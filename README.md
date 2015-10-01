# Restrict Dashboard by Role

Restrict users with certain User Roles from accessing the WordPress Dashboard (WP Admin).

## About

If you have a WordPress website with multiple users and several User Roles defined, and you wish to prevent certain User Roles from accessing `wp-admin`, then this plugin is for you.

The plugin provides the following functionality:

- An options screen, that lets you:
 - Restrict Access to the WordPress Admin Screen (WP Admin) for one or more User Roles.
 - Choose how to handle the restriction for users with multiple roles
 - Define a login screen error message (if no custom redirect URL is set)
 - Set a custom redirect URL

## Installation

1. Download this repository and unzip it into the folder `restrict-dashboard-by-role`
2. Upload the `restrict-dashboard-by-role` folder to the `/wp-content/plugins/` directory
3. Activate the plugin through the 'Plugins' menu in WordPress
4. Configure the plugin via the 'Restrict Dashboard by Role' options page under the WordPress 'Settings' Menu

## Changelog

**2.1.0** - *01.10.2015* - Updated for submission to WordPress plugin repository.  
**2.0.0** - *01.10.2015* - Code review and refactor.  
**1.2.0** - *27.09.2015* - Stopped the plugin blocking AJAX calls.  
**1.1.0** - *17.09.2015* - Added ability to choose how to handle restrictions for users with multiple roles.  
**1.0.2** - *17.09.2015* - Corrected options page path.  
**1.0.1** - *17.09.2015* - Updated POT File, and cleaned up legacy references.  
**1.0.0** - *17.09.2015* - First stable release.  
