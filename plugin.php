<?php

/**
 * @link              https://github.com/mkdo/dashboard-user-lockout
 * @since             1.1.0
 * @package           mkdo\dashboard_user_lockout
 *
 * @wordpress-plugin
 * Plugin Name:       Dashboard User Lockout
 * Plugin URI:        https://github.com/mkdo/dashboard-user-lockout
 * Description:       Restrict users with certain User Roles from accessing the WordPress Dashboard (WP Admin).
 * Version:           1.1.0
 * Author:            Make Do <hello@makedo.in>
 * Author URI:        http://www.makedo.in
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       dashboard-user-lockout
 * Domain Path:       /languages
 */

// Load Classes
require_once( "php/class.MainController.php" );
require_once( "php/class.Options.php" );
require_once( "php/class.AccessController.php" );
require_once( "php/class.LoginErrors.php" );

// Define Namespaces
use mkdo\dashboard_user_lockout\MainController;
use mkdo\dashboard_user_lockout\Options;
use mkdo\dashboard_user_lockout\AccessController;
use mkdo\dashboard_user_lockout\LoginErrors;

// Initialize Controllers
$options           = new Options();
$login_errors      = new LoginErrors();
$access_controller = new AccessController( $login_errors );
$controller        = new MainController( $options, $access_controller );

// Run the Plugin
$controller->run();
