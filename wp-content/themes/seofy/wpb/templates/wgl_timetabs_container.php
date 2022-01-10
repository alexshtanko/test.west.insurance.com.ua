<?php
	$defaults = array(
		// General
		'tab_title' => '',
		'tab_sub_title' => '',
		'tab_id' => '',
	);
	$atts = vc_shortcode_attribute_parse($defaults, $atts);
	extract($atts);
	
	echo '<div class="timetab_container" data-tab-id="tab-'.esc_attr($tab_id).'">'.do_shortcode($content).'</div>';

?>