<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @package Minimalist
 * @since 1.0.0
 */

get_header(); ?>
<main id="main" class="site-main content-area">
	<?php
	if ( have_posts() ) {
		?>
		<header class="page-header">
			<?php if ( ! minimalist_is_frontpage() ) { ?>
				<h1 class="page-title"><?php single_post_title(); ?>
				</h1>
			<?php } else { ?>
				<h2 class="page-title"><?php esc_html_e( 'Posts', 'Minimalist' ); ?>
				</h2>
			<?php } ?>
		</header><!-- .page-header -->
		<?php
		while ( have_posts() ) {
			the_post();
			get_template_part( 'template-parts/post/content', get_post_format() );
		}
		the_posts_pagination(
			array(
				'mid_size'  => 2,
				'prev_text' => __( 'Previous', 'Minimalist' ),
				'next_text' => __( 'Next', 'Minimalist' ),
			)
		);
	} else {
		get_template_part( 'template-parts/post/content', 'none' );
	}
	?>
</main><!-- #main -->
<?php
get_sidebar();
get_footer();

