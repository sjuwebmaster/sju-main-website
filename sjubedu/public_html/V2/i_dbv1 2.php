<?php
// Test/i_db.php - MASTER TEMPLATE
// Contains: DB Connection, API Logic, Data Processing, AND HTML Output.

ini_set('display_errors', 0); // Changed to 0 for production stability
ini_set('display_startup_errors', 0);
error_reporting(E_ALL);

$config = file_exists('/home/sjubedu/config.php') ? '/home/sjubedu/config.php' : __DIR__ . '/../../config.php';
require_once $config;

// --- 1. CONFIG & DATABASE ---
$db_host = 'localhost'; $db_name = 'sjubedu_faculty_data'; $db_user = 'sjubedu_developer'; $db_pass = 'SJU2022_sju';


try {
    $pdo = new PDO("mysql:host=$db_host;dbname=$db_name;charset=utf8mb4", $db_user, $db_pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // Health Purge: Clean records older than 6 hours
    $pdo->exec("DELETE FROM api_cache WHERE created_at < DATE_SUB(NOW(), INTERVAL 6 HOUR)");
} catch (PDOException $e) {
    die("Database Error: " . $e->getMessage());
}

// --- 2. LOGIC ---
if (!isset($FACULTY_ID)) { die("Error: FACULTY_ID not set."); }
$cache_id = 'faculty_' . $FACULTY_ID;
$cache_time = 21600; // 6 Hours
$is_cache_valid = false;
$staff_data = []; $data = []; $row = null;

// Check Cache
try {
    // Added fail_count to the select
    $stmt = $pdo->prepare("SELECT content, created_at, fail_count FROM api_cache WHERE id = ?");
    $stmt->execute([$cache_id]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($row && (time() - strtotime($row['created_at']) < $cache_time)) {
        $cached = json_decode($row['content'], true);
        if ($cached) { $staff_data = $cached['staff']; $data = $cached['reports']; $is_cache_valid = true; }
    }
} catch (Exception $e) {}

// Fetch API (if needed)
if (!$is_cache_valid) {
    if (file_exists(__DIR__ . '/config.php')) require_once __DIR__ . '/config.php';
    elseif (file_exists(__DIR__ . '/../config.php')) require_once __DIR__ . '/../config.php';
    
    // API Calls with 5s timeout to prevent hanging
    $opts = [CURLOPT_RETURNTRANSFER=>true, CURLOPT_HTTPHEADER=>["Authorization: $API_TOKEN", "Accept: application/json"], CURLOPT_SSL_VERIFYPEER=>false, CURLOPT_TIMEOUT=>5];

    $ch1 = curl_init("https://sjuv4.linways.com/api/v1/staffs/" . urlencode($FACULTY_ID));
    curl_setopt_array($ch1, $opts);
    $res1 = curl_exec($ch1);
    $s_api = json_decode($res1, true); curl_close($ch1);

    $ch2 = curl_init("https://sjuv4.linways.com/api/v1/exat2/reports/FxNRR5E7W56PzBizk/" . urlencode($FACULTY_ID));
    curl_setopt_array($ch2, $opts);
    $res2 = curl_exec($ch2);
    $r_api = json_decode($res2, true); curl_close($ch2);

    // --- FAIL-SAFE LOGIC ---
    if ($s_api && $r_api && !isset($s_api['error']) && !empty($r_api['data'])) {
        // SUCCESS: Save and reset fail_count
        $pdo->prepare("REPLACE INTO api_cache (id, content, created_at, fail_count) VALUES (?, ?, NOW(), 0)")
            ->execute([$cache_id, json_encode(['staff'=>$s_api, 'reports'=>$r_api])]);
        $staff_data = $s_api; $data = $r_api;
    } elseif ($row) {
        // FAIL: Linways is down. Extend cache by 6 hours and log the failure
        $new_fails = (int)$row['fail_count'] + 1;
        $pdo->prepare("UPDATE api_cache SET created_at = NOW(), fail_count = ? WHERE id = ?")
            ->execute([$new_fails, $cache_id]);
        $cached = json_decode($row['content'], true);
        $staff_data = $cached['staff']; $data = $cached['reports'];
    } else {
        die("System Maintenance: Data currently unavailable.");
    }
}

// --- 3. DATA CLEANING ---
$sections = $data['data'] ?? [];

// --- 3. DATA CLEANING ---
$sections = $data['data'] ?? [];

// Rename Awards and Professional qwualifications
foreach ($sections as &$s) { 
    if ($s['name'] === 'AWARDS,ACHIEVEMENTS' || $s['name'] === 'Awards, Achievements') {
        $s['name'] = 'Awards'; 
    }
    if ($s['name'] === 'PREVIOUS WORK EXPERIENCE') {
        $s['name'] = 'Previous Experience';
    }

    // Standardize subsection names to prevent double headings from variations like 'Previous Work Experience' no api headings
    if (!empty($s['data'])) {
        foreach ($s['data'] as &$sub) {
            if ($sub['name'] === 'Previous Work Experience') {
                $sub['name'] = 'Previous Experience';
            }
        }
        unset($sub);
    }
     if (!empty($s['data'])) {
        foreach ($s['data'] as &$sub) {
            if ($sub['name'] === 'Awards, Achievements') {
                $sub['name'] = 'Awards';
            }
        }
        unset($sub);
    }
} 
unset($s);

// Merge Degrees
$ac=null; $pr=null; $ph=null;
foreach ($sections as $k=>$s) {
    if ($s['name'] === 'ACADEMIC QUALIFICATION') $ac=$k;
    elseif ($s['name'] === 'PROFESSIONAL QUALIFICATION') $pr=$k;
    elseif ($s['name'] === 'PHD DETAILS') $ph=$k;
}
if ($ac!==null) {
    if ($pr!==null) { $sections[$ac]['data'] = array_merge($sections[$ac]['data'], $sections[$pr]['data']); unset($sections[$pr]); }
    if ($ph!==null) { $sections[$ac]['data'] = array_merge($sections[$ac]['data'], $sections[$ph]['data']); unset($sections[$ph]); }
    
    // --- CHANGE: Rename the main section to 'Professional Qualification' ---
    $sections[$ac]['name'] = 'Professional Qualification'; 
    
    $sections = array_values($sections);
}
/*
// Extract Participation
$partData = null;
foreach ($sections as &$s) {
    if (!empty($s['data'])) {
        foreach ($s['data'] as $sk=>$sub) {
            if (trim($sub['name']) === 'Participation (Seminar, Conference, Workshop)') {
                if ($partData===null) $partData=$sub; else $partData['data']=array_merge($partData['data'], $sub['data']);
                unset($s['data'][$sk]);
            }
        }
        $s['data'] = array_values($s['data']);
    }
}
unset($s);
if ($partData) $sections[] = ['id'=>'participation_section', 'name'=>'Participation', 'type'=>'section', 'data'=>[$partData]];
*/
// Prepare Variables
if (!isset($salutation)) $salutation = "Dr";
//function toTitleCase($s) { return ucwords(strtolower($s), " \t\r\n\f\v/-"); }
//$raw_name = $staff_data['name'] ?? ($faculty_name ?? 'N/A');
//$name = $salutation . " " . toTitleCase(stripslashes($raw_name));
// --- NEW BYPASS LOGIC ---
function toTitleCase($s) { return ucwords(strtolower($s), " \t\r\n\f\v/-"); }

// THE FIX: "If the name is NOT already set, then get it from Linways"
if (!isset($name)) {
    $raw_name = $staff_data['name'] ?? ($faculty_name ?? 'N/A');
    $name = $salutation . " " . toTitleCase(stripslashes($raw_name));
}
$employee_code = $staff_data['code'] ?? 'N/A';
$specialization = stripslashes(trim($staff_data['fieldOfSpecialization'] ?? ''));
if ($specialization === 'N/A') $specialization = '';
$email = $staff_data['email'] ?? '';

// About Me
$about_me = '';
foreach ($sections as $s) { if ($s['name']==='ABOUT ME') foreach($s['data'] as $sub) if($sub['name']==='About Me') $about_me=stripslashes($sub['data'][0]['About Me']??''); }

// Vidwan
$vidwan_id = '';
foreach ($sections as $s) { if ($s['name']==='RESEARCH IDs') foreach($s['data'] as $sub) if($sub['name']==='Research ids') $vidwan_id=$sub['data'][0]['Vidwan']??''; }

// Defaults
if (!isset($profile_photo) || empty($profile_photo)) $profile_photo = "https://via.placeholder.com/140x160?text=No+Image"; 
if (!isset($designation)) $designation = 'Associate Professor';
if (!isset($department)) $department = 'Physics';
date_default_timezone_set('Asia/Kolkata');
// Use the original cache timestamp for the display if it's from cache
$lastUpdated = date("d M Y, h:i A", strtotime($row['created_at'] ?? 'now'));

// --- END OF PHP LOGIC / START OF HTML ---
?>
<!doctype html>
<html class="no-js" lang="zxx" dir="ltr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>St Joseph's University</title>
    <link rel="icon" href="assets/img/favicon.png" type="image/png">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400..900;1,400..900&family=Plus+Jakarta+Sans:ital,wght@0,200..800;1,200..800&family=Urbanist:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="assets/css/style.css?v=2.3">
   <style>
        html { scroll-padding-top: 100px; scroll-behavior: smooth; }
        .section-content { display: none; animation: fadeIn 0.5s; }
        .section-content.active { display: block; }
        .tab-button.active { background-color: var(--bs-primary) !important; color: white !important; border-color: var(--bs-primary) !important; }
        @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
        @media print { .container { width: 100% !important; max-width: 100% !important; padding: 0 !important; } .section-content { display: block !important; opacity: 1 !important; } }
                .tab-contents h5 {
            font-family: 'robotobold';
            font-weight: 100;
            text-decoration: underline;
            padding: 0 0 13px;
            margin: 0 auto;
            color: #131313;
            letter-spacing: 0px;
            font-size: 15px;
            text-transform: uppercase;
        }
    </style> 

 <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
</head>
<body>
<button class="btn btn-primary position-fixed top-0 end-0 m-3 d-print-none z-3" onclick="window.print()">Download PDF</button>

<div class="container my-4">
    <div class="row mb-4 border-bottom pb-4">
        <div class="col-md-auto text-center text-md-start mb-3 mb-md-0">
            <img src="<?php echo htmlspecialchars($profile_photo); ?>" alt="Profile Photo" class="img-thumbnail mx-auto mx-md-0" style="width: 140px; height: 160px; object-fit: cover;">
        </div>
        <div class="col text-center text-md-start">
            <h1 class="text-primary mb-0"><?php echo htmlspecialchars($name); ?></h1>
            <p class="lead text-muted mb-2"><?php echo htmlspecialchars($designation); ?></p>
            <p class="mb-1"><i class="fas fa-building me-2 text-primary"></i><?php echo htmlspecialchars($department); ?></p>
            <p class="mb-1"><i class="fas fa-id-card me-2 text-primary"></i><?php echo htmlspecialchars($employee_code); ?></p>
            <?php if (!empty($specialization)): ?><p class="mb-1"><i class="fas fa-graduation-cap me-2 text-primary"></i><?php echo htmlspecialchars($specialization); ?></p><?php endif; ?>
            <?php if (!empty($email)): ?><p class="mb-1"><i class="fas fa-envelope me-2 text-primary"></i><a href="mailto:<?php echo htmlspecialchars($email); ?>" class="text-decoration-none"><?php echo htmlspecialchars($email); ?></a></p><?php endif; ?>
            <?php if (!empty($vidwan_id)): ?><p class="mb-0"><i class="fas fa-id-badge me-2 text-primary"></i><a href="https://vidwan.inflibnet.ac.in/profile/<?php echo htmlspecialchars($vidwan_id); ?>" target="_blank" class="text-decoration-none"><?php echo htmlspecialchars($vidwan_id); ?></a></p><?php endif; ?>
        </div>
    </div>

    <div class="content tab-contents">
        <?php
        if (!empty($about_me)) {
            echo '<h2 class="text-primary border-bottom pb-2 mb-3">About Me</h2>';
            echo '<div class="about-me-wrapper mb-4"><p class="about-me-text text-justify">' . htmlspecialchars($about_me) . '</p><a href="#" class="read-more-link text-decoration-none fw-bold">Read More</a></div>';
        }

        // TABS
        echo '<div class="d-flex flex-wrap gap-2 mb-4 border-bottom pb-3 d-print-none">';
        foreach ($sections as $section) {
            if (in_array($section['name'], ['ABOUT ME','ACADEMIC POSITION','COLLABORATIONS','AT SJC','CERTIFICATE COURSES CONDUCTED'])) continue;
            $hasData = false; foreach ($section['data'] as $sub) if (!in_array($sub['name'], ['Contribution through Committees','Extra and Co-curricular Details','Extension']) && !empty($sub['data'])) $hasData = true;
            if ($hasData) {
                $sid = 'section-' . preg_replace('/[^a-z0-9]+/', '-', strtolower($section['name']));
                echo '<a href="#' . $sid . '" class="btn btn-light border tab-button">' . htmlspecialchars(toTitleCase($section['name'])) . '</a>';
            }
        }
        echo '</div>';

        // TABLES
        $hidden_cols = ['Name of Institution', 'Position', 'Publons id', 'LinkedIn id'];
        foreach ($sections as $section) {
            if (in_array($section['name'], ['ABOUT ME','ACADEMIC POSITION','COLLABORATIONS','AT SJC','CERTIFICATE COURSES CONDUCTED'])) continue;
            $hasData = false; foreach ($section['data'] as $sub) if (!in_array($sub['name'], ['Contribution through Committees','Extra and Co-curricular Details','Extension']) && !empty($sub['data'])) $hasData = true;

            if ($hasData) {
                $sid = 'section-' . preg_replace('/[^a-z0-9]+/', '-', strtolower($section['name']));
                echo "<div id='$sid' class='section-content'>";
                echo "<h2 class='text-primary border-bottom pb-2 mb-3 mt-4'>" . htmlspecialchars(toTitleCase($section['name'])) . "</h2>";
                
                $scount = 0;
                foreach ($section['data'] as $sub) {
                    if (empty($sub['data']) || in_array($sub['name'], ['Contribution through Committees','Extra and Co-curricular Details','Extension'])) continue;
              //      if (trim($sub['name']) === 'Participation (Seminar, Conference, Workshop)' && $section['name'] !== 'Participation') continue;
                    
                    // --- CHANGE: Updated check to match new section name ---
                    if ($section['name'] === 'Professional Qualification' && $scount > 0) echo '<hr class="my-4 border-secondary">';
                    
                    $scount++;

                    if (in_array('Year', $sub['headers'])) usort($sub['data'], function($a,$b){ return strnatcmp($b['Year']??'', $a['Year']??''); });// Sort by Year if that column exists
                    //api name displayed to be bold and in text-primary, and if the same sub-section name appears multiple times, display the name only for the first occurrence to avoid redundancy. This is done to maintain clarity while preventing unnecessary repetition of sub-section titles.
                  //  if (strcasecmp($sub['name'], $section['name']) !== 0) echo "<h3 class='h5 text-secondary mt-4 mb-2'>" . htmlspecialchars($sub['name']) . "</h3>";
if (strcasecmp($sub['name'], $section['name']) !== 0) {
                        if ($sub['name'] === 'Membership (Research body/Professional Association)') {
                            echo "<h5 class='h3 fw-bold text-secondary mt-4 mb-2'>" . htmlspecialchars($sub['name']) . "</h5>";
                        } else {
                         //   echo "<h3 class='h5 text-secondary mt-4 mb-2'>" . htmlspecialchars($sub['name']) . "</h3>";
                                                     echo "<h5>" . htmlspecialchars($sub['name']) . "</h5>";

                        }
                    }
               // Headers Logic ehere stripping of hidden columns is done at the time of display, so that the original data structure remains intact for any future processing needs.
                    $headers = $sub['headers']; $labels = array_combine($headers, $headers);
                            if ($sub['name'] === 'ACADEMIC QUALIFICATION') { $headers=['Academic Degree','Subject','University','Address of the University','Rank/ Medals']; $labels=array_combine($headers,$headers); }
                    if ($sub['name'] === 'Eligibility Details') { $headers=['Category','Subject','Status']; $labels=array_combine($headers,$headers); }
                    if ($sub['name'] === 'PG Diploma Details') { $headers=['Programme Name','Main Subject','University Name','Start Date','End Date','Mark / Grade Obtained']; $labels=array_combine($headers,$headers); }
                    if ($section['name'] === 'JOURNAL PUBLICATIONS') { $headers=['Title','Name of Journal','Year','DOI/URL','Your authorial position','How many authors','Clarivate IF']; $labels=$headers; $labels[6]='Clarivate IF'; }
                    if ($sub['name'] === 'PhD Details') { $headers=['Title of Thesis','University / Institution','University Address','Date of Registration','Date of Qualifying PhD','Details of papers published (Enter the total number of papers published / under process as part of Phd)','Current Status']; $labels=array_combine($headers,$headers); $labels['Date of Qualifying PhD']='Date of Completion'; }
                    if ($sub['name'] === 'Presentations') { 
                        $headers=['Title of Paper','Title of Conference','Organized by','Level','Start Date','Place','Country','Duration']; 
                        $labels=array_combine($headers,$headers); $labels['Title of Conference']='Title of Seminar/Conference'; 
                    }
                            if ($sub['name'] === 'Events Organized') {
                        $headers=['Type of Event','Level','Organized by','Date','Name of Event','Duration','Place'];
                        $labels=array_combine($headers,$headers); $labels['Date']='Date From'; $labels['Name of Event']='Title of Event';
                    }
                                     if ($sub['name'] === 'Previous Experience') { 
                        $headers=['Designation','Institution Name','Start Date','End Date']; 
                        $labels=array_combine($headers,$headers); 
                    }
                            if ($sub['name'] === 'Faculty Development Program') { 
                        $headers=['Title of the program','Select Programme','Level','Organized by','Place','Start Date','End Date']; 
                        $labels=array_combine($headers,$headers);
                        $labels['Title of the program'] = 'Title of Event'; $labels['Select Programme'] = 'Type of Event'; $labels['Start Date'] = 'Date From'; $labels['End Date'] = 'Date To';
                    }
                         if ($sub['name'] === 'Resource Persons') { 
                        $headers=['Title of the Program','Role','Level','Organized by','Start Date','Place','Country']; 
                        $labels=array_combine($headers,$headers); 
                    }
   if ($sub['name'] === 'Participation (Seminar, Conference, Workshop)') { 
                        $headers=['Title of Event','Type of Event','Level','Organized by','Start Date','Place','Duration']; 
                        $labels=array_combine($headers,$headers); 
                    }
                       if ($sub['name'] === 'PATENT') { 
                        $headers=['Title','Patent Type','Patent Application Number','Status','Year']; 
                        $labels=array_combine($headers,$headers); 
                    }
                          if ($sub['name'] === 'Membership (Research body/Professional Association)') { 
                        $headers=['Name of the Body','Position','Level','Start Date','End Date','Any other Information']; 
                        $labels=array_combine($headers,$headers); 
                    }
                    echo "<div class='table-responsive mb-4'><table class='table table-bordered table-striped table-hover'>";
                    echo "<thead class='table-primary'><tr>";
                    foreach ($headers as $h) {
                        if (in_array($h, $hidden_cols)) continue;
                        echo "<th>" . htmlspecialchars($labels[$h]??$h) . "</th>";
                    }
                    echo "</tr></thead><tbody>";
                    foreach ($sub['data'] as $row) {
                        echo "<tr>";
                        foreach ($headers as $h) {
                            if (in_array($h, $hidden_cols)) continue;
                            $val = stripslashes($row[$h]??'');
                            $clean_url = trim(preg_replace('/[[:^print:]]/', '', str_replace(' ', '', $val)));
                            if (filter_var($clean_url, FILTER_VALIDATE_URL)) echo '<td><a href="'.$clean_url.'" target="_blank">'.htmlspecialchars($val).'</a></td>';
                            else echo "<td>".htmlspecialchars($val)."</td>";
                        }
                        echo "</tr>";
                    }
                    echo "</tbody></table></div>";
                }
                echo "</div>";
            }
        }
        ?>
    </div>

    <div class="d-flex justify-content-between align-items-end mt-5 pt-3 border-top">
        <div class="qr-area d-none d-print-flex align-items-center gap-3">
            <div id="qrcode"></div>
            <div class="small text-muted">
                <strong>Digital Signature</strong><br>Scan to verify this record.<br>
                <?php if($row && $row['fail_count'] > 0): ?>
                    <span class="text-danger small"><i class="bi bi-exclamation-triangle"></i> Connectivity Limited (Logged Fails: <?php echo $row['fail_count']; ?>)</span>
                <?php endif; ?>
            </div>
        </div>
        <div class="timestamp small text-muted d-none d-print-block">Synced on: <?php echo $lastUpdated; ?></div>
    </div>
</div>

<div class="print-footer d-none d-print-block text-center"><small>St Joseph's University • Faculty Profile</small></div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    new QRCode(document.getElementById("qrcode"), { text: window.location.href, width: 70, height: 70, colorDark : "#333333", colorLight : "#ffffff" });
    document.addEventListener('DOMContentLoaded', function() {
        const tabs = document.querySelectorAll('.tab-button');
        const sects = document.querySelectorAll('.section-content');
        if (tabs.length > 0) {
            function switchTab(tid) {
                sects.forEach(s => s.classList.remove('active'));
                tabs.forEach(t => t.classList.remove('active'));
                const ts = document.querySelector(tid);
                const tb = document.querySelector(`.tab-button[href="${tid}"]`);
                if (ts) ts.classList.add('active');
                if (tb) tb.classList.add('active');
            }
            tabs.forEach(b => b.addEventListener('click', function(e) { e.preventDefault(); switchTab(this.getAttribute('href')); }));
            switchTab(tabs[0].getAttribute('href'));
        }
        const abt = document.querySelector('.about-me-text');
        const rm = document.querySelector('.read-more-link');
        if (abt && rm) {
            if (abt.scrollHeight > abt.clientHeight) rm.style.display = 'inline-block';
            rm.addEventListener('click', function(e) { e.preventDefault(); abt.classList.toggle('expanded'); this.textContent = abt.classList.contains('expanded') ? 'Read Less' : 'Read More'; });
        }
    });
</script>
<script src="assets/js/main.js"></script>
</body>
</html>