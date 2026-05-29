<?php
$section = $args['section'] ?? array();
$style   = oum_section_field( $section, 'style', 'normal' );
?>
<section class="oum-section cta section oum-cta--<?php echo esc_attr( $style ); ?>">
	<div class="cta__inner section__inner">
		<div class="cta__mark" aria-hidden="true">1</div>
		<div class="cta__content">
			<?php if ( oum_section_field( $section, 'heading' ) ) : ?><h2><?php echo esc_html( oum_section_field( $section, 'heading' ) ); ?></h2><?php endif; ?>
			<?php if ( oum_section_field( $section, 'text' ) ) : ?><p><?php echo esc_html( oum_section_field( $section, 'text' ) ); ?></p><?php endif; ?>
		</div>
		<?php if ( oum_section_field( $section, 'button_label' ) && oum_section_field( $section, 'button_url' ) ) : ?><a class="button" href="<?php echo esc_url( oum_section_field( $section, 'button_url' ) ); ?>"><?php echo esc_html( oum_section_field( $section, 'button_label' ) ); ?></a><?php endif; ?>
	</div>
</section>
