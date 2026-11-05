<?php
// publication_admin.php - Admin Dashboard for Publications Module
session_start();

// Robust Config Path
$config_paths = [
    '/home/sjubedu/config.php',
    __DIR__ . '/../config.php',
    __DIR__ . '/../../config.php',
    __DIR__ . '/../../../config.php'
];
foreach ($config_paths as $path) {
    if (file_exists($path)) {
        require_once $path;
        break;
    }
}

// Auth Check
if (!isset($_SESSION['is_admin']) || !in_array('view_logs', $_SESSION['admin_perms'] ?? [])) {

    header("Location: dashboard.php");
    exit;
}

// DB Connection
try {
    $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4", DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Ensure table exists
    $pdo->exec("CREATE TABLE IF NOT EXISTS `publication_cache` (
        `department_id` VARCHAR(50) PRIMARY KEY,
        `department_name` VARCHAR(255),
        `content` LONGTEXT,
        `created_at` DATETIME
    ) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;");
    
} catch (PDOException $e) {
    die("Database Connection Failed: " . $e->getMessage());
}

// Handle Sync Action
$message = "";
if (isset($_POST['sync_dept'])) {
    $dept_id = $_POST['dept_id'];
    $dept_name = $_POST['dept_name'];
    
    // API Fetch Logic
    $form_id = $FORM_IDS['publication'] ?? '';
    if ($form_id) {
        $url = "https://sjuv4.linways.com/api/v1/exat2/forms/reports/" . $form_id . "/ALL?departmentId=" . urlencode($dept_id);
        $options = [
            "http" => [
                "method" => "GET",
                "header" => "Accept: application/json\r\n" . "Authorization: " . $API_TOKEN . "\r\n",
                "timeout" => 30
            ],
            "ssl" => ["verify_peer" => false, "verify_peer_name" => false]
        ];
        $context = stream_context_create($options);
        $response = @file_get_contents($url, false, $context);
        
        if ($response) {
            $data = json_decode($response, true);
            if (isset($data['data'])) {
                // Update Cache
                $stmt = $pdo->prepare("REPLACE INTO publication_cache (department_id, department_name, content, created_at) VALUES (?, ?, ?, NOW())");
                $stmt->execute([$dept_id, $dept_name, $response]);
                $message = "<div class='alert alert-success alert-dismissible fade show'>Successfully synced Publication data for <strong>$dept_name</strong>.<button type='button' class='btn-close' data-bs-dismiss='alert'></button></div>";
            } else {
                $message = "<div class='alert alert-warning alert-dismissible fade show'>API returned invalid data for $dept_name.<button type='button' class='btn-close' data-bs-dismiss='alert'></button></div>";
            }
        } else {
            $message = "<div class='alert alert-danger alert-dismissible fade show'>Failed to connect to API for $dept_name.<button type='button' class='btn-close' data-bs-dismiss='alert'></button></div>";
        }
    } else {
        $message = "<div class='alert alert-danger'>Form ID not configured in config.php.</div>";
    }
}

// Fetch Cache Status
$cache_data = [];
try {
    $stmt = $pdo->query("SELECT department_id, department_name, created_at, LENGTH(content) as size, content FROM publication_cache ORDER BY department_name");
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $json = json_decode($row['content'], true);
        $count = isset($json['data']) ? count($json['data']) : 0;
        $cache_data[$row['department_id']] = [
            'name' => $row['department_name'],
            'synced' => $row['created_at'],
            'count' => $count
        ];
    }
} catch (Exception $e) {
    // Table might not exist yet or empty
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include $_SERVER['DOCUMENT_ROOT'] . '/gtm.php'; ?>
    <meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0"><title>Publication Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-light p-4">
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><i class="fa fa-book text-primary"></i> Publication Administration</h2>
        <div>
            <a href="bulk_publication_generator.php" target="_blank" class="btn btn-outline-dark me-2"><i class="fa fa-file-code"></i> Generate Pages</a>
            <a href="dashboard.php" class="btn btn-secondary">Back to Dashboard</a>
        </div>
    </div>

    <?php echo $message; ?>

    <div class="card shadow-sm">
        <div class="card-header bg-white fw-bold">Department Sync Status</div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0 align-middle">
                    <thead class="table-light"><tr><th>Department</th><th>Cached Records</th><th>Last Synced</th><th>Actions</th></tr></thead>
                    <tbody>
                        <?php foreach ($departments as $id => $name): 
                            $cached = $cache_data[$id] ?? null;
                        ?>
                        <tr>
                            <td><strong><?php echo htmlspecialchars($name); ?></strong><small class="text-muted d-block">ID: <?php echo $id; ?></small></td>
                            <td>
                                <?php if ($cached): ?><span class="badge bg-success"><?php echo $cached['count']; ?> Publications</span>
                                <?php else: ?><span class="badge bg-secondary">Not Synced</span><?php endif; ?>
                            </td>
                            <td><?php echo $cached ? date('d M Y, h:i A', strtotime($cached['synced'])) : '-'; ?></td>
                            <td>
                                <form method="POST" class="d-inline"><input type="hidden" name="dept_id" value="<?php echo $id; ?>"><input type="hidden" name="dept_name" value="<?php echo htmlspecialchars($name); ?>"><button type="submit" name="sync_dept" class="btn btn-sm btn-primary"><i class="fa fa-sync"></i> Sync</button></form>
                                <a href="publication_live.php?dept=<?php echo $id; ?>" target="_blank" class="btn btn-sm btn-outline-danger"><i class="fa fa-broadcast-tower"></i> Live</a>
                                <?php if ($cached): ?><a href="publication/publication_<?php echo $id; ?>.php" target="_blank" class="btn btn-sm btn-outline-success"><i class="fa fa-eye"></i> View Cached</a><?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>