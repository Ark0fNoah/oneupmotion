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
			<p class="eyebrow"><?php echo esc_html__( 'Services', 'oneup-motion' ); ?></p>
			<h2 id="services-title"><?php echo esc_html__( 'Design and digital work with momentum.', 'oneup-motion' ); ?></h2>
		</div>
		<div class="service-grid">
			<?php foreach ( $oum_services as $oum_index => $oum_service ) : ?>
				<article class="service-card">
					<span class="service-card__number"><?php echo esc_html( str_pad( (string) ( $oum_index + 1 ), 2, '0', STR_PAD_LEFT ) ); ?></span>
					<h3><?php echo esc_html( $oum_service ); ?></h3>
					<p><?php echo esc_html__( 'Focused creative support shaped for modern teams, launches and digital products.', 'oneup-motion' ); ?></p>
				</article>
			<?php endforeach; ?>
		</div>
	</div>
</section>
