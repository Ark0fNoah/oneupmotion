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
		'primary'          => esc_html__( 'Primary Menu', 'oneup-motion' ),
		'footer_nav'       => esc_html__( 'Footer Navigation', 'oneup-motion' ),
		'footer_tools'     => esc_html__( 'Footer Tools', 'oneup-motion' ),
		'footer_resources' => esc_html__( 'Footer Resources', 'oneup-motion' ),
		'footer_legal'     => esc_html__( 'Footer Legal', 'oneup-motion' ),
	) );
}
add_action( 'after_setup_theme', 'oum_register_menus' );
