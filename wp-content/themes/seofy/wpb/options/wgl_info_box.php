<?php
if ( ! defined( 'ABSPATH' ) ) {
    die( '-1' );
}
$theme_color = esc_attr(Seofy_Theme_Helper::get_option("theme-custom-color"));
$header_font_color = esc_attr(Seofy_Theme_Helper::get_option('header-font')['color']);
$main_font_color = esc_attr(Seofy_Theme_Helper::get_option('main-font')['color']);
$theme_gradient_start = esc_attr(Seofy_Theme_Helper::get_option('theme-gradient')['from']);
$theme_gradient_end = esc_attr(Seofy_Theme_Helper::get_option('theme-gradient')['to']);

add_action( 'admin_enqueue_scripts', 'load_admin_style' );
function load_admin_style() {
    wp_enqueue_style('flaticon', get_template_directory_uri() . '/fonts/flaticon/flaticon.css');
}

if (function_exists('vc_map')) {
// Add list item
    vc_map(array(
        'name' => esc_html__('Info Box', 'seofy'),
        'base' => 'wgl_info_box',
        'class' => 'seofy_info_box',
        'category' => esc_html__('WGL Modules', 'seofy'),
        'icon' => 'wgl_icon_info_box',
        'content_element' => true,
        'description' => esc_html__('Info Box','seofy'),
        'params' => array(
            array(
                'type' => 'seofy_radio_image',
                'heading' => esc_html__('Info Box Type', 'seofy'),
                'param_name' => 'ib_type',
                'fields' => array(
                    'default' => array(
                        'image_url' => get_template_directory_uri() . '/img/wgl_composer_addon/icons/type_def.png',
                        'label' => esc_html__('Default', 'seofy')),
                    'full_size' => array(
                        'image_url' => get_template_directory_uri() . '/img/wgl_composer_addon/icons/type_full_width.png',
                        'label' => esc_html__('Full Size', 'seofy')),
                    'bordered' => array(
                        'image_url' => get_template_directory_uri() . '/img/wgl_composer_addon/icons/type_bordered.png',
                        'label' => esc_html__('Bordered', 'seofy')),
                    'fill' => array(
                        'image_url' => get_template_directory_uri() . '/img/wgl_composer_addon/icons/type_fill.png',
                        'label' => esc_html__('Fill', 'seofy')),
                    'tile' => array(
                        'image_url' => get_template_directory_uri() . '/img/wgl_composer_addon/icons/type_tile.png',
                        'label' => esc_html__('Tile', 'seofy')),
                ),
                'value' => 'default',
            ),
            array(
                'type' => 'seofy_radio_image',
                'heading' => esc_html__('Info Box Layout', 'seofy'),
                'param_name' => 'ib_layout',
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
                    'element' => 'ib_type',
                    'value' => array('default', 'bordered', 'fill', 'tile')
                ),
            ),
            array(
                'type' => 'dropdown',
                'heading' => esc_html__( 'Alignment', 'seofy' ),
                'param_name' => 'ib_align',
                'value' => array(
					esc_html__( 'Left', 'seofy' )   => 'left',
					esc_html__( 'Center', 'seofy' ) => 'center',
					esc_html__( 'Right', 'seofy' )  => 'right',
                ),
            ),
            // Info-box shadow
			array(
				'type' => 'wgl_checkbox',
				'heading' => esc_html__( 'Add Info-Box Shadow', 'seofy' ),
				'param_name' => 'add_shadow',
				'edit_field_class' => 'vc_col-sm-3',
			),
			// Info-box shadow style
			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Button Shadow Style', 'seofy' ),
				'param_name' => 'shadow_style',
				'value'	=> array(
					esc_html__( 'On Hover', 'seofy' )     => 'on_hover',
					esc_html__( 'Before Hover', 'seofy' ) => 'before_hover',
					esc_html__( 'Always', 'seofy' )       => 'always',
				),
				'description' => esc_html__('Select info-box shadow style.', 'seofy'),
				'dependency' => array(
					'element' => 'add_shadow',
					'value' => 'true'
				),
				'edit_field_class' => 'vc_col-sm-9',
			),
            vc_map_add_css_animation( true ),
            array(
                'type' => 'textfield',
                'heading' => esc_html__('Extra Class', 'seofy'),
                'param_name' => 'extra_class',
                'description' => esc_html__('Add an extra class name to the element and refer to it from Custom CSS option.', 'seofy')
            ),
            // Info Box Content
            array(
                'type' => 'textarea',
                'heading' => esc_html__('Info Box Title', 'seofy'),
                'param_name' => 'ib_title',
                'admin_label' => true,
                'group' => esc_html__( 'Content', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-9',
            ),
            array(
                'type' => 'wgl_checkbox',
                'heading' => esc_html__( 'Add Title Divider', 'seofy' ),
                'param_name' => 'add_title_divider',
                'group' => esc_html__( 'Content', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-3',
                'dependency' => array(
                    'element' => 'ib_layout',
                    'value' => 'top',
                ),
            ),
            array(
                'type' => 'textfield',
                'heading' => esc_html__('Info Box Subtitle', 'seofy'),
                'param_name' => 'ib_subtitle',
                'admin_label' => true,
                'group' => esc_html__( 'Content', 'seofy' ),
            ),
            array(
                'type' => 'textarea',
                'heading' => esc_html__('Info Box Text', 'seofy'),
                'param_name' => 'ib_content',
                'group' => esc_html__( 'Content', 'seofy' ),
            ),
            array(
                'type' => 'wgl_checkbox',
                'heading' => esc_html__( 'Add Read More Button', 'seofy' ),
                'param_name' => 'add_read_more',
                'group' => esc_html__( 'Content', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-12',
            ),
            array(
                'type' => 'textfield',
                'heading' => esc_html__('Read More Button Text', 'seofy'),
                'param_name' => 'read_more_text',
                'value' => 'Read More',
                'group' => esc_html__( 'Content', 'seofy' ),
                'dependency' => array(
                    'element' => 'add_read_more',
                    'value'   => 'true'
                ),
                'edit_field_class' => 'vc_col-sm-4',
            ),
            array(
                'type' => 'vc_link',
                'heading' => esc_html__( 'Link', 'seofy' ),
                'param_name' => 'link',
                'description' => esc_html__('Add link to read more button.', 'seofy'),
                'dependency' => array(
                    'element' => 'add_read_more',
                    'value' => 'true'
                ),
                'group' => esc_html__( 'Content', 'seofy' ),
            ),
            array(
                'type' => 'wgl_checkbox',
                'heading' => esc_html__( 'Custom Top Offset', 'seofy' ),
                'param_name' => 'add_read_more_offset',
                'dependency' => array(
                    'element' => 'add_read_more',
                    'value' => 'true'
                ),
                'group' => esc_html__( 'Content', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-4',
            ),
            array(
                'type' => 'textfield',
                'heading' => esc_html__('Button Top Offset', 'seofy'),
                'param_name' => 'read_more_offset',
                'value' => '',
                'description' => esc_html__('Add top offset to read more button in pixels.', 'seofy'),
                'dependency' => array(
                    'element' => 'add_read_more_offset',
                    'value' => 'true'
                ),
                'group' => esc_html__( 'Content', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-8',
            ),
            // ICON TAB
            // Info Box Icon/Image heading
            array(
                'type' => 'seofy_param_heading',
                'heading' => esc_html__('Icon Type', 'seofy'),
                'param_name' => 'h_icon_type',
                'group' => esc_html__( 'Icon', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-12 no-top-margin',
            ),
            // Info Box Icon/Image
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
                    esc_html__( 'Flaticon', 'seofy' )    => 'type_flaticon',
                    esc_html__( 'Fontawesome', 'seofy' ) => 'type_fontawesome',
                ),
                'save_always' => true,
                'dependency' => array(
                    'element' => 'icon_type',
                    'value' => 'font',
                ),
                'group' => esc_html__( 'Icon', 'seofy' ),
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
                    // default true, display an 'EMPTY' icon
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
                'dependency' => array(
                    'element' => 'icon_type',
                    'value' => 'image',
                ),
                'group' => esc_html__( 'Icon', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-6',
            ),
            // Custom image height
            array(
                'type' => 'textfield',
                'heading' => esc_html__('Custom Image Height', 'seofy'),
                'param_name' => 'custom_image_height',
                'description' => esc_html__( 'Enter image size in pixels.', 'seofy' ),
                'dependency' => array(
                    'element' => 'icon_type',
                    'value' => 'image',
                ),
                'group' => esc_html__( 'Icon', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-6',
            ),
            // Icon shadow
			array(
				'type' => 'wgl_checkbox',
				'heading' => esc_html__( 'Add Icon Shadow', 'seofy' ),
				'param_name' => 'add_icon_shadow',
				'description' => esc_html__( 'Custom box-shadow style.', 'seofy' ),
				'dependency' => array(
					'element' => 'icon_type',
                    'value' => 'font',
				),
				'group' => esc_html__( 'Icon', 'seofy' ),
				'edit_field_class' => 'vc_col-sm-3',
			),
			// Icon shadow style
			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Button Shadow Style', 'seofy' ),
				'param_name' => 'icon_shadow_style',
				'value'	=> array(
					esc_html__( 'On Hover', 'seofy' )     => 'on_hover',
					esc_html__( 'Before Hover', 'seofy' ) => 'before_hover',
					esc_html__( 'Always', 'seofy' )       => 'always',
				),
				'description' => esc_html__('Select icon shadow style.', 'seofy'),
				'dependency' => array(
					'element' => 'add_icon_shadow',
					'value' => 'true'
				),
				'group' => esc_html__( 'Icon', 'seofy' ),
				'edit_field_class' => 'vc_col-sm-9',
			),
            // Custom icon size
            array(
                'type' => 'textfield',
                'heading' => esc_html__('Custom Icon Size', 'seofy'),
                'param_name' => 'custom_icon_size',
                'description' => esc_html__( 'Enter Icon size in pixels.', 'seofy' ),
                'dependency' => array(
                    'element' => 'icon_type',
                    'value' => 'font',
                ),
                'group' => esc_html__( 'Icon', 'seofy' ),
            ),
            // Icon color checkbox
            array(
                'type' => 'wgl_checkbox',
                'heading' => esc_html__( 'Use Custom Icon Colors', 'seofy' ),
                'param_name' => 'custom_icon_color',
                'description' => esc_html__( 'Select custom colors', 'seofy' ),
                'dependency' => array(
                    'element' => 'icon_type',
                    'value' => 'font',
                ),
                'group' => esc_html__( 'Icon', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-4',
            ),
            array(
                'type' => 'dropdown',
                'heading' => esc_html__('Select Customization Style', 'seofy'),
                'param_name' => 'icon_color_type',
                'value' => array(
                    esc_html__( 'Color', 'seofy' )    => 'color',
                    esc_html__( 'Gradient', 'seofy' ) => 'gradient'
                ),
                'dependency' => array(
                    'element' => 'custom_icon_color',
                    'value' => 'true',
                ),
                'group' => esc_html__( 'Icon', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-8',
            ),
            // Icon color
            array(
                'type' => 'colorpicker',
                'heading' => esc_html__('Icon Color', 'seofy'),
                'param_name' => 'icon_color_idle',
                'value' => $theme_color,
                'description' => esc_html__('Select icon color', 'seofy'),
                'dependency' => array(
                    'element' => 'icon_color_type',
                    'value' => 'color'
                ),
                'group' => esc_html__( 'Icon', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-6',
            ),
            // Icon hover color
            array(
                'type' => 'colorpicker',
                'heading' => esc_html__('Icon Hover Color', 'seofy'),
                'param_name' => 'icon_color_hover',
                'value' => $theme_color,
                'description' => esc_html__('Select icon hover color', 'seofy'),
                'dependency' => array(
                    'element' => 'icon_color_type',
                    'value' => 'color'
                ),
                'group' => esc_html__( 'Icon', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-6',
            ),
            // Icon gradient start color
            array(
                'type' => 'colorpicker',
                'heading' => esc_html__('Gradient Start Color', 'seofy'),
                'param_name' => 'icon_color_gradient_start',
                'value' => $theme_gradient_start,
                'dependency' => array(
                    'element' => 'icon_color_type',
                    'value' => 'gradient'
                ),
                'group' => esc_html__( 'Icon', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-6',
            ),
            // Icon gradient end color
            array(
                'type' => 'colorpicker',
                'heading' => esc_html__('Gradient End Color', 'seofy'),
                'param_name' => 'icon_color_gradient_end',
                'value' => $theme_gradient_end,
                'dependency' => array(
                    'element' => 'icon_color_type',
                    'value' => 'gradient'
                ),
                'group' => esc_html__( 'Icon', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-6',
            ),
            // Icon/image number
            array(
                'type' => 'seofy_param_heading',
                'heading' => esc_html__('Icon Number', 'seofy'),
                'param_name' => 'h_icon_number',
                'dependency' => array(
                    'element' => 'icon_type',
                    'value' => array('font','image'),
                ),
                'group' => esc_html__( 'Icon', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-12',
            ),
            array(
                'type' => 'wgl_checkbox',
                'heading' => esc_html__( 'Add Number', 'seofy' ),
                'param_name' => 'add_number',
                'dependency' => array(
                    'element' => 'icon_type',
                    'value' => array('font','image'),
                ),
                'group' => esc_html__( 'Icon', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-3',
            ),
            array(
                'type' => 'textfield',
                'heading' => esc_html__('Enter Icon Number', 'seofy'),
                'param_name' => 'icon_number',
                'value' => '01',
                'dependency' => array(
                    'element' => 'add_number',
                    'value' => 'true',
                ),
                'group' => esc_html__( 'Icon', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-4',
            ),
            array(
                'type' => 'dropdown',
                'heading' => esc_html__('Number Position', 'seofy'),
                'param_name' => 'number_pos',
                'value' => array(
                    esc_html__( 'Left Top Corner', 'seofy' )     => 'left_top',
                    esc_html__( 'Right Top Corner', 'seofy' )    => 'right_top',
                    esc_html__( 'Left Bottom Corner', 'seofy' )  => 'left_bottom',
                    esc_html__( 'Right Bottom Corner', 'seofy' ) => 'right_bottom',
                ),
                'dependency' => array(
                    'element' => 'add_number',
                    'value' => 'true',
                ),
                'group' => esc_html__( 'Icon', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-5',
            ),
            // ICON BACKGROUND TAB
            array(
                'type' => 'seofy_param_heading',
                'heading' => esc_html__('Icon Background Dimensions', 'seofy'),
                'param_name' => 'h_icon_bg',
                'group' => esc_html__( 'Icon Background', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-12 no-top-margin',
            ),
            // Custom icon bg size
            array(
                'type' => 'textfield',
                'heading' => esc_html__('Enter Background Width', 'seofy'),
                'param_name' => 'custom_icon_bg_width',
                'description' => esc_html__( 'Custom width in pixels.', 'seofy' ),
                'group' => esc_html__( 'Icon Background', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-6',
            ),
            // Custom icon bg size
            array(
                'type' => 'textfield',
                'heading' => esc_html__('Enter Background Height', 'seofy'),
                'param_name' => 'custom_icon_bg_height',
                'description' => esc_html__( 'Custom height in pixels.', 'seofy' ),
                'group' => esc_html__( 'Icon Background', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-6',
            ),
            // Custom icon bg offsets
            array(
                'type' => 'textfield',
                'heading' => esc_html__('Enter Bottom Offset', 'seofy'),
                'param_name' => 'custom_icon_bot_offset',
                'description' => esc_html__( 'Custom offset in pixels.', 'seofy' ),
                'group' => esc_html__( 'Icon Background', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-6',
            ),  
            array(
                'type' => 'textfield',
                'heading' => esc_html__('Enter Side Offset', 'seofy'),
                'param_name' => 'custom_icon_side_offset',
                'description' => esc_html__( 'It works only with layout left or right', 'seofy' ),
                'group' => esc_html__( 'Icon Background', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-6',
                'dependency' => array(
                    'element' => 'ib_layout',
                    'value' => array('left','right','top_left','top_right'),
                ),
            ),  
            // Custom icon bg radius
            array(
                'type' => 'textfield',
                'heading' => esc_html__('Enter Border Radius', 'seofy'),
                'param_name' => 'custom_icon_radius',
                'description' => esc_html__( 'Custom radius in pixels.', 'seofy' ),
                'group' => esc_html__( 'Icon Background', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-12',
                'dependency' => array(
                    'element' => 'ib_type',
                    'value' => array('bordered','fill')
                ),
            ),   
            // icon/image border styles
            array(
                'type' => 'seofy_param_heading',
                'heading' => esc_html__('Border Styles', 'seofy'),
                'param_name' => 'h_border_styles',
                'group' => esc_html__( 'Icon Background', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-12',
                'dependency' => array(
                    'element' => 'ib_type',
                    'value' => 'bordered'
                ),
            ),
            // Custom icon border width
            array(
                'type' => 'textfield',
                'heading' => esc_html__('Border Width', 'seofy'),
                'param_name' => 'border_width',
                'description' => esc_html__( 'Enter border width in pixels.', 'seofy' ),
                'group' => esc_html__( 'Icon Background', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-12',
                'dependency' => array(
                    'element' => 'ib_type',
                    'value' => 'bordered'
                ),
            ),
            // Border color checkbox
            array(
                'type' => 'wgl_checkbox',
                'heading' => esc_html__( 'Use Custom Border Colors', 'seofy' ),
                'param_name' => 'custom_border_color',
                'description' => esc_html__( 'Select custom colors', 'seofy' ),
                'group' => esc_html__( 'Icon Background', 'seofy' ),
                'dependency' => array(
                    'element' => 'ib_type',
                    'value' => 'bordered'
                ),
                'edit_field_class' => 'vc_col-sm-4',
            ),
            // Border color
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
                'group' => esc_html__( 'Icon Background', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-4',
            ),
            // Border hover color
            array(
                'type' => 'colorpicker',
                'heading' => esc_html__('Border Hover Color', 'seofy'),
                'param_name' => 'border_color_hover',
                'value' => '#000000',
                'description' => esc_html__('Select border hover color', 'seofy'),
                'dependency' => array(
                    'element' => 'custom_border_color',
                    'value' => 'true'
                ),
                'group' => esc_html__( 'Icon Background', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-4',
            ), 
            // Icon/image bg
            array(
                'type' => 'seofy_param_heading',
                'heading' => esc_html__('Icon Background Color', 'seofy'),
                'param_name' => 'h_icon_bg_color',
                'group' => esc_html__( 'Icon Background', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-12',
            ),
            // Icon bg color checkbox
            array(
                'type' => 'wgl_checkbox',
                'heading' => esc_html__( 'Use Custom Background Color', 'seofy' ),
                'param_name' => 'custom_icon_bg_color',
                'group' => esc_html__( 'Icon Background', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-4',
            ),
            array(
                'type' => 'dropdown',
                'heading' => esc_html__('Select Background Customization Style', 'seofy'),
                'param_name' => 'icon_bg_type',
                'value' => array(
                    esc_html__( 'Color', 'seofy' )    => 'color',
                    esc_html__( 'Gradient', 'seofy' ) => 'gradient'
                ),
                'dependency' => array(
                    'element' => 'custom_icon_bg_color',
                    'value' => 'true',
                ),
                'group' => esc_html__( 'Icon Background', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-8',
            ),        
            // Icon bg color
            array(
                'type' => 'colorpicker',
                'heading' => esc_html__('Background Color', 'seofy'),
                'param_name' => 'icon_bg_color',
                'value' => '#ffffff',
                'description' => esc_html__('Select color.', 'seofy'),
                'dependency' => array(
                    'element' => 'icon_bg_type',
                    'value' => 'color'
                ),
                'group' => esc_html__( 'Icon Background', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-6',
            ),
            // Icon bg hover color
            array(
                'type' => 'colorpicker',
                'heading' => esc_html__('Background Hover Color', 'seofy'),
                'param_name' => 'icon_bg_color_hover',
                'value' => $theme_color,
                'description' => esc_html__('Select color.', 'seofy'),
                'dependency' => array(
                    'element' => 'icon_bg_type',
                    'value' => 'color'
                ),
                'group' => esc_html__( 'Icon Background', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-6',
            ),
            // Icon bg gradient start color
            array(
                'type' => 'colorpicker',
                'heading' => esc_html__('Background Start Color', 'seofy'),
                'param_name' => 'icon_bg_gradient_start',
                'value' => $theme_gradient_start,
                'dependency' => array(
                    'element' => 'icon_bg_type',
                    'value' => 'gradient'
                ),
                'group' => esc_html__( 'Icon Background', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-6',
            ),
            // Icon bg gradient end color
            array(
                'type' => 'colorpicker',
                'heading' => esc_html__('Background End Color', 'seofy'),
                'param_name' => 'icon_bg_gradient_end',
                'value' => $theme_gradient_end,
                'dependency' => array(
                    'element' => 'icon_bg_type',
                    'value' => 'gradient'
                ),
                'group' => esc_html__( 'Icon Background', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-6',
            ),
            // Icon bg gradient start hover color
            array(
                'type' => 'colorpicker',
                'heading' => esc_html__('Background Hover Start Color', 'seofy'),
                'param_name' => 'icon_bg_gradient_start_hover',
                'value' => $theme_gradient_end,
                'dependency' => array(
                    'element' => 'icon_bg_type',
                    'value' => 'gradient'
                ),
                'group' => esc_html__( 'Icon Background', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-6',
            ),
            // Icon bg gradient end hover color
            array(
                'type' => 'colorpicker',
                'heading' => esc_html__('Background Hover End Color', 'seofy'),
                'param_name' => 'icon_bg_gradient_end_hover',
                'value' => $theme_gradient_start,
                'dependency' => array(
                    'element' => 'icon_bg_type',
                    'value' => 'gradient'
                ),
                'group' => esc_html__( 'Icon Background', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-6',
            ),
            // Tile background
            array(
                'type' => 'seofy_param_heading',
                'heading' => esc_html__('Customize Tile Colors', 'seofy'),
                'param_name' => 'h_tile_colors',
                'group' => esc_html__( 'Tile Background', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-12 no-top-margin',
                'dependency' => array(
                    'element' => 'ib_type',
                    'value' => 'tile'
                ),
            ),
            array(
                'type' => 'wgl_checkbox',
                'heading' => esc_html__( 'Use Custom Colors', 'seofy' ),
                'param_name' => 'custom_tile_colors',
                'group' => esc_html__( 'Tile Background', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-6',
                'dependency' => array(
                    'element' => 'ib_type',
                    'value' => 'tile'
                ),
            ),
            // tile hover content colors
            array(
                'type' => 'colorpicker',
                'heading' => esc_html__('Tile Hover Content', 'seofy'),
                'param_name' => 'tile_content_color_hover',
                'value' => '#ffffff',
                'dependency' => array(
                    'element' => 'custom_tile_colors',
                    'value' => 'true'
                ),
                'group' => esc_html__( 'Tile Background', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-6',
            ),
            // Background color
            array(
                'type' => 'dropdown',
                'heading' => esc_html__( 'Background Customize Colors', 'seofy' ),
                'param_name' => 'tile_bg_color_type',
                'value' => array(
                    esc_html__( 'Default', 'seofy' ) => 'def',
                    esc_html__( 'Color', 'seofy' )   => 'color',
                ),
                'dependency' => array(
                    'element' => 'custom_tile_colors',
                    'value' => 'true'
                ),
                'group' => esc_html__( 'Tile Background', 'seofy' ),
            ),
            // background color
            array(
                'type' => 'colorpicker',
                'heading' => esc_html__('Background Color', 'seofy'),
                'param_name' => 'tile_bg_color',
                'value' => '#ffffff',
                'description' => esc_html__('Select background color', 'seofy'),
                'dependency' => array(
                    'element' => 'tile_bg_color_type',
                    'value' => 'color'
                ),
                'group' => esc_html__( 'Tile Background', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-6',
            ),
            // background hover color
            array(
                'type' => 'colorpicker',
                'heading' => esc_html__('Background Hover Color', 'seofy'),
                'param_name' => 'tile_bg_color_hover',
                'value' => $theme_color,
                'description' => esc_html__('Select background hover color', 'seofy'),
                'dependency' => array(
                    'element' => 'tile_bg_color_type',
                    'value' => 'color'
                ),
                'group' => esc_html__( 'Tile Background', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-6',
            ), 
            // title styles heading
            array(
                'type' => 'seofy_param_heading',
                'heading' => esc_html__('Title Styles', 'seofy'),
                'param_name' => 'h_title_styles',
                'group' => esc_html__( 'Styling', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-12 no-top-margin',
            ),
            array(
                'type' => 'dropdown',
                'heading' => esc_html__( 'Title Tag', 'seofy' ),
                'param_name' => 'title_tag',
                'value' => array(
                    esc_html__( 'Span', 'seofy' ) => 'span',
                    esc_html__( 'Div', 'seofy' )  => 'div',
                    esc_html__( 'H2', 'seofy' )   => 'h2',
                    esc_html__( 'H3', 'seofy' )   => 'h3',
                    esc_html__( 'H4', 'seofy' )   => 'h4',
                    esc_html__( 'H5', 'seofy' )   => 'h5',
                    esc_html__( 'H6', 'seofy' )   => 'h6',
                ),
                'std' => 'h3',
                'group'         => esc_html__( 'Styling', 'seofy' ),
                'description' => esc_html__( 'Choose your tag for info box title', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-6',
            ),
            // title Font Size
            array(
                'type' => 'textfield',
                'heading' => esc_html__('Title Font Size', 'seofy'),
                'param_name' => 'title_size',
                'value' => '',
                'description' => esc_html__( 'Enter Info Box title font-size in pixels.', 'seofy' ),
                'group' => esc_html__( 'Styling', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-6',
            ),
            // title Font Weight
            array(
                'type' => 'textfield',
                'heading' => esc_html__('Title Font Weight', 'seofy'),
                'param_name' => 'title_weight',
                'value' => '',
                'description' => esc_html__( 'Enter Info Box title font-weight.', 'seofy' ),
                'group' => esc_html__( 'Styling', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-6',
            ),
            // title Font Weight
            array(
                'type' => 'textfield',
                'heading' => esc_html__('Title Bottom Offset', 'seofy'),
                'param_name' => 'title_bot_offset',
                'value' => '',
                'description' => esc_html__( 'Enter Info Box title offset in pixels.', 'seofy' ),
                'group' => esc_html__( 'Styling', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-6',
            ),
            // Title Fonts
            array(
                'type' => 'wgl_checkbox',
                'heading' => esc_html__( 'Custom font family for info box title', 'seofy' ),
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
            // title color checkbox
            array(
                'type' => 'wgl_checkbox',
                'heading' => esc_html__( 'Use Custom Title Color', 'seofy' ),
                'param_name' => 'custom_title_color',
                'description' => esc_html__( 'Select custom color', 'seofy' ),
                'group' => esc_html__( 'Styling', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-4',
            ),
            // title color
            array(
                'type' => 'colorpicker',
                'heading' => esc_html__('Title Color', 'seofy'),
                'param_name' => 'title_color',
                'value' => $header_font_color,
                'description' => esc_html__('Select title color', 'seofy'),
                'dependency' => array(
                    'element' => 'custom_title_color',
                    'value' => 'true'
                ),
                'group' => esc_html__( 'Styling', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-4',
            ),
            // subtitle styles heading
            array(
                'type' => 'seofy_param_heading',
                'heading' => esc_html__('Subtitle Styles', 'seofy'),
                'param_name' => 'h_subtitle_styles',
                'group' => esc_html__( 'Styling', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-12',
            ),
            array(
                'type' => 'dropdown',
                'heading' => esc_html__( 'Subtitle Tag', 'seofy' ),
                'param_name' => 'subtitle_tag',
                'value' => array(
                    esc_html__( 'Span', 'seofy' ) => 'span',
                    esc_html__( 'Div', 'seofy' )  => 'div',
                    esc_html__( 'H2', 'seofy' )   => 'h2',
                    esc_html__( 'H3', 'seofy' )   => 'h3',
                    esc_html__( 'H4', 'seofy' )   => 'h4',
                    esc_html__( 'H5', 'seofy' )   => 'h5',
                    esc_html__( 'H6', 'seofy' )   => 'h6',
                ),
                'std' => 'span',
                'group'         => esc_html__( 'Styling', 'seofy' ),
                'description' => esc_html__( 'Choose your tag for info box subtitle', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-6',
            ),
            // subtitle Font Size
            array(
                'type' => 'textfield',
                'heading' => esc_html__('Subtitle Font Size', 'seofy'),
                'param_name' => 'subtitle_size',
                'value' => '',
                'description' => esc_html__( 'Enter Info Box subtitle font-size in pixels.', 'seofy' ),
                'group' => esc_html__( 'Styling', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-6',
            ),
            // Subtitle Fonts
            array(
                'type' => 'wgl_checkbox',
                'heading' => esc_html__( 'Custom font family for info box subtitle', 'seofy' ),
                'param_name' => 'custom_fonts_subtitle',
                'description' => esc_html__( 'Customize font family', 'seofy' ),
                'group' => esc_html__( 'Styling', 'seofy' ),
            ),
            array(
                'type' => 'google_fonts',
                'param_name' => 'google_fonts_subtitle',
                'value' => '',
                'dependency' => array(
                    'element' => 'custom_fonts_subtitle',
                    'value' => 'true',
                ),
                'group' => esc_html__( 'Styling', 'seofy' ),
            ),
            // subtitle color checkbox
            array(
                'type' => 'wgl_checkbox',
                'heading' => esc_html__( 'Use Custom Subtitle Color', 'seofy' ),
                'param_name' => 'custom_subtitle_color',
                'description' => esc_html__( 'Select custom color', 'seofy' ),
                'group' => esc_html__( 'Styling', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-4',
            ),
            // subtitle color
            array(
                'type' => 'colorpicker',
                'heading' => esc_html__('Subtitle Color', 'seofy'),
                'param_name' => 'subtitle_color',
                'value' => '#000000',
                'description' => esc_html__('Select subtitle color', 'seofy'),
                'dependency' => array(
                    'element' => 'custom_subtitle_color',
                    'value' => 'true'
                ),
                'group' => esc_html__( 'Styling', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-4',
            ),
            // content styles heading
            array(
                'type' => 'seofy_param_heading',
                'heading' => esc_html__('Content Styles', 'seofy'),
                'param_name' => 'h_content_styles',
                'group' => esc_html__( 'Styling', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-12',
            ),
            array(
                'type' => 'dropdown',
                'heading' => esc_html__( 'Content Tag', 'seofy' ),
                'param_name' => 'content_tag',
                'value' => array(
                    esc_html__( 'Span', 'seofy' ) => 'span',
                    esc_html__( 'Div', 'seofy' )  => 'div',
                    esc_html__( 'H2', 'seofy' )   => 'h2',
                    esc_html__( 'H3', 'seofy' )   => 'h3',
                    esc_html__( 'H4', 'seofy' )   => 'h4',
                    esc_html__( 'H5', 'seofy' )   => 'h5',
                    esc_html__( 'H6', 'seofy' )   => 'h6',
                ),
                'std' => 'div',
                'group'         => esc_html__( 'Styling', 'seofy' ),
                'description' => esc_html__( 'Choose your tag for info box content', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-4',
            ),
            // content Font Size
            array(
                'type' => 'textfield',
                'heading' => esc_html__('Content Font Size', 'seofy'),
                'param_name' => 'content_size',
                'value' => '',
                'description' => esc_html__( 'Enter Info Box content font-size in pixels.', 'seofy' ),
                'group' => esc_html__( 'Styling', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-4',
            ),
            // content Font Size
            array(
                'type' => 'textfield',
                'heading' => esc_html__('Content Font Weight', 'seofy'),
                'param_name' => 'content_weight',
                'value' => '',
                'description' => esc_html__( 'Enter Info Box content font-weight.', 'seofy' ),
                'group' => esc_html__( 'Styling', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-4',
            ),
            // Content Fonts
            array(
                'type' => 'wgl_checkbox',
                'heading' => esc_html__( 'Custom font family for info box content', 'seofy' ),
                'param_name' => 'custom_fonts_content',
                'description' => esc_html__( 'Customize font family', 'seofy' ),
                'group' => esc_html__( 'Styling', 'seofy' ),
            ),
            array(
                'type' => 'google_fonts',
                'param_name' => 'google_fonts_content',
                'value' => '',
                'dependency' => array(
                    'element' => 'custom_fonts_content',
                    'value' => 'true',
                ),
                'group' => esc_html__( 'Styling', 'seofy' ),
            ),
            // content color checkbox
            array(
                'type' => 'wgl_checkbox',
                'heading' => esc_html__( 'Use Custom Content Color', 'seofy' ),
                'param_name' => 'custom_content_color',
                'description' => esc_html__( 'Select custom color', 'seofy' ),
                'group' => esc_html__( 'Styling', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-4',
            ),
            // content color
            array(
                'type' => 'colorpicker',
                'heading' => esc_html__('Content Color', 'seofy'),
                'param_name' => 'content_color',
                'value' => $main_font_color,
                'description' => esc_html__('Select content color', 'seofy'),
                'dependency' => array(
                    'element' => 'custom_content_color',
                    'value' => 'true'
                ),
                'group' => esc_html__( 'Styling', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-4',
            ),
            // button styles heading
            array(
                'type' => 'seofy_param_heading',
                'heading' => esc_html__('Button Styles', 'seofy'),
                'param_name' => 'h_button_styles',
                'group' => esc_html__( 'Styling', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-12',
                'dependency' => array(
                    'element' => 'add_read_more',
                    'value' => 'true'
                ),
            ),
            // button Font Size
            array(
                'type' => 'textfield',
                'heading' => esc_html__('Button Font Size', 'seofy'),
                'param_name' => 'button_size',
                'value' => '',
                'description' => esc_html__( 'Enter Info Box button font-size in pixels.', 'seofy' ),
                'group' => esc_html__( 'Styling', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-6',
                'dependency' => array(
                    'element' => 'add_read_more',
                    'value' => 'true'
                ),
            ),
            // Button Fonts
            array(
                'type' => 'wgl_checkbox',
                'heading' => esc_html__( 'Custom font family for info box button', 'seofy' ),
                'param_name' => 'custom_fonts_button',
                'description' => esc_html__( 'Customize font family', 'seofy' ),
                'group' => esc_html__( 'Styling', 'seofy' ),
                'dependency' => array(
                    'element' => 'add_read_more',
                    'value' => 'true'
                ),
            ),
            array(
                'type' => 'google_fonts',
                'param_name' => 'google_fonts_button',
                'value' => '',
                'dependency' => array(
                    'element' => 'custom_fonts_button',
                    'value' => 'true',
                ),
                'group' => esc_html__( 'Styling', 'seofy' ),
            ),
            // button color checkbox
            array(
                'type' => 'wgl_checkbox',
                'heading' => esc_html__( 'Use Custom Button Color', 'seofy' ),
                'param_name' => 'custom_button_color',
                'description' => esc_html__( 'Select custom color', 'seofy' ),
                'group' => esc_html__( 'Styling', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-4',
                'dependency' => array(
                    'element' => 'add_read_more',
                    'value' => 'true'
                ),
            ),
            // button color
            array(
                'type' => 'colorpicker',
                'heading' => esc_html__('Button Color', 'seofy'),
                'param_name' => 'button_color',
                'value' => $theme_color,
                'description' => esc_html__('Select button color', 'seofy'),
                'dependency' => array(
                    'element' => 'custom_button_color',
                    'value' => 'true'
                ),
                'group' => esc_html__( 'Styling', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-4',
            ),
            // button hover color
            array(
                'type' => 'colorpicker',
                'heading' => esc_html__('Button Hover Color', 'seofy'),
                'param_name' => 'button_color_hover',
                'value' => $header_font_color,
                'description' => esc_html__('Select button hover color', 'seofy'),
                'dependency' => array(
                    'element' => 'custom_button_color',
                    'value' => 'true'
                ),
                'group' => esc_html__( 'Styling', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-4',
            ),
        )
    ));
    
    if (class_exists('WPBakeryShortCode')) {
        class WPBakeryShortCode_wgl_info_box extends WPBakeryShortCode {
            
        }
    } 
}
