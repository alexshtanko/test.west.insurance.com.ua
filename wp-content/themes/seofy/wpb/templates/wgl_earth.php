<?php
$defaults = array(
	'figure_color' => '#ffffff',
	'width' => '750',
	'add_second_sphere' => false,
);
$atts = vc_shortcode_attribute_parse($defaults, $atts);
extract($atts);

wp_enqueue_script('three', get_template_directory_uri() . '/js/three.min.js', array(), false, false);
wp_enqueue_script('blockchain-earth', get_template_directory_uri() . '/js/blockchain-earth.js', array(), false, false);

?> 
<div class="blockchain-earth" data-second-sphere="<?php echo esc_attr($add_second_sphere);?>" data-sphere-color="<?php echo esc_attr($figure_color);?>" data-sphere-width="<?php echo esc_attr($width);?>" ><canvas></canvas></div>