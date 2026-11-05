<!doctype html>
<html class="no-js" lang="en" dir="ltr">

<head>
    <?php include $_SERVER['DOCUMENT_ROOT'] . '/gtm.php'; ?>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Photo Beacon – Photo Magazine | St Joseph's University, Bengaluru</title>
    <meta name="description" content="Photo Beacon is the photo magazine produced by students of St Joseph's University, Bengaluru, showcasing visual journalism and photography.">
    <meta name="keywords" content="Photo Beacon, SJU Photo Magazine, St Joseph's University, Visual Journalism, Photography">
    <link rel="canonical" href="https://www.sju.edu.in/bulletin/sjuphotobeacon">

    <!-- Open Graph / Social Sharing -->
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="St Joseph's University, Bengaluru">
    <meta property="og:title" content="Photo Beacon – Photo Magazine | St Joseph's University, Bengaluru">
    <meta property="og:description" content="Photo Beacon is the photo magazine produced by students of St Joseph's University, Bengaluru, showcasing visual journalism and photography.">
    <meta property="og:url" content="https://www.sju.edu.in/bulletin/sjuphotobeacon">
    <meta property="og:image" content="https://www.sju.edu.in/assets/img/st-joseph-university-logo.png">
    <meta property="og:image:width" content="200">
    <meta property="og:image:height" content="200">
    <meta name="twitter:card" content="summary">
    <meta name="twitter:site" content="@StJosephsUniBLR">
    <meta name="twitter:title" content="Photo Beacon – Photo Magazine | St Joseph's University, Bengaluru">
    <meta name="twitter:description" content="Photo Beacon is the photo magazine produced by students of St Joseph's University, Bengaluru, showcasing visual journalism and photography.">
    <meta name="twitter:image" content="https://www.sju.edu.in/assets/img/st-joseph-university-logo.png">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="icon" href="../assets/img/favicon.png" type="image/png">
    <link rel="apple-touch-icon" href="../assets/img/favicon-apple.png">
    <link rel="manifest" href="../studentsupport/assets/img/favicons/manifest.json">
    <meta name="msapplication-TileColor" content="#ffffff">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400..900;1,400..900&family=Plus+Jakarta+Sans:ital,wght@0,200..800;1,200..800&family=Urbanist:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Arima:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/fontawesome.min.css">
    <link rel="stylesheet" href="../assets/css/magnific-popup.min.css">
    <link rel="stylesheet" href="../assets/css/swiper-bundle.min.css">
    <link rel="stylesheet" href="../assets/css/style.css?v=2.3">

    <style>
        .beacon-month-header {
            display: flex;
            align-items: center;
            gap: 14px;
            margin: 2rem 0 1rem;
        }
        .beacon-month-header .month-label {
            font-size: 0.8rem;
            font-weight: 700;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            background: #1a5c3a;
            color: #fff;
            padding: 4px 14px;
            border-radius: 20px;
            white-space: nowrap;
        }
        .beacon-month-header hr {
            flex: 1;
            border-color: #d0d8e8;
            opacity: 1;
            margin: 0;
        }
        .beacon-card {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            background: #fff;
            border: 1px solid #e4eaf3;
            border-left: 4px solid #1a5c3a;
            border-radius: 10px;
            padding: 16px 20px;
            margin-bottom: 12px;
            transition: box-shadow 0.2s, transform 0.2s;
        }
        .beacon-card:hover {
            box-shadow: 0 4px 18px rgba(26,92,58,0.10);
            transform: translateY(-1px);
        }
        .beacon-card .bc-icon {
            flex-shrink: 0;
            width: 44px;
            height: 44px;
            background: #eaf3ee;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.3rem;
            color: #1a5c3a;
        }
        .beacon-card .bc-meta { flex: 1; min-width: 0; }
        .beacon-card .bc-title {
            font-size: 0.97rem;
            font-weight: 600;
            color: #1a2e4a;
            margin: 0 0 2px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .beacon-card .bc-label { font-size: 0.78rem; color: #7a8faa; }
        .beacon-card .bc-actions { display: flex; gap: 8px; flex-shrink: 0; }
        .beacon-card .bc-actions a {
            font-size: 0.82rem;
            font-weight: 600;
            padding: 6px 16px;
            border-radius: 20px;
            text-decoration: none;
            transition: background 0.15s, color 0.15s;
        }
        .btn-bulletin-view {
            background: #1a5c3a;
            color: #fff;
            border: 2px solid #1a5c3a;
        }
        .btn-bulletin-view:hover { background: #134a2d; color: #fff; }
        .btn-beacon-dl {
            background: transparent;
            color: #1a5c3a;
            border: 2px solid #1a5c3a;
        }
        .btn-beacon-dl:hover { background: #1a5c3a; color: #fff; }
        .beacon-section-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: linear-gradient(135deg, #1a5c3a 0%, #27ae60 100%);
            color: #fff;
            font-size: 1rem;
            font-weight: 700;
            padding: 8px 22px;
            border-radius: 30px;
            margin-bottom: 1.5rem;
        }
        @media (max-width: 576px) {
            .beacon-card { flex-direction: column; align-items: flex-start; gap: 12px; }
            .beacon-card .bc-actions { width: 100%; }
            .beacon-card .bc-actions a { flex: 1; text-align: center; }
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
      "name": "Bulletin",
      "item": "https://www.sju.edu.in/bulletin"
    },
    {
      "@type": "ListItem",
      "position": 3,
      "name": "Photo Beacon",
      "item": "https://www.sju.edu.in/bulletin/sjuphotobeacon"
    }
  ]
}
</script>
</head>
<body>
    <?php require_once '../header.php'; ?>

<!-- BREADCRUMB HERO -->
<section class="breadcrumb-hero text-white">
  <div class="overlay"></div>
  <div class="container">
    <div class="row">
      <div class="col-12">
        <div class="breadcrumb-content text-center">
          <h1 class="page-title mb-2">Photo Beacon</h1>
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb justify-content-center mb-0">
              <li class="breadcrumb-item"><a href="/" class="text-white text-decoration-none">Home</a></li>
              <li class="breadcrumb-item"><a href="#" class="text-white text-decoration-none">Bulletin</a></li>
              <li class="breadcrumb-item active text-warning" aria-current="page">Photo Beacon</li>
            </ol>
          </nav>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="iqac-page py-5 px-4">
  <div class="container">
    <article class="dept-section department_tab mb-5">

      <!-- About -->
      <div class="mb-4">
        <h5 class="fw-bold mb-3">Photo Beacon – Visual Journalism</h5>
        <p>Photo Beacon is a visual journalism publication produced by students of the M.A. Journalism &amp; Mass Communication program at St Joseph's University, Bengaluru. It provides a platform for student photographers to tell compelling stories through images, combining photojournalism with in-depth captions and visual narratives.</p>
        <p>Through Photo Beacon, students develop skills in documentary photography, photo editing, layout design, and visual storytelling — gaining hands-on experience that complements their broader journalism training.</p>
      </div>

      <hr class="mb-4">

      <!-- Badge -->
      <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4">
        <div class="beacon-section-badge mb-0">
          <i class="fas fa-camera"></i> All Editions
        </div>
      </div>

      <!-- 2024 -->
      <div class="beacon-month-header">
        <span class="month-label">September 2024</span><hr>
      </div>
      <div class="beacon-card">
        <div class="bc-icon"><i class="fas fa-camera"></i></div>
        <div class="bc-meta">
          <p class="bc-title">Photo Beacon – 27 September 2024</p>
          <span class="bc-label">Photo Magazine</span>
        </div>
        <div class="bc-actions">
          <a href="bulletin-view?pub=photobeacon&amp;file=PHOTOBEACON%2027-09-2024.pdf" class="btn-bulletin-view"><i class="bi bi-eye me-1"></i>View</a>
          <a href="https://sjudata.s3.ap-south-1.amazonaws.com/Bulletin/Photo%20Beacon/PHOTOBEACON%2027-09-2024.pdf" download class="btn-beacon-dl"><i class="bi bi-download me-1"></i>Download</a>
        </div>
      </div>

    </article>
  </div>
</section>

<?php require_once '../footer.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="../assets/js/main.js"></script>
</body>
</html>
