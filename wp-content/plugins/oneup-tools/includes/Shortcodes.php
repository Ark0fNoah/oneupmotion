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
	/** @var Assets|null */
	private $assets;

	//───────────────────────────────────────
	// Register shortcodes
	//───────────────────────────────────────
	public function __construct( $assets = null ) {
		$this->assets = $assets;
		add_shortcode( 'oneup_qr_generator', array( $this, 'render_qr_generator' ) );
	}

	//───────────────────────────────────────
	// QR generator shortcode
	//───────────────────────────────────────
	public function render_qr_generator( $atts = array(), $content = null ) {
		if ( $this->assets instanceof Assets ) {
			$this->assets->enqueue_qr_assets();
		}

		ob_start();
		?>
		<section class="oneup-tool oneup-qr" data-oneup-qr-generator>
			<div class="oneup-tool__header">
				<p class="oneup-tool__eyebrow"><?php echo esc_html__( 'OneUp Tools', 'oneup-tools' ); ?></p>
				<h2><?php echo esc_html__( 'QR Generator', 'oneup-tools' ); ?></h2>
				<p><?php echo esc_html__( 'Create a styled QR code preview. Full QR rendering, logo support and downloads will be added in a future version.', 'oneup-tools' ); ?></p>
			</div>
			<form class="oneup-qr__form" action="#" method="post">
				<label><span><?php echo esc_html__( 'URL', 'oneup-tools' ); ?></span><input type="url" name="oneup_qr_url" placeholder="<?php echo esc_attr__( 'https://oneupmotion.com', 'oneup-tools' ); ?>" value=""></label>
				<div class="oneup-qr__colors">
					<label><span><?php echo esc_html__( 'Foreground', 'oneup-tools' ); ?></span><input type="color" name="oneup_qr_foreground" value="#031A34"></label>
					<label><span><?php echo esc_html__( 'Background', 'oneup-tools' ); ?></span><input type="color" name="oneup_qr_background" value="#FFFFFF"></label>
				</div>
				<label><span><?php echo esc_html__( 'Logo upload', 'oneup-tools' ); ?></span><input type="text" name="oneup_qr_logo" placeholder="<?php echo esc_attr__( 'Logo upload placeholder', 'oneup-tools' ); ?>" disabled></label>
				<button class="oneup-tool__button" type="button" data-oneup-qr-generate><?php echo esc_html__( 'Generate QR', 'oneup-tools' ); ?></button>
			</form>
			<div class="oneup-qr__preview-wrap" aria-live="polite">
				<div class="oneup-qr__preview" data-oneup-qr-preview><span><?php echo esc_html__( 'QR preview', 'oneup-tools' ); ?></span></div>
				<button class="oneup-tool__button oneup-tool__button--secondary" type="button" disabled><?php echo esc_html__( 'Download', 'oneup-tools' ); ?></button>
			</div>
		</section>
		<?php
		return ob_get_clean();
	}
}
