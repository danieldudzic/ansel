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


	// Add a class of has-post-thumbnail if the post or page has a featured image set.
	if ( has_post_thumbnail() && is_singular() ) {
		if  ( ansel_has_post_thumbnail() ) {
			$classes[] = 'has-post-thumbnail';
		}
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
