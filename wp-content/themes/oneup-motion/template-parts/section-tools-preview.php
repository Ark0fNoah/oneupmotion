<?php
/**
 * Tools preview section.
 *
 * @package OneUpMotion
 */

$oum_tools = array(
	array(
		'title'  => __( 'QR Generator', 'oneup-motion' ),
		'text'   => __( 'Create custom QR codes with colors, borders, logos and unique styles.', 'oneup-motion' ),
		'status' => 'available',
		'url'    => home_url( '/tools/' ),
	),
	array(
		'title'  => __( 'UTM Builder', 'oneup-motion' ),
		'text'   => __( 'Build clean campaign links without messy spreadsheets.', 'oneup-motion' ),
		'status' => 'coming-soon',
	),
	array(
		'title'  => __( 'Image Tools', 'oneup-motion' ),
		'text'   => __( 'Simple visual utilities for creators, marketers and designers.', 'oneup-motion' ),
		'status' => 'coming-soon',
	),
);
?>
<section class="tools-preview section" id="tools" aria-labelledby="tools-title">
	<div class="tools-preview__inner section__inner">
		<div class="section__header section__header--stacked">
			<p class="eyebrow"><?php echo esc_html__( 'Powerful tools', 'oneup-motion' ); ?></p>
			<h2 id="tools-title"><?php echo esc_html__( 'Tools built to make creation easier.', 'oneup-motion' ); ?></h2>
			<p><?php echo esc_html__( 'Simple, fast and useful tools for everyday creators, marketers and businesses.', 'oneup-motion' ); ?></p>
			<a class="button button--ghost" href="<?php echo esc_url( home_url( '/tools/' ) ); ?>"><?php echo esc_html__( 'View All Tools', 'oneup-motion' ); ?></a>
		</div>

		<div class="tool-grid">
			<?php foreach ( $oum_tools as $oum_tool ) : ?>
				<article class="tool-card tool-card--<?php echo esc_attr( $oum_tool['status'] ); ?>">
					<div class="tool-card__icon" aria-hidden="true">
						<?php if ( 'available' === $oum_tool['status'] ) : ?>
							<span class="qr-mark"></span>
						<?php else : ?>
							<span class="soon-mark"></span>
						<?php endif; ?>
					</div>
					<div class="tool-card__status">
						<?php echo 'available' === $oum_tool['status'] ? esc_html__( 'Active tool', 'oneup-motion' ) : esc_html__( 'Coming soon', 'oneup-motion' ); ?>
					</div>
					<h3><?php echo esc_html( $oum_tool['title'] ); ?></h3>
					<p><?php echo esc_html( $oum_tool['text'] ); ?></p>
					<?php if ( 'available' === $oum_tool['status'] ) : ?>
						<a class="tool-card__button" href="<?php echo esc_url( $oum_tool['url'] ); ?>"><?php echo esc_html__( 'Try Now', 'oneup-motion' ); ?></a>
					<?php endif; ?>
				</article>
			<?php endforeach; ?>
		</div>
	</div>
</section>
