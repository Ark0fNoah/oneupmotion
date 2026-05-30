<?php
/**
 * Plugin settings for OneUp Tools.
 *
 * @package OneUpTools
 */

namespace OneUpTools;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Settings {
	/**
	 * Option name.
	 */
	const OPTION_NAME = 'oneup_tools_options';

	//───────────────────────────────────────
	// Register hooks
	//───────────────────────────────────────
	public function __construct() {
		add_action( 'admin_menu', array( $this, 'add_options_page' ) );
		add_action( 'admin_init', array( $this, 'register_settings' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_assets' ) );
	}

	//───────────────────────────────────────
	// Defaults
	//───────────────────────────────────────
	public static function defaults() {
		return array(
			'tool_bg'          => '#ffffff',
			'tool_panel_bg'    => '#f7fbfa',
			'tool_text'        => '#031a34',
			'tool_muted'       => '#657386',
			'tool_accent'      => '#30f7c2',
			'tool_border'      => 'rgba(3, 26, 52, 0.12)',
			'tool_font_size'   => '16',
			'qr_foreground'    => '#031a34',
			'qr_background'    => '#ffffff',
			'qr_block_shape'   => 'rounded',
			'qr_corner_shape'  => 'rounded',
			'qr_logo_id'       => 0,
			'qr_logo_size'     => '18',
		);
	}

	//───────────────────────────────────────
	// Get options
	//───────────────────────────────────────
	public static function get_options() {
		$options = get_option( self::OPTION_NAME, array() );

		return wp_parse_args( is_array( $options ) ? $options : array(), self::defaults() );
	}

	//───────────────────────────────────────
	// Get option
	//───────────────────────────────────────
	public static function get_option( $key, $fallback = '' ) {
		$options = self::get_options();

		return isset( $options[ $key ] ) ? $options[ $key ] : $fallback;
	}

	//───────────────────────────────────────
	// Add options page
	//───────────────────────────────────────
	public function add_options_page() {
		add_options_page(
			__( 'OneUp Tools', 'oneup-tools' ),
			__( 'OneUp Tools', 'oneup-tools' ),
			'manage_options',
			'oneup-tools',
			array( $this, 'render_options_page' )
		);
	}

	//───────────────────────────────────────
	// Register settings
	//───────────────────────────────────────
	public function register_settings() {
		register_setting( 'oneup_tools_options', self::OPTION_NAME, array( $this, 'sanitize_options' ) );
	}

	//───────────────────────────────────────
	// Admin assets
	//───────────────────────────────────────
	public function enqueue_admin_assets( $hook ) {
		if ( 'settings_page_oneup-tools' !== $hook ) {
			return;
		}

		wp_enqueue_media();
		wp_enqueue_style(
			'oneup-tools-admin-style',
			ONEUP_TOOLS_URL . 'assets/css/tools.css',
			array(),
			$this->asset_version( 'assets/css/tools.css' )
		);
		wp_enqueue_script(
			'oneup-tools-admin',
			ONEUP_TOOLS_URL . 'assets/js/admin-tools.js',
			array(),
			$this->asset_version( 'assets/js/admin-tools.js' ),
			true
		);
	}

	//───────────────────────────────────────
	// Sanitize settings
	//───────────────────────────────────────
	public function sanitize_options( $input ) {
		$input    = is_array( $input ) ? $input : array();
		$defaults = self::defaults();
		$output   = self::get_options();

		foreach ( array( 'tool_bg', 'tool_panel_bg', 'tool_text', 'tool_muted', 'tool_accent', 'qr_foreground', 'qr_background' ) as $key ) {
			$output[ $key ] = isset( $input[ $key ] ) ? $this->sanitize_color( $input[ $key ], $defaults[ $key ] ) : $output[ $key ];
		}

		$output['tool_border'] = isset( $input['tool_border'] ) ? $this->sanitize_css_color( $input['tool_border'], $defaults['tool_border'] ) : $output['tool_border'];
		$output['tool_font_size'] = isset( $input['tool_font_size'] ) ? (string) min( max( absint( $input['tool_font_size'] ), 12 ), 24 ) : $output['tool_font_size'];
		$output['qr_logo_size'] = isset( $input['qr_logo_size'] ) ? (string) min( max( absint( $input['qr_logo_size'] ), 8 ), 30 ) : $output['qr_logo_size'];
		$output['qr_logo_id'] = isset( $input['qr_logo_id'] ) ? absint( $input['qr_logo_id'] ) : absint( $output['qr_logo_id'] ?? 0 );

		foreach ( array( 'qr_block_shape', 'qr_corner_shape' ) as $key ) {
			$value = isset( $input[ $key ] ) ? sanitize_key( $input[ $key ] ) : $output[ $key ];
			$output[ $key ] = in_array( $value, array( 'square', 'rounded', 'dot' ), true ) ? $value : $defaults[ $key ];
		}

		return $output;
	}

	//───────────────────────────────────────
	// Render options page
	//───────────────────────────────────────
	public function render_options_page() {
		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}

		$options = self::get_options();
		?>
		<div class="wrap oneup-tools-settings">
			<h1><?php echo esc_html__( 'OneUp Tools Settings', 'oneup-tools' ); ?></h1>
			<nav class="nav-tab-wrapper" aria-label="<?php echo esc_attr__( 'OneUp Tools settings tabs', 'oneup-tools' ); ?>">
				<a class="nav-tab nav-tab-active" href="#oneup-tools-qr"><?php echo esc_html__( 'QR Generator', 'oneup-tools' ); ?></a>
			</nav>
			<form method="post" action="options.php">
				<?php settings_fields( 'oneup_tools_options' ); ?>
				<section id="oneup-tools-qr" class="oneup-tools-panel">
					<h2><?php echo esc_html__( 'QR Generator Defaults', 'oneup-tools' ); ?></h2>
					<p><?php echo esc_html__( 'Control the QR tool interface and the default QR style used by the shortcode.', 'oneup-tools' ); ?></p>
					<div class="oneup-tools-grid">
						<?php $this->color_field( $options, 'tool_bg', __( 'Tool background', 'oneup-tools' ) ); ?>
						<?php $this->color_field( $options, 'tool_panel_bg', __( 'Tool panel background', 'oneup-tools' ) ); ?>
						<?php $this->color_field( $options, 'tool_text', __( 'Tool text color', 'oneup-tools' ) ); ?>
						<?php $this->color_field( $options, 'tool_muted', __( 'Muted text color', 'oneup-tools' ) ); ?>
						<?php $this->color_field( $options, 'tool_accent', __( 'Accent / button color', 'oneup-tools' ) ); ?>
						<?php $this->text_field( $options, 'tool_border', __( 'Border color', 'oneup-tools' ) ); ?>
						<?php $this->number_field( $options, 'tool_font_size', __( 'Tool font size', 'oneup-tools' ), 12, 24 ); ?>
						<?php $this->color_field( $options, 'qr_foreground', __( 'Default QR foreground', 'oneup-tools' ) ); ?>
						<?php $this->color_field( $options, 'qr_background', __( 'Default QR background', 'oneup-tools' ) ); ?>
						<?php $this->select_field( $options, 'qr_block_shape', __( 'QR block shape', 'oneup-tools' ) ); ?>
						<?php $this->select_field( $options, 'qr_corner_shape', __( 'QR corner shape', 'oneup-tools' ) ); ?>
						<?php $this->number_field( $options, 'qr_logo_size', __( 'Logo size percent', 'oneup-tools' ), 8, 30 ); ?>
						<?php $this->media_field( $options, 'qr_logo_id', __( 'Center logo', 'oneup-tools' ) ); ?>
					</div>
				</section>
				<?php submit_button(); ?>
			</form>
		</div>
		<?php
	}

	//───────────────────────────────────────
	// Field helpers
	//───────────────────────────────────────
	private function color_field( $options, $key, $label ) {
		$this->text_field( $options, $key, $label, 'color' );
	}

	private function text_field( $options, $key, $label, $type = 'text' ) {
		?>
		<label>
			<span><?php echo esc_html( $label ); ?></span>
			<input type="<?php echo esc_attr( $type ); ?>" name="<?php echo esc_attr( self::OPTION_NAME . '[' . $key . ']' ); ?>" value="<?php echo esc_attr( $options[ $key ] ?? '' ); ?>">
		</label>
		<?php
	}

	private function number_field( $options, $key, $label, $min, $max ) {
		?>
		<label>
			<span><?php echo esc_html( $label ); ?></span>
			<input type="number" min="<?php echo esc_attr( $min ); ?>" max="<?php echo esc_attr( $max ); ?>" name="<?php echo esc_attr( self::OPTION_NAME . '[' . $key . ']' ); ?>" value="<?php echo esc_attr( $options[ $key ] ?? '' ); ?>">
		</label>
		<?php
	}

	private function select_field( $options, $key, $label ) {
		$choices = array(
			'square'  => __( 'Square', 'oneup-tools' ),
			'rounded' => __( 'Rounded', 'oneup-tools' ),
			'dot'     => __( 'Dot', 'oneup-tools' ),
		);
		?>
		<label>
			<span><?php echo esc_html( $label ); ?></span>
			<select name="<?php echo esc_attr( self::OPTION_NAME . '[' . $key . ']' ); ?>">
				<?php foreach ( $choices as $value => $choice_label ) : ?>
					<option value="<?php echo esc_attr( $value ); ?>" <?php selected( $options[ $key ] ?? '', $value ); ?>><?php echo esc_html( $choice_label ); ?></option>
				<?php endforeach; ?>
			</select>
		</label>
		<?php
	}

	private function media_field( $options, $key, $label ) {
		$value = absint( $options[ $key ] ?? 0 );
		?>
		<label class="oneup-tools-media-field">
			<span><?php echo esc_html( $label ); ?></span>
			<input type="hidden" name="<?php echo esc_attr( self::OPTION_NAME . '[' . $key . ']' ); ?>" value="<?php echo esc_attr( $value ); ?>" data-oneup-tools-media-input>
			<button type="button" class="button" data-oneup-tools-media-button><?php echo esc_html__( 'Choose logo', 'oneup-tools' ); ?></button>
			<button type="button" class="button-link" data-oneup-tools-media-clear><?php echo esc_html__( 'Remove', 'oneup-tools' ); ?></button>
			<span class="oneup-tools-media-preview" data-oneup-tools-media-preview><?php echo $value ? wp_kses_post( wp_get_attachment_image( $value, 'thumbnail' ) ) : ''; ?></span>
		</label>
		<?php
	}

	//───────────────────────────────────────
	// Sanitizers
	//───────────────────────────────────────
	private function sanitize_color( $value, $fallback ) {
		$color = sanitize_hex_color( $value );

		return $color ? $color : $fallback;
	}

	private function sanitize_css_color( $value, $fallback ) {
		$value = trim( (string) $value );

		if ( preg_match( '/^(#[0-9a-fA-F]{3,8}|rgba?\\([0-9.,\\s]+\\))$/', $value ) ) {
			return $value;
		}

		return $fallback;
	}

	//───────────────────────────────────────
	// Asset version
	//───────────────────────────────────────
	private function asset_version( $relative_path ) {
		$path = ONEUP_TOOLS_PATH . ltrim( $relative_path, '/' );

		return file_exists( $path ) ? (string) filemtime( $path ) : ONEUP_TOOLS_VERSION;
	}
}
