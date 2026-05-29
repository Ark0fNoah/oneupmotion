<?php
/**
 * Frontend rendering for OneUp Sections.
 *
 * @package OneUpMotion
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

//───────────────────────────────────────
// Section type definitions
//───────────────────────────────────────
function oum_section_types() {
	return array(
		'hero'          => __( 'Hero Section', 'oneup-motion' ),
		'text'          => __( 'Text Section', 'oneup-motion' ),
		'text_image'    => __( 'Text + Image Section', 'oneup-motion' ),
		'cards'         => __( 'Cards Section', 'oneup-motion' ),
		'tools_preview' => __( 'Tools Preview Section', 'oneup-motion' ),
		'services'      => __( 'Services Section', 'oneup-motion' ),
		'cta'           => __( 'CTA Section', 'oneup-motion' ),
		'faq'           => __( 'FAQ Section', 'oneup-motion' ),
		'contact'       => __( 'Contact Section', 'oneup-motion' ),
	);
}

//───────────────────────────────────────
// Section getter
//───────────────────────────────────────
function oum_get_sections( $post_id = null ) {
	$post_id  = $post_id ? absint( $post_id ) : get_the_ID();
	$sections = $post_id ? get_post_meta( $post_id, '_oum_sections', true ) : array();

	return is_array( $sections ) ? $sections : array();
}

//───────────────────────────────────────
// Has sections
//───────────────────────────────────────
function oum_has_sections( $post_id = null ) {
	return ! empty( oum_get_sections( $post_id ) );
}

//───────────────────────────────────────
// Render sections
//───────────────────────────────────────
function oum_render_sections( $post_id = null ) {
	$sections = oum_get_sections( $post_id );

	if ( empty( $sections ) ) {
		return;
	}

	foreach ( $sections as $section ) {
		$type = isset( $section['type'] ) ? sanitize_key( $section['type'] ) : '';

		if ( ! array_key_exists( $type, oum_section_types() ) ) {
			continue;
		}

		get_template_part( 'template-parts/sections/section-' . str_replace( '_', '-', $type ), null, array( 'section' => $section ) );
	}
}

//───────────────────────────────────────
// Section field helper
//───────────────────────────────────────
function oum_section_field( $section, $key, $fallback = '' ) {
	return isset( $section[ $key ] ) && '' !== $section[ $key ] ? $section[ $key ] : $fallback;
}

//───────────────────────────────────────
// Section rich text output
//───────────────────────────────────────
function oum_section_rich_text( $text ) {
	echo wp_kses_post( wpautop( $text ) );
}

//───────────────────────────────────────
// Highlight heading helper
//───────────────────────────────────────
function oum_section_heading_with_highlight( $heading, $highlight ) {
	$heading   = (string) $heading;
	$highlight = trim( (string) $highlight );

	if ( '' === $highlight || false === stripos( $heading, $highlight ) ) {
		echo esc_html( $heading );
		return;
	}

	$pattern = '/' . preg_quote( $highlight, '/' ) . '/i';
	$output  = preg_replace( $pattern, '<span>$0</span>', esc_html( $heading ), 1 );

	echo wp_kses( $output, array( 'span' => array() ) );
}
