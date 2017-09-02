<?php
/**
 * The template for displaying the Project Tag taxonomy archive page
 *
 * @package Ansel
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

			<?php
			if ( have_posts() ) : ?>

				<header class="page-header">
					<h1 class="page-title">
						<?php
						printf(
							wp_kses(
								/* translators: %s: project tag title */
								__( '<span>Project Tag:</span> %s', 'ansel' ),
								array(
									'span' => array(
										'class' => array(),
									),
								)
							),
							ansel_portfolio_title()
						); ?>
					</h1>
				</header><!-- .page-header -->

				<?php
				/* Start the Loop */
				while ( have_posts() ) : the_post();

					if ( 0 === $wp_query->current_post ) :
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
