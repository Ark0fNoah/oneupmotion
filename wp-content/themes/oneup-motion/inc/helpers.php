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
	if ( function_exists( 'the_custom_logo' ) && has_custom_logo() ) {
		the_custom_logo();
		return;
	}
	?>
	<a class="site-branding__link" href="<?php echo esc_url( home_url( '/' ) ); ?>" aria-label="<?php echo esc_attr__( 'OneUp Motion home', 'oneup-motion' ); ?>">
		<span class="site-branding__mark" aria-hidden="true">1</span>
		<span class="site-branding__name"><?php echo esc_html__( 'OneUp Motion', 'oneup-motion' ); ?></span>
	</a>
	<?php
}
