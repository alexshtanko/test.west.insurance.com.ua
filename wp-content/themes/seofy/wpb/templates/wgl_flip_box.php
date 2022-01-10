<?php

	$theme_color = esc_attr(Seofy_Theme_Helper::get_option("theme-custom-color"));

	$defaults = array(
		// General
		'fb_dir' => 'flip_right',
		'fb_height' => '',
		'extra_class' => '',
		// Front Side
		'front_bg_style' => 'front_color',
		'front_bg_color' => '#ffffff',
		'front_bg_image' => '',
		'front_logo_image' => '',
		'front_title' => '',
		'front_title_color' => '#ffffff',
		'front_descr' => '',
		'front_descr_color' => '#ffffff',
		// Back Side
		'back_bg_style' => 'back_color',
		'back_bg_color' => $theme_color,
		'back_bg_image' => '',
		'add_back_logo_image' => false,
		'back_logo_image' => '',
		'back_title' => '',
		'back_title_color' => '#ffffff',
		'back_descr' => '',
		'back_descr_color' => '#ffffff',
		'add_read_more' => false,
		'back_button_color' => '#ffffff',
		'read_more_text' => 'Read More',
		'link' => '',
		'add_icon_button' => false,
		'button_icon_fontawesome' => 'fa fa-adjust',
		'button_icon_position' => 'left',
	);
	$atts = vc_shortcode_attribute_parse($defaults, $atts);
	extract($atts);

	if ((bool)$add_read_more) {
        // carousel options array
        $button_options_arr = array(
            'button_text' => $read_more_text,
            'link' => $link,
            'icon_type' => (bool)$add_icon_button ? 'font' : '',
            'icon_fontawesome' => $button_icon_fontawesome,
            'icon_position' => $button_icon_position,
            'customize' => 'color',
            'text_color' => $back_button_color,
            'border_color' => $back_button_color,
            'bg_color' => 'transparent',
            'custom_icon_color' => true,
            'icon_color' => $back_button_color,
        );

        // carousel options
        $button_options = array_map(function($k, $v) { return "$k=\"$v\" "; }, array_keys($button_options_arr), $button_options_arr);
        $button_options = implode('', $button_options);
    }

	$output = $flipbox_wrap_classes = $flipbox_inner = $button_attr = $animation_class = $flipbox_front = $flipbox_back = $front_styles = $back_styles = $flipbox_styles = '';

	// Animation
	if (!empty($atts['css_animation'])) {
		$animation_class = $this->getCSSAnimation( $atts['css_animation'] );
	}

	// Flipbox wrapper classes
	$flipbox_wrap_classes .= ' type_'.$fb_dir;
	$flipbox_wrap_classes .= $animation_class;
	$flipbox_wrap_classes .= !empty($extra_class) ? ' '.$extra_class : '';

	// Front Side styles
	if ($front_bg_style == 'front_color') {
		$front_styles .= 'style="background:'.esc_attr($front_bg_color).';"';
	} else if ($front_bg_style == 'front_image') {
		$front_image = wp_get_attachment_image_src($front_bg_image, 'full');
		$front_image_url = $front_image[0];
		$front_styles .= 'style="background-image: url('.esc_url($front_image_url).');"';
	}

	// Frontside logo image
	$flipbox_front_logo = wp_get_attachment_image_src($front_logo_image, 'full');
	$front_logo_img_alt = get_post_meta($front_logo_image, '_wp_attachment_image_alt', true);
	$front_logo_url = $flipbox_front_logo[0];

	// Front Side
	$flipbox_front .= '<div class="flipbox_front" '.$front_styles.'>';
		$flipbox_front .= !empty($front_logo_url) ? '<img class="flipbox_logo" src="'.(esc_url($front_logo_url)).'" alt="'.(!empty($front_logo_img_alt) ? esc_attr($front_logo_img_alt) : 'front-logo').'" />' : '';
		$flipbox_front .= !empty($front_title) ? '<h5 class="flipbox_title" '.(!empty($front_title_color) ? 'style="color:'.esc_attr($front_title_color).';"' : '').'>'.(esc_html($front_title)).'</h5>' : '';
		$flipbox_front .= !empty($front_descr) ? '<div class="flipbox_descr" '.(!empty($front_descr_color) ? 'style="color:'.esc_attr($front_descr_color).';"' : '').'>'.(esc_html($front_descr)).'</div>' : '';
	$flipbox_front .= '</div>';

	// Read more button
	$link_temp = vc_build_link($link);
	$url = $link_temp['url'];
	$button_title = $link_temp['title'];
	$target = $link_temp['target'];
	$button_attr .= !empty($url) ? 'href="'.esc_url($url).'"' : 'href="#"';
	$button_attr .= !empty($button_title) ? " title='".esc_attr($button_title)."'" : '';
	$button_attr .= !empty($target) ? ' target="'.esc_attr($target).'"' : '';

	// Back Side styles
	if ($back_bg_style == 'back_color') {
		$back_styles .= 'style="background:'.esc_attr($back_bg_color).';"';
	} else if ($back_bg_style == 'back_image') {
		$back_image = wp_get_attachment_image_src($back_bg_image, 'full');
		$back_image_url = $back_image[0];
		$back_styles .= 'style="background-image: url('.esc_url($back_image_url).');"';
	}

	// Back side logo image
	$flipbox_back_logo = wp_get_attachment_image_src($back_logo_image, 'full');
	$back_logo_img_alt = get_post_meta($back_logo_image, '_wp_attachment_image_alt', true);
	$back_logo_url     = $flipbox_back_logo[0];

	// Back Side
	$flipbox_back .= '<div class="flipbox_back" '.$back_styles.'><div class="flipbox_back_content">';
		$flipbox_back .= !empty($back_logo_url) ? '<div class="flipbox_logo"><img src="'.esc_url($back_logo_url).'" alt="'.(!empty($back_logo_img_alt) ? esc_attr($back_logo_img_alt) : 'back-logo').'"></div>' : '';
		$flipbox_back .= !empty($back_title) ? '<h4 class="flipbox_title" '.(!empty($back_title_color) ? 'style="color:'.esc_attr($back_title_color).';"' : '').'>'.(esc_html($back_title)).'</h4>' : '';
		$flipbox_back .= !empty($back_descr) ? '<div class="flipbox_content" '.(!empty($back_descr_color) ? 'style="color:'.esc_attr($back_descr_color).';"' : '').'>'.(esc_html($back_descr)).'</div>' : '';
		$flipbox_back .= $add_read_more ? do_shortcode('[wgl_button '.$button_options.'][/wgl_button]') : '';
	$flipbox_back .= '</div></div>';

	// Flipbox Wrapper Styles
	$flipbox_height = ($fb_height != '') ? 'min-height: '.$fb_height.'px; ' : '';
	$flipbox_styles .= !empty($flipbox_height) ? 'style="'.$flipbox_height.'"' : '';

	// Render html
	$output .= '<div class="seofy_module_flipbox'.esc_attr($flipbox_wrap_classes).'">';
		$output .= '<div class="flipbox_wrapper" '.$flipbox_styles.'>';
			$output .= $flipbox_front;
			$output .= $flipbox_back;
		$output .= '</div>';
	$output .= '</div>';

	echo Seofy_Theme_Helper::render_html($output);

?>  
