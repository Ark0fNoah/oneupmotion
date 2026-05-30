<?php
/**
 * Admin and login assets.
 *
 * @package OneUpAdmin
 */

namespace OneUp_Admin;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Assets {
	/**
	 * Settings manager.
	 *
	 * @var Settings
	 */
	private $settings;

	//───────────────────────────────────────
	// Constructor
	//───────────────────────────────────────
	public function __construct( Settings $settings ) {
		$this->settings = $settings;
	}

	//───────────────────────────────────────
	// Register hooks
	//───────────────────────────────────────
	public function register() {
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin' ) );
		add_action( 'login_enqueue_scripts', array( $this, 'enqueue_login' ) );
		add_action( 'admin_head', array( $this, 'print_custom_admin_css' ) );
		add_action( 'admin_head', array( $this, 'print_force_dark_panels_css' ), 999 );
		add_action( 'login_head', array( $this, 'print_custom_login_css' ) );
	}

	//───────────────────────────────────────
	// Enqueue admin assets
	//───────────────────────────────────────
	public function enqueue_admin( $hook ) {
		wp_enqueue_style( 'oneup-admin', ONEUP_ADMIN_URL . 'assets/css/admin.css', array(), ONEUP_ADMIN_VERSION );
		wp_enqueue_script( 'oneup-admin', ONEUP_ADMIN_URL . 'assets/js/admin.js', array(), ONEUP_ADMIN_VERSION, true );

		if ( 'toplevel_page_oneup-admin' === $hook ) {
			wp_enqueue_media();
		}
	}

	//───────────────────────────────────────
	// Enqueue login assets
	//───────────────────────────────────────
	public function enqueue_login() {
		if ( '1' !== $this->settings->get( 'enable_branded_login', '1' ) ) {
			return;
		}

		wp_enqueue_style( 'oneup-admin-login', ONEUP_ADMIN_URL . 'assets/css/login.css', array(), ONEUP_ADMIN_VERSION );
	}

	//───────────────────────────────────────
	// Force dark panels for stubborn WordPress screens
	//───────────────────────────────────────
	public function print_force_dark_panels_css() {
		?>
		<style id="oneup-admin-force-dark-panels">
			html body.wp-admin .wp-filter,
			html body.wp-admin .wp-filter *,
			html body.wp-admin .wp-filter::before,
			html body.wp-admin .wp-filter::after,
			html body.wp-admin .plugin-card-bottom,
			html body.wp-admin .plugin-card-bottom *,
			html body.wp-admin .plugin-card-bottom::before,
			html body.wp-admin .plugin-card-bottom::after,
			html body.wp-admin .oum-admin-panel,
			html body.wp-admin .oum-admin-panel *,
			html body.wp-admin .oum-admin-panel::before,
			html body.wp-admin .oum-admin-panel::after,
			html body.wp-admin .oum-section-panel,
			html body.wp-admin .oum-section-panel *,
			html body.wp-admin .oum-section-panel::before,
			html body.wp-admin .oum-section-panel::after {
				background-color: transparent !important;
				border-color: rgba(255,255,255,.12) !important;
			}

			html body.wp-admin .wp-filter,
			html body.wp-admin .plugin-card-bottom,
			html body.wp-admin .oum-admin-panel,
			html body.wp-admin .oum-section-panel {
				background: linear-gradient(145deg, rgba(255,255,255,.055), rgba(255,255,255,.022)), #071a2e !important;
				background-color: #071a2e !important;
				background-image: linear-gradient(145deg, rgba(255,255,255,.055), rgba(255,255,255,.022)) !important;
				border: 1px solid rgba(255,255,255,.12) !important;
				box-shadow: 0 18px 60px rgba(0,0,0,.22) !important;
				color: #ffffff !important;
			}

			html body.wp-admin .plugin-card-bottom {
				border-top: 1px solid rgba(255,255,255,.12) !important;
			}

			html body.wp-admin .wp-filter a,
			html body.wp-admin .wp-filter label,
			html body.wp-admin .wp-filter span,
			html body.wp-admin .wp-filter div,
			html body.wp-admin .plugin-card-bottom,
			html body.wp-admin .plugin-card-bottom a,
			html body.wp-admin .plugin-card-bottom span,
			html body.wp-admin .plugin-card-bottom div,
			html body.wp-admin .oum-admin-panel,
			html body.wp-admin .oum-admin-panel label,
			html body.wp-admin .oum-admin-panel span,
			html body.wp-admin .oum-admin-panel p,
			html body.wp-admin .oum-admin-panel h1,
			html body.wp-admin .oum-admin-panel h2,
			html body.wp-admin .oum-admin-panel h3,
			html body.wp-admin .oum-section-panel,
			html body.wp-admin .oum-section-panel label,
			html body.wp-admin .oum-section-panel span,
			html body.wp-admin .oum-section-panel p,
			html body.wp-admin .oum-section-panel h1,
			html body.wp-admin .oum-section-panel h2,
			html body.wp-admin .oum-section-panel h3 {
				color: #ffffff !important;
			}

			html body.wp-admin .plugin-card-bottom *,
			html body.wp-admin .wp-filter .filter-count,
			html body.wp-admin .oum-admin-panel .description,
			html body.wp-admin .oum-section-panel .description {
				color: rgba(255,255,255,.72) !important;
			}

			html body.wp-admin .wp-filter input,
			html body.wp-admin .wp-filter select,
			html body.wp-admin .oum-admin-panel input,
			html body.wp-admin .oum-admin-panel select,
			html body.wp-admin .oum-admin-panel textarea,
			html body.wp-admin .oum-section-panel input,
			html body.wp-admin .oum-section-panel select,
			html body.wp-admin .oum-section-panel textarea {
				background: rgba(255,255,255,.07) !important;
				border: 1px solid rgba(255,255,255,.12) !important;
				color: #ffffff !important;
			}

			html body.wp-admin .wp-filter .filter-links li > a.current,
			html body.wp-admin .wp-filter .filter-links li > a:hover {
				background: rgba(32,240,192,.14) !important;
				color: #20f0c0 !important;
			}
		</style>
		<?php
	}

	//───────────────────────────────────────
	// CSS variable output
	//───────────────────────────────────────
	private function css_variables() {
		$accent = $this->settings->get( 'accent_color', '#20f0c0' );
		$bg     = $this->settings->get( 'dark_background', '#03101f' );

		return ':root{--oneup-admin-bg:' . esc_html( $bg ) . ';--oneup-admin-bg-soft:#071a2e;--oneup-admin-navy:#001f3d;--oneup-admin-card:rgba(255,255,255,.055);--oneup-admin-card-border:rgba(255,255,255,.12);--oneup-admin-text:#fff;--oneup-admin-muted:rgba(255,255,255,.72);--oneup-admin-soft-muted:rgba(255,255,255,.52);--oneup-admin-mint:' . esc_html( $accent ) . ';--oneup-admin-mint-dark:#08caa0;--oneup-admin-radius:22px;--oneup-admin-radius-sm:14px;--oneup-admin-shadow:0 24px 80px rgba(0,0,0,.35);}';
	}

	//───────────────────────────────────────
	// Print admin CSS
	//───────────────────────────────────────
	public function print_custom_admin_css() {
		echo '<style id="oneup-admin-vars">' . $this->css_variables() . '</style>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

		if ( '1' === $this->settings->get( 'enable_compact_admin', '0' ) ) {
			echo '<style id="oneup-admin-compact">#wpcontent{padding-left:18px}.wrap{margin-top:18px}.postbox{border-radius:14px}</style>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		}

		$custom_css = trim( (string) $this->settings->get( 'custom_admin_css', '' ) );
		if ( '' !== $custom_css ) {
			echo '<style id="oneup-admin-custom">' . esc_html( $custom_css ) . '</style>';
		}
	}

	//───────────────────────────────────────
	// Print login CSS
	//───────────────────────────────────────
	public function print_custom_login_css() {
		if ( '1' !== $this->settings->get( 'enable_branded_login', '1' ) ) {
			return;
		}

		echo '<style id="oneup-admin-login-vars">' . $this->css_variables() . '</style>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

		$logo_id = absint( $this->settings->get( 'login_logo_id', 0 ) );
		$logo    = $logo_id ? wp_get_attachment_image_url( $logo_id, 'medium' ) : '';

		if ( $logo ) {
			echo '<style id="oneup-admin-login-logo">body.login h1 a{background-image:url(' . esc_url( $logo ) . ') !important;}</style>';
		}
	}
}
