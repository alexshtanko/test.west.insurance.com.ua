<?php
$header_font = Seofy_Theme_Helper::get_option('header-font');
$main_font = Seofy_Theme_Helper::get_option('main-font');

$theme_color = esc_attr(Seofy_Theme_Helper::get_option("theme-custom-color"));

$defaults = array(
    // General
    'blog_title' => '',
    'blog_subtitle' => '',
    'blog_style' => 'medium_img',
    'blog_layout' => 'grid',
    'min_height_blog' => '',
    'blog_navigation' => 'none',
    'items_load'  => 4,
    'blog_navigation_align' => 'left',
    'css_animation' => '',
    'css' => '',
    'extra_class' => '',
    // Content
    'blog_columns' => '12',
    'hide_media' => '',
    'hide_content' => '',
    'hide_blog_title' => '',
    'hide_postmeta' => '',
    'meta_author' => '',
    'meta_comments' => 'true',
    'meta_categories' => '',
    'meta_date' => '',
    'hide_likes' => '',
    'hide_share' => '',
    'read_more_hide' => 'true',
    'content_letter_count' => '290',
    'crop_square_img' => 'true',
    // Carousel
    'use_carousel' => false,
    'autoplay' => false,
    'autoplay_speed' => '3000',
    'use_pagination' => true,
    'use_navigation' => true,
    'pag_type' => 'circle',
    'pag_offset' => '',
    'custom_pag_color' => false,
    'pag_color' => $theme_color,
    'custom_resp' => false,
    'resp_medium' => '1025',
    'resp_medium_slides' => '',
    'resp_tablets' => '800',
    'resp_tablets_slides' => '',
    'resp_mobile' => '480',
    'resp_mobile_slides' => '',
    // Custom style
    'heading_tag' => 'h4',
    'heading_margin_bottom' => '12px',
    'custom_fonts_blog_content' => '',
    'google_fonts_blog' => '',
    'custom_fonts_blog_headings' => '',
    'google_fonts_blog_headings' => '',
    'custom_main_color' => '#abaebe',
    'custom_read_more_color' => esc_attr($theme_color),
    'custom_hover_read_more_color' => esc_attr($main_font['color']),
    'custom_headings_color' => esc_attr($header_font['color']),
    'custom_hover_headings_color' => esc_attr($theme_color),
    'custom_content_color' => esc_attr($main_font['color']),
    'heading_font_size' => '24',
    'heading_line_height' => '34',
    'content_font_size' => '16',
    'content_line_height' => '30',   
    'custom_blog_mask' => '',
    'custom_image_mask_color' => 'rgba(14,21,30,.6)',
    'custom_blog_bg_item' => '',
    'custom_bg_color' => 'rgba(19,17,31,1)',
    'custom_blog_hover_mask'    => '',
    'custom_image_hover_mask_color'    => 'rgba(14,21,30,.6)',
    'blog_border_color' => '#eeeeee',
    'custom_fonts_blog_size_headings' => '',
    'custom_fonts_blog_size_content' => '',
    'use_custom_heading_color' => '',
    'use_custom_content_color' => '',
    'use_custom_main_color' => '',
    'use_custom_read_color' => '',
    'name_load_more' => esc_html__('Load More', 'seofy'),
);

$atts = vc_shortcode_attribute_parse($defaults, $atts);

extract($atts);

list($query_args) = Seofy_Loop_Settings::buildQuery($atts);

// Add Page to Query
global $paged;
if (empty($paged)) {
    $paged = (get_query_var('page')) ? get_query_var('page') : 1;
}
$query_args['paged'] = $paged;

// New Query

$class_to_filter = vc_shortcode_custom_css_class( $css, ' ' ) . $this->getExtraClass( $extra_class );
$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $class_to_filter, $this->settings['base'], $atts );

// Animation
$animation_class = '';
if (! empty($atts['css_animation'])) {
    $animation_class = $this->getCSSAnimation( $atts['css_animation'] );
}

// Start Custom CSS
$styles = $blog_id = '';
// Add custom id

$custom_style = '';

switch (true) {      
    case (bool)$custom_fonts_blog_content:
        $custom_style = true;
        break;    
    case (bool)$custom_fonts_blog_headings:
        $custom_style = true;
        break;    
    case (bool)$use_custom_heading_color:
        $custom_style = true;
        break;    
    case (bool)$use_custom_content_color:
        $custom_style = true;
        break;    
    case (bool)$use_custom_main_color:
        $custom_style = true;
        break;    
    case (bool)$use_custom_read_color:
        $custom_style = true;
        break; 
    case (bool)$custom_blog_mask:
        $custom_style = true;
        break;    
    case (bool)$custom_blog_hover_mask:
        $custom_style = true;
        break;           
    case (bool)$custom_fonts_blog_size_headings:
        $custom_style = true;
        break;      
    case (bool)$custom_fonts_blog_size_content:
        $custom_style = true;
        break;    
    case (bool)$custom_blog_bg_item:
        $custom_style = true;
        break;
}


if( (bool)$custom_style ) {
    $blog_id = uniqid( "blog_module_" );
}

// Render Google Fonts
if( (bool)$custom_fonts_blog_content || (bool)$custom_fonts_blog_headings ) {

    $blog_value_font = $blog_value_font_headings = '';
    extract( GoogleFontsRender::getAttributes( $atts, $this, array('google_fonts_blog', 'google_fonts_blog_headings')));

    if ( ! empty( $styles_google_fonts_blog ) ) {
        $blog_value_font = esc_attr( $styles_google_fonts_blog );
        $styles .= "#$blog_id.blog-posts,
        #$blog_id.blog-posts .button-read-more,
        #$blog_id.blog-posts .wgl-likes .sl-count {
            ".$blog_value_font."
        }";

    }

    if ( ! empty( $styles_google_fonts_blog_headings ) ) {
        $blog_value_font_headings = esc_attr( $styles_google_fonts_blog_headings );
        $styles .= "
        #$blog_id.blog-posts .blog-post_title {
            ".$blog_value_font_headings."
        }";
    }

    
}

// Render colors and font size
if ( (bool)$custom_style ) {

    $custom_main_color_css = !empty($custom_main_color) ? ' color:'.$custom_main_color.';' : '';
    $custom_main_bg_css = !empty($custom_main_color) ? ' background-color:'.$custom_main_color.';' : '';
    $custom_read_color_css = !empty($custom_read_more_color) ? ' color:'.$custom_read_more_color.';' : '';
    $custom_hover_read_color_css = !empty($custom_hover_read_more_color) ? ' color:'.$custom_hover_read_more_color.';' : '';
    
    $custom_headings_color_css = !empty($custom_headings_color) ? ' color:'.$custom_headings_color.';' : '';
    $custom_headings_hover_color_css = !empty($custom_hover_headings_color) ? ' color:'.$custom_hover_headings_color.';' : '';
    $custom_content_color_css = !empty($custom_content_color) ? ' color:'.$custom_content_color.';' : '';
    
    $heading_font_size_css = !empty($heading_font_size) ? ' font-size:'.$heading_font_size.'px;' : '';
    $heading_line_height = !empty($heading_font_size) ? ' line-height:'.$heading_line_height.'px;' : '';
    $content_font_size_css = !empty($content_font_size) ? ' font-size:'.$content_font_size.'px;' : '';
    $content_line_height = !empty($content_line_height) ? ' line-height:'.$content_line_height.'px;' : '';
    $background_color = !empty($custom_image_mask_color) ? ' background-color:'.$custom_image_mask_color.';' : '';
    $background_color_hover = !empty($custom_image_hover_mask_color) ? ' background-color:'.$custom_image_hover_mask_color.';' : '';
    $background_color_items = !empty($custom_bg_color) ? ' background-color:'.$custom_bg_color.';' : '';

    // custom testimonials colors
    ob_start();

    if ((bool)$use_custom_heading_color && (bool)$custom_headings_color_css) {
        echo "#$blog_id.blog-posts .blog-post_title,
        #$blog_id.blog-posts .blog-post_title a {
            ".$custom_headings_color_css ."
        }";
    }     

    if ((bool)$use_custom_heading_color && (bool)$custom_headings_hover_color_css) {
        echo "#$blog_id.blog-posts .blog-post_title:hover,
        #$blog_id.blog-posts .blog-post_title a:hover {
            ".$custom_headings_hover_color_css ."
        }";
    }    

    if ((bool)$custom_fonts_blog_size_headings &&  (bool)$heading_font_size_css ) {
        echo "#$blog_id.blog-posts .blog-post_title,
        #$blog_id.blog-posts .blog-post_title a {
            ".$heading_font_size_css. $heading_line_height ."
        }";
    }

    if ( (bool)$use_custom_content_color &&  (bool)$custom_content_color_css) {
        echo "#$blog_id.blog-posts .blog-post_text {
            ".$custom_content_color_css."
            line-height: 1.7;
        }";
    }  

    if ((bool)$custom_fonts_blog_size_content && (bool)$content_font_size_css) {
        echo "#$blog_id.blog-posts .blog-post_text {
            ".$content_font_size_css. $content_line_height ."
        }";
    }


    if ((bool) $use_custom_main_color && (bool)$custom_main_color_css ) {
        echo "#$blog_id.blog-posts .blog-post_title a:hover,
        #$blog_id.blog-posts .meta-wrapper,
        #$blog_id.blog-posts .meta-wrapper a,
        #$blog_id.blog-posts .blog-post_meta-categories .lavalamp-object,
        #$blog_id.blog-posts .blog-post_meta-categories a,
        #$blog_id.blog-posts .blog-post_meta-categories span,
        #$blog_id.blog-posts .blog-post_likes-wrap .sl-count,
        #$blog_id.blog-posts .blog-post_likes-wrap .sl-icon,
        #$blog_id.blog-posts .meta-wrapper a:hover{
            ".$custom_main_color_css."
        }";
    }    
    if ((bool) $use_custom_main_color && (bool)$custom_main_color_css ) {
        echo "#$blog_id.blog-posts .blog-post_meta-categories .lavalamp-object{
            ".$custom_main_bg_css."
        }";            
    }

    if ((bool) $use_custom_read_color && (bool)$custom_read_color_css ) {
        echo "#$blog_id.blog-posts .button-read-more:not(:hover),
        #$blog_id.blog-posts .button-read-more:after{
            ".$custom_read_color_css."
        }";
    }  

    if ((bool) $use_custom_read_color && (bool)$custom_hover_read_color_css ) {
        echo "#$blog_id.blog-posts .button-read-more:hover,
        #$blog_id.blog-posts .button-read-more:hover:after{
            ".$custom_hover_read_color_css."
        }";
    }               

    if((bool) $custom_blog_mask){
        echo "#$blog_id.blog-posts .blog-post_bg_media:before,
        #$blog_id.blog-posts .blog-post.format-standard-image .blog-post_media .blog-post_feature-link:before{
            ".$background_color."
        }";        
    } 

    if((bool) $custom_blog_hover_mask){
        echo "#$blog_id.blog-posts .blog-post:hover .blog-post_bg_media:before,
        #$blog_id.blog-posts .blog-post.hide_media:hover,
        #$blog_id.blog-posts .blog-post.format-standard-image .blog-post_media .blog-post_feature-link:before{
            ".$background_color_hover."
        }";        
    }

    if((bool) $custom_blog_bg_item){
        echo "#$blog_id.blog-posts .blog-post{
            ".$background_color_items."
        }";        
    } 
    

    $styles .= ob_get_clean();
    
}

// Register css
if (!empty($styles)) {
    Seofy_shortcode_css()->enqueue_seofy_css($styles);
}

if($blog_navigation == 'none'){
    $query_args['no_found_rows'] = true;
    $query_args['ignore_sticky_posts'] = 1;
}

$query = Seofy_Theme_Cache::cache_query($query_args);
    // Render Items blog
$wgl_def_atts = array(
    'query' => $query,
    'animation_class' => $animation_class,
        // General
    'blog_layout' => '',
    'blog_title' => '',
    'blog_subtitle' => '',
        // Content
    'blog_columns' => '',
    'hide_media' => '',
    'hide_share' => '',
    'hide_content' => '',
    'hide_blog_title' => '',
    'hide_postmeta' => '',
    'meta_author' => '',
    'meta_comments' => '',
    'meta_categories' => '',
    'meta_date' => '',
    'hide_likes' => '',
    'read_more_hide' => $read_more_hide,
    'content_letter_count' => '',
    'crop_square_img' => $crop_square_img,
    'heading_tag' => '',
    'heading_margin_bottom' => $heading_margin_bottom,
    'items_load'  => $items_load,
    'blog_style' => 'medium_img',
    'min_height_blog'   => '',
    'name_load_more'    => $name_load_more
);

global $wgl_blog_atts;
$wgl_blog_atts = array_merge($wgl_def_atts ,array_intersect_key($atts, $wgl_def_atts));
ob_start();

get_template_part('templates/post/post', $blog_style);

$blog_items = ob_get_clean();

// Render row class
$row_class = '';

wp_enqueue_script( 'imagesloaded' ); 
if ($blog_layout == 'masonry') {
    //Call Wordpress Isotope
    wp_enqueue_script('isotope');
    $row_class .= 'blog_masonry';
}

// Allowed HTML render
$allowed_html = array(
    'a' => array(
        'href' => true,
        'title' => true,
    ),
    'br' => array(),
    'em' => array(),
    'strong' => array()
); 

// Options for carousel
if ($blog_layout == 'carousel') {
    switch ($blog_columns){
        case '6':
            $item_grid = 2;
            break;
        case '3':
            $item_grid = 4;
            break;
        case '4':
            $item_grid = 3;
            break;
        case '12':
            $item_grid = 1;
            break;
        default:
            $item_grid = 6;
            break;
    }

    $carousel_options_arr = array(
        'slide_to_show' => $item_grid,
        'autoplay' => $autoplay,
        'autoplay_speed' => $autoplay_speed,
        'use_pagination' => $use_pagination,
        'use_navigation' => $use_navigation,
        'pag_type' => $pag_type,
        'pag_offset' => $pag_offset,
        'custom_pag_color' => $custom_pag_color,
        'pag_color' => $pag_color,
        'custom_resp' => $custom_resp,
        'resp_medium' => $resp_medium,
        'resp_medium_slides' => $resp_medium_slides,
        'resp_tablets' => $resp_tablets,
        'resp_tablets_slides' => $resp_tablets_slides,
        'resp_mobile' => $resp_mobile,
        'resp_mobile_slides' => $resp_mobile_slides,
        'adaptive_height'   => true
    );

    if((bool) $use_navigation){
        $carousel_options_arr['use_prev_next'] = 'true';
    }
    // carousel options
    $carousel_options = array_map(function($k, $v) { return "$k=\"$v\" "; }, array_keys($carousel_options_arr), $carousel_options_arr);
    $carousel_options = implode('', $carousel_options);

    wp_enqueue_script('slick', get_template_directory_uri() . '/js/slick.min.js', array(), false, false);

    $blog_items = do_shortcode('[wgl_carousel '.$carousel_options.']'.$blog_items.'[/wgl_carousel]');

    $row_class = 'blog_carousel';
    if(!empty($blog_title) || !empty($blog_title)){
        $row_class .= ' blog_carousel_title-arrow';
    }
}

// Row class for grid and massonry
if ( in_array($blog_layout, array('grid', 'masonry')) ) {

    switch ( $blog_columns ) {
        case '12':
            $row_class .= ' blog_columns-1';
            break;
        case '6':
            $row_class .= ' blog_columns-2';
            break;
        case '4':
            $row_class .= ' blog_columns-3';
            break;
        case '3':
            $row_class .= ' blog_columns-4';
            break;
    }
    $row_class .= " ".$blog_layout;

}
$row_class .= " blog-style-".$blog_style;

// Render wraper
if ($query->have_posts()): ?>
    <section class="wgl_cpt_section">
        <div <?php if ((bool)$blog_id) echo 'id="'.esc_attr($blog_id).'"' ?> class="blog-posts <?php echo esc_attr($css_class); ?>">
            <?php 
            if(!empty($blog_title) || !empty($blog_subtitle)){
                echo '<div class="wgl_module_title item_title">';
                if(!empty($blog_title)) echo '<h3 class="seofy_module_title blog_title">'.wp_kses( $blog_title, $allowed_html ).'</h3>';
                if(!empty($blog_subtitle)) echo '<p class="blog_subtitle">'.wp_kses( $blog_subtitle, $allowed_html ).'</p>';

                if ($blog_layout == 'carousel' && (bool) $use_navigation) {
                    echo '<div class="carousel_arrows"><span class="left_slick_arrow"><span></span></span><span class="right_slick_arrow"><span></span></span></div>';      
                }  
                echo '</div>';           
            }
            echo '<div class="container-grid row '. esc_attr($row_class) .'">';
                echo Seofy_Theme_Helper::render_html($blog_items);
            echo '</div>';
            ?>
        </div>
<?php

if ( $blog_navigation == 'pagination' ) {
    echo Seofy_Theme_Helper::pagination('10', $query, $blog_navigation_align);
}

if ( $blog_navigation == 'load_more' ) {
    $wgl_blog_atts['post_count'] = $query->post_count;
    $wgl_blog_atts['query_args'] = $query_args;
    $wgl_blog_atts['atts'] = $atts;
    $class  = 'blog_load_more';
    echo Seofy_Theme_Helper::load_more('10', $wgl_blog_atts, $blog_navigation_align, $name_load_more, $class);
}
    echo '</section>';
endif;
?>
<?php
// Clear global var
unset($wgl_blog_atts);
?>