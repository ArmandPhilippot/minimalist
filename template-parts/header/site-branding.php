<?php
/**
 * Template part for displaying site branding.
 *
 * @package Minimalist
 * @since 1.0.0
 */

?>
<div class="site-branding">
	<?php if ( has_custom_logo() ) { ?>
		<div class="site-logo">
			<?php the_custom_logo(); ?>
		</div><!-- .site-logo -->
		<?php
	}
	?>
	<div class="site-branding-content">
		<?php
		if ( is_front_page() ) {
			?>
			<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
		<?php } else { ?>
			<p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a>
			</p>
		<?php } ?>
		<p class="site-description"><?php echo esc_html( get_bloginfo( 'description' ) ); ?></p>
	</div><!-- .site-branding-content -->
</div>
