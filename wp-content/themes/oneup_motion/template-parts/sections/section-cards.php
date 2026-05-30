<?php
/**
 * OneUp Sections cards.
 *
 * @package OneUpMotion
 */

$section = $args['section'] ?? array();
$cards   = isset( $section['cards'] ) && is_array( $section['cards'] ) ? $section['cards'] : array();
$layout  = oum_section_field( $section, 'layout', '3' );
?>
<section<?php echo oum_section_anchor_attr( $section ); ?> class="<?php echo esc_attr( oum_section_classes( $section, 'oum-section oum-section-cards' ) ); ?>">
	<div class="section__inner">
		<div class="section__header">
			<div>
				<?php if ( oum_section_field( $section, 'eyebrow' ) ) : ?><p class="eyebrow"><?php echo esc_html( oum_section_field( $section, 'eyebrow' ) ); ?></p><?php endif; ?>
				<?php if ( oum_section_field( $section, 'heading' ) ) : ?><h2><?php echo esc_html( oum_section_field( $section, 'heading' ) ); ?></h2><?php endif; ?>
			</div>
			<?php if ( oum_section_field( $section, 'text' ) ) : ?><div class="oum-section__text"><?php oum_section_rich_text( oum_section_field( $section, 'text' ) ); ?></div><?php endif; ?>
		</div>
		<div class="oum-card-grid oum-card-grid--<?php echo esc_attr( $layout ); ?>">
			<?php foreach ( $cards as $card ) : ?>
				<article class="tool-card">
					<?php oum_section_icon( $card, 'tool-card__icon' ); ?>
					<h3><?php echo esc_html( $card['title'] ?? '' ); ?></h3>
					<p><?php echo esc_html( $card['text'] ?? '' ); ?></p>
					<?php if ( ! empty( $card['button_label'] ) && ! empty( $card['button_url'] ) ) : ?>
						<a class="tool-card__button" href="<?php echo esc_url( $card['button_url'] ); ?>"><?php echo esc_html( $card['button_label'] ); ?></a>
					<?php endif; ?>
				</article>
			<?php endforeach; ?>
		</div>
	</div>
</section>
