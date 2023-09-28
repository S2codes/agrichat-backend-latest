<?php
// Get the file path from the query parameter
$fileUrl = $_GET['file_path'];

// Check if the file exists
if (filter_var($fileUrl, FILTER_VALIDATE_URL)) {
    // Extract the filename from the URL
    $filename = basename($fileUrl);
    
    // Set headers to force download
    header("Content-Type: application/octet-stream");
    header("Content-Disposition: attachment; filename=\"$filename\"");
    
    // Read the file and output its contents
    readfile($fileUrl);
} else {
    // Invalid file path provided
    header("HTTP/1.0 404 Not Found");
    echo "File not found.";
}
?>
