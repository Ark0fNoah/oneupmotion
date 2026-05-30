<?php
/**
 * Helper functions for OneUp Motion.
 *
 * @package OneUpMotion
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

//───────────────────────────────────────
// Asset version helper
//───────────────────────────────────────
function oum_asset_version( $relative_path ) {
	$path = get_template_directory() . '/' . ltrim( $relative_path, '/' );

	return file_exists( $path ) ? (string) filemtime( $path ) : wp_get_theme()->get( 'Version' );
}

//───────────────────────────────────────
// Tools archive URL helper
//───────────────────────────────────────
function oum_tools_url() {
	$category = get_category_by_slug( 'tools' );

	if ( $category && ! is_wp_error( $category ) ) {
		$link = get_category_link( $category );

		if ( ! is_wp_error( $link ) ) {
			return $link;
		}
	}

	$page = get_page_by_path( 'tools' );

	if ( $page instanceof WP_Post ) {
		return get_permalink( $page );
	}

	return home_url( '/tools/' );
}

//───────────────────────────────────────
// Brand logo helper
//───────────────────────────────────────
function oum_brand_logo() {
	$logo_id    = function_exists( 'oum_get_theme_option' ) ? absint( oum_get_theme_option( 'main_logo_id', 0 ) ) : 0;
	$brand_name = function_exists( 'oum_get_theme_option' ) ? oum_get_theme_option( 'brand_name', get_bloginfo( 'name' ) ) : get_bloginfo( 'name' );

	if ( $logo_id ) {
		echo '<a class="custom-logo-link" href="' . esc_url( home_url( '/' ) ) . '" rel="home">' . wp_get_attachment_image( $logo_id, 'full', false, array( 'class' => 'custom-logo', 'alt' => esc_attr( $brand_name ) ) ) . '</a>';
		return;
	}

	if ( function_exists( 'the_custom_logo' ) && has_custom_logo() ) {
		the_custom_logo();
		return;
	}
	?>
	<a class="site-branding__link site-branding__link--image-fallback" href="<?php echo esc_url( home_url( '/' ) ); ?>" aria-label="<?php echo esc_attr__( 'OneUp Motion home', 'oneup-motion' ); ?>">
		<img class="site-branding__fallback-logo" src="<?php echo esc_url( get_template_directory_uri() . '/assets/img/oneup-motion-logo-horizontal-white-color.png' ); ?>" alt="<?php echo esc_attr( $brand_name ); ?>">
	</a>
	<?php
}

//───────────────────────────────────────
// Footer logo helper
//───────────────────────────────────────
function oum_footer_logo() {
	$logo_id    = function_exists( 'oum_get_theme_option' ) ? absint( oum_get_theme_option( 'footer_logo_id', 0 ) ) : 0;
	$brand_name = function_exists( 'oum_get_theme_option' ) ? oum_get_theme_option( 'footer_brand_text', get_bloginfo( 'name' ) ) : get_bloginfo( 'name' );

	if ( $logo_id ) {
		echo '<a class="custom-logo-link" href="' . esc_url( home_url( '/' ) ) . '" rel="home">' . wp_get_attachment_image( $logo_id, 'full', false, array( 'class' => 'custom-logo', 'alt' => esc_attr( $brand_name ) ) ) . '</a>';
		return;
	}

	?>
	<a class="site-branding__link site-branding__link--image-fallback" href="<?php echo esc_url( home_url( '/' ) ); ?>" aria-label="<?php echo esc_attr__( 'OneUp Motion home', 'oneup-motion' ); ?>">
		<img class="site-branding__fallback-logo" src="<?php echo esc_url( get_template_directory_uri() . '/assets/img/oneup-motion-logo-horizontal-white-color.png' ); ?>" alt="<?php echo esc_attr( $brand_name ); ?>">
	</a>
	<?php
}

//───────────────────────────────────────
// Footer menu helper
//───────────────────────────────────────
function oum_footer_menu( $location, $title, $fallback = '' ) {
	?>
	<nav class="site-footer__nav" aria-label="<?php echo esc_attr( $title ); ?>">
		<h2><?php echo esc_html( $title ); ?></h2>
		<?php
		if ( has_nav_menu( $location ) ) {
			wp_nav_menu( array(
				'theme_location' => $location,
				'container'      => false,
				'menu_class'     => 'site-footer__menu',
				'fallback_cb'    => false,
				'depth'          => 1,
			) );
		} elseif ( $fallback ) {
			echo '<p class="site-footer__fallback">' . esc_html( $fallback ) . '</p>';
		}
		?>
	</nav>
	<?php
}

//───────────────────────────────────────
// Safe SVG allowlist
//───────────────────────────────────────
function oum_allowed_svg_tags() {
	return array(
		'svg'      => array(
			'class'       => true,
			'xmlns'       => true,
			'width'       => true,
			'height'      => true,
			'viewbox'     => true,
			'viewBox'     => true,
			'fill'        => true,
			'stroke'      => true,
			'stroke-width'=> true,
			'aria-hidden' => true,
			'role'        => true,
			'focusable'   => true,
		),
		'g'        => array(
			'class'       => true,
			'fill'        => true,
			'stroke'      => true,
			'stroke-width'=> true,
			'clip-path'   => true,
			'transform'   => true,
			'opacity'     => true,
		),
		'path'     => array(
			'class'           => true,
			'd'               => true,
			'fill'            => true,
			'stroke'          => true,
			'stroke-width'    => true,
			'stroke-linecap'  => true,
			'stroke-linejoin' => true,
			'fill-rule'       => true,
			'clip-rule'       => true,
			'opacity'         => true,
			'transform'       => true,
		),
		'circle'   => array(
			'class'        => true,
			'cx'           => true,
			'cy'           => true,
			'r'            => true,
			'fill'         => true,
			'stroke'       => true,
			'stroke-width' => true,
			'opacity'      => true,
		),
		'rect'     => array(
			'class'        => true,
			'x'            => true,
			'y'            => true,
			'rx'           => true,
			'ry'           => true,
			'width'        => true,
			'height'       => true,
			'fill'         => true,
			'stroke'       => true,
			'stroke-width' => true,
			'opacity'      => true,
			'transform'    => true,
		),
		'line'     => array(
			'class'           => true,
			'x1'              => true,
			'y1'              => true,
			'x2'              => true,
			'y2'              => true,
			'stroke'          => true,
			'stroke-width'    => true,
			'stroke-linecap'  => true,
			'opacity'         => true,
		),
		'polyline' => array(
			'class'           => true,
			'points'          => true,
			'fill'            => true,
			'stroke'          => true,
			'stroke-width'    => true,
			'stroke-linecap'  => true,
			'stroke-linejoin' => true,
			'opacity'         => true,
		),
		'polygon'  => array(
			'class'           => true,
			'points'          => true,
			'fill'            => true,
			'stroke'          => true,
			'stroke-width'    => true,
			'stroke-linejoin' => true,
			'opacity'         => true,
		),
		'title'    => array(),
		'desc'     => array(),
		'defs'     => array(),
		'clipPath' => array( 'id' => true ),
		'use'      => array(
			'href'       => true,
			'xlink:href' => true,
			'x'          => true,
			'y'          => true,
			'fill'       => true,
		),
	);
}

//───────────────────────────────────────
// Safe SVG sanitizer
//───────────────────────────────────────
function oum_sanitize_svg_code( $svg ) {
	$svg = (string) $svg;

	if ( '' === trim( $svg ) ) {
		return '';
	}

	$svg = preg_replace( '#<script(.*?)>(.*?)</script>#is', '', $svg );
	$svg = preg_replace( '/\son[a-z]+\s*=\s*(["\']).*?\1/i', '', $svg );
	$svg = preg_replace( '/\s(href|xlink:href)\s*=\s*(["\'])\s*javascript:.*?\2/i', '', $svg );

	return wp_kses( $svg, oum_allowed_svg_tags() );
}
