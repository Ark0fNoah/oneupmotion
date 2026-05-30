<?php
/**
 * OneUp Sections hero.
 *
 * @package OneUpMotion
 */

$section = $args['section'] ?? array();
$visual  = oum_section_field( $section, 'hero_visual_type', oum_section_field( $section, 'visual_style', 'geometric' ) );
$id      = ! empty( $section['id'] ) ? $section['id'] : uniqid( 'oum_', false );
$image_id = absint( oum_section_field( $section, 'hero_image_id', 0 ) );
$image_position = oum_section_field( $section, 'hero_image_position', 'right' );
$image_style = oum_section_field( $section, 'hero_image_style', 'normal' );
?>
<section<?php echo oum_section_anchor_attr( $section ); ?> class="<?php echo esc_attr( oum_section_classes( $section, 'oum-section oum-section-hero' ) ); ?> oum-hero-image-<?php echo esc_attr( $image_position ); ?>" aria-labelledby="oum-section-<?php echo esc_attr( $id ); ?>">
	<?php if ( '1' === oum_section_field( $section, 'show_grid_background', '1' ) ) : ?><div class="hero__bg-grid" aria-hidden="true"></div><?php endif; ?>
	<div class="oum-section-hero__inner section__inner">
		<div>
			<?php if ( oum_section_field( $section, 'eyebrow' ) ) : ?>
				<p class="eyebrow"><?php echo esc_html( oum_section_field( $section, 'eyebrow' ) ); ?></p>
			<?php endif; ?>
			<h1 id="oum-section-<?php echo esc_attr( $id ); ?>"><?php oum_section_heading_with_highlight( oum_section_field( $section, 'heading' ), oum_section_field( $section, 'highlighted_word' ) ); ?></h1>
			<?php if ( oum_section_field( $section, 'text' ) ) : ?>
				<div class="hero__text"><?php oum_section_rich_text( oum_section_field( $section, 'text' ) ); ?></div>
			<?php endif; ?>
			<div class="hero__actions">
				<?php if ( oum_section_field( $section, 'primary_button_label' ) && oum_section_field( $section, 'primary_button_url' ) ) : ?>
					<a class="button" href="<?php echo esc_url( oum_section_field( $section, 'primary_button_url' ) ); ?>"><?php echo esc_html( oum_section_field( $section, 'primary_button_label' ) ); ?></a>
				<?php endif; ?>
				<?php if ( oum_section_field( $section, 'secondary_button_label' ) && oum_section_field( $section, 'secondary_button_url' ) ) : ?>
					<a class="button button--ghost" href="<?php echo esc_url( oum_section_field( $section, 'secondary_button_url' ) ); ?>"><?php echo esc_html( oum_section_field( $section, 'secondary_button_label' ) ); ?></a>
				<?php endif; ?>
			</div>
		</div>
		<?php if ( 'image' === $visual && $image_id ) : ?>
			<div class="oum-hero-image oum-hero-image--<?php echo esc_attr( $image_style ); ?>">
				<?php echo wp_get_attachment_image( $image_id, 'large', false, array( 'alt' => esc_attr( oum_section_field( $section, 'hero_image_alt', '' ) ) ) ); ?>
			</div>
		<?php elseif ( 'none' !== $visual ) : ?>
			<div class="hero-visual hero-visual--<?php echo esc_attr( $visual ); ?>" aria-hidden="true">
				<div class="hero-visual__grid"></div>
				<?php if ( '1' === oum_section_field( $section, 'show_glow', '1' ) ) : ?><div class="hero-visual__beam"></div><?php endif; ?>
				<div class="hero-visual__one"></div>
				<div class="hero-visual__one-shadow"></div>
				<?php if ( '1' === oum_section_field( $section, 'show_motion_lines', '1' ) ) : ?>
					<div class="hero-visual__motion hero-visual__motion--one"></div>
					<div class="hero-visual__motion hero-visual__motion--two"></div>
				<?php endif; ?>
				<div class="hero-visual__dot hero-visual__dot--one"></div>
				<div class="hero-visual__dot hero-visual__dot--two"></div>
				<div class="hero-visual__tile"></div>
			</div>
		<?php endif; ?>
	</div>
</section>
