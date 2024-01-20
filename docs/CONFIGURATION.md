# Configuration Guide for Zendesk to Halo Library

This document provides a detailed description of the configuration options available in the Zendesk to Halo conversion library, including examples and explanations of environment variables and constants.

## Overview

The `ZendeskToHalo` library offers various configuration options to tailor the data mapping and conversion process. These configurations are primarily managed through constants defined in the `constantsConfig.php` file and are used within the `ZendeskToHaloDataMap` class.

## Constants Configuration

### General Constants

- **`REQUEST_ID_PREFIX`**:
    - Description: This prefix is added to the Request ID from the Zendesk export. It ensures uniqueness and prevents conflicts with existing IDs in the Halo system.
    - Default Value: `900`

### Default Column Mappings

The following constants define default values or column names used in the data mapping process:

- **`IMPACT_COLUMN_DEFAULT`**:
    - Description: Default impact level of a request.
    - Default Value: `1`

- **`URGENCY_COLUMN_DEFAULT`**:
    - Description: Default urgency level for processing a request.
    - Default Value: `1`

- **`CLIENT_NAME_COLUMN_DEFAULT`**:
    - Description: Default column name for the client's organization.
    - Default Value: `'Organization'`

- **`SITE_NAME_COLUMN_DEFAULT`**:
    - Description: Default column name for the site or domain associated with the requester.
    - Default Value: `'Requester domain'`

- **`USERNAME_COLUMN_DEFAULT`**:
    - Description: Default column name for the username of the requester.
    - Default Value: `'Requester'`

- **`SUMMARY_COLUMN_DEFAULT`**:
    - Description: Default column name for the summary or title of the request.
    - Default Value: `'Subject'`

- **`DETAILS_COLUMN_DEFAULT`**:
    - Description: Default column name for detailed description of the request.
    - Default Value: `'Description'`

- **`DATE_OCCURRED_COLUMN_DEFAULT`**:
    - Description: Default column name for the date when the request was created.
    - Default Value: `'Created at'`

### Category and Status Constants

- **`CATEGORY_COLUMN_DEFAULT`** and **`CATEGORY1_COLUMN_DEFAULT`**:
    - Description: Default categories for classifying the request.
    - Default Value: `'Account Administration'`

- **`CATEGORY2_COLUMN_DEFAULT`**:
    - Description: An additional category level for more granular classification.
    - Default Value: `'Group'`

- **`STATUS_COLUMN_DEFAULT`**:
    - Description: Default column name for the current status of the request.
    - Default Value: `'Status'`

### Additional Constants

- **`ASSIGNED_TO_COLUMN_DEFAULT`**, **`TEAM_COLUMN_DEFAULT`**, etc.:
    - Description: These constants provide default mappings for various other fields like 'Assigned To', 'Team', 'Request Type', etc.
    - Default Values: Varies based on field (e.g., `'Assignee'`, `'NA'`, etc.)

## Customizing Configuration

To customize the configuration, you can modify the values of these constants in the `constantsConfig.php` file. This allows for easy adjustments to the data mapping logic without altering the core functionality of the library.

### Example Scenario

If you need to change the default impact level for all requests:

```php
// In constantsConfig.php
const IMPACT_COLUMN_DEFAULT = 2; // Set the default impact level to 2
```

## Conclusion

Understanding and appropriately configuring these constants is crucial for the successful integration and operation of the Zendesk to Halo library within your system. Adjust these settings based on your specific requirements and the data structure of your Zendesk exports and Halo system.