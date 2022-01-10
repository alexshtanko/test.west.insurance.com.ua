<?php
if ( ! defined( 'ABSPATH' ) ) {
    die( '-1' );
}

if (function_exists('vc_map')) {
    vc_map(array(
        'name' => esc_html__('Clients', 'seofy'),
        'base' => 'wgl_clients',
        'class' => 'seofy_clients',
        'category' => esc_html__('WGL Modules', 'seofy'),
        'icon' => 'wgl_icon_clients',
        'content_element' => true,
        'description' => esc_html__('Display Clients','seofy'),
        'params' => array(
            array(
                'type' => 'param_group',
                'heading' => esc_html__( 'Values', 'seofy' ),
                'param_name' => 'values',
                'description' => esc_html__( 'Enter values for graph - thumbnail, quote, author name and author status.', 'seofy' ),
                'params' => array(
                    array(
                        "type" => "attach_image",
                        "heading" => esc_html__( 'Thumbnail', 'seofy' ),
                        "param_name" => "thumbnail",
                        'edit_field_class' => 'vc_col-sm-6',
                    ),
                    array(
                        'type' => 'attach_image',
                        'heading' => esc_html__( 'Hover Thumbnail', 'seofy' ),
                        'param_name' => 'hover_thumbnail',
                        'edit_field_class' => 'vc_col-sm-6 no-top-padding',
                        'description' => esc_html__( 'Work only with Exchange Images animation.', 'seofy' ),
                    ),
                    array(
                        'type' => 'wgl_checkbox',
                        'heading' => esc_html__( 'Add Link', 'seofy' ),
                        'param_name' => 'add_link',
                        'edit_field_class' => 'vc_col-sm-12',
                    ),
                    array(
                        'type' => 'vc_link',
                        'heading' => esc_html__( 'Link', 'seofy' ),
                        'param_name' => 'link',
                        'description' => esc_html__('Add link to client image.', 'seofy'),
                        "dependency" => array(
                            "element" => "add_link",
                            "value" => 'true'
                        ),
                    ),
                ),
            ),
            array(
                "type" => "dropdown",
                "heading" => esc_html__( 'Clients Grid', 'seofy' ),
                "param_name" => "item_grid",
                "value" => array(
                    esc_html__( 'One Column', 'seofy' )    => '1',
                    esc_html__( 'Two Columns', 'seofy' )   => '2',
                    esc_html__( 'Three Columns', 'seofy' ) => '3',
                    esc_html__( 'Four Columns', 'seofy' )  => '4',
                    esc_html__( 'Five Columns', 'seofy' )  => '5',
                    esc_html__( 'Six Columns', 'seofy' )   => '6',
                ),
                'std' => '4',
                'edit_field_class' => 'vc_col-sm-6',
            ),
            array(
                "type" => "dropdown",
                "heading" => esc_html__( 'Clients Animation for each Image', 'seofy' ),
                "param_name" => "item_anim",
                "value" => array(
                    esc_html__( 'Zoom', 'seofy' )            => 'zoom',
                    esc_html__( 'Grayscale', 'seofy' )       => 'grayscale',
                    esc_html__( 'Opacity', 'seofy' )         => 'opacity',
                    esc_html__( 'Shadow', 'seofy' )          => 'shadow',
                    esc_html__( 'Contrast', 'seofy' )        => 'contrast',
                    esc_html__( 'Blur', 'seofy' )            => 'blur',
                    esc_html__( 'Invert', 'seofy' )          => 'invert',
                    esc_html__( 'Exchange Images', 'seofy' ) => 'ex_images',
                ),       
                'edit_field_class' => 'vc_col-sm-6',
            ),
            vc_map_add_css_animation( true ),
            array(
                'type' => 'textfield',
                'heading' => esc_html__('Extra Class', 'seofy'),
                'param_name' => 'extra_class',
                'description' => esc_html__('Add an extra class name to the element and refer to it from Custom CSS option.', 'seofy')
            ),
            // carousel heading
            array(
                'type' => 'seofy_param_heading',
                'heading' => esc_html__('Add Carousel for Clients Items', 'seofy'),
                'param_name' => 'h_carousel',
                'group' => esc_html__( 'Carousel', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-12 no-top-margin',
            ),
            array(
                "type"          => "wgl_checkbox",
                'heading' => esc_html__( 'Use Carousel', 'seofy' ),
                "param_name"    => "use_carousel",
                'edit_field_class' => 'vc_col-sm-4',
                'group' => esc_html__( 'Carousel', 'seofy' ),
            ),
            array(
                "type"          => "wgl_checkbox",
                'heading' => esc_html__( 'Autoplay', 'seofy' ),
                "param_name"    => "autoplay",
                "dependency"    => array(
                    "element"   => "use_carousel",
                    "value" => 'true'
                ),
                'edit_field_class' => 'vc_col-sm-4',
                'group' => esc_html__( 'Carousel', 'seofy' ),
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
            // carousel pagination heading
            array(
                'type' => 'seofy_param_heading',
                'heading' => esc_html__('Responsive', 'seofy'),
                'param_name' => 'h_resp',
                'group' => esc_html__( 'Carousel', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-12',
                "dependency"    => array(
                    "element"   => "use_carousel",
                    "value" => 'true'
                ),
            ),
            array(
                'type' => 'wgl_checkbox',
                'heading' => esc_html__( 'Customize Responsive', 'seofy' ),
                'param_name' => 'custom_resp',
                "dependency"    => array(
                    "element"   => "use_carousel",
                    "value" => 'true'
                ),
                'edit_field_class' => 'vc_col-sm-12 no-top-margin',
                'group' => esc_html__( 'Carousel', 'seofy' ),
            ),
            // medium desktop
            array(
                'type' => 'seofy_param_heading',
                'heading' => esc_html__('Medium Desktop', 'seofy'),
                'param_name' => 'h_resp_medium',
                'group' => esc_html__( 'Carousel', 'seofy' ),
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
                'group' => esc_html__( 'Carousel', 'seofy' ),
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
                'group' => esc_html__( 'Carousel', 'seofy' ),
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
                'group' => esc_html__( 'Carousel', 'seofy' ),
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
                'group' => esc_html__( 'Carousel', 'seofy' ),
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
                'group' => esc_html__( 'Carousel', 'seofy' ),
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
                'group' => esc_html__( 'Carousel', 'seofy' ),
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
                'group' => esc_html__( 'Carousel', 'seofy' ),
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
                'group' => esc_html__( 'Carousel', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-6',
                'dependency' => array(
                    'element' => 'custom_resp',
                    'value' => 'true',
                ),
            ),
        )
    ));

    if (class_exists('WPBakeryShortCode')) {
        class WPBakeryShortCode_wgl_Clients extends WPBakeryShortCode {
        }
    }
}
