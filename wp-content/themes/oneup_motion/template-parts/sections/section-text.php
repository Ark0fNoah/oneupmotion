<?php
/**
 * OneUp Sections text.
 *
 * @package OneUpMotion
 */

$section = $args['section'] ?? array();
$align   = oum_section_field( $section, 'alignment', 'left' );
?>
<section<?php echo oum_section_anchor_attr( $section ); ?> class="<?php echo esc_attr( oum_section_classes( $section, 'oum-section oum-section-text' ) ); ?> oum-align-<?php echo esc_attr( $align ); ?>">
	<div class="section__inner oum-section-text__inner">
		<?php if ( oum_section_field( $section, 'eyebrow' ) ) : ?>
			<p class="eyebrow"><?php echo esc_html( oum_section_field( $section, 'eyebrow' ) ); ?></p>
		<?php endif; ?>
		<?php if ( oum_section_field( $section, 'heading' ) ) : ?>
			<h2><?php oum_section_heading_with_highlight( oum_section_field( $section, 'heading' ), oum_section_field( $section, 'highlighted_word' ) ); ?></h2>
		<?php endif; ?>
		<?php if ( oum_section_field( $section, 'text' ) ) : ?>
			<div class="oum-section__text"><?php oum_section_rich_text( oum_section_field( $section, 'text' ) ); ?></div>
		<?php endif; ?>
		<?php if ( oum_section_field( $section, 'button_label' ) && oum_section_field( $section, 'button_url' ) ) : ?>
			<a class="button" href="<?php echo esc_url( oum_section_field( $section, 'button_url' ) ); ?>"><?php echo esc_html( oum_section_field( $section, 'button_label' ) ); ?></a>
		<?php endif; ?>
	</div>
</section>
