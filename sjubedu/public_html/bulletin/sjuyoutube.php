<!doctype html>
<html class="no-js" lang="en" dir="ltr">
<head>
    <?php include $_SERVER['DOCUMENT_ROOT'] . '/gtm.php'; ?>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>SJU on YouTube | St Joseph's University, Bengaluru</title>
    <meta name="description" content="Watch all videos from the official St Joseph's University, Bengaluru YouTube channel â events, documentaries, promos, and campus life.">
    <link rel="canonical" href="https://www.sju.edu.in/bulletin/sjuyoutube">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="icon" href="../assets/img/favicon.png" type="image/png">
    <link rel="apple-touch-icon" href="../assets/img/favicon-apple.png">
    <link rel="manifest" href="../studentsupport/assets/img/favicons/manifest.json">
    <meta name="msapplication-TileColor" content="#ffffff">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400..900;1,400..900&family=Plus+Jakarta+Sans:ital,wght@0,200..800;1,200..800&family=Urbanist:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/fontawesome.min.css">
    <link rel="stylesheet" href="../assets/css/style.css?v=2.3">

    <style>
        :root { --yt: #c4302b; --yt-dark: #8b1a1a; }

        /* ââ Channel profile ââ */
        .yt-profile-card {
            display: flex;
            align-items: flex-start;
            gap: 20px;
            background: linear-gradient(135deg, #1a0a0a 0%, var(--yt-dark) 100%);
            border-radius: 14px;
            padding: 22px 26px;
            color: #fff;
            margin-bottom: 1.5rem;
        }
        .yt-profile-avatar img {
            width: 84px;
            height: 84px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid rgba(255,255,255,0.25);
            flex-shrink: 0;
        }
        .yt-profile-info { flex: 1; min-width: 0; }
        .yt-profile-info h5 { color: #fff; margin-bottom: 4px; }
        .yt-profile-meta {
            font-size: 0.82rem;
            color: rgba(255,255,255,0.7);
            margin-bottom: 8px;
        }
        .yt-profile-desc {
            font-size: 0.87rem;
            color: rgba(255,255,255,0.85);
            line-height: 1.6;
            margin-bottom: 12px;
        }
        .yt-profile-actions { display: flex; gap: 8px; flex-wrap: wrap; }
        .yt-btn-primary {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 0.82rem;
            font-weight: 700;
            padding: 7px 18px;
            border-radius: 20px;
            background: var(--yt);
            color: #fff;
            text-decoration: none;
            transition: background 0.15s;
        }
        .yt-btn-primary:hover { background: #a32724; color: #fff; }
        .yt-btn-ghost {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 0.82rem;
            font-weight: 700;
            padding: 7px 18px;
            border-radius: 20px;
            background: rgba(255,255,255,0.14);
            border: 1.5px solid rgba(255,255,255,0.3);
            color: #fff;
            text-decoration: none;
            transition: background 0.15s;
        }
        .yt-btn-ghost:hover { background: rgba(255,255,255,0.25); color: #fff; }

        /* ââ Filter & badge ââ */
        .beacon-section-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: linear-gradient(135deg, var(--yt-dark) 0%, var(--yt) 100%);
            color: #fff;
            font-size: 1rem;
            font-weight: 700;
            padding: 8px 22px;
            border-radius: 30px;
        }
        .yt-filter-btn {
            background: #fff;
            border: 2px solid var(--yt);
            color: var(--yt);
            font-size: 0.82rem;
            font-weight: 700;
            padding: 6px 20px;
            border-radius: 20px;
            cursor: pointer;
            transition: background 0.15s, color 0.15s;
        }
        .yt-filter-btn.active,
        .yt-filter-btn:hover { background: var(--yt); color: #fff; }

        /* ââ Video grid ââ */
        .yt-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            margin-top: 1rem;
        }
        .yt-card {
            background: #fff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0,0,0,0.08);
            transition: box-shadow 0.2s, transform 0.2s;
            cursor: pointer;
            text-decoration: none;
            display: flex;
            flex-direction: column;
        }
        .yt-card:hover {
            box-shadow: 0 6px 24px rgba(196,48,43,0.15);
            transform: translateY(-3px);
        }
        .yt-thumb-wrap {
            position: relative;
            aspect-ratio: 16/9;
            background: #111;
            overflow: hidden;
        }
        .yt-thumb-wrap img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
            transition: transform 0.3s;
        }
        .yt-card:hover .yt-thumb-wrap img { transform: scale(1.04); }
        .yt-play-btn {
            position: absolute;
            inset: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(0,0,0,0.25);
            transition: background 0.2s;
        }
        .yt-card:hover .yt-play-btn { background: rgba(0,0,0,0.4); }
        .yt-play-btn i {
            font-size: 2.8rem;
            color: #fff;
            filter: drop-shadow(0 2px 6px rgba(0,0,0,0.5));
        }
        .yt-year-badge {
            position: absolute;
            top: 8px;
            right: 8px;
            font-size: 0.7rem;
            font-weight: 800;
            background: var(--yt);
            color: #fff;
            padding: 2px 9px;
            border-radius: 12px;
        }
        .yt-card-body {
            padding: 12px 14px 14px;
            flex: 1;
        }
        .yt-card-title {
            font-size: 0.9rem;
            font-weight: 600;
            color: #1a2e4a;
            line-height: 1.4;
            margin: 0 0 6px;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        .yt-card-year {
            font-size: 0.75rem;
            color: #888;
        }

        /* ââ Custom overlay player ââ */
        #yt-overlay {
            display: none;
            position: fixed;
            inset: 0;
            z-index: 9999;
            background: rgba(0,0,0,0.92);
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        #yt-overlay.open { display: flex; }
        .yt-overlay-inner {
            position: relative;
            width: 100%;
            max-width: 900px;
        }
        .yt-overlay-close {
            position: absolute;
            top: -42px;
            right: 0;
            background: none;
            border: none;
            color: #fff;
            font-size: 1.8rem;
            cursor: pointer;
            line-height: 1;
            opacity: 0.85;
        }
        .yt-overlay-close:hover { opacity: 1; }
        .yt-overlay-ratio {
            position: relative;
            padding-bottom: 56.25%;
            height: 0;
            border-radius: 10px;
            overflow: hidden;
            background: #000;
        }
        .yt-overlay-ratio iframe {
            position: absolute;
            top: 0; left: 0;
            width: 100%; height: 100%;
            border: none;
        }
        .yt-overlay-title {
            color: rgba(255,255,255,0.88);
            margin-top: 12px;
            font-size: 0.9rem;
            font-weight: 600;
        }

        /* ââ No API notice ââ */
        .yt-api-notice {
            background: #fff8e1;
            border: 1.5px solid #ffc107;
            border-radius: 10px;
            padding: 14px 18px;
            font-size: 0.88rem;
            color: #6d5200;
            margin-bottom: 1.5rem;
        }

        @media (max-width: 768px) {
            .yt-grid { grid-template-columns: repeat(2, 1fr); gap: 14px; }
            .yt-profile-card { flex-direction: column; align-items: center; text-align: center; }
        }
        @media (max-width: 480px) {
            .yt-grid { grid-template-columns: 1fr; }
        }
    </style>

    <?php
    // âââââââââââââââââââââââââââââââââââââââââââââââââââââ
    //  YouTube Data API v3 â configuration
    //  Get a free key at https://console.cloud.google.com/
    //  Enable "YouTube Data API v3" then paste the key below.
    // âââââââââââââââââââââââââââââââââââââââââââââââââââââ
    define('YT_API_KEY',       '');            // â paste API key here
    define('YT_CHANNEL_HANDLE','SJUBengaluru');
    define('YT_CACHE_FILE',    sys_get_temp_dir() . '/sju_yt_videos.json');
    define('YT_CACHE_TTL',     86400);         // re-fetch every 24 hours

    // ââ Static fallback (used when no API key is set) ââ
    // thumbnail is derived from the video ID at render time; no need to hardcode it.
    $fallback_videos = [
        ['id'=>'47xEPoMHd-E','title'=>"St. Joseph's University Promo Video",         'year'=>'2024','thumbnail'=>''],
        ['id'=>'m1S5l5CyUYc','title'=>"St Joseph's University Promo",                 'year'=>'2024','thumbnail'=>''],
        ['id'=>'IPl_OkGI6eo','title'=>'Ignitors Program â Centre for Human Excellence','year'=>'2023','thumbnail'=>''],
        ['id'=>'WM2LBfI-7e8','title'=>'SJU Election Documentary',                     'year'=>'2023','thumbnail'=>''],
        ['id'=>'bK534lW88QE','title'=>'SJU Documentary',                               'year'=>'2023','thumbnail'=>''],
    ];

    $videos       = [];
    $channel_info = [];
    $api_active   = false;

    if (YT_API_KEY !== '') {
        $api_active = true;

        // ââ Load from cache or fetch fresh ââ
        if (file_exists(YT_CACHE_FILE) && (time() - filemtime(YT_CACHE_FILE)) < YT_CACHE_TTL) {
            $cached = json_decode(file_get_contents(YT_CACHE_FILE), true);
            $videos       = $cached['videos']  ?? [];
            $channel_info = $cached['channel'] ?? [];
        } else {
            $ctx = stream_context_create(['http'=>['timeout'=>10,'ignore_errors'=>true]]);

            // 1. Resolve handle â' channel info
            $ch_url  = 'https://www.googleapis.com/youtube/v3/channels?part=snippet,contentDetails,statistics'
                     . '&forHandle=' . urlencode(YT_CHANNEL_HANDLE)
                     . '&key=' . urlencode(YT_API_KEY);
            $ch_raw  = @file_get_contents($ch_url, false, $ctx);
            $ch_data = $ch_raw ? json_decode($ch_raw, true) : null;

            if (!empty($ch_data['items'][0])) {
                $ch      = $ch_data['items'][0];
                $uploads = $ch['contentDetails']['relatedPlaylists']['uploads'];

                $channel_info = [
                    'title'       => $ch['snippet']['title'],
                    'description' => $ch['snippet']['description'],
                    'thumbnail'   => $ch['snippet']['thumbnails']['high']['url']
                                  ?? $ch['snippet']['thumbnails']['default']['url'] ?? '',
                    'subscribers' => $ch['statistics']['subscriberCount'] ?? null,
                    'video_count' => $ch['statistics']['videoCount']      ?? null,
                    'handle'      => YT_CHANNEL_HANDLE,
                ];

                // 2. Paginate through the uploads playlist
                $page_token = '';
                do {
                    $pl_url  = 'https://www.googleapis.com/youtube/v3/playlistItems'
                             . '?part=snippet&maxResults=50'
                             . '&playlistId=' . urlencode($uploads)
                             . '&key=' . urlencode(YT_API_KEY)
                             . ($page_token ? '&pageToken=' . urlencode($page_token) : '');
                    $pl_raw  = @file_get_contents($pl_url, false, $ctx);
                    $pl_data = $pl_raw ? json_decode($pl_raw, true) : null;

                    foreach ($pl_data['items'] ?? [] as $item) {
                        $vid_id  = $item['snippet']['resourceId']['videoId'];
                        $pub     = $item['snippet']['publishedAt'];
                        $videos[] = [
                            'id'        => $vid_id,
                            'title'     => $item['snippet']['title'],
                            'thumbnail' => $item['snippet']['thumbnails']['high']['url']
                                        ?? $item['snippet']['thumbnails']['medium']['url']
                                        ?? $item['snippet']['thumbnails']['default']['url'] ?? '',
                            'year'      => substr($pub, 0, 4),
                            'published' => $pub,
                        ];
                    }
                    $page_token = $pl_data['nextPageToken'] ?? '';
                } while ($page_token);

                // 3. Cache
                file_put_contents(YT_CACHE_FILE, json_encode([
                    'channel' => $channel_info,
                    'videos'  => $videos,
                ], JSON_UNESCAPED_UNICODE));
            }
        }
    }

    // Fallback if API inactive or returned nothing
    if (empty($videos)) { $videos = $fallback_videos; }

    // Build sorted year list (newest first)
    $years = array_values(array_unique(array_column($videos, 'year')));
    rsort($years);
    ?>
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
      "name": "YouTube",
      "item": "https://www.sju.edu.in/bulletin/sjuyoutube"
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
    <div class="row"><div class="col-12">
      <div class="breadcrumb-content text-center">
        <h1 class="page-title mb-2">SJU on YouTube</h1>
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb justify-content-center mb-0">
            <li class="breadcrumb-item"><a href="/" class="text-white text-decoration-none">Home</a></li>
            <li class="breadcrumb-item"><a href="#" class="text-white text-decoration-none">Bulletin</a></li>
            <li class="breadcrumb-item active text-warning" aria-current="page">YouTube</li>
          </ol>
        </nav>
      </div>
    </div></div>
  </div>
</section>

<section class="iqac-page py-5 px-4">
  <div class="container">
    <article class="dept-section department_tab mb-5">

      <!-- Channel profile card -->
      <div class="yt-profile-card">
        <div class="yt-profile-avatar">
          <?php if (!empty($channel_info['thumbnail'])): ?>
            <img src="<?php echo htmlspecialchars($channel_info['thumbnail']); ?>" alt="SJU Bengaluru YouTube">
          <?php else: ?>
            <img src="https://yt3.googleusercontent.com/ytc/AIdro_kN6XsBxPbq-mS4v_5jRzf7O9NkfI_dDVz8bw=s88-c-k-c0x00ffffff-no-rj"
                 alt="SJU Bengaluru YouTube" onerror="this.src='../assets/img/favicon.png'">
          <?php endif; ?>
        </div>
        <div class="yt-profile-info">
          <div class="d-flex align-items-center gap-2 flex-wrap mb-1">
            <h5 class="fw-bold mb-0"><?php echo htmlspecialchars($channel_info['title'] ?? 'SJU Bengaluru'); ?></h5>
            <?php if (!empty($channel_info['subscribers'])): ?>
              <span style="font-size:.78rem;background:rgba(255,255,255,.15);color:#fff;padding:2px 10px;border-radius:12px;">
                <?php echo number_format((int)$channel_info['subscribers']); ?> subscribers
              </span>
            <?php endif; ?>
            <?php if (!empty($channel_info['video_count'])): ?>
              <span style="font-size:.78rem;color:rgba(255,255,255,.65);">
                <?php echo number_format((int)$channel_info['video_count']); ?> videos
              </span>
            <?php endif; ?>
          </div>
          <p class="yt-profile-desc">
            <?php
            $desc = $channel_info['description'] ?? 'The official YouTube channel of St Joseph\'s University, Bengaluru â featuring campus events, academic programmes, student life, documentaries, and more.';
            echo htmlspecialchars(mb_strimwidth($desc, 0, 280, 'â¦'));
            ?>
          </p>
          <div class="yt-profile-actions">
            <a href="https://www.youtube.com/@SJUBengaluru" target="_blank" rel="noopener" class="yt-btn-primary">
              <i class="bi bi-youtube"></i> Visit Channel
            </a>
            <a href="https://www.youtube.com/@SJUBengaluru/videos" target="_blank" rel="noopener" class="yt-btn-ghost">
              <i class="bi bi-collection-play"></i> All Videos
            </a>
            <a href="https://www.youtube.com/results?search_query=St+Joseph%27s+University+Bengaluru" target="_blank" rel="noopener" class="yt-btn-ghost">
              <i class="bi bi-search"></i> Search on YouTube
            </a>
          </div>
        </div>
      </div>

      <?php if (!$api_active): ?>
      <div class="yt-api-notice">
        <i class="bi bi-info-circle me-1"></i>
        <strong>Showing curated videos.</strong> To automatically display all <?php echo count($videos) > 5 ? count($videos) : ''; ?> channel videos, add a
        <strong>YouTube Data API v3</strong> key to the <code>YT_API_KEY</code> constant at the top of this file.
        Get one free at <a href="https://console.cloud.google.com/" target="_blank" rel="noopener">console.cloud.google.com</a>.
      </div>
      <?php endif; ?>

      <!-- Filter bar -->
      <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-3">
        <div class="beacon-section-badge">
          <i class="bi bi-play-circle-fill"></i>
          <span id="yt-count"><?php echo count($videos); ?></span> Videos
        </div>
        <div class="d-flex gap-2 flex-wrap" role="group" aria-label="Filter by year">
          <button class="yt-filter-btn active" data-year="all">All</button>
          <?php foreach ($years as $y): ?>
            <button class="yt-filter-btn" data-year="<?php echo $y; ?>"><?php echo $y; ?></button>
          <?php endforeach; ?>
        </div>
      </div>

      <!-- Video grid -->
      <div class="yt-grid" id="yt-grid">
        <?php foreach ($videos as $v): ?>
        <a class="yt-card"
           href="#"
           data-year="<?php echo htmlspecialchars($v['year']); ?>"
           data-vid="<?php echo htmlspecialchars($v['id']); ?>"
           data-title="<?php echo htmlspecialchars($v['title']); ?>"
           onclick="openYT(this); return false;">
          <div class="yt-thumb-wrap">
            <img src="<?php echo !empty($v['thumbnail']) ? htmlspecialchars($v['thumbnail']) : 'https://i.ytimg.com/vi/'.htmlspecialchars($v['id']).'/maxresdefault.jpg'; ?>"
                 alt="<?php echo htmlspecialchars($v['title']); ?>"
                 loading="lazy"
                 onerror="if(!this.dataset.fb){this.dataset.fb=1;this.src='https://i.ytimg.com/vi/<?php echo $v['id']; ?>/hqdefault.jpg';}else{this.onerror=null;this.style.opacity='0.3';}">
            <div class="yt-play-btn"><i class="bi bi-play-circle-fill"></i></div>
            <span class="yt-year-badge"><?php echo htmlspecialchars($v['year']); ?></span>
          </div>
          <div class="yt-card-body">
            <p class="yt-card-title"><?php echo htmlspecialchars($v['title']); ?></p>
            <span class="yt-card-year"><i class="bi bi-calendar3 me-1"></i><?php echo htmlspecialchars($v['year']); ?></span>
          </div>
        </a>
        <?php endforeach; ?>
      </div>

      <!-- Empty state -->
      <div id="yt-empty" style="display:none; text-align:center; padding:3rem 0; color:#888;">
        <i class="bi bi-camera-video" style="font-size:2.5rem;"></i>
        <p class="mt-2 mb-0">No videos found for this year.</p>
      </div>

    </article>
  </div>
</section>

<!-- YouTube Overlay Player -->
<div id="yt-overlay" role="dialog" aria-modal="true" aria-label="Video player">
  <div class="yt-overlay-inner">
    <button class="yt-overlay-close" onclick="closeYT()" aria-label="Close video">
      <i class="bi bi-x-circle-fill"></i>
    </button>
    <div class="yt-overlay-ratio">
      <iframe id="ytOverlayFrame"
              src=""
              allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
              allowfullscreen>
      </iframe>
    </div>
    <p class="yt-overlay-title" id="ytOverlayTitle"></p>
  </div>
</div>

<?php require_once '../footer.php'; ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="../assets/js/main.js"></script>

<script>
  var _ytOverlay = document.getElementById('yt-overlay');
  var _ytFrame   = document.getElementById('ytOverlayFrame');
  var _ytTitle   = document.getElementById('ytOverlayTitle');

  function openYT(el) {
    var vid   = el.dataset.vid;
    var title = el.dataset.title;
    _ytTitle.textContent = title;
    _ytFrame.src = 'https://www.youtube.com/embed/' + vid + '?autoplay=1&rel=0';
    _ytOverlay.classList.add('open');
    document.body.style.overflow = 'hidden';
    return false;
  }

  function closeYT() {
    _ytOverlay.classList.remove('open');
    _ytFrame.src = '';
    document.body.style.overflow = '';
  }

  _ytOverlay.addEventListener('click', function(e) {
    if (e.target === _ytOverlay) closeYT();
  });

  document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape' && _ytOverlay.classList.contains('open')) closeYT();
  });

  function applyFilter(year) {
    var cards = document.querySelectorAll('.yt-card');
    var count = 0;
    cards.forEach(function(c) {
      var show = (year === 'all' || c.dataset.year === year);
      c.style.display = show ? '' : 'none';
      if (show) count++;
    });
    document.getElementById('yt-count').textContent = count;
    document.getElementById('yt-empty').style.display = (count === 0) ? '' : 'none';
    document.querySelectorAll('.yt-filter-btn').forEach(function(btn) {
      btn.classList.toggle('active', btn.dataset.year === year);
    });
  }

  document.querySelectorAll('.yt-filter-btn').forEach(function(btn) {
    btn.addEventListener('click', function() { applyFilter(this.dataset.year); });
  });
</script>
</body>
</html>
