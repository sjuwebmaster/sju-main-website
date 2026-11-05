<?php
// 1. Define the path we want to test
$target = dirname(__DIR__, 2) . '/config.php';

echo "<h2>Path Security Check</h2>";
echo "<b>Looking for file at:</b> " . $target . "<br><br>";

// 2. Run the tests
if (file_exists($target)) {
    echo "✅ <b>SUCCESS:</b> The file exists.<br>";
    
    if (is_readable($target)) {
        echo "✅ <b>SUCCESS:</b> PHP has permission to read the file.<br>";
        
        // Final Test: Try to pull a piece of data
        include $target;
        if (defined('DB_HOST')) {
            echo "✅ <b>SUCCESS:</b> Constants from config.php were loaded! (Host: " . DB_HOST . ")";
        } else {
            echo "❌ <b>ERROR:</b> File loaded, but no constants were found. Check your config.php syntax.";
        }
    } else {
        echo "❌ <b>ERROR:</b> The file exists, but PHP is NOT allowed to read it (Check Permissions).";
    }
} else {
    echo "❌ <b>ERROR:</b> The file was not found at that location. double-check the folder name.";
}
?>