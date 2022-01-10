<?php
	$theme_color = esc_attr(Seofy_Theme_Helper::get_option("theme-custom-color"));
	$header_font_color = esc_attr(Seofy_Theme_Helper::get_option('header-font')['color']);
	$main_font_color = esc_attr(Seofy_Theme_Helper::get_option('main-font')['color']);
	$theme_gradient_start = esc_attr(Seofy_Theme_Helper::get_option('theme-gradient')['from']);
	$theme_gradient_end = esc_attr(Seofy_Theme_Helper::get_option('theme-gradient')['to']);

	$defaults = array(
		// General
		'pricing_title' => '',
		'pricing_cur' => '',
		'pricing_price' => '',
		'pricing_desc' => '',
		'extra_class' => '',
		// Icon Section
		'icon_type' => 'none',
		'icon_font_type' => 'type_fontawesome',
		'icon_fontawesome' => 'fa fa-adjust',
		'icon_flaticon' => '',
		'custom_icon_size' => '',
		'custom_icon_color' => false,
		'icon_color' => '#ffffff',
		'thumbnail' => '',
		'custom_image_width' => '',
		'custom_image_height' => '',
		// Button
		'descr_text' => '',
		'button_title' => esc_html__('BUY NOW', 'seofy'),
		'link' => '',
		'button_customize' => 'def',
		'button_text_color' => '#ffffff',
		'button_text_color_hover' => $header_font_color,
		'button_bg_color' => '#ffffff',
		'button_bg_color_hover' => $theme_color,
		'button_bg_gradient_start' => $theme_gradient_start,
		'button_bg_gradient_end' => $theme_gradient_end,
		'button_bg_gradient_start_hover' => $theme_gradient_end,
		'button_bg_gradient_end_hover' => $theme_gradient_start,
		'button_border_color' => $theme_color,
		'button_border_color_hover' => $theme_color,
		'button_border_gradient_start' => $theme_gradient_start,
		'button_border_gradient_end' => $theme_gradient_end,
		'button_border_gradient_start_hover' => $theme_gradient_end,
		'button_border_gradient_end_hover' => $theme_gradient_start,
		// Background
		'pricing_customize' => 'def',
		'pricing_bg_color' => $theme_color,
		'pricing_bg_image' => '',
		'header_customize' => 'def',
		'header_bg_color' => $theme_color,
		'header_bg_image' => '',
		'content_customize' => 'def',
		'content_bg_color' => '',
		// Typography
		'title_size' => '',
		'title_weight' => '',
		'custom_title_color' => false,
		'title_color' => '#ffffff',
		'title_border_color' => '#ff7d00',
		'price_size' => '',
		'custom_price_color' => false,
		'price_color' => $header_font_color,
		'description_size' => '',
		'custom_description_color' => true,
		'description_color' => '#b8b8b8',
	);

	$atts = vc_shortcode_attribute_parse($defaults, $atts);
	extract($atts);

	if (!empty($button_title)) {
		// carousel options array
		$button_options_arr = array(
			'button_text' => $button_title,
			'link' => $link,
			'align' => 'center',
			'full_width' => true,
			'size' => 'l',
			'customize' => $button_customize,
			'text_color' => $button_text_color,
			'text_color_hover' => $button_text_color_hover,
			'bg_color' => $button_bg_color,
			'bg_color_hover' => $button_bg_color_hover,
			'border_color' => $button_border_color,
			'border_color_hover' => $button_border_color_hover,
			'bg_gradient_start' => $button_bg_gradient_start,
			'bg_gradient_end' => $button_bg_gradient_end,
			'bg_gradient_start_hover' => $button_bg_gradient_start_hover,
			'bg_gradient_end_hover' => $button_bg_gradient_end_hover,
			'border_gradient_start' => $button_border_gradient_start,
			'border_gradient_end' => $button_border_gradient_end,
			'border_gradient_start_hover' => $button_border_gradient_start_hover,
			'border_gradient_end_hover' => $button_border_gradient_end_hover,
			'shadow_style' => 'none',
		);

		// carousel options
		$button_options = array_map(function($k, $v) { return "$k=\"$v\" "; }, array_keys($button_options_arr), $button_options_arr);
		$button_options = implode('', $button_options);
	}

	$output = $styles = $pricing_title_out = $pricing_price_out = $pricing_desc_out = $pricing_cur_out = $pricing_icon = $pricing_inner = $pricing_button = $icon_type_html = $pricing_content = $pricing_wrap_classes = $pricing_plan_id_attr = '';

	// Adding unique id for pricing module
	if ((bool)$custom_icon_color || (bool)$custom_price_color || (bool)$custom_description_color || (bool)$custom_title_color || $pricing_customize != 'def' || $header_customize != 'def' || $content_customize != 'def') {
		$pricing_plan_id = uniqid( "seofy_pricing_plan_" );
		$pricing_plan_id_attr = 'id='.$pricing_plan_id;
	}

	// Custom pricing colors
	ob_start();
		if ((bool)$custom_icon_color) {
			echo "#$pricing_plan_id .pricing_icon{
				color: ".(!empty($icon_color) ? esc_attr($icon_color) : 'transparent').";
			}";
		}
		if ((bool)$custom_title_color) {
			echo "#$pricing_plan_id .pricing_title{
				color: ".(!empty($title_color) ? esc_attr($title_color) : 'transparent').";
			}";
		}
		if ((bool)$custom_price_color) {
			echo "#$pricing_plan_id .pricing_price_wrap{
				color: ".(!empty($price_color) ? esc_attr($price_color) : 'transparent').";
			}";
		}
		if ((bool)$custom_description_color) {
			echo "#$pricing_plan_id .pricing_desc{
				color: ".(!empty($description_color) ? esc_attr($description_color) : 'transparent').";
			}";
		}
		if ($header_customize == 'color') {
			echo "#$pricing_plan_id .pricing_header{
				background-color: ".(!empty($header_bg_color) ? esc_attr($header_bg_color) : 'transparent').";
			}";
			echo "#$pricing_plan_id .pricing_header .pricing_title{
				border-color: ".(!empty($header_bg_color) ? esc_attr($header_bg_color) : 'transparent').";
			}";
		}
		if ($content_customize == 'color') {
			echo "#$pricing_plan_id .pricing_content,
				#$pricing_plan_id .pricing_title-wrapper .pricing_title{
					background-color: ".(!empty($content_bg_color) ? esc_attr($content_bg_color) : 'transparent').";
			}";
		}
		if ($pricing_customize !== 'def') {
			echo "#$pricing_plan_id .pricing_header,
				  #$pricing_plan_id .pricing_content,
				  #$pricing_plan_id .pricing_footer{
					background-color: transparent;
			}";
			if ($pricing_customize == 'color') {
				echo "#$pricing_plan_id .pricing_plan_wrap{
					background-color: ".(!empty($pricing_bg_color) ? esc_attr($pricing_bg_color) : 'transparent').";
				}";
			}
		}

	$styles = ob_get_clean();
	Seofy_shortcode_css()->enqueue_seofy_css($styles);

	// Animation
	if (!empty($atts['css_animation'])) {
		$animation_class = $this->getCSSAnimation( $atts['css_animation'] );
	}

	// Pricing wrapper classes
	$pricing_wrap_classes .= !empty($animation_class) ? $animation_class : '';
	$pricing_wrap_classes .= !empty($extra_class) ? ' '.$extra_class : '';

	// Render Google Fonts
	extract( GoogleFontsRender::getAttributes( $atts, $this, array('google_fonts_title') ) );
	$title_font = (!empty($styles_google_fonts_title)) ? esc_attr($styles_google_fonts_title) : '';
	
	// Font sizes
	$title_font_size = !empty($title_size) ? ' font-size:'.(int)$title_size.'px; ' : '';
	$price_font_size = !empty($price_size) ? 'font-size:'.(int)$price_size.'px; ' : '';
	$description_font_size = !empty($description_size) ? 'font-size:'.(int)$description_size.'px; ' : '';

	// Title style
	$title_styles = ' style="border-color: '.(!empty($title_border_color) ? esc_attr($title_border_color) : 'transparent').';';
	$title_styles .= !empty($title_font_size) ? esc_attr($title_font_size).';' : '';
	$title_styles .= !empty($title_font) ? $title_font.';"' : '"';

	// Price, price description styles
	$price_styles = !empty($price_font_size) ? ' style="'.esc_attr($price_font_size).'"' : '';
	$description_styles = !empty($description_font_size) ? ' style="'.esc_attr($description_font_size).'"' : '';

	// Title output
	$pricing_title_out .= !empty($pricing_title) ? '<h4 class="pricing_title"'.$title_styles.'>'.esc_html($pricing_title).'</h4>' : '';

	// Price output
	if (isset($pricing_price)) {
		preg_match( "/(\d+)(\.| |,)(\d+)$/", $pricing_price, $matches, PREG_OFFSET_CAPTURE );
		switch (isset($matches[0])) {
			case true:
				$pricing_price_out .= '<div class="pricing_price">';
					$pricing_price_out .= esc_html($matches[1][0]);
					$pricing_price_out .= '<span class="price_decimal">'.esc_html($matches[3][0]).'</span>';
				$pricing_price_out .= '</div>';
				break;
			case false:
				$pricing_price_out .= '<div class="pricing_price">'.esc_html($pricing_price).'</div>';
				break;
		}
	}

	// Price description output
	$pricing_desc_out .= !empty($pricing_desc) ? '<div class="pricing_desc"'.$description_styles.'>'.esc_html($pricing_desc).'</div>' : '';

	// Price currency output
	$pricing_cur_out .= !empty($pricing_cur) ? '<span class="pricing_cur">'.esc_html($pricing_cur).'</span>' : '';

	// Icon/Image output
	if ($icon_type != 'none') {
		if ($icon_type == 'font' && !empty($icon_fontawesome)) {

			if ($icon_font_type == 'type_fontawesome') {
				wp_enqueue_style('font-awesome', get_template_directory_uri() . '/css/font-awesome.min.css');
				$icon_font = $icon_fontawesome;
			} else if($icon_font_type == 'type_flaticon'){
				wp_enqueue_style('flaticon', get_template_directory_uri() . '/fonts/flaticon/flaticon.css');
				$icon_font = $icon_flaticon;
			}

			$icon_size = ($custom_icon_size != '') ? 'style="font-size:'.(int)$custom_icon_size.'px;"' : '';
			$icon_type_html .= '<i class="pricing_icon '.esc_attr($icon_font).'" '.$icon_size.'></i>';
		} else if ($icon_type == 'image' && !empty($thumbnail)) {
			$featured_image = wp_get_attachment_image_src($thumbnail, 'full');
			$featured_image_url = $featured_image[0];
			$image_width_crop = ($custom_image_width != '') ? $custom_image_width*2 : '';
			$image_height_crop = ($custom_image_height != '') ? $custom_image_height*2 : '';
			$pricing_image_src = ($custom_image_width != '' || $custom_image_height != '') ? (aq_resize($featured_image_url, $image_width_crop, $image_height_crop, true, true, true)) : $featured_image_url;
			$image_width = ($custom_image_width != '') ? 'width:'.(int)$custom_image_width.'px; ' : '';
			$image_height = ($custom_image_height != '') ? 'height:'.(int)$custom_image_height.'px;' : '';
			$pricing_img_width_style = (!empty($image_width) || !empty($image_height))  ? 'style="'.$image_width.$image_height.'"' : '';
			$img_alt = get_post_meta($thumbnail, '_wp_attachment_image_alt', true);
			$icon_type_html .= '<div class="pricing_icon"><img src="'.esc_url($pricing_image_src).'" alt="'.(!empty($img_alt) ? esc_attr($img_alt) : '').'" '.$pricing_img_width_style.' /></div>';
		}
		$pricing_icon .= '<div class="pricing_icon_wrapper">';
			$pricing_icon .= '<div class="pricing_icon_container ">'.$icon_type_html.'</div>';
		$pricing_icon .= '</div>';
	}

	// Button
	$pricing_button .= !empty($button_title) ? do_shortcode('[wgl_button '.$button_options.'][/wgl_button]') : '';

	// Pricing footer description
	$header_image = wp_get_attachment_image_src($header_bg_image, 'full');
	$header_image_url = $header_image[0];
	$pricing_header_style = !empty($header_bg_image) ? 'style="background-image: url('.$header_image_url.')"' : '';

	// Pricing table background image
	$pricing_bg = wp_get_attachment_image_src($pricing_bg_image , 'full');
	$pricing_bg_url = $pricing_bg[0];
	$pricing_bg_style = !empty($pricing_bg) ? ' style="background: url('.esc_url($pricing_bg_url).') center / cover"' : '';

	// Pricing description footer
	$pricing_desc_footer = !empty($descr_text) ? '<div class="pricing_description">'.esc_html($descr_text).'</div>' : '';

	// Pricing content
	$pricing_content .= !empty($content) ? do_shortcode($content) : '';

	// Render html
	$pricing_inner .= '<div class="pricing_header" '.$pricing_header_style.'>';
		$pricing_inner .= $pricing_icon;
		$pricing_inner .= $pricing_title_out;
		$pricing_inner .= '<div class="pricing_price_wrap"'.$price_styles.'>';
			$pricing_inner .= $pricing_cur_out;
			$pricing_inner .= $pricing_price_out;
		$pricing_inner .= '</div>';
		$pricing_inner .= $pricing_desc_out;
	$pricing_inner .= '</div>';
	$pricing_inner .= '<div class="pricing_content">';
		$pricing_inner .= $pricing_content;
	$pricing_inner .= '</div>';
	$pricing_inner .= '<div class="pricing_footer">';
		$pricing_inner .= $pricing_desc_footer;
		$pricing_inner .= $pricing_button;
	$pricing_inner .= '</div>';
	

	$output .= '<div '.esc_attr($pricing_plan_id_attr).' class="seofy_module_pricing_plan'.esc_attr($pricing_wrap_classes).'">';
		$output .= '<div class="pricing_plan_wrap"'.$pricing_bg_style.'>';
			$output .= $pricing_inner;
		$output .= '</div>';
	$output .= '</div>';

	echo Seofy_Theme_Helper::render_html($output);

?>  
