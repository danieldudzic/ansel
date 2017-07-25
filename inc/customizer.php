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
	$wp_customize->add_section( 'ansel_panel1', array(
		'title'           => esc_html__( 'Homepage Feature 1', 'ansel' ),
		'active_callback' => 'is_front_page',
		'panel'           => 'ansel_theme_options',
		'description'     => esc_html__( 'Add a background image to your panel by setting a featured image in the page editor. If you don&rsquo;t select a page, this panel will not be displayed.', 'ansel' ),
	) );

	$wp_customize->add_setting( 'ansel_panel1', array(
		'default'           => false,
		'sanitize_callback' => 'ansel_sanitize_numeric_value',
	) );

	$wp_customize->add_control( 'ansel_panel1', array(
		'label'   => esc_html__( 'Feature Content', 'ansel' ),
		'section' => 'ansel_panel1',
		'type'    => 'dropdown-pages',
	) );

	// Homepage Feature 2
	$wp_customize->add_section( 'ansel_panel2', array(
		'title'           => esc_html__( 'Homepage Feature 2', 'ansel' ),
		'active_callback' => 'is_front_page',
		'panel'           => 'ansel_theme_options',
		'description'     => esc_html__( 'Add a background image to your panel by setting a featured image in the page editor. If you don&rsquo;t select a page, this panel will not be displayed.', 'ansel' ),
	) );

	$wp_customize->add_setting( 'ansel_panel2', array(
		'default'           => false,
		'sanitize_callback' => 'ansel_sanitize_numeric_value',
	) );

	$wp_customize->add_control( 'ansel_panel2', array(
		'label'   => esc_html__( 'Feature Content', 'ansel' ),
		'section' => 'ansel_panel2',
		'type'    => 'dropdown-pages',
	) );

	// Homepage Feature 3
	$wp_customize->add_section( 'ansel_panel3', array(
		'title'           => esc_html__( 'Homepage Feature 3', 'ansel' ),
		'active_callback' => 'is_front_page',
		'panel'           => 'ansel_theme_options',
		'description'     => esc_html__( 'Add a background image to your panel by setting a featured image in the page editor. If you don&rsquo;t select a page, this panel will not be displayed.', 'ansel' ),
	) );

	$wp_customize->add_setting( 'ansel_panel3', array(
		'default'           => false,
		'sanitize_callback' => 'ansel_sanitize_numeric_value',
	) );

	$wp_customize->add_control( 'ansel_panel3', array(
		'label'   => esc_html__( 'Feature Content', 'ansel' ),
		'section' => 'ansel_panel3',
		'type'    => 'dropdown-pages',
	) );

	// Homepage Feature 4
	$wp_customize->add_section( 'ansel_panel4', array(
		'title'           => esc_html__( 'Homepage Feature 4', 'ansel' ),
		'active_callback' => 'is_front_page',
		'panel'           => 'ansel_theme_options',
		'description'     => esc_html__( 'Add a background image to your panel by setting a featured image in the page editor. If you don&rsquo;t select a page, this panel will not be displayed.', 'ansel' ),
	) );

	$wp_customize->add_setting( 'ansel_panel4', array(
		'default'           => false,
		'sanitize_callback' => 'ansel_sanitize_numeric_value',
	) );

	$wp_customize->add_control( 'ansel_panel4', array(
		'label'   => esc_html__( 'Feature Content', 'ansel' ),
		'section' => 'ansel_panel4',
		'type'    => 'dropdown-pages',
	) );

	// Homepage Feature 5
	$wp_customize->add_section( 'ansel_panel5', array(
		'title'           => esc_html__( 'Homepage Feature 5', 'ansel' ),
		'active_callback' => 'is_front_page',
		'panel'           => 'ansel_theme_options',
		'description'     => esc_html__( 'Add a background image to your panel by setting a featured image in the page editor. If you don&rsquo;t select a page, this panel will not be displayed.', 'ansel' ),
	) );

	$wp_customize->add_setting( 'ansel_panel5', array(
		'default'           => false,
		'sanitize_callback' => 'ansel_sanitize_numeric_value',
	) );

	$wp_customize->add_control( 'ansel_panel5', array(
		'label'   => esc_html__( 'Feature Content', 'ansel' ),
		'section' => 'ansel_panel5',
		'type'    => 'dropdown-pages',
	) );

	// Homepage Feature 6
	$wp_customize->add_section( 'ansel_panel6', array(
		'title'           => esc_html__( 'Homepage Feature 6', 'ansel' ),
		'active_callback' => 'is_front_page',
		'panel'           => 'ansel_theme_options',
		'description'     => esc_html__( 'Add a background image to your panel by setting a featured image in the page editor. If you don&rsquo;t select a page, this panel will not be displayed.', 'ansel' ),
	) );

	$wp_customize->add_setting( 'ansel_panel6', array(
		'default'           => false,
		'sanitize_callback' => 'ansel_sanitize_numeric_value',
	) );

	$wp_customize->add_control( 'ansel_panel6', array(
		'label'   => esc_html__( 'Feature Content', 'ansel' ),
		'section' => 'ansel_panel6',
		'type'    => 'dropdown-pages',
	) );

	// Homepage Feature 7
	$wp_customize->add_section( 'ansel_panel7', array(
		'title'           => esc_html__( 'Homepage Feature 7', 'ansel' ),
		'active_callback' => 'is_front_page',
		'panel'           => 'ansel_theme_options',
		'description'     => esc_html__( 'Add a background image to your panel by setting a featured image in the page editor. If you don&rsquo;t select a page, this panel will not be displayed.', 'ansel' ),
	) );

	$wp_customize->add_setting( 'ansel_panel7', array(
		'default'           => false,
		'sanitize_callback' => 'ansel_sanitize_numeric_value',
	) );

	$wp_customize->add_control( 'ansel_panel7', array(
		'label'   => esc_html__( 'Feature Content', 'ansel' ),
		'section' => 'ansel_panel7',
		'type'    => 'dropdown-pages',
	) );

	// Homepage Feature 8
	$wp_customize->add_section( 'ansel_panel8', array(
		'title'           => esc_html__( 'Homepage Feature 8', 'ansel' ),
		'active_callback' => 'is_front_page',
		'panel'           => 'ansel_theme_options',
		'description'     => esc_html__( 'Add a background image to your panel by setting a featured image in the page editor. If you don&rsquo;t select a page, this panel will not be displayed.', 'ansel' ),
	) );

	$wp_customize->add_setting( 'ansel_panel8', array(
		'default'           => false,
		'sanitize_callback' => 'ansel_sanitize_numeric_value',
	) );

	$wp_customize->add_control( 'ansel_panel8', array(
		'label'   => esc_html__( 'Feature Content', 'ansel' ),
		'section' => 'ansel_panel8',
		'type'    => 'dropdown-pages',
	) );

	// Homepage Feature 9
	$wp_customize->add_section( 'ansel_panel9', array(
		'title'           => esc_html__( 'Homepage Feature 9', 'ansel' ),
		'active_callback' => 'is_front_page',
		'panel'           => 'ansel_theme_options',
		'description'     => esc_html__( 'Add a background image to your panel by setting a featured image in the page editor. If you don&rsquo;t select a page, this panel will not be displayed.', 'ansel' ),
	) );

	$wp_customize->add_setting( 'ansel_panel9', array(
		'default'           => false,
		'sanitize_callback' => 'ansel_sanitize_numeric_value',
	) );

	$wp_customize->add_control( 'ansel_panel9', array(
		'label'   => esc_html__( 'Feature Content', 'ansel' ),
		'section' => 'ansel_panel9',
		'type'    => 'dropdown-pages',
	) );

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
	wp_enqueue_script( 'ansel-customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), '20151215', true );
}
add_action( 'customize_preview_init', 'ansel_customize_preview_js' );
