<?php
/**
 * The default template for 404 page.
 *
 * Template part for displaying a message that posts cannot be found.
 *
 * @package Minimalist
 * @since 1.0.0
 */

?>

<article itemtype="http://schema.org/Article" itemscope="itemscope">
	<header class="entry-header">
		<h1 class="entry-title">
			<?php esc_html_e( 'Nothing Found', 'Minimalist' ); ?>
		</h1>
	</header><!-- .entry-header -->
	<div class="entry-content">
		<?php if ( is_home() && current_user_can( 'publish_posts' ) ) { ?>
			<p>
				<?php
				printf(
					// translators: %1$s: URL to publish post.
					esc_html__( 'Ready to publish your first post? <a href="%1$s">Get started here</a>.', 'Minimalist' ),
					esc_url( admin_url( 'post-new.php' ) )
				);
				?>
			</p>
		<?php } else { ?>
			<p><?php esc_html_e( 'It seems we can\'t find what you\'re looking for. Perhaps searching can help.', 'Minimalist' ); ?></p>
			<?php
			get_search_form();
		}
		?>
	</div><!-- .entry-content -->
</article>
