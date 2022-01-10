<?php

	$theme_color = esc_attr(Seofy_Theme_Helper::get_option("theme-custom-color"));

	$defaults = array(
		// General
		'service_anim' => 'fade',
		'anim_dir' => 'to_right',
		'service_align' => 'left',
		'item_el_class' => '',
		// Front Side
		'front_bg_style' => 'front_frame',
		'front_frame_color' => 'rgba(255,255,255,0.3)',
		'front_bg_color' => '#ffffff',
		'front_bg_image' => '',
		'front_icon_type' => 'none',
		'front_icon_font_type' => 'type_fontawesome',
		'icon_fontawesome' => 'fa fa-adjust',
		'icon_flaticon' => '',
		'front_icon_thumbnail' => '',
		'custom_image_width' => '',
		'custom_image_height' => '',
		'custom_icon_size' => '',
		'front_icon_color' => '#ffffff',
		'front_title' => '',
		'front_title_color' => '#ffffff',
		'front_descr' => '',
		'front_descr_color' => '#bebebe',
		// Back Side
		'back_bg_style' => 'back_color',
		'back_bg_color' => $theme_color,
		'back_bg_image' => '',
		'add_read_more' => false,
		'read_more_text' => 'Read More',
		'link' => '',
		'button_customize' => 'def',
		'button_text_color' => '#ffffff',
		'button_text_color_hover' => $theme_color,
		'button_bg_color' => $theme_color,
		'button_bg_color_hover' => '#ffffff',
		'button_border_color' => $theme_color,
		'button_border_color_hover' => '#ffffff',
	);
	$atts = vc_shortcode_attribute_parse($defaults, $atts);
	extract($atts);

	if ((bool)$add_read_more) {
        // button options array
        $button_options_arr = array(
            'button_text' => $read_more_text,
            'link' => $link,
            'customize' => 'color',
            'size' => 'xl',
            'text_color' => $button_text_color,
            'text_color_hover' => $button_text_color_hover,
            'bg_color' => $button_bg_color,
            'bg_color_hover' => $button_bg_color_hover,
            'border_color' => $button_border_color,
            'border_color_hover' => $button_border_color_hover,
            'bottom_mar' => '0',
        );

        // button options
        $button_options = array_map(function($k, $v) { return "$k=\"$v\" "; }, array_keys($button_options_arr), $button_options_arr);
        $button_options = implode('', $button_options);
    }

	$output = $services_wrap_classes = $services_inner = $front_icon_type_html = $services_icon = $animation_class = $services_front = $services_back = $front_styles = $back_styles = $services_styles = '';

	// Animation
	if (!empty($atts['css_animation'])) {
		$animation_class = $this->getCSSAnimation( $atts['css_animation'] );
	}

	// services wrapper classes
	$services_wrap_classes .= ' service_'.$service_anim;
	$services_wrap_classes .= ' a'.$service_align;
	$services_wrap_classes .= $service_anim != 'fade' ? ' anim_dir_'.$anim_dir : '';
	$services_wrap_classes .= ' bg_'.$front_bg_style;
	$services_wrap_classes .= $animation_class;
	$services_wrap_classes .= !empty($item_el_class) ? ' '.$item_el_class : '';

	// Front Side styles
	switch ($front_bg_style) {
		case 'front_frame':
			$front_styles .= 'style="border-color:'.esc_attr($front_frame_color).';"';
			break;
		case 'front_color':
			$front_styles .= 'style="background:'.esc_attr($front_bg_color).'; border-color:'.esc_attr($front_frame_color).';"';
			break;
		case 'front_image':
			$front_image = wp_get_attachment_image_src($front_bg_image, 'full');
			$front_image_url = $front_image[0];
			$front_styles .= 'style="background-image: url('.esc_url($front_image_url).');"';
			break;
		default:
			$front_styles .= 'style="border-color:'.esc_attr($front_frame_color).';"';
			break;
	}

	// Front side icon
	// Icon/Image output
	if ($front_icon_type != 'none') {
		if ($front_icon_type == 'font' && (!empty($icon_fontawesome) || !empty($icon_flaticon))) {
			if ($front_icon_font_type == 'type_fontawesome') {
				wp_enqueue_style('font-awesome', get_template_directory_uri() . '/css/font-awesome.min.css');
				$icon_font = $icon_fontawesome;
			} else if($front_icon_font_type == 'type_flaticon'){
				wp_enqueue_style('flaticon', get_template_directory_uri() . '/fonts/flaticon/flaticon.css');
				$icon_font = $icon_flaticon;
			}
			$icon_size = ($custom_icon_size != '') ? ' font-size:'.esc_attr((int)$custom_icon_size).'px;' : '';
			$icon_color = !empty($front_icon_color) ? ' color:'.esc_attr($front_icon_color).';': '';
			$icon_style = (!empty($icon_size) || !empty($icon_color)) ? 'style="'.$icon_size.$icon_color.'"' : '';
			$front_icon_type_html .= '<i class="services_icon '.esc_attr($icon_font).'" '.$icon_style.'></i>';
		} else if ($front_icon_type == 'image' && !empty($front_icon_thumbnail)) {
			$featured_image = wp_get_attachment_image_src($front_icon_thumbnail, 'full');
			$featured_image_url = $featured_image[0];
			$image_width_crop = ($custom_image_width != '') ? $custom_image_width*2 : '';
			$image_height_crop = ($custom_image_height != '') ? $custom_image_height*2 : '';
			$services_image_src = ($custom_image_width != '' || $custom_image_height != '') ? (aq_resize($featured_image_url, $image_width_crop, $image_height_crop, true, true, true)) : $featured_image_url;
			$image_width = ($custom_image_width != '') ? 'width:'.esc_attr((int)$custom_image_width).'px; ' : '';
			$image_height = ($custom_image_height != '') ? 'height:'.esc_attr((int)$custom_image_height).'px;' : '';
			$services_img_width_style = (!empty($image_width) || !empty($image_height)) ? ' style="'.$image_width.$image_height.'"' : '';
			$img_alt = get_post_meta($front_icon_thumbnail, '_wp_attachment_image_alt', true);
			$front_icon_type_html .= '<div class="services_icon" '.(($custom_image_height != '') ? ' style="height:'.esc_attr((int)$custom_image_height).'px;"' : '').'><img src="'.esc_url($services_image_src).'" alt="'.(!empty($img_alt) ? $img_alt : '').'" '.$services_img_width_style.' /></div>';
		}

		$services_icon .= '<div class="services_icon_wrapper">'.$front_icon_type_html.'</div>';
	}

	// Front Side
	$services_front .= '<div class="services_front" '.$front_styles.'>';
		$services_front .= $services_icon;
		$services_front .= !empty($front_title) ? '<h5 class="services_title" '.(!empty($front_title_color) ? 'style="color:'.esc_attr($front_title_color).';"' : '').'>'.(esc_html($front_title)).'</h5>' : '';
		$services_front .= !empty($front_descr) ? '<div class="services_descr" '.(!empty($front_descr_color) ? 'style="color:'.esc_attr($front_descr_color).';"' : '').'>'.(esc_html($front_descr)).'</div>' : '';
	$services_front .= '</div>';

	// Back Side styles
	if ($back_bg_style == 'back_color') {
		$back_styles .= 'style="background:'.esc_attr($back_bg_color).';"';
	} else if ($back_bg_style == 'back_image') {
		$back_image = wp_get_attachment_image_src($back_bg_image, 'full');
		$back_image_url = $back_image[0];
		$back_styles .= 'style="background-image: url('.esc_url($back_image_url).');"';
	}

	// Back Side
	$services_back .= '<div class="services_back" '.$back_styles.'></div>';

	// Back Side Button
	$services_button = $add_read_more ? '<div class="services_button">'.do_shortcode('[wgl_button '.$button_options.'][/wgl_button]').'</div>' : '';

	// render html
	$output .= '<div class="seofy_module_services'.esc_attr($services_wrap_classes).'">';
		$output .= '<div class="services_wrapper">';
		$output .= $services_front;
		$output .= $services_back;
		$output .= $services_button;
		$output .= '</div>';
	$output .= '</div>';

	echo sprintf("%s", $output);

?>