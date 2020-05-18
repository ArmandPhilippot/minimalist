<?php
/**
 * Minimalist-Theme functions and definitions.
 *
 * This file is read by WordPress to setup the theme and his additionnal
 * features.
 *
 * @package   Minimalist
 * @link      https://github.com/ArmandPhilippot/minimalist
 * @author    Armand Philippot <contact@armandphilippot.com>
 * @see       https://www.armandphilippot.com
 *
 * @copyright 2020 Armand Philippot
 * @license   GPL-2.0-or-later
 * @since     1.0.0
 */

/*
 * Currently theme version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'MINIMALIST_VERSION', '1.1.0' );

if ( ! function_exists( 'minimalist_setup' ) ) {
	/**
	 * Setup Minimalist theme and registers support for various
	 * WordPress features.
	 *
	 * @since 1.0.0
	 */
	function minimalist_setup() {
		// Make theme available for translation.
		load_theme_textdomain( 'Minimalist', get_template_directory() . '/languages' );

		// Add RSS feed links to <head> for posts and comments.
		add_theme_support( 'automatic-feed-links' );

		// Let WordPress manage the document title.
		add_theme_support( 'title-tag' );

		// Switch default core markup for search form, comment form, and comments to output valid HTML5.
		add_theme_support(
			'html5',
			array(
				'search-form',
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
				'script',
				'style',
			)
		);

		// Enable support for Custom Logo.
		add_theme_support(
			'custom-logo',
			array(
				'width'       => 150,
				'height'      => 150,
				'flex-height' => true,
				'flex-width'  => true,
			)
		);

		// Enable support for Post Thumbnails.
		add_theme_support( 'post-thumbnails' );
		add_image_size( 'minimalist-featured-image', 2000, 1200, true );
		add_image_size( 'minimalist-thumbnail-avatar', 100, 100, true );

		// Enable support for Post Formats.
		add_theme_support(
			'post-formats',
			array(
				'aside',
				'image',
				'video',
				'quote',
				'link',
				'gallery',
				'audio',
			)
		);

		// Enable the WordPress core custom background feature.
		add_theme_support(
			'custom-background',
			apply_filters(
				'minimalist_custom_background_args',
				array(
					'default-color' => 'ffffff',
					'default-image' => '',
				)
			)
		);

		// Enable support for full and wide align images.
		add_theme_support( 'align-wide' );

		// Enable support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		// Enable support for custom editor font sizes.
		add_theme_support(
			'editor-font-sizes',
			array(
				array(
					'name'      => __( 'Small', 'Minimalist' ),
					'shortName' => __( 'S', 'Minimalist' ),
					'size'      => 13,
					'slug'      => 'small',
				),
				array(
					'name'      => __( 'Normal', 'Minimalist' ),
					'shortName' => __( 'M', 'Minimalist' ),
					'size'      => 17,
					'slug'      => 'normal',
				),
				array(
					'name'      => __( 'Large', 'Minimalist' ),
					'shortName' => __( 'L', 'Minimalist' ),
					'size'      => 20,
					'slug'      => 'large',
				),
				array(
					'name'      => __( 'Huge', 'Minimalist' ),
					'shortName' => __( 'XL', 'Minimalist' ),
					'size'      => 24,
					'slug'      => 'huge',
				),
			)
		);

		// Enable support for responsive embedded content.
		add_theme_support( 'responsive-embeds' );

		// Make theme compatible with Woocommerce.
		add_theme_support( 'woocommerce' );

		// Add Woocommerce Gallery support.
		add_theme_support( 'wc-product-gallery-zoom' );
		add_theme_support( 'wc-product-gallery-lightbox' );
		add_theme_support( 'wc-product-gallery-slider' );

		// Register menu.
		register_nav_menus(
			array(
				'primary-menu' => __( 'Primary Menu', 'Minimalist' ),
				'footer-menu'  => __( 'Footer Menu', 'Minimalist' ),
			)
		);
	}
}
add_action( 'after_setup_theme', 'minimalist_setup' );

/**
 * Register Sidebars.
 *
 * @since 1.0.0
 */
function minimalist_widgets_init() {
	if ( function_exists( 'register_sidebar' ) ) {
		register_sidebar(
			array(
				'name'          => __( 'Sidebar', 'Minimalist' ),
				'id'            => 'site-sidebar',
				'description'   => __( 'Add widgets here to appear in your sidebar.', 'Minimalist' ),
				'before_title'  => '<p class="widget-title">',
				'after_title'   => '</p>',
				'before_widget' => '<div id="%1$s" class="widget %2$s">',
				'after_widget'  => '</div>',
			)
		);
		register_sidebar(
			array(
				'name'          => __( 'Footer', 'Minimalist' ),
				'id'            => 'footer-sidebar',
				'description'   => __( 'Add widgets here to appear in your footer.', 'Minimalist' ),
				'before_title'  => '<p class="widget-title">',
				'after_title'   => '</p>',
				'before_widget' => '<div id="%1$s" class="widget %2$s">',
				'after_widget'  => '</div>',
			)
		);
	}
}
add_action( 'widgets_init', 'minimalist_widgets_init' );

/**
 * Enqueue scripts and styles.
 *
 * @since 1.0.0
 */
function minimalist_scripts_styles() {
	// Register theme version in a variable.
	$theme_version = wp_get_theme()->get( 'Version' );
	// Register server path to the theme directory.
	$theme_directory = get_template_directory();
	// Register theme directory URI.
	$theme_uri = get_template_directory_uri();

	// Stylesheet - Register Styles.
	if ( file_exists( $theme_directory . '/style.min.css' ) ) {
		wp_register_style( 'minimalist-style', $theme_uri . '/style.min.css', array(), $theme_version );
	} else {
		wp_register_style( 'minimalist-style', $theme_uri . '/style.css', array(), $theme_version );
	}
	if ( file_exists( $theme_directory . '/print.min.css' ) ) {
		wp_register_style( 'minimalist-style-print', $theme_uri . '/print.min.css', array(), $theme_version );
	} else {
		wp_register_style( 'minimalist-style-print', $theme_uri . '/print.css', array(), $theme_version );
	}

	// Stylesheet - Enqueue Styles.
	wp_enqueue_style( 'minimalist-style' );
	wp_enqueue_style( 'minimalist-style-print' );

	// Javascript - Register Scripts.
	wp_register_script( 'html5', $theme_uri . '/assets/js/html5shiv/dist/html5shiv.min.js', array(), '3.7.3', true ); // Register the html5 shiv.

	// Javascript - Enqueue Scripts.
	wp_enqueue_script( 'html5' );
	wp_script_add_data( 'html5', 'conditional', 'lt IE 9' );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'minimalist_scripts_styles' );

/**
 * Enqueue supplemental block editor styles.
 *
 * @since 1.0.0
 */
function minimalist_block_editor_styles() {
	// Register theme version in a variable.
	$theme_version = wp_get_theme()->get( 'Version' );
	// Register server path to the theme directory.
	$theme_directory = get_template_directory();
	// Register theme directory URI.
	$theme_uri = get_template_directory_uri();

	// Register the editor styles.
	if ( file_exists( $theme_directory . '/assets/css/style-editor.min.css' ) ) {
		wp_register_style( 'minimalist-block-editor-styles', $theme_uri . '/assets/css/style-editor.min.css', array(), $theme_version );
	} else {
		wp_register_style( 'minimalist-block-editor-styles', $theme_uri . '/assets/css/style-editor.min.css', array(), $theme_version );
	}

	// Enqueue the editor styles.
	wp_enqueue_style( 'minimalist-block-editor-styles' );
}
add_action( 'enqueue_block_editor_assets', 'minimalist_block_editor_styles', 1, 1 );

/**
 * Add custom favicon
 *
 * @since 1.0.0
 */
function minimalist_favicon_links() {
	echo '<link rel="apple-touch-icon" sizes="180x180" href="' . esc_url( get_theme_file_uri( '/assets/images/favicon/apple-touch-icon.png' ) ) . '" />' . "\n";
	echo '<link rel="icon" type="image/png" sizes="32x32" href="' . esc_url( get_theme_file_uri( '/assets/images/favicon/favicon-32x32.png' ) ) . '" />' . "\n";
	echo '<link rel="icon" type="image/png" sizes="16x16" href="' . esc_url( get_theme_file_uri( '/assets/images/favicon/favicon-16x16.png' ) ) . '" />' . "\n";
	echo '<link ref="manifest" href="' . esc_url( get_theme_file_uri( '/assets/images/favicon/site.webmanifest' ) ) . '" />' . "\n";
	echo '<link rel="mask-icon" href="' . esc_url( get_theme_file_uri( '/assets/images/favicon/safari-pinned-tab.svg' ) ) . '" color="#1450aa" />' . "\n";
	echo '<link rel="shortcut icon" type="image/x-icon" href="' . esc_url( get_theme_file_uri( '/assets/images/favicon/favicon.ico' ) ) . '" />' . "\n";
	echo '<meta name="msapplication-TileColor" content="#1450aa">' . "\n";
	echo '<meta name="msapplication-config" content="' . esc_url( get_theme_file_uri( '/assets/images/favicon/browserconfig.xml' ) ) . '">' . "\n";
	echo '<meta name="theme-color" content="#1450aa">' . "\n";
}
add_action( 'wp_head', 'minimalist_favicon_links' );

/**
 * REQUIRED FILES
 * Include required files.
 */
// Additional features.
require get_parent_theme_file_path( '/inc/template-functions.php' );
// Woocommerce hooks & filters.
require get_parent_theme_file_path( '/inc/woocommerce-functions.php' );
