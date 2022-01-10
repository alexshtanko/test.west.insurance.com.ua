<?php
if ( ! defined( 'ABSPATH' ) ) {
    die( '-1' );
}

$main_font = Seofy_Theme_Helper::get_option('main-font');
$theme_color = esc_attr(Seofy_Theme_Helper::get_option("theme-custom-color"));
$header_font = Seofy_Theme_Helper::get_option('header-font');
if (function_exists('vc_map')) {
    vc_map(array(
        'name' => esc_html__('Countdown Timer', 'seofy'),
        'base' => 'wgl_countdown',
        'class' => 'seofy_countdown',
        'content_element' => true,
        'description' => esc_html__('Countdown','seofy'),
        'category' => esc_html__('WGL Modules', 'seofy'),
        'icon' => 'wgl_icon_countdown',
        'params' => array(
            array(
                'type'          => 'seofy_param_heading',
                'heading' => esc_html__('Countdown Date:', 'seofy'),
                'param_name'    => 'h_date',
            ),
            array(
                'type' => 'textfield',
                'heading' => esc_html__('Year', 'seofy'),
                'param_name' => 'countdown_year',
                'edit_field_class' => 'vc_col-sm-2',
                'description' => esc_html__('Enter year example: 2018', 'seofy'),
            ),
            array(
                'type' => 'textfield',
                'heading' => esc_html__('Month', 'seofy'),
                'param_name' => 'countdown_month',
                'edit_field_class' => 'vc_col-sm-2',
                'description' => esc_html__('Enter month example: 03', 'seofy'),
            ),            
            array(
                'type' => 'textfield',
                'heading' => esc_html__('Day', 'seofy'),
                'param_name' => 'countdown_day',
                'edit_field_class' => 'vc_col-sm-2',
                'description' => esc_html__('Enter day example: 28', 'seofy'),
            ),
            array(
                'type' => 'textfield',
                'heading' => esc_html__('Hours', 'seofy'),
                'param_name' => 'countdown_hours', 
                'edit_field_class' => 'vc_col-sm-2',
                'description' => esc_html__('Enter hours example: 13', 'seofy'),
            ),
            array(
                'type' => 'textfield',
                'heading' => esc_html__('Minutes', 'seofy'),
                'param_name' => 'countdown_min',
                'edit_field_class' => 'vc_col-sm-2',
                'description' => esc_html__('Enter min. example: 24', 'seofy'),
            ), 
            array(
                "type"          => "seofy_param_heading",
                "heading" => esc_html__("Countdown Hide:", 'seofy'),
                "param_name"    => "h_hide",
            ),
            array(
                'type' => 'wgl_checkbox',
                'heading' => esc_html__( 'Hide Days?', 'seofy' ),
                'param_name' => 'hide_day',
                'edit_field_class' => 'vc_col-sm-3',
            ),            
            array(
                'type' => 'wgl_checkbox',
                'heading' => esc_html__( 'Hide Hours?', 'seofy' ),
                'param_name' => 'hide_hours',
                'edit_field_class' => 'vc_col-sm-3',
            ),
            array(
                'type' => 'wgl_checkbox',
                'heading' => esc_html__( 'Hide Minutes?', 'seofy' ),
                'param_name' => 'hide_minutes',
                'edit_field_class' => 'vc_col-sm-3',
            ),
            array(
                'type' => 'wgl_checkbox',
                'heading' => esc_html__( 'Hide Seconds?', 'seofy' ),
                'param_name' => 'hide_seconds',
                'edit_field_class' => 'vc_col-sm-3',
            ),
            array(
                'type' => 'wgl_checkbox',
                'heading' => esc_html__( 'Custom font family for a countdown?', 'seofy' ),
                'param_name' => 'custom_fonts_countdown',
                'description' => esc_html__( 'Customize font family', 'seofy' ),
                'group' => esc_html__( 'Style', 'seofy' ),
            ),
            array(
                'type' => 'google_fonts',
                'param_name' => 'google_fonts_countdown',
                'value' => '',
                'dependency' => array(
                    'element' => 'custom_fonts_countdown',
                    'value' => 'true',
                ),
                'group' => esc_html__( 'Style', 'seofy' ),
            ),
            array(
                "type" => "dropdown",
                "class" => "",
                "heading" => esc_html__("Size", 'seofy'),
                "param_name" => "size",
                "value" => array(
                    esc_html__("Small",'seofy') => "small",
                    esc_html__("Medium",'seofy') => "medium",
                    esc_html__("Large",'seofy') => "large",
                    esc_html__("Extra Large",'seofy') => "e_large",
                    esc_html__("Custom",'seofy') => "custom",
                ),
                'std'         => 'large', 
                'group' => esc_html__( 'Style', 'seofy' ),
            ),
            array(
                'type' => 'textfield',
                'heading' => esc_html__('Custom Font Size', 'seofy'),
                'param_name' => 'font_size',
                'description' => esc_html__('Enter font-size in pixels', 'seofy'),
                'edit_field_class' => 'vc_col-sm-4',
                'dependency' => array(
                    'element' => 'size',
                    'value' => 'custom',
                ),
                'group' => esc_html__( 'Style', 'seofy' ),
            ),
            array(
                'type' => 'textfield',
                'heading' => esc_html__('Custom Font Size Numner', 'seofy'),
                'param_name' => 'font_size_number',
                'description' => esc_html__('Enter font-size in em', 'seofy'),
                'edit_field_class' => 'vc_col-sm-4',
                'dependency' => array(
                    'element' => 'size',
                    'value' => 'custom',
                ),
                'group' => esc_html__( 'Style', 'seofy' ),
            ),           
             array(
                'type' => 'textfield',
                'heading' => esc_html__('Custom Font Size Text', 'seofy'),
                'param_name' => 'font_size_text',
                'description' => esc_html__('Enter font-size in em', 'seofy'),
                'edit_field_class' => 'vc_col-sm-4',
                'dependency' => array(
                    'element' => 'size',
                    'value' => 'custom',
                ),
                'group' => esc_html__( 'Style', 'seofy' ),
            ),
            array(
                'type' => 'textfield',
                'heading' => esc_html__('Custom Number Weight', 'seofy'),
                'param_name' => 'font_weight',
                'description' => esc_html__('Enter font-weight in pixels', 'seofy'),
                'edit_field_class' => 'vc_col-sm-4',
                'group' => esc_html__( 'Style', 'seofy' ),
            ),
            array(
                'type' => 'textfield',
                'heading' => esc_html__('Custom Text Weight', 'seofy'),
                'param_name' => 'font_text_weight',
                'description' => esc_html__('Enter font-weight in pixels', 'seofy'),
                'edit_field_class' => 'vc_col-sm-4',
                'group' => esc_html__( 'Style', 'seofy' ),
            ),
            array(
                'type' => 'dropdown',
                'heading' => esc_html__( 'Align', 'seofy' ),
                'param_name' => 'align',
                "value"         => array(
                    esc_html__( 'Left', 'seofy' ) => 'left',
                    esc_html__( 'Center', 'seofy' ) => 'center',
                    esc_html__( 'Right', 'seofy' ) => 'right',
                ),
                'std' => 'center',
                'group' => esc_html__( 'Style', 'seofy' ),
            ),
            array(
                'type' => 'colorpicker',
                'class' => '',
                'heading' => esc_html__('Number Color', 'seofy'),
                'param_name' => 'number_color',
                'value' => "#ffffff",
                'group' => esc_html__( 'Style', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-4',
            ), 
            array(
                'type' => 'colorpicker',
                'class' => '',
                'heading' => esc_html__('Text Color', 'seofy'),
                'param_name' => 'countdown_color',
                'value' => "#ffffff",
                'group' => esc_html__( 'Style', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-4',
            ), 
            array(
                'type' => 'colorpicker',
                'class' => '',
                'heading' => esc_html__('Points Color', 'seofy'),
                'param_name' => 'points_color',
                'value' => $theme_color,
                'group' => esc_html__( 'Style', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-4',
            ),                     
        )
    ));
    
    if (class_exists('WPBakeryShortCode')) {
        class WPBakeryShortCode_wgl_countdown extends WPBakeryShortCode {}
    } 
}