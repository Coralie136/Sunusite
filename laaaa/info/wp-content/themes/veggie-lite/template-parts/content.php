<?php
/**
 * Template part for displaying posts.
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

		<?php the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>

	</header><!-- .entry-header -->

	<div class="entry-content">
		<?php
			/* translators: %s: Name of current post */
			the_content( sprintf(
				wp_kses( __( 'Continue reading %s <span class="meta-nav" aria-hidden="true">&rarr;</span>', 'veggie-lite' ), array( 'span' => array( 'class' => array() ) ) ),
				the_title( '<span class="screen-reader-text">"', '"</span>', false )
			) );
		?>

		<?php
			wp_link_pages( array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'veggie-lite' ),
				'after'  => '</div>',
			) );
		?>
	</div><!-- .entry-content -->
	<?php if( ! get_theme_mod( 'veggie_post_footer' ) ) : ?>
	<?php if ( 'post' == get_post_type() ) : ?>
		<div class="entry-meta">
			<?php veggie_posted_on(); ?>
		</div><!-- .entry-meta -->
	<?php endif; ?>
	<?php endif; ?>
</article><!-- #post-## -->
