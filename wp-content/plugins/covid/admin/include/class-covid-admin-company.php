<?php

class Covid_Admin_Company {

    /**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	// private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct(  ) {

        
	}
	
	// private $version = 1.1.0;


    public function run() {

        /*
        * Вывод списка бланков 
        */
//        add_action( 'admin_head', array( $this, 'covid_company_list_js' ) );
        add_action( 'admin_print_scripts-covid_page_covid-company', array( $this, 'covid_company_list_js' ) );

		//Экшн Вывода Бланков 
		add_action( 'wp_ajax_covidcompanylist', array( $this, 'covid_company_list' ) );
        add_action( 'wp_ajax_nopriv_covidcompanylist', array( $this, 'covid_company_list' ) );
        


		/*
		*Добавление бланка в БД
		*/
		//JS скрипт обработки добавления Бланков в БД
//		add_action( 'admin_head', array( $this, 'covid_add_company_js' ) );
        add_action( 'admin_print_scripts-covid_page_covid-company', array( $this, 'covid_add_company_js' ) );

		//Экшн добавления Бланков в БД 
		add_action( 'wp_ajax_covidaddcompany', array( $this, 'covid_add_company' ) );
		add_action( 'wp_ajax_nopriv_covidaddcompany', array( $this, 'covid_add_company' ) );



		/*
		*	Удаление бланков с БД
		*	Происходит изменение статуса отображения 1 - показывать, 0 - нет
		*/
		//JS скрипт обработки добавления Бланков в БД
//		add_action( 'admin_head', array( $this, 'covid_delete_company_js' ) );
        add_action( 'admin_print_scripts-covid_page_covid-company', array( $this, 'covid_delete_company_js' ) );

		//Экшн удаления Бланков с БД 
		add_action( 'wp_ajax_coviddeletecompany', array( $this, 'covid_delete_company' ) );
		add_action( 'wp_ajax_nopriv_coviddeletecompany', array( $this, 'covid_delete_company' ) );

		/*
		*	Редактирование Бланка
		*/
//		add_action( 'admin_head', array( $this, 'covid_delete_company_js' ) );
        add_action( 'admin_print_scripts-covid_page_covid-company', array( $this, 'covid_delete_company_js' ) );

		//Экшн редактирования Бланков с БД 
		add_action( 'wp_ajax_covideditcompany', array( $this, 'covid_edit_company' ) );
        add_action( 'wp_ajax_nopriv_covideditcompany', array( $this, 'covid_edit_company' ) );
        
    }


    public function covid_add_company_js() {

//		wp_enqueue_script( 'covidadminaddcompany', PLUGIN_URL . 'admin/js/covid-admin-add-company.js', array('jquery') );
		wp_enqueue_script( 'covidadminaddcompany', plugins_url( 'js/covid-admin-add-company.js', dirname(__FILE__) ), array('jquery') );

		wp_localize_script( 'covidadminaddcompany', 'covidAdminAddCompany', array(
			'ajaxurl' => admin_url('admin-ajax.php'),
			'nonce' => wp_create_nonce( 'covid-admin-add-company' ) // Create nonce which we later will use to verify AJAX request
		));
	}

	public function covid_add_company(){

		if( empty( $_POST['nonce'] ) ){
			wp_die('', '', 400);
		}
	
		check_ajax_referer( 'covid-admin-add-company', 'nonce', true );
	
	
		// проверим возможность
		if( current_user_can('covid_companies') ){

			global $wpdb;

			$company_name = $_POST['company_name'];
			$company_logo_url = $_POST['company_logo_url'];
			$company_logo_id = $_POST['company_logo_id'];

			$table_name = $wpdb->get_blog_prefix() . 'covid_company';
		
			$wpdb->insert( $table_name, array( 'title' => $company_name, 'logo_url' => $company_logo_url, 'logo_id' => $company_logo_id, 'status' => 1 ), array( '%s', '%s', '%d', '%d' ));

            $company_id = $wpdb->insert_id;

            if( $company_id )
            {
                require_once "class-covid-admin-help.php";

                $help = new Covid_Admin_Help();

                $help->update_user_covid_visible_company( 'user_manager', $company_id );

                $result = array(
                    'message' => "Компанію успiшно додано.",
                    'company_name' => $company_name,
                    'status' => 1,
                );
            }
            else
            {
                $result = array(
                    'message' => "Не вдалося додати компанiю.",
                    'company_name' => $company_name,
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

	public function get_companys() {

		global $wpdb;

		$table_name = $wpdb->get_blog_prefix() . 'covid_company';

		$companys = $wpdb->get_results( $wpdb->prepare("SELECT logo_url, logo_id, id, title FROM " . $table_name . " WHERE status = 1 ORDER BY id DESC;", '%d' ) );

		return $companys;

	}

	public function render_company_list( $companys ) {

		if( $companys ){

			$render = '';

			$render .= '<h2>Всi Компанії</h2><table class="wp-list-table widefat fixed striped posts"><thead><th class="manage-column table-50">№</th><th class="manage-column table-150">Логотип</th><th class="manage-column table-50">ID</th><th class="manage-column">Назва Компанії</th><th class="manage-column table-100 text-center">Управлiння</th></thead><tbody>';
			$i = 1;
			foreach( $companys as $company ){

				$render .= '<tr>';
				$render .= '<td>' . $i . '</td>';
				$render .= '<td class="table-200 company-list-logo"><img src="' . $company->logo_url . '" /></td>';
				$render .= '<td>' . $company->id . '</td>';
				$render .= '<td>' . $company->title . '</td>';
				$render .= '<td class="text-center manage-column"><button class="button button-primary button-large edit-company js-edit-company" data-id="'. $company->id .'" data-company-title="'. $company->title .'" data-logo-url="' . $company->logo_url . '" data-logo-id="' . $company->logo_id . '"><i class="fa fa-edit"></i></button><span class="delete-agree">Ви впевненi?<span><button class="button button-primary button-small js-delete-company" data-id="'. $company->id .'">Так</button><button class="button button-primary button-small js-remove-btn-cancel">Нi</button></span></span><button class="button button-primary button-large js-remove-btn"><i class="fa fa-trash"></i></button></td>';
				$render .= '</tr>';
				$i ++;
				
			}

			$render .= '</tbody></table>';

			// $render = '';

			return $render;

		}
	}


	public function covid_company_list_js() {

//		wp_enqueue_script( 'covidadmincompanylist', PLUGIN_URL . 'admin/js/covid-admin-company-list.js', array('jquery') );
		wp_enqueue_script( 'covidadmincompanylist', plugins_url( 'js/covid-admin-company-list.js', dirname(__FILE__) ), array('jquery') );

		wp_localize_script( 'covidadmincompanylist', 'covidAdminCompanyList', array(
			'ajaxurl' => admin_url('admin-ajax.php'),
			'nonce' => wp_create_nonce( 'covid-admin-company-list' ) // Create nonce which we later will use to verify AJAX request
        ));
        

	}

	//Выводим список бланков
	public function covid_company_list() {

		if( empty( $_POST['nonce'] ) ){
			wp_die('', '', 400);
		}
	
		check_ajax_referer( 'covid-admin-company-list', 'nonce', true );

		if( current_user_can('covid_companies') ){

			$companys = $this->get_companys();

			$result = $this->render_company_list( $companys );

			echo $result;

		}

		wp_die();

	}

	public function covid_delete_company_js() {

//		wp_enqueue_script( 'covidadmindeletecompany', PLUGIN_URL . 'admin/js/covid-admin-delete-company.js', array('jquery') );
		wp_enqueue_script( 'covidadmindeletecompany', plugins_url( 'js/covid-admin-delete-company.js', dirname(__FILE__) ), array('jquery') );

		wp_localize_script( 'covidadmindeletecompany', 'covidAdminDeleteCompany', array(
			'ajaxurl' => admin_url('admin-ajax.php'),
			'nonce' => wp_create_nonce( 'covid-admin-delete-company' ) // Create nonce which we later will use to verify AJAX request
		));
	}


	public function covid_delete_company(){

		if( empty( $_POST['nonce'] ) ){
			wp_die('', '', 400);
		}
	
		check_ajax_referer( 'covid-admin-delete-company', 'nonce', true );
	
	
		// проверим возможность
		if( current_user_can('covid_companies') ){

			global $wpdb;

			$id = $_POST['id'];

			$table_name = $wpdb->get_blog_prefix() . 'covid_company';
		
			$res = $wpdb->update( $table_name, array( 'status' => 0 ), array( 'id' => $id ));
			// return $product;
	
			$result = array(
				'message' => "Компанiя була успiшно видалена.",
				'company_name' => $id,
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
	public function covid_edit_company_js() {

//		wp_enqueue_script( 'covidadmineditcompany', PLUGIN_URL . 'admin/js/covid-admin-edit-company.js', array('jquery') );
		wp_enqueue_script( 'covidadmineditcompany', plugins_url( 'js/covid-admin-edit-company.js', dirname(__FILE__) ), array('jquery') );

		wp_localize_script( 'covidadmineditcompany', 'covidAdminEditCompany', array(
			'ajaxurl' => admin_url('admin-ajax.php'),
			'nonce' => wp_create_nonce( 'covid-admin-edit-company' ) // Create nonce which we later will use to verify AJAX request
		));
	}

	public function covid_edit_company(){

		if( empty( $_POST['nonce'] ) ){
			wp_die('', '', 400);
		}
	
		check_ajax_referer( 'covid-admin-edit-company', 'nonce', true );
	
	
		// проверим возможность
		if( current_user_can('covid_companies') ){

			global $wpdb;

			$id = $_POST['id'];

			$title = $_POST['title'];
			$company_logo_url = $_POST['company_logo_url'];
			$company_logo_id = $_POST['company_logo_id'];

			$company_data = array();

			if( ! empty( $title ) ){
				$company_data['title'] = $title;
			}
			if( ! empty( $company_logo_url ) ){
				$company_data['logo_url'] = $company_logo_url;
				$company_data['logo_id'] = $company_logo_id;
			}


			$table_name = $wpdb->get_blog_prefix() . 'covid_company';
		
			// $res = $wpdb->update( $table_name, array( 'title' => $title, 'logo_url' => $company_logo_url, 'logo_id' => $company_logo_id ), array( 'id' => $id ));
			$res = $wpdb->update( $table_name, $company_data, array( 'id' => $id ));
			// return $product;
	
			$result = array(
				'message' => "Інформація про компанію була оновлена.",
				'company_name' => $title,
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
	public function getCompanies() {

		$results = array();

		global $wpdb;

		$table_name = $wpdb->get_blog_prefix() . 'covid_company';

		$results = $wpdb->get_results( $wpdb->prepare("SELECT id, title FROM " . $table_name . " WHERE status = 1 ORDER BY id DESC;", '%d' ), ARRAY_A );
		
		return $results;
		
	}
}

?>