<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package Veggie Lite
 */

?>

	</div><!-- #content -->

	<?php if ( is_active_sidebar( 'footer-1' ) || is_active_sidebar( 'footer-2' ) || is_active_sidebar( 'footer-3' ) ) : ?>

	<footer id="colophon" class="site-footer" role="contentinfo">

			<div class="footer-widgets clear">

				<?php if ( is_active_sidebar( 'footer-1' ) ) : ?>

					<div class="widget-area">

						<?php dynamic_sidebar( 'footer-1' ); ?>

					</div><!-- .widget-area -->

				<?php endif; ?>

				<?php if ( is_active_sidebar( 'footer-2' ) ) : ?>

					<div class="widget-area">

						<?php dynamic_sidebar( 'footer-2' ); ?>

					</div><!-- .widget-area -->

				<?php endif; ?>

				<?php if ( is_active_sidebar( 'footer-3' ) ) : ?>

					<div class="widget-area">

						<?php dynamic_sidebar( 'footer-3' ); ?>

					</div><!-- .widget-area -->

				<?php endif; ?>

			</div><!-- .footer-widgets -->

	</footer><!-- #colophon -->
	<?php endif; ?>
	<div class="site-info" role="contentinfo">
		<div class="copyright">
            <a href="http://www.anarieldesign.com/free-food-recipes-wordpress-theme/"><?php printf( esc_html__( 'Theme: %1$s.', 'veggie-lite' ), 'Veggie Lite designed by Anariel Design. Copyright 2015-2016 Anariel Design' ); ?></a>
        </div>
	</div><!-- .site-info -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>