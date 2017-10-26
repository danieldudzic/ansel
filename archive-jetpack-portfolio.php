<?php
/**
 * The template for displaying the Portfolio archive page
 *
 * @package Ansel
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

			<?php
			if ( have_posts() ) : ?>

				<header class="page-header">
					<?php echo ansel_portfolio_title( '<h1 class="page-title">', '</h1>' ); ?>
					<?php echo ansel_portfolio_content( '<div class="archive-description">', '</div>' ); ?>
				</header><!-- .page-header -->

				<?php if ( ansel_portfolio_thumbnail() ) {
					echo ansel_portfolio_thumbnail( '<div class="featured-image-header">', '</div>' );
				} ?>

				<?php
				/* Start the Loop */
				while ( have_posts() ) : the_post();

					if ( 0 === $wp_query->current_post && ! ansel_portfolio_thumbnail() ) :
						get_template_part( 'template-parts/content', 'card-featured' );
					else :
						get_template_part( 'template-parts/content', 'card' );
					endif;

				endwhile; // End of the loop.
			else :

				get_template_part( 'template-parts/content', 'none' );

			endif; ?>

			<?php ansel_posts_navigation(); ?>
		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_footer();
