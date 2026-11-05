<?php require_once '_shared.php'; ?>
<!doctype html>
<html lang="en" dir="ltr">
<head>
  <?php include $_SERVER['DOCUMENT_ROOT'] . '/gtm.php'; ?>
  <meta charset="utf-8">
  <title>SDG Research | St Joseph's University, Bengaluru</title>
  <meta name="description" content="Faculty and student research at St Joseph's University aligned with the UN Sustainable Development Goals â from climate science to social equity.">
  <meta name="keywords" content="SDG research, sustainability research, St Joseph's University, faculty research, student projects">
  <meta name="robots" content="index, follow">
  <link rel="canonical" href="https://www.sju.edu.in/sdg/research">
  <meta property="og:title" content="SDG Research | St Joseph's University, Bengaluru">
  <meta property="og:description" content="Research at SJU mapped to the 17 UN Sustainable Development Goals.">
  <meta property="og:url" content="https://www.sju.edu.in/sdg/research">
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
.res-hero { background:linear-gradient(135deg,#064e3b 0%,#065f46 50%,#047857 100%); padding:56px 0 44px; color:#fff; }
.res-hero h1 { font-size:2rem; font-weight:800; }

.res-area-card {
  border-radius:16px; border:1.5px solid #e2e8f0; background:#fff;
  padding:28px 26px; height:100%;
  transition:box-shadow .2s, border-color .2s;
}
.res-area-card:hover { box-shadow:0 8px 28px rgba(0,0,0,.1); border-color:#2563b0; }
.res-area-icon { font-size:2.2rem; margin-bottom:14px; display:block; }
.res-area-card h5 { font-weight:800; color:#1a3c6e; font-size:1rem; margin-bottom:8px; }
.res-area-card p { font-size:.88rem; color:#475569; line-height:1.65; }

.dept-row { border-bottom:1px solid #f1f5f9; padding:24px 0; }
.dept-row:last-child { border-bottom:none; }
.dept-name { font-weight:700; color:#1a3c6e; font-size:.95rem; }
.dept-desc { font-size:.87rem; color:#475569; margin-top:4px; line-height:1.6; }

.project-card {
  border-radius:12px; background:#f8fafc; border-left:4px solid;
  padding:18px 20px; margin-bottom:16px;
}
.project-card h6 { font-weight:700; color:#1a3c6e; font-size:.9rem; margin-bottom:4px; }
.project-card p { font-size:.84rem; color:#475569; margin:0; line-height:1.55; }
.project-card .proj-meta { font-size:.76rem; color:#94a3b8; margin-top:6px; }
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
      "name": "Research",
      "item": "https://www.sju.edu.in/sdg/research"
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
      <h1 class="page-title mb-2">Research</h1>
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb justify-content-center mb-0">
          <li class="breadcrumb-item"><a href="/" class="text-white text-decoration-none">Home</a></li>
          <li class="breadcrumb-item"><a href="index.php" class="text-white text-decoration-none">SDGs</a></li>
          <li class="breadcrumb-item active text-warning" aria-current="page">Research</li>
        </ol>
      </nav>
    </div>
  </div>
</section>

<section class="res-hero">
  <div class="container">
    <p class="text-uppercase fw-bold mb-2" style="letter-spacing:.1em;opacity:.65;font-size:.78rem;">Evidence for a Sustainable World</p>
    <h1>SDG-Aligned Research at SJU</h1>
    <p class="mt-2" style="opacity:.85;max-width:640px;">Faculty and student research projects at St Joseph's University generate knowledge that directly informs policy, practice, and innovation across the 2030 Agenda â from Bengaluru to the globe.</p>
  </div>
</section>

<!-- RESEARCH CLUSTERS -->
<section class="py-5" style="background:#f8fafc;">
  <div class="container">
    <div class="text-center mb-5">
      <div style="width:48px;height:4px;background:#2563b0;border-radius:2px;margin:0 auto 14px;"></div>
      <h2 style="font-size:1.6rem;font-weight:800;color:#1a3c6e;">Research Clusters</h2>
      <p class="text-muted mt-2" style="max-width:580px;margin:0 auto;">Six thematic clusters organise SJU's SDG research activity, enabling cross-disciplinary collaboration and maximising societal impact.</p>
    </div>
    <div class="row g-4">
      <?php
      $clusters = [
        ['ð¿','Environment &amp; Climate', 'var(--sdg13)', 'Botany, Zoology, Environmental Science, and Chemistry departments collaborate on air quality, biodiversity, freshwater ecology, urban heat islands, and climate-adaptation research in South India.', ['SDG 13','SDG 14','SDG 15','SDG 6']],
        ['ð§¬','Life Sciences &amp; Health', 'var(--sdg3)', 'Microbiology, Biotechnology, Biochemistry, and Bioinformatics programmes conduct research on antimicrobial resistance, plant-based medicine, disease genomics, and public-health data analytics.', ['SDG 3','SDG 2','SDG 9']],
        ['ð'¡','Technology &amp; Innovation', 'var(--sdg9)', 'Computer Science, Cyber Security, AI, Electronics, and Physics departments develop solutions in IoT, smart energy grids, cybersecurity frameworks, and data-driven sustainability monitoring.', ['SDG 9','SDG 7','SDG 11']],
        ['ðï¸','Society &amp; Welfare', 'var(--sdg1)', 'Social Work, Sociology, Economics, and Political Science faculty examine poverty, migration, urban livelihoods, social exclusion, and the effectiveness of welfare-delivery systems.', ['SDG 1','SDG 10','SDG 11','SDG 16']],
        ['ð','Education &amp; Equity', 'var(--sdg4)', 'Education, Psychology, and Humanities departments research pedagogy, access barriers, gender disparities in learning, and the impact of NEP 2020 on educational outcomes.', ['SDG 4','SDG 5','SDG 10']],
        ['ð','Governance &amp; Ethics', 'var(--sdg16)', 'Law, Journalism, Political Science, and Philosophy departments examine transparency, rule of law, media freedom, human rights, and ethical dimensions of technology and business.', ['SDG 16','SDG 17','SDG 5']],
      ];
      foreach ($clusters as $c): ?>
      <div class="col-sm-6 col-lg-4">
        <div class="res-area-card">
          <span class="res-area-icon"><?= $c[0] ?></span>
          <h5><?= $c[1] ?></h5>
          <p><?= $c[3] ?></p>
          <div class="mt-3">
            <?php foreach ($c[4] as $b): ?>
            <span class="sdg-pill-tag"><?= $b ?></span>
            <?php endforeach; ?>
          </div>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- DEPARTMENTS & SDG MAPPING -->
<section class="py-5">
  <div class="container">
    <div class="text-center mb-5">
      <div style="width:48px;height:4px;background:#2563b0;border-radius:2px;margin:0 auto 14px;"></div>
      <h2 style="font-size:1.6rem;font-weight:800;color:#1a3c6e;">Department-wise SDG Contributions</h2>
    </div>
    <div class="row g-5">
      <div class="col-lg-6">
        <?php
        $depts_left = [
          ['Department of Environmental Science','SDG 13 Â· 14 Â· 15','Research on urban biodiversity, freshwater ecology, green building assessment, and climate-change education programmes for school and college students.'],
          ['Department of Microbiology','SDG 3 Â· 2 Â· 9','Studies on antimicrobial peptides, probiotic food formulations, waste-water treatment microbiomes, and bioremediation of industrial effluents.'],
          ['Department of Computer Science &amp; Engineering','SDG 9 Â· 8 Â· 11','Projects on AI-driven traffic management, smart-city dashboards, automated waste-classification systems, and blockchain-based supply-chain transparency.'],
          ['Department of Social Work (BSW/MSW)','SDG 1 Â· 3 Â· 10 Â· 16','Field-based action research with urban slum communities, tribal villages, and domestic-violence survivors. Student dissertations mapped to SDG targets.'],
          ['Department of Economics','SDG 8 Â· 1 Â· 10','Research on informal labour markets, micro-finance efficacy, GST impact on MSMEs, and urban poverty concentration in Bengaluru.'],
        ];
        foreach ($depts_left as $d): ?>
        <div class="dept-row">
          <div class="dept-name"><?= $d[0] ?></div>
          <div style="font-size:.74rem;color:#2563b0;font-weight:700;margin:3px 0 4px;"><?= $d[1] ?></div>
          <div class="dept-desc"><?= $d[2] ?></div>
        </div>
        <?php endforeach; ?>
      </div>
      <div class="col-lg-6">
        <?php
        $depts_right = [
          ['Department of Botany &amp; Life Sciences','SDG 15 Â· 2 Â· 14','Herbarium management, ethnobotany, plant tissue culture for conservation, aquatic plant ecology, and medicinal plant research with local communities.'],
          ['Department of Physics &amp; Electronics','SDG 7 Â· 9 Â· 11','Solar energy system design, smart-meter prototyping, photovoltaic efficiency studies, and low-cost environmental monitoring sensor development.'],
          ['Department of Journalism &amp; Mass Communication','SDG 16 Â· 10 Â· 5','Research on media plurality, misinformation dynamics, digital divide, representation of marginalised groups in Indian journalism, and media ethics.'],
          ['Department of Chemistry','SDG 6 Â· 3 Â· 12','Water-quality analysis of Bengaluru lakes, green-synthesis of nanoparticles, bioplastics development, and pollution-remediation chemistry.'],
          ['Department of Zoology','SDG 14 Â· 15 Â· 3','Freshwater biodiversity assessments, urban avifauna surveys, herpetology research, and One Health studies linking animal and human-health outcomes.'],
        ];
        foreach ($depts_right as $d): ?>
        <div class="dept-row">
          <div class="dept-name"><?= $d[0] ?></div>
          <div style="font-size:.74rem;color:#2563b0;font-weight:700;margin:3px 0 4px;"><?= $d[1] ?></div>
          <div class="dept-desc"><?= $d[2] ?></div>
        </div>
        <?php endforeach; ?>
      </div>
    </div>
  </div>
</section>

<!-- STUDENT RESEARCH PROJECTS -->
<section class="py-5" style="background:#f8fafc;">
  <div class="container">
    <div class="text-center mb-5">
      <div style="width:48px;height:4px;background:#2563b0;border-radius:2px;margin:0 auto 14px;"></div>
      <h2 style="font-size:1.6rem;font-weight:800;color:#1a3c6e;">Featured Student Projects</h2>
      <p class="text-muted mt-2" style="max-width:580px;margin:0 auto;">A sample of recent student dissertations and capstone projects directly mapped to SDG targets.</p>
    </div>
    <div class="row g-4">
      <?php
      $projects = [
        ['Assessment of Heavy Metals in Bellandur Lake', '#0A97D9', 'SDG 6 Â· 14', 'M.Sc. Environmental Science â field study analysing heavy-metal concentrations in Bengaluru\'s Bellandur Lake, providing data for restoration advocacy.'],
        ['AI-Powered Sign Language Interpreter', '#FD6925', 'SDG 4 Â· 10', 'B.Sc. AI & ML final project â a real-time sign-language-to-text interpreter using CNNs, improving educational accessibility for the hearing-impaired.'],
        ['Urban Poverty and Food Insecurity in North Bengaluru', '#E5243B', 'SDG 1 Â· 2', 'MSW dissertation examining food-insecurity patterns among migrant construction workers in north Bengaluru and evaluating government intervention effectiveness.'],
        ['Probiotic Fermentation of Local Millets for Food Security', '#DDA63A', 'SDG 2 Â· 3', 'M.Sc. Microbiology â developing probiotic millet-based food products from locally available varieties to address nutritional deficiency in rural Karnataka.'],
        ['Solar-Powered IoT Water-Quality Monitoring', '#FCC30B', 'SDG 6 Â· 7 Â· 9', 'B.Sc. Electronics project â low-cost IoT sensor nodes powered by mini solar panels that transmit real-time water-quality data from community bore-wells.'],
        ['Gender Representation in Kannada Print Media', '#DD1367', 'SDG 5 Â· 16', 'M.A. Journalism dissertation performing quantitative content analysis of women\'s representation and agency in six Kannada daily newspapers over ten years.'],
      ];
      foreach ($projects as $p): ?>
      <div class="col-sm-6 col-lg-4">
        <div class="project-card" style="border-color:<?= $p[1] ?>;">
          <h6><?= $p[0] ?></h6>
          <div class="proj-meta"><?= $p[2] ?></div>
          <p><?= $p[3] ?></p>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- PUBLISH & COLLABORATE -->
<section style="background:linear-gradient(135deg,#064e3b 0%,#047857 100%);padding:56px 0;color:#fff;">
  <div class="container text-center">
    <h2 style="font-size:1.7rem;font-weight:800;">Collaborate on SDG Research</h2>
    <p style="opacity:.85;max-width:520px;margin:10px auto 0;">SJU welcomes research partnerships with industry, NGOs, government bodies, and international universities on projects aligned with the 2030 Agenda.</p>
    <div class="d-flex justify-content-center gap-3 mt-4 flex-wrap">
      <a href="/about/contact-us" style="background:#fff;color:#064e3b;border-radius:10px;font-weight:700;padding:12px 28px;text-decoration:none;">Contact the Research Office â'</a>
      <a href="reports.php" style="background:transparent;color:#fff;border:2px solid rgba(255,255,255,.6);border-radius:10px;font-weight:700;padding:11px 28px;text-decoration:none;">View SDG Reports</a>
    </div>
  </div>
</section>

<?php require_once '../footer.php'; ?>
</body>
</html>
