<?php
session_start();
$config = file_exists('/home/sjubedu/config.php') ? '/home/sjubedu/config.php' : __DIR__ . '/../../config.php';
require_once $config;
date_default_timezone_set('Asia/Kolkata');

// --- 2. GLOBAL TRACKER INJECTION ---
// This is your Global Security & Tracker Bridge. 
// It must stay here to catch your iPhone's IPv6 address.
//if (file_exists('/home/sjubedu/public_html/global_tracker.php')) {
  //  require_once('/home/sjubedu/public_html/global_tracker.php');
//}
// This is your Global Security & Tracker Bridge. 
// It must stay here to catch your iPhone's IPv6 address.
if (file_exists('/home/sjubedu/public_html/global_tracker.php')) {
    require_once('/home/sjubedu/public_html/global_tracker.php');
}

$message = '';
$error = '';

if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

// Handle Login
if (isset($_POST['login'])) {
    if ($_POST['password'] === $ADMIN_PASSWORD) {
        $_SESSION['is_admin'] = true;
    } else {
        $error = 'Invalid password';
    }
}

// Handle Clear Cache
if (isset($_SESSION['is_admin']) && $_SESSION['is_admin'] === true && $_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['clear_cache'])) {
    if (is_dir($CACHE_DIR)) {
        $files = glob($CACHE_DIR . '/*'); 
        $count = 0;
        foreach ($files as $file) {
            if (is_file($file)) {
                unlink($file);
                $count++;
            }
        }
        $message = "Cache cleared successfully! ($count files deleted)";
    } else {
        $message = "Cache directory not found.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include $_SERVER['DOCUMENT_ROOT'] . '/gtm.php'; ?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title>Clear Cache</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light d-flex align-items-center justify-content-center vh-100">
    <div class="card shadow-sm p-4 text-center" style="max-width: 400px;">
        <div class="d-flex justify-content-between mb-2">
            <a href="dashboard.php" class="text-decoration-none small">&larr; Dashboard</a>
            <?php if (isset($_SESSION['is_admin']) && $_SESSION['is_admin'] === true): ?><a href="?logout=1" class="text-danger text-decoration-none small">Logout</a><?php endif; ?>
        </div>
        <h3 class="mb-3">Cache Manager</h3>

        <?php if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== true): ?>
            <?php if ($error): ?>
                <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
            <?php endif; ?>
            <form method="post">
                <div class="mb-3">
                    <input type="password" name="password" class="form-control" placeholder="Enter Password" required>
                </div>
                <button type="submit" name="login" class="btn btn-primary w-100">Login</button>
            </form>
        <?php else: ?>
            <?php if ($message): ?>
                <div class="alert alert-success"><?php echo htmlspecialchars($message); ?></div>
            <?php endif; ?>

            <?php
            if (is_dir($CACHE_DIR)) {
                $files = glob($CACHE_DIR . '/*');
                if ($files) {
                    foreach ($files as $file) {
                        if (is_file($file)) {
                            $last_updated = date("d M Y, h:i A", filemtime($file));
                            echo '<div class="alert alert-info py-2 mb-3"><small><strong>' . htmlspecialchars(basename($file)) . '</strong><br>Last Updated: ' . $last_updated . '</small></div>';
                        }
                    }
                }
            }
            ?>

            <p class="text-muted mb-4">Click below to clear stored API data and force a refresh on the next visit.</p>
            <form method="post">
                <button type="submit" name="clear_cache" class="btn btn-danger w-100">Clear Cache</button>
            </form>
        <?php endif; ?>
    </div>
</body>
</html>