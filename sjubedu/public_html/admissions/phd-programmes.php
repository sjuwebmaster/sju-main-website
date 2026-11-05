<!doctype html>
<html lang="en" dir="ltr">

<head>
    <?php include $_SERVER['DOCUMENT_ROOT'] . '/gtm.php'; ?>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>PhD Programmes | St Joseph's University, Bengaluru</title>
    <meta name="description" content="Explore PhD Programmes at St Joseph's University, Bengaluru — UG, PG and doctoral programme admissions 2026. Eligibility, process and important dates.">
    <meta name="keywords" content="admissions St Joseph's University Bengaluru, UG PG admission SJU Bangalore 2026, college admission Karnataka, SJU admissions Bengaluru, Jesuit university admissions">
    <meta name="robots" content="INDEX,FOLLOW">
    <link rel="canonical" href="https://www.sju.edu.in/admissions/phd-programmes">

    <!-- Open Graph / Social Sharing -->
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="St Joseph's University, Bengaluru">
    <meta property="og:title" content="PhD Programmes | St Joseph's University, Bengaluru">
    <meta property="og:description" content="Explore PhD Programmes at St Joseph's University, Bengaluru — UG, PG and doctoral programme admissions 2026. Eligibility, process and important dates.">
    <meta property="og:url" content="https://www.sju.edu.in/admissions/phd-programmes">
    <meta property="og:image" content="https://www.sju.edu.in/assets/img/st-joseph-university-logo.png">
    <meta property="og:image:width" content="200">
    <meta property="og:image:height" content="200">
    <meta name="twitter:card" content="summary">
    <meta name="twitter:site" content="@StJosephsUniBLR">
    <meta name="twitter:title" content="PhD Programmes | St Joseph's University, Bengaluru">
    <meta name="twitter:description" content="Explore PhD Programmes at St Joseph's University, Bengaluru — UG, PG and doctoral programme admissions 2026. Eligibility, process and important dates.">
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
      "name": "PhD Programmes",
      "item": "https://www.sju.edu.in/admissions/phd-programmes"
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
          <h1 class="page-title mb-2">PhD Programmes</h1>
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb justify-content-center mb-0">
              <li class="breadcrumb-item">
                <a href="/" class="text-white text-decoration-none">Home</a>
              </li> 
              <li class="breadcrumb-item active text-warning" aria-current="page">
                 PhD Programmes
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
             <h5 class="fw-bold text-white">Find your Programmes</h5>
         </div>
         <div class="col-lg-4">

             <select id="levelFilter" class="form-select program-filter">
                <option value="all" selected>All Programmes</option>
                <option value="phd">PhD</option>
                <!--<option value="pg">PG</option>
                <option value="pg-diploma">PG Diploma</option>-->
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

      <!-- ===================== PHD PROGRAMMES ===================== -->
      <div class="school-block" data-level="phd" data-school="business">
         <h3 class="text_blue fw-bold mb-3">School of Business</h3>
         <div class="program-grid">

              <!-- PROGRAM -->
              <div class="programme-box">
                <div class="d-flex gap-4 pgm_dtl">
                    <div class="program-icon icon-orange">
                      <i class="fa fa-book"></i>
                    </div>
                    <div>
                      <h5 class="text-blue fw-bold">PhD in Commerce</h5>
                      <p class="program-degree">Doctoral Programme (PhD)</p>
              
                    </div>
                </div>
                <div class="batch-info mb-4">
                    <ul class="list-unstyled batch-list">
                        <li class="batch-item">
                        Full Time Ph.D only
                      </li>
                      <!--<li class="batch-item">
                        <span>Batch I</span>
                        <strong>7:00 AM – 12:00 PM</strong>
                      </li>
                      <li class="batch-item">
                        <span>Batch II</span>
                        <strong>12:00 PM – 04:00 PM</strong>
                      </li>
                      <li class="batch-item">
                        <span>Batch III</span>
                        <strong>04:45 PM – 08:45 PM</strong>
                      </li>
                      <li class="batch-item">
                        <span>Block B (Bannerghatta)</span>
                        <strong>9:00 AM to 4:00 PM</strong>
                      </li>-->
                    </ul>
                </div>
                <!--<p><b>Entrance Test:</b> No</p>-->

                <!-- CTA Buttons -->
                <div class="hero-actions">
                  <button class="btn btn-success fee-btn" data-url="<?php echo LIVE_URL; ?>school-of-business/department-of-commerce/phd-in-commerce.php">Fees</button>
                  <p><a href="../school-of-business/department-of-commerce/phd-in-commerce.php" target="_blank" class="btn btn-warning">Details</a></p>
                  <p><a href="https://sjuv4.linways.com/v4/adm-applicant/login" target="_blank" class="btn-outline">Apply</a></p>
                </div>
             </div>
            
            <!-- PROGRAM -->
            <!-- <div class="programme-box">
                <div class="d-flex gap-4 pgm_dtl">
                    <div class="program-icon icon-orange">
                      <i class="fa fa-book"></i>
                    </div>
                    <div>
                      <h5 class="text-blue fw-bold">PhD in Management</h5>
                      <p class="program-degree">Doctoral Programme (PhD)</p>
              
                    </div>
                </div>
                <div class="batch-info mb-4">
                    <ul class="list-unstyled batch-list">
                      <li class="batch-item">
                        Full Time Ph.D only
                      </li>
                    </ul>
                </div>   -->
                
                <!-- CTA Buttons -->
                <!-- <div class="hero-actions">
                  <button class="btn btn-success fee-btn" data-url="<?php echo LIVE_URL; ?>school-of-business/department-of-management/phd-in-management.php">Fees</button>
                  <p><a href="../school-of-business/department-of-management/phd-in-management.php" target="_blank" class="btn btn-warning">Details</a></p>
                  <p><a href="https://sjuv4.linways.com/v4/adm-applicant/login" target="_blank" class="btn-outline">Apply</a></p>
                </div> 
            </div>   -->
        </div>
     </div>
     
     <div class="school-block" data-level="phd" data-school="chemical">
         <h3 class="text_blue fw-bold mb-3">School of Chemical Sciences</h3>
         <div class="program-grid">

             <!-- PROGRAM -->
            <div class="programme-box">
                <div class="d-flex gap-4 pgm_dtl">
                    <div class="program-icon icon-orange">
                      <i class="fa fa-book"></i>
                    </div>
                    <div>
                      <h5 class="text-blue fw-bold">PhD in Chemistry</h5>
                      <p class="program-degree">Doctoral Programme (PhD)</p>
              
                    </div>
                </div>
                <div class="batch-info mb-4">
                    <ul class="list-unstyled batch-list">
                      <li class="batch-item">
                        Full Time Ph.D only
                      </li>
                    </ul>
                </div>  
                
                <!-- CTA Buttons -->
                <div class="hero-actions">
                  <button class="btn btn-success fee-btn" data-url="<?php echo LIVE_URL; ?>school-of-chemical-sciences/department-of-chemistry/phd-in-chemistry.php">Fees</button>
                  <p><a href="../school-of-chemical-sciences/department-of-chemistry/phd-in-chemistry.php" target="_blank" class="btn btn-warning">Details</a></p>
                  <p><a href="https://sjuv4.linways.com/v4/adm-applicant/login" target="_blank" class="btn-outline">Apply</a></p>
                </div> 
            </div>
            
            
        </div>
     </div>
     <!--SCHOOL-->
     <div class="school-block" data-level="phd" data-school="humanities">
         <h3 class="text_blue fw-bold mb-3">School of Humanities & Social Sciences</h3>
         <div class="program-grid">

              <!-- PROGRAM -->
            <div class="programme-box">
                <div class="d-flex gap-4 pgm_dtl">
                    <div class="program-icon icon-orange">
                      <i class="fa fa-book"></i>
                    </div>
                    <div>
                      <h5 class="text-blue fw-bold">PhD in Economics</h5>
                      <p class="program-degree">Doctoral Programme (PhD)</p>
              
                    </div>
                </div>
                <div class="batch-info mb-4">
                    <ul class="list-unstyled batch-list">
                      <li class="batch-item">
                        Full Time Ph.D only
                      </li>
                    </ul>
                </div>  
                
                <!-- CTA Buttons -->
                <div class="hero-actions">
                  <button class="btn btn-success fee-btn" data-url="<?php echo LIVE_URL; ?>school-of-humanities-and-social-sciences/department-of-economics/phd-in-economics.php">Fees</button>
                  <p><a href="../school-of-humanities-and-social-sciences/department-of-economics/phd-in-economics.php" target="_blank" class="btn btn-warning">Details</a></p>
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
                      <h5 class="text-blue fw-bold">PhD in Political Science</h5>
                      <p class="program-degree">Doctoral Programme (PhD)</p>
              
                    </div>
                </div>
                <div class="batch-info mb-4">
                    <ul class="list-unstyled batch-list">
                      <li class="batch-item">
                        Full Time Ph.D only
                      </li>
                    </ul>
                </div>  
                
                <!-- CTA Buttons -->
                <div class="hero-actions">
                  <button class="btn btn-success fee-btn" data-url="#">Fees</button>
                  <p><a href="#" target="_blank" class="btn btn-warning">Details</a></p>
                  <p><a href="#" target="_blank" class="btn-outline">Apply</a></p>
                </div> 
            </div> 
            
        </div>
     </div>
     <!--SCHOOL-->
     <div class="school-block" data-level="ug" data-school="language">
         <h3 class="text_blue fw-bold mb-3">School of Languages & Literatures</h3>
         <div class="program-grid">

             <!-- PROGRAM -->
            <!-- <div class="programme-box">
                <div class="d-flex gap-4 pgm_dtl">
                    <div class="program-icon icon-orange">
                      <i class="fa fa-book"></i>
                    </div>
                    <div>
                      <h5 class="text-blue fw-bold">PhD in English</h5>
                      <p class="program-degree">Doctoral Programme (PhD)</p>
              
                    </div>
                </div>
                <div class="batch-info mb-4">
                    <ul class="list-unstyled batch-list">
                      <li class="batch-item">
                        Full Time Ph.D only
                      </li>
                    </ul>
                </div>   -->
                
                <!-- CTA Buttons -->
                <!-- <div class="hero-actions">
                  <button class="btn btn-success fee-btn" data-url="<?php echo LIVE_URL; ?>school-of-languages-and-literatures/department-of-english/phd-in-english.php">Fees</button>
                  <p><a href="../school-of-languages-and-literatures/department-of-english/phd-in-english.php" target="_blank" class="btn btn-warning">Details</a></p>
                  <p><a href="https://sjuv4.linways.com/v4/adm-applicant/login" target="_blank" class="btn-outline">Apply</a></p>
                </div> 
            </div> -->
            
             <!-- PROGRAM -->
             <!-- <div class="programme-box">
                <div class="d-flex gap-4 pgm_dtl">
                    <div class="program-icon icon-orange">
                      <i class="fa fa-book"></i>
                    </div>
                    <div>
                      <h5 class="text-blue fw-bold">PhD in Hindi</h5>
                      <p class="program-degree">Doctoral Programme (PhD)</p>
              
                    </div>
                </div>
                <div class="batch-info mb-4">
                    <ul class="list-unstyled batch-list">
                      <li class="batch-item">
                        Full Time Ph.D only
                      </li>
                    </ul>
                </div>   -->
                
                <!-- CTA Buttons -->
                <!-- <div class="hero-actions">
                  <button class="btn btn-success fee-btn" data-url="<?php echo LIVE_URL; ?>school-of-languages-and-literatures/department-of-hindi/phd-in-hindi.php">Fees</button>
                  <p><a href="../school-of-languages-and-literatures/department-of-hindi/phd-in-hindi.php" target="_blank" class="btn btn-warning">Details</a></p>
                  <p><a href="https://sjuv4.linways.com/v4/adm-applicant/login" target="_blank" class="btn-outline">Apply</a></p>
                </div> 
            </div> -->
            
             <!-- PROGRAM -->
            <div class="programme-box">
                <div class="d-flex gap-4 pgm_dtl">
                    <div class="program-icon icon-orange">
                      <i class="fa fa-book"></i>
                    </div>
                    <div>
                      <h5 class="text-blue fw-bold">PhD in Kannada</h5>
                      <p class="program-degree">Doctoral Programme (PhD)</p>
              
                    </div>
                </div>
                <div class="batch-info mb-4">
                    <ul class="list-unstyled batch-list">
                      <li class="batch-item">
                        Full Time Ph.D only
                      </li>
                    </ul>
                </div>  
                
                <!-- CTA Buttons -->
                <div class="hero-actions">
                  <button class="btn btn-success fee-btn" data-url="<?php echo LIVE_URL; ?>school-of-languages-and-literatures/department-of-kannada/phd-in-kannada.php">Fees</button>
                  <p><a href="../school-of-languages-and-literatures/department-of-kannada/phd-in-kannada.php" target="_blank" class="btn btn-warning">Details</a></p>
                  <p><a href="https://sjuv4.linways.com/v4/adm-applicant/login" target="_blank" class="btn-outline">Apply</a></p>
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
                      <h5 class="text-blue fw-bold">PhD in Biotechnology</h5>
                      <p class="program-degree">Doctoral Programme (PhD)</p>
              
                    </div>
                </div>
                <div class="batch-info mb-4">
                    <ul class="list-unstyled batch-list">
                      <li class="batch-item">
                        Full Time Ph.D only
                      </li>
                    </ul>
                </div>  
                
                <!-- CTA Buttons -->
                <div class="hero-actions">
                  <button class="btn btn-success fee-btn" data-url="<?php echo LIVE_URL; ?>school-of-life-sciences/department-of-biotechnology/phd-in-biotechnology.php">Fees</button>
                  <p><a href="../school-of-life-sciences/department-of-biotechnology/phd-in-biotechnology.php" target="_blank" class="btn btn-warning">Details</a></p>
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
                      <h5 class="text-blue fw-bold">PhD in Botany</h5>
                      <p class="program-degree">Doctoral Programme (PhD)</p>
              
                    </div>
                </div>
                <div class="batch-info mb-4">
                    <ul class="list-unstyled batch-list">
                      <li class="batch-item">
                        Full Time Ph.D only
                      </li>
                    </ul>
                </div>  
                
                <!-- CTA Buttons -->
                <div class="hero-actions">
                  <button class="btn btn-success fee-btn" data-url="<?php echo LIVE_URL; ?>school-of-life-sciences/department-of-botany/phd-in-botany.php">Fees</button>
                  <p><a href="../school-of-life-sciences/department-of-botany/phd-in-botany.php" target="_blank" class="btn btn-warning">Details</a></p>
                  <p><a href="https://sjuv4.linways.com/v4/adm-applicant/login" target="_blank" class="btn-outline">Apply</a></p>
                </div> 
            </div>
            <!-- PROGRAM -->
            <!-- <div class="programme-box">
                <div class="d-flex gap-4 pgm_dtl">
                    <div class="program-icon icon-orange">
                      <i class="fa fa-book"></i>
                    </div>
                    <div>
                      <h5 class="text-blue fw-bold">PhD in Environmental Science and Sustainability</h5>
                      <p class="program-degree">Doctoral Programme (PhD)</p>
              
                    </div>
                </div>
                <div class="batch-info mb-4">
                    <ul class="list-unstyled batch-list">
                      <li class="batch-item">
                        Full Time Ph.D only
                      </li>
                    </ul>
                </div>   -->
                
                <!-- CTA Buttons -->
                <!-- <div class="hero-actions">
                  <button class="btn btn-success fee-btn" data-url="<?php echo LIVE_URL; ?>school-of-life-sciences/department-of-environmental-science/phd-in-environmental-science-and-sustainability.php">Fees</button>
                  <p><a href="../school-of-life-sciences/department-of-environmental-science/phd-in-environmental-science-and-sustainability.php" target="_blank" class="btn btn-warning">Details</a></p>
                  <p><a href="https://sjuv4.linways.com/v4/adm-applicant/login" target="_blank" class="btn-outline">Apply</a></p>
                </div> 
            </div> -->
            
            <!-- PROGRAM -->
            <div class="programme-box">
                <div class="d-flex gap-4 pgm_dtl">
                    <div class="program-icon icon-orange">
                      <i class="fa fa-book"></i>
                    </div>
                    <div>
                      <h5 class="text-blue fw-bold">PhD in Microbiology</h5>
                      <p class="program-degree">Doctoral Programme (PhD)</p>
              
                    </div>
                </div>
                <div class="batch-info mb-4">
                    <ul class="list-unstyled batch-list">
                      <li class="batch-item">
                        Full Time Ph.D only
                      </li>
                    </ul>
                </div>  
                
                <!-- CTA Buttons -->
                <div class="hero-actions">
                  <button class="btn btn-success fee-btn" data-url="<?php echo LIVE_URL; ?>school-of-life-sciences/department-of-microbiology/phd-in-microbiology.php">Fees</button>
                  <p><a href="../school-of-life-sciences/department-of-microbiology/phd-in-microbiology.php" target="_blank" class="btn btn-warning">Details</a></p>
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
                      <h5 class="text-blue fw-bold">PhD in Zoology</h5>
                      <p class="program-degree">Doctoral Programme (PhD)</p>
              
                    </div>
                </div>
                <div class="batch-info mb-4">
                    <ul class="list-unstyled batch-list">
                      <li class="batch-item">
                        Full Time Ph.D only
                      </li>
                    </ul>
                </div>  
                
                <!-- CTA Buttons -->
                <div class="hero-actions">
                  <button class="btn btn-success fee-btn" data-url="<?php echo LIVE_URL; ?>school-of-life-sciences/department-of-zoology/phd-in-zoology.php">Fees</button>
                  <p><a href="../school-of-life-sciences/department-of-zoology/phd-in-zoology.php" target="_blank" class="btn btn-warning">Details</a></p>
                  <p><a href="https://sjuv4.linways.com/v4/adm-applicant/login" target="_blank" class="btn-outline">Apply</a></p>
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
                      <h5 class="text-blue fw-bold">PhD in Mathematics</h5>
                      <p class="program-degree">Doctoral Programme (PhD)</p>
              
                    </div>
                </div>
                <div class="batch-info mb-4">
                    <ul class="list-unstyled batch-list">
                      <li class="batch-item">
                        Full Time Ph.D only
                      </li>
                    </ul>
                </div>  
                
                <!-- CTA Buttons -->
                <div class="hero-actions">
                  <button class="btn btn-success fee-btn" data-url="<?php echo LIVE_URL; ?>school-of-physical-sciences/department-of-mathematics/phd-in-mathematics.php">Fees</button>
                  <p><a href="../school-of-physical-sciences/department-of-mathematics/phd-in-mathematics.php" target="_blank" class="btn btn-warning">Details</a></p>
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
                      <h5 class="text-blue fw-bold">PhD in Physics</h5>
                      <p class="program-degree">Doctoral Programme (PhD)</p>
              
                    </div>
                </div>
                <div class="batch-info mb-4">
                    <ul class="list-unstyled batch-list">
                      <li class="batch-item">
                        Full Time Ph.D only
                      </li>
                    </ul>
                </div>  
                
                <!-- CTA Buttons -->
                <div class="hero-actions">
                  <button class="btn btn-success fee-btn" data-url="<?php echo LIVE_URL; ?>school-of-physical-sciences/department-of-physics/phd-in-physics.php">Fees</button>
                  <p><a href="../school-of-physical-sciences/department-of-physics/phd-in-physics.php" target="_blank" class="btn btn-warning">Details</a></p>
                  <p><a href="https://sjuv4.linways.com/v4/adm-applicant/login" target="_blank" class="btn-outline">Apply</a></p>
                </div> 
            </div>
            
        </div>
     </div> 
     
     <!--SCHOOL
     <div class="school-block" data-level="ug" data-school="social">
         <h3 class="text_blue fw-bold mb-3">School of Social Work</h3>
         <div class="program-grid">

             
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

                 
                <div class="hero-actions">
                 <button class="btn btn-success fee-btn" data-url="<?php echo LIVE_URL; ?>school-of-social-work/department-of-social-work/bachelor-of-social-work.php"> Fees </button>
                 <p> <a href="../school-of-social-work/department-of-social-work/bachelor-of-social-work.php" target="_blank" class="btn btn-warning">Details</a></p>
                 <p><a href="https://sjuv4.linways.com/v4/adm-applicant/login" target="_blank" class="btn-outline">Apply Now</a></p>
                </div>
            </div>    
        </div>
     </div>-->
     
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
                      <h5 class="text-blue fw-bold">PhD in Mass Communication</h5>
                      <p class="program-degree">Doctoral Programme (PhD)</p>
              
                    </div>
                </div>
                <div class="batch-info mb-4">
                    <ul class="list-unstyled batch-list">
                      <li class="batch-item">
                        Full Time Ph.D only
                      </li>
                    </ul>
                </div>  
                
                <!-- CTA Buttons -->
                <div class="hero-actions">
                  <button class="btn btn-success fee-btn" data-url="<?php echo LIVE_URL; ?>school-of-communication-media-studies/department-of-communication-media-studies/phd-in-mass-communication.php">Fees</button>
                  <p><a href="../school-of-communication-media-studies/department-of-communication-media-studies/phd-in-mass-communication.php" target="_blank" class="btn btn-warning">Details</a></p>
                  <p><a href="https://sjuv4.linways.com/v4/adm-applicant/login" target="_blank" class="btn-outline">Apply</a></p>
                </div> 
            </div>
        </div>
     </div>
     
     <!--SCHOOL-->
     <div class="school-block" data-level="ug" data-school="info_technology">
         <h3 class="text_blue fw-bold mb-3">School of Information Technology</h3>
         <div class="program-grid">
 <!-- PROGRAM -->
            <!-- <div class="programme-box">
                <div class="d-flex gap-4 pgm_dtl">
                    <div class="program-icon icon-orange">
                      <i class="fa fa-book"></i>
                    </div>
                    <div>
                      <h5 class="text-blue fw-bold">PhD in Advanced Computing</h5>
                      <p class="program-degree">Doctoral Programme (PhD)</p>
              
                    </div>
                </div>
                <div class="batch-info mb-4">
                    <ul class="list-unstyled batch-list">
                      <li class="batch-item">
                        Full Time Ph.D only
                      </li>
                    </ul>
                </div>   -->
                
                <!-- CTA Buttons -->
                <!-- <div class="hero-actions">
                  <button class="btn btn-success fee-btn" data-url="<?php echo LIVE_URL; ?>school-of-information-technology/department-of-advanced-computing/phd-in-advanced-computing.php">Fees</button>
                  <p><a href="../school-of-information-technology/department-of-advanced-computing/phd-in-advanced-computing.php" target="_blank" class="btn btn-warning">Details</a></p>
                  <p><a href="https://sjuv4.linways.com/v4/adm-applicant/login" target="_blank" class="btn-outline">Apply</a></p>
                </div> 
            </div> -->
             <!-- PROGRAM -->
            <div class="programme-box">
                <div class="d-flex gap-4 pgm_dtl">
                    <div class="program-icon icon-orange">
                      <i class="fa fa-book"></i>
                    </div>
                    <div>
                      <h5 class="text-blue fw-bold">PhD in Computer Science</h5>
                      <p class="program-degree">Doctoral Programme (PhD)</p>
              
                    </div>
                </div>
                <div class="batch-info mb-4">
                    <ul class="list-unstyled batch-list">
                      <li class="batch-item">
                        Full Time Ph.D only
                      </li>
                    </ul>
                </div>  
                
                <!-- CTA Buttons -->
                <div class="hero-actions">
                  <button class="btn btn-success fee-btn" data-url="<?php echo LIVE_URL; ?>school-of-information-technology/department-of-computer-science/phd-in-computer-science.php">Fees</button>
                  <p><a href="../school-of-information-technology/department-of-computer-science/phd-in-computer-science.php" target="_blank" class="btn btn-warning">Details</a></p>
                  <p><a href="https://sjuv4.linways.com/v4/adm-applicant/login" target="_blank" class="btn-outline">Apply</a></p>
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
