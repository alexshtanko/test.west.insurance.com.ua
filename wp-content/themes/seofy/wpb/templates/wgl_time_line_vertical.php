<?php

    $theme_color = esc_attr(Seofy_Theme_Helper::get_option("theme-custom-color"));

    $defaults = array(
        'values' => '',
        'extra_class' => '',
        'appear_anim' => true,
    );

    $atts = vc_shortcode_attribute_parse($defaults, $atts);
    extract($atts);

    $output = $content = $time_line_wrap_classes = $animation_class = '';
    $i = 0; // counter ensuring identificator uniqueness

    wp_enqueue_script('appear', get_template_directory_uri() . '/js/jquery.appear.js', array(), false, false);

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
        $new_data['title'] = isset( $data['title'] ) ? $data['title'] : '';
        $new_data['descr'] = isset( $data['descr'] ) ? $data['descr'] : '';
        $new_data['date'] = isset( $data['date'] ) ? $data['date'] : '';
        $new_data['color'] = isset( $data['color'] ) ? $data['color'] : $theme_color;
        $new_data['active'] = isset( $data['active'] ) ? $data['active'] : false;
        $new_data['bg_image'] = isset( $data['bg_image'] ) ? $data['bg_image'] : '';

        $item_data[] = $new_data;
    }

    foreach ( $item_data as $item_d ) {

        $item_class = ((bool)$item_d['active']) ? 'item_active' : '';

        // Unique id
        $time_line_id = uniqid( "time_line_" ).++$i;
        $time_line_attr = 'id='.$time_line_id;

        // Custom colors
        ob_start();
            echo "#$time_line_id .time_line-date{
                    color: ".$item_d['color'].";
                  }";
            echo "#$time_line_id .time_line-content:before{
                    background: ".$item_d['color'].";
                  }";
        $styles = ob_get_clean();
        Seofy_shortcode_css()->enqueue_seofy_css($styles);

        $bg_image = wp_get_attachment_image_src($item_d['bg_image'], 'full');

        $content .= '<div '.$time_line_attr.' class="time_line-item '.$item_class.'">';
            $content .= '<div class="time_line-date_wrap">';
                $content .= Seofy_Theme_Helper::hexagon_html($item_d['color']);
                $content .= Seofy_Theme_Helper::hexagon_html($item_d['color'], true);
                $content .= '<h4 class="time_line-date">'.esc_html($item_d['date']).'</h4>';
            $content .= '</div>';
            $content .= '<div class="time_line-content">';
                $content .= !empty($bg_image) ? '<div class="time_line-image"><img src="'.esc_url($bg_image[0]).'" alt="'.esc_attr($item_d['title']).'" /></div>' : '';
                $content .= '<h5 class="time_line-title">'.esc_html($item_d['title']).'</h5>';
                $content .= '<div class="time_line-descr">'.esc_html($item_d['descr']).'</div>';
            $content .= '</div>';
        $content .= '</div>';

    }

    $output .= '<div class="seofy_module_time_line_vertical'.esc_attr($time_line_wrap_classes).'">';
        $output .= $content;
    $output .= '</div>';

    echo Seofy_Theme_Helper::render_html($output);

?>