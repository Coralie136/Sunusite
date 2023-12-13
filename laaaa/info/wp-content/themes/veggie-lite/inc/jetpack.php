<?php
/**
 * Jetpack Compatibility File
 * See: https://jetpack.me/
 *
 * @package Veggie Lite
 */

/**
 * Add theme support for Infinite Scroll.
 * See: https://jetpack.me/support/infinite-scroll/
 */
function veggie_jetpack_setup() {
	add_theme_support( 'jetpack-responsive-videos' );

	add_theme_support( 'post-thumbnails' );

} // end function veggie_jetpack_setup
add_action( 'after_setup_theme', 'veggie_jetpack_setup' );