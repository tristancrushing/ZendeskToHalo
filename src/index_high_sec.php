<?php
// index_high_sec.php

require_once 'constantsConfig.php';
require_once '../vendor/autoload.php';
use Tristancrushing\ZendeskToHalo\ZendeskToHalo;

// Secure session initialization with strict settings
session_start([
    'cookie_lifetime' => 0, // Session cookie will last until the browser is closed
    'read_and_close'  => false, // Keep session file open for read/write
    'cookie_secure'   => true, // Send the cookie only over HTTPS
    'cookie_httponly' => true, // Make the cookie inaccessible to JavaScript
    'use_strict_mode' => true, // Prevent uninitialized session IDs
    'cookie_samesite' => 'Strict' // Restrict cross-site sharing of cookies
]);
session_regenerate_id(true); // Prevent session fixation attacks

// Set HTTP security headers
header("Content-Security-Policy: default-src 'self'; script-src 'none';"); // Mitigate XSS attacks
header("X-Content-Type-Options: nosniff"); // Prevent MIME-sniffing
header("X-Frame-Options: DENY"); // Avoid clickjacking attacks
header("X-XSS-Protection: 1; mode=block"); // Enable XSS filtering in older browsers
header("Referrer-Policy: strict-origin-when-cross-origin"); // Control referrer header

// Error reporting settings
ini_set('display_errors', '0'); // Do not display errors to the client
ini_set('log_errors', '1'); // Enable error logging
ini_set('error_log', __DIR__ . '/logs/'.bin2hex(random_bytes(8)) .'_error_log.txt'); // Specify the error log file
error_reporting(E_ALL); // Report all PHP errors

// Strip Public Html Dir
function stripPublicHtml(string $filePath): string
{
    $publicHtmlDir = $_SERVER['DOCUMENT_ROOT'];

    $modifiedString = str_replace($publicHtmlDir, "", $filePath);

    return $modifiedString; // Outputs: some/other/path
}

// CSRF token for form submission validation
if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32)); // Generate a new token
}

// CSRF token validation function
function validateCsrfToken(string $token): bool {
    return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
}

// Secure file upload handler
function handleSecureFileUpload(string $uploadDir, string $outputDir, string $csrfToken): void {
    if (!validateCsrfToken($csrfToken)) {
        throw new Exception('CSRF token validation failed.');
    }

    // Check for file upload errors
    if ($_FILES['zendeskExport']['error'] !== UPLOAD_ERR_OK) {
        throw new Exception('File upload error. Code: ' . $_FILES['zendeskExport']['error']);
    }

    // Verify file MIME type
    $fileTempPath = $_FILES['zendeskExport']['tmp_name'];
    $fileType = mime_content_type($fileTempPath);
    if ($fileType !== 'text/csv') {
        throw new Exception('Invalid file type. Only CSV files are allowed.');
    }

    // Validate file extension
    $baseName = basename($_FILES['zendeskExport']['name']);
    if (!preg_match('/\.csv$/i', $baseName)) {
        throw new Exception('Invalid file extension. Only CSV files are allowed.');
    }

    // Process file upload
    $uploadedFilePath = $uploadDir . uniqid('zendesk_', true) . '_' . $baseName;
    if (!move_uploaded_file($fileTempPath, $uploadedFilePath)) {
        throw new Exception('Failed to move uploaded file.');
    }

    // Process the file with ZendeskToHalo
    $haloImportFilePath = $outputDir . 'halo_import_' . time() . '.csv';
    $zendeskToHalo = new ZendeskToHalo();
    $zendeskToHalo->processExportToImport($uploadedFilePath, $haloImportFilePath);

    echo '<p>Conversion successful! <a target="_blank" href="' . htmlspecialchars(stripPublicHtml($haloImportFilePath)) . '">Download Halo Import File</a></p>';
}

// Main request handling
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['csrf_token'])) {
    $uploadDir = __DIR__ . '/secure_uploads/';
    $outputDir = __DIR__ . '/secure_output/';

    // Create directories if they don't exist
    if (!is_dir($uploadDir) && !mkdir($uploadDir, 0755, true) && !is_dir($uploadDir)) {
        throw new Exception('Failed to create upload directory.');
    }
    if (!is_dir($outputDir) && !mkdir($outputDir, 0755, true) && !is_dir($outputDir)) {
        throw new Exception('Failed to create output directory.');
    }

    try {
        handleSecureFileUpload($uploadDir, $outputDir, $_POST['csrf_token']);
    } catch (Exception $e) {
        error_log('Error: ' . $e->getMessage()); // Log the error
        echo '<p>Error: ' . htmlspecialchars($e->getMessage()) . '</p>'; // Display error to user
    }
} else {
    // Render the file upload form with CSRF token
    ?>
    <form method="post" enctype="multipart/form-data">
        <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token']); ?>">
        <label for="zendeskExport">Upload Zendesk Export CSV:</label><br>
        <input type="file" name="zendeskExport" id="zendeskExport" required><br><br>
        <input type="submit" value="Convert to Halo Import">
    </form>
    <?php
}
?>