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
        .sidebar { background: #f8f9fa; border-right: 1px solid #dee2e6; height: 100vh; position: fixed; padding: 20px; overflow-y: auto; }
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
                <a class="nav-link" href="#overview">Overview</a>
                <a class="nav-link" href="#features">Key Features</a>
                <a class="nav-link" href="#files">File Structure</a>
                <a class="nav-link" href="#config">Configuration</a>
                <a class="nav-link" href="#database">Database Schema</a>
                <a class="nav-link" href="#automation">Automation</a>
                <a class="nav-link" href="#emergency">Emergency</a>
                <a class="nav-link" href="#infrastructure">Infrastructure</a>
                <hr>
                <a class="nav-link text-danger" href="?logout=1">🚪 Secure Logout</a>
            </div>
        </nav>

        <main class="col-md-10 main-content">
            <div id="overview" class="mb-5">
                <h1>🛡️ SJU Faculty Portal: Management & Master Monitor Suite (v3.7)</h1>
                <p class="lead"><strong>A High-Performance Middleware, Centralized Profile Manager & Traffic Analytics System.</strong></p>
                <p>This system acts as a high-availability bridge between the <strong>Linways API</strong> and the SJU public portal. Designed for the <strong>AWS t3.medium</strong> environment, it ensures that faculty profiles remain accessible to <strong>10,000+ students</strong> even during upstream API failures or server resource spikes.</p>
            </div>

            <section id="features" class="mb-5">
                <h2>🚀 Key Features</h2>
                <div class="row">
                    <div class="col-md-4">
                        <div class="card h-100">
                            <div class="card-header">1. Faculty Profile Management (v2.1)</div>
                            <div class="card-body">
                                <ul>
                                    <li><strong>Resilient Caching:</strong> Served via local MySQL. Extends data life during API failures.</li>
                                    <li><strong>Zero-Downtime Sync:</strong> Uses <code>REPLACE INTO</code> to avoid table locking.</li>
                                    <li><strong>Multi-Module Cache:</strong> Separate tables for Faculty, PhD, Publications, etc.</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card h-100">
                            <div class="card-header">2. Master Monitor & Security (v3.5)</div>
                            <div class="card-body">
                                <ul>
                                    <li><strong>Intelligent Health Grading:</strong> A-F scoring based on CPU load (Crit > 2.5).</li>
                                    <li><strong>Silent Error Engine:</strong> 2s DB timeout ensures monitoring never blocks user traffic.</li>
                                    <li><strong>Cybersecurity:</strong> IP nicknaming, bulk blocking, Cloudflare IP restoration.</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card h-100">
                            <div class="card-header">3. Emergency Recovery (v3.6)</div>
                            <div class="card-body">
                                <ul>
                                    <li><strong>Nuclear Reset:</strong> Secure key-gated script to wipe all cache and traffic tables instantly in case of corruption.</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section id="files" class="mb-5">
                <h2>📂 File Structure</h2>
                
                <h5 class="mt-4">Core Management & Profiles</h5>
                <ul class="file-list">
                    <li><code>dashboard.php</code>: Main control panel for stats, API latency, and logs.</li>
                    <li><code>i_db.php</code>: Public-facing profile template; handles the fallback logic.</li>
                    <li><code>config.php</code>: Sensitive credentials (stored above the public root for security).</li>
                    <li><code>maintenance.html</code>: Static page displayed when Maintenance Mode is active.</li>
                    <li><code>emergency_reset.php</code>: Nuclear option to wipe all databases (<code>key</code> required).</li>
                    <li><code>maintenance_watchdog.php</code>: Safety script to auto-disable maintenance mode after 2 hours.</li>
                </ul>

                <h5 class="mt-4">Monitoring & Automation</h5>
                <ul class="file-list">
                    <li><code>global_tracker.php</code>: The "Silent" tracking engine included in all profile headers.</li>
                    <li><code>Health_check.php</code>: Visual dashboard for cache freshness and server load.</li>
                    <li><code>master_sync.php</code>: Background script for full module synchronization.</li>
                    <li><code>bulk_import.php</code>: Manual bulk import tool with logging.</li>
                </ul>

                <h5 class="mt-4">Module Generators</h5>
                <ul class="file-list">
                    <li><code>master_generator.php</code>: Unified generator that runs all individual module generators in sequence.</li>
                    <li><code>bulk_*_generator.php</code>: Generates static PHP files for specific modules.</li>
                    <li><code>bulk_*_live_generator.php</code>: Generates live-fetch versions of module pages.</li>
                </ul>

                <h5 class="mt-4">Database & Sync Workers</h5>
                <ul class="file-list">
                    <li><code>cron_update_all.php</code>: Primary sync script for Faculty Profiles (populates <code>api_cache</code>).</li>
                    <li><code>bulk_*_cron.php</code>: Modular background scripts for specific tables (e.g., <code>phd_cache</code>).</li>
                    <li><code>force_purge.php</code>: Emergency utility to truncate the main cache table.</li>
                    <li><code>db_speed_test.php</code>: Benchmarks database connection and query latency.</li>
                </ul>

                <div class="card mt-3">
                    <div class="card-header">Difference: <code>cron_update_all.php</code> vs <code>bulk_import.php</code></div>
                    <div class="card-body p-0">
                        <table class="table table-striped mb-0">
                            <thead><tr><th>Feature</th><th>cron_update_all.php</th><th>bulk_import.php</th></tr></thead>
                            <tbody>
                                <tr><td>Primary Purpose</td><td><strong>Automated Sync:</strong> CLI / Server Cron.</td><td><strong>Manual Sync:</strong> Admin Browser.</td></tr>
                                <tr><td>Output</td><td>Plain text logs.</td><td>Visual HTML progress bar.</td></tr>
                                <tr><td>Rate Limiting</td><td>Aggressive (0.3s delay).</td><td>Conservative (0.9s delay).</td></tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>

            <section id="config" class="mb-5">
                <h2>⚙️ Configuration Core (config.php)</h2>
                <p>The <code>config.php</code> file is the <strong>heart</strong> of the system. It is located <strong>outside</strong> the public HTML directory for security.</p>
                <ul>
                    <li><strong>Credentials:</strong> Stores MySQL login details and Linways API Token.</li>
                    <li><strong>Form IDs:</strong> Centralized mapping of Linways Form IDs for all modules.</li>
                    <li><strong>Department List:</strong> Master array of Department IDs and Names.</li>
                    <li><strong>Security Layer:</strong> Includes IP Restoration (Cloudflare), Firewall (Banned IPs), and Global Tracker.</li>
                </ul>
            </section>

            <section id="database" class="mb-5">
                <h2>🛠️ Database Schemas (SQL)</h2>
                <div class="card">
                    <div class="card-header">Database 1: Traffic Analytics & Security</div>
                    <div class="card-body">
<pre>CREATE TABLE IF NOT EXISTS active_visitors (
    visitor_hash VARCHAR(64) PRIMARY KEY,
    load_type TEXT NOT NULL,
    ip_address VARCHAR(45) NOT NULL,
    device_type VARCHAR(50) NOT NULL,
    carrier VARCHAR(100) DEFAULT 'Unknown',
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

CREATE TABLE IF NOT EXISTS system_settings (
    setting_key VARCHAR(50) PRIMARY KEY,
    setting_value VARCHAR(255)
) ENGINE=InnoDB;

INSERT IGNORE INTO system_settings (setting_key, setting_value) VALUES ('maintenance_mode', 'off');</pre>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">Database 2: Faculty Data Cache</div>
                    <div class="card-body">
<pre>CREATE TABLE `api_cache` (
  `id` varchar(255) PRIMARY KEY,
  `content` longtext NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `fail_count` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
-- Also includes: phd_cache, publication_cache, project_cache, awards_cache, etc.</pre>
                    </div>
                </div>
            </section>

            <section id="automation" class="mb-5">
                <h2>🤖 Automation & Background Commands</h2>
                
                <h5 class="mt-3">Manual Master Sync</h5>
                <pre>nohup php /home/sjubedu/public_html/Test/master_sync.php > /home/sjubedu/public_html/Test/master_sync.log 2>&1 &</pre>

                <h5 class="mt-3">Background Bulk Import</h5>
                <pre>sudo nohup php /home/sjubedu/public_html/Test/bulk_import.php > /home/sjubedu/public_html/Test/sync_results.log 2>&1 &</pre>

                <h5 class="mt-3">Process Management</h5>
                <ul>
                    <li><strong>Check Progress:</strong> <code>tail -f /home/sjubedu/public_html/Test/sync_results.log</code></li>
                    <li><strong>Kill Active Sync:</strong> <code>sudo pkill -f bulk_import.php</code></li>
                </ul>
            </section>

            <section id="emergency" class="mb-5">
                <h2 class="text-danger">☢️ Emergency Reset (Nuclear Option)</h2>
                <p>In the event of critical database corruption or a massive security event, use the Emergency Reset tool. This will <strong>TRUNCATE</strong> all traffic and faculty cache tables.</p>
                <ul>
                    <li><strong>URL:</strong> <code>https://sjub.edu.in/emergency_reset.php?key=SJU_RESET_2026</code></li>
                    <li><strong>Action:</strong> Clears <code>active_visitors</code>, <code>banned_ips</code>, <code>ip_nicknames</code>, and all faculty modules.</li>
                    <li><strong>Log:</strong> Recorded in <code>purge_history.log</code>.</li>
                </ul>
            </section>

            <section id="troubleshoot" class="mb-5">
                <h2>🔍 Troubleshooting & Operational Principles</h2>
                <ol>
                    <li><strong>Fail-Safe Mode:</strong> If <code>fail_count</code> increases, API is unstable. System serves "Old Data" to protect frontend.</li>
                    <li><strong>Performance Priority:</strong> If server hits <strong>"F" Grade</strong>, monitor prioritizes profile loading over tracking.</li>
                    <li><strong>Permissions:</strong> Web server needs write access to logs and cache directory.</li>
                </ol>
            </section>

            <hr>

            <section id="infrastructure" class="mb-5">
                <h1>🎓 Infrastructure & Performance Optimization</h1>
                <p>
                    <img src="https://img.shields.io/website?down_color=red&down_message=offline&label=Server%20Status&up_color=green&up_message=online&url=https%3A%2F%2Fsjub.edu.in%2F" alt="Status">
                    <img src="https://img.shields.io/badge/PHP-8.x-blue" alt="PHP">
                    <img src="https://img.shields.io/badge/Architecture-AWS%20EC2-orange" alt="AWS">
                </p>

                <h3>🏗 System Architecture</h3>
                <ul>
                    <li><strong>Server:</strong> AWS EC2 (AlmaLinux 9.x / WHM)</li>
                    <li><strong>Hardware:</strong> 4GB RAM / SSD (t3.medium class)</li>
                    <li><strong>Security:</strong> Cloudflare Proxy (WAF, SSL/TLS 1.3)</li>
                    <li><strong>Stack:</strong> Apache 2.4 + PHP-FPM 8.x</li>
                </ul>

                <h3>⚙️ Core Stack Optimization</h3>
                <div class="card mb-3">
                    <div class="card-header">PHP-FPM Pool Config</div>
                    <div class="card-body p-0">
                        <table class="table table-bordered mb-0">
                            <thead><tr><th>Setting</th><th>Value</th><th>Justification</th></tr></thead>
                            <tbody>
                                <tr><td>pm.max_children</td><td>30</td><td>Balance CPU/Network for 146KB payloads.</td></tr>
                                <tr><td>pm.max_requests</td><td>500</td><td>Recycles processes to prevent leaks.</td></tr>
                                <tr><td>memory_limit</td><td>128M</td><td>Optimized for 30-worker pool on 4GB RAM.</td></tr>
                                <tr><td>max_execution_time</td><td>90s</td><td>Ensures scripts complete during spikes.</td></tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <h3>🚀 Performance Benchmarking</h3>
                <p>Tested with <strong>Apache Benchmark (ab)</strong>.</p>
                <pre>ab -n 500 -c 30 https://sjub.edu.in/index2.php</pre>
                
                <table class="table table-sm">
                    <thead><tr><th>Endpoint</th><th>Concurrency</th><th>Success</th><th>Latency (90%)</th></tr></thead>
                    <tbody>
                        <tr><td>Static (Home)</td><td>100</td><td>100%</td><td>< 800ms</td></tr>
                        <tr><td>Dynamic (Portal)</td><td>30</td><td>100%</td><td>~2.5s</td></tr>
                    </tbody>
                </table>
                <div class="alert alert-info">
                    <strong>Capacity Verdict:</strong> Handles <strong>30 concurrent DB requests</strong> (approx. 450-600 active users) without failure.
                </div>

                <h3>📉 Bottleneck Analysis & Fixes</h3>
                <ul>
                    <li><strong>SSL Read Failed:</strong> Fixed by setting <code>net.core.somaxconn = 4096</code>.</li>
                    <li><strong>MaxRequestWorkers:</strong> Increased Apache limit to <strong>500</strong>.</li>
                    <li><strong>Timeouts:</strong> Capped PHP workers to 30 to avoid network saturation.</li>
                </ul>

                <h3>🛡️ Security Hardening</h3>
                <p>Disabled functions: <code>exec, system, passthru, shell_exec, popen, proc_open</code></p>

                <h3>🔮 Future Improvements</h3>
                <ul>
                    <li><strong>Redis:</strong> Object caching for session management.</li>
                    <li><strong>Horizontal Scaling:</strong> Upgrade to 8GB RAM / scale workers to 60.</li>
                    <li><strong>Gzip/Brotli:</strong> Verify compression is active.</li>
                </ul>
            </section>

            <section id="maintainer" class="mb-5 text-center">
                <div class="card bg-light">
                    <div class="card-body">
                        <h5>👨‍💻 Maintainer</h5>
                        <p class="mb-1"><strong>Jogith Biju</strong> - Web Developer</p>
                        <a href="https://www.linkedin.com/in/jogith-biju/" target="_blank">LinkedIn Profile</a>
                    </div>
                </div>
            </section>

            <footer class="text-center py-5 text-muted border-top">
                &copy; 2026 St. Joseph's University | SJU Faculty Management Suite | Infrastructure Tested & Validated
            </footer>
        </main>
    </div>
</div>

</body>
</html>