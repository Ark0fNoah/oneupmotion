<?php
/**
 * Archive template.
 *
 * @package OneUpMotion
 */

get_header();
?>
<main id="main" class="site-main content-wrap">
	<header class="archive-header">
		<h1><?php the_archive_title(); ?></h1>
		<?php the_archive_description( '<div class="archive-description">', '</div>' ); ?>
	</header>
	<?php if ( have_posts() ) : ?>
		<div class="post-list">
			<?php while ( have_posts() ) : the_post(); ?>
				<article <?php post_class( 'entry-card' ); ?>>
					<h2 class="entry-card__title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
					<div class="entry-card__excerpt"><?php the_excerpt(); ?></div>
				</article>
			<?php endwhile; ?>
		</div>
		<?php the_posts_pagination(); ?>
	<?php endif; ?>
</main>
<?php
get_footer();
