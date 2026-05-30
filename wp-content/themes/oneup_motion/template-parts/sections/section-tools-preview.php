<?php
/**
 * OneUp Sections tools/preview boxes.
 *
 * @package OneUpMotion
 */

$section = $args['section'] ?? array();
$items   = isset( $section['items'] ) && is_array( $section['items'] ) ? $section['items'] : array();
$tools   = array(
	'qr'    => array( 'title' => __( 'QR Generator', 'oneup-motion' ), 'text' => __( 'Create custom QR codes with colors, borders, logos and unique styles.', 'oneup-motion' ), 'status' => 'available', 'badge' => __( 'Active tool', 'oneup-motion' ) ),
	'utm'   => array( 'title' => __( 'UTM Builder', 'oneup-motion' ), 'text' => __( 'Build clean campaign links without messy spreadsheets.', 'oneup-motion' ), 'status' => 'coming-soon', 'badge' => __( 'Coming soon', 'oneup-motion' ) ),
	'image' => array( 'title' => __( 'Image Tools', 'oneup-motion' ), 'text' => __( 'Simple visual utilities for creators, marketers and designers.', 'oneup-motion' ), 'status' => 'coming-soon', 'badge' => __( 'Coming soon', 'oneup-motion' ) ),
);
?>
<section<?php echo oum_section_anchor_attr( $section ); ?> class="<?php echo esc_attr( oum_section_classes( $section, 'oum-section tools-preview' ) ); ?>">
	<div class="tools-preview__inner section__inner">
		<div class="section__header section__header--stacked">
			<?php if ( oum_section_field( $section, 'eyebrow' ) ) : ?><p class="eyebrow"><?php echo esc_html( oum_section_field( $section, 'eyebrow' ) ); ?></p><?php endif; ?>
			<?php if ( oum_section_field( $section, 'heading' ) ) : ?><h2><?php oum_section_heading_with_highlight( oum_section_field( $section, 'heading' ), oum_section_field( $section, 'highlighted_word' ) ); ?></h2><?php endif; ?>
			<?php if ( oum_section_field( $section, 'text' ) ) : ?><div class="oum-section__text"><?php oum_section_rich_text( oum_section_field( $section, 'text' ) ); ?></div><?php endif; ?>
			<?php if ( oum_section_field( $section, 'button_label' ) && oum_section_field( $section, 'button_url' ) ) : ?><a class="button button--ghost" href="<?php echo esc_url( oum_section_field( $section, 'button_url' ) ); ?>"><?php echo esc_html( oum_section_field( $section, 'button_label' ) ); ?></a><?php endif; ?>
		</div>
		<div class="tool-grid oum-preview-grid--<?php echo esc_attr( oum_section_field( $section, 'layout', 'auto' ) ); ?> oum-card-style--<?php echo esc_attr( oum_section_field( $section, 'card_style', 'glass' ) ); ?>">
			<?php if ( ! empty( $items ) ) : ?>
				<?php foreach ( $items as $index => $item ) : ?>
					<?php
					$status      = sanitize_html_class( $item['status'] ?? 'normal' );
					$highlighted = ( 0 === $index && '1' === oum_section_field( $section, 'highlight_first_card', '0' ) ) || 'highlighted' === $status || 'available' === $status;
					?>
					<article class="tool-card tool-card--<?php echo esc_attr( $status ); ?> <?php echo $highlighted ? 'tool-card--available' : ''; ?>">
						<?php oum_section_icon( $item, 'tool-card__icon' ); ?>
						<?php if ( ! empty( $item['badge'] ) && '1' === oum_section_field( $section, 'show_badges', '1' ) ) : ?><div class="tool-card__status"><?php echo esc_html( $item['badge'] ); ?></div><?php endif; ?>
						<h3><?php echo esc_html( $item['title'] ?? '' ); ?></h3>
						<p><?php echo esc_html( $item['text'] ?? '' ); ?></p>
						<?php if ( '1' === oum_section_field( $section, 'show_card_buttons', '1' ) && ! empty( $item['button_label'] ) && ! empty( $item['button_url'] ) ) : ?><a class="tool-card__button" href="<?php echo esc_url( $item['button_url'] ); ?>" <?php echo ! empty( $item['new_tab'] ) ? 'target="_blank" rel="noopener noreferrer"' : ''; ?>><?php echo esc_html( $item['button_label'] ); ?></a><?php endif; ?>
					</article>
				<?php endforeach; ?>
			<?php else : ?>
				<?php foreach ( $tools as $key => $tool ) : ?>
					<?php if ( empty( $section[ 'show_' . $key ] ) ) { continue; } ?>
					<article class="tool-card tool-card--<?php echo esc_attr( $tool['status'] ); ?> <?php echo 'available' === $tool['status'] ? 'tool-card--available' : ''; ?>">
						<div class="tool-card__icon" aria-hidden="true"><?php echo 'qr' === $key ? '<span class="qr-mark"></span>' : '<span class="soon-mark"></span>'; ?></div>
						<div class="tool-card__status"><?php echo esc_html( $tool['badge'] ); ?></div>
						<h3><?php echo esc_html( $tool['title'] ); ?></h3>
						<p><?php echo esc_html( $tool['text'] ); ?></p>
					</article>
				<?php endforeach; ?>
			<?php endif; ?>
		</div>
	</div>
</section>
