<?php
/**
 * OneUp Sections text image.
 *
 * @package OneUpMotion
 */

$section  = $args['section'] ?? array();
$position = oum_section_field( $section, 'image_position', 'right' );
$image_id = absint( oum_section_field( $section, 'image_id', 0 ) );
?>
<section class="oum-section oum-section-text-image oum-image-<?php echo esc_attr( $position ); ?> section">
	<div class="section__inner oum-section-text-image__inner">
		<div class="oum-section-text-image__content">
			<?php if ( oum_section_field( $section, 'eyebrow' ) ) : ?><p class="eyebrow"><?php echo esc_html( oum_section_field( $section, 'eyebrow' ) ); ?></p><?php endif; ?>
			<?php if ( oum_section_field( $section, 'heading' ) ) : ?><h2><?php echo esc_html( oum_section_field( $section, 'heading' ) ); ?></h2><?php endif; ?>
			<?php if ( oum_section_field( $section, 'text' ) ) : ?><div class="oum-section__text"><?php oum_section_rich_text( oum_section_field( $section, 'text' ) ); ?></div><?php endif; ?>
			<?php if ( oum_section_field( $section, 'button_label' ) && oum_section_field( $section, 'button_url' ) ) : ?>
				<a class="button" href="<?php echo esc_url( oum_section_field( $section, 'button_url' ) ); ?>"><?php echo esc_html( oum_section_field( $section, 'button_label' ) ); ?></a>
			<?php endif; ?>
		</div>
		<div class="oum-section-text-image__media">
			<?php echo $image_id ? wp_get_attachment_image( $image_id, 'large' ) : '<div class="oum-image-placeholder" aria-hidden="true"></div>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
		</div>
	</div>
</section>
