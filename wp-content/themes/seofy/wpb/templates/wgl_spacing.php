<?php
$defaults = array(
	'spacer_size' => '30px',
	'responsive_desktop' => false,
	'screen_desktops' => '1024',
	'size_desktops' => '',	
	'responsive_tablet' => false,
	'screen_tablet' => '800',
	'size_tablet' => '',	
	'responsive_mobile' => false,
	'screen_mobile' => '480',
	'size_mobile' => ''
);
$atts = vc_shortcode_attribute_parse( $defaults, $atts );
extract($atts);

if(!empty($spacer_size) || $spacer_size == '0'){
	$spacer_id = uniqid( "seofy_spacer_" );

	ob_start();
		if((bool) $responsive_desktop){
			if(!empty($screen_desktops)){
				echo '@media only screen and (max-width: '.(int) $screen_desktops.'px){
					#'.$spacer_id.' .spacing_size{
						display: none;
					}				
					#'.$spacer_id.' .spacing_size-desktops{
						display: block;
					}

				}';					
			}
		}		

		if((bool) $responsive_tablet){
			if(!empty($screen_tablet)){
				echo '@media only screen and (max-width: '.(int) $screen_tablet.'px){
					#'.$spacer_id.' .spacing_size{
						display: none;
					}					
					#'.$spacer_id.' .spacing_size-tablet{
						display: block;
					}

				}';					
			}
		}		

		if((bool) $responsive_mobile){
			if(!empty($screen_mobile)){
				echo '@media only screen and (max-width: '.(int) $screen_mobile.'px){
					#'.$spacer_id.' .spacing_size{
						display: none;
					}					
					#'.$spacer_id.' .spacing_size-mobile{
						display: block;
					}
				}';					
			}
		}

	$styles = ob_get_clean();
	Seofy_shortcode_css()->enqueue_seofy_css($styles);

	$responsive = (bool) $responsive_desktop || (bool) $responsive_tablet || (bool) $responsive_mobile ? true : false;
	$class = '';
	$class .= (bool)$responsive ? ' responsive_active' : '';
	echo '<div '.( (bool) ($responsive)  ? 'id="'.esc_attr($spacer_id).'"' : '').' class ="seofy_module_spacing'.esc_attr($class).'">';
		echo '<div class="spacing_size spacing_size-initial" style="height:'.esc_attr((int)$spacer_size).'px;"></div>';
		if((bool) $responsive_desktop){
			if(!empty($size_desktops) || $size_desktops == 0){
				echo '<div class="spacing_size spacing_size-desktops" style="height:'.esc_attr((int)$size_desktops).'px;"></div>';
			}
		}		
		if((bool) $responsive_tablet){
			if(!empty($size_tablet) || $size_tablet == 0){
				echo '<div class="spacing_size spacing_size-tablet" style="height:'.esc_attr((int)$size_tablet).'px;"></div>';
			}
		}		

		if((bool) $responsive_mobile){
			if(!empty($size_mobile) || $size_mobile == 0){
				echo '<div class="spacing_size spacing_size-mobile" style="height:'.esc_attr((int)$size_mobile).'px;"></div>';
			}
		}


	echo '</div>';
}

?>  
