<?php
// popular_media_search.php
$config = file_exists('/home/sjubedu/config.php') ? '/home/sjubedu/config.php' : __DIR__ . '/../../config.php';
require_once $config;

try { $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4", DB_USER, DB_PASS); } catch (PDOException $e) { die("DB Error"); }

$departments = $pdo->query("SELECT DISTINCT department_name FROM popular_media_cache ORDER BY department_name ASC")->fetchAll(PDO::FETCH_COLUMN);
$query = $_GET['q'] ?? ''; $dept_filter = $_GET['dept'] ?? '';
$results = [];

if ($query || $dept_filter) {
    $stmt = $pdo->query("SELECT department_name, content FROM popular_media_cache");
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        if ($dept_filter && $row['department_name'] !== $dept_filter) continue;
        $data = json_decode($row['content'], true)['data'] ?? [];
        foreach ($data as $item) {
            $match = true;
            if ($query) {
                $search_str = ($item['Name of Faculty']??'') . ' ' . ($item['Name of Article']??'') . ' ' . ($item['Name of the Magazine / Media']??'');
                if (stripos($search_str, $query) === false) $match = false;
            }
            if ($match) { $item['Department'] = $row['department_name']; $results[] = $item; }
        }
    }
}

function formatCell($value) {
    if (filter_var($value, FILTER_VALIDATE_URL)) return '<a href="'.htmlspecialchars($value).'" target="_blank">Link</a>';
    return htmlspecialchars($value);
}
?>
<!DOCTYPE html><html lang="en"><head><meta charset="UTF-8"><title>Popular Media Search</title><link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"></head><body class="bg-light p-4">
<div class="container">
    <div class="d-flex justify-content-between mb-4"><h2>Popular Media Database</h2><a href="dashboard.php" class="btn btn-secondary">Dashboard</a></div>
    <div class="card shadow-sm mb-4"><div class="card-body"><form method="GET" class="row g-2">
        <div class="col-md-6"><input type="text" name="q" class="form-control" placeholder="Search..." value="<?php echo htmlspecialchars($query); ?>"></div>
        <div class="col-md-4"><select name="dept" class="form-select"><option value="">All Departments</option><?php foreach ($departments as $d) echo "<option value='$d' ".($dept_filter==$d?'selected':'').">$d</option>"; ?></select></div>
        <div class="col-md-2"><button class="btn btn-primary w-100">Search</button></div>
    </form></div></div>
    <?php if ($results): ?>
    <div class="card shadow-sm"><div class="table-responsive"><table class="table table-hover mb-0"><thead class="table-dark"><tr><th>Dept</th><th>Faculty</th><th>Article</th><th>Media</th><th>Year</th><th>Link</th></tr></thead><tbody>
    <?php foreach ($results as $r): ?><tr>
        <td><?php echo htmlspecialchars($r['Department']); ?></td>
        <td><?php echo htmlspecialchars($r['Name of Faculty']??''); ?></td>
        <td><?php echo htmlspecialchars($r['Name of Article']??''); ?></td>
        <td><?php echo htmlspecialchars($r['Name of the Magazine / Media']??''); ?></td>
        <td><?php echo htmlspecialchars($r['Year']??''); ?></td>
        <td><?php echo formatCell($r['Link']??''); ?></td>
    </tr><?php endforeach; ?>
    </tbody></table></div></div>
    <?php elseif ($query || $dept_filter): ?><div class="alert alert-warning">No records found.</div><?php endif; ?>
</div></body></html>