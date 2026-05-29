<?php
/**
 * OneUp Motion theme bootstrap.
 *
 * @package OneUpMotion
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$oum_includes = array(
	'inc/helpers.php',
	'inc/setup.php',
	'inc/menus.php',
	'inc/assets.php',
	'inc/customizer.php',
	'inc/theme-options.php',
	'inc/section-renderer.php',
	'inc/section-builder.php',
);

foreach ( $oum_includes as $oum_file ) {
	$oum_path = get_template_directory() . '/' . $oum_file;

	if ( file_exists( $oum_path ) ) {
		require_once $oum_path;
	}
}
