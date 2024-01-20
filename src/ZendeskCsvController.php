<?php

namespace Tristancrushing\ZendeskToHalo;

/**
 * Class ZendeskCsvController
 *
 * This class is designed to handle the reading and processing of CSV files
 * formatted according to Zendesk's standards. It provides functionality to
 * convert the CSV data into different formats such as an array, a JSON string,
 * or a PHP object. This can be particularly useful for integrating Zendesk CSV
 * exports with other systems or for further data processing and analysis.
 */
class ZendeskCsvController
{
    /**
     * Demonstrates the usage of the ZendeskCsvController class methods.
     * It creates an instance of the class, reads CSV data from a file,
     * converts it to an array, a JSON string, and an object, then outputs them.
     * This method is static and can be called without instantiating the class.
     *
     * @param string $filePath The path to the CSV file that should be read.
     * @return void
     */
    public function runExampleUsage(string $filePath): void
    {
        // Instantiate the ZendeskCsvController class
        $controller = new ZendeskCsvController();

        // Read CSV data from a file and convert it to an array
        $csvArray = $controller->readCsvToArray($filePath);

        // Convert the array to a JSON string
        $json = $controller->convertArrayToJson($csvArray);

        // Convert the array to a PHP object
        $object = $controller->convertArrayToObject($csvArray);

        // Output the data in different formats
        echo $json; // Output as JSON
        print_r($csvArray); // Output as Array
        print_r($object); // Output as Object
    }

    /**
     * Reads a CSV file from the given file path and returns an array containing
     * the CSV data. Each row from the CSV file is converted into an associative
     * array with keys corresponding to the column headers.
     *
     * @param string $filePath The path to the CSV file that should be read.
     * @return array An array of associative arrays representing the CSV data.
     */
    public function readCsvToArray(string $filePath): array
    {
        // Open the CSV file for reading
        $fileHandle = fopen($filePath, 'r');

        // Initialize an empty array to hold the CSV data
        $csvData = [];

        // Read the first row to extract column headers
        $headers = fgetcsv($fileHandle);

        // Loop through each row of the CSV file
        while (($row = fgetcsv($fileHandle)) !== false) {
            // Combine the row with the headers to create an associative array
            $csvData[] = array_combine($headers, $row);
        }

        // Close the file handle
        fclose($fileHandle);

        // Return the array containing the CSV data
        return $csvData;
    }

    /**
     * Converts the given array of CSV data into a JSON string. This can be used
     * for outputting the data in a format that is easily readable by JavaScript
     * or for APIs that exchange data in JSON format.
     *
     * @param array $csvArray The CSV data as an array to be converted to JSON.
     * @return string A JSON encoded string representing the CSV data.
     */
    public function convertArrayToJson(array $csvArray): string
    {
        // Convert the array to a JSON string with pretty print for readability
        return json_encode($csvArray, JSON_PRETTY_PRINT);
    }

    /**
     * Converts the given array of CSV data into a PHP object. This can be useful
     * for when the data needs to be accessed using object syntax in PHP.
     *
     * @param array $csvArray The CSV data as an array to be converted to an object.
     * @return object An object representing the CSV data.
     */
    public function convertArrayToObject(array $csvArray): object
    {
        // Convert the array to an object
        return (object) $csvArray;
    }
}

// Example usage can be run directly if the script is executed via CLI or web server
// (new ZendeskCsvController())->runExampleUsage();