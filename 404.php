<?php
/**
 * The template for displaying the 404 page.
 *
 * @package Minimalist
 * @since 1.0.0
 */

get_header(); ?>
<main id="main" class="site-main content-area">
	<?php get_template_part( 'template-parts/post/content', 'none' ); ?>
</main><!-- #main -->
<?php
get_sidebar();
get_footer();

