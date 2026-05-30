<?php
/**
 * OneUp Sections story.
 *
 * @package OneUpMotion
 */

$section = $args['section'] ?? array();
$points  = isset( $section['points'] ) && is_array( $section['points'] ) ? $section['points'] : array();
$image_id = absint( oum_section_field( $section, 'image_id', 0 ) );
?>
<section<?php echo oum_section_anchor_attr( $section ); ?> class="<?php echo esc_attr( oum_section_classes( $section, 'oum-section about-story' ) ); ?>">
	<div class="about-story__inner section__inner">
		<div class="about-visual" aria-hidden="true">
			<?php if ( 'image' === oum_section_field( $section, 'visual_type', 'css' ) && $image_id ) : ?>
				<?php echo wp_get_attachment_image( $image_id, 'large', false, array( 'alt' => esc_attr( oum_section_field( $section, 'image_alt', '' ) ) ) ); ?>
			<?php elseif ( 'none' !== oum_section_field( $section, 'visual_type', 'css' ) ) : ?>
				<div class="about-visual__portal"></div><div class="about-visual__figure about-visual__figure--one"></div><div class="about-visual__figure about-visual__figure--two"></div><div class="about-visual__base"></div>
			<?php endif; ?>
		</div>
		<div>
			<?php if ( oum_section_field( $section, 'eyebrow' ) ) : ?><p class="eyebrow"><?php echo esc_html( oum_section_field( $section, 'eyebrow' ) ); ?></p><?php endif; ?>
			<?php if ( oum_section_field( $section, 'heading' ) ) : ?><h2><?php oum_section_heading_with_highlight( oum_section_field( $section, 'heading' ), oum_section_field( $section, 'highlighted_word' ) ); ?></h2><?php endif; ?>
			<?php if ( oum_section_field( $section, 'text' ) ) : ?><div class="oum-section__text"><?php oum_section_rich_text( oum_section_field( $section, 'text' ) ); ?></div><?php endif; ?>
			<?php if ( oum_section_field( $section, 'quote' ) ) : ?><p class="about-story__note"><?php echo esc_html( oum_section_field( $section, 'quote' ) ); ?></p><?php endif; ?>
			<ul class="about-story__points">
				<?php foreach ( $points as $point ) : ?><li><span><?php echo esc_html( $point['icon'] ?? '' ); ?></span><strong><?php echo esc_html( $point['title'] ?? '' ); ?></strong><?php if ( ! empty( $point['text'] ) ) : ?><em><?php echo esc_html( $point['text'] ); ?></em><?php endif; ?></li><?php endforeach; ?>
			</ul>
		</div>
	</div>
</section>
