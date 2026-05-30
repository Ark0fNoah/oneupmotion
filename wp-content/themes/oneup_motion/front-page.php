<?php
/**
 * Front page template.
 *
 * @package OneUpMotion
 */

get_header();
?>

<main id="main" class="site-main">
	<?php
	if ( have_posts() ) {
		the_post();
	}

	if ( function_exists( 'oum_has_sections' ) && oum_has_sections( get_the_ID() ) ) {
		oum_render_sections( get_the_ID() );
	} else {
		get_template_part( 'template-parts/hero' );
		get_template_part( 'template-parts/section-tools-preview' );
		get_template_part( 'template-parts/section-services' );
		get_template_part( 'template-parts/section-about' );
		get_template_part( 'template-parts/section-cta' );
	}
	?>
</main>

<?php
get_footer();
