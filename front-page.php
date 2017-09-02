<?php
/**
 * The front page template file.
 *
 * If the user has selected a static page for their homepage, this is what will appear.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Ansel
 */

if ( 'posts' == get_option( 'show_on_front' ) ) :

	get_template_part( 'index' );

else :

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
				else :

					if ( current_user_can( 'publish_posts' ) ) : ?>

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

					else : ?>

						<article class="page no-showcase-items">
							<div class="entry-content">
								<?php esc_html_e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'ansel' ); ?>
							</div>
							<?php get_search_form(); ?>
						</article>
						<?php

					endif;
				endif; ?>

			</main><!-- #main -->
		</div><!-- #primary -->

	<?php get_footer();
endif;
