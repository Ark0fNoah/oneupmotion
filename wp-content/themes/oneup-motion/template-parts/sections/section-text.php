<?php
$section = $args['section'] ?? array();
$align   = oum_section_field( $section, 'alignment', 'left' );
?>
<section class="oum-section oum-section-text oum-align-<?php echo esc_attr( $align ); ?> section">
	<div class="section__inner oum-section-text__inner">
		<?php if ( oum_section_field( $section, 'eyebrow' ) ) : ?><p class="eyebrow"><?php echo esc_html( oum_section_field( $section, 'eyebrow' ) ); ?></p><?php endif; ?>
		<?php if ( oum_section_field( $section, 'heading' ) ) : ?><h2><?php echo esc_html( oum_section_field( $section, 'heading' ) ); ?></h2><?php endif; ?>
		<?php if ( oum_section_field( $section, 'text' ) ) : ?><div class="oum-section__text"><?php oum_section_rich_text( oum_section_field( $section, 'text' ) ); ?></div><?php endif; ?>
	</div>
</section>
