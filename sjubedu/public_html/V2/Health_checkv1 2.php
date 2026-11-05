<?php
// Test/health_check.php - SYSTEM MONITOR & NATIVE PURGE TOOL
session_start();
require_once __DIR__ . '/config.php';
date_default_timezone_set('Asia/Kolkata');

if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

// --- 1. AUTHENTICATION ---
if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== true) {
    die("Access Denied. Please login at admin_update.php");
}

// --- 2. DATABASE CONNECTION ---
$db_host = 'localhost'; $db_name = 'sjubedu_faculty_data'; $db_user = 'sjubedu_developer'; $db_pass = 'SJU2022_sju';

try {
    $pdo = new PDO("mysql:host=$db_host;dbname=$db_name;charset=utf8mb4", $db_user, $db_pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->exec("SET SESSION time_zone = '+05:30'");

    // --- 3. INDIVIDUAL & BULK RESYNC HANDLER ---
    $purge_message = "";
    if (isset($_POST['resync_item']) || isset($_POST['bulk_resync'])) {
        $items_to_sync = [];
        
        if (isset($_POST['resync_item'])) {
            $items_to_sync[] = $_POST['resync_item'];
        } elseif (isset($_POST['bulk_resync']) && !empty($_POST['selected_items'])) {
            $items_to_sync = $_POST['selected_items'];
        }

        $table_map = [
            'Faculty' => ['table' => 'api_cache', 'col' => 'id'],
            'PhD' => ['table' => 'phd_cache', 'col' => 'department_id'],
            'Publication' => ['table' => 'publication_cache', 'col' => 'department_id'],
            'Project' => ['table' => 'project_cache', 'col' => 'department_id'],
            'Award' => ['table' => 'awards_cache', 'col' => 'department_id']
        ];

        $count = 0;
        foreach ($items_to_sync as $item) {
            if (strpos($item, '|') === false) continue;
            list($type, $key) = explode('|', $item);
            
            if (isset($table_map[$type])) {
                $t = $table_map[$type]['table'];
                $c = $table_map[$type]['col'];
                try {
                    $stmt = $pdo->prepare("DELETE FROM $t WHERE $c = ?");
                    $stmt->execute([$key]);
                    $count++;
                } catch (Exception $e) {}
            }
        }
        
        if ($count > 0) {
            $purge_message = "<div class='alert alert-success shadow-sm'>✅ Successfully cleared cache for $count item(s).</div>";
        }
    }

    // --- 4. NATIVE FORCE PURGE HANDLER ---
    if (isset($_POST['purge_expired'])) {
        // Use rowCount to verify the deletion actually happened in the DB
        $tables = ['api_cache', 'phd_cache', 'publication_cache', 'project_cache', 'awards_cache'];
        $total_count = 0;
        foreach ($tables as $table) {
            try {
                $stmt = $pdo->prepare("DELETE FROM $table WHERE created_at < DATE_SUB(NOW(), INTERVAL 6 HOUR)");
                $stmt->execute();
                $total_count += $stmt->rowCount();
            } catch (Exception $e) {}
        }

        if ($total_count > 0) {
            $purge_message = "<div class='alert alert-success shadow-sm'>🔥 Native Purge Success: Removed $total_count records from all databases.</div>";
        } else {
            $purge_message = "<div class='alert alert-info shadow-sm'>ℹ️ Databases are clean. No records met the 6-hour expiration criteria.</div>";
        }
    }

    // --- 5. DATA RETRIEVAL ---
    $rows = [];
    
    // Faculty
    try {
        $stmt = $pdo->query("SELECT id, created_at FROM api_cache");
        while ($r = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $rows[] = [
                'db_key' => $r['id'],
                'id' => str_replace('faculty_', '', $r['id']),
                'created_at' => $r['created_at'],
                'type' => 'Faculty'
            ];
        }
    } catch (Exception $e) {}

    // PhD
    try {
        $stmt = $pdo->query("SELECT department_id, department_name, created_at FROM phd_cache");
        while ($r = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $rows[] = [
                'db_key' => $r['department_id'],
                'id' => $r['department_name'],
                'created_at' => $r['created_at'],
                'type' => 'PhD'
            ];
        }
    } catch (Exception $e) {}

    // Publications
    try {
        $stmt = $pdo->query("SELECT department_id, department_name, created_at FROM publication_cache");
        while ($r = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $rows[] = [
                'db_key' => $r['department_id'],
                'id' => $r['department_name'],
                'created_at' => $r['created_at'],
                'type' => 'Publication'
            ];
        }
    } catch (Exception $e) {}

    // Projects
    try {
        $stmt = $pdo->query("SELECT department_id, department_name, created_at FROM project_cache");
        while ($r = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $rows[] = [
                'db_key' => $r['department_id'],
                'id' => $r['department_name'],
                'created_at' => $r['created_at'],
                'type' => 'Project'
            ];
        }
    } catch (Exception $e) {}

    // Awards
    try {
        $stmt = $pdo->query("SELECT department_id, department_name, created_at FROM awards_cache");
        while ($r = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $rows[] = [
                'db_key' => $r['department_id'],
                'id' => $r['department_name'],
                'created_at' => $r['created_at'],
                'type' => 'Award'
            ];
        }
    } catch (Exception $e) {}

    // --- FILTER LOGIC ---
    $filter_type = isset($_GET['filter_type']) ? $_GET['filter_type'] : '';
    if ($filter_type && $filter_type !== 'All') {
        $rows = array_filter($rows, function($r) use ($filter_type) {
            return $r['type'] === $filter_type;
        });
    }

    // Sort by created_at ASC
    usort($rows, function($a, $b) {
        return strtotime($a['created_at']) - strtotime($b['created_at']);
    });

} catch (PDOException $e) { die("Critical DB Error: " . $e->getMessage()); }

$now = time();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="refresh" content="60">
    <title>SJU Health Monitor</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { background-color: #f4f7f6; font-family: 'Segoe UI', sans-serif; }
        .expired { background-color: #ffeef0 !important; }
        .healthy { background-color: #f0fff4 !important; }
        .table-fixed { height: 60vh; overflow-y: auto; background: white; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); }
        .sticky-top { background: #212529 !important; color: white; }
    </style>
</head>
<body>

<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold"><i class="fa fa-stethoscope text-primary me-2"></i> Cache Health Check</h2>
        <div class="d-flex align-items-center gap-2">
            <button type="submit" form="healthForm" name="bulk_resync" class="btn btn-warning btn-sm text-dark fw-bold"><i class="fa fa-sync me-1"></i> Resync Selected</button>
            <button type="button" id="selectExpired" class="btn btn-outline-danger btn-sm fw-bold"><i class="fa fa-check-square me-1"></i> Select Expired</button>
            <form method="GET">
                <select name="filter_type" class="form-select form-select-sm" onchange="this.form.submit()" style="width: auto;">
                    <option value="">All Modules</option>
                    <option value="Faculty" <?php if($filter_type === 'Faculty') echo 'selected'; ?>>Faculty</option>
                    <option value="PhD" <?php if($filter_type === 'PhD') echo 'selected'; ?>>PhD</option>
                    <option value="Publication" <?php if($filter_type === 'Publication') echo 'selected'; ?>>Publication</option>
                    <option value="Project" <?php if($filter_type === 'Project') echo 'selected'; ?>>Project</option>
                    <option value="Award" <?php if($filter_type === 'Award') echo 'selected'; ?>>Award</option>
                </select>
            </form>
            <div class="btn-group">
                <a href="dashboard.php" class="btn btn-outline-dark btn-sm"><i class="fa fa-tachometer-alt"></i> Dashboard</a>
                <button onclick="location.reload()" class="btn btn-primary btn-sm">Refresh View</button>
                <a href="?logout=1" class="btn btn-danger btn-sm">Logout</a>
            </div>
        </div>
    </div>

    <?php echo $purge_message; ?>

    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="card p-3 shadow-sm text-center border-0">
                <h6 class="text-muted small fw-bold">DB ROW COUNT</h6>
                <h2 class="m-0"><?php echo count($rows); ?></h2>
            </div>
        </div>
        <div class="col-md-4 text-center">
             <div class="card p-3 shadow-sm border-0">
                <h6 class="text-muted small fw-bold">SYSTEM IST TIME</h6>
                <h4 class="text-primary m-0"><?php echo date('h:i A'); ?></h4>
            </div>
        </div>
        <div class="col-md-4">
            <form method="POST">
                <button type="submit" name="purge_expired" class="btn btn-danger w-100 py-3 fw-bold shadow-sm" onclick="return confirm('Execute Native SQL Purge?');">
                    <i class="fa fa-trash-alt me-2"></i> PURGE STALE DATA
                </button>
            </form>
        </div>
    </div>

    <form method="POST" id="healthForm">
    <div class="table-fixed border">
        <table class="table table-hover align-middle mb-0">
            <thead class="sticky-top">
                <tr>
                    <th class="ps-3" style="width: 40px;"><input type="checkbox" class="form-check-input" id="selectAll"></th>
                    <th class="ps-2">MODULE</th>
                    <th>ID / DEPARTMENT</th>
                    <th>SYNC TIME (IST)</th>
                    <th>LIFE REMAINING</th>
                    <th class="text-end pe-4">STATUS</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($rows as $row): 
                    $created_unix = strtotime($row['created_at']);
                    $expiry_unix = $created_unix + (6 * 3600);
                    $mins = round(($expiry_unix - $now) / 60);
                    
                    $is_expired = ($mins <= 0);
                    $status_lbl = $is_expired ? "EXPIRED" : ($mins < 60 ? "URGENT" : "HEALTHY");
                    $badge = $is_expired ? "bg-danger" : ($mins < 60 ? "bg-warning text-dark" : "bg-success");
                ?>
                <tr class="<?php echo $is_expired ? 'expired' : 'healthy'; ?>">
                    <td class="ps-3"><input type="checkbox" name="selected_items[]" value="<?php echo $row['type'] . '|' . $row['db_key']; ?>" class="form-check-input item-checkbox"></td>
                    <td class="ps-2"><span class="badge bg-secondary"><?php echo htmlspecialchars($row['type']); ?></span></td>
                    <td><strong><?php echo htmlspecialchars($row['id']); ?></strong></td>
                    <td><?php echo date('h:i A', $created_unix); ?></td>
                    <td><?php echo ($mins > 0 ? $mins : 0); ?> mins</td>
                    <td class="text-end pe-4">
                        <span class="badge <?php echo $badge; ?> px-3"><?php echo $status_lbl; ?></span>
                        <?php if ($is_expired): ?>
                        <button type="submit" name="resync_item" value="<?php echo $row['type'] . '|' . $row['db_key']; ?>" class="btn btn-sm btn-outline-primary py-0 ms-2" title="Resync"><i class="fa fa-sync"></i></button>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    </form>
</div>

<script>
document.getElementById('selectAll').addEventListener('change', function() {
    const checkboxes = document.querySelectorAll('.item-checkbox');
    checkboxes.forEach(cb => cb.checked = this.checked);
});

document.getElementById('selectExpired').addEventListener('click', function() {
    const checkboxes = document.querySelectorAll('.item-checkbox');
    checkboxes.forEach(cb => {
        if (cb.closest('tr').classList.contains('expired')) {
            cb.checked = true;
        } else {
            cb.checked = false;
        }
    });
});
</script>
</body>
</html>