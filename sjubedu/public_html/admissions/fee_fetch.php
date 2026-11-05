<?php
header('Content-Type: text/html; charset=utf-8');

$url = $_GET['url'] ?? '';
if (!$url) exit("No URL provided.");

// Validate URL to prevent Server-Side Request Forgery (SSRF)
$parsed_url = parse_url($url);
$allowed_hosts = ['sjub.edu.in', 'www.sjub.edu.in', 'sju.edu.in', 'www.sju.edu.in'];
if (!isset($parsed_url['scheme']) || !in_array($parsed_url['scheme'], ['http', 'https'])) {
    http_response_code(400);
    exit("<p class='text-danger'>Error: Invalid URL scheme.</p>");
}
if (!isset($parsed_url['host']) || !in_array($parsed_url['host'], $allowed_hosts)) {
    http_response_code(403);
    exit("<p class='text-danger'>Error: Request to unauthorized domain.</p>");
}

// 1. Create a stream context to mimic a real browser
$options = [
    "http" => [
        "method" => "GET",
        "follow_location" => 1, // CRITICAL: This follows the .htaccess redirects
        "header" => "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36\r\n" .
                    "Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8\r\n" .
                    "Accept-Language: en-US,en;q=0.5\r\n",
        "ignore_errors" => true // Helps us see what the error is instead of just failing
    ],
    "ssl" => [
        "verify_peer" => false,
        "verify_peer_name" => false,
    ]
];

$context = stream_context_create($options);

// 2. Try to fetch the page
$html = file_get_contents($url, false, $context);

if ($html === FALSE) {
    exit("Error: Physical path or URL is unreachable. Check if LIVE_URL is correct.");
}

// 3. Parse the HTML
$dom = new DOMDocument();
libxml_use_internal_errors(true);
// Use the UTF-8 hack for Rupee symbols
$dom->loadHTML('<?xml encoding="utf-8" ?>' . $html);
libxml_clear_errors();

$xpath = new DOMXPath($dom);
$section = $xpath->query("//*[@id='fee-structure']");

if ($section->length > 0) {
    echo $dom->saveHTML($section->item(0));
} else {
    echo "<p class='text-danger'>Connection successful, but id='fee-structure' was not found on that page.</p>";
}