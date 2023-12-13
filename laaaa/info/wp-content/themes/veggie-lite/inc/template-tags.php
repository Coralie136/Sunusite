<?php
/**
 * Custom template tags for this theme.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Veggie Lite
 */

if ( ! function_exists( 'veggie_posted_on' ) ) :
/**
 * Prints HTML with meta information for the current post-date/time and author.
 */
function veggie_posted_on() {
	list( $byline, $posted_on ) = veggie_posted_on_custom( true );

	echo '<p><span class="posted-on">' . $posted_on . '</span></p><span class="byline"> ' . $byline . '</span>'; // WPCS: XSS OK.

	if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
		echo '<span class="comments-link">';
		comments_popup_link( esc_html__( 'Leave a comment', 'veggie-lite' ), esc_html__( '1 Comment', 'veggie-lite' ), esc_html__( '% Comments', 'veggie-lite' ) );
		echo '</span>';
	}

	if ( ! is_single() ) {
		edit_post_link( sprintf( esc_html__( 'Edit %1$s', 'veggie-lite' ), '<span class="screen-reader-text">' . the_title_attribute( 'echo=0' ) . '</span>' ), '<span class="edit-link">', '</span>' );
	}
}
endif;

if ( ! function_exists( 'veggie_posted_on_custom' ) ) :
/**
 * Prints HTML with meta information for the current post-date/time and author.
 */
function veggie_posted_on_custom( $return=false ) {
	$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
	if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
		$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
	}

	$time_string = sprintf( $time_string,
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() ),
		esc_attr( get_the_modified_date( 'c' ) ),
		esc_html( get_the_modified_date() )
	);

	if ( is_single() ) {
		$posted_on = sprintf( esc_attr__( 'Posted on %1$s', 'veggie-lite' ),
						'<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>'
					);
	}
	else {
		$posted_on = '<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>';
	}

	if ( is_single() ) {
		$byline = sprintf( esc_html__( 'by %1$s', 'veggie-lite' ),
					'<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>'
				);
	}
	else {
		$byline = '<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>';
	}

	if ( $return ) {
		return array( $byline, $posted_on );
	} else {
		echo '<p><span class="posted-on">' . $posted_on . '</span></p><p class="author-name"><span class="byline"> ' . $byline . '</span></p>'; // WPCS: XSS OK.
	}

}
endif;

if ( ! function_exists( 'veggie_entry_footer' ) ) :
/**
 * Prints HTML with meta information for the categories, tags and comments.
 */
function veggie_entry_footer() {
	// Hide category and tag text for pages.
	if ( 'post' == get_post_type() ) {
		/* translators: used between list items, there is a space after the comma */
		$categories_list = get_the_category_list( esc_html__( ', ', 'veggie-lite' ) );
		if ( $categories_list && veggie_categorized_blog() ) {
			printf( '<span class="cat-links">' . esc_html__( 'Posted in %1$s', 'veggie-lite' ) . '</span>', $categories_list ); // WPCS: XSS OK.
		}

		/* translators: used between list items, there is a space after the comma */
		$tags_list = get_the_tag_list( '', esc_html__( ', ', 'veggie-lite' ) );
		if ( $tags_list ) {
			printf( '<span class="tags-links">' . esc_html__( 'Tagged %1$s', 'veggie-lite' ) . '</span>', $tags_list ); // WPCS: XSS OK.
		}
	}

	edit_post_link( sprintf( esc_html__( 'Edit %1$s', 'veggie-lite' ), '<span class="screen-reader-text">' . the_title_attribute( 'echo=0' ) . '</span>' ), '<span class="edit-link">', '</span>' );
}
endif;

/**
 * Returns true if a blog has more than 1 category.
 *
 * @return bool
 */
function veggie_categorized_blog() {
	if ( false === ( $all_the_cool_cats = get_transient( 'veggie_categories' ) ) ) {
		// Create an array of all the categories that are attached to posts.
		$all_the_cool_cats = get_categories( array(
			'fields'     => 'ids',
			'hide_empty' => 1,

			// We only need to know if there is more than one category.
			'number'     => 2,
		) );

		// Count the number of categories that are attached to the posts.
		$all_the_cool_cats = count( $all_the_cool_cats );

		set_transient( 'veggie_categories', $all_the_cool_cats );
	}

	if ( $all_the_cool_cats > 1 ) {
		// This blog has more than 1 category so veggie_categorized_blog should return true.
		return true;
	} else {
		// This blog has only 1 category so veggie_categorized_blog should return false.
		return false;
	}
}

/**
 * Flush out the transients used in veggie_categorized_blog.
 */
function veggie_category_transient_flusher() {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	// Like, beat it. Dig?
	delete_transient( 'veggie_categories' );
}
add_action( 'edit_category', 'veggie_category_transient_flusher' );
add_action( 'save_post',     'veggie_category_transient_flusher' );