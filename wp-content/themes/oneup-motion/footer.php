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
			<?php oum_footer_logo(); ?>
			<p><?php echo esc_html( oum_get_theme_option( 'footer_description', __( 'Digital tools. Modern design. Real results.', 'oneup-motion' ) ) ); ?></p>
			<div class="site-footer__socials" aria-label="<?php echo esc_attr__( 'Social links', 'oneup-motion' ); ?>">
				<?php
				$oum_socials = array(
					'footer_instagram' => __( 'Instagram', 'oneup-motion' ),
					'footer_x'         => __( 'X', 'oneup-motion' ),
					'footer_youtube'   => __( 'YouTube', 'oneup-motion' ),
					'footer_linkedin'  => __( 'LinkedIn', 'oneup-motion' ),
				);
				foreach ( $oum_socials as $oum_key => $oum_label ) :
					$oum_url = oum_get_theme_option( $oum_key, '' );
					if ( ! $oum_url ) {
						continue;
					}
					?>
					<a href="<?php echo esc_url( $oum_url ); ?>"><?php echo esc_html( $oum_label ); ?></a>
				<?php endforeach; ?>
			</div>
			<?php if ( oum_get_theme_option( 'footer_email', '' ) ) : ?>
				<a class="site-footer__email" href="mailto:<?php echo esc_attr( oum_get_theme_option( 'footer_email', '' ) ); ?>"><?php echo esc_html( oum_get_theme_option( 'footer_email', '' ) ); ?></a>
			<?php endif; ?>
		</div>

		<div class="site-footer__columns">
			<?php
			oum_footer_menu( 'footer_nav', oum_get_theme_option( 'footer_nav_title', __( 'Navigation', 'oneup-motion' ) ), __( 'Assign a Footer Navigation menu in Appearance > Menus.', 'oneup-motion' ) );
			oum_footer_menu( 'footer_tools', oum_get_theme_option( 'footer_tools_title', __( 'Tools', 'oneup-motion' ) ), __( 'Assign a Footer Tools menu in Appearance > Menus.', 'oneup-motion' ) );
			oum_footer_menu( 'footer_resources', oum_get_theme_option( 'footer_resources_title', __( 'Resources', 'oneup-motion' ) ), __( 'Assign a Footer Resources menu in Appearance > Menus.', 'oneup-motion' ) );
			oum_footer_menu( 'footer_legal', oum_get_theme_option( 'footer_legal_title', __( 'Legal', 'oneup-motion' ) ), __( 'Assign a Footer Legal menu in Appearance > Menus.', 'oneup-motion' ) );
			?>
		</div>

		<p class="site-footer__copyright">
			&copy; <?php echo esc_html( gmdate( 'Y' ) ); ?> <?php echo esc_html( oum_get_theme_option( 'footer_copyright', __( 'OneUp Motion. All rights reserved.', 'oneup-motion' ) ) ); ?>
		</p>
	</div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
