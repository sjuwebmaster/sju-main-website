<?php
session_start();

/**
 * 🛡️ SJU FACULTY PORTAL: MANAGEMENT & MASTER MONITOR SUITE (v3.7)
 * A High-Performance Middleware, Centralized Profile Manager & Traffic Analytics System.
 * Optimized for AWS t3.medium | AlmaLinux 9.x | PHP 8.2
 */

// --- 1. GLOBAL TRACKER INJECTION ---
if (file_exists('/home/sjubedu/public_html/global_tracker.php')) {
    require_once('/home/sjubedu/public_html/global_tracker.php');
}

$ADMIN_PASSWORD = "SJU_ADMIN_2026"; 

if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

if (isset($_POST['password'])) {
    if ($_POST['password'] === $ADMIN_PASSWORD) {
        $_SESSION['docs_auth'] = true;
    } else {
        $error = "Access Denied: Incorrect Security Key.";
    }
}

if (!isset($_SESSION['docs_auth'])): ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include $_SERVER['DOCUMENT_ROOT'] . '/gtm.php'; ?>
    <meta charset="UTF-8">
    <title>SJU Documentation Auth</title>
    <style>
        body { font-family: -apple-system, sans-serif; background: #0f172a; display: flex; align-items: center; justify-content: center; height: 100vh; margin: 0; color: white; }
        .login-box { background: #1e293b; padding: 40px; border-radius: 12px; box-shadow: 0 10px 25px rgba(0,0,0,0.3); text-align: center; width: 350px; border: 1px solid #334155; }
        input { width: 100%; padding: 12px; margin: 15px 0; border: 1px solid #334155; background: #0f172a; color: white; border-radius: 6px; box-sizing: border-box; }
        button { background: #3b82f6; color: white; border: none; padding: 12px; width: 100%; border-radius: 6px; cursor: pointer; font-weight: bold; transition: 0.3s; }
        button:hover { background: #2563eb; }
        .error { color: #f87171; font-size: 14px; margin-bottom: 10px; }
    </style>
</head>
<body>
    <div class="login-box">
        <h2>🛡️ SJU Admin</h2>
        <p style="color: #94a3b8;">System Manual v3.7</p>
        <?php if (isset($error)) echo "<div class='error'>$error</div>"; ?>
        <form method="POST">
            <input type="password" name="password" placeholder="Enter System Key" required autofocus>
            <button type="submit">Unlock Manual</button>
        </form>
    </div>
</body>
</html>
<?php exit; endif; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php include $_SERVER['DOCUMENT_ROOT'] . '/gtm.php'; ?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SJU Master Documentation v3.7</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root { --primary-blue: #4e73df; --dark-slate: #2c3e50; --emergency-red: #e74a3b; --success-green: #1cc88a; }
        body { background-color: #f8f9fc; color: #2d3436; font-family: 'Inter', sans-serif; }
        .sidebar { background: #4e73df; background-image: linear-gradient(180deg, #4e73df 10%, #224abe 100%); height: 100vh; position: fixed; padding: 25px 15px; color: white; z-index: 1000; overflow-y: auto; }
        .main-content { margin-left: 16.66%; padding: 50px; }
        .nav-link { color: rgba(255,255,255,.8); font-weight: 500; border-radius: 8px; margin-bottom: 5px; }
        .nav-link:hover, .nav-link.active { color: white; background: rgba(255,255,255,.15); }
        .card { border: none; box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.1); border-radius: 12px; margin-bottom: 25px; }
        .card-header { background: #f8f9fc; font-weight: bold; color: var(--primary-blue); border-bottom: 1px solid #e3e6f0; }
        pre { background: #1e293b; color: #e2e8f0; padding: 20px; border-radius: 8px; font-size: 0.85rem; position: relative; overflow-x: auto; }
        .timeline-container { border-left: 3px solid var(--primary-blue); padding-left: 20px; position: relative; margin-left: 10px; }
        .timeline-item { position: relative; margin-bottom: 30px; }
        .timeline-item::before { content: ''; position: absolute; left: -29px; top: 5px; width: 15px; height: 15px; border-radius: 50%; background: var(--primary-blue); border: 3px solid white; box-shadow: 0 0 0 3px var(--primary-blue); }
        .emergency-zone { border: 2px dashed var(--emergency-red); background: #fff5f5; padding: 25px; border-radius: 12px; }
        h2 { font-weight: 700; color: var(--dark-slate); margin-top: 40px; border-left: 5px solid var(--primary-blue); padding-left: 15px; }
        .status-pill { background: #d1e7dd; color: #0f5132; padding: 4px 12px; border-radius: 50px; font-size: 0.75rem; font-weight: 700; }
    </style>
</head>
<body>

<div class="container-fluid">
    <div class="row">
        <nav class="col-md-2 sidebar d-none d-md-block">
            <h4 class="text-center mb-4">🛡️ SJU Master</h4>
            <div class="nav flex-column">
                <a class="nav-link active" href="#overview">Overview</a>
                <a class="nav-link" href="#features">Key Features</a>
                <a class="nav-link" href="#schedule">Maintenance Schedule</a>
                <a class="nav-link" href="#security">Hardening</a>
                <a class="nav-link" href="#files">File Structure</a>
                <a class="nav-link" href="#emergency">Emergency Ops</a>
                <hr style="background: white;">
                <a class="nav-link text-warning" href="?logout=1">🚪 Secure Logout</a>
            </div>
        </nav>

        <main class="col-md-10 main-content">
            
            <header id="overview" class="mb-5">
                <div class="d-flex justify-content-between align-items-center">
                    <h1>SJU Faculty Portal Suite v3.7</h1>
                    <span class="status-pill">SYSTEM STABLE</span>
                </div>
                <p class="lead text-muted">A high-availability middleware bridge for Linways API on AWS Infrastructure.</p>
                <div class="alert alert-primary">
                    Designed for <strong>AWS t3.medium</strong> environments to serve <strong>10,000+ students</strong> during peak spikes.
                </div>
            </header>

            <section id="features" class="mb-5">
                <h2>🚀 Key Features</h2>
                <div class="row mt-4">
                    <div class="col-md-4">
                        <div class="card h-100 p-3">
                            <h6>1. Profile Management (v2.1)</h6>
                            <small class="text-muted">Resilient caching via local MySQL; extends data life during API failures.</small>
                            <small class="text-muted mt-2">Zero-downtime sync using <code>REPLACE INTO</code> logic.</small>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card h-100 p-3">
                            <h6>2. Monitor & Security (v3.5)</h6>
                            <small class="text-muted">Automated A-F scoring based on CPU load (Warning @ 1.8, Critical @ 2.5).</small>
                            <small class="text-muted mt-2">Cybersecurity tools for IP nicknaming and bulk blocking.</small>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card h-100 p-3">
                            <h6>3. Emergency Recovery (v3.6)</h6>
                            <small class="text-muted">Secure, key-gated "Nuclear Reset" script to wipe cache/tracking tables.</small>
                        </div>
                    </div>
                </div>
            </section>

            <section id="schedule" class="mb-5">
                <h2>🕒 Automated Maintenance (Cron Schedule)</h2>
                <p class="text-muted">Off-peak operations (01:00 AM – 03:00 AM) to ensure student portal performance.</p>
                
                <div class="card p-4 shadow-sm">
                    <div class="timeline-container">
                        <div class="timeline-item">
                            <strong>01:00 AM</strong> - <code>cron_update_all.php</code>
                            <p class="text-muted mb-0">Initial daily data synchronization and API cache population.</p>
                        </div>
                        <div class="timeline-item">
                            <strong>01:45 AM</strong> - <strong>SQL Database Dump</strong>
                            <p class="text-muted mb-0">Streams compressed <code>.sql.gz</code> to AWS S3 (Mumbai).</p>
                        </div>
                        <div class="timeline-item">
                            <strong>02:01 AM</strong> - <strong>4.8 GiB File Stream</strong>
                            <p class="text-muted mb-0">Streams <code>public_html</code> to S3 via <code>tar</code> pipes to bypass local disk limits.</p>
                        </div>
                        <div class="timeline-item">
                            <strong>03:00 AM</strong> - <code>master_sync.php</code>
                            <p class="text-muted mb-0">Final master synchronization across all data modules.</p>
                        </div>
                    </div>
                    
                    <div class="mt-4 pt-3 border-top">
                        <h6>Live Log Status (Last Modified)</h6>
                        <div class="row">
                            <?php
                            $logs = ['File Backup' => '/home/sjubedu/cron_debug.log', 'SQL Backup' => '/home/sjubedu/sql_cron_debug.log'];
                            foreach ($logs as $name => $path):
                                $status = file_exists($path) ? date("F d, Y H:i", filemtime($path)) : "No Log Found";
                            ?>
                            <div class="col-md-6">
                                <small class="text-muted text-uppercase"><?php echo $name; ?>:</small><br>
                                <strong><?php echo $status; ?></strong>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </section>

            <section id="security" class="mb-5">
                <h2>🛡️ Security & Hardening</h2>
                <div class="card bg-dark text-white p-3 mb-3">
                    <h6>Content-Security-Policy (CSP) Enforcement</h6>
                    <code>header("Content-Security-Policy: default-src 'self'; script-src 'self' https://cdn.jsdelivr.net;");</code>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="card p-3 border-danger h-100">
                            <h6>Disabled Functions</h6>
                            <small><code>exec, system, passthru, shell_exec, popen, proc_open</code></small>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card p-3 border-primary h-100">
                            <h6>Access Control Policy</h6>
                            <small>Denied access to <code>.log, .ini, .sql, .bak, config.php, i_db.php</code></small>
                        </div>
                    </div>
                </div>
            </section>

            <section id="files" class="mb-5">
                <h2>📂 File Structure</h2>
                <div class="card p-3">
                    <h6>Core Monitoring & Database</h6>
                    <ul class="list-unstyled mb-0">
                        <li>📄 <code>dashboard.php</code>: Main control panel for latency and logs.</li>
                        <li>📄 <code>global_tracker.php</code>: Silent visitor tracking engine.</li>
                        <li>📄 <code>master_sync.php</code>: Background full module synchronization.</li>
                        <li>📄 <code>db_speed_test.php</code>: Benchmarks database latency.</li>
                    </ul>
                </div>
            </section>

            <section id="emergency" class="mb-5">
                <div class="emergency-zone shadow-sm">
                    <h2 class="text-danger mt-0">☢️ Emergency Operations</h2>
                    <div class="row mt-3">
                        <div class="col-md-6">
                            <h6>Nuclear Cache Purge (TRUNCATE)</h6>
                            <p class="small text-muted">Instantly resets all tracking and faculty cache modules.</p>
                            <code class="d-block bg-white p-2 border mb-3 text-break">https://sjub.edu.in/emergency_reset.php?key=SJU_RESET_2026</code>
                        </div>
                        <div class="col-md-6">
                            <h6>Terminate AWS Streams</h6>
                            <p class="small text-muted">Kills all active <code>tar</code> and <code>aws</code> S3 streaming processes.</p>
                            <code class="d-block bg-white p-2 border mb-3">pkill -u sjubedu -f "tar|aws|mysqldump"</code>
                        </div>
                    </div>
                </div>
            </section>

            <footer class="mt-5 py-4 border-top text-center text-muted">
                <p>Maintainer: <strong>Jogith Biju</strong> - Web Developer | St. Joseph's University Portal</p>
                <small>&copy; 2026 SJU Infrastructure Suite | Ireland Master's Candidate (Cybersecurity)</small>
            </footer>

        </main>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>