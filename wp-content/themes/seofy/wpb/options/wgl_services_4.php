<?php
if ( ! defined( 'ABSPATH' ) ) {
    die( '-1' );
}

$theme_color = esc_attr(Seofy_Theme_Helper::get_option("theme-custom-color"));
$theme_gradient = Seofy_Theme_Helper::get_option("theme-gradient");

if (function_exists('vc_map')) {
    // Add button
    vc_map(array(
        'name' => esc_html__('Services 4', 'seofy'),
        'base' => 'wgl_services_4',
        'class' => 'seofy_services_4',
        'category' => esc_html__('WGL Modules', 'seofy'),
        'icon' => 'wgl_icon_services_4',
        'content_element' => true,
        'description' => esc_html__('Add Services','seofy'),
        'params' => array(
            // General
            array(
                "type" => "textfield",
                "heading" => esc_html__( 'Title', 'seofy' ),
                "param_name" => "title",
                'admin_label' => true,
            ),
            array(
                "type" => "textfield",
                "heading" => esc_html__( 'Number', 'seofy' ),
                "param_name" => "number",
            ),
            array(
                "type" => "textfield",
                "heading" => esc_html__( 'Max Width', 'seofy' ),
                "param_name" => "max_width",
                'description' => esc_html__('Enter custom max width in pixels (default: 100%)', 'seofy'),
            ),
            array(
                'type' => 'dropdown',
                "heading" => esc_html__( 'Background Type', 'seofy' ),
                'param_name' => 'bg_type',
                'value' => array(
                    esc_html__( 'Hexagon', 'seofy' )  => 'hex',
                    esc_html__( 'Figure', 'seofy' )  => 'figure',
                ),
                'edit_field_class' => 'vc_col-sm-6',
            ),
            array(
                "type" => "textfield",
                "heading" => esc_html__( 'Figure Border Radius', 'seofy' ),
                "param_name" => "f_radius",
                'edit_field_class' => 'vc_col-sm-6',
                'description' => esc_html__('Enter figure border radius in pixels (default: 50%)', 'seofy'),
                'dependency' => array(
                    'element' => 'bg_type',
                    'value' => 'figure',
                ),
            ),
            array(
                'type' => 'wgl_checkbox',
                'heading' => esc_html__( 'Add Link for Service', 'seofy' ),
                'param_name' => 'add_link',
            ),
            array(
                'type' => 'vc_link',
                'heading' => esc_html__( 'Link', 'seofy' ),
                'param_name' => 'link',
                'description' => esc_html__('Add link to read more button.', 'seofy'),
                'dependency' => array(
                    'element' => 'add_link',
                    'value' => 'true',
                ),
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
                'heading' => esc_html__('Icon Type', 'seofy'),
                'param_name' => 'h_icon_type',
                'group' => esc_html__( 'Icon', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-12 no-top-margin',
            ),
            // Info Box Icon/Image
            array(
                'type' => 'dropdown',
                'param_name' => 'icon_type',
                'value' => array(
                    esc_html__( 'None', 'seofy' )  => 'none',
                    esc_html__( 'Font', 'seofy' )  => 'font',
                    esc_html__( 'Image', 'seofy' ) => 'image',
                ),
                'save_always' => true,
                'group' => esc_html__( 'Icon', 'seofy' ),
            ),
            array(
                'type' => 'dropdown',
                'param_name' => 'icon_font_type',
                'value' => array(
                    esc_html__( 'Flaticon', 'seofy' )    => 'type_flaticon',
                    esc_html__( 'Fontawesome', 'seofy' ) => 'type_fontawesome',
                ),
                'save_always' => true,
                'group' => esc_html__( 'Icon', 'seofy' ),
                'dependency' => array(
                    'element' => 'icon_type',
                    'value' => 'font',
                ),
            ),
            array(
                'type' => 'iconpicker',
                'heading' => esc_html__( 'Icon', 'seofy' ),
                'param_name' => 'icon_fontawesome',
                'value' => 'fa fa-adjust', // default value to backend editor admin_label
                'settings' => array(
                    'emptyIcon' => false,
                    // default true, display an 'EMPTY' icon?
                    'type' => 'fontawesome',
                    'iconsPerPage' => 200,
                    // default 100, how many icons per/page to display, we use (big number) to display all icons in single page
                ),
                'description' => esc_html__( 'Select icon from library.', 'seofy' ),
                'dependency' => array(
                    'element' => 'icon_font_type',
                    'value' => 'type_fontawesome',
                ),
                'group' => esc_html__( 'Icon', 'seofy' ),
            ),
            array(
                'type' => 'iconpicker',
                'heading' => esc_html__( 'Icon', 'seofy' ),
                'param_name' => 'icon_flaticon',
                'value' => '', // default value to backend editor admin_label
                'settings' => array(
                    'emptyIcon' => false,
                    // default true, display an 'EMPTY' icon
                    'type' => 'flaticon',
                    'iconsPerPage' => 200,
                    // default 100, how many icons per/page to display, we use (big number) to display all icons in single page
                ),
                'description' => esc_html__( 'Select icon from library.', 'seofy' ),
                'dependency' => array(
                    'element' => 'icon_font_type',
                    'value' => 'type_flaticon',
                ),
                'group' => esc_html__( 'Icon', 'seofy' ),
            ),
            array(
                'type' => 'attach_image',
                'heading' => esc_html__( 'Image', 'seofy' ),
                'param_name' => 'thumbnail',
                'value' => '',
                'description' => esc_html__( 'Select image from media library.', 'seofy' ),
                'dependency' => array(
                    'element' => 'icon_type',
                    'value' => 'image',
                ),
                'group' => esc_html__( 'Icon', 'seofy' ),
            ),
            // Custom image width
            array(
                'type' => 'textfield',
                'heading' => esc_html__('Custom Image Width', 'seofy'),
                'param_name' => 'custom_image_width',
                'description' => esc_html__( 'Enter image size in pixels.', 'seofy' ),
                'group' => esc_html__( 'Icon', 'seofy' ),
                'dependency' => array(
                    'element' => 'icon_type',
                    'value' => 'image',
                ),
                'edit_field_class' => 'vc_col-sm-12',
            ),
            // Custom icon size
            array(
                'type' => 'textfield',
                'heading' => esc_html__('Custom Icon Size', 'seofy'),
                'param_name' => 'custom_icon_size',
                'description' => esc_html__( 'Enter Icon size in pixels.', 'seofy' ),
                'group' => esc_html__( 'Icon', 'seofy' ),
                'dependency' => array(
                    'element' => 'icon_type',
                    'value' => 'font',
                ),
            ),
            // Styling
            array(
                'type' => 'seofy_param_heading',
                'heading' => esc_html__('Custom Title Color', 'seofy'),
                'param_name' => 'h_custom_colors',
                'group' => esc_html__( 'Styles', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-12 no-top-margin',
            ),
            array(
                'type' => 'wgl_checkbox',
                'heading' => esc_html__( 'Use Custom Title Color', 'seofy' ),
                'param_name' => 'custom_title_color',
                'description' => esc_html__( 'Select custom color', 'seofy' ),
                'group' => esc_html__( 'Styles', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-4',
            ),
            array(
                'type' => 'colorpicker',
                'heading' => esc_html__('Title Color', 'seofy'),
                'param_name' => 'title_color',
                'value' => '#252525',
                'group' => esc_html__( 'Styles', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-6',
                'dependency' => array(
                    'element' => 'custom_title_color',
                    'value' => 'true',
                ),
            ),
            array(
                'type' => 'seofy_param_heading',
                'heading' => esc_html__('Custom Icon Colors', 'seofy'),
                'param_name' => 'h_custom_icon_colors',
                'dependency' => array(
                    'element' => 'icon_type',
                    'value' => 'font',
                ),
                'group' => esc_html__( 'Styles', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-12',
            ),
            // Icon color checkbox
            array(
                'type' => 'wgl_checkbox',
                'heading' => esc_html__( 'Use Custom Icon Colors', 'seofy' ),
                'param_name' => 'custom_icon_color',
                'description' => esc_html__( 'Select custom colors', 'seofy' ),
                'dependency' => array(
                    'element' => 'icon_type',
                    'value' => 'font',
                ),
                'group' => esc_html__( 'Styles', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-4',
            ),
            array(
                'type' => 'colorpicker',
                'heading' => esc_html__('Icon Color', 'seofy'),
                'param_name' => 'icon_color',
                'value' => $theme_color,
                'dependency' => array(
                    'element' => 'custom_icon_color',
                    'value' => 'true',
                ),
                'group' => esc_html__( 'Styles', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-4',
            ),
            array(
                'type' => 'colorpicker',
                'heading' => esc_html__('Icon Hover Color', 'seofy'),
                'param_name' => 'icon_hover_color',
                'value' => $theme_color,
                'dependency' => array(
                    'element' => 'custom_icon_color',
                    'value' => 'true',
                ),
                'group' => esc_html__( 'Styles', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-4',
            ),
            array(
                'type' => 'seofy_param_heading',
                'heading' => esc_html__('Custom Number Color', 'seofy'),
                'param_name' => 'h_custom_number_colors',
                'group' => esc_html__( 'Styles', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-12',
            ),
            array(
                'type' => 'wgl_checkbox',
                'heading' => esc_html__( 'Use Custom Number Color', 'seofy' ),
                'param_name' => 'custom_number_color',
                'description' => esc_html__( 'Select custom color', 'seofy' ),
                'group' => esc_html__( 'Styles', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-4',
            ),
            array(
                'type' => 'colorpicker',
                'heading' => esc_html__('Number Color', 'seofy'),
                'param_name' => 'number_color',
                'value' => '#f4f6fd',
                'dependency' => array(
                    'element' => 'custom_number_color',
                    'value' => 'true',
                ),
                'group' => esc_html__( 'Styles', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-4',
            ),
            array(
                'type' => 'colorpicker',
                'heading' => esc_html__('Number Hover Color', 'seofy'),
                'param_name' => 'number_hover_color',
                'value' => $theme_color,
                'dependency' => array(
                    'element' => 'custom_number_color',
                    'value' => 'true',
                ),
                'group' => esc_html__( 'Styles', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-4',
            ),
            array(
                'type' => 'seofy_param_heading',
                'heading' => esc_html__('Custom Background Color', 'seofy'),
                'param_name' => 'h_custom_bg_colors',
                'group' => esc_html__( 'Styles', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-12',
            ),
            array(
                'type' => 'wgl_checkbox',
                'heading' => esc_html__( 'Use Custom Background Color', 'seofy' ),
                'param_name' => 'custom_bg_color',
                'description' => esc_html__( 'Select custom color', 'seofy' ),
                'group' => esc_html__( 'Styles', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-4',
            ),
            array(
                'type' => 'colorpicker',
                'heading' => esc_html__('Background Color', 'seofy'),
                'param_name' => 'bg_color',
                'value' => '#ffffff',
                'dependency' => array(
                    'element' => 'custom_bg_color',
                    'value' => 'true',
                ),
                'group' => esc_html__( 'Styles', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-4',
            ),
            array(
                'type' => 'colorpicker',
                'heading' => esc_html__('Background Hover Color', 'seofy'),
                'param_name' => 'bg_hover_color',
                'value' => '#f4f6fd',
                'dependency' => array(
                    'element' => 'custom_bg_color',
                    'value' => 'true',
                ),
                'group' => esc_html__( 'Styles', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-4',
            ),
        )
    ));

    if (class_exists('WPBakeryShortCode')) {
        class WPBakeryShortCode_wgl_Services_4 extends WPBakeryShortCode {
        }
    }
}