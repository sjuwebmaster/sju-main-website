<?php
//rotate log for csp alerts
// 1. Set the directory and file names
$dir = __DIR__;
$current_log = $dir . '/csp-alerts.log';
$archive_log = $dir . '/csp-alerts-' . date('Y-m') . '.log';

// 2. If the log exists, rename it to include the month/year
if (file_exists($current_log)) {
    rename($current_log, $archive_log);
    
    // 3. Create a fresh, empty log file for the new month
    touch($current_log);
    chmod($current_log, 0644);
    
    echo "Log rotated successfully. Current log is now: " . basename($archive_log);
} else {
    echo "No log file found to rotate.";
}
?>