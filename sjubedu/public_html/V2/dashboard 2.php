<?php
// Test/dashboard.php - Centralized Admin Dashboard
$speed_test_start_time = microtime(true); // START TIMER
session_start();
$config = file_exists('/home/sjubedu/config.php') ? '/home/sjubedu/config.php' : __DIR__ . '/../../config.php';
require_once $config;
$speed_test_config_time = microtime(true); // CONFIG LOADED

// --- 2. GLOBAL TRACKER INJECTION ---
// This is your Global Security & Tracker Bridge. 
// It must stay here to catch your iPhone's IPv6 address.
if (file_exists('/home/sjubedu/public_html/global_tracker.php')) {
    require_once('/home/sjubedu/public_html/global_tracker.php');
}

// --- CONFIGURATION ---
$purge_log = __DIR__ . '/purge_history.log';

// --- AUTHENTICATION ---
if (isset($_POST['login_pass'])) {
    if ($_POST['login_pass'] === $ADMIN_PASSWORD) {
        $_SESSION['is_admin'] = true;
    } else {
        $error_msg = "Incorrect Password";
    }
}

if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: dashboard.php");
    exit;
}

if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== true) {
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light d-flex align-items-center justify-content-center vh-100">
    <div class="card shadow p-4" style="width: 100%; max-width: 400px;">
        <h3 class="text-center mb-4">Admin Dashboard</h3>
        <?php if(isset($error_msg)) echo "<div class='alert alert-danger'>$error_msg</div>"; ?>
        <form method="POST">
            <div class="mb-3">
                <label class="form-label">Password</label>
                <input type="password" name="login_pass" class="form-control" required>
            </div>
            <button class="btn btn-primary w-100">Login</button>
        </form>
    </div>
</body>
</html>
<?php
    exit;
}

// --- DATABASE CONNECTION ---
try {
    $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4", DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $speed_test_conn_time = microtime(true); // DB CONNECTED

    // --- SPEED TEST LOGIC ---
    $stmt_speed = $pdo->query("SELECT id FROM api_cache LIMIT 1");
    $stmt_speed->fetch();
    $speed_test_fetch_time = microtime(true); // DB FETCHED

    $speed_test_results = [];
    $speed_test_results['total_time'] = round(($speed_test_fetch_time - $speed_test_start_time) * 1000, 2);
    $speed_test_results['config_load_time'] = round(($speed_test_config_time - $speed_test_start_time) * 1000, 2);
    $speed_test_results['db_conn_time'] = round(($speed_test_conn_time - $speed_test_config_time) * 1000, 2);
    $speed_test_results['db_query_time'] = round(($speed_test_fetch_time - $speed_test_conn_time) * 1000, 2);

    if ($speed_test_results['total_time'] < 50) {
        $speed_test_results['grade'] = 'Excellent';
        $speed_test_results['grade_class'] = 'text-success';
        $speed_test_results['grade_message'] = '🚀 Excellent: Your server is highly responsive.';
    } elseif ($speed_test_results['total_time'] < 200) {
        $speed_test_results['grade'] = 'Good';
        $speed_test_results['grade_class'] = 'text-warning';
        $speed_test_results['grade_message'] = '⚖️ Good: Standard performance for shared hosting.';
    } else {
        $speed_test_results['grade'] = 'Slow';
        $speed_test_results['grade_class'] = 'text-danger';
        $speed_test_results['grade_message'] = '⚠️ Slow: You may face lag with high traffic.';
    }
    // --- END SPEED TEST ---
    
    // --- PATH SECURITY CHECK ---
    $path_check_results = [];
    $path_target = file_exists('/home/sjubedu/config.php') ? '/home/sjubedu/config.php' : __DIR__ . '/../../config.php';
    $path_check_results['target'] = $path_target;

    if (file_exists($path_target)) {
        $path_check_results['exists'] = ['status' => true, 'message' => 'SUCCESS: The file exists.'];
        
        if (is_readable($path_target)) {
            $path_check_results['readable'] = ['status' => true, 'message' => 'SUCCESS: PHP has permission to read the file.'];
            
            // The file is already included at the top, so we can just check the constant
            if (defined('DB_HOST')) {
                $path_check_results['constant'] = ['status' => true, 'message' => 'SUCCESS: Constants from config.php were loaded! (Host: ' . DB_HOST . ')'];
            } else {
                $path_check_results['constant'] = ['status' => false, 'message' => 'ERROR: File loaded, but no constants were found. Check config.php syntax.'];
            }
        } else {
            $path_check_results['readable'] = ['status' => false, 'message' => 'ERROR: The file exists, but PHP is NOT allowed to read it (Check Permissions).'];
        }
    } else {
        $path_check_results['exists'] = ['status' => false, 'message' => 'ERROR: The file was not found at that location. Double-check the folder name.'];
    }

    // --- API STATUS CHECK (5s Timeout) ---
    $api_check = curl_init("https://sjuv4.linways.com/");
    curl_setopt_array($api_check, [CURLOPT_TIMEOUT=>5, CURLOPT_NOBODY=>true, CURLOPT_SSL_VERIFYPEER=>false]);
    curl_exec($api_check);
    $api_status = curl_getinfo($api_check, CURLINFO_HTTP_CODE);
    $api_latency = curl_getinfo($api_check, CURLINFO_TOTAL_TIME);
    curl_close($api_check);

    // --- LOG LATENCY ---
    $lat_file = __DIR__ . '/api_latency.json';
    $lat_data = file_exists($lat_file) ? json_decode(file_get_contents($lat_file), true) : [];
    if (!is_array($lat_data)) $lat_data = [];
    $lat_data[] = ['t' => time(), 'v' => $api_latency];
    if (count($lat_data) > 30) $lat_data = array_slice($lat_data, -30); // Keep last 30
    file_put_contents($lat_file, json_encode($lat_data));

    // --- MANUAL OVERRIDE: FORCE PURGE ---
    if (isset($_POST['manual_purge'])) {
        if ($api_status >= 200 && $api_status < 500) {
            $cutoff_time = date('Y-m-d H:i:s', strtotime('-6 hours'));
            
            // Delete expired records
            $stmt = $pdo->prepare("DELETE FROM api_cache WHERE created_at < ?");
            $stmt->execute([$cutoff_time]);
            $count = $stmt->rowCount();
            
            $log_msg = "[" . date('Y-m-d H:i:s') . "] MANUAL PURGE: Removed $count expired IDs.\n";
            file_put_contents($purge_log, $log_msg, FILE_APPEND);
            $success_msg = "Successfully purged $count expired records.";
        } else {
            $purge_error = "Purge Failed: API unreachable (Status: $api_status). Safety lock engaged.";
        }
    }

    // --- FORCE PURGE ANYWAY ---
    if (isset($_POST['force_purge_anyway'])) {
        $cutoff_time = date('Y-m-d H:i:s', strtotime('-6 hours'));
        
        // Delete expired records
        $stmt = $pdo->prepare("DELETE FROM api_cache WHERE created_at < ?");
        $stmt->execute([$cutoff_time]);
        $count = $stmt->rowCount();
        
        $log_msg = "[" . date('Y-m-d H:i:s') . "] FORCE PURGE (UNSAFE): Removed $count expired IDs.\n";
        file_put_contents($purge_log, $log_msg, FILE_APPEND);
        $success_msg = "Successfully force purged $count expired records (Safety Bypassed).";
    }

    // --- WIPE ALL DATA (No 6-Hour Limit) ---
    if (isset($_POST['wipe_all_data'])) {
        $pdo->exec("TRUNCATE TABLE api_cache");
        $log_msg = "[" . date('Y-m-d H:i:s') . "] WIPE ALL: Database truncated by admin.\n";
        file_put_contents($purge_log, $log_msg, FILE_APPEND);
        $success_msg = "Database completely wiped (All records removed).";
    }

    // --- SELECTIVE PURGE (Specific ID) ---
    if (isset($_POST['selective_purge_btn']) && !empty($_POST['selective_purge_id'])) {
        $target_id = trim($_POST['selective_purge_id']);
        $clean_id = str_replace('faculty_', '', $target_id); // Handle if user typed "faculty_123"
        $db_id = 'faculty_' . $clean_id;

        $stmt = $pdo->prepare("DELETE FROM api_cache WHERE id = ?");
        $stmt->execute([$db_id]);
        
        if ($stmt->rowCount() > 0) {
            $log_msg = "[" . date('Y-m-d H:i:s') . "] SELECTIVE PURGE: Removed ID $db_id.\n";
            file_put_contents($purge_log, $log_msg, FILE_APPEND);
            $success_msg = "Successfully purged record for Faculty ID: $clean_id";
        } else {
            $purge_error = "No record found for Faculty ID: $clean_id";
        }
    }

    // --- INDIVIDUAL TABLE PURGE ---
    if (isset($_POST['purge_table'])) {
        $tbl = $_POST['purge_table'];
        $allowed = ['api_cache', 'phd_cache', 'publication_cache', 'project_cache', 'awards_cache', 'patent_cache', 'book_chapter_cache', 'books_published_cache', 'consultancy_cache', 'events_organized_cache', 'popular_media_cache'];
        if (in_array($tbl, $allowed)) {
            try {
                $pdo->exec("TRUNCATE TABLE $tbl");
                $log_msg = "[" . date('Y-m-d H:i:s') . "] TABLE PURGE: Truncated $tbl.\n";
                file_put_contents($purge_log, $log_msg, FILE_APPEND);
                $success_msg = "Successfully wiped table: $tbl.";
            } catch (Exception $e) {
                $purge_error = "Failed to wipe $tbl: " . $e->getMessage();
            }
        }
    }

    // --- EXPORT CSV ---
    if (isset($_POST['export_csv'])) {
        $filename = "sju_faculty_cache_" . date('Y-m-d_H-i') . ".csv";
        
        // Clean buffer to prevent HTML injection into CSV
        if (ob_get_level()) ob_end_clean();
        
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        
        $output = fopen('php://output', 'w');
        fputcsv($output, ['ID', 'Name', 'Department', 'Designation', 'Last Synced (IST)']);
        
        $stmt = $pdo->query("SELECT id, content, created_at FROM api_cache ORDER BY created_at DESC");
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $data = json_decode($row['content'], true);
            $staff = $data['staff'] ?? [];
            fputcsv($output, [str_replace('faculty_', '', $row['id']), $staff['name'] ?? 'Unknown', $staff['department']['name'] ?? 'N/A', $staff['academicDesignation']['name'] ?? 'N/A', $row['created_at']]);
        }
        fclose($output);
        exit;
    }
} catch (PDOException $e) {
    die("Database Connection Failed: " . $e->getMessage());
}

// --- DATA AGGREGATION ---
// 1. Total Faculty
$stmt = $pdo->query("SELECT COUNT(*) FROM api_cache");
$total_faculty = $stmt->fetchColumn();

// DB Stats for Modal
$db_stats = [];
$tables_to_check = ['api_cache', 'phd_cache', 'publication_cache', 'project_cache', 'awards_cache', 'patent_cache', 'book_chapter_cache', 'books_published_cache', 'consultancy_cache', 'events_organized_cache', 'popular_media_cache'];

foreach ($tables_to_check as $tbl) {
    try {
        $count = $pdo->query("SELECT COUNT(*) FROM $tbl")->fetchColumn();
        $last_sync = $pdo->query("SELECT MAX(created_at) FROM $tbl")->fetchColumn();
        $db_stats[$tbl] = [
            'count' => $count,
            'last_sync' => $last_sync ? date('d M, H:i', strtotime($last_sync)) : 'Never'
        ];
    } catch (Exception $e) {
        $db_stats[$tbl] = ['count' => 0, 'last_sync' => 'Error'];
    }
}

// 1.5 Total PhD Scholars
$total_phd_scholars = 0;
$phd_last_sync = 'N/A';
$phd_dept_stats = [];
try {
    $stmt_phd = $pdo->query("SELECT department_name, content, created_at FROM phd_cache");
    while ($row_phd = $stmt_phd->fetch(PDO::FETCH_ASSOC)) {
        $data_phd = json_decode($row_phd['content'], true);
        $count = 0;
        if (isset($data_phd['data']) && is_array($data_phd['data'])) {
            $count = count($data_phd['data']);
        }
        $total_phd_scholars += $count;
        
        $dept_name = $row_phd['department_name'] ?? 'Unknown';
        if ($count > 0) $phd_dept_stats[$dept_name] = $count;
        
        if ($row_phd['created_at'] && ($phd_last_sync === 'N/A' || strtotime($row_phd['created_at']) > strtotime($phd_last_sync))) {
            $phd_last_sync = $row_phd['created_at'];
        }
    }
    arsort($phd_dept_stats);
} catch (Exception $e) {}

// 1.6 Total Publications
$total_publications = 0;
$pub_last_sync = 'N/A';
$pub_dept_stats = [];
try {
    $stmt_pub = $pdo->query("SELECT department_name, content, created_at FROM publication_cache");
    while ($row_pub = $stmt_pub->fetch(PDO::FETCH_ASSOC)) {
        $data_pub = json_decode($row_pub['content'], true);
        $count = 0;
        if (isset($data_pub['data']) && is_array($data_pub['data'])) {
            $count = count($data_pub['data']);
        }
        $total_publications += $count;
        $dept_name = $row_pub['department_name'] ?? 'Unknown';
        if ($count > 0) $pub_dept_stats[$dept_name] = $count;
        
        // Track latest sync time
        if ($row_pub['created_at'] && ($pub_last_sync === 'N/A' || strtotime($row_pub['created_at']) > strtotime($pub_last_sync))) {
            $pub_last_sync = $row_pub['created_at'];
        }
    }
    arsort($pub_dept_stats);
} catch (Exception $e) {}

// 1.7 Total Projects
$total_projects = 0;
$proj_last_sync = 'N/A';
$proj_dept_stats = [];
try {
    $stmt_proj = $pdo->query("SELECT department_name, content, created_at FROM project_cache");
    while ($row_proj = $stmt_proj->fetch(PDO::FETCH_ASSOC)) {
        $data_proj = json_decode($row_proj['content'], true);
        $count = 0;
        if (isset($data_proj['data']) && is_array($data_proj['data'])) {
            $count = count($data_proj['data']);
        }
        $total_projects += $count;
        $dept_name = $row_proj['department_name'] ?? 'Unknown';
        if ($count > 0) $proj_dept_stats[$dept_name] = $count;
        
        // Track latest sync time
        if ($row_proj['created_at'] && ($proj_last_sync === 'N/A' || strtotime($row_proj['created_at']) > strtotime($proj_last_sync))) {
            $proj_last_sync = $row_proj['created_at'];
        }
    }
    arsort($proj_dept_stats);
} catch (Exception $e) {}

// 1.8 Total Awards
$total_awards = 0;
$award_last_sync = 'N/A';
$award_dept_stats = [];
try {
    $stmt_award = $pdo->query("SELECT department_name, content, created_at FROM awards_cache");
    while ($row_award = $stmt_award->fetch(PDO::FETCH_ASSOC)) {
        $data_award = json_decode($row_award['content'], true);
        $count = 0;
        if (isset($data_award['data']) && is_array($data_award['data'])) {
            $count = count($data_award['data']);
        }
        $total_awards += $count;
        
        $dept_name = $row_award['department_name'] ?? 'Unknown';
        if ($count > 0) $award_dept_stats[$dept_name] = $count;
        
        if ($row_award['created_at'] && ($award_last_sync === 'N/A' || strtotime($row_award['created_at']) > strtotime($award_last_sync))) {
            $award_last_sync = $row_award['created_at'];
        }
    }
    arsort($award_dept_stats);
} catch (Exception $e) {}

// 1.9 Total Patents
$total_patents = 0;
$patent_last_sync = 'N/A';
$patent_dept_stats = [];
try {
    $stmt_patent = $pdo->query("SELECT department_name, content, created_at FROM patent_cache");
    while ($row_patent = $stmt_patent->fetch(PDO::FETCH_ASSOC)) {
        $data_patent = json_decode($row_patent['content'], true);
        $count = 0;
        if (isset($data_patent['data']) && is_array($data_patent['data'])) {
            $count = count($data_patent['data']);
        }
        $total_patents += $count;
        
        $dept_name = $row_patent['department_name'] ?? 'Unknown';
        if ($count > 0) $patent_dept_stats[$dept_name] = $count;
        
        if ($row_patent['created_at'] && ($patent_last_sync === 'N/A' || strtotime($row_patent['created_at']) > strtotime($patent_last_sync))) {
            $patent_last_sync = $row_patent['created_at'];
        }
    }
    arsort($patent_dept_stats);
} catch (Exception $e) {}

// 1.10 Total Book Chapters
$total_book_chapters = 0;
$book_chapter_last_sync = 'N/A';
$book_chapter_dept_stats = [];
try {
    $stmt_bc = $pdo->query("SELECT department_name, content, created_at FROM book_chapter_cache");
    while ($row_bc = $stmt_bc->fetch(PDO::FETCH_ASSOC)) {
        $data_bc = json_decode($row_bc['content'], true);
        $count = 0;
        if (isset($data_bc['data']) && is_array($data_bc['data'])) {
            $count = count($data_bc['data']);
        }
        $total_book_chapters += $count;
        
        $dept_name = $row_bc['department_name'] ?? 'Unknown';
        if ($count > 0) $book_chapter_dept_stats[$dept_name] = $count;
        
        if ($row_bc['created_at'] && ($book_chapter_last_sync === 'N/A' || strtotime($row_bc['created_at']) > strtotime($book_chapter_last_sync))) {
            $book_chapter_last_sync = $row_bc['created_at'];
        }
    }
    arsort($book_chapter_dept_stats);
} catch (Exception $e) {}

// 1.11 Total Books Published
$total_books_published = 0;
$books_published_last_sync = 'N/A';
$books_published_dept_stats = [];
try {
    $stmt_bp = $pdo->query("SELECT department_name, content, created_at FROM books_published_cache");
    while ($row_bp = $stmt_bp->fetch(PDO::FETCH_ASSOC)) {
        $data_bp = json_decode($row_bp['content'], true);
        $count = 0;
        if (isset($data_bp['data']) && is_array($data_bp['data'])) {
            $count = count($data_bp['data']);
        }
        $total_books_published += $count;
        
        $dept_name = $row_bp['department_name'] ?? 'Unknown';
        if ($count > 0) $books_published_dept_stats[$dept_name] = $count;
        
        if ($row_bp['created_at'] && ($books_published_last_sync === 'N/A' || strtotime($row_bp['created_at']) > strtotime($books_published_last_sync))) {
            $books_published_last_sync = $row_bp['created_at'];
        }
    }
    arsort($books_published_dept_stats);
} catch (Exception $e) {}

// 1.12 Total Consultancy
$total_consultancy = 0;
$consultancy_last_sync = 'N/A';
$consultancy_dept_stats = [];
try {
    $stmt_consultancy = $pdo->query("SELECT department_name, content, created_at FROM consultancy_cache");
    while ($row_consultancy = $stmt_consultancy->fetch(PDO::FETCH_ASSOC)) {
        $data_consultancy = json_decode($row_consultancy['content'], true);
        $count = 0;
        if (isset($data_consultancy['data']) && is_array($data_consultancy['data'])) {
            $count = count($data_consultancy['data']);
        }
        $total_consultancy += $count;
        
        $dept_name = $row_consultancy['department_name'] ?? 'Unknown';
        if ($count > 0) $consultancy_dept_stats[$dept_name] = $count;
        
        if ($row_consultancy['created_at'] && ($consultancy_last_sync === 'N/A' || strtotime($row_consultancy['created_at']) > strtotime($consultancy_last_sync))) {
            $consultancy_last_sync = $row_consultancy['created_at'];
        }
    }
    arsort($consultancy_dept_stats);
} catch (Exception $e) {}

// 1.13 Total Events Organized
$total_events_organized = 0;
$events_organized_last_sync = 'N/A';
$events_organized_dept_stats = [];
try {
    $stmt_events = $pdo->query("SELECT department_name, content, created_at FROM events_organized_cache");
    while ($row_events = $stmt_events->fetch(PDO::FETCH_ASSOC)) {
        $data_events = json_decode($row_events['content'], true);
        $count = 0;
        if (isset($data_events['data']) && is_array($data_events['data'])) {
            $count = count($data_events['data']);
        }
        $total_events_organized += $count;
        $dept_name = $row_events['department_name'] ?? 'Unknown';
        if ($count > 0) $events_organized_dept_stats[$dept_name] = $count;
        if ($row_events['created_at'] && ($events_organized_last_sync === 'N/A' || strtotime($row_events['created_at']) > strtotime($events_organized_last_sync))) {
            $events_organized_last_sync = $row_events['created_at'];
        }
    }
    arsort($events_organized_dept_stats);
} catch (Exception $e) {}

// 1.14 Total Popular Media
$total_popular_media = 0;
$popular_media_last_sync = 'N/A';
$popular_media_dept_stats = [];
try {
    $stmt_media = $pdo->query("SELECT department_name, content, created_at FROM popular_media_cache");
    while ($row_media = $stmt_media->fetch(PDO::FETCH_ASSOC)) {
        $data_media = json_decode($row_media['content'], true);
        $count = 0;
        if (isset($data_media['data']) && is_array($data_media['data'])) $count = count($data_media['data']);
        $total_popular_media += $count;
        $dept_name = $row_media['department_name'] ?? 'Unknown';
        if ($count > 0) $popular_media_dept_stats[$dept_name] = $count;
        if ($row_media['created_at'] && ($popular_media_last_sync === 'N/A' || strtotime($row_media['created_at']) > strtotime($popular_media_last_sync))) $popular_media_last_sync = $row_media['created_at'];
    }
    arsort($popular_media_dept_stats);
} catch (Exception $e) {}

// 2. Department Stats & Recent Updates
$stmt = $pdo->query("SELECT id, content, created_at FROM api_cache ORDER BY created_at DESC");
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

$departments = [];
$recent_updates = [];
$designations = [];

foreach ($rows as $index => $row) {
    $data = json_decode($row['content'], true);
    $dept = $data['staff']['department']['name'] ?? 'Unassigned';
    
    // Count Departments
    if (!isset($departments[$dept])) $departments[$dept] = 0;
    $departments[$dept]++;

    // Count Designations
    $desig = $data['staff']['academicDesignation']['name'] ?? 'Unknown';
    if (!isset($designations[$desig])) $designations[$desig] = 0;
    $designations[$desig]++;

    // Get recent 5
    if ($index < 5) {
        $recent_updates[] = [
            'name' => $data['staff']['name'] ?? 'Unknown',
            'id' => str_replace('faculty_', '', $row['id']),
            'time' => $row['created_at']
        ];
    }
}
arsort($departments); // Sort by count desc
arsort($designations); // Sort by count desc

// 3. Cache Size
$cache_dir_size = 0;
if (isset($CACHE_DIR) && is_dir($CACHE_DIR)) {
    foreach (glob($CACHE_DIR . "/*.json") as $file) {
        $cache_dir_size += filesize($file);
    }
}
$cache_size_mb = round($cache_dir_size / 1024 / 1024, 2);

// 4. Search Logic
$search_results = [];
$search_term = '';
if (isset($_GET['search']) && !empty(trim($_GET['search']))) {
    $search_term = trim($_GET['search']);
    foreach ($rows as $row) {
        $data = json_decode($row['content'], true);
        $name = $data['staff']['name'] ?? '';
        $fid = str_replace('faculty_', '', $row['id']);
        $dept = $data['staff']['department']['name'] ?? '';
        
        if (stripos($name, $search_term) !== false || stripos($fid, $search_term) !== false) {
            $search_results[] = [
                'id' => $fid,
                'name' => $name,
                'dept' => $dept,
                'designation' => $data['staff']['academicDesignation']['name'] ?? 'N/A'
            ];
        }
    }
}

// 5. Read Purge Log
$purge_history = file_exists($purge_log) ? array_slice(explode("\n", trim(file_get_contents($purge_log))), -5) : [];

// 6. Cron Job Status
$cron_log = __DIR__ . '/cron_sync.log';
$cron_last_run = file_exists($cron_log) ? date("d M Y, h:i A", filemtime($cron_log)) : "Log file not found";

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SJU Faculty Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        .sidebar { min-height: 100vh; }
        .card-icon { font-size: 2.5rem; opacity: 0.3; position: absolute; right: 20px; top: 20px; }
    </style>
</head>
<body>
    <!-- Navbar for mobile toggle -->
    <nav class="navbar bg-body-tertiary d-lg-none sticky-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">SJU Admin</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu">
                <span class="navbar-toggler-icon"></span>
            </button>
        </div>
    </nav>

<div class="d-flex vh-100">
    <!-- Sidebar -->
    <div class="offcanvas-lg offcanvas-start sidebar bg-body-tertiary d-flex flex-column flex-shrink-0 p-0" data-bs-scroll="true" tabindex="-1" id="sidebarMenu" style="width: 250px;">
        <div class="offcanvas-header p-3 d-lg-none">
            <h5 class="offcanvas-title">SJU Admin</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="p-3 d-none d-lg-block">
            <a href="#" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-body text-decoration-none">
                <span class="fs-4 fw-bold">SJU Admin</span>
            </a>
        </div>
        <div class="offcanvas-body p-3 d-flex flex-column">
            <hr class="mt-0">
            <ul class="nav nav-pills flex-column mb-auto">
                <li class="nav-item"><a href="#" class="nav-link active"><i class="fa fa-home me-2"></i> Dashboard</a></li>
                <li><a href="admin_update.php" class="nav-link text-body"><i class="fa fa-list me-2"></i> Manage List</a></li>
                <li><a href="bulk_import.php" target="_blank" class="nav-link text-body"><i class="fa fa-upload me-2"></i> Bulk Import</a></li>
                <li><a href="Health_check.php" target="_blank" class="nav-link text-body"><i class="fa fa-server me-2"></i> Server Control</a></li>
                <li><a href="Health_checkv1.php" target="_blank" class="nav-link text-body"><i class="fa fa-heartbeat me-2"></i> Health Check</a></li>
                <li class="nav-item">
                    <a href="#generator-submenu" data-bs-toggle="collapse" class="nav-link text-body">
                        <i class="fa fa-file-code me-2"></i> Page Generators
                    </a>
                    <ul class="collapse nav flex-column ms-3" id="generator-submenu" data-bs-parent="#sidebarMenu">
                        <li><a href="create_profiles.php" target="_blank" class="nav-link text-body small">Faculty Profiles</a></li>
                        <li><a href="bulk_phd_generator.php" target="_blank" class="nav-link text-body small">PhD Pages</a></li>
                        <li><a href="bulk_phd_live_generator.php" target="_blank" class="nav-link text-body small">LIVE PhD Pages</a></li>
                        <li><a href="bulk_publication_generator.php" target="_blank" class="nav-link text-body small">Publication Pages</a></li>
                        <li><a href="bulk_project_generator.php" target="_blank" class="nav-link text-body small">Project Pages</a></li>
                        <li><a href="bulk_awards_generator.php" target="_blank" class="nav-link text-body small">Award Pages</a></li>
                        <li><a href="bulk_patent_generator.php" target="_blank" class="nav-link text-body small">Patent Pages</a></li>
                        <li><a href="bulk_book_chapter_generator.php" target="_blank" class="nav-link text-body small">Book Chapter Pages</a></li>
                        <li><a href="bulk_books_published_generator.php" target="_blank" class="nav-link text-body small">Books Published Pages</a></li>
                        <li><a href="bulk_consultancy_generator.php" target="_blank" class="nav-link text-body small">Consultancy Pages</a></li>
                    </ul>
                </li>
                <li><a href="phd_admin.php" class="nav-link text-body"><i class="fa fa-graduation-cap me-2"></i> PhD Admin</a></li>
                <li><a href="publication_admin.php" class="nav-link text-body"><i class="fa fa-book me-2"></i> Publication Admin</a></li>
                <li><a href="project_admin.php" class="nav-link text-body"><i class="fa fa-flask me-2"></i> Project Admin</a></li>
                <li><a href="awards_admin.php" class="nav-link text-body"><i class="fa fa-trophy me-2"></i> Awards Admin</a></li>
                <li><a href="patent_admin.php" class="nav-link text-body"><i class="fa fa-lightbulb me-2"></i> Patent Admin</a></li>
                <li><a href="book_chapter_admin.php" class="nav-link text-body"><i class="fa fa-book-open me-2"></i> Book Chapter Admin</a></li>
                <li><a href="books_published_admin.php" class="nav-link text-body"><i class="fa fa-book-bookmark me-2"></i> Books Published Admin</a></li>
                <li><a href="consultancy_admin.php" class="nav-link text-body"><i class="fa fa-handshake me-2"></i> Consultancy Admin</a></li>
                <li><a href="events_organized_admin.php" class="nav-link text-body"><i class="fa fa-calendar-check me-2"></i> Events Organized Admin</a></li>
                <li><a href="popular_media_admin.php" class="nav-link text-body"><i class="fa fa-newspaper me-2"></i> Popular Media Admin</a></li>
                <li><a href="settings.php" class="nav-link text-body"><i class="fa fa-cog me-2"></i> Settings</a></li>
                <li><a href="view_logs.php" class="nav-link text-body"><i class="fa fa-file-alt me-2"></i> View Logs</a></li>
            </ul>
            <hr>
            <div class="dropdown">
                <a href="?logout=1" class="d-flex align-items-center text-body text-decoration-none">
                    <i class="fa fa-sign-out-alt me-2"></i> <strong>Sign out</strong>
                </a>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <main class="flex-grow-1 bg-body-tertiary p-3 p-lg-4" style="overflow-y: auto;">
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4">
                <h2>Dashboard Overview</h2>
                <?php if(isset($success_msg)) echo "<div class='alert alert-success py-1 px-3 mb-0'>$success_msg</div>"; ?>
                <?php if(isset($purge_error)) echo "<div class='alert alert-danger py-1 px-3 mb-0'>$purge_error</div>"; ?>
                <div class="d-flex flex-wrap align-items-center gap-2">
                    <div class="form-check form-switch" title="Toggle Dark Mode">
                        <input class="form-check-input" type="checkbox" role="switch" id="themeSwitch">
                    </div>
                    <form method="POST" class="d-inline">
                        <button type="submit" name="export_csv" class="btn btn-outline-dark me-2"><i class="fa fa-file-csv"></i> Export CSV</button>
                    </form>
                    <button type="button" class="btn btn-outline-secondary me-2" data-bs-toggle="modal" data-bs-target="#dbStatsModal"><i class="fa fa-database"></i> DB Stats</button>
                    <button type="button" class="btn btn-outline-info me-2" data-bs-toggle="modal" data-bs-target="#pathCheckModal"><i class="fa fa-folder-open"></i> Path Check</button>
                    <button type="button" class="btn btn-outline-warning me-2" data-bs-toggle="modal" data-bs-target="#speedTestModal"><i class="fa fa-tachometer-alt"></i> Speed Test</button>
                    <button class="btn btn-outline-primary me-2" onclick="location.reload()"><i class="fa fa-sync"></i> Refresh</button>
                    <div class="btn-group">
                        <button type="button" class="btn btn-success dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fa fa-rocket"></i> Run Sync
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item fw-bold" href="master_sync.php" target="_blank">Run Master Sync (All)</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="cron_update_all.php" target="_blank">Sync Faculty Profiles</a></li>
                            <li><a class="dropdown-item" href="bulk_phd_cron.php" target="_blank">Sync PhD Scholars</a></li>
                            <li><a class="dropdown-item" href="bulk_publication_cron.php" target="_blank">Sync Publications</a></li>
                            <li><a class="dropdown-item" href="bulk_project_cron.php" target="_blank">Sync Projects</a></li>
                            <li><a class="dropdown-item" href="bulk_awards_cron.php" target="_blank">Sync Awards</a></li>
                            <li><a class="dropdown-item" href="bulk_patent_cron.php" target="_blank">Sync Patents</a></li>
                            <li><a class="dropdown-item" href="bulk_book_chapter_cron.php" target="_blank">Sync Book Chapters</a></li>
                            <li><a class="dropdown-item" href="bulk_books_published_cron.php" target="_blank">Sync Books Published</a></li>
                            <li><a class="dropdown-item" href="bulk_consultancy_cron.php" target="_blank">Sync Consultancy</a></li>
                            <li><a class="dropdown-item" href="bulk_events_organized_cron.php" target="_blank">Sync Events Organized</a></li>
                            <li><a class="dropdown-item" href="bulk_popular_media_cron.php" target="_blank">Sync Popular Media</a></li>
                        </ul>
                    </div>
                    <div class="btn-group">
                        <button type="button" class="btn btn-info text-white dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fa fa-file-code"></i> Generate Pages
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item fw-bold text-primary" href="master_generator.php" target="_blank">Run Master Generator (All)</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><h6 class="dropdown-header">Cached Page Generators</h6></li>
                            <li><a class="dropdown-item" href="create_profiles.php" target="_blank">Faculty Profiles</a></li>
                            <li><a class="dropdown-item" href="bulk_phd_generator.php" target="_blank">PhD Pages</a></li>
                            <li><a class="dropdown-item" href="bulk_publication_generator.php" target="_blank">Publication Pages</a></li>
                            <li><a class="dropdown-item" href="bulk_project_generator.php" target="_blank">Project Pages</a></li>
                            <li><a class="dropdown-item" href="bulk_awards_generator.php" target="_blank">Award Pages</a></li>
                            <li><a class="dropdown-item" href="bulk_patent_generator.php" target="_blank">Patent Pages</a></li>
                            <li><a class="dropdown-item" href="bulk_book_chapter_generator.php" target="_blank">Book Chapter Pages</a></li>
                            <li><a class="dropdown-item" href="bulk_books_published_generator.php" target="_blank">Books Published Pages</a></li>
                            <li><a class="dropdown-item" href="bulk_consultancy_generator.php" target="_blank">Consultancy Pages</a></li>
                            <li><a class="dropdown-item" href="bulk_events_organized_generator.php" target="_blank">Events Organized Pages</a></li>
                            <li><a class="dropdown-item" href="bulk_popular_media_generator.php" target="_blank">Popular Media Pages</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><h6 class="dropdown-header text-danger">Live Page Generators</h6></li>
                            <li><a class="dropdown-item" href="bulk_phd_live_generator.php" target="_blank">LIVE PhD Pages</a></li>
                            <li><a class="dropdown-item" href="bulk_publication_live_generator.php" target="_blank">LIVE Publication Pages</a></li>
                            <li><a class="dropdown-item" href="bulk_project_live_generator.php" target="_blank">LIVE Project Pages</a></li>
                            <li><a class="dropdown-item" href="bulk_awards_live_generator.php" target="_blank">LIVE Award Pages</a></li>
                            <li><a class="dropdown-item" href="bulk_patent_live_generator.php" target="_blank">LIVE Patent Pages</a></li>
                            <li><a class="dropdown-item" href="bulk_book_chapter_live_generator.php" target="_blank">LIVE Book Chapter Pages</a></li>
                            <li><a class="dropdown-item" href="bulk_books_published_live_generator.php" target="_blank">LIVE Books Published Pages</a></li>
                            <li><a class="dropdown-item" href="bulk_consultancy_live_generator.php" target="_blank">LIVE Consultancy Pages</a></li>
                            <li><a class="dropdown-item" href="bulk_events_organized_live_generator.php" target="_blank">LIVE Events Organized Pages</a></li>
                            <li><a class="dropdown-item" href="bulk_popular_media_live_generator.php" target="_blank">LIVE Popular Media Pages</a></li>
                        </ul>
                    </div>
                    <a href="?logout=1" class="btn btn-danger ms-2"><i class="fa fa-sign-out-alt"></i> Logout</a>
                </div>
            </div>

            <!-- System Health Widget -->
            <div class="card shadow-sm mb-4 border-start border-5 <?php echo ($api_status >= 200 && $api_status < 500) ? 'border-success' : 'border-danger'; ?>">
                <div class="card-body d-flex align-items-center justify-content-between flex-wrap gap-3">
                    <div>
                        <h5 class="mb-0 fw-bold"><i class="fa fa-heartbeat text-danger me-2"></i> System Health</h5>
                        <small class="text-muted">Real-time connectivity status</small>
                    </div>
                    <div class="d-flex gap-4">
                        <div class="d-flex align-items-center">
                            <div class="me-3 text-end">
                                <div class="fw-bold small text-uppercase text-muted">Linways API</div>
                                <?php if ($api_status >= 200 && $api_status < 500): ?>
                                    <div class="text-success fw-bold"><i class="fa fa-check-circle"></i> Reachable</div>
                                <?php else: ?>
                                    <div class="text-danger fw-bold"><i class="fa fa-times-circle"></i> Down (<?php echo $api_status; ?>)</div>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="vr"></div>
                        <div class="d-flex align-items-center">
                            <div class="me-3 text-end">
                                <div class="fw-bold small text-uppercase text-muted">Database</div>
                                <?php if (isset($pdo) && $pdo): ?>
                                    <div class="text-success fw-bold"><i class="fa fa-database"></i> Connected</div>
                                <?php else: ?>
                                    <div class="text-danger fw-bold"><i class="fa fa-exclamation-triangle"></i> Disconnected</div>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="vr"></div>
                        <div class="d-flex align-items-center">
                            <div class="text-end">
                                <div class="fw-bold small text-uppercase text-muted">Latency</div>
                                <div class="fw-bold"><?php echo round($api_latency * 1000); ?> ms</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Search Section -->
            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <form method="GET" class="row g-3">
                        <div class="col-sm-9 col-md-10">
                            <input type="text" name="search" class="form-control" placeholder="Search faculty by Name or ID..." value="<?php echo htmlspecialchars($search_term); ?>">
                        </div>
                        <div class="col-sm-3 col-md-2">
                            <button type="submit" class="btn btn-primary w-100"><i class="fa fa-search"></i> Search</button>
                        </div>
                    </form>
                    
                    <?php if (!empty($search_term)): ?>
                        <hr>
                        <h5 class="mb-3">Search Results for "<?php echo htmlspecialchars($search_term); ?>" (<?php echo count($search_results); ?>)</h5>
                        <?php if (count($search_results) > 0): ?>
                            <div class="list-group">
                                <?php foreach ($search_results as $res): ?>
                                    <a href="create_profiles.php?search=<?php echo urlencode($res['id']); ?>" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                        <div>
                                            <strong><?php echo htmlspecialchars($res['name']); ?></strong> <span class="text-muted small">(ID: <?php echo $res['id']; ?>)</span><br>
                                            <small class="text-muted"><?php echo htmlspecialchars($res['designation']); ?> - <?php echo htmlspecialchars($res['dept']); ?></small>
                                        </div>
                                        <i class="fa fa-chevron-right text-muted"></i>
                                    </a>
                                <?php endforeach; ?>
                            </div>
                        <?php else: ?>
                            <div class="alert alert-warning">No faculty found matching your criteria.</div>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Stats Cards -->
            <div class="row g-4 mb-4 row-cols-1 row-cols-sm-2 row-cols-lg-3 row-cols-xl-5 row-cols-xxl-6">
                <div class="col">
                    <div class="card bg-primary text-white h-100 shadow-sm border-0">
                        <div class="card-body">
                            <h6 class="card-title">TOTAL FACULTY</h6>
                            <h2 class="display-6 fw-bold"><?php echo $total_faculty; ?></h2>
                            <i class="fa fa-users card-icon"></i>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card bg-secondary text-white h-100 shadow-sm border-0">
                        <div class="card-body">
                            <h6 class="card-title">PHD SCHOLARS</h6>
                            <h2 class="display-6 fw-bold"><?php echo $total_phd_scholars; ?></h2>
                            <small class="opacity-75">Synced: <?php echo ($phd_last_sync !== 'N/A') ? date('d M, H:i', strtotime($phd_last_sync)) : 'Never'; ?></small>
                            <i class="fa fa-graduation-cap card-icon"></i>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card bg-danger text-white h-100 shadow-sm border-0">
                        <div class="card-body">
                            <h6 class="card-title">PUBLICATIONS</h6>
                            <h2 class="display-6 fw-bold"><?php echo $total_publications; ?></h2>
                            <small class="opacity-75">Synced: <?php echo ($pub_last_sync !== 'N/A') ? date('d M, H:i', strtotime($pub_last_sync)) : 'Never'; ?></small>
                            <i class="fa fa-book card-icon"></i>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card bg-dark text-white h-100 shadow-sm border-0">
                        <div class="card-body">
                            <h6 class="card-title">PROJECTS</h6>
                            <h2 class="display-6 fw-bold"><?php echo $total_projects; ?></h2>
                            <small class="opacity-75">Synced: <?php echo ($proj_last_sync !== 'N/A') ? date('d M, H:i', strtotime($proj_last_sync)) : 'Never'; ?></small>
                            <i class="fa fa-flask card-icon"></i>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card bg-primary text-white h-100 shadow-sm border-0" style="background-color: #6610f2 !important;">
                        <div class="card-body">
                            <h6 class="card-title">AWARDS</h6>
                            <h2 class="display-6 fw-bold"><?php echo $total_awards; ?></h2>
                            <small class="opacity-75">Synced: <?php echo ($award_last_sync !== 'N/A') ? date('d M, H:i', strtotime($award_last_sync)) : 'Never'; ?></small>
                            <i class="fa fa-trophy card-icon"></i>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card bg-info text-white h-100 shadow-sm border-0">
                        <div class="card-body">
                            <h6 class="card-title">PATENTS</h6>
                            <h2 class="display-6 fw-bold"><?php echo $total_patents; ?></h2>
                            <small class="opacity-75">Synced: <?php echo ($patent_last_sync !== 'N/A') ? date('d M, H:i', strtotime($patent_last_sync)) : 'Never'; ?></small>
                            <i class="fa fa-lightbulb card-icon"></i>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card text-white h-100 shadow-sm border-0" style="background-color: #6f42c1 !important;">
                        <div class="card-body">
                            <h6 class="card-title">BOOK CHAPTERS</h6>
                            <h2 class="display-6 fw-bold"><?php echo $total_book_chapters; ?></h2>
                            <small class="opacity-75">Synced: <?php echo ($book_chapter_last_sync !== 'N/A') ? date('d M, H:i', strtotime($book_chapter_last_sync)) : 'Never'; ?></small>
                            <i class="fa fa-book-open card-icon"></i>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card text-white h-100 shadow-sm border-0" style="background-color: #fd7e14;">
                        <div class="card-body">
                            <h6 class="card-title">BOOKS PUBLISHED</h6>
                            <h2 class="display-6 fw-bold"><?php echo $total_books_published; ?></h2>
                            <small class="opacity-75">Synced: <?php echo ($books_published_last_sync !== 'N/A') ? date('d M, H:i', strtotime($books_published_last_sync)) : 'Never'; ?></small>
                            <i class="fa fa-book-bookmark card-icon"></i>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card text-white h-100 shadow-sm border-0" style="background-color: #20c997;">
                        <div class="card-body">
                            <h6 class="card-title">CONSULTANCY</h6>
                            <h2 class="display-6 fw-bold"><?php echo $total_consultancy; ?></h2>
                            <small class="opacity-75">Synced: <?php echo ($consultancy_last_sync !== 'N/A') ? date('d M, H:i', strtotime($consultancy_last_sync)) : 'Never'; ?></small>
                            <i class="fa fa-handshake card-icon"></i>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card bg-secondary text-white h-100 shadow-sm border-0">
                        <div class="card-body">
                            <h6 class="card-title">EVENTS ORGANIZED</h6>
                            <h2 class="display-6 fw-bold"><?php echo $total_events_organized; ?></h2>
                            <small class="opacity-75">Synced: <?php echo ($events_organized_last_sync !== 'N/A') ? date('d M, H:i', strtotime($events_organized_last_sync)) : 'Never'; ?></small>
                            <i class="fa fa-calendar-check card-icon"></i>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card bg-info text-white h-100 shadow-sm border-0">
                        <div class="card-body">
                            <h6 class="card-title">POPULAR MEDIA</h6>
                            <h2 class="display-6 fw-bold"><?php echo $total_popular_media; ?></h2>
                            <small class="opacity-75">Synced: <?php echo ($popular_media_last_sync !== 'N/A') ? date('d M, H:i', strtotime($popular_media_last_sync)) : 'Never'; ?></small>
                            <i class="fa fa-newspaper card-icon"></i>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card bg-success text-white h-100 shadow-sm border-0">
                        <div class="card-body">
                            <h6 class="card-title">DEPARTMENTS</h6>
                            <h2 class="display-6 fw-bold"><?php echo count($departments); ?></h2>
                            <i class="fa fa-building card-icon"></i>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card bg-warning text-dark h-100 shadow-sm border-0">
                        <div class="card-body">
                            <h6 class="card-title">CACHE SIZE</h6>
                            <h2 class="display-6 fw-bold"><?php echo $cache_size_mb; ?> MB</h2>
                            <i class="fa fa-database card-icon"></i>
                        </div>
                    </div>
                </div>
                <div class="col d-none d-xxl-block">
                    <div class="card bg-info text-white h-100 shadow-sm border-0">
                        <div class="card-body">
                            <h6 class="card-title">LAST UPDATE</h6>
                            <h5 class="fw-bold mt-3"><?php echo !empty($recent_updates) ? date('H:i', strtotime($recent_updates[0]['time'])) : 'N/A'; ?></h5>
                            <small>Today</small>
                            <i class="fa fa-clock card-icon"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Cron Job Status -->
            <div class="card shadow-sm mb-4">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="fw-bold mb-1"><i class="fa fa-cogs me-2"></i> Background Sync Status</h6>
                        <small class="text-muted">Last modification of <code>cron_sync.log</code></small>
                    </div>
                    <div class="text-end">
                        <h5 class="mb-0 fw-bold <?php echo (strpos($cron_last_run, 'not found') === false) ? 'text-success' : 'text-danger'; ?>">
                            <?php echo $cron_last_run; ?>
                        </h5>
                    </div>
                </div>
            </div>

            <!-- API Latency Chart -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white fw-bold">
                    <i class="fa fa-tachometer-alt me-2"></i> API Response Time (Last 30 Checks)
                </div>
                <div class="card-body">
                    <canvas id="latencyChart" style="max-height: 250px;"></canvas>
                </div>
            </div>

            <div class="row">
                <!-- Department Chart -->
                <div class="col-lg-8 mb-4">
                    <div class="card shadow-sm h-100">
                        <div class="card-header bg-white fw-bold">Faculty Distribution by Department</div>
                        <div class="card-body">
                            <canvas id="deptChart"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Recent Activity -->
                <div class="col-lg-4 mb-4">
                    <div class="card shadow-sm h-100">
                        <div class="card-header bg-white fw-bold">Recent Updates</div>
                        <ul class="list-group list-group-flush">
                            <?php foreach ($recent_updates as $update): ?>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <div>
                                    <strong><?php echo htmlspecialchars($update['name']); ?></strong><br>
                                    <small class="text-muted">ID: <?php echo $update['id']; ?></small>
                                </div>
                                <span class="badge bg-light text-dark"><?php echo date('H:i:s', strtotime($update['time'])); ?></span>
                            </li>
                            <?php endforeach; ?>
                            <?php if(empty($recent_updates)): ?>
                                <li class="list-group-item text-center text-muted">No recent data found.</li>
                            <?php endif; ?>
                        </ul>
                        <div class="card-footer bg-white text-center">
                            <a href="admin_update.php" class="text-decoration-none small">View All Records</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Publications Chart -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white fw-bold">Publications by Department</div>
                <div class="card-body">
                    <canvas id="pubChart" style="max-height: 300px;"></canvas>
                </div>
            </div>

            <!-- Projects Chart -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white fw-bold">Research Projects by Department</div>
                <div class="card-body">
                    <canvas id="projChart" style="max-height: 300px;"></canvas>
                </div>
            </div>

            <!-- Awards Chart -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white fw-bold">Awards & Achievements by Department</div>
                <div class="card-body">
                    <canvas id="awardChart" style="max-height: 300px;"></canvas>
                </div>
            </div>

            <!-- Patents Chart -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white fw-bold">Patents by Department</div>
                <div class="card-body">
                    <canvas id="patentChart" style="max-height: 300px;"></canvas>
                </div>
            </div>

            <!-- Book Chapters Chart -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white fw-bold">Book Chapters by Department</div>
                <div class="card-body">
                    <canvas id="bookChapterChart" style="max-height: 300px;"></canvas>
                </div>
            </div>

            <!-- Books Published Chart -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white fw-bold">Books Published by Department</div>
                <div class="card-body">
                    <canvas id="booksPublishedChart" style="max-height: 300px;"></canvas>
                </div>
            </div>

            <!-- Consultancy Chart -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white fw-bold">Consultancy by Department</div>
                <div class="card-body">
                    <canvas id="consultancyChart" style="max-height: 300px;"></canvas>
                </div>
            </div>

            <!-- Events Organized Chart -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white fw-bold">Events Organized by Department</div>
                <div class="card-body">
                    <canvas id="eventsOrganizedChart" style="max-height: 300px;"></canvas>
                </div>
            </div>

            <!-- Popular Media Chart -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white fw-bold">Popular Media Articles by Department</div>
                <div class="card-body">
                    <canvas id="popularMediaChart" style="max-height: 300px;"></canvas>
                </div>
            </div>

            <div class="row">
                <!-- PhD Scholars Chart -->
                <div class="col-lg-8 mb-4">
                    <div class="card shadow-sm h-100">
                        <div class="card-header bg-white fw-bold">PhD Scholars by Department</div>
                        <div class="card-body">
                            <canvas id="phdChart" style="max-height: 300px;"></canvas>
                        </div>
                    </div>
                </div>
                <!-- Designation Chart -->
                <div class="col-lg-4 mb-4">
                    <div class="card shadow-sm h-100">
                        <div class="card-header bg-white fw-bold">Faculty Designations</div>
                        <div class="card-body">
                            <canvas id="designationChart" style="max-height: 300px;"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Manual Override Section -->
            <div class="card shadow-sm mb-4 border-danger">
                <div class="card-header bg-danger text-white fw-bold"><i class="fa fa-exclamation-triangle me-2"></i> Manual Override</div>
                <div class="card-body">
                    <!-- Bulk Actions -->
                    <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-3">
                        <div>
                            <strong>Force Purge Expired Data</strong>
                            <p class="text-muted small mb-0">Manage cache retention. Use "Wipe Everything" to remove all data regardless of time.</p>
                        </div>
                        <div class="d-flex gap-2">
                            <form method="POST" onsubmit="return confirm('Are you sure? This will delete cached data.');">
                                <button type="submit" name="manual_purge" class="btn btn-danger">Purge Now</button>
                            </form>
                            <form method="POST" onsubmit="return confirm('WARNING: This bypasses the API safety check. If the API is down, profiles will disappear. Continue?') && confirm('Double Check: Are you absolutely sure you want to force delete data without an API check?');">
                                <button type="submit" name="force_purge_anyway" class="btn btn-outline-danger">Force Purge Anyway</button>
                            </form>
                            <form method="POST" onsubmit="return confirm('CRITICAL: This will delete ALL data immediately. The database will be empty. Are you sure?');">
                                <button type="submit" name="wipe_all_data" class="btn btn-dark">Wipe Everything</button>
                            </form>
                        </div>
                    </div>

                    <hr>

                    <!-- Selective Purge -->
                    <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
                        <div>
                            <strong>Selective Purge</strong>
                            <p class="text-muted small mb-0">Remove a specific faculty profile from the cache to force a re-sync.</p>
                        </div>
                        <form method="POST" class="d-flex flex-wrap gap-2 align-items-center">
                            <input type="text" name="selective_purge_id" class="form-control" placeholder="Enter Faculty ID (e.g. 123)" required style="width: 200px;">
                            <button type="submit" name="selective_purge_btn" class="btn btn-outline-danger text-nowrap">Purge ID</button>
                        </form>
                    </div>
                </div>
            </div>
            
            <!-- System Health / Logs -->
                    </div>
                </div>
            </div>
            
            <!-- System Health / Logs -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white fw-bold d-flex justify-content-between align-items-center">
                    <span><i class="fa fa-terminal me-2"></i> System Logs (Auto-Purge History)</span>
                    <a href="view_logs.php" class="btn btn-sm btn-outline-secondary py-0">View Full Log</a>
                </div>
                <div class="card-body bg-dark text-success font-monospace small p-3" style="max-height: 150px; overflow-y: auto;">
                    <?php if(empty($purge_history)): ?>
                        <div>No purge events recorded yet.</div>
                    <?php else: ?>
                        <?php foreach(array_reverse($purge_history) as $log) echo "<div>" . htmlspecialchars($log) . "</div>"; ?>
                    <?php endif; ?>
                </div>
            </div>

        </div> <!-- /.container-fluid -->
    </main>
</div> <!-- /.d-flex -->

<!-- DB Stats Modal -->
<div class="modal fade" id="dbStatsModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Database Table Statistics</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <table class="table table-striped">
                    <thead><tr><th>Table Name</th><th>Content</th><th>Row Count</th><th>Last Synced</th><th>Action</th></tr></thead>
                    <tbody>
                        <?php 
                        $tbl_map = [
                            'api_cache' => 'Faculty Profiles',
                            'phd_cache' => 'PhD Data (Depts)',
                            'publication_cache' => 'Publications (Depts)',
                            'project_cache' => 'Projects (Depts)',
                            'awards_cache' => 'Awards (Depts)',
                            'patent_cache' => 'Patents (Depts)',
                            'book_chapter_cache' => 'Book Chapters (Depts)',
                            'books_published_cache' => 'Books Published (Depts)',
                            'consultancy_cache' => 'Consultancy (Depts)',
                            'events_organized_cache' => 'Events Organized (Depts)',
                            'popular_media_cache' => 'Popular Media (Depts)'
                        ];
                        foreach ($tbl_map as $tbl => $desc): ?>
                        <tr>
                            <td><code><?php echo $tbl; ?></code></td>
                            <td><?php echo $desc; ?></td>
                            <td><?php echo $db_stats[$tbl]['count']; ?></td>
                            <td><?php echo $db_stats[$tbl]['last_sync']; ?></td>
                            <td>
                                <form method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to wipe <?php echo $tbl; ?>?');">
                                    <button type="submit" name="purge_table" value="<?php echo $tbl; ?>" class="btn btn-sm btn-outline-danger py-0" title="Wipe Table"><i class="fa fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <div class="alert alert-info small mb-0">
                    <i class="fa fa-info-circle me-2"></i>
                    <strong>Note:</strong> For non-faculty tables (PhD, Publications, etc.), the "Row Count" represents the number of <em>departments</em> that have been successfully synced and stored in the database.
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Path Check Modal -->
<div class="modal fade" id="pathCheckModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Configuration Path Security Check</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>This checks if the system can securely access the main <code>config.php</code> file.</p>
                <hr>
                <p class="mb-2"><b>Target Path:</b></p>
                <p><code><?php echo htmlspecialchars($path_check_results['target']); ?></code></p>
                
                <ul class="list-group">
                    <?php if (isset($path_check_results['exists'])): ?>
                        <li class="list-group-item d-flex justify-content-between align-items-center <?php echo $path_check_results['exists']['status'] ? 'list-group-item-success' : 'list-group-item-danger'; ?>">
                            <?php echo $path_check_results['exists']['message']; ?>
                            <i class="fa <?php echo $path_check_results['exists']['status'] ? 'fa-check-circle' : 'fa-times-circle'; ?>"></i>
                        </li>
                    <?php endif; ?>
                    <?php if (isset($path_check_results['readable'])): ?>
                        <li class="list-group-item d-flex justify-content-between align-items-center <?php echo $path_check_results['readable']['status'] ? 'list-group-item-success' : 'list-group-item-danger'; ?>">
                            <?php echo $path_check_results['readable']['message']; ?>
                            <i class="fa <?php echo $path_check_results['readable']['status'] ? 'fa-check-circle' : 'fa-times-circle'; ?>"></i>
                        </li>
                    <?php endif; ?>
                    <?php if (isset($path_check_results['constant'])): ?>
                        <li class="list-group-item d-flex justify-content-between align-items-center <?php echo $path_check_results['constant']['status'] ? 'list-group-item-success' : 'list-group-item-danger'; ?>">
                            <?php echo $path_check_results['constant']['message']; ?>
                            <i class="fa <?php echo $path_check_results['constant']['status'] ? 'fa-check-circle' : 'fa-times-circle'; ?>"></i>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </div>
</div>

<!-- Speed Test Modal -->
<div class="modal fade" id="speedTestModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Server Performance Benchmark</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>This test measures the time it takes to load the configuration, connect to the database, and fetch a single record.</p>
                <hr>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Config Load Time
                        <span class="badge bg-secondary rounded-pill"><?php echo $speed_test_results['config_load_time']; ?> ms</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        DB Connection Time
                        <span class="badge bg-secondary rounded-pill"><?php echo $speed_test_results['db_conn_time']; ?> ms</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        DB Query Time
                        <span class="badge bg-secondary rounded-pill"><?php echo $speed_test_results['db_query_time']; ?> ms</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center fw-bold">
                        Total Execution Time
                        <span class="badge bg-primary rounded-pill fs-6"><?php echo $speed_test_results['total_time']; ?> ms</span>
                    </li>
                </ul>
                <div class="alert <?php echo str_replace('text-', 'alert-', $speed_test_results['grade_class']); ?> mt-3 text-center">
                    <h5 class="fw-bold mb-0 <?php echo $speed_test_results['grade_class']; ?>"><?php echo $speed_test_results['grade_message']; ?></h5>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Declare chart variables in a broader scope
    let deptChart, pubChart, projChart, awardChart, patentChart, bookChapterChart, booksPublishedChart, consultancyChart, eventsOrganizedChart, popularMediaChart, phdChart, designationChart, latencyChart;

    // --- Chart Data from PHP ---
    const chartData = {
        departments: <?php echo json_encode($departments); ?>,
        pub_dept_stats: <?php echo json_encode($pub_dept_stats); ?>,
        proj_dept_stats: <?php echo json_encode($proj_dept_stats); ?>,
        award_dept_stats: <?php echo json_encode($award_dept_stats); ?>,
        patent_dept_stats: <?php echo json_encode($patent_dept_stats); ?>,
        book_chapter_dept_stats: <?php echo json_encode($book_chapter_dept_stats); ?>,
        books_published_dept_stats: <?php echo json_encode($books_published_dept_stats); ?>,
        consultancy_dept_stats: <?php echo json_encode($consultancy_dept_stats); ?>,
        events_organized_dept_stats: <?php echo json_encode($events_organized_dept_stats); ?>,
        popular_media_dept_stats: <?php echo json_encode($popular_media_dept_stats); ?>,
        phd_dept_stats: <?php echo json_encode($phd_dept_stats); ?>,
        designations: <?php echo json_encode($designations); ?>,
        latency: <?php echo json_encode($lat_data); ?>
    };

    function renderCharts(theme) {
        const isDark = theme === 'dark';
        const gridColor = isDark ? 'rgba(255, 255, 255, 0.1)' : 'rgba(0, 0, 0, 0.1)';
        const labelColor = isDark ? 'rgba(255, 255, 255, 0.8)' : '#6c757d';

        // Helper to safely create a chart
        const createChart = (chartInstance, canvasId, config) => {
            if (chartInstance) chartInstance.destroy();
            const canvas = document.getElementById(canvasId);
            if (canvas) {
                return new Chart(canvas.getContext('2d'), config);
            }
            return null;
        };

        // Department Chart
        const sortedDepts = Object.entries(chartData.departments).sort((a,b) => b[1] - a[1]).slice(0, 10);
        deptChart = createChart(deptChart, 'deptChart', {
            type: 'bar',
            data: { labels: sortedDepts.map(d => d[0]), datasets: [{ data: sortedDepts.map(d => d[1]), backgroundColor: '#0d6efd', borderRadius: 4 }] },
            options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { display: false } }, scales: { y: { beginAtZero: true, grid: { color: gridColor }, ticks: { color: labelColor } }, x: { grid: { color: gridColor }, ticks: { color: labelColor } } } }
        });

        // Publication Chart
        pubChart = createChart(pubChart, 'pubChart', {
            type: 'bar',
            data: { labels: Object.keys(chartData.pub_dept_stats), datasets: [{ data: Object.values(chartData.pub_dept_stats), backgroundColor: '#dc3545', borderRadius: 4 }] },
            options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { display: false } }, scales: { y: { beginAtZero: true, grid: { color: gridColor }, ticks: { color: labelColor } }, x: { grid: { color: gridColor }, ticks: { color: labelColor } } } }
        });

        // Project Chart
        projChart = createChart(projChart, 'projChart', {
            type: 'bar',
            data: { labels: Object.keys(chartData.proj_dept_stats), datasets: [{ data: Object.values(chartData.proj_dept_stats), backgroundColor: '#212529', borderRadius: 4 }] },
            options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { display: false } }, scales: { y: { beginAtZero: true, grid: { color: gridColor }, ticks: { color: labelColor } }, x: { grid: { color: gridColor }, ticks: { color: labelColor } } } }
        });

        // Award Chart
        awardChart = createChart(awardChart, 'awardChart', {
            type: 'bar',
            data: { labels: Object.keys(chartData.award_dept_stats), datasets: [{ data: Object.values(chartData.award_dept_stats), backgroundColor: '#6610f2', borderRadius: 4 }] },
            options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { display: false } }, scales: { y: { beginAtZero: true, grid: { color: gridColor }, ticks: { color: labelColor } }, x: { grid: { color: gridColor }, ticks: { color: labelColor } } } }
        });

        // Patent Chart
        patentChart = createChart(patentChart, 'patentChart', {
            type: 'bar',
            data: { labels: Object.keys(chartData.patent_dept_stats), datasets: [{ data: Object.values(chartData.patent_dept_stats), backgroundColor: '#0dcaf0', borderRadius: 4 }] },
            options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { display: false } }, scales: { y: { beginAtZero: true, grid: { color: gridColor }, ticks: { color: labelColor } }, x: { grid: { color: gridColor }, ticks: { color: labelColor } } } }
        });

        // Book Chapter Chart
        bookChapterChart = createChart(bookChapterChart, 'bookChapterChart', {
            type: 'bar',
            data: { labels: Object.keys(chartData.book_chapter_dept_stats), datasets: [{ data: Object.values(chartData.book_chapter_dept_stats), backgroundColor: '#6f42c1', borderRadius: 4 }] },
            options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { display: false } }, scales: { y: { beginAtZero: true, grid: { color: gridColor }, ticks: { color: labelColor } }, x: { grid: { color: gridColor }, ticks: { color: labelColor } } } }
        });

        // Books Published Chart
        booksPublishedChart = createChart(booksPublishedChart, 'booksPublishedChart', {
            type: 'bar',
            data: { labels: Object.keys(chartData.books_published_dept_stats), datasets: [{ data: Object.values(chartData.books_published_dept_stats), backgroundColor: '#fd7e14', borderRadius: 4 }] },
            options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { display: false } }, scales: { y: { beginAtZero: true, grid: { color: gridColor }, ticks: { color: labelColor } }, x: { grid: { color: gridColor }, ticks: { color: labelColor } } } }
        });

        // Consultancy Chart
        consultancyChart = createChart(consultancyChart, 'consultancyChart', {
            type: 'bar',
            data: { labels: Object.keys(chartData.consultancy_dept_stats), datasets: [{ data: Object.values(chartData.consultancy_dept_stats), backgroundColor: '#20c997', borderRadius: 4 }] },
            options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { display: false } }, scales: { y: { beginAtZero: true, grid: { color: gridColor }, ticks: { color: labelColor } }, x: { grid: { color: gridColor }, ticks: { color: labelColor } } } }
        });

        // Events Organized Chart
        eventsOrganizedChart = createChart(eventsOrganizedChart, 'eventsOrganizedChart', {
            type: 'bar',
            data: { labels: Object.keys(chartData.events_organized_dept_stats), datasets: [{ data: Object.values(chartData.events_organized_dept_stats), backgroundColor: '#6c757d', borderRadius: 4 }] },
            options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { display: false } }, scales: { y: { beginAtZero: true, grid: { color: gridColor }, ticks: { color: labelColor } }, x: { grid: { color: gridColor }, ticks: { color: labelColor } } } }
        });

        // Popular Media Chart
        popularMediaChart = createChart(popularMediaChart, 'popularMediaChart', {
            type: 'bar',
            data: { labels: Object.keys(chartData.popular_media_dept_stats), datasets: [{ data: Object.values(chartData.popular_media_dept_stats), backgroundColor: '#0dcaf0', borderRadius: 4 }] },
            options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { display: false } }, scales: { y: { beginAtZero: true, grid: { color: gridColor }, ticks: { color: labelColor } }, x: { grid: { color: gridColor }, ticks: { color: labelColor } } } }
        });

        // PhD Chart
        phdChart = createChart(phdChart, 'phdChart', {
            type: 'bar',
            data: { labels: Object.keys(chartData.phd_dept_stats), datasets: [{ data: Object.values(chartData.phd_dept_stats), backgroundColor: '#6c757d', borderRadius: 4 }] },
            options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { display: false } }, scales: { y: { beginAtZero: true, grid: { color: gridColor }, ticks: { color: labelColor } }, x: { grid: { color: gridColor }, ticks: { color: labelColor } } } }
        });

        // Designation Chart
        designationChart = createChart(designationChart, 'designationChart', {
            type: 'pie',
            data: { labels: Object.keys(chartData.designations), datasets: [{ data: Object.values(chartData.designations), backgroundColor: ['#0d6efd', '#6610f2', '#6f42c1', '#d63384', '#dc3545', '#fd7e14', '#ffc107', '#198754', '#20c997', '#0dcaf0', '#adb5bd', '#6c757d'], borderWidth: 1 }] },
            options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { position: 'bottom', labels: { boxWidth: 12, font: { size: 10 }, color: labelColor } } } }
        });

        // Latency Chart
        latencyChart = createChart(latencyChart, 'latencyChart', {
            type: 'line',
            data: { labels: chartData.latency.map(d => new Date(d.t * 1000).toLocaleTimeString([], {hour: '2-digit', minute:'2-digit', second:'2-digit'})), datasets: [{ label: 'Response Time (seconds)', data: chartData.latency.map(d => d.v), borderColor: '#198754', backgroundColor: 'rgba(25, 135, 84, 0.1)', fill: true, tension: 0.3, pointRadius: 3 }] },
            options: { responsive: true, maintainAspectRatio: false, scales: { y: { beginAtZero: true, title: {display: true, text: 'Seconds'}, grid: { color: gridColor }, ticks: { color: labelColor } }, x: { grid: { color: gridColor }, ticks: { color: labelColor } } }, plugins: { legend: { display: false } } }
        });
    }

    // --- THEME SWITCHER LOGIC ---
    const themeSwitch = document.getElementById('themeSwitch');

    const getStoredTheme = () => localStorage.getItem('theme');
    const setStoredTheme = theme => localStorage.setItem('theme', theme);

    const getPreferredTheme = () => {
        const storedTheme = getStoredTheme();
        return storedTheme ? storedTheme : 'light';
    };

    const setTheme = theme => {
        document.documentElement.setAttribute('data-bs-theme', theme);
        renderCharts(theme);
    };

    // Set initial state of the toggle
    themeSwitch.checked = getPreferredTheme() === 'dark';

    // Add event listener
    themeSwitch.addEventListener('change', () => {
        const theme = themeSwitch.checked ? 'dark' : 'light';
        setStoredTheme(theme);
        setTheme(theme);
    });

    // Initial render of charts with the correct theme
    renderCharts(getPreferredTheme());
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>