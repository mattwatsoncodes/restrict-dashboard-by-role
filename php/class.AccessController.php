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

		// If we are doing an ajax request, let it through
		if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) {
			return;
		}

		$mkdo_rdbr_admin_restrict          = get_option( 'mkdo_rdbr_admin_restrict' );
		$mkdo_rdbr_admin_restrict_multiple = get_option( 'mkdo_rdbr_admin_restrict_multiple' );
		$current_user                      = wp_get_current_user();
		$roles                             = $current_user->roles;
		$redirect_url                      = wp_login_url( '', false ) . '?error="mkdo-rcbr-insufficient-permissions"';
		$mkdo_rdbr_default_redirect        = get_option( 'mkdo_rdbr_default_redirect' );
		$mkdo_rdbr_force_logout            = get_option( 'mkdo_rdbr_force_logout', 'true' );

		if ( ! empty( $mkdo_rdbr_default_redirect ) ) {
			$redirect_url = $mkdo_rdbr_default_redirect;
		}

		if ( ! is_array( $mkdo_rdbr_admin_restrict ) ) {
			$mkdo_rdbr_admin_restrict = array();
		}

		// If user is in any role, redirect
		if ( 'any' == $mkdo_rdbr_admin_restrict_multiple ) {
			foreach ( $roles as $key => $role ) {
				if ( in_array( $role, $mkdo_rdbr_admin_restrict ) ) {
					if ( 'true' === $mkdo_rdbr_force_logout ) {
						wp_logout();
					}
					wp_redirect( $redirect_url );
					exit;
				}
			}
		} else if ( 'all' == $mkdo_rdbr_admin_restrict_multiple ) {
			// If user has to be in all roles, check it is not an AJAX request
			// If user is in all roles, redirect
			if ( count( array_intersect( $roles, $mkdo_rdbr_admin_restrict ) ) == count( $roles ) ) {
				if ( 'true' === $mkdo_rdbr_force_logout ) {
					wp_logout();
				}
				wp_redirect( $redirect_url );
				exit;
			}
		}
	}
}
