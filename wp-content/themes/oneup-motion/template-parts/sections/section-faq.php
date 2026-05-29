<?php
$section = $args['section'] ?? array();
$faqs    = isset( $section['faqs'] ) && is_array( $section['faqs'] ) ? $section['faqs'] : array();
?>
<section class="oum-section oum-section-faq section">
	<div class="section__inner">
		<?php if ( oum_section_field( $section, 'eyebrow' ) ) : ?><p class="eyebrow"><?php echo esc_html( oum_section_field( $section, 'eyebrow' ) ); ?></p><?php endif; ?>
		<?php if ( oum_section_field( $section, 'heading' ) ) : ?><h2><?php echo esc_html( oum_section_field( $section, 'heading' ) ); ?></h2><?php endif; ?>
		<div class="oum-faq-list">
			<?php foreach ( $faqs as $faq ) : ?>
				<details class="oum-faq-item"><summary><?php echo esc_html( $faq['question'] ?? '' ); ?></summary><div><?php oum_section_rich_text( $faq['answer'] ?? '' ); ?></div></details>
			<?php endforeach; ?>
		</div>
	</div>
</section>
