<?php
/**
 * Admin menu customization.
 *
 * @package OneUpAdmin
 */

namespace OneUp_Admin;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Menu {
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
		add_action( 'admin_menu', array( $this, 'customize_menu' ), 999 );
	}

	//───────────────────────────────────────
	// Customize menu
	//───────────────────────────────────────
	public function customize_menu() {
		if ( '1' !== $this->settings->get( 'enable_menu_cleanup', '1' ) ) {
			return;
		}

		if ( '1' === $this->settings->get( 'hide_comments', '1' ) ) {
			remove_menu_page( 'edit-comments.php' );
		}

		if ( '1' === $this->settings->get( 'hide_tools', '0' ) ) {
			remove_menu_page( 'tools.php' );
		}

		$this->rename_menu_items();

		if ( '1' === $this->settings->get( 'hide_cookie_plugin_menu', '1' ) ) {
			$this->hide_cookie_plugin_menus();
		}
	}

	//───────────────────────────────────────
	// Rename menu items
	//───────────────────────────────────────
	private function rename_menu_items() {
		global $menu;

		if ( ! is_array( $menu ) ) {
			return;
		}

		foreach ( $menu as $index => $item ) {
			$slug = isset( $item[2] ) ? $item[2] : '';

			if ( 'edit.php?post_type=page' === $slug && '1' === $this->settings->get( 'rename_pages', '1' ) ) {
				$menu[ $index ][0] = esc_html__( 'Website Pages', 'oneup-admin' );
			}

			if ( 'upload.php' === $slug && '1' === $this->settings->get( 'rename_media', '1' ) ) {
				$menu[ $index ][0] = esc_html__( 'Files & Images', 'oneup-admin' );
			}
		}
	}

	//───────────────────────────────────────
	// Hide cookie plugin menus
	//───────────────────────────────────────
	private function hide_cookie_plugin_menus() {
		global $menu, $submenu;

		$keywords = $this->cookie_keywords();

		if ( is_array( $menu ) ) {
			foreach ( $menu as $index => $item ) {
				$title = isset( $item[0] ) ? wp_strip_all_tags( $item[0] ) : '';
				$slug  = isset( $item[2] ) ? $item[2] : '';

				if ( $this->matches_keywords( $title . ' ' . $slug, $keywords ) ) {
					unset( $menu[ $index ] );
				}
			}
		}

		if ( is_array( $submenu ) ) {
			foreach ( $submenu as $parent => $items ) {
				foreach ( $items as $index => $item ) {
					$title = isset( $item[0] ) ? wp_strip_all_tags( $item[0] ) : '';
					$slug  = isset( $item[2] ) ? $item[2] : '';

					if ( $this->matches_keywords( $title . ' ' . $slug, $keywords ) ) {
						unset( $submenu[ $parent ][ $index ] );
					}
				}
			}
		}
	}

	//───────────────────────────────────────
	// Cookie keywords getter
	//───────────────────────────────────────
	private function cookie_keywords() {
		$raw      = (string) $this->settings->get( 'cookie_keywords', '' );
		$lines    = preg_split( '/\r\n|\r|\n/', $raw );
		$keywords = array();

		foreach ( $lines as $line ) {
			$line = sanitize_key( trim( $line ) );

			if ( '' !== $line ) {
				$keywords[] = $line;
			}
		}

		return $keywords;
	}

	//───────────────────────────────────────
	// Keyword matcher
	//───────────────────────────────────────
	private function matches_keywords( $haystack, $keywords ) {
		$haystack = strtolower( (string) $haystack );

		foreach ( $keywords as $keyword ) {
			if ( '' !== $keyword && false !== strpos( $haystack, strtolower( $keyword ) ) ) {
				return true;
			}
		}

		return false;
	}
}
