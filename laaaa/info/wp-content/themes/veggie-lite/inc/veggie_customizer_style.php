<?php
//////////////////////////////////////////////////////////////////
// Customizer - Add CSS
//////////////////////////////////////////////////////////////////
function veggie_customizer_css() {
	?>
	<style type="text/css">
		
		<?php if(get_theme_mod( 'veggie_custom_css' )) : ?>
		<?php echo wp_kses( get_theme_mod( 'veggie_custom_css' ), '' ); ?>
		<?php endif; ?>

	</style>
	<?php
}
add_action( 'wp_head', 'veggie_customizer_css' );
?>