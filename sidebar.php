<?php
/**
 * The template for displaying sidebar.
 *
 * @package Minimalist
 * @since 1.0.0
 */

if ( ! is_active_sidebar( 'site-sidebar' ) ) {
	return;
}
?>
<aside id="secondary" class="sidebar widget-area">
	<?php dynamic_sidebar( 'site-sidebar' ); ?>
</aside>
