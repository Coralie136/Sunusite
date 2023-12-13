<?php
/**
 * Template part for displaying single posts.
 *
 * @package Veggie
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php if ( has_post_thumbnail() ) { ?>
		<div class="post-thumbnail">
			<a href="<?php the_permalink(); ?>">
				<?php the_post_thumbnail( 'default-thumb' ); ?>
			</a>
		</div>
		<?php } ?>

		<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>

		<?php if( ! get_theme_mod( 'veggie_post_footer' ) ) : ?>
		<div class="entry-meta">
			<?php veggie_posted_on(); ?>
		</div><!-- .entry-meta -->
		<?php endif; ?>

	</header><!-- .entry-header -->

	<div class="entry-content">
		<?php the_content(); ?>
		<?php
			wp_link_pages( array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'veggie-lite' ),
				'after'  => '</div>',
			) );
		?>
	</div><!-- .entry-content -->

	<?php if( ! get_theme_mod( 'veggie_post_footer' ) ) : ?>
	<footer class="entry-footer">
		<?php veggie_entry_footer(); ?>
	</footer><!-- .entry-footer -->
	<?php endif; ?>

	<?php if( ! get_theme_mod( 'veggie_author_bio' ) ) : ?>
	<?php get_template_part( 'author-bio' );?>
	<?php endif; ?>
</article><!-- #post-## -->

