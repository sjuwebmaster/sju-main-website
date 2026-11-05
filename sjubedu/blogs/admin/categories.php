<?php
require_once __DIR__ . '/auth.php';
requireAuth();

$pdo   = getDB();
$flash = null;

// Add category
if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['action'] ?? '') === 'add') {
    verifyCsrf();
    $name = trim($_POST['name'] ?? '');
    if ($name === '') {
        flash('Category name cannot be empty.', 'danger');
    } else {
        try {
            $pdo->prepare("INSERT INTO blog_categories (name) VALUES (:name)")->execute([':name' => $name]);
            flash("Category \"{$name}\" added.");
        } catch (PDOException $e) {
            flash('Category already exists.', 'danger');
        }
    }
    header('Location: /admin/categories.php'); exit;
}

// Delete category
if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['action'] ?? '') === 'delete') {
    verifyCsrf();
    $cid = (int)($_POST['id'] ?? 0);
    $count = (int)$pdo->prepare("SELECT COUNT(*) FROM blog_posts WHERE category_id = :id")->execute([':id' => $cid]) ? $pdo->query("SELECT COUNT(*) FROM blog_posts WHERE category_id = {$cid}")->fetchColumn() : 0;
    // Safer count
    $cntStmt = $pdo->prepare("SELECT COUNT(*) FROM blog_posts WHERE category_id = :id");
    $cntStmt->execute([':id' => $cid]);
    $count = (int)$cntStmt->fetchColumn();

    if ($count > 0) {
        flash("Cannot delete: {$count} post(s) use this category. Reassign them first.", 'danger');
    } else {
        $nameStmt = $pdo->prepare("SELECT name FROM blog_categories WHERE id = :id");
        $nameStmt->execute([':id' => $cid]);
        $catName = $nameStmt->fetchColumn();
        $pdo->prepare("DELETE FROM blog_categories WHERE id = :id")->execute([':id' => $cid]);
        flash("Category \"{$catName}\" deleted.");
    }
    header('Location: /admin/categories.php'); exit;
}

$categories = $pdo->query(
    "SELECT c.id, c.name, COUNT(p.id) AS post_count
     FROM blog_categories c
     LEFT JOIN blog_posts p ON p.category_id = c.id
     GROUP BY c.id, c.name
     ORDER BY c.name"
)->fetchAll();

$flash = getFlash();
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Categories | SJU Blog Admin</title>
    <link rel="icon" href="https://www.sju.edu.in/assets/img/favicon.png" type="image/png">
    <link rel="stylesheet" href="https://www.sju.edu.in/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        :root { --navy: #002147; --gold: #C5A059; }
        body { background: #f4f6f9; font-family: 'Segoe UI', Arial, sans-serif; }
        .admin-sidebar {
            width: 230px; min-height: 100vh; background: var(--navy);
            position: fixed; top: 0; left: 0; z-index: 100;
        }
        .sidebar-logo { padding: 1.4rem 1.2rem; border-bottom: 1px solid rgba(255,255,255,.1); }
        .sidebar-logo img { height: 42px; }
        .sidebar-logo span { display: block; color: var(--gold); font-size: .78rem; font-weight: 700; letter-spacing: .05em; margin-top: .3rem; }
        .sidebar-nav a {
            display: flex; align-items: center; gap: .7rem;
            padding: .75rem 1.3rem; color: rgba(255,255,255,.75);
            text-decoration: none; font-size: .9rem; font-weight: 500;
            transition: background .15s, color .15s;
        }
        .sidebar-nav a:hover, .sidebar-nav a.active { background: rgba(255,255,255,.1); color: #fff; }
        .sidebar-nav a i { width: 18px; text-align: center; }
        .sidebar-nav .nav-section { padding: .9rem 1.3rem .3rem; font-size: .7rem; font-weight: 700; letter-spacing: .1em; text-transform: uppercase; color: rgba(255,255,255,.35); }
        .sidebar-nav a.logout-link { color: rgba(255,80,80,.8); }
        .sidebar-nav a.logout-link:hover { background: rgba(220,53,69,.15); color: #ff6b6b; }
        .admin-main { margin-left: 230px; padding: 2rem; max-width: 760px; }
        .admin-topbar { background: #fff; border-radius: 10px; padding: .9rem 1.4rem; display: flex; align-items: center; justify-content: space-between; margin-bottom: 1.8rem; box-shadow: 0 1px 6px rgba(0,0,0,.07); }
        .admin-topbar h4 { margin: 0; color: var(--navy); font-weight: 700; font-size: 1.1rem; }
        .card-section { background: #fff; border-radius: 12px; box-shadow: 0 1px 8px rgba(0,0,0,.07); margin-bottom: 1.5rem; }
        .card-section .card-head { padding: 1rem 1.4rem; border-bottom: 1px solid #f0f0f0; font-weight: 700; color: var(--navy); font-size: .95rem; }
        .card-section .card-body-inner { padding: 1.4rem; }
        .form-control:focus { border-color: var(--gold); box-shadow: 0 0 0 .2rem rgba(197,160,89,.2); }
        .btn-sju { background: var(--navy); color: #fff; border: none; }
        .btn-sju:hover { background: var(--gold); color: #fff; }
        .table th { font-size: .78rem; font-weight: 700; text-transform: uppercase; letter-spacing: .04em; color: #888; }
        .table td { vertical-align: middle; }
        .badge-count { background: #e0eaff; color: var(--navy); font-size: .78rem; font-weight: 700; padding: .2rem .65rem; border-radius: 20px; }
    </style>
</head>
<body>

<div class="admin-sidebar d-flex flex-column">
    <div class="sidebar-logo">
        <img src="https://www.sju.edu.in/assets/img/st-joseph-university-logo.png" alt="SJU">
        <span>Blog Admin Panel</span>
    </div>
    <nav class="sidebar-nav d-flex flex-column flex-grow-1 py-2">
        <div class="nav-section">Content</div>
        <a href="/admin/index.php"><i class="fas fa-th-large"></i> Dashboard</a>
        <a href="/admin/edit.php"><i class="fas fa-plus-circle"></i> New Post</a>
        <a href="/admin/categories.php" class="active"><i class="fas fa-tags"></i> Categories</a>
        <div class="nav-section">Site</div>
        <a href="https://blogs.sju.edu.in/" target="_blank"><i class="fas fa-external-link-alt"></i> View Blog</a>
        <a href="https://www.sju.edu.in" target="_blank"><i class="fas fa-university"></i> Main Website</a>
        <div class="mt-auto">
            <a href="/admin/logout.php" class="logout-link"><i class="fas fa-sign-out-alt"></i> Logout</a>
        </div>
    </nav>
</div>

<div class="admin-main">
    <div class="admin-topbar">
        <h4><i class="fas fa-tags me-2 text-warning"></i>Categories</h4>
        <a href="/admin/index.php" class="btn btn-sm btn-outline-secondary"><i class="fas fa-arrow-left me-1"></i>Back</a>
    </div>

    <?php if ($flash): ?>
    <div class="alert alert-<?= $flash['type'] === 'success' ? 'success' : 'danger' ?> alert-dismissible mb-3 py-2">
        <?= htmlspecialchars($flash['msg']) ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    <?php endif; ?>

    <!-- Add category -->
    <div class="card-section mb-4">
        <div class="card-head"><i class="fas fa-plus me-2 text-warning"></i>Add New Category</div>
        <div class="card-body-inner">
            <form method="POST" class="d-flex gap-2">
                <input type="hidden" name="csrf_token" value="<?= csrfToken() ?>">
                <input type="hidden" name="action" value="add">
                <input type="text" name="name" class="form-control" placeholder="Category name…" required maxlength="80">
                <button type="submit" class="btn btn-sju px-4">Add</button>
            </form>
        </div>
    </div>

    <!-- Category list -->
    <div class="card-section">
        <div class="card-head"><i class="fas fa-list me-2 text-warning"></i>All Categories (<?= count($categories) ?>)</div>
        <?php if (empty($categories)): ?>
            <div class="text-center py-4 text-muted">No categories yet.</div>
        <?php else: ?>
        <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr><th>Name</th><th>Posts</th><th>Action</th></tr>
            </thead>
            <tbody>
            <?php foreach ($categories as $cat): ?>
            <tr>
                <td class="fw-semibold"><?= htmlspecialchars($cat['name']) ?></td>
                <td><span class="badge-count"><?= (int)$cat['post_count'] ?></span></td>
                <td>
                    <form method="POST" onsubmit="return confirm('Delete category \'<?= htmlspecialchars($cat['name'], ENT_QUOTES) ?>\'?')">
                        <input type="hidden" name="csrf_token" value="<?= csrfToken() ?>">
                        <input type="hidden" name="action" value="delete">
                        <input type="hidden" name="id" value="<?= (int)$cat['id'] ?>">
                        <button type="submit" class="btn btn-sm btn-outline-danger"
                                <?= $cat['post_count'] > 0 ? 'disabled title="Reassign posts first"' : '' ?>>
                            <i class="fas fa-trash"></i>
                        </button>
                    </form>
                </td>
            </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        </div>
        <?php endif; ?>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
