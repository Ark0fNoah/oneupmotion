<?php
/**
 * OneUp Sections preview boxes.
 *
 * @package OneUpMotion
 */

$section = $args['section'] ?? array();
$boxes   = isset( $section['boxes'] ) && is_array( $section['boxes'] ) ? $section['boxes'] : array();
$layout  = oum_section_field( $section, 'layout', 'auto' );
?>
<section<?php echo oum_section_anchor_attr( $section ); ?> class="<?php echo esc_attr( oum_section_classes( $section, 'oum-section oum-preview-boxes' ) ); ?>">
	<div class="section__inner">
		<div class="section__header">
			<div>
				<?php if ( oum_section_field( $section, 'eyebrow' ) ) : ?><p class="eyebrow"><?php echo esc_html( oum_section_field( $section, 'eyebrow' ) ); ?></p><?php endif; ?>
				<?php if ( oum_section_field( $section, 'heading' ) ) : ?><h2><?php oum_section_heading_with_highlight( oum_section_field( $section, 'heading' ), oum_section_field( $section, 'highlighted_word' ) ); ?></h2><?php endif; ?>
			</div>
			<?php if ( oum_section_field( $section, 'text' ) ) : ?><div class="oum-section__text"><?php oum_section_rich_text( oum_section_field( $section, 'text' ) ); ?></div><?php endif; ?>
			<?php if ( oum_section_field( $section, 'button_label' ) && oum_section_field( $section, 'button_url' ) ) : ?><a class="button button--ghost" href="<?php echo esc_url( oum_section_field( $section, 'button_url' ) ); ?>"><?php echo esc_html( oum_section_field( $section, 'button_label' ) ); ?></a><?php endif; ?>
		</div>
		<div class="tool-grid oum-preview-grid oum-preview-grid--<?php echo esc_attr( $layout ); ?> oum-card-style--<?php echo esc_attr( oum_section_field( $section, 'card_style', 'glass' ) ); ?>">
			<?php foreach ( $boxes as $index => $box ) : ?>
				<?php $status = sanitize_html_class( $box['status'] ?? 'normal' ); ?>
				<article class="tool-card tool-card--<?php echo esc_attr( $status ); ?> <?php echo 0 === $index && '1' === oum_section_field( $section, 'highlight_first_card', '0' ) ? 'tool-card--available' : ''; ?>">
					<?php if ( ! empty( $box['badge'] ) && '1' === oum_section_field( $section, 'show_badges', '1' ) ) : ?><div class="tool-card__status"><?php echo esc_html( $box['badge'] ); ?></div><?php endif; ?>
					<?php if ( ! empty( $box['icon_image_id'] ) ) : ?>
						<div class="tool-card__icon tool-card__icon--image"><?php echo wp_get_attachment_image( absint( $box['icon_image_id'] ), 'thumbnail' ); ?></div>
					<?php elseif ( ! empty( $box['icon_text'] ) ) : ?>
						<div class="tool-card__icon"><?php echo esc_html( $box['icon_text'] ); ?></div>
					<?php endif; ?>
					<h3><?php echo esc_html( $box['title'] ?? '' ); ?></h3>
					<p><?php echo esc_html( $box['text'] ?? '' ); ?></p>
					<?php if ( '1' === oum_section_field( $section, 'show_card_buttons', '1' ) && ! empty( $box['button_label'] ) && ! empty( $box['button_url'] ) ) : ?>
						<a class="tool-card__button" href="<?php echo esc_url( $box['button_url'] ); ?>" <?php echo ! empty( $box['new_tab'] ) ? 'target="_blank" rel="noopener noreferrer"' : ''; ?>><?php echo esc_html( $box['button_label'] ); ?></a>
					<?php endif; ?>
				</article>
			<?php endforeach; ?>
		</div>
	</div>
</section>
