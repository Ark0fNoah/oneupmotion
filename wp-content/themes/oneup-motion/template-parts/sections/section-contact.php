<?php
$section = $args['section'] ?? array();
?>
<section class="oum-section oum-section-contact section">
	<div class="section__inner oum-contact-card">
		<div>
			<?php if ( oum_section_field( $section, 'eyebrow' ) ) : ?><p class="eyebrow"><?php echo esc_html( oum_section_field( $section, 'eyebrow' ) ); ?></p><?php endif; ?>
			<?php if ( oum_section_field( $section, 'heading' ) ) : ?><h2><?php echo esc_html( oum_section_field( $section, 'heading' ) ); ?></h2><?php endif; ?>
			<?php if ( oum_section_field( $section, 'text' ) ) : ?><div class="oum-section__text"><?php oum_section_rich_text( oum_section_field( $section, 'text' ) ); ?></div><?php endif; ?>
		</div>
		<div class="oum-contact-card__links">
			<?php if ( oum_section_field( $section, 'email' ) ) : ?><a href="mailto:<?php echo esc_attr( oum_section_field( $section, 'email' ) ); ?>"><?php echo esc_html( oum_section_field( $section, 'email' ) ); ?></a><?php endif; ?>
			<?php if ( oum_section_field( $section, 'phone' ) ) : ?><a href="tel:<?php echo esc_attr( preg_replace( '/[^0-9+]/', '', oum_section_field( $section, 'phone' ) ) ); ?>"><?php echo esc_html( oum_section_field( $section, 'phone' ) ); ?></a><?php endif; ?>
			<?php if ( oum_section_field( $section, 'button_label' ) && oum_section_field( $section, 'button_url' ) ) : ?><a class="button" href="<?php echo esc_url( oum_section_field( $section, 'button_url' ) ); ?>"><?php echo esc_html( oum_section_field( $section, 'button_label' ) ); ?></a><?php endif; ?>
		</div>
	</div>
</section>
