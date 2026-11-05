<!doctype html>
<html class="no-js " lang="en" dir="ltr">

<head>
    <?php include $_SERVER['DOCUMENT_ROOT'] . '/gtm.php'; ?>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Learning Today,Leading Tomorrow | St Joseph's University, Bengaluru</title>
    <meta name="description" content="Explore Learning Today,Leading Tomorrow at St Joseph's University, Bengaluru — a leading Jesuit autonomous university in Karnataka.">
    <meta name="keywords" content="Learning Today,Leading Tomorrow St Joseph's University Bengaluru, SJU Learning Today,Leading Tomorrow Bangalore, St Joseph's University Bengaluru, Jesuit university Karnataka">
    <meta name="robots" content="INDEX,FOLLOW">
    <link rel="canonical" href="https://www.sju.edu.in/index3">

    <!-- Open Graph / Social Sharing -->
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="St Joseph's University, Bengaluru">
    <meta property="og:title" content="Learning Today,Leading Tomorrow | St Joseph's University, Bengaluru">
    <meta property="og:description" content="Explore Learning Today,Leading Tomorrow at St Joseph's University, Bengaluru — a leading Jesuit autonomous university in Karnataka.">
    <meta property="og:url" content="https://www.sju.edu.in/index3">
    <meta property="og:image" content="https://www.sju.edu.in/assets/img/st-joseph-university-logo.png">
    <meta property="og:image:width" content="200">
    <meta property="og:image:height" content="200">
    <meta name="twitter:card" content="summary">
    <meta name="twitter:site" content="@StJosephsUniBLR">
    <meta name="twitter:title" content="Learning Today,Leading Tomorrow | St Joseph's University, Bengaluru">
    <meta name="twitter:description" content="Explore Learning Today,Leading Tomorrow at St Joseph's University, Bengaluru — a leading Jesuit autonomous university in Karnataka.">
    <meta name="twitter:image" content="https://www.sju.edu.in/assets/img/st-joseph-university-logo.png">

    <!-- Mobile Specific Metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Favicons - Place favicon.ico in the root directory -->
    <link rel="icon" href="assets/img/favicon.png" type="image/png">
    <!-- Apple Touch Icon (for iOS home screen) -->
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
    <!-- Bootstrap -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <!-- Fontawesome Icon -->
    <link rel="stylesheet" href="assets/css/fontawesome.min.css">
    <!-- Magnific Popup -->
    <link rel="stylesheet" href="assets/css/magnific-popup.min.css">
    <!-- Swiper Js -->
    <link rel="stylesheet" href="assets/css/swiper-bundle.min.css">
    <!-- Theme Custom CSS -->
    <link rel="stylesheet" href="assets/css/style.css?v=2.3">
 <!--   <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
    <meta http-equiv="Pragma" content="no-cache" />
    <meta http-equiv="Expires" content="0" /> --> 
    
    
</head>
<body>
    <?php include 'header.php';
    
    
    
ini_set('display_errors', 1); 
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$config = file_exists('/home/sjubedu/config.php') ? '/home/sjubedu/config.php' : __DIR__ . '/../../config.php';
require_once $config;
$pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4", DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$status = 'Y';
$sql = "SELECT c_image FROM sliders WHERE c_status = :status 
        ORDER BY id ASC";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':status', $status);
$stmt->execute();

        
    ?>
<!-- Admission Popup -->
<section>
<div id="admissionPopup" class="admission-overlay">
  <div class="admission-modal">
    <button class="admission-close" aria-label="Close popup">&times;</button>

    <!-- Image -->
    <div class="admission-image">
      <img src="assets/img/banner/popup_banner.webp" alt="Admissions Open">
    </div>

    <h2>Admissions Open</h2>
    <p>
      Secure your seat today. Applications are now open for the upcoming academic year.
    </p>

    <a href="#" class="admission-cta">Apply Now</a>
  </div>
</div>
</section>
<!-- Floating Social Icons -->


<!-- HERO / Main carousel (infinite) -->
 <!-- Hero Slider Section -->
<section id="heroSlider" class="hero-slider position-relative">
  <div id="heroCarousel" class="carousel slide carousel-fade" data-bs-ride="carousel" data-bs-interval="3000">
    <div class="carousel-inner">

      <!-- Slide 1 -->


      <?php
      $slidercount=0;
      $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
      $totalCount = count($rows);
      foreach ($rows as $row) {
  $slidercount++;
  if($slidercount==1){
  $slider_active="active";
  }
  else {
    $slider_active="";
  }
  ?>
      <div class="carousel-item <?php echo $slider_active;?>">
        <div class="slide-bg" style="background-image: url('sju_admin/assets/admin/uploads/sliders/original/<?php echo $row['c_image'];?>');">
          <div class="text-start carousel-caption">
            <h1 class="display-4 fw-bold text-white">Learning Today,<br><span class="text-warning">Leading Tomorrow</span></h1>
            <!--<p class="text-light mt-3">
              The encouragement of holistic development in students is echoed in the infrastructural
              facilities provided by the Institution as well as its policies.
            </p>-->
            <a href="#" class="btn btn-warning mt-3 fw-semibold px-4 py-2">
              More <i class="fa fa-long-arrow-right ms-2"></i>
            </a>
          </div>
        </div>
      </div>
<?php }?>
      

    </div>

    <!-- Vertical Dots -->
    <div class="carousel-indicators flex-column align-items-end pe-3">
    <?php
    $slider_dot=0;
    for ($i = 0; $i < $totalCount; $i++) {
       if($slider_dot==0){
      $slider_dot_active="active";
      }
      else {
        $slider_dot_active="";
      }
      ?>
      <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="<?php echo $slider_dot;?>" class="<?php echo $slider_dot_active;?>" aria-current="true"></button>
      <?php
      $slider_dot++;
    }
    ?>
      
    </div>
  </div>
</section>
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
      <div class="announcement__message"><a href="#">
        21 October 2025: Instructions to Students for Semester Examinations &nbsp; <span>››</span>&nbsp;</a>
      </div>
      <div class="announcement__message"><a href="#">
        18 October 2025: Notice Regarding Certificate Course Admissions – Non SJU Students &nbsp;<span> ›› </span>&nbsp;</a>
      </div>
      <div class="announcement__message"><a href="#">
        15 October 2025: NOTICE – Grant of Additional Marks for Achievements in Sports, NSS, and NCC &nbsp;<span>››</span>&nbsp;</a>
      </div>
      <!-- duplicate messages as needed for seamless scroll -->
      <div class="announcement__message"><a href="#">
        21 October 2025: Instructions to Students for Semester Examinations &nbsp;<span>››</span>&nbsp;</a>
      </div>
      <div class="announcement__message"><a href="#">
        18 October 2025: Notice Regarding Certificate Course Admissions – Non SJU Students &nbsp;<span>››</span>&nbsp;</a>
      </div>
      <div class="announcement__message"><a href="#">
        15 October 2025: NOTICE – Grant of Additional Marks for Achievements in Sports, NSS, and NCC &nbsp;<span>››</span> &nbsp;</a>
      </div>
    </div>
  </div>
</div>
</section>
<!--SEARCH SECTION-->
<section class="sjric-search-section">
  <div class="container">
    <div class="search-grid">

      <!-- Left Content -->
      <div class="search-content">
        <h2 class="fw-bold mb-3">Explore <span class="text-warning">Events & News</span> </h2>
        <p>
          Stay updated with the latest academic events, research highlights,
          announcements, and campus news from St Joseph's University.
        </p>
      </div>

      <!-- Right Search -->
      <div class="search-box-wrap">
        <div class="search-box">
          <input
            type="text"
            id="siteSearch"
            placeholder="Search events, news, announcements…"
            autocomplete="off"
          />
          <button aria-label="Search">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none">
              <circle cx="11" cy="11" r="7" stroke="currentColor" stroke-width="2"/>
              <line x1="20" y1="20" x2="16.5" y2="16.5" stroke="currentColor" stroke-width="2"/>
            </svg>
          </button>
        </div>

        <div class="search-results" id="searchResults"></div>
      </div>

    </div>
  </div>
</section>
<!-- Features Section -->
<section class="quick-links py-5">
  <div class="container">
    <div class="row g-4 justify-content-center">
      <!-- Card 1 -->
      <div class="col-6 col-md-3">
        <div class="quick-link-item text-center p-4 rounded-3 h-100">
          <i class="fa-solid fa-landmark fa-2x text-warning mb-3"></i>
          <h5 class="fw-semibold mb-0">The University</h5>
        </div>
      </div>
      <!-- Card 2 -->
      <div class="col-6 col-md-3">
        <div class="quick-link-item text-center p-4 rounded-3  h-100">
          <i class="fa-solid fa-graduation-cap fa-2x text-warning mb-3"></i>
          <h5 class="fw-semibold mb-0">Academics</h5>
        </div>
      </div>
      <!-- Card 3 -->
      <div class="col-6 col-md-3">
        <div class="quick-link-item text-center p-4 rounded-3  h-100">
          <i class="fa-solid fa-network-wired fa-2x text-warning mb-3"></i>
          <h5 class="fw-semibold mb-0">SJU Intranet</h5>
        </div>
      </div>
      <!-- Card 4 -->
      <div class="col-6 col-md-3">
        <div class="quick-link-item text-center p-4 rounded-3 h-100">
          <i class="fa-solid fa-users fa-2x text-warning mb-3"></i>
          <h5 class="fw-semibold mb-0">Students Support</h5>
        </div>
      </div>
    </div>
  </div>
</section>
<!--About Section-->
<section class="welcome-section pt-4">
  <div class="container">
    <div class="row g-0 align-items-stretch">

      <!-- Left side background image -->
      <div class="col-lg-4 bg-cover" style="background-image: url('assets/img/about/students.webp');"> </div>
      <!-- Right side content -->
      <div class="col-lg-8 d-flex flex-column justify-content-center content-box">
        <div class="mt-4">
          <h2 class="fw-bold text-warning mb-1">Welcome to St Joseph's University,</h2>
          <h2 class="fw-bold text_blue mb-3">Bengaluru, India</h2>
          <p class="text-muted">
            St Joseph's University is a Jesuit university at the heart of Bengaluru, the silicon city of India.
            Established in 1882 by Paris Foreign Mission Fathers, the management of the college was handed 
            over to the Jesuit order (Society of Jesus) in 1937. The college was first affiliated with the University 
            of Madras and later with the Mysore and Bangalore universities. In 1986, St Joseph's College became 
            the first affiliated college in Karnataka to offer postgraduate programmes. In 1988, it became the first 
            college in Karnataka to get a Research Centre.
          </p>
          <a href="#" class="btn btn-success px-4 py-2 mt-2">
            More <i class="fa fa-arrow-right ms-2"></i>
          </a>
          <!-- Bottom small images -->
          <div class="row g-6 mt-5">
            <div class="col-md-6 mb-hide">
              <img src="assets/img/about/St-Josephs-University-bengaluru.webp" class="img-fluid rounded-3 shadow-sm" alt="Campus 1">
            </div>
            <div class="col-md-6">
              <img src="assets/img/about/our-graduates.webp" class="img-fluid rounded-3 shadow-sm" alt="Campus 2">
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<!-- LATEST NEWS + CAMPUS LIFE
<section class="news-section py-5">
  <div class="container">
    <div class="row g-4 align-items-stretch">

    
      <div class="col-lg-7 d-flex flex-column">
        <h2 class="fw-bold text-blue mb-4">Announcements</h2>

        <div id="announcementCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="4000">
          <div class="carousel-inner">

            <div class="carousel-item active">
              <div class="announcement-item p-4 rounded">
                <h6 class="fw-bold mb-1">6 October 2025</h6>
                <p class="mb-0">Notice Regarding L'Oreal India Young Women Scholarship-UG</p>
              </div>
              <div class="announcement-item p-4 rounded mt-3">
                <h6 class="fw-bold mb-1">8 October 2025</h6>
                <p class="mb-0">Foundation Course Supplementary Examination 2025-26 (For Non-NEP Students)</p>
              </div>
              <div class="announcement-item p-4 rounded mt-3">
                <h6 class="fw-bold mb-1">15 October 2025</h6>
                <p class="mb-0">Foundation Course Supplementary Examination 2025-26 (For Non-NEP Students)</p>
              </div>
            </div>

            <div class="carousel-item">
              <div class="announcement-item p-4 rounded">
                <h6 class="fw-bold mb-1">22 October 2025</h6>
                <p class="mb-0">Midterm Assessments - PG Programs</p>
              </div>
              <div class="announcement-item p-4 rounded mt-3">
                <h6 class="fw-bold mb-1">25 October 2025</h6>
                <p class="mb-0">Notice Regarding Library Orientation for Freshers</p>
              </div>
              <div class="announcement-item p-4 rounded mt-3">
                <h6 class="fw-bold mb-1">30 October 2025</h6>
                <p class="mb-0">Holiday Notice - Founders Day Celebration</p>
              </div>
            </div>
            <div class="carousel-item active">
              <div class="announcement-item p-4 rounded">
                <h6 class="fw-bold mb-1">6 October 2025</h6>
                <p class="mb-0">Notice Regarding L'Oreal India Young Women Scholarship-UG</p>
              </div>
              <div class="announcement-item p-4 rounded mt-3">
                <h6 class="fw-bold mb-1">8 October 2025</h6>
                <p class="mb-0">Foundation Course Supplementary Examination 2025-26 (For Non-NEP Students)</p>
              </div>
              <div class="announcement-item p-4 rounded mt-3">
                <h6 class="fw-bold mb-1">15 October 2025</h6>
                <p class="mb-0">Foundation Course Supplementary Examination 2025-26 (For Non-NEP Students)</p>
              </div>
            </div>
            <div class="carousel-item">
              <div class="announcement-item p-4 rounded">
                <h6 class="fw-bold mb-1">22 October 2025</h6>
                <p class="mb-0">Midterm Assessments - PG Programs</p>
              </div>
              <div class="announcement-item p-4 rounded mt-3">
                <h6 class="fw-bold mb-1">25 October 2025</h6>
                <p class="mb-0">Notice Regarding Library Orientation for Freshers</p>
              </div>
              <div class="announcement-item p-4 rounded mt-3">
                <h6 class="fw-bold mb-1">30 October 2025</h6>
                <p class="mb-0">Holiday Notice - Founders Day Celebration</p>
              </div>
            </div>

          </div>
        </div>

         
        <div class="carousel-indicators-outside text-center mt-4">
          <button type="button" data-bs-target="#announcementCarousel" data-bs-slide-to="0" class="active"></button>
          <button type="button" data-bs-target="#announcementCarousel" data-bs-slide-to="1"></button>
          <button type="button" data-bs-target="#announcementCarousel" data-bs-slide-to="2"></button>
          <button type="button" data-bs-target="#announcementCarousel" data-bs-slide-to="3"></button>
        </div>
      </div>

     
      <div class="col-lg-5 d-flex flex-column">
        <h2 class="fw-bold text-warning mb-4">Latest News</h2>

        <div id="newsCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="4000">
          <div class="carousel-inner">

            <div class="carousel-item active">
              <div class="news-card text-white p-5 rounded">
                <h3 class="fw-bold">Multi-criteria Decision Analysis using ISM</h3>
                <p class="mt-2">Notice Regarding L'Oreal India Young Women Scholarship-UG</p>
                <a href="#" class="btn btn-warning mt-2 fw-semibold px-3 py-2">
                  More <i class="fa fa-arrow-right ms-2"></i>
                </a>
              </div>
            </div>

            <div class="carousel-item">
              <div class="news-card text-white p-5 rounded">
                <h3 class="fw-bold">St. Joseph's Cultural Fest 2025</h3>
                <p class="mt-2">Annual cultural celebration begins with inter-college competitions.</p>
                <a href="#" class="btn btn-warning mt-2 fw-semibold px-3 py-2">
                  More <i class="fa fa-arrow-right ms-2"></i>
                </a>
              </div>
            </div>
            <div class="carousel-item active">
              <div class="news-card text-white p-5 rounded">
                <h3 class="fw-bold">Multi-criteria Decision Analysis using ISM</h3>
                <p class="mt-2">Notice Regarding L'Oreal India Young Women Scholarship-UG</p>
                <a href="#" class="btn btn-warning mt-2 fw-semibold px-3 py-2">
                  More <i class="fa fa-arrow-right ms-2"></i>
                </a>
              </div>
            </div>

          </div>
        </div>

       
        <div class="carousel-indicators-outside text-center mt-4">
          <button type="button" data-bs-target="#newsCarousel" data-bs-slide-to="0" class="active"></button>
          <button type="button" data-bs-target="#newsCarousel" data-bs-slide-to="1"></button>
          <button type="button" data-bs-target="#newsCarousel" data-bs-slide-to="2"></button>
        </div>
      </div>

    </div>
  </div>
</section> -->
<!-- LATEST NEWS + CAMPUS LIFE-->
<section class="news-section py-5">
  <div class="container pt-8">
    <div class="row g-4 align-items-stretch">
 <!-- Image Carousel -->
<div class="col-lg-7 d-flex flex-column position-relative">
  <h2 class="fw-bold mb-3">Campus <span class="text-warning">Highlights</span> </h2>
   <div id="imageCarousel" class="carousel slide campus-carousel rounded overflow-hidden" data-bs-ride="carousel" data-bs-interval="3500" data-bs-touch="true">
    <!-- Carousel Inner -->
    <div class="carousel-inner">
      <div class="carousel-item active">
        <img src="assets/img/gallery/sju-bangalore-.webp" class="d-block w-100" alt="Campus Life">
      </div>
      <div class="carousel-item">
        <img src="assets/img/gallery/bse-.webp" class="d-block w-100" alt="Events">
      </div>
      <div class="carousel-item">
        <img src="assets/img/gallery/sju-certification.webp" class="d-block w-100" alt="Students">
      </div>
      <div class="carousel-item">
        <img src="assets/img/gallery/sju-college.webp" class="d-block w-100" alt="Campus">
      </div>
    </div>
    <!-- Controls (TOP RIGHT) -->
    <button class="carousel-control-prev campus-control" type="button" data-bs-target="#imageCarousel" data-bs-slide="prev">
      <span class="carousel-control-prev-icon"></span>
    </button>
    <button class="carousel-control-next campus-control" type="button" data-bs-target="#imageCarousel" data-bs-slide="next">
      <span class="carousel-control-next-icon"></span>
    </button>
  </div>
</div>

<!--LATEST NEWS-->
      <div class="col-lg-5 d-flex flex-column">
        <h2 class="fw-bold text-warning mb-4">Latest News</h2>

        <div id="newsCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="4000">
          <div class="carousel-inner">

          <?php
              $status = 'Y';
              $c_type='Homepage';
              $sql = "SELECT title,slug,description,created_at,c_image FROM news WHERE c_status = :status AND c_type = :c_type
                      ORDER BY id ASC";
              $stmtnews = $pdo->prepare($sql);
              $stmtnews->bindParam(':status', $status);
              $stmtnews->bindParam(':c_type', $c_type);
              $stmtnews->execute();
               $newscount=0;
                    $newsrows = $stmtnews->fetchAll(PDO::FETCH_ASSOC);
                    $totalnewsCount = count($newsrows);
                    foreach ($newsrows as $newsrows) {
                $newscount++;
                if($newscount==1){
                $snews_active="active";
                }
                else {
                  $snews_active="";
                }
?>
            <div class="carousel-item <?php echo $snews_active;?>">
              <div class="news-card text-white p-5 rounded">
                <h3 class="fw-bold"><?php echo htmlspecialchars($newsrows['title']);?></h3>
                <p class="mt-2"><?php 
              $desc = strip_tags($newsrows['description']);
              echo htmlspecialchars(substr($desc,0,200)); 
              if(strlen($desc) >200) echo "...";
              ?></p>
                <a href="news-detail.php?slug=<?php echo $newsrows['slug'];?>" class="btn btn-warning mt-2 fw-semibold px-3 py-2">
                  More <i class="fa fa-arrow-right ms-2"></i>
                </a>
              </div>
            </div>

            <?php 
            }
            ?>
          </div>
           <div class="carousel-indicators-outside text-center mt-4">

<?php
    $news_dot=0;
    for ($i = 0; $i < $totalnewsCount; $i++) {
       if($news_dot==0){
      $news_dot_active="active";
      }
      else {
        $news_dot_active="";
      }
      ?>

            <button type="button" data-bs-target="#newsCarousel" data-bs-slide-to="<?php echo $news_dot;?>" class="<?php echo $news_dot_active;?>"></button>
            <?php
            $news_dot++;
            
            }
            ?>
            
           </div>
        </div>
        
      </div>
    </div>
  </div>
</section> 
<!--Campus Life-->
<section class="campus-life-section py-5 mt-2 text-center">
  <div class="container">

    <div class="title-area text-center pb-2">
      <h2 class="fw-bold mb-3">
        Campus <span style="color:#f4b400;">Life</span>
      </h2>
    </div>

    <p class="text-muted mb-5">
      Green campuses are a rarity in metropolitan cities, but SJU has ensured a green and eco-friendly campus.
    </p>

    <!-- Carousel -->
    <div class="custom-carousel">
      <div class="carousel-track" id="carouselTrack">

        <!-- ITEM -->
        <div class="carousel-item1">
          <a href="services/sports.php" target="_blank">
            <img src="assets/img/about/SJU_sports_.webp">
            <h5>Sports</h5>
          </a>
        </div>

        <div class="carousel-item1">
          <a href="services/sju-national-cadet-corps.php" target="_blank">
            <img src="assets/img/about/ncc-students.webp">
            <h5>NCC</h5>
          </a>
        </div>

        <div class="carousel-item1">
          <a href="services/outreach.php" target="_blank">
            <img src="assets/img/about/sju-outreach.webp">
            <h5>Outreach</h5>
          </a>
        </div>

        <div class="carousel-item1">
          <a href="services/hostel/university-hostel.php" target="_blank">
            <img src="assets/img/about/college-hostel.webp">
            <h5>Hostel</h5>
          </a>
        </div>

      </div>
    </div>

  </div>
</section>
<script>
document.addEventListener("DOMContentLoaded", function () {

  const track = document.getElementById("carouselTrack");

  // Clone items for seamless loop
  const items = track.children;
  const cloneCount = items.length;

  for (let i = 0; i < cloneCount; i++) {
    track.appendChild(items[i].cloneNode(true));
  }

  let position = 0;
  const speed = 0.4;

  function autoScroll() {
    position -= speed;

    if (Math.abs(position) >= track.scrollWidth / 2) {
      position = 0;
    }

    track.style.transform = `translate3d(${position}px, 0, 0)`;
    requestAnimationFrame(autoScroll);
  }

  autoScroll();

});
</script>
<!--==========================================
 SCHOOLS & DEPARTMENTS
 ===========================================-->
<section class="below-pg-title space py-5">
  <div class="container">
    <div class="title-area text-center pb-2"><h2 class="fw-bold mb-3">
      Schools &  <span class="text-warning">Departments</span>
    </h2>
    </div>
    <!-- Accordion for mobile -->
    <div class="accordion d-lg-none" id="sjuAccordion" style="background-color:#f1f1f1;">
      <div class="accordion-item">
        <h2 class="accordion-header" id="heading1">
          <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse1">School of Business</button>
        </h2>
        <div id="collapse1" class="accordion-collapse collapse show" data-bs-parent="#sjuAccordion">
          <div class="accordion-body">
            <h6 class="text-uppercase fw-bold">School of Business</h6>
            <a href="school-of-business/department-of-commerce/department-of-commerce.php" target="_blank" class="btn btn-theme me-2 mt-2">Commerce</a>
          <a href="school-of-business/department-of-management/department-of-management.php" target="_blank" class="btn btn-theme me-2 mt-2">Management</a>
          </div>
        </div>
      </div>
      <div class="accordion-item">
        <h2 class="accordion-header" id="heading2">
          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse2">School of Chemical Sciences</button>
        </h2>
        <div id="collapse2" class="accordion-collapse collapse" data-bs-parent="#sjuAccordion">
          <div class="accordion-body">
            <h6 class="text-uppercase fw-bold">School of Chemical Sciences</h6>
          <a href="school-of-chemical-sciences/department-of-biochemistry/department-of-biochemistry.php" target="_blank" class="btn btn-theme me-2 mt-2">Biochemistry</a>
          <a href="school-of-chemical-sciences/department-of-chemistry/department-of-chemistry.php" target="_blank" class="btn btn-theme me-2 mt-2">Chemistry</a>
          </div>
        </div>
      </div>
      <div class="accordion-item">
        <h2 class="accordion-header" id="heading4">
          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse3">
            School of Humanities & Social Sciences
          </button>
        </h2>
        <div id="collapse3" class="accordion-collapse collapse" data-bs-parent="#sjuAccordion">
          <div class="accordion-body">
            <h6 class="text-uppercase fw-bold">School of Humanities & Social Sciences</h6>
          <a href="school-of-humanities-and-social-sciences/department-of-economics/department-of-economics.php" target="_blank" class="btn btn-theme me-2 mt-2">Economics</a>
          <a href="school-of-humanities-and-social-sciences/department-of-history/department-of-history.php" target="_blank" class="btn btn-theme me-2 mt-2">History</a>
          <a href="school-of-humanities-and-social-sciences/department-of-industrial-relations/department-of-industrial-relations.php" target="_blank" class="btn btn-theme me-2 mt-2">Industrial Relations</a>
          <a href="school-of-humanities-and-social-sciences/department-of-international-relations-peace-and-public-policy/department-of-international-relations-peace-and-public-policy.php" target="_blank" class="btn btn-theme me-2 mt-2">International Relations, Peace and Pubic Policy</a>
          <a href="school-of-humanities-and-social-sciences/department-of-political-science/department-of-political-science.php" target="_blank" class="btn btn-theme me-2 mt-2">Political Science</a>
          <a href="school-of-humanities-and-social-sciences/department-of-psychology-and-counselling/department-of-psychology-and-counselling.php" target="_blank" class="btn btn-theme me-2 mt-2">Psychology and Counselling</a>
          <a href="school-of-humanities-and-social-sciences/department-of-social-science/department-of-social-science.php" target="_blank" class="btn btn-theme me-2 mt-2">Social Science</a>
          <a href="school-of-humanities-and-social-sciences/department-of-sociology/department-of-sociology.php" target="_blank" class="btn btn-theme me-2 mt-2">Sociology</a>
          </div>
        </div>
      </div>
      <div class="accordion-item">
        <h2 class="accordion-header" id="heading5">
          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse4">
            School of Languages & Literatures
          </button>
        </h2>
        <div id="collapse4" class="accordion-collapse collapse" data-bs-parent="#sjuAccordion">
          <div class="accordion-body">
            <h6 class="text-uppercase fw-bold">School of Languages & Literatures</h6>
           <a href="school-of-languages-and-literatures/department-of-english/department-of-english.php" target="_blank" class="btn btn-theme me-2 mt-2">English</a>
          <a href="school-of-languages-and-literatures/department-of-foreign-language/department-of-foreign-language.php" target="_blank" class="btn btn-theme me-2 mt-2">Foreign Language</a>
          <a href="school-of-languages-and-literatures/department-of-hindi/department-of-hindi.php" target="_blank" class="btn btn-theme me-2 mt-2">Hindi</a>
          <a href="school-of-languages-and-literatures/department-of-journalism/department-of-journalism.php" target="_blank" class="btn btn-theme me-2 mt-2">Journalism</a>
          <a href="school-of-languages-and-literatures/department-of-kannada/department-of-kannada.php" target="_blank" class="btn btn-theme me-2 mt-2">Kannada</a>
          <a href="school-of-languages-and-literatures/department-of-sanskrit/department-of-sanskrit.php" target="_blank" class="btn btn-theme me-2 mt-2">Sanskrit</a>
          <a href="school-of-languages-and-literatures/department-of-tamil/department-of-tamil.php" target="_blank" class="btn btn-theme me-2 mt-2">Tamil</a>
          </div>
        </div>
      </div>
      <div class="accordion-item">
        <h2 class="accordion-header" id="heading6">
          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse5">
            School of Life Sciences
          </button>
        </h2>
        <div id="collapse5" class="accordion-collapse collapse" data-bs-parent="#sjuAccordion">
          <div class="accordion-body">
            <h6 class="text-uppercase fw-bold">School of Life Sciences</h6>
           <a href="school-of-life-sciences/department-of-biology/department-of-biology.php" target="_blank" class="btn btn-theme me-2 mt-2">Biology</a>
           <a href="school-of-life-sciences/department-of-biotechnology/department-of-biotechnology.php" target="_blank" class="btn btn-theme me-2 mt-2">Biotechnology</a>
           <a href="school-of-life-sciences/department-of-botany/department-of-botany.php" target="_blank" class="btn btn-theme me-2 mt-2">Botany</a>
           <a href="school-of-life-sciences/department-of-enviornmental-science/department-of-enviornmental-science.php" target="_blank" class="btn btn-theme me-2 mt-2">Environmental Science</a>
           <a href="school-of-life-sciences/department-of-food-science-and-technology/department-of-food-science-and-technology.php" target="_blank" class="btn btn-theme me-2 mt-2">Food Science and Technology</a>
           <a href="school-of-life-sciences/department-of-microbiology/department-of-microbiology.php" target="_blank" class="btn btn-theme me-2 mt-2">Microbiology</a>
           <a href="school-of-life-sciences/department-of-zoology/department-of-zoology.php" target="_blank" class="btn btn-theme me-2 mt-2">Zoology</a>
          </div>
        </div>
      </div>
      <div class="accordion-item">
        <h2 class="accordion-header" id="heading7">
          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse6">School of Physical Sciences
          </button>
        </h2>
        <div id="collapse6" class="accordion-collapse collapse" data-bs-parent="#sjuAccordion">
          <div class="accordion-body">
            <h6 class="text-uppercase fw-bold">School of Physical Sciences</h6>
          <a href="school-of-physical-sciences/department-of-electronics/department-of-electronics.php" target="_blank" class="btn btn-theme me-2 mt-2">Electronics</a>
          <a href="school-of-physical-sciences/department-of-mathematics/department-of-mathematics.php" target="_blank" class="btn btn-theme me-2 mt-2">Mathematics</a>
          <a href="school-of-physical-sciences/department-of-physics/department-of-physics.php" target="_blank" class="btn btn-theme me-2 mt-2">Physics</a>
          <a href="school-of-physical-sciences/department-of-statistics/department-of-statistics.php" target="_blank" class="btn btn-theme me-2 mt-2">Statistics</a>
          </div>
        </div>
      </div>
      <div class="accordion-item">
        <h2 class="accordion-header" id="heading8">
          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse7">School of Social Work
          </button>
        </h2>
        <div id="collapse7" class="accordion-collapse collapse" data-bs-parent="#sjuAccordion">
          <div class="accordion-body">
            <h6 class="text-uppercase fw-bold">School of Social Work</h6>
          <a href="school-of-social-work/department-of-social-work/department-of-social-work.php" target="_blank" class="btn btn-theme me-2 mt-2">Social Work</a>
          </div>
        </div>
      </div>
      <div class="accordion-item">
        <h2 class="accordion-header" id="heading9">
          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse8">School of Communication & Media Studies
          </button>
        </h2>
        <div id="collapse8" class="accordion-collapse collapse" data-bs-parent="#sjuAccordion">
          <div class="accordion-body"><h6 class="text-uppercase fw-bold">School of Communication & Media Studies</h6>
          <a href="school-of-communication-media-studies/department-of-communication-media-studies/department-of-communication-media-studies.php" target="_blank" class="btn btn-theme me-2 mt-2">School of Communication & Media Studies</a>
          </div>
        </div>
      </div>
      <div class="accordion-item">
        <h2 class="accordion-header" id="heading9">
          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse9">School of Information Technology
          </button>
        </h2>
        <div id="collapse9" class="accordion-collapse collapse" data-bs-parent="#sjuAccordion">
          <div class="accordion-body">
          <h6 class="text-uppercase fw-bold">School of Information Technology</h6>
          <a href="school-of-information-technology/department-of-advanced-computing/department-of-advanced-computing.php" target="_blank" class="btn btn-theme me-2 mt-2">Advanced Computing</a>
          <a href="school-of-information-technology/department-of-computer-science/department-of-computer-science.php" target="_blank" class="btn btn-theme me-2 mt-2">Computer Science</a>
          </div>
        </div>
      </div>
    </div>
    <!-- Desktop Layout: Vertical Tabs -->
    <div class="d-none d-lg-flex mt-5">
      <div class="nav flex-column nav-pills me-4 sjric-tabs" id="v-pills-tab" role="tablist" aria-orientation="vertical">
        <button class="nav-link active" id="business-tab" data-bs-toggle="pill" data-bs-target="#business" type="button" role="tab">School of Business</button>
        <button class="nav-link" id="chemicalscience-tab" data-bs-toggle="pill" data-bs-target="#chemicalscience" type="button" role="tab">School of Chemical Sciences</button>
        <button class="nav-link" id="social-tab" data-bs-toggle="pill" data-bs-target="#social" type="button" role="tab">School of Humanities & Social Sciences</button>
        <button class="nav-link" id="language-tab" data-bs-toggle="pill" data-bs-target="#language" type="button" role="tab">School of Languages & Literatures</button>
        <button class="nav-link" id="lifescience-tab" data-bs-toggle="pill" data-bs-target="#lifescience" type="button" role="tab">School of Life Sciences</button>
        <button class="nav-link" id="physicalscience-tab" data-bs-toggle="pill" data-bs-target="#physicalscience" type="button" role="tab">School of Physical Sciences</button>
        <button class="nav-link" id="socialwork-tab" data-bs-toggle="pill" data-bs-target="#socialwork" type="button" role="tab">School of Social Work</button>
        <button class="nav-link" id="mediastudies-tab" data-bs-toggle="pill" data-bs-target="#mediastudies" type="button" role="tab">School of Communication & Media Studies</button>
        <button class="nav-link" id="infotech-tab" data-bs-toggle="pill" data-bs-target="#infotech" type="button" role="tab">School of Information Technology</button>
      </div>

      <div class="tab-content flex-grow-1 p-4 border rounded shadow-sm bg-white" id="v-pills-tabContent">
          
         <div class="tab-pane fade show active" id="business" role="tabpanel">
          <h6 class="text-uppercase fw-bold px-4">School of Business</h6>
          <a href="school-of-business/department-of-commerce/department-of-commerce.php" target="_blank" class="btn btn-theme mt-2">
              <img src="assets/img/academic/commerce.webp" alt="Commerce" width="200" class="rounded mb-2">
              <p>Commerce</p>
          </a>
          <a href="school-of-business/department-of-management/department-of-management.php" target="_blank" class="btn btn-theme mt-2">
              <img src="assets/img/academic/management.webp" alt="Management" width="200" class="rounded mb-2">
              <p>Management</p>
          </a>
         </div>
        
        <div class="tab-pane fade" id="chemicalscience" role="tabpanel">
          <h6 class="text-uppercase fw-bold px-4">School of Chemical Sciences</h6>
          <a href="school-of-chemical-sciences/department-of-biochemistry/department-of-biochemistry.php" target="_blank" class="btn btn-theme mt-2">
              <img src="assets/img/academic/Biochemistry.webp" alt="Biochemistry" width="200" class="rounded mb-2">
              <p>Biochemistry</p>
          </a>
          <a href="school-of-chemical-sciences/department-of-chemistry/department-of-chemistry.php" target="_blank" class="btn btn-theme mt-2">
              <img src="assets/img/academic/Chemistry.webp" alt="Chemistry" width="200" class="rounded mb-2">
              <p>Chemistry</p>
          </a>
        </div>
        
         <div class="tab-pane fade" id="social" role="tabpanel" style="align-items: stretch;">
          <h6 class="text-uppercase fw-bold px-4">School of Humanities & Social Sciences</h6>
          <a href="school-of-humanities-and-social-sciences/department-of-economics/department-of-economics.php" target="_blank" class="btn btn-theme">
              <img src="assets/img/academic/economics.webp" alt="Economics" width="200" class="rounded mb-2">
                <p>Economics</p>
          </a>
          <a href="school-of-humanities-and-social-sciences/department-of-history/department-of-history.php" target="_blank" class="btn btn-theme">
              <img src="assets/img/academic/history.webp" alt="History" width="200" class="mb-2">
                <p>History</p>
          </a>
          <a href="school-of-humanities-and-social-sciences/department-of-industrial-relations/department-of-industrial-relations.php" target="_blank" class="btn btn-theme">
              <img src="assets/img/academic/industrial-relations.webp" alt="Industrial Relations" width="200" class="rounded mb-2">
                <p>Industrial Relations</p>
          </a>
          <a href="school-of-humanities-and-social-sciences/department-of-international-relations-peace-and-public-policy/department-of-international-relations-peace-and-public-policy.php" target="_blank" class="btn btn-theme">
              <img src="assets/img/academic/international-relation.webp" alt="International Relations" width="200"  class="rounded mb-2">
                <p>International Relations, Peace & Pubic Policy</p>
          </a>
          <a href="school-of-humanities-and-social-sciences/department-of-political-science/department-of-political-science.php" target="_blank" class="btn btn-theme">
              <img src="assets/img/academic/political-science.webp" alt="Political Science" width="200" class="rounded mb-2">
                <p>Political Science</p>
          </a>
          <a href="school-of-humanities-and-social-sciences/department-of-psychology-and-counselling/department-of-psychology-and-counselling.php" target="_blank" class="btn btn-theme">
              <img src="assets/img/academic/psychology-counselling.webp" alt="Psychology and Counselling" width="200" class="rounded mb-2">
                <p>Psychology & Counselling</p>
          </a>
          <a href="school-of-humanities-and-social-sciences/department-of-social-science/department-of-social-science.php" target="_blank" class="btn btn-theme">
              <img src="assets/img/academic/social-science.webp" alt="Social Science" width="200" class="rounded mb-2">
                <p>Social Science</p>
          </a>
          <a href="school-of-humanities-and-social-sciences/department-of-sociology/department-of-sociology.php" target="_blank" class="btn btn-theme">
              <img src="assets/img/academic/sociology.webp" alt="Sociology" width="200" class="rounded mb-2">
              <p>Sociology</p>
          </a>
        </div>

        <div class="tab-pane fade" id="language" role="tabpanel" style="align-items: stretch;">
          <h6 class="text-uppercase fw-bold px-4">School of Languages & Literatures</h6>
           <a href="school-of-languages-and-literatures/department-of-english/department-of-english.php" target="_blank" class="btn btn-theme me-2 mt-2">
               <img src="assets/img/academic/english.webp" alt="English" width="200" class="rounded mb-2">
                 <p>English</p>
          </a>
          <a href="school-of-languages-and-literatures/department-of-foreign-language/department-of-foreign-language.php" target="_blank" class="btn btn-theme me-2 mt-2"><img src="assets/img/academic/foreign-language.webp" alt="Foreign Language" width="200" class="rounded mb-2">
                 <p>Foreign Language</p>
          </a>
          <a href="school-of-languages-and-literatures/department-of-hindi/department-of-hindi.php" target="_blank" class="btn btn-theme me-2 mt-2"><img src="assets/img/academic/academics.webp" alt="Hindi" width="200" class="rounded mb-2">
                 <p>Hindi</p>
          </a>
          <a href="school-of-languages-and-literatures/department-of-journalism/department-of-journalism.php" target="_blank" class="btn btn-theme me-2 mt-2"><img src="assets/img/academic/Journalism.webp" alt="Journalism" width="200" class="rounded mb-2">
                 <p>Journalism</p>
          </a>
          <a href="school-of-languages-and-literatures/department-of-kannada/department-of-kannada.php" target="_blank" class="btn btn-theme me-2 mt-2"><img src="assets/img/academic/english.webp" alt="Kannada" width="200" class="rounded mb-2">
                 <p>Kannada</p>
          </a>
          <a href="school-of-languages-and-literatures/department-of-sanskrit/department-of-sanskrit.php" target="_blank" class="btn btn-theme me-2 mt-2"><img src="assets/img/academic/sju-academics.webp" alt="Sanskrit" width="200" class="rounded mb-2">
                 <p>Sanskrit</p>
          </a>
          <a href="school-of-languages-and-literatures/department-of-tamil/department-of-tamil.php" target="_blank" class="btn btn-theme me-2 mt-2"><img src="assets/img/academic/sju-academics.webp" alt="Tamil" width="200" class="rounded mb-2">
                 <p>Tamil</p>
          </a>
        </div>

        <div class="tab-pane fade" id="lifescience" role="tabpanel" style="align-items: stretch;">
          <h6 class="text-uppercase fw-bold px-4">School of Life Sciences</h6>
           <a href="#" target="_blank" class="btn btn-theme me-2 mt-2"><img src="assets/img/academic/biology.webp" alt="Biology" width="200" class="rounded mb-2">
          <br>Biology</a>
          <a href="#" target="_blank" class="btn btn-theme me-2 mt-2"><img src="assets/img/academic/Biotechnology.webp" alt="Biotechnology" width="200" class="rounded mb-2">
          <br>Biotechnology</a>
          <a href="#" target="_blank" class="btn btn-theme me-2 mt-2"><img src="assets/img/academic/sju-academics.webp" alt="Botany" width="200" class="rounded mb-2">
          <br>Botany</a>
          <a href="#" target="_blank" class="btn btn-theme me-2 mt-2"><img src="assets/img/academic/english.webp" alt="Environmental Science" width="200" class="rounded mb-2">
          <br>Environmental Science</a>
          <a href="#" target="_blank" class="btn btn-theme me-2 mt-2"><img src="assets/img/academic/academics.webp" alt="Food Science and Technology" width="200" class="rounded mb-2">
          <br>Food Science and Technology</a>
          <a href="#" target="_blank" class="btn btn-theme me-2 mt-2"><img src="assets/img/academic/Biotechnology.webp" alt="Microbiology" width="200" class="rounded mb-2">
          <br>Microbiology</a>
          <a href="#" target="_blank" class="btn btn-theme me-2 mt-2"><img src="assets/img/academic/sju-academics.webp" alt="Zoology" width="200" class="rounded mb-2">
          <br>Zoology</a>
        </div>
        <div class="tab-pane fade" id="physicalscience" role="tabpanel" style="align-items: stretch;">
          <h6 class="text-uppercase fw-bold px-4">School of Physical Sciences</h6>
          <a href="school-of-physical-sciences/department-of-electronics/department-of-electronics.php" target="_blank" class="btn btn-theme me-2 mt-2"><img src="assets/img/academic/sju-academics.webp" alt="Electronics" width="200" class="rounded mb-2">
          <br>Electronics</a>
          <a href="school-of-physical-sciences/department-of-mathematics/department-of-mathematics.php" target="_blank" class="btn btn-theme me-2 mt-2"><img src="assets/img/academic/english.webp" alt="Mathematics" width="200" class="rounded mb-2">
          <br>Mathematics</a>
          <a href="school-of-physical-sciences/department-of-physics/department-of-physics.php" target="_blank" class="btn btn-theme me-2 mt-2"><img src="assets/img/academic/academics.webp" alt="Physics" width="200" class="rounded mb-2">
          <br>Physics</a>
          <a href="school-of-physical-sciences/department-of-statistics/department-of-statistics.php" target="_blank" class="btn btn-theme me-2 mt-2"><img src="assets/img/academic/sju-academics.webp" alt="Statistics" width="200" class="rounded mb-2">
          <br>Statistics</a>
        </div>
        <div class="tab-pane fade" id="socialwork" role="tabpanel">
          <h6 class="text-uppercase fw-bold px-4">School of Social Work</h6>
          <a href="school-of-social-work/department-of-social-work/department-of-social-work.php" target="_blank" class="btn btn-theme me-2 mt-2"><img src="assets/img/about/Holistic-education.webp" alt="Social Work" width="200" class="rounded mb-2">
          <br>Social Work</a>
        </div>
        <div class="tab-pane fade" id="mediastudies" role="tabpanel">
          <h6 class="text-uppercase fw-bold px-4">School of Communication & Media Studies</h6>
          <a href="#" target="_blank" class="btn btn-theme me-2 mt-2"><img src="assets/img/about/Holistic-education.webp" alt="Social Work" width="200" class="rounded mb-2">
          <br>School of Communication & Media Studies</a>
        </div>
        <div class="tab-pane fade" id="infotech" role="tabpanel">
          <h6 class="text-uppercase fw-bold px-4">School of Information Technology</h6>
          <a href="#" target="_blank" class="btn btn-theme me-2 mt-2"><img src="assets/img/academic/english.webp" alt="Social Work" width="200" class="rounded mb-2">
          <br>Advanced Computing</a>
          <a href="#" target="_blank" class="btn btn-theme me-2 mt-2"><img src="assets/img/academic/sju-academics.webp" alt="Social Work" width="200" class="rounded mb-2">
          <br>Computer Science</a>
        </div>
      </div>
    </div>
  </div>
</section>
<!--Support & Assistance-->
<!-- Features Section -->
<section class="quick-links py-5">
  <div class="container">
      <div class="title-area text-center pb-5"><h2 class="fw-bold mb-3">
      Support &  <span class="text-warning">Assistance</span>
    </h2>
    </div>
    <div class="row g-4 justify-content-center">
      <!-- Card 1 -->
      <div class="col-6 col-md-3">
        <div class="quick-link-item text-center p-4 rounded-3 h-100">
          <i class="fa fa-university fa-2x text-warning mb-3"></i>
          <h5 class="fw-semibold mb-0">Campus Ministry</h5>
        </div>
      </div>

      <!-- Card 2 -->
      <div class="col-6 col-md-3">
        <div class="quick-link-item text-center p-4 rounded-3  h-100">
          <i class="fa fa-cogs fa-2x text-warning mb-3"></i>
          <h5 class="fw-semibold mb-0">Campus Facilities</h5>
        </div>
      </div>

      <!-- Card 3 -->
      <div class="col-6 col-md-3">
        <div class="quick-link-item text-center p-4 rounded-3  h-100">
          <i class="fa fa-users fa-2x text-warning mb-3"></i>
          <h5 class="fw-semibold mb-0">Clubs & Associates</h5>
        </div>
      </div>

      <!-- Card 4 -->
      <div class="col-6 col-md-3">
        <div class="quick-link-item text-center p-4 rounded-3 h-100">
          <i class="fa fa-user-friends fa-2x text-warning mb-3"></i>
          <h5 class="fw-semibold mb-0">Counselling Services</h5>
        </div>
      </div>
      <div class="col-6 col-md-3">
        <div class="quick-link-item text-center p-4 rounded-3 h-100">
          <i class="fa fa-clipboard-list fa-2x text-warning mb-3"></i>
          <h5 class="fw-semibold mb-0">Examinations</h5>
        </div>
      </div>
      <div class="col-6 col-md-3">
        <div class="quick-link-item text-center p-4 rounded-3 h-100">
          <i class="fa fa-globe fa-2x text-warning mb-3"></i>
          <h5 class="fw-semibold mb-0">Global Initiative</h5>
        </div>
      </div>
      <div class="col-6 col-md-3">
        <div class="quick-link-item text-center p-4 rounded-3 h-100">
          <i class="fa fa-lightbulb fa-2x text-warning mb-3"></i>
          <h5 class="fw-semibold mb-0">HRDC (FDP)</h5>
        </div>
      </div>
      <div class="col-6 col-md-3">
        <div class="quick-link-item text-center p-4 rounded-3 h-100">
          <i class="fa fa-ribbon fa-2x text-warning mb-3"></i>
          <h5 class="fw-semibold mb-0">IQAC</h5>
        </div>
      </div>
      <div class="col-6 col-md-3">
        <div class="quick-link-item text-center p-4 rounded-3 h-100">
          <i class="fa fa-utensils fa-2x text-warning mb-3"></i>
          <h5 class="fw-semibold mb-0">Mid Day Meals</h5>
        </div>
      </div>
      <div class="col-6 col-md-3">
        <div class="quick-link-item text-center p-4 rounded-3 h-100">
          <i class="fa fa-briefcase fa-2x text-warning mb-3"></i>
          <h5 class="fw-semibold mb-0">Placements</h5>
        </div>
      </div>
      <div class="col-6 col-md-3">
        <div class="quick-link-item text-center p-4 rounded-3 h-100">
          <i class="fa fa-id-badge fa-2x text-warning mb-3"></i>
          <h5 class="fw-semibold mb-0">PRO</h5>
        </div>
      </div>
      <div class="col-6 col-md-3">
        <div class="quick-link-item text-center p-4 rounded-3 h-100">
          <i class="fa fa-graduation-cap fa-2x text-warning mb-3"></i>
          <h5 class="fw-semibold mb-0">Scholarships</h5>
        </div>
      </div>
      <div class="col-6 col-md-3">
        <div class="quick-link-item text-center p-4 rounded-3 h-100">
          <i class="fa fa-users fa-2x text-warning mb-3"></i>
          <h5 class="fw-semibold mb-0">Student Council</h5>
        </div>
      </div>
      <div class="col-6 col-md-3">
        <div class="quick-link-item text-center p-4 rounded-3 h-100">
          <i class="fa fa-books fa-2x text-warning mb-3"></i>
          <h5 class="fw-semibold mb-0">Library</h5>
        </div>
      </div>
      <div class="col-6 col-md-3">
        <div class="quick-link-item text-center p-4 rounded-3 h-100">
          <i class="fa fa-pen-square fa-2x text-warning mb-3"></i>
          <h5 class="fw-semibold mb-0">Research</h5>
        </div>
      </div> 
      <div class="col-6 col-md-3">
         
      </div>
      
    </div>
  </div>
</section>
<!--Upcoming events-->
<section class="events-section py-5">
  <div class="container">
    <h2 class="fw-bold mb-4 text-capitalize">Upcoming Events</h2>

    <div class="events-carousel-wrapper position-relative overflow-hidden">
      <div class="events-track d-flex">
        <!-- 6 Event Cards -->
        <div class="event-card">
          <div class="card h-100 shadow-sm border-0">
            <div class="card-header h-100 fw-bold rounded-top">
               Outcome Based Education for Educators 
                  <div class="event-date d-flex align-items-center mt-2">
                    <i class="bi bi-calendar-event me-2"></i><span>24 Aug 2025</span>
                  </div>
            </div>
            <div class="card-body bg-light">
              <p class="text-muted mb-0">Notice Regarding L\'Oreal India Young Women Scholarship UG</p>
            </div>
          </div>
        </div>

        <div class="event-card">
          <div class="card h-100 shadow-sm border-0">
            <div class="card-header h-100 fw-bold rounded-top">
               Ignatian Week Inauguration & AICUF Investiture Ceremony 
                  <div class="event-date d-flex align-items-center mt-2">
                    <i class="bi bi-calendar-event me-2"></i><span>25 Sept 2025</span>
                  </div>
            </div>
            <div class="card-body bg-light">
              <p class="text-muted mb-0">Foundation Course Supplementary Examination 2025-26 (For Non NEP Students)</p>
            </div>
          </div>
        </div>

        <div class="event-card">
          <div class="card h-100 shadow-sm border-0">
            <div class="card-header h-100 fw-bold rounded-top">
               Statistical Theory and Application for Trends 
                  <div class="event-date d-flex align-items-center mt-2">
                    <i class="bi bi-calendar-event me-2"></i><span>21 Oct 2025</span>
                  </div>
            </div>
            <div class="card-body bg-light">
              <p class="text-muted mb-0">Statistical Theory and Application for Trends and Online Webinar on The Importance of Entrepreneurship in India.</p>
            </div>
          </div>
        </div>

        <div class="event-card">
          <div class="card h-100 shadow-sm border-0">
            <div class="card-header h-100  fw-bold rounded-top">
               Women in Research Symposium 
                  <div class="event-date d-flex align-items-center mt-2">
                    <i class="bi bi-calendar-event me-2"></i><span>24 August 2025</span>
                  </div>
            </div>
            <div class="card-body bg-light">
              <p class="text-muted mb-0">Celebrating innovation and breakthroughs by women scientists.</p>
            </div>
          </div>
        </div>

        <div class="event-card">
          <div class="card h-100 shadow-sm border-0">
            <div class="card-header h-100  fw-bold rounded-top">
               AI in Education Forum 
                  <div class="event-date d-flex align-items-center mt-2">
                    <i class="bi bi-calendar-event me-2"></i><span>18 Oct 2025</span>
                  </div>
            </div>
            <div class="card-body bg-light">
              <p class="text-muted mb-0">Exploring artificial intelligence in modern learning systems.</p>
            </div>
          </div>
        </div>

        <div class="event-card">
          <div class="card h-100 shadow-sm border-0">
            <div class="card-header h-100  fw-bold rounded-top">
               Green Campus Drive 
                  <div class="event-date d-flex align-items-center mt-2">
                    <i class="bi bi-calendar-event me-2"></i><span>21 Oct 2025</span>
                  </div>
            </div>
            <div class="card-body bg-light">
              <p class="text-muted mb-0">Join us for our annual tree plantation and sustainability program.</p>
            </div>
          </div>
        </div>
      </div>

      <!-- Dot Navigation -->
      <div class="carousel-dots text-center mt-4 mb-5"></div>
    </div>
  </div>
</section>  

<section class="story-section py-5">
  <div class="container">
    <h2 class="text-center mb-5 fw-bold">Our <span class="text-warning">Alumni</span></h2>

    <div class="story-slider-wrapper position-relative">
      <!-- Navigation Buttons -->
      <button class="story-prev btn btn-nav">
        <i class="fa fa-chevron-left"></i>
      </button>

      <!-- Slider Track -->
      <div class="story-slider d-flex">
        <!-- Story Cards -->
        <div class="story-card text-center">
          <img src="assets/img/about/Indian-revenue-service-officer.webp" class="img-fluid rounded-top" alt="img">
          <div class="p-4 story-body rounded-bottom">
            <h5 class="fw-bold mb-1">Cap Pradeep Shoury Arya</h5>
            <p class="small mb-0">Indian Revenue Service Officer and Additional Commissioner of Income Tax, Mumbai</p>
          </div>
        </div>

        <div class="story-card text-center">
          <img src="assets/img/about/IIS-officer.webp" class="img-fluid rounded-top" alt="img">
          <div class="p-4 story-body rounded-bottom">
            <h5 class="fw-bold mb-1">Mr Frank Noronha</h5>
            <p class="small mb-0">IIS Officer</p>
          </div>
        </div>

        <div class="story-card text-center">
          <img src="assets/img/about/journalist.webp" class="img-fluid rounded-top" alt="img">
          <div class="p-4 story-body rounded-bottom">
            <h5 class="fw-bold mb-1">Ms Nabila Jamal</h5>
            <p class="small mb-0">Journalist Anchor India Today</p>
          </div>
        </div>
        <div class="story-card text-center">
          <img src="assets/img/about/indian-social-activist.webp" class="img-fluid rounded-top" alt="img">
          <div class="p-4 story-body rounded-bottom">
            <h5 class="fw-bold mb-1">Ms Sunitha Krishnan</h5>
            <p class="small mb-0">Indian Social Activist, Padma Shri Awardee</p>
          </div>
        </div>
        <div class="story-card text-center">
          <img src="assets/img/about/DGP.webp" class="img-fluid rounded-top" alt="img">
          <div class="p-4 story-body rounded-bottom">
            <h5 class="fw-bold mb-1">Dr Prateep V. Philip</h5>
            <p class="small mb-0">Director General of Police, Tamil Nadu</p>
          </div>
        </div>
        <div class="story-card text-center">
          <img src="assets/img/about/Indian-director.webp" class="img-fluid rounded-top" alt="img">
          <div class="p-4 story-body rounded-bottom">
            <h5 class="fw-bold mb-1">Mr Mahesh Dattani</h5>
            <p class="small mb-0">Indian Director, Actor, Playwright & Writer</p>
          </div>
        </div>
      </div>

      <!-- Next Button -->
      <button class="story-next btn btn-nav">
        <i class="fa fa-chevron-right"></i>
      </button>
    </div>
    <div class="text-center mt-5"><a href="#" class="btn btn-success fw-semibold px-4 py-2">
             View More <i class="fa fa-long-arrow-right ms-2"></i>
            </a></div>
  </div>
</section>

  <!-- ALUMNI SCROLLER (infinite horizontal)
  <section class="py-5 bg-white">
    <div class="container">
      <h3 class="section-title">Our Alumni</h3>

      <div class="alumni-scroller-wrapper mt-4">
        <div class="alumni-scroller" id="alumniScroller"> 
          <div class="alumni-card">
            <img src="assets/img/alumni1.jpg" alt="" />
            <div class="alumni-info">
              <h6>Mr Rajesh N Jagdale</h6>
              <small>Chairman & MD - Jagdale Industries</small>
            </div>
          </div>

          <div class="alumni-card">
            <img src="assets/img/alumni2.jpg" alt="" />
            <div class="alumni-info">
              <h6>Her Excellency Sajidha Mohamed</h6>
              <small>First Lady of the Maldives</small>
            </div>
          </div>

          <div class="alumni-card">
            <img src="assets/img/alumni3.jpg" alt="" />
            <div class="alumni-info">
              <h6>Mr Frank Noronha</h6>
              <small>IIS Officer</small>
            </div>
          </div>

          <div class="alumni-card">
            <img src="assets/img/alumni4.jpg" alt="" />
            <div class="alumni-info">
              <h6>Ms Nabila Jamal</h6>
              <small>Journalist, Anchor - India Today</small>
            </div>
          </div>

          <div class="alumni-card" aria-hidden="true">
            <img src="assets/img/alumni1.jpg" alt="" />
            <div class="alumni-info">
              <h6>Mr Rajesh N Jagdale</h6>
              <small>Chairman & MD - Jagdale Industries</small>
            </div>
          </div>
          <div class="alumni-card" aria-hidden="true">
            <img src="assets/img/alumni2.jpg" alt="" />
            <div class="alumni-info">
              <h6>Her Excellency Sajidha Mohamed</h6>
              <small>First Lady of the Maldives</small>
            </div>
          </div>
          <div class="alumni-card" aria-hidden="true">
            <img src="assets/img/alumni3.jpg" alt="" />
            <div class="alumni-info">
              <h6>Mr Frank Noronha</h6>
              <small>IIS Officer</small>
            </div>
          </div>
          <div class="alumni-card" aria-hidden="true">
            <img src="assets/img/alumni4.jpg" alt="" />
            <div class="alumni-info">
              <h6>Ms Nabila Jamal</h6>
              <small>Journalist, Anchor - India Today</small>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section> -->
<!--=======================GALLERY=======================
======================================================-->
<section class="mb-5">
    <div class="container py-5">
         <h2 class="text-center mb-5 fw-bold">Our <span class="text-warning">Gallery</span></h2>
    <div id="gallery" class="row g-3 row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4">
      <div class="col">
            <div class="gallery-item" data-index="3" data-full="assets/img/gallery/gallery_sju.webp" data-caption="Campus Life">
          <img src="assets/img/gallery/gallery_sju.webp" alt="Commerce Department">
        </div>
      </div>

      <div class="col">
        <div class="gallery-item" data-index="1" data-full="assets/img/gallery/sju-bangalore-.webp" data-caption="Faculty Session">
          <img src="assets/img/gallery/sju-bangalore-.webp" alt="Faculty Session">
        </div>
      </div>

      <div class="col">
        <div class="gallery-item" data-index="2" data-full="assets/img/gallery/bse-.webp" data-caption="Student Workshop">
          <img src="assets/img/gallery/bse-.webp" alt="Student Workshop">
        </div>
      </div>

      <div class="col">
        <div class="gallery-item" data-index="3" data-full="assets/img/gallery/sju-college.webp" data-caption="Campus Life">
          <img src="assets/img/gallery/sju-college.webp" alt="Campus Life">
        </div>
      </div>
      <div class="col">
        <div class="gallery-item" data-index="3" data-full="assets/img/gallery/sju-students-.webp" data-caption="Campus Life">
          <img src="assets/img/gallery/sju-students-.webp" alt="Campus Life">
        </div>
      </div>
      <div class="col">
        <div class="gallery-item" data-index="3" data-full="assets/img/gallery/sju-bengalore-.webp" data-caption="Campus Life">
          <img src="assets/img/gallery/sju-bengalore-.webp" alt="Campus Life">
        </div>
      </div>
      <div class="col">
        <div class="gallery-item" data-index="3" data-full="assets/img/gallery/sju-gallery.webp" data-caption="Campus Life">
          <img src="assets/img/gallery/sju-gallery.webp" alt="Campus Life">
        </div>
      </div>
      <div class="col">
        <div class="gallery-item" data-index="0" data-full="assets/img/gallery/sju-certification.webp" data-caption="Department of Commerce">
          <img src="assets/img/gallery/sju-certification.webp" alt="Campus Life">
        </div>
      </div>

    </div>
  </div>
   <div class="text-center mt-2"><a href="#" class="btn btn-success fw-semibold px-4 py-2">
             View More <i class="fa fa-long-arrow-right ms-2"></i>
            </a></div>

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
</section>
<!--Counter-->
<section class="py-5 text-center">
  <div class="container">
    <h2 class="fw-bold mb-5">SJU <span class="text-warning">in Numbers</span></h2>
    <div class="row g-4">
      
      <div class="col-6 col-md-3">
        <div class="counter-box p-4 rounded">
          <h2 class="counter text-warning fw-bold mb-2" data-target="142">0</h2>
          <p class="fw-semibold mb-0">Non Teaching Staff</p>
        </div>
      </div>

      <div class="col-6 col-md-3">
        <div class="counter-box p-4 rounded">
          <h2 class="counter text-warning fw-bold mb-2" data-target="204">0</h2>
          <p class="fw-semibold mb-0">Faculty with PHD</p>
        </div>
      </div>

      <div class="col-6 col-md-3">
        <div class="counter-box p-4 rounded">
          <h2 class="counter text-warning fw-bold mb-2" data-target="9">0</h2>
          <p class="fw-semibold mb-0">PG Diploma</p>
        </div>
      </div>

      <div class="col-6 col-md-3">
        <div class="counter-box p-4 rounded">
          <h2 class="counter text-warning fw-bold mb-2" data-target="38">0</h2>
          <p class="fw-semibold mb-0">UG Programmes</p>
        </div>
      </div>

      <div class="col-6 col-md-3">
        <div class="counter-box p-4 rounded">
          <h2 class="counter text-warning fw-bold mb-2" data-target="10723">0</h2>
          <p class="fw-semibold mb-0">Students</p>
        </div>
      </div>

      <div class="col-6 col-md-3">
        <div class="counter-box p-4 rounded">
          <h2 class="counter text-warning fw-bold mb-2" data-target="340">0</h2>
          <p class="fw-semibold mb-0">Academic Staff</p>
        </div>
      </div>

      <div class="col-6 col-md-3">
        <div class="counter-box p-4 rounded">
          <h2 class="counter text-warning fw-bold mb-2" data-target="13">0</h2>
          <p class="fw-semibold mb-0">PHD Programmes</p>
        </div>
      </div>

      <div class="col-6 col-md-3">
        <div class="counter-box p-4 rounded">
          <h2 class="counter text-warning fw-bold mb-2" data-target="22">0</h2>
          <p class="fw-semibold mb-0">PG Programmes</p>
        </div>
      </div>

    </div>
  </div>
</section>
  <!-- Footer injected -->
<?php include 'footer.php'; ?>
  <!-- Bootstrap JS bundle -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <!-- Custom JS -->
  <script src="assets/js/main.js"></script>
</body>
</html>
