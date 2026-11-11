<!doctype html>
<html lang="en" dir="ltr">

<head>
    <?php include $_SERVER['DOCUMENT_ROOT'] . '/gtm.php'; ?>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Gallery | St Joseph's University, Bengaluru</title>
    <meta name="description" content="Explore Gallery at St Joseph's University, Bengaluru — a leading Jesuit autonomous university in Karnataka.">
    <meta name="keywords" content="Gallery St Joseph's University Bengaluru, SJU Gallery Bangalore, St Joseph's University Bengaluru, Jesuit university Karnataka">
    <meta name="robots" content="INDEX,FOLLOW">
    <link rel="canonical" href="https://www.sju.edu.in/gallery-view">

    <!-- Open Graph / Social Sharing -->
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="St Joseph's University, Bengaluru">
    <meta property="og:title" content="Gallery | St Joseph's University, Bengaluru">
    <meta property="og:description" content="Explore Gallery at St Joseph's University, Bengaluru — a leading Jesuit autonomous university in Karnataka.">
    <meta property="og:url" content="https://www.sju.edu.in/gallery-view">
    <meta property="og:image" content="https://www.sju.edu.in/assets/img/st-joseph-university-logo.png">
    <meta property="og:image:width" content="200">
    <meta property="og:image:height" content="200">
    <meta name="twitter:card" content="summary">
    <meta name="twitter:site" content="@StJosephsUniBLR">
    <meta name="twitter:title" content="Gallery | St Joseph's University, Bengaluru">
    <meta name="twitter:description" content="Explore Gallery at St Joseph's University, Bengaluru — a leading Jesuit autonomous university in Karnataka.">
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
    <style>
    /* ===== TITLE ===== */
    .gallery-title {
      text-align: center;
      font-weight: 700;
      margin-bottom: 30px;
    }

    /* ===== GRID ===== */
    .gallery-images {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
      gap: 15px;
    }

    /* ===== IMAGE BOX ===== */
    .img-box {
      overflow: hidden;
      border-radius: 8px;
    }

    .img-box img {
      width: 100%;
      height: 220px;
      object-fit: cover;
      cursor: pointer;
      transition: 0.3s ease;
    }

    .img-box:hover img {
      transform: scale(1.08);
    }

    /* ===== LIGHTBOX ===== */
    .lightbox {
      display: none;
      position: fixed;
      z-index: 9999;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: rgba(0,0,0,0.9);
      justify-content: center;
      align-items: center;
    }

    .lightbox img {
      max-width: 90%;
      max-height: 90%;
      border-radius: 8px;
    }

    .lightbox-close {
      position: absolute;
      top: 20px;
      right: 30px;
      font-size: 35px;
      color: #fff;
      cursor: pointer;
    }
    /* Arrows */
.lightbox-prev,
.lightbox-next {
  position: absolute;
  top: 50%;
  transform: translateY(-50%);
  font-size: 40px;
  color: #fff;
  cursor: pointer;
  padding: 10px;
  user-select: none;
}

.lightbox-prev {
  left: 20px;
}

.lightbox-next {
  right: 20px;
}

.lightbox-prev:hover,
.lightbox-next:hover {
  color: #c8a951;
}
/* Controls top right */
/* Controls */
.lightbox-controls {
  position: absolute;
  top: 20px;
  left: 20px;
  display: flex;
  gap: 10px;
}

.control-btn {
  width: 40px;
  height: 40px;
  border-radius: 50%;
  border: none;
  background: rgba(255,255,255,0.15);
  backdrop-filter: blur(6px);
  color: #fff;
  font-size: 18px;
  cursor: pointer;
  display: flex;
  align-items: center;
  justify-content: center;
}

.control-btn:hover {
  background: #c8a951;
}

/* Progress bar */
.progress-bar {
  position: absolute;
  bottom: 0;
  left: 0;
  width: 100%;
  height: 4px;
  background: rgba(255,255,255,0.2);
}

.progress {
  height: 100%;
  width: 0%;
  background: #c8a951;
  transition: width linear;
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
      "name": "Gallery",
      "item": "https://www.sju.edu.in/gallery-view"
    }
  ]
}
</script>
</head>
<body>
     <?php require_once 'header.php';
    
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
    
    ?>
    
<!--BREADCRUMB-->
 <section class="breadcrumb-hero text-white">
  <div class="overlay"></div>
  <div class="container">
    <div class="row">
      <div class="col-12">
        <div class="breadcrumb-content text-center">
          <h1 class="page-title mb-2">
                  Gallery
          </h1>
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb justify-content-center mb-0">
              <li class="breadcrumb-item">
                <a href="/" class="text-white text-decoration-none">Home</a>
              </li> 
              <li class="breadcrumb-item active text-warning" aria-current="page">
                 Gallery
              </li>
            </ol>
          </nav>
        </div>
      </div>
    </div>
  </div>
</section> 

<?php
$folder = $_GET['folder'] ?? '';
$safeFolder = basename($folder);

$basePath = "Gallery/" . $safeFolder . "/";

$images = glob($basePath . "*.{jpg,jpeg,png,webp}", GLOB_BRACE);
?>

<div class="container my-5">

  <h2 class="gallery-title">
    <?php echo htmlspecialchars(str_replace(['-', '_'], ' ', $safeFolder)); ?>
  </h2>

  <div class="gallery-images">

  <?php if (!empty($images)): ?>

    <?php foreach ($images as $img): 
        if (stripos($img, 'thumbnail') !== false) continue;
    ?>

      <div class="img-box">
        <img src="<?php echo $img; ?>" alt="" loading="lazy">
      </div>

    <?php endforeach; ?>

  <?php else: ?>

    <p class="text-center">No images found in this gallery.</p>

  <?php endif; ?>

  </div>

</div>

<!-- LIGHTBOX -->
<div id="lightbox" class="lightbox">
  <span class="lightbox-close">&times;</span>

  <!-- Controls -->
  <div class="lightbox-controls">
    <button id="playPauseBtn" class="control-btn">
      <span id="playIcon">▶</span>
    </button>

    <a id="downloadBtn" class="control-btn" download>
      <i class="fa fa-download"></i> 
    </a>
  </div>

  <!-- Progress Bar -->
  <div class="progress-bar">
    <div class="progress"></div>
  </div>

  <!-- Prev -->
  <span class="lightbox-prev">&#10094;</span>

  <!-- Image -->
  <img id="lightbox-img">

  <!-- Next -->
  <span class="lightbox-next">&#10095;</span>
</div>

<!-- JS -->
<script>
document.addEventListener("DOMContentLoaded", function () {

  const images = document.querySelectorAll('.img-box img');
  const lightbox = document.getElementById('lightbox');
  const lightboxImg = document.getElementById('lightbox-img');
  const closeBtn = document.querySelector('.lightbox-close');
  const prevBtn = document.querySelector('.lightbox-prev');
  const nextBtn = document.querySelector('.lightbox-next');
  const playPauseBtn = document.getElementById('playPauseBtn');
  const playIcon = document.getElementById('playIcon');
  const downloadBtn = document.getElementById('downloadBtn');
  const progressBar = document.querySelector('.progress');

  let currentIndex = 0;
  let slideshowInterval = null;
  let isPlaying = false;
  const duration = 3000;

  const imgArray = Array.from(images);

  function showImage(index) {
    if (index < 0) {
      currentIndex = imgArray.length - 1;
    } else if (index >= imgArray.length) {
      currentIndex = 0;
    } else {
      currentIndex = index;
    }

    const src = imgArray[currentIndex].src;
    lightboxImg.src = src;
    downloadBtn.href = src;

    resetProgress();
  }

  function resetProgress() {
    progressBar.style.transition = 'none';
    progressBar.style.width = '0%';

    setTimeout(() => {
      progressBar.style.transition = `width ${duration}ms linear`;
      progressBar.style.width = '100%';
    }, 50);
  }

  function startSlideshow() {
    resetProgress();

    slideshowInterval = setInterval(() => {
      showImage(currentIndex + 1);
    }, duration);

    isPlaying = true;
    playIcon.textContent = "❚❚";
  }

  function stopSlideshow() {
    clearInterval(slideshowInterval);
    isPlaying = false;
    playIcon.textContent = "▶";
    progressBar.style.width = '0%';
  }

  // Open
  imgArray.forEach((img, index) => {
    img.addEventListener('click', () => {
      currentIndex = index;
      showImage(currentIndex);
      lightbox.style.display = 'flex';
    });
  });

  // Navigation
  nextBtn.onclick = () => showImage(currentIndex + 1);
  prevBtn.onclick = () => showImage(currentIndex - 1);

  // Play/Pause
  playPauseBtn.onclick = () => {
    if (isPlaying) {
      stopSlideshow();
    } else {
      startSlideshow();
    }
  };

  // Close
  closeBtn.onclick = () => {
    lightbox.style.display = 'none';
    stopSlideshow();
  };

  lightbox.addEventListener('click', (e) => {
    if (e.target === lightbox) {
      lightbox.style.display = 'none';
      stopSlideshow();
    }
  });

  // Keyboard
  document.addEventListener('keydown', (e) => {
    if (lightbox.style.display === 'flex') {
      if (e.key === 'ArrowRight') showImage(currentIndex + 1);
      if (e.key === 'ArrowLeft') showImage(currentIndex - 1);
      if (e.key === 'Escape') {
        lightbox.style.display = 'none';
        stopSlideshow();
      }
    }
  });

});
</script>
  <!-- Footer injected -->
<?php require_once 'footer.php'; ?>

  <!-- Bootstrap JS bundle -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

  <!-- Custom JS -->
  <script src="assets/js/main.js"></script>
</body>
</html>
