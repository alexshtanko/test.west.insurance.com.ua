<?php

$theme_color = esc_attr(Seofy_Theme_Helper::get_option("theme-custom-color"));

if (function_exists('vc_map')) {
    vc_map(array(		
		
        'base' => 'wgl_carousel',
        'name' => esc_html__('Carousel', 'seofy'),
		'class' => 'seofy_carousel_module',
        'content_element' => true,      
        'category' => esc_html__('WGL Modules', 'seofy'),
        'icon' => 'wgl_icon_carousel',
        'show_settings_on_create' => true,
        'is_container' => true,
		'as_parent' => array('only' => 'wgl_counter, wgl_button, vc_column_text, wgl_pricing_table, wgl_info_box, wgl_custom_text, vc_single_image, vc_tta_tabs, vc_tta_tour, vc_tta_accordion, vc_images_carousel, vc_gallery, vc_message, vc_row, wgl_flip_box'),
        'params' => array(
            array(
                'type' => 'dropdown',
                'heading' => esc_html__('Carousel Columns', 'seofy'),
                'admin_label' => true,
                'param_name' => 'slide_to_show',
                'value' => array(
                    esc_html__('1', 'seofy') => '1',
                    esc_html__('2', 'seofy') => '2',
                    esc_html__('3', 'seofy') => '3',
                    esc_html__('4', 'seofy') => '4',
                    esc_html__('5', 'seofy') => '5',
                    esc_html__('6', 'seofy') => '6',
                )
            ),
            array(
                'type' => 'textfield',
                'heading' => esc_html__( 'Speed', 'seofy' ),
                'param_name' => 'speed',
                'value' => '300',
                'description' => esc_html__( 'Animation speed(ms)', 'seofy' ),
            ),              
            array(
                'type' => 'wgl_checkbox',
                'heading' => esc_html__( 'Autoplay', 'seofy' ),
                'param_name' => 'autoplay',
                'value' => array( esc_html__( 'Yes', 'seofy' ) => 'yes' ),
                'edit_field_class' => 'vc_col-sm-4',
                'std' => 'yes'
            ),
            array(
                "type"          => "textfield",
                "heading"       => esc_html__( 'Autoplay Speed', 'seofy' ),
                "param_name"    => "autoplay_speed",
                "dependency"    => array(
                    "element"   => "autoplay",
                    "value" => 'true'
                ),
                'edit_field_class' => 'vc_col-sm-4',
                "value"         => "3000",
                'group' => esc_html__( 'Carousel', 'seofy' ),
            ),                 
            array(
                'type' => 'wgl_checkbox',
                'heading' => esc_html__( 'Adaptive', 'seofy' ),
                'param_name' => 'adaptive_height',
                'edit_field_class' => 'vc_col-sm-4',
                'dependency' => array(
                    'element' => 'slide_to_show',
                    'value' => array('1'),
                ),
            ),     

            array(
                'type' => 'wgl_checkbox',
                'heading' => esc_html__( 'Slide One Item by Click', 'seofy' ),
                'param_name' => 'slides_to_scroll',
                'edit_field_class' => 'vc_col-sm-4',
            ),
            array(
                'type' => 'wgl_checkbox',
                'heading' => esc_html__( 'Infinite loop sliding', 'seofy' ),
                'param_name' => 'infinite',
                'edit_field_class' => 'vc_col-sm-4',
            ),

            vc_map_add_css_animation( true ),
            // carousel pagination heading
            array(
                'type' => 'seofy_param_heading',
                'heading' => esc_html__('Pagination Controls', 'seofy'),
                'param_name' => 'h_pag_controls',
                'group' => esc_html__( 'Navigation', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-12 no-top-margin',
            ),
            array(
                'type' => 'wgl_checkbox',
                'heading' => esc_html__( 'Add Pagination control', 'seofy' ),
                'param_name' => 'use_pagination',
                'edit_field_class' => 'vc_col-sm-12 no-top-margin',
                'group' => esc_html__( 'Navigation', 'seofy' ),
                'std' => 'true'
            ),
            array(
                'type' => 'seofy_radio_image',
                'heading' => esc_html__('Pagination Type', 'seofy'),
                'param_name' => 'pag_type',
                'fields' => array(
                    'circle' => array(
                        'image_url' => get_template_directory_uri() . '/img/wgl_composer_addon/icons/pag_circle.png',
                        'label' => esc_html__('Circle', 'seofy')),
                    'circle_border' => array(
                        'image_url' => get_template_directory_uri() . '/img/wgl_composer_addon/icons/pag_circle_border.png',
                        'label' => esc_html__('Empty Circle', 'seofy')),
                    'square' => array(
                        'image_url' => get_template_directory_uri() . '/img/wgl_composer_addon/icons/pag_square.png',
                        'label' => esc_html__('Square', 'seofy')),
                    'line' => array(
                        'image_url' => get_template_directory_uri() . '/img/wgl_composer_addon/icons/pag_line.png',
                        'label' => esc_html__('Line', 'seofy')),
                    'line_circle' => array(
                        'image_url' => get_template_directory_uri() . '/img/wgl_composer_addon/icons/pag_line_circle.png',
                        'label' => esc_html__('Line - Circle', 'seofy')),
                ),
                'group' => esc_html__( 'Navigation', 'seofy' ),
                'dependency' => array(
                    'element' => 'use_pagination',
                    'value' => 'true',
                ),
                'value' => 'circle',
            ),
            array(
                'type' => 'textfield',
                'heading' => esc_html__( 'Pagination Top Offset', 'seofy' ),
                'param_name' => 'pag_offset',
                'value' => '',
                'group' => esc_html__( 'Navigation', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-6',
                'description' => esc_html__( 'Enter pagination top offset in pixels.', 'seofy' ),
                'dependency' => array(
                    'element' => 'use_pagination',
                    'value' => 'true',
                ),
            ),
            array(
                'type' => 'dropdown',
                'heading' => esc_html__('Pagination Aligning', 'seofy'),
                'param_name' => 'pag_align',
                'value' => array(
                    esc_html__('Left', 'seofy') => 'left',
                    esc_html__('Right', 'seofy') => 'right',
                    esc_html__('Center', 'seofy') => 'center',
                ),
                'dependency' => array(
                    'element' => 'use_pagination',
                    'value' => 'true',
                ),
                'edit_field_class' => 'vc_col-sm-6',
                'std' => 'center',
                'group' => esc_html__( 'Navigation', 'seofy' ),
            ),
            array(
                'type' => 'wgl_checkbox',
                'heading' => esc_html__( 'Custom Pagination Color', 'seofy' ),
                'param_name' => 'custom_pag_color',
                'edit_field_class' => 'vc_col-sm-6',
                'group' => esc_html__( 'Navigation', 'seofy' ),
                'dependency' => array(
                    'element' => 'use_pagination',
                    'value' => 'true',
                ),
            ),
            array(
                'type' => 'colorpicker',
                'heading' => esc_html__('Pagination Color', 'seofy'),
                'param_name' => 'pag_color',
                'value' => $theme_color,
                'dependency' => array(
                    'element' => 'custom_pag_color',
                    'value' => 'true'
                ),
                'group' => esc_html__( 'Navigation', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-6',
            ),
            // carousel prev/next heading
            array(
                'type' => 'seofy_param_heading',
                'heading' => esc_html__('Prev/Next Buttons', 'seofy'),
                'param_name' => 'h_buttons',
                'group' => esc_html__( 'Navigation', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-12',
            ),
            array(
                'type' => 'wgl_checkbox',
                'heading' => esc_html__( 'Add Prev/Next buttons', 'seofy' ),
                'param_name' => 'use_prev_next',
                'edit_field_class' => 'vc_col-sm-12',
                'group' => esc_html__( 'Navigation', 'seofy' ),
            ),            
            array(
                'type' => 'wgl_checkbox',
                'heading' => esc_html__( 'Custom offset', 'seofy' ),
                'param_name' => 'custom_offeset_prev_next',
                'edit_field_class' => 'vc_col-sm-12',
                'group' => esc_html__( 'Navigation', 'seofy' ),
                 'dependency' => array(
                    'element' => 'use_prev_next',
                    'value' => 'true',
                ),
            ),
            array(
                'type' => 'textfield',
                'heading' => esc_html__( 'Pagination Top Offset', 'seofy' ),
                'param_name' => 'buttons_offset',
                'value' => '50%',
                'group' => esc_html__( 'Navigation', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-8',
                'description' => esc_html__( 'Enter buttons top offset in percentages.', 'seofy' ),
                'dependency' => array(
                    'element' => 'custom_offeset_prev_next',
                    'value' => 'true',
                ),
            ),
            array(
                'type' => 'seofy_param_heading',
                'param_name' => 'h_buttons',
                'group' => esc_html__( 'Navigation', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-12 no-top-margin',
                'dependency' => array(
                    'element' => 'use_prev_next',
                    'value' => 'true',
                ),
            ),
            array(
                'type' => 'wgl_checkbox',
                'heading' => esc_html__( 'Custom Buttons Color', 'seofy' ),
                'param_name' => 'custom_buttons_color',
                'edit_field_class' => 'vc_col-sm-4',
                'group' => esc_html__( 'Navigation', 'seofy' ),
                'dependency' => array(
                    'element' => 'use_prev_next',
                    'value' => 'true',
                ),
            ),
            array(
                'type' => 'colorpicker',
                'heading' => esc_html__('Prev/Next Buttons Color', 'seofy'),
                'param_name' => 'buttons_color',
                'value' => $theme_color,
                'dependency' => array(
                    'element' => 'custom_buttons_color',
                    'value' => 'true'
                ),
                'group' => esc_html__( 'Navigation', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-4',
            ),
            array(
                'type' => 'colorpicker',
                'heading' => esc_html__('Buttons Background Color', 'seofy'),
                'param_name' => 'buttons_bg_color',
                'value' => '#ffffff',
                'dependency' => array(
                    'element' => 'custom_buttons_color',
                    'value' => 'true'
                ),
                'group' => esc_html__( 'Navigation', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-4',
            ),
            array(
                'type' => 'wgl_checkbox',
                'heading' => esc_html__( 'Customize Responsive', 'seofy' ),
                'param_name' => 'custom_resp',
                'edit_field_class' => 'vc_col-sm-12 no-top-margin',
                'group' => esc_html__( 'Responsive', 'seofy' ),
            ),
            // medium desktop
            array(
                'type' => 'seofy_param_heading',
                'heading' => esc_html__('Medium Desktop', 'seofy'),
                'param_name' => 'h_resp_medium',
                'group' => esc_html__( 'Responsive', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-12',
                'dependency' => array(
                    'element' => 'custom_resp',
                    'value' => 'true',
                ),
            ),
            array(
                'type' => 'textfield',
                'heading' => esc_html__( 'Screen resolution', 'seofy' ),
                'param_name' => 'resp_medium',
                'value' => '1025',
                'group' => esc_html__( 'Responsive', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-6',
                'dependency' => array(
                    'element' => 'custom_resp',
                    'value' => 'true',
                ),
            ),
            array(
                'type' => 'textfield',
                'heading' => esc_html__( 'Slides to show', 'seofy' ),
                'param_name' => 'resp_medium_slides',
                'value' => '',
                'group' => esc_html__( 'Responsive', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-6',
                'dependency' => array(
                    'element' => 'custom_resp',
                    'value' => 'true',
                ),
            ),
            
            // tablets
            array(
                'type' => 'seofy_param_heading',
                'heading' => esc_html__('Tablets', 'seofy'),
                'param_name' => 'h_resp_tablets',
                'group' => esc_html__( 'Responsive', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-12',
                'dependency' => array(
                    'element' => 'custom_resp',
                    'value' => 'true',
                ),
            ),
            array(
                'type' => 'textfield',
                'heading' => esc_html__( 'Screen resolution', 'seofy' ),
                'param_name' => 'resp_tablets',
                'value' => '800',
                'group' => esc_html__( 'Responsive', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-6',
                'dependency' => array(
                    'element' => 'custom_resp',
                    'value' => 'true',
                ),
            ),
            array(
                'type' => 'textfield',
                'heading' => esc_html__( 'Slides to show', 'seofy' ),
                'param_name' => 'resp_tablets_slides',
                'value' => '',
                'group' => esc_html__( 'Responsive', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-6',
                'dependency' => array(
                    'element' => 'custom_resp',
                    'value' => 'true',
                ),
            ),
            // mobile phones
            array(
                'type' => 'seofy_param_heading',
                'heading' => esc_html__('Mobile Phones', 'seofy'),
                'param_name' => 'h_resp_mobile',
                'group' => esc_html__( 'Responsive', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-12',
                'dependency' => array(
                    'element' => 'custom_resp',
                    'value' => 'true',
                ),
            ),
            array(
                'type' => 'textfield',
                'heading' => esc_html__( 'Screen resolution', 'seofy' ),
                'param_name' => 'resp_mobile',
                'value' => '480',
                'group' => esc_html__( 'Responsive', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-6',
                'dependency' => array(
                    'element' => 'custom_resp',
                    'value' => 'true',
                ),
            ),
            array(
                'type' => 'textfield',
                'heading' => esc_html__( 'Slides to show', 'seofy' ),
                'param_name' => 'resp_mobile_slides',
                'value' => '',
                'group' => esc_html__( 'Responsive', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-6',
                'dependency' => array(
                    'element' => 'custom_resp',
                    'value' => 'true',
                ),
            ),
            array(
                'type' => 'textfield',
                'heading' => esc_html__('Extra Class', 'seofy'),
                'param_name' => 'extra_class',
                'description' => esc_html__('Add an extra class name to the element and refer to it from Custom CSS option.', 'seofy')
            )			
        ),
		'js_view' => 'VcColumnView'
    ));


    if (class_exists('WPBakeryShortCodesContainer')) {
        class WPBakeryShortCode_wgl_carousel extends WPBakeryShortCodesContainer {}
    }
}