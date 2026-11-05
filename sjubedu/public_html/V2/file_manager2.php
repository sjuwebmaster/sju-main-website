<?php
session_start();
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

// --- AJAX Universal Uploader Handler ---
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['ajax_upload'])) {
    header('Content-Type: application/json');
    
    $storage_type = $_POST['storage_type'] ?? 'local';
    $target_path = $_POST['target_path'] ?? '/home/sjubedu/public_html/';
    
    // S3 Settings
    $s3_bucket_ajax = $_POST['s3_bucket'] ?? '';
    $s3_region_ajax = $_POST['s3_region'] ?? '';
    $s3_key_ajax    = $_POST['s3_key'] ?? '';
    $s3_secret_ajax = $_POST['s3_secret'] ?? '';
    $s3_prefix_ajax = $_POST['s3_prefix'] ?? '';
    
    $chunk_index = isset($_POST['chunk_index']) ? (int)$_POST['chunk_index'] : 0;
    $total_chunks = isset($_POST['total_chunks']) ? (int)$_POST['total_chunks'] : 1;
    $file_name = $_POST['file_name'] ?? '';
    
    $file_paths = [];
    if (isset($_POST['file_paths']) && !empty($_POST['file_paths'])) {
        $file_paths = json_decode($_POST['file_paths'], true);
    }
    
    $success_count = 0;
    $error_count = 0;
    $error_details = [];
    $success_urls = [];
    
    $uploaded_files = $_FILES['files'];
    $total_files = count($uploaded_files['name']);
    
    // AWS S3 Setup
    $s3_client_ajax = null;
    if ($storage_type === 's3') {
        if (class_exists('Aws\S3\S3Client')) {
            try {
                $s3_client_ajax = new Aws\S3\S3Client([
                    'version'     => 'latest',
                    'region'      => $s3_region_ajax,
                    'credentials' => [
                        'key'    => $s3_key_ajax,
                        'secret' => $s3_secret_ajax,
                    ]
                ]);
            } catch (Exception $e) {
                echo json_encode(['success' => 0, 'error' => $total_files, 'details' => ['S3 Connection Error: ' . $e->getMessage()]]);
                exit;
            }
        } else {
            echo json_encode(['success' => 0, 'error' => $total_files, 'details' => ['AWS SDK missing.']]);
            exit;
        }
    }

    $temp_dir = __DIR__ . '/cache/tmp_uploads';
    if (!is_dir($temp_dir)) @mkdir($temp_dir, 0775, true);

    for ($i = 0; $i < $total_files; $i++) {
        if ($uploaded_files['error'][$i] === UPLOAD_ERR_OK) {
            // Capture relative directory path
            $rel_path = !empty($file_paths[$i]) ? $file_paths[$i] : (empty($file_name) ? $uploaded_files['name'][$i] : $file_name);
            $clean_path = ltrim(preg_replace('/\.+[\/\\\\]/', '', $rel_path), '/\\');
            
            $tmp_file_path = $temp_dir . '/' . md5($rel_path . session_id()) . '.part';
            
            $in = fopen($uploaded_files['tmp_name'][$i], "rb");
            $out = fopen($tmp_file_path, $chunk_index == 0 ? "wb" : "ab");
            while ($buff = fread($in, 4096)) fwrite($out, $buff);
            fclose($in);
            fclose($out);
            
            if ($chunk_index == $total_chunks - 1) {
                if ($storage_type === 'local') {
                    $destination = rtrim($target_path, '/') . '/' . $clean_path;
                    $dest_dir = dirname($destination);
                    
                    if (!is_dir($dest_dir)) @mkdir($dest_dir, 0775, true);
                    
                    if (rename($tmp_file_path, $destination)) {
                        chmod($destination, 0644);
                        $success_count++;
                        
                        $public_path = str_replace('/home/sjubedu/public_html', '', $destination);
                        $public_path = str_replace('\\', '/', $public_path);
                        $parts = array_map('rawurlencode', explode('/', ltrim($public_path, '/')));
                        $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http";
                        $domain = $_SERVER['HTTP_HOST'] ?? 'sjub.edu.in';
                        $success_urls[] = $protocol . '://' . $domain . '/' . implode('/', $parts);
                    } else {
                        $error_count++;
                        $error_details[] = "Failed to assemble file: " . htmlspecialchars($clean_path);
                    }
                } elseif ($storage_type === 's3' && $s3_client_ajax) {
                    $s3_object_key = ltrim($s3_prefix_ajax . '/' . $clean_path, '/');
                    try {
                        $s3_client_ajax->putObject(['Bucket' => $s3_bucket_ajax, 'Key' => $s3_object_key, 'SourceFile' => $tmp_file_path]);
                        $success_count++;
                        $success_urls[] = "https://{$s3_bucket_ajax}.s3.{$s3_region_ajax}.amazonaws.com/" . str_replace('%2F', '/', rawurlencode($s3_object_key));
                        @unlink($tmp_file_path);
                    } catch (Exception $e) {
                        $error_count++;
                        $error_details[] = "S3 Upload Failed for " . htmlspecialchars($clean_path) . ": " . $e->getMessage();
                        @unlink($tmp_file_path);
                    }
                }
            } else {
                echo json_encode(['success' => 1, 'error' => 0, 'details' => [], 'urls' => [], 'chunk_done' => true]);
                exit;
            }
        } else {
            $error_count++;
            $error_details[] = "Upload error code: " . $uploaded_files['error'][$i];
        }
    }
    
    echo json_encode(['success' => $success_count, 'error' => $error_count, 'details' => $error_details, 'urls' => $success_urls]);
    exit;
}

// --- State & Storage Mode ---
$mode = $_GET['mode'] ?? 'local';
if (isset($_POST['save_s3_config'])) {
    $_SESSION['s3_mgr_config'] = [
        'bucket' => $_POST['s3_bucket'],
        'region' => $_POST['s3_region'],
        'key' => $_POST['s3_key'],
        'secret' => $_POST['s3_secret']
    ];
    header("Location: file_manager.php?mode=s3");
    exit;
}

// --- Configuration ---
// Set the base directory you want to manage. Users cannot navigate above this directory.
$base_dir = '/home/sjubedu/public_html/';

// Fallback to current directory for local testing if the path doesn't exist
if (!is_dir($base_dir)) {
    $base_dir = realpath(__DIR__);
} else {
    $base_dir = realpath($base_dir);
}

$s3 = null;
$s3_bucket = '';
$s3_ready = false;
$sdk_missing = false;

if ($mode === 's3') {
    if (!class_exists('Aws\S3\S3Client')) {
        $sdk_missing = true;
    } elseif (!empty($_SESSION['s3_mgr_config']['key']) && !empty($_SESSION['s3_mgr_config']['bucket'])) {
        try {
            $s3 = new Aws\S3\S3Client([
                'version' => 'latest',
                'region' => $_SESSION['s3_mgr_config']['region'],
                'credentials' => [
                    'key' => $_SESSION['s3_mgr_config']['key'],
                    'secret' => $_SESSION['s3_mgr_config']['secret']
                ]
            ]);
            $s3_bucket = $_SESSION['s3_mgr_config']['bucket'];
            $s3_ready = true;
        } catch (Exception $e) {
            $message = "<div class='alert alert-danger'>S3 Connection Error: " . htmlspecialchars($e->getMessage()) . "</div>";
        }
    }
}

$req_path = $_GET['path'] ?? '';
$req_path = ltrim(str_replace(['../', '..\\'], '', $req_path), '/\\'); // Basic sanitization

$current_dir = '';
if ($mode === 'local') {
    $current_dir = realpath($base_dir . '/' . $req_path);
    if ($current_dir === false || strpos($current_dir, $base_dir) !== 0) {
        $current_dir = $base_dir;
        $req_path = '';
    }
}

$message = '';
$editable_exts = ['txt', 'php', 'html', 'css', 'js', 'json', 'md', 'xml', 'csv', 'log', 'ini'];

/**
 * Recursively delete a directory
 */
function deleteDir($dirPath) {
    if (!is_dir($dirPath)) return;
    $objects = scandir($dirPath);
    foreach ($objects as $object) {
        if ($object != "." && $object != "..") {
            if (is_dir($dirPath . DIRECTORY_SEPARATOR . $object) && !is_link($dirPath."/".$object))
                deleteDir($dirPath . DIRECTORY_SEPARATOR . $object);
            else
                unlink($dirPath . DIRECTORY_SEPARATOR . $object);
        }
    }
    rmdir($dirPath);
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
    
    if ($mode === 's3' && $s3_ready) {
        $target_key = $_POST['target'] ?? '';
        $target_key = ltrim(str_replace(['../', '..\\'], '', $target_key), '/');
        $is_folder = isset($_POST['is_dir']) && $_POST['is_dir'] == '1';

        if ($action === 'delete' && $target_key !== '') {
            try {
                if ($is_folder) {
                    $prefix_to_delete = rtrim($target_key, '/') . '/';
                    // Recursively delete S3 folder (prefix)
                    $objects = $s3->getPaginator('ListObjectsV2', ['Bucket' => $s3_bucket, 'Prefix' => $prefix_to_delete]);
                    foreach ($objects as $object) {
                        $s3->deleteObject(['Bucket' => $s3_bucket, 'Key' => $object['Key']]);
                    }
                    $message = "<div class='alert alert-success'>S3 Folder deleted successfully.</div>";
                } else {
                    $s3->deleteObject(['Bucket' => $s3_bucket, 'Key' => $target_key]);
                    $message = "<div class='alert alert-success'>S3 File deleted successfully.</div>";
                }
            } catch (Exception $e) {
                $message = "<div class='alert alert-danger'>S3 Delete Error: " . htmlspecialchars($e->getMessage()) . "</div>";
            }
        } elseif ($action === 'save_edit' && $target_key !== '') {
            $content = $_POST['file_content'] ?? '';
            try {
                $s3->putObject(['Bucket' => $s3_bucket, 'Key' => $target_key, 'Body' => $content]);
                $message = "<div class='alert alert-success'>S3 File saved successfully.</div>";
            } catch (Exception $e) {
                $message = "<div class='alert alert-danger'>S3 Save Error: " . htmlspecialchars($e->getMessage()) . "</div>";
            }
        } elseif ($action === 'create_folder') {
            $folder_name = trim($_POST['folder_name'] ?? '');
            $folder_name = preg_replace('/[^a-zA-Z0-9_\-\s]/', '', $folder_name);
            if ($folder_name) {
                $prefix_to_create = rtrim($req_path, '/') . '/' . $folder_name . '/';
                $prefix_to_create = ltrim($prefix_to_create, '/');
                if ($prefix_to_create === '/') $prefix_to_create = $folder_name . '/';
                try {
                    $s3->putObject(['Bucket' => $s3_bucket, 'Key' => $prefix_to_create, 'Body' => '']);
                    $message = "<div class='alert alert-success'>S3 Folder '$folder_name' created successfully.</div>";
                } catch (Exception $e) {
                    $message = "<div class='alert alert-danger'>S3 Create Folder Error: " . htmlspecialchars($e->getMessage()) . "</div>";
                }
            }
        }
    } elseif ($mode === 'local') {
        if ($action === 'create_folder') {
            $folder_name = trim($_POST['folder_name'] ?? '');
            $folder_name = preg_replace('/[^a-zA-Z0-9_\-\s]/', '', $folder_name);
            if ($folder_name) {
                $new_dir = rtrim($current_dir, '/') . '/' . $folder_name;
                if (!is_dir($new_dir)) {
                    if (@mkdir($new_dir, 0775, true)) $message = "<div class='alert alert-success'>Folder '$folder_name' created successfully.</div>";
                    else $message = "<div class='alert alert-danger'>Failed to create folder. Check server permissions.</div>";
                } else {
                    $message = "<div class='alert alert-warning'>Folder already exists.</div>";
                }
            }
        } elseif ($action !== '') {
            $target_file = isset($_POST['target']) ? realpath($base_dir . '/' . $_POST['target']) : '';
            if ($target_file && strpos($target_file, $base_dir) === 0) {
                if ($action === 'delete') {
                    if (is_dir($target_file)) {
                        deleteDir($target_file);
                        $message = "<div class='alert alert-success'>Directory deleted successfully.</div>";
                    } else {
                        unlink($target_file);
                        $message = "<div class='alert alert-success'>File deleted successfully.</div>";
                    }
                } elseif ($action === 'save_edit') {
                    $content = $_POST['file_content'] ?? '';
                    if (file_put_contents($target_file, $content) !== false) {
                        $message = "<div class='alert alert-success'>File saved successfully.</div>";
                    } else {
                        $message = "<div class='alert alert-danger'>Failed to save file. Check permissions.</div>";
                    }
                }
            } else {
                $message = "<div class='alert alert-danger'>Invalid file operation or permission denied.</div>";
            }
        }
    }
}

// --- Handle Download (GET) ---
if (isset($_GET['action']) && $_GET['action'] === 'download' && isset($_GET['file'])) {
    $target_dl = realpath($base_dir . '/' . $_GET['file']);
    if ($target_dl && strpos($target_dl, $base_dir) === 0 && is_file($target_dl)) {
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

// --- Handle Edit Mode (GET) ---
$edit_mode = false;
$edit_content = '';
$edit_file = '';
if (isset($_GET['action']) && $_GET['action'] === 'edit' && isset($_GET['file'])) {
    if ($mode === 's3' && $s3_ready) {
        $target_key = ltrim(str_replace(['../', '..\\'], '', $_GET['file']), '/');
        try {
            $result = $s3->getObject(['Bucket' => $s3_bucket, 'Key' => $target_key]);
            $edit_mode = true;
            $edit_file = $target_key;
            $edit_content = (string) $result['Body'];
        } catch (Exception $e) {
            $message = "<div class='alert alert-danger'>S3 Read Error: " . htmlspecialchars($e->getMessage()) . "</div>";
        }
    } elseif ($mode === 'local') {
        $target_edit = realpath($base_dir . '/' . $_GET['file']);
        if ($target_edit && strpos($target_edit, $base_dir) === 0 && is_file($target_edit)) {
            $edit_mode = true;
            $edit_file = $_GET['file'];
            $edit_content = file_get_contents($target_edit);
        }
    }
}

// Scan Directory if not in edit mode
$items = [];
if (!$edit_mode) {
    if ($mode === 's3' && $s3_ready) {
        $s3_prefix = rtrim($req_path, '/');
        if ($s3_prefix !== '') $s3_prefix .= '/';

        try {
            $results = $s3->listObjectsV2([
                'Bucket' => $s3_bucket,
                'Prefix' => $s3_prefix,
                'Delimiter' => '/'
            ]);

            // Parent link
            if ($s3_prefix !== '') {
                $parent_prefix = preg_replace('/[^\/]+\/$/', '', $s3_prefix);
                $items[] = ['name' => '..', 'path' => rtrim($parent_prefix, '/'), 'is_dir' => true, 'size' => '-', 'mtime' => 0, 'ext' => ''];
            }

            // Directories
            foreach ($results['CommonPrefixes'] ?: [] as $dir) {
                $name = rtrim(substr($dir['Prefix'], strlen($s3_prefix)), '/');
                $items[] = ['name' => $name, 'path' => rtrim($dir['Prefix'], '/'), 'is_dir' => true, 'size' => '-', 'mtime' => 0, 'ext' => ''];
            }

            // Files
            foreach ($results['Contents'] ?: [] as $obj) {
                if ($obj['Key'] === $s3_prefix) continue; // Skip the folder prefix itself
                $name = substr($obj['Key'], strlen($s3_prefix));
                $s3_region = $_SESSION['s3_mgr_config']['region'];
                $public_url = "https://{$s3_bucket}.s3.{$s3_region}.amazonaws.com/" . str_replace('%2F', '/', rawurlencode($obj['Key']));
                
                $items[] = ['name' => $name, 'path' => $obj['Key'], 'is_dir' => false, 'size' => $obj['Size'], 'mtime' => strtotime((string)$obj['LastModified']), 'ext' => strtolower(pathinfo($name, PATHINFO_EXTENSION)), 'url' => $public_url];
            }
        } catch (Exception $e) {
            $message = "<div class='alert alert-danger'>S3 List Error: " . htmlspecialchars($e->getMessage()) . "</div>";
        }
    } elseif ($mode === 'local') {
        $files = scandir($current_dir);
        foreach ($files as $file) {
            if ($file === '.') continue;
            // Hide "up" directory if we are at the base
            if ($file === '..' && $current_dir === $base_dir) continue;

            $full_path = $current_dir . '/' . $file;
            $rel_path = ltrim(str_replace($base_dir, '', $full_path), '/');
            
            $is_dir = is_dir($full_path);
            
            $public_url = '';
            if (!$is_dir) {
                $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http";
                $domain = $_SERVER['HTTP_HOST'] ?? 'sjub.edu.in';
                $web_path = str_replace('/home/sjubedu/public_html', '', $full_path);
                $web_path = str_replace('\\', '/', $web_path);
                $parts = array_map('rawurlencode', explode('/', ltrim($web_path, '/')));
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
    }

    // Sort: directories first (and '..' at the very top), then files alphabetically
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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Server File Manager</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        #dropZone { border: 2px dashed #0d6efd; background-color: #f8f9fa; transition: 0.3s; cursor: pointer; }
        #dropZone.dragover { background-color: #e9ecef; border-color: #198754; }
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
        <li class="nav-item">
            <a class="nav-link <?php echo $mode === 'local' ? 'active fw-bold' : ''; ?>" href="?mode=local"><i class="fa fa-server"></i> Local Server (EC2)</a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?php echo $mode === 's3' ? 'active fw-bold text-warning' : ''; ?>" href="?mode=s3"><i class="fab fa-aws"></i> Amazon S3</a>
        </li>
    </ul>

    <?php echo $message; ?>

    <?php if ($mode === 's3' && !$s3_ready): ?>
        <div class="card shadow-sm mb-4 border-warning">
            <div class="card-header bg-warning text-dark fw-bold"><i class="fab fa-aws"></i> Connect to AWS S3 Bucket</div>
            <div class="card-body">
                <?php if ($sdk_missing): ?>
                    <div class="alert alert-danger mb-0">
                        <strong>AWS SDK Missing!</strong> You must install the AWS SDK for PHP to manage S3 files.<br>
                        Connect via SSH to your server and run: <code>composer require aws/aws-sdk-php</code> in the project directory.
                    </div>
                <?php else: ?>
                    <form method="POST">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label small fw-bold">Bucket Name</label>
                                <?php 
                                $bucket_list = [];
                                if (!empty($S3_BUCKETS)) $bucket_list = array_map('trim', explode(',', $S3_BUCKETS));
                                elseif (!empty($S3_BUCKET)) $bucket_list = [$S3_BUCKET];
                                $default_bucket = $_SESSION['s3_mgr_config']['bucket'] ?? ($bucket_list[0] ?? '');
                                ?>
                                <input type="text" class="form-control" name="s3_bucket" value="<?php echo htmlspecialchars($default_bucket); ?>" list="bucketList" placeholder="e.g. sjub-storage" required>
                                <datalist id="bucketList">
                                    <?php foreach ($bucket_list as $b): ?>
                                        <?php if (!empty($b)): ?><option value="<?php echo htmlspecialchars($b); ?>"><?php endif; ?>
                                    <?php endforeach; ?>
                                </datalist>
                            </div>
                            <div class="col-md-6"><label class="form-label small fw-bold">Region</label><input type="text" class="form-control" name="s3_region" value="<?php echo htmlspecialchars($_SESSION['s3_mgr_config']['region'] ?? ($S3_REGION ?? 'ap-south-1')); ?>" required></div>
                            <div class="col-md-6"><label class="form-label small fw-bold">Access Key</label><input type="text" class="form-control" name="s3_key" value="<?php echo htmlspecialchars($_SESSION['s3_mgr_config']['key'] ?? ($S3_ACCESS_KEY ?? '')); ?>" required></div>
                            <div class="col-md-6"><label class="form-label small fw-bold">Secret Key</label><input type="password" class="form-control" name="s3_secret" value="<?php echo htmlspecialchars($_SESSION['s3_mgr_config']['secret'] ?? ($S3_SECRET_KEY ?? '')); ?>" required></div>
                            <div class="col-12"><button type="submit" name="save_s3_config" class="btn btn-warning fw-bold"><i class="fa fa-link"></i> Connect to Bucket</button></div>
                        </div>
                    </form>
                <?php endif; ?>
            </div>
        </div>
    <?php endif; ?>

    <?php if ($mode === 'local' || ($mode === 's3' && $s3_ready)): ?>
    <div class="card shadow-sm">
        <div class="card-header bg-white d-flex align-items-center fw-bold text-monospace">
            <?php if ($mode === 'local'): ?>
                <i class="fa fa-hdd text-secondary me-2"></i> <?php echo htmlspecialchars($base_dir . '/' . $req_path); ?>
            <?php else: ?>
                <i class="fa fa-cloud text-warning me-2"></i> s3://<?php echo htmlspecialchars($s3_bucket . '/' . $req_path); ?> <a href="?mode=s3&reset=1" class="ms-auto btn btn-sm btn-outline-secondary py-0" onclick="document.forms[0].submit();">Change Bucket</a>
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
                <div class="table-responsive">
                    <table class="table table-hover table-striped align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Name</th>
                                <th>Size</th>
                                <th>Last Modified</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($items as $item): ?>
                            <tr>
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
                                        <?php if (!$item['is_dir']): ?>
                                            <button type="button" onclick="navigator.clipboard.writeText('<?php echo htmlspecialchars($item['url']); ?>'); alert('Link copied to clipboard!');" class="btn btn-sm btn-outline-success py-0 px-2" title="Copy Link"><i class="fa fa-link"></i></button>
                                            <?php if (in_array($item['ext'], $editable_exts)): ?>
                                                <a href="?mode=<?php echo $mode; ?>&action=edit&file=<?php echo urlencode($item['path']); ?>" class="btn btn-sm btn-outline-primary py-0 px-2" title="Edit"><i class="fa fa-edit"></i></a>
                                            <?php endif; ?>
                                            <a href="?mode=<?php echo $mode; ?>&action=download&file=<?php echo urlencode($item['path']); ?>" class="btn btn-sm btn-outline-info py-0 px-2" title="Download"><i class="fa fa-download"></i></a>
                                        <?php endif; ?>
                                        <form method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this <?php echo $item['is_dir'] ? 'folder and ALL its contents' : 'file'; ?>? This cannot be undone.');">
                                            <input type="hidden" name="action" value="delete">
                                            <input type="hidden" name="is_dir" value="<?php echo $item['is_dir'] ? '1' : '0'; ?>">
                                            <input type="hidden" name="target" value="<?php echo htmlspecialchars($item['path']); ?>">
                                            <button type="submit" class="btn btn-sm btn-outline-danger py-0 px-2" title="Delete"><i class="fa fa-trash"></i></button>
                                        </form>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </div>
    <?php endif; ?>
</div>

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
                    <input type="hidden" name="s3_bucket" value="<?php echo htmlspecialchars($s3_bucket); ?>">
                    <input type="hidden" name="s3_region" value="<?php echo htmlspecialchars($_SESSION['s3_mgr_config']['region'] ?? ($S3_REGION ?? 'ap-south-1')); ?>">
                    <input type="hidden" name="s3_key" value="<?php echo htmlspecialchars($_SESSION['s3_mgr_config']['key'] ?? ($S3_ACCESS_KEY ?? '')); ?>">
                    <input type="hidden" name="s3_secret" value="<?php echo htmlspecialchars($_SESSION['s3_mgr_config']['secret'] ?? ($S3_SECRET_KEY ?? '')); ?>">
                    <input type="hidden" name="s3_prefix" value="<?php echo htmlspecialchars($req_path); ?>">
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
    function createFolder() {
        const folderName = prompt("Enter new folder name:");
        if (folderName && folderName.trim() !== "") {
            document.getElementById('folderNameInput').value = folderName.trim();
            document.getElementById('createFolderForm').submit();
        }
    }

    // Universal Upload Logic
    let selectedFiles = [];
    const dropZone = document.getElementById('dropZone');
    const fileInput = document.getElementById('fileInput');
    const folderInput = document.getElementById('folderInput');
    const uploadBtn = document.getElementById('uploadBtn');
    const fileCountDiv = document.getElementById('fileCount');

    ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => { dropZone.addEventListener(eventName, preventDefaults, false); });
    function preventDefaults(e) { e.preventDefault(); e.stopPropagation(); }
    ['dragenter', 'dragover'].forEach(eventName => { dropZone.addEventListener(eventName, () => dropZone.classList.add('dragover'), false); });
    ['dragleave', 'drop'].forEach(eventName => { dropZone.addEventListener(eventName, () => dropZone.classList.remove('dragover'), false); });

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
        
        // New UI Elements
        const uploadSpeedSpan = document.getElementById('uploadSpeed');
        const timeRemainingSpan = document.getElementById('timeRemaining');
        uploadSpeedSpan.innerText = 'Speed: 0.00 MB/s';
        timeRemainingSpan.innerText = 'Time remaining: Calculating...';

        const CHUNK_SIZE = 2 * 1024 * 1024; // 2MB chunks
        let totalBytes = selectedFiles.reduce((acc, file) => acc + file.size, 0);
        let uploadedBytes = 0;
        let globalErrors = [];
        let globalUrls = [];
        let totalUploadedFiles = 0;

        // Speed/Time Calculation Variables
        let lastUpdateTime = Date.now();
        let lastUpdateBytes = 0;

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
                    const response = await new Promise((resolve, reject) => {
                        const xhr = new XMLHttpRequest();
                        xhr.open('POST', window.location.href, true);
                        
                        xhr.upload.onprogress = (event) => {
                            if (event.lengthComputable) {
                                const currentUpload = uploadedBytes + event.loaded;
                                const percent = Math.floor((currentUpload / totalBytes) * 100);
                                progressBar.style.width = percent + '%';
                                progressText.innerText = `Uploading... ${percent}%`;

                                // Calculate Speed & Remaining Time
                                const now = Date.now();
                                const deltaSeconds = (now - lastUpdateTime) / 1000;

                                // Update every 500ms for a stable UI reading
                                if (deltaSeconds >= 0.5 || currentUpload === totalBytes) {
                                    const deltaBytes = currentUpload - lastUpdateBytes;
                                    const speedBps = deltaBytes / deltaSeconds; // Bytes per second

                                    if (speedBps > 0) {
                                        // Update Speed
                                        const speedMBps = (speedBps / (1024 * 1024)).toFixed(2);
                                        uploadSpeedSpan.innerText = `Speed: ${speedMBps} MB/s`;

                                        // Update Time
                                        const remainingBytes = totalBytes - currentUpload;
                                        const remainingSecs = Math.max(0, Math.ceil(remainingBytes / speedBps));
                                        
                                        if (remainingSecs > 60) {
                                            const mins = Math.floor(remainingSecs / 60);
                                            const secs = remainingSecs % 60;
                                            timeRemainingSpan.innerText = `Time remaining: ${mins}m ${secs}s`;
                                        } else {
                                            timeRemainingSpan.innerText = `Time remaining: ${remainingSecs}s`;
                                        }
                                    }

                                    lastUpdateTime = now;
                                    lastUpdateBytes = currentUpload;
                                }
                            }
                        };

                        xhr.onload = () => {
                            if (xhr.status >= 200 && xhr.status < 300) {
                                uploadedBytes += chunk.size;
                                try {
                                    const res = JSON.parse(xhr.responseText);
                                    if (res.details && res.details.length > 0) globalErrors.push(...res.details);
                                    if (res.urls && res.urls.length > 0) globalUrls.push(...res.urls);
                                    resolve(res);
                                } catch(err) {
                                    globalErrors.push(`Server returned invalid response for chunk ${chunkIndex+1} of ${file.name}.`);
                                    resolve({ error: 1 });
                                }
                            } else {
                                reject(`HTTP Error ${xhr.status} on file ${file.name}`);
                            }
                        };
                        xhr.onerror = () => reject(`Network error on file ${file.name}`);
                        xhr.send(formData);
                    });
                } catch (err) {
                    globalErrors.push(err);
                    break; // Stop uploading this file if a chunk fails
                }
            }
            totalUploadedFiles++;
            progressCount.innerText = `${totalUploadedFiles} / ${selectedFiles.length}`;
        }
        
        progressBar.style.width = '100%';
        progressBar.classList.remove('progress-bar-animated');
        progressText.innerText = 'Upload Complete!';
        uploadSpeedSpan.innerText = 'Speed: 0.00 MB/s';
        timeRemainingSpan.innerText = 'Time remaining: Complete';
        
        let msg = `<div class="alert alert-success">Successfully processed ${totalUploadedFiles} files. Refresh page to see them.</div>`;
        if (globalUrls.length > 0) {
            msg += `<div class="card mt-3"><div class="card-header bg-light fw-bold"><i class="fa fa-link"></i> Uploaded Links</div><div class="card-body p-0" style="max-height: 200px; overflow-y: auto;"><ul class="list-group list-group-flush" style="font-size: 0.85rem;">`;
            globalUrls.forEach(url => { msg += `<li class="list-group-item py-1"><a href="${url}" target="_blank" class="text-decoration-none text-break">${url}</a></li>`; });
            msg += `</ul></div></div>`;
        }
        if (globalErrors.length > 0) {
            msg += `<div class="alert alert-danger mt-3">Some errors occurred:<ul class="mb-0"><li>${globalErrors.slice(0,10).join('</li><li>')}</li></ul></div>`;
        }
        document.getElementById('resultMessage').innerHTML = msg;
        setTimeout(() => window.location.reload(), 5000);
    });
</script>

<?php if ($mode === 's3' && isset($_GET['reset'])): ?>
<script>
    <?php unset($_SESSION['s3_mgr_config']); ?>
    window.location.href = '?mode=s3';
</script>
<?php endif; ?>
</body>
</html>