<?php
/**
 * Site header.
 *
 * @package OneUpMotion
 */
?><!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<a class="skip-link screen-reader-text" href="#main"><?php echo esc_html__( 'Skip to content', 'oneup-motion' ); ?></a>

<header class="site-header" role="banner">
	<div class="site-header__inner">
		<div class="site-branding">
			<?php oum_brand_logo(); ?>
		</div>

		<button class="nav-toggle" type="button" aria-expanded="false" aria-controls="primary-menu">
			<span class="nav-toggle__bar" aria-hidden="true"></span>
			<span class="screen-reader-text"><?php echo esc_html__( 'Toggle navigation', 'oneup-motion' ); ?></span>
		</button>

		<nav class="primary-nav" aria-label="<?php echo esc_attr__( 'Primary navigation', 'oneup-motion' ); ?>">
			<?php
			if ( has_nav_menu( 'primary' ) ) {
				wp_nav_menu( array(
					'theme_location' => 'primary',
					'menu_id'        => 'primary-menu',
					'menu_class'     => 'primary-nav__list',
					'container'      => false,
					'fallback_cb'    => false,
				) );
			} else {
				?>
				<ul id="primary-menu" class="primary-nav__list">
					<li><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php echo esc_html__( 'Home', 'oneup-motion' ); ?></a></li>
					<li><a href="<?php echo esc_url( home_url( '/tools/' ) ); ?>"><?php echo esc_html__( 'Tools', 'oneup-motion' ); ?></a></li>
					<li><a href="#services"><?php echo esc_html__( 'Services', 'oneup-motion' ); ?></a></li>
					<li><a href="#about"><?php echo esc_html__( 'About', 'oneup-motion' ); ?></a></li>
					<li><a href="#contact"><?php echo esc_html__( 'Contact', 'oneup-motion' ); ?></a></li>
				</ul>
				<?php
			}
			?>
		</nav>

		<?php if ( '1' === oum_get_theme_option( 'show_header_cta', '1' ) ) : ?>
			<a class="button button--small site-header__cta" href="<?php echo esc_url( oum_get_theme_option( 'header_cta_url', '#contact' ) ); ?>"><?php echo esc_html( oum_get_theme_option( 'header_cta_label', __( 'Start Creating', 'oneup-motion' ) ) ); ?></a>
		<?php endif; ?>
	</div>
</header>
