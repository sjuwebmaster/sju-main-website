<?php 
/**
 * 1. S3 PREVIEW FETCH LOGIC
 */
function get_preview_images($folderPath, $limit = 7) {
    $bucket = 'sjub'; 
    $region = 'ap-south-1';
    $encodedPath = str_replace(' ', '+', trim($folderPath, '/')) . '/';
    $apiUrl = "https://{$bucket}.s3.{$region}.amazonaws.com/?prefix=" . $encodedPath;
    $images = [];
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $apiUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    $xmlContent = curl_exec($ch);
    curl_close($ch);
    if ($xmlContent !== false) {
        try {
            $xml = new SimpleXMLElement($xmlContent);
            $xml->registerXPathNamespace('s3', 'http://s3.amazonaws.com/doc/2006-03-01/');
            $nodes = $xml->xpath('//s3:Contents');
            if ($nodes) {
                foreach ($nodes as $node) {
                    $key = (string)$node->Key;
                    if (preg_match('/\.(jpg|jpeg|png|webp|JPG|JPEG)$/i', $key) && !str_ends_with($key, '/')) {
                        $images[] = "https://{$bucket}.s3.{$region}.amazonaws.com/" . str_replace(' ', '+', $key);
                    }
                    if (count($images) >= $limit) break; 
                }
            }
        } catch (Exception $e) {}
    }
    return $images;
}

$preview_imgs = get_preview_images('Hostel/Gallery/Ladies-B', 7);
if (count($preview_imgs) < 7) {
    $preview_imgs = array_pad($preview_imgs, 7, 'https://via.placeholder.com/800x600?text=SJU+Hostel');
}
?>
<!doctype html>
<html lang="en" dir="ltr">
<head>
    <?php @include $_SERVER['DOCUMENT_ROOT'] . '/gtm.php'; ?>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Ladies Hostel-B | St Joseph's University</title>
    
    <link rel="stylesheet" href="../../assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../assets/css/fontawesome.min.css">
    <link rel="stylesheet" href="../../assets/css/magnific-popup.min.css">
    <link rel="stylesheet" href="../../assets/css/style.css?v=2.3">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        /* --- NAVIGATION BAR FULL WIDTH & SOLID WHITE FIX --- */
        header, .header-main, .sticky-wrapper, .navbar {
            background-color: #ffffff !important;
            width: 100% !important;
            position: relative !important;
            z-index: 1050 !important;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .navbar .nav-link, .navbar a { color: #333333 !important; }

        /* --- BREADCRUMB HERO --- */
        .breadcrumb-hero { position: relative; z-index: 1; }

        /* --- GALLERY & PAGE DESIGN --- */
        .sidebar-nav-sticky { position: sticky; top: 120px; }
        .galleria-item img { width: 100%; object-fit: cover; display: block; transition: transform 0.3s ease; }
        .center-hero-h { height: 500px; }
        .fixed-stack-h { height: 160px; }
        .side-pill-h { height: 200px; }
        .rounded-start-pill { border-top-left-radius: 100px !important; border-bottom-left-radius: 100px !important; }
        .rounded-end-pill { border-top-right-radius: 100px !important; border-bottom-right-radius: 100px !important; }
        @media (max-width: 991px) { .center-hero-h { height: 350px; } .fixed-stack-h { height: 130px; } }
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
      "name": "Hostel",
      "item": "https://www.sju.edu.in/university-hostel"
    },
    {
      "@type": "ListItem",
      "position": 3,
      "name": "Ladies Hostel-B",
      "item": "https://www.sju.edu.in"
    }
  ]
}
</script>
</head>
<body>
    <?php require_once '../../header.php'; ?>
    
    <section class="breadcrumb-hero text-white" style="background: url('../../assets/img/breadcrumb-bg.jpg') center/cover;">
        <div class="overlay" style="background: rgba(0,0,0,0.6); position: absolute; top:0; left:0; width:100%; height:100%;"></div>
        <div class="container" style="position: relative; z-index: 2; padding: 60px 0;">
            <div class="row text-center">
                <div class="col-12">
                    <h1 class="page-title mb-2">Ladies Hostel-B</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb justify-content-center mb-0">
                            <li class="breadcrumb-item"><a href="/" class="text-white text-decoration-none">Home</a></li>
                            <li class="breadcrumb-item"><a href="university-hostel.php" class="text-white text-decoration-none">Hostel</a></li>
                            <li class="breadcrumb-item active text-warning">Ladies Hostel-B</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </section>

    <section class="py-5 px-4">
        <div class="container-fluid">
            <div class="row flex-column-reverse flex-lg-row">
                <aside class="col-lg-3 sidebar-nav-sticky">
                    <div class="sidebar-inner sticky-top" style="top: 100px;">
                        <h4 class="mb-4">SJU Hostel</h4>
                        <nav class="nav flex-column sidebar-nav">
                            <a href="university-hostel.php" class="nav-link"><i class="fa-solid fa-angle-right me-2"></i> About Hostel</a>
                            <a href="gents-hostel.php" class="nav-link"><i class="fa-solid fa-angle-right me-2"></i> Gents Hostel</a>
                            <a href="ladies-hostel.php" class="nav-link"><i class="fa-solid fa-angle-right me-2"></i> Ladies Hostel</a>
                            <a href="ladies-hostel-B.php" class="nav-link active"><i class="fa-solid fa-angle-right me-2"></i> Ladies Hostel-B</a> 
                        </nav>
                    </div>
                </aside>

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