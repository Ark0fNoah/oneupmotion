<?php
/**
 * Login page customization.
 *
 * @package OneUpAdmin
 */

namespace OneUp_Admin;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Login {
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
		add_filter( 'login_headerurl', array( $this, 'login_logo_url' ) );
		add_filter( 'login_headertext', array( $this, 'login_logo_text' ) );
		add_action( 'login_header', array( $this, 'render_login_intro' ) );
	}

	//───────────────────────────────────────
	// Login logo URL
	//───────────────────────────────────────
	public function login_logo_url() {
		return home_url( '/' );
	}

	//───────────────────────────────────────
	// Login logo text
	//───────────────────────────────────────
	public function login_logo_text() {
		return $this->settings->get( 'brand_name', 'OneUp Motion' );
	}

	//───────────────────────────────────────
	// Login intro
	//───────────────────────────────────────
	public function render_login_intro() {
		if ( '1' !== $this->settings->get( 'enable_branded_login', '1' ) ) {
			return;
		}

		$headline = $this->settings->get( 'login_headline', 'Welcome back' );
		$subtext  = $this->settings->get( 'login_subtext', 'Sign in to manage OneUp Motion.' );
		?>
		<div class="oneup-login-intro">
			<p><?php echo esc_html( $headline ); ?></p>
			<span><?php echo esc_html( $subtext ); ?></span>
		</div>
		<?php
	}
}
