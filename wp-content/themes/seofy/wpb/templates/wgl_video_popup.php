<?php

$theme_color = esc_attr(Seofy_Theme_Helper::get_option("theme-custom-color"));
$header_font_color = esc_attr(Seofy_Theme_Helper::get_option('header-font')['color']);
$theme_gradient_start = esc_attr(Seofy_Theme_Helper::get_option('theme-gradient')['from']);
$theme_gradient_end = esc_attr(Seofy_Theme_Helper::get_option('theme-gradient')['to']);


$defaults = array(
	// General
    'title' => '',
    'title_pos' => 'bot',
    'button_pos' => 'center',
    'link' => '',
    'bg_image' => '',
	'extra_class' => '',
    // Styles
    'title_color' => $header_font_color,
    'title_size' => '',
    'btn_size' => '',
    'triangle_size' => '',
    'triangle_color' => '#ffffff',
    'bg_color_type' => 'def',
    'background_color' => $theme_color,
    'background_gradient_start' => $theme_gradient_start,
    'background_gradient_end' => $theme_gradient_end,
	// Animation
	'animation_style' => 'animation_ring',
    'always_pulse_anim' => false,
    'animation_color' => '#ffffff',
);

$atts = vc_shortcode_attribute_parse($defaults, $atts);
extract($atts);

// Enqueue swipebox script
wp_enqueue_script('swipebox', get_template_directory_uri() . '/js/swipebox/js/jquery.swipebox.min.js', array(), false, false);
wp_enqueue_style('swipebox', get_template_directory_uri() . '/js/swipebox/css/swipebox.min.css');

$videobox_id = uniqid( "seofy_video_" );
$videobox_id_attr = ' id='.$videobox_id;

$title_font_family = $video_wrap_classes = $animated_element = $style = $triangle_svg = '';

ob_start();
	switch ($bg_color_type) {
		case 'color':
			echo "#$videobox_id .videobox_link{
				background-color: ".(!empty($background_color) ? esc_html($background_color) : 'transparent').";
			}";
			break;
		case 'gradient':
			$background_gradient_start = !empty($background_gradient_start) ? esc_attr($background_gradient_start) : 'transparent';
			$background_gradient_end = !empty($background_gradient_end) ? esc_attr($background_gradient_end) : 'transparent';
			echo "#$videobox_id .videobox_link{
				background: linear-gradient(90deg, $background_gradient_start, $background_gradient_end);
			}";
			break;
	}
$styles = ob_get_clean();
Seofy_shortcode_css()->enqueue_seofy_css($styles);

// Google Fonts
extract( GoogleFontsRender::getAttributes( $atts, $this, array('google_fonts_title') ) );
if ( !empty( $styles_google_fonts_title ) ) {
	$title_font_family = esc_attr( $styles_google_fonts_title ) . ';';
}

// Animation
if (!empty($atts['css_animation'])) {
	$animation_class = $this->getCSSAnimation( $atts['css_animation'] );
}

// Wrapper classes
$video_wrap_classes .= ' button_align-'.$button_pos;
$video_wrap_classes .= ' title_pos-'.$title_pos;
$video_wrap_classes .= ' '.$animation_style;
$video_wrap_classes .= (bool)$always_pulse_anim ? ' always-pulse-animation' : '';
$video_wrap_classes .= !empty($bg_image) ? ' with_image' : '';
$video_wrap_classes .= !empty($animation_class) ? ' '.$animation_class : '';
$video_wrap_classes .= !empty($extra_class) ? ' '.$extra_class : '';

// Title style
$title_size = !empty($title_size) ? 'font-size: ' . $title_size . 'px;' : '';
$title_color = !empty($title_color) ? 'color: '.$title_color.';' : '';
$title_style = (!empty($title_color) || !empty($title_size) || !empty($title_font_family)) ? 'style="'.esc_attr($title_color).$title_font_family.esc_attr($title_size).'"' : '';

// Title output
$title = !empty($title) ? '<h2 class="title" '.$title_style.' >'.$title.'</h2>' : '';

// Button size (diameter)
$btn_size_style = !empty($btn_size) ? ' width:'.esc_attr((int)$btn_size).'px; height:'.esc_attr((int)$btn_size).'px;' : '';

// Link
$link = ' href="'.(!empty($link) ? esc_url($link) : '#').'"';

// Animation color
$animation_color_style = ' style="border-color: '.(!empty($animation_color) ? esc_attr($animation_color) : 'transparent').'";';

// Animation element output
switch ($animation_style) {
	case 'animation_circles':
		$animated_element .= '<div class="videobox_animation circle_1"'.$animation_color_style.'></div>';
		$animated_element .= '<div class="videobox_animation circle_2"'.$animation_color_style.'></div>';
		$animated_element .= '<div class="videobox_animation circle_3"'.$animation_color_style.'></div>';
		break;
	case 'animation_ring':
		$animated_element .= '<div class="videobox_animation ring_1"></div>';
		break;
}

// Triangle styles
$triangle_size_style = !empty($triangle_size) ? ' width="'.esc_attr((int)$triangle_size).'px" height="'.esc_attr((int)$triangle_size).'px" ' : ' width="31%" height="35%"';

$triangle_color_style = ' fill="'.(!empty($triangle_color) ? esc_attr($triangle_color) : 'white').'"';

// Triangle svg output
switch ($triangle_shape = 'rounded') {
	case 'sharp':
		$triangle_svg .= '<svg class="videobox_icon"'.$triangle_size_style.$triangle_color_style.' viewBox="0 0 10 10"><polygon points="1,0 1,10 8.5,5"/></svg>';
		break;
	case 'rounded':
		$triangle_svg .= '<svg class="videobox_icon"'.$triangle_size_style.$triangle_color_style.' viewBox="0 0 232 232"><path d="M203,99L49,2.3c-4.5-2.7-10.2-2.2-14.5-2.2 c-17.1,0-17,13-17,16.6v199c0,2.8-0.07,16.6,17,16.6c4.3,0,10,0.4,14.5-2.2 l154-97c12.7-7.5,10.5-16.5,10.5-16.5S216,107,204,100z"/></svg>';
		break;
}

if ( !empty($btn_size_style) ) {
	$style .= ' style="'.$btn_size_style.'"';
}


// Render html
$uniqrel = uniqid();

$output = '<div'.$videobox_id_attr.' class="seofy_module_videobox'.esc_attr($video_wrap_classes).'">';
	$output .= '<div class="videobox_content">';
		$output .= !empty($bg_image) ? '<div class="videobox_background">'.wp_get_attachment_image( $bg_image , 'full' ).'</div>' : '';
		$output .= !empty($bg_image) ? '<div class="videobox_link_wrapper">' : '';
		$output .= $title;
		$output .= '<a data-rel="youtube-'.esc_attr($uniqrel).'" class="videobox_link videobox"'.$link.$style.'>';
			$output .= $triangle_svg;
			$output .= $animated_element;
		$output .= '</a>';
		$output .= !empty($bg_image) ? '</div>' : '';
	$output .= '</div>';
$output .= '</div>';

echo Seofy_Theme_Helper::render_html($output);

?>