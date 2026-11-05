<?php
session_start();
$config = file_exists('/home/sjubedu/config.php') ? '/home/sjubedu/config.php' : __DIR__ . '/../../config.php';
if (file_exists($config)) {
    require_once $config;
}

// Authentication Check
if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== true || !in_array('manage_gallery', $_SESSION['admin_perms'] ?? [])) {
    header("Location: dashboard.php");
    exit;
}

$target_dir = "/home/sjubedu/public_html/Gallery/";
$message = "";

// Ensure base directory exists
if (!is_dir($target_dir)) {
    if (!@mkdir($target_dir, 0775, true)) {
        $message = "<div class='alert alert-danger'><i class='fa fa-exclamation-triangle me-2'></i><strong>Server Permission Error:</strong> PHP does not have permission to create the folder <code>$target_dir</code>. <br><br>Please connect to your EC2 instance via SSH and run:<br><code>sudo mkdir -p $target_dir</code><br><code>sudo chown -R www-data:www-data $target_dir</code><br><code>sudo chmod -R 775 $target_dir</code></div>";
    }
} elseif (!is_writable($target_dir)) {
    $message = "<div class='alert alert-danger'><i class='fa fa-exclamation-triangle me-2'></i><strong>Server Permission Error:</strong> The folder <code>$target_dir</code> exists but is not writable by PHP. <br><br>Please connect to your EC2 instance via SSH and run:<br><code>sudo chown -R www-data:www-data $target_dir</code><br><code>sudo chmod -R 775 $target_dir</code></div>";
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if post_max_size was exceeded (Silent Failure Detection)
    if (empty($_POST) && empty($_FILES) && isset($_SERVER['CONTENT_LENGTH']) && $_SERVER['CONTENT_LENGTH'] > 0) {
        $message = "<div class='alert alert-danger'><i class='fa fa-exclamation-triangle me-2'></i><strong>Upload Failed:</strong> The folder size exceeds the server's configured <code>post_max_size</code> (" . ini_get('post_max_size') . "). Please upload smaller batches or increase your server limits.</div>";
    } elseif (isset($_POST['delete_folder'])) {
        $folder_to_delete = basename($_POST['delete_folder']);
        $del_path = $target_dir . $folder_to_delete;
        
        if (is_dir($del_path) && $folder_to_delete !== '.' && $folder_to_delete !== '..') {
            try {
                $iterator = new RecursiveDirectoryIterator($del_path, RecursiveDirectoryIterator::SKIP_DOTS);
                $files = new RecursiveIteratorIterator($iterator, RecursiveIteratorIterator::CHILD_FIRST);
                foreach($files as $file) {
                    if ($file->isDir()){ rmdir($file->getRealPath()); }
                    else { unlink($file->getRealPath()); }
                }
                rmdir($del_path);
                $message = "<div class='alert alert-success'><i class='fa fa-check-circle me-2'></i>Successfully deleted <strong>" . htmlspecialchars($folder_to_delete) . "</strong></div>";
            } catch (Exception $e) {
                $message = "<div class='alert alert-danger'>Error deleting folder: " . $e->getMessage() . "</div>";
            }
        } else {
            $message = "<div class='alert alert-danger'>Folder not found or invalid.</div>";
        }
    } elseif (isset($_POST['rename_folder'])) {
        $old_folder = basename($_POST['old_folder_name']);
        $new_folder = basename($_POST['new_folder_name']);
        $old_path = $target_dir . $old_folder;
        $new_path = $target_dir . $new_folder;
        
        if (is_dir($old_path) && $old_folder !== '.' && $old_folder !== '..' && !empty($new_folder)) {
            if (!is_dir($new_path)) {
                if (rename($old_path, $new_path)) {
                    $message = "<div class='alert alert-success'><i class='fa fa-check-circle me-2'></i>Successfully renamed folder to <strong>" . htmlspecialchars($new_folder) . "</strong></div>";
                } else {
                    $message = "<div class='alert alert-danger'>Error renaming folder.</div>";
                }
            } else {
                $message = "<div class='alert alert-danger'>A folder with the new name already exists.</div>";
            }
        } else {
            $message = "<div class='alert alert-danger'>Invalid folder name.</div>";
        }
    } elseif (isset($_POST['rename_image'])) {
        $old_image = $_POST['old_image_name'];
        $new_image_name = basename($_POST['new_image_name']);
        
        if (strpos($old_image, '..') === false && !empty($new_image_name)) {
            $old_path = $target_dir . $old_image;
            $new_path = dirname($old_path) . '/' . $new_image_name;
            
            if (is_file($old_path)) {
                if (!is_file($new_path)) {
                    if (rename($old_path, $new_path)) {
                        $message = "<div class='alert alert-success'><i class='fa fa-check-circle me-2'></i>Successfully renamed image to <strong>" . htmlspecialchars($new_image_name) . "</strong></div>";
                    } else {
                        $message = "<div class='alert alert-danger'>Error renaming image.</div>";
                    }
                } else {
                    $message = "<div class='alert alert-danger'>An image with the new name already exists in this folder.</div>";
                }
            } else {
                $message = "<div class='alert alert-danger'>Image not found.</div>";
            }
        } else {
            $message = "<div class='alert alert-danger'>Invalid image path.</div>";
        }
    } elseif (isset($_POST['delete_image'])) {
        $img_to_delete = $_POST['delete_image'];
        if (strpos($img_to_delete, '..') === false) {
            $del_path = $target_dir . $img_to_delete;
            if (is_file($del_path)) {
                unlink($del_path);
                $message = "<div class='alert alert-success'><i class='fa fa-check-circle me-2'></i>Successfully deleted image <strong>" . htmlspecialchars(basename($img_to_delete)) . "</strong></div>";
            } else {
                $message = "<div class='alert alert-danger'>Image not found.</div>";
            }
        } else {
            $message = "<div class='alert alert-danger'>Invalid image path.</div>";
        }
    } elseif (isset($_FILES['files']) && !empty($_FILES['files']['name'][0])) {
        $uploaded_files = $_FILES['files'];
        $total_files = count($uploaded_files['name']);
        $success_count = 0;
        $error_count = 0;
        $error_details = [];
        
        $file_paths = [];
        if (isset($_POST['file_paths']) && !empty($_POST['file_paths'])) {
            $file_paths = json_decode($_POST['file_paths'], true);
        }

        for ($i = 0; $i < $total_files; $i++) {
            if ($uploaded_files['error'][$i] === UPLOAD_ERR_OK) {
                // Get the relative path from the upload if available (PHP 8.1+)
                // Fallback to JS provided path or name if full_path is missing
                if (!empty($file_paths[$i])) {
                    $rel_path = $file_paths[$i];
                } else {
                    $rel_path = isset($uploaded_files['full_path'][$i]) && !empty($uploaded_files['full_path'][$i]) 
                                ? $uploaded_files['full_path'][$i] 
                                : $uploaded_files['name'][$i];
                }
                
                // Sanitize path to prevent directory traversal
                $clean_path = preg_replace('/\.+[\/\\\\]/', '', $rel_path);
                $clean_path = ltrim($clean_path, '/\\'); // Remove leading slashes
                
                $destination = $target_dir . $clean_path;
                $dest_dir = dirname($destination);
                
                // Create the directory structure if it doesn't exist
                if (!is_dir($dest_dir)) {
                    if (!@mkdir($dest_dir, 0775, true)) {
                        $error_count++;
                        $error_details[] = "Could not create server directory for " . htmlspecialchars($clean_path);
                        continue;
                    }
                }

                // Move the file to the destination
                if (move_uploaded_file($uploaded_files['tmp_name'][$i], $destination)) {
                    chmod($destination, 0644); // Make sure the web server can read it
                    $success_count++;
                } else {
                    $error_count++;
                    $error_details[] = "Failed to move file to server disk: " . htmlspecialchars($clean_path);
                }
            } else {
                $error_count++;
                $err_code = $uploaded_files['error'][$i];
                $err_messages = [
                    UPLOAD_ERR_INI_SIZE   => 'File is too large (exceeds upload_max_filesize in php.ini)',
                    UPLOAD_ERR_FORM_SIZE  => 'File is too large (exceeds MAX_FILE_SIZE in HTML form)',
                    UPLOAD_ERR_PARTIAL    => 'File was only partially uploaded',
                    UPLOAD_ERR_NO_FILE    => 'No file was uploaded',
                    UPLOAD_ERR_NO_TMP_DIR => 'Missing a temporary folder on the server',
                    UPLOAD_ERR_CANT_WRITE => 'Server failed to write file to disk',
                    UPLOAD_ERR_EXTENSION  => 'A PHP extension stopped the file upload',
                ];
                $err_reason = $err_messages[$err_code] ?? "Unknown upload error ($err_code)";
                $error_details[] = htmlspecialchars($uploaded_files['name'][$i]) . " - " . $err_reason;
            }
        }
        
        if (isset($_POST['ajax_upload'])) {
            header('Content-Type: application/json');
            echo json_encode([
                'success' => $success_count,
                'error' => $error_count,
                'details' => $error_details
            ]);
            exit;
        }
        
        $msg_class = $error_count === 0 ? 'alert-success' : ($success_count > 0 ? 'alert-warning' : 'alert-danger');
        $message = "<div class='alert $msg_class mb-2'>Successfully uploaded $success_count files. " . ($error_count > 0 ? "$error_count failed." : "") . "</div>";
        
        if (!empty($error_details)) {
            $max_file_uploads = ini_get('max_file_uploads');
            $message .= "<div class='alert alert-danger small mt-2'><strong>Error Details:</strong><ul class='mb-0'><li>" . implode("</li><li>", array_slice($error_details, 0, 15)) . (count($error_details) > 15 ? "</li><li>...and more." : "") . "</li></ul>";
            if ($total_files >= $max_file_uploads) {
                $message .= "<hr><div class='fw-bold text-danger'><i class='fa fa-info-circle me-1'></i> Note: Your PHP server limits uploads to <strong>$max_file_uploads files at a time</strong> (<code>max_file_uploads</code> setting in php.ini). You uploaded $total_files files. Try uploading the folder in smaller batches, or increase the limit in your server's php.ini.</div>";
            }
            $message .= "</div>";
        }
    } elseif (isset($_FILES['files'])) {
        $message = "<div class='alert alert-danger'>No files uploaded. Make sure the folder is not empty and fits within your server upload size limits.</div>";
    }
}

// Get a list of existing directories in the Gallery
$existing_folders = [];
if (is_dir($target_dir)) {
    $items = scandir($target_dir);
    foreach ($items as $item) {
        if ($item !== '.' && $item !== '..' && is_dir($target_dir . $item)) {
            $existing_folders[] = $item;
        }
    }
}

// Prepare preview images if a folder is selected to view
$view_folder = isset($_GET['view_folder']) ? basename($_GET['view_folder']) : '';
$preview_images = [];
if (!empty($view_folder) && is_dir($target_dir . $view_folder)) {
    $dir_path = $target_dir . $view_folder;
    $iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dir_path));
    foreach ($iterator as $file) {
        if ($file->isFile()) {
            $ext = strtolower($file->getExtension());
            if (in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp'])) {
                $rel_path = substr($file->getRealPath(), strlen($dir_path) + 1);
                $preview_images[] = [
                    'name' => $file->getFilename(),
                    'rel_path' => str_replace('\\', '/', $rel_path)
                ];
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include $_SERVER['DOCUMENT_ROOT'] . '/gtm.php'; ?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gallery Folder Upload</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .folder-list { max-height: 400px; overflow-y: auto; }
        #folderInput { position: absolute; top: 0; left: 0; width: 100%; height: 100%; opacity: 0; cursor: pointer; z-index: 10; }
        #dropZone { transition: all 0.2s ease; }
        #dropZone.dragover { background-color: #e9ecef !important; border-color: #0d6efd !important; }
        .folder-item { transition: background-color 0.2s; }
        .folder-item:hover { background-color: #f8f9fa; }
    </style>
</head>
<body class="bg-light p-4">
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><i class="fa fa-folder-open text-primary"></i> Gallery Directory Upload</h2>
        <a href="dashboard.php" class="btn btn-secondary">Back to Dashboard</a>
    </div>
    <?php echo $message; ?>
    <div class="row">
        <div class="col-md-8">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white fw-bold">Upload Folder</div>
                <div class="card-body">
                    <p class="text-muted mb-4">Select a folder from your computer. The entire folder and its contents will be uploaded into <code>/home/sjubedu/public_html/Gallery/</code> preserving the directory structure.</p>
                    <form action="" method="post" enctype="multipart/form-data" id="uploadForm">
                        <input type="hidden" name="file_paths" id="filePaths">
                        <div class="mb-4 p-5 border rounded bg-light text-center position-relative" id="dropZone" style="border-style: dashed !important; border-width: 2px !important;">
                            <input type="file" name="files[]" id="folderInput" multiple webkitdirectory directory required>
                            <i class="fa fa-cloud-upload-alt text-primary mb-3" style="font-size: 3rem;"></i>
                            <h5 class="mb-2">Drag & Drop a folder here</h5>
                            <p class="text-muted mb-3">or click anywhere in this box to browse</p>
                            <div class="mt-3 text-primary fw-bold small" id="fileCount">No folder selected</div>
                        </div>
                        <div class="alert alert-info small"><i class="fa fa-info-circle me-2"></i><strong>Note:</strong> The system will automatically chunk large folders into smaller batches to bypass server file size and count limits.</div>
                        <button type="submit" class="btn btn-success w-100 btn-lg" id="uploadBtn" disabled><i class="fa fa-upload"></i> Start Upload</button>
                        
                        <div id="progressContainer" class="d-none mt-3">
                            <div class="d-flex justify-content-between small mb-1 fw-bold text-secondary">
                                <span id="progressText">Uploading... 0%</span>
                                <span id="uploadSpeed" class="ms-2"></span>
                                <span id="progressCount">0 / 0 files</span>
                            </div>
                            <div class="progress" style="height: 20px;">
                                <div id="progressBar" class="progress-bar progress-bar-striped progress-bar-animated bg-success" role="progressbar" style="width: 0%;"></div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white fw-bold"><i class="fa fa-images text-secondary me-2"></i> Existing Gallery Folders</div>
                <ul class="list-group list-group-flush folder-list">
                    <?php if (empty($existing_folders)): ?>
                        <li class="list-group-item text-muted text-center py-3">No folders found in Gallery.</li>
                    <?php else: ?>
                        <?php foreach ($existing_folders as $folder): ?>
                            <li class="list-group-item d-flex justify-content-between align-items-center folder-item">
                                <div>
                                    <i class="fa fa-folder text-warning me-2"></i>
                                    <span><?php echo htmlspecialchars($folder); ?></span>
                                </div>
                                <div class="d-flex align-items-center">
                                    <button type="button" class="btn btn-sm btn-outline-secondary py-0 px-1 me-2" title="Rename Folder" onclick="renameFolder('<?php echo htmlspecialchars(addslashes($folder)); ?>')"><i class="fa fa-edit"></i></button>
                                <a href="?view_folder=<?php echo rawurlencode($folder); ?>" class="btn btn-sm btn-outline-info py-0 px-1 me-2" title="Preview Images"><i class="fa fa-eye"></i></a>
                                    <form method="POST" class="m-0" onsubmit="return confirm('Are you sure you want to completely delete the folder \'<?php echo htmlspecialchars(addslashes($folder)); ?>\' and all its contents?');">
                                        <input type="hidden" name="delete_folder" value="<?php echo htmlspecialchars($folder); ?>">
                                        <button type="submit" class="btn btn-sm btn-outline-danger py-0 px-1" title="Delete Folder"><i class="fa fa-trash"></i></button>
                                    </form>
                                </div>
                            </li>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </div>

    <?php if (!empty($view_folder) && is_dir($target_dir . $view_folder)): ?>
    <div class="card shadow-sm mb-4" id="previewSection">
        <div class="card-header bg-white fw-bold d-flex justify-content-between align-items-center">
            <span><i class="fa fa-images text-info me-2"></i> Preview: <?php echo htmlspecialchars($view_folder); ?></span>
            <a href="gallery_upload.php" class="btn btn-sm btn-close" title="Close Preview"></a>
        </div>
        <div class="card-body">
            <?php if (empty($preview_images)): ?>
                <p class="text-muted mb-0">No images found in this folder.</p>
            <?php else: ?>
                <div class="row row-cols-2 row-cols-md-4 row-cols-lg-6 g-3">
                    <?php foreach ($preview_images as $img): 
                        // Map physical path to URL path assuming public_html is document root
                    $img_url = "/Gallery/" . rawurlencode($view_folder) . "/" . implode('/', array_map('rawurlencode', explode('/', $img['rel_path'])));
                        $physical_rel_path = $view_folder . '/' . $img['rel_path'];
                    ?>
                    <div class="col">
                        <div class="card h-100 border-0 shadow-sm position-relative">
                            <div class="position-absolute top-0 end-0 m-1 d-flex gap-1" style="z-index: 10;">
                                <button type="button" class="btn btn-sm btn-secondary py-0 px-1 shadow" title="Rename Image" style="line-height: 1;" onclick="renameImage('<?php echo htmlspecialchars(addslashes($physical_rel_path)); ?>', '<?php echo htmlspecialchars(addslashes($img['name'])); ?>')"><i class="fa fa-edit" style="font-size: 11px;"></i></button>
                                <form method="POST" action="?view_folder=<?php echo rawurlencode($view_folder); ?>" class="m-0" onsubmit="return confirm('Are you sure you want to delete this image?');">
                                    <input type="hidden" name="delete_image" value="<?php echo htmlspecialchars($physical_rel_path); ?>">
                                    <button type="submit" class="btn btn-sm btn-danger py-0 px-1 shadow" title="Delete Image" style="line-height: 1;"><i class="fa fa-times" style="font-size: 11px;"></i></button>
                                </form>
                            </div>
                            <img src="<?php echo htmlspecialchars($img_url); ?>" class="card-img-top" alt="Image" loading="lazy" style="height: 120px; object-fit: cover;">
                            <div class="card-body p-2 text-center">
                                <small class="text-muted text-truncate d-block" title="<?php echo htmlspecialchars($img['rel_path']); ?>"><?php echo htmlspecialchars($img['name']); ?></small>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
    <?php endif; ?>
</div>

<form id="renameFolderForm" method="POST" style="display:none;">
    <input type="hidden" name="rename_folder" value="1">
    <input type="hidden" name="old_folder_name" id="oldFolderName">
    <input type="hidden" name="new_folder_name" id="newFolderName">
</form>

<form id="renameImageForm" method="POST" style="display:none;" action="?view_folder=<?php echo urlencode($view_folder); ?>">
    <input type="hidden" name="rename_image" value="1">
    <input type="hidden" name="old_image_name" id="oldImageName">
    <input type="hidden" name="new_image_name" id="newImageName">
</form>

<script>
const folderInput = document.getElementById('folderInput');
const dropZone = document.getElementById('dropZone');

folderInput.addEventListener('dragenter', () => dropZone.classList.add('dragover'));
folderInput.addEventListener('dragleave', () => dropZone.classList.remove('dragover'));
folderInput.addEventListener('drop', () => dropZone.classList.remove('dragover'));

folderInput.addEventListener('change', function(e) {
    const files = e.target.files;
    const btn = document.getElementById('uploadBtn');
    const fileCountText = document.getElementById('fileCount');
    if (files.length > 0) {
        const paths = [];
        for (let i = 0; i < files.length; i++) {
            paths.push(files[i].webkitRelativePath);
        }
        document.getElementById('filePaths').value = JSON.stringify(paths);
        fileCountText.innerHTML = `<strong>${files.length}</strong> file(s) ready to upload from folder <strong>${files[0].webkitRelativePath.split('/')[0]}</strong>`;
        btn.disabled = false;
    } else {
        document.getElementById('filePaths').value = '';
        fileCountText.innerHTML = 'No folder selected';
        btn.disabled = true;
    }
});

document.getElementById('uploadForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const files = document.getElementById('folderInput').files;
    if (files.length === 0) return;

    const btn = document.getElementById('uploadBtn');
    btn.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Uploading... Please wait';
    btn.disabled = true;

    document.getElementById('progressContainer').classList.remove('d-none');
    const progressBar = document.getElementById('progressBar');
    const progressText = document.getElementById('progressText');
    const progressCount = document.getElementById('progressCount');

    const BATCH_SIZE_LIMIT = 2 * 1024 * 1024; // 2MB to stay safely under server limits
    const BATCH_FILE_LIMIT = 20; // Default PHP max_file_uploads is 20

    let batches = [];
    let currentBatch = new FormData();
    let currentBatchSize = 0;
    let currentBatchFiles = 0;
    let filePaths = [];

    for (let i = 0; i < files.length; i++) {
        const file = files[i];

        // If current file would push batch over limit, finalize previous batch
        if (currentBatchFiles > 0 && (currentBatchSize + file.size > BATCH_SIZE_LIMIT || currentBatchFiles >= BATCH_FILE_LIMIT)) {
            currentBatch.append('file_paths', JSON.stringify(filePaths));
            currentBatch.append('ajax_upload', '1');
            batches.push({ formData: currentBatch, fileCount: currentBatchFiles });
            
            currentBatch = new FormData();
            currentBatchSize = 0;
            currentBatchFiles = 0;
            filePaths = [];
        }

        // Add file to current batch
        currentBatch.append('files[]', file);
        filePaths.push(file.webkitRelativePath);
        currentBatchSize += file.size;
        currentBatchFiles++;

        // If it's the last file, finalize the last batch
        if (i === files.length - 1) {
            currentBatch.append('file_paths', JSON.stringify(filePaths));
            currentBatch.append('ajax_upload', '1');
            batches.push({ formData: currentBatch, fileCount: currentBatchFiles });
        }
    }

    let currentBatchIndex = 0;
    let totalUploadedFiles = 0;
    const totalFiles = files.length;
    let globalErrors = [];
    
    let batchStartTime = 0; // To track the start time of the current batch upload
    let batchLoadedBytes = 0; // To track loaded bytes for the current batch

    function uploadNextBatch() {
        if (currentBatchIndex >= batches.length) {
            progressBar.style.width = "100%";
            progressBar.classList.remove('progress-bar-animated');

            if (globalErrors.length > 0) {
                document.getElementById('uploadSpeed').innerText = ''; // Clear speed display
                progressText.innerText = "Upload Complete with errors.";
                let errorHtml = '<div class="alert alert-danger mt-3"><strong>Upload completed with errors:</strong><ul class="mb-0 small">';
                globalErrors.forEach(err => {
                    errorHtml += `<li>${err}</li>`;
                });
                errorHtml += '</ul></div>';
                document.getElementById('progressContainer').insertAdjacentHTML('afterend', errorHtml);
                // Do not reload on error
            } else {
                progressText.innerText = "Upload Complete!";
                document.getElementById('uploadSpeed').innerText = ''; // Clear speed display
                setTimeout(() => window.location.reload(), 1500);
            }
            return;
        }

        const batch = batches[currentBatchIndex];
        
        // Reset for the new batch
        batchStartTime = Date.now();
        batchLoadedBytes = 0;
        document.getElementById('uploadSpeed').innerText = '';

        const xhr = new XMLHttpRequest();
        xhr.open('POST', window.location.href, true);

        xhr.upload.onprogress = function(event) {
            if (event.lengthComputable) {
                const batchPercent = event.loaded / event.total;
                const overallFilesDone = totalUploadedFiles + (batch.fileCount * batchPercent);
                const overallPercent = Math.floor((overallFilesDone / totalFiles) * 100);
                progressBar.style.width = overallPercent + '%';
                progressText.innerText = `Uploading... ${overallPercent}%`;

                // Calculate live upload speed for the current batch
                const currentTime = Date.now();
                const timeElapsedSeconds = (currentTime - batchStartTime) / 1000; // in seconds
                
                if (timeElapsedSeconds > 0) {
                    const currentSpeedBps = event.loaded / timeElapsedSeconds; // Bytes per second
                    const currentSpeedMBps = currentSpeedBps / (1024 * 1024); // MB per second
                    document.getElementById('uploadSpeed').innerText = `(${currentSpeedMBps.toFixed(2)} MB/s)`;
                } else {
                    document.getElementById('uploadSpeed').innerText = `(Calculating...)`;
                }
            }
        };

        xhr.onload = function() {
            try {
                const res = JSON.parse(xhr.responseText);
                if (res.error > 0 && res.details) {
                    globalErrors.push(...res.details);
                }
            } catch (e) {
                globalErrors.push(`Server returned a non-JSON response for batch ${currentBatchIndex + 1}. This is likely a server error (e.g., 413 Request Entity Too Large, 500 Internal Server Error). Check the browser's network tab for details.`);
            }
            totalUploadedFiles += batch.fileCount;
            currentBatchIndex++;
            progressCount.innerText = `${totalUploadedFiles} / ${totalFiles} files`;
            document.getElementById('uploadSpeed').innerText = ''; // Clear speed after batch completes
            uploadNextBatch();
        };

        xhr.onerror = function() {
            globalErrors.push("Network error on batch " + (currentBatchIndex + 1) + ". The server may have dropped the connection. This is often caused by exceeding server limits like `post_max_size` or `client_max_body_size`.");
            totalUploadedFiles += batch.fileCount;
            currentBatchIndex++;
            progressCount.innerText = `${totalUploadedFiles} / ${totalFiles} files`;
            document.getElementById('uploadSpeed').innerText = ''; // Clear speed after batch errors
            uploadNextBatch();
        };

        xhr.send(batch.formData);
    }

    progressCount.innerText = `0 / ${totalFiles} files`;
    uploadNextBatch();
});

function renameFolder(oldName) {
    const newName = prompt("Enter new name for folder:", oldName);
    if (newName && newName.trim() !== "" && newName !== oldName) {
        document.getElementById('oldFolderName').value = oldName;
        document.getElementById('newFolderName').value = newName.trim();
        document.getElementById('renameFolderForm').submit();
    }
}

function renameImage(oldPath, oldName) {
    const newName = prompt("Enter new name for image (including extension):", oldName);
    if (newName && newName.trim() !== "" && newName !== oldName) {
        document.getElementById('oldImageName').value = oldPath;
        document.getElementById('newImageName').value = newName.trim();
        document.getElementById('renameImageForm').submit();
    }
}

<?php if (!empty($view_folder) && is_dir($target_dir . $view_folder)): ?>
document.addEventListener("DOMContentLoaded", function() {
    document.getElementById('previewSection').scrollIntoView({behavior: 'smooth'});
});
<?php endif; ?>
</script>
</body>
</html>