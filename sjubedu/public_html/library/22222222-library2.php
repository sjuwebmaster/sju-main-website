<!doctype html>
<html class="no-js " lang="en" dir="ltr">

<head>
    <?php include $_SERVER['DOCUMENT_ROOT'] . '/gtm.php'; ?>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Learning Today,Leading Tomorrow | St Joseph's University, Bengaluru</title>
    <meta name="description" content="Access Learning Today,Leading Tomorrow at St Joseph's University, Bengaluru — e-journals, databases, rare collections and reading rooms for students, faculty and researchers.">
    <meta name="keywords" content="SJU library Bengaluru, university library Bangalore, e-journals university Karnataka, research library SJU, St Joseph's University library resources">
    <meta name="robots" content="INDEX,FOLLOW">
    <link rel="canonical" href="https://www.sju.edu.in/library/22222222-library2">

    <!-- Open Graph / Social Sharing -->
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="St Joseph's University, Bengaluru">
    <meta property="og:title" content="Learning Today,Leading Tomorrow | St Joseph's University, Bengaluru">
    <meta property="og:description" content="Access Learning Today,Leading Tomorrow at St Joseph's University, Bengaluru — e-journals, databases, rare collections and reading rooms for students, faculty and researchers.">
    <meta property="og:url" content="https://www.sju.edu.in/library/22222222-library2">
    <meta property="og:image" content="https://www.sju.edu.in/assets/img/st-joseph-university-logo.png">
    <meta property="og:image:width" content="200">
    <meta property="og:image:height" content="200">
    <meta name="twitter:card" content="summary">
    <meta name="twitter:site" content="@StJosephsUniBLR">
    <meta name="twitter:title" content="Learning Today,Leading Tomorrow | St Joseph's University, Bengaluru">
    <meta name="twitter:description" content="Access Learning Today,Leading Tomorrow at St Joseph's University, Bengaluru — e-journals, databases, rare collections and reading rooms for students, faculty and researchers.">
    <meta name="twitter:image" content="https://www.sju.edu.in/assets/img/st-joseph-university-logo.png">

    <!-- Mobile Specific Metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Favicons - Place favicon.ico in the root directory -->
    <link rel="icon" href="../assets/img/favicon.png" type="image/png">
    <!-- Apple Touch Icon (for iOS home screen) -->
    <link rel="apple-touch-icon" href="../assets/img/favicon-apple.png">
    <link rel="manifest" href="../assets/img/favicons/manifest.json">
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

</head>
<body>
    <?php include 'header.php';
    
    // Define potential paths for the configuration file
                           $config_paths = [
        '/home/sjubedu/config.php',
        __DIR__ . '/../config.php',
        __DIR__ . '/../../config.php',
        __DIR__ . '/../../../config.php'
    ];

    $config_loaded = false;

    // Loop through paths and load the first one that exists
    foreach ($config_paths as $path) {
        if (file_exists($path)) {
            require_once $path;
            $config_loaded = true;
            break;
        }
    }

    if (!$config_loaded) {
        die("Error: Configuration file not found.");
    }
    
    $config = file_exists('/home/sjubedu/config.php') ? '/home/sjubedu/config.php' : __DIR__ . '/../../config.php';
require_once $config;
$pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4", DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    

    date_default_timezone_set('Asia/Kolkata');

  $today = date('Y-m-d');

  ini_set('display_errors', 1); 
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
    ?>
 
<!-- HERO / Main carousel (infinite) -->
 <!-- Hero Slider Section -->
<section id="heroSlider" class="hero-slider position-relative">
  <div id="heroCarousel" class="carousel slide carousel-fade" data-bs-ride="carousel" data-bs-interval="3000">
    <div class="carousel-inner">

      <!-- Slide 1 -->
      <div class="carousel-item active">
        <div class="slide-bg" style="background-image: url('assets/img/banner/STAT-St-Joseph-college.webp');">
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

      <!-- Slide 2 -->
      <div class="carousel-item">
        <div class="slide-bg" style="background-image: url('assets/img/banner/st-joseph-university_.webp');">
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
      <div class="carousel-item">
        <div class="slide-bg" style="background-image: url('../assets/img/banner/sju-students.webp');">
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
      <div class="carousel-item">
        <div class="slide-bg" style="background-image: url('../assets/img/banner/university-in-bangalore.webp');">
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

    </div>

    <!-- Vertical Dots -->
    <div class="carousel-indicators flex-column align-items-end pe-3">
      <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="0" class="active" aria-current="true"></button>
      <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="1"></button>
      <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="2"></button>
      <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="3"></button>
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
<section class="news-section py-5 px-3">
  <div class="container">
    <div class="row g-4 align-items-stretch">

    <div class="col-lg-7 d-flex flex-column">
<h2 class="fw-bold text-blue mb-4">Announcements</h2>

<div id="announcementCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="4000">
<div class="carousel-inner">

<?php
$status = 'Y';
$department = "Library";

$sql = "SELECT n.title, n.slug, n.description, n.d_start_date
        FROM announcements n
        JOIN announcement_departments nd ON n.id = nd.announcement_id
        WHERE nd.c_department = :department
        AND n.c_status = :status
        AND n.d_start_date >= :today
        ORDER BY n.d_start_date DESC";

$stmtannouncement = $pdo->prepare($sql);
$stmtannouncement->bindParam(':department', $department);
$stmtannouncement->bindParam(':status', $status);
$stmtannouncement->bindParam(':today', $today);
$stmtannouncement->execute();

$announcementrows = $stmtannouncement->fetchAll(PDO::FETCH_ASSOC);
$totalannouncementCount = count($announcementrows);

$announcementcount = 0;

foreach ($announcementrows as $row) {

    // open new slide every 3 items
    if ($announcementcount % 3 == 0) {

        // close previous slide
        if ($announcementcount != 0) echo '</div>';

        // first slide active
        echo ($announcementcount == 0)
            ? '<div class="carousel-item active">'
            : '<div class="carousel-item">';

        $inner = 0; // reset inside-slide counter
    }

    // margin only for 2nd & 3rd items
    $marginClass = ($inner == 0) ? '' : 'mt-3';

    // format date
    $d_start_date = (!empty($row['d_start_date']) && $row['d_start_date'] != '0000-00-00')
        ? date('j F Y', strtotime($row['d_start_date']))
        : '';
?>
<a href="<?php echo LIVE_URL;?>announcement-detail.php?slug=<?php echo $row['slug'];?>">
      <div class="announcement-item p-4 rounded <?php echo $marginClass; ?>">
        <h6 class="fw-bold mb-1"><?php echo $d_start_date; ?></h6>
        <p class="mb-0"><?php echo htmlspecialchars($row['title']); ?></p>
    </div>
</a>
<?php
    $announcementcount++;
    $inner++;
}

// close last slide
if ($announcementcount > 0) echo '</div>';
?>

</div>
<div class="carousel-indicators-outside text-center mt-4">

<?php
$totalSlides = ceil($totalannouncementCount / 3);

for ($i = 0; $i < $totalSlides; $i++) {
?>
    <button type="button"
        data-bs-target="#announcementCarousel"
        data-bs-slide-to="<?php echo $i; ?>"
        class="<?php echo ($i == 0) ? 'active' : ''; ?>">
    </button>
<?php } ?>

</div>
</div>
</div>
         
  
     
      <div class="col-lg-5 d-flex flex-column">
        <h2 class="fw-bold text-warning mb-4">Latest News /Events</h2>

        <div id="newsCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="4000">
          <div class="carousel-inner">



<?php
              
          
$status = 'Y';
$department="Library";
 $sql = "SELECT n.title, n.slug, n.description, n.d_start_date
        FROM news n
        JOIN news_departments nd ON n.id = nd.news_id
        WHERE nd.c_department = :department
        AND n.c_status = :status
        AND n.d_start_date >= :today
        ORDER BY n.d_start_date DESC";

          $stmtnews = $pdo->prepare($sql);
          $stmtnews->bindParam(':department', $department);
          $stmtnews->bindParam(':status', $status);
          $stmtnews->bindParam(':today', $today);

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
                <a href="<?php echo LIVE_URL;?>news-detail.php?slug=<?php echo $newsrows['slug'];?>" class="btn btn-warning mt-2 fw-semibold px-3 py-2">
                  More <i class="fa fa-arrow-right ms-2"></i>
                </a>
              </div>
            </div>

           <?php 
                    }
                    ?>
          
          </div>
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
</section> 
<section class="sjric-search-section px-3">
  <div class="container"> 
        <h2 class="fw-bold mb-3 text_blue text-center">Library  <span class="text-warning">@ a Glance</span> </h2> 
        <div class="row align-items-stretch pt-4">
        <div class="col-lg-6 d-flex">
            <div class="info-card vision-card w-100">
                <ul class="language-list mt-4 p-0" style="list-style-type:none;">
                       <li class="pb-3"><i class="fas fa-check me-2" aria-hidden="true"></i>The library professionals and other team members at SJU Library are well qualified and well trained, with rich experience to provide optimum services and facilities to the users at all times.
                       <li class="pb-3"><i class="fas fa-check me-2" aria-hidden="true"></i>SJU Library is well equipped with modern infrastructure with 15 different sections.</li>
                       <li class="pb-3"><i class="fas fa-check me-2" aria-hidden="true"></i>The carpet area of the University Library is 21805.26 (in sq. ft.)</li>
                       <li class="pb-3"><i class="fas fa-check me-2" aria-hidden="true"></i>Adopted Open Access System.</li>
                       <li class="pb-3"><i class="fas fa-check me-2" aria-hidden="true"></i>Resources: Print, Electronic, Digital</li>
                       <li class="pb-3"><i class="fas fa-check me-2" aria-hidden="true"></i>Well-established e-learning resource centre with LAN-connected latest computers with the best internet bandwidth connectivity</li>
                       <li class="pb-3"><i class="fas fa-check me-2" aria-hidden="true"></i>Two android touchscreens have been installed at the digital library to provide library education to its users.</li>
                       <li class="pb-3"><i class="fas fa-check me-2" aria-hidden="true"></i>Library e-resources are remotely available 24/7 through Knimbus RAS software.</li>
                       <li class="pb-3"><i class="fas fa-check me-2" aria-hidden="true"></i>The library is fully automated, with the world's best Koha ILMS.</li>
                       <li class="pb-3"><i class="fas fa-check me-2" aria-hidden="true"></i>Using Dewey Decimal Classification (DDC) system for organising knowledge</li>
                       <li class="pb-3"><i class="fas fa-check me-2" aria-hidden="true"></i>Using MARC 21 format for bibliographic data capture</li>
                       <li class="pb-3"><i class="fas fa-check me-2" aria-hidden="true"></i>Using AACR-2 to catalogue the library documents</li>
                       <li class="pb-3"><i class="fas fa-check me-2" aria-hidden="true"></i>Auto-generated e-mail alert services for every library transaction</li>
                     </ul>
            </div>
        </div>
        <div class="col-lg-6 d-flex">
            <div class="info-card vision-card w-100">
                <ul class="language-list mt-4 p-0" style="list-style-type:none;">
                       <li class="pb-3"><i class="fas fa-check me-2" aria-hidden="true"></i>Installed DSpace for digital archive</li>
                        <li class="pb-3"><i class="fas fa-check me-2" aria-hidden="true"></i>Implemented RFID technology</li>
                        <li class="pb-3"><i class="fas fa-check me-2" aria-hidden="true"></i>Round-the-clock surveillance is made through the CCTVs</li>
                        <li class="pb-3"><i class="fas fa-check me-2" aria-hidden="true"></i>Computerised attendance system at the library entrance</li>
                        <li class="pb-3"><i class="fas fa-check me-2" aria-hidden="true"></i>The library catalogue is web-enabled.</li>
                        <li class="pb-3"><i class="fas fa-check me-2" aria-hidden="true"></i>Reference reading section with silent zone</li>
                        <li class="pb-3"><i class="fas fa-check me-2" aria-hidden="true"></i>The library offers a book bank facility for economically challenged students of all disciplines.</li>
                        <li class="pb-3"><i class="fas fa-check me-2" aria-hidden="true"></i>The library provides readers with the latest information services through new arrivals, announcement posters, newsletters, etc.</li>
                        <li class="pb-3"><i class="fas fa-check me-2" aria-hidden="true"></i>Each shelf has a shelf list, which indicates rack number, shelf number, class number and subjects concerned.</li>
                        <li class="pb-3"><i class="fas fa-check me-2" aria-hidden="true"></i>The library has a membership to access consortium e-resources from N-LIST & DELNET.</li>
                        <li class="pb-3"><i class="fas fa-check me-2" aria-hidden="true"></i>Semester question papers of the previous years are made available through the DSpace software.</li>
                        <li class="pb-3"><i class="fas fa-check me-2" aria-hidden="true"></i>Installed a good number of research tools and applications in the e-resource centre</li>
                     </ul>
            </div>
         </div>
    </div>
    
    
    <div id="gallery" class="row justify-content-center g-3 row-cols-1 row-cols-sm-2 row-cols-md-4 row-cols-lg-4">
      <div class="col">
            <div class="gallery-item" data-index="3" data-full="images/STAT-St-Joseph-college.webp" data-caption="library">
              <img src="images/STAT-St-Joseph-college.webp" alt="sju_sportsteam">
            </div>
      </div>

      <div class="col">
        <div class="gallery-item" data-index="1" data-full="images/psychology-counselling.webp" data-caption="library">
          <img src="images/psychology-counselling.webp" alt="library">
        </div>
      </div>  
      
      <div class="col">
        <div class="gallery-item" data-index="1" data-full="images/political-science.webp" data-caption="library">
          <img src="images/political-science.webp" alt="sports-team">
        </div>
      </div>  
      
      <div class="col">
        <div class="gallery-item" data-index="1" data-full="images/st-joseph-college-bengaluru.webp" data-caption="library">
          <img src="images/st-joseph-college-bengaluru.webp" alt="sports-team">
        </div>
      </div>  

    </div>
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
</section>
 
<!--About Section-->
<section class="welcome-section pt-4 px-3">
  <div class="container">
    <div class="row g-0 align-items-stretch">

      <!-- Left side background image -->
      <div class="col-lg-4 bg-cover" style="background-image: url('images/students.webp');"> </div>
      <!-- Right side content -->
      <div class="col-lg-8 d-flex flex-column justify-content-center content-box">
        <div class="mt-4 nss-article"> 

           <div class="nss-header"> <h3 class="fw-bold">Library Timings</h3> </div> 
           <div class="nss-body">  
              <div class="nss-item">
                 <div class="badge-icon">
                 <i class="bi bi-clock"></i>
                 </div>
                 <div>
                   <div class="nss-title fw-bold">Monday to Saturday</div>
                    
                   <div class="nss-text pb-2">06.30 AM TO 10.00 PM</div> 
                 </div>
              </div>
              
              <div class="nss-item">
                 <div class="badge-icon">
                 <i class="bi bi-clock"></i>
                 </div>
                 <div>
                   <div class="nss-title fw-bold">During Summer Vacation</div> 
                   <div class="nss-text pb-2">08.30 AM TO 04.30 PM</div> 
                 </div>
              </div>
              
              <div class="nss-item">
                 <div class="badge-icon">
                 <i class="bi bi-clock"></i>
                 </div>
                 <div>
                   <div class="nss-title fw-bold">Sunday's</div> 
                   <div class="nss-text pb-2">Holiday</div> 
                 </div>
              </div>
              
              <div class="nss-item">
                 <div class="badge-icon">
                 <i class="bi bi-clock"></i>
                 </div>
                 <div>
                   <div class="nss-title fw-bold">During Govt. Holiday's</div> 
                   <div class="nss-text pb-2">Holiday</div> 
                 </div>
              </div>

              </div> 
           
        </div>
      </div>
    </div>
  </div>
</section>

<!--Newly Arrived Books in the Central Library-->
<section class="events-section py-5 px-3">
  <div class="container">
    <h2 class="fw-bold mb-4 text-capitalize text-center text_blue"><span class="text-warning">Newly Arrived Books</span> in the Central Library</h2>

    <div class="events-carousel-wrapper position-relative overflow-hidden">
      <div class="events-track d-flex"> 

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

<section class="story-section pb-5 px-3">
  <div class="container">
     <h2 class="fw-bold mb-4 text-capitalize text-center text_blue"><span class="text-warning">Newly Arrived Books</span> in the Central Library</h2>

    <div class="story-slider-wrapper position-relative">
      <!-- Navigation Buttons -->
      <button class="story-prev btn btn-nav">
        <i class="fa fa-chevron-left"></i>
      </button>

      <!-- Slider Track -->
      <div class="story-slider d-flex">
        <!-- Story Cards -->
        <div class="story-card text-center"> 
          <div class="p-4 story-body rounded-bottom">
            <h6 class="fw-bold pb-2">The Public Policy Primer</h6>
             <img src="images/The-Public-Policy-Primer.jpg" class="img-fluid rounded-top" alt="img">
          </div>
        </div>

        <div class="story-card text-center"> 
          <div class="p-4 story-body rounded-bottom">
            <h6 class="fw-bold pb-2">The Public Policy Primer</h6>
             <img src="images/The-Public-Policy-Primer.jpg" class="img-fluid rounded-top" alt="img">
          </div>
        </div>

        <div class="story-card text-center"> 
          <div class="p-4 story-body rounded-bottom">
            <h6 class="fw-bold pb-2">The Public Policy Primer</h6>
             <img src="images/The-Public-Policy-Primer.jpg" class="img-fluid rounded-top" alt="img">
          </div>
        </div>
        <div class="story-card text-center"> 
          <div class="p-4 story-body rounded-bottom">
            <h6 class="fw-bold pb-2">The Public Policy Primer</h6>
             <img src="images/The-Public-Policy-Primer.jpg" class="img-fluid rounded-top" alt="img">
          </div>
        </div>
        <div class="story-card text-center"> 
          <div class="p-4 story-body rounded-bottom">
            <h6 class="fw-bold pb-2">The Public Policy Primer</h6>
             <img src="images/The-Public-Policy-Primer.jpg" class="img-fluid rounded-top" alt="img">
          </div>
        </div>
        <div class="story-card text-center"> 
          <div class="p-4 story-body rounded-bottom">
            <h6 class="fw-bold pb-2">The Public Policy Primer</h6>
             <img src="images/The-Public-Policy-Primer.jpg" class="img-fluid rounded-top" alt="img">
          </div>
        </div>
      </div>

      <!-- Next Button -->
      <button class="story-next btn btn-nav">
        <i class="fa fa-chevron-right"></i>
      </button>
    </div> 
  </div>
</section> 
<!-- Features Section -->
<section class="council-section py-5 px-3">
  <div class="container">
      <div class="title-area text-center pb-5"><h2 class="fw-bold mb-3">
       Quick <span class="text-warning"> Links</span>
    </h2>
    </div>
    <div class="row g-4 justify-content-center">
      <!-- Card 1 -->
      <div class="col-6 col-md-3">
        <div class="member-card text-center p-4 rounded-3 h-100">
          <img src="images/icon_1.png" alt="Web-OPAC" class="pb-3">
          <h5 class="fw-semibold mb-0"> Web-OPAC </h5>
        </div>
      </div>

      <!-- Card 2 -->
      <div class="col-6 col-md-3">
        <div class="member-card text-center p-4 rounded-3  h-100">
           <img src="images/icon_2.png" alt=" Digital Initiatives" class="pb-3">
          <h5 class="fw-semibold mb-0"> Digital Initiatives  </h5>
        </div>
      </div>

      <!-- Card 3 -->
      <div class="col-6 col-md-3">
        <div class="member-card text-center p-4 rounded-3  h-100">
           <img src="images/icon_3.png" alt=" Library IT Infrastructure" class="pb-3">
          <h5 class="fw-semibold mb-0"> Library IT Infrastructure  </h5>
        </div>
      </div>

      <!-- Card 4 -->
      <div class="col-6 col-md-3">
        <div class="member-card text-center p-4 rounded-3 h-100">
           <img src="images/icon_4.png" alt="  Library Automation " class="pb-3">
          <h5 class="fw-semibold mb-0">  Library Automation  </h5>
        </div>
      </div>
      <div class="col-6 col-md-3">
        <div class="member-card text-center p-4 rounded-3 h-100">
           <img src="images/icon_5.png" alt="RFID" class="pb-3">
          <h5 class="fw-semibold mb-0"> RFID  </h5>
        </div>
      </div>
      <div class="col-6 col-md-3">
        <div class="member-card text-center p-4 rounded-3 h-100">
           <img src="images/icon_6.png" alt="Braille Section" class="pb-3">
          <h5 class="fw-semibold mb-0"> Braille Section  </h5>
        </div>
      </div>
      <div class="col-6 col-md-3">
        <div class="member-card text-center p-4 rounded-3 h-100">
           <img src="images/icon_7.png" alt=" Talking Digital Library" class="pb-3">
          <h5 class="fw-semibold mb-0"> Talking Digital Library  </h5>
        </div>
      </div> 
      
    </div>
  </div>
</section>



 
<!--Counter-->
<section class="py-5 text-center px-3">
  <div class="container">
    <h2 class="fw-bold mb-5">Library <span class="text-warning">Collections</span></h2>
    <div class="row g-4 justify-content-center">
      
      <div class="col-6 col-md-3">
        <div class="counter-box p-4 rounded">
          <h2 class="counter text-warning fw-bold mb-2" data-target="66552">0</h2>
          <p class="fw-semibold mb-0">Books </p>
        </div>
      </div>

      <div class="col-6 col-md-3">
        <div class="counter-box p-4 rounded">
          <h2 class="counter text-warning fw-bold mb-2" data-target="22">0</h2>
          <p class="fw-semibold mb-0">Journal </p>
        </div>
      </div>

      <div class="col-6 col-md-3">
        <div class="counter-box p-4 rounded">
          <h2 class="counter text-warning fw-bold mb-2" data-target="9970">0</h2>
          <p class="fw-semibold mb-0">Reference Books</p>
        </div>
      </div>

      <div class="col-6 col-md-3">
        <div class="counter-box p-4 rounded">
          <h2 class="counter text-warning fw-bold mb-2" data-target="837">0</h2>
          <p class="fw-semibold mb-0">Back Bounded Volumes</p>
        </div>
      </div>

      <div class="col-6 col-md-3">
        <div class="counter-box p-4 rounded">
          <h2 class="counter text-warning fw-bold mb-2" data-target="1168">0</h2>
          <p class="fw-semibold mb-0">Book Bank Books</p>
        </div>
      </div>

      <div class="col-6 col-md-3">
        <div class="counter-box p-4 rounded">
          <h2 class="counter text-warning fw-bold mb-2" data-target="1871">0</h2>
          <p class="fw-semibold mb-0">Donated Books</p>
        </div>
      </div>

      <div class="col-6 col-md-3">
        <div class="counter-box p-4 rounded">
          <h2 class="counter text-warning fw-bold mb-2" data-target="671">0</h2>
          <p class="fw-semibold mb-0">Student Dissertations </p>
        </div>
      </div>

      <div class="col-6 col-md-3">
        <div class="counter-box p-4 rounded">
          <h2 class="counter text-warning fw-bold mb-2" data-target="33">0</h2>
          <p class="fw-semibold mb-0">Magazines </p>
        </div>
      </div>

      <div class="col-6 col-md-3">
        <div class="counter-box p-4 rounded">
          <h2 class="counter text-warning fw-bold mb-2" data-target="15">0</h2>
          <p class="fw-semibold mb-0">News Papers  </p>
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
  <script src="../assets/js/main.js"></script>
</body>
</html>
