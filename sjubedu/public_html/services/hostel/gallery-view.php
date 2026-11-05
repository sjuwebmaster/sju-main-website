<?php 
/**
 * 1. S3 FETCH LOGIC
 */
function get_sju_s3_images($folderPath) {
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
                // Get images, ignore folder markers
                if (preg_match('/\.(jpg|jpeg|png|webp|JPG|JPEG)$/i', $key) && !str_ends_with($key, '/')) {
                    
                    $pathParts = explode('/', $key);
                    // Get subfolder name (e.g., "Event Name (Ladies Hostel)") for the caption
                    $subFolder = (count($pathParts) > 4) ? $pathParts[count($pathParts) - 2] : '';
                    $filename = pathinfo($key, PATHINFO_FILENAME);
                    
                    $cleanCaption = !empty($subFolder) ? $subFolder : $filename;
                    $cleanCaption = ucwords(str_replace(['-', '_'], ' ', $cleanCaption));

                    $images[] = [
                        'url' => "https://{$bucket}.s3.{$region}.amazonaws.com/" . $key,
                        'caption' => $cleanCaption
                    ];
                }
            }
        } catch (Exception $e) {}
    }
    return $images;
}

// 2. DATA COLLECTION
$ladies_images = get_sju_s3_images('Hostel/Gallery/Ladies');
$gents_images  = get_sju_s3_images('Hostel/Gallery/Gents');

$all_images = [];
foreach($ladies_images as $img) { $img['cat'] = 'ladies'; $img['cat_label'] = 'Ladies Hostel'; $all_images[] = $img; }
foreach($gents_images as $img) { $img['cat'] = 'gents'; $img['cat_label'] = 'Gents Hostel'; $all_images[] = $img; }

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
<html lang="en" dir="ltr">

<head>
    <?php include $_SERVER['DOCUMENT_ROOT'] . '/gtm.php'; ?>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Hostel Terms and Conditions | St Joseph's University, Bengaluru</title>
    <meta name="description" content="Explore Hostel Terms and Conditions at St Joseph's University, Bengaluru — comfortable student accommodation with modern amenities, security and a vibrant campus life.">
    <meta name="keywords" content="Hostel Terms and Conditions SJU Bengaluru, university hostel Bengaluru, student hostel Bangalore university, SJU accommodation, college hostel Karnataka">
    <meta name="robots" content="INDEX,FOLLOW">
    <link rel="canonical" href="https://www.sju.edu.in/services/hostel/gallery-view">

    <!-- Open Graph / Social Sharing -->
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="St Joseph's University, Bengaluru">
    <meta property="og:title" content="Hostel Terms and Conditions | St Joseph's University, Bengaluru">
    <meta property="og:description" content="Explore Hostel Terms and Conditions at St Joseph's University, Bengaluru — comfortable student accommodation with modern amenities, security and a vibrant campus life.">
    <meta property="og:url" content="https://www.sju.edu.in/services/hostel/gallery-view">
    <meta property="og:image" content="https://www.sju.edu.in/assets/img/st-joseph-university-logo.png">
    <meta property="og:image:width" content="200">
    <meta property="og:image:height" content="200">
    <meta name="twitter:card" content="summary">
    <meta name="twitter:site" content="@StJosephsUniBLR">
    <meta name="twitter:title" content="Hostel Terms and Conditions | St Joseph's University, Bengaluru">
    <meta name="twitter:description" content="Explore Hostel Terms and Conditions at St Joseph's University, Bengaluru — comfortable student accommodation with modern amenities, security and a vibrant campus life.">
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
      "name": "Hostel",
      "item": "https://www.sju.edu.in/services/hostel/university-hostel"
    },
    {
      "@type": "ListItem",
      "position": 3,
      "name": "Hostel Terms and Conditions",
      "item": "https://www.sju.edu.in/services/hostel/gallery-view"
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
          <h1 class="page-title mb-2">  Hostel Terms and Conditions</h1>
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb justify-content-center mb-0">
              <li class="breadcrumb-item">
                <a href="/" class="text-white text-decoration-none">Home</a>
              </li>
              <li class="breadcrumb-item">
                <a href="university-hostel.php" class="text-white text-decoration-none">Hostel</a>
              </li>
              <li class="breadcrumb-item active text-warning" aria-current="page">
                  Hostel Terms and Conditions
              </li>
            </ol>
          </nav>
        </div>
      </div>
    </div>
  </div>
</section> 

    <section class="py-5 bg-light">
      <div class="container">
        
        <div class="text-center mb-5">
            <div class="btn-group shadow-sm rounded-pill p-1 bg-white border">
                <button class="btn filter-btn active rounded-pill px-4" onclick="filterGallery('all', this)">All Photos</button>
                <button class="btn filter-btn rounded-pill px-4" onclick="filterGallery('ladies', this)">Ladies Hostel</button>
                <button class="btn filter-btn rounded-pill px-4" onclick="filterGallery('gents', this)">Gents Hostel</button>
            </div>
        </div>

        <div class="row g-4 popup-gallery" id="gallery-grid">
            <?php foreach ($display_images as $img): ?>
                <div class="col-lg-3 col-md-4 col-sm-6 gallery-item" data-category="<?= $img['cat'] ?>">
                    <a href="<?= $img['url'] ?>" title="<?= $img['caption'] ?> (<?= $img['cat_label'] ?>)" class="gallery-card shadow-sm d-block text-decoration-none">
                        <div class="img-wrapper">
                            <img src="<?= $img['url'] ?>" class="img-fluid w-100" style="height:230px; object-fit:cover;">
                            <i class="bi bi-zoom-in zoom-icon"></i>
                        </div>
                        <div class="p-3 text-center border-top">
                            <span class="badge <?= $img['cat'] == 'ladies' ? 'bg-warning text-dark' : 'bg-primary' ?> mb-2">
                                <?= $img['cat_label'] ?>
                            </span>
                            <p class="mb-0 fw-bold small text-dark"><?= $img['caption'] ?></p>
                        </div>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>

        <?php if ($total_pages > 1): ?>
        <nav aria-label="Page navigation" class="mt-5">
          <ul class="pagination justify-content-center">
            <?php if($current_page > 1): ?>
                <li class="page-item"><a class="page-link" href="/services/hostel/gallery-view.php?page=<?= $current_page - 1 ?>">Previous</a></li>
            <?php endif; ?>

            <?php for($i = 1; $i <= $total_pages; $i++): ?>
                <li class="page-item <?= ($i == $current_page) ? 'active' : '' ?>">
                    <a class="page-link" href="/services/hostel/gallery-view.php?page=<?= $i ?>"><?= $i ?></a>
                </li>
            <?php endfor; ?>

            <?php if($current_page < $total_pages): ?>
                <li class="page-item"><a class="page-link" href="/services/hostel/gallery-view.php?page=<?= $current_page + 1 ?>">Next</a></li>
            <?php endif; ?>
          </ul>
        </nav>
        <?php endif; ?>

      </div>
    </section>

    <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/footer.php'; ?>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/jquery.magnific-popup.min.js"></script>

    <script>
    $(document).ready(function() {
        // Initialize Slideshow & Click to Zoom
        $('.popup-gallery').magnificPopup({
            delegate: 'a',
            type: 'image',
            gallery: {
                enabled: true,
                navigateByImgClick: true,
                preload: [0,1]
            },
            zoom: {
                enabled: true,
                duration: 300
            }
        });
    });

    function filterGallery(category, btn) {
        $('.filter-btn').removeClass('active');
        $(btn).addClass('active');

        if (category === 'all') {
            $('.gallery-item').fadeIn(400);
        } else {
            $('.gallery-item').hide();
            $('.gallery-item[data-category="' + category + '"]').fadeIn(400);
        }
    }
    </script>
</body>
</html>