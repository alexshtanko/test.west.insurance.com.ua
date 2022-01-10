<?php

function seofy_radio_image($settings, $value) {
    $name = isset($settings['param_name']) ? $settings['param_name'] : '';
    $type = isset($settings['type']) ? $settings['type'] : '';
    $input_classes = $name . ' ' .  $type;
    
    // start bufer
    ob_start();

    $classes = isset($settings['class']) ? $settings['class'] : '';
    $uniqid = uniqid();
    echo '<input type="hidden" name="'.esc_attr($name).'" class="wpb_vc_param_value radio-image '.esc_attr($input_classes).' '.esc_attr($classes).' '.esc_attr($value).'" value="'.esc_attr($value).'" id="trace-'.esc_attr($uniqid).'"/>';
    ?>
    <div id="wgl-icon-<?php echo esc_attr($uniqid)?>" class="wgl-radio-image">
    <?php

    $fields_list = isset($settings['fields']) ? $settings['fields'] : '';
    // Start render radio image 
    foreach($fields_list as $key => $key_value) {
        echo '<label class="'.($key == $value ? 'selected' : '').'"><img class="select-image" src="' . esc_url($key_value['image_url']) . '" alt="'.esc_attr($name).'"/><input type="radio" name="'.esc_attr($name).'" class="wpb_vc_param_value '.esc_attr($input_classes).' display_none" value="'.esc_attr($key).'" /><span>' . esc_attr($key_value['label']) . '</span></label>';
    }
    ?>
    </div>
    <?php
    // Get bufer content
    $content = ob_get_clean();
    return $content;
}

?>