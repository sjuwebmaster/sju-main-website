<?php
header('Content-Type: text/plain; charset=utf-8');
header('X-Content-Type-Options: nosniff');
header('Access-Control-Allow-Origin: https://blogs.sju.edu.in');
header('Access-Control-Allow-Methods: POST');

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || empty($_POST['post_id'])) {
    http_response_code(400); echo 'error'; exit;
}

$postId = (int)$_POST['post_id'];
if ($postId <= 0) { http_response_code(400); echo 'error'; exit; }

$config = file_exists('/home/sjubedu/config.php')
    ? '/home/sjubedu/config.php'
    : __DIR__ . '/../../config.php';
require_once $config;

try {
    $pdo = new PDO(
        "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4",
        DB_USER, DB_PASS,
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );

    $upd = $pdo->prepare("UPDATE blog_posts SET like_count = like_count + 1 WHERE id = :id AND is_published = 1");
    $upd->execute([':id' => $postId]);

    if ($upd->rowCount() === 0) { http_response_code(404); echo 'error'; exit; }

    $sel = $pdo->prepare("SELECT like_count FROM blog_posts WHERE id = :id");
    $sel->execute([':id' => $postId]);
    echo (int)$sel->fetchColumn();

} catch (PDOException $e) {
    http_response_code(500); echo 'error';
}
