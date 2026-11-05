<!doctype html>
<html lang="en" dir="ltr">

<head>
    <?php include $_SERVER['DOCUMENT_ROOT'] . '/gtm.php'; ?>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Events | St Joseph's University, Bengaluru</title>
    <meta name="description" content="Explore Events at St Joseph's University, Bengaluru — a leading Jesuit autonomous university in Karnataka.">
    <meta name="keywords" content="Events St Joseph's University Bengaluru, SJU Events Bangalore, St Joseph's University Bengaluru, Jesuit university Karnataka">
    <meta name="robots" content="INDEX,FOLLOW">
    <link rel="canonical" href="https://www.sju.edu.in/events-detail">

    <!-- Open Graph / Social Sharing -->
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="St Joseph's University, Bengaluru">
    <meta property="og:title" content="Events | St Joseph's University, Bengaluru">
    <meta property="og:description" content="Explore Events at St Joseph's University, Bengaluru — a leading Jesuit autonomous university in Karnataka.">
    <meta property="og:url" content="https://www.sju.edu.in/events-detail">
    <meta property="og:image" content="https://www.sju.edu.in/assets/img/st-joseph-university-logo.png">
    <meta property="og:image:width" content="200">
    <meta property="og:image:height" content="200">
    <meta name="twitter:card" content="summary">
    <meta name="twitter:site" content="@StJosephsUniBLR">
    <meta name="twitter:title" content="Events | St Joseph's University, Bengaluru">
    <meta name="twitter:description" content="Explore Events at St Joseph's University, Bengaluru — a leading Jesuit autonomous university in Karnataka.">
    <meta name="twitter:image" content="https://www.sju.edu.in/assets/img/st-joseph-university-logo.png">

    <!-- Mobile Specific Metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Favicons - Place favicon.ico in the root directory -->
    <link rel="icon" href="assets/img/favicon.png" type="image/png">
    <!-- Apple Touch Icon (for iOS home screen) -->
    <link rel="apple-touch-icon" href="assets/img/favicon-apple.png">
    <link rel="manifest" href="assets/img/favicons/manifest.json">
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
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <!-- Fontawesome Icon -->
    <link rel="stylesheet" href="assets/css/fontawesome.min.css">
    <!-- Magnific Popup -->
    <link rel="stylesheet" href="assets/css/magnific-popup.min.css">
    <!-- Swiper Js -->
    <link rel="stylesheet" href="assets/css/swiper-bundle.min.css">
    <!-- Theme Custom CSS -->
    <link rel="stylesheet" href="assets/css/style.css?v=2.3">
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
      "name": "Events",
      "item": "https://www.sju.edu.in/events-detail"
    },
    {
      "@type": "ListItem",
      "position": 3,
      "name": "Events",
      "item": "https://www.sju.edu.in/events-detail"
    }
  ]
}
</script>
</head>
<body>
    <?php require_once 'header.php'; ?>
    <?php
    
$config = file_exists('/home/sjubedu/config.php') ? '/home/sjubedu/config.php' : __DIR__ . '/../../config.php';
require_once $config;
$pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4", DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

//$slug = isset($_GET['slug']) ? urldecode(trim($_GET['slug'])) : '';

function makeSlug($text)
{
    $text = strtolower($text);

    // remove special characters except spaces and hyphen
    $text = preg_replace('/[^a-z0-9\s-]/', '', $text);

    // convert spaces to hyphen
    $text = preg_replace('/\s+/', '-', $text);

    // DO NOT remove double hyphen (important for your DB)
    return trim($text, '-');
}

$slug = $_GET['slug'] ?? '';
$slug = urldecode($slug);
$slug = makeSlug($slug);

$status = 'Y';
  $sql = "SELECT event_name, slug, description, created_at, c_image ,d_start_date,d_end_date,c_file_type,c_pdf,c_url,c_text,
 c_registration,c_registration_link,c_venue,c_phone,c_email
        FROM events 
        WHERE slug = :slug AND c_status = :status 
        LIMIT 1";

$stmt = $pdo->prepare($sql);
$stmt->bindParam(':slug', $slug);
$stmt->bindParam(':status', $status);
$stmt->execute();

$details = $stmt->fetch(PDO::FETCH_ASSOC);

 //$newsDate = date('d-m-Y', strtotime($details['created_at']));

            if (!empty($details['d_start_date']) && $details['d_start_date'] != '0000-00-00') {
									$d_start_date =  date('d-m-Y', strtotime($details['d_start_date']));
								} else {
									$d_start_date = '';
								}
								if (!empty($details['d_end_date']) && $details['d_end_date'] != '0000-00-00') {
									$d_end_date =  date('d-m-Y', strtotime($details['d_end_date']));
								} else {
									$d_end_date = '';
								}

                $c_file_type = $details['c_file_type'];
                $c_pdf = $details['c_pdf'];
                $c_url = $details['c_url'];
                $c_text = $details['c_text'];
                $c_registration = $details['c_registration'];
                $c_registration_link = $details['c_registration_link'];
                $c_venue = $details['c_venue'];
                $c_phone = $details['c_phone'];
                $c_email = $details['c_email'];

               if($c_file_type=="File"){

               $ext = strtolower(pathinfo($c_pdf, PATHINFO_EXTENSION));

              }

              $link = "";
if($c_registration_link){
            if (!preg_match("~^(?:f|ht)tps?://~i", $c_registration_link)) {
                $link = "https://" . $c_registration_link;
            }
}

    ?>
<!--BREADCRUMB-->
 <section class="breadcrumb-hero text-white">
  <div class="overlay"></div>
  <div class="container">
    <div class="row">
      <div class="col-12">
        <div class="breadcrumb-content text-center">
          <h1 class="page-title mb-2"> Events</h1>
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb justify-content-center mb-0">
              <li class="breadcrumb-item">
                <a href="/" class="text-white text-decoration-none">Home</a>
              </li>
              <li class="breadcrumb-item">
                <a href="#" class="text-white text-decoration-none">Events</a>
              </li>
              <li class="breadcrumb-item active text-warning" aria-current="page">
                 Events
              </li>
            </ol>
          </nav>
        </div>
      </div>
    </div>
  </div>
</section>



<section class="event-details py-12 px-4">
<div class="container my-5">

<div class="row align-items-center g-4">

<!-- Event Image -->
<div class="col-lg-12">
<h2 class="event-title"><?php echo htmlspecialchars($details['event_name']);?> <?php echo $d_start_date;?> - <?php echo $d_end_date;?></h2>
</div>
<?php if($c_registration=="Yes"){
  ?>
<div class="col-lg-12">
<a href="<?php echo $link;?>" target="_blank"><button>Register now</button></a>
</div>
<?php }?>
<div class="col-lg-12">
  <?php if($ext=="pdf"){
?>
<iframe src="sju_admin/assets/admin/uploads/events/pdf/<?php echo $details['c_pdf'];?>" width="100%" height="700px"></iframe>
<?php 
  } 
  else if($ext == 'jpg' || $ext == 'jpeg' || $ext == 'png' || $ext == 'gif'){
    ?>
  <img src="sju_admin/assets/admin/uploads/events/pdf/<?php echo $details['c_pdf'];?>" class="img-fluid rounded" alt="Event Image">
<?php } else {?>
<?php echo $details['c_text'];?>
<?php }?>
</div>
</div>
</div>

</div>
</section>


  <!-- Footer injected -->
<?php require_once 'footer.php'; ?>

  <!-- Bootstrap JS bundle -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

  <!-- Custom JS -->
  <script src="assets/js/main.js"></script>
</body>
</html>
