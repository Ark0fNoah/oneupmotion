<?php
/**
 * OneUp Sections logo strip.
 *
 * @package OneUpMotion
 */

$section = $args['section'] ?? array();
$items   = isset( $section['items'] ) && is_array( $section['items'] ) ? $section['items'] : array();
?>
<section<?php echo oum_section_anchor_attr( $section ); ?> class="<?php echo esc_attr( oum_section_classes( $section, 'oum-section trust-strip' ) ); ?>">
	<div class="trust-strip__inner section__inner">
		<?php if ( oum_section_field( $section, 'eyebrow' ) ) : ?><p><?php echo esc_html( oum_section_field( $section, 'eyebrow' ) ); ?></p><?php endif; ?>
		<?php if ( oum_section_field( $section, 'text' ) ) : ?><div class="oum-section__text"><?php oum_section_rich_text( oum_section_field( $section, 'text' ) ); ?></div><?php endif; ?>
		<div class="trust-strip__logos">
			<?php foreach ( $items as $item ) : ?>
				<?php $name = $item['name'] ?? ''; ?>
				<?php if ( ! empty( $item['url'] ) ) : ?><a href="<?php echo esc_url( $item['url'] ); ?>"><?php echo esc_html( $name ); ?></a><?php else : ?><span><?php echo esc_html( $name ); ?></span><?php endif; ?>
			<?php endforeach; ?>
		</div>
	</div>
</section>
