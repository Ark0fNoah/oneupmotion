<?php
/**
 * Single post template.
 *
 * @package OneUpMotion
 */

get_header();
?>

<?php
while ( have_posts() ) :
	the_post();
	if ( '1' === oum_get_theme_option( 'enable_post_sections', '0' ) && function_exists( 'oum_has_sections' ) && oum_has_sections( get_the_ID() ) ) :
		?>
		<main id="main" class="site-main">
			<?php oum_render_sections( get_the_ID() ); ?>
		</main>
	<?php else : ?>
		<main id="main" class="site-main content-wrap">
		<article <?php post_class( 'entry-content' ); ?>>
			<header class="entry-header">
				<p class="entry-meta">
					<?php
					printf(
						/* translators: 1: post date, 2: author name */
						esc_html__( 'Published %1$s by %2$s', 'oneup-motion' ),
						esc_html( get_the_date() ),
						esc_html( get_the_author() )
					);
					?>
				</p>
				<h1><?php the_title(); ?></h1>
			</header>
			<?php if ( has_post_thumbnail() ) : ?>
				<figure class="entry-featured-image">
					<?php the_post_thumbnail( 'large' ); ?>
				</figure>
			<?php endif; ?>
			<?php the_content(); ?>
			<footer class="entry-footer">
				<?php the_post_navigation( array(
					'prev_text' => '<span>' . esc_html__( 'Previous', 'oneup-motion' ) . '</span> %title',
					'next_text' => '<span>' . esc_html__( 'Next', 'oneup-motion' ) . '</span> %title',
				) ); ?>
			</footer>
		</article>
		</main>
	<?php endif; ?>
<?php endwhile; ?>

<?php
get_footer();
