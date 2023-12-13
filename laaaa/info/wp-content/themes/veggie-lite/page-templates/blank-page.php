<?php
/**
 * Template Name: Page Builder Template
 *
 * @package Veggie Lite
 * @since Veggie Lite 1.2.1
 */

get_header(); ?>

	<div class="builder-content">

		<?php while ( have_posts() ) : the_post(); ?>

			<?php get_template_part( 'template-parts/content', 'blank' ); ?>

		<?php endwhile; // end of the loop. ?>

	</div><!-- #content -->
<?php get_footer(); ?>