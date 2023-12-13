<?php
/**
 * The template for displaying Author bios
 *
 * @package Veggie Lite
 * @since Veggie Lite 1.0
 */
?>

<div class="titlecomment">
    <p class="author-title"><?php esc_html_e( 'Published by', 'veggie-lite' ); ?></p>
</div>
<div class="author-info">
	<div class="author-avatar">
		<?php
		/**
		 * Filter the author bio avatar size.
		 *
		 * @since Veggie 1.0
		 *
		 * @param int $size The avatar height and width size in pixels.
		 */
		$author_bio_avatar_size = apply_filters( 'veggie_author_bio_avatar_size', 56 );

		echo get_avatar( get_the_author_meta( 'user_email' ), $author_bio_avatar_size );
		?>
	</div><!-- .author-avatar -->

	<div class="author-description">
		<p class="author-title"><?php echo get_the_author(); ?></p>

		<p class="author-bio">
			<?php the_author_meta( 'description' ); ?>
			<span><a class="author-link" href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" rel="author">
				<?php printf( esc_html__( 'View all posts by %s', 'veggie-lite' ), get_the_author() ); ?>
			</a></span>
		</p><!-- .author-bio -->

	</div><!-- .author-description -->
</div><!-- .author-info -->