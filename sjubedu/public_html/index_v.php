<?php

$api_url = "https://sjuv4.linways.com/api/v1/staffs";
$access_token = "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJhSWQiOiI0NTNlMzRjNWY1NDU5ZDMxNjg5OCIsImNJZCI6IjYyMDgiLCJvSWQiOiI1IiwiaWF0IjoxNzI0OTE1ODI2fQ.WSAp2aF6p0EiS0kjBzlSvE-1QcLnue8eEvYya0-r4ds";

$ch = curl_init($api_url);

curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "Authorization: Bearer $access_token"
]);
curl_setopt($ch, CURLOPT_USERAGENT, "PostmanRuntime/7.36.0");

$response = curl_exec($ch);

$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

curl_close($ch);

echo "HTTP CODE: " . $http_code;
echo "<pre>";
print_r($response);
echo "</pre>";