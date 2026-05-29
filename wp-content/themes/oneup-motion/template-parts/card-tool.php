<?php
/**
 * Tool card partial.
 *
 * Expected args: title, text, status, url.
 *
 * @package OneUpMotion
 */

$oum_title  = isset( $args['title'] ) ? $args['title'] : '';
$oum_text   = isset( $args['text'] ) ? $args['text'] : '';
$oum_status = isset( $args['status'] ) ? $args['status'] : 'coming-soon';
$oum_url    = isset( $args['url'] ) ? $args['url'] : '#';
?>
<article class="tool-card tool-card--<?php echo esc_attr( $oum_status ); ?>">
	<div class="tool-card__status"><?php echo 'available' === $oum_status ? esc_html__( 'Available', 'oneup-motion' ) : esc_html__( 'Coming soon', 'oneup-motion' ); ?></div>
	<h3><?php echo esc_html( $oum_title ); ?></h3>
	<p><?php echo esc_html( $oum_text ); ?></p>
	<?php if ( 'available' === $oum_status ) : ?>
		<a class="tool-card__link" href="<?php echo esc_url( $oum_url ); ?>"><?php echo esc_html__( 'Open tool', 'oneup-motion' ); ?></a>
	<?php endif; ?>
</article>
