<?php
// force_purge.php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$db_host = 'localhost';
$db_name = 'sjubedu_faculty_data'; 
$db_user = 'sjubedu_developer'; 
$db_pass = 'SJU2022_sju';

try {
    $pdo = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // This empties the table completely
    $pdo->exec("TRUNCATE TABLE api_cache");

    echo "<h1>✅ Success!</h1>";
    echo "The faculty cache has been completely cleared. All pages will now pull fresh data from Linways.";
} catch (Exception $e) {
    echo "<h1>❌ Error</h1>" . $e->getMessage();
}
?>