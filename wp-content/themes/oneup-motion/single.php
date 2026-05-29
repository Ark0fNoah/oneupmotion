<?php
/**
 * Single post template.
 *
 * @package OneUpMotion
 */

get_header();
?>
<main id="main" class="site-main content-wrap">
	<?php while ( have_posts() ) : the_post(); ?>
		<article <?php post_class( 'entry-content' ); ?>>
			<header class="entry-header">
				<p class="entry-meta"><?php echo esc_html( get_the_date() ); ?></p>
				<h1><?php the_title(); ?></h1>
			</header>
			<?php the_content(); ?>
		</article>
	<?php endwhile; ?>
</main>
<?php
get_footer();
