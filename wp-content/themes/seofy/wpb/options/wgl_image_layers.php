<?php
if ( ! defined( 'ABSPATH' ) ) {
    die( '-1' );
}

if (function_exists('vc_map')) {
    vc_map(array(
        'name' => esc_html__('Image Layers', 'seofy'),
        'base' => 'wgl_image_layers',
        'class' => 'seofy_image_layers',
        'category' => esc_html__('WGL Modules', 'seofy'),
        'icon' => 'wgl_icon_image_layers',
        'content_element' => true,
        'description' => esc_html__('Display Image Layers','seofy'),
        'params' => array(
            // image styles heading
            array(
                'type' => 'seofy_param_heading',
                'heading' => esc_html__('Layers Settings', 'seofy'),
                'param_name' => 'h_settings',
                'edit_field_class' => 'vc_col-sm-12 no-top-margin',
            ),
            array(
                'type' => 'param_group',
                'heading' => esc_html__( 'Values', 'seofy' ),
                'param_name' => 'values',
                'description' => esc_html__( 'Enter values for graph', 'seofy' ),
                'params' => array(
                    array(
                        'type'          => 'attach_image',
                        'heading'       => esc_html__( 'Thumbnail', 'seofy' ),
                        'param_name'    => 'thumbnail',
                    ),
                    array(
                        'type'          => 'textfield',
                        'heading'       => esc_html__( 'Top Offset', 'seofy' ),
                        'param_name'    => 'top_offset',
                        'edit_field_class' => 'vc_col-sm-6',
                        'description' => esc_html__( 'Enter offset in %, for example -100% or 100%', 'seofy' ),
                    ),
                    array(
                        'type'          => 'textfield',
                        'heading'       => esc_html__( 'Left Offset', 'seofy' ),
                        'param_name'    => 'left_offset',
                        'edit_field_class' => 'vc_col-sm-6',
                        'description' => esc_html__( 'Enter offset in %, for example -100% or 100%', 'seofy' ),
                    ),          
                    array(
                        'type'          => 'dropdown',
                        'heading'       => esc_html__( 'Image Animation', 'seofy' ),
                        'param_name'    => 'image_animation',
                        'edit_field_class' => 'vc_col-sm-6',
                        'value'         => array(
                            esc_html__( 'Fade In', 'seofy' )      => 'fade_in',
                            esc_html__( 'Slide Up', 'seofy' )      => 'slide_up',
                            esc_html__( 'Slide Down', 'seofy' )     => 'slide_down',
                            esc_html__( 'Slide Left', 'seofy' )     => 'slide_left',
                            esc_html__( 'Slide Right', 'seofy' )     => 'slide_right',
                            esc_html__( 'Slide Big Up', 'seofy' )      => 'slide_big_up',
                            esc_html__( 'Slide Big Down', 'seofy' )     => 'slide_big_down',
                            esc_html__( 'Slide Big Left', 'seofy' )     => 'slide_big_left',
                            esc_html__( 'Slide Big Right', 'seofy' )     => 'slide_big_right',
                            esc_html__( 'Slide Big Right', 'seofy' )     => 'slide_big_right',
                            esc_html__( 'Flip Horizontally', 'seofy' )     => 'flip_x',
                            esc_html__( 'Flip Vertically', 'seofy' )     => 'flip_y',
                            esc_html__( 'Zoom In', 'seofy' )     => 'zoom_in',
                        ),
                    ),         
                    array(
                        'type'          => 'textfield',
                        'heading'       => esc_html__( 'Image z-index', 'seofy' ),
                        'param_name'    => 'image_order',
                        'value'         => '1',
                        'edit_field_class' => 'vc_col-sm-6',
                    ),  
                ),
            ),
            // images interval
            array(
                'type' => 'textfield',
                'heading' => esc_html__('Enter Interval Images Appearing', 'seofy'),
                'param_name' => 'interval',
                'value' => '600',
                'description' => esc_html__( 'Enter interval in milliseconds', 'seofy' ),
            ),
            array(
                'type' => 'textfield',
                'heading' => esc_html__('Enter Transition Speed', 'seofy'),
                'param_name' => 'transition',
                'value' => '800',
                'description' => esc_html__( 'Enter transition speed in milliseconds', 'seofy' ),
            ),
            array(
                'type' => 'vc_link',
                'heading' => esc_html__( 'Link', 'seofy' ),
                'param_name' => 'link',
                'description' => esc_html__('Add link to button.', 'seofy')
            ),
            array(
                'type' => 'textfield',
                'heading' => esc_html__('Extra Class', 'seofy'),
                'param_name' => 'extra_class',
                'description' => esc_html__('Add an extra class name to the element and refer to it from Custom CSS option.', 'seofy')
            ),
        )
    ));

    if (class_exists('WPBakeryShortCode')) {
        class WPBakeryShortCode_wgl_Image_Layers extends WPBakeryShortCode {
        }
    }
}
