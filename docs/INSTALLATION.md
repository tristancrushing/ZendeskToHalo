# INSTALLATION.md

Welcome to the installation guide for the Zendesk to Halo library. This document provides detailed instructions on setting up and installing the library, assuming minimal experience with PHP and Linux. Instructions are tailored for environments including Plesk and cPanel.

---

## Requirements

- PHP (version 8.x or higher).
- Composer (for managing PHP dependencies).
- Access to a Linux-based server environment.
- For Plesk or cPanel users, access to your hosting control panel.

---

## Basic Installation

1. **Install PHP**: Ensure PHP 8.x or higher is installed on your server. Most Linux distributions come with PHP, but you might need to upgrade to meet the version requirement.

2. **Install Composer**: Composer is a tool for dependency management in PHP. Install it by following the instructions on the [Composer website](https://getcomposer.org/download/).

3. **Clone the Repository**:
   ```bash
   git clone https://github.com/tristancrushing/ZendeskToHalo.git
   cd ZendeskToHalo
   ```

4. **Install Dependencies**:
   Run Composer to install the required PHP dependencies:
   ```bash
   composer install
   ```

5. **Configuration**:
   Edit the `constantsConfig.php` file in the `src` directory to adjust configuration settings as per your requirements.

---

## Plesk Installation

1. **Access Plesk Panel**: Log in to your Plesk control panel.

2. **Check PHP Version**: Ensure you are running PHP 8.x or higher. You can check and change this in the Plesk PHP settings for your domain.

3. **File Manager**: Use Plesk's File Manager to upload the ZendeskToHalo project folder to your hosting space.

4. **SSH Access**:
    - If you have SSH access, follow the Basic Installation steps in the terminal.
    - If not, use Plesk's built-in Composer tool to install dependencies.

---

## cPanel Installation

1. **Access cPanel**: Log in to your cPanel account.

2. **Software Section**: In the Software section of cPanel, select ‘Select PHP Version’ to ensure you’re using PHP 8.x or higher.

3. **File Manager**: Use the cPanel File Manager to upload the ZendeskToHalo project folder to your server.

4. **Terminal or SSH**:
    - If you have SSH access, you can use terminal commands as in Basic Installation.
    - Alternatively, use cPanel’s terminal feature to run Composer and install dependencies.

---

## Post-Installation

After installation, navigate to the `index.php` file in your web browser to start using the Zendesk to Halo library. For specific usage instructions, refer to [USAGE.md](USAGE.md).

---

*If you encounter any issues during installation, please refer to our [TROUBLESHOOTING.md](TROUBLESHOOTING.md) for assistance.*