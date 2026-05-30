<?php
/**
 * Main template.
 *
 * @package OneUpMotion
 */

get_header();
?>
<main id="main" class="site-main content-wrap">
	<?php if ( have_posts() ) : ?>
		<div class="post-list">
			<?php while ( have_posts() ) : the_post(); ?>
				<article <?php post_class( 'entry-card' ); ?>>
					<h1 class="entry-card__title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h1>
					<div class="entry-card__excerpt"><?php the_excerpt(); ?></div>
				</article>
			<?php endwhile; ?>
		</div>
		<?php the_posts_pagination(); ?>
	<?php else : ?>
		<p><?php echo esc_html__( 'No content found yet.', 'oneup-motion' ); ?></p>
	<?php endif; ?>
</main>
<?php
get_footer();
