<?php

class Covid_Admin_Program {

    public function __construct(  ) {

	}

	private $version;

    public function run( $plugin_name, $version ) {

		$this->version = $version;

        /*
        * Вывод списка бланков 
        */
//        add_action( 'admin_head', array( $this, 'covid_program_list_js' ) );
        add_action( 'admin_print_scripts-toplevel_page_covid', array( $this, 'covid_program_list_js' ) );

		//Экшн Вывода Бланков 
		add_action( 'wp_ajax_covidprogramlist', array( $this, 'covid_program_list' ) );
        add_action( 'wp_ajax_nopriv_covidprogramlist', array( $this, 'covid_program_list' ) );
        


		/*
		*Добавление бланка в БД
		*/
		//JS скрипт обработки добавления Бланков в БД
//		add_action( 'admin_head', array( $this, 'covid_add_program_js' ) );
        add_action( 'admin_print_scripts-toplevel_page_covid', array( $this, 'covid_add_program_js' ) );

		//Экшн добавления Бланков в БД 
		add_action( 'wp_ajax_covidaddprogram', array( $this, 'covid_add_program' ) );
		add_action( 'wp_ajax_nopriv_covidaddprogram', array( $this, 'covid_add_program' ) );



		/*
		*	Удаление бланков с БД
		*	Происходит изменение статуса отображения 1 - показывать, 0 - нет
		*/
		//JS скрипт обработки добавления Бланков в БД
//		add_action( 'admin_head', array( $this, 'covid_delete_program_js' ) );
        add_action( 'admin_print_scripts-toplevel_page_covid', array( $this, 'covid_delete_program_js' ) );

		//Экшн удаления Бланков с БД 
		add_action( 'wp_ajax_coviddeleteprogram', array( $this, 'covid_delete_program' ) );
		add_action( 'wp_ajax_nopriv_coviddeleteprogram', array( $this, 'covid_delete_program' ) );

		/*
		*	Редактирование Бланка
		*/
//		add_action( 'admin_head', array( $this, 'covid_edit_program_js' ) );
        add_action( 'admin_print_scripts-toplevel_page_covid', array( $this, 'covid_edit_program_js' ) );

		//Экшн редактирования Бланков с БД 
		add_action( 'wp_ajax_covideditprogram', array( $this, 'covid_edit_program' ) );
		add_action( 'wp_ajax_nopriv_covideditprogram', array( $this, 'covid_edit_program' ) );
        
    }


    public function covid_add_program_js() {

//		wp_enqueue_script( 'covidadminaddprogram', PLUGIN_URL . 'admin/js/covid-admin-add-program.js', array('jquery'), $this->version );
		wp_enqueue_script( 'covidadminaddprogram', plugins_url( 'js/covid-admin-add-program.js', dirname(__FILE__) ), array('jquery'), $this->version );

		wp_localize_script( 'covidadminaddprogram', 'covidAdminAddProgram', array(
			'ajaxurl' => admin_url('admin-ajax.php'),
			'nonce' => wp_create_nonce( 'covid-admin-add-program' ) // Create nonce which we later will use to verify AJAX request
		));
	}

	public function covid_add_program(){

		if( empty( $_POST['nonce'] ) ){
			wp_die('', '', 400);
		}
	
		check_ajax_referer( 'covid-admin-add-program', 'nonce', true );
	
	
		// проверим возможность
		if( current_user_can('covid_programs') ){

			global $wpdb;

			$program_name = trim( $_POST['program_name'] );

			$program_comments = trim( $_POST['program_comments'] );

			// $program_company_title = $_POST['program_company_title'];

			$table_name = $wpdb->get_blog_prefix() . 'covid_program';

			$status = false;

			$has_program_title = $wpdb->get_results( "SELECT * FROM " . $table_name . " WHERE title LIKE '" . $program_name . "' AND status = 1", ARRAY_A );

			if( is_null( $has_program_title ) || empty( $has_program_title ) ){

				$wpdb->insert( $table_name, array( 'title' => $program_name, 'comments' => $program_comments, 'status' => 1 ), array( '%s', '%s', '%d' ));

				$result = array(
					'message' => '<span style="color: green">Програма успiшно додана.</span>',
					'program_name' => $program_name,
					'status' => 1,
				);

			}
			else{

				$result = array(
					'message' => '<span style="color: red"><b>' . $program_name . '</b> вже iснує. Вкажiть iншу назву.</span>',
					'program_name' => $program_name,
					'status' => 0,
				);


			}
	
			// $result = array(
			// 	'message' => "Програма успiшно додана.",
			// 	'program_name' => $program_name,
			// 	'status' => 1,
			// );
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

	public function load_programs() {

		$programs = $this->get_programs();

		//Выводим список бланков
		$this->render_program_list( $programs );


	}

	public function get_programs() {

		global $wpdb;

		$table_name = $wpdb->get_blog_prefix() . 'covid_program';

		$programs = $wpdb->get_results( $wpdb->prepare("SELECT id, title, comments FROM " . $table_name . " WHERE status = 1 ORDER BY id DESC;", '%d' ) );

		return $programs;

	}

	public function render_program_list( $programs ) {

		if( $programs ){

			$render = '';

			$render .= '<h2>Всi бланки</h2><table class="wp-list-table widefat fixed striped posts"><thead><th class="manage-column table-50">№</th>
                <th class="manage-column table-50">ID</th>
				<th class="manage-column">Назва програми</th>
				<th class="manage-column">Коментар до програми</th>
                <th class="manage-column table-100 text-center">Управлiння</th>
            </thead>
            <tbody>';
			$i = 1;
			foreach( $programs as $program ){

				$render .= '<tr>';
				$render .= '<td>' . $i . '</td>';
				$render .= '<td>' . $program->id . '</td>';
				$render .= '<td>' . $program->title . '</td>';
				$render .= '<td>' . $program->comments . '</td>';
				$render .= '<td class="text-center manage-column"><button class="button button-primary button-large edit-program js-edit-program" data-id="'. $program->id .'" data-program-title="'. $program->title .'" data-program-comments="'. $program->comments .'"><i class="fa fa-edit"></i></button>
				<span class="delete-agree">Ви впевненi? <b class="covid-danger-help"><i class="fa fa-info-circle" aria-hidden="true"></i><small>При видаленні бланку будуть видалені усі серії та нумерації бланків пов`язані з ним.</small> </b> 
				<span><button class="button button-primary button-small js-delete-program" data-id="'. $program->id .'">Так</button><button class="button button-primary button-small js-remove-btn-cancel">Нi</button></span>
				</span>
				<button class="button button-primary button-large js-remove-btn"><i class="fa fa-trash"></i></button>
				</td>';
				$render .= '</tr>';

				$i ++;
				
			}

			$render .= '</tbody></table>';

			return $render;

		}
	}


	public function covid_program_list_js() {

//		wp_enqueue_script( 'covidadminprogramlist', PLUGIN_URL . 'admin/js/covid-admin-program-list.js', array('jquery'), $this->version );
		wp_enqueue_script( 'covidadminprogramlist', plugins_url( 'js/covid-admin-program-list.js', dirname(__FILE__) ), array('jquery'), $this->version );

		wp_localize_script( 'covidadminprogramlist', 'covidAdminProgramList', array(
			'ajaxurl' => admin_url('admin-ajax.php'),
			'nonce' => wp_create_nonce( 'covid-admin-program-list' ) // Create nonce which we later will use to verify AJAX request
        ));
        

	}

	//Выводим список бланков
	public function covid_program_list() {

		if( empty( $_POST['nonce'] ) ){
			wp_die('', '', 400);
		}
	
		check_ajax_referer( 'covid-admin-program-list', 'nonce', true );

		if( current_user_can('covid_programs') ){

			$programs = $this->get_programs();

			$result = $this->render_program_list( $programs );

			echo $result;

		}

		wp_die();

	}

	public function covid_delete_program_js() {

//		wp_enqueue_script( 'covidadmindeleteprogram', PLUGIN_URL . 'admin/js/covid-admin-delete-program.js', array('jquery'), $this->version );
		wp_enqueue_script( 'covidadmindeleteprogram', plugins_url( 'js/covid-admin-delete-program.js', dirname(__FILE__) ), array('jquery'), $this->version );

		wp_localize_script( 'covidadmindeleteprogram', 'covidAdminDeleteProgram', array(
			'ajaxurl' => admin_url('admin-ajax.php'),
			'nonce' => wp_create_nonce( 'covid-admin-delete-program' ) // Create nonce which we later will use to verify AJAX request
		));
	}


	public function covid_delete_program(){

		if( empty( $_POST['nonce'] ) ){
			wp_die('', '', 400);
		}
	
		check_ajax_referer( 'covid-admin-delete-program', 'nonce', true );
	
	
		// проверим возможность
		if( current_user_can('covid_programs') ){

			global $wpdb;

			$id = $_POST['id'];

			$table_name = $wpdb->get_blog_prefix() . 'covid_program';
		
			$res = $wpdb->update( $table_name, array( 'status' => 0 ), array( 'id' => $id ));
			// return $product;
	
			$result = array(
				'message' => "Програма була успiшно видалена.",
				'program_name' => $id,
				'status' => 1,
			);
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


	//Редактирование бланков
	public function covid_edit_program_js() {

//		wp_enqueue_script( 'covidadmineditprogram', PLUGIN_URL . 'admin/js/covid-admin-edit-program.js', array('jquery'), $this->version );
		wp_enqueue_script( 'covidadmineditprogram', plugins_url( 'js/covid-admin-edit-program.js', dirname(__FILE__) ), array('jquery'), $this->version );

		wp_localize_script( 'covidadmineditprogram', 'covidAdminEditProgram', array(
			'ajaxurl' => admin_url('admin-ajax.php'),
			'nonce' => wp_create_nonce( 'covid-admin-edit-program' ) // Create nonce which we later will use to verify AJAX request
		));
	}

	public function covid_edit_program(){

		if( empty( $_POST['nonce'] ) ){
			wp_die('', '', 400);
		}
	
		check_ajax_referer( 'covid-admin-edit-program', 'nonce', true );
	
	
		// проверим возможность
		if( current_user_can('covid_programs') ){

			global $wpdb;

			$id = $_POST['id'];

			$title = $_POST['title'];
			$comments = $_POST['comments'];

			$update_array = array();

			if( ! empty( $title ) ){
				$update_array['title'] = $title;
			}

			if( ! empty( $comments ) ){
				$update_array['comments'] = $comments;
			}

			$table_name = $wpdb->get_blog_prefix() . 'covid_program';
		
			// $res = $wpdb->update( $table_name, array( 'title' => $title, 'comments' => $comments  ), array( 'id' => $id ));
			$res = $wpdb->update( $table_name, $update_array, array( 'id' => $id ));
			// return $product;
	
			$result = array(
				'message' => "Бланк був успiшно оновлений.",
				'program_name' => $title,
				'id' => $id,
				'status' => 1,
			);
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
	* Возвращает компании где статус = 1
	* return ARRAY
	*/
	public function getPrograms() {

		$results = array();

		global $wpdb;

		$table_name = $wpdb->get_blog_prefix() . 'covid_program';

		$results = $wpdb->get_results( $wpdb->prepare("SELECT id, title FROM " . $table_name . " WHERE status = 1 ORDER BY id DESC;", '%d' ), ARRAY_A );
		
		return $results;
		
	}


	


}

?>