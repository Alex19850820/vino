(function( $ ) {
	/*
	 *
	 * Flytheme_Options_color function
	 * Adds farbtastic to color elements
	 *
	 */
	$(document).ready(function(){
		$( '.ya-popup-colorpicker' ).each( function(){
			$(this).wpColorPicker();
		});		
	});
})( jQuery );