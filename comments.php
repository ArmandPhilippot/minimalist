<?php
/**
 * The template for displaying the comments and comment form.
 *
 * @package Minimalist
 * @since 1.0.0
 */

/*
 * If the current post is protected by a password and the visitor has not yet
 * entered the password we will return early without loading the comments.
*/
if ( post_password_required() ) {
	return;
}
?>

<div id="comments" class="comments-area">
	<?php
	if ( have_comments() ) {
		?>
		<h2 class="comments-title">
			<?php
			$minimalist_comment_count = get_comments_number();
			if ( '1' === $minimalist_comment_count ) {
				// translators: %s: post title.
				printf( esc_html_x( 'One reply to &ldquo;%s&rdquo;', 'comments title', 'Minimalist' ), esc_html( get_the_title() ) );
			} else {
				printf(
					esc_html(
						// translators: 1: number of comments, 2: post title.
						_nx(
							'%1$s reply to &ldquo;%2$s&rdquo;',
							'%1$s replies to &ldquo;%2$s&rdquo;',
							$minimalist_comment_count,
							'comments title',
							'Minimalist'
						)
					),
					esc_html( number_format_i18n( $minimalist_comment_count ) ),
					esc_html( get_the_title() )
				);
			}
			?>
		</h2>
		<ol class="comment-list">
		<?php
		wp_list_comments(
			array(
				'avatar_size' => 100,
				'style'       => 'ol',
				'short_ping'  => true,
				'reply_text'  => __( 'Reply', 'Minimalist' ),
			)
		);
		?>
	</ol>
		<?php
		the_comments_pagination(
			array(
				'mid_size'  => 2,
				'prev_text' => __( 'Previous', 'Minimalist' ),
				'next_text' => __( 'Next', 'Minimalist' ),
			)
		);
	}
	if ( ! comments_open() && get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) {
		?>
		<p class="no-comments"><?php esc_html_e( 'Comments are closed.', 'Minimalist' ); ?>
		</p>
		<?php
	}
	comment_form();
	?>
</div><!-- #comments -->
