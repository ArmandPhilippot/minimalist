<?php
/**
 * The template for displaying search pages.
 *
 * @package Minimalist
 * @since 1.0.0
 */

get_header(); ?>
<main id="main" class="site-main content-area">
	<?php if ( have_posts() ) { ?>
		<header class="page-header">
			<h1 class="page-title">
				<?php
				// translators: %s: search query.
				printf( esc_html__( 'Search Results for: %s', 'Minimalist' ), '<span>' . get_search_query() . '</span>' );
				?>
			</h1>
		</header>
		<?php
		while ( have_posts() ) {
			the_post();
			get_template_part( 'template-parts/post/content', 'excerpt' );
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
