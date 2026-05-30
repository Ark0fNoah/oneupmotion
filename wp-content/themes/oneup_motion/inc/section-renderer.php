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
		'qr_generator'  => __( 'QR Generator', 'oneup-motion' ),
		'logo_strip'    => __( 'Logo Strip / Trust Strip', 'oneup-motion' ),
		'preview_boxes' => __( 'Preview Boxes', 'oneup-motion' ),
		'feature_grid'  => __( 'Services / Feature Grid', 'oneup-motion' ),
		'story'         => __( 'Story / About Section', 'oneup-motion' ),
		'shortcode'     => __( 'Custom Shortcode', 'oneup-motion' ),
		'custom_code'   => __( 'Custom Code', 'oneup-motion' ),
	);
}

//───────────────────────────────────────
// Repeater field map
//───────────────────────────────────────
function oum_section_repeater_fields( $type ) {
	$fields = array(
		'cards'    => array( 'icon_type', 'icon_text', 'icon_image_id', 'icon_url', 'icon_svg', 'icon_alt', 'title', 'text', 'button_label', 'button_url' ),
		'services' => array( 'icon_type', 'icon_text', 'icon_image_id', 'icon_url', 'icon_svg', 'icon_alt', 'title', 'text', 'url', 'button_label' ),
		'faq'      => array( 'question', 'answer' ),
	);

	return $fields[ $type ] ?? array();
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
// Section class helper
//───────────────────────────────────────
function oum_section_classes( $section, $base = 'oum-section' ) {
	$classes = array(
		$base,
		'section',
		'oum-bg-' . sanitize_html_class( oum_section_field( $section, 'background_style', 'default' ) ),
		'oum-width-' . sanitize_html_class( oum_section_field( $section, 'layout_width', 'default' ) ),
		'oum-spacing-' . sanitize_html_class( oum_section_field( $section, 'section_spacing', 'default' ) ),
		'oum-align-' . sanitize_html_class( oum_section_field( $section, 'text_alignment', 'left' ) ),
	);

	$custom = oum_section_field( $section, 'custom_class', '' );
	if ( $custom ) {
		foreach ( preg_split( '/\s+/', $custom ) as $class ) {
			$class = sanitize_html_class( $class );
			if ( $class ) {
				$classes[] = $class;
			}
		}
	}

	return implode( ' ', array_unique( array_filter( $classes ) ) );
}

//───────────────────────────────────────
// Section anchor helper
//───────────────────────────────────────
function oum_section_anchor_attr( $section ) {
	$anchor = sanitize_title( oum_section_field( $section, 'section_anchor', '' ) );

	return $anchor ? ' id="' . esc_attr( $anchor ) . '"' : '';
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

//───────────────────────────────────────
// Section icon output
//───────────────────────────────────────
function oum_section_icon( $item, $class = 'tool-card__icon' ) {
	$icon_type = isset( $item['icon_type'] ) ? sanitize_key( $item['icon_type'] ) : '';
	$alt       = isset( $item['icon_alt'] ) ? $item['icon_alt'] : '';

	if ( 'none' === $icon_type ) {
		return;
	}

	if ( 'svg' === $icon_type && ! empty( $item['icon_svg'] ) ) {
		echo '<span class="' . esc_attr( $class . ' ' . $class . '--svg' ) . '" aria-hidden="' . esc_attr( $alt ? 'false' : 'true' ) . '">';
		echo function_exists( 'oum_sanitize_svg_code' ) ? oum_sanitize_svg_code( $item['icon_svg'] ) : wp_kses_post( $item['icon_svg'] );
		echo '</span>';
		return;
	}

	if ( ( '' === $icon_type || 'media' === $icon_type ) && ! empty( $item['icon_image_id'] ) ) {
		echo '<span class="' . esc_attr( $class . ' ' . $class . '--image' ) . '">';
		echo wp_kses_post( wp_get_attachment_image( absint( $item['icon_image_id'] ), 'thumbnail', false, array( 'alt' => esc_attr( $alt ) ) ) );
		echo '</span>';
		return;
	}

	if ( ( '' === $icon_type || 'url' === $icon_type ) && ! empty( $item['icon_url'] ) ) {
		echo '<span class="' . esc_attr( $class . ' ' . $class . '--image' ) . '"><img src="' . esc_url( $item['icon_url'] ) . '" alt="' . esc_attr( $alt ) . '"></span>';
		return;
	}

	if ( ( '' === $icon_type || 'text' === $icon_type ) && ( ! empty( $item['icon_text'] ) || ! empty( $item['icon'] ) ) ) {
		echo '<span class="' . esc_attr( $class ) . '" aria-hidden="true">' . esc_html( $item['icon_text'] ?? $item['icon'] ) . '</span>';
	}
}
