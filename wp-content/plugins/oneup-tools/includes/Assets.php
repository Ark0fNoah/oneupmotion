<?php
/**
 * Tool asset handling.
 *
 * @package OneUpTools
 */

namespace OneUpTools;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Assets {
	/**
	 * Whether QR assets were requested by a shortcode render.
	 *
	 * @var bool
	 */
	private $needs_qr_assets = false;

	//───────────────────────────────────────
	// Register hooks
	//───────────────────────────────────────
	public function __construct() {
		add_action( 'wp_enqueue_scripts', array( $this, 'register_assets' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'maybe_enqueue_shortcode_assets' ), 20 );
	}

	//───────────────────────────────────────
	// Register assets
	//───────────────────────────────────────
	public function register_assets() {
		wp_register_style(
			'oneup-tools',
			ONEUP_TOOLS_URL . 'assets/css/tools.css',
			array(),
			$this->asset_version( 'assets/css/tools.css' )
		);

		wp_register_script(
			'oneup-qr-generator',
			ONEUP_TOOLS_URL . 'assets/js/qr-generator.js',
			array(),
			$this->asset_version( 'assets/js/qr-generator.js' ),
			true
		);

		wp_localize_script(
			'oneup-qr-generator',
			'oneupQrDefaults',
			$this->qr_defaults()
		);
	}

	//───────────────────────────────────────
	// Request QR assets
	//───────────────────────────────────────
	public function enqueue_qr_assets() {
		$this->needs_qr_assets = true;

		if ( wp_style_is( 'oneup-tools', 'registered' ) ) {
			wp_enqueue_style( 'oneup-tools' );
		}

		if ( wp_script_is( 'oneup-qr-generator', 'registered' ) ) {
			wp_enqueue_script( 'oneup-qr-generator' );
		}
	}

	//───────────────────────────────────────
	// Shortcode asset detection
	//───────────────────────────────────────
	public function maybe_enqueue_shortcode_assets() {
		if ( ! is_singular() ) {
			return;
		}

		$post                = get_post();
		$has_shortcode       = $post && has_shortcode( $post->post_content, 'oneup_qr_generator' );
		$uses_tools_template = is_page_template( 'template-tools.php' );

		if ( ! $has_shortcode && ! $uses_tools_template ) {
			return;
		}

		$this->enqueue_qr_assets();
	}

	//───────────────────────────────────────
	// Asset version
	//───────────────────────────────────────
	private function asset_version( $relative_path ) {
		$path = ONEUP_TOOLS_PATH . ltrim( $relative_path, '/' );

		return file_exists( $path ) ? (string) filemtime( $path ) : ONEUP_TOOLS_VERSION;
	}

	//───────────────────────────────────────
	// QR defaults for JavaScript
	//───────────────────────────────────────
	private function qr_defaults() {
		$options = class_exists( __NAMESPACE__ . '\Settings' ) ? Settings::get_options() : array();
		$logo_id = absint( $options['qr_logo_id'] ?? 0 );

		return array(
			'foreground'  => $options['qr_foreground'] ?? '#031a34',
			'background'  => $options['qr_background'] ?? '#ffffff',
			'blockShape'  => $options['qr_block_shape'] ?? 'rounded',
			'cornerShape' => $options['qr_corner_shape'] ?? 'rounded',
			'logoUrl'     => $logo_id ? wp_get_attachment_image_url( $logo_id, 'medium' ) : '',
			'logoSize'    => absint( $options['qr_logo_size'] ?? 18 ),
		);
	}
}
