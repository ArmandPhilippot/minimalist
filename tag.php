<?php
/**
 * The template for displaying tags pages.
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
			<?php
			$minimalist_current_tag = single_tag_title( '', false );
			echo '<h1 class="page-title">' . esc_html( $minimalist_current_tag ) . '</h1>';
			if ( tag_description() ) {
				echo '<div class="taxonomy-description">' . wp_kses_post( tag_description() ) . '</div>';
			}
			?>
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

