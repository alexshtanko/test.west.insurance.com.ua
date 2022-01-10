<?php
	$main_font = Seofy_Theme_Helper::get_option('main-font');

	$defaults = array(
		'extra_class' => '',
		'font_size' => (int)$main_font['font-size'],
		'line_height' => (int)$main_font['line-height'],
		'custom_fonts' => false,
		'responsive_font_desktop' => '',
		'responsive_font_tablet' => '',
		'responsive_font_mobile' => '',
		'font_size_desktop' => '',
		'line_height_desktop' => (int)$main_font['line-height'],
		'font_size_tablet' => '',
		'line_height_tablet' => (int)$main_font['line-height'],
		'font_size_mobile' => '',
		'line_height_mobile' => (int)$main_font['line-height'],

	); 
	$atts = vc_shortcode_attribute_parse($defaults, $atts);
	extract($atts);

	// Render Google Fonts
	extract( GoogleFontsRender::getAttributes( $atts, $this, array('google_fonts_text') ) );

	$class = $css = '';
	
	if ( ! empty( $styles_google_fonts_text ) ) {
		$font_family = esc_attr( $styles_google_fonts_text );
	}

	if (! empty($atts['css_animation'])) {
		$class .= ' '.$this->getCSSAnimation( $atts['css_animation'] );
	}
	$class .= !empty($extra_class) ? ' '.$extra_class : '';
	$class .= (bool)$custom_fonts ? ' custom_font' : '';
	$style = !empty($font_family) ? $font_family.';' : '';
	$style .= $font_size !== '' ? 'font-size:' . esc_attr( (int) $font_size).'px;' : '';
	$style .= $line_height !== '' ? 'line-height:' .esc_attr( (int) $line_height).'px;' : '';

	//Set Responsive options
	$style_desktop = $style_tablet = $style_mobile = '';

	if(!empty($responsive_font_desktop)){
		$style_desktop .= $font_size_desktop !== '' ? 'font-size:' . esc_attr( (int) $font_size_desktop).'px;' : '';
		$style_desktop .= $line_height_desktop !== '' ? 'line-height:' .esc_attr( (int) $line_height_desktop).'px;' : '';
	}

	if(!empty($responsive_font_tablet)){
		$style_tablet .= $font_size_tablet !== '' ? 'font-size:' . esc_attr( (int) $font_size_tablet).'px;' : '';
		$style_tablet .= $line_height_tablet !== '' ? 'line-height:' .esc_attr( (int) $line_height_tablet).'px;' : '';
	}	

	if(!empty($responsive_font_mobile)){
		$style_mobile .= $font_size_mobile !== '' ? 'font-size:' . esc_attr( (int) $font_size_mobile).'px;' : '';
		$style_mobile .= $line_height_mobile !== '' ? 'line-height:' .esc_attr( (int) $line_height_mobile).'px;' : '';
	}

	if(!empty($content)){
		echo '<div class ="seofy_module_text'.esc_attr($class).'"'.(!empty($style) ? ' style="'.$style.'"' : '').'>';

			//Create responsive wrapper
			if(!empty($responsive_font_desktop)){
				echo '<div class="text_desktop"'.(!empty($style_desktop) ? ' style="'.$style_desktop.'"' : '').'>';
			}

			if(!empty($responsive_font_tablet)){
				echo '<div class="text_tablet"'.(!empty($style_tablet) ? ' style="'.$style_tablet.'"' : '').'>';
			}			
			if(!empty($responsive_font_mobile)){
				echo ' <div class="text_mobile"'.(!empty($style_mobile) ? ' style="'.$style_mobile.'"' : '').'>';
			}
			echo do_shortcode($content);
			
			echo !empty($responsive_font_desktop) ? ' </div>' : '';
			
			echo !empty($responsive_font_tablet) ? ' </div>' : '';
			
			echo !empty($responsive_font_mobile) ? ' </div>' : '';

		echo '</div>';
	}
?>  
