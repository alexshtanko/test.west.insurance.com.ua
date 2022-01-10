<?php

if ( ! defined( 'ABSPATH' ) ) { exit; }
/**
* Seofy WglAdminIcon
*
*
* @class        WglAdminIcon
* @version      1.0
* @category Class
* @author       WebGeniusLab
*/

if (!class_exists('WglAdminIcon')) {
    class WglAdminIcon {
        private $wp_remote_get_args = array(
            'timeout'   => 10,
            'sslverify' => false,
        );

        private $stylesheet_url;
        private $css;
        private $fallback_data = array('path' => '','css' => '');
        private $icon_picker_directory = '/';
        private $icons = array();

        public $prefix = 'fa';


        private static $instance = null;
        public static function get_instance( ) {
            if ( null == self::$instance ) {
                self::$instance = new self( );
            }

            return self::$instance;

        }

        private function __construct( ) {
            $this->load();
        }

        public function load() {
            $this->initialize( );
            $this->setup_stylesheet_data();
            $this->add_editor_styles();      
            add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_scripts' ) );
            add_action( 'media_buttons', array( $this, 'add_insert_shortcode_button' ), 99 );

        }

        private function initialize() {
            $this->parse_args();
            $this->setup_root_url();
            $this->setup_fallback_data();

        }

        private function parse_args() {
            $this->wp_remote_get_args = apply_filters( 'seofy_wp_remote_get_args', $this->wp_remote_get_args );
        }

        function setup_root_url() {
            $this->root_url = trailingslashit( get_template_directory_uri()) .  'core/admin';
        }   

        private function setup_fallback_data() {
            $this->fallback_data['css'] = $this->get_fallback_css();
        }

        private function setup_stylesheet_data() {
            // Get the Font Awesome CSS.
            $this->css = $this->get_css( get_template_directory_uri() . '/css/font-awesome.min.css');
            $this->icons = $this->setup_icon_array( $this->css );
        }

        private function get_css( $url, $version = 4.7 ) {

            $response = $this->get_transient_css( $version );
            if ( ! $response ) {
                $response = $this->get_remote_css( $url, $version );
            }

            return $response;

        }

        private function get_transient_css( $version ) {

            $transient_css_array = get_transient( 'wgl-css' );
            return isset( $transient_css_array[ $version ] ) ? $transient_css_array[ $version ] : '';

        }


        private function get_remote_css( $url, $version ) {

            // Get the remote Font Awesome CSS.
            $url = set_url_scheme( $url );
            $response = wp_remote_get( $url, $this->wp_remote_get_args );

            if ( 200 == wp_remote_retrieve_response_code( $response ) ) {

                $response = wp_remote_retrieve_body( $response );
                $this->set_css_transient( $version, $response );

            } elseif ( is_wp_error( $response ) ) { // Check for faulty wp_remote_get()
                $response = $response;
            } elseif ( isset( $response['response'] ) ) { // Check for 404 and other non-WP_ERROR codes
                $response = new WP_Error( $response['response']['code'], $response['response']['message'] . " (URL: $url)" );
            } else { // Total failsafe
                $response = '';
            }

            return $response;
        }


        private function set_css_transient( $version, $value ) {

            $transient_css_array = get_transient( 'wgl-css' );
            $transient_css_array[ $version ] = $value;

            $transient_expiration = apply_filters( 'seofy_css_transient_expiration', 30 * DAY_IN_SECONDS );

            // Set the new CSS array transient.
            set_transient( 'wgl-css', $transient_css_array, $transient_expiration );

        }

        private function get_fallback_css() {
            return $this->get_local_file_contents( $this->fallback_data['path'] );
        }

        private function setup_icon_array( $css ) {

            $icons = array();
            $hex_codes = array();

            preg_match_all( '/\.(icon-|fa-)([^,}]*)\s*:before\s*{\s*(content:)\s*"(\\\\[^"]+)"/s', $css, $matches );
            $icons = $matches[2];
            $hex_codes = $matches[4];
            $icons = array_combine( $hex_codes, $icons );
            asort( $icons );
            $icons = apply_filters( 'seofy_icon_list', $icons );
            return $icons;
        } 

        public function add_editor_styles() {
            add_editor_style( $this->stylesheet_url );
        }

        public function enqueue_admin_scripts() {
            // Custom admin CSS.
            wp_enqueue_style( 'wgl-admin', $this->root_url . '/css/admin-styles.css' );

            // Custom admin JS.
            wp_enqueue_script( 'wgl-admin', $this->root_url . '/js/admin_icon.js' );

            // Icon picker JS and CSS.
            wp_enqueue_style( 'fontawesome-iconpicker', $this->root_url.'/' . $this->icon_picker_directory . 'css/fontawesome-iconpicker.min.css' );
            wp_enqueue_script( 'fontawesome-iconpicker', $this->root_url.'/' . $this->icon_picker_directory . 'js/fontawesome-iconpicker.min.js' );

            // Output PHP variables to JS.
            $seofy_vars = array(
                'fa_prefix'   => $this->prefix,
                'fa_icons'    => $this->get_icons(),
            );

            wp_localize_script( 'wgl-admin', 'seofy_vars', $seofy_vars );

        }

        public function add_insert_shortcode_button() {

            ob_start();
            ?>
            <span class="wgl-iconpicker fontawesome-iconpicker" data-selected="fa-flag">
                <a href="#" class="button button-secondary iconpicker-component">
                    <span class="fa icon fa-flag icon-flag"></span>&nbsp;
                    <?php esc_html_e( 'Insert Icon', 'seofy' ); ?>
                    <i class="change-icon-placeholder"></i>
                </a>
            </span>
            <?php
            echo ob_get_clean();

        }


        /*----------------------------------------------------------------------------*
         * Helper Functions
         *----------------------------------------------------------------------------*/
        private function get_local_file_contents( $file_path ) {
            if(empty($file_path)){
                return;
            }
            ob_start();
            include $file_path;
            $contents = ob_get_clean();

            return $contents;
        }

        /*----------------------------------------------------------------------------*
         * Public User Functions
         *----------------------------------------------------------------------------*/
        public function get_icons() {
            return $this->icons;
        }

        /*----------------------------------------------------------------------------*
         * Public Helper Functions
         *----------------------------------------------------------------------------*/
        public function get_icons_name() {
            $icons = array();

            foreach ($this->icons as $key => $value) {
                $icons['fa fa-'.$value] = esc_html($value);
            }

            return $icons;
        }

    }

    function WglAdminIcon() {
        return WglAdminIcon::get_instance();
    }

    // Call Admin Func
    WglAdminIcon();
}
?>