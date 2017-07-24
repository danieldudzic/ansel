<?php
/**
 * The template for displaying the Portfolio archive page.
 *
 * @package Ansel
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

		<?php if ( have_posts() ) : ?>

			<?php ansel_portfolio_thumbnail( '<div class="entry-image">', '</div>' ) ?>

			<header class="page-header">
				<?php
					ansel_portfolio_title( '<h1 class="page-title">', '</h1>' );
					ansel_portfolio_content( '<div class="taxonomy-description">', '</div>' );
				?>
			</header><!-- .page-header -->

			<div id="infinite-wrap">

				<?php /* Start the Loop */ ?>
				<?php while ( have_posts() ) : the_post(); ?>

					<?php get_template_part( 'template-parts/content', 'portfolio' ); ?>

				<?php endwhile; ?>

				<?php
					the_posts_navigation( array(
						'prev_text'          => esc_html__( 'Older projects', 'ansel' ),
						'next_text'          => esc_html__( 'Newer projects', 'ansel' ),
						'screen_reader_text' => esc_html__( 'Portfolio navigation', 'ansel' ),
					) );
				?>

			</div>

		<?php else : ?>

			<?php get_template_part( 'template-parts/content', 'none' ); ?>

		<?php endif; ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
