<?php
/**
 * OneUp Sections feature grid.
 *
 * @package OneUpMotion
 */

$section = $args['section'] ?? array();
$items   = isset( $section['items'] ) && is_array( $section['items'] ) ? $section['items'] : array();
?>
<section<?php echo oum_section_anchor_attr( $section ); ?> class="<?php echo esc_attr( oum_section_classes( $section, 'oum-section services' ) ); ?>">
	<div class="section__inner">
		<div class="section__header">
			<div>
				<?php if ( oum_section_field( $section, 'eyebrow' ) ) : ?><p class="eyebrow"><?php echo esc_html( oum_section_field( $section, 'eyebrow' ) ); ?></p><?php endif; ?>
				<?php if ( oum_section_field( $section, 'heading' ) ) : ?><h2><?php oum_section_heading_with_highlight( oum_section_field( $section, 'heading' ), oum_section_field( $section, 'highlighted_word' ) ); ?></h2><?php endif; ?>
			</div>
			<?php if ( oum_section_field( $section, 'text' ) ) : ?><div class="oum-section__text"><?php oum_section_rich_text( oum_section_field( $section, 'text' ) ); ?></div><?php endif; ?>
		</div>
		<div class="service-grid oum-card-grid--<?php echo esc_attr( oum_section_field( $section, 'columns', '4' ) ); ?>">
			<?php foreach ( $items as $item ) : ?>
				<article class="service-card">
					<?php oum_section_icon( $item, 'service-card__icon' ); ?>
					<h3><?php echo esc_html( $item['title'] ?? '' ); ?></h3>
					<p><?php echo esc_html( $item['text'] ?? '' ); ?></p>
					<?php if ( ! empty( $item['url'] ) && ! empty( $item['button_label'] ) ) : ?><a class="tool-card__button" href="<?php echo esc_url( $item['url'] ); ?>"><?php echo esc_html( $item['button_label'] ); ?></a><?php endif; ?>
				</article>
			<?php endforeach; ?>
		</div>
	</div>
</section>
