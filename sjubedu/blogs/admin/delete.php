<?php
require_once __DIR__ . '/auth.php';
requireAuth();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: /admin/index.php'); exit;
}

verifyCsrf();

$id = (int)($_POST['id'] ?? 0);
if ($id <= 0) {
    flash('Invalid post ID.', 'danger');
    header('Location: /admin/index.php'); exit;
}

$pdo = getDB();
$post = $pdo->prepare("SELECT title, featured_img FROM blog_posts WHERE id = :id");
$post->execute([':id' => $id]);
$post = $post->fetch();

if (!$post) {
    flash('Post not found.', 'danger');
    header('Location: /admin/index.php'); exit;
}

// Delete featured image file if it exists
if (!empty($post['featured_img'])) {
    $imgPath = __DIR__ . '/../uploads/blog/' . $post['featured_img'];
    if (file_exists($imgPath)) unlink($imgPath);
}

$pdo->prepare("DELETE FROM blog_posts WHERE id = :id")->execute([':id' => $id]);

flash("Post \"{$post['title']}\" deleted.");
header('Location: /admin/index.php');
exit;
