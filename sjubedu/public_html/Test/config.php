<?php
// Configuration Settings
date_default_timezone_set('Asia/Kolkata'); // Set PHP to Indian Time
// API Token
$API_TOKEN  = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJhSWQiOiI0NTNlMzRjNWY1NDU5ZDMxNjg5OCIsImNJZCI6IjYyMDgiLCJvSWQiOiI1IiwiaWF0IjoxNzI0OTE1ODI2fQ.WSAp2aF6p0EiS0kjBzlSvE-1QcLnue8eEvYya0-r4ds';
$ADMIN_PASSWORD = 'sju_admin_secure';
// Cache Directory
$CACHE_DIR = __DIR__ . '/cache';
// AWS S3 Credentials
$S3_ACCESS_KEY = 'AKIA4SYAMQP74NUJSHHL';
$S3_SECRET_KEY = '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';
$S3_REGION = 'ap-south-1';
$S3_BUCKET = 'sju-backups-storage';
?>