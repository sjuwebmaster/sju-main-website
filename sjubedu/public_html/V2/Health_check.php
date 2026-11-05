<?php
session_start();

// 1. SECURITY & CONFIG
if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== true) {
    header("Location: ../dashboard.php?error=unauthorized"); exit();
}

// Only superadmins can access physical server controls
if (!isset($_SESSION['admin_role']) || $_SESSION['admin_role'] !== 'superadmin') {
    die("Access Denied: Superadmin privileges required.");
}

$config = file_exists('/home/sjubedu/config.php') ? '/home/sjubedu/config.php' : __DIR__ . '/../../config.php';
require_once $config;
date_default_timezone_set('Asia/Kolkata');

// --- UPPER LIMITS & CONFIGURATION ---
$cpu_cores = function_exists('processor_count') ? \processor_count() : 2;
$max_sessions = 500;

function parse_memory_limit($limit_str) {
    if (empty($limit_str)) return 0;
    $limit = (int) $limit_str;
    $unit = strtolower(substr($limit_str, -1));
    switch ($unit) {
        case 'g': $limit *= 1024;
        case 'm': $limit *= 1024;
        case 'k': $limit *= 1024;
    }
    return round($limit / 1024 / 1024);
}
$memory_limit_mb = parse_memory_limit(ini_get('memory_limit'));

// --- HELPER FUNCTIONS ---
function check_site_status($url) {
    if (!function_exists('curl_init')) return false;
    $ch = curl_init($url);
    curl_setopt_array($ch, [CURLOPT_RETURNTRANSFER => true, CURLOPT_NOBODY => true, CURLOPT_TIMEOUT => 5, CURLOPT_CONNECTTIMEOUT => 2, CURLOPT_SSL_VERIFYPEER => false, CURLOPT_FOLLOWLOCATION => true]);
    curl_exec($ch);
    if (curl_errno($ch)) { curl_close($ch); return false; }
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    return ($http_code >= 200 && $http_code < 400);
}

function resilient_exec($command, &$output, &$return_var) {
    $command_with_error_redirect = $command . ' 2>&1';
    if (function_exists('exec')) {
        exec($command_with_error_redirect, $output, $return_var);
        return true;
    }
    if (function_exists('shell_exec')) {
        $output_str = shell_exec($command_with_error_redirect);
        $output = $output_str ? explode("\n", trim($output_str)) : [];
        $return_var = (strpos(strtolower(implode("\n", $output)), 'permission denied') !== false || strpos(strtolower(implode("\n", $output)), 'not found') !== false) ? 126 : 0;
        return true;
    }
    $output = ["The PHP `exec()` and `shell_exec()` functions are disabled on this server."];
    $return_var = -1;
    return false;
}

// --- FILE PATHS & ADMIN IDENTIFICATION ---
$my_ip = $_SERVER['HTTP_CF_CONNECTING_IP'] ?? $_SERVER['REMOTE_ADDR'];
$base_dir = dirname($config);
$blocked_file = $base_dir . '/blocked_ips.txt';
$nicknames_file = $base_dir . '/ip_nicknames.json';
$log_file = $base_dir . '/visitor_log.txt';

// --- ACTIONS HANDLER ---
if (isset($_POST['unban_ip'])) { 
    $ip_to_unban = trim($_POST['unban_ip']);
    if (file_exists($blocked_file)) {
        $lines = file($blocked_file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        $lines = array_filter($lines, function($line) use ($ip_to_unban) { return trim($line) !== $ip_to_unban; });
        file_put_contents($blocked_file, implode("\n", $lines) . (empty($lines) ? "" : "\n"));
    }
    header("Location: ".$_SERVER['PHP_SELF']); exit(); 
}

if (isset($_POST['ban_ip'])) { 
    $ip_to_ban = trim($_POST['ban_ip']);
    if ($ip_to_ban !== $my_ip) {
        $lines = file_exists($blocked_file) ? file($blocked_file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) : [];
        if (!in_array($ip_to_ban, array_map('trim', $lines))) {
            file_put_contents($blocked_file, $ip_to_ban . "\n", FILE_APPEND);
        }
    }
    header("Location: ".$_SERVER['PHP_SELF']); exit(); 
}

if (isset($_POST['save_name'])) {
    $nicknames = file_exists($nicknames_file) ? json_decode(file_get_contents($nicknames_file), true) : [];
    if (!is_array($nicknames)) $nicknames = [];
    $ip_to_name = trim($_POST['ip_to_name']);
    $new_nickname = trim($_POST['new_nickname']);
    if (!empty($ip_to_name) && !empty($new_nickname)) {
        $nicknames[$ip_to_name] = $new_nickname;
        file_put_contents($nicknames_file, json_encode($nicknames, JSON_PRETTY_PRINT));
    }
    header("Location: ".$_SERVER['PHP_SELF']); exit();
}

if (isset($_POST['reboot_server'])) {
    $output = []; $return_var = -1;
    // This requires the web server user (e.g., www-data) to have passwordless sudo permissions.
    // Add to sudoers (via `sudo visudo`): www-data ALL=(ALL) NOPASSWD: /sbin/reboot
    resilient_exec('sudo /sbin/reboot', $output, $return_var);
    if ($return_var === 0) {
        $reboot_msg = "✅ Reboot command issued successfully."; $reboot_msg_class = 'alert-success';
    } else {
        $error_details = !empty($output) ? implode("\n", $output) : 'No output.';
        $reboot_msg = "❌ Reboot Failed. Error: " . htmlspecialchars($error_details); $reboot_msg_class = 'alert-danger';
    }
}

if (isset($_POST['reset_ip_table'])) { 
    if (file_exists($log_file)) file_put_contents($log_file, '');
    header("Location: ".$_SERVER['PHP_SELF']); exit(); 
}

// --- DATE RANGE FILTERING ---
$start_date_str = $_GET['start_date'] ?? date('Y-m-d', strtotime('-1 month'));
$end_date_str = $_GET['end_date'] ?? date('Y-m-d');
$start_timestamp = strtotime($start_date_str . ' 00:00:00');
$end_timestamp = strtotime($end_date_str . ' 23:59:59');
// ... (reboot_server logic remains the same)

// --- VITALS & GRADING (No DB dependency) ---
$current_cpu = function_exists('sys_getloadavg') ? round(sys_getloadavg()[0], 2) : 0.0;
$mem_usage = function_exists('memory_get_usage') ? round(memory_get_usage() / 1024 / 1024, 2) : 0.0;
$disk_total = function_exists('disk_total_space') ? disk_total_space("/") : 0;
$disk_free = function_exists('disk_free_space') ? disk_free_space("/") : 0;
$uptime_formatted = 'N/A';
if (is_readable('/proc/uptime')) {
    $uptime_seconds = (float)file_get_contents('/proc/uptime');
    $days = floor($uptime_seconds / 86400); $hours = floor(($uptime_seconds % 86400) / 3600); $minutes = floor(($uptime_seconds % 3600) / 60);
    $parts = [];
    if ($days > 0) $parts[] = $days . 'd'; if ($hours > 0) $parts[] = $hours . 'h'; if ($days == 0 && $minutes > 0) $parts[] = $minutes . 'm'; if (empty($parts) && $uptime_seconds > 0) $parts[] = round($uptime_seconds) . 's';
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

// --- DATA PROCESSING (FILE-BASED) ---
$search = $_GET['search'] ?? '';
$active_visitors = [];
$page_hits = [];
$hourly_hits = array_fill(0, 24, 0);
$active_ips_1h = [];
$now = time();
$twenty_four_hours_ago = $now - (24 * 3600);
$fifteen_minutes_ago = $now - (15 * 60);
$one_hour_ago = $now - 3600;

 $unique_visitors_in_selected_range = []; // New variable for unique visitors in selected date range
if (file_exists($log_file)) {
    $handle = fopen($log_file, "r");
    if ($handle) {
        while (($line = fgets($handle)) !== false) { // Process all entries for potential date filtering
            $entry = json_decode(trim($line), true);
            if (!$entry || !isset($entry['timestamp']) || $entry['timestamp'] < $twenty_four_hours_ago) continue;

            $hash = $entry['hash'];
            if (!isset($active_visitors[$hash])) {
                $active_visitors[$hash] = ['hit_count' => 0, 'ip_address' => $entry['ip'], 'device_type' => $entry['device']];
            }
            $active_visitors[$hash]['hit_count']++;
            $active_visitors[$hash]['last_activity'] = $entry['timestamp'];
            $active_visitors[$hash]['load_type'] = $entry['page'];

            // Apply date range filter for page hits and hourly hits
            if ($entry['timestamp'] < $start_timestamp || $entry['timestamp'] > $end_timestamp) {
                continue; // Skip entries outside the selected date range
            }
            $page = $entry['page'];
            if (!isset($page_hits[$page])) $page_hits[$page] = 0;
            $page_hits[$page]++;

            $hour = (int)date('G', $entry['timestamp']);
            $hourly_hits[$hour]++;
            
            if ($entry['timestamp'] >= $one_hour_ago) {
                $ip_addr = $entry['ip'];
                if (!isset($active_ips_1h[$ip_addr])) $active_ips_1h[$ip_addr] = 0;
                $active_ips_1h[$ip_addr]++;
            }
        }
        fclose($handle);
    }
}

// --- FINAL CALCULATIONS ---
$nicknames = file_exists($nicknames_file) ? json_decode(file_get_contents($nicknames_file), true) : [];
$active_feed = [];
foreach ($active_visitors as $hash => $visitor) {
    $visitor['nickname'] = $nicknames[$visitor['ip_address']] ?? null;
    $visitor['sec_ago'] = $now - $visitor['last_activity'];
    $active_feed[] = $visitor;
}
usort($active_feed, function($a, $b) { return $b['last_activity'] <=> $a['last_activity']; });

$blocked_registry = [];
if (file_exists($blocked_file)) {
    $lines = file($blocked_file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) $blocked_registry[] = ['ip_address' => trim($line)];
    usort($blocked_registry, function($a, $b) { return strcmp($a['ip_address'], $b['ip_address']); });
}
$blocked_ips_flat = array_column($blocked_registry, 'ip_address');
$active_feed = array_filter($active_feed, function($v) use ($blocked_ips_flat) { return !in_array($v['ip_address'], $blocked_ips_flat); });

$top_pages = [];
arsort($page_hits);
foreach (array_slice($page_hits, 0, 50, true) as $page => $total) {
    $top_pages[] = ['load_type' => $page, 'total' => $total];
}

$top_ips_display = [];
arsort($active_ips_1h);
foreach (array_slice($active_ips_1h, 0, 10, true) as $ip => $hits) {
    $top_ips_display[] = ['ip' => $ip, 'hits' => $hits, 'name' => $nicknames[$ip] ?? ''];
}

$sessions_active = 0;
foreach ($active_visitors as $visitor) {
    if ($visitor['last_activity'] > $fifteen_minutes_ago) $sessions_active++;
}

$chart_labels = []; $chart_data = []; $max_hits = 0; $peak_index = 0; $current_hour = (int)date('G');
for ($i = -23; $i <= 0; $i++) {
    $h = ($current_hour + $i + 24) % 24;
    $label = ($h == 0) ? "12AM" : (($h > 12) ? ($h-12)."PM" : $h."AM");
    $chart_labels[] = $label;
    $val = $hourly_hits[$h] ?? 0;
    $chart_data[] = $val;
    if ($val >= $max_hits && $val > 0) { $max_hits = $val; $peak_index = count($chart_data) - 1; }
}

$server_profile_name = "$cpu_cores Cores Detected";
$server_profile_desc = "Generic Profile";
if ($cpu_cores == 2) { $server_profile_name = "AWS t3.medium"; $server_profile_desc = "2 vCPUs, Burstable"; }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="refresh" content="30">
    <title>SJU Master Monitor</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <style>
        .info.legend { background: rgba(255,255,255,0.8); padding: 6px 8px; font: 12px Arial, Helvetica, sans-serif; box-shadow: 0 0 15px rgba(0,0,0,0.2); border-radius: 5px; }
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
<?php if (isset($reboot_msg, $reboot_msg_class)): ?>
    <div class="alert <?php echo $reboot_msg_class; ?>"><?php echo $reboot_msg; ?></div>
<?php endif; ?>

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
                <span class="text-muted x-small">UNIQUE VISITORS</span>
                <div class="h4 m-0 fw-bold text-success"><?php echo $total_unique_visitors_in_selected_range; ?></div>
                <small class="text-muted">(Selected Range)</small>
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
            
            <form class="card p-2 mb-3 d-flex flex-row gap-2" method="GET">
                <input type="text" name="search" value="<?php echo htmlspecialchars($search); ?>" class="form-control form-control-sm" placeholder="Search IP/Name...">
                <input type="date" name="start_date" id="start_date" class="form-control form-control-sm" value="<?php echo htmlspecialchars($start_date_str); ?>">
                <input type="date" name="end_date" id="end_date" class="form-control form-control-sm" value="<?php echo htmlspecialchars($end_date_str); ?>">
                <button type="submit" class="btn btn-sm btn-primary px-3"><i class="fa fa-filter"></i> Filter</button>
                <?php if (!empty($search) || $start_date_str !== date('Y-m-d', strtotime('-1 month')) || $end_date_str !== date('Y-m-d')): ?>
                <a href="<?php echo $_SERVER['PHP_SELF']; ?>" class="btn btn-sm btn-outline-secondary px-3"><i class="fa fa-times"></i> Clear</a>
                <?php endif; ?>
            </form>
            <div class="alert alert-info small mb-3">
                <i class="fa fa-info-circle me-2"></i>
                Displaying data from <strong><?php echo htmlspecialchars($start_date_str); ?></strong> to <strong><?php echo htmlspecialchars($end_date_str); ?></strong>.
                <?php if ($start_date_str === date('Y-m-d', strtotime('-1 month')) && $end_date_str === date('Y-m-d')): ?>
                (Default: Last 1 Month)
                <?php endif; ?>
            </form>

            <div class="card overflow-hidden">
                <div class="card-header bg-white d-flex justify-content-between align-items-center py-2">
                    <h6 class="m-0 fw-bold x-small text-muted">ACTIVE VISITORS</h6>
                    <button id="clearFilterBtn" class="btn btn-sm btn-outline-secondary py-0" style="display:none;">Show All Visitors</button>
                </div>
                <div class="table-responsive">
                    <table class="table align-middle m-0 small text-center">
                        <thead class="bg-light text-muted x-small"><tr><th>DEV</th><th>IDENTITY</th><th>TIME</th><th>MANAGE</th></tr></thead>
                        <tbody>
                            <?php foreach($active_feed as $v): 
                                $t = ($v['sec_ago'] < 60) ? $v['sec_ago'].'s' : round($v['sec_ago']/60).'m';
                                $is_me = ($v['ip_address'] === $my_ip); 
                            ?>
                            <tr class="visitor-row <?php echo $is_me ? 'table-info' : ''; ?>" data-ip="<?php echo htmlspecialchars($v['ip_address']); ?>" data-device="<?php echo htmlspecialchars($v['device_type'] ?? 'Desktop'); ?>">
                                <td><i class="fa <?php echo ($v['device_type'] ?? '') === 'Mobile' ? 'fa-mobile-alt' : (($v['device_type'] ?? '') === 'Tablet' ? 'fa-tablet-alt' : 'fa-desktop'); ?> text-primary"></i></td>
                                <td class="text-start">
                                    <?php if(!empty($v['nickname'])): ?><strong class="text-primary"><?php echo $v['nickname']; ?></strong><br><?php endif; ?>
                                    <span class="ip-text"><?php echo $v['ip_address']; ?></span><br><span class="carrier-tag"><?php echo $v['carrier'] ?? 'ISP'; ?></span>
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

            <div class="card border-0 shadow-sm mb-3 bg-white">
                <div class="card-header bg-white py-2 fw-bold x-small text-muted">TOP PAGES (24H)</div>
                <div class="card-body p-0" style="max-height: 300px; overflow-y: auto;">
                    <div class="p-3 pt-0">
                    <?php foreach($top_pages as $p): ?>
                    <div class="d-flex justify-content-between border-bottom py-2 small">
                        <a href="<?php echo htmlspecialchars($p['load_type']); ?>" target="_blank" class="text-decoration-none text-truncate d-inline-block" style="max-width: 180px;" title="<?php echo htmlspecialchars($p['load_type']); ?>"><?php echo htmlspecialchars($p['load_type']); ?></a>
                        <strong class="text-primary"><?php echo $p['total']; ?></strong>
                    </div>
                    <?php endforeach; ?>
                    </div>
                </div>
            </div>

            <div class="card border-0 shadow-sm mb-3 bg-white">
                <div class="card-header bg-white py-2 fw-bold x-small text-muted">TOP IPs (1H)</div>
                <div class="card-body p-0" style="max-height: 300px; overflow-y: auto;">
                    <div class="p-3 pt-0">
                    <?php foreach($top_ips_display as $ip_data): ?>
                    <div class="d-flex justify-content-between align-items-center border-bottom py-2 small">
                        <span class="text-truncate d-inline-block" style="max-width: 150px;">
                            <span class="ip-text fw-bold"><?php echo htmlspecialchars($ip_data['ip']); ?></span>
                            <?php if($ip_data['name']): ?><br><span class="text-primary" style="font-size: 0.7rem;"><?php echo htmlspecialchars($ip_data['name']); ?></span><?php endif; ?>
                        </span>
                        <div class="d-flex align-items-center gap-2">
                            <strong class="text-danger"><?php echo $ip_data['hits']; ?></strong>
                            <?php if($ip_data['ip'] !== $my_ip): ?>
                            <form method="POST" class="m-0" onsubmit="return confirm('Block this IP?');">
                                <button type="submit" name="ban_ip" value="<?php echo htmlspecialchars($ip_data['ip']); ?>" class="btn btn-sm btn-outline-danger py-0 px-1" title="Block IP"><i class="fa fa-ban" style="font-size: 0.7rem;"></i></button>
                            </form>
                            <?php else: ?>
                            <span class="badge bg-success" style="font-size: 0.55rem;">ME</span>
                            <?php endif; ?>
                        </div>
                    </div>
                    <?php endforeach; ?>
                    <?php if(empty($top_ips_display)): ?><div class="py-2 small text-muted text-center">No recent activity</div><?php endif; ?>
                    </div>
                </div>
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

<div class="container-fluid px-3 mt-4">
    <div class="row g-3">
        <div class="col-md-6">
            <div class="card p-3 bg-white">
                <h6 class="fw-bold x-small text-muted mb-2"><i class="fa fa-globe text-primary"></i> LIVE TRAFFIC MAP</h6>
                <div id="trafficMap" style="height: 400px; width: 100%; border-radius: 8px; z-index: 1;"></div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card p-3 bg-white">
                <h6 class="fw-bold x-small text-muted mb-2"><i class="fa fa-flag text-primary"></i> VISITORS BY COUNTRY</h6>
                <div id="countryMap" style="height: 400px; width: 100%; border-radius: 8px; z-index: 1;"></div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const geoCache = {};
    const visitorRows = document.querySelectorAll('.visitor-row');
    const clearFilterBtn = document.getElementById('clearFilterBtn');

    // Map 1: Live Traffic Pins
    const trafficMap = L.map('trafficMap').setView([20, 0], 2);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', { maxZoom: 18, attribution: '© OpenStreetMap' }).addTo(trafficMap);

    // Map 2: Country Choropleth
    const countryMap = L.map('countryMap').setView([20, 0], 2);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', { maxZoom: 18, attribution: '© OpenStreetMap' }).addTo(countryMap);
    let geoJsonLayer;

    const uniqueIps = [...new Set(Array.from(visitorRows).map(row => row.dataset.ip))];
    const geoPromises = uniqueIps.map(ip => {
        if (!ip || ip === 'UNKNOWN' || ip === '::1' || ip === '127.0.0.1') return Promise.resolve({ ip, data: null });
        return fetch(`https://get.geojs.io/v1/ip/geo/${ip}.json`)
            .then(r => r.json())
            .then(data => {
                if (data.country) {
                    const loc = [data.city, data.region, data.country].filter(Boolean).join(', ');
                    geoCache[ip] = { loc: loc, lat: data.latitude, lon: data.longitude, country_code3: data.country_code3, region: data.region };
                }
                return { ip, data };
            }).catch(e => ({ ip, data: null }));
    });

    const worldJsonPromise = fetch('https://raw.githubusercontent.com/johan/world.geo.json/master/countries.geo.json').then(r => r.json());

    Promise.all([...geoPromises, worldJsonPromise]).then(results => {
        const worldJson = results.pop();
        const countryCounts = {};
        const addedMarkers = new Set();
        const activeBounds = L.latLngBounds();

        visitorRows.forEach(row => {
            const ip = row.dataset.ip;
            const geoSpan = row.querySelector('.geo-loc');
            const geoData = geoCache[ip];

            if (geoData) {
                if (geoSpan) geoSpan.textContent = geoData.loc;
                if (geoData.lat && geoData.lon && !addedMarkers.has(ip)) {
                    let iconClass = 'fa-desktop';
                    let iconColor = '#0d6efd';
                    if (row.dataset.device === 'Mobile') { iconClass = 'fa-mobile-alt'; iconColor = '#dc3545'; }
                    else if (row.dataset.device === 'Tablet') { iconClass = 'fa-tablet-alt'; iconColor = '#fd7e14'; }

                    const customIcon = L.divIcon({
                        className: 'custom-pin',
                        html: `<div style="color: ${iconColor}; font-size: 1.2rem; text-shadow: 1px 1px 2px white, -1px -1px 2px white, 1px -1px 2px white, -1px 1px 2px white;"><i class="fa ${iconClass}"></i></div>`,
                        iconSize: [20, 20],
                        iconAnchor: [10, 10]
                    });

                    const marker = L.marker([geoData.lat, geoData.lon], { icon: customIcon }).addTo(trafficMap).bindPopup(`<b>${ip}</b><br>${geoData.loc}<br>Device: ${row.dataset.device}`);
                    if (geoData.region) marker.bindTooltip(geoData.region, { direction: 'top' });
                    addedMarkers.add(ip);
                    activeBounds.extend([geoData.lat, geoData.lon]);
                }
                if (geoData.country_code3) {
                    row.dataset.countryCode = geoData.country_code3;
                }
            } else if (geoSpan) {
                if (ip === 'UNKNOWN' || ip === '::1' || ip === '127.0.0.1') geoSpan.textContent = 'Localhost';
                else if (geoSpan.textContent === 'Loading location...') geoSpan.textContent = 'Location unavailable';
            }
        });

        // Count unique IPs per country instead of total active sessions
        uniqueIps.forEach(ip => {
            const geoData = geoCache[ip];
            if (geoData && geoData.country_code3) {
                countryCounts[geoData.country_code3] = (countryCounts[geoData.country_code3] || 0) + 1;
            }
        });

        function getColor(count) { return count > 10 ? '#800026' : count > 5 ? '#BD0026' : count > 2 ? '#E31A1C' : count > 1 ? '#FC4E2A' : count > 0 ? '#FED976' : '#f7f7f7'; }
        function style(feature) { return { fillColor: getColor(countryCounts[feature.id] || 0), weight: 1, opacity: 1, color: '#ccc', fillOpacity: 0.7 }; }

        function onEachFeature(feature, layer) {
            const count = countryCounts[feature.id] || 0;
            layer.bindPopup(`<strong>${feature.properties.name}</strong><br>Active IPs: ${count}`);
            layer.on({
                mouseover: e => {
                    const l = e.target;
                    l.setStyle({ weight: 2, color: '#666', dashArray: '' });
                    if (!L.Browser.ie && !L.Browser.opera && !L.Browser.edge) l.bringToFront();
                },
                mouseout: e => { if (geoJsonLayer) geoJsonLayer.resetStyle(e.target); },
                click: e => {
                    const countryCode = e.target.feature.id;
                    let visibleCount = 0;
                    visitorRows.forEach(row => {
                        if (row.dataset.countryCode === countryCode) {
                            row.style.display = '';
                            visibleCount++;
                        } else {
                            row.style.display = 'none';
                        }
                    });
                    clearFilterBtn.style.display = 'block';
                    clearFilterBtn.textContent = `Show All Visitors (${visibleCount} shown for ${e.target.feature.properties.name})`;
                }
            });
        }

        geoJsonLayer = L.geoJson(worldJson, { style: style, onEachFeature: onEachFeature }).addTo(countryMap);

        if (activeBounds.isValid()) {
            trafficMap.fitBounds(activeBounds, { padding: [30, 30], maxZoom: 6 });
            countryMap.fitBounds(activeBounds, { padding: [30, 30], maxZoom: 6 });
        }

        const legend = L.control({ position: 'bottomright' });
        legend.onAdd = function (map) {
            const div = L.DomUtil.create('div', 'info legend');
            const grades = [0, 1, 2, 5, 10];
            div.innerHTML += '<strong>Unique IPs</strong><br>';
            for (let i = 0; i < grades.length; i++) {
                div.innerHTML += '<i style="background:' + getColor(grades[i] + 1) + '; width: 18px; height: 18px; float: left; margin-right: 8px; opacity: 0.7;"></i> ' + grades[i] + (grades[i + 1] ? '&ndash;' + grades[i + 1] + '<br>' : '+');
            }
            return div;
        };
        legend.addTo(countryMap);
    });

    clearFilterBtn.addEventListener('click', () => {
        visitorRows.forEach(row => row.style.display = '');
        clearFilterBtn.style.display = 'none';
    });

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
});
</script>
</body>
</html>