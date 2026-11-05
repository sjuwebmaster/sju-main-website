<!doctype html>
<html lang="en" dir="ltr">
<head>
    <?php include $_SERVER['DOCUMENT_ROOT'] . '/gtm.php'; ?>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Sustainable Development Goals (SDGs) | St Joseph's University, Bengaluru</title>
    <meta name="description" content="St Joseph's University's commitment to the United Nations Sustainable Development Goals â embedding the 2030 Agenda across teaching, research, and community engagement.">
    <meta name="keywords" content="SDG, Sustainable Development Goals, St Joseph's University, UN 2030 Agenda, Sustainability, Bengaluru, Jesuit University">
    <meta name="robots" content="index, follow">
    <link rel="canonical" href="https://www.sju.edu.in/sdg/">
    <meta property="og:title" content="Sustainable Development Goals | St Joseph's University, Bengaluru">
    <meta property="og:description" content="St Joseph's University aligns its academic mission with all 17 UN SDGs â across curriculum, research, campus operations, and community engagement.">
    <meta property="og:url" content="https://www.sju.edu.in/sdg/">
    <meta property="og:type" content="website">
    <meta property="og:image" content="https://www.sju.edu.in/assets/img/og-sdg.jpg">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="icon" href="../assets/img/favicon.png" type="image/png">
    <link rel="apple-touch-icon" href="../assets/img/favicon-apple.png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400..900;1,400..900&family=Plus+Jakarta+Sans:ital,wght@0,200..800;1,200..800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="../../assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../assets/css/fontawesome.min.css">
    <link rel="stylesheet" href="../../assets/css/magnific-popup.min.css">
    <link rel="stylesheet" href="../../assets/css/swiper-bundle.min.css">
    <link rel="stylesheet" href="../../assets/css/style.css?v=2.3">
<style>
:root {
  --sdg1:#E5243B;--sdg2:#DDA63A;--sdg3:#4C9F38;--sdg4:#C5192D;
  --sdg5:#FF3A21;--sdg6:#26BDE2;--sdg7:#FCC30B;--sdg8:#A21942;
  --sdg9:#FD6925;--sdg10:#DD1367;--sdg11:#FD9D24;--sdg12:#BF8B2E;
  --sdg13:#3F7E44;--sdg14:#0A97D9;--sdg15:#56C02B;--sdg16:#00689D;
  --sdg17:#19486A;
}

/* ââ Stat bar ââ */
.sdg-stat-bar { background:#fff; border-bottom:1px solid #e8ecf3; padding:0; }
.sdg-stat-bar .container { padding:0; max-width:100%; }
.sdg-stat-bar .d-flex { display:grid !important; grid-template-columns:repeat(4,1fr); gap:0; }
.sdg-stat-item { display:flex; flex-direction:column; align-items:center; justify-content:center; gap:4px; padding:22px 16px; text-align:center; border-right:none; position:relative; }
.sdg-stat-item:nth-child(1) { background:linear-gradient(135deg,#1a3c6e,#2563b0); }
.sdg-stat-item:nth-child(2) { background:linear-gradient(135deg,#15803d,#22c55e); }
.sdg-stat-item:nth-child(3) { background:linear-gradient(135deg,#b45309,#f59e0b); }
.sdg-stat-item:nth-child(4) { background:linear-gradient(135deg,#6d28d9,#a78bfa); }
.sdg-stat-num { font-size:2rem; font-weight:900; line-height:1; color:#fff; }
.sdg-stat-lbl { font-size:.72rem; color:rgba(255,255,255,.8); text-transform:uppercase; letter-spacing:.06em; line-height:1.3; }

/* ââ Commitment section ââ */
.sdg-commitment { background:linear-gradient(135deg,#eef4ff 0%,#f8fafc 55%,#f0fdf4 100%); padding:72px 0; }
.sdg-commitment .eyebrow { font-size:.75rem; font-weight:700; letter-spacing:.14em; text-transform:uppercase; color:#1e40af; margin-bottom:16px; display:inline-flex; align-items:center; gap:6px; background:rgba(37,99,176,.09); padding:5px 14px; border-radius:20px; }
.sdg-commitment h2 { font-size:2.2rem; font-weight:800; line-height:1.2; background:linear-gradient(120deg,#0f172a 0%,#1d4ed8 60%,#15803d 100%); -webkit-background-clip:text; -webkit-text-fill-color:transparent; background-clip:text; }
.sdg-commitment p { color:#334155; font-size:1rem; line-height:1.75; max-width:560px; }
.sdg-commitment p em { color:#1d4ed8; font-style:italic; font-weight:600; -webkit-text-fill-color:#1d4ed8; }
.sdg-wheel-wrap { position:relative; }
.sdg-wheel-wrap img { border-radius:20px; box-shadow:0 20px 60px rgba(0,0,0,.12); }
.sdg-un-tag {
  position:absolute; bottom:-18px; right:20px;
  background:#fff; border:1.5px solid #e2e8f0;
  border-radius:12px; padding:10px 16px;
  font-size:.78rem; font-weight:700; color:#1a3c6e;
  box-shadow:0 4px 16px rgba(0,0,0,.08);
  display:flex; align-items:center; gap:8px;
}

/* ââ SDG Tiles section ââ */
.sdg-tiles-section { background:#0f172a; padding:64px 0; }
.sdg-tiles-section h2 { color:#fff; font-size:1.5rem; font-weight:800; }
.sdg-tiles-section p { color:rgba(255,255,255,.6); font-size:.9rem; }
.sdg-tile-grid {
  display:grid;
  grid-template-columns:repeat(6,1fr);
  gap:8px;
  margin-top:36px;
}
.sdg-tile {
  aspect-ratio:1;
  border-radius:10px;
  overflow:hidden;
  position:relative;
  cursor:pointer;
  transition:transform .2s, box-shadow .2s;
}
@media (hover: hover) {
  .sdg-tile:hover { transform:scale(1.08); box-shadow:0 8px 28px rgba(0,0,0,.4); z-index:2; }
}
.sdg-tile img { width:100%; height:100%; object-fit:cover; display:block; border-radius:10px; }
.sdg-tile-fallback {
  width:100%; height:100%; border-radius:10px;
  display:flex; flex-direction:column;
  align-items:center; justify-content:center;
  color:#fff; text-align:center; padding:6px;
}
.sdg-tile-fallback .tn { font-size:1.4rem; font-weight:900; line-height:1; }
.sdg-tile-fallback .tl { font-size:.58rem; font-weight:700; line-height:1.2; margin-top:3px; text-transform:uppercase; letter-spacing:.02em; }

/* ââ Contribution cards ââ */
.sdg-contrib-section { background:#fff; padding:72px 0; }
.sdg-contrib-section .sec-label { font-size:.75rem; font-weight:700; letter-spacing:.14em; text-transform:uppercase; color:#2563b0; }
.sdg-contrib-section h2 { font-size:1.8rem; font-weight:800; color:#0f172a; }

.sdg-contrib-card {
  border-radius:16px; overflow:hidden;
  background:#fff; border:1px solid #e8ecf3;
  height:100%;
  transition:box-shadow .22s, transform .22s;
  display:flex; flex-direction:column;
}
@media (hover: hover) {
  .sdg-contrib-card:hover { box-shadow:0 12px 36px rgba(0,0,0,.1); transform:translateY(-4px); }
}
.sdg-contrib-card .card-img-wrap { position:relative; height:100px; overflow:hidden; flex-shrink:0; }
.sdg-contrib-card .card-img-wrap img { width:100%; height:100%; object-fit:cover; }
.sdg-contrib-card .card-img-fallback {
  width:100%; height:100%;
  display:flex; align-items:center; justify-content:center;
  color:#fff;
}
.sdg-contrib-card .card-img-fallback .cn { font-size:2.8rem; font-weight:900; opacity:.25; }
.sdg-contrib-card .card-img-fallback .ct { font-size:.7rem; font-weight:700; text-transform:uppercase; letter-spacing:.05em; position:absolute; bottom:10px; left:12px; }
.sdg-contrib-card .card-body-inner { padding:16px 18px 18px; flex:1; display:flex; flex-direction:column; }
.sdg-contrib-card .card-goal-num { font-size:.7rem; font-weight:800; padding:2px 10px; border-radius:20px; color:#fff; display:inline-block; margin-bottom:8px; }
.sdg-contrib-card h6 { font-size:.88rem; font-weight:700; color:#1a3c6e; margin-bottom:6px; line-height:1.35; }
.sdg-contrib-card p { font-size:.8rem; color:#64748b; line-height:1.6; flex:1; margin:0 0 12px; }
.sdg-contrib-card .tags { display:flex; flex-wrap:wrap; gap:4px; margin-top:auto; }
.sdg-contrib-card .tag { font-size:.68rem; font-weight:600; padding:2px 9px; border-radius:20px; background:#f1f5f9; color:#475569; }

/* ââ Pillars ââ */
.sdg-pillars { background:#f8fafc; padding:72px 0; }
.pillar-row { display:flex; gap:0; border:1px solid #e2e8f0; border-radius:16px; overflow:hidden; }
.pillar-item { flex:1; padding:32px 24px; border-right:1px solid #e2e8f0; transition:background .15s; }
.pillar-item:last-child { border-right:none; }
.pillar-item:hover { background:#fff; }
.pillar-accent { width:36px; height:4px; border-radius:2px; margin-bottom:16px; }
.pillar-icon { font-size:1.8rem; margin-bottom:12px; display:block; }
.pillar-item h5 { font-size:.95rem; font-weight:800; color:#1a3c6e; margin-bottom:8px; }
.pillar-item p { font-size:.82rem; color:#64748b; margin:0; line-height:1.65; }

/* ââ Initiatives ââ */
.sdg-initiatives { background:#fff; padding:72px 0; }
.initiative-row { display:flex; gap:16px; align-items:flex-start; padding:20px 0; border-bottom:1px solid #f1f5f9; }
.initiative-row:last-child { border-bottom:none; }
.init-num { width:36px; height:36px; border-radius:8px; flex-shrink:0; display:flex; align-items:center; justify-content:center; font-size:.72rem; font-weight:800; color:#fff; }
.initiative-row h6 { font-size:.92rem; font-weight:700; color:#1a3c6e; margin:0 0 4px; }
.initiative-row p { font-size:.83rem; color:#64748b; margin:0; line-height:1.55; }
.sdg-mini-badge { font-size:.65rem; font-weight:700; color:#fff; padding:1px 7px; border-radius:20px; display:inline-block; margin-right:3px; }

/* ââ CTA ââ */
.sdg-cta-section { background:#0f172a; padding:72px 0; }
.sdg-cta-section h2 { font-size:2rem; font-weight:800; color:#fff; }
.sdg-cta-section p { color:rgba(255,255,255,.65); font-size:1rem; }
.btn-cta-primary { background:#fff; color:#0f172a; border-radius:10px; font-weight:700; padding:13px 30px; text-decoration:none; display:inline-block; transition:opacity .15s; }
.btn-cta-primary:hover { opacity:.9; color:#0f172a; }
.btn-cta-ghost { background:transparent; color:#fff; border:1.5px solid rgba(255,255,255,.35); border-radius:10px; font-weight:700; padding:12px 30px; text-decoration:none; display:inline-block; transition:border-color .15s; }
.btn-cta-ghost:hover { border-color:#fff; color:#fff; }

/* ââ SDG badge ââ */
.sdg-badge { display:inline-block; font-size:.68rem; font-weight:700; color:#fff; padding:2px 8px; border-radius:20px; }

/* ââ Tablet (â¤991px) ââ */
@media (max-width:991px) {
  .pillar-row { flex-direction:column; }
  .pillar-item { border-right:none; border-bottom:1px solid #e2e8f0; }
  .pillar-item:last-child { border-bottom:none; }
  .pillar-item { padding:24px 20px; }

  .sdg-tile-grid { grid-template-columns:repeat(4,1fr); gap:6px; }

  .sdg-commitment { padding:48px 0; }
  .sdg-commitment h2 { font-size:1.9rem; }

  .sdg-contrib-section { padding:52px 0; }
  .sdg-pillars, .sdg-initiatives { padding:52px 0; }
  .sdg-cta-section { padding:52px 0; }

  .sdg-un-tag { font-size:.72rem; padding:8px 12px; right:12px; bottom:-14px; }
}

/* ââ Mobile (â¤767px) ââ */
@media (max-width:767px) {
  /* Stat bar: 2Ã2 grid on mobile */
  .sdg-stat-bar .d-flex { grid-template-columns:1fr 1fr !important; }
  .sdg-stat-item { padding:18px 12px; }
  .sdg-stat-num { font-size:1.6rem; }

  /* Commitment */
  .sdg-commitment { padding:40px 0 56px; }
  .sdg-commitment h2 { font-size:1.6rem; }
  .sdg-commitment p { font-size:.92rem; }
  .sdg-wheel-wrap { margin-top:8px; }
  .sdg-un-tag { position:static; margin-top:14px; display:inline-flex; border-radius:10px; font-size:.74rem; }

  /* Tile grid */
  .sdg-tile-grid { grid-template-columns:repeat(3,1fr); gap:5px; margin-top:24px; }
  .sdg-tiles-section { padding:44px 0; }
  .sdg-tiles-section h2 { font-size:1.3rem; }

  /* Contribution section */
  .sdg-contrib-section { padding:44px 0; }
  .sdg-contrib-section h2 { font-size:1.5rem; }
  .sdg-contrib-card .card-img-wrap { height:80px; }

  /* Pillars */
  .sdg-pillars { padding:44px 0; }
  .pillar-item { padding:20px 18px; }
  .pillar-icon { font-size:1.5rem; margin-bottom:8px; }

  /* Initiatives */
  .sdg-initiatives { padding:44px 0; }
  .initiative-row { gap:12px; }
  .initiative-row h6 { font-size:.85rem; }
  .initiative-row p { font-size:.79rem; }

  /* CTA */
  .sdg-cta-section { padding:44px 0; }
  .sdg-cta-section h2 { font-size:1.5rem; }
  .btn-cta-primary, .btn-cta-ghost { padding:12px 16px; font-size:.9rem; }
  .sdg-cta-section .col-lg-5 { width:100%; }
  .sdg-cta-section .col-lg-5 .d-flex { flex-direction:column !important; gap:10px !important; }
  .sdg-cta-section .col-lg-5 .btn-cta-primary,
  .sdg-cta-section .col-lg-5 .btn-cta-ghost { width:100%; text-align:center; }
}

/* ââ Small mobile (â¤480px) ââ */
@media (max-width:480px) {
  .sdg-tile-grid { grid-template-columns:repeat(3,1fr); gap:4px; }
  .sdg-stat-num { font-size:1.4rem; }
  .sdg-stat-lbl { font-size:.68rem; }
  .sdg-commitment h2 { font-size:1.4rem; }
  .sdg-contrib-card .card-goal-num { font-size:.65rem; }
  .sdg-contrib-card h6 { font-size:.84rem; }
  .sdg-contrib-card p { font-size:.77rem; }
  .init-num { width:30px; height:30px; font-size:.65rem; }
}

/* ââ Very small (â¤360px) ââ */
@media (max-width:360px) {
  .sdg-tile-grid { grid-template-columns:repeat(3,1fr); gap:3px; }
  .sdg-commitment h2 { font-size:1.25rem; }
  .sdg-contrib-section .row.mb-5 { margin-bottom:24px !important; }
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
      "name": "About",
      "item": "https://www.sju.edu.in/sdg/"
    },
    {
      "@type": "ListItem",
      "position": 3,
      "name": "SDGs",
      "item": "https://www.sju.edu.in/sdg/"
    }
  ]
}
</script>
</head>
<body>
<?php require_once '../header.php'; ?>
<?php include '_nav.php'; ?>

<!-- BREADCRUMB -->
<section class="breadcrumb-hero text-white">
  <div class="overlay"></div>
  <div class="container">
    <div class="breadcrumb-content text-center">
      <h1 class="page-title mb-2">Sustainable Development Goals</h1>
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb justify-content-center mb-0">
          <li class="breadcrumb-item"><a href="/" class="text-white text-decoration-none">Home</a></li>
          <li class="breadcrumb-item"><a href="#" class="text-white text-decoration-none">About</a></li>
          <li class="breadcrumb-item active text-warning" aria-current="page">SDGs</li>
        </ol>
      </nav>
    </div>
  </div>
</section>

<!-- STAT BAR -->
<div class="sdg-stat-bar">
  <div class="container">
    <div class="d-flex flex-wrap justify-content-center justify-content-md-start">
      <div class="sdg-stat-item">
        <div class="sdg-stat-num">17</div>
        <div class="sdg-stat-lbl">SDGs<br>Engaged</div>
      </div>
      <div class="sdg-stat-item">
        <div class="sdg-stat-num">50+</div>
        <div class="sdg-stat-lbl">SDG-linked<br>Programmes</div>
      </div>
      <div class="sdg-stat-item">
        <div class="sdg-stat-num">30+</div>
        <div class="sdg-stat-lbl">Community<br>Initiatives</div>
      </div>
      <div class="sdg-stat-item">
        <div class="sdg-stat-num">2030</div>
        <div class="sdg-stat-lbl">Commitment<br>Year</div>
      </div>
    </div>
  </div>
</div>

<!-- COMMITMENT -->
<section class="sdg-commitment">
  <div class="container">
    <div class="row align-items-center g-5">
      <div class="col-lg-6">
        <span class="eyebrow">UN 2030 Agenda Â· Jesuit Mission</span>
        <h2>Transforming Our World,<br>One Goal at a Time</h2>
        <p class="mt-3">St Joseph's University, Bengaluru â rooted in the Jesuit tradition of <em>cura personalis</em> â aligns its teaching, research, and campus life with all 17 United Nations Sustainable Development Goals. Our commitment to a just, equitable, and sustainable world is not a programme; it is a way of being.</p>
        <div class="d-flex gap-3 mt-4 flex-wrap">
          <a href="our-goals.php" class="btn btn-primary rounded-pill px-4 flex-grow-1 flex-md-grow-0">Explore Our Goals</a>
          <a href="initiatives.php" class="btn btn-outline-secondary rounded-pill px-4 flex-grow-1 flex-md-grow-0">See Initiatives</a>
        </div>
      </div>
      <div class="col-lg-6">
        <div class="sdg-wheel-wrap">
          <img src="assets/img/sdg-wheel.png"
               alt="UN Sustainable Development Goals Wheel" class="img-fluid w-100">
        </div>
      </div>
    </div>
  </div>
</section>

<!-- SDG TILE GRID -->
<section class="sdg-tiles-section">
  <div class="container">
    <div class="row align-items-end">
      <div class="col-md-7">
        <h2>The 17 Goals</h2>
        <p>Click any goal to see SJU's specific contribution.</p>
      </div>
      <div class="col-md-5 text-md-end">
        <a href="our-goals.php" class="text-white text-decoration-none" style="font-size:.85rem;font-weight:600;opacity:.7;">View All Goals <i class="bi bi-arrow-right"></i></a>
      </div>
    </div>
    <?php
    $sdgs = [
      1=>['No Poverty','#E5243B'],2=>['Zero Hunger','#DDA63A'],
      3=>['Good Health','#4C9F38'],4=>['Quality Education','#C5192D'],
      5=>['Gender Equality','#FF3A21'],6=>['Clean Water','#26BDE2'],
      7=>['Clean Energy','#FCC30B'],8=>['Decent Work','#A21942'],
      9=>['Innovation','#FD6925'],10=>['Inequalities','#DD1367'],
      11=>['Sustainable Cities','#FD9D24'],12=>['Consumption','#BF8B2E'],
      13=>['Climate Action','#3F7E44'],14=>['Life Below Water','#0A97D9'],
      15=>['Life on Land','#56C02B'],16=>['Peace & Justice','#00689D'],
      17=>['Partnerships','#19486A'],
    ];
    ?>
    <div class="sdg-tile-grid">
      <?php foreach ($sdgs as $n => $s):
        $nn = str_pad($n, 2, '0', STR_PAD_LEFT); ?>
      <a href="#sdg-<?= $n ?>" class="sdg-tile text-decoration-none" title="SDG <?= $n ?>: <?= $s[0] ?>">
        <img src="assets/img/sdg-<?= $nn ?>.png" alt="SDG <?= $n ?>"
             style="display:none"
             onload="this.style.display='block';this.nextElementSibling.style.display='none'"
             onerror="this.style.display='none';this.nextElementSibling.style.display='flex'">
        <div class="sdg-tile-fallback" style="display:flex;background:<?= $s[1] ?>;">
          <span class="tn"><?= $n ?></span>
          <span class="tl"><?= $s[0] ?></span>
        </div>
      </a>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- SDG CONTRIBUTIONS -->
<section class="sdg-contrib-section">
  <div class="container">
    <div class="row mb-5">
      <div class="col-lg-6">
        <span class="sec-label">Goal by Goal</span>
        <h2 class="mt-1">SJU's Contribution to Each Goal</h2>
      </div>
      <div class="col-lg-6 d-flex align-items-end">
        <p class="text-muted mb-0" style="font-size:.9rem;">How our teaching, research, and community work advances every one of the 17 SDGs.</p>
      </div>
    </div>
    <div class="row g-4">
      <?php
      $cards = [
        [1,'No Poverty','#E5243B','SJU provides need-based scholarships, freeship seats, and fee concessions ensuring higher education is accessible to students from economically weaker sections.',['Merit-cum-Means Scholarships','Government Schemes','BSW / MSW']],
        [2,'Zero Hunger','#DDA63A','The university runs a Mid-Day Meal programme for students in need, and Life Sciences engages in food-security research and urban-agriculture awareness drives.',['Mid-Day Meal Programme','Life Sciences Research','Urban Agriculture']],
        [3,'Good Health & Well-being','#4C9F38','A dedicated counselling centre, sports infrastructure, mental-health awareness campaigns, and NSS health camps extend well-being support beyond the classroom.',['Student Counselling','NSS Health Camps','Mental Health Week']],
        [4,'Quality Education','#C5192D','NAAC A+ accredited, SJU offers 60+ UG, PG, and PhD programmes aligned with NEP 2020, with industry-integrated curricula and experiential learning at its core.',['NAAC A+','NEP 2020','60+ Programmes','Open Electives']],
        [5,'Gender Equality','#FF3A21','The Equal Opportunity Cell, Gender Champions programme, and Women\'s Cell actively promote gender equity on campus and in surrounding communities.',['Equal Opportunity Cell','Women\'s Cell','Gender Champions']],
        [6,'Clean Water & Sanitation','#26BDE2','Rainwater harvesting systems across campus, water-audit programmes, and Environmental Science projects on watershed management and water-quality testing.',['Rainwater Harvesting','Water Audits','Environmental Science']],
        [7,'Affordable & Clean Energy','#FCC30B','Solar panels installed across campus buildings reduce the carbon footprint. Physics and Electronics departments conduct research on renewable energy systems.',['Solar Campus','Energy Audits','Physics Research']],
        [8,'Decent Work & Economic Growth','#A21942','The Career Development Centre places students across 200+ companies annually. Entrepreneurship Cell and SJRIC incubate student start-ups.',['Placement Cell','SJRIC Incubation','Entrepreneurship Cell']],
        [9,'Industry, Innovation & Infrastructure','#FD6925','State-of-the-art labs in Cyber Security, AI, Bioinformatics, and Data Analytics. MoUs with industry partners facilitate collaborative research and technology transfer.',['M.Sc. Cyber Security & AI','Industry MoUs','Research Centres']],
        [10,'Reduced Inequalities','#DD1367','Reservation policies, SC/ST/OBC scholarships, Shift III evening programmes for working students, and outreach to first-generation learners actively reduce access gaps.',['Shift III Programmes','SC/ST Scholarships','First-Gen Outreach']],
        [11,'Sustainable Cities & Communities','#FD9D24','Green-campus architecture, community outreach in Bengaluru neighbourhoods, and urban-studies modules in Social Work and Economics contribute to city sustainability.',['Green Campus','Urban Community Projects','NSS Outreach']],
        [12,'Responsible Consumption','#BF8B2E','Zero single-use plastic policy, segregated waste management, composting of food waste from the canteen, and annual sustainability audits across all departments.',['Plastic-Free Campus','Waste Segregation','Composting']],
        [13,'Climate Action','#3F7E44','SJU hosts a live Climate and World Clock, runs a dedicated M.Sc. in Environmental Science & Sustainability, and leads tree-planting drives and climate campaigns.',['Climate Clock','M.Sc. Environmental Science','Tree Plantation']],
        [14,'Life Below Water','#0A97D9','Zoology and Environmental Science research on freshwater biodiversity, student field studies in aquatic ecosystems, and awareness campaigns against water body pollution.',['Aquatic Biodiversity Research','Zoology Department','Field Studies']],
        [15,'Life on Land','#56C02B','A thriving botanical garden on campus, biodiversity audits, herbarium collections, and Botany & Zoology research programmes focused on native species conservation.',['Botanical Garden','Biodiversity Audit','Herbarium']],
        [16,'Peace, Justice & Strong Institutions','#00689D','Legal-awareness clinics, IQAC-driven institutional governance, anti-ragging and grievance redressal committees, and the Department of Journalism fostering media literacy.',['IQAC Governance','Grievance Cell','Journalism Dept']],
        [17,'Partnerships for the Goals','#19486A','Active MoUs with international universities, NGOs, government bodies, and industry partners globally. Member of ACU, Jesuit Worldwide Learning, and the NIRF framework.',['International MoUs','ACU Member','Jesuit Network']],
      ];
      foreach ($cards as $c):
        $nn = str_pad($c[0], 2, '0', STR_PAD_LEFT);
      ?>
      <div class="col-sm-6 col-lg-4" id="sdg-<?= $c[0] ?>">
        <div class="sdg-contrib-card">
          <div class="card-img-wrap">
            <img src="assets/img/sdg-<?= $nn ?>.png" alt="SDG <?= $c[0] ?>"
                 style="display:none"
                 onload="this.style.display='block';this.nextElementSibling.style.display='none'"
                 onerror="this.style.display='none';this.nextElementSibling.style.display='flex'">
            <div class="card-img-fallback" style="display:flex;background:<?= $c[2] ?>;">
              <span class="cn"><?= $c[0] ?></span>
              <span class="ct"><?= htmlspecialchars($c[1]) ?></span>
            </div>
          </div>
          <div class="card-body-inner">
            <span class="card-goal-num" style="background:<?= $c[2] ?>;">Goal <?= $c[0] ?></span>
            <h6><?= htmlspecialchars($c[1]) ?></h6>
            <p><?= htmlspecialchars($c[3]) ?></p>
            <div class="tags">
              <?php foreach ($c[4] as $tag): ?>
              <span class="tag"><?= htmlspecialchars($tag) ?></span>
              <?php endforeach; ?>
            </div>
          </div>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- FOUR PILLARS -->
<section class="sdg-pillars">
  <div class="container">
    <div class="text-center mb-5">
      <span style="font-size:.75rem;font-weight:700;letter-spacing:.14em;text-transform:uppercase;color:#1e40af;background:rgba(37,99,176,.09);padding:5px 14px;border-radius:20px;display:inline-block;">How We Work</span>
      <h2 style="font-size:1.8rem;font-weight:800;margin-top:12px;line-height:1.25;">
        <span style="background:linear-gradient(90deg,#2563b0,#15803d,#d97706,#7c3aed);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;">Four Pillars</span>
        <span style="color:#0f172a;"> of SDG Action</span>
      </h2>
    </div>
    <div class="pillar-row">
      <div class="pillar-item">
        <div class="pillar-accent" style="background:#2563b0;"></div>
        <span class="pillar-icon">ð</span>
        <h5>Curriculum</h5>
        <p>SDG themes woven into course objectives, open electives, and capstone projects across all schools and departments.</p>
      </div>
      <div class="pillar-item">
        <div class="pillar-accent" style="background:#16a34a;"></div>
        <span class="pillar-icon">ð¬</span>
        <h5>Research</h5>
        <p>Faculty and student research projects mapped to SDG targets, contributing to national and international policy discourse.</p>
      </div>
      <div class="pillar-item">
        <div class="pillar-accent" style="background:#d97706;"></div>
        <span class="pillar-icon">ð¤</span>
        <h5>Community</h5>
        <p>NSS, NCC, and extension units engage through health camps, legal aid, digital literacy, and skill-building programmes.</p>
      </div>
      <div class="pillar-item">
        <div class="pillar-accent" style="background:#7c3aed;"></div>
        <span class="pillar-icon">ð±</span>
        <h5>Campus Operations</h5>
        <p>Solar energy, water harvesting, zero-waste events, and annual sustainability reporting measure our environmental impact.</p>
      </div>
    </div>
  </div>
</section>

<!-- INITIATIVES -->
<section class="sdg-initiatives">
  <div class="container">
    <div class="row g-5 align-items-start">
      <div class="col-lg-4">
        <span style="font-size:.75rem;font-weight:700;letter-spacing:.14em;text-transform:uppercase;color:#2563b0;">In Action</span>
        <h2 style="font-size:1.8rem;font-weight:800;color:#0f172a;margin-top:8px;margin-bottom:16px;">Highlighted Initiatives</h2>
        <p class="text-muted" style="font-size:.9rem;">A snapshot of programmes and projects where SJU's SDG commitment comes to life on campus and in the community.</p>
        <img src="assets/img/sdg-wheel.png"
             alt="UN SDG Wheel" class="img-fluid rounded-3 mt-4" style="max-width:280px;opacity:.85;">
      </div>
      <div class="col-lg-8">
        <?php
        $initiatives = [
          ['Mid-Day Meal & Welfare Scheme', 'The campus Mid-Day Meal programme ensures no student goes hungry, complemented by direct financial assistance for students facing economic hardship.', ['#E5243B','SDG 1'],['#DDA63A','SDG 2']],
          ['NSS & NCC â Service Beyond the Campus', 'Over 500 students annually participate in NSS camps, blood donation drives, legal literacy workshops, and disaster relief activities in and around Bengaluru.', ['#4C9F38','SDG 3'],['#00689D','SDG 16']],
          ['Shift III â Evening Programmes for Working Learners', 'Dedicated evening-shift UG and PG programmes enabling working professionals, first-generation learners, and marginalised students to access quality education.', ['#C5192D','SDG 4'],['#DD1367','SDG 10']],
          ['SJRIC â Research & Innovation Centre', 'The SJU Research and Innovation Centre incubates student start-ups, facilitates industry-academia partnerships, and drives technology solutions aligned with societal needs.', ['#A21942','SDG 8'],['#FD6925','SDG 9']],
          ['Climate Clock & Sustainability Dashboard', 'SJU hosts a real-time Climate and World Clock visible to the entire university community, fostering daily awareness of climate urgency and action targets.', ['#3F7E44','SDG 13'],['#56C02B','SDG 15']],
          ['International Collaborations & Jesuit Network', 'Partnerships with universities across Europe, the USA, and Asia through the Jesuit network facilitate student exchange, joint research, and global SDG projects.', ['#19486A','SDG 17'],['#C5192D','SDG 4']],
        ];
        foreach ($initiatives as $init): ?>
        <div class="initiative-row">
          <div class="init-num" style="background:<?= $init[2][0] ?>;"><?= substr($init[2][1],-2) ?></div>
          <div>
            <div class="mb-1">
              <span class="sdg-mini-badge" style="background:<?= $init[2][0] ?>;"><?= $init[2][1] ?></span>
              <span class="sdg-mini-badge" style="background:<?= $init[3][0] ?>;"><?= $init[3][1] ?></span>
            </div>
            <h6><?= htmlspecialchars($init[0]) ?></h6>
            <p><?= htmlspecialchars($init[1]) ?></p>
          </div>
        </div>
        <?php endforeach; ?>
      </div>
    </div>
  </div>
</section>

<!-- CTA -->
<section class="sdg-cta-section">
  <div class="container">
    <div class="row align-items-center g-4">
      <div class="col-lg-7">
        <span style="font-size:.74rem;font-weight:700;letter-spacing:.14em;text-transform:uppercase;color:rgba(255,255,255,.45);">Join the Movement</span>
        <h2 class="mt-2">Be Part of SJU's<br>Sustainability Journey</h2>
        <p class="mt-2">Whether you are a student, researcher, faculty member, or community partner â there is a meaningful role for you in advancing the SDGs at St Joseph's University.</p>
      </div>
      <div class="col-lg-5 d-flex flex-column gap-3 align-items-start align-items-lg-end mt-2 mt-lg-0">
        <div class="d-flex gap-3 flex-wrap w-100 justify-content-lg-end">
          <a href="/admissions/admissions" class="btn-cta-primary">Apply Now â'</a>
          <a href="get-involved.php" class="btn-cta-ghost">Get Involved</a>
        </div>
        <a href="/about/contact-us" class="btn-cta-ghost align-self-stretch align-self-lg-auto text-center text-lg-start">Contact Us</a>
      </div>
    </div>
  </div>
</section>

<?php require_once '../footer.php'; ?>

<script>
document.querySelectorAll('a[href^="#sdg-"]').forEach(function(a) {
  a.addEventListener('click', function(e) {
    var target = document.querySelector(this.getAttribute('href'));
    if (target) {
      e.preventDefault();
      target.scrollIntoView({ behavior: 'smooth', block: 'center' });
      target.style.outline = '3px solid #2563b0';
      target.style.outlineOffset = '4px';
      target.style.borderRadius = '16px';
      setTimeout(function(){ target.style.outline = ''; target.style.outlineOffset = ''; }, 1800);
    }
  });
});
</script>
</body>
</html>
