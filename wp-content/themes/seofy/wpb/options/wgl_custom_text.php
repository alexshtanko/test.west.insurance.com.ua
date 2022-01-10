<?php
if ( ! defined( 'ABSPATH' ) ) {
    die( '-1' );
}

$main_font = Seofy_Theme_Helper::get_option('main-font');

if (function_exists('vc_map')) {
// Add list item
    vc_map(array(
        'name' => esc_html__('WGL Text Module', 'seofy'),
        'base' => 'wgl_custom_text',
        'class' => 'seofy_custom_text',
        'category' => esc_html__('WGL Modules', 'seofy'),
        'icon' => 'wgl_icon_custom_text',
        'content_element' => true,
        'description' => esc_html__('Text with responsive settings','seofy'),
        'params' => array(
            array(
                'type' => 'textarea_html',
                'holder' => 'div',
                'heading' => esc_html__('Content.', 'seofy') ,
                'param_name' => 'content',
            ),
            vc_map_add_css_animation( true ),
            array(
                'type' => 'textfield',
                'heading' => esc_html__('Extra Class', 'seofy'),
                'param_name' => 'extra_class',
                'description' => esc_html__('Add an extra class name to the element and refer to it from Custom CSS option.', 'seofy')
            ),
            array(
                'type' => 'textfield',
                'heading' => esc_html__('Font Size', 'seofy'),
                'param_name' => 'font_size',
                'value' => (int)$main_font['font-size'],
                'description' => esc_html__( 'Enter font-size in pixels.', 'seofy' ),
                'group' => esc_html__( 'Styling', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-4 no-top-padding',
            ),
            array(
                'type' => 'textfield',
                'heading' => esc_html__('Line Height', 'seofy'),
                'param_name' => 'line_height',
                'value' => $main_font['line-height'],
                'description' => esc_html__( 'Enter line height in px.', 'seofy' ),
                'group' => esc_html__( 'Styling', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-4 no-top-padding',
            ),
            array(
                'type' => 'wgl_checkbox',
                'heading' => esc_html__( 'Custom font family for text', 'seofy' ),
                'param_name' => 'custom_fonts',
                'description' => esc_html__( 'Customize font family', 'seofy' ),
                'group' => esc_html__( 'Styling', 'seofy' ),
            ),
            array(
                'type' => 'google_fonts',
                'param_name' => 'google_fonts_text',
                'value' => '',
                'dependency' => array(
                    'element' => 'custom_fonts',
                    'value' => 'true',
                ),
                'group' => esc_html__( 'Styling', 'seofy' ),
            ), 
            array(
                'type' => 'seofy_param_heading',
                'heading' => esc_html__('Desktops typography settings', 'seofy'),
                'param_name' => 'h_responsive_elements',
                'group' => esc_html__( 'Responsive', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-12',
            ),
            array(
                'type' => 'wgl_checkbox',
                'heading' => esc_html__( 'Desktops', 'seofy' ),
                'param_name' => 'responsive_font_desktop',
                'group' => esc_html__( 'Responsive', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-2',
            ),
            array( 
                'type' => 'textfield',
                'heading' => esc_html__('Font Size Desktops', 'seofy'),
                'param_name' => 'font_size_desktop',
                'description' => esc_html__( 'Enter font-size in pixels.', 'seofy' ),
                'group' => esc_html__( 'Responsive', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-5',
                'dependency' => array(
                    'element' => 'responsive_font_desktop',
                    'value' => 'true'
                ),
            ),
            array(
                'type' => 'textfield',
                'heading' => esc_html__('Line Height Desktops', 'seofy'),
                'param_name' => 'line_height_desktop',
                'value' => $main_font['line-height'],
                'description' => esc_html__( 'Enter line height in px.', 'seofy' ),
                'group' => esc_html__( 'Responsive', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-5',
                'dependency' => array(
                    'element' => 'responsive_font_desktop',
                    'value' => 'true'
                ),
            ),
            array(
                'type' => 'seofy_param_heading',
                'heading' => esc_html__('Tablet typography settings', 'seofy'),
                'param_name' => 'h_responsive_elements_talet',
                'group' => esc_html__( 'Responsive', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-12',
            ),
            array(
                'type' => 'wgl_checkbox',
                'heading' => esc_html__( 'Tablet', 'seofy' ),
                'param_name' => 'responsive_font_tablet',
                'group' => esc_html__( 'Responsive', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-2',
            ),
            array(
                'type' => 'textfield',
                'heading' => esc_html__('Font Size for Tablets', 'seofy'),
                'param_name' => 'font_size_tablet',
                'description' => esc_html__( 'Enter font-size in pixels.', 'seofy' ),
                'group' => esc_html__( 'Responsive', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-5',
                'dependency' => array(
                    'element' => 'responsive_font_tablet',
                    'value' => 'true'
                ),
            ),
            array(
                'type' => 'textfield',
                'heading' => esc_html__('Line Height Tablet', 'seofy'),
                'param_name' => 'line_height_tablet',
                'value' => $main_font['line-height'],
                'description' => esc_html__( 'Enter line height in px.', 'seofy' ),
                'group' => esc_html__( 'Responsive', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-5',
                'dependency' => array(
                    'element' => 'responsive_font_tablet',
                    'value' => 'true'
                ),
            ),
            array(
                'type' => 'seofy_param_heading',
                'heading' => esc_html__('Mobile typography settings', 'seofy'),
                'param_name' => 'h_responsive_elements_mobile',
                'group' => esc_html__( 'Responsive', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-12',
            ),
            array(
                'type' => 'wgl_checkbox',
                'heading' => esc_html__( 'Mobile', 'seofy' ),
                'param_name' => 'responsive_font_mobile',
                'group' => esc_html__( 'Responsive', 'seofy' ),
                 'edit_field_class' => 'vc_col-sm-2',
            ),
            array(
                'type' => 'textfield',
                'heading' => esc_html__('Font Size for Mobile', 'seofy'),
                'param_name' => 'font_size_mobile',
                'description' => esc_html__( 'Enter font-size in pixels.', 'seofy' ),
                'group' => esc_html__( 'Responsive', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-5',
                'dependency' => array(
                    'element' => 'responsive_font_mobile',
                    'value' => 'true'
                ),
            ),
            array(
                'type' => 'textfield',
                'heading' => esc_html__('Line Height Mobile', 'seofy'),
                'param_name' => 'line_height_mobile',
                'value' => $main_font['line-height'],
                'description' => esc_html__( 'Enter line height in px.', 'seofy' ),
                'group' => esc_html__( 'Responsive', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-5',
                'dependency' => array(
                    'element' => 'responsive_font_mobile',
                    'value' => 'true'
                ),
            ),              
        )
    ));
    
    if (class_exists('WPBakeryShortCode')) {
        class WPBakeryShortCode_wgl_custom_text extends WPBakeryShortCode {
            
        }
    } 
}
