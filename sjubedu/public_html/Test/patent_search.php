<?php
// patent_search.php
$config = file_exists('/home/sjubedu/config.php') ? '/home/sjubedu/config.php' : __DIR__ . '/../../config.php';
require_once $config;

try {
    $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4", DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) { 
    error_log("Patent Search DB Error: " . $e->getMessage());
    die("Database connection failed. Please try again later."); 
}

$dept_stmt = $pdo->query("SELECT DISTINCT department_name FROM patent_cache ORDER BY department_name ASC");
$departments = $dept_stmt->fetchAll(PDO::FETCH_COLUMN);

$query = isset($_GET['q']) ? trim($_GET['q']) : '';
$selected_dept = isset($_GET['dept']) ? $_GET['dept'] : '';
$results = [];
$searched = false;

if ($query !== '' || $selected_dept !== '') {
    $searched = true;
    $stmt = $pdo->query("SELECT department_name, content FROM patent_cache");
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $dept = $row['department_name'];
        if ($selected_dept !== '' && $dept !== $selected_dept) continue;
        
        $json = json_decode($row['content'], true);
        if (isset($json['data']) && is_array($json['data'])) {
            foreach ($json['data'] as $item) {
                $name = $item['Name (of the Staff/Research Scholar)'] ?? ($item['Name of Faculty'] ?? ''); // Supports both old and new keys
                $title = $item['Title'] ?? $item['Innovation'] ?? '';
                $app_num = $item['Patent Application Number'] ?? '';
                
                $match = true;
                if ($query !== '') {
                    if (stripos($name, $query) === false && stripos($title, $query) === false && stripos($app_num, $query) === false) {
                        $match = false;
                    }
                }
                if ($match) {
                    $item['Department'] = $dept;
                    $results[] = $item;
                }
            }
        }
    }
}

function formatCell($value) {
    if (is_array($value)) {
        if (empty($value)) return '<span class="text-muted small">No File</span>';
        $links = [];
        foreach ($value as $file) {
            $fileUrl = $file['url'] ?? '#';
            $links[] = '<a href="'.htmlspecialchars($fileUrl).'" target="_blank" class="btn btn-sm btn-outline-primary p-1"><i class="fa fa-download"></i> View</a>';
        }
        return implode(' ', $links);
    }
    if (filter_var($value, FILTER_VALIDATE_URL)) {
        return '<a href="'.htmlspecialchars($value).'" target="_blank">Link</a>';
    }
    return !empty($value) ? htmlspecialchars($value) : '<span class="text-secondary">—</span>';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include $_SERVER['DOCUMENT_ROOT'] . '/gtm.php'; ?><meta charset="UTF-8"><title>Patents Search</title><link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"><link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"></head>
<body class="bg-light p-4">
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><i class="fa fa-lightbulb text-primary"></i> Patents Database</h2>
        <a href="dashboard.php" class="btn btn-secondary">Back to Dashboard</a>
    </div>
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <form method="GET" class="row g-2">
                <div class="col-md-6"><input type="text" name="q" class="form-control form-control-lg" placeholder="Search Faculty, Title, Innovation or App No..." value="<?php echo htmlspecialchars($query); ?>" autofocus></div>
                <div class="col-md-4"><select name="dept" class="form-select form-select-lg"><option value="">All Departments</option><?php foreach ($departments as $d): ?><option value="<?php echo htmlspecialchars($d); ?>" <?php echo ($selected_dept === $d) ? 'selected' : ''; ?>><?php echo htmlspecialchars($d); ?></option><?php endforeach; ?></select></div>
                <div class="col-md-2"><button type="submit" class="btn btn-primary btn-lg w-100">Search</button></div>
            </form>
        </div>
    </div>
    
    <?php if ($searched): ?>
        <h5 class="mb-3">Results: <span class="badge bg-secondary"><?php echo count($results); ?></span></h5>
        <?php if (count($results) > 0): ?>
            <div class="card shadow-sm">
                <div class="table-responsive">
                    <table class="table table-hover mb-0 align-middle table-striped"><thead class="table-dark"><tr><th>Dept</th><th>Name</th><th>Title/Innovation</th><th>Patent Type</th><th>Application No</th><th>Status</th><th>Year</th><th>Affiliation</th><th>Link/File</th></tr></thead><tbody><?php foreach ($results as $row): ?><tr><td class="fw-bold text-primary small"><?php echo htmlspecialchars($row['Department']); ?></td><td><?php echo formatCell($row['Name of Faculty'] ?? ''); ?></td><td><small><?php echo formatCell($row['Title'] ?? $row['Innovation'] ?? ''); ?></small></td><td><?php echo formatCell($row['Patent Type'] ?? ''); ?></td><td><?php echo formatCell($row['Patent Application Number'] ?? ''); ?></td><td><?php echo formatCell($row['Status'] ?? ''); ?></td><td><?php echo formatCell($row['Year'] ?? ''); ?></td><td><?php echo formatCell($row['Affiliation at the time of grant of patent'] ?? ''); ?></td><td><?php echo formatCell($row['DOI link to Patent repository'] ?? ''); ?> <?php echo formatCell($row['Upload document'] ?? ''); ?></td></tr><?php endforeach; ?></tbody></table>
                </div>
            </div>
        <?php else: ?>
            <div class="alert alert-warning">No records found.</div>
        <?php endif; ?>
    <?php endif; ?>
</div>
</body>
</html>
