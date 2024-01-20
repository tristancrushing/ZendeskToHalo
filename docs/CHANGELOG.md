# CHANGELOG for Zendesk to Halo Library

The CHANGELOG documents the history of changes, updates, and notable enhancements made to the Zendesk to Halo library. It includes versioning information and descriptions of significant additions, fixes, and any breaking changes.

---

## [0.0.5] - 2024-01-20

### Added
- Expanded `.gitignore` to exclude additional directories for improved repository cleanliness.
- Created `README.md` providing an overview of the library and a quick start guide for users.
- Added comprehensive documentation in the `docs` folder, detailing various aspects of the library.
- Introduced new test classes and updated the test index for expanded test coverage.

### Changed
- Made minor modifications to `ZendeskToHalo.php` for code clarity.
- Enhanced `index.php` with improved HTML structure and styling.
- Refined Zendesk to Halo conversion module with enhanced security, configurability, and new configurations.
- Updated `src/ZendeskExportToHaloImport.php` for better CSV output header configuration.
- Improved dynamic data mapping in `src/ZendeskToHaloDataMap.php`.
- Modified `src/index.php` and `src/index_high_sec.php` to introduce `constantsConfig.php` and the `stripPublicHtml` function.

### Security
- Advanced security measures in `src/index_high_sec.php`, tailored for cybersecurity education.

---

## [0.0.4] - 2024-01-20

### Added
- Enhanced documentation in `constantsConfig.php` for improved understanding and maintainability.

### Changed
- Refined Zendesk to Halo conversion module with enhanced security, configurability, and new configurations.
- Updated `src/ZendeskExportToHaloImport.php` for better CSV output header configuration.
- Enhanced `src/ZendeskToHalo.php` with an updated success message.
- Improved dynamic data mapping in `src/ZendeskToHaloDataMap.php`.
- Modified `src/index.php` and `src/index_high_sec.php` to introduce `constantsConfig.php` and the `stripPublicHtml` function.

### Security
- Advanced security measures in `src/index_high_sec.php`, tailored for cybersecurity education.

---

## [0.0.3] - 2024-01-20

### Added
- Initial implementation of the Zendesk CSV to Halo Import conversion module.
- Core files: `src/ZendeskExportToHaloImport.php`, `src/ZendeskToHalo.php`, `src/ZendeskToHaloDataMap.php`.
- Basic (`src/index.php`) and high-security (`src/index_high_sec.php`) web interfaces.
- Comprehensive comments for educational purposes.

### Security
- Basic security measures in `src/index.php` for standard web applications.

---

## [0.0.2] - 2024-01-20

### Added
- Setup of PHP Composer project structure.
- `ZendeskCsvController` class with methods for CSV data manipulation.

### Features
- Methods in `ZendeskCsvController`: `readCsvToArray`, `convertArrayToJson`, `convertArrayToObject`, `runExampleUsage`.
- PSR-4 autoloading standards implemented.

---

## [0.0.1] - 2024-01-20

### Added
- Project initialization with basic structure and essential classes.

### Notes
- This represents the foundational stage of the project, focusing on setting up the core components and establishing the project's framework.

---

*Note: The version numbers represent the pre-release development stages of the Zendesk to Halo library, leading up to its initial public release.*

---

## How to Contribute to the CHANGELOG

When contributing to the library, please document any significant changes in this CHANGELOG as part of your pull request. This includes new features, changes to existing functionality, bug fixes, and security updates. Remember to follow the existing format for consistency.

---

For the most up-to-date information and version history, visit the library's GitHub repository.