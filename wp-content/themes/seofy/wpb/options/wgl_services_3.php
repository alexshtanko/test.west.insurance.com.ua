<?php
if ( ! defined( 'ABSPATH' ) ) {
    die( '-1' );
}

$theme_color = esc_attr(Seofy_Theme_Helper::get_option("theme-custom-color"));
$second_color = esc_attr(Seofy_Theme_Helper::get_option("second-custom-color"));
$theme_gradient = Seofy_Theme_Helper::get_option("theme-gradient");

if (function_exists('vc_map')) {
    // Add button
    vc_map(array(
        'name' => esc_html__('Services 3', 'seofy'),
        'base' => 'wgl_services_3',
        'class' => 'seofy_services_3',
        'category' => esc_html__('WGL Modules', 'seofy'),
        'icon' => 'wgl_icon_services_3',
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
                "type" => "textarea",
                "heading" => esc_html__( 'Content', 'seofy' ),
                "param_name" => "descr",
            ),
            array(
                'type' => 'wgl_checkbox',
                'heading' => esc_html__( 'Add Read More Button', 'seofy' ),
                'param_name' => 'add_read_more',
                'edit_field_class' => 'vc_col-sm-12',
            ),
            array(
                'type' => 'textfield',
                'heading' => esc_html__('Read More Button Text', 'seofy'),
                'param_name' => 'read_more_text',
                'value' => 'Read More',
                'dependency' => array(
                    'element' => 'add_read_more',
                    'value'   => 'true'
                ),
                'edit_field_class' => 'vc_col-sm-4',
            ),
            array(
                'type' => 'vc_link',
                'heading' => esc_html__( 'Link', 'seofy' ),
                'param_name' => 'link',
                'description' => esc_html__('Add link to read more button.', 'seofy'),
                'dependency' => array(
                    'element' => 'add_read_more',
                    'value' => 'true'
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
            array(
                'type' => 'wgl_checkbox',
                'heading' => esc_html__( 'Add Hexagons', 'seofy' ),
                'param_name' => 'add_hexagons',
                'description' => esc_html__( 'Add hexagons around the background', 'seofy' ),
                'group' => esc_html__( 'Icon', 'seofy' ),
                'dependency' => array(
                    'element' => 'icon_type',
                    'value' => array('font','image')
                ),
                'edit_field_class' => 'vc_col-sm-6',
            ),
            array(
                'type' => 'wgl_checkbox',
                'heading' => esc_html__( 'Use Custom Hexagon Colors', 'seofy' ),
                'param_name' => 'hexgon_colors',
                'description' => esc_html__( 'Select custom colors', 'seofy' ),
                'group' => esc_html__( 'Icon', 'seofy' ),
                'dependency' => array(
                    'element' => 'add_hexagons',
                    'value' => 'true',
                ),
                'edit_field_class' => 'vc_col-sm-6',
            ),
            array(
                'type' => 'colorpicker',
                'heading' => esc_html__('Hexagon Color', 'seofy'),
                'param_name' => 'hexagon_color',
                'value' => $theme_color,
                'description' => esc_html__('Select hexagon color', 'seofy'),
                'dependency' => array(
                    'element' => 'hexgon_colors',
                    'value' => 'true'
                ),
                'group' => esc_html__( 'Icon', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-6',
            ),
            array(
                'type' => 'colorpicker',
                'heading' => esc_html__('Hexagon Color 2', 'seofy'),
                'param_name' => 'hexagon_color_2',
                'value' => $second_color,
                'description' => esc_html__('Select hexagon 2 color', 'seofy'),
                'dependency' => array(
                    'element' => 'hexgon_colors',
                    'value' => 'true'
                ),
                'group' => esc_html__( 'Icon', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-6',
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
                'heading' => esc_html__('Custom Content Color', 'seofy'),
                'param_name' => 'h_custom_content_colors',
                'group' => esc_html__( 'Styles', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-12',
            ),
            array(
                'type' => 'wgl_checkbox',
                'heading' => esc_html__( 'Use Custom Content Color', 'seofy' ),
                'param_name' => 'custom_content_color',
                'description' => esc_html__( 'Select custom color', 'seofy' ),
                'group' => esc_html__( 'Styles', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-4',
            ),
            array(
                'type' => 'colorpicker',
                'heading' => esc_html__('Content Color', 'seofy'),
                'param_name' => 'content_color',
                'value' => '#6e6e6e',
                'dependency' => array(
                    'element' => 'custom_content_color',
                    'value' => 'true',
                ),
                'group' => esc_html__( 'Styles', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-6',
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
            // Icon color dropdown
            array(
                'type' => 'dropdown',
                'param_name' => 'icon_color_type',
                'value' => array(
                    esc_html__( 'Color', 'seofy' )    => 'color',
                    esc_html__( 'Gradient', 'seofy' ) => 'gradient',
                ),
                'dependency' => array(
                    'element' => 'custom_icon_color',
                    'value' => 'true'
                ),
                'group' => esc_html__( 'Styles', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-8',
            ),
            // Icon color
            array(
                'type' => 'colorpicker',
                'heading' => esc_html__('Icon Idle Color', 'seofy'),
                'param_name' => 'icon_color_idle',
                'value' => $theme_color,
                'description' => esc_html__('Select custom color.', 'seofy'),
                'dependency' => array(
                    'element' => 'icon_color_type',
                    'value' => 'color'
                ),
                'group' => esc_html__( 'Styles', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-6',
            ),
            // Icon hover color
            array(
                'type' => 'colorpicker',
                'heading' => esc_html__('Icon Gradient From', 'seofy'),
                'param_name' => 'icon_color_hover',
                'value' => $theme_color,
                'description' => esc_html__('Select custom color.', 'seofy'),
                'dependency' => array(
                    'element' => 'icon_color_type',
                    'value' => 'color'
                ),
                'group' => esc_html__( 'Styles', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-6',
            ),
            // Icon gradient start color
            array(
                'type' => 'colorpicker',
                'heading' => esc_html__('Icon Gradient From', 'seofy'),
                'param_name' => 'icon_color_from',
                'value' => $theme_gradient['from'],
                'description' => esc_html__('Select icon gradient color from', 'seofy'),
                'dependency' => array(
                    'element' => 'icon_color_type',
                    'value' => 'gradient'
                ),
                'group' => esc_html__( 'Styles', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-6',
            ),
            // Icon gradient end color
            array(
                'type' => 'colorpicker',
                'heading' => esc_html__('Icon Gradient To', 'seofy'),
                'param_name' => 'icon_color_to',
                'value' => $theme_gradient['to'],
                'description' => esc_html__('Select icon gradient color to', 'seofy'),
                'dependency' => array(
                    'element' => 'icon_color_type',
                    'value' => 'gradient'
                ),
                'group' => esc_html__( 'Styles', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-4',
            ),
            // Read More color checkbox
            array(
                'type' => 'seofy_param_heading',
                'heading' => esc_html__('Custom Read More Colors', 'seofy'),
                'param_name' => 'h_custom_btn_colors',
                'group' => esc_html__( 'Styles', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-12',
                'dependency' => array(
                    'element' => 'add_read_more',
                    'value' => 'true',
                ),
            ),
            array(
                'type' => 'wgl_checkbox',
                'heading' => esc_html__( 'Use Custom Read More Colors', 'seofy' ),
                'param_name' => 'custom_btn_color',
                'description' => esc_html__( 'Select custom colors', 'seofy' ),
                'group' => esc_html__( 'Styles', 'seofy' ),
                'dependency' => array(
                    'element' => 'add_read_more',
                    'value' => 'true',
                ),
                'edit_field_class' => 'vc_col-sm-4',
            ),
            // Read More color
            array(
                'type' => 'colorpicker',
                'heading' => esc_html__('Read More Color', 'seofy'),
                'param_name' => 'btn_color',
                'value' => $theme_color,
                'description' => esc_html__('Select read more color', 'seofy'),
                'dependency' => array(
                    'element' => 'custom_btn_color',
                    'value' => 'true'
                ),
                'group' => esc_html__( 'Styles', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-4',
            ),
            // Read More hover color
            array(
                'type' => 'colorpicker',
                'heading' => esc_html__('Read More Hover Color', 'seofy'),
                'param_name' => 'btn_hover',
                'value' => '#252525',
                'description' => esc_html__('Select read more hover color', 'seofy'),
                'dependency' => array(
                    'element' => 'custom_btn_color',
                    'value' => 'true'
                ),
                'group' => esc_html__( 'Styles', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-4',
            ),
        )
    ));

    if (class_exists('WPBakeryShortCode')) {
        class WPBakeryShortCode_wgl_Services_3 extends WPBakeryShortCode {
        }
    }
}