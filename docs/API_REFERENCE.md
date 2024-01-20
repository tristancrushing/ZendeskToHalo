# API Reference for Zendesk to Halo Library

This document provides detailed API documentation for the Zendesk to Halo conversion library. It includes descriptions of the key classes, functions, and methods, along with their parameters, return types, and example usage.

## Overview

The Zendesk to Halo library consists of several components working together to convert data from Zendesk's CSV format to a format compatible with the Halo system. The primary classes and methods are outlined below.

## Classes

### ZendeskToHalo

The main class responsible for orchestrating the conversion process.

#### Methods

- **`processExportToImport`**:
    - Description: Processes the Zendesk export file and creates a Halo import file.
    - Parameters:
        - `$pathToZendeskExport` (string): Path to the Zendesk CSV file.
        - `$pathToHaloImport` (string): Path where the Halo import file will be saved.
    - Return Type: void
    - Example:
      ```php
      $zendeskToHalo = new ZendeskToHalo();
      $zendeskToHalo->processExportToImport('/path/to/zendesk.csv', '/path/to/halo_import.csv');
      ```

### ZendeskCsvController

Responsible for reading and parsing the Zendesk CSV file.

#### Methods

- **`readCsvToArray`**:
    - Description: Reads a CSV file and converts it to an array.
    - Parameters:
        - `$filePath` (string): Path to the CSV file.
    - Return Type: array
    - Example:
      ```php
      $csvController = new ZendeskCsvController();
      $csvArray = $csvController->readCsvToArray('/path/to/zendesk.csv');
      ```

### ZendeskToHaloDataMap

Handles the mapping of data from Zendesk format to Halo format.

#### Methods

- **`mapRowToHaloFormat`**:
    - Description: Converts a single row of Zendesk data to Halo format.
    - Parameters:
        - `$row` (array): An associative array representing a single row of Zendesk data.
    - Return Type: array
    - Example:
      ```php
      $dataMap = new ZendeskToHaloDataMap();
      $haloFormattedRow = $dataMap->mapRowToHaloFormat($zendeskRow);
      ```

## Usage Examples

### Converting a Zendesk Export File

```php
$zendeskToHalo = new ZendeskToHalo();
$zendeskToHalo->processExportToImport('/path/to/zendesk.csv', '/path/to/halo_import.csv');
```

### Reading a CSV File

```php
$csvController = new ZendeskCsvController();
$csvArray = $csvController->readCsvToArray('/path/to/zendesk.csv');
```

### Mapping Data to Halo Format

```php
$dataMap = new ZendeskToHaloDataMap();
foreach ($csvArray as $row) {
    $haloFormattedRow = $dataMap->mapRowToHaloFormat($row);
    // Process $haloFormattedRow as needed
}
```
