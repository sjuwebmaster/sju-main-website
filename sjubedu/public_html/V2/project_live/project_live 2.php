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
if (file_exists('/home/sjubedu/public_html/global_tracker.php')) {
    require_once('/home/sjubedu/public_html/global_tracker.php');
}

// Determine Department ID (Default to 59 if not set)
if (!isset($DEPARTMENT_ID)) {
    $DEPARTMENT_ID = "59";
}

// --- LIVE API FETCH ---
$report = [];

// Fetch from API (Project Form ID: tYuM47LhCvJvkWnWo)
$form_id = $FORM_IDS['project'] ?? '';
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
} else {
    die("Error: Unable to fetch live data from the project API. The service may be temporarily unavailable.");
}

// Verify data structure
if (!isset($report['data'])) {
    die("Error: Invalid data format received from the API.");
}

// Define Headers for Projects
$headers = [
    "Principal Investigator",
    "Title of Project",
    "Funding Agency",
    "Amount",
    "Duration",
    "Current Status",
    "Type of Project"
];
$projects = $report['data'];

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
    
    if (filter_var($value, FILTER_VALIDATE_URL)) {
        return '<a href="'.htmlspecialchars($value).'" target="_blank">Link</a>';
    }

    return !empty($value) ? htmlspecialchars($value) : '<span class="text-secondary">—</span>';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SJU Live Projects Report</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f4f7f6; }
        .table-primary th { background-color: #dc3545 !important; color: white; position: sticky; top: 0; z-index: 10; font-size: 11px; white-space: nowrap; }
        .table-container { max-height: 80vh; overflow-y: auto; border: 1px solid #dee2e6; border-radius: 8px; background: white; }
        table td { font-size: 12px; min-width: 150px; }
        table td:first-child { font-weight: bold; color: #1a237e; position: sticky; left: 0; background: #fdfdfd; z-index: 5; border-right: 2px solid #eee; }
    </style>
</head>
<body>
<div class="container-fluid py-4">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-white d-flex justify-content-between align-items-center">
            <div><h4 class="text-danger mb-0"><i class="fas fa-broadcast-tower me-2"></i> LIVE: Research Projects - <?php echo isset($DEPARTMENT_NAME) ? htmlspecialchars($DEPARTMENT_NAME) : "Dept ID: " . htmlspecialchars($DEPARTMENT_ID); ?></h4><small class="text-muted">Total Records: <?php echo htmlspecialchars($report['totalRecords'] ?? count($projects)); ?></small></div>
        </div>
        <div class="card-body p-0"><div class="table-container"><table class="table table-sm table-hover mb-0"><thead class="table-primary"><tr><?php foreach ($headers as $header): ?><th class="p-3"><?php echo htmlspecialchars($header); ?></th><?php endforeach; ?></tr></thead><tbody><?php foreach ($projects as $row): ?><tr><?php foreach ($headers as $header): ?><td class="p-3"><?php echo formatCell($row[$header] ?? ''); ?></td><?php endforeach; ?></tr><?php endforeach; ?></tbody></table></div></div>
    </div>
</div>
</body>
</html>