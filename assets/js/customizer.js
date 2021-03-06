/**
 * File customizer.js.
 *
 * Theme Customizer enhancements for a better user experience.
 *
 * Contains handlers to make Theme Customizer preview reload changes asynchronously.
 */

( function( $ ) {

	// Site title and description.
	wp.customize( 'blogname', function( value ) {
		value.bind( function( to ) {
			$( '.site-title a' ).text( to );
		} );
	} );
	wp.customize( 'blogdescription', function( value ) {
		value.bind( function( to ) {
			$( '.site-description' ).text( to );
		} );
	} );

	// Header text color.
	wp.customize( 'header_textcolor', function( value ) {
		value.bind( function( to ) {
			if ( 'blank' === to ) {
				$( '.site-branding' ).css( {
					'clip': 'rect(1px, 1px, 1px, 1px)',
					'height': '1px',
					'overflow': 'hidden',
					'overflow-wrap': 'normal',
					'position': 'absolute',
					'width': '1px'

				} );
			} else {
				$( '.site-branding' ).css( {
					'clip': 'auto',
					'height': 'inherit',
					'overflow': 'inherit',
					'overflow-wrap': 'inherit',
					'position': 'relative',
					'width': 'inherit'
				} );
				$( '.site-title a' ).css( {
					'color': to
				} );
			}
		} );
	} );
} )( jQuery );
