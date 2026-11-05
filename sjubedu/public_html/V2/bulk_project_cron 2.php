<?php
// bulk_project_cron.php - Background Sync Script for Projects
set_time_limit(0);

$config = file_exists('/home/sjubedu/config.php') ? '/home/sjubedu/config.php' : __DIR__ . '/../../config.php';
require_once $config;

try {
    $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4", DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Self-healing: Ensure table exists
    $pdo->exec("CREATE TABLE IF NOT EXISTS `project_cache` (
        `department_id` VARCHAR(50) PRIMARY KEY,
        `department_name` VARCHAR(255),
        `content` LONGTEXT,
        `created_at` DATETIME
    ) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;");
} catch (PDOException $e) { die("DB Error: " . $e->getMessage()); }

// The $departments array is now included from config.php
echo "<pre>Starting Bulk Project Sync...\n";

foreach ($departments as $id => $name) {
    echo "Syncing $name ($id)... ";
    
    $url = "https://sjuv4.linways.com/api/v1/exat2/forms/reports/" . ($FORM_IDS['project'] ?? '') . "/ALL?departmentId=" . urlencode($id);
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "Accept: application/json",
        "Authorization: " . $API_TOKEN
    ]);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    
    $response = curl_exec($ch);
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($http_code == 200 && $response) {
        $json = json_decode($response, true);
        if (isset($json['data'])) {
            $stmt = $pdo->prepare("REPLACE INTO project_cache (department_id, department_name, content, created_at) VALUES (?, ?, ?, NOW())");
            $stmt->execute([$id, $name, $response]);
            echo "OK\n";
        } else {
            echo "Invalid Data\n";
        }
    } else {
        echo "Failed (HTTP $http_code)\n";
    }
    
    // Sleep to prevent rate limiting
    usleep(500000); // 0.5 seconds
}

echo "Done.</pre>";
?>