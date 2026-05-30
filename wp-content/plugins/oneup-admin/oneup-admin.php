<?php
/**
 * Plugin Name: OneUp Admin
 * Description: Branded WordPress admin experience for OneUp Motion.
 * Version: 2.2.0
 * Author: OneUp Motion
 * Text Domain: oneup-admin
 * Requires at least: 6.0
 * Requires PHP: 7.4
 *
 * @package OneUpAdmin
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'ONEUP_ADMIN_VERSION', '2.2.0' );
define( 'ONEUP_ADMIN_FILE', __FILE__ );
define( 'ONEUP_ADMIN_PATH', plugin_dir_path( __FILE__ ) );
define( 'ONEUP_ADMIN_URL', plugin_dir_url( __FILE__ ) );

$oneup_admin_files = array(
	'includes/Settings.php',
	'includes/Assets.php',
	'includes/Login.php',
	'includes/Dashboard.php',
	'includes/Menu.php',
	'includes/AdminBar.php',
	'includes/Plugin.php',
);

foreach ( $oneup_admin_files as $oneup_admin_file ) {
	$oneup_admin_path = ONEUP_ADMIN_PATH . $oneup_admin_file;

	if ( file_exists( $oneup_admin_path ) ) {
		require_once $oneup_admin_path;
	}
}

//───────────────────────────────────────
// Bootstrap plugin
//───────────────────────────────────────
function oneup_admin_bootstrap() {
	\OneUp_Admin\Plugin::instance();
}
add_action( 'plugins_loaded', 'oneup_admin_bootstrap' );
