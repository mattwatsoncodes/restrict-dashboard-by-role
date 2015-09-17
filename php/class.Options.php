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
		register_setting( 'dul_settings_group', 'dul_admin_restrict_message' );

		// Add sections
		add_settings_section( 'dul_admin_restrict_section', 'Restrict Access to WP Admin', array( $this, 'dul_admin_restrict_section_cb' ), 'dul_settings' );

    	// Add fields to a section
		add_settings_field( 'dul_admin_restrict_user_roles_select', 'Choose User Roles to restrict:', array( $this, 'dul_admin_restrict_user_roles_select_cb' ), 'dul_settings', 'dul_admin_restrict_section' );
		add_settings_field( 'dul_admin_restrict_message', 'Enter the restriction message:', array( $this, 'dul_admin_restrict_message_cb' ), 'dul_settings', 'dul_admin_restrict_section' );
	}

	/**
	 * Add the options page
	 */
	public function add_options_page() {
		add_submenu_page( 'options-general.php', __( 'Dashboard User Lockout', 'dashboard-user-lockout' ), __( 'Dashboard User Lockout', 'dashboard-user-lockout' ), 'manage_options', 'mkdo_members', array( $this, 'render_options_page' ), 'dashicons-groups' );
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
		_e( 'Select the User Roles that you wish to restrict from accessing the WordPress Admin Screen:', 'dashboard-user-lockout' );
		echo '</p>';
	}

	/**
	 * Call back for the admin restrict user role field
	 */
	public function dul_admin_restrict_user_roles_select_cb() {

		global $wp_roles;

		$roles             = $wp_roles->roles;
		$dul_admin_restrict = get_option( 'dul_admin_restrict', array() );

		?>

		<p><?php _e( 'Check the box next to the User Role(s) that you wish to restrict:', 'dashboard-user-lockout' );?></p>

		<ul>
			<?php
			foreach ( $roles as $key => $role ) {
				?>
				<li>
					<label>
						<input type="checkbox" name="dul_admin_restrict[]" value="<?php echo $key; ?>" <?php if ( in_array( $key, $dul_admin_restrict ) ) { echo ' checked="checked"'; } ?> />
						<?php echo $role['name'];?>
					</label>
				</li>
				<?php
			}
			?>
		</ul>
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
