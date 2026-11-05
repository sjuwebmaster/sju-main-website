<?php
// Include configuration for API Token
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
//if (file_exists('/home/sjubedu/public_html/global_tracker.php')) {
  //  require_once('/home/sjubedu/public_html/global_tracker.php');
//}
// This is your Global Security & Tracker Bridge. 
// It must stay here to catch your iPhone's IPv6 address.
if (file_exists('/home/sjubedu/public_html/global_tracker.php')) {
    require_once('/home/sjubedu/public_html/global_tracker.php');
}

// Determine Department ID (Default to 59 if not set)
if (!isset($DEPARTMENT_ID)) {
    $DEPARTMENT_ID = "59";
}

// --- DATABASE CONNECTION ---
$pdo = null;
try {
    $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4", DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // Continue without DB if connection fails (will rely on direct API)
}

// --- CACHE LOGIC ---
$cache_time = 21600; // 6 Hours
$is_cache_valid = false;
$report = [];
$db_row = null;

if ($pdo) {
    try {
        $stmt = $pdo->prepare("SELECT content, created_at FROM phd_cache WHERE department_id = ?");
        $stmt->execute([$DEPARTMENT_ID]);
        $db_row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($db_row && (time() - strtotime($db_row['created_at']) < $cache_time)) {
            $report = json_decode($db_row['content'], true);
            if ($report) $is_cache_valid = true;
        }
    }
    catch (Exception $e) {
        // Self-healing: create table if it doesn't exist
        if ($pdo && strpos($e->getMessage(), "Base table or view not found") !== false) {
            $pdo->exec("CREATE TABLE IF NOT EXISTS `phd_cache` (
                `department_id` VARCHAR(50) PRIMARY KEY, `department_name` VARCHAR(255), `content` LONGTEXT, `created_at` DATETIME
            ) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;");
        }
    }
}

if (!$is_cache_valid) {
    // Fetch from API
    $form_id = $FORM_IDS['phd'] ?? '';
    $url = "https://sjuv4.linways.com/api/v1/exat2/forms/reports/" . $form_id . "/ALL?departmentId=" . urlencode($DEPARTMENT_ID);
    $options = [
        "http" => [
            "method" => "GET",
            "header" => "Accept: application/json\r\n" . "Authorization: " . $API_TOKEN . "\r\n"
        ],
        "ssl" => ["verify_peer" => false, "verify_peer_name" => false]
    ];
    $context = stream_context_create($options);
    $response = @file_get_contents($url, false, $context);

    if ($response !== FALSE) {
        $report = json_decode($response, true);
        // Save to DB
        if ($pdo && isset($report['data'])) {
            $stmt = $pdo->prepare("REPLACE INTO phd_cache (department_id, department_name, content, created_at) VALUES (?, ?, ?, NOW())");
            $stmt->execute([$DEPARTMENT_ID, $DEPARTMENT_NAME ?? 'Unknown', $response]);
        }
    } elseif ($db_row) {
        // Fail-safe: Use expired cache if API fails
        $report = json_decode($db_row['content'], true);
    } else {
        die("Error: Unable to fetch data from the research API.");
    }
}

// Verify data structure
if (!isset($report['headers']) || !isset($report['data'])) {
    die("Error: Invalid data format received.");
}

$headers = [
    "Name of Research Scholar",
    "Date of Enrollment for Coursework at SJU",
    "Area of Research",
    "Title of the Thesis (Provisional)",
    "Link to the Profile of the Supervisor",
    "Status of the Thesis"
];
$scholars = $report['data'];

/**
 * Helper to handle the 'Upload' fields and empty values
 */
function formatCell($value) {
    if (is_array($value)) {
        if (empty($value)) return '<span class="text-muted" style="font-size: 0.8em;">No File</span>';
        
        $links = [];
        foreach ($value as $file) {
            // Check if URL exists to avoid broken links
            $fileUrl = $file['url'] ?? '#';
            $fileName = $file['name'] ?? 'View';
            $links[] = '<a href="'.$fileUrl.'" target="_blank" class="btn btn-sm btn-outline-primary p-1 mb-1" style="font-size:10px; display:block;">'.$fileName.'</a>';
        }
        return implode('', $links);
    }
    
    // Check if the string is a URL (for Supervisor Profile links)
    if (filter_var($value, FILTER_VALIDATE_URL)) {
        return '<a href="'.htmlspecialchars($value).'" target="_blank">View Profile</a>';
    }

    return !empty($value) ? htmlspecialchars($value) : '<span class="text-secondary">—</span>';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php include $_SERVER['DOCUMENT_ROOT'] . '/gtm.php'; ?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SJU Research Report</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f4f7f6; }
        .table-primary th { background-color: #1a237e !important; color: white; position: sticky; top: 0; z-index: 10; font-size: 11px; white-space: nowrap; }
        .table-container { max-height: 80vh; overflow-y: auto; border: 1px solid #dee2e6; border-radius: 8px; background: white; }
        table td { font-size: 12px; min-width: 150px; }
        table td:first-child { font-weight: bold; color: #1a237e; position: sticky; left: 0; background: #fdfdfd; z-index: 5; border-right: 2px solid #eee; }
        @media print { .table-container { max-height: none; overflow: visible; } table { width: 100% !important; font-size: 8pt; } th { background-color: #1a237e !important; -webkit-print-color-adjust: exact; } }
    </style>
</head>
<body>
<div class="container-fluid py-4">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-white d-flex justify-content-between align-items-center">
            <div><h4 class="text-primary mb-0">PhD Research Scholars - <?php echo isset($DEPARTMENT_NAME) ? htmlspecialchars($DEPARTMENT_NAME) : "Department ID: " . htmlspecialchars($DEPARTMENT_ID); ?></h4><small class="text-muted">Total Records: <?php echo htmlspecialchars($report['totalRecords']); ?></small></div>
        </div>
        <div class="card-body p-0"><div class="table-container"><table class="table table-sm table-hover mb-0"><thead class="table-primary"><tr><?php foreach ($headers as $header): ?><th class="p-3"><?php echo htmlspecialchars($header); ?></th><?php endforeach; ?></tr></thead><tbody><?php foreach ($scholars as $row): ?><tr><?php foreach ($headers as $header): ?><td class="p-3"><?php echo formatCell($row[$header] ?? ''); ?></td><?php endforeach; ?></tr><?php endforeach; ?></tbody></table></div></div>
    </div>
</div>
</body>
</html>