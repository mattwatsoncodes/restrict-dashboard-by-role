<?php

namespace mkdo\restrict_dashboard_by_role;

/**
 * Class LoginErrors
 * @package mkdo\restrict_dashboard_by_role
 */
class LoginErrors {

	// Constructor
	public function __construct( ) {
	}

	// Do Work
	public function run() {
		add_action( 'login_message', array( $this, 'error_insufficient_permissions' ), 99 );
	}

	/**
	 * Error to show if there are insufficiant permissions to access content
	 */
	public function error_insufficient_permissions() {
		if( isset( $_GET['error'] ) && $_GET['error'] == 'mkdo-rcbr-insufficient-permissions' ) {

			$error   = get_option( 'mkdo_rdbr_admin_restrict_message' );

			$message = '';
			$message .= '<p class="message">';
			$message .= $error;
			$message .= '</p>';

			return $message;
		}
	}
}
