<?php
	$theme_color = esc_attr(Seofy_Theme_Helper::get_option("theme-custom-color"));

	$defaults = array(
		// Styles
		'title_custom_color' => false,
		'title_color' => '#919191',
		'title_color_hover' => '#ffffff',
		'subtitle_custom_color' => false,
		'subtitle_color' => '#dadada',
		'subtitle_color_hover' => '#dadada',
		'bar_custom_color' => false,
		'bar_color' => 'rgba(255, 255, 255, 0.1)',
		'bar_color_hover' => $theme_color,
	);
	$atts = vc_shortcode_attribute_parse($defaults, $atts);
	extract($atts);

	$title_array = $subtitle_array = $tab_id_array = $timetabs_id = $timetabs_id_attr = '';

	// Extract tab titles
	preg_match_all( '/tab_title="([^\"]*)"[^\]]*tab_sub_title="([^\"]*)"[^\]]tab_id="([^\"]*)"/i', $content, $matches, PREG_OFFSET_CAPTURE );
	$tab_titles = array();

	if ( isset( $matches[1] ) ) {
		$title_array = $matches[1];
	}
	if ( isset( $matches[2] ) ) {
		$subtitle_array = $matches[2];
	}
	if ( isset( $matches[3] ) ) {
		$tab_id_array = $matches[3];
	}

	if ((bool)$title_custom_color || (bool)$subtitle_custom_color || (bool)$bar_custom_color) {
		$timetabs_id = uniqid( "timetabs_" );
		$timetabs_id_attr = ' id='.$timetabs_id;
	}

	ob_start();
	if ((bool)$title_custom_color) {
		echo "#$timetabs_id .wgl_tab .tab_title {color:".(!empty($title_color) ? esc_attr($title_color) : 'transparent').";}";
		echo "#$timetabs_id .wgl_tab:hover .tab_title {color:".(!empty($title_color_hover) ? esc_attr($title_color_hover) : 'transparent').";}";
		echo "#$timetabs_id .wgl_tab.active .tab_title {color:".(!empty($title_color_hover) ? esc_attr($title_color_hover) : 'transparent').";}";
	}
	if ((bool)$subtitle_custom_color) {
		echo "#$timetabs_id .wgl_tab .tab_subtitle {color:".(!empty($subtitle_color) ? esc_attr($subtitle_color) : 'transparent').";}";
		echo "#$timetabs_id .wgl_tab:hover .tab_subtitle {color:".(!empty($subtitle_color_hover) ? esc_attr($subtitle_color_hover) : 'transparent').";}";
		echo "#$timetabs_id .wgl_tab.active .tab_subtitle {color:".(!empty($subtitle_color_hover) ? esc_attr($subtitle_color_hover) : 'transparent').";}";
	}
	if ((bool)$bar_custom_color) {
		echo "#$timetabs_id .wgl_tab:before {background-color:".(!empty($bar_color) ? esc_attr($bar_color) : 'transparent').";}";
		echo "#$timetabs_id .wgl_tab.active:after {background-color:".(!empty($bar_color_hover) ? esc_attr($bar_color_hover) : 'transparent').";}";
	}
	$styles = ob_get_clean();
	Seofy_shortcode_css()->enqueue_seofy_css($styles);

	$tab_titles_array = array();
	foreach ($title_array as $key => $val) {
		$headings = true;
		$tab_titles_array[] = array(
			'title' => $title_array[$key][0],
			'sub_title' => $subtitle_array[$key][0],
			'tab_id' => 'tab-'.$tab_id_array[$key][0]
		);
		if (empty($title_array[$key][0]) && empty($subtitle_array[$key][0])) {
			$headings = false;
		}
	}

	echo '<div class="wgl_timetabs"'.$timetabs_id_attr.'>';
		if ($headings) {
			echo '<div class="timetabs_headings">';
		}
			foreach ($tab_titles_array as $value) {
				echo '<div class="wgl_tab" data-tab-id="'.esc_attr($value['tab_id']).'">';
					echo !empty($value['title']) ? '<div class="tab_title">'.esc_html($value['title'],'seofy').'</div>' : '';
					echo !empty($value['sub_title']) ? '<div class="tab_subtitle">'.esc_html($value['sub_title'],'seofy').'</div>' : '';
				echo '</div>';
			}
		if ($headings) {
			echo '</div>';
		}
		echo '<div class="timetabs_data">';
			echo do_shortcode($content);
		echo '</div>';
	echo '</div>';

?>