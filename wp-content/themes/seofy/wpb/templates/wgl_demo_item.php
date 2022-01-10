<?php

	$defaults = array(
		// General
		'di_title' => '',
		'di_subtitle' => '',
		'di_image' => '',
		'coming_soon' => false,
		'add_button' => false,
		'di_button_title' => '',
		'di_link' => '',
		'extra_class' => '',
	);
	$atts = vc_shortcode_attribute_parse($defaults, $atts);
	extract($atts);

	$output = $button_attr = $di_wrap_classes = '';

	// Animation
	if (!empty($atts['css_animation'])) {
		$animation_class = $this->getCSSAnimation( $atts['css_animation'] );
	}

	// wrapper classes
	$di_wrap_classes .= (bool)$coming_soon ? ' coming_soon' : '';
	$di_wrap_classes .= !empty($animation_class) ? ' '.$animation_class : '';
	$di_wrap_classes .= !empty($extra_class) ? ' '.$extra_class : '';

	// image src
	$featured_image = wp_get_attachment_image_src($di_image, 'full');

	// module alt
	$img_alt = get_post_meta($di_image, '_wp_attachment_image_alt', true);

	// link button
	$link_temp = vc_build_link($di_link);
	$url = $link_temp['url'];
	$button_title = $link_temp['title'];
	$target = $link_temp['target'];
	$button_attr .= !empty($url) ? 'href="'.esc_url($url).'"' : 'href="#"';
	$button_attr .= !empty($button_title) ? " title='".esc_attr($button_title)."'" : '';
	$button_attr .= !empty($target) ? ' target="'.esc_attr($target).'"' : '';

	// render html
	$output .= '<div class="seofy_module_demo_item'.esc_attr($di_wrap_classes).'">';
		if (!empty($di_image)) {
			$output .= '<div class="di_image-wrap">';
				$output .= '<a class="di_image-link" '.$button_attr.'><img src="'.esc_url($featured_image[0]).'" alt="'.(!empty($img_alt) ? esc_attr($img_alt) : '').'"></a>';
				$output .= (bool)$add_button ? '<div class="di_button seofy_module_button wgl_button wgl_button-xl"><a class="wgl_button_link" '.$button_attr.'>'.esc_html($di_button_title).'</a></div>' : '';
				$output .= (bool)$coming_soon ? '<h5 class="di_label">'.esc_html__( 'Coming Soon', 'seofy' ).'</h5>' : '';
			$output .= '</div>';
		}
		$output .= '<div class="di_title-wrap">';
			$output .= !empty($di_subtitle) ? '<h5 class="di_subtitle">'.esc_html($di_subtitle).'</h5>' : '';
			$output .= !empty($di_title) ? '<a '.$button_attr.'><h5 class="di_title">'.esc_html($di_title).'</h5></a>' : '';
		$output .= '</div>';
	$output .= '</div>';

	echo Seofy_Theme_Helper::render_html($output);

?>