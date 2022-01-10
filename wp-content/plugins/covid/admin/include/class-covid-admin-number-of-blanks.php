<?php

class Covid_Admin_Number_Of_Blanks {


    public function __construct() {      

	}
	
	private $version;

    public function run( $plugin_name, $version ) {

		$this->version = $version;
		$page = 'toplevel_page_covid';

        // JS добавление нумераций БЛАНКОВ
//		add_action('admin_head', array($this, 'covid_add_number_of_blank_to_manager_js'));
//        add_action( 'admin_print_scripts-covid_page_covid-blank-to-manager', array( $this, 'covid_add_number_of_blank_to_manager_js' ) );
        add_action( 'admin_print_scripts-covid_page_covid-number-of-blank', array( $this, 'covid_add_number_of_blank_to_manager_js' ) );

        add_action('wp_ajax_covidadmingetmanagerofblank', array($this, 'get_manager_of_blank'));
        add_action('wp_ajax_nopriv_covidadmingetmanagerofblank', array($this, 'get_manager_of_blank'));

		// JS добавление нумераций БЛАНКОВ
//            add_action( 'admin_head', array( $this, 'covid_add_number_of_blanks_js' ) );

        add_action( 'admin_print_scripts-covid_page_covid-number-of-blank', array( $this, 'covid_add_number_of_blanks_js' ) );


		//Экшн Вывода Бланков От и ДО 
		add_action( 'wp_ajax_covidaddnumberofblanks', array( $this, 'covid_add_number_of_blanks' ) );
		add_action( 'wp_ajax_nopriv_covidaddnumberofblanks', array( $this, 'covid_add_number_of_blanks' ) );

		// JS Удаление нумераций БЛАНКОВ
//		add_action( 'admin_head', array( $this, 'covid_remove_number_of_blanks_js' ) );
//        add_action( 'admin_print_scripts-covid_page_covid-number-of-blank', array( $this, 'covid_remove_number_of_blanks_js' ) );
        add_action( 'admin_print_scripts-covid_page_covid-number-of-blank', array( $this, 'covid_remove_number_of_blanks_js' ) );

		//Экшн Удаления Бланков От и ДО 
		add_action( 'wp_ajax_covidadminremovenumberofblanks', array( $this, 'covid_remove_number_of_blanks' ) );
		add_action( 'wp_ajax_nopriv_covidadminremovenumberofblanks', array( $this, 'covid_remove_number_of_blanks' ) );


		// JS Фильтр нумераций БЛАНКОВ
//		add_action( 'admin_head', array( $this, 'covid_filter_number_of_blanks_js' ) );
        add_action( 'admin_print_scripts-covid_page_covid-number-of-blank', array( $this, 'covid_filter_number_of_blanks_js' ) );

		//Экшн Фильтр Бланков От и ДО 
		add_action( 'wp_ajax_covidadminfilternumberofblanks', array( $this, 'covid_filter_number_of_blanks' ) );
		add_action( 'wp_ajax_nopriv_covidadminfilternumberofblanks', array( $this, 'covid_filter_number_of_blanks' ) );
    }


    public function covid_add_number_of_blank_to_manager_js()
    {
//		wp_enqueue_script('covidadminaddblanktomanager', PLUGIN_URL . 'admin/js/covid-admin-add-blank_to_manager.js', array('jquery'), $this->version);
//        wp_enqueue_script('covidadminaddblanktomanager',  plugins_url( 'js/covid-admin-add-blank_to_manager.js', dirname(__FILE__) ), array('jquery'), $this->version);
        wp_enqueue_script('covidadminaddblanktomanager',  plugins_url( 'js/covid-admin-get-blank_to_manager.js', dirname(__FILE__) ), array('jquery'), $this->version);

        wp_localize_script('covidadminaddblanktomanager', 'covidAdminGetBlankToManager', array(
            'ajaxurl' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('covid-admin-get-blank-to-manager') // Create nonce which we later will use to verify AJAX request
        ));
    }

    //Редактирование бланков
	public function covid_add_number_of_blanks_js() {

//		wp_enqueue_script( 'covidadminaddnumberofblanks', PLUGIN_URL . 'admin/js/covid-admin-add-number-of-blanks.js', array('jquery'), $this->version );
//		wp_enqueue_script( 'covidadmingetblanktomanager', plugins_url( 'js/covid-admin-add-number-of-blanks.js', dirname(__FILE__) ), array('jquery'), $this->version );
		wp_enqueue_script( 'covidadminaddnumberofblanks', plugins_url( 'js/covid-admin-add-number-of-blanks.js', dirname(__FILE__) ), array('jquery'), $this->version );

		wp_localize_script( 'covidadminaddnumberofblanks', 'covidAdminAddNumberOfBlanks', array(
			'ajaxurl' => admin_url('admin-ajax.php'),
			'nonce' => wp_create_nonce( 'covid-admin-add-number-of-blanks' ) // Create nonce which we later will use to verify AJAX request
		));

	}

    public function get_manager_of_blank()
    {
        if (empty($_POST['nonce'])) {
            wp_die('', '', 400);
        }

        global $wpdb;
        $table_number_of_blank = $wpdb->get_blog_prefix() . 'covid_number_of_blank';
        $blank_id = $wpdb->get_results($wpdb->prepare("SELECT id FROM " . $table_number_of_blank . " WHERE company_id = %d AND status = 1 AND blank_series = %s AND number_start <= %d AND number_end >= %d", $_POST['company_id'], $_POST['blank_series'], $_POST['blank_number'], $_POST['blank_number']), ARRAY_A);

        if (!empty($blank_id)) {
            $table_blank_to_manager = $wpdb->get_blog_prefix() . 'covid_blank_to_manager';
            $manager_id = $wpdb->get_results($wpdb->prepare("SELECT `manager_id` FROM " . $table_blank_to_manager . " WHERE `number_of_blank_id` = %d AND status = 1 AND number_start <= %d AND number_end >= %d", $blank_id[0]['id'], $_POST['blank_number'], $_POST['blank_number']), ARRAY_A);

            if (!empty($manager_id)) {
                $table_orders = $wpdb->get_blog_prefix() . 'covid_orders';
                $table_statuses = $wpdb->get_blog_prefix() . 'covid_statuses';
                $order_status = $wpdb->get_results($wpdb->prepare("SELECT S.text as text FROM ".$table_orders." AS O INNER JOIN ".$table_statuses." AS S ON O.status = S.id WHERE O.`blank_number` = %d AND O.`blank_series` = %s AND O.`company_id` = %d ORDER BY O.ID DESC", $_POST['blank_number'], $_POST['blank_series'], $_POST['company_id']), ARRAY_A);
                $status = !empty($order_status) ? $order_status[0]["text"] : "Вільний";

                echo json_encode(['status' => 'ok', "message" => "Бланк закріплений за менеджером - <a target='_blank' href='" . admin_url( 'admin.php?page=covid-blank-to-manager&managerid='.$manager_id[0]["manager_id"] ) . "'>" . $this->km_get_users_name($manager_id[0]['manager_id'])['name']."</a>. Cтатус бланку - <strong>".$status."</strong>"]);
//                echo \GuzzleHttp\json_encode(['status' => 'ok', "message" => "Бланк закріплений за менеджером - <a target='_blank' href='" . admin_url( 'admin.php?page=covid-blank-to-manager&managerid='.$manager_id[0]["manager_id"] ) . "'>" . $this->km_get_users_name($manager_id[0]['manager_id'])['name']."</a>. Cтатус бланку - <strong>".$status."</strong>"]);
            } else {
                echo json_encode(['status' => 'error',
                    'message' => 'Бланк не закріплений за менеджером',
                    //'sqlFirst' => "SELECT id FROM " . $table_number_of_blank . " WHERE company_id = ".$_POST['company_id']." AND blank_series = ".$_POST['blank_series']." AND number_start <= ".$_POST['blank_number']." AND number_end >= ".$_POST['blank_number'],
                    //'sqlSecond' => "SELECT `manager_id` FROM " . $table_blank_to_manager . " WHERE `number_of_blank_id` = ".$blank_id[0]['id']." AND number_start <= ".$_POST['blank_number']." AND number_end >= ".$_POST['blank_number']
                ]);

                /*echo \GuzzleHttp\json_encode(['status' => 'error',
                    'message' => 'Бланк не закріплений за менеджером',
                    //'sqlFirst' => "SELECT id FROM " . $table_number_of_blank . " WHERE company_id = ".$_POST['company_id']." AND blank_series = ".$_POST['blank_series']." AND number_start <= ".$_POST['blank_number']." AND number_end >= ".$_POST['blank_number'],
                    //'sqlSecond' => "SELECT `manager_id` FROM " . $table_blank_to_manager . " WHERE `number_of_blank_id` = ".$blank_id[0]['id']." AND number_start <= ".$_POST['blank_number']." AND number_end >= ".$_POST['blank_number']
                ]);*/
            }
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Не знайдено даного бланку']);
//            echo \GuzzleHttp\json_encode(['status' => 'error', 'message' => 'Не знайдено даного бланку']);
        }
        wp_die();
    }


	public function covid_add_number_of_blanks() {

		if( empty( $_POST['nonce'] ) ){
			wp_die('', '', 400);
		}
	
		check_ajax_referer( 'covid-admin-add-number-of-blanks', 'nonce', true );
	
	
		// проверим возможность
		if( current_user_can('covid_number_of_blanks') ){

            global $wpdb;

//            $blank_type_id = (int)$_POST['blank_type_id'];
			$company_id = (int)$_POST['company_id'];
			$blank_series = $_POST['blank_series'];
            $blank_number_start = (int)$_POST['blank_number_start'];
            $blank_number_end = (int)$_POST['blank_number_end'];
			$blank_comments = $_POST['blank_comments'];


			$table_name = $wpdb->get_blog_prefix() . 'covid_number_of_blank';
		
			$query_result = $wpdb->insert( $table_name, 
			array( 
				'number_start' => $blank_number_start, 
				'number_end' => $blank_number_end,
				'blank_series' => $blank_series, 
				'company_id' => $company_id, 
				'comments' => $blank_comments,
//				'blank_type_id' => $blank_type_id,
				'status' => 1 
			), 
			array( '%d', '%d', '%s', '%d', '%s', '%d' ));




			                        
            if( $query_result ){

                //для поиска по ТАБЛИЧКИ ЭЛЕКТРОННЫХ
                $new_blank_diapason = $wpdb->insert_id;

                $i = $blank_number_start;
                while( $i <= $blank_number_end )
                {
                    $this->set_blnak_number_to_covid_e_blank_number_list($i, $new_blank_diapason);
                    $i++;
                }




                $blanks = $this->getNumberOfBlanks();
                $blanks_render = $this->render_number_of_blank( $blanks );

                $result = array(
                    'message' => "Нумерацію бланків успішно добавлено.",
                    'status' => 1,
                    'blanks' => $blanks_render
                );
            }
            else{
                $result = array(
                    'message' => "Нічого не добавлено.",
                    'status' => 0,
                );
            }
			

        }
        else{
            $result = array(
				'message' => "Недостатньо прав.",
				'status' => 0,
			);
        }

        echo json_encode($result);

		wp_die();

    }
    
    /*
	* Получаем все бланки " Бланк ОТ" и "Бланк ДО"
	* return ARRAY
	*/

	public function getNumberOfBlanks() {
		$results = array();
		global $wpdb;

		$table_name_number_of_blank = $wpdb->get_blog_prefix() . 'covid_number_of_blank';
		$table_name_company = $wpdb->get_blog_prefix() . 'covid_company';
		$table_name_blank_type = $wpdb->get_blog_prefix() . 'covid_blank_type';

		$results = $wpdb->get_results( "SELECT nob.id, nob.company_id, c.title AS company_title, nob.blank_series, nob.number_start, nob.number_end, nob.comments, DATE_FORMAT(nob.date_added,'%d.%m.%y') AS date_added  FROM " . $table_name_number_of_blank . " nob
		left join " . $table_name_company . " c ON c.status = 1 AND c.id = nob.company_id 
		WHERE nob.status = 1 ORDER BY nob.id DESC;", ARRAY_A );
		
		return $results;


	}

	public function getUniqueBlankSeries(){
		$results = array();

		global $wpdb;
		$table_name_number_of_blank = $wpdb->get_blog_prefix() . 'covid_number_of_blank';

		$results = $wpdb->get_results( "SELECT `company_id`, `blank_series` FROM `".$table_name_number_of_blank."` WHERE `status` = 1 GROUP BY `company_id`, `blank_series`", ARRAY_A );

		return $results;
	}


	/*
	*	Вывод всей "Нумерации бланков"
	*	return HTML
	*/	

	public function render_number_of_blank( $blanks = 0 ) {

		$render = '';

		$render .= $this->render_number_of_blank_filter();

		$render .= '<h2>Всi бланки</h2>
			<table class="wp-list-table widefat fixed striped posts">
			<thead>
			<th class="manage-column table-30">№</th>
			<th class="manage-column table-30">ID</th>
			<th class="manage-column table-120 text-center">Назва компанії</th>
			<th class="manage-column table-70 text-center">Серія бланка</th>
			<th class="manage-column table-70 text-center">Нумерація від</th>
			<th class="manage-column table-70 text-center">Нумерація до</th>
			<th class="manage-column table-80 text-center">Кількість (шт.)</th>
			<th class="manage-column table-100 text-center">Коментар</th>
			<th class="manage-column table-80 text-center">Дата</th>
			<th class="manage-column table-100 text-center">Управлiння</th>
			</thead>
			<tbody>';
		$i = 1;
		foreach( $blanks as $blank ){
			
			$render .= '<tr>
			<td>' . $i . '</td><td>' . $blank['id'] . '</td>
			<td>' . $blank['company_title'] . '</td>
			<td>' . $blank['blank_series'] . '</td>
			<td class="text-center">' . $blank['number_start'] . '</td>
			<td class="text-center">' . $blank['number_end'] . '</td>
			<td class="text-center">' . ( $blank['number_end'] - $blank['number_start']  + 1) . '</td>
			<td class="text-center">' . $blank['comments'] . '</td>
			<td class="text-center">' . $blank['date_added'] . '</td>
			<td class="text-center manage-column">
			<span class="delete-agree">Ви впевненi? 
			<span><button class="button button-primary button-small js-remove-number-of-blanks" data-id="'. $blank['id'] .'">Так</button><button class="button button-primary button-small js-remove-btn-cancel">Нi</button></span>
			</span>
			<button class="button button-primary button-large js-remove-btn"><i class="fa fa-trash"></i></button>
			</td>
			</tr>';
			$i ++;
			
		}

		$render .= '</tbody></table>';

		return $render;

	}

	/*
	*	Вывод Фильтра "Нумерации бланков"
	*	return HTML
	*/
	public function render_number_of_blank_filter() {

		$all_programs = $this->filterFetBlanks();

		$result = '';

		$result .= '<h2>Фiльтр</h2>';
		$result .= '<div class="covid-form-wrapper"><form action="" method="POST" id="formNumberOfBlank">';
		$result .= '<select name="number_of_blank" id="NumberOfBlank"><option value="">Оберіть компанію</option>';

            foreach ( $all_programs as $program ){
				$result .= '<option value="' . $program['company_id'] . '">' . $program['title'] . '</option>';
			}

		$result .= '</select>';

		$result .= '<input type="submit" id="sbmtNumberOfBlank" value="Фiльтрувати" class="btn-m-l btn-1 button button-primary button-large"><button class="btn-m-l button button-primary button-large" id="resetNumberOfBlank">Очистити фiльтр</button>';

		$result .= '</form><div class="clear"></div></div>';

		return $result;

	}


	//Редактирование бланков
	public function covid_remove_number_of_blanks_js() {

//		wp_enqueue_script( 'covidadminremovenumberofblanks', PLUGIN_URL . 'admin/js/covid-admin-remove-number-of-blanks.js', array('jquery'), $this->version );
		wp_enqueue_script( 'covidadminremovenumberofblanks', plugins_url( 'js/covid-admin-remove-number-of-blanks.js', dirname(__FILE__) ), array('jquery'), $this->version );


		wp_localize_script( 'covidadminremovenumberofblanks', 'covidAdminRemoveNumberOfBlanks', array(
			'ajaxurl' => admin_url('admin-ajax.php'),
			'nonce' => wp_create_nonce( 'covid-admin-remove-number-of-blanks' ) // Create nonce which we later will use to verify AJAX request
		));

	}

	public function covid_remove_number_of_blanks() {

		if( empty( $_POST['nonce'] ) ){
			wp_die('', '', 400);
		}
	
		check_ajax_referer( 'covid-admin-remove-number-of-blanks', 'nonce', true );
	
	
		// проверим возможность
		if( current_user_can('covid_number_of_blanks') ){

			global $wpdb;

			$id = $_POST['id'];

			$table_name = $wpdb->get_blog_prefix() . 'covid_number_of_blank';
		
			$res = $wpdb->update( $table_name, array( 'status' => 0 ), array( 'id' => $id ));

			if( $res ){

                //для поиска по ТАБЛИЧКИ ЭЛЕКТРОННЫХ
                $this->change_status_e_blank_number($id);


                $blanks = $this->getNumberOfBlanks();
                $blanks_render = $this->render_number_of_blank( $blanks );

                $result = array(
                    'message' => "Нумерацію бланків успішно видалено.",
                    'status' => 1,
                    'blanks' => $blanks_render
                );
            }
            else{
                $result = array(
                    'message' => '<span class="color-red">Нічого не видалено!.</span>',
                    'status' => 0,
                );
            }

        }
        else{
            $result = array(
				'message' => '<span class="color-red">Недостатньо прав.</span>',
				'status' => 0,
			);
        }

        echo json_encode($result);

		wp_die();

	}
	

	//Редактирование бланков
	public function covid_filter_number_of_blanks_js() {

//		wp_enqueue_script( 'covidadminfilternumberofblanks', PLUGIN_URL . 'admin/js/covid-admin-filter-number-of-blanks.js', array('jquery'), $this->version );
		wp_enqueue_script( 'covidadminfilternumberofblanks', plugins_url( 'js/covid-admin-filter-number-of-blanks.js', dirname(__FILE__) ), array('jquery'), $this->version );

		wp_localize_script( 'covidadminfilternumberofblanks', 'covidAdminFilterNumberOfBlanks', array(
			'ajaxurl' => admin_url('admin-ajax.php'),
			'nonce' => wp_create_nonce( 'covid-admin-filter-number-of-blanks' ) // Create nonce which we later will use to verify AJAX request
		));

	}

	public function covid_filter_number_of_blanks() {

		if( empty( $_POST['nonce'] ) ){
			wp_die('', '', 400);
		}
	
		check_ajax_referer( 'covid-admin-filter-number-of-blanks', 'nonce', true );
	
	
		// проверим возможность
		if( current_user_can('covid_number_of_blanks') ){
			global $wpdb;

			$id = $_POST['blank_id'];

			$table_name = $wpdb->get_blog_prefix() . 'covid_number_of_blank';
			$table_name_company = $wpdb->get_blog_prefix() . 'covid_company';

			if( $id != 0 ){
				$blanks = $wpdb->get_results("SELECT nob.id, c.title AS company_title, nob.number_start, nob.number_end, nob.blank_series, nob.comments 
				FROM " . $table_name . " nob
				left join " . $table_name_company . " c ON c.status = 1 AND c.id = ".$id." AND c.id = nob.company_id 
				WHERE nob.company_id = $id AND nob.status = 1 ORDER BY nob.id DESC", ARRAY_A );
			}
			else{
				$blanks = $wpdb->get_results("SELECT nob.id, c.title AS company_title, nob.number_start, nob.number_end, nob.blank_series, nob.comments 
				FROM " . $table_name . " nob
				left join " . $table_name_company . " c ON c.status = 1 AND c.id = nob.company_id 
				WHERE nob.status = 1 ORDER BY nob.id DESC", ARRAY_A );
			}


			if( $blanks ){


                // $blanks = $this->getNumberOfBlanks();
                $blanks_render = $this->render_number_of_blank( $blanks );

                $result = array(
                    'message' => "Нумерацію бланків успішно вiдфiльтровано.",
                    'status' => 1,
					'blanks' => $blanks_render,
					'id' => $id
                );
            }
            else{
                $result = array(
                    'message' => '<span class="color-red">Нічого не знайдено!.</span>',
					'status' => 0,
					'id' => $id
                );
            }

        }
        else{
            $result = array(
				'message' => '<span class="color-red">Недостатньо прав.</span>',
				'status' => 0,
			);
        }

        echo json_encode($result);

		wp_die();

	}
	
	public function filterFetBlanks() {

		global $wpdb;

		$id = $_POST['blank_id'];

		$table_name = $wpdb->get_blog_prefix() . 'covid_number_of_blank';
		$table_name_company = $wpdb->get_blog_prefix() . 'covid_company';

		$result = $wpdb->get_results("SELECT DISTINCT nob.company_id, b.title FROM " . $table_name . " nob
		left join " . $table_name_company . " as b ON b.id = nob.company_id WHERE nob.status = 1
		ORDER BY nob.id DESC", ARRAY_A );

		return $result;
	}

    /*
     * Вставляем нумерацию ЭЛЕКТРОННЫХ бланков
     * */
    private function set_blnak_number_to_covid_e_blank_number_list($blank_number, $number_of_blank_id)
    {

        global $wpdb;

        $table_name = $wpdb->get_blog_prefix() . 'covid_e_blank_number_list';
        $wpdb->insert( $table_name,
            [
                'blank_number' => $blank_number,
                'number_of_blank_id' => $number_of_blank_id
            ],
            [
                '%d',
                '%d'
            ] );

    }

    /*
     * Удаление ЭЛЕКТРОННЫХ бланков
     * */

    private function change_status_e_blank_number($number_of_blank_id)
    {
        global $wpdb;
        $table_name = $wpdb->get_blog_prefix() . 'covid_e_blank_number_list';

        $wpdb->update( $table_name,
            [ 'status' => 2 ],
            [ 'number_of_blank_id'=> $number_of_blank_id ],
            [ '%d' ],
            [ '%d' ]
        );

    }

    public function km_get_users_name($user_id = null)
    {
        unset($user_info);
        $user_info = $user_id ? new WP_User($user_id) : wp_get_current_user();

        if ($user_info->first_name) {

            if ($user_info->last_name) {
                return ['id' => $user_id, 'name' => $user_info->first_name . ' ' . $user_info->last_name];
            }

            return ['id' => $user_id, 'name' => $user_info->first_name];
        }

        return ['id' => $user_id, 'name' => $user_info->display_name];
    }

}