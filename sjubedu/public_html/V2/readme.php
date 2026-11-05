<?php
session_start();

// --- 2. GLOBAL TRACKER INJECTION ---
// This is your Global Security & Tracker Bridge. 
// It must stay here to catch your iPhone's IPv6 address.
if (file_exists('/home/sjubedu/public_html/global_tracker.php')) {
    require_once('/home/sjubedu/public_html/global_tracker.php');
}

/**
 * SJU SYSTEM DOCUMENTATION - PASSWORD PROTECTION
 */
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
<html>
<head>
    <title>SJU Documentation Auth</title>
    <style>
        body { font-family: -apple-system, sans-serif; background: #f4f7f9; display: flex; align-items: center; justify-content: center; height: 100vh; margin: 0; }
        .login-box { background: white; padding: 40px; border-radius: 8px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); text-align: center; width: 350px; }
        input { width: 100%; padding: 12px; margin: 10px 0; border: 1px solid #ddd; border-radius: 4px; box-sizing: border-box; }
        button { background: #0056b3; color: white; border: none; padding: 12px; width: 100%; border-radius: 4px; cursor: pointer; font-weight: bold; }
        .error { color: #d9534f; font-size: 14px; margin-bottom: 10px; }
    </style>
</head>
<body>
    <div class="login-box">
        <h2>🛡️ SJU Admin</h2>
        <p>System Documentation v3.7</p>
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
    <meta charset="UTF-8">
    <title>SJU Master Documentation v3.7</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #ffffff; color: #212529; font-family: 'Segoe UI', Arial, sans-serif; }
        .sidebar { background: #f8f9fa; border-right: 1px solid #dee2e6; height: 100vh; position: fixed; padding: 20px; }
        .main-content { margin-left: 20%; padding: 40px; }
        .card { border: 1px solid #e3e6f0; border-radius: 0.35rem; box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.1); margin-bottom: 30px; }
        .card-header { background-color: #f8f9fc; border-bottom: 1px solid #e3e6f0; font-weight: bold; color: #4e73df; }
        pre { background: #f1f3f5; padding: 15px; border-radius: 5px; border-left: 5px solid #4e73df; color: #2d3436; font-size: 0.9rem; }
        .nav-link { color: #4a5568; font-weight: 500; margin-bottom: 10px; }
        .nav-link:hover { color: #4e73df; background: #e9ecef; border-radius: 5px; }
        .emergency-zone { border: 2px dashed #e74a3b; background: #fff5f5; padding: 20px; border-radius: 10px; }
        .status-badge { font-size: 0.8rem; padding: 5px 10px; border-radius: 20px; background: #d4edda; color: #155724; }
        h2 { color: #2c3e50; border-bottom: 2px solid #4e73df; padding-bottom: 10px; margin-top: 40px; }
        .file-list { font-family: monospace; list-style: none; padding-left: 0; }
        .file-list li::before { content: "📄 "; }
    </style>
</head>
<body>

<div class="container-fluid">
    <div class="row">
        <nav class="col-md-2 sidebar">
            <h4 class="text-primary mb-4">SJU Portal v3.7</h4>
            <div class="nav flex-column nav-pills">
                <a class="nav-link" href="#overview">System Overview</a>
                <a class="nav-link" href="#files">File Architecture</a>
                <a class="nav-link" href="#database">Database Schemas</a>
                <a class="nav-link" href="#automation">Sync & Automation</a>
                <a class="nav-link" href="#emergency">Emergency Reset</a>
                <a class="nav-link" href="#troubleshoot">Troubleshooting</a>
                <hr>
                <a class="nav-link text-danger" href="?logout=1">🚪 Secure Logout</a>
            </div>
        </nav>

        <main class="col-md-10 main-content">
            <div id="overview" class="mb-5">
                <div class="d-flex justify-content-between">
                    <h1>SJU Master Documentation</h1>
                    <div><span class="status-badge">System: Active (2026)</span></div>
                </div>
                <p class="lead">Definitive technical guide for the Middleware and Analytics engine. Optimized for <b>AWS t3.medium</b> instances handling 10,000+ student profiles.</p>
                
                
            </div>

            <section id="files">
                <h2>📂 Detailed File Architecture</h2>
                <div class="row">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">Core Management (v2.1)</div>
                            <div class="card-body">
                                <ul class="file-list">
                                    <li><b>dashboard.php</b>: Real-time stats, Dept. breakdown, Cache monitor.</li>
                                    <li><b>i_db.php</b>: Main profile renderer. Logic for API fallback.</li>
                                    <li><b>config.php</b>: <i>(Critical)</i> Stores API tokens & DB credentials.</li>
                                    <li><b>admin_update.php</b>: Legacy list management interface.</li>
                                    <li><b>settings.php</b>: Configuration GUI for system credentials.</li>
                                    <li><b>maintenance.html</b>: Static page displayed when Maintenance Mode is active.</li>
                                    <li><b>maintenance_watchdog.php</b>: Safety script to auto-disable maintenance mode.</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">Monitoring & Utilities (v3.5)</div>
                            <div class="card-body">
                                <ul class="file-list">
                                    <li><b>global_tracker.php</b>: Silent visitor tracking (PHP PDO).</li>
                                    <li><b>Health_check.php</b>: Cache freshness & server load grading.</li>
                                    <li><b>view_logs.php</b>: Filterable viewer for <code>purge_history.log</code>.</li>
                                    <li><b>emergency_reset.php</b>: Key-gated script for nuclear purge.</li>
                                    <li><b>master_sync.php</b>: Background script for full module synchronization.</li>
                                    <li><b>bulk_import.php</b>: Manual bulk import tool with logging.</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 mt-4">
                        <div class="card">
                            <div class="card-header">Module Generators</div>
                            <div class="card-body">
                                <ul class="file-list">
                                    <li><b>master_generator.php</b>: Unified generator that runs all individual module generators.</li>
                                    <li><b>bulk_*_generator.php</b>: Generates static PHP files for specific modules.</li>
                                    <li><b>bulk_*_live_generator.php</b>: Generates live-fetch versions of module pages.</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section id="database">
                <h2>🛠️ Database Schemas (SQL)</h2>
                
                <div class="card">
                    <div class="card-header">Database 1: Traffic Analytics & Security</div>
                    <div class="card-body">
                        <pre>
CREATE TABLE IF NOT EXISTS active_visitors (
    visitor_hash VARCHAR(64) PRIMARY KEY,
    load_type TEXT NOT NULL,
    ip_address VARCHAR(45) NOT NULL,
    device_type VARCHAR(50),
    location VARCHAR(100) DEFAULT 'Unknown',
    hit_count INT DEFAULT 1,
    last_activity TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX (last_activity)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS banned_ips (
    ip_address VARCHAR(45) PRIMARY KEY,
    banned_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS ip_nicknames (
    ip_address VARCHAR(45) PRIMARY KEY,
    nickname VARCHAR(100) NOT NULL
) ENGINE=InnoDB;

-- 4. Global Settings (Maintenance Mode)
CREATE TABLE IF NOT EXISTS system_settings (
    setting_key VARCHAR(50) PRIMARY KEY,
    setting_value VARCHAR(255)
) ENGINE=InnoDB;

INSERT IGNORE INTO system_settings (setting_key, setting_value) VALUES ('maintenance_mode', 'off');</pre>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">Database 2: Faculty Data Cache (sjubedu_faculty_data)</div>
                    <div class="card-body">
                        <pre>
CREATE TABLE `api_cache` (
  `id` varchar(255) PRIMARY KEY,
  `content` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `fail_count` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Note: Tables phd_cache, publication_cache, project_cache, and awards_cache 
-- follow identical structural logic for modular synchronization.</pre>
                    </div>
                </div>
            </section>

            <section id="automation">
                <h2>🤖 Automation & Terminal Commands</h2>
                <p>Background tasks ensure zero-downtime for students while data refreshes.</p>
                <div class="card">
                    <div class="card-body">
                        <table class="table table-striped">
                            <thead>
                                <tr><th>Objective</th><th>Terminal Command</th></tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Full Background Sync</td>
                                    <td><code>nohup php /home/sjubedu/public_html/Test/master_sync.php > master_sync.log 2>&1 &</code></td>
                                </tr>
                                <tr>
                                    <td>Individual Bulk Import</td>
                                    <td><code>sudo nohup php bulk_import.php > sync_results.log 2>&1 &</code></td>
                                </tr>
                                <tr>
                                    <td>Monitor Progress</td>
                                    <td><code>tail -f sync_results.log</code></td>
                                </tr>
                                <tr>
                                    <td>Scheduled Cron (3AM)</td>
                                    <td><code>0 3 * * * php /path/to/bulk_import.php >> cron_sync.log 2>&1</code></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>

            <section id="emergency" class="mb-5">
                <h2 class="text-danger">☢️ Emergency Reset (Nuclear Option)</h2>
                <div class="emergency-zone">
                    <h4>Protocol Details</h4>
                    <p>Executing the reset script performs a <b>TRUNCATE</b> on <u>all</u> tables in both the Traffic and Faculty databases. This is used only during critical corruption or server overload.</p>
                    <div class="mb-3">
                        <b>Direct URL:</b> <code>https://sjub.edu.in/emergency_reset.php?key=SJU_RESET_2026</code>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <strong>Tables Cleared:</strong>
                            <ul class="small">
                                <li>active_visitors, banned_ips, ip_nicknames</li>
                                <li>api_cache, phd_cache, publication_cache</li>
                                <li>project_cache, awards_cache</li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <strong>System Impact:</strong>
                            <ul class="small">
                                <li>Cache: 100% Cleared (Fresh API fetch required)</li>
                                <li>Logs: Purge recorded in <code>purge_history.log</code></li>
                                <li>Traffic: Counter reset to zero</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </section>

            <section id="troubleshoot" class="mb-5">
                <h2>🔍 Operational Principles</h2>
                <div class="row g-4">
                    <div class="col-md-4">
                        <div class="p-3 border rounded shadow-sm">
                            <h6>Fail-Safe Architecture</h6>
                            <p class="small">If API connectivity fails, the <code>fail_count</code> column increments. The system prevents cache deletion to ensure profile visibility.</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="p-3 border rounded shadow-sm">
                            <h6>Silent Tracking</h6>
                            <p class="small">The <code>global_tracker.php</code> uses a 2-second PDO timeout. If the database is busy, the tracker skips the hit rather than delaying the page load.</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="p-3 border rounded shadow-sm">
                            <h6>AWS Optimization</h6>
                            <p class="small">System health is graded based on CPU load. Grade A: < 1.0, Grade C: 1.8 (Warning), Grade F: > 2.5 (Critical).</p>
                        </div>
                    </div>
                </div>
            </section>

            <footer class="text-center py-5 text-muted border-top">
                &copy; 2026 St. Joseph's University | SJU Faculty Management Suite
            </footer>
        </main>
    </div>
</div>

</body>
</html>