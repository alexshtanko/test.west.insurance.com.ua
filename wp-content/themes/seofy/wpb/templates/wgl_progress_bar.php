<?php

    $theme_color = esc_attr(Seofy_Theme_Helper::get_option("theme-custom-color"));
    $header_font_color = esc_attr(Seofy_Theme_Helper::get_option('header-font')['color']);

    $defaults = array(
        'values' => '',
        'units' => '%',
        'extra_class' => '',
    );

    $atts = vc_shortcode_attribute_parse($defaults, $atts);
    extract($atts);
   
    wp_enqueue_script('appear', get_template_directory_uri() . '/js/jquery.appear.js', array(), false, false);

    $output = $points_render = $content = $value_render = $progress_classes = $animation_class = '';
    $i = 0; // counter ensuring identificator uniqueness

    // Animation
    if (!empty($atts['css_animation'])) {
        $animation_class = $this->getCSSAnimation( $atts['css_animation'] );
    }

    // Progress bar classes
    $progress_classes .= !empty($animation_class) ? ' '.$animation_class : '';
    $progress_classes .= !empty($extra_class) ? ' '.$extra_class : '';

    // Progress bar
    $values = (array) vc_param_group_parse_atts( $values );
    $item_data = array();
    foreach ( $values as $data ) {
        $new_data = $data;
        $new_data['label'] = isset( $data['label'] ) ? esc_html($data['label']) : '';
        $new_data['point_value'] = isset( $data['point_value'] ) ? (int)$data['point_value'] : '0';
        $new_data['text_color'] = isset( $data['text_color'] ) ? esc_attr($data['text_color']) : $header_font_color;
        $new_data['bg_bar_color'] = !empty( $data['bg_bar_color'] ) ? esc_attr($data['bg_bar_color']) : 'transparent';
        $new_data['bar_color'] = !empty( $data['bar_color'] ) ? esc_attr($data['bar_color']) : 'transparent';
        $new_data['bar_color_type'] = isset( $data['bar_color_type'] ) ? $data['bar_color_type'] : 'def';
        $new_data['bar_color_gradient_start'] = !empty( $data['bar_color_gradient_start'] ) ? esc_attr($data['bar_color_gradient_start']) : 'transparent';
        $new_data['bar_color_gradient_end'] = !empty( $data['bar_color_gradient_end'] ) ? esc_attr($data['bar_color_gradient_end']) : 'transparent';

        $item_data[] = $new_data;
    }

    foreach ( $item_data as $item_d ) {

        // Adding unique id for progress bar
        $progress_attr = '';
        if ($item_d['bar_color_type'] != 'def') {
            $progress_id = uniqid( "progress_" ).++$i; 
            $progress_id_attr = ' id='.$progress_id;
        }

        // Custom styles
        ob_start();
            if ($item_d['bar_color_type'] != 'def') {
                echo "#$progress_id .progress_label,
                      #$progress_id .progress_value,
                      #$progress_id .progress_units{
                        color: ".$item_d['text_color'].";
                    }";
                echo "#$progress_id.progress_bar_wrap{
                        background: ".$item_d['bg_bar_color'].";
                    }";
            }
            if ($item_d['bar_color_type'] == 'color') {
                echo "#$progress_id .progress_bar{
                        background: ".$item_d['bar_color'].";
                    }";
            }
            if ($item_d['bar_color_type'] == 'gradient') {
                $gradient = $item_d['bar_color_gradient_start'].';';
                $gradient .= 'background: -moz-linear-gradient(-30deg, '.$item_d['bar_color_gradient_start'].' 0%, '.$item_d['bar_color_gradient_end'].' 100%);';
                $gradient .= 'background: -webkit-linear-gradient(-30deg, '.$item_d['bar_color_gradient_start'].' 0%, '.$item_d['bar_color_gradient_end'].' 100%);';
                $gradient .= 'background: linear-gradient(120deg, '.$item_d['bar_color_gradient_start'].' 0%, '.$item_d['bar_color_gradient_end'].' 100%);';
                echo "#$progress_id .progress_bar{
                        background: ".$gradient."
                    }";
            }
        $styles = ob_get_clean();
        Seofy_shortcode_css()->enqueue_seofy_css($styles);

        // Render html
        $content .= '<div'.$progress_id_attr.' class="progress_bar_wrap">';
            $content .= '<div class="progress_bar" data-width="'.$item_d['point_value'].'">';
                $content .= '<div class="progress_label_wrap">';
                    $content .= '<h5 class="progress_label">'.$item_d['label'].'</h5>';
                $content .= '</div>';
            $content .= '</div>';
            $content .= '<div class="progress_value_wrap">';
                $content .= '<span class="progress_value">'.$item_d['point_value'].'</span>';
                $content .= '<span class="progress_units">'.$units.'</span>';
            $content .= '</div>';
        $content .= '</div>';
    }

    $output .= '<div class="seofy_module_progress_bar'.esc_attr($progress_classes).'">';
        $output .= $content;
    $output .= '</div>';

    echo Seofy_Theme_Helper::render_html($output);

?>