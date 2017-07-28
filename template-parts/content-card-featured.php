<?php
/**
 * Template part for displaying portfolio posts on the archive page.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Ansel
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'entry-card entry-card-featured' ); ?>>
	<div class="post-thumbnail">
		<?php if ( ansel_has_post_thumbnail() ) : ?>
			<a href="<?php the_permalink(); ?>">
				<?php the_post_thumbnail( 'ansel-feature-card-featured' ); ?>
			</a>
		<?php else: ?>
			<a href="<?php the_permalink(); ?>">
				<img src="<?php echo get_template_directory_uri() . '/assets/images/card-default-thumbnail-featured.png' . '"' .  the_title_attribute( 'echo=0' ) . ' />'; ?>
			</a>
		<?php endif; ?>
	</div>
	<header class="entry-header">
		<?php
			the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
		?>
	</header><!-- .entry-header -->
</article><!-- #post-<?php the_ID(); ?> -->
