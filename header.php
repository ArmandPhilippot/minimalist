<?php
/**
 * Header file.
 *
 * @package Minimalist
 * @since 1.0.0
 */

?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?> itemscope="itemscope" itemtype="http://schema.org/WebPage">
	<div id="page" class="site">
		<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'Minimalist' ); ?></a>
		<header id="masthead" class="site-header">
			<div class="header-container site-container">
				<?php
				get_template_part( 'template-parts/header/site', 'branding' );
				get_template_part( 'template-parts/header/navigation', 'top' );
				?>
			</div><!-- .header-container -->
		</header><!-- .site-header -->
		<div id="content" class="site-content">
			<div class="content-container">
