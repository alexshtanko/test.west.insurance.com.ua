<?php

	$theme_color = esc_attr(Seofy_Theme_Helper::get_option("theme-custom-color"));
	$second_color = esc_attr(Seofy_Theme_Helper::get_option("second-custom-color"));
	$theme_gradient = Seofy_Theme_Helper::get_option("theme-gradient");

	$defaults = array(
		// General
		'values' => '',
		'link' => '',
		'item_el_class' => '',
		// Icons Styles
		'icon_color_type' => 'color',
		'icon_color_idle' => $theme_color,
		'icon_color_hover' => $theme_color,
		'icon_color_from' => $theme_gradient['from'],
		'icon_color_to' => $theme_gradient['to'],
		'icon_hover_color_from' => $theme_gradient['to'],
		'icon_hover_color_to' => $theme_gradient['from'],
		'custom_icon_size' => '',
		'bg_color_type' => 'color',
		'bg_color_idle' => '#ffffff',
		'bg_color_hover' => $second_color,
		'bg_color_from' => $theme_gradient['from'],
		'bg_color_to' => $theme_gradient['to'],
		'bg_hover_color_from' => $theme_gradient['to'],
		'bg_hover_color_to' => $theme_gradient['from'],
		// Styles
		'custom_title_color' => false,
		'title_color' => '#252525',
		'custom_subtitle_color' => false,
		'subtitle_color' => $theme_color,
		'custom_content_color' => false,
		'content_color' => '#6e6e6e',
	);
	$atts = vc_shortcode_attribute_parse($defaults, $atts);
	extract($atts);

	$output = $services_wrap_classes = $services_id_attr = $animation_class = $icon_type_html = $content = '';

	if ($icon_color_type != 'def' || $bg_color_type != 'def') {
		$services_id = uniqid( "seofy_services_" );
		$services_id_attr = 'id='.$services_id;
	}

	// Custom services styles
	ob_start();
	if ($icon_color_type != 'def') {
		switch ($icon_color_type) {
			case 'color':
				echo "#$services_id .services_icon-grad1{
						color: ".(!empty($icon_color_idle) ? esc_attr($icon_color_idle) : 'transparent').";
					  }";
				echo "#$services_id .services_icon-grad2{
						color: ".(!empty($icon_color_hover) ? esc_attr($icon_color_hover) : 'transparent').";
					  }";
				break;
			case 'gradient':
				$gradient = 'linear-gradient(0deg, '.$icon_color_from.' 0%, '.$icon_color_to.' 100%)';
				$gradient2 = 'linear-gradient(0deg, '.$icon_hover_color_from.' 0%, '.$icon_hover_color_to.' 100%)';
				echo "#$services_id .services_icon-grad1{
						color: ".$icon_color_from.";
						-webkit-background-clip: text;
						background-image: -webkit-".$gradient.";
						background-image: -moz-".$gradient.";
					  }";
				echo "#$services_id .services_icon-grad2{
						color: ".$icon_hover_color_from.";
						-webkit-background-clip: text;
						background-image: -webkit-".$gradient2.";
						background-image: -moz-".$gradient2.";
					  }";
				break;
		}
	}
	if ($bg_color_type != 'def') {
		switch ($bg_color_type) {
			case 'color':
				echo "#$services_id .services_item-icon:before{
						background: ".(!empty($bg_color_idle) ? esc_attr($bg_color_idle) : 'transparent').";
					  }";
				echo "#$services_id .services_item-icon:after{
						background: ".(!empty($bg_color_hover) ? esc_attr($bg_color_hover) : 'transparent').";
					  }";
				break;
			case 'gradient':
				$gradient = 'linear-gradient(0deg, '.$bg_color_from.' 0%, '.$bg_color_to.' 100%)';
				$gradient2 = 'linear-gradient(0deg, '.$bg_hover_color_from.' 0%, '.$bg_hover_color_to.' 100%)';
				echo "#$services_id .services_item-icon:before{
						background-image: -webkit-".$gradient.";
						background-image: -moz-".$gradient.";
					  }";
				echo "#$services_id .services_item-icon:after{
						background-image: -webkit-".$gradient2.";
						background-image: -moz-".$gradient2.";
					  }";
				break;
		}
	}
	$styles = ob_get_clean();
	Seofy_shortcode_css()->enqueue_seofy_css($styles);

	// Animation
	if (!empty($atts['css_animation'])) {
		$animation_class = $this->getCSSAnimation( $atts['css_animation'] );
	}

	// services wrapper classes
	$services_wrap_classes .= $animation_class;
	$services_wrap_classes .= !empty($item_el_class) ? ' '.$item_el_class : '';

	$values = (array) vc_param_group_parse_atts( $values );
	$item_data = array();
	foreach ( $values as $data ) {
		$new_data = $data;
		$new_data['icon_font_type'] = isset( $data['icon_font_type'] ) ? $data['icon_font_type'] : 'type_flaticon';
		$new_data['icon_fontawesome'] = isset( $data['icon_fontawesome'] ) ? $data['icon_fontawesome'] : '';
		$new_data['icon_flaticon'] = isset( $data['icon_flaticon'] ) ? $data['icon_flaticon'] : '';
		$new_data['title'] = isset( $data['title'] ) ? $data['title'] : '';
		$new_data['subtitle'] = isset( $data['subtitle'] ) ? $data['subtitle'] : '';
		$new_data['descr'] = isset( $data['descr'] ) ? $data['descr'] : '';

		$item_data[] = $new_data;
	}

	foreach ( $item_data as $item_d ) {

		
		// Icon output
		if (!empty($item_d['icon_fontawesome']) || !empty($item_d['icon_flaticon'])) {
			if ($item_d['icon_font_type'] == 'type_fontawesome') {
				wp_enqueue_style('font-awesome', get_template_directory_uri() . '/css/font-awesome.min.css');
				$icon_font = $item_d['icon_fontawesome'];
			} else if($item_d['icon_font_type'] == 'type_flaticon'){
				wp_enqueue_style('flaticon', get_template_directory_uri() . '/fonts/flaticon/flaticon.css');
				$icon_font = $item_d['icon_flaticon'];
			}
			$icon_size = ($custom_icon_size != '') ? ' style="font-size:'.esc_attr((int)$custom_icon_size).'px;"' : '';
			$icon_type_html = '<i class="services_icon services_icon-grad1 '.esc_attr($icon_font).'" '.$icon_size.'></i><i class="services_icon services_icon-grad2 '.esc_attr($icon_font).'" '.$icon_size.'></i>';
		}

		// title html
		$services_title = '<h3 class="services_title" '.((bool)$custom_title_color ? 'style="color:'.esc_attr($title_color).'"' : '').'>'.esc_html($item_d['title']).'</h3>';
	
		// subtitle html
		$services_subtitle = '<div class="services_subtitle" '.((bool)$custom_subtitle_color ? 'style="color:'.esc_attr($subtitle_color).'"' : '').'>'.esc_html($item_d['subtitle']).'</div>';

		// descr html
		$services_descr = '<div class="services_descr" '.((bool)$custom_content_color ? 'style="color:'.esc_attr($content_color).'"' : '').'>'.esc_html($item_d['descr']).'</div>';


		$content .= '<div class="services_item-wrap">';
			$content .= '<div class="services_item-icon">';
				$content .= $icon_type_html;
			$content .= '</div>';
			$content .= '<div class="services_item-content">';
				$content .= $services_subtitle;
				$content .= $services_title;
				$content .= $services_descr;
			$content .= '</div>';
		$content .= '</div>';
	}



	// render html
	$output .= '<div '.esc_attr($services_id_attr).' class="seofy_module_circuit_services'.esc_attr($services_wrap_classes).'">';
		$output .= '<div class="services_wrapper">';
			$output .= $content;
		$output .= '</div>';
	$output .= '</div>';
	
	echo Seofy_Theme_Helper::render_html($output);

?>