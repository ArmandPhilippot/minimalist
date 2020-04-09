<?php
/**
 * Template part for displaying footer credits.
 *
 * @package Minimalist
 * @since 1.0.0
 */

// We store the date of the first article posted.
$minimalist_older_post    = get_posts( 'numberposts=1&order=ASC' );
$minimalist_copybeginning = mysql2date( 'Y', $minimalist_older_post['0']->post_date );
// We store the current year.
$minimalist_current_year = date_i18n(
	/* translators: Copyright date format, see https://secure.php.net/date */
	_x( 'Y', 'copyright date format', 'Minimalist' )
);
// If the current year is different from the year of the first article, we will display two dates.
if ( $minimalist_copybeginning < $minimalist_current_year ) {
	$minimalist_copyright = $minimalist_copybeginning . ' - ' . $minimalist_current_year;
} else {
	$minimalist_copyright = $minimalist_copybeginning;
}
?>
<div class="footer-credits">
	<div class="footer-credits-container">
		<div class="footer-copyright">
			<span itemprop="creator"><?php bloginfo( 'name' ); ?></span>
			&copy;
			<span itemprop="copyrightYear">
				<?php
				echo esc_html( $minimalist_copyright );
				?>
			</span>
		</div><!-- .footer-copyright -->
		<?php if ( has_nav_menu( 'footer-menu' ) ) { ?>
			<nav class="footer-menu" aria-label="<?php esc_html_e( 'Footer Links', 'Minimalist' ); ?>">
					<?php
					wp_nav_menu(
						array(
							'theme_location' => 'footer-menu',
							'container'      => false,
							'menu_id'        => 'footer-menu',
						)
					);
					?>
			</nav><!-- .footer-menu-nav -->
		<?php } ?>
		<div class="footer-theme-creator">
			<?php echo '<p>' . esc_html__( 'Theme by', 'Minimalist' ) . ' <a href="https://www.armandphilippot.com/" title="Armand Philippot"><img src="' . esc_url( get_theme_file_uri( '/assets/images/armandphilippot.png' ) ) . '" alt="Armand Philippot" /></a></p>'; ?>
		</div><!-- .footer-theme-creator -->
		<a class="to-the-top" href="#page" title="<?php esc_html_e( 'Back to top', 'Minimalist' ); ?>">
			<?php
			// translators: %s: HTML character for up arrow.
			printf( esc_html__( 'Up %s', 'Minimalist' ), '<span aria-hidden="true">&uarr;</span>' );
			?>
		</a><!-- .to-the-top -->
	</div><!-- .footer-credits-container -->
</div><!-- .footer-credits -->
