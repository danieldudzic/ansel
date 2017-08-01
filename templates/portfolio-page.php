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
		<main id="main" class="site-main">

			<?php
			$homepage_features = ansel_get_homepage_features();

			if ( ! empty( $homepage_features ) ) :

				foreach ( $homepage_features as $id => $feature ) { ?>

					<article id="entry-<?php echo esc_attr( $id ); ?>" class="entry-card">
						<div class="entry-thumbnail">
							<?php ansel_homepage_feature_thumbnail( $feature['thumbnail'], $id, $feature['type'] ); ?>
						</div>

						<header class="entry-header">
							<h2 class="entry-title"><?php ansel_homepage_feature_title( $id, $feature['type'] ); ?></h2>
						</header>

					</article><!-- #entry-## -->
					<?php
				}
			else : ?>

				<article class="page no-homepage-features">
					<header class="entry-header">
						<h1 class="entry-title"><?php esc_html_e( 'Homepage Features', 'ansel' ); ?></h1>
					</header>

					<div class="entry-content">
						<p><?php esc_html_e( 'Homepage features link out to other sections of the website, such as pages, project types, and post categories. They appear in a grid underneath the header image.', 'ansel' ); ?></p>

						<p><?php esc_html_e( 'You can set up this section in the Customizer > Theme Options.', 'ansel' ); ?></p>
					</div>
				</article>
				<?php
			endif; ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php get_footer();
