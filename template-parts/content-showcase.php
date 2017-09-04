<?php
/**
 * Template part for displaying showcase items on the front page template
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Ansel
 */

global $showcase_id;
global $showcase_item;
?>

<article id="entry-<?php echo esc_attr( $showcase_id ); ?>" class="showcase-item">
	<div class="entry-thumbnail">
		<?php ansel_showcase_item_thumbnail( $showcase_item['thumbnail'], $showcase_id, $showcase_item['type'] ); ?>
	</div>

	<header class="entry-header">
		<h2 class="entry-title"><?php ansel_showcase_item_title( $showcase_id, $showcase_item['type'] ); ?></h2>
	</header>
</article><!-- #entry-## -->
