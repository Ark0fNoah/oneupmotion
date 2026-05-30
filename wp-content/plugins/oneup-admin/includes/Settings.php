<?php
/**
 * Settings page and option handling.
 *
 * @package OneUpAdmin
 */

namespace OneUp_Admin;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Settings {
	const OPTION_NAME = 'oneup_admin_options';

	/**
	 * Settings page hook suffix.
	 *
	 * @var string
	 */
	private $page_hook = '';

	//───────────────────────────────────────
	// Register hooks
	//───────────────────────────────────────
	public function register() {
		add_action( 'admin_menu', array( $this, 'register_page' ) );
		add_action( 'admin_init', array( $this, 'handle_save' ) );
	}

	//───────────────────────────────────────
	// Guarded page hook getter
	//───────────────────────────────────────
	public function get_page_hook() {
		return $this->page_hook;
	}

	//───────────────────────────────────────
	// Register settings page
	//───────────────────────────────────────
	public function register_page() {
		$this->page_hook = add_menu_page(
			esc_html__( 'OneUp Admin Settings', 'oneup-admin' ),
			esc_html__( 'OneUp Admin', 'oneup-admin' ),
			'manage_options',
			'oneup-admin',
			array( $this, 'render_page' ),
			'dashicons-arrow-up-alt2',
			3
		);
	}

	//───────────────────────────────────────
	// Defaults
	//───────────────────────────────────────
	public function defaults() {
		return array(
			'admin_logo_id'              => 0,
			'login_logo_id'              => 0,
			'brand_name'                 => 'OneUp Motion',
			'footer_text'                => 'OneUp Motion admin experience.',
			'accent_color'               => '#20f0c0',
			'dark_background'            => '#03101f',
			'enable_custom_dashboard'    => '1',
			'show_welcome_card'          => '1',
			'show_quick_links'           => '1',
			'show_site_status_card'      => '1',
			'show_roadmap_card'          => '1',
			'enable_branded_login'       => '1',
			'login_headline'             => 'Welcome back',
			'login_subtext'              => 'Sign in to manage OneUp Motion.',
			'login_button_style'         => 'filled',
			'enable_menu_cleanup'        => '1',
			'rename_pages'               => '1',
			'rename_media'               => '1',
			'hide_comments'              => '1',
			'hide_tools'                 => '0',
			'hide_cookie_plugin_menu'    => '1',
			'cookie_keywords'            => "complianz\ncmplz\ncookie\ncookies\ncookie-notice\ncookie-law\niubenda\ncookiebot\ngdpr\nborlabs",
			'disable_dashboard_widgets'  => '1',
			'hide_wp_version_footer'     => '1',
			'enable_compact_admin'       => '0',
			'enable_stronger_styling'    => '1',
			'custom_admin_css'           => '',
		);
	}

	//───────────────────────────────────────
	// Options getter
	//───────────────────────────────────────
	public function get_options() {
		$saved = get_option( self::OPTION_NAME, array() );

		if ( ! is_array( $saved ) ) {
			$saved = array();
		}

		return wp_parse_args( $saved, $this->defaults() );
	}

	//───────────────────────────────────────
	// Single option getter
	//───────────────────────────────────────
	public function get( $key, $default = null ) {
		$options = $this->get_options();

		if ( array_key_exists( $key, $options ) ) {
			return $options[ $key ];
		}

		return null === $default ? '' : $default;
	}

	//───────────────────────────────────────
	// Tabs
	//───────────────────────────────────────
	public function tabs() {
		return array(
			'branding'  => esc_html__( 'Branding', 'oneup-admin' ),
			'dashboard' => esc_html__( 'Dashboard', 'oneup-admin' ),
			'login'     => esc_html__( 'Login', 'oneup-admin' ),
			'menu'      => esc_html__( 'Menu', 'oneup-admin' ),
			'advanced'  => esc_html__( 'Advanced', 'oneup-admin' ),
		);
	}

	//───────────────────────────────────────
	// Field map
	//───────────────────────────────────────
	public function fields_by_tab() {
		return array(
			'branding'  => array( 'admin_logo_id', 'login_logo_id', 'brand_name', 'footer_text', 'accent_color', 'dark_background' ),
			'dashboard' => array( 'enable_custom_dashboard', 'show_welcome_card', 'show_quick_links', 'show_site_status_card', 'show_roadmap_card' ),
			'login'     => array( 'enable_branded_login', 'login_headline', 'login_subtext', 'login_button_style' ),
			'menu'      => array( 'enable_menu_cleanup', 'rename_pages', 'rename_media', 'hide_comments', 'hide_tools', 'hide_cookie_plugin_menu', 'cookie_keywords' ),
			'advanced'  => array( 'disable_dashboard_widgets', 'hide_wp_version_footer', 'enable_compact_admin', 'enable_stronger_styling', 'custom_admin_css' ),
		);
	}

	//───────────────────────────────────────
	// Checkbox fields
	//───────────────────────────────────────
	private function checkbox_fields() {
		return array(
			'enable_custom_dashboard',
			'show_welcome_card',
			'show_quick_links',
			'show_site_status_card',
			'show_roadmap_card',
			'enable_branded_login',
			'enable_menu_cleanup',
			'rename_pages',
			'rename_media',
			'hide_comments',
			'hide_tools',
			'hide_cookie_plugin_menu',
			'disable_dashboard_widgets',
			'hide_wp_version_footer',
			'enable_compact_admin',
			'enable_stronger_styling',
		);
	}

	//───────────────────────────────────────
	// Save handler
	//───────────────────────────────────────
	public function handle_save() {
		if ( ! isset( $_POST['oneup_admin_action'] ) || 'save_settings' !== sanitize_key( wp_unslash( $_POST['oneup_admin_action'] ) ) ) {
			return;
		}

		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}

		check_admin_referer( 'oneup_admin_save_settings', 'oneup_admin_nonce' );

		$tab          = isset( $_POST['oneup_admin_tab'] ) ? sanitize_key( wp_unslash( $_POST['oneup_admin_tab'] ) ) : 'branding';
		$fields_by_tab = $this->fields_by_tab();

		if ( ! isset( $fields_by_tab[ $tab ] ) ) {
			$tab = 'branding';
		}

		$options   = $this->get_options();
		$submitted = isset( $_POST['oneup_admin_options'] ) && is_array( $_POST['oneup_admin_options'] ) ? wp_unslash( $_POST['oneup_admin_options'] ) : array();

		foreach ( $fields_by_tab[ $tab ] as $field ) {
			if ( in_array( $field, $this->checkbox_fields(), true ) ) {
				$options[ $field ] = isset( $submitted[ $field ] ) ? '1' : '0';
				continue;
			}

			if ( array_key_exists( $field, $submitted ) ) {
				$options[ $field ] = $this->sanitize_field( $field, $submitted[ $field ] );
			}
		}

		update_option( self::OPTION_NAME, $options );

		$redirect = add_query_arg(
			array(
				'page'    => 'oneup-admin',
				'tab'     => $tab,
				'updated' => '1',
			),
			admin_url( 'admin.php' )
		);

		wp_safe_redirect( $redirect );
		exit;
	}

	//───────────────────────────────────────
	// Sanitize field
	//───────────────────────────────────────
	private function sanitize_field( $field, $value ) {
		switch ( $field ) {
			case 'admin_logo_id':
			case 'login_logo_id':
				return absint( $value );
			case 'accent_color':
			case 'dark_background':
				$color = sanitize_hex_color( $value );
				return $color ? $color : $this->defaults()[ $field ];
			case 'login_button_style':
				$allowed = array( 'filled', 'gradient', 'outline' );
				$value   = sanitize_key( $value );
				return in_array( $value, $allowed, true ) ? $value : 'filled';
			case 'cookie_keywords':
			case 'custom_admin_css':
			case 'login_subtext':
				return sanitize_textarea_field( $value );
			default:
				return sanitize_text_field( $value );
		}
	}

	//───────────────────────────────────────
	// Render settings page
	//───────────────────────────────────────
	public function render_page() {
		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}

		$tabs       = $this->tabs();
		$active_tab = isset( $_GET['tab'] ) ? sanitize_key( wp_unslash( $_GET['tab'] ) ) : 'branding';

		if ( ! isset( $tabs[ $active_tab ] ) ) {
			$active_tab = 'branding';
		}

		$options = $this->get_options();
		?>
		<div class="wrap oneup-admin-wrap">
			<div class="oneup-admin-hero">
				<div>
					<p class="oneup-admin-eyebrow"><?php echo esc_html__( 'OneUp Motion', 'oneup-admin' ); ?></p>
					<h1><?php echo esc_html__( 'Admin Settings', 'oneup-admin' ); ?></h1>
					<p><?php echo esc_html__( 'Control the branded WordPress admin experience, login screen, dashboard and menu cleanup.', 'oneup-admin' ); ?></p>
				</div>
			</div>

			<?php if ( isset( $_GET['updated'] ) ) : ?>
				<div class="notice notice-success is-dismissible"><p><?php echo esc_html__( 'Settings saved.', 'oneup-admin' ); ?></p></div>
			<?php endif; ?>

			<nav class="nav-tab-wrapper oneup-admin-tabs" aria-label="<?php echo esc_attr__( 'OneUp Admin tabs', 'oneup-admin' ); ?>">
				<?php foreach ( $tabs as $slug => $label ) : ?>
					<a class="nav-tab <?php echo $active_tab === $slug ? 'nav-tab-active' : ''; ?>" href="<?php echo esc_url( add_query_arg( array( 'page' => 'oneup-admin', 'tab' => $slug ), admin_url( 'admin.php' ) ) ); ?>"><?php echo esc_html( $label ); ?></a>
				<?php endforeach; ?>
			</nav>

			<form method="post" action="<?php echo esc_url( admin_url( 'admin.php?page=oneup-admin&tab=' . $active_tab ) ); ?>" class="oneup-admin-card">
				<?php wp_nonce_field( 'oneup_admin_save_settings', 'oneup_admin_nonce' ); ?>
				<input type="hidden" name="oneup_admin_action" value="save_settings">
				<input type="hidden" name="oneup_admin_tab" value="<?php echo esc_attr( $active_tab ); ?>">

				<?php $this->render_tab_fields( $active_tab, $options ); ?>

				<p class="submit">
					<button type="submit" class="button button-primary oneup-admin-save"><?php echo esc_html__( 'Save Settings', 'oneup-admin' ); ?></button>
				</p>
			</form>
		</div>
		<?php
	}

	//───────────────────────────────────────
	// Render tab fields
	//───────────────────────────────────────
	private function render_tab_fields( $tab, $options ) {
		switch ( $tab ) {
			case 'branding':
				$this->render_media_field( 'admin_logo_id', esc_html__( 'Admin logo', 'oneup-admin' ), $options['admin_logo_id'] );
				$this->render_media_field( 'login_logo_id', esc_html__( 'Login logo', 'oneup-admin' ), $options['login_logo_id'] );
				$this->render_text_field( 'brand_name', esc_html__( 'Brand name fallback', 'oneup-admin' ), $options['brand_name'] );
				$this->render_text_field( 'footer_text', esc_html__( 'Admin footer text', 'oneup-admin' ), $options['footer_text'] );
				$this->render_color_field( 'accent_color', esc_html__( 'Accent color', 'oneup-admin' ), $options['accent_color'] );
				$this->render_color_field( 'dark_background', esc_html__( 'Dark background color', 'oneup-admin' ), $options['dark_background'] );
				break;
			case 'dashboard':
				$this->render_checkbox_field( 'enable_custom_dashboard', esc_html__( 'Enable custom dashboard', 'oneup-admin' ), $options['enable_custom_dashboard'] );
				$this->render_checkbox_field( 'show_welcome_card', esc_html__( 'Show welcome card', 'oneup-admin' ), $options['show_welcome_card'] );
				$this->render_checkbox_field( 'show_quick_links', esc_html__( 'Show quick links', 'oneup-admin' ), $options['show_quick_links'] );
				$this->render_checkbox_field( 'show_site_status_card', esc_html__( 'Show site status card', 'oneup-admin' ), $options['show_site_status_card'] );
				$this->render_checkbox_field( 'show_roadmap_card', esc_html__( 'Show roadmap card', 'oneup-admin' ), $options['show_roadmap_card'] );
				break;
			case 'login':
				$this->render_checkbox_field( 'enable_branded_login', esc_html__( 'Enable branded login', 'oneup-admin' ), $options['enable_branded_login'] );
				$this->render_text_field( 'login_headline', esc_html__( 'Login headline', 'oneup-admin' ), $options['login_headline'] );
				$this->render_textarea_field( 'login_subtext', esc_html__( 'Login subtext', 'oneup-admin' ), $options['login_subtext'] );
				$this->render_select_field( 'login_button_style', esc_html__( 'Login button style', 'oneup-admin' ), $options['login_button_style'], array( 'filled' => 'Filled', 'gradient' => 'Gradient', 'outline' => 'Outline' ) );
				break;
			case 'menu':
				$this->render_checkbox_field( 'enable_menu_cleanup', esc_html__( 'Enable admin menu cleanup', 'oneup-admin' ), $options['enable_menu_cleanup'] );
				$this->render_checkbox_field( 'rename_pages', esc_html__( 'Rename Pages to Website Pages', 'oneup-admin' ), $options['rename_pages'] );
				$this->render_checkbox_field( 'rename_media', esc_html__( 'Rename Media to Files & Images', 'oneup-admin' ), $options['rename_media'] );
				$this->render_checkbox_field( 'hide_comments', esc_html__( 'Hide Comments menu', 'oneup-admin' ), $options['hide_comments'] );
				$this->render_checkbox_field( 'hide_tools', esc_html__( 'Hide Tools menu', 'oneup-admin' ), $options['hide_tools'] );
				$this->render_checkbox_field( 'hide_cookie_plugin_menu', esc_html__( 'Hide cookie plugin menu', 'oneup-admin' ), $options['hide_cookie_plugin_menu'] );
				$this->render_textarea_field( 'cookie_keywords', esc_html__( 'Cookie plugin menu keywords/slugs', 'oneup-admin' ), $options['cookie_keywords'] );
				break;
			case 'advanced':
				$this->render_checkbox_field( 'disable_dashboard_widgets', esc_html__( 'Disable default WordPress dashboard widgets', 'oneup-admin' ), $options['disable_dashboard_widgets'] );
				$this->render_checkbox_field( 'hide_wp_version_footer', esc_html__( 'Hide WordPress version text in admin footer', 'oneup-admin' ), $options['hide_wp_version_footer'] );
				$this->render_checkbox_field( 'enable_compact_admin', esc_html__( 'Enable compact admin mode', 'oneup-admin' ), $options['enable_compact_admin'] );
				$this->render_checkbox_field( 'enable_stronger_styling', esc_html__( 'Enable stronger admin styling', 'oneup-admin' ), $options['enable_stronger_styling'] );
				$this->render_textarea_field( 'custom_admin_css', esc_html__( 'Custom admin CSS', 'oneup-admin' ), $options['custom_admin_css'] );
				break;
		}
	}

	//───────────────────────────────────────
	// Render text field
	//───────────────────────────────────────
	private function render_text_field( $key, $label, $value ) {
		?>
		<label class="oneup-admin-field">
			<span><?php echo esc_html( $label ); ?></span>
			<input type="text" name="oneup_admin_options[<?php echo esc_attr( $key ); ?>]" value="<?php echo esc_attr( $value ); ?>">
		</label>
		<?php
	}

	//───────────────────────────────────────
	// Render textarea field
	//───────────────────────────────────────
	private function render_textarea_field( $key, $label, $value ) {
		?>
		<label class="oneup-admin-field">
			<span><?php echo esc_html( $label ); ?></span>
			<textarea name="oneup_admin_options[<?php echo esc_attr( $key ); ?>]" rows="6"><?php echo esc_textarea( $value ); ?></textarea>
		</label>
		<?php
	}

	//───────────────────────────────────────
	// Render color field
	//───────────────────────────────────────
	private function render_color_field( $key, $label, $value ) {
		?>
		<label class="oneup-admin-field">
			<span><?php echo esc_html( $label ); ?></span>
			<input type="color" name="oneup_admin_options[<?php echo esc_attr( $key ); ?>]" value="<?php echo esc_attr( $value ); ?>">
		</label>
		<?php
	}

	//───────────────────────────────────────
	// Render checkbox field
	//───────────────────────────────────────
	private function render_checkbox_field( $key, $label, $value ) {
		?>
		<label class="oneup-admin-field oneup-admin-field--checkbox">
			<input type="checkbox" name="oneup_admin_options[<?php echo esc_attr( $key ); ?>]" value="1" <?php checked( $value, '1' ); ?>>
			<span><?php echo esc_html( $label ); ?></span>
		</label>
		<?php
	}

	//───────────────────────────────────────
	// Render select field
	//───────────────────────────────────────
	private function render_select_field( $key, $label, $value, $choices ) {
		?>
		<label class="oneup-admin-field">
			<span><?php echo esc_html( $label ); ?></span>
			<select name="oneup_admin_options[<?php echo esc_attr( $key ); ?>]">
				<?php foreach ( $choices as $choice_value => $choice_label ) : ?>
					<option value="<?php echo esc_attr( $choice_value ); ?>" <?php selected( $value, $choice_value ); ?>><?php echo esc_html( $choice_label ); ?></option>
				<?php endforeach; ?>
			</select>
		</label>
		<?php
	}

	//───────────────────────────────────────
	// Render media field
	//───────────────────────────────────────
	private function render_media_field( $key, $label, $value ) {
		$preview = $value ? wp_get_attachment_image( absint( $value ), 'medium', false, array( 'class' => 'oneup-admin-media-preview__image' ) ) : '';
		?>
		<div class="oneup-admin-field oneup-admin-media-field" data-oneup-media-field>
			<span><?php echo esc_html( $label ); ?></span>
			<input type="hidden" name="oneup_admin_options[<?php echo esc_attr( $key ); ?>]" value="<?php echo esc_attr( absint( $value ) ); ?>" data-oneup-media-input>
			<div class="oneup-admin-media-preview" data-oneup-media-preview><?php echo $preview; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></div>
			<div class="oneup-admin-media-actions">
				<button type="button" class="button" data-oneup-media-select><?php echo esc_html__( 'Choose image', 'oneup-admin' ); ?></button>
				<button type="button" class="button-link-delete" data-oneup-media-clear><?php echo esc_html__( 'Remove', 'oneup-admin' ); ?></button>
			</div>
		</div>
		<?php
	}
}
