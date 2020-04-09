<?php
/**
 * The template for displaying posts.
 *
 * @package Minimalist
 * @since 1.0.0
 */

get_header(); ?>
<main id="main" class="site-main content-area">
	<?php
	if ( have_posts() ) {
		while ( have_posts() ) {
			the_post();
			get_template_part( 'template-parts/post/content', get_post_format() );
			if ( comments_open() || get_comments_number() ) {
				comments_template();
			}
		}
	}
	?>
</main><!-- #main -->
<?php
get_sidebar();
get_footer();

