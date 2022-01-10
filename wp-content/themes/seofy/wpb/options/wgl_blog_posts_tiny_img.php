<?php
if ( ! defined( 'ABSPATH' ) ) {
    die( '-1' );
}

$header_font = Seofy_Theme_Helper::get_option('header-font');
$main_font = Seofy_Theme_Helper::get_option('main-font');
$theme_color = Seofy_Theme_Helper::get_option('theme-custom-color');

if (function_exists('vc_map')) {
    vc_map(array(
        'base' => 'wgl_blog_posts_tiny_img',
        'name' => esc_html__('Tiny Image', 'seofy'),
        'description' => esc_html__('Display the blog posts', 'seofy'),
        'category' => esc_html__('WGL Blog Modules', 'seofy'),
        'icon' => 'wgl_icon_blog_tiny_img',
        'params' => array(
             array(
                'type' => 'textfield',
                'heading' => esc_html__('Blog Title', 'seofy'),
                'param_name' => 'blog_title',
                'admin_label' => true,
            ),
            array(
                'type' => 'textarea',
                'heading' => esc_html__('Blog Subtitle', 'seofy'),
                'param_name' => 'blog_subtitle',
                'admin_label' => true,
            ),     
            array(
                'type' => 'seofy_radio_image',
                'heading' => esc_html__('Layout', 'seofy'),
                'param_name' => 'blog_layout',
                'fields' => array(
                    'grid' => array(
                        'image_url' => get_template_directory_uri() . '/img/wgl_composer_addon/icons/layout_grid.png',
                        'label' => esc_html__('Grid', 'seofy')),
                    'masonry' => array(
                        'image_url' => get_template_directory_uri() . '/img/wgl_composer_addon/icons/layout_masonry.png',
                        'label' => esc_html__('Masonry', 'seofy')),
                    'carousel' => array(
                        'image_url' => get_template_directory_uri() . '/img/wgl_composer_addon/icons/layout_carousel.png',
                        'label' => esc_html__('Carousel', 'seofy')),
                ),
                'value' => 'grid',
            ),
            array(
                'type' => 'dropdown',
                'heading' => esc_html__( 'Navigation', 'seofy' ),
                'param_name' => 'blog_navigation',
                'value'         => array(
                    esc_html__( 'None', 'seofy' ) => 'none',
                    esc_html__( 'Pagination', 'seofy' ) => 'pagination',
                    esc_html__( 'Load More', 'seofy' ) => 'load_more',
                ),
                'description' => esc_html__('Select Type of Navigation', 'seofy'),
                'std' => 'none',
                'dependency' => array(
                    'element' => 'blog_layout',
                    'value_not_equal_to' => 'carousel',
                ),
            ),
            array(
                'type' => 'dropdown',
                'heading' => esc_html__( 'Navigation\'s Alignment', 'seofy' ),
                'param_name' => 'blog_navigation_align',
                'value'         => array(
                    esc_html__( 'Left', 'seofy' ) => 'left',
                    esc_html__( 'Center', 'seofy' ) => 'center',
                    esc_html__( 'Right', 'seofy' ) => 'right'
                ),
                'description' => esc_html__('Select Navigation\'s Alignment.', 'seofy'),
                'std' => 'left',
                'dependency' => array(
                    'element' => 'blog_navigation',
                    'value' => 'pagination'
                ),
            ),
            array(
                'type' => 'textfield',
                'heading' => esc_html__('Items on load', 'seofy'),
                'param_name' => 'items_load',
                'value' => '4',
                'save_always' => true,
                'description' => esc_html__( 'Items load by load more button.', 'seofy' ),
                'dependency' => array(
                    'element' => 'blog_navigation',
                    "value" => "load_more"
                )
            ),            
            array(
                'type' => 'textfield',
                'heading' => esc_html__('Button Name', 'seofy'),
                'param_name' => 'name_load_more',
                'value' => esc_html__('Load More', 'seofy'),
                'save_always' => true,
                'dependency' => array(
                    'element' => 'blog_navigation',
                    "value" => "load_more"
                )
            ),
            vc_map_add_css_animation( true ),
            array(
                'type' => 'textfield',
                'heading' => esc_html__('Extra Class', 'seofy'),
                'param_name' => 'extra_class',
                'description' => esc_html__("Add an extra class name to the element and refer to it from Custom CSS option.", 'seofy')
            ),
            array(
                'type' => 'seofy_param_heading',
                'heading' => esc_html__('Layout Settings', 'seofy'),
                'param_name' => 'h_layout_settings',
                'group' => esc_html__( 'Icon', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-12 no-top-margin',
                'group' => esc_html__( 'Content', 'seofy' ),
            ),
            array(
                'type' => 'dropdown',
                'heading' => esc_html__( 'Number of Columns', 'seofy' ),
                'param_name' => 'blog_columns',
                'value'         => array(
                    esc_html__( 'One', 'seofy' ) => '12',
                    esc_html__( 'Two', 'seofy' ) => '6',
                    esc_html__( 'Three', 'seofy' ) => '4',
                    esc_html__( 'Four', 'seofy' ) => '3'
                ),
                'description' => esc_html__('Select Number of Columns', 'seofy'),
                'std' => '12',
                'edit_field_class' => 'vc_col-sm-6',
                'group' => esc_html__( 'Content', 'seofy' ),
            ),
            // Post Meta settings
            // Info Box Icon/Image heading
            array(
                'type' => 'seofy_param_heading',
                'heading' => esc_html__('Content Elements', 'seofy'),
                'param_name' => 'h_content_elements',
                'group' => esc_html__( 'Icon', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-12',
                'group' => esc_html__( 'Content', 'seofy' ),
            ),
            array(
                'type' => 'wgl_checkbox',
                'heading' => esc_html__('Hide Media?', 'seofy' ),
                'param_name' => 'hide_media',
                'edit_field_class' => 'vc_col-sm-4',
                'group' => esc_html__( 'Content', 'seofy' ),
            ),
            array(
                'type' => 'wgl_checkbox',
                'heading' => esc_html__('Hide Title?', 'seofy' ),
                'param_name' => 'hide_blog_title',
                'edit_field_class' => 'vc_col-sm-4',
                'group' => esc_html__( 'Content', 'seofy' ),
            ),
            array(
                'type' => 'wgl_checkbox',
                'heading' => esc_html__('Hide Content?', 'seofy' ),
                'param_name' => 'hide_content',
                'edit_field_class' => 'vc_col-sm-4',
                'group' => esc_html__( 'Content', 'seofy' ),
                'std' => 'true'
            ),
            array(
                'type' => 'wgl_checkbox',
                'heading' => esc_html__('Hide all post-meta?', 'seofy' ),
                'param_name' => 'hide_postmeta',
                'edit_field_class' => 'vc_col-sm-4',
                'group' => esc_html__( 'Content', 'seofy' ),
            ),
            array(
                'type' => 'wgl_checkbox',
                'heading' => esc_html__('Hide post-meta author?', 'seofy' ),
                'param_name' => 'meta_author',
                'edit_field_class' => 'vc_col-sm-4',
                'group' => esc_html__( 'Content', 'seofy' ),
                'dependency' => array(
                    'element' => 'hide_postmeta',
                    'value_not_equal_to' => 'true',
                ),
            ),
            array(
                'type' => 'wgl_checkbox',
                'heading' => esc_html__('Hide post-meta comments?', 'seofy' ),
                'param_name' => 'meta_comments',
                'edit_field_class' => 'vc_col-sm-4',
                'group' => esc_html__( 'Content', 'seofy' ),
                'dependency' => array(
                    'element' => 'hide_postmeta',
                    'value_not_equal_to' => 'true',
                ),
                'std' => 'true'
            ),
            array(
                'type' => 'wgl_checkbox',
                'heading' => esc_html__('Hide post-meta categories?', 'seofy' ),
                'param_name' => 'meta_categories',
                'edit_field_class' => 'vc_col-sm-4',
                'group' => esc_html__( 'Content', 'seofy' ),
                'dependency' => array(
                    'element' => 'hide_postmeta',
                    'value_not_equal_to' => 'true',
                ),
                'std' => 'true'
            ),
            array(
                'type' => 'wgl_checkbox',
                'heading' => esc_html__('Hide post-meta date?', 'seofy' ),
                'param_name' => 'meta_date',
                'edit_field_class' => 'vc_col-sm-4',
                'group' => esc_html__( 'Content', 'seofy' ),
                'dependency' => array(
                    'element' => 'hide_postmeta',
                    'value_not_equal_to' => 'true',
                ),
            ),
            array(
                'type' => 'wgl_checkbox',
                'heading' => esc_html__('Hide Likes?', 'seofy' ),
                'param_name' => 'hide_likes',
                'edit_field_class' => 'vc_col-sm-4',
                'group' => esc_html__( 'Content', 'seofy' ),
            ),            
            array(
                'type' => 'wgl_checkbox',
                'heading' => esc_html__('Hide Post Share?', 'seofy' ),
                'param_name' => 'hide_share',
                'edit_field_class' => 'vc_col-sm-4',
                'group' => esc_html__( 'Content', 'seofy' ),
            ),
            // Post Read More Link
            array(
                'type' => 'seofy_param_heading',
                'heading' => esc_html__('Content Trim', 'seofy'),
                'param_name' => 'h_content_trime',
                'edit_field_class' => 'vc_col-sm-12',
                'group' => esc_html__( 'Content', 'seofy' ),
            ),
            array(
                'type' => 'wgl_checkbox',
                'heading' => esc_html__('Hide post read more link?', 'seofy' ),
                'param_name' => 'read_more_hide',
                'edit_field_class' => 'vc_col-sm-4',
                'group' => esc_html__( 'Content', 'seofy' ),
                'std' => 'true'
            ),
            // Content Letter Count
            array(
                'type' => 'textfield',
                'heading' => esc_html__('Content Letter Count', 'seofy'),
                'param_name' => 'content_letter_count',
                'value' => '290',
                'description' => esc_html__( 'Enter content letter count.', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-12',
                'group' => esc_html__( 'Content', 'seofy' ),
            ),
            array(
                'type' => 'wgl_checkbox',
                'heading' => esc_html__('Crop Images for Posts List?', 'seofy' ),
                'param_name' => 'crop_square_img',
                'description' => esc_html__( 'For correctly work uploaded image size should be larger than 700px height and width.', 'seofy' ),
                'group' => esc_html__( 'Content', 'seofy' ),
                'std' => 'true'
            ),
            
            // --- CAROUSEL GROUP --- //
            array(
                "type"          => "wgl_checkbox",
                'heading' => esc_html__( 'Autoplay', 'seofy' ),
                "param_name"    => "autoplay",
                'dependency'    => array(
                    'element'   => 'blog_layout',
                    'value' => 'carousel'
                ),
                'edit_field_class' => 'vc_col-sm-4',
                'group' => esc_html__( 'Carousel', 'seofy' ),
            ),
            array(
                "type"          => "textfield",
                "heading"       => esc_html__( 'Autoplay Speed', 'seofy' ),
                "param_name"    => "autoplay_speed",
                "dependency"    => array(
                    "element"   => "autoplay",
                    "value" => 'true'
                ),
                'edit_field_class' => 'vc_col-sm-4',
                "value"         => "3000",
                'group' => esc_html__( 'Carousel', 'seofy' ),
            ),
            // carousel pagination heading
            array(
                'type' => 'seofy_param_heading',
                'heading' => esc_html__('Pagination Controls', 'seofy'),
                'param_name' => 'h_pag_controls',
                'group' => esc_html__( 'Carousel', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-12',
                'dependency'    => array(
                    'element'   => 'blog_layout',
                    'value' => 'carousel'
                ),
            ),
            array(
                'type' => 'wgl_checkbox',
                'heading' => esc_html__( 'Add Pagination control', 'seofy' ),
                'param_name' => 'use_pagination',
                'edit_field_class' => 'vc_col-sm-12',
                'group' => esc_html__( 'Carousel', 'seofy' ),
                'dependency'    => array(
                    'element'   => 'blog_layout',
                    'value' => 'carousel'
                ),
                'std' => 'true'
            ),
            array(
                'type' => 'seofy_radio_image',
                'heading' => esc_html__('Pagination Type', 'seofy'),
                'param_name' => 'pag_type',
                'fields' => array(
                    'circle' => array(
                        'image_url' => get_template_directory_uri() . '/img/wgl_composer_addon/icons/pag_circle.png',
                        'label' => esc_html__('Circle', 'seofy')),
                    'circle_border' => array(
                        'image_url' => get_template_directory_uri() . '/img/wgl_composer_addon/icons/pag_circle_border.png',
                        'label' => esc_html__('Empty Circle', 'seofy')),
                    'square' => array(
                        'image_url' => get_template_directory_uri() . '/img/wgl_composer_addon/icons/pag_square.png',
                        'label' => esc_html__('Square', 'seofy')),
                    'line' => array(
                        'image_url' => get_template_directory_uri() . '/img/wgl_composer_addon/icons/pag_line.png',
                        'label' => esc_html__('Line', 'seofy')),
                    'line_circle' => array(
                        'image_url' => get_template_directory_uri() . '/img/wgl_composer_addon/icons/pag_line_circle.png',
                        'label' => esc_html__('Line - Circle', 'seofy')),
                ),
                'group' => esc_html__( 'Carousel', 'seofy' ),
                'dependency' => array(
                    'element' => 'use_pagination',
                    'value' => 'true',
                ),
                'value' => 'circle',
            ),
            array(
                'type' => 'textfield',
                'heading' => esc_html__( 'Pagination Top Offset', 'seofy' ),
                'param_name' => 'pag_offset',
                'value' => '',
                'group' => esc_html__( 'Carousel', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-4',
                'description' => esc_html__( 'Enter pagination top offset in pixels.', 'seofy' ),
                'dependency' => array(
                    'element' => 'use_pagination',
                    'value' => 'true',
                ),
            ),
            array(
                'type' => 'wgl_checkbox',
                'heading' => esc_html__( 'Custom Pagination Color', 'seofy' ),
                'param_name' => 'custom_pag_color',
                'edit_field_class' => 'vc_col-sm-4',
                'group' => esc_html__( 'Carousel', 'seofy' ),
                'dependency' => array(
                    'element' => 'use_pagination',
                    'value' => 'true',
                ),
            ),
            array(
                'type' => 'colorpicker',
                'heading' => esc_html__('Pagination Color', 'seofy'),
                'param_name' => 'pag_color',
                'value' => esc_attr($theme_color),
                'dependency' => array(
                    'element' => 'custom_pag_color',
                    'value' => 'true'
                ),
                'group' => esc_html__( 'Carousel', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-4',
            ),
            // carousel pagination heading            
            // carousel navigation heading
            array(
                'type' => 'seofy_param_heading',
                'heading' => esc_html__('Navigation Controls', 'seofy'),
                'param_name' => 'h_nav_controls',
                'group' => esc_html__( 'Carousel', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-12',
                'dependency'    => array(
                    'element'   => 'blog_layout',
                    'value' => 'carousel'
                ),
            ),
            array(
                'type' => 'wgl_checkbox',
                'heading' => esc_html__( 'Add Navigation control', 'seofy' ),
                'param_name' => 'use_navigation',
                'edit_field_class' => 'vc_col-sm-12',
                'group' => esc_html__( 'Carousel', 'seofy' ),
                'dependency'    => array(
                    'element'   => 'blog_layout',
                    'value' => 'carousel'
                ),
                'std' => 'true'
            ),
            array(
                'type' => 'seofy_radio_image',
                'heading' => esc_html__('Navigation Type', 'seofy'),
                'param_name' => 'nav_type',
                'fields' => array(
                    'element' => array(
                        'image_url' => get_template_directory_uri() . '/img/wgl_composer_addon/icons/pag_circle.png',
                        'label' => esc_html__('On element', 'seofy')),
                    'offset_element' => array(
                        'image_url' => get_template_directory_uri() . '/img/wgl_composer_addon/icons/pag_circle_border.png',
                        'label' => esc_html__('Offset Element', 'seofy')),
                ),
                'group' => esc_html__( 'Carousel', 'seofy' ),
                'dependency' => array(
                    'element' => 'use_navigation',
                    'value' => 'true',
                ),
                'value' => 'on_element',
            ),
            // carousel navigation heading
            array(
                'type' => 'seofy_param_heading',
                'heading' => esc_html__('Responsive', 'seofy'),
                'param_name' => 'h_resp',
                'group' => esc_html__( 'Carousel', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-12',
                'dependency'    => array(
                    'element'   => 'blog_layout',
                    'value' => 'carousel'
                ),
            ),
            array(
                'type' => 'wgl_checkbox',
                'heading' => esc_html__( 'Customize Responsive', 'seofy' ),
                'param_name' => 'custom_resp',
                'dependency'    => array(
                    'element'   => 'blog_layout',
                    'value' => 'carousel'
                ),
                'edit_field_class' => 'vc_col-sm-12 no-top-margin',
                'group' => esc_html__( 'Carousel', 'seofy' ),
            ),
            // medium desktop
            array(
                'type' => 'seofy_param_heading',
                'heading' => esc_html__('Medium Desktop', 'seofy'),
                'param_name' => 'h_resp_medium',
                'group' => esc_html__( 'Carousel', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-12',
                'dependency' => array(
                    'element' => 'custom_resp',
                    'value' => 'true',
                ),
            ),
            array(
                'type' => 'textfield',
                'heading' => esc_html__( 'Screen resolution', 'seofy' ),
                'param_name' => 'resp_medium',
                'value' => '1025',
                'group' => esc_html__( 'Carousel', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-6',
                'dependency' => array(
                    'element' => 'custom_resp',
                    'value' => 'true',
                ),
            ),
            array(
                'type' => 'textfield',
                'heading' => esc_html__( 'Slides to show', 'seofy' ),
                'param_name' => 'resp_medium_slides',
                'value' => '',
                'group' => esc_html__( 'Carousel', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-6',
                'dependency' => array(
                    'element' => 'custom_resp',
                    'value' => 'true',
                ),
            ),
            
            // tablets
            array(
                'type' => 'seofy_param_heading',
                'heading' => esc_html__('Tablets', 'seofy'),
                'param_name' => 'h_resp_tablets',
                'group' => esc_html__( 'Carousel', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-12',
                'dependency' => array(
                    'element' => 'custom_resp',
                    'value' => 'true',
                ),
            ),
            array(
                'type' => 'textfield',
                'heading' => esc_html__( 'Screen resolution', 'seofy' ),
                'param_name' => 'resp_tablets',
                'value' => '800',
                'group' => esc_html__( 'Carousel', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-6',
                'dependency' => array(
                    'element' => 'custom_resp',
                    'value' => 'true',
                ),
            ),
            array(
                'type' => 'textfield',
                'heading' => esc_html__( 'Slides to show', 'seofy' ),
                'param_name' => 'resp_tablets_slides',
                'value' => '',
                'group' => esc_html__( 'Carousel', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-6',
                'dependency' => array(
                    'element' => 'custom_resp',
                    'value' => 'true',
                ),
            ),
            // mobile phones
            array(
                'type' => 'seofy_param_heading',
                'heading' => esc_html__('Mobile Phones', 'seofy'),
                'param_name' => 'h_resp_mobile',
                'group' => esc_html__( 'Carousel', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-12',
                'dependency' => array(
                    'element' => 'custom_resp',
                    'value' => 'true',
                ),
            ),
            array(
                'type' => 'textfield',
                'heading' => esc_html__( 'Screen resolution', 'seofy' ),
                'param_name' => 'resp_mobile',
                'value' => '480',
                'group' => esc_html__( 'Carousel', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-6',
                'dependency' => array(
                    'element' => 'custom_resp',
                    'value' => 'true',
                ),
            ),
            array(
                'type' => 'textfield',
                'heading' => esc_html__( 'Slides to show', 'seofy' ),
                'param_name' => 'resp_mobile_slides',
                'value' => '',
                'group' => esc_html__( 'Carousel', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-6',
                'dependency' => array(
                    'element' => 'custom_resp',
                    'value' => 'true',
                ),
            ),

            // --- CUSTOM GROUP --- //
            array(
                'type' => 'dropdown',
                'heading' => esc_html__( 'Heading tag', 'seofy' ),
                'param_name' => 'heading_tag',
                'value'         => array(
                    esc_html__( 'H1', 'seofy' ) => 'h1',
                    esc_html__( 'H2', 'seofy' ) => 'h2',
                    esc_html__( 'H3', 'seofy' ) => 'h3',
                    esc_html__( 'H4', 'seofy' ) => 'h4',
                    esc_html__( 'H5', 'seofy' ) => 'h5',
                    esc_html__( 'H6', 'seofy' ) => 'h6',
                ),
                'description' => esc_html__('Select Type Heading tag.', 'seofy'),
                'std' => 'h6',
                'group' => esc_html__( 'Custom', 'seofy' ),
            ),
            array(
                'type' => 'textfield',
                'heading' => esc_html__('Heading margin bottom', 'seofy'),
                'param_name' => 'heading_margin_bottom',
                'value' => '12px',
                'save_always' => true,
                'group' => esc_html__( 'Custom', 'seofy' ),
            ),  
            // Blog Headings Font
            array(
                'type' => 'seofy_param_heading',
                'heading' => esc_html__('Blog Headings Styles', 'seofy'),
                'param_name' => 'blog_heading_styles',
                'group' => esc_html__( 'Custom', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-12',
            ),
            array(
                'type' => 'wgl_checkbox',
                'heading' => esc_html__( 'Custom font family for Blog Headings', 'seofy' ),
                'param_name' => 'custom_fonts_blog_headings',
                'group' => esc_html__( 'Custom', 'seofy' ),
            ),            
            array(
                'type' => 'google_fonts',
                'param_name' => 'google_fonts_blog_headings',
                'value' => '',
                'dependency' => array(
                    'element' => 'custom_fonts_blog_headings',
                    'value' => 'true'
                ),
                'group' => esc_html__( 'Custom', 'seofy' ),
            ),
            array(
                'type' => 'wgl_checkbox',
                'heading' => esc_html__( 'Custom font size for Blog Headings', 'seofy' ),
                'param_name' => 'custom_fonts_blog_size_headings',
                'group' => esc_html__( 'Custom', 'seofy' ),
            ),
            // Heading Font Size
            array(
                'type' => 'textfield',
                'heading' => esc_html__('Heading Font Size', 'seofy'),
                'param_name' => 'heading_font_size',
                'value' => '24',
                'description' => esc_html__( 'Enter heading font-size in pixels.', 'seofy' ),
                'group' => esc_html__( 'Custom', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-6',
                'dependency' => array(
                    'element' => 'custom_fonts_blog_size_headings',
                    'value' => 'true'
                ),
            ),
            array(
                'type' => 'textfield',
                'heading' => esc_html__('Heading Line Height', 'seofy'),
                'param_name' => 'heading_line_height',
                'value' => '34',
                'description' => esc_html__( 'Enter heading line-height in pixels.', 'seofy' ),
                'group' => esc_html__( 'Custom', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-6',
                'dependency' => array(
                    'element' => 'custom_fonts_blog_size_headings',
                    'value' => 'true'
                ),
            ),
            array(
                'type' => 'wgl_checkbox',
                'heading' => esc_html__( 'Use Custom Heading Color', 'seofy' ),
                'param_name' => 'use_custom_heading_color',
                'description' => esc_html__( 'Select custom color', 'seofy' ),
                'group' => esc_html__( 'Custom', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-4',
            ),
            array(
                'type' => 'colorpicker',
                'class' => '',
                'heading' => esc_html__('Custom Headings Color', 'seofy'),
                'param_name' => 'custom_headings_color',
                'value' => esc_attr($header_font['color']),
                'description' => esc_html__('Select custom headings color.', 'seofy'),
                'dependency' => array(
                    'element' => 'use_custom_heading_color',
                    'value' => 'true'
                ),
                'group' => esc_html__( 'Custom', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-4',
            ),            
            array(
                'type' => 'colorpicker',
                'class' => '',
                'heading' => esc_html__('Custom Hover Headings Color', 'seofy'),
                'param_name' => 'custom_hover_headings_color',
                'value' => esc_attr($theme_color),
                'description' => esc_html__('Select custom hover headings color.', 'seofy'),
                'dependency' => array(
                    'element' => 'use_custom_heading_color',
                    'value' => 'true'
                ),
                'group' => esc_html__( 'Custom', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-4',
            ),
            // Blog Font
            // Blog Headings Font
            array(
                'type' => 'seofy_param_heading',
                'heading' => esc_html__('Blog Content Styles', 'seofy'),
                'group' => esc_html__( 'Custom', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-12',
                'param_name' => 'blog_content_styles',
            ),
            array(
                'type' => 'wgl_checkbox',
                'heading' => esc_html__( 'Custom font family for Blog Content', 'seofy' ),
                'param_name' => 'custom_fonts_blog_content',
                'group' => esc_html__( 'Custom', 'seofy' ),
            ),
            array(
                'type' => 'google_fonts',
                'param_name' => 'google_fonts_blog',
                'value' => '',
                'dependency' => array(
                    'element' => 'custom_fonts_blog_content',
                    'value' => 'true'
                ),
                'group' => esc_html__( 'Custom', 'seofy' ),
            ),
            array(
                'type' => 'wgl_checkbox',
                'heading' => esc_html__( 'Custom font size for Blog Content', 'seofy' ),
                'param_name' => 'custom_fonts_blog_size_content',
                'group' => esc_html__( 'Custom', 'seofy' ),
            ),
            // Heading Font Size
            array(
                'type' => 'textfield',
                'heading' => esc_html__('Content Font Size', 'seofy'),
                'param_name' => 'content_font_size',
                'value' => '16',
                'description' => esc_html__( 'Enter content font-size in pixels.', 'seofy' ),
                'group' => esc_html__( 'Custom', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-6',
                'dependency' => array(
                    'element' => 'custom_fonts_blog_size_content',
                    'value' => 'true'
                ),
            ),
            array(
                'type' => 'textfield',
                'heading' => esc_html__('Content Line Height', 'seofy'),
                'param_name' => 'content_line_height',
                'value' => '30',
                'description' => esc_html__( 'Enter content line-height in pixels.', 'seofy' ),
                'group' => esc_html__( 'Custom', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-6',
                'dependency' => array(
                    'element' => 'custom_fonts_blog_size_content',
                    'value' => 'true'
                ),
            ),
            array(
                'type' => 'wgl_checkbox',
                'heading' => esc_html__( 'Use Custom Content Color', 'seofy' ),
                'param_name' => 'use_custom_content_color',
                'description' => esc_html__( 'Select custom color', 'seofy' ),
                'group' => esc_html__( 'Custom', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-6',
            ),
            array(
                'type' => 'colorpicker',
                'class' => '',
                'heading' => esc_html__('Custom Content Color', 'seofy'),
                'param_name' => 'custom_content_color',
                'value' => esc_attr($main_font['color']),
                'description' => esc_html__('Select custom content color.', 'seofy'),
                'dependency' => array(
                    'element' => 'use_custom_content_color',
                    'value' => 'true'
                ),
                'group' => esc_html__( 'Custom', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-6',
            ),
             // Blog Style
            array(
                'type' => 'seofy_param_heading',
                'heading' => esc_html__('Blog Styles', 'seofy'),
                'group' => esc_html__( 'Custom', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-12',
                'param_name' => 'blog_content_styles',
            ),
            array(
                'type' => 'wgl_checkbox',
                'heading' => esc_html__( 'Use Custom Main Color', 'seofy' ),
                'param_name' => 'use_custom_main_color',
                'description' => esc_html__( 'Custom blog font size and font color.', 'seofy' ),
                'group' => esc_html__( 'Custom', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-7',
            ),
            // Custom blog style
            array(
                'type' => 'colorpicker',
                'class' => '',
                'heading' => esc_html__('Custom Main Color', 'seofy'),
                'param_name' => 'custom_main_color',
                'value' => '#abaebe',
                'description' => esc_html__('Select custom main color.', 'seofy'),
                'dependency' => array(
                    'element' => 'use_custom_main_color',
                    'value' => 'true'
                ),
                'group' => esc_html__( 'Custom', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-5 clearfix-col',
            ),  
            array(
                'type' => 'wgl_checkbox',
                'heading' => esc_html__( 'Use Custom Read More Color', 'seofy' ),
                'param_name' => 'use_custom_read_color',
                'description' => esc_html__( 'Custom read more color.', 'seofy' ),
                'group' => esc_html__( 'Custom', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-4',
            ),
            // Custom blog style
            array(
                'type' => 'colorpicker',
                'class' => '',
                'heading' => esc_html__('Read More Color', 'seofy'),
                'param_name' => 'custom_read_more_color',
                'value' => esc_attr($theme_color),
                'description' => esc_html__('Select read more color.', 'seofy'),
                'dependency' => array(
                    'element' => 'use_custom_read_color',
                    'value' => 'true'
                ),
                'group' => esc_html__( 'Custom', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-4 clearfix-col',
            ),             
            array(
                'type' => 'colorpicker',
                'class' => '',
                'heading' => esc_html__('Hover Read More Color', 'seofy'),
                'param_name' => 'custom_hover_read_more_color',
                'value' => esc_attr($main_font['color']),
                'description' => esc_html__('Select read more color.', 'seofy'),
                'dependency' => array(
                    'element' => 'use_custom_read_color',
                    'value' => 'true'
                ),
                'group' => esc_html__( 'Custom', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-4 clearfix-col',
            ),         
            array(
                'type' => 'wgl_checkbox',
                'heading' => esc_html__( 'Add Mask Image', 'seofy' ),
                'param_name' => 'custom_blog_mask',
                'description' => esc_html__( 'Custom blog image', 'seofy' ),
                'group' => esc_html__( 'Custom', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-7',
            ),
            array(
                'type' => 'colorpicker',
                'class' => '',
                'heading' => esc_html__('Mask Image Color', 'seofy'),
                'param_name' => 'custom_image_mask_color',
                'value' => esc_attr('rgba(14,21,30,.6)'),
                'dependency' => array(
                    'element' => 'custom_blog_mask',
                    'value' => 'true'
                ),
                'group' => esc_html__( 'Custom', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-5',
            ),            
            array(
                'type' => 'wgl_checkbox',
                'heading' => esc_html__( 'Add Hover Mask', 'seofy' ),
                'param_name' => 'custom_blog_hover_mask',
                'description' => esc_html__( 'Custom blog hover mask', 'seofy' ),
                'group' => esc_html__( 'Custom', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-7',
            ),
            array(
                'type' => 'colorpicker',
                'class' => '',
                'heading' => esc_html__('Mask Hover Image Color', 'seofy'),
                'param_name' => 'custom_image_hover_mask_color',
                'value' => esc_attr('rgba(14,21,30,.6)'),
                'dependency' => array(
                    'element' => 'custom_blog_hover_mask',
                    'value' => 'true'
                ),
                'group' => esc_html__( 'Custom', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-5',
            ),
            array(
                'type' => 'wgl_checkbox',
                'heading' => esc_html__( 'Add Background to Items', 'seofy' ),
                'param_name' => 'custom_blog_bg_item',
                'description' => esc_html__( 'Custom background items', 'seofy' ),
                'group' => esc_html__( 'Custom', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-7',
            ),
            array(
                'type' => 'colorpicker',
                'class' => '',
                'heading' => esc_html__('Background Color', 'seofy'),
                'param_name' => 'custom_bg_color',
                'value' => esc_attr('rgba(19,17,31,1)'),
                'dependency' => array(
                    'element' => 'custom_blog_bg_item',
                    'value' => 'true'
                ),
                'group' => esc_html__( 'Custom', 'seofy' ),
                'edit_field_class' => 'vc_col-sm-5',
            ),  
        ),

    ));
    
    Seofy_Loop_Settings::init('wgl_blog_posts_tiny_img');
    
    class WPBakeryShortCode_wgl_Blog_Posts_Tiny_Img extends WPBakeryShortCode
    {
    }
    

}