<?php

namespace Tristancrushing\ZendeskToHalo;

/**
 * Class ZendeskToHalo
 *
 * This class serves as a high-level interface to facilitate the conversion of
 * Zendesk export files into a format suitable for import into the Halo system.
 * It leverages the functionality provided by ZendeskCsvController for reading CSV files,
 * ZendeskToHaloDataMap for mapping data fields, and ZendeskExportToHaloImport for
 * generating the Halo-compatible CSV file. This class is intended to be used as a helper
 * class in a web application, particularly in an index.php file where users can upload
 * their Zendesk export file for processing.
 */
class ZendeskToHalo
{
    /**
     * Processes a Zendesk export CSV file and creates a Halo import CSV file.
     *
     * This method acts as a single entry point to execute the full conversion process.
     * It abstracts the complexity of the underlying steps and provides a simple interface
     * for the end-user. This is particularly useful when the class is used as part of a
     * web application, allowing file uploads and processing through a web interface.
     *
     * @param string $pathToZendeskExport The file path to the source Zendesk export CSV.
     * @param string $pathToHaloImport The file path where the resulting Halo import CSV will be saved.
     * @return void
     */
    public function processExportToImport(string $pathToZendeskExport, string $pathToHaloImport): void
    {
        // Create an instance of the class responsible for handling the conversion process.
        $exportToImport = new ZendeskExportToHaloImport();

        // Call the method that orchestrates the reading of the Zendesk CSV,
        // the mapping of its data, and the creation of the Halo import file.
        $exportToImport->createHaloImportCsv($pathToZendeskExport, $pathToHaloImport);

        // Output a success message to indicate completion of the process.
        // Note: In a web application, this might be replaced with a redirect,
        // a session flash message, or a JSON response.
        echo "The Halo import file has been successfully created and is available at the link below: <br>";
    }
}