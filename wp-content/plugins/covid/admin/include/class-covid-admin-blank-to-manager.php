<?php

class Covid_Admin_Blank_To_Manager
{

	public function __construct()
	{

	}

	private $version;

	public function run($plugin_name, $version)
	{

		$this->version = $version;

		// JS добавление нумераций БЛАНКОВ
//		add_action('admin_head', array($this, 'covid_add_number_of_blank_to_manager_js'));
        add_action( 'admin_print_scripts-covid_page_covid-blank-to-manager', array( $this, 'covid_add_number_of_blank_to_manager_js' ) );

		add_action('wp_ajax_covidadmingetmanagerofblank', array($this, 'get_manager_of_blank'));
		add_action('wp_ajax_nopriv_covidadmingetmanagerofblank', array($this, 'get_manager_of_blank'));
	}

	public function covid_add_number_of_blank_to_manager_js()
	{
//		wp_enqueue_script('covidadminaddblanktomanager', PLUGIN_URL . 'admin/js/covid-admin-add-blank_to_manager.js', array('jquery'), $this->version);
		wp_enqueue_script('covidadminaddblanktomanager',  plugins_url( 'js/covid-admin-add-blank_to_manager.js', dirname(__FILE__) ), array('jquery'), $this->version);

		wp_localize_script('covidadminaddblanktomanager', 'covidAdminBlankToManager', array(
			'ajaxurl' => admin_url('admin-ajax.php'),
			'nonce' => wp_create_nonce('covid-admin-get-blank-to-details') // Create nonce which we later will use to verify AJAX request
		));
	}

	public function covid_add_blank_to_manager($postData, $managerId)
	{

		// проверим возможность
		if (current_user_can('covid_number_of_blanks')) {

			global $wpdb;

			$companyId = $postData['company_id'];
			$blankSeries = $postData['form_blanks_series'];
			$numberStar = $postData['form_blanks_number_start'];
			$numberEnd = $postData['form_blanks_number_end'];
			$comment = $postData['form_blanks_comments'];

			$blanks_table = $wpdb->get_blog_prefix() . 'covid_number_of_blank';
			$blank_to_manager_table = $wpdb->get_blog_prefix() . 'covid_blank_to_manager';

			$blanks = $wpdb->get_results("SELECT id FROM " . $blanks_table . " WHERE company_id = " . $companyId . " AND blank_series = '" . $blankSeries . "' AND number_start <= " . $numberStar . " AND number_end >= " . $numberEnd . " AND status = 1;", ARRAY_A);

			if (count($blanks) == 1) {
				$checkBusyNumbers = $wpdb->get_results("SELECT id FROM " . $blank_to_manager_table . " WHERE number_of_blank_id = " . $blanks[0]['id'] . " AND ((number_start BETWEEN " . $numberStar . " AND " . $numberEnd . ") OR (number_end BETWEEN " . $numberStar . " AND " . $numberEnd . ")) AND status = 1;", ARRAY_A);
				if (count($checkBusyNumbers) == 0) {
					$query_result = $wpdb->insert($blank_to_manager_table, array('number_of_blank_id' => $blanks[0]['id'], 'manager_id' => $managerId, 'number_start' => $numberStar, 'number_end' => $numberEnd, 'comment' => $comment, 'status' => 1), array('%d', '%d', '%d', '%d', '%s', '%d'));

					if ($query_result) {
						return true;
					}
				}
			}

		}

		return false;
	}

	public function load_blanks_to_manager($managerId)
	{

		$blanks = $this->get_blanks_to_manager($managerId);

		//Выводим список бланков закрепленных за менеджером
		if (count($blanks) > 0) {
			return $this->render_blank_list_to_manager($blanks, $managerId);
		} else {
			return false;
		}

	}

	public function get_blanks_to_manager($managerId)
	{

		global $wpdb;

		$table_blank_to_manager = $wpdb->get_blog_prefix() . 'covid_blank_to_manager';
		$table_blanks = $wpdb->get_blog_prefix() . 'covid_number_of_blank';
		$table_company = $wpdb->get_blog_prefix() . 'covid_company';

		$blanks = $wpdb->get_results("SELECT M.id as id, M.number_start as number_start, M.number_end as number_end, M.comment as comment, B.blank_series as blank_series, C.title as company_title FROM " . $table_blank_to_manager . " as M INNER JOIN " . $table_blanks . " as B ON M.number_of_blank_id = B.id INNER JOIN " . $table_company . " as C ON C.id = B.company_id WHERE M.status = 1 AND M.manager_id = " . $managerId . " ORDER BY M.id DESC;", ARRAY_A);

		return $blanks;

	}

	public function render_blank_list_to_manager($blanks, $managerId)
	{

		if (count($blanks) > 0) {
			$render = '<table class="wp-list-table widefat fixed striped posts">
						<thead>
							<tr>
								<th class="manage-column table-50">№</th>
								<th class="manage-column">Початковий номер</th>
								<th class="manage-column">Кінцевий номер</th>
								<th class="manage-column">Кількість (шт.)</th>
								<th class="manage-column">Коментар</th>
								<th class="manage-column">Компанія</th>
								<th class="manage-column">Серія бланка</th>
								<th class="manage-column table-100 text-center">Управлiння</th>
							</tr>
						</thead>
						<tbody>';

			$i = 1;
			foreach ($blanks as $blank) {
				extract($blank);

				$render .= '<tr>
								<td>' . $i . '</td>
								<td>' . $number_start . '</td>
								<td>' . $number_end . '</td>
								<td>' . ($number_end - $number_start + 1) . '</td>
								<td>' . $comment . '</td>
								<td>' . $company_title . '</td>
								<td>' . $blank_series . '</td>
								<td class="text-center manage-column">
									<form method="POST" onsubmit=\'return confirm("Ви впевнені що хочете видалити даний запис?");\'>
									    <input type="hidden" name="delete_row" value="true">
									    <input type="hidden" name="manager_id" value="' . $managerId . '">
									    <input type="hidden" name="row_id" value="' . $id . '">
				                        <button type="submit" class="button button-primary button-large">
							                <i class="fa fa-trash"></i>
							            </button>
				                    </form>
								</td></tr>';
				$i++;

			}

			$render .= "</tbody></table>";

			return $render;

		}
	}


	public function covid_delete_blank_to_manager($postData)
	{

		// проверим возможность
		if (current_user_can('covid_number_of_blanks')) {

			global $wpdb;
			$id = $postData['row_id'];
			$manager_id = $postData['manager_id'];

			$table_blank_to_manager = $wpdb->get_blog_prefix() . 'covid_blank_to_manager';

			$res = $wpdb->update($table_blank_to_manager, array('status' => 0), array('id' => $id, 'manager_id' => $manager_id));

			return true;
		}

		return false;

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

				echo \GuzzleHttp\json_encode(['status' => 'ok', "message" => "Бланк закріплений за менеджером - <a target='_blank' href='" . admin_url( 'admin.php?page=covid-blank-to-manager&managerid='.$manager_id[0]["manager_id"] ) . "'>" . $this->km_get_users_name($manager_id[0]['manager_id'])['name']."</a>. Cтатус бланку - <strong>".$status."</strong>"]);
			} else {
				echo \GuzzleHttp\json_encode(['status' => 'error',
				                              'message' => 'Бланк не закріплений за менеджером',
				                              //'sqlFirst' => "SELECT id FROM " . $table_number_of_blank . " WHERE company_id = ".$_POST['company_id']." AND blank_series = ".$_POST['blank_series']." AND number_start <= ".$_POST['blank_number']." AND number_end >= ".$_POST['blank_number'],
				                              //'sqlSecond' => "SELECT `manager_id` FROM " . $table_blank_to_manager . " WHERE `number_of_blank_id` = ".$blank_id[0]['id']." AND number_start <= ".$_POST['blank_number']." AND number_end >= ".$_POST['blank_number']
				]);
			}
		} else {
			echo \GuzzleHttp\json_encode(['status' => 'error', 'message' => 'Не знайдено даного бланку']);
		}
		wp_die();
	}

	public
	function km_get_users_name($user_id = null)
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

?>