<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }
/**
* Seofy Theme Helper
*
*
* @class        Seofy_Walker_Nav_Footer_Menu
* @version      1.0
* @category Class
* @author       WebGeniusLab
*/

class Seofy_Walker_Nav_Footer_Menu extends Walker {
    private $elements;
    private $elements_counter = 0;

    function __construct() {}

    function walk ($items, $depth) {
        $this->elements = $this->get_number_of_root_elements($items);
        return parent::walk($items, $depth);
    }

    var $tree_type = array( 'post_type', 'taxonomy', 'custom' );
    var $db_fields = array( 'parent' => 'menu_item_parent', 'id' => 'db_id' );

    function start_lvl( &$output, $depth = 0, $args = array() ) {
        $indent = str_repeat("\t", $depth);
        $output .= "\n$indent<ul class=\"sub-menu\">";
        $output .= "\n";
    }

    function end_lvl( &$output, $depth = 0, $args = array() ) {
        $indent = str_repeat("\t", $depth);
        $output .= "$indent</ul>\n";
    }

    function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
        $indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

        $class_names = $value = '';

        $classes = empty( $item->classes ) ? array() : (array) $item->classes;
        $classes[] = 'menu-item-' . sanitize_html_class( $item->ID );

        if ($item->menu_item_parent=="0") {
            $this->elements_counter += 1;
            if ($this->elements_counter>$this->elements/2){
                array_push($classes,'right');
            }
        }

        $class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args ) );
        $class_names = $class_names ? ' class="' . $class_names  . '"' : '';

        $id = apply_filters( 'nav_menu_item_id', 'footer-menu-item-'. sanitize_html_class( $item->ID ), $item, $args );
        $id = $id ? ' id="' . $id . '"' : '';

        $output .= $indent . '<li' . $id . $value . $class_names .'>';

        $atts = array();
        $atts['title']  = ! empty( $item->attr_title ) ? $item->attr_title : '';
        $atts['target'] = ! empty( $item->target )   ? $item->target     : '';
        $atts['rel']    = ! empty( $item->xfn )     ? $item->xfn        : '';
        $atts['href']   = ! empty( $item->url )     ? $item->url        : '';

        $atts = apply_filters( 'nav_menu_link_attributes', $atts, $item, $args );

        $attributes = '';
        foreach ( $atts as $attr => $value ) {
            if ( ! empty( $value ) ) {
                $value = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
                $attributes .= ' ' . $attr . '="' . $value . '"';
            }
        }

        $item_output = !empty($args->before) ? $args->before : '';
        $item_output .= '<a'. $attributes .'>';

        $item_output .= ( !empty($args->link_before) ? $args->link_before : '' ) . apply_filters( 'the_title', $item->title, $item->ID ) . ( !empty($args->link_after ) ? $args->link_after : '' );
        $item_output .= '</a>';

        if ( in_array( 'menu-item-has-children', $item->classes ) ){
            $item_output .= "<span class='button_open'></span>";
        }
        $item_output .= ( !empty($args->after) ? $args->after : '' );

        $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
    }

    function end_el( &$output, $item, $depth = 0, $args = array() ) {
        $output .= "</li>\n";
    }
}