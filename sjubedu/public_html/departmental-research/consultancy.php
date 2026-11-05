<!doctype html>
<html lang="en" dir="ltr">

<head>
    <?php include $_SERVER['DOCUMENT_ROOT'] . '/gtm.php'; ?>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Consultancy | St Joseph's University, Bengaluru</title>
    <meta name="description" content="Explore Consultancy at St Joseph's University, Bengaluru — a leading Jesuit autonomous university in Karnataka.">
    <meta name="keywords" content="Consultancy St Joseph's University Bengaluru, SJU Consultancy Bangalore, St Joseph's University Bengaluru, Jesuit university Karnataka">
    <link rel="canonical" href="https://www.sju.edu.in/departmental-research/consultancy">

    <!-- Open Graph / Social Sharing -->
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="St Joseph's University, Bengaluru">
    <meta property="og:title" content="Consultancy | St Joseph's University, Bengaluru">
    <meta property="og:description" content="Explore Consultancy at St Joseph's University, Bengaluru — a leading Jesuit autonomous university in Karnataka.">
    <meta property="og:url" content="https://www.sju.edu.in/departmental-research/consultancy">
    <meta property="og:image" content="https://www.sju.edu.in/assets/img/st-joseph-university-logo.png">
    <meta property="og:image:width" content="200">
    <meta property="og:image:height" content="200">
    <meta name="twitter:card" content="summary">
    <meta name="twitter:site" content="@StJosephsUniBLR">
    <meta name="twitter:title" content="Consultancy | St Joseph's University, Bengaluru">
    <meta name="twitter:description" content="Explore Consultancy at St Joseph's University, Bengaluru — a leading Jesuit autonomous university in Karnataka.">
    <meta name="twitter:image" content="https://www.sju.edu.in/assets/img/st-joseph-university-logo.png">
    <meta name="robots" content="INDEX,FOLLOW">

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
      "name": "Department of",
      "item": "https://www.sju.edu.in/departmental-research/consultancy"
    },
    {
      "@type": "ListItem",
      "position": 3,
      "name": "Consultancy",
      "item": "https://www.sju.edu.in/departmental-research/consultancy"
    }
  ]
}
</script>
</head>
<body>
    <?php include '../header.php'; ?>
 
   <?php
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

    // Fetch the specific Form ID from the array in your config.php
    $form_id = isset($FORM_IDS['consultancy']) ? $FORM_IDS['consultancy'] : '';

    if (empty($form_id)) {
        die("Error: PhD Form ID is missing from the configuration.");
    }
   
  
   
   $department_id = $_POST['dep'];
   $api_url = "https://sjuv4.linways.com/api/v1/exat2/forms/reports/{$form_id}/ALL?departmentId={$department_id}";
 
    $api_ch = curl_init();
    curl_setopt($api_ch, CURLOPT_URL, $api_url);
    curl_setopt($api_ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($api_ch, CURLOPT_HTTPHEADER, ["Authorization: $API_TOKEN", "Accept: application/json"]);
    curl_setopt($api_ch, CURLOPT_SSL_VERIFYPEER, false);
    $response_data = curl_exec($api_ch);
    $response_data = json_decode($response_data, true);
    curl_close($api_ch);

// echo "<pre>";
// print_r($response_data);
// echo "</pre>";
 $totalRecords = $response_data['totalRecords'];

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
if($totalRecords==0){

    $department_name =$deptList[$department_id];
} else {
  $department_name =$response_data['data'][1]['Department'];
}

?>

<!--BREADCRUMB-->
 <section class="breadcrumb-hero text-white">
  <div class="overlay"></div>
  <div class="container">
    <div class="row">
      <div class="col-12">
        <div class="breadcrumb-content text-center">
          <h1 class="page-title mb-2">Consultancy</h1>
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb justify-content-center mb-0">
              <li class="breadcrumb-item">
                <a href="/" class="text-white text-decoration-none">Home</a>
              </li>
              <li class="breadcrumb-item">
                <a class="text-white text-decoration-none">Department of <?php echo $department_name; ?></a>
              </li>
              <li class="breadcrumb-item active text-warning" aria-current="page">
                Consultancy
              </li>
            </ol>
          </nav>
        </div>
      </div>
    </div>
  </div>
</section>
<section class="department-layout py-5">
  <div class="container"> 
  
  
                      
                    <div class="table-responsive" id="publicationTable">
                      <table class="table table-responsive table-bordered align-middle api_table">
                          <thead>
         <tr>
            <th>Sl. no.</th>
            <th>Name of Faculty</th>
            <th>Name of Consultancy Project</th>
            <th>Sponsoring Agency</th>
            <th>Date of Consultancy</th>
            <th>Revenue Generated (amount in Rupees)</th>
            
        </tr>
    </thead>
    <tbody id="tableBody">
        <?php
		$cnt=0;
        if (!empty($response_data['data'])) {
            foreach ($response_data['data'] as $row) {
				$cnt++;
                ?>
                <tr>
                <td class="align-top"><?php echo $cnt;?></td>
                     <td class="align-top"><?php echo htmlspecialchars($row['Name of Faculty'] ?? '') ?></td>
                    <td class="align-top"><?php echo htmlspecialchars($row['Name of Consultancy Project'] ?? '') ?></td>
                     <td class="align-top"><?php echo htmlspecialchars($row['Sponsoring Agency'] ?? '') ?></td>
                     <td class="align-top"><?php echo htmlspecialchars($row['Date of Consultancy'] ?? '') ?></td>
                      <td class="align-top"><?php echo htmlspecialchars($row['Revenue Generated (amount in Rupees)'] ?? '') ?></td>
      
                     
                </tr>
                <?php
            }
        }
        ?>
    </tbody>
</table>
                
 <nav class="mt-4">
  <ul id="pagination" class="pagination justify-content-center"></ul>
</nav> 
  </div>
</div>
</section>


  <!-- Footer injected -->
<?php include '../footer.php'; ?>

  <!-- Bootstrap JS bundle -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

  <!-- Custom JS -->
  <script src="../assets/js/main.js"></script>
</body>
</html>

