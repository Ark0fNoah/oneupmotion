<?php
/**
 * Page template.
 *
 * @package OneUpMotion
 */

get_header();
?>

<?php
while ( have_posts() ) :
	the_post();
	if ( function_exists( 'oum_has_sections' ) && oum_has_sections( get_the_ID() ) ) :
		?>
		<main id="main" class="site-main">
			<?php oum_render_sections( get_the_ID() ); ?>
		</main>
	<?php else : ?>
		<main id="main" class="site-main content-wrap">
		<article <?php post_class( 'entry-content' ); ?>>
			<header class="entry-header">
				<h1><?php the_title(); ?></h1>
			</header>
			<?php if ( '' !== trim( get_the_content() ) ) : ?>
				<?php the_content(); ?>
			<?php elseif ( current_user_can( 'edit_post', get_the_ID() ) ) : ?>
				<div class="oum-empty-page">
					<p><?php echo esc_html__( 'This page has no sections yet.', 'oneup-motion' ); ?></p>
				</div>
			<?php endif; ?>
		</article>
		</main>
	<?php endif; ?>
<?php endwhile; ?>

<?php
get_footer();
