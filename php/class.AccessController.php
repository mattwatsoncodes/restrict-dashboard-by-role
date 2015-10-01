<?php

namespace mkdo\restrict_dashboard_by_role;

/**
 * Class AccessController
 * @package mkdo\restrict_dashboard_by_role
 */
class AccessController {

	private $login_errors;

	/**
	 * Constructor
	 *
	 * @param LoginErrors $login_errors Object that renders error messages on the login screen
	 */
	public function __construct( LoginErrors $login_errors ) {
		$this->login_errors = $login_errors;
	}

	/**
	 * Do Work
	 */
	public function run() {
		add_action( 'admin_init', array( $this, 'access_control' ) );

		$this->login_errors->run();
	}

	/**
	 * Check if user has access
	 */
	public function access_control() {

		$mkdo_rdbr_admin_restrict          = get_option( 'mkdo_rdbr_admin_restrict' );
		$mkdo_rdbr_admin_restrict_multiple = get_option( 'mkdo_rdbr_admin_restrict_multiple' );
		$current_user                      = wp_get_current_user();
		$roles                             = $current_user->roles;
		$redirect_url                      = wp_login_url ( '', false ) . '?error="mkdo-rcbr-insufficient-permissions"';
		$mkdo_rdbr_default_redirect        = get_option( 'mkdo_rdbr_default_redirect' );

		if ( ! empty( $mkdo_rdbr_default_redirect ) ) {
			$redirect_url = $mkdo_rdbr_default_redirect;
		}

		if ( ! is_array( $mkdo_rdbr_admin_restrict ) ) {
			$mkdo_rdbr_admin_restrict = array();
		}

		// If user is in any role, redirect
		if ( $mkdo_rdbr_admin_restrict_multiple== 'any' ) {
			foreach ( $roles as $key => $role ) {
				if ( in_array( $role, $mkdo_rdbr_admin_restrict ) ) {
					wp_logout();
					wp_redirect( $redirect_url );
					exit;
				}
			}

		// If user has to be in all roles, check it is not an AJAX request
		} else if ( $mkdo_rdbr_admin_restrict_multiple == 'all' && ( ! defined( 'DOING_AJAX' ) || ! DOING_AJAX ) ) {

			// If user is in all roles, redirect
			if ( count( array_intersect( $roles, $mkdo_rdbr_admin_restrict ) ) == count( $roles ) ) {
				wp_logout();
				wp_redirect( $redirect_url );
				exit;
			}
		}
	}
}
