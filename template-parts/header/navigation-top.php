<?php
/**
 * Template part for displaying top navigation.
 *
 * @package Minimalist
 * @since 1.0.0
 */

?>

<input type="checkbox" id="top-nav" name="top-nav" aria-labelledby="top-nav-toggle" />
<label for="top-nav" class="top-nav-label" id="top-nav-toggle">
	<span class="open-close-menu">
		<span class="open-menu"><?php esc_html_e( 'Open menu', 'Minimalist' ); ?></span>
		<span class="close-menu"><?php esc_html_e( 'Close menu', 'Minimalist' ); ?></span>
	</span>
</label>
<nav id="site-navigation" class="main-navigation" aria-label="<?php esc_attr_e( 'Primary Menu', 'Minimalist' ); ?>">
	<?php
	if ( has_nav_menu( 'primary-menu' ) ) {
		wp_nav_menu(
			array(
				'theme_location' => 'primary-menu',
				'container'      => false,
				'menu_id'        => 'header-menu',
				'item_spacing'   => 'discard',
			)
		);
	} else {
		echo '<ul class="menu">';
		wp_list_pages(
			array(
				'match_menu_classes'  => true,
				'show_sub_menu_icons' => true,
				'title_li'            => false,
				'item_spacing'        => 'discard',
			)
		);
		echo '</ul>';
	}
	?>
</nav><!-- #site-navigation -->
