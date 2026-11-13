<!doctype html>
<html lang="en" dir="ltr">

<head>
    <?php include $_SERVER['DOCUMENT_ROOT'] . '/gtm.php'; ?>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>SJU University Announcements | St Joseph's University Bangalore</title>
    <link rel="canonical" href="https://www.sju.edu.in/announcements">
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="St Joseph's University, Bengaluru">
    <meta property="og:title" content="SJU University Announcements | St Joseph's University Bangalore">
    <meta property="og:description" content="Explore university announcements from St Joseph's University Bengaluru. Stay updated on notices, academic information, exams, admissions and campus updates.">
    <meta property="og:url" content="https://www.sju.edu.in/announcements">
    <meta property="og:image" content="https://www.sju.edu.in/assets/img/st-joseph-university-logo.png">
    <meta property="og:image:width" content="356">
    <meta property="og:image:height" content="102">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:site" content="@StJosephsUniBLR">
    <meta name="twitter:title" content="SJU University Announcements | St Joseph's University Bangalore">
    <meta name="twitter:description" content="Explore university announcements from St Joseph's University Bengaluru. Stay updated on notices, academic information, exams, admissions and campus updates.">
    <meta name="twitter:image" content="https://www.sju.edu.in/assets/img/st-joseph-university-logo.png">
    <meta name="robots" content="INDEX,FOLLOW">
    <meta name="description" content="Explore university announcements from St Joseph's University Bengaluru. Stay updated on notices, academic information, exams, admissions and campus updates.">
    <meta name="keywords" content="SJU Announcements">
    <meta name="title" content="SJU University Announcements | St Joseph's University Bangalore">

    <!-- Mobile Specific Metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Favicons -->
    <link rel="icon" href="assets/img/favicon.png" type="image/png">
    <link rel="apple-touch-icon" href="assets/img/favicon-apple.png">
    <link rel="manifest" href="assets/img/favicons/manifest.json">
    <meta name="msapplication-TileColor" content="#ffffff">

    <!--==============================
      Google Fonts
    ============================== -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400..900;1,400..900&family=Plus+Jakarta+Sans:ital,wght@0,200..800;1,200..800&family=Urbanist:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Arima:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <!--==============================
        All CSS File
    ============================== -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/fontawesome.min.css">
    <link rel="stylesheet" href="assets/css/magnific-popup.min.css">
    <link rel="stylesheet" href="assets/css/swiper-bundle.min.css">
    <link rel="stylesheet" href="assets/css/style.css?v=2.3">
    <meta http-equiv="Cache-Control" content="public, max-age=86400">
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "BreadcrumbList",
  "itemListElement": [
    {
      "@type": "ListItem",
      "position": 1,
      "name": "Home",
      "item": "https://www.sju.edu.in/"
    },
    {
      "@type": "ListItem",
      "position": 2,
      "name": "About",
      "item": "https://www.sju.edu.in/announcements"
    },
    {
      "@type": "ListItem",
      "position": 3,
      "name": "Announcements",
      "item": "https://www.sju.edu.in/announcements"
    }
  ]
}
</script>
</head>
<body>
    <?php require_once 'header.php'; ?>

<!--BREADCRUMB-->
<section class="breadcrumb-hero text-white">
  <div class="overlay"></div>
  <div class="container">
    <div class="row">
      <div class="col-12">
        <div class="breadcrumb-content text-center">
          <h1 class="page-title mb-2">Announcements</h1>
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb justify-content-center mb-0">
              <li class="breadcrumb-item">
                <a href="/" class="text-white text-decoration-none">Home</a>
              </li>
              <li class="breadcrumb-item active text-warning" aria-current="page">
                Announcements
              </li>
            </ol>
          </nav>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="events-section py-5 px-4">
<?php

// -------------------------------------------------------
// 1. DATABASE CONFIG
// -------------------------------------------------------
$config = file_exists('/home/sjubedu/config.php')
    ? '/home/sjubedu/config.php'
    : __DIR__ . '/../../config.php';
require_once $config;

$pdo = new PDO(
    "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4",
    DB_USER,
    DB_PASS
);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// -------------------------------------------------------
// 2. FETCH CMS ANNOUNCEMENTS
// -------------------------------------------------------
$sql = "SELECT title, slug, description, d_start_date, c_image, d_end_date, c_file_type, c_url
        FROM announcements
        WHERE c_status = 'Y'
        ORDER BY d_start_date DESC";

$stmt = $pdo->prepare($sql);
$stmt->execute();
$cmsRows = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Normalise CMS rows into a unified shape
$cmsAnnouncements = [];
foreach ($cmsRows as $row) {
    $timestamp = strtotime($row['d_start_date']);

    if ($row['c_file_type'] === 'URL') {
        $link = $row['c_url'];
        if (!preg_match("~^(?:f|ht)tps?://~i", $link)) {
            $link = 'https://' . $link;
        }
        $href       = $link;
        $targetBlank = true;
    } else {
        $href       = 'announcement-detail.php?slug=' . urlencode($row['slug']);
        $targetBlank = false;
    }
    
// -------------------------------------------------------
// to add default images for the broken codes
// -------------------------------------------------------
    // ---- Safe image: show default picture if file is missing ----
    $defaultImage = 'https://sjudata.s3.ap-south-1.amazonaws.com/announcements/images/Statue.JPG.jpeg';
    $imgFile      = trim($row['c_image'] ?? '');
    $uploadDir    = '/sju_admin/assets/admin/uploads/announcement/original/';

    if ($imgFile === '') {
        $image = $defaultImage;
    } elseif (preg_match('~^https?://~i', $imgFile)) {
        $image = $imgFile;
    } else {
        $imgFile    = basename($imgFile);
        $serverPath = $_SERVER['DOCUMENT_ROOT'] . $uploadDir . $imgFile;
        $image      = file_exists($serverPath)
            ? $uploadDir . rawurlencode($imgFile)
            : $defaultImage;
    }
    // -------------------------------------------------------
// to add default images for the broken codes
// -------------------------------------------------------
    $cmsAnnouncements[] = [
        'title'       => $row['title'],
        'timestamp'   => $timestamp,
        'date_label'  => date('jS F Y', $timestamp),
        'year'        => date('Y', $timestamp),
        'href'        => $href,
        'target_blank'=> $targetBlank,
        // 'image'       => 'sju_admin/assets/admin/uploads/announcement/original/' . $row['c_image'],
        'image'       => $image,
        'source'      => 'cms',
    ];
}

// -------------------------------------------------------
// 3. HARDCODED ANNOUNCEMENTS (migrated to unified shape)
// -------------------------------------------------------
$hardcodedRaw = [

         [
       'title' => '13 November 2026 : RESULTS - PhD COURSEWORK EXAMINATION - OCTOBER 2026',
      'date'  => '2026-11-13',
      'href'  => 'https://sjudata.s3.ap-south-1.amazonaws.com/Examinations/Exam+Notices/RESULTS+-+PhD+COURSEWORK+EXAMINATION+-+OCTOBER+2026.pdf',
       'image' => 'https://sjudata.s3.ap-south-1.amazonaws.com/announcements/images/sju8.jpeg',
     ], 
      [
       'title' => '02 November 2026 : Readmissions 2026-27',
      'date'  => '2026-11-02',
      'href'  => 'https://www.sju.edu.in/student-support/sjureadmission',
       'image' => 'https://sjudata.s3.ap-south-1.amazonaws.com/announcements/images/sju8.jpeg',
     ], 

       [
       'title' => '22 October 2026 :Notice – Hall Ticket(End Semester October 2026)',
      'date'  => '2026-10-22',
      'href'  => 'https://sjudata.s3.ap-south-1.amazonaws.com/Notice+%E2%80%93+Hall+Ticket(End+Semester+October+2026).pdf',
       'image' => 'https://sjudata.s3.ap-south-1.amazonaws.com/announcements/images/sju8.jpeg',
     ], 

      [
       'title' => '22 October 2026 : Notice-Students-Grievance cell-Hall ticket issues-odd sem exams',
      'date'  => '2026-10-22',
      'href'  => 'https://sjudata.s3.ap-south-1.amazonaws.com/announcements/Notice-Students-Grievance+cell-Hall+ticket+issues-odd+sem+exams.pdf',
       'image' => 'https://sjudata.s3.ap-south-1.amazonaws.com/announcements/images/sju8.jpeg',
     ], 
          [
       'title' => '17 October 2026 : Notice - Special Holiday - Oct 19, 2026',
      'date'  => '2026-10-17',
      'href'  => 'https://sjudata.s3.ap-south-1.amazonaws.com/announcements/Notice+-+Special+Holiday+-+Oct+19%2C+2026.pdf',
       'image' => 'https://sjudata.s3.ap-south-1.amazonaws.com/announcements/images/sju8.jpeg',
     ], 
         [
       'title' => '13 October 2026 : Notice Final-Year Students and Alumni',
      'date'  => '2026-10-13',
      'href'  => 'https://sjudata.s3.ap-south-1.amazonaws.com/Scholarships/notices/Notice+Final-Year+Students+and+Alumni+.pdf',
       'image' => 'https://sjudata.s3.ap-south-1.amazonaws.com/announcements/images/sju10.jpeg',
     ],   

       [
       'title' => '06 October 2026 : Notice-URGENT-Doc verification-Deadline-1st Year UG, PG',
      'date'  => '2026-10-06',
      'href'  => 'https://sjudata.s3.ap-south-1.amazonaws.com/announcements/Notice-URGENT-Doc+verification-Deadline-1st+Year+UG%2C+PG..pdf',
       'image' => 'https://sjudata.s3.ap-south-1.amazonaws.com/announcements/images/sju10.jpeg',
     ],

      [
       'title' => '03 October 2026 :Notice- Attendance - Other Duty - October 2026',
      'date'  => '2026-10-03',
      'href'  => 'https://sjudata.s3.ap-south-1.amazonaws.com/announcements/Notice-+Attendance+-+Other+Duty+-+October+2026.pdf',
       'image' => 'https://sjudata.s3.ap-south-1.amazonaws.com/announcements/images/sju10.jpeg',
     ],

    [
       'title' => '01 July 2026: Inaugural Mass 1 July 2026',
      'date'  => '2026-07-01',
      'href'  => 'https://sjudata.s3.ap-south-1.amazonaws.com/announcements/Inaugural+Mass+1+July+2026.pdf',
       'image' => 'https://sjudata.s3.ap-south-1.amazonaws.com/announcements/images/sju6.jpeg',
     ],
    [
       'title' => '01 July 2026: Notice-Student Council Election-2026-27',
      'date'  => '2026-07-01',
      'href'  => 'https://sjudata.s3.ap-south-1.amazonaws.com/announcements/Notice-Student+Council+Election-2026-27.pdf',
       'image' => 'https://sjudata.s3.ap-south-1.amazonaws.com/announcements/images/sju8.jpeg',
     ],
    [
       'title' => '30 June 2026:7th International Thirukkural Conference',
      'date'  => '2026-06-30',
      'href'  => 'https://sjudata.s3.ap-south-1.amazonaws.com/announcements/7th+International+Thirukkural+Conference.jpeg',
       'image' => 'https://sjudata.s3.ap-south-1.amazonaws.com/announcements/images/sju7.jpeg',
     ],
  [
       'title' => '30 June 2026:Recruitment Ad-Associate HR Manager',
      'date'  => '2026-06-30',
      'href'  => 'https://sjudata.s3.ap-south-1.amazonaws.com/announcements/30+June+2026-Recruitment+Ad-Associate+HR+Manager.pdf',
       'image' => 'https://sjudata.s3.ap-south-1.amazonaws.com/announcements/images/sju8.jpeg',
     ],
 [
       'title' => '30 June 2026: Recruitment Ad-Technical Assistant (CIF) ',
      'date'  => '2026-06-30',
      'href'  => 'https://sjudata.s3.ap-south-1.amazonaws.com/announcements/30+June+2026-Recruitment+Ad-Technical+Assistant+(CIF).pdf',
       'image' => 'https://sjudata.s3.ap-south-1.amazonaws.com/announcements/images/sju9.jpeg',
     ],
 [
       'title' => '30 June 2026: Notification - University Sports Teams Selections (2026-27) ',
      'date'  => '2026-06-30',
      'href'  => 'https://sjudata.s3.ap-south-1.amazonaws.com/announcements/Notification+-+University+Sports+Teams+Selections+(2026-27).pdf',
       'image' => 'https://sjudata.s3.ap-south-1.amazonaws.com/announcements/images/sju10.jpeg',
     ],
  [
       'title' => '29 June 2026: WALK-IN INTERVIEW 2026-27 M.Sc BIG DATA ANALYTICS ',
      'date'  => '2026-06-29',
      'href'  => 'https://sjudata.s3.ap-south-1.amazonaws.com/announcements/Walk-In+Interview+2026-27+MSC+Big+Data+Analytics.jpg',
       'image' => 'https://sjudata.s3.ap-south-1.amazonaws.com/announcements/images/sju7.jpeg',
     ],
    //  [
    //    'title' => '28 June 2026: International conference on Business Dynamics and sustainable Development ',
    //   'date'  => '2026-06-28',
    //   'href'  => 'https://sjudata.s3.ap-south-1.amazonaws.com/announcements/Draft-4+Brochure+Conference+Nov-26-s+(2).pdf',
    //    'image' => 'https://sjudata.s3.ap-south-1.amazonaws.com/announcements/images/sju8.jpeg',
    //  ],
   [
       'title' => '26 June 2026: Notification to all III Semester Undergraduate students to select multidisciplinary elective - reg. ',
      'date'  => '2026-06-26',
      'href'  => 'https://sjudata.s3.ap-south-1.amazonaws.com/announcements/Notice-Sem+III+UG+Students-Multidisciplinary+Elective%2C+2026-27.pdf',
       'image' => 'https://sjudata.s3.ap-south-1.amazonaws.com/announcements/images/sju4.jpeg',
     ],
  [
       'title' => '25 June 2026: Change Of Second Language(L2) - Application Form',
      'date'  => '2026-06-25',
      'href'  => 'https://sjudata.s3.ap-south-1.amazonaws.com/announcements/Change+Of+Second+Language(L2)+-+Application+Form.pdf',
       'image' => 'https://sjudata.s3.ap-south-1.amazonaws.com/announcements/images/sju4.jpeg',
     ],
  [
       'title' => '24 June 2026: Notification - Extension of Last Date for Application and Fee Payment – Convocation and Degree Completion Certificates - From 25.06.2026 - 05.08.2026',
      'date'  => '2026-06-24',
      'href'  => 'https://sjudata.s3.ap-south-1.amazonaws.com/Examinations/Exam+Notices/Notification+-+Extension+of+Last+Date+for+Application+and+Fee+Payment+%E2%80%93+Convocation+and+Degree+Completion+Certificates+-+From+25.06.2026+-+05.08.2026.pdf',
       'image' => 'https://sjudata.s3.ap-south-1.amazonaws.com/announcements/images/Statue.JPG.jpeg',
     ],
   [
       'title' => '24 June 2026: B.Sc.ADMISSIONS_2026-27 ONLINE WALK-IN INTERVIEWS ',
      'date'  => '2026-06-24',
      'href'  => 'https://sjudata.s3.ap-south-1.amazonaws.com/announcements/B.Sc.ADMISSIONS_2026-27+ONLINE+WALK-IN+INTERVIEWS.png',
       'image' => 'https://sjudata.s3.ap-south-1.amazonaws.com/announcements/images/compressed_IMG_0774.JPG.jpeg',
     ],
   [
       'title' => '23 June 2026: Flyer Walk-in Interview_ Statistics ',
      'date'  => '2026-06-23',
      'href'  => 'https://sjudata.s3.ap-south-1.amazonaws.com/announcements/Flyer+Walk-in+Interview_+Statistics.jpeg',
       'image' => 'https://sjudata.s3.ap-south-1.amazonaws.com/announcements/images/sju6.jpeg',
     ],
   [
       'title' => '22 June 2026: SEATING ARRANGEMENT - SPECIAL SUPPLEMENTARY EXAMINATION - JUNE 2026 - 23.06.2026',
      'date'  => '2026-06-22',
      'href'  => 'https://sjudata.s3.ap-south-1.amazonaws.com/Examinations/Exam+Notices/SEATING+ARRANGEMENT+-+SPECIAL+SUPPLEMENTARY+EXAMINATION+-+JUNE+2026+-+23.06.2026.pdf',
       'image' => 'https://sjudata.s3.ap-south-1.amazonaws.com/announcements/images/P12083701.webp',
     ],
  [
       'title' => '21 June 2026: Time table 2026-2027 B Block',
      'date'  => '2026-06-21',
      'href'  => 'https://sjudata.s3.ap-south-1.amazonaws.com/announcements/Block_B_Timetable_Odd+Sem+26-27+(1).pdf',
       'image' => 'https://www.sju.edu.in/sju_admin/assets/admin/uploads/announcement/original/5cd319ad873103ce5530707168b12d20.jpeg',
     ],
    [
       'title' => '21 June 2026: Time Table 2026-2027 main campus ',
      'date'  => '2026-06-21',
      'href'  => 'https://www.sju.edu.in/services/timetable/time-table-2026',
       'image' => 'https://sjudata.s3.ap-south-1.amazonaws.com/announcements/images/Statue.JPG.jpeg',
     ],

  [
      'title' => '21 June 2026: First Year Language Rooms ',
      'date'  => '2026-06-21',
      'href'  => 'https://sjudata.s3.ap-south-1.amazonaws.com/announcements/First+Year+Language+Rooms.pdf',
      'image' => 'https://sjudata.s3.ap-south-1.amazonaws.com/announcements/images/P12083701.webp',
     ],
  
   [
       'title' => '20 June 2026: SEATING ARRANGEMENT - SPECIAL SUPPLEMENTARY EXAMINATION - JUNE 2026 - 22.06.2026 ',
      'date'  => '2026-06-20',
      'href'  => 'https://sjudata.s3.ap-south-1.amazonaws.com/Examinations/Seating+arrangements/SEATING+ARRANGEMENT+-+SPECIAL+SUPPLEMENTARY+EXAMINATION+-+JUNE+2026+-+22.06.2026.pdf',
       'image' => 'https://sjudata.s3.ap-south-1.amazonaws.com/announcements/images/Statue.JPG.jpeg',
     ],
  [
       'title' => '20 June 2026: Notice-- All Teaching Faculty - Commencement of classes & Acade',
      'date'  => '2026-06-20',
      'href'  => 'https://sjudata.s3.ap-south-1.amazonaws.com/announcements/Notice--+All+Teaching+Faculty+-+Commencement+of+classes+%26+Acade.pdf',
       'image' => 'https://sjudata.s3.ap-south-1.amazonaws.com/announcements/images/sju6.jpeg',
     ],
[
       'title' => '18 June 2026: SEATING ARRANGEMENT - SPECIAL SUPPLEMENTARY EXAMINATION - JUNE 2026 - 19.06.2026',
      'date'  => '2026-06-18',
      'href'  => 'https://sjudata.s3.ap-south-1.amazonaws.com/Examinations/Seating+arrangements/SEATING+ARRANGEMENT+-+SPECIAL+SUPPLEMENTARY+EXAMINATION+-+JUNE+2026+-+19.06.2026.pdf',
       'image' => 'https://sjudata.s3.ap-south-1.amazonaws.com/announcements/images/Statue.JPG.jpeg',
     ],
 [
       'title' => '18 June 2026: NATIONAL SERVICE SCHEME ENROLMENT FORM (2026-2027)',
      'date'  => '2026-06-18',
      'href'  => 'https://www.sju.edu.in/services/sju-nss/sju-nss-student-volunteer',
       'image' => 'https://sjudata.s3.ap-south-1.amazonaws.com/nss/NSS+Enrolment+26-27+(1).jpeg',
     ],
   [
       'title' => '17 June 2026: SEATING ARRANGEMENT - SPECIAL SUPPLEMENTARY EXAMINATION - JUNE 2026 - 18.06.2026  ',
      'date'  => '2026-06-17',
      'href'  => 'https://sjudata.s3.ap-south-1.amazonaws.com/Examinations/Seating+arrangements/SEATING+ARRANGEMENT+-+SPECIAL+SUPPLEMENTARY+EXAMINATION+-+JUNE+2026+-+18.06.2026.pdf',
       'image' => 'https://sjudata.s3.ap-south-1.amazonaws.com/announcements/images/Statue.JPG.jpeg',
     ],
    [
       'title' => '17 June 2026: School of IT Orientation Schedule -2026-UG.docx  ',
      'date'  => '2026-06-17',
      'href'  => 'https://sjudata.s3.ap-south-1.amazonaws.com/announcements/School+of+IT+Orientation+Schedule+-2026-UG.docx+.pdf',
       'image' => 'https://sjudata.s3.ap-south-1.amazonaws.com/announcements/images/P12083701.webp',
     ],
   [
       'title' => '17 June 2026: SCMS Student Orientation ',
      'date'  => '2026-06-17',
      'href'  => 'https://sjudata.s3.ap-south-1.amazonaws.com/announcements/SCMS+Student+Orientation+.pdf',
       'image' => 'https://sjudata.s3.ap-south-1.amazonaws.com/announcements/images/SJU1.jpeg',
     ],
   [
       'title' => '17 June 2026: Student Orientation_Physical Sciences',
      'date'  => '2026-06-17',
      'href'  => 'https://sjudata.s3.ap-south-1.amazonaws.com/announcements/Student+Orientation_Physical+Sciences.pdf',
       'image' => 'https://sjudata.s3.ap-south-1.amazonaws.com/announcements/images/sju4.jpeg',
     ],
   [
       'title' => '16 June 2026: SEATING ARRANGEMENT - SPECIAL SUPPLEMENTARY EXAMINATION - JUNE 2026 - 17.06.2026',
      'date'  => '2026-06-16',
      'href'  => 'https://sjudata.s3.ap-south-1.amazonaws.com/Examinations/Seating+arrangements/SEATING+ARRANGEMENT+-+SPECIAL+SUPPLEMENTARY+EXAMINATION+-+JUNE+2026+-+17.06.2026.pdf',
       'image' => 'https://sjudata.s3.ap-south-1.amazonaws.com/announcements/images/sju6.jpeg',
     ],
    //   [
    //    'title' => '16 June 2026: MCA CLASS TIMETABLE 16.06.26 ',
    //   'date'  => '2026-06-16',
    //   'href'  => 'https://sjudata.s3.ap-south-1.amazonaws.com/announcements/MCA+CLASS+TIMETABLE+16.06.26+.pdf',
    //    'image' => 'https://sjudata.s3.ap-south-1.amazonaws.com/announcements/images/Statue.JPG.jpeg',
    //  ],
   [
       'title' => '16 June 2026: Fee Notice 2nd year UG & PG',
      'date'  => '2026-06-16',
      'href'  => 'https://sjudata.s3.ap-south-1.amazonaws.com/announcements/Fee+Notice+2nd+year+UG+%26+PG.pdf',
       'image' => 'https://sjudata.s3.ap-south-1.amazonaws.com/announcements/images/Statue.JPG.jpeg',
     ],
   [
       'title' => 'Programme Schedule_Student Orientation_16th June',
      'date'  => '2026-06-16',
      'href'  => 'https://sjudata.s3.ap-south-1.amazonaws.com/announcements/Programme+Schedule_Student+Orientation_16th+June.pdf',
       'image' => 'https://sjudata.s3.ap-south-1.amazonaws.com/announcements/images/SJU1.jpeg',
     ],
//  [
//        'title' => 'School of Business (Commerce)_SHIFT-III_ODD SEM 2026-2027 ',
//       'date'  => '2026-06-14',
//       'href'  => 'https://sjudata.s3.ap-south-1.amazonaws.com/announcements/School+of+Business+(Commerce)_SHIFT-III_ODD+SEM+2026-2027.pdf',
//        'image' => 'https://www.sju.edu.in/sju_admin/assets/admin/uploads/announcement/original/94fd654cc7be3f88e9349ac563690bfc.webp',
//      ],

//  [
//        'title' => 'School Of Business Odd 26-27 ',
//       'date'  => '2026-06-14',
//       'href'  => 'https://sjudata.s3.ap-south-1.amazonaws.com/announcements/School+Of+Business+Odd+26-27.pdf',
//        'image' => 'https://www.sju.edu.in/sju_admin/assets/admin/uploads/announcement/original/7c208135a16c121fcdc5dee3f766b6a9.jpeg',
//      ],

  // [
  //      'title' => 'School of Chemical Sciences Time Table for AY-26-27-ODD SEM-updated ',
  //     'date'  => '2026-06-14',
  //     'href'  => 'https://sjudata.s3.ap-south-1.amazonaws.com/announcements/School+of+Chemical+Sciences+Time+Table+for+AY-26-27-ODD+SEM-updated.pdf',
  //      'image' => 'https://sjudata.s3.ap-south-1.amazonaws.com/announcements/images/Statue.JPG.jpeg',
  //    ],

  // [
  //      'title' => 'School of Communication and Media Studies UG timetables Odd 26-27',
  //     'date'  => '2026-06-14',
  //     'href'  => 'https://sjudata.s3.ap-south-1.amazonaws.com/announcements/School+of+Communication+and+Media+Studies+UG+timetables+Odd+26-27.pdf',
  //      'image' => 'https://sjudata.s3.ap-south-1.amazonaws.com/announcements/images/Statue.JPG.jpeg',
  //    ],
  // [
  //      'title' => 'School of Humanities and Social Sciences_shift II_Shift I_ODD SEM 2026-27',
  //     'date'  => '2026-06-14',
  //     'href'  => 'https://sjudata.s3.ap-south-1.amazonaws.com/announcements/School+of+Humanities+and+Social+Sciences_shift+II_Shift+I_ODD+SEM+2026-27.pdf',
  //      'image' => 'https://sjudata.s3.ap-south-1.amazonaws.com/announcements/images/Statue.JPG.jpeg',
  //    ],
//  [
//        'title' => 'School of Humanities and Social Sciences_SHIFT-III-ODD SEM TT 2026-27',
//       'date'  => '2026-06-14',
//       'href'  => 'https://sjudata.s3.ap-south-1.amazonaws.com/announcements/School+of+Humanities+and+Social+Sciences_SHIFT-III-ODD+SEM+TT+2026-27.pdf',
//        'image' => 'https://sjudata.s3.ap-south-1.amazonaws.com/announcements/images/Statue.JPG.jpeg',
//      ],
  // [
  //      'title' => 'School of Information Techonology-SHIFT-III -ODD SEM TT-2026-27',
  //     'date'  => '2026-06-14',
  //     'href'  => 'https://sjudata.s3.ap-south-1.amazonaws.com/announcements/School+of+Information+Techonology-SHIFT-III+-ODD+SEM+TT-2026-27.pdf',
  //      'image' => 'https://www.sju.edu.in/sju_admin/assets/admin/uploads/announcement/original/5cd319ad873103ce5530707168b12d20.jpeg',
  //    ],

//  [
//        'title' => 'School of Physical Sciences TT, Odd sem 2026-27',
//       'date'  => '2026-06-14',
//       'href'  => 'https://sjudata.s3.ap-south-1.amazonaws.com/announcements/School+Of+Information+Technology.pdf',
//        'image' => 'https://www.sju.edu.in/sju_admin/assets/admin/uploads/announcement/original/5cd319ad873103ce5530707168b12d20.jpeg',
//      ],
// [
//        'title' => 'School of Information Techonology-SHIFT-III -ODD SEM TT-2026-27 ',
//       'date'  => '2026-06-14',
//       'href'  => 'https://sjudata.s3.ap-south-1.amazonaws.com/announcements/School+of+Information+Techonology-SHIFT-III+-ODD+SEM+TT-2026-27.pdf',
//        'image' => 'https://sjudata.s3.ap-south-1.amazonaws.com/announcements/images/Statue.JPG.jpeg',
//      ],
  [
       'title' => 'School of Physical Sciences TT, Odd sem 2026-27',
      'date'  => '2026-06-14',
      'href'  => 'https://sjudata.s3.ap-south-1.amazonaws.com/announcements/School+of+Physical+Sciences+TT%2C+Odd+sem+2026-27.pdf',
       'image' => 'https://sjudata.s3.ap-south-1.amazonaws.com/announcements/images/compressed_IMG_0774.JPG.jpeg',
     ],
  [
  'title' => 'School of Social Work',
        'date'  => '2026-06-14',
        'href'  => 'https://ap-south-1.console.aws.amazon.com/s3/object/sjudata?region=ap-south-1&prefix=announcements/School+of+Social+Work.pdf',
        'image' => 'https://sjudata.s3.ap-south-1.amazonaws.com/announcements/images/SJU1.jpeg',
    ],
  //   [
  //  'title' => 'Online Walk-in Interviews for Schools of Chemical and Life Sciences',
  //       'date'  => '2026-06-15',
  //       'href'  => 'https://sjudata.s3.ap-south-1.amazonaws.com/announcements/online+walk+-+in++Interview+.pdf',
  //       'image' => 'https://sjudata.s3.ap-south-1.amazonaws.com/announcements/images/P12083701.webp',
  //   ],
   [
   'title' => 'SEATING ARRANGEMENT - SPECIAL SUPPLEMENTARY EXAMINATION - JUNE 2026 - 15.06.2026',
        'date'  => '2026-06-13',
        'href'  => 'https://sjudata.s3.ap-south-1.amazonaws.com/Admissions/Candidate+Shortlisted+2026/SEATING+ARRANGEMENT+-+SPECIAL+SUPPLEMENTARY+EXAMINATION+-+JUNE+2026+-+15.06.2026.pdf',
        'image' => 'https://sjudata.s3.ap-south-1.amazonaws.com/announcements/images/2b51324f7bff72bf1ec4e6aa83085c8d.jpg',
    ],
[
        'title' => 'Special supplementary Timetable For NCC, NSS and SPORTS CANDIDATES June 2026',
        'date'  => '2026-06-12',
        'href'  => 'https://sjudata.s3.ap-south-1.amazonaws.com/Examinations/Exam+Notices/Special+supplementary+Timetable+For+NCC%2C+NSS+and+SPORTS+CANDIDATES+June+2026.pdf',
        'image' => 'https://sjudata.s3.ap-south-1.amazonaws.com/announcements/images/compressed_IMG_0774.JPG.jpeg',
    ],
    // [
    //     'title' => 'Online Walk-in Interview for the School of Chemical Science and School of Life Sciences',
    //     'date'  => '2026-06-11',
    //     'href'  => 'https://sjudata.s3.ap-south-1.amazonaws.com/announcements/walk-in-iterview.jpeg',
    //     'image' => 'https://sjudata.s3.ap-south-1.amazonaws.com/announcements/images/Statue.JPG.jpeg',
    // ],
  // [
  //       'title' => 'Organized',
  //       'date'  => '2026-06-11',
  //       'href'  => 'https://sjudata.s3.ap-south-1.amazonaws.com/announcements/organized+(3).pdf',
  //       'image' => 'https://sjudata.s3.ap-south-1.amazonaws.com/announcements/images/Statue.JPG.jpeg',
  //   ],

     [
        'title' => 'Lectio Brevis - June 2026',
        'date'  => '2026-06-10',
        'href'  => 'https://sjudata.s3.ap-south-1.amazonaws.com/announcements/Lectio+Brevis.jpeg',
        'image' => 'https://sjudata.s3.ap-south-1.amazonaws.com/announcements/images/Statue.JPG.jpeg',
    ],
  [
        'title' => 'Notification - Special Supplementary Examination June 2026',
        'date'  => '2026-06-09',
        'href'  => 'https://sjudata.s3.ap-south-1.amazonaws.com/Examinations/Exam+Notices/Notification+-+Special+Supplementary+Examination+June+2026.pdf',
        'image' => 'https://sjudata.s3.ap-south-1.amazonaws.com/announcements/images/Statue.JPG.jpeg',
    ],
    [
        'title' => 'Special Supplementary JUNE 2026 APPLICATION',
        'date'  => '2026-06-08',
        'href'  => 'https://sjudata.s3.ap-south-1.amazonaws.com/Examinations/Exam+application+forms/Special+Supplementary+JUNE+2026+APPLICATION.pdf',
        'image' => 'https://sjudata.s3.ap-south-1.amazonaws.com/announcements/images/Statue.JPG.jpeg',
    ],
    [
        'title' => 'Hall ticket Special Supplementary examination June 2026',
        'date'  => '2026-06-08',
        'href'  => 'https://sjudata.s3.ap-south-1.amazonaws.com/Examinations/Exam+application+forms/Hall+ticket++Special+Supplementary+examination+June+2026.pdf',
        'image' => 'https://sjudata.s3.ap-south-1.amazonaws.com/announcements/images/Statue.JPG.jpeg',
    ],
    [
        'title' => 'NOTIFICATION - APRIL 2026 – UG, PG, and HONORS APPLICATION FOR PHOTOCOPY, REVALUATION, AND CHALLENGE VALUATION',
        'date'  => '2026-06-08',
        'href'  => 'https://sjudata.s3.ap-south-1.amazonaws.com/Examinations/Exam+Notices/NOTIFICATION+-+APRIL+2026+%E2%80%93+UG%2C+PG%2C+and+HONORS+APPLICATION+FOR+PHOTOCOPY%2C+REVALUATION%2C+AND+CHALLENGE+VALUATION.pdf',
        'image' => 'https://sjudata.s3.ap-south-1.amazonaws.com/announcements/images/Statue.JPG.jpeg',
    ],
    // [
    //     'title' => 'UG_Special supplementary Examination Timetable June 2026',
    //     'date'  => '2026-06-04',
    //     'href'  => 'https://sjudata.s3.ap-south-1.amazonaws.com/Examinations/Exam+Notices/UG_Special+supplementary+Examination+Timetable+June+2026.pdf',
    //     'image' => 'https://www.sju.edu.in/sju_admin/assets/admin/uploads/announcement/original/0153fb5b04d0a9e400b7ad1ba720893e.jpeg',
    // ],
    // [
    //     'title' => 'PG_Special supplementary Examination Timetable June 2026',
    //     'date'  => '2026-06-04',
    //     'href'  => 'https://sjudata.s3.ap-south-1.amazonaws.com/Examinations/Exam+Notices/PG_Special+supplementary+Examination+Timetable+June+2026.pdf',
    //     'image' => 'https://sjudata.s3.ap-south-1.amazonaws.com/announcements/images/Statue.JPG.jpeg',
    // ],
    // [
    //     'title' => 'Honours Programme_Special supplementary Examination Timetable June 2026',
    //     'date'  => '2026-06-04',
    //     'href'  => 'https://sjudata.s3.ap-south-1.amazonaws.com/Examinations/Exam+Notices/Honours+Programme_Special+supplementary+Examination+Timetable+June+2026.pdf',
    //     'image' => 'https://www.sju.edu.in/sju_admin/assets/admin/uploads/announcement/original/7c208135a16c121fcdc5dee3f766b6a9.jpeg',
    // ],
    [
        'title' => 'Additional Credit Notice - June 2026',
        'date'  => '2026-06-03',
        'href'  => 'https://sjudata.s3.ap-south-1.amazonaws.com/Examinations/Exam+Notices/Additional+credit+Notice-June+2026.pdf',
        'image' => 'https://sjudata.s3.ap-south-1.amazonaws.com/announcements/images/Statue.JPG.jpeg',
    ],
    // [
    //     'title' => 'Notification - Special Supplementary Examination June 2026',
    //     'date'  => '2026-06-03',
    //     'href'  => 'https://sjudata.s3.ap-south-1.amazonaws.com/Examinations/Exam+Notices/Notification+-+Special+Supplementary+Examination+June+2026.pdf',
    //     'image' => 'https://www.sju.edu.in/sju_admin/assets/admin/uploads/announcement/original/5cd319ad873103ce5530707168b12d20.jpeg',
    // ],
    [
        'title' => 'Holiday for the Month of June',
        'date'  => '2026-06-02',
        'href'  => 'https://sjudata.s3.ap-south-1.amazonaws.com/announcements/Holiday+for+the+Month+of+June.pdf',
        'image' => 'https://sjudata.s3.ap-south-1.amazonaws.com/announcements/images/Statue.JPG.jpeg',
    ],
];

$hardcodedAnnouncements = [];
foreach ($hardcodedRaw as $item) {
    $timestamp = strtotime($item['date']);
    $hardcodedAnnouncements[] = [
        'title'        => $item['title'],
        'timestamp'    => $timestamp,
        'date_label'   => date('jS F Y', $timestamp),
        'year'         => date('Y', $timestamp),
        'href'         => $item['href'],
        'target_blank' => true,
        'image'        => $item['image'],
        'source'       => 'hardcoded',
    ];
}

// -------------------------------------------------------
// 4. MERGE & DEDUPLICATE
//    Dedupe on (title + date). CMS record wins if duplicate.
// -------------------------------------------------------
$seen   = [];
$merged = [];

// Index CMS entries first so they take precedence
foreach ($cmsAnnouncements as $item) {
    $key = md5(strtolower(trim($item['title'])) . $item['timestamp']);
    $seen[$key]   = true;
    $merged[]     = $item;
}

// Add hardcoded entries only if not already present from CMS
foreach ($hardcodedAnnouncements as $item) {
    $key = md5(strtolower(trim($item['title'])) . $item['timestamp']);
    if (!isset($seen[$key])) {
        $seen[$key] = true;
        $merged[]   = $item;
    }
}

// -------------------------------------------------------
// 5. SORT ALL ENTRIES BY DATE DESCENDING
// -------------------------------------------------------
usort($merged, fn($a, $b) => $b['timestamp'] - $a['timestamp']);

// -------------------------------------------------------
// 6. BUILD YEAR LIST FOR FILTER DROPDOWN
// -------------------------------------------------------
$years = [];
foreach ($merged as $item) {
    $years[$item['year']] = $item['year'];
}
krsort($years); // newest year first

?>

  <div class="container mb-4">
    <div class="row align-items-center">
      <div class="col-lg-6 col-12">
        <h2 class="fw-bold mb-1">Announcements</h2>
      </div>
      <div class="col-lg-3 col-md-4 col-12 ms-lg-auto">
        <select class="form-select year-filter" id="yearFilter">
          <option value="all">Select the year</option>
          <?php foreach ($years as $year): ?>
            <option value="<?php echo htmlspecialchars($year); ?>"><?php echo htmlspecialchars($year); ?></option>
          <?php endforeach; ?>
        </select>
      </div>
    </div>
  </div>

  <!-- Cards -->
  <div class="container">
    <div class="row g-4" id="announcementsGrid">

      <?php foreach ($merged as $item): ?>
        <div class="col-lg-4 col-md-6 event-item" data-year="<?php echo htmlspecialchars($item['year']); ?>">
          <div class="events-card">

            <div class="event-img">
              <img
                src="<?php echo htmlspecialchars($item['image']); ?>"
                alt="<?php echo htmlspecialchars($item['title']); ?>"
                loading="lazy"
              >
            </div>

            <div class="event-content">
              <a
                href="<?php echo htmlspecialchars($item['href']); ?>"
                <?php echo $item['target_blank'] ? 'target="_blank" rel="noopener noreferrer"' : ''; ?>
              >
                <p class="event-date">
                  <i class="fa-regular fa-calendar me-2"></i>
                  <?php echo htmlspecialchars($item['date_label']); ?>
                </p>
                <h5><?php echo htmlspecialchars($item['title']); ?></h5>
              </a>
            </div>

          </div>
        </div>
      <?php endforeach; ?>

    </div>

    <!-- Empty state (shown via JS when filter returns no results) -->
    <div id="noResults" class="text-center py-5 d-none">
      <p class="text-muted fs-5">No announcements found for the selected year.</p>
    </div>

  </div>

</section>

<script>
(function () {
  const filterEl = document.getElementById('yearFilter');
  const noResults = document.getElementById('noResults');

  filterEl.addEventListener('change', function () {
    const selected = this.value;
    const items    = document.querySelectorAll('.event-item');
    let   visible  = 0;

    items.forEach(function (item) {
      const show = selected === 'all' || item.dataset.year === selected;
      item.style.display = show ? '' : 'none';
      if (show) visible++;
    });

    noResults.classList.toggle('d-none', visible > 0);
  });
})();
</script>

<!-- Footer -->
<?php require_once 'footer.php'; ?>

<!-- Bootstrap JS bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<!-- Custom JS -->
<script src="assets/js/main.js"></script>
</body>
</html>
