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
            'RequestID' => defined('REQUEST_ID_PREFIX') ? (REQUEST_ID_PREFIX + $row['Id']) : $row['Id'],

            // Some fields like 'Impact' and 'Urgency' may not exist in the Zendesk data.
            // Here, they are given a default value, which can be adjusted as needed.
            'Impact' => defined('IMPACT_COLUMN_DEFAULT') ? IMPACT_COLUMN_DEFAULT : 1,
            'Urgency' => defined('URGENCY_COLUMN_DEFAULT') ? URGENCY_COLUMN_DEFAULT : 1,

            // 'ClientName', 'SiteName', 'Username', 'Summary', and other fields are
            // mapped directly if they have a corresponding field in the Zendesk data.
            'ClientName' => defined('CLIENT_NAME_COLUMN_DEFAULT') ? $row[CLIENT_NAME_COLUMN_DEFAULT] : $row['Organization'],
            'SiteName' => defined('SITE_NAME_COLUMN_DEFAULT') ? $row[SITE_NAME_COLUMN_DEFAULT] : $row['Requester domain'],
            'Username' => defined('USERNAME_COLUMN_DEFAULT') ? $row[USERNAME_COLUMN_DEFAULT] : $row['Requester'],
            'Summary' => defined('SUMMARY_COLUMN_DEFAULT') ? $row[SUMMARY_COLUMN_DEFAULT] : $row['Subject'],

            // For 'Details', we strip HTML tags from the 'Description' to get clean text.
            'Details' => defined('DETAILS_COLUMN_DEFAULT') ? isset($row[DETAILS_COLUMN_DEFAULT]) ? strip_tags($row[DETAILS_COLUMN_DEFAULT]) : 'No Details in Export' : 'No Details in Export',

            // Date fields need to be properly formatted to match Halo's expected format.
            'DateOccurred' => defined('DATE_OCCURRED_COLUMN_DEFAULT') ? date('m/d/Y', strtotime($row[DATE_OCCURRED_COLUMN_DEFAULT])) : date('m/d/Y', strtotime($row['Created at'])),

            // Categories may not have a direct mapping and might use a default or be based on other logic.
            'Category' => defined('CATEGORY_COLUMN_DEFAULT') ? CATEGORY_COLUMN_DEFAULT : 'Account Administration',
            'Category1' => defined('CATEGORY1_COLUMN_DEFAULT') ? CATEGORY1_COLUMN_DEFAULT : 'Account Administration',
            'Category2' => $row[CATEGORY2_COLUMN_DEFAULT] ?? 'General',

            // Status and other fields that have a direct mapping are assigned directly.
            'Status' => defined('STATUS_COLUMN_DEFAULT') ? $row[STATUS_COLUMN_DEFAULT] : $row['Status'],
            'AssignedTo' => defined('ASSIGNED_TO_COLUMN_DEFAULT') ? $row[ASSIGNED_TO_COLUMN_DEFAULT] : $row['Assignee'],
            'Team' => defined('TEAM_COLUMN_DEFAULT') ? TEAM_COLUMN_DEFAULT : 'NA',

            // RequestType might be derived from the 'Ticket type' or a similar field.
            'RequestType' => defined('REQUEST_TYPE_COLUMN_DEFAULT') ? $row[REQUEST_TYPE_COLUMN_DEFAULT] : $row['Ticket type'],

            // Priority is mapped directly from Zendesk data, assuming it's in a compatible format.
            'Priority' => defined('PRIORITY_COLUMN_DEFAULT') ? $row[PRIORITY_COLUMN_DEFAULT] : $row['Priority'],

            // Additional fields for Halo are filled with empty strings or appropriate defaults
            // if they do not have a corresponding value in the Zendesk data.
            'SLA' => defined('SLA_COLUMN_DEFAULT') ? SLA_COLUMN_DEFAULT : 'Our Example SLA 1', // Default SLA value
            'OpportunityEmailAddress' => defined('OPPORTUNITY_EMAIL_ADDRESS_COLUMN_DEFAULT') ? OPPORTUNITY_EMAIL_ADDRESS_COLUMN_DEFAULT : '',
            'OpportunityAddress1' => defined('OPPORTUNITY_ADDRESS1_COLUMN_DEFAULT') ? OPPORTUNITY_ADDRESS1_COLUMN_DEFAULT : '',
            'OpportunityAddress2' => defined('OPPORTUNITY_ADDRESS2_COLUMN_DEFAULT') ? OPPORTUNITY_ADDRESS2_COLUMN_DEFAULT : '',
            'OpportunityAddress3' => defined('OPPORTUNITY_ADDRESS3_COLUMN_DEFAULT') ? OPPORTUNITY_ADDRESS3_COLUMN_DEFAULT : '',
            'OpportunityAddress4' => defined('OPPORTUNITY_ADDRESS4_COLUMN_DEFAULT') ? OPPORTUNITY_ADDRESS4_COLUMN_DEFAULT : '',
            'OpportunityPostCode' => defined('OPPORTUNITY_POSTAL_CODE_COLUMN_DEFAULT') ? OPPORTUNITY_POSTAL_CODE_COLUMN_DEFAULT : '',
            'OpportunityValue' => defined('OPPORTUNITY_VALUE_COLUMN_DEFAULT') ? OPPORTUNITY_VALUE_COLUMN_DEFAULT : '',
            'OpportunityConversionProbability' => defined('OPPORTUNITY_CONVERSION_PROBABILITY_COLUMN_DEFAULT') ? OPPORTUNITY_CONVERSION_PROBABILITY_COLUMN_DEFAULT : ''
        ];
    }
}
