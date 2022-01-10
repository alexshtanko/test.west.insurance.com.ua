<?php

	$defaults = array(
		// General
		'values' => '',
		'interval' => '600',
		'transition' => '800',
		'link' => '',
		'extra_class' => '',
	);
	$atts = vc_shortcode_attribute_parse($defaults, $atts);
	extract($atts);

	$output = $img_layer_image = $img_layer_wrap_classes = $img_layer_classes = $offset_styles = $styles = $link_attr = '';

    $nth_child = $animation_delay = 0;
    $animation_delay = $animation_delay - $interval;

	wp_enqueue_script('appear', get_template_directory_uri() . '/js/jquery.appear.js', array(), false, false);

	// adding uniq id for infobox module
	$img_layer_id = uniqid( "seofy_img_layer_" );
	$img_layer_id_attr = 'id='.$img_layer_id;

	// image layer wrapper classes
    $img_layer_wrap_classes .= !empty($extra_class) ? ' '.$extra_class : '';

	// Link Settings
	$link_temp = vc_build_link($link);
	$url = $link_temp['url'];
	$link_title = $link_temp['title'];
	$target = $link_temp['target'];
	$link_attr .= !empty($url) ? 'href="'.esc_url($url).'"' : '';
	$link_attr .= !empty($link_title) ? " title='".esc_attr($link_title)."'" : '';
	$link_attr .= !empty($target) ? ' target="'.esc_attr($target).'"' : '';

	$values = (array) vc_param_group_parse_atts( $values );
    $item_data = array();
    foreach ( $values as $data ) {
        $new_data = $data;
        $new_data['thumbnail'] = isset( $data['thumbnail'] ) ? $data['thumbnail'] : '';
        $new_data['top_offset'] = isset( $data['top_offset'] ) ? $data['top_offset'] : '';
        $new_data['left_offset'] = isset( $data['left_offset'] ) ? $data['left_offset'] : '';
        $new_data['image_animation'] = isset( $data['image_animation'] ) ? $data['image_animation'] : '';
        $new_data['image_order'] = isset( $data['image_order'] ) ? $data['image_order'] : '1';

        $item_data[] = $new_data;
    }
    foreach ( $item_data as $item_d ) {
    	$nth_child ++;
    	$animation_delay = $animation_delay + $interval;

    	// animation delay styles
	    ob_start();
		echo "#$img_layer_id .img_layer_image_wrapper:nth-child(".$nth_child.") .img_layer_image {transition: all ".$transition."ms; -webkit-transition-delay: ".$animation_delay."ms; -moz-transition-delay: ".$animation_delay."ms; -o-transition-delay: ".$animation_delay."ms; transition-delay: ".$animation_delay."ms;}";
		$styles .= ob_get_clean();

    	// image offset
    	$offset_styles = '-webkit-transform: translate('.esc_attr($item_d['top_offset']).'%, '.esc_attr($item_d['left_offset']).'%); -moz-transform: translate('.esc_attr($item_d['top_offset']).'%, '.esc_attr($item_d['left_offset']).'%); -o-transform: translate('.esc_attr($item_d['top_offset']).'%, '.esc_attr($item_d['left_offset']).'%); transform: translate('.esc_attr($item_d['top_offset']).'%, '.esc_attr($item_d['left_offset']).'%);'; 
    	$offset_styles = ($item_d['top_offset'] != '' && $item_d['left_offset'] != '') ? 'style="'.$offset_styles.'"' : '';

        // image url
        $featured_image = wp_get_attachment_image_src($item_d['thumbnail'], 'full');
        $img_alt = get_post_meta($item_d['thumbnail'], '_wp_attachment_image_alt', true);

        // image html
        $img_layer_image .= '<div class="img_layer_image_wrapper '.esc_attr($item_d['image_animation']).'" style="z-index:'.esc_attr($item_d['image_order']).'">';
	        $img_layer_image .= '<div class="img_layer_item" '.$offset_styles.'>';
	       		$img_layer_image .= '<div class="img_layer_image">';
	       			$img_layer_image .= '<img src="'.esc_url($featured_image[0]).'" alt="'.(!empty($img_alt) ? esc_attr($img_alt) : '').'" />';
	        	$img_layer_image .= '</div>';
	        $img_layer_image .= '</div>';
	    $img_layer_image .= '</div>';
    }

	$output .= '<div '.esc_attr($img_layer_id_attr).' class="seofy_module_img_layer'.esc_attr($img_layer_wrap_classes).'">';

		$output .= !empty($url) ? "<a ".$link_attr.">" : '';
		$output .= $img_layer_image;
		$output .= !empty($url) ? '</a>' : '';

	$output .= '</div>';

	Seofy_shortcode_css()->enqueue_seofy_css($styles);

	echo Seofy_Theme_Helper::render_html($output);

?>  
