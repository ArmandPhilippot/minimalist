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

<section class="no-results not-found">
	<header class="page-header">
		<h1 class="page-title">
			<?php esc_html_e( 'Nothing Found', 'Minimalist' ); ?>
		</h1>
	</header><!-- .page-header -->
	<div class="page-content">
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
	</div><!-- .page-content -->
</section><!-- .no-results -->
