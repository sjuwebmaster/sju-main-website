<?php
session_start();
// Prevent timeouts for large zip operations
set_time_limit(0); 

$config = file_exists('/home/sjubedu/config.php') ? '/home/sjubedu/config.php' : __DIR__ . '/../config.php';
if (file_exists($config)) {
    require_once $config;
}

// Authentication Check
if (!isset($_SESSION['is_admin']) || !in_array('manage_gallery', $_SESSION['admin_perms'] ?? [])) {
    $admin_ip = $_SERVER['HTTP_CF_CONNECTING_IP'] ?? $_SERVER['REMOTE_ADDR'] ?? 'UNKNOWN';
    $user = $_SESSION['admin_username'] ?? 'Unauthenticated';
    file_put_contents(__DIR__ . '/admin_logins.log', "[" . date('Y-m-d H:i:s') . "] Unauthorized Access Attempt: $user tried to access File Manager from IP: $admin_ip\n", FILE_APPEND);
    header("Location: dashboard.php");
    exit;
}

// --- Configuration ---
// Updated to manage the entire home directory as requested
$base_dir = '/home/sjubedu/';
if (!is_dir($base_dir)) $base_dir = realpath(__DIR__);
else $base_dir = realpath($base_dir);

// --- AJAX Universal Uploader Handler ---
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['ajax_upload'])) {
    header('Content-Type: application/json');
    
    $storage_type = $_POST['storage_type'] ?? 'local';
    $target_path = $_POST['target_path'] ?? $base_dir;
    
    $s3_bucket_ajax = $_POST['s3_bucket'] ?? '';
    $s3_region_ajax = $_POST['s3_region'] ?? '';
    $s3_key_ajax    = $_POST['s3_key'] ?? '';
    $s3_secret_ajax = $_POST['s3_secret'] ?? '';
    $s3_prefix_ajax = $_POST['s3_prefix'] ?? '';
    
    $chunk_index = isset($_POST['chunk_index']) ? (int)$_POST['chunk_index'] : 0;
    $total_chunks = isset($_POST['total_chunks']) ? (int)$_POST['total_chunks'] : 1;
    $file_name = $_POST['file_name'] ?? '';
    
    $file_paths = [];
    if (isset($_POST['file_paths']) && !empty($_POST['file_paths'])) $file_paths = json_decode($_POST['file_paths'], true);
    
    $success_count = 0; $error_count = 0; $error_details = []; $success_urls = [];
    $uploaded_files = $_FILES['files'];
    $total_files = count($uploaded_files['name']);
    
    $s3_client_ajax = null;
    if ($storage_type === 's3' && class_exists('Aws\S3\S3Client')) {
        try {
            $s3_client_ajax = new Aws\S3\S3Client(['version' => 'latest', 'region' => $s3_region_ajax, 'credentials' => ['key' => $s3_key_ajax, 'secret' => $s3_secret_ajax]]);
        } catch (Exception $e) {}
    }

    $temp_dir = __DIR__ . '/cache/tmp_uploads';
    if (!is_dir($temp_dir)) @mkdir($temp_dir, 0775, true);

    for ($i = 0; $i < $total_files; $i++) {
        if ($uploaded_files['error'][$i] === UPLOAD_ERR_OK) {
            $rel_path = !empty($file_paths[$i]) ? $file_paths[$i] : (empty($file_name) ? $uploaded_files['name'][$i] : $file_name);
            $clean_path = ltrim(preg_replace('/\.+[\/\\\\]/', '', $rel_path), '/\\');
            $tmp_file_path = $temp_dir . '/' . md5($rel_path . session_id()) . '.part';
            
            $in = fopen($uploaded_files['tmp_name'][$i], "rb");
            $out = fopen($tmp_file_path, $chunk_index == 0 ? "wb" : "ab");
            while ($buff = fread($in, 4096)) fwrite($out, $buff);
            fclose($in); fclose($out);
            
            if ($chunk_index == $total_chunks - 1) {
                if ($storage_type === 'local') {
                    $destination = rtrim($target_path, '/') . '/' . $clean_path;
                    $dest_dir = dirname($destination);
                    if (!is_dir($dest_dir)) @mkdir($dest_dir, 0775, true);
                    
                    if (rename($tmp_file_path, $destination)) {
                        chmod($destination, 0644);
                        $success_count++;
                    } else {
                        $error_count++; $error_details[] = "Failed to assemble: " . htmlspecialchars($clean_path);
                    }
                } elseif ($storage_type === 's3' && $s3_client_ajax) {
                    $s3_object_key = ltrim($s3_prefix_ajax . '/' . $clean_path, '/');
                    try {
                        $s3_client_ajax->putObject(['Bucket' => $s3_bucket_ajax, 'Key' => $s3_object_key, 'SourceFile' => $tmp_file_path]);
                        $success_count++; @unlink($tmp_file_path);
                    } catch (Exception $e) {
                        $error_count++; $error_details[] = "S3 Upload Failed: " . $e->getMessage(); @unlink($tmp_file_path);
                    }
                }
            } else {
                echo json_encode(['success' => 1, 'error' => 0, 'details' => [], 'urls' => [], 'chunk_done' => true]); exit;
            }
        } else {
            $error_count++; $error_details[] = "Upload error code: " . $uploaded_files['error'][$i];
        }
    }
    echo json_encode(['success' => $success_count, 'error' => $error_count, 'details' => $error_details, 'urls' => $success_urls]); exit;
}

// --- State & Storage Mode ---
$mode = $_GET['mode'] ?? 'local';
if (isset($_POST['save_s3_config'])) {
    $_SESSION['s3_mgr_config'] = ['bucket' => $_POST['s3_bucket'], 'region' => $_POST['s3_region'], 'key' => $_POST['s3_key'], 'secret' => $_POST['s3_secret']];
    header("Location: file_manager.php?mode=s3"); exit;
}

$s3 = null; $s3_bucket = ''; $s3_ready = false; $sdk_missing = false;
if ($mode === 's3') {
    if (!class_exists('Aws\S3\S3Client')) $sdk_missing = true;
    elseif (!empty($_SESSION['s3_mgr_config']['key']) && !empty($_SESSION['s3_mgr_config']['bucket'])) {
        try {
            $s3 = new Aws\S3\S3Client(['version' => 'latest', 'region' => $_SESSION['s3_mgr_config']['region'], 'credentials' => ['key' => $_SESSION['s3_mgr_config']['key'], 'secret' => $_SESSION['s3_mgr_config']['secret']]]);
            $s3_bucket = $_SESSION['s3_mgr_config']['bucket']; $s3_ready = true;
        } catch (Exception $e) { $message = "<div class='alert alert-danger'>S3 Error: " . htmlspecialchars($e->getMessage()) . "</div>"; }
    }
}

$req_path = $_GET['path'] ?? '';
$req_path = ltrim(str_replace(['../', '..\\'], '', $req_path), '/\\'); 

$current_dir = '';
if ($mode === 'local') {
    $current_dir = realpath($base_dir . '/' . $req_path);
    if ($current_dir === false || strpos($current_dir, $base_dir) !== 0) {
        $current_dir = $base_dir; $req_path = '';
    }
}

$message = '';
$editable_exts = ['txt', 'php', 'html', 'css', 'js', 'json', 'md', 'xml', 'csv', 'log', 'ini'];

// --- Helper Functions ---
function deleteDir($dirPath) {
    if (!is_dir($dirPath)) return;
    $objects = scandir($dirPath);
    foreach ($objects as $object) {
        if ($object != "." && $object != "..") {
            if (is_dir($dirPath . DIRECTORY_SEPARATOR . $object) && !is_link($dirPath."/".$object)) deleteDir($dirPath . DIRECTORY_SEPARATOR . $object);
            else unlink($dirPath . DIRECTORY_SEPARATOR . $object);
        }
    }
    rmdir($dirPath);
}

function rcopy($src, $dst) {
    if (is_dir($src)) {
        if (!is_dir($dst)) @mkdir($dst, 0775, true);
        $files = scandir($src);
        foreach ($files as $file) {
            if ($file != "." && $file != "..") rcopy("$src/$file", "$dst/$file");
        }
    } else if (file_exists($src)) {
        copy($src, $dst);
    }
}

function zipData($source, $destination) {
    if (!extension_loaded('zip') || !file_exists($source)) return false;
    $zip = new ZipArchive();
    if (!$zip->open($destination, ZIPARCHIVE::CREATE)) return false;
    $source = str_replace('\\', '/', realpath($source));
    if (is_dir($source) === true) {
        $files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($source), RecursiveIteratorIterator::SELF_FIRST);
        foreach ($files as $file) {
            $file = str_replace('\\', '/', $file);
            if( in_array(substr($file, strrpos($file, '/')+1), array('.', '..')) ) continue;
            $file = realpath($file);
            if (is_dir($file) === true) $zip->addEmptyDir(str_replace($source . '/', '', $file . '/'));
            else if (is_file($file) === true) $zip->addFromString(str_replace($source . '/', '', $file), file_get_contents($file));
        }
    } else if (is_file($source) === true) {
        $zip->addFromString(basename($source), file_get_contents($source));
    }
    return $zip->close();
}

function formatBytes($bytes, $precision = 2) { 
    if ($bytes === '-') return '-';
    $units = ['B', 'KB', 'MB', 'GB', 'TB']; 
    $bytes = max($bytes, 0); 
    $pow = floor(($bytes ? log($bytes) : 0) / log(1024)); 
    $pow = min($pow, count($units) - 1); 
    $bytes /= pow(1024, $pow); 
    return round($bytes, $precision) . ' ' . $units[$pow]; 
}

// --- Handle Actions (POST) ---
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    
    if ($mode === 'local') {
        // Bulk Actions (Clipboard & Zip)
        if (in_array($action, ['copy', 'cut']) && !empty($_POST['selected_files'])) {
            $_SESSION['fm_clipboard'] = ['action' => $action, 'files' => $_POST['selected_files'], 'source_dir' => $current_dir];
            $message = "<div class='alert alert-info'>".count($_POST['selected_files'])." items added to clipboard. Navigate to destination and click Paste.</div>";
        } 
        elseif ($action === 'paste' && isset($_SESSION['fm_clipboard'])) {
            $clip = $_SESSION['fm_clipboard'];
            $pasted_count = 0;
            foreach ($clip['files'] as $file_rel) {
                $src = realpath($clip['source_dir'] . '/' . basename($file_rel));
                if ($src && strpos($src, $base_dir) === 0) {
                    $dest = $current_dir . '/' . basename($src);
                    if ($clip['action'] === 'copy') { rcopy($src, $dest); $pasted_count++; }
                    elseif ($clip['action'] === 'cut') { rename($src, $dest); $pasted_count++; }
                }
            }
            if ($clip['action'] === 'cut') unset($_SESSION['fm_clipboard']);
            $message = "<div class='alert alert-success'>Successfully pasted $pasted_count items.</div>";
        }
        elseif ($action === 'zip' && !empty($_POST['selected_files'])) {
            if (class_exists('ZipArchive')) {
                $zip_name = $current_dir . '/archive_' . time() . '.zip';
                $zip = new ZipArchive();
                if ($zip->open($zip_name, ZipArchive::CREATE) === TRUE) {
                    foreach ($_POST['selected_files'] as $file_rel) {
                        $src = realpath($current_dir . '/' . basename($file_rel));
                        if ($src && strpos($src, $base_dir) === 0) {
                            if (is_dir($src)) {
                                $files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($src), RecursiveIteratorIterator::SELF_FIRST);
                                foreach ($files as $file) {
                                    $file = str_replace('\\', '/', $file);
                                    if( in_array(substr($file, strrpos($file, '/')+1), array('.', '..')) ) continue;
                                    $file = realpath($file);
                                    $local_path = basename($src) . '/' . str_replace(realpath($src) . '/', '', $file);
                                    if (is_dir($file)) $zip->addEmptyDir($local_path . '/');
                                    else if (is_file($file)) $zip->addFromString($local_path, file_get_contents($file));
                                }
                            } else {
                                $zip->addFile($src, basename($src));
                            }
                        }
                    }
                    $zip->close();
                    $message = "<div class='alert alert-success'>Successfully created archive: ".basename($zip_name)."</div>";
                }
            } else {
                $message = "<div class='alert alert-danger'>ZipArchive extension is missing on this server.</div>";
            }
        }
        elseif ($action === 'extract' && isset($_POST['target'])) {
            $target_file = realpath($base_dir . '/' . $_POST['target']);
            if ($target_file && strpos($target_file, $base_dir) === 0 && class_exists('ZipArchive')) {
                $zip = new ZipArchive;
                if ($zip->open($target_file) === TRUE) {
                    $zip->extractTo($current_dir);
                    $zip->close();
                    $message = "<div class='alert alert-success'>Archive extracted successfully.</div>";
                } else {
                    $message = "<div class='alert alert-danger'>Failed to open zip file.</div>";
                }
            }
        }
        // Basic Actions
        elseif ($action === 'create_folder') {
            $folder_name = preg_replace('/[^a-zA-Z0-9_\-\s]/', '', trim($_POST['folder_name'] ?? ''));
            if ($folder_name) {
                $new_dir = rtrim($current_dir, '/') . '/' . $folder_name;
                if (!is_dir($new_dir) && @mkdir($new_dir, 0775, true)) $message = "<div class='alert alert-success'>Folder created.</div>";
                else $message = "<div class='alert alert-danger'>Failed to create folder.</div>";
            }
        } 
        elseif ($action === 'delete' && isset($_POST['target'])) {
            $target_file = realpath($base_dir . '/' . $_POST['target']);
            if ($target_file && strpos($target_file, $base_dir) === 0) {
                if (is_dir($target_file)) deleteDir($target_file);
                else unlink($target_file);
                $message = "<div class='alert alert-success'>Deleted successfully.</div>";
            }
        } 
        elseif ($action === 'save_edit' && isset($_POST['target'])) {
            $target_file = realpath($base_dir . '/' . $_POST['target']);
            if ($target_file && strpos($target_file, $base_dir) === 0) {
                file_put_contents($target_file, $_POST['file_content'] ?? '');
                $message = "<div class='alert alert-success'>File saved.</div>";
            }
        }
    }
}

// --- Handle Download (GET) ---
if (isset($_GET['action']) && $_GET['action'] === 'download' && isset($_GET['file'])) {
    $target_dl = realpath($base_dir . '/' . $_GET['file']);
    if ($target_dl && strpos($target_dl, $base_dir) === 0) {
        if (is_dir($target_dl)) {
            // Download Directory as Zip
            if (class_exists('ZipArchive')) {
                $temp_zip = sys_get_temp_dir() . '/' . uniqid('dir_') . '.zip';
                if (zipData($target_dl, $temp_zip)) {
                    header('Content-Type: application/zip');
                    header('Content-Disposition: attachment; filename="'.basename($target_dl).'_export.zip"');
                    header('Content-Length: ' . filesize($temp_zip));
                    readfile($temp_zip);
                    unlink($temp_zip);
                    exit;
                }
            }
        } else if (is_file($target_dl)) {
            // Download Single File
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="'.basename($target_dl).'"');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($target_dl));
            readfile($target_dl);
            exit;
        }
    }
}

// --- Handle Edit Mode (GET) ---
$edit_mode = false; $edit_content = ''; $edit_file = '';
if (isset($_GET['action']) && $_GET['action'] === 'edit' && isset($_GET['file'])) {
    if ($mode === 'local') {
        $target_edit = realpath($base_dir . '/' . $_GET['file']);
        if ($target_edit && strpos($target_edit, $base_dir) === 0 && is_file($target_edit)) {
            $edit_mode = true; $edit_file = $_GET['file']; $edit_content = file_get_contents($target_edit);
        }
    }
}

// Scan Directory
$items = [];
if (!$edit_mode && $mode === 'local') {
    $files = scandir($current_dir);
    foreach ($files as $file) {
        if ($file === '.') continue;
        if ($file === '..' && $current_dir === $base_dir) continue;

        $full_path = $current_dir . '/' . $file;
        $rel_path = ltrim(str_replace($base_dir, '', $full_path), '/');
        $is_dir = is_dir($full_path);
        
        $public_url = '';
        if (!$is_dir && strpos($full_path, '/home/sjubedu/public_html') === 0) {
            $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http";
            $domain = $_SERVER['HTTP_HOST'] ?? 'sju.edu.in';
            $web_path = str_replace('/home/sjubedu/public_html', '', $full_path);
            $parts = array_map('rawurlencode', explode('/', ltrim(str_replace('\\', '/', $web_path), '/')));
            $public_url = $protocol . '://' . $domain . '/' . implode('/', $parts);
        }

        $items[] = [
            'name' => $file,
            'path' => $rel_path,
            'is_dir' => $is_dir,
            'size' => $is_dir ? '-' : filesize($full_path),
            'mtime' => filemtime($full_path),
            'ext' => $is_dir ? '' : strtolower(pathinfo($full_path, PATHINFO_EXTENSION)),
            'url' => $public_url
        ];
    }
    usort($items, function($a, $b) {
        if ($a['name'] === '..') return -1;
        if ($b['name'] === '..') return 1;
        if ($a['is_dir'] && !$b['is_dir']) return -1;
        if (!$a['is_dir'] && $b['is_dir']) return 1;
        return strcasecmp($a['name'], $b['name']);
    });
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include $_SERVER['DOCUMENT_ROOT'] . '/gtm.php'; ?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Server File Manager</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        #dropZone { border: 2px dashed #0d6efd; background-color: #f8f9fa; transition: 0.3s; cursor: pointer; }
        #dropZone.dragover { background-color: #e9ecef; border-color: #198754; }
        .table-checkbox { width: 40px; text-align: center; }
    </style>
</head>
<body class="bg-light p-4">
<div class="container-fluid max-w-1200">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><i class="fa fa-folder-open text-primary"></i> File Manager</h2>
        <div>
            <a href="dashboard.php" class="btn btn-secondary">Back to Dashboard</a>
        </div>
    </div>

    <ul class="nav nav-tabs mb-4">
        <li class="nav-item"><a class="nav-link <?php echo $mode === 'local' ? 'active fw-bold' : ''; ?>" href="?mode=local"><i class="fa fa-server"></i> Local Server</a></li>
        <li class="nav-item"><a class="nav-link <?php echo $mode === 's3' ? 'active fw-bold text-warning' : ''; ?>" href="?mode=s3"><i class="fab fa-aws"></i> Amazon S3</a></li>
    </ul>

    <?php echo $message; ?>

    <?php if ($mode === 'local' || ($mode === 's3' && $s3_ready)): ?>
    <div class="card shadow-sm">
        <div class="card-header bg-white d-flex align-items-center fw-bold text-monospace">
            <?php if ($mode === 'local'): ?>
                <i class="fa fa-hdd text-secondary me-2"></i> <?php echo htmlspecialchars($base_dir . '/' . $req_path); ?>
            <?php else: ?>
                <i class="fa fa-cloud text-warning me-2"></i> s3://<?php echo htmlspecialchars($s3_bucket . '/' . $req_path); ?> <a href="?mode=s3&reset=1" class="ms-auto btn btn-sm btn-outline-secondary py-0">Change Bucket</a>
            <?php endif; ?>
            
            <div class="ms-auto">
                <button type="button" class="btn btn-sm btn-outline-success me-2" data-bs-toggle="modal" data-bs-target="#uploadModal"><i class="fa fa-upload"></i> Upload Here</button>
                <button type="button" class="btn btn-sm btn-outline-info py-1" onclick="createFolder()"><i class="fa fa-folder-plus"></i> New Folder</button>
            </div>
        </div>
        
        <div class="card-body p-0">
            <?php if ($edit_mode): ?>
                <div class="p-3">
                    <div class="d-flex justify-content-between mb-3 align-items-center">
                        <h5 class="mb-0">Editing: <code><?php echo htmlspecialchars($edit_file); ?></code></h5>
                        <a href="?mode=<?php echo $mode; ?>&path=<?php echo urlencode(dirname($edit_file)); ?>" class="btn btn-sm btn-outline-secondary">Close Editor</a>
                    </div>
                    <form method="POST">
                        <input type="hidden" name="action" value="save_edit">
                        <input type="hidden" name="target" value="<?php echo htmlspecialchars($edit_file); ?>">
                        <textarea name="file_content" class="form-control text-monospace bg-dark text-light mb-3" rows="20" style="font-family: monospace;" spellcheck="false"><?php echo htmlspecialchars($edit_content); ?></textarea>
                        <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Save Changes</button>
                    </form>
                </div>
            <?php else: ?>
                
                <?php if ($mode === 'local'): ?>
                <div class="bg-light border-bottom p-2 d-flex align-items-center gap-2">
                    <input type="checkbox" id="selectAll" class="form-check-input ms-2" title="Select All">
                    <span class="text-muted small ms-2 me-3 border-end pe-3">Select All</span>
                    
                    <button type="button" class="btn btn-sm btn-outline-secondary" onclick="submitBulk('copy')"><i class="fa fa-copy"></i> Copy</button>
                    <button type="button" class="btn btn-sm btn-outline-secondary" onclick="submitBulk('cut')"><i class="fa fa-cut"></i> Cut</button>
                    
                    <?php if (isset($_SESSION['fm_clipboard'])): ?>
                        <form method="POST" class="d-inline mb-0">
                            <input type="hidden" name="action" value="paste">
                            <button type="submit" class="btn btn-sm btn-success"><i class="fa fa-paste"></i> Paste (<?php echo count($_SESSION['fm_clipboard']['files']); ?> items)</button>
                        </form>
                    <?php endif; ?>

                    <button type="button" class="btn btn-sm btn-outline-primary ms-auto" onclick="submitBulk('zip')"><i class="fa fa-file-archive"></i> Zip Selected</button>
                </div>
                <?php endif; ?>

                <form id="bulkForm" method="POST">
                    <input type="hidden" name="action" id="bulkAction" value="">
                    <div class="table-responsive">
                        <table class="table table-hover table-striped align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <?php if ($mode === 'local'): ?><th class="table-checkbox"></th><?php endif; ?>
                                    <th>Name</th>
                                    <th>Size</th>
                                    <th>Last Modified</th>
                                    <th class="text-end">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($items as $item): ?>
                                <tr>
                                    <?php if ($mode === 'local'): ?>
                                    <td class="table-checkbox">
                                        <?php if ($item['name'] !== '..'): ?>
                                            <input type="checkbox" name="selected_files[]" value="<?php echo htmlspecialchars($item['path']); ?>" class="form-check-input item-checkbox">
                                        <?php endif; ?>
                                    </td>
                                    <?php endif; ?>
                                    <td>
                                        <?php if ($item['is_dir']): ?>
                                            <i class="fa fa-folder text-warning me-2"></i> 
                                            <a href="?mode=<?php echo $mode; ?>&path=<?php echo urlencode($item['path']); ?>" class="text-decoration-none fw-bold"><?php echo htmlspecialchars($item['name']); ?></a>
                                        <?php else: ?>
                                            <i class="fa fa-file text-secondary me-2"></i> 
                                            <?php echo htmlspecialchars($item['name']); ?>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-muted small"><?php echo formatBytes($item['size']); ?></td>
                                    <td class="text-muted small"><?php echo date('Y-m-d H:i:s', $item['mtime']); ?></td>
                                    <td class="text-end">
                                        <?php if ($item['name'] !== '..'): ?>
                                            
                                            <?php if ($item['ext'] === 'zip' && $mode === 'local'): ?>
                                                <button type="button" onclick="extractZip('<?php echo htmlspecialchars($item['path']); ?>')" class="btn btn-sm btn-warning py-0 px-2" title="Extract Zip"><i class="fa fa-box-open"></i> Extract</button>
                                            <?php endif; ?>

                                            <?php if (!$item['is_dir'] && $item['url']): ?>
                                                <button type="button" onclick="navigator.clipboard.writeText('<?php echo htmlspecialchars($item['url']); ?>'); alert('Link copied!');" class="btn btn-sm btn-outline-success py-0 px-2" title="Copy Link"><i class="fa fa-link"></i></button>
                                            <?php endif; ?>

                                            <?php if (!$item['is_dir'] && in_array($item['ext'], $editable_exts)): ?>
                                                <a href="?mode=<?php echo $mode; ?>&action=edit&file=<?php echo urlencode($item['path']); ?>" class="btn btn-sm btn-outline-primary py-0 px-2" title="Edit"><i class="fa fa-edit"></i></a>
                                            <?php endif; ?>
                                            
                                            <a href="?mode=<?php echo $mode; ?>&action=download&file=<?php echo urlencode($item['path']); ?>" class="btn btn-sm btn-outline-info py-0 px-2" title="Download"><i class="fa fa-download"></i></a>
                                            
                                            <button type="button" onclick="deleteItem('<?php echo htmlspecialchars($item['path']); ?>', <?php echo $item['is_dir'] ? '1' : '0'; ?>)" class="btn btn-sm btn-outline-danger py-0 px-2" title="Delete"><i class="fa fa-trash"></i></button>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </form>
            <?php endif; ?>
        </div>
    </div>
    <?php endif; ?>
</div>

<form id="actionForm" method="POST" style="display:none;">
    <input type="hidden" name="action" id="singleAction">
    <input type="hidden" name="target" id="actionTarget">
    <input type="hidden" name="is_dir" id="actionIsDir">
</form>

<form id="createFolderForm" method="POST" style="display:none;">
    <input type="hidden" name="action" value="create_folder">
    <input type="hidden" name="folder_name" id="folderNameInput">
</form>

<div class="modal fade" id="uploadModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fa fa-cloud-upload-alt text-success"></i> Upload to Current Folder</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="uploadForm">
                    <input type="hidden" name="storage_type" value="<?php echo $mode; ?>">
                    <input type="hidden" name="target_path" value="<?php echo htmlspecialchars($current_dir); ?>">
                    <input type="hidden" name="ajax_upload" value="1">

                    <div class="d-flex gap-2 mb-3">
                        <button type="button" class="btn btn-outline-primary btn-sm" onclick="document.getElementById('fileInput').click()"><i class="fa fa-file"></i> Select Files</button>
                        <button type="button" class="btn btn-outline-info btn-sm" onclick="document.getElementById('folderInput').click()"><i class="fa fa-folder"></i> Select Folder</button>
                    </div>
                    
                    <input type="file" id="fileInput" multiple style="display:none;">
                    <input type="file" id="folderInput" multiple webkitdirectory directory style="display:none;">
                    
                    <div id="dropZone" class="p-5 text-center rounded mb-3">
                        <i class="fa fa-cloud-upload-alt text-primary mb-2" style="font-size: 2rem;"></i>
                        <h5>Drag & Drop files or folders here</h5>
                        <div id="fileCount" class="text-success fw-bold mt-2">No files selected</div>
                    </div>

                    <button type="submit" class="btn btn-success w-100" id="uploadBtn" disabled><i class="fa fa-upload"></i> Start Upload</button>

                    <div id="progressContainer" class="d-none mt-3">
                        <div class="d-flex justify-content-between small fw-bold mb-1">
                            <span id="progressText">Uploading...</span>
                            <span id="progressCount">0 / 0</span>
                        </div>
                        <div class="progress" style="height: 20px;">
                            <div id="progressBar" class="progress-bar progress-bar-striped progress-bar-animated bg-success" style="width: 0%;"></div>
                        </div>
                        <div class="d-flex justify-content-between small text-muted mt-1">
                            <span id="uploadSpeed">Speed: 0.00 MB/s</span>
                            <span id="timeRemaining">Time remaining: Calculating...</span>
                        </div>
                    </div>
                    <div id="resultMessage" class="mt-3"></div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // JS Logic for Actions
    function createFolder() {
        const name = prompt("Enter new folder name:");
        if (name && name.trim() !== "") {
            document.getElementById('folderNameInput').value = name.trim();
            document.getElementById('createFolderForm').submit();
        }
    }

    function deleteItem(path, isDir) {
        if (confirm('Are you sure you want to delete this ' + (isDir ? 'folder and ALL its contents' : 'file') + '?')) {
            document.getElementById('singleAction').value = 'delete';
            document.getElementById('actionTarget').value = path;
            document.getElementById('actionIsDir').value = isDir;
            document.getElementById('actionForm').submit();
        }
    }

    function extractZip(path) {
        if (confirm('Extract this archive into the current directory?')) {
            document.getElementById('singleAction').value = 'extract';
            document.getElementById('actionTarget').value = path;
            document.getElementById('actionForm').submit();
        }
    }

    // Bulk Action Logic
    const selectAllCheckbox = document.getElementById('selectAll');
    if (selectAllCheckbox) {
        selectAllCheckbox.addEventListener('change', function() {
            document.querySelectorAll('.item-checkbox').forEach(cb => cb.checked = this.checked);
        });
    }

    function submitBulk(action) {
        const checked = document.querySelectorAll('.item-checkbox:checked');
        if (checked.length === 0) { alert('Please select at least one item.'); return; }
        document.getElementById('bulkAction').value = action;
        document.getElementById('bulkForm').submit();
    }

    // Uploader Logic (with Speed & Time)
    let selectedFiles = [];
    const dropZone = document.getElementById('dropZone');
    const fileInput = document.getElementById('fileInput');
    const folderInput = document.getElementById('folderInput');
    const uploadBtn = document.getElementById('uploadBtn');
    const fileCountDiv = document.getElementById('fileCount');

    ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(e => dropZone.addEventListener(e, prev, false));
    function prev(e) { e.preventDefault(); e.stopPropagation(); }
    ['dragenter', 'dragover'].forEach(e => dropZone.addEventListener(e, () => dropZone.classList.add('dragover'), false));
    ['dragleave', 'drop'].forEach(e => dropZone.addEventListener(e, () => dropZone.classList.remove('dragover'), false));

    dropZone.addEventListener('drop', (e) => handleFiles(e.dataTransfer.files), false);
    fileInput.addEventListener('change', (e) => handleFiles(e.target.files));
    folderInput.addEventListener('change', (e) => handleFiles(e.target.files));

    function handleFiles(files) {
        if (files.length > 0) {
            selectedFiles = Array.from(files);
            fileCountDiv.innerHTML = `${selectedFiles.length} file(s) selected`;
            uploadBtn.disabled = false;
        }
    }

    document.getElementById('uploadForm').addEventListener('submit', async function(e) {
        e.preventDefault();
        if (selectedFiles.length === 0) return;
        uploadBtn.disabled = true;
        document.getElementById('progressContainer').classList.remove('d-none');
        document.getElementById('resultMessage').innerHTML = '';
        const progressBar = document.getElementById('progressBar');
        const progressText = document.getElementById('progressText');
        const progressCount = document.getElementById('progressCount');
        const uploadSpeedSpan = document.getElementById('uploadSpeed');
        const timeRemainingSpan = document.getElementById('timeRemaining');

        const CHUNK_SIZE = 2 * 1024 * 1024;
        let totalBytes = selectedFiles.reduce((acc, file) => acc + file.size, 0);
        let uploadedBytes = 0; let globalErrors = []; let totalUploadedFiles = 0;
        let lastUpdateTime = Date.now(); let lastUpdateBytes = 0;

        for (let i = 0; i < selectedFiles.length; i++) {
            const file = selectedFiles[i];
            const totalChunks = Math.max(1, Math.ceil(file.size / CHUNK_SIZE));
            const path = file.webkitRelativePath ? file.webkitRelativePath : file.name;

            for (let chunkIndex = 0; chunkIndex < totalChunks; chunkIndex++) {
                const start = chunkIndex * CHUNK_SIZE;
                const end = Math.min(start + CHUNK_SIZE, file.size);
                const chunk = file.slice(start, end);

                const formData = new FormData(this);
                formData.delete('files[]');
                formData.append('files[]', chunk, file.name);
                formData.append('file_paths', JSON.stringify([path]));
                formData.append('file_name', file.name);
                formData.append('chunk_index', chunkIndex);
                formData.append('total_chunks', totalChunks);

                try {
                    await new Promise((resolve, reject) => {
                        const xhr = new XMLHttpRequest();
                        xhr.open('POST', window.location.href, true);
                        xhr.upload.onprogress = (event) => {
                            if (event.lengthComputable) {
                                const currentUpload = uploadedBytes + event.loaded;
                                const percent = Math.floor((currentUpload / totalBytes) * 100);
                                progressBar.style.width = percent + '%';
                                progressText.innerText = `Uploading... ${percent}%`;

                                const now = Date.now();
                                const deltaSeconds = (now - lastUpdateTime) / 1000;
                                if (deltaSeconds >= 0.5 || currentUpload === totalBytes) {
                                    const speedBps = (currentUpload - lastUpdateBytes) / deltaSeconds;
                                    if (speedBps > 0) {
                                        uploadSpeedSpan.innerText = `Speed: ${(speedBps / 1048576).toFixed(2)} MB/s`;
                                        const remainingSecs = Math.max(0, Math.ceil((totalBytes - currentUpload) / speedBps));
                                        timeRemainingSpan.innerText = `Time remaining: ${remainingSecs > 60 ? Math.floor(remainingSecs/60)+'m '+(remainingSecs%60)+'s' : remainingSecs+'s'}`;
                                    }
                                    lastUpdateTime = now; lastUpdateBytes = currentUpload;
                                }
                            }
                        };
                        xhr.onload = () => {
                            if (xhr.status >= 200 && xhr.status < 300) {
                                uploadedBytes += chunk.size; resolve(JSON.parse(xhr.responseText));
                            } else reject();
                        };
                        xhr.send(formData);
                    });
                } catch (err) { break; }
            }
            totalUploadedFiles++;
            progressCount.innerText = `${totalUploadedFiles} / ${selectedFiles.length}`;
        }
        
        progressBar.style.width = '100%';
        progressBar.classList.remove('progress-bar-animated');
        progressText.innerText = 'Upload Complete!';
        uploadSpeedSpan.innerText = 'Speed: 0.00 MB/s';
        timeRemainingSpan.innerText = 'Time remaining: Complete';
        setTimeout(() => window.location.reload(), 2000);
    });
</script>
</body>
</html>