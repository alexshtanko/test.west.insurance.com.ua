//************************************************************************//
//**	Name: Add News WP-Recall FULL (Объявление в личном кабинете)	**//
//**	Author Uri: http://wppost.ru/author/ulogin_vkontakte_220251751/	**//
//**	js/addnwpr.js													**//
//************************************************************************//

(function( $ ) {
    $(function() {

		$( 'input[name="global[color_border_addnwpr]"]' ).wpColorPicker({
		defaultColor: '#DD3333'
	});
		$( 'input[name="global[color_backgraund_addnwpr]"]' ).wpColorPicker();
		$( 'input[name="global[color_title_addnwpr]"]' ).wpColorPicker();
		$( 'input[name="global[color_text_addnwpr]"]' ).wpColorPicker();
          
    });
})( jQuery );