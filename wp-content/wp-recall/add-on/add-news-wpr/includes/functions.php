<?php
/*********************************************************************/
/**	Name: Add News WP-Recall (Объявление в личном кабинете)			**/
/**	Author Uri: http://wppost.ru/author/ulogin_vkontakte_220251751/	**/
/**	includes/functions.php											**/
/*********************************************************************/

rcl_block('before','addnwpr');

function addnwpr (){
	global $rcl_options;
		if($rcl_options['on_off_addnwpr']!=on_addnwpr) return $addnwpr;
		
		$addnwpr .= '<style>.close_button {float: right;color: #DD3333 !important;width: 20px;height: 20px;font-weight: bold !important;  margin-right: -14px;margin-top: -4px;}.close_button:hover {cursor: pointer;}.addnwpr {position: relative;background-color: ' . $rcl_options['color_backgraund_addnwpr'] . ' ;border: ' . $rcl_options['border_addnwpr'] . 'px solid;border-color: #DD3333;border-color: ' . $rcl_options['color_border_addnwpr'] . ' ;border-radius: 2px;margin: 10px 0;padding: 0px 10px 7px;text-align: center;}h3#title-addnwpr {color: ' . $rcl_options['color_title_addnwpr'] . ' ;}p#text-addnwpr {color: ' . $rcl_options['color_text_addnwpr'] . ' ;}</style>
			
		<div class="window-addnwpr addnwpr" id="window">
		<p type="button" class="close_button" title="Закрыть"onclick="closeWindow();">X</p>
		<h3 id="title-addnwpr"> ' . $rcl_options['title_addnwpr'] . ' </h3>
		<p id="text-addnwpr"> ' . $rcl_options['text_addnwpr'] . ' </p></div>
		<script type="text/javascript">init();</script>';
			
	require_once("display-scripts.php");
			
		return $addnwpr;
}