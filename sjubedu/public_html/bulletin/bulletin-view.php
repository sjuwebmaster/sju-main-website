<!doctype html>
<html lang="en" dir="ltr">
<head>
    <?php include $_SERVER['DOCUMENT_ROOT'] . '/gtm.php'; ?>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="robots" content="noindex, nofollow">

    <?php
    // -----------------------------------------------------------------------
    // Publication registry — add future bulletins here, no other file needed
    // -----------------------------------------------------------------------
    $publications = [
        'beacon' => [
            'label'        => 'The Beacon',
            'back_url'     => '/bulletin/sjubeacon',
            'back_label'   => 'The Beacon',
            's3_folder'    => 'Bulletin/Beacon%202025-2026/',
            'color'        => '#1a3a6b',
            'icon'         => 'fas fa-newspaper',
            'bg'           => '#e8edf5',
            // Valid filename prefixes (case-insensitive). Empty = any file accepted.
            'prefixes'     => ['THE BEACON'],
        ],
        'communique' => [
            'label'        => 'Communique',
            'back_url'     => '/bulletin/sjucommunique',
            'back_label'   => 'Communique',
            's3_folder'    => 'Bulletin/Communique/',
            'color'        => '#8b1a1a',
            'icon'         => 'fas fa-book-open',
            'bg'           => '#f5eaea',
            'prefixes'     => ['COMMUNIQUE', '2025 '],
        ],
        'photobeacon' => [
            'label'        => 'Photo Beacon',
            'back_url'     => '/bulletin/sjuphotobeacon',
            'back_label'   => 'Photo Beacon',
            's3_folder'    => 'Bulletin/Photo%20Beacon/',
            'color'        => '#1a5c3a',
            'icon'         => 'fas fa-camera',
            'bg'           => '#eaf3ee',
            'prefixes'     => ['PHOTOBEACON'],
        ],
    ];

    $s3_root = 'https://sjudata.s3.ap-south-1.amazonaws.com/';

    // --- Inputs ---
    $pub_key = isset($_GET['pub']) ? strtolower(trim($_GET['pub'])) : 'beacon';
    $file    = isset($_GET['file']) ? trim($_GET['file'])            : '';
    $src     = isset($_GET['src'])  ? trim($_GET['src'])             : 's3';

    // --- Validate publication ---
    if (!array_key_exists($pub_key, $publications)) {
        header('Location: /bulletin/sjubeacon'); exit;
    }
    $pub = $publications[$pub_key];

    // --- Validate file ---
    $valid = false;

    // dspace URLs (Beacon 2023 archive)
    if ($src === 'dspace' && strpos($file, 'http://dspace.sju.edu.in/bitstream/') === 0) {
        $valid = true;
    }

    // S3 filenames — prevent path traversal, allow one subfolder level
    if ($src === 's3' && strpos($file, '..') === false && substr_count($file, '/') <= 1) {
        $fname = basename($file);
        if (empty($pub['prefixes'])) {
            $valid = true;
        } else {
            foreach ($pub['prefixes'] as $prefix) {
                if (stripos($fname, $prefix) !== false) { $valid = true; break; }
            }
        }
    }

    if (!$valid || empty($file)) {
        header('Location: ' . $pub['back_url']); exit;
    }

    // --- Build PDF URL ---
    if ($src === 'dspace') {
        $pdf_url = $file;
    } else {
        // Encode each path component separately so subfolder slashes are preserved
        $parts   = explode('/', $file);
        $encoded = implode('/', array_map('rawurlencode', $parts));
        $pdf_url = $s3_root . $pub['s3_folder'] . $encoded;
    }

    // --- Derive display date ---
    $months_map = [
        '01'=>'January','02'=>'February','03'=>'March','04'=>'April',
        '05'=>'May','06'=>'June','07'=>'July','08'=>'August',
        '09'=>'September','10'=>'October','11'=>'November','12'=>'December',
        'JANUARY'=>'January','FEBRUARY'=>'February','MARCH'=>'March','APRIL'=>'April',
        'MAY'=>'May','JUNE'=>'June','JULY'=>'July','AUGUST'=>'August',
        'SEPTEMBER'=>'September','OCTOBER'=>'October','NOVEMBER'=>'November','DECEMBER'=>'December',
    ];
    $display_date = '';

    // DD-MM-YYYY format (Beacon)
    if (preg_match('/(\d{2})-(\d{2})-(\d{4})/', $file, $m)) {
        $display_date = $m[1] . ' ' . ($months_map[$m[2]] ?? $m[2]) . ' ' . $m[3];
    }
    // Month-name + year format (Communique)
    if (!$display_date) {
        foreach (['JANUARY','FEBRUARY','MARCH','APRIL','MAY','JUNE','JULY',
                  'AUGUST','SEPTEMBER','OCTOBER','NOVEMBER','DECEMBER'] as $mn) {
            if (stripos($file, $mn) !== false) {
                preg_match('/\b(20\d{2})\b/', $file, $ym);
                $display_date = $months_map[$mn] . ($ym[1] ? ' ' . $ym[1] : '');
                break;
            }
        }
    }

    $page_title = $pub['label'] . ($display_date ? ' – ' . $display_date : '');
    $bar_color  = $pub['color'];
    $bg_color   = $pub['bg'];
    $icon_class = $pub['icon'];
    ?>

    <title><?php echo htmlspecialchars($page_title); ?> | St Joseph's University, Bengaluru</title>
    <meta name="description" content="<?php echo htmlspecialchars($page_title); ?> – St Joseph's University, Bengaluru">

    <link rel="icon" href="../assets/img/favicon.png" type="image/png">
    <link rel="apple-touch-icon" href="../assets/img/favicon-apple.png">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400..900;1,400..900&family=Plus+Jakarta+Sans:ital,wght@0,200..800;1,200..800&family=Urbanist:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/fontawesome.min.css">
    <link rel="stylesheet" href="../assets/css/style.css?v=2.3">

    <style>
        .pub-viewer-bar {
            background: <?php echo $bar_color; ?>;
            color: #fff;
            padding: 12px 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 10px;
        }
        .pub-viewer-bar .pvb-title {
            font-size: 1rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .pub-viewer-bar .pvb-title i { font-size: 1.2rem; opacity: 0.85; }
        .pub-viewer-bar .pvb-actions { display: flex; gap: 8px; }
        .pub-viewer-bar a {
            font-size: 0.82rem;
            font-weight: 600;
            padding: 6px 16px;
            border-radius: 20px;
            text-decoration: none;
            border: 2px solid rgba(255,255,255,0.5);
            color: #fff;
            transition: background 0.15s;
        }
        .pub-viewer-bar a:hover { background: rgba(255,255,255,0.15); }
        .pub-viewer-bar a.btn-dl { background: rgba(255,255,255,0.18); border-color: transparent; }
        .pub-viewer-bar a.btn-dl:hover { background: rgba(255,255,255,0.3); }
        .pdf-frame-wrap { width: 100%; background: <?php echo $bg_color; ?>; }
        .pdf-frame-wrap iframe {
            width: 100%;
            height: calc(100vh - 220px);
            min-height: 500px;
            border: none;
            display: block;
        }
        @media (max-width: 576px) {
            .pdf-frame-wrap iframe { height: calc(100vh - 260px); min-height: 400px; }
            .pub-viewer-bar .pvb-title { font-size: 0.88rem; }
        }
    </style>
</head>
<body>
    <?php require_once '../header.php'; ?>

    <section class="breadcrumb-hero text-white">
      <div class="overlay"></div>
      <div class="container">
        <div class="row">
          <div class="col-12">
            <div class="breadcrumb-content text-center">
              <h1 class="page-title mb-2"><?php echo htmlspecialchars($pub['label']); ?></h1>
              <nav aria-label="breadcrumb">
                <ol class="breadcrumb justify-content-center mb-0">
                  <li class="breadcrumb-item"><a href="/" class="text-white text-decoration-none">Home</a></li>
                  <li class="breadcrumb-item">
                    <a href="<?php echo $pub['back_url']; ?>" class="text-white text-decoration-none">
                      <?php echo htmlspecialchars($pub['back_label']); ?>
                    </a>
                  </li>
                  <li class="breadcrumb-item active text-warning" aria-current="page">
                    <?php echo htmlspecialchars($display_date ?: 'Edition'); ?>
                  </li>
                </ol>
              </nav>
            </div>
          </div>
        </div>
      </div>
    </section>

    <div class="pub-viewer-bar">
      <div class="pvb-title">
        <i class="<?php echo $icon_class; ?>"></i>
        <?php echo htmlspecialchars($page_title); ?>
      </div>
      <div class="pvb-actions">
        <a href="<?php echo $pub['back_url']; ?>"><i class="bi bi-arrow-left me-1"></i>All Editions</a>
        <a href="<?php echo htmlspecialchars($pdf_url); ?>" download class="btn-dl"><i class="bi bi-download me-1"></i>Download</a>
      </div>
    </div>

    <div class="pdf-frame-wrap">
      <iframe
        src="<?php echo htmlspecialchars($pdf_url); ?>"
        title="<?php echo htmlspecialchars($page_title); ?>">
        <p>Your browser cannot display this PDF. <a href="<?php echo htmlspecialchars($pdf_url); ?>">Download it here.</a></p>
      </iframe>
    </div>

    <?php require_once '../footer.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/js/main.js"></script>
</body>
</html>
