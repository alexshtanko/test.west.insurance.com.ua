<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }
/**
* Seofy Theme Autoload
*
*
* @class        Seofy_Theme_Autoload
* @version      1.0
* @category Class
* @author       WebGeniusLab
*/

if (!class_exists('Seofy_Theme_Autoload')) {
    class Seofy_Theme_Autoload{

        private static $instance = null;
        public static function get_instance( ) {
            if ( null == self::$instance ) {
                self::$instance = new self( );
            }

            return self::$instance;
        }

        public function __construct () {
            add_filter( 'template_include', array($this,'vc_template'), 1000 );
            
            #Defaults option theme
            $this->theme_default_option();
            
            #Metabox option 
            $this->metabox_option();
        
            #Theme option 
            $this->theme_option();            

            #Customize theme 
            $this->theme_customize();

            #Widgets
            $this->theme_widget();

            #TGM init
            $this->tgm_register();
        }

        public function theme_default_option(){
            require_once(get_template_directory() . '/core/includes/default-options.php');
        }        

        public function theme_option(){
            require_once(get_template_directory() . '/core/includes/redux/redux-config.php');
        }        

        public function metabox_option(){
            require_once(get_template_directory() . '/core/includes/metabox/metabox-config.php');
        }

        public function theme_customize(){
            require_once(get_template_directory() . '/core/class/dynamic-styles.php');
            require_once(get_template_directory() . '/core/class/theme-support.php');            
        }

        public function vc_template( $template ){
            if(is_page_template('template-full-width.php'))
                require_once(get_template_directory() . "/wpb/wgl_vc_addons.php");
            return $template;
        }

        public function theme_widget(){
            require_once(get_template_directory() . '/core/includes/widgets/posts.php');
            require_once(get_template_directory() . '/core/includes/widgets/posts_hero.php');
            require_once(get_template_directory() . '/core/includes/widgets/author.php');
            require_once(get_template_directory() . '/core/includes/widgets/banner.php');            
        }

        public function tgm_register(){
             require_once(get_template_directory() . '/core/tgm/wgl-tgm.php');
        } 
    }
    new Seofy_Theme_Autoload();

}
?>