<?php
// TestSuite.php

require_once '../src/constantsConfig.php';
require_once '../vendor/autoload.php'; // Adjust the path as needed
use Tristancrushing\ZendeskToHalo\ZendeskToHalo; // Import the conversion class

class TestSuite {

    public static function stripPublicHtml(string $filePath): string
    {
        $publicHtmlDir = $_SERVER['DOCUMENT_ROOT'];

        $modifiedString = str_replace($publicHtmlDir, "", $filePath);

        return $modifiedString; // Outputs: some/other/path
    }

    // Static method to simulate the Zendesk CSV conversion process
    public static function testZendeskToHaloConversion() {
        // Define the directories for storing uploaded and processed files.
        $uploadDir = __DIR__ . '/uploads/';
        $outputDir = __DIR__ . '/output/';

        // Ensure the upload and output directories exist
        if (!is_dir($uploadDir) && !mkdir($uploadDir, 0755, true)) {
            throw new Exception("Failed to create directory: $uploadDir");
        }
        if (!is_dir($outputDir) && !mkdir($outputDir, 0755, true)) {
            throw new Exception("Failed to create directory: $outputDir");
        }

        // Use existing methods to generate fake Zendesk export data
        $randomUsers = fetchRandomUsers();
        $fakeZendeskExport = generateFakeZendeskExport($randomUsers);

        // Write the generated data to a CSV file in the uploads directory
        $uploadedFilePath = $uploadDir . 'test_zendesk_export_' . time() . '.csv';
        $fp = fopen($uploadedFilePath, 'w');
        if ($fp === false) {
            throw new Exception("Unable to open file for writing: $uploadedFilePath");
        }

        // First, write the headers to the CSV
        fputcsv($fp, array_keys(reset($fakeZendeskExport)));

        // Then write each row of data
        foreach ($fakeZendeskExport as $row) {
            fputcsv($fp, $row);
        }
        fclose($fp);

        // Generate a fake Halo import file path
        $haloImportFilePath = $outputDir . 'halo_import_test_' . time() . '.csv';

        // Process the uploaded Zendesk export file to Halo import format
        $zendeskToHalo = new ZendeskToHalo();
        $zendeskToHalo->processExportToImport($uploadedFilePath, $haloImportFilePath);

        // Output a success message for the test; in a real scenario, you'd likely return this value
        // Success message with a link to download the new Halo import file.
        // echo '<p>Conversion successful! <a target="_blank" href="' . htmlspecialchars(self::stripPublicHtml($haloImportFilePath)) . '">Download Halo Import File</a></p>';
        // Define the file name
        $haloImportFileName = 'halo_import_test_' . time() . '.csv';
        $haloImportFilePath = $outputDir . $haloImportFileName;

        // Process the uploaded Zendesk export file to Halo import format
        $zendeskToHalo = new ZendeskToHalo();
        $zendeskToHalo->processExportToImport($uploadedFilePath, $haloImportFilePath);

        // Set Content-Disposition header with the file name
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="' . $haloImportFileName . '"');

        // Output the CSV file
        readfile($haloImportFilePath);
        exit;
    }
}

// Make sure the fetchRandomUsers and generateFakeZendeskExport functions are defined.
// They could be included from another file or defined in this script.
