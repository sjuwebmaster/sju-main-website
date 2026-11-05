<!doctype html>
<html class="no-js" lang="en" dir="ltr">

<head>
    <?php include $_SERVER['DOCUMENT_ROOT'] . '/gtm.php'; ?>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>The Beacon – Student Newspaper | St Joseph's University, Bengaluru</title>
    <meta name="description" content="The Beacon is the daily practice newspaper published by students of the M.A. Journalism & Mass Communication program at St Joseph's University, Bengaluru.">
    <meta name="keywords" content="The Beacon, SJU Newspaper, St Joseph's University, Journalism, Student Newspaper">
    <link rel="canonical" href="https://www.sju.edu.in/bulletin/sjubeacon">

    <!-- Open Graph / Social Sharing -->
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="St Joseph's University, Bengaluru">
    <meta property="og:title" content="The Beacon – Student Newspaper | St Joseph's University, Bengaluru">
    <meta property="og:description" content="The Beacon is the daily practice newspaper published by students of the M.A. Journalism &amp; Mass Communication program at St Joseph's University, Bengaluru.">
    <meta property="og:url" content="https://www.sju.edu.in/bulletin/sjubeacon">
    <meta property="og:image" content="https://www.sju.edu.in/assets/img/st-joseph-university-logo.png">
    <meta property="og:image:width" content="200">
    <meta property="og:image:height" content="200">
    <meta name="twitter:card" content="summary">
    <meta name="twitter:site" content="@StJosephsUniBLR">
    <meta name="twitter:title" content="The Beacon – Student Newspaper | St Joseph's University, Bengaluru">
    <meta name="twitter:description" content="The Beacon is the daily practice newspaper published by students of the M.A. Journalism &amp; Mass Communication program at St Joseph's University, Bengaluru.">
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
            background: #1a3a6b;
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
            border-left: 4px solid #1a3a6b;
            border-radius: 10px;
            padding: 16px 20px;
            margin-bottom: 12px;
            transition: box-shadow 0.2s, transform 0.2s;
        }
        .beacon-card:hover {
            box-shadow: 0 4px 18px rgba(26,58,107,0.10);
            transform: translateY(-1px);
        }
        .beacon-card .bc-icon {
            flex-shrink: 0;
            width: 44px;
            height: 44px;
            background: #f0f4fb;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.3rem;
            color: #1a3a6b;
        }
        .beacon-card .bc-meta {
            flex: 1;
            min-width: 0;
        }
        .beacon-card .bc-title {
            font-size: 0.97rem;
            font-weight: 600;
            color: #1a2e4a;
            margin: 0 0 2px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .beacon-card .bc-label {
            font-size: 0.78rem;
            color: #7a8faa;
        }
        .beacon-card .bc-actions {
            display: flex;
            gap: 8px;
            flex-shrink: 0;
        }
        .beacon-card .bc-actions a {
            font-size: 0.82rem;
            font-weight: 600;
            padding: 6px 16px;
            border-radius: 20px;
            text-decoration: none;
            transition: background 0.15s, color 0.15s;
        }
        .btn-bulletin-view {
            background: #1a3a6b;
            color: #fff;
            border: 2px solid #1a3a6b;
        }
        .btn-bulletin-view:hover { background: #12295a; color: #fff; }
        .btn-beacon-dl {
            background: transparent;
            color: #1a3a6b;
            border: 2px solid #1a3a6b;
        }
        .btn-beacon-dl:hover { background: #1a3a6b; color: #fff; }
        .beacon-section-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: linear-gradient(135deg, #1a3a6b 0%, #2356a0 100%);
            color: #fff;
            font-size: 1rem;
            font-weight: 700;
            padding: 8px 22px;
            border-radius: 30px;
            margin-bottom: 1.5rem;
        }
        .beacon-filter-btn {
            background: #fff;
            border: 2px solid #1a3a6b;
            color: #1a3a6b;
            font-size: 0.82rem;
            font-weight: 700;
            padding: 6px 20px;
            border-radius: 20px;
            cursor: pointer;
            transition: background 0.15s, color 0.15s;
        }
        .beacon-filter-btn.active,
        .beacon-filter-btn:hover {
            background: #1a3a6b;
            color: #fff;
        }
        .beacon-archive-toggle {
            cursor: pointer;
            user-select: none;
            background: #f5f7fb;
            border: 1px solid #dde3ef;
            border-radius: 8px;
            padding: 12px 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            font-weight: 600;
            color: #3a5278;
            margin-top: 2.5rem;
            transition: background 0.15s;
        }
        .beacon-archive-toggle:hover { background: #eaeff9; }
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
      "name": "The Beacon",
      "item": "https://www.sju.edu.in/bulletin/sjubeacon"
    }
  ]
}
</script>
</head>
<body>
    <?php require_once '../header.php'; ?>

<!-- BREADCRUMB HERO - DO NOT EDIT -->
<section class="breadcrumb-hero text-white">
  <div class="overlay"></div>
  <div class="container">
    <div class="row">
      <div class="col-12">
        <div class="breadcrumb-content text-center">
          <h1 class="page-title mb-2">The Beacon</h1>
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb justify-content-center mb-0">
              <li class="breadcrumb-item">
                <a href="/" class="text-white text-decoration-none">Home</a>
              </li>
              <li class="breadcrumb-item">
                <a href="#" class="text-white text-decoration-none">Bulletin</a>
              </li>
              <li class="breadcrumb-item active text-warning" aria-current="page">The Beacon</li>
            </ol>
          </nav>
        </div>
      </div>
    </div>
  </div>
</section>
<!-- END BREADCRUMB HERO -->

<section class="iqac-page py-5 px-4">
  <div class="container">

    <article class="dept-section department_tab mb-5">

      <!-- About -->
      <div class="mb-4">
        <h5 class="fw-bold mb-3">Newspaper – The Beacon</h5>
        <p>The Institute of Communication and Media Studies has been providing a solid grounding in print reporting for cub reporters for the last 16 years through its unique and successful initiative called The Beacon. The daily practice newspaper is written and published by the students of the M.A. Journalism &amp; Mass Communication program, providing a real-time simulated experience of a newsroom.</p>
        <p>The Beacon follows a complete workflow, mirroring the actual newsroom process, starting with pitching news story ideas to the editorial board, intense discussions on the news sense of the pitch, and finding varied sources. After preliminary research, the student reporters hunt for multiple sources, conduct field interviews, and write news stories in line with the modern principles of reporting, editing, and design.</p>
        <p>Each day's copies are published well within the deadline. This immersive experience has transformed enthusiastic cub reporters into fully-fledged professional reporters, who have ended up working for several reputable news organisations.</p>
      </div>

      <hr class="mb-4">

      <!-- 2025–2026 Editions -->
      <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4">
        <div class="beacon-section-badge mb-0">
          <i class="bi bi-newspaper"></i> Academic Year 2025–2026
        </div>
        <div class="d-flex gap-2 flex-wrap" role="group" aria-label="Filter by year">
          <button class="beacon-filter-btn active" data-year="all">All</button>
          <button class="beacon-filter-btn" data-year="2026">2026</button>
          <button class="beacon-filter-btn" data-year="2025">2025</button>
          <button class="beacon-filter-btn" data-year="2023">2022–23</button>
        </div>
      </div>

      <div class="beacon-year-group" data-year="2026">

      <!-- March 2026 -->
      <div class="beacon-month-header"><span class="month-label">March 2026</span><hr></div>

      <div class="beacon-card">
        <div class="bc-icon"><i class="fas fa-file-pdf"></i></div>
        <div class="bc-meta"><p class="bc-title">The Beacon – 14 March 2026</p><span class="bc-label">Academic Year 2025–2026</span></div>
        <div class="bc-actions">
          <a href="bulletin-view?file=March%202026%2FTHE%20BEACON%2014-03-2026.pdf" class="btn-bulletin-view"><i class="bi bi-eye me-1"></i>View</a>
          <a href="https://sjudata.s3.ap-south-1.amazonaws.com/Bulletin/Beacon%202025-2026/March%202026/THE%20BEACON%2014-03-2026.pdf" download class="btn-beacon-dl"><i class="bi bi-download me-1"></i>Download</a>
        </div>
      </div>

      <div class="beacon-card">
        <div class="bc-icon"><i class="fas fa-file-pdf"></i></div>
        <div class="bc-meta"><p class="bc-title">The Beacon – 12 March 2026</p><span class="bc-label">Academic Year 2025–2026</span></div>
        <div class="bc-actions">
          <a href="bulletin-view?file=March%202026%2FTHE%20BEACON%2012-03-2026.pdf" class="btn-bulletin-view"><i class="bi bi-eye me-1"></i>View</a>
          <a href="https://sjudata.s3.ap-south-1.amazonaws.com/Bulletin/Beacon%202025-2026/March%202026/THE%20BEACON%2012-03-2026.pdf" download class="btn-beacon-dl"><i class="bi bi-download me-1"></i>Download</a>
        </div>
      </div>

      <div class="beacon-card">
        <div class="bc-icon"><i class="fas fa-file-pdf"></i></div>
        <div class="bc-meta"><p class="bc-title">The Beacon – 11 March 2026</p><span class="bc-label">Academic Year 2025–2026</span></div>
        <div class="bc-actions">
          <a href="bulletin-view?file=March%202026%2FTHE%20BEACON%2011-03-2026.pdf" class="btn-bulletin-view"><i class="bi bi-eye me-1"></i>View</a>
          <a href="https://sjudata.s3.ap-south-1.amazonaws.com/Bulletin/Beacon%202025-2026/March%202026/THE%20BEACON%2011-03-2026.pdf" download class="btn-beacon-dl"><i class="bi bi-download me-1"></i>Download</a>
        </div>
      </div>

      <div class="beacon-card">
        <div class="bc-icon"><i class="fas fa-file-pdf"></i></div>
        <div class="bc-meta"><p class="bc-title">The Beacon – 10 March 2026</p><span class="bc-label">Academic Year 2025–2026</span></div>
        <div class="bc-actions">
          <a href="bulletin-view?file=March%202026%2FTHE%20BEACON%2010-03-2026.pdf" class="btn-bulletin-view"><i class="bi bi-eye me-1"></i>View</a>
          <a href="https://sjudata.s3.ap-south-1.amazonaws.com/Bulletin/Beacon%202025-2026/March%202026/THE%20BEACON%2010-03-2026.pdf" download class="btn-beacon-dl"><i class="bi bi-download me-1"></i>Download</a>
        </div>
      </div>

      <div class="beacon-card">
        <div class="bc-icon"><i class="fas fa-file-pdf"></i></div>
        <div class="bc-meta"><p class="bc-title">The Beacon – 07 March 2026</p><span class="bc-label">Academic Year 2025–2026</span></div>
        <div class="bc-actions">
          <a href="bulletin-view?file=March%202026%2FTHE%20BEACON%2007-03-2026.pdf" class="btn-bulletin-view"><i class="bi bi-eye me-1"></i>View</a>
          <a href="https://sjudata.s3.ap-south-1.amazonaws.com/Bulletin/Beacon%202025-2026/March%202026/THE%20BEACON%2007-03-2026.pdf" download class="btn-beacon-dl"><i class="bi bi-download me-1"></i>Download</a>
        </div>
      </div>

      <div class="beacon-card">
        <div class="bc-icon"><i class="fas fa-file-pdf"></i></div>
        <div class="bc-meta"><p class="bc-title">The Beacon – 06 March 2026</p><span class="bc-label">Academic Year 2025–2026</span></div>
        <div class="bc-actions">
          <a href="bulletin-view?file=March%202026%2FTHE%20BEACON%2006-03-2026.pdf" class="btn-bulletin-view"><i class="bi bi-eye me-1"></i>View</a>
          <a href="https://sjudata.s3.ap-south-1.amazonaws.com/Bulletin/Beacon%202025-2026/March%202026/THE%20BEACON%2006-03-2026.pdf" download class="btn-beacon-dl"><i class="bi bi-download me-1"></i>Download</a>
        </div>
      </div>

      <div class="beacon-card">
        <div class="bc-icon"><i class="fas fa-file-pdf"></i></div>
        <div class="bc-meta"><p class="bc-title">The Beacon – 05 March 2026</p><span class="bc-label">Academic Year 2025–2026</span></div>
        <div class="bc-actions">
          <a href="bulletin-view?file=March%202026%2FTHE%20BEACON%2005-03-2026.pdf" class="btn-bulletin-view"><i class="bi bi-eye me-1"></i>View</a>
          <a href="https://sjudata.s3.ap-south-1.amazonaws.com/Bulletin/Beacon%202025-2026/March%202026/THE%20BEACON%2005-03-2026.pdf" download class="btn-beacon-dl"><i class="bi bi-download me-1"></i>Download</a>
        </div>
      </div>

      <div class="beacon-card">
        <div class="bc-icon"><i class="fas fa-file-pdf"></i></div>
        <div class="bc-meta"><p class="bc-title">The Beacon – 03 March 2026</p><span class="bc-label">Academic Year 2025–2026</span></div>
        <div class="bc-actions">
          <a href="bulletin-view?file=March%202026%2FTHE%20BEACON%2003-03-2026.pdf" class="btn-bulletin-view"><i class="bi bi-eye me-1"></i>View</a>
          <a href="https://sjudata.s3.ap-south-1.amazonaws.com/Bulletin/Beacon%202025-2026/March%202026/THE%20BEACON%2003-03-2026.pdf" download class="btn-beacon-dl"><i class="bi bi-download me-1"></i>Download</a>
        </div>
      </div>

      <!-- February 2026 -->
      <div class="beacon-month-header"><span class="month-label">February 2026</span><hr></div>

      <div class="beacon-card">
        <div class="bc-icon"><i class="fas fa-file-pdf"></i></div>
        <div class="bc-meta"><p class="bc-title">The Beacon – 28 February 2026</p><span class="bc-label">Academic Year 2025–2026</span></div>
        <div class="bc-actions">
          <a href="bulletin-view?file=February%202026%2FTHE%20BEACON%2028-02-2026.pdf" class="btn-bulletin-view"><i class="bi bi-eye me-1"></i>View</a>
          <a href="https://sjudata.s3.ap-south-1.amazonaws.com/Bulletin/Beacon%202025-2026/February%202026/THE%20BEACON%2028-02-2026.pdf" download class="btn-beacon-dl"><i class="bi bi-download me-1"></i>Download</a>
        </div>
      </div>

      <div class="beacon-card">
        <div class="bc-icon"><i class="fas fa-file-pdf"></i></div>
        <div class="bc-meta"><p class="bc-title">The Beacon – 27 February 2026</p><span class="bc-label">Academic Year 2025–2026</span></div>
        <div class="bc-actions">
          <a href="bulletin-view?file=February%202026%2FTHE%20BEACON%2027-02-2026.pdf" class="btn-bulletin-view"><i class="bi bi-eye me-1"></i>View</a>
          <a href="https://sjudata.s3.ap-south-1.amazonaws.com/Bulletin/Beacon%202025-2026/February%202026/THE%20BEACON%2027-02-2026.pdf" download class="btn-beacon-dl"><i class="bi bi-download me-1"></i>Download</a>
        </div>
      </div>

      <div class="beacon-card">
        <div class="bc-icon"><i class="fas fa-file-pdf"></i></div>
        <div class="bc-meta"><p class="bc-title">The Beacon – 24 February 2026</p><span class="bc-label">Academic Year 2025–2026</span></div>
        <div class="bc-actions">
          <a href="bulletin-view?file=February%202026%2FTHE%20BEACON%2024-02-2026.pdf" class="btn-bulletin-view"><i class="bi bi-eye me-1"></i>View</a>
          <a href="https://sjudata.s3.ap-south-1.amazonaws.com/Bulletin/Beacon%202025-2026/February%202026/THE%20BEACON%2024-02-2026.pdf" download class="btn-beacon-dl"><i class="bi bi-download me-1"></i>Download</a>
        </div>
      </div>

      <div class="beacon-card">
        <div class="bc-icon"><i class="fas fa-file-pdf"></i></div>
        <div class="bc-meta"><p class="bc-title">The Beacon – 22 February 2026</p><span class="bc-label">Academic Year 2025–2026</span></div>
        <div class="bc-actions">
          <a href="https://sjudata.s3.ap-south-1.amazonaws.com/Bulletin/Beacon+2025-2026/February+2026/The+Beacon+-+22+February+2026.pdf" target="_blank" class="btn-bulletin-view"><i class="bi bi-eye me-1"></i>View</a>
          <a href="https://sjudata.s3.ap-south-1.amazonaws.com/Bulletin/Beacon+2025-2026/February+2026/The+Beacon+-+22+February+2026.pdf" download class="btn-beacon-dl"><i class="bi bi-download me-1"></i>Download</a>
        </div>
      </div>

      <div class="beacon-card">
        <div class="bc-icon"><i class="fas fa-file-pdf"></i></div>
        <div class="bc-meta"><p class="bc-title">The Beacon – 20 February 2026</p><span class="bc-label">Academic Year 2025–2026</span></div>
        <div class="bc-actions">
          <a href="https://sjudata.s3.ap-south-1.amazonaws.com/Bulletin/Beacon+2025-2026/February+2026/The+Beacon+-+20+February+2026.pdf" target="_blank" class="btn-bulletin-view"><i class="bi bi-eye me-1"></i>View</a>
          <a href="https://sjudata.s3.ap-south-1.amazonaws.com/Bulletin/Beacon+2025-2026/February+2026/The+Beacon+-+20+February+2026.pdf" download class="btn-beacon-dl"><i class="bi bi-download me-1"></i>Download</a>
        </div>
      </div>

      <div class="beacon-card">
        <div class="bc-icon"><i class="fas fa-file-pdf"></i></div>
        <div class="bc-meta"><p class="bc-title">The Beacon – 19 February 2026</p><span class="bc-label">Academic Year 2025–2026</span></div>
        <div class="bc-actions">
          <a href="bulletin-view?file=February%202026%2FTHE%20BEACON%2019-02-2026.pdf" class="btn-bulletin-view"><i class="bi bi-eye me-1"></i>View</a>
          <a href="https://sjudata.s3.ap-south-1.amazonaws.com/Bulletin/Beacon%202025-2026/February%202026/THE%20BEACON%2019-02-2026.pdf" download class="btn-beacon-dl"><i class="bi bi-download me-1"></i>Download</a>
        </div>
      </div>

      <div class="beacon-card">
        <div class="bc-icon"><i class="fas fa-file-pdf"></i></div>
        <div class="bc-meta"><p class="bc-title">The Beacon – 18 February 2026</p><span class="bc-label">Academic Year 2025–2026</span></div>
        <div class="bc-actions">
          <a href="https://sjudata.s3.ap-south-1.amazonaws.com/Bulletin/Beacon+2025-2026/February+2026/The+Beacon+-+18+February+2026.pdf" target="_blank" class="btn-bulletin-view"><i class="bi bi-eye me-1"></i>View</a>
          <a href="https://sjudata.s3.ap-south-1.amazonaws.com/Bulletin/Beacon+2025-2026/February+2026/The+Beacon+-+18+February+2026.pdf" download class="btn-beacon-dl"><i class="bi bi-download me-1"></i>Download</a>
        </div>
      </div>

      <div class="beacon-card">
        <div class="bc-icon"><i class="fas fa-file-pdf"></i></div>
        <div class="bc-meta"><p class="bc-title">The Beacon – 17 February 2026</p><span class="bc-label">Academic Year 2025–2026</span></div>
        <div class="bc-actions">
          <a href="bulletin-view?file=February%202026%2FTHE%20BEACON%2017-02-2026.pdf" class="btn-bulletin-view"><i class="bi bi-eye me-1"></i>View</a>
          <a href="https://sjudata.s3.ap-south-1.amazonaws.com/Bulletin/Beacon%202025-2026/February%202026/THE%20BEACON%2017-02-2026.pdf" download class="btn-beacon-dl"><i class="bi bi-download me-1"></i>Download</a>
        </div>
      </div>

      <div class="beacon-card">
        <div class="bc-icon"><i class="fas fa-file-pdf"></i></div>
        <div class="bc-meta"><p class="bc-title">The Beacon – 14 February 2026</p><span class="bc-label">Academic Year 2025–2026</span></div>
        <div class="bc-actions">
          <a href="bulletin-view?file=February%202026%2FTHE%20BEACON%2014-02-2026.pdf" class="btn-bulletin-view"><i class="bi bi-eye me-1"></i>View</a>
          <a href="https://sjudata.s3.ap-south-1.amazonaws.com/Bulletin/Beacon%202025-2026/February%202026/THE%20BEACON%2014-02-2026.pdf" download class="btn-beacon-dl"><i class="bi bi-download me-1"></i>Download</a>
        </div>
      </div>

      <div class="beacon-card">
        <div class="bc-icon"><i class="fas fa-file-pdf"></i></div>
        <div class="bc-meta"><p class="bc-title">The Beacon – 03 February 2026</p><span class="bc-label">Academic Year 2025–2026</span></div>
        <div class="bc-actions">
          <a href="bulletin-view?file=February%202026%2FTHE%20BEACON%2003-02-2026.pdf" class="btn-bulletin-view"><i class="bi bi-eye me-1"></i>View</a>
          <a href="https://sjudata.s3.ap-south-1.amazonaws.com/Bulletin/Beacon%202025-2026/February%202026/THE%20BEACON%2003-02-2026.pdf" download class="btn-beacon-dl"><i class="bi bi-download me-1"></i>Download</a>
        </div>
      </div>

      <!-- January 2026 -->
      <div class="beacon-month-header"><span class="month-label">January 2026</span><hr></div>

      <div class="beacon-card">
        <div class="bc-icon"><i class="fas fa-file-pdf"></i></div>
        <div class="bc-meta"><p class="bc-title">The Beacon – 31 January 2026</p><span class="bc-label">Academic Year 2025–2026</span></div>
        <div class="bc-actions">
          <a href="bulletin-view?file=January%202026%2FTHE%20BEACON%2031-01-2026.pdf" class="btn-bulletin-view"><i class="bi bi-eye me-1"></i>View</a>
          <a href="https://sjudata.s3.ap-south-1.amazonaws.com/Bulletin/Beacon%202025-2026/January%202026/THE%20BEACON%2031-01-2026.pdf" download class="btn-beacon-dl"><i class="bi bi-download me-1"></i>Download</a>
        </div>
      </div>

      <div class="beacon-card">
        <div class="bc-icon"><i class="fas fa-file-pdf"></i></div>
        <div class="bc-meta"><p class="bc-title">The Beacon – 30 January 2026</p><span class="bc-label">Academic Year 2025–2026</span></div>
        <div class="bc-actions">
          <a href="bulletin-view?file=January%202026%2FTHE%20BEACON%2030-01-2026.pdf" class="btn-bulletin-view"><i class="bi bi-eye me-1"></i>View</a>
          <a href="https://sjudata.s3.ap-south-1.amazonaws.com/Bulletin/Beacon%202025-2026/January%202026/THE%20BEACON%2030-01-2026.pdf" download class="btn-beacon-dl"><i class="bi bi-download me-1"></i>Download</a>
        </div>
      </div>

      <div class="beacon-card">
        <div class="bc-icon"><i class="fas fa-file-pdf"></i></div>
        <div class="bc-meta"><p class="bc-title">The Beacon – 28 January 2026</p><span class="bc-label">Academic Year 2025–2026</span></div>
        <div class="bc-actions">
          <a href="bulletin-view?file=January%202026%2FTHE%20BEACON%2028-01-2026.pdf" class="btn-bulletin-view"><i class="bi bi-eye me-1"></i>View</a>
          <a href="https://sjudata.s3.ap-south-1.amazonaws.com/Bulletin/Beacon%202025-2026/January%202026/THE%20BEACON%2028-01-2026.pdf" download class="btn-beacon-dl"><i class="bi bi-download me-1"></i>Download</a>
        </div>
      </div>

      <div class="beacon-card">
        <div class="bc-icon"><i class="fas fa-file-pdf"></i></div>
        <div class="bc-meta"><p class="bc-title">The Beacon – 27 January 2026</p><span class="bc-label">Academic Year 2025–2026</span></div>
        <div class="bc-actions">
          <a href="bulletin-view?file=January%202026%2FTHE%20BEACON%2027-01-2026.pdf" class="btn-bulletin-view"><i class="bi bi-eye me-1"></i>View</a>
          <a href="https://sjudata.s3.ap-south-1.amazonaws.com/Bulletin/Beacon%202025-2026/January%202026/THE%20BEACON%2027-01-2026.pdf" download class="btn-beacon-dl"><i class="bi bi-download me-1"></i>Download</a>
        </div>
      </div>

      <div class="beacon-card">
        <div class="bc-icon"><i class="fas fa-file-pdf"></i></div>
        <div class="bc-meta"><p class="bc-title">The Beacon – 22 January 2026</p><span class="bc-label">Academic Year 2025–2026</span></div>
        <div class="bc-actions">
          <a href="bulletin-view?file=January%202026%2FTHE%20BEACON%2022-01-2026.pdf" class="btn-bulletin-view"><i class="bi bi-eye me-1"></i>View</a>
          <a href="https://sjudata.s3.ap-south-1.amazonaws.com/Bulletin/Beacon%202025-2026/January%202026/THE%20BEACON%2022-01-2026.pdf" download class="btn-beacon-dl"><i class="bi bi-download me-1"></i>Download</a>
        </div>
      </div>

      <div class="beacon-card">
        <div class="bc-icon"><i class="fas fa-file-pdf"></i></div>
        <div class="bc-meta"><p class="bc-title">The Beacon – 20 January 2026</p><span class="bc-label">Academic Year 2025–2026</span></div>
        <div class="bc-actions">
          <a href="bulletin-view?file=January%202026%2FTHE%20BEACON%2020-01-2026.pdf" class="btn-bulletin-view"><i class="bi bi-eye me-1"></i>View</a>
          <a href="https://sjudata.s3.ap-south-1.amazonaws.com/Bulletin/Beacon%202025-2026/January%202026/THE%20BEACON%2020-01-2026.pdf" download class="btn-beacon-dl"><i class="bi bi-download me-1"></i>Download</a>
        </div>
      </div>

      <div class="beacon-card">
        <div class="bc-icon"><i class="fas fa-file-pdf"></i></div>
        <div class="bc-meta"><p class="bc-title">The Beacon – 16 January 2026</p><span class="bc-label">Academic Year 2025–2026</span></div>
        <div class="bc-actions">
          <a href="bulletin-view?file=January%202026%2FTHE%20BEACON%2016-01-2026.pdf" class="btn-bulletin-view"><i class="bi bi-eye me-1"></i>View</a>
          <a href="https://sjudata.s3.ap-south-1.amazonaws.com/Bulletin/Beacon%202025-2026/January%202026/THE%20BEACON%2016-01-2026.pdf" download class="btn-beacon-dl"><i class="bi bi-download me-1"></i>Download</a>
        </div>
      </div>

      <div class="beacon-card">
        <div class="bc-icon"><i class="fas fa-file-pdf"></i></div>
        <div class="bc-meta"><p class="bc-title">The Beacon – 14 January 2026</p><span class="bc-label">Academic Year 2025–2026</span></div>
        <div class="bc-actions">
          <a href="bulletin-view?file=January%202026%2FTHE%20BEACON%2014-01-2026.pdf" class="btn-bulletin-view"><i class="bi bi-eye me-1"></i>View</a>
          <a href="https://sjudata.s3.ap-south-1.amazonaws.com/Bulletin/Beacon%202025-2026/January%202026/THE%20BEACON%2014-01-2026.pdf" download class="btn-beacon-dl"><i class="bi bi-download me-1"></i>Download</a>
        </div>
      </div>

      <div class="beacon-card">
        <div class="bc-icon"><i class="fas fa-file-pdf"></i></div>
        <div class="bc-meta"><p class="bc-title">The Beacon – 13 January 2026</p><span class="bc-label">Academic Year 2025–2026</span></div>
        <div class="bc-actions">
          <a href="bulletin-view?file=January%202026%2FTHE%20BEACON%2013-01-2026.pdf" class="btn-bulletin-view"><i class="bi bi-eye me-1"></i>View</a>
          <a href="https://sjudata.s3.ap-south-1.amazonaws.com/Bulletin/Beacon%202025-2026/January%202026/THE%20BEACON%2013-01-2026.pdf" download class="btn-beacon-dl"><i class="bi bi-download me-1"></i>Download</a>
        </div>
      </div>

      <div class="beacon-card">
        <div class="bc-icon"><i class="fas fa-file-pdf"></i></div>
        <div class="bc-meta"><p class="bc-title">The Beacon – 10 January 2026</p><span class="bc-label">Academic Year 2025–2026</span></div>
        <div class="bc-actions">
          <a href="bulletin-view?file=January%202026%2FTHE%20BEACON%2010-01-2026.pdf" class="btn-bulletin-view"><i class="bi bi-eye me-1"></i>View</a>
          <a href="https://sjudata.s3.ap-south-1.amazonaws.com/Bulletin/Beacon%202025-2026/January%202026/THE%20BEACON%2010-01-2026.pdf" download class="btn-beacon-dl"><i class="bi bi-download me-1"></i>Download</a>
        </div>
      </div>

      <div class="beacon-card">
        <div class="bc-icon"><i class="fas fa-file-pdf"></i></div>
        <div class="bc-meta"><p class="bc-title">The Beacon – 08 January 2026</p><span class="bc-label">Academic Year 2025–2026</span></div>
        <div class="bc-actions">
          <a href="bulletin-view?file=January%202026%2FTHE%20BEACON%2008-01-2026.pdf" class="btn-bulletin-view"><i class="bi bi-eye me-1"></i>View</a>
          <a href="https://sjudata.s3.ap-south-1.amazonaws.com/Bulletin/Beacon%202025-2026/January%202026/THE%20BEACON%2008-01-2026.pdf" download class="btn-beacon-dl"><i class="bi bi-download me-1"></i>Download</a>
        </div>
      </div>

      <div class="beacon-card">
        <div class="bc-icon"><i class="fas fa-file-pdf"></i></div>
        <div class="bc-meta"><p class="bc-title">The Beacon – 07 January 2026</p><span class="bc-label">Academic Year 2025–2026</span></div>
        <div class="bc-actions">
          <a href="bulletin-view?file=January%202026%2FTHE%20BEACON%2007-01-2026.pdf" class="btn-bulletin-view"><i class="bi bi-eye me-1"></i>View</a>
          <a href="https://sjudata.s3.ap-south-1.amazonaws.com/Bulletin/Beacon%202025-2026/January%202026/THE%20BEACON%2007-01-2026.pdf" download class="btn-beacon-dl"><i class="bi bi-download me-1"></i>Download</a>
        </div>
      </div>

      </div><!-- end 2026 group -->

      <div class="beacon-year-group" data-year="2025">

      <!-- December 2025 -->
      <div class="beacon-month-header"><span class="month-label">December 2025</span><hr></div>

      <div class="beacon-card">
        <div class="bc-icon"><i class="fas fa-file-pdf"></i></div>
        <div class="bc-meta"><p class="bc-title">The Beacon – 19 December 2025</p><span class="bc-label">Academic Year 2025–2026</span></div>
        <div class="bc-actions">
          <a href="bulletin-view?file=December%202025%2FTHE%20BEACON%2019-12-2025%20.pdf" class="btn-bulletin-view"><i class="bi bi-eye me-1"></i>View</a>
          <a href="https://sjudata.s3.ap-south-1.amazonaws.com/Bulletin/Beacon%202025-2026/December%202025/THE%20BEACON%2019-12-2025%20.pdf" download class="btn-beacon-dl"><i class="bi bi-download me-1"></i>Download</a>
        </div>
      </div>

      <div class="beacon-card">
        <div class="bc-icon"><i class="fas fa-file-pdf"></i></div>
        <div class="bc-meta"><p class="bc-title">The Beacon – 16 December 2025</p><span class="bc-label">Academic Year 2025–2026</span></div>
        <div class="bc-actions">
          <a href="bulletin-view?file=December%202025%2FTHE%20BEACON%2016-12-2025.pdf" class="btn-bulletin-view"><i class="bi bi-eye me-1"></i>View</a>
          <a href="https://sjudata.s3.ap-south-1.amazonaws.com/Bulletin/Beacon%202025-2026/December%202025/THE%20BEACON%2016-12-2025.pdf" download class="btn-beacon-dl"><i class="bi bi-download me-1"></i>Download</a>
        </div>
      </div>

      <div class="beacon-card">
        <div class="bc-icon"><i class="fas fa-file-pdf"></i></div>
        <div class="bc-meta"><p class="bc-title">The Beacon – 15 December 2025</p><span class="bc-label">Academic Year 2025–2026</span></div>
        <div class="bc-actions">
          <a href="bulletin-view?file=December%202025%2FTHE%20BEACON%2015-12-2025.pdf" class="btn-bulletin-view"><i class="bi bi-eye me-1"></i>View</a>
          <a href="https://sjudata.s3.ap-south-1.amazonaws.com/Bulletin/Beacon%202025-2026/December%202025/THE%20BEACON%2015-12-2025.pdf" download class="btn-beacon-dl"><i class="bi bi-download me-1"></i>Download</a>
        </div>
      </div>

      <div class="beacon-card">
        <div class="bc-icon"><i class="fas fa-file-pdf"></i></div>
        <div class="bc-meta"><p class="bc-title">The Beacon – 13 December 2025</p><span class="bc-label">Academic Year 2025–2026</span></div>
        <div class="bc-actions">
          <a href="bulletin-view?file=December%202025%2FTHE%20BEACON%20%2013-12-2025.pdf" class="btn-bulletin-view"><i class="bi bi-eye me-1"></i>View</a>
          <a href="https://sjudata.s3.ap-south-1.amazonaws.com/Bulletin/Beacon%202025-2026/December%202025/THE%20BEACON%20%2013-12-2025.pdf" download class="btn-beacon-dl"><i class="bi bi-download me-1"></i>Download</a>
        </div>
      </div>

      <div class="beacon-card">
        <div class="bc-icon"><i class="fas fa-file-pdf"></i></div>
        <div class="bc-meta"><p class="bc-title">The Beacon – 12 December 2025</p><span class="bc-label">Academic Year 2025–2026</span></div>
        <div class="bc-actions">
          <a href="bulletin-view?file=December%202025%2FTHE%20BEACON%2012-12-2025.pdf" class="btn-bulletin-view"><i class="bi bi-eye me-1"></i>View</a>
          <a href="https://sjudata.s3.ap-south-1.amazonaws.com/Bulletin/Beacon%202025-2026/December%202025/THE%20BEACON%2012-12-2025.pdf" download class="btn-beacon-dl"><i class="bi bi-download me-1"></i>Download</a>
        </div>
      </div>

      <div class="beacon-card">
        <div class="bc-icon"><i class="fas fa-file-pdf"></i></div>
        <div class="bc-meta"><p class="bc-title">The Beacon – 11 December 2025</p><span class="bc-label">Academic Year 2025–2026</span></div>
        <div class="bc-actions">
          <a href="bulletin-view?file=December%202025%2FTHE%20BEACON%2011-12-2025.pdf" class="btn-bulletin-view"><i class="bi bi-eye me-1"></i>View</a>
          <a href="https://sjudata.s3.ap-south-1.amazonaws.com/Bulletin/Beacon%202025-2026/December%202025/THE%20BEACON%2011-12-2025.pdf" download class="btn-beacon-dl"><i class="bi bi-download me-1"></i>Download</a>
        </div>
      </div>

      <div class="beacon-card">
        <div class="bc-icon"><i class="fas fa-file-pdf"></i></div>
        <div class="bc-meta"><p class="bc-title">The Beacon – 10 December 2025</p><span class="bc-label">Academic Year 2025–2026</span></div>
        <div class="bc-actions">
          <a href="bulletin-view?file=December%202025%2FTHE%20BEACON%2010-12-2025.pdf" class="btn-bulletin-view"><i class="bi bi-eye me-1"></i>View</a>
          <a href="https://sjudata.s3.ap-south-1.amazonaws.com/Bulletin/Beacon%202025-2026/December%202025/THE%20BEACON%2010-12-2025.pdf" download class="btn-beacon-dl"><i class="bi bi-download me-1"></i>Download</a>
        </div>
      </div>

      <div class="beacon-card">
        <div class="bc-icon"><i class="fas fa-file-pdf"></i></div>
        <div class="bc-meta"><p class="bc-title">The Beacon – 08 December 2025</p><span class="bc-label">Academic Year 2025–2026</span></div>
        <div class="bc-actions">
          <a href="bulletin-view?file=December%202025%2FTHE%20BEACON%20%2008-12-2025.pdf" class="btn-bulletin-view"><i class="bi bi-eye me-1"></i>View</a>
          <a href="https://sjudata.s3.ap-south-1.amazonaws.com/Bulletin/Beacon%202025-2026/December%202025/THE%20BEACON%20%2008-12-2025.pdf" download class="btn-beacon-dl"><i class="bi bi-download me-1"></i>Download</a>
        </div>
      </div>

      <div class="beacon-card">
        <div class="bc-icon"><i class="fas fa-file-pdf"></i></div>
        <div class="bc-meta"><p class="bc-title">The Beacon – 05 December 2025</p><span class="bc-label">Academic Year 2025–2026</span></div>
        <div class="bc-actions">
          <a href="bulletin-view?file=December%202025%2FTHE%20BEACON%2005-12-2025.pdf" class="btn-bulletin-view"><i class="bi bi-eye me-1"></i>View</a>
          <a href="https://sjudata.s3.ap-south-1.amazonaws.com/Bulletin/Beacon%202025-2026/December%202025/THE%20BEACON%2005-12-2025.pdf" download class="btn-beacon-dl"><i class="bi bi-download me-1"></i>Download</a>
        </div>
      </div>

      <!-- November 2025 -->
      <div class="beacon-month-header"><span class="month-label">November 2025</span><hr></div>

      <div class="beacon-card">
        <div class="bc-icon"><i class="fas fa-file-pdf"></i></div>
        <div class="bc-meta"><p class="bc-title">The Beacon – 29 November 2025</p><span class="bc-label">Academic Year 2025–2026</span></div>
        <div class="bc-actions">
          <a href="bulletin-view?file=November%202025%2FTHE%20BEACON%2029-11-2025.pdf" class="btn-bulletin-view"><i class="bi bi-eye me-1"></i>View</a>
          <a href="https://sjudata.s3.ap-south-1.amazonaws.com/Bulletin/Beacon%202025-2026/November%202025/THE%20BEACON%2029-11-2025.pdf" download class="btn-beacon-dl"><i class="bi bi-download me-1"></i>Download</a>
        </div>
      </div>

      <div class="beacon-card">
        <div class="bc-icon"><i class="fas fa-file-pdf"></i></div>
        <div class="bc-meta"><p class="bc-title">The Beacon – 27 November 2025</p><span class="bc-label">Academic Year 2025–2026</span></div>
        <div class="bc-actions">
          <a href="bulletin-view?file=November%202025%2FTHE%20BEACON%2027-11-2025.pdf" class="btn-bulletin-view"><i class="bi bi-eye me-1"></i>View</a>
          <a href="https://sjudata.s3.ap-south-1.amazonaws.com/Bulletin/Beacon%202025-2026/November%202025/THE%20BEACON%2027-11-2025.pdf" download class="btn-beacon-dl"><i class="bi bi-download me-1"></i>Download</a>
        </div>
      </div>

      <!-- September 2025 -->
      <div class="beacon-month-header"><span class="month-label">September 2025</span><hr></div>

      <div class="beacon-card">
        <div class="bc-icon"><i class="fas fa-file-pdf"></i></div>
        <div class="bc-meta"><p class="bc-title">The Beacon – 23 September 2025</p><span class="bc-label">Academic Year 2025–2026</span></div>
        <div class="bc-actions">
          <a href="bulletin-view?file=September%202025%2FTHE%20BEACON%2023-09-2025.pdf" class="btn-bulletin-view"><i class="bi bi-eye me-1"></i>View</a>
          <a href="https://sjudata.s3.ap-south-1.amazonaws.com/Bulletin/Beacon%202025-2026/September%202025/THE%20BEACON%2023-09-2025.pdf" download class="btn-beacon-dl"><i class="bi bi-download me-1"></i>Download</a>
        </div>
      </div>

      <div class="beacon-card">
        <div class="bc-icon"><i class="fas fa-file-pdf"></i></div>
        <div class="bc-meta"><p class="bc-title">The Beacon – 18 September 2025</p><span class="bc-label">Academic Year 2025–2026</span></div>
        <div class="bc-actions">
          <a href="bulletin-view?file=September%202025%2FTHE%20BEACON%2018-09-2025.pdf" class="btn-bulletin-view"><i class="bi bi-eye me-1"></i>View</a>
          <a href="https://sjudata.s3.ap-south-1.amazonaws.com/Bulletin/Beacon%202025-2026/September%202025/THE%20BEACON%2018-09-2025.pdf" download class="btn-beacon-dl"><i class="bi bi-download me-1"></i>Download</a>
        </div>
      </div>

      <div class="beacon-card">
        <div class="bc-icon"><i class="fas fa-file-pdf"></i></div>
        <div class="bc-meta"><p class="bc-title">The Beacon – 13 September 2025</p><span class="bc-label">Academic Year 2025–2026</span></div>
        <div class="bc-actions">
          <a href="bulletin-view?file=September%202025%2FTHE%20BEACON%20%2013-09-2025.pdf" class="btn-bulletin-view"><i class="bi bi-eye me-1"></i>View</a>
          <a href="https://sjudata.s3.ap-south-1.amazonaws.com/Bulletin/Beacon%202025-2026/September%202025/THE%20BEACON%20%2013-09-2025.pdf" download class="btn-beacon-dl"><i class="bi bi-download me-1"></i>Download</a>
        </div>
      </div>

      <div class="beacon-card">
        <div class="bc-icon"><i class="fas fa-file-pdf"></i></div>
        <div class="bc-meta"><p class="bc-title">The Beacon – 05 September 2025</p><span class="bc-label">Academic Year 2025–2026</span></div>
        <div class="bc-actions">
          <a href="bulletin-view?file=September%202025%2FTHE%20BEACON%2005-09-2025.pdf" class="btn-bulletin-view"><i class="bi bi-eye me-1"></i>View</a>
          <a href="https://sjudata.s3.ap-south-1.amazonaws.com/Bulletin/Beacon%202025-2026/September%202025/THE%20BEACON%2005-09-2025.pdf" download class="btn-beacon-dl"><i class="bi bi-download me-1"></i>Download</a>
        </div>
      </div>

      <div class="beacon-card">
        <div class="bc-icon"><i class="fas fa-file-pdf"></i></div>
        <div class="bc-meta"><p class="bc-title">The Beacon – 04 September 2025</p><span class="bc-label">Academic Year 2025–2026</span></div>
        <div class="bc-actions">
          <a href="bulletin-view?file=September%202025%2FTHE%20BEACON%2004-09-2025%20.pdf" class="btn-bulletin-view"><i class="bi bi-eye me-1"></i>View</a>
          <a href="https://sjudata.s3.ap-south-1.amazonaws.com/Bulletin/Beacon%202025-2026/September%202025/THE%20BEACON%2004-09-2025%20.pdf" download class="btn-beacon-dl"><i class="bi bi-download me-1"></i>Download</a>
        </div>
      </div>

      <!-- August 2025 -->
      <div class="beacon-month-header"><span class="month-label">August 2025</span><hr></div>

      <div class="beacon-card">
        <div class="bc-icon"><i class="fas fa-file-pdf"></i></div>
        <div class="bc-meta"><p class="bc-title">The Beacon – 30 August 2025</p><span class="bc-label">Academic Year 2025–2026</span></div>
        <div class="bc-actions">
          <a href="bulletin-view?file=August%202025%2FTHE%20BEACON%2030-08-2025.pdf" class="btn-bulletin-view"><i class="bi bi-eye me-1"></i>View</a>
          <a href="https://sjudata.s3.ap-south-1.amazonaws.com/Bulletin/Beacon%202025-2026/August%202025/THE%20BEACON%2030-08-2025.pdf" download class="btn-beacon-dl"><i class="bi bi-download me-1"></i>Download</a>
        </div>
      </div>

      <div class="beacon-card">
        <div class="bc-icon"><i class="fas fa-file-pdf"></i></div>
        <div class="bc-meta"><p class="bc-title">The Beacon – 26 August 2025</p><span class="bc-label">Academic Year 2025–2026</span></div>
        <div class="bc-actions">
          <a href="bulletin-view?file=August%202025%2FTHE%20BEACON%2026-08-2025.pdf" class="btn-bulletin-view"><i class="bi bi-eye me-1"></i>View</a>
          <a href="https://sjudata.s3.ap-south-1.amazonaws.com/Bulletin/Beacon%202025-2026/August%202025/THE%20BEACON%2026-08-2025.pdf" download class="btn-beacon-dl"><i class="bi bi-download me-1"></i>Download</a>
        </div>
      </div>

      <div class="beacon-card">
        <div class="bc-icon"><i class="fas fa-file-pdf"></i></div>
        <div class="bc-meta"><p class="bc-title">The Beacon – 22 August 2025</p><span class="bc-label">Academic Year 2025–2026</span></div>
        <div class="bc-actions">
          <a href="bulletin-view?file=August%202025%2FTHE%20BEACON%2022-08-2025.pdf" class="btn-bulletin-view"><i class="bi bi-eye me-1"></i>View</a>
          <a href="https://sjudata.s3.ap-south-1.amazonaws.com/Bulletin/Beacon%202025-2026/August%202025/THE%20BEACON%2022-08-2025.pdf" download class="btn-beacon-dl"><i class="bi bi-download me-1"></i>Download</a>
        </div>
      </div>

      <div class="beacon-card">
        <div class="bc-icon"><i class="fas fa-file-pdf"></i></div>
        <div class="bc-meta"><p class="bc-title">The Beacon – 02 August 2025</p><span class="bc-label">Academic Year 2025–2026</span></div>
        <div class="bc-actions">
          <a href="bulletin-view?file=August%202025%2FTHE%20BEACON%2002-08-2025.pdf" class="btn-bulletin-view"><i class="bi bi-eye me-1"></i>View</a>
          <a href="https://sjudata.s3.ap-south-1.amazonaws.com/Bulletin/Beacon%202025-2026/August%202025/THE%20BEACON%2002-08-2025.pdf" download class="btn-beacon-dl"><i class="bi bi-download me-1"></i>Download</a>
        </div>
      </div>

      </div><!-- end 2025 group -->

      <div class="beacon-year-group" data-year="2023">
      <!-- 2022–2023 archive editions go here -->
      </div><!-- end 2023 group -->

    </article>
  </div>
</section>

<?php require_once '../footer.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="../assets/js/main.js"></script>

<script>
  function applyFilter(year) {
    document.querySelectorAll('.beacon-year-group').forEach(function(group) {
      group.style.display = (year === 'all' || group.dataset.year === year) ? '' : 'none';
    });
    document.querySelectorAll('.beacon-filter-btn').forEach(function(btn) {
      btn.classList.toggle('active', btn.dataset.year === year);
    });
  }

  document.querySelectorAll('.beacon-filter-btn').forEach(function(btn) {
    btn.addEventListener('click', function() { applyFilter(this.dataset.year); });
  });
</script>
</body>
</html>
