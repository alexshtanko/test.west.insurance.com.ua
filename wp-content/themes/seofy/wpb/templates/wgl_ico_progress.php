<?php

$theme_gradient = Seofy_Theme_Helper::get_option('theme-gradient');

$defaults = array(
	//General
    'bg_color_type' => 'def',
    'bg_color' => 'rgba(0,0,32,0.7)',
    'bg_gradient_start' => $theme_gradient['from'],
    'bg_gradient_end' => $theme_gradient['to'],
    'ico_left_pad' => '30',
    'ico_right_pad' => '30',
    'ico_top_pad' => '30',
    'ico_bottom_pad' => '30',
    'extra_class' => '',
);

$atts = vc_shortcode_attribute_parse($defaults, $atts);
extract($atts);

$ico_attr = $ico_wrap_classes = $animation_class = $ico_styles = '';
if ($bg_color_type !== 'def') {
	$ico_id = uniqid( "seofy_ico_" );
	$ico_attr = 'id='.$ico_id;
}

// custom colors
ob_start();
	if ($bg_color_type == 'color') {
	    echo "#$ico_id{
	        background-color: ".$bg_color.";
	    }";
	}
	if ($bg_color_type == 'gradient') {
	    echo "#$ico_id{
	        background: linear-gradient(90deg, $bg_gradient_start, $bg_gradient_end);
	    }";
	}
$styles = ob_get_clean();
Seofy_shortcode_css()->enqueue_seofy_css($styles);

// Animation
if (!empty($atts['css_animation'])) {
	$animation_class = $this->getCSSAnimation( $atts['css_animation'] );
}

$ico_wrap_classes .= $animation_class;
$ico_wrap_classes .= !empty($extra_class) ? ' '.$extra_class : '';

$ico_styles .= ($ico_left_pad != '') ? 'padding-left:'.$ico_left_pad.'px; ' : '';
$ico_styles .= ($ico_right_pad != '') ? 'padding-right:'.$ico_right_pad.'px; ' : '';
$ico_styles .= ($ico_top_pad != '') ? 'padding-top:'.$ico_top_pad.'px; ' : '';
$ico_styles .= ($ico_bottom_pad != '') ? 'padding-bottom:'.$ico_bottom_pad.'px; ' : '';
 
$ico_style_attr = !empty($ico_styles) ? ' style="'.$ico_styles.'"' : '';
?>

    <div <?php echo esc_attr($ico_attr); echo Seofy_Theme_Helper::render_html($ico_style_attr); ?> class="seofy_module_ico_progress<?php echo esc_attr($ico_wrap_classes) ?>">
        <?php echo do_shortcode($content); ?>
    </div>

