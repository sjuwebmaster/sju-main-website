<?php require_once '_shared.php'; ?>
<!doctype html>
<html lang="en" dir="ltr">
<head>
  <?php include $_SERVER['DOCUMENT_ROOT'] . '/gtm.php'; ?>
  <meta charset="utf-8">
  <title>SDG Reports &amp; Rankings | St Joseph's University, Bengaluru</title>
  <meta name="description" content="Sustainability reports, THE Impact Rankings performance, NIRF data, and annual SDG disclosures from St Joseph's University, Bengaluru.">
  <meta name="keywords" content="SDG reports, sustainability report, THE Impact Rankings, NIRF, St Joseph's University">
  <meta name="robots" content="index, follow">
  <link rel="canonical" href="https://www.sju.edu.in/sdg/reports">
  <meta property="og:title" content="SDG Reports &amp; Rankings | St Joseph's University">
  <meta property="og:description" content="Annual SDG progress reports, impact rankings, and sustainability disclosures from SJU.">
  <meta property="og:url" content="https://www.sju.edu.in/sdg/reports">
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
.rep-hero { background:linear-gradient(135deg,#3730a3 0%,#4f46e5 100%); padding:56px 0 44px; color:#fff; }
.rep-hero h1 { font-size:2rem; font-weight:800; }

.rank-card {
  border-radius:18px; overflow:hidden;
  background:#fff; border:1.5px solid #e2e8f0;
  height:100%; transition:box-shadow .2s;
}
.rank-card:hover { box-shadow:0 8px 32px rgba(0,0,0,.1); }
.rank-card-head { padding:28px 26px 20px; color:#fff; }
.rank-card-head .rank-icon { font-size:2.2rem; display:block; margin-bottom:10px; }
.rank-card-head h5 { font-size:1rem; font-weight:800; margin:0; line-height:1.35; }
.rank-card-body { padding:20px 26px 24px; font-size:.88rem; color:#475569; line-height:1.65; }
.rank-value { font-size:2rem; font-weight:900; line-height:1; }

.report-row {
  display:flex; align-items:center; gap:18px;
  border-radius:12px; background:#fff; border:1.5px solid #e2e8f0;
  padding:18px 22px; margin-bottom:14px;
  transition:box-shadow .18s, border-color .18s;
  text-decoration:none; color:inherit;
}
.report-row:hover { box-shadow:0 4px 20px rgba(0,0,0,.08); border-color:#2563b0; }
.report-row .rep-icon { font-size:2rem; flex-shrink:0; }
.report-row .rep-title { font-weight:700; color:#1a3c6e; font-size:.95rem; }
.report-row .rep-desc { font-size:.83rem; color:#64748b; margin-top:2px; }
.report-row .rep-arrow { margin-left:auto; color:#2563b0; font-size:1.1rem; flex-shrink:0; }

.metric-box { background:#f8fafc; border-radius:14px; padding:24px 20px; text-align:center; border:1.5px solid #e2e8f0; }
.metric-box .mn { font-size:2.2rem; font-weight:900; color:#2563b0; line-height:1; }
.metric-box .ml { font-size:.76rem; text-transform:uppercase; letter-spacing:.05em; color:#64748b; margin-top:6px; }
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
      "name": "Reports",
      "item": "https://www.sju.edu.in/sdg/reports"
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
      <h1 class="page-title mb-2">Reports &amp; Rankings</h1>
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb justify-content-center mb-0">
          <li class="breadcrumb-item"><a href="/" class="text-white text-decoration-none">Home</a></li>
          <li class="breadcrumb-item"><a href="index.php" class="text-white text-decoration-none">SDGs</a></li>
          <li class="breadcrumb-item active text-warning" aria-current="page">Reports</li>
        </ol>
      </nav>
    </div>
  </div>
</section>

<section class="rep-hero">
  <div class="container">
    <p class="text-uppercase fw-bold mb-2" style="letter-spacing:.1em;opacity:.65;font-size:.78rem;">Transparency &amp; Accountability</p>
    <h1>SDG Reports &amp; Rankings</h1>
    <p class="mt-2" style="opacity:.85;max-width:640px;">St Joseph's University is committed to transparent reporting of its sustainability and social impact performance â through international ranking frameworks, government disclosures, and annual institutional reports.</p>
  </div>
</section>

<!-- KEY METRICS -->
<div style="background:#fff;padding:40px 0;border-bottom:1px solid #e2e8f0;">
  <div class="container">
    <div class="row g-3">
      <div class="col-6 col-md-3"><div class="metric-box"><div class="mn">NAAC A+</div><div class="ml">Accreditation Grade</div></div></div>
      <div class="col-6 col-md-3"><div class="metric-box"><div class="mn">NIRF</div><div class="ml">Ranked Nationally</div></div></div>
      <div class="col-6 col-md-3"><div class="metric-box"><div class="mn">THE</div><div class="ml">Impact Rankings Participant</div></div></div>
      <div class="col-6 col-md-3"><div class="metric-box"><div class="mn">17/17</div><div class="ml">SDGs Engaged</div></div></div>
    </div>
  </div>
</div>

<!-- RANKING FRAMEWORKS -->
<section class="py-5" style="background:#f8fafc;">
  <div class="container">
    <div class="text-center mb-5">
      <div style="width:48px;height:4px;background:#2563b0;border-radius:2px;margin:0 auto 14px;"></div>
      <h2 style="font-size:1.6rem;font-weight:800;color:#1a3c6e;">Ranking &amp; Assessment Frameworks</h2>
      <p class="text-muted mt-2" style="max-width:580px;margin:0 auto;">SJU uses established external benchmarks to measure, communicate, and improve its SDG performance.</p>
    </div>
    <div class="row g-4">
      <div class="col-sm-6 col-lg-3">
        <div class="rank-card">
          <div class="rank-card-head" style="background:linear-gradient(135deg,#b45309,#d97706);">
            <span class="rank-icon">ð</span>
            <h5>Times Higher Education Impact Rankings</h5>
          </div>
          <div class="rank-card-body">
            <p>THE Impact Rankings evaluate universities against all 17 SDGs. SJU participates in this framework to benchmark SDG performance globally and identify areas for improvement.</p>
            <span class="sdg-pill-tag">Global Benchmark</span>
            <span class="sdg-pill-tag">All 17 SDGs</span>
          </div>
        </div>
      </div>
      <div class="col-sm-6 col-lg-3">
        <div class="rank-card">
          <div class="rank-card-head" style="background:linear-gradient(135deg,#1e40af,#2563b0);">
            <span class="rank-icon">ð</span>
            <h5>NAAC â National Assessment &amp; Accreditation</h5>
          </div>
          <div class="rank-card-body">
            <p>SJU holds an A+ grade from NAAC. The NAAC Self-Study Report contains detailed data on research output, social impact, infrastructure, and inclusive practices aligned with SDGs.</p>
            <span class="sdg-pill-tag">A+ Grade</span>
            <span class="sdg-pill-tag">SDG 4 Â· 16</span>
          </div>
        </div>
      </div>
      <div class="col-sm-6 col-lg-3">
        <div class="rank-card">
          <div class="rank-card-head" style="background:linear-gradient(135deg,#065f46,#047857);">
            <span class="rank-icon">ð</span>
            <h5>NIRF â National Institutional Rankings Framework</h5>
          </div>
          <div class="rank-card-body">
            <p>NIRF rankings assess universities on Teaching, Research, Graduation Outcomes, Outreach, Inclusivity, and Perception â all strongly correlated with SDG targets.</p>
            <span class="sdg-pill-tag">National Ranking</span>
            <span class="sdg-pill-tag">SDG 4 Â· 10</span>
          </div>
        </div>
      </div>
      <div class="col-sm-6 col-lg-3">
        <div class="rank-card">
          <div class="rank-card-head" style="background:linear-gradient(135deg,#6d28d9,#7c3aed);">
            <span class="rank-icon">ð</span>
            <h5>IQAC Annual Quality Assurance Report</h5>
          </div>
          <div class="rank-card-body">
            <p>SJU's Internal Quality Assurance Cell publishes an Annual Quality Assurance Report (AQAR) covering curriculum, research, student outcomes, and community engagement metrics.</p>
            <span class="sdg-pill-tag">Annual Disclosure</span>
            <span class="sdg-pill-tag">SDG 16</span>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- REPORTS LIST -->
<section class="py-5">
  <div class="container">
    <div class="row g-5">
      <div class="col-lg-6">
        <div style="width:48px;height:4px;background:#2563b0;border-radius:2px;margin-bottom:16px;"></div>
        <h2 style="font-size:1.4rem;font-weight:800;color:#1a3c6e;margin-bottom:24px;">Institutional Reports</h2>

        <a href="/about/iqac" class="report-row">
          <span class="rep-icon">ð</span>
          <div>
            <div class="rep-title">IQAC Annual Quality Assurance Reports (AQAR)</div>
            <div class="rep-desc">Year-wise AQAR submissions to NAAC â covering research, teaching, outreach, and SDG progress.</div>
          </div>
          <i class="bi bi-arrow-right-circle rep-arrow"></i>
        </a>

        <a href="/about/naac" class="report-row">
          <span class="rep-icon">ð</span>
          <div>
            <div class="rep-title">NAAC Self-Study Report (SSR)</div>
            <div class="rep-desc">Comprehensive institutional self-assessment submitted to NAAC, with detailed social and sustainability impact data.</div>
          </div>
          <i class="bi bi-arrow-right-circle rep-arrow"></i>
        </a>

        <a href="/about/nirf" class="report-row">
          <span class="rep-icon">ðï¸</span>
          <div>
            <div class="rep-title">NIRF Data Disclosures</div>
            <div class="rep-desc">Annual data submitted to MHRD's National Institutional Rankings Framework â publicly available on the NIRF portal.</div>
          </div>
          <i class="bi bi-arrow-right-circle rep-arrow"></i>
        </a>

        <a href="/research" class="report-row">
          <span class="rep-icon">ð¬</span>
          <div>
            <div class="rep-title">Research Publications Archive</div>
            <div class="rep-desc">Faculty and student publications mapped to SDG targets â journals, conference proceedings, and monographs.</div>
          </div>
          <i class="bi bi-arrow-right-circle rep-arrow"></i>
        </a>
      </div>

      <div class="col-lg-6">
        <div style="width:48px;height:4px;background:#2563b0;border-radius:2px;margin-bottom:16px;"></div>
        <h2 style="font-size:1.4rem;font-weight:800;color:#1a3c6e;margin-bottom:24px;">Campus Sustainability Data</h2>

        <div class="report-row" style="cursor:default;">
          <span class="rep-icon">âï¸</span>
          <div>
            <div class="rep-title">Solar Energy Generation Report</div>
            <div class="rep-desc">Annual kilowatt-hour generation from campus solar installations and COâ offset calculations. (Available from Facilities Office)</div>
          </div>
          <i class="bi bi-building rep-arrow"></i>
        </div>

        <div class="report-row" style="cursor:default;">
          <span class="rep-icon">ð'§</span>
          <div>
            <div class="rep-title">Water Audit Report</div>
            <div class="rep-desc">Annual campus water-consumption data, rainwater-harvesting yield, and conservation targets. (Available from Sustainability Cell)</div>
          </div>
          <i class="bi bi-building rep-arrow"></i>
        </div>

        <div class="report-row" style="cursor:default;">
          <span class="rep-icon">ðï¸</span>
          <div>
            <div class="rep-title">Waste Management Report</div>
            <div class="rep-desc">Segregation rates, composting volumes, and plastic-free event metrics reported annually to the Green Campus Committee.</div>
          </div>
          <i class="bi bi-building rep-arrow"></i>
        </div>

        <div class="report-row" style="cursor:default;">
          <span class="rep-icon">ð¿</span>
          <div>
            <div class="rep-title">Biodiversity Audit Report</div>
            <div class="rep-desc">Annual species-count audit of flora and fauna on the SJU campus, conducted by Botany and Zoology departments.</div>
          </div>
          <i class="bi bi-building rep-arrow"></i>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- SDG PROGRESS TABLE -->
<section class="py-5" style="background:#f8fafc;">
  <div class="container">
    <div class="text-center mb-5">
      <div style="width:48px;height:4px;background:#2563b0;border-radius:2px;margin:0 auto 14px;"></div>
      <h2 style="font-size:1.6rem;font-weight:800;color:#1a3c6e;">SDG Engagement Summary</h2>
      <p class="text-muted mt-2">A high-level overview of SJU's primary mechanism of engagement per SDG.</p>
    </div>
    <div class="table-responsive rounded-4 border">
      <table class="table table-hover mb-0" style="font-size:.86rem;">
        <thead style="background:#1a3c6e;color:#fff;">
          <tr>
            <th style="padding:12px 16px;width:60px;">Goal</th>
            <th style="padding:12px 16px;">Title</th>
            <th style="padding:12px 16px;">Primary Mechanism</th>
            <th style="padding:12px 16px;">Key Unit</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $summary = [
            [1,'No Poverty','Scholarships &amp; Welfare','Dean of Students'],
            [2,'Zero Hunger','Mid-Day Meal Programme','Campus Administration'],
            [3,'Good Health','Counselling &amp; NSS Health Camps','Student Welfare'],
            [4,'Quality Education','NAAC A+ Curriculum, NEP 2020','IQAC'],
            [5,'Gender Equality','Women\'s Cell &amp; Gender Champions','Equal Opportunity Cell'],
            [6,'Clean Water','Rainwater Harvesting, Water Audits','Facilities &amp; Env. Science'],
            [7,'Clean Energy','Solar Campus, Energy Audits','Physics &amp; Facilities'],
            [8,'Decent Work','Placements, SJRIC Incubation','CDC &amp; SJRIC'],
            [9,'Innovation','Cyber Security, AI, MoUs','SJRIC &amp; Departments'],
            [10,'Reduced Inequalities','Shift III, SC/ST Scholarships','Admissions Office'],
            [11,'Sustainable Cities','Green Campus, NSS Outreach','NSS &amp; Facilities'],
            [12,'Responsible Consumption','Plastic-free, Waste Segregation','Green Campus Committee'],
            [13,'Climate Action','Climate Clock, M.Sc. Env. Science','Env. Science Dept'],
            [14,'Life Below Water','Aquatic Biodiversity Research','Zoology Department'],
            [15,'Life on Land','Botanical Garden, Herbarium','Botany Department'],
            [16,'Peace &amp; Justice','IQAC Governance, Journalism','IQAC &amp; Journalism'],
            [17,'Partnerships','Jesuit Network, ACU, MoUs','International Relations'],
          ];
          foreach ($summary as $row):
            $color = $SDG[$row[0]]['color'];
          ?>
          <tr>
            <td style="padding:10px 16px;">
              <span style="background:<?= $color ?>;color:#fff;border-radius:20px;padding:2px 10px;font-size:.72rem;font-weight:700;"><?= $row[0] ?></span>
            </td>
            <td style="padding:10px 16px;font-weight:600;color:#1a3c6e;"><?= $row[1] ?></td>
            <td style="padding:10px 16px;color:#475569;"><?= $row[2] ?></td>
            <td style="padding:10px 16px;color:#64748b;"><?= $row[3] ?></td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</section>

<!-- CTA -->
<section style="background:linear-gradient(135deg,#3730a3 0%,#4f46e5 100%);padding:56px 0;color:#fff;">
  <div class="container text-center">
    <h2 style="font-size:1.7rem;font-weight:800;">Request a Report</h2>
    <p style="opacity:.85;max-width:520px;margin:10px auto 0;">For detailed sustainability data, campus audit results, or institutional SDG disclosures, contact the IQAC office.</p>
    <div class="d-flex justify-content-center gap-3 mt-4 flex-wrap">
      <a href="/about/iqac" style="background:#fff;color:#3730a3;border-radius:10px;font-weight:700;padding:12px 28px;text-decoration:none;">Visit IQAC â'</a>
      <a href="get-involved.php" style="background:transparent;color:#fff;border:2px solid rgba(255,255,255,.6);border-radius:10px;font-weight:700;padding:11px 28px;text-decoration:none;">Get Involved</a>
    </div>
  </div>
</section>

<?php require_once '../footer.php'; ?>
</body>
</html>
