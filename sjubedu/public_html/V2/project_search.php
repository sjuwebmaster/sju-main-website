<?php
// project_search.php - Search Interface for Project Database

$config = file_exists('/home/sjubedu/config.php') ? '/home/sjubedu/config.php' : __DIR__ . '/../../config.php';
require_once $config;

// Database Connection
$db_host = 'localhost'; $db_name = 'sjubedu_faculty_data'; $db_user = 'sjubedu_developer'; $db_pass = 'SJU2022_sju';
try {
    $pdo = new PDO("mysql:host=$db_host;dbname=$db_name;charset=utf8mb4", $db_user, $db_pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

// Fetch Departments for Dropdown
$dept_stmt = $pdo->query("SELECT DISTINCT department_name FROM project_cache ORDER BY department_name ASC");
$departments = $dept_stmt->fetchAll(PDO::FETCH_COLUMN);

$query = isset($_GET['q']) ? trim($_GET['q']) : '';
$selected_dept = isset($_GET['dept']) ? $_GET['dept'] : '';
$results = [];
$searched = false;

if ($query !== '' || $selected_dept !== '') {
    $searched = true;
    // Fetch all departments from cache
    $stmt = $pdo->query("SELECT department_name, content FROM project_cache");
    
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $dept = $row['department_name'];
        
        // Filter by Department
        if ($selected_dept !== '' && $dept !== $selected_dept) {
            continue;
        }

        $json = json_decode($row['content'], true);
        
        if (isset($json['data']) && is_array($json['data'])) {
            foreach ($json['data'] as $proj) {
                $pi = $proj['Principal Investigator'] ?? '';
                $title = $proj['Title of Project'] ?? '';
                $agency = $proj['Funding Agency'] ?? '';
                
                // Search Logic (Case-insensitive)
                $match = true;
                if ($query !== '') {
                    if (stripos($pi, $query) === false && stripos($title, $query) === false && stripos($agency, $query) === false) {
                        $match = false;
                    }
                }
                
                if ($match) {
                    $proj['Department'] = $dept;
                    $results[] = $proj;
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
            $links[] = '<a href="'.$fileUrl.'" target="_blank" class="btn btn-sm btn-outline-primary p-1"><i class="fa fa-download"></i> View</a>';
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
    <meta charset="UTF-8">
    <title>Project Search</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-light p-4">
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><i class="fa fa-flask text-primary"></i> Research Project Database</h2>
        <a href="dashboard.php" class="btn btn-secondary">Back to Dashboard</a>
    </div>
    <div class="card shadow-sm mb-4"><div class="card-body"><form method="GET" class="row g-2"><div class="col-md-6"><input type="text" name="q" class="form-control form-control-lg" placeholder="Search Title, PI or Agency..." value="<?php echo htmlspecialchars($query); ?>" autofocus></div><div class="col-md-4"><select name="dept" class="form-select form-select-lg"><option value="">All Departments</option><?php foreach ($departments as $d): ?><option value="<?php echo htmlspecialchars($d); ?>" <?php echo ($selected_dept === $d) ? 'selected' : ''; ?>><?php echo htmlspecialchars($d); ?></option><?php endforeach; ?></select></div><div class="col-md-2"><button type="submit" class="btn btn-primary btn-lg w-100">Search</button></div></form></div></div>
    <?php if ($searched): ?>
        <h5 class="mb-3">Results: <span class="badge bg-secondary"><?php echo count($results); ?></span></h5>
        <?php if (count($results) > 0): ?>
            <div class="card shadow-sm"><div class="table-responsive"><table class="table table-hover mb-0 align-middle table-striped"><thead class="table-dark"><tr><th>Dept</th><th>Principal Investigator</th><th>Title</th><th>Funding Agency</th><th>Amount</th><th>Status</th><th>File</th></tr></thead><tbody><?php foreach ($results as $row): ?><tr><td class="fw-bold text-primary small"><?php echo htmlspecialchars($row['Department']); ?></td><td><?php echo formatCell($row['Principal Investigator'] ?? ''); ?></td><td><small><?php echo formatCell($row['Title of Project'] ?? ''); ?></small></td><td><?php echo formatCell($row['Funding Agency'] ?? ''); ?></td><td><?php echo formatCell($row['Amount'] ?? ''); ?></td><td><?php echo formatCell($row['Current Status'] ?? ''); ?></td><td><?php echo formatCell($row['Upload (Approval Order)'] ?? ''); ?></td></tr><?php endforeach; ?></tbody></table></div></div>
        <?php else: ?>
            <div class="alert alert-warning">No records found.</div>
        <?php endif; ?>
    <?php endif; ?>
</div>
</body>
</html>