<?php
// master_generator.php - Runs all bulk page generators
// This script sequentially includes all generator scripts to refresh all static files.

set_time_limit(3600); // 1 hour execution time (needed for Live generators)
ignore_user_abort(true); // Continue running even if browser closes
ini_set('memory_limit', '1024M');

session_start();
$is_cli = (php_sapi_name() === 'cli' || defined('STDIN') || (empty($_SERVER['REMOTE_ADDR']) && !isset($_SERVER['HTTP_USER_AGENT']) && count($_SERVER['argv']) > 0));
$config = file_exists('/home/sjubedu/config.php') ? '/home/sjubedu/config.php' : __DIR__ . '/../../config.php';
require_once $config;

// Auth Check
if (!$is_cli && (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== true)) {
    header("Location: dashboard.php");
    exit;
}

echo "<!DOCTYPE html><html><head><title>Master Generator</title>";
echo "<link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css' rel='stylesheet'>";
echo "<style>body { background: #f8f9fa; padding: 20px; } .card { margin-bottom: 20px; } .output-box { max-height: 200px; overflow-y: auto; background: #212529; color: #00ff00; padding: 10px; font-family: monospace; font-size: 0.85rem; } .card-header { background: #343a40; color: white; }</style>";
echo "</head><body>";
echo "<div class='container'>";
echo "<div class='d-flex justify-content-between align-items-center mb-4'>";
echo "<h2><i class='fa fa-cogs'></i> Master Page Generator</h2>";
echo "<a href='dashboard.php' class='btn btn-secondary'>Back to Dashboard</a>";
echo "</div>";
echo "<div class='alert alert-info'>This process will regenerate all department-specific PHP files for every module.</div>";

$generators = [
    'bulk_phd_generator.php' => 'PhD Pages (Cached)',
    'bulk_phd_live_generator.php' => 'PhD Pages (LIVE)',
    'bulk_publication_generator.php' => 'Publication Pages (Cached)',
    'bulk_publication_live_generator.php' => 'Publication Pages (LIVE)',
    'bulk_project_generator.php' => 'Project Pages (Cached)',
    'bulk_project_live_generator.php' => 'Project Pages (LIVE)',
    'bulk_awards_generator.php' => 'Award Pages (Cached)',
    'bulk_awards_live_generator.php' => 'Award Pages (LIVE)',
    'bulk_patent_generator.php' => 'Patent Pages (Cached)',
    'bulk_patent_live_generator.php' => 'Patent Pages (LIVE)',
    'bulk_book_chapter_generator.php' => 'Book Chapter Pages (Cached)',
    'bulk_book_chapter_live_generator.php' => 'Book Chapter Pages (LIVE)',
    'bulk_books_published_generator.php' => 'Books Published Pages (Cached)',
    'bulk_books_published_live_generator.php' => 'Books Published Pages (LIVE)',
    'bulk_consultancy_generator.php' => 'Consultancy Pages (Cached)',
    'bulk_consultancy_live_generator.php' => 'Consultancy Pages (LIVE)',
    'bulk_events_organized_generator.php' => 'Events Organized Pages (Cached)',
    'bulk_events_organized_live_generator.php' => 'Events Organized Pages (LIVE)',
    'bulk_popular_media_generator.php' => 'Popular Media Pages (Cached)',
    'bulk_popular_media_live_generator.php' => 'Popular Media Pages (LIVE)',
];

// Progress Bar
if (!$is_cli) echo '<div class="progress mb-4" style="height: 25px;"><div id="master-progress" class="progress-bar progress-bar-striped progress-bar-animated bg-success" role="progressbar" style="width: 0%">0%</div></div>';

$total = count($generators);
$current = 0;

foreach ($generators as $script => $label) {
    $current++;
    $percent = round(($current / $total) * 100);

    if (!$is_cli) {
        echo "<div class='card shadow-sm'>";
        echo "<div class='card-header fw-bold'>$label</div>";
        echo "<div class='card-body p-0'><div class='output-box'>";
    } else {
        echo "Running $script... ";
    }
    
    if (file_exists(__DIR__ . '/' . $script)) {
        // Use output buffering to capture the script's output
        ob_start();
        try {
            include __DIR__ . '/' . $script;
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
        $output = ob_get_clean();
        
        // Strip HTML structure tags to embed cleanly
        $output = preg_replace('/<!DOCTYPE html>|<html.*?>|<head>.*?<\/head>|<body.*?>|<\/body>|<\/html>/si', '', $output);
        
        if (!$is_cli) echo trim($output) ? $output : "Script executed successfully.";
        else echo "Done.\n";
    } else {
        if (!$is_cli) echo "❌ Script not found: $script";
        else echo "❌ Missing: $script\n";
    }
    
    if (!$is_cli) echo "</div></div></div>";
    
    // Update Progress Bar
    if (!$is_cli) echo "<script>document.getElementById('master-progress').style.width = '$percent%'; document.getElementById('master-progress').innerText = '$percent%';</script>";
    
    // Force flush to browser so user sees progress
    if (ob_get_level() > 0) ob_flush();
    flush();
}

if (!$is_cli) {
    echo "<div class='alert alert-success mt-4'>✅ All generators have been executed successfully.</div>";
    echo "</div></body></html>";
} else {
    echo "\n✅ All generators have been executed successfully.\n";
}
?>