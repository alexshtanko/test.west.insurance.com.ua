<?php

function seofy_checkbox_custom($settings, $value) {
    $uid = uniqid();
    $param_name = isset($settings['param_name']) ? $settings['param_name'] : '';
    $type = isset($settings['type']) ? $settings['type'] : '';
    $class = isset($settings['class']) ? $settings['class'] : '';
    $values = isset( $settings['value'] ) && is_array( $settings['value'] ) ? $settings['value'] : array( esc_html__( 'Yes', 'seofy' ) => 'true' );

    $output = $checked = '';

    if(is_array($values) && !empty($values)){
		foreach($values as $label => $key){
			$checked = $active_class = "";
			if((bool)$value == $key){
				$checked = "checked=checked";
				$active_class = "checked";
			}

			$output .= '<div class="wgl_checkbox_wrapper">
							<input type="checkbox" name="'.esc_attr($param_name).'" value="'.esc_attr($value).'" class="wpb_vc_param_value ' . esc_attr($param_name) . ' ' . esc_attr($type) . ' ' . esc_attr($class) . '" id="wgl_checkbox-'.esc_attr($uid).'" '.esc_attr($checked).'>
							<label class="wgl_checkbox_label '.esc_attr($active_class).'" for="'.esc_attr($param_name).'" data-value="'.esc_attr($key).'">
								<span class="button-animation"></span>
							</label>
						</div>';
		}
	}

    return $output;
}

add_filter( 'vc_map_get_param_defaults', 'wgl_checkbox_param_defaults', 10, 2 );
function wgl_checkbox_param_defaults( $value, $param ) {
    if ( 'checkbox_custom' === $param['type'] ) {
        $value = '';
        if ( isset( $param['std'] ) ) {
            $value = $param['std'];
        }
    }

    return $value;
}