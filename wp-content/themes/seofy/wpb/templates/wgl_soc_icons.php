<?php

    $theme_color = esc_attr(Seofy_Theme_Helper::get_option("theme-custom-color"));

    $defaults = array(
        'values' => '',
        'icon_size' => '',
        'bg_size' => '',
        'border_radius' => '',
        'icons_pos' => 'left',
        'icon_gap' => '',
        'add_bg' => true,
        'all_custom_colors' => false,
        'all_icon_color' => '#ffffff',
        'all_icon_hover_color' => $theme_color,
        'all_bg_color' => $theme_color,
        'all_bg_hover_color' => '#ffffff',
        'all_border_color' => '#ffffff',
        'all_border_hover_color' => $theme_color,
        'extra_class' => '',
    );

    $atts = vc_shortcode_attribute_parse($defaults, $atts);
    extract($atts);

    $output = $content = $social_wrap_classes = $animation_class = $icon_colors = $soc_icon_wrap_id_attr = '';

    // adding uniq id for soc icon module
    if ((bool)$all_custom_colors) {
        $soc_icon_wrap_id = uniqid( "seofy_soc_icon_wrap_" );
        $soc_icon_wrap_id_attr = 'id='.$soc_icon_wrap_id;
    }

    // custom soc icons colors
    ob_start();
        if ((bool)$all_custom_colors) {
            echo "#$soc_icon_wrap_id a{
                color: ".(!empty($all_icon_color) ? $all_icon_color : '#ffffff').";
            }";
            echo "#$soc_icon_wrap_id a:hover{
                color: ".(!empty($all_icon_hover_color) ? $all_icon_hover_color : $theme_color).";
            }";
            if ((bool)$add_bg) {
                echo "#$soc_icon_wrap_id a{
                    background: ".(!empty($all_bg_color) ? $all_bg_color : 'transparent').";
                    border-color: ".(!empty($all_border_color) ? $all_border_color : '#ffffff').";
                }";
                echo "#$soc_icon_wrap_id a:hover{
                    background: ".(!empty($all_bg_hover_color) ? $all_bg_hover_color : 'transparent').";
                    border-color: ".(!empty($all_border_hover_color) ? $all_border_hover_color : $theme_color).";
                }";
            }
        }
    $styles = ob_get_clean();
    Seofy_shortcode_css()->enqueue_seofy_css($styles);

    // Animation
    if (!empty($atts['css_animation'])) {
        $animation_class = $this->getCSSAnimation( $atts['css_animation'] );
    }

    // social wrapper classes
    $social_wrap_classes .= ' a'.$icons_pos;
    $social_wrap_classes .= (bool)$add_bg ? ' with_bg' : '';
    $social_wrap_classes .= !empty($animation_class) ? ' '.$animation_class : '';
    $social_wrap_classes .= !empty($extra_class) ? ' '.$extra_class : '';

    $values = (array) vc_param_group_parse_atts( $values );
    $item_data = array();
    foreach ( $values as $data ) {
        $new_data = $data;
        $new_data['icon'] = isset( $data['icon'] ) ? $data['icon'] : '';
        $new_data['link'] = isset( $data['link'] ) ? $data['link'] : '#';
        $new_data['title'] = isset( $data['title'] ) ? $data['title'] : '';
        $new_data['new_tab'] = isset( $data['new_tab'] ) ? $data['new_tab'] : true;
        $new_data['custom_colors'] = isset( $data['custom_colors'] ) ? $data['custom_colors'] : false;
        $new_data['icon_color'] = isset( $data['icon_color'] ) && !empty($data['icon_color']) ? $data['icon_color'] : '#ffffff';
        $new_data['icon_hover_color'] = isset( $data['icon_hover_color'] )  && !empty($data['icon_hover_color']) ? $data['icon_hover_color'] : 'transparent';
        $new_data['bg_color'] = isset( $data['bg_color'] ) && !empty($data['bg_color']) ? $data['bg_color'] : 'transparent';
        $new_data['bg_hover_color'] = isset( $data['bg_hover_color'] ) && !empty($data['bg_hover_color']) ? $data['bg_hover_color'] : '#ffffff';

        $item_data[] = $new_data;
    }

    $icon_size_style = !empty($icon_size) ? 'font-size:'.esc_attr($icon_size).'px; ' : '';
    $bg_size_style = (!empty($bg_size) && (bool)$add_bg) ? 'width:'.esc_attr($bg_size).'px; height:'.esc_attr($bg_size).'px; line-height:'.esc_attr($bg_size).'px; ' : '';
    $border_radius_style = ( ( !empty($border_radius) || $border_radius == '0' ) && (bool)$add_bg) ? 'border-radius:'.esc_attr($border_radius).'px; ' : '';
    $icon_gap_style = !empty($icon_gap) ? 'margin-left:'.esc_attr(($icon_gap/2)).'px; margin-right:'.esc_attr(($icon_gap/2)).'px; margin-bottom:'.($icon_gap).'px; ' : '';

    $icon_style = (!empty($icon_size_style) || !empty($bg_size_style) || !empty($border_radius_style) || !empty($icon_gap_style)) ? 'style="'.$icon_size_style.$bg_size_style.$border_radius_style.$icon_gap_style.'"' : '';

    foreach ( $item_data as $item_d ) {
        $icon = $item_d['icon'];
        $title_tag = !empty( $item_d['title'] ) ? " title='".esc_attr($item_d['title'])."'" : "";
        $new_tab = !empty( $item_d['link'] ) && (bool)$item_d['new_tab'] ? "target='_blank'" : "";

        if ((bool)$item_d['custom_colors']) {
            $social_id = uniqid( "soc_icon_" );
            $social_attr = 'id='.$social_id;
        } else{
            $social_attr = '';
        }
        // custom social colors
        ob_start();
            if ((bool)$item_d['custom_colors']) {
                echo "#$social_id{
                    color: ".$item_d['icon_color'].";
                }";
                echo "#$social_id:hover{
                    color: ".$item_d['icon_hover_color'].";
                }";
                if ((bool)$add_bg) {
                    echo "#$social_id{
                        background: ".$item_d['bg_color'].";
                    }";
                    echo "#$social_id:hover{
                        background: ".$item_d['bg_hover_color'].";
                    }";
                }
            }
        $styles = ob_get_clean();
        Seofy_shortcode_css()->enqueue_seofy_css($styles);

        $content .= '<a '.$social_attr.' href="'.esc_url($item_d['link']).'" class="soc_icon '.$item_d['icon'].'" '.$icon_style.' '.$new_tab.' '.$title_tag.'></a>';

    }

    $icon_wrap_gap_style = !empty($icon_gap) ? 'style="margin-left:-'.esc_attr(($icon_gap/2)).'px; margin-right:-'.esc_attr(($icon_gap/2)).'px;"' : '';

    $output .= '<div '.esc_attr($soc_icon_wrap_id_attr).' class="seofy_module_social clearfix'.esc_attr($social_wrap_classes).'" '.$icon_wrap_gap_style.'>';
        $output .= $content;
    $output .= '</div>';

    echo Seofy_Theme_Helper::render_html($output);

?>