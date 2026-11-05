<?php
// Test/create_faculty.php - CMS UI to create a single faculty profile
ini_set('display_errors', 1);
error_reporting(E_ALL);
session_start();
$config = file_exists('/home/sjubedu/config.php') ? '/home/sjubedu/config.php' : __DIR__ . '/../../config.php';
if (file_exists($config)) {
    require_once $config;
}

// Authentication Check
if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== true) {
    header("Location: dashboard.php");
    exit;
}
if (!in_array('add_faculty', $_SESSION['admin_perms'] ?? []) && !in_array('sync_data', $_SESSION['admin_perms'] ?? [])) {
    die("<div style='font-family:sans-serif; padding:20px; color:red;'><h2>Access Denied</h2><p>You do not have the permission required to access this tool.</p></div>");
}

// Helper function for base64 URL-safe encoding
if (!function_exists('base64_url_encode')) {
    function base64_url_encode($data) {
        return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
    }
}

// AJAX Handler to list existing faculty in a directory
if (isset($_GET['action']) && $_GET['action'] === 'list_files') {
    $school = $_GET['school'] ?? '';
    $dept = $_GET['dept'] ?? '';
    $base_dir = '/home/sjubedu/public_html/';
    if (!is_dir($base_dir)) {
        $base_dir = realpath(__DIR__ . '/../') . '/';
    }
    $target_dir = rtrim($base_dir, '/') . '/' . $school . '/' . $dept;
    $files_data = [];
    
    if (is_dir($target_dir)) {
        $files = glob($target_dir . '/*.php');
        foreach ($files as $file) {
            $content = file_get_contents($file);
            if (strpos($content, '$FACULTY_ID') !== false) {
                preg_match('/\$FACULTY_ID\s*=\s*[\'"]([^\'"]+)[\'"];/', $content, $m_id);
                preg_match('/\$salutation\s*=\s*[\'"]([^\'"]*)[\'"];/', $content, $m_sal);
                preg_match('/\$designation\s*=\s*[\'"]([^\'"]*)[\'"];/', $content, $m_des);
                preg_match('/\$department\s*=\s*[\'"]([^\'"]*)[\'"];/', $content, $m_dep);
                preg_match('/\$profile_photo\s*=\s*[\'"]([^\'"]*)[\'"];/', $content, $m_photo);
                
                $files_data[] = [
                    'filename' => basename($file),
                    'faculty_id' => $m_id[1] ?? '',
                    'salutation' => $m_sal[1] ?? '',
                    'designation' => $m_des[1] ?? '',
                    'department' => $m_dep[1] ?? '',
                    'profile_photo' => $m_photo[1] ?? ''
                ];
            }
        }
    }
    header('Content-Type: application/json');
    echo json_encode($files_data);
    exit;
}

// AJAX Handler to delete a file
if (isset($_POST['action']) && $_POST['action'] === 'delete_file') {
    $school = $_POST['school'] ?? '';
    $dept = $_POST['dept'] ?? '';
    $filename = $_POST['filename'] ?? '';
    
    if ($school && $dept && $filename && strpos($filename, '..') === false) {
        $base_dir = '/home/sjubedu/public_html/';
        if (!is_dir($base_dir)) {
            $base_dir = realpath(__DIR__ . '/../') . '/';
        }
        $target_file = rtrim($base_dir, '/') . '/' . $school . '/' . $dept . '/' . basename($filename);
        
        if (is_file($target_file)) {
            if (unlink($target_file)) {
                echo json_encode(['success' => true]);
                exit;
            } else {
                echo json_encode(['success' => false, 'error' => 'Permission denied. Could not delete.']);
                exit;
            }
        } else {
            echo json_encode(['success' => false, 'error' => 'File not found.']);
            exit;
        }
    }
    echo json_encode(['success' => false, 'error' => 'Invalid parameters.']);
    exit;
}

$message = '';

$schools = [
    'school-of-chemical-sciences' => 'School of Chemical Sciences',
    'school-of-life-sciences' => 'School of Life Sciences',
    'school-of-physical-sciences' => 'School of Physical Sciences',
    'school-of-social-sciences' => 'School of Social Sciences',
    'school-of-humanities' => 'School of Humanities',
    'school-of-languages' => 'School of Languages',
    'school-of-commerce' => 'School of Commerce',
    'school-of-business' => 'School of Business',
    'school-of-information-technology' => 'School of Information Technology'
];

$departments = [
    'school-of-chemical-sciences' => [
        'department-of-biochemistry' => 'Biochemistry',
        'department-of-chemistry' => 'Chemistry'
    ],
    'school-of-life-sciences' => [
        'department-of-biotechnology' => 'Biotechnology',
        'department-of-botany' => 'Botany',
        'department-of-environmental-science' => 'Environmental Science',
        'department-of-microbiology' => 'Microbiology',
        'department-of-zoology' => 'Zoology'
    ],
    'school-of-physical-sciences' => [
        'department-of-physics' => 'Physics',
        'department-of-mathematics' => 'Mathematics',
        'department-of-statistics' => 'Statistics',
        'department-of-electronics' => 'Electronics',
        'department-of-computer-science' => 'Computer Science'
    ],
    'school-of-social-sciences' => [
        'department-of-economics' => 'Economics',
        'department-of-history' => 'History',
        'department-of-political-science' => 'Political Science',
        'department-of-sociology' => 'Sociology',
        'department-of-psychology' => 'Psychology',
        'department-of-social-work' => 'Social Work'
    ],
    'school-of-humanities' => [
        'department-of-english' => 'English',
        'department-of-journalism-and-mass-communication' => 'Journalism & Mass Communication',
        'department-of-visual-communication' => 'Visual Communication'
    ],
    'school-of-languages' => [
        'department-of-kannada' => 'Kannada',
        'department-of-hindi' => 'Hindi',
        'department-of-french' => 'French'
    ],
    'school-of-commerce' => [
        'department-of-commerce' => 'Commerce'
    ],
    'school-of-business' => [
        'department-of-management' => 'Management'
    ],
    'school-of-information-technology' => [
        'department-of-computer-science' => 'Computer Science'
    ]
];

$selected_school = '';
$selected_dept = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $selected_school = $school_folder = $_POST['school_folder'] ?? '';
    $selected_dept = $dept_folder = $_POST['dept_folder'] ?? '';
    $faculty_id = trim($_POST['faculty_id'] ?? '');
    $salutation = trim($_POST['salutation'] ?? '');
    $profile_photo = trim($_POST['profile_photo'] ?? '');
    $designation = trim($_POST['designation'] ?? '');
    $department_display = trim($_POST['department'] ?? '');

    if ($school_folder && $dept_folder && $faculty_id && $salutation && $designation && $department_display) {
        $encoded_id = base64_url_encode($faculty_id);
        $filename = $encoded_id . '.php';
        
        $base_dir = '/home/sjubedu/public_html/'; 
        if (!is_dir($base_dir)) {
             $base_dir = realpath(__DIR__ . '/../') . '/';
        }
        
        $target_dir = rtrim($base_dir, '/') . '/' . $school_folder . '/' . $dept_folder;
        
        // Ensure directories exist
        if (!is_dir($target_dir)) {
            if (!mkdir($target_dir, 0775, true)) {
                $err = error_get_last();
                $message = "<div class='alert alert-danger'>Failed to create directory structure: " . htmlspecialchars($school_folder . '/' . $dept_folder) . "<br>Error: " . htmlspecialchars($err['message'] ?? 'Unknown error') . "</div>";
            }
        }
        
        if (is_dir($target_dir)) {
            $file_path = $target_dir . '/' . $filename;
            
            $content = "<?php\n";
            $content .= "\$FACULTY_ID = \"" . addslashes($faculty_id) . "\";\n";
            $content .= "\$salutation = \"" . addslashes($salutation) . "\";\n";
            $content .= "\$profile_photo = \"" . addslashes($profile_photo) . "\";\n";
            $content .= "\$designation = \"" . addslashes($designation) . "\";\n";
            $content .= "\$department = \"" . addslashes($department_display) . "\";\n";
            $content .= "// Calls the Master Template (which has the HTML)\n";
            $content .= "require_once __DIR__ . '/../../Test/i_db.php';\n";
            $content .= "?>";
            
            $write_result = @file_put_contents($file_path, $content);
            if ($write_result !== false) {
                @chmod($file_path, 0644);
                $message = "<div class='alert alert-success'>Successfully created/updated profile: <strong>" . htmlspecialchars($filename) . "</strong> in <code>" . htmlspecialchars($school_folder . '/' . $dept_folder) . "</code><br><br>File Path: " . htmlspecialchars($file_path) . " <br><a href='/" . rawurlencode($school_folder) . "/" . rawurlencode($dept_folder) . "/" . $filename . "' target='_blank' class='btn btn-sm btn-success mt-2'><i class='fa fa-external-link-alt'></i> View Profile</a></div>";
            } else {
                $err = error_get_last();
                $message = "<div class='alert alert-danger'>Failed to write file. Check directory permissions.<br>Error: " . htmlspecialchars($err['message'] ?? 'Unknown error') . "</div>";
            }
        }
    } else {
        $message = "<div class='alert alert-warning'>Please fill in all required fields.</div>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include $_SERVER['DOCUMENT_ROOT'] . '/gtm.php'; ?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Individual Faculty Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script>
        const departmentsData = <?php echo json_encode($departments); ?>;
        
        function updateDepartments() {
            const schoolSelect = document.getElementById('school_folder');
            const deptSelect = document.getElementById('dept_folder');
            const selectedSchool = schoolSelect.value;
            
            deptSelect.innerHTML = '<option value="">Select Department Folder</option>';
            
            if (selectedSchool && departmentsData[selectedSchool]) {
                const depts = departmentsData[selectedSchool];
                for (const [folder, name] of Object.entries(depts)) {
                    const option = document.createElement('option');
                    option.value = folder;
                    option.dataset.name = name;
                    option.textContent = name + ' (' + folder + ')';
                    deptSelect.appendChild(option);
                }
            }
            
            loadExistingFiles();
        }
        
        function updateDisplayDept() {
            const deptSelect = document.getElementById('dept_folder');
            const deptDisplayInput = document.getElementById('department');
            if (deptSelect.selectedIndex > 0) {
                const name = deptSelect.options[deptSelect.selectedIndex].dataset.name;
                deptDisplayInput.value = name.toUpperCase();
            } else {
                deptDisplayInput.value = '';
            }
            
            loadExistingFiles();
        }
        
        function loadExistingFiles() {
            const schoolSelect = document.getElementById('school_folder').value;
            const deptSelect = document.getElementById('dept_folder').value;
            
            const tableBody = document.getElementById('existing-faculty-body');
            if (!tableBody) return;
            tableBody.innerHTML = '<tr><td colspan="6" class="text-center py-4">Loading <i class="fa fa-spinner fa-spin ms-2"></i></td></tr>';
            
            if (schoolSelect && deptSelect) {
                fetch(`create_faculty.php?action=list_files&school=${schoolSelect}&dept=${deptSelect}`)
                    .then(response => response.json())
                    .then(data => {
                        tableBody.innerHTML = '';
                        if (data.length === 0) {
                            tableBody.innerHTML = '<tr><td colspan="6" class="text-center text-muted py-4">No faculty profiles found in this department.</td></tr>';
                            return;
                        }
                        data.forEach(item => {
                            const tr = document.createElement('tr');
                            
                            const tdId = document.createElement('td'); tdId.textContent = item.faculty_id;
                            const tdSal = document.createElement('td'); tdSal.textContent = item.salutation;
                            const tdDes = document.createElement('td'); tdDes.textContent = item.designation;
                            const tdDep = document.createElement('td'); tdDep.textContent = item.department;
                            
                            const tdPhoto = document.createElement('td');
                            if (item.profile_photo) {
                                const img = document.createElement('img');
                                img.src = item.profile_photo;
                                img.width = 40; img.height = 40;
                                img.className = 'rounded shadow-sm';
                                img.style.objectFit = 'cover';
                                img.onerror = () => img.style.display = 'none';
                                tdPhoto.appendChild(img);
                            } else {
                                tdPhoto.innerHTML = '<span class="text-muted small">None</span>';
                            }
                            
                            const tdAction = document.createElement('td');
                            const btnEdit = document.createElement('button');
                            btnEdit.type = 'button';
                            btnEdit.className = 'btn btn-sm btn-outline-primary text-nowrap me-2';
                            btnEdit.innerHTML = '<i class="fa fa-edit"></i> Edit';
                            btnEdit.onclick = () => editFaculty(item.faculty_id, item.salutation, item.designation, item.department, item.profile_photo);
                            
                            const btnPreview = document.createElement('a');
                            btnPreview.href = `/${encodeURIComponent(schoolSelect)}/${encodeURIComponent(deptSelect)}/${item.filename}`;
                            btnPreview.target = '_blank';
                            btnPreview.className = 'btn btn-sm btn-outline-success text-nowrap';
                            btnPreview.innerHTML = '<i class="fa fa-external-link-alt"></i> Preview';
                            
                            const btnDelete = document.createElement('button');
                            btnDelete.type = 'button';
                            btnDelete.className = 'btn btn-sm btn-outline-danger text-nowrap ms-2';
                            btnDelete.innerHTML = '<i class="fa fa-trash"></i> Delete';
                            btnDelete.onclick = () => deleteFaculty(schoolSelect, deptSelect, item.filename);
                            
                            tdAction.appendChild(btnEdit);
                            tdAction.appendChild(btnPreview);
                            tdAction.appendChild(btnDelete);
                            
                            tr.append(tdId, tdSal, tdDes, tdDep, tdPhoto, tdAction);
                            tableBody.appendChild(tr);
                        });
                    })
                    .catch(error => {
                        tableBody.innerHTML = `<tr><td colspan="6" class="text-center text-danger py-4">Error loading files: ${error}</td></tr>`;
                    });
            } else {
                tableBody.innerHTML = '<tr><td colspan="6" class="text-center text-muted py-4"><i class="fa fa-folder-open mb-2 d-block fs-3 opacity-50"></i> Select a school and department to view existing profiles.</td></tr>';
            }
        }
        
        function editFaculty(id, salutation, designation, department, photo) {
            document.querySelector('input[name="faculty_id"]').value = id;
            document.querySelector('input[name="salutation"]').value = salutation;
            document.querySelector('input[name="designation"]').value = designation;
            document.querySelector('input[name="department"]').value = department;
            document.querySelector('input[name="profile_photo"]').value = photo;
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }

        function deleteFaculty(school, dept, filename) {
            if (confirm(`Are you sure you want to permanently delete ${filename}? This action cannot be undone.`)) {
                const formData = new FormData();
                formData.append('action', 'delete_file');
                formData.append('school', school);
                formData.append('dept', dept);
                formData.append('filename', filename);
                
                fetch('create_faculty.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        loadExistingFiles();
                    } else {
                        alert(data.error || 'Failed to delete file.');
                    }
                })
                .catch(error => alert('Error deleting file: ' + error));
            }
        }

        window.onload = function() {
            const preSelectedSchool = "<?php echo htmlspecialchars($selected_school); ?>";
            const preSelectedDept = "<?php echo htmlspecialchars($selected_dept); ?>";
            if (preSelectedSchool) {
                updateDepartments();
                if (preSelectedDept) {
                    document.getElementById('dept_folder').value = preSelectedDept;
                }
                loadExistingFiles();
            }
        }
    </script>
</head>
<body class="bg-light p-4">
    <div class="container max-w-1200" style="max-width: 800px;">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2><i class="fa fa-user-plus text-primary"></i> Add Faculty Profile</h2>
            <a href="dashboard.php" class="btn btn-secondary">Back to Dashboard</a>
        </div>
        
        <?php echo $message; ?>
        
        <div class="card shadow-sm">
            <div class="card-header bg-white fw-bold">
                <i class="fa fa-file-code me-2"></i> File Configuration
            </div>
            <div class="card-body p-4">
                <form method="POST">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold">School Folder <span class="text-danger">*</span></label>
                            <select name="school_folder" id="school_folder" class="form-select" required onchange="updateDepartments()">
                                <option value="">Select School Folder</option>
                                <?php foreach ($schools as $folder => $name): ?>
                                    <option value="<?php echo htmlspecialchars($folder); ?>" <?php echo $selected_school === $folder ? 'selected' : ''; ?>><?php echo htmlspecialchars($name); ?> (<?php echo htmlspecialchars($folder); ?>)</option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Department Folder <span class="text-danger">*</span></label>
                            <select name="dept_folder" id="dept_folder" class="form-select" required onchange="updateDisplayDept()">
                                <option value="">Select Department Folder</option>
                            </select>
                        </div>
                        
                        <div class="col-md-4">
                            <label class="form-label fw-bold">Faculty ID <span class="text-danger">*</span></label>
                            <input type="text" name="faculty_id" class="form-control" placeholder="e.g., 1457" required>
                            <div class="form-text text-muted">Ex: 1457 -> MTQ1Nw.php</div>
                        </div>
                        
                        <div class="col-md-4">
                            <label class="form-label fw-bold">Salutation <span class="text-danger">*</span></label>
                            <input type="text" name="salutation" class="form-control" placeholder="e.g., Dr" value="Dr" required>
                        </div>
                        
                        <div class="col-md-4">
                            <label class="form-label fw-bold">Designation <span class="text-danger">*</span></label>
                            <input type="text" name="designation" class="form-control" placeholder="e.g., ASSISTANT PROFESSOR" required>
                        </div>
                        
                        <div class="col-md-12">
                            <label class="form-label fw-bold">Department Display Name <span class="text-danger">*</span></label>
                            <input type="text" name="department" id="department" class="form-control" placeholder="e.g., BIOCHEMISTRY" required>
                        </div>
                        
                        <div class="col-md-12">
                            <label class="form-label fw-bold">Profile Photo URL</label>
                            <input type="url" name="profile_photo" class="form-control" placeholder="https://sjub.s3.ap-south-1.amazonaws.com/...">
                            <div class="form-text">Leave blank to use default placeholder if no image exists yet.</div>
                        </div>
                        
                        <div class="col-12 mt-4">
                            <button type="submit" class="btn btn-primary btn-lg w-100"><i class="fa fa-magic"></i> Generate Faculty Profile File</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        
        <div class="card shadow-sm mt-4">
            <div class="card-header bg-white fw-bold">
                <i class="fa fa-users me-2"></i> Existing Faculty in Selected Department
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover table-striped mb-0 align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Faculty ID</th>
                                <th>Salutation</th>
                                <th>Designation</th>
                                <th>Department Display</th>
                                <th>Photo</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="existing-faculty-body">
                            <tr><td colspan="6" class="text-center text-muted py-4"><i class="fa fa-folder-open mb-2 d-block fs-3 opacity-50"></i> Select a school and department to view existing profiles.</td></tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
