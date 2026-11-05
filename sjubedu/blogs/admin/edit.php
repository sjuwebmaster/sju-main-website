<?php
require_once __DIR__ . '/auth.php';
requireAuth();

$pdo = getDB();
$id   = (int)($_GET['id'] ?? 0);
$post = null;
$errors = [];

// Load existing post for edit
if ($id > 0) {
    $post = $pdo->prepare("SELECT * FROM blog_posts WHERE id = :id");
    $post->execute([':id' => $id]);
    $post = $post->fetch();
    if (!$post) { flash('Post not found.', 'danger'); header('Location: /admin/index.php'); exit; }
}

$categories = $pdo->query("SELECT id, name FROM blog_categories ORDER BY name")->fetchAll();

// ── Handle POST (save) ────────────────────────────────────────────
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verifyCsrf();

    $title       = trim($_POST['title'] ?? '');
    $slug        = trim($_POST['slug'] ?? '');
    $excerpt     = trim($_POST['excerpt'] ?? '');
    $content     = $_POST['content'] ?? '';        // raw HTML from editor
    $catId       = (int)($_POST['category_id'] ?? 0) ?: null;
    $author      = trim($_POST['author'] ?? 'SJU Editorial');
    $isPublished = isset($_POST['is_published']) ? 1 : 0;

    // Validate
    if ($title === '') $errors[] = 'Title is required.';
    if ($slug === '') $slug = makeSlug($title);
    $slug = makeSlug($slug);
    if ($slug === '') $errors[] = 'Slug is required.';
    if (trim(strip_tags($content)) === '') $errors[] = 'Content cannot be empty.';

    // Check slug uniqueness
    if (empty($errors)) {
        $slugCheck = $pdo->prepare("SELECT id FROM blog_posts WHERE slug = :slug AND id != :id");
        $slugCheck->execute([':slug' => $slug, ':id' => $id]);
        if ($slugCheck->fetch()) $errors[] = 'This slug is already used by another post. Choose a different one.';
    }

    // Featured image upload
    $featuredImg = $post['featured_img'] ?? null;
    if (!empty($_FILES['featured_img']['name'])) {
        $file = $_FILES['featured_img'];
        if (class_exists('finfo')) {
            $finfo = new finfo(FILEINFO_MIME_TYPE);
            $mime  = $finfo->file($file['tmp_name']);
        } elseif (function_exists('mime_content_type')) {
            $mime  = mime_content_type($file['tmp_name']);
        } else {
            $mime  = $file['type'];
        }

        if (!in_array($mime, BLOG_ALLOWED_IMG_TYPES, true)) {
            $errors[] = 'Invalid image type. Allowed: JPG, PNG, GIF, WebP.';
        } elseif ($file['size'] > BLOG_MAX_IMG_SIZE) {
            $errors[] = 'Image too large (max 5 MB).';
        } else {
            $ext     = pathinfo($file['name'], PATHINFO_EXTENSION);
            $newName = bin2hex(random_bytes(12)) . '.' . strtolower($ext);
            $dest    = __DIR__ . '/../uploads/blog/' . $newName;
            if (move_uploaded_file($file['tmp_name'], $dest)) {
                // Delete old image if replacing
                if ($featuredImg && file_exists(__DIR__ . '/../uploads/blog/' . $featuredImg)) {
                    unlink(__DIR__ . '/../uploads/blog/' . $featuredImg);
                }
                $featuredImg = $newName;
            } else {
                $errors[] = 'Image upload failed. Check server write permissions on uploads/blog/.';
            }
        }
    }

    if (empty($errors)) {
        if ($id > 0) {
            // Update
            $stmt = $pdo->prepare(
                "UPDATE blog_posts SET title=:title, slug=:slug, excerpt=:excerpt, content=:content,
                 featured_img=:img, category_id=:cat, author=:author, is_published=:pub
                 WHERE id=:id"
            );
            $stmt->execute([
                ':title' => $title, ':slug' => $slug, ':excerpt' => $excerpt,
                ':content' => $content, ':img' => $featuredImg, ':cat' => $catId,
                ':author' => $author, ':pub' => $isPublished, ':id' => $id,
            ]);
            flash("Post \"{$title}\" updated successfully.");
        } else {
            // Insert
            $stmt = $pdo->prepare(
                "INSERT INTO blog_posts (title, slug, excerpt, content, featured_img, category_id, author, is_published)
                 VALUES (:title, :slug, :excerpt, :content, :img, :cat, :author, :pub)"
            );
            $stmt->execute([
                ':title' => $title, ':slug' => $slug, ':excerpt' => $excerpt,
                ':content' => $content, ':img' => $featuredImg, ':cat' => $catId,
                ':author' => $author, ':pub' => $isPublished,
            ]);
            flash("Post \"{$title}\" created successfully.");
        }
        header('Location: /admin/index.php'); exit;
    }

    // Re-populate form on error
    $post = array_merge($post ?? [], compact('title', 'slug', 'excerpt', 'content', 'catId', 'author', 'isPublished'));
    $post['category_id']  = $catId;
    $post['is_published'] = $isPublished;
    $post['featured_img'] = $featuredImg;
}

$pageTitle = $id > 0 ? 'Edit Post' : 'New Post';
$flash = getFlash();
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $pageTitle ?> | SJU Blog Admin</title>
    <link rel="icon" href="https://www.sju.edu.in/assets/img/favicon.png" type="image/png">
    <link rel="stylesheet" href="https://www.sju.edu.in/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Summernote Bootstrap 5 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs5.min.css">

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
        .sidebar-nav .nav-section {
            padding: .9rem 1.3rem .3rem;
            font-size: .7rem; font-weight: 700; letter-spacing: .1em;
            text-transform: uppercase; color: rgba(255,255,255,.35);
        }
        .sidebar-nav a.logout-link { color: rgba(255,80,80,.8); }
        .sidebar-nav a.logout-link:hover { background: rgba(220,53,69,.15); color: #ff6b6b; }

        .admin-main { margin-left: 230px; padding: 2rem; }
        .admin-topbar {
            background: #fff; border-radius: 10px; padding: .9rem 1.4rem;
            display: flex; align-items: center; justify-content: space-between;
            margin-bottom: 1.8rem; box-shadow: 0 1px 6px rgba(0,0,0,.07);
        }
        .admin-topbar h4 { margin: 0; color: var(--navy); font-weight: 700; font-size: 1.1rem; }

        .card-section { background: #fff; border-radius: 12px; box-shadow: 0 1px 8px rgba(0,0,0,.07); margin-bottom: 1.5rem; }
        .card-section .card-head {
            padding: 1rem 1.4rem; border-bottom: 1px solid #f0f0f0;
            font-weight: 700; color: var(--navy); font-size: .95rem;
        }
        .card-section .card-body-inner { padding: 1.4rem; }

        .form-label { font-weight: 600; font-size: .88rem; color: #444; }
        .form-control:focus, .form-select:focus { border-color: var(--gold); box-shadow: 0 0 0 .2rem rgba(197,160,89,.2); }

        .btn-sju { background: var(--navy); color: #fff; border: none; }
        .btn-sju:hover { background: var(--gold); color: #fff; }
        .btn-gold { background: var(--gold); color: #fff; border: none; }
        .btn-gold:hover { background: #b08c42; color: #fff; }

        /* Summernote overrides */
        .note-editor.note-frame { border-radius: 8px; border-color: #dee2e6; }
        .note-toolbar { background: #f8f9fa; border-bottom: 1px solid #dee2e6; border-radius: 8px 8px 0 0; }
        .note-editable { min-height: 380px; }
        .note-codable { min-height: 380px; font-family: 'Courier New', monospace; font-size: .88rem; background: #1e1e2e; color: #cdd6f4; }

        /* Image preview */
        #img-preview { max-height: 160px; border-radius: 8px; display: none; }

        /* Slug auto-gen notice */
        #slug-status { font-size: .75rem; }

        /* Sticky save bar */
        .save-bar {
            position: sticky; bottom: 0; background: #fff;
            border-top: 1px solid #e8e8e8; padding: 1rem 1.4rem;
            display: flex; gap: .7rem; align-items: center;
            box-shadow: 0 -4px 12px rgba(0,0,0,.06); z-index: 50;
            border-radius: 0 0 12px 12px; margin-top: -1px;
        }
    </style>
</head>
<body>

<!-- Sidebar -->
<div class="admin-sidebar d-flex flex-column">
    <div class="sidebar-logo">
        <img src="https://www.sju.edu.in/assets/img/st-joseph-university-logo.png" alt="SJU">
        <span>Blog Admin Panel</span>
    </div>
    <nav class="sidebar-nav d-flex flex-column flex-grow-1 py-2">
        <div class="nav-section">Content</div>
        <a href="/admin/index.php"><i class="fas fa-th-large"></i> Dashboard</a>
        <a href="/admin/edit.php" class="<?= $id === 0 ? 'active' : '' ?>"><i class="fas fa-plus-circle"></i> New Post</a>
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
        <h4>
            <i class="fas fa-<?= $id > 0 ? 'edit' : 'plus-circle' ?> me-2 text-warning"></i>
            <?= $pageTitle ?>
            <?php if ($id > 0 && $post): ?>
                <span class="text-muted fw-normal small ms-2">#<?= $id ?></span>
            <?php endif; ?>
        </h4>
        <div class="d-flex gap-2">
            <?php if ($id > 0): ?>
            <a href="https://blogs.sju.edu.in/post.php?slug=<?= urlencode($post['slug'] ?? '') ?>"
               target="_blank" class="btn btn-sm btn-outline-secondary">
                <i class="fas fa-eye me-1"></i>Preview
            </a>
            <?php endif; ?>
            <a href="/admin/index.php" class="btn btn-sm btn-outline-secondary">
                <i class="fas fa-arrow-left me-1"></i>Back
            </a>
        </div>
    </div>

    <?php if (!empty($errors)): ?>
    <div class="alert alert-danger mb-3">
        <strong>Please fix the following:</strong>
        <ul class="mb-0 mt-1">
            <?php foreach ($errors as $e): ?><li><?= htmlspecialchars($e) ?></li><?php endforeach; ?>
        </ul>
    </div>
    <?php endif; ?>

    <form method="POST" enctype="multipart/form-data" id="post-form">
        <input type="hidden" name="csrf_token" value="<?= csrfToken() ?>">

        <div class="row g-4">

            <!-- Left column: main content -->
            <div class="col-lg-8">

                <!-- Title & Slug -->
                <div class="card-section">
                    <div class="card-head"><i class="fas fa-heading me-2 text-warning"></i>Post Details</div>
                    <div class="card-body-inner">
                        <div class="mb-3">
                            <label class="form-label">Title <span class="text-danger">*</span></label>
                            <input type="text" name="title" id="title" class="form-control form-control-lg"
                                   placeholder="Enter post title…"
                                   value="<?= htmlspecialchars($post['title'] ?? '') ?>" required>
                        </div>
                        <div class="mb-0">
                            <label class="form-label">Slug (URL)</label>
                            <div class="input-group">
                                <span class="input-group-text text-muted" style="font-size:.82rem;">blogs.sju.edu.in/post.php?slug=</span>
                                <input type="text" name="slug" id="slug" class="form-control"
                                       value="<?= htmlspecialchars($post['slug'] ?? '') ?>"
                                       placeholder="auto-generated from title">
                                <button type="button" class="btn btn-outline-secondary btn-sm" id="regen-slug" title="Regenerate from title">
                                    <i class="fas fa-sync-alt"></i>
                                </button>
                            </div>
                            <div id="slug-status" class="text-muted mt-1"></div>
                        </div>
                    </div>
                </div>

                <!-- Content Editor -->
                <div class="card-section">
                    <div class="card-head d-flex align-items-center justify-content-between">
                        <span><i class="fas fa-align-left me-2 text-warning"></i>Content</span>
                        <span class="text-muted small fw-normal">Use <kbd>&lt;/&gt;</kbd> in the toolbar to edit raw HTML directly</span>
                    </div>
                    <div class="card-body-inner pb-0">
                        <textarea id="content" name="content"><?= htmlspecialchars($post['content'] ?? '') ?></textarea>
                    </div>
                    <div class="save-bar">
                        <button type="submit" name="is_published" value="1" class="btn btn-sju px-4" id="save-publish">
                            <i class="fas fa-check me-1"></i>
                            <?= ($post['is_published'] ?? 0) ? 'Update Post' : 'Publish Post' ?>
                        </button>
                        <button type="submit" class="btn btn-outline-secondary px-3" id="save-draft">
                            <i class="fas fa-save me-1"></i>Save as Draft
                        </button>
                        <a href="/admin/index.php" class="btn btn-link text-muted">Cancel</a>
                    </div>
                </div>

            </div>

            <!-- Right column: metadata -->
            <div class="col-lg-4">

                <!-- Publish status -->
                <div class="card-section mb-3">
                    <div class="card-head"><i class="fas fa-toggle-on me-2 text-warning"></i>Status</div>
                    <div class="card-body-inner">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="is_published" id="is_published"
                                   value="1" <?= ($post['is_published'] ?? 1) ? 'checked' : '' ?>>
                            <label class="form-check-label fw-semibold" for="is_published">Published</label>
                        </div>
                        <div class="text-muted small mt-1">Uncheck to save as draft.</div>
                    </div>
                </div>

                <!-- Category & Author -->
                <div class="card-section mb-3">
                    <div class="card-head"><i class="fas fa-tag me-2 text-warning"></i>Category &amp; Author</div>
                    <div class="card-body-inner">
                        <div class="mb-3">
                            <label class="form-label">Category</label>
                            <select name="category_id" class="form-select">
                                <option value="">— Uncategorised —</option>
                                <?php foreach ($categories as $cat): ?>
                                    <option value="<?= $cat['id'] ?>"
                                        <?= ((int)($post['category_id'] ?? 0) === (int)$cat['id']) ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($cat['name']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <a href="/admin/categories.php" class="text-muted small d-block mt-1">
                                <i class="fas fa-plus me-1"></i>Manage categories
                            </a>
                        </div>
                        <div class="mb-0">
                            <label class="form-label">Author</label>
                            <input type="text" name="author" class="form-control"
                                   value="<?= htmlspecialchars($post['author'] ?? 'SJU Editorial') ?>">
                        </div>
                    </div>
                </div>

                <!-- Excerpt -->
                <div class="card-section mb-3">
                    <div class="card-head"><i class="fas fa-align-right me-2 text-warning"></i>Excerpt</div>
                    <div class="card-body-inner">
                        <textarea name="excerpt" class="form-control" rows="3"
                                  placeholder="Short summary shown on the blog listing (optional)…"
                                  maxlength="500"><?= htmlspecialchars($post['excerpt'] ?? '') ?></textarea>
                        <div class="text-muted small mt-1">Max 500 characters.</div>
                    </div>
                </div>

                <!-- Featured image -->
                <div class="card-section mb-3">
                    <div class="card-head"><i class="fas fa-image me-2 text-warning"></i>Featured Image</div>
                    <div class="card-body-inner">
                        <?php if (!empty($post['featured_img'])): ?>
                        <div class="mb-2">
                            <img src="/uploads/blog/<?= htmlspecialchars($post['featured_img']) ?>"
                                 class="img-fluid rounded" style="max-height:140px;" alt="Current image">
                            <div class="text-muted small mt-1">Current image. Upload below to replace.</div>
                        </div>
                        <?php endif; ?>
                        <img id="img-preview" alt="Preview">
                        <input type="file" name="featured_img" id="featured_img"
                               class="form-control" accept="image/*">
                        <div class="text-muted small mt-1">JPG, PNG, GIF, WebP · Max 5 MB</div>
                    </div>
                </div>

            </div>
        </div>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs5.min.js"></script>
<script>
$(function () {

    // ── Summernote editor ──
    $('#content').summernote({
        height: 420,
        toolbar: [
            ['style',   ['style']],
            ['font',    ['bold', 'italic', 'underline', 'strikethrough', 'clear']],
            ['color',   ['color']],
            ['para',    ['ul', 'ol', 'paragraph']],
            ['table',   ['table']],
            ['insert',  ['link', 'picture', 'video', 'hr']],
            ['view',    ['fullscreen', 'codeview']],   // codeview = raw HTML
            ['misc',    ['undo', 'redo']]
        ],
        callbacks: {
            onImageUpload: function (files) {
                for (let i = 0; i < files.length; i++) {
                    uploadImage(files[i]);
                }
            }
        },
        styleTags: ['p', 'blockquote', 'pre', 'h1', 'h2', 'h3', 'h4', 'h5', 'h6'],
        placeholder: 'Write your post content here…  Click </> in the toolbar to edit raw HTML directly.',
    });

    function uploadImage(file) {
        let data = new FormData();
        data.append('file', file);
        data.append('csrf_token', '<?= csrfToken() ?>');
        fetch('/admin/upload.php', { method: 'POST', body: data })
            .then(r => r.json())
            .then(res => {
                if (res.url) $('#content').summernote('insertImage', res.url);
                else alert('Image upload failed: ' + (res.error || 'Unknown error'));
            }).catch(() => alert('Image upload failed.'));
    }

    // ── Slug auto-generate ──
    const titleEl = document.getElementById('title');
    const slugEl  = document.getElementById('slug');
    const slugStatus = document.getElementById('slug-status');
    let slugManuallyEdited = '<?= !empty($post['slug']) ? 'true' : 'false' ?>' === 'true';

    function slugify(s) {
        return s.toLowerCase().replace(/[^a-z0-9\s-]/g, '').replace(/\s+/g, '-').replace(/^-+|-+$/g, '');
    }

    titleEl.addEventListener('input', function () {
        if (!slugManuallyEdited) slugEl.value = slugify(this.value);
    });

    slugEl.addEventListener('input', function () {
        slugManuallyEdited = this.value !== '';
        this.value = slugify(this.value);
    });

    document.getElementById('regen-slug').addEventListener('click', function () {
        slugEl.value = slugify(titleEl.value);
        slugManuallyEdited = false;
        slugStatus.textContent = 'Slug regenerated from title.';
        setTimeout(() => slugStatus.textContent = '', 2000);
    });

    // ── Featured image preview ──
    document.getElementById('featured_img').addEventListener('change', function () {
        const file = this.files[0];
        if (!file) return;
        const reader = new FileReader();
        reader.onload = e => {
            const preview = document.getElementById('img-preview');
            preview.src = e.target.result;
            preview.style.display = 'block';
        };
        reader.readAsDataURL(file);
    });

    // ── Save as Draft: uncheck published before submit ──
    document.getElementById('save-draft').addEventListener('click', function (e) {
        document.getElementById('is_published').checked = false;
    });
});
</script>
</body>
</html>
