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
	add_theme_support( 'jetpack-portfolio', array(
		'title'          => true,
		'content'        => true,
		'featured-image' => true,
	) );

	// Add theme support for Infinite Scroll.
	add_theme_support( 'infinite-scroll', array(
		'container' => 'main',
		'render'    => 'ansel_infinite_scroll_render',
		'footer'    => 'page',
		'wrapper'   => false,
	) );

	// Add theme support for Responsive Videos.
	add_theme_support( 'jetpack-responsive-videos' );

	// Add theme support for Social Menus.
	add_theme_support( 'jetpack-social-menu', 'svg' );

	// Add theme support for Content Options.
	add_theme_support( 'jetpack-content-options', array(
		'blog-display'       => 'content',
		'author-bio'         => true,
		'author-bio-default' => false,
		'post-details'       => array(
			'stylesheet'     => 'ansel-style',
			'date'           => '.posted-on',
			'categories'     => '.cat-links',
			'tags'           => '.tags-links',
			'author'         => '.byline',
			'comment'        => '.comments-link',
		),
		'featured-images'      => array(
			'archive'          => true,
			'post'             => true,
			'post-default'     => true,
			'portfolio'        => false,
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
			'post-option' => get_option( 'jetpack_content_featured_images_post', $settings['post-default'] ),
			'page-option' => get_option( 'jetpack_content_featured_images_page', $settings['page-default'] ),
		) );

		if ( ( ! $settings['post-option'] && is_single() ) || ( ! $settings['page-option'] && is_singular() && is_page() ) ) {
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
		elseif ( 'jetpack-portfolio' === get_post_type() || ansel_is_page_template_showcase() ) :
			get_template_part( 'template-parts/content', 'card' );
		else :
			get_template_part( 'template-parts/content', get_post_format() );
		endif;
	}
}

/**
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
 * Portfolio Title.
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
 * Author Bio Avatar Size.
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

/**
 * Get Showcase Items data.
 */
function ansel_get_showcase_items() {
	$showcase_items = '';

	for ( $x = 1; $x <= 9; $x++ ) {
		$showcase_items[ $x ]['content'] = '';
		$showcase_items[ $x ]['thumbnail'] = '';

		$content = get_theme_mod( 'ansel_showcase_item_content_' . $x );
		$thumbnail = get_theme_mod( 'ansel_showcase_item_content_thumbnail_' . $x );

		if ( ! empty( $content ) ) {
			$showcase_items[ $x ]['content'] = $content;
		}

		if ( ! empty( $thumbnail ) ) {
			$showcase_items[ $x ]['thumbnail'] = $thumbnail;
		}
	}

	if ( empty( $showcase_items ) ) {
		return false;
	} else {
		$items = '';

		foreach ( $showcase_items as $item ) {
			if ( ! empty( $item['content'] ) || 'select' === $item['content'] ) {

				$item_id = '';

				if ( 'select' !== $item['content'] ) {
					$exploded_item = explode( '_', $item['content'] );

					$item_id = $exploded_item[1];
					$item_type = $exploded_item[0];

					$items[ $item_id ]['type'] = $item_type;

					if ( ! empty( $item['thumbnail'] ) ) {
						$items[ $item_id ]['thumbnail'] = $item['thumbnail'];
					} else {
						$items[ $item_id ]['thumbnail'] = '';
					}
				}
			}
		}

		return $items;
	}
}

/**
 * Get Showcase Item title.
 */
function ansel_get_showcase_item_title( $id, $type ) {
	switch ( $type ) {
		case 'page':
			$title = get_the_title( $id );
			break;
		case 'portfolio-type':
			$portfolio_type = get_term_by( 'id', $id, 'jetpack-portfolio-type' );
			$title = $portfolio_type->name;
			break;
		case 'category':
			$title = get_cat_name( $id );
			break;
	}

	return $title;
}

/**
 * Get Showcase Item url.
 */
function ansel_get_showcase_item_url( $id, $type ) {
	switch ( $type ) {
		case 'page':
			$url = get_permalink( $id );
			break;
		case 'portfolio-type':
			$portfolio_type = get_term_by( 'id', $id, 'jetpack-portfolio-type' );
			$url = get_term_link( $portfolio_type->slug, 'jetpack-portfolio-type' );
			break;
		case 'category':
			$url = get_category_link( $id );
			break;
	}

	return $url;
}

/**
 * Display the Showcase Item title.
 */
function ansel_showcase_item_title( $id, $type ) {
	echo '<a href="' . esc_url( ansel_get_showcase_item_url( $id, $type ) ) . '" rel="bookmark">' . apply_filters( 'the_title', ansel_get_showcase_item_title( $id, $type ), $id ) . '</a>';
}

/**
 * Display the Showcase Item thumbnail.
 */
function ansel_showcase_item_thumbnail( $src, $item_id = '', $item_type = '' ) {

	if ( ! empty( $src ) ) {
		$thumbnail_id = ansel_get_attachment_id( $src );
	} else {
		$thumbnail_id = false;
	}

	$thumbnail_attr = '';

	if ( ! empty( $item_id ) && ! empty( $item_type ) ) {
		$thumbnail_attr = array(
			'alt' => esc_attr( ansel_get_showcase_item_title( $item_id, $item_type ) ),
		);
	}

	if ( $thumbnail_id ) {
		$thumbnail = wp_get_attachment_image( $thumbnail_id, 'ansel-entry-card', false, $thumbnail_attr );
		$class = '';
	} else {
		$thumbnail = '<span class="screen-reader-text">' . esc_html( ansel_get_showcase_item_title( $item_id, $item_type ) ) . '</span>';
		$class = 'placeholder';
	}

	$url = ansel_get_showcase_item_url( $item_id, $item_type );

	if ( ! empty( $item_id ) && ! empty( $item_type ) ) {
		$thumbnail = '<a class="' . $class . '" href="' . esc_url( $url ) . '">' . $thumbnail . '</a>';
	}

	echo $thumbnail;
}

/**
 * Get an attachment ID given a URL.
 *
 * @return int Attachment ID on success, 0 on failure
 */
function ansel_get_attachment_id( $url ) {
	$attachment_id = 0;
	$dir = wp_upload_dir();
	if ( false !== strpos( $url, $dir['baseurl'] . '/' ) ) { // Is URL in uploads directory?
		$file = basename( $url );
		$query_args = array(
			'post_type'   => 'attachment',
			'post_status' => 'inherit',
			'fields'      => 'ids',
			'meta_query'  => array(
				array(
					'value'   => $file,
					'compare' => 'LIKE',
					'key'     => '_wp_attachment_metadata',
				),
			),
		);
		$query = new WP_Query( $query_args );
		if ( $query->have_posts() ) {
			foreach ( $query->posts as $post_id ) {
				$meta = wp_get_attachment_metadata( $post_id );
				$original_file       = basename( $meta['file'] );
				$cropped_image_files = wp_list_pluck( $meta['sizes'], 'file' );
				if ( $original_file === $file || in_array( $file, $cropped_image_files ) ) {
					$attachment_id = $post_id;
					break;
				}
			}
		}
	}
	return $attachment_id;
}

/**
 * Load the author template if Author Bio is not available.
 */
function ansel_author_bio() {
	if ( ! function_exists( 'jetpack_author_bio' ) ) {
		get_template_part( 'template-parts/content', 'author' );
	} else {
		jetpack_author_bio();
	}
}
