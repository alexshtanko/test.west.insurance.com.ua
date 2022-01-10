<?php

	$theme_color = esc_attr(Seofy_Theme_Helper::get_option("theme-custom-color"));

	$defaults = array(
		// General
		'custom_height' => '',
		'title' => '',
		'subtitle' => '',
		'logo_image' => '',
		'bg_image' => '',
		'link' => '',
		'item_el_class' => '',
		'title_color' => $theme_color,
		'subtitle_color' => '#ffffff',
	);
	$atts = vc_shortcode_attribute_parse($defaults, $atts);
	extract($atts);

	$output = $services_wrap_classes = $animation_class = $services_title = $services_subtitle = $link_attr = $services_logo = $bg_style = '';

	// Animation
	if (!empty($atts['css_animation'])) {
		$animation_class = $this->getCSSAnimation( $atts['css_animation'] );
	}

	// services wrapper classes
	$services_wrap_classes .= $animation_class;
	$services_wrap_classes .= !empty($item_el_class) ? ' '.$item_el_class : '';

	// Image output
	if (!empty($logo_image)) {
		$logo = wp_get_attachment_image_src($logo_image, 'full');
		$logo_url = $logo[0];
		$img_alt = get_post_meta($logo, '_wp_attachment_image_alt', true);
		$services_logo .= '<div class="services_logo"><img src="'.esc_url($logo_url).'" alt="'.(!empty($img_alt) ? $img_alt : '').'"/></div>';
	}
	
	// wrap styles
	if (!empty($bg_image)) {
		$image = wp_get_attachment_image_src($bg_image, 'full');
		$image_url = $image[0];
		$bg_style .= 'background-image: url('.esc_url($image_url).');';
	} 
	if (!empty($custom_height)) {
		$bg_style .= ' min-height: '.(int)$custom_height.'px;';
	} 
	$bg_styles = !empty($bg_style) ? 'style="'.$bg_style.'"' : '';

	// title
	if (!empty($title)) {
		$services_title .= '<h3 class="services_title" '.(!empty($title_color) ? 'style="color:'.esc_attr($title_color).'"' : '').'>'.esc_html($title).'</h3>';
	}

	// subtitle
	if (!empty($subtitle)) {
		$services_subtitle .= '<div class="services_subtitle" '.(!empty($subtitle_color) ? 'style="color:'.esc_attr($subtitle_color).'"' : '').'>'.esc_html($subtitle).'</div><br />';
	}

	// Link Settings
	$link_temp = vc_build_link($link);
	$url = $link_temp['url'];
	$link_title = $link_temp['title'];
	$target = $link_temp['target'];
	$link_attr .= !empty($url) ? 'href="'.esc_url($url).'"' : '';
	$link_attr .= !empty($link_title) ? " title='".esc_attr($link_title)."'" : '';
	$link_attr .= !empty($target) ? ' target="'.esc_attr($target).'"' : '';

	// render html
	$output .= '<div class="seofy_module_services_2'.esc_attr($services_wrap_classes).'">';
		$output .= !empty($url) ? "<a ".$link_attr.">" : '';
			$output .= Seofy_Theme_Helper::hexagon_html();
			$output .= '<div class="services_wrapper" '.$bg_styles.'>';
				$output .= '<div class="services_content">';
					$output .= $services_subtitle;
					$output .= $services_title;
				$output .= '</div>';
				$output .= $services_logo;
			$output .= '</div>';
		$output .= !empty($url) ? '</a>' : '';
	$output .= '</div>';

	echo Seofy_Theme_Helper::render_html($output);

?>