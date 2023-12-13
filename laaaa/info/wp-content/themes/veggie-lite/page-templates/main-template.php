<?php
/**
 * Template Name: Front Template
 * The template for displaying a front page.
 *
 * @package Veggie Lite
 */

get_header(); ?>

	<div id="primary" class="content-area frontpage">
		<main id="main" class="site-main" role="main">
			<div class="main-content">

				<?php while ( have_posts() ) : the_post(); ?>

					<?php get_template_part( 'template-parts/content', 'page' ); ?>

					<?php
						// If comments are open or we have at least one comment, load up the comment template.
						if ( comments_open() || get_comments_number() ) :
							comments_template();
						endif;
					?>

				<?php endwhile; // End of the loop. ?>

			</div><!-- .main-content -->

			<?php if ( is_active_sidebar( 'sidebar-2' ) ) : ?>
				<div class="two-third">
				<div class="widgetized-content">
					<?php get_sidebar( 'main' ); ?>
				</div><!-- .block-four -->
				</div>
				<div class="one-third lastcolumn secondblock">
				<?php get_sidebar(); ?>
				</div>
			<?php endif; ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php get_footer(); ?>