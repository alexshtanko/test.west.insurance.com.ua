<?php
if ( ! defined( 'ABSPATH' ) ) {
    die( '-1' );
}

$theme_color = esc_attr(Seofy_Theme_Helper::get_option("theme-custom-color"));
$header_font_color = esc_attr(Seofy_Theme_Helper::get_option('header-font')['color']);
$theme_gradient_start = esc_attr(Seofy_Theme_Helper::get_option('theme-gradient')['from']);
$theme_gradient_end = esc_attr(Seofy_Theme_Helper::get_option('theme-gradient')['to']);

if (function_exists('vc_map')) {
    vc_map(array(
        'name' => esc_html__('Progress Bar', 'seofy'),
        'base' => 'wgl_progress_bar',
        'class' => 'seofy_progress_bar',
        'category' => esc_html__('WGL Modules', 'seofy'),
        'icon' => 'wgl_icon_progress_bar',
        'content_element' => true,
        'description' => esc_html__('Display Progress Bar','seofy'),
        'params' => array(
            array(
                'type' => 'param_group',
                'param_name' => 'values',
                'description' => esc_html__( 'Enter values for graph - point label and point value.', 'seofy' ),
                'params' => array(
                    array(
                        "type" => "textfield",
                        "heading" => esc_html__( 'Label', 'seofy' ),
                        "param_name" => "label",
                        'admin_label' => true,
                        "description" => esc_html__( 'Enter text used as title of bar.', 'seofy' ),
                    ),
                    array(
                        "type" => "textfield",
                        "heading" => esc_html__( 'Value', 'seofy' ),
                        "param_name" => "point_value",
                        "description" => esc_html__( 'Enter value of bar.', 'seofy' ),
                    ),
                    array(
                        'type' => 'dropdown',
                        'heading' => esc_html__( 'Progress Bar Customize Color', 'seofy' ),
                        'param_name' => 'bar_color_type',
                        'value' => array(
                            esc_html__( 'Default', 'seofy' )  => 'def',
                            esc_html__( 'Color', 'seofy' )    => 'color',
                            esc_html__( 'Gradient', 'seofy' ) => 'gradient',
                        ),
                    ),
                    // Text color
                    array(
                        'type' => 'colorpicker',
                        'heading' => esc_html__('Text Color', 'seofy'),
                        'param_name' => 'text_color',
                        'value' => $header_font_color,
                        'description' => esc_html__('Select custom color', 'seofy'),
                        'dependency' => array(
                            'element' => 'bar_color_type',
                            'value' => array('color', 'gradient')
                        ),
                        'edit_field_class' => 'vc_col-sm-6',
                    ),
                    // Bar bg color
                    array(
                        'type' => 'colorpicker',
                        'heading' => esc_html__('Background Bar Color', 'seofy'),
                        'param_name' => 'bg_bar_color',
                        'value' => '#f4f6fd',
                        'description' => esc_html__('Select custom color', 'seofy'),
                        'dependency' => array(
                            'element' => 'bar_color_type',
                            'value' => array('color', 'gradient')
                        ),
                        'edit_field_class' => 'vc_col-sm-6',
                    ),
                    // Bar color
                    array(
                        'type' => 'colorpicker',
                        'heading' => esc_html__('Bar Color', 'seofy'),
                        'param_name' => 'bar_color',
                        'value' => $theme_color,
                        'description' => esc_html__('Select custom color', 'seofy'),
                        'dependency' => array(
                            'element' => 'bar_color_type',
                            'value' => 'color'
                        ),
                        'edit_field_class' => 'vc_col-sm-6',
                    ),
                    // Bar color gradient start
                    array(
                        'type' => 'colorpicker',
                        'class' => '',
                        'heading' => esc_html__('Bar Start Color', 'seofy'),
                        'param_name' => 'bar_color_gradient_start',
                        'value' => $theme_gradient_start,
                        'save_always' => true,
                        'description' => esc_html__('Select gradient start color', 'seofy'),
                        'dependency' => array(
                            'element' => 'bar_color_type',
                            'value' => 'gradient'
                        ),
                        'group' => esc_html__( 'Content', 'seofy' ),
                        'edit_field_class' => 'vc_col-sm-6',
                    ),
                    // Bar color gradient end
                    array(
                        'type' => 'colorpicker',
                        'class' => '',
                        'heading' => esc_html__('Bar End Color', 'seofy'),
                        'param_name' => 'bar_color_gradient_end',
                        'value' => $theme_gradient_end,
                        'save_always' => true,
                        'description' => esc_html__('Select gradient end color', 'seofy'),
                        'dependency' => array(
                            'element' => 'bar_color_type',
                            'value' => 'gradient'
                        ),
                        'group' => esc_html__( 'Content', 'seofy' ),
                        'edit_field_class' => 'vc_col-sm-6',
                    ),
                ),
            ),
            array(
                "type" => "textfield",
                "heading" => esc_html__( 'Units', 'seofy' ),
                "param_name" => "units",
                'value' => '%',
                'description' => esc_html__('Enter measurement units (Example: %, px, points, etc. Note: graph value and units will be appended to graph title).', 'seofy'),
            ),
            vc_map_add_css_animation( true ),
            array(
                'type' => 'textfield',
                'heading' => esc_html__('Extra Class', 'seofy'),
                'param_name' => 'extra_class',
                'description' => esc_html__('Add an extra class name to the element and refer to it from Custom CSS option.', 'seofy')
            ),
        )
    ));

    if (class_exists('WPBakeryShortCode')) {
        class WPBakeryShortCode_wgl_Progress_Bar extends WPBakeryShortCode {
        }
    }
}
