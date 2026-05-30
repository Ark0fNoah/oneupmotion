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
		add_shortcode( 'oneup_utm_generator', array( $this, 'render_utm_generator' ) );
		add_shortcode( 'oneup_og_preview', array( $this, 'render_og_preview' ) );
		add_shortcode( 'oneup_open_graph_preview', array( $this, 'render_og_preview' ) );
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
			'--oneup-tool-bg:%1$s;--oneup-tool-panel-bg:%2$s;--oneup-tool-text:%3$s;--oneup-tool-muted:%4$s;--oneup-tool-accent:%5$s;--oneup-tool-border:%6$s;--oneup-tool-font-size:%7$dpx;--oneup-tool-input-bg:%8$s;--oneup-tool-input-text:%9$s;--oneup-tool-input-border:%10$s;--oneup-tool-dropdown-bg:%11$s;--oneup-tool-dropdown-text:%12$s;--oneup-tool-button-text:%13$s;--oneup-tool-radius:%14$dpx;--oneup-tool-control-radius:%15$dpx;--oneup-qr-frame-color:%16$s;--oneup-qr-frame-text-color:%17$s;',
			esc_attr( $options['tool_bg'] ?? '#071a2e' ),
			esc_attr( $options['tool_panel_bg'] ?? '#03101f' ),
			esc_attr( $options['tool_text'] ?? '#ffffff' ),
			esc_attr( $options['tool_muted'] ?? 'rgba(255,255,255,0.72)' ),
			esc_attr( $options['tool_accent'] ?? '#20f0c0' ),
			esc_attr( $options['tool_border'] ?? 'rgba(255,255,255,0.12)' ),
			absint( $options['tool_font_size'] ?? 16 ),
			esc_attr( $options['tool_input_bg'] ?? '#071a2e' ),
			esc_attr( $options['tool_input_text'] ?? '#ffffff' ),
			esc_attr( $options['tool_input_border'] ?? 'rgba(255,255,255,0.12)' ),
			esc_attr( $options['tool_dropdown_bg'] ?? '#071a2e' ),
			esc_attr( $options['tool_dropdown_text'] ?? '#ffffff' ),
			esc_attr( $options['tool_button_text'] ?? '#02131f' ),
			absint( $options['tool_radius'] ?? 22 ),
			absint( $options['tool_control_radius'] ?? 14 ),
			esc_attr( $options['qr_frame_color'] ?? '#ffffff' ),
			esc_attr( $options['qr_frame_text_color'] ?? '#001f3d' )
		);

		$frame_options = array(
			'none'          => __( 'None', 'oneup-tools' ),
			'rounded-card'  => __( 'Card', 'oneup-tools' ),
			'label'         => __( 'Label', 'oneup-tools' ),
			'label-top'     => __( 'Top label', 'oneup-tools' ),
			'button-bottom' => __( 'Button', 'oneup-tools' ),
			'comment-box'   => __( 'Comment', 'oneup-tools' ),
			'ticket'        => __( 'Ticket', 'oneup-tools' ),
			'phone'         => __( 'Phone', 'oneup-tools' ),
			'polaroid'      => __( 'Polaroid', 'oneup-tools' ),
			'double-border' => __( 'Double', 'oneup-tools' ),
		);

		$shape_options = array(
			'square'         => __( 'Square', 'oneup-tools' ),
			'rounded'        => __( 'Rounded', 'oneup-tools' ),
			'dot'            => __( 'Dots', 'oneup-tools' ),
			'extra-rounded'  => __( 'Extra', 'oneup-tools' ),
			'classy'         => __( 'Classy', 'oneup-tools' ),
			'classy-rounded' => __( 'Classy round', 'oneup-tools' ),
		);

		ob_start();
		?>
		<section class="oneup-tool oneup-qr" style="<?php echo esc_attr( $style ); ?>" data-oneup-qr-generator data-default-logo="<?php echo esc_url( $logo_url ); ?>" data-default-logo-size="<?php echo esc_attr( absint( $options['qr_logo_size'] ?? 18 ) ); ?>" data-default-frame="<?php echo esc_attr( $options['qr_frame_style'] ?? 'none' ); ?>" data-qr-engine="qr-code-styling">
			<div class="oneup-tool__header">
				<p class="oneup-tool__eyebrow"><?php echo esc_html__( 'OneUp Tools', 'oneup-tools' ); ?></p>
				<h2><?php echo esc_html__( 'QR Generator', 'oneup-tools' ); ?></h2>
				<p><?php echo esc_html__( 'Create branded QR codes with custom shapes, colors, frames and an optional center logo.', 'oneup-tools' ); ?></p>
			</div>

			<form class="oneup-qr__form" action="#" method="post">
				<div class="oneup-qr__step oneup-qr__step--content">
					<h3><span>1</span><?php echo esc_html__( 'Content', 'oneup-tools' ); ?></h3>
					<label>
						<span><?php echo esc_html__( 'Website or text', 'oneup-tools' ); ?></span>
						<input type="text" name="oneup_qr_url" placeholder="<?php echo esc_attr__( 'https://oneupmotion.com', 'oneup-tools' ); ?>" value="">
					</label>
				</div>

				<div class="oneup-qr__step oneup-qr__step--design">
					<h3><span>2</span><?php echo esc_html__( 'Design', 'oneup-tools' ); ?></h3>

					<div class="oneup-qr__tabs" role="tablist" aria-label="<?php echo esc_attr__( 'QR design options', 'oneup-tools' ); ?>">
						<button type="button" class="is-active" data-oneup-design-tab="frame"><?php echo esc_html__( 'Frame', 'oneup-tools' ); ?></button>
						<button type="button" data-oneup-design-tab="shape"><?php echo esc_html__( 'Shape', 'oneup-tools' ); ?></button>
						<button type="button" data-oneup-design-tab="logo"><?php echo esc_html__( 'Logo', 'oneup-tools' ); ?></button>
						<button type="button" data-oneup-design-tab="level"><?php echo esc_html__( 'Color', 'oneup-tools' ); ?></button>
					</div>

					<div class="oneup-qr__design-panel is-active" data-oneup-design-panel="frame">
						<input type="hidden" name="oneup_qr_frame_style" value="<?php echo esc_attr( $options['qr_frame_style'] ?? 'none' ); ?>">
						<div class="oneup-qr__option-grid oneup-qr__option-grid--frames">
							<?php foreach ( $frame_options as $value => $label ) : ?>
								<button type="button" class="oneup-qr__option-card<?php echo selected( $options['qr_frame_style'] ?? 'none', $value, false ) ? ' is-active' : ''; ?>" data-oneup-frame-option="<?php echo esc_attr( $value ); ?>">
									<span class="oneup-qr__frame-thumb oneup-qr__frame-thumb--<?php echo esc_attr( $value ); ?>"><i></i></span>
									<em><?php echo esc_html( $label ); ?></em>
								</button>
							<?php endforeach; ?>
						</div>
						<div class="oneup-qr__mini-grid">
							<label>
								<span><?php echo esc_html__( 'Frame color', 'oneup-tools' ); ?></span>
								<input type="color" name="oneup_qr_frame_color" value="<?php echo esc_attr( $options['qr_frame_color'] ?? '#ffffff' ); ?>">
							</label>
							<label>
								<span><?php echo esc_html__( 'Text color', 'oneup-tools' ); ?></span>
								<input type="color" name="oneup_qr_frame_text_color" value="<?php echo esc_attr( $options['qr_frame_text_color'] ?? '#001f3d' ); ?>">
							</label>
							<label>
								<span><?php echo esc_html__( 'Frame text', 'oneup-tools' ); ?></span>
								<input type="text" name="oneup_qr_frame_text" value="<?php echo esc_attr( $options['qr_frame_text'] ?? 'SCAN ME' ); ?>">
							</label>
						</div>
					</div>

					<div class="oneup-qr__design-panel" data-oneup-design-panel="shape" hidden>
						<label>
							<span><?php echo esc_html__( 'Block shape', 'oneup-tools' ); ?></span>
							<select name="oneup_qr_block_shape">
								<?php foreach ( $shape_options as $value => $label ) : ?>
									<option value="<?php echo esc_attr( $value ); ?>" <?php selected( $options['qr_block_shape'] ?? 'rounded', $value ); ?>><?php echo esc_html( $label ); ?></option>
								<?php endforeach; ?>
							</select>
						</label>
						<div class="oneup-qr__mini-grid">
							<label>
								<span><?php echo esc_html__( 'Border style', 'oneup-tools' ); ?></span>
								<select name="oneup_qr_corner_shape">
									<?php foreach ( array( 'square' => __( 'Square', 'oneup-tools' ), 'rounded' => __( 'Rounded', 'oneup-tools' ), 'dot' => __( 'Dot', 'oneup-tools' ), 'extra-rounded' => __( 'Extra rounded', 'oneup-tools' ) ) as $value => $label ) : ?>
										<option value="<?php echo esc_attr( $value ); ?>" <?php selected( $options['qr_corner_shape'] ?? 'extra-rounded', $value ); ?>><?php echo esc_html( $label ); ?></option>
									<?php endforeach; ?>
								</select>
							</label>
							<label>
								<span><?php echo esc_html__( 'Center style', 'oneup-tools' ); ?></span>
								<select name="oneup_qr_center_shape">
									<?php foreach ( array( 'square' => __( 'Square', 'oneup-tools' ), 'dot' => __( 'Dot', 'oneup-tools' ) ) as $value => $label ) : ?>
										<option value="<?php echo esc_attr( $value ); ?>" <?php selected( $options['qr_center_shape'] ?? 'square', $value ); ?>><?php echo esc_html( $label ); ?></option>
									<?php endforeach; ?>
								</select>
							</label>
						</div>
					</div>

					<div class="oneup-qr__design-panel" data-oneup-design-panel="logo" hidden>
						<label>
							<span><?php echo esc_html__( 'Logo image', 'oneup-tools' ); ?></span>
							<input type="file" name="oneup_qr_logo" accept="image/*">
							<small><?php echo esc_html__( 'Optional. Leave empty to use the configured default logo.', 'oneup-tools' ); ?></small>
						</label>
						<label>
							<span><?php echo esc_html__( 'Logo size', 'oneup-tools' ); ?></span>
							<input type="range" name="oneup_qr_logo_size" min="8" max="30" value="<?php echo esc_attr( absint( $options['qr_logo_size'] ?? 18 ) ); ?>">
						</label>
					</div>

					<div class="oneup-qr__design-panel" data-oneup-design-panel="level" hidden>
						<div class="oneup-qr__mini-grid">
							<label>
								<span><?php echo esc_html__( 'QR color', 'oneup-tools' ); ?></span>
								<input type="color" name="oneup_qr_foreground" value="<?php echo esc_attr( $options['qr_foreground'] ?? '#001f3d' ); ?>">
							</label>
							<label>
								<span><?php echo esc_html__( 'Background', 'oneup-tools' ); ?></span>
								<input type="color" name="oneup_qr_background" value="<?php echo esc_attr( $options['qr_background'] ?? '#ffffff' ); ?>">
							</label>
						</div>
					</div>

					<button class="oneup-tool__button" type="button" data-oneup-qr-generate>
						<?php echo esc_html__( 'Generate QR', 'oneup-tools' ); ?>
					</button>
				</div>
			</form>

			<div class="oneup-qr__preview-wrap" aria-live="polite">
				<h3><span>3</span><?php echo esc_html__( 'Download', 'oneup-tools' ); ?></h3>
				<div class="oneup-qr__preview" data-oneup-qr-preview>
					<span><?php echo esc_html__( 'QR preview', 'oneup-tools' ); ?></span>
				</div>
				<p class="oneup-qr__message" data-oneup-qr-message></p>
				<button class="oneup-tool__button oneup-tool__button--secondary" type="button" data-oneup-qr-download disabled>
					<?php echo esc_html__( 'Download PNG', 'oneup-tools' ); ?>
				</button>
			</div>
		</section>
		<?php

		return ob_get_clean();
	}

	//───────────────────────────────────────
	// UTM generator shortcode
	//───────────────────────────────────────
	public function render_utm_generator( $atts = array(), $content = null ) {
		if ( $this->assets instanceof Assets ) {
			$this->assets->enqueue_utm_assets();
		}

		$options = class_exists( __NAMESPACE__ . '\Settings' ) ? Settings::get_options() : array();

		$style = sprintf(
			'--oneup-tool-bg:%1$s;--oneup-tool-panel-bg:%2$s;--oneup-tool-text:%3$s;--oneup-tool-muted:%4$s;--oneup-tool-accent:%5$s;--oneup-tool-border:%6$s;--oneup-tool-font-size:%7$dpx;--oneup-tool-input-bg:%8$s;--oneup-tool-input-text:%9$s;--oneup-tool-input-border:%10$s;--oneup-tool-dropdown-bg:%11$s;--oneup-tool-dropdown-text:%12$s;--oneup-tool-button-text:%13$s;--oneup-tool-radius:%14$dpx;--oneup-tool-control-radius:%15$dpx;',
			esc_attr( $options['tool_bg'] ?? '#071a2e' ),
			esc_attr( $options['tool_panel_bg'] ?? '#03101f' ),
			esc_attr( $options['tool_text'] ?? '#ffffff' ),
			esc_attr( $options['tool_muted'] ?? 'rgba(255,255,255,0.72)' ),
			esc_attr( $options['tool_accent'] ?? '#20f0c0' ),
			esc_attr( $options['tool_border'] ?? 'rgba(255,255,255,0.12)' ),
			absint( $options['tool_font_size'] ?? 16 ),
			esc_attr( $options['tool_input_bg'] ?? '#071a2e' ),
			esc_attr( $options['tool_input_text'] ?? '#ffffff' ),
			esc_attr( $options['tool_input_border'] ?? 'rgba(255,255,255,0.12)' ),
			esc_attr( $options['tool_dropdown_bg'] ?? '#071a2e' ),
			esc_attr( $options['tool_dropdown_text'] ?? '#ffffff' ),
			esc_attr( $options['tool_button_text'] ?? '#02131f' ),
			absint( $options['tool_radius'] ?? 22 ),
			absint( $options['tool_control_radius'] ?? 14 )
		);

		ob_start();
		?>
		<section class="oneup-tool oneup-utm" style="<?php echo esc_attr( $style ); ?>" data-oneup-utm-generator>
			<div class="oneup-tool__header">
				<p class="oneup-tool__eyebrow"><?php echo esc_html__( 'OneUp Tools', 'oneup-tools' ); ?></p>
				<h2><?php echo esc_html__( 'UTM Builder', 'oneup-tools' ); ?></h2>
				<p><?php echo esc_html__( 'Build campaign URLs with all common UTM parameters, preview the result instantly, and copy or download it.', 'oneup-tools' ); ?></p>
			</div>

			<form class="oneup-utm__form" action="#" method="post">
				<div class="oneup-utm__step">
					<h3><span>1</span><?php echo esc_html__( 'Destination', 'oneup-tools' ); ?></h3>
					<label class="oneup-utm__field oneup-utm__field--full">
						<span><?php echo esc_html__( 'Website URL', 'oneup-tools' ); ?></span>
						<input type="url" name="oneup_utm_url" placeholder="<?php echo esc_attr__( 'https://oneupmotion.com/landing-page', 'oneup-tools' ); ?>" autocomplete="url">
					</label>
				</div>

				<div class="oneup-utm__step">
					<h3><span>2</span><?php echo esc_html__( 'Campaign source', 'oneup-tools' ); ?></h3>
					<div class="oneup-utm__grid">
						<label class="oneup-utm__field">
							<span><?php echo esc_html__( 'utm_source', 'oneup-tools' ); ?></span>
							<input type="text" name="utm_source" placeholder="<?php echo esc_attr__( 'google, instagram, newsletter', 'oneup-tools' ); ?>">
						</label>
						<label class="oneup-utm__field">
							<span><?php echo esc_html__( 'utm_medium', 'oneup-tools' ); ?></span>
							<input type="text" name="utm_medium" placeholder="<?php echo esc_attr__( 'cpc, social, email', 'oneup-tools' ); ?>">
						</label>
						<label class="oneup-utm__field">
							<span><?php echo esc_html__( 'utm_campaign', 'oneup-tools' ); ?></span>
							<input type="text" name="utm_campaign" placeholder="<?php echo esc_attr__( 'spring_launch', 'oneup-tools' ); ?>">
						</label>
						<label class="oneup-utm__field">
							<span><?php echo esc_html__( 'utm_id', 'oneup-tools' ); ?></span>
							<input type="text" name="utm_id" placeholder="<?php echo esc_attr__( 'campaign-2026-01', 'oneup-tools' ); ?>">
						</label>
					</div>
				</div>

				<div class="oneup-utm__step">
					<h3><span>3</span><?php echo esc_html__( 'Optional tracking', 'oneup-tools' ); ?></h3>
					<div class="oneup-utm__grid">
						<label class="oneup-utm__field">
							<span><?php echo esc_html__( 'utm_term', 'oneup-tools' ); ?></span>
							<input type="text" name="utm_term" placeholder="<?php echo esc_attr__( 'keyword or audience', 'oneup-tools' ); ?>">
						</label>
						<label class="oneup-utm__field">
							<span><?php echo esc_html__( 'utm_content', 'oneup-tools' ); ?></span>
							<input type="text" name="utm_content" placeholder="<?php echo esc_attr__( 'button_a, image_ad', 'oneup-tools' ); ?>">
						</label>
						<label class="oneup-utm__field">
							<span><?php echo esc_html__( 'Creative format', 'oneup-tools' ); ?></span>
							<input type="text" name="utm_creative_format" placeholder="<?php echo esc_attr__( 'video, banner, carousel', 'oneup-tools' ); ?>">
						</label>
						<label class="oneup-utm__field">
							<span><?php echo esc_html__( 'Marketing tactic', 'oneup-tools' ); ?></span>
							<input type="text" name="utm_marketing_tactic" placeholder="<?php echo esc_attr__( 'retargeting, prospecting', 'oneup-tools' ); ?>">
						</label>
					</div>
				</div>

				<div class="oneup-utm__step">
					<h3><span>4</span><?php echo esc_html__( 'Options', 'oneup-tools' ); ?></h3>
					<div class="oneup-utm__grid">
						<label class="oneup-utm__field">
							<span><?php echo esc_html__( 'Space format', 'oneup-tools' ); ?></span>
							<select name="oneup_utm_space_format">
								<option value="dash"><?php echo esc_html__( 'Replace spaces with -', 'oneup-tools' ); ?></option>
								<option value="underscore"><?php echo esc_html__( 'Replace spaces with _', 'oneup-tools' ); ?></option>
								<option value="plus"><?php echo esc_html__( 'Replace spaces with +', 'oneup-tools' ); ?></option>
								<option value="encoded"><?php echo esc_html__( 'Encode spaces as %20', 'oneup-tools' ); ?></option>
							</select>
						</label>
						<label class="oneup-utm__field oneup-utm__field--checkbox">
							<input type="checkbox" name="oneup_utm_lowercase" checked>
							<span><?php echo esc_html__( 'Lowercase UTM values', 'oneup-tools' ); ?></span>
						</label>
						<label class="oneup-utm__field oneup-utm__field--checkbox">
							<input type="checkbox" name="oneup_utm_preserve_existing" checked>
							<span><?php echo esc_html__( 'Preserve existing URL parameters', 'oneup-tools' ); ?></span>
						</label>
					</div>
				</div>
			</form>

			<div class="oneup-utm__result" aria-live="polite">
				<h3><span>5</span><?php echo esc_html__( 'Generated URL', 'oneup-tools' ); ?></h3>
				<textarea name="oneup_utm_result" readonly placeholder="<?php echo esc_attr__( 'Your UTM link will appear here…', 'oneup-tools' ); ?>"></textarea>
				<p class="oneup-utm__message" data-oneup-utm-message></p>
				<div class="oneup-utm__actions">
					<button class="oneup-tool__button" type="button" data-oneup-utm-copy disabled><?php echo esc_html__( 'Copy URL', 'oneup-tools' ); ?></button>
					<button class="oneup-tool__button oneup-tool__button--secondary" type="button" data-oneup-utm-open disabled><?php echo esc_html__( 'Open URL', 'oneup-tools' ); ?></button>
					<button class="oneup-tool__button oneup-tool__button--secondary" type="button" data-oneup-utm-download disabled><?php echo esc_html__( 'Download TXT', 'oneup-tools' ); ?></button>
					<button class="oneup-tool__button oneup-tool__button--ghost" type="button" data-oneup-utm-clear><?php echo esc_html__( 'Clear', 'oneup-tools' ); ?></button>
				</div>
			</div>
		</section>
		<?php

		return ob_get_clean();
	}
	//───────────────────────────────────────
	// Open Graph preview shortcode
	//───────────────────────────────────────
	public function render_og_preview( $atts = array(), $content = null ) {
		if ( $this->assets instanceof Assets ) {
			$this->assets->enqueue_og_assets();
		}

		$options = class_exists( __NAMESPACE__ . '\Settings' ) ? Settings::get_options() : array();

		$style = sprintf(
			'--oneup-tool-bg:%1$s;--oneup-tool-panel-bg:%2$s;--oneup-tool-text:%3$s;--oneup-tool-muted:%4$s;--oneup-tool-accent:%5$s;--oneup-tool-border:%6$s;--oneup-tool-font-size:%7$dpx;--oneup-tool-input-bg:%8$s;--oneup-tool-input-text:%9$s;--oneup-tool-input-border:%10$s;--oneup-tool-dropdown-bg:%11$s;--oneup-tool-dropdown-text:%12$s;--oneup-tool-button-text:%13$s;--oneup-tool-radius:%14$dpx;--oneup-tool-control-radius:%15$dpx;',
			esc_attr( $options['tool_bg'] ?? '#071a2e' ),
			esc_attr( $options['tool_panel_bg'] ?? '#03101f' ),
			esc_attr( $options['tool_text'] ?? '#ffffff' ),
			esc_attr( $options['tool_muted'] ?? 'rgba(255,255,255,0.72)' ),
			esc_attr( $options['tool_accent'] ?? '#20f0c0' ),
			esc_attr( $options['tool_border'] ?? 'rgba(255,255,255,0.12)' ),
			absint( $options['tool_font_size'] ?? 16 ),
			esc_attr( $options['tool_input_bg'] ?? '#071a2e' ),
			esc_attr( $options['tool_input_text'] ?? '#ffffff' ),
			esc_attr( $options['tool_input_border'] ?? 'rgba(255,255,255,0.12)' ),
			esc_attr( $options['tool_dropdown_bg'] ?? '#071a2e' ),
			esc_attr( $options['tool_dropdown_text'] ?? '#ffffff' ),
			esc_attr( $options['tool_button_text'] ?? '#02131f' ),
			absint( $options['tool_radius'] ?? 22 ),
			absint( $options['tool_control_radius'] ?? 14 )
		);

		ob_start();
		?>
		<section class="oneup-tool oneup-og" style="<?php echo esc_attr( $style ); ?>" data-oneup-og-preview>
			<div class="oneup-tool__header">
				<p class="oneup-tool__eyebrow"><?php echo esc_html__( 'OneUp Tools', 'oneup-tools' ); ?></p>
				<h2><?php echo esc_html__( 'Open Graph Preview Generator', 'oneup-tools' ); ?></h2>
				<p><?php echo esc_html__( 'Preview how your page could look when shared on LinkedIn, Facebook, X, Discord and other social platforms.', 'oneup-tools' ); ?></p>
			</div>

			<form class="oneup-og__form" action="#" method="post">
				<div class="oneup-og__step">
					<h3><span>1</span><?php echo esc_html__( 'Page details', 'oneup-tools' ); ?></h3>
					<label class="oneup-og__field oneup-og__field--full">
						<span><?php echo esc_html__( 'Page URL', 'oneup-tools' ); ?></span>
						<input type="url" name="oneup_og_url" placeholder="<?php echo esc_attr__( 'https://oneupmotion.com/your-page', 'oneup-tools' ); ?>">
					</label>
					<label class="oneup-og__field">
						<span><?php echo esc_html__( 'Page title', 'oneup-tools' ); ?></span>
						<input type="text" name="oneup_og_title" maxlength="120" placeholder="<?php echo esc_attr__( 'OneUp Motion — Creative tools for digital creators', 'oneup-tools' ); ?>">
						<small data-oneup-counter="oneup_og_title">0/60</small>
					</label>
					<label class="oneup-og__field">
						<span><?php echo esc_html__( 'Site name', 'oneup-tools' ); ?></span>
						<input type="text" name="oneup_og_site" placeholder="<?php echo esc_attr__( 'OneUp Motion', 'oneup-tools' ); ?>">
					</label>
					<label class="oneup-og__field oneup-og__field--full">
						<span><?php echo esc_html__( 'Description', 'oneup-tools' ); ?></span>
						<textarea name="oneup_og_description" rows="4" maxlength="240" placeholder="<?php echo esc_attr__( 'Create, preview and improve your social sharing cards before publishing.', 'oneup-tools' ); ?>"></textarea>
						<small data-oneup-counter="oneup_og_description">0/160</small>
					</label>
				</div>

				<div class="oneup-og__step">
					<h3><span>2</span><?php echo esc_html__( 'Image', 'oneup-tools' ); ?></h3>
					<div class="oneup-og__image-grid">
						<label class="oneup-og__field">
							<span><?php echo esc_html__( 'Image URL', 'oneup-tools' ); ?></span>
							<input type="url" name="oneup_og_image_url" placeholder="<?php echo esc_attr__( 'https://example.com/social-image.jpg', 'oneup-tools' ); ?>">
						</label>
						<label class="oneup-og__field">
							<span><?php echo esc_html__( 'Upload image', 'oneup-tools' ); ?></span>
							<input type="file" name="oneup_og_image_file" accept="image/*">
						</label>
					</div>
					<div class="oneup-og__tips">
						<strong><?php echo esc_html__( 'Recommended size:', 'oneup-tools' ); ?></strong>
						<span><?php echo esc_html__( '1200 × 630 px for most platforms.', 'oneup-tools' ); ?></span>
					</div>
				</div>

				<div class="oneup-og__step">
					<h3><span>3</span><?php echo esc_html__( 'Preview options', 'oneup-tools' ); ?></h3>
					<div class="oneup-og__platforms" role="tablist" aria-label="<?php echo esc_attr__( 'Preview platform', 'oneup-tools' ); ?>">
						<button type="button" class="is-active" data-oneup-og-platform="linkedin"><?php echo esc_html__( 'LinkedIn', 'oneup-tools' ); ?></button>
						<button type="button" data-oneup-og-platform="facebook"><?php echo esc_html__( 'Facebook', 'oneup-tools' ); ?></button>
						<button type="button" data-oneup-og-platform="x"><?php echo esc_html__( 'X', 'oneup-tools' ); ?></button>
						<button type="button" data-oneup-og-platform="discord"><?php echo esc_html__( 'Discord', 'oneup-tools' ); ?></button>
						<button type="button" data-oneup-og-platform="generic"><?php echo esc_html__( 'Generic', 'oneup-tools' ); ?></button>
					</div>
				</div>
			</form>

			<div class="oneup-og__result" aria-live="polite">
				<h3><span>4</span><?php echo esc_html__( 'Live preview', 'oneup-tools' ); ?></h3>
				<div class="oneup-og-card oneup-og-card--linkedin" data-oneup-og-card>
					<div class="oneup-og-card__image" data-oneup-og-image>
						<span><?php echo esc_html__( 'Social image preview', 'oneup-tools' ); ?></span>
					</div>
					<div class="oneup-og-card__body">
						<p class="oneup-og-card__domain" data-oneup-og-domain><?php echo esc_html__( 'oneupmotion.com', 'oneup-tools' ); ?></p>
						<strong data-oneup-og-preview-title><?php echo esc_html__( 'Your page title appears here', 'oneup-tools' ); ?></strong>
						<p data-oneup-og-preview-description><?php echo esc_html__( 'Your description appears here. Keep it clear, specific and easy to understand.', 'oneup-tools' ); ?></p>
						<small data-oneup-og-site><?php echo esc_html__( 'OneUp Motion', 'oneup-tools' ); ?></small>
					</div>
				</div>

				<div class="oneup-og__meta">
					<h4><?php echo esc_html__( 'Meta tags', 'oneup-tools' ); ?></h4>
					<textarea name="oneup_og_tags" readonly></textarea>
				</div>

				<div class="oneup-og__actions">
					<button class="oneup-tool__button" type="button" data-oneup-og-copy-tags><?php echo esc_html__( 'Copy Meta Tags', 'oneup-tools' ); ?></button>
					<button class="oneup-tool__button oneup-tool__button--secondary" type="button" data-oneup-og-copy-summary><?php echo esc_html__( 'Copy Summary', 'oneup-tools' ); ?></button>
					<button class="oneup-tool__button oneup-tool__button--ghost" type="button" data-oneup-og-clear><?php echo esc_html__( 'Clear', 'oneup-tools' ); ?></button>
				</div>
				<p class="oneup-og__message" data-oneup-og-message></p>
			</div>
		</section>
		<?php

		return ob_get_clean();
	}

}
