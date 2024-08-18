# Jeco IP Blacklist

## Description

Jeco IP Blacklist is a WordPress plugin designed to automatically update the `.htaccess` file with the latest IP blacklist to block spam bots. The plugin allows you to set a specific time for the cron job that performs the update.

## Author
Jesus Carrero
GitHub: Jesusjeco

## Features

- Automatically updates the `.htaccess` file with an IP blacklist.
- Configurable cron job to run at a specific time each day.
- Easy-to-use settings page in the WordPress admin dashboard.

## Installation

1. Download the plugin ZIP file or clone the repository:
   git clone https://github.com/Jesusjeco/jeco-ip-blacklist.git

2. Upload the plugin to your WordPress installation:
- If using the ZIP file, go to Plugins > Add New > Upload Plugin and select the ZIP file.
- If using Git, place the cloned repository in the wp-content/plugins/ directory.

3. Activate the plugin from the WordPress admin dashboard under Plugins.

## Configuration
Go to Settings > Jeco Blacklist in the WordPress admin menu.
Enter the desired start time for the cron job in the Cron Job Start Time (HH:MM) field.
Click Save Changes to apply the settings.

## Usage
Once configured, the plugin will automatically update your .htaccess file with the IP blacklist at the specified time each day.

## Acknowledgments

The IP blacklist update script used in this plugin is provided by MyIP.ms. You can find more information about their services at [MyIP.ms](https://myip.ms/).