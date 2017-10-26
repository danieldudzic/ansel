<?php
/**
 * Front Page Showcase functions
 *
 * @package WordPress
 * @subpackage Ansel
 * @since 1.0
 */

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

					if ( 'portfolio-type' === $item_type && ! taxonomy_exists( 'jetpack-portfolio-type' ) || 'portfolio-tag' === $item_type && ! taxonomy_exists( 'jetpack-portfolio-tag' ) ) {
						continue;
					}

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
		case 'portfolio-type':
			$portfolio_type = get_term_by( 'id', $id, 'jetpack-portfolio-type' );
			$title = $portfolio_type->name;
			break;
		case 'portfolio-tag':
			$portfolio_tag = get_term_by( 'id', $id, 'jetpack-portfolio-tag' );
			$title = $portfolio_tag->name;
			break;
	}

	return $title;
}

/**
 * Get Showcase Item url.
 */
function ansel_get_showcase_item_url( $id, $type ) {
	switch ( $type ) {
		case 'portfolio-type':
			$portfolio_type = get_term_by( 'id', $id, 'jetpack-portfolio-type' );
			$url = get_term_link( $portfolio_type->slug, 'jetpack-portfolio-type' );
			break;
		case 'portfolio-tag':
			$portfolio_tag = get_term_by( 'id', $id, 'jetpack-portfolio-tag' );
			$url = get_term_link( $portfolio_tag->slug, 'jetpack-portfolio-tag' );
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
