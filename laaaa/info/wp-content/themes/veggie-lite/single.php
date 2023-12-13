<?php
/**
 * The template for displaying all single posts.
 *
 * @package Veggie Lite
 */

get_header(); ?>

	<?php if ( is_active_sidebar( 'sidebar-1' ) ) : ?>
	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

		<?php while ( have_posts() ) : the_post(); ?>

			<?php get_template_part( 'template-parts/content', 'single' ); ?>

			<?php the_post_navigation( array( 'next_text' => wp_kses( __( '<span class="meta-nav">Next Post</span> %title', 'veggie-lite' ), array( 'span' => array( 'class' => array() ) ) ), 'prev_text' => wp_kses( __( '<span class="meta-nav">Previous Post</span> %title', 'veggie-lite' ), array( 'span' => array( 'class' => array() ) ) ) ) ); ?>

			<?php
				// If comments are open or we have at least one comment, load up the comment template.
				if ( comments_open() || get_comments_number() ) :
					comments_template();
				endif;
			?>

		<?php endwhile; // End of the loop. ?>

		</main><!-- #main -->
	</div><!-- #primary -->

	<?php get_sidebar(); ?>
	<?php else: ?>
	<div id="primary" class="content-area single-without-sidebar">
			<main id="main" class="site-main" role="main">

			<?php while ( have_posts() ) : the_post(); ?>

				<?php get_template_part( 'template-parts/content', 'single' ); ?>

				<?php the_post_navigation( array( 'next_text' => wp_kses( __( '<span class="meta-nav">Next Post</span> %title', 'veggie-lite' ), array( 'span' => array( 'class' => array() ) ) ), 'prev_text' => wp_kses( __( '<span class="meta-nav">Previous Post</span> %title', 'veggie-lite' ), array( 'span' => array( 'class' => array() ) ) ) ) ); ?>

				<?php
					// If comments are open or we have at least one comment, load up the comment template.
					if ( comments_open() || get_comments_number() ) :
						comments_template();
					endif;
				?>

			<?php endwhile; // End of the loop. ?>

			</main><!-- #main -->
		</div><!-- #primary -->
	<?php endif; ?>
<?php get_footer(); ?>