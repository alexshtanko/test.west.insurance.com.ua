<?php
if ( ! defined( 'ABSPATH' ) ) {
    die( '-1' );
}


if (function_exists('vc_map')) {
// Add list item
    vc_map(array(
        'name' => esc_html__('Spacing', 'seofy'),
        'base' => 'wgl_spacing',
        'class' => 'seofy_spacing',
        'category' => esc_html__('WGL Modules', 'seofy'),
        'icon' => 'wgl_icon_spacing',
        'content_element' => true,
        'description' => esc_html__('Spacing','seofy'),
        'params' => array(
            array(
                'type' => 'textfield',
                'heading' => esc_html__('Spacer Size', 'seofy'),
                'param_name' => 'spacer_size',
                'description' => esc_html__('Enter Spacer units in pixels', 'seofy'),
                'value' => '30px',
                'save_always' => true,
                'admin_label' => true,
            ),
            array(
                'type' => 'seofy_param_heading',
                'heading' => esc_html__('Desktops spacer settings', 'seofy'),
                'param_name' => 'h_responsive_elements',
                'edit_field_class' => 'vc_col-sm-12',
            ),
            array(
                'type' => 'wgl_checkbox',
                'heading' => esc_html__( 'Desktops', 'seofy' ),
                'param_name' => 'responsive_desktop',
                'edit_field_class' => 'vc_col-sm-2',
            ),
            array(
                'type' => 'textfield',
                'heading' => esc_html__('Screen resolution', 'seofy'),
                'param_name' => 'screen_desktops',
                'edit_field_class' => 'vc_col-sm-5',
                'value' => '1024',
                'dependency' => array(
                    'element' => 'responsive_desktop',
                    'value' => 'true'
                ),
            ),           
            array(
                'type' => 'textfield',
                'heading' => esc_html__('Spacer size', 'seofy'),
                'param_name' => 'size_desktops',
                'description' => esc_html__( 'Enter size in pixels.', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-5',
                'dependency' => array(
                    'element' => 'responsive_desktop',
                    'value' => 'true'
                ),
            ),
            array(
                'type' => 'seofy_param_heading',
                'heading' => esc_html__('Tablet spacer settings', 'seofy'),
                'param_name' => 'h_responsive_tablet',
                'edit_field_class' => 'vc_col-sm-12',
            ),
            array(
                'type' => 'wgl_checkbox',
                'heading' => esc_html__( 'Tablet', 'seofy' ),
                'param_name' => 'responsive_tablet',
                'edit_field_class' => 'vc_col-sm-2',
            ),
            array(
                'type' => 'textfield',
                'heading' => esc_html__('Screen resolution', 'seofy'),
                'param_name' => 'screen_tablet',
                'value' => '800',
                'edit_field_class' => 'vc_col-sm-5',
                'dependency' => array(
                    'element' => 'responsive_tablet',
                    'value' => 'true'
                ),
            ),
            array(
                'type' => 'textfield',
                'heading' => esc_html__('Spacer size', 'seofy'),
                'param_name' => 'size_tablet',
                'description' => esc_html__( 'Enter size in pixels.', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-5',
                'dependency' => array(
                    'element' => 'responsive_tablet',
                    'value' => 'true'
                ),
            ),            
            array(
                'type' => 'seofy_param_heading',
                'heading' => esc_html__('Mobile spacer settings', 'seofy'),
                'param_name' => 'h_responsive_tablet',
                'edit_field_class' => 'vc_col-sm-12',
            ),
            array(
                'type' => 'wgl_checkbox',
                'heading' => esc_html__( 'Mobile', 'seofy' ),
                'param_name' => 'responsive_mobile',
                'edit_field_class' => 'vc_col-sm-2',
            ),
            array(
                'type' => 'textfield',
                'heading' => esc_html__('Screen resolution', 'seofy'),
                'param_name' => 'screen_mobile',
                'value' => '480',
                'edit_field_class' => 'vc_col-sm-5',
                'dependency' => array(
                    'element' => 'responsive_mobile',
                    'value' => 'true'
                ),
            ),
            array(
                'type' => 'textfield',
                'heading' => esc_html__('Spacer size', 'seofy'),
                'param_name' => 'size_mobile',
                'description' => esc_html__( 'Enter size in pixels.', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-5',
                'dependency' => array(
                    'element' => 'responsive_mobile',
                    'value' => 'true'
                ),
            ),                    
        )
    ));
    
    if (class_exists('WPBakeryShortCode')) {
        class WPBakeryShortCode_wgl_spacing extends WPBakeryShortCode {
            
        }
    } 
}
