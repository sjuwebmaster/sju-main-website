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
    <link rel="canonical" href="https://www.sju.edu.in/events">

    <!-- Open Graph / Social Sharing -->
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="St Joseph's University, Bengaluru">
    <meta property="og:title" content="Events | St Joseph's University, Bengaluru">
    <meta property="og:description" content="Explore Events at St Joseph's University, Bengaluru — a leading Jesuit autonomous university in Karnataka.">
    <meta property="og:url" content="https://www.sju.edu.in/events">
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
      "name": "About",
      "item": "https://www.sju.edu.in/events"
    },
    {
      "@type": "ListItem",
      "position": 3,
      "name": "Events",
      "item": "https://www.sju.edu.in/events"
    }
  ]
}
</script>
</head>
<body>
    <?php require_once 'header.php'; ?>
    
<!--BREADCRUMB-->

 <section class="breadcrumb-hero text-white">
  <div class="overlay"></div>
  <div class="container">
    <div class="row">
      <div class="col-12">
        <div class="breadcrumb-content text-center">
          <h1 class="page-title mb-2">Events</h1>
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb justify-content-center mb-0">
              <li class="breadcrumb-item">
                <a href="/" class="text-white text-decoration-none">Home</a>
              </li>
              <!-- <li class="breadcrumb-item">
                <a href="#" class="text-white text-decoration-none">About</a>
              </li> -->
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
  
<section class="events-section py-5 px-4">
<?php
$config = file_exists('/home/sjubedu/config.php') ? '/home/sjubedu/config.php' : __DIR__ . '/../../config.php';
require_once $config;
$pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4", DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$status = 'Y';

$sql = "SELECT event_name, slug, description, d_start_date, c_image,d_end_date,c_file_type,c_url
        FROM events
        WHERE c_status = :status
        ORDER BY d_start_date DESC";

$stmt = $pdo->prepare($sql);
$stmt->bindParam(':status', $status);
$stmt->execute();
$events = [];
$years = [];

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

    $year = date('Y', strtotime($row['d_start_date']));
    $date = date('jS F Y', strtotime($row['d_start_date']));

    $row['year'] = $year;
    $row['date'] = $date;

    $events[] = $row;

    $years[$year] = $year; // prevents duplicate years
}

rsort($years);


    ?>
  <div class="container mb-4">
    <div class="row align-items-center">
      <div class="col-lg-6 col-12">
        <h2 class="fw-bold mb-1">Events</h2>
      </div>

      <div class="col-lg-3 col-md-4 col-12 ms-lg-auto">
        <select class="form-select year-filter" id="yearFilter">
          <option value="all">Select the year</option>
          <?php foreach($years as $year){ ?>
            <option value="<?php echo $year; ?>"><?php echo $year; ?></option>
            <?php } ?>
        </select>
      </div>
    </div>
  </div>

  <!-- Cards -->
  <div class="container">
    <div class="row g-4">
<?php foreach($events as $row){ ?>

<div class="col-lg-4 col-md-6 event-item" data-year="<?php echo $row['year']; ?>">

  <div class="events-card">

    <div class="event-img">
     
      <img src="sju_admin/assets/admin/uploads/events/original/<?php echo $row['c_image'];?>" alt="Image">
    </div>

    <div class="event-content">
<?php
if($row['c_file_type']=="URL"){


$link = $row['c_url'];

if (!preg_match("~^(?:f|ht)tps?://~i", $link)) {
    $link = "https://" . $link;
}
  ?>
 <a href="<?php echo $link;?>" class="">
  <?php
} else {?>

      <a href="events-detail.php?slug=<?php echo $row['slug'];?>" class="">
         <?php
} ?>
      <p class="event-date">
        <i class="fa-regular fa-calendar me-2"></i>
        <?php echo $row['date']; ?>
      </p>

      <h5><?php echo $row['event_name']; ?></h5>
</a>
    </div>

  </div>

</div>

<?php } ?>
     

    </div>
  </div>

</section> 
<script>
document.getElementById('yearFilter').addEventListener('change', function () {
  const selectedYear = this.value;
  const items = document.querySelectorAll('.event-item');

  items.forEach(item => {
     if (selectedYear === "all") {
      item.style.display = "block";
    }
    else
    if (item.getAttribute('data-year') === selectedYear) {
      item.style.display = "block";
    } else {
      item.style.display = "none";
    }
  });
});
</script>
  <!-- Footer injected -->
<?php require_once 'footer.php'; ?>

  <!-- Bootstrap JS bundle -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

  <!-- Custom JS -->
  <script src="assets/js/main.js"></script>
</body>
</html>
