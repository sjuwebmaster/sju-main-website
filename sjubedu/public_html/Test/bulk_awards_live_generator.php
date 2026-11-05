<?php
// bulk_awards_live_generator.php

$config = file_exists('/home/sjubedu/config.php') ? '/home/sjubedu/config.php' : __DIR__ . '/../../config.php';
require_once $config;

// --- 2. GLOBAL TRACKER INJECTION ---
// This is your Global Security & Tracker Bridge. 
// It must stay here to catch your iPhone's IPv6 address.
if (file_exists('/home/sjubedu/public_html/global_tracker.php')) {
    require_once('/home/sjubedu/public_html/global_tracker.php');
}

// Auth Check
session_start();
if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== true) {
    if (isset($_POST['login_pass']) && $_POST['login_pass'] === $ADMIN_PASSWORD) {
        $_SESSION['is_admin'] = true;
        header("Location: " . $_SERVER['PHP_SELF']);
        exit;
    }
    echo '<!DOCTYPE html><html><head><title>Login</title><link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"></head><body class="bg-light d-flex align-items-center justify-content-center vh-100"><div class="card shadow p-4"><h3 class="mb-3">Login Required</h3><form method="POST"><input type="password" name="login_pass" class="form-control mb-3" placeholder="Password" required><button class="btn btn-primary w-100">Login</button></form></div></body></html>';
    exit;
}

// The $departments array is now included from config.php
// Ensure the 'awards_live' subdirectory exists
$target_dir = __DIR__ . '/awards_live';
if (!is_dir($target_dir)) {
    if (!@mkdir($target_dir, 0755, true)) {
        die("Permission Error: Cannot create directory '$target_dir'.");
    }
}

// Ensure the template file (awards_live.php) exists in the target directory
if (!file_exists(__DIR__ . '/awards_live.php')) {
    die("<div class='alert alert-danger'>CRITICAL ERROR: The template file <code>awards_live.php</code> is missing. Cannot generate pages.</div>");
}

if (!copy(__DIR__ . '/awards_live.php', $target_dir . '/awards_live.php')) {
    die("<div class='alert alert-danger'>CRITICAL ERROR: Failed to copy template file into <code>$target_dir</code>. Check permissions.</div>");
}

echo "<h2>Generating LIVE Awards Pages...</h2><ul>";
$count = 0;
foreach ($departments as $id => $name) {
    $filename = "awards_" . $id . ".php";
    $content = "<?php\n// Auto-generated LIVE Awards Page for $name\n\$DEPARTMENT_ID = \"$id\";\n\$DEPARTMENT_NAME = \"" . addslashes($name) . "\";\nrequire_once __DIR__ . '/awards_live.php';\n?>";
    if (file_put_contents($target_dir . '/' . $filename, $content)) {
        echo "<li>✅ Created <strong><a href='awards_live/$filename' target='_blank'>awards_live/$filename</a></strong> for $name</li>";
        $count++;
    }
}
echo "</ul><p><strong>Total pages created: $count</strong></p>";
?>