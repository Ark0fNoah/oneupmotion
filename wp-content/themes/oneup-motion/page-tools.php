<?php
/**
 * Template Name: Tools
 *
 * @package OneUpMotion
 */

get_header();
?>
<main id="main" class="site-main content-wrap">
	<article <?php post_class( 'entry-content tools-page' ); ?>>
		<header class="entry-header">
			<p class="eyebrow"><?php echo esc_html__( 'OneUp Tools', 'oneup-motion' ); ?></p>
			<h1><?php echo esc_html__( 'Tools built to make creation easier.', 'oneup-motion' ); ?></h1>
			<p><?php echo esc_html__( 'Start with the QR Generator. More practical creative utilities are on the way.', 'oneup-motion' ); ?></p>
		</header>
		<?php
		while ( have_posts() ) :
			the_post();
			the_content();

			if ( ! has_shortcode( get_the_content(), 'oneup_qr_generator' ) ) {
				echo do_shortcode( '[oneup_qr_generator]' );
			}
		endwhile;
		?>
	</article>
</main>
<?php
get_footer();
