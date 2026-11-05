<?php 
$url = $_GET['url'] ?? '';
if(!$url) exit;

/* SSRF PROTECTION */
$parsed_url = parse_url($url);
$allowed_hosts = ['sjub.edu.in', 'www.sjub.edu.in', 'sju.edu.in', 'www.sju.edu.in'];
if (!isset($parsed_url['scheme']) || !in_array($parsed_url['scheme'], ['http', 'https'])) {
    http_response_code(400);
    exit("<p>Error: Invalid URL scheme.</p>");
}
if (!isset($parsed_url['host']) || !in_array($parsed_url['host'], $allowed_hosts)) {
    http_response_code(403);
    exit("<p>Error: Request to unauthorized domain.</p>");
}

/* FETCH PAGE */

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

$html = curl_exec($ch);
curl_close($ch);

if(!$html) exit;

/* PARSE HTML */

$dom = new DOMDocument();
libxml_use_internal_errors(true);
$dom->loadHTML($html);
libxml_clear_errors();

$xpath = new DOMXPath($dom);
$section = $xpath->query("//*[@id='fee-structure']");

if($section->length > 0){
echo $dom->saveHTML($section->item(0));
}else{
echo "<p>Fee details not found.</p>";
}

?>