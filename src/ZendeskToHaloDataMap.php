<?php

namespace Tristancrushing\ZendeskToHalo;

/**
 * Class ZendeskToHaloDataMap
 *
 * This class is responsible for mapping data from a Zendesk-formatted CSV to the
 * fields used by the Halo system. It takes each row of data from the CSV and
 * transforms it into the corresponding Halo format, ensuring that the data types
 * and structures match the expected format for Halo system import.
 *
 * The mapping includes both direct field-to-field mapping and also cases where
 * defaults or transformations are needed to fit the Halo system's requirements.
 */
class ZendeskToHaloDataMap
{
    /**
     * Maps a single row of CSV data from Zendesk format to Halo format.
     *
     * The method takes an associative array representing a row of data in the
     * Zendesk format and converts it to an associative array that matches the
     * Halo system's expected format. Fields that require default values or
     * transformation are handled accordingly.
     *
     * @param array $row An associative array representing a single row of Zendesk CSV data.
     * @return array An associative array formatted for the Halo system.
     */
    public function mapRowToHaloFormat(array $row): array
    {
        // Mapping from Zendesk format to Halo format
        return [
            // The 'RequestID' field is mapped directly from 'Id' in Zendesk format.
            'RequestID' => $row['Id'],

            // Some fields like 'Impact' and 'Urgency' may not exist in the Zendesk data.
            // Here, they are given a default value, which can be adjusted as needed.
            'Impact' => 1,
            'Urgency' => 1,

            // 'ClientName', 'SiteName', 'Username', 'Summary', and other fields are
            // mapped directly if they have a corresponding field in the Zendesk data.
            'ClientName' => $row['Organization'],
            'SiteName' => $row['Requester domain'],
            'Username' => $row['Requester'],
            'Summary' => $row['Subject'],

            // For 'Details', we strip HTML tags from the 'Description' to get clean text.
            'Details' => isset($row['Description']) ? strip_tags($row['Description']) : '',

            // Date fields need to be properly formatted to match Halo's expected format.
            'DateOccurred' => date('m/d/Y', strtotime($row['Created at'])),

            // Categories may not have a direct mapping and might use a default or be based on other logic.
            'Category' => 'Account Administration',
            'Category1' => 'Account Administration',
            'Category2' => $row['Group'] ?? 'General',

            // Status and other fields that have a direct mapping are assigned directly.
            'Status' => $row['Status'],
            'AssignedTo' => $row['Assignee'],
            'Team' => $row['Group'],

            // RequestType might be derived from the 'Ticket type' or a similar field.
            'RequestType' => $row['Ticket type'],

            // Priority is mapped directly from Zendesk data, assuming it's in a compatible format.
            'Priority' => $row['Priority'],

            // Additional fields for Halo are filled with empty strings or appropriate defaults
            // if they do not have a corresponding value in the Zendesk data.
            'SLA' => 'Our Example SLA 1', // Default SLA value
            'OpportunityEmailAddress' => '',
            'OpportunityAddress1' => '',
            'OpportunityAddress2' => '',
            'OpportunityAddress3' => '',
            'OpportunityAddress4' => '',
            'OpportunityPostCode' => '',
            'OpportunityValue' => '',
            'OpportunityConversionProbability' => ''
        ];
    }
}
