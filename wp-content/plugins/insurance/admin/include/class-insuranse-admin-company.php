<?php

class Insurance_Admin_Company {

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
//        add_action( 'admin_head', array( $this, 'insurance_company_list_js' ) );
        add_action( 'admin_print_scripts-medical-policy_page_insurance-company', array( $this, 'insurance_company_list_js' ) );

		//Экшн Вывода Бланков 
		add_action( 'wp_ajax_insurancecompanylist', array( $this, 'insurance_company_list' ) );
        add_action( 'wp_ajax_nopriv_insurancecompanylist', array( $this, 'insurance_company_list' ) );
        


		/*
		*Добавление бланка в БД
		*/
		//JS скрипт обработки добавления Бланков в БД
//		add_action( 'admin_head', array( $this, 'insurance_add_company_js' ) );
        add_action( 'admin_print_scripts-medical-policy_page_insurance-company', array( $this, 'insurance_add_company_js' ) );

		//Экшн добавления Бланков в БД 
		add_action( 'wp_ajax_insuranceaddcompany', array( $this, 'insurance_add_company' ) );
		add_action( 'wp_ajax_nopriv_insuranceaddcompany', array( $this, 'insurance_add_company' ) );



		/*
		*	Удаление бланков с БД
		*	Происходит изменение статуса отображения 1 - показывать, 0 - нет
		*/
		//JS скрипт обработки добавления Бланков в БД
//		add_action( 'admin_head', array( $this, 'insurance_delete_company_js' ) );
        add_action( 'admin_print_scripts-medical-policy_page_insurance-company', array( $this, 'insurance_delete_company_js' ) );

		//Экшн удаления Бланков с БД 
		add_action( 'wp_ajax_insurancedeletecompany', array( $this, 'insurance_delete_company' ) );
		add_action( 'wp_ajax_nopriv_insurancedeletecompany', array( $this, 'insurance_delete_company' ) );

		/*
		*	Редактирование Бланка
		*/
//		add_action( 'admin_head', array( $this, 'insurance_edit_company_js' ) );
        add_action( 'admin_print_scripts-medical-policy_page_insurance-company', array( $this, 'insurance_edit_company_js' ) );

		//Экшн редактирования Бланков с БД 
		add_action( 'wp_ajax_insuranceeditcompany', array( $this, 'insurance_edit_company' ) );
        add_action( 'wp_ajax_nopriv_insuranceeditcompany', array( $this, 'insurance_edit_company' ) );
        
    }


    public function insurance_add_company_js() {

		wp_enqueue_script( 'insuranceadminaddcompany', plugins_url( 'js/insurance-admin-add-company.js', dirname(__FILE__) ), array('jquery') );

		wp_localize_script( 'insuranceadminaddcompany', 'insuranceAdminAddCompany', array(
			'ajaxurl' => admin_url('admin-ajax.php'),
			'nonce' => wp_create_nonce( 'insurance-admin-add-company' ) // Create nonce which we later will use to verify AJAX request
		));
	}

	public function insurance_add_company(){

		if( empty( $_POST['nonce'] ) ){
			wp_die('', '', 400);
		}
	
		check_ajax_referer( 'insurance-admin-add-company', 'nonce', true );
	
	
		// проверим возможность
		if( current_user_can('medical_insurance_companies') ){

			global $wpdb;

			$company_name = $_POST['company_name'];
			$company_logo_url = $_POST['company_logo_url'];
			$company_logo_id = $_POST['company_logo_id'];

			$table_name = $wpdb->get_blog_prefix() . 'insurance_company';

            $wpdb->insert( $table_name, array( 'title' => $company_name, 'logo_url' => $company_logo_url, 'logo_id' => $company_logo_id, 'status' => 1 ), array( '%s', '%s', '%d', '%d' ));

            $company_id = $wpdb->insert_id;

            if( $company_id )
            {
                require_once "class-insurance-admin-help.php";

                $help = new Insurance_Admin_Help();

                $help->updateUserInsuranceVisibleCompany( 'user_manager', $company_id );

//                var_dump($test);

                $result = array(
                    'message' => "Компанію успiшно додано.",
                    'company_name' => $company_name . ' ' . $company_id,
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

		$table_name = $wpdb->get_blog_prefix() . 'insurance_company';

		$companys = $wpdb->get_results( $wpdb->prepare("SELECT logo_url, logo_id, id, title FROM " . $table_name . " WHERE status = 1 ORDER BY id DESC;", '%d' ) );

		return $companys;

	}

	public function render_company_list( $companys ) {

		if( $companys ){

			$render = '';

			$render .= '<h2>Всi Компанії</h2><table class="wp-list-table widefat fixed striped posts"><thead><th class="manage-column table-50">№</th><th class="manage-column table-150">Логотип</th><th class="manage-column table-50">ID</th><th class="manage-column">Назва Компанії</th><th class="manage-column table-100 text-center">Управлiння</th></thead><tbody>';
			$i = 1;
			foreach( $companys as $company ){

				// $render .= '<div class="row insurance-blanl-list-item"><div class="col-lg-1 p-1">' . $i . '</div><div class="col-lg-10 p-1">' . $company->title . '</div><div class="col-lg-1 p-1 text-danger"><span data-id="'. $company->id .'"><button class="button button-primary button-large deleteRow"><i class="fa fa-trash"></i></button></span></div></div>';
				// $render .= '<tr><td>' . $i . '</td><td>' . $company->id . '</td><td>' . $company->title . '</td><td class="text-center manage-column"><button class="button button-primary button-large edit-company js-edit-company" data-id="'. $company->id .'" data-company-title="'. $company->title .'"><i class="fa fa-edit"></i></button><button class="button button-primary button-large deleteRow js-delete-company" data-id="'. $company->id .'"><i class="fa fa-trash"></i></button></td></tr>';
				$render .= '<tr>';
				$render .= '<td>' . $i . '</td>';
				$render .= '<td class="table-200 company-list-logo"><img src="' . $company->logo_url . '" /></td>';
				$render .= '<td>' . $company->id . '</td>';
				$render .= '<td>' . $company->title . '</td>';
				// $render .= '<td class="text-center manage-column"><button class="button button-primary button-large edit-company js-edit-company" data-id="'. $company->id .'" data-company-title="'. $company->title .'"><i class="fa fa-edit"></i></button><button class="button button-primary button-large deleteRow js-delete-company" data-id="'. $company->id .'"><i class="fa fa-trash"></i></button></td>';
				$render .= '<td class="text-center manage-column"><button class="button button-primary button-large edit-company js-edit-company" data-id="'. $company->id .'" data-company-title="'. $company->title .'" data-logo-url="' . $company->logo_url . '" data-logo-id="' . $company->logo_id . '"><i class="fa fa-edit"></i></button><span class="delete-agree">Ви впевненi?<span><button class="button button-primary button-small js-delete-company" data-id="'. $company->id .'">Так</button><button class="button button-primary button-small js-remove-btn-cancel">Нi</button></span></span><button class="button button-primary button-large js-remove-btn"><i class="fa fa-trash"></i></button></td>';
				$render .= '</tr>';
				$i ++;
				
			}

			$render .= '</tbody></table>';

			// $render = '';

			return $render;

		}
	}


	public function insurance_company_list_js() {

//		wp_enqueue_script( 'insuranceadmincompanylist', PLUGIN_URL . 'admin/js/insurance-admin-company-list.js', array('jquery') );
		wp_enqueue_script( 'insuranceadmincompanylist', plugins_url( 'js/insurance-admin-company-list.js', dirname(__FILE__) ), array('jquery') );

		wp_localize_script( 'insuranceadmincompanylist', 'insuranceAdminCompanyList', array(
			'ajaxurl' => admin_url('admin-ajax.php'),
			'nonce' => wp_create_nonce( 'insurance-admin-company-list' ) // Create nonce which we later will use to verify AJAX request
        ));
        

	}

	//Выводим список бланков
	public function insurance_company_list() {

		if( empty( $_POST['nonce'] ) ){
			wp_die('', '', 400);
		}
	
		check_ajax_referer( 'insurance-admin-company-list', 'nonce', true );

		if( current_user_can('medical_insurance_companies') ){

			$companys = $this->get_companys();

			$result = $this->render_company_list( $companys );

			echo $result;

		}

		wp_die();

	}

	public function insurance_delete_company_js() {

//		wp_enqueue_script( 'insuranceadmindeletecompany', PLUGIN_URL . 'admin/js/insurance-admin-delete-company.js', array('jquery') );
		wp_enqueue_script( 'insuranceadmindeletecompany', plugins_url( 'js/insurance-admin-delete-company.js', dirname(__FILE__ ) ), array('jquery') );

		wp_localize_script( 'insuranceadmindeletecompany', 'insuranceAdminDeleteCompany', array(
			'ajaxurl' => admin_url('admin-ajax.php'),
			'nonce' => wp_create_nonce( 'insurance-admin-delete-company' ) // Create nonce which we later will use to verify AJAX request
		));
	}


	public function insurance_delete_company(){

		if( empty( $_POST['nonce'] ) ){
			wp_die('', '', 400);
		}
	
		check_ajax_referer( 'insurance-admin-delete-company', 'nonce', true );
	
	
		// проверим возможность
		if( current_user_can('medical_insurance_companies') ){

			global $wpdb;

			$id = $_POST['id'];

			$table_name = $wpdb->get_blog_prefix() . 'insurance_company';
		
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
	public function insurance_edit_company_js() {

//		wp_enqueue_script( 'insuranceadmineditcompany', PLUGIN_URL . 'admin/js/insurance-admin-edit-company.js', array('jquery') );
		wp_enqueue_script( 'insuranceadmineditcompany', plugins_url( 'js/insurance-admin-edit-company.js', dirname(__FILE__ ) ), array('jquery') );

		wp_localize_script( 'insuranceadmineditcompany', 'insuranceAdminEditCompany', array(
			'ajaxurl' => admin_url('admin-ajax.php'),
			'nonce' => wp_create_nonce( 'insurance-admin-edit-company' ) // Create nonce which we later will use to verify AJAX request
		));
	}

	public function insurance_edit_company(){

		if( empty( $_POST['nonce'] ) ){
			wp_die('', '', 400);
		}
	
		check_ajax_referer( 'insurance-admin-edit-company', 'nonce', true );
	
	
		// проверим возможность
		if( current_user_can('medical_insurance_companies') ){

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


			$table_name = $wpdb->get_blog_prefix() . 'insurance_company';
		
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

		$table_name = $wpdb->get_blog_prefix() . 'insurance_company';

		$results = $wpdb->get_results( $wpdb->prepare("SELECT id, title FROM " . $table_name . " WHERE status = 1 ORDER BY id DESC;", '%d' ), ARRAY_A );
		
		return $results;
		
	}
}

?>