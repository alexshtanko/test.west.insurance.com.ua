<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }
/**
* Seofy Dynamic Styles
*
*
* @class        Seofy_dynamic_styles
* @version      1.0
* @category Class
* @author       WebGeniusLab
*/

class Seofy_dynamic_styles{

	public $settings;
	protected static $instance = null;
	private $gtdu;
	private $use_minify;

	public static function instance() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}
		return self::$instance;
	}  

	public function register_script(){
		$this->gtdu = get_template_directory_uri();
		$this->use_minify = Seofy_Theme_Helper::get_option('use_minify') ? '.min' : '';
		// Register action
		add_action('wp_enqueue_scripts', array($this,'css_reg') );
		add_action('wp_enqueue_scripts', array($this,'rtl_css_reg') );
		add_action('wp_enqueue_scripts', array($this,'js_reg') );
		// Register action for Admin
		add_action('admin_enqueue_scripts', array($this,'admin_css_reg') );
		add_action('admin_enqueue_scripts', array($this, 'admin_js_reg') );
	}

	/* Register CSS */
	public function css_reg(){
	    /* Register CSS */
	    wp_enqueue_style('seofy-default-style', get_bloginfo('stylesheet_url'), array(), '5.10.13');
	    // Flaticon register
	    wp_enqueue_style('flaticon', $this->gtdu . '/fonts/flaticon/flaticon.css');
	    // Font-Awesome
		wp_enqueue_style('font-awesome', $this->gtdu . '/css/font-awesome.min.css');
		// wp_enqueue_style('seofy-main', $this->gtdu . '/css/main'.$this->use_minify.'.css', array(), filemtime(get_template_directory() . '/css/main.css'));
		wp_enqueue_style('seofy-main', $this->gtdu . '/css/main'.$this->use_minify.'.css', array(), '5.10.16');
	}
	/* Register JS */
	public function js_reg(){

		wp_enqueue_script('seofy-theme-addons', $this->gtdu . '/js/theme-addons'.$this->use_minify.'.js', array('jquery'), false, true);
		wp_enqueue_script('seofy-theme', $this->gtdu . '/js/theme.js', array('jquery'), false, true);

	    wp_localize_script( 'seofy-theme', 'wgl_core', array(
	        'ajaxurl' => admin_url( 'admin-ajax.php' ),
	        'slickSlider' => esc_url(get_template_directory_uri() . '/js/slick.min.js'),
	        'JarallaxPlugin' => esc_url(get_template_directory_uri() . '/js/jarallax-video.min.js'),
	        'JarallaxPluginVideo' => esc_url(get_template_directory_uri() . '/js/jarallax.min.js'),
	        'like' => esc_html__( 'Like', 'seofy' ),
	        'unlike' => esc_html__( 'Unlike', 'seofy' )
	        ) );

	   	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply' );
		}
	}

	/* Register css for admin panel */
	public function admin_css_reg(){
	 	// Font-awesome
		wp_enqueue_style('font-awesome', $this->gtdu . '/css/font-awesome.min.css');
		// Main admin styles
		wp_enqueue_style('seofy-admin', $this->gtdu . '/core/admin/css/admin.css');
		// Add standard wp color picker
		wp_enqueue_style('wp-color-picker');
		// Colorbox https://gist.github.com/tmcw/6793969
	    wp_enqueue_style('seofy-admin-colorbox', $this->gtdu . '/core/admin/css/colorbox.css');
	    // https://github.com/marcj/jquery-selectBox
		wp_enqueue_style('selectBox', $this->gtdu . '/core/admin/css/jquery.selectBox.css');
		wp_enqueue_style('seofy-vc-backend-style', $this->gtdu . '/core/admin/css/wgl-vc-backend.css');
	}

	/* Register css and js for admin panel */
	public function admin_js_reg(){
	    /* Register JS */
	    wp_enqueue_media();
	    wp_enqueue_script('wp-color-picker');
	    // Colorbox https://gist.github.com/tmcw/6793969
	    wp_enqueue_script('seofy-admin-colorbox', $this->gtdu . '/core/admin/js/jquery.colorbox-min.js', array(), false, true);
	    // Select-box https://github.com/marcj/jquery-selectBox
		wp_enqueue_script('selectBox', $this->gtdu . '/core/admin/js/jquery.selectBox.js');		
		//Admin Js
		wp_enqueue_script('admin', $this->gtdu . '/core/admin/js/admin.js');
		// If active Metabox IO
		if (class_exists( 'RWMB_Loader' )) {
			wp_enqueue_script('metaboxes', $this->gtdu . '/core/admin/js/metaboxes.js');
		}
	}

	/* Register css for rtl */
	public function rtl_css_reg(){
		$is_rtl = is_rtl();
		// Rtl css
		if ($is_rtl) {
		   	wp_enqueue_style('rtl-css', $this->gtdu . '/css/rtl.css');
		}
	}

	public function init_style() {
		add_action('wp_enqueue_scripts', array($this, 'add_style') );
	}

	public function minify_css($css = null){
		if(!$css){
			return;
		}
		$css = str_replace( ',{', '{', $css );
		$css = str_replace( ', ', ',', $css );
		$css = preg_replace( '!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $css );
		$css = str_replace( array("\r\n", "\r", "\n", "\t", '  ', '    ', '    '), '', $css );
		$css = trim( $css );

		return $css;
	}
	
	public function add_style() {
		$css = '';
		/*-----------------------------------------------------------------------------------*/
		/* Body Style
		/*-----------------------------------------------------------------------------------*/
		$page_colors_switch = Seofy_Theme_Helper::options_compare('page_colors_switch','mb_page_colors_switch','custom');
		$theme_color = Seofy_Theme_Helper::options_compare('theme-custom-color','mb_page_colors_switch','custom');
		$second_color = Seofy_Theme_Helper::options_compare('second-custom-color','mb_page_colors_switch','custom');
		$bg_body = Seofy_Theme_Helper::options_compare('body-background-color','mb_page_colors_switch','custom');
		
		// Go top color
		$scroll_up_bg_color = Seofy_Theme_Helper::options_compare('scroll_up_bg_color','mb_page_colors_switch','custom');
		$scroll_up_arrow_color = Seofy_Theme_Helper::options_compare('scroll_up_arrow_color','mb_page_colors_switch','custom');
		
		// Gradient colors
		$use_gradient_switch = Seofy_Theme_Helper::options_compare('use-gradient','mb_page_colors_switch','custom');
		if ($page_colors_switch == 'custom') {
			$theme_gradient_from = Seofy_Theme_Helper::options_compare('theme-gradient-from','mb_page_colors_switch','custom');
			$theme_gradient_to = Seofy_Theme_Helper::options_compare('theme-gradient-to','mb_page_colors_switch','custom');
			$second_gradient_from = Seofy_Theme_Helper::options_compare('second-gradient-from','mb_page_colors_switch','custom');
			$second_gradient_to = Seofy_Theme_Helper::options_compare('second-gradient-to','mb_page_colors_switch','custom');
		} else{
			$theme_gradient = Seofy_Theme_Helper::get_option('theme-gradient');
			$second_gradient = Seofy_Theme_Helper::get_option('second-gradient');
			$theme_gradient_from = $theme_gradient['from'];
			$theme_gradient_to = $theme_gradient['to'];
			$second_gradient_from = $second_gradient['from'];
			$second_gradient_to = $second_gradient['to'];
		}

		/*-----------------------------------------------------------------------------------*/
		/* \End Body style
		/*-----------------------------------------------------------------------------------*/

		/*-----------------------------------------------------------------------------------*/
		/* Body add Class
		/*-----------------------------------------------------------------------------------*/
		if ((bool)$use_gradient_switch) {
			add_filter( 'body_class', function( $classes ) {
				return array_merge( $classes, array( 'theme-gradient' ) );
			} );
		}
		/*-----------------------------------------------------------------------------------*/
		/* End Body add Class
		/*-----------------------------------------------------------------------------------*/

		/*-----------------------------------------------------------------------------------*/
		/* Header Typography
		/*-----------------------------------------------------------------------------------*/
		$header_font = Seofy_Theme_Helper::get_option('header-font');
		$header_font_secondary = Seofy_Theme_Helper::get_option('subtitle-font');
		$subtitle_family = $subtitle_weight = '';
		if(!empty($header_font_secondary)){
			$subtitle_family = esc_attr($header_font_secondary['font-family']);
		}

		$header_font_family = $header_font_weight = $header_font_color = '';
		if (!empty($header_font)) {
			$header_font_family = esc_attr($header_font['font-family']);
			$header_font_weight = esc_attr($header_font['font-weight']);
			$header_font_color = esc_attr($header_font['color']);
		}

		// Add Heading h1,h2,h3,h4,h5,h6 variables
		for ($i = 1; $i <= 6; $i++) {
		    ${'header-h'.$i} = Seofy_Theme_Helper::get_option('header-h'.$i);
			${'header-h'.$i.'_family'} = ${'header-h'.$i.'_weight'} = ${'header-h'.$i.'_line_height'} = ${'header-h'.$i.'_size'} = ${'header-h'.$i.'_text_transform'} = '';
			
			if (!empty(${'header-h'.$i})) {
				${'header-h'.$i.'_family'} = !empty(${'header-h'.$i}["font-family"]) ? esc_attr(${'header-h'.$i}["font-family"]) : '';
				${'header-h'.$i.'_weight'} = !empty(${'header-h'.$i}["font-weight"]) ? esc_attr(${'header-h'.$i}["font-weight"]) : '';
				${'header-h'.$i.'_line_height'} = !empty(${'header-h'.$i}["line-height"]) ? esc_attr(${'header-h'.$i}["line-height"]) : '';
				${'header-h'.$i.'_size'} = !empty(${'header-h'.$i}["font-size"]) ? esc_attr(${'header-h'.$i}["font-size"]) : '';
				${'header-h'.$i.'_text_transform'} = !empty(${'header-h'.$i}["text-transform"]) ? esc_attr(${'header-h'.$i}["text-transform"]) : '';
			}
		}

		/*-----------------------------------------------------------------------------------*/
		/* \End Header Typography
		/*-----------------------------------------------------------------------------------*/

		/*-----------------------------------------------------------------------------------*/
		/* Body Typography
		/*-----------------------------------------------------------------------------------*/
		$main_font = Seofy_Theme_Helper::get_option('main-font');
		$content_font_family = $content_line_height = $content_font_size = $content_font_weight = $content_color = '';
		if (!empty($main_font)) {
			$content_font_family = esc_attr($main_font['font-family']);
			$content_line_height = esc_attr($main_font['line-height']);
			$content_font_size = esc_attr($main_font['font-size']);
			$content_font_weight = esc_attr($main_font['font-weight']);
			$content_color = esc_attr($main_font['color']);
		}

		/*-----------------------------------------------------------------------------------*/
		/* \End Body Typography
		/*-----------------------------------------------------------------------------------*/

		/*-----------------------------------------------------------------------------------*/
		/* Menu, Sub-menu Typography
		/*-----------------------------------------------------------------------------------*/
		$menu_font = Seofy_Theme_Helper::get_option('menu-font');
		$menu_font_family = $menu_font_weight = $menu_font_line_height = $menu_font_size = '';
		if (!empty($menu_font)) {
			$menu_font_family = !empty($menu_font['font-family']) ? esc_attr($menu_font['font-family']) : '';
			$menu_font_weight = !empty($menu_font['font-weight']) ? esc_attr($menu_font['font-weight']) : '';
			$menu_font_line_height = !empty($menu_font['line-height']) ? esc_attr($menu_font['line-height']) : '';
			$menu_font_size = !empty($menu_font['font-size']) ? esc_attr($menu_font['font-size']) : '';
		}

		$sub_menu_font = Seofy_Theme_Helper::get_option('sub-menu-font');
		$sub_menu_font_family = $sub_menu_font_weight = $sub_menu_font_line_height = $sub_menu_font_size = '';
		if (!empty($sub_menu_font)) {
			$sub_menu_font_family = !empty($sub_menu_font['font-family']) ? esc_attr($sub_menu_font['font-family']) : '';
			$sub_menu_font_weight = !empty($sub_menu_font['font-weight']) ? esc_attr($sub_menu_font['font-weight']) : '';
			$sub_menu_font_line_height = !empty($sub_menu_font['line-height']) ? esc_attr($sub_menu_font['line-height']) : '';
			$sub_menu_font_size = !empty($sub_menu_font['font-size']) ? esc_attr($sub_menu_font['font-size']) : '';
		}
		/*-----------------------------------------------------------------------------------*/
		/* \End Menu, Sub-menu Typography
		/*-----------------------------------------------------------------------------------*/
		
		$name_preset = Seofy_Theme_Helper::header_preset_name();
		$get_def_name = get_option( 'seofy_preset' );
		$def_preset = false;
		if(isset($get_def_name['default']) && $name_preset){
			if(array_key_exists($name_preset, $get_def_name['default']) && !array_key_exists($name_preset, $get_def_name)){
				$def_preset = true;
			}	
		}

		$menu_color_top = Seofy_Theme_Helper::get_option('header_top_color', $name_preset, $def_preset);
		if (!empty($menu_color_top['rgba'])) {
	        $menu_color_top = !empty($menu_color_top['rgba']) ? esc_attr($menu_color_top['rgba']) : '';
	    }

		$menu_color_middle = Seofy_Theme_Helper::get_option('header_middle_color', $name_preset, $def_preset);
		if(!empty($menu_color_middle['rgba'])){
			$menu_color_middle = !empty($menu_color_middle['rgba']) ? esc_attr($menu_color_middle['rgba']) : '';
		}

		$menu_color_bottom = Seofy_Theme_Helper::get_option('header_bottom_color', $name_preset, $def_preset);
		if(!empty($menu_color_bottom['rgba'])){
			$menu_color_bottom = !empty($menu_color_bottom['rgba']) ? esc_attr($menu_color_bottom['rgba']) : '';
		}

		// Set Queris width to apply mobile style
	    $sub_menu_color = Seofy_Theme_Helper::get_option('sub_menu_color' ,$name_preset, $def_preset);
	    $sub_menu_bg = Seofy_Theme_Helper::get_option('sub_menu_background' ,$name_preset, $def_preset);
	    $sub_menu_bg = $sub_menu_bg['rgba'];


		$mobile_sub_menu_bg = Seofy_Theme_Helper::get_option('mobile_sub_menu_background');
		$mobile_sub_menu_bg = $mobile_sub_menu_bg['rgba'];
		$mobile_sub_menu_color = Seofy_Theme_Helper::get_option('mobile_sub_menu_color');

		$hex_header_font_color = Seofy_Theme_Helper::HexToRGB($header_font_color);
		$hex_theme_color =  Seofy_Theme_Helper::HexToRGB($theme_color);

		//sticky header logo 
	    $header_sticky_height = Seofy_Theme_Helper::get_option('header_sticky_height');
	    $header_sticky_height = (int)$header_sticky_height['height'].'px';
	    //sticky header color
	    $header_sticky_color = Seofy_Theme_Helper::get_option('header_sticky_color');

	    $footer_text_color = Seofy_Theme_Helper::get_option('footer_text_color');
	    $footer_heading_color = Seofy_Theme_Helper::get_option('footer_heading_color');

	    $copyright_text_color = Seofy_Theme_Helper::options_compare('copyright_text_color','mb_copyright_switch','on');

		//Page Title Background Color
		$page_title_bg_color = Seofy_Theme_Helper::get_option('page_title_bg_color');
		$hex_page_title_bg_color = Seofy_Theme_Helper::HexToRGB($page_title_bg_color);
		/*-----------------------------------------------------------------------------------*/
		/* Parse css
		/*-----------------------------------------------------------------------------------*/
		global $wp_filesystem;
		if( empty( $wp_filesystem ) ) {
			require_once( ABSPATH .'/wp-admin/includes/file.php' );
			WP_Filesystem();
		}

		$files = array('theme_content', 'theme_color', 'footer');
		if(class_exists( 'WooCommerce' )){
			array_push($files, 'shop');
		}
		foreach ($files as $key => $file) {
			$file = get_template_directory() . '/core/admin/css/dynamic/'.$file.'.css';
			if ( $wp_filesystem->exists($file) ) {
				$file = $wp_filesystem->get_contents( $file );
				preg_match_all('/\s*\\$([A-Za-z1-9_\-]+)(\s*:\s*(.*?);)?\s*/', $file, $vars); 

				$found     = $vars[0];
				$varNames  = $vars[1];
				$count     = count($found);    

				for($i = 0; $i < $count; $i++) {
					$varName  = trim($varNames[$i]);   
					$file = preg_replace('/\\$'.$varName.'(\W|\z)/', (isset(${$varName}) ? ${$varName} : "").'\\1', $file);
				}
				
				$line = str_replace($found, '', $file);

				$css .= $line;
			}
		}
		/*-----------------------------------------------------------------------------------*/
		/* \End Parse css
		/*-----------------------------------------------------------------------------------*/
		
		$css .= 'body {'
			.(!empty($bg_body) ? 'background:'.$bg_body.';' : '').'
		}
		ol.commentlist:after {
			'.(!empty($bg_body) ? 'background:'.$bg_body.';' : '').'
		}';
		
		/*-----------------------------------------------------------------------------------*/
		/* Typography render
		/*-----------------------------------------------------------------------------------*/
		for ($i = 1; $i <= 6; $i++) {
			$css .= 'h'.$i.',h'.$i.' a, h'.$i.' span { 
				'.(!empty(${'header-h'.$i.'_family'}) ? 'font-family:'.${'header-h'.$i.'_family'}.';' : '' ).'
				'.(!empty(${'header-h'.$i.'_weight'}) ? 'font-weight:'.${'header-h'.$i.'_weight'}.';' : '' ).'
				'.(!empty(${'header-h'.$i.'_size'}) ? 'font-size:'.${'header-h'.$i.'_size'}.';' : '' ).'
				'.(!empty(${'header-h'.$i.'_line_height'}) ? 'line-height:'.${'header-h'.$i.'_line_height'}.';' : '' ).'
				'.(!empty(${'header-h'.$i.'_text_transform'}) ? 'text-transform:'.${'header-h'.$i.'_text_transform'}.';' : '' ).'
			}';
		}	
		/*-----------------------------------------------------------------------------------*/
		/* \End Typography render
		/*-----------------------------------------------------------------------------------*/	

		/*-----------------------------------------------------------------------------------*/
		/* Mobile Header render
		/*-----------------------------------------------------------------------------------*/    
	    $mobile_header = Seofy_Theme_Helper::get_option('mobile_header');

	    // Fetch header height to apply it for mobile styles
		$header_mobile_height = Seofy_Theme_Helper::get_option('header_mobile_height');
		$header_mobile_min_height = !empty($header_mobile_height['height']) ? 'calc(100vh - '.esc_attr((int)$header_mobile_height['height']).'px - 30px)' : '';		
		$header_mobile_height = !empty($header_mobile_height['height']) ? 'calc(100vh - '.esc_attr((int)$header_mobile_height['height']).'px)' : '';

		// Set Queries width to apply mobile style
	    $header_queries = Seofy_Theme_Helper::get_option('header_mobile_queris', $name_preset, $def_preset);


	    if ($mobile_header == '1') {
	    	$mobile_background = Seofy_Theme_Helper::get_option('mobile_background');
	    	$mobile_color = Seofy_Theme_Helper::get_option('mobile_color');

	    	$css .= '@media only screen and (max-width: '.(int)$header_queries.'px){
				.wgl-theme-header{
			    	background-color: '.esc_attr($mobile_background['rgba']).' !important;
			    	color: '.esc_attr($mobile_color).' !important;
			    }
			    .hamburger-inner, .hamburger-inner:before, .hamburger-inner:after{
		    		background-color:'.esc_attr($mobile_color).';
		    	}
			}';
	    } 
	    
	    $css .= '@media only screen and (max-width: '.(int)$header_queries.'px){
			.wgl-theme-header .wgl-mobile-header{
				display: block;
			}		
			.wgl-site-header{
				display:none;
			}
			.wgl-theme-header .mobile-hamburger-toggle{
				display: inline-block;
			}
			.wgl-theme-header .primary-nav{
				display:none;
			}
			header.wgl-theme-header .mobile_nav_wrapper .primary-nav{
				display:block;
			}
			.wgl-theme-header .wgl-sticky-header{
				display: none;
			}
			.wgl-theme-header.header_overlap{
				position: relative;
				z-index: 2;
			}
			body.mobile_switch_on .wgl-menu_outer {
			    height: '.$header_mobile_height.';
			}
			.mobile_nav_wrapper .primary-nav{
				min-height: '.$header_mobile_min_height.';
			}
		}';
		/*-----------------------------------------------------------------------------------*/
		/* \End Mobile Header render
		/*-----------------------------------------------------------------------------------*/

		/*-----------------------------------------------------------------------------------*/
		/* Footer page css
		/*-----------------------------------------------------------------------------------*/
		$footer_switch = Seofy_Theme_Helper::get_option('footer_switch');
		if ($footer_switch) {
			$footer_content_type = Seofy_Theme_Helper::get_option('footer_content_type');
			if (class_exists( 'RWMB_Loader' ) && get_queried_object_id() !== 0) {
				$mb_footer_switch = rwmb_meta('mb_footer_switch');
				if ($mb_footer_switch == 'on') {
					$footer_content_type = rwmb_meta('mb_footer_content_type');
				}
			}

			if($footer_content_type == 'pages'){
				$footer_page_id = Seofy_Theme_Helper::options_compare('footer_page_select');
				if ( $footer_page_id ) {
					$footer_page_id = intval($footer_page_id);
					$shortcodes_css = get_post_meta( $footer_page_id, '_wpb_shortcodes_custom_css', true );
					if ( ! empty( $shortcodes_css ) ) {
						$shortcodes_css = strip_tags( $shortcodes_css );
						$css .= $shortcodes_css;
					}
				}
			}		
		}
		/*-----------------------------------------------------------------------------------*/
		/* \End Footer page css
		/*-----------------------------------------------------------------------------------*/

		/*-----------------------------------------------------------------------------------*/
		/* Gradient css
		/*-----------------------------------------------------------------------------------*/
		$gradient_class = (bool)$use_gradient_switch ? '.theme-gradient ' : '';

		// Theme Gradient colors
		$css .= '
		.example,
		.woocommerce .widget_price_filter .ui-slider .ui-slider-range{';
			if ( (bool)$use_gradient_switch ) {
				$css .= '
				background: '.$theme_gradient_from.';
				background: -moz-linear-gradient(-30deg, '.$theme_gradient_from.' 0%, '.$theme_gradient_to.' 100%);
				background: -webkit-gradient(left top, right bottom, color-stop(0%, '.$theme_gradient_from.'), color-stop(100%, '.$theme_gradient_to.'));
				background: -webkit-linear-gradient(-30deg, '.$theme_gradient_from.' 0%, '.$theme_gradient_to.' 100%);
				background: -o-linear-gradient(-30deg, '.$theme_gradient_from.' 0%, '.$theme_gradient_to.' 100%);
				background: -ms-linear-gradient(-30deg, '.$theme_gradient_from.' 0%, '.$theme_gradient_to.' 100%);
				background: linear-gradient(120deg, '.$theme_gradient_from.' 0%, '.$theme_gradient_to.' 100%);';
			} else {
				$css .= 'background-color: '.$theme_color.';';
			}
		$css .= '}';

		$css .= '
		'.$gradient_class.'#scroll_up,
		'.$gradient_class.'button,
		'.$gradient_class.'.widget.seofy_widget.seofy_banner-widget .banner-widget_button,
		'.$gradient_class.'.load_more_item,
		'.$gradient_class.'input[type="submit"],
		'.$gradient_class.'.rev_slider .rev-btn.gradient-button,
		'.$gradient_class.'.seofy_module_demo_item .di_button a,
		.page_404_wrapper .seofy_404_button.wgl_button .wgl_button_link {';
		if ( (bool)$use_gradient_switch ) {
			$css .= '
			background: -webkit-linear-gradient(left, '.$theme_gradient_from.' 0%, '.$theme_gradient_to.' 50%, '.$theme_gradient_from.' 100%);
			background-size: 300%, 1px;
			background-position: 0%;';
		} else {
			$css .= 'background-color:'.$theme_color.';';
		}
		$css .= '}';

		//Shop Gradient

		$css .= '
		'.$gradient_class.'ul.wgl-products li a.add_to_cart_button, 
		'.$gradient_class.'ul.wgl-products li a.button,	
		'.$gradient_class.'div.product form.cart .button,	
		'.$gradient_class.'.widget_shopping_cart .buttons a,	
		'.$gradient_class.'ul.wgl-products li .added_to_cart.wc-forward,
		'.$gradient_class.'#payment #place_order,
		'.$gradient_class.'#payment #place_order:hover,
		'.$gradient_class.'#add_payment_method .wc-proceed-to-checkout a.checkout-button,
		'.$gradient_class.'table.shop_table.cart input.button,
		'.$gradient_class.'.checkout_coupon button.button,
		'.$gradient_class.'#review_form #respond .form-submit input,
		'.$gradient_class.'#review_form #respond .form-submit input:hover,
		'.$gradient_class.'.cart .button,
		'.$gradient_class.'button.button:hover,
		'.$gradient_class.'.cart_totals .wc-proceed-to-checkout a.checkout-button:hover,
		'.$gradient_class.'.cart .button:hover,
		'.$gradient_class.'.cart-collaterals .button,
		'.$gradient_class.'.cart-collaterals .button:hover,
		'.$gradient_class.'table.shop_table.cart input.button:hover,
		'.$gradient_class.'.woocommerce-message a.button,
		'.$gradient_class.'.woocommerce-message a.button:hover,
		'.$gradient_class.'.wgl-theme-header .woo_mini_cart .woocommerce-mini-cart__buttons a.button.wc-forward:not(.checkout),
		'.$gradient_class.'.wgl-theme-header .woo_mini_cart .woocommerce-mini-cart__buttons a.button.wc-forward:not(.checkout):hover,
		'.$gradient_class.'.wc-proceed-to-checkout a.checkout-button{';
		if ( (bool)$use_gradient_switch ) {
			$css .= '
			background: -webkit-linear-gradient(left, '.$theme_gradient_from.' 0%, '.$theme_gradient_to.' 50%, '.$theme_gradient_from.' 100%);
			background-size: 300%, 1px;
			background-position: 0%;';
		} else {
			$css .= 'background-color:'.$theme_color.';';
		}
		$css .= '}';		

		// text gradient color 
		$css .= '
		.example {';
		if ( (bool)$use_gradient_switch ) {
			$gradient = 'linear-gradient(0deg, '.$theme_gradient_from.' 0%, '.$theme_gradient_to.' 100%)';
			$css .= '
				color: '.$theme_gradient_from.';
				-webkit-text-fill-color: transparent;
				-webkit-background-clip: text;
				background-image: -webkit-'.$gradient.';
				background-image: -moz-'.$gradient.';
			';
		} else {
			$css .= 'color:'.$theme_gradient_from.';';
		}
		$css .= '}';
		
		// Secondary Theme Gradient Сolors
		$css .= '
		.author-widget_social a,
		.woocommerce .widget_price_filter .ui-slider .ui-slider-range,
		.woocommerce div.product .woocommerce-tabs ul.tabs li.active a:before,
		.wgl_module_team .team-info_icons .team-icon{';
			if ( (bool)$use_gradient_switch ) {
				$css .= '
				background: '.$second_gradient_from.';
				background: -moz-linear-gradient(-30deg, '.$second_gradient_from.' 0%, '.$second_gradient_to.' 100%);
				background: -webkit-gradient(left top, right bottom, color-stop(0%, '.$second_gradient_from.'), color-stop(100%, '.$second_gradient_to.'));
				background: -webkit-linear-gradient(-30deg, '.$second_gradient_from.' 0%, '.$second_gradient_to.' 100%);
				background: -o-linear-gradient(-30deg, '.$second_gradient_from.' 0%, '.$second_gradient_to.' 100%);
				background: -ms-linear-gradient(-30deg, '.$second_gradient_from.' 0%, '.$second_gradient_to.' 100%);
				background: linear-gradient(120deg, '.$second_gradient_from.' 0%, '.$second_gradient_to.' 100%);';
			} else {
				$css .= 'background-color: '.$theme_color.';';
			}
		$css .= '}';

		$css .= '
		'.$gradient_class.'.example,
		.single_team_page .team-info_icons a,
		#main ul.seofy_check_gradient li:before {';
		if ( (bool)$use_gradient_switch ) {
			$css .= '
			background: -webkit-linear-gradient(left, '.$second_gradient_from.' 0%, '.$second_gradient_to.' 50%, '.$second_gradient_from.' 100%);
			background-size: 300%, 1px;
			background-position: 0%;';
		} else {
			$css .= 'background-color:'.$theme_color.';';
		}
		$css .= '}';		

		$css .= '
		'.$gradient_class.' .woocommerce .widget_shopping_cart .buttons a.checkout,
		'.$gradient_class.'.wgl-theme-header .woo_mini_cart .woocommerce-mini-cart__buttons a.checkout{';
		if ( (bool)$use_gradient_switch ) {
			$css .= '
			background: -webkit-linear-gradient(left, '.$second_gradient_from.' 0%, '.$second_gradient_to.' 50%, '.$second_gradient_from.' 100%);
			background-size: 300%, 1px;
			background-position: 0%;';
		} else {
			$css .= 'background-color:'.$theme_color.';';
		}
		$css .= '}';

		// wpBakery elemets
		$css .= '
		.wpb-js-composer .wgl-container .vc_row .vc_general.vc_tta.vc_tta-tabs .vc_tta-tabs-container .vc_tta-tabs-list .vc_tta-tab a:before,
		.wpb-js-composer .wgl-container .vc_row .vc_general.vc_tta.vc_tta-tabs .vc_tta-panels-container .vc_tta-panels .vc_tta-panel.vc_active .vc_tta-panel-heading .vc_tta-panel-title a:before {';
			if ( (bool)$use_gradient_switch ) {
				$css .= '
				background: '.$second_gradient_from.';
				background: -moz-linear-gradient(-30deg, '.$second_gradient_from.' 0%, '.$second_gradient_to.' 100%);
				background: -webkit-gradient(left top, right bottom, color-stop(0%, '.$second_gradient_from.'), color-stop(100%, '.$second_gradient_to.'));
				background: -webkit-linear-gradient(-30deg, '.$second_gradient_from.' 0%, '.$second_gradient_to.' 100%);
				background: -o-linear-gradient(-30deg, '.$second_gradient_from.' 0%, '.$second_gradient_to.' 100%);
				background: -ms-linear-gradient(-30deg, '.$second_gradient_from.' 0%, '.$second_gradient_to.' 100%);
				background: linear-gradient(120deg, '.$second_gradient_from.' 0%, '.$second_gradient_to.' 100%);';
			} else {
				$css .= 'background-color: '.$theme_color.';';
			}
		$css .= '}';

		// text gradient
		$css .= '
		.seofy_module_testimonials.type_author_top_inline .testimonials_meta_wrap:after {';
		if ( (bool)$use_gradient_switch ) {
			$gradient = 'linear-gradient(0deg, '.$second_gradient_from.' 0%, '.$second_gradient_to.' 100%)';
			$css .= '
				color: '.$second_gradient_from.';
				-webkit-text-fill-color: transparent;
				-webkit-background-clip: text;
				background-image: -webkit-'.$gradient.';
				background-image: -moz-'.$gradient.';
			';
		} else {
			$css .= 'color:'.$second_gradient_from.';';
		}
		$css .= '}';

		/*-----------------------------------------------------------------------------------*/
		/* \End Gradient css
		/*-----------------------------------------------------------------------------------*/

		/*-----------------------------------------------------------------------------------*/
		/* Add Inline css
		/*-----------------------------------------------------------------------------------*/

		$css = $this->minify_css($css);
		wp_add_inline_style( 'seofy-main', $css );

		/*-----------------------------------------------------------------------------------*/
		/* \End Add Inline css
		/*-----------------------------------------------------------------------------------*/
	}
}

if(!function_exists('seofy_dynamic_styles')){
    function seofy_dynamic_styles() {
        return Seofy_dynamic_styles::instance();
    }
}

seofy_dynamic_styles()->register_script();
seofy_dynamic_styles()->init_style();



