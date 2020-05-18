<?php
/**
 * The template for displaying author pages.
 *
 * @package Minimalist
 * @since 1.0.0
 */

get_header(); ?>
<main id="main" class="site-main content-area">
	<?php
	if ( have_posts() ) {
		$minimalist_author = get_user_by( 'slug', get_query_var( 'author_name' ) );
		?>
		<article itemtype="http://schema.org/Article" itemscope="itemscope">
			<header class="entry-header">
				<?php
				echo '<h1 class="entry-title">' . esc_html( get_the_author_meta( 'nickname', $minimalist_author->ID ) ) . '</h1>';
				if ( '' !== get_the_author_meta( 'description', $minimalist_author->ID ) || '' !== get_the_author_meta( 'user_url', $minimalist_author->ID ) ) {
					echo '<div class="taxonomy-description">';
					echo wp_kses_post( wpautop( get_the_author_meta( 'description', $minimalist_author->ID ) ) );
					if ( '' !== get_the_author_meta( 'user_url', $minimalist_author->ID ) ) {
						echo '<p class="author-website"><span class="fields">' . esc_html__( 'Website:', 'Minimalist' ) . '</span> <a href="' . esc_url( get_the_author_meta( 'user_url', $minimalist_author->ID ) ) . '">' . esc_url( get_the_author_meta( 'user_url', $minimalist_author->ID ) ) . '</a></p>';
					}
					echo '</div>';
				}
				?>
			</header><!-- .entry-header -->
			<div class="entry-content">
				<div class="entries-list">
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
					?>
				</div><!-- .entries-list -->
			</div><!-- .entry-content -->
		</article>
		<?php
	} else {
		get_template_part( 'template-parts/post/content', 'none' );
	}
	?>
</main><!-- #main -->
<?php
get_sidebar();
get_footer();

