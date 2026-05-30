<?php
/**
 * Services section.
 *
 * @package OneUpMotion
 */

$oum_services = array(
	__( 'Web Design', 'oneup-motion' ),
	__( 'Brand Identity', 'oneup-motion' ),
	__( 'Digital Content', 'oneup-motion' ),
	__( 'Custom Tools', 'oneup-motion' ),
);
?>
<section class="services section section--light" id="services" aria-labelledby="services-title">
	<div class="section__inner">
		<div class="section__header">
			<p class="eyebrow"><?php echo esc_html__( 'What we do', 'oneup-motion' ); ?></p>
			<h2 id="services-title"><?php echo wp_kses_post( __( 'Design and digital work with <span>momentum</span>.', 'oneup-motion' ) ); ?></h2>
		</div>

		<div class="service-grid">
			<?php
			$oum_descriptions = array(
				__( 'Modern websites that look sharp and perform even better.', 'oneup-motion' ),
				__( 'Visual identities that connect, stand out and stick.', 'oneup-motion' ),
				__( 'Scroll-stopping content that tells your story with impact.', 'oneup-motion' ),
				__( 'Custom web tools built to solve real problems.', 'oneup-motion' ),
			);
			foreach ( $oum_services as $oum_index => $oum_service ) :
				?>
				<article class="service-card">
					<span class="service-card__icon" aria-hidden="true"></span>
					<h3><?php echo esc_html( $oum_service ); ?></h3>
					<p><?php echo esc_html( $oum_descriptions[ $oum_index ] ); ?></p>
				</article>
			<?php endforeach; ?>
		</div>
	</div>
</section>
