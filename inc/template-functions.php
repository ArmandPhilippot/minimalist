<?php
/**
 * Additional features for this theme.
 *
 * @package Minimalist
 * @since 1.0.0
 */

/**
 * Checks to see if we're on the front page or not.
 */
function minimalist_is_frontpage() {
	return is_front_page() && ! is_home();
}

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function minimalist_body_classes( $classes ) {
	// Add class if sidebar is used.
	if ( is_active_sidebar( 'site-sidebar' ) ) {
		$classes[] = 'has-sidebar';
	}

	return $classes;
}
add_filter( 'body_class', 'minimalist_body_classes' );

/**
 * Add submenu toggle button to menu items that have children.
 *
 * @param string $item_output Nav menu item start element.
 * @param object $item Nav menu item.
 * @param int    $depth Depth.
 * @param object $args Nav menu args.
 */
function minimalist_nav_menu_toogle_submenu( $item_output, $item, $depth, $args ) {
	$item_has_children = in_array( 'menu-item-has-children', $item->classes, true );
	if ( $item_has_children ) {
		$item_output .= '<input type="checkbox" id="submenu-toggle-' . $item->ID . '" name="submenu-toggle-' . $item->ID . '" aria-labelledby="submenu-toggle-label-' . $item->ID . '" class="submenu-toggle" />';
		$item_output .= '<label for="submenu-toggle-' . $item->ID . '" class="top-nav-label" id="submenu-toggle-label-' . $item->ID . '"><span class="open-close-menu"><span class="open-menu">' . __( 'Open submenu', 'Minimalist' ) . '</span><span class="close-menu">' . __( 'Close submenu', 'Minimalist' ) . '</span></span></label>';
	}

	return $item_output;
}
add_filter( 'walker_nav_menu_start_el', 'minimalist_nav_menu_toogle_submenu', 10, 4 );

/**
 * Overwrite default more tag with styling and screen reader markup.
 *
 * @since 1.0.0
 */
function minimalist_custom_read_more_link() {
	return sprintf(
		'<p class="link-more"><a href="%1$s" class="more-link">%2$s</a></p>',
		esc_url( get_permalink( get_the_ID() ) ),
		// translators: %s: Name of current post.
		sprintf( __( 'Continue reading %s', 'Minimalist' ), the_title( '<span class="screen-reader-text">', '</span>', false ) )
	);
}
add_filter( 'the_content_more_link', 'minimalist_custom_read_more_link' );

/**
 * Custom Excerpt.
 * Replaces "[...]" (appended to automatically generated excerpts) with a 'Continue reading' link.
 *
 * @param string $output The default output HTML for the more tag.
 * @return string 'Continue reading' link.
 *
 * @since 1.0.0
 */
function minimalist_excerpt_more( $output ) {
	$link = sprintf(
		'<p class="link-more"><a href="%1$s" class="more-link">%2$s</a></p>',
		esc_url( get_permalink( get_the_ID() ) ),
		// translators: %s: Name of current post.
		sprintf( __( 'Continue reading %s', 'Minimalist' ), the_title( '<span class="screen-reader-text">', '</span>', false ) )
	);

	return $output . $link;
}
add_filter( 'the_excerpt', 'minimalist_excerpt_more' );

/**
 * Determines whether or not the current post is a paginated post.
 *
 * @return  boolean  True if the post is paginated; false, otherwise.
 * @package includes
 * @since   1.0.0
 */
function minimalist_is_paginated_post() {
	global $multipage;
	return 0 !== $multipage;
}
