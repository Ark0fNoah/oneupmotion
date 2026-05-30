<?php
/**
 * Admin section builder for OneUp Sections.
 *
 * @package OneUpMotion
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

//───────────────────────────────────────
// Reusable builder field groups
//───────────────────────────────────────
function oum_section_icon_fields( $url_key = 'url', $include_button = true ) {
	$fields = array(
		'icon_type'     => array( 'label' => __( 'Icon source', 'oneup-motion' ), 'type' => 'select', 'choices' => array( 'none' => __( 'No icon', 'oneup-motion' ), 'text' => __( 'Text / character', 'oneup-motion' ), 'media' => __( 'Media library image', 'oneup-motion' ), 'url' => __( 'Icon URL', 'oneup-motion' ), 'svg' => __( 'SVG code', 'oneup-motion' ) ) ),
		'icon_text'     => array( 'label' => __( 'Icon text / character', 'oneup-motion' ), 'type' => 'text' ),
		'icon_image_id' => array( 'label' => __( 'Icon media', 'oneup-motion' ), 'type' => 'media' ),
		'icon_url'      => array( 'label' => __( 'Icon URL', 'oneup-motion' ), 'type' => 'url' ),
		'icon_svg'      => array( 'label' => __( 'Icon SVG code', 'oneup-motion' ), 'type' => 'svg' ),
		'icon_alt'      => array( 'label' => __( 'Icon alt text', 'oneup-motion' ), 'type' => 'text' ),
		'title'         => array( 'label' => __( 'Title', 'oneup-motion' ), 'type' => 'text' ),
		'text'          => array( 'label' => __( 'Text', 'oneup-motion' ), 'type' => 'textarea' ),
	);

	$fields[ $url_key ] = array( 'label' => __( 'URL', 'oneup-motion' ), 'type' => 'url' );

	if ( $include_button ) {
		$fields['button_label'] = array( 'label' => __( 'Button label', 'oneup-motion' ), 'type' => 'text' );
	}

	return $fields;
}

//───────────────────────────────────────
// Section field definitions
//───────────────────────────────────────
function oum_section_field_definitions() {
	$common = array(
		'section_anchor'  => array( 'label' => __( 'Section ID / anchor', 'oneup-motion' ), 'type' => 'text' ),
		'background_style'=> array( 'label' => __( 'Background style', 'oneup-motion' ), 'type' => 'select', 'choices' => array( 'default' => __( 'Default', 'oneup-motion' ), 'dark' => __( 'Dark', 'oneup-motion' ), 'soft' => __( 'Soft', 'oneup-motion' ), 'glass' => __( 'Glass', 'oneup-motion' ), 'highlighted' => __( 'Highlighted', 'oneup-motion' ), 'minimal' => __( 'Minimal', 'oneup-motion' ) ) ),
		'layout_width'    => array( 'label' => __( 'Layout width', 'oneup-motion' ), 'type' => 'select', 'default' => 'default', 'choices' => array( 'default' => __( 'Default homepage width', 'oneup-motion' ), 'wide' => __( 'Wide', 'oneup-motion' ), 'full' => __( 'Full', 'oneup-motion' ), 'narrow' => __( 'Narrow', 'oneup-motion' ) ) ),
		'section_spacing' => array( 'label' => __( 'Section spacing', 'oneup-motion' ), 'type' => 'select', 'default' => 'default', 'choices' => array( 'default' => __( 'Default', 'oneup-motion' ), 'compact' => __( 'Compact', 'oneup-motion' ), 'spacious' => __( 'Spacious', 'oneup-motion' ) ) ),
		'text_alignment'  => array( 'label' => __( 'Alignment', 'oneup-motion' ), 'type' => 'select', 'default' => 'left', 'choices' => array( 'left' => __( 'Left', 'oneup-motion' ), 'center' => __( 'Center', 'oneup-motion' ), 'right' => __( 'Right', 'oneup-motion' ) ) ),
		'custom_class'    => array( 'label' => __( 'Optional custom CSS class', 'oneup-motion' ), 'type' => 'text' ),
	);

	return array_map(
		static function( $fields ) use ( $common ) {
			return $fields + $common;
		},
		array(
		'hero'          => array(
			'eyebrow'                => array( 'label' => __( 'Eyebrow / label', 'oneup-motion' ), 'type' => 'text' ),
			'heading'                => array( 'label' => __( 'Heading', 'oneup-motion' ), 'type' => 'text' ),
			'highlighted_word'       => array( 'label' => __( 'Highlighted word', 'oneup-motion' ), 'type' => 'text' ),
			'text'                   => array( 'label' => __( 'Text', 'oneup-motion' ), 'type' => 'textarea' ),
			'primary_button_label'   => array( 'label' => __( 'Primary button label', 'oneup-motion' ), 'type' => 'text' ),
			'primary_button_url'     => array( 'label' => __( 'Primary button URL', 'oneup-motion' ), 'type' => 'url' ),
			'secondary_button_label' => array( 'label' => __( 'Secondary button label', 'oneup-motion' ), 'type' => 'text' ),
			'secondary_button_url'   => array( 'label' => __( 'Secondary button URL', 'oneup-motion' ), 'type' => 'url' ),
			'visual_style'           => array( 'label' => __( 'Visual style', 'oneup-motion' ), 'type' => 'select', 'choices' => array( 'geometric' => __( 'Geometric', 'oneup-motion' ), 'simple' => __( 'Simple', 'oneup-motion' ), 'none' => __( 'None', 'oneup-motion' ) ) ),
			'hero_visual_type'       => array( 'label' => __( 'Hero visual type', 'oneup-motion' ), 'type' => 'select', 'choices' => array( 'geometric' => __( 'CSS geometric visual', 'oneup-motion' ), 'image' => __( 'Uploaded image', 'oneup-motion' ), 'none' => __( 'None', 'oneup-motion' ) ) ),
			'hero_image_id'          => array( 'label' => __( 'Hero image upload', 'oneup-motion' ), 'type' => 'media' ),
			'hero_image_alt'         => array( 'label' => __( 'Hero image alt text', 'oneup-motion' ), 'type' => 'text' ),
			'hero_image_position'    => array( 'label' => __( 'Hero image position', 'oneup-motion' ), 'type' => 'select', 'choices' => array( 'right' => __( 'Right', 'oneup-motion' ), 'left' => __( 'Left', 'oneup-motion' ), 'background' => __( 'Background', 'oneup-motion' ) ) ),
			'hero_image_style'       => array( 'label' => __( 'Hero image style', 'oneup-motion' ), 'type' => 'select', 'choices' => array( 'normal' => __( 'Normal', 'oneup-motion' ), 'rounded' => __( 'Rounded', 'oneup-motion' ), 'glass-card' => __( 'Glass card', 'oneup-motion' ), 'floating' => __( 'Floating', 'oneup-motion' ), 'glow' => __( 'Glow', 'oneup-motion' ) ) ),
			'show_motion_lines'      => array( 'label' => __( 'Show motion lines', 'oneup-motion' ), 'type' => 'checkbox', 'default' => '1' ),
			'show_grid_background'   => array( 'label' => __( 'Show grid background', 'oneup-motion' ), 'type' => 'checkbox', 'default' => '1' ),
			'show_glow'              => array( 'label' => __( 'Show glow', 'oneup-motion' ), 'type' => 'checkbox', 'default' => '1' ),
		),
		'text'          => array(
			'eyebrow'   => array( 'label' => __( 'Eyebrow', 'oneup-motion' ), 'type' => 'text' ),
			'heading'   => array( 'label' => __( 'Heading', 'oneup-motion' ), 'type' => 'text' ),
			'highlighted_word' => array( 'label' => __( 'Highlighted word', 'oneup-motion' ), 'type' => 'text' ),
			'text'      => array( 'label' => __( 'Text', 'oneup-motion' ), 'type' => 'textarea' ),
			'button_label' => array( 'label' => __( 'Button label', 'oneup-motion' ), 'type' => 'text' ),
			'button_url' => array( 'label' => __( 'Button URL', 'oneup-motion' ), 'type' => 'url' ),
			'width' => array( 'label' => __( 'Width', 'oneup-motion' ), 'type' => 'select', 'choices' => array( 'narrow' => __( 'Narrow', 'oneup-motion' ), 'default' => __( 'Default', 'oneup-motion' ), 'wide' => __( 'Wide', 'oneup-motion' ) ) ),
			'alignment' => array( 'label' => __( 'Alignment', 'oneup-motion' ), 'type' => 'select', 'choices' => array( 'left' => __( 'Left', 'oneup-motion' ), 'center' => __( 'Center', 'oneup-motion' ), 'right' => __( 'Right', 'oneup-motion' ) ) ),
		),
		'text_image'    => array(
			'eyebrow'        => array( 'label' => __( 'Eyebrow', 'oneup-motion' ), 'type' => 'text' ),
			'heading'        => array( 'label' => __( 'Heading', 'oneup-motion' ), 'type' => 'text' ),
			'highlighted_word' => array( 'label' => __( 'Highlighted word', 'oneup-motion' ), 'type' => 'text' ),
			'text'           => array( 'label' => __( 'Text', 'oneup-motion' ), 'type' => 'textarea' ),
			'image_id'       => array( 'label' => __( 'Image upload', 'oneup-motion' ), 'type' => 'media' ),
			'image_alt'      => array( 'label' => __( 'Image alt text', 'oneup-motion' ), 'type' => 'text' ),
			'image_position' => array( 'label' => __( 'Image position', 'oneup-motion' ), 'type' => 'select', 'choices' => array( 'left' => __( 'Left', 'oneup-motion' ), 'right' => __( 'Right', 'oneup-motion' ) ) ),
			'image_style'    => array( 'label' => __( 'Image style', 'oneup-motion' ), 'type' => 'select', 'choices' => array( 'normal' => __( 'Normal', 'oneup-motion' ), 'rounded' => __( 'Rounded', 'oneup-motion' ), 'glass-card' => __( 'Glass card', 'oneup-motion' ), 'floating' => __( 'Floating', 'oneup-motion' ), 'glow' => __( 'Glow', 'oneup-motion' ) ) ),
			'button_label'   => array( 'label' => __( 'Button label', 'oneup-motion' ), 'type' => 'text' ),
			'button_url'     => array( 'label' => __( 'Button URL', 'oneup-motion' ), 'type' => 'url' ),
		),
		'cards'         => array(
			'eyebrow' => array( 'label' => __( 'Eyebrow', 'oneup-motion' ), 'type' => 'text' ),
			'heading' => array( 'label' => __( 'Heading', 'oneup-motion' ), 'type' => 'text' ),
			'text'    => array( 'label' => __( 'Text', 'oneup-motion' ), 'type' => 'textarea' ),
			'layout'  => array( 'label' => __( 'Layout', 'oneup-motion' ), 'type' => 'select', 'choices' => array( '2' => __( '2 columns', 'oneup-motion' ), '3' => __( '3 columns', 'oneup-motion' ), '4' => __( '4 columns', 'oneup-motion' ) ) ),
			'cards'   => array( 'label' => __( 'Cards', 'oneup-motion' ), 'type' => 'repeater', 'fields' => oum_section_icon_fields( 'button_url', true ) ),
		),
		'tools_preview' => array(
			'eyebrow'      => array( 'label' => __( 'Eyebrow', 'oneup-motion' ), 'type' => 'text' ),
			'heading'      => array( 'label' => __( 'Heading', 'oneup-motion' ), 'type' => 'text' ),
			'highlighted_word' => array( 'label' => __( 'Highlighted word', 'oneup-motion' ), 'type' => 'text' ),
			'text'         => array( 'label' => __( 'Text', 'oneup-motion' ), 'type' => 'textarea' ),
			'layout'       => array( 'label' => __( 'Layout', 'oneup-motion' ), 'type' => 'select', 'choices' => array( 'auto' => __( 'Auto', 'oneup-motion' ), '2' => __( '2 columns', 'oneup-motion' ), '3' => __( '3 columns', 'oneup-motion' ), '4' => __( '4 columns', 'oneup-motion' ) ) ),
			'card_style'   => array( 'label' => __( 'Card style', 'oneup-motion' ), 'type' => 'select', 'choices' => array( 'glass' => __( 'Glass', 'oneup-motion' ), 'outlined' => __( 'Outlined', 'oneup-motion' ), 'flat' => __( 'Flat', 'oneup-motion' ), 'glow' => __( 'Glow', 'oneup-motion' ) ) ),
			'highlight_first_card' => array( 'label' => __( 'Highlight first item', 'oneup-motion' ), 'type' => 'checkbox' ),
			'show_card_buttons' => array( 'label' => __( 'Show item buttons', 'oneup-motion' ), 'type' => 'checkbox', 'default' => '1' ),
			'show_badges' => array( 'label' => __( 'Show badges', 'oneup-motion' ), 'type' => 'checkbox', 'default' => '1' ),
			'items'        => array( 'label' => __( 'Tool/preview items', 'oneup-motion' ), 'type' => 'repeater', 'fields' => array_merge(
				oum_section_icon_fields( 'button_url', true ),
				array(
					'badge' => array( 'label' => __( 'Badge text', 'oneup-motion' ), 'type' => 'text' ),
					'status' => array( 'label' => __( 'Status', 'oneup-motion' ), 'type' => 'select', 'choices' => array( 'normal' => __( 'Normal', 'oneup-motion' ), 'available' => __( 'Available', 'oneup-motion' ), 'highlighted' => __( 'Highlighted', 'oneup-motion' ), 'coming-soon' => __( 'Coming soon', 'oneup-motion' ), 'disabled' => __( 'Disabled', 'oneup-motion' ) ) ),
					'new_tab' => array( 'label' => __( 'Open link in new tab', 'oneup-motion' ), 'type' => 'checkbox' ),
				)
			) ),
			'show_qr'      => array( 'label' => __( 'Legacy fallback: show QR Generator', 'oneup-motion' ), 'type' => 'checkbox' ),
			'show_utm'     => array( 'label' => __( 'Legacy fallback: show UTM Builder', 'oneup-motion' ), 'type' => 'checkbox' ),
			'show_image'   => array( 'label' => __( 'Legacy fallback: show Image Tools', 'oneup-motion' ), 'type' => 'checkbox' ),
			'button_label' => array( 'label' => __( 'Main button label', 'oneup-motion' ), 'type' => 'text' ),
			'button_url'   => array( 'label' => __( 'Main button URL', 'oneup-motion' ), 'type' => 'url' ),
		),
		'services'      => array(
			'eyebrow'  => array( 'label' => __( 'Eyebrow', 'oneup-motion' ), 'type' => 'text' ),
			'heading'  => array( 'label' => __( 'Heading', 'oneup-motion' ), 'type' => 'text' ),
			'text'     => array( 'label' => __( 'Text', 'oneup-motion' ), 'type' => 'textarea' ),
			'services' => array( 'label' => __( 'Service cards', 'oneup-motion' ), 'type' => 'repeater', 'fields' => oum_section_icon_fields( 'url', true ) ),
		),
		'cta'           => array(
			'heading'      => array( 'label' => __( 'Heading', 'oneup-motion' ), 'type' => 'text' ),
			'text'         => array( 'label' => __( 'Text', 'oneup-motion' ), 'type' => 'textarea' ),
			'button_label' => array( 'label' => __( 'Button label', 'oneup-motion' ), 'type' => 'text' ),
			'button_url'   => array( 'label' => __( 'Button URL', 'oneup-motion' ), 'type' => 'url' ),
			'secondary_button_label' => array( 'label' => __( 'Secondary button label', 'oneup-motion' ), 'type' => 'text' ),
			'secondary_button_url' => array( 'label' => __( 'Secondary button URL', 'oneup-motion' ), 'type' => 'url' ),
			'show_icon_mark' => array( 'label' => __( 'Show icon/mark', 'oneup-motion' ), 'type' => 'checkbox', 'default' => '1' ),
			'style'        => array( 'label' => __( 'Style', 'oneup-motion' ), 'type' => 'select', 'choices' => array( 'normal' => __( 'Normal', 'oneup-motion' ), 'highlighted' => __( 'Highlighted', 'oneup-motion' ), 'compact' => __( 'Compact', 'oneup-motion' ), 'full-width' => __( 'Full-width', 'oneup-motion' ) ) ),
		),
		'faq'           => array(
			'eyebrow' => array( 'label' => __( 'Eyebrow', 'oneup-motion' ), 'type' => 'text' ),
			'heading' => array( 'label' => __( 'Heading', 'oneup-motion' ), 'type' => 'text' ),
			'text' => array( 'label' => __( 'Description', 'oneup-motion' ), 'type' => 'textarea' ),
			'layout' => array( 'label' => __( 'Layout', 'oneup-motion' ), 'type' => 'select', 'choices' => array( 'single' => __( 'Single column', 'oneup-motion' ), 'two' => __( 'Two columns', 'oneup-motion' ) ) ),
			'faqs'    => array( 'label' => __( 'FAQ items', 'oneup-motion' ), 'type' => 'repeater', 'fields' => array(
				'question' => __( 'Question', 'oneup-motion' ),
				'answer'   => __( 'Answer', 'oneup-motion' ),
			) ),
		),
		'contact'       => array(
			'eyebrow'      => array( 'label' => __( 'Eyebrow', 'oneup-motion' ), 'type' => 'text' ),
			'heading'      => array( 'label' => __( 'Heading', 'oneup-motion' ), 'type' => 'text' ),
			'text'         => array( 'label' => __( 'Text', 'oneup-motion' ), 'type' => 'textarea' ),
			'email'        => array( 'label' => __( 'Email', 'oneup-motion' ), 'type' => 'text' ),
			'phone'        => array( 'label' => __( 'Phone', 'oneup-motion' ), 'type' => 'text' ),
			'button_label' => array( 'label' => __( 'Button label', 'oneup-motion' ), 'type' => 'text' ),
			'button_url'   => array( 'label' => __( 'Button URL', 'oneup-motion' ), 'type' => 'url' ),
			'form_shortcode' => array( 'label' => __( 'Optional contact form shortcode', 'oneup-motion' ), 'type' => 'textarea' ),
		),
		'qr_generator'  => array(
			'eyebrow'                => array( 'label' => __( 'Eyebrow / label', 'oneup-motion' ), 'type' => 'text' ),
			'heading'                => array( 'label' => __( 'Heading', 'oneup-motion' ), 'type' => 'text' ),
			'text'                   => array( 'label' => __( 'Text', 'oneup-motion' ), 'type' => 'textarea' ),
			'tool_intro_text'        => array( 'label' => __( 'Tool intro text', 'oneup-motion' ), 'type' => 'textarea' ),
			'show_surrounding_card'  => array( 'label' => __( 'Show surrounding card/panel', 'oneup-motion' ), 'type' => 'checkbox', 'default' => '1' ),
			'layout'                 => array( 'label' => __( 'Layout', 'oneup-motion' ), 'type' => 'select', 'choices' => array( 'centered' => __( 'Centered', 'oneup-motion' ), 'two-column' => __( 'Two-column', 'oneup-motion' ), 'full-width' => __( 'Full-width', 'oneup-motion' ) ) ),
			'background_style'       => array( 'label' => __( 'Background style', 'oneup-motion' ), 'type' => 'select', 'choices' => array( 'default' => __( 'Default', 'oneup-motion' ), 'glass' => __( 'Glass', 'oneup-motion' ), 'highlighted' => __( 'Highlighted', 'oneup-motion' ), 'minimal' => __( 'Minimal', 'oneup-motion' ) ) ),
		),
		'logo_strip'    => array(
			'eyebrow' => array( 'label' => __( 'Eyebrow / label', 'oneup-motion' ), 'type' => 'text' ),
			'text'    => array( 'label' => __( 'Text', 'oneup-motion' ), 'type' => 'textarea' ),
			'style'   => array( 'label' => __( 'Style', 'oneup-motion' ), 'type' => 'select', 'choices' => array( 'text' => __( 'Text only', 'oneup-motion' ), 'logos' => __( 'Logo images', 'oneup-motion' ), 'mixed' => __( 'Mixed', 'oneup-motion' ) ) ),
			'items'   => array( 'label' => __( 'Logos/items', 'oneup-motion' ), 'type' => 'repeater', 'fields' => array( 'name' => array( 'label' => __( 'Name', 'oneup-motion' ), 'type' => 'text' ), 'logo_image_id' => array( 'label' => __( 'Logo image', 'oneup-motion' ), 'type' => 'media' ), 'url' => array( 'label' => __( 'URL', 'oneup-motion' ), 'type' => 'url' ) ) ),
		),
		'preview_boxes' => array(
			'eyebrow' => array( 'label' => __( 'Eyebrow / label', 'oneup-motion' ), 'type' => 'text' ),
			'heading' => array( 'label' => __( 'Heading', 'oneup-motion' ), 'type' => 'text' ),
			'highlighted_word' => array( 'label' => __( 'Highlighted word', 'oneup-motion' ), 'type' => 'text' ),
			'text' => array( 'label' => __( 'Description / text', 'oneup-motion' ), 'type' => 'textarea' ),
			'button_label' => array( 'label' => __( 'Main button label', 'oneup-motion' ), 'type' => 'text' ),
			'button_url' => array( 'label' => __( 'Main button URL', 'oneup-motion' ), 'type' => 'url' ),
			'layout' => array( 'label' => __( 'Layout', 'oneup-motion' ), 'type' => 'select', 'choices' => array( 'auto' => __( 'Auto', 'oneup-motion' ), '2' => __( '2 columns', 'oneup-motion' ), '3' => __( '3 columns', 'oneup-motion' ), '4' => __( '4 columns', 'oneup-motion' ) ) ),
			'card_style' => array( 'label' => __( 'Card style', 'oneup-motion' ), 'type' => 'select', 'choices' => array( 'glass' => __( 'Glass', 'oneup-motion' ), 'outlined' => __( 'Outlined', 'oneup-motion' ), 'flat' => __( 'Flat', 'oneup-motion' ), 'glow' => __( 'Glow', 'oneup-motion' ) ) ),
			'highlight_first_card' => array( 'label' => __( 'Highlight first card', 'oneup-motion' ), 'type' => 'checkbox' ),
			'show_card_buttons' => array( 'label' => __( 'Show card buttons', 'oneup-motion' ), 'type' => 'checkbox', 'default' => '1' ),
			'show_badges' => array( 'label' => __( 'Show badges', 'oneup-motion' ), 'type' => 'checkbox', 'default' => '1' ),
			'boxes' => array( 'label' => __( 'Boxes', 'oneup-motion' ), 'type' => 'repeater', 'fields' => array_merge(
				array(
					'icon_type'     => array( 'label' => __( 'Icon source', 'oneup-motion' ), 'type' => 'select', 'choices' => array( 'none' => __( 'No icon', 'oneup-motion' ), 'text' => __( 'Text / character', 'oneup-motion' ), 'media' => __( 'Media library image', 'oneup-motion' ), 'url' => __( 'Icon URL', 'oneup-motion' ), 'svg' => __( 'SVG code', 'oneup-motion' ) ) ),
					'icon_text'     => array( 'label' => __( 'Icon text / character', 'oneup-motion' ), 'type' => 'text' ),
					'icon_image_id' => array( 'label' => __( 'Icon media', 'oneup-motion' ), 'type' => 'media' ),
					'icon_url'      => array( 'label' => __( 'Icon URL', 'oneup-motion' ), 'type' => 'url' ),
					'icon_svg'      => array( 'label' => __( 'Icon SVG code', 'oneup-motion' ), 'type' => 'svg' ),
					'icon_alt'      => array( 'label' => __( 'Icon alt text', 'oneup-motion' ), 'type' => 'text' ),
					'badge'         => array( 'label' => __( 'Badge text', 'oneup-motion' ), 'type' => 'text' ),
					'title'         => array( 'label' => __( 'Title', 'oneup-motion' ), 'type' => 'text' ),
					'text'          => array( 'label' => __( 'Description', 'oneup-motion' ), 'type' => 'textarea' ),
					'button_label'  => array( 'label' => __( 'Button label', 'oneup-motion' ), 'type' => 'text' ),
					'button_url'    => array( 'label' => __( 'Button URL', 'oneup-motion' ), 'type' => 'url' ),
					'status'        => array( 'label' => __( 'Status', 'oneup-motion' ), 'type' => 'select', 'choices' => array( 'normal' => __( 'Normal', 'oneup-motion' ), 'highlighted' => __( 'Highlighted', 'oneup-motion' ), 'coming-soon' => __( 'Coming soon', 'oneup-motion' ), 'disabled' => __( 'Disabled', 'oneup-motion' ) ) ),
					'new_tab'       => array( 'label' => __( 'Open link in new tab', 'oneup-motion' ), 'type' => 'checkbox' ),
				)
			) ),
		),
		'feature_grid' => array(
			'eyebrow' => array( 'label' => __( 'Eyebrow', 'oneup-motion' ), 'type' => 'text' ),
			'heading' => array( 'label' => __( 'Heading', 'oneup-motion' ), 'type' => 'text' ),
			'highlighted_word' => array( 'label' => __( 'Highlighted word', 'oneup-motion' ), 'type' => 'text' ),
			'text' => array( 'label' => __( 'Description', 'oneup-motion' ), 'type' => 'textarea' ),
			'columns' => array( 'label' => __( 'Layout columns', 'oneup-motion' ), 'type' => 'select', 'choices' => array( '2' => __( '2 columns', 'oneup-motion' ), '3' => __( '3 columns', 'oneup-motion' ), '4' => __( '4 columns', 'oneup-motion' ) ) ),
			'card_style' => array( 'label' => __( 'Card style', 'oneup-motion' ), 'type' => 'select', 'choices' => array( 'glass' => __( 'Glass', 'oneup-motion' ), 'outlined' => __( 'Outlined', 'oneup-motion' ), 'flat' => __( 'Flat', 'oneup-motion' ), 'glow' => __( 'Glow', 'oneup-motion' ) ) ),
			'items' => array( 'label' => __( 'Items', 'oneup-motion' ), 'type' => 'repeater', 'fields' => oum_section_icon_fields( 'url', true ) ),
		),
		'story' => array(
			'eyebrow' => array( 'label' => __( 'Eyebrow', 'oneup-motion' ), 'type' => 'text' ),
			'heading' => array( 'label' => __( 'Heading', 'oneup-motion' ), 'type' => 'text' ),
			'highlighted_word' => array( 'label' => __( 'Highlighted word', 'oneup-motion' ), 'type' => 'text' ),
			'text' => array( 'label' => __( 'Text', 'oneup-motion' ), 'type' => 'textarea' ),
			'visual_type' => array( 'label' => __( 'Image/visual type', 'oneup-motion' ), 'type' => 'select', 'choices' => array( 'css' => __( 'CSS abstract visual', 'oneup-motion' ), 'image' => __( 'Uploaded image', 'oneup-motion' ), 'none' => __( 'None', 'oneup-motion' ) ) ),
			'image_id' => array( 'label' => __( 'Image upload', 'oneup-motion' ), 'type' => 'media' ),
			'image_alt' => array( 'label' => __( 'Image alt text', 'oneup-motion' ), 'type' => 'text' ),
			'quote' => array( 'label' => __( 'Quote/handwritten line', 'oneup-motion' ), 'type' => 'text' ),
			'visual_position' => array( 'label' => __( 'Image/visual position', 'oneup-motion' ), 'type' => 'select', 'choices' => array( 'left' => __( 'Left', 'oneup-motion' ), 'right' => __( 'Right', 'oneup-motion' ) ) ),
			'points' => array( 'label' => __( 'Value points', 'oneup-motion' ), 'type' => 'repeater', 'fields' => oum_section_icon_fields( 'url', false ) ),
		),
		'shortcode' => array(
			'eyebrow' => array( 'label' => __( 'Eyebrow', 'oneup-motion' ), 'type' => 'text' ),
			'heading' => array( 'label' => __( 'Heading', 'oneup-motion' ), 'type' => 'text' ),
			'text' => array( 'label' => __( 'Text', 'oneup-motion' ), 'type' => 'textarea' ),
			'shortcode' => array( 'label' => __( 'Shortcode', 'oneup-motion' ), 'type' => 'textarea' ),
			'show_surrounding_card' => array( 'label' => __( 'Show surrounding card/panel', 'oneup-motion' ), 'type' => 'checkbox', 'default' => '1' ),
		),
		'custom_code' => array(
			'eyebrow' => array( 'label' => __( 'Eyebrow', 'oneup-motion' ), 'type' => 'text' ),
			'heading' => array( 'label' => __( 'Heading', 'oneup-motion' ), 'type' => 'text' ),
			'text' => array( 'label' => __( 'Text', 'oneup-motion' ), 'type' => 'textarea' ),
			'html_code' => array( 'label' => __( 'Custom HTML', 'oneup-motion' ), 'type' => 'code_html' ),
			'js_code' => array( 'label' => __( 'Custom JavaScript', 'oneup-motion' ), 'type' => 'code_js' ),
			'show_surrounding_card' => array( 'label' => __( 'Show surrounding card/panel', 'oneup-motion' ), 'type' => 'checkbox', 'default' => '1' ),
		),
		)
	);
}

//───────────────────────────────────────
// Use OneUp Sections editor
//───────────────────────────────────────
function oum_uses_sections_editor_for_type( $post_type ) {
	if ( 'page' === $post_type ) {
		return '1' === oum_get_theme_option( 'use_sections_for_pages', '1' );
	}

	if ( 'post' === $post_type ) {
		return '1' === oum_get_theme_option( 'enable_post_sections', '0' ) && '1' === oum_get_theme_option( 'replace_post_editor_with_sections', '0' );
	}

	return false;
}

//───────────────────────────────────────
// Disable block editor when sections replace content
//───────────────────────────────────────
function oum_filter_block_editor_for_sections( $use_block_editor, $post_type ) {
	return oum_uses_sections_editor_for_type( $post_type ) ? false : $use_block_editor;
}
add_filter( 'use_block_editor_for_post_type', 'oum_filter_block_editor_for_sections', 10, 2 );

//───────────────────────────────────────
// Hide default content editor
//───────────────────────────────────────
function oum_maybe_remove_default_editor_support() {
	if ( '1' === oum_get_theme_option( 'use_sections_for_pages', '1' ) && '1' === oum_get_theme_option( 'hide_page_content_editor', '1' ) ) {
		remove_post_type_support( 'page', 'editor' );
	}

	if ( oum_uses_sections_editor_for_type( 'post' ) ) {
		remove_post_type_support( 'post', 'editor' );
	}
}
add_action( 'init', 'oum_maybe_remove_default_editor_support', 20 );
add_action( 'admin_init', 'oum_maybe_remove_default_editor_support', 20 );

//───────────────────────────────────────
// Editor notice
//───────────────────────────────────────
function oum_sections_editor_admin_notice() {
	$screen = get_current_screen();

	if ( ! $screen || 'page' !== $screen->post_type || ! oum_uses_sections_editor_for_type( 'page' ) ) {
		return;
	}

	echo '<div class="notice notice-info oum-sections-mode-notice"><p>' . esc_html__( 'OneUp Sections is active for pages. The normal block editor is disabled so this page can be managed with predefined sections.', 'oneup-motion' ) . '</p></div>';
}
add_action( 'admin_notices', 'oum_sections_editor_admin_notice' );

//───────────────────────────────────────
// Register meta boxes
//───────────────────────────────────────
function oum_register_section_metaboxes() {
	if ( '1' === oum_get_theme_option( 'use_sections_for_pages', '1' ) ) {
		add_meta_box( 'oum_page_sections', __( 'OneUp Page Sections', 'oneup-motion' ), 'oum_render_sections_metabox', 'page', 'normal', 'high' );
	}

	if ( '1' === oum_get_theme_option( 'enable_post_sections', '0' ) ) {
		add_meta_box( 'oum_page_sections', __( 'OneUp Post Sections', 'oneup-motion' ), 'oum_render_sections_metabox', 'post', 'normal', 'high' );
	}
}
add_action( 'add_meta_boxes', 'oum_register_section_metaboxes' );

//───────────────────────────────────────
// Link picker options
//───────────────────────────────────────
function oum_section_link_picker_options() {
	$options = array();

	foreach ( get_pages( array( 'sort_column' => 'post_title', 'number' => 80 ) ) as $page ) {
		$options[] = array(
			'label' => sprintf( __( 'Page: %s', 'oneup-motion' ), get_the_title( $page ) ),
			'url'   => get_permalink( $page ),
		);
	}

	foreach ( get_posts( array( 'post_type' => 'post', 'posts_per_page' => 80, 'post_status' => 'publish' ) ) as $post ) {
		$options[] = array(
			'label' => sprintf( __( 'Post: %s', 'oneup-motion' ), get_the_title( $post ) ),
			'url'   => get_permalink( $post ),
		);
	}

	foreach ( get_categories( array( 'hide_empty' => false, 'number' => 80 ) ) as $category ) {
		$options[] = array(
			'label' => sprintf( __( 'Category: %s', 'oneup-motion' ), $category->name ),
			'url'   => get_category_link( $category ),
		);
	}

	return $options;
}

//───────────────────────────────────────
// Admin assets
//───────────────────────────────────────
function oum_enqueue_section_builder_assets( $hook ) {
	if ( ! in_array( $hook, array( 'post.php', 'post-new.php' ), true ) ) {
		return;
	}

	wp_enqueue_media();
	wp_enqueue_style( 'oum-admin', get_template_directory_uri() . '/assets/css/admin.css', array(), oum_asset_version( 'assets/css/admin.css' ) );
	wp_enqueue_script( 'oum-admin-sections', get_template_directory_uri() . '/assets/js/admin-sections.js', array(), oum_asset_version( 'assets/js/admin-sections.js' ), true );
	wp_localize_script( 'oum-admin-sections', 'oumSectionBuilder', array(
		'types'  => oum_section_types(),
		'fields' => oum_section_field_definitions(),
		'links'  => oum_section_link_picker_options(),
		'i18n'   => array(
			'newSection' => __( 'New Section', 'oneup-motion' ),
			'addItem'    => __( 'Add item', 'oneup-motion' ),
			'remove'     => __( 'Remove', 'oneup-motion' ),
			'chooseImage'=> __( 'Choose image', 'oneup-motion' ),
			'chooseLink' => __( 'Choose link', 'oneup-motion' ),
			'selectLink' => __( 'Select a page, post or category', 'oneup-motion' ),
			'empty'      => __( 'No sections yet. Add your first section to start building this page.', 'oneup-motion' ),
		),
	) );
}
add_action( 'admin_enqueue_scripts', 'oum_enqueue_section_builder_assets' );

//───────────────────────────────────────
// Render meta box
//───────────────────────────────────────
function oum_render_sections_metabox( $post ) {
	wp_nonce_field( 'oum_save_sections', 'oum_sections_nonce' );
	$sections = oum_get_sections( $post->ID );
	?>
	<div class="oum-sections-builder" data-oum-sections-builder>
		<div class="oum-sections-builder__intro">
			<h2><?php echo esc_html__( 'Build with OneUp Sections', 'oneup-motion' ); ?></h2>
			<p><?php echo esc_html__( 'Build this page by adding, reordering and editing predefined sections.', 'oneup-motion' ); ?></p>
		</div>
		<div class="oum-sections-toolbar">
			<select data-oum-section-type>
				<?php foreach ( oum_section_types() as $type => $label ) : ?>
					<option value="<?php echo esc_attr( $type ); ?>"><?php echo esc_html( $label ); ?></option>
				<?php endforeach; ?>
			</select>
			<button type="button" class="button button-primary button-hero" data-oum-add-section><?php echo esc_html__( 'Add Section', 'oneup-motion' ); ?></button>
		</div>
		<p class="oum-sections-empty" data-oum-empty-state <?php echo empty( $sections ) ? '' : 'hidden'; ?>><?php echo esc_html__( 'No sections yet. Add your first section to start building this page.', 'oneup-motion' ); ?></p>
		<div class="oum-sections-list" data-oum-sections-list>
			<?php foreach ( $sections as $index => $section ) : ?>
				<?php oum_render_admin_section_panel( $index, $section ); ?>
			<?php endforeach; ?>
		</div>
	</div>
	<?php
}

//───────────────────────────────────────
// Render admin section
//───────────────────────────────────────
function oum_render_admin_section_panel( $index, $section ) {
	$type   = $section['type'] ?? 'text';
	$fields = oum_section_field_definitions()[ $type ] ?? array();
	$title  = oum_section_types()[ $type ] ?? __( 'Section', 'oneup-motion' );
	$id     = $section['id'] ?? uniqid( 'oum_', true );
	$summary = '';

	foreach ( array( 'heading', 'title', 'eyebrow' ) as $summary_key ) {
		if ( ! empty( $section[ $summary_key ] ) ) {
			$summary = wp_trim_words( wp_strip_all_tags( $section[ $summary_key ] ), 12 );
			break;
		}
	}
	?>
	<div class="oum-section-panel" data-oum-section>
		<div class="oum-section-panel__header">
			<div class="oum-section-panel__title">
				<strong><?php echo esc_html( $title ); ?></strong>
				<span data-oum-section-summary><?php echo $summary ? esc_html( $summary ) : esc_html__( 'No heading yet', 'oneup-motion' ); ?></span>
			</div>
			<div class="oum-section-panel__controls">
				<button type="button" class="button" data-oum-move-up><?php echo esc_html__( 'Move Up', 'oneup-motion' ); ?></button>
				<button type="button" class="button" data-oum-move-down><?php echo esc_html__( 'Move Down', 'oneup-motion' ); ?></button>
				<button type="button" class="button" data-oum-toggle><?php echo esc_html__( 'Collapse', 'oneup-motion' ); ?></button>
				<button type="button" class="button" data-oum-duplicate><?php echo esc_html__( 'Duplicate', 'oneup-motion' ); ?></button>
				<button type="button" class="button-link-delete" data-oum-remove><?php echo esc_html__( 'Remove', 'oneup-motion' ); ?></button>
			</div>
		</div>
		<div class="oum-section-panel__body">
			<input type="hidden" name="oum_sections[<?php echo esc_attr( $index ); ?>][type]" value="<?php echo esc_attr( $type ); ?>">
			<input type="hidden" name="oum_sections[<?php echo esc_attr( $index ); ?>][id]" value="<?php echo esc_attr( $id ); ?>">
			<div class="oum-section-fields-grid" data-oum-fields-grid>
				<?php foreach ( $fields as $key => $field ) : ?>
					<?php if ( in_array( $key, array( 'section_anchor', 'background_style', 'layout_width', 'section_spacing', 'text_alignment', 'custom_class' ), true ) ) : ?>
						<?php continue; ?>
					<?php endif; ?>
					<?php oum_render_admin_section_field( $index, $key, $field, $section[ $key ] ?? '' ); ?>
				<?php endforeach; ?>
			</div>
			<div class="oum-section-advanced-toggle-wrap">
				<button type="button" class="button button-secondary oum-section-advanced-toggle" data-oum-advanced-toggle aria-expanded="false"><?php echo esc_html__( 'Advanced options', 'oneup-motion' ); ?></button>
			</div>
			<div class="oum-section-advanced" data-oum-advanced hidden>
				<div class="oum-section-fields-grid oum-section-fields-grid--advanced">
					<?php foreach ( $fields as $key => $field ) : ?>
						<?php if ( ! in_array( $key, array( 'section_anchor', 'background_style', 'layout_width', 'section_spacing', 'text_alignment', 'custom_class' ), true ) ) : ?>
							<?php continue; ?>
						<?php endif; ?>
						<?php oum_render_admin_section_field( $index, $key, $field, $section[ $key ] ?? '' ); ?>
					<?php endforeach; ?>
				</div>
			</div>
		</div>
	</div>
	<?php
}

//───────────────────────────────────────
// Render admin field
//───────────────────────────────────────
function oum_render_admin_section_field( $index, $key, $field, $value ) {
	$name        = 'oum_sections[' . esc_attr( $index ) . '][' . esc_attr( $key ) . ']';
	$type        = $field['type'] ?? 'text';
	$is_advanced = in_array( $key, array( 'section_anchor', 'background_style', 'layout_width', 'section_spacing', 'text_alignment', 'custom_class' ), true );
	?>
	<div class="oum-section-field oum-section-field--<?php echo esc_attr( $type ); ?><?php echo $is_advanced ? ' oum-section-field--advanced' : ''; ?>" data-oum-field-key="<?php echo esc_attr( $key ); ?>" data-oum-field-type="<?php echo esc_attr( $type ); ?>">
		<label>
			<span><?php echo esc_html( $field['label'] ?? $key ); ?></span>
			<?php if ( in_array( $type, array( 'textarea', 'code_html', 'code_js' ), true ) ) : ?>
				<textarea name="<?php echo esc_attr( $name ); ?>" rows="4"><?php echo esc_textarea( $value ); ?></textarea>
			<?php elseif ( 'select' === $type ) : ?>
				<?php $selected_value = '' === $value && isset( $field['default'] ) ? $field['default'] : $value; ?>
				<select name="<?php echo esc_attr( $name ); ?>">
					<?php foreach ( $field['choices'] ?? array() as $choice_value => $choice_label ) : ?>
						<option value="<?php echo esc_attr( $choice_value ); ?>" <?php selected( $selected_value, $choice_value ); ?>><?php echo esc_html( $choice_label ); ?></option>
					<?php endforeach; ?>
				</select>
			<?php elseif ( 'checkbox' === $type ) : ?>
				<?php $checked_value = '' === $value && isset( $field['default'] ) ? $field['default'] : $value; ?>
				<input type="checkbox" name="<?php echo esc_attr( $name ); ?>" value="1" <?php checked( $checked_value, '1' ); ?>>
			<?php elseif ( 'media' === $type ) : ?>
				<input type="hidden" name="<?php echo esc_attr( $name ); ?>" value="<?php echo esc_attr( absint( $value ) ); ?>" data-oum-media-input>
				<button type="button" class="button" data-oum-media-button><?php echo esc_html__( 'Choose image', 'oneup-motion' ); ?></button>
				<button type="button" class="button-link" data-oum-media-clear><?php echo esc_html__( 'Remove', 'oneup-motion' ); ?></button>
				<span class="oum-media-preview" data-oum-media-preview><?php echo $value ? wp_get_attachment_image( absint( $value ), 'thumbnail' ) : ''; ?></span>
			<?php elseif ( 'repeater' === $type ) : ?>
				<?php oum_render_admin_repeater( $index, $key, $field, is_array( $value ) ? $value : array() ); ?>
			<?php else : ?>
				<input type="<?php echo esc_attr( 'url' === $type ? 'url' : 'text' ); ?>" name="<?php echo esc_attr( $name ); ?>" value="<?php echo esc_attr( $value ); ?>">
			<?php endif; ?>
		</label>
	</div>
	<?php
}

//───────────────────────────────────────
// Render admin repeater
//───────────────────────────────────────
function oum_render_admin_repeater( $section_index, $key, $field, $items ) {
	?>
	<div class="oum-repeater" data-oum-repeater="<?php echo esc_attr( $key ); ?>" data-oum-repeater-fields="<?php echo esc_attr( rawurlencode( wp_json_encode( $field['fields'] ?? array() ) ) ); ?>">
		<div class="oum-repeater__items" data-oum-repeater-items>
			<?php foreach ( $items as $item_index => $item ) : ?>
				<div class="oum-repeater__item" data-oum-repeater-item>
					<div class="oum-repeater__controls">
						<button type="button" class="button" data-oum-repeater-up><?php echo esc_html__( 'Up', 'oneup-motion' ); ?></button>
						<button type="button" class="button" data-oum-repeater-down><?php echo esc_html__( 'Down', 'oneup-motion' ); ?></button>
						<button type="button" class="button-link-delete" data-oum-repeater-remove><?php echo esc_html__( 'Remove item', 'oneup-motion' ); ?></button>
					</div>
					<?php foreach ( $field['fields'] as $item_key => $item_field ) : ?>
						<?php oum_render_admin_repeater_field( $section_index, $key, $item_index, $item_key, $item_field, $item[ $item_key ] ?? '' ); ?>
					<?php endforeach; ?>
				</div>
			<?php endforeach; ?>
		</div>
		<button type="button" class="button" data-oum-repeater-add><?php echo esc_html__( 'Add item', 'oneup-motion' ); ?></button>
	</div>
	<?php
}

//───────────────────────────────────────
// Normalize repeater field
//───────────────────────────────────────
function oum_normalize_repeater_field( $field, $key = '' ) {
	if ( is_array( $field ) ) {
		$field = wp_parse_args( $field, array( 'type' => 'text', 'label' => '' ) );

		if ( 'text' === $field['type'] && false !== strpos( (string) $key, 'url' ) ) {
			$field['type'] = 'url';
		}

		return $field;
	}

	return array(
		'label' => (string) $field,
		'type'  => false !== strpos( (string) $key, 'url' ) ? 'url' : 'textarea',
	);
}

//───────────────────────────────────────
// Render admin repeater field
//───────────────────────────────────────
function oum_render_admin_repeater_field( $section_index, $repeater_key, $item_index, $item_key, $field, $value ) {
	$field = oum_normalize_repeater_field( $field, $item_key );
	$type  = $field['type'] ?? 'text';
	$name  = 'oum_sections[' . esc_attr( $section_index ) . '][' . esc_attr( $repeater_key ) . '][' . esc_attr( $item_index ) . '][' . esc_attr( $item_key ) . ']';
	?>
	<label class="oum-repeater-field oum-repeater-field--<?php echo esc_attr( $type ); ?>">
		<span><?php echo esc_html( $field['label'] ?: $item_key ); ?></span>
		<?php if ( in_array( $type, array( 'textarea', 'code_html', 'code_js' ), true ) ) : ?>
			<textarea name="<?php echo esc_attr( $name ); ?>" rows="2"><?php echo esc_textarea( $value ); ?></textarea>
		<?php elseif ( 'select' === $type ) : ?>
			<?php $selected_value = '' === $value && isset( $field['default'] ) ? $field['default'] : $value; ?>
			<select name="<?php echo esc_attr( $name ); ?>">
				<?php foreach ( $field['choices'] ?? array() as $choice_value => $choice_label ) : ?>
					<option value="<?php echo esc_attr( $choice_value ); ?>" <?php selected( $selected_value, $choice_value ); ?>><?php echo esc_html( $choice_label ); ?></option>
				<?php endforeach; ?>
			</select>
		<?php elseif ( 'checkbox' === $type ) : ?>
			<input type="checkbox" name="<?php echo esc_attr( $name ); ?>" value="1" <?php checked( $value, '1' ); ?>>
		<?php elseif ( 'media' === $type ) : ?>
			<input type="hidden" name="<?php echo esc_attr( $name ); ?>" value="<?php echo esc_attr( absint( $value ) ); ?>" data-oum-media-input>
			<button type="button" class="button" data-oum-media-button><?php echo esc_html__( 'Choose image', 'oneup-motion' ); ?></button>
			<button type="button" class="button-link" data-oum-media-clear><?php echo esc_html__( 'Remove', 'oneup-motion' ); ?></button>
			<span class="oum-media-preview" data-oum-media-preview><?php echo $value ? wp_kses_post( wp_get_attachment_image( absint( $value ), 'thumbnail' ) ) : ''; ?></span>
		<?php else : ?>
			<input type="<?php echo esc_attr( 'url' === $type ? 'url' : 'text' ); ?>" name="<?php echo esc_attr( $name ); ?>" value="<?php echo esc_attr( $value ); ?>">
		<?php endif; ?>
	</label>
	<?php
}

//───────────────────────────────────────
// Save sections
//───────────────────────────────────────
function oum_save_sections( $post_id ) {
	if ( ! isset( $_POST['oum_sections_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['oum_sections_nonce'] ) ), 'oum_save_sections' ) ) {
		return;
	}

	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}

	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}

	$post_type = get_post_type( $post_id );
	if ( 'post' === $post_type && '1' !== oum_get_theme_option( 'enable_post_sections', '0' ) ) {
		return;
	}

	if ( ! isset( $_POST['oum_sections'] ) || ! is_array( $_POST['oum_sections'] ) ) {
		delete_post_meta( $post_id, '_oum_sections' );
		return;
	}

	$raw      = wp_unslash( $_POST['oum_sections'] );
	$sections = oum_sanitize_sections( $raw );

	if ( empty( $sections ) ) {
		delete_post_meta( $post_id, '_oum_sections' );
		return;
	}

	update_post_meta( $post_id, '_oum_sections', $sections );
}
add_action( 'save_post', 'oum_save_sections' );

//───────────────────────────────────────
// Sanitize sections
//───────────────────────────────────────
function oum_sanitize_sections( $raw_sections ) {
	$definitions = oum_section_field_definitions();
	$sections    = array();

	foreach ( $raw_sections as $raw_section ) {
		if ( ! is_array( $raw_section ) ) {
			continue;
		}

		$type = isset( $raw_section['type'] ) ? sanitize_key( $raw_section['type'] ) : '';
		if ( ! isset( $definitions[ $type ] ) ) {
			continue;
		}

		$section = array(
			'type' => $type,
			'id'   => isset( $raw_section['id'] ) ? sanitize_key( $raw_section['id'] ) : uniqid( 'oum_', true ),
		);

		foreach ( $definitions[ $type ] as $key => $field ) {
			$value           = $raw_section[ $key ] ?? '';
			$section[ $key ] = oum_sanitize_section_field( $value, $field );
		}

		$sections[] = $section;
	}

	return $sections;
}

//───────────────────────────────────────
// Sanitize section field
//───────────────────────────────────────
function oum_sanitize_section_field( $value, $field ) {
	$type = $field['type'] ?? 'text';

	if ( 'textarea' === $type ) {
		return wp_kses_post( $value );
	}

	if ( 'svg' === $type ) {
		return function_exists( 'oum_sanitize_svg_code' ) ? oum_sanitize_svg_code( $value ) : wp_kses_post( $value );
	}

	if ( 'code_html' === $type ) {
		return current_user_can( 'unfiltered_html' ) ? (string) $value : wp_kses_post( $value );
	}

	if ( 'code_js' === $type ) {
		return current_user_can( 'unfiltered_html' ) ? (string) $value : '';
	}

	if ( 'url' === $type ) {
		return esc_url_raw( $value );
	}

	if ( 'media' === $type ) {
		return absint( $value );
	}

	if ( 'checkbox' === $type ) {
		return ! empty( $value ) ? '1' : '0';
	}

	if ( 'select' === $type ) {
		$value   = sanitize_key( $value );
		$choices = $field['choices'] ?? array( '' => '' );
		$keys    = array_keys( $choices );
		return array_key_exists( $value, $choices ) ? $value : ( $keys[0] ?? '' );
	}

	if ( 'repeater' === $type ) {
		return oum_sanitize_section_repeater( $value, $field['fields'] ?? array() );
	}

	return sanitize_text_field( $value );
}

//───────────────────────────────────────
// Sanitize repeater
//───────────────────────────────────────
function oum_sanitize_section_repeater( $items, $fields ) {
	if ( ! is_array( $items ) ) {
		return array();
	}

	$clean = array();
	foreach ( $items as $item ) {
		if ( ! is_array( $item ) ) {
			continue;
		}

		$clean_item = array();
		foreach ( $fields as $key => $field ) {
			$field              = oum_normalize_repeater_field( $field );
			$value              = $item[ $key ] ?? '';
			$clean_item[ $key ] = oum_sanitize_section_field( $value, $field );
		}
		$clean[] = $clean_item;
	}

	return $clean;
}
