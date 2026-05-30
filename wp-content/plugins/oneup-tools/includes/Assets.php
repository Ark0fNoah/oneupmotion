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
			'oneup-qr-code-styling',
			'https://cdn.jsdelivr.net/npm/qr-code-styling@1.6.0/lib/qr-code-styling.js',
			array(),
			'1.6.0',
			true
		);

		wp_register_script(
			'oneup-qr-generator',
			ONEUP_TOOLS_URL . 'assets/js/qr-generator.js',
			array( 'oneup-qr-code-styling' ),
			$this->asset_version( 'assets/js/qr-generator.js' ),
			true
		);

		wp_register_script(
			'oneup-utm-generator',
			ONEUP_TOOLS_URL . 'assets/js/utm-generator.js',
			array(),
			$this->asset_version( 'assets/js/utm-generator.js' ),
			true
		);

		wp_register_script(
			'oneup-og-preview',
			ONEUP_TOOLS_URL . 'assets/js/og-preview.js',
			array(),
			$this->asset_version( 'assets/js/og-preview.js' ),
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
		$this->enqueue_tool_assets();

		if ( wp_script_is( 'oneup-qr-code-styling', 'registered' ) ) {
			wp_enqueue_script( 'oneup-qr-code-styling' );
		}

		if ( wp_script_is( 'oneup-qr-generator', 'registered' ) ) {
			wp_enqueue_script( 'oneup-qr-generator' );
		}
	}

	//───────────────────────────────────────
	// Request UTM assets
	//───────────────────────────────────────
	public function enqueue_utm_assets() {
		$this->enqueue_tool_assets();

		if ( wp_script_is( 'oneup-utm-generator', 'registered' ) ) {
			wp_enqueue_script( 'oneup-utm-generator' );
		}
	}

	//───────────────────────────────────────
	// Request Open Graph preview assets
	//───────────────────────────────────────
	public function enqueue_og_assets() {
		$this->enqueue_tool_assets();

		if ( wp_script_is( 'oneup-og-preview', 'registered' ) ) {
			wp_enqueue_script( 'oneup-og-preview' );
		}
	}

	//───────────────────────────────────────
	// Request shared tool assets
	//───────────────────────────────────────
	public function enqueue_tool_assets() {
		$this->needs_qr_assets = true;

		if ( wp_style_is( 'oneup-tools', 'registered' ) ) {
			wp_enqueue_style( 'oneup-tools' );
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
		$has_qr_shortcode    = $post && has_shortcode( $post->post_content, 'oneup_qr_generator' );
		$has_utm_shortcode   = $post && has_shortcode( $post->post_content, 'oneup_utm_generator' );
		$has_og_shortcode    = $post && ( has_shortcode( $post->post_content, 'oneup_og_preview' ) || has_shortcode( $post->post_content, 'oneup_open_graph_preview' ) );
		$uses_tools_template = is_page_template( 'template-tools.php' );

		if ( ! $has_qr_shortcode && ! $has_utm_shortcode && ! $has_og_shortcode && ! $uses_tools_template ) {
			return;
		}

		if ( $has_qr_shortcode || $uses_tools_template ) {
			$this->enqueue_qr_assets();
		}

		if ( $has_utm_shortcode || $uses_tools_template ) {
			$this->enqueue_utm_assets();
		}

		if ( $has_og_shortcode || $uses_tools_template ) {
			$this->enqueue_og_assets();
		}
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
			'foreground'  => $options['qr_foreground'] ?? '#001f3d',
			'background'  => $options['qr_background'] ?? '#ffffff',
			'blockShape'  => $options['qr_block_shape'] ?? 'rounded',
			'cornerShape' => $options['qr_corner_shape'] ?? 'extra-rounded',
			'centerShape' => $options['qr_center_shape'] ?? 'square',
			'frameStyle'  => $options['qr_frame_style'] ?? 'none',
			'frameColor'     => $options['qr_frame_color'] ?? '#ffffff',
			'frameTextColor' => $options['qr_frame_text_color'] ?? '#001f3d',
			'frameText'      => $options['qr_frame_text'] ?? 'SCAN ME',
			'logoUrl'     => $logo_id ? wp_get_attachment_image_url( $logo_id, 'medium' ) : '',
			'logoSize'    => absint( $options['qr_logo_size'] ?? 18 ),
		);
	}
}
