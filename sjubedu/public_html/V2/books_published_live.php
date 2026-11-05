<?php
// books_published_live.php - Template for Live Books Published Display (No Cache)

// Securely include the configuration file
$config = file_exists('/home/sjubedu/config.php') ? '/home/sjubedu/config.php' : __DIR__ . '/../../config.php';
if (file_exists($config)) {
    require_once $config;
} else {
    die("Security Error: Core configuration bridge failed.");
}

// --- 2. GLOBAL TRACKER INJECTION ---
// This is your Global Security & Tracker Bridge. 
// It must stay here to catch your iPhone's IPv6 address.
if (file_exists('/home/sjubedu/public_html/global_tracker.php')) {
    require_once('/home/sjubedu/public_html/global_tracker.php');
}

// Determine Department ID, with a fallback for direct access
if (!isset($DEPARTMENT_ID)) {
    $DEPARTMENT_ID = "59"; // Default to Commerce for example
}

// --- LIVE API FETCH ---
$report = [];

$form_id = $FORM_IDS['books_published'] ?? ''; 
$url = "https://sjuv4.linways.com/api/v1/exat2/forms/reports/" . $form_id . "/ALL?departmentId=" . urlencode($DEPARTMENT_ID);

$options = [
    "http" => [
        "method" => "GET",
        "header" => "Accept: application/json\r\n" . "Authorization: " . $API_TOKEN . "\r\n",
        "timeout" => 15 // Increased timeout for potentially slow API responses
    ],
    "ssl" => ["verify_peer" => false, "verify_peer_name" => false]
];

$context = stream_context_create($options);
$response = @file_get_contents($url, false, $context);

if ($response !== FALSE) {
    $report = json_decode($response, true);
} else {
    die("<div class='alert alert-danger m-4'>Error: Unable to fetch live data from the Books Published API. The service may be temporarily unavailable.</div>");
}

if (!isset($report['data'])) die("Error: Invalid data format received from the API.");

$headers = ["Name of Faculty", "Title", "Type", "No of Authors or Editors", "Your authorial position", "Year", "ISBN", "Publisher Details", "DOI/URL", "Upload title page and publisher information page"];
$books_published = $report['data'];

function formatCell($value) {
    if (is_array($value)) {
        if (empty($value)) return '<span class="text-muted" style="font-size: 0.8em;">No File</span>';
        $links = [];
        foreach ($value as $file) {
            $fileUrl = $file['url'] ?? '#';
            $fileName = $file['name'] ?? 'View';
            $links[] = '<a href="'.htmlspecialchars($fileUrl).'" target="_blank" class="btn btn-sm btn-outline-primary p-1 mb-1" style="font-size:10px; display:block;">'.htmlspecialchars($fileName).'</a>';
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
    <meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0"><title>SJU Live Books Published Report</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { font-family: 'Segoe UI', sans-serif; background-color: #f4f7f6; }
        .table-primary th { background-color: #dc3545 !important; color: white; position: sticky; top: 0; }
        .table-container { max-height: 80vh; overflow-y: auto; border: 1px solid #dee2e6; background: white; }
    </style>
</head>
<body>
<div class="container-fluid py-4"><div class="card shadow-sm border-0"><div class="card-header bg-white d-flex justify-content-between align-items-center"><div><h4 class="text-danger mb-0"><i class="fas fa-broadcast-tower me-2"></i> LIVE: Books Published - <?php echo isset($DEPARTMENT_NAME) ? htmlspecialchars($DEPARTMENT_NAME) : "Dept ID: " . htmlspecialchars($DEPARTMENT_ID); ?></h4><small class="text-muted">Total Records: <?php echo htmlspecialchars($report['totalRecords'] ?? count($books_published)); ?></small></div></div><div class="card-body p-0"><div class="table-container"><table class="table table-sm table-hover mb-0"><thead class="table-primary"><tr><?php foreach ($headers as $header): ?><th class="p-3"><?php echo htmlspecialchars($header); ?></th><?php endforeach; ?></tr></thead><tbody><?php foreach ($books_published as $row): ?><tr><?php foreach ($headers as $header): ?><td class="p-3"><?php echo formatCell($row[$header] ?? ''); ?></td><?php endforeach; ?></tr><?php endforeach; ?></tbody></table></div></div></div></div>
</body>
</html>