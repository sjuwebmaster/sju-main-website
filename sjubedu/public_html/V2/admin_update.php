<?php
// Test/admin_update.php - FULL CONTROL PANEL WITH AUTO-PURGE & LOGGING
session_start();
//require_once __DIR__ . '/config.php';
$config = file_exists('/home/sjubedu/config.php') ? '/home/sjubedu/config.php' : __DIR__ . '/../../config.php';
require_once $config;
// Keeps logs in the Test folder so you can actually read them via FTP
$purge_log = __DIR__ . '/purge_history.log';
// --- DATABASE CONNECTION ---
try {
    $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4", DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->exec("SET time_zone = '+05:30'");

    // Auto-purge removed for safety. Use Dashboard Manual Override.

} catch (PDOException $e) { die("DB Connection Failed."); }

$message = "";

// --- 2. LOGIN / LOGOUT SYSTEM ---
if (isset($_POST['username']) && isset($_POST['password'])) {
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    $captcha_answer = trim($_POST['captcha'] ?? '');
    $expected_captcha = ($_SESSION['captcha_num1'] ?? 0) + ($_SESSION['captcha_num2'] ?? 0);

    if ($captcha_answer !== (string)$expected_captcha) {
        $message = "<div class='alert alert-danger'>❌ Incorrect CAPTCHA answer</div>";
    } else {
    try {
        $stmt = $pdo->prepare("SELECT * FROM admin_users WHERE username = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($user && password_verify($password, $user['password_hash'])) {
            $upd = $pdo->prepare("UPDATE admin_users SET last_login = NOW() WHERE id = ?");
            $upd->execute([$user['id']]);

            $_SESSION['is_admin'] = true;
            $_SESSION['admin_username'] = $user['username'];
            $_SESSION['admin_role'] = $user['role'];
            $perms = json_decode($user['permissions'] ?? '[]', true);
            if (empty($perms)) {
                if ($user['role'] === 'superadmin') $perms = ['manage_users', 'sync_data', 'purge_data', 'manage_gallery', 'manage_list', 'manage_phd', 'manage_publication', 'manage_project', 'manage_awards', 'manage_patent', 'manage_book_chapter', 'manage_books_published', 'manage_consultancy', 'manage_events', 'manage_media', 'view_logs'];
                elseif ($user['role'] === 'editor') $perms = ['sync_data'];
                else $perms = [];
            }
            $_SESSION['admin_perms'] = $perms;
        } elseif ($username === ($ADMIN_USERNAME ?? 'sjuadmin') && $password === $ADMIN_PASSWORD) {
            $_SESSION['is_admin'] = true;
            $_SESSION['admin_username'] = $ADMIN_USERNAME ?? 'sjuadmin';
            $_SESSION['admin_role'] = 'superadmin';
            $_SESSION['admin_perms'] = ['manage_users', 'sync_data', 'purge_data', 'manage_gallery', 'manage_list', 'manage_phd', 'manage_publication', 'manage_project', 'manage_awards', 'manage_patent', 'manage_book_chapter', 'manage_books_published', 'manage_consultancy', 'manage_events', 'manage_media', 'view_logs'];
        } else {
            $message = "<div class='alert alert-danger'>❌ Incorrect Username or Password</div>";
        }
    } catch (Exception $e) {
        if ($username === ($ADMIN_USERNAME ?? 'sjuadmin') && $password === $ADMIN_PASSWORD) {
            $_SESSION['is_admin'] = true;
            $_SESSION['admin_username'] = $ADMIN_USERNAME ?? 'sjuadmin';
            $_SESSION['admin_role'] = 'superadmin';
            $_SESSION['admin_perms'] = ['manage_users', 'sync_data', 'purge_data', 'manage_gallery', 'manage_list', 'manage_phd', 'manage_publication', 'manage_project', 'manage_awards', 'manage_patent', 'manage_book_chapter', 'manage_books_published', 'manage_consultancy', 'manage_events', 'manage_media', 'view_logs'];
        } else {
            $message = "<div class='alert alert-danger'>❌ Database/Login Error</div>";
        }
    }
    }
}
if (isset($_GET['logout'])) { session_destroy(); header("Location: admin_update.php"); exit; }

if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== true) {
    // Generate CAPTCHA
    $_SESSION['captcha_num1'] = rand(1, 9);
    $_SESSION['captcha_num2'] = rand(1, 9);
    // ... (Your existing Login HTML goes here) ...
    ?>
    <!DOCTYPE html><html><head><title>Login</title><link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"></head>
    <body class="bg-light d-flex align-items-center" style="height:100vh;"><div class="container" style="max-width:400px;"><div class="card shadow p-4 text-center">
    <h2 class="mb-4">Admin Login</h2><?php echo $message; ?>
    <form method="POST">
        <input type="text" name="username" class="form-control mb-3" placeholder="Username (e.g. <?php echo htmlspecialchars($ADMIN_USERNAME ?? 'sjuadmin'); ?>)" required autofocus>
        <input type="password" name="password" class="form-control mb-3" placeholder="Password" required>
        <div class="mb-3 text-start">
            <label class="form-label text-secondary fw-bold">Security Check: <?php echo $_SESSION['captcha_num1']; ?> + <?php echo $_SESSION['captcha_num2']; ?> = ?</label>
            <input type="number" name="captcha" class="form-control" placeholder="Answer" required>
        </div>
        <button class="btn btn-primary w-100">Unlock</button>
    </form>
    </div></div></body></html>
    <?php exit;
}

if (!in_array('manage_list', $_SESSION['admin_perms'] ?? [])) {
    header("Location: dashboard.php");
    exit;
}

// --- 3. ACTIONS ---
if (isset($_GET['delete_id'])) {
    if (in_array('purge_data', $_SESSION['admin_perms'] ?? [])) {
        $stmt = $pdo->prepare("DELETE FROM api_cache WHERE id = ?");
        $stmt->execute([$_GET['delete_id']]);
        $message = "<div class='alert alert-success'>✅ Profile removed.</div>";
    } else { $message = "<div class='alert alert-danger'>❌ Access Denied.</div>"; }
}
if (isset($_POST['clear_db'])) {
    if (in_array('purge_data', $_SESSION['admin_perms'] ?? [])) {
        $pdo->exec("TRUNCATE TABLE api_cache");
        $message = "<div class='alert alert-warning'>🗑️ Database Wiped Clean.</div>";
    } else { $message = "<div class='alert alert-danger'>❌ Access Denied: Superadmin only.</div>"; }
}
if (isset($_POST['manual_purge'])) {
    if (in_array('purge_data', $_SESSION['admin_perms'] ?? [])) {
        $cutoff_time = date('Y-m-d H:i:s', strtotime('-6 hours'));
        $stmt = $pdo->prepare("DELETE FROM api_cache WHERE created_at < ?");
        $stmt->execute([$cutoff_time]);
        $count = $stmt->rowCount();
        $message = "<div class='alert alert-success'>✅ Manual Purge: Removed $count expired records.</div>";
        $log_msg = "[" . date('Y-m-d H:i:s') . "] MANUAL PURGE (Admin): Removed $count IDs.\n";
        file_put_contents($purge_log, $log_msg, FILE_APPEND);
    } else { $message = "<div class='alert alert-danger'>❌ Access Denied.</div>"; }
}

// --- 4. DATA GATHERING ---
$stmt = $pdo->query("SELECT id, content, created_at FROM api_cache ORDER BY created_at DESC");
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
$total_faculty = count($rows);

$faculty_list = []; $dept_stats = [];
foreach ($rows as $row) {
    $json = json_decode($row['content'], true);
    $dept = $json['staff']['department']['name'] ?? 'Unknown';
    $faculty_list[] = ['id'=>$row['id'], 'raw_id'=>str_replace('faculty_','',$row['id']), 'name'=>$json['staff']['name'] ?? 'Unknown', 'dept'=>$dept, 'updated'=>$row['created_at']];
    $dept_stats[$dept] = ($dept_stats[$dept] ?? 0) + 1;
}
ksort($dept_stats);

// Read last few lines of purge log for the widget
$purge_history = file_exists($purge_log) ? array_slice(explode("\n", trim(file_get_contents($purge_log))), -3) : ["No recent purges."];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>SJU Admin Terminal (IST)</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .stat-box { border-left: 5px solid #0d6efd; background: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.05); }
        .purge-widget { font-family: monospace; font-size: 0.75rem; background: #212529; color: #0dfd0d; padding: 10px; border-radius: 5px; }
    </style>
</head>
<body class="bg-light">

<nav class="navbar navbar-dark bg-dark mb-4 shadow"><div class="container d-flex justify-content-between">
    <span class="navbar-brand fw-bold">SJU Faculty Admin</span>
    <div class="text-white small"><i class="fa fa-clock me-2"></i><?php echo date('h:i A'); ?> IST</div>
    <div>
        <a href="dashboard.php" class="btn btn-outline-light btn-sm me-2"><i class="fa fa-tachometer-alt"></i> Dashboard</a>
        <a href="?logout=1" class="btn btn-outline-light btn-sm">Logout</a>
    </div>
</div></nav>

<div class="container">
    <?php echo $message; ?>

    <div class="row mb-4">
        <div class="col-md-4">
            <div class="stat-box mb-4">
                <h6 class="text-muted small">ACTIVE PROFILES (6H WINDOW)</h6>
                <h1 class="display-4 fw-bold"><?php echo $total_faculty; ?></h1>
            </div>
            
            <div class="card p-3 shadow-sm mb-4">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <h6 class="fw-bold m-0"><i class="fa fa-broom me-2"></i> Recent Purges</h6>
                    <a href="view_logs.php" class="small text-decoration-none">View Full Log</a>
                </div>
                <div class="purge-widget">
                    <?php foreach(array_reverse($purge_history) as $line) echo htmlspecialchars($line) . "<br>"; ?>
                </div>
            </div>

        <?php if (in_array('purge_data', $_SESSION['admin_perms'] ?? [])): ?>
            <div class="card p-3 shadow-sm mb-4 border-danger">
                <h6 class="fw-bold text-danger"><i class="fa fa-exclamation-triangle me-2"></i> Maintenance</h6>
                <form method="POST" onsubmit="return confirm('Are you sure?');">
                    <button type="submit" name="manual_purge" class="btn btn-outline-danger w-100 btn-sm mb-2">Purge Expired (>6h)</button>
                <button type="submit" name="clear_db" class="btn btn-danger w-100 btn-sm">Wipe Database (Reset)</button>
                </form>
            </div>
        <?php endif; ?>

            <div class="card p-3 shadow-sm border-success mb-3">
                <form method="POST" target="sync_window" onsubmit="window.open('', 'sync_window', 'width=600,height=400');">
                    <button type="submit" name="run_bulk" class="btn btn-success w-100">
                        <i class="fa fa-refresh me-2"></i> Bulk Sync (New Window)
                    </button>
                </form>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card shadow-sm p-4 h-100">
                <h5><i class="fa fa-building text-primary me-2"></i> Department Breakdown</h5>
                <div class="row">
                    <?php foreach ($dept_stats as $name => $count): ?>
                    <div class="col-6 mb-2 border-bottom d-flex justify-content-between p-1">
                        <small><?php echo $name; ?></small><span class="badge bg-primary rounded-pill"><?php echo $count; ?></span>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow-sm p-4 mb-5">
        <h5 class="fw-bold mb-3">Faculty Directory</h5>
        <div class="table-responsive">
            <table class="table table-hover">
                <thead><tr><th>ID</th><th>Name</th><th>Dept</th><th>Synced (IST)</th><th>Action</th></tr></thead>
                <tbody>
                    <?php foreach ($faculty_list as $f): ?>
                    <tr>
                        <td><?php echo $f['raw_id']; ?></td>
                        <td class="fw-bold"><?php echo $f['name']; ?></td>
                        <td><?php echo $f['dept']; ?></td>
                        <td class="text-muted"><?php echo date("H:i", strtotime($f['updated'])); ?></td>
                        <td><a href="?delete_id=<?php echo $f['id']; ?>" class="text-danger" onclick="return confirm('Delete?');"><i class="fa fa-trash"></i></a></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
</body>
</html>