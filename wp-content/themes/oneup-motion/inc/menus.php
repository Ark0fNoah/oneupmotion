<?php
/**
 * Menu registration.
 *
 * @package OneUpMotion
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

//───────────────────────────────────────
// Navigation menus
//───────────────────────────────────────
function oum_register_menus() {
	register_nav_menus( array(
		'primary' => esc_html__( 'Primary Menu', 'oneup-motion' ),
	) );
}
add_action( 'after_setup_theme', 'oum_register_menus' );
