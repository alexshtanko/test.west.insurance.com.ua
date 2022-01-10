<?php 
// https://github.com/AngeIII/vc-google-fonts-element/blob/master/shortcode/class.php
if (!class_exists('GoogleFontsRender')) {
class GoogleFontsRender {
    public static function getAttributes( $atts, $that, $param_list ) {
        // Shortcode attributes
        $shortcode = $that->getShortcode();
        $atts = vc_map_get_attributes( $shortcode, $atts );

        // Get default values from VC_MAP.
        $google_fonts_obj = new Vc_Google_Fonts();
        $google_fonts_data = array();
        foreach ($param_list as $key => $value ) {
            $wpb_param = WPBMap::getParam( $shortcode, $key );
            $fields = isset( $wpb_param['settings'], $wpb_param['settings']['fields'] ) ? $wpb_param['settings']['fields'] : array();

            $data_single = strlen( $atts[$value] ) > 0 ? $google_fonts_obj->_vc_google_fonts_parse_attributes( $fields, $atts[$value] ) : '';

            array_push($google_fonts_data, $data_single);

        }

        $css = self::arrayElementsStyles($google_fonts_data, $param_list);

        return $css;    

    }

    static function arrayElementsStyles( $fontsData, $elements_array ) {
        $style_string = array();
        foreach ( $fontsData as $name => $value) {
        	$style_array = '';
            // enqueue fonts
            self::enqueueGoogleFonts( $value );
        	if ( ! empty( $value ) && isset( $value['values'], $value['values']['font_family'], $value['values']['font_style'] ) ) {
                	$style_array = self::googleFontsStyles( $value );
                    $style_array = implode( ';', $style_array );
        	}

        	$style_string['styles_'.$elements_array[$name]] = $style_array;
        }
        return $style_string;
    }

    static function enqueueGoogleFonts( $fontsData ) {
        // Get extra subsets for settings (latin/cyrillic/etc)
        $settings = get_option( 'wpb_js_google_fonts_subsets' );
        if ( is_array( $settings ) && ! empty( $settings ) ) {
            $subsets = '&subset=' . implode( ',', $settings );
        } else {
            $subsets = '';
        }
        // We also need to enqueue font from googleapis
        if ( isset( $fontsData['values']['font_family'] ) ) {
            wp_enqueue_style( 'vc_google_fonts_' . vc_build_safe_css_class( $fontsData['values']['font_family'] ), '//fonts.googleapis.com/css?family=' . $fontsData['values']['font_family'] . $subsets );
        }
    }

    static function googleFontsStyles( $fontsData ) {
        // Inline styles
        $fontFamily = explode( ':', $fontsData['values']['font_family'] );
        $styles[] = 'font-family:' . $fontFamily[0];
        $fontStyles = explode( ':', $fontsData['values']['font_style'] );
        $styles[] = 'font-weight:' . $fontStyles[1];
        $styles[] = 'font-style:' . $fontStyles[2];
        return $styles;
    }
}

}
?>