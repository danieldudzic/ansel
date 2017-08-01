<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package Ansel
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function ansel_body_classes( $classes ) {
	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	// Add a class of has-post-thumbnail if the post or page has a featured image set or a custom header image is set.
	if ( is_singular() && ansel_has_post_thumbnail() && ansel_jetpack_featured_image_display() || has_header_image() ) {
		$classes[] = 'has-custom-header';
	}

	// Add a class of no-sidebar when there is no sidebar present.
	if ( ! is_active_sidebar( 'sidebar-1' ) ) {
		$classes[] = 'no-sidebar';
	}

	// Add a class of has-cards when displaying portfolio items.
	if ( ! is_single() && 'jetpack-portfolio' === get_post_type() || ansel_is_page_template_portfolio() ) {
		$classes[] = 'has-cards';
	}

	return $classes;
}
add_filter( 'body_class', 'ansel_body_classes' );

/**
 * Add a pingback url auto-discovery header for singularly identifiable articles.
 */
function ansel_pingback_header() {
	if ( is_singular() && pings_open() ) {
		echo '<link rel="pingback" href="', esc_url( get_bloginfo( 'pingback_url' ) ), '">';
	}
}
add_action( 'wp_head', 'ansel_pingback_header' );
