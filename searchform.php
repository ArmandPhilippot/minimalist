<?php
/**
 * The template for displaying the searchform.
 *
 * Used any time that get_search_form() is called.
 *
 * @package Minimalist
 * @since 1.0.0
 */

/*
 * Generate a unique ID for each form and a string containing an aria-label if
 * one was passed to get_search_form() in the args array.
 */

$minimalist_unique_id = esc_attr( uniqid( 'search-form-' ) );

$minimalist_aria_label = ! empty( $args['label'] ) ? 'aria-label="' . esc_attr( $args['label'] ) . '"' : '';
?>
<form role="search" <?php echo $minimalist_aria_label; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Escaped above. ?> method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<label for="<?php echo esc_attr( $minimalist_unique_id ); ?>">
		<span class="screen-reader-text"><?php esc_html_e( 'Search for:', 'Minimalist' ); ?></span>
		<input type="search" id="<?php echo esc_attr( $minimalist_unique_id ); ?>" class="search-field" placeholder="<?php echo esc_attr_x( 'Search &hellip;', 'placeholder', 'Minimalist' ); ?>" value="<?php echo get_search_query(); ?>" name="s" />
	</label>
	<button type="submit" class="search-submit">
		<span class="screen-reader-text"><?php echo esc_html_x( 'Search', 'submit button', 'Minimalist' ); ?></span>
	</button>
</form>
