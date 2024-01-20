<?php
// StaticTestClasses.php

class ZendeskExportTest {

    // This static method fetches random user data and generates a fake Zendesk export
    public static function generateAndDownloadFakeExport() {
        // Assume fetchRandomUsers and generateFakeZendeskExport are defined elsewhere
        $randomUsers = fetchRandomUsers();
        $fakeZendeskExport = generateFakeZendeskExport($randomUsers);

        // Proceed to download the file
        exportToBrowser($fakeZendeskExport, 'fake_zendesk_export.csv');
    }
}
