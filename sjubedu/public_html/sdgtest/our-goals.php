<?php
require_once '_shared.php';
?>
<!doctype html>
<html lang="en" dir="ltr">
<head>
  <?php include $_SERVER['DOCUMENT_ROOT'] . '/gtm.php'; ?>
  <meta charset="utf-8">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <title>Our 17 Goals | SDGs | St Joseph's University, Bengaluru</title>
  <meta name="description" content="Explore how St Joseph's University, Bengaluru contributes to all 17 UN Sustainable Development Goals through education, research, and community action.">
  <meta name="keywords" content="SDG goals, St Joseph's University, sustainability, UN 2030, SDG contributions">
  <meta name="robots" content="index, follow">
  <link rel="canonical" href="https://www.sju.edu.in/sdg/our-goals">
  <meta property="og:title" content="Our SDG Goals | St Joseph's University, Bengaluru">
  <meta property="og:description" content="SJU's contributions to all 17 UN Sustainable Development Goals — a goal-by-goal breakdown.">
  <meta property="og:url" content="https://www.sju.edu.in/sdg/our-goals">
  <meta property="og:type" content="website">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="icon" href="../assets/img/favicon.png" type="image/png">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,200..800;1,200..800&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
  <link rel="stylesheet" href="../../assets/css/bootstrap.min.css">
  <link rel="stylesheet" href="../../assets/css/fontawesome.min.css">
  <link rel="stylesheet" href="../../assets/css/style.css?v=2.3">
  <?php sdg_head_css(); ?>
<style>
.goals-hero { background: linear-gradient(135deg,#1a3c6e 0%,#2563b0 100%); padding:56px 0 44px; color:#fff; }
.goals-hero h1 { font-size:2rem; font-weight:800; }
.goals-hero p { opacity:.85; max-width:640px; }

.goal-block { padding:56px 0; border-bottom:1px solid #e2e8f0; }
.goal-block:nth-child(even) { background:#f8fafc; }
.goal-logo-wrap { position:relative; width:140px; height:140px; border-radius:16px; overflow:hidden; flex-shrink:0; }
.goal-logo-wrap img { width:100%; height:100%; object-fit:cover; border-radius:16px; }
.goal-logo-fallback {
  width:140px; height:140px; border-radius:16px; color:#fff;
  display:flex; flex-direction:column; align-items:center; justify-content:center;
  font-size:2rem; text-align:center; padding:8px;
}
.goal-logo-fallback .fn { font-size:2.8rem; font-weight:900; line-height:1; opacity:.4; }
.goal-logo-fallback .ft { font-size:.65rem; font-weight:700; text-transform:uppercase; letter-spacing:.04em; line-height:1.25; margin-top:4px; }
.goal-title { font-weight:800; font-size:1.3rem; color:#1a3c6e; margin-bottom:4px; }
.goal-num-badge { font-size:.72rem; font-weight:700; padding:2px 10px; border-radius:20px; color:#fff; display:inline-block; margin-bottom:8px; }
.goal-short { font-size:.92rem; color:#475569; font-style:italic; margin-bottom:12px; }
.goal-detail { font-size:.91rem; color:#334155; line-height:1.7; }

@media (max-width:575px){
  .goal-logo-wrap, .goal-logo-fallback { width:90px; height:90px; }
  .goal-logo-fallback .fn { font-size:1.8rem; }
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
      "name": "SDGs",
      "item": "https://www.sju.edu.in/sdg/index"
    },
    {
      "@type": "ListItem",
      "position": 3,
      "name": "Our Goals",
      "item": "https://www.sju.edu.in/sdg/our-goals"
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
      <h1 class="page-title mb-2">Our 17 Goals</h1>
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb justify-content-center mb-0">
          <li class="breadcrumb-item"><a href="/" class="text-white text-decoration-none">Home</a></li>
          <li class="breadcrumb-item"><a href="index.php" class="text-white text-decoration-none">SDGs</a></li>
          <li class="breadcrumb-item active text-warning" aria-current="page">Our Goals</li>
        </ol>
      </nav>
    </div>
  </div>
</section>

<!-- HERO INTRO -->
<section class="goals-hero">
  <div class="container">
    <p class="text-uppercase fw-bold mb-2" style="letter-spacing:.1em;opacity:.65;font-size:.78rem;">Goal-by-Goal Breakdown</p>
    <h1>SJU's Contribution to Every SDG</h1>
    <p class="mt-2">A detailed look at how St Joseph's University, Bengaluru embeds each of the 17 United Nations Sustainable Development Goals into its teaching, research, operations, and community engagement.</p>
    <!-- Quick-jump pills -->
    <div class="d-flex flex-wrap gap-2 mt-4">
      <?php foreach ($SDG as $n => $g): ?>
      <a href="#goal-<?= $n ?>" class="text-decoration-none" style="background:<?= $g['color'] ?>;color:#fff;padding:4px 12px;border-radius:20px;font-size:.72rem;font-weight:700;"><?= $n ?></a>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- GOALS -->
<?php foreach ($SDG as $n => $g):
  $c = $SJU_CONTRIB[$n];
  $nn = str_pad($n, 2, '0', STR_PAD_LEFT);
?>
<section class="goal-block" id="goal-<?= $n ?>">
  <div class="container">
    <div class="d-flex flex-column flex-sm-row gap-4 align-items-start">
      <!-- Logo -->
      <div class="flex-shrink-0">
        <div class="goal-logo-wrap">
          <img src="assets/img/sdg-<?= $nn ?>.png" alt="SDG <?= $n ?>"
               style="display:none"
               onload="this.style.display='block';this.nextElementSibling.style.display='none'"
               onerror="this.style.display='none';this.nextElementSibling.style.display='flex'">
          <div class="goal-logo-fallback" style="display:flex;background:<?= $g['color'] ?>;">
            <span class="fn"><?= $n ?></span>
            <span class="ft"><?= htmlspecialchars($g['title']) ?></span>
          </div>
        </div>
      </div>
      <!-- Content -->
      <div class="flex-grow-1">
        <span class="goal-num-badge" style="background:<?= $g['color'] ?>;">Goal <?= $n ?></span>
        <h2 class="goal-title"><?= htmlspecialchars($g['title']) ?></h2>
        <p class="goal-short"><?= htmlspecialchars($g['short']) ?></p>
        <p class="goal-detail"><?= htmlspecialchars($g['detail'] ?? $c['detail']) ?></p>
        <div class="mt-3">
          <?php foreach ($c['tags'] as $tag): ?>
          <span class="sdg-pill-tag"><?= htmlspecialchars($tag) ?></span>
          <?php endforeach; ?>
        </div>
      </div>
    </div>
  </div>
</section>
<?php endforeach; ?>

<!-- BACK TO TOP -->
<div class="text-center py-5" style="background:#f8fafc;">
  <a href="#" class="btn btn-outline-primary rounded-pill px-4">
    <i class="bi bi-arrow-up-circle me-1"></i> Back to Top
  </a>
  <a href="index.php" class="btn btn-primary rounded-pill px-4 ms-2">
    <i class="bi bi-house me-1"></i> SDG Overview
  </a>
</div>

<?php require_once '../footer.php'; ?>
</body>
</html>
