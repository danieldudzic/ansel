<?php
/**
 * Custom template tags for this theme
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Ansel
 */

if ( ! function_exists( 'ansel_posted_on' ) ) :
/**
 * Prints HTML with meta information for the current post-date/time and author.
 */
function ansel_posted_on() {

	if ( ! is_sticky() ) {
		$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
		if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
			$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
		}

		$time_string = sprintf( $time_string,
			esc_attr( get_the_date( 'c' ) ),
			esc_html( get_the_date() ),
			esc_attr( get_the_modified_date( 'c' ) ),
			esc_html( get_the_modified_date() )
		);

		$posted_on = sprintf(
			/* translators: %s: post date. */
			esc_html_x( 'Posted on %s', 'post date', 'ansel' ),
			'<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>'
		);
	} else {
		$posted_on = esc_html__( 'Featured', 'ansel' );
	}

	$byline = sprintf(
		/* translators: %s: post author. */
		esc_html_x( 'by %s', 'post author', 'ansel' ),
		'<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>'
	);

	echo '<span class="posted-on">' . $posted_on . '</span><span class="byline"> ' . $byline . '</span>'; // WPCS: XSS OK.

}
endif;

if ( ! function_exists( 'ansel_entry_footer' ) ) :
/**
 * Prints HTML with meta information for the categories, tags and comments.
 */
function ansel_entry_footer() {
	// Hide category and tag text for pages.
	if ( 'post' === get_post_type() ) {
		/* translators: used between list items, there is a space after the comma */
		$categories_list = get_the_category_list( esc_html__( ', ', 'ansel' ) );
		if ( $categories_list ) {
			/* translators: 1: list of categories. */
			printf( '<span class="cat-links">' . esc_html__( 'Posted in %1$s', 'ansel' ) . '</span>', $categories_list ); // WPCS: XSS OK.
		}
	}

	if ( 'jetpack-portfolio' === get_post_type() ) {
		/* translators: used between list items, there is a space after the comma */
		$term_list = get_the_term_list( get_the_ID(), 'jetpack-portfolio-type', '', ', ' );
		if ( $term_list ) {
			/* translators: 1: list of terms. */
			printf( '<span class="cat-links">' . esc_html__( 'Posted in %1$s', 'ansel' ) . '</span>', $term_list ); // WPCS: XSS OK.
		}
	}

	if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
		echo '<span class="comments-link">';
		comments_popup_link(
			sprintf(
				wp_kses(
					/* translators: %s: post title */
					__( 'Leave a Comment<span class="screen-reader-text"> on %s</span>', 'ansel' ),
					array(
						'span' => array(
							'class' => array(),
						),
					)
				),
				get_the_title()
			)
		);
		echo '</span>';
	}

	edit_post_link(
		sprintf(
			wp_kses(
				/* translators: %s: Name of current post. Only visible to screen readers */
				__( 'Edit <span class="screen-reader-text">%s</span>', 'ansel' ),
				array(
					'span' => array(
						'class' => array(),
					),
				)
			),
			get_the_title()
		),
		'<span class="edit-link">',
		'</span>'
	);

	$tags_list = get_the_tag_list();

	if ( $tags_list ) {
		/* translators: 1: list of tags. */
		printf( '<span class="tags-links">' . esc_html__( 'Tagged %1$s', 'ansel' ) . '</span>', $tags_list ); // WPCS: XSS OK.
	}

	if ( 'jetpack-portfolio' === get_post_type() ) {
		/* translators: used between list items, there is a space after the comma */
		$tags_list = get_the_term_list( get_the_ID(), 'jetpack-portfolio-tag' );
		if ( $tags_list ) {
		/* translators: 1: list of tags. */
			printf( '<span class="tags-links">' . esc_html__( 'Tagged %1$s', 'ansel' ) . '</span>', $tags_list ); // WPCS: XSS OK.
		}
	}

}
endif;
