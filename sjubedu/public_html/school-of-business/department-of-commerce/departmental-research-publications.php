<!doctype html>
<html lang="en" dir="ltr">

<head>
    <?php include $_SERVER['DOCUMENT_ROOT'] . '/gtm.php'; ?>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Publications | St Joseph's University, Bengaluru</title>
    <meta name="description" content="Explore Publications at St Joseph's University, Bengaluru — a leading Jesuit autonomous university in Karnataka.">
    <meta name="keywords" content="Publications St Joseph's University Bengaluru, SJU Publications Bangalore, St Joseph's University Bengaluru, Jesuit university Karnataka">
    <link rel="canonical" href="https://www.sju.edu.in/school-of-business/department-of-commerce/departmental-research-publications">

    <!-- Open Graph / Social Sharing -->
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="St Joseph's University, Bengaluru">
    <meta property="og:title" content="Publications | St Joseph's University, Bengaluru">
    <meta property="og:description" content="Explore Publications at St Joseph's University, Bengaluru — a leading Jesuit autonomous university in Karnataka.">
    <meta property="og:url" content="https://www.sju.edu.in/school-of-business/department-of-commerce/departmental-research-publications">
    <meta property="og:image" content="https://www.sju.edu.in/assets/img/st-joseph-university-logo.png">
    <meta property="og:image:width" content="200">
    <meta property="og:image:height" content="200">
    <meta name="twitter:card" content="summary">
    <meta name="twitter:site" content="@StJosephsUniBLR">
    <meta name="twitter:title" content="Publications | St Joseph's University, Bengaluru">
    <meta name="twitter:description" content="Explore Publications at St Joseph's University, Bengaluru — a leading Jesuit autonomous university in Karnataka.">
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
      "name": "Department of Commerce",
      "item": "https://www.sju.edu.in/school-of-business/department-of-commerce/department-of-commerce"
    },
    {
      "@type": "ListItem",
      "position": 3,
      "name": "Publications",
      "item": "https://www.sju.edu.in/school-of-business/department-of-commerce/departmental-research-publications"
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
          <h1 class="page-title mb-2">Publications</h1>
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb justify-content-center mb-0">
              <li class="breadcrumb-item">
                <a href="/" class="text-white text-decoration-none">Home</a>
              </li>
              <li class="breadcrumb-item">
                <a href="department-of-commerce.php" class="text-white text-decoration-none">Department of Commerce</a>
              </li>
              <li class="breadcrumb-item active text-warning" aria-current="page">
                Publications
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
  <div class="container"> 
  
    <?php

$API_TOKEN='YOUR_API_TOKEN';

$api_url = "https://sjuv4.linways.com/api/v1/exat2/forms/reports/36rBxCwiGkjZ2aBi2/ALL?departmentId=$department_id";

$api_ch = curl_init();
curl_setopt($api_ch, CURLOPT_URL, $api_url);
curl_setopt($api_ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($api_ch, CURLOPT_HTTPHEADER, ["Authorization: $API_TOKEN", "Accept: application/json"]);
curl_setopt($api_ch, CURLOPT_SSL_VERIFYPEER, false);

$response_data = curl_exec($api_ch);
$response_data = json_decode($response_data, true);
curl_close($api_ch);

?>
<div class="table-responsive" id="publicationTable-<?php echo $report_id; ?>">

<table class="table table-bordered align-middle api_table">

<thead>
<tr>
<th>Sl. no.</th>
<th>Name of Faculty</th>
<th>Title</th>
<th>Name of Journal</th>
<th>Year</th>
<th>DOI/URL</th>
</tr>
</thead>

<tbody id="tableBody-<?php echo $report_id; ?>">

<?php
$cnt=0;

if (!empty($response_data['data'])) {

usort($response_data['data'], function($a, $b) {

$dateA = strtotime($a['Year'] ?? '');
$dateB = strtotime($b['Year'] ?? '');

if ($dateA != $dateB) {
return $dateB - $dateA;
}

return strcmp(
$a['Name of Faculty'] ?? '',
$b['Name of Faculty'] ?? ''
);

});

foreach ($response_data['data'] as $row) {

$cnt++;
?>

<tr>

<td><?php echo $cnt;?></td>

<td><?php echo htmlspecialchars($row['Name of Faculty'] ?? '') ?></td>

<td><?php echo htmlspecialchars($row['Title'] ?? '') ?></td>

<td><?php echo htmlspecialchars($row['Name of Journal'] ?? '') ?></td>

<td><?php echo htmlspecialchars($row['Year'] ?? '') ?></td>

<td>

<?php if (!empty($row['DOI/URL'])) { ?>

<a class="fw-semibold text-primary text-decoration-none"
href="<?php echo $row['DOI/URL']; ?>" target="_blank">
View More
</a>

<?php } ?>

</td>

</tr>

<?php
}
}
?>

</tbody>
</table>

<nav class="mt-4">
<ul id="pagination-<?php echo $report_id; ?>" class="pagination justify-content-center"></ul>
</nav>

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
