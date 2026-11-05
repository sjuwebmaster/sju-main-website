<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-T6VZSMFG"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->

<style>
/* Prevent scroll chaining on navigation dropdowns */
.scrollable-menu {
    overscroll-behavior: contain;
}
</style>
<section>
<div class="floating-social">
  <button class="social-toggle" aria-label="Social Links">
    <i class="fas fa-share-alt"></i>
  </button>

  <div class="social-links">
    <a href="https://www.facebook.com/sjubengaluru" target="_blank" class="social-iconf fb">
      <i class="fab fa-facebook-f"></i>
    </a>
    <a href="https://twitter.com/sjcbengaluru" target="_blank" class="social-iconf tw">
      <i class="fab fa-twitter"></i>
    </a>
    <a href="https://www.youtube.com/@SJUBengaluru" target="_blank" class="social-iconf yt">
      <i class="fab fa-youtube"></i>
    </a>
    <a href="https://www.linkedin.com/school/sjcbengaluru/" target="_blank" class="social-iconf ln">
      <i class="fab fa-linkedin-in"></i>
    </a>
    <a href="https://www.instagram.com/sjubengaluru/" target="_blank" class="social-iconf ig">
      <i class="fab fa-instagram"></i>
    </a>
  </div>
</div>
</section>
<section>
 <div class="whatsapp-float_icon">
  <a href="https://wa.me/9480811912?text=I%20have%20a%20question%20about%20SJU%20admission" class="" target="_blank" aria-label="Chat on WhatsApp"> 
   <i class="fab fa-whatsapp"></i>
  </a>
 </div> 
</section>
<section>
    <div>
    <!--    <a href="admissions.sju.edu.in" target="_blank"  class="admission-open"> Admissions Open </a>-->
              <a href="https://admissions.sju.edu.in/" target="_blank"  class="admission-open"> Admissions Open </a>

    </div>
</section>
<?php
$topBar = '
<div class="topbar row g-6 align-items-stretch">
        <!-- Left Column (Blue background links) -->
        <div class="col-md-8 col-12 topbar-links d-flex flex-wrap align-items-center justify-content-center">
          <a href="https://alumni.sju.edu.in/" target="_blank"><i class="fa-solid fa-user"></i> Alumni</a>
          <a href="https://sjric.res.in/" target="_blank"><i class="fas fa-book"></i> Research</a>
          <a href="#"><i class="fas fa-building"> </i>NAAC</a>
          <a href="/about/iqac/iqac.php" target="_blank"><i class="fas fa-certificate"> </i>IQAC</a> 
          <a href="https://www.sju.edu.in/announcements"><i class="fas fa-book"></i> Notices</a>
          <a href="/bulletin/sjuannualreport.php"><i class="fas fa-file-signature"> </i>Annual Report</a>
          <a href="/library/library.php"><i class="fa-solid fa-book"></i> Library</a>
          <a href="/publicself-disclosure.php" target="_blank"><i class="fas fa-award"> </i>Public Self - Disclosure</a>
          <a href="/internationalstudents/internationalstudents.php" target="_blank"><i class="fas fa-globe"> </i>For International Students</a>  
          <a href="/climateandworldclock.php" target="_blank"><i class="fas fa-clock"> </i>Climate & Emissions Clock</a>  
          
        </div>
        <!-- Right Column (Yellow background buttons) -->
        <div class="col-md-4 col-12 topbar-buttons d-flex align-items-center">
            <!-- Logo (LEFT) -->
            <a class="navbar-branda me-auto" href="/">
              <img src="/assets/img/st-joseph-university-logo.png" alt="SJU Logo" height="50">
            </a>
            <!-- Right-side actions -->
            <a href="/erp-login.php" target="_blank" class="btn btn-sm">
              <i class="fa-solid fa-user" style="color:#000;"></i> Login
            </a> 

          </div> 
    </div>
    ';
?>
<?php
$mainNav = '
<ul class="navbar-nav mb-2 mb-lg-0">

              <li class="nav-item"><a class="nav-link active" href="/">Home</a></li>

              <!-- ABOUT -->
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="aboutDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">About Us</a>
                <ul class="dropdown-menu scrollable-menu" aria-labelledby="aboutDropdown">
                  <li><a class="dropdown-item" href="/about/about-the-university.php">About the university </a></li>
                  <li><a class="dropdown-item" href="/about/academic-council.php">Academic Council </a></li>
                  <li><a class="dropdown-item" href="/about/milestones.php">History and Milestones </a></li>
                  <li><a class="dropdown-item" href="/about/our-inspiration.php">Our Inspiration </a></li>
                  <li><a class="dropdown-item" href="/about/vision-and-mission.php">Vision and Mission </a></li>
                  <li><a class="dropdown-item" href="/about/sju-anthem-logo.php">Logo and Anthem </a></li>
                  <li><a class="dropdown-item" href="/about/management.php">Management </a></li>
                  <li><a class="dropdown-item" href="/about/calendar.php">Calendar for Academic year </a></li>
                  <li><a class="dropdown-item" href="/about/organogram.php">Organogram</a></li>
                  <li><a class="dropdown-item" href="/about/faculty-members.php">Teaching staff </a></li>
                  <li><a class="dropdown-item" href="/about/non-teaching-staff.php">Non-Teaching Staff</a></li> 
                  <li><a class="dropdown-item" href="/about/jesuit-community-arrupe-nivas.php">Jesuit Community </a></li>
                  <li><a class="dropdown-item" href="/about/iqac/iqac.php">IQAC </a></li>
                  <li><a class="dropdown-item" href="/about/sju-schools.php">Schools and Departments </a></li>
                  <li><a class="dropdown-item" href="/about/finance-commitee.php">Finance Committee </a></li>
                  <li><a class="dropdown-item" href="/about/ombudsperson.php">Ombud Person </a></li> 
                  <li><a class="dropdown-item" href="/about/sponsoring-body.php">Sponsoring body </a></li>
                  <li><a class="dropdown-item" href="/about/contact-us.php">Contact Us</a></li>  
                  <li><a class="dropdown-item" href="/about/external-members.php">BoS External Members </a></li> 
                </ul>
              </li>

              <!-- ACADEMICS -->
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="academicsDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">Academics</a>
                <ul class="dropdown-menu scrollable-menu" aria-labelledby="academicsDropdown">
                  <li><a class="dropdown-item" href="/school-of-business/school-of-business.php">School of Business</a></li>
                  <li><a class="dropdown-item" href="/school-of-chemical-sciences/school-of-chemical-sciences.php">School of Chemical Sciences</a></li>
                  <li><a class="dropdown-item" href="/school-of-humanities-and-social-sciences/school-of-humanities-and-social-sciences.php">School of Humanities & Social Sciences</a></li>
                  <li><a class="dropdown-item" href="/school-of-languages-and-literatures/school-of-languages-and-literatures.php">School of Languages & Literatures</a></li>
                  <li><a class="dropdown-item" href="/school-of-life-sciences/school-of-life-sciences.php">School of Life Sciences</a></li>
                  <li><a class="dropdown-item" href="/school-of-physical-sciences/school-of-physical-sciences.php">School of Physical Sciences</a></li>
                  <li><a class="dropdown-item" href="/school-of-social-work/school-of-social-work.php">School of Social Work</a></li>
                  <li><a class="dropdown-item" href="/school-of-communication-media-studies/school-of-communication-media-studies.php">School of Communication & Media Studies</a></li>
                  <li><a class="dropdown-item" href="/school-of-information-technology/school-of-information-technology.php">School of Information Technology</a></li>
                </ul>
              </li>

              <!-- STUDENT SUPPORT -->
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="studentSupportDropdown" role="button" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false">Student Support</a>
                  <ul class="dropdown-menu scrollable-menu" aria-labelledby="studentSupportDropdown"> 
                    <li><a class="dropdown-item" href="https://ssp.postmatric.karnataka.gov.in/CA/" target="_blank">State Scholarship Portal</a></li>
                     <li><a class="dropdown-item" href="/student-support/antiraggingcell.php">Anti-Ragging cell </a></li>
                    <li><a class="dropdown-item" href="/student-support/common-application.php">Common Application Form </a></li>
                     <li><a class="dropdown-item" href="/student-support/counselling-services.php">Counselling Services </a></li>
                    <li><a class="dropdown-item" href="/student-support/student-grievance-redressal.php">Student Grievance Redressal Committee </a></li>
                     <li><a class="dropdown-item" href="/student-support/campusinistry/campusministry.php">Campus ministry </a></li>
                     <li><a class="dropdown-item" href="/student-support/UGC-E-Samadhaan.php">Online Student Grievance Redressal Portal Of The University Grants Commission (UGC) </a></li>
                     <li><a class="dropdown-item" href="https://www.sju.edu.in/student-support/equaloppurtunitycell">Equal Opportunity Cell </a></li>
                     <li><a class="dropdown-item" href="/services/hostel/university-hostel.php">Hostel </a></li>
                     <li><a class="dropdown-item" href="/student-support/gendersensitisationcell.php">Gender Sensitisation Cell </a></li>
                     <li><a class="dropdown-item" href="/student-support/lateralentry.php">Lateral Entry Admissions</a></li>
                     <li><a class="dropdown-item" href="/student-support/internal-complaints-committee.php">Internal Complaints Committee  </a></li>
                     <li><a class="dropdown-item" href="/about/iqac/iqac.php">IQAC </a></li>
                     <li><a class="dropdown-item" href="/student-support/campusinistry/middaymeals.php">Mid Day Meals</a></li>
                     <li><a class="dropdown-item" href="/services/sju-nss/national-service-scheme.php">NSS</a></li>
                     <li><a class="dropdown-item" href="/placements/about-placements.php">Placements</a></li>
                     <li><a class="dropdown-item" href="/student-support/prevention-of-caste-based-discrimination.php">Prevention of Caste Based Discrimination</a></li>
                     <li><a class="dropdown-item" href="https://www.sju.edu.in/student-support/scholarships_page">Scholarships</a></li>
                     <li><a class="dropdown-item" href="/student-support/sjureadmission.php">Readmissions 2025</a></li>
                     <li><a class="dropdown-item" href="/student-support/facilitiesfordifferentlyabled.php">Facilities For Differently Abled</a></li>
                     <li><a class="dropdown-item" href="/student-support/medicalfacilities.php">Health Facilities </a></li>
                </ul>
              </li>
              <!-- EXAMINATIONS -->
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="examinationsDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">Examinations</a>
                <ul class="dropdown-menu scrollable-menu" aria-labelledby="examinationsDropdown">
                  <li><a class="dropdown-item" href="/examination/applicationform.php">Application Forms</a></li>
                  <li><a class="dropdown-item" href="/examination/controller-of-examinations.php">Controller of Examinations </a></li>
                  <li><a class="dropdown-item" href="/examination/examinationnotices.php">Examination Notices</a></li>
                  <li><a class="dropdown-item" href="/examination/sjuexamseatingarrangement.php">Examination Seating Arrangements </a></li>
                  <li><a class="dropdown-item" href="/examination/toppers.php">Examination Toppers </a></li>
                  <li><a class="dropdown-item" href="/examination/rank-holders.php">Rank Holders</a></li>
                  <li><a class="dropdown-item" href="/examination/exam-time-table.php">Test/ Exam Timetable</a></li>
                  <li><a class="dropdown-item" href="/examination/examinationmanual.php">Examination Manual</a></li>
                </ul>
              </li>

              <!-- SERVICES -->
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="servicesDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">Services</a>
                <ul class="dropdown-menu scrollable-menu" aria-labelledby="servicesDropdown">
                  <li><a class="dropdown-item" href="https://sjuv4.linways.com/v4/adm-applicant/login" target="_blank">Applicant Login</a></li>
                  <li><a class="dropdown-item" href="https://ssp.postmatric.karnataka.gov.in/homepage.aspx" target="_blank">State Scholarship Portal</a></li>
                  <li><a class="dropdown-item" href="https://alumni.sju.edu.in/" target="_blank">Alumni Login</a></li>
                  <li><a class="dropdown-item" href="https://www.sju.edu.in/announcements" target="_blank">Announcements</a></li>
                  <li><a class="dropdown-item" href="/services/sju-campus-facilities.php">Campus Facilities</a></li> 
                  <li><a class="dropdown-item" href="/services/certificate-courses.php">Certificate Courses</a></li>
                  <li><a class="dropdown-item" href="/services/sju-document-verification.php">Document Verification</a></li>
                  <li><a class="dropdown-item" href="/services/hostel/university-hostel.php">Hostel </a></li>
                  <li><a class="dropdown-item" href="/services/sju-hdrc-fdp.php">HDRC (FDP)</a></li> 
                  <li><a class="dropdown-item" href="/services/sju-national-cadet-corps.php">National Cadet Corps</a></li>
                  <li><a class="dropdown-item" href="/news-archive.php">News and Events</a></li>
                  <li><a class="dropdown-item" href="/services/sju-nss/national-service-scheme.php">National Service Scheme</a></li>
                  <li><a class="dropdown-item" href="/services/outreach.php">Outreach</a></li>
                  <!--<li><a class="dropdown-item" href="/services/placements/about-placements.php">Placements</a></li>-->
                  <li><a class="dropdown-item" href="/services/pro.php">PRO</a></li>
                  <li><a class="dropdown-item" href="https://www.sju.edu.in/services/sports">Sports</a></li>
                  <li><a class="dropdown-item" href="/services/sju-staff-residence.php">Staff Residence</a></li> 
                  <li><a class="dropdown-item" href="https://accounts.google.com/v3/signin/identifier?continue=https%3A%2F%2Fmail.google.com%2Fmail%2F&hd=sju.edu.in&osid=1&sacu=1&service=mail&flowName=GlifWebSignIn&flowEntry=AddSession&dsh=S1111217219%3A1721756108719345&ddm=0" target="_blank">Staff Email Login</a></li>
                  <li><a class="dropdown-item" href="/services/student-council/student-council.php">Student Counselling </a></li>  
                  <li><a class="dropdown-item" href="/services/timetable/time-table-2025.php">Timetable 2025 </a></li>   
                  <li><a class="dropdown-item" href="/services/sustainable-tomorrow/chemical-sciences-for-a-sustainable-tomorrow.php">Chemical Sciences for a Sustainable Tomorrow: Synergy and Solutions (CSSTSS-2025) </a></li>
                  <li><a class="dropdown-item" href="/services/ek-bharat-shrestha-bharath-club.php">Ek Bharat Shrestha Bharath Club </a></li>
                  <li><a class="dropdown-item" href="/services/icstat/international-conference-statistical-theory-applications-trends.php">International Conference on Statistical Theory and Applications for Trends (STAT-2025)</a></li>
                  <li><a class="dropdown-item" href="/services/trends-in-biotechnology/recent-trends-in-biotechnology.php">Recent Trends in Biotechnology</a></li>
                  <li><a class="dropdown-item" href="/services/ncma/national-conference-mathematical-advances.php">NCMA </a></li>
                  <li><a class="dropdown-item" href="https://www.sju.edu.in/services/che/che-about.php">Centre for Human Excellence</a></li>
                  <li><a class="dropdown-item" href="/services/symposium/aboutstjosephuniversity.php">One-day National Symposium on Emerging and re-emerging infections with a focus on antimicrobial resistance</a></li>
                  <li><a class="dropdown-item" href="/services/icma/icma.php">ICMA</a></li>
                  <li><a class="dropdown-item" href="/services/iks.php">IKS  </a></li>
                
                </ul>
              </li>

              <!-- BULLETIN -->
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="bulletinDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">Bulletin</a>
                <ul class="dropdown-menu scrollable-menu" aria-labelledby="bulletinDropdown">
                  <li><a class="dropdown-item" href="/bulletin/sjubeacon.php">The Beacon</a></li>
                  <li><a class="dropdown-item" href="/bulletin/sjuphotobeacon.php">Photo Beacon</a></li>
                  <li><a class="dropdown-item" href="/bulletin/sjucommunique.php">Communique</a></li>
                  <li><a class="dropdown-item" href="/bulletin/magazines.php">University Magazines</a></li>
                  <li><a class="dropdown-item" href="/bulletin/sjuradioicms.php">Radio ICMS</a></li>
                  <li><a class="dropdown-item" href="#">Joseph\'s News</a></li>
                  <li><a class="dropdown-item" href="/bulletin/sjuepigramddebsoc.php">Epigram SJU DEBSOC</a></li>
                  <li><a class="dropdown-item" href="/bulletin/sjuauditedreport.php">SJU Audit Report</a></li>
                  <li><a class="dropdown-item" href="/bulletin/sjuannualreport.php">SJU Annual Report</a></li>
                </ul>
              </li>

              <!-- WHY SJU -->
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="whySjuDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">Why SJU</a>
                <ul class="dropdown-menu scrollable-menu" aria-labelledby="whySjuDropdown"> 
                  <li><a class="dropdown-item" href="/whysju/shift3.php">Shift-III</a></li> 
                  <li><a class="dropdown-item" href="/whysju/career.php">Careers</a></li>
                  <li><a class="dropdown-item" href="/whysju/oianotice/oianotice.php">OIA Notice</a></li>
                </ul>
              </li>
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="admissionsDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">Admissions</a>
                <ul class="dropdown-menu scrollable-menu" aria-labelledby="admissionsDropdown">
                  <li><a class="dropdown-item" href="/admissions/admissions.php" target="_blank">Admission Process</a></li>
                  <li><a class="dropdown-item" href="https://sjub.sju.edu.in/" target="_blank">Admissions Block B 2026</a></li>
                  <li><a class="dropdown-item" href="/admissions/all-programmes.php">Undergraduate Programmes</a></li>
                  <li><a class="dropdown-item" href="/admissions/all-programmes.php">Postgraduate Programmes</a></li>
                  <li><a class="dropdown-item" href="https://www.sju.edu.in/admissions/phd-programmes">Ph.D. Programmes</a></li>
                  <li><a class="dropdown-item" href="/admissions/all-programmes.php">PG Diploma</a></li> 
                  <li><a class="dropdown-item" href="/assets/documents/SJU-Refund-Policy.pdf">Fee Refund Policy </a></li>
                  <li><a class="dropdown-item" href="/faq.php" target="_blank" class="btn btn-sm"> FAQ  </a></li>
                </ul>
              </li>
              

            </ul>
';
?>

<header>
   <div class="top-info-bar">
     <div class="container-fluid top-info-inner">
       <!-- Left Text -->
       <div class="top-info-text">
         <i class="fa-solid fa-location-dot"></i>&nbsp;&nbsp;36, Lalbagh Road, Bengaluru-560027, Karnataka, India.
       </div>
       <div class="top-info-text">
         A Public-Private-Partnership University under RUSA 2.0 of MHRD
         (Government of India), established by the Karnataka Govt. Act No. 24 of 2021
       </div>
       <div class="top-info-text">
        <!-- <a href="/assets/documents/UGC-Proforma_.pdf" target="_blank" class="text-white"> UGC Proforma/Mandatory Disclosure</a> | -->
         <a href="https://sjudata.s3.ap-south-1.amazonaws.com/University+Docs/UGC-Proforma_.pdf" target="_blank" class="text-white"> UGC Proforma/Mandatory Disclosure</a> | 

         <a href="/about/iqac/sju-iqac-nirf.php" target="_blank" class="text-white"> NIRF  </a>  | 
         
         <a href="/admissions/admissions.php" target="_blank" class="text-white"> Admissions  </a>
         
       </div> 
     </div>
   </div>

<!--Main Header-->
<div class="sju-header">
  <div class="container-fluid header-container">
    <!-- Left: Logo -->
    <div class="header-left">
      <a href="https://sju.edu.in" class="brand-logo">
        <img src="/assets/img/st-joseph-university-logo.png" alt="SJU Logo">
      </a>
    </div>

    <!-- Right: Topbar + Navbar -->
    <div class="header-right">
      <!-- Topbar -->
     <?php echo $topBar; ?>



      <!-- Navbar -->
      <nav class="navbar navbar-expand-lg">
        <div class="container-fluid p-0">
          <!-- Mobile logo + toggle -->
          <a class="navbar-brand" href="/">
            <img src="/assets/img/st-joseph-university-logo.png" alt="SJU Logo" height="50">
          </a>

          <button class="navbar-toggler ms-auto" type="button" data-bs-toggle="collapse"
            data-bs-target="#sjuNavbar" aria-controls="sjuNavbar" aria-expanded="false"
            aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>

          <div class="collapse navbar-collapse fade-menu" id="sjuNavbar">
            <!-- Close button (mobile only) -->
            <button type="button" class="btn-close d-lg-none ms-auto mb-3" data-bs-toggle="collapse"
              data-bs-target="#sjuNavbar" aria-label="Close"></button>

            <?php echo $mainNav; ?>
          </div>
        </div>
      </nav>
    </div>
  </div>
 </div>
  
</header>
<div id="sticky-sentinel"></div>
<!--====================STICKY HEADER=====================
=======================================================-->
<header id="stickyHeader" class="sju-sticky-header">
   <div class="container-fluid d-flex align-items-center justify-content-between">
     <div class="header-right">
      <!-- Topbar -->
     <?php echo $topBar; ?>
     </div>
    </div>
    <div class="container-fluid d-flex align-items-center justify-content-around py-2"   style="box-shadow: 0 4px 8px rgba(0,0,0,0.15);">
    <!-- Logo --> 
    <a href="/" class="brand-sticky sticky-logo align-items-left">
      <img src="/assets/img/st-joseph-university-logo.png" height="50" alt="SJU">
    </a>
    <!-- DESKTOP NAV -->
    <nav class="navbar navbar-expand-lg d-none d-lg-flex" id="stickyNavbar">
        <?php echo $mainNav; ?>
    </nav>

    <!-- MOBILE TOGGLE -->
    <button class="navbar-toggler d-lg-none"
      data-bs-toggle="collapse"
      data-bs-target="#mobileNavbar">
      <span class="navbar-toggler-icon"></span>
    </button>

  </div>
  <!--MOBILE STICKY-->
<div class="collapse navbar-collapse sju-mobile-nav d-lg-none" id="mobileNavbar">
  <nav class="navbar">
     <?php echo $mainNav; ?>
  </nav>
</div>
     
</header>
 <script>
     document.addEventListener("DOMContentLoaded", function () {

  function closeMainHeaderDropdowns() {

    const header = document.querySelector('.sju-header');
    if (!header) return;

    // Get all dropdown toggles ONLY inside main header
    const toggles = header.querySelectorAll('[data-bs-toggle="dropdown"]');

    toggles.forEach(function (toggle) {

      // Force Bootstrap instance
      let instance = bootstrap.Dropdown.getInstance(toggle);

      if (!instance) {
        instance = new bootstrap.Dropdown(toggle);
      }

      instance.hide(); // Proper Bootstrap close
    });

    // HARD RESET (fallback)
    header.querySelectorAll('.dropdown-menu').forEach(menu => {
      menu.classList.remove('show');
    });

    header.querySelectorAll('.dropdown').forEach(drop => {
      drop.classList.remove('show');
    });

    header.querySelectorAll('[aria-expanded="true"]').forEach(el => {
      el.setAttribute('aria-expanded', 'false');
    });

  }

  //Trigger ONLY when user scrolls DOWN
  let lastScroll = 0;

  window.addEventListener("scroll", function () {

    let currentScroll = window.pageYOffset;

    if (currentScroll > lastScroll) {
      closeMainHeaderDropdowns();
    }

    lastScroll = currentScroll;

  });

});
 </script>
 <script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@graph": [

    {
      "@type": "CollegeOrUniversity",
      "@id": "https://www.sju.edu.in/#university",
      "name": "St Joseph’s University",
      "url": "https://www.sju.edu.in/",
      "logo": "https://www.sju.edu.in/assets/img/st-joseph-university-logo.png",
      "description": "St Joseph’s University is the best university in Bangalore and a premier Jesuit institution offering UG, PG, Ph.D and diploma programs across business, sciences, humanities, media and technology disciplines.",

      "address": {
        "@type": "PostalAddress",
        "streetAddress": "36 Lalbagh Road",
        "addressLocality": "Bengaluru",
        "addressRegion": "Karnataka",
        "postalCode": "560027",
        "addressCountry": "IN"
      },

      "geo": {
        "@type": "GeoCoordinates",
        "latitude": 12.9624055,
        "longitude": 77.5964362
      },

      "contactPoint": {
        "@type": "ContactPoint",
        "telephone": "+91-8022274079",
        "contactType": "customer support",
        "email": "desk@sju.edu.in"
      },

      "sameAs": [
        "https://www.facebook.com/sjubengaluru",
        "https://x.com/sjcbengaluru",
        "https://www.youtube.com/@SJUBengaluru",
        "https://www.linkedin.com/school/sjcbengaluru/",
        "https://www.instagram.com/sjubengaluru/"
      ],

      "hasMap": "https://share.google/BuSDWVxCn6pzaANBa",

      "department": [
        { "@type": "EducationalOrganization", "name": "School of Business" },
        { "@type": "EducationalOrganization", "name": "School of Chemical Sciences" },
        { "@type": "EducationalOrganization", "name": "School of Humanities & Social Sciences" },
        { "@type": "EducationalOrganization", "name": "School of Languages & Literatures" },
        { "@type": "EducationalOrganization", "name": "School of Life Sciences" },
        { "@type": "EducationalOrganization", "name": "School of Physical Sciences" },
        { "@type": "EducationalOrganization", "name": "School of Social Work" },
        { "@type": "EducationalOrganization", "name": "School of Communication & Media Studies" },
        { "@type": "EducationalOrganization", "name": "School of Information Technology" }
      ],

      "offers": {
        "@type": "EducationalOccupationalProgram",
        "name": "Academic Programs",
        "educationalProgramMode": "Full-time",
        "programType": [
          "Undergraduate",
          "Postgraduate",
          "Doctoral",
          "PG Diploma"
        ],
        "provider": {
          "@id": "https://www.sju.edu.in/#university"
        }
      },

      "award": [
        "NAAC Accredited",
        "NIRF Ranked Institution",
        "QS I-GAUGE Gold Rating"
      ]
    },

    {
      "@type": "WebSite",
      "@id": "https://www.sju.edu.in/#website",
      "url": "https://www.sju.edu.in/",
      "name": "St Joseph’s University",
      "publisher": {
        "@id": "https://www.sju.edu.in/#university"
      },
      "potentialAction": {
        "@type": "SearchAction",
        "target": "https://www.sju.edu.in/search?q={search_term_string}",
        "query-input": "required name=search_term_string"
      }
    }

  ]
}
</script>
