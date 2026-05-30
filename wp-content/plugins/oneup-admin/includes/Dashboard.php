<?php
/**
 * Dashboard customization.
 *
 * @package OneUpAdmin
 */

namespace OneUp_Admin;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Dashboard {
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
		add_action( 'wp_dashboard_setup', array( $this, 'setup_dashboard' ), 99 );
		add_filter( 'admin_footer_text', array( $this, 'admin_footer_text' ) );
		add_filter( 'update_footer', array( $this, 'admin_version_text' ), 99 );
	}

	//───────────────────────────────────────
	// Dashboard setup
	//───────────────────────────────────────
	public function setup_dashboard() {
		if ( '1' !== $this->settings->get( 'enable_custom_dashboard', '1' ) ) {
			return;
		}

		if ( '1' === $this->settings->get( 'disable_dashboard_widgets', '1' ) ) {
			$this->remove_default_widgets();
		}

		if ( '1' === $this->settings->get( 'show_welcome_card', '1' ) ) {
			wp_add_dashboard_widget( 'oneup_admin_welcome', esc_html__( 'Welcome to OneUp Motion', 'oneup-admin' ), array( $this, 'render_welcome_card' ) );
		}

		if ( '1' === $this->settings->get( 'show_quick_links', '1' ) ) {
			wp_add_dashboard_widget( 'oneup_admin_quick_links', esc_html__( 'Quick Links', 'oneup-admin' ), array( $this, 'render_quick_links_card' ) );
		}

		if ( '1' === $this->settings->get( 'show_site_status_card', '1' ) ) {
			wp_add_dashboard_widget( 'oneup_admin_site_status', esc_html__( 'Site Status', 'oneup-admin' ), array( $this, 'render_site_status_card' ) );
		}

		if ( '1' === $this->settings->get( 'show_roadmap_card', '1' ) ) {
			wp_add_dashboard_widget( 'oneup_admin_roadmap', esc_html__( 'Roadmap', 'oneup-admin' ), array( $this, 'render_roadmap_card' ) );
		}
	}

	//───────────────────────────────────────
	// Remove default widgets
	//───────────────────────────────────────
	private function remove_default_widgets() {
		remove_meta_box( 'dashboard_quick_press', 'dashboard', 'side' );
		remove_meta_box( 'dashboard_primary', 'dashboard', 'side' );
		remove_meta_box( 'dashboard_site_health', 'dashboard', 'normal' );
		remove_meta_box( 'dashboard_activity', 'dashboard', 'normal' );
		remove_meta_box( 'dashboard_right_now', 'dashboard', 'normal' );
	}

	//───────────────────────────────────────
	// Welcome card
	//───────────────────────────────────────
	public function render_welcome_card() {
		?>
		<div class="oneup-dashboard-card">
			<p><?php echo esc_html__( 'Manage your pages, sections, tools and design settings from one clean workspace.', 'oneup-admin' ); ?></p>
			<div class="oneup-dashboard-actions">
				<a class="button button-primary" href="<?php echo esc_url( admin_url( 'post.php?post=' . absint( get_option( 'page_on_front' ) ) . '&action=edit' ) ); ?>"><?php echo esc_html__( 'Edit Homepage', 'oneup-admin' ); ?></a>
				<a class="button" href="<?php echo esc_url( admin_url( 'admin.php?page=oneup-motion-settings' ) ); ?>"><?php echo esc_html__( 'Theme Settings', 'oneup-admin' ); ?></a>
				<a class="button" href="<?php echo esc_url( admin_url( 'post-new.php?post_type=page' ) ); ?>"><?php echo esc_html__( 'Add New Page', 'oneup-admin' ); ?></a>
				<a class="button" href="<?php echo esc_url( home_url( '/' ) ); ?>" target="_blank" rel="noopener noreferrer"><?php echo esc_html__( 'View Website', 'oneup-admin' ); ?></a>
			</div>
		</div>
		<?php
	}

	//───────────────────────────────────────
	// Quick links card
	//───────────────────────────────────────
	public function render_quick_links_card() {
		$links = array(
			esc_html__( 'Website Pages', 'oneup-admin' ) => admin_url( 'edit.php?post_type=page' ),
			esc_html__( 'Files & Images', 'oneup-admin' ) => admin_url( 'upload.php' ),
			esc_html__( 'Menus', 'oneup-admin' ) => admin_url( 'nav-menus.php' ),
			esc_html__( 'OneUp Admin Settings', 'oneup-admin' ) => admin_url( 'admin.php?page=oneup-admin' ),
			esc_html__( 'Plugins', 'oneup-admin' ) => admin_url( 'plugins.php' ),
		);
		?>
		<ul class="oneup-admin-link-list">
			<?php foreach ( $links as $label => $url ) : ?>
				<li><a href="<?php echo esc_url( $url ); ?>"><?php echo esc_html( $label ); ?></a></li>
			<?php endforeach; ?>
		</ul>
		<?php
	}

	//───────────────────────────────────────
	// Site status card
	//───────────────────────────────────────
	public function render_site_status_card() {
		$theme       = wp_get_theme();
		$plugins     = get_option( 'active_plugins', array() );
		$tools_active = in_array( 'oneup-tools/oneup-tools.php', $plugins, true ) ? esc_html__( 'Active', 'oneup-admin' ) : esc_html__( 'Not active', 'oneup-admin' );
		?>
		<ul class="oneup-admin-status-list">
			<li><strong><?php echo esc_html__( 'Theme', 'oneup-admin' ); ?></strong><span><?php echo esc_html( $theme->get( 'Name' ) ); ?></span></li>
			<li><strong><?php echo esc_html__( 'Active plugins', 'oneup-admin' ); ?></strong><span><?php echo esc_html( count( $plugins ) ); ?></span></li>
			<li><strong><?php echo esc_html__( 'WordPress', 'oneup-admin' ); ?></strong><span><?php echo esc_html( get_bloginfo( 'version' ) ); ?></span></li>
			<li><strong><?php echo esc_html__( 'PHP', 'oneup-admin' ); ?></strong><span><?php echo esc_html( PHP_VERSION ); ?></span></li>
			<li><strong><?php echo esc_html__( 'OneUp Tools', 'oneup-admin' ); ?></strong><span><?php echo esc_html( $tools_active ); ?></span></li>
		</ul>
		<?php
	}

	//───────────────────────────────────────
	// Roadmap card
	//───────────────────────────────────────
	public function render_roadmap_card() {
		$items = array( 'QR Generator', 'UTM Builder', 'Image Tools', 'More design sections', 'Case studies' );
		?>
		<ul class="oneup-admin-roadmap">
			<?php foreach ( $items as $item ) : ?>
				<li><?php echo esc_html( $item ); ?></li>
			<?php endforeach; ?>
		</ul>
		<?php
	}

	//───────────────────────────────────────
	// Admin footer text
	//───────────────────────────────────────
	public function admin_footer_text( $text ) {
		$footer = $this->settings->get( 'footer_text', '' );
		return $footer ? esc_html( $footer ) : $text;
	}

	//───────────────────────────────────────
	// Admin version text
	//───────────────────────────────────────
	public function admin_version_text( $text ) {
		if ( '1' === $this->settings->get( 'hide_wp_version_footer', '1' ) ) {
			return '';
		}

		return $text;
	}
}
