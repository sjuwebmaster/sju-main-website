
<?php 
/**
 * 1. S3 PREVIEW FETCH LOGIC
 * Fetches exactly 7 images from the Ladies folder for the staggered layout
 */
function get_preview_images($folderPath, $limit = 7) {
    $bucket = 'sjub'; 
    $region = 'ap-south-1';
    $folderPath = trim($folderPath, '/') . '/';
    $apiUrl = "https://{$bucket}.s3.{$region}.amazonaws.com/?prefix=" . urlencode($folderPath);

    $images = [];
    $xmlContent = @file_get_contents($apiUrl);

    if ($xmlContent !== false) {
        try {
            $xml = new SimpleXMLElement($xmlContent);
            $xml->registerXPathNamespace('s3', 'http://s3.amazonaws.com/doc/2006-03-01/');
            $nodes = $xml->xpath('//s3:Contents');

            foreach ($nodes as $node) {
                $key = (string)$node->Key;
                if (preg_match('/\.(jpg|jpeg|png|webp|JPG|JPEG)$/i', $key) && !str_ends_with($key, '/')) {
                    $images[] = "https://{$bucket}.s3.{$region}.amazonaws.com/" . $key;
                }
                if (count($images) >= $limit) break; 
            }
        } catch (Exception $e) {}
    }
    return $images;
}

// Fetch 7 images specifically from the Ladies folder
$preview_imgs = get_preview_images('Hostel/Gallery/Ladies-B', 7);

// Fallback logic if S3 is empty
if (count($preview_imgs) < 7) {
    $preview_imgs = array_pad($preview_imgs, 7, 'https://via.placeholder.com/800x600?text=SJU+Hostel');
}
?>
<!doctype html>
<html lang="en" dir="ltr">

<head>
    <?php include $_SERVER['DOCUMENT_ROOT'] . '/gtm.php'; ?>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Ladies Hostel-B | St Joseph's University, Bengaluru</title>
    <meta name="description" content="Explore Ladies Hostel-B at St Joseph's University, Bengaluru — comfortable student accommodation with modern amenities, security and a vibrant campus life.">
    <meta name="keywords" content="Ladies Hostel-B SJU Bengaluru, university hostel Bengaluru, student hostel Bangalore university, SJU accommodation, college hostel Karnataka">
    <meta name="robots" content="INDEX,FOLLOW">
    <link rel="canonical" href="https://www.sju.edu.in/services/hostel/ladies-hostel-B">

    <!-- Open Graph / Social Sharing -->
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="St Joseph's University, Bengaluru">
    <meta property="og:title" content="Ladies Hostel-B | St Joseph's University, Bengaluru">
    <meta property="og:description" content="Explore Ladies Hostel-B at St Joseph's University, Bengaluru — comfortable student accommodation with modern amenities, security and a vibrant campus life.">
    <meta property="og:url" content="https://www.sju.edu.in/services/hostel/ladies-hostel-B">
    <meta property="og:image" content="https://www.sju.edu.in/assets/img/st-joseph-university-logo.png">
    <meta property="og:image:width" content="200">
    <meta property="og:image:height" content="200">
    <meta name="twitter:card" content="summary">
    <meta name="twitter:site" content="@StJosephsUniBLR">
    <meta name="twitter:title" content="Ladies Hostel-B | St Joseph's University, Bengaluru">
    <meta name="twitter:description" content="Explore Ladies Hostel-B at St Joseph's University, Bengaluru — comfortable student accommodation with modern amenities, security and a vibrant campus life.">
    <meta name="twitter:image" content="https://www.sju.edu.in/assets/img/st-joseph-university-logo.png">

    <!-- Mobile Specific Metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Favicons - Place favicon.ico in the root directory -->
    <link rel="icon" href="../../assets/img/favicon.png" type="image/png">
    <!-- Apple Touch Icon (for iOS home screen) -->
    <link rel="apple-touch-icon" href="../../assets/img/favicon-apple.png">
    <link rel="manifest" href="../../assets/img/favicons/manifest.json">
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
    <link rel="stylesheet" href="../../assets/css/bootstrap.min.css">
    <!-- Fontawesome Icon -->
    <link rel="stylesheet" href="../../assets/css/fontawesome.min.css">
    <!-- Magnific Popup -->
    <link rel="stylesheet" href="../../assets/css/magnific-popup.min.css">
    <!-- Swiper Js -->
    <link rel="stylesheet" href="../../assets/css/swiper-bundle.min.css">
    <!-- Theme Custom CSS -->
    <link rel="stylesheet" href="../../assets/css/style.css?v=2.3">
 <!--   <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
    <meta http-equiv="Pragma" content="no-cache" />
    <meta http-equiv="Expires" content="0" /> -->
<style>
    /* 1. Core Shapes & Alignment */
    .galleria-item img {
        width: 100%;
        object-fit: cover; /* Prevents images from stretching/squashing */
        display: block;
        transition: transform 0.3s ease;
    }
    
    .galleria-item:hover img {
        transform: scale(1.02);
    }

    /* 2. Fixed Heights to match the "Christ University" masonry look */
    .center-hero-h { 
        height: 500px; 
    }
    .fixed-stack-h { 
        height: 160px; 
    }
    .side-pill-h { 
        height: 200px; 
    }

    /* 3. Custom Blue Borders */
    .border-blue-2 { border: 2px solid #004a99 !important; }
    .border-blue-3 { border: 3px solid #004a99 !important; }
    .border-blue-4 { border: 4px solid #004a99 !important; }

    /* 4. Pill Rounding for the edges */
    .rounded-start-pill {
        border-top-left-radius: 100px !important;
        border-bottom-left-radius: 100px !important;
    }
    .rounded-end-pill {
        border-top-right-radius: 100px !important;
        border-bottom-right-radius: 100px !important;
    }

    /* 5. "View All Photos" Button Styling */
    .btn-view-all {
        border: 1px solid #ccc;
        background: #fff;
        color: #333;
        font-weight: 600;
        transition: 0.3s;
    }
    .btn-view-all:hover {
        background: #004a99;
        color: #fff;
        border-color: #004a99;
    }

    /* 6. Mobile Responsiveness */
    @media (max-width: 991px) {
        .center-hero-h { height: 350px; }
        .fixed-stack-h { height: 130px; }
    }
</style>
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
      "name": "Services",
      "item": "https://www.sju.edu.in/services"
    },
    {
      "@type": "ListItem",
      "position": 3,
      "name": "Hostel",
      "item": "https://www.sju.edu.in/services/hostel/university-hostel"
    },
    {
      "@type": "ListItem",
      "position": 4,
      "name": "Ladies Hostel-B",
      "item": "https://www.sju.edu.in/services/hostel/ladies-hostel-B"
    }
  ]
}
</script>
</head>
<body>
    <?php require_once '../../header.php'; ?>
    
<!--BREADCRUMB-->
 <section class="breadcrumb-hero text-white">
  <div class="overlay"></div>
  <div class="container">
    <div class="row">
      <div class="col-12">
        <div class="breadcrumb-content text-center">
          <h1 class="page-title mb-2"> Ladies Hostel-B</h1>
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb justify-content-center mb-0">
              <li class="breadcrumb-item">
                <a href="/" class="text-white text-decoration-none">Home</a>
              </li>
              <li class="breadcrumb-item">
                <a href="#" class="text-white text-decoration-none">Services</a>
              </li>
              <li class="breadcrumb-item">
                <a href="university-hostel.php" class="text-white text-decoration-none">Hostel</a>
              </li>
              <li class="breadcrumb-item active text-warning" aria-current="page">
                    Ladies Hostel-B
              </li>
            </ol>
          </nav>
        </div>
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
            <h4 class="mb-0">SJU Hostel</h4>
            <small>St Joseph's University</small>
          </div>

          <nav class="nav flex-column sidebar-nav">
            <a href="university-hostel.php" class="nav-link">
                <i class="fa-solid fa-angle-right me-2"></i> About Hostel
            </a>
            <a href="sju-hostel-administration.php" class="nav-link">
                <i class="fa-solid fa-angle-right me-2"></i> Hostel Administration
            </a>
            <a href="sju-academic-ambience.php" class="nav-link">
                <i class="fa-solid fa-angle-right me-2"></i>Academic Ambience
            </a> 
            <a href="sju-hostel-facilities.php" class="nav-link">
                <i class="fa-solid fa-angle-right me-2"></i> Facilities
            </a>

            <a href="sju-hostel-home-away-from-home.php" class="nav-link">
                <i class="fa-solid fa-angle-right me-2"></i> Home Away From Home
            </a>
            <a href="sju-hostel-life-events.php" class="nav-link">
                <i class="fa-solid fa-angle-right me-2"></i>Life and Events
            </a>
            <a href="sju-hostel-upcoming-events.php" class="nav-link">
                <i class="fa-solid fa-angle-right me-2"></i> Upcoming Events
            </a>
            <a href="gents-hostel.php" class="nav-link">
                <i class="fa-solid fa-angle-right me-2"></i> Gents Hostel
            </a>
            <a href="ladies-hostel.php" class="nav-link ">
                <i class="fa-solid fa-angle-right me-2"></i> Ladies Hostel
            </a> 
            <a href="ladies-hostel-B.php" class="nav-link active">
                <i class="fa-solid fa-angle-right me-2"></i> Ladies Hostel-B
            </a> 
          </nav>

        </div>
      </aside>

      <!-- Content -->
       <main class="col-lg-9">
                    <article class="mb-5">  
                        <div class="row align-items-center g-5">  
                            <div class="col-lg-7">
                                <span class="facility-tag">More About</span>
                                <h2 class="mt-3">Ladies Hostel-B</h2>
                                <p class="mt-3">The University has opened a second ladies' hostel located about 700 metres from the campus. It features modern amenities such as well-furnished rooms, hot water, Wi-Fi, recreation rooms, and washing machines.</p>
                            </div>  
                            <div class="col-lg-5 text-center">
                                <img src="https://sjub.s3.ap-south-1.amazonaws.com/Hostel/Images/Ladies+Hostel-B.png" class="img-fluid rounded shadow" alt="Ladies Hostel-B">
                            </div>
                        </div>
                    </article> 

                    <article class="mb-5">
                        <div class="mb-3"> 
                            <h2 class="guidelines-title mt-3">Total Available Rooms</h2>
                        </div>
                        <div class="guideline-item d-flex align-items-start mb-2">
                            <i class="bi bi-door-open guideline-icon me-2 text-primary"></i>
                            <p class="mb-0">Two-sharing – 17 rooms</p>
                        </div>
                        <div class="guideline-item d-flex align-items-start mb-3">
                            <i class="bi bi-door-open guideline-icon me-2 text-primary"></i>
                            <p class="mb-0">Three-sharing – 6 rooms</p>
                        </div>
                        <h6 class="sju-notice p-3 text-center fw-bold alert alert-success">Applications are Open</h6>
                    </article>

                    <article class="mb-5">
                        <div class="table-responsive">
                            <table class="table table-bordered align-middle fee-table">
                                <thead class="table-dark text-center">
                                    <tr><th colspan="2">St Joseph's University Ladies Hostel-B</th></tr>
                                    <tr><th colspan="2">Total Fees 2026-27 (in rupees)</th></tr>
                                </thead>
                                <tbody>
                                    <tr class="table-light"><th>Application Fee</th><td>₹150/-</td></tr>
                                    <tr><th>Admission fee</th><td>₹1,000/-</td></tr>
                                    <tr class="table-light"><th>Two Sharing</th><td>₹1,20,000/-</td></tr>
                                    <tr><th>Three Sharing</th><td>₹96,000/-</td></tr>
                                    <tr><th>Mess fee</th><td>₹60,000/-</td></tr>
                                    <tr><th>NRI Students Fee (Freshers)</th><td>₹10,000/-</td></tr>
                                </tbody>
                            </table>
                        </div>
                        
                        <div class="row g-4 mt-4">
                            <div class="col-md-6">
                                <div class="card-box p-3 border rounded text-center">
                                    <i class="fa-solid fa-envelope text-primary mb-2"></i>
                                    <h6>ladies.hostel@sju.edu.in</h6>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card-box p-3 border rounded text-center">
                                    <i class="fa-solid fa-phone text-primary mb-2"></i>
                                    <h6>+91 9480811923</h6>
                                </div>
                            </div>
                        </div>
                    </article>

                    <article class="text-center py-5">   
                        <div class="mb-4">
                            <a href="hostel-terms-conditions.php" target="_blank" class="px-2 text-primary text-decoration-none fw-bold">Terms and Conditions</a> |
                            <a href="../../assets/documents/Hostel-Refund-Policy.pdf" target="_blank" class="px-2 text-primary text-decoration-none fw-bold">Refund Policy</a> |
                            <a href="../../assets/documents/privacy-policy.pdf" target="_blank" class="px-2 text-primary text-decoration-none fw-bold">Privacy Policy</a>
                        </div>
                        <a href="https://sjuv4.linways.com/hostel/hostel-applicant/login" class="btn btn-warning btn-lg fw-bold px-5 py-3 mb-5" target="_blank">Hostel Login / Apply</a> 

                        <h4 class="mb-4">Ladies Hostel-B Accommodations</h4>
                        <div class="row justify-content-center g-4">
                            <div class="col-6 col-md-4"><img src="https://sjub.s3.ap-south-1.amazonaws.com/Hostel/Images/IMG_2715.jpg" class="img-fluid rounded shadow-sm" alt="Room View"></div>
                            <div class="col-6 col-md-4"><img src="https://sjub.s3.ap-south-1.amazonaws.com/Hostel/Images/IMG_2722.jpg" class="img-fluid rounded shadow-sm" alt="Interior"></div>
                            <div class="col-6 col-md-4"><img src="https://sjub.s3.ap-south-1.amazonaws.com/Hostel/Images/IMG_2726.jpg" class="img-fluid rounded shadow-sm" alt="Interior"></div>
                            <div class="col-6 col-md-3 mt-4"><img src="https://sjub.s3.ap-south-1.amazonaws.com/Hostel/Images/IMG_2707.jpg" class="img-fluid rounded shadow-sm" alt="Interior"></div>  
                            <div class="col-6 col-md-5 mt-4"><img src="https://sjub.s3.ap-south-1.amazonaws.com/Hostel/Images/IMG_2727.jpg" class="img-fluid rounded shadow-sm" alt="Interior"></div>
                        </div>
                    </article>
                </main>
            </div>
        </div>
    </section>

    <?php require_once '../../footer.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../../assets/js/main.js"></script>
</body>
</html>