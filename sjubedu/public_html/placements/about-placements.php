<!doctype html>
<html lang="en" dir="ltr">

<head>
    <?php include $_SERVER['DOCUMENT_ROOT'] . '/gtm.php'; ?>
	
	<style>
.company-grid {
    background:#f6f6f6;
}

.company-card {
    background:#fff;
    border:1px solid #e3e3e3;
    height:160px;
    display:flex;
    align-items:center;
    justify-content:center;
    padding:20px;
    transition:all .3s ease;
}

.company-card img{
    max-width:140px;
    max-height:70px;
    object-fit:contain;
}

.company-card:hover{
    box-shadow:0 8px 20px rgba(0,0,0,0.08);
    transform:translateY(-3px);
}
</style>
	
	
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Placement Cell | St Joseph's University, Bengaluru</title>
    <meta name="description" content="Explore Placement Cell at St Joseph's University, Bengaluru — campus recruitment, industry partnerships, internships and career development for students.">
    <meta name="keywords" content="placements St Joseph's University Bengaluru, campus recruitment SJU Bangalore, college placements Karnataka, SJU career services, placement cell Bengaluru university">
    <meta name="robots" content="INDEX,FOLLOW">
    <link rel="canonical" href="https://www.sju.edu.in/placements/about-placements">

    <!-- Open Graph / Social Sharing -->
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="St Joseph's University, Bengaluru">
    <meta property="og:title" content="Placement Cell | St Joseph's University, Bengaluru">
    <meta property="og:description" content="Explore Placement Cell at St Joseph's University, Bengaluru — campus recruitment, industry partnerships, internships and career development for students.">
    <meta property="og:url" content="https://www.sju.edu.in/placements/about-placements">
    <meta property="og:image" content="https://www.sju.edu.in/assets/img/st-joseph-university-logo.png">
    <meta property="og:image:width" content="200">
    <meta property="og:image:height" content="200">
    <meta name="twitter:card" content="summary">
    <meta name="twitter:site" content="@StJosephsUniBLR">
    <meta name="twitter:title" content="Placement Cell | St Joseph's University, Bengaluru">
    <meta name="twitter:description" content="Explore Placement Cell at St Joseph's University, Bengaluru — campus recruitment, industry partnerships, internships and career development for students.">
    <meta name="twitter:image" content="https://www.sju.edu.in/assets/img/st-joseph-university-logo.png">

    <!-- Mobile Specific Metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Favicons - Place favicon.ico in the root directory -->
    <link rel="icon" href="../assets/img/favicon.png" type="image/png">
    <!-- Apple Touch Icon (for iOS home screen) -->
    <link rel="apple-touch-icon" href="../assets/img/favicon-apple.png">
    <link rel="manifest" href="../studentsupport/assets/img/favicons/manifest.json">
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
    <!-- Bootstrap -->
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <!-- Fontawesome Icon -->
    <link rel="stylesheet" href="../assets/css/fontawesome.min.css">
    <!-- Magnific Popup -->
    <link rel="stylesheet" href="../assets/css/magnific-popup.min.css">
    <!-- Swiper Js -->
    <link rel="stylesheet" href="../assets/css/swiper-bundle.min.css">
    <!-- Theme Custom CSS -->
    <link rel="stylesheet" href="../assets/css/style.css?v=2.3">
 <!--   <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
    <meta http-equiv="Pragma" content="no-cache" />
    <meta http-equiv="Expires" content="0" /> -->

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
      "name": "Student Support",
      "item": "https://www.sju.edu.in/placements"
    },
    {
      "@type": "ListItem",
      "position": 3,
      "name": "Placement Cell",
      "item": "https://www.sju.edu.in/placements/about-placements"
    }
  ]
}
</script>
</head>
<body>
    <?php require_once '../header.php';
    
    ini_set('display_errors', 1); 
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$config = file_exists('/home/sjubedu/config.php') ? '/home/sjubedu/config.php' : __DIR__ . '/../../config.php';
require_once $config;
$pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4", DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

date_default_timezone_set('Asia/Kolkata');

$today = date('Y-m-d');


$status = 'Y';
$sql = "SELECT c_image FROM sliders WHERE c_status = :status 
        ORDER BY id ASC";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':status', $status);
$stmt->execute();

    
    ?>
    
<!--BREADCRUMB-->
 <section class="breadcrumb-hero text-white">
  <div class="overlay"></div>
  <div class="container">
    <div class="row">
      <div class="col-12">
        <div class="breadcrumb-content text-center">
          <h1 class="page-title mb-2">Placement Cell</h1>
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb justify-content-center mb-0">
              <li class="breadcrumb-item">
                <a href="/" class="text-white text-decoration-none">Home</a>
              </li>
              <li class="breadcrumb-item">
                <a href="#" class="text-white text-decoration-none">Student Support</a>
              </li>
              <li class="breadcrumb-item active text-warning" aria-current="page">
                Placement Cell
              </li>
            </ol>
          </nav>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Placement Cell Banner Slider -->
<section class="placement-banner-slider position-relative">
  <div id="placementBannerCarousel" class="carousel slide carousel-fade" data-bs-ride="carousel" data-bs-interval="4000">
    <div class="carousel-inner">
      <div class="carousel-item active">
        <img src="images/Slide2.jpg" class="d-block w-100" alt="Companies for Placements">
      </div>
      <div class="carousel-item">
        <img src="images/IMG20250205181142.jpg" class="d-block w-100" alt="Placement Cell - Offer Letter Distribution">
      </div>
      <div class="carousel-item">
        <img src="images/IMG20250206103931.jpg" class="d-block w-100" alt="Placement Cell - Training Session">
      </div>
    </div>

    <button class="carousel-control-prev" type="button" data-bs-target="#placementBannerCarousel" data-bs-slide="prev">
      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#placementBannerCarousel" data-bs-slide="next">
      <span class="carousel-control-next-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Next</span>
    </button>

    <div class="carousel-indicators">
      <button type="button" data-bs-target="#placementBannerCarousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
      <button type="button" data-bs-target="#placementBannerCarousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
      <button type="button" data-bs-target="#placementBannerCarousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
    </div>
  </div>
</section>
<style>
.placement-banner-slider .carousel-item img {
  height: 480px;
  object-fit: cover;
}
@media (max-width: 767px) {
  .placement-banner-slider .carousel-item img {
    height: 220px;
  }
}
</style>

<!--Announcements-->
<section>
    <div class="announcement" role="region" aria-label="University announcement">
  <div class="announcement__icon" aria-hidden="true">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round">
      <path d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6 6 0 10-12 0v3.159c0 .538-.214 1.055-.595 1.436L4 17h11z"/>
      <path d="M13.73 21a2 2 0 01-3.46 0"/>
    </svg>
  </div>
  <div class="announcement__title">Announcements</div>
  <div class="announcement__scroll">
    <div class="announcement__track">

    <?php

    $status = 'Y';
$department="Homepage";
$sql = "SELECT n.title, n.slug, n.d_start_date
        FROM announcements n
        JOIN announcement_departments nd ON n.id = nd.announcement_id
        WHERE nd.c_department = :department
        AND n.c_status = :status
        AND n.d_end_date >= :today
        ORDER BY n.d_end_date DESC";

$stmt = $pdo->prepare($sql);
$stmt->bindParam(':department', $department);
$stmt->bindParam(':status', $status);
$stmt->bindParam(':today', $today);

$stmt->execute();

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

 $announcement_title = $row['title'];
 $announcement_slug = $row['slug'];
  $announcementDate = date('d F Y', strtotime($row['d_start_date']));


  ?>
      <div class="announcement__message"><a href="announcement-detail.php?slug=<?php echo $announcement_slug;?>">
        <?php echo $announcementDate;?> : <?php echo $announcement_title;?> &nbsp; <span>âºâº</span>&nbsp;</a>
      </div>

      <?php }?>
      
    </div>
  </div>
</div>
</section>
<section class="iqac-page py-5 px-4">
  <div class="container-fluid">
    <div class="row flex-column-reverse flex-lg-row">

      <!-- Sidebar -->
      <aside class="col-lg-3 sidebar sidebar-nav-sticky">
        <div class="sidebar-inner">

          <div class="sidebar-header mb-4">
            <h4 class="mb-0">Placement Cell</h4>           
          </div>

          <nav class="nav flex-column sidebar-nav">
            <a href="about-placements.php" class="nav-link active"><i class="fa-solid fa-angle-right me-2"></i> Home</a>
            <a href="our-recruiters.php" class="nav-link "><i class="fa-solid fa-angle-right me-2"></i> Our Recruiters</a> 
            <a href="placementprocess.php" class="nav-link "><i class="fa-solid fa-angle-right me-2"></i> Placement Process</a>
            <a href="training.php" class="nav-link "><i class="fa-solid fa-angle-right me-2"></i> Training</a>
			  <a href="placementevents.php" class="nav-link"><i class="fa-solid fa-angle-right me-2"></i> Events</a>
			  <a href="contact.php" class="nav-link"><i class="fa-solid fa-angle-right me-2"></i> Contact Us</a>
            </nav>

        </div>
      </aside>

      <!-- Content -->
      <main class="col-lg-9 content-area">

        <!-- Our Recruiters -->
        <section class="company-grid py-5 mb-4">
          <div class="title-area text-center pb-2"><h2 class="fw-bold mb-3">Our <span class="text-warning">Recruiters</span></h2></div>
          <div class="container-fluid">
            <div class="row g-4">
              <div class="col-6 col-md-4 col-lg-2">
                <div class="company-card">
                  <img src="images/recruiters-2025-26/adecco.png" alt="Adecco" title="Adecco"/>
                </div>
              </div>

              <div class="col-6 col-md-4 col-lg-2">
                <div class="company-card">
                  <img src="images/recruiters-2025-26/aon.png" alt="AON" title="AON"/>
                </div>
              </div>

              <div class="col-6 col-md-4 col-lg-2">
                <div class="company-card">
                  <img src="images/recruiters-2025-26/cognizant-technology.png" alt="Cognizant Technology" title="Cognizant Technology"/>
                </div>
              </div>

              <div class="col-6 col-md-4 col-lg-2">
                <div class="company-card">
                  <img src="images/recruiters-2025-26/hewlett-packard.png" alt="Hewlett Packard" title="Hewlett Packard"/>
                </div>
              </div>

              <div class="col-6 col-md-4 col-lg-2">
                <div class="company-card">
                  <img src="images/recruiters-2025-26/ibm.png" alt="IBM" title="IBM"/>
                </div>
              </div>

              <div class="col-6 col-md-4 col-lg-2">
                <div class="company-card">
                  <img src="images/recruiters-2025-26/nvidia.png" alt="NVIDIA" title="NVIDIA"/>
                </div>
              </div>

              <div class="col-6 col-md-4 col-lg-2">
                <div class="company-card">
                  <img src="images/recruiters-2025-26/target.png" alt="Target" title="Target"/>
                </div>
              </div>

              <div class="col-6 col-md-4 col-lg-2">
                <div class="company-card">
                  <img src="images/recruiters-2025-26/thermo-fisher-scientific.png" alt="Thermo Fisher Scientific" title="Thermo Fisher Scientific"/>
                </div>
              </div>

              <div class="col-6 col-md-4 col-lg-2">
                <div class="company-card">
                  <img src="images/recruiters-2025-26/abb.png" alt="ABB" title="ABB"/>
                </div>
              </div>

              <div class="col-6 col-md-4 col-lg-2">
                <div class="company-card">
                  <img src="images/recruiters-2025-26/accenture.png" alt="Accenture" title="Accenture"/>
                </div>
              </div>

              <div class="col-6 col-md-4 col-lg-2">
                <div class="company-card">
                  <img src="images/recruiters-2025-26/anz.jpeg" alt="ANZ" title="ANZ"/>
                </div>
              </div>

              <div class="col-6 col-md-4 col-lg-2">
                <div class="company-card">
                  <img src="images/recruiters-2025-26/arvind-fashion.jpeg" alt="Arvind Fashion" title="Arvind Fashion"/>
                </div>
              </div>

              <div class="col-6 col-md-4 col-lg-2">
                <div class="company-card">
                  <img src="images/recruiters-2025-26/bennett-coleman.png" alt="Bennett Coleman" title="Bennett Coleman"/>
                </div>
              </div>

              <div class="col-6 col-md-4 col-lg-2">
                <div class="company-card">
                  <img src="images/recruiters-2025-26/bluevine.png" alt="Bluevine" title="Bluevine"/>
                </div>
              </div>

              <div class="col-6 col-md-4 col-lg-2">
                <div class="company-card">
                  <img src="images/recruiters-2025-26/bosch.png" alt="Bosch" title="Bosch"/>
                </div>
              </div>

              <div class="col-6 col-md-4 col-lg-2">
                <div class="company-card">
                  <img src="images/recruiters-2025-26/broadridge.png" alt="Broadridge" title="Broadridge"/>
                </div>
              </div>

              <div class="col-6 col-md-4 col-lg-2">
                <div class="company-card">
                  <img src="images/recruiters-2025-26/deloitte.png" alt="Deloitte" title="Deloitte"/>
                </div>
              </div>

              <div class="col-6 col-md-4 col-lg-2">
                <div class="company-card">
                  <img src="images/recruiters-2025-26/digit.png" alt="Digit" title="Digit"/>
                </div>
              </div>

              <div class="col-6 col-md-4 col-lg-2">
                <div class="company-card">
                  <img src="images/recruiters-2025-26/ditto-insurance.png" alt="Ditto Insurance" title="Ditto Insurance"/>
                </div>
              </div>

              <div class="col-6 col-md-4 col-lg-2">
                <div class="company-card">
                  <img src="images/recruiters-2025-26/dtss.png" alt="DTSS" title="DTSS"/>
                </div>
              </div>

              <div class="col-6 col-md-4 col-lg-2">
                <div class="company-card">
                  <img src="images/recruiters-2025-26/empower.png" alt="Empower" title="Empower"/>
                </div>
              </div>

              <div class="col-6 col-md-4 col-lg-2">
                <div class="company-card">
                  <img src="images/recruiters-2025-26/equifax.png" alt="Equifax" title="Equifax"/>
                </div>
              </div>

              <div class="col-6 col-md-4 col-lg-2">
                <div class="company-card">
                  <img src="images/recruiters-2025-26/ernst-young.png" alt="Ernst Young" title="Ernst Young"/>
                </div>
              </div>

              <div class="col-6 col-md-4 col-lg-2">
                <div class="company-card">
                  <img src="images/recruiters-2025-26/federal-bank.png" alt="Federal Bank" title="Federal Bank"/>
                </div>
              </div>

              <div class="col-6 col-md-4 col-lg-2">
                <div class="company-card">
                  <img src="images/recruiters-2025-26/first-source.png" alt="First Source" title="First Source"/>
                </div>
              </div>

              <div class="col-6 col-md-4 col-lg-2">
                <div class="company-card">
                  <img src="images/recruiters-2025-26/gain-pro.png" alt="Gain Pro" title="Gain Pro"/>
                </div>
              </div>

              <div class="col-6 col-md-4 col-lg-2">
                <div class="company-card">
                  <img src="images/recruiters-2025-26/giant-eagle.png" alt="Giant Eagle" title="Giant Eagle"/>
                </div>
              </div>

              <div class="col-6 col-md-4 col-lg-2">
                <div class="company-card">
                  <img src="images/recruiters-2025-26/global-automation.jpeg" alt="Global Automation" title="Global Automation"/>
                </div>
              </div>

              <div class="col-6 col-md-4 col-lg-2">
                <div class="company-card">
                  <img src="images/recruiters-2025-26/icici-bank.png" alt="ICICI Bank" title="ICICI Bank"/>
                </div>
              </div>

              <div class="col-6 col-md-4 col-lg-2">
                <div class="company-card">
                  <img src="images/recruiters-2025-26/itc-foods.png" alt="ITC Foods" title="ITC Foods"/>
                </div>
              </div>

              <div class="col-6 col-md-4 col-lg-2">
                <div class="company-card">
                  <img src="images/recruiters-2025-26/karbon-business.png" alt="Karbon Business" title="Karbon Business"/>
                </div>
              </div>

              <div class="col-6 col-md-4 col-lg-2">
                <div class="company-card">
                  <img src="images/recruiters-2025-26/kpmg.png" alt="KPMG" title="KPMG"/>
                </div>
              </div>

              <div class="col-6 col-md-4 col-lg-2">
                <div class="company-card">
                  <img src="images/recruiters-2025-26/larsen-and-toubro.png" alt="Larsen &amp; Toubro" title="Larsen &amp; Toubro"/>
                </div>
              </div>

              <div class="col-6 col-md-4 col-lg-2">
                <div class="company-card">
                  <img src="images/recruiters-2025-26/leadsquared.png" alt="Leadsquared" title="Leadsquared"/>
                </div>
              </div>

              <div class="col-6 col-md-4 col-lg-2">
                <div class="company-card">
                  <img src="images/recruiters-2025-26/lufthansa-technik.png" alt="Lufthansa Technik" title="Lufthansa Technik"/>
                </div>
              </div>

              <div class="col-6 col-md-4 col-lg-2">
                <div class="company-card">
                  <img src="images/recruiters-2025-26/mnp-spark.png" alt="MNP Spark" title="MNP Spark"/>
                </div>
              </div>

              <div class="col-6 col-md-4 col-lg-2">
                <div class="company-card">
                  <img src="images/recruiters-2025-26/molecular-connections.png" alt="Molecular Connections" title="Molecular Connections"/>
                </div>
              </div>

              <div class="col-6 col-md-4 col-lg-2">
                <div class="company-card">
                  <img src="images/recruiters-2025-26/navi.png" alt="Navi" title="Navi"/>
                </div>
              </div>

              <div class="col-6 col-md-4 col-lg-2">
                <div class="company-card">
                  <img src="images/recruiters-2025-26/randstad.png" alt="Randstad" title="Randstad"/>
                </div>
              </div>

              <div class="col-6 col-md-4 col-lg-2">
                <div class="company-card">
                  <img src="images/recruiters-2025-26/societe-generale.png" alt="Societe Generale" title="Societe Generale"/>
                </div>
              </div>

              <div class="col-6 col-md-4 col-lg-2">
                <div class="company-card">
                  <img src="images/recruiters-2025-26/standard-chartered.png" alt="Standard Chartered" title="Standard Chartered"/>
                </div>
              </div>

              <div class="col-6 col-md-4 col-lg-2">
                <div class="company-card">
                  <img src="images/recruiters-2025-26/swiggy.png" alt="Swiggy" title="Swiggy"/>
                </div>
              </div>

              <div class="col-6 col-md-4 col-lg-2">
                <div class="company-card">
                  <img src="images/recruiters-2025-26/syngene-international.png" alt="Syngene International" title="Syngene International"/>
                </div>
              </div>

              <div class="col-6 col-md-4 col-lg-2">
                <div class="company-card">
                  <img src="images/recruiters-2025-26/tata-consultancy-services-tcs.png" alt="Tata Consultancy Services (TCS)" title="Tata Consultancy Services (TCS)"/>
                </div>
              </div>

              <div class="col-6 col-md-4 col-lg-2">
                <div class="company-card">
                  <img src="images/recruiters-2025-26/tata-electronics.png" alt="Tata Electronics" title="Tata Electronics"/>
                </div>
              </div>

              <div class="col-6 col-md-4 col-lg-2">
                <div class="company-card">
                  <img src="images/recruiters-2025-26/teachforindia.png" alt="TeachforIndia" title="TeachforIndia"/>
                </div>
              </div>

              <div class="col-6 col-md-4 col-lg-2">
                <div class="company-card">
                  <img src="images/recruiters-2025-26/thomson-reuters.jpeg" alt="Thomson Reuters" title="Thomson Reuters"/>
                </div>
              </div>

              <div class="col-6 col-md-4 col-lg-2">
                <div class="company-card">
                  <img src="images/recruiters-2025-26/updapt.png" alt="Updapt" title="Updapt"/>
                </div>
              </div>

              <div class="col-6 col-md-4 col-lg-2">
                <div class="company-card">
                  <img src="images/recruiters-2025-26/wipro.png" alt="Wipro" title="Wipro"/>
                </div>
              </div>

              <div class="col-6 col-md-4 col-lg-2">
                <div class="company-card">
                  <img src="images/recruiters-2025-26/withum.png" alt="Withum" title="Withum"/>
                </div>
              </div>
            </div>
          </div>
        </section>

        <article id="vision-mission" class="dept-section department_tab mb-5">
            <div class="row align-items-stretch">
                <div class="col-12 d-flex">
                     
                 <div class="content">
			<div class="left_title_border mt-4 mb-2">
           <h3 class="br_title text_blue fw-bold"><span></span>Introduction</h3> 
        </div>
                           
                       
                       <p><strong>About Us:</strong> The Centre for Placements and Skill Development is dedicated to empowering students by enhancing their employability and career prospects. Through comprehensive training in both technical and soft skills, we equip students with the knowledge and competencies required to thrive in their chosen fields, bridging the gap between education and industry expectations.</p>
										
                </div>
                
			
	  
			</div>
        </article>
		  
		  
			<div class="left_title_border mt-4 mb-2">
           <h3 class="br_title text_blue fw-bold"><span></span>Functions</h3> 
        </div>
		 
				
	  <ul class="language-list mt-0 p-0" style="list-style-type:none;">
		<li class="pb-3"><i class="fas fa-check me-2" aria-hidden="true"></i><strong>Job and Internship Sourcing</strong>
<ul>
  <li>Identify and source job openings and internship opportunities for final-year undergraduate (UG) and postgraduate (PG) students across various schools.</li>
			 
			</ul>
		  </li>			   
		<li class="pb-3"><i class="fas fa-check me-2" aria-hidden="true"></i><strong>Academia-Industry Collaboration</strong>
<ul>
  <li>Strengthen industry-academia interaction through guest lectures, seminars, workshops, and other initiatives.</li>
			  <li>Bridge skill gaps by aligning student competencies with industry expectations.</li>
			</ul>
		  </li>
		  <li class="pb-3"><i class="fas fa-check me-2" aria-hidden="true"></i><strong>Soft Skills Training</strong>
<ul>
  <li>Conduct soft skills training for final-year students at the beginning of the academic year.</li>
			  <li>Prepare students for placement processes, including resume building, interview skills, and professional communication.</li>
			</ul>
		  
		  </li>
		  <li class="pb-3"><i class="fas fa-check me-2" aria-hidden="true"></i><strong>Recruiter Relationship Management</strong>
<ul>
  <li>Maintain strong relationships with existing recruiters.</li>
			  <li>Identify and engage potential recruiters through placement brochures, LinkedIn, alumni networks, and direct outreach.</li>
			</ul>
		  
		  </li>
		  <li class="pb-3"><i class="fas fa-check me-2" aria-hidden="true"></i><strong>Campus Recruitment Coordination</strong>
<ul>
  <li>Ensure a seamless experience for recruiters visiting the campus by managing logistics and other requirements.</li>
			 
			</ul>
		  </li>
		  <li class="pb-3"><i class="fas fa-check me-2" aria-hidden="true"></i><strong>Effective Communication</strong>
<ul>
  <li>Provide timely updates on placement activities to all university stakeholders, including students, faculty, and administration.</li>
			 
			</ul>
		  </li>
		  <li class="pb-3"><i class="fas fa-check me-2" aria-hidden="true"></i><strong>Placement Documentation & Compliance</strong>
<ul>
  <li>Maintain records of all placement-related activities in accordance with NAAC and other statutory university requirements.</li>
			 
			</ul>
		  
		  </li>
		   
		</ul>
		  
		  
		  
		  
	 <div class="mt-5 text-center">
				
		<h4>Organizational Structure</h4>		
			<img src="images/diagram.jpg"  alt=""/> 
			</div>
			
			
			<div class="mt-5">
				
				
			<div class="left_title_border mt-4 mb-2">
           <h3 class="br_title text_blue fw-bold"><span></span>Placement Policy</h3> 
        </div>
				
			
			<h5>1. Eligibility and Registration</h5>
			<ul class="language-list mt-0 p-0" style="list-style-type:none;">
		   <li class="pb-3"><i class="fas fa-check me-2" aria-hidden="true"></i><strong>Mandatory Registration:</strong> All final-year undergraduate (UG) and postgraduate (PG) students must register on the Placement page of the Linways portal.</li>
		
				<li class="pb-3"><i class="fas fa-check me-2" aria-hidden="true"></i><strong>Participation Choice</strong>
<ul>
  <li>Students interested in campus recruitment must select âYES' during registration.</li>
			 <li>Students opting out must select âNO' and choose a reason from the provided dropdown list for non-participation.</li>
			</ul>
		  </li>	
		</ul>
			<h5>2. Compliance Requirements</h5>	
				<ul class="language-list mt-0 p-0" style="list-style-type:none;">
		   
		<li class="pb-3"><i class="fas fa-check me-2" aria-hidden="true"></i><strong>Registered students must adhere to university placement norms, including</strong>
<ul>
  <li>Maintaining the required attendance percentage.</li>
			 <li>Ensuring they have no active backlogs at the time of placement.</li>
			</ul>
		  </li>	
		</ul>
				
			<h5>3. Terms and Conditions</h5>	
				<ul class="language-list mt-0 p-0" style="list-style-type:none;">
		   
		<li class="pb-3"><i class="fas fa-check me-2" aria-hidden="true"></i><strong>Single Offer Policy:</strong> Once a student secures a placement offer from any organization, they will no longer be eligible for further campus recruitment drives.</li>
					<li class="pb-3"><i class="fas fa-check me-2" aria-hidden="true"></i><strong>Documentation Requirement:</strong> Students must submit a copy of their offer letter to the Placement Office for official records.</li>	
		</ul>
		
			<div class="left_title_border mt-4 mb-2">
           <h3 class="br_title text_blue fw-bold"><span></span>Placement Drive Reporting Guidelines</h3> 
        </div>
	
		<b>Students are required to:</b>
		<ul class="language-list mt-0 p-0" style="list-style-type:none;">
		   
		<li class="pb-3"><strong>Report on time as per the schedule shared by the Placement Office. Latecomers will not be allowed to participate in the process.</strong></li>
			<li class="pb-3"><i class="fas fa-check me-2" aria-hidden="true"></i><strong>Carry essential documents, including</strong>
<ul>
  <li>A hard copy of their updated CV</li>
			 <li>College identity card</li>
			</ul>
		  </li>
			<li class="pb-3"><i class="fas fa-check me-2" aria-hidden="true"></i><strong>Dress professionally:</strong> Students should be well-groomed and dressed in formal attire for the placement drive</li>	
		</ul>
		
		<h5>4. Work Commitment</h5>	
				<ul class="language-list mt-0 p-0" style="list-style-type:none;">
		   
		<li class="pb-3"><i class="fas fa-check me-2" aria-hidden="true"></i>Students placed through campus recruitment drives are expected to commit to a minimum employment period of one year with the respective organization</li>					
		</ul>
		</div>
		
		</main>
	    </div>
  	</div></section>
	

	<section class="company-grid py-5">
		
<div class="title-area text-center pb-2"><h2 class="fw-bold mb-3">Top <span class="text-warning">Recruiters</span></h2></div>
		
<div class="container">
<div class="row g-4">

<!-- Item -->
<div class="col-6 col-md-4 col-lg-2">
<div class="company-card">
  <img src="images/aakash.webp" alt=""/> </div>
</div>

<div class="col-6 col-md-4 col-lg-2">
<div class="company-card">
  <img src="images/accenture.webp" alt=""/> </div>
</div>

<div class="col-6 col-md-4 col-lg-2">
<div class="company-card">
  <img src="images/accorian.webp" alt=""/> </div>
</div>

<div class="col-6 col-md-4 col-lg-2">
<div class="company-card">
  <img src="images/anklesarla.webp" alt=""/> </div>
</div>

<div class="col-6 col-md-4 col-lg-2">
<div class="company-card">
  <img src="images/x.webp" alt=""/></div>
</div>

<div class="col-6 col-md-4 col-lg-2">
<div class="company-card">
<img src="images/atkinsrealis.webp" alt=""/>
</div>
</div>
	</div>
	
	
<div class="row g-4">
<div class="col-6 col-md-4 col-lg-2">
<div class="company-card">
<img src="images/bdo.webp" alt=""/></div>
</div>


<div class="col-6 col-md-4 col-lg-2">
<div class="company-card">
  <img src="images/brandscale.webp" alt=""/> </div>
</div>

<div class="col-6 col-md-4 col-lg-2">
<div class="company-card">
  <img src="images/britania.webp" alt=""/> </div>
</div>

<div class="col-6 col-md-4 col-lg-2">
<div class="company-card">
  <img src="images/broadridge.webp" alt=""/> </div>
</div>

<div class="col-6 col-md-4 col-lg-2">
<div class="company-card">
  <img src="images/cognizant.webp" alt=""/> </div>
</div>

<div class="col-6 col-md-4 col-lg-2">
<div class="company-card">
  <img src="images/crisil.webp" alt=""/> </div>
</div>	

</div>

<div class="row g-4">
		<div class="col-6 col-md-4 col-lg-2">
<div class="company-card">
  <img src="images/deloitte.webp" alt=""/></div>
</div>
	
	<div class="col-6 col-md-4 col-lg-2">
<div class="company-card">
   <img src="images/ditto.webp" alt=""/></div>
</div>	
	
	<div class="col-6 col-md-4 col-lg-2">
<div class="company-card">
   <img src="images/empower.webp" alt=""/></div>
</div>	
	
	<div class="col-6 col-md-4 col-lg-2">
<div class="company-card">
  <img src="images/enate.webp" alt=""/></div>
</div>	
	
	<div class="col-6 col-md-4 col-lg-2">
<div class="company-card">
   <img src="images/ey.webp" alt=""/></div>
</div>	
	
	<div class="col-6 col-md-4 col-lg-2">
<div class="company-card">
   <img src="images/federalbank.webp" alt=""/></div>
</div>
	</div><br><br>
	<div class="text-center mt-5"><a href="recruiters.php" target="_blank" class="btn btn-apply text-center" aria-label="Master of Science (M.Sc.) in Biotechnology">  View More â'
          </a></div>
	</div>

	
	</section>
	<!--==============GALLERY=====-->
<section class="mb-3">
  <div class="container py-5">

    <h2 class="text-center mb-5 fw-bold">Our <span class="text-warning">Gallery</span></h2>

    <!-- Tabs -->
    <ul class="nav nav-pills justify-content-center mb-4" id="galleryTab">
      <li class="nav-item">
        <button class="nav-link active" data-bs-toggle="pill" data-bs-target="#photos">Photos</button>
      </li>
      <li class="nav-item">
        <button class="nav-link" data-bs-toggle="pill" data-bs-target="#videos">Videos</button>
      </li>
    </ul>

    <div class="tab-content">

      <!-- ================= PHOTO TAB ================= -->
      <div class="tab-pane fade show active" id="photos">

        <div id="gallery" class="row g-3 row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4">
      <div class="col">
            <div class="gallery-item" data-index="3" data-full="assets/img/gallery/gallery_sju.webp" data-caption="Campus Life">
          <img src="/assets/img/gallery/gallery_sju.webp" alt="Commerce Department">
        </div>
      </div>

      <div class="col">
        <div class="gallery-item" data-index="1" data-full="/assets/img/gallery/sju-bangalore-.webp" data-caption="Faculty Session">
          <img src="/assets/img/gallery/sju-bangalore-.webp" alt="Faculty Session">
        </div>
      </div>

      <div class="col">
        <div class="gallery-item" data-index="2" data-full="/assets/img/gallery/bse-.webp" data-caption="Student Workshop">
          <img src="/assets/img/gallery/bse-.webp" alt="Student Workshop">
        </div>
      </div>

      <div class="col">
        <div class="gallery-item" data-index="3" data-full="/assets/img/gallery/sju-college.webp" data-caption="Campus Life">
          <img src="/assets/img/gallery/sju-college.webp" alt="Campus Life">
        </div>
      </div>
      <div class="col">
        <div class="gallery-item" data-index="3" data-full="/assets/img/gallery/sju-students-.webp" data-caption="Campus Life">
          <img src="/assets/img/gallery/sju-students-.webp" alt="Campus Life">
        </div>
      </div>
      <div class="col">
        <div class="gallery-item" data-index="3" data-full="/assets/img/gallery/sju-bengalore-.webp" data-caption="Campus Life">
          <img src="/assets/img/gallery/sju-bengalore-.webp" alt="Campus Life">
        </div>
      </div>
      <div class="col">
        <div class="gallery-item" data-index="3" data-full="/assets/img/gallery/sju-gallery.webp" data-caption="Campus Life">
          <img src="/assets/img/gallery/sju-gallery.webp" alt="Campus Life">
        </div>
      </div>
      <div class="col">
        <div class="gallery-item" data-index="0" data-full="assets/img/gallery/sju-certification.webp" data-caption="Department of Commerce">
          <img src="/assets/img/gallery/sju-certification.webp" alt="Campus Life">
        </div>
      </div>

    </div>
     <div class="text-center mt-5"><a href="#" target="_blank" class="btn btn-success fw-semibold px-4 py-2">
             View More <i class="fa fa-long-arrow-right ms-2"></i>
            </a></div> 
  </div>
  

  <!-- Lightbox Modal -->
 <div class="modal fade" id="lightboxModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
      <div class="modal-content bg-dark">
        <div class="modal-body position-relative text-center">
          <button type="button" class="btn-close position-absolute top-0 end-0 m-2" data-bs-dismiss="modal" style="color:#ffc107;background: #fff;opacity: 1;"><i class="fa fa-close" style="color:#ffc107;background: #fff;opacity: 1;"></i></button>
          <button type="button" class="lightbox-nav lightbox-prev" aria-label="Previous">
            <i class="fa fa-chevron-left"></i>
          </button>
          <img id="lightboxImage" src="" alt="" class="lightbox-img rounded">
          <button type="button" class="lightbox-nav lightbox-next" aria-label="Next">
            <i class="fa fa-chevron-right"></i>
          </button>
          <div id="lightboxCaption" class="text-white-50 mt-3"></div>
        </div>
      </div>
    </div> 
</div>

      <!-- ================= VIDEO TAB ================= -->
      <div class="tab-pane fade" id="videos">

  <div class="row g-4">

    <!-- VIDEO 1 -->
    <div class="col-md-4">
      <div class="video-card">

        <div class="ratio ratio-16x9">
          <iframe width="560" height="315" src="https://www.youtube.com/embed/WM2LBfI-7e8?si=CxurSqER2rTzrveY" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
        </div>

      </div>
    </div>

    <!-- VIDEO 2 -->
    <div class="col-md-4">
      <div class="video-card">
        <div class="ratio ratio-16x9">
          <iframe width="560" height="315" src="https://www.youtube.com/embed/bK534lW88QE?si=-FSCLg5XQHNokp61" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
        </div>
      </div>
    </div>

    <!-- VIDEO 3 -->
    <div class="col-md-4">
      <div class="video-card">
        <div class="ratio ratio-16x9">
          <iframe width="560" height="315" src="https://www.youtube.com/embed/47xEPoMHd-E?si=Eg3A1oJscGygU_ZG" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
        </div>
      </div>
    </div>

    <!-- VIDEO 4 -->
    <div class="col-md-4">
      <div class="video-card">
        <div class="ratio ratio-16x9">
          <iframe width="560" height="315" src="https://www.youtube.com/embed/oyCBckjJnTA?si=QKpwUQx0clwn0AAi" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
        </div>
      </div>
    </div>

    <!-- VIDEO 5 -->
    <div class="col-md-4">
      <div class="video-card">
        <div class="ratio ratio-16x9">
          <iframe width="560" height="315" src="https://www.youtube.com/embed/w7f590k5K2k?si=QT09C0O7pG7E_L6J" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
        </div>
      </div>
    </div>

  </div>

</div>

    </div>

  </div>
</section>
		
	
		
		
	
	
  <!-- Footer injected -->
<?php require_once '../footer.php'; ?>

  <!-- Bootstrap JS bundle -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

  <!-- Custom JS -->
  <script src="../assets/js/main.js"></script>
</body>
</html>
