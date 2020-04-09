<?php
/**
 * The default template for displaying content
 *
 * Used for both single and index.
 *
 * @package Minimalist
 * @since 1.0.0
 */

?>

<article itemtype="http://schema.org/Article" itemscope="itemscope" id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php
		if ( is_single() ) {
			the_title( '<h1 class="entry-title" itemprop="name">', '</h1>' );
		} else {
			the_title( '<h2 class="entry-title" itemprop="name"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
		}
		?>
	</header><!-- .entry-header -->
	<div class="entry-content" itemprop="articleBody">
		<?php
		the_content();
		?>
	</div><!-- .entry-content -->
	<?php
	if ( minimalist_is_paginated_post() ) {
		echo '<footer class="entry-footer">';
			wp_link_pages(
				array(
					'before'      => '<nav class="post-nav-links nav-links pagination" aria-label="' . esc_attr__( 'Page', 'Minimalist' ) . '"><span class="screen-reader-text">' . __( 'Pages:', 'Minimalist' ) . '</span>',
					'after'       => '</nav>',
				)
			);
		echo '</footer><!-- .entry-footer -->';
	}
	?>
</article>
