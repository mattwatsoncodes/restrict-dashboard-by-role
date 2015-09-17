<?php

namespace mkdo\dashboard_user_lockout;

/**
 * Class Options
 * @package mkdo\dashboard_user_lockout
 */
class Options {

	public function __construct() {

	}

	public function run() {
		add_action( 'admin_init', array( $this, 'init_options_page' ) );
		add_action( 'admin_menu', array( $this, 'add_options_page' ) );
	}

	public function init_options_page() {

		// Register Settings
		register_setting( 'dul_settings_group', 'dul_admin_restrict' );
		register_setting( 'dul_settings_group', 'dul_admin_restrict_multiple' );
		register_setting( 'dul_settings_group', 'dul_admin_restrict_message' );

		// Add sections
		add_settings_section( 'dul_admin_restrict_section', 'Restrict Access to WP Admin', array( $this, 'dul_admin_restrict_section_cb' ), 'dul_settings' );

    	// Add fields to a section
		add_settings_field( 'dul_admin_restrict_user_roles_select', 'Choose User Roles to restrict:', array( $this, 'dul_admin_restrict_user_roles_select_cb' ), 'dul_settings', 'dul_admin_restrict_section' );
		add_settings_field( 'dul_admin_restrict_multiple', 'How should we handle users with multiple roles?', array( $this, 'dul_admin_restrict_multiple_cb' ), 'dul_settings', 'dul_admin_restrict_section' );
		add_settings_field( 'dul_admin_restrict_message', 'Enter the restriction message:', array( $this, 'dul_admin_restrict_message_cb' ), 'dul_settings', 'dul_admin_restrict_section' );
	}

	/**
	 * Add the options page
	 */
	public function add_options_page() {
		add_submenu_page( 'options-general.php', __( 'Dashboard User Lockout', 'dashboard-user-lockout' ), __( 'Dashboard User Lockout', 'dashboard-user-lockout' ), 'manage_options', 'dashboard_user_lockout', array( $this, 'render_options_page' ) );
	}

	/**
	 * Render the options page
	 */
	public function render_options_page() {
		?>
		<div class="wrap">
			<h2><?php _e( 'Dashboard User Lockout', 'dashboard-user-lockout' );?></h2>
			<form action="options.php" method="POST">
	            <?php settings_fields( 'dul_settings_group' ); ?>
	            <?php do_settings_sections( 'dul_settings' ); ?>
	            <?php submit_button(); ?>
	        </form>
		</div>
	<?php
	}

	/**
	 * Call back for the admin restrict section
	 */
	public function dul_admin_restrict_section_cb() {
		echo '<p>';
		_e( 'Options that allow you to restrict users with certain User Roles from accessing the WordPress Admin Screen.', 'dashboard-user-lockout' );
		echo '</p>';
	}

	/**
	 * Call back for the admin restrict user role field
	 */
	public function dul_admin_restrict_user_roles_select_cb() {

		global $wp_roles;

		$roles              = $wp_roles->roles;
		$dul_admin_restrict = get_option( 'dul_admin_restrict', array() );

		if( ! is_array( $dul_admin_restrict ) ) {
			$dul_admin_restrict = array();
		}

		?>

		<p><?php _e( 'Check the box next to the User Role(s) that you wish to restrict.', 'dashboard-user-lockout' );?></p>
		<p><?php _e( '<strong style="background-color:red; color:white; padding: 0 2px 0 2px; font-weight: normal;">Warning!</strong> If you restrict the <strong>Administrator</strong> role, and you have no other User Roles that have a capability of <code>manage_options</code>, you may get perminantly locked out of the website.', 'dashboard-user-lockout' ); ?></p>
		<ul>
			<?php
			foreach ( $roles as $key => $role ) {
				?>
				<li>
					<label>
						<input type="checkbox" name="dul_admin_restrict[]" value="<?php echo $key; ?>" <?php if ( in_array( $key, $dul_admin_restrict ) ) { echo ' checked="checked"'; } ?> />
						<?php echo $role['name'];?> <?php if( $key == 'administrator' ) { _e( ' <strong>(See warning - Restrict at own risk)</strong>', 'dashboard-user-lockout' ); } ?>
					</label>
				</li>
				<?php
			}
			?>
		</ul>
		<?php
	}

	/**
	 * Call back for the admin restrict user priority field
	 */
	public function dul_admin_restrict_multiple_cb() {

		$dul_admin_restrict_multiple = get_option( 'dul_admin_restrict_multiple', 'all' );

		?>

		<p>
			<?php _e( 'Choose how to handle users that have multiple User Roles.', 'dashboard-user-lockout' );?>
		</p>
		<p>
			<label><input type="radio" name="dul_admin_restrict_multiple" value="any" <?php checked( 'any', $dul_admin_restrict_multiple );?>> Users are locked out if <strong>one or more</strong> of their roles have been ristricted</label><br/>
			<label><input type="radio" name="dul_admin_restrict_multiple" value="all" <?php checked( 'all', $dul_admin_restrict_multiple );?>> Users are locked out if <strong>all</strong> of their roles have been ristricted </label>
		</p>

		<?php
	}

	/**
	 * Call back for the admin restrict user role field
	 */
	public function dul_admin_restrict_message_cb() {

		$dul_admin_restrict_message = get_option( 'dul_admin_restrict_message', __( 'Sorry, you do not have permission to access that area of the website.', 'mkdp-members' ) );

		?>

		<p>
			<label for="dul_admin_restrict_message"><?php _e( 'Add the message that you wish to appear on the Login Page for restricted users.', 'dashboard-user-lockout' );?></label>
		</p>
		<p>
			<textarea name="dul_admin_restrict_message" id="dul_admin_restrict_message" style="width:100%;" rows="4"><?php echo $dul_admin_restrict_message;?></textarea>
		</p>

		<?php
	}
}
