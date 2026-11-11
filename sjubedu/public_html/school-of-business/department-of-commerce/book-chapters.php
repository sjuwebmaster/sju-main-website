<!doctype html>
<html lang="en" dir="ltr">

<head>
    <?php include $_SERVER['DOCUMENT_ROOT'] . '/gtm.php'; ?>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Department of Commerce | St Joseph's University, Bengaluru</title>
    <meta name="description" content="Explore Department of Commerce at St Joseph's University, Bengaluru — a leading Jesuit autonomous university in Karnataka.">
    <meta name="keywords" content="Department of Commerce St Joseph's University Bengaluru, SJU Department of Commerce Bangalore, St Joseph's University Bengaluru, Jesuit university Karnataka">
    <link rel="canonical" href="https://www.sju.edu.in/school-of-business/department-of-commerce/book-chapters">

    <!-- Open Graph / Social Sharing -->
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="St Joseph's University, Bengaluru">
    <meta property="og:title" content="Department of Commerce | St Joseph's University, Bengaluru">
    <meta property="og:description" content="Explore Department of Commerce at St Joseph's University, Bengaluru — a leading Jesuit autonomous university in Karnataka.">
    <meta property="og:url" content="https://www.sju.edu.in/school-of-business/department-of-commerce/book-chapters">
    <meta property="og:image" content="https://www.sju.edu.in/assets/img/st-joseph-university-logo.png">
    <meta property="og:image:width" content="200">
    <meta property="og:image:height" content="200">
    <meta name="twitter:card" content="summary">
    <meta name="twitter:site" content="@StJosephsUniBLR">
    <meta name="twitter:title" content="Department of Commerce | St Joseph's University, Bengaluru">
    <meta name="twitter:description" content="Explore Department of Commerce at St Joseph's University, Bengaluru — a leading Jesuit autonomous university in Karnataka.">
    <meta name="twitter:image" content="https://www.sju.edu.in/assets/img/st-joseph-university-logo.png">
    <meta name="robots" content="INDEX,FOLLOW">

    <!-- Mobile Specific Metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Favicons - Place favicon.ico in the root directory -->
    <link rel="icon" href="../../assets/img/favicon.png" type="image/png">
    <!-- Apple Touch Icon (for iOS home screen) -->
    <link rel="apple-touch-icon" href="../../assets/img/favicon-apple.png">
    <link rel="manifest" href="../../assets/img/favicons/manifest.json">
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
    <link rel="stylesheet" href="../../assets/css/bootstrap.min.css">
    <!-- Fontawesome Icon -->
    <link rel="stylesheet" href="../../assets/css/fontawesome.min.css">
    <!-- Magnific Popup -->
    <link rel="stylesheet" href="../../assets/css/magnific-popup.min.css">
    <!-- Swiper Js -->
    <link rel="stylesheet" href="../../assets/css/swiper-bundle.min.css">
    <!-- Theme Custom CSS -->
    <link rel="stylesheet" href="../../assets/css/style.css?v=2.3">
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
      "name": "School of Business",
      "item": "https://www.sju.edu.in/school-of-business/department-of-commerce/../school-of-business"
    },
    {
      "@type": "ListItem",
      "position": 3,
      "name": "Commerce",
      "item": "https://www.sju.edu.in/school-of-business/department-of-commerce/book-chapters"
    }
  ]
}
</script>
</head>
<body>
    <?php include '../../header.php'; ?>


<!--BREADCRUMB-->
 <section class="breadcrumb-hero text-white">
  <div class="overlay"></div>
  <div class="container">
    <div class="row">
      <div class="col-12">
        <div class="breadcrumb-content text-center">
          <h1 class="page-title mb-2">Department of Commerce</h1>
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb justify-content-center mb-0">
              <li class="breadcrumb-item">
                <a href="/" class="text-white text-decoration-none">Home</a>
              </li>
              <li class="breadcrumb-item">
                <a href="../school-of-business.php" class="text-white text-decoration-none">School of Business</a>
              </li>
              <li class="breadcrumb-item active text-warning" aria-current="page">
                Commerce
              </li>
            </ol>
          </nav>
        </div>
      </div>
    </div>
  </div>
</section>
<!--===================BODY PART=====================-->
<section class="department-layout py-5">
  <div class="container-fluid">
    <div class="row">
<?php
$API_TOKEN='eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJhSWQiOiI0NTNlMzRjNWY1NDU5ZDMxNjg5OCIsImNJZCI6IjYyMDgiLCJvSWQiOiI1IiwiaWF0IjoxNzI0OTE1ODI2fQ.WSAp2aF6p0EiS0kjBzlSvE-1QcLnue8eEvYya0-r4ds';
   $api_url = "https://sjuv4.linways.com/api/v1/exat2/forms/reports/78bfwvpM2D3eTdojY/ALL?departmentId=59";
 
    $api_ch = curl_init();
    curl_setopt($api_ch, CURLOPT_URL, $api_url);
    curl_setopt($api_ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($api_ch, CURLOPT_HTTPHEADER, ["Authorization: $API_TOKEN", "Accept: application/json"]);
    curl_setopt($api_ch, CURLOPT_SSL_VERIFYPEER, false);
    $response_data = curl_exec($api_ch);
    $response_data = json_decode($response_data, true);
    curl_close($api_ch);

echo "<pre>";
print_r($response_data);
echo "</pre>";

?>
   </div>
  </div>
</section>
 


  <!-- Footer injected -->
<?php include '../../footer.php'; ?>

  <!-- Bootstrap JS bundle -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

  <!-- Custom JS -->
  <script src="../../assets/js/main.js"></script>
</body>
</html>
