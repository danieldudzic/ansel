<?php
/**
 * Ansel Theme Customizer
 *
 * @package Ansel
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function ansel_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';

	/**
	 * Add the Theme Options section.
	 */
	$wp_customize->add_panel( 'ansel_theme_options', array(
		'title' => esc_html__( 'Theme Options', 'ansel' ),
	) );

	/**
	 * Add the Homepage Feature sections.
	 */
	ansel_generate_customizer_homepage_feature_sections( $wp_customize );

	if ( isset( $wp_customize->selective_refresh ) ) {
		$wp_customize->selective_refresh->add_partial( 'blogname', array(
			'selector'        => '.site-title a',
			'render_callback' => 'ansel_customize_partial_blogname',
		) );
		$wp_customize->selective_refresh->add_partial( 'blogdescription', array(
			'selector'        => '.site-description',
			'render_callback' => 'ansel_customize_partial_blogdescription',
		) );
	}
}
add_action( 'customize_register', 'ansel_customize_register' );

/**
 * Render the site title for the selective refresh partial.
 *
 * @return void
 */
function ansel_customize_partial_blogname() {
	bloginfo( 'name' );
}

/**
 * Render the site tagline for the selective refresh partial.
 *
 * @return void
 */
function ansel_customize_partial_blogdescription() {
	bloginfo( 'description' );
}

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function ansel_customize_preview_js() {
	wp_enqueue_script( 'ansel-customizer', get_template_directory_uri() . '/assets/js/customizer.js', array( 'customize-preview' ), '20151215', true );
}
add_action( 'customize_preview_init', 'ansel_customize_preview_js' );

/**
 * Check if the page is using the Portfolio Template.
 */
function ansel_is_page_template_portfolio() {
	if ( is_page_template( 'templates/portfolio-page.php' ) ) {
		return true;
	} else {
		return false;
	}
}

function ansel_sanitize_select( $input ) {
	// Ensure input is a slug.
	$input = sanitize_key( $input );

	// Get list of choices from the control associated with the setting.
	$choices = ansel_get_homepage_feature_content_choices();

	$options = $choices['options'];

	if ( array_key_exists( $input, $options['pages'] ) ) {
		$sanitized_input = $input;
	} elseif ( array_key_exists( $input, $options['portfolio_types'] ) ) {
		$sanitized_input = $input;
	} elseif ( array_key_exists( $input, $options['categories'] ) ) {
		$sanitized_input = $input;
	} else {
		$sanitized_input = 'select';
	}

	return $sanitized_input;
}

/**
 * Generate 9 Homepage Feature sections.
 */
function ansel_generate_customizer_homepage_feature_sections( $wp_customize ) {

	for ( $x = 1; $x <= 9; $x++ ) {

		$wp_customize->add_section( 'ansel_homepage_feature_' . $x, array(
			'title'           => esc_html__( 'Homepage Feature ' . $x, 'ansel' ),
			'active_callback' => 'ansel_is_page_template_portfolio',
			'panel'           => 'ansel_theme_options',
			'description'     => esc_html__( 'Homepage features link out to other sections of your website, such as your pages, project types, and post categories. They appear in a grid underneath your header image.', 'ansel' ),
		) );

		$wp_customize->add_setting( 'ansel_homepage_feature_content_' . $x, array(
			'default'           => false,
			'sanitize_callback' => 'ansel_sanitize_select',
		) );

		$wp_customize->add_control( new Ansel_Select_Homepage_Feature_Control( $wp_customize, 'ansel_homepage_feature_content_' . $x, array(
			'label'   => esc_html__( 'Feature Content', 'ansel' ),
			'section' => 'ansel_homepage_feature_' . $x,
			'type'    => 'select',
			'choices' => ansel_get_homepage_feature_content_choices(),
		) ) );

		$wp_customize->add_setting( 'ansel_homepage_feature_content_thumbnail_' . $x, array(
			'default'           => false,
			'sanitize_callback'	=> 'esc_url_raw',
		) );

		$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'ansel_homepage_feature_content_thumbnail_' . $x, array(
			'section'	=> 'ansel_homepage_feature_' . $x,
			'settings'	=> 'ansel_homepage_feature_content_thumbnail_' . $x,
			'label'		=> esc_html__( 'Feature Content Thumbnail', 'ansel' ),
		) ) );
	}
}

/**
 * Get all the options for the Homepage Feature Content select.
 */
function ansel_get_homepage_feature_content_choices() {
	$options = array(
		'pages'			  => '',
		'portfolio_types' => '',
		'categories'	  => '',
	);

	$types = array(
		'pages_label'			=> esc_html__( 'Pages', 'ansel' ),
		'portfolio_types_label' => esc_html__( 'Portfolio Types', 'ansel' ),
		'categories_label'		=> esc_html__( 'Categories', 'ansel' ),
	);

	$pages = get_pages();

	foreach ( $pages as $page ) {
		$page_id = 'page_' . $page->ID;
		$options['pages'][$page_id] = $page->post_title;
	}

	$portfolio_types = get_terms( array(
		'taxonomy' => 'jetpack-portfolio-type',
		'hide_empty' => false,
	) );

	foreach ( $portfolio_types as $portfolio_type ) {
		$portfolio_type_id = 'portfolio-type_' . $portfolio_type->term_id;
		$options['portfolio_types'][$portfolio_type_id] = $portfolio_type->name;
	}

	$categories = get_categories();

	foreach ( $categories as $category ) {
		$category_id = 'category_' . $category->term_id;
		$options['categories'][$category_id] = $category->name;
	}

	$choices = array(
		'types'   => $types,
		'options' => $options,
	);

	return $choices;
}

/**
 * Get homepage features data.
 */
function ansel_get_homepage_features() {
	$homepage_features = '';

	for ( $x = 1; $x <= 9; $x++ ) {
		$homepage_features[$x]['content'] = '';
		$homepage_features[$x]['thumbnail'] = '';

		$content = get_theme_mod('ansel_homepage_feature_content_' . $x );
		$thumbnail = get_theme_mod('ansel_homepage_feature_content_thumbnail_' . $x );

		if ( ! empty( $content ) ) {
			$homepage_features[$x]['content'] = $content;
		}

		if ( ! empty( $thumbnail ) ) {
			$homepage_features[$x]['thumbnail'] = $thumbnail;
		}
	}

	if ( empty( $homepage_features ) ) {
		return false;
	} else {
		$features = '';

		foreach ( $homepage_features as $feature ) {
			if ( ! empty( $feature['content'] ) || 'select' === $feature['content'] ) {

				$feature_id = '';

				if ( 'select' !== $feature['content'] ) {
					$exploded_feature = explode( '_', $feature['content'] );

					$feature_id = $exploded_feature[1];
					$feature_type = $exploded_feature[0];

					$features[$feature_id]['type'] = $feature_type;

					if ( ! empty( $feature['thumbnail'] ) ) {
						$features[$feature_id]['thumbnail'] = $feature['thumbnail'];
					} else {
						$features[$feature_id]['thumbnail'] = '';
					}
				}
			}
		}

		return $features;
	}
}

function ansel_homepage_get_feature_title( $id, $type ) {
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

function ansel_homepage_get_feature_url( $id, $type ) {
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


function ansel_homepage_feature_title( $id, $type ) {
	echo '<a href="' . esc_url( ansel_homepage_get_feature_url( $id, $type ) ) . '" rel="bookmark">' . apply_filters( 'the_title', ansel_homepage_get_feature_title( $id, $type ), $id ) . '</a>';
}

function ansel_homepage_feature_thumbnail( $src, $feature_id = '', $feature_type = '' ) {

	if ( ! empty ( $src ) ) {
		$thumbnail_id = ansel_get_attachment_id( $src );
	} else {
		$thumbnail_id = false;
	}

	$thumbnail_attr = '';

	if ( ! empty( $feature_id ) && ! empty ( $feature_type ) ) {
		$thumbnail_attr = array(
			 'alt' => esc_attr( ansel_homepage_get_feature_title( $feature_id, $feature_type ) ),
		);
	}

	if ( $thumbnail_id ) {
		$thumbnail = wp_get_attachment_image( $thumbnail_id, 'ansel-homepage-feature', false, $thumbnail_attr );
	} else {
		$thumbnail = '<img src="' . get_template_directory_uri() . '/assets/images/homepage-feature-default-thumbnail.png' . '" alt="' . $thumbnail_attr['alt'] . '" />';
	}

	$url = ansel_homepage_get_feature_url( $feature_id, $feature_type );

	if ( ! empty( $feature_id ) && ! empty ( $feature_type ) ) {
		$thumbnail = '<a href="' . esc_url( $url ) . '">' . $thumbnail . '</a>';
	}

	echo $thumbnail;
}

/**
 * Get an attachment ID given a URL.
 *
 * @param string $url
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
			)
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
