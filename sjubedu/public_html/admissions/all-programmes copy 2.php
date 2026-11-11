<!doctype html>
<html lang="en" dir="ltr">

<head>
    <?php include $_SERVER['DOCUMENT_ROOT'] . '/gtm.php'; ?>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>All Programmes | St Joseph's University, Bengaluru</title>
    <meta name="description" content="Explore All Programmes at St Joseph's University, Bengaluru — UG, PG and doctoral programme admissions 2026. Eligibility, process and important dates.">
    <meta name="keywords" content="admissions St Joseph's University Bengaluru, UG PG admission SJU Bangalore 2026, college admission Karnataka, SJU admissions Bengaluru, Jesuit university admissions">
    <link rel="canonical" href="https://www.sju.edu.in/admissions/all-programmes copy 2">

    <!-- Open Graph / Social Sharing -->
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="St Joseph's University, Bengaluru">
    <meta property="og:title" content="All Programmes | St Joseph's University, Bengaluru">
    <meta property="og:description" content="Explore All Programmes at St Joseph's University, Bengaluru — UG, PG and doctoral programme admissions 2026. Eligibility, process and important dates.">
    <meta property="og:url" content="https://www.sju.edu.in/admissions/all-programmes copy 2">
    <meta property="og:image" content="https://www.sju.edu.in/assets/img/st-joseph-university-logo.png">
    <meta property="og:image:width" content="200">
    <meta property="og:image:height" content="200">
    <meta name="twitter:card" content="summary">
    <meta name="twitter:site" content="@StJosephsUniBLR">
    <meta name="twitter:title" content="All Programmes | St Joseph's University, Bengaluru">
    <meta name="twitter:description" content="Explore All Programmes at St Joseph's University, Bengaluru — UG, PG and doctoral programme admissions 2026. Eligibility, process and important dates.">
    <meta name="twitter:image" content="https://www.sju.edu.in/assets/img/st-joseph-university-logo.png">

    <!-- Mobile Specific Metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Favicons - Place favicon.ico in the root directory -->
    <link rel="icon" href="../assets/img/favicon.png" type="image/png">
    <!-- Apple Touch Icon (for iOS home screen) -->
    <link rel="apple-touch-icon" href="../assets/img/favicon-apple.png">
    <link rel="manifest" href="../assets/img/favicons/manifest.json">
    <meta name="msapplication-TileColor" content="#ffffff">

    <!--==============================
      Google Fonts
    ============================== -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400..900;1,400..900&family=Plus+Jakarta+Sans:ital,wght@0,200..800;1,200..800&family=Urbanist:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Arima:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">


    <!--==============================
        All CSS File
    ============================== -->
    <!-- Bootstrap -->
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <!-- Fontawesome Icon -->
    <link rel="stylesheet" href="../assets/css/fontawesome.min.css">
    <!-- Magnific Popup -->
    <link rel="stylesheet" href="../assets/css/magnific-popup.min.css">
    <!-- Swiper Js -->
    <link rel="stylesheet" href="../assets/css/swiper-bundle.min.css">
    <!-- Theme Custom CSS -->
    <link rel="stylesheet" href="../assets/css/style.css?v=2.3">
 <!--   <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
    <meta http-equiv="Pragma" content="no-cache" />
    <meta http-equiv="Expires" content="0" /> --> 
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
      "name": "All Programmes",
      "item": "https://www.sju.edu.in/admissions/all-programmes copy 2"
    }
  ]
}
</script>
</head>
<body>
    <?php require_once '../header.php';
    
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
    
<!--BREADCRUMB-->
 <section class="breadcrumb-hero text-white">
  <div class="overlay"></div>
  <div class="container">
    <div class="row">
      <div class="col-12">
        <div class="breadcrumb-content text-center">
          <h1 class="page-title mb-2">All Programmes</h1>
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb justify-content-center mb-0">
              <li class="breadcrumb-item">
                <a href="/" class="text-white text-decoration-none">Home</a>
              </li> 
              <li class="breadcrumb-item active text-warning" aria-current="page">
                 All Programmes
              </li>
            </ol>
          </nav>
        </div>
      </div>
    </div>
  </div>
</section> 
<!-- FILTER BAR -->

<section class="admission-section py-5 px-4">
   <div class="container program-filter-section p-5">

      <div class="row g-4 justify-content-center">
         <div class="col-12">
             <h5 class="fw-bold text-white">Find your program</h5>
         </div>
         <div class="col-lg-4">

             <select id="levelFilter" class="form-select program-filter">
                <option value="all" selected>All Programmes</option>
                <option value="ug">UG</option>
                <option value="pg">PG</option>
                <option value="pg-diploma">PG Diploma</option>
             </select>

         </div>

         <div class="col-lg-6">

             <select id="schoolFilter" class="form-select program-filter">
                <option value="all" selected>All School</option>
                <option value="business">School of Business</option>
                <option value="chemical">School of Chemical Sciences</option>
                <option value="humanities">School of Humanities & Social Sciences</option>
                <option value="language">School of Languages & Literatures</option>
                <option value="life_sciences">School of Life Sciences</option>
                <option value="physical_science">School of Physical Sciences</option>
                <option value="social">School of Social Work</option>
                <option value="communication">School of Communication & Media Studies</option>
                <option value="info_technology">School of Information Technology</option>
             </select>

         </div>

         <div class="col-lg-2">
                <button id="filterBtn" class="program-search-btn">
                   <i class="fa-solid fa-chevron-right"></i>
                </button>
         </div>

      </div>

   </div>
</section>



<section class="admission-section pt-3 bpb-5 px-4">

   <div class="container">

      <!-- ===================== UG PROGRAMMES ===================== -->
      <div class="school-block" data-level="ug" data-school="business">
         <h3 class="text_blue fw-bold mb-3">School of Business</h3>
         <div class="program-grid">

              <!-- PROGRAM -->
              <div class="programme-box">
                <div class="d-flex gap-4 pgm_dtl">
                    <div class="program-icon icon-orange">
                      <i class="fa fa-book"></i>
                    </div>
                    <div>
                      <h5 class="text-blue fw-bold">Bachelor of Commerce (B.Com.)</h5>
                      <p class="program-degree">UG Programme</p>
              
                    </div>
                </div>
                <div class="batch-info mb-4">
                    <ul class="list-unstyled batch-list">
                      <li class="batch-item">
                        <span>Batch I</span>
                        <strong>7:00 AM – 12:00 PM</strong>
                      </li>
                      <li class="batch-item">
                        <span>Batch II</span>
                        <strong>12:00 PM – 04:00 PM (closed on 17 April 2026)</strong>
                      </li>
                      <li class="batch-item">
                        <span>Batch III</span>
                        <strong>04:45 PM – 08:45 PM</strong>
                      </li>
                      <li class="batch-item">
                        <span>Block B (Bannerghatta)</span>
                        <strong>9:00 AM to 4:00 PM</strong>
                      </li>
                    </ul>
                </div>
                <p><b>Entrance Test:</b> No</p>

                <!-- CTA Buttons -->
                <div class="hero-actions">
                  <button class="btn btn-success fee-btn" data-url="<?php echo LIVE_URL; ?>school-of-business/department-of-commerce/bachelor-of-commerce.php">Fees</button>
                  <p><a href="../school-of-business/department-of-commerce/bachelor-of-commerce.php" target="_blank" class="btn btn-warning">Details</a></p>
                  <p><a href="https://sjuv4.linways.com/v4/adm-applicant/login" target="_blank" class="btn-outline">Apply</a></p>
                </div>
             </div>
            
            <!-- PROGRAM -->
            <div class="programme-box">
                <div class="d-flex gap-4 pgm_dtl">
                    <div class="program-icon icon-orange">
                      <i class="fa fa-book"></i>
                    </div>
                    <div>
                      <h5 class="text-blue fw-bold">Bachelor of Commerce (B.Com.) Industry Integrated</h5>
                      <p class="program-degree">UG Programme</p>
              
                    </div>
                </div>
                <div class="batch-info mb-4">
                    <ul class="list-unstyled batch-list">
                      <li class="batch-item">
                        <span>Batch </span>
                        <strong>7:00 AM – 12:00 PM (closed on 15 April 2026)</strong>
                      </li> 
                    </ul>
                </div> 
                <p><b>Entrance Test:</b> No</p>
                
                <!-- CTA Buttons -->
                <div class="hero-actions">
                  <button class="btn btn-success fee-btn" data-url="<?php echo LIVE_URL; ?>school-of-business/department-of-commerce/bachelor-of-commerce-industry-integrated.php">Fees</button>
                  <p><a href="../school-of-business/department-of-commerce/bachelor-of-commerce-industry-integrated.php" target="_blank" class="btn btn-warning">Details</a></p>
                  <p><a href="https://sjuv4.linways.com/v4/adm-applicant/login" target="_blank" class="btn-outline">Apply</a></p>
                </div> 
            </div>
            <!-- PROGRAM -->
            <div class="programme-box">
                <div class="d-flex gap-4 pgm_dtl">
                    <div class="program-icon icon-orange">
                      <i class="fa fa-book"></i>
                    </div>
                    <div>
                      <h5 class="text-blue fw-bold">Bachelor of Commerce (B.Com.) International Finance and Accounting</h5>
                      <p class="program-degree">UG Programme</p>
              
                    </div>
                </div>
                <div class="batch-info mb-4">
                    <ul class="list-unstyled batch-list">
                      <li class="batch-item">
                        <span>Batch I </span>
                        <strong>7:00 AM to 12:00 PM</strong>
                      </li> 
                      <li class="batch-item">
                        <span>Batch II</span>
                        <strong>4:45 PM to 8:45 PM</strong>
                      </li> 
                    </ul>
                </div> 
                <p><b>Entrance Test:</b> Yes</p>
                
                <!-- CTA Buttons -->
                <div class="hero-actions">
                   <button class="btn btn-success fee-btn" data-url="<?php echo LIVE_URL; ?>school-of-business/department-of-commerce/bachelor-of-commerce-international-finance-and-accounting.php"> Fees </button>
                  <p><a href="../school-of-business/department-of-commerce/bachelor-of-commerce-international-finance-and-accounting.php" target="_blank" class="btn btn-warning">Details</a></p>
                  <p><a href="https://sjuv4.linways.com/v4/adm-applicant/login" target="_blank" class="btn-outline">Apply</a></p>
                </div> 
            </div>
            
            <!-- PROGRAM -->
            <div class="programme-box">
                <div class="d-flex gap-4 pgm_dtl">
                    <div class="program-icon icon-orange">
                      <i class="fa fa-book"></i>
                    </div>
                    <div>
                      <h5 class="text-blue fw-bold">Bachelor of Business Administration (BBA)</h5>
                      <p class="program-degree">UG Programme</p>
              
                    </div>
                </div>
                <div class="batch-info mb-4">
                    <ul class="list-unstyled batch-list">
                      <li class="batch-item">
                        <span>Batch I </span>
                        <strong>7:00 AM to 12:00 PM</strong>
                      </li> 
                      <li class="batch-item">
                        <span>Batch II</span>
                        <strong>4:45 PM to 8:45 PM</strong>
                      </li> 
                      <li class="batch-item">
                        <span>Block B (Bannerghatta)</span>
                        <strong>9:00 AM to 4:00 PM</strong>
                      </li> 
                    </ul>
                </div> 
                <p><b>Entrance Test:</b> No</p>
                
                <!-- CTA Buttons -->
                <div class="hero-actions">
                   <button class="btn btn-success fee-btn" data-url="<?php echo LIVE_URL; ?>school-of-business/department-of-management/bachelor-of-business-administration.php"> Fees </button>
                  <p><a href="../school-of-business/department-of-management/bachelor-of-business-administration.php" target="_blank" class="btn btn-warning">Details</a></p>
                  <p><a href="https://sjuv4.linways.com/v4/adm-applicant/login" target="_blank" class="btn-outline">Apply</a></p>
                </div> 
            </div>
            
            <!-- PROGRAM -->
            <div class="programme-box">
                <div class="d-flex gap-4 pgm_dtl">
                    <div class="program-icon icon-orange">
                      <i class="fa fa-book"></i>
                    </div>
                    <div>
                      <h5 class="text-blue fw-bold">Bachelor of Business Administration (BBA) in Strategic Finance</h5>
                      <p class="program-degree">UG Programme</p>
              
                    </div>
                </div>
                <div class="batch-info mb-4">
                    <ul class="list-unstyled batch-list">
                      <li class="batch-item">
                        <span>Batch I </span>
                        <strong>7:00 AM to 12:00 PM</strong>
                      </li> 
                      <li class="batch-item">
                        <span>Batch II</span>
                        <strong>4:00 PM to 8:45 PM</strong>
                      </li>  
                    </ul>
                </div> 
                <p><b>Entrance Test:</b> Yes</p>
                
                <!-- CTA Buttons -->
                <div class="hero-actions">
                  <button class="btn btn-success fee-btn" data-url="<?php echo LIVE_URL; ?>school-of-business/department-of-management/bba-in-strategic-finance.php"> Fees </button>
                  <p><a href="../school-of-business/department-of-management/bba-in-strategic-finance.php" target="_blank" class="btn btn-warning">Details</a></p>
                  <p><a href="https://sjuv4.linways.com/v4/adm-applicant/login" target="_blank" class="btn-outline">Apply</a></p>
                </div> 
            </div>
            <!-- PROGRAM -->
            <div class="programme-box">
                <div class="d-flex gap-4 pgm_dtl">
                    <div class="program-icon icon-orange">
                      <i class="fa fa-book"></i>
                    </div>
                    <div>
                      <h5 class="text-blue fw-bold">Bachelor of Business Administration (BBA) in Branding and Entrepreneurship</h5>
                      <p class="program-degree">UG Programme</p>
              
                    </div>
                </div>
                <div class="batch-info mb-4">
                    <ul class="list-unstyled batch-list">
                      <li class="batch-item">
                        <span>Batch </span>
                        <strong>7:00 AM to 12:00 PM</strong>
                      </li>  
                    </ul>
                </div> 
                <p><b>Entrance Test:</b> No</p>
                
                <!-- CTA Buttons -->
                <div class="hero-actions">
                  <button class="btn btn-success fee-btn" data-url="<?php echo LIVE_URL; ?>school-of-business/department-of-management/bba-in-branding-and-entrepreneurship.php"> Fees </button>
                  <p><a href="../school-of-business/department-of-management/bba-in-branding-and-entrepreneurship.php" target="_blank" class="btn btn-warning">Details</a></p>
                  <p><a href="https://sjuv4.linways.com/v4/adm-applicant/login" target="_blank" class="btn-outline">Apply</a></p>
                </div> 
            </div>
            
        </div>
     </div>
     
     <div class="school-block" data-level="ug" data-school="chemical">
         <h3 class="text_blue fw-bold mb-3">School of Chemical Sciences</h3>
         <div class="program-grid">

            <!-- PROGRAM -->
            <div class="programme-box">
                <div class="d-flex gap-4 pgm_dtl">
                    <div class="program-icon icon-orange">
                      <i class="fa fa-book"></i>
                    </div>
                    <div>
                      <h5 class="text-blue fw-bold">Bachelor of Science (B.Sc.) in Chemistry, Biotechnology and Biology</h5>
                      <p class="program-degree">UG Programme</p>
              
                    </div>
                </div>
                <div class="batch-info mb-4">
                    <ul class="list-unstyled batch-list">
                      <li class="batch-item">
                        <span>Batch </span>
                        <strong>9:00 AM – 4:00 PM</strong>
                      </li>  
                    </ul>
                </div>  
                <p><b>Entrance Test:</b> No</p>

                <!-- CTA Buttons -->
                <div class="hero-actions">
                 <button class="btn btn-success fee-btn" data-url="<?php echo LIVE_URL; ?>school-of-chemical-sciences/department-of-chemistry/bsc-in-chemistry-biotechnology-and-biology.php"> Fees </button>
                 <p><a href="../school-of-chemical-sciences/department-of-chemistry/bsc-in-chemistry-biotechnology-and-biology.php" target="_blank" class="btn btn-warning">Details</a></p>
                 <p><a href="https://sjuv4.linways.com/v4/adm-applicant/login" target="_blank" class="btn-outline">Apply Now</a></p>
                </div>
            </div>
            <!-- PROGRAM -->
            <div class="programme-box">
                <div class="d-flex gap-4 pgm_dtl">
                    <div class="program-icon icon-orange">
                      <i class="fa fa-book"></i>
                    </div>
                    <div>
                      <h5 class="text-blue fw-bold">Bachelor of Science (B.Sc.) in Biochemistry, Microbiology and Zoology</h5>
                      <p class="program-degree">UG Programme</p>
              
                    </div>
                </div>
                <div class="batch-info mb-4">
                    <ul class="list-unstyled batch-list">
                      <li class="batch-item">
                        <span>Batch </span>
                        <strong>7:00 AM to 1:00 PM</strong>
                      </li>  
                    </ul>
                </div>  
                <p><b>Entrance Test:</b> No</p>

                <!-- CTA Buttons -->
                <div class="hero-actions">
                 <button class="btn btn-success fee-btn" data-url="<?php echo LIVE_URL; ?>school-of-chemical-sciences/department-of-biochemistry/bsc-in-biochemistry-microbiology-and-zoology.php"> Fees </button>
                 <p><a href="../school-of-chemical-sciences/department-of-biochemistry/bsc-in-biochemistry-microbiology-and-zoology.php" target="_blank" class="btn btn-warning">Details</a></p>
                 <p><a href="https://sjuv4.linways.com/v4/adm-applicant/login" target="_blank" class="btn-outline">Apply Now</a></p>
                </div>
            </div>
            <!-- PROGRAM -->
            <div class="programme-box">
                <div class="d-flex gap-4 pgm_dtl">
                    <div class="program-icon icon-orange">
                      <i class="fa fa-book"></i>
                    </div>
                    <div>
                      <h5 class="text-blue fw-bold">Bachelor of Science (B.Sc.) in Biochemistry, Biology and Biotechnology</h5>
                      <p class="program-degree">UG Programme</p>
              
                    </div>
                </div>
                <div class="batch-info mb-4">
                    <ul class="list-unstyled batch-list">
                      <li class="batch-item">
                        <span>Batch </span>
                        <strong>7:00 AM to 1:00 PM</strong>
                      </li>  
                    </ul>
                </div>  
                <p><b>Entrance Test:</b> No</p>

                <!-- CTA Buttons -->
                <div class="hero-actions">
                 <button class="btn btn-success fee-btn" data-url="<?php echo LIVE_URL; ?>school-of-chemical-sciences/department-of-biochemistry/bsc-in-biochemistry-biology-and-biotechnology.php"> Fees </button>
                 <p><a href="../school-of-chemical-sciences/department-of-biochemistry/bsc-in-biochemistry-biology-and-biotechnology.php" target="_blank" class="btn btn-warning">Details</a></p>
                 <p><a href="https://sjuv4.linways.com/v4/adm-applicant/login" target="_blank" class="btn-outline">Apply Now</a></p>
                </div>
            </div>
            <!-- PROGRAM -->
            <div class="programme-box">
                <div class="d-flex gap-4 pgm_dtl">
                    <div class="program-icon icon-orange">
                      <i class="fa fa-book"></i>
                    </div>
                    <div>
                      <h5 class="text-blue fw-bold">Bachelor of Science (B.Sc.) in Biochemistry, Biotechnology and Zoology</h5>
                      <p class="program-degree">UG Programme</p>
              
                    </div>
                </div>
                <div class="batch-info mb-4">
                    <ul class="list-unstyled batch-list">
                      <li class="batch-item">
                        <span>Batch </span>
                        <strong>7:00 AM to 1:00 PM</strong>
                      </li>  
                    </ul>
                </div>  
                <p><b>Entrance Test:</b> No</p>

                <!-- CTA Buttons -->
                <div class="hero-actions">
                 <button class="btn btn-success fee-btn" data-url="<?php echo LIVE_URL; ?>school-of-chemical-sciences/department-of-biochemistry/bsc-in-biochemistry-biotechnology-and-zoology.php"> Fees </button>
                 <p><a href="../school-of-chemical-sciences/department-of-biochemistry/bsc-in-biochemistry-biotechnology-and-zoology.php" target="_blank" class="btn btn-warning">Details</a></p>
                 <p><a href="https://sjuv4.linways.com/v4/adm-applicant/login" target="_blank" class="btn-outline">Apply Now</a></p>
                </div>
            </div>
            <!-- PROGRAM -->
            <div class="programme-box">
                <div class="d-flex gap-4 pgm_dtl">
                    <div class="program-icon icon-orange">
                      <i class="fa fa-book"></i>
                    </div>
                    <div>
                      <h5 class="text-blue fw-bold">Bachelor of Science (B.Sc.) in Chemistry, Botany and Zoology</h5>
                      <p class="program-degree">UG Programme</p>
              
                    </div>
                </div>
                <div class="batch-info mb-4">
                    <ul class="list-unstyled batch-list">
                      <li class="batch-item">
                        <span>Batch </span>
                        <strong>9:00 AM to 4:00 PM</strong>
                      </li>  
                    </ul>
                </div>   
                <p><b>Entrance Test:</b> No</p>

                <!-- CTA Buttons -->
                <div class="hero-actions">
                 <button class="btn btn-success fee-btn" data-url="<?php echo LIVE_URL; ?>school-of-chemical-sciences/department-of-chemistry/bsc-in-chemistry-botany-and-zoology.php"> Fees </button>
                 <p><a href="../school-of-chemical-sciences/department-of-chemistry/bsc-in-chemistry-botany-and-zoology.php" target="_blank" class="btn btn-warning">Details</a></p>
                 <p><a href="https://sjuv4.linways.com/v4/adm-applicant/login" target="_blank" class="btn-outline">Apply Now</a></p>
                </div>
            </div>
            <!-- PROGRAM -->
            <div class="programme-box">
                <div class="d-flex gap-4 pgm_dtl">
                    <div class="program-icon icon-orange">
                      <i class="fa fa-book"></i>
                    </div>
                    <div>
                      <h5 class="text-blue fw-bold">Bachelor of Science (B.Sc.) in Physics, Chemistry and Mathematics</h5>
                      <p class="program-degree">UG Programme</p>
              
                    </div>
                </div>
                <div class="batch-info mb-4">
                    <ul class="list-unstyled batch-list">
                      <li class="batch-item">
                        <span>Batch </span>
                        <strong>9:00 AM to 4:00 PM</strong>
                      </li>  
                    </ul>
                </div>   
                <p><b>Entrance Test:</b> No</p>

                <!-- CTA Buttons -->
                <div class="hero-actions">
                 <button class="btn btn-success fee-btn" data-url="<?php echo LIVE_URL; ?>school-of-chemical-sciences/department-of-chemistry/bsc-in-physics-chemistry-and-mathematics.php"> Fees </button>
                 <p><a href="../school-of-chemical-sciences/department-of-chemistry/bsc-in-physics-chemistry-and-mathematics.php" target="_blank" class="btn btn-warning">Details</a></p>
                 <p><a href="https://sjuv4.linways.com/v4/adm-applicant/login" target="_blank" class="btn-outline">Apply Now</a></p>
                </div>
            </div>
            <!-- PROGRAM -->
            <div class="programme-box">
                <div class="d-flex gap-4 pgm_dtl">
                    <div class="program-icon icon-orange">
                      <i class="fa fa-book"></i>
                    </div>
                    <div>
                      <h5 class="text-blue fw-bold">Bachelor of Science (B.Sc.) in Chemistry, Environmental Science and Biology</h5>
                      <p class="program-degree">UG Programme</p>
              
                    </div>
                </div>
                <div class="batch-info mb-4">
                    <ul class="list-unstyled batch-list">
                      <li class="batch-item">
                        <span>Batch </span>
                        <strong>9:00 AM to 4:00 PM</strong>
                      </li>  
                    </ul>
                </div>   
                <p><b>Entrance Test:</b> No</p>

                <!-- CTA Buttons -->
                <div class="hero-actions"> 
                 <button class="btn btn-success fee-btn" data-url="<?php echo LIVE_URL; ?>school-of-chemical-sciences/department-of-chemistry/bsc-in-chemistry-environmental_science-and-biology.php"> Fees </button>
                 <p><a href="../school-of-chemical-sciences/department-of-chemistry/bsc-in-chemistry-environmental_science-and-biology.php" target="_blank" class="btn btn-warning">Details</a></p>
                 <p><a href="https://sjuv4.linways.com/v4/adm-applicant/login" target="_blank" class="btn-outline">Apply Now</a></p>
                </div>
            </div>
            <!-- PROGRAM -->
            <div class="programme-box">
                <div class="d-flex gap-4 pgm_dtl">
                    <div class="program-icon icon-orange">
                      <i class="fa fa-book"></i>
                    </div>
                    <div>
                      <h5 class="text-blue fw-bold">Bachelor of Science (B.Sc.) in Chemistry, Microbiology and Biology</h5>
                      <p class="program-degree">UG Programme</p>
              
                    </div>
                </div>
                <div class="batch-info mb-4">
                    <ul class="list-unstyled batch-list">
                      <li class="batch-item">
                        <span>Batch </span>
                        <strong>9:00 AM to 4:00 PM</strong>
                      </li>  
                    </ul>
                </div>   
                <p><b>Entrance Test:</b> No</p>

                <!-- CTA Buttons -->
                <div class="hero-actions"> 
                 <button class="btn btn-success fee-btn" data-url="<?php echo LIVE_URL; ?>school-of-chemical-sciences/department-of-chemistry/bsc-in-chemistry-microbiology-and-biology.php"> Fees </button>
                 <p><a href="../school-of-chemical-sciences/department-of-chemistry/bsc-in-chemistry-microbiology-and-biology.php" target="_blank" class="btn btn-warning">Details</a></p>
                 <p><a href="https://sjuv4.linways.com/v4/adm-applicant/login" target="_blank" class="btn-outline">Apply Now</a></p>
                </div>
            </div>
            <!-- PROGRAM -->
            <div class="programme-box">
                <div class="d-flex gap-4 pgm_dtl">
                    <div class="program-icon icon-orange">
                      <i class="fa fa-book"></i>
                    </div>
                    <div>
                      <h5 class="text-blue fw-bold">Bachelor of Science (B.Sc.) in Chemistry, Zoology and Biotechnology</h5>
                      <p class="program-degree">UG Programme</p>
              
                    </div>
                </div>
                <div class="batch-info mb-4">
                    <ul class="list-unstyled batch-list">
                      <li class="batch-item">
                        <span>Batch </span>
                        <strong>9:00 AM to 4:00 PM</strong>
                      </li>  
                    </ul>
                </div>   
                <p><b>Entrance Test:</b> No</p>

                <!-- CTA Buttons -->
                <div class="hero-actions"> 
                 <button class="btn btn-success fee-btn" data-url="<?php echo LIVE_URL; ?>school-of-chemical-sciences/department-of-chemistry/bsc-in-chemistry-zoology-and-biotechnology.php"> Fees </button>
                 <p><a href="../school-of-chemical-sciences/department-of-chemistry/bsc-in-chemistry-zoology-and-biotechnology.php" target="_blank" class="btn btn-warning">Details</a></p>
                 <p><a href="https://sjuv4.linways.com/v4/adm-applicant/login" target="_blank" class="btn-outline">Apply Now</a></p>
                </div>
            </div>
            <!-- PROGRAM -->
            <div class="programme-box">
                <div class="d-flex gap-4 pgm_dtl">
                    <div class="program-icon icon-orange">
                      <i class="fa fa-book"></i>
                    </div>
                    <div>
                      <h5 class="text-blue fw-bold">Bachelor of Science (B.Sc.) in Biochemistry, Biology and Microbiology</h5>
                      <p class="program-degree">UG Programme</p>
              
                    </div>
                </div>
               <div class="batch-info mb-4">
                    <ul class="list-unstyled batch-list">
                      <li class="batch-item">
                        <span>Batch </span>
                        <strong>7:00 AM to 1:00 PM</strong>
                      </li>  
                    </ul>
                </div>   
                <p><b>Entrance Test:</b> No</p>

                <!-- CTA Buttons -->
                <div class="hero-actions"> 
                 <button class="btn btn-success fee-btn" data-url="<?php echo LIVE_URL; ?>school-of-chemical-sciences/department-of-biochemistry/bsc-in-biochemistry-biology-and-microbiology.php"> Fees </button>
                 <p><a href="../school-of-chemical-sciences/department-of-biochemistry/bsc-in-biochemistry-biology-and-microbiology.php" target="_blank" class="btn btn-warning">Details</a></p>
                 <p><a href="https://sjuv4.linways.com/v4/adm-applicant/login" target="_blank" class="btn-outline">Apply Now</a></p>
                </div>
            </div>
            <!-- PROGRAM -->
            <div class="programme-box">
                <div class="d-flex gap-4 pgm_dtl">
                    <div class="program-icon icon-orange">
                      <i class="fa fa-book"></i>
                    </div>
                    <div>
                      <h5 class="text-blue fw-bold">Bachelor of Science (B.Sc.) in Biochemistry, Botany and Biotechnology</h5>
                      <p class="program-degree">UG Programme</p>
              
                    </div>
                </div>
                <div class="batch-info mb-4">
                    <ul class="list-unstyled batch-list">
                      <li class="batch-item">
                        <span>Batch </span>
                        <strong>9:00 AM to 4:00 PM</strong>
                      </li>  
                    </ul>
                </div>   
                <p><b>Entrance Test:</b> No</p>

                <!-- CTA Buttons -->
                <div class="hero-actions"> 
                 <button class="btn btn-success fee-btn" data-url="<?php echo LIVE_URL; ?>school-of-chemical-sciences/department-of-biochemistry/bsc-in-biochemistry-botany-and-biotechnology.php"> Fees </button>
                 <p><a href="../school-of-chemical-sciences/department-of-biochemistry/bsc-in-biochemistry-botany-and-biotechnology.php" target="_blank" class="btn btn-warning">Details</a></p>
                 <p><a href="https://sjuv4.linways.com/v4/adm-applicant/login" target="_blank" class="btn-outline">Apply Now</a></p>
                </div>
            </div>
            <!-- PROGRAM -->
            <div class="programme-box">
                <div class="d-flex gap-4 pgm_dtl">
                    <div class="program-icon icon-orange">
                      <i class="fa fa-book"></i>
                    </div>
                    <div>
                      <h5 class="text-blue fw-bold">Bachelor of Science (B.Sc.) in Chemistry, Microbiology & Biotechnology</h5>
                      <p class="program-degree">UG Programme</p>
              
                    </div>
                </div>
                <div class="batch-info mb-4">
                    <ul class="list-unstyled batch-list">
                      <li class="batch-item">
                        <span>Batch </span>
                        <strong>9:00 AM to 4:00 PM</strong>
                      </li>  
                    </ul>
                </div>   
                <p><b>Entrance Test:</b> No</p>

                <!-- CTA Buttons -->
                <div class="hero-actions"> 
                 <button class="btn btn-success fee-btn" data-url="<?php echo LIVE_URL; ?>school-of-chemical-sciences/department-of-chemistry/bsc-in-chemistry-microbiology-and-biotechnology.php"> Fees </button>
                 <p><a href="../school-of-chemical-sciences/department-of-chemistry/bsc-in-chemistry-microbiology-and-biotechnology.php" target="_blank" class="btn btn-warning">Details</a></p>
                 <p><a href="https://sjuv4.linways.com/v4/adm-applicant/login" target="_blank" class="btn-outline">Apply Now</a></p>
                </div>
            </div>
            
            
        </div>
     </div>
     
     <div class="school-block" data-level="ug" data-school="humanities">
         <h3 class="text_blue fw-bold mb-3">School of Humanities & Social Sciences</h3>
         <div class="program-grid">

            <!-- PROGRAM -->
            <div class="programme-box">
                <div class="d-flex gap-4 pgm_dtl">
                    <div class="program-icon icon-orange">
                      <i class="fa fa-book"></i>
                    </div>
                    <div>
                      <h5 class="text-blue fw-bold">Bachelor of Science (B.Sc.) in Economics, Mathematics and Statistics</h5>
                      <p class="program-degree">UG Programme</p>
              
                    </div>
                </div>
                <div class="batch-info mb-4">
                    <ul class="list-unstyled batch-list">
                      <li class="batch-item">
                        <span>Batch </span>
                        <strong>9:00 AM to 4:00 PM</strong>
                      </li>  
                    </ul>
                </div>   
                <p><b>Entrance Test:</b> No</p>

                <!-- CTA Buttons -->
                <div class="hero-actions">
                 <button class="btn btn-success fee-btn" data-url="<?php echo LIVE_URL; ?>school-of-humanities-and-social-sciences/department-of-economics/bsc-in-economics-mathematics-and-statistics.php"> Fees </button>
                 <p><a href="../school-of-humanities-and-social-sciences/department-of-economics/bsc-in-economics-mathematics-and-statistics.php" target="_blank" class="btn btn-warning">Details</a></p>
                 <p><a href="https://sjuv4.linways.com/v4/adm-applicant/login" target="_blank" class="btn-outline">Apply Now</a></p>
                </div>
            </div>
            <!-- PROGRAM -->
            <div class="programme-box">
                <div class="d-flex gap-4 pgm_dtl">
                    <div class="program-icon icon-orange">
                      <i class="fa fa-book"></i>
                    </div>
                    <div>
                      <h5 class="text-blue fw-bold">Bachelor of Arts (B.A.) in Industrial Relations, Economics and Sociology</h5>
                      <p class="program-degree">UG Programme</p>
              
                    </div>
                </div>
                <div class="batch-info mb-4">
                    <ul class="list-unstyled batch-list">
                      <li class="batch-item">
                        <span>Batch </span>
                        <strong>9:00 AM to 4:00 PM</strong>
                      </li>  
                    </ul>
                </div>   
                <p><b>Entrance Test:</b> No</p>

                <!-- CTA Buttons -->
                <div class="hero-actions">
                 <button class="btn btn-success fee-btn" data-url="<?php echo LIVE_URL; ?>school-of-humanities-and-social-sciences/department-of-economics/ba-industrial-relations-economics-sociology.php"> Fees </button>
                 <p><a href="../school-of-humanities-and-social-sciences/department-of-economics/ba-industrial-relations-economics-sociology.php" target="_blank" class="btn btn-warning">Details</a></p>
                 <p><a href="https://sjuv4.linways.com/v4/adm-applicant/login" target="_blank" class="btn-outline">Apply Now</a></p>
                </div>
            </div>
            <!-- PROGRAM -->
            <div class="programme-box">
                <div class="d-flex gap-4 pgm_dtl">
                    <div class="program-icon icon-orange">
                      <i class="fa fa-book"></i>
                    </div>
                    <div>
                      <h5 class="text-blue fw-bold">Bachelor of Arts (B.A.) in Economics, Political Science and Sociology</h5>
                      <p class="program-degree">UG Programme</p>
              
                    </div>
                </div>
               <div class="batch-info mb-4">
                    <ul class="list-unstyled batch-list">
                      <li class="batch-item">
                        <span>Batch </span>
                        <strong>9:00 AM to 4:00 PM</strong>
                      </li>  
                    </ul>
                </div>   
                <p><b>Entrance Test:</b> No</p>

                <!-- CTA Buttons -->
                <div class="hero-actions">
                 <button class="btn btn-success fee-btn" data-url="<?php echo LIVE_URL; ?>school-of-humanities-and-social-sciences/department-of-economics/ba-in-economics-political-science-and-sociology.php"> Fees </button>
                 <p><a href="../school-of-humanities-and-social-sciences/department-of-economics/ba-in-economics-political-science-and-sociology.php" target="_blank" class="btn btn-warning">Details</a></p>
                 <p><a href="https://sjuv4.linways.com/v4/adm-applicant/login" target="_blank" class="btn-outline">Apply Now</a></p>
                </div>
            </div>
            <!-- PROGRAM -->
            <div class="programme-box">
                <div class="d-flex gap-4 pgm_dtl">
                    <div class="program-icon icon-orange">
                      <i class="fa fa-book"></i>
                    </div>
                    <div>
                      <h5 class="text-blue fw-bold">Bachelor of Arts (B.A.) in History, Political Science and Sociology</h5>
                      <p class="program-degree">UG Programme</p>
              
                    </div>
                </div>
                <div class="batch-info mb-4">
                    <ul class="list-unstyled batch-list">
                      <li class="batch-item">
                        <span>Batch </span>
                        <strong>9:00 AM to 4:00 PM</strong>
                      </li>  
                    </ul>
                </div>   
                <p><b>Entrance Test:</b> No</p>

                <!-- CTA Buttons -->
                <div class="hero-actions">
                 <button class="btn btn-success fee-btn" data-url="<?php echo LIVE_URL; ?>school-of-humanities-and-social-sciences/department-of-history/ba-in-history-political-science-and-sociology.php"> Fees </button>
                 <p><a href="../school-of-humanities-and-social-sciences/department-of-history/ba-in-history-political-science-and-sociology.php" target="_blank" class="btn btn-warning">Details</a></p>
                 <p><a href="https://sjuv4.linways.com/v4/adm-applicant/login" target="_blank" class="btn-outline">Apply Now</a></p>
                </div>
            </div>
            <!-- PROGRAM -->
            <div class="programme-box">
                <div class="d-flex gap-4 pgm_dtl">
                    <div class="program-icon icon-orange">
                      <i class="fa fa-book"></i>
                    </div>
                    <div>
                      <h5 class="text-blue fw-bold">Bachelor of Arts (B.A.) in International Relations and Peace Studies, Journalism & Public Policy</h5>
                      <p class="program-degree">UG Programme</p>
              
                    </div>
                </div>
                <div class="batch-info mb-4">
                    <ul class="list-unstyled batch-list">
                      <li class="batch-item">
                        <span>Batch </span>
                        <strong>9:00 AM to 4:00 PM</strong>
                      </li>  
                    </ul>
                </div>   
                <p><b>Entrance Test:</b> No</p>

                <!-- CTA Buttons -->
                <div class="hero-actions">
                 <button class="btn btn-success fee-btn" data-url="<?php echo LIVE_URL; ?>school-of-humanities-and-social-sciences/department-of-international-relations-peace-and-public-policy/ba-international-relations-and-peace-studies-journalism-and-public-policy.php"> Fees </button>
                 <p><a href="../school-of-humanities-and-social-sciences/department-of-international-relations-peace-and-public-policy/ba-international-relations-and-peace-studies-journalism-and-public-policy.php" target="_blank" class="btn btn-warning">Details</a></p>
                 <p><a href="https://sjuv4.linways.com/v4/adm-applicant/login" target="_blank" class="btn-outline">Apply Now</a></p>
                </div>
            </div>
            <!-- PROGRAM -->
            <div class="programme-box">
                <div class="d-flex gap-4 pgm_dtl">
                    <div class="program-icon icon-orange">
                      <i class="fa fa-book"></i>
                    </div>
                    <div>
                      <h5 class="text-blue fw-bold">	Bachelor of Arts (B.A.) in Journalism, Political Science and Sociology</h5>
                      <p class="program-degree">UG Programme</p>
              
                    </div>
                </div>
                <div class="batch-info mb-4">
                    <ul class="list-unstyled batch-list">
                      <li class="batch-item">
                        <span>Batch </span>
                        <strong>4:45 AM to 8:45 PM</strong>
                      </li>  
                    </ul>
                </div>   
                <p><b>Entrance Test:</b> No</p>

                <!-- CTA Buttons -->
                <div class="hero-actions">
                  <button class="btn btn-success fee-btn" data-url="<?php echo LIVE_URL; ?>school-of-humanities-and-social-sciences/department-of-political-science/ba-in-journalism-political-science-and-sociology.php"> Fees </button>
                 <p><a href="../school-of-humanities-and-social-sciences/department-of-political-science/ba-in-journalism-political-science-and-sociology.php" target="_blank" class="btn btn-warning">Details</a></p>
                 <p><a href="https://sjuv4.linways.com/v4/adm-applicant/login" target="_blank" class="btn-outline">Apply Now</a></p>
                </div>
            </div>
            <!-- PROGRAM -->
            <div class="programme-box">
                <div class="d-flex gap-4 pgm_dtl">
                    <div class="program-icon icon-orange">
                      <i class="fa fa-book"></i>
                    </div>
                    <div>
                      <h5 class="text-blue fw-bold">Bachelor of Arts (B.A.) in Communicative English, Political Science and Economics</h5>
                      <p class="program-degree">UG Programme</p>
              
                    </div>
                </div>
                <div class="batch-info mb-4">
                    <ul class="list-unstyled batch-list">
                      <li class="batch-item">
                        <span>Batch </span>
                        <strong>9:00 AM to 4:00 PM</strong>
                      </li>  
                    </ul>
                </div>   
                <p><b>Entrance Test:</b> No</p>

                <!-- CTA Buttons -->
                <div class="hero-actions"> 
                 <button class="btn btn-success fee-btn" data-url="<?php echo LIVE_URL; ?>school-of-humanities-and-social-sciences/department-of-political-science/ba-communicative-english-political-science-economics.php"> Fees </button>
                 <p><a href="../school-of-humanities-and-social-sciences/department-of-political-science/ba-communicative-english-political-science-economics.php" target="_blank" class="btn btn-warning">Details</a></p>
                 <p><a href="https://sjuv4.linways.com/v4/adm-applicant/login" target="_blank" class="btn-outline">Apply Now</a></p>
                </div>
            </div>
            <!-- PROGRAM -->
            <div class="programme-box">
                <div class="d-flex gap-4 pgm_dtl">
                    <div class="program-icon icon-orange">
                      <i class="fa fa-book"></i>
                    </div>
                    <div>
                      <h5 class="text-blue fw-bold">Bachelor of Arts (B.A.) in History, Economics and Political Science</h5>
                      <p class="program-degree">UG Programme</p>
              
                    </div>
                </div>
                <div class="batch-info mb-4">
                    <ul class="list-unstyled batch-list">
                      <li class="batch-item">
                        <span>Batch I</span>
                        <strong>9:00 AM to 4:00 PM</strong>
                      </li>  
                       <li class="batch-item">
                        <span>Batch II</span>
                        <strong>4:45 PM to 8:45 PM</strong>
                      </li>  
                    </ul>
                </div>   
                <p><b>Entrance Test:</b> No</p>

                <!-- CTA Buttons -->
                <div class="hero-actions"> 
                 <button class="btn btn-success fee-btn" data-url="<?php echo LIVE_URL; ?>school-of-humanities-and-social-sciences/department-of-political-science/ba-in-history-economics-and-political_science.php"> Fees </button>
                 <p><a href="../school-of-humanities-and-social-sciences/department-of-political-science/ba-in-history-economics-and-political_science.php" target="_blank" class="btn btn-warning">Details</a></p>
                 <p><a href="https://sjuv4.linways.com/v4/adm-applicant/login" target="_blank" class="btn-outline">Apply Now</a></p>
                </div>
            </div>
            <!-- PROGRAM -->
            <div class="programme-box">
                <div class="d-flex gap-4 pgm_dtl">
                    <div class="program-icon icon-orange">
                      <i class="fa fa-book"></i>
                    </div>
                    <div>
                      <h5 class="text-blue fw-bold">	Bachelor of Arts (B.A.) in Journalism, Economics & Psychology</h5>
                      <p class="program-degree">UG Programme</p>
              
                    </div>
                </div>
                <div class="batch-info mb-4">
                    <ul class="list-unstyled batch-list">
                      <li class="batch-item">
                        <span>Batch </span>
                        <strong>4:00 PM to 9:00 PM</strong>
                      </li>  
                    </ul>
                </div>   
                <p><b>Entrance Test:</b> No</p>

                <!-- CTA Buttons -->
                <div class="hero-actions"> 
                 <button class="btn btn-success fee-btn" data-url="<?php echo LIVE_URL; ?>school-of-humanities-and-social-sciences/department-of-psychology-and-counselling/ba-in-journalism-economics-and-psychology.php"> Fees </button>
                 <p><a href="../school-of-humanities-and-social-sciences/department-of-psychology-and-counselling/ba-in-journalism-economics-and-psychology.php" target="_blank" class="btn btn-warning">Details</a></p>
                 <p><a href="https://sjuv4.linways.com/v4/adm-applicant/login" target="_blank" class="btn-outline">Apply Now</a></p>
                </div>
            </div>
            <!-- PROGRAM -->
            <div class="programme-box">
                <div class="d-flex gap-4 pgm_dtl">
                    <div class="program-icon icon-orange">
                      <i class="fa fa-book"></i>
                    </div>
                    <div>
                      <h5 class="text-blue fw-bold">Bachelor of Arts (B.A.) in Optional English, Journalism and Psychology</h5>
                      <p class="program-degree">UG Programme</p>
              
                    </div>
                </div>
                <div class="batch-info mb-4">
                    <ul class="list-unstyled batch-list">
                      <li class="batch-item">
                        <span>Batch I </span>
                        <strong>7:00 AM to 1:00 PM </strong>
                      </li>  
                      <li class="batch-item">
                        <span>Batch II </span>
                        <strong> 9:00 AM to 4:00 PM </strong>
                      </li>  
                      <li class="batch-item">
                        <span>Block B (Bannerghatta)</span>
                        <strong>9:00 AM to 4:00 PM </strong>
                      </li>  
                    </ul>
                </div>   
                <p><b>Entrance Test:</b> Yes</p>

                <!-- CTA Buttons -->
                <div class="hero-actions"> 
                 <button class="btn btn-success fee-btn" data-url="<?php echo LIVE_URL; ?>school-of-humanities-and-social-sciences/department-of-psychology-and-counselling/ba-in-optional-english-journalism-and-psychology.php"> Fees </button>
                 <p><a href="../school-of-humanities-and-social-sciences/department-of-psychology-and-counselling/ba-in-optional-english-journalism-and-psychology.php" target="_blank" class="btn btn-warning">Details</a></p>
                 <p><a href="https://sjuv4.linways.com/v4/adm-applicant/login" target="_blank" class="btn-outline">Apply Now</a></p>
                </div>
            </div>
            <!-- PROGRAM -->
            <div class="programme-box">
                <div class="d-flex gap-4 pgm_dtl">
                    <div class="program-icon icon-orange">
                      <i class="fa fa-book"></i>
                    </div>
                    <div>
                      <h5 class="text-blue fw-bold">Bachelor of Arts (B.A.) in Theatre and Performance Studies, Optional English & Psychology</h5>
                      <p class="program-degree">UG Programme</p>
              
                    </div>
                </div>
                <div class="batch-info mb-4">
                    <ul class="list-unstyled batch-list">
                      <li class="batch-item">
                        <span>Batch  </span>
                        <strong>7:00 AM to 1:00 PM</strong>
                      </li>  
                    </ul>
                </div>   
                <p><b>Entrance Test:</b> No</p>

                <!-- CTA Buttons -->
                <div class="hero-actions"> 
                 <button class="btn btn-success fee-btn" data-url="<?php echo LIVE_URL; ?>school-of-humanities-and-social-sciences/department-of-psychology-and-counselling/ba-in-theatre-and-performance-studies-optional-english-and-psychology.php"> Fees </button>
                 <p><a href="../school-of-humanities-and-social-sciences/department-of-psychology-and-counselling/ba-in-theatre-and-performance-studies-optional-english-and-psychology.php" target="_blank" class="btn btn-warning">Details</a></p>
                 <p><a href="https://sjuv4.linways.com/v4/adm-applicant/login" target="_blank" class="btn-outline">Apply Now</a></p>
                </div>
            </div> 
        </div>
     </div>
     <!--SCHOOL-->
     <div class="school-block" data-level="ug" data-school="language">
         <h3 class="text_blue fw-bold mb-3">School of Languages & Literatures</h3>
         <div class="program-grid">

            <!-- PROGRAM -->
            <div class="programme-box">
                <div class="d-flex gap-4 pgm_dtl">
                    <div class="program-icon icon-orange">
                      <i class="fa fa-book"></i>
                    </div>
                    <div>
                      <h5 class="text-blue fw-bold">Bachelor of Arts (B.A.) in International Relations and Peace Studies, Journalism & Public Policy</h5>
                      <p class="program-degree">UG Programme</p>
              
                    </div>
                </div>
                <div class="batch-info mb-4">
                    <ul class="list-unstyled batch-list">
                      <li class="batch-item">
                        <span>Batch </span>
                        <strong>9:00 AM to 4:00 PM</strong>
                      </li>  
                    </ul>
                </div>   
                <p><b>Entrance Test:</b> No</p>

                <!-- CTA Buttons -->
                <div class="hero-actions">
                 <button class="btn btn-success fee-btn" data-url="<?php echo LIVE_URL; ?>school-of-languages-and-literatures/department-of-journalism/ba-international-relations-and-peace-studies-journalism-and-public-policy.php"> Fees </button>
                 <p><a href="../school-of-languages-and-literatures/department-of-journalism/ba-international-relations-and-peace-studies-journalism-and-public-policy.php" target="_blank" class="btn btn-warning">Details</a></p>
                 <p><a href="https://sjuv4.linways.com/v4/adm-applicant/login" target="_blank" class="btn-outline">Apply Now</a></p>
                </div>
            </div> 
            <!-- PROGRAM -->
            <div class="programme-box">
                <div class="d-flex gap-4 pgm_dtl">
                    <div class="program-icon icon-orange">
                      <i class="fa fa-book"></i>
                    </div>
                    <div>
                      <h5 class="text-blue fw-bold">Bachelor of Arts (B.A.) in Journalism, Political Science and Sociology</h5>
                      <p class="program-degree">UG Programme</p>
              
                    </div>
                </div>
                <div class="batch-info mb-4">
                    <ul class="list-unstyled batch-list">
                      <li class="batch-item">
                        <span>Batch </span>
                        <strong>4:45 PM to 8:45 PM</strong>
                      </li>  
                    </ul>
                </div>   
                <p><b>Entrance Test:</b> No</p>

                <!-- CTA Buttons -->
                <div class="hero-actions">
                 <button class="btn btn-success fee-btn" data-url="<?php echo LIVE_URL; ?>school-of-languages-and-literatures/department-of-journalism/ba-in-journalism-political-science-and-sociology.php"> Fees </button>
                 <p><a href="../school-of-languages-and-literatures/department-of-journalism/ba-in-journalism-political-science-and-sociology.php" target="_blank" class="btn btn-warning">Details</a></p>
                 <p><a href="https://sjuv4.linways.com/v4/adm-applicant/login" target="_blank" class="btn-outline">Apply Now</a></p>
                </div>
            </div> 
            <!-- PROGRAM -->
            <div class="programme-box">
                <div class="d-flex gap-4 pgm_dtl">
                    <div class="program-icon icon-orange">
                      <i class="fa fa-book"></i>
                    </div>
                    <div>
                      <h5 class="text-blue fw-bold">Bachelor of Arts (B.A.) in Communicative English, Political Science and Economics</h5>
                      <p class="program-degree">UG Programme</p>
              
                    </div>
                </div>
                <div class="batch-info mb-4">
                    <ul class="list-unstyled batch-list">
                      <li class="batch-item">
                        <span>Batch </span>
                        <strong>9:00 AM to 4:00 PM</strong>
                      </li>  
                    </ul>
                </div>   
                <p><b>Entrance Test:</b> No</p>

                <!-- CTA Buttons -->
                <div class="hero-actions">
                 <button class="btn btn-success fee-btn" data-url="<?php echo LIVE_URL; ?>school-of-languages-and-literatures/department-of-english/ba-communicative-english-political-science-economics.php"> Fees </button>
                 <p><a href="../school-of-languages-and-literatures/department-of-english/ba-communicative-english-political-science-economics.php" target="_blank" class="btn btn-warning">Details</a></p>
                 <p><a href="https://sjuv4.linways.com/v4/adm-applicant/login" target="_blank" class="btn-outline">Apply Now</a></p>
                </div>
            </div> 
            <!-- PROGRAM -->
            <div class="programme-box">
                <div class="d-flex gap-4 pgm_dtl">
                    <div class="program-icon icon-orange">
                      <i class="fa fa-book"></i>
                    </div>
                    <div>
                      <h5 class="text-blue fw-bold">Bachelor of Arts (B.A.) in Journalism, Economics & Psychology</h5>
                      <p class="program-degree">UG Programme</p>
              
                    </div>
                </div>
                <div class="batch-info mb-4">
                    <ul class="list-unstyled batch-list">
                      <li class="batch-item">
                        <span>Batch </span>
                        <strong>4:00 PM to 9:00 PM</strong>
                      </li>  
                    </ul>
                </div>   
                <p><b>Entrance Test:</b> No</p>

                <!-- CTA Buttons -->
                <div class="hero-actions">
                 <button class="btn btn-success fee-btn" data-url="<?php echo LIVE_URL; ?>school-of-languages-and-literatures/department-of-english/ba-in-journalism-economics-and-psychology.php"> Fees </button>
                 <p><a href="../school-of-languages-and-literatures/department-of-english/ba-in-journalism-economics-and-psychology.php" target="_blank" class="btn btn-warning">Details</a></p>
                 <p><a href="https://sjuv4.linways.com/v4/adm-applicant/login" target="_blank" class="btn-outline">Apply Now</a></p>
                </div>
            </div> 
            <!-- PROGRAM -->
            <div class="programme-box">
                <div class="d-flex gap-4 pgm_dtl">
                    <div class="program-icon icon-orange">
                      <i class="fa fa-book"></i>
                    </div>
                    <div>
                      <h5 class="text-blue fw-bold">Bachelor of Arts (B.A.) in Optional English, Journalism and Psychology</h5>
                      <p class="program-degree">UG Programme</p>
              
                    </div>
                </div>
                <div class="batch-info mb-4">
                    <ul class="list-unstyled batch-list">
                      <li class="batch-item">
                        <span>Batch I</span>
                        <strong> 7:00 AM to 1:00 PM</strong>
                      </li>  
                      <li class="batch-item">
                        <span>Batch I|</span>
                        <strong>9:00 AM to 4:00 PM</strong>
                      </li>  
                      <li class="batch-item">
                        <span>Block B (Bannerghatta)</span>
                        <strong> 9:00 AM to 4:00 PM</strong>
                      </li>  
                    </ul>
                </div>   
                <p><b>Entrance Test:</b> Yes</p>

                <!-- CTA Buttons -->
                <div class="hero-actions">
                 <button class="btn btn-success fee-btn" data-url="<?php echo LIVE_URL; ?>school-of-languages-and-literatures/department-of-english/ba-in-optional-english-journalism-and-psychology.php"> Fees </button>
                 <p><a href="../school-of-languages-and-literatures/department-of-english/ba-in-optional-english-journalism-and-psychology.php" target="_blank" class="btn btn-warning">Details</a></p>
                 <p><a href="https://sjuv4.linways.com/v4/adm-applicant/login" target="_blank" class="btn-outline">Apply Now</a></p>
                </div>
            </div> 
            <!-- PROGRAM -->
            <div class="programme-box">
                <div class="d-flex gap-4 pgm_dtl">
                    <div class="program-icon icon-orange">
                      <i class="fa fa-book"></i>
                    </div>
                    <div>
                      <h5 class="text-blue fw-bold">Bachelor of Arts (B.A.) in Theatre and Performance Studies, Optional English & Psychology</h5>
                      <p class="program-degree">UG Programme</p>
              
                    </div>
                </div>
                <div class="batch-info mb-4">
                    <ul class="list-unstyled batch-list">
                      <li class="batch-item">
                        <span>Batch </span>
                        <strong> 7:00 AM to 1:00 PM</strong>
                      </li>  
                    </ul>
                </div>   
                <p><b>Entrance Test:</b> No</p>

                <!-- CTA Buttons -->
                <div class="hero-actions">
                 <button class="btn btn-success fee-btn" data-url="<?php echo LIVE_URL; ?>school-of-languages-and-literatures/department-of-english/ba-in-theatre-and-performance-studies-optional-english-and-psychology.php"> Fees </button>
                 <p><a href="../school-of-languages-and-literatures/department-of-english/ba-in-theatre-and-performance-studies-optional-english-and-psychology.php" target="_blank" class="btn btn-warning">Details</a></p>
                 <p><a href="https://sjuv4.linways.com/v4/adm-applicant/login" target="_blank" class="btn-outline">Apply Now</a></p>
                </div>
            </div>  
        </div>
     </div>
     
     <!--SCHOOL-->
     <div class="school-block" data-level="ug" data-school="life_sciences">
         <h3 class="text_blue fw-bold mb-3">School of Life Sciences</h3>
         <div class="program-grid">

            <!-- PROGRAM -->
            <div class="programme-box">
                <div class="d-flex gap-4 pgm_dtl">
                    <div class="program-icon icon-orange">
                      <i class="fa fa-book"></i>
                    </div>
                    <div>
                      <h5 class="text-blue fw-bold">Bachelor of Science (B.Sc.) in Chemistry, Biotechnology and Biology</h5>
                      <p class="program-degree">UG Programme</p>
              
                    </div>
                </div>
                <div class="batch-info mb-4">
                    <ul class="list-unstyled batch-list">
                      <li class="batch-item">
                        <span>Batch </span>
                        <strong>9:00 AM to 4:00 PM</strong>
                      </li>  
                    </ul>
                </div>   
                <p><b>Entrance Test:</b> No</p>

                <!-- CTA Buttons -->
                <div class="hero-actions">
                 <button class="btn btn-success fee-btn" data-url="<?php echo LIVE_URL; ?>school-of-life-sciences/department-of-biology/bsc-in-chemistry-biotechnology-and-biology.php"> Fees </button>
                 <p><a href="../school-of-life-sciences/department-of-biology/bsc-in-chemistry-biotechnology-and-biology.php" target="_blank" class="btn btn-warning">Details</a></p>
                 <p><a href="https://sjuv4.linways.com/v4/adm-applicant/login" target="_blank" class="btn-outline">Apply Now</a></p>
                </div>
            </div> 
            <!-- PROGRAM -->
            <div class="programme-box">
                <div class="d-flex gap-4 pgm_dtl">
                    <div class="program-icon icon-orange">
                      <i class="fa fa-book"></i>
                    </div>
                    <div>
                      <h5 class="text-blue fw-bold">Bachelor of Science (B.Sc.) in Biochemistry, Biology and Biotechnology</h5>
                      <p class="program-degree">UG Programme</p>
              
                    </div>
                </div>
                <div class="batch-info mb-4">
                    <ul class="list-unstyled batch-list">
                      <li class="batch-item">
                        <span>Batch </span>
                        <strong>7:00 AM to 1:00 PM</strong>
                      </li>  
                    </ul>
                </div>   
                <p><b>Entrance Test:</b> No</p>

                <!-- CTA Buttons -->
                <div class="hero-actions">
                 <button class="btn btn-success fee-btn" data-url="<?php echo LIVE_URL; ?>school-of-life-sciences/department-of-biology/bsc-in-biochemistry-Biology-and-biotechnology.php"> Fees </button>
                 <p><a href="../school-of-life-sciences/department-of-biology/bsc-in-biochemistry-Biology-and-biotechnology.php" target="_blank" class="btn btn-warning">Details</a></p>
                 <p><a href="https://sjuv4.linways.com/v4/adm-applicant/login" target="_blank" class="btn-outline">Apply Now</a></p>
                </div>
            </div> 
            <!-- PROGRAM -->
            <div class="programme-box">
                <div class="d-flex gap-4 pgm_dtl">
                    <div class="program-icon icon-orange">
                      <i class="fa fa-book"></i>
                    </div>
                    <div>
                      <h5 class="text-blue fw-bold">Bachelor of Science (B.Sc.) in Biochemistry, Microbiology and Zoology</h5>
                      <p class="program-degree">UG Programme</p>
              
                    </div>
                </div>
                <div class="batch-info mb-4">
                    <ul class="list-unstyled batch-list">
                      <li class="batch-item">
                        <span>Batch </span>
                        <strong> 7:00 AM to 1:00 PM</strong>
                      </li>  
                    </ul>
                </div>   
                <p><b>Entrance Test:</b> No</p>

                <!-- CTA Buttons -->
                <div class="hero-actions">
                 <button class="btn btn-success fee-btn" data-url="<?php echo LIVE_URL; ?>school-of-life-sciences/department-of-microbiology/bsc-in-biochemistry-microbiology-and-zoology.php"> Fees </button>
                 <p><a href="../school-of-life-sciences/department-of-microbiology/bsc-in-biochemistry-microbiology-and-zoology.php" target="_blank" class="btn btn-warning">Details</a></p>
                 <p><a href="https://sjuv4.linways.com/v4/adm-applicant/login" target="_blank" class="btn-outline">Apply Now</a></p>
                </div>
            </div> 
            <!-- PROGRAM -->
            <div class="programme-box">
                <div class="d-flex gap-4 pgm_dtl">
                    <div class="program-icon icon-orange">
                      <i class="fa fa-book"></i>
                    </div>
                    <div>
                      <h5 class="text-blue fw-bold">Bachelor of Science (B.Sc.) in Biochemistry, Biotechnology and Zoology</h5>
                      <p class="program-degree">UG Programme</p>
              
                    </div>
                </div>
                <div class="batch-info mb-4">
                    <ul class="list-unstyled batch-list">
                      <li class="batch-item">
                        <span>Batch </span>
                        <strong>7:00 AM to 1:00 PM</strong>
                      </li>  
                    </ul>
                </div>   
                <p><b>Entrance Test:</b> No</p>

                <!-- CTA Buttons -->
                <div class="hero-actions">
                 <button class="btn btn-success fee-btn" data-url="<?php echo LIVE_URL; ?>school-of-life-sciences/department-of-biotechnology/bsc-in-biochemistry-biotechnology-and-zoology.php"> Fees </button>
                 <p><a href="../school-of-life-sciences/department-of-biotechnology/bsc-in-biochemistry-biotechnology-and-zoology.php" target="_blank" class="btn btn-warning">Details</a></p>
                 <p><a href="https://sjuv4.linways.com/v4/adm-applicant/login" target="_blank" class="btn-outline">Apply Now</a></p>
                </div>
            </div> 
            <!-- PROGRAM -->
            <div class="programme-box">
                <div class="d-flex gap-4 pgm_dtl">
                    <div class="program-icon icon-orange">
                      <i class="fa fa-book"></i>
                    </div>
                    <div>
                      <h5 class="text-blue fw-bold">Bachelor of Science (B.Sc.) in Chemistry, Botany and Zoology</h5>
                      <p class="program-degree">UG Programme</p>
              
                    </div>
                </div>
                <div class="batch-info mb-4">
                    <ul class="list-unstyled batch-list">
                      <li class="batch-item">
                        <span>Batch </span>
                        <strong> 9:00 AM to 4:00 PM</strong>
                      </li>  
                    </ul>
                </div>   
                <p><b>Entrance Test:</b> No</p>

                <!-- CTA Buttons -->
                <div class="hero-actions">
                 <button class="btn btn-success fee-btn" data-url="<?php echo LIVE_URL; ?>school-of-life-sciences/department-of-botany/bsc-in-chemistry-botany-and-zoology.php"> Fees </button>
                 <p><a href="../school-of-life-sciences/department-of-botany/bsc-in-chemistry-botany-and-zoology.php" target="_blank" class="btn btn-warning">Details</a></p>
                 <p><a href="https://sjuv4.linways.com/v4/adm-applicant/login" target="_blank" class="btn-outline">Apply Now</a></p>
                </div>
            </div> 
            <!-- PROGRAM -->
            <div class="programme-box">
                <div class="d-flex gap-4 pgm_dtl">
                    <div class="program-icon icon-orange">
                      <i class="fa fa-book"></i>
                    </div>
                    <div>
                      <h5 class="text-blue fw-bold">Bachelor of Science (B.Sc.) in Chemistry, Environmental Science and Biology</h5>
                      <p class="program-degree">UG Programme</p>
              
                    </div>
                </div>
                <div class="batch-info mb-4">
                    <ul class="list-unstyled batch-list">
                      <li class="batch-item">
                        <span>Batch </span>
                        <strong> 9:00 AM to 4:00 PM</strong>
                      </li>  
                    </ul>
                </div>   
                <p><b>Entrance Test:</b> No</p>

                <!-- CTA Buttons -->
                <div class="hero-actions">
                 <button class="btn btn-success fee-btn" data-url="<?php echo LIVE_URL; ?>school-of-life-sciences/department-of-environmental-science/bsc-in-chemistry-environmental-science-and-biology.php"> Fees </button>
                 <p><a href="../school-of-life-sciences/department-of-environmental-science/bsc-in-chemistry-environmental-science-and-biology.php" target="_blank" class="btn btn-warning">Details</a></p>
                 <p><a href="https://sjuv4.linways.com/v4/adm-applicant/login" target="_blank" class="btn-outline">Apply Now</a></p>
                </div>
            </div>  
            <!-- PROGRAM -->
            <div class="programme-box">
                <div class="d-flex gap-4 pgm_dtl">
                    <div class="program-icon icon-orange">
                      <i class="fa fa-book"></i>
                    </div>
                    <div>
                      <h5 class="text-blue fw-bold">Bachelor of Science (B.Sc.) in Chemistry, Microbiology and Biology</h5>
                      <p class="program-degree">UG Programme</p>
              
                    </div>
                </div>
                <div class="batch-info mb-4">
                    <ul class="list-unstyled batch-list">
                      <li class="batch-item">
                        <span>Batch </span>
                        <strong> 9:00 AM to 4:00 PM</strong>
                      </li>  
                    </ul>
                </div>   
                <p><b>Entrance Test:</b> No</p>

                <!-- CTA Buttons -->
                <div class="hero-actions">
                 <button class="btn btn-success fee-btn" data-url="<?php echo LIVE_URL; ?>school-of-life-sciences/department-of-microbiology/bsc-in-chemistry-microbiology-and-biology.php"> Fees </button>
                 <p><a href="../school-of-life-sciences/department-of-microbiology/bsc-in-chemistry-microbiology-and-biology.php" target="_blank" class="btn btn-warning">Details</a></p>
                 <p><a href="https://sjuv4.linways.com/v4/adm-applicant/login" target="_blank" class="btn-outline">Apply Now</a></p>
                </div>
            </div>  
             <!-- PROGRAM -->
            <div class="programme-box">
                <div class="d-flex gap-4 pgm_dtl">
                    <div class="program-icon icon-orange">
                      <i class="fa fa-book"></i>
                    </div>
                    <div>
                      <h5 class="text-blue fw-bold">Bachelor of Science (B.Sc.) in Chemistry, Zoology and Biotechnology</h5>
                      <p class="program-degree">UG Programme</p>
              
                    </div>
                </div>
                <div class="batch-info mb-4">
                    <ul class="list-unstyled batch-list">
                      <li class="batch-item">
                        <span>Batch </span>
                        <strong> 9:00 AM to 4:00 PM</strong>
                      </li>  
                    </ul>
                </div>   
                <p><b>Entrance Test:</b> No</p>

                <!-- CTA Buttons -->
                <div class="hero-actions">
                 <button class="btn btn-success fee-btn" data-url="<?php echo LIVE_URL; ?>school-of-life-sciences/department-of-biotechnology/bsc-in-chemistry-zoology-and-biotechnology.php"> Fees </button>
                 <p><a href="../school-of-life-sciences/department-of-biotechnology/bsc-in-chemistry-zoology-and-biotechnology.php" target="_blank" class="btn btn-warning">Details</a></p>
                 <p><a href="https://sjuv4.linways.com/v4/adm-applicant/login" target="_blank" class="btn-outline">Apply Now</a></p>
                </div>
            </div>  
             <!-- PROGRAM -->
            <div class="programme-box">
                <div class="d-flex gap-4 pgm_dtl">
                    <div class="program-icon icon-orange">
                      <i class="fa fa-book"></i>
                    </div>
                    <div>
                      <h5 class="text-blue fw-bold">Bachelor of Science (B.Sc.) in Biochemistry, Biology and Microbiology</h5>
                      <p class="program-degree">UG Programme</p>
              
                    </div>
                </div>
                <div class="batch-info mb-4">
                    <ul class="list-unstyled batch-list">
                      <li class="batch-item">
                        <span>Batch </span>
                        <strong>  7:00 AM to 1:00 PM</strong>
                      </li>  
                    </ul>
                </div>   
                <p><b>Entrance Test:</b> No</p>

                <!-- CTA Buttons -->
                <div class="hero-actions">
                 <button class="btn btn-success fee-btn" data-url="<?php echo LIVE_URL; ?>school-of-life-sciences/department-of-microbiology/bsc-in-biochemistry-biology-and-microbiology.php"> Fees </button>
                 <p><a href="../school-of-life-sciences/department-of-microbiology/bsc-in-biochemistry-biology-and-microbiology.php" target="_blank" class="btn btn-warning">Details</a></p>
                 <p><a href="https://sjuv4.linways.com/v4/adm-applicant/login" target="_blank" class="btn-outline">Apply Now</a></p>
                </div>
            </div>  
             <!-- PROGRAM -->
            <div class="programme-box">
                <div class="d-flex gap-4 pgm_dtl">
                    <div class="program-icon icon-orange">
                      <i class="fa fa-book"></i>
                    </div>
                    <div>
                      <h5 class="text-blue fw-bold">Bachelor of Science (B.Sc.) in Biochemistry, Botany and Biotechnology</h5>
                      <p class="program-degree">UG Programme</p>
              
                    </div>
                </div>
                <div class="batch-info mb-4">
                    <ul class="list-unstyled batch-list">
                      <li class="batch-item">
                        <span>Batch </span>
                        <strong>  9:00 AM to 4:00 PM</strong>
                      </li>  
                    </ul>
                </div>   
                <p><b>Entrance Test:</b> No</p>

                <!-- CTA Buttons -->
                <div class="hero-actions">
                 <button class="btn btn-success fee-btn" data-url="<?php echo LIVE_URL; ?>school-of-life-sciences/department-of-botany/bsc-in-biochemistry-botany-and-biotechnology.php"> Fees </button>
                 <p><a href="../school-of-life-sciences/department-of-botany/bsc-in-biochemistry-botany-and-biotechnology.php" target="_blank" class="btn btn-warning">Details</a></p>
                 <p><a href="https://sjuv4.linways.com/v4/adm-applicant/login" target="_blank" class="btn-outline">Apply Now</a></p>
                </div>
            </div>  
            <!-- PROGRAM -->
            <div class="programme-box">
                <div class="d-flex gap-4 pgm_dtl">
                    <div class="program-icon icon-orange">
                      <i class="fa fa-book"></i>
                    </div>
                    <div>
                      <h5 class="text-blue fw-bold">Bachelor of Science (B.Sc.) in Botany, Environmental Science and Zoology</h5>
                      <p class="program-degree">UG Programme</p>
              
                    </div>
                </div>
                <div class="batch-info mb-4">
                    <ul class="list-unstyled batch-list">
                      <li class="batch-item">
                        <span>Batch </span>
                        <strong>  9:00 AM to 4:00 PM</strong>
                      </li>  
                    </ul>
                </div>   
                <p><b>Entrance Test:</b> No</p>

                <!-- CTA Buttons -->
                <div class="hero-actions">
                 <button class="btn btn-success fee-btn" data-url="<?php echo LIVE_URL; ?>school-of-life-sciences/department-of-botany/bsc-in-botany-environmental-science-and-zoology.php"> Fees </button>
                 <p><a href="../school-of-life-sciences/department-of-botany/bsc-in-botany-environmental-science-and-zoology.php" target="_blank" class="btn btn-warning">Details</a></p>
                 <p><a href="https://sjuv4.linways.com/v4/adm-applicant/login" target="_blank" class="btn-outline">Apply Now</a></p>
                </div>
            </div>  
            <!-- PROGRAM -->
            <div class="programme-box">
                <div class="d-flex gap-4 pgm_dtl">
                    <div class="program-icon icon-orange">
                      <i class="fa fa-book"></i>
                    </div>
                    <div>
                      <h5 class="text-blue fw-bold">	Bachelor of Science (B.Sc.) in Chemistry, Microbiology & Biotechnology</h5>
                      <p class="program-degree">UG Programme</p>
              
                    </div>
                </div>
                <div class="batch-info mb-4">
                    <ul class="list-unstyled batch-list">
                      <li class="batch-item">
                        <span>Batch </span>
                        <strong>  9:00 AM to 4:00 PM</strong>
                      </li>  
                    </ul>
                </div>   
                <p><b>Entrance Test:</b> No</p>

                <!-- CTA Buttons -->
                <div class="hero-actions">
                 <button class="btn btn-success fee-btn" data-url="<?php echo LIVE_URL; ?>school-of-life-sciences/department-of-microbiology/bsc-in-chemistry-microbiology-and-biotechnology.php"> Fees </button>
                 <p><a href="../school-of-life-sciences/department-of-microbiology/bsc-in-chemistry-microbiology-and-biotechnology.php" target="_blank" class="btn btn-warning">Details</a></p>
                 <p><a href="https://sjuv4.linways.com/v4/adm-applicant/login" target="_blank" class="btn-outline">Apply Now</a></p>
                </div>
            </div>   
        </div>
     </div>
     <!--SCHOOL-->
     <div class="school-block" data-level="ug" data-school="physical_science">
         <h3 class="text_blue fw-bold mb-3">School of Physical Sciences</h3>
         <div class="program-grid">

            <!-- PROGRAM -->
            <div class="programme-box">
                <div class="d-flex gap-4 pgm_dtl">
                    <div class="program-icon icon-orange">
                      <i class="fa fa-book"></i>
                    </div>
                    <div>
                      <h5 class="text-blue fw-bold">Bachelor of Science (B.Sc.) in Physics, Mathematics and Computer Science</h5>
                      <p class="program-degree">UG Programme</p>
              
                    </div>
                </div>
                <div class="batch-info mb-4">
                    <ul class="list-unstyled batch-list">
                      <li class="batch-item">
                        <span>Batch </span>
                        <strong>9:00 AM to 4:00 PM</strong>
                      </li>  
                    </ul>
                </div>   
                <p><b>Entrance Test:</b> No</p>

                <!-- CTA Buttons -->
                <div class="hero-actions">
                 <button class="btn btn-success fee-btn" data-url="<?php echo LIVE_URL; ?>school-of-physical-sciences/department-of-physics/bsc-in-physics-mathematics-computer-science.php"> Fees </button>
                 <p><a href="../school-of-physical-sciences/department-of-physics/bsc-in-physics-mathematics-computer-science.php" target="_blank" class="btn btn-warning">Details</a></p>
                 <p><a href="https://sjuv4.linways.com/v4/adm-applicant/login" target="_blank" class="btn-outline">Apply Now</a></p>
                </div>
            </div> 
            <!-- PROGRAM -->
            <div class="programme-box">
                <div class="d-flex gap-4 pgm_dtl">
                    <div class="program-icon icon-orange">
                      <i class="fa fa-book"></i>
                    </div>
                    <div>
                      <h5 class="text-blue fw-bold">Bachelor of Science (B.Sc.) in Economics, Mathematics and Statistics</h5>
                      <p class="program-degree">UG Programme</p>
              
                    </div>
                </div>
                <div class="batch-info mb-4">
                    <ul class="list-unstyled batch-list">
                      <li class="batch-item">
                        <span>Batch </span>
                        <strong>9:00 AM to 4:00 PM</strong>
                      </li>  
                    </ul>
                </div>   
                <p><b>Entrance Test:</b> No</p>

                <!-- CTA Buttons -->
                <div class="hero-actions">
                 <button class="btn btn-success fee-btn" data-url="<?php echo LIVE_URL; ?>school-of-physical-sciences/department-of-mathematics/bsc-in-economics-mathematics-and-statistics.php"> Fees </button>
                 <p><a href="../school-of-physical-sciences/department-of-mathematics/bsc-in-economics-mathematics-and-statistics.php" target="_blank" class="btn btn-warning">Details</a></p>
                 <p><a href="https://sjuv4.linways.com/v4/adm-applicant/login" target="_blank" class="btn-outline">Apply Now</a></p>
                </div>
            </div> 
            <!-- PROGRAM -->
            <div class="programme-box">
                <div class="d-flex gap-4 pgm_dtl">
                    <div class="program-icon icon-orange">
                      <i class="fa fa-book"></i>
                    </div>
                    <div>
                      <h5 class="text-blue fw-bold">Bachelor of Science (B.Sc.) in Mathematics, Electronics and Computer Science</h5>
                      <p class="program-degree">UG Programme</p>
              
                    </div>
                </div>
                <div class="batch-info mb-4">
                    <ul class="list-unstyled batch-list">
                      <li class="batch-item">
                        <span>Batch </span>
                        <strong> 9:00 AM to 4:00 PM</strong>
                      </li>  
                    </ul>
                </div>   
                <p><b>Entrance Test:</b> No</p>

                <!-- CTA Buttons -->
                <div class="hero-actions">
                 <button class="btn btn-success fee-btn" data-url="<?php echo LIVE_URL; ?>school-of-physical-sciences/department-of-mathematics/bsc-in-mathematics-electronics-computer-science.php"> Fees </button>
                 <p><a href="../school-of-physical-sciences/department-of-mathematics/bsc-in-mathematics-electronics-computer-science.php" target="_blank" class="btn btn-warning">Details</a></p>
                 <p><a href="https://sjuv4.linways.com/v4/adm-applicant/login" target="_blank" class="btn-outline">Apply Now</a></p>
                </div>
            </div> 
            <!-- PROGRAM -->
            <div class="programme-box">
                <div class="d-flex gap-4 pgm_dtl">
                    <div class="program-icon icon-orange">
                      <i class="fa fa-book"></i>
                    </div>
                    <div>
                      <h5 class="text-blue fw-bold">Bachelor of Science (B.Sc.) in Physics, Chemistry and Mathematics</h5>
                      <p class="program-degree">UG Programme</p>
              
                    </div>
                </div>
                <div class="batch-info mb-4">
                    <ul class="list-unstyled batch-list">
                      <li class="batch-item">
                        <span>Batch </span>
                        <strong>9:00 AM to 4:00 PM</strong>
                      </li>  
                    </ul>
                </div>   
                <p><b>Entrance Test:</b> No</p>

                <!-- CTA Buttons -->
                <div class="hero-actions">
                 <button class="btn btn-success fee-btn" data-url="<?php echo LIVE_URL; ?>school-of-physical-sciences/department-of-physics/bsc-in-physics-chemistry-and-mathematics.php"> Fees </button>
                 <p><a href="../school-of-physical-sciences/department-of-physics/bsc-in-physics-chemistry-and-mathematics.php" target="_blank" class="btn btn-warning">Details</a></p>
                 <p><a href="https://sjuv4.linways.com/v4/adm-applicant/login" target="_blank" class="btn-outline">Apply Now</a></p>
                </div>
            </div> 
            <!-- PROGRAM -->
            <div class="programme-box">
                <div class="d-flex gap-4 pgm_dtl">
                    <div class="program-icon icon-orange">
                      <i class="fa fa-book"></i>
                    </div>
                    <div>
                      <h5 class="text-blue fw-bold">Bachelor of Science (B.Sc.) in Physics, Electronics and Mathematics</h5>
                      <p class="program-degree">UG Programme</p>
              
                    </div>
                </div>
                <div class="batch-info mb-4">
                    <ul class="list-unstyled batch-list">
                      <li class="batch-item">
                        <span>Batch </span>
                        <strong> 9:00 AM to 4:00 PM</strong>
                      </li>  
                    </ul>
                </div>   
                <p><b>Entrance Test:</b> No</p>

                <!-- CTA Buttons -->
                <div class="hero-actions">
                 <button class="btn btn-success fee-btn" data-url="<?php echo LIVE_URL; ?>school-of-physical-sciences/department-of-physics/bsc-in-physics-electronics-mathematics.php"> Fees </button>
                 <p><a href="../school-of-physical-sciences/department-of-physics/bsc-in-physics-electronics-mathematics.php" target="_blank" class="btn btn-warning">Details</a></p>
                 <p><a href="https://sjuv4.linways.com/v4/adm-applicant/login" target="_blank" class="btn-outline">Apply Now</a></p>
                </div>
            </div> 
            <!-- PROGRAM -->
            <div class="programme-box">
                <div class="d-flex gap-4 pgm_dtl">
                    <div class="program-icon icon-orange">
                      <i class="fa fa-book"></i>
                    </div>
                    <div>
                      <h5 class="text-blue fw-bold">Bachelor of Science (B.Sc.) in Computer Science, Mathematics and Statistics</h5>
                      <p class="program-degree">UG Programme</p>
              
                    </div>
                </div>
                <div class="batch-info mb-4">
                    <ul class="list-unstyled batch-list">
                      <li class="batch-item">
                        <span>Batch </span>
                        <strong> 7:00 AM to 1:00 PM </strong>
                      </li>  
                    </ul>
                </div>   
                <p><b>Entrance Test:</b> No</p>

                <!-- CTA Buttons -->
                <div class="hero-actions">
                 <button class="btn btn-success fee-btn" data-url="<?php echo LIVE_URL; ?>school-of-physical-sciences/department-of-statistics/bsc-in-computer-science-mathematics-statistics.php"> Fees </button>
                 <p><a href="../school-of-physical-sciences/department-of-statistics/bsc-in-computer-science-mathematics-statistics.php" target="_blank" class="btn btn-warning">Details</a></p>
                 <p><a href="https://sjuv4.linways.com/v4/adm-applicant/login" target="_blank" class="btn-outline">Apply Now</a></p>
                </div>
            </div>   
        </div>
     </div>
     <!--SCHOOL-->
     <div class="school-block" data-level="ug" data-school="physical_science">
         <h3 class="text_blue fw-bold mb-3">School of Physical Sciences</h3>
         <div class="program-grid">

            <!-- PROGRAM -->
            <div class="programme-box">
                <div class="d-flex gap-4 pgm_dtl">
                    <div class="program-icon icon-orange">
                      <i class="fa fa-book"></i>
                    </div>
                    <div>
                      <h5 class="text-blue fw-bold">Bachelor of Science (B.Sc.) in Physics, Mathematics and Computer Science</h5>
                      <p class="program-degree">UG Programme</p>
              
                    </div>
                </div>
                <div class="batch-info mb-4">
                    <ul class="list-unstyled batch-list">
                      <li class="batch-item">
                        <span>Batch </span>
                        <strong>9:00 AM to 4:00 PM</strong>
                      </li>  
                    </ul>
                </div>   
                <p><b>Entrance Test:</b> No</p>

                <!-- CTA Buttons -->
                <div class="hero-actions">
                 <button class="btn btn-success fee-btn" data-url="<?php echo LIVE_URL; ?>school-of-physical-sciences/department-of-physics/bsc-in-physics-mathematics-computer-science.php"> Fees </button>
                 <p><a href="../school-of-physical-sciences/department-of-physics/bsc-in-physics-mathematics-computer-science.php" target="_blank" class="btn btn-warning">Details</a></p>
                 <p><a href="https://sjuv4.linways.com/v4/adm-applicant/login" target="_blank" class="btn-outline">Apply Now</a></p>
                </div>
            </div> 
            <!-- PROGRAM -->
            <div class="programme-box">
                <div class="d-flex gap-4 pgm_dtl">
                    <div class="program-icon icon-orange">
                      <i class="fa fa-book"></i>
                    </div>
                    <div>
                      <h5 class="text-blue fw-bold">Bachelor of Science (B.Sc.) in Economics, Mathematics and Statistics</h5>
                      <p class="program-degree">UG Programme</p>
              
                    </div>
                </div>
                <div class="batch-info mb-4">
                    <ul class="list-unstyled batch-list">
                      <li class="batch-item">
                        <span>Batch </span>
                        <strong>9:00 AM to 4:00 PM</strong>
                      </li>  
                    </ul>
                </div>   
                <p><b>Entrance Test:</b> No</p>

                <!-- CTA Buttons -->
                <div class="hero-actions">
                 <button class="btn btn-success fee-btn" data-url="<?php echo LIVE_URL; ?>school-of-physical-sciences/department-of-mathematics/bsc-in-economics-mathematics-and-statistics.php"> Fees </button>
                 <p><a href="../school-of-physical-sciences/department-of-mathematics/bsc-in-economics-mathematics-and-statistics.php" target="_blank" class="btn btn-warning">Details</a></p>
                 <p><a href="https://sjuv4.linways.com/v4/adm-applicant/login" target="_blank" class="btn-outline">Apply Now</a></p>
                </div>
            </div> 
            <!-- PROGRAM -->
            <div class="programme-box">
                <div class="d-flex gap-4 pgm_dtl">
                    <div class="program-icon icon-orange">
                      <i class="fa fa-book"></i>
                    </div>
                    <div>
                      <h5 class="text-blue fw-bold">Bachelor of Science (B.Sc.) in Mathematics, Electronics and Computer Science</h5>
                      <p class="program-degree">UG Programme</p>
              
                    </div>
                </div>
                <div class="batch-info mb-4">
                    <ul class="list-unstyled batch-list">
                      <li class="batch-item">
                        <span>Batch </span>
                        <strong> 9:00 AM to 4:00 PM</strong>
                      </li>  
                    </ul>
                </div>   
                <p><b>Entrance Test:</b> No</p>

                <!-- CTA Buttons -->
                <div class="hero-actions">
                 <button class="btn btn-success fee-btn" data-url="<?php echo LIVE_URL; ?>school-of-physical-sciences/department-of-mathematics/bsc-in-mathematics-electronics-computer-science.php"> Fees </button>
                 <p><a href="../school-of-physical-sciences/department-of-mathematics/bsc-in-mathematics-electronics-computer-science.php" target="_blank" class="btn btn-warning">Details</a></p>
                 <p><a href="https://sjuv4.linways.com/v4/adm-applicant/login" target="_blank" class="btn-outline">Apply Now</a></p>
                </div>
            </div> 
            <!-- PROGRAM -->
            <div class="programme-box">
                <div class="d-flex gap-4 pgm_dtl">
                    <div class="program-icon icon-orange">
                      <i class="fa fa-book"></i>
                    </div>
                    <div>
                      <h5 class="text-blue fw-bold">Bachelor of Science (B.Sc.) in Physics, Chemistry and Mathematics</h5>
                      <p class="program-degree">UG Programme</p>
              
                    </div>
                </div>
                <div class="batch-info mb-4">
                    <ul class="list-unstyled batch-list">
                      <li class="batch-item">
                        <span>Batch </span>
                        <strong>9:00 AM to 4:00 PM</strong>
                      </li>  
                    </ul>
                </div>   
                <p><b>Entrance Test:</b> No</p>

                <!-- CTA Buttons -->
                <div class="hero-actions">
                 <button class="btn btn-success fee-btn" data-url="<?php echo LIVE_URL; ?>school-of-physical-sciences/department-of-physics/bsc-in-physics-chemistry-and-mathematics.php"> Fees </button>
                 <p><a href="../school-of-physical-sciences/department-of-physics/bsc-in-physics-chemistry-and-mathematics.php" target="_blank" class="btn btn-warning">Details</a></p>
                 <p><a href="https://sjuv4.linways.com/v4/adm-applicant/login" target="_blank" class="btn-outline">Apply Now</a></p>
                </div>
            </div> 
            <!-- PROGRAM -->
            <div class="programme-box">
                <div class="d-flex gap-4 pgm_dtl">
                    <div class="program-icon icon-orange">
                      <i class="fa fa-book"></i>
                    </div>
                    <div>
                      <h5 class="text-blue fw-bold">Bachelor of Science (B.Sc.) in Physics, Electronics and Mathematics</h5>
                      <p class="program-degree">UG Programme</p>
              
                    </div>
                </div>
                <div class="batch-info mb-4">
                    <ul class="list-unstyled batch-list">
                      <li class="batch-item">
                        <span>Batch </span>
                        <strong> 9:00 AM to 4:00 PM</strong>
                      </li>  
                    </ul>
                </div>   
                <p><b>Entrance Test:</b> No</p>

                <!-- CTA Buttons -->
                <div class="hero-actions">
                 <button class="btn btn-success fee-btn" data-url="<?php echo LIVE_URL; ?>school-of-physical-sciences/department-of-physics/bsc-in-physics-electronics-mathematics.php"> Fees </button>
                 <p><a href="../school-of-physical-sciences/department-of-physics/bsc-in-physics-electronics-mathematics.php" target="_blank" class="btn btn-warning">Details</a></p>
                 <p><a href="https://sjuv4.linways.com/v4/adm-applicant/login" target="_blank" class="btn-outline">Apply Now</a></p>
                </div>
            </div> 
            <!-- PROGRAM -->
            <div class="programme-box">
                <div class="d-flex gap-4 pgm_dtl">
                    <div class="program-icon icon-orange">
                      <i class="fa fa-book"></i>
                    </div>
                    <div>
                      <h5 class="text-blue fw-bold">Bachelor of Science (B.Sc.) in Computer Science, Mathematics and Statistics</h5>
                      <p class="program-degree">UG Programme</p>
              
                    </div>
                </div>
                <div class="batch-info mb-4">
                    <ul class="list-unstyled batch-list">
                      <li class="batch-item">
                        <span>Batch </span>
                        <strong> 7:00 AM to 1:00 PM </strong>
                      </li>  
                    </ul>
                </div>   
                <p><b>Entrance Test:</b> No</p>

                <!-- CTA Buttons -->
                <div class="hero-actions">
                 <button class="btn btn-success fee-btn" data-url="<?php echo LIVE_URL; ?>school-of-physical-sciences/department-of-statistics/bsc-in-computer-science-mathematics-statistics.php"> Fees </button>
                 <p><a href="../school-of-physical-sciences/department-of-statistics/bsc-in-computer-science-mathematics-statistics.php" target="_blank" class="btn btn-warning">Details</a></p>
                 <p><a href="https://sjuv4.linways.com/v4/adm-applicant/login" target="_blank" class="btn-outline">Apply Now</a></p>
                </div>
            </div>   
        </div>
     </div>
     
     <!--SCHOOL-->
     <div class="school-block" data-level="ug" data-school="social">
         <h3 class="text_blue fw-bold mb-3">School of Social Work</h3>
         <div class="program-grid">

            <!-- PROGRAM -->
            <div class="programme-box">
                <div class="d-flex gap-4 pgm_dtl">
                    <div class="program-icon icon-orange">
                      <i class="fa fa-book"></i>
                    </div>
                    <div>
                      <h5 class="text-blue fw-bold">Bachelor of Social Work (BSW)</h5>
                      <p class="program-degree">UG Programme</p>
              
                    </div>
                </div>
                <div class="batch-info mb-4">
                    <ul class="list-unstyled batch-list">
                      <li class="batch-item">
                        <span>Batch </span>
                        <strong>7:00 AM to 1:00 PM</strong>
                      </li>  
                    </ul>
                </div>   
                <p><b>Entrance Test:</b> No</p>

                <!-- CTA Buttons -->
                <div class="hero-actions">
                 <button class="btn btn-success fee-btn" data-url="<?php echo LIVE_URL; ?>school-of-social-work/department-of-social-work/bachelor-of-social-work.php"> Fees </button>
                 <p> <a href="../school-of-social-work/department-of-social-work/bachelor-of-social-work.php" target="_blank" class="btn btn-warning">Details</a></p>
                 <p><a href="https://sjuv4.linways.com/v4/adm-applicant/login" target="_blank" class="btn-outline">Apply Now</a></p>
                </div>
            </div>    
        </div>
     </div>
     
     <!--SCHOOL-->
     <div class="school-block" data-level="ug" data-school="communication">
         <h3 class="text_blue fw-bold mb-3">School of Communication & Media Studies</h3>
         <div class="program-grid">

            <!-- PROGRAM -->
            <div class="programme-box">
                <div class="d-flex gap-4 pgm_dtl">
                    <div class="program-icon icon-orange">
                      <i class="fa fa-book"></i>
                    </div>
                    <div>
                      <h5 class="text-blue fw-bold">Bachelor of Arts (B.A.) in Visual Communication</h5>
                      <p class="program-degree">UG Programme</p>
              
                    </div>
                </div>
                <div class="batch-info mb-4">
                    <ul class="list-unstyled batch-list">
                      <li class="batch-item">
                        <span>Batch </span>
                        <strong>7:00 AM to 1:00 PM</strong>
                      </li>  
                    </ul>
                </div>   
                <p><b>Entrance Test:</b> Yes</p>

                <!-- CTA Buttons -->
                <div class="hero-actions">
                 <button class="btn btn-success fee-btn" data-url="<?php echo LIVE_URL; ?>school-of-communication-media-studies/department-of-communication-media-studies/ba-in-visual-communication.php"> Fees </button>
                 <p><a href="../school-of-communication-media-studies/department-of-communication-media-studies/ba-in-visual-communication.php" target="_blank" class="btn btn-warning">Details</a></p>
                 <p><a href="https://sjuv4.linways.com/v4/adm-applicant/login" target="_blank" class="btn-outline">Apply Now</a></p>
                </div>
            </div> 
            <!-- PROGRAM -->
            <div class="programme-box">
                <div class="d-flex gap-4 pgm_dtl">
                    <div class="program-icon icon-orange">
                      <i class="fa fa-book"></i>
                    </div>
                    <div>
                      <h5 class="text-blue fw-bold">Bachelor of Vocation (B.Voc.) in Digital Media and Animation</h5>
                      <p class="program-degree">UG Programme</p>
              
                    </div>
                </div>
                <div class="batch-info mb-4">
                    <ul class="list-unstyled batch-list">
                      <li class="batch-item">
                        <span>Batch </span>
                        <strong>7:00 AM to 1:00 PM</strong>
                      </li>  
                    </ul>
                </div>   
                <p><b>Entrance Test:</b> Yes</p>

                <!-- CTA Buttons -->
                <div class="hero-actions">
                 <button class="btn btn-success fee-btn" data-url="<?php echo LIVE_URL; ?>school-of-communication-media-studies/department-of-communication-media-studies/bvoc-in-digital-media-animation.php"> Fees </button>
                 <p><a href="../school-of-communication-media-studies/department-of-communication-media-studies/bvoc-in-digital-media-animation.php" target="_blank" class="btn btn-warning">Details</a></p>
                 <p><a href="https://sjuv4.linways.com/v4/adm-applicant/login" target="_blank" class="btn-outline">Apply Now</a></p>
                </div>
            </div> 
            <!-- PROGRAM -->
            <div class="programme-box">
                <div class="d-flex gap-4 pgm_dtl">
                    <div class="program-icon icon-orange">
                      <i class="fa fa-book"></i>
                    </div>
                    <div>
                      <h5 class="text-blue fw-bold">Bachelor of Vocation (B.Voc.) in Visual Media and Film-Making</h5>
                      <p class="program-degree">UG Programme</p>
              
                    </div>
                </div>
                <div class="batch-info mb-4">
                    <ul class="list-unstyled batch-list">
                      <li class="batch-item">
                        <span>Batch </span>
                        <strong>7:00 AM to 1:00 PM</strong>
                      </li>  
                    </ul>
                </div>   
                <p><b>Entrance Test:</b> Yes</p>

                <!-- CTA Buttons -->
                <div class="hero-actions">
                 <button class="btn btn-success fee-btn" data-url="<?php echo LIVE_URL; ?>school-of-communication-media-studies/department-of-communication-media-studies/bvoc-in-visual-media-film-making.php"> Fees </button>
                 <p><a href="../school-of-communication-media-studies/department-of-communication-media-studies/bvoc-in-visual-media-film-making.php" target="_blank" class="btn btn-warning">Details</a></p>
                 <p><a href="https://sjuv4.linways.com/v4/adm-applicant/login" target="_blank" class="btn-outline">Apply Now</a></p>
                </div>
            </div>  
        </div>
     </div>
     
     <!--SCHOOL-->
     <div class="school-block" data-level="ug" data-school="info_technology">
         <h3 class="text_blue fw-bold mb-3">School of Information Technology</h3>
         <div class="program-grid">

            <!-- PROGRAM -->
            <div class="programme-box">
                <div class="d-flex gap-4 pgm_dtl">
                    <div class="program-icon icon-orange">
                      <i class="fa fa-book"></i>
                    </div>
                    <div>
                      <h5 class="text-blue fw-bold">Bachelor of Computer Applications (BCA)</h5>
                      <p class="program-degree">UG Programme</p>
              
                    </div>
                </div>
                <div class="batch-info mb-4">
                    <ul class="list-unstyled batch-list">
                      <li class="batch-item">
                        <span>Batch I</span>
                        <strong>9:00 AM to 4:00 PM (Closed on 10 April 2026)</strong>
                      </li> 
                      <li class="batch-item">
                        <span>Batch II</span>
                        <strong> 4:00 PM to 9:00 PM</strong>
                      </li> 
                      <li class="batch-item">
                        <span>Block B (Bannerghatta)</span>
                        <strong>9:00 AM to 4:00 PM</strong>
                      </li> 
                    </ul>
                </div>   
                <p><b>Entrance Test:</b> No</p>

                <!-- CTA Buttons -->
                <div class="hero-actions">
                 <button class="btn btn-success fee-btn" data-url="<?php echo LIVE_URL; ?>school-of-information-technology/department-of-computer-science/bachelor-of-computer-applications.php"> Fees </button>
                 <p><a href="../school-of-information-technology/department-of-computer-science/bachelor-of-computer-applications.php" target="_blank" class="btn btn-warning">Details</a></p>
                 <p><a href="https://sjuv4.linways.com/v4/adm-applicant/login" target="_blank" class="btn-outline">Apply Now</a></p>
                </div>
            </div> 
            <!-- PROGRAM -->
            <div class="programme-box">
                <div class="d-flex gap-4 pgm_dtl">
                    <div class="program-icon icon-orange">
                      <i class="fa fa-book"></i>
                    </div>
                    <div>
                      <h5 class="text-blue fw-bold">Bachelor of Science (B.Sc.) in Physics, Mathematics and Computer Science</h5>
                      <p class="program-degree">UG Programme</p>
              
                    </div>
                </div>
                <div class="batch-info mb-4">
                    <ul class="list-unstyled batch-list">
                      <li class="batch-item">
                        <span>Batch </span>
                        <strong>9:00 AM to 4:00 PM</strong>
                      </li>  
                    </ul>
                </div>   
                <p><b>Entrance Test:</b> No</p>

                <!-- CTA Buttons -->
                <div class="hero-actions">
                 <button class="btn btn-success fee-btn" data-url="<?php echo LIVE_URL; ?>school-of-information-technology/department-of-computer-science/bsc-in-physics-mathematics-computer-science.php"> Fees </button>
                 <p><a href="../school-of-information-technology/department-of-computer-science/bsc-in-physics-mathematics-computer-science.php" target="_blank" class="btn btn-warning">Details</a></p>
                 <p><a href="https://sjuv4.linways.com/v4/adm-applicant/login" target="_blank" class="btn-outline">Apply Now</a></p>
                </div>
            </div> 
            <!-- PROGRAM -->
            <div class="programme-box">
                <div class="d-flex gap-4 pgm_dtl">
                    <div class="program-icon icon-orange">
                      <i class="fa fa-book"></i>
                    </div>
                    <div>
                      <h5 class="text-blue fw-bold">Bachelor of Science (B.Sc.) in Mathematics, Electronics and Computer Science</h5>
                      <p class="program-degree">UG Programme</p>
              
                    </div>
                </div>
                <div class="batch-info mb-4">
                    <ul class="list-unstyled batch-list">
                      <li class="batch-item">
                        <span>Batch </span>
                        <strong>9:00 AM to 4:00 PM</strong>
                      </li>  
                    </ul>
                </div>   
                <p><b>Entrance Test:</b> No</p>

                <!-- CTA Buttons -->
                <div class="hero-actions">
                  <button class="btn btn-success fee-btn" data-url="<?php echo LIVE_URL; ?>school-of-information-technology/department-of-mathematics/bsc-in-mathematics-electronics-computer-science.php"> Fees </button>
                 <p><a href="../school-of-information-technology/department-of-mathematics/bsc-in-mathematics-electronics-and-computer-science.php" target="_blank" class="btn btn-warning">Details</a></p>
                 <p><a href="https://sjuv4.linways.com/v4/adm-applicant/login" target="_blank" class="btn-outline">Apply Now</a></p>
                </div>
            </div>   
            <!-- PROGRAM -->
            <div class="programme-box">
                <div class="d-flex gap-4 pgm_dtl">
                    <div class="program-icon icon-orange">
                      <i class="fa fa-book"></i>
                    </div>
                    <div>
                      <h5 class="text-blue fw-bold">Bachelor of Computer Applications (BCA) in Data Analytics</h5>
                      <p class="program-degree">UG Programme</p>
              
                    </div>
                </div>
                <div class="batch-info mb-4">
                    <ul class="list-unstyled batch-list">
                      <li class="batch-item">
                        <span>Batch </span>
                        <strong>7:00 AM to 1:00 PM (Closed on 16 April 2026)</strong>
                      </li>  
                    </ul>
                </div>   
                <p><b>Entrance Test:</b> No</p>

                <!-- CTA Buttons -->
                <div class="hero-actions">
                 <button class="btn btn-success fee-btn" data-url="<?php echo LIVE_URL; ?>school-of-information-technology/department-of-advanced-computing/bca-in-data-analytics.php"> Fees </button>
                 <p><a href="../school-of-information-technology/department-of-advanced-computing/bca-in-data-analytics.php" target="_blank" class="btn btn-warning">Details</a></p>
                 <p><a href="https://sjuv4.linways.com/v4/adm-applicant/login" target="_blank" class="btn-outline">Apply Now</a></p>
                </div>
            </div>  
            <!-- PROGRAM -->
            <div class="programme-box">
                <div class="d-flex gap-4 pgm_dtl">
                    <div class="program-icon icon-orange">
                      <i class="fa fa-book"></i>
                    </div>
                    <div>
                      <h5 class="text-blue fw-bold">Bachelor of Science (B.Sc.) in Computer Science, Mathematics and Statistics</h5>
                      <p class="program-degree">UG Programme</p>
              
                    </div>
                </div>
                <div class="batch-info mb-4">
                    <ul class="list-unstyled batch-list">
                      <li class="batch-item">
                        <span>Batch </span>
                        <strong>7:00 AM to 1:00 PM</strong>
                      </li>  
                    </ul>
                </div>   
                <p><b>Entrance Test:</b> No</p>

                <!-- CTA Buttons -->
                <div class="hero-actions">
                 <button class="btn btn-success fee-btn" data-url="<?php echo LIVE_URL; ?>school-of-information-technology/department-of-computer-science/bsc-in-computer-science-mathematics-statistics.php"> Fees </button>
                 <p><a href="../school-of-information-technology/department-of-computer-science/bsc-in-computer-science-mathematics-statistics.php" target="_blank" class="btn btn-warning">Details</a></p>
                 <p><a href="https://sjuv4.linways.com/v4/adm-applicant/login" target="_blank" class="btn-outline">Apply Now</a></p>
                </div>
            </div>   
        </div>
     </div>
<!--===========================PG PROGRAMMES=========================-->
     <!--SCHOOL-->
     <div class="school-block" data-level="pg" data-school="business">
         <h3 class="text_blue fw-bold mb-3">School of Business</h3>
         <div class="program-grid">

            <!-- PROGRAM -->
            <div class="programme-box">
                <div class="d-flex gap-4 pgm_dtl">
                    <div class="program-icon icon-orange">
                      <i class="fa fa-book"></i>
                    </div>
                    <div>
                      <h5 class="text-blue fw-bold">Master of Commerce (M.Com.)</h5>
                      <p class="program-degree">PG Programme</p>
              
                    </div>
                </div>
                <div class="batch-info mb-4">
                    <ul class="list-unstyled batch-list">
                      <li class="batch-item">
                        <span>Batch I </span>
                        <strong> 7:00 AM to 11:00 AM</strong>
                      </li>  
                      <li class="batch-item">
                        <span>Batch II </span>
                        <strong> 4:45 PM to 8:45 PM</strong>
                      </li>  
                    </ul>
                </div>   
                <p><b>Entrance Test:</b> No</p>

                <!-- CTA Buttons -->
                <div class="hero-actions">
                 <button class="btn btn-success fee-btn" data-url="<?php echo LIVE_URL; ?>school-of-business/department-of-commerce/master-of-commerce.php"> Fees </button>
                 <p><a href="../school-of-business/department-of-commerce/master-of-commerce.php" target="_blank" class="btn btn-warning">Details</a></p>
                 <p><a href="https://sjuv4.linways.com/v4/adm-applicant/login" target="_blank" class="btn-outline">Apply Now</a></p>
                </div>
            </div> 
        </div>
     </div>
     
     <!--SCHOOL-->
     <div class="school-block" data-level="pg" data-school="chemical">
         <h3 class="text_blue fw-bold mb-3">School of Chemical Sciences</h3>
         <div class="program-grid">

            <!-- PROGRAM -->
            <div class="programme-box">
                <div class="d-flex gap-4 pgm_dtl">
                    <div class="program-icon icon-orange">
                      <i class="fa fa-book"></i>
                    </div>
                    <div>
                      <h5 class="text-blue fw-bold">Master of Science (M.Sc.) in Analytical Chemistry</h5>
                      <p class="program-degree">PG Programme</p>
              
                    </div>
                </div>
                <div class="batch-info mb-4">
                    <ul class="list-unstyled batch-list">
                      <li class="batch-item">
                        <span>Batch </span>
                        <strong> 9:00 AM to 4:00 PM</strong>
                      </li>  
                    </ul>
                </div>   
                <p><b>Entrance Test:</b> No</p>

                <!-- CTA Buttons -->
                <div class="hero-actions">
                 <button class="btn btn-success fee-btn" data-url="<?php echo LIVE_URL; ?>school-of-chemical-sciences/department-of-chemistry/msc-in-analytical-chemistry.php"> Fees </button>
                 <p><a href="../school-of-chemical-sciences/department-of-chemistry/msc-in-analytical-chemistry.php" target="_blank" class="btn btn-warning">Details</a></p>
                 <p><a href="https://sjuv4.linways.com/v4/adm-applicant/login" target="_blank" class="btn-outline">Apply Now</a></p>
                </div>
            </div> 
            <!-- PROGRAM -->
            <div class="programme-box">
                <div class="d-flex gap-4 pgm_dtl">
                    <div class="program-icon icon-orange">
                      <i class="fa fa-book"></i>
                    </div>
                    <div>
                      <h5 class="text-blue fw-bold">Master of Science (M.Sc.) in Organic Chemistry</h5>
                      <p class="program-degree">PG Programme</p>
              
                    </div>
                </div>
                <div class="batch-info mb-4">
                    <ul class="list-unstyled batch-list">
                      <li class="batch-item">
                        <span>Batch </span>
                        <strong>7:00 AM to 1:00 PM</strong>
                      </li>  
                    </ul>
                </div>   
                <p><b>Entrance Test:</b> No</p>

                <!-- CTA Buttons -->
                <div class="hero-actions">
                 <button class="btn btn-success fee-btn" data-url="<?php echo LIVE_URL; ?>school-of-chemical-sciences/department-of-chemistry/msc-in-organic-chemistry.php"> Fees </button>
                 <p><a href="../school-of-chemical-sciences/department-of-chemistry/msc-in-organic-chemistry.php" target="_blank" class="btn btn-warning">Details</a></p>
                 <p><a href="https://sjuv4.linways.com/v4/adm-applicant/login" target="_blank" class="btn-outline">Apply Now</a></p>
                </div>
            </div> 
            <!-- PROGRAM -->
            <div class="programme-box">
                <div class="d-flex gap-4 pgm_dtl">
                    <div class="program-icon icon-orange">
                      <i class="fa fa-book"></i>
                    </div>
                    <div>
                      <h5 class="text-blue fw-bold">	Master of Science (M.Sc.) in Biochemistry</h5>
                      <p class="program-degree">PG Programme</p>
              
                    </div>
                </div>
                <div class="batch-info mb-4">
                    <ul class="list-unstyled batch-list">
                      <li class="batch-item">
                        <span>Batch </span>
                        <strong>7:00 AM to 1:00 PM</strong>
                      </li>  
                    </ul>
                </div>   
                <p><b>Entrance Test:</b> No</p>

                <!-- CTA Buttons -->
                <div class="hero-actions">
                 <button class="btn btn-success fee-btn" data-url="<?php echo LIVE_URL; ?>school-of-chemical-sciences/department-of-biochemistry/msc-in-biochemistry.php"> Fees </button>
                 <p><a href="../school-of-chemical-sciences/department-of-biochemistry/msc-in-biochemistry.php" target="_blank" class="btn btn-warning">Details</a></p>
                 <p><a href="https://sjuv4.linways.com/v4/adm-applicant/login" target="_blank" class="btn-outline">Apply Now</a></p>
                </div>
            </div> 
            
        </div>
     </div>
     
      <!--SCHOOL-->
     <div class="school-block" data-level="pg" data-school="humanities">
         <h3 class="text_blue fw-bold mb-3">School of Humanities & Social Sciences</h3>
         <div class="program-grid">

            <!-- PROGRAM -->
            <div class="programme-box">
                <div class="d-flex gap-4 pgm_dtl">
                    <div class="program-icon icon-orange">
                      <i class="fa fa-book"></i>
                    </div>
                    <div>
                      <h5 class="text-blue fw-bold">Master of Arts (M.A.) in Economics</h5>
                      <p class="program-degree">PG Programme</p>
              
                    </div>
                </div>
                <div class="batch-info mb-4">
                    <ul class="list-unstyled batch-list">
                      <li class="batch-item">
                        <span>Batch </span>
                        <strong> 9:00 AM to 4:00 PM</strong>
                      </li>  
                    </ul>
                </div>   
                <p><b>Entrance Test:</b> No</p>

                <!-- CTA Buttons -->
                <div class="hero-actions">
                 <button class="btn btn-success fee-btn" data-url="<?php echo LIVE_URL; ?>school-of-humanities-and-social-sciences/department-of-economics/master-of-arts-in-economics.php"> Fees </button>
                 <p><a href="../school-of-humanities-and-social-sciences/department-of-economics/master-of-arts-in-economics.php" target="_blank" class="btn btn-warning">Details</a></p>
                 <p><a href="https://sjuv4.linways.com/v4/adm-applicant/login" target="_blank" class="btn-outline">Apply Now</a></p>
                </div>
            </div> 
            <!-- PROGRAM -->
            <div class="programme-box">
                <div class="d-flex gap-4 pgm_dtl">
                    <div class="program-icon icon-orange">
                      <i class="fa fa-book"></i>
                    </div>
                    <div>
                      <h5 class="text-blue fw-bold">Master of Arts (M.A.) in Political Science</h5>
                      <p class="program-degree">PG Programme</p>
              
                    </div>
                </div>
                <div class="batch-info mb-4">
                    <ul class="list-unstyled batch-list">
                      <li class="batch-item">
                        <span>Batch </span>
                        <strong>7:00 AM to 1:00 PM</strong>
                      </li>  
                    </ul>
                </div>   
                <p><b>Entrance Test:</b> No</p>

                <!-- CTA Buttons -->
                <div class="hero-actions">
                 <button class="btn btn-success fee-btn" data-url="<?php echo LIVE_URL; ?>school-of-humanities-and-social-sciences/department-of-political-science/master-of-arts-in-political-science.php"> Fees </button>
                 <p><a href="../school-of-humanities-and-social-sciences/department-of-political-science/master-of-arts-in-political-science.php" target="_blank" class="btn btn-warning">Details</a></p>
                 <p><a href="https://sjuv4.linways.com/v4/adm-applicant/login" target="_blank" class="btn-outline">Apply Now</a></p>
                </div>
            </div> 
            <!-- PROGRAM -->
            <div class="programme-box">
                <div class="d-flex gap-4 pgm_dtl">
                    <div class="program-icon icon-orange">
                      <i class="fa fa-book"></i>
                    </div>
                    <div>
                      <h5 class="text-blue fw-bold">Master of Science (M.Sc.) in Counselling Psychology</h5>
                      <p class="program-degree">PG Programme</p>
              
                    </div>
                </div>
                <div class="batch-info mb-4">
                    <ul class="list-unstyled batch-list">
                      <li class="batch-item">
                        <span>Batch </span>
                        <strong>7:00 AM to 1:00 PM</strong>
                      </li>  
                    </ul>
                </div>   
                <p><b>Entrance Test:</b> Yes</p>

                <!-- CTA Buttons -->
                <div class="hero-actions">
                 <button class="btn btn-success fee-btn" data-url="<?php echo LIVE_URL; ?>school-of-humanities-and-social-sciences/department-of-psychology-and-counselling/master-of-science-in-counselling-psychology.php"> Fees </button>
                 <p><a href="../school-of-humanities-and-social-sciences/department-of-psychology-and-counselling/master-of-science-in-counselling-psychology.php" target="_blank" class="btn btn-warning">Details</a></p>
                 <p><a href="https://sjuv4.linways.com/v4/adm-applicant/login" target="_blank" class="btn-outline">Apply Now</a></p>
                </div>
            </div>  
        </div>
     </div>
     
      <!--SCHOOL-->
     <div class="school-block" data-level="pg" data-school="language">
         <h3 class="text_blue fw-bold mb-3">School of Languages & Literatures</h3>
         <div class="program-grid">

            <!-- PROGRAM -->
            <div class="programme-box">
                <div class="d-flex gap-4 pgm_dtl">
                    <div class="program-icon icon-orange">
                      <i class="fa fa-book"></i>
                    </div>
                    <div>
                      <h5 class="text-blue fw-bold">Master of Arts (M.A.) in English</h5>
                      <p class="program-degree">PG Programme</p>
              
                    </div>
                </div>
                <div class="batch-info mb-4">
                    <ul class="list-unstyled batch-list">
                      <li class="batch-item">
                        <span>Batch I </span>
                        <strong> 9:00 AM to 4:00 PM</strong>
                      </li>  
                      <li class="batch-item">
                        <span>Batch II </span>
                        <strong> 4:45 PM to 8:45 PM</strong>
                      </li>  
                    </ul>
                </div>   
                <p><b>Entrance Test:</b> No</p>

                <!-- CTA Buttons -->
                <div class="hero-actions">
                 <button class="btn btn-success fee-btn" data-url="<?php echo LIVE_URL; ?>school-of-languages-and-literatures/department-of-english/master-of-arts-in-english.php"> Fees </button>
                 <p><a href="../school-of-languages-and-literatures/department-of-english/master-of-arts-in-english.php" target="_blank" class="btn btn-warning">Details</a></p>
                 <p><a href="https://sjuv4.linways.com/v4/adm-applicant/login" target="_blank" class="btn-outline">Apply Now</a></p>
                </div>
            </div>  
        </div>
     </div>
     
     <!--SCHOOL-->
     <div class="school-block" data-level="pg" data-school="life_sciences">
         <h3 class="text_blue fw-bold mb-3">School of Life Sciences</h3>
         <div class="program-grid">

            <!-- PROGRAM -->
            <div class="programme-box">
                <div class="d-flex gap-4 pgm_dtl">
                    <div class="program-icon icon-orange">
                      <i class="fa fa-book"></i>
                    </div>
                    <div>
                      <h5 class="text-blue fw-bold">Master of Science (M.Sc.) in Biotechnology</h5>
                      <p class="program-degree">PG Programme</p>
              
                    </div>
                </div>
                <div class="batch-info mb-4">
                    <ul class="list-unstyled batch-list">
                      <li class="batch-item">
                        <span>Batch   </span>
                        <strong> 7:00 AM to 1:00 PM</strong>
                      </li>  
                    </ul>
                </div>   
                <p><b>Entrance Test:</b> Yes</p>

                <!-- CTA Buttons -->
                <div class="hero-actions">
                 <button class="btn btn-success fee-btn" data-url="<?php echo LIVE_URL; ?>school-of-life-sciences/department-of-biotechnology/msc-in-biotechnology.php"> Fees </button>
                 <p><a href="../school-of-life-sciences/department-of-biotechnology/msc-in-biotechnology.php" target="_blank" class="btn btn-warning">Details</a></p>
                 <p><a href="https://sjuv4.linways.com/v4/adm-applicant/login" target="_blank" class="btn-outline">Apply Now</a></p>
                </div>
            </div>  
            <!-- PROGRAM -->
            <div class="programme-box">
                <div class="d-flex gap-4 pgm_dtl">
                    <div class="program-icon icon-orange">
                      <i class="fa fa-book"></i>
                    </div>
                    <div>
                      <h5 class="text-blue fw-bold">Master of Science (M.Sc.) in Environmental Science and Sustainability</h5>
                      <p class="program-degree">PG Programme</p>
              
                    </div>
                </div>
                <div class="batch-info mb-4">
                    <ul class="list-unstyled batch-list">
                      <li class="batch-item">
                        <span>Batch   </span>
                        <strong>9:00 AM to 4:00 PM</strong>
                      </li>  
                    </ul>
                </div>   
                <p><b>Entrance Test:</b> No</p>

                <!-- CTA Buttons -->
                <div class="hero-actions">
                 <button class="btn btn-success fee-btn" data-url="<?php echo LIVE_URL; ?>school-of-life-sciences/department-of-environmental-science/msc-in-environmental-science-and-sustainability.php"> Fees </button>
                 <p><a href="../school-of-life-sciences/department-of-environmental-science/msc-in-environmental-science-and-sustainability.php" target="_blank" class="btn btn-warning">Details</a></p>
                 <p><a href="https://sjuv4.linways.com/v4/adm-applicant/login" target="_blank" class="btn-outline">Apply Now</a></p>
                </div>
            </div>  
            <!-- PROGRAM -->
            <div class="programme-box">
                <div class="d-flex gap-4 pgm_dtl">
                    <div class="program-icon icon-orange">
                      <i class="fa fa-book"></i>
                    </div>
                    <div>
                      <h5 class="text-blue fw-bold">Master of Science (M.Sc.) in Food Science and Technology</h5>
                      <p class="program-degree">PG Programme</p>
              
                    </div>
                </div>
                <div class="batch-info mb-4">
                    <ul class="list-unstyled batch-list">
                      <li class="batch-item">
                        <span>Batch   </span>
                        <strong>9:00 AM to 4:00 PM</strong>
                      </li>  
                    </ul>
                </div>   
                <p><b>Entrance Test:</b> Yes</p>

                <!-- CTA Buttons -->
                <div class="hero-actions">
                 <button class="btn btn-success fee-btn" data-url="<?php echo LIVE_URL; ?>school-of-life-sciences/department-of-food-science-and-technology/msc-in-food-science-and-technology.php"> Fees </button>
                 <p><a href="../school-of-life-sciences/department-of-food-science-and-technology/msc-in-food-science-and-technology.php" target="_blank" class="btn btn-warning">Details</a></p>
                 <p><a href="https://sjuv4.linways.com/v4/adm-applicant/login" target="_blank" class="btn-outline">Apply Now</a></p>
                </div>
            </div>  
            <!-- PROGRAM -->
            <div class="programme-box">
                <div class="d-flex gap-4 pgm_dtl">
                    <div class="program-icon icon-orange">
                      <i class="fa fa-book"></i>
                    </div>
                    <div>
                      <h5 class="text-blue fw-bold">Master of Science (M.Sc.) in Microbiology</h5>
                      <p class="program-degree">PG Programme</p>
              
                    </div>
                </div>
                <div class="batch-info mb-4">
                    <ul class="list-unstyled batch-list">
                      <li class="batch-item">
                        <span>Batch   </span>
                        <strong>9:00 AM to 4:00 PM</strong>
                      </li>  
                    </ul>
                </div>   
                <p><b>Entrance Test:</b> Yes</p>

                <!-- CTA Buttons -->
                <div class="hero-actions">
                 <button class="btn btn-success fee-btn" data-url="<?php echo LIVE_URL; ?>school-of-life-sciences/department-of-microbiology/msc-in-microbiology.php"> Fees </button>
                 <p><a href="../school-of-life-sciences/department-of-microbiology/msc-in-microbiology.php" target="_blank" class="btn btn-warning">Details</a></p>
                 <p><a href="https://sjuv4.linways.com/v4/adm-applicant/login" target="_blank" class="btn-outline">Apply Now</a></p>
                </div>
            </div>  
            <!-- PROGRAM -->
            <div class="programme-box">
                <div class="d-flex gap-4 pgm_dtl">
                    <div class="program-icon icon-orange">
                      <i class="fa fa-book"></i>
                    </div>
                    <div>
                      <h5 class="text-blue fw-bold">Master of Science (M.Sc.) in Zoology</h5>
                      <p class="program-degree">PG Programme</p>
              
                    </div>
                </div>
                <div class="batch-info mb-4">
                    <ul class="list-unstyled batch-list">
                      <li class="batch-item">
                        <span>Batch   </span>
                        <strong>7:00 AM to 1:00 PM</strong>
                      </li>  
                    </ul>
                </div>   
                <p><b>Entrance Test:</b> No</p>

                <!-- CTA Buttons -->
                <div class="hero-actions">
                 <button class="btn btn-success fee-btn" data-url="<?php echo LIVE_URL; ?>school-of-life-sciences/department-of-zoology/msc-in-zoology.php"> Fees </button>
                 <p><a href="../school-of-life-sciences/department-of-zoology/msc-in-zoology.php" target="_blank" class="btn btn-warning">Details</a></p>
                 <p><a href="https://sjuv4.linways.com/v4/adm-applicant/login" target="_blank" class="btn-outline">Apply Now</a></p>
                </div>
            </div>   
        </div>
     </div>
     
     <!--SCHOOL-->
     <div class="school-block" data-level="pg" data-school="physical_science">
         <h3 class="text_blue fw-bold mb-3">School of Physical Sciences</h3>
         <div class="program-grid">

            <!-- PROGRAM -->
            <div class="programme-box">
                <div class="d-flex gap-4 pgm_dtl">
                    <div class="program-icon icon-orange">
                      <i class="fa fa-book"></i>
                    </div>
                    <div>
                      <h5 class="text-blue fw-bold">Master of Science (M.Sc.) in Mathematics</h5>
                      <p class="program-degree">PG Programme</p>
              
                    </div>
                </div>
                <div class="batch-info mb-4">
                    <ul class="list-unstyled batch-list">
                      <li class="batch-item">
                        <span>Batch   </span>
                        <strong> 9:00 AM to 4:00 PM</strong>
                      </li>  
                    </ul>
                </div>   
                <p><b>Entrance Test:</b> No</p>

                <!-- CTA Buttons -->
                <div class="hero-actions">
                 <button class="btn btn-success fee-btn" data-url="<?php echo LIVE_URL; ?>school-of-physical-sciences/department-of-mathematics/master-of-science-in-mathematics.php"> Fees </button>
                 <p><a href="../school-of-physical-sciences/department-of-mathematics/master-of-science-in-mathematics.php" target="_blank" class="btn btn-warning">Details</a></p>
                 <p><a href="https://sjuv4.linways.com/v4/adm-applicant/login" target="_blank" class="btn-outline">Apply Now</a></p>
                </div>
            </div>  
            <!-- PROGRAM -->
            <div class="programme-box">
                <div class="d-flex gap-4 pgm_dtl">
                    <div class="program-icon icon-orange">
                      <i class="fa fa-book"></i>
                    </div>
                    <div>
                      <h5 class="text-blue fw-bold">Master of Science (M.Sc.) in Physics</h5>
                      <p class="program-degree">PG Programme</p>
              
                    </div>
                </div>
                <div class="batch-info mb-4">
                    <ul class="list-unstyled batch-list">
                      <li class="batch-item">
                        <span>Batch   </span>
                        <strong>7:00 AM to 1:00 PM</strong>
                      </li>  
                    </ul>
                </div>   
                <p><b>Entrance Test:</b> No</p>

                <!-- CTA Buttons -->
                <div class="hero-actions">
                 <button class="btn btn-success fee-btn" data-url="<?php echo LIVE_URL; ?>school-of-physical-sciences/department-of-physics/master-of-science-in-physics.php"> Fees </button>
                 <p><a href="../school-of-physical-sciences/department-of-physics/master-of-science-in-physics.php" target="_blank" class="btn btn-warning">Details</a></p>
                 <p><a href="https://sjuv4.linways.com/v4/adm-applicant/login" target="_blank" class="btn-outline">Apply Now</a></p>
                </div>
            </div>  
            <!-- PROGRAM -->
            <div class="programme-box">
                <div class="d-flex gap-4 pgm_dtl">
                    <div class="program-icon icon-orange">
                      <i class="fa fa-book"></i>
                    </div>
                    <div>
                      <h5 class="text-blue fw-bold">Master of Science (M.Sc.) in Statistics</h5>
                      <p class="program-degree">PG Programme</p>
              
                    </div>
                </div>
                <div class="batch-info mb-4">
                    <ul class="list-unstyled batch-list">
                      <li class="batch-item">
                        <span>Batch   </span>
                        <strong>7:00 AM to 1:00 PM</strong>
                      </li>  
                    </ul>
                </div>   
                <p><b>Entrance Test:</b> No</p>

                <!-- CTA Buttons -->
                <div class="hero-actions">
                 <button class="btn btn-success fee-btn" data-url="<?php echo LIVE_URL; ?>school-of-physical-sciences/department-of-statistics/master-of-science-in-statistics.php"> Fees </button>
                 <p><a href="../school-of-physical-sciences/department-of-statistics/master-of-science-in-statistics.php" target="_blank" class="btn btn-warning">Details</a></p>
                 <p><a href="https://sjuv4.linways.com/v4/adm-applicant/login" target="_blank" class="btn-outline">Apply Now</a></p>
                </div>
            </div>    
        </div>
     </div>
     
     <!--SCHOOL-->
     <div class="school-block" data-level="pg" data-school="social">
         <h3 class="text_blue fw-bold mb-3">School of Social Work</h3>
         <div class="program-grid">

            <!-- PROGRAM -->
            <div class="programme-box">
                <div class="d-flex gap-4 pgm_dtl">
                    <div class="program-icon icon-orange">
                      <i class="fa fa-book"></i>
                    </div>
                    <div>
                      <h5 class="text-blue fw-bold">Master of Social Work (MSW)</h5>
                      <p class="program-degree">PG Programme</p>
              
                    </div>
                </div>
                <div class="batch-info mb-4">
                    <ul class="list-unstyled batch-list">
                      <li class="batch-item">
                        <span>Batch   </span>
                        <strong> 7:00 AM to 1:00 PM</strong>
                      </li>  
                    </ul>
                </div>   
                <p><b>Entrance Test:</b> No</p>

                <!-- CTA Buttons -->
                <div class="hero-actions">
                 <button class="btn btn-success fee-btn" data-url="<?php echo LIVE_URL; ?>school-of-social-work/department-of-social-work/master-of-social-work.php"> Fees </button>
                 <p><a href="../school-of-social-work/department-of-social-work/master-of-social-work.php" target="_blank" class="btn btn-warning">Details</a></p>
                 <p><a href="https://sjuv4.linways.com/v4/adm-applicant/login" target="_blank" class="btn-outline">Apply Now</a></p>
                </div>
            </div>    
        </div>
     </div>
     
     <!--SCHOOL-->
     <div class="school-block" data-level="pg" data-school="communication">
         <h3 class="text_blue fw-bold mb-3">School of Communication & Media Studies</h3>
         <div class="program-grid">

            <!-- PROGRAM -->
            <div class="programme-box">
                <div class="d-flex gap-4 pgm_dtl">
                    <div class="program-icon icon-orange">
                      <i class="fa fa-book"></i>
                    </div>
                    <div>
                      <h5 class="text-blue fw-bold">Master of Arts (M.A.) in Advertising and Public Relations</h5>
                      <p class="program-degree">PG Programme</p>
              
                    </div>
                </div>
                <div class="batch-info mb-4">
                    <ul class="list-unstyled batch-list">
                      <li class="batch-item">
                        <span>Batch   </span>
                        <strong> 7:00 AM to 1:00 PM</strong>
                      </li>  
                    </ul>
                </div>   
                <p><b>Entrance Test:</b> Yes</p>

                <!-- CTA Buttons -->
                <div class="hero-actions">
                 <button class="btn btn-success fee-btn" data-url="<?php echo LIVE_URL; ?>school-of-communication-media-studies/department-of-communication-media-studies/ma-in-advertising-public-relations.php"> Fees </button>
                 <p><a href="../school-of-communication-media-studies/department-of-communication-media-studies/ma-in-advertising-public-relations.php" target="_blank" class="btn btn-warning">Details</a></p>
                 <p><a href="https://sjuv4.linways.com/v4/adm-applicant/login" target="_blank" class="btn-outline">Apply Now</a></p>
                </div>
            </div>    
            
            <!-- PROGRAM -->
            <div class="programme-box">
                <div class="d-flex gap-4 pgm_dtl">
                    <div class="program-icon icon-orange">
                      <i class="fa fa-book"></i>
                    </div>
                    <div>
                      <h5 class="text-blue fw-bold">Master of Arts (M.A.) in Journalism and Mass Communication</h5>
                      <p class="program-degree">PG Programme</p>
              
                    </div>
                </div>
                <div class="batch-info mb-4">
                    <ul class="list-unstyled batch-list">
                      <li class="batch-item">
                        <span>Batch   </span>
                        <strong> 7:00 AM to 1:00 PM</strong>
                      </li>  
                    </ul>
                </div>   
                <p><b>Entrance Test:</b> Yes</p>

                <!-- CTA Buttons -->
                <div class="hero-actions">
                 <button class="btn btn-success fee-btn" data-url="<?php echo LIVE_URL; ?>school-of-communication-media-studies/department-of-communication-media-studies/ma-in-journalism-mass-communication.php"> Fees </button>
                 <p><a href="../school-of-communication-media-studies/department-of-communication-media-studies/ma-in-journalism-mass-communication.php" target="_blank" class="btn btn-warning">Details</a></p>
                 <p><a href="https://sjuv4.linways.com/v4/adm-applicant/login" target="_blank" class="btn-outline">Apply Now</a></p>
                </div>
            </div>    
        </div>
     </div>
     
     <!--SCHOOL-->
     <div class="school-block" data-level="pg" data-school="info_technology">
         <h3 class="text_blue fw-bold mb-3">School of Information Technology</h3>
         <div class="program-grid">

            <!-- PROGRAM -->
            <div class="programme-box">
                <div class="d-flex gap-4 pgm_dtl">
                    <div class="program-icon icon-orange">
                      <i class="fa fa-book"></i>
                    </div>
                    <div>
                      <h5 class="text-blue fw-bold">Master of Computer Applications (MCA)</h5>
                      <p class="program-degree">PG Programme</p>
              
                    </div>
                </div>
                <div class="batch-info mb-4">
                    <ul class="list-unstyled batch-list">
                      <li class="batch-item">
                        <span>Batch   </span>
                        <strong> 	1:00 PM to 7:00 PM</strong>
                      </li>  
                    </ul>
                </div>   
                <p><b>Entrance Test:</b> Yes</p>

                <!-- CTA Buttons -->
                <div class="hero-actions">
                 <button class="btn btn-success fee-btn" data-url="<?php echo LIVE_URL; ?>school-of-information-technology/department-of-computer-science/master-of-computer-applications.php"> Fees </button>
                 <p><a href="../school-of-information-technology/department-of-computer-science/master-of-computer-applications.php" target="_blank" class="btn btn-warning">Details</a></p>
                 <p><a href="https://sjuv4.linways.com/v4/adm-applicant/login" target="_blank" class="btn-outline">Apply Now</a></p>
                </div>
            </div>    
            
            <!-- PROGRAM -->
            <div class="programme-box">
                <div class="d-flex gap-4 pgm_dtl">
                    <div class="program-icon icon-orange">
                      <i class="fa fa-book"></i>
                    </div>
                    <div>
                      <h5 class="text-blue fw-bold">Master of Science (M.Sc.) in Big Data Analytics</h5>
                      <p class="program-degree">PG Programme</p>
              
                    </div>
                </div>
                <div class="batch-info mb-4">
                    <ul class="list-unstyled batch-list">
                      <li class="batch-item">
                        <span>Batch   </span>
                        <strong>9:00 AM to 4:00 PM</strong>
                      </li>  
                    </ul>
                </div>   
                <p><b>Entrance Test:</b> No</p>

                <!-- CTA Buttons -->
                <div class="hero-actions">
                 <button class="btn btn-success fee-btn" data-url="<?php echo LIVE_URL; ?>school-of-information-technology/department-of-advanced-computing/msc-in-big-data-analytics.php"> Fees </button>
                 <p><a href="../school-of-information-technology/department-of-advanced-computing/msc-in-big-data-analytics.php" target="_blank" class="btn btn-warning">Details</a></p>
                 <p><a href="https://sjuv4.linways.com/v4/adm-applicant/login" target="_blank" class="btn-outline">Apply Now</a></p>
                </div>
            </div>    
            <!-- PROGRAM -->
            <div class="programme-box">
                <div class="d-flex gap-4 pgm_dtl">
                    <div class="program-icon icon-orange">
                      <i class="fa fa-book"></i>
                    </div>
                    <div>
                      <h5 class="text-blue fw-bold">	Master of Science (M.Sc.) in Computer Science</h5>
                      <p class="program-degree">PG Programme</p>
              
                    </div>
                </div>
                <div class="batch-info mb-4">
                    <ul class="list-unstyled batch-list">
                      <li class="batch-item">
                        <span>Batch   </span>
                        <strong>9:00 AM to 4:00 PM</strong>
                      </li>  
                    </ul>
                </div>   
                <p><b>Entrance Test:</b> No</p>

                <!-- CTA Buttons -->
                <div class="hero-actions">
                 <button class="btn btn-success fee-btn" data-url="<?php echo LIVE_URL; ?>school-of-information-technology/department-of-computer-science/msc-in-computer-science.php"> Fees </button>
                 <p><a href="../school-of-information-technology/department-of-computer-science/msc-in-computer-science.php" target="_blank" class="btn btn-warning">Details</a></p>
                 <p><a href="https://sjuv4.linways.com/v4/adm-applicant/login" target="_blank" class="btn-outline">Apply Now</a></p>
                </div>
            </div>    
            <!-- PROGRAM -->
            <div class="programme-box">
                <div class="d-flex gap-4 pgm_dtl">
                    <div class="program-icon icon-orange">
                      <i class="fa fa-book"></i>
                    </div>
                    <div>
                      <h5 class="text-blue fw-bold">Master of Science (M.Sc.) in Cyber Security and Artificial Intelligence</h5>
                      <p class="program-degree">PG Programme</p>
              
                    </div>
                </div>
                <div class="batch-info mb-4">
                    <ul class="list-unstyled batch-list">
                      <li class="batch-item">
                        <span>Batch   </span>
                        <strong>7:00 AM to 01:00 PM</strong>
                      </li>  
                    </ul>
                </div>   
                <p><b>Entrance Test:</b> No</p>

                <!-- CTA Buttons -->
                <div class="hero-actions">
                 <button class="btn btn-success fee-btn" data-url="<?php echo LIVE_URL; ?>school-of-information-technology/department-of-computer-science/msc-in-cyber-security-artificial-intelligence.php"> Fees </button>
                 <p><a href="../school-of-information-technology/department-of-computer-science/msc-in-cyber-security-artificial-intelligence.php" target="_blank" class="btn btn-warning">Details</a></p>
                 <p><a href="https://sjuv4.linways.com/v4/adm-applicant/login" target="_blank" class="btn-outline">Apply Now</a></p>
                </div>
            </div>    
        </div>
     </div>
<!--=========================PGD PROGRMMES============================-->     
     <!--SCHOOL-->
     <div class="school-block" data-level="pg-diploma" data-school="business">
         <h3 class="text_blue fw-bold mb-3">School of Business</h3>
         <div class="program-grid">

            <!-- PROGRAM -->
            <div class="programme-box">
                <div class="d-flex gap-4 pgm_dtl">
                    <div class="program-icon icon-orange">
                      <i class="fa fa-book"></i>
                    </div>
                    <div>
                      <h5 class="text-blue fw-bold">Postgraduate Diploma in Financial Management</h5>
                      <p class="program-degree">PG Diploma Programme</p>
              
                    </div>
                </div>
                <div class="batch-info mb-4">
                    <ul class="list-unstyled batch-list">
                      <li class="batch-item">
                        <span>Saturday </span>
                        <strong>Offline class 9:00 AM to 3:00 PM</strong>
                      </li>  
                      <li class="batch-item">
                        <span>Sunday </span>
                        <strong>Online class 9:00 AM to 3:00 PM</strong>
                      </li>  
                    </ul>
                </div>   
                <p><b>Entrance Test:</b> No</p>

                <!-- CTA Buttons -->
                <div class="hero-actions">
                 <button class="btn btn-success fee-btn" data-url="<?php echo LIVE_URL; ?>school-of-business/department-of-commerce/pg-diploma-in-financial-management.php"> Fees </button>
                 <p><a href="../school-of-business/department-of-commerce/pg-diploma-in-financial-management.php" target="_blank" class="btn btn-warning">Details</a></p>
                 <p><a href="https://sjuv4.linways.com/v4/adm-applicant/login" target="_blank" class="btn-outline">Apply Now</a></p>
                </div>
            </div> 
            <!-- PROGRAM -->
            <div class="programme-box">
                <div class="d-flex gap-4 pgm_dtl">
                    <div class="program-icon icon-orange">
                      <i class="fa fa-book"></i>
                    </div>
                    <div>
                      <h5 class="text-blue fw-bold">Postgraduate Diploma in Human Resource Management</h5>
                      <p class="program-degree">PG Diploma Programme</p>
              
                    </div>
                </div>
                <div class="batch-info mb-4">
                    <ul class="list-unstyled batch-list">
                      <li class="batch-item">
                        <span>Saturday </span>
                        <strong>Offline class 9:00 AM to 3:00 PM</strong>
                      </li>  
                      <li class="batch-item">
                        <span>Sunday </span>
                        <strong>Online class 9:00 AM to 3:00 PM</strong>
                      </li>  
                    </ul>
                </div>   
                <p><b>Entrance Test:</b> No</p>

                <!-- CTA Buttons -->
                <div class="hero-actions">
                 <button class="btn btn-success fee-btn" data-url="<?php echo LIVE_URL; ?>school-of-business/department-of-management/post-graduation-diploma-in-human-resource-management.php"> Fees </button>
                 <p><a href="../school-of-business/department-of-management/post-graduation-diploma-in-human-resource-management.php" target="_blank" class="btn btn-warning">Details</a></p>
                 <p><a href="https://sjuv4.linways.com/v4/adm-applicant/login" target="_blank" class="btn-outline">Apply Now</a></p>
                </div>
            </div> 
        </div>
     </div>
     
     <!--SCHOOL-->
     <div class="school-block" data-level="pg-diploma" data-school="communication">
         <h3 class="text_blue fw-bold mb-3">School of Communication & Media Studies</h3>
         <div class="program-grid">

            <!-- PROGRAM -->
            <div class="programme-box">
                <div class="d-flex gap-4 pgm_dtl">
                    <div class="program-icon icon-orange">
                      <i class="fa fa-book"></i>
                    </div>
                    <div>
                      <h5 class="text-blue fw-bold">Executive Diploma Digital Media Communications</h5>
                      <p class="program-degree">PG Diploma Programme</p>
              
                    </div>
                </div>
                <div class="batch-info mb-4">
                    <ul class="list-unstyled batch-list">
                      <li class="batch-item">
                        <span>Tuesday & Thursday </span>
                        <strong>7:30 PM to 8:30 PM (Online Classes)</strong>
                      </li>  
                      <li class="batch-item">
                        <span>Saturday </span>
                        <strong>11:30 AM to 1:00 PM (Offline Classes)</strong>
                      </li>  
                    </ul>
                </div>   
                <p><b>Entrance Test:</b> No</p>

                <!-- CTA Buttons -->
                <div class="hero-actions">
                 <button class="btn btn-success fee-btn" data-url="<?php echo LIVE_URL; ?>school-of-communication-media-studies/department-of-communication-media-studies/executive-diploma-digital-media-communications.php"> Fees </button>
                 <p><a href="../school-of-communication-media-studies/department-of-communication-media-studies/executive-diploma-digital-media-communications.php" target="_blank" class="btn btn-warning">Details</a></p>
                 <p><a href="https://sjuv4.linways.com/v4/adm-applicant/login" target="_blank" class="btn-outline">Apply Now</a></p>
                </div>
            </div>  
        </div>
     </div>
     <!--SCHOOL-->
     <div class="school-block" data-level="pg-diploma" data-school="info_technology">
         <h3 class="text_blue fw-bold mb-3">School of Information Technology</h3>
         <div class="program-grid">

            <!-- PROGRAM -->
            <div class="programme-box">
                <div class="d-flex gap-4 pgm_dtl">
                    <div class="program-icon icon-orange">
                      <i class="fa fa-book"></i>
                    </div>
                    <div>
                      <h5 class="text-blue fw-bold">Postgraduate Diploma in Cyber Security</h5>
                      <p class="program-degree">PG Diploma Programme</p>
              
                    </div>
                </div>
                <div class="batch-info mb-4">
                    <ul class="list-unstyled batch-list">
                      <li class="batch-item">
                        <span>Weekdays (Monday to Friday) online</span>
                        <strong>6:00 PM to 9:00 PM</strong>
                      </li>  
                      <li class="batch-item">
                        <span>Weekend(Saturday ) </span>
                        <strong>on campus - 2:00 PM to 5:00 PM</strong>
                      </li>  
                      <li class="batch-item">
                        <span>Weekend(Sunday)</span>
                        <strong>on campus - 9:00 AM to 5:00 PM</strong>
                      </li>  
                    </ul>
                </div>   
                <p><b>Entrance Test:</b> No</p>

                <!-- CTA Buttons -->
                <div class="hero-actions">
                 <button class="btn btn-success fee-btn" data-url="<?php echo LIVE_URL; ?>school-of-information-technology/department-of-advanced-computing/pg-diploma-in-cyber-security.php"> Fees </button>
                 <p><a href="../school-of-information-technology/department-of-advanced-computing/pg-diploma-in-cyber-security.php" target="_blank" class="btn btn-warning">Details</a></p>
                 <p><a href="https://sjuv4.linways.com/v4/adm-applicant/login" target="_blank" class="btn-outline">Apply Now</a></p>
                </div>
            </div>  
            
            <!-- PROGRAM -->
            <div class="programme-box">
                <div class="d-flex gap-4 pgm_dtl">
                    <div class="program-icon icon-orange">
                      <i class="fa fa-book"></i>
                    </div>
                    <div>
                      <h5 class="text-blue fw-bold">Postgraduate Diploma in Data Analytics</h5>
                      <p class="program-degree">PG Diploma Programme</p>
              
                    </div>
                </div>
                <div class="batch-info mb-4">
                    <ul class="list-unstyled batch-list">
                      <li class="batch-item">
                        <span>Weekdays (Monday to Friday) online</span>
                        <strong>6:00 PM to 9:00 PM</strong>
                      </li>  
                      <li class="batch-item">
                        <span>Weekend(Saturday ) </span>
                        <strong>on campus - 2:00 PM to 5:00 PM</strong>
                      </li>  
                      <li class="batch-item">
                        <span>Weekend(Sunday)</span>
                        <strong>on campus - 9:00 AM to 5:00 PM</strong>
                      </li>  
                    </ul>
                </div>   
                <p><b>Entrance Test:</b> No</p>

                <!-- CTA Buttons -->
                <div class="hero-actions">
                 <button class="btn btn-success fee-btn" data-url="<?php echo LIVE_URL; ?>school-of-information-technology/department-of-advanced-computing/pg-diploma-in-data-analytics.php"> Fees </button>
                 <p><a href="../school-of-information-technology/department-of-advanced-computing/pg-diploma-in-data-analytics.php" target="_blank" class="btn btn-warning">Details</a></p>
                 <p><a href="https://sjuv4.linways.com/v4/adm-applicant/login" target="_blank" class="btn-outline">Apply Now</a></p>
                </div>
            </div>  
        </div>
     </div> 
</div>

</section>
<!-- NO RESULT MESSAGE -->
   <div id="noResults" class="text-center py-5" style="display:none;">
      <h5>No Records Found</h5>
   </div>

  <!--/*MODAL & SCRIPT*/--->
  <div class="modal fade" id="feeModal">
  <div class="modal-dialog modal-lg modal-dialog-scrollable">
    <div class="modal-content">

      <div class="modal-header">
        <h4>Fees Details</h4>
        <button type="button" class="custom-close" data-bs-dismiss="modal">
          <svg width="25" height="25" viewBox="0 0 24 24">
            <line x1="18" y1="6" x2="6" y2="18" stroke="currentColor" stroke-width="2"/>
            <line x1="6" y1="6" x2="18" y2="18" stroke="currentColor" stroke-width="2"/>
          </svg>
        </button>
      </div>

      <div class="modal-body" id="feeContent">
        Loading...
      </div>

    </div>
  </div>
</div>




<!--<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>-->



<script>

/* PROGRAM FILTER */

const levelFilter = document.getElementById("levelFilter");
const schoolFilter = document.getElementById("schoolFilter");
const blocks = document.querySelectorAll(".school-block");
const noResults = document.getElementById("noResults");

function filterCourses(){

let level = levelFilter.value;
let school = schoolFilter.value;

let visibleCount = 0;

blocks.forEach(block=>{

let blockLevel = block.dataset.level;
let blockSchool = block.dataset.school;

let levelMatch = (level === "all" || blockLevel === level);
let schoolMatch = (school === "all" || blockSchool === school);

if(levelMatch && schoolMatch){
block.style.display = "grid";
visibleCount++;
}else{
block.style.display = "none";
}

});

/* SHOW MESSAGE IF NOTHING VISIBLE */

if(visibleCount === 0){
noResults.style.display = "block";
}else{
noResults.style.display = "none";
}

}

document.getElementById("filterBtn").addEventListener("click", filterCourses);

/* run on page load */
filterCourses();



/* FEE MODAL */

document.querySelectorAll(".fee-btn").forEach(btn=>{

btn.addEventListener("click",function(){

let url = this.dataset.url;

document.getElementById("feeContent").innerHTML = "Loading...";

fetch("fee_fetch.php?url="+encodeURIComponent(url)+"&t="+Date.now())
.then(res=>res.text())
.then(data=>{

if(data.trim() === ""){
document.getElementById("feeContent").innerHTML = "Fee details not available.";
}else{
document.getElementById("feeContent").innerHTML = data;
}

})
.catch(()=>{
document.getElementById("feeContent").innerHTML = "Unable to load fee details.";
});

let modal = new bootstrap.Modal(document.getElementById("feeModal"));
modal.show();

});

});

</script> 
  <!-- Footer injected -->
<?php require_once '../footer.php'; ?>

  <!-- Bootstrap JS bundle -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

  <!-- Custom JS -->
  <script src="../assets/js/main.js"></script>
</body>
</html>
