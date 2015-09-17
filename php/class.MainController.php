<?php

namespace mkdo\dashboard_user_lockout;

/**
 * Class MainController
 * @package mkdo\members
 */
class MainController {

	private $plugin_path;
	private $text_domain;
	private $options;
	private $access_controller;

	function __construct( Options $options, AccessController $access_controller ) {

		$this->plugin_path  = plugin_dir_path( __FILE__ );
		$this->text_domain = 'dashboard-user-lockout';

		$this->options = $options;
		$this->access_controller = $access_controller;
	}

	public function run() {
		load_plugin_textdomain( $this->text_domain, false, $this->plugin_path . '\..\languages' );

		$this->options->run();
		$this->access_controller->run();
	}
}
