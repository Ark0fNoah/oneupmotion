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
			'tool_bg'             => '#071a2e',
			'tool_panel_bg'       => '#03101f',
			'tool_text'           => '#ffffff',
			'tool_muted'          => 'rgba(255,255,255,0.72)',
			'tool_accent'         => '#20f0c0',
			'tool_border'         => 'rgba(255,255,255,0.12)',
			'tool_font_size'      => '16',
			'tool_input_bg'       => '#071a2e',
			'tool_input_text'     => '#ffffff',
			'tool_input_border'   => 'rgba(255,255,255,0.12)',
			'tool_dropdown_bg'    => '#071a2e',
			'tool_dropdown_text'  => '#ffffff',
			'tool_button_text'    => '#02131f',
			'tool_radius'         => '22',
			'tool_control_radius' => '14',
			'qr_foreground'       => '#001f3d',
			'qr_background'       => '#ffffff',
			'qr_block_shape'      => 'rounded',
			'qr_corner_shape'     => 'extra-rounded',
			'qr_center_shape'     => 'square',
			'qr_frame_style'      => 'none',
			'qr_frame_color'      => '#ffffff',
			'qr_frame_text_color' => '#001f3d',
			'qr_frame_text'       => 'SCAN ME',
			'qr_logo_id'          => 0,
			'qr_logo_size'        => '18',
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

		foreach ( array( 'tool_bg', 'tool_panel_bg', 'tool_text', 'tool_muted', 'tool_accent', 'qr_foreground', 'qr_background', 'tool_input_bg', 'tool_input_text', 'tool_dropdown_bg', 'tool_dropdown_text', 'tool_button_text', 'qr_frame_color', 'qr_frame_text_color' ) as $key ) {
			$output[ $key ] = isset( $input[ $key ] ) ? $this->sanitize_color( $input[ $key ], $defaults[ $key ] ) : $output[ $key ];
		}

		foreach ( array( 'tool_border', 'tool_input_border' ) as $key ) {
			$output[ $key ] = isset( $input[ $key ] ) ? $this->sanitize_css_color( $input[ $key ], $defaults[ $key ] ) : $output[ $key ];
		}

		$output['tool_font_size']      = isset( $input['tool_font_size'] ) ? (string) min( max( absint( $input['tool_font_size'] ), 12 ), 24 ) : $output['tool_font_size'];
		$output['tool_radius']         = isset( $input['tool_radius'] ) ? (string) min( max( absint( $input['tool_radius'] ), 0 ), 42 ) : $output['tool_radius'];
		$output['tool_control_radius'] = isset( $input['tool_control_radius'] ) ? (string) min( max( absint( $input['tool_control_radius'] ), 0 ), 28 ) : $output['tool_control_radius'];
		$output['qr_logo_size']        = isset( $input['qr_logo_size'] ) ? (string) min( max( absint( $input['qr_logo_size'] ), 8 ), 30 ) : $output['qr_logo_size'];
		$output['qr_logo_id']          = isset( $input['qr_logo_id'] ) ? absint( $input['qr_logo_id'] ) : absint( $output['qr_logo_id'] ?? 0 );
		$output['qr_frame_text']       = isset( $input['qr_frame_text'] ) ? sanitize_text_field( $input['qr_frame_text'] ) : ( $output['qr_frame_text'] ?? $defaults['qr_frame_text'] );

		$shape_choices = array( 'square', 'rounded', 'dot', 'extra-rounded', 'classy', 'classy-rounded' );
		foreach ( array( 'qr_block_shape', 'qr_corner_shape' ) as $key ) {
			$value          = isset( $input[ $key ] ) ? sanitize_key( $input[ $key ] ) : $output[ $key ];
			$output[ $key ] = in_array( $value, $shape_choices, true ) ? $value : $defaults[ $key ];
		}

		$value = isset( $input['qr_center_shape'] ) ? sanitize_key( $input['qr_center_shape'] ) : $output['qr_center_shape'];
		$output['qr_center_shape'] = in_array( $value, array( 'square', 'dot' ), true ) ? $value : $defaults['qr_center_shape'];

		$value = isset( $input['qr_frame_style'] ) ? sanitize_key( $input['qr_frame_style'] ) : $output['qr_frame_style'];
		$output['qr_frame_style'] = in_array( $value, array( 'none', 'rounded-card', 'label', 'label-top', 'button-bottom', 'comment-box', 'ticket', 'phone', 'polaroid', 'double-border' ), true ) ? $value : $defaults['qr_frame_style'];

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
			<nav class="nav-tab-wrapper oneup-tools-tabs" aria-label="<?php echo esc_attr__( 'OneUp Tools settings tabs', 'oneup-tools' ); ?>">
				<a class="nav-tab nav-tab-active" href="#oneup-tools-design" data-oneup-tools-tab><?php echo esc_html__( 'General Tool Design', 'oneup-tools' ); ?></a>
				<a class="nav-tab" href="#oneup-tools-qr" data-oneup-tools-tab><?php echo esc_html__( 'QR Generator', 'oneup-tools' ); ?></a>
			</nav>
			<form method="post" action="options.php">
				<?php settings_fields( 'oneup_tools_options' ); ?>

				<section id="oneup-tools-design" class="oneup-tools-panel is-active" data-oneup-tools-panel>
					<h2><?php echo esc_html__( 'General Tool Design', 'oneup-tools' ); ?></h2>
					<p><?php echo esc_html__( 'These design settings apply to the QR Generator and all future OneUp tools.', 'oneup-tools' ); ?></p>
					<div class="oneup-tools-grid">
						<?php $this->color_field( $options, 'tool_bg', __( 'Tool background', 'oneup-tools' ) ); ?>
						<?php $this->color_field( $options, 'tool_panel_bg', __( 'Panel / preview background', 'oneup-tools' ) ); ?>
						<?php $this->color_field( $options, 'tool_text', __( 'Text color', 'oneup-tools' ) ); ?>
						<?php $this->color_field( $options, 'tool_muted', __( 'Muted text color', 'oneup-tools' ) ); ?>
						<?php $this->color_field( $options, 'tool_accent', __( 'Accent / button color', 'oneup-tools' ) ); ?>
						<?php $this->color_field( $options, 'tool_button_text', __( 'Button text color', 'oneup-tools' ) ); ?>
						<?php $this->color_field( $options, 'tool_input_bg', __( 'Text field background', 'oneup-tools' ) ); ?>
						<?php $this->color_field( $options, 'tool_input_text', __( 'Text field text color', 'oneup-tools' ) ); ?>
						<?php $this->text_field( $options, 'tool_input_border', __( 'Text field border color', 'oneup-tools' ) ); ?>
						<?php $this->color_field( $options, 'tool_dropdown_bg', __( 'Dropdown background', 'oneup-tools' ) ); ?>
						<?php $this->color_field( $options, 'tool_dropdown_text', __( 'Dropdown text color', 'oneup-tools' ) ); ?>
						<?php $this->text_field( $options, 'tool_border', __( 'Panel border color', 'oneup-tools' ) ); ?>
						<?php $this->number_field( $options, 'tool_font_size', __( 'Tool font size', 'oneup-tools' ), 12, 24 ); ?>
						<?php $this->number_field( $options, 'tool_radius', __( 'Tool card radius', 'oneup-tools' ), 0, 42 ); ?>
						<?php $this->number_field( $options, 'tool_control_radius', __( 'Input/dropdown radius', 'oneup-tools' ), 0, 28 ); ?>
					</div>
				</section>

				<section id="oneup-tools-qr" class="oneup-tools-panel" data-oneup-tools-panel hidden>
					<h2><?php echo esc_html__( 'QR Generator Defaults', 'oneup-tools' ); ?></h2>
					<p><?php echo esc_html__( 'These settings control the generated QR code itself.', 'oneup-tools' ); ?></p>
					<div class="oneup-tools-grid">
						<?php $this->color_field( $options, 'qr_foreground', __( 'Default QR foreground', 'oneup-tools' ) ); ?>
						<?php $this->color_field( $options, 'qr_background', __( 'Default QR background', 'oneup-tools' ) ); ?>
						<?php $this->select_field( $options, 'qr_block_shape', __( 'QR block shape', 'oneup-tools' ) ); ?>
						<?php $this->select_field( $options, 'qr_corner_shape', __( 'QR border style', 'oneup-tools' ) ); ?>
						<?php $this->select_field( $options, 'qr_center_shape', __( 'QR center style', 'oneup-tools' ) ); ?>
						<?php $this->select_field( $options, 'qr_frame_style', __( 'QR frame style', 'oneup-tools' ) ); ?>
						<?php $this->color_field( $options, 'qr_frame_color', __( 'QR frame color', 'oneup-tools' ) ); ?>
						<?php $this->color_field( $options, 'qr_frame_text_color', __( 'QR frame text color', 'oneup-tools' ) ); ?>
						<?php $this->text_field( $options, 'qr_frame_text', __( 'QR frame text', 'oneup-tools' ) ); ?>
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
		$choice_sets = array(
			'qr_block_shape'  => array(
				'square'         => __( 'Square', 'oneup-tools' ),
				'rounded'        => __( 'Rounded', 'oneup-tools' ),
				'dot'            => __( 'Dots', 'oneup-tools' ),
				'extra-rounded'  => __( 'Extra rounded', 'oneup-tools' ),
				'classy'         => __( 'Classy', 'oneup-tools' ),
				'classy-rounded' => __( 'Classy rounded', 'oneup-tools' ),
			),
			'qr_corner_shape' => array(
				'square'        => __( 'Square', 'oneup-tools' ),
				'rounded'       => __( 'Rounded', 'oneup-tools' ),
				'dot'           => __( 'Dot', 'oneup-tools' ),
				'extra-rounded' => __( 'Extra rounded', 'oneup-tools' ),
			),
			'qr_center_shape' => array(
				'square' => __( 'Square', 'oneup-tools' ),
				'dot'    => __( 'Dot', 'oneup-tools' ),
			),
			'qr_frame_style'  => array(
				'none'         => __( 'No frame', 'oneup-tools' ),
				'rounded-card' => __( 'Rounded card', 'oneup-tools' ),
				'label'        => __( 'Label card', 'oneup-tools' ),
				'ticket'       => __( 'Ticket', 'oneup-tools' ),
				'label-top'     => __( 'Top label', 'oneup-tools' ),
				'button-bottom' => __( 'Button below', 'oneup-tools' ),
				'comment-box'   => __( 'Comment box', 'oneup-tools' ),
				'phone'         => __( 'Phone screen', 'oneup-tools' ),
				'polaroid'      => __( 'Polaroid', 'oneup-tools' ),
				'double-border' => __( 'Double border', 'oneup-tools' ),
			),
		);
		$choices = $choice_sets[ $key ] ?? array(
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
