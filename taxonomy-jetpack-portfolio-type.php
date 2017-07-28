<?php
/**
 * The template for displaying the Project Type taxonomy archive page
 *
 * @package Ansel
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

			<?php
				if ( have_posts() ) : ?>

					<header class="page-header">
						<?php
							ansel_portfolio_title( '<h1 class="page-title">' . esc_html( 'Project Type: ', 'ansel' ), '</h1>' );
						?>
					</header><!-- .page-header -->

					<?php
						/* Start the Loop */
						while ( have_posts() ) : the_post();

							if ( 0 === $wp_query->current_post ) :
								get_template_part( 'template-parts/content', 'card-featured' );
							else :
								get_template_part( 'template-parts/content', 'card' );
							endif;

						endwhile;
				else :

					get_template_part( 'template-parts/content', 'none' );

				endif; ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php get_footer(); ?>
