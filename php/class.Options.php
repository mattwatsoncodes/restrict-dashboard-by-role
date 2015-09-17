<?php

namespace mkdo\members;

/**
 * Class Options
 * @package mkdo\members
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
		register_setting( 'mm_settings_group', 'mm_admin_restrict' );
		register_setting( 'mm_settings_group', 'mm_admin_restrict_message' );

		// Add sections
		add_settings_section( 'mm_admin_restrict_section', 'Restrict Access to WP Admin', array( $this, 'mm_admin_restrict_section_cb' ), 'mm_settings' );

    	// Add fields to a section
		add_settings_field( 'mm_admin_restrict_user_roles_select', 'Choose User Roles to restrict:', array( $this, 'mm_admin_restrict_user_roles_select_cb' ), 'mm_settings', 'mm_admin_restrict_section' );
		add_settings_field( 'mm_admin_restrict_message', 'Enter the restriction message:', array( $this, 'mm_admin_restrict_message_cb' ), 'mm_settings', 'mm_admin_restrict_section' );
	}

	/**
	 * Add the options page
	 */
	public function add_options_page() {
		add_submenu_page( 'options-general.php', 'Members', 'Members', 'manage_options', 'mkdo_members', array( $this, 'render_options_page' ), 'dashicons-groups' );
	}

	/**
	 * Render the options page
	 */
	public function render_options_page() {
		?>
		<div class="wrap">
			<h2>Members</h2>
			<form action="options.php" method="POST">
	            <?php settings_fields( 'mm_settings_group' ); ?>
	            <?php do_settings_sections( 'mm_settings' ); ?>
	            <?php submit_button(); ?>
	        </form>
		</div>
	<?php
	}

	/**
	 * Call back for the admin restrict section
	 */
	public function mm_admin_restrict_section_cb() {
		echo '<p>';
		_e( 'Select the User Roles that you wish to restrict from accessing the WordPress Admin Screen:', 'mkdo-members' );
		echo '</p>';
	}

	/**
	 * Call back for the admin restrict user role field
	 */
	public function mm_admin_restrict_user_roles_select_cb() {

		global $wp_roles;

		$roles             = $wp_roles->roles;
		$mm_admin_restrict = get_option( 'mm_admin_restrict', array() );

		?>

		<p><?php _e( 'Check the box next to the User Role(s) that you wish to restrict:', 'mkdo-members' );?></p>

		<ul>
			<?php
			foreach ( $roles as $key => $role ) {
				?>
				<li>
					<label>
						<input type="checkbox" name="mm_admin_restrict[]" value="<?php echo $key; ?>" <?php if ( in_array( $key, $mm_admin_restrict ) ) { echo ' checked="checked"'; } ?> />
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
	public function mm_admin_restrict_message_cb() {

		$mm_admin_restrict_message = get_option( 'mm_admin_restrict_message', __( 'Sorry, you do not have permission to access that area of the website.', 'mkdp-members' ) );

		?>

		<p>
			<label for="mm_admin_restrict_message"><?php _e( 'Add the message that you wish to appear on the Login Page for restricted users.', 'mkdo-members' );?></label>
		</p>
		<p>
			<textarea name="mm_admin_restrict_message" id="mm_admin_restrict_message" style="width:100%;" rows="4"><?php echo $mm_admin_restrict_message;?></textarea>
		</p>

		<?php
	}
}
