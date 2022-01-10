<?php
    $theme_color = esc_attr(Seofy_Theme_Helper::get_option("theme-custom-color"));
    wp_enqueue_script('countdown', get_template_directory_uri() . '/js/jquery.countdown.min.js', array(), false, false);

	$defaults = array(
		'icon_type' => 'font',
        'countdown_year' => '2018',
        'countdown_month' => '10',
        'countdown_day' => '17',
        'countdown_hours' => '11',
        'countdown_min' => '30',        
        'number_color' => '#ffffff',            
        'countdown_color' => '#ffffff',            
        'points_color' => $theme_color,            
        'custom_fonts_countdown' => 'yes',  
        'hide_day' => '',  
        'hide_hours' => '',  
        'hide_minutes' => '',  
        'hide_seconds' => '',  
        'size' => 'large',  
        'font_size' => '',  
        'font_size_number' => '',  
        'font_size_text' => '',  
        'font_weight' => '',  
        'font_text_weight' => '',  
        'align' => 'center',  
	);

	$atts = vc_shortcode_attribute_parse($defaults, $atts);
	extract($atts);

    extract( GoogleFontsRender::getAttributes( $atts, $this, array('google_fonts_countdown') ) );

    $countdown_value_font = '';

    // uniq id
    $countdown_id = uniqid( "countdown_" );
    $countdown_attr = 'id='.$countdown_id;

    // custom social colors
    ob_start();
        echo "#$countdown_id .countdown-amount{
            color: ".$number_color.";
        }";
        echo "#$countdown_id .countdown-amount:before,
            #$countdown_id .countdown-amount:after{
            background-color: ".$points_color.";
        }";
        if ($font_weight != '') {
            echo "#$countdown_id .countdown-amount{
                font-weight: ".$font_weight.";
            }";
        }
        if ($font_text_weight != '') {
            echo "#$countdown_id .countdown-period{
                font-weight: ".$font_text_weight.";
            }";
        }
        if( $size == 'custom' ){
            if(!empty($font_size_number)){
                echo "#$countdown_id .countdown-amount{
                    font-size: ".floatval($font_size_number)."em;
                }";                
            }
            if(!empty($font_size_text)){
                echo "#$countdown_id .countdown-period{
                    font-size: ".floatval($font_size_text)."em;
                }";                  
            }
       
        }
    $styles = ob_get_clean();
    Seofy_shortcode_css()->enqueue_seofy_css($styles);


    if(isset($styles_google_fonts_countdown) && !empty($styles_google_fonts_countdown)){
        $countdown_value_font = '' . esc_attr( $styles_google_fonts_countdown ) . '; ';
    }

    $countdown_class = '';
    if($custom_fonts_countdown != 'yes'){
        $countdown_class .= ' custom_countdown';
    }

    $countdown_class .= ' countdown_size_'.$size;
    $countdown_class .= ' countdown_align_'.$align;

    $countdown_style = '';
    $countdown_style .= "color:".esc_attr($countdown_color).";";
    $countdown_style .= !empty($countdown_value_font) ? $countdown_value_font : "";
    $countdown_style .= $size == 'custom' ? 'font-size:'.$font_size.'px;' : "";

    $f = '';
    if (!(bool)$hide_day) {
        $f .= 'd';
    }
    if (!(bool)$hide_hours) {
        $f .= 'H';
    }
    if (!(bool)$hide_minutes) {
        $f .= 'M';
    }
    if (!(bool)$hide_seconds) {
        $f .= 'S';
    }
    //Countdow data attribute http://keith-wood.name/countdown.html
    $data_array = array(); 

    if (!empty($f)) {
        $data_array['format']    =  esc_attr($f);
    }
    $data_array['year'] =  esc_attr($countdown_year);
    $data_array['month'] =  esc_attr($countdown_month);
    $data_array['day'] =  esc_attr($countdown_day);
    $data_array['hours'] =  esc_attr($countdown_hours);
    $data_array['minutes'] =  esc_attr($countdown_min);

    $data_array['labels'][]  =  esc_attr( esc_html__('Years', 'seofy') );
    $data_array['labels'][]  =  esc_attr( esc_html__('Months', 'seofy') );
    $data_array['labels'][]  =  esc_attr( esc_html__('Weeks', 'seofy') );
    $data_array['labels'][]  =  esc_attr( esc_html__('Days', 'seofy') );
    $data_array['labels'][]  =  esc_attr( esc_html__('Hours', 'seofy') );
    $data_array['labels'][]  =  esc_attr( esc_html__('Minutes', 'seofy') );
    $data_array['labels'][]  =  esc_attr( esc_html__('Seconds', 'seofy') );
    $data_array['labels1'][] =  esc_attr( esc_html__('Year', 'seofy') );
    $data_array['labels1'][] =  esc_attr( esc_html__('Month', 'seofy') );
    $data_array['labels1'][] =  esc_attr( esc_html__('Week', 'seofy') );
    $data_array['labels1'][] =  esc_attr( esc_html__('Day', 'seofy') );
    $data_array['labels1'][] =  esc_attr( esc_html__('Hour', 'seofy') );
    $data_array['labels1'][] =  esc_attr( esc_html__('Minute', 'seofy') );
    $data_array['labels1'][] =  esc_attr( esc_html__('Second', 'seofy') );

    $data_attribute = json_encode($data_array, true);

    echo '<div '.$countdown_attr.' class="seofy_module_countdown'.esc_attr($countdown_class).'" data-atts="'.esc_js($data_attribute).'" style="'.esc_attr($countdown_style).'">';
    echo '</div>';

?>
    
