<?php

	$theme_color = esc_attr(Seofy_Theme_Helper::get_option("theme-custom-color"));
	
	$defaults = array(
		// General
		'height' => '2px',
		'width' => '100',
		'width_units' => '%',
		'divider_alignment' => 'left',
		'divider_color' => '#ececec',
		// Divider Line
		'add_divider_line' => false,
		'divider_line_alignment' => 'left',
		'divider_line_color' => $theme_color,
	);
	$atts = vc_shortcode_attribute_parse( $defaults, $atts );
	extract($atts);
	
	// Divider classes
	$divider_class = ' divider_alignment_'.$divider_alignment;
	$divider_line_class = ' divider_line_alignment_'.$divider_line_alignment;
	
	// Divider styles
	$divider_styles = ' style='.(!empty($width) ? 'width:'.(int)$width.$width_units.';' : '');
	$divider_styles .= !empty($height) ? 'height:'.(int)$height.'px;' : '';
	$divider_styles .= 'background-color:'.(!empty($divider_color) ? esc_attr($divider_color) : 'transparent').';';

	// Divider line styles
	$divider_line_styles = ' style="background-color:'.(!empty($divider_line_color) ? esc_attr($divider_line_color) : 'transparent').';';

	// Render html
	$divider_line = (bool)$add_divider_line ? '<span class="divider_line"'.$divider_line_styles.';"></span>' : '';

	$output = '<div class="seofy_divider'.esc_attr($divider_class).'">';
		$output .= '<div class="divider_line'.esc_attr($divider_line_class).'">';
			$output .= '<div class="divider_custom"'.esc_attr($divider_styles).'>';
				$output .= $divider_line;
			$output .= '</div>';
		$output .= '</div>';
	$output .= '</div>';
    
	echo Seofy_Theme_Helper::render_html($output);

?>