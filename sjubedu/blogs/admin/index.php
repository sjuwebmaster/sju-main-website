<?php
require_once __DIR__ . '/auth.php';
requireAuth();

$pdo = getDB();

// Stats
$stats = $pdo->query("
    SELECT
        COUNT(*) AS total,
        SUM(is_published = 1) AS published,
        SUM(is_published = 0) AS drafts,
        COALESCE(SUM(like_count), 0) AS total_likes
    FROM blog_posts
")->fetch();

$catCount = (int)$pdo->query("SELECT COUNT(*) FROM blog_categories")->fetchColumn();

// Filters
$filterCat  = (int)($_GET['cat'] ?? 0);
$filterStatus = $_GET['status'] ?? '';
$search     = trim($_GET['q'] ?? '');

$where  = ['1=1'];
$params = [];
if ($filterCat > 0) { $where[] = 'p.category_id = :cat'; $params[':cat'] = $filterCat; }
if ($filterStatus === 'published') { $where[] = 'p.is_published = 1'; }
if ($filterStatus === 'draft') { $where[] = 'p.is_published = 0'; }
if ($search !== '') { $where[] = 'p.title LIKE :q'; $params[':q'] = '%' . $search . '%'; }

$whereSQL = 'WHERE ' . implode(' AND ', $where);
$stmt = $pdo->prepare(
    "SELECT p.id, p.title, p.slug, p.author, p.like_count, p.is_published, p.created_at,
            c.name AS category
     FROM blog_posts p
     LEFT JOIN blog_categories c ON c.id = p.category_id
     $whereSQL
     ORDER BY p.created_at DESC"
);
$stmt->execute($params);
$posts = $stmt->fetchAll();

$categories = $pdo->query("SELECT id, name FROM blog_categories ORDER BY name")->fetchAll();
$flash = getFlash();
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard | SJU Blog Admin</title>
    <link rel="icon" href="https://www.sju.edu.in/assets/img/favicon.png" type="image/png">
    <link rel="stylesheet" href="https://www.sju.edu.in/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        :root { --navy: #002147; --gold: #C5A059; }
        body { background: #f4f6f9; font-family: 'Segoe UI', Arial, sans-serif; }

        /* Sidebar */
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
        .sidebar-nav .nav-section {
            padding: .9rem 1.3rem .3rem;
            font-size: .7rem; font-weight: 700; letter-spacing: .1em;
            text-transform: uppercase; color: rgba(255,255,255,.35);
        }
        .sidebar-nav a.logout-link { color: rgba(255,80,80,.8); margin-top: auto; }
        .sidebar-nav a.logout-link:hover { background: rgba(220,53,69,.15); color: #ff6b6b; }

        /* Main */
        .admin-main { margin-left: 230px; padding: 2rem; }
        .admin-topbar {
            background: #fff; border-radius: 10px; padding: .9rem 1.4rem;
            display: flex; align-items: center; justify-content: space-between;
            margin-bottom: 1.8rem; box-shadow: 0 1px 6px rgba(0,0,0,.07);
        }
        .admin-topbar h4 { margin: 0; color: var(--navy); font-weight: 700; font-size: 1.1rem; }

        /* Stat cards */
        .stat-card { background: #fff; border-radius: 12px; padding: 1.3rem 1.5rem; box-shadow: 0 1px 8px rgba(0,0,0,.07); }
        .stat-card .stat-icon { width: 44px; height: 44px; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 1.2rem; }
        .stat-card .stat-value { font-size: 1.8rem; font-weight: 800; color: var(--navy); line-height: 1; }
        .stat-card .stat-label { font-size: .8rem; color: #888; margin-top: .2rem; }

        /* Table */
        .admin-table-wrap { background: #fff; border-radius: 12px; box-shadow: 0 1px 8px rgba(0,0,0,.07); overflow: hidden; }
        .admin-table-wrap .table-header {
            padding: 1.1rem 1.4rem; border-bottom: 1px solid #f0f0f0;
            display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: .6rem;
        }
        .admin-table-wrap .table-header h6 { margin: 0; font-weight: 700; color: var(--navy); }
        .table th { font-size: .78rem; font-weight: 700; text-transform: uppercase; letter-spacing: .04em; color: #888; border-bottom: 2px solid #f0f0f0; }
        .table td { vertical-align: middle; font-size: .88rem; }
        .badge-pub { background: #d1fae5; color: #065f46; font-weight: 600; font-size: .72rem; padding: .28rem .65rem; border-radius: 20px; }
        .badge-draft { background: #fef3c7; color: #92400e; font-weight: 600; font-size: .72rem; padding: .28rem .65rem; border-radius: 20px; }

        .btn-sju { background: var(--navy); color: #fff; border: none; }
        .btn-sju:hover { background: var(--gold); color: #fff; }
        .btn-gold { background: var(--gold); color: #fff; border: none; }
        .btn-gold:hover { background: #b08c42; color: #fff; }

        /* Filter bar */
        .filter-bar { display: flex; gap: .5rem; flex-wrap: wrap; align-items: center; }
        .filter-bar .form-control, .filter-bar .form-select { font-size: .85rem; padding: .35rem .75rem; }

        /* ── Mobile: sidebar becomes off-canvas drawer ── */
        .sidebar-toggle {
            display: none; position: fixed; top: .8rem; left: .8rem; z-index: 200;
            background: var(--navy); color: #fff; border: none; border-radius: 8px;
            padding: .45rem .7rem; font-size: 1.1rem; cursor: pointer;
        }
        @media (max-width: 900px) {
            .sidebar-toggle { display: flex; align-items: center; }
            .admin-sidebar {
                position: fixed; left: -240px; top: 0; width: 230px; z-index: 150;
                transition: left .25s ease; box-shadow: 4px 0 20px rgba(0,0,0,.2);
            }
            .admin-sidebar.open { left: 0; }
            .admin-main { margin-left: 0; padding: 1rem; padding-top: 3.5rem; }
            .sidebar-overlay {
                display: none; position: fixed; inset: 0;
                background: rgba(0,0,0,.45); z-index: 140;
            }
            .sidebar-overlay.open { display: block; }
        }
    </style>
</head>
<body>

<!-- Mobile sidebar toggle -->
<button class="sidebar-toggle" id="sidebarToggle" aria-label="Open menu">
    <i class="fas fa-bars"></i>
</button>
<div class="sidebar-overlay" id="sidebarOverlay"></div>

<!-- Sidebar -->
<div class="admin-sidebar d-flex flex-column" id="adminSidebar">
    <div class="sidebar-logo">
        <img src="https://www.sju.edu.in/assets/img/st-joseph-university-logo.png" alt="SJU">
        <span>Blog Admin Panel</span>
    </div>
    <nav class="sidebar-nav d-flex flex-column flex-grow-1 py-2">
        <div class="nav-section">Content</div>
        <a href="/admin/index.php" class="active"><i class="fas fa-th-large"></i> Dashboard</a>
        <a href="/admin/edit.php"><i class="fas fa-plus-circle"></i> New Post</a>
        <a href="/admin/categories.php"><i class="fas fa-tags"></i> Categories</a>
        <div class="nav-section">Site</div>
        <a href="https://blogs.sju.edu.in/" target="_blank"><i class="fas fa-external-link-alt"></i> View Blog</a>
        <a href="https://www.sju.edu.in" target="_blank"><i class="fas fa-university"></i> Main Website</a>
        <div class="mt-auto">
            <a href="/admin/logout.php" class="logout-link"><i class="fas fa-sign-out-alt"></i> Logout</a>
        </div>
    </nav>
</div>

<!-- Main content -->
<div class="admin-main">

    <div class="admin-topbar">
        <h4><i class="fas fa-th-large me-2 text-warning"></i>Dashboard</h4>
        <a href="/admin/edit.php" class="btn btn-sm btn-sju px-3">
            <i class="fas fa-plus me-1"></i> New Post
        </a>
    </div>

    <?php if ($flash): ?>
    <div class="alert alert-<?= $flash['type'] === 'success' ? 'success' : 'danger' ?> alert-dismissible mb-3 py-2" role="alert">
        <?= htmlspecialchars($flash['msg']) ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    <?php endif; ?>

    <!-- Stats -->
    <div class="row g-3 mb-4">
        <div class="col-6 col-md-3">
            <div class="stat-card d-flex align-items-center gap-3">
                <div class="stat-icon" style="background:#e0eaff;color:var(--navy)"><i class="fas fa-file-alt"></i></div>
                <div>
                    <div class="stat-value"><?= (int)$stats['total'] ?></div>
                    <div class="stat-label">Total Posts</div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="stat-card d-flex align-items-center gap-3">
                <div class="stat-icon" style="background:#d1fae5;color:#065f46"><i class="fas fa-check-circle"></i></div>
                <div>
                    <div class="stat-value"><?= (int)$stats['published'] ?></div>
                    <div class="stat-label">Published</div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="stat-card d-flex align-items-center gap-3">
                <div class="stat-icon" style="background:#fef3c7;color:#92400e"><i class="fas fa-pencil-alt"></i></div>
                <div>
                    <div class="stat-value"><?= (int)$stats['drafts'] ?></div>
                    <div class="stat-label">Drafts</div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="stat-card d-flex align-items-center gap-3">
                <div class="stat-icon" style="background:#ffe4e6;color:#9f1239"><i class="fas fa-heart"></i></div>
                <div>
                    <div class="stat-value"><?= (int)$stats['total_likes'] ?></div>
                    <div class="stat-label">Total Likes</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Posts table -->
    <div class="admin-table-wrap">
        <div class="table-header">
            <h6><i class="fas fa-list me-2 text-warning"></i>All Posts (<?= count($posts) ?>)</h6>
            <form method="GET" class="filter-bar">
                <input type="text" name="q" class="form-control" placeholder="Search title…" value="<?= htmlspecialchars($search) ?>" style="width:160px;">
                <select name="cat" class="form-select" style="width:140px;">
                    <option value="">All Categories</option>
                    <?php foreach ($categories as $c): ?>
                        <option value="<?= $c['id'] ?>" <?= $filterCat === (int)$c['id'] ? 'selected' : '' ?>><?= htmlspecialchars($c['name']) ?></option>
                    <?php endforeach; ?>
                </select>
                <select name="status" class="form-select" style="width:120px;">
                    <option value="">All Status</option>
                    <option value="published" <?= $filterStatus === 'published' ? 'selected' : '' ?>>Published</option>
                    <option value="draft" <?= $filterStatus === 'draft' ? 'selected' : '' ?>>Draft</option>
                </select>
                <button type="submit" class="btn btn-sm btn-sju px-3">Filter</button>
                <?php if ($search || $filterCat || $filterStatus): ?>
                    <a href="/admin/index.php" class="btn btn-sm btn-outline-secondary">Clear</a>
                <?php endif; ?>
            </form>
        </div>

        <?php if (empty($posts)): ?>
            <div class="text-center py-5 text-muted">
                <i class="fas fa-file-alt fa-2x mb-2 d-block" style="color:#ddd;"></i>
                No posts found. <a href="/admin/edit.php">Create your first post &rarr;</a>
            </div>
        <?php else: ?>
        <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Title</th>
                    <th>Category</th>
                    <th>Author</th>
                    <th>Status</th>
                    <th><i class="fas fa-heart"></i></th>
                    <th>Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($posts as $post): ?>
            <tr>
                <td class="text-muted"><?= (int)$post['id'] ?></td>
                <td>
                    <strong><?= htmlspecialchars($post['title']) ?></strong>
                    <div class="text-muted" style="font-size:.75rem;"><?= htmlspecialchars($post['slug']) ?></div>
                </td>
                <td><?= htmlspecialchars($post['category'] ?? '—') ?></td>
                <td><?= htmlspecialchars($post['author']) ?></td>
                <td>
                    <?php if ($post['is_published']): ?>
                        <span class="badge-pub">Published</span>
                    <?php else: ?>
                        <span class="badge-draft">Draft</span>
                    <?php endif; ?>
                </td>
                <td><?= (int)$post['like_count'] ?></td>
                <td><?= date('d M Y', strtotime($post['created_at'])) ?></td>
                <td>
                    <div class="d-flex gap-1">
                        <a href="/admin/edit.php?id=<?= (int)$post['id'] ?>"
                           class="btn btn-sm btn-outline-primary" title="Edit">
                            <i class="fas fa-edit"></i>
                        </a>
                        <a href="https://blogs.sju.edu.in/post.php?slug=<?= urlencode($post['slug']) ?>"
                           target="_blank" class="btn btn-sm btn-outline-secondary" title="Preview">
                            <i class="fas fa-eye"></i>
                        </a>
                        <form method="POST" action="/admin/delete.php" onsubmit="return confirm('Delete this post permanently?')">
                            <input type="hidden" name="csrf_token" value="<?= csrfToken() ?>">
                            <input type="hidden" name="id" value="<?= (int)$post['id'] ?>">
                            <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </div>
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
<script>
(function () {
    const toggle  = document.getElementById('sidebarToggle');
    const sidebar = document.getElementById('adminSidebar');
    const overlay = document.getElementById('sidebarOverlay');
    function openSidebar()  { sidebar.classList.add('open'); overlay.classList.add('open'); }
    function closeSidebar() { sidebar.classList.remove('open'); overlay.classList.remove('open'); }
    toggle.addEventListener('click', openSidebar);
    overlay.addEventListener('click', closeSidebar);
})();
</script>
</body>
</html>
