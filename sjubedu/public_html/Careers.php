<?php
// Set the timezone to IST
date_default_timezone_set('Asia/Kolkata');
$current_date = date('Y-m-d');
?>
<!doctype html>
<html lang="en" dir="ltr">

<head>
    <?php include $_SERVER['DOCUMENT_ROOT'] . '/gtm.php'; ?>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Careers | St Joseph's University</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="icon" href="assets/img/favicon.png" type="image/png">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/style.css?v=12.0">
   <!--==============================
        All CSS File
    ============================== --> 
    <!-- Fontawesome Icon -->
    <link rel="stylesheet" href="assets/css/fontawesome.min.css">
    <!-- Magnific Popup -->
    <link rel="stylesheet" href="assets/css/magnific-popup.min.css">  
    <!-- Theme Custom CSS -->
    <link rel="stylesheet" href="assets/css/style.css?v=2.3">
 <!--   <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
    <meta http-equiv="Pragma" content="no-cache" />
    <meta http-equiv="Expires" content="0" /> --> 
    <style>
        body { padding-top: 0 !important; margin: 0; background: #fff; font-family: 'Plus Jakarta Sans', sans-serif; }
        .header-spacer { height: 180px; width: 100%; display: block; }
        @media (max-width: 991px) { .header-spacer { height: 140px; } }

        .career-hero {
            background: linear-gradient(rgba(0, 43, 92, 0.8), rgba(0, 43, 92, 0.8)), 
                        url('assets/img/about/St-Josephs-University-bengaluru.webp') center/cover;
            padding: 80px 0; color: white; text-align: center;
        }

        .filter-section { background: #fff; border-radius: 15px; /*margin-top: -40px; */z-index: 10; position: relative; }

        /* Job Card & Metadata */
        .job-card { transition: 0.3s; border-left: 6px solid transparent !important; margin-bottom: 12px; border-radius: 12px !important; border: 1px solid #eee; }
        .job-card:hover:not(.closed-job) { border-left: 6px solid #ffc107 !important; transform: translateY(-3px); box-shadow: 0 10px 20px rgba(0,0,0,0.05); }
        .job-details-meta span { margin-right: 15px; color: #6c757d; font-size: 0.85rem; display: inline-flex; align-items: center; margin-bottom: 5px; }
        .job-details-meta i { color: #ffc107; margin-right: 5px; }

        /* URGENT Badge */
        .badge-urgent { background: #dc3545; color: #fff; animation: pulse 2s infinite; font-size: 0.7rem; font-weight: 700; padding: 5px 10px; }
        @keyframes pulse { 0% { opacity: 1; } 50% { opacity: 0.6; } 100% { opacity: 1; } }

        /* Status Colors */
        .closed-job { opacity: 0.6; background: #f8f9fa !important; border-left: 6px solid #adb5bd !important; pointer-events: none; }
        .btn-pdf { color: #dc3545; border: 1px solid #dc3545; font-size: 0.75rem; padding: 3px 8px; border-radius: 4px; text-decoration: none; }
        .btn-pdf:hover { background: #dc3545; color: #fff; }

        /* Team & Sharing */
        .share-link { color: #6c757d; cursor: pointer; font-size: 1.1rem; }
        .hr-img { width: 110px; height: 110px; object-fit: cover; border: 3px solid #ffc107; border-radius: 50%; }
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
      "name": "Courses",
      "item": "https://www.sju.edu.in"
    },
    {
      "@type": "ListItem",
      "position": 3,
      "name": "Careers at SJU",
      "item": "https://www.sju.edu.in"
    }
  ]
}
</script>
</head>

<body>
    <?php require_once 'header.php';
    
      // Define potential paths for the configuration file
                           $config_paths = [
        '/home/sjubedu/config.php',
        __DIR__ . '/../config.php',
        __DIR__ . '/../../config.php',
        __DIR__ . '/../../../config.php'
    ];

    $config_loaded = false;

    // Loop through paths and load the first one that exists
    foreach ($config_paths as $path) {
        if (file_exists($path)) {
            require_once $path;
            $config_loaded = true;
            break;
        }
    }

    if (!$config_loaded) {
        die("Error: Configuration file not found.");
    }
    
    ?>
    <!--<div class="header-spacer"></div>-->

    <!--<section class="career-hero">
        <div class="container">
            <h1 class="display-5 fw-bold text-white mb-2 text-uppercase">Careers at SJU</h1>
          <p class="lead text-light mb-0">Official IST Server Time: <?php echo date('h:i A'); ?></p> 
        </div>
    </section>-->
<!--BREADCRUMB-->
 <section class="breadcrumb-hero text-white">
  <div class="overlay"></div>
  <div class="container">
    <div class="row">
      <div class="col-12">
        <div class="breadcrumb-content text-center">
          <h1 class="page-title mb-2">Careers at SJU</h1>
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb justify-content-center mb-0">
              <li class="breadcrumb-item">
                <a href="/" class="text-white text-decoration-none">Home</a>
              </li>
              <li class="breadcrumb-item">Courses</li>
              <li class="breadcrumb-item active text-warning" aria-current="page">
                Careers at SJU
              </li>
            </ol>
          </nav>
        </div>
      </div>
    </div>
  </div>
</section>
<!--Announcements-->
<section>
    <div class="announcement" role="region" aria-label="University announcement">
  <div class="announcement__icon" aria-hidden="true">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round">
      <path d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6 6 0 10-12 0v3.159c0 .538-.214 1.055-.595 1.436L4 17h11z"/>
      <path d="M13.73 21a2 2 0 01-3.46 0"/>
    </svg>
  </div>
  <div class="announcement__title">Announcements</div>
  <div class="announcement__scroll">
    <div class="announcement__track">
      <div class="announcement__message"><a href="#">
        21 October 2025: Instructions to Students for Semester Examinations &nbsp; <span>››</span>&nbsp;</a>
      </div>
      <div class="announcement__message"><a href="#">
        18 October 2025: Notice Regarding Certificate Course Admissions – Non SJU Students &nbsp;<span> ›› </span>&nbsp;</a>
      </div>
      <div class="announcement__message"><a href="#">
        15 October 2025: NOTICE – Grant of Additional Marks for Achievements in Sports, NSS, and NCC &nbsp;<span>››</span>&nbsp;</a>
      </div>
      <!-- duplicate messages as needed for seamless scroll -->
      <div class="announcement__message"><a href="#">
        21 October 2025: Instructions to Students for Semester Examinations &nbsp;<span>››</span>&nbsp;</a>
      </div>
      <div class="announcement__message"><a href="#">
        18 October 2025: Notice Regarding Certificate Course Admissions – Non SJU Students &nbsp;<span>››</span>&nbsp;</a>
      </div>
      <div class="announcement__message"><a href="#">
        15 October 2025: NOTICE – Grant of Additional Marks for Achievements in Sports, NSS, and NCC &nbsp;<span>››</span> &nbsp;</a>
      </div>
    </div>
  </div>
</div>
</section>
    <section class="container my-5 px-3">
        <div class="filter-section p-4 shadow border">
            <div class="row g-3">
                <div class="col-md-4"><input type="text" id="jobSearch" class="form-control" placeholder="Search title or dept..."></div>
                <div class="col-md-3">
                    <select id="categoryFilter" class="form-select">
                        <option value="all">All Departments</option>
                        <option value="faculty">Faculty</option>
                        <option value="research">Research</option>
                        <option value="it">IT & Technical</option>
                        <option value="admin">Admin / HR</option>
                        <option value="warden">Hostel Warden</option>
                        <option value="maintenance">Maintenance</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <select id="statusFilter" class="form-select">
                        <option value="open">Open Positions</option>
                        <option value="closed">Closed Positions</option>
                        <option value="all">View All</option>
                    </select>
                </div>
                <div class="col-md-2"><button class="btn btn-warning w-100 fw-bold" onclick="resetFilters()">Reset</button></div>
            </div>
        </div>
    </section>

    <section class="py-4 bg-white">
        <div class="container">
            <div id="jobContainer" class="list-group border-0">
                
                <?php
                // ENHANCED FUNCTION: Includes $is_urgent parameter
                function createJobCard($title, $dept, $exp, $expiry, $cat, $current_date, $id, $is_urgent = false) {
                    $is_closed = ($current_date > $expiry);
                    $status_class = $is_closed ? 'closed-job' : '';
                    $data_status = $is_closed ? 'closed' : 'open';
                    ?>
                    <div class="list-group-item p-4 job-card <?php echo $status_class; ?>" data-category="<?php echo $cat; ?>" data-status="<?php echo $data_status; ?>">
                        <div class="d-md-flex justify-content-between align-items-start">
                            <div class="flex-grow-1">
                                <span class="badge <?php echo $is_closed ? 'bg-secondary' : 'bg-light text-dark'; ?> mb-2">
                                    <?php echo $is_closed ? "Closed: " : "Closing: "; echo date('d M Y', strtotime($expiry)); ?>
                                </span>
                                <?php if ($is_urgent && !$is_closed): ?>
                                    <span class="badge badge-urgent mb-2 ms-1">URGENT</span>
                                <?php endif; ?>

                                <h5 class="fw-bold mb-2 <?php echo $is_closed ? 'text-muted' : ''; ?>"><?php echo $title; ?></h5>
                                <div class="job-details-meta">
                                    <span><i class="bi bi-building"></i> <?php echo $dept; ?></span>
                                    <span><i class="bi bi-briefcase"></i> <?php echo $exp; ?></span>
                                    <span><i class="bi bi-file-earmark-pdf"></i> <a href="#" class="btn-pdf ms-1">View JD</a></span>
                                </div>
                            </div>
                            <div class="text-md-end mt-3 mt-md-0">
                                <div class="mb-3"><i class="bi bi-share share-link" onclick="shareJob('<?php echo $title; ?>', '<?php echo $id; ?>')"></i></div>
                                <?php if (!$is_closed): ?>
                                    <a href="apply-now.php?role=<?php echo $id; ?>" class="btn btn-warning fw-bold px-4 rounded-pill">Apply Now</a>
                                <?php else: ?>
                                    <button class="btn btn-secondary disabled rounded-pill px-4">Expired</button>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php } ?>

                <?php 
                    createJobCard("Assistant Professor - CS", "School of IT", "2-5 Years", "2026-04-15", "faculty", $current_date, "cs", true); // URGENT
                    createJobCard("Hostel Warden", "Student Welfare", "Prior Exp", "2026-03-25", "warden", $current_date, "warden", true); // URGENT
                    createJobCard("Junior Research Fellow", "Life Sciences", "0-1 Year", "2026-03-20", "research", $current_date, "jrf", false);
                    createJobCard("System Administrator", "IT Dept", "5+ Years", "2026-03-01", "it", $current_date, "sys-admin", false); // EXPIRED
                    createJobCard("HR Executive", "Admin Office", "3+ Years", "2026-04-10", "admin", $current_date, "hr", false);
                    createJobCard("Campus Electrician", "Maintenance", "ITI Holder", "2026-04-05", "maintenance", $current_date, "elec", false);
                ?>

            </div>
            <div id="noJobs" class="text-center py-5 d-none"><p class="text-muted">No results match your criteria.</p></div>
        </div>
    </section>

    <section class="py-5 bg-light border-top">
        <div class="container text-center py-4">
            <h2 class="fw-bold mb-5">Talk to our <span class="text-warning">HR Team</span></h2>
            <div class="row justify-content-center g-5">
                <div class="col-6 col-md-3">
                    <img src="assets/img/team/hr1.webp" class="hr-img shadow mb-2"><h6 class="fw-bold mb-0">Dr</h6><p class="small text-muted">Director - HR</p>
                </div>
                <div class="col-6 col-md-3">
                    <img src="assets/img/team/hr2.webp" class="hr-img shadow mb-2"><h6 class="fw-bold mb-0">Mr</h6><p class="small text-muted">Head of Recruitment</p>
                </div>
            </div>
        </div>
    </section>

      <!-- Footer injected -->
<?php require_once 'footer.php'; ?>
  <!-- Custom JS -->
  <script src="/assets/js/main.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function filterJobs() {
            let term = document.getElementById('jobSearch').value.toLowerCase();
            let cat = document.getElementById('categoryFilter').value;
            let stat = document.getElementById('statusFilter').value;
            let count = 0;

            document.querySelectorAll('.job-card').forEach(c => {
                let matchesSearch = c.innerText.toLowerCase().includes(term);
                let matchesCat = cat === 'all' || c.dataset.category === cat;
                let matchesStat = stat === 'all' || c.dataset.status === stat;

                if (matchesSearch && matchesCat && matchesStat) {
                    c.classList.remove('d-none');
                    count++;
                } else {
                    c.classList.add('d-none');
                }
            });
            document.getElementById('noJobs').classList.toggle('d-none', count > 0);
        }

        document.querySelectorAll('input, select').forEach(el => el.addEventListener('input', filterJobs));
        function resetFilters() { document.getElementById('jobSearch').value = ''; document.getElementById('categoryFilter').value = 'all'; document.getElementById('statusFilter').value = 'open'; filterJobs(); }
        
        function shareJob(t, i) { 
            const url = window.location.href + '?role=' + i;
            if (navigator.share) { navigator.share({ title: 'SJU Careers', text: `Apply for ${t}:`, url: url }); } 
            else { navigator.clipboard.writeText(url); alert('Link copied!'); }
        }
        filterJobs();
    </script>
</body>
</html>