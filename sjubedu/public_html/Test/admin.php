<?php
// Test/admin_update.php
session_start();

// --- 1. SECURITY BRIDGE ---
// Points to /home/sjubedu/config.php (outside public_html)
$config = file_exists('/home/sjubedu/config.php') ? '/home/sjubedu/config.php' : __DIR__ . '/../../config.php';
require_once $config;

// --- 2. STOP SIGNAL LOGIC ---
if (isset($_GET['stop_sync'])) {
    $_SESSION['stop_signal'] = true;
    header("Location: admin_update.php");
    exit;
}

// --- 3. STREAMING CONFIG ---
// Forces the server to send progress data to the browser immediately
if (isset($_POST['run_sync'])) {
    header('Content-Type: text/html; charset=utf-8');
    header('Cache-Control: no-cache');
    header('X-Accel-Buffering: no'); 
    ini_set('output_buffering', 'off');
    ini_set('zlib.output_compression', false);
    while (ob_get_level()) ob_end_flush();
    ob_implicit_flush(true);
}

// --- 4. DATABASE CONNECTION ---
try {
    // Uses constants (DB_HOST, DB_NAME, etc.) from your private config.php
    $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4", DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) { 
    die("DB Connection Failed: Check your private config.php settings."); 
}

// --- 5. AUTHENTICATION ---
if (isset($_POST['login_pass'])) {
    // $ADMIN_PASSWORD must be defined in your private config.php
    if ($_POST['login_pass'] === $ADMIN_PASSWORD) { 
        $_SESSION['is_admin'] = true; 
    } else { 
        $message = "<div class='alert alert-danger'>❌ Incorrect Password</div>"; 
    }
}

if (isset($_GET['logout'])) { 
    session_destroy(); 
    header("Location: admin_update.php"); 
    exit; 
}

if (!isset($_SESSION['is_admin'])) {
    ?>
    <!DOCTYPE html><html><head>
    <?php include $_SERVER['DOCUMENT_ROOT'] . '/gtm.php'; ?><title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"></head>
    <body class="bg-light d-flex align-items-center" style="height:100vh;"><div class="container" style="max-width:400px;"><div class="card shadow p-4 text-center">
    <h2>Admin Login</h2><?php if(isset($message)) echo $message; ?>
    <form method="POST"><input type="password" name="login_pass" class="form-control mb-3" placeholder="Password" required autofocus><button class="btn btn-primary w-100">Login</button></form>
    </div></div></body></html>
    <?php exit;
}

// --- 6. GATHER DATA ---
$stmt = $pdo->query("SELECT id, content, created_at FROM api_cache ORDER BY created_at DESC");
$db_rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
$total_faculty = count($db_rows);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php include $_SERVER['DOCUMENT_ROOT'] . '/gtm.php'; ?>
    <meta charset="UTF-8">
    <title>SJU Faculty Control Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        #progress-area { display: none; margin-bottom: 20px; }
        .card { border: none; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        .sync-table { max-height: 400px; overflow-y: auto; }
    </style>
</head>
<body class="bg-light">

<nav class="navbar navbar-dark bg-dark mb-4 shadow"><div class="container">
    <span class="navbar-brand fw-bold">SJU Faculty Admin</span>
    <a href="?logout=1" class="btn btn-sm btn-outline-light">Logout</a>
</div></nav>

<div class="container">
    <div id="progress-area" class="card p-4 border-primary shadow">
        <h5><i class="fa fa-sync fa-spin me-2 text-primary"></i> Synchronizing with Linways...</h5>
        <div class="progress mb-2" style="height: 25px;">
            <div id="p-bar" class="progress-bar progress-bar-striped progress-bar-animated bg-success" style="width: 0%">0%</div>
        </div>
        <div class="d-flex justify-content-between align-items-center">
            <small id="p-status" class="text-muted">Preparing...</small>
            <a href="?stop_sync=1" class="btn btn-danger btn-sm"><i class="fa fa-stop-circle me-1"></i> Stop Sync</a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="card p-4 text-center bg-primary text-white mb-3">
                <h6 class="text-uppercase small opacity-75">Cached Profiles</h6>
                <h1 class="display-4 fw-bold"><?php echo $total_faculty; ?></h1>
            </div>
            <div class="card p-3 shadow-sm">
                <form method="POST">
                    <button name="run_sync" class="btn btn-success w-100 py-2 fw-bold">
                        <i class="fa fa-refresh me-2"></i> Sync All Profiles Now
                    </button>
                </form>
                <p class="small text-muted mt-2 mb-0 text-center italic">Updates content for all currently cached IDs.</p>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card p-4 shadow-sm">
                <h5 class="mb-3 border-bottom pb-2">Cached Faculty List</h5>
                <div class="sync-table">
                    <table class="table table-hover table-sm">
                        <thead class="table-light"><tr><th>ID</th><th>Last Synced (IST)</th></tr></thead>
                        <tbody>
                            <?php foreach($db_rows as $row): ?>
                                <tr>
                                    <td><code><?php echo htmlspecialchars($row['id']); ?></code></td>
                                    <td class="small text-muted"><?php echo $row['created_at']; ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
// --- THE SYNC ENGINE ---
if (isset($_POST['run_sync'])) {
    echo "<script>document.getElementById('progress-area').style.display = 'block';</script>";
    
    set_time_limit(0); 
    $total = count($db_rows);

    if ($total > 0) {
        // Reset the stop signal at the start of a fresh run
        unset($_SESSION['stop_signal']);

        foreach ($db_rows as $index => $row) {
            // CHECK FOR STOP SIGNAL
            if (isset($_SESSION['stop_signal']) && $_SESSION['stop_signal'] === true) {
                unset($_SESSION['stop_signal']);
                echo "<script>alert('Sync Interrupted by User.'); window.location.href='admin_update.php';</script>";
                exit;
            }

            $cache_id = $row['id'];
            $raw_id = str_replace('faculty_', '', $cache_id);
            $percent = round((($index + 1) / $total) * 100);

            // 1. FETCH FROM API (Using $API_TOKEN from config.php)
            $opts = [
                CURLOPT_RETURNTRANSFER => true, 
                CURLOPT_HTTPHEADER => ["Authorization: $API_TOKEN", "Accept: application/json"], 
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_TIMEOUT => 5
            ];

            $ch = curl_init("https://sjuv4.linways.com/api/v1/staffs/" . urlencode($raw_id));
            curl_setopt_array($ch, $opts);
            $staff = json_decode(curl_exec($ch), true); curl_close($ch);

            $ch = curl_init("https://sjuv4.linways.com/api/v1/exat2/reports/FxNRR5E7W56PzBizk/" . urlencode($raw_id));
            curl_setopt_array($ch, $opts);
            $reports = json_decode(curl_exec($ch), true); curl_close($ch);

            // 2. SAVE TO DB
            if ($staff && $reports && !isset($staff['error'])) {
                $stmt = $pdo->prepare("REPLACE INTO api_cache (id, content, created_at, fail_count) VALUES (?, ?, NOW(), 0)");
                $stmt->execute([$cache_id, json_encode(['staff' => $staff, 'reports' => $reports])]);
            }

            // 3. PUSH UPDATE TO BROWSER
            echo "<script>
                document.getElementById('p-bar').style.width = '$percent%';
                document.getElementById('p-bar').innerText = '$percent%';
                document.getElementById('p-status').innerText = 'Updating: " . ($index+1) . " / $total (ID: $raw_id)';
            </script>";

            // 4. CRITICAL FLUSH (Forces browser to show progress)
            echo str_repeat(' ', 1024 * 64); 
            flush();
            
            usleep(50000); // 0.05s tiny pause for smoothness
        }
        echo "<script>window.location.href='admin_update.php?msg=success';</script>";
    }
}
?>
</body>
</html>