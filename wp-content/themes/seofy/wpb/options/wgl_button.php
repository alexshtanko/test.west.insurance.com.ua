<?php
if ( ! defined( 'ABSPATH' ) ) {
    die( '-1' );
}

$theme_color = esc_attr(Seofy_Theme_Helper::get_option('theme-custom-color'));
$theme_gradient = Seofy_Theme_Helper::get_option('theme-gradient');

if (function_exists('vc_map')) {
    vc_map(array(
        'name' => esc_html__('Button', 'seofy'),
        'base' => 'wgl_button',
        'class' => 'seofy_button',
        'icon' => 'wgl_icon_button',
        'content_element' => true,
        'category' => esc_html__('WGL Modules', 'seofy'),
        'description' => esc_html__('Add extended button','seofy'),
        'params' => array(
            // General Settings
            array(
                'type' => 'textfield',
                'heading' => esc_html__('Button Text', 'seofy'),
                'value' => esc_html__('Button Text', 'seofy'),
                'param_name' => 'button_text',
                'admin_label' => true,
            ),
            array(
                'type' => 'vc_link',
                'heading' => esc_html__( 'Button Link', 'seofy' ),
                'param_name' => 'link',
            ),
            // Button Animations
            vc_map_add_css_animation( true ),
            array(
                'type' => 'textfield',
                'heading' => esc_html__('Extra Class', 'seofy'),
                'param_name' => 'extra_class',
                'description' => esc_html__('Add an extra class name to the element and refer to it from Custom CSS option.', 'seofy')
            ),
            // Button Style
            array(
                'type' => 'seofy_param_heading',
                'heading' => esc_html__('Button Style', 'seofy'),
                'param_name' => 'h_button_style',
                'group' => esc_html__( 'Style', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-12 no-top-margin',
            ),
            array(
                'type' => 'dropdown',
                'heading' => esc_html__( 'Button Size', 'seofy' ),
                'param_name' => 'size',
                'value' => array(
                    esc_html__( 'Small', 'seofy' ) => 's',
                    esc_html__( 'Medium', 'seofy' ) => 'm',
                    esc_html__( 'Large', 'seofy' ) => 'l',
                    esc_html__( 'Extra Large', 'seofy' ) => 'xl',
                ),
                'group' => esc_html__( 'Style', 'seofy' ),
                'std' => 'xl',
                'edit_field_class' => 'vc_col-sm-6',
                'description' => esc_html__('Select button size.', 'seofy')
            ),
            array(
                'type' => 'textfield',
                'heading' => esc_html__('Button Border Radius', 'seofy'),
                'value' => '',
                'param_name' => 'border_radius',
                'edit_field_class' => 'vc_col-sm-6',
                'group' => esc_html__( 'Style', 'seofy' ),
                'description' => esc_html__('Enter border radius in pixels.', 'seofy')
            ),
            array(
                'type' => 'dropdown',
                'heading' => esc_html__( 'Button Align', 'seofy' ),
                'param_name' => 'align',
                'value' => array(
                    esc_html__( 'Left', 'seofy' ) => 'left',
                    esc_html__( 'Center', 'seofy' ) => 'center',
                    esc_html__( 'Right', 'seofy' ) => 'right',
                ),
                'group' => esc_html__( 'Style', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-6',
                'description' => esc_html__('Select button align.', 'seofy')
            ),
            array(
                'type' => 'wgl_checkbox',
                'heading' => esc_html__( 'Button Full Width', 'seofy' ),
                'param_name' => 'full_width',
                'group' => esc_html__( 'Style', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-3',
            ), 
            array(
                'type' => 'wgl_checkbox',
                'heading' => esc_html__( 'Button Inline', 'seofy' ),
                'param_name' => 'inline',
                'group' => esc_html__( 'Style', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-3',
            ), 
            array(
                'type' => 'seofy_param_heading',
                'heading' => esc_html__('Button Border', 'seofy'),
                'param_name' => 'h_button_border',
                'group' => esc_html__( 'Style', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-12',
            ),
            array(
                'type' => 'wgl_checkbox',
                'heading' => esc_html__( 'Add Button Border', 'seofy' ),
                'param_name' => 'add_border',
                'group' => esc_html__( 'Style', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-4',
                'std' => 'true'
            ), 
            array(
                'type' => 'textfield',
                'heading' => esc_html__('Button Border Width', 'seofy'),
                'value' => '1px',
                'param_name' => 'border_width',
                'dependency' => array(
                    'element' => 'add_border',
                    'value' => 'true'
                ),
                'group' => esc_html__( 'Style', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-8',
                'description' => esc_html__('Enter border width in pixels.', 'seofy')
            ),
            array(
                'type' => 'seofy_param_heading',
                'heading' => esc_html__('Button Shadow', 'seofy'),
                'param_name' => 'h_button_shadow',
                'group' => esc_html__( 'Style', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-12',
            ),
            array(
                'type' => 'dropdown',
                'heading' => esc_html__( 'Button Shadow Style', 'seofy' ),
                'param_name' => 'shadow_style',
                'value' => array(
					esc_html__( 'None', 'seofy' ) => 'none',
					esc_html__( 'Always', 'seofy' ) => 'always',
					esc_html__( 'On Hover', 'seofy' ) => 'on_hover',
					esc_html__( 'Before Hover', 'seofy' ) => 'before_hover',
                ),
                'group' => esc_html__( 'Style', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-12',
                'description' => esc_html__('Select button shadow style.', 'seofy')
            ),
            // Button Typography
            array(
                'type' => 'wgl_checkbox',
                'heading' => esc_html__( 'Custom font family for button', 'seofy' ),
                'param_name' => 'custom_fonts_button',
                'description' => esc_html__( 'Customize font family', 'seofy' ),
                'group' => esc_html__( 'Typography', 'seofy' ),
            ),
            array(
                'type' => 'google_fonts',
                'param_name' => 'google_fonts_button',
                'value' => '',
                'dependency' => array(
                    'element' => 'custom_fonts_button',
                    'value' => 'true',
                ),
                'group' => esc_html__( 'Typography', 'seofy' ),
            ),
            array(
                'type' => 'textfield',
                'heading' => esc_html__('Button Font Size', 'seofy'),
                'param_name' => 'font_size',
                'value' => '',
                'description' => esc_html__( 'Enter button font-size in pixels.', 'seofy' ),
                'group' => esc_html__( 'Typography', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-6',
            ),            
            array(
                'type' => 'textfield',
                'heading' => esc_html__('Button Font Weight', 'seofy'),
                'param_name' => 'font_weight',
                'value' => '',
                'description' => esc_html__( 'Enter button font-weight.', 'seofy' ),
                'group' => esc_html__( 'Typography', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-6',
            ),
            // Button Icon
            array(
                'type' => 'seofy_param_heading',
                'heading' => esc_html__('Icon Type', 'seofy'),
                'param_name' => 'h_icon_type',
                'group' => esc_html__( 'Icon', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-12 no-top-margin',
            ),
            array(
                'type' => 'dropdown',
                'param_name' => 'icon_type',
                'value' => array(
                    esc_html__('None','seofy') => 'none',
                    esc_html__('Font','seofy') => 'font',
                    esc_html__('Image','seofy') => 'image',
                ),
                'group' => esc_html__( 'Icon', 'seofy' ),
                'description' => esc_html__('Select button icon type (font icon or custom image)', 'seofy'),
            ),
            array(
                'type' => 'dropdown',
                'param_name' => 'icon_font_type',
                'value' => array(
                    esc_html__( 'Fontawesome', 'seofy' ) => 'type_fontawesome',
                    esc_html__( 'Flaticon', 'seofy' ) => 'type_flaticon',
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
                'heading' => esc_html__('Icon', 'seofy'),
                'param_name' => 'icon_fontawesome',
                'value' => 'fa fa-adjust',
                'settings' => array(
                    'emptyIcon' => false,
                    'iconsPerPage' => 200, 
                ),
                'dependency' => array(
                    'element' => 'icon_font_type',
                    'value' => 'type_fontawesome',
                ),
                'description' => esc_html__( 'Select icon from library.', 'seofy' ),
                'group' => esc_html__( 'Icon', 'seofy' ),
            ),
            array(
                'type' => 'iconpicker',
                'heading' => esc_html__( 'Icon', 'seofy' ),
                'param_name' => 'icon_flaticon',
                'value' => '',
                'settings' => array(
                    'emptyIcon' => false,
                    'type' => 'flaticon',
                    'iconsPerPage' => 200,
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
                'heading' => esc_html__('Image', 'seofy'),
                'param_name' => 'image',
                'value' => '',
                'description' => esc_html__( 'Select image from media library.', 'seofy' ),
                'dependency' => array(
                    'element' => 'icon_type',
                    'value' => 'image'
                ),
                'group' => esc_html__( 'Icon', 'seofy' ),
            ),
            array(
                'type' => 'textfield',
                'heading' => esc_html__('Image Width', 'seofy'),
                'param_name' => 'img_width',
                'value' => '',
                'description' => esc_html__( 'Enter image width in pixels.', 'seofy' ),
                'dependency' => array(
                    'element' => 'icon_type',
                    'value' => 'image'
                ),
                'edit_field_class' => 'vc_col-sm-6',
                'group' => esc_html__( 'Icon', 'seofy' ),
            ),
            array(
                'type' => 'dropdown',
                'heading' => esc_html__('Icon Position', 'seofy'),
                'param_name' => 'icon_position',
                'value' => array(
                    esc_html__('Left', 'seofy') => 'left',
                    esc_html__('Right', 'seofy') => 'right'
                ),
                'edit_field_class' => 'vc_col-sm-6',
                'description' => esc_html__( 'Select button icon position.', 'seofy' ),
                'dependency' => array(
                    'element' => 'icon_type',
                    'value' => array('image', 'font')
                ),
                'group' => esc_html__( 'Icon', 'seofy' ),
            ),
            array(
                'type' => 'textfield',
                'heading' => esc_html__('Icon Font Size', 'seofy'),
                'param_name' => 'icon_font_size',
                'value' => '',
                'edit_field_class' => 'vc_col-sm-6',
                'description' => esc_html__( 'Enter icon font-size in pixels.', 'seofy' ),
                'dependency' => array(
                    'element' => 'icon_type',
                    'value' => 'font'
                ),
                'group' => esc_html__( 'Icon', 'seofy' ),
            ),
            // Button icon-color checkbox
            array(
                'type' => 'wgl_checkbox',
                'heading' => esc_html__( 'Use Custom Colors', 'seofy' ),
                'param_name' => 'custom_icon_color',
                'description' => esc_html__( 'Select custom colors', 'seofy' ),
                'group' => esc_html__( 'Icon', 'seofy' ),
                'dependency' => array(
                    'element' => 'icon_type',
                    'value' => 'font'
                ),
                'edit_field_class' => 'vc_col-sm-4',
            ),
            // Button icon-color
            array(
                'type' => 'colorpicker',
                'heading' => esc_html__('Icon Color', 'seofy'),
                'param_name' => 'icon_color',
                'value' => '#ffffff',
                'description' => esc_html__('Select icon color', 'seofy'),
                'dependency' => array(
                    'element' => 'custom_icon_color',
                    'value' => 'true'
                ),
                'group' => esc_html__( 'Icon', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-4',
            ),
            // Button Hover icon-color
            array(
                'type' => 'colorpicker',
                'heading' => esc_html__('Hover Icon Color', 'seofy'),
                'param_name' => 'icon_color_hover',
                'value' => '#ffffff',
                'description' => esc_html__('Select icon hover color', 'seofy'),
                'dependency' => array(
                    'element' => 'custom_icon_color',
                    'value' => 'true'
                ),
                'group' => esc_html__( 'Icon', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-4',
            ),
            // Button Spacing
            array(
                'type' => 'seofy_param_heading',
                'heading' => esc_html__('Button Paddings', 'seofy'),
                'param_name' => 'heading',
                'group' => esc_html__( 'Spacing', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-12 no-top-margin',
            ),
            array(
                'type' => 'textfield',
                'heading' => esc_html__('Button Left Padding', 'seofy'),
                'param_name' => 'left_pad',
                'value' => '',
                'group' => esc_html__( 'Spacing', 'seofy' ),
                'description' => esc_html__( 'Enter button left padding in pixels.', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-6',
            ),
            array(
                'type' => 'textfield',
                'heading' => esc_html__('Button Right Padding', 'seofy'),
                'param_name' => 'right_pad',
                'value' => '',
                'group' => esc_html__( 'Spacing', 'seofy' ),
                'description' => esc_html__( 'Enter button right padding in pixels.', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-6',
            ),
            array(
                'type' => 'textfield',
                'heading' => esc_html__('Button Top Padding', 'seofy'),
                'param_name' => 'top_pad',
                'value' => '',
                'group' => esc_html__( 'Spacing', 'seofy' ),
                'description' => esc_html__( 'Enter button top padding in pixels.', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-6',
            ),
            array(
                'type' => 'textfield',
                'heading' => esc_html__('Button Bottom Padding', 'seofy'),
                'param_name' => 'bottom_pad',
                'value' => '',
                'group' => esc_html__( 'Spacing', 'seofy' ),
                'description' => esc_html__( 'Enter button bottom padding in pixels.', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-6',
            ),
            array(
                'type' => 'seofy_param_heading',
                'heading' => esc_html__('Button Margins', 'seofy'),
                'param_name' => 'heading',
                'group' => esc_html__( 'Spacing', 'seofy' ),
            ),
            array(
                'type' => 'textfield',
                'heading' => esc_html__('Button Left Margin', 'seofy'),
                'param_name' => 'left_mar',
                'value' => '',
                'group' => esc_html__( 'Spacing', 'seofy' ),
                'description' => esc_html__( 'Enter button left margin in pixels.', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-6',
            ),
            array(
                'type' => 'textfield',
                'heading' => esc_html__('Button Right Margin', 'seofy'),
                'param_name' => 'right_mar',
                'value' => '',
                'group' => esc_html__( 'Spacing', 'seofy' ),
                'description' => esc_html__( 'Enter button right margin in pixels.', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-6',
            ),
            array(
                'type' => 'textfield',
                'heading' => esc_html__('Button Top Margin', 'seofy'),
                'param_name' => 'top_mar',
                'value' => '',
                'group' => esc_html__( 'Spacing', 'seofy' ),
                'description' => esc_html__( 'Enter button top margin in pixels.', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-6',
            ),
            array(
                'type' => 'textfield',
                'heading' => esc_html__('Button Bottom Margin', 'seofy'),
                'param_name' => 'bottom_mar',
                'value' => '',
                'group' => esc_html__( 'Spacing', 'seofy' ),
                'description' => esc_html__( 'Enter button bottom margin in pixels.', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-6',
            ),
            // Button Colors
            array(
                'type' => 'seofy_param_heading',
                'heading' => esc_html__('Button Colors', 'seofy'),
                'param_name' => 'h_button_colors',
                'group' => esc_html__( 'Colors', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-12 no-top-margin',
            ),
            array(
                'type' => 'dropdown',
                'heading' => esc_html__( 'Customize', 'seofy' ),
                'param_name' => 'customize',
                'value' => array(
                    esc_html__( 'Default', 'seofy' ) => 'def',
                    esc_html__( 'Color', 'seofy' ) => 'color',
                    esc_html__( 'Gradient', 'seofy' )  => 'gradient',
                ),
                'group' => esc_html__( 'Colors', 'seofy' ),
            ),
            array(
                'type' => 'seofy_param_heading',
                'heading' => esc_html__('Text Color', 'seofy'),
                'param_name' => 'h_text_color',
                'group' => esc_html__( 'Colors', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-12',
                'dependency' => array(
                    'element' => 'customize',
                    'value' => array('color', 'gradient')
                ),
            ),
            array(
                'type' => 'colorpicker',
                'class' => '',
                'heading' => esc_html__('Text Color', 'seofy'),
                'param_name' => 'text_color',
                'value' => '#ffffff',
                'description' => esc_html__('Select custom text color for button.', 'seofy'),
                'save_always' => true,
                'dependency' => array(
                    'element' => 'customize',
                    'value' => array('color', 'gradient')
                ),
                'group' => esc_html__( 'Colors', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-6',
            ),
            array(
                'type' => 'colorpicker',
                'class' => '',
                'heading' => esc_html__('Hover Text Color', 'seofy'),
                'param_name' => 'text_color_hover',
                'value' => $theme_color,
                'description' => esc_html__('Select custom text color for hover button.', 'seofy'),
                'dependency' => array(
                    'element' => 'customize',
                    'value' => array('color', 'gradient')
                ),
                'group' => esc_html__( 'Colors', 'seofy' ),
                'save_always' => true,
                'edit_field_class' => 'vc_col-sm-6',
            ),
            array(
                'type' => 'seofy_param_heading',
                'heading' => esc_html__('Background Color', 'seofy'),
                'param_name' => 'h_background_color',
                'group' => esc_html__( 'Colors', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-12',
                'dependency' => array(
                    'element' => 'customize',
                    'value' => 'color'
                ),
            ),
            array(
                'type' => 'colorpicker',
                'class' => '',
                'heading' => esc_html__('Background', 'seofy'),
                'param_name' => 'bg_color',
                'value' => $theme_color,
                'description' => esc_html__('Select custom background for button.', 'seofy'),
                'save_always' => true,
                'dependency' => array(
                    'element' => 'customize',
                    'value' => 'color'
                ),
                'group' => esc_html__( 'Colors', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-6',
            ),
            array(
                'type' => 'colorpicker',
                'class' => '',
                'heading' => esc_html__('Hover Background', 'seofy'),
                'param_name' => 'bg_color_hover',
                'value' => '#ffffff',
                'description' => esc_html__('Select custom background for hover button.', 'seofy'),
                'dependency' => array(
                    'element' => 'customize',
                    'value' => 'color'
                ),
                'group' => esc_html__( 'Colors', 'seofy' ),
                'save_always' => true,
                'edit_field_class' => 'vc_col-sm-6',
            ),
            // Button Bg Gradient header
            array(
                'type' => 'seofy_param_heading',
                'heading' => esc_html__('Background Gradient Color', 'seofy'),
                'param_name' => 'h_background_gradient_color',
                'group' => esc_html__( 'Colors', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-12',
                'dependency' => array(
                    'element' => 'customize',
                    'value' => 'gradient'
                ),
            ),
            // Button Bg Gradient start
            array(
                'type' => 'colorpicker',
                'class' => '',
                'heading' => esc_html__('Start Color', 'seofy'),
                'param_name' => 'bg_gradient_start',
                'value' => $theme_gradient['from'],
                'save_always' => true,
                'dependency' => array(
                    'element' => 'customize',
                    'value' => array('gradient')
                ),
                'group' => esc_html__( 'Colors', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-6',
            ),
            // Button Bg Gradient end
            array(
                'type' => 'colorpicker',
                'class' => '',
                'heading' => esc_html__('End Color', 'seofy'),
                'param_name' => 'bg_gradient_end',
                'value' => $theme_gradient['to'],
                'dependency' => array(
                    'element' => 'customize',
                    'value' => array('gradient')
                ),
                'group' => esc_html__( 'Colors', 'seofy' ),
                'save_always' => true,
                'edit_field_class' => 'vc_col-sm-6',
            ),
            // Button Bg Gradient Hover header
            array(
                'type' => 'seofy_param_heading',
                'heading' => esc_html__('Background Gradient Hover Color', 'seofy'),
                'param_name' => 'h_background_gradient_hover_color',
                'group' => esc_html__( 'Colors', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-12',
                'dependency' => array(
                    'element' => 'customize',
                    'value' => array('gradient')
                ),
            ),
            // Button Bg Gradient Hover start
            array(
                'type' => 'colorpicker',
                'class' => '',
                'heading' => esc_html__('Start Color', 'seofy'),
                'param_name' => 'bg_gradient_start_hover',
                'value' => $theme_gradient['to'],
                'save_always' => true,
                'dependency' => array(
                    'element' => 'customize',
                    'value' => array('gradient')
                ),
                'group' => esc_html__( 'Colors', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-6',
            ),
            // Button Bg Gradient Hover end
            array(
                'type' => 'colorpicker',
                'class' => '',
                'heading' => esc_html__('End Color', 'seofy'),
                'param_name' => 'bg_gradient_end_hover',
                'value' => $theme_gradient['from'],
                'save_always' => true,
                'dependency' => array(
                    'element' => 'customize',
                    'value' => 'gradient'
                ),
                'group' => esc_html__( 'Colors', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-6',
            ),
            array(
                'type' => 'seofy_param_heading',
                'heading' => esc_html__('Border Color', 'seofy'),
                'param_name' => 'h_border_color',
                'dependency' => array(
                    'element' => 'customize',
                    'value' => 'color'
                ),
                'group' => esc_html__( 'Colors', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-12',
            ),
            array(
                'type' => 'colorpicker',
                'class' => '',
                'heading' => esc_html__('Border Color', 'seofy'),
                'param_name' => 'border_color',
                'value' => $theme_color,
                'description' => esc_html__('Select custom border color for button.', 'seofy'),
                'save_always' => true,
                'dependency' => array(
                    'element' => 'customize',
                    'value' => 'color'
                ),
                'group' => esc_html__( 'Colors', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-6',
            ),
            array(
                'type' => 'colorpicker',
                'class' => '',
                'heading' => esc_html__('Hover Border Color', 'seofy'),
                'param_name' => 'border_color_hover',
                'value' => $theme_color,
                'description' => esc_html__('Select custom border color for hover button.', 'seofy'),
                'group' => esc_html__( 'Colors', 'seofy' ),
                'save_always' => true,
                'dependency' => array(
                    'element' => 'customize',
                    'value' => 'color'
                ),
                'edit_field_class' => 'vc_col-sm-6',
            ),
            // Button Border Gradient header
            array(
                'type' => 'seofy_param_heading',
                'heading' => esc_html__('Border Gradient Color', 'seofy'),
                'param_name' => 'h_border_gradient_color',
                'group' => esc_html__( 'Colors', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-12',
                'dependency' => array(
                    'element' => 'customize',
                    'value' => array('gradient')
                ),
            ),
            // Button Border Gradient start
            array(
                'type' => 'colorpicker',
                'class' => '',
                'heading' => esc_html__('Start Color', 'seofy'),
                'param_name' => 'border_gradient_start',
                'value' => $theme_gradient['from'],
                'save_always' => true,
                'dependency' => array(
                    'element' => 'customize',
                    'value' => array('gradient')
                ),
                'group' => esc_html__( 'Colors', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-6',
            ),
            // Button Hover Border Gradient end
            array(
                'type' => 'colorpicker',
                'class' => '',
                'heading' => esc_html__('End Color', 'seofy'),
                'param_name' => 'border_gradient_end',
                'value' => $theme_gradient['to'],
                'dependency' => array(
                    'element' => 'customize',
                    'value' => array('gradient')
                ),
                'group' => esc_html__( 'Colors', 'seofy' ),
                'save_always' => true,
                'edit_field_class' => 'vc_col-sm-6',
            ),
            // Button Border Gradient Hover header
            array(
                'type' => 'seofy_param_heading',
                'heading' => esc_html__('Border Gradient Hover Color', 'seofy'),
                'param_name' => 'h_border_gradient_hover_color',
                'group' => esc_html__( 'Colors', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-12',
                'dependency' => array(
                    'element' => 'customize',
                    'value' => array('gradient')
                ),
            ),
            // Button Border Gradient Hover start
            array(
                'type' => 'colorpicker',
                'class' => '',
                'heading' => esc_html__('Start Color', 'seofy'),
                'param_name' => 'border_gradient_start_hover',
                'value' => $theme_gradient['to'],
                'save_always' => true,
                'dependency' => array(
                    'element' => 'customize',
                    'value' => array('gradient')
                ),
                'group' => esc_html__( 'Colors', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-6',
            ),
            // Button Border Gradient Hover end
            array(
                'type' => 'colorpicker',
                'class' => '',
                'heading' => esc_html__('End Color', 'seofy'),
                'param_name' => 'border_gradient_end_hover',
                'value' => $theme_gradient['from'],
                'dependency' => array(
                    'element' => 'customize',
                    'value' => array('gradient')
                ),
                'group' => esc_html__( 'Colors', 'seofy' ),
                'save_always' => true,
                'edit_field_class' => 'vc_col-sm-6',
            ),
        )
    ));

    if (class_exists('WPBakeryShortCode')) {
        class WPBakeryShortCode_wgl_Button extends WPBakeryShortCode {
        }
    }
}