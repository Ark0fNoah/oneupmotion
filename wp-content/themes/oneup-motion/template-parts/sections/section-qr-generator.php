<?php
/**
 * OneUp Sections QR generator.
 *
 * @package OneUpMotion
 */

$section = $args['section'] ?? array();
$layout  = oum_section_field( $section, 'layout', 'centered' );
$bg      = oum_section_field( $section, 'background_style', 'default' );
$panel   = '1' === oum_section_field( $section, 'show_surrounding_card', '1' );
?>
<section class="oum-section oum-section-qr oum-section-qr--<?php echo esc_attr( $layout ); ?> oum-section-qr--<?php echo esc_attr( $bg ); ?> section">
	<div class="section__inner">
		<div class="oum-section-qr__grid">
			<div class="oum-section-qr__content">
				<?php if ( oum_section_field( $section, 'eyebrow' ) ) : ?>
					<p class="eyebrow"><?php echo esc_html( oum_section_field( $section, 'eyebrow' ) ); ?></p>
				<?php endif; ?>
				<?php if ( oum_section_field( $section, 'heading' ) ) : ?>
					<h2><?php echo esc_html( oum_section_field( $section, 'heading' ) ); ?></h2>
				<?php endif; ?>
				<?php if ( oum_section_field( $section, 'text' ) ) : ?>
					<div class="oum-section__text"><?php oum_section_rich_text( oum_section_field( $section, 'text' ) ); ?></div>
				<?php endif; ?>
			</div>
			<div class="oum-section-qr__tool <?php echo $panel ? 'has-panel' : 'is-minimal'; ?>">
				<?php if ( oum_section_field( $section, 'tool_intro_text' ) ) : ?>
					<div class="oum-section-qr__intro"><?php oum_section_rich_text( oum_section_field( $section, 'tool_intro_text' ) ); ?></div>
				<?php endif; ?>
				<?php if ( shortcode_exists( 'oneup_qr_generator' ) ) : ?>
					<?php echo do_shortcode( '[oneup_qr_generator]' ); ?>
				<?php elseif ( current_user_can( 'activate_plugins' ) ) : ?>
					<div class="oum-section-qr__notice"><?php echo esc_html__( 'QR Generator is unavailable. Please activate the OneUp Tools plugin.', 'oneup-motion' ); ?></div>
				<?php endif; ?>
			</div>
		</div>
	</div>
</section>
