<?php
function get_sju_s3_images($folderPath) {
    $bucket = 'sjub'; 
    $region = 'ap-south-1';
    $folderPath = trim($folderPath, '/') . '/';
    
    // The API URL to list objects
    $apiUrl = "https://{$bucket}.s3.{$region}.amazonaws.com/?prefix=" . urlencode($folderPath);

    $images = [];
    $xmlContent = @file_get_contents($apiUrl);

    if ($xmlContent !== false) {
        $xml = new SimpleXMLElement($xmlContent);
        // S3 uses a namespace; we must register it to find the <Contents> tags
        $xml->registerXPathNamespace('s3', 'http://s3.amazonaws.com/doc/2006-03-01/');
        $nodes = $xml->xpath('//s3:Contents');

        foreach ($nodes as $node) {
            $key = (string)$node->Key;
            // Only grab image files and ignore the folder name itself
            if (preg_match('/\.(jpg|jpeg|png|webp)$/i', $key) && $key !== $folderPath) {
                $images[] = [
                    'url' => "https://{$bucket}.s3.{$region}.amazonaws.com/" . $key,
                    'caption' => ucwords(str_replace(['-', '_'], ' ', pathinfo($key, PATHINFO_FILENAME)))
                ];
            }
        }
    }
    return $images;
}
?>