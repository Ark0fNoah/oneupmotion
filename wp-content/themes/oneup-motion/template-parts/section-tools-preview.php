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
	<div class="section__inner">
		<div class="section__header">
			<p class="eyebrow"><?php echo esc_html__( 'Tools', 'oneup-motion' ); ?></p>
			<h2 id="tools-title"><?php echo esc_html__( 'Tools built to make creation easier.', 'oneup-motion' ); ?></h2>
		</div>
		<div class="tool-grid">
			<?php foreach ( $oum_tools as $oum_tool ) { get_template_part( 'template-parts/card-tool', null, $oum_tool ); } ?>
		</div>
	</div>
</section>
