<?php
session_start();
$config = file_exists('/home/sjubedu/config.php') ? '/home/sjubedu/config.php' : __DIR__ . '/../../config.php';
if (file_exists($config)) {
    require_once $config;
} else {
    require_once __DIR__ . '/config.php'; // Fallback
}

// Authentication & Permission Check
if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== true || !in_array('view_logs', $_SESSION['admin_perms'] ?? [])) {
    header("Location: dashboard.php");
    exit;
}

$log_file = __DIR__ . '/admin_logins.log';

// Handle Clear Log Action
$msg = '';
if (isset($_POST['clear_log'])) {
    if (file_put_contents($log_file, '') !== false) {
        $msg = "<div class='alert alert-success'><i class='fa fa-check-circle me-2'></i> Login history cleared successfully.</div>";
    } else {
        $msg = "<div class='alert alert-danger'><i class='fa fa-times-circle me-2'></i> Failed to clear log. Check file permissions.</div>";
    }
}

// Read and Parse the Log File
$logs = [];
if (file_exists($log_file)) {
    $lines = file($log_file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    
    // Reverse so newest entries are at the top
    foreach (array_reverse($lines) as $line) {
        // Regex to parse line format: [YYYY-MM-DD HH:MM:SS] Login Success/Failed: Details from IP: xxx.xxx.xxx.xxx
        if (preg_match('/^\[(.*?)\] (.*?) from IP: (.*)$/', $line, $matches)) {
            $timestamp = $matches[1];
            $status_user = $matches[2];
            $ip = $matches[3];
            
            $status = strpos($status_user, 'Success') !== false ? 'Success' : 'Failed';
            $details = str_replace(['Login Success: ', 'Login Failed: '], '', $status_user);
            
            $logs[] = [
                'timestamp' => $timestamp,
                'status' => $status,
                'details' => $details,
                'ip' => $ip,
                'raw' => $line
            ];
        } else {
            $logs[] = [
                'timestamp' => 'N/A',
                'status' => 'Unknown',
                'details' => $line, // Dump raw line in details if it doesn't match
                'ip' => 'N/A',
                'raw' => $line
            ];
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login History</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-light p-4">
<div class="container" style="max-width: 1000px;">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><i class="fa fa-user-shield text-primary me-2"></i> Admin Login History</h2>
        <div>
            <a href="dashboard.php" class="btn btn-secondary">Back to Dashboard</a>
        </div>
    </div>
    <?php echo $msg; ?>
    <div class="card shadow-sm">
        <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
            <span class="fw-bold">Recorded Admin Authentication Attempts</span>
            <form method="POST" class="m-0" onsubmit="return confirm('Are you absolutely sure you want to clear the entire login log? This cannot be undone.');">
                <button type="submit" name="clear_log" class="btn btn-sm btn-outline-danger"><i class="fa fa-trash me-1"></i> Clear Log</button>
            </form>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive" style="max-height: 70vh; overflow-y: auto;">
                <table class="table table-hover table-striped mb-0 align-middle">
                    <thead class="table-dark" style="position: sticky; top: 0; z-index: 10;">
                        <tr>
                            <th>Timestamp</th>
                            <th>Status</th>
                            <th>Attempted By / Context</th>
                            <th>IP Address</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($logs)): ?>
                            <tr><td colspan="4" class="text-center text-muted py-4">No login records found yet.</td></tr>
                        <?php else: ?>
                            <?php foreach ($logs as $log): ?>
                                <tr>
                                    <td class="text-nowrap"><?php echo htmlspecialchars($log['timestamp']); ?></td>
                                    <td>
                                        <?php if ($log['status'] === 'Success'): ?>
                                            <span class="badge bg-success"><i class="fa fa-check me-1"></i> Success</span>
                                        <?php elseif ($log['status'] === 'Failed'): ?>
                                            <span class="badge bg-danger"><i class="fa fa-times me-1"></i> Failed</span>
                                        <?php else: ?>
                                            <span class="badge bg-secondary">Unknown</span>
                                        <?php endif; ?>
                                    </td>
                                    <td><?php echo htmlspecialchars($log['details']); ?></td>
                                    <td class="font-monospace text-primary fw-bold geo-ip-cell" data-ip="<?php echo htmlspecialchars($log['ip']); ?>">
                                        <?php if ($log['ip'] !== 'N/A' && $log['ip'] !== 'UNKNOWN'): ?>
                                            <a href="https://ipinfo.io/<?php echo htmlspecialchars($log['ip']); ?>" target="_blank" class="text-decoration-none" title="Lookup IP Information">
                                                <?php echo htmlspecialchars($log['ip']); ?> <i class="fa fa-external-link-alt ms-1" style="font-size: 0.7em;"></i>
                                            </a>
                                            <div class="geo-loc text-muted small mt-1"></div>
                                        <?php else: ?>
                                            <span class="text-muted"><?php echo htmlspecialchars($log['ip']); ?></span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ipCells = document.querySelectorAll('.geo-ip-cell');
        const geoCache = {};

        ipCells.forEach(cell => {
            const ip = cell.getAttribute('data-ip');
            const geoDiv = cell.querySelector('.geo-loc');
            
            if (!ip || ip === 'N/A' || ip === 'UNKNOWN' || !geoDiv) return;
            if (ip === '127.0.0.1' || ip === '::1') {
                geoDiv.innerHTML = '<i class="fa fa-map-marker-alt me-1"></i>Localhost';
                return;
            }

            if (geoCache[ip]) {
                geoDiv.innerHTML = `<i class="fa fa-map-marker-alt me-1"></i>${geoCache[ip]}`;
            } else {
                fetch(`https://get.geojs.io/v1/ip/geo/${ip}.json`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.country) {
                            const city = data.city ? data.city + ', ' : '';
                            const loc = `${city}${data.country}`;
                            geoCache[ip] = loc;
                            geoDiv.innerHTML = `<i class="fa fa-map-marker-alt me-1"></i>${loc}`;
                            
                            // Update any other cells with the same IP immediately
                            ipCells.forEach(otherCell => {
                                if (otherCell.getAttribute('data-ip') === ip) {
                                    const otherGeoDiv = otherCell.querySelector('.geo-loc');
                                    if (otherGeoDiv) otherGeoDiv.innerHTML = `<i class="fa fa-map-marker-alt me-1"></i>${loc}`;
                                }
                            });
                        }
                    })
                    .catch(err => console.error('Geo IP error:', err));
            }
        });
    });
</script>
</body>
</html>