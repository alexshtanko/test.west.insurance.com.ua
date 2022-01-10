<?php
if ( ! defined( 'ABSPATH' ) ) {
    die( '-1' );
}
$theme_color = esc_attr(Seofy_Theme_Helper::get_option("theme-custom-color"));
$header_font_color = esc_attr(Seofy_Theme_Helper::get_option('header-font')['color']);

if (function_exists('vc_map')) {
    vc_map(array(
        'name' => esc_html__('Counter', 'seofy'),
        'base' => 'wgl_counter',
        'class' => 'seofy_counter',
        'category' => esc_html__('WGL Modules', 'seofy'),
        'icon' => 'wgl_icon_counter',
        'content_element' => true,
        'description' => esc_html__('Counter','seofy'),
        'params' => array(
            array(
                'type' => 'textfield',
                'heading' => esc_html__('Counter Title', 'seofy'),
                'param_name' => 'count_title',
                'admin_label' => true,
                'edit_field_class' => 'vc_col-sm-9',
            ),
            array(
                'type' => 'wgl_checkbox',
                'heading' => esc_html__( 'Add Counter Divider', 'seofy' ),
                'param_name' => 'add_counter_divider',
                'edit_field_class' => 'vc_col-sm-3 no-top-padding',
            ),
            array(
                'type' => 'textfield',
                'heading' => esc_html__('Counter Value Prefix', 'seofy'),
                'description' => esc_html__('Enter prefix before counter number', 'seofy'),
                'param_name' => 'count_prefix',
                'edit_field_class' => 'vc_col-sm-4',
            ),
            array(
                'type' => 'textfield',
                'heading' => esc_html__('Counter Value', 'seofy'),
                'description' => esc_html__('Enter number without any special character', 'seofy'),
                'param_name' => 'count_value',
                'admin_label' => true,
                'edit_field_class' => 'vc_col-sm-4',
            ),
            array(
                'type' => 'textfield',
                'heading' => esc_html__('Counter Value Suffix', 'seofy'),
                'description' => esc_html__('Enter suffix after counter number', 'seofy'),
                'param_name' => 'count_suffix',
                'edit_field_class' => 'vc_col-sm-4',
            ),
            array(
                'type' => 'seofy_radio_image',
                'heading' => esc_html__('Counter Type', 'seofy'),
                'param_name' => 'counter_type',
                'fields' => array(
                    'default' => array(
                        'image_url' => get_template_directory_uri() . '/img/wgl_composer_addon/icons/type_def.png',
                        'label' => esc_html__('Default', 'seofy')),
                    'bordered' => array(
                        'image_url' => get_template_directory_uri() . '/img/wgl_composer_addon/icons/type_bordered.png',
                        'label' => esc_html__('Bordered', 'seofy')),
                    'fill' => array(
                        'image_url' => get_template_directory_uri() . '/img/wgl_composer_addon/icons/type_fill.png',
                        'label' => esc_html__('Fill', 'seofy')),
                ),
                'value' => 'default',
            ),
            array(
                'type' => 'seofy_radio_image',
                'heading' => esc_html__('Counter Layout', 'seofy'),
                'param_name' => 'counter_layout',
                'fields' => array(
                    'top' => array(
                        'image_url' => get_template_directory_uri() . '/img/wgl_composer_addon/icons/style_def.png',
                        'label' => esc_html__('Top', 'seofy')),
                    'left' => array(
                        'image_url' => get_template_directory_uri() . '/img/wgl_composer_addon/icons/style_left.png',
                        'label' => esc_html__('Left', 'seofy')),
                    'right' => array(
                        'image_url' => get_template_directory_uri() . '/img/wgl_composer_addon/icons/style_right.png',
                        'label' => esc_html__('Right', 'seofy')),
                    'top_left' => array(
                        'image_url' => get_template_directory_uri() . '/img/wgl_composer_addon/icons/style_left_top.png',
                        'label' => esc_html__('Top Left', 'seofy')),
                    'top_right' => array(
                        'image_url' => get_template_directory_uri() . '/img/wgl_composer_addon/icons/style_right_top.png',
                        'label' => esc_html__('Top Right', 'seofy')),
                ),
                'value' => 'top',
                'dependency' => array(
                    'element' => 'counter_type',
                    'value' => array('default', 'bordered', 'fill')
                ),
            ),
            array(
                'type' => 'dropdown',
                'heading' => esc_html__( 'Alignment', 'seofy' ),
                'param_name' => 'counter_align',
                'value' => array(
                    esc_html__( 'Left', 'seofy' )   => 'left',
                    esc_html__( 'Right', 'seofy' )  => 'right',
                    esc_html__( 'Center', 'seofy' ) => 'center',
                ),
            ),
            vc_map_add_css_animation( true ),
            array(
                'type' => 'textfield',
                'heading' => esc_html__('Extra Class', 'seofy'),
                'param_name' => 'extra_class',
                'description' => esc_html__('Add an extra class name to the element and refer to it from Custom CSS option.', 'seofy')
            ),
            // Counter Icon/Image heading
            array(
                'type' => 'seofy_param_heading',
                'heading' => esc_html__('Icon Type', 'seofy'),
                'param_name' => 'h_icon_type',
                'group' => esc_html__( 'Icon', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-12 no-top-margin',
            ),
            // Counter Icon/Image
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
                    esc_html__( 'Fontawesome', 'seofy' ) => 'type_fontawesome',
                    esc_html__( 'Flaticon', 'seofy' )    => 'type_flaticon',
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
                    // default true, display an 'EMPTY' icon?
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
                'edit_field_class' => 'vc_col-sm-6',
            ),
            // Custom image height
            array(
                'type' => 'textfield',
                'heading' => esc_html__('Custom Image Height', 'seofy'),
                'param_name' => 'custom_image_height',
                'description' => esc_html__( 'Enter image size in pixels.', 'seofy' ),
                'group' => esc_html__( 'Icon', 'seofy' ),
                'dependency' => array(
                    'element' => 'icon_type',
                    'value' => 'image',
                ),
                'edit_field_class' => 'vc_col-sm-6',
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
            // Icon color checkbox
            array(
                'type' => 'wgl_checkbox',
                'heading' => esc_html__( 'Use Custom Icon Colors', 'seofy' ),
                'param_name' => 'custom_icon_color',
                'description' => esc_html__( 'Select custom colors', 'seofy' ),
                'group' => esc_html__( 'Icon', 'seofy' ),
                'dependency' => array(
                    'element' => 'icon_type',
                    'value' => 'font',
                ),
                'edit_field_class' => 'vc_col-sm-4',
            ),
            // Icon color
            array(
                'type' => 'colorpicker',
                'heading' => esc_html__('Icon Color', 'seofy'),
                'param_name' => 'icon_color',
                'value' => '#000000',
                'description' => esc_html__('Select icon color', 'seofy'),
                'dependency' => array(
                    'element' => 'custom_icon_color',
                    'value' => 'true'
                ),
                'group' => esc_html__( 'Icon', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-4',
            ),
            // Icon hover color
            array(
                'type' => 'colorpicker',
                'heading' => esc_html__('Icon Hover Color', 'seofy'),
                'param_name' => 'icon_color_hover',
                'description' => esc_html__('Select icon hover color', 'seofy'),
                'dependency' => array(
                    'element' => 'custom_icon_color',
                    'value' => 'true'
                ),
                'group' => esc_html__( 'Icon', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-4',
            ),    
            // icon/image bg
            array(
                'type' => 'seofy_param_heading',
                'heading' => esc_html__('For The Types with Icon Background', 'seofy'),
                'param_name' => 'h_icon_bg',
                'group' => esc_html__( 'Background Icon', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-12 no-top-margin',
            ),
            // Custom icon bg size
            array(
                'type' => 'textfield',
                'heading' => esc_html__('Enter Background Width', 'seofy'),
                'param_name' => 'custom_icon_bg_width',
                'description' => esc_html__( 'Custom width in pixels.', 'seofy' ),
                'group' => esc_html__( 'Background Icon', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-6',
            ),
            // Custom icon bg size
            array(
                'type' => 'textfield',
                'heading' => esc_html__('Enter Background Height', 'seofy'),
                'param_name' => 'custom_icon_bg_height',
                'description' => esc_html__( 'Custom height in pixels.', 'seofy' ),
                'group' => esc_html__( 'Background Icon', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-6',
            ),
            array(
                'type' => 'textfield',
                'heading' => esc_html__('Enter Bottom Offset', 'seofy'),
                'param_name' => 'custom_icon_bot_offset',
                'description' => esc_html__( 'Custom offset in pixels.', 'seofy' ),
                'group' => esc_html__( 'Background Icon', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-6',
            ), 
            array(
                'type' => 'textfield',
                'heading' => esc_html__('Enter Side Offset', 'seofy'),
                'param_name' => 'custom_icon_side_offset',
                'description' => esc_html__( 'It works only with layout left or right', 'seofy' ),
                'group' => esc_html__( 'Background Icon', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-6',
                'dependency' => array(
                    'element' => 'counter_layout',
                    'value' => array('left','right','top_left','top_right'),
                ),
            ),  
            // Custom icon bg radius
            array(
                'type' => 'textfield',
                'heading' => esc_html__('Enter Border Radius', 'seofy'),
                'param_name' => 'custom_icon_radius',
                'description' => esc_html__( 'Custom radius in pixels.', 'seofy' ),
                'group' => esc_html__( 'Background Icon', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-12',
                'dependency' => array(
                    'element' => 'counter_type',
                    'value' => array('bordered','fill')
                ),
            ),   
            // icon/image border styles
            array(
                'type' => 'seofy_param_heading',
                'heading' => esc_html__('Border Styles', 'seofy'),
                'param_name' => 'h_border_styles',
                'group' => esc_html__( 'Background Icon', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-12',
                'dependency' => array(
                    'element' => 'counter_type',
                    'value' => 'bordered'
                ),
            ),
            // Custom icon border width
            array(
                'type' => 'textfield',
                'heading' => esc_html__('Border Width', 'seofy'),
                'param_name' => 'border_width',
                'description' => esc_html__( 'Enter border width in pixels.', 'seofy' ),
                'group' => esc_html__( 'Background Icon', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-12',
                'dependency' => array(
                    'element' => 'counter_type',
                    'value' => 'bordered'
                ),
            ),
            // border color checkbox
            array(
                'type' => 'wgl_checkbox',
                'heading' => esc_html__( 'Use Custom Border Colors', 'seofy' ),
                'param_name' => 'custom_border_color',
                'description' => esc_html__( 'Select custom colors', 'seofy' ),
                'group' => esc_html__( 'Background Icon', 'seofy' ),
                'dependency' => array(
                    'element' => 'counter_type',
                    'value' => 'bordered'
                ),
                'edit_field_class' => 'vc_col-sm-4',
            ),
            // border color
            array(
                'type' => 'colorpicker',
                'heading' => esc_html__('Border Color', 'seofy'),
                'param_name' => 'border_color',
                'value' => '#000000',
                'description' => esc_html__('Select border color', 'seofy'),
                'dependency' => array(
                    'element' => 'custom_border_color',
                    'value' => 'true'
                ),
                'group' => esc_html__( 'Background Icon', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-4',
            ),
            // border hover color
            array(
                'type' => 'colorpicker',
                'heading' => esc_html__('Border Hover Color', 'seofy'),
                'param_name' => 'border_color_hover',
                'description' => esc_html__('Select border hover color', 'seofy'),
                'dependency' => array(
                    'element' => 'custom_border_color',
                    'value' => 'true'
                ),
                'group' => esc_html__( 'Background Icon', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-4',
            ), 
            // icon/image bg styles
            array(
                'type' => 'seofy_param_heading',
                'heading' => esc_html__('Background Styles', 'seofy'),
                'param_name' => 'h_bg_styles',
                'group' => esc_html__( 'Background Icon', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-12',
                'dependency' => array(
                    'element' => 'counter_type',
                    'value' => array('bordered','fill')
                ),
            ),
            // Background color/gradient
            array(
                'type' => 'dropdown',
                'heading' => esc_html__( 'Background Customize Colors', 'seofy' ),
                'param_name' => 'bg_color_type',
                'value' => array(
                    esc_html__( 'Default', 'seofy' )  => 'def',
                    esc_html__( 'Color', 'seofy' )    => 'color',
                    esc_html__( 'Gradient', 'seofy' ) => 'gradient',
                ),
                'dependency' => array(
                    'element' => 'counter_type',
                    'value' => array('bordered','fill')
                ),
                'group' => esc_html__( 'Background Icon', 'seofy' ),
            ),
            // background color
            array(
                'type' => 'colorpicker',
                'heading' => esc_html__('Background Color', 'seofy'),
                'param_name' => 'background_color',
                'value' => '#000000',
                'description' => esc_html__('Select background color', 'seofy'),
                'dependency' => array(
                    'element' => 'bg_color_type',
                    'value' => 'color'
                ),
                'group' => esc_html__( 'Background Icon', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-6',
            ),
            // Background hover color
            array(
                'type' => 'colorpicker',
                'heading' => esc_html__('Background Hover Color', 'seofy'),
                'param_name' => 'background_color_hover',
                'description' => esc_html__('Select background hover color', 'seofy'),
                'dependency' => array(
                    'element' => 'bg_color_type',
                    'value' => 'color'
                ),
                'group' => esc_html__( 'Background Icon', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-6',
            ), 
            // Background Gradient start
            array(
                'type' => 'colorpicker',
                'heading' => esc_html__('Background Start Color', 'seofy'),
                'param_name' => 'background_gradient_start',
                'value' => $theme_color,
                'dependency' => array(
                    'element' => 'bg_color_type',
                    'value' => 'gradient'
                ),
                'group' => esc_html__( 'Background Icon', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-6',
            ),
            // Background Gradient end
            array(
                'type' => 'colorpicker',
                'heading' => esc_html__('Background End Color', 'seofy'),
                'param_name' => 'background_gradient_end',
                'value' => '#000000',
                'dependency' => array(
                    'element' => 'bg_color_type',
                    'value' => 'gradient'
                ),
                'group' => esc_html__( 'Background Icon', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-6',
            ),
            // Background Gradient start
            array(
                'type' => 'colorpicker',
                'heading' => esc_html__('Background Hover Start Color', 'seofy'),
                'param_name' => 'background_gradient_hover_start',
                'dependency' => array(
                    'element' => 'bg_color_type',
                    'value' => 'gradient'
                ),
                'group' => esc_html__( 'Background Icon', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-6',
            ),
            // Background Gradient end
            array(
                'type' => 'colorpicker',
                'heading' => esc_html__('Background Hover End Color', 'seofy'),
                'param_name' => 'background_gradient_hover_end',
                'dependency' => array(
                    'element' => 'bg_color_type',
                    'value' => 'gradient'
                ),
                'group' => esc_html__( 'Background Icon', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-6',
            ),
            // Title styles heading
            array(
                'type' => 'seofy_param_heading',
                'heading' => esc_html__('Title Styles', 'seofy'),
                'param_name' => 'h_title_styles',
                'group' => esc_html__( 'Styling', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-12 no-top-margin',
            ),
            array(
                'type' => 'dropdown',
                'heading' => esc_html__( 'Counter Title Weight', 'seofy' ),
                'param_name' => 'title_weight',
                'value' => array(
                    esc_html__( '300 / Light', 'seofy' )    => '300',
                    esc_html__( '400 / Regular', 'seofy' )  => '400',
                    esc_html__( '600 / SemiBold', 'seofy' ) => '600',
                    esc_html__( '700 / Bold', 'seofy' )     => '700',
                ),
                'std' => '700',
                'group' => esc_html__( 'Styling', 'seofy' ),
                'description' => esc_html__( 'Choose your Weight for counter title', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-6',
            ),
            // Title Font Size
            array(
                'type' => 'textfield',
                'heading' => esc_html__('Title Font Size', 'seofy'),
                'param_name' => 'title_size',
                'value' => '',
                'description' => esc_html__( 'Enter Counter title font-size in pixels.', 'seofy' ),
                'group' => esc_html__( 'Styling', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-6',
            ),
            // Title Fonts
            array(
                'type' => 'wgl_checkbox',
                'heading' => esc_html__( 'Custom font family for counter title', 'seofy' ),
                'param_name' => 'custom_fonts_title',
                'description' => esc_html__( 'Customize font family', 'seofy' ),
                'group' => esc_html__( 'Styling', 'seofy' ),
            ),
            array(
                'type' => 'google_fonts',
                'param_name' => 'google_fonts_title',
                'value' => '',
                'dependency' => array(
                    'element' => 'custom_fonts_title',
                    'value' => 'true',
                ),
                'group' => esc_html__( 'Styling', 'seofy' ),
            ),
            // Title color checkbox
            array(
                'type' => 'wgl_checkbox',
                'heading' => esc_html__( 'Use Custom Title Color', 'seofy' ),
                'param_name' => 'custom_title_color',
                'description' => esc_html__( 'Select custom color', 'seofy' ),
                'value' => 'true',
                'group' => esc_html__( 'Styling', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-4',
            ),
            // Title colorpicker
            array(
                'type' => 'colorpicker',
                'heading' => esc_html__('Title Color', 'seofy'),
                'param_name' => 'title_color',
                'value' => '#6e6e6e',
                'description' => esc_html__('Select custom color', 'seofy'),
                'dependency' => array(
                    'element' => 'custom_title_color',
                    'value' => 'true'
                ),
                'group' => esc_html__( 'Styling', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-4',
            ),
            // counter value styles heading
            array(
                'type' => 'seofy_param_heading',
                'heading' => esc_html__('Counter Value Styles', 'seofy'),
                'param_name' => 'h_count_value_styles',
                'group' => esc_html__( 'Styling', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-12',
            ),
            array(
                'type' => 'dropdown',
                'heading' => esc_html__( 'Counter Value Weight', 'seofy' ),
                'param_name' => 'count_value_weight',
                'value' => array(
                    esc_html__( '300 / Light', 'seofy' )      => '300',
                    esc_html__( '400 / Regular', 'seofy' )    => '400',
                    esc_html__( '600 / SemiBold', 'seofy' )   => '600',
                    esc_html__( '700 / Bold', 'seofy' )       => '700',
                    esc_html__( '800 / Extra-Bold', 'seofy' ) => '800',
                ),
                'std' => '800',
                'group' => esc_html__( 'Styling', 'seofy' ),
                'description' => esc_html__( 'Choose your Weight for counter value', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-6',
            ),
            // Counter Value Font Size
            array(
                'type' => 'textfield',
                'heading' => esc_html__('Counter Value Font Size', 'seofy'),
                'param_name' => 'count_value_size',
                'value' => '',
                'description' => esc_html__( 'Enter Counter counter value font-size in pixels.', 'seofy' ),
                'group' => esc_html__( 'Styling', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-6',
            ),
            // Counter Value Fonts
            array(
                'type' => 'wgl_checkbox',
                'heading' => esc_html__( 'Custom font family for counter value', 'seofy' ),
                'param_name' => 'custom_fonts_count_value',
                'description' => esc_html__( 'Customize font family', 'seofy' ),
                'group' => esc_html__( 'Styling', 'seofy' ),
            ),
            array(
                'type' => 'google_fonts',
                'param_name' => 'google_fonts_count_value',
                'value' => '',
                'dependency' => array(
                    'element' => 'custom_fonts_count_value',
                    'value' => 'true',
                ),
                'group' => esc_html__( 'Styling', 'seofy' ),
            ),
            // Counter value color checkbox
            array(
                'type' => 'wgl_checkbox',
                'heading' => esc_html__( 'Use Custom Counter Value Color', 'seofy' ),
                'param_name' => 'custom_count_value_color',
                'description' => esc_html__( 'Select custom color', 'seofy' ),
                'group' => esc_html__( 'Styling', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-4',
            ),
            // Counter value color
            array(
                'type' => 'colorpicker',
                'heading' => esc_html__('Counter Value Color', 'seofy'),
                'param_name' => 'count_value_color',
                'value' => $header_font_color,
                'description' => esc_html__('Select counter value color', 'seofy'),
                'dependency' => array(
                    'element' => 'custom_count_value_color',
                    'value' => 'true'
                ),
                'group' => esc_html__( 'Styling', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-4',
            ),
        )
    ));

    if (class_exists('WPBakeryShortCode')) {
        class WPBakeryShortCode_wgl_Counter extends WPBakeryShortCode {
        }
    }
}