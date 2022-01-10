<?php

    $theme_color = esc_attr(Seofy_Theme_Helper::get_option("theme-custom-color"));

    $defaults = array(
        'values' => '',
        'extra_class' => '',
        'main_color' => '#ffffff',
        'appear_anim' => true,
        // Carousel
        'slide_to_show' => '5',
        'slides_to_scroll' => true,
        'autoplay' => false,
        'autoplay_speed' => '3000',
        'use_pagination' => true,
        'pag_type' => 'circle',
        'pag_offset' => '',
        'pag_align' => 'center',
        'custom_pag_color' => false,
        'pag_color' => $theme_color,
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

    // carousel options array
    $carousel_options_arr = array(
        'slide_to_show' => $slide_to_show,
        'autoplay' => $autoplay,
        'autoplay_speed' => $autoplay_speed,
        'use_pagination' => $use_pagination,
        'pag_type' => $pag_type,
        'pag_offset' => $pag_offset,
        'pag_align' => $pag_align,
        'custom_pag_color' => $custom_pag_color,
        'pag_color' => $pag_color,
        'custom_resp' => $custom_resp,
        'resp_medium' => $resp_medium,
        'resp_medium_slides' => $resp_medium_slides,
        'resp_tablets' => $resp_tablets,
        'resp_tablets_slides' => $resp_tablets_slides,
        'resp_mobile' => $resp_mobile,
        'resp_mobile_slides' => $resp_mobile_slides,
        'slides_to_scroll' => $slides_to_scroll,
    );

    // carousel options
    $carousel_options = array_map(function($k, $v) { return "$k=\"$v\" "; }, array_keys($carousel_options_arr), $carousel_options_arr);
    $carousel_options = implode('', $carousel_options);

    wp_enqueue_script('slick', get_template_directory_uri() . '/js/slick.min.js', array(), false, false);
   
    if ((bool)$appear_anim){
        wp_enqueue_script('appear', get_template_directory_uri() . '/js/jquery.appear.js', array(), false, false);
    }

    $output = $content = $time_line_wrap_classes = $animation_class = '';

     // uniq id
    $time_line_module_id = uniqid( "time_line_" );
    $time_line_module_attr = 'id='.$time_line_module_id;

    // custom social colors
    ob_start();
        echo "#$time_line_module_id .time_line-date,
            #$time_line_module_id .time_line-descr{
            color: ".$main_color.";
        }";
        echo "#$time_line_module_id:before{
            background: -webkit-linear-gradient(left, transparent 0%, ".$main_color." 100px, ".$main_color." calc(100% - 100px), transparent 100%);;
        }";
    $styles = ob_get_clean();
    Seofy_shortcode_css()->enqueue_seofy_css($styles);

    // Animation
    if (!empty($atts['css_animation'])) {
        $animation_class = $this->getCSSAnimation( $atts['css_animation'] );
    }

    // social wrapper classes
    $time_line_wrap_classes .= (bool)$appear_anim ? ' appear_anim' : '';
    $time_line_wrap_classes .= !empty($animation_class) ? ' '.$animation_class : '';
    $time_line_wrap_classes .= !empty($extra_class) ? ' '.$extra_class : '';

    $values = (array) vc_param_group_parse_atts( $values );
    $item_data = array();
    foreach ( $values as $data ) {
        $new_data = $data;
        $new_data['descr'] = isset( $data['descr'] ) ? $data['descr'] : '';
        $new_data['date'] = isset( $data['date'] ) ? $data['date'] : '';
        $new_data['circle_color'] = isset( $data['circle_color'] ) ? $data['circle_color'] : $theme_color;

        $item_data[] = $new_data;
    }

    foreach ( $item_data as $item_d ) {

        // uniq id
        $time_line_id = uniqid( "time_line_" );
        $time_line_attr = 'id='.$time_line_id;

        // custom social colors
        ob_start();
            echo "#$time_line_id .time_line-check:before{
                background: ".$item_d['circle_color'].";
                box-shadow: 0 0 10px 5px rgba(".Seofy_Theme_Helper::HexToRGB($item_d['circle_color']).",0.35);
            }";
            echo "#$time_line_id.time_line-item:hover .time_line-check:before{
                box-shadow: 0 0 10px 10px rgba(".Seofy_Theme_Helper::HexToRGB($item_d['circle_color']).",0.35);
            }";
        $styles = ob_get_clean();
        Seofy_shortcode_css()->enqueue_seofy_css($styles);

        $content .= '<div '.$time_line_attr.' class="time_line-item">';
            $content .= '<h4 class="time_line-date">'.esc_html($item_d['date']).'</h4>';
            $content .= '<div class="time_line-check_wrap"><div class="time_line-check"></div></div>';
            $content .= '<div class="time_line-descr">'.esc_html($item_d['descr']).'</div>';
        $content .= '</div>';

    }

    $output .= '<div '.$time_line_module_attr.' class="seofy_module_time_line_horizontal'.esc_attr($time_line_wrap_classes).'">';
        $output .= do_shortcode('[wgl_carousel '.$carousel_options.']'.$content.'[/wgl_carousel]');
    $output .= '</div>';

    echo Seofy_Theme_Helper::render_html($output);

?>