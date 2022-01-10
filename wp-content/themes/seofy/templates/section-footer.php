<?php  if ( ! defined( 'ABSPATH' ) ) { exit; }

if (!class_exists('Seofy_footer_area')) {
	/**
	 * Footer area
	 *
	 *
	 * @class 		Seofy_footer_area
	 * @version		1.0
	 * @category	Class
	 * @author 		WebGeniusLab
	 */

    class Seofy_footer_area {
		/**
		* @since 1.0
		* @access private
		*/  	
    	
    	private $footer_full_width;
    	private $mb_footer_switch;
    	private $mb_copyright_switch;
    	private $id;

    	function __construct () {
	    	// footer option
	        $footer_switch = Seofy_Theme_Helper::get_option('footer_switch');	        
	        $footer_bg_color = Seofy_Theme_Helper::get_option('footer_bg_color');
	        // copyright option
	        $copyright_switch = Seofy_Theme_Helper::get_option('copyright_switch');
			
			//add global variables
	        $this->footer_full_width = Seofy_Theme_Helper::get_option('footer_full_width');
	        $this->id = get_queried_object_id();

	        if (class_exists( 'RWMB_Loader' ) && $this->id !== 0) {
	            $this->mb_footer_switch = rwmb_meta('mb_footer_switch');
	            if ($this->mb_footer_switch == 'on') {
	                $footer_switch = true;
	                $footer_bg_color = rwmb_meta('mb_footer_bg');
	                $footer_bg_color = !empty($footer_bg_color['color']) ? $footer_bg_color['color'] : "";
	            }elseif (rwmb_meta('mb_footer_switch') == 'off') {
	                $footer_switch = false;
	            }	                
	            
	            $this->mb_copyright_switch = rwmb_meta('mb_copyright_switch');      
	            if ($this->mb_copyright_switch == 'on') {
	                $copyright_switch = true;
	            }elseif ($this->mb_copyright_switch == 'off') {
	                $copyright_switch = false;
	            }
	        }

	        //Footer container style
	        $style = !empty($footer_bg_color) ? ' background-color :'.esc_attr($footer_bg_color).';' : '';
	        $style .= Seofy_Theme_Helper::bg_render('footer','mb_footer_switch','on');
	        $style = !empty($style) ? ' style="'.esc_attr($style).'"' : '' ;

	        /*
	        *
	        * Footer render
	        */
	        if ($footer_switch || $copyright_switch) {
	            echo "<footer class='footer clearfix'".$style." id='footer'>";
	                if ($footer_switch) {
	                	$footer_content_type = Seofy_Theme_Helper::options_compare('footer_content_type','mb_footer_switch','on');
	                	switch ($footer_content_type) {
	                		case 'widgets':
	                			$this->main_footer_html();
	                			break;
	                		case 'pages':
	                    		$this->main_footer_get_page();
	                			break;
	                		default:
	                			$this->main_footer_html();
	                			break;
	                	}
	                }

	                if ($copyright_switch) {
	                    $this->copyright_html();
	                }

	            echo "</footer>";
	        }
    	}

    	private function get_mountain_html(){
    		$mountain_switch = Seofy_Theme_Helper::options_compare('footer_add_mountain','mb_footer_switch','on');
    		if((bool) $mountain_switch){
    			$mountain_color = Seofy_Theme_Helper::get_option('footer_mountain_color');
    			$mountain_color = !empty($mountain_color) ? $mountain_color : '';

    			echo "<div class='seofy_mountain_footer'>";

					echo '<svg id="OBJECTS" xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" viewBox="0 0 1920 720" preserveAspectRatio="none">';
					echo '<linearGradient id="SVGID_1_" gradientUnits="userSpaceOnUse" x1="2741.4871" y1="2717.3525" x2="-1771.3439" y2="1921.6184" gradientTransform="matrix(0.9848 -0.1736 0.1736 0.9848 11.3419 105.8396)">';
						echo '<stop  offset="0" style="stop-color:'.(!empty($mountain_color) ? esc_attr($mountain_color) : '#131C77').'"/>';
						echo '<stop  offset="0.2856" style="stop-color:'.(!empty($mountain_color) ? esc_attr($mountain_color) : '#0D166D').'"/>';
						echo '<stop  offset="1" style="stop-color:'.(!empty($mountain_color) ? esc_attr($mountain_color) : '#000857').'"/>';
					echo '</linearGradient>';
					echo '<path class="st0" style="fill:url(#SVGID_1_);" d="M-1381.2,2764.3l320.5,793.3c13.1,32.5,32.9,61.8,58.1,86.2l615.4,594.3c25.2,24.3,55.2,43.1,88.2,55.1
						l804,292.6c32.9,12,68,16.9,102.9,14.5l853.5-59.7c34.9-2.4,69-12.2,99.9-28.7l755.4-401.7c30.9-16.4,58.1-39.2,79.6-66.8
						l526.7-674.2c21.6-27.6,37.1-59.4,45.6-93.4l207-830.1c8.5-34,9.7-69.4,3.6-103.9l-148.6-842.6c-6.1-34.5-19.4-67.3-38.9-96.4
						l-478.4-709.3c-19.6-29-45.1-53.6-74.8-72.2L1713,168c-29.7-18.6-63-30.7-97.7-35.6L768.1,13.3c-34.7-4.9-70-2.4-103.7,7.3
						L-158,256.4c-33.7,9.7-64.9,26.3-91.8,48.8l-655.4,549.9c-26.8,22.5-48.6,50.4-64,81.9l-375,769c-15.4,31.5-23.9,65.9-25.1,100.9
						l-29.9,855C-1400.5,2696.9-1394.3,2731.8-1381.2,2764.3z"/>';
					echo '</svg>';

    			echo "</div>";
    		}
    	}

    	private function get_footer_vars($optn_1 = null){

			$footer_options = array();
			
    		//Get options	
			$footer_spacing = Seofy_Theme_Helper::options_compare('footer_spacing','mb_footer_switch','on');

	        // Only for widgets in footer
	        if ($optn_1 == 'widgets') {
				$footer_options['widget_columns'] = Seofy_Theme_Helper::get_option('widget_columns');
		        $footer_options['widget_columns_2'] = Seofy_Theme_Helper::get_option('widget_columns_2');
		        $footer_options['widget_columns_3'] = Seofy_Theme_Helper::get_option('widget_columns_3');
		        $footer_align = Seofy_Theme_Helper::get_option('footer_align');

	    		//footer container class
				$footer_options['footer_class'] = ' align-'.esc_attr($footer_align);	
	        }

	        //footer padding style
	        $footer_options['footer_style'] = '';
	        $footer_options['footer_style'] .= !empty($footer_spacing['padding-top']) ? ' padding-top:'.(int)$footer_spacing['padding-top'].'px;' : '' ;
	        $footer_options['footer_style'] .= !empty($footer_spacing['padding-bottom']) ? ' padding-bottom:'.(int)$footer_spacing['padding-bottom'].'px;' : '' ;
	        $footer_options['footer_style'] .= !empty($footer_spacing['padding-left']) ? ' padding-left:'.(int)$footer_spacing['padding-left'].'px;' : '' ;
	        $footer_options['footer_style'] .= !empty($footer_spacing['padding-right']) ? ' padding-right:'.(int)$footer_spacing['padding-right'].'px;' : '' ;
	        $footer_options['footer_style'] = !empty($footer_options['footer_style']) ? ' style="'.$footer_options['footer_style'].'"' : '';

	        // Only for widgets in footer
	        if ($optn_1 == 'widgets') {
		        $footer_options['layout'] = array();
		        switch ((int)$footer_options['widget_columns']) {
		            case 1:
		                $footer_options['layout'] = array('12');
		                break;
		            case 2:
		                $footer_options['layout'] = explode('-', $footer_options['widget_columns_2']);
		                break;
		            case 3:
		                $footer_options['layout'] = explode('-', $footer_options['widget_columns_3']);
		                break;
		            case 4:
		                $footer_options['layout'] = array('3','3','3','3');
		                break;
		            default:
		                $footer_options['layout'] = array('3','3','3','3');
		                break;
		        }
	        }

	        return $footer_options;
    	}

    	private function main_footer_html(){
    		
    		// Get footer vars
	        $footer_vars = $this->get_footer_vars('widgets');
	        extract($footer_vars);

    		echo "<div class='footer_top-area column_".(int)$widget_columns.$footer_class."'>";

    			//Render Mountain svg
    			$this->get_mountain_html();

                if (!$this->footer_full_width) { echo "<div class='wgl-container'>"; }

                $sidebar_exists = false;
                $i = 1;
	            while ($i < (int)$widget_columns + 1) {
					if (is_active_sidebar( 'footer_column_' . $i )) {
						$sidebar_exists = true;
					}
                    $i++;
                }
                if ($sidebar_exists) {
	                echo "<div class='row'".$footer_style.">";
	                	$i = 1;
	                	while ($i < (int)$widget_columns + 1) {
	                		$columns_number = $i - 1;
	                		?>
	                		<div class='wgl_col-<?php echo esc_attr($layout[$columns_number]);?>'>
	                			<?php
	                                if (is_active_sidebar( 'footer_column_' . $i)) dynamic_sidebar( 'footer_column_' . $i);
	                            ?>
	                        </div>
	                        <?php
	                		$i++;
	                	}
	                echo "</div>";
                }

				if (!$this->footer_full_width) { echo "</div>"; }
				
			echo "</div>";
			
    	}

    	private function main_footer_get_page(){
    		// Get options
    		$footer_vars = $this->get_footer_vars('page');
	        extract($footer_vars);

	        echo "<div class='footer_top-area'>";
	        	
	        	//Render Mountain svg
	        	$this->get_mountain_html();

                if (!$this->footer_full_width) { echo "<div class='wgl-container'>";}
                echo "<div class='row-footer'".$footer_style.">";
                    
                    $footer_page_select = Seofy_Theme_Helper::options_compare('footer_page_select','mb_footer_switch','on');

                    if (!empty($footer_page_select)) {
                    	$footer_page_select_id = intval($footer_page_select);

                    	$page_data = get_page($footer_page_select_id);

						if (!empty($page_data) && isset($page_data->post_status) && strcmp($page_data->post_status,'publish')===0) {

							$content = $page_data->post_content;
						    $array = array (
						        '<p>[' => '[',
						        ']</p>' => ']',
						        ']<br />' => ']'
						    );

						    $content = strtr($content, $array);
						    echo do_shortcode($content);

						}
					}
					
                echo "</div>";
				if (!$this->footer_full_width) { echo "</div>"; }
				
			echo "</div>";
    	}

    	private function copyright_spacing(){
	        //Get options
    		$copyright_spacing = Seofy_Theme_Helper::options_compare('copyright_spacing','mb_copyright_switch','on');
 
	        // copyright style
	        $style = '';
	        $style .= !empty($copyright_spacing['padding-top']) ? 'padding-top:'.(int)$copyright_spacing['padding-top'].'px;' : '' ;
	        $style .= !empty($copyright_spacing['padding-bottom']) ? 'padding-bottom:'.(int)$copyright_spacing['padding-bottom'].'px;' : '' ;
	        $style = !empty($style) ? ' style="'.$style.'"' : '';
	        return $style;
    	}

    	private function copyright_style(){
			$bg_color = Seofy_Theme_Helper::options_compare('copyright_bg_color','mb_copyright_switch','on');

			// copyright style
	        $style = '';
	        $style .= !empty($bg_color) ? 'background-color:'.esc_attr($bg_color).';' : '';
	        $style = !empty($style) ? ' style="'.$style.'"' : '';
	        return $style;
    	}

    	private function copyright_html() {	
	        $editor = Seofy_Theme_Helper::get_option('copyright_editor');

	        if ($this->mb_copyright_switch == 'on') {
	        	$editor = rwmb_meta('mb_copyright_editor');
	        }
	        ?>
    		<div class='copyright'<?php echo Seofy_Theme_Helper::render_html($this->copyright_style()); ?> >
                <?php if (!$this->footer_full_width) echo "<div class='wgl-container'>"; ?>
                	<div class='row' <?php echo Seofy_Theme_Helper::render_html($this->copyright_spacing());?> >
                       <div class='wgl_col-12'>
                       <?php echo do_shortcode( $editor ); ?>
                       </div>
                	</div>
                <?php if (!$this->footer_full_width) echo "</div>"; ?>
            </div>
            <?php
    	}
    }

    new Seofy_footer_area();
}