<?php
/**
 * OneUp Sections hero.
 *
 * @package OneUpMotion
 */

$section = $args['section'] ?? array();
$visual  = oum_section_field( $section, 'visual_style', 'geometric' );
$id      = ! empty( $section['id'] ) ? $section['id'] : uniqid( 'oum_', false );
?>
<section class="oum-section oum-section-hero section" aria-labelledby="oum-section-<?php echo esc_attr( $id ); ?>">
	<div class="hero__bg-grid" aria-hidden="true"></div>
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
		<?php if ( 'none' !== $visual ) : ?>
			<div class="hero-visual hero-visual--<?php echo esc_attr( $visual ); ?>" aria-hidden="true">
				<div class="hero-visual__grid"></div><div class="hero-visual__beam"></div><div class="hero-visual__one"></div><div class="hero-visual__one-shadow"></div><div class="hero-visual__motion hero-visual__motion--one"></div><div class="hero-visual__motion hero-visual__motion--two"></div><div class="hero-visual__dot hero-visual__dot--one"></div><div class="hero-visual__dot hero-visual__dot--two"></div><div class="hero-visual__tile"></div>
			</div>
		<?php endif; ?>
	</div>
</section>
