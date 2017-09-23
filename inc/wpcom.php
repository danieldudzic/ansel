<?php
/**
 * WordPress.com-specific functions and definitions
 *
 * This file is centrally included from `wp-content/mu-plugins/wpcom-theme-compat.php`.
 *
 * @package Ansel
 */

/**
 * Adds support for wp.com-specific theme functions.
 *
 * @global array $themecolors
 */
function ansel_wpcom_setup() {
	global $themecolors;

	// Set theme colors for third party services.
	if ( ! isset( $themecolors ) ) {
		$themecolors = array(
			'bg'     => 'ffffff',
			'border' => 'f7f7f7',
			'text'   => '444444',
			'link'   => '2c55e2',
			'url'    => '2c55e2',
		);
	}

	add_theme_support( 'print-styles' );
}
add_action( 'after_setup_theme', 'ansel_wpcom_setup' );

/**
 * Enqueue WordPress.com-specific styles.
 */
function ansel_wpcom_styles() {
	wp_enqueue_style( 'ansel-wpcom', get_template_directory_uri() . '/inc/style-wpcom.css', '20170903' );
}
add_action( 'wp_enqueue_scripts', 'ansel_wpcom_styles' );
