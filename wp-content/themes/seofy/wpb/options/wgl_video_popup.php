<?php
if ( ! defined( 'ABSPATH' ) ) {
    die( '-1' );
}

$theme_color = esc_attr(Seofy_Theme_Helper::get_option("theme-custom-color"));
$header_font_color = esc_attr(Seofy_Theme_Helper::get_option('header-font')['color']);
$theme_gradient_start = esc_attr(Seofy_Theme_Helper::get_option('theme-gradient')['from']);
$theme_gradient_end = esc_attr(Seofy_Theme_Helper::get_option('theme-gradient')['to']);


if (function_exists('vc_map')) {
    vc_map(array(
        'base' => 'wgl_video_popup',
        'name' => esc_html__('Video Popup', 'seofy'),
        'description' => esc_html__('Create a Button or Poster for Video Popup.', 'seofy'),
        'category' => esc_html__('WGL Modules', 'seofy'),
        'icon' => 'wgl_icon_video_popup',
        'params' => array(
            array(
                'type' => 'textfield',
                'heading' => esc_html__('Title', 'seofy'),
                'param_name' => 'title',
            ),
            array(
                'type' => 'dropdown',
                'heading' => esc_html__( 'Title Position', 'seofy' ),
                'param_name' => 'title_pos',
                'value' => array(
                    esc_html__( 'Left', 'seofy' )   => 'left',
                    esc_html__( 'Right', 'seofy' )  => 'right',
                    esc_html__( 'Top', 'seofy' )    => 'top',
                    esc_html__( 'Bottom', 'seofy' ) => 'bot',
                ),
                'std' => 'bot',
            ),
            array(
                'type' => 'dropdown',
                'heading' => esc_html__( 'Video Popup Button Alignment', 'seofy' ),
                'param_name' => 'button_pos',
                'value' => array(
                    esc_html__( 'Left', 'seofy' )   => 'left',
                    esc_html__( 'Center', 'seofy' ) => 'center',
                    esc_html__( 'Right', 'seofy' )  => 'right',
                    esc_html__( 'Inline', 'seofy' ) => 'inline',
                ),
                'std' => 'center',
            ),
            array(
                'type' => 'textfield',
                'heading' => esc_html__('Video Link', 'seofy'),
                'param_name' => 'link',
                'description' => esc_html__('Enter video link from youtube or vimeo.', 'seofy')
            ),
            array(
                'type' => 'attach_image',
                'heading' => esc_html__('Background Image/Video', 'seofy'),
                'param_name' => 'bg_image',
                'description' => esc_html__('Select video background image.', 'seofy')
            ),
            vc_map_add_css_animation( true ),
            array(
                'type' => 'textfield',
                'heading' => esc_html__('Extra Class', 'seofy'),
                'param_name' => 'extra_class',
                'description' => esc_html__('Add an extra class name to the element and refer to it from Custom CSS option.', 'seofy')
            ),
            // STYLING TAB
            array(
                'type' => 'seofy_param_heading',
                'heading' => esc_html__('Title Styles', 'seofy'),
                'param_name' => 'h_background_title_styles',
                'group' => esc_html__( 'Styling', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-12 no-top-margin',
            ),
            array(
                'type' => 'colorpicker',
                'heading' => esc_html__('Title color', 'seofy'),
                'param_name' => 'title_color',
                'value' => $header_font_color,
                'group' => esc_html__( 'Styling', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-6',
            ),
            array(
                'type' => 'wgl_checkbox',
                'heading' => esc_html__( 'Custom font family for Video Popup title?', 'seofy' ),
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
            array(
                'type' => 'textfield',
                'heading' => esc_html__('Video Popup Title Font Size', 'seofy'),
                'param_name' => 'title_size',
                'value' => '',
                'description' => esc_html__( 'Enter title font-size in pixels.', 'seofy' ),
                'group' => esc_html__( 'Styling', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-6',
            ),
            array(
                'type' => 'seofy_param_heading',
                'heading' => esc_html__('Button Styles', 'seofy'),
                'param_name' => 'h_background_title_styles',
                'group' => esc_html__( 'Styling', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-12',
            ),
            // Button diameter
            array(
                'type' => 'textfield',
                'heading' => esc_html__('Custom Button Size', 'seofy'),
                'param_name' => 'btn_size',
                'description' => esc_html__( 'Enter button diameter in pixels.', 'seofy' ),
                'group' => esc_html__( 'Styling', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-6',
            ),
            // Triangle size
            array(
                'type' => 'textfield',
                'heading' => esc_html__('Custom Triangle Size', 'seofy'),
                'param_name' => 'triangle_size',
                'description' => esc_html__( 'Enter triangle size in pixels.', 'seofy' ),
                'group' => esc_html__( 'Styling', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-6',
            ),
            // Triangle color
            array(
                'type' => 'colorpicker',
                'heading' => esc_html__('Custom Triangle Color', 'seofy'),
                'param_name' => 'triangle_color',
                'value' => '#ffffff',
                'group' => esc_html__( 'Styling', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-6',
            ),
            array(
                'type' => 'dropdown',
                'heading' => esc_html__( 'Background Customize Colors', 'seofy' ),
                'param_name' => 'bg_color_type',
                'value' => array(
                    esc_html__( 'Default', 'seofy' )  => 'def',
                    esc_html__( 'Color', 'seofy' )    => 'color',
                    esc_html__( 'Gradient', 'seofy' ) => 'gradient',
                ),
                'group' => esc_html__( 'Styling', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-12',
            ),
            array(
                'type' => 'colorpicker',
                'heading' => esc_html__('Background Color', 'seofy'),
                'param_name' => 'background_color',
                'value' => $theme_color,
                'description' => esc_html__('Select background color', 'seofy'),
                'dependency' => array(
                    'element' => 'bg_color_type',
                    'value' => 'color'
                ),
                'group' => esc_html__( 'Styling', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-6',
            ),
            array(
                'type' => 'colorpicker',
                'heading' => esc_html__('Background Start Color', 'seofy'),
                'param_name' => 'background_gradient_start',
                'value' => $theme_gradient_start,
                'dependency' => array(
                    'element' => 'bg_color_type',
                    'value' => 'gradient'
                ),
                'group' => esc_html__( 'Styling', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-6',
            ),
			array(
				'type' => 'colorpicker',
				'heading' => esc_html__('Background End Color', 'seofy'),
				'param_name' => 'background_gradient_end',
				'value' => $theme_gradient_end,
				'dependency' => array(
					'element' => 'bg_color_type',
					'value' => 'gradient'
				),
				'group' => esc_html__( 'Styling', 'seofy' ),
				'edit_field_class' => 'vc_col-sm-6',
			),
            // ANIMATION TAB
            // Animation style
            array(
                'type' => 'dropdown',
                'heading' => esc_html__( 'Select Animation Style', 'seofy' ),
                'param_name' => 'animation_style',
                'value' => array(
                    esc_html__( 'Pulse Ring', 'seofy' )    => 'animation_ring',
                    esc_html__( 'Pulse Circles', 'seofy' ) => 'animation_circles',
                ),
                'group' => esc_html__( 'Animation', 'seofy' ),
            ),
            array(
                'type' => 'wgl_checkbox',
                'heading' => esc_html__( 'Always Pulse Animation', 'seofy' ),
                'param_name' => 'always_pulse_anim',
                'description' => esc_html__('Run animation until hover.', 'seofy'),
                'group' => esc_html__( 'Animation', 'seofy' ),
            ),
			// Animation circles color
			array(
				'type' => 'seofy_param_heading',
				'heading' => esc_html__('Animation Customization', 'seofy'),
				'param_name' => 'animated_circles_styles',
                'dependency' => array(
                    'element' => 'animation_style',
                    'value' => 'animation_circles'
                ),
				'group' => esc_html__( 'Animation', 'seofy' ),
				'edit_field_class' => 'vc_col-sm-12',
			),
			array(
				'type' => 'colorpicker',
				'heading' => esc_html__('Animation Color', 'seofy'),
				'param_name' => 'animation_color',
				'value' => '#ffffff',
                'description' => esc_html__('Select color of animated circles', 'seofy'),
                'dependency' => array(
                    'element' => 'animation_style',
                    'value' => 'animation_circles'
                ),
				'group' => esc_html__( 'Animation', 'seofy' ),
				'edit_field_class' => 'vc_col-sm-4',
			),
		),
    ));

    class WPBakeryShortCode_wgl_Video_Popup extends WPBakeryShortCode { }

}