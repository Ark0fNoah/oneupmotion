<?php
/**
 * Main plugin manager.
 *
 * @package OneUpAdmin
 */

namespace OneUp_Admin;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

final class Plugin {
	/**
	 * Plugin instance.
	 *
	 * @var Plugin|null
	 */
	private static $instance = null;

	/**
	 * Settings manager.
	 *
	 * @var Settings
	 */
	private $settings;

	/**
	 * Assets manager.
	 *
	 * @var Assets
	 */
	private $assets;

	/**
	 * Login manager.
	 *
	 * @var Login
	 */
	private $login;

	/**
	 * Dashboard manager.
	 *
	 * @var Dashboard
	 */
	private $dashboard;

	/**
	 * Menu manager.
	 *
	 * @var Menu
	 */
	private $menu;

	/**
	 * Admin bar manager.
	 *
	 * @var AdminBar
	 */
	private $admin_bar;

	//───────────────────────────────────────
	// Guarded instance getter
	//───────────────────────────────────────
	public static function instance() {
		if ( null === self::$instance ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	//───────────────────────────────────────
	// Constructor
	//───────────────────────────────────────
	private function __construct() {
		$this->settings  = new Settings();
		$this->assets    = new Assets( $this->settings );
		$this->login     = new Login( $this->settings );
		$this->dashboard = new Dashboard( $this->settings );
		$this->menu      = new Menu( $this->settings );
		$this->admin_bar = new AdminBar( $this->settings );

		$this->settings->register();
		$this->assets->register();
		$this->login->register();
		$this->dashboard->register();
		$this->menu->register();
		$this->admin_bar->register();
	}

	//───────────────────────────────────────
	// Prevent cloning
	//───────────────────────────────────────
	private function __clone() {}

	//───────────────────────────────────────
	// Prevent unserializing
	//───────────────────────────────────────
	public function __wakeup() {
		_doing_it_wrong( __METHOD__, esc_html__( 'Unserializing this class is not allowed.', 'oneup-admin' ), esc_html( ONEUP_ADMIN_VERSION ) );
	}
}
