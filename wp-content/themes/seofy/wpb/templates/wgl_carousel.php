<?php

$theme_color = esc_attr(Seofy_Theme_Helper::get_option("theme-custom-color"));
wp_enqueue_script('slick', get_template_directory_uri() . '/js/slick.min.js', array(), false, false);

$defaults = array(
	//General
    'slide_to_show' => '1',
    'autoplay' => true,
    'autoplay_speed' => '3000',
    'speed' => '300',
    'slides_to_scroll' => false,
	'infinite' => false,
	'adaptive_height' => false,
	'variable_width' => false,
	'extra_class' => '',
	// Navigation
	'use_pagination' => true,
	'use_navigation' => false,
	'pag_type' => 'circle',
	'nav_type' => 'element',
	'pag_offset' => '',
	'pag_align' => 'center',
	'custom_offeset_prev_next' => false,
	'buttons_offset' => '50%',
	'custom_pag_color' => false,
	'pag_color' => $theme_color,
	'use_prev_next' => false,
	'custom_buttons_color' => false,
	'buttons_color' => $theme_color,
	'buttons_bg_color' => '#ffffff',
	// Responsive
	'custom_resp' => false,
	'resp_medium' => '1025',
	'resp_medium_slides' => '',
	'resp_tablets' => '800',
	'resp_tablets_slides' => '',
	'resp_mobile' => '480',
	'resp_mobile_slides' => '',
);

$atts = vc_shortcode_attribute_parse($defaults, $atts);
extract($atts);

$carousel_id_attr = $carousel_wrap_classes = $animation_class = '';
if ((bool)$custom_pag_color || (bool)$custom_buttons_color || $pag_offset != '' || $buttons_offset != '') {
	$carousel_id = uniqid( "seofy_carousel_" );
	$carousel_id_attr = 'id='.$carousel_id;
}

// custom carousel colors
ob_start();
	if ((bool)$custom_pag_color) {
		echo "#$carousel_id.pagination_circle .slick-dots li button,
		#$carousel_id.pagination_square .slick-dots li button,
		#$carousel_id.pagination_line_circle .slick-dots li button{
			background: ".(!empty($pag_color) ? esc_html($pag_color) : 'transparent').";
		}";
		echo "#$carousel_id.pagination_line .slick-dots li button:before{
			background: ".(!empty($pag_color) ? esc_html($pag_color) : 'transparent').";
		}";
	}
	if ((bool)$custom_buttons_color) {
		echo "#$carousel_id .slick-arrow{
			border-color: ".(!empty($buttons_color) ? esc_html($buttons_color) : 'transparent').";
			color: ".(!empty($buttons_color) ? esc_html($buttons_color) : 'transparent').";
			background-color: ".(!empty($buttons_bg_color) ? esc_html($buttons_bg_color) : 'transparent').";
		}";
	}
	if ($pag_offset != '') {
		echo "#$carousel_id.seofy_module_carousel .slick-dots{
			margin-top: ".(int)$pag_offset."px;
		}";
	}
	if((bool) $custom_offeset_prev_next){
		if ($buttons_offset != '') {
			echo "#$carousel_id.seofy_module_carousel .slick-next,
				#$carousel_id.seofy_module_carousel .slick-prev{
				top: ".(int)$buttons_offset."%;
			}";
		}
	}
$styles = ob_get_clean();
Seofy_shortcode_css()->enqueue_seofy_css($styles);

// Animation
if (!empty($atts['css_animation'])) {
	$animation_class = $this->getCSSAnimation( $atts['css_animation'] );
}

switch ($slide_to_show) {
	case '2':
		$responsive_medium = 2;
		$responsive_tablets = 2;
		$responsive_mobile = 1;
		break;
	case '3':
		$responsive_medium = 3;
		$responsive_tablets = 2;
		$responsive_mobile = 1;
		break;
	case '4':
	case '5':
	case '6':
		$responsive_medium = 4;
		$responsive_tablets = 2;
		$responsive_mobile = 1;
		break;
	default:
		$responsive_medium = 1;
		$responsive_tablets = 1;
		$responsive_mobile = 1;
		break;
}

//If Custom responsive
if ($custom_resp) {
	$responsive_medium = !empty($resp_medium_slides) ? (int)$resp_medium_slides : $responsive_medium;
	$responsive_tablets = !empty($resp_tablets_slides) ? (int)$resp_tablets_slides : $responsive_tablets;
	$responsive_mobile = !empty($resp_mobile_slides) ? (int)$resp_mobile_slides : $responsive_mobile;
}

if($slides_to_scroll){
	$responsive_sltscrl_medium = $responsive_sltscrl_tablets = $responsive_sltscrl_mobile = 1;
}else{
	$responsive_sltscrl_medium = $responsive_medium;
	$responsive_sltscrl_tablets = $responsive_tablets;
	$responsive_sltscrl_mobile = $responsive_mobile;
}


$data_array = array(); 
$data_array['slidesToShow'] =  (int)$slide_to_show;
$data_array['slidesToScroll'] = $slides_to_scroll ? 1 : (int)$slide_to_show;
$data_array['infinite'] = $infinite ? true : false;
if(!empty($variable_width)){
	$data_array['variableWidth'] =  true;
}

$data_array['autoplay'] = $autoplay ? true : false;
$data_array['autoplaySpeed'] = $autoplay_speed ? $autoplay_speed : '';
$data_array['speed'] = $speed ? (int)$speed : '300';

$data_array['arrows'] = $use_prev_next ? true : false;
$data_array['dots'] = $use_pagination ? true : false;
$data_array['adaptiveHeight'] = $adaptive_height ? true : false;

//Responsive settings
$data_array['responsive'][0]['breakpoint'] = (int)$resp_medium;
$data_array['responsive'][0]['settings']['slidesToShow'] = (int) esc_attr($responsive_medium);
$data_array['responsive'][0]['settings']['slidesToScroll'] = (int) esc_attr($responsive_sltscrl_medium);

$data_array['responsive'][1]['breakpoint'] = (int)$resp_tablets;
$data_array['responsive'][1]['settings']['slidesToShow'] = (int) esc_attr($responsive_tablets);
$data_array['responsive'][1]['settings']['slidesToScroll'] = (int) esc_attr($responsive_sltscrl_tablets);

$data_array['responsive'][2]['breakpoint'] = (int)$resp_mobile;
$data_array['responsive'][2]['settings']['slidesToShow'] = (int) esc_attr($responsive_mobile);
$data_array['responsive'][2]['settings']['slidesToScroll'] = (int) esc_attr($responsive_sltscrl_mobile);

$data_attribute = " data-slick='".json_encode($data_array, true)."'";


$carousel_wrap_classes .= $use_pagination ? ' pagination_'.$pag_type : '';
$carousel_wrap_classes .= $use_navigation ? ' navigation_'.$nav_type : '';
$carousel_wrap_classes .= ' pag_align_'.$pag_align;
$carousel_wrap_classes .= $animation_class;
$carousel_wrap_classes .= !empty($extra_class) ? ' '.$extra_class : '';

echo '<div class="seofy_module_carousel-wrapper">';
echo '<div '.esc_attr($carousel_id_attr).' class="seofy_module_carousel'.esc_attr($carousel_wrap_classes).'">';
    echo '<div class="seofy_carousel_slick"'.$data_attribute.'>';	
        echo do_shortcode($content);
    echo '</div>';
echo '</div>';
echo '</div>';

