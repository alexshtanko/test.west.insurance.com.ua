<?php
if ( ! defined( 'ABSPATH' ) ) {
    die( '-1' );
}

$theme_color = esc_attr(Seofy_Theme_Helper::get_option("theme-custom-color"));

if (function_exists('vc_map')) {
    // Add button
    vc_map(array(
        'name' => esc_html__('Services', 'seofy'),
        'base' => 'wgl_services',
        'class' => 'seofy_services',
        'category' => esc_html__('WGL Modules', 'seofy'),
        'icon' => 'wgl_icon_services',
        'content_element' => true,
        'description' => esc_html__('Add Services','seofy'),
        'params' => array(
            // General
            array(
                'type' => 'dropdown',
                'heading' => esc_html__( 'Service Animation', 'seofy' ),
                'param_name' => 'service_anim',
                'value'         => array(
                    esc_html__( 'Fade', 'seofy' )      => 'fade',
                    esc_html__( 'Front Side Slide', 'seofy' )      => 'front_slide',
                    esc_html__( 'Back Side Slide', 'seofy' )      => 'back_slide',
                ),
                'admin_label' => true,
            ),
            array(
                'type' => 'dropdown',
                'heading' => esc_html__( 'Animation Direction', 'seofy' ),
                'param_name' => 'anim_dir',
                'value'         => array(
                    esc_html__( 'Slide to Right', 'seofy' )      => 'to_right',
                    esc_html__( 'Slide to Left', 'seofy' )      => 'to_left',
                    esc_html__( 'Slide to Top', 'seofy' )      => 'to_top',
                    esc_html__( 'Slide to Bottom', 'seofy' )      => 'to_bottom',
                ),
                'dependency' => array(
                    'element' => 'service_anim',
                    'value' => array('front_slide','back_slide'),
                ),
            ),
            array(
                'type'          => 'dropdown',
                'heading'       => esc_html__( 'Alignment', 'seofy' ),
                'param_name'    => 'service_align',
                'value'         => array(
					esc_html__( 'Left', 'seofy' )   => 'left',
					esc_html__( 'Center', 'seofy' ) => 'center',
					esc_html__( 'Right', 'seofy' )  => 'right',
                ),
            ),
            vc_map_add_css_animation( true ),
            array(
                'type' => 'textfield',
                'heading' => esc_html__('Extra Class', 'seofy'),
                'param_name' => 'item_el_class',
                'description' => esc_html__('If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'seofy')
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
                'value'         => array(
                    esc_html__( 'Frame', 'seofy' )      => 'front_frame',
                    esc_html__( 'Color', 'seofy' )      => 'front_color',
                    esc_html__( 'Image', 'seofy' )      => 'front_image',
                ),
                'group' => esc_html__( 'Front Side', 'seofy' ),
            ),
            array(
                'type' => 'colorpicker',
                'heading' => esc_html__('Frame Color', 'seofy'),
                'param_name' => 'front_frame_color',
                'value' => 'rgba(255,255,255,0.3)',
                'dependency' => array(
                    'element' => 'front_bg_style',
                    'value' => array('front_frame','front_color')
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
                'heading' => esc_html__('Front Side Icon', 'seofy'),
                'param_name' => 'h_front_content',
                'group' => esc_html__( 'Front Side', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-12',
            ),
            // Info Box Icon/Image
            array(
                'type'          => 'dropdown',
                'param_name'    => 'front_icon_type',
                'value'         => array(
                    esc_html__( 'None', 'seofy' )      => 'none',
                    esc_html__( 'Font', 'seofy' )      => 'font',
                    esc_html__( 'Image', 'seofy' )     => 'image',
                ),
                'save_always' => true,
                'group' => esc_html__( 'Front Side', 'seofy' ),
            ),
            array(
                'type'          => 'dropdown',
                'param_name'    => 'front_icon_font_type',
                'value'         => array(
                    esc_html__( 'Fontawesome', 'seofy' )      => 'type_fontawesome',
                    esc_html__( 'Flaticon', 'seofy' )      => 'type_flaticon',
                ),
                'save_always' => true,
                'group' => esc_html__( 'Front Side', 'seofy' ),
                'dependency' => array(
                    'element' => 'front_icon_type',
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
                    'type' => 'fontawesome',
                    'iconsPerPage' => 200,
                    // default 100, how many icons per/page to display, we use (big number) to display all icons in single page
                ),
                'description' => esc_html__( 'Select icon from library.', 'seofy' ),
                'dependency' => array(
                    'element' => 'front_icon_font_type',
                    'value' => 'type_fontawesome',
                ),
                'group' => esc_html__( 'Front Side', 'seofy' ),
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
                    'element' => 'front_icon_font_type',
                    'value' => 'type_flaticon',
                ),
                'group' => esc_html__( 'Front Side', 'seofy' ),
            ),
            array(
                'type' => 'attach_image',
                'heading' => esc_html__( 'Image', 'seofy' ),
                'param_name' => 'front_icon_thumbnail',
                'value' => '',
                'description' => esc_html__( 'Select image from media library.', 'seofy' ),
                'dependency' => array(
                    'element' => 'front_icon_type',
                    'value' => 'image',
                ),
                'group' => esc_html__( 'Front Side', 'seofy' ),
            ),
            // Custom image width
            array(
                'type' => 'textfield',
                'heading' => esc_html__('Custom Image Width', 'seofy'),
                'param_name' => 'custom_image_width',
                'description' => esc_html__( 'Enter image size in pixels.', 'seofy' ),
                'group' => esc_html__( 'Front Side', 'seofy' ),
                'dependency' => array(
                    'element' => 'front_icon_type',
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
                'group' => esc_html__( 'Front Side', 'seofy' ),
                'dependency' => array(
                    'element' => 'front_icon_type',
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
                'group' => esc_html__( 'Front Side', 'seofy' ),
                'dependency' => array(
                    'element' => 'front_icon_type',
                    'value' => 'font',
                ),
                'edit_field_class' => 'vc_col-sm-6',
            ),
            array(
                'type' => 'colorpicker',
                'heading' => esc_html__('Icon Color', 'seofy'),
                'param_name' => 'front_icon_color',
                'value' => '#ffffff',
                'dependency' => array(
                    'element' => 'front_icon_type',
                    'value' => 'font',
                ),
                'group' => esc_html__( 'Front Side', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-6',
            ),
            // Front Side Title
            array(
                'type' => 'seofy_param_heading',
                'heading' => esc_html__('Front Side Title', 'seofy'),
                'param_name' => 'h_front_title',
                'group' => esc_html__( 'Front Side', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-12',
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
            // Front Side Title
            array(
                'type' => 'seofy_param_heading',
                'heading' => esc_html__('Front Side Description', 'seofy'),
                'param_name' => 'h_front_descr',
                'group' => esc_html__( 'Front Side', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-12',
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
                'value' => '#bebebe',
                'group' => esc_html__( 'Front Side', 'seofy' ),
            ),
            // Back Side
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
                'value'         => array(
                    esc_html__( 'Color', 'seofy' )      => 'back_color',
                    esc_html__( 'Image', 'seofy' )      => 'back_image',
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
                'type' => 'textfield',
                'heading' => esc_html__('Read More Button Text', 'seofy'),
                'param_name' => 'read_more_text',
                'value' => esc_html__('Read More', 'seofy'),
                'group' => esc_html__( 'Back Side', 'seofy' ),
                'dependency' => array(
                    'element' => 'add_read_more',
                    'value' => 'true'
                ),
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
                'type' => 'dropdown',
                'heading' => esc_html__( 'Customize', 'seofy' ),
                'param_name' => 'button_customize',
                'value'         => array(
                    esc_html__( 'Default', 'seofy' )        => 'def',
                    esc_html__( 'Color', 'seofy' )          => 'color',
                ),
                'group' => esc_html__( 'Back Side', 'seofy' ),
                'dependency' => array(
                    'element' => 'add_read_more',
                    'value' => 'true'
                ),
            ),
            // Button text-color
            array(
                'type' => 'colorpicker',
                'class' => '',
                'heading' => esc_html__('Text Color', 'seofy'),
                'param_name' => 'button_text_color',
                'value' => '#ffffff',
                'description' => esc_html__('Select custom text color for button.', 'seofy'),
                'save_always' => true,
                'dependency' => array(
                    'element' => 'button_customize',
                    'value' => array('color', 'gradient')
                ),
                'group' => esc_html__( 'Back Side', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-6',
            ),
            // Button Hover text-color
            array(
                'type' => 'colorpicker',
                'class' => '',
                'heading' => esc_html__('Hover Text Color', 'seofy'),
                'param_name' => 'button_text_color_hover',
                'value' => $theme_color,
                'description' => esc_html__('Select custom text color for hover button.', 'seofy'),
                'dependency' => array(
                    'element' => 'button_customize',
                    'value' => array('color', 'gradient')
                ),
                'group' => esc_html__( 'Back Side', 'seofy' ),
                'save_always' => true,
                'edit_field_class' => 'vc_col-sm-6',
            ),
            // Button Bg
            array(
                'type' => 'colorpicker',
                'class' => '',
                'heading' => esc_html__('Background', 'seofy'),
                'param_name' => 'button_bg_color',
                'value' => $theme_color,
                'description' => esc_html__('Select custom background for button.', 'seofy'),
                'save_always' => true,
                'dependency' => array(
                    'element' => 'button_customize',
                    'value' => array('color')
                ),
                'group' => esc_html__( 'Back Side', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-6',
            ),
            // Button Hover Bg
            array(
                'type' => 'colorpicker',
                'class' => '',
                'heading' => esc_html__('Hover Background', 'seofy'),
                'param_name' => 'button_bg_color_hover',
                'value' => '#ffffff',
                'description' => esc_html__('Select custom background for hover button.', 'seofy'),
                'dependency' => array(
                    'element' => 'button_customize',
                    'value' => array('color')
                ),
                'group' => esc_html__( 'Back Side', 'seofy' ),
                'save_always' => true,
                'edit_field_class' => 'vc_col-sm-6',
            ),
            // Button border-color
            array(
                'type' => 'colorpicker',
                'class' => '',
                'heading' => esc_html__('Border Color', 'seofy'),
                'param_name' => 'button_border_color',
                'value' => $theme_color,
                'description' => esc_html__('Select custom border color for button.', 'seofy'),
                'save_always' => true,
                'dependency' => array(
                    'element' => 'button_customize',
                    'value' => array('color')
                ),
                'group' => esc_html__( 'Back Side', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-6',
            ),
            // Button Hover border-color
            array(
                'type' => 'colorpicker',
                'class' => '',
                'heading' => esc_html__('Hover Border Color', 'seofy'),
                'param_name' => 'button_border_color_hover',
                'value' => '#ffffff',
                'description' => esc_html__('Select custom border color for hover button.', 'seofy'),
                'group' => esc_html__( 'Back Side', 'seofy' ),
                'save_always' => true,
                'dependency' => array(
                    'element' => 'button_customize',
                    'value' => array('color')
                ),
                'edit_field_class' => 'vc_col-sm-6',
            ),
        )
    ));

    if (class_exists('WPBakeryShortCode')) {
        class WPBakeryShortCode_wgl_Services extends WPBakeryShortCode {
        }
    }
}