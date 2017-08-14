<?php
/**
 * Ansel functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Ansel
 */

if ( ! function_exists( 'ansel_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function ansel_setup() {
	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on Ansel, use a find and replace
	 * to change 'ansel' to the name of your theme in all the template files.
	 */
	load_theme_textdomain( 'ansel', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
	 */
	add_theme_support( 'post-thumbnails' );

	add_image_size( 'ansel-featured-image-post', 650, 9999 );
	add_image_size( 'ansel-featured-image-header', 1000, 9999 );
	add_image_size( 'ansel-feature-card', 300, 200, true );
	add_image_size( 'ansel-feature-card-featured', 1000, 500, true );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'menu-1' => esc_html__( 'Top Menu', 'ansel' ),
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );

	// Set up the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'ansel_custom_background_args', array(
		'default-color' => 'f7f7f7',
		'default-image' => '',
	) ) );

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );

	/**
	 * Add support for core custom logo.
	 *
	 * @link https://codex.wordpress.org/Theme_Logo
	 */
	add_theme_support( 'custom-logo', array(
		'height'      => 100,
		'width'       => 250,
		'flex-width'  => true,
		'flex-height' => true,
		'header-text' => array(
			'site-title',
			'site-description',
		),
	) );
}
endif;
add_action( 'after_setup_theme', 'ansel_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function ansel_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'ansel_content_width', 650 );
}
add_action( 'after_setup_theme', 'ansel_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function ansel_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'ansel' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here.', 'ansel' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'ansel_widgets_init' );

/**
 * Returns an ellipsis and "Continue reading" plus off-screen title link for excerpts
 */
function ansel_continue_reading_link() {
	return '&hellip; <a href="' . esc_url( get_permalink() ) . '" class="more-link">' .
		sprintf(
			wp_kses(
				/* translators: %s: post title */
				__( 'Continue reading <span class="screen-reader-text">%1$s</span>', 'ansel' ),
				array(
					'span' => array(
						'class' => array(),
					),
				)
			),
			get_the_title()
		) .
	'</a>';
}

/**
 * Replaces "[...]" (appended to automatically generated excerpts) with ansel_continue_reading_link().
 *
 * To override this in a child theme, remove the filter and add your own
 * function tied to the excerpt_more filter hook.
 */
function ansel_auto_excerpt_more() {
	if ( is_admin() ) {
		return;
	}

	return ansel_continue_reading_link();
}
add_filter( 'excerpt_more', 'ansel_auto_excerpt_more' );

/**
 * Handles JavaScript detection.
 *
 * Adds a `js` class to the root `<html>` element when JavaScript is detected.
 */
function ansel_javascript_detection() {
	echo "<script>(function(html){html.className = html.className.replace(/\bno-js\b/,'js')})(document.documentElement);</script>\n";
}
add_action( 'wp_head', 'ansel_javascript_detection', 0 );

/**
 * Add Google webfonts
 *
 * - See: http://themeshaper.com/2014/08/13/how-to-add-google-fonts-to-wordpress-themes/
 */
function ansel_fonts_url() {

	$fonts_url = '';

	/*
	* Translators: If there are characters in your language that are not
	* supported by Work Sans, translate this to 'off'. Do not translate
	* into your own language.
	*/
	$work_sans = esc_html_x( 'on', 'Work Sans font: on or off', 'ansel' );

	/*
	* Translators: If there are characters in your language that are not
	* supported by Karla, translate this to 'off'. Do not translate
	* into your own language.
	*/
	$karla = esc_html_x( 'on', 'Karla font: on or off', 'ansel' );

	if ( 'off' !== $work_sans || 'off' !== $karla ) {
		$font_families = array();

		if ( 'off' !== $work_sans ) {
			$font_families[] = 'Work Sans:400,700';
		}

		if ( 'off' !== $karla ) {
			$font_families[] = 'Karla:400,700';
		}

		$query_args = array(
			'family' => urlencode( implode( '|', $font_families ) ),
			'subset' => urlencode( 'latin,latin-ext' ),
		);

		$fonts_url = add_query_arg( $query_args, 'https://fonts.googleapis.com/css' );
	}

	return esc_url_raw( $fonts_url );
}

/**
 * Enqueue scripts and styles.
 */
function ansel_scripts() {

	wp_enqueue_style( 'ansel-fonts', ansel_fonts_url(), array(), null );

	wp_enqueue_style( 'ansel-style', get_stylesheet_uri() );

	wp_enqueue_script( 'ansel-skip-link-focus-fix', get_template_directory_uri() . '/assets/js/skip-link-focus-fix.js', array(), '1.0', true );

	$ansel_l10n = array(
		'has_navigation' => 'false',
	);

	wp_enqueue_script( 'ansel-navigation', get_theme_file_uri( '/assets/js/navigation.js' ), array(), '1.0', true );

	$ansel_l10n['has_navigation'] = 'true';
	$ansel_l10n['expand']         = esc_html__( 'Expand child menu', 'ansel' );
	$ansel_l10n['collapse']       = esc_html__( 'Collapse child menu', 'ansel' );
	$ansel_l10n['icon']           = ansel_get_svg( array(
		'icon' => 'expand',
		'fallback' => true,
	) );
	wp_localize_script( 'ansel-skip-link-focus-fix', 'anselScreenReaderText', $ansel_l10n );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'ansel_scripts' );


/**
 * Conditially output the post(s) navigation.
 */
function ansel_posts_navigation() {
	if ( have_posts() ) :
		if ( is_single() ) {
			the_post_navigation( array(
				'prev_text' => '<span aria-hidden="true" class="nav-subtitle">' .
									esc_html_x( 'Previous', 'previous post', 'ansel' ) .
								'</span>%title',
				'next_text' => '<span aria-hidden="true" class="nav-subtitle">' .
									esc_html_x( 'Next', 'next post', 'ansel' ) .
								'</span>%title',
			) );
		} else {
			if ( 'jetpack-portfolio' === get_post_type() ) {
				the_posts_navigation( array(
					'prev_text'          => esc_html__( 'Older Projects', 'ansel' ),
					'next_text'          => esc_html__( 'Newer Projects', 'ansel' ),
					'screen_reader_text' => esc_html__( 'Portfolio Navigation', 'ansel' ),
				) );
			} else {
				the_posts_navigation();
			}
		}
	endif;
}

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Custom customizer controls.
 */
require get_template_directory() . '/inc/customizer-controls.php';

/**
 * SVG icons functions and filters.
 */
require get_template_directory() . '/inc/icon-functions.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';
