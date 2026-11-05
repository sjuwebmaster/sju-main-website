<?php
// Test/settings.php - Configuration Manager
session_start();
$config = file_exists('/home/sjubedu/config.php') ? '/home/sjubedu/config.php' : __DIR__ . '/../../config.php';
require_once $config;

// --- 2. GLOBAL TRACKER INJECTION ---
// This is your Global Security & Tracker Bridge. 
// It must stay here to catch your iPhone's IPv6 address.
if (file_exists('/home/sjubedu/public_html/global_tracker.php')) {
    require_once('/home/sjubedu/public_html/global_tracker.php');
}

if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

// --- AUTHENTICATION ---
if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== true) {
    header("Location: dashboard.php");
    exit;
}

$message = '';

// --- HANDLE FORM SUBMISSION ---
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $new_token = trim($_POST['api_token']);
    $new_pass = trim($_POST['admin_password']);

    if (!empty($new_token) && !empty($new_pass)) {
        // Prepare content for config.php
        // We use var_export to safely escape strings
        $config_content = "<?php\n";
        $config_content .= "// Configuration Settings\n";
        $config_content .= "date_default_timezone_set('Asia/Kolkata'); // Set PHP to Indian Time\n";
        $config_content .= "// API Token\n";
        $config_content .= "\$API_TOKEN  = " . var_export($new_token, true) . ";\n";
        $config_content .= "\$ADMIN_PASSWORD = " . var_export($new_pass, true) . ";\n";
        $config_content .= "// Cache Directory\n";
        $config_content .= "\$CACHE_DIR = __DIR__ . '/cache';\n";
        $config_content .= "?>";

        // Write to file
        if (file_put_contents(__DIR__ . '/config.php', $config_content)) {
            $message = "<div class='alert alert-success'>✅ Settings updated successfully!</div>";
            // Update current session variables to reflect changes immediately
            $API_TOKEN = $new_token;
            $ADMIN_PASSWORD = $new_pass;
        } else {
            $message = "<div class='alert alert-danger'>❌ Failed to write to config.php. Check file permissions.</div>";
        }
    } else {
        $message = "<div class='alert alert-danger'>⚠️ All fields are required.</div>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Settings</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-light d-flex align-items-center justify-content-center vh-100">

    <div class="card shadow p-4" style="width: 100%; max-width: 600px;">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h3 class="mb-0"><i class="fa fa-cogs me-2"></i> Settings</h3>
            <div>
                <a href="dashboard.php" class="btn btn-outline-secondary btn-sm me-2">&larr; Dashboard</a>
                <a href="?logout=1" class="btn btn-outline-danger btn-sm">Logout</a>
            </div>
        </div>
        <hr>
        
        <?php echo $message; ?>

        <form method="POST">
            <div class="mb-3">
                <label class="form-label fw-bold">Admin Password</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fa fa-lock"></i></span>
                    <input type="text" name="admin_password" class="form-control" value="<?php echo htmlspecialchars($ADMIN_PASSWORD); ?>" required>
                </div>
                <div class="form-text">Password used to access the Dashboard.</div>
            </div>

            <div class="mb-4">
                <label class="form-label fw-bold">Linways API Token</label>
                <textarea name="api_token" class="form-control" rows="5" required><?php echo htmlspecialchars($API_TOKEN); ?></textarea>
                <div class="form-text">JWT Token used for authenticating with the Linways API.</div>
            </div>

            <button type="submit" class="btn btn-primary w-100"><i class="fa fa-save me-2"></i> Save Changes</button>
        </form>
    </div>
</body>
</html>