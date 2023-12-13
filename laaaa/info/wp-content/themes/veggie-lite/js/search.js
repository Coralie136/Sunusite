/**
 * Theme functions file.
 *
 * Contains handlers for search.
 */

( function( $ ) {
	"use strict";
	// Search toggle.
		$( '.search-toggle' ).on( 'click.veggie', function( event ) {
			var that    = $( this ),
				wrapper = $( '#search-container' ),
				container = that.find( 'a' );

			that.toggleClass( 'active' );
			wrapper.toggleClass( 'hide' );

			if ( that.hasClass( 'active' ) ) {
				container.attr( 'aria-expanded', 'true' );
			} else {
				container.attr( 'aria-expanded', 'false' );
			}

			if ( that.is( '.active' ) || $( '.search-toggle .screen-reader-text' )[0] === event.target ) {
				wrapper.find( '.search-field' ).focus();
			}
		} );
} )( jQuery );