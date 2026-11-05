<?php
// patent.php - Template for Patents Display
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

// --- 2. GLOBAL TRACKER INJECTION ---
// This is your Global Security & Tracker Bridge. 
// It must stay here to catch your iPhone's IPv6 address.
if (file_exists('/home/sjubedu/public_html/global_tracker.php')) {
    require_once('/home/sjubedu/public_html/global_tracker.php');
}

if (isset($_GET['dept'])) {
    $DEPARTMENT_ID = $_GET['dept'];
}
if (!isset($DEPARTMENT_ID)) {
    $DEPARTMENT_ID = "72"; // Default to Chemistry for example
}
$pdo = null;
try {
    $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4", DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    error_log("Patents Template DB Error: " . $e->getMessage());
}

$cache_time = 21600; // 6 Hours
$is_cache_valid = false;
$report = [];
$db_row = null;

if ($pdo) {
    try {
        $stmt = $pdo->prepare("SELECT content, created_at FROM patent_cache WHERE department_id = ?");
        $stmt->execute([$DEPARTMENT_ID]);
        $db_row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($db_row && (time() - strtotime($db_row['created_at']) < $cache_time)) {
            $report = json_decode($db_row['content'], true);
            if ($report) $is_cache_valid = true;
        }
    } catch (Exception $e) {
        // Self-healing: create table if it doesn't exist
        if ($pdo && strpos($e->getMessage(), "Base table or view not found") !== false) {
            $pdo->exec("CREATE TABLE IF NOT EXISTS `patent_cache` (
                `department_id` varchar(50) NOT NULL,
                `department_name` varchar(255) DEFAULT NULL,
                `content` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
                `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
                PRIMARY KEY (`department_id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");
        }
    }
}

if (!$is_cache_valid) {
    try {
        $form_id = $FORM_IDS['patent'] ?? 'YOUR_PATENT_FORM_ID';
        if (strpos($form_id, 'YOUR_') !== false) {
            die("<div class='alert alert-danger m-4'>Configuration Error: The Patent Form ID has not been set in <code>config.php</code>. Please update the placeholder value.</div>");
        }

        $url = "https://sjuv4.linways.com/api/v1/exat2/forms/reports/" . $form_id . "/ALL?departmentId=" . urlencode($DEPARTMENT_ID);
        
        $options = [
            "http" => [
                "method" => "GET",
                "header" => "Accept: application/json\r\n" . "Authorization: " . $API_TOKEN . "\r\n",
                "timeout" => 10
            ],
            "ssl" => ["verify_peer" => false, "verify_peer_name" => false]
        ];
        
        $context = stream_context_create($options);
        $response = @file_get_contents($url, false, $context);

        if ($response === FALSE) throw new Exception("API request failed or timed out.");

        $report = json_decode($response, true);
        
        if ($pdo && isset($report['data'])) {
            $stmt = $pdo->prepare("REPLACE INTO patent_cache (department_id, department_name, content, created_at) VALUES (?, ?, ?, NOW())");
            $stmt->execute([$DEPARTMENT_ID, $DEPARTMENT_NAME ?? 'Unknown', $response]);
        }
        
    } catch (Exception $e) {
        error_log("Patents API Error: " . $e->getMessage());
        if ($db_row) {
            $report = json_decode($db_row['content'], true);
        } else {
            die("<div style='padding:20px; color:red; font-family:sans-serif;'>
                    <b>Service Note:</b> Patent data is currently being updated. Please check back in a few minutes.
                 </div>");
        }
    }
}

if (!isset($report['data'])) die("Error: Invalid data format received.");

$headers = ["Name of Faculty", "Title", "Patent Type", "Patent Application Number", "Year", "Innovation", "Status", "Affiliation at the time of grant of patent", "DOI link to Patent repository"];
$patents = $report['data'];

function formatCell($value) {
    if (is_array($value)) {
        if (empty($value)) return '<span class="text-muted" style="font-size: 0.8em;">No File</span>';
        $links = [];
        foreach ($value as $file) {
            $fileUrl = $file['url'] ?? '#';
            $fileName = $file['name'] ?? 'View';
            $links[] = '<a href="'.$fileUrl.'" target="_blank" class="btn btn-sm btn-outline-primary p-1 mb-1" style="font-size:10px; display:block;">'.$fileName.'</a>';
        }
        return implode('', $links);
    }
    if (filter_var($value, FILTER_VALIDATE_URL)) return '<a href="'.htmlspecialchars($value).'" target="_blank">Link</a>';
    return !empty($value) ? htmlspecialchars($value) : '<span class="text-secondary">—</span>';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0"><title>SJU Patents</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>body { font-family: 'Segoe UI', sans-serif; background-color: #f4f7f6; } .table-primary th { background-color: #1a237e !important; color: white; position: sticky; top: 0; } .table-container { max-height: 80vh; overflow-y: auto; border: 1px solid #dee2e6; background: white; }</style>
</head>
<body>
<div class="container-fluid py-4"><div class="card shadow-sm border-0"><div class="card-header bg-white"><div><h4 class="text-primary mb-0">Patents - <?php echo isset($DEPARTMENT_NAME) ? htmlspecialchars($DEPARTMENT_NAME) : "Department ID: " . htmlspecialchars($DEPARTMENT_ID); ?></h4><small class="text-muted">Total Records: <?php echo htmlspecialchars($report['totalRecords'] ?? count($patents)); ?></small></div></div><div class="card-body p-0"><div class="table-container"><table class="table table-sm table-hover mb-0"><thead class="table-primary"><tr><?php foreach ($headers as $header): ?><th class="p-3"><?php echo htmlspecialchars($header); ?></th><?php endforeach; ?></tr></thead><tbody><?php foreach ($patents as $row): ?><tr><?php foreach ($headers as $header): ?><td class="p-3"><?php echo formatCell($row[$header] ?? ''); ?></td><?php endforeach; ?></tr><?php endforeach; ?></tbody></table></div></div></div></div>
</body>
</html>