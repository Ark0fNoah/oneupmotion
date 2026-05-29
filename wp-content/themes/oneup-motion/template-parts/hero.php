<?php
/**
 * Homepage hero.
 *
 * @package OneUpMotion
 */
?>
<section class="hero section" aria-labelledby="hero-title">
	<div class="hero__bg-grid" aria-hidden="true"></div>
	<div class="hero__glow hero__glow--one" aria-hidden="true"></div>
	<div class="hero__glow hero__glow--two" aria-hidden="true"></div>
	<div class="hero__inner section__inner">
		<div class="hero__content">
			<p class="eyebrow"><?php echo esc_html__( 'Digital tools & creative studio', 'oneup-motion' ); ?></p>
			<h1 id="hero-title"><?php echo wp_kses_post( __( 'We turn ideas into <span>motion</span>.', 'oneup-motion' ) ); ?></h1>
			<p class="hero__text"><?php echo esc_html__( 'OneUp Motion builds digital tools, sharp design and modern web experiences that help creators and brands level up.', 'oneup-motion' ); ?></p>
			<div class="hero__actions">
				<a class="button" href="<?php echo esc_url( home_url( '/tools/' ) ); ?>"><?php echo esc_html__( 'Explore Tools', 'oneup-motion' ); ?></a>
				<a class="button button--ghost" href="#services"><?php echo esc_html__( 'Work With Us', 'oneup-motion' ); ?></a>
			</div>
		</div>

		<div class="hero-visual" aria-hidden="true">
			<div class="hero-visual__grid"></div>
			<div class="hero-visual__beam"></div>
			<div class="hero-visual__one"></div>
			<div class="hero-visual__one-shadow"></div>
			<div class="hero-visual__motion hero-visual__motion--one"></div>
			<div class="hero-visual__motion hero-visual__motion--two"></div>
			<div class="hero-visual__dot hero-visual__dot--one"></div>
			<div class="hero-visual__dot hero-visual__dot--two"></div>
			<div class="hero-visual__tile"></div>
		</div>
	</div>

	<div class="trust-strip section__inner" aria-label="<?php echo esc_attr__( 'Trusted by creators and brands', 'oneup-motion' ); ?>">
		<span><?php echo esc_html__( 'Trusted by creators & brands', 'oneup-motion' ); ?></span>
		<ul>
			<li><?php echo esc_html__( 'Northlane', 'oneup-motion' ); ?></li>
			<li><?php echo esc_html__( 'PixelPeak', 'oneup-motion' ); ?></li>
			<li><?php echo esc_html__( 'Elevate.', 'oneup-motion' ); ?></li>
			<li><?php echo esc_html__( 'ShiftLab', 'oneup-motion' ); ?></li>
			<li><?php echo esc_html__( 'Vertex', 'oneup-motion' ); ?></li>
			<li><?php echo esc_html__( 'Lumen+', 'oneup-motion' ); ?></li>
		</ul>
	</div>
</section>
