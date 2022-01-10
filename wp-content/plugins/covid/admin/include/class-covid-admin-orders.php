<?php

//Подключаем библиотеку для работы с Excel файлами
require ABSPATH . '/vendor/autoload.php';
require_once 'class-covid-admin-help.php';
class Covid_Admin_Orders
{
	private $plugin_name;

	private $version;

	public function __construct()
	{
	}

	public function run($plugin_name, $version)
	{
		$this->plugin_name = $plugin_name;
		$this->version = $version;

		/*
		*	Попап с информацией
	   */
//		add_action('admin_head', array($this, 'order_details_js'));
        add_action( 'admin_print_scripts-covid_page_covid-orders', array( $this, 'order_details_js' ) );

		add_action('wp_ajax_covidadminorderdetails', array($this, 'get_orders_details'));
		add_action('wp_ajax_nopriv_covidadminorderdetails', array($this, 'get_orders_details'));

		add_action('wp_ajax_covidadminorderdetailssave', array($this, 'save_orders_details'));
		add_action('wp_ajax_nopriv_covidadminorderdetailssave', array($this, 'save_orders_details'));
		/*
		* Вывод списка заказов
		*/
//		add_action('admin_head', array($this, 'covid_order_list_js'));
        add_action( 'admin_print_scripts-covid_page_covid-orders', array( $this, 'covid_order_list_js' ) );


		//Экшн Вывода заказов
		add_action('wp_ajax_covidorderlist', array($this, 'covid_order_list'));
		add_action('wp_ajax_nopriv_covidorderlist', array($this, 'covid_order_list'));

		/*
		* Удалить заказ
		*/
//		add_action('admin_head', array($this, 'covid_order_delete_js'));
        add_action( 'admin_print_scripts-covid_page_covid-orders', array( $this, 'covid_order_delete_js' ) );

		//Экшн удаления тарифа
		add_action('wp_ajax_covidorderdelete', array($this, 'covid_order_delete'));
		add_action('wp_ajax_nopriv_covidorderdelete', array($this, 'covid_order_delete'));

		//Экшн смены статуса
		add_action('wp_ajax_covidorderhangestatus', array($this, 'covid_order_change_status'));
		add_action('wp_ajax_nopriv_covidorderhangestatus', array($this, 'covid_order_change_status'));
	}

	//Попап и информацией
	public function order_details_js()
	{
//		wp_enqueue_script('covidadminorderdetails', PLUGIN_URL . 'admin/js/covid-admin-order-details.js', array('jquery'), $this->version);
		wp_enqueue_script('covidadminorderdetails',  plugins_url( 'js/covid-admin-order-details.js', dirname(__FILE__) ), array('jquery'), $this->version);

		wp_localize_script('covidadminorderdetails', 'covidAdminOrderDetails', array(
			'ajaxurl' => admin_url('admin-ajax.php'),
			'nonce' => wp_create_nonce('covid-admin-order-details') // Create nonce which we later will use to verify AJAX request
		));
	}

	public function covid_order_delete_js()
	{
//		wp_enqueue_script('covidadminorderdelete', PLUGIN_URL . 'admin/js/covid-admin-order-delete.js', array('jquery'), $this->version);
		wp_enqueue_script('covidadminorderdelete', plugins_url( 'js/covid-admin-order-delete.js', dirname(__FILE__) ) , array('jquery'), $this->version);

		wp_localize_script('covidadminorderdelete', 'covidAdminorderDelete', array(
			'ajaxurl' => admin_url('admin-ajax.php'),
			'nonce' => wp_create_nonce('covid-admin-order-delete') // Create nonce which we later will use to verify AJAX request
		));
	}

	//Удалить бланк
	public function covid_order_delete()
	{

		if (empty($_POST['nonce'])) {
			wp_die('', '', 400);
		}

		check_ajax_referer('covid-admin-order-delete', 'nonce', true);

		if (current_user_can('covid_orders')) {

			$id = $_POST['id'];
			$company_id = $_POST['company_id'];
			$program_id = $_POST['program_id'];
			$franchise = $_POST['franchise'];
			$blank_series = $_POST['blank_series'];
			$manager_id = $_POST['manager_id'];
			$status = $_POST['status'];
			$count = $_POST['count'];
			$date_from = $_POST['date_from'];
			$date_to = $_POST['date_to'];
			$page = $_POST['page'];

			$orders_limit_from = ($page - 1) * $count;

            //для поиска по ТАБЛИЧКИ ЭЛЕКТРОННЫХ
			$blank_type_data = $this->get_order_blank_type_id($id);

			//Устанавливаем новый статус для ЭЛЕКТРОННЫХ бланков
            $this->set_status_e_blank($blank_type_data[0]['number_blank_id'], $blank_type_data[0]['blank_number'], 0);

			//Удаление Тарифа
			$remove_status = $this->remove_order($id);

			//Обновляем список заказов
			$orders_sort = $this->orders_sort($program_id, $company_id, $blank_series, $manager_id, $franchise, $date_from, $date_to, $status);

			$orders_count = count($orders_sort);
			$paginations = $this->get_paginations($orders_count, $count, $page);

			$page = $orders_count / $count;
			$pages = ceil($page);

			$orders_sort = $this->orders_sort($program_id, $company_id, $blank_series, $manager_id, $franchise, $date_from, $date_to, $status, $orders_limit_from, $count);

			$orders = $this->orders_render($orders_sort, $page, $count);

			$result = array(
				'orders' => $orders,
				'paginations' => $paginations['result'],
//				'status' => $remove_status['status'],
				'pages' => $pages,
				'orders_count' => $orders_count,
//				'message' => $remove_status['message'],
				'demo' => $id,
			);

			echo json_encode($result);
		}

		wp_die();
	}

	public function covid_order_list_js()
	{

//		wp_enqueue_script('covidadminorderlist', PLUGIN_URL . 'admin/js/covid-admin-order-list.js', array('jquery'), $this->version);
		wp_enqueue_script('covidadminorderlist',  plugins_url( 'js/covid-admin-order-list.js', dirname(__FILE__) ), array('jquery'), $this->version);

		wp_localize_script('covidadminorderlist', 'covidAdminOrderList', array(
			'ajaxurl' => admin_url('admin-ajax.php'),
			'nonce' => wp_create_nonce('covid-admin-order-list') // Create nonce which we later will use to verify AJAX request
		));


	}

	//смена статуса
	public function covid_order_change_status()
	{
		if (empty($_POST['nonce'])) {
			wp_die('', '', 400);
		}

		check_ajax_referer('covid-admin-order-list', 'nonce', true);

		global $wpdb;

		$table_name_orders = $wpdb->get_blog_prefix() . 'covid_orders';
		$order_id = $_POST['id'];
		$status = $_POST['status'];


        //для поиска по ТАБЛИЧКИ ЭЛЕКТРОННЫХ
        $blank_type_data = $this->get_order_blank_type_id($order_id);
        $e_status = $status != 1 ? 0 : 1;


        $this->set_status_e_blank($blank_type_data[0]['number_blank_id'], $blank_type_data[0]['blank_number'], $e_status);

		$results = $wpdb->get_results($wpdb->prepare("UPDATE " . $table_name_orders . " SET `status`='%s'  WHERE id = %s ", $status, $order_id), ARRAY_A);

	}

	//Выводим список бланков
	public function covid_order_list()
	{
		if (empty($_POST['nonce'])) {
			wp_die('', '', 400);
		}

		check_ajax_referer('covid-admin-order-list', 'nonce', true);

		if (current_user_can('covid_orders')) {

			$company_id = $_POST['company_id'];
			$program_id = $_POST['program_id'];
			$franchise = $_POST['franchise'];
			$blank_series = $_POST['blank_series'];
			$manager_id = $_POST['manager_id'];
			$status = $_POST['status'];
			$count = $_POST['count'];
			$date_from = $_POST['date_from'];
			$date_to = $_POST['date_to'];
			$blank_number = $_POST['blank_number'];

			$page = $_POST['page'];

			$orders_limit_from = ($page - 1) * $count;

			$orders_sort = $this->orders_sort($program_id, $company_id, $blank_series, $manager_id, $franchise, $date_from, $date_to, $status, 0, 999999, $blank_number);

			$orders_count = count($orders_sort);

			$paginations = $this->get_paginations($orders_count, $count, $page);

			$orders_sort = $this->orders_sort($program_id, $company_id, $blank_series, $manager_id, $franchise, $date_from, $date_to, $status, $orders_limit_from, $count, $blank_number);

			$orders = $this->orders_render($orders_sort, $page, $count);

			$page = $orders_count / $count;
			$pages = ceil($page);

			if (!empty($orders)) {
				$message = 'По вашому запиту знайдено результатiв: ' . $orders_count . '.';
			} else {
				$message = 'По вашому запиту результатiв не знайдено.';
			}

			$type = gettype($date_from);

			$result = array(
				'orders' => $orders,
				'paginations' => $paginations['result'],
				'pages' => $pages,
                'validity' => $type,
				'orders_count' => $orders_count,
				'message' => $message,
			);

			echo json_encode($result);

		}

		wp_die();

	}


	public function import()
	{

		add_action('admin_post_nopriv_admin_rate_import', array($this, 'covid_rate_import'));
		add_action('admin_post_admin_rate_import', array($this, 'covid_rate_import'));

	}


	/*
	*   Получаем все тарифы
	*   return ARRAY
	*/
	public function get_orders($limit_from = 0, $offset = 99999999)
	{

		global $wpdb;

		$table_name_orders = $wpdb->get_blog_prefix() . 'covid_orders';

		$results = $wpdb->get_results(
		        $wpdb->prepare(
		                "SELECT 
                            `id`, 
                            `program_title`,
                            `company_id`,
                            `company_title`,
                            `rate_id`, 
                            `rate_price`, 
                            `blank_series`, 
                            `blank_number`, 
                            `date_added`, 
                            `status`, 
                            `rate_coefficient`, 
                            `rate_price_coefficient`, 
                            `user_id`, 
                            `insurer_status` 
                        FROM " . $table_name_orders . " ir 
                        ORDER BY ir . id DESC LIMIT %d, %d", $limit_from, $offset), ARRAY_A);

		return $results;
	}

	/*
*   Получаем все тарифы
*   return ARRAY
*/
	public function get_orders_details()
	{
		if (empty($_POST['nonce'])) {
			wp_die('', '', 400);
		}
		$order_id = $_POST['id'];

		global $wpdb;
		$table_name_orders = $wpdb->get_blog_prefix() . 'covid_orders';
		$table_name_statuses = $wpdb->get_blog_prefix() . 'covid_statuses';

		$orders = $wpdb->get_results("SELECT ir.`id`,
                                                                    `program_id`,
                                                                    `program_title`,
                                                                    `number_blank_id`,
                                                                    `number_blank_comment`,
                                                                     `blank_number`,
                                                                      `blank_series`,
                                                                       `company_id`,
                                                                        `company_title`,
                                                                         `rate_id`,
                                                                          `rate_franchise`,
                                                                           `rate_validity`,
                                                                            `rate_insured_sum`,
                                                                             `rate_price`,
                                                                               `rate_coefficient`,
                                                                                `rate_price_coefficient`,
                                                                                 `name`,
                                                                                  `last_name`,
                                                                                   `passport`,
                                                                                   `citizenship`,
                                                                                    `birthday`,
                                                                                     `address`,
                                                                                      `phone_number`,
                                                                                       `email`,
                                                                                        `date_from`,
                                                                                         `date_to`,
                                                                                          `count_days`,
                                                                                           `pdf_url`,
                                                                                            ir.`status` as status_id,
                                                                                            wis.text as status,
                                                                                             `is_manager`,
                                                                                              `user_id`,
                                                                                               `cashback`,
                                                                                                ir.`date_added`,
                                                                                                ir.`insurer_status`
        FROM " . $table_name_orders . " ir
        LEFT JOIN " . $table_name_statuses . " wis ON wis.id=ir.status
         WHERE ir.id = " . $order_id . "
        ORDER BY ir.id DESC");

		$order = $orders[0];
		$order->manager = $this->km_get_users_name($order->user_id)['name'];

        $insurer_status = (int)$order->insurer_status;

        $insurer_price = 0;

        $total_insurer_rate_price = 0;

        $insurer_price_data = new Covid_Admin_Help();

        if( $insurer_status ){

            /*
             * Надбавки
             * */

            $rate_price = $order->rate_price;
            $insurer_age_coefficient = $order->rate_coefficient;



            $insurer_price = $insurer_price_data->company_price_coeficient( $order->company_id, $order->rate_price, $order->rate_coefficient, $order->rate_price_coefficient );
            $total_insurer_rate_price = $insurer_price;


            /*
             * Страхувальники
             * */
            $insurers = $this->get_insurers( $order->id );

            $insurers_html = '';

            if( $insurers ) {

                $insurers_html .= '<tr><td colspan="2"><hr><h3 style="text-align: center">Страхувальники</h3></td></tr>';

                foreach ($insurers as $insurer) {

                    $insurers_html .= '<tr><td>Ім\'я</td><td>'. $insurer['name'] .'</td></tr>';
                    $insurers_html .= '<tr><td>Прізвище</td><td>'. $insurer['last_name'] .'</td></tr>';
                    $insurers_html .= '<tr><td>Серія і номер паспорту</td><td>'. $insurer['passport'] .'</td></tr>';
                    $insurers_html .= '<tr><td>Дата народження</td><td>'. date('d.m.Y', strtotime($insurer['birthday'])) .'</td></tr>';
                    $insurers_html .= '<tr><td>Адреса</td><td>'. $insurer['address'] .'</td></tr>';
                    $insurers_html .= '<tr><td>Громадянство</td><td>'. $insurer['citizenship'] .'</td></tr>';
                    $insurers_html .= '<tr><td>Коефіцієнт</td><td>'. $insurer['coefficient'] .'</td></tr>';
                    $insurers_html .= '<tr><td>Ціна (грн.)</td><td>'. $insurer['price'] .'</td></tr>';

                    //расчет цены в зависимости от возрастного коеффициента
                    $insurer_age_coefficient = $insurer['coefficient'];

                    $total_insurer_rate_price += $insurer_price_data->company_price_coeficient( $order->company_id, $order->rate_price, $insurer_age_coefficient, $order->rate_price_coefficient );

                }
            }
        }
        else{

            /*
             * Страхувальники
             * */
            $insurers = $this->get_insurers( $order->id );

            $insurers_html = '';

            $rate_price = $order->rate_price;

            if( $insurers ) {

                $insurers_html .= '<tr><td colspan="2"><hr><h3 style="text-align: center">Страхувальники</h3></td></tr>';

                foreach ($insurers as $insurer) {

                    $insurers_html .= '<tr><td>Ім\'я</td><td>'. $insurer['name'] .'</td></tr>';
                    $insurers_html .= '<tr><td>Прізвище</td><td>'. $insurer['last_name'] .'</td></tr>';
                    $insurers_html .= '<tr><td>Серія і номер паспорту</td><td>'. $insurer['passport'] .'</td></tr>';
                    $insurers_html .= '<tr><td>Дата народження</td><td>'. date('d.m.Y', strtotime($insurer['birthday'])) .'</td></tr>';
                    $insurers_html .= '<tr><td>Адреса</td><td>'. $insurer['address'] .'</td></tr>';
                    $insurers_html .= '<tr><td>Громадянство</td><td>'. $insurer['citizenship'] .'</td></tr>';
                    $insurers_html .= '<tr><td>Коефіцієнт</td><td>'. $insurer['coefficient'] .'</td></tr>';
                    $insurers_html .= '<tr><td>Ціна (грн.)</td><td>'. $insurer['price'] .'</td></tr>';

                    //расчет цены в зависимости от возрастного коеффициента
                    $insurer_age_coefficient = $insurer['coefficient'];

                    $total_insurer_rate_price += $insurer_price_data->company_price_coeficient( $order->company_id, $order->rate_price, $insurer_age_coefficient, $order->rate_price_coefficient );

                }
            }


        }



		?>
        <div class="popup_table_wrapper">
            <form>
                <input type="hidden" name="id" value="<?= $order->id; ?>"/>
                <table class="wp-list-table widefat fixed striped posts popup_table">
                    <thead>
                    </thead>
                    <tbody id="rateList">
                    <tr>
                        <td>Id компанії</td>
                        <td><?= $order->company_id; ?></td>
                    </tr>
                    <tr>
                        <td>Id замовлення</td>
                        <td><?= $order->id; ?></td>
                    </tr>
                    <tr>
                        <td>Назва програми</td>
                        <td><?= $order->program_title; ?></td>
                    </tr>
                    <tr>
                        <td>Назва компанії</td>
                        <td><?= $order->company_title; ?></td>
                    </tr>
                    <tr>
                        <td>Серія бланка</td>
                        <td><?= $order->blank_series; ?></td>
                    </tr>
                    <tr>
                        <td>Номер бланку</td>
                        <td><?= $order->blank_number; ?></td>
                    </tr>
                    <tr>
                        <td>Коментар до нумерації бланку</td>
                        <td><?= $order->number_blank_comment; ?></td>
                    </tr>
                    <tr>
                        <td>Франшиза</td>
                        <td><?= $order->rate_franchise; ?></td>
                    </tr>
                    <tr>
                        <td>Перiод страхування (днiв)</td>
                        <td><?= $order->rate_validity; ?></td>
                    </tr>
                    <tr>
                        <td>Страхова сума</td>
                        <td><?= $order->rate_insured_sum; ?></td>
                    </tr>
                    <tr>
                        <td>Територія дії</td>
                        <td><?= $order->rate_locations; ?></td>
                    </tr>
                    <tr>
                        <td>Кількість днів</td>
                        <td><?= $order->count_days; ?></td>
                    </tr>
                    <tr>
                        <td>Ім'я</td>
                        <td><input class="order_popup_field" type="text" maxlength="255" name="name"
                                   value="<?= $order->name; ?>"/>
                        </td>
                    </tr>
                    <tr>
                        <td>Прізвище</td>
                        <td><input class="order_popup_field" type="text" maxlength="255" name="last_name"
                                   value="<?= $order->last_name; ?>"/></td>
                    </tr>
                    <tr>
                        <td>Серія і номер паспорту</td>
                        <td><input class="order_popup_field" type="text" maxlength="255" name="passport"
                                   value="<?= $order->passport; ?>"/></td>
                    </tr>
                    <tr>
                        <td>Дата народження</td>

                        <td><input class="order_popup_field" name="birthday" type="text"
                                   value="<?= date("Y-m-d", strtotime($order->birthday)); ?>" readonly/></td>
                    </tr>
                    <tr>
                        <td>Адреса</td>
                        <td><input class="order_popup_field" type="text" maxlength="255" name="address"
                                   value="<?= $order->address; ?>"/></td>
                    </tr>
                    <tr>
                        <td>Громадянство</td>
                        <td><input class="order_popup_field" type="text" maxlength="255" name="address"
                                   value="<?= $order->citizenship; ?>"/></td>
                    </tr>
                    <tr>
                        <td>Телефон</td>
                        <td><input class="order_popup_field" type="text" maxlength="255" name="phone_number"
                                   value="<?= $order->phone_number; ?>"/>
                        </td>
                    </tr>
                    <tr>
                        <td>Email</td>
                        <td><input class="order_popup_field" type="text" maxlength="255" name="email"
                                   value="<?= $order->email; ?>"/></td>
                    </tr>
                    <tr>
                        <td>Дата початку дії</td>
                        <td>
                            <input class="order_popup_field" name="date_from" type="date"
                                   value="<?= date("Y-m-d", strtotime($order->date_from)); ?>"/>
                        </td>
                    </tr>
                    <tr>
                        <td>Дата закінчення дії</td>
                        <td>
                            <input class="order_popup_field" name="date_to" type="date"
                                   value="<?= date("Y-m-d", strtotime($order->date_to)); ?>"/>
                        </td>
                    </tr>
                    <tr>
                        <td>Статус</td>
                        <td><?= $order->status; ?></td>
                    </tr>
                    <tr>
                        <td>Менеджер</td>
                        <td><?= $order->manager; ?></td>
                    </tr>
                    <tr>
                        <td>Сума повернення менеджеру</td>
                        <td><?= $order->cashback; ?></td>
                    </tr>
                    <tr>
                        <td>Дата додавання запису</td>
                        <td>

                            <input class="order_popup_field" name="date_added" type="date"
                                   value="<?= date("Y-m-d", strtotime($order->date_added)); ?>"/>
                        </td>
                    </tr>
                    <?php if( $insurer_status ) : ?>
                        <tr>
                            <td>Коефіцієнт надбавки (вік)</td>
                            <td><?= $order->rate_coefficient; ?></td>
                        </tr>
                    <?php endif; ?>
                    <tr>
                        <td>Коефіцієнт надбавки від менеджера</td>
                        <td><?= $order->rate_price_coefficient; ?></td>
                    </tr>

                    <?php if( $insurer_status ) : ?>
                        <tr>
                            <td>Ціна (грн.)</td>
                            <td><?= $insurer_price ?></td>
                        </tr>
                    <?php endif; ?>

                    <?php
                        if( ! empty( $insurers_html ) ){
                            echo $insurers_html;
                        }
                    ?>
                    <tr><td colspan="2"><hr></td></tr>
                    <tr>
                        <td><b>Загальна сума договору (грн.)</b></td>
                        <td><?php echo $total_insurer_rate_price; ?></td>
                    </tr>

                    </tbody>
                </table>
                <div style="margin: 15px auto 0px; text-align: center;" >
                    <input style="width:50%" type="submit" id="save_order_details"
                                                       class="button button-primary button-large"
                                                       value="Зберегти"/>
                </div>
            </form>
        </div>
        <style>
            form input[type=date], form input[type=text] {
                width: 100%;
            }
        </style>
		<?php

		wp_die();
	}

	public function save_orders_details()
	{
		if (empty($_POST['nonce'])) {
			wp_die('', '', 400);
		}
		$order_id = $_POST['id'];


		$details = $_POST;
		unset($details['action']);
		unset($details['nonce']);
		unset($details['id']);

		global $wpdb;
		$table_name_orders = $wpdb->get_blog_prefix() . 'covid_orders';
		$res = $wpdb->update($table_name_orders, $details, array('id' => $order_id));

		if ($res || $res === 0) {
			echo json_encode([
				'message' => "Деталі замовлення успішно оновлено.",
				'order_id' => $order_id,
				'status' => 'ok'
			]);
		} else {
			echo json_encode([
				'message' => "Щось пішло не так.",
				'order_id' => $order_id,
				'status' => 'error'
			]);
		}
		die();
	}

	/*
	*   Получаем все франшизы
	*   return ARRAY
	*/
	public
	function get_franchise()
	{

		global $wpdb;

		$table_name_rate = $wpdb->get_blog_prefix() . 'covid_rate';

		$results = $wpdb->get_results("SELECT franchise
        FROM " . $table_name_rate . " GROUP BY franchise", ARRAY_A);

		return $results;

	}


	/*
	*   Получаем все Страховые суммы
	*   return ARRAY
	*/
	public
	function get_insured_sum()
	{

		global $wpdb;

		$table_name_rate = $wpdb->get_blog_prefix() . 'covid_rate';

		$results = $wpdb->get_results("SELECT insured_sum
        FROM " . $table_name_rate . " GROUP BY insured_sum", ARRAY_A);

		return $results;

	}

	/*
	*   Получаем все Територии действия
	*   return ARRAY
	*/
	public function get_locations()
	{

		global $wpdb;

		$table_name_rate = $wpdb->get_blog_prefix() . 'covid_rate';

		$results = $wpdb->get_results("SELECT locations
        FROM " . $table_name_rate . " GROUP BY locations", ARRAY_A);

		return $results;

	}

	/*
*   Получаем все серии бланков
*   return ARRAY
*/
	public function get_blank_series()
	{

		global $wpdb;

		$table_name_orders = $wpdb->get_blog_prefix() . 'covid_orders';

		$results = $wpdb->get_results("SELECT `blank_series` FROM " . $table_name_orders . " GROUP BY `blank_series`", ARRAY_A);

		return $results;

	}

	/*
*   Получаем всех менеджеров
*   return ARRAY
*/
	public function get_managers_ids()
	{
		global $wpdb;
		$table_name_orders = $wpdb->get_blog_prefix() . 'covid_orders';
		$results = $wpdb->get_results("SELECT `user_id` FROM " . $table_name_orders . " GROUP BY `user_id`", ARRAY_A);
		return $results;
	}

	/*
*   Получаем все серии бланков
*   return ARRAY
*/
	public function get_statuses()
	{

		global $wpdb;
		$table_name_statuses = $wpdb->get_blog_prefix() . 'covid_statuses';
		return $wpdb->get_results("SELECT `id`,`text` FROM " . $table_name_statuses, ARRAY_A);
	}

	public function get_paginations($count, $offset, $current_page = 1)
	{

		$page = $count / $offset;
		$page_count = ceil($page);

		$paginations = '<ul>';

		for ($i = 1; $i <= $page_count; $i++) {

			if ($i == $current_page) {
				$paginations .= '<li class="active-page js-active-page"><button class="" data-page="' . $i . '">' . $i . '</button></li>';
			} else {
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
	public function orders_render($orders, $page = 1, $count = 10)
	{
		$result = '';

		$page = $page - 1;

		$statuses = $this->get_statuses();

        $insurer_price_data = new Covid_Admin_Help();


		if (!empty($orders)) {
			$i = 1;
			foreach ($orders as $order) {

                //Определяем какой бланк
                // 1 - из бумаги
                // 2 электронный
                $order_blank_btn = '';

                $order_blank_btn = "<a target='_blank' class='button button-primary button-large more-data get-order-excell' href='/wp-content/plugins/covid/order-print/electronic-form/electronic-form.php?order_id=" . $order['id'] . "&key=TdHjjZycfXfqRF7Ydao4'><i class='fa fa-print' aria-hidden='true'></i></a>";

				$numb = $page * $count + $i;

                $total_insurer_rate_price = 0;

                $insurer_status = $order['insurer_status'];

                if( $insurer_status ){


                    $rate_price = $order['rate_price'];
                    $insurer_age_coefficient = $order['rate_coefficient'];

                    $total_insurer_rate_price += $insurer_price_data->company_price_coeficient( $order['company_id'], $rate_price, $order['rate_coefficient'], $order['rate_price_coefficient'] );



                    /*Страхувальники*/
                    $insurers = $this->get_insurers( $order['id'] );
                    if( $insurers ) {

                        foreach ($insurers as $insurer) {

                            //расчет цены в зависимости от возрастного коеффициента
                            $insurer_age_coefficient = $insurer['coefficient'];

                            $total_insurer_rate_price += $insurer_price_data->company_price_coeficient( $order['company_id'], $rate_price, $insurer_age_coefficient, $order['rate_price_coefficient'] );

                        }
                    }
                    /*Страхувальники кінець*/
                }
                else{
                    /*Страхувальники*/
                    $insurers = $this->get_insurers( $order['id'] );

                    $rate_price = $order['rate_price'];
                    if( $insurers ) {

                        foreach ($insurers as $insurer) {

                            //расчет цены в зависимости от возрастного коеффициента
                            $insurer_age_coefficient = $insurer['coefficient'];

                            $total_insurer_rate_price += $insurer_price_data->company_price_coeficient( $order['company_id'], $rate_price, $insurer_age_coefficient, $order['rate_price_coefficient'] );

                        }
                    }
                    /*Страхувальники кінець*/
                }

				$user_info = $order['user_id'] ? new WP_User($order['user_id']) : wp_get_current_user();



				$order_price = 0;
				$result .= '<tr>';
				$result .= '<td>' . $order['id'] . '</td>';


				$result .= '<td>' . $order['program_title'] . '</td>';
				$result .= '<td>' . $order['company_title'] . '</td>';
				$result .= '<td>' . $order['blank_series'] . '</td>';
				$result .= '<td>' . $order['blank_number'] . '</td>';
				$result .= '<td>' . $total_insurer_rate_price . '</td>';
				$result .= '<td>' . $user_info->display_name . '</td>';
				$result .= '<td>' . date('H:i d.m.y', strtotime($order['date_added'])) . '</td>';
				$result .= '<td>';
				if (!empty($statuses)) {
					$result .= '<select class="order_status" data-id="' . $order['id'] . '">';
					foreach ($statuses as $status) {
						$status_str = ($order['status'] == $status['id']) ? 'selected' : '';
						$result .= '<option ' . $status_str . ' value="' . $status['id'] . '">' . $status['text'] . '</option>';
					}
					$result .= '</select>';
				}
				$result .= '</td>';
				// $result .= '<td><button class="button button-primary button-large js-delete-order" data-id="' . $order['id'] . '"><i class="fa fa-trash"></i></button></td>';
				$result .= '<td class="text-center manage-column">
                                ' . $order_blank_btn . '
                                <button class="button button-primary button-large order-details js-order-details" data-id="' . $order['id'] . '">
                                    <i class="fa fa-info"></i>
                                </button>  

                                <span class="delete-agree">Ви впевненi?
                                    <span>
                                        <button class="button button-primary button-small js-delete-order" data-id="' . $order['id'] . '">Так</button>
                                        <button class="button button-primary button-small js-remove-btn-cancel">Нi</button>
                                    </span>
                                </span>
                                <button class="button button-primary button-large js-remove-btn">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </td>';
				$result .= '</tr>';

				$i++;
			}

		}

		return $result;
	}

	/*
	*   Сортируем Тарифы
	*   return ARRAY
	*/
	public function orders_sort($program_id, $company_id, $blank_series, $manager_id, $franchise, $date_from, $date_to, $status, $orders_limit_from = 0, $offset = 999999, $blank_number = '')
	{

        global $wpdb;

		$where_array = [];
		if (!empty($program_id)) {
			$where_array[] = "io.program_id = '" . $program_id . "'";
		}
		if (!empty($company_id)) {
			$where_array[] =
				"io.company_id = '" . $company_id . "'";
		}
		if (!empty($blank_series)) {
			$where_array[] =
				"blank_series = '" . $blank_series . "'";
		}
		if (!empty($manager_id)) {
			$where_array[] =
				"io.user_id = '" . $manager_id . "'";
		}
		if (!empty($franchise)) {
			$where_array[] =
				"io.rate_franchise = '" . $franchise . "'";
		}
		if (!empty($date_from)) {
			$where_array[] =
				"io.date_added >= '" . $date_from . " 00:00:00'";
		}
		if (!empty($date_to)) {
			$where_array[] =
				"io.date_added <= '" . $date_to . " 23:59:59'";
		}
		if (strlen($status) > 0) {
			$where_array[] =
				"io.status = '" . $status . "'";
		}

        if (!empty($blank_number)) {
            $wild = '%';
            $like = $wild . $wpdb->esc_like( $blank_number ) . $wild;
            $where_array[] =
                "io.blank_number LIKE '" . $like. "'";
        }


		$where = ' WHERE  1 ';

		if (!empty($where_array)) {
			foreach ($where_array as $where_item) {
				$where .= " AND " . $where_item;
			}
		}




		$table_name_orders = $wpdb->get_blog_prefix() . 'covid_orders';

		$results = $wpdb->get_results($wpdb->prepare("SELECT `id`,  `program_title`, `company_id`, `company_title`, `rate_id`,`rate_price`, `blank_series`,`blank_number`, `date_added`, `user_id`, `status`, `insurer_status`, `rate_coefficient`, `rate_price_coefficient`  
        FROM " . $table_name_orders . " io " . $where . "
        ORDER BY io.id DESC LIMIT %d,  %d", $orders_limit_from, $offset), ARRAY_A);

//        $results = $blank_number;

		return $results;
	}

	public function remove_order($id)
	{
		// проверим возможность
		if (current_user_can('covid_orders')) {
			global $wpdb;
			// $id = $_POST['id'];
			$table_name = $wpdb->get_blog_prefix() . 'covid_orders';
			$res = $wpdb->delete($table_name, array('id' => $id), array('%d'));
			// return $product;
			$result = array(
				'message' => "Замовлення було успiшно видалено.",
				'order_id' => $id,
				'status' => 1,
			);
		} else {
			$result = array(
				'message' => "Недостатньо прав.",
				'status' => 0,
			);
		}
		return $result;

		wp_die();
	}

	public function km_get_users_name($user_id = null)
	{

		$user_info = $user_id ? new WP_User($user_id) : wp_get_current_user();

		return ['id' => $user_id, 'name' => $user_info->display_name];
	}



    //Получаем всех страховальников
    //return array

    public function get_insurers( $order_id ){

        global $wpdb;

        $table_name = $wpdb->get_blog_prefix() . 'covid_insurer';

        $result = $wpdb->get_results( "SELECT * FROM " . $table_name . " WHERE order_id = " . $order_id . " ", ARRAY_A );

        return $result;

    }

    //для поиска по ТАБЛИЧКИ ЭЛЕКТРОННЫХ
    /*
     * Получаем тип бланка
     *
     * return INT
     * */
    public function get_order_blank_type_id($id)
    {

        global $wpdb;

        $table_name = $wpdb->get_blog_prefix() . 'covid_orders';

        $result = $wpdb->get_results( "SELECT `number_blank_id`, `blank_number` FROM " . $table_name . " WHERE `id` = " . $id . " ", ARRAY_A );

        return $result;

    }

    //для поиска по ТАБЛИЧКИ ЭЛЕКТРОННЫХ
    /*
     * Смена статуса у ЭЛЕКТРОННОГО бланка
     * */
    public function set_status_e_blank($number_blank_id, $blank_number, $status = 0)
    {

        global $wpdb;
        $table_name = $wpdb->get_blog_prefix() . 'covid_e_blank_number_list';
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

?>