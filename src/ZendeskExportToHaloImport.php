<?php

namespace Tristancrushing\ZendeskToHalo;

/**
 * Class ZendeskExportToHaloImport
 *
 * This class provides the functionality to take a Zendesk Export CSV file, process it,
 * and convert it into a format that is suitable for importing into the Halo system.
 * It makes use of the ZendeskCsvController class to read and parse the Zendesk CSV
 * and the ZendeskToHaloDataMap class to map the data to the Halo import format.
 * The result is a new CSV file created that can be imported directly into Halo.
 */
class ZendeskExportToHaloImport
{
    private ZendeskCsvController $csvController;
    private ZendeskToHaloDataMap $dataMapper;

    /**
     * Constructor for the ZendeskExportToHaloImport class.
     * Initializes the controller and mapper classes.
     */
    public function __construct()
    {
        $this->csvController = new ZendeskCsvController();
        $this->dataMapper = new ZendeskToHaloDataMap();
    }

    /**
     * Executes an example usage of the ZendeskExportToHaloImport class.
     *
     * This method provides an illustrative example of how to use the ZendeskExportToHaloImport
     * class to process a Zendesk Export CSV file and create a Halo Import CSV file.
     * It is intended to demonstrate the process from start to finish, using the class's
     * functionality to read a Zendesk CSV, convert the data to the Halo format, and write
     * the output to a new CSV file ready for Halo import.
     *
     * @param string $pathToZendeskExport The file path to the source Zendesk export CSV.
     * @param string $pathToHaloImport The file path where the resulting Halo import CSV will be saved.
     * @return void
     */
    public function runExampleUsage(string $pathToZendeskExport, string $pathToHaloImport): void
    {
        // Instantiate the ZendeskExportToHaloImport class to access its CSV transformation capabilities.
        $exportToImport = new ZendeskExportToHaloImport();

        // Inform the user that the process has started.
        echo "Starting the conversion process from Zendesk export to Halo import format...\n";

        // Perform the conversion from the Zendesk CSV format to the Halo CSV format.
        // This will read the CSV data from the specified Zendesk export path, map each
        // row to the Halo format using the ZendeskToHaloDataMap class, and write the new
        // formatted data to the specified Halo import path.
        $exportToImport->createHaloImportCsv($pathToZendeskExport, $pathToHaloImport);

        // Inform the user that the process has completed successfully.
        echo "Conversion completed. The Halo import CSV has been saved to: {$pathToHaloImport}\n";
    }

    /**
     * Processes the Zendesk CSV export and creates a Halo import CSV.
     *
     * This method takes the path to the Zendesk export CSV file, reads the data,
     * maps it to the Halo format, and writes a new CSV file that is ready for
     * import into the Halo system.
     *
     * @param string $zendeskCsvPath The path to the Zendesk export CSV file.
     * @param string $haloCsvPath The path where the new Halo import CSV will be saved.
     * @return void
     */
    public function createHaloImportCsv(string $zendeskCsvPath, string $haloCsvPath): void
    {
        // Read the Zendesk CSV data into an array
        $zendeskData = $this->csvController->readCsvToArray($zendeskCsvPath);

        // Open the file handle for the Halo import CSV
        $haloFileHandle = fopen($haloCsvPath, 'w');

        // Write the header row to the Halo CSV
        $headers = [
            'RequestID', 'Impact', 'Urgency', 'ClientName', 'SiteName', 'Username',
            'Summary', 'Details', 'DateOccurred', 'Category', 'Category1', 'Category2',
            'Status', 'AssignedTo', 'Team', 'RequestType', 'Priority',
            'SLA', 'OpportunityEmailAddress', 'OpportunityAddress1', 'OpportunityAddress2', 'OpportunityAddress3',
            'OpportunityAddress4', 'OpportunityPostCode', 'OpportunityValue',
        ];
        fputcsv($haloFileHandle, $headers);

        // Loop through each row of the Zendesk data
        foreach ($zendeskData as $row) {
            // Map the Zendesk row to the Halo format
            $haloRow = $this->dataMapper->mapRowToHaloFormat($row);
            // Write the mapped row to the Halo CSV
            fputcsv($haloFileHandle, $haloRow);
        }

        // Close the file handle
        fclose($haloFileHandle);
    }
}