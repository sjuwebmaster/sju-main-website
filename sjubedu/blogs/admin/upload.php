<?php
// Inline image upload endpoint for Summernote editor
// Returns JSON: { "url": "..." } or { "error": "..." }
require_once __DIR__ . '/auth.php';
requireAuth();

header('Content-Type: application/json; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['error' => 'Method not allowed']); exit;
}

verifyCsrf();

if (empty($_FILES['file'])) {
    echo json_encode(['error' => 'No file received']); exit;
}

$file  = $_FILES['file'];
if (class_exists('finfo')) {
    $finfo = new finfo(FILEINFO_MIME_TYPE);
    $mime  = $finfo->file($file['tmp_name']);
} elseif (function_exists('mime_content_type')) {
    $mime  = mime_content_type($file['tmp_name']);
} else {
    $mime  = $file['type'];
}

if (!in_array($mime, BLOG_ALLOWED_IMG_TYPES, true)) {
    echo json_encode(['error' => 'Invalid file type. Allowed: JPG, PNG, GIF, WebP.']); exit;
}

if ($file['size'] > BLOG_MAX_IMG_SIZE) {
    echo json_encode(['error' => 'File too large (max 5 MB).']); exit;
}

$ext     = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
$newName = 'inline_' . bin2hex(random_bytes(10)) . '.' . $ext;
$dest    = __DIR__ . '/../uploads/blog/' . $newName;

if (!move_uploaded_file($file['tmp_name'], $dest)) {
    echo json_encode(['error' => 'Upload failed. Check write permissions on uploads/blog/']); exit;
}

echo json_encode(['url' => '/uploads/blog/' . $newName]);
