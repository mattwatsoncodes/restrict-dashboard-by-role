<?php

/**
 * @link              https://github.com/mkdo/mkdo-members
 * @since             1.0.0
 * @package           mkdo\members
 *
 * @wordpress-plugin
 * Plugin Name:       MKDO Members
 * Plugin URI:        https://github.com/mkdo/mkdo-members
 * Description:       Easy User and Membership management for WordPress from Make Do
 * Version:           1.0.0
 * Author:            Make Do <hello@makedo.in>
 * Author URI:        http://www.makedo.in
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       mkdo-members
 * Domain Path:       /languages
 */

// Load Classes
require_once( "php/class.MainController.php" );
require_once( "php/class.Options.php" );
require_once( "php/class.AccessController.php" );
require_once( "php/class.LoginErrors.php" );

// Define Namespaces
use mkdo\members\MainController;
use mkdo\members\Options;
use mkdo\members\AccessController;
use mkdo\members\LoginErrors;

// Initialize Controllers
$options           = new Options();
$login_errors      = new LoginErrors();
$access_controller = new AccessController( $login_errors );
$controller        = new MainController( $options, $access_controller );

// Run the Plugin
$controller->run();
