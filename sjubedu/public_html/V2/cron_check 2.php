<?php
/**
 * cron_check.php - Health Monitor with Status Icons
 */
date_default_timezone_set('Asia/Kolkata');

$marker_file = '/home/sjubedu/public_html/Test/last_success.txt';
$admin_email = "jogith@example.com"; 

if (file_exists($marker_file)) {
    $last_sync_time = strtotime(file_get_contents($marker_file));
    $seconds_since_last_sync = time() - $last_sync_time;
    
    // 26 hour threshold
    if ($seconds_since_last_sync > 93600) {
        // ❌ FAILURE STATUS
        $subject = "❌ ALERT: SJU Faculty Sync Failure";
        $message = "🔴 CRITICAL: The faculty sync hasn't finished in over 26 hours.\n";
        $message .= "🕒 Last successful completion: " . date('Y-m-d H:i:s', $last_sync_time) . "\n";
        $message .= "📂 Check logs: /home/sjubedu/public_html/Test/cron_log.log";
        
        mail($admin_email, $subject, $message);
        echo "❌ Health Check: FAIL. Alert sent.\n";
    } else {
        // ✅ SUCCESS STATUS
        echo "✅ Health Check: PASS. System is healthy.\n";
        echo "🕒 Last Sync: " . date('Y-m-d H:i:s', $last_sync_time) . "\n";
    }
} else {
    // ⚠️ WARNING STATUS
    $subject = "⚠️ ALERT: Sync Marker Missing";
    mail($admin_email, $subject, "The file last_success.txt was not found!");
    echo "⚠️ Health Check: ERROR. Marker file missing.\n";
}