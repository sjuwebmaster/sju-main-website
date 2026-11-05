<?php
// /home/sjubedu/public_html/emergency_reset.php
session_start();

// 1. HARD SECURITY KEY
$secret_key = "SJU_RESET_2026"; 
if (!isset($_GET['key']) || $_GET['key'] !== $secret_key) {
    header('HTTP/1.0 403 Forbidden');
    die("Unauthorized Access.");
}

$config = file_exists('/home/sjubedu/config.php') ? '/home/sjubedu/config.php' : __DIR__ . '/../config.php';
require_once $config;

echo "<html><body style='font-family:sans-serif; padding:20px; background:#1a1a1a; color:#eee;'>";
echo "<h2 style='color:#ff4d4d;'>☢️ FULL SYSTEM PURGE INITIATED</h2>";

try {
    // --- DATABASE 1: TRAFFIC & SECURITY ---
    $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4", DB_USER, DB_PASS);
    
    $traffic_tables = ['active_visitors', 'banned_ips', 'ip_nicknames'];
    echo "<b>Clearing Traffic & Security Tables:</b><ul>";
    foreach ($traffic_tables as $table) {
        $pdo->exec("TRUNCATE TABLE $table");
        echo "<li>$table ... <span style='color:#00ff00;'>WIPED</span></li>";
    }
    echo "</ul>";

    // --- DATABASE 2: FACULTY DATA CACHE ---
    // Using the credentials from your faculty update logic
    $pdo_cache = new PDO("mysql:host=localhost;dbname=sjubedu_faculty_data;charset=utf8mb4", "sjubedu_developer", "SJU2022_sju");
    
    $cache_tables = ['api_cache', 'phd_cache', 'publication_cache', 'project_cache', 'awards_cache'];
    echo "<b>Clearing Faculty Data Cache:</b><ul>";
    foreach ($cache_tables as $table) {
        $pdo_cache->exec("TRUNCATE TABLE $table");
        echo "<li>$table ... <span style='color:#00ff00;'>WIPED</span></li>";
    }
    echo "</ul>";

    // --- LOGS & OPTIMIZATION ---
    if (file_exists('/home/sjubedu/purge_history.log')) {
        file_put_contents('/home/sjubedu/purge_history.log', "[" . date('Y-m-d H:i:s') . "] EMERGENCY FULL WIPE EXECUTED\n", FILE_APPEND);
        echo "<li>System Log ... <span style='color:#00ff00;'>UPDATED</span></li>";
    }

    echo "<hr><h3 style='color:#00ff00;'>✅ TOTAL RESET COMPLETE</h3>";
    echo "<p>Every table is now empty. The portal will now fetch fresh data from the source for the next 10,000 students.</p>";
    echo "<a href='Test/Health_check.php' style='display:inline-block; padding:10px 20px; background:#0d6efd; color:white; text-decoration:none; border-radius:5px;'>Back to Health Monitor</a>";

} catch (Exception $e) {
    echo "<h3 style='color:#ff4d4d;'>❌ CRITICAL FAILURE: " . $e->getMessage() . "</h3>";
}
echo "</body></html>";