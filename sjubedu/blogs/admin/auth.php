<?php
// Shared bootstrap for every admin page
require_once __DIR__ . '/../admin_config.php';

$config = file_exists('/home/sjubedu/config.php')
    ? '/home/sjubedu/config.php'
    : __DIR__ . '/../../../config.php';
require_once $config;

session_name(BLOG_ADMIN_SESSION);
session_start();

// Redirect to login if not authenticated
function requireAuth(): void {
    if (empty($_SESSION['blog_admin_logged_in'])) {
        header('Location: /admin/login.php');
        exit;
    }
}

// CSRF helpers
function csrfToken(): string {
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

function verifyCsrf(): void {
    $token = $_POST['csrf_token'] ?? '';
    if (!hash_equals($_SESSION['csrf_token'] ?? '', $token)) {
        http_response_code(403);
        die('Invalid CSRF token.');
    }
}

// DB connection (returns PDO)
function getDB(): PDO {
    static $pdo = null;
    if ($pdo === null) {
        $pdo = new PDO(
            "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4",
            DB_USER, DB_PASS,
            [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC]
        );
    }
    return $pdo;
}

function makeSlug(string $text): string {
    $text = strtolower(trim($text));
    $text = preg_replace('/[^a-z0-9\s-]/', '', $text);
    return trim(preg_replace('/\s+/', '-', $text), '-');
}

// Flash messages
function flash(string $msg, string $type = 'success'): void {
    $_SESSION['flash'] = ['msg' => $msg, 'type' => $type];
}
function getFlash(): ?array {
    $f = $_SESSION['flash'] ?? null;
    unset($_SESSION['flash']);
    return $f;
}
