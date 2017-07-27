/**
 * Theme Customizer enhancements, specific to controls, for a better user experience.
 */

( function( $ ) {

	wp.customize.bind( 'ready', function() {

		var select = $( "li[id^='customize-control-ansel_panel_'] select" );

		select.each( function() {

			// Move all the Category options inside a dedicated optgroup.
			categoryOptions = $( this ).find( "option[value^='category_']" );

			if ( ! $.isEmptyObject( categoryOptions ) ) {
				$( this ).prepend( '<optgroup id="categories" label="Categories"></optgroup>' );
				$( this ).find( "option[value^='category_']" ).remove();
				$( this ).find( "optgroup[id='categories']" ).append( categoryOptions );
			}

			// Move all the Portfolio Type options inside a dedicated optgroup.
			portfolioTypeOptions = $( this ).find( "option[value^='portfolio_type_']" );

			if ( ! $.isEmptyObject( portfolioTypeOptions ) ) {
				$( this ).prepend( '<optgroup id="portfolio-types" label="Portfolio Types"></optgroup>' );
				$( this ).find( "option[value^='portfolio_type_']" ).remove();
				$( this ).find( "optgroup[id='portfolio-types']" ).append( portfolioTypeOptions );
			}

			// Move all the Page options inside a dedicated optgroup.
			pageOptions = $( this ).find( "option[value^='page_']" );

			if ( ! $.isEmptyObject( pageOptions ) ) {
				$( this ).prepend( '<optgroup id="pages" label="Pages"></optgroup>' );
				$( this ).find( "option[value^='page_']" ).remove();
				$( this ).find( "optgroup[id='pages']" ).append( pageOptions );
			}

		});

		select.prepend( "<option value='#'>— Select —</option>" );

	} );

} )( jQuery );