<?php
// master_sync.php - Unified Sync Script
// Runs Faculty, PhD, and Publication syncs sequentially.

// Increase time limit for the master process (1 hour)
set_time_limit(3600);
ignore_user_abort(true);
ini_set('memory_limit', '1024M');
date_default_timezone_set('Asia/Kolkata');

$is_cli = (php_sapi_name() === 'cli');

if (!$is_cli) {
    echo "<!DOCTYPE html><html><head>
    <?php include $_SERVER['DOCUMENT_ROOT'] . '/gtm.php'; ?><title>Master Sync</title>";
    echo "<link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css' rel='stylesheet'>";
    echo "<style>body { background: #121212; color: #e0e0e0; font-family: monospace; padding: 20px; } .card { background: #1e1e1e; border: 1px solid #333; margin-bottom: 20px; } .card-header { border-bottom: 1px solid #333; font-weight: bold; color: #fff; } pre { margin: 0; color: #00ff00; max-height: 300px; overflow-y: auto; white-space: pre-wrap; }</style>";
    echo "</head><body>";
    echo "<div class='container'>";
    echo "<div class='d-flex justify-content-between align-items-center mb-4'>";
    echo "<h2 class='text-primary mb-0'><i class='fa fa-rocket'></i> SJU Master Sync Protocol</h2>";
    echo "<a href='dashboard.php' class='btn btn-outline-light btn-sm'>Back to Dashboard</a>";
    echo "</div>";
    echo "<p class='text-muted'>Starting sequential synchronization of all datasets...</p>";
} else {
    echo "🚀 SJU Master Sync Protocol (CLI Mode)\n";
    echo "Starting sequential synchronization of all datasets...\n\n";
}

// Helper to run script and capture output
function run_script($script_name, $label) {
    global $is_cli;
    
    if (!$is_cli) {
        echo "<div class='card'>";
        echo "<div class='card-header'>$label (" . $script_name . ")</div>";
        echo "<div class='card-body'><pre>";
    } else {
        echo "--------------------------------------------------\n";
        echo "$label ($script_name)\n";
        echo "--------------------------------------------------\n";
    }
    
    $file_path = __DIR__ . '/' . $script_name;
    
    if (file_exists($file_path)) {
        // Capture output buffer
        ob_start();
        try {
            include $file_path;
        } catch (Exception $e) {
            echo "Error running script: " . $e->getMessage();
        }
        $output = ob_get_clean();
        
        // Clean up output (remove existing HTML tags from child scripts if any, to keep log clean)
        $allowed_tags = $is_cli ? '' : '<br><p><div>';
        $output = strip_tags($output, $allowed_tags); 
        echo trim($output) ?: "Script executed (No output).";
        
    } else {
        echo "❌ Error: Script file '$script_name' not found in " . __DIR__;
    }
    
    if (!$is_cli) {
        echo "</pre></div></div>";
    } else {
        echo "\n\n";
    }
    
    // Force flush to browser
    if (ob_get_level() > 0) ob_flush();
    flush();
}

// 1. Faculty Sync
//run_script('cron_update_all.php', '1. Faculty Profiles');

// 2. PhD Sync
run_script('bulk_phd_cron.php', '2. PhD Scholars');

// 3. Publication Sync
run_script('bulk_publication_cron.php', '3. Publications');

// 4. Project Sync
run_script('bulk_project_cron.php', '4. Projects');

// 5. Awards Sync
run_script('bulk_awards_cron.php', '5. Awards');

// 6. Patents Sync
run_script('bulk_patent_cron.php', '6. Patents');

// 7. Book Chapters Sync
run_script('bulk_book_chapter_cron.php', '7. Book Chapters');

// 8. Books Published Sync
run_script('bulk_books_published_cron.php', '8. Books Published');

// 9. Consultancy Sync
run_script('bulk_consultancy_cron.php', '9. Consultancy');

// 10. Events Organized Sync
run_script('bulk_events_organized_cron.php', '10. Events Organized');

// 11. Popular Media Sync
run_script('bulk_popular_media_cron.php', '11. Popular Media Articles');

if (!$is_cli) {
    echo "<div class='alert alert-success mt-4'>✅ Master Sync Completed Successfully.</div>";
    echo "<a href='dashboard.php' class='btn btn-light'>Return to Dashboard</a>";
    echo "</div></body></html>";
} else {
    echo "✅ Master Sync Completed Successfully.\n";
}
?>