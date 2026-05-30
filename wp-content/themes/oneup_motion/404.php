<?php
/**
 * 404 template.
 *
 * @package OneUpMotion
 */

get_header();
?>
<main id="main" class="site-main content-wrap not-found">
	<h1><?php echo esc_html__( 'Page not found', 'oneup-motion' ); ?></h1>
	<p><?php echo esc_html__( 'The page you are looking for may have moved. Try heading back home.', 'oneup-motion' ); ?></p>
	<a class="button" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php echo esc_html__( 'Back to Home', 'oneup-motion' ); ?></a>
</main>
<?php
get_footer();
