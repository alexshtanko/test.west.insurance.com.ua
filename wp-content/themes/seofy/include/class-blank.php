<?php

class Blank {

    public function __construct()
    {

    }

    /*
     * Получаем диапазон нумерации бланков в зависимости от:
     * - страховой компании;
     * - типа бланка (Из бумаги, Электронный);
     *
     * return ARRAY
     * */
    public function get_blank_range( $blank_type_id = 1, $company_id, $last_order_blank_number, $last_order_blank_series ){

        global $wpdb;

        $results = array();

        $table_name = $wpdb->get_blog_prefix() . 'insurance_number_of_blank';

        $results = $wpdb->get_results( 'SELECT DISTINCT * FROM ' . $table_name . ' WHERE 
        number_start <= '. (int) $last_order_blank_number .' 
        AND number_end >= '. (int) $last_order_blank_number .' 
        AND blank_series LIKE "'.$last_order_blank_series.'" 
        AND company_id = ' . $company_id . ' 
        AND blank_type_id = ' . $blank_type_id . ' 
        AND status = 1 AND range_used_status = 0 ORDER BY id ASC LIMIT 1;', ARRAY_A );

        return $results;

    }

    /*
     * Получаем диапазон для первого договора
     *
     * return ARRAY
     * */
    public function get_first_blank_range( $blank_type_id = 1, $company_id ){

        global $wpdb;

        $results = array();

        $table_name = $wpdb->get_blog_prefix() . 'insurance_number_of_blank';

//        $results = $wpdb->get_results( 'SELECT DISTINCT * FROM ' . $table_name . ' WHERE
//        company_id = ' . $company_id . '
//        AND blank_type_id = ' . $blank_type_id . '
//        AND status = 1 AND range_used_status = 0 ORDER BY id ASC LIMIT 1;', ARRAY_A );
        $results = $wpdb->get_results( 'SELECT DISTINCT * FROM ' . $table_name . ' WHERE 
        number_start = (SELECT MIN(number_start) FROM ' . $table_name . ' WHERE company_id = ' . $company_id . ' AND blank_type_id = ' . $blank_type_id . '  AND status = 1 AND range_used_status = 0 )
        AND company_id = ' . $company_id . ' 
        AND blank_type_id = ' . $blank_type_id . ' 
        AND status = 1 AND range_used_status = 0 ORDER BY id ASC LIMIT 1;', ARRAY_A );

        return $results;

    }


    /*
     * Получаем новый диапазон
     *
     * return ARRAY
     * */
    public function get_new_blank_range( $blank_type_id, $company_id, $last_order_blank_number, $last_order_blank_series ){

        global $wpdb;

        $results = array();

        $table_name = $wpdb->get_blog_prefix() . 'insurance_number_of_blank';
/*
 SELECT DISTINCT * FROM `plc_insurance_number_of_blank` WHERE
 `number_start` = (SELECT MIN(`number_start`) FROM `plc_insurance_number_of_blank` WHERE `company_id` = 1 AND `number_end` >= 21 AND `blank_type_id` = 2 AND `status` = 1 AND `range_used_status` = 0 )
       AND `number_end` >= 21
        AND `blank_series` LIKE ''
        AND `company_id` = 1
        AND `blank_type_id` = 2
        AND `status` = 1 AND `range_used_status` = 0 ORDER BY `id` ASC LIMIT 1
 * */
//        $results = $wpdb->get_results( 'SELECT DISTINCT * FROM ' . $table_name . ' WHERE
//        number_start = (SELECT MIN(number_start) FROM ' . $table_name . ' WHERE `company_id` = ' . $company_id . ' AND number_end >= '. (int) $last_order_blank_number .'  AND blank_type_id = ' . $blank_type_id . '  AND status = 1 AND range_used_status = 0 )
//        AND number_end >= '. (int) $last_order_blank_number .'
//        AND blank_series LIKE "'.$last_order_blank_series.'"
//        AND company_id = ' . $company_id . '
//        AND blank_type_id = ' . $blank_type_id . '
//        AND status = 1 AND range_used_status = 0 ORDER BY id ASC LIMIT 1;', ARRAY_A );

        $results = $wpdb->get_results( 'SELECT DISTINCT * FROM ' . $table_name . ' WHERE 
        number_start = (SELECT MIN(number_start) FROM ' . $table_name . ' WHERE company_id = ' . $company_id . ' AND blank_type_id = ' . $blank_type_id . '  AND status = 1 AND range_used_status = 0 )
        AND company_id = ' . $company_id . ' 
        AND blank_type_id = ' . $blank_type_id . ' 
        AND status = 1 AND range_used_status = 0 ORDER BY id ASC LIMIT 1;', ARRAY_A );

        return $results;
    }

    /*
     * Получаем номер бланка последнего оформленного договора
     *
     * return ARRAY
     * */
    public function get_last_order_data( $blank_type_id = 1 ){

        global $wpdb;

        $results = array();

        $table_name = $wpdb->get_blog_prefix() . 'insurance_orders';

        $results = $wpdb->get_results( 'SELECT * FROM ' . $table_name . ' WHERE blank_type_id = ' . $blank_type_id . ' AND status = 1 ORDER BY id DESC LIMIT 1;', ARRAY_A );

        return $results;

    }

    /*
     * Изменяем статус использования указаного диапазона бланков
     *
     * */

    public function change_range_used_status( $number_of_blank_id ){

        global $wpdb;

        $table_name = $wpdb->get_blog_prefix() . 'insurance_number_of_blank';

        $wpdb->update( $table_name,
            [ 'range_used_status' => 1 ],
            [ 'id' => $number_of_blank_id ],
            [ '%d' ],
            [ '%d' ]
        );

    }


    //для поиска по ТАБЛИЧКИ ЭЛЕКТРОННЫХ
    /*
     * Получаем свободный номер ЭЛЕКТРОННОГО бланка
     * return INT
     * */
    public function get_e_blank_number()
    {

        global $wpdb;

        $table_name = $wpdb->get_blog_prefix() . 'insurance_e_blank_number_list';

        $result = $wpdb->get_results( "SELECT `blank_number` FROM " . $table_name . " WHERE `status` = 0 ORDER BY `id` ASC LIMIT 1", ARRAY_A );

        $result = $result[0]['blank_number'];

        return $result;

    }

    //для поиска по ТАБЛИЧКИ ЭЛЕКТРОННЫХ
    /*
     * Получаем свободный номер ЭЛЕКТРОННОГО бланка, ноер серии, название серии
     * return ARRAY
     * */
    public function get_e_blank_number_data($company_id)
    {

        global $wpdb;

        $table_name = $wpdb->get_blog_prefix() . 'insurance_e_blank_number_list';
        $table_name_1 = $wpdb->get_blog_prefix() . 'insurance_number_of_blank';

//        $result = $wpdb->get_results( " SELECT ebnl.blank_number, nob.blank_series, nob.comments, ebnl.number_of_blank_id
//                                        FROM ".$table_name." ebnl
//                                        LEFT JOIN ".$table_name_1." nob ON nob.id = ebnl.number_of_blank_id
//                                        WHERE ebnl.status = 0 ORDER BY ebnl.id ASC LIMIT 1;",
//                                    ARRAY_A );

        $result = $wpdb->get_results( " SELECT ebnl.blank_number, nob.blank_series, nob.comments, ebnl.number_of_blank_id 
                                        FROM ".$table_name." ebnl
                                        LEFT JOIN ".$table_name_1." nob ON nob.id = ebnl.number_of_blank_id
                                        WHERE ebnl.status = 0 AND nob.company_id = $company_id ORDER BY ebnl.id ASC LIMIT 1;",
                                    ARRAY_A );

        return $result;

    }

    //для поиска по ТАБЛИЧКИ ЭЛЕКТРОННЫХ
    /*
     * Смена статуса у ЭЛЕКТРОННОГО бланка
     * */
    public function change_status_e_blank_number($number_blank_id, $blank_number, $status = 0)
    {

        global $wpdb;
        $table_name = $wpdb->get_blog_prefix() . 'insurance_e_blank_number_list';
//        $date_time = new DateTime();
        date_default_timezone_set('Europe/Kiev');
        $date_time = date('Y-m-d H:i:s');

        $wpdb->update( $table_name,
            [ 'status' => $status, 'date_change' => $date_time ],
            [ 'number_of_blank_id' => $number_blank_id, 'blank_number' => $blank_number],
            [ '%d', '%s' ],
            [ '%d', '%d' ]
        );

    }


}