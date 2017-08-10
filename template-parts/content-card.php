<?php
/**
 * Template part for displaying portfolio posts on the archive page.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Ansel
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'entry-card' ); ?>>
	<div class="post-thumbnail">
		<?php if ( ansel_has_post_thumbnail() ) : ?>
			<a href="<?php the_permalink(); ?>">
				<?php the_post_thumbnail( 'ansel-feature-card' ); ?>
			</a>
		<?php else : ?>
			<a class="placeholder" href="<?php the_permalink(); ?>">
				<?php the_title( '<span class="screen-reader-text">', '</span>' ); ?>
			</a>
		<?php endif; ?>
	</div>
	<header class="entry-header">
		<?php the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' ); ?>
	</header><!-- .entry-header -->
</article><!-- #post-<?php the_ID(); ?> -->
