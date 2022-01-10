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
        'name' => esc_html__('Circuit Services', 'seofy'),
        'base' => 'wgl_circuit_services',
        'class' => 'seofy_circuit_services',
        'category' => esc_html__('WGL Modules', 'seofy'),
        'icon' => 'wgl_icon_circuit_services',
        'content_element' => true,
        'description' => esc_html__('Add Services','seofy'),
        'params' => array(
            // General
			array(
				'type' => 'param_group',
				'heading' => esc_html__( 'Values', 'seofy' ),
				'param_name' => 'values',
                'save_always' => true,
				'params' => array(
                    array(
                        'type' => 'dropdown',
                        'param_name' => 'icon_font_type',
                        'value' => array(
                            esc_html__( 'Flaticon', 'seofy' )    => 'type_flaticon',
                            esc_html__( 'Fontawesome', 'seofy' ) => 'type_fontawesome',
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
                    ),
                    array(
                        'type' => 'iconpicker',
                        'heading' => esc_html__( 'Icon', 'seofy' ),
                        'param_name' => 'icon_flaticon',
                        'value' => 'fa fa-adjust', // default value to backend editor admin_label
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
						"type" => "textarea",
						"heading" => esc_html__( 'Description', 'seofy' ),
						"param_name" => "descr",
					),
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
                'heading' => esc_html__('Icons Colors', 'seofy'),
                'param_name' => 'h_icon_type',
                'group' => esc_html__( 'Icons Styles', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-12 no-top-margin',
            ),
            // Icon color dropdown
            array(
                'type' => 'dropdown',
                'param_name' => 'icon_color_type',
                'value' => array(
                    esc_html__( 'Default', 'seofy' )    => 'def',
                    esc_html__( 'Color', 'seofy' )    => 'color',
                    esc_html__( 'Gradient', 'seofy' ) => 'gradient',
                ),
                'group' => esc_html__( 'Icons Styles', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-12',
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
                'group' => esc_html__( 'Icons Styles', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-6',
            ),
            // Icon hover color
            array(
                'type' => 'colorpicker',
                'heading' => esc_html__('Icon Color Hover', 'seofy'),
                'param_name' => 'icon_color_hover',
                'value' => $theme_color,
                'description' => esc_html__('Select custom color.', 'seofy'),
                'dependency' => array(
                    'element' => 'icon_color_type',
                    'value' => 'color'
                ),
                'group' => esc_html__( 'Icons Styles', 'seofy' ),
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
                'group' => esc_html__( 'Icons Styles', 'seofy' ),
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
                'group' => esc_html__( 'Icons Styles', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-4',
            ),
            // Icon gradient start color
            array(
                'type' => 'colorpicker',
                'heading' => esc_html__('Icon Hover Gradient From', 'seofy'),
                'param_name' => 'icon_hover_color_from',
                'value' => $theme_gradient['to'],
                'description' => esc_html__('Select icon gradient color from', 'seofy'),
                'dependency' => array(
                    'element' => 'icon_color_type',
                    'value' => 'gradient'
                ),
                'group' => esc_html__( 'Icons Styles', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-6',
            ),
            // Icon gradient end color
            array(
                'type' => 'colorpicker',
                'heading' => esc_html__('Icon Hover Gradient To', 'seofy'),
                'param_name' => 'icon_hover_color_to',
                'value' => $theme_gradient['from'],
                'description' => esc_html__('Select icon gradient color to', 'seofy'),
                'dependency' => array(
                    'element' => 'icon_color_type',
                    'value' => 'gradient'
                ),
                'group' => esc_html__( 'Icons Styles', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-4',
            ),
            // Custom icon size
            array(
                'type' => 'seofy_param_heading',
                'heading' => esc_html__('Custom Icon Size', 'seofy'),
                'param_name' => 'h_size_icon_type',
                'group' => esc_html__( 'Icons Styles', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-12',
            ),
            array(
                'type' => 'textfield',
                'heading' => esc_html__('Custom Icon Size', 'seofy'),
                'param_name' => 'custom_icon_size',
                'description' => esc_html__( 'Enter Icon size in pixels (default 50px)', 'seofy' ),
                'group' => esc_html__( 'Icons Styles', 'seofy' ),
                'dependency' => array(
                    'element' => 'icon_type',
                    'value' => 'font',
                ),
            ),
            array(
                'type' => 'seofy_param_heading',
                'heading' => esc_html__('Icons Background Colors', 'seofy'),
                'param_name' => 'h_bg_icon_type',
                'group' => esc_html__( 'Icons Styles', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-12',
            ),
            // Icon color dropdown
            array(
                'type' => 'dropdown',
                'param_name' => 'bg_color_type',
                'value' => array(
                    esc_html__( 'Default', 'seofy' )    => 'def',
                    esc_html__( 'Color', 'seofy' )    => 'color',
                    esc_html__( 'Gradient', 'seofy' ) => 'gradient',
                ),
                'group' => esc_html__( 'Icons Styles', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-12',
            ),
            // Icon color
            array(
                'type' => 'colorpicker',
                'heading' => esc_html__('Background Idle Color', 'seofy'),
                'param_name' => 'bg_color_idle',
                'value' => '#ffffff',
                'description' => esc_html__('Select custom color.', 'seofy'),
                'dependency' => array(
                    'element' => 'bg_color_type',
                    'value' => 'color'
                ),
                'group' => esc_html__( 'Icons Styles', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-6',
            ),
            // Icon hover color
            array(
                'type' => 'colorpicker',
                'heading' => esc_html__('Background Color Hover', 'seofy'),
                'param_name' => 'bg_color_hover',
                'value' => $second_color,
                'description' => esc_html__('Select custom color.', 'seofy'),
                'dependency' => array(
                    'element' => 'bg_color_type',
                    'value' => 'color'
                ),
                'group' => esc_html__( 'Icons Styles', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-6',
            ),
            // Icon gradient start color
            array(
                'type' => 'colorpicker',
                'heading' => esc_html__('Background Gradient From', 'seofy'),
                'param_name' => 'bg_color_from',
                'value' => $theme_gradient['from'],
                'description' => esc_html__('Select icon gradient color from', 'seofy'),
                'dependency' => array(
                    'element' => 'bg_color_type',
                    'value' => 'gradient'
                ),
                'group' => esc_html__( 'Icons Styles', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-6',
            ),
            // Icon gradient end color
            array(
                'type' => 'colorpicker',
                'heading' => esc_html__('Background Gradient To', 'seofy'),
                'param_name' => 'bg_color_to',
                'value' => $theme_gradient['to'],
                'description' => esc_html__('Select icon gradient color to', 'seofy'),
                'dependency' => array(
                    'element' => 'bg_color_type',
                    'value' => 'gradient'
                ),
                'group' => esc_html__( 'Icons Styles', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-4',
            ),
            // Icon gradient start color
            array(
                'type' => 'colorpicker',
                'heading' => esc_html__('Background Hover Gradient From', 'seofy'),
                'param_name' => 'bg_hover_color_from',
                'value' => $theme_gradient['to'],
                'description' => esc_html__('Select icon gradient color from', 'seofy'),
                'dependency' => array(
                    'element' => 'bg_color_type',
                    'value' => 'gradient'
                ),
                'group' => esc_html__( 'Icons Styles', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-6',
            ),
            // Icon gradient end color
            array(
                'type' => 'colorpicker',
                'heading' => esc_html__('Background Hover Gradient To', 'seofy'),
                'param_name' => 'bg_hover_color_to',
                'value' => $theme_gradient['from'],
                'description' => esc_html__('Select icon gradient color to', 'seofy'),
                'dependency' => array(
                    'element' => 'bg_color_type',
                    'value' => 'gradient'
                ),
                'group' => esc_html__( 'Icons Styles', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-4',
            ),
            // Styling
            array(
                'type' => 'seofy_param_heading',
                'heading' => esc_html__('Custom Title Color', 'seofy'),
                'param_name' => 'h_custom_colors',
                'group' => esc_html__( 'Typography', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-12 no-top-margin',
            ),
            array(
                'type' => 'wgl_checkbox',
                'heading' => esc_html__( 'Use Custom Title Color', 'seofy' ),
                'param_name' => 'custom_title_color',
                'description' => esc_html__( 'Select custom color', 'seofy' ),
                'group' => esc_html__( 'Typography', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-4',
            ),
            array(
                'type' => 'colorpicker',
                'heading' => esc_html__('Title Color', 'seofy'),
                'param_name' => 'title_color',
                'value' => '#252525',
                'group' => esc_html__( 'Typography', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-6',
                'dependency' => array(
                    'element' => 'custom_title_color',
                    'value' => 'true',
                ),
            ),
            array(
                'type' => 'seofy_param_heading',
                'heading' => esc_html__('Custom Subtitle Color', 'seofy'),
                'param_name' => 'h_custom_subtitle_colors',
                'group' => esc_html__( 'Typography', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-12',
            ),
            array(
                'type' => 'wgl_checkbox',
                'heading' => esc_html__( 'Use Custom Subtitle Color', 'seofy' ),
                'param_name' => 'custom_subtitle_color',
                'description' => esc_html__( 'Select custom color', 'seofy' ),
                'group' => esc_html__( 'Typography', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-4',
            ),
            array(
                'type' => 'colorpicker',
                'heading' => esc_html__('Subtitle Color', 'seofy'),
                'param_name' => 'subtitle_color',
                'value' => $theme_color,
                'dependency' => array(
                    'element' => 'custom_subtitle_color',
                    'value' => 'true',
                ),
                'group' => esc_html__( 'Typography', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-6',
            ),
            array(
                'type' => 'seofy_param_heading',
                'heading' => esc_html__('Custom Content Color', 'seofy'),
                'param_name' => 'h_custom_content_colors',
                'group' => esc_html__( 'Typography', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-12',
            ),
            array(
                'type' => 'wgl_checkbox',
                'heading' => esc_html__( 'Use Custom Content Color', 'seofy' ),
                'param_name' => 'custom_content_color',
                'description' => esc_html__( 'Select custom color', 'seofy' ),
                'group' => esc_html__( 'Typography', 'seofy' ),
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
                'group' => esc_html__( 'Typography', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-6',
            ),
        )
    ));

    if (class_exists('WPBakeryShortCode')) {
        class WPBakeryShortCode_wgl_Circuit_Services extends WPBakeryShortCode {
        }
    }
}