<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
$config = file_exists('/home/sjubedu/config.php') ? '/home/sjubedu/config.php' : __DIR__ . '/../../config.php';
if (file_exists($config)) {
    require_once $config;
} else {
    $config = __DIR__ . '/config.php'; // Fallback
    if (file_exists($config)) require_once $config;
}

// Authentication Check
if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== true || !in_array('manage_users', $_SESSION['admin_perms'] ?? [])) {
    $admin_ip = $_SERVER['HTTP_CF_CONNECTING_IP'] ?? $_SERVER['REMOTE_ADDR'] ?? 'UNKNOWN';
    $user = $_SESSION['admin_username'] ?? 'Unauthenticated';
    file_put_contents(__DIR__ . '/admin_logins.log', "[" . date('Y-m-d H:i:s') . "] Unauthorized Access Attempt: $user tried to access Manage Users from IP: $admin_ip\n", FILE_APPEND);
    header("Location: dashboard.php");
    exit;
}

$msg = '';

$all_permissions = [
    'manage_users' => 'Manage Admin Users & Roles',
    'sync_data' => 'Run Bulk Imports & Auto-Syncs',
    'purge_data' => 'Force Purge/Wipe System Data',
    'manage_gallery' => 'Manage Gallery & File Manager',
    'manage_list' => 'Manage Core Faculty List',
    'manage_server_controls' => 'Access Server Controls (Reboot, Ban IPs, etc.)', // New permission
    'view_logs' => 'View System Logs & Login History',
    'manage_phd' => 'Admin: PhD Scholars',
    'manage_publication' => 'Admin: Publications',
    'manage_project' => 'Admin: Research Projects',
    'manage_awards' => 'Admin: Awards & Achievements',
    'manage_patent' => 'Admin: Patents',
    'manage_book_chapter' => 'Admin: Book Chapters',
    'manage_books_published' => 'Admin: Books Published',
    'manage_consultancy' => 'Admin: Consultancy',
    'manage_events' => 'Admin: Events Organized',
    'manage_media' => 'Admin: Popular Media'
];

// Handle Update Legacy Username
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'update_legacy_user') {
    $new_legacy_user = trim($_POST['legacy_username'] ?? '');
    if (!empty($new_legacy_user) && file_exists($config)) {
        $config_content = file_get_contents($config);
        if ($config_content !== false) {
        if (strpos($config_content, '$ADMIN_USERNAME') !== false) {
            $config_content = preg_replace('/\$ADMIN_USERNAME\s*=\s*[\'"].*?[\'"];/', "\$ADMIN_USERNAME = '$new_legacy_user';", $config_content);
        } else {
            $pos = strrpos($config_content, '?>');
            if ($pos !== false) {
                $config_content = substr_replace($config_content, "\n\$ADMIN_USERNAME = '$new_legacy_user';\n", $pos, 0);
            } else {
                $config_content .= "\n\$ADMIN_USERNAME = '$new_legacy_user';\n";
            }
        }
        if (file_put_contents($config, $config_content)) {
            $msg = "<div class='alert alert-success'><i class='fa fa-check-circle me-2'></i>Legacy username updated to <strong>" . htmlspecialchars($new_legacy_user) . "</strong>!</div>";
            $ADMIN_USERNAME = $new_legacy_user;
        } else {
            $msg = "<div class='alert alert-danger'><i class='fa fa-times-circle me-2'></i>Failed to write to config.php. Please check file permissions.</div>";
        }
        }
    }
}

try {
    $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4", DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    try {
        $pdo->exec("CREATE TABLE IF NOT EXISTS `admin_users` (
            `id` INT AUTO_INCREMENT PRIMARY KEY,
            `username` VARCHAR(50) UNIQUE NOT NULL,
            `password_hash` VARCHAR(255) NOT NULL,
            `role` ENUM('superadmin', 'editor', 'viewer') NOT NULL DEFAULT 'viewer',
            `permissions` TEXT NULL,
            `last_login` DATETIME NULL,
            `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");
    } catch (PDOException $e) {}

    try { $pdo->exec("ALTER TABLE `admin_users` ADD COLUMN `last_login` DATETIME NULL AFTER `permissions`"); } catch (PDOException $e) {}
    try { $pdo->exec("ALTER TABLE `admin_users` ADD COLUMN `profile_pic` VARCHAR(255) NULL"); } catch (PDOException $e) {}
    try { $pdo->exec("ALTER TABLE `admin_users` ADD COLUMN `email` VARCHAR(100) NULL"); } catch (PDOException $e) {}
    try { $pdo->exec("ALTER TABLE `admin_users` ADD COLUMN `mobile` VARCHAR(20) NULL"); } catch (PDOException $e) {}
    try { $pdo->exec("ALTER TABLE `admin_users` ADD COLUMN `linkedin` VARCHAR(255) NULL"); } catch (PDOException $e) {}
    try { $pdo->exec("ALTER TABLE `admin_users` ADD COLUMN `last_device` VARCHAR(255) NULL"); } catch (PDOException $e) {}
    try { $pdo->exec("ALTER TABLE `admin_users` ADD COLUMN `last_ip` VARCHAR(45) NULL"); } catch (PDOException $e) {}
    try { $pdo->exec("ALTER TABLE `admin_users` ADD COLUMN `status` ENUM('active', 'resigned') NOT NULL DEFAULT 'active'"); } catch (PDOException $e) {}

    // Handle Add User
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'add_user') {
        $username = trim($_POST['username'] ?? '');
        $password = $_POST['password'] ?? '';
        $role = $_POST['role'] ?? 'viewer';
        $perms = isset($_POST['permissions']) ? json_encode($_POST['permissions']) : '[]';
        $profile_pic = trim($_POST['profile_pic'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $mobile = trim($_POST['mobile'] ?? '');
        $linkedin = trim($_POST['linkedin'] ?? '');
        $status = $_POST['status'] ?? 'active';

        if (!empty($username) && !empty($password)) {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            try {
                $stmt = $pdo->prepare("INSERT INTO admin_users (username, password_hash, role, permissions, profile_pic, email, mobile, linkedin, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
                $stmt->execute([$username, $hash, $role, $perms, $profile_pic, $email, $mobile, $linkedin, $status]);
                $msg = "<div class='alert alert-success'><i class='fa fa-check-circle me-2'></i>User '<strong>" . htmlspecialchars($username) . "</strong>' created successfully!</div>";
            } catch (PDOException $e) {
                if ($e->getCode() == 23000) {
                    $msg = "<div class='alert alert-danger'><i class='fa fa-times-circle me-2'></i>Error: Username already exists.</div>";
                } else {
                    $msg = "<div class='alert alert-danger'><i class='fa fa-times-circle me-2'></i>Error: " . htmlspecialchars($e->getMessage()) . "</div>";
                }
            }
        } else {
            $msg = "<div class='alert alert-warning'><i class='fa fa-exclamation-triangle me-2'></i>Username and Password are required.</div>";
        }
    }

    // Handle Edit User
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'edit_user') {
        $user_id = $_POST['user_id'] ?? '';
        $new_username = trim($_POST['username'] ?? '');
        $role = $_POST['role'] ?? 'viewer';
        $perms = isset($_POST['permissions']) ? json_encode($_POST['permissions']) : '[]';
        $profile_pic = trim($_POST['profile_pic'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $mobile = trim($_POST['mobile'] ?? '');
        $linkedin = trim($_POST['linkedin'] ?? '');
        $status = $_POST['status'] ?? 'active';

        if (!empty($new_username)) {
            try {
                if (!empty($_POST['password'])) {
                    $hash = password_hash($_POST['password'], PASSWORD_DEFAULT);
                    $stmt = $pdo->prepare("UPDATE admin_users SET username = ?, role = ?, permissions = ?, password_hash = ?, profile_pic = ?, email = ?, mobile = ?, linkedin = ?, status = ? WHERE id = ?");
                    $stmt->execute([$new_username, $role, $perms, $hash, $profile_pic, $email, $mobile, $linkedin, $status, $user_id]);
                } else {
                    $stmt = $pdo->prepare("UPDATE admin_users SET username = ?, role = ?, permissions = ?, profile_pic = ?, email = ?, mobile = ?, linkedin = ?, status = ? WHERE id = ?");
                    $stmt->execute([$new_username, $role, $perms, $profile_pic, $email, $mobile, $linkedin, $status, $user_id]);
                }
                $msg = "<div class='alert alert-success'><i class='fa fa-check-circle me-2'></i>User updated successfully!</div>";
            } catch (PDOException $e) {
                if ($e->getCode() == 23000) {
                    $msg = "<div class='alert alert-danger'><i class='fa fa-times-circle me-2'></i>Error: Username already exists.</div>";
                } else {
                    $msg = "<div class='alert alert-danger'><i class='fa fa-times-circle me-2'></i>Error: " . htmlspecialchars($e->getMessage()) . "</div>";
                }
            }
        }
    }

    // Handle Delete User
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'delete_user') {
        $user_id = $_POST['user_id'] ?? '';
        $stmt = $pdo->prepare("DELETE FROM admin_users WHERE id = ?");
        $stmt->execute([$user_id]);
        $msg = "<div class='alert alert-success'><i class='fa fa-trash me-2'></i>User deleted successfully!</div>";
    }

    // Fetch Users
    $users = [];
    try {
        $stmt = $pdo->query("SELECT * FROM admin_users ORDER BY role ASC, username ASC");
        if ($stmt) {
            $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
    } catch (Exception $e) {}

} catch (PDOException $e) {
    die("Database Connection Failed.");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Admin Users</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-light p-4">
<div class="container-fluid max-w-1200" style="max-width: 1200px;">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><i class="fa fa-users-cog text-primary me-2"></i> Manage Access & Roles</h2>
        <a href="dashboard.php" class="btn btn-secondary"><i class="fa fa-arrow-left me-1"></i> Back to Dashboard</a>
    </div>

    <?php echo $msg; ?>
    
    <div class="row">
        <div class="col-md-12 mb-4 d-none"><!-- Call Jogith https://www.linkedin.com/in/jogith-biju/ -->
            <div class="card shadow-sm border-warning">
                <div class="card-header bg-warning text-dark fw-bold d-flex justify-content-between align-items-center">
                    <span><i class="fa fa-star me-1"></i> Legacy Admin Account (config.php fallback)</span>
                </div>
                <div class="card-body">
                    <form method="POST" class="d-flex align-items-center gap-3">
                        <input type="hidden" name="action" value="update_legacy_user">
                        <label class="form-label mb-0 fw-bold text-nowrap">Legacy Username:</label>
                        <input type="text" name="legacy_username" class="form-control" value="<?php echo htmlspecialchars($ADMIN_USERNAME ?? 'sjuadmin'); ?>" required>
                        <button type="submit" class="btn btn-warning text-dark fw-bold text-nowrap">Update Legacy Username</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white fw-bold"><i class="fa fa-user-plus me-1"></i> Add New User</div>
                <div class="card-body">
                    <form method="POST">
                        <input type="hidden" name="action" value="add_user">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold small">Username</label>
                                <input type="text" name="username" class="form-control" required placeholder="e.g. jdoe">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold small">Password</label>
                                <input type="password" name="password" class="form-control" required placeholder="••••••••">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold small">Email Address</label>
                                <input type="email" name="email" class="form-control" placeholder="user@sju.edu.in">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold small">Mobile</label>
                                <input type="text" name="mobile" class="form-control" placeholder="+91...">
                            </div>
                            <div class="col-md-12 mb-3">
                                <label class="form-label fw-bold small">Profile Picture (URL)</label>
                                <input type="url" name="profile_pic" class="form-control" placeholder="https://...">
                            </div>
                            <div class="col-md-12 mb-3">
                                <label class="form-label fw-bold small">LinkedIn URL</label>
                                <input type="url" name="linkedin" class="form-control" placeholder="https://linkedin.com/in/...">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold small">Primary Role</label>
                            <select name="role" class="form-select role-selector">
                                <option value="superadmin">Super Administrator (Core + Custom Access)</option>
                                <option value="editor">Editor (Content & Custom Access)</option>
                                <option value="viewer" selected>Viewer (Read-only + Custom Access)</option>
                            </select>
                            <small class="text-muted d-block mt-1">Role defines base UI layout. Use checkboxes below for exact access control.</small>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold small">Account Status</label>
                            <select name="status" class="form-select">
                                <option value="active" selected>Active</option>
                                <option value="resigned">Resigned / Disabled</option>
                            </select>
                        </div>
                        <hr>
                        <label class="form-label fw-bold small">Specific Permissions</label>
                        <div style="max-height: 250px; overflow-y: auto;" class="border p-2 rounded mb-3 bg-light">
                            <?php foreach ($all_permissions as $key => $label): ?>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="permissions[]" value="<?php echo htmlspecialchars($key); ?>" id="perm_<?php echo $key; ?>">
                                    <label class="form-check-label small" for="perm_<?php echo $key; ?>"><?php echo htmlspecialchars($label); ?></label>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <button type="submit" class="btn btn-primary w-100"><i class="fa fa-plus me-1"></i> Create Account</button>
                    </form>
                </div>
            </div>
        </div>
        
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-white fw-bold"><i class="fa fa-users me-1"></i> Existing Users</div>
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0" style="white-space: nowrap;">
                        <thead class="table-light">
                            <tr>
                                <th>User Profile</th>
                                <th>Access Role</th>
                                <th>Joined</th>
                                <th>Last Online From</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($users)): ?>
                                <tr><td colspan="5" class="text-center py-4 text-muted">No database users created yet.</td></tr>
                            <?php else: ?>
                                <?php foreach ($users as $u): ?>
                                    <tr>
                                        <td class="d-flex align-items-center border-0">
                                            <img src="<?php echo !empty($u['profile_pic']) ? htmlspecialchars($u['profile_pic']) : 'https://ui-avatars.com/api/?name='.urlencode($u['username'] ?? 'U').'&background=random'; ?>" alt="Avatar" class="rounded-circle me-3 border" width="45" height="45" style="object-fit:cover;">
                                            <div>
                                                <span class="fw-bold text-primary"><?php echo htmlspecialchars($u['username'] ?? 'Unknown'); ?></span><br>
                                                <div class="small mt-1">
                                                    <?php if(!empty($u['email'])): ?><a href="mailto:<?php echo htmlspecialchars($u['email']); ?>" title="Email"><i class="fa fa-envelope text-secondary"></i></a><?php endif; ?>
                                                    <?php if(!empty($u['mobile'])): ?><a href="tel:<?php echo htmlspecialchars($u['mobile']); ?>" title="Mobile"><i class="fa fa-phone text-secondary ms-1"></i></a><?php endif; ?>
                                                    <?php if(!empty($u['linkedin'])): ?><a href="<?php echo htmlspecialchars($u['linkedin']); ?>" target="_blank" title="LinkedIn"><i class="fab fa-linkedin text-secondary ms-1"></i></a><?php endif; ?>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <?php if (($u['role'] ?? '') === 'superadmin'): ?><span class="badge bg-danger">Superadmin</span>
                                            <?php elseif (($u['role'] ?? '') === 'editor'): ?><span class="badge bg-primary">Editor</span>
                                            <?php else: ?><span class="badge bg-secondary">Viewer</span><?php endif; ?>
                                            <?php if (($u['status'] ?? 'active') === 'resigned'): ?><span class="badge bg-dark mt-1 d-block" style="width:fit-content;"><i class="fa fa-user-slash"></i> Resigned</span><?php endif; ?>
                                        </td>
                                        <td class="small text-muted">
                                            <?php echo !empty($u['created_at']) ? date('M d, Y', strtotime($u['created_at'])) : 'N/A'; ?>
                                        </td>
                                        <td class="small">
                                            <?php if(!empty($u['last_login'])): ?>
                                                <div class="fw-bold text-success"><?php echo date('M d, Y h:i A', strtotime($u['last_login'])); ?></div>
                                                <div class="text-muted text-truncate" style="max-width: 150px;" title="<?php echo htmlspecialchars($u['last_device'] ?? 'Unknown'); ?>"><i class="fa fa-laptop"></i> <?php echo htmlspecialchars($u['last_device'] ?? 'Unknown'); ?></div>
                                                <div class="text-muted"><i class="fa fa-map-marker-alt"></i> IP: <?php echo htmlspecialchars($u['last_ip'] ?? 'Unknown'); ?></div>
                                            <?php else: ?>
                                                <span class="text-muted"><i>Never logged in</i></span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="text-end">
                                            <button type="button" class="btn btn-sm btn-outline-secondary py-1" data-bs-toggle="modal" data-bs-target="#editModal<?php echo $u['id'] ?? '0'; ?>"><i class="fa fa-edit"></i> Edit</button>
                                            <button type="button" class="btn btn-sm btn-outline-danger py-1" data-bs-toggle="modal" data-bs-target="#deleteModal<?php echo $u['id'] ?? '0'; ?>"><i class="fa fa-trash"></i> Delete</button>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Edit Modals (Safely outside the table) -->
<?php if (!empty($users)): ?>
    <?php foreach ($users as $u): ?>
        <div class="modal fade text-start" id="editModal<?php echo $u['id'] ?? '0'; ?>" tabindex="-1">
            <div class="modal-dialog">
                <form method="POST" class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit User: <?php echo htmlspecialchars($u['username'] ?? 'Unknown'); ?></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="action" value="edit_user">
                        <input type="hidden" name="user_id" value="<?php echo $u['id'] ?? '0'; ?>">
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label small fw-bold">Username</label>
                                <input type="text" name="username" class="form-control" value="<?php echo htmlspecialchars($u['username'] ?? ''); ?>" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label small fw-bold">New Password <small class="text-muted">(Optional)</small></label>
                                <input type="password" name="password" class="form-control" placeholder="••••••••">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold small">Email Address</label>
                                <input type="email" name="email" class="form-control" value="<?php echo htmlspecialchars($u['email'] ?? ''); ?>">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold small">Mobile</label>
                                <input type="text" name="mobile" class="form-control" value="<?php echo htmlspecialchars($u['mobile'] ?? ''); ?>">
                            </div>
                            <div class="col-md-12 mb-3">
                                <label class="form-label fw-bold small">Profile Picture (URL)</label>
                                <input type="url" name="profile_pic" class="form-control" value="<?php echo htmlspecialchars($u['profile_pic'] ?? ''); ?>">
                            </div>
                            <div class="col-md-12 mb-3">
                                <label class="form-label fw-bold small">LinkedIn URL</label>
                                <input type="url" name="linkedin" class="form-control" value="<?php echo htmlspecialchars($u['linkedin'] ?? ''); ?>">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-bold">Role</label>
                            <select name="role" class="form-select role-selector">
                                <option value="superadmin" <?php echo ($u['role'] ?? '') === 'superadmin' ? 'selected' : ''; ?>>Superadmin (Core + Custom Access)</option>
                                <option value="editor" <?php echo ($u['role'] ?? '') === 'editor' ? 'selected' : ''; ?>>Editor (Content & Custom Access)</option>
                                <option value="viewer" <?php echo ($u['role'] ?? '') === 'viewer' ? 'selected' : ''; ?>>Viewer (Read-only + Custom Access)</option>
                            </select>
                            <small class="text-muted d-block mt-1">Role defines base UI layout. Use checkboxes below for exact access control.</small>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-bold">Account Status</label>
                            <select name="status" class="form-select">
                                <option value="active" <?php echo ($u['status'] ?? 'active') === 'active' ? 'selected' : ''; ?>>Active</option>
                                <option value="resigned" <?php echo ($u['status'] ?? '') === 'resigned' ? 'selected' : ''; ?>>Resigned / Disabled</option>
                            </select>
                        </div>
                        <hr>
                        <label class="form-label small fw-bold">Permissions</label>
                        <div style="max-height: 200px; overflow-y: auto;" class="border p-2 rounded bg-light">
                            <?php $user_perms = json_decode($u['permissions'] ?? '[]', true); if(!is_array($user_perms)) $user_perms = []; ?>
                            <?php foreach ($all_permissions as $key => $label): ?>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="permissions[]" value="<?php echo htmlspecialchars($key); ?>" <?php echo in_array($key, $user_perms) ? 'checked' : ''; ?>>
                                    <label class="form-check-label small"><?php echo htmlspecialchars($label); ?></label>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Delete Modal -->
        <div class="modal fade text-start" id="deleteModal<?php echo $u['id'] ?? '0'; ?>" tabindex="-1">
            <div class="modal-dialog">
                <form method="POST" class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title text-danger"><i class="fa fa-exclamation-triangle"></i> Confirm Deletion</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="action" value="delete_user">
                        <input type="hidden" name="user_id" value="<?php echo $u['id'] ?? '0'; ?>">
                        <p>Are you sure you want to permanently delete the user <strong><?php echo htmlspecialchars($u['username'] ?? 'Unknown'); ?></strong>?</p>
                        <p class="text-muted small mb-0">This action cannot be undone.</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-danger"><i class="fa fa-trash"></i> Delete User</button>
                    </div>
                </form>
            </div>
        </div>
    <?php endforeach; ?>
<?php endif; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const roleSelectors = document.querySelectorAll('.role-selector');
    roleSelectors.forEach(selector => {
        selector.addEventListener('change', function() {
            const form = this.closest('form');
            const checkboxes = form.querySelectorAll('input[type="checkbox"][name="permissions[]"]');
            if (this.value === 'superadmin') {
                checkboxes.forEach(cb => cb.checked = true);
            } else if (this.value === 'editor') {
                checkboxes.forEach(cb => { // Editor gets most 'manage_' permissions except 'manage_users' and 'manage_server_controls'
                    cb.checked = cb.value.startsWith('manage_') && cb.value !== 'manage_users' && cb.value !== 'manage_server_controls';
                });
            } else {
                checkboxes.forEach(cb => cb.checked = false);
            }
        });
    });
});
</script>
 <div class="footer">
            &copy; <?php echo date('Y'); ?> St Joseph's University.<br>Managed by the University IT Department
        </div>
</body>
</html>