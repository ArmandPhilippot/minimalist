<?php
/**
 * Woocommerce features for this theme.
 *
 * @package Minimalist
 * @since 1.1.0
 */

/**
 * Disable all Woocommerce stylesheets.
 */
add_filter( 'woocommerce_enqueue_styles', '__return_empty_array' );

/**
 * Unhook the WooCommerce wrappers.
 */
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );

/**
 * Wrapper for Woocommerce pages. Markup opening.
 */
function minimalist_woocommerce_wrapper_start() {
	echo '<main id="main" class="site-main content-area"><article itemtype="http://schema.org/Article" itemscope="itemscope" id="post-' . esc_attr( get_the_ID() ) . '" class="' . esc_attr( join( ' ', get_post_class() ) ) . '"><div class="entry-content" itemprop="articleBody">';
}
add_action( 'woocommerce_before_main_content', 'minimalist_woocommerce_wrapper_start', 10 );

/**
 * Wrapper for Woocommerce pages. Markup ending.
 */
function minimalist_woocommerce_wrapper_end() {
	echo '</div><!-- .entry-content --></article></main><!-- #main -->';
}
add_action( 'woocommerce_after_main_content', 'minimalist_woocommerce_wrapper_end', 10 );

/**
 * Override default pagination arguments. Change previous and next text.
 *
 * @param array $args Pagination arguments.
 * @return array $args Arguments overrided.
 */
function minimalist_woocommerce_override_pagination_args( $args ) {
	$args['prev_text'] = __( 'Previous', 'Minimalist' );
	$args['next_text'] = __( 'Next', 'Minimalist' );
	$args['type']      = 'plain';
	return $args;
}
add_filter( 'woocommerce_pagination_args', 'minimalist_woocommerce_override_pagination_args' );

/**
 * Remove default Single Product Meta.
 */
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );

/**
 * Change default Single Product Meta markup.
 */
function minimalist_woocommerce_template_single_meta() {
	global $product;
	echo '<ul class="product_meta">';
	if ( wc_product_sku_enabled() && ( $product->get_sku() || $product->is_type( 'variable' ) ) ) {
		echo '<li class="sku_wrapper">' . esc_html__( 'SKU:', 'Minimalist' ) . ' ';
		echo '<span class="sku">';
		$sku = $product->get_sku();
		if ( ! empty( $sku ) ) {
			echo esc_html( $sku );
		} else {
			esc_html_e( 'N/A', 'Minimalist' );
		}
		echo '</span>';
		echo '</li>';
	}
	echo wp_kses_post( wc_get_product_category_list( $product->get_id(), ', ', '<li class="posted_in">' . _n( 'Category:', 'Categories:', count( $product->get_category_ids() ), 'Minimalist' ) . ' ', '</li>' ) );

	echo wp_kses_post( wc_get_product_tag_list( $product->get_id(), ', ', '<li class="tagged_as">' . _n( 'Tag:', 'Tags:', count( $product->get_tag_ids() ), 'Minimalist' ) . ' ', '</li>' ) );

	echo '</ul>';
}
add_action( 'woocommerce_single_product_summary', 'minimalist_woocommerce_template_single_meta', 40 );

/**
 * Change review form markup
 *
 * @param array $comment_form The comment form.
 * @return array $comment_form The modified comment form.
 */
function minimalist_woocommerce_product_review_comment_form_args( $comment_form ) {
	$comment_form['title_reply_before'] = '<h3 id="reply-title" class="comment-reply-title">';
	$comment_form['title_reply_after']  = '</h3>';
	return $comment_form;
};
add_filter( 'woocommerce_product_review_comment_form_args', 'minimalist_woocommerce_product_review_comment_form_args', 10, 1 );

/**
 * Change review list arguments
 *
 * TODO: fix this issue!
 *
 * @param array $args The product review list arguments.
 * @return array $args The modified arguments.
 */
function minimalist_product_review_list_args( $args ) {
	$args['avatar_size'] = 100;
	return $args;
}
add_filter( 'woocommerce_product_review_list_args', 'minimalist_product_review_list_args', 10, 1 );

/**
 * Filter WooCommerce Search Field
 *
 * @param string $form The product search form.
 * @return string $form The modified search form.
 */
function minimalist_woocommerce_custom_product_searchform( $form ) {
	$minimalist_woocoomerce_unique_id = esc_attr( uniqid( 'woocommerce-product-search-field-' ) );

	$form = '<form role="search" method="get" class="woocommerce-product-search" action="' . esc_url( home_url( '/' ) ) . '">
		<label for="' . $minimalist_woocoomerce_unique_id . '">
			<span class="screen-reader-text">' . esc_html__( 'Search for:', 'Minimalist' ) . '</span>
			<input type="search" id="' . $minimalist_woocoomerce_unique_id . '" class="search-field" placeholder="' . esc_attr__( 'Search products&hellip;', 'Minimalist' ) . '" value="' . get_search_query() . '" name="s" />
		</label>
		<button type="submit" class="search-submit">
			<span class="screen-reader-text">' . esc_html_x( 'Search', 'submit button', 'Minimalist' ) . '</span>
		</button>
		<input type="hidden" name="post_type" value="product" />
	</form>';
	return $form;
}
add_filter( 'get_product_search_form', 'minimalist_woocommerce_custom_product_searchform' );

/**
 * Define the woocommerce_no_products_found callback
 *
 * @param string $wc_no_products_found The no products found message.
 */
function minimalist_woocommerce_no_products_found( $wc_no_products_found ) {
	echo '<p>' . esc_html__( 'It seems we can\'t find what you\'re looking for. Perhaps searching can help.', 'Minimalist' ) . '</p>';
	get_product_search_form();
}
add_action( 'woocommerce_no_products_found', 'minimalist_woocommerce_no_products_found', 10, 1 );

/**
 * Remove the subcategories from the product loop.
 */
remove_filter( 'woocommerce_product_loop_start', 'woocommerce_maybe_show_product_subcategories' );

/**
 * Separate categories from products in another list.
 */
function minimalist_woocommerce_reset_loop_start() {
	$shop_display_type       = get_option( 'woocommerce_shop_page_display', '' );
	$categories_display_type = get_option( 'woocommerce_category_archive_display', '' );
	if ( ( 'both' === $shop_display_type && is_shop() ) || ( 'both' === $categories_display_type && is_product_category() ) ) {
		echo '<h2 class="display-type-title">' . esc_html__( 'Products', 'Minimalist' ) . '</h2>';
	}
	echo '<ul class="products columns-' . esc_attr( wc_get_loop_prop( 'columns' ) ) . '">';
}
add_action( 'woocommerce_product_loop_start', 'minimalist_woocommerce_reset_loop_start' );

/**
 * Add subcategories before the product loop
 */
function minimalist_woocommerce_show_product_subcategories() {
	$subcategories = woocommerce_maybe_show_product_subcategories();
	if ( $subcategories ) {
		echo '<h2 class="display-type-title">' . esc_html__( 'Categories', 'Minimalist' ) . '</h2>';
		echo '<ul class="product-categories products columns-' . esc_attr( wc_get_loop_prop( 'columns' ) ) . '">' . wp_kses_post( $subcategories ) . '</ul>';
	}
}
add_action( 'woocommerce_before_shop_loop', 'minimalist_woocommerce_show_product_subcategories', 40 );

/**
 * Remove first & last classes from post classes.
 *
 * @param array $classes Post classes.
 * @return array $classes Post classes without first & last classes.
 */
function minimalist_woocommerce_remove_post_class( $classes ) {
	if ( 'product' === get_post_type() ) {
		$classes = array_diff( $classes, array( 'last', 'first' ) );
	}
	return $classes;
}
add_filter( 'woocommerce_post_class', 'minimalist_woocommerce_remove_post_class', 21, 3 );

/**
 * Remove first & last classes from categories classes.
 *
 * @param array $classes Categories classes.
 * @return array $classes Categories classes without first & last classes.
 */
function minimalist_woocommerce_remove_category_class( $classes ) {
	if ( 'product' === get_post_type() ) {
		$classes = array_diff( $classes, array( 'last', 'first' ) );
	}
	return $classes;
}
add_filter( 'product_cat_class', 'minimalist_woocommerce_remove_category_class', 21, 3 );

/**
 * Remove the default item title markup.
 */
remove_action( 'woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title', 10 );
remove_action( 'woocommerce_shop_loop_subcategory_title', 'woocommerce_template_loop_category_title', 10 );

/**
 * Change the default item title markup.
 */
function minimalist_woocommerce_shop_loop_item_title() {
	$subcategories = woocommerce_maybe_show_product_subcategories();
	if ( $subcategories || is_product() ) {
		echo '<h3 class="woocommerce-loop-product_title">' . esc_html( get_the_title() ) . '</h3>';
	} else {
		echo '<h2 class="woocommerce-loop-product_title">' . esc_html( get_the_title() ) . '</h2>';
	}
}
add_action( 'woocommerce_shop_loop_item_title', 'minimalist_woocommerce_shop_loop_item_title', 10 );

/**
 * Change the default category title markup.
 *
 * @param object $category Category object.
 */
function minimalist_woocommerce_shop_loop_category_title( $category ) {
	echo '<h3 class="woocommerce-loop-category__title">';
	echo esc_html( $category->name );
	if ( $category->count > 0 ) {
		echo apply_filters( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			'woocommerce_subcategory_count_html', // phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals
			' <mark class="count">(' . esc_html( $category->count ) . ')</mark>',
			$category // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		);
	}
	if ( $category->description ) {
		echo '<div class="product-category-description">';
			echo esc_html( mb_strimwidth( wp_strip_all_tags( $category->description ), 0, 80, '...' ) );
		echo '</div>';
	}
	echo '</h3>';
}
add_action( 'woocommerce_shop_loop_subcategory_title', 'minimalist_woocommerce_shop_loop_category_title' );

/**
 * Add a container around the product price
 *
 * @param string $price The product price.
 * @return string The price with its container.
 */
function minimalist_woocommerce_get_price_html( $price ) {
	return '<span class="product-price">' . $price . '</span>';
}
add_filter( 'woocommerce_get_price_html', 'minimalist_woocommerce_get_price_html', 10, 2 );

/**
 * Add a container & a screen reader class to stars.
 *
 * @param string  $html HTML for star rating.
 * @param float   $rating Rating being shown.
 * @param integer $count Total number of ratings.
 * @return string The modified HTML for star rating.
 */
function minimalist_woocommerce_get_star_rating_html( $html, $rating, $count ) {
	$html  = '<span style="width:' . ( ( $rating / 5 ) * 100 ) . '%">';
	$html .= '<span class="screen-reader-text">';
	if ( 0 < $count ) {
		/* translators: 1: rating 2: rating count */
		$html .= sprintf( _n( 'Rated %1$s out of 5 based on %2$s customer rating', 'Rated %1$s out of 5 based on %2$s customer ratings', $count, 'Minimalist' ), '<strong class="rating">' . esc_html( $rating ) . '</strong>', '<span class="rating">' . esc_html( $count ) . '</span>' );
	} else {
		/* translators: %s: rating */
		$html .= sprintf( esc_html__( 'Rated %s out of 5', 'Minimalist' ), '<strong class="rating">' . esc_html( $rating ) . '</strong>' );
	}
	$html .= '</span>';
	$html .= '</span>';
	return $html;
}
add_filter( 'woocommerce_get_star_rating_html', 'minimalist_woocommerce_get_star_rating_html', 10, 3 );

/**
 * Add a container to product name in Cart widget.
 *
 * @param string $product_get_name The product name.
 * @return string The product name with its container.
 */
function minimalist_woocommerce_cart_item_name( $product_get_name ) {
	return '<span class="product-title">' . $product_get_name . '</span>';
};
add_filter( 'woocommerce_cart_item_name', 'minimalist_woocommerce_cart_item_name', 10, 3 );
