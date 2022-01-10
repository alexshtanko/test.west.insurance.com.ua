<?php
if ( ! defined( 'ABSPATH' ) ) {
    die( '-1' );
}

$theme_color = esc_attr(Seofy_Theme_Helper::get_option("theme-custom-color"));
$header_font = Seofy_Theme_Helper::get_option('header-font');

if (function_exists('vc_map')) {
    // Add button
    vc_map(array(
        'name' => esc_html__('Flip Box', 'seofy'),
        'base' => 'wgl_flip_box',
        'class' => 'seofy_flip_box',
        'category' => esc_html__('WGL Modules', 'seofy'),
        'icon' => 'wgl_icon_flip_box',
        'content_element' => true,
        'description' => esc_html__('Add Flip Box','seofy'),
        'params' => array(
            // GENERAL TAB
            array(
                'type' => 'dropdown',
                'heading' => esc_html__( 'Flip Direction', 'seofy' ),
                'param_name' => 'fb_dir',
                'value' => array(
                    esc_html__( 'Flip to Right', 'seofy' )  => 'flip_right',
                    esc_html__( 'Flip to Left', 'seofy' )   => 'flip_left',
                    esc_html__( 'Flip to Top', 'seofy' )    => 'flip_top',
                    esc_html__( 'Flip to Bottom', 'seofy' ) => 'flip_bottom',
                ),
                'admin_label' => true,
            ),
            array(
                'type' => 'textfield',
                'heading' => esc_html__('Custom Flip Box Height', 'seofy'),
                'param_name' => 'fb_height',
                'value' => '',
                'description' => esc_html__( 'Enter custom flip box height in pixels.', 'seofy' ),
            ),
            vc_map_add_css_animation( true ),
            array(
                'type' => 'textfield',
                'heading' => esc_html__('Extra Class', 'seofy'),
                'param_name' => 'extra_class',
                'description' => esc_html__('Add an extra class name to the element and refer to it from Custom CSS option.', 'seofy')
            ),
            // Front Side
            array(
                'type' => 'seofy_param_heading',
                'heading' => esc_html__('Front Side Background', 'seofy'),
                'param_name' => 'h_front_bg',
                'group' => esc_html__( 'Front Side', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-12 no-top-margin',
            ),
            array(
                'type' => 'dropdown',
                'param_name' => 'front_bg_style',
                'value' => array(
                    esc_html__( 'Color', 'seofy' ) => 'front_color',
                    esc_html__( 'Image', 'seofy' ) => 'front_image',
                ),
                'group' => esc_html__( 'Front Side', 'seofy' ),
            ),
            array(
                'type' => 'colorpicker',
                'heading' => esc_html__('Background Color', 'seofy'),
                'param_name' => 'front_bg_color',
                'value' => '#ffffff',
                'dependency' => array(
                    'element' => 'front_bg_style',
                    'value' => 'front_color'
                ),
                'group' => esc_html__( 'Front Side', 'seofy' ),
            ),
            array(
                'type' => 'attach_image',
                'heading' => esc_html__('Background Image', 'seofy'),
                'param_name' => 'front_bg_image',
                'description' => esc_html__( 'Select image from media library.', 'seofy' ),
                'dependency' => array(
                    'element' => 'front_bg_style',
                    'value' => 'front_image'
                ),
                'group' => esc_html__( 'Front Side', 'seofy' ),
            ),
            array(
                'type' => 'seofy_param_heading',
                'heading' => esc_html__('Front Side Content', 'seofy'),
                'param_name' => 'h_front_content',
                'group' => esc_html__( 'Front Side', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-12',
            ),
			array(
				'type' => 'attach_image',
				'heading' => esc_html__('Logo Image', 'seofy'),
				'param_name' => 'front_logo_image',
				'description' => esc_html__( 'Select image from media library.', 'seofy' ),
				'group' => esc_html__( 'Front Side', 'seofy' ),
			),
            array(
                'type' => 'textarea',
                'param_name' => 'front_title',
                'heading' => esc_html__('Title', 'seofy'),
                'group' => esc_html__( 'Front Side', 'seofy' ),
            ),
            array(
                'type' => 'colorpicker',
                'heading' => esc_html__('Title Color', 'seofy'),
                'param_name' => 'front_title_color',
                'value' => '#ffffff',
                'group' => esc_html__( 'Front Side', 'seofy' ),
            ),
            array(
                'type' => 'textarea',
                'param_name' => 'front_descr',
                'heading' => esc_html__('Description', 'seofy'),
                'group' => esc_html__( 'Front Side', 'seofy' ),
            ),
            array(
                'type' => 'colorpicker',
                'heading' => esc_html__('Description Color', 'seofy'),
                'param_name' => 'front_descr_color',
                'value' => '#ffffff',
                'group' => esc_html__( 'Front Side', 'seofy' ),
            ),
            // BACK SIDE
            array(
                'type' => 'seofy_param_heading',
                'heading' => esc_html__('Back Side Background', 'seofy'),
                'param_name' => 'h_back_bg',
                'group' => esc_html__( 'Back Side', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-12 no-top-margin',
            ),
            array(
                'type' => 'dropdown',
                'param_name' => 'back_bg_style',
                'value' => array(
                    esc_html__( 'Color', 'seofy' ) => 'back_color',
                    esc_html__( 'Image', 'seofy' ) => 'back_image',
                ),
                'group' => esc_html__( 'Back Side', 'seofy' ),
            ),
            array(
                'type' => 'colorpicker',
                'heading' => esc_html__('Background Color', 'seofy'),
                'param_name' => 'back_bg_color',
                'value' => $theme_color,
                'dependency' => array(
                    'element' => 'back_bg_style',
                    'value' => 'back_color'
                ),
                'group' => esc_html__( 'Back Side', 'seofy' ),
            ),
            array(
                'type' => 'attach_image',
                'heading' => esc_html__('Background Image', 'seofy'),
                'param_name' => 'back_bg_image',
                'description' => esc_html__( 'Select image from media library.', 'seofy' ),
                'dependency' => array(
                    'element' => 'back_bg_style',
                    'value' => 'back_image'
                ),
                'group' => esc_html__( 'Back Side', 'seofy' ),
            ),
            array(
                'type' => 'seofy_param_heading',
                'heading' => esc_html__('Back Side Content', 'seofy'),
                'param_name' => 'h_back_title',
                'group' => esc_html__( 'Back Side', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-12',
            ),
			array(
				'type' => 'wgl_checkbox',
				'heading' => esc_html__( 'Add Logo Image', 'seofy' ),
				'param_name' => 'add_back_logo_image',
				'value' => false,
				'group' => esc_html__( 'Back Side', 'seofy' ),
				'edit_field_class' => 'vc_col-sm-3',
			),
			array(
				'type' => 'attach_image',
				'heading' => esc_html__('Logo Image', 'seofy'),
				'param_name' => 'back_logo_image',
				'description' => esc_html__( 'Select image from media library.', 'seofy' ),
				'dependency' => array(
					'element' => 'add_back_logo_image',
					'value' => 'true'
				),
				'group' => esc_html__( 'Back Side', 'seofy' ),
				'edit_field_class' => 'vc_col-sm-9',
			),
            array(
                'type' => 'textfield',
                'param_name' => 'back_title',
                'heading' => esc_html__('Title', 'seofy'),
                'group' => esc_html__( 'Back Side', 'seofy' ),
            ),
            array(
                'type' => 'colorpicker',
                'heading' => esc_html__('Title Color', 'seofy'),
                'param_name' => 'back_title_color',
                'value' => '#ffffff',
                'group' => esc_html__( 'Back Side', 'seofy' ),
            ),
            array(
                'type' => 'textarea',
                'param_name' => 'back_descr',
                'heading' => esc_html__('Description', 'seofy'),
                'group' => esc_html__( 'Back Side', 'seofy' ),
            ),
            array(
                'type' => 'colorpicker',
                'heading' => esc_html__('Description Color', 'seofy'),
                'param_name' => 'back_descr_color',
                'value' => '#ffffff',
                'group' => esc_html__( 'Back Side', 'seofy' ),
            ),
            array(
                'type' => 'seofy_param_heading',
                'heading' => esc_html__('Back Side Button', 'seofy'),
                'param_name' => 'h_back_button',
                'group' => esc_html__( 'Back Side', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-12',
            ),
            array(
                'type' => 'wgl_checkbox',
                'heading' => esc_html__( 'Add Read More Button', 'seofy' ),
                'param_name' => 'add_read_more',
                'group' => esc_html__( 'Back Side', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-6',
            ),
            array(
                'type' => 'colorpicker',
                'heading' => esc_html__('Button Color', 'seofy'),
                'param_name' => 'back_button_color',
                'value' => '#ffffff',
                'group' => esc_html__( 'Back Side', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-6',
                'dependency' => array(
                    'element' => 'add_read_more',
                    'value' => 'true'
                ),
            ),
            array(
                'type' => 'textfield',
                'heading' => esc_html__('Read More Button Text', 'seofy'),
                'param_name' => 'read_more_text',
                'value' => esc_html__('Read More', 'seofy'),
                'group' => esc_html__( 'Back Side', 'seofy' ),
                'dependency' => array(
                    'element' => 'add_read_more',
                    'value' => 'true'
                ),
                'edit_field_class' => 'vc_col-sm-4',
            ),
            array(
                'type' => 'vc_link',
                'heading' => esc_html__( 'Link', 'seofy' ),
                'param_name' => 'link',
                'description' => esc_html__('Add link to read more button.', 'seofy'),
                'group' => esc_html__( 'Back Side', 'seofy' ),
                'dependency' => array(
                    'element' => 'add_read_more',
                    'value' => 'true'
                ),
            ),
            array(
                'type' => 'wgl_checkbox',
                'heading' => esc_html__( 'Add Icon to the Button', 'seofy' ),
                'param_name' => 'add_icon_button',
                'group' => esc_html__( 'Back Side', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-12',
                'dependency' => array(
                    'element' => 'add_read_more',
                    'value' => 'true'
                ),
            ),
            array(
                'type' => 'iconpicker',
                'heading' => esc_html__('Icon', 'seofy'),
                'param_name' => 'button_icon_fontawesome',
                'value' => 'fa fa-adjust', // default value to backend editor admin_label
                'settings' => array(
                    'emptyIcon' => false, // default true, display an 'EMPTY' icon?
                    'iconsPerPage' => 200, // default 100, how many icons per/page to display, we use (big number) to display all icons in single page
                ),
                'dependency' => array(
                    'element' => 'add_icon_button',
                    'value' => 'true'
                ),
                'description' => esc_html__( 'Select icon from library.', 'seofy' ),
                'group' => esc_html__( 'Back Side', 'seofy' ),
            ),
            array(
                'type' => 'dropdown',
                'heading' => esc_html__('Icon Position', 'seofy'),
                'param_name' => 'button_icon_position',
                'value' => array(
                    esc_html__('Left', 'seofy') => 'left',
                    esc_html__('Right', 'seofy') => 'right'
                ),
                'dependency' => array(
                    'element' => 'add_icon_button',
                    'value' => 'true'
                ),
                'group' => esc_html__( 'Back Side', 'seofy' ),
            ),
        )
    ));

    if (class_exists('WPBakeryShortCode')) {
        class WPBakeryShortCode_wgl_Flip_Box extends WPBakeryShortCode {
        }
    }
}