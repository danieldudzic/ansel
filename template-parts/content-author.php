<?php
/**
 * Template part for displaying the Author Bio
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Ansel
 */

?>

<div class="entry-author">
	<div class="author-avatar"><?php echo get_avatar( get_the_author_meta( 'user_email' ), 90 ); ?></div>

	<div class="author-heading">
		<h2 class="author-title">
			<?php esc_html_e( 'Published by', 'ansel' ); ?> <span class="author-name"><?php the_author(); ?></span>
		</h2>
	</div>

	<p class="author-bio"><?php the_author_meta( 'description' ); ?>
		<a class="author-link" href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" title="<?php echo esc_attr( get_the_author() ); ?>">
			<?php echo sprintf( esc_html( 'View all posts by %s', 'ansel' ), get_the_author() ); ?>
		</a>
	</p>
</div>
