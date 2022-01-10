<?php

class Insurance_Admin_Blank_Pype {


    public function __construct()
    {

    }

    private $version;

    /*
     * Получить все виды бланков
     *
     * return Array
     * */
    public function get_all_blank_type(){

        global $wpdb;

        $results = array();

        $table_name = $wpdb->get_blog_prefix() . 'insurance_blank_type';

        $results = $wpdb->get_results( 'SELECT * FROM ' . $table_name . ' WHERE status = 1;', ARRAY_A );

        return $results;

    }

}