<?php



$API_TOKEN='eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJhSWQiOiI0NTNlMzRjNWY1NDU5ZDMxNjg5OCIsImNJZCI6IjYyMDgiLCJvSWQiOiI1IiwiaWF0IjoxNzI0OTE1ODI2fQ.WSAp2aF6p0EiS0kjBzlSvE-1QcLnue8eEvYya0-r4ds';


  //DEPARTMENT
 $api_url = "https://sjuv4.linways.com/api/v1/departments";

 
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