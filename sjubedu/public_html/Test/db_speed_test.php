<?php
// db_speed_test.php
$start_time = microtime(true);

// 1. Measure Config Bridge Speed
$config = file_exists('/home/sjubedu/config.php') ? '/home/sjubedu/config.php' : __DIR__ . '/../../config.php';
require_once $config;
$config_time = microtime(true);

// 2. Measure DB Connection Speed
try {
    $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (Exception $e) { die("Connection failed."); }
$conn_time = microtime(true);

// 3. Measure Data Retrieval (Fetch 1 Profile)
$stmt = $pdo->query("SELECT id FROM api_cache LIMIT 1");
$stmt->fetch();
$fetch_time = microtime(true);

// Calculations
$total_time = round(($fetch_time - $start_time) * 1000, 2); // Convert to milliseconds
$db_only = round(($fetch_time - $conn_time) * 1000, 2);

echo "<h2>Server Performance Benchmark</h2>";
echo "Total Execution Time: <b>{$total_time} ms</b><br>";
echo "Time to fetch from DB: <b>{$db_only} ms</b><br>";

if ($total_time < 50) {
    echo "<span style='color:green;'>🚀 Excellent: Your server is highly responsive.</span>";
} elseif ($total_time < 200) {
    echo "<span style='color:orange;'>⚖️ Good: Standard performance for shared hosting.</span>";
} else {
    echo "<span style='color:red;'>⚠️ Slow: You may face lag with high traffic.</span>";
}
?>