<?php
session_start();

// 1. SECURITY & CONFIG
if (!isset($_SESSION['is_admin']) || !in_array('view_logs', $_SESSION['admin_perms'] ?? [])) {

    header("Location: ../dashboard.php?error=unauthorized"); exit();
}

$config = file_exists('/home/sjubedu/config.php') ? '/home/sjubedu/config.php' : __DIR__ . '/../../config.php';
require_once $config;
date_default_timezone_set('Asia/Kolkata');

try {
    $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4", DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // --- UPPER LIMITS & CONFIGURATION ---
    $cpu_cores = function_exists('processor_count') ? \processor_count() : 2; // Default to 2 for t3.medium
    $max_sessions = 500; // A reasonable upper limit for concurrent sessions on a t3.medium

    function parse_memory_limit($limit_str) {
        if (empty($limit_str)) return 0;
        $limit = (int) $limit_str;
        $unit = strtolower(substr($limit_str, -1));
        switch ($unit) {
            case 'g': $limit *= 1024;
            case 'm': $limit *= 1024;
            case 'k': $limit *= 1024;
        }
        return round($limit / 1024 / 1024); // Return in MB
    }
    $memory_limit_mb = parse_memory_limit(ini_get('memory_limit'));

    // --- HELPER FOR SITE CHECK (cURL is more reliable than fsockopen) ---
    function check_site_status($url) {
        // Return false immediately if cURL is not available on the server.
        if (!function_exists('curl_init')) {
            return false;
        }

        $ch = curl_init($url);
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_NOBODY         => true, // We only need headers
            CURLOPT_TIMEOUT        => 5,    // 5-second total timeout
            CURLOPT_CONNECTTIMEOUT => 2,    // 2-second connection timeout
            CURLOPT_SSL_VERIFYPEER => false, // Ignore SSL cert issues for a simple check
            CURLOPT_FOLLOWLOCATION => true,  // Follow redirects if any
        ]);
        curl_exec($ch);
        
        // If a cURL error occurred (like a timeout), it's down.
        if (curl_errno($ch)) {
            curl_close($ch);
            return false;
        }

        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        return ($http_code >= 200 && $http_code < 400); // True if site is accessible
    }

    /**
     * Tries to execute a command using various available PHP functions.
     * This makes the feature more resilient on servers with custom restrictions.
     * @param string $command The shell command to execute.
     * @param array &$output The array to be filled with the command's output.
     * @param int &$return_var The variable to be filled with the command's return status.
     * @return bool True if a function was attempted, false if all are disabled.
     */
    function resilient_exec($command, &$output, &$return_var) {
        $command_with_error_redirect = $command . ' 2>&1';

        if (function_exists('exec')) {
            exec($command_with_error_redirect, $output, $return_var);
            return true;
        }
        
        if (function_exists('shell_exec')) {
            $output_str = shell_exec($command_with_error_redirect);
            $output = $output_str ? explode("\n", trim($output_str)) : [];
            // shell_exec doesn't provide a reliable return code. We guess based on output.
            $return_var = (strpos(strtolower(implode("\n", $output)), 'permission denied') !== false || strpos(strtolower(implode("\n", $output)), 'not found') !== false) ? 126 : 0;
            return true;
        }

        $output = ["The PHP `exec()` and `shell_exec()` functions are disabled on this server. Please check `disable_functions` in `php.ini`."];
        $return_var = -1;
        return false;
    }

    // --- IDENTIFY ADMIN ---
    $my_ip = $_SERVER['HTTP_CF_CONNECTING_IP'] ?? $_SERVER['REMOTE_ADDR'];

    // --- ACTIONS HANDLER ---
    if (isset($_POST['unban_ip'])) { 
        $stmt = $pdo->prepare("DELETE FROM banned_ips WHERE ip_address = ?");
        $stmt->execute([trim($_POST['unban_ip'])]);
        header("Location: ".$_SERVER['PHP_SELF']); exit(); 
    }
    
    if (isset($_POST['ban_ip'])) { 
        if ($_POST['ban_ip'] !== $my_ip) {
            $stmt = $pdo->prepare("INSERT IGNORE INTO banned_ips (ip_address) VALUES (?)");
            $stmt->execute([trim($_POST['ban_ip'])]);
        }
        header("Location: ".$_SERVER['PHP_SELF']); exit(); 
    }

    if (isset($_POST['reboot_server'])) {
        $output = [];
        $return_var = -1;
        // This requires the web server user (e.g., www-data) to have passwordless sudo permissions.
        // Add to sudoers (via `sudo visudo`): www-data ALL=(ALL) NOPASSWD: /sbin/reboot
        resilient_exec('sudo /sbin/reboot', $output, $return_var);

        if ($return_var === 0) {
            $reboot_msg = "✅ Reboot command issued successfully. The server should restart in a moment.";
            $reboot_msg_class = 'alert-success';
        } else {
            $error_details = !empty($output) ? implode("\n", $output) : 'No output from command.';
            $reboot_msg = "❌ Reboot Failed. Server Error: " . htmlspecialchars($error_details);
            $reboot_msg_class = 'alert-danger';
        }
    }

    if (isset($_POST['save_name'])) {
        $stmt = $pdo->prepare("INSERT INTO ip_nicknames (ip_address, nickname) VALUES (?, ?) ON DUPLICATE KEY UPDATE nickname = ?");
        $stmt->execute([$_POST['ip_to_name'], $_POST['new_nickname'], $_POST['new_nickname']]);
    }

    if (isset($_POST['reset_ip_table'])) { 
        $pdo->exec("TRUNCATE TABLE active_visitors"); 
        header("Location: ".$_SERVER['PHP_SELF']); exit(); 
    }

    // --- VITALS & GRADING ---
    // Safely get system stats, providing defaults if functions are disabled
    $current_cpu = function_exists('sys_getloadavg') ? round(sys_getloadavg()[0], 2) : 0.0;
    $mem_usage = function_exists('memory_get_usage') ? round(memory_get_usage() / 1024 / 1024, 2) : 0.0;
    $disk_total = function_exists('disk_total_space') ? disk_total_space("/") : 0;
    $disk_free = function_exists('disk_free_space') ? disk_free_space("/") : 0;

    // --- UPTIME LOGIC ---
    $uptime_formatted = 'N/A';
    if (is_readable('/proc/uptime')) {
        $uptime_seconds = (float)file_get_contents('/proc/uptime');
        
        $days = floor($uptime_seconds / 86400);
        $hours = floor(($uptime_seconds % 86400) / 3600);
        $minutes = floor(($uptime_seconds % 3600) / 60);

        $parts = [];
        if ($days > 0) $parts[] = $days . 'd';
        if ($hours > 0) $parts[] = $hours . 'h';
        if ($days == 0 && $minutes > 0) $parts[] = $minutes . 'm';
        if (empty($parts) && $uptime_seconds > 0) $parts[] = round($uptime_seconds) . 's';

        $uptime_formatted = implode(' ', $parts);
    }

    $disk_total_gb = $disk_total > 0 ? round($disk_total / (1024**3), 1) : 0;
    $disk_used_gb = $disk_total > 0 ? round(($disk_total - $disk_free) / (1024**3), 1) : 0;
    $disk_used_percent = ($disk_total > 0) ? round((($disk_total - $disk_free) / $disk_total) * 100) : 0;

    $sju_up = check_site_status("https://sju.edu.in");
    $sjub_up = check_site_status("https://sjub.edu.in");

    $cpu_load_percent = ($cpu_cores > 0) ? ($current_cpu / $cpu_cores) * 100 : 0;

    if ($cpu_load_percent > 90) { $grade = "F"; $color = "#dc3545"; $msg = "CRITICAL LOAD"; }
    elseif (!$sju_up || !$sjub_up) { $grade = "D"; $color = "#fd7e14"; $msg = "SITE DOWN"; }
    elseif ($disk_used_percent > 95) { $grade = "C"; $color = "#ffc107"; $msg = "DISK FULL"; }
    elseif ($cpu_load_percent > 70) { $grade = "B"; $color = "#0dcaf0"; $msg = "MODERATE LOAD"; }
    else { $grade = "A"; $color = "#198754"; $msg = "OPTIMAL"; }

    // --- CHART LOGIC ---
    // --- Server Profile ---
    $server_profile_name = "Generic Profile";
    $server_profile_desc = "$cpu_cores Cores Detected";
    if ($cpu_cores == 2) {
        $server_profile_name = "AWS t3.medium";
        $server_profile_desc = "2 vCPUs, Burstable";
    }

    $raw_graph = $pdo->query("SELECT HOUR(last_activity) as hr, SUM(hit_count) as total FROM active_visitors WHERE last_activity > NOW() - INTERVAL 24 HOUR GROUP BY hr ORDER BY hr ASC")->fetchAll(PDO::FETCH_KEY_PAIR);
    $chart_labels = []; $chart_data = []; $max_hits = 0; $peak_index = 0; $current_hour = (int)date('G');
    for ($i = -23; $i <= 0; $i++) {
        $h = ($current_hour + $i + 24) % 24;
        $label = ($h == 0) ? "12AM" : (($h > 12) ? ($h-12)."PM" : $h."AM");
        $chart_labels[] = $label;
        $val = $raw_graph[$h] ?? 0;
        $chart_data[] = $val;
        if ($val >= $max_hits && $val > 0) { $max_hits = $val; $peak_index = count($chart_data) - 1; }
    }

    // --- DATA FETCHING ---
    $search = $_GET['search'] ?? '';
    
    // 1. ACTIVE USERS
    $feed_stmt = $pdo->prepare("SELECT v.*, n.nickname, TIMESTAMPDIFF(SECOND, v.last_activity, NOW()) as sec_ago FROM active_visitors v LEFT JOIN ip_nicknames n ON v.ip_address = n.ip_address WHERE (v.ip_address LIKE :s OR n.nickname LIKE :s) AND v.ip_address NOT IN (SELECT ip_address FROM banned_ips) ORDER BY last_activity DESC LIMIT 50");
    $feed_stmt->execute([':s' => "%$search%"]);
    $active_feed = $feed_stmt->fetchAll(PDO::FETCH_ASSOC);

    // 2. BLOCKED REGISTRY (THE FIX: Removed 'ORDER BY id')
    $blocked_registry = $pdo->query("SELECT * FROM banned_ips ORDER BY ip_address ASC")->fetchAll(PDO::FETCH_ASSOC);

    // 3. STATS
    $top_pages = $pdo->query("SELECT load_type, SUM(hit_count) as total FROM active_visitors WHERE last_activity > NOW() - INTERVAL 24 HOUR GROUP BY load_type ORDER BY total DESC LIMIT 5")->fetchAll(PDO::FETCH_ASSOC);
    $sessions_active = $pdo->query("SELECT COUNT(*) FROM active_visitors WHERE last_activity > NOW() - INTERVAL 15 MINUTE")->fetchColumn();

} catch (Exception $e) { $error_msg = $e->getMessage(); }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include $_SERVER['DOCUMENT_ROOT'] . '/gtm.php'; ?>
    <meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="refresh" content="30">
    <title>SJU Master Monitor</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { background: #f0f2f5; font-family: -apple-system, sans-serif; }
        .card { border: none; border-radius: 16px; box-shadow: 0 4px 12px rgba(0,0,0,0.05); }
        .block-card { padding: 1rem; text-align: center; min-height: 110px; display: flex; flex-direction: column; justify-content: center; }
        .grade-val { font-size: 2.8rem; font-weight: 900; line-height: 1; }
        .x-small { font-size: 0.65rem; text-transform: uppercase; font-weight: 800; }
        .ip-text { font-family: monospace; font-size: 0.72rem; word-break: break-all; }
        .carrier-tag { font-size: 0.6rem; background: #e9ecef; padding: 2px 6px; border-radius: 4px; font-weight: bold; color: #6c757d; }
    </style>
</head>
<body>

<nav class="navbar bg-white border-bottom mb-3 sticky-top">
    <div class="container-fluid px-3">
        <span class="navbar-brand fw-bold text-primary">SJU MONITOR</span>
        <div class="d-flex align-items-center">
            <span class="small text-muted me-3">My IP: <code><?php echo $my_ip; ?></code></span>
            <a href="../dashboard.php" class="btn btn-dark btn-sm rounded-pill px-3">Exit</a>
        </div>
    </div>
</nav>

<div class="container-fluid px-3">
    <?php if (isset($reboot_msg, $reboot_msg_class)): ?>
        <div class="alert <?php echo $reboot_msg_class; ?>"><?php echo $reboot_msg; ?></div>
    <?php endif; ?>

    <div class="row row-cols-2 row-cols-md-4 row-cols-lg-7 g-2 mb-3 text-center">
        <div class="col">
            <div class="card block-card" style="background: <?php echo $color; ?>15; border: 1px solid <?php echo $color; ?>;">
                <span class="text-muted x-small">HEALTH</span>
                <div class="grade-val" style="color: <?php echo $color; ?>;"><?php echo $grade; ?></div>
                <small class="fw-bold x-small" style="color: <?php echo $color; ?>;"><?php echo $msg; ?></small>
            </div>
        </div>
        <div class="col">
            <div class="card block-card bg-white">
                <span class="text-muted x-small">CPU LOAD</span>
                <div class="h4 m-0 fw-bold"><?php echo $current_cpu; ?> / <small class="text-muted"><?php echo $cpu_cores; ?> Cores</small></div>
            </div>
        </div>
        <div class="col">
            <div class="card block-card bg-white">
                <span class="text-muted x-small">PHP MEMORY</span>
                <div class="h4 m-0 fw-bold text-info"><?php echo $mem_usage; ?> / <small class="text-muted"><?php echo $memory_limit_mb; ?> MB</small></div>
            </div>
        </div>
        <div class="col">
            <div class="card block-card bg-white">
                <span class="text-muted x-small">DISK USAGE</span>
                <div class="h4 m-0 fw-bold"><?php echo $disk_used_gb; ?> / <small class="text-muted"><?php echo $disk_total_gb; ?> GB</small></div>
            </div>
        </div>
        <div class="col">
            <div class="card block-card bg-white">
                <span class="text-muted x-small">SESSIONS (15m)</span>
                <div class="h4 m-0 fw-bold text-primary"><?php echo $sessions_active; ?> / <small class="text-muted"><?php echo $max_sessions; ?></small></div>
            </div>
        </div>
        <div class="col">
            <div class="card block-card bg-white">
                <span class="text-muted x-small">UPTIME</span>
                <div class="h4 m-0 fw-bold text-success"><?php echo $uptime_formatted; ?></div>
            </div>
        </div>
        <div class="col">
            <div class="card block-card bg-white">
                <span class="text-muted x-small">NETWORK STATUS</span>
                <div class="d-flex justify-content-around align-items-center mt-1 pt-1 w-100">
                    <div class='text-center'>
                        <a href="https://sju.edu.in" target="_blank" class="text-decoration-none text-body"><span class="fw-bold small">sju.edu.in</span></a><br>
                        <span class="badge <?php echo $sju_up ? 'bg-success' : 'bg-danger'; ?>"><?php echo $sju_up ? 'UP' : 'DOWN'; ?></span>
                    </div>
                    <div class='text-center'>
                        <a href="https://sjub.edu.in" target="_blank" class="text-decoration-none text-body"><span class="fw-bold small">sjub.edu.in</span></a><br>
                        <span class="badge <?php echo $sjub_up ? 'bg-success' : 'bg-danger'; ?>"><?php echo $sjub_up ? 'UP' : 'DOWN'; ?></span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-3">
        <div class="col-lg-8">
            <div class="card p-3 mb-3 bg-white">
                <div class="d-flex align-items-center">
                    <div class="flex-grow-1">
                        <canvas id="trafficChart" height="130"></canvas>
                    </div>
                    <div class="ps-4 text-center border-start">
                        <span class="text-muted x-small">SERVER PROFILE</span>
                        <div class="h5 m-0 fw-bold"><?php echo $server_profile_name; ?></div>
                        <small class="text-muted"><?php echo $server_profile_desc; ?></small>
                    </div>
                </div>
            </div>
            
            <form class="card p-2 mb-3 flex-row gap-2" method="GET">
                <input type="text" name="search" value="<?php echo htmlspecialchars($search); ?>" class="form-control form-control-sm" placeholder="Search IP/Name...">
                <button type="submit" class="btn btn-sm btn-primary px-3">Filter</button>
            </form>

            <div class="card overflow-hidden">
                <div class="table-responsive">
                    <table class="table align-middle m-0 small text-center">
                        <thead class="bg-light text-muted x-small"><tr><th>DEV</th><th>IDENTITY</th><th>TIME</th><th>MANAGE</th></tr></thead>
                        <tbody>
                            <?php foreach($active_feed as $v): 
                                $t = ($v['sec_ago'] < 60) ? $v['sec_ago'].'s' : round($v['sec_ago']/60).'m';
                                $is_me = ($v['ip_address'] === $my_ip); 
                            ?>
                            <tr class="<?php echo $is_me ? 'table-info' : ''; ?>">
                                <td><i class="fa fa-mobile-alt text-primary"></i></td>
                                <td class="text-start">
                                    <?php if(!empty($v['nickname'])): ?><strong class="text-primary"><?php echo htmlspecialchars($v['nickname']); ?></strong><br><?php endif; ?>
                                    <span class="ip-text"><?php echo htmlspecialchars($v['ip_address']); ?></span><br><span class="carrier-tag"><?php echo htmlspecialchars($v['carrier'] ?? 'ISP'); ?></span>
                                </td>
                                <td><span class="badge bg-light text-dark fw-normal"><?php echo $t; ?></span></td>
                                <td>
                                    <form method="POST" class="d-flex gap-1 justify-content-center">
                                        <?php if($is_me): ?>
                                            <span class="badge bg-success py-2 px-3">ME</span>
                                            <input type="text" name="new_nickname" placeholder="Name" class="form-control form-control-sm" style="width: 50px;">
                                            <button name="save_name" class="btn btn-sm btn-light border p-1"><i class="fa fa-tag"></i></button>
                                        <?php else: ?>
                                            <input type="text" name="new_nickname" placeholder="Label" class="form-control form-control-sm" style="width: 50px;">
                                            <input type="hidden" name="ip_to_name" value="<?php echo $v['ip_address']; ?>">
                                            <button name="save_name" class="btn btn-sm btn-light border p-1"><i class="fa fa-tag"></i></button>
                                            <button name="ban_ip" value="<?php echo $v['ip_address']; ?>" class="btn btn-sm btn-outline-danger border-0 p-1"><i class="fa fa-ban"></i></button>
                                        <?php endif; ?>
                                    </form>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card border-danger mb-3">
                <div class="card-header bg-danger text-white py-2 fw-bold x-small text-center">🛡️ BLOCKED REGISTRY</div>
                <div class="card-body p-0" style="max-height: 400px; overflow-y: auto;">
                    <table class="table m-0 small table-striped">
                        <?php if(empty($blocked_registry)): ?>
                            <tr><td class="text-center py-4 text-muted x-small">Registry Empty</td></tr>
                        <?php else: foreach($blocked_registry as $b): ?>
                            <tr>
                                <td class="py-2 ps-3">
                                    <span class="ip-text text-danger fw-bold"><?php echo $b['ip_address']; ?></span>
                                </td>
                                <td class="text-end pe-3">
                                    <form method="POST">
                                        <input type="hidden" name="unban_ip" value="<?php echo $b['ip_address']; ?>">
                                        <button class="btn btn-sm btn-success fw-bold px-2 py-0" style="font-size: 0.7rem;">ALLOW</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; endif; ?>
                    </table>
                </div>
            </div>

            <div class="card p-3 mb-3">
                <h6 class="fw-bold x-small text-muted mb-3">Top Pages (24H)</h6>
                <?php foreach($top_pages as $p): ?>
                <div class="d-flex justify-content-between border-bottom py-2 small">
                    <a href="<?php echo htmlspecialchars($p['load_type']); ?>" target="_blank" class="text-decoration-none text-truncate" style="max-width: 140px;"><?php echo htmlspecialchars(basename($p['load_type'])); ?></a>
                    <strong class="text-primary"><?php echo $p['total']; ?></strong>
                </div>
                <?php endforeach; ?>
            </div>

            <div class="card border-danger mb-3">
                <div class="card-header bg-danger text-white py-2 fw-bold x-small text-center">SERVER CONTROL</div>
                <div class="card-body p-2">
                    <form method="POST" onsubmit="return confirm('CRITICAL: Are you sure you want to reboot the entire server?');">
                        <button name="reboot_server" class="btn btn-danger w-100 fw-bold">
                            <i class="fa fa-power-off me-2"></i> REBOOT SERVER
                        </button>
                    </form>
                </div>
            </div>

            <form method="POST" onsubmit="return confirm('Reset analytics?');"><button name="reset_ip_table" class="btn btn-warning btn-sm w-100 fw-bold x-small text-dark">RESET TRACKING</button></form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
new Chart(document.getElementById('trafficChart'), {
    type: 'line',
    data: {
        labels: <?php echo json_encode($chart_labels); ?>,
        datasets: [{ 
            data: <?php echo json_encode($chart_data); ?>, 
            borderColor: '<?php echo $color; ?>', borderWidth: 2, fill: true, backgroundColor: '<?php echo $color; ?>10', tension: 0.3,
            pointRadius: (ctx) => ctx.dataIndex === <?php echo $peak_index; ?> ? 6 : 0,
            pointBackgroundColor: '<?php echo $color; ?>', pointBorderColor: '#fff', pointBorderWidth: 2
        }]
    },
    options: { plugins: { legend: { display: false }, tooltip: { callbacks: { label: (c) => c.parsed.y + ' Hits' } } }, scales: { y: { beginAtZero: true, grid: { color: 'rgba(0,0,0,0.05)' } } } }
});
</script>
</body>
</html>