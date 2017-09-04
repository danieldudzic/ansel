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
	 * Add the Showcase Item sections.
	 */
	ansel_generate_customizer_showcase_item_sections( $wp_customize );

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
 * Check if the page is using the Front Page template and displaying the showcase items.
 */
function ansel_is_page_template_showcase() {
	if ( is_front_page() ) {
		if ( 'posts' == get_option( 'show_on_front' ) ) {
			return false;
		} else {
			return true;
		}
	} else {
		return false;
	}
}

/**
 * Sanitize the Showcase Items select.
 */
function ansel_sanitize_select( $input ) {
	// Ensure input is a slug.
	$input = sanitize_key( $input );

	// Get list of choices from the control associated with the setting.
	$choices = ansel_get_showcase_item_content_choices();

	$options = $choices['options'];

	if ( ! empty( $options['pages'] ) && array_key_exists( $input, $options['pages'] ) ) {
		$sanitized_input = $input;
	} elseif ( ! empty( $options['portfolio_types'] ) && array_key_exists( $input, $options['portfolio_types'] ) ) {
		$sanitized_input = $input;
	} elseif ( ! empty( $options['categories'] ) && array_key_exists( $input, $options['categories'] ) ) {
		$sanitized_input = $input;
	} else {
		$sanitized_input = 'select';
	}

	return $sanitized_input;
}

/**
 * Generate 9 Showcase Item sections.
 */
function ansel_generate_customizer_showcase_item_sections( $wp_customize ) {

	for ( $x = 1; $x <= 9; $x++ ) {

		$wp_customize->add_section( 'ansel_showcase_item_' . $x, array(
			'title'           => esc_html__( 'Showcase Item ', 'ansel' ) . $x,
			'active_callback' => 'ansel_is_page_template_showcase',
			'panel'           => 'ansel_theme_options',
			'description'     => esc_html__( 'Showcase items link out to other sections of your website, such as your pages, project types, and post categories. They appear in a grid underneath your header image.', 'ansel' ),
		) );

		$wp_customize->add_setting( 'ansel_showcase_item_content_' . $x, array(
			'default'           => false,
			'sanitize_callback' => 'ansel_sanitize_select',
		) );

		$wp_customize->add_control( new Ansel_Select_Showcase_Item_Control( $wp_customize, 'ansel_showcase_item_content_' . $x, array(
			'label'   => esc_html__( 'Item Content', 'ansel' ),
			'section' => 'ansel_showcase_item_' . $x,
			'type'    => 'select',
			'choices' => ansel_get_showcase_item_content_choices(),
		) ) );

		$wp_customize->add_setting( 'ansel_showcase_item_content_thumbnail_' . $x, array(
			'default'           => false,
			'sanitize_callback' => 'esc_url_raw',
		) );

		$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'ansel_showcase_item_content_thumbnail_' . $x, array(
			'section'  => 'ansel_showcase_item_' . $x,
			'settings' => 'ansel_showcase_item_content_thumbnail_' . $x,
			'label'    => esc_html__( 'Item Content Thumbnail', 'ansel' ),
		) ) );
	}
}

/**
 * Get all the options for the Showcase Item Content select.
 */
function ansel_get_showcase_item_content_choices() {
	$options = array(
		'pages'           => '',
		'portfolio_types' => '',
		'categories'      => '',
	);

	$types = array(
		'pages_label'           => esc_html__( 'Pages', 'ansel' ),
		'portfolio_types_label' => esc_html__( 'Portfolio Types', 'ansel' ),
		'categories_label'      => esc_html__( 'Categories', 'ansel' ),
	);

	$pages = get_pages();

	foreach ( $pages as $page ) {
		$page_id = 'page_' . $page->ID;
		$options['pages'][ $page_id ] = $page->post_title;
	}

	if ( taxonomy_exists( 'jetpack-portfolio-type' ) ) {

		$portfolio_types = get_terms( array(
			'taxonomy' => 'jetpack-portfolio-type',
			'hide_empty' => false,
		) );

		foreach ( $portfolio_types as $portfolio_type ) {
			$portfolio_type_id = 'portfolio-type_' . $portfolio_type->term_id;
			$options['portfolio_types'][ $portfolio_type_id ] = $portfolio_type->name;
		}
	}

	$categories = get_categories();

	foreach ( $categories as $category ) {
		$category_id = 'category_' . $category->term_id;
		$options['categories'][ $category_id ] = $category->name;
	}

	$choices = array(
		'types'   => $types,
		'options' => $options,
	);

	return $choices;
}
