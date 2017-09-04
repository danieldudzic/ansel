<?php
/**
 * Template part for displaying info when no showcase items are set
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Ansel
 */

?>

<article class="page no-showcase-items">
	<header class="entry-header">
		<h1 class="entry-title"><?php esc_html_e( 'Showcase Items', 'ansel' ); ?></h1>
	</header>

	<div class="entry-content">
		<p><?php esc_html_e( 'Showcase items link out to other sections of the website, such as pages, project types, and post categories. They appear in a grid underneath the header image.', 'ansel' ); ?></p>

		<p><?php esc_html_e( 'You can set up this section in the Customizer > Theme Options.', 'ansel' ); ?></p>

		<p><?php esc_html_e( 'If you want to display static content, on your front page, instead of the Showcase items, simply add some content to this Page.', 'ansel' ); ?></p>
	</div>
</article>
