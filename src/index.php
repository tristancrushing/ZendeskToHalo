<?php

// index.php

/**
 * Entry point for a web application that converts Zendesk export CSV files into a Halo import format.
 * Implements security best practices, proper validation, and error handling.
 * This script is designed to be part of a real-world application, demonstrating
 * industry standards for file uploads and processing.
 */

require_once 'vendor/autoload.php'; // Include the Composer autoloader.

use Tristancrushing\ZendeskToHalo\ZendeskToHalo; // Import the conversion class.

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
    echo '<p>Conversion successful! <a href="' . htmlspecialchars($haloImportFilePath) . '">Download Halo Import File</a></p>';
}

// Check for a POST request indicating a file upload attempt.
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['zendeskExport'])) {
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
} else {
    // Display the HTML form for uploading a Zendesk export CSV file.
    ?>
    <form method="post" enctype="multipart/form-data">
        <label for="zendeskExport">Upload Zendesk Export CSV:</label><br>
        <input type="file" name="zendeskExport" id="zendeskExport" required><br><br>
        <input type="submit" value="Convert to Halo Import">
    </form>
    <?php
}