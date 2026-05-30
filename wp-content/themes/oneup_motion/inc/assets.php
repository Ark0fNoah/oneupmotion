<?php
/**
 * Theme assets.
 *
 * @package OneUpMotion
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

//───────────────────────────────────────
// Front-end assets
//───────────────────────────────────────
function oum_enqueue_assets() {
	wp_enqueue_style(
		'oum-main',
		get_template_directory_uri() . '/assets/css/main.css',
		array(),
		oum_asset_version( 'assets/css/main.css' )
	);

	wp_enqueue_style(
		'oum-sections',
		get_template_directory_uri() . '/assets/css/sections.css',
		array( 'oum-main' ),
		oum_asset_version( 'assets/css/sections.css' )
	);

	wp_enqueue_style(
		'oum-section-addons',
		get_template_directory_uri() . '/assets/css/section-addons.css',
		array( 'oum-sections' ),
		oum_asset_version( 'assets/css/section-addons.css' )
	);

	wp_enqueue_style(
		'oum-builder-fixes',
		get_template_directory_uri() . '/assets/css/builder-fixes.css',
		array( 'oum-section-addons' ),
		oum_asset_version( 'assets/css/builder-fixes.css' )
	);

	wp_enqueue_script(
		'oum-main',
		get_template_directory_uri() . '/assets/js/main.js',
		array(),
		oum_asset_version( 'assets/js/main.js' ),
		true
	);
}
add_action( 'wp_enqueue_scripts', 'oum_enqueue_assets' );
