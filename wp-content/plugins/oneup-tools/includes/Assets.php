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
		wp_register_style( 'oneup-tools', ONEUP_TOOLS_URL . 'assets/css/tools.css', array(), $this->asset_version( 'assets/css/tools.css' ) );
		wp_register_script( 'oneup-qr-generator', ONEUP_TOOLS_URL . 'assets/js/qr-generator.js', array(), $this->asset_version( 'assets/js/qr-generator.js' ), true );
	}

	//───────────────────────────────────────
	// Request QR assets
	//───────────────────────────────────────
	public function enqueue_qr_assets() {
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

		$post = get_post();
		$has_shortcode = $post && has_shortcode( $post->post_content, 'oneup_qr_generator' );
		$uses_tools_template = is_page_template( 'page-tools.php' );

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
}
