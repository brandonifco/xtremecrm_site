<?php
header('Content-Type: text/css');

// Step 1: Include the font import
echo "@import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap');\n";

// Step 2: Get all .css files in the current directory
$files = glob(__DIR__ . '/*.css');

// Step 3: Loop through and output @import for each file except this one
foreach ($files as $file) {
    $basename = basename($file);
    if ($basename !== 'main-live.php') {
        echo "@import '$basename';\n";
    }
}
