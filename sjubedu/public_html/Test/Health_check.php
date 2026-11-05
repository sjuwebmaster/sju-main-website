<?php
declare(strict_types=1);
session_start();

// 1. SECURITY & CONFIG
if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== true) {
    header("Location: ../dashboard.php?error=unauthorized"); 
    exit();
}

if (!isset($_SESSION['admin_role']) || $_SESSION['admin_role'] !== 'superadmin') {
    die("Access Denied: Superadmin privileges required.");
}

// Generate CSRF Token for form submissions
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
$csrf_token = $_SESSION['csrf_token'];

$config = file_exists('/home/sjubedu/config.php') ? '/home/sjubedu/config.php' : __DIR__ . '/../../config.php';
require_once $config;
date_default_timezone_set('Asia/Kolkata');

// --- CONFIGURATION ---
$cpu_cores = function_exists('processor_count') ? \processor_count() : 2;
$max_sessions = 500;

// --- ROBUST SITE CHECKER ---
function check_site_status(string $url): bool {
    if (!function_exists('curl_init')) return false;
    $ch = curl_init($url);
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_NOBODY => true,
        CURLOPT_TIMEOUT => 10, // Slightly reduced to prevent extreme blocking
        CURLOPT_CONNECTTIMEOUT => 5,
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_SSL_VERIFYHOST => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_USERAGENT => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) Monitor/1.1',
        CURLOPT_REFERER => 'https://www.google.com/'
    ]);
    curl_exec($ch);
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    return ($http_code >= 200 && $http_code < 405);
}

// --- FILE PATHS ---
$my_ip = $_SERVER['HTTP_CF_CONNECTING_IP'] ?? $_SERVER['REMOTE_ADDR'] ?? '';
$base_dir = dirname($config);
$blocked_file = $base_dir . '/blocked_ips.txt';
$nicknames_file = $base_dir . '/ip_nicknames.json';
$log_file = $base_dir . '/visitor_log.txt';

// --- ACTIONS (With CSRF & Validation) ---
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!hash_equals($csrf_token, $_POST['csrf_token'] ?? '')) {
        die("Security Error: Invalid CSRF token.");
    }

    if (isset($_POST['ban_ip'])) {
        $ip = trim($_POST['ban_ip']);
        if (filter_var($ip, FILTER_VALIDATE_IP) && $ip !== $my_ip) {
            // Added LOCK_EX to prevent race conditions
            file_put_contents($blocked_file, $ip . PHP_EOL, FILE_APPEND | LOCK_EX);
        }
        header("Location: " . $_SERVER['PHP_SELF']); 
        exit();
    }

    if (isset($_POST['unban_ip'])) {
        $ip = trim($_POST['unban_ip']);
        if (file_exists($blocked_file)) {
            $lines = file($blocked_file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
            $updated_lines = array_diff($lines, [$ip]);
            file_put_contents($blocked_file, implode(PHP_EOL, $updated_lines) . PHP_EOL, LOCK_EX);
        }
        header("Location: " . $_SERVER['PHP_SELF']); 
        exit();
    }
    
    // Note: 'reboot' action was in HTML but had no backend logic in the original file. 
    // Left unhandled in PHP to strictly maintain original feature set.
}

// --- VITALS ---
$current_cpu = function_exists('sys_getloadavg') ? round(sys_getloadavg()[0], 2) : 0.0;
$disk_total = disk_total_space("/");
$disk_free = disk_free_space("/");
$disk_used_percent = ($disk_total > 0) ? round((($disk_total - $disk_free) / $disk_total) * 100) : 0;
$sju_up = check_site_status("https://sju.edu.in");
$sjric_up = check_site_status("https://sjric.res.in");

// Health Grading
if ($disk_used_percent > 95 || !$sju_up) { 
    $grade = "D"; $color = "#dc3545"; 
} else { 
    $grade = "A"; $color = "#198754"; 
}

// --- DATA PROCESSING FOR CHARTS/MAPS ---
$hourly_hits = array_fill(0, 24, 0);
$active_feed = [];
$cutoff_time = time() - 86400;

if (file_exists($log_file)) {
    $log_data = file($log_file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    if ($log_data !== false) {
        foreach ($log_data as $line) {
            $entry = json_decode($line, true);
            if (is_array($entry) && isset($entry['timestamp']) && $entry['timestamp'] > $cutoff_time) {
                $hour = (int)date('G', $entry['timestamp']);
                $hourly_hits[$hour]++;
                if (isset($entry['ip'])) {
                    $active_feed[$entry['ip']] = $entry; // Overwrites to keep latest per IP
                }
            }
        }
    }
}
$active_feed = array_reverse($active_feed);
$chart_labels = []; 
$chart_data = [];
for($i = 23; $i >= 0; $i--) {
    $h = (date('G') - $i + 24) % 24;
    $chart_labels[] = $h . ":00";
    $chart_data[] = $hourly_hits[$h];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php 
    $gtm_path = $_SERVER['DOCUMENT_ROOT'] . '/gtm.php';
    if (file_exists($gtm_path)) include $gtm_path; 
    ?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SJU Advanced Monitor</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <style>
        body { background: #f8f9fa; }
        .card { border: none; border-radius: 15px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); margin-bottom: 20px; }
        .vitals-card { text-align: center; padding: 20px; }
        .vitals-card h1 { font-size: 3.5rem; font-weight: 800; margin: 0; }
        #map { height: 400px; border-radius: 15px; z-index: 1; }
        .ip-list { max-height: 400px; overflow-y: auto; }
    </style>
</head>
<body>

<div class="container-fluid py-4">
    <div class="row g-3">
        <div class="col-md-2">
            <div class="card vitals-card" style="border-top: 5px solid <?php echo htmlspecialchars($color); ?>">
                <small class="text-muted fw-bold">SYSTEM GRADE</small>
                <h1 style="color: <?php echo htmlspecialchars($color); ?>"><?php echo htmlspecialchars($grade); ?></h1>
                <small class="text-uppercase fw-bold text-muted">Disk: <?php echo $disk_used_percent; ?>%</small>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card p-3">
                <small class="text-muted fw-bold mb-2 d-block">TRAFFIC (LAST 24H)</small>
                <canvas id="trafficChart" height="100"></canvas>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card p-3">
                <small class="text-muted fw-bold mb-2 d-block">SITE STATUS</small>
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <span>sju.edu.in</span>
                    <span class="badge <?php echo $sju_up ? 'bg-success' : 'bg-danger'; ?>"><?php echo $sju_up ? 'UP' : 'DOWN'; ?></span>
                </div>
                <div class="d-flex justify-content-between align-items-center">
                    <span>sjric.res.in</span>
                    <span class="badge <?php echo $sjric_up ? 'bg-success' : 'bg-danger'; ?>"><?php echo $sjric_up ? 'UP' : 'DOWN'; ?></span>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card p-3 bg-dark text-white text-center">
                <small class="fw-bold opacity-75">SERVER CONTROL</small>
                <form method="POST" onsubmit="return confirm('Reboot Now?');">
                    <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($csrf_token); ?>">
                    <button name="reboot" class="btn btn-outline-danger w-100 mt-2 fw-bold">REBOOT SYSTEM</button>
                </form>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card p-3">
                <small class="text-muted fw-bold mb-3 d-block"><i class="fa fa-globe"></i> LIVE VISITOR MAP</small>
                <div id="map"></div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card p-3">
                <small class="text-muted fw-bold mb-3 d-block"><i class="fa fa-users"></i> RECENT UNIQUE IPs</small>
                <div class="ip-list">
                    <table class="table table-sm small">
                        <thead><tr><th>IP</th><th>Device</th><th>Action</th></tr></thead>
                        <tbody>
                            <?php foreach($active_feed as $ip => $v): ?>
                            <tr class="visitor-row" data-ip="<?php echo htmlspecialchars($ip); ?>">
                                <td class="fw-bold text-primary"><?php echo htmlspecialchars($ip); ?></td>
                                <td><i class="fa <?php echo (isset($v['device']) && $v['device'] === 'Mobile') ? 'fa-mobile' : 'fa-desktop'; ?>"></i></td>
                                <td>
                                    <form method="POST" class="d-inline">
                                        <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($csrf_token); ?>">
                                        <button name="ban_ip" value="<?php echo htmlspecialchars($ip); ?>" class="btn btn-link text-danger p-0 small" title="Ban IP">
                                            <i class="fa fa-ban"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<script>
// 1. Initialize Map
const map = L.map('map').setView([20, 78], 4);
L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);

// 2. Fetch Geo Data for IPs (Upgraded with Caching and Async/Await)
const geoCache = new Map();
const visitorRows = document.querySelectorAll('.visitor-row');

visitorRows.forEach(async (row) => {
    const ip = row.dataset.ip;
    if (ip && ip !== '::1' && ip !== '127.0.0.1') {
        if (geoCache.has(ip)) return; // Prevent duplicate API calls
        geoCache.set(ip, true);

        try {
            const res = await fetch(`https://get.geojs.io/v1/ip/geo/${ip}.json`);
            if (!res.ok) throw new Error('Network response was not ok');
            const data = await res.json();
            
            if (data.latitude && data.longitude) {
                const city = data.city || 'Unknown City';
                const country = data.country || 'Unknown Country';
                L.marker([data.latitude, data.longitude])
                 .addTo(map)
                 .bindPopup(`<b>IP:</b> ${ip}<br><b>Loc:</b> ${city}, ${country}`);
            }
        } catch (error) {
            console.warn(`Failed to fetch geo data for ${ip}`, error);
        }
    }
});

// 3. Traffic Chart
const ctx = document.getElementById('trafficChart').getContext('2d');
new Chart(ctx, {
    type: 'line',
    data: {
        labels: <?php echo json_encode($chart_labels); ?>,
        datasets: [{
            label: 'Hits',
            data: <?php echo json_encode($chart_data); ?>,
            borderColor: '#0d6efd',
            backgroundColor: 'rgba(13, 110, 253, 0.1)',
            fill: true,
            tension: 0.4
        }]
    },
    options: { 
        plugins: { legend: { display: false } }, 
        scales: { y: { beginAtZero: true } } 
    }
});
</script>
</body>
</html>