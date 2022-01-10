<?php
	$theme_color = esc_attr(Seofy_Theme_Helper::get_option("theme-custom-color"));
	$header_font_color = esc_attr(Seofy_Theme_Helper::get_option('header-font')['color']);
	$main_font_color = esc_attr(Seofy_Theme_Helper::get_option('main-font')['color']);
	$theme_gradient_start = esc_attr(Seofy_Theme_Helper::get_option('theme-gradient')['from']);
	$theme_gradient_end = esc_attr(Seofy_Theme_Helper::get_option('theme-gradient')['to']);

	$defaults = array(
		// General
		'ib_type' => 'default',
		'ib_layout' => 'top',
		'ib_align' => 'left ',
		'add_shadow' => false,
		'shadow_style' => 'on_hover',
		'animation_class' => '',
		'extra_class' => '',
        // Content
		'ib_title' => '',
		'add_title_divider' => false,
		'ib_subtitle' => '',
		'ib_content' => '',
		'add_read_more' => false,
		'read_more_text' => 'Read More',
		'link' => '',
		'add_read_more_offset' => false,
		'read_more_offset' => '',
		// Icon/Image
		'icon_type' => 'none',
		'icon_font_type' => 'type_flaticon',
		'icon_fontawesome' => 'fa fa-adjust',
		'icon_flaticon' => '',
		'custom_icon_size' => '',
		'custom_icon_color' => false,
		'icon_color_type' => 'color',
		'icon_color_idle' => $theme_color,
		'icon_color_hover' => $theme_color,
		'icon_color_gradient_start' => $theme_gradient_start,
		'icon_color_gradient_end' => $theme_gradient_end,
		'add_icon_shadow' => false,
		'icon_shadow_style' => 'on_hover',
		'thumbnail' => '',
		'custom_image_width' => '',
		'custom_image_height' => '',
		'add_number' => false,
		'icon_number' => '01',
		'number_pos' => 'left_top',
		// Icon/Image Background
		'custom_icon_bg_width' => '',
		'custom_icon_bg_height' => '',
		'custom_icon_bot_offset' => '',
		'custom_icon_side_offset' => '',
		'custom_icon_radius' => '',
		'border_width' => '',
		'custom_border_color' => false,
		'border_color' => '#000000',
		'border_color_hover' => '#000000',
		'custom_icon_bg_color' => false,
		'icon_bg_type' => 'color',
		'icon_bg_color' => '#ffffff',
		'icon_bg_color_hover' => $theme_color,
		'icon_bg_gradient_start' => $theme_gradient_start,
		'icon_bg_gradient_end' => $theme_gradient_end,
		'icon_bg_gradient_start_hover' => $theme_gradient_end,
		'icon_bg_gradient_end_hover' => $theme_gradient_start,
		// Tile Background Colors
		'custom_tile_colors' => false,
		'tile_content_color_hover' => '#ffffff',
		'tile_bg_color_type' => 'def',
		'tile_bg_color' => '#ffffff',
		'tile_bg_color_hover' => $theme_color,
		// Typography
		'title_tag' => 'h3',
		'title_size' => '',
		'title_weight' => '',
		'title_bot_offset' => '',
		'custom_title_color' => false,
		'title_color' => $header_font_color,
		'subtitle_tag' => 'span',
		'subtitle_size' => '',
		'custom_subtitle_color' => false,
		'subtitle_color' => '#000000',
		'content_tag' => 'div',
		'content_size' => '',
		'content_weight' => '',
		'custom_content_color' => false,
		'content_color' => $main_font_color,
		'button_size' => '',
		'custom_button_color' => false,
		'button_color' => $theme_color,
		'button_color_hover' => $header_font_color,
	);
	$atts = vc_shortcode_attribute_parse($defaults, $atts);
	extract($atts);

	$output = $style = $infobox_id = $infobox_id_attr = $infobox_wrap_classes = $infobox_inner = $button_attr = $icon_type_html = $animation_class = '';
	$infobox_icon = $infobox_title = $infobox_subtitle = $infobox_content = $infobox_button = $number_icon_html = '';

	// Adding unique id for info-box item
	if ((bool)$custom_title_color || (bool)$custom_subtitle_color || (bool)$custom_content_color || (bool)$custom_button_color || (bool)$custom_icon_color || (bool)$custom_border_color || (bool)$custom_tile_colors || (bool)$add_shadow || (bool)$add_icon_shadow || (bool)$custom_icon_bg_color) {
		$infobox_id = uniqid( "seofy_infobox_" );
		$infobox_id_attr = 'id='.$infobox_id;
	}

	// Custom info-box styles
	ob_start();
		// custom colors
		if ((bool)$custom_title_color) {
			echo "#$infobox_id .infobox_title{
				color: ".(!empty($title_color) ? esc_html($title_color) : 'transparent').";
			}";
			echo "#$infobox_id.infobox_alignment_left.title_divider .infobox_title:before,
				#$infobox_id.infobox_alignment_right.title_divider .infobox_title:before{
				background: ".(!empty($title_color) ? esc_html($title_color) : 'transparent').";
			}";
		}
		if ((bool)$custom_subtitle_color) {
			echo "#$infobox_id .infobox_subtitle{
				color: ".(!empty($subtitle_color) ? esc_html($subtitle_color) : 'transparent').";
			}";
		}
		if ((bool)$custom_content_color) {
			echo "#$infobox_id .infobox_content{
				color: ".(!empty($content_color) ? esc_html($content_color) : 'transparent').";
			}";
		}
		if ((bool)$custom_button_color) {
			echo "#$infobox_id .infobox_button{
				color: ".(!empty($button_color) ? esc_html($button_color) : 'transparent').";
			}";
			echo "#$infobox_id .infobox_button:hover{
				color: ".(!empty($button_color_hover) ? esc_html($button_color_hover) : 'transparent').";
			}";
		}
		if ((bool)$custom_icon_color) {
			switch ($icon_color_type) {
				case 'color':
					echo "#$infobox_id .infobox_icon{
							color: ".(!empty($icon_color_idle) ? esc_html($icon_color_idle) : 'transparent').";
							-webkit-text-fill-color: unset;
						  }";
					echo "#$infobox_id:hover .infobox_icon{
							color: ".(!empty($icon_color_hover) ? esc_html($icon_color_hover) : 'transparent').";
						  }";
					break;
				case 'gradient':
					$icon_color_gradient_start = (!empty($icon_color_gradient_start) ? esc_attr($icon_color_gradient_start) : 'transparent');
					$icon_color_gradient_end = (!empty($icon_color_gradient_end) ? esc_attr($icon_color_gradient_end) : 'transparent');
					$gradient_values = 'linear-gradient(0deg, '.$icon_color_gradient_start.' 0%, '.$icon_color_gradient_end.' 100%)';
					echo "#$infobox_id .infobox_icon{
							color: ".$icon_color_gradient_start.";
							-webkit-text-fill-color: transparent;
							-webkit-background-clip: text;
							background-image: -webkit-".$gradient_values.";
							background-image: -moz-".$gradient_values.";
						  }";
					break;
			}
		}
		if ((bool)$custom_border_color) {
			echo "#$infobox_id .infobox_icon_container{
				border-color: ".(!empty($border_color) ? esc_html($border_color) : 'transparent').";
			}";
			echo "#$infobox_id:hover .infobox_icon_container{
				border-color: ".(!empty($border_color_hover) ? esc_html($border_color_hover) : 'transparent').";
			}";
		}
		if ((bool)$custom_tile_colors && !empty($tile_content_color_hover)) {
			echo "#$infobox_id.type_tile:hover .infobox_title,
				  #$infobox_id.type_tile:hover .infobox_subtitle,
				  #$infobox_id.type_tile:hover .infobox_content{
					color: ".esc_html($tile_content_color_hover).";
				  }";
		}
		if ($tile_bg_color_type == 'color') {
			echo "#$infobox_id.type_tile{
				background-color: ".(!empty($tile_bg_color) ? esc_attr($tile_bg_color) : 'transparent').";
			}";
			echo "#$infobox_id.type_tile:hover{
				background-color: ".(!empty($tile_bg_color_hover) ? esc_attr($tile_bg_color_hover) : 'transparent').";
				border-color: ".(!empty($tile_bg_color_hover) ? esc_attr($tile_bg_color_hover) : 'transparent').";
			}";
		}
		if ((bool)$custom_icon_bg_color) {
			switch ($icon_bg_type) {
				case 'color':
					echo "#$infobox_id .infobox_icon_container{
							background-color: ".(!empty($icon_bg_color) ? esc_attr($icon_bg_color) : 'transparent').";
						 }";
					echo "#$infobox_id:hover .infobox_icon_container{
							background-color: ".(!empty($icon_bg_color_hover) ? esc_attr($icon_bg_color_hover) : 'transparent').";
						  }";
					break;
				case 'gradient':
					$icon_bg_gradient_start = (!empty($icon_bg_gradient_start) ? esc_attr($icon_bg_gradient_start) : 'transparent');
					$icon_bg_gradient_end = (!empty($icon_bg_gradient_end) ? esc_attr($icon_bg_gradient_end) : 'transparent');
					$gradient_values = 'linear-gradient(90deg, '.$icon_bg_gradient_start.' 0%, '.$icon_bg_gradient_end.' 100%);';
					$gradient_before = $icon_bg_gradient_start.';';
					$gradient_before .= 'background: -webkit-'.$gradient_values;
					$gradient_before .= 'background: -moz-'.$gradient_values;
					$gradient_before .= 'background: '.$gradient_values;
					echo "#$infobox_id .infobox_icon_container.ib_gradient:before{
							background: ".$gradient_before."
						  }";
					$icon_bg_gradient_start_hover = (!empty($icon_bg_gradient_start_hover) ? esc_attr($icon_bg_gradient_start_hover) : 'transparent');
					$icon_bg_gradient_end_hover = (!empty($icon_bg_gradient_end_hover) ? esc_attr($icon_bg_gradient_end_hover) : 'transparent');
					$gradient_values = 'linear-gradient(90deg, '.$icon_bg_gradient_start_hover.' 0%, '.$icon_bg_gradient_end_hover.' 100%);';
					$gradient_after = $icon_bg_gradient_start_hover.';';
					$gradient_after .= 'background: -webkit-'.$gradient_values;
					$gradient_after .= 'background: -moz-'.$gradient_values;
					$gradient_after .= 'background: '.$gradient_values;
					echo "#$infobox_id .infobox_icon_container.ib_gradient:after{
							background: ".$gradient_after."
						  }";
					break;
			}
		}
		// info-box shadow
		$box_shadow = 'box-shadow: 7px 5px 30px 0 rgba(72,73,121,0.15);';
		$bg_white = 'background-color: #ffffff;';
		if ((bool)$add_shadow) {
			switch ($shadow_style) {
				case 'before_hover':
					echo "#$infobox_id .infobox_wrapper{"
							.$box_shadow.$bg_white.
						  "}";
					echo "#$infobox_id:hover .infobox_wrapper{ box-shadow: none; }";
					break;
				case 'on_hover':
					echo "#$infobox_id .infobox_wrapper{ box-shadow: none; }";
					echo "#$infobox_id:hover .infobox_wrapper{"
							.$box_shadow.$bg_white.
							"border-color: transparent;
						}";
					break;
				case 'always':
					echo "#$infobox_id .infobox_wrapper{".$box_shadow.$bg_white."}";
					break;
			}
		}
		// icon container shadow
		if ((bool)$add_icon_shadow) {
			switch ($icon_shadow_style) {
				case 'before_hover':
					echo "#$infobox_id .infobox_icon_container{".$box_shadow."}";
					echo "#$infobox_id:hover .infobox_icon_container{box-shadow: none;}";
					break;
				case 'on_hover':
					echo "#$infobox_id .infobox_icon_container{box-shadow: none;}";
					echo "#$infobox_id:hover .infobox_icon_container{".$box_shadow."}";
					break;
				case 'always':
					echo "#$infobox_id .infobox_icon_container{".$box_shadow."}";
					break;
			}
		}
	$styles = ob_get_clean();
	Seofy_shortcode_css()->enqueue_seofy_css($styles);

	// Animation
	if (!empty($atts['css_animation'])) {
		$animation_class = $this->getCSSAnimation( $atts['css_animation'] );
	}

	// Info-box wrapper classes
	$infobox_wrap_classes .= ' type_'.$ib_type;
	$infobox_wrap_classes .= ' layout_'.$ib_layout;
	$infobox_wrap_classes .= ' infobox_alignment_'.$ib_align;
	$infobox_wrap_classes .= (bool)$add_title_divider ? ' title_divider' : '';
	$infobox_wrap_classes .= $animation_class;
	$infobox_wrap_classes .= !empty($extra_class) ? ' '.$extra_class : '';

	// Render Google Fonts
	extract( GoogleFontsRender::getAttributes( $atts, $this, array('google_fonts_title', 'google_fonts_subtitle', 'google_fonts_content', 'google_fonts_button') ) );
	$title_font = (!empty($styles_google_fonts_title)) ? esc_attr($styles_google_fonts_title) : '';
	$subtitle_font = (!empty($styles_google_fonts_subtitle)) ? esc_attr($styles_google_fonts_subtitle) : '';
	$content_font = (!empty($styles_google_fonts_content)) ? esc_attr($styles_google_fonts_content) : '';
	$button_font = (!empty($styles_google_fonts_button)) ? esc_attr($styles_google_fonts_button) : '';

	// Font sizes
	$title_font_size = ($title_size != '') ? 'font-size:'.$title_size.'px; ' : '';
	$title_font_weight = ($title_weight != '') ? 'font-weight:'.$title_weight.'; ' : '';
	$title_offset = ($title_bot_offset != '') ? 'margin-bottom:'.(int)$title_bot_offset.'px; ' : '';
	$subtitle_font_size = ($subtitle_size != '') ? 'font-size:'.$subtitle_size.'px; ' : '';
	$content_font_size = ($content_size != '') ? 'font-size:'.$content_size.'px; ' : '';
	$content_font_weight = ($content_weight != '') ? 'font-weight:'.$content_weight.'; ' : '';
	$button_font_size = ($button_size != '') ? 'font-size:'.$button_size.'px; ' : '';
	$button_offset = ($add_read_more_offset != '') ? 'margin-top:'.$read_more_offset.'px; ' : '';

	// Title, subtitle, content, button styles
	$title_styles = (!empty($title_font_size) || !empty($title_font) || !empty($title_font_weight) || !empty($title_offset)) ? ' style="'.esc_attr($title_font_size).esc_attr($title_font_weight).$title_font.$title_offset.'"' : '';
	$subtitle_styles = (!empty($subtitle_font_size) || !empty($subtitle_font)) ? ' style="'.esc_attr($subtitle_font_size).$subtitle_font.'"' : '';
	$content_styles = (!empty($content_font_size) || !empty($content_font) || !empty($content_font_weight)) ? ' style="'.esc_attr($content_font_size).$content_font.$content_font_weight.'"' : '';
	$button_styles = (!empty($button_font_size) || !empty($button_font) || !empty($button_offset)) ? ' style="'.esc_attr($button_font_size).$button_font.$button_offset.'"' : '';

	// Read more button
	$link_temp = vc_build_link($link);
	$url = $link_temp['url'];
	$button_title = $link_temp['title'];
	$target = $link_temp['target'];
	$button_attr .= !empty($url) ? 'href="'.esc_url($url).'"' : 'href="#"';
	$button_attr .= !empty($button_title) ? " title='".esc_attr($button_title)."'" : '';
	$button_attr .= !empty($target) ? ' target="'.esc_attr($target).'"' : '';
	$button_attr .= !empty($button_styles) ? $button_styles : '';
	$infobox_button .= $add_read_more ? '<a class="infobox_button button-read-more" '.$button_attr.'>'.esc_html($read_more_text).'</a>' : '';

	// Title output
	$infobox_title .= !empty($ib_title) ? '<'.esc_attr($title_tag).' class="infobox_title" '.$title_styles.'>'.wp_kses( $ib_title, array('br' => array()) ).'</'.esc_attr($title_tag).'>' : '';

	// Subtitle output
	$infobox_subtitle .= !empty($ib_subtitle) ? '<'.esc_attr($subtitle_tag).' class="infobox_subtitle" '.$subtitle_styles.'>'.esc_html($ib_subtitle).'</'.esc_attr($subtitle_tag).'>' : '';

	// Content output
	$infobox_content .= !empty($ib_content) ? '<'.esc_attr($content_tag).' class="infobox_content" '.$content_styles.'>'.esc_html($ib_content).'</'.esc_attr($content_tag).'>' : '';

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
			$icon_size = ($custom_icon_size != '') ? ' style="font-size:'.(int)$custom_icon_size.'px;"' : '';
			$icon_type_html .= '<i class="infobox_icon '.esc_attr($icon_font).'" '.$icon_size.'></i>';
		} else if ($icon_type == 'image' && !empty($thumbnail)) {
			$featured_image = wp_get_attachment_image_src($thumbnail, 'full');
			$featured_image_url = $featured_image[0];
			$image_width_crop = ($custom_image_width != '') ? $custom_image_width*2 : '';
			$image_height_crop = ($custom_image_height != '') ? $custom_image_height*2 : '';
			$iconbox_image_src = ($custom_image_width != '' || $custom_image_height != '') ? (aq_resize($featured_image_url, $image_width_crop, $image_height_crop, true, true, true)) : $featured_image_url;
			$image_width = ($custom_image_width != '') ? 'width:'.(int)$custom_image_width.'px; ' : '';
			$image_height = ($custom_image_height != '') ? 'height:'.(int)$custom_image_height.'px;' : '';
			$iconbox_img_width_style = (!empty($image_width) || !empty($image_height))  ? ' style="'.$image_width.$image_height.'"' : '';
			$img_alt = get_post_meta($thumbnail, '_wp_attachment_image_alt', true);
			$icon_type_html .= '<div class="infobox_icon" '.(($custom_image_height != '') ? ' style="height:'.(int)$custom_image_height.'px;"' : '').'><img src="'.esc_url($iconbox_image_src).'" alt="'.(!empty($img_alt) ? esc_attr($img_alt) : '').'" '.$iconbox_img_width_style.' /></div>';
		}
		$number_icon_html .= ((bool)$add_number && $icon_number != '') ? '<span class="infobox_icon_number '.esc_attr($number_pos).'">'.$icon_number.'</span>' : '';
		$icon_bg_width = ($custom_icon_bg_width != '') ? 'width:'.(int)$custom_icon_bg_width.'px; ' : '';
		$icon_bg_height = ($custom_icon_bg_height != '') ? 'height:'.(int)$custom_icon_bg_height.'px; ' : '';
		$icon_bg_radius = ($custom_icon_radius != '') ? 'border-radius:'.(int)$custom_icon_radius.'px; ' : '';
		$icon_border_width = ($border_width != '') ? 'border-width:'.(int)$border_width.'px; ' : '';
		$icon_bg_gradient_class = ($icon_bg_type == 'gradient') ? ' ib_gradient' : '';
		$icon_bg_style = (!empty($icon_bg_width) || !empty($icon_bg_height) || !empty($icon_bg_radius) || !empty($icon_border_width))  ? ' style="'.$icon_bg_width.$icon_bg_height.$icon_bg_radius.$icon_border_width.'"' : '';
		$icon_bot_offset = ($custom_icon_bot_offset != '') ? 'margin-bottom:'.$custom_icon_bot_offset.'px; ' : '';
		$icon_left_offset = ($custom_icon_side_offset != '' && ($ib_layout == 'left' || $ib_layout == 'top_left')) ? 'margin-right:'.$custom_icon_side_offset.'px; ' : '';
		$icon_right_offset = ($custom_icon_side_offset != '' && ($ib_layout == 'right' || $ib_layout == 'top_right')) ? 'margin-left:'.$custom_icon_side_offset.'px; ' : '';

		$icon_wrap_style = (!empty($icon_bot_offset) || !empty($icon_left_offset) || !empty($icon_right_offset))  ? ' style="'.$icon_bot_offset.$icon_left_offset.$icon_right_offset.'"' : '';
		
		$infobox_icon .= '<div class="infobox_icon_wrapper" '.$icon_wrap_style.'>';
			$infobox_icon .= '<div class="infobox_icon_container'.$icon_bg_gradient_class.'"'.$icon_bg_style.'>';
			$infobox_icon .= $icon_type_html.$number_icon_html;
			$infobox_icon .= '</div>';
		$infobox_icon .= '</div>';
	}

	// Layout switch
	switch ($ib_layout) {
		case 'top':
			$infobox_inner .= $infobox_icon;
			$infobox_inner .= $infobox_title;
			$infobox_inner .= $infobox_subtitle;
			$infobox_inner .= $infobox_content;
			$infobox_inner .= $infobox_button;
			break;
		case 'left':
		case 'right':
		case 'top_left':
		case 'top_right':
			$infobox_inner .= $infobox_icon;
			$infobox_inner .= '<div class="infobox_content_wrapper">';
			$infobox_inner .= $infobox_title;
			$infobox_inner .= $infobox_subtitle;
			$infobox_inner .= $infobox_content;
			$infobox_inner .= $infobox_button;
			$infobox_inner .= '</div>';
			break;
	}

	// Render html
	$output .= '<div '.esc_attr($infobox_id_attr).' class="seofy_module_infobox'.esc_attr($infobox_wrap_classes).'">';
		$output .= '<div class="infobox_wrapper">';
			$output .= $infobox_inner;
		$output .= '</div>';
	$output .= '</div>';

	echo Seofy_Theme_Helper::render_html($output);

?>  
