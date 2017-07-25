<?php
/**
 * The Ansel header
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Ansel
 */

?>
<!doctype html>
<html <?php language_attributes(); ?> class="no-js no-svg">
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="http://gmpg.org/xfn/11">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'ansel' ); ?></a>

	<header id="masthead" class="site-header">
		<div class="branding-container">

			<div class="site-branding">
				<?php
				the_custom_logo();
				if ( is_front_page() && is_home() ) : ?>
					<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
				<?php else : ?>
					<p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
				<?php
				endif; ?>
			</div><!-- .site-branding -->

			<button class="menu-toggle" aria-controls="top-menu" aria-expanded="false">
			<?php
				echo ansel_get_svg( array( 'icon' => 'bars' ) );
				echo ansel_get_svg( array( 'icon' => 'close' ) );
				esc_html_e( 'Menu', 'ansel' );
			?>
			</button>
			<nav id="site-navigation" class="main-navigation">
				<?php wp_nav_menu( array(
					'theme_location' => 'menu-1',
					'menu_id'        => 'top-menu',
				) ); ?>
			</nav><!-- #site-navigation -->
		</div><!-- .branding-container -->

		<?php
		$description = get_bloginfo( 'description', 'display' );
		if ( $description || is_customize_preview() ) : ?>
			<p class="site-description"><?php echo $description; /* WPCS: xss ok. */ ?></p>
		<?php
		endif; ?>
	</header><!-- #masthead -->

	<div id="content" class="site-content">

	<?php ansel_custom_header(); ?>
