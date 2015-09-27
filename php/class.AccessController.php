<?php

namespace mkdo\dashboard_user_lockout;

/**
 * Class AccessController
 * @package mkdo\dashboard_user_lockout
 */
class AccessController {

	private $login_errors;

	public function __construct( LoginErrors $login_errors ) {
		$this->login_errors = $login_errors;
	}

	public function run() {
		add_action( 'admin_init', array( $this, 'access_control' ) );

		$this->login_errors->run();
	}

	public function access_control() {

		$restricted_roles    = get_option( 'dul_admin_restrict' );
		$restricted_multiple = get_option( 'dul_admin_restrict_multiple' );
		$current_user        = wp_get_current_user();
		$roles               = $current_user->roles;
		$redirect_url        = wp_login_url ('', false ) . '?error="insufficient-permissions"';

		if( ! is_array( $restricted_roles ) ) {
			$restricted_roles = array();
		}

		if( $restricted_multiple == 'any' ) {
			foreach( $roles as $key => $role ) {
				if( in_array( $role, $restricted_roles ) ) {

					wp_logout();
					wp_safe_redirect( $redirect_url );
					exit;
				}
			}
		} else if( $restricted_multiple == 'all' && ( ! defined( 'DOING_AJAX' ) || ! DOING_AJAX ) ) {
			if( count( array_intersect( $roles, $restricted_roles ) ) == count( $roles ) ) {

				wp_logout();
				wp_safe_redirect( $redirect_url );
				exit;
			}
		}
	}
}
