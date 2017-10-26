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
		'title'       => esc_html__( 'Theme Options', 'ansel' ),
		'description' => esc_html__( 'Showcase items link out to other sections of your website, such as project types and tags. They appear in a grid underneath your header image.', 'ansel' ),
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
 * Generate 9 Showcase Item sections.
 */
function ansel_generate_customizer_showcase_item_sections( $wp_customize ) {

	for ( $x = 1; $x <= 9; $x++ ) {

		$wp_customize->add_section( 'ansel_showcase_item_' . $x, array(
			'title'       => esc_html__( 'Showcase Item ', 'ansel' ) . $x,
			'panel'       => 'ansel_theme_options',
			'description' => ansel_customizer_showcase_item_section_description(),
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
 * Return the description for the Showcase sections.
 */
function ansel_customizer_showcase_item_section_description() {
	$description = esc_html__( 'You will need to enable Portfolios in Jetpack > Settings > Writing > Custom content types in order to use the Showcase section.', 'ansel' );

	if ( ansel_project_type_tag_taxonomies_exist() ) {
		$description = esc_html__( 'Showcase items link out to other sections of your website, such as project types and tags. They appear in a grid underneath your header image.', 'ansel' );
	}

	return $description;
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

	if ( ! empty( $options['portfolio_types'] ) && array_key_exists( $input, $options['portfolio_types'] ) ) {
		$sanitized_input = $input;
	} elseif ( ! empty( $options['portfolio_tags'] ) && array_key_exists( $input, $options['portfolio_tags'] ) ) {
		$sanitized_input = $input;
	} else {
		$sanitized_input = 'select';
	}

	return $sanitized_input;
}

/**
 * Get all the options for the Showcase Item Content select.
 */
function ansel_get_showcase_item_content_choices() {
	$options = array(
		'portfolio_types' => '',
		'portfolio_tags'  => '',
	);

	$types = array(
		'portfolio_types_label' => esc_html__( 'Portfolio Types', 'ansel' ),
		'portfolio_tags_label'  => esc_html__( 'Portfolio Tags', 'ansel' ),
	);

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

	if ( taxonomy_exists( 'jetpack-portfolio-tag' ) ) {

		$portfolio_tags = get_terms( array(
			'taxonomy' => 'jetpack-portfolio-tag',
			'hide_empty' => false,
		) );

		foreach ( $portfolio_tags as $portfolio_tag ) {
			$portfolio_tag_id = 'portfolio-tag_' . $portfolio_tag->term_id;
			$options['portfolio_tags'][ $portfolio_tag_id ] = $portfolio_tag->name;
		}
	}

	$choices = array(
		'options' => $options,
		'types'   => $types,
	);

	return $choices;
}

/**
 * Check if the page is using the Front Page template and displaying the showcase items.
 */
function ansel_is_page_template_front_page() {
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
 * Check if Project Type or Tag taxonomies exist.
 */
function ansel_project_type_tag_taxonomies_exist() {
	if ( taxonomy_exists( 'jetpack-portfolio-type' ) || taxonomy_exists( 'jetpack-portfolio-tag' ) ) {
		return true;
	} else {
		return false;
	}
}