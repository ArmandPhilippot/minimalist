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
		<article itemtype="http://schema.org/Article" itemscope="itemscope">
			<header class="entry-header">
				<?php
				$minimalist_current_tag = single_tag_title( '', false );
				echo '<h1 class="entry-title">' . esc_html( $minimalist_current_tag ) . '</h1>';
				if ( tag_description() ) {
					echo '<div class="taxonomy-description">' . wp_kses_post( tag_description() ) . '</div>';
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

