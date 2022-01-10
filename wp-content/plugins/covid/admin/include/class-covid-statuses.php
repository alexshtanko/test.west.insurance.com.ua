<?php

class Covid_Admin_Statuses {

    public function __construct(  ) {

    }

	private $version;

	public function run( $plugin_name, $version ) {

		$this->version = $version;

		// JS добавление нумераций БЛАНКОВ
//		add_action( 'admin_head', array( $this, 'covid_add_statuses_js' ) );
        add_action( 'admin_print_scripts-covid_page_covid-statuses', array( $this, 'covid_add_statuses_js' ) );
	}

	public function covid_add_statuses_js() {
//		wp_enqueue_script( 'covidadminaddstatuses', PLUGIN_URL . 'admin/js/covid-admin-statuses.js', array('jquery'), $this->version );
		wp_enqueue_script( 'covidadminaddstatuses', plugins_url( 'js/covid-admin-statuses.js', dirname(__FILE__) ), array('jquery'), $this->version );
	}

	public function covid_add_status($postData){
		// проверим возможность
		if( current_user_can('create_users') ){
			global $wpdb;

			$statusText = $postData['form_status_text'];
			$statusComment = $postData['form_status_comment'];
			$statusAdminReport = $postData['form_status_admin_report'];
			$statusManagerReport = $postData['form_status_manager_report'];
			$statusFreeBlank = $postData['form_status_free_blank'];

			$statuses_table = $wpdb->get_blog_prefix() . 'covid_statuses';
			$statuses = $wpdb->get_results( "SELECT count(*) as counter FROM " . $statuses_table . ";", ARRAY_A)[0];

			$query_result = $wpdb->insert( $statuses_table, array( 'id' => $statuses['counter'], 'text' => trim($statusText), 'comment' => $statusComment, 'adminReport' => $statusAdminReport, 'managerReport' => $statusManagerReport, 'freeBlank' => $statusFreeBlank, 'status' => 1, 'disabled' => 0 ), array('%d', '%s', '%s', '%d', '%d', '%d',  '%d', '%d' ));

			if($query_result) {
				return true;
			}

		}

		return false;
	}

	public function covid_edit_status($postData){
		// проверим возможность
		if( current_user_can('create_users') ){
			global $wpdb;

			$statusText = $postData['form_status_text'];
			$statusComment = $postData['form_status_comment'];
			$statusAdminReport = $postData['form_status_admin_report'];
			$statusManagerReport = $postData['form_status_manager_report'];
			$statusFreeBlank = $postData['form_status_free_blank'];
			$statusId = $postData['status_id'];

			$statuses_table = $wpdb->get_blog_prefix() . 'covid_statuses';
			$statuses = $wpdb->get_results( "SELECT * FROM " . $statuses_table . " WHERE status = 1 AND id=".$statusId.";", ARRAY_A);
			if(count($statuses) == 1) {
				$res = $wpdb->update( $statuses_table, array( 'text' => $statusText, 'comment' => $statusComment, 'adminReport' => $statusAdminReport, 'managerReport' => $statusManagerReport, 'freeBlank' => $statusFreeBlank), array( 'id' => $statusId, 'status' =>  1));
				return true;
			}
		}

		return false;
	}

	public function load_statuses() {

		$statuses = $this->get_statuses();

		//Выводим список статусов заказов
		if(count($statuses) > 0) {
			return $this->render_statuses_list($statuses);
		}
		else {
			return false;
		}

	}

	public function get_statuses($id = false) {
		global $wpdb;
		$selectedStatus = $id !== false ? " AND id = ".$id : "";

		$table_statuses = $wpdb->get_blog_prefix() . 'covid_statuses';
		$statuses = $wpdb->get_results( "SELECT * FROM " . $table_statuses . " WHERE status = 1".$selectedStatus.";", ARRAY_A);
		return $statuses;
	}

	public function get_statuses_array() {
		global $wpdb;
		$table_statuses = $wpdb->get_blog_prefix() . 'covid_statuses';
		$statuses = $wpdb->get_results( "SELECT id, text FROM " . $table_statuses . " WHERE status = 1;", ARRAY_A);
		return $statuses;
	}

	public function render_statuses_list( $statuses ) {

		if( count($statuses) > 0 ){
			$render = '<table class="wp-list-table widefat fixed striped posts">
						<thead>
							<tr>
								<th class="manage-column table-50">№</th>
								<th class="manage-column">Текст статусу</th>
								<th class="manage-column">Коментар</th>
								<th class="manage-column"><i class="fa fa-eye"></i> в звітах адміністратора</th>
								<th class="manage-column"><i class="fa fa-eye"></i> в звітах менеджера</th>
								<th class="manage-column">Звільняти номер бланку</th>
								<th class="manage-column table-100 text-center">Управлiння</th>
							</tr>
						</thead>
						<tbody>';

			$i = 1;
			foreach( $statuses as $status ){
				extract( $status );

				$delete = '<form method="POST" onsubmit=\'return confirm("Ви впевнені що хочете видалити даний статус замовлення?");\'>
									    <input type="hidden" name="delete_status" value="true">
									    <input type="hidden" name="status_id" value="'.$id.'">
				                        <button type="submit" class="button button-primary button-large">
							                <i class="fa fa-trash"></i>
							            </button>
				                    </form>';

				$edit = '<a href="' . admin_url( 'admin.php?page=covid-statuses&getStatusId='.$id ) . '" class="button button-primary button-large ">
					        <i class="fa fa-edit"></i></a>&nbsp;';


				if($disabled == true ) {
					$delete = '';
					$edit = '';
				}

				$textAdminReport = $adminReport == true ? "Так" : "Ні";
				$textManagerReport = $managerReport == true ? "Так" : "Ні";
				$textFreeBlank = $freeBlank == true ? "Так" : "Ні";

				$render .= '<tr>
								<td>' . $i . '</td>
								<td>' . $text . '</td>
								<td>' . $comment . '</td>
								<td>' . $textAdminReport . '</td>
								<td>' . $textManagerReport . '</td>
								<td>' . $textFreeBlank . '</td>
								<td class="text-center manage-column" style="display: inline-flex;">
									'.$edit.'
									'.$delete.'
								</td></tr>';
				$i ++;
				
			}

			$render .= "</tbody></table>";

			return $render;

		}
	}


	public function covid_delete_status($postData){

		// проверим возможность
		if( current_user_can('create_users') ){

			global $wpdb;
			$id = $postData['status_id'];

			$table_statuses = $wpdb->get_blog_prefix() . 'covid_statuses';

			if($id >= 2 ) {
				$res = $wpdb->update( $table_statuses, array( 'status' => 0 ), array( 'id' => $id ) );
				return true;
			}

		}

		return false;

	}

}

?>