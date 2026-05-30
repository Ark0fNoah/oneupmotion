<?php
/**
 * Shortcodes for OneUp Tools.
 *
 * @package OneUpTools
 */

namespace OneUpTools;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Shortcodes {
	/**
	 * Asset service.
	 *
	 * @var Assets|null
	 */
	private $assets;

	/**
	 * Settings service.
	 *
	 * @var Settings|null
	 */
	private $settings;

	//───────────────────────────────────────
	// Register shortcodes
	//───────────────────────────────────────
	public function __construct( $assets = null, $settings = null ) {
		$this->assets   = $assets;
		$this->settings = $settings;

		add_shortcode( 'oneup_qr_generator', array( $this, 'render_qr_generator' ) );
	}

	//───────────────────────────────────────
	// QR generator shortcode
	//───────────────────────────────────────
	public function render_qr_generator( $atts = array(), $content = null ) {
		if ( $this->assets instanceof Assets ) {
			$this->assets->enqueue_qr_assets();
		}

		$options  = class_exists( __NAMESPACE__ . '\Settings' ) ? Settings::get_options() : array();
		$logo_id  = absint( $options['qr_logo_id'] ?? 0 );
		$logo_url = $logo_id ? wp_get_attachment_image_url( $logo_id, 'medium' ) : '';

		$style = sprintf(
			'--oneup-tool-bg:%1$s;--oneup-tool-panel-bg:%2$s;--oneup-tool-text:%3$s;--oneup-tool-muted:%4$s;--oneup-tool-accent:%5$s;--oneup-tool-border:%6$s;--oneup-tool-font-size:%7$dpx;',
			esc_attr( $options['tool_bg'] ?? '#ffffff' ),
			esc_attr( $options['tool_panel_bg'] ?? '#f7fbfa' ),
			esc_attr( $options['tool_text'] ?? '#031a34' ),
			esc_attr( $options['tool_muted'] ?? '#657386' ),
			esc_attr( $options['tool_accent'] ?? '#30f7c2' ),
			esc_attr( $options['tool_border'] ?? 'rgba(3, 26, 52, 0.12)' ),
			absint( $options['tool_font_size'] ?? 16 )
		);

		ob_start();
		?>
		<section class="oneup-tool oneup-qr" style="<?php echo esc_attr( $style ); ?>" data-oneup-qr-generator data-default-logo="<?php echo esc_url( $logo_url ); ?>" data-default-logo-size="<?php echo esc_attr( absint( $options['qr_logo_size'] ?? 18 ) ); ?>">
			<div class="oneup-tool__header">
				<p class="oneup-tool__eyebrow"><?php echo esc_html__( 'OneUp Tools', 'oneup-tools' ); ?></p>
				<h2><?php echo esc_html__( 'QR Generator', 'oneup-tools' ); ?></h2>
				<p><?php echo esc_html__( 'Create a real downloadable QR code with custom colors, module shapes, corner styling and an optional center logo.', 'oneup-tools' ); ?></p>
			</div>

			<form class="oneup-qr__form" action="#" method="post">
				<label>
					<span><?php echo esc_html__( 'URL', 'oneup-tools' ); ?></span>
					<input type="url" name="oneup_qr_url" placeholder="<?php echo esc_attr__( 'https://oneupmotion.com', 'oneup-tools' ); ?>" value="">
				</label>

				<div class="oneup-qr__colors">
					<label>
						<span><?php echo esc_html__( 'Foreground', 'oneup-tools' ); ?></span>
						<input type="color" name="oneup_qr_foreground" value="<?php echo esc_attr( $options['qr_foreground'] ?? '#031a34' ); ?>">
					</label>

					<label>
						<span><?php echo esc_html__( 'Background', 'oneup-tools' ); ?></span>
						<input type="color" name="oneup_qr_background" value="<?php echo esc_attr( $options['qr_background'] ?? '#ffffff' ); ?>">
					</label>
				</div>

				<label>
					<span><?php echo esc_html__( 'Block shape', 'oneup-tools' ); ?></span>
					<select name="oneup_qr_block_shape">
						<?php foreach ( array( 'square' => __( 'Square', 'oneup-tools' ), 'rounded' => __( 'Rounded', 'oneup-tools' ), 'dot' => __( 'Dot', 'oneup-tools' ) ) as $value => $label ) : ?>
							<option value="<?php echo esc_attr( $value ); ?>" <?php selected( $options['qr_block_shape'] ?? 'rounded', $value ); ?>><?php echo esc_html( $label ); ?></option>
						<?php endforeach; ?>
					</select>
				</label>

				<label>
					<span><?php echo esc_html__( 'Corner shape', 'oneup-tools' ); ?></span>
					<select name="oneup_qr_corner_shape">
						<?php foreach ( array( 'square' => __( 'Square', 'oneup-tools' ), 'rounded' => __( 'Rounded', 'oneup-tools' ), 'dot' => __( 'Dot', 'oneup-tools' ) ) as $value => $label ) : ?>
							<option value="<?php echo esc_attr( $value ); ?>" <?php selected( $options['qr_corner_shape'] ?? 'rounded', $value ); ?>><?php echo esc_html( $label ); ?></option>
						<?php endforeach; ?>
					</select>
				</label>

				<label>
					<span><?php echo esc_html__( 'Logo image', 'oneup-tools' ); ?></span>
					<input type="file" name="oneup_qr_logo" accept="image/*">
					<small><?php echo esc_html__( 'Optional. Leave empty to use the configured default logo.', 'oneup-tools' ); ?></small>
				</label>

				<label>
					<span><?php echo esc_html__( 'Logo size', 'oneup-tools' ); ?></span>
					<input type="range" name="oneup_qr_logo_size" min="8" max="30" value="<?php echo esc_attr( absint( $options['qr_logo_size'] ?? 18 ) ); ?>">
				</label>

				<button class="oneup-tool__button" type="button" data-oneup-qr-generate>
					<?php echo esc_html__( 'Generate QR', 'oneup-tools' ); ?>
				</button>
			</form>

			<div class="oneup-qr__preview-wrap" aria-live="polite">
				<div class="oneup-qr__preview" data-oneup-qr-preview>
					<span><?php echo esc_html__( 'QR preview', 'oneup-tools' ); ?></span>
				</div>
				<p class="oneup-qr__message" data-oneup-qr-message></p>
				<button class="oneup-tool__button oneup-tool__button--secondary" type="button" data-oneup-qr-download disabled>
					<?php echo esc_html__( 'Download SVG', 'oneup-tools' ); ?>
				</button>
			</div>
		</section>
		<?php

		return ob_get_clean();
	}
}
