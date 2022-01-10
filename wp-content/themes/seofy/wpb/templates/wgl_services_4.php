<?php

	$theme_color = esc_attr(Seofy_Theme_Helper::get_option("theme-custom-color"));
	$second_color = esc_attr(Seofy_Theme_Helper::get_option("second-custom-color"));
	$theme_gradient = Seofy_Theme_Helper::get_option("theme-gradient");

	$defaults = array(
		// General
		'title' => '',
		'number' => '',
		'max_width' => '',
		'bg_type' => 'hex',
		'f_radius' => '',
		'add_link' => false,
		'link' => '',
		'item_el_class' => '',
		// Icon
		'icon_type' => 'none',
		'icon_font_type' => 'type_flaticon',
		'icon_fontawesome' => 'fa fa-adjust',
		'icon_flaticon' => '',
		'custom_icon_size' => '',
		'thumbnail' => '',
		'custom_image_width' => '',
		// Styles
		'custom_title_color' => false,
		'title_color' => '#252525',
		'custom_icon_color' => false,
		'icon_color' => $theme_color,
		'icon_hover_color' => $theme_color,
		'custom_number_color' => false,
		'number_color' => '#f4f6fd',
		'number_hover_color' => $theme_color,
		'custom_bg_color' => false,
		'bg_color' => '#ffffff',
		'bg_hover_color' => '#f4f6fd',
	);
	$atts = vc_shortcode_attribute_parse($defaults, $atts);
	extract($atts);

	$output = $services_wrap_classes = $animation_class = $icon_type_html = $button_attr = $services_title = $services_descr = $services_id_attr = $services_figure = '';

	if ((bool)$custom_icon_color || (bool)$custom_number_color || (bool)$custom_bg_color) {
		$services_id = uniqid( "seofy_services_" );
		$services_id_attr = 'id='.$services_id;
	}

	// Custom services styles
	ob_start();
	if ((bool)$custom_icon_color) {
		echo "#$services_id .services_icon{
			color: ".(!empty($icon_color) ? esc_attr($icon_color) : 'transparent').";
		}";
		echo "#$services_id:hover .services_icon{
			color: ".(!empty($icon_hover_color) ? esc_attr($icon_hover_color) : 'transparent').";
		}";
	}
	if ((bool)$custom_number_color) {
		echo "#$services_id .services_number{
			color: ".(!empty($number_color) ? esc_attr($number_color) : 'transparent').";
		}";
		echo "#$services_id:hover .services_number{
			color: ".(!empty($number_hover_color) ? esc_attr($number_hover_color) : 'transparent').";
		}";
	}
	if ((bool)$custom_bg_color) {
		if ($bg_type == 'hex') {
			echo "#$services_id .seofy_hexagon svg{
				fill: ".(!empty($bg_color) ? esc_attr($bg_color).' !important' : 'transparent').";
			}";
			echo "#$services_id:hover .seofy_hexagon svg{
				fill: ".(!empty($bg_hover_color) ? esc_attr($bg_hover_color).' !important' : 'transparent').";
			}";
		} else if ($bg_type == 'figure'){
			echo "#$services_id .services_figure{
				background: ".(!empty($bg_color) ? esc_attr($bg_color) : 'transparent').";
			}";
			echo "#$services_id:hover .services_figure{
				background: ".(!empty($bg_hover_color) ? esc_attr($bg_hover_color) : 'transparent').";
			}";
		}
	}
	$styles = ob_get_clean();
	Seofy_shortcode_css()->enqueue_seofy_css($styles);

	// Animation
	if (!empty($atts['css_animation'])) {
		$animation_class = $this->getCSSAnimation( $atts['css_animation'] );
	}

	// services wrapper classes
	$services_wrap_classes .= ' '.$bg_type.'-type';
	$services_wrap_classes .= $animation_class;
	$services_wrap_classes .= !empty($item_el_class) ? ' '.$item_el_class : '';

	// link
	$link_temp = vc_build_link($link);
	$url = $link_temp['url'];
	$button_title = $link_temp['title'];
	$target = $link_temp['target'];
	$button_attr .= !empty($url) ? 'href="'.esc_url($url).'"' : 'href="#"';
	$button_attr .= !empty($button_title) ? " title='".esc_attr($button_title)."'" : '';
	$button_attr .= !empty($target) ? ' target="'.esc_attr($target).'"' : '';

	// Icon/Image output
	if ($icon_type != 'none') {
		if ($icon_type == 'font' && (!empty($icon_fontawesome) || !empty($icon_flaticon))) {
			if ($icon_font_type == 'type_fontawesome') {
				wp_enqueue_style('font-awesome', get_template_directory_uri() . '/css/font-awesome.min.css');
				$icon_font = $icon_fontawesome;
			} else if($icon_font_type == 'type_flaticon'){
				wp_enqueue_style('flaticon', get_template_directory_uri() . '/fonts/flaticon/flaticon.css');
				$icon_font = $icon_flaticon;
			}
			$icon_size = ($custom_icon_size != '') ? ' style="font-size:'.esc_attr((int)$custom_icon_size).'px;"' : '';
			$icon_type_html .= '<i class="services_icon '.esc_attr($icon_font).'" '.$icon_size.'></i>';
		} else if ($icon_type == 'image' && !empty($thumbnail)) {
			$featured_image = wp_get_attachment_image_src($thumbnail, 'full');
			$featured_image_url = $featured_image[0];
			$image_width_crop = ($custom_image_width != '') ? $custom_image_width*2 : '';
			$iconbox_image_src = ($custom_image_width != '') ? (aq_resize($featured_image_url, $image_width_crop, $image_width_crop, true, true, true)) : $featured_image_url;
			$image_width = ($custom_image_width != '') ? 'width:'.(int)$custom_image_width.'px; ' : '';
			$iconbox_img_width_style = (!empty($image_width))  ? ' style="'.esc_attr($image_width).'"' : '';
			$img_alt = get_post_meta($thumbnail, '_wp_attachment_image_alt', true);
			$icon_type_html .= '<div class="services_icon"><img src="'.esc_url($iconbox_image_src).'" alt="'.(!empty($img_alt) ? esc_attr($img_alt) : '').'" '.$iconbox_img_width_style.' /></div>';
		}
	}

	// title
	if (!empty($title)) {
		$services_title .= '<h3 class="services_title" '.((bool)$custom_title_color ? 'style="color:'.esc_attr($title_color).'"' : '').'>'.esc_html($title).'</h3>';
	}

	// content
	if (!empty($descr)) {
		$services_descr .= '<div class="services_content" '.((bool)$custom_content_color ? 'style="color:'.esc_attr($content_color).'"' : '').'>'.esc_html($descr).'</div>';
	}

	// services figure
	if ($bg_type == 'figure') {
		$figure_style = ($f_radius == '0' || $f_radius != '') ? 'style="border-radius: '.esc_attr((int)$f_radius).'px;"' : '';
		$services_figure = '<div class="services_figure" '.$figure_style.'></div>';
	}

	// render html
	$output .= '<div '.esc_attr($services_id_attr).' class="seofy_module_services_4'.esc_attr($services_wrap_classes).'" '.($max_width != '' ? 'style="max-width: '.esc_attr((int)$max_width).'px;"' : '').'>';
		$output .= (bool)$add_link ? '<a class="services_link" '.$button_attr.'>' : '';
		$output .= '<div class="services_wrapper">';
			$output .= '<div class="services_bg">';
				$output .= ($bg_type == 'hex') ? Seofy_Theme_Helper::hexagon_html('#ffffff', false) : $services_figure;
			$output .= '</div>';
			$output .= '<div class="services_number">'.esc_html($number).'</div>';
			$output .= '<div class="services_content">';
				$output .= '<div class="services_icon_wrapper">';
					$output .= $icon_type_html;
				$output .= '</div>';
				$output .= $services_title;
			$output .= '</div>';
		$output .= '</div>';
		$output .= (bool)$add_link ? '</a>' : '';
	$output .= '</div>';
	
	echo Seofy_Theme_Helper::render_html($output);

?>