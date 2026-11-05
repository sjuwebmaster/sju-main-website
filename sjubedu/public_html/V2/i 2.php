<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
/**
 * HARD-CODED FACULTY TEMPLATE
 * Features: Image Placeholder, QR Code, Print Support, Text-Only API Data.
 */

if (!isset($FACULTY_ID)) {
    $FACULTY_ID = "70";
}
require_once 'config.php';
$config = file_exists('/home/sjubedu/config.php') ? '/home/sjubedu/config.php' : __DIR__ . '/../../config.php';
require_once $config;

// --- 2. GLOBAL TRACKER INJECTION ---
// This is your Global Security & Tracker Bridge. 
// It must stay here to catch your iPhone's IPv6 address.
if (file_exists('/home/sjubedu/public_html/global_tracker.php')) {
    require_once('/home/sjubedu/public_html/global_tracker.php');
}

// Caching Configuration
$cache_dir = $CACHE_DIR;
$cache_file = $cache_dir . '/faculty_' . $FACULTY_ID . '.json';
$cache_time = 1200; // Cache for 20 minutes (1200 seconds)

$staff_data = [];
$data = [];
// Check if cache exists and is fresh
if (file_exists($cache_file) && (time() - filemtime($cache_file) < $cache_time)) {
    $cached_content = json_decode(file_get_contents($cache_file), true);
    if ($cached_content) {
        $staff_data = $cached_content['staff'];
        $data = $cached_content['reports'];
    }
} else {
    // Fetch Name from Staff API
    $staff_url = "https://sjuv4.linways.com/api/v1/staffs/" . urlencode($FACULTY_ID);
    $staff_ch = curl_init();
    curl_setopt($staff_ch, CURLOPT_URL, $staff_url);
    curl_setopt($staff_ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($staff_ch, CURLOPT_HTTPHEADER, ["Authorization: $API_TOKEN", "Accept: application/json"]);
    curl_setopt($staff_ch, CURLOPT_SSL_VERIFYPEER, false);
    $staff_response = curl_exec($staff_ch);
    $staff_data = json_decode($staff_response, true);
    curl_close($staff_ch);

    // Fetch data from Linways
    $api_url = "https://sjuv4.linways.com/api/v1/exat2/reports/FxNRR5E7W56PzBizk/" . urlencode($FACULTY_ID);
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $api_url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ["Authorization: $API_TOKEN", "Accept: application/json"]);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Fix for local SSL certificate issues
    $response = curl_exec($ch);

    if ($response === false) {
        die('Curl error: ' . curl_error($ch));
    }
    $data = json_decode($response, true);
    curl_close($ch);

    // Save to cache
    if (!is_dir($cache_dir)) {
        mkdir($cache_dir, 0755, true);
    }
    file_put_contents($cache_file, json_encode(['staff' => $staff_data, 'reports' => $data]));
}

// Uncomment the following line to debug the raw API response if data is still missing
// echo "<div style='background:#f8d7da; color:#721c24; padding:20px; border:1px solid #f5c6cb; margin-top: 20px;'>";
// echo "<h3>Profile API Debugger</h3>";
// echo "<strong>HTTP Status:</strong> " . $http_code . "<br>";
// echo "<strong>Raw Response:</strong> " . htmlspecialchars($response) . "<br>";
// echo "<pre>" . print_r($data, true) . "</pre>";
// echo "</div>"; exit;

// The main data is nested inside the 'data' key
$sections = $data['data'] ?? [];

// Rename "AWARDS,ACHIEVEMENTS" to "Awards"
foreach ($sections as &$section) {
    if ($section['name'] === 'AWARDS,ACHIEVEMENTS' || $section['name'] === 'Awards, Achievements') {
        $section['name'] = 'Awards';
    }
}
unset($section);
// Merge PROFESSIONAL QUALIFICATION and PHD DETAILS into ACADEMIC QUALIFICATION
$academicKey = null;
$professionalKey = null;
$phdKey = null;

foreach ($sections as $key => $section) {
    if ($section['name'] === 'ACADEMIC QUALIFICATION') {
        $academicKey = $key;
    } elseif ($section['name'] === 'PROFESSIONAL QUALIFICATION') {
        $professionalKey = $key;
    } elseif ($section['name'] === 'PHD DETAILS') {
        $phdKey = $key;
    }
}

if ($academicKey !== null) {
    if ($professionalKey !== null) {
        $sections[$academicKey]['data'] = array_merge($sections[$academicKey]['data'], $sections[$professionalKey]['data']);
        unset($sections[$professionalKey]);
    }
    if ($phdKey !== null) {
        $sections[$academicKey]['data'] = array_merge($sections[$academicKey]['data'], $sections[$phdKey]['data']);
        unset($sections[$phdKey]);
    }
    $sections = array_values($sections);
}

// Extract "Participation (Seminar, Conference, Workshop)" to its own section
$participationData = null;
foreach ($sections as $sKey => &$section) {
    if (!empty($section['data'])) {
        foreach ($section['data'] as $subKey => $subsection) {
            if (trim($subsection['name']) === 'Participation (Seminar, Conference, Workshop)') {
                if ($participationData === null) {
                    $participationData = $subsection;
                } else {
                    $participationData['data'] = array_merge($participationData['data'], $subsection['data']);
                }
                // Remove from original location
                unset($section['data'][$subKey]);
            }
        }
        // Re-index array to avoid gaps
        $section['data'] = array_values($section['data']);
    }
}
unset($section);

if ($participationData) {
    $sections[] = [
        'id' => 'participation_section',
        'name' => 'Participation',
        'type' => 'section',
        'data' => [$participationData]
    ];
}

/**
 * Helper function to find a specific section's data array.
 * @param array $sections The array of all sections.
 * @param string $section_name The name of the section to find.
 * @param string $subsection_name The name of the subsection to find.
 * @return array The data array of the found subsection, or an empty array.
 */
function find_section_data($sections, $section_name, $subsection_name) {
    foreach ((array)$sections as $section) {
        if (isset($section['name']) && $section['name'] === $section_name) {
            foreach ((array)$section['data'] as $subsection) {
                if (isset($subsection['name']) && $subsection['name'] === $subsection_name) {
                    return $subsection['data'] ?? [];
                }
            }
        }
    }
    return [];
}

/**
 * Helper function to convert string to Title Case.
 */
function toTitleCase($string) {
    // Capitalize first letter of every word, handling common delimiters
    return ucwords(strtolower($string), " \t\r\n\f\v/-");
}

// --- Data Extraction ---

// 1. Extract data from Staff API
if (!isset($salutation)) {
    $salutation = "Dr";
}
$name = $salutation . " " . toTitleCase(stripslashes($staff_data['name'] ?? 'N/A'));
$employee_code = $staff_data['code'] ?? 'N/A';
$specialization = stripslashes(trim($staff_data['fieldOfSpecialization'] ?? ''));
if ($specialization === 'N/A') $specialization = '';
$email = $staff_data['email'] ?? '';
$about_me_data = find_section_data($sections, 'ABOUT ME', 'About Me');
$about_me = stripslashes($about_me_data[0]['About Me'] ?? '');
$research_ids_data = find_section_data($sections, 'RESEARCH IDs', 'Research ids');
$vidwan_id = $research_ids_data[0]['Vidwan'] ?? '';

// --- Profile Photo Logic ---
// If profile photo is not set by the parent file, use default
if (!isset($profile_photo) || empty($profile_photo)) {
    $profile_photo = "https://via.placeholder.com/140x160?text=No+Image"; 
}

// 2. Extract Designation
if (!isset($designation)) {
    $designation = 'Associate Professor';
}

// 3. Extract Department
if (!isset($department)) {
    $department = 'Physics';
}

date_default_timezone_set('Asia/Kolkata');
$lastUpdated = date("d M Y, h:i A");
?>

<!doctype html>
<html class="no-js " lang="zxx" dir="ltr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
<!--        <title><?php echo $name; ?> - Profile</title> -->
    <title>St Joseph's University</title>


    <!-- Favicons - Place favicon.ico in the root directory -->
    <link rel="icon" href="assets/img/favicon.png" type="image/png">
    <link rel="apple-touch-icon" href="assets/img/favicon-apple.png">
    <link rel="manifest" href="assets/img/favicons/manifest.json">
    <meta name="msapplication-TileColor" content="#ffffff">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400..900;1,400..900&family=Plus+Jakarta+Sans:ital,wght@0,200..800;1,200..800&family=Urbanist:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Arima:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <!-- All CSS File -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <!-- Main site style -->
    <link rel="stylesheet" href="assets/css/style.css?v=2.3">
    <!-- Profile page specific style -->
    <link rel="stylesheet" href="style.css">
    <style>
        .section-content {
            display: none;
            animation: fadeIn 0.5s;
        }
        .section-content.active {
            display: block;
        }
        .tab-button.active {
            background-color: var(--bs-primary) !important;
            color: white !important;
            border-color: var(--bs-primary) !important;
        }
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        @media print {
            @page {
                size: A4;
                margin: 10mm;
            }
            html, body {
                zoom: 90%;
            }
            .container {
                width: 100% !important;
                max-width: 100% !important;
                padding: 0 !important;
            }
            .section-content {
                display: block !important;
                opacity: 1 !important;
                visibility: visible !important;
                animation: none !important;
            }
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
                <?php if (!empty($specialization)): ?>
                    <p class="mb-1"><i class="fas fa-graduation-cap me-2 text-primary"></i><?php echo htmlspecialchars($specialization); ?></p>
                <?php endif; ?>
                <?php if (!empty($email)): ?>
                    <p class="mb-1"><i class="fas fa-envelope me-2 text-primary"></i><a href="mailto:<?php echo htmlspecialchars($email); ?>" class="text-decoration-none"><?php echo htmlspecialchars($email); ?></a></p>
                <?php endif; ?>
                <?php if (!empty($vidwan_id)): ?>
             <!--       <p class="mb-0"><strong>Vidwan Profile:</strong> <a href="https://vidwan.inflibnet.ac.in/profile/<?php echo htmlspecialchars($vidwan_id); ?>" target="_blank" class="text-decoration-none"><?php echo htmlspecialchars($vidwan_id); ?></a></p>-->
                 <p class="mb-0"><i class="fas fa-id-badge me-2 text-primary"></i><a href="https://vidwan.inflibnet.ac.in/profile/<?php echo htmlspecialchars($vidwan_id); ?>" target="_blank" class="text-decoration-none"><?php echo htmlspecialchars($vidwan_id); ?></a></p>
  
             <?php endif; ?>

            </div>
        </div>

    <div class="content">
        <?php
        if (!empty($about_me)) {
            echo '<h2 class="text-primary border-bottom pb-2 mb-3">About Me</h2>';
            echo '<div class="about-me-wrapper mb-4">';
            echo '<p class="about-me-text text-justify">' . htmlspecialchars($about_me) . '</p>';
            echo '<a href="#" class="read-more-link text-decoration-none fw-bold">Read More</a>';
            echo '</div>';
        }

        // Create navigation buttons for each section
        echo '<div class="d-flex flex-wrap gap-2 mb-4 border-bottom pb-3 d-print-none">';
        if (!empty($sections)) {
            foreach ($sections as $section) {
                if ($section['name'] === 'ABOUT ME' || $section['name'] === 'ACADEMIC POSITION' || $section['name'] === 'COLLABORATIONS' || $section['name'] === 'AT SJC' || $section['name'] === 'CERTIFICATE COURSES CONDUCTED') continue;  //removed
                $hasData = false;
                foreach ($section['data'] as $sub) {
                    if ($sub['name'] === 'Contribution through Committees') continue; // removed
                    if ($sub['name'] === 'Extra and Co-curricular Details') continue; // removed
                    if ($sub['name'] === 'Extension') continue; // removed
                    if (!empty($sub['data'])) {
                        $hasData = true;
                        break;
                    }
                }
                if ($hasData) {
                    $section_id = 'section-' . preg_replace('/[^a-z0-9]+/', '-', strtolower($section['name']));
                    echo '<a href="#' . $section_id . '" class="btn btn-light border tab-button">' . htmlspecialchars(toTitleCase($section['name'])) . '</a>';
                }
            }
        }
        echo '</div>';

        // Render section tables
        $hidden_columns = ['Name of Institution', 'Position', 'Publons id', 'LinkedIn id'];

        if (!empty($sections)) {
            foreach ($sections as $section) {
                if ($section['name'] === 'ABOUT ME' || $section['name'] === 'ACADEMIC POSITION' || $section['name'] === 'COLLABORATIONS' || $section['name'] === 'AT SJC' || $section['name'] === 'CERTIFICATE COURSES CONDUCTED') continue;
                // Check if section has any data
                $hasData = false;
                foreach ($section['data'] as $sub) {
                    if ($sub['name'] === 'Contribution through Committees') continue;
                    if ($sub['name'] === 'Extra and Co-curricular Details') continue;
                    if ($sub['name'] === 'Extension') continue;
                    if (!empty($sub['data'])) {
                        $hasData = true;
                        break;
                    }
                }
                
                if ($hasData) {
                    $section_id = 'section-' . preg_replace('/[^a-z0-9]+/', '-', strtolower($section['name']));
                    echo "<div id='" . $section_id . "' class='section-content'>";
                    echo "<h2 class='text-primary border-bottom pb-2 mb-3 mt-4'>" . htmlspecialchars(toTitleCase($section['name'])) . "</h2>";
                    $subsection_count = 0;
                    foreach ($section['data'] as $subsection) {
                        if (empty($subsection['data']) || $subsection['name'] === 'Contribution through Committees' || $subsection['name'] === 'Extra and Co-curricular Details' || $subsection['name'] === 'Extension') continue;
                        
                        // Safeguard: Skip Participation if it's not in the Participation section
                        if (trim($subsection['name']) === 'Participation (Seminar, Conference, Workshop)' && $section['name'] !== 'Participation') continue;
                        
                        if ($section['name'] === 'ACADEMIC QUALIFICATION' && $subsection_count > 0) {
                            echo '<hr class="my-4 border-secondary">';
                        }
                        $subsection_count++;
                        
                        // Sort by Year descending if column exists
                        if (in_array('Year', $subsection['headers'])) {
                            usort($subsection['data'], function($a, $b) {
                                return strnatcmp($b['Year'] ?? '', $a['Year'] ?? '');
                            });
                        }
                        
                        // Only show subsection title if it's different from section title
                        if (strcasecmp($subsection['name'], $section['name']) !== 0) {
                            echo "<h3 class='h5 text-secondary mt-4 mb-2'>" . htmlspecialchars($subsection['name']) . "</h3>";
                        }
                        
                        // Define custom column order/labels for specific sections
                        $display_headers = $subsection['headers'];
                        $header_labels = array_combine($display_headers, $display_headers);

                        // Custom mapping for Eligibility Details
                        if ($subsection['name'] === 'Eligibility Details') {
                            $custom_map = [
                                'Category' => 'Category',
                                'Subject' => 'Subject',
                                'Status' => 'Status'
                            ];
                            $display_headers = array_keys($custom_map);
                            foreach ($custom_map as $key => $label) {
                                $header_labels[$key] = $label;
                            }
                        }

                        // Custom mapping for PG Diploma Details
                        if ($subsection['name'] === 'PG Diploma Details') {
                            $custom_map = [
                                'Programme Name' => 'Programme Name',
                                'Main Subject' => 'Main Subject',
                                'University Name' => 'University Name',
                                'Start Date' => 'Start Date',
                                'End Date' => 'End Date',
                                'Mark / Grade Obtained' => 'Mark / Grade Obtained'
                            ];
                            $display_headers = array_keys($custom_map);
                            foreach ($custom_map as $key => $label) {
                                $header_labels[$key] = $label;
                            }
                        }

// Custom mapping for JOURNAL PUBLICATIONS
                        if ($section['name'] === 'JOURNAL PUBLICATIONS') {
                            $custom_map = [
                                'Title' => 'Title',
                                'Name of Journal' => 'Journal Name',
                                'Year' => 'Year',
                                'DOI/URL' => 'DOI/URL',
                                'Your authorial position' => 'Your authorial position',
                                'How many authors' => 'How many authors',
                                'Impact Factor/Citation Index' => 'Clarivate IF'
                            ];
                            $display_headers = array_keys($custom_map);
                            foreach ($custom_map as $key => $label) {
                                $header_labels[$key] = $label;
                            }
                        }
                        // Custom mapping for PHD DETAILS
                        if ($subsection['name'] === 'PhD Details') {
                            $custom_map = [
                                'Title of Thesis' => 'Title of Thesis',
                                'University / Institution' => 'University / Institution',
                                'University Address' => 'University Address',
                                'Date of Registration' => 'Date of Registration',
                                'Date of Qualifying PhD' => 'Date of Completion',
                                'Details of papers published (Enter the total number of papers published / under process as part of Phd)' => 'Details of papers published (Enter the total number of papers published / under process as part of Phd)',
                                'Current Status' => 'Current Status'
                            ];
                            $display_headers = array_keys($custom_map);
                            foreach ($custom_map as $key => $label) {
                                $header_labels[$key] = $label;
                            }
                        }
                        
                        // Custom mapping for Events Organized
                        if ($subsection['name'] === 'Events Organized') {
                            $custom_map = [
                                'Type of Event' => 'Type of Event',
                                'Level' => 'Level',
                                'Organized by' => 'Organized by',
                                'Date' => 'Date From',
                                'Name of Event' => 'Title of Event',
                                'Duration' => 'Duration',
                                'Place' => 'Place'
                            ];
                            $display_headers = array_keys($custom_map);
                            foreach ($custom_map as $key => $label) {
                                $header_labels[$key] = $label;
                            }
                        }

                        // Custom mapping for Participation (Seminar, Conference, Workshop)
                        if ($subsection['name'] === 'Participation (Seminar, Conference, Workshop)') {
                            $custom_map = [
                                'Title of Event' => 'Title of Event',
                                'Type of Event' => 'Type of Event',
                                'Level' => 'Level',
                                'Organized by' => 'Organized by',
                                'Start Date' => 'Start Date',
                                'Place' => 'Place',
                                'Duration' => 'Duration'
                            ];

                            $display_headers = array_keys($custom_map);
                            foreach ($custom_map as $key => $label) {
                                $header_labels[$key] = $label;
                            }
                        }
                        
                        // Custom mapping for RESEARCH PROJECTS -> Projects
                        if ($subsection['name'] === 'Projects') {
                            $custom_map = [
                                'Title of Project' => 'Title of Project',
                                'Type of Project' => 'Category',
                                'Level' => 'Level',
                                'Department' => 'Department',
                                'Current Status' => 'Current Status',
                                'Principal Investigator' => 'Principal Investigator',
                                'Funding Agency' => 'Funding Agency',
                                'Project Start Date' => 'Project Start Date',
                                'Project End Date' => 'Project End Date',
                                'Amount' => 'Amount'
                            ];
                            $display_headers = array_keys($custom_map);
                            foreach ($custom_map as $key => $label) {
                                $header_labels[$key] = $label;
                            }
                        }

                        // Custom mapping for PAPER PRESENTATIONS -> Presentations
                        if ($subsection['name'] === 'Presentations') {
                            $custom_map = [
                                'Title of Paper' => 'Title of Paper',
                                'Title of Conference' => 'Title of Seminar/Conference',
                                'Organized by' => 'Organized by',
                                'Level' => 'Level',
                                'Start Date' => 'Start Date',
                                'Place' => 'Place',
                                'Country' => 'Country',
                                'Duration' => 'Duration'
                            ];
                            $display_headers = array_keys($custom_map);
                            foreach ($custom_map as $key => $label) {
                                $header_labels[$key] = $label;
                            }
                        }

                        // Custom mapping for PREVIOUS WORK EXPERIENCE -> Previous Experience
                        if ($subsection['name'] === 'Previous Experience') {
                            $custom_map = [
                                'Designation' => 'Designation',
                                'Institution Name' => 'Institution Name',
                                'Start Date' => 'Start Date',
                                'End Date' => 'End Date'
                            ];
                            $display_headers = array_keys($custom_map);
                            foreach ($custom_map as $key => $label) {
                                $header_labels[$key] = $label;
                            }
                        }

                        // Custom mapping for FACULTY DEVELOPMENT PROGRAM -> Faculty Development Program
                        if ($subsection['name'] === 'Faculty Development Program') {
                            $custom_map = [
                                'Title of the program' => 'Title of Event',
                                'Select Programme' => 'Type of Event',
                                'Level' => 'Level',
                                'Organized by' => 'Organized by',
                                'Place' => 'Place',
                                'Start Date' => 'Date From',
                                'End Date' => 'Date To'
                            ];
                            $display_headers = array_keys($custom_map);
                            foreach ($custom_map as $key => $label) {
                                $header_labels[$key] = $label;
                            }
                        }

                        $tbl_class = 'table-' . preg_replace('/[^a-z0-9]+/', '-', strtolower($subsection['name']));
                        echo "<div class='table-responsive mb-4'>";
                        echo "<table class='table table-bordered table-striped table-hover " . $tbl_class . "'>";
                        echo "<thead class='table-primary'><tr>";
                        foreach ($display_headers as $header) {
                            if (in_array($header, $hidden_columns)) continue;
                            $label = $header_labels[$header] ?? $header;
                            echo "<th>" . htmlspecialchars(stripslashes($label)) . "</th>";
                        }
                        echo "</tr></thead>";
                        echo "<tbody>";
                        foreach ($subsection['data'] as $row) {
                            echo "<tr>";
                            foreach ($display_headers as $header) {
                                if (in_array($header, $hidden_columns)) continue;
                                $val = stripslashes($row[$header] ?? '');

                                // Clean up potential URLs before validation
                                $potential_url = str_replace(' ', '', $val); // Remove spaces that might break validation
                                $potential_url = preg_replace('/[[:^print:]]/', '', $potential_url); // Remove non-printable chars like zero-width spaces
                                $trimmed_val = trim($potential_url);

                                // Check if the value is a URL and make it clickable
                                if (filter_var($trimmed_val, FILTER_VALIDATE_URL)) {
                                    echo '<td><a href="' . htmlspecialchars($trimmed_val) . '" target="_blank" rel="noopener noreferrer">' . htmlspecialchars($val) . '</a></td>';
                                } else {
                                    echo "<td>" . htmlspecialchars($val) . "</td>";
                                }
                            }
                            echo "</tr>";
                        }
                        echo "</tbody>";
                        echo "</table>";
                        echo "</div>";
                    }
                    echo "</div>";
                }
            }
        } else {
            echo "<p>No profile data available.</p>";
        }
        ?>
    </div>

    <div class="d-flex justify-content-between align-items-end mt-5 pt-3 border-top">
        <div class="qr-area d-none d-print-flex align-items-center gap-3">
            <div id="qrcode"></div>
            <div class="small text-muted">
                <strong>Digital Signature</strong><br>
                Scan to verify this record.
            </div>
        </div>
        <div class="timestamp small text-muted d-none d-print-block">
            Synced on: <?php echo $lastUpdated; ?>
        </div>
    </div>
</div>

<div class="print-footer d-none d-print-block text-center">
    <small>St Joseph's University • Faculty Profile</small>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Automatically generates QR for the hard-coded URL
    new QRCode(document.getElementById("qrcode"), {
        text: window.location.href,
        width: 70,
        height: 70,
        colorDark : "#333333",
        colorLight : "#ffffff"
    });

    document.addEventListener('DOMContentLoaded', function() {
        const tabButtons = document.querySelectorAll('.tab-button');
        const sections = document.querySelectorAll('.section-content');

        if (tabButtons.length > 0) {
            // Function to switch tabs
            function switchTab(targetId) {
                // Hide all sections and remove active class from buttons
                sections.forEach(section => section.classList.remove('active'));
                tabButtons.forEach(button => button.classList.remove('active'));

                // Show the target section and set its button to active
                const targetSection = document.querySelector(targetId);
                const targetButton = document.querySelector(`.tab-button[href="${targetId}"]`);

                if (targetSection) {
                    targetSection.classList.add('active');
                }
                if (targetButton) {
                    targetButton.classList.add('active');
                }
            }

            // Add click event listeners to buttons
            tabButtons.forEach(button => {
                button.addEventListener('click', function(event) {
                    event.preventDefault(); // Prevent default anchor jump
                    const targetId = this.getAttribute('href');
                    switchTab(targetId);
                });
            });

            // Activate the first tab by default
            const firstButton = tabButtons[0];
            if (firstButton) {
                const firstTargetId = firstButton.getAttribute('href');
                switchTab(firstTargetId);
            }
        }

        // About Me Read More logic
        const aboutMeText = document.querySelector('.about-me-text');
        const readMoreLink = document.querySelector('.read-more-link');

        if (aboutMeText && readMoreLink) {
            if (aboutMeText.scrollHeight > aboutMeText.clientHeight) {
                readMoreLink.style.display = 'inline-block';
            }
            readMoreLink.addEventListener('click', function(e) {
                e.preventDefault();
                aboutMeText.classList.toggle('expanded');
                this.textContent = aboutMeText.classList.contains('expanded') ? 'Read Less' : 'Read More';
            });
        }
    });
</script>
<!-- Main site JS -->
<script src="assets/js/main.js"></script>

</body>
</html>