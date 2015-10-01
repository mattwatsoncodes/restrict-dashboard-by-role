<?php

namespace mkdo\restrict_dashboard_by_role;

/**
 * Class Options
 * @package mkdo\restrict_dashboard_by_role
 */
class Options {

	/**
	 * Constructor
	 */
	public function __construct() {
	}

	/**
	 * Do Work
	 */
	public function run() {
		add_action( 'admin_init', array( $this, 'init_options_page' ) );
		add_action( 'admin_menu', array( $this, 'add_options_page' ) );
		add_action( 'plugin_action_links_' . plugin_basename( MKDO_RDBR_ROOT ) , array( $this, 'add_setings_link' ) );
	}

	/**
	 * Initialise the Options Page
	 */
	public function init_options_page() {

		// Register Settings
		register_setting( 'mkdo_rdbr_settings_group', 'mkdo_rdbr_admin_restrict' );
		register_setting( 'mkdo_rdbr_settings_group', 'mkdo_rdbr_admin_restrict_multiple' );
		register_setting( 'mkdo_rdbr_settings_group', 'mkdo_rdbr_admin_restrict_message' );
		register_setting( 'mkdo_rdbr_settings_group', 'mkdo_rdbr_default_redirect' );

		// Add sections
		add_settings_section( 'mkdo_rdbr_admin_restrict_section', 'Restrict Access to WP Admin', array( $this, 'mkdo_rdbr_admin_restrict_section_cb' ), 'mkdo_rdbr_settings' );

    	// Add fields to a section
		add_settings_field( 'mkdo_rdbr_admin_restrict_user_roles_select', 'Choose User Roles to restrict:', array( $this, 'mkdo_rdbr_admin_restrict_user_roles_select_cb' ), 'mkdo_rdbr_settings', 'mkdo_rdbr_admin_restrict_section' );
		add_settings_field( 'mkdo_rdbr_admin_restrict_multiple', 'How should we handle users with multiple roles?', array( $this, 'mkdo_rdbr_admin_restrict_multiple_cb' ), 'mkdo_rdbr_settings', 'mkdo_rdbr_admin_restrict_section' );
		add_settings_field( 'mkdo_rdbr_admin_restrict_message', 'Enter the restriction message:', array( $this, 'mkdo_rdbr_admin_restrict_message_cb' ), 'mkdo_rdbr_settings', 'mkdo_rdbr_admin_restrict_section' );
		add_settings_field( 'mkdo_rdbr_default_redirect', 'Redirect URL:', array( $this, 'mkdo_rdbr_default_redirect_cb' ), 'mkdo_rdbr_settings', 'mkdo_rdbr_admin_restrict_section' );
	}

	/**
	 * Call back for the admin restrict section
	 */
	public function mkdo_rdbr_admin_restrict_section_cb() {
		echo '<p>';
		esc_html_e( 'Options that allow you to restrict users with certain User Roles from accessing the WordPress Admin Screen.', MKDO_RDBR_TEXT_DOMAIN );
		echo '</p>';
	}

	/**
	 * Call back for the admin restrict user role field
	 */
	public function mkdo_rdbr_admin_restrict_user_roles_select_cb() {

		global $wp_roles;

		$roles              = $wp_roles->roles;
		$mkdo_rdbr_admin_restrict = get_option( 'mkdo_rdbr_admin_restrict', array() );

		if( ! is_array( $mkdo_rdbr_admin_restrict ) ) {
			$mkdo_rdbr_admin_restrict = array();
		}

		?>

		<div class="field field-checkbox-group field-roles">
			<p class="field-description">
				<?php esc_html_e( 'Check the box next to the User Role(s) that you wish to restrict.', MKDO_RDBR_TEXT_DOMAIN );?>
				<?php printf( esc_html__( '%sWarning!%s If you restrict the %sAdministrator%s role, and you have no other User Roles that have a capability of %smanage_options%s, you may get perminantly locked out of the website.', MKDO_RDBR_TEXT_DOMAIN ), '<strong class="warning">', '</strong>', '<strong>', '</strong>', '<code>', '</code>' ); ?>
			</p>
			<ul class="field-input">
				<?php
				foreach ( $roles as $key => $role ) {
					?>
					<li>
						<label>
							<input type="checkbox" name="mkdo_rdbr_admin_restrict[]" value="<?php echo $key; ?>" <?php if ( in_array( $key, $mkdo_rdbr_admin_restrict ) ) { echo ' checked="checked"'; } ?> />
							<?php echo $role['name'];?>
							<?php if( $key == 'administrator' ) {  printf( esc_html__( '%s(See warning - Restrict at own risk)%s', MKDO_RDBR_TEXT_DOMAIN ), '<strong>', '</strong>' ); } ?>
						</label>
					</li>
					<?php
				}
				?>
			</ul>
		</div>
		<?php
	}

	/**
	 * Call back for the admin restrict user priority field
	 */
	public function mkdo_rdbr_admin_restrict_multiple_cb() {

		$mkdo_rdbr_admin_restrict_multiple = get_option( 'mkdo_rdbr_admin_restrict_multiple', 'all' );

		?>

		<div class="field field-radio-group field-handle-multiple">
			<p class="field-description">
				<?php esc_html_e( 'Choose how to handle users that have multiple User Roles.', MKDO_RDBR_TEXT_DOMAIN );?>
			</p>
			<ul class="field-input">
			<li>
				<label><input type="radio" name="mkdo_rdbr_admin_restrict_multiple" value="any" <?php checked( 'any', $mkdo_rdbr_admin_restrict_multiple );?>> <?php printf( esc_html__( 'Users are locked out if %sone or more%s of their roles have been ristricted' , MKDO_RDBR_TEXT_DOMAIN ), '<strong>', '</strong>' );?></label>
			</li>
			<li>
				<label><input type="radio" name="mkdo_rdbr_admin_restrict_multiple" value="all" <?php checked( 'all', $mkdo_rdbr_admin_restrict_multiple );?>> <?php printf( esc_html__( 'Users are locked out if %sall%s of their roles have been ristricted' , MKDO_RDBR_TEXT_DOMAIN ), '<strong>', '</strong>' );?> </label>
			</li>
			</ul
		</div>

		<?php
	}

	/**
	 * Call back for the admin restrict user role field
	 */
	public function mkdo_rdbr_admin_restrict_message_cb() {

		$mkdo_rdbr_admin_restrict_message = get_option( 'mkdo_rdbr_admin_restrict_message', esc_html__( 'Sorry, you do not have permission to access that area of the website.', MKDO_RDBR_TEXT_DOMAIN ) );

		?>

		<div class="field field-textarea field-restrict-message">
			<p class="field-description">
				<label for="mkdo_rdbr_admin_restrict_message">
					<?php esc_html_e( 'Add the message that you wish to appear on the Login Page for restricted users.', MKDO_RDBR_TEXT_DOMAIN );?>
				</label>
			</p>
			<p class="field-input">
				<textarea name="mkdo_rdbr_admin_restrict_message" id="mkdo_rdbr_admin_restrict_message"><?php echo $mkdo_rdbr_admin_restrict_message;?></textarea>
			</p>
		</div>

		<?php
	}

	/**
	 * Call back for the redirect url
	 */
	public function mkdo_rdbr_default_redirect_cb() {

		$mkdo_rdbr_default_redirect = get_option( 'mkdo_rdbr_default_redirect' );
		?>

		<div class="field field-redirect-url">
			<p class="field-title">
				<label for="mkdo_rdbr_default_redirect" class="screen-reader-text">
					<?php esc_html_e( 'Redirect Url', MKDO_RCBR_TEXT_DOMAIN );?>
				</label>
			</p>
			<p class="field-description">
				<?php esc_html_e( 'Enter the full URL that you wish to redirect to. (Leave blank to redirect to login screen).', MKDO_RCBR_TEXT_DOMAIN );?>
			</p>
			<p class="field-input">
				<input type="text" name="mkdo_rdbr_default_redirect" id="mkdo_rdbr_default_redirect" placeholder="http://example.com/content/" value="<?php echo $mkdo_rdbr_default_redirect;?>" />
			</p>
		</div>

		<?php
	}

	/**
	 * Add the options page
	 */
	public function add_options_page() {
		add_submenu_page( 'options-general.php', esc_html__( 'Restrict Dashboard by Role', MKDO_RDBR_TEXT_DOMAIN ), esc_html__( 'Restrict Dashboard by Role', MKDO_RDBR_TEXT_DOMAIN ), 'manage_options', 'restrict_dashboard_by_role', array( $this, 'render_options_page' ) );
	}

	/**
	 * Render the options page
	 */
	public function render_options_page() {
		?>
		<div class="wrap">
			<h2><?php esc_html_e( 'Restrict Dashboard by Role', MKDO_RDBR_TEXT_DOMAIN );?></h2>
			<form action="options.php" method="POST">
	            <?php settings_fields( 'mkdo_rdbr_settings_group' ); ?>
	            <?php do_settings_sections( 'mkdo_rdbr_settings' ); ?>
	            <?php submit_button(); ?>
	        </form>
		</div>
	<?php
	}

	/**
	 * Add 'Settings' action on installed plugin list
	 */
	function add_setings_link( $links ) {
		array_unshift( $links, '<a href="options-general.php?page=restrict_dashboard_by_role">' . esc_html__( 'Settings', MKDO_RDBR_TEXT_DOMAIN ) . '</a>');
		return $links;
	}
}
