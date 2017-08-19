<?php
/**
 * Template Name: Showcase Page
 *
 * Showcase items link out to other sections of the website, such as pages, project types, and post categories.
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
			$showcase_items = ansel_get_showcase_items();

			if ( ! empty( $showcase_items ) ) :

				foreach ( $showcase_items as $id => $item ) { ?>

					<article id="entry-<?php echo esc_attr( $id ); ?>" class="showcase-item">
						<div class="entry-thumbnail">
							<?php ansel_showcase_item_thumbnail( $item['thumbnail'], $id, $item['type'] ); ?>
						</div>

						<header class="entry-header">
							<h2 class="entry-title"><?php ansel_showcase_item_title( $id, $item['type'] ); ?></h2>
						</header>

					</article><!-- #entry-## -->
					<?php
				}
			else : ?>

				<article class="page no-showcase-items">
					<header class="entry-header">
						<h1 class="entry-title"><?php esc_html_e( 'Showcase Items', 'ansel' ); ?></h1>
					</header>

					<div class="entry-content">
						<p><?php esc_html_e( 'Showcase items link out to other sections of the website, such as pages, project types, and post categories. They appear in a grid underneath the header image.', 'ansel' ); ?></p>

						<p><?php esc_html_e( 'You can set up this section in the Customizer > Theme Options.', 'ansel' ); ?></p>
					</div>
				</article>
				<?php
			endif; ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php get_footer();
