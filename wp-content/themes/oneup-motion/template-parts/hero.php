<?php
/**
 * Homepage hero.
 *
 * @package OneUpMotion
 */
?>
<section class="hero section" aria-labelledby="hero-title">
	<div class="hero__inner section__inner">
		<div class="hero__content">
			<p class="eyebrow"><?php echo esc_html__( 'Creative systems for useful momentum', 'oneup-motion' ); ?></p>
			<h1 id="hero-title"><?php echo esc_html__( 'Digital tools and design that move ideas forward.', 'oneup-motion' ); ?></h1>
			<p class="hero__text"><?php echo esc_html__( 'OneUp Motion creates useful digital tools, sharp visuals and modern web experiences for creators, brands and businesses.', 'oneup-motion' ); ?></p>
			<div class="hero__actions">
				<a class="button" href="<?php echo esc_url( home_url( '/tools/' ) ); ?>"><?php echo esc_html__( 'Explore Tools', 'oneup-motion' ); ?></a>
				<a class="button button--ghost" href="#services"><?php echo esc_html__( 'Work With Us', 'oneup-motion' ); ?></a>
			</div>
		</div>
		<div class="hero-visual" aria-hidden="true">
			<div class="hero-visual__grid"></div>
			<div class="hero-visual__arrow"></div>
			<div class="hero-visual__motion hero-visual__motion--one"></div>
			<div class="hero-visual__motion hero-visual__motion--two"></div>
			<div class="hero-visual__tile"></div>
		</div>
	</div>
</section>
