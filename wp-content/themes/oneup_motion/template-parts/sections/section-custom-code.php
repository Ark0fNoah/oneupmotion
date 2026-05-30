<?php
/**
 * OneUp Sections custom code.
 *
 * @package OneUpMotion
 */

$section = $args['section'] ?? array();
$wrap    = '1' === oum_section_field( $section, 'show_surrounding_card', '1' );
?>
<section<?php echo oum_section_anchor_attr( $section ); ?> class="<?php echo esc_attr( oum_section_classes( $section, 'oum-section oum-custom-code' ) ); ?>">
	<div class="section__inner">
		<?php if ( oum_section_field( $section, 'eyebrow' ) || oum_section_field( $section, 'heading' ) || oum_section_field( $section, 'text' ) ) : ?>
			<div class="section__header">
				<div>
					<?php if ( oum_section_field( $section, 'eyebrow' ) ) : ?><p class="eyebrow"><?php echo esc_html( oum_section_field( $section, 'eyebrow' ) ); ?></p><?php endif; ?>
					<?php if ( oum_section_field( $section, 'heading' ) ) : ?><h2><?php echo esc_html( oum_section_field( $section, 'heading' ) ); ?></h2><?php endif; ?>
				</div>
				<?php if ( oum_section_field( $section, 'text' ) ) : ?><div class="oum-section__text"><?php oum_section_rich_text( oum_section_field( $section, 'text' ) ); ?></div><?php endif; ?>
			</div>
		<?php endif; ?>

		<div class="<?php echo esc_attr( $wrap ? 'oum-custom-code__card' : 'oum-custom-code__raw' ); ?>">
			<?php echo (string) oum_section_field( $section, 'html_code', '' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
		</div>

		<?php if ( oum_section_field( $section, 'js_code' ) ) : ?>
			<script>
				<?php echo (string) oum_section_field( $section, 'js_code', '' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
			</script>
		<?php endif; ?>
	</div>
</section>
