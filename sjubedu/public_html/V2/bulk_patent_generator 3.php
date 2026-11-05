<?php
// bulk_patent_generator.php
// Generates static PHP files for each department's Patent page

$config = file_exists('/home/sjubedu/config.php') ? '/home/sjubedu/config.php' : __DIR__ . '/../../config.php';
require_once $config;

// --- 2. GLOBAL TRACKER INJECTION ---
// This is your Global Security & Tracker Bridge. 
// It must stay here to catch your iPhone's IPv6 address.
if (file_exists('/home/sjubedu/public_html/global_tracker.php')) {
    require_once('/home/sjubedu/public_html/global_tracker.php');
}

// Ensure output directory exists
$output_dir = __DIR__ . '/patent';
if (!is_dir($output_dir)) {
    mkdir($output_dir, 0755, true);
}

echo "<!DOCTYPE html><html><head><title>Patent Page Generator</title><link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css' rel='stylesheet'></head><body class='p-4'>";
echo "<div class='container'><div class='card shadow'><div class='card-header bg-primary text-white'><h3>Generating Patent Pages</h3></div><div class='card-body'><ul class='list-group'>";

$count = 0;
foreach ($departments as $id => $name) {
    $filename = "patent_" . $id . ".php";
    $filepath = $output_dir . "/" . $filename;
    
    // Content for the generated file
    // It sets the ID and Name, then includes the main template
    $content = "<?php\n";
    $content .= "\$DEPARTMENT_ID = \"$id\";\n";
    $content .= "\$DEPARTMENT_NAME = \"" . addslashes($name) . "\";\n";
    $content .= "require_once '../patent.php';\n";
    $content .= "?>";
    
    if (file_put_contents($filepath, $content)) {
        echo "<li class='list-group-item list-group-item-success'>✅ Generated: <strong>$filename</strong> for $name</li>";
        $count++;
    } else {
        echo "<li class='list-group-item list-group-item-danger'>❌ Failed: $filename</li>";
    }
}

echo "</ul></div><div class='card-footer'><strong>Total Pages Generated: $count</strong><br><a href='dashboard.php' class='btn btn-secondary mt-2'>Back to Dashboard</a></div></div></div>";
echo "</body></html>";
?>