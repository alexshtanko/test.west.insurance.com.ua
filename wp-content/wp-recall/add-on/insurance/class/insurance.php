<?php

require($_SERVER['DOCUMENT_ROOT'].'/wp-load.php');

require ABSPATH . '/vendor/autoload.php';

require_once ABSPATH . '/wp-content/plugins/insurance/admin/include/class-insurance-admin-help.php';

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Insurance_Class {

    function __construct() {

    }

    public $referals_array = array();


    /*  Получаем всех рефералов указаного пользователя $user_id
    *   return ARRAY
    */
    public function get_referals( $user_id ) {

        global $wpdb;

//        $table_name = $wpdb->prefix . 'prt_partners';

        $table_name = 'plc_9115_prt_partners';
//        $referal = $wpdb->get_results( "SELECT referal FROM " . WP_PREFIX . "prt_partners WHERE partner='$user_id'", ARRAY_A );
        $referal = $wpdb->get_results( "SELECT referal FROM " . $table_name . " WHERE partner='$user_id'", ARRAY_A );

        return $referal;

    }

    //Заполняем массив ID всех рефералов включая вложенность
    public function get_all_referels( $user_id ) {

        if( ! $user_id )
            return false;

        $referals = array();

        $referals = $this->get_referals( $user_id );

        if( $referals ){
            foreach( $referals as $referal_id ){

                // $this->referals_array[$user_id]['referals_id'][] = $referal_id['referal'];

                $this->referals_array[] = $referal_id['referal'];

                $this->get_all_referels( $referal_id['referal'] );

            }
        }

    }

    /*  Получаем данные рефералов
    *   return array
    */
    public function referels_data( $user_id ) {

        global $wpdb;

        $table_name = $wpdb->get_blog_prefix() . 'users';

        $result = $wpdb->get_results( "SELECT id, display_name as name FROM " . $table_name . " WHERE ID IN (".$user_id.")", ARRAY_A );

        return $result;


    }

    /*  Отрисовываем фильр
    *   return html
    */
    public function render_filter_form( $data ) {

        $result = '';

        $result .= '<div class="add-on-insurance-filetr-wrapper">';
        $result .= '<label class="add-on-insurance-label">Оберіть менеджера:</label>';
        $result .= '<select>';
        $result .= '<option value="0">Усі</option>';

        foreach( $data as $data_item ){

            $result .= '<option value="' . $data_item['id'] . '">' . $data_item['name'] . '</option>';

        }

        $result .= '</select>';

        $result .= '<button class="js-insurance-order-filter-btn">Фільтрувати</button>';

        $result .= '</div>';
        return $result;

    }

    /*  Получаем заявки
    *   return array
    */
    public function get_orders( $user_id, $limit_from = 0, $offset = 99999999 ) {

        global $wpdb;

        $table_name = $wpdb->get_blog_prefix() . 'insurance_orders';

        $result = $wpdb->get_results( "SELECT * FROM " . $table_name . " WHERE user_id IN (".$user_id.") AND status = 1 ORDER BY id DESC LIMIT " . $limit_from . ", " . $offset . " ", ARRAY_A );

        return $result;

    }


    /*  Получаем заявку
    *   return array
    */
    public function get_order( $order_id ) {

        global $wpdb;

        $table_name = $wpdb->get_blog_prefix() . 'insurance_orders';

        $result = $wpdb->get_row( "SELECT * FROM " . $table_name . " WHERE id = " . $order_id . " AND status = 1", ARRAY_A );

        return $result;

    }


    /*
    * Пагинация
    * return HTML
    */
    public function pagination( $page = 1, $orders_count = 1, $pages = 1 ) {

        // $order_per_page = 5;

        // $pages = ceil( $orders_count / $order_per_page );

        $result = '<span class="js-paginations-total-pages" data-pages="' . $pages . '">Усього сторінок: <b>' . $pages .  '</b></span>&nbsp;|&nbsp;<span class="add-on-pagination-orders-total">Кількість заявок: <b>' . $orders_count . '</b></span>';

        $result .= '<div class="add-on-insurance-pagination-btn add-on-insurance-pagination-btn-prev"><i class="fa fa-angle-left" aria-hidden="true"></i></div>';
        $result .= '<input class="add-on-insurance-pagination-inpt js-add-on-insurance-pagination-inpt" type="text" value="' . $page . '">';
        $result .= '<div class="add-on-insurance-pagination-btn add-on-insurance-pagination-btn-next"><i class="fa fa-angle-right" aria-hidden="true"></i></div>';

        return $result;

    }

    /*  Отрисовываем заявки
    *   return html
    */
    public function render_orders( $orders ) {

        $result = '';

        $result .= "<table class='wp-list-table widefat fixed striped posts add-on-insurance-rate-list'>";

        $result .= "<thead>
                <th scope='col' class='manage-column' style='width:35px;'>ID</th>
				<th scope='col' class='manage-column'>Прізвище ім'я</th>
				<th scope='col' class='manage-column'>Телефон</th>
				<th scope='col' class='manage-column' style='width:80px;'>Номер договору</th>
				<th scope='col' class='manage-column' style='width:60px;'>Ціна, грн.</th>
				<th scope='col' class='manage-column'>Компанія</th>
				<th scope='col' class='manage-column' style='width:110px;'>Дата запису</th>
				<th scope='col' class='manage-column'>Інформація</th>
              </thead>";

        $result .= "<tbody id='contractsInfo'>";

        $insurer_price_data = new Insurance_Admin_Help();

        foreach( $orders as $order ){

            $insurer_status = (int)$order['insurer_status'];

            $total_insurer_rate_price = 0;

            $order_blank_btn = '';

            if( $insurer_status ){

                $insurer_price = $insurer_price_data->company_price_coeficient( $order['company_id'], $order['rate_price'], $order['rate_coefficient'], $order['rate_price_coefficient'] );
                $total_insurer_rate_price = $insurer_price;

                //Страхувальники
                $insurers = $this->get_insurers( $order['id'] );

                if( $insurers ) {

                    foreach ($insurers as $insurer) {

                        //расчет цены в зависимости от возрастного коеффициента
                        $insurer_age_coefficient = $insurer['coefficient'];

                        $total_insurer_rate_price += $insurer_price_data->company_price_coeficient( $order['company_id'], $order['rate_price'], $insurer_age_coefficient, $order['rate_price_coefficient'] );

                    }
                }

            }
            else{

                
                $insurers = $this->get_insurers( $order['id'] );

                if( $insurers ) {

                    foreach ($insurers as $insurer) {

                        //расчет цены в зависимости от возрастного коеффициента
                        $insurer_age_coefficient = $insurer['coefficient'];

                        $total_insurer_rate_price += $insurer_price_data->company_price_coeficient( $order['company_id'], $order['rate_price'], $insurer_age_coefficient, $order['rate_price_coefficient'] );

                    }
                }

            }

            //Определяем какой бланк
            // 1 - из бумаги
            // 2 электронный
            if( $order['blank_type_id'] == 1 ){

                if( $order['company_id'] == 2 )
                {
                    if( $order['id'] >= 1003 )
                    {
                        $order_blank_btn = "<a target='_blank' class='button button-primary button-large more-data get-order-excell' href='/wp-content/plugins/insurance/order-print/paper/index.php?order_id=" . $order['id'] . "&key=WPbm49ebf124'><i class='fa fa-file-excel-o' aria-hidden='true'></i></a>";
                    }
                    else
                    {
                        $order_blank_btn = "<a target='_blank' class='button button-primary button-large more-data get-order-excell' href='/wp-content/wp-recall/add-on/insurance/report/download_print.php?order_id=" . $order['id'] . "&key=WPbm49ebf124'><i class='fa fa-file-excel-o' aria-hidden='true'></i></a>";
                    }
                }
                elseif( $order['company_id'] == 4 )
                {
                    $order_blank_btn = "<a target='_blank' class='button button-primary button-large more-data get-order-excell' href='/wp-content/plugins/insurance/order-print/paper/index.php?order_id=" . $order['id'] . "&key=WPbm49ebf124'><i class='fa fa-file-excel-o' aria-hidden='true'></i></a>";
                }
                elseif( $order['company_id'] == 6 )
                {
                    $order_blank_btn = "<a target='_blank' class='button button-primary button-large more-data get-order-excell' href='/wp-content/plugins/insurance/order-print/paper/index.php?order_id=" . $order['id'] . "&key=WPbm49ebf124'><i class='fa fa-file-excel-o' aria-hidden='true'></i></a>";
                }
                else
                {
                    $order_blank_btn = "<a target='_blank' class='button button-primary button-large more-data get-order-excell' href='/wp-content/wp-recall/add-on/insurance/report/download_print.php?order_id=" . $order['id'] . "&key=WPbm49ebf124'><i class='fa fa-file-excel-o' aria-hidden='true'></i></a>";
                }

//                if( $order['company_id'] != 4 || $order['company_id'] != 6 ) {
//                    $order_blank_btn = "<a target='_blank' class='button button-primary button-large more-data get-order-excell' href='/wp-content/wp-recall/add-on/insurance/report/download_print.php?order_id=" . $order['id'] . "&key=WPbm49ebf124'><i class='fa fa-file-excel-o' aria-hidden='true'></i></a>";
//                }
//                else
//                {
//                    $order_blank_btn = "<a target='_blank' class='button button-primary button-large more-data get-order-excell' href='/wp-content/plugins/insurance/order-print/paper/index.php?order_id=" . $order['id'] . "&key=WPbm49ebf124'><i class='fa fa-file-excel-o' aria-hidden='true'></i></a>";
//                }
            }
            elseif ( $order['blank_type_id'] == 2 ){

                $order_blank_btn = "<a target='_blank' class='button button-primary button-large more-data get-order-excell' href='/wp-content/plugins/insurance/order-print/electronic-form/electronic-form.php?order_id=" . $order['id'] . "&key=kDCRa89dc0e1'><i class='fa fa-file-excel-o' aria-hidden='true'></i></a>";

            }


            $date_added = date( 'd.m.Y', strtotime( $order['date_added'] ) );

            $phone = preg_replace('~[^+0-9]+~','', $order['phone_number']);

            $result .= "<tr>
					<td>".$order['id']."</td>
					<td>".$order['last_name']." ".$order['name']."</td>
					<td><a href='tel:".$phone."'>".$order['phone_number']."</a></td>
					<td>". $order['blank_series'] . " " . $order['blank_number'] . "</td>
					<td>".$total_insurer_rate_price."</td>
					<td>".$order['company_title']."</td>
					<td>".$date_added."</td>
					<td>
                        <button type='submit' class='button button-primary button-large more-data js-get-order-info' data-order-id='".$order['id']."''><i class='fa fa-eye'></i></button>" . $order_blank_btn . "
                        
                        <button class='button button-primary button-large more-data js-insurance-removal-request' data-blank-number='". $order['blank_number'] ."' data-blank-series='". $order['blank_series'] ."' data-order-id='".$order['id']."' data-unicue-code='" . $order['unicue_code'] . "'><i class='fa fa-trash-o' aria-hidden='true'></i></button>               
                    </td>
				  </tr>";
                  
        }

        $result .= "</tbody>";

        $result .= "</table>";

        $result .= "<div id='my-modal-id' style='display:none;'><div></div></div><a name='Детально про договір' style='display: none;' href='/?TB_inline&width=600&height=550&inlineId=my-modal-id' class='thickbox show-modal-data'>Открыть модальное окно</a>";

        return $result;
    }

    /*  Отрисовываем заявку
    *   return html
    */
    public function render_order( $order ) {

        $insurer_status = (int)$order['insurer_status'];

        $insurer_price_data = new Insurance_Admin_Help();

        $total_insurer_rate_price = 0;

        if( $insurer_status ){

            $insurer_price = $insurer_price_data->company_price_coeficient( $order['company_id'], $order['rate_price'], $order['rate_coefficient'], $order['rate_price_coefficient'] );
            $total_insurer_rate_price = $insurer_price;

            /*
            * Страхувальники
            * */
            $insurers = $this->get_insurers( $order['id'] );

            $insurers_html = '';

            if( $insurers ) {

                $insurers_html .= '<tr><td colspan="2"><hr><h3 style="text-align: center">Страхувальники</h3></td></tr>';

                foreach ($insurers as $insurer) {

                    $insurers_html .= "<tr><td>Ім'я</td><td>". $insurer['name'] ."</td></tr>";
                    $insurers_html .= "<tr><td>Прізвище</td><td>". $insurer['last_name'] ."</td></tr>";
                    $insurers_html .= "<tr><td>Серія і номер паспорту</td><td>". $insurer['passport'] ."</td></tr>";
                    $insurers_html .= "<tr><td>Дата народження</td><td>". date('d.m.Y', strtotime($insurer['birthday'])) . "</td></tr>";
                    $insurers_html .= "<tr><td>Адреса</td><td>" . $insurer['address'] . "</td></tr>";
                    $insurers_html .= "<tr><td>Коефіцієнт</td><td>". $insurer['coefficient'] . "</td></tr>";
                    $insurers_html .= "<tr><td>Ціна (грн.)</td><td>". $insurer['price'] . "</td></tr>";

                    //расчет цены в зависимости от возрастного коеффициента
                    $insurer_age_coefficient = $insurer['coefficient'];

                    $total_insurer_rate_price += $insurer_price_data->company_price_coeficient( $order['company_id'], $order['rate_price'], $insurer_age_coefficient, $order['rate_price_coefficient'] );

                }
            }

        }
        else{

            /*
            * Страхувальники
            * */
            $insurers = $this->get_insurers( $order['id'] );

            $insurers_html = '';

            if( $insurers ) {

                $insurers_html .= '<tr><td colspan="2"><hr><h3 style="text-align: center">Страхувальники</h3></td></tr>';

                foreach ($insurers as $insurer) {

                    $insurers_html .= "<tr><td>Ім'я</td><td>". $insurer['name'] ."</td></tr>";
                    $insurers_html .= "<tr><td>Прізвище</td><td>". $insurer['last_name'] ."</td></tr>";
                    $insurers_html .= "<tr><td>Серія і номер паспорту</td><td>". $insurer['passport'] ."</td></tr>";
                    $insurers_html .= "<tr><td>Дата народження</td><td>". date('d.m.Y', strtotime($insurer['birthday'])) . "</td></tr>";
                    $insurers_html .= "<tr><td>Адреса</td><td>" . $insurer['address'] . "</td></tr>";
                    $insurers_html .= "<tr><td>Коефіцієнт</td><td>". $insurer['coefficient'] . "</td></tr>";
                    $insurers_html .= "<tr><td>Ціна (грн.)</td><td>". $insurer['price'] . "</td></tr>";


                    //расчет цены в зависимости от возрастного коеффициента
                    $insurer_age_coefficient = $insurer['coefficient'];

                    $total_insurer_rate_price += $insurer_price_data->company_price_coeficient( $order['company_id'], $order['rate_price'], $insurer_age_coefficient, $order['rate_price_coefficient'] );

                }

            }

        }

        $phone = preg_replace('~[^+0-9]+~','', $order['phone_number']);
        $date_from = date( 'd.m.Y', strtotime( $order['date_from'] ) );
        $date_to = date( 'd.m.Y', strtotime( $order['date_to'] ) );
        $birthday = date( 'd.m.Y', strtotime( $order['birthday'] ) );

        $result = '';

        $result .= "<table class='wp-list-table widefat fixed striped posts'>";

        $result .= "<tbody>";

        $result .= "<tr><td>Назва бланка</td><td>" . $order['program_title'] . "</td></tr>";
        $result .= "<tr><td>Серія бланка</td><td>" . $order['blank_series'] . "</td></tr>";
        $result .= "<tr><td>Номер бланка</td><td>" . $order['blank_number'] . "</td></tr>";
        $result .= "<tr><td>Назва компанії</td><td>" . $order['company_title'] . "</td></tr>";
        $result .= "<tr><td>Франшиза</td><td>" . $order['rate_franchise'] . "</td></tr>";
        $result .= "<tr><td>Термін дії</td><td>" . $order['rate_validity'] . "</td></tr>";
        $result .= "<tr><td>Початок дії договору</td><td>" . $date_from . "</td></tr>";
        $result .= "<tr><td>Завершення договору</td><td>" . $date_to . "</td></tr>";
        $result .= "<tr><td>Страхова сума</td><td>" . $order['rate_insured_sum'] . "</td></tr>";
        $result .= "<tr><td>Ціна</td><td>" . $order['rate_price'] . "</td></tr>";
        $result .= "<tr><td>Територія дії</td><td>" . $order['rate_locations'] . "</td></tr>";
        $result .= "<tr><td>Прізвище</td><td>" . $order['last_name'] . "</td></tr>";
        $result .= "<tr><td>Ім'я</td><td>" . $order['name'] . "</td></tr>";
        $result .= "<tr><td>Паспорт</td><td>" . $order['passport'] . "</td></tr>";
        $result .= "<tr><td>Адреса</td><td>" . $order['address'] . "</td></tr>";
        $result .= "<tr><td>Дата народження</td><td>" . $birthday . "</td></tr>";
        $result .= "<tr><td>Номер телефону</td><td><a href='tel:" . $phone . "'>" . $order['phone_number'] . "</a></td></tr>";
        $result .= "<tr><td>Email</td><td><a href='mailto:" . $order['email'] . "'>" . $order['email'] . "</a></td></tr>";

        $result .= $insurers_html;
        $result .= "<tr><td><b>Загальна сума договору (грн.)</b></td><td>" .  $total_insurer_rate_price . "</td></tr>";
        $result .= "<tr><td>Дата і час запису</td><td>" . $order['date_added'] . "</td></tr>";

        




        $result .= "</tbody>";

        $result .= "</table>";

        return $result;
    }



    /*
    * Excell
    * return TRUE, FALSE
    */
    public function export_excell( $order_id ) {

        global $user_ID;

        $user = wp_get_current_user();

        $allowed_roles = array('user_manager', 'administrator', 'editor');

//        $result = $user->roles;


        if( $user->roles[0] == 'administrator' || $user->roles[0] == 'editor' )
        {
            $result = true;
        }
        else
        {
            if( array_intersect($allowed_roles, $user->roles ) ) {

                //Для теста подставляем 29 т.к. у этого опльзователя есть реферальные менеджеры с уровнем вложености
                // $user_id = 29;

                //Заполняем массив данными
                $this->get_all_referels( $user_ID );

                //Получаем ID всех рефералов включая вложеность
                $get_all_referals_id = $this->referals_array;

                //Если у менеджеоа есть рефералы, то формируем строку из ID менеджера и рефералов
                if( ! empty( $get_all_referals_id ) ){

                    $get_all_referals_id = implode( ",", $get_all_referals_id );

                    $get_all_referals_id = $user_ID . ',' . $get_all_referals_id;

                }
                //Если у менеджера нет рефералов, то в строку записываем только ID менеджера
                else{

                    $get_all_referals_id = $user_ID;

                }

                $orders = $this->get_orders( $get_all_referals_id );

                //Проверяем есть ли у даного менеджера или его рефералов договор по ID которого передали
                $exist = array_search( $order_id, array_column( $orders, 'id'));

                $result = false;

                if( is_numeric( $exist ) ){

                    $result = true;

                }
                else{

                    $result = false;

                }

            }
        }

        /*if( array_intersect($allowed_roles, $user->roles ) ) {

            //Для теста подставляем 29 т.к. у этого опльзователя есть реферальные менеджеры с уровнем вложености
            // $user_id = 29;

            //Заполняем массив данными
            $this->get_all_referels( $user_ID );

            //Получаем ID всех рефералов включая вложеность
            $get_all_referals_id = $this->referals_array;

            //Если у менеджеоа есть рефералы, то формируем строку из ID менеджера и рефералов
            if( ! empty( $get_all_referals_id ) ){

                $get_all_referals_id = implode( ",", $get_all_referals_id );

                $get_all_referals_id = $user_ID . ',' . $get_all_referals_id;

            }
            //Если у менеджера нет рефералов, то в строку записываем только ID менеджера
            else{

                $get_all_referals_id = $user_ID;

            }

            $orders = $this->get_orders( $get_all_referals_id );

            //Проверяем есть ли у даного менеджера или его рефералов договор по ID которого передали
            $exist = array_search( $order_id, array_column( $orders, 'id'));

            $result = false;

            if( is_numeric( $exist ) ){

                $result = true;

            }
            else{

                $result = false;

            }

        }*/

        return $result;

    }

    /*
     * Получаем все статусы заявок
     * return array
     */
    public function get_order_statuses(){

        global $wpdb;

        $table_name = $wpdb->get_blog_prefix() . 'insurance_statuses';

        $result = $wpdb->get_results( "SELECT * FROM " . $table_name . " WHERE NOT id=1 ", ARRAY_A );

        return $result;

    }

    /*
     * Выводим форму смены статусов договоров
     * eturn HTML
     *
     * */

    public function render_statuses( $statuses, $order_id, $unicue_code = '', $blank_number, $blank_series ){

        $result = '';

//        $result .= 'Функционал в разработке.';

        $result .= '<div class="add-on-removal-request-wrapper">';

        $result .= '<div class="add-on-modal-title">Форма зміни статусу до договору</div>';
        $result .= '<label class="lbl-1">Оберіть статус</label>';
        $result .= '<div class="select-wrapper"><select id="removalRequestStatus">';
        foreach ( $statuses as $status )
        {
            $result .= '<option value="'. $status["id"] .'">' . $status["text"] . '</option>';
        }
        $result .= '</select></div>';

        $result .='<label class="lbl-1">Залиште коментар</label><textarea class="txt-area-1" id="removalRequestComments"></textarea>';



        $result .='<button class="button button-primary button-large box-center" id="sendRemovalRequest" data-blank-number="'. $blank_number .'" data-blank-series="'. $blank_series .'" data-order-id="'. $order_id .'" data-unicue-code="' .  $unicue_code .'">Надіслати запит</button>';

        $result .='<div class="form-message js-form-message"></div>';
        $result .= '</div>';

        return $result;

    }

    /*
     * Отправка Email
     * */
    public function send_email( $to, $subject, $message ){

//        $to = 'epolicy@i.ua';
//         $to = 'alexshtanko@gmail.com';

        $site_email =  get_bloginfo( $show = 'admin_email' );
//        $site_email =  'tes1t@gmail.com';

//        $subject = 'Epolicy. Запит на змыну статуса.';
//        $message = 'Привет';

        $headers = "From: " . $site_email . "\r\n";
        $headers .= "Reply-To: ". $site_email . "\r\n";
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: text/html; charset=UTF-8\r\n";

        $header_ = 'MIME-Version: 1.0' . "\r\n" . 'Content-type: text/html; charset=UTF-8' . "\r\n";
        wp_mail($to, '=?UTF-8?B?'.base64_encode($subject).'?=', $message, $header_ . $headers);

//        wp_die();

    }

    //Получаем всех страховальников
    //return array

    public function get_insurers( $order_id ){

        global $wpdb;

        $table_name = $wpdb->get_blog_prefix() . 'insurance_insurer';

        $result = $wpdb->get_results( "SELECT * FROM " . $table_name . " WHERE order_id = " . $order_id . " ", ARRAY_A );

        return $result;

    }


    public function change_status( $order_id, $status, $unicue_code ){

        global $wpdb;

        $table_name_orders = $wpdb->get_blog_prefix() . 'insurance_orders';

        $result = $wpdb->update( $table_name_orders, ['status' => $status], ['id' => $order_id, 'unicue_code' => $unicue_code] );


        /*require($_SERVER['DOCUMENT_ROOT'].'/wp-load.php');

        $key = 'sqrNKT7A$U49A';
        require ABSPATH . '/vendor/autoload.php';

//Check key to run the script
        if ( $key == $_GET['key'] ){

            $order_id = (int)$_GET['order_id'];
            $status = $_GET['status'];
            $unicue_code = $_GET['unicue_code'];


            if( !empty ( $order_id ) && $status != '' && ! empty( $unicue_code ) ){

                global $wpdb;

                $table_name_orders = $wpdb->get_blog_prefix() . 'insurance_orders';

                $result = $wpdb->update( $table_name_orders, ['status' => $status], ['id' => $order_id, 'unicue_code' => $unicue_code] );

                if( $result != false ){

                    echo 'Статус був успiшно замiнений';

                }
                else{
                    echo 'Не знайдено договору для змiни статусу. ';
                }


            }
            else{
                echo 'Помилка. Не всi данi було передано.';
            }

        }
        else{
            echo 'Невiрний ключ.';
        }*/

    }


    //для поиска по ТАБЛИЧКИ ЭЛЕКТРОННЫХ
    /*
     * Смена статуса у ЭЛЕКТРОННОГО бланка
     * */
    public function set_status_e_blank($number_blank_id, $blank_number, $status = 0)
    {

        global $wpdb;
        $table_name = $wpdb->get_blog_prefix() . 'insurance_e_blank_number_list';
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