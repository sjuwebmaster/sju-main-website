<?php
/**
 * Bulk Profile Creator
 * Run this script once to generate individual PHP files for each faculty member.
 */
$config = file_exists('/home/sjubedu/config.php') ? '/home/sjubedu/config.php' : __DIR__ . '/../../config.php';
require_once $config;

function base64_url_encode($data) {
    return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
}

function base64_url_decode($data) {
    return base64_decode(strtr($data, '-_', '+/'));
}

// 1. MAP YOUR FACULTY IDs TO DETAILS HERE
$faculty_map = [
    "548" => [
        "image" => "https://sjub.s3.ap-south-1.amazonaws.com/Life+Science/Microbiology/Dr_Beatrice_Maria_Sequeira.webp",
        "designation" => "Associate Professor",
        "department" => "MICROBIOLOGY",
        "salutation" => "Dr"
    ],
    "310" => [
        "image" => "https://sjub.s3.ap-south-1.amazonaws.com/Life+Science/Microbiology/Dr_Vanitha_N_M.webp",
        "designation" => "Associate Professor",
        "department" => "MICROBIOLOGY",
        "salutation" => "Dr"
    ],
    "18" => [
        "image" => "https://sjub.s3.ap-south-1.amazonaws.com/Life+Science/Microbiology/Dr-Syed-Wajeed.webp",
        "designation" => "Associate Professor - REGISTRAR",
        "department" => "MICROBIOLOGY",
        "salutation" => "Dr"
    ],
    "49" => [
        "image" => "https://sjub.s3.ap-south-1.amazonaws.com/Life+Science/Microbiology/Dr_W_Jothy.webp",
        "designation" => "Associate Professor - NAAC Coordinator",
        "department" => "NATURAL SCIENCE",
        "salutation" => "Dr"
    ],
    "97" => [
        "image" => "https://sjub.s3.ap-south-1.amazonaws.com/Life+Science/Microbiology/Dr_Mamatha_S.webp",
        "designation" => "Assistant Professor - PG Coordinator",
        "department" => "MICROBIOLOGY",
        "salutation" => "Dr"
    ],
    "35" => [
        "image" => "https://sjub.s3.ap-south-1.amazonaws.com/Life+Science/Microbiology/Dr_Popy_Dutta.webp",
        "designation" => "Assistant Professor - Associate Dean and HOD",
        "department" => "MICROBIOLOGY",
        "salutation" => "Dr"
    ],
    "1235" => [
        "image" => "https://sjub.s3.ap-south-1.amazonaws.com/Life+Science/Microbiology/Dr_Debalina_Chaudhuri.webp",
        "designation" => "ASSISTANT PROFESSOR",
        "department" => "MICROBIOLOGY",
        "salutation" => "Dr"
    ],
    "1408" => [
        "image" => "https://sjub.s3.ap-south-1.amazonaws.com/Life+Science/Microbiology/Dr_Mohanraj_Gunasekaran.webp",
        "designation" => "Assistant Professor",
        "department" => "MICROBIOLOGY",
        "salutation" => "Dr"
    ],
    "1658" => [
        "image" => "https://sjub.s3.ap-south-1.amazonaws.com/Life+Science/Microbiology/DR_GEETA_D.webp",
        "designation" => "ASSISTANT PROFESSOR",
        "department" => "MICROBIOLOGY",
        "salutation" => "DR"
    ],
        "82" => [
        "image" => "https://sjub.s3.ap-south-1.amazonaws.com/Life+Science/Microbiology/Ms_Shalmali_Kamath_Prabhu.webp",
        "designation" => "ASSISTANT PROFESSOR",
        "department" => "MICROBIOLOGY",
        "salutation" => "Ms"
    ],
];


session_start();

// If forcing a refresh, clear the cached map
if (isset($_POST['export_map'])) {
    if (isset($_SESSION['faculty_map_with_names'])) {
        unset($_SESSION['faculty_map_with_names']);
    }
}

// Handle Clear Cache
if (isset($_POST['clear_cache'])) {
    if (isset($_SESSION['faculty_map_with_names'])) {
        unset($_SESSION['faculty_map_with_names']);
    }
    $alert_msg = "Cache cleared successfully.";
    $alert_type = "success";
}

// Caching mechanism for faculty names
// Caching mechanism for faculty names.
// The faculty map with names is stored in the session to avoid slow page loads
// due to repeated API calls. The cache is cleared when the "Sync Names & Export Map"
// button is clicked, which allows for a manual refresh of the data.
if (isset($_SESSION['faculty_map_with_names'])) {
    $cached_map = $_SESSION['faculty_map_with_names'];
    foreach ($faculty_map as $id => &$details) {
        if (isset($cached_map[$id]['name'])) {
            $details['name'] = $cached_map[$id]['name'];
        }
    }
    unset($details);
} else {
    set_time_limit(0); // Allow long execution for API calls
    foreach ($faculty_map as $id => &$details) {
        $id = trim($id);
        if (empty($id)) continue;

        // Fetch from API
        $staff_url = "https://sjuv4.linways.com/api/v1/staffs/" . urlencode($id);
        $staff_ch = curl_init();
        curl_setopt($staff_ch, CURLOPT_URL, $staff_url);
        curl_setopt($staff_ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($staff_ch, CURLOPT_HTTPHEADER, ["Authorization: $API_TOKEN", "Accept: application/json"]);
        curl_setopt($staff_ch, CURLOPT_SSL_VERIFYPEER, false);
        $staff_response = curl_exec($staff_ch);
        $staff_data = json_decode($staff_response, true);
        curl_close($staff_ch);

        if (!empty($staff_data['name'])) {
            $details['name'] = $staff_data['name'];
        }
    }
    unset($details); // Unset reference

    $_SESSION['faculty_map_with_names'] = $faculty_map;
}
 // .. add the rest here ...


$alert_msg = '';
$alert_type = '';
$decode_result = '';

// Handle Rename
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['rename_file'])) {
    $old_name = basename($_POST['old_name']);
    $new_name_raw = basename($_POST['new_name']);

    // Ensure new name has .php extension
    if (substr($new_name_raw, -4) !== '.php') {
        $new_name_raw .= '.php';
    }
    
    // Sanitize new name
    $new_name = preg_replace('/[^a-zA-Z0-9_.-]/', '_', $new_name_raw);

    if (file_exists($old_name) && !empty($new_name) && $new_name !== '.php') {
        if (rename($old_name, $new_name)) {
            $alert_msg = "Renamed '$old_name' to '$new_name'.";
            $alert_type = "success";
        } else {
            $alert_msg = "Error renaming file.";
            $alert_type = "danger";
        }
    } else {
        $alert_msg = "Error: Old file not found or new name is invalid.";
        $alert_type = "danger";
    }
}

// Handle Individual Deletion
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_file'])) {
    $file_to_delete = basename($_POST['delete_file']);
    if (file_exists($file_to_delete)) {
        unlink($file_to_delete);
        $alert_msg = "Deleted $file_to_delete";
        $alert_type = "success";
    }
}

// Handle Bulk Deletion
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_selected']) && !empty($_POST['selected_files'])) {
    $del_count = 0;
    foreach ($_POST['selected_files'] as $file) {
        $file = basename($file);
        if (file_exists($file)) {
            unlink($file);
            $del_count++;
        }
    }
    $alert_msg = "Deleted $del_count profiles.";
    $alert_type = "success";
}

// Handle Map Export (Sync Names)
$export_output = '';
if (isset($_POST['export_map'])) {
    set_time_limit(0); // Allow long execution for API calls
    $export_output = "\$faculty_map = [\n";
    
    foreach ($faculty_map as $id => $details) {
        $id = trim($id);
        if (empty($id)) continue;

        $current_name = $details['name'] ?? '';
        $api_name = '';

        // Always fetch from API to ensure correctness
        $staff_url = "https://sjuv4.linways.com/api/v1/staffs/" . urlencode($id);
        $staff_ch = curl_init();
        curl_setopt($staff_ch, CURLOPT_URL, $staff_url);
        curl_setopt($staff_ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($staff_ch, CURLOPT_HTTPHEADER, ["Authorization: $API_TOKEN", "Accept: application/json"]);
        curl_setopt($staff_ch, CURLOPT_SSL_VERIFYPEER, false);
        $staff_response = curl_exec($staff_ch);
        $staff_data = json_decode($staff_response, true);
        curl_close($staff_ch);

        if (!empty($staff_data['name'])) {
            $api_name = $staff_data['name'];
        }

        // Use API name if available, otherwise fallback to current
        $final_name = !empty($api_name) ? $api_name : $current_name;
        
        $export_output .= "    \"$id\" => [\n";
        $export_output .= "        \"salutation\" => \"" . addslashes($details['salutation'] ?? '') . "\",\n";
        $export_output .= "        \"name\" => \"" . addslashes($final_name) . "\",\n";
        $export_output .= "        \"image\" => \"" . addslashes($details['image'] ?? '') . "\",\n";
        $export_output .= "        \"designation\" => \"" . addslashes($details['designation'] ?? '') . "\",\n";
        $export_output .= "        \"department\" => \"" . addslashes($details['department'] ?? '') . "\"\n";
        $export_output .= "    ],\n";
    }
    $export_output .= "];";
}

// Handle Generation (Process all items)
if (isset($_POST['generate_all'])) {
    $gen_count = 0;
    foreach ($faculty_map as $id => $details) {
        $id = trim($id);
        if (empty($id)) continue;
        
        $photo_url = $details['image'] ?? '';
        $designation = $details['designation'] ?? '';
        $department = $details['department'] ?? '';
        $salutation = $details['salutation'] ?? '';
        
        $filename = base64_url_encode($id) . ".php";

        $content = "<?php\n\$FACULTY_ID = \"$id\";\n\$salutation = \"$salutation\";\n\$profile_photo = \"$photo_url\";\n\$designation = \"$designation\";\n\$department = \"$department\";\nrequire_once '/home/sjubedu/public_html/Test/i_db.php';\n?>";
        
        file_put_contents($filename, $content);
        $gen_count++;
    }
    $alert_msg = "Successfully generated/updated $gen_count profiles.";
    $alert_type = "success";
}

// Handle Excel Export
if (isset($_POST['export_excel'])) {
    $filename = "faculty_list_" . date('Y-m-d') . ".csv";
    
    // Clean output buffer to prevent file corruption
    if (ob_get_level()) ob_end_clean();
    
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename="' . $filename . '"');
    
    $output = fopen('php://output', 'w');
    
    // Add BOM for Excel to recognize UTF-8 characters correctly
    fputs($output, "\xEF\xBB\xBF");
    
    // Headers
    fputcsv($output, ['ID', 'Name', 'Designation', 'Department', 'Email', 'Image URL', 'Generated Filename']);
    
    foreach ($faculty_map as $id => $details) {
        $gen_file = base64_url_encode($id) . ".php";
        fputcsv($output, [
            $id,
            $details['name'] ?? '',
            $details['designation'] ?? '',
            $details['department'] ?? '',
            $details['email'] ?? '',
            $details['image'] ?? '',
            $gen_file
        ]);
    }
    
    fclose($output);
    exit;
}

// Handle Decode
if (isset($_POST['decode_submit'])) {
    $encoded_str = trim($_POST['encoded_string']);
    $clean_str = str_replace('.php', '', $encoded_str);
    $decoded_id = base64_url_decode($clean_str);
    
    if ($decoded_id) {
        $name_info = '';
        if (isset($faculty_map[$decoded_id]['name'])) {
            $name_info = " (" . $faculty_map[$decoded_id]['name'] . ")";
        } else {
            // Fetch from API if not in local map
            $staff_url = "https://sjuv4.linways.com/api/v1/staffs/" . urlencode($decoded_id);
            $staff_ch = curl_init();
            curl_setopt($staff_ch, CURLOPT_URL, $staff_url);
            curl_setopt($staff_ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($staff_ch, CURLOPT_HTTPHEADER, ["Authorization: $API_TOKEN", "Accept: application/json"]);
            curl_setopt($staff_ch, CURLOPT_SSL_VERIFYPEER, false);
            $staff_response = curl_exec($staff_ch);
            $staff_data = json_decode($staff_response, true);
            curl_close($staff_ch);

            if (!empty($staff_data['name'])) {
                $name_info = " (" . $staff_data['name'] . ")";
            } else {
                $name_info = " (Name not found in API)";
            }
        }
        $decode_result = "Decoded: <strong>" . htmlspecialchars($clean_str) . "</strong> &rarr; ID: <strong>" . htmlspecialchars($decoded_id) . "</strong>" . htmlspecialchars($name_info);
    } else {
        $decode_result = "Could not decode string: " . htmlspecialchars($encoded_str);
    }
}



?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include $_SERVER['DOCUMENT_ROOT'] . '/gtm.php'; ?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Generator</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light p-5">
    <div class="container">
        <h2 class="mb-4">Profile Manager</h2>
        
        <?php if ($alert_msg): ?>
            <div class="alert alert-<?php echo $alert_type; ?> mb-4"><?php echo htmlspecialchars($alert_msg); ?></div>
        <?php endif; ?>

        <?php if ($decode_result): ?>
            <div class="alert alert-info mb-4"><?php echo $decode_result; ?></div>
        <?php endif; ?>

        <?php if ($export_output): ?>
            <div class="mb-4">
                <label class="form-label fw-bold">Updated Map Code (Copy & Replace in file):</label>
                <textarea class="form-control" rows="10" onclick="this.select()"><?php echo htmlspecialchars($export_output); ?></textarea>
            </div>
        <?php endif; ?>

        <form method="post" class="mb-4">
            <div class="d-flex gap-2">
                <button type="submit" name="generate_all" class="btn btn-success">Generate / Update All Profiles</button>
                <button type="submit" name="export_map" class="btn btn-warning text-dark" onclick="return confirm('This will fetch names from the API for ALL profiles. It may take a few minutes. Continue?')">Sync Names & Export Map</button>
                <button type="submit" name="export_excel" class="btn btn-info text-white">Export to Excel</button>
                <button type="submit" name="clear_cache" class="btn btn-danger" onclick="return confirm('Are you sure you want to clear the cache? This will force a refresh of all faculty data from the API.')">Clear Cache</button>
                <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#decodeModal">Decode Filename</button>
            </div>
        </form>

                <?php
                $search = isset($_GET['search']) ? trim($_GET['search']) : '';
                $filter_status = isset($_GET['filter']) ? $_GET['filter'] : 'all';
                ?>

                        <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">



                            <form method="get" class="flex-grow-1">



                                <div class="input-group">



                                    <input type="text" name="search" class="form-control" placeholder="Search by ID, Name, Designation, or Department..." value="<?php echo htmlspecialchars($search); ?>">



                                    <input type="hidden" name="filter" value="<?php echo htmlspecialchars($filter_status); ?>">



                                    <button class="btn btn-outline-secondary" type="submit">Search</button>
                                    <?php if ($search !== ''): ?>
                                        <a href="?" class="btn btn-outline-danger">Clear Search</a>
                                    <?php endif; ?>



                                </div>



                            </form>



                            <div class="btn-group" role="group">



                                <a href="?search=<?php echo urlencode($search); ?>" class="btn <?php echo ($filter_status !== 'missing') ? 'btn-primary' : 'btn-outline-primary'; ?>">All</a>



                                <a href="?filter=missing&search=<?php echo urlencode($search); ?>" class="btn <?php echo ($filter_status === 'missing') ? 'btn-primary' : 'btn-outline-primary'; ?>">Missing</a>



                            </div>



                        </div>



                



                        <form method="post" id="bulkForm">



                        <div class="d-flex justify-content-between align-items-center mb-3 p-2 bg-white border rounded">



                            <div class="form-check ms-2">



                                <input type="checkbox" id="selectAll" class="form-check-input">



                                <label for="selectAll" class="form-check-label fw-bold">Select All</label>



                            </div>



                            <button type="submit" name="delete_selected" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete the selected profiles?')">Delete Selected</button>



                        </div>



                



                        <div class="list-group" id="profileList">



                <?php


                $page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;



                $limit = 500; // Items per page



                



                // Filter items based on search
                $filtered_items = array_filter($faculty_map, function($details, $id) use ($search) {
                    if (empty($search)) return true;
                    $search_lower = strtolower($search);
                    $id_lower = strtolower((string)$id);
                    $name_lower = strtolower($details['name'] ?? '');
                    $designation_lower = strtolower($details['designation'] ?? '');
                    $department_lower = strtolower($details['department'] ?? '');
                    $email_lower = strtolower($details['email'] ?? '');
                    
                    // Also search by filename
                    $filename = base64_url_encode((string)$id) . ".php";
                    $filename_lower = strtolower($filename);

                    return strpos($id_lower, $search_lower) !== false || 
                           strpos($name_lower, $search_lower) !== false ||
                           strpos($designation_lower, $search_lower) !== false ||
                           strpos($department_lower, $search_lower) !== false ||
                           strpos($email_lower, $search_lower) !== false ||
                           strpos($filename_lower, $search_lower) !== false;
                }, ARRAY_FILTER_USE_BOTH);



                



                // Filter by status (missing)



                if ($filter_status === 'missing') {



                    $filtered_items = array_filter($filtered_items, function($details, $id) {



                        $filename = base64_url_encode($id) . ".php";



                        return !file_exists($filename);



                    }, ARRAY_FILTER_USE_BOTH);



                }



                



                $total_items = count($filtered_items);



                $total_pages = ceil($total_items / $limit);



                $offset = ($page - 1) * $limit;



                $display_items = array_slice($filtered_items, $offset, $limit, true);



                



                foreach ($display_items as $id => $details) {



                    $id = trim($id);



                    if (empty($id)) continue;



                



                    $name = $details['name'] ?? '';



                    $photo_url = $details['image'] ?? '';



                    $designation = $details['designation'] ?? '';



                    $department = $details['department'] ?? '';



                



                    $filename = base64_url_encode($id) . ".php";



                    



                    if (file_exists($filename)) {



                        echo "<div class='list-group-item d-flex justify-content-between align-items-center profile-item'>



                                <div class='d-flex align-items-center'>



                                    <input type='checkbox' name='selected_files[]' value='$filename' class='form-check-input me-3 select-item'>



                                    <span>Created: <strong>$filename</strong>" . ($name ? " - <span class='text-muted'>$name</span>" : "") . "</span>



                                </div>



                                <div>



                                    <a href='$filename' target='_blank' class='btn btn-sm btn-primary me-2'>View</a>



                                    <button type='button' class='btn btn-sm btn-secondary me-2 rename-btn' data-filename='$filename'>Rename</button>



                                    <button type='submit' name='delete_file' value='$filename' class='btn btn-sm btn-danger' onclick='return confirm(\"Are you sure?\")'>Delete</button>



                                </div>



                              </div>";



                    } else {



                        echo "<div class='list-group-item list-group-item-warning profile-item'>Missing: <strong>$filename</strong>" . ($name ? " - <span class='text-muted'>$name</span>" : "") . "</div>";



                    }



                }



                ?>



                        </div>



                        </form>



                



                        <!-- Pagination Controls -->



                        <?php if ($total_pages > 1): ?>



                        <nav aria-label="Page navigation" class="mt-4">



                            <ul class="pagination justify-content-center">



                                <li class="page-item <?php echo ($page <= 1) ? 'disabled' : ''; ?>">



                                    <a class="page-link" href="?page=<?php echo $page - 1; ?>&search=<?php echo urlencode($search); ?>&filter=<?php echo urlencode($filter_status); ?>">Previous</a>



                                </li>



                                <?php for ($i = 1; $i <= $total_pages; $i++): ?>



                                    <li class="page-item <?php echo ($page == $i) ? 'active' : ''; ?>">



                                        <a class="page-link" href="?page=<?php echo $i; ?>&search=<?php echo urlencode($search); ?>&filter=<?php echo urlencode($filter_status); ?>"><?php echo $i; ?></a>



                                    </li>



                                <?php endfor; ?>



                                <li class="page-item <?php echo ($page >= $total_pages) ? 'disabled' : ''; ?>">



                                    <a class="page-link" href="?page=<?php echo $page + 1; ?>&search=<?php echo urlencode($search); ?>&filter=<?php echo urlencode($filter_status); ?>">Next</a>



                                </li>



                            </ul>



                        </nav>



                        <?php endif; ?>



                



                        <div class="mt-3 alert alert-info">



                            <strong>Showing <?php echo count($display_items); ?> of <?php echo $total_items; ?> profiles</strong>



                        </div>
        



    </div>

    <!-- Rename Modal -->
    <div class="modal fade" id="renameModal" tabindex="-1" aria-labelledby="renameModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="renameModalLabel">Rename Profile</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <form method="post">
            <div class="modal-body">
              <p>Renaming file: <strong id="oldFilenameLabel"></strong></p>
              <input type="hidden" name="old_name" id="oldFilenameInput">
              <div class="mb-3">
                <label for="newFilenameInput" class="form-label">New Filename (without .php)</label>
                <input type="text" name="new_name" id="newFilenameInput" class="form-control" required>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              <button type="submit" name="rename_file" class="btn btn-primary">Save changes</button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <!-- Decode Modal -->
    <div class="modal fade" id="decodeModal" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Decode Filename</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <form method="post">
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">Paste Filename (e.g., MTkz.php or MTkz)</label>
                    <input type="text" name="encoded_string" class="form-control" required placeholder="Paste here...">
                </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              <button type="submit" name="decode_submit" class="btn btn-primary">Decode</button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <button id="back-to-top" class="btn btn-primary">Back to Top</button>
    <script>
        // Back to Top button functionality
        const backToTopButton = document.getElementById('back-to-top');

        window.onscroll = function() {
            if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
                backToTopButton.style.display = 'block';
            } else {
                backToTopButton.style.display = 'none';
            }
        };

        backToTopButton.onclick = function() {
            document.body.scrollTop = 0;
            document.documentElement.scrollTop = 0;
        };
        
        document.getElementById('selectAll').addEventListener('change', function() {
            let checkboxes = document.querySelectorAll('.select-item');
            checkboxes.forEach(cb => cb.checked = this.checked);
        });

        const renameModal = new bootstrap.Modal(document.getElementById('renameModal'));
        document.querySelectorAll('.rename-btn').forEach(button => {
            button.addEventListener('click', function() {
                const filename = this.dataset.filename;
                document.getElementById('oldFilenameLabel').textContent = filename;
                document.getElementById('oldFilenameInput').value = filename;
                document.getElementById('newFilenameInput').value = filename.replace('.php', '');
                renameModal.show();
            });
        });
    </script>
    <style>
        #back-to-top {
            position: fixed;
            bottom: 20px;
            right: 20px;
            display: none;
        }
    </style>
</body>
</html>