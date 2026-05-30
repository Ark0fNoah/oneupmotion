<?php
/**
 * Customizer hooks.
 *
 * @package OneUpMotion
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

//───────────────────────────────────────
// Customizer placeholder
//───────────────────────────────────────
function oum_customize_register( $wp_customize ) {
	$blogname = $wp_customize->get_setting( 'blogname' );

	if ( $blogname ) {
		$blogname->transport = 'postMessage';
	}
}
add_action( 'customize_register', 'oum_customize_register' );
