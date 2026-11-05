<?php
// test_tracker.php - TRACKING DIAGNOSTIC
header('Content-Type: text/plain');
$config = file_exists('/home/sjubedu/config.php') ? '/home/sjubedu/config.php' : __DIR__ . '/../../config.php';
require_once $config;

echo "--- SJU Tracker Diagnostic ---\n";

// 1. Check PDO
if (!isset($pdo)) {
    die("ERROR: \$pdo variable is not defined. Check config.php placement.");
}
echo "SUCCESS: Database variable found.\n";

// 2. Check Table Permissions
try {
    $ip = "1.1.1.1"; // Test IP
    $hash = md5($ip . "TestBot");
    $stmt = $pdo->prepare("INSERT INTO active_visitors (visitor_hash, load_type, ip_address, device_type, hit_count) 
                           VALUES (?, 'Standard_Page', ?, 'Tester', 1) 
                           ON DUPLICATE KEY UPDATE hit_count = hit_count + 1");
    $stmt->execute([$hash, $ip]);
    echo "SUCCESS: Insert/Update command executed on active_visitors.\n";
} catch (Exception $e) {
    echo "DATABASE ERROR: " . $e->getMessage() . "\n";
}

// 3. Check Table Content
$count = $pdo->query("SELECT COUNT(*) FROM active_visitors")->fetchColumn();
echo "TOTAL TRACKED VISITORS: " . $count . "\n";

echo "YOUR CURRENT IP: " . $_SERVER['REMOTE_ADDR'] . "\n";
echo "--- Diagnostic End ---";