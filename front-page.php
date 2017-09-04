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
	$sidebar = '';

	get_header(); ?>

		<div id="primary" class="content-area">
			<main id="main" class="site-main">

				<?php
				$showcase_items = ansel_get_showcase_items();

				if ( ! empty( $showcase_items ) ) :

					foreach ( $showcase_items as $showcase_id => $showcase_item ) {
						global $showcase_id;
						global $showcase_item;

						get_template_part( 'template-parts/content', 'showcase' );
					}

				else :
					$sidebar = true;

					if ( have_posts() ) :
						while ( have_posts() ) : the_post();

							if ( get_the_content() ) {

								get_template_part( 'template-parts/content', 'page' );

							} else {

								if ( current_user_can( 'publish_posts' ) ) :

									get_template_part( 'template-parts/content', 'showcase-none' );

								else : ?>

									<article class="page no-showcase-items">
										<div class="entry-content">
											<?php esc_html_e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'ansel' ); ?>
										</div>
										<?php get_search_form(); ?>
									</article>

									<?php
								endif;
							}
						endwhile;
					endif;

				endif; ?>

				<?php ansel_posts_navigation(); ?>
			</main><!-- #main -->
		</div><!-- #primary -->

		<?php
	if ( $sidebar ) {
		get_sidebar();
	}
	get_footer();
endif;
