<?php
if ( ! defined( 'ABSPATH' ) ) {
    die( '-1' );
}

$theme_color = esc_attr(Seofy_Theme_Helper::get_option("theme-custom-color"));
$header_font_color = esc_attr(Seofy_Theme_Helper::get_option('header-font')['color']);

if (function_exists('vc_map')) {
// Add list item
    vc_map(array(
        'name' => esc_html__('Double Headings', 'seofy'),
        'base' => 'wgl_double_headings',
        'class' => 'seofy_custom_text',
        'category' => esc_html__('WGL Modules', 'seofy'),
        'icon' => 'wgl_icon_double-text',
        'content_element' => true,
        'description' => esc_html__('Double Headings','seofy'),
        'params' => array(
            array(
                'type' => 'textarea',
                'heading' => esc_html__('Title', 'seofy'),
                'param_name' => 'title',
                'admin_label' => true,
            ),
            array(
                'type' => 'textfield',
                'heading' => esc_html__('Subtitle', 'seofy'),
                'param_name' => 'subtitle',
            ),
            array(
                'type' => 'dropdown',
                'heading' => esc_html__( 'Alignment', 'seofy' ),
                'param_name' => 'align',
                'edit_field_class' => 'vc_col-sm-12',
                'value' => array(
                    esc_html__( 'Left', 'seofy' )   => 'left',
                    esc_html__( 'Center', 'seofy' ) => 'center',
                    esc_html__( 'Right', 'seofy' )  => 'right',
                ),
            ), 
            vc_map_add_css_animation( true ),
            array(
                'type' => 'textfield',
                'heading' => esc_html__('Extra Class', 'seofy'),
                'param_name' => 'extra_class',
                'description' => esc_html__('Add an extra class name to the element and refer to it from Custom CSS option.', 'seofy')
            ),
            // Styling
            array(
                'type' => 'seofy_param_heading',
                'heading' => esc_html__('Title Styles', 'seofy'),
                'param_name' => 'h_title_styles',
                'group' => esc_html__( 'Title Styles', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-12 no-top-margin',
            ),
            array(
                'type' => 'dropdown',
                'heading' => esc_html__( 'HTML Tag', 'seofy' ),
                'param_name' => 'title_tag',
                'value' => array(
                    esc_html__( '‹div›', 'seofy' ) => 'div',
                    esc_html__( '‹h1›', 'seofy' ) => 'h1',
                    esc_html__( '‹h2›', 'seofy' ) => 'h2',
                    esc_html__( '‹h3›', 'seofy' ) => 'h3',
                    esc_html__( '‹h4›', 'seofy' ) => 'h4',
                    esc_html__( '‹h5›', 'seofy' ) => 'h5',
                    esc_html__( '‹h6›', 'seofy' ) => 'h6',
                ),
                'std' => 'div',
                'group' => esc_html__( 'Title Styles', 'seofy' ),
                'description' => esc_html__( 'Your html tag for title', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-3',
            ),
            array(
                'type' => 'textfield',
                'heading' => esc_html__('Title Font Size', 'seofy'),
                'param_name' => 'title_size',
                'value' => '36px',
                'description' => esc_html__( 'Enter font-size in pixels.', 'seofy' ),
                'group' => esc_html__( 'Title Styles', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-3',
            ),
            array(
                'type' => 'textfield',
                'heading' => esc_html__('Title Line Height', 'seofy'),
                'param_name' => 'title_line_height',
                'value' => '48px',
                'description' => esc_html__( 'Enter line height in pixels.', 'seofy' ),
                'group' => esc_html__( 'Title Styles', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-3',
            ),
            array(
                'type' => 'textfield',
                'heading' => esc_html__('Title Font Weight', 'seofy'),
                'param_name' => 'title_weight',
                'value' => '800',
                'group' => esc_html__( 'Title Styles', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-3',
            ),
            array(
                'type' => 'wgl_checkbox',
                'heading' => esc_html__( 'Custom Title Color', 'seofy' ),
                'param_name' => 'custom_title_color',
                'group' => esc_html__( 'Title Styles', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-6',
            ),
            array(
                'type' => 'colorpicker',
                'heading' => esc_html__( 'Title Color', 'seofy' ),
                'param_name' => 'title_color',
                'group' => esc_html__( 'Title Styles', 'seofy' ),
                'value' => $header_font_color,
                'save_always' => true,
                'dependency' => array(
                    'element' => 'custom_title_color',
                    'value' => 'true'
                ),
                'edit_field_class' => 'vc_col-sm-6',
                'description' => esc_html__( 'Choose color for title.', 'seofy' ),
            ), 
            array(
                'type' => 'wgl_checkbox',
                'heading' => esc_html__( 'Set Title Resonsive Font Size', 'seofy' ),
                'param_name' => 'responsive_font',
                'group' => esc_html__( 'Title Styles', 'seofy' ),
            ),
            array(
                'type' => 'textfield',
                'heading' => esc_html__('Small Desktops', 'seofy'),
                'param_name' => 'font_size_desctop',
                'description' => esc_html__( 'Enter font-size in pixels.', 'seofy' ),
                'group' => esc_html__( 'Title Styles', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-4',
                'dependency' => array(
                    'element' => 'responsive_font',
                    'value' => 'true'
                ),
            ),
            array(
                'type' => 'textfield',
                'heading' => esc_html__('Tablets', 'seofy'),
                'param_name' => 'font_size_tablet',
                'description' => esc_html__( 'Enter font-size in pixels.', 'seofy' ),
                'group' => esc_html__( 'Title Styles', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-4',
                'dependency' => array(
                    'element' => 'responsive_font',
                    'value' => 'true'
                ),
            ),
            array(
                'type' => 'textfield',
                'heading' => esc_html__('Mobile', 'seofy'),
                'param_name' => 'font_size_mobile',
                'description' => esc_html__( 'Enter font-size in pixels.', 'seofy' ),
                'group' => esc_html__( 'Title Styles', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-4',
                'dependency' => array(
                    'element' => 'responsive_font',
                    'value' => 'true'
                ),
            ),
            array(
                'type' => 'wgl_checkbox',
                'heading' => esc_html__( 'Custom font family for title', 'seofy' ),
                'param_name' => 'custom_fonts_title',
                'description' => esc_html__( 'Customize font family', 'seofy' ),
                'group' => esc_html__( 'Title Styles', 'seofy' ),
            ),
            array(
                'type' => 'google_fonts',
                'param_name' => 'google_fonts_title',
                'value' => '',
                'dependency' => array(
                    'element' => 'custom_fonts_title',
                    'value' => 'true',
                ),
                'group' => esc_html__( 'Title Styles', 'seofy' ),
            ),   
            // subtitle
            array(
                'type' => 'seofy_param_heading',
                'heading' => esc_html__('Subtitle Styles', 'seofy'),
                'param_name' => 'h_subtitle_styles',
                'group' => esc_html__( 'Subtitle Styles', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-12 no-top-margin',
            ),
            array(
                'type' => 'textfield',
                'heading' => esc_html__('Subtitle Font Size', 'seofy'),
                'param_name' => 'subtitle_size',
                'value' => '14px',
                'description' => esc_html__( 'Enter font-size in pixels.', 'seofy' ),
                'group' => esc_html__( 'Subtitle Styles', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-4',
            ),
            array(
                'type' => 'textfield',
                'heading' => esc_html__('Subtitle Line Height', 'seofy'),
                'param_name' => 'subtitle_line_height',
                'value' => '12px',
                'description' => esc_html__( 'Enter line height in pixels.', 'seofy' ),
                'group' => esc_html__( 'Subtitle Styles', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-4',
            ),
            array(
                'type' => 'textfield',
                'heading' => esc_html__('Subtitle Font Weight', 'seofy'),
                'param_name' => 'subtitle_weight',
                'value' => '600',
                'group' => esc_html__( 'Subtitle Styles', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-4',
            ),
            array(
                'type' => 'wgl_checkbox',
                'heading' => esc_html__( 'Custom Subtitle Color', 'seofy' ),
                'param_name' => 'custom_subtitle_color',
                'group' => esc_html__( 'Subtitle Styles', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-6',
            ),
            array(
                'type'          => 'colorpicker',
                'heading'       => esc_html__( 'Subtitle Color', 'seofy' ),
                'param_name'    => 'subtitle_color',
                'group'         => esc_html__( 'Subtitle Styles', 'seofy' ),
                'value'         => $theme_color,
                'save_always' => true,
                'dependency' => array(
                    'element' => 'custom_subtitle_color',
                    'value' => 'true',
                ),
                'edit_field_class' => 'vc_col-sm-6',
                'description' => esc_html__( 'Choose color for subtitle.', 'seofy' ),
            ), 
            array(
                'type' => 'wgl_checkbox',
                'heading' => esc_html__( 'Custom font family for subtitle', 'seofy' ),
                'param_name' => 'custom_fonts_subtitle',
                'description' => esc_html__( 'Customize font family', 'seofy' ),
                'group' => esc_html__( 'Subtitle Styles', 'seofy' ),
            ),
            array(
                'type' => 'google_fonts',
                'param_name' => 'google_fonts_subtitle',
                'value' => '',
                'dependency' => array(
                    'element' => 'custom_fonts_subtitle',
                    'value' => 'true',
                ),
                'group' => esc_html__( 'Subtitle Styles', 'seofy' ),
            ),              
        )
    ));
    
    if (class_exists('WPBakeryShortCode')) {
        class WPBakeryShortCode_wgl_Double_Headings extends WPBakeryShortCode {
            
        }
    } 
}
