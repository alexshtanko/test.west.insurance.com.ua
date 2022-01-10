<?php

include_once 'class/covid.php';

add_action('init','add_tab_covid');

//Показать подробную информацию по заказу
if (!is_admin()):
    add_action('rcl_enqueue_scripts','add_on_covid_order_info_js',10);
endif;

if(defined('DOING_AJAX') && DOING_AJAX){
    add_action('wp_ajax_nopriv_covid_order_info', 'add_on_covid_order_info'); // No privileges - т.е. гость
    add_action('wp_ajax_covid_order_info', 'add_on_covid_order_info'); // любой залогиненный
}

function add_on_covid_order_info_js(){
    rcl_enqueue_style('add-on-covid-style',rcl_addon_url('css/style.css', __FILE__));
    rcl_enqueue_script( 'add-on-covid-order-info', rcl_addon_url('js/add-on-covid-order-info.js', __FILE__) );
}


function add_on_covid_order_info() {

    rcl_verify_ajax_nonce(); // проверка nonce

    $order_id = $_POST['order_id'];

    $insurance = new Covid_Class();

    $order_data = $insurance->get_covid_order( $order_id );

    $render_order = $insurance->render_covid_order( $order_data );

    echo json_encode( $render_order ); // отправляем в скрипт

    wp_die();

}



//Запрос на изменение статуса
if(defined('DOING_AJAX') && DOING_AJAX){
    add_action('wp_ajax_nopriv_covid_removal_request', 'add_on_covid_removal_request'); // No privileges - т.е. гость
    add_action('wp_ajax_covid_removal_request', 'add_on_covid_removal_request'); // любой залогиненный
}

function add_on_covid_removal_request() {

    rcl_verify_ajax_nonce(); // проверка nonce

    $order_id = $_POST['order_id'];

    $unicue_code = $_POST['unicue_code'];
    $blank_number = $_POST['blank_number'];
    $blank_series = $_POST['blank_series'];

    $insurance = new Covid_Class();

    $statuses = $insurance->get_covid_order_statuses();

//    $insurance->send_email();

    $render_order = $insurance->render_statuses( $statuses, $order_id, $unicue_code, $blank_number, $blank_series );


//    echo json_encode( $render_order ); // отправляем в скрипт
    echo json_encode( $render_order );

    wp_die();

}

//Отправка Email
if(defined('DOING_AJAX') && DOING_AJAX){
    add_action('wp_ajax_nopriv_covid_send_email', 'add_on_covid_send_email'); // No privileges - т.е. гость
    add_action('wp_ajax_covid_send_email', 'add_on_covid_send_email'); // любой залогиненный
}


function add_on_covid_send_email() {

    rcl_verify_ajax_nonce(); // проверка nonce

    $key = 'sqrNKT7A$U49A';
    $order_id = (int) $_POST['order_id'];
    $comment = $_POST['comment'];
    $status = $_POST['status'];
    $status_text = $_POST['status_text'];
    $unicue_code = $_POST['unicue_code'];
    $blank_number = $_POST['blank_number'];
    $blank_series = $_POST['blank_series'];

    $current_user = wp_get_current_user();

    $Covid_Class = new Covid_Class();

    $order_date_added = $Covid_Class->get_covid_order( $order_id );
    $order_date_added = strtotime($order_date_added['date_added']);
    $current_date_start = (int) strtotime(date('Y-m-d'));
    $current_date_end = $current_date_start + 86400;

    /*
     * Определяем если изменения статуса договора поступило в те же сутки в которые он был оформлен.
     * Значит удалаем его автоматически.
     * Если позже, то отправляем письмо адмсинистратору для подтверждения
     * */

    if( $current_date_start >= $order_date_added && $order_date_added <= $current_date_end ){

        $to = array(
            0 => 'alexshtanko@gmail.com',
            1 => get_option('admin_email'),
        );

        $subject = 'Epolicy. Запит на змiну статуса.';

        //ВОшел ли пользователь на сайт (Авторизован)
        if( is_user_logged_in() ){

            $user_name = $current_user->user_firstname;
            $user_last_name = $current_user->user_lastname;

//        $message = '<p>Користувач '. $user_last_name . ' '. $user_name .' подає запит на змiну статуса у полiса з ID = ' . $order_id . '</p><a href="http://epolicy.shtanko.com.ua/wp-content/plugins/insurance/change/change_status.php?key='. $key .'&order_id=1&status='. $status .'&unicue_code=NPzeAdJ3oSzf">Змiнити статус.</a><p>Коментар: '. $comment .'</p>';
            $message = '<p>Користувач '. $user_last_name . ' '. $user_name .' подає запит на змiну статуса на <b>' . $status_text . '</b> у полiса Серія: ' . $blank_series . ' № '. $blank_number .' з ID = ' . $order_id . '</p><a href="http://epolicy.shtanko.com.ua/wp-content/plugins/covid/change/change_status.php?key='. $key .'&order_id='. $order_id .'&status='. $status .'&unicue_code='. $unicue_code .'">Змiнити статус.</a><p>Коментар: '. $comment .'</p>';

            $Covid_Class->send_email( $to, $subject, $message );
        }


    }
    else{

        //для поиска по ТАБЛИЧКИ ЭЛЕКТРОННЫХ
        $blank_type_data = $Covid_Class->get_order_blank_type_id($order_id);
        $e_status = $status != 1 ? 0 : 1;

        $Covid_Class->set_status_e_blank($blank_type_data[0]['number_blank_id'], $blank_type_data[0]['blank_number'], $e_status);

        $Covid_Class->change_status( $order_id, $status, $unicue_code );

    }

    wp_die();

}

//Pagination
if (!is_admin()):
    add_action('rcl_enqueue_scripts','add_on_covid_order_pagination_js',10);
endif;

if(defined('DOING_AJAX') && DOING_AJAX){
    add_action('wp_ajax_nopriv_order_pagination', 'add_on_covid_order_pagination'); // No privileges - т.е. гость
    add_action('wp_ajax_order_pagination', 'add_on_covid_order_pagination'); // любой залогиненный
}

function add_on_covid_order_pagination_js(){
    rcl_enqueue_script( 'add-on-covid-order-pagination', rcl_addon_url('js/add-on-covid-pagination.js', __FILE__) );
}


function add_on_covid_order_pagination() {

    rcl_verify_ajax_nonce(); // проверка nonce

    global $user_ID;

    //Выводим записи начиная с 0
    $limit_from = 0;
    //Отступ 10, т.е. выводим первые 10 записей
    $offset = 10;

    $current_page = $_POST['page'] - 1;

    $referal_id = $_POST['user_id'];

    $insurance = new Covid_Class();

    //Заполняем массив данными
    $insurance->get_all_referels( $user_ID );

    // //Узнаем сколько всего заявок, ТЕСТОВЫЙ ИД 1
    // $orders = $insurance->get_orders( 1 );
    // $orders_count = count( $orders );

    // $page = $orders_count/$offset;

    // $pages = ceil( $page );

    //Если надо показать все договора, формируем строчку из всех ID менеджеров (рефералов) + ID текущего менеджера
    if( $referal_id == 0 ){

        $get_all_referals_id = $insurance->referals_array;

        if( ! empty( $get_all_referals_id ) ){

            $get_all_referals_id = implode( ",", $get_all_referals_id );

            $get_all_referals_id = $user_ID . ',' . $get_all_referals_id;

        }
        //Если у менеджера нет рефералов, то в строку записываем только ID менеджера
        else{

            $get_all_referals_id = $user_ID;

        }

        // $get_all_referals_id = implode( ",", $get_all_referals_id );

        //Все рефералы и актуальный менеджер
        // $referal_id = $user_ID . ',' . $get_all_referals_id;

    }
    else{
        $get_all_referals_id = $referal_id;
    }

    //Делаем оступ в зависимости от страницы
    $limit_from = $current_page * $offset;

    //ID тестового менеджера 91. Для релиза меняем на $referal_id
    $orders_list_data = $insurance->get_covid_orders( $get_all_referals_id, $limit_from, $offset );

    //Отрисовываем заявки
    $render_orders_list = $insurance->render_covid_orders( $orders_list_data );

    //Количество ЗАЯВОК
    // $orders_count = count( $orders_list_data );

    $current_page = $current_page + 1;

    //Узнаем сколько всего заявок, ТЕСТОВЫЙ ИД 1
    $orders = $insurance->get_covid_orders( $get_all_referals_id );
    $orders_count = count( $orders );

    $page = $orders_count/$offset;

    $pages = ceil( $page );
    //пагинация
//    $pagination = $insurance->pagination( $current_page, $orders_count, $pages );
    $pagination = $insurance->pagination( $current_page, $orders_count, $pages );


    $result = array(
        'orders' => $render_orders_list,
        'pagination' => $pagination,
    );

    //Отправляем HTML всех выбраных заявок
    echo json_encode( $result  ); // отправляем в скрипт

    wp_die();

}



//Фильтр заявок
if (!is_admin()):
    add_action('rcl_enqueue_scripts','add_on_covid_order_filter_js',10);
endif;

if(defined('DOING_AJAX') && DOING_AJAX){
    add_action('wp_ajax_nopriv_covid_order_filter', 'add_on_covid_order_filter'); // No privileges - т.е. гость
    add_action('wp_ajax_covid_order_filter', 'add_on_covid_order_filter'); // любой залогиненный
}

function add_on_covid_order_filter_js(){
    rcl_enqueue_script( 'add-on-covid-order-filter', rcl_addon_url('js/add-on-covid-filter.js', __FILE__) );
}


function add_on_covid_order_filter() {

    rcl_verify_ajax_nonce(); // проверка nonce

    global $user_ID;

    //Выводим записи начиная с 0
    $limit_from = 0;
    //Отступ 10, т.е. выводим первые 10 записей
    $offset = 10;

    $referal_id = $_POST['user_id'];

    $insurance = new Covid_Class();

    //Заполняем массив данными
    $insurance->get_all_referels( $user_ID );



    //Если надо показать все договора, формируем строчку из всех ID менеджеров (рефералов) + ID текущего менеджера
    if( $referal_id == 0 ){

        $get_all_referals_id = $insurance->referals_array;

        if( ! empty( $get_all_referals_id ) ){

            $get_all_referals_id = implode( ",", $get_all_referals_id );

            $get_all_referals_id = $user_ID . ',' . $get_all_referals_id;

        }
        //Если у менеджера нет рефералов, то в строку записываем только ID менеджера
        else{

            $get_all_referals_id = $user_ID;

        }

        // $get_all_referals_id = implode( ",", $get_all_referals_id );

        //Все рефералы и актуальный менеджер
        // $referal_id = $user_ID . ',' . $get_all_referals_id;

    }
    else{
        $get_all_referals_id = $referal_id;
    }

    //ID тестового менеджера 91. Для релиза меняем на $referal_id
    $orders_list_data = $insurance->get_covid_orders( $get_all_referals_id, $limit_from, $offset );

    //Отрисовываем заявки
    $render_orders_list = $insurance->render_covid_orders( $orders_list_data );

    //Количество ЗАЯВОК
    // $orders_count = count( $orders_list_data );

    //Узнаем сколько всего заявок, ТЕСТОВЫЙ ИД 91
    // $orders = $insurance->get_orders( 91 );
    $orders = $insurance->get_covid_orders( $get_all_referals_id );
    $orders_count = count( $orders );

    $page = $orders_count/$offset;

    $pages = ceil( $page );


    //пагинация
    $pagination = $insurance->pagination( 1, $orders_count, $pages );


    $result = array(
        'orders' => $render_orders_list,
        'pagination' => $pagination,
    );

    //Отправляем HTML всех выбраных заявок
    echo json_encode( $result  ); // отправляем в скрипт

    wp_die();

}


//Excell
if (!is_admin()):
    add_action('rcl_enqueue_scripts','add_on_covid_get_excell_order_js',10);
endif;

if(defined('DOING_AJAX') && DOING_AJAX){
    add_action('wp_ajax_nopriv_get_excell_order', 'add_on_covid_get_excell_order'); // No privileges - т.е. гость
    add_action('wp_ajax_get_excell_order', 'add_on_covid_get_excell_order'); // любой залогиненный
}

function add_on_covid_get_excell_order_js(){
    rcl_enqueue_script( 'add-on-covid-get_excell_order', rcl_addon_url('js/add-on-covid-get-excell-order.js', __FILE__) );
}


function add_on_covid_get_excell_order() {

    rcl_verify_ajax_nonce(); // проверка nonce

    global $user_ID;

    $order_id = $_POST['order_id'];

    $insurance = new Covid_Class();

    $user = $insurance->export_excell( $order_id );

    //Отправляем HTML всех выбраных заявок
    echo json_encode( $user  ); // отправляем в скрипт

    wp_die();

}



function add_tab_covid(){

    global $user_ID;

    $tab_data =	array(
        'id'=>'covid_91',
        'name'=>'Covid',
        'public'=>0,//делаем вкладку приватной
        'icon'=>'fa-files-o',//указываем иконку
        'output'=>'menu',//указываем область вывода
        'content'=>array(
            array( //массив данных первой дочерней вкладки
                'callback' => array(
                    'name'=>'covid_recall_block',//функция формирующая контент
                )
            )
        )
    );


    //Для теста отображаем таб только для пользователя с ID = 91. Надо бурать условие после релиза
    // if( $user_ID == 91 ){
    //     rcl_tab($tab_data);
    // }

    $user = wp_get_current_user();

    $allowed_roles = array('administrator', 'user_manager');

    if( array_intersect($allowed_roles, $user->roles ) ) {
        rcl_tab($tab_data);
    }



}

function covid_recall_block($user){
    add_thickbox();
    global $user_ID;
    global $wpdb;

    //Выводим записи начиная с 0
    $limit_from = 0;
    //Отступ 10, т.е. выводим первые 10 записей
    $offset = 10;

    //Для теста подставили 1. Т.к. тестовые договора оформлены под АДМИНОМ с ИД = 1
    $user_id = $user_ID;

    $result = '';

    $insurance = new Covid_Class();

    //Для теста подставляем 29 т.к. у этого опльзователя есть реферальные менеджеры с уровнем вложености
    // $user_id = 29;

    //Заполняем массив данными
    $insurance->get_all_referels( $user_id );

    //Получаем ID всех рефералов включая вложеность
    $get_all_referals_id = $insurance->referals_array;

    if( ! empty( $get_all_referals_id ) ){

        $get_all_referals_id = implode( ",", $get_all_referals_id );

        $get_all_referals_id = $user_id . ',' . $get_all_referals_id;

    }
    else{

        $get_all_referals_id = $user_id;

    }


    $referal_data = $insurance->referels_data( $get_all_referals_id );

    $render_filter = $insurance->render_filter_form( $referal_data );

    $result .= $render_filter;

    $result .= '<div class="add-on-insurance-rate-list-wrapper js-add-on-insurance-rate-list-wrapper">';

    //Узнаем сколько всего заявок
    // $orders = $insurance->get_orders( 1 );
    $orders = $insurance->get_covid_orders( $get_all_referals_id );

    $orders_count = count( $orders );

    $page = $orders_count/$offset;

    $pages = ceil( $page );

    //Получаем все ЗАЯВКИ пользователя. ДЛЯ теста взят ID = 1
    // $orders_list_data = $insurance->get_orders( 1, $limit_from, $offset );
    $orders_list_data = $insurance->get_covid_orders( $get_all_referals_id, $limit_from, $offset );

    //Количество ЗАЯВОК
    // $orders_count = count( $orders_list_data );

    $render_orders_list = $insurance->render_covid_orders( $orders_list_data );

    $result .= $render_orders_list;

    $result .= "</div>";

    //пагинация
    $pagination = $insurance->pagination( 1, $orders_count, $pages );

    $result .= '<div class="add-on-insurance-pagination js-add-on-insurance-pagination" id="pagination">';

    $result .= $pagination;

    $result .= '</div>';

    return $result;

}


?>