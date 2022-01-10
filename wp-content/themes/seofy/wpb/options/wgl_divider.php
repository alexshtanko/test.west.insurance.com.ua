<?php
if ( ! defined( 'ABSPATH' ) ) {
    die( '-1' );
}

$theme_color = esc_attr(Seofy_Theme_Helper::get_option("theme-custom-color"));

if (function_exists('vc_map')) {
// Add list item
    vc_map(array(
        'name' => esc_html__('Divider', 'seofy'),
        'base' => 'wgl_divider',
        'class' => 'seofy_divider',
        'category' => esc_html__('WGL Modules', 'seofy'),
        'icon' => 'wgl_icon_divider', // need to change
        'content_element' => true,
        'description' => esc_html__('Divider', 'seofy'),
        'params' => array(
            array(
                'type' => 'textfield',
                'heading' => esc_html__('Height', 'seofy'),
                'param_name' => 'height',
                'description' => esc_html__('Enter divider height in pixels', 'seofy'),
                'value' => '2px',
                'save_always' => true,
                'admin_label' => true,
                'edit_field_class' => 'vc_col-sm-12',
            ),
            array(
                'type' => 'textfield',
                'heading' => esc_html__('Width', 'seofy'),
                'param_name' => 'width',
                'description' => esc_html__('Enter divider width', 'seofy'),
                'value' => '100',
                'admin_label' => true,
                'edit_field_class' => 'vc_col-sm-6',
            ),
            array(
                'type' => 'dropdown',
                'heading' => esc_html__( 'Divider Width Units', 'seofy' ),
                'param_name' => 'width_units',
                'value' => array(
                    esc_html__( 'Pixels', 'seofy' )      => 'px',
                    esc_html__( 'Percentages', 'seofy' ) => '%',
                ),
                'description' => esc_html__('Select width units', 'seofy'),
                'std' => '%',
                'edit_field_class' => 'vc_col-sm-6',
            ),
            array(
                'type' => 'dropdown',
                'heading' => esc_html__( 'Divider Alignment', 'seofy' ),
                'param_name' => 'divider_alignment',
                'value' => array(
                    esc_html__( 'Left', 'seofy' )   => 'left',
                    esc_html__( 'Center', 'seofy' ) => 'center',
                    esc_html__( 'Right', 'seofy' )  => 'right',
                ),
            ),
            array(
                'type' => 'colorpicker',
                'heading' => esc_html__( 'Divider Color', 'seofy' ),
                'param_name' => 'divider_color',
                'value' => '#ececec',
                'save_always' => true,
                'description' => esc_html__( 'Choose divider color.', 'seofy' ),
            ),
            array(
                'type' => 'wgl_checkbox',
                'heading' => esc_html__( 'Add Divider Line', 'seofy' ),
                'param_name' => 'add_divider_line',
                'edit_field_class' => 'vc_col-sm-12 no-margin-top',
                'group' => esc_html__( 'Divider Line', 'seofy' ),
            ),
            array(
                'type' => 'dropdown',
                'heading' => esc_html__( 'Divider Line Alignment', 'seofy' ),
                'param_name' => 'divider_line_alignment',
                'value' => array(
                    esc_html__( 'Left', 'seofy' )   => 'left',
                    esc_html__( 'Center', 'seofy' ) => 'center',
                    esc_html__( 'Right', 'seofy' )  => 'right',
                ),
                'dependency' => array(
                    'element' => 'add_divider_line',
                    'value' => 'true'
                ),
                'group' => esc_html__( 'Divider Line', 'seofy' ),
            ),
            array(
                'type' => 'colorpicker',
                'heading' => esc_html__( 'Divider Line Color', 'seofy' ),
                'param_name' => 'divider_line_color',
                'value' => $theme_color,
                'save_always' => true,
                'description' => esc_html__( 'Choose divider line color.', 'seofy' ),
                'dependency' => array(
                    'element' => 'add_divider_line',
                    'value' => 'true'
                ),
                'group' => esc_html__( 'Divider Line', 'seofy' ),
            ),
        )
    ));
    
    if (class_exists('WPBakeryShortCode')) {
        class WPBakeryShortCode_wgl_divider extends WPBakeryShortCode {}
    }
}