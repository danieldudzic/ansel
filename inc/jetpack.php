<?php
/**
 * Jetpack Compatibility File
 *
 * @link https://jetpack.com/
 *
 * @package Ansel
 */

/**
 * Jetpack setup function.
 *
 * See: https://jetpack.com/support/infinite-scroll/
 * See: https://jetpack.com/support/responsive-videos/
 * See: https://jetpack.com/support/content-options/
 */
function ansel_jetpack_setup() {

		// Add support for Jetpack Portfolio Custom Post Type.
	add_theme_support( 'jetpack-portfolio', array (
		'title'          => true,
		'content'        => true,
		'featured-image' => true,
	) );

	// Add theme support for Infinite Scroll.
	add_theme_support( 'infinite-scroll', array (
		'container' => 'main',
		'render'    => 'ansel_infinite_scroll_render',
		'footer'    => 'page',
		'wrapper'	=> false,
	) );

	// Add theme support for Responsive Videos.
	add_theme_support( 'jetpack-responsive-videos' );

	// Add theme support for Social Menus.
	add_theme_support( 'jetpack-social-menu', 'svg' );

	// Add theme support for Content Options.
	add_theme_support( 'jetpack-content-options', array (
		'blog-display'		 => 'excerpt',
		'author-bio'		 => true,
		'author-bio-default' => false,
		'post-details'		 => array(
			'stylesheet'	 => 'ansel-style',
			'date'			 => '.posted-on',
			'categories'	 => '.cat-links',
			'tags'			 => '.tags-links',
			'author'		 => '.byline',
			'comment'		 => '.comments-link',
		),
		'featured-images' => array(
			'archive'          => true,
			'post'             => true,
			'post-default'     => true,
			'page'             => true,
			'page-default'     => true,
			'fallback'         => true,
			'fallback-default' => false,
		),
	) );
}
add_action( 'after_setup_theme', 'ansel_jetpack_setup' );

/**
 * Show/Hide Featured Image outside of the loop.
 */
function ansel_jetpack_featured_image_display() {
    if ( ! function_exists( 'jetpack_featured_images_remove_post_thumbnail' ) ) {
        return true;
    } else {
        $options         = get_theme_support( 'jetpack-content-options' );
        $featured_images = ( ! empty( $options[0]['featured-images'] ) ) ? $options[0]['featured-images'] : null;

        $settings = array(
            'post-default' => ( isset( $featured_images['post-default'] ) && false === $featured_images['post-default'] ) ? '' : 1,
            'page-default' => ( isset( $featured_images['page-default'] ) && false === $featured_images['page-default'] ) ? '' : 1,
        );

        $settings = array_merge( $settings, array(
            'post-option'  => get_option( 'jetpack_content_featured_images_post', $settings['post-default'] ),
            'page-option'  => get_option( 'jetpack_content_featured_images_page', $settings['page-default'] ),
        ) );

        if ( ( ! $settings['post-option'] && is_single() )
            || ( ! $settings['page-option'] && is_singular() && is_page() ) ) {
            return false;
        } else {
            return true;
        }
    }
}

/**
 * Custom render function for Infinite Scroll.
 */
function ansel_infinite_scroll_render() {
	while ( have_posts() ) {
		the_post();
		if ( is_search() ) :
			get_template_part( 'template-parts/content', 'search' );
		elseif ( 'jetpack-portfolio' === get_post_type() || ansel_is_page_template_portfolio() ) :
			get_template_part( 'template-parts/content', 'card' );
		else :
			get_template_part( 'template-parts/content', get_post_format() );
		endif;
	}
}

/*
 * Only display social menu if function exists.
 */
function ansel_social_menu() {
	if ( ! function_exists( 'jetpack_social_menu' ) ) {
		return;
	} else {
		jetpack_social_menu();
	}
}

/**
 * Getter function for Featured Content
 *
 * @return (string) The value of the filter defined in add_theme_support( 'featured-content' )
 */
function ansel_get_featured_projects() {
	return apply_filters( 'ansel_get_featured_projects', array() );
}

/**
 * Portfolio Title
 */
function ansel_portfolio_title( $before = '', $after = '' ) {
	$jetpack_portfolio_title = get_option( 'jetpack_portfolio_title' );
	$title = '';

	if ( is_post_type_archive( 'jetpack-portfolio' ) ) {
		if ( isset( $jetpack_portfolio_title ) && '' != $jetpack_portfolio_title ) {
			$title = esc_html( $jetpack_portfolio_title );
		} else {
			$title = post_type_archive_title( '', false );
		}
	} elseif ( is_tax( 'jetpack-portfolio-type' ) || is_tax( 'jetpack-portfolio-tag' ) ) {
		$title = single_term_title( '', false );
	}

	echo $before . $title . $after;
}

/**
 * Portfolio Content
 */
function ansel_portfolio_content( $before = '', $after = '' ) {
	$jetpack_portfolio_content = get_option( 'jetpack_portfolio_content' );

	if ( is_tax() && get_the_archive_description() ) {
		echo $before . get_the_archive_description() . $after;
	} else if ( isset( $jetpack_portfolio_content ) && '' != $jetpack_portfolio_content ) {
		$content = convert_chars( convert_smilies( wptexturize( stripslashes( wp_filter_post_kses( addslashes( $jetpack_portfolio_content ) ) ) ) ) );
		echo $before . $content . $after;
	}
}

/**
 * Portfolio Featured Image
 */
function ansel_portfolio_thumbnail( $before = '', $after = '' ) {
	$jetpack_portfolio_featured_image = get_option( 'jetpack_portfolio_featured_image' );

	if ( isset( $jetpack_portfolio_featured_image ) && '' != $jetpack_portfolio_featured_image ) {
		$featured_image = wp_get_attachment_image( (int) $jetpack_portfolio_featured_image, 'full-width' );
		echo $before . $featured_image . $after;
	}
}

/**
 * Author Bio Avatar Size
 */
function ansel_author_bio_avatar_size() {
	return 90;
}
add_filter( 'jetpack_author_bio_avatar_size', 'ansel_author_bio_avatar_size' );

/**
 * Custom function to check for a post thumbnail;
 * If Jetpack is not available, fall back to has_post_thumbnail()
 */
function ansel_has_post_thumbnail( $post = null ) {
	if ( function_exists( 'jetpack_has_featured_image' ) ) {
		return jetpack_has_featured_image( $post );
	} else {
		return has_post_thumbnail( $post );
	}
}
