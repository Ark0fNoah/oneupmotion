<?php
/**
 * Admin bar customization.
 *
 * @package OneUpAdmin
 */

namespace OneUp_Admin;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class AdminBar {
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
		add_action( 'admin_bar_menu', array( $this, 'customize_admin_bar' ), 80 );
	}

	//───────────────────────────────────────
	// Customize admin bar
	//───────────────────────────────────────
	public function customize_admin_bar( $wp_admin_bar ) {
		if ( ! is_admin_bar_showing() ) {
			return;
		}

		$wp_admin_bar->remove_node( 'wp-logo' );

		$wp_admin_bar->add_node(
			array(
				'id'    => 'oneup-admin',
				'title' => esc_html( $this->settings->get( 'brand_name', 'OneUp Motion' ) ),
				'href'  => admin_url( 'index.php' ),
			)
		);

		$wp_admin_bar->add_node(
			array(
				'id'     => 'oneup-visit-site',
				'parent' => 'oneup-admin',
				'title'  => esc_html__( 'Visit Site', 'oneup-admin' ),
				'href'   => home_url( '/' ),
			)
		);

		$wp_admin_bar->add_node(
			array(
				'id'     => 'oneup-edit-homepage',
				'parent' => 'oneup-admin',
				'title'  => esc_html__( 'Edit Homepage', 'oneup-admin' ),
				'href'   => admin_url( 'post.php?post=' . absint( get_option( 'page_on_front' ) ) . '&action=edit' ),
			)
		);

		$wp_admin_bar->add_node(
			array(
				'id'     => 'oneup-admin-settings',
				'parent' => 'oneup-admin',
				'title'  => esc_html__( 'Admin Settings', 'oneup-admin' ),
				'href'   => admin_url( 'admin.php?page=oneup-admin' ),
			)
		);

		$wp_admin_bar->add_node(
			array(
				'id'     => 'oneup-new-page',
				'parent' => 'oneup-admin',
				'title'  => esc_html__( 'New Page', 'oneup-admin' ),
				'href'   => admin_url( 'post-new.php?post_type=page' ),
			)
		);
	}
}
