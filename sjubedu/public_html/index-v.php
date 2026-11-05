<?php


//$FACULTY_ID of Jogith  is 1293

$FACULTY_ID='';

$API_TOKEN='eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJhSWQiOiI0NTNlMzRjNWY1NDU5ZDMxNjg5OCIsImNJZCI6IjYyMDgiLCJvSWQiOiI1IiwiaWF0IjoxNzI0OTE1ODI2fQ.WSAp2aF6p0EiS0kjBzlSvE-1QcLnue8eEvYya0-r4ds';


	//STAFF
   //$api_url = "https://sjuv4.linways.com/api/v1/staffs/" . urlencode($FACULTY_ID);
  
  //DEPARTMENT
 $api_url = "https://sjuv4.linways.com/api/v1/departments";
 
 
 
    $staff_ch = curl_init();
    curl_setopt($staff_ch, CURLOPT_URL, $api_url);
    curl_setopt($staff_ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($staff_ch, CURLOPT_HTTPHEADER, ["Authorization: $API_TOKEN", "Accept: application/json"]);
    curl_setopt($staff_ch, CURLOPT_SSL_VERIFYPEER, false);
    $staff_response = curl_exec($staff_ch);
    $staff_data = json_decode($staff_response, true);
    curl_close($staff_ch);

echo "<pre>";
print_r($staff_data);
echo "</pre>";