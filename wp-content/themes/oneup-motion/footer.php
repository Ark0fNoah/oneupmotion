<?php
/**
 * Site footer.
 *
 * @package OneUpMotion
 */
?>
<footer class="site-footer" id="contact">
	<div class="site-footer__inner">
		<div class="site-footer__brand">
			<?php oum_brand_logo(); ?>
			<p><?php echo esc_html__( 'Digital tools. Modern design. Real results.', 'oneup-motion' ); ?></p>
			<div class="site-footer__socials" aria-label="<?php echo esc_attr__( 'Social links', 'oneup-motion' ); ?>">
				<a href="#"><?php echo esc_html__( 'Instagram', 'oneup-motion' ); ?></a>
				<a href="#"><?php echo esc_html__( 'X', 'oneup-motion' ); ?></a>
				<a href="#"><?php echo esc_html__( 'YouTube', 'oneup-motion' ); ?></a>
				<a href="#"><?php echo esc_html__( 'LinkedIn', 'oneup-motion' ); ?></a>
			</div>
		</div>

		<div class="site-footer__columns">
			<nav class="site-footer__nav" aria-label="<?php echo esc_attr__( 'Footer navigation', 'oneup-motion' ); ?>">
				<h2><?php echo esc_html__( 'Navigation', 'oneup-motion' ); ?></h2>
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php echo esc_html__( 'Home', 'oneup-motion' ); ?></a>
				<a href="<?php echo esc_url( home_url( '/tools/' ) ); ?>"><?php echo esc_html__( 'Tools', 'oneup-motion' ); ?></a>
				<a href="#services"><?php echo esc_html__( 'Services', 'oneup-motion' ); ?></a>
				<a href="#about"><?php echo esc_html__( 'About', 'oneup-motion' ); ?></a>
				<a href="mailto:hello@oneupmotion.com"><?php echo esc_html__( 'Contact', 'oneup-motion' ); ?></a>
			</nav>

			<nav class="site-footer__nav" aria-label="<?php echo esc_attr__( 'Footer tools', 'oneup-motion' ); ?>">
				<h2><?php echo esc_html__( 'Tools', 'oneup-motion' ); ?></h2>
				<a href="<?php echo esc_url( home_url( '/tools/' ) ); ?>"><?php echo esc_html__( 'QR Generator', 'oneup-motion' ); ?></a>
				<a href="#"><?php echo esc_html__( 'UTM Builder', 'oneup-motion' ); ?></a>
				<a href="#"><?php echo esc_html__( 'Image Tools', 'oneup-motion' ); ?></a>
				<a href="#"><?php echo esc_html__( 'More Coming Soon', 'oneup-motion' ); ?></a>
			</nav>

			<nav class="site-footer__nav" aria-label="<?php echo esc_attr__( 'Footer resources', 'oneup-motion' ); ?>">
				<h2><?php echo esc_html__( 'Resources', 'oneup-motion' ); ?></h2>
				<a href="#"><?php echo esc_html__( 'Blog', 'oneup-motion' ); ?></a>
				<a href="#"><?php echo esc_html__( 'Help Center', 'oneup-motion' ); ?></a>
				<a href="#"><?php echo esc_html__( 'Updates', 'oneup-motion' ); ?></a>
				<a href="#"><?php echo esc_html__( 'Roadmap', 'oneup-motion' ); ?></a>
			</nav>

			<div class="site-footer__nav">
				<h2><?php echo esc_html__( 'Contact', 'oneup-motion' ); ?></h2>
				<a href="mailto:hello@oneupmotion.com"><?php echo esc_html__( 'hello@oneupmotion.com', 'oneup-motion' ); ?></a>
			</div>
		</div>

		<p class="site-footer__copyright">
			&copy; <?php echo esc_html( gmdate( 'Y' ) ); ?> <?php echo esc_html__( 'OneUp Motion. All rights reserved.', 'oneup-motion' ); ?>
		</p>
	</div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
