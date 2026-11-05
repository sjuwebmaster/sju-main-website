<?php
// book_chapter_admin.php
session_start();
$config = file_exists('/home/sjubedu/config.php') ? '/home/sjubedu/config.php' : __DIR__ . '/../../config.php';
require_once $config;

if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== true) {
    header("Location: dashboard.php");
    exit;
}

try {
    $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4", DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) { 
    error_log("Book Chapters Admin DB Error: " . $e->getMessage());
    die("Database Connection Failed."); 
}

$msg = "";
if (isset($_POST['sync_id'])) {
    $dept_id = $_POST['sync_id'];
    $stmt = $pdo->prepare("DELETE FROM book_chapter_cache WHERE department_id = ?");
    $stmt->execute([$dept_id]);
    $msg = "<div class='alert alert-success'>Cache cleared for ID $dept_id. It will be re-synced on the next cron run or manual sync.</div>";
}

if (isset($_POST['purge_expired'])) {
    $stmt = $pdo->prepare("DELETE FROM book_chapter_cache WHERE created_at < DATE_SUB(NOW(), INTERVAL 6 HOUR)");
    $stmt->execute();
    $count = $stmt->rowCount();
    $msg = "<div class='alert alert-success'>Purged $count expired records.</div>";
}

$stmt = $pdo->query("SELECT * FROM book_chapter_cache ORDER BY created_at DESC");
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"><title>Book Chapters Admin Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-light p-4">
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><i class="fa fa-book-open text-primary"></i> Book Chapters Data Control Panel</h2>
        <div>
            <a href="dashboard.php" class="btn btn-secondary">Back to Dashboard</a> 
            <a href="bulk_book_chapter_cron.php" target="_blank" class="btn btn-success"><i class="fa fa-rocket"></i> Run Bulk Sync</a>
            <a href="?logout=1" class="btn btn-danger">Logout</a>
        </div>
    </div>
    <?php echo $msg; ?>
    <div class="card shadow-sm mb-4"><div class="card-body d-flex justify-content-between align-items-center"><div><h5 class="mb-0">Database Status</h5><small class="text-muted">Total Cached Departments: <?php echo count($rows); ?></small></div><form method="POST"><button type="submit" name="purge_expired" class="btn btn-warning text-dark"><i class="fa fa-broom"></i> Purge Expired</button></form></div></div>
    <div class="card shadow-sm"><div class="table-responsive"><table class="table table-hover mb-0 align-middle"><thead class="table-dark"><tr><th>ID</th><th>Department Name</th><th>Last Synced</th><th>Status</th><th>Action</th></tr></thead><tbody><?php foreach ($rows as $row): 
        $age = time() - strtotime($row['created_at']);
        $is_expired = $age > 21600; // 6 hours
    ?><tr>
        <td><?php echo htmlspecialchars($row['department_id']); ?></td>
        <td class="fw-bold"><?php echo htmlspecialchars($row['department_name']); ?></td>
        <td><?php echo $row['created_at']; ?></td>
        <td><span class="badge <?php echo $is_expired ? 'bg-danger' : 'bg-success'; ?>"><?php echo $is_expired ? 'Expired' : 'Fresh'; ?></span></td>
        <td>
            <form method="POST" class="d-inline"><input type="hidden" name="sync_id" value="<?php echo $row['department_id']; ?>"><button class="btn btn-sm btn-outline-primary">Resync</button></form> 
            <a href="book_chapters/book_chapter_<?php echo $row['department_id']; ?>.php" target="_blank" class="btn btn-sm btn-outline-secondary">View Cached</a>
            <a href="book_chapters_live/book_chapter_<?php echo $row['department_id']; ?>.php" target="_blank" class="btn btn-sm btn-outline-danger">View Live</a>
        </td>
    </tr><?php endforeach; ?></tbody></table></div></div>
</div>
</body>
</html>