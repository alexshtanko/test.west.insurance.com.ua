<?php

    $theme_color = esc_attr(Seofy_Theme_Helper::get_option("theme-custom-color"));

    $defaults = array(
        // General
        'select_cats' => '',
        'item_grid' => '4',
        'extra_class' => '',
        // Carousel
        'use_carousel' => false,
        'autoplay' => false,
        'autoplay_speed' => '3000',
        'use_pagination' => false,
        'pag_type' => 'circle',
        'pag_offset' => '',
        'pag_align' => 'center',
        'custom_pag_color' => false,
        'pag_color' => $theme_color,
        'use_prev_next' => false,
        'custom_resp' => false,
        'resp_medium' => '1025',
        'resp_medium_slides' => '',
        'resp_tablets' => '800',
        'resp_tablets_slides' => '',
        'resp_mobile' => '480',
        'resp_mobile_slides' => '',
    );

    $atts = vc_shortcode_attribute_parse($defaults, $atts);
    extract($atts);

    $output = $content = $cats_wrap_classes = $animation_class = '';

    if ((bool)$use_carousel) {
        // carousel options array
        $carousel_options_arr = array(
            'slide_to_show' => $item_grid,
            'autoplay' => $autoplay,
            'autoplay_speed' => $autoplay_speed,
            'use_pagination' => $use_pagination,
            'pag_type' => $pag_type,
            'pag_offset' => $pag_offset,
            'pag_align' => $pag_align,
            'custom_pag_color' => $custom_pag_color,
            'pag_color' => $pag_color,
            'use_prev_next' => $use_prev_next,
            'custom_resp' => $custom_resp,
            'resp_medium' => $resp_medium,
            'resp_medium_slides' => $resp_medium_slides,
            'resp_tablets' => $resp_tablets,
            'resp_tablets_slides' => $resp_tablets_slides,
            'resp_mobile' => $resp_mobile,
            'resp_mobile_slides' => $resp_mobile_slides,
            'infinite' => true,
            'slides_to_scroll' => true,
        );

        // carousel options
        $carousel_options = array_map(function($k, $v) { return "$k=\"$v\" "; }, array_keys($carousel_options_arr), $carousel_options_arr);
        $carousel_options = implode('', $carousel_options);

        wp_enqueue_script('slick', get_template_directory_uri() . '/js/slick.min.js', array(), false, false);
    }

    // Animation
    if (!empty($atts['css_animation'])) {
        $animation_class = $this->getCSSAnimation( $atts['css_animation'] );
    }

    function wgl_get_cat_postcount($id) {
        $cat = get_category($id);
        $count = (int) $cat->count;
        $taxonomy = 'category';
        $args = array(
          'child_of' => $id,
        );
        $tax_terms = get_terms($taxonomy,$args);
        foreach ($tax_terms as $tax_term) {
            $count +=$tax_term->count;
        }
        return $count;
    }

    $cats_arr = explode(",", $select_cats);
    foreach( $cats_arr as $cat ){
        $categories[] = get_category_by_slug($cat);
    }
    foreach( $categories as $cat ){
        $title = $cat->name;
        $count = wgl_get_cat_postcount($cat->term_id);
        $cat_link = get_term_link($cat->term_id);
        $bg_image_id = get_term_meta ( $cat->term_id, 'category-image-id', true );
        $icon_image_id = get_term_meta ( $cat->term_id, 'category-icon-image-id', true );
        $icon_image_alt = get_post_meta($icon_image_id, '_wp_attachment_image_alt', true);
        $bg_image = wp_get_attachment_image_src ( $bg_image_id, 'full' );
        $icon_image = wp_get_attachment_image_src ( $icon_image_id, 'full' );
        $cat_color = get_term_meta ( $cat->term_id, '_category_color', true );

        // item background styles
        $item_bg = !empty($bg_image) ? 'background-image: url('.$bg_image[0].');' : 'background-color: #'.$cat_color.';';
        $item_wrap_styles = !empty($item_bg) ? 'style="'.esc_attr($item_bg).'"' : '';

        // count background styles
        $count_bg = !empty($cat_color) ? 'background-color: #'.$cat_color.';' : '';
        $count_styles = !empty($count_bg) ? 'style="'.esc_attr($count_bg).'"' : '';
        
        $content .= '<div class="cats_item-wrap">';
            $content .= '<div class="cats_item" '.$item_wrap_styles.'>';
                $content .= '<a class="cats_item-link" href="'.esc_url($cat_link).'">';
                    $content .= !empty($icon_image) ? '<img class="cats_item-image" src="'. esc_url($icon_image[0]) .'" alt="'.(!empty($icon_image_alt) ? esc_attr($icon_image_alt) : '').'" />' : '';
                    $content .= '<h3 class="cats_item-title">'.$title.'</h3>';
                    $content .= '<h6 class="cats_item-count" '.$count_styles.'>'.$count.esc_html__( ' News', 'seofy' ).'</h6>';
                $content .= '</a>';
            $content .= '</div>';
        $content .= '</div>';
    }

    // cats wrapper classes
    $cats_wrap_classes .= !(bool)$use_carousel ? ' items-'.$item_grid : '';
    $cats_wrap_classes .= !empty($animation_class) ? ' '.$animation_class : '';
    $cats_wrap_classes .= !empty($extra_class) ? ' '.$extra_class : '';



    $output .= '<div class="seofy_module_cats clearfix'.esc_attr($cats_wrap_classes).'">';
        if ((bool)$use_carousel) {
            $output .= do_shortcode('[wgl_carousel '.$carousel_options.']'.$content.'[/wgl_carousel]');
        } else{
            $output .= $content;
        }
    $output .= '</div>';

    echo Seofy_Theme_Helper::render_html($output);

?>