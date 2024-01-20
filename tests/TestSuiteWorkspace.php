<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

// Constants storing test IDs
const TEST_IDS = ['bA9qW2d3Oj2FS', 'tX99Wo3DvW6n2'];
const GENERATE_FORM_ID = TEST_IDS[0];
const CONVERSION_FORM_ID = TEST_IDS[1];

// Flags to trigger test CSV generation and conversion tests
$generate_test_csv = false;
$run_conversion_test = false;

// Including required files and libraries
require_once '../vendor/autoload.php'; // Path to autoload file may vary based on project structure
require_once '../src/constantsConfig.php'; // Assumed to contain configuration constants
require_once 'TestSuite.php'; // Assumed to contain TestSuite class with necessary tests
require_once 'ZendeskExportTest.php'; // Assumed to contain ZendeskExportTest class with necessary tests

/*
 * Fetches random user data from an API in JSON format and returns it as an associative array.
 *
 * @param int $count The number of users to fetch. Defaults to 10.
 * @return array The fetched random user data.
 */
function fetchRandomUsers($count = 10) {
    $apiUrl = "https://random-data-api.com/api/v2/users?size=$count";
    $json = file_get_contents($apiUrl);
    return json_decode($json, true);
}

/*
 * Converts the fetched random user data to a fake Zendesk export format.
 *
 * @param array $users The user data to convert.
 * @return array The converted user data in Zendesk export format.
 */
function generateFakeZendeskExport($users) {
    $zendeskExport = [];
    $headers = [
        'Summation column', 'Id', 'Requester', 'Requester id', 'Requester external id',
        'Requester email', 'Requester domain', 'Submitter', 'Assignee', 'Group', 'Subject',
        'Tags', 'Status', 'Priority', 'Via', 'Ticket type', 'Created at', 'Updated at',
        'Assigned at', 'Organization', 'Due date', 'Initially assigned at', 'Solved at',
        'Resolution time', 'Satisfaction Score', 'Group stations', 'Assignee stations',
        'Reopens', 'Replies', 'First reply time in minutes',
        'First reply time in minutes within business hours', 'First resolution time in minutes',
        'First resolution time in minutes within business hours', 'Full resolution time in minutes',
        'Full resolution time in minutes within business hours', 'Agent wait time in minutes',
        'Agent wait time in minutes within business hours', 'Requester wait time in minutes',
        'Requester wait time in minutes within business hours', 'On hold time in minutes',
        'On hold time in minutes within business hours'
    ];

    foreach ($users as $user) {
        $now = date('m/d/y H:i'); // Current date/time for 'Updated at' and other current date values
        $entry = array_combine($headers, array_fill(0, count($headers), null)); // Initialize all keys with null

        // Assign values to the correct keys based on the fetched user data
        $entry['Summation column'] = '1'; // This is a placeholder value
        $entry['Id'] = $user['id'];
        $entry['Requester'] = $user['first_name'] . ' ' . $user['last_name'];
        $entry['Requester id'] = $user['id']; // Assuming the 'Requester id' is the same as 'Id'
        $entry['Requester external id'] = ''; // No external id available from the random data
        $entry['Requester email'] = $user['email'];
        $entry['Requester domain'] = explode('@', $user['email'])[1];
        $entry['Submitter'] = $user['first_name'] . ' ' . $user['last_name']; // Assuming submitter is the same as requester
        $entry['Assignee'] = $user['first_name'] . ' ' . $user['last_name']; // Assuming assignee is the same as requester
        $entry['Group'] = $user['employment']['title']; // Using job title as group
        $entry['Subject'] = 'Inquiry from ' . $user['first_name'];
        $entry['Tags'] = ''; // No tags provided
        $entry['Status'] = 'Open'; // Placeholder status
        $entry['Priority'] = 'Medium'; // Placeholder priority
        $entry['Via'] = 'Web'; // Placeholder for ticket origin
        $entry['Ticket type'] = 'Question'; // Placeholder ticket type
        $entry['Created at'] = $now;
        $entry['Updated at'] = $now;
        $entry['Assigned at'] = $now; // Assuming immediate assignment
        $entry['Organization'] = $user['employment']['title']; // Placeholder organization
        $entry['Due date'] = ''; // Placeholder due date
        $entry['Initially assigned at'] = $now; // Assuming immediate initial assignment
        $entry['Solved at'] = ''; // Placeholder for solved time
        $entry['Resolution time'] = ''; // Placeholder resolution time
        $entry['Satisfaction Score'] = 'Not Offered'; // Placeholder satisfaction score
        $entry['Group stations'] = '1'; // Placeholder group stations count
        $entry['Assignee stations'] = '1'; // Placeholder assignee stations count
        $entry['Reopens'] = '0'; // Placeholder reopens count
        $entry['Replies'] = '0'; // Placeholder replies count
        $entry['First reply time in minutes'] = ''; // Placeholder first reply time
        $entry['First reply time in minutes within business hours'] = ''; // Placeholder first reply time within business hours
        $entry['First resolution time in minutes'] = ''; // Placeholder first resolution time
        $entry['First resolution time in minutes within business hours'] = ''; // Placeholder first resolution time within business hours
        $entry['Full resolution time in minutes'] = ''; // Placeholder full resolution time
        $entry['Full resolution time in minutes within business hours'] = ''; // Placeholder full resolution time within business hours
        $entry['Agent wait time in minutes'] = '0'; // Placeholder agent wait time
        $entry['Agent wait time in minutes within business hours'] = '0'; // Placeholder agent wait time within business hours
        $entry['Requester wait time in minutes'] = '0'; // Placeholder requester wait time
        $entry['Requester wait time in minutes within business hours'] = '0'; // Placeholder requester wait time within business hours
        $entry['On hold time in minutes'] = '0'; // Placeholder on hold time
        $entry['On hold time in minutes within business hours'] = '0'; // Placeholder on hold time within business hours

        $zendeskExport[] = $entry;
    }

    return $zendeskExport;
}

/*
 * Exports the given data to a CSV file.
 *
 * @param array $data The data to export.
 * @param string $filename The name of the CSV file. Defaults to 'zendesk_export.csv'.
 */
function exportToBrowser($data, $filename = 'zendesk_export.csv') {
    // Set headers to prompt file download when outputting data
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="' . $filename . '"');

    // Open file pointer to output stream
    $fp = fopen('php://output', 'w');

    // Output CSV headers if data array isn't empty
    if (!empty($data)) {
        fputcsv($fp, array_keys($data[0]));
    }

    // Output CSV rows
    foreach ($data as $row) {
        fputcsv($fp, $row);
    }

    // Close file pointer
    fclose($fp);
}

// Check if the script was called by a POST request to trigger actions
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['download_csv'])) {
    $randomUsers = fetchRandomUsers();
    $fakeZendeskExport = generateFakeZendeskExport($randomUsers);
    exportToBrowser($fakeZendeskExport);
    exit; // Stop the script after sending CSV
}

// Check trigger conditions for tests
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['generate_test_csv'])) $generate_test_csv = true;
    if (isset($_POST['run_conversion_test'])) $run_conversion_test = true;
}

// Run tests in response to GET requests
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['testID'])) {
    if ($_GET['testID'] == GENERATE_FORM_ID) {
        ZendeskExportTest::generateAndDownloadFakeExport();
        exit; // Stop the script after running test
    } elseif ($_GET['testID'] == CONVERSION_FORM_ID) {
        TestSuite::testZendeskToHaloConversion();
        exit; // Stop the script after running test
    }
}

// Including HTML for the interactive test interface
// ... HTML not shown for brevity ...
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zendesk to Halo Conversion Tests</title>
    <!-- Latest compiled and minified Bootstrap CSS from CDN -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>

<div class="container mt-5">
    <div class="row">
        <div class="col-12 mb-3">
            <?php
            if ($_SERVER['REQUEST_METHOD'] === 'GET' && !empty($_GET)) {
                echo "<div class='alert alert-info'>Running Test: " . htmlspecialchars($_GET['test']) . "</div>";
            }
            ?>
        </div>
        <div class="col-12">
            <h1 class="mb-4">Test Zendesk Export/ Halo Import</h1>
            <ul>
                <li>
                    <h2 class="mb-4">Test Zendesk Export with Demo Data</h2>
                    <form id="generateForm" method="post">
                        <button type="submit" name="generate_test_csv" class="btn btn-warning">Generate Test CSV</button>
                    </form>
                </li>
                <hr/>
                <li>
                    <h2 class="mb-4">Test Halo Import with Demo Zendesk Export Demo Data</h2>
                    <form id="conversionForm" method="post">
                        <button type="submit" name="run_conversion_test" class="btn btn-info">Run Conversion Test</button>
                    </form>
                </li>
            </ul>
        </div>
    </div>
</div>

<!-- Bootstrap JS, Popper.js, and jQuery -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

<script type="application/javascript">
	$('#generateForm').submit(function(event) {
		event.preventDefault();
		fetch("https://gnsit.devtesting.net/tristan-mcgowan-zendesk-to-halo/tests/index.php?testID=<?php echo GENERATE_FORM_ID ?>")
			.then(response => response.blob())
			.then(data => {
				const url = window.URL.createObjectURL(data);
				const link = document.createElement('a');
				link.href = url;
				link.setAttribute('download', 'file.csv');
				document.body.appendChild(link);
				link.click();
			});
	});

	$('#conversionForm').submit(function(event) {
		event.preventDefault();
		fetch("https://gnsit.devtesting.net/tristan-mcgowan-zendesk-to-halo/tests/index.php?testID=<?php echo CONVERSION_FORM_ID ?>")
			.then(response => response.blob())
			.then(data => {
				const url = window.URL.createObjectURL(data);
				const link = document.createElement('a');
				link.href = url;
				link.setAttribute('download', 'file.csv');
				document.body.appendChild(link);
				link.click();
			});
	});
</script>

</body>
</html>
