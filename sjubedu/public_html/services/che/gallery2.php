<?php
/**
 * Fetch images from S3 and caption them as "Ignitors 1", "Ignitors 2", etc.
 */
function get_ignitors_photos($folderPath) {
    $bucket = 'sjub';
    $region = 'ap-south-1';
    $folderPath = trim($folderPath, '/') . '/';
    $prefix  = str_replace(' ', '+', $folderPath);
    $apiUrl  = "https://{$bucket}.s3.{$region}.amazonaws.com/?prefix=" . $prefix;

    $xmlContent = false;
    if (function_exists('curl_version')) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $apiUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $xmlContent = curl_exec($ch);
        curl_close($ch);
    } else {
        $xmlContent = @file_get_contents($apiUrl);
    }

    $images = [];
    if ($xmlContent) {
        try {
            $xml = new SimpleXMLElement($xmlContent);
            $xml->registerXPathNamespace('s3', 'http://s3.amazonaws.com/doc/2006-03-01/');
            $nodes = $xml->xpath('//s3:Contents');
            if ($nodes) {
                $counter = 1;
                foreach ($nodes as $node) {
                    $key = (string)$node->Key;
                    if (preg_match('/\.(jpg|jpeg|png|webp)$/i', $key) && !str_ends_with($key, '/')) {
                        $encodedKey = implode('/', array_map('rawurlencode', explode('/', $key)));
                        $images[] = [
                            'url'     => "https://{$bucket}.s3.{$region}.amazonaws.com/" . $encodedKey,
                            'caption' => 'Ignitors ' . $counter,
                        ];
                        $counter++;
                    }
                }
            }
        } catch (Exception $e) { /* silent */ }
    }
    return $images;
}

// Update folder path below if photos live in a different S3 sub-folder
$photos = get_ignitors_photos('Center for Human Excellence/Gallery');

// ── YouTube video list ─────────────────────────────────────────────────────
// Add/remove entries: ['id' => 'YOUTUBE_VIDEO_ID', 'title' => 'Caption']
$videos = [
    ['id' => 'IPl_OkGI6eo',   'title' => 'Centre for Human Excellence Overview'],
    ['id' => 'PpRTIBAnaPg',   'title' => 'IGNITORS – Centre for Human Excellence'],
    // ['id' => 'THIRD_VIDEO_ID', 'title' => 'Third Video Title'],
];
?>
<!doctype html>
<html class="no-js" lang="en" dir="ltr">
<head>
    <?php @include $_SERVER['DOCUMENT_ROOT'] . '/gtm.php'; ?>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Gallery | Centre for Human Excellence | St Joseph's University</title>
    <meta name="description" content="Photo and video gallery of the Centre for Human Excellence, St Joseph's University, Bengaluru.">
    <link rel="canonical" href="https://www.sju.edu.in/services/che/gallery2">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="icon" href="../../assets/img/favicon.png" type="image/png">
    <link rel="apple-touch-icon" href="../../assets/img/favicon-apple.png">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400..900;1,400..900&family=Plus+Jakarta+Sans:ital,wght@0,200..800;1,200..800&family=Urbanist:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <link rel="stylesheet" href="../../assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../assets/css/fontawesome.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">
    <link rel="stylesheet" href="../../assets/css/style.css?v=2.3">

    <style>
        /* ── Section labels ─────────────────────────────── */
        .gallery-section-label {
            font-family: 'Playfair Display', serif;
            font-size: 1.5rem;
            font-weight: 700;
            color: #198754;
            margin-bottom: 1.5rem;
            padding-bottom: .6rem;
            border-bottom: 3px solid #198754;
            display: flex;
            align-items: center;
            gap: .6rem;
        }
        .section-divider {
            border: none;
            border-top: 2px solid #e9ecef;
            margin: 3.5rem 0 2.5rem;
        }

        /* ── Photo Slideshow ─────────────────────────────── */
        .photoSwiper {
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 8px 32px rgba(0,0,0,0.12);
        }
        .photoSwiper .swiper-slide img {
            width: 100%;
            height: clamp(260px, 45vw, 520px);
            object-fit: cover;
            display: block;
        }
        .photoSwiper .slide-caption {
            background: rgba(0,0,0,0.55);
            color: #fff;
            text-align: center;
            padding: .6rem 1rem;
            font-size: .9rem;
            font-weight: 600;
            letter-spacing: .03em;
        }
        /* Nav arrows */
        .photoSwiper .swiper-button-next,
        .photoSwiper .swiper-button-prev {
            background: rgba(255,255,255,0.85);
            border-radius: 50%;
            width: 44px; height: 44px;
            box-shadow: 0 3px 10px rgba(0,0,0,0.15);
        }
        .photoSwiper .swiper-button-next:after,
        .photoSwiper .swiper-button-prev:after {
            font-size: 16px; font-weight: 900; color: #198754;
        }
        .photoSwiper .swiper-pagination-bullet-active { background: #198754; }

        /* Thumbnail strip below slideshow */
        .thumbSwiper {
            margin-top: .75rem;
        }
        .thumbSwiper .swiper-slide {
            cursor: pointer;
            border-radius: 8px;
            overflow: hidden;
            border: 2px solid transparent;
            transition: border-color .2s;
            opacity: .65;
        }
        .thumbSwiper .swiper-slide-thumb-active {
            border-color: #198754;
            opacity: 1;
        }
        .thumbSwiper .swiper-slide img {
            width: 100%; height: 70px; object-fit: cover; display: block;
        }

        /* ── Video Slider ────────────────────────────────── */
        .videoSwiper {
            padding: .5rem .25rem 2rem;
        }
        .videoSwiper .swiper-slide .card {
            border-radius: 14px;
        }
        .swiper-button-next, .swiper-button-prev {
            background: rgba(255,255,255,0.9);
            border-radius: 50%;
            width: 42px; height: 42px;
            box-shadow: 0 3px 10px rgba(0,0,0,0.12);
        }
        .swiper-button-next:after, .swiper-button-prev:after {
            font-size: 15px; font-weight: 800; color: #198754;
        }
        .swiper-pagination-bullet-active { background: #198754; }

        /* ── Empty state ────────────────────────────────── */
        .gallery-empty {
            background: #f8f9fa; border-radius: 14px;
            padding: 3rem; text-align: center; color: #6c757d;
        }
        .gallery-empty i { font-size: 3rem; margin-bottom: 1rem; display: block; }
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
      "item": "https://www.sju.edu.in/services/che/gallery2"
    }
  ]
}
</script>
</head>
<body>
    <?php require_once '../../header.php'; ?>

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

      <!-- Sidebar -->
      <aside class="col-lg-3 sidebar sidebar-nav-sticky">
        <div class="sidebar-inner">
          <div class="sidebar-header mb-4">
            <h4 class="mb-0">Services</h4>
          </div>
          <nav class="nav flex-column sidebar-nav">
            <a href="che-about.php" class="nav-link"><i class="fa-solid fa-angle-right me-2"></i> About The Department</a>
            <a href="chenotifications.php" class="nav-link"><i class="fa-solid fa-angle-right me-2"></i> Notifications</a>
            <a href="chereports.php" class="nav-link"><i class="fa-solid fa-angle-right me-2"></i> Reports</a>
            <a href="che-team.php" class="nav-link"><i class="fa-solid fa-angle-right me-2"></i> Faculty</a>
            <a href="cheprograms.php" class="nav-link"><i class="fa-solid fa-angle-right me-2"></i> Programs</a>
            <a href="ignitors.php" class="nav-link"><i class="fa-solid fa-angle-right me-2"></i> Ignitors Overview</a>
            <a href="upcoming-events.php" class="nav-link"><i class="fa-solid fa-angle-right me-2"></i> Department Activities</a>
            <a href="gallery2.php" class="nav-link active"><i class="fa-solid fa-angle-right me-2"></i> Gallery</a>
            <a href="contact.php" class="nav-link"><i class="fa-solid fa-angle-right me-2"></i> Contact Us</a>
          </nav>
        </div>
      </aside>

      <!-- Content -->
      <main class="col-lg-9 content-area">

          <!-- ════════════════════════════════════════════════
               SECTION 1 — PHOTOS (Slideshow)
          ════════════════════════════════════════════════ -->
          <h2 class="gallery-section-label">
              <i class="fa-solid fa-images"></i> Photos
          </h2>

          <?php if (count($photos) > 0): ?>

              <!-- Main slideshow -->
              <div class="swiper photoSwiper">
                  <div class="swiper-wrapper">
                      <?php foreach ($photos as $photo): ?>
                      <div class="swiper-slide">
                          <img src="<?= $photo['url'] ?>"
                               alt="<?= htmlspecialchars($photo['caption']) ?>"
                               loading="lazy">
                          <div class="slide-caption"><?= htmlspecialchars($photo['caption']) ?></div>
                      </div>
                      <?php endforeach; ?>
                  </div>
                  <div class="swiper-button-next"></div>
                  <div class="swiper-button-prev"></div>
                  <div class="swiper-pagination"></div>
              </div>

              <!-- Thumbnail strip -->
              <div class="swiper thumbSwiper mt-3">
                  <div class="swiper-wrapper">
                      <?php foreach ($photos as $photo): ?>
                      <div class="swiper-slide">
                          <img src="<?= $photo['url'] ?>"
                               alt="<?= htmlspecialchars($photo['caption']) ?>">
                      </div>
                      <?php endforeach; ?>
                  </div>
              </div>

              <p class="text-muted small mt-3 text-center">
                  <?= count($photos) ?> photo<?= count($photos) !== 1 ? 's' : '' ?> &nbsp;·&nbsp; Use arrows or thumbnail strip to browse
              </p>

          <?php else: ?>
              <div class="gallery-empty">
                  <i class="fa-solid fa-images text-secondary"></i>
                  <h5 class="fw-semibold">Photos Coming Soon</h5>
                  <p class="text-muted small mb-0">Gallery images will appear here once uploaded to S3.</p>
              </div>
          <?php endif; ?>


          <!-- ════════════════════════════════════════════════
               SECTION 2 — VIDEOS (YouTube Carousel)
          ════════════════════════════════════════════════ -->
          <hr class="section-divider">
          <h2 class="gallery-section-label">
              <i class="fa-brands fa-youtube" style="color:#ff0000;"></i> Videos
          </h2>

          <?php if (count($videos) > 0): ?>
          <div class="swiper videoSwiper">
              <div class="swiper-wrapper">
                  <?php foreach ($videos as $v): ?>
                  <div class="swiper-slide pb-2">
                      <div class="card shadow-sm border-0 rounded-4 overflow-hidden">
                          <div class="ratio ratio-16x9">
                              <iframe src="https://www.youtube.com/embed/<?= htmlspecialchars($v['id']) ?>?rel=0"
                                      title="<?= htmlspecialchars($v['title']) ?>"
                                      allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                      allowfullscreen
                                      referrerpolicy="strict-origin-when-cross-origin"
                                      loading="lazy"></iframe>
                          </div>
                          <div class="card-body bg-light text-center py-3">
                              <p class="mb-0 fw-semibold text-dark"><?= htmlspecialchars($v['title']) ?></p>
                          </div>
                      </div>
                  </div>
                  <?php endforeach; ?>
              </div>
              <div class="swiper-button-next"></div>
              <div class="swiper-button-prev"></div>
              <div class="swiper-pagination position-relative mt-3"></div>
          </div>
          <?php else: ?>
              <div class="gallery-empty">
                  <i class="fa-brands fa-youtube text-secondary"></i>
                  <h5 class="fw-semibold">Videos Coming Soon</h5>
                  <p class="text-muted small mb-0">Add YouTube video IDs to the <code>$videos</code> array in this file.</p>
              </div>
          <?php endif; ?>

      </main>
    </div>
  </div>
</section>

<?php require_once '../../footer.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script src="../../assets/js/main.js"></script>

<script>
(function () {
    // Thumbnail swiper (controlled by main)
    var thumbSwiper = new Swiper('.thumbSwiper', {
        spaceBetween: 8,
        slidesPerView: 5,
        freeMode: true,
        watchSlidesProgress: true,
        breakpoints: {
            480:  { slidesPerView: 6 },
            768:  { slidesPerView: 7 },
            1200: { slidesPerView: 8 },
        }
    });

    // Main photo slideshow
    new Swiper('.photoSwiper', {
        spaceBetween: 0,
        loop: true,
        autoplay: { delay: 3500, disableOnInteraction: false, pauseOnMouseEnter: true },
        navigation: { nextEl: '.photoSwiper .swiper-button-next', prevEl: '.photoSwiper .swiper-button-prev' },
        pagination: { el: '.photoSwiper .swiper-pagination', clickable: true },
        thumbs: { swiper: thumbSwiper },
        keyboard: { enabled: true },
    });

    // Video carousel
    new Swiper('.videoSwiper', {
        slidesPerView: 1,
        spaceBetween: 24,
        navigation: { nextEl: '.videoSwiper .swiper-button-next', prevEl: '.videoSwiper .swiper-button-prev' },
        pagination: { el: '.videoSwiper .swiper-pagination', clickable: true },
        breakpoints: { 992: { slidesPerView: 2 } }
    });
})();
</script>
</body>
</html>
