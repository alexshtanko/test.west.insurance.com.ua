<?php

if (!class_exists('Vc_Manager')) {
    return;
}



if(!class_exists('Wgl_vc_addons')){
    class Wgl_vc_addons{
        static public $row_atts = array();

        public static function wgl_vc_row_before($atts, $content){
            $full_width = $output =  "";
            extract( $atts);         
            if($full_width == ''){
                $output .= '<div class="wgl-container">';
            }    
            return $output;     
        }
        
        public static function wgl_vc_row($atts, $content){         
            $el_class = $full_height = $parallax_speed_bg = $parallax_speed_video = $full_width = $equal_height = $flex_row = $columns_placement = $content_placement = $parallax = $parallax_image = $css = $el_id = $video_bg = $video_bg_url = $video_bg_parallax = $css_animation = '';
            $disable_element = '';
            $output = $after_output = '';

            $tag = "vc_row";
            $sc_obj = Vc_Shortcodes_Manager::getInstance()->getElementClass( $tag );

            $atts = vc_map_get_attributes( $sc_obj->getShortcode(), $atts );
            extract( $atts );

            wp_enqueue_script( 'wpb_composer_front_js' );

            $el_class = $sc_obj->getExtraClass( $el_class ) . $sc_obj->getCSSAnimation( $css_animation );
            $css_classes = array(
                'vc_row',
                'wpb_row',
                //deprecated
                'vc_row-fluid',
                $el_class,
            );

            if ($full_width != 'stretch_row') {
                $css_classes[] = vc_shortcode_custom_css_class( $css );
            }

            if ( 'yes' === $disable_element ) {
                if ( vc_is_page_editable() ) {
                    $css_classes[] = 'vc_hidden-lg vc_hidden-xs vc_hidden-sm vc_hidden-md';
                } else {
                    return '';
                }
            }

            if ( vc_shortcode_custom_css_has_property( $css, array(
                    'border',
                    'background',
                ) ) || $video_bg || $parallax
            ) {
                $css_classes[] = 'vc_row-has-fill';
            }

            if ( ! empty( $atts['gap'] ) ) {
                $css_classes[] = 'vc_column-gap-' . $atts['gap'];
            }

            $wrapper_attributes = array();
            // build attributes for wrapper
            if ( ! empty( $el_id ) ) {
                $wrapper_attributes[] = 'id="' . esc_attr( $el_id ) . '"';
            }
            if ( ! empty( $full_width ) ) {
                $wrapper_attributes[] = 'data-vc-full-width="true"';
                $wrapper_attributes[] = 'data-vc-full-width-init="false"';
                if ( 'stretch_row_content' === $full_width ) {
                    $wrapper_attributes[] = 'data-vc-stretch-content="true"';
                } elseif ( 'stretch_row_content_no_spaces' === $full_width ) {
                    $wrapper_attributes[] = 'data-vc-stretch-content="true"';
                    $css_classes[] = 'vc_row-no-padding';
                }
                $after_output .= '<div class="vc_row-full-width vc_clearfix"></div>';
            }

            if ( ! empty( $full_height ) ) {
                $css_classes[] = 'vc_row-o-full-height';
                if ( ! empty( $columns_placement ) ) {
                    $flex_row = true;
                    $css_classes[] = 'vc_row-o-columns-' . $columns_placement;
                    if ( 'stretch' === $columns_placement ) {
                        $css_classes[] = 'vc_row-o-equal-height';
                    }
                }
            }

            if ( ! empty( $equal_height ) ) {
                $flex_row = true;
                $css_classes[] = 'vc_row-o-equal-height';
            }

            if ( ! empty( $content_placement ) ) {
                $flex_row = true;
                $css_classes[] = 'vc_row-o-content-' . $content_placement;
            }

            if ( ! empty( $flex_row ) ) {
                $css_classes[] = 'vc_row-flex';
            }

            $has_video_bg = ( ! empty( $video_bg ) && ! empty( $video_bg_url ) && vc_extract_youtube_id( $video_bg_url ) );

            $parallax_speed = $parallax_speed_bg;
            if ( $has_video_bg ) {
                $parallax = $video_bg_parallax;
                $parallax_speed = $parallax_speed_video;
                $parallax_image = $video_bg_url;
                $css_classes[] = 'vc_video-bg-container';
                wp_enqueue_script( 'vc_youtube_iframe_api_js' );
            }

            if ( ! empty( $parallax ) ) {
                wp_enqueue_script( 'vc_jquery_skrollr_js' );
                $wrapper_attributes[] = 'data-vc-parallax="' . esc_attr( $parallax_speed ) . '"'; // parallax speed
                $css_classes[] = 'vc_general vc_parallax vc_parallax-' . $parallax;
                if ( false !== strpos( $parallax, 'fade' ) ) {
                    $css_classes[] = 'js-vc_parallax-o-fade';
                    $wrapper_attributes[] = 'data-vc-parallax-o-fade="on"';
                } elseif ( false !== strpos( $parallax, 'fixed' ) ) {
                    $css_classes[] = 'js-vc_parallax-o-fixed';
                }
            }

            if ( ! empty( $parallax_image ) ) {
                if ( $has_video_bg ) {
                    $parallax_image_src = $parallax_image;
                } else {
                    $parallax_image_id = preg_replace( '/[^\d]/', '', $parallax_image );
                    $parallax_image_src = wp_get_attachment_image_src( $parallax_image_id, 'full' );
                    if ( ! empty( $parallax_image_src[0] ) ) {
                        $parallax_image_src = $parallax_image_src[0];
                    }
                }
                $wrapper_attributes[] = 'data-vc-parallax-image="' . esc_attr( $parallax_image_src ) . '"';
            }
            if ( ! $parallax && $has_video_bg ) {
                $wrapper_attributes[] = 'data-vc-video-bg="' . esc_attr( $video_bg_url ) . '"';
            }
            if ($full_width == 'stretch_row') {
                $custom_css_classes = $css_classes;
                $css_classes = array('wgl_wrapper', vc_shortcode_custom_css_class( $css ));
            }
            $css_class = preg_replace( '/\s+/', ' ', apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, implode( ' ', array_filter( array_unique( $css_classes ) ) ), $tag, $atts ) );
            $wrapper_attributes[] = 'class="' . esc_attr( trim( $css_class ) ) . '"';

            $output .= '<div ' . implode( ' ', $wrapper_attributes ) . '>';
            if ($full_width == 'stretch_row') {
                $output .= '<div class="wgl-container"><div class="'.esc_attr(trim( implode( ' ', array_filter( array_unique( $custom_css_classes ) )) )).'">';
            }
            $output .= wpb_js_remove_wpautop( $content );
            if ($full_width == 'stretch_row') {
                $output .= '</div></div>';
            }
            $output .= '</div>';
            $output .= $after_output;
            return $output;
        }   
        public static function wgl_vc_row_after($atts, $content){         
            $output = $full_width = '';
            extract( $atts );
            if ($full_width == '') {
                $output .= '</div>';
            }
            return $output;
        }
    }
    new Wgl_vc_addons;
}

if ( !function_exists( 'vc_theme_before_vc_row' ) ) {
    function vc_theme_before_vc_row($atts, $content = null) {
        return Wgl_vc_addons::wgl_vc_row_before($atts, $content);
    }
}

if ( !function_exists( 'vc_theme_vc_row' ) ) {
    function vc_theme_vc_row($atts, $content = null) {
        return Wgl_vc_addons::wgl_vc_row($atts, $content);
    }
}

if ( !function_exists( 'vc_theme_after_vc_row' ) ) {
    function vc_theme_after_vc_row($atts, $content = null) {
        return Wgl_vc_addons::wgl_vc_row_after($atts, $content);
    }
}
