<?php
/**
 * Template part for displaying footer widgets.
 *
 * @package Minimalist
 * @since 1.0.0
 */

if ( ! is_active_sidebar( 'footer-sidebar' ) ) {
	return;
}
?>
<div class="footer-widgets">
	<?php dynamic_sidebar( 'footer-sidebar' ); ?>
</div><!-- .footer-widgets -->
