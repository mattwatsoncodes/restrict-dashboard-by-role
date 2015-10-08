=== Restrict Dashboard by Role ===
Contributors: mkdo, mwtsn
Donate link:
Tags: restrict, restrict admin, restrict wp-admin, restrict dashboard, lockdown, lockdown admin, lockdown wp-admin, lockdown dashboard, admin, dashboard, wp-admin, lockdown, management, permissions, manage dashboard permissions, manage wp-admin permissions, manage admin permissions, manage wp-admin permissions, manage users, manage roles, users, roles
Requires at least: 4.3
Tested up to: 4.3
Stable tag: 2.1.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Restrict users with certain User Roles from accessing the WordPress Dashboard (WP Admin).

== Description ==

If you have a WordPress website with multiple users and several User Roles defined, and you wish to prevent certain User Roles from accessing `wp-admin`, then this plugin is for you.

The plugin provides the following functionality:

* An options screen, that lets you:
 * Restrict Access to the WordPress Admin Screen (WP Admin) for one or more User Roles.
 * Choose how to handle the restriction for users with multiple roles
 * Define a login screen error message (if no custom redirect URL is set)
 * Set a custom redirect URL

If you are using this plugin in your project [we would love to hear about it](mailto:hello@makedo.in).

== Installation ==

1. Backup your WordPress install
2. Upload the plugin folder to the `/wp-content/plugins/` directory
3. Activate the plugin through the 'Plugins' menu in WordPress
4. Configure the plugin via the 'Restrict Dashboard by Role' options page under the WordPress 'Settings' Menu

== Screenshots ==

1. Options page

== Changelog ==

= 2.1.0 =
* Updated for submission to WordPress plugin repository

= 2.0.0 =
* Code review and refactor

= 1.2.0 =
* Stopped the plugin blocking AJAX calls

= 1.1.0 =
* Added ability to choose how to handle restrictions for users with multiple roles.

= 1.0.2 =
* Corrected options page path

= 1.0.1 =
* Updated POT File, and cleaned up legacy references

= 1.0.0 =
* First stable release
