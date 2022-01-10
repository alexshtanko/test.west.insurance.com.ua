<?php
if ( ! defined( 'ABSPATH' ) ) {
    die( '-1' );
}

$theme_color = esc_attr(Seofy_Theme_Helper::get_option("theme-custom-color"));

if (function_exists('vc_map')) {
    // Add button
    vc_map(array(
        'name' => esc_html__('Services 2', 'seofy'),
        'base' => 'wgl_services_2',
        'class' => 'seofy_services_2',
        'category' => esc_html__('WGL Modules', 'seofy'),
        'icon' => 'wgl_icon_services_2',
        'content_element' => true,
        'description' => esc_html__('Add Services','seofy'),
        'params' => array(
            // General
            array(
                'type' => 'textfield',
                'heading' => esc_html__('Custom Services Height', 'seofy'),
                'param_name' => 'custom_height',
                'value' => '',
                'description' => esc_html__( 'Enter custom services height in pixels.', 'seofy' ),
            ),
            array(
                "type" => "textfield",
                "heading" => esc_html__( 'Title', 'seofy' ),
                "param_name" => "title",
                'admin_label' => true,
            ),
            array(
                "type" => "textfield",
                "heading" => esc_html__( 'Subtitle', 'seofy' ),
                "param_name" => "subtitle",
            ),
            array(
                'type' => 'attach_image',
                'heading' => esc_html__('Logo Image', 'seofy'),
                'param_name' => 'logo_image',
                'description' => esc_html__( 'Select image from media library.', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-6',
            ),
            array(
                'type' => 'attach_image',
                'heading' => esc_html__('Background Image', 'seofy'),
                'param_name' => 'bg_image',
                'description' => esc_html__( 'Select image from media library.', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-6',
            ),
            array(
                'type' => 'vc_link',
                'heading' => esc_html__( 'Link', 'seofy' ),
                'param_name' => 'link',
                'description' => esc_html__('Add link to Service.', 'seofy')
            ),
            vc_map_add_css_animation( true ),
            array(
                'type' => 'textfield',
                'heading' => esc_html__('Extra Class', 'seofy'),
                'param_name' => 'item_el_class',
                'description' => esc_html__('If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'seofy')
            ),
            array(
                'type' => 'seofy_param_heading',
                'heading' => esc_html__('Custom Colors', 'seofy'),
                'param_name' => 'h_custom_colors',
                'group' => esc_html__( 'Styles', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-12 no-top-margin',
            ),
            array(
                'type' => 'colorpicker',
                'heading' => esc_html__('Title Color', 'seofy'),
                'param_name' => 'title_color',
                'value' => $theme_color,
                'group' => esc_html__( 'Styles', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-6',
            ),
            array(
                'type' => 'colorpicker',
                'heading' => esc_html__('Subtitle Color', 'seofy'),
                'param_name' => 'subtitle_color',
                'value' => '#ffffff',
                'group' => esc_html__( 'Styles', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-6',
            ),
        )
    ));

    if (class_exists('WPBakeryShortCode')) {
        class WPBakeryShortCode_wgl_Services_2 extends WPBakeryShortCode {
        }
    }
}