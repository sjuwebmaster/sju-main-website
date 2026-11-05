<?php
/**
 * Fetches images from a public S3 bucket using XML parsing (No SDK required)
 */
function get_sju_s3_images($folderPath) {
    $bucket = 'sjub'; // REPLACE WITH YOUR BUCKET NAME
    $region = 'ap-south-1'; // REPLACE WITH YOUR REGION
    
    // S3 lists files at this URL when prefix is provided
    $apiUrl = "https://{$bucket}.s3.{$region}.amazonaws.com/?prefix=" . urlencode($folderPath);

    $images = [];
    $xml = @simplexml_load_file($apiUrl);

    if ($xml) {
        // S3 uses a specific namespace for its XML
        $xml->registerXPathNamespace('s3', 'http://s3.amazonaws.com/doc/2006-03-01/');
        $nodes = $xml->xpath('//s3:Contents');

        foreach ($nodes as $node) {
            $key = (string)$node->Key;
            
            // Filter: Only images and exclude the folder name itself
            if (preg_match('/\.(jpg|jpeg|png|webp)$/i', $key) && $key !== $folderPath) {
                $url = "https://{$bucket}.s3.{$region}.amazonaws.com/{$key}";
                
                // Caption logic: "student-lounge.jpg" -> "Student Lounge"
                $filename = pathinfo($key, PATHINFO_FILENAME);
                $caption = ucwords(str_replace(['-', '_'], ' ', $filename));
                
                $images[] = ['url' => $url, 'caption' => $caption];
            }
        }
    }
    return $images;
}

/**
 * Renders the Panoramic Galleria Layout
 */
function render_sju_panoramic($images, $title_gold, $title_blue, $folder) {
    if (count($images) < 5) {
        echo "<p class='text-center py-5'>S3 Folder '$folder' needs at least 5 images.</p>";
        return;
    }
    ?>
    <section class="gallery-section py-5">
        <div class="container text-center">
            <h2 class="mb-5"><span class="text_gold"><?php echo $title_gold; ?></span> <span class="text_blue"><?php echo $title_blue; ?></span></h2>
            
            <div class="row g-3 align-items-center">
                <div class="col-md-3">
                    <div class="gallery-item mb-3">
                        <img src="<?php echo $images[0]['url']; ?>" class="img-fluid rounded shadow-sm">
                        <p class="small mt-2 fw-bold"><?php echo $images[0]['caption']; ?></p>
                    </div>
                    <div class="gallery-item">
                        <img src="<?php echo $images[1]['url']; ?>" class="img-fluid rounded shadow-sm">
                        <p class="small mt-2 fw-bold"><?php echo $images[1]['caption']; ?></p>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="gallery-item main-feature">
                        <img src="<?php echo $images[2]['url']; ?>" class="img-fluid rounded shadow-lg">
                        <h5 class="mt-3 text_blue fw-bold"><?php echo $images[2]['caption']; ?></h5>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="gallery-item mb-3">
                        <img src="<?php echo $images[3]['url']; ?>" class="img-fluid rounded shadow-sm">
                        <p class="small mt-2 fw-bold"><?php echo $images[3]['caption']; ?></p>
                    </div>
                    <div class="gallery-item">
                        <img src="<?php echo $images[4]['url']; ?>" class="img-fluid rounded shadow-sm">
                        <p class="small mt-2 fw-bold"><?php echo $images[4]['caption']; ?></p>
                    </div>
                </div>
            </div>

            <div class="mt-5">
                <a href="gallery-view.php?folder=<?php echo urlencode($folder); ?>" class="btn btn-primary rounded-pill px-5">View More Photos</a>
            </div>
        </div>
    </section>
    <?php
}
?>