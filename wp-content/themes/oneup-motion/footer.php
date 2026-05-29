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
			<p><?php echo esc_html__( 'Digital tools, design systems and web experiences that help ideas move with purpose.', 'oneup-motion' ); ?></p>
		</div>
		<nav class="site-footer__nav" aria-label="<?php echo esc_attr__( 'Footer navigation', 'oneup-motion' ); ?>">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php echo esc_html__( 'Home', 'oneup-motion' ); ?></a>
			<a href="<?php echo esc_url( home_url( '/tools/' ) ); ?>"><?php echo esc_html__( 'Tools', 'oneup-motion' ); ?></a>
			<a href="#services"><?php echo esc_html__( 'Services', 'oneup-motion' ); ?></a>
			<a href="#about"><?php echo esc_html__( 'About', 'oneup-motion' ); ?></a>
			<a href="mailto:hello@oneupmotion.com"><?php echo esc_html__( 'Contact', 'oneup-motion' ); ?></a>
		</nav>
		<p class="site-footer__copyright">&copy; <?php echo esc_html( gmdate( 'Y' ) ); ?> <?php echo esc_html__( 'OneUp Motion. All rights reserved.', 'oneup-motion' ); ?></p>
	</div>
</footer>
<?php wp_footer(); ?>
</body>
</html>
