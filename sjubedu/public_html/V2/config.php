<?php
// /home/sjubedu/config.php

// 1. Database Credentials
define('DB_HOST', 'localhost');
define('DB_USER', 'sjubedu_developer'); 
define('DB_PASS', 'SJU2022_sju');      
define('DB_NAME', 'sjubedu_faculty_data');

// 2. Global Path Settings
define('BASE_PATH', '/home/sjubedu/public_html/Test/');
define('BASE_URL', 'https://sjub.edu.in/Test/');

// 3. App Settings
date_default_timezone_set('Asia/Kolkata');
$API_TOKEN = "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJhSWQiOiI0NTNlMzRjNWY1NDU5ZDMxNjg5OCIsImNJZCI6IjYyMDgiLCJvSWQiOiI1IiwiaWF0IjoxNzI0OTE1ODI2fQ.WSAp2aF6p0EiS0kjBzlSvE-1QcLnue8eEvYya0-r4ds";
$ADMIN_PASSWORD = "sju_admin_secure";
$CACHE_DIR = __DIR__ . '/cache';

// NEW: Centralized Linways Form IDs
$FORM_IDS = [
    'phd'             => 'KkAkaWwi5XkbQiiDs',
    'publication'     => '36rBxCwiGkjZ2aBi2',
    'project'         => 'tYuM47LhCvJvkWnWo',
    'awards'          => 'NjJm3udjaCeeWCM7W',
    'book_chapter'    => '78bfwvpM2D3eTdojY',
    'books_published' => 'qxGCrWMgR5fHSsRL8',
    'consultancy'     => 'e4ucW5x6RdCBYgceC',
    'patent'          => 'SB8Zk4TPeosXcQjeB',
    'events_organized' => 'Cgv5AoyWn56MSrG8d',
    'popular_media'   => '4GYZ4bpSk4jEvA2WQ',
];

// 4. Centralized Department List
$departments = [
    "52" => "ADMIN", "53" => "LIBRARY", "54" => "COMPUTER SCIENCE", "55" => "ENGLISH", "59" => "COMMERCE", "64" => "ECONOMICS", "65" => "POLITICAL SCIENCE", "68" => "COMMUNICATION", "69" => "PSYCHOLOGY", "70" => "SOCIAL WORK", "71" => "PHYSICS", "72" => "CHEMISTRY", "73" => "MATHEMATICS", "74" => "ELECTRONICS", "75" => "STATISTICS", "77" => "BOTANY", "78" => "ZOOLOGY", "79" => "ENVIRONMENTAL SCIENCE", "80" => "MICROBIOLOGY", "81" => "BIOTECHNOLOGY", "83" => "COMMUNICATION OLD", "84" => "PHYSICAL EDUCATION", "88" => "BIG DATA ANALYTICS", "92" => "TEST", "93" => "NATURAL SCIENCE", "94" => "PHYSICAL SCIENCE", "95" => "SOCIAL SCIENCE", "96" => "PROFESSIONAL COURSES", "97" => "VOCATIONAL COURSES", "102" => "OFFICE", "103" => "LANGUAGES", "105" => "FOOD SCIENCE AND TECHNOLOGY", "107" => "HISTORY", "109" => "READMIT", "110" => "IT", "114" => "PHYSICAL EDUCATION AND LIBRARY", "116" => "MANAGEMENT", "117" => "BIOCHEMISTRY", "118" => "BATCH SHIFT III", "119" => "INTERNATIONAL RELATIONS PEACE AND PUBLIC POLICY", "120" => "RESEARCH AND INNOVATION COUNCIL", "121" => "INSTITUTE OF COMMUNICATION AND MEDIA STUDIES", "122" => "EXT", "126" => "SJRIC", "127" => "BIOLOGY", "129" => "JOURNALISM", "130" => "Honours", "131" => "Center for Human Excellence",
];

// --- FORCE REAL IP RESTORATION ---
// This ensures $_SERVER['REMOTE_ADDR'] is always the visitor, not Cloudflare
if (isset($_SERVER['HTTP_CF_CONNECTING_IP']) && filter_var($_SERVER['HTTP_CF_CONNECTING_IP'], FILTER_VALIDATE_IP)) {
    $_SERVER['REMOTE_ADDR'] = $_SERVER['HTTP_CF_CONNECTING_IP'];
} elseif (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
    $ips = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
    $real_ip = trim($ips[0]);
    if (filter_var($real_ip, FILTER_VALIDATE_IP)) {
        $_SERVER['REMOTE_ADDR'] = $real_ip;
    }
}
$visitor_ip = $_SERVER['REMOTE_ADDR'];

// 5. Establish Database Connection
try {
    $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4", DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) { $pdo = null; }

// 6. FIREWALL (Text File Based)
$blocked_file = __DIR__ . '/blocked_ips.txt';
if (file_exists($blocked_file)) {
    $blocked_ips = file($blocked_file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    if (in_array($visitor_ip, array_map('trim', $blocked_ips))) {
        if (file_exists($_SERVER['DOCUMENT_ROOT'] . '/403.php')) {
            include($_SERVER['DOCUMENT_ROOT'] . '/403.php');
        } else {
            header('HTTP/1.1 403 Forbidden');
            die("Access Denied for IP: $visitor_ip");
        }
        exit;
    }
}

// 7. ANONYMOUS TRACKER (v3.0 - Text File Based)
try {
    $log_file_path = __DIR__ . '/visitor_log.txt';
    $ua = $_SERVER['HTTP_USER_AGENT'] ?? '';
    // $visitor_ip is already defined above
    $v_hash = md5($visitor_ip . $ua);
    
    // Enhanced Device Detection
    $device = "Desktop";
    if (preg_match("/(tablet|ipad)/i", $ua)) {
        $device = "Tablet";
    } elseif (preg_match("/(android|webos|iphone|ipod|blackberry|iemobile|opera mini)/i", $ua)) {
        $device = "Mobile";
    }

    // This logs the full page URI, including any query strings (e.g., /path/page.php?id=123)
    $type = $_SERVER['REQUEST_URI'] ?? 'Unknown Page';

    $log_entry = [
        'hash' => $v_hash,
        'ip' => $visitor_ip,
        'timestamp' => time(),
        'page' => $type,
        'device' => $device,
        'ua' => $ua
    ];

    // Skip tracking for background cron jobs to prevent them from flooding the Top Pages list
    $request_uri = $_SERVER['REQUEST_URI'] ?? '';
    if (strpos($request_uri, '_cron.php') === false && strpos($request_uri, 'master_sync.php') === false) {
        // Use file locking to prevent race conditions on high traffic sites
        $fp = fopen($log_file_path, 'a');
        if ($fp && flock($fp, LOCK_EX)) {
            fwrite($fp, json_encode($log_entry) . "\n");
            flock($fp, LOCK_UN);
            fclose($fp);
        }
    }
} catch (Exception $e) {
    // Silently fail to avoid impacting user experience
    error_log("File Tracker Error: " . $e->getMessage());
}

Can you rewrite the Javascript and PHP upload logic in file_manager.php to use chunked uploads so I don't have to change my server limits?

