<?php
/**
 * Theme options for OneUp Motion.
 *
 * @package OneUpMotion
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

//───────────────────────────────────────
// Option defaults
//───────────────────────────────────────
function oum_theme_option_defaults() {
	return array(
		'main_logo_id'           => 0,
		'alt_logo_id'            => 0,
		'footer_logo_id'         => 0,
		'brand_name'             => 'OneUp Motion',
		'footer_brand_text'      => 'OneUp Motion',
		'bg'                     => '#03101f',
		'bg_soft'                => '#071a2e',
		'navy'                   => '#001f3d',
		'card'                   => 'rgba(255, 255, 255, 0.055)',
		'card_border'            => 'rgba(255, 255, 255, 0.12)',
		'text'                   => '#ffffff',
		'muted'                  => 'rgba(255, 255, 255, 0.72)',
		'soft_muted'             => 'rgba(255, 255, 255, 0.52)',
		'mint'                   => '#20f0c0',
		'mint_dark'              => '#08caa0',
		'button_bg'              => '#20f0c0',
		'button_text'            => '#02131f',
		'header_bg'              => 'rgba(3, 16, 31, 0.74)',
		'footer_bg'              => '#020a14',
		'heading_font'           => 'rounded',
		'body_font'              => 'rounded',
		'button_font'            => 'rounded',
		'heading_weight'         => '900',
		'body_weight'            => '400',
		'button_weight'          => '900',
		'heading_spacing'        => '0',
		'body_spacing'           => '0',
		'button_spacing'         => '0',
		'base_font_size'         => '16',
		'heading_style'          => 'rounded',
		'button_transform'       => 'none',
		'button_font_size'       => '16',
		'button_radius'          => '999',
		'button_padding'         => 'medium',
		'button_style'           => 'filled',
		'button_shadow'          => '1',
		'button_hover_lift'      => '1',
		'button_arrow'           => '0',
		'container_width'        => 'default',
		'section_spacing'        => 'default',
		'card_radius'            => 'rounded',
		'card_style'             => 'glass',
		'sticky_header'          => '1',
		'transparent_header'     => '1',
		'show_header_cta'        => '1',
		'header_cta_label'       => 'Start Creating',
		'header_cta_url'         => '#contact',
		'footer_description'     => 'Digital tools. Modern design. Real results.',
		'footer_email'           => 'hello@oneupmotion.com',
		'footer_instagram'       => '',
		'footer_x'               => '',
		'footer_youtube'         => '',
		'footer_linkedin'        => '',
		'footer_copyright'       => 'OneUp Motion. All rights reserved.',
		'footer_nav_title'       => 'Navigation',
		'footer_tools_title'     => 'Tools',
		'footer_resources_title' => 'Resources',
		'footer_legal_title'     => 'Legal',
		'enable_post_sections'   => '0',
	);
}

//───────────────────────────────────────
// Option getter
//───────────────────────────────────────
function oum_get_theme_option( $key, $fallback = null ) {
	$defaults = oum_theme_option_defaults();
	$options  = get_option( 'oum_theme_options', array() );
	$value    = isset( $options[ $key ] ) ? $options[ $key ] : ( $defaults[ $key ] ?? $fallback );

	return null === $value ? $fallback : $value;
}

//───────────────────────────────────────
// Font stacks
//───────────────────────────────────────
function oum_font_choices() {
	return array(
		'system'  => array( 'label' => __( 'System Sans', 'oneup-motion' ), 'stack' => 'system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif' ),
		'rounded' => array( 'label' => __( 'Rounded Sans', 'oneup-motion' ), 'stack' => 'ui-rounded, "SF Pro Rounded", system-ui, sans-serif' ),
		'modern'  => array( 'label' => __( 'Modern Sans', 'oneup-motion' ), 'stack' => 'Inter, system-ui, sans-serif' ),
		'serif'   => array( 'label' => __( 'Serif', 'oneup-motion' ), 'stack' => 'Georgia, "Times New Roman", serif' ),
		'mono'    => array( 'label' => __( 'Mono', 'oneup-motion' ), 'stack' => 'ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, monospace' ),
	);
}

//───────────────────────────────────────
// Sanitize options
//───────────────────────────────────────
function oum_sanitize_theme_options( $input ) {
	$defaults = oum_theme_option_defaults();
	$output   = array();
	$input    = is_array( $input ) ? $input : array();

	foreach ( array( 'main_logo_id', 'alt_logo_id', 'footer_logo_id' ) as $key ) {
		$output[ $key ] = isset( $input[ $key ] ) ? absint( $input[ $key ] ) : 0;
	}

	$text_keys = array( 'brand_name', 'footer_brand_text', 'heading_weight', 'body_weight', 'button_weight', 'heading_spacing', 'body_spacing', 'button_spacing', 'base_font_size', 'button_font_size', 'button_radius', 'header_cta_label', 'footer_description', 'footer_email', 'footer_copyright', 'footer_nav_title', 'footer_tools_title', 'footer_resources_title', 'footer_legal_title' );
	foreach ( $text_keys as $key ) {
		$output[ $key ] = isset( $input[ $key ] ) ? sanitize_text_field( $input[ $key ] ) : $defaults[ $key ];
	}

	foreach ( array( 'header_cta_url', 'footer_instagram', 'footer_x', 'footer_youtube', 'footer_linkedin' ) as $key ) {
		$output[ $key ] = isset( $input[ $key ] ) ? esc_url_raw( $input[ $key ] ) : '';
	}

	foreach ( array( 'bg', 'bg_soft', 'navy', 'card', 'card_border', 'text', 'muted', 'soft_muted', 'mint', 'mint_dark', 'button_bg', 'button_text', 'header_bg', 'footer_bg' ) as $key ) {
		$output[ $key ] = isset( $input[ $key ] ) ? oum_sanitize_css_value( $input[ $key ], $defaults[ $key ] ) : $defaults[ $key ];
	}

	$selects = array(
		'heading_font'     => array_keys( oum_font_choices() ),
		'body_font'        => array_keys( oum_font_choices() ),
		'button_font'      => array_keys( oum_font_choices() ),
		'heading_style'    => array( 'normal', 'rounded', 'compact', 'elegant' ),
		'button_transform' => array( 'none', 'uppercase' ),
		'button_padding'   => array( 'small', 'medium', 'large' ),
		'button_style'     => array( 'filled', 'outline', 'ghost', 'gradient' ),
		'container_width'  => array( 'narrow', 'default', 'wide' ),
		'section_spacing'  => array( 'compact', 'default', 'spacious' ),
		'card_radius'      => array( 'sharp', 'soft', 'rounded' ),
		'card_style'       => array( 'flat', 'glass', 'outlined', 'glow' ),
	);
	foreach ( $selects as $key => $allowed ) {
		$value          = isset( $input[ $key ] ) ? sanitize_key( $input[ $key ] ) : $defaults[ $key ];
		$output[ $key ] = in_array( $value, $allowed, true ) ? $value : $defaults[ $key ];
	}

	foreach ( array( 'button_shadow', 'button_hover_lift', 'button_arrow', 'sticky_header', 'transparent_header', 'show_header_cta', 'enable_post_sections' ) as $key ) {
		$output[ $key ] = ! empty( $input[ $key ] ) ? '1' : '0';
	}

	return $output;
}

//───────────────────────────────────────
// CSS value sanitizer
//───────────────────────────────────────
function oum_sanitize_css_value( $value, $fallback ) {
	$value = trim( (string) $value );

	if ( preg_match( '/^(#[0-9a-fA-F]{3,8}|rgba?\([0-9.,\s]+\))$/', $value ) ) {
		return $value;
	}

	return $fallback;
}

//───────────────────────────────────────
// Admin menu
//───────────────────────────────────────
function oum_register_theme_options_page() {
	add_theme_page( __( 'OneUp Motion', 'oneup-motion' ), __( 'OneUp Motion', 'oneup-motion' ), 'edit_theme_options', 'oum-theme-options', 'oum_render_theme_options_page' );
}
add_action( 'admin_menu', 'oum_register_theme_options_page' );

//───────────────────────────────────────
// Register settings
//───────────────────────────────────────
function oum_register_theme_options() {
	register_setting( 'oum_theme_options_group', 'oum_theme_options', 'oum_sanitize_theme_options' );
}
add_action( 'admin_init', 'oum_register_theme_options' );

//───────────────────────────────────────
// Admin assets
//───────────────────────────────────────
function oum_enqueue_options_admin_assets( $hook ) {
	if ( 'appearance_page_oum-theme-options' !== $hook ) {
		return;
	}

	wp_enqueue_media();
	wp_enqueue_style( 'oum-admin', get_template_directory_uri() . '/assets/css/admin.css', array(), oum_asset_version( 'assets/css/admin.css' ) );
	wp_enqueue_script( 'oum-admin-sections', get_template_directory_uri() . '/assets/js/admin-sections.js', array(), oum_asset_version( 'assets/js/admin-sections.js' ), true );
}
add_action( 'admin_enqueue_scripts', 'oum_enqueue_options_admin_assets' );

//───────────────────────────────────────
// Options page
//───────────────────────────────────────
function oum_render_theme_options_page() {
	if ( ! current_user_can( 'edit_theme_options' ) ) {
		return;
	}

	$options = wp_parse_args( get_option( 'oum_theme_options', array() ), oum_theme_option_defaults() );
	?>
	<div class="wrap oum-admin-page">
		<h1><?php echo esc_html__( 'OneUp Motion Theme Settings', 'oneup-motion' ); ?></h1>
		<p><?php echo esc_html__( 'Manage brand, colors, typography, layout, header, footer and section-builder settings.', 'oneup-motion' ); ?></p>
		<form method="post" action="options.php">
			<?php settings_fields( 'oum_theme_options_group' ); ?>
			<div class="oum-admin-grid">
				<?php oum_render_options_panel_branding( $options ); ?>
				<?php oum_render_options_panel_colors( $options ); ?>
				<?php oum_render_options_panel_typography( $options ); ?>
				<?php oum_render_options_panel_buttons_layout( $options ); ?>
				<?php oum_render_options_panel_header_footer( $options ); ?>
			</div>
			<?php submit_button(); ?>
		</form>
	</div>
	<?php
}

//───────────────────────────────────────
// Field helpers
//───────────────────────────────────────
function oum_option_name( $key ) {
	return 'oum_theme_options[' . esc_attr( $key ) . ']';
}

function oum_text_field( $options, $key, $label, $type = 'text' ) {
	?>
	<label>
		<span><?php echo esc_html( $label ); ?></span>
		<input type="<?php echo esc_attr( $type ); ?>" name="<?php echo esc_attr( oum_option_name( $key ) ); ?>" value="<?php echo esc_attr( $options[ $key ] ?? '' ); ?>">
	</label>
	<?php
}

function oum_select_field( $options, $key, $label, $choices ) {
	?>
	<label>
		<span><?php echo esc_html( $label ); ?></span>
		<select name="<?php echo esc_attr( oum_option_name( $key ) ); ?>">
			<?php foreach ( $choices as $value => $choice_label ) : ?>
				<option value="<?php echo esc_attr( $value ); ?>" <?php selected( $options[ $key ] ?? '', $value ); ?>><?php echo esc_html( $choice_label ); ?></option>
			<?php endforeach; ?>
		</select>
	</label>
	<?php
}

function oum_checkbox_field( $options, $key, $label ) {
	?>
	<label class="oum-checkbox">
		<input type="checkbox" name="<?php echo esc_attr( oum_option_name( $key ) ); ?>" value="1" <?php checked( $options[ $key ] ?? '', '1' ); ?>>
		<span><?php echo esc_html( $label ); ?></span>
	</label>
	<?php
}

function oum_media_field( $options, $key, $label ) {
	$value = absint( $options[ $key ] ?? 0 );
	?>
	<label class="oum-media-field">
		<span><?php echo esc_html( $label ); ?></span>
		<input type="hidden" name="<?php echo esc_attr( oum_option_name( $key ) ); ?>" value="<?php echo esc_attr( $value ); ?>" data-oum-media-input>
		<button type="button" class="button" data-oum-media-button><?php echo esc_html__( 'Choose image', 'oneup-motion' ); ?></button>
		<button type="button" class="button-link" data-oum-media-clear><?php echo esc_html__( 'Remove', 'oneup-motion' ); ?></button>
		<span class="oum-media-preview" data-oum-media-preview><?php echo $value ? wp_get_attachment_image( $value, 'thumbnail' ) : ''; ?></span>
	</label>
	<?php
}

function oum_panel_open( $title ) {
	echo '<section class="oum-admin-panel"><h2>' . esc_html( $title ) . '</h2>';
}

function oum_panel_close() {
	echo '</section>';
}

//───────────────────────────────────────
// Branding panel
//───────────────────────────────────────
function oum_render_options_panel_branding( $options ) {
	oum_panel_open( __( 'Logo / Branding', 'oneup-motion' ) );
	oum_media_field( $options, 'main_logo_id', __( 'Main logo upload', 'oneup-motion' ) );
	oum_media_field( $options, 'alt_logo_id', __( 'Alternative dark/light logo', 'oneup-motion' ) );
	oum_media_field( $options, 'footer_logo_id', __( 'Footer logo option', 'oneup-motion' ) );
	oum_text_field( $options, 'brand_name', __( 'Brand name fallback', 'oneup-motion' ) );
	oum_text_field( $options, 'footer_brand_text', __( 'Footer brand text', 'oneup-motion' ) );
	echo '<p><a href="' . esc_url( admin_url( 'customize.php?autofocus[section]=title_tagline' ) ) . '">' . esc_html__( 'Set the favicon/site icon in the WordPress Site Identity settings.', 'oneup-motion' ) . '</a></p>';
	oum_panel_close();
}

//───────────────────────────────────────
// Colors panel
//───────────────────────────────────────
function oum_render_options_panel_colors( $options ) {
	oum_panel_open( __( 'Colors', 'oneup-motion' ) );
	$labels = array(
		'bg'          => __( 'Background color', 'oneup-motion' ),
		'bg_soft'     => __( 'Soft background color', 'oneup-motion' ),
		'navy'        => __( 'Navy color', 'oneup-motion' ),
		'card'        => __( 'Card background color', 'oneup-motion' ),
		'card_border' => __( 'Border color', 'oneup-motion' ),
		'text'        => __( 'Primary text color', 'oneup-motion' ),
		'muted'       => __( 'Muted text color', 'oneup-motion' ),
		'soft_muted'  => __( 'Soft muted text color', 'oneup-motion' ),
		'mint'        => __( 'Primary accent color', 'oneup-motion' ),
		'mint_dark'   => __( 'Secondary accent color', 'oneup-motion' ),
		'button_bg'   => __( 'Button background color', 'oneup-motion' ),
		'button_text' => __( 'Button text color', 'oneup-motion' ),
		'header_bg'   => __( 'Header background color', 'oneup-motion' ),
		'footer_bg'   => __( 'Footer background color', 'oneup-motion' ),
	);
	foreach ( $labels as $key => $label ) {
		oum_text_field( $options, $key, $label );
	}
	oum_panel_close();
}

//───────────────────────────────────────
// Typography panel
//───────────────────────────────────────
function oum_render_options_panel_typography( $options ) {
	oum_panel_open( __( 'Typography', 'oneup-motion' ) );
	$fonts = array_map( static function( $choice ) { return $choice['label']; }, oum_font_choices() );
	oum_select_field( $options, 'heading_font', __( 'Heading font family', 'oneup-motion' ), $fonts );
	oum_select_field( $options, 'body_font', __( 'Body font family', 'oneup-motion' ), $fonts );
	oum_select_field( $options, 'button_font', __( 'Button font family', 'oneup-motion' ), $fonts );
	oum_text_field( $options, 'heading_weight', __( 'Heading font weight', 'oneup-motion' ) );
	oum_text_field( $options, 'body_weight', __( 'Body font weight', 'oneup-motion' ) );
	oum_text_field( $options, 'button_weight', __( 'Button font weight', 'oneup-motion' ) );
	oum_text_field( $options, 'heading_spacing', __( 'Heading letter spacing', 'oneup-motion' ) );
	oum_text_field( $options, 'body_spacing', __( 'Body letter spacing', 'oneup-motion' ) );
	oum_text_field( $options, 'button_spacing', __( 'Button letter spacing', 'oneup-motion' ) );
	oum_text_field( $options, 'base_font_size', __( 'Base font size', 'oneup-motion' ), 'number' );
	oum_select_field( $options, 'heading_style', __( 'Heading style', 'oneup-motion' ), array( 'normal' => __( 'Normal', 'oneup-motion' ), 'rounded' => __( 'Rounded/bold', 'oneup-motion' ), 'compact' => __( 'Compact', 'oneup-motion' ), 'elegant' => __( 'Elegant', 'oneup-motion' ) ) );
	oum_select_field( $options, 'button_transform', __( 'Button text transform', 'oneup-motion' ), array( 'none' => __( 'None', 'oneup-motion' ), 'uppercase' => __( 'Uppercase', 'oneup-motion' ) ) );
	oum_text_field( $options, 'button_font_size', __( 'Button font size', 'oneup-motion' ), 'number' );
	oum_panel_close();
}

//───────────────────────────────────────
// Button and layout panel
//───────────────────────────────────────
function oum_render_options_panel_buttons_layout( $options ) {
	oum_panel_open( __( 'Buttons & Layout', 'oneup-motion' ) );
	oum_text_field( $options, 'button_radius', __( 'Button border radius', 'oneup-motion' ), 'number' );
	oum_select_field( $options, 'button_padding', __( 'Button padding size', 'oneup-motion' ), array( 'small' => __( 'Small', 'oneup-motion' ), 'medium' => __( 'Medium', 'oneup-motion' ), 'large' => __( 'Large', 'oneup-motion' ) ) );
	oum_select_field( $options, 'button_style', __( 'Button style', 'oneup-motion' ), array( 'filled' => __( 'Filled', 'oneup-motion' ), 'outline' => __( 'Outline', 'oneup-motion' ), 'ghost' => __( 'Ghost', 'oneup-motion' ), 'gradient' => __( 'Gradient', 'oneup-motion' ) ) );
	oum_checkbox_field( $options, 'button_shadow', __( 'Button shadow', 'oneup-motion' ) );
	oum_checkbox_field( $options, 'button_hover_lift', __( 'Button hover lift', 'oneup-motion' ) );
	oum_checkbox_field( $options, 'button_arrow', __( 'Button icon arrow', 'oneup-motion' ) );
	oum_select_field( $options, 'container_width', __( 'Container width', 'oneup-motion' ), array( 'narrow' => __( 'Narrow', 'oneup-motion' ), 'default' => __( 'Default', 'oneup-motion' ), 'wide' => __( 'Wide', 'oneup-motion' ) ) );
	oum_select_field( $options, 'section_spacing', __( 'Section spacing', 'oneup-motion' ), array( 'compact' => __( 'Compact', 'oneup-motion' ), 'default' => __( 'Default', 'oneup-motion' ), 'spacious' => __( 'Spacious', 'oneup-motion' ) ) );
	oum_select_field( $options, 'card_radius', __( 'Card border radius', 'oneup-motion' ), array( 'sharp' => __( 'Sharp', 'oneup-motion' ), 'soft' => __( 'Soft', 'oneup-motion' ), 'rounded' => __( 'Rounded', 'oneup-motion' ) ) );
	oum_select_field( $options, 'card_style', __( 'Card style', 'oneup-motion' ), array( 'flat' => __( 'Flat', 'oneup-motion' ), 'glass' => __( 'Glass', 'oneup-motion' ), 'outlined' => __( 'Outlined', 'oneup-motion' ), 'glow' => __( 'Glow', 'oneup-motion' ) ) );
	oum_checkbox_field( $options, 'enable_post_sections', __( 'Enable OneUp Sections on posts', 'oneup-motion' ) );
	oum_panel_close();
}

//───────────────────────────────────────
// Header and footer panel
//───────────────────────────────────────
function oum_render_options_panel_header_footer( $options ) {
	oum_panel_open( __( 'Header & Footer', 'oneup-motion' ) );
	oum_checkbox_field( $options, 'sticky_header', __( 'Sticky header', 'oneup-motion' ) );
	oum_checkbox_field( $options, 'transparent_header', __( 'Transparent header', 'oneup-motion' ) );
	oum_checkbox_field( $options, 'show_header_cta', __( 'Show header CTA button', 'oneup-motion' ) );
	oum_text_field( $options, 'header_cta_label', __( 'CTA button label', 'oneup-motion' ) );
	oum_text_field( $options, 'header_cta_url', __( 'CTA button URL', 'oneup-motion' ), 'url' );
	oum_text_field( $options, 'footer_description', __( 'Footer description text', 'oneup-motion' ) );
	oum_text_field( $options, 'footer_email', __( 'Footer email', 'oneup-motion' ), 'email' );
	oum_text_field( $options, 'footer_instagram', __( 'Instagram URL', 'oneup-motion' ), 'url' );
	oum_text_field( $options, 'footer_x', __( 'X/Twitter URL', 'oneup-motion' ), 'url' );
	oum_text_field( $options, 'footer_youtube', __( 'YouTube URL', 'oneup-motion' ), 'url' );
	oum_text_field( $options, 'footer_linkedin', __( 'LinkedIn URL', 'oneup-motion' ), 'url' );
	oum_text_field( $options, 'footer_nav_title', __( 'Footer Navigation Title', 'oneup-motion' ) );
	oum_text_field( $options, 'footer_tools_title', __( 'Footer Tools Title', 'oneup-motion' ) );
	oum_text_field( $options, 'footer_resources_title', __( 'Footer Resources Title', 'oneup-motion' ) );
	oum_text_field( $options, 'footer_legal_title', __( 'Footer Legal Title', 'oneup-motion' ) );
	oum_text_field( $options, 'footer_copyright', __( 'Footer copyright text', 'oneup-motion' ) );
	oum_panel_close();
}

//───────────────────────────────────────
// Frontend CSS variables
//───────────────────────────────────────
function oum_output_theme_css_variables() {
	$options = wp_parse_args( get_option( 'oum_theme_options', array() ), oum_theme_option_defaults() );
	$fonts   = oum_font_choices();
	$vars    = array(
		'--oum-bg'               => $options['bg'],
		'--oum-bg-soft'          => $options['bg_soft'],
		'--oum-navy'             => $options['navy'],
		'--oum-card'             => $options['card'],
		'--oum-card-border'      => $options['card_border'],
		'--oum-text'             => $options['text'],
		'--oum-muted'            => $options['muted'],
		'--oum-soft-muted'       => $options['soft_muted'],
		'--oum-mint'             => $options['mint'],
		'--oum-mint-dark'        => $options['mint_dark'],
		'--oum-button-bg'        => $options['button_bg'],
		'--oum-button-text'      => $options['button_text'],
		'--oum-header-bg'        => $options['header_bg'],
		'--oum-footer-bg'        => $options['footer_bg'],
		'--oum-heading-font'     => $fonts[ $options['heading_font'] ]['stack'] ?? $fonts['rounded']['stack'],
		'--oum-body-font'        => $fonts[ $options['body_font'] ]['stack'] ?? $fonts['rounded']['stack'],
		'--oum-button-font'      => $fonts[ $options['button_font'] ]['stack'] ?? $fonts['rounded']['stack'],
		'--oum-heading-weight'   => $options['heading_weight'],
		'--oum-body-weight'      => $options['body_weight'],
		'--oum-button-weight'    => $options['button_weight'],
		'--oum-heading-spacing'  => $options['heading_spacing'],
		'--oum-body-spacing'     => $options['body_spacing'],
		'--oum-button-spacing'   => $options['button_spacing'],
		'--oum-base-font-size'   => absint( $options['base_font_size'] ) . 'px',
		'--oum-button-font-size' => absint( $options['button_font_size'] ) . 'px',
		'--oum-button-radius'    => absint( $options['button_radius'] ) . 'px',
		'--oum-button-transform' => $options['button_transform'],
	);

	$css = ':root{';
	foreach ( $vars as $name => $value ) {
		$css .= $name . ':' . oum_clean_css_output_value( $value ) . ';';
	}
	$css .= '}';

	echo '<style id="oum-theme-options-css">' . $css . '</style>' . "\n"; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
}
add_action( 'wp_head', 'oum_output_theme_css_variables', 20 );

//───────────────────────────────────────
// Clean CSS output value
//───────────────────────────────────────
function oum_clean_css_output_value( $value ) {
	return str_replace( array( '<', '>', '{', '}', ';' ), '', wp_strip_all_tags( (string) $value ) );
}

//───────────────────────────────────────
// Body option classes
//───────────────────────────────────────
function oum_theme_option_body_classes( $classes ) {
	$options = wp_parse_args( get_option( 'oum_theme_options', array() ), oum_theme_option_defaults() );
	$keys    = array( 'heading_style', 'button_padding', 'button_style', 'container_width', 'section_spacing', 'card_radius', 'card_style' );

	foreach ( $keys as $key ) {
		$classes[] = 'oum-' . str_replace( '_', '-', $key ) . '-' . sanitize_html_class( $options[ $key ] );
	}

	foreach ( array( 'button_shadow', 'button_hover_lift', 'button_arrow', 'sticky_header', 'transparent_header' ) as $key ) {
		if ( '1' === $options[ $key ] ) {
			$classes[] = 'oum-' . str_replace( '_', '-', $key );
		}
	}

	return $classes;
}
add_filter( 'body_class', 'oum_theme_option_body_classes' );
