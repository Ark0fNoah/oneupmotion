<?php
/**
 * Main plugin coordinator.
 *
 * @package OneUpTools
 */

namespace OneUpTools;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Plugin {
	/**
	 * Asset manager.
	 *
	 * @var Assets|null
	 */
	private $assets;

	/**
	 * Shortcode manager.
	 *
	 * @var Shortcodes|null
	 */
	private $shortcodes;

	/**
	 * Settings manager.
	 *
	 * @var Settings|null
	 */
	private $settings;

	//───────────────────────────────────────
	// Boot services
	//───────────────────────────────────────
	public function __construct() {
		$this->assets     = class_exists( __NAMESPACE__ . '\Assets' ) ? new Assets() : null;
		$this->settings   = class_exists( __NAMESPACE__ . '\Settings' ) ? new Settings() : null;
		$this->shortcodes = class_exists( __NAMESPACE__ . '\Shortcodes' ) ? new Shortcodes( $this->assets, $this->settings ) : null;

		add_action( 'init', array( $this, 'load_tool_files' ) );
	}

	//───────────────────────────────────────
	// Optional tool includes
	//───────────────────────────────────────
	public function load_tool_files() {
		$tool_file = ONEUP_TOOLS_PATH . 'tools/qr-generator/qr-generator.php';

		if ( file_exists( $tool_file ) ) {
			require_once $tool_file;
		}
	}
}
