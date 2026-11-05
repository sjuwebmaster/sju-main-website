<?php
date_default_timezone_set('Asia/Kolkata');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    header('Allow: POST');
    exit;
}

// Silently ignore known crawlers
$ua = $_SERVER['HTTP_USER_AGENT'] ?? '';
$bots = ['Googlebot', 'Bingbot', 'Slurp', 'DuckDuckBot', 'Baiduspider', 'YandexBot'];
foreach ($bots as $bot) {
    if (stripos($ua, $bot) !== false) {
        http_response_code(204);
        exit;
    }
}

$raw  = file_get_contents('php://input');
$data = json_decode($raw, true);

if (!$data) {
    http_response_code(400);
    exit;
}

$ip      = $_SERVER['HTTP_CF_CONNECTING_IP'] ?? $_SERVER['REMOTE_ADDR'];
$country = $_SERVER['HTTP_CF_IPCOUNTRY'] ?? 'Unknown';
$ts      = date('Y-m-d H:i:s');

// report-uri sends {"csp-report": {...}}
// report-to sends an array of report objects [{type, body, ...}]
$entries = [];

if (isset($data['csp-report'])) {
    // Legacy report-uri format
    $r = $data['csp-report'];
    $entries[] = [
        'type'      => 'csp-violation',
        'page'      => $r['document-uri']       ?? 'Unknown',
        'blocked'   => $r['blocked-uri']         ?? 'Unknown',
        'directive' => $r['violated-directive']  ?? 'Unknown',
        'source'    => ($r['source-file'] ?? 'Inline') . ' (line ' . ($r['line-number'] ?? 'N/A') . ')',
    ];
} elseif (is_array($data) && isset($data[0]['type'])) {
    // New report-to format (array of reports)
    foreach ($data as $report) {
        $b = $report['body'] ?? [];
        $entries[] = [
            'type'      => $report['type']           ?? 'unknown',
            'page'      => $b['documentURL']         ?? $b['document-uri']         ?? 'Unknown',
            'blocked'   => $b['blockedURL']          ?? $b['blocked-uri']          ?? 'Unknown',
            'directive' => $b['effectiveDirective']  ?? $b['violated-directive']   ?? 'Unknown',
            'source'    => ($b['sourceFile'] ?? 'Inline') . ' (line ' . ($b['lineNumber'] ?? 'N/A') . ')',
        ];
    }
} else {
    http_response_code(400);
    exit;
}

$log_file = __DIR__ . '/csp-alerts.log';
foreach ($entries as $e) {
    $line  = "[$ts] {$e['type']}\n";
    $line .= "IP: $ip ($country) | UA: $ua\n";
    $line .= "PAGE:      {$e['page']}\n";
    $line .= "BLOCKED:   {$e['blocked']}\n";
    $line .= "DIRECTIVE: {$e['directive']}\n";
    $line .= "SOURCE:    {$e['source']}\n";
    $line .= str_repeat('-', 60) . "\n";
    file_put_contents($log_file, $line, FILE_APPEND | LOCK_EX);
}

http_response_code(204);
