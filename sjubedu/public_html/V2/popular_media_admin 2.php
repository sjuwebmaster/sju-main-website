<?php
// popular_media_admin.php
session_start();
$config = file_exists('/home/sjubedu/config.php') ? '/home/sjubedu/config.php' : __DIR__ . '/../../config.php';
require_once $config;

if (isset($_GET['logout'])) { session_destroy(); header("Location: " . $_SERVER['PHP_SELF']); exit; }
if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== true) { header("Location: dashboard.php"); exit; }

try {
    $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4", DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) { die("DB Error."); }

$msg = "";
if (isset($_POST['sync_id'])) {
    $stmt = $pdo->prepare("DELETE FROM popular_media_cache WHERE department_id = ?");
    $stmt->execute([$_POST['sync_id']]);
    $msg = "<div class='alert alert-success'>Cache cleared. Resync on next load.</div>";
}
if (isset($_POST['purge_expired'])) {
    $pdo->exec("DELETE FROM popular_media_cache WHERE created_at < DATE_SUB(NOW(), INTERVAL 6 HOUR)");
    $msg = "<div class='alert alert-success'>Expired records purged.</div>";
}

$rows = $pdo->query("SELECT * FROM popular_media_cache ORDER BY created_at DESC")->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html><html lang="en"><head><meta charset="UTF-8"><title>Popular Media Admin</title><link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"><link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"></head><body class="bg-light p-4">
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><i class="fa fa-newspaper text-primary"></i> Popular Media Admin</h2>
        <div><a href="dashboard.php" class="btn btn-secondary">Dashboard</a> <a href="bulk_popular_media_cron.php" target="_blank" class="btn btn-success">Run Sync</a> <a href="?logout=1" class="btn btn-danger">Logout</a></div>
    </div>
    <?php echo $msg; ?>
    <div class="card shadow-sm mb-4"><div class="card-body d-flex justify-content-between"><div><h5 class="mb-0">Status</h5><small>Cached Depts: <?php echo count($rows); ?></small></div><form method="POST"><button name="purge_expired" class="btn btn-warning"><i class="fa fa-broom"></i> Purge Expired</button></form></div></div>
    <div class="card shadow-sm"><div class="table-responsive"><table class="table table-hover mb-0 align-middle"><thead class="table-dark"><tr><th>ID</th><th>Dept</th><th>Last Synced</th><th>Status</th><th>Action</th></tr></thead><tbody><?php foreach ($rows as $row): 
        $expired = (time() - strtotime($row['created_at'])) > 21600;
    ?><tr>
        <td><?php echo htmlspecialchars($row['department_id']); ?></td>
        <td class="fw-bold"><?php echo htmlspecialchars($row['department_name']); ?></td>
        <td><?php echo $row['created_at']; ?></td>
        <td><span class="badge <?php echo $expired ? 'bg-danger' : 'bg-success'; ?>"><?php echo $expired ? 'Expired' : 'Fresh'; ?></span></td>
        <td>
            <form method="POST" class="d-inline"><input type="hidden" name="sync_id" value="<?php echo $row['department_id']; ?>"><button class="btn btn-sm btn-outline-primary">Resync</button></form> 
            <a href="popular_media/popular_media_<?php echo $row['department_id']; ?>.php" target="_blank" class="btn btn-sm btn-outline-secondary">Cached</a>
            <a href="popular_media_live/popular_media_<?php echo $row['department_id']; ?>.php" target="_blank" class="btn btn-sm btn-outline-danger">Live</a>
        </td>
    </tr><?php endforeach; ?></tbody></table></div></div>
</div>
</body></html>