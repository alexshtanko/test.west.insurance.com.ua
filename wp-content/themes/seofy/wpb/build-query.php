<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }
/**
* Seofy Loop Settings
*
*
* @class        Seofy_Loop_Settings
* @version      1.0
* @category Class
* @author       WebGeniusLab
*/
if (!class_exists('Seofy_Loop_Settings')) {
    class Seofy_Loop_Settings{

        private static $instance = null;
        public static function get_instance( ) {
            if ( null == self::$instance ) {
                self::$instance = new self( );
            }

            return self::$instance;
        }

        public static function buildQuery($query){
            $query_builder = new Seofy_Query_Builder( $query );
            return $query_builder->build();
        }

        public static function init($base_name, $array = array()){
            if( !$base_name )
                return;
            
            //Add Autocomplete posts
            add_filter( 'vc_autocomplete_'.$base_name.'_by_posts_callback', 'Seofy_Loop_Settings::by_posts_suggester', 10, 1 );

            add_filter( 'vc_autocomplete_'.$base_name.'_by_posts_render', 'Seofy_Loop_Settings::by_posts_suggester_render', 10, 1 );

            //Add Autocomplete categories
            add_filter( 'vc_autocomplete_'.$base_name.'_categories_callback', 'Seofy_Loop_Settings::categories_suggester', 10, 1 );

            add_filter( 'vc_autocomplete_'.$base_name.'_categories_render', 'Seofy_Loop_Settings::categories_suggester_render', 10, 1 );

            //Add Autocomplete tags
           add_filter( 'vc_autocomplete_'.$base_name.'_tags_callback', 'Seofy_Loop_Settings::tags_suggester', 10, 1 );

            add_filter( 'vc_autocomplete_'.$base_name.'_tags_render', 'Seofy_Loop_Settings::tags_suggester_render', 10, 1 );            

            //Add Autocomplete taxonomies
           add_filter( 'vc_autocomplete_'.$base_name.'_taxonomies_callback', 'Seofy_Loop_Settings::taxonomies_suggester', 10, 1 );

            add_filter( 'vc_autocomplete_'.$base_name.'_taxonomies_render', 'Seofy_Loop_Settings::taxonomies_suggester_render', 10, 1 );          

            //Add Autocomplete users
           add_filter( 'vc_autocomplete_'.$base_name.'_author_callback', 'Seofy_Loop_Settings::author_suggester', 10, 1 );

            add_filter( 'vc_autocomplete_'.$base_name.'_author_render', 'Seofy_Loop_Settings::author_suggester_render', 10, 1 );

            vc_add_param($base_name,array(
                    'type'        => 'textfield',
                    'edit_field_class' => 'vc_col-sm-4',
                    'heading'     => esc_html__('Post count', 'seofy'),
                    'param_name'  => 'number_of_posts',
                    'description' => '',
                    'std'         => 12,
                    'group' => esc_html__( 'Query', 'seofy' ),
                )
            );
            vc_add_param($base_name,array(
                    'type'        => 'dropdown',
                    'edit_field_class' => 'vc_col-sm-4 no-top-padding',
                    'heading'     => esc_html__('Order By', 'seofy'),
                    'param_name'  => 'order_by',
                    'value'       => array(
                        esc_html__('Date', 'seofy')  => 'date',
                        esc_html__('Title', 'seofy') => 'title',
                        esc_html__('Author', 'seofy')  => 'author',
                        esc_html__('Modified', 'seofy')  => 'modified',
                        esc_html__('rand', 'seofy')  => 'Random',
                        esc_html__('comment_count', 'seofy')  => 'Comment count',
                        esc_html__('menu_order', 'seofy')  => 'Menu order',
                    ),
                    'save_always' => true,
                    'description' => '',
                    'group' => esc_html__( 'Query', 'seofy' ),
                )
            );
            vc_add_param($base_name,array(
                    'type'        => 'dropdown',
                    'edit_field_class' => 'vc_col-sm-4 no-top-padding',
                    'heading'     => esc_html__('Sort Order', 'seofy'),
                    'param_name'  => 'order',
                    'value'       => array(
                        esc_html__('ASC', 'seofy')  => 'ASC',
                        esc_html__('DESC', 'seofy') => 'DESC'
                    ),
                    'save_always' => true,
                    'description' => '',
                    'group' => esc_html__( 'Query', 'seofy' ),
                )
            );

            if(!isset($array['hide_cats'])){
                vc_add_param($base_name,array(
                        'type'        => 'autocomplete',
                        'edit_field_class' => 'vc_col-sm-10',
                        'heading'     => esc_html__('Category Slug', 'seofy'),
                        'param_name'  => 'categories',
                        'description' => esc_html__('Leave empty for all', 'seofy'),
                        'group' => esc_html__( 'Query', 'seofy' ),
                        'settings' => array(
                            'multiple' => true,
                            'min_length' => 2,
                            'display_inline' => true,
                            'unique_values' => true,
                        ),
                    )
                );
                vc_add_param($base_name,array(
                        'type' => 'wgl_checkbox',
                        'heading' => esc_html__('Exclude', 'seofy' ),
                        'param_name' => 'exclude_categories',
                        'edit_field_class' => 'vc_col-sm-2',
                        'group' => esc_html__( 'Query', 'seofy' ),
                    )
                );                
            }

            if(!isset($array['hide_tags'])){
                vc_add_param($base_name,array(
                        'type'        => 'autocomplete',
                        'edit_field_class' => 'vc_col-sm-10',
                        'heading'     => esc_html__('Tags Slug', 'seofy'),
                        'param_name'  => 'tags',
                        'description' => esc_html__('Leave empty for all', 'seofy'),
                        'group' => esc_html__( 'Query', 'seofy' ),
                        'settings' => array(
                            'multiple' => true,
                            'min_length' => 2,
                            'display_inline' => true,
                            'unique_values' => true,
                        ),
                    )
                );
                vc_add_param($base_name,array(            
                        'type' => 'wgl_checkbox',
                        'heading' => esc_html__('Exclude', 'seofy' ),
                        'param_name' => 'exclude_tags',
                        'edit_field_class' => 'vc_col-sm-2',
                        'group' => esc_html__( 'Query', 'seofy' ),
                    )
                );
            }
            vc_add_param($base_name,array(        
                    'type'        => 'autocomplete',
                    'edit_field_class' => 'vc_col-sm-10',
                    'heading'     => esc_html__('Taxonomies', 'seofy'),
                    'param_name'  => 'taxonomies',
                    'description' => esc_html__('Filter output by custom taxonomies categories, enter category names here.', 'seofy'),
                    'group' => esc_html__( 'Query', 'seofy' ),
                    'settings' => array(
                        'multiple' => true,
                        'min_length' => 2,
                        'display_inline' => false,
                        'unique_values' => true,
                    ),
                )
            );
            vc_add_param($base_name,array(            
                    'type' => 'wgl_checkbox',
                    'heading' => esc_html__('Exclude', 'seofy' ),
                    'param_name' => 'exclude_taxonomies',
                    'edit_field_class' => 'vc_col-sm-2',
                    'group' => esc_html__( 'Query', 'seofy' ),
                )
            );
            vc_add_param($base_name,array(           
                    'type'        => 'autocomplete',
                    'class'       => '',
                    'heading'     => esc_html__('Individual Posts/Pages/Custom Post Types', 'seofy'),
                    'param_name'  => 'by_posts',
                    'edit_field_class' => 'vc_col-sm-10',
                    'description' => esc_html__('Individual Posts/Pages/Custom Post Types', 'seofy'),
                    'settings' => array(
                        'multiple' => true,
                        'min_length' => 2,
                        'display_inline' => false,
                        'unique_values' => true,
                    ),
                    'group' => esc_html__( 'Query', 'seofy' ),
                ) 
            );
            vc_add_param($base_name,array(            
                    'type' => 'wgl_checkbox',
                    'heading' => esc_html__('Exclude', 'seofy' ),
                    'param_name' => 'exclude_any',
                    'edit_field_class' => 'vc_col-sm-2',
                    'group' => esc_html__( 'Query', 'seofy' ),
                )
            );
            vc_add_param($base_name,array(          
                    'type'        => 'autocomplete',
                    'class'       => '',
                    'heading'     => esc_html__('Author', 'seofy'),
                    'param_name'  => 'author',
                    'description' => esc_html__('Filter by author name.', 'seofy'),
                    'group' => esc_html__( 'Query', 'seofy' ),
                    'edit_field_class' => 'vc_col-sm-10',
                    'settings' => array(
                        'multiple' => true,
                        'min_length' => 2,
                        'display_inline' => false,
                        'unique_values' => true,
                    ),
                )
            ); 
            vc_add_param($base_name,array(            
                    'type' => 'wgl_checkbox',
                    'heading' => esc_html__('Exclude', 'seofy' ),
                    'param_name' => 'exclude_author',
                    'edit_field_class' => 'vc_col-sm-2',
                    'group' => esc_html__( 'Query', 'seofy' ),
                )
            ); 
         
        }

        /**
         * @param query posts
         *
         * @since 1.0
         * @return array
         */
        public static function by_posts_suggester( $query) {
            $content = array();

            $args = ! empty( $query ) ? array( 's' => $query, 'post_type' => 'any' ) : array( 'post_type' => 'any' );

            $posts = get_posts( $args );
            foreach ( $posts as $post ) {
                $content[] = array( 'value' => $post->post_name, 'label' => $post->post_title );
            }
            return $content;
        }

        public static function by_posts_suggester_render( $query ) {
            $options = array();
            $query = trim( $query['value'] );

            // get value from requested
            if ( ! empty( $query ) ) {
                $list = get_posts( array( 'post_type' => 'any', 'name' => $query  ) );
                
                foreach ( $list as $obj ) {
                    $options[] = array(
                        'value' => $obj->post_name,
                        'label' => $obj->post_title,
                    );
                }
                
                return isset($options[0]) ? $options[0] : ''; 
            }
            return false;
        }        

        /**
         * @param query author
         *
         * @since 1.0
         * @return array
         */
        public static function author_suggester( $query) {
            $content = array();
            $args = ! empty( $query ) ? array(
                'search' => '*' . $query . '*',
                'search_columns' => array( 'user_nicename' ),
            ) : array();
            $users = get_users( $args );
            foreach ( $users as $user ) {
                $content[] = array( 'value' => (string) $user->ID, 'label' => (string) $user->data->user_nicename );
            }
            return $content;
        }

        public static function author_suggester_render( $query ) {
            $options = array();
            $query = trim( $query['value'] );

            // get value from requested
            if ( ! empty( $query ) ) {
                $list = explode( ',', $query );
                $users = get_users( array( 'include' => array_map( 'abs', $list ) ) );
                foreach ( $users as $user ) {
                    $options[] = array(
                        'value' => (string) $user->ID,
                        'label' => $user->data->user_nicename,
                    );
                }
                
                return isset($options[0]) ? $options[0] : ''; 
            }
            return false;
        }

        /**
         * @param query categories
         *
         * @since 1.0
         * @return array
         */
        public static function categories_suggester($query){
            $content = array();
            $args = ! empty( $query ) ? array( 'search' => $query ) : array();
            
            $categories = get_categories($args);
            foreach ( $categories as $cat ) {
                $args = array(
                  'separator' => ' > ',
                  'format'    => 'name',          
                );
                $parent = self::get_term_parents_list( $cat->cat_ID, 'category', $args);
                
                $content[] = array( 'value' => (string) $cat->slug, 'label' => $cat->cat_name.(!empty($parent) ? esc_html__(' (Parent categories: (', 'seofy') .$parent.'))' : ""));
            }
            return $content;            
        }

        public static function categories_suggester_render( $query ) {
            $query = trim( $query['value'] );

            // get value from requested
            if ( ! empty( $query ) ) {

                $list = explode( ',', $query );
                $id_list = array();
                foreach ($list as $key => $value) {
                    $idObj = get_category_by_slug($value); 
                    $id_list[] = $idObj->term_id;
                }
                $id_list = implode(",", $id_list);
                
                $categories = get_categories( array( 'include' => $id_list  ) ); 
                $content = array();
                foreach ( $categories as $cat ) {
                    $args = array(
                      'separator' => ' > ',
                      'format'    => 'name',          
                    );
                    $parent = self::get_term_parents_list( $cat->cat_ID, 'category', $args);
                    
                    $content[] = array( 'value' => (string) $cat->slug, 'label' => $cat->cat_name.(!empty($parent) ? esc_html__(' (Parent categories: (', 'seofy') .$parent.'))' : ""));
                }
                return isset($content[0]) ? $content[0] : false;  
            }
            return false;
        }         

        /**
         * @param query tags
         *
         * @since 1.0
         * @return array
         */
        public static function tags_suggester($query){
            $content = array();
            $args = ! empty( $query ) ? array( 'search' => $query ) : array();
            
            $tags = get_tags($args);
            foreach ( $tags as $tag ) {                
                $content[] = array( 'value' => (string) $tag->slug, 'label' => $tag->name);
            }
            return $content;           
        }

        public static function tags_suggester_render( $query ) {
            $query = trim( $query['value'] );

            // get value from requested
            if ( ! empty( $query ) ) {

                $list = explode( ',', $query );
                $id_list = array();
                foreach ($list as $key => $value) {
                    $idObj = get_term_by('slug', $value,'post_tag'); 
                    $id_list[] = $idObj->term_id;
                }
                $id_list = implode(",", $id_list);
                
                $tags = get_tags( array( 'include' => $id_list  ) ); 
                $content = array();
                foreach ( $tags as $tag ) {                    
                    $content[] = array( 'value' => (string) $tag->slug, 'label' => $tag->name);
                }
                return isset($content[0]) ? $content[0] : false;  
            }
            return false;
        }    

        /**
         * @param query taxonomies
         *
         * @since 1.0
         * @return array
         */
        public static function taxonomies_suggester($query){
            $content = array();
            $args = ! empty( $query ) ? array( 'search' => $query ) : array();
            $tags = get_terms( self::getTaxonomies(), $args );

            foreach ( $tags as $tag ) {
                $args = array(
                    'separator' => ' > ',
                    'format'    => 'name',          
                );
                $parent = self::get_term_parents_list( $tag->term_id, $tag->taxonomy, $args);
                $content[] = array(
                    'value' => $tag->taxonomy.":".$tag->slug,
                    'label' => $tag->name . ' (' . $tag->taxonomy . ')'.(!empty($parent) ? esc_html__(' (Parent categories: (', 'seofy') .$parent.'))' : "")
                );
            }
            return $content;
        }

        public static function getTaxonomies(){
             $taxonomy_exclude = (array) apply_filters( 'get_categories_taxonomy', 'category' );
            $taxonomy_exclude[] = 'post_tag';
            $taxonomies = array();

            foreach ( get_taxonomies() as $taxonomy ) {
                if ( ! in_array( $taxonomy, $taxonomy_exclude ) ) {
                    $taxonomies[] = $taxonomy;
                }
            }
            return $taxonomies;           
        }

        public static function taxonomies_suggester_render($query){
            $query = trim( $query['value'] );
            // get value from requested
            if ( ! empty( $query ) ) {
                $list = explode( ',', $query );
                $id_list = array();
                $taxonomies = get_terms( self::getTaxonomies() );
                foreach ($list as $key => $value) {
                    $item = explode(":", $value);
                    $idObj = get_term_by('slug', $item[1], $item[0]); 
                    $id_list[] = $idObj->term_id;
                }

                $id_list = implode(",", $id_list);
                
                $list = get_terms( self::getTaxonomies(), array( 'include' => $id_list  ) ); 
                $content = array();
                foreach ( $list as $obj ) {  
                    $args = array(
                        'separator' => ' > ',
                        'format'    => 'name',          
                    );
                    $parent = self::get_term_parents_list( $obj->term_id, $obj->taxonomy, $args);

                    $content[] = array( 
                        'value' => $obj->taxonomy.":".(string) $obj->slug,
                        'label' => $obj->name . ' (' . $obj->taxonomy . ')'.(!empty($parent) ? esc_html__(' (Parent categories: (', 'seofy') .$parent.'))' : "")
                    );
                }
                return isset($content[0]) ? $content[0] : false;  
            }
            return false;
        }

        /**
         * @param $taxonomy
         * @param $helper
         *
         * @since 1.0
         */
        public static function get_term_parents_list( $term_id, $taxonomy, $args = array() ) {
            $list = '';
            $term = get_term( $term_id, $taxonomy );
    
            if ( is_wp_error( $term ) ) {
                return $term;
            }
    
            if ( ! $term ) {
                return $list;
            }
    
            $term_id = $term->term_id;
    
            $defaults = array(
                    'format'    => 'name',
                    'separator' => '/',
                    'inclusive' => true,
            );
    
            $args = wp_parse_args( $args, $defaults );
    
            foreach ( array(  'inclusive' ) as $bool ) {
                $args[ $bool ] = wp_validate_boolean( $args[ $bool ] );
            }
    
            $parents = get_ancestors( $term_id, $taxonomy, 'taxonomy' );
            
            if ( $args['inclusive'] ) {
                array_unshift( $parents, $term_id );
            }
        
            $a = count($parents) - 1;
            foreach ( array_reverse( $parents ) as $index => $term_id ) {
                $parent = get_term( $term_id, $taxonomy );
                $temp_sep = $args['separator'];
                $lastElement = reset($parents);
                $first = end($parents);
                
                if($index == $a - 1){
                    $temp_sep = '';
                }
                if( $term_id != $lastElement){
                    $name   = $parent->name;
                    $list .= $name . $temp_sep;  
                }         
            }
    
            return $list;
        }        
        
    }
    new Seofy_Loop_Settings();
}

/**
* Seofy Query Builder
*
*
* @class        Seofy_Query_Builder
* @version      1.0
* @category Class
* @author       WebGeniusLab
*/
if(!class_exists('Seofy_Query_Builder')){
    class Seofy_Query_Builder{
        /**
         * @since 1.0
         * @var array
         */
        private $args = array(
            'post_status' => 'publish', // show only published posts #1098
        );

        private $data_attr = array();

        private static $instance = null;
        public static function get_instance( ) {
            if ( null == self::$instance ) {
                self::$instance = new self( );
            }

            return self::$instance;
        }

        function __construct( $data ) {
            //Include Item
            foreach ( $data as $key => $value ) {
                $method = 'parse_' . $key;
                if(stripos($key,'exclude_') === false){
                    if ( method_exists( $this, $method ) ) {
                        $this->$method( $value );
                    }
                }

            }

            //Exclude Item
            foreach ($data as $k => $v) {
                $method = 'parse_' . $k;
                if(stripos($k,'exclude_') !== false){
                    if ( method_exists( $this, $method ) ) {
                        $this->$method( $v );
                    }
                }
            }
        }    

        /**
         * Pages count
         * @since 1.0
         *
         * @param $value
         */
        protected function parse_number_of_posts( $value ) {
            $this->args['posts_per_page'] = 'All' === $value ? - 1 : (int) $value;
        }

        /**
         * Sorting field
         * @since 1.0
         *
         * @param $value
         */
        protected function parse_order_by( $value ) {
            $this->args['orderby'] = $value;
        }

        /**
         * Sorting order
         * @since 1.0
         *
         * @param $value
         */
        protected function parse_order( $value ) {
            $this->args['order'] = $value;
        }

        /**
         * By author
         * @since 1.0
         *
         * @param $value
         */
        protected function parse_author( $value ) {

            $this->data_attr['author_id'] = $value;
            $this->args['author'] = $value;
        }        

        /**
         * Exclude author
         * @since 1.0
         *
         * @param $value
         */
        protected function parse_exclude_author( $value ) {
            if(!isset($this->data_attr['author_id'])){
                return;
            }
            if(isset($this->args['author'])){
                unset($this->args['author']);
            }
            $author_id = array();
            $author_id[] = $this->data_attr['author_id'];
            $this->args['author__not_in'] = $author_id;
        }

        /**
         * By categories
         * @since 1.0
         *
         * @param $value
         */
        protected function parse_categories( $value ) {
            if(empty($value)){
                return;
            }
            $this->args['category_name'] = $value;
        }        

        /**
         * Exclude categories
         * @since 1.0
         *
         * @param $value
         */
        protected function parse_exclude_categories( $value ) {
            if(!isset($this->args['category_name'])){
                return;
            }

            $list = $this->stringToArray( $this->args['category_name'] );
            $id_list = array();
            foreach ($list as $key => $value) {
                $idObj = get_category_by_slug($value); 
                $id_list[] = '-'.$idObj->term_id;
            }
            $id_list = implode(",", $id_list);
            $this->args['cat'] = $id_list;
            unset($this->args['category_name']);
        }

        /**
         * Get Taxonomies
         * @since 1.0
         *
         * @param $value
         */
        private function get_tax( $value ){
            $terms = $this->stringToArray( $value );
            $this->args['tax_query'] = array( 'relation' => 'AND' );

            $item = $id_list = array();

            $taxonomies = get_terms( Seofy_Loop_Settings::getTaxonomies() );
            foreach ($terms as $key => $value) {
                $item_t = explode(":", $value);
                if(isset($item_t[1])){
                    $idObj = get_term_by('slug', $item_t[1], $item_t[0]); 
                    $id_list[] = $idObj->term_id;  
                }
            }

            $terms = get_terms( Seofy_Loop_Settings::getTaxonomies(),
                array( 'include' => array_map( 'abs', $id_list ) ) );
            foreach ( $terms as $t ) {
                $item[ $t->taxonomy ][] = $t->slug;
            }

            return $item;
        }

        /**
         * By taxonomies
         * @since 1.0
         *
         * @param $value
         */
        protected function parse_taxonomies( $value ) {
            if(empty($value)){
                return;
            }

            $this->data_attr['taxonomies'] = $value;
            
            $item = $this->get_tax($value);

            foreach ( $item as $taxonomy => $terms ) {
                $this->args['tax_query'][] = array(
                    'field' => 'slug',
                    'taxonomy' => $taxonomy,
                    'terms' => $terms,
                    'operator' => 'IN',
                );
            }
        }        

        /**
         * Exclude tax slugs
         * @since 1.0
         *
         * @param $value
         */
        protected function parse_exclude_taxonomies() {
            if(!isset($this->data_attr['taxonomies'])){
                return;
            }
            if(isset($this->args['tax_query'])){
                unset($this->args['tax_query']);
            }           
            
            $value = $this->data_attr['taxonomies'];  
                
            $item = $this->get_tax($value);

            foreach ( $item as $taxonomy => $terms ) {
                $this->args['tax_query'][] = array(
                    'field' => 'slug',
                    'taxonomy' => $taxonomy,
                    'terms' => $terms,
                    'operator' => 'NOT IN',
                );
            }
        }

        /**
         * By tags slugs
         * @since 1.0
         *
         * @param $value
         */
        protected function parse_tags( $value ) {
            if(empty($value)){
                return;
            }
            $this->data_attr['tags'] = $value;
            $in = $not_in = array();
            $tags_slugs = $this->stringToArray( $value );
            foreach ( $tags_slugs as $tag ) {
                $in[] = $tag;
            }
            $this->args['tag_slug__in'] = $in;
        }

        /**
         * Exclude tags slugs
         * @since 1.0
         *
         * @param $value
         */
        protected function parse_exclude_tags( $value ) {
            if(!isset($this->data_attr['tags'])){
                return;
            }

            $list = $this->stringToArray( $this->data_attr['tags'] );
            $id_list = array();
            foreach ($list as $key => $value) {
                $idObj = get_term_by('slug', $value,'post_tag');
                $id_list[] = (int) $idObj->term_id;
            }

            $id_list = implode(",", $id_list);
            $this->args['tag__not_in'] = $id_list;

            unset($this->args['tag_slug__in']);
        }

        /**
         * By posts slugs
         * @since 1.0
         *
         * @param $value
         */
        protected function parse_by_posts( $value ) {
            $in = array();
            $this->data_attr['posts_in'] = $value;
            $slugs = $this->stringToArray( $value );
            foreach ( $slugs as $slug ) {
                $in[] = $slug;
            }
            $this->args['post_name__in'] = $in;
        }        

        /**
         * Exclude posts slugs
         * @since 1.0
         *
         * @param $value
         */
        protected function parse_exclude_any( $value ) {
            global $post;
            if(!isset($this->data_attr['posts_in'])){
                return;
            }
            if(isset($this->args['post_name__in'])){
                unset($this->args['post_name__in']);
            }

            $options = array();
            $value = trim( $this->data_attr['posts_in'] );
            $value = explode(', ', $value);     
            $list = new WP_Query(array( 
                'post_type'             => 'any',
                'post_name__in'         => $value,
            ));
            foreach ( $list->posts as $obj ) {
                $options[] = $obj->ID;
            }
            $this->args['post__not_in'] = $options;       
        }

        /**
         * @since 1.0
         *
         * @param $id
         */
        public function excludeId( $id ) {
            if ( ! isset( $this->args['post__not_in'] ) ) {
                $this->args['post__not_in'] = array();
            }
            if ( is_array( $id ) ) {
                $this->args['post__not_in'] = array_merge( $this->args['post__not_in'], $id );
            } else {
                $this->args['post__not_in'][] = $id;
            }
        }

        /**
         * Converts string to array. Filters empty arrays values
         * @since 1.0
         *
         * @param $value
         *
         * @return array
         */
        protected function stringToArray( $value ) {
            $valid_values = array();
            $list = preg_split( '/\,[\s]*/', $value );
            foreach ( $list as $v ) {
                if ( strlen( $v ) > 0 ) {
                    $valid_values[] = $v;
                }
            }

            return $valid_values;
        }
 
        public function build(){
            return array( $this->args, new WP_Query( $this->args ) );
        }       
    }
}
?>