<?php
/**
 * OneUp Sections tools preview.
 *
 * @package OneUpMotion
 */

$section = $args['section'] ?? array();
$tools   = array(
	'qr'    => array( 'title' => __( 'QR Generator', 'oneup-motion' ), 'text' => __( 'Create custom QR codes with colors, borders, logos and unique styles.', 'oneup-motion' ), 'status' => 'available' ),
	'utm'   => array( 'title' => __( 'UTM Builder', 'oneup-motion' ), 'text' => __( 'Build clean campaign links without messy spreadsheets.', 'oneup-motion' ), 'status' => 'coming-soon' ),
	'image' => array( 'title' => __( 'Image Tools', 'oneup-motion' ), 'text' => __( 'Simple visual utilities for creators, marketers and designers.', 'oneup-motion' ), 'status' => 'coming-soon' ),
);
?>
<section class="oum-section tools-preview section">
	<div class="tools-preview__inner section__inner">
		<div class="section__header section__header--stacked">
			<?php if ( oum_section_field( $section, 'eyebrow' ) ) : ?><p class="eyebrow"><?php echo esc_html( oum_section_field( $section, 'eyebrow' ) ); ?></p><?php endif; ?>
			<?php if ( oum_section_field( $section, 'heading' ) ) : ?><h2><?php echo esc_html( oum_section_field( $section, 'heading' ) ); ?></h2><?php endif; ?>
			<?php if ( oum_section_field( $section, 'text' ) ) : ?><div class="oum-section__text"><?php oum_section_rich_text( oum_section_field( $section, 'text' ) ); ?></div><?php endif; ?>
			<?php if ( oum_section_field( $section, 'button_label' ) && oum_section_field( $section, 'button_url' ) ) : ?><a class="button button--ghost" href="<?php echo esc_url( oum_section_field( $section, 'button_url' ) ); ?>"><?php echo esc_html( oum_section_field( $section, 'button_label' ) ); ?></a><?php endif; ?>
		</div>
		<div class="tool-grid">
			<?php foreach ( $tools as $key => $tool ) : ?>
				<?php if ( empty( $section[ 'show_' . $key ] ) ) { continue; } ?>
				<article class="tool-card tool-card--<?php echo esc_attr( $tool['status'] ); ?>">
					<div class="tool-card__icon" aria-hidden="true"><?php echo 'qr' === $key ? '<span class="qr-mark"></span>' : '<span class="soon-mark"></span>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></div>
					<div class="tool-card__status"><?php echo 'available' === $tool['status'] ? esc_html__( 'Active tool', 'oneup-motion' ) : esc_html__( 'Coming soon', 'oneup-motion' ); ?></div>
					<h3><?php echo esc_html( $tool['title'] ); ?></h3>
					<p><?php echo esc_html( $tool['text'] ); ?></p>
				</article>
			<?php endforeach; ?>
		</div>
	</div>
</section>
