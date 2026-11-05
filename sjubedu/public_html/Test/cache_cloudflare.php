<?php
// 1. SET TIMEZONE TO IST
date_default_timezone_set('Asia/Kolkata');

// --- PHP LOGIC ---
$zoneId = "4028ed5a3569d750c302eb5e2f603be0"; 
$authEmail = "webmaster@sju.edu.in"; 
$authKey = "20b569d88866fe0a8d8bce56045445870fde5"; 

$url = "https://api.cloudflare.com/client/v4/zones/$zoneId/purge_cache";
$data = json_encode(["purge_everything" => true]);

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "X-Auth-Email: $authEmail",
    "X-Auth-Key: $authKey",
    "Content-Type: application/json"
]);
curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$error = curl_errno($ch) ? curl_error($ch) : null;
curl_close($ch);

$result = json_decode($response, true);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php include $_SERVER['DOCUMENT_ROOT'] . '/gtm.php'; ?>
    <meta charset="UTF-8">
    <meta http-equiv="refresh" content="10">
    <title>SJU | Cloudflare Purge (IST)</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: #f0f2f5; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; }
        .box { background: white; padding: 30px; border-radius: 12px; box-shadow: 0 10px 25px rgba(0,0,0,0.1); text-align: center; width: 350px; border-top: 5px solid #004a99; }
        .success { color: #27ae60; font-weight: bold; font-size: 1.1rem; }
        .error { color: #c0392b; font-weight: bold; }
        .time-box { background: #f8f9fa; padding: 10px; border-radius: 8px; margin-top: 20px; border: 1px solid #eee; }
        .label { color: #7f8c8d; font-size: 0.8rem; text-transform: uppercase; letter-spacing: 1px; }
        .timestamp { color: #2c3e50; font-size: 1.2rem; font-weight: 600; }
    </style>
</head>
<body>

<div class="box">
    <img src="https://sju.edu.in/images/logo.webp" alt="SJU Logo" style="max-width: 100px; margin-bottom: 15px;">
    <h3>CF Cache Purge</h3>
    
    <?php if ($error): ?>
        <p class="error">CURL Error: <?php echo $error; ?></p>
    <?php elseif (isset($result['success']) && $result['success']): ?>
        <p class="success">✅ Successfully Purged</p>
    <?php else: ?>
        <p class="error">❌ Failed: <?php echo $result['errors'][0]['message'] ?? 'Check Config'; ?></p>
    <?php endif; ?>

    <div class="time-box">
        <div class="label">Last Execution (IST)</div>
        <div class="timestamp"><?php echo date('h:i:s A'); ?></div>
    </div>
    
    <p style="font-size: 0.8rem; color: #95a5a6; margin-top: 15px;">Next auto-refresh in 10s</p>
</div>

</body>
</html>