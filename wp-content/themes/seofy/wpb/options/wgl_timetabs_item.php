<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

$theme_color_secondary	= esc_attr(Seofy_Theme_Helper::get_option("theme-secondary-color"));
$header_font_color = esc_attr(Seofy_Theme_Helper::get_option('header-font')['color']);


if (function_exists('vc_map')) {
	vc_map(array(
		'name' => esc_html__('Time Tab Item', 'seofy'),
		'base' => 'wgl_timetabs_item',
		'class' => 'seofy_time_line_vertical',
		'category' => esc_html__('WGL Modules', 'seofy'),
		'icon' => 'wgl_icon_vertical-timeline',
		'as_child' => array('only' => 'wgl_timetabs_container'),
		'content_element' => true,
		'description' => esc_html__('Time tabs item','seofy'),
		'params' => array(
			array(
				'type' => 'textfield',
				'heading' => esc_html__('Time', 'seofy'),
				'param_name' => 'time',
				'admin_label' => true,
				'value' => esc_html__( '11.00 am - 01.00 pm', 'seofy' ),
			),
			array(
				'type' => 'textfield',
				'heading' => esc_html__('Title', 'seofy'),
				'param_name' => 'title',
				'admin_label' => true,
				'value' => esc_html__( 'Event Title', 'seofy' ),
			),
			array(
				'type' => 'attach_image',
				'heading' => esc_html__( 'Image', 'seofy' ),
				'param_name' => 'thumbnail',
				'value' => '',
				'description' => esc_html__( 'Select image from media library.', 'seofy' ),
			),
			// Content Section
			array(
				'type' => 'textarea',
				'heading' => esc_html__('Event description', 'seofy'),
				'param_name' => 'description',
			),
			//Button settings
			array(
				'type' => 'seofy_param_heading',
				'heading' => esc_html__('Button Customize', 'seofy'),
				'param_name' => 'h_button',
				'group' => esc_html__( 'Button', 'seofy' ),
				'edit_field_class' => 'vc_col-sm-12 no-top-margin',
			),
			array(
				'type' => 'textfield',
				'heading' => esc_html__('Button Text', 'seofy'),
				'value' => esc_html__('Read more', 'seofy'),
				'param_name' => 'button_text',
				'group' => esc_html__( 'Button', 'seofy' ),
			),
			array(
				'type' => 'vc_link',
				'heading' => esc_html__( 'Button Link', 'seofy' ),
				'param_name' => 'button_link',
				'group' => esc_html__( 'Button', 'seofy' ),
			),
			// Button size header
			array(
				'type' => 'seofy_param_heading',
				'heading' => esc_html__('Button Size', 'seofy'),
				'param_name' => 'h_button_size',
				'group' => esc_html__( 'Button', 'seofy' ),
				'edit_field_class' => 'vc_col-sm-6',
			),
			// Button shadow header
			array(
				'type' => 'seofy_param_heading',
				'heading' => esc_html__('Button Shadow', 'seofy'),
				'param_name' => 'h_button_shadow',
				'group' => esc_html__( 'Button', 'seofy' ),
				'edit_field_class' => 'vc_col-sm-6',
			),
			// Button size options
			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Button Size', 'seofy' ),
				'description' => esc_html__('Select button size.', 'seofy'),
				'param_name' => 'button_size',
				'value' => array(
					esc_html__( 'Small', 'seofy' )  => 's',
					esc_html__( 'Medium', 'seofy' ) => 'm',
					esc_html__( 'Large', 'seofy' )  => 'l',
					esc_html__( 'Extra Large', 'seofy' ) => 'xl',
				),
				'std' => 'm',
				'group' => esc_html__( 'Button', 'seofy' ),
				'edit_field_class' => 'vc_col-sm-6',
			),
			// Button shadow options
			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Button Shadow Style', 'seofy' ),
				'description' => esc_html__('Select button shadow style.', 'seofy'),
				'param_name' => 'button_shadow_style',
				'value' => array(
					esc_html__( 'None', 'seofy' )     => 'none',
					esc_html__( 'Always', 'seofy' )   => 'always',
					esc_html__( 'On Hover', 'seofy' ) => 'on_hover',
					esc_html__( 'Before Hover', 'seofy' ) => 'before_hover',
				),
				'std' => 'on_hover',
				'group' => esc_html__( 'Button', 'seofy' ),
				'edit_field_class' => 'vc_col-sm-6',
			),
			array(
				'type'		 => 'dropdown',
				'heading' 	 => esc_html__( 'Customize', 'seofy' ),
				'description' => esc_html__('Show options for color customizing.', 'seofy'),
				'param_name' => 'button_customize',
				'value'		 => array(
					esc_html__( 'Default', 'seofy' ) => 'def',
					esc_html__( 'Color', 'seofy' )   => 'color',
				),
				'std'		=> 'color',
				'group' 	=> esc_html__( 'Button', 'seofy' ),
			),
			array(
				'type' 		 => 'seofy_param_heading',
				'heading' 	 => esc_html__('Text Color', 'seofy'),
				'param_name' => 'h_text_color',
				'dependency' => array(
					'element' => 'button_customize',
					'value'   => 'color'
				),
				'group' => esc_html__( 'Button', 'seofy' ),
				'edit_field_class' => 'vc_col-sm-12',
			),
			array(
				'type' => 'colorpicker',
				'class' => '',
				'heading' => esc_html__('Text Color', 'seofy'),
				'description' => esc_html__('Select custom text color for button.', 'seofy'),
				'param_name' => 'button_text_color',
				'value' => $header_font_color,
				'dependency'  => array(
					'element' => 'button_customize',
					'value'   => 'color'
				),
				'save_always' => true,
				'group' => esc_html__( 'Button', 'seofy' ),
				'edit_field_class' => 'vc_col-sm-6',
			),
			array(
				'type' => 'colorpicker',
				'class' => '',
				'heading' => esc_html__('Hover Text Color', 'seofy'),
				'description' => esc_html__('Select custom text color for hover button.', 'seofy'),
				'param_name' => 'button_text_color_hover',
				'value' => '#ffffff',
				'dependency' => array(
					'element' => 'button_customize',
					'value' => 'color',
				),
				'save_always' => true,
				'group' => esc_html__( 'Button', 'seofy' ),
				'edit_field_class' => 'vc_col-sm-6',
			),
			array(
				'type' => 'seofy_param_heading',
				'heading' => esc_html__('Background Color', 'seofy'),
				'param_name' => 'h_background_color',
				'group' => esc_html__( 'Button', 'seofy' ),
				'edit_field_class' => 'vc_col-sm-12',
				'dependency' => array(
					'element' => 'button_customize',
					'value'   => 'color'
				),
			),
			array(
				'type' => 'colorpicker',
				'class' => '',
				'heading' 	  => esc_html__('Background', 'seofy'),
				'description' => esc_html__('Select custom background for button.', 'seofy'),
				'param_name' => 'button_bg_color',
				'value' => '#ffffff',
				'dependency' => array(
					'element' => 'button_customize',
					'value'   => 'color'
				),
				'save_always' => true,
				'group' => esc_html__( 'Button', 'seofy' ),
				'edit_field_class' => 'vc_col-sm-6',
			),
			array(
				'type' => 'colorpicker',
				'class' => '',
				'heading' => esc_html__('Hover Background', 'seofy'),
				'param_name' => 'button_bg_color_hover',
				'value' => $theme_color_secondary,
				'description' => esc_html__('Select custom background for hover button.', 'seofy'),
				'dependency' => array(
					'element' => 'button_customize',
					'value'   => 'color'
				),
				'save_always' => true,
				'group' => esc_html__( 'Button', 'seofy' ),
				'edit_field_class' => 'vc_col-sm-6',
			),
			// Button border-color header
			array(
				'type' => 'seofy_param_heading',
				'heading' => esc_html__('Border Color', 'seofy'),
				'param_name' => 'h_border_color',
				'dependency' => array(
					'element' => 'button_customize',
					'value' => 'color'
				),
				'group' => esc_html__( 'Button', 'seofy' ),
				'edit_field_class' => 'vc_col-sm-12',
			),
			// Button border-color
			array(
				'type' => 'colorpicker',
				'class' => '',
				'heading' => esc_html__('Border Color', 'seofy'),
				'description' => esc_html__('Select custom border color for button.', 'seofy'),
				'param_name' => 'button_border_color',
				'value' => $theme_color_secondary,
				'dependency' => array(
					'element' => 'button_customize',
					'value' => array('color')
				),
				'save_always' => true,
				'group' => esc_html__( 'Button', 'seofy' ),
				'edit_field_class' => 'vc_col-sm-6',
			),
			// Button Hover border-color
			array(
				'type' => 'colorpicker',
				'class' => '',
				'heading' => esc_html__('Hover Border Color', 'seofy'),
				'description' => esc_html__('Select custom border color for hover button.', 'seofy'),
				'param_name' => 'button_border_color_hover',
				'value' => $theme_color_secondary,
				'dependency' => array(
					'element' => 'button_customize',
					'value' => array('color')
				),
				'save_always' => true,
				'group' => esc_html__( 'Button', 'seofy' ),
				'edit_field_class' => 'vc_col-sm-6',
			),
			// Text Color Customize
			array(
				'type' => 'seofy_param_heading',
				'heading' => esc_html__('Text Color Customize', 'seofy'),
				'param_name' => 'h_text_colors',
				'group' => esc_html__( 'Styles', 'seofy' ),
				'edit_field_class' => 'vc_col-sm-12 no-top-margin',
			),
			// Time Custom Color
			array(
				'type' => 'wgl_checkbox',
				'heading' => esc_html__( 'Time Custom Color', 'seofy' ),
				'param_name' => 'time_custom_color',
				'group' => esc_html__( 'Styles', 'seofy' ),
				'edit_field_class' => 'vc_col-sm-7',
			),
			array(
				'type' => 'colorpicker',
				'heading' => esc_html__('Time Color', 'seofy'),
				'param_name' => 'time_color',
				'value' => '#ffffff',
				'description' => esc_html__('Select custom color', 'seofy'),
				'dependency' => array(
					'element' => 'time_custom_color',
					'value' => 'true'
				),
				'group' => esc_html__( 'Styles', 'seofy' ),
				'edit_field_class' => 'vc_col-sm-5',
			),
			// Title Custom Color
			array(
				'type' => 'wgl_checkbox',
				'heading' => esc_html__( 'Title Custom Color', 'seofy' ),
				'param_name' => 'title_custom_color',
				'group' => esc_html__( 'Styles', 'seofy' ),
				'edit_field_class' => 'vc_col-sm-7',
			),
			array(
				'type' => 'colorpicker',
				'heading' => esc_html__('Title Color', 'seofy'),
				'param_name' => 'title_color',
				'value' => '#ffffff',
				'description' => esc_html__('Select custom color', 'seofy'),
				'dependency' => array(
					'element' => 'title_custom_color',
					'value' => 'true'
				),
				'group' => esc_html__( 'Styles', 'seofy' ),
				'edit_field_class' => 'vc_col-sm-5',
			),
			// Description Custom Color
			array(
				'type' => 'wgl_checkbox',
				'heading' => esc_html__( 'Description Custom Color', 'seofy' ),
				'param_name' => 'description_custom_color',
				'group' => esc_html__( 'Styles', 'seofy' ),
				'edit_field_class' => 'vc_col-sm-7',
			),
			array(
				'type' => 'colorpicker',
				'heading' => esc_html__('Description Color', 'seofy'),
				'param_name' => 'description_color',
				'value' => '#dadada',
				'description' => esc_html__('Select custom color', 'seofy'),
				'dependency' => array(
					'element' => 'description_custom_color',
					'value' => 'true'
				),
				'group' => esc_html__( 'Styles', 'seofy' ),
				'edit_field_class' => 'vc_col-sm-5',
			),
			// Bg Color Customize
			array(
				'type' => 'seofy_param_heading',
				'heading' => esc_html__('Background Color Customize', 'seofy'),
				'param_name' => 'h_bg_color',
				'group' => esc_html__( 'Styles', 'seofy' ),
				'edit_field_class' => 'vc_col-sm-12',
			),
			array(
				'type' => 'wgl_checkbox',
				'heading' => esc_html__( 'Background Custom Color', 'seofy' ),
				'param_name' => 'bg_custom_color',
				'group' => esc_html__( 'Styles', 'seofy' ),
				'edit_field_class' => 'vc_col-sm-4',
			),
			array(
				'type' => 'colorpicker',
				'heading' => esc_html__('Background Color', 'seofy'),
				'param_name' => 'bg_color',
				'value' => '',
				'description' => esc_html__('Select custom color', 'seofy'),
				'dependency' => array(
					'element' => 'bg_custom_color',
					'value' => 'true'
				),
				'group' => esc_html__( 'Styles', 'seofy' ),
				'edit_field_class' => 'vc_col-sm-4',
			),
			array(
				'type' => 'colorpicker',
				'heading' => esc_html__('Background Hover Color', 'seofy'),
				'param_name' => 'bg_color_hover',
				'value' => '#131120',
				'description' => esc_html__('Select custom color', 'seofy'),
				'dependency' => array(
					'element' => 'bg_custom_color',
					'value' => 'true'
				),
				'group' => esc_html__( 'Styles', 'seofy' ),
				'edit_field_class' => 'vc_col-sm-4',
			),
		)
	));

	if (class_exists('WPBakeryShortCode')) {
		class WPBakeryShortCode_wgl_timetabs_item extends WPBakeryShortCode {
		}
	}
}