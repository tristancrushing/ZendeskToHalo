<?php

/**
 * constantsConfig.php
 *
 * This configuration file defines various constants used in the Zendesk to Halo conversion module.
 * These constants provide default values and configurations, enhancing the module's flexibility
 * and adaptability. The use of constants allows for easy adjustments and fine-tuning of the module's behavior
 * without altering the core logic, making the system more maintainable and scalable.
 */

// Define Request ID Prefix: This prefix is added to the numeric Request ID from the Zendesk export.
// It's useful for ensuring uniqueness and avoiding conflicts with existing IDs in the Halo system.
const REQUEST_ID_PREFIX = 900;

// Default values for various columns. These defaults are used when the corresponding data
// is not available in the Zendesk export or to provide a consistent baseline value.

// IMPACT_COLUMN_DEFAULT: Default impact level of a request.
// It could be mapped to a numeric scale or a qualitative assessment.
const IMPACT_COLUMN_DEFAULT = 1;

// URGENCY_COLUMN_DEFAULT: Default urgency level for processing a request.
const URGENCY_COLUMN_DEFAULT = 1;

// CLIENT_NAME_COLUMN_DEFAULT: Default column name for the client's organization.
const CLIENT_NAME_COLUMN_DEFAULT = 'Organization';

// SITE_NAME_COLUMN_DEFAULT: Default column name for the site or domain associated with the requester.
const SITE_NAME_COLUMN_DEFAULT = 'Requester domain';

// USERNAME_COLUMN_DEFAULT: Default column name for the username of the requester.
const USERNAME_COLUMN_DEFAULT = 'Requester';

// SUMMARY_COLUMN_DEFAULT: Default column name for the summary or title of the request.
const SUMMARY_COLUMN_DEFAULT = 'Subject';

// DETAILS_COLUMN_DEFAULT: Default column name for detailed description of the request.
const DETAILS_COLUMN_DEFAULT = 'Description';

// DATE_OCCURRED_COLUMN_DEFAULT: Default column name for the date when the request was created.
const DATE_OCCURRED_COLUMN_DEFAULT = 'Created at';

// CATEGORY_COLUMN_DEFAULT and CATEGORY1_COLUMN_DEFAULT: Default categories for classifying the request.
// These can be used for routing, reporting, or prioritization in the Halo system.
const CATEGORY_COLUMN_DEFAULT = 'Account Administration';
const CATEGORY1_COLUMN_DEFAULT = 'Account Administration';

// CATEGORY2_COLUMN_DEFAULT: An additional category level for more granular classification.
const CATEGORY2_COLUMN_DEFAULT = 'Group';

// STATUS_COLUMN_DEFAULT: Default column name for the current status of the request.
const STATUS_COLUMN_DEFAULT = 'Status';

// ASSIGNED_TO_COLUMN_DEFAULT: Default column name for the individual or team assigned to the request.
const ASSIGNED_TO_COLUMN_DEFAULT = 'Assignee';

// TEAM_COLUMN_DEFAULT: Default value for the team responsible for handling the request.
const TEAM_COLUMN_DEFAULT = 'NA';

// REQUEST_TYPE_COLUMN_DEFAULT: Default column name for the type or mode of the request.
const REQUEST_TYPE_COLUMN_DEFAULT = 'Ticket type';

// PRIORITY_COLUMN_DEFAULT: Default column name for the priority level of the request.
const PRIORITY_COLUMN_DEFAULT = 'Priority';

// SLA_COLUMN_DEFAULT: Default Service Level Agreement (SLA) associated with the request.
const SLA_COLUMN_DEFAULT = 'Our Example SLA 1';

// The following constants are placeholders for potential future integration with an opportunity tracking or CRM system.
// Currently, they are set to empty strings but can be configured to map to corresponding fields in the Zendesk export.

const OPPORTUNITY_EMAIL_ADDRESS_COLUMN_DEFAULT = '';
const OPPORTUNITY_ADDRESS1_COLUMN_DEFAULT = '';
const OPPORTUNITY_ADDRESS2_COLUMN_DEFAULT = '';
const OPPORTUNITY_ADDRESS3_COLUMN_DEFAULT = '';
const OPPORTUNITY_ADDRESS4_COLUMN_DEFAULT = '';
const OPPORTUNITY_POSTAL_CODE_COLUMN_DEFAULT = '';
const OPPORTUNITY_VALUE_COLUMN_DEFAULT = '';
const OPPORTUNITY_CONVERSION_PROBABILITY_COLUMN_DEFAULT = '';
