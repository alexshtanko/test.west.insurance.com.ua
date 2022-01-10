<?php
if ( ! defined( 'ABSPATH' ) ) {
    die( '-1' );
}

$theme_color = esc_attr(Seofy_Theme_Helper::get_option("theme-custom-color"));

if (function_exists('vc_map')) {
// Add list item
    $main_font = Seofy_Theme_Helper::get_option('main-font');
    vc_map(array(
        'name' => esc_html__('Message Box', 'seofy'),
        'base' => 'wgl_message_box',
        'class' => 'seofy_message_box',
        'category' => esc_html__('WGL Modules', 'seofy'),
        'icon' => 'wgl_icon_message_box',
        'content_element' => true,
        'description' => esc_html__('Message Box','seofy'),
        'params' => array(
            array(
                'type'          => 'dropdown',
                'heading'       => esc_html__( 'Message Type', 'seofy' ),
                'param_name'    => 'type',
                'value'         => array(
                    esc_html__( 'Informational', 'seofy' ) => 'info',
                    esc_html__( 'Success', 'seofy' )		 => 'success',
                    esc_html__( 'Warning', 'seofy' )		 => 'warning',
                    esc_html__( 'Error', 'seofy' )		 => 'error',
                    esc_html__( 'Custom', 'seofy' )		 => 'custom',
                ),              
            ),
            array(
                'type' => 'iconpicker',
                'heading' => esc_html__( 'Icon', 'seofy' ),
                'param_name' => 'icon_fontawesome',
                'value' => 'fa fa-adjust',
                'settings' => array(
                    'emptyIcon' => false,
                    'iconsPerPage' => 200,
                ),
                'description' => esc_html__( 'Select icon from library.', 'seofy' ),
                'dependency'    => array(
                    'element'   => 'type',
                    'value' => 'custom'
                ),
            ),
            array(
                'type'          => 'colorpicker',
                'heading'       => esc_html__( 'Message Color', 'seofy' ),
                'param_name'    => 'icon_color',
                'value'         => $theme_color,
                'dependency'    => array(
                    'element'   => 'type',
                    'value' => 'custom'
                ),
            ),
            array(
                'type' => 'textfield',
                'heading' => esc_html__('Title', 'seofy'),
                'param_name' => 'title',
                'admin_label'   => true,
            ),  
            array(
                'type' => 'textarea',
                'heading' => esc_html__('Text', 'seofy'),
                'param_name' => 'text',
            ),       
            array(
                'type'          => 'wgl_checkbox',
                'heading'       => esc_html__( 'Closable?', 'seofy' ),
                'param_name'    => 'closable',
            ),
            vc_map_add_css_animation( true ),
            array(
                'type' => 'textfield',
                'heading' => esc_html__('Extra Class', 'seofy'),
                'param_name' => 'extra_class',
                'description' => esc_html__('Add an extra class name to the element and refer to it from Custom CSS option.', 'seofy')
            ),
            // title styles heading
            array(
                'type' => 'seofy_param_heading',
                'heading' => esc_html__('Title Styles', 'seofy'),
                'param_name' => 'h_title_styles',
                'group' => esc_html__( 'Typography', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-12 no-top-margin',
                'dependency'    => array(
                    'element'   => 'type',
                    'value' => 'custom'
                ),
            ),
            array(
                'type'          => 'dropdown',
                'heading'       => esc_html__( 'Title Tag', 'seofy' ),
                'param_name'    => 'title_tag',
                'value'         => array(
                    esc_html__( 'Div', 'seofy' )    => 'div',
                    esc_html__( 'Span', 'seofy' )    => 'span',
                    esc_html__( 'H2', 'seofy' )    => 'h2',
                    esc_html__( 'H3', 'seofy' )    => 'h3',
                    esc_html__( 'H4', 'seofy' )    => 'h4',
                    esc_html__( 'H5', 'seofy' )    => 'h5',
                    esc_html__( 'H6', 'seofy' )    => 'h6',
                ),
                'std' => 'h4',
                'group'         => esc_html__( 'Typography', 'seofy' ),
                'description' => esc_html__( 'Choose your tag for title', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-6',
                'dependency'    => array(
                    'element'   => 'type',
                    'value' => 'custom'
                ),
            ),
            // title Font Size
            array(
                'type' => 'textfield',
                'heading' => esc_html__('Title Font Size', 'seofy'),
                'param_name' => 'title_size',
                'value' => '',
                'description' => esc_html__( 'Enter title font-size in pixels.', 'seofy' ),
                'group' => esc_html__( 'Typography', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-6',
                'dependency'    => array(
                    'element'   => 'type',
                    'value' => 'custom'
                ),
            ),
            // Title Fonts
            array(
                'type' => 'wgl_checkbox',
                'heading' => esc_html__( 'Custom font family for title', 'seofy' ),
                'param_name' => 'custom_fonts_title',
                'description' => esc_html__( 'Customize font family', 'seofy' ),
                'group' => esc_html__( 'Typography', 'seofy' ),
                'dependency'    => array(
                    'element'   => 'type',
                    'value' => 'custom'
                ),
            ),
            array(
                'type' => 'google_fonts',
                'param_name' => 'google_fonts_title',
                'value' => '',
                'dependency' => array(
                    'element' => 'custom_fonts_title',
                    'value' => 'true',
                ),
                'group' => esc_html__( 'Typography', 'seofy' ),
            ),
            // title color checkbox
            array(
                'type' => 'wgl_checkbox',
                'heading' => esc_html__( 'Use Custom Title Color', 'seofy' ),
                'param_name' => 'custom_title_color',
                'description' => esc_html__( 'Select custom color', 'seofy' ),
                'group' => esc_html__( 'Typography', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-4',
                'dependency'    => array(
                    'element'   => 'type',
                    'value' => 'custom'
                ),
            ),
            // title color
            array(
                'type' => 'colorpicker',
                'heading' => esc_html__('Title Color', 'seofy'),
                'param_name' => 'title_color',
                'value' => $theme_color,
                'description' => esc_html__('Select title color', 'seofy'),
                'dependency' => array(
                    'element' => 'custom_title_color',
                    'value' => 'true'
                ),
                'group' => esc_html__( 'Typography', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-4',
            ),
            // text styles heading
            array(
                'type' => 'seofy_param_heading',
                'heading' => esc_html__('Text Styles', 'seofy'),
                'param_name' => 'h_text_styles',
                'group' => esc_html__( 'Typography', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-12',
                'dependency'    => array(
                    'element'   => 'type',
                    'value' => 'custom'
                ),
            ),
            array(
                'type'          => 'dropdown',
                'heading'       => esc_html__( 'Text Tag', 'seofy' ),
                'param_name'    => 'text_tag',
                'value'         => array(
                    esc_html__( 'Div', 'seofy' )    => 'div',
                    esc_html__( 'Span', 'seofy' )    => 'span',
                    esc_html__( 'H2', 'seofy' )    => 'h2',
                    esc_html__( 'H3', 'seofy' )    => 'h3',
                    esc_html__( 'H4', 'seofy' )    => 'h4',
                    esc_html__( 'H5', 'seofy' )    => 'h5',
                    esc_html__( 'H6', 'seofy' )    => 'h6',
                ),
                'std' => 'div',
                'group'         => esc_html__( 'Typography', 'seofy' ),
                'description' => esc_html__( 'Choose your tag for text', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-6',
                'dependency'    => array(
                    'element'   => 'type',
                    'value' => 'custom'
                ),
            ),
            // text Font Size
            array(
                'type' => 'textfield',
                'heading' => esc_html__('Text Font Size', 'seofy'),
                'param_name' => 'text_size',
                'value' => '',
                'description' => esc_html__( 'Enter text font-size in pixels.', 'seofy' ),
                'group' => esc_html__( 'Typography', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-6',
                'dependency'    => array(
                    'element'   => 'type',
                    'value' => 'custom'
                ),
            ),
            // text Fonts
            array(
                'type' => 'wgl_checkbox',
                'heading' => esc_html__( 'Custom font family for text', 'seofy' ),
                'param_name' => 'custom_fonts_text',
                'description' => esc_html__( 'Customize font family', 'seofy' ),
                'group' => esc_html__( 'Typography', 'seofy' ),
                'dependency'    => array(
                    'element'   => 'type',
                    'value' => 'custom'
                ),
            ),
            array(
                'type' => 'google_fonts',
                'param_name' => 'google_fonts_text',
                'value' => '',
                'dependency' => array(
                    'element' => 'custom_fonts_text',
                    'value' => 'true',
                ),
                'group' => esc_html__( 'Typography', 'seofy' ),
            ),
            // text color checkbox
            array(
                'type' => 'wgl_checkbox',
                'heading' => esc_html__( 'Use Custom Text Color', 'seofy' ),
                'param_name' => 'custom_text_color',
                'description' => esc_html__( 'Select custom color', 'seofy' ),
                'group' => esc_html__( 'Typography', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-4',
                'dependency'    => array(
                    'element'   => 'type',
                    'value' => 'custom'
                ),
            ),
            // text color
            array(
                'type' => 'colorpicker',
                'heading' => esc_html__('Text Color', 'seofy'),
                'param_name' => 'text_color',
                'value' => '#000000',
                'description' => esc_html__('Select text color', 'seofy'),
                'dependency' => array(
                    'element' => 'custom_text_color',
                    'value' => 'true'
                ),
                'group' => esc_html__( 'Typography', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-4',
            ),             
        )
    ));
    
    if (class_exists('WPBakeryShortCode')) {
        class WPBakeryShortCode_wgl_message_box extends WPBakeryShortCode {}
    } 
}
