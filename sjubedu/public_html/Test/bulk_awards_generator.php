<?php
// bulk_awards_generator.php

$config = file_exists('/home/sjubedu/config.php') ? '/home/sjubedu/config.php' : __DIR__ . '/../../config.php';
require_once $config;

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
$target_dir = __DIR__ . '/awards';
if (!is_dir($target_dir)) {
    if (!@mkdir($target_dir, 0755, true)) {
        die("<div style='font-family:sans-serif; color:#721c24; background:#f8d7da; padding:20px; border:1px solid #f5c6cb; border-radius:5px;'>
            <h3>❌ Permission Error: Cannot Create Directory</h3>
            <p>The server cannot create the folder <code>$target_dir</code>.</p>
            <p><strong>Run this command in your EC2 terminal to fix it:</strong></p>
            <pre style='background:#2d2d2d; color:#fff; padding:15px; border-radius:5px;'>sudo chown -R www-data:www-data " . __DIR__ . " && sudo chmod -R 755 " . __DIR__ . "</pre>
            </div>");
    }
}

// Check if writable
if (!is_writable($target_dir)) {
    die("<div style='font-family:sans-serif; color:#721c24; background:#f8d7da; padding:20px; border:1px solid #f5c6cb; border-radius:5px;'>
        <h3>❌ Permission Error: Directory Not Writable</h3>
        <p>The server cannot write files to <code>$target_dir</code>.</p>
        <p><strong>Run this command in your EC2 terminal to fix it:</strong></p>
        <pre style='background:#2d2d2d; color:#fff; padding:15px; border-radius:5px;'>sudo chown -R www-data:www-data $target_dir && sudo chmod -R 755 $target_dir</pre>
        </div>");
}

$template_file = __DIR__ . '/awards.php';
if (!file_exists($template_file)) {
    die("<div class='alert alert-danger'>CRITICAL ERROR: The template file <code>awards.php</code> is missing. Cannot generate pages.</div>");
}

if (!copy($template_file, $target_dir . '/awards.php')) {
    die("<div class='alert alert-danger'>CRITICAL ERROR: Failed to copy template file into <code>$target_dir</code>. Check permissions.</div>");
}

echo "<h2>Generating Awards Pages...</h2><ul>";
$count = 0;
foreach ($departments as $id => $name) {
    $filename = "awards_" . $id . ".php";
    $content = "<?php\n// Auto-generated Awards Page for $name\n\$DEPARTMENT_ID = \"$id\";\n\$DEPARTMENT_NAME = \"" . addslashes($name) . "\";\nrequire_once __DIR__ . '/awards.php';\n?>";
    if (file_put_contents($target_dir . '/' . $filename, $content)) {
        echo "<li>✅ Created <strong><a href='awards/$filename' target='_blank'>awards/$filename</a></strong> for $name</li>";
        $count++;
    }
}
echo "</ul><p><strong>Total pages created: $count</strong></p>";
?>