<?php
// index.php
/**
 * Entry point for a web application that converts Zendesk export CSV files into a Halo import format.
 * Implements security best practices, proper validation, and error handling.
 * This script is designed to be part of a real-world application, demonstrating
 * industry standards for file uploads and processing.
 */

require_once 'constantsConfig.php';
require_once '../vendor/autoload.php'; // Include the Composer autoloader.

use Tristancrushing\ZendeskToHalo\ZendeskToHalo; // Import the conversion class.

// Strip Public Html Dir
function stripPublicHtml(string $filePath): string
{
    $publicHtmlDir = $_SERVER['DOCUMENT_ROOT'];

    $modifiedString = str_replace($publicHtmlDir, "", $filePath);

    return $modifiedString; // Outputs: some/other/path
}

// Function to handle file upload and conversion.
function handleFileUpload(string $uploadDir, string $outputDir): void
{
    // Check for file upload errors and handle them appropriately.
    if ($_FILES['zendeskExport']['error'] !== UPLOAD_ERR_OK) {
        throw new Exception('File upload error. Code: ' . $_FILES['zendeskExport']['error']);
    }

    // Security measure: Validate that the file is a CSV.
    $fileType = mime_content_type($_FILES['zendeskExport']['tmp_name']);
    if ($fileType !== 'text/csv') {
        throw new Exception('Invalid file type. Only CSV files are allowed.');
    }

    // Security measure: Avoid directory traversal issues.
    $baseName = basename($_FILES['zendeskExport']['name']);
    if (!preg_match('/\.csv$/i', $baseName)) {
        throw new Exception('Invalid file extension. Only CSV files are allowed.');
    }

    // Generate a unique file name to prevent overwriting existing files.
    $uploadedFilePath = $uploadDir . uniqid('zendesk_', true) . '_' . $baseName;

    // Move the uploaded file to the uploads directory.
    if (!move_uploaded_file($_FILES['zendeskExport']['tmp_name'], $uploadedFilePath)) {
        throw new Exception('Failed to move uploaded file.');
    }

    // Set the path for the Halo import file.
    $haloImportFilePath = $outputDir . 'halo_import_' . time() . '.csv';

    // Process the uploaded Zendesk export file to Halo import format.
    $zendeskToHalo = new ZendeskToHalo();
    $zendeskToHalo->processExportToImport($uploadedFilePath, $haloImportFilePath);

    // Success message with a link to download the new Halo import file.
    echo '<p>Conversion successful! <a target="_blank" href="' . htmlspecialchars(stripPublicHtml($haloImportFilePath)) . '">Download Halo Import File</a></p>';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zendesk to Halo Conversion</title>
    <!-- Latest compiled and minified Bootstrap CSS from CDN -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>

<div class="container mt-5">
    <h1 class="mb-4">Zendesk to Halo Conversion</h1>

    <?php if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['zendeskExport'])): ?>
        <?php
        // Define the directories for storing uploaded and processed files.
        $uploadDir = __DIR__ . '/uploads/';
        $outputDir = __DIR__ . '/output/';

        // Create the upload and output directories if they do not exist.
        if (!is_dir($uploadDir) && !mkdir($uploadDir, 0755, true) && !is_dir($uploadDir)) {
            throw new Exception('Failed to create upload directory.');
        }
        if (!is_dir($outputDir) && !mkdir($outputDir, 0755, true) && !is_dir($outputDir)) {
            throw new Exception('Failed to create output directory.');
        }

        try {
            handleFileUpload($uploadDir, $outputDir);
        } catch (Exception $e) {
            // Handle exceptions and display an error message to the user.
            echo '<p>Error: ' . htmlspecialchars($e->getMessage()) . '</p>';
        }
        ?>
    <?php else: ?>
        <div class="card">
            <div class="card-body">
                <form method="post" enctype="multipart/form-data" class="form-group">
                    <label for="zendeskExport">Upload Zendesk Export CSV:</label>
                    <input type="file" name="zendeskExport" id="zendeskExport" class="form-control-file mb-3" required>
                    <input type="submit" value="Convert to Halo Import" class="btn btn-primary">
                </form>
            </div>
        </div>
    <?php endif; ?>

</div>

<!-- Bootstrap JS, Popper.js, and jQuery -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.7.12/umd.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>