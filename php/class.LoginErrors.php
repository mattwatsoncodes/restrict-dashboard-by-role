<?php

namespace mkdo\dashboard_user_lockout;

/**
 * Class LoginErrors
 * @package mkdo\dashboard_user_lockout
 */
class LoginErrors {

	public function __construct( ) {
	}

	public function run() {
		add_action( 'login_message', array( $this, 'error_insufficient_permissions' ) );
	}

	public function error_insufficient_permissions() {
		if( isset( $_GET['error'] ) && $_GET['error'] == 'insufficient-permissions' ) {

			$error   = get_option( 'dul_admin_restrict_message' );

			$message = '';
			$message .= '<p class="message">';
			$message .= $error;
			$message .= '</p>';
			return $message;
		}
	}
}
