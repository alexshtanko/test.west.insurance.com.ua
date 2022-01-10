<?php
	
	$theme_color_secondary = esc_attr(Seofy_Theme_Helper::get_option("theme-secondary-color"));
	$header_font_color = esc_attr(Seofy_Theme_Helper::get_option('header-font')['color']);
	
	$defaults = array(
		// General
		'time' => esc_html__('12.00 am - 14.00 pm', 'seofy'),
		'title' => esc_html__('Event Title', 'seofy'),
		'thumbnail' => '',
		'description' => '',
		// Styles
		'time_custom_color' => false,
		'time_color' => '#ffffff',
		'title_custom_color' => false,
		'title_color' => '#ffffff',
		'description_custom_color' => false,
		'description_color' => '#dadada',
		'bg_custom_color' => false,
		'bg_color' => '',
		'bg_color_hover' => '#131120',
		// Button
		'button_link' => '',
		'button_size' => 'm',
		'button_customize' => 'color',
		'button_text' => esc_html__('Read more', 'seofy'),
		'button_text_color' => $header_font_color,
		'button_text_color_hover' => '#ffffff',
		'button_bg_color' => '#ffffff',
		'button_bg_color_hover' => $theme_color_secondary,
		'button_border_color' => $theme_color_secondary,
		'button_border_color_hover' => $theme_color_secondary,
		'button_shadow_style' => 'on_hover',
	);
	$atts = vc_shortcode_attribute_parse($defaults, $atts); 
	extract($atts);

	$output = $timetabs_item_id = $img_alt = '';

	if ((bool)$bg_custom_color || (bool)$title_custom_color || (bool)$description_custom_color || (bool)$bg_custom_color) {
		$timetabs_item_id = uniqid( "timetabs_item_" );
	}

	ob_start();
	if ((bool)$bg_custom_color) {
		echo "#$timetabs_item_id {background-color:".(!empty($bg_color) ? esc_attr($bg_color) : 'transparent').";}";
		echo "#$timetabs_item_id:hover {background-color:".(!empty($bg_color_hover) ? esc_attr($bg_color_hover) : 'transparent').";}";
	}
	if ((bool)$time_custom_color) {
		echo "#$timetabs_item_id .item_time {color:".(!empty($time_color) ? esc_attr($time_color) : 'transparent').";}";
	}
	if ((bool)$title_custom_color) {
		echo "#$timetabs_item_id .item_title {color:".(!empty($title_color) ? esc_attr($title_color) : 'transparent').";}";
	}
	if ((bool)$description_custom_color) {
		echo "#$timetabs_item_id .item_description {color:".(!empty($description_color) ? esc_attr($description_color) : 'transparent').";}";
	}
	$styles = ob_get_clean();
	Seofy_shortcode_css()->enqueue_seofy_css($styles);

	if (!empty($button_text)) {
		// carousel options array
		$button_options_arr = array(
			'button_text' => $button_text,
			'link' => $button_link,
			'size' => $button_size,
			'customize' => $button_customize,
			'text_color' => $button_text_color,
			'text_color_hover' => $button_text_color_hover,
			'bg_color' => $button_bg_color,
			'bg_color_hover' => $button_bg_color_hover,
			'border_color' => $button_border_color,
			'border_color_hover' => $button_border_color_hover,
			'shadow_style' => $button_shadow_style,
		);
		// carousel options
		$button_options = array_map(function($k, $v) { return "$k=\"$v\" "; }, array_keys($button_options_arr), $button_options_arr);
		$button_options = implode('', $button_options);
	}
	
	if (!empty($thumbnail)) {
		$featured_image = wp_get_attachment_image_src($thumbnail, 'full');
		$featured_image_url = $featured_image[0];
		$featured_image_src = aq_resize($featured_image_url, 268, 268, true, true, true);
		$img_alt = get_post_meta($thumbnail, '_wp_attachment_image_alt', true);
	}

	// Render
	$uniq_id = !empty($timetabs_item_id) ? ' id="'.$timetabs_item_id.'"' : '';
	$time_render = !empty($time) ? '<div class="item_time">'.esc_html($time).'</div>' : '';
	$image_render = !empty($featured_image_src) ? '<div class="item_img"><img src="'.esc_attr($featured_image_src).'" alt="'.(!empty($img_alt) ? esc_attr($img_alt) : '').'" width="134" height="134"></div>' : '';
	$title_render = !empty($title) ? '<div class="item_title">'.esc_html($title).'</div>' : '';
	$description_render = !empty($description) ? '<div class="item_description">'.esc_html($description).'</div>' : '';
	$button_render = !empty($button_text) ? do_shortcode('[wgl_button '.$button_options.'][/wgl_button]') : '';

	$output .= '<div class="timetabs_item"'.$uniq_id.'>';
		$output .= $time_render;
		$output .= $image_render;
		$output .= '<div class="content-wrapper">';
			$output .= $title_render;
			$output .= $description_render;
		$output .= '</div>';
		$output .= $button_render;
	$output .= '</div>';
	
	echo Seofy_Theme_Helper::render_html($output);
	
?>