<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }
/**
* Page Title area
*
*
* @class 		Seofy_get_page_title
* @version		1.0
* @category	Class
* @author 		WebGeniusLab
*/

if (!class_exists('Seofy_get_page_title')) {
	class Seofy_get_page_title{

		private static $instance = null;
		public static function get_instance( ) {
			if ( null == self::$instance ) {
				self::$instance = new self( );
			}

			return self::$instance;
		}

	    public function __construct() {
	    	$this->init();
	    }

	    private $page_title_switch;
	    private $mb_page_title_switch;
	    private $heading_page_title;
	    protected $id;
 
		public function init(){	
			$this->id = get_queried_object_id();
			$this->page_title_switch = Seofy_Theme_Helper::get_option('page_title_switch') == '1' || Seofy_Theme_Helper::get_option('page_title_switch') == true ? 'on' : 'off';
			if (class_exists( 'RWMB_Loader' ) && $this->id !== 0) {
				$this->mb_page_title_switch = rwmb_meta('mb_page_title_switch');
			}
	        
	        /**
			* If single type 3 page title off
			*
			*
			* @since 1.0
			* @access private
			*/			
			$this->check_single_type();
	        
	        /**
			* Generate html header rendered
			*
			*
			* @since 1.0
			* @access public
			*/
	        $this->page_title_render_html();
	   	}

	   	private function check_single_type(){
	   		if(get_post_type(get_queried_object_id()) == 'post' && is_single()){
				$single_type = Seofy_Theme_Helper::get_option('single_type_layout');
				if (class_exists( 'RWMB_Loader' )) {
					$mb_type = rwmb_meta('mb_post_layout_conditional');
					if(!empty($mb_type) && $mb_type != 'default' ){
						$single_type = rwmb_meta('mb_single_type_layout');
					}
				}
				if($single_type === '3'){
					$this->page_title_switch = 'off';
				}	   			
	   		}
	   	}

	   	public function page_title_render_html(){

			$page_title_font = Seofy_Theme_Helper::options_compare('page_title_font', 'mb_page_title_switch', 'on');
			$page_title_breadcrumbs_font = Seofy_Theme_Helper::options_compare('page_title_breadcrumbs_font', 'mb_page_title_switch', 'on');
			$page_title_breadcrumbs_switch = Seofy_Theme_Helper::options_compare('page_title_breadcrumbs_switch', 'mb_page_title_switch', 'on');
			$page_title_parallax = Seofy_Theme_Helper::options_compare('page_title_parallax', 'mb_page_title_switch', 'on');
			$page_title_parallax_speed = Seofy_Theme_Helper::options_compare('page_title_parallax_speed', 'mb_page_title_switch', 'on');
			$page_title_extended_anim = Seofy_Theme_Helper::options_compare('page_title_extended_anim', 'mb_page_title_switch', 'on');
			$page_title_extended_color_1 = Seofy_Theme_Helper::options_compare('page_title_extended_color_1', 'mb_page_title_switch', 'on');
			$page_title_extended_color_2 = Seofy_Theme_Helper::options_compare('page_title_extended_color_2', 'mb_page_title_switch', 'on');
			$page_title_extended_color_3 = Seofy_Theme_Helper::options_compare('page_title_extended_color_3', 'mb_page_title_switch', 'on');

			if ($this->mb_page_title_switch == 'on') {
				$this->page_title_switch = 'on'; 
			}elseif($this->mb_page_title_switch == 'off'){
				$this->page_title_switch = 'off';
			}

			// Title styles
			$page_title_font_color = !empty($page_title_font['color']) ? 'color:'.$page_title_font['color'].';' : '';
			$page_title_font_size = !empty($page_title_font['font-size']) ? ' font-size:'.(int)$page_title_font['font-size'].'px;' : '';
			$page_title_font_height = !empty($page_title_font['line-height']) ? ' line-height:'.(int)$page_title_font['line-height'].'px;' : '';
			$title_style = 'style="'.$page_title_font_color.$page_title_font_size.$page_title_font_height.'"';

			// Breadcrumbs Styles
			$page_title_breadcrumbs_font_color = !empty($page_title_breadcrumbs_font['color']) ? 'color:'.$page_title_breadcrumbs_font['color'].';' : '';
			$page_title_breadcrumbs_font_size = !empty($page_title_breadcrumbs_font['font-size']) ? ' font-size:'.(int)$page_title_breadcrumbs_font['font-size'].'px;' : '';
			$page_title_breadcrumbs_font_height = !empty($page_title_breadcrumbs_font['line-height']) ? ' line-height:'.(int)$page_title_breadcrumbs_font['line-height'].'px;' : '';
			$breadcrumbs_style = 'style="'.$page_title_breadcrumbs_font_color.$page_title_breadcrumbs_font_size.$page_title_breadcrumbs_font_height.'"';

			// Extended Animation
			$extended_anim = '';
			if ((bool)$page_title_extended_anim) {
				wp_enqueue_script('particles', get_template_directory_uri() . '/js/particles.min.js', array('jquery'), false, true);
				$color_1 = !empty($page_title_extended_color_1) ? esc_attr($page_title_extended_color_1) : '#ff7e00';
				$color_2 = !empty($page_title_extended_color_2) ? esc_attr($page_title_extended_color_2) : '#3224e9';
				$color_3 = !empty($page_title_extended_color_3) ? esc_attr($page_title_extended_color_3) : '#69e9f2';
				$extended_anim_data = 'data-particles-color="'.$color_1.','.$color_2.','.$color_3.'"';
				$extended_anim .= '<div id="page-title-particles-js" class="particles-js" data-particles-type="hexagons" data-particles-number="30" data-particles-line="false" data-particles-size="5" data-particles-speed="2" data-particles-hover="false" data-particles-hover-mode="bubble" data-particles-colors-type="random_colors" '.$extended_anim_data.'></div>';
			}

			$seofy_page_title = $this->seofy_page_title();

			if(is_home() || is_front_page()){
				$this->page_title_switch = 'off';
			}

	        if ($this->page_title_switch == 'on') {
				
				if ((bool)$page_title_parallax) {
					wp_enqueue_script('parallax', get_template_directory_uri() . '/js/jquery.paroller.min.js', array(), false, false);
				}
	
				$page_title_parallax_class = (bool)$page_title_parallax ? ' page_title_parallax' : '';
				$page_title_parallax_data_speed = !empty($page_title_parallax_speed) ? $page_title_parallax_speed : '0.3';
				$page_title_parallax_data = (!empty($page_title_parallax_data_speed) && (bool)$page_title_parallax) ? 'data-paroller-factor='.$page_title_parallax_data_speed : '';	

				ob_start();
					get_template_part('templates/breadcrumbs');
				$breadcrumbs_part = ob_get_clean();

	        	$classes = $this->page_title_classes();
	        	$styles = $this->page_title_styles();
	            $output = "<div class='page-header ". (!empty($classes) ? esc_attr($classes) : '' ) . $page_title_parallax_class . "'".( !empty($styles) ? ' style="'.esc_attr($styles).'"' : '')." ".$page_title_parallax_data.">";
	                $output .= "<div class='page-header_wrapper'>";
	                    $output .= "<div class='wgl-container'>";
	                        $output .= "<div class='page-header_content'>";
	                            if(!empty($seofy_page_title)){
	                            	$tag = !empty($this->heading_page_title) ? $this->heading_page_title : 'div';
								    $output .= sprintf( "<%s class='page-header_title' %s>%s</%s>",
							            $tag,
							            $title_style,
							            Seofy_Theme_Helper::render_html($seofy_page_title),
							            $tag
							        );
	                            }
	                            if ((bool)$page_title_breadcrumbs_switch) {
	                                $output .= "<div class='page-header_breadcrumbs' ".$breadcrumbs_style.">";
	                                    $output .= $breadcrumbs_part;
	                                $output .= "</div>";
	                            }
	                        $output .= "</div>";  
	                    $output .= "</div>";                  
					$output .= "</div>";
					$output .= $extended_anim;
				$output .= "</div>";
				
				echo Seofy_Theme_Helper::render_html($output);

	        }	
	   	}

	    public function seofy_page_title(){
	        $title = '';
	        if (is_home() || is_front_page()) {
	            $title = '';
	        }elseif (is_category()) {
	            $title = single_cat_title('', false);
	        }elseif (is_tag()) {
	            $title = single_term_title("", false).esc_html__(' Tag', 'seofy');
	        }elseif (is_date()) {
	            $title = get_the_time('F Y');
	        }elseif(is_author()){
	            $title = esc_html__('Author:', 'seofy') . " " . get_the_author();
	        }elseif (is_search()) {
	            $title = esc_html__('Search', 'seofy');
	        }elseif (is_404()) {
	            $title = esc_html__('Error Page', 'seofy');
	        }elseif (is_archive()) { 	
				if(function_exists('is_shop') && ( is_shop() || is_product_category() || is_product_tag() ) ){
					$title = esc_html__('Shop', 'seofy');
	            }else{
					$title = esc_html__('Archive','seofy');
	            }
	        }elseif (is_singular( 'portfolio' )) {

				$portfolio_title_conditional = Seofy_Theme_Helper::get_option('portfolio_title_conditional') == '1' ? 'on' : 'off';
	            $portfolio_title_text = !empty(Seofy_Theme_Helper::get_option('portfolio_single_page_title_text')) ? Seofy_Theme_Helper::get_option('portfolio_single_page_title_text') : '';

				$title = $portfolio_title_conditional == 'on' ? esc_html($portfolio_title_text) : esc_html(get_the_title());
				$title = apply_filters('seofy_page_title_portfolio_text', $title);
				
	        }elseif (is_singular( 'team' )) {
				
				$team_title_conditional = Seofy_Theme_Helper::get_option('team_title_conditional') == '1' ? 'on' : 'off';
	            $team_title_text = !empty(Seofy_Theme_Helper::get_option('team_single_page_title_text')) ? Seofy_Theme_Helper::get_option('team_single_page_title_text') : '';

				$title = $team_title_conditional == 'on' ? esc_html($team_title_text) : esc_html(get_the_title());
				$title = apply_filters('seofy_page_title_team_text', $title);

	        }
	        elseif ( function_exists('is_product') && ( is_product() ) ) {
	        	$shop_title_conditional = Seofy_Theme_Helper::get_option('shop_title_conditional') == '1' ? 'on' : 'off';
	            $shop_title_text = !empty(Seofy_Theme_Helper::get_option('shop_single_page_title_text')) ? Seofy_Theme_Helper::get_option('shop_single_page_title_text') : '';

				$title = $shop_title_conditional == 'on' ? esc_html($shop_title_text) : esc_html(get_the_title());
				$title = apply_filters('seofy_page_title_shop_text', $title);
	        }
	        else{
	            global $post;
	            
	            if (!empty($post)) {
	                $id = $post->ID;
	                $posttype = get_post_type($post );
	                $blog_title_conditional = Seofy_Theme_Helper::get_option('blog_title_conditional') == '1' ? 'on' : 'off';
	                $blog_title_text = !empty(Seofy_Theme_Helper::get_option('post_single_page_title_text')) ? Seofy_Theme_Helper::get_option('post_single_page_title_text') : '';
	                
	                if($posttype == 'post'){
						$title = $blog_title_conditional == 'on' ? esc_html($blog_title_text) : esc_html(get_the_title($id));
						$title = apply_filters('seofy_page_title_blog_text', $title);
	                }else{     
	                	$this->heading_page_title = 'h1'; 
	                    $title = esc_html(get_the_title($id));                    
	                }

	            }else{
	                $title = esc_html__('No Posts','seofy');
	            }
	            
	        } 
	        if ($this->mb_page_title_switch == 'on') {
	        	$custom_title_switch = rwmb_meta('mb_page_change_tile_switch'); 
	        	
	        	if(!empty($custom_title_switch)){
	        		$custom_title = rwmb_meta('mb_page_change_tile'); 
	        		$title = !empty($custom_title) ? esc_html($custom_title) : '';
	        		$title = apply_filters('seofy_page_title_custom_text', $title);
	        	}
	        }
	        
	        return $title;
	    }
	    
	   	public function page_title_classes(){

			$page_title_align = Seofy_Theme_Helper::options_compare('page_title_align', 'mb_page_title_switch', 'on');

	        $page_title_classes = !empty($page_title_align) ? ' page-header_align_'.esc_attr($page_title_align) : ' page-header_align_left';
	        
	        return $page_title_classes;		
	   	}

	   	public function page_title_styles(){
			$style = '';
			   
			$page_title_padding = Seofy_Theme_Helper::options_compare('page_title_padding', 'mb_page_title_switch', 'on');
			$page_title_margin = Seofy_Theme_Helper::options_compare('page_title_margin', 'mb_page_title_switch', 'on');

	        if ($this->page_title_switch == 'on') {
	            $page_title_bg_color = Seofy_Theme_Helper::get_option('page_title_bg_color');
	            $page_title_height = Seofy_Theme_Helper::get_option('page_title_height');
	            $page_title_height = $page_title_height['height'];
	        }

	        if ($this->mb_page_title_switch == 'on') {
	        	$this->page_title_switch = 'on';
	        	$page_title_bg_color = isset(rwmb_meta('mb_page_title_bg')['color']) ? rwmb_meta('mb_page_title_bg')['color'] : '';
	        	$page_title_height = rwmb_meta('mb_page_title_height');
	        }elseif($this->mb_page_title_switch == 'off'){
	        	$this->page_title_switch = 'off';
			}

	        //Shop Page
	        $shop_title = '';
	        switch (true) {
	        	case function_exists('is_shop') &&  ( is_shop() ):
	        		$shop_title = 'catalog';
	        		break;	        	
	        	case function_exists('is_product') && ( is_product() ):
	        		$shop_title = 'single';
	        		break;	        	
	        	case function_exists('is_cart') &&  ( is_cart() ):
	        		$shop_title = 'cart';
	        		break;	        	
	        	case function_exists('is_checkout') &&  ( is_checkout() ):
	        		$shop_title = 'checkout';
	        		break;
	        	default:
	        		$shop_title = '';
	        		break;
	        }

	        //Portfolio and Team Page Title
	        $cpt_title = $cpt_type_title = '';
	        
	        if(get_post_type(get_queried_object_id()) == 'portfolio'){
	        	$cpt_type_title = 'portfolio';
	        	$cpt_title = is_single() ? 'single' : 'archive';        	
	        }elseif(get_post_type(get_queried_object_id()) == 'team'){
	        	$cpt_type_title = 'team';
	        	$cpt_title = is_single() ? 'single' : 'archive';	
	        }elseif(get_post_type(get_queried_object_id()) == 'post'){
	        	$cpt_type_title = 'post';
	        	$cpt_title = is_single() ? 'single' : 'archive';	
	        }

	        if (is_404() && !empty(Seofy_Theme_Helper::bg_render('404_page_title'))){
	        	$style .= Seofy_Theme_Helper::bg_render('404_page_title');
	        } elseif((bool) $shop_title && !empty(Seofy_Theme_Helper::bg_render('shop_'.$shop_title.'_page_title')) ){
	        	$style .= Seofy_Theme_Helper::bg_render('shop_'.$shop_title.'_page_title');
	        } elseif((bool) $cpt_title && !empty(Seofy_Theme_Helper::bg_render($cpt_type_title.'_'.$cpt_title.'_page_title')) ){
	        	$style .= Seofy_Theme_Helper::bg_render($cpt_type_title.'_'.$cpt_title.'_page_title');
	        }else{
	        	$style .= Seofy_Theme_Helper::bg_render('page_title','mb_page_title_switch','on');
	        }

	        $style .= !empty($page_title_bg_color) ? 'background-color:'.esc_attr($page_title_bg_color).';' : '';
	        $style .= !empty($page_title_height) ? ' height:'.(int)$page_title_height.'px;' : '';       
	        $style .= !empty($page_title_margin['margin-bottom'] || $page_title_margin['margin-bottom'] == '0') ? ' margin-bottom:'.(int)$page_title_margin['margin-bottom'].'px;' : '';
	        $style .= !empty($page_title_padding['padding-top'] || $page_title_padding['padding-top'] == '0') ?  ' padding-top:'.(int)$page_title_padding['padding-top'].'px;' : '';
			$style .= !empty($page_title_padding['padding-bottom'] || $page_title_padding['padding-bottom'] == '0') ?  ' padding-bottom:'.(int)$page_title_padding['padding-bottom'].'px;' : '';
	        
	        return $style;		
	   	}
	
	}

    new Seofy_get_page_title();
}
