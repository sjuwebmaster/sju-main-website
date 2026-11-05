<?php
// ─────────────────────────────────────────────────────────────────
// SJU Blog Admin Credentials
// Change BLOG_ADMIN_PASS before deploying to production.
// To generate a secure hash, run:
//   php -r "echo password_hash('your_password', PASSWORD_DEFAULT);"
// then paste the result in BLOG_ADMIN_PASS_HASH and remove BLOG_ADMIN_PASS.
// ─────────────────────────────────────────────────────────────────
define('BLOG_ADMIN_USER', 'sjublogadmin');
define('BLOG_ADMIN_PASS', 'SJUBlog@2024');   // ← Change this before going live

// Session name (unique to this subdomain)
define('BLOG_ADMIN_SESSION', 'sju_blog_admin');

// Max failed login attempts before 15-min lockout
define('BLOG_LOGIN_MAX_ATTEMPTS', 5);

// Allowed image types for uploads
define('BLOG_ALLOWED_IMG_TYPES', ['image/jpeg', 'image/png', 'image/gif', 'image/webp']);
define('BLOG_MAX_IMG_SIZE', 5 * 1024 * 1024); // 5 MB
