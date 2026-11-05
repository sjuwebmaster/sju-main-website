<!doctype html>
<html class="no-js" lang="en" dir="ltr">

<head>
    <?php include $_SERVER['DOCUMENT_ROOT'] . '/gtm.php'; ?>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Radio MACS – Campus Radio | St Joseph's University, Bengaluru</title>
    <meta name="description" content="Radio MACS is the campus radio program produced by students of the M.A. Journalism & Mass Communication program at St Joseph's University, Bengaluru.">
    <meta name="keywords" content="Radio MACS, Campus Radio, SJU Radio, St Joseph's University, Journalism, Audio Program">
    <link rel="canonical" href="https://www.sju.edu.in/bulletin/sjuradioicms">

    <!-- Open Graph / Social Sharing -->
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="St Joseph's University, Bengaluru">
    <meta property="og:title" content="Radio MACS – Campus Radio | St Joseph's University, Bengaluru">
    <meta property="og:description" content="Radio MACS is the campus radio program produced by students of the M.A. Journalism &amp; Mass Communication program at St Joseph's University, Bengaluru.">
    <meta property="og:url" content="https://www.sju.edu.in/bulletin/sjuradioicms">
    <meta property="og:image" content="https://www.sju.edu.in/assets/img/st-joseph-university-logo.png">
    <meta property="og:image:width" content="200">
    <meta property="og:image:height" content="200">
    <meta name="twitter:card" content="summary">
    <meta name="twitter:site" content="@StJosephsUniBLR">
    <meta name="twitter:title" content="Radio MACS – Campus Radio | St Joseph's University, Bengaluru">
    <meta name="twitter:description" content="Radio MACS is the campus radio program produced by students of the M.A. Journalism &amp; Mass Communication program at St Joseph's University, Bengaluru.">
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
        :root {
            --rc: #5b2d8e;
            --rc-dark: #3e1f63;
            --rc-light: #f3ecfc;
            --rc-mid: #7c4db8;
        }

        /* ── Section badge & filter ── */
        .beacon-section-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: linear-gradient(135deg, var(--rc-dark) 0%, var(--rc-mid) 100%);
            color: #fff;
            font-size: 1rem;
            font-weight: 700;
            padding: 8px 22px;
            border-radius: 30px;
        }
        .beacon-filter-btn {
            background: #fff;
            border: 2px solid var(--rc);
            color: var(--rc);
            font-size: 0.82rem;
            font-weight: 700;
            padding: 6px 20px;
            border-radius: 20px;
            cursor: pointer;
            transition: background 0.15s, color 0.15s;
        }
        .beacon-filter-btn.active,
        .beacon-filter-btn:hover { background: var(--rc); color: #fff; }

        /* ── Year divider ── */
        .rc-year-divider {
            display: flex;
            align-items: center;
            gap: 14px;
            margin: 2.2rem 0 1.2rem;
        }
        .rc-year-divider .ry-label {
            font-size: 0.78rem;
            font-weight: 800;
            letter-spacing: 0.14em;
            text-transform: uppercase;
            background: var(--rc);
            color: #fff;
            padding: 4px 16px;
            border-radius: 20px;
            white-space: nowrap;
        }
        .rc-year-divider hr {
            flex: 1;
            border-color: #d5c9e8;
            opacity: 1;
            margin: 0;
        }

        /* ── Episode card ── */
        .ep-card {
            background: #fff;
            border-radius: 14px;
            overflow: hidden;
            margin-bottom: 20px;
            box-shadow: 0 2px 12px rgba(91,45,142,0.08);
            transition: box-shadow 0.2s, transform 0.2s;
        }
        .ep-card:hover {
            box-shadow: 0 6px 24px rgba(91,45,142,0.16);
            transform: translateY(-2px);
        }

        /* Header strip */
        .ep-card .ep-head {
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 14px 18px 12px;
            background: linear-gradient(135deg, var(--rc-dark) 0%, var(--rc) 100%);
        }
        .ep-card .ep-badge {
            flex-shrink: 0;
            background: rgba(255,255,255,0.18);
            border: 2px solid rgba(255,255,255,0.35);
            color: #fff;
            font-size: 0.7rem;
            font-weight: 800;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            padding: 4px 12px;
            border-radius: 20px;
            white-space: nowrap;
        }
        .ep-card .ep-title {
            flex: 1;
            color: #fff;
            font-size: 0.97rem;
            font-weight: 700;
            margin: 0;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .ep-card .ep-year-tag {
            font-size: 0.75rem;
            color: rgba(255,255,255,0.7);
            white-space: nowrap;
        }
        .ep-card .ep-sc-link {
            flex-shrink: 0;
            display: flex;
            align-items: center;
            gap: 5px;
            font-size: 0.78rem;
            font-weight: 700;
            color: rgba(255,255,255,0.85);
            text-decoration: none;
            border: 1.5px solid rgba(255,255,255,0.4);
            padding: 4px 12px;
            border-radius: 20px;
            transition: background 0.15s, color 0.15s;
            white-space: nowrap;
        }
        .ep-card .ep-sc-link:hover {
            background: rgba(255,255,255,0.2);
            color: #fff;
        }

        /* Player */
        .ep-card .ep-player {
            background: #f7f3fc;
            padding: 0;
            line-height: 0;
        }
        .ep-card .ep-player iframe {
            width: 100%;
            height: 166px;
            border: none;
            display: block;
        }

        /* ── Profile card ── */
        .rc-profile-card {
            display: flex;
            align-items: flex-start;
            gap: 20px;
            background: linear-gradient(135deg, var(--rc-dark) 0%, var(--rc) 100%);
            border-radius: 14px;
            padding: 20px 24px;
            color: #fff;
        }
        .rc-profile-avatar { flex-shrink: 0; }
        .rc-profile-avatar img {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid rgba(255,255,255,0.3);
        }
        .rc-profile-info { flex: 1; min-width: 0; }
        .rc-profile-info h5 { color: #fff; }
        .rc-profile-bio {
            font-size: 0.88rem;
            color: rgba(255,255,255,0.85);
            line-height: 1.6;
        }
        .rc-sc-badge {
            display: inline-flex;
            align-items: center;
            font-size: 0.75rem;
            font-weight: 700;
            padding: 3px 10px;
            border-radius: 20px;
            background: rgba(255,255,255,0.18);
            border: 1.5px solid rgba(255,255,255,0.35);
            color: #fff;
            text-decoration: none;
            transition: background 0.15s;
            white-space: nowrap;
        }
        .rc-sc-badge:hover { background: rgba(255,255,255,0.3); color: #fff; }
        .rc-profile-btn {
            display: inline-flex;
            align-items: center;
            font-size: 0.83rem;
            font-weight: 700;
            padding: 7px 18px;
            border-radius: 20px;
            background: #fff;
            color: var(--rc-dark);
            text-decoration: none;
            transition: background 0.15s, color 0.15s;
        }
        .rc-profile-btn:hover { background: rgba(255,255,255,0.85); color: var(--rc-dark); }

        @media (max-width: 576px) {
            .rc-profile-card { flex-direction: column; align-items: center; text-align: center; }
            .ep-card .ep-head { flex-wrap: wrap; gap: 8px; }
            .ep-card .ep-title { font-size: 0.88rem; }
            .ep-card .ep-sc-link { font-size: 0.75rem; padding: 4px 10px; }
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
      "name": "Radio MACS",
      "item": "https://www.sju.edu.in/bulletin/sjuradioicms"
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
          <h1 class="page-title mb-2">Radio MACS</h1>
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb justify-content-center mb-0">
              <li class="breadcrumb-item"><a href="/" class="text-white text-decoration-none">Home</a></li>
              <li class="breadcrumb-item"><a href="#" class="text-white text-decoration-none">Bulletin</a></li>
              <li class="breadcrumb-item active text-warning" aria-current="page">Radio MACS</li>
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

      <!-- Profile card -->
      <div class="rc-profile-card mb-4">
        <div class="rc-profile-avatar">
          <img src="https://i1.sndcdn.com/avatars-z243nhNnH2ygW4o9-bJkkMg-t500x500.jpg"
               alt="Radio MACS" loading="lazy">
        </div>
        <div class="rc-profile-info">
          <div class="d-flex align-items-center gap-2 mb-1">
            <h5 class="fw-bold mb-0">Radio MACS</h5>
            <a href="https://soundcloud.com/campusradio-macs" target="_blank" rel="noopener"
               class="rc-sc-badge"><i class="bi bi-soundwave me-1"></i>SoundCloud</a>
          </div>
          <p class="rc-profile-bio mb-2">The campus radio initiative of the Institute of Communication and Media Studies (ICMS), St Joseph's University, Bengaluru. Each episode is researched, scripted, recorded, and produced entirely by student journalists — giving them hands-on experience in audio storytelling and broadcast journalism.</p>
          <p class="rc-profile-bio mb-3">From news features and interviews to documentaries and commentary, Radio MACS covers a broad spectrum of topics, building students' confidence as broadcasters and giving them a platform to reach audiences beyond the classroom.</p>
          <a href="https://soundcloud.com/campusradio-macs" target="_blank" rel="noopener" class="rc-profile-btn">
            <i class="bi bi-box-arrow-up-right me-1"></i> Visit Radio MACS on SoundCloud
          </a>
        </div>
      </div>

      <hr class="mb-4">

      <!-- Filter + badge -->
      <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-2">
        <div class="beacon-section-badge">
          <i class="fas fa-broadcast-tower"></i> All Episodes
        </div>
        <div class="d-flex gap-2 flex-wrap" role="group" aria-label="Filter by year">
          <button class="beacon-filter-btn active" data-year="all">All</button>
          <button class="beacon-filter-btn" data-year="2026">2026</button>
          <button class="beacon-filter-btn" data-year="2025">2025</button>
        </div>
      </div>

      <!-- ══ 2026 ══ -->
      <div class="beacon-year-group" data-year="2026">
        <div class="rc-year-divider"><span class="ry-label">2026</span><hr></div>

        <div class="ep-card">
          <div class="ep-head">
            <span class="ep-badge">EP 08</span>
            <p class="ep-title">Radio MACS – Episode 8</p>
            <span class="ep-year-tag">2026</span>
            <a href="https://soundcloud.com/campusradio-macs/radio-macs-2026-episode-8" target="_blank" rel="noopener" class="ep-sc-link"><i class="bi bi-soundwave me-1"></i>SoundCloud</a>
          </div>
          <div class="ep-player">
            <iframe scrolling="no" frameborder="no" allow="autoplay"
              src="https://w.soundcloud.com/player/?url=https%3A//api.soundcloud.com/tracks/2289124877&color=%235b2d8e&auto_play=false&hide_related=true&show_comments=false&show_user=true&show_reposts=false&show_teaser=false">
            </iframe>
          </div>
        </div>

        <div class="ep-card">
          <div class="ep-head">
            <span class="ep-badge">EP 07</span>
            <p class="ep-title">Radio MACS – Episode 7</p>
            <span class="ep-year-tag">2026</span>
            <a href="https://soundcloud.com/campusradio-macs/radio-macs-2026-episode-7" target="_blank" rel="noopener" class="ep-sc-link"><i class="bi bi-soundwave me-1"></i>SoundCloud</a>
          </div>
          <div class="ep-player">
            <iframe scrolling="no" frameborder="no" allow="autoplay"
              src="https://w.soundcloud.com/player/?url=https%3A//api.soundcloud.com/tracks/2289112091&color=%235b2d8e&auto_play=false&hide_related=true&show_comments=false&show_user=true&show_reposts=false&show_teaser=false">
            </iframe>
          </div>
        </div>

        <div class="ep-card">
          <div class="ep-head">
            <span class="ep-badge">EP 06</span>
            <p class="ep-title">Radio MACS – Episode 6</p>
            <span class="ep-year-tag">2026</span>
            <a href="https://soundcloud.com/campusradio-macs/radio-macs-2026-episode-6" target="_blank" rel="noopener" class="ep-sc-link"><i class="bi bi-soundwave me-1"></i>SoundCloud</a>
          </div>
          <div class="ep-player">
            <iframe scrolling="no" frameborder="no" allow="autoplay"
              src="https://w.soundcloud.com/player/?url=https%3A//api.soundcloud.com/tracks/2288944319&color=%235b2d8e&auto_play=false&hide_related=true&show_comments=false&show_user=true&show_reposts=false&show_teaser=false">
            </iframe>
          </div>
        </div>

        <div class="ep-card">
          <div class="ep-head">
            <span class="ep-badge">EP 05</span>
            <p class="ep-title">Radio MACS – Episode 5</p>
            <span class="ep-year-tag">2026</span>
            <a href="https://soundcloud.com/campusradio-macs/radio-macs-2026-episode-5" target="_blank" rel="noopener" class="ep-sc-link"><i class="bi bi-soundwave me-1"></i>SoundCloud</a>
          </div>
          <div class="ep-player">
            <iframe scrolling="no" frameborder="no" allow="autoplay"
              src="https://w.soundcloud.com/player/?url=https%3A//api.soundcloud.com/tracks/2288939765&color=%235b2d8e&auto_play=false&hide_related=true&show_comments=false&show_user=true&show_reposts=false&show_teaser=false">
            </iframe>
          </div>
        </div>

        <div class="ep-card">
          <div class="ep-head">
            <span class="ep-badge">EP 02</span>
            <p class="ep-title">Radio MACS – Episode 2</p>
            <span class="ep-year-tag">2026</span>
            <a href="https://soundcloud.com/campusradio-macs/radio-macs-2026-episode-2" target="_blank" rel="noopener" class="ep-sc-link"><i class="bi bi-soundwave me-1"></i>SoundCloud</a>
          </div>
          <div class="ep-player">
            <iframe scrolling="no" frameborder="no" allow="autoplay"
              src="https://w.soundcloud.com/player/?url=https%3A//api.soundcloud.com/tracks/2247112391&color=%235b2d8e&auto_play=false&hide_related=true&show_comments=false&show_user=true&show_reposts=false&show_teaser=false">
            </iframe>
          </div>
        </div>

      </div><!-- end 2026 -->

      <!-- ══ 2025 ══ -->
      <div class="beacon-year-group" data-year="2025">
        <div class="rc-year-divider"><span class="ry-label">2025</span><hr></div>

        <div class="ep-card">
          <div class="ep-head">
            <span class="ep-badge">EP 04</span>
            <p class="ep-title">Radio MACS – Episode 4</p>
            <span class="ep-year-tag">2025</span>
            <a href="https://soundcloud.com/campusradio-macs/radio-macs-2025-episode-4" target="_blank" rel="noopener" class="ep-sc-link"><i class="bi bi-soundwave me-1"></i>SoundCloud</a>
          </div>
          <div class="ep-player">
            <iframe scrolling="no" frameborder="no" allow="autoplay"
              src="https://w.soundcloud.com/player/?url=https%3A//api.soundcloud.com/tracks/2285978738&color=%235b2d8e&auto_play=false&hide_related=true&show_comments=false&show_user=true&show_reposts=false&show_teaser=false">
            </iframe>
          </div>
        </div>

        <div class="ep-card">
          <div class="ep-head">
            <span class="ep-badge">EP 01</span>
            <p class="ep-title">Radio MACS – Episode 1</p>
            <span class="ep-year-tag">2025</span>
            <a href="https://soundcloud.com/campusradio-macs/radio-macs-2025-episode-1" target="_blank" rel="noopener" class="ep-sc-link"><i class="bi bi-soundwave me-1"></i>SoundCloud</a>
          </div>
          <div class="ep-player">
            <iframe scrolling="no" frameborder="no" allow="autoplay"
              src="https://w.soundcloud.com/player/?url=https%3A//api.soundcloud.com/tracks/2236128584&color=%235b2d8e&auto_play=false&hide_related=true&show_comments=false&show_user=true&show_reposts=false&show_teaser=false">
            </iframe>
          </div>
        </div>

      </div><!-- end 2025 -->

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
