<?php
session_start();
$config = file_exists('/home/sjubedu/config.php') ? '/home/sjubedu/config.php' : __DIR__ . '/../../config.php';
require_once $config;

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

if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

// Authentication Check
if (!isset($_SESSION['is_admin']) || !in_array('view_logs', $_SESSION['admin_perms'] ?? [])) {

    header("Location: dashboard.php");
    exit;
}

$log_file = __DIR__ . '/purge_history.log';

// Handle Clear Logs
if (isset($_POST['clear_logs'])) {
    file_put_contents($log_file, "");
    header("Location: view_logs.php");
    exit;
}

$filter = isset($_GET['filter']) ? $_GET['filter'] : 'ALL';
$log_content = file_exists($log_file) ? file_get_contents($log_file) : "No logs found.";

if ($filter !== 'ALL' && file_exists($log_file)) {
    $lines = explode("\n", $log_content);
    $filtered_lines = [];
    foreach ($lines as $line) {
        if (stripos($line, $filter) !== false) {
            $filtered_lines[] = $line;
        }
    }
    $logs = empty($filtered_lines) ? "No events found matching '$filter'." : implode("\n", $filtered_lines);
} else {
    $logs = $log_content;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include $_SERVER['DOCUMENT_ROOT'] . '/gtm.php'; ?>
    <meta charset="UTF-8">
    <title>System Logs</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-light p-4">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h3><i class="fa fa-list-alt me-2"></i> System Logs</h3>
            <div>
                <a href="dashboard.php" class="btn btn-secondary me-2"><i class="fa fa-arrow-left me-2"></i> Back</a>
                <a href="?logout=1" class="btn btn-danger">Logout</a>
            </div>
        </div>

        <div class="mb-3">
            <a href="?filter=ALL" class="btn btn-sm <?php echo $filter === 'ALL' ? 'btn-primary' : 'btn-outline-primary'; ?>">All Events</a>
            <a href="?filter=PURGE" class="btn btn-sm <?php echo $filter === 'PURGE' ? 'btn-primary' : 'btn-outline-primary'; ?>">Purge Events</a>
            <a href="?filter=ERROR" class="btn btn-sm <?php echo $filter === 'ERROR' ? 'btn-primary' : 'btn-outline-primary'; ?>">Errors</a>
        </div>
        
        <div class="card shadow-sm">
            <div class="card-body bg-dark text-white font-monospace p-3" style="height: 70vh; overflow-y: auto; white-space: pre-wrap;"><?php echo htmlspecialchars($logs); ?></div>
            <div class="card-footer bg-white d-flex justify-content-end">
                <form method="POST" onsubmit="return confirm('Are you sure you want to clear the entire log history?');">
                    <button type="submit" name="clear_logs" class="btn btn-danger"><i class="fa fa-trash me-2"></i> Clear Logs</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>