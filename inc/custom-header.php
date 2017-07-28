<?php
/**
 * Sample implementation of the Custom Header feature
 *
 * You can add an optional custom header image to header.php like so ...
 *
	<?php the_header_image_tag(); ?>
 *
 * @link https://developer.wordpress.org/themes/functionality/custom-headers/
 *
 * @package Ansel
 */

/**
 * Set up the WordPress core custom header feature.
 *
 * @uses ansel_header_style()
 */
function ansel_custom_header_setup() {
	add_theme_support( 'custom-header', apply_filters( 'ansel_custom_header_args', array(
		'default-image'          => '',
		'default-text-color'     => '000000',
		'width'                  => 1000,
		'height'                 => 500,
		'flex-height'            => true,
		'wp-head-callback'       => 'ansel_header_style',
	) ) );
}
add_action( 'after_setup_theme', 'ansel_custom_header_setup' );

if ( ! function_exists( 'ansel_header_style' ) ) :
/**
 * Styles the header image and text displayed on the blog.
 *
 * @see ansel_custom_header_setup().
 */
function ansel_header_style() {
	$header_text_color = get_header_textcolor();

	/*
	 * If no custom options for text are set, let's bail.
	 * get_header_textcolor() options: Any hex value, 'blank' to hide text. Default: add_theme_support( 'custom-header' ).
	 */
	if ( get_theme_support( 'custom-header', 'default-text-color' ) === $header_text_color ) {
		return;
	}

	// If we get this far, we have custom styles. Let's do this.
	?>
	<style type="text/css">
	<?php
		// Has the text been hidden?
		if ( ! display_header_text() ) :
	?>
		.site-title,
		.site-description {
			position: absolute;
			clip: rect(1px, 1px, 1px, 1px);
		}
	<?php
		// If the user has set a custom color for the text use that.
		else :
	?>
		.site-title a,
		.site-description {
			color: #<?php echo esc_attr( $header_text_color ); ?>;
		}
	<?php endif; ?>
	</style>
	<?php
}
endif;

/**
 * Manages the logic for displaying the custom header image.
 */
function ansel_custom_header() {
	// Display the Featured Image as the Custom Header Image on Single Posts and Pages.
	if ( is_singular() && ansel_has_post_thumbnail() && ansel_jetpack_featured_image_display() ) { ?>
		<div class="featured-image-header">
			<a href="<?php the_permalink(); ?>">
				<?php the_post_thumbnail( 'ansel-featured-image-header' ); ?>
			</a>
		</div>
	<?php
	} elseif ( has_header_image() && 'jetpack-portfolio' !== get_post_type() ) { ?>
		<div class="featured-image-header">
			<?php the_header_image_tag(); ?>
		</div>
	<?php
	}
}

