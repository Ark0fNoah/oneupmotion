<?php
/**
 * Plugin Name: OneUp Tools
 * Plugin URI: https://oneupmotion.com
 * Description: Future-ready digital tools for OneUp Motion, starting with a QR Generator shortcode placeholder.
 * Version: 0.1.0
 * Author: OneUp Motion
 * Author URI: https://oneupmotion.com
 * Text Domain: oneup-tools
 * Requires at least: 6.0
 * Requires PHP: 7.4
 *
 * @package OneUpTools
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'ONEUP_TOOLS_VERSION', '0.1.0' );
define( 'ONEUP_TOOLS_FILE', __FILE__ );
define( 'ONEUP_TOOLS_PATH', plugin_dir_path( __FILE__ ) );
define( 'ONEUP_TOOLS_URL', plugin_dir_url( __FILE__ ) );

$oneup_tools_files = array(
	'includes/Assets.php',
	'includes/Settings.php',
	'includes/Shortcodes.php',
	'includes/Plugin.php',
);

foreach ( $oneup_tools_files as $oneup_tools_file ) {
	$oneup_tools_path = ONEUP_TOOLS_PATH . $oneup_tools_file;

	if ( file_exists( $oneup_tools_path ) ) {
		require_once $oneup_tools_path;
	}
}

//───────────────────────────────────────
// Plugin instance
//───────────────────────────────────────
function oneup_tools() {
	static $instance = null;

	if ( null === $instance && class_exists( '\OneUpTools\Plugin' ) ) {
		$instance = new \OneUpTools\Plugin();
	}

	return $instance;
}

oneup_tools();
