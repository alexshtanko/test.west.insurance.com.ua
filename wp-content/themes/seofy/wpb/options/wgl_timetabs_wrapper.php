<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

$theme_color = esc_attr(Seofy_Theme_Helper::get_option("theme-custom-color"));

if (function_exists('vc_map')) {
	vc_map(array(
		'name' => esc_html__('Time Tabs', 'seofy'),
		'base' => 'wgl_timetabs_wrapper',
		'class' => 'seofy_time_line_vertical',
		'category' => esc_html__('WGL Modules', 'seofy'),
		'icon' => 'wgl_icon_time_tabs',
		'as_parent' => array('only' => 'wgl_timetabs_container'),
		'content_element' => true,
		'show_settings_on_create' => false,
		'is_container' => true,
		'description' => esc_html__('Place Time Tabs','seofy'),
		'params' => array(
			// Title customize
			array(
				'type' => 'seofy_param_heading',
				'heading' => esc_html__('Title Customize', 'seofy'),
				'param_name' => 'h_title_colors',
				'group' => esc_html__( 'Styles', 'seofy' ),
				'edit_field_class' => 'vc_col-sm-12 no-top-margin',
			),
			// Title colors
			array(
				'type' => 'wgl_checkbox',
				'heading' => esc_html__( 'Title Custom Color', 'seofy' ),
				'param_name' => 'title_custom_color',
				'group' => esc_html__( 'Styles', 'seofy' ),
				'edit_field_class' => 'vc_col-sm-4',
			),
			array(
				'type' => 'colorpicker',
				'heading' => esc_html__('Title Color', 'seofy'),
				'param_name' => 'title_color',
				'value' => '#919191',
				'description' => esc_html__('Select custom color', 'seofy'),
				'dependency' => array(
					'element' => 'title_custom_color',
					'value' => 'true'
				),
				'group' => esc_html__( 'Styles', 'seofy' ),
				'edit_field_class' => 'vc_col-sm-4',
			),
			array(
				'type' => 'colorpicker',
				'heading' => esc_html__('Title Hover Color', 'seofy'),
				'param_name' => 'title_color_hover',
				'value' => '#ffffff',
				'description' => esc_html__('Select custom color', 'seofy'),
				'dependency' => array(
					'element' => 'title_custom_color',
					'value' => 'true'
				),
				'group' => esc_html__( 'Styles', 'seofy' ),
				'edit_field_class' => 'vc_col-sm-4',
			),
			// Subtitle customize
			array(
				'type' => 'seofy_param_heading',
				'heading' => esc_html__('Subtitle Customize', 'seofy'),
				'param_name' => 'h_subtitle_colors',
				'group' => esc_html__( 'Styles', 'seofy' ),
				'edit_field_class' => 'vc_col-sm-12',
			),
			array(
				'type' => 'wgl_checkbox',
				'heading' => esc_html__( 'Subtitle Custom Color', 'seofy' ),
				'param_name' => 'subtitle_custom_color',
				'group' => esc_html__( 'Styles', 'seofy' ),
				'edit_field_class' => 'vc_col-sm-4',
			),
			array(
				'type' => 'colorpicker',
				'heading' => esc_html__('Subtitle Color', 'seofy'),
				'param_name' => 'subtitle_color',
				'value' => '#dadada',
				'description' => esc_html__('Select custom color', 'seofy'),
				'dependency' => array(
					'element' => 'subtitle_custom_color',
					'value' => 'true'
				),
				'group' => esc_html__( 'Styles', 'seofy' ),
				'edit_field_class' => 'vc_col-sm-4',
			),
			array(
				'type' => 'colorpicker',
				'heading' => esc_html__('Subtitle Hover Color', 'seofy'),
				'param_name' => 'subtitle_color_hover',
				'value' => '#dadada',
				'description' => esc_html__('Select custom color', 'seofy'),
				'dependency' => array(
					'element' => 'subtitle_custom_color',
					'value' => 'true'
				),
				'group' => esc_html__( 'Styles', 'seofy' ),
				'edit_field_class' => 'vc_col-sm-4',
			),
			// Tab Bottom Bar
			array(
				'type' => 'seofy_param_heading',
				'heading' => esc_html__('Tab Bottom Bar Customize', 'seofy'),
				'param_name' => 'h_bar_colors',
				'group' => esc_html__( 'Styles', 'seofy' ),
				'edit_field_class' => 'vc_col-sm-12',
			),
			array(
				'type' => 'wgl_checkbox',
				'heading' => esc_html__( 'Tab Bottom Bar Color', 'seofy' ),
				'param_name' => 'bar_custom_color',
				'group' => esc_html__( 'Styles', 'seofy' ),
				'edit_field_class' => 'vc_col-sm-4',
			),
			array(
				'type' => 'colorpicker',
				'heading' => esc_html__('Bar Idle Color', 'seofy'),
				'param_name' => 'bar_color',
				'value' => 'rgba(255, 255, 255, 0.1)',
				'description' => esc_html__('Select custom color', 'seofy'),
				'dependency' => array(
					'element' => 'bar_custom_color',
					'value' => 'true'
				),
				'group' => esc_html__( 'Styles', 'seofy' ),
				'edit_field_class' => 'vc_col-sm-4',
			),
			array(
				'type' => 'colorpicker',
				'heading' => esc_html__('Bar Active Color', 'seofy'),
				'param_name' => 'bar_color_hover',
				'value' => $theme_color,
				'description' => esc_html__('Select custom color', 'seofy'),
				'dependency' => array(
					'element' => 'bar_custom_color',
					'value' => 'true'
				),
				'group' => esc_html__( 'Styles', 'seofy' ),
				'edit_field_class' => 'vc_col-sm-4',
			),
		),
		'js_view' => 'VcColumnView'
	));

	if (class_exists('WPBakeryShortCode')) {
		class WPBakeryShortCode_wgl_timetabs_wrapper extends WPBakeryShortCodesContainer {
		}
	}
}