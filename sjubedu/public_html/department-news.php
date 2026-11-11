<!doctype html>
<html lang="en" dir="ltr">

<head>
    <?php include $_SERVER['DOCUMENT_ROOT'] . '/gtm.php'; ?>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>News | St Joseph's University, Bengaluru</title>
    <meta name="description" content="Explore News at St Joseph's University, Bengaluru — a leading Jesuit autonomous university in Karnataka.">
    <meta name="keywords" content="News St Joseph's University Bengaluru, SJU News Bangalore, St Joseph's University Bengaluru, Jesuit university Karnataka">
    <meta name="robots" content="INDEX,FOLLOW">
    <link rel="canonical" href="https://www.sju.edu.in/department-news">

    <!-- Open Graph / Social Sharing -->
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="St Joseph's University, Bengaluru">
    <meta property="og:title" content="News | St Joseph's University, Bengaluru">
    <meta property="og:description" content="Explore News at St Joseph's University, Bengaluru — a leading Jesuit autonomous university in Karnataka.">
    <meta property="og:url" content="https://www.sju.edu.in/department-news">
    <meta property="og:image" content="https://www.sju.edu.in/assets/img/st-joseph-university-logo.png">
    <meta property="og:image:width" content="200">
    <meta property="og:image:height" content="200">
    <meta name="twitter:card" content="summary">
    <meta name="twitter:site" content="@StJosephsUniBLR">
    <meta name="twitter:title" content="News | St Joseph's University, Bengaluru">
    <meta name="twitter:description" content="Explore News at St Joseph's University, Bengaluru — a leading Jesuit autonomous university in Karnataka.">
    <meta name="twitter:image" content="https://www.sju.edu.in/assets/img/st-joseph-university-logo.png">

    <!-- Mobile Specific Metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Favicons - Place favicon.ico in the root directory -->
    <link rel="icon" href="assets/img/favicon.png" type="image/png">
    <!-- Apple Touch Icon (for iOS home screen) -->
    <link rel="apple-touch-icon" href="../assets/img/favicon-apple.png">
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
      "name": "News",
      "item": "https://www.sju.edu.in/department-news"
    }
  ]
}
</script>
</head>
<body>
    <?php require_once 'header.php';
    
    
    
    $deptList = [
52 => 'ADMIN',
53 => 'LIBRARY',
54 => 'COMPUTER SCIENCE',
55 => 'ENGLISH',
59 => 'COMMERCE',
64 => 'ECONOMICS',
65 => 'POLITICAL SCIENCE',
68 => 'COMMUNICATION',
69 => 'PSYCHOLOGY',
70 => 'SOCIAL WORK',
71 => 'PHYSICS',
72 => 'CHEMISTRY',
73 => 'MATHEMATICS',
74 => 'ELECTRONICS',
75 => 'STATISTICS',
77 => 'BOTANY',
78 => 'ZOOLOGY',
79 => 'ENVIRONMENTAL SCIENCE',
80 => 'MICROBIOLOGY',
81 => 'BIOTECHNOLOGY',
83 => 'COMMUNICATION OLD',
84 => 'PHYSICAL EDUCATION',
88 => 'BIG DATA ANALYTICS',
92 => 'TEST',
93 => 'NATURAL SCIENCE',
94 => 'PHYSICAL SCIENCE',
95 => 'SOCIAL SCIENCE',
96 => 'PROFESSIONAL COURSES',
97 => 'VOCATIONAL COURSES',
102 => 'OFFICE',
103 => 'LANGUAGES',
105 => 'FOOD SCIENCE AND TECHNOLOGY',
107 => 'HISTORY',
109 => 'READMIT',
110 => 'IT',
114 => 'PHYSICAL EDUCATION AND LIBRARY',
116 => 'MANAGEMENT',
117 => 'BIOCHEMISTRY',
118 => 'BATCH SHIFT III',
119 => 'INTERNATIONAL RELATIONS PEACE AND PUBLIC POLICY',
120 => 'RESEARCH AND INNOVATION COUNCIL',
121 => 'INSTITUTE OF COMMUNICATION AND MEDIA STUDIES',
122 => 'EXT',
126 => 'SJRIC',
127 => 'BIOLOGY',
129 => 'JOURNALISM',
130 => 'Honours',
131 => 'Center for Human Excellence'
];
  $department_id = $_POST['dep'];
  $department =$deptList[$department_id];

    
    
    ?>
    
<!--BREADCRUMB-->

 <section class="breadcrumb-hero text-white">
  <div class="overlay"></div>
  <div class="container">
    <div class="row">
      <div class="col-12">
        <div class="breadcrumb-content text-center">
          <h1 class="page-title mb-2">News</h1>
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb justify-content-center mb-0">
              <li class="breadcrumb-item">
                <a href="/" class="text-white text-decoration-none">Home</a>
              </li>
              <li class="breadcrumb-item">
                <a href="#" class="text-white text-decoration-none"><?php echo $department;?></a>
              </li>
              <li class="breadcrumb-item active text-warning" aria-current="page">
                News
              </li>
            </ol>
          </nav>
        </div>
      </div>
    </div>
  </div>
</section> 

<section class="news-section py-5">
    <div class="container">

<!-- Tabs -->
        <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-3">

            <div class="btn-group news-tabs">
            <button class="btn btn-light" data-filter="today">Today</button>
            <button class="btn btn-light" data-filter="week">This Week</button>
            <button class="btn btn-light" data-filter="month">This Month</button>
            <button class="btn btn-primary active" data-filter="all">All News</button>
            </div>

            <input type="text" class="form-control search-box" placeholder="Search news..." id="newsSearch">

        </div>


<!-- NEWS LIST -->
<div id="newsContainer">

    <!-- News -->

<?php


$config = file_exists('/home/sjubedu/config.php') ? '/home/sjubedu/config.php' : __DIR__ . '/../../config.php';
require_once $config;
$pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4", DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $today = date('Y-m-d');
$weekStart = date('Y-m-d', strtotime('monday this week'));
$weekEnd = date('Y-m-d', strtotime('sunday this week'));
$monthStart = date('Y-m-01');

$status = 'Y';
 $sql = "SELECT n.title, n.slug, n.description, n.d_start_date,n.c_image
        FROM news n
        JOIN news_departments nd ON n.id = nd.news_id
        WHERE nd.c_department = :department
        AND n.c_status = :status
        AND n.d_start_date >= :today
        ORDER BY n.d_start_date DESC";

          $stmt = $pdo->prepare($sql);
          $stmt->bindParam(':department', $department);
          $stmt->bindParam(':status', $status);
          $stmt->bindParam(':today', $today);

              $stmt->execute();




while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
  $newsDate = date('Y-m-d', strtotime($row['d_start_date']));

if ($newsDate == $today) {
    $category = "today";
}
elseif ($newsDate >= $weekStart && $newsDate <= $weekEnd && $newsDate != $today) {
    $category = "week";
}
elseif ($newsDate >= $monthStart && $newsDate < $weekStart) {
    $category = "month";
}
else {
    $category = "all";
}
    ?>
<div class="news-type p-3" data-category="<?php echo $category; ?>">
       <div class="row g-0">

           <div class="col-md-3 pb-3">
           <img src="sju_admin/assets/admin/uploads/news/large/<?php echo $row['c_image'];?>" class="img-fluid news-img">
           </div>

          <div class="col-md-9">
            <div class="py-2 px-4">
             <span class="news-date"><?php echo date("d-m-Y", strtotime($row['d_start_date']));?></span>

             <h4 class="fw-bold"><?php echo htmlspecialchars($row['title']);?></h4>

             <p><?php 
              $desc = strip_tags($row['description']);
              echo htmlspecialchars(substr($desc,0,200)); 
              if(strlen($desc) >200) echo "...";
              ?></p>

             <a href="news-detail.php?slug=<?php echo $row['slug'];?>" class="news-link fw-bold">Read More â'</a>
            </div>
          </div>
       </div>
 </div>
<?php }?>
       
   







</div>
</div>
</section>
<script>
    const tabs = document.querySelectorAll(".news-tabs button");
const newsCards = document.querySelectorAll(".news-type");
const searchInput = document.getElementById("newsSearch");

tabs.forEach(tab => {

tab.addEventListener("click", function(){

tabs.forEach(btn => btn.classList.remove("active","btn-primary"));
tabs.forEach(btn => btn.classList.add("btn-light"));

this.classList.add("active","btn-primary");
this.classList.remove("btn-light");

let filter = this.getAttribute("data-filter");

newsCards.forEach(card => {

if(filter === "all" || card.dataset.category === filter){
card.style.display = "block";
}else{
card.style.display = "none";
}

});

});

});
 


 //SEARCH
 //const searchInput = document.getElementById("newsSearch");
//const newsCards = document.querySelectorAll(".news-type");

searchInput.addEventListener("keyup", function() {

let searchValue = this.value.toLowerCase();

newsCards.forEach(card => {

let text = card.innerText.toLowerCase();

if(text.includes(searchValue)){
    card.style.display = "block";
}else{
    card.style.display = "none";
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
