<?php require_once '_shared.php'; ?>
<!doctype html>
<html lang="en" dir="ltr">
<head>
  <?php include $_SERVER['DOCUMENT_ROOT'] . '/gtm.php'; ?>
  <meta charset="utf-8">
  <title>SDG Initiatives | St Joseph's University, Bengaluru</title>
  <meta name="description" content="Programmes, campus initiatives, and community projects at St Joseph's University, Bengaluru that directly advance the UN Sustainable Development Goals.">
  <meta name="keywords" content="SDG initiatives, NSS, NCC, sustainability programmes, St Joseph's University">
  <meta name="robots" content="index, follow">
  <link rel="canonical" href="https://www.sju.edu.in/sdg/initiatives">
  <meta property="og:title" content="SDG Initiatives | St Joseph's University">
  <meta property="og:description" content="Key programmes and initiatives at SJU advancing the UN 2030 Agenda.">
  <meta property="og:url" content="https://www.sju.edu.in/sdg/initiatives">
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
.init-hero { background:linear-gradient(135deg,#0f4c75 0%,#1b6ca8 100%); padding:56px 0 44px; color:#fff; }
.init-hero h1 { font-size:2rem; font-weight:800; }

.init-card {
  border-radius:16px; overflow:hidden; height:100%;
  border:1.5px solid #e2e8f0; background:#fff;
  transition:box-shadow .2s, border-color .2s;
  display:flex; flex-direction:column;
}
.init-card:hover { box-shadow:0 8px 32px rgba(0,0,0,.1); border-color:#2563b0; }
.init-card-head { padding:22px 22px 14px; color:#fff; }
.init-card-head .init-icon { font-size:2rem; margin-bottom:8px; display:block; }
.init-card-head h5 { font-size:.95rem; font-weight:700; margin:0; line-height:1.35; }
.init-card-body { padding:18px 22px 20px; flex:1; font-size:.88rem; color:#475569; line-height:1.65; }
.init-card-footer { padding:12px 22px 18px; }

.category-head {
  display:flex; align-items:center; gap:12px;
  border-bottom:2px solid #e2e8f0; padding-bottom:14px; margin-bottom:32px;
}
.category-head .cat-icon { font-size:1.8rem; }
.category-head h2 { font-size:1.35rem; font-weight:800; color:#1a3c6e; margin:0; }

.stat-strip { background:linear-gradient(135deg,#1a3c6e 0%,#2563b0 100%); padding:48px 0; color:#fff; }
.stat-item { text-align:center; }
.stat-item .sn { font-size:2.6rem; font-weight:900; line-height:1; color:#fbbf24; }
.stat-item .sl { font-size:.78rem; text-transform:uppercase; letter-spacing:.06em; opacity:.8; margin-top:4px; }
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
      "name": "Initiatives",
      "item": "https://www.sju.edu.in/sdg/initiatives"
    }
  ]
}
</script>
</head>
<body>
<?php require_once '../header.php'; ?>
<?php include '_nav.php'; ?>

<section class="breadcrumb-hero text-white">
  <div class="overlay"></div>
  <div class="container">
    <div class="breadcrumb-content text-center">
      <h1 class="page-title mb-2">Initiatives</h1>
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb justify-content-center mb-0">
          <li class="breadcrumb-item"><a href="/" class="text-white text-decoration-none">Home</a></li>
          <li class="breadcrumb-item"><a href="index.php" class="text-white text-decoration-none">SDGs</a></li>
          <li class="breadcrumb-item active text-warning" aria-current="page">Initiatives</li>
        </ol>
      </nav>
    </div>
  </div>
</section>

<section class="init-hero">
  <div class="container">
    <p class="text-uppercase fw-bold mb-2" style="letter-spacing:.1em;opacity:.65;font-size:.78rem;">Action on Campus &amp; Beyond</p>
    <h1>SDG Initiatives at SJU</h1>
    <p class="mt-2" style="opacity:.85;max-width:640px;">From solar-powered buildings to international research partnerships, St Joseph's University translates SDG commitments into tangible action across four domains.</p>
  </div>
</section>

<!-- STATS STRIP -->
<div class="stat-strip">
  <div class="container">
    <div class="row g-4 text-center">
      <div class="col-6 col-md-3"><div class="stat-item"><div class="sn">500+</div><div class="sl">NSS Student Volunteers</div></div></div>
      <div class="col-6 col-md-3"><div class="stat-item"><div class="sn">200+</div><div class="sl">Industry Placements/yr</div></div></div>
      <div class="col-6 col-md-3"><div class="stat-item"><div class="sn">30+</div><div class="sl">Community Projects</div></div></div>
      <div class="col-6 col-md-3"><div class="stat-item"><div class="sn">50+</div><div class="sl">MoU Partners</div></div></div>
    </div>
  </div>
</div>

<!-- CAMPUS SUSTAINABILITY -->
<section class="py-5" style="background:#f8fafc;">
  <div class="container">
    <div class="category-head">
      <span class="cat-icon">ð±</span>
      <h2>Campus Sustainability</h2>
    </div>
    <div class="row g-4">
      <?php
      $campus = [
        ['Solar Campus', 'var(--sdg7)', '#fef9c3', 'âï¸', 'SDG 7', 'Solar panels installed on major campus buildings reduce grid dependence and serve as live teaching tools for renewable energy education.', ['SDG 7','SDG 13']],
        ['Rainwater Harvesting', 'var(--sdg6)', '#e0f2fe', 'ð'§', 'SDG 6', 'Multiple rainwater harvesting pits and tank systems across the campus conserve water and reduce run-off, supplementing the campus water supply.', ['SDG 6','SDG 11']],
        ['Plastic-Free Campus', 'var(--sdg12)', '#fef3c7', 'â»ï¸', 'SDG 12', 'A strict no-single-use-plastic policy, biodegradable cutlery at the canteen, and annual waste audits drive responsible consumption on campus.', ['SDG 12','SDG 14']],
        ['Botanical Garden &amp; Herbarium', 'var(--sdg15)', '#dcfce7', 'ð¿', 'SDG 15', 'A maintained botanical garden, active herbarium, and biodiversity audits support native-species conservation and serve as open-air classrooms for life-sciences students.', ['SDG 15','SDG 4']],
        ['Climate Clock', 'var(--sdg13)', '#d1fae5', 'ð', 'SDG 13', 'A live Climate and World Clock displayed on campus creates continuous awareness of climate-change timelines and motivates the university community to act.', ['SDG 13']],
        ['Zero-Waste Events', 'var(--sdg12)', '#fef9c3', 'ðï¸', 'SDG 12', 'All major university events follow a zero-waste protocol: pre-event planning, on-site segregation stations, and post-event sustainability reports.', ['SDG 12','SDG 17']],
      ];
      foreach ($campus as $item): ?>
      <div class="col-sm-6 col-lg-4">
        <div class="init-card">
          <div class="init-card-head" style="background:<?= $item[1] ?>;">
            <span class="init-icon"><?= $item[4] ?></span>
            <h5><?= $item[0] ?></h5>
          </div>
          <div class="init-card-body">
            <p><?= $item[5] ?></p>
          </div>
          <div class="init-card-footer">
            <?php foreach ($item[6] as $badge): ?>
            <span class="sdg-pill-tag"><?= $badge ?></span>
            <?php endforeach; ?>
          </div>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- SOCIAL OUTREACH -->
<section class="py-5">
  <div class="container">
    <div class="category-head">
      <span class="cat-icon">ð¤</span>
      <h2>Social Outreach &amp; Welfare</h2>
    </div>
    <div class="row g-4">
      <?php
      $social = [
        ['NSS Camps &amp; Community Service', 'var(--sdg3)', 'â¤ï¸', 'Over 500 NSS students participate annually in health camps, blood donation drives, legal literacy workshops, and disaster-relief activities in Bengaluru and surrounding villages.', ['SDG 3','SDG 16','SDG 11']],
        ['Mid-Day Meal &amp; Student Welfare', 'var(--sdg1)', 'ð½ï¸', 'The campus Mid-Day Meal programme ensures no enrolled student goes hungry. It is complemented by direct financial assistance and in-kind support for students facing economic hardship.', ['SDG 1','SDG 2']],
        ['Shift III â Evening Programmes', 'var(--sdg4)', 'ð', 'Dedicated evening-shift UG and PG programmes empower working professionals, first-generation learners, and marginalised students to access quality education without leaving their livelihoods.', ['SDG 4','SDG 10','SDG 8']],
        ['SC/ST/OBC Scholarships &amp; Outreach', 'var(--sdg10)', 'ð«', 'Reserved seats, government scholarships, and dedicated first-generation-learner outreach programmes actively reduce access gaps in higher education across caste and community lines.', ['SDG 10','SDG 1','SDG 4']],
        ['Legal Aid &amp; Awareness Clinics', 'var(--sdg16)', 'âï¸', 'The Department of Law and Commerce, in partnership with NGOs, conducts community legal-awareness workshops, RTI clinics, and voter-literacy drives in urban and peri-urban areas.', ['SDG 16','SDG 10']],
        ['Gender Champions Programme', 'var(--sdg5)', 'â§ï¸', 'Trained student Gender Champions lead peer education on consent, gender-based violence, and equality. The programme feeds into institutional policy and curriculum through the Women\'s Cell and Equal Opportunity Cell.', ['SDG 5','SDG 10','SDG 16']],
      ];
      foreach ($social as $item): ?>
      <div class="col-sm-6 col-lg-4">
        <div class="init-card">
          <div class="init-card-head" style="background:<?= $item[1] ?>;">
            <span class="init-icon"><?= $item[2] ?></span>
            <h5><?= $item[0] ?></h5>
          </div>
          <div class="init-card-body">
            <p><?= $item[3] ?></p>
          </div>
          <div class="init-card-footer">
            <?php foreach ($item[4] as $badge): ?>
            <span class="sdg-pill-tag"><?= $badge ?></span>
            <?php endforeach; ?>
          </div>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- ACADEMIC PROGRAMMES -->
<section class="py-5" style="background:#f8fafc;">
  <div class="container">
    <div class="category-head">
      <span class="cat-icon">ð</span>
      <h2>SDG-Linked Academic Programmes</h2>
    </div>
    <div class="row g-4">
      <?php
      $progs = [
        ['M.Sc. Environmental Science &amp; Sustainability', 'var(--sdg13)', 'ð', 'A flagship postgraduate programme that trains environmental scientists to address climate change, biodiversity loss, pollution, and natural-resource management â directly aligned with SDGs 13, 14, and 15.', ['SDG 13','SDG 14','SDG 15']],
        ['M.Sc. Cyber Security &amp; Artificial Intelligence', 'var(--sdg9)', 'ð', 'Prepares graduates to secure digital infrastructure and develop AI solutions, contributing to innovation ecosystems and safe digital societies in line with SDG 9 and SDG 16.', ['SDG 9','SDG 16','SDG 8']],
        ['BSW &amp; MSW â Social Work', 'var(--sdg1)', 'ðï¸', 'Social Work programmes train grassroots change-makers in community development, welfare law, and public health â building the human capital needed to drive progress on SDGs 1 through 10.', ['SDG 1','SDG 3','SDG 10']],
        ['B.Sc./M.Sc. Life Sciences &amp; Bioinformatics', 'var(--sdg3)', 'ð§¬', 'Programmes in Microbiology, Biotechnology, Biochemistry, and Bioinformatics feed directly into SDG 3 (health), SDG 2 (food security), and SDG 9 (innovation) through frontier research and industry linkages.', ['SDG 3','SDG 2','SDG 9']],
        ['M.Sc. Data Analytics', 'var(--sdg9)', 'ð', 'Combines statistical methods and machine-learning tools to produce data professionals who can generate evidence for evidence-based policy across all 17 SDGs.', ['SDG 9','SDG 17','SDG 8']],
        ['Open Electives &amp; NEP 2020 Integration', 'var(--sdg4)', 'ð', 'Under NEP 2020, SJU offers open electives in Sustainability, Human Rights, Environmental Ethics, and Development Economics â ensuring SDG literacy reaches students across all disciplines.', ['SDG 4','SDG 10','SDG 16']],
      ];
      foreach ($progs as $item): ?>
      <div class="col-sm-6 col-lg-4">
        <div class="init-card">
          <div class="init-card-head" style="background:<?= $item[1] ?>;">
            <span class="init-icon"><?= $item[2] ?></span>
            <h5><?= $item[0] ?></h5>
          </div>
          <div class="init-card-body">
            <p><?= $item[3] ?></p>
          </div>
          <div class="init-card-footer">
            <?php foreach ($item[4] as $badge): ?>
            <span class="sdg-pill-tag"><?= $badge ?></span>
            <?php endforeach; ?>
          </div>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- INDUSTRY & PARTNERSHIPS -->
<section class="py-5">
  <div class="container">
    <div class="category-head">
      <span class="cat-icon">ð</span>
      <h2>Partnerships &amp; Collaborations</h2>
    </div>
    <div class="row g-4">
      <?php
      $partners = [
        ['SJRIC â Research &amp; Innovation Centre', 'var(--sdg9)', 'ð', 'The SJU Research and Innovation Centre incubates student start-ups, runs hackathons, and bridges academia with industry to deliver technology solutions aligned with SDGs 8 and 9.', ['SDG 9','SDG 8','SDG 17']],
        ['Jesuit Worldwide Learning', 'var(--sdg17)', 'âï¸', 'As part of the global Jesuit academic network, SJU collaborates with Jesuit universities across Europe, the Americas, and Asia on joint research, student exchange, and SDG-focused projects.', ['SDG 17','SDG 4','SDG 10']],
        ['ACU Membership', 'var(--sdg17)', 'ðï¸', 'Membership of the Association of Commonwealth Universities enables SJU to access global best practices in sustainability, governance, and inclusive education across the Commonwealth.', ['SDG 17','SDG 4','SDG 16']],
        ['THE Impact Rankings', 'var(--sdg17)', 'ð', 'SJU reports SDG performance through the Times Higher Education Impact Rankings framework, enabling transparent benchmarking against global peers and accountability to stakeholders.', ['SDG 17','SDG 4','SDG 16']],
        ['Government &amp; NGO MoUs', 'var(--sdg16)', 'ð¤', 'MoUs with government departments (BBMP, health agencies, DPAR) and NGOs facilitate community-health outreach, digital literacy, and infrastructure development aligned with multiple SDGs.', ['SDG 16','SDG 3','SDG 11']],
        ['International University Exchange', 'var(--sdg4)', 'âï¸', 'Active student and faculty exchange programmes with universities in Germany, France, Spain, Australia, and the USA expose the SJU community to diverse sustainability practices and global SDG strategies.', ['SDG 4','SDG 17','SDG 10']],
      ];
      foreach ($partners as $item): ?>
      <div class="col-sm-6 col-lg-4">
        <div class="init-card">
          <div class="init-card-head" style="background:<?= $item[1] ?>;">
            <span class="init-icon"><?= $item[2] ?></span>
            <h5><?= $item[0] ?></h5>
          </div>
          <div class="init-card-body">
            <p><?= $item[3] ?></p>
          </div>
          <div class="init-card-footer">
            <?php foreach ($item[4] as $badge): ?>
            <span class="sdg-pill-tag"><?= $badge ?></span>
            <?php endforeach; ?>
          </div>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- CTA -->
<section style="background:linear-gradient(135deg,#1a3c6e 0%,#2563b0 100%);padding:56px 0;color:#fff;">
  <div class="container text-center">
    <h2 style="font-size:1.7rem;font-weight:800;">Want to Start Your Own Initiative?</h2>
    <p style="opacity:.85;max-width:520px;margin:10px auto 0;">Students and faculty can pitch SDG-aligned project ideas through the NSS office or the Entrepreneurship Cell.</p>
    <div class="d-flex justify-content-center gap-3 mt-4 flex-wrap">
      <a href="get-involved.php" style="background:#fff;color:#1a3c6e;border-radius:10px;font-weight:700;padding:12px 28px;text-decoration:none;">Get Involved â'</a>
      <a href="research.php" style="background:transparent;color:#fff;border:2px solid rgba(255,255,255,.6);border-radius:10px;font-weight:700;padding:11px 28px;text-decoration:none;">View Research</a>
    </div>
  </div>
</section>

<?php require_once '../footer.php'; ?>
</body>
</html>
