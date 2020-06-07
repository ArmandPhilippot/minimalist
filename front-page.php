<?php
/**
 * The template for displaying front-page.
 *
 * @package Minimalist
 * @since 1.0.0
 */

get_header(); ?>
<main id="main" class="site-main content-area">
	<?php
	if ( is_home() ) {
		if ( have_posts() ) {
			?>
			<article itemtype="http://schema.org/Article" itemscope="itemscope">
				<header class="entry-header">
					<?php if ( ! minimalist_is_frontpage() ) { ?>
						<h1 class="entry-title"><?php single_post_title(); ?>
						</h1>
					<?php } else { ?>
						<h2 class="entry-title"><?php esc_html_e( 'Posts', 'Minimalist' ); ?>
						</h2>
					<?php } ?>
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
	} else {
		if ( have_posts() ) {
			while ( have_posts() ) {
				the_post();
				get_template_part( 'template-parts/page/content', '' );
			}
		}
	}
	?>
</main><!-- #main -->
<?php
get_sidebar();
get_footer();

