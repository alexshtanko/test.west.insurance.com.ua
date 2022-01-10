<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

$theme_color = esc_attr(Seofy_Theme_Helper::get_option("theme-custom-color"));
$header_font_color = esc_attr(Seofy_Theme_Helper::get_option('header-font')['color']);
$main_font_color = esc_attr(Seofy_Theme_Helper::get_option('main-font')['color']);
$theme_gradient_start = esc_attr(Seofy_Theme_Helper::get_option('theme-gradient')['from']);
$theme_gradient_end = esc_attr(Seofy_Theme_Helper::get_option('theme-gradient')['to']);

if (function_exists('vc_map')) {
	vc_map(array(
		'name' => esc_html__('Pricing Table', 'seofy'),
		'base' => 'wgl_pricing_table',
		'class' => 'seofy_pricing_table',
		'category' => esc_html__('WGL Modules', 'seofy'),
		'icon' => 'wgl_icon_price_table',
		'content_element' => true,
		'description' => esc_html__('Place Pricing Table','seofy'),
		'params' => array(
			// GENERAL TAB
			array(
				'type' => 'textfield',
				'heading' => esc_html__('Pricing Table Title', 'seofy'),
				'param_name' => 'pricing_title',
				'admin_label' => true,
			),
			array(
				'type' => 'textfield',
				'heading' => esc_html__('Currency', 'seofy'),
				'param_name' => 'pricing_cur',
				'edit_field_class' => 'vc_col-sm-2',
			),
			array(
				'type' => 'textfield',
				'heading' => esc_html__('Price', 'seofy'),
				'param_name' => 'pricing_price',
				'edit_field_class' => 'vc_col-sm-2',
				'admin_label' => true,
			),
			array(
				'type' => 'textfield',
				'heading' => esc_html__('Descriptions', 'seofy'),
				'param_name' => 'pricing_desc',
				'edit_field_class' => 'vc_col-sm-8',
			),
			vc_map_add_css_animation( true ),
			array(
				'type' => 'textfield',
				'heading' => esc_html__('Extra Class', 'seofy'),
				'param_name' => 'extra_class',
				'description' => esc_html__('Add an extra class name to the element and refer to it from Custom CSS option.', 'seofy')
			),
			// ICON TAB
			// Pricing Table Icon/Image heading
			array(
				'type' => 'seofy_param_heading',
				'heading' => esc_html__('Icon Type', 'seofy'),
				'param_name' => 'h_icon_type',
				'group' => esc_html__( 'Icon', 'seofy' ),
				'edit_field_class' => 'vc_col-sm-12 no-top-margin',
			),
			// Pricing Table Icon/Image
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
				'value' => '#ffffff',
				'description' => esc_html__('Select icon color', 'seofy'),
				'dependency' => array(
					'element' => 'custom_icon_color',
					'value' => 'true'
				),
				'group' => esc_html__( 'Icon', 'seofy' ),
				'edit_field_class' => 'vc_col-sm-4',
			),   
			// CONTENT TAB
			array(
				'type' => 'textarea_html',
				'holder' => 'div',
				'heading' => esc_html__('Content.', 'seofy'),
				'param_name' => 'content',
				'group' => esc_html__( 'Content', 'seofy' ),
				'admin_label' => false,
			),
			// description
			array(
				'type' => 'textarea',
				'heading' => esc_html__('Description Text', 'seofy'),
				'param_name' => 'descr_text',
				'group' => esc_html__( 'Content', 'seofy' ),
			),
			// add button header
			array(
				'type' => 'seofy_param_heading',
				'heading' => esc_html__('Add Button', 'seofy'),
				'param_name' => 'h_button',
				'group' => esc_html__( 'Content', 'seofy' ),
				'edit_field_class' => 'vc_col-sm-12',
			),
			// Button
			array(
				'type' => 'textfield',
				'heading' => esc_html__('Button Text', 'seofy'),
				'param_name' => 'button_title',
				'value' => esc_html__('BUY NOW', 'seofy'),
				'group' => esc_html__( 'Content', 'seofy' ),
			),
			// Link
			array(
				'type' => 'vc_link',
				'heading' => esc_html__( 'Button Link', 'seofy' ),
				'param_name' => 'link',
				'description' => esc_html__('Add link to button.', 'seofy'),
				'group' => esc_html__( 'Content', 'seofy' )
			),
			// Button customize
			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Customize', 'seofy' ),
				'param_name' => 'button_customize',
				'value' => array(
					esc_html__( 'Default', 'seofy' )  => 'def',
					esc_html__( 'Color', 'seofy' )    => 'color',
					esc_html__( 'Gradient', 'seofy' ) => 'gradient',
				),
				'group' => esc_html__( 'Content', 'seofy' ),
			),
			// Header for button text color
			array(
				'type' => 'seofy_param_heading',
				'heading' => esc_html__('Text Color', 'seofy'),
				'param_name' => 'h_text_color',
				'dependency' => array(
					'element' => 'button_customize',
					'value' => array('color', 'gradient')
				),
				'group' => esc_html__( 'Content', 'seofy' ),
				'edit_field_class' => 'vc_col-sm-12',
			),
			// Button text color
			array(
				'type' => 'colorpicker',
				'class' => '',
				'heading' => esc_html__('Text Color', 'seofy'),
				'param_name' => 'button_text_color',
				'value' => '#ffffff',
				'description' => esc_html__('Select custom color for idle state.', 'seofy'),
				'dependency' => array(
					'element' => 'button_customize',
					'value' => array('color', 'gradient')
				),
				'group' => esc_html__( 'Content', 'seofy' ),
				'edit_field_class' => 'vc_col-sm-6',
			),
			// Button hover text color
			array(
				'type' => 'colorpicker',
				'class' => '',
				'heading' => esc_html__('Hover Text Color', 'seofy'),
				'param_name' => 'button_text_color_hover',
				'value' => $header_font_color,
				'description' => esc_html__('Select custom color for hover state.', 'seofy'),
				'dependency' => array(
					'element' => 'button_customize',
					'value' => array('color', 'gradient')
				),
				'group' => esc_html__( 'Content', 'seofy' ),
				'edit_field_class' => 'vc_col-sm-6',
			),
			// Header for button bg
			array(
				'type' => 'seofy_param_heading',
				'heading' => esc_html__('Background Color', 'seofy'),
				'param_name' => 'h_background_color',
				'group' => esc_html__( 'Content', 'seofy' ),
				'edit_field_class' => 'vc_col-sm-12',
				'dependency' => array(
					'element' => 'button_customize',
					'value' => 'color'
				),
			),
			// Button bg
			array(
				'type' => 'colorpicker',
				'class' => '',
				'heading' => esc_html__('Button background', 'seofy'),
				'param_name' => 'button_bg_color',
				'value' => '#ffffff',
				'save_always' => true,
				'description' => esc_html__('Select custom color for idle state.', 'seofy'),
				'dependency' => array(
					'element' => 'button_customize',
					'value' => 'color'
				),
				'group' => esc_html__( 'Content', 'seofy' ),
				'edit_field_class' => 'vc_col-sm-6',
			),
			// Button hover bg
			array(
				'type' => 'colorpicker',
				'class' => '',
				'heading' => esc_html__('Hover Background', 'seofy'),
				'param_name' => 'button_bg_color_hover',
				'value' => $theme_color,
				'save_always' => true,
				'description' => esc_html__('Select custom for hover state.', 'seofy'),
				'dependency' => array(
					'element' => 'button_customize',
					'value' => 'color'
				),
				'group' => esc_html__( 'Content', 'seofy' ),
				'edit_field_class' => 'vc_col-sm-6',
			),
			// Header for button bg gradients
			array(
				'type' => 'seofy_param_heading',
				'heading' => esc_html__('Background Gradient Color', 'seofy'),
				'param_name' => 'h_button_background_gradient_color',
				'group' => esc_html__( 'Content', 'seofy' ),
				'edit_field_class' => 'vc_col-sm-12',
				'dependency' => array(
					'element' => 'button_customize',
					'value' => 'gradient'
				),
			),
			// Button bg gradient start
			array(
				'type' => 'colorpicker',
				'class' => '',
				'heading' => esc_html__('Start Color', 'seofy'),
				'param_name' => 'button_bg_gradient_start',
				'value' => $theme_gradient_start,
				'save_always' => true,
				'dependency' => array(
					'element' => 'button_customize',
					'value' => 'gradient'
				),
				'group' => esc_html__( 'Content', 'seofy' ),
				'edit_field_class' => 'vc_col-sm-6',
			),
			// Button bg gradient end
			array(
				'type' => 'colorpicker',
				'class' => '',
				'heading' => esc_html__('End Color', 'seofy'),
				'param_name' => 'button_bg_gradient_end',
				'value' => $theme_gradient_end,
				'save_always' => true,
				'dependency' => array(
					'element' => 'button_customize',
					'value' => 'gradient'
				),
				'group' => esc_html__( 'Content', 'seofy' ),
				'edit_field_class' => 'vc_col-sm-6',
			),
			// Header for button bg hover gradients
			array(
				'type' => 'seofy_param_heading',
				'heading' => esc_html__('Background Gradient Hover Color', 'seofy'),
				'param_name' => 'h_background_gradient_hover_color',
				'group' => esc_html__( 'Content', 'seofy' ),
				'edit_field_class' => 'vc_col-sm-12',
				'dependency' => array(
					'element' => 'button_customize',
					'value' => 'gradient'
				),
			),
			// Button bg gradient hover start
			array(
				'type' => 'colorpicker',
				'class' => '',
				'heading' => esc_html__('Start Color', 'seofy'),
				'param_name' => 'button_bg_gradient_start_hover',
				'value' => $theme_gradient_end,
				'save_always' => true,
				'dependency' => array(
					'element' => 'button_customize',
					'value' => 'gradient'
				),
				'group' => esc_html__( 'Content', 'seofy' ),
				'edit_field_class' => 'vc_col-sm-6',
			),
			// Button bg gradient hover end
			array(
				'type' => 'colorpicker',
				'class' => '',
				'heading' => esc_html__('End Color', 'seofy'),
				'param_name' => 'button_bg_gradient_end_hover',
				'value' => $theme_gradient_start,
				'save_always' => true,
				'dependency' => array(
					'element' => 'button_customize',
					'value' => 'gradient'
				),
				'group' => esc_html__( 'Content', 'seofy' ),
				'edit_field_class' => 'vc_col-sm-6',
			),
			// Header for button border color 
			array(
				'type' => 'seofy_param_heading',
				'heading' => esc_html__('Border Color', 'seofy'),
				'param_name' => 'h_border_color',
				'dependency' => array(
					'element' => 'button_customize',
					'value' => 'color'
				),
				'group' => esc_html__( 'Content', 'seofy' ),
				'edit_field_class' => 'vc_col-sm-12',
			),
			// Button border color
			array(
				'type' => 'colorpicker',
				'class' => '',
				'heading' => esc_html__('Border Color', 'seofy'),
				'param_name' => 'button_border_color',
				'value' => $theme_color,
				'description' => esc_html__('Select custom color idle state.', 'seofy'),
				'dependency' => array(
					'element' => 'button_customize',
					'value' => 'color'
				),
				'group' => esc_html__( 'Content', 'seofy' ),
				'edit_field_class' => 'vc_col-sm-6',
			),
			// Button hover border color
			array(
				'type' => 'colorpicker',
				'class' => '',
				'heading' => esc_html__('Hover Border Color', 'seofy'),
				'param_name' => 'button_border_color_hover',
				'value' => $theme_color,
				'description' => esc_html__('Select custom color for hover state.', 'seofy'),
				'dependency' => array(
					'element' => 'button_customize',
					'value' => 'color'
				),
				'group' => esc_html__( 'Content', 'seofy' ),
				'edit_field_class' => 'vc_col-sm-6',
			),
			// Header for button border gradients
			array(
				'type' => 'seofy_param_heading',
				'heading' => esc_html__('Border Gradient Color', 'seofy'),
				'param_name' => 'h_border_gradient_color',
				'dependency' => array(
					'element' => 'button_customize',
					'value' => 'gradient'
				),
				'group' => esc_html__( 'Content', 'seofy' ),
				'edit_field_class' => 'vc_col-sm-12',
			),
			// Button border gradient start
			array(
				'type' => 'colorpicker',
				'class' => '',
				'heading' => esc_html__('Start Color', 'seofy'),
				'param_name' => 'button_border_gradient_start',
				'value' => $theme_gradient_start,
				'dependency' => array(
					'element' => 'button_customize',
					'value' => 'gradient'
				),
				'group' => esc_html__( 'Content', 'seofy' ),
				'edit_field_class' => 'vc_col-sm-6',
			),
			// Button border gradient end
			array(
				'type' => 'colorpicker',
				'class' => '',
				'heading' => esc_html__('End Color', 'seofy'),
				'param_name' => 'button_border_gradient_end',
				'value' => $theme_gradient_end,
				'dependency' => array(
					'element' => 'button_customize',
					'value' => 'gradient'
				),
				'group' => esc_html__( 'Content', 'seofy' ),
				'edit_field_class' => 'vc_col-sm-6',
			),
			// Header for button border hover gradients
			array(
				'type' => 'seofy_param_heading',
				'heading' => esc_html__('Border Gradient Hover Color', 'seofy'),
				'param_name' => 'h_border_gradient_hover_color',
				'dependency' => array(
					'element' => 'button_customize',
					'value' => 'gradient'
				),
				'group' => esc_html__( 'Content', 'seofy' ),
				'edit_field_class' => 'vc_col-sm-12',
			),
			// Button border gradient start hover
			array(
			    'type' => 'colorpicker',
			    'class' => '',
			    'heading' => esc_html__('Start Color', 'seofy'),
			    'param_name' => 'button_border_gradient_start_hover',
			    'value' => $theme_gradient_end,
			    'dependency' => array(
			        'element' => 'button_customize',
			        'value' => 'gradient'
			    ),
			    'group' => esc_html__( 'Content', 'seofy' ),
			    'edit_field_class' => 'vc_col-sm-6',
			),
			// Button border gradient end hover
			array(
			    'type' => 'colorpicker',
			    'class' => '',
			    'heading' => esc_html__('End Color', 'seofy'),
			    'param_name' => 'button_border_gradient_end_hover',
			    'value' => $theme_gradient_start,
			    'dependency' => array(
			        'element' => 'button_customize',
			        'value' => 'gradient'
			    ),
			    'group' => esc_html__( 'Content', 'seofy' ),
			    'edit_field_class' => 'vc_col-sm-6',
			),
			// BACKGROUND TAB
			array(
				'type' => 'seofy_param_heading',
				'heading' => esc_html__('Pricing Table Background', 'seofy'),
				'param_name' => 'h_pricing_customize',
				'group' => esc_html__( 'Background', 'seofy' ),
				'edit_field_class' => 'vc_col-sm-12 no-top-margin',
			),
			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Customization', 'seofy' ),
				'param_name' => 'pricing_customize',
				'value' => array(
					esc_html__( 'Default', 'seofy' ) => 'def',
					esc_html__( 'Color', 'seofy' )   => 'color',
					esc_html__( 'Image', 'seofy' )   => 'image',
				),
				'group' => esc_html__( 'Background', 'seofy' ),
				'edit_field_class' => 'vc_col-sm-6 no-top-margin',
			),
			// Pricing table bg color
			array(
				'type' => 'colorpicker',
				'class' => '',
				'heading' => esc_html__('Background', 'seofy'),
				'param_name' => 'pricing_bg_color',
				'value' => $theme_color,
				'description' => esc_html__('Select custom background for pricing table.', 'seofy'),
				'save_always' => true,
				'dependency' => array(
					'element' => 'pricing_customize',
					'value'   => array('color')
				),
				'group' => esc_html__( 'Background', 'seofy' ),
				'edit_field_class' => 'vc_col-sm-6',
			),
			// Pricing table bg image
			array(
				'type' => 'attach_image',
				'heading' => esc_html__( 'Background Header Image', 'seofy' ),
				'param_name'  => 'pricing_bg_image',
				'value' => '',
				'description' => esc_html__( 'Select image from media library.', 'seofy' ),
				'dependency' => array(
					'element' => 'pricing_customize',
					'value'   => 'image',
				),
				'group' => esc_html__( 'Background', 'seofy' ),
				'edit_field_class' => 'vc_col-sm-6',
			),
			// Header bg
			array(
				'type' => 'seofy_param_heading',
				'heading' => esc_html__('Header Background', 'seofy'),
				'param_name' => 'h_header_customize',
				'dependency' => array(
					'element' => 'pricing_customize',
					'value'   => 'def',
				),
				'group' => esc_html__( 'Background', 'seofy' ),
				'edit_field_class' => 'vc_col-sm-12',
			),
			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Customization', 'seofy' ),
				'param_name' => 'header_customize',
				'value' => array(
					esc_html__( 'Default', 'seofy' ) => 'def',
					esc_html__( 'Color', 'seofy' )   => 'color',
					esc_html__( 'Image', 'seofy' )   => 'image',
				),
				'dependency' => array(
					'element' => 'pricing_customize',
					'value'   => 'def',
				),
				'group' => esc_html__( 'Background', 'seofy' ),
				'edit_field_class' => 'vc_col-sm-6 no-top-margin',
			),
			// Header bg color
			array(
				'type' => 'colorpicker',
				'class' => '',
				'heading' => esc_html__('Background', 'seofy'),
				'param_name' => 'header_bg_color',
				'value' => $theme_color,
				'description' => esc_html__('Select custom background for header.', 'seofy'),
				'save_always' => true,
				'dependency' => array(
					'element' => 'header_customize',
					'value' => array('color')
				),
				'group' => esc_html__( 'Background', 'seofy' ),
				'edit_field_class' => 'vc_col-sm-6',
			),
			// Header bg gradient
			array(
				'type' => 'seofy_param_heading',
				'heading' => esc_html__('Background Gradient Color', 'seofy'),
				'param_name' => 'h_background_gradient_color',
				'group' => esc_html__( 'Background', 'seofy' ),
				'edit_field_class' => 'vc_col-sm-12',
				'dependency' => array(
					'element' => 'header_customize',
					'value' => array('gradient')
				),
			),
			// Header bg image
			array(
				'type' => 'attach_image',
				'heading' => esc_html__( 'Background Header Image', 'seofy' ),
				'param_name'  => 'header_bg_image',
				'value' => '',
				'description' => esc_html__( 'Select image from media library.', 'seofy' ),
				'dependency' => array(
					'element' => 'header_customize',
					'value' => 'image',
				),
				'group' => esc_html__( 'Background', 'seofy' ),
				'edit_field_class' => 'vc_col-sm-6',
			),
			array(
				'type' => 'seofy_param_heading',
				'heading' => esc_html__('Content Background', 'seofy'),
				'param_name' => 'h_content_style',
				'dependency' => array(
					'element' => 'pricing_customize',
					'value' => 'def',
				),
				'group' => esc_html__( 'Background', 'seofy' ),
				'edit_field_class' => 'vc_col-sm-12',
			),
			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Customize', 'seofy' ),
				'param_name' => 'content_customize',
				'value' => array(
					esc_html__( 'Default', 'seofy' ) => 'def',
					esc_html__( 'Color', 'seofy' )   => 'color',
				),
				'dependency' => array(
					'element' => 'pricing_customize',
					'value' => 'def',
				),
				'group' => esc_html__( 'Background', 'seofy' ),
				'edit_field_class' => 'vc_col-sm-6 no-top-margin',
			),
			// Content bg color
			array(
				'type' => 'colorpicker',
				'class' => '',
				'heading' => esc_html__('Background', 'seofy'),
				'param_name'  => 'content_bg_color',
				'value' => '#ffffff',
				'description' => esc_html__('Select custom background for content.', 'seofy'),
				'save_always' => true,
				'dependency'  => array(
					'element' => 'content_customize',
					'value'   => array('color')
				),
				'group' => esc_html__( 'Background', 'seofy' ),
				'edit_field_class' => 'vc_col-sm-6',
			),
			// TYPOGRAPHY TAB
			// Title styles heading
			array(
				'type' => 'seofy_param_heading',
				'heading' => esc_html__('Title Styles', 'seofy'),
				'param_name' => 'h_title_styles',
				'group' => esc_html__( 'Typography', 'seofy' ),
				'edit_field_class' => 'vc_col-sm-12 no-top-margin',
			),
			// Title font size
			array(
				'type' => 'textfield',
				'heading' => esc_html__('Title Font Size', 'seofy'),
				'param_name' => 'title_size',
				'value' => '',
				'description' => esc_html__( 'Enter title font-size in pixels.', 'seofy' ),
				'group' => esc_html__( 'Typography', 'seofy' ),
				'edit_field_class' => 'vc_col-sm-6',
			),
			// Title font weight
			array(
				'type' => 'textfield',
				'heading' => esc_html__('Title Font Weight', 'seofy'),
				'param_name' => 'title_weight',
				'value' => '',
				'description' => esc_html__( 'Enter font-weight.', 'seofy' ),
				'group' => esc_html__( 'Typography', 'seofy' ),
				'edit_field_class' => 'vc_col-sm-6',
			),
			// Title fonts
			array(
				'type' => 'wgl_checkbox',
				'heading' => esc_html__( 'Custom font family for pricing table title', 'seofy' ),
				'param_name' => 'custom_fonts_title',
				'description' => esc_html__( 'Customize font family', 'seofy' ),
				'group' => esc_html__( 'Typography', 'seofy' ),
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
			// Title color checkbox
			array(
				'type' => 'wgl_checkbox',
				'heading' => esc_html__( 'Use Custom Title Color', 'seofy' ),
				'param_name' => 'custom_title_color',
				'description' => esc_html__( 'Select custom color', 'seofy' ),
				'group' => esc_html__( 'Typography', 'seofy' ),
				'edit_field_class' => 'vc_col-sm-4',
			),
			// Title color
			array(
				'type' => 'colorpicker',
				'heading' => esc_html__('Title Color', 'seofy'),
				'param_name' => 'title_color',
				'value' => '#ffffff',
				'description' => esc_html__('Select custom color', 'seofy'),
				'dependency' => array(
					'element' => 'custom_title_color',
					'value' => 'true'
				),
				'group' => esc_html__( 'Typography', 'seofy' ),
				'edit_field_class' => 'vc_col-sm-4',
			),
			// Title border color
			array(
				'type' => 'colorpicker',
				'heading' => esc_html__('Title Border Color', 'seofy'),
				'param_name' => 'title_border_color',
				'value' => '#ff7d00',
				'description' => esc_html__('Select custom color', 'seofy'),
				'dependency' => array(
					'element' => 'custom_title_color',
					'value' => 'true'
				),
				'group' => esc_html__( 'Typography', 'seofy' ),
				'edit_field_class' => 'vc_col-sm-4',
			),
			array(
				'type' => 'seofy_param_heading',
				'heading' => esc_html__('Price Styles', 'seofy'),
				'param_name' => 'h_content_styles',
				'group' => esc_html__( 'Typography', 'seofy' ),
				'edit_field_class' => 'vc_col-sm-12',
			),
			// Price Font Size
			array(
				'type' => 'textfield',
				'heading' => esc_html__('Price Font Size', 'seofy'),
				'param_name' => 'price_size',
				'value' => '',
				'description' => esc_html__( 'Enter price font-size in pixels.', 'seofy' ),
				'group' => esc_html__( 'Typography', 'seofy' ),
				'edit_field_class' => 'vc_col-sm-4',
			),
			array(
				'type' => 'wgl_checkbox',
				'heading' => esc_html__( 'Use Custom Price Color', 'seofy' ),
				'param_name' => 'custom_price_color',
				'description' => esc_html__( 'Select custom color', 'seofy' ),
				'group' => esc_html__( 'Typography', 'seofy' ),
				'edit_field_class' => 'vc_col-sm-4',
			),
			// title color
			array(
				'type' => 'colorpicker',
				'heading' => esc_html__('Price Color', 'seofy'),
				'param_name' => 'price_color',
				'value' => $header_font_color,
				'description' => esc_html__('Select price color', 'seofy'),
				'dependency' => array(
					'element' => 'custom_price_color',
					'value' => 'true'
				),
				'group' => esc_html__( 'Typography', 'seofy' ),
				'edit_field_class' => 'vc_col-sm-4',
			),
			// Pricing Description Styles
			array(
				'type' => 'seofy_param_heading',
				'heading' => esc_html__('Pricing Descriptions Styles', 'seofy'),
				'param_name' => 'description_styles',
				'group' => esc_html__( 'Typography', 'seofy' ),
				'edit_field_class' => 'vc_col-sm-12',
			),
			// pricing description font size 
			array(
				'type' => 'textfield',
				'heading' => esc_html__('Pricing Description Font Size', 'seofy'),
				'param_name' => 'description_size',
				'value' => '',
				'description' => esc_html__( 'Enter description font-size in pixels.', 'seofy' ),
				'group' => esc_html__( 'Typography', 'seofy' ),
				'edit_field_class' => 'vc_col-sm-4',
			),
			//  pricing description custom color checkbox
			array(
				'type' => 'wgl_checkbox',
				'heading' => esc_html__( 'Use Custom Description Color', 'seofy' ),
				'param_name' => 'custom_description_color',
				'description' => esc_html__( 'Select custom color', 'seofy' ),
				'value' => 'true',
				'group' => esc_html__( 'Typography', 'seofy' ),
				'edit_field_class' => 'vc_col-sm-4',
			),
			// pricing description custom color picker
			array(
				'type' => 'colorpicker',
				'heading' => esc_html__('Description Color', 'seofy'),
				'param_name' => 'description_color',
				'value' => '#b8b8b8',
				'description' => esc_html__('Select price color', 'seofy'),
				'dependency' => array(
					'element' => 'custom_description_color',
					'value' => 'true'
				),
				'group' => esc_html__( 'Typography', 'seofy' ),
				'edit_field_class' => 'vc_col-sm-4',
			),
		)
	));

	if (class_exists('WPBakeryShortCode')) {
		class WPBakeryShortCode_wgl_Pricing_Table extends WPBakeryShortCode {}
	}
}
