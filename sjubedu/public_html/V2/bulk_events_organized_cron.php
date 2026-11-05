<?php
// bulk_events_organized_cron.php - Background Sync Script for Events Organized
set_time_limit(0);

$config = file_exists('/home/sjubedu/config.php') ? '/home/sjubedu/config.php' : __DIR__ . '/../../config.php';
require_once $config;

// Auth Check (Allow CLI)
if (php_sapi_name() !== 'cli') {
    session_start();
    if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== true) {
        if (isset($_POST['login_pass']) && $_POST['login_pass'] === $ADMIN_PASSWORD) {
            $_SESSION['is_admin'] = true;
            header("Location: " . $_SERVER['PHP_SELF']);
            exit;
        }
        echo '<!DOCTYPE html><html><head><title>Login</title><link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"></head><body class="bg-light d-flex align-items-center justify-content-center vh-100"><div class="card shadow p-4"><h3 class="mb-3">Login Required</h3><form method="POST"><input type="password" name="login_pass" class="form-control mb-3" placeholder="Password" required><button class="btn btn-primary w-100">Login</button></form></div></body></html>';
        exit;
    }
}

// DB Connection
try {
    $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4", DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Ensure table exists
    $pdo->exec("CREATE TABLE IF NOT EXISTS `events_organized_cache` (
        `department_id` varchar(50) NOT NULL,
        `department_name` varchar(255) DEFAULT NULL,
        `content` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
        `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY (`department_id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");
} catch (PDOException $e) { die("DB Error: " . $e->getMessage()); }

echo "<pre>Starting Bulk Events Organized Sync...\n";

foreach ($departments as $id => $name) {
    echo "Syncing $name ($id)... ";
    
    $form_id = $FORM_IDS['events_organized'] ?? '';

    if (empty($form_id)) {
        echo "SKIPPED: Events Organized Form ID is not configured.\n";
        continue;
    }

    $url = "https://sjuv4.linways.com/api/v1/exat2/forms/reports/" . $form_id . "/ALL?departmentId=" . urlencode($id);
    
    $ch = curl_init();
    curl_setopt_array($ch, [
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HTTPHEADER => ["Accept: application/json", "Authorization: " . $API_TOKEN],
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_TIMEOUT => 30
    ]);
    
    $response = curl_exec($ch);
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($http_code == 200 && $response) {
        $json = json_decode($response, true);
        if (isset($json['data'])) {
            $stmt = $pdo->prepare("REPLACE INTO events_organized_cache (department_id, department_name, content, created_at) VALUES (?, ?, ?, NOW())");
            $stmt->execute([$id, $name, $response]);
            echo "OK\n";
        } else {
            echo "Invalid Data\n";
        }
    } else {
        echo "Failed (HTTP $http_code)\n";
    }
    
    usleep(500000); // 0.5 seconds pause
}

echo "Done.</pre>";
?>
