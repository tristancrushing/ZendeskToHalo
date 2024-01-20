# Troubleshooting Guide for Zendesk to Halo Library

This document provides solutions for common issues encountered while using the Zendesk to Halo conversion library. It includes debugging tips and contact information for further support.

## Common Issues and Solutions

### Issue: File Upload Errors

**Symptoms:**
- Error messages during file upload.
- Uploaded file is not processed.

**Solutions:**
- Ensure the file is a valid CSV format.
- Check file size limits as per your PHP and web server settings.
- Verify that the `uploads` directory has the correct permissions.

### Issue: Incorrect Data Mapping

**Symptoms:**
- Output data does not match the expected format.
- Missing or incorrectly formatted fields in the Halo import file.

**Solutions:**
- Check if the Zendesk export file matches the expected structure.
- Review and adjust the mapping constants in `constantsConfig.php`.
- Ensure that the `ZendeskToHaloDataMap` class correctly maps each field.

### Issue: Conversion Process Fails

**Symptoms:**
- The script stops or crashes during the conversion process.
- No output file is generated.

**Solutions:**
- Check for PHP errors or warnings in your log files.
- Verify that all required dependencies are installed and up to date.
- Increase memory limits or execution time in your PHP configuration if the file is large.

## Debugging Tips

- **Enable Detailed Error Reporting:** Temporarily enable detailed error reporting in PHP to get more insight into any issues. Add `error_reporting(E_ALL);` and `ini_set('display_errors', 1);` at the beginning of your script.
- **Check Log Files:** Regularly check the PHP and web server log files for any errors or warnings.
- **Test with Sample Data:** Use known good sample data to isolate the issue. This can help determine if the problem is with the data or the code.

## Further Support

If you encounter issues that are not covered in this guide, or if you need more personalized assistance, please contact us for support:

- **Email:** support@ipspy.net
- **GitHub Issues:** If applicable, you can also open an issue on the GitHub repository for the library.

Please provide as much detail as possible when seeking support, including error messages, steps to reproduce the issue, and any relevant code snippets or data samples.
