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
		'main_logo_id'          => 0,
		'alt_logo_id'           => 0,
		'footer_logo_id'        => 0,
		'brand_name'            => 'OneUp Motion',
		'footer_brand_text'     => 'OneUp Motion',
		'header_logo_max_width' => '180',
		'header_logo_max_height'=> '52',
		'footer_logo_max_width' => '180',
		'footer_logo_max_height'=> '60',
		'bg'                    => '#03101f',
		'bg_soft'               => '#071a2e',
		'navy'                  => '#001f3d',
		'card'                  => 'rgba(255, 255, 255, 0.055)',
		'card_border'           => 'rgba(255, 255, 255, 0.12)',
		'text'                  => '#ffffff',
		'muted'                 => 'rgba(255, 255, 255, 0.72)',
		'soft_muted'            => 'rgba(255, 255, 255, 0.52)',
		'mint'                  => '#20f0c0',
		'mint_dark'             => '#08caa0',
		'button_bg'             => '#20f0c0',
		'button_text'           => '#02131f',
		'header_bg'             => 'rgba(3, 16, 31, 0.74)',
		'footer_bg'             => '#020a14',
		'heading_font'          => 'rounded',
		'body_font'             => 'rounded',
		'button_font'           => 'rounded',
		'heading_weight'        => '900',
		'body_weight'           => '400',
		'button_weight'         => '900',
		'heading_spacing'       => '0',
		'body_spacing'          => '0',
		'button_spacing'        => '0',
		'base_font_size'        => '16',
		'heading_style'         => 'rounded',
		'button_transform'      => 'none',
		'button_font_size'      => '16',
		'button_radius'         => '999',
		'button_padding'        => 'medium',
		'button_style'          => 'filled',
		'button_shadow'         => '1',
		'button_hover_lift'     => '1',
		'button_arrow'          => '0',
		'container_width'       => 'default',
		'section_spacing'       => 'default',
		'card_radius'           => 'rounded',
		'card_style'            => 'glass',
		'sticky_header'         => '1',
		'transparent_header'    => '1',
		'show_header_cta'       => '1',
		'header_cta_label'      => 'Start Creating',
		'header_cta_url'        => '#contact',
		'footer_description'    => 'Digital tools. Modern design. Real results.',
		'footer_email'          => 'hello@oneupmotion.com',
		'footer_instagram'      => '',
		'footer_x'              => '',
		'footer_youtube'        => '',
		'footer_linkedin'       => '',
		'footer_copyright'      => 'OneUp Motion. All rights reserved.',
		'footer_nav_title'      => 'Navigation',
		'footer_tools_title'    => 'Tools',
		'footer_resources_title'=> 'Resources',
		'footer_legal_title'    => 'Legal',
		'show_footer_nav'       => '1',
		'show_footer_tools'     => '1',
		'show_footer_resources' => '1',
		'show_footer_legal'     => '1',
		'use_sections_for_pages'=> '1',
		'hide_page_content_editor' => '1',
		'enable_post_sections'  => '0',
		'replace_post_editor_with_sections' => '0',
	);
}

//───────────────────────────────────────
// Theme defaults alias
//───────────────────────────────────────
function oum_get_theme_defaults() {
	return oum_theme_option_defaults();
}

//───────────────────────────────────────
// Theme options getter
//───────────────────────────────────────
function oum_get_theme_options() {
	$saved = get_option( 'oum_theme_options', array() );

	return wp_parse_args( is_array( $saved ) ? $saved : array(), oum_get_theme_defaults() );
}

//───────────────────────────────────────
// Option getter
//───────────────────────────────────────
function oum_get_theme_option( $key, $fallback = null ) {
	$defaults = oum_get_theme_defaults();
	$options  = oum_get_theme_options();
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
	$defaults = oum_get_theme_defaults();
	$output   = oum_get_theme_options();
	$input    = is_array( $input ) ? $input : array();

	$ids = array( 'main_logo_id', 'alt_logo_id', 'footer_logo_id' );
	foreach ( $ids as $key ) {
		$output[ $key ] = isset( $input[ $key ] ) ? absint( $input[ $key ] ) : 0;
	}

	$text_keys = array( 'brand_name', 'footer_brand_text', 'heading_weight', 'body_weight', 'button_weight', 'heading_spacing', 'body_spacing', 'button_spacing', 'base_font_size', 'button_font_size', 'button_radius', 'header_cta_label', 'footer_description', 'footer_email', 'footer_copyright', 'footer_nav_title', 'footer_tools_title', 'footer_resources_title', 'footer_legal_title' );
	foreach ( $text_keys as $key ) {
		$output[ $key ] = isset( $input[ $key ] ) ? sanitize_text_field( $input[ $key ] ) : $defaults[ $key ];
	}

	$logo_sizes = array(
		'header_logo_max_width'  => array( 60, 320 ),
		'header_logo_max_height' => array( 24, 120 ),
		'footer_logo_max_width'  => array( 60, 320 ),
		'footer_logo_max_height' => array( 24, 120 ),
	);
	foreach ( $logo_sizes as $key => $range ) {
		$value          = isset( $input[ $key ] ) ? absint( $input[ $key ] ) : absint( $defaults[ $key ] );
		$output[ $key ] = (string) min( max( $value, $range[0] ), $range[1] );
	}

	$url_keys = array( 'header_cta_url', 'footer_instagram', 'footer_x', 'footer_youtube', 'footer_linkedin' );
	foreach ( $url_keys as $key ) {
		$output[ $key ] = isset( $input[ $key ] ) ? esc_url_raw( $input[ $key ] ) : '';
	}

	$css_keys = array( 'bg', 'bg_soft', 'navy', 'card', 'card_border', 'text', 'muted', 'soft_muted', 'mint', 'mint_dark', 'button_bg', 'button_text', 'header_bg', 'footer_bg' );
	foreach ( $css_keys as $key ) {
		$output[ $key ] = isset( $input[ $key ] ) ? oum_sanitize_css_value( $input[ $key ], $defaults[ $key ] ) : $defaults[ $key ];
	}

	$selects = array(
		'heading_font'       => array_keys( oum_font_choices() ),
		'body_font'          => array_keys( oum_font_choices() ),
		'button_font'        => array_keys( oum_font_choices() ),
		'heading_style'      => array( 'normal', 'rounded', 'compact', 'elegant' ),
		'button_transform'   => array( 'none', 'uppercase' ),
		'button_padding'     => array( 'small', 'medium', 'large' ),
		'button_style'       => array( 'filled', 'outline', 'ghost', 'gradient' ),
		'container_width'    => array( 'narrow', 'default', 'wide' ),
		'section_spacing'    => array( 'compact', 'default', 'spacious' ),
		'card_radius'        => array( 'sharp', 'soft', 'rounded' ),
		'card_style'         => array( 'flat', 'glass', 'outlined', 'glow' ),
	);
	foreach ( $selects as $key => $allowed ) {
		$value          = isset( $input[ $key ] ) ? sanitize_key( $input[ $key ] ) : $defaults[ $key ];
		$output[ $key ] = in_array( $value, $allowed, true ) ? $value : $defaults[ $key ];
	}

	$checks = array( 'button_shadow', 'button_hover_lift', 'button_arrow', 'sticky_header', 'transparent_header', 'show_header_cta', 'show_footer_nav', 'show_footer_tools', 'show_footer_resources', 'show_footer_legal', 'use_sections_for_pages', 'hide_page_content_editor', 'enable_post_sections', 'replace_post_editor_with_sections' );
	foreach ( $checks as $key ) {
		$output[ $key ] = ! empty( $input[ $key ] ) ? '1' : '0';
	}

	return $output;
}

//───────────────────────────────────────
// Sanitize one option
//───────────────────────────────────────
function oum_sanitize_theme_option( $key, $value ) {
	$defaults = oum_get_theme_defaults();

	if ( in_array( $key, array( 'main_logo_id', 'alt_logo_id', 'footer_logo_id' ), true ) ) {
		return absint( $value );
	}

	$logo_sizes = array(
		'header_logo_max_width'  => array( 60, 320 ),
		'header_logo_max_height' => array( 24, 120 ),
		'footer_logo_max_width'  => array( 60, 320 ),
		'footer_logo_max_height' => array( 24, 120 ),
	);
	if ( isset( $logo_sizes[ $key ] ) ) {
		$range = $logo_sizes[ $key ];
		return (string) min( max( absint( $value ), $range[0] ), $range[1] );
	}

	if ( in_array( $key, array( 'header_cta_url', 'footer_instagram', 'footer_x', 'footer_youtube', 'footer_linkedin' ), true ) ) {
		return esc_url_raw( $value );
	}

	if ( in_array( $key, array( 'bg', 'bg_soft', 'navy', 'card', 'card_border', 'text', 'muted', 'soft_muted', 'mint', 'mint_dark', 'button_bg', 'button_text', 'header_bg', 'footer_bg' ), true ) ) {
		return oum_sanitize_css_value( $value, $defaults[ $key ] ?? '' );
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
	if ( isset( $selects[ $key ] ) ) {
		$value = sanitize_key( $value );
		return in_array( $value, $selects[ $key ], true ) ? $value : ( $defaults[ $key ] ?? '' );
	}

	if ( in_array( $key, oum_checkbox_option_keys(), true ) ) {
		return ! empty( $value ) ? '1' : '0';
	}

	return sanitize_text_field( $value );
}

//───────────────────────────────────────
// Checkbox option keys
//───────────────────────────────────────
function oum_checkbox_option_keys() {
	return array( 'button_shadow', 'button_hover_lift', 'button_arrow', 'sticky_header', 'transparent_header', 'show_header_cta', 'show_footer_nav', 'show_footer_tools', 'show_footer_resources', 'show_footer_legal', 'use_sections_for_pages', 'hide_page_content_editor', 'enable_post_sections', 'replace_post_editor_with_sections' );
}

//───────────────────────────────────────
// Update merged theme options
//───────────────────────────────────────
function oum_update_theme_options( $new_values, $submitted_keys = array() ) {
	$options        = oum_get_theme_options();
	$submitted_keys = array_map( 'sanitize_key', (array) $submitted_keys );
	$new_values     = is_array( $new_values ) ? $new_values : array();

	foreach ( $submitted_keys as $key ) {
		if ( ! array_key_exists( $key, oum_get_theme_defaults() ) ) {
			continue;
		}

		$value           = array_key_exists( $key, $new_values ) ? $new_values[ $key ] : '';
		$options[ $key ] = oum_sanitize_theme_option( $key, $value );
	}

	update_option( 'oum_theme_options', $options );

	return $options;
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
	add_theme_page(
		__( 'OneUp Motion', 'oneup-motion' ),
		__( 'OneUp Motion', 'oneup-motion' ),
		'edit_theme_options',
		'oum-theme-options',
		'oum_render_theme_options_page'
	);
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

	$options = oum_get_theme_options();
	$tabs    = oum_theme_options_tabs();
	$active  = isset( $_GET['tab'] ) ? sanitize_key( wp_unslash( $_GET['tab'] ) ) : 'branding';
	$active  = isset( $tabs[ $active ] ) ? $active : 'branding';
	?>
	<div class="wrap oum-admin-page">
		<h1><?php echo esc_html__( 'OneUp Motion Theme Settings', 'oneup-motion' ); ?></h1>
		<?php if ( isset( $_GET['settings-updated'] ) && '1' === sanitize_text_field( wp_unslash( $_GET['settings-updated'] ) ) ) : ?>
			<div class="notice notice-success is-dismissible"><p><?php echo esc_html__( 'Settings saved.', 'oneup-motion' ); ?></p></div>
		<?php endif; ?>
		<p><?php echo esc_html__( 'Manage brand, colors, typography, layout, header, footer and section-builder settings.', 'oneup-motion' ); ?></p>
		<nav class="nav-tab-wrapper" aria-label="<?php echo esc_attr__( 'OneUp Motion settings tabs', 'oneup-motion' ); ?>">
			<?php foreach ( $tabs as $tab => $label ) : ?>
				<a class="nav-tab <?php echo $active === $tab ? 'nav-tab-active' : ''; ?>" href="<?php echo esc_url( add_query_arg( array( 'page' => 'oum-theme-options', 'tab' => $tab ), admin_url( 'themes.php' ) ) ); ?>"><?php echo esc_html( $label ); ?></a>
			<?php endforeach; ?>
		</nav>
		<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
			<?php wp_nonce_field( 'oum_save_theme_options', 'oum_theme_options_nonce' ); ?>
			<input type="hidden" name="action" value="oum_save_theme_options">
			<input type="hidden" name="oum_active_tab" value="<?php echo esc_attr( $active ); ?>">
			<div class="oum-admin-grid oum-admin-grid--single">
				<?php oum_render_theme_options_tab( $active, $options ); ?>
			</div>
			<?php submit_button(); ?>
		</form>
	</div>
	<?php
}

//───────────────────────────────────────
// Save theme options
//───────────────────────────────────────
function oum_handle_theme_options_save() {
	if ( ! current_user_can( 'edit_theme_options' ) ) {
		wp_die( esc_html__( 'You do not have permission to edit theme options.', 'oneup-motion' ) );
	}

	if ( ! isset( $_POST['oum_theme_options_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['oum_theme_options_nonce'] ) ), 'oum_save_theme_options' ) ) {
		wp_die( esc_html__( 'Security check failed.', 'oneup-motion' ) );
	}

	$values = isset( $_POST['oum_theme_options'] ) && is_array( $_POST['oum_theme_options'] ) ? wp_unslash( $_POST['oum_theme_options'] ) : array();
	$keys   = isset( $_POST['oum_submitted_keys'] ) && is_array( $_POST['oum_submitted_keys'] ) ? wp_unslash( $_POST['oum_submitted_keys'] ) : array();
	$tab    = isset( $_POST['oum_active_tab'] ) ? sanitize_key( wp_unslash( $_POST['oum_active_tab'] ) ) : 'branding';

	oum_update_theme_options( $values, $keys );

	wp_safe_redirect(
		add_query_arg(
			array(
				'page'             => 'oum-theme-options',
				'tab'              => $tab,
				'settings-updated' => '1',
			),
			admin_url( 'themes.php' )
		)
	);
	exit;
}
add_action( 'admin_post_oum_save_theme_options', 'oum_handle_theme_options_save' );

//───────────────────────────────────────
// Settings tabs
//───────────────────────────────────────
function oum_theme_options_tabs() {
	return array(
		'branding'   => __( 'Branding', 'oneup-motion' ),
		'colors'     => __( 'Colors', 'oneup-motion' ),
		'typography' => __( 'Typography', 'oneup-motion' ),
		'buttons'    => __( 'Buttons', 'oneup-motion' ),
		'layout'     => __( 'Layout', 'oneup-motion' ),
		'header'     => __( 'Header', 'oneup-motion' ),
		'footer'     => __( 'Footer', 'oneup-motion' ),
		'sections'   => __( 'Sections', 'oneup-motion' ),
		'advanced'   => __( 'Advanced', 'oneup-motion' ),
	);
}

//───────────────────────────────────────
// Render active settings tab
//───────────────────────────────────────
function oum_render_theme_options_tab( $active, $options ) {
	$callback = 'oum_render_options_panel_' . str_replace( '-', '_', $active );

	if ( function_exists( $callback ) ) {
		call_user_func( $callback, $options );
		return;
	}

	oum_render_options_panel_branding( $options );
}

//───────────────────────────────────────
// Field helpers
//───────────────────────────────────────
function oum_option_name( $key ) {
	return 'oum_theme_options[' . esc_attr( $key ) . ']';
}

function oum_register_submitted_option_key( $key ) {
	echo '<input type="hidden" name="oum_submitted_keys[]" value="' . esc_attr( $key ) . '">';
}

function oum_text_field( $options, $key, $label, $type = 'text' ) {
	?>
	<label>
		<span><?php echo esc_html( $label ); ?></span>
		<input type="<?php echo esc_attr( $type ); ?>" name="<?php echo esc_attr( oum_option_name( $key ) ); ?>" value="<?php echo esc_attr( $options[ $key ] ?? '' ); ?>">
	</label>
	<?php oum_register_submitted_option_key( $key ); ?>
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
	<?php oum_register_submitted_option_key( $key ); ?>
	<?php
}

function oum_checkbox_field( $options, $key, $label ) {
	?>
	<label class="oum-checkbox">
		<input type="checkbox" name="<?php echo esc_attr( oum_option_name( $key ) ); ?>" value="1" <?php checked( $options[ $key ] ?? '', '1' ); ?>>
		<span><?php echo esc_html( $label ); ?></span>
	</label>
	<?php oum_register_submitted_option_key( $key ); ?>
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
	<?php oum_register_submitted_option_key( $key ); ?>
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
	echo '<p>' . esc_html__( 'Set the editable brand fallbacks and constrain uploaded logos so large image files never break the header or footer layout.', 'oneup-motion' ) . '</p>';
	oum_media_field( $options, 'main_logo_id', __( 'Main logo upload', 'oneup-motion' ) );
	oum_media_field( $options, 'alt_logo_id', __( 'Alternative dark/light logo', 'oneup-motion' ) );
	oum_media_field( $options, 'footer_logo_id', __( 'Footer logo option', 'oneup-motion' ) );
	oum_text_field( $options, 'brand_name', __( 'Brand name fallback', 'oneup-motion' ) );
	oum_text_field( $options, 'footer_brand_text', __( 'Footer brand text', 'oneup-motion' ) );
	oum_text_field( $options, 'header_logo_max_width', __( 'Header logo max width', 'oneup-motion' ), 'number' );
	oum_text_field( $options, 'header_logo_max_height', __( 'Header logo max height', 'oneup-motion' ), 'number' );
	oum_text_field( $options, 'footer_logo_max_width', __( 'Footer logo max width', 'oneup-motion' ), 'number' );
	oum_text_field( $options, 'footer_logo_max_height', __( 'Footer logo max height', 'oneup-motion' ), 'number' );
	echo '<p><a href="' . esc_url( admin_url( 'customize.php?autofocus[section]=title_tagline' ) ) . '">' . esc_html__( 'Set the favicon/site icon in the WordPress Site Identity settings.', 'oneup-motion' ) . '</a></p>';
	oum_panel_close();
}

//───────────────────────────────────────
// Colors panel
//───────────────────────────────────────
function oum_render_options_panel_colors( $options ) {
	oum_panel_open( __( 'Colors', 'oneup-motion' ) );
	echo '<p>' . esc_html__( 'These values output as CSS variables and control the dark OneUp Motion visual system.', 'oneup-motion' ) . '</p>';
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
	echo '<p>' . esc_html__( 'Choose safe system font stacks only. No external fonts are loaded.', 'oneup-motion' ) . '</p>';
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
// Buttons panel
//───────────────────────────────────────
function oum_render_options_panel_buttons( $options ) {
	oum_panel_open( __( 'Buttons', 'oneup-motion' ) );
	echo '<p>' . esc_html__( 'Control global button styling without changing template markup.', 'oneup-motion' ) . '</p>';
	oum_text_field( $options, 'button_radius', __( 'Button border radius', 'oneup-motion' ), 'number' );
	oum_select_field( $options, 'button_padding', __( 'Button padding size', 'oneup-motion' ), array( 'small' => __( 'Small', 'oneup-motion' ), 'medium' => __( 'Medium', 'oneup-motion' ), 'large' => __( 'Large', 'oneup-motion' ) ) );
	oum_select_field( $options, 'button_style', __( 'Button style', 'oneup-motion' ), array( 'filled' => __( 'Filled', 'oneup-motion' ), 'outline' => __( 'Outline', 'oneup-motion' ), 'ghost' => __( 'Ghost', 'oneup-motion' ), 'gradient' => __( 'Gradient', 'oneup-motion' ) ) );
	oum_checkbox_field( $options, 'button_shadow', __( 'Button shadow', 'oneup-motion' ) );
	oum_checkbox_field( $options, 'button_hover_lift', __( 'Button hover lift', 'oneup-motion' ) );
	oum_checkbox_field( $options, 'button_arrow', __( 'Button icon arrow', 'oneup-motion' ) );
	oum_panel_close();
}

//───────────────────────────────────────
// Layout panel
//───────────────────────────────────────
function oum_render_options_panel_layout( $options ) {
	oum_panel_open( __( 'Layout', 'oneup-motion' ) );
	echo '<p>' . esc_html__( 'Adjust global spacing and card treatments while preserving the current homepage design defaults.', 'oneup-motion' ) . '</p>';
	oum_select_field( $options, 'container_width', __( 'Container width', 'oneup-motion' ), array( 'narrow' => __( 'Narrow', 'oneup-motion' ), 'default' => __( 'Default', 'oneup-motion' ), 'wide' => __( 'Wide', 'oneup-motion' ) ) );
	oum_select_field( $options, 'section_spacing', __( 'Section spacing', 'oneup-motion' ), array( 'compact' => __( 'Compact', 'oneup-motion' ), 'default' => __( 'Default', 'oneup-motion' ), 'spacious' => __( 'Spacious', 'oneup-motion' ) ) );
	oum_select_field( $options, 'card_radius', __( 'Card border radius', 'oneup-motion' ), array( 'sharp' => __( 'Sharp', 'oneup-motion' ), 'soft' => __( 'Soft', 'oneup-motion' ), 'rounded' => __( 'Rounded', 'oneup-motion' ) ) );
	oum_select_field( $options, 'card_style', __( 'Card style', 'oneup-motion' ), array( 'flat' => __( 'Flat', 'oneup-motion' ), 'glass' => __( 'Glass', 'oneup-motion' ), 'outlined' => __( 'Outlined', 'oneup-motion' ), 'glow' => __( 'Glow', 'oneup-motion' ) ) );
	oum_panel_close();
}

//───────────────────────────────────────
// Header panel
//───────────────────────────────────────
function oum_render_options_panel_header( $options ) {
	oum_panel_open( __( 'Header', 'oneup-motion' ) );
	oum_checkbox_field( $options, 'sticky_header', __( 'Sticky header', 'oneup-motion' ) );
	oum_checkbox_field( $options, 'transparent_header', __( 'Transparent header', 'oneup-motion' ) );
	oum_checkbox_field( $options, 'show_header_cta', __( 'Show header CTA button', 'oneup-motion' ) );
	oum_text_field( $options, 'header_cta_label', __( 'CTA button label', 'oneup-motion' ) );
	oum_text_field( $options, 'header_cta_url', __( 'CTA button URL', 'oneup-motion' ), 'url' );
	oum_panel_close();
}

//───────────────────────────────────────
// Footer panel
//───────────────────────────────────────
function oum_render_options_panel_footer( $options ) {
	oum_panel_open( __( 'Footer', 'oneup-motion' ) );
	oum_text_field( $options, 'footer_description', __( 'Footer description text', 'oneup-motion' ) );
	oum_text_field( $options, 'footer_email', __( 'Footer email', 'oneup-motion' ), 'email' );
	oum_text_field( $options, 'footer_instagram', __( 'Instagram URL', 'oneup-motion' ), 'url' );
	oum_text_field( $options, 'footer_x', __( 'X/Twitter URL', 'oneup-motion' ), 'url' );
	oum_text_field( $options, 'footer_youtube', __( 'YouTube URL', 'oneup-motion' ), 'url' );
	oum_text_field( $options, 'footer_linkedin', __( 'LinkedIn URL', 'oneup-motion' ), 'url' );
	oum_checkbox_field( $options, 'show_footer_nav', __( 'Show Footer Navigation section', 'oneup-motion' ) );
	oum_checkbox_field( $options, 'show_footer_tools', __( 'Show Footer Tools section', 'oneup-motion' ) );
	oum_checkbox_field( $options, 'show_footer_resources', __( 'Show Footer Resources section', 'oneup-motion' ) );
	oum_checkbox_field( $options, 'show_footer_legal', __( 'Show Footer Legal section', 'oneup-motion' ) );
	oum_text_field( $options, 'footer_nav_title', __( 'Footer Navigation Title', 'oneup-motion' ) );
	oum_text_field( $options, 'footer_tools_title', __( 'Footer Tools Title', 'oneup-motion' ) );
	oum_text_field( $options, 'footer_resources_title', __( 'Footer Resources Title', 'oneup-motion' ) );
	oum_text_field( $options, 'footer_legal_title', __( 'Footer Legal Title', 'oneup-motion' ) );
	oum_text_field( $options, 'footer_copyright', __( 'Footer copyright text', 'oneup-motion' ) );
	oum_panel_close();
}

//───────────────────────────────────────
// Sections panel
//───────────────────────────────────────
function oum_render_options_panel_sections( $options ) {
	oum_panel_open( __( 'Sections', 'oneup-motion' ) );
	echo '<p>' . esc_html__( 'Use OneUp Sections as the managed page-building experience for predefined layouts.', 'oneup-motion' ) . '</p>';
	oum_checkbox_field( $options, 'use_sections_for_pages', __( 'Use OneUp Sections as the page editor', 'oneup-motion' ) );
	oum_checkbox_field( $options, 'hide_page_content_editor', __( 'Hide default page content editor', 'oneup-motion' ) );
	oum_checkbox_field( $options, 'enable_post_sections', __( 'Enable OneUp Sections on posts', 'oneup-motion' ) );
	oum_checkbox_field( $options, 'replace_post_editor_with_sections', __( 'Replace post editor with sections', 'oneup-motion' ) );
	oum_panel_close();
}

//───────────────────────────────────────
// Advanced panel
//───────────────────────────────────────
function oum_render_options_panel_advanced( $options ) {
	oum_panel_open( __( 'Advanced', 'oneup-motion' ) );
	echo '<p>' . esc_html__( 'Developer and fallback settings will live here as the theme grows. No destructive reset is implemented.', 'oneup-motion' ) . '</p>';
	oum_panel_close();
}

//───────────────────────────────────────
// Frontend CSS variables
//───────────────────────────────────────
function oum_output_theme_css_variables() {
	$options = wp_parse_args( get_option( 'oum_theme_options', array() ), oum_theme_option_defaults() );
	$fonts   = oum_font_choices();

	$vars = array(
		'--oum-bg'             => $options['bg'],
		'--oum-bg-soft'        => $options['bg_soft'],
		'--oum-navy'           => $options['navy'],
		'--oum-card'           => $options['card'],
		'--oum-card-border'    => $options['card_border'],
		'--oum-text'           => $options['text'],
		'--oum-muted'          => $options['muted'],
		'--oum-soft-muted'     => $options['soft_muted'],
		'--oum-mint'           => $options['mint'],
		'--oum-mint-dark'      => $options['mint_dark'],
		'--oum-button-bg'      => $options['button_bg'],
		'--oum-button-text'    => $options['button_text'],
		'--oum-header-bg'      => $options['header_bg'],
		'--oum-footer-bg'      => $options['footer_bg'],
		'--oum-heading-font'   => $fonts[ $options['heading_font'] ]['stack'] ?? $fonts['rounded']['stack'],
		'--oum-body-font'      => $fonts[ $options['body_font'] ]['stack'] ?? $fonts['rounded']['stack'],
		'--oum-button-font'    => $fonts[ $options['button_font'] ]['stack'] ?? $fonts['rounded']['stack'],
		'--oum-heading-weight' => $options['heading_weight'],
		'--oum-body-weight'    => $options['body_weight'],
		'--oum-button-weight'  => $options['button_weight'],
		'--oum-heading-spacing'=> $options['heading_spacing'],
		'--oum-body-spacing'   => $options['body_spacing'],
		'--oum-button-spacing' => $options['button_spacing'],
		'--oum-base-font-size' => absint( $options['base_font_size'] ) . 'px',
		'--oum-button-font-size'=> absint( $options['button_font_size'] ) . 'px',
		'--oum-button-radius'  => absint( $options['button_radius'] ) . 'px',
		'--oum-button-transform'=> $options['button_transform'],
		'--oum-header-logo-max-width' => absint( $options['header_logo_max_width'] ) . 'px',
		'--oum-header-logo-max-height'=> absint( $options['header_logo_max_height'] ) . 'px',
		'--oum-footer-logo-max-width' => absint( $options['footer_logo_max_width'] ) . 'px',
		'--oum-footer-logo-max-height'=> absint( $options['footer_logo_max_height'] ) . 'px',
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

	if ( '1' === $options['button_shadow'] ) {
		$classes[] = 'oum-button-shadow';
	}
	if ( '1' === $options['button_hover_lift'] ) {
		$classes[] = 'oum-button-hover-lift';
	}
	if ( '1' === $options['button_arrow'] ) {
		$classes[] = 'oum-button-arrow';
	}
	if ( '1' === $options['sticky_header'] ) {
		$classes[] = 'oum-sticky-header';
	}
	if ( '1' === $options['transparent_header'] ) {
		$classes[] = 'oum-transparent-header';
	}

	return $classes;
}
add_filter( 'body_class', 'oum_theme_option_body_classes' );
