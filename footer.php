<?php
/**
 * The template for displaying the footer.
 *
 * @package Minimalist
 * @since 1.0.0
 */

?>
</div><!-- .content-container -->
</div><!-- #content -->
<footer id="colophon" class="site-footer">
	<div class="footer-container site-container">
		<?php
		get_template_part( 'template-parts/footer/widgets', '' );
		get_template_part( 'template-parts/footer/credits', '' );
		?>
	</div><!-- .footer-container -->
</footer><!-- #colophon -->
</div><!-- #page -->
<?php wp_footer(); ?>
</body>

</html>
