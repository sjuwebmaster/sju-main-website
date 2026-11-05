<?php
require_once __DIR__ . '/auth.php';

if (!empty($_SESSION['blog_admin_logged_in'])) {
    header('Location: /admin/index.php'); exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $attempts = $_SESSION['login_attempts'] ?? 0;
    $lockUntil = $_SESSION['login_lock_until'] ?? 0;

    if (time() < $lockUntil) {
        $wait = ceil(($lockUntil - time()) / 60);
        $error = "Too many failed attempts. Try again in {$wait} minute(s).";
    } else {
        $user = trim($_POST['username'] ?? '');
        $pass = $_POST['password'] ?? '';

        $userOk = hash_equals(BLOG_ADMIN_USER, $user);
        $passOk = hash_equals(BLOG_ADMIN_PASS, $pass);

        if ($userOk && $passOk) {
            session_regenerate_id(true);
            $_SESSION['blog_admin_logged_in'] = true;
            $_SESSION['login_attempts'] = 0;
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
            header('Location: /admin/index.php'); exit;
        } else {
            $attempts++;
            $_SESSION['login_attempts'] = $attempts;
            if ($attempts >= BLOG_LOGIN_MAX_ATTEMPTS) {
                $_SESSION['login_lock_until'] = time() + 900;
                $error = 'Too many failed attempts. Locked for 15 minutes.';
            } else {
                $rem = BLOG_LOGIN_MAX_ATTEMPTS - $attempts;
                $error = "Invalid credentials. {$rem} attempt(s) remaining.";
            }
        }
    }
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Login | SJU Blog</title>
    <link rel="icon" href="https://www.sju.edu.in/assets/img/favicon.png" type="image/png">
    <link rel="stylesheet" href="https://www.sju.edu.in/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        :root { --navy: #002147; --gold: #C5A059; }
        body { background: var(--navy); min-height: 100vh; display: flex; align-items: center; justify-content: center; }
        .login-card { width: 100%; max-width: 400px; border-radius: 16px; overflow: hidden; box-shadow: 0 20px 60px rgba(0,0,0,.4); }
        .login-header { background: var(--gold); padding: 2rem; text-align: center; }
        .login-header img { height: 60px; }
        .login-header h5 { color: #fff; margin: .8rem 0 0; font-weight: 700; letter-spacing: .02em; }
        .login-body { padding: 2rem; background: #fff; }
        .btn-login { background: var(--navy); color: #fff; border: none; width: 100%; padding: .7rem; border-radius: 8px; font-weight: 700; }
        .btn-login:hover { background: var(--gold); color: #fff; }
        .form-control:focus { border-color: var(--gold); box-shadow: 0 0 0 .2rem rgba(197,160,89,.25); }
    </style>
</head>
<body>
<div class="login-card">
    <div class="login-header">
        <img src="https://www.sju.edu.in/assets/img/st-joseph-university-logo.png" alt="SJU">
        <h5>Blog Admin Panel</h5>
    </div>
    <div class="login-body">
        <?php if ($error): ?>
            <div class="alert alert-danger py-2 small"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>
        <form method="POST" autocomplete="off">
            <div class="mb-3">
                <label class="form-label fw-semibold">Username</label>
                <input type="text" name="username" class="form-control" required autofocus
                       value="<?= htmlspecialchars($_POST['username'] ?? '') ?>">
            </div>
            <div class="mb-4">
                <label class="form-label fw-semibold">Password</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <button type="submit" class="btn-login">Sign In &rarr;</button>
        </form>
        <p class="text-center mt-3 mb-0">
            <a href="https://blogs.sju.edu.in/" class="text-muted small">&larr; Back to Blog</a>
        </p>
    </div>
</div>
</body>
</html>
