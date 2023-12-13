<?php
/**
 * The sidebar containing the widget area for the front page.
 *
 * @package Veggie Lite
 */

if ( ! is_active_sidebar( 'sidebar-2' ) ) {
	return;
}
?>

<div class="widget-area-front" role="complementary">
	<?php dynamic_sidebar( 'sidebar-2' ); ?>
</div><!-- #secondary -->