<?php 
/**
 * 1. S3 FETCH LOGIC (WITH BUILT-IN DEBUGGING)
 */
function get_che_s3_images($folderPath, &$debugLog) {
    $bucket = 'sjub'; 
    $region = 'ap-south-1';
    
    // Ensure folder path format
    $folderPath = trim($folderPath, '/') . '/';
    
    // AWS API Query prefix: Encode spaces as '+' for the API request
    $prefix = str_replace(' ', '+', $folderPath);
    $apiUrl = "https://{$bucket}.s3.{$region}.amazonaws.com/?prefix=" . $prefix;

    $debugLog['API_URL'] = $apiUrl;
    $images = [];
    $xmlContent = false;

    // Use cURL as it is more reliable than file_get_contents on strict servers
    if (function_exists('curl_version')) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $apiUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Prevent SSL block
        $xmlContent = curl_exec($ch);
        $debugLog['HTTP_Status'] = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $debugLog['cURL_Error'] = curl_error($ch);
        curl_close($ch);
        $debugLog['Fetch_Method'] = 'cURL';
    } else {
        $xmlContent = @file_get_contents($apiUrl);
        $debugLog['Fetch_Method'] = 'file_get_contents';
        if ($xmlContent === false) {
            $err = error_get_last();
            $debugLog['PHP_Error'] = $err ? $err['message'] : 'Unknown file_get_contents error';
        }
    }

    $debugLog['Raw_XML_Response'] = $xmlContent ? htmlspecialchars($xmlContent) : 'No response received.';

    if ($xmlContent !== false && !empty($xmlContent)) {
        try {
            $xml = new SimpleXMLElement($xmlContent);
            $xml->registerXPathNamespace('s3', 'http://s3.amazonaws.com/doc/2006-03-01/');
            
            // Check if AWS threw an error (like AccessDenied)
            if (isset($xml->Code) && isset($xml->Message)) {
                $debugLog['AWS_Error'] = (string)$xml->Code . " - " . (string)$xml->Message;
            }

            $nodes = $xml->xpath('//s3:Contents');
            if ($nodes) {
                foreach ($nodes as $node) {
                    $key = (string)$node->Key;
                    
                    // Match jpg, jpeg, png, webp (case-insensitive)
                    if (preg_match('/\.(jpg|jpeg|png|webp)$/i', $key) && !str_ends_with($key, '/')) {
                        
                        $filename = pathinfo($key, PATHINFO_FILENAME);
                        $cleanCaption = ucwords(str_replace(['-', '_'], ' ', $filename));

                        // Encode the final image URL correctly for browsers
                        $encodedKey = implode('/', array_map('rawurlencode', explode('/', $key)));

                        $images[] = [
                            'url' => "https://{$bucket}.s3.{$region}.amazonaws.com/" . $encodedKey,
                            'caption' => $cleanCaption
                        ];
                    }
                }
            } else {
                $debugLog['XML_Parsing'] = 'Found 0 <Contents> nodes. Path might be empty or incorrect.';
            }
        } catch (Exception $e) {
            $debugLog['XML_Parsing_Error'] = $e->getMessage();
        }
    }
    return $images;
}

// 2. DATA COLLECTION
$debugLog = [];
$all_images = get_che_s3_images('Center for Human Excellence/Gallery', $debugLog);

// 3. PAGINATION
$items_per_page = 12; 
$current_page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
if ($current_page < 1) $current_page = 1;

$total_images = count($all_images);
$total_pages = ceil($total_images / $items_per_page);
$start_index = ($current_page - 1) * $items_per_page;
$display_images = array_slice($all_images, $start_index, $items_per_page);
?>
<!doctype html>
<html class="no-js " lang="en" dir="ltr">

<head>
    <?php @include '../../gtm.php'; ?>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Gallery | Centre for Human Excellence | St Joseph's University</title>
    <meta name="description" content="St Joseph's University">
    <meta name="keywords" content="St Joseph's University">
    <link rel="canonical" href="https://www.sju.edu.in/services/che/gallery1">

    <!-- Open Graph / Social Sharing -->
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="St Joseph's University, Bengaluru">
    <meta property="og:title" content="Gallery | Centre for Human Excellence | St Joseph's University">
    <meta property="og:description" content="St Joseph's University">
    <meta property="og:url" content="https://www.sju.edu.in/services/che/gallery1">
    <meta property="og:image" content="https://www.sju.edu.in/assets/img/st-joseph-university-logo.png">
    <meta property="og:image:width" content="200">
    <meta property="og:image:height" content="200">
    <meta name="twitter:card" content="summary">
    <meta name="twitter:site" content="@StJosephsUniBLR">
    <meta name="twitter:title" content="Gallery | Centre for Human Excellence | St Joseph's University">
    <meta name="twitter:description" content="St Joseph's University">
    <meta name="twitter:image" content="https://www.sju.edu.in/assets/img/st-joseph-university-logo.png">

    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="icon" href="../../assets/img/favicon.png" type="image/png">
    <link rel="apple-touch-icon" href="../../assets/img/favicon-apple.png">
    <link rel="manifest" href="assets/img/favicons/manifest.json">
    <meta name="msapplication-TileColor" content="#ffffff">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400..900;1,400..900&family=Plus+Jakarta+Sans:ital,wght@0,200..800;1,200..800&family=Urbanist:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Arima:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <link rel="stylesheet" href="../../assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../assets/css/fontawesome.min.css">
    <link rel="stylesheet" href="../../assets/css/magnific-popup.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" /> <link rel="stylesheet" href="../../assets/css/style.css?v=2.3">

    <style>
        .gallery-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            border-radius: 12px;
            background: #fff;
            border: 1px solid rgba(0,0,0,0.05);
        }
        .gallery-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important;
        }
        .img-wrapper {
            position: relative;
            overflow: hidden;
            border-top-left-radius: 12px;
            border-top-right-radius: 12px;
        }
        .img-wrapper img {
            transition: transform 0.5s ease;
        }
        .gallery-card:hover .img-wrapper img {
            transform: scale(1.05);
        }
        .zoom-icon {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-size: 2rem;
            color: white;
            opacity: 0;
            transition: opacity 0.3s ease;
            background: rgba(25, 135, 84, 0.7);
            border-radius: 50%;
            width: 50px;
            height: 50px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .gallery-card:hover .zoom-icon {
            opacity: 1;
        }
        
        /* Swiper Slider adjustments */
        .swiper-button-next, .swiper-button-prev {
            background-color: rgba(255,255,255,0.8);
            border-radius: 50%;
            width: 40px;
            height: 40px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
        .swiper-button-next:after, .swiper-button-prev:after {
            font-size: 16px;
            font-weight: bold;
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
      "name": "Gallery",
      "item": "https://www.sju.edu.in/services/che/gallery1"
    }
  ]
}
</script>
</head>
<body>
    <?php 
    // Safe Header Include
    $root_path = realpath(__DIR__ . '/../../');
    if($root_path) { chdir($root_path); include 'header.php'; chdir(__DIR__); }
    else { include '../../header.php'; }
    ?>
    
<section class="breadcrumb-hero text-white">
  <div class="overlay"></div>
  <div class="container">
    <div class="row">
      <div class="col-12">
        <div class="breadcrumb-content text-center">
          <h1 class="page-title mb-2">Gallery</h1>
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb justify-content-center mb-0">
              <li class="breadcrumb-item"><a href="/" class="text-white text-decoration-none">Home</a></li>
              <li class="breadcrumb-item"><a href="#" class="text-white text-decoration-none">Services</a></li>
              <li class="breadcrumb-item active text-warning" aria-current="page">Gallery</li>
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

      <aside class="col-lg-3 sidebar sidebar-nav-sticky">
        <div class="sidebar-inner">
          <div class="sidebar-header mb-4">
            <h4 class="mb-0">Services</h4>           
          </div>
          <nav class="nav flex-column sidebar-nav">
            <a href="che" class="nav-link"><i class="fa-solid fa-angle-right me-2"></i> About The Department</a>
            <a href="chenotifications" class="nav-link"><i class="fa-solid fa-angle-right me-2"></i> Notifications</a> 
            <a href="chereports" class="nav-link"><i class="fa-solid fa-angle-right me-2"></i> Reports</a> 
            <a href="che-team" class="nav-link"><i class="fa-solid fa-angle-right me-2"></i> Faculty</a>
            <a href="cheprograms" class="nav-link"><i class="fa-solid fa-angle-right me-2"></i> Programs</a>
            <a href="ignitors" class="nav-link"><i class="fa-solid fa-angle-right me-2"></i> Ignitors Overview</a>
            <a href="upcoming-events" class="nav-link"><i class="fa-solid fa-angle-right me-2"></i> Upcoming Events</a>
            <a href="activities-conducted" class="nav-link"><i class="fa-solid fa-angle-right me-2"></i> Activities Conducted</a>
            <a href="che-gallery" class="nav-link active"><i class="fa-solid fa-angle-right me-2"></i> Gallery</a>
            <a href="contact" class="nav-link"><i class="fa-solid fa-angle-right me-2"></i> Contact Us</a>
          </nav>
        </div>
      </aside>

      <main class="col-lg-9 content-area">
          
          <div class="d-flex justify-content-between align-items-center mb-4">
              <h3 class="mb-0 fw-bold" style="font-family: 'Playfair Display', serif;">Photo Gallery</h3>
          </div>

          <div class="row g-4 popup-gallery" id="gallery-grid">
              <?php if (count($display_images) > 0): ?>
                  <?php foreach ($display_images as $img): ?>
                      <div class="col-lg-4 col-md-6 gallery-item">
                          <a href="<?= $img['url'] ?>" title="<?= $img['caption'] ?>" class="gallery-card shadow-sm d-block text-decoration-none h-100">
                              <div class="img-wrapper">
                                  <img src="<?= $img['url'] ?>" alt="<?= $img['caption'] ?>" class="img-fluid w-100" style="height:250px; object-fit:cover;">
                                  <i class="bi bi-arrows-fullscreen zoom-icon"></i>
                              </div>
                              <div class="p-3 text-center border-top bg-light">
                                  <p class="mb-0 fw-semibold small text-dark text-truncate"><?= $img['caption'] ?></p>
                              </div>
                          </a>
                      </div>
                  <?php endforeach; ?>
              <?php else: ?>
                  
                  <div class="col-12">
                      <div class="alert alert-danger shadow-sm border-0">
                          <h5 class="alert-heading text-danger fw-bold"><i class="bi bi-exclamation-triangle-fill me-2"></i>No Images Found - Diagnostic Mode</h5>
                          <p class="mb-2">The server could not fetch the images from AWS S3. Here is the technical data to help identify the problem:</p>
                          <hr>
                          <pre class="bg-dark text-light p-3 rounded small" style="overflow-x: auto;"><?php print_r($debugLog); ?></pre>
                      </div>
                  </div>

              <?php endif; ?>
          </div>

          <?php if ($total_pages > 1): ?>
          <nav aria-label="Gallery Page navigation" class="mt-5">
            <ul class="pagination justify-content-center">
              <?php if($current_page > 1): ?>
                  <li class="page-item"><a class="page-link" href="?page=<?= $current_page - 1 ?>">Previous</a></li>
              <?php endif; ?>

              <?php for($i = 1; $i <= $total_pages; $i++): ?>
                  <li class="page-item <?= ($i == $current_page) ? 'active' : '' ?>">
                      <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                  </li>
              <?php endfor; ?>

              <?php if($current_page < $total_pages): ?>
                  <li class="page-item"><a class="page-link" href="?page=<?= $current_page + 1 ?>">Next</a></li>
              <?php endif; ?>
            </ul>
          </nav>
          <?php endif; ?>


          <hr class="my-5 opacity-25">
          <div class="d-flex justify-content-between align-items-center mb-4">
              <h3 class="mb-0 fw-bold" style="font-family: 'Playfair Display', serif;">Video Gallery</h3>
          </div>

          <div class="swiper videoSwiper px-2 py-3">
              <div class="swiper-wrapper">
                  
                  <div class="swiper-slide pb-4">
                      <div class="card shadow-sm border-0 h-100 rounded-4 overflow-hidden">
                          <div class="ratio ratio-16x9">
                              <iframe src="https://www.youtube.com/embed/IPl_OkGI6eo?rel=0" title="Centre for Human Excellence" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen referrerpolicy="strict-origin-when-cross-origin"></iframe>
                          </div>
                          <div class="card-body bg-light text-center py-3">
                              <p class="mb-0 fw-semibold text-dark">Centre for Human Excellence Overview</p>
                          </div>
                      </div>
                  </div>

                  <div class="swiper-slide pb-4">
                      <div class="card shadow-sm border-0 h-100 rounded-4 overflow-hidden">
                          <div class="ratio ratio-16x9">
                              <iframe src="https://www.youtube.com/embed/" title="Video 2" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen referrerpolicy="strict-origin-when-cross-origin"></iframe>
                          </div>
                          <div class="card-body bg-light text-center py-3">
                              <p class="mb-0 fw-semibold text-dark">Student Testimonials</p>
                          </div>
                      </div>
                  </div>

                  <div class="swiper-slide pb-4">
                      <div class="card shadow-sm border-0 h-100 rounded-4 overflow-hidden">
                          <div class="ratio ratio-16x9">
                              <iframe src="https://www.youtube.com/embed/YOUR_3RD_VIDEO_ID?rel=0" title="Video 3" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen referrerpolicy="strict-origin-when-cross-origin"></iframe>
                          </div>
                          <div class="card-body bg-light text-center py-3">
                              <p class="mb-0 fw-semibold text-dark">Upcoming Events & Workshops</p>
                          </div>
                      </div>
                  </div>
                  
              </div>
              
              <div class="swiper-button-next" style="color: #004282;"></div>
              <div class="swiper-button-prev" style="color: #004282;"></div>
              <div class="swiper-pagination position-relative mt-2"></div>
          </div>
          </main>
  
    </div>
  </div>
</section>
  
<?php 
if($root_path) { chdir($root_path); include 'footer.php'; chdir(__DIR__); }
else { include '../../footer.php'; }
?>

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/jquery.magnific-popup.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
  <script src="../../assets/js/main.js"></script>

  <script>
  $(document).ready(function() {
      // 1. Initialize Photo Gallery Popups
      $('.popup-gallery').magnificPopup({
          delegate: 'a',
          type: 'image',
          tLoading: 'Loading image #%curr%...',
          mainClass: 'mfp-img-mobile',
          gallery: {
              enabled: true,
              navigateByImgClick: true,
              preload: [0,1] 
          },
          zoom: {
              enabled: true,
              duration: 300,
              easing: 'ease-in-out'
          },
          image: {
              tError: '<a href="%url%">The image #%curr%</a> could not be loaded.',
              titleSrc: function(item) {
                  return item.el.attr('title');
              }
          }
      });

      // 2. Initialize Video Slider
      var swiper = new Swiper(".videoSwiper", {
          slidesPerView: 1, // 1 video on mobile
          spaceBetween: 30, // Space between cards
          navigation: {
              nextEl: ".swiper-button-next",
              prevEl: ".swiper-button-prev",
          },
          pagination: {
              el: ".swiper-pagination",
              clickable: true,
          },
          breakpoints: {
              992: {
                  slidesPerView: 2, // 2 videos side-by-side on desktop
              }
          }
      });
  });
  </script>
</body>
</html>