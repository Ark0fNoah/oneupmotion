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
	<a class="site-branding__link" href="<?php echo esc_url( home_url( '/' ) ); ?>" aria-label="<?php echo esc_attr__( 'OneUp Motion home', 'oneup-motion' ); ?>">
		<span class="site-branding__mark" aria-hidden="true">1</span>
		<span class="site-branding__name"><?php echo esc_html( $brand_name ); ?></span>
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
	<a class="site-branding__link" href="<?php echo esc_url( home_url( '/' ) ); ?>" aria-label="<?php echo esc_attr__( 'OneUp Motion home', 'oneup-motion' ); ?>">
		<span class="site-branding__mark" aria-hidden="true">1</span>
		<span class="site-branding__name"><?php echo esc_html( $brand_name ); ?></span>
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
