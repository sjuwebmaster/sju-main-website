<?php
// Dynamic XML sitemap for blogs.sju.edu.in
// Cloudflare caches this for 24 hours (see .htaccess)
header('Content-Type: application/xml; charset=utf-8');
header('X-Robots-Tag: noindex');

$_candidates = ['/home/sjubedu/config.php', __DIR__ . '/../../config.php', __DIR__ . '/../public_html/V2/config.php'];
foreach ($_candidates as $_p) { if (file_exists($_p)) { require_once $_p; break; } }

try {
    $pdo = new PDO(
        "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4",
        DB_USER, DB_PASS,
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );
    $posts = $pdo->query(
        "SELECT slug, updated_at FROM blog_posts WHERE is_published = 1 ORDER BY updated_at DESC"
    )->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $posts = [];
}

echo '<?xml version="1.0" encoding="UTF-8"?>';
?>

<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
        xmlns:news="http://www.google.com/schemas/sitemap-news/0.9">

  <url>
    <loc>https://blogs.sju.edu.in/</loc>
    <changefreq>daily</changefreq>
    <priority>1.0</priority>
  </url>

  <?php foreach ($posts as $post): ?>
  <url>
    <loc>https://blogs.sju.edu.in/post.php?slug=<?= htmlspecialchars(urlencode($post['slug'])) ?></loc>
    <lastmod><?= date('Y-m-d', strtotime($post['updated_at'])) ?></lastmod>
    <changefreq>monthly</changefreq>
    <priority>0.8</priority>
  </url>
  <?php endforeach; ?>

</urlset>
