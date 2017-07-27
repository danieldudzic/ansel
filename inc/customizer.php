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
	 * Add the Theme Options section
	 */
	$wp_customize->add_panel( 'ansel_theme_options', array(
		'title' => esc_html__( 'Theme Options', 'ansel' ),
	) );

	// Homepage Feature 1
	$wp_customize->add_section( 'ansel_panel_1', array(
		'title'           => esc_html__( 'Homepage Feature 1', 'ansel' ),
		'active_callback' => 'ansel_is_page_template_portfolio',
		'panel'           => 'ansel_theme_options',
		'description'     => esc_html__( 'Homepage features link out to other sections of your website, such as your pages, project types, and post categories. They appear in a grid underneath your header image.', 'ansel' ),
	) );

	$wp_customize->add_setting( 'ansel_panel_1', array(
		'default'           => false,
		'sanitize_callback' => 'ansel_sanitize_select',
	) );

	$wp_customize->add_control( new Ansel_Select_Homepage_Feature_Control( $wp_customize, 'ansel_panel_1', array(
		'label'   => esc_html__( 'Feature Content', 'ansel' ),
		'section' => 'ansel_panel_1',
		'type'    => 'select',
		'choices' => ansel_get_homepage_feature_content_choices(),
	) ) );

	// Homepage Feature 2
	$wp_customize->add_section( 'ansel_panel_2', array(
		'title'           => esc_html__( 'Homepage Feature 2', 'ansel' ),
		'active_callback' => 'ansel_is_page_template_portfolio',
		'panel'           => 'ansel_theme_options',
		'description'     => esc_html__( 'Add a background image to your panel by setting a featured image in the page editor. If you don&rsquo;t select a page, this panel will not be displayed.', 'ansel' ),
	) );

	$wp_customize->add_setting( 'ansel_panel_2', array(
		'default'           => false,
		'sanitize_callback' => 'ansel_sanitize_select',
	) );

	$wp_customize->add_control( new Ansel_Select_Homepage_Feature_Control( $wp_customize, 'ansel_panel_2', array(
		'label'   => esc_html__( 'Feature Content', 'ansel' ),
		'section' => 'ansel_panel_2',
		'type'    => 'select',
		'choices' => ansel_get_homepage_feature_content_choices(),
	) ) );

	// Homepage Feature 3
	$wp_customize->add_section( 'ansel_panel_3', array(
		'title'           => esc_html__( 'Homepage Feature 3', 'ansel' ),
		'active_callback' => 'ansel_is_page_template_portfolio',
		'panel'           => 'ansel_theme_options',
		'description'     => esc_html__( 'Add a background image to your panel by setting a featured image in the page editor. If you don&rsquo;t select a page, this panel will not be displayed.', 'ansel' ),
	) );

	$wp_customize->add_setting( 'ansel_panel_3', array(
		'default'           => false,
		'sanitize_callback' => 'ansel_sanitize_select',
	) );

	$wp_customize->add_control( new Ansel_Select_Homepage_Feature_Control( $wp_customize, 'ansel_panel_3', array(
		'label'   => esc_html__( 'Feature Content', 'ansel' ),
		'section' => 'ansel_panel_3',
		'type'    => 'select',
		'choices' => ansel_get_homepage_feature_content_choices(),
	) ) );

	// Homepage Feature 4
	$wp_customize->add_section( 'ansel_panel4', array(
		'title'           => esc_html__( 'Homepage Feature 4', 'ansel' ),
		'active_callback' => 'ansel_is_page_template_portfolio',
		'panel'           => 'ansel_theme_options',
		'description'     => esc_html__( 'Add a background image to your panel by setting a featured image in the page editor. If you don&rsquo;t select a page, this panel will not be displayed.', 'ansel' ),
	) );

	$wp_customize->add_setting( 'ansel_panel4', array(
		'default'           => false,
		'sanitize_callback' => 'ansel_sanitize_select',
	) );

	$wp_customize->add_control( new Ansel_Select_Homepage_Feature_Control( $wp_customize, 'ansel_panel4', array(
		'label'   => esc_html__( 'Feature Content', 'ansel' ),
		'section' => 'ansel_panel4',
		'type'    => 'select',
		'choices' => ansel_get_homepage_feature_content_choices(),
	) ) );

	// Homepage Feature 5
	$wp_customize->add_section( 'ansel_panel_5', array(
		'title'           => esc_html__( 'Homepage Feature 5', 'ansel' ),
		'active_callback' => 'ansel_is_page_template_portfolio',
		'panel'           => 'ansel_theme_options',
		'description'     => esc_html__( 'Add a background image to your panel by setting a featured image in the page editor. If you don&rsquo;t select a page, this panel will not be displayed.', 'ansel' ),
	) );

	$wp_customize->add_setting( 'ansel_panel_5', array(
		'default'           => false,
		'sanitize_callback' => 'ansel_sanitize_select',
	) );

	$wp_customize->add_control( new Ansel_Select_Homepage_Feature_Control( $wp_customize, 'ansel_panel_5', array(
		'label'   => esc_html__( 'Feature Content', 'ansel' ),
		'section' => 'ansel_panel_5',
		'type'    => 'select',
		'choices' => ansel_get_homepage_feature_content_choices(),
	) ) );

	// Homepage Feature 6
	$wp_customize->add_section( 'ansel_panel_6', array(
		'title'           => esc_html__( 'Homepage Feature 6', 'ansel' ),
		'active_callback' => 'ansel_is_page_template_portfolio',
		'panel'           => 'ansel_theme_options',
		'description'     => esc_html__( 'Add a background image to your panel by setting a featured image in the page editor. If you don&rsquo;t select a page, this panel will not be displayed.', 'ansel' ),
	) );

	$wp_customize->add_setting( 'ansel_panel_6', array(
		'default'           => false,
		'sanitize_callback' => 'ansel_sanitize_select',
	) );

	$wp_customize->add_control( new Ansel_Select_Homepage_Feature_Control( $wp_customize, 'ansel_panel_6', array(
		'label'   => esc_html__( 'Feature Content', 'ansel' ),
		'section' => 'ansel_panel_6',
		'type'    => 'select',
		'choices' => ansel_get_homepage_feature_content_choices(),
	) ) );

	// Homepage Feature 7
	$wp_customize->add_section( 'ansel_panel_7', array(
		'title'           => esc_html__( 'Homepage Feature 7', 'ansel' ),
		'active_callback' => 'ansel_is_page_template_portfolio',
		'panel'           => 'ansel_theme_options',
		'description'     => esc_html__( 'Add a background image to your panel by setting a featured image in the page editor. If you don&rsquo;t select a page, this panel will not be displayed.', 'ansel' ),
	) );

	$wp_customize->add_setting( 'ansel_panel_7', array(
		'default'           => false,
		'sanitize_callback' => 'ansel_sanitize_select',
	) );

	$wp_customize->add_control( new Ansel_Select_Homepage_Feature_Control( $wp_customize, 'ansel_panel_7', array(
		'label'   => esc_html__( 'Feature Content', 'ansel' ),
		'section' => 'ansel_panel_7',
		'type'    => 'select',
		'choices' => ansel_get_homepage_feature_content_choices(),
	) ) );

	// Homepage Feature 8
	$wp_customize->add_section( 'ansel_panel_8', array(
		'title'           => esc_html__( 'Homepage Feature 8', 'ansel' ),
		'active_callback' => 'ansel_is_page_template_portfolio',
		'panel'           => 'ansel_theme_options',
		'description'     => esc_html__( 'Add a background image to your panel by setting a featured image in the page editor. If you don&rsquo;t select a page, this panel will not be displayed.', 'ansel' ),
	) );

	$wp_customize->add_setting( 'ansel_panel_8', array(
		'default'           => false,
		'sanitize_callback' => 'ansel_sanitize_select',
	) );

	$wp_customize->add_control( new Ansel_Select_Homepage_Feature_Control( $wp_customize, 'ansel_panel_8', array(
		'label'   => esc_html__( 'Feature Content', 'ansel' ),
		'section' => 'ansel_panel_8',
		'type'    => 'select',
		'choices' => ansel_get_homepage_feature_content_choices(),
	) ) );

	// Homepage Feature 9
	$wp_customize->add_section( 'ansel_panel_9', array(
		'title'           => esc_html__( 'Homepage Feature 9', 'ansel' ),
		'active_callback' => 'ansel_is_page_template_portfolio',
		'panel'           => 'ansel_theme_options',
		'description'     => esc_html__( 'Add a background image to your panel by setting a featured image in the page editor. If you don&rsquo;t select a page, this panel will not be displayed.', 'ansel' ),
	) );

	$wp_customize->add_setting( 'ansel_panel_9', array(
		'default'           => false,
		'sanitize_callback' => 'ansel_sanitize_select',
	) );

	$wp_customize->add_control( new Ansel_Select_Homepage_Feature_Control( $wp_customize, 'ansel_panel_9', array(
		'label'   => esc_html__( 'Feature Content', 'ansel' ),
		'section' => 'ansel_panel_9',
		'type'    => 'select',
		'choices' => ansel_get_homepage_feature_content_choices(),
	) ) );

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

function ansel_sanitize_select( $input, $setting ) {
	// Ensure input is a slug.
	$input = sanitize_key( $input );

	// Get list of choices from the control associated with the setting.
	$choices = $setting->manager->get_control( $setting->id )->choices;

	// If the input is a valid key, return it; otherwise, return the default.
	return ( array_key_exists( $input, $choices ) ? $input : $setting->default );
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
		$portfolio_type_id = 'portfolio_type_' . $portfolio_type->term_id;
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
