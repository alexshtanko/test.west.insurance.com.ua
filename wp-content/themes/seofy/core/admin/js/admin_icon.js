"use strict";
( function( $ ) {

    $( document ).on( 'ready ', function() {
    	
    	//Call colorpicker option
    	$( '.colorpicker' ).wpColorPicker();

		$( 'body' ).on( 'mousedown', '.wgl-iconpicker', function(e) { // Use mousedown even to allow for triggering click later without infinite looping.

			e.preventDefault();

	    	$( this ).not( ' .initialized' )
	    		.addClass( 'initialized' ) 
	    		.iconpicker({
		    		placement: 'bottomLeft',
		    		hideOnSelect: true,
		    		animation: false,
		    		selectedCustomClass: 'selected',
		    		icons: seofy_vars.fa_icons,
		    		fullClassFormatter: function( val ) {
		    			if ( seofy_vars.fa_prefix ) {
		    				return seofy_vars.fa_prefix + ' ' + seofy_vars.fa_prefix + '-' + val;
		    			} else {
		    				return val;
		    			}
		    		},
		    	});

		    $( this ).trigger( 'click' );

		})
		.on( 'click', '.wgl-iconpicker', function(e) {
			$( this ).find( '.iconpicker-search' ).focus();
		});

		// Set up icon insertion functionality.
		$( document ).on( 'iconpickerSelect', function( e ) {
    		wp.media.editor.insert( icon_shortcode( e.iconpickerItem.context.title.replace( '.', '' ) ) );
    	});

    });

    function icon_shortcode( icon ) {
        return '[wgl_icon name="' + icon + '" class="" unprefixed_class=""]';
    }

} )( jQuery );
