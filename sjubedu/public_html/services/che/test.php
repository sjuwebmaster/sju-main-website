<?php 
/**
 * 1. S3 FETCH LOGIC
 */
function get_che_s3_images($folderPath) {
    $bucket = 'sjub'; 
    $region = 'ap-south-1';
    $folderPath = trim($folderPath, '/') . '/';
    $prefix = str_replace(' ', '+', $folderPath);
    $apiUrl = "https://{$bucket}.s3.{$region}.amazonaws.com/?prefix=" . $prefix;

    $images = [];
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $apiUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    $xmlContent = curl_exec($ch);
    curl_close($ch);

    if ($xmlContent) {
        try {
            $xml = new SimpleXMLElement($xmlContent);
            $xml->registerXPathNamespace('s3', 'http://s3.amazonaws.com/doc/2006-03-01/');
            $nodes = $xml->xpath('//s3:Contents');
            if ($nodes) {
                foreach ($nodes as $node) {
                    $key = (string)$node->Key;
                    if (preg_match('/\.(jpg|jpeg|png|webp)$/i', $key) && !str_ends_with($key, '/')) {
                        $filename = pathinfo($key, PATHINFO_FILENAME);
                        $cleanCaption = ucwords(str_replace(['-', '_'], ' ', $filename));
                        $encodedKey = implode('/', array_map('rawurlencode', explode('/', $key)));
                        $images[] = [
                            'url' => "https://{$bucket}.s3.{$region}.amazonaws.com/" . $encodedKey,
                            'caption' => $cleanCaption
                        ];
                    }
                }
            }
        } catch (Exception $e) {}
    }
    return $images;
}

$all_images = get_che_s3_images('Center for Human Excellence/Gallery');
?>
<!doctype html>
<html class="no-js" lang="en" dir="ltr">

<head>
    <?php @include '../../gtm.php'; ?>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Gallery | St Joseph's University</title>

    <link rel="stylesheet" href="../../assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../assets/css/fontawesome.min.css">
    <link rel="stylesheet" href="../../assets/css/magnific-popup.min.css">
    <link rel="stylesheet" href="../../assets/css/style.css?v=2.3">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        /* --- SCOPED GALLERY STYLES (Does not touch Header) --- */
        
        .gallery-container-main {
            margin-top: 30px;
        }

        /* Tabs Styling */
        .gallery-tab-nav {
            background: #f8f9fa;
            border: 1px solid #ddd;
            display: flex;
            justify-content: center;
            margin-bottom: 30px;
        }
        
        .gallery-tab-nav .nav-link {
            border: none;
            color: #333;
            font-weight: 700;
            padding: 15px 40px;
            text-transform: uppercase;
            font-size: 13px;
            border-radius: 0;
            transition: 0.3s;
        }

        .gallery-tab-nav .nav-link.active {
            background: #004282 !important;
            color: #fff !important;
        }

        /* Image Cards */
        .gallery-card-item {
            border: 1px solid #eee;
            border-radius: 8px;
            overflow: hidden;
            background: #fff;
            margin-bottom: 25px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.05);
        }

        .gallery-card-item img {
            height: 250px;
            width: 100%;
            object-fit: cover;
        }

        /* Video Carousel Fix */
        .video-slider-box {
            max-width: 900px;
            margin: 0 auto;
        }
        
        .carousel-control-prev-icon, .carousel-control-next-icon {
            background-color: #004282;
            border-radius: 50%;
            padding: 15px;
        }

        /* Sidebar Fix */
        .che-sidebar {
            position: sticky;
            top: 120px;
        }
    </style>
</head>

<body>
    <?php 
    // Header Include
    $root_path = realpath(__DIR__ . '/../../');
    if($root_path) { chdir($root_path); include 'header.php'; chdir(__DIR__); }
    else { include '../../header.php'; }
    ?>

    <section class="breadcrumb-hero" style="background: #f4f4f4; padding: 40px 0; border-bottom: 1px solid #ddd;">
        <div class="container text-center">
            <h2 class="fw-bold mb-1">Gallery</h2>
            <p class="text-muted mb-0">Home / Gallery</p>
        </div>
    </section>

    <div class="gallery-tab-nav shadow-sm">
        <ul class="nav nav-pills" id="pills-tab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="pills-photo-tab" data-bs-toggle="pill" data-bs-target="#pills-photo" type="button" role="tab"><i class="bi bi-images me-2"></i> Photo Gallery</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="pills-video-tab" data-bs-toggle="pill" data-bs-target="#pills-video" type="button" role="tab"><i class="bi bi-play-circle me-2"></i> Video Gallery</button>
            </li>
        </ul>
    </div>

    <div class="container-fluid gallery-container-main px-4">
        <div class="row">
            <aside class="col-lg-3">
                <div class="che-sidebar">
                    <div class="card p-3 shadow-sm border-0">
                        <nav class="nav flex-column sidebar-nav">
                            <a href="che" class="nav-link"><i class="fa-solid fa-angle-right me-2"></i> About</a>
                            <a href="che-team" class="nav-link"><i class="fa-solid fa-angle-right me-2"></i> Faculty</a>
                            <a href="che-gallery" class="nav-link active"><i class="fa-solid fa-angle-right me-2"></i> Gallery</a>
                            <a href="contact" class="nav-link"><i class="fa-solid fa-angle-right me-2"></i> Contact</a>
                        </nav>
                    </div>
                </div>
            </aside>

            <main class="col-lg-9">
                <div class="tab-content" id="pills-tabContent">
                    
                    <div class="tab-pane fade show active" id="pills-photo" role="tabpanel">
                        <div class="row g-4 popup-gallery">
                            <?php foreach ($all_images as $img): ?>
                                <div class="col-md-4">
                                    <div class="gallery-card-item">
                                        <a href="<?= $img['url'] ?>" title="<?= $img['caption'] ?>">
                                            <img src="<?= $img['url'] ?>" alt="">
                                            <div class="p-2 text-center bg-light border-top">
                                                <p class="mb-0 small fw-bold text-dark"><?= $img['caption'] ?></p>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="pills-video" role="tabpanel">
                        <div class="video-slider-box">
                            <div id="videoCarousel" class="carousel slide" data-bs-ride="false">
                                <div class="carousel-inner">
                                    <div class="carousel-item active">
                                        <div class="ratio ratio-16x9 shadow rounded overflow-hidden">
                                            <iframe src="https://www.youtube.com/embed/IPl_OkGI6eo?rel=0" allowfullscreen referrerpolicy="strict-origin-when-cross-origin"></iframe>
                                        </div>
                                    </div>
                                    <div class="carousel-item">
                                        <div class="ratio ratio-16x9 shadow rounded overflow-hidden">
                                            <iframe src="https://www.youtube.com/embed/IPl_OkGI6eo?rel=0" allowfullscreen referrerpolicy="strict-origin-when-cross-origin"></iframe>
                                        </div>
                                    </div>
                                </div>
                                <button class="carousel-control-prev" type="button" data-bs-target="#videoCarousel" data-bs-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                </button>
                                <button class="carousel-control-next" type="button" data-bs-target="#videoCarousel" data-bs-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                </button>
                            </div>
                        </div>
                    </div>

                </div>
            </main>
        </div>
    </div>

    <?php 
    if($root_path) { chdir($root_path); include 'footer.php'; chdir(__DIR__); }
    else { include '../../footer.php'; }
    ?>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/jquery.magnific-popup.min.js"></script>
    <script src="../../assets/js/main.js"></script>

    <script>
        $(document).ready(function() {
            $('.popup-gallery').magnificPopup({ delegate: 'a', type: 'image', gallery: { enabled: true } });
        });
    </script>
</body>
</html>