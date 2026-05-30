<?php
/**
 * OneUp Sections FAQ.
 *
 * @package OneUpMotion
 */

$section = $args['section'] ?? array();
$faqs    = isset( $section['faqs'] ) && is_array( $section['faqs'] ) ? $section['faqs'] : array();
$layout  = oum_section_field( $section, 'layout', 'single' );
?>
<section<?php echo oum_section_anchor_attr( $section ); ?> class="<?php echo esc_attr( oum_section_classes( $section, 'oum-section oum-section-faq' ) ); ?> oum-faq--<?php echo esc_attr( $layout ); ?>">
	<div class="section__inner">
		<?php if ( oum_section_field( $section, 'eyebrow' ) ) : ?><p class="eyebrow"><?php echo esc_html( oum_section_field( $section, 'eyebrow' ) ); ?></p><?php endif; ?>
		<?php if ( oum_section_field( $section, 'heading' ) ) : ?><h2><?php echo esc_html( oum_section_field( $section, 'heading' ) ); ?></h2><?php endif; ?>
		<?php if ( oum_section_field( $section, 'text' ) ) : ?><div class="oum-section__text"><?php oum_section_rich_text( oum_section_field( $section, 'text' ) ); ?></div><?php endif; ?>
		<div class="oum-faq-list">
			<?php foreach ( $faqs as $faq ) : ?>
				<details class="oum-faq-item">
					<summary><?php echo esc_html( $faq['question'] ?? '' ); ?></summary>
					<div><?php oum_section_rich_text( $faq['answer'] ?? '' ); ?></div>
				</details>
			<?php endforeach; ?>
		</div>
	</div>
</section>
