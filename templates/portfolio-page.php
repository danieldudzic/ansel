<?php
/**
 * Template Name: Portfolio Page
 *
 * Homepage features link out to other sections of the website, such as pages, project types, and post categories.
 * They appear in a grid underneath the header image.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Ansel
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main portfolio-masonry">

			<?php
				$homepage_features = ansel_get_homepage_features();

				if ( ! empty ( $homepage_features ) ) {

					foreach( $homepage_features as $id => $feature ) { ?>

						<article id="entry-<?php echo $id; ?>" class="homepage-feature">
							<div class="entry-thumbnail">
								<?php ansel_homepage_feature_thumbnail( $feature['thumbnail'], $id, $feature['type'] ); ?>
							</div>

							<header class="entry-header">
								<h2 class="entry-title">
									<?php ansel_homepage_feature_title( $id, $feature['type'] ) ?>
								</h2><!-- .entry-header -->
							</header>

						</article><!-- #entry-## -->
					<?php }
				} ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php get_footer(); ?>
