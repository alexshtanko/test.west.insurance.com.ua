<?php
/*********************************************************************/
/**	Name: Add News WP-Recall (Объявление в личном кабинете)			**/
/**	Author Uri: http://wppost.ru/author/ulogin_vkontakte_220251751/	**/
/**	index.php														**/
/*********************************************************************/
 
require_once("includes/settings.php");
require_once("includes/functions.php");

add_action( 'admin_enqueue_scripts', 'add_color_picker' );
function add_color_picker( $hook ) {
	if( is_admin() ) { 
		wp_enqueue_style( 'wp-color-picker' ); 
		wp_enqueue_script( 'custom_addnwpr', rcl_addon_url( 'js/addnwpr.js', __FILE__ ), array( 'wp-color-picker' ), false, true ); 
	}
}