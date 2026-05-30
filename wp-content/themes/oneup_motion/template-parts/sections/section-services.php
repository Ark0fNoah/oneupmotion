<?php
/**
 * OneUp Sections services.
 *
 * @package OneUpMotion
 */

$section  = $args['section'] ?? array();
$services = isset( $section['services'] ) && is_array( $section['services'] ) ? $section['services'] : array();
?>
<section<?php echo oum_section_anchor_attr( $section ); ?> class="<?php echo esc_attr( oum_section_classes( $section, 'oum-section services' ) ); ?>">
	<div class="section__inner">
		<div class="section__header">
			<div>
				<?php if ( oum_section_field( $section, 'eyebrow' ) ) : ?><p class="eyebrow"><?php echo esc_html( oum_section_field( $section, 'eyebrow' ) ); ?></p><?php endif; ?>
				<?php if ( oum_section_field( $section, 'heading' ) ) : ?><h2><?php echo esc_html( oum_section_field( $section, 'heading' ) ); ?></h2><?php endif; ?>
			</div>
			<?php if ( oum_section_field( $section, 'text' ) ) : ?><div class="oum-section__text"><?php oum_section_rich_text( oum_section_field( $section, 'text' ) ); ?></div><?php endif; ?>
		</div>
		<div class="service-grid">
			<?php foreach ( $services as $service ) : ?>
				<article class="service-card">
					<?php oum_section_icon( $service, 'service-card__icon' ); ?>
					<h3><?php echo esc_html( $service['title'] ?? '' ); ?></h3>
					<p><?php echo esc_html( $service['text'] ?? '' ); ?></p>
					<?php if ( ! empty( $service['url'] ) ) : ?><a class="tool-card__button" href="<?php echo esc_url( $service['url'] ); ?>"><?php echo esc_html( $service['button_label'] ?? __( 'Learn more', 'oneup-motion' ) ); ?></a><?php endif; ?>
				</article>
			<?php endforeach; ?>
		</div>
	</div>
</section>
