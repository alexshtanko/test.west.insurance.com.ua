<?php

function seofy_heading_line ($settings, $value) {
    $param_name = isset($settings['param_name']) ? $settings['param_name'] : '';
	$class = isset($settings['class']) ? $settings['class'] : '';
	$text = isset($settings['text']) ? $settings['text'] : '';
	$type = "";
	$output = '<h4 class="wpb_vc_param_value '.esc_attr($class).'">'.esc_html($text).'</h4>';

	$output .= '<input type="hidden"  class="wpb_vc_param_value ' . esc_attr($param_name . ' ' . $type . ' ' . $class) . '" name="' . esc_attr($param_name) . '" value="'.esc_attr($value).'" />';
	return $output;
}