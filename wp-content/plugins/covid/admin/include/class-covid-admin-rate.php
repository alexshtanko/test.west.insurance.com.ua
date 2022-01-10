<?php

//Подключаем библиотеку для работы с Excel файлами
require ABSPATH . '/vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;



class Covid_Admin_Rate {

    private $plugin_name;

    private $version;

    public function __construct( $plugin_name, $version ) {

        
        $this->plugin_name = $plugin_name;
        $this->version = $version;

        /*
        * Вывод списка тарифов 
        */
//        add_action( 'admin_head', array( $this, 'covid_rate_list_js' ) );
//        add_action( 'admin_print_scripts-covid_page_covid-rate-import', array( $this, 'covid_rate_list_js' ) );
        add_action( 'admin_print_scripts-covid_page_covid-rate', array( $this, 'covid_rate_list_js' ) );

		//Экшн Вывода тарифов 
		add_action( 'wp_ajax_covidratelist', array( $this, 'covid_rate_list' ) );
        add_action( 'wp_ajax_nopriv_covidratelist', array( $this, 'covid_rate_list' ) );

        /*
        * Удалить тарий
        */
//        add_action( 'admin_head', array( $this, 'covid_rate_delete_js' ) );
        add_action( 'admin_print_scripts-covid_page_covid-rate-import', array( $this, 'covid_rate_delete_js' ) );

		//Экшн удаления тарифа 
		add_action( 'wp_ajax_covidratedelete', array( $this, 'covid_rate_delete' ) );
        add_action( 'wp_ajax_nopriv_covidratedelete', array( $this, 'covid_rate_delete' ) );

    }

    public function covid_rate_delete_js() {

//		wp_enqueue_script( 'covidadminratedelete', PLUGIN_URL . 'admin/js/covid-admin-rate-delete.js', array('jquery'), $this->version );
		wp_enqueue_script( 'covidadminratedelete', plugins_url( 'js/covid-admin-rate-delete.js', dirname(__FILE__) ), array('jquery'), $this->version );

		wp_localize_script( 'covidadminratedelete', 'covidAdminRateDelete', array(
			'ajaxurl' => admin_url('admin-ajax.php'),
			'nonce' => wp_create_nonce( 'covid-admin-rate-delete' ) // Create nonce which we later will use to verify AJAX request
        ));


    }
    
    //Удалить бланк
	public function covid_rate_delete() {

		if( empty( $_POST['nonce'] ) ){
			wp_die('', '', 400);
		}
	
//		check_ajax_referer( 'covid-rate-delete', 'nonce', true );
		check_ajax_referer( 'covid-admin-rate-list', 'nonce', true );

		if( current_user_can('covid_import') ){

            $id = $_POST['id'];
            $company_title = $_POST['company_title'];
            $blank_title = $_POST['blank_title'];
            $franchise = $_POST['franchise'];
            $validity = $_POST['validity'];
            $sum = $_POST['sum'];
            $location = $_POST['location'];
            $count = $_POST['count'];
            $page = $_POST['page'];

            $rates_limit_from = ($page - 1) * $count;

            //Удаление Тарифа
            $remove_status =  $this->remove_rate( $id );
            
            //Обновляем список тарифов
            $rates_sort = $this->rates_sort( $company_title, $blank_title, $franchise, $validity, $sum );

            $rates_count = count($rates_sort);
            $paginations = $this->get_paginations( $rates_count, $count, $page );

            $page = $rates_count/$count;
		    $pages = ceil( $page );

            $rates_sort = $this->rates_sort( $company_title, $blank_title, $franchise, $validity, $sum, $rates_limit_from, $count );
            
            $rates = $this->rates_render( $rates_sort, $page, $count );

            $result = array(
                'rates' => $rates,
                'paginations' => $paginations['result'],
                'status' => $remove_status['status'],
                'pages' => $pages,
                'rates_count' => $rates_count,
                'message' => $remove_status['message'],
                'demo' => $id,
            );

            echo json_encode($result);

        }

        wp_die();
    }

    public function covid_rate_list_js() {

//		wp_enqueue_script( 'covidadminratelist', PLUGIN_URL . 'admin/js/covid-admin-rate-list.js', array('jquery'), $this->version );
		wp_enqueue_script( 'covidadminratelist', plugins_url( 'js/covid-admin-rate-list.js', dirname(__FILE__) ) , array('jquery'), $this->version );

		wp_localize_script( 'covidadminratelist', 'covidAdminRateList', array(
			'ajaxurl' => admin_url('admin-ajax.php'),
			'nonce' => wp_create_nonce( 'covid-admin-rate-list' ) // Create nonce which we later will use to verify AJAX request
        ));


	}

	//Выводим список бланков
	public function covid_rate_list() {

		if( empty( $_POST['nonce'] ) ){
			wp_die('', '', 400);
		}
	
		check_ajax_referer( 'covid-admin-rate-list', 'nonce', true );

		if( current_user_can('covid_import') ){

            $company_title = $_POST['company_title'];
            $blank_title = $_POST['blank_title'];
            $franchise = $_POST['franchise'];
            $validity = $_POST['validity'];
            $sum = $_POST['sum'];
//            $location = $_POST['location'];
            $count = $_POST['count'];
            $page = $_POST['page'];

            $rates_limit_from = ($page - 1) * $count;

            $rates_sort = $this->rates_sort( $company_title, $blank_title, $franchise, $validity, $sum );

            $rates_count = count($rates_sort);

            
            $paginations = $this->get_paginations( $rates_count, $count, $page );

            $rates_sort = $this->rates_sort( $company_title, $blank_title, $franchise, $validity, $sum, $rates_limit_from, $count );
            
            $rates = $this->rates_render( $rates_sort, $page, $count );

            $page = $rates_count/$count;
		    $pages = ceil( $page );

            if( ! empty( $rates ) ){
                $message = 'По вашому запиту знайдено результатiв: '. $rates_count .'.';
            }
            else{
                $message = 'По вашому запиту результатiв не знайдено.';
            }

            $type = gettype($validity);

            $result = array(
                'rates' => $rates,
                'paginations' => $paginations['result'],
                'pages' => $pages,
                'validity' => $type,
                'rates_count' => $rates_count,
                'message' => $message,
            );

            echo json_encode($result);

		}

		wp_die();

	}

    

    public function import() {

        add_action('admin_post_nopriv_admin_rate_import', array( $this, 'covid_rate_import' ));
        add_action('admin_post_admin_rate_import', array( $this, 'covid_rate_import' ));

    }

    public function covid_rate_import_js() {

//		wp_enqueue_script( 'covidadminrateimport', PLUGIN_URL . 'admin/js/covid-admin-rate-import.js', array('jquery'), $this->version );
		wp_enqueue_script( 'covidadminrateimport', plugins_url( 'js/covid-admin-rate-import.js', dirname(__FILE__) ) , array('jquery'), $this->version );

		wp_localize_script( 'covidadminrateimport', 'covidAdminRateImport', array(
			'ajaxurl' => admin_url('admin-ajax.php'),
			'nonce' => wp_create_nonce( 'covid-admin-rate-import' ) // Create nonce which we later will use to verify AJAX request
        ));
        

    }
    
    public function covid_rate_upload_db ( $rows, $balnk_type_id = 1 ){
        
        //Проверяем права пользователя, если админ то идем дальше
        if( current_user_can('covid_import') ){

            global $wpdb;

            $blank_name = $_POST['blank_name'];

            $table_name = $wpdb->get_blog_prefix() . 'covid_rate';
            
            foreach( $rows as $row ){

                $res = $wpdb->insert( $table_name, array( 
                    'franchise' => $row['franchise'], 
                    'validity' => $row['validity'], 
                    'insured_sum' => $row['insured_sum'], 
                    'price' => $row['price'], 
//                    'locations'=> $row['locations'],
                    'company_id' => $row['company_id'], 
                    'program_id'=> $row['program_id'],
                ), 
                    array( '%s', '%s', '%s', '%f', '%d', '%d' ));

            }

            $message = 'Данi завантажено';

            return $message;
        }
                
    }

    public function covid_rate_update_db ( $rows, $blank_type_id = 1 ){
        
        //Проверяем права пользователя, если админ то идем дальше
        if( current_user_can('covid_import') ){

            global $wpdb;

            $blank_name = $_POST['blank_name'];

            $table_name = $wpdb->get_blog_prefix() . 'covid_rate';
            
            foreach( $rows as $row ){
                
                $res = $wpdb->update( $table_name, array( 'price' => $row['price'] ), array( 'id' => $row['id'] ) );

            }

            $message = 'Данi завантажено';

            return $message;
        }
                
    }

	//Импорт тарифов
	public function covid_rate_import() {

        $message = array();

        //Проверяем NONCE код
        if( wp_verify_nonce( $_POST['fileup_nonce'], 'form_rate_file_upload' ) ){
            
            if ( ! function_exists( 'wp_handle_upload' ) ){
                require_once( ABSPATH . 'wp-admin/includes/file.php' );
            }

            //Получаем ID Компании и бланка
            $company_id = $_POST['rate_company'];
            $program_id = $_POST['rate_blank'];
            $blank_type_id = $_POST['blank_type'];

            $file = & $_FILES['rate_import_file'];
            $file['name'] = time(). '.xlsx';
            
            $overrides = array(
                'test_form' => false,
            );

            add_filter( 'upload_dir', array( $this, 'change_upload_dir_url' ) );

            $movefile = wp_handle_upload( $file, $overrides );

            remove_filter( 'upload_dir', array( $this, 'change_upload_dir_url' ) );

            //Проверяем бы ли файл сохранен
            if ( $movefile && empty($movefile['error']) ) {

                $file_url = $movefile['file'];
                
                //Чтение Excel файла
                $spreadsheet = PhpOffice\PhpSpreadsheet\IOFactory::load( $file_url );
                $worksheet = $spreadsheet->getActiveSheet();
                $rows = [];
                foreach ($worksheet->getRowIterator() AS $row) {
                    $cellIterator = $row->getCellIterator();
                    $cellIterator->setIterateOnlyExistingCells(FALSE); // This loops through all cells,
                    $cells = [];
                    foreach ($cellIterator as $cell) {
                        $cells[] = $cell->getValue();
                    }
                    $rows[] = $cells;
                }

                //Формируем массив для добавления в БД
                $results = array();
                foreach( $rows as $row ){

                    $results[] = array(
                        'franchise' => $row['0'], 
                        'validity' => $row['1'], 
                        'insured_sum' => $row['2'], 
                        'price' => $row['3'], 
//                        'locations'=> $row['4'],
                        'company_id' => $company_id, 
                        'program_id'=> $program_id 
                    );

                }

                $tmp_results = $results;
                $excell_array = array();

                //Убираем лишние поля и обьединяем в строку
                foreach( $tmp_results as $tmp_result ){
                    array_splice( $tmp_result, 3, 1 );
                    array_splice( $tmp_result, 3, 2 );
                    $excell_array[] = implode( '', $tmp_result );
                }



                //Получаем все Бланки с БД
                $all_rates_from_db = $this->get_all_rates_for_upload( $company_id, $program_id );
                $all_rates_from_db_new = array();
                //Убираем лишние поля и обьединяем в строку
                foreach( $all_rates_from_db as $all_rate_from_db ){
                    array_splice( $all_rate_from_db, 0, 1 );
                    $all_rates_from_db_new[] = implode( '', $all_rate_from_db );

                }






                $result_upload = array();

                $update = array();
                $update_value = array();

                foreach( $excell_array as $k => $v ){
                    //Проверяем есть ли в массиве искомы массив
                    //Если да, то заносим его
                    if ( in_array( $v, $all_rates_from_db_new )){

                        $update[] = array_keys( $all_rates_from_db_new, $v );
                        $upldate_value[] = $tmp_results[$k]['price'];
                        
                    }
                    else{
                        $result_upload[] = $tmp_results[$k];
                    }
                }

                $result_update = array();

                //Формируем массив для обновления в БД
                foreach( $update as $upd_k => $upd_v ){
                    $result_update[] = array(
                        'id' => (int)$all_rates_from_db[$upd_v[0]]['id'],
                        'price' => floatval( $upldate_value[$upd_k])
                    );
                }
                
                //Заносим результат в БД
                $result = $this->covid_rate_upload_db( $result_upload, $blank_type_id );
                

                //Обновляем "Цену" Тарифа в БД
                $this->covid_rate_update_db( $result_update, $blank_type_id );
                
            } else {
                $message[] = "Возможны атаки при загрузке файла!\n";
            }
		          
        }
        else{
            $message[] = 'NONCE не подходит';
        }

        $redirect = home_url();
        if (isset($_POST['redirect'])) {
            $redirect = $_POST['redirect'];
            $redirect = wp_validate_redirect($redirect, home_url());
        }

        wp_redirect($redirect);
        return $message;
        
        die();
        
    }

    //Изменяем директорию расположения файла
    public function change_upload_dir_url( $dirs ) {
        $dirs['subdir'] = '/files/xls';
        $dirs['path'] = $dirs['basedir'] . '/files/xls';
        $dirs['url'] = $dirs['baseurl'] . '/files/xls';
    
        return $dirs;
    }

    /*
    *   Получаем все тарифы
    *   return ARRAY 
    */
    public function get_rates( $limit_from = 0, $offset = 99999999) {

        global $wpdb;

        $table_name_rate = $wpdb->get_blog_prefix() . 'covid_rate';
        $table_name_program = $wpdb->get_blog_prefix() . 'covid_program';
        $table_name_company = $wpdb->get_blog_prefix() . 'covid_company';

		$results = $wpdb->get_results( $wpdb->prepare("SELECT ir.id, ir.franchise, ir.validity, ir.insured_sum, ir.price, ic.title as commpany_title, ib.title as blank_title 
        FROM " . $table_name_rate . " ir 
        left join " . $table_name_company . " ic on ic.id = ir.company_id 
        left join " . $table_name_program . " ib on ib.id = ir.program_id 
        ORDER BY ir.id DESC LIMIT " . $limit_from . ", " . $offset . " ", '%d', '%d', '%d' ), ARRAY_A );


        // ORDER BY ir.id DESC", '%d' ), ARRAY_A );
        return $results;

    }

    /*
    *   Получаем все франшизы
    *   return ARRAY 
    */
    public function get_franchise() {

        global $wpdb;

        $table_name_rate = $wpdb->get_blog_prefix() . 'covid_rate';

		$results = $wpdb->get_results( $wpdb->prepare("SELECT franchise
        FROM " . $table_name_rate . " GROUP BY franchise", '%s' ), ARRAY_A );

        return $results;

    }

    /*
    *   Получаем все Сроки действия
    *   return ARRAY 
    */
    public function get_validity() {

        global $wpdb;

        $table_name_rate = $wpdb->get_blog_prefix() . 'covid_rate';

		$results = $wpdb->get_results( $wpdb->prepare("SELECT validity
        FROM " . $table_name_rate . " GROUP BY validity", '%s' ), ARRAY_A );

        return $results;

    }

    /*
    *   Получаем все Страховые суммы
    *   return ARRAY 
    */
    public function get_insured_sum() {

        global $wpdb;

        $table_name_rate = $wpdb->get_blog_prefix() . 'covid_rate';

		$results = $wpdb->get_results( $wpdb->prepare("SELECT insured_sum
        FROM " . $table_name_rate . " GROUP BY insured_sum", '%s' ), ARRAY_A );

        return $results;

    }

    /*
    *   Получаем все Територии действия
    *   return ARRAY 
    */
    public function get_locations() {

        global $wpdb;

        $table_name_rate = $wpdb->get_blog_prefix() . 'covid_rate';

		$results = $wpdb->get_results( $wpdb->prepare("SELECT locations
        FROM " . $table_name_rate . " GROUP BY locations", '%s' ), ARRAY_A );

        return $results;

    }

    public function get_paginations( $count, $offset, $current_page = 1 ) {

        $page = $count/$offset;
        $page_count = ceil( $page );

        $paginations = '<ul>';
        
        for( $i = 1; $i <= $page_count; $i++){

            if( $i == $current_page ){
                $paginations .= '<li class="active-page js-active-page"><button class="" data-page="' . $i . '">' . $i . '</button></li>';
            }
            else{
                $paginations .= '<li><button class="" data-page="' . $i . '">' . $i . '</button></li>';
            }

        }


        $paginations .= '</ul>';

        return $paginations = array(
            'page_count' => $page_count,
            'result' => $paginations
        );

    }


    /*
    *   Отрисовываем Тарифы
    *   return HTML 
    */
    public function rates_render( $rates, $page = 1, $count = 10  ) {

        $result = '';

        $page = $page - 1;        

        if( !empty( $rates ) ){
            $i = 1;
            foreach( $rates as $rate ){
                $numb = $page*$count+$i;
                $result .= '<tr>';
                $result .= '<td>' . $numb . '</td>';
                $result .= '<td>' . $rate['id'] . '</td>';
                $result .= '<td>' . $rate['commpany_title'] . '</td>';
                $result .= '<td>' . $rate['franchise'] . '</td>';
                $result .= '<td>' . $rate['validity'] . '</td>';
                $result .= '<td>' . $rate['insured_sum'] . '</td>';
                $result .= '<td>' . $rate['price'] . '</td>';
                $result .= '<td>' . $rate['blank_title'] . '</td>';
                // $result .= '<td><button class="button button-primary button-large js-delete-rate" data-id="' . $rate['id'] . '"><i class="fa fa-trash"></i></button></td>';
                $result .= '<td class="text-center manage-column"><span class="delete-agree">Ви впевненi? 
                <span><button class="button button-primary button-small js-delete-rate" data-id="'. $rate['id'] .'">Так</button><button class="button button-primary button-small js-remove-btn-cancel">Нi</button></span>
                </span>
                <button class="button button-primary button-large js-remove-btn"><i class="fa fa-trash"></i></button></td>';
                $result .= '</tr>';

                $i ++;
            }

        }
        
        return $result;
    }

    /*
    *   Сортируем Тарифы
    *   return ARRAY 
    */
    public function rates_sort( $company_title, $blank_title, $franchise, $validity, $sum, $rates_limit_from = 0, $offset = 999999 ) {

        empty( $company_title ) ? $company_title = "" : $company_title = "ir.company_id = '". $company_title . "'";
        // empty( $blank_title ) ? $blank_title = "" : $blank_title = "blank_id = '". $blank_title . "'";
        empty( $blank_title ) ? $blank_title = "" : $blank_title = "program_id = '". $blank_title . "'";
        empty( $franchise ) ? $franchise = "" : $franchise = "franchise = '". $franchise . "'";
        empty( $validity ) ? $validity = "" : $validity = "validity = '". $validity . "'";
        empty( $sum ) ? $sum = "" : $sum = "insured_sum = '". $sum . "'";
//        empty( $location ) ? $location = "" : $location = "locations = '". $location . "'";

        $where = '';

//        if( $company_title || $blank_title || $franchise || $validity || $sum || $location ){
        if( $company_title || $blank_title || $franchise || $validity || $sum  ){

            $where = "WHERE ";

            if ( strlen( $company_title ) > 0 ) {
                $where .= $company_title . " AND ";
            }
            if ( strlen( $blank_title ) > 0 ) {
                $where .= $blank_title . " AND ";
            }
            if ( strlen( $franchise ) > 0 ) {
                $where .= $franchise . " AND ";
            }
            if ( strlen( $validity ) > 0 ) {
                $where .= $validity . " AND ";
            }
            if ( strlen( $sum ) > 0 ) {
                $where .= $sum . " AND ";
            }
//            if ( strlen( $location ) > 0 ) {
//                $where .= $location . " AND ";
//            }

            $where = substr( $where, 0, - 5 );

        }

        global $wpdb;

        $table_name_rate = $wpdb->get_blog_prefix() . 'covid_rate';
        $table_name_program = $wpdb->get_blog_prefix() . 'covid_program';
        $table_name_company = $wpdb->get_blog_prefix() . 'covid_company';

        // $results = $wpdb->get_results( $wpdb->prepare("SELECT * FROM ". $table_name_rate ." WHERE validity = '". $validity ."'", '%s' ), ARRAY_A );
		$results = $wpdb->get_results( "SELECT ir.id, ir.franchise, ir.validity, ir.insured_sum, ir.price, ic.title as commpany_title, ib.title as blank_title 
        FROM ". $table_name_rate ." ir 
        left join " . $table_name_company . " ic on ic.id = ir.company_id 
        left join " . $table_name_program . " ib on ib.id = ir.program_id  ". $where ." ORDER BY ir.id DESC LIMIT " . $rates_limit_from . ", " . $offset . " ", ARRAY_A );

        return $results;

    }

    public function remove_rate( $id ) {
	
		// проверим возможность
		if( current_user_can('covid_import') ){

			global $wpdb;

			// $id = $_POST['id'];

			$table_name = $wpdb->get_blog_prefix() . 'covid_rate';
		
			$res = $wpdb->delete( $table_name, array( 'id'=> $id ), array( '%d' ) );
			// return $product;
	
			$result = array(
				'message' => "Тариф був успiшно видалений.",
				'rate_id' => $id,
				'status' => 1,
			);
		}
		else{
	
			$result = array(
				'message' => "Недостатньо прав.",
				'status' => 0,
			);
		}
	
        return $result;
	
		wp_die();

    }


    /*
    *   Получаем все тарифы для загрузки в БД
    *   return ARRAY 
    */
    public function get_all_rates_for_upload( $company_id, $program_id ) {
        // public function get_rates() {

        global $wpdb;

        $table_name_rate = $wpdb->get_blog_prefix() . 'covid_rate';
        $table_name_blank = $wpdb->get_blog_prefix() . 'covid_program';
        $table_name_company = $wpdb->get_blog_prefix() . 'covid_company';

		$results = $wpdb->get_results( $wpdb->prepare("SELECT id, franchise, validity, insured_sum  
        FROM " . $table_name_rate . " WHERE company_id = " . (int)$company_id . " AND program_id = " . (int)$program_id . "  ORDER BY id ASC", '%d', '%d' ), ARRAY_A );

        return $results;
    }


    //Поиск в массиве
    public function array_recursive_search_key_map($needle, $haystack) {
        foreach($haystack as $first_level_key=>$value) {
            if ($needle === $value) {
                return array($first_level_key);
            } elseif (is_array($value)) {
                $callback = $this->array_recursive_search_key_map($needle, $value);
                if ($callback) {
                    return array_merge(array($first_level_key), $callback);
                }
            }
        }
        return false;
    }
}

?>