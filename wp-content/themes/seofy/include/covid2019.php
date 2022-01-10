<?php


add_action('wp_ajax_covidgetblanks', 'covid_get_blanks');
add_action('wp_ajax_nopriv_covidgetblanks', 'covid_get_blanks');

function covid_get_blanks(){

    if( empty( $_POST['nonce'] ) ){
        wp_die('', '', 400);
    }

    check_ajax_referer( 'medical-m', 'nonce', true );

    $blank_type_id = 1;

    global $wpdb;

    $table_name_rate = $wpdb->get_blog_prefix() . 'covid_rate';
    $table_name_program = $wpdb->get_blog_prefix() . 'covid_program';

    $blanks = $wpdb->get_results('SELECT DISTINCT p.id, p.title FROM ' . $table_name_rate . ' r 
    RIGHT JOIN ' . $table_name_program . ' p on p.id = r.program_id AND p.status = 1 
    WHERE 1 GROUP BY r.program_id;' );

    if( $blanks ){
        $result = array(
            'message' => 'OK )',
            'blanks' => $blanks
        );
    }
    else{
        $result = array(
            'message' => 'На даний момент не додано жодного бланку',
            'blanks' => ''
        );
    }


    echo json_encode( $result );

    wp_die();
}


add_action('wp_ajax_covidperiod', 'get_covid_period');
add_action('wp_ajax_nopriv_covidperiod', 'get_covid_period');

function get_covid_period(){

    if( empty( $_POST['nonce'] ) ){
        wp_die('', '', 400);
    }

    check_ajax_referer( 'medical-m', 'nonce', true );

    $program_id = $_POST['blank_id'];


    global $wpdb;

    $table_name_rate = $wpdb->get_blog_prefix() . 'covid_rate';
    $table_name_blank = $wpdb->get_blog_prefix() . 'insurance_program';
    $table_name_company = $wpdb->get_blog_prefix() . 'insurance_company';

    $results = $wpdb->get_results( $wpdb->prepare("SELECT DISTINCT ir.validity 
    FROM " . $table_name_rate . " ir 
    WHERE program_id = " . $program_id . "
    GROUP BY ir.validity DESC ORDER BY CONVERT(Substring_Index(ir.validity, '/', -1), SIGNED INTEGER) DESC", '%d' ), ARRAY_A );


    // ORDER BY ir.id DESC", '%d' ), ARRAY_A );
    // return $results;

    $result = array(
        'test' => $_POST['test'],
        'results' => $results,
    );

    echo json_encode($result);

    wp_die();
}


add_action('wp_ajax_getcovidinsurancelist', 'covid_insurance_list');
add_action('wp_ajax_nopriv_getcovidinsurancelist', 'covid_insurance_list');

function covid_insurance_list(){

    if( empty( $_POST['nonce'] ) ){
        wp_die('', '', 400);
    }

    check_ajax_referer( 'medical-m', 'nonce', true );

    $program_id = $_POST['program_id'];

    $blank_type_id = 1;

    //Надо получить данные страховки

    $validity = $_POST['validity'];

    global $wpdb;

    $table_name_rate = $wpdb->get_blog_prefix() . 'covid_rate';
    $table_name_program = $wpdb->get_blog_prefix() . 'covid_program';
    $table_name_company = $wpdb->get_blog_prefix() . 'covid_company';

    /*$result = $wpdb->get_results( $wpdb->prepare( "SELECT ir.id, ir.franchise, ir.validity, ir.insured_sum, ir.price, ir.company_id, ic.title as commpany_title, ic.logo_url as company_logo_url, ir.program_id, ib.title as program_title
    FROM " . $table_name_rate . " ir
    left join " . $table_name_company . " ic on ic.id = ir.company_id
    left join " . $table_name_program . " ib on ib.id = ir.program_id
    WHERE ir.validity = '" . $validity . "' AND ir.program_id = '" . $program_id . "' ORDER BY ir.id ASC", '%d', '%d' ), ARRAY_A );*/

    $result = $wpdb->get_results( $wpdb->prepare( "SELECT 
       ir.id, 
       ir.franchise, 
       ir.validity, 
       ir.insured_sum, 
       ir.price, 
       ir.company_id, 
       ic.title as commpany_title, 
       ic.logo_url as company_logo_url, 
       ir.program_id, 
       ib.title as program_title,
       
       ( SUBSTR(ir.franchise, 1,instr(ir.franchise,' ') - 1) *1) AS franchise_number,
       (SUBSTR(ir.insured_sum, 1,instr(ir.insured_sum,' ') - 1) *1 )AS insured_sum_number
    FROM " . $table_name_rate . " ir
    left join " . $table_name_company . " ic on ic.id = ir.company_id
    left join " . $table_name_program . " ib on ib.id = ir.program_id
    WHERE ir.validity = '" . $validity . "' AND ir.program_id = '" . $program_id . "' ORDER BY franchise_number ASC, insured_sum_number ASC", '%d', '%s' ), ARRAY_A );


    if( ! empty( $result ) ){


        $result = array(
            'message' => 'Знайдено полісів.',
            'result' => covid_list_render( $result, $program_id ),
//            'result' => $result
        );
    }
    else{
        $result = array(
            'message' => 'В базі данних відсутні поліси за вашими критеріями.',
            'result' => $result,
        );
    }

    echo json_encode($result);

    wp_die();
}

function covid_list_render( $insurance_list, $program_id = '' ) {


    /*
     * Получаем список отображаемых компаний
     */
    $cur_user_id = get_current_user_id();


    $result = '';

    $results = array();

    $program_id = $program_id;

    if( current_user_can('create_users') ) {

        foreach ($insurance_list as $item) {

            $results[$item['validity']][$item['commpany_title']]['logo'] = $item['company_logo_url'];
            $results[$item['validity']][$item['commpany_title']]['company_id'] = $item['company_id'];
            $results[$item['validity']][$item['commpany_title']]['franchise'][$item['franchise']][] = array(
                'id' => $item['id'],
                'insured_sum' => $item['insured_sum'],
                'price' => $item['price'],
                'program_title' => $item['program_title'],
            );

        }
    }
    else
    {
        foreach ($insurance_list as $item) {

            $user_company_visible_status = get_user_meta($cur_user_id, 'user_covid_company_visible_status_' . $item['company_id'], true);

            if ($user_company_visible_status == 1) {
                $results[$item['validity']][$item['commpany_title']]['logo'] = $item['company_logo_url'];
                $results[$item['validity']][$item['commpany_title']]['company_id'] = $item['company_id'];
                $results[$item['validity']][$item['commpany_title']]['franchise'][$item['franchise']][] = array(
                    'id' => $item['id'],
                    'insured_sum' => $item['insured_sum'],
                    'price' => $item['price'],
                    'program_title' => $item['program_title'],
                );
            }
        }
    }

    //Создаем массив компаний и сортируем по страховой выплате и компании
    /*foreach( $insurance_list as $item ){

        $results[$item['insured_sum']][$item['commpany_title']]['logo'] = $item['company_logo_url'];
        $results[$item['insured_sum']][$item['commpany_title']]['validity'] = $item['validity'];
        $results[$item['insured_sum']][$item['commpany_title']]['company_id'] = $item['company_id'];
        $results[$item['insured_sum']][$item['commpany_title']]['franchise'][] = array(
            'id' => $item['id'],
            'franchise' =>  $item['franchise'],
            'price' => $item['price'],
            'program_id' => $item['program_id'],
            'program_title' => $item['program_title'],
        );

    }*/

    //Отрисовываем HTML

    if( ! empty( $results ) ) {
        foreach ($results as $k_insured_sum => $v_insured_sum) {

            $result .= '<div class="step-3-results-list">';
            $company_logo = '';
            foreach ($v_insured_sum as $k_company => $v_company) {
                if (!empty($v_company['logo'])) {
                    $company_logo = '<img src="' . $v_company['logo'] . '" alt="' . $k_company . '">';
                } else {
                    $company_logo = '';
                }

                $coefficient_message = '';

                if ($v_company['company_id'] == 1 or $v_company['company_id'] == 2) {
                    $coefficient_message = '<span class="coefficient-message js-coefficient-message" data-toggle="tooltip" data-placement="top" title="Цiна може бути змiнена в залежностi вiд дати народження."><i class="fa fa-info-circle" aria-hidden="true"></i></span>';
                }

                $result .= '<div class="row step-3-results-item">';
                $result .= '<div class="vc_col-md-12">';
                $result .= '<div class="step-3-results-item-top">';
                $result .= '<div class="vc_col-sm-4 vc_col-md-4"><div class="company-logo">' . $company_logo . '</div><div class="company-title">' . $k_company . '</div></div>';
                $result .= '<div class="vc_col-sm-2 vc_col-md-2 js-change-insurer-sum"><div class="step-3-dcv"><div class="step-3-results-item-title">Оберiть франшизу</div>';

                $i = 0;
                $ii = 0;
                $rate_id = '';
                $rate_franchise = '';
                $rate_locations = '';
                $count = 0;
                foreach ($v_company['franchise'] as $fk => $company) {
                    if ($i == 0) {
                        $price = $company['price'];
                        $franchise_amount = $fk;
                        $rate_franchise = $company['franchise'];
                        $result .= '<p><input type="radio" name="' . $k_insured_sum . $k_company . '" id="' . $v_company['company_id'] . $fk . '" data-insurance-price="' . $company['price'] . '" data-insurance-amount="' . $company['franchise'] . '" data-franchise-amount="' . $k_insured_sum . '" checked><label data-insurer-price-box-id="' . $i . '" for="' . $v_company['company_id'] . $fk . '" data-insurance-price="' . $company['price'] . '" data-franchise-amount="' . $fk . '">' . $fk . '</label></p>';
                    } else {
                        $result .= '<p><input type="radio" name="' . $k_insured_sum . $k_company . '" id="' . $v_company['company_id'] . $fk . '" data-insurance-price="' . $company['price'] . '" data-insurance-amount="' . $company['franchise'] . '" data-franchise-amount="' . $k_insured_sum . '"><label data-insurer-price-box-id="' . $i . '" for="' . $v_company['company_id'] . $fk . '" data-insurance-price="' . $company['price'] . '" data-franchise-amount="' . $fk . '">' . $fk . '</label></p>';
                    }
                    $i++;
                    $count++;
                }


                $result .= '</div></div>';

                $result .= '<div class="vc_col-sm-2 vc_col-md-2"><div class="step-3-dcv"><div class="step-3-results-item-title">Оберiть страхову суму</div>';

                $count = 0;
                $class_css = '';
                foreach ($v_company['franchise'] as $fk => $company) {
                    $class_css = $count == 0 ? '' : 'hide-box';
                    $result .= '<div class="js-insurer-price-box insurer-price-box ' . $class_css . '" id="' . $count . '">';
                    foreach ($company as $fr_price) {

                        if ($ii == 0) {
                            $price = $fr_price['price'];
                            $rate_id = $fr_price['id'];
                            $insured_sum = $fr_price['insured_sum'];
                            $rate_franchise = $company['franchise'];
                            $result .= '<p><input type="radio" name="' . $k_insured_sum . $k_company . 'insurer" id="' . $fr_price['id'] . '" data-insurance-price="' . $fr_price['price'] . '" data-insurance-amount="' . $fr_price['insured_sum'] . '" data-franchise-amount="' . $fk . '" data-insured-sum="' . $fr_price['insured_sum'] . '" checked><label class="js-label-insurance-price" for="' . $fr_price['id'] . '" data-insurance-price="' . $fr_price['price'] . '" data-franchise-amount="' . $fk . '">' . $fr_price['insured_sum'] . '</label></p>';
                        } else {
                            $result .= '<p><input type="radio" name="' . $k_insured_sum . $k_company . 'insurer" id="' . $fr_price['id'] . '" data-insurance-price="' . $fr_price['price'] . '" data-insurance-amount="' . $fr_price['insured_sum'] . '" data-franchise-amount="' . $fk . '" data-insured-sum="' . $fr_price['insured_sum'] . '"><label class="js-label-insurance-price" for="' . $fr_price['id'] . '" data-insurance-price="' . $fr_price['price'] . '" data-franchise-amount="' . $fk . '">' . $fr_price['insured_sum'] . '</label></p>';
                        }
                        $ii++;

                    }
                    $result .= '</div>';

                    $count++;

                }
                $result .= '</div></div>';
                // $result .= '<div class="vc_col-sm-4 vc_col-md-2"><div class="step-3-price"><div class="step-3-results-item-title">Цiна</div><span class="price js-insurance-price">' . $company['price'] . '</span> <span class="currency">грн.</span></div></div>';
                $result .= '<div class="vc_col-sm-4 vc_col-md-2"><div class="step-3-price"><div class="step-3-results-item-title">Цiна ' . $coefficient_message . '</div><span class="price js-insurance-price">' . $price . '</span> <span class="currency">грн.</span></div></div>';

                // $result .= '<div class="vc_col-md-2"><button data-company-id="' . $v_company['company_id'] . '" data-cmpany-name="' . $k_company . '" data-insurance-currency="" data-insurance-period="'. $v_company['validity'] .'" data-insurance-price="' . $company['price'] . '" data-franchise-amount="' . $rate_franchise . '"  data-rate-id="'. $rate_id .'" data-rate-franchise="' . $rate_franchise . '" data-rate-validity="'. $v_company['validity'] .'" data-rate-insured-sum="'. $k_insured_sum .'" data-rate-price="' . $company['price'] . '"  class="btn-get-it js-get-insurance">Придбати</button></div>';
                $result .= '<div class="vc_col-md-2"><button data-program-id="' . $program_id . '" data-company-id="' . $v_company['company_id'] . '" data-cmpany-name="' . $k_company . '" data-insurance-currency="" data-insurance-period="' . $k_insured_sum . '" data-insurance-price="' . $price . '" data-franchise-amount="' . $franchise_amount . '"  data-rate-id="' . $rate_id . '" data-rate-franchise="' . $franchise_amount . '" data-rate-validity="' . $k_insured_sum . '" data-rate-insured-sum="' . $insured_sum . '" data-rate-price="' . $price . '" class="btn-get-it js-get-insurance">Придбати</button></div>';

                $result .= '</div></div></div>';

            }

            $result .= '</div>';

        }
    }

    /*foreach( $results as $k_insured_sum => $v_insured_sum ){

        $result .= '<div class="step-3-results-list">';
        $company_logo = '';
        foreach( $v_insured_sum as $k_company => $v_company ){
            if(  ! empty( $v_company['logo'] ) ){
                $company_logo =  '<img src="' . $v_company['logo'] . '" alt="' . $k_company . '">';
            }
            else{
                $company_logo = '';
            }

            $coefficient_message = '';

            if( $v_company['company_id'] == 1 OR $v_company['company_id'] == 2 ){
                $coefficient_message = '<span class="coefficient-message js-coefficient-message" data-toggle="tooltip" data-placement="top" title="Цiна може бути змiнена в залежностi вiд дати народження."><i class="fa fa-info-circle" aria-hidden="true"></i></span>';
            }

            $result .= '<div class="row step-3-results-item">';
            $result .= '<div class="vc_col-md-12">';
            $result .= '<div class="step-3-results-item-top">';
            $result .= '<div class="vc_col-sm-4 vc_col-md-4"><div class="company-logo">' . $company_logo . '</div><div class="company-title">' . $k_company . '</div></div>';
            $result .= '<div class="vc_col-sm-4 vc_col-md-4"><div class="step-3-dcv"><div class="step-3-results-item-title">Оберiть франшизу</div>';

            $i = 0;
            $rate_id = '';
            $rate_franchise = '';
            $rate_locations = '';
            foreach( $v_company['franchise'] as $company ){
                if( $i == 0){
                    $price = $company['price'];
                    $rate_id = $company['id'];
                    $rate_franchise = $company['franchise'];
                    $result .= '<p><input type="radio" name="' . $k_insured_sum . $k_company . '" id="' . $company['id'] . '" data-insurance-price="' . $company['price'] . '" data-insurance-amount="' . $company['franchise'] . '" data-franchise-amount="' . $k_insured_sum . '" checked><label for="' . $company['id'] . '" data-insurance-price="' . $company['price'] . '" data-franchise-amount="' . $company['franchise'] . '">' . $company['franchise'] . '</label></p>';
                }
                else{
                    $result .= '<p><input type="radio" name="' . $k_insured_sum . $k_company . '" id="' . $company['id'] . '" data-insurance-price="' . $company['price'] . '" data-insurance-amount="' . $company['franchise'] . '" data-franchise-amount="' . $k_insured_sum . '"><label for="' . $company['id'] . '" data-insurance-price="' . $company['price'] . '" data-franchise-amount="' . $company['franchise'] . '">' . $company['franchise'] . '</label></p>';
                }
                $i ++;
            }



            $result .= '</div></div>';
            // $result .= '<div class="vc_col-sm-4 vc_col-md-2"><div class="step-3-price"><div class="step-3-results-item-title">Цiна</div><span class="price js-insurance-price">' . $company['price'] . '</span> <span class="currency">грн.</span></div></div>';
            $result .= '<div class="vc_col-sm-4 vc_col-md-2"><div class="step-3-price"><div class="step-3-results-item-title">Цiна '. $coefficient_message .'</div><span class="price js-insurance-price">' . $price . '</span> <span class="currency">грн.</span></div></div>';

            // $result .= '<div class="vc_col-md-2"><button data-company-id="' . $v_company['company_id'] . '" data-cmpany-name="' . $k_company . '" data-insurance-currency="" data-insurance-period="'. $v_company['validity'] .'" data-insurance-price="' . $company['price'] . '" data-franchise-amount="' . $rate_franchise . '"  data-rate-id="'. $rate_id .'" data-rate-franchise="' . $rate_franchise . '" data-rate-validity="'. $v_company['validity'] .'" data-rate-insured-sum="'. $k_insured_sum .'" data-rate-price="' . $company['price'] . '"  class="btn-get-it js-get-insurance">Придбати</button></div>';
            $result .= '<div class="vc_col-md-2"><button data-program-id="'. $program_id .'" data-company-id="' . $v_company['company_id'] . '" data-cmpany-name="' . $k_company . '" data-insurance-currency="" data-insurance-period="'. $v_company['validity'] .'" data-insurance-price="' . $price . '" data-franchise-amount="' . $rate_franchise . '"  data-rate-id="'. $rate_id .'" data-rate-franchise="' . $rate_franchise . '" data-rate-validity="'. $v_company['validity'] .'" data-rate-insured-sum="'. $k_insured_sum .'" data-rate-price="' . $price . '" class="btn-get-it js-get-insurance">Придбати</button></div>';

            $result .= '</div></div></div>';

        }

        $result .= '</div>';

    }*/

    return $result;

}



add_action('wp_ajax_covidcreateorder', 'covid_create_order');
add_action('wp_ajax_nopriv_covidcreateorder', 'covid_create_order');

function covid_create_order(){

    if( empty( $_POST['nonce'] ) ){
        wp_die('', '', 400);
    }

    check_ajax_referer( 'medical-m-create-order', 'nonce', true );

    $result = array();

    $surname = strip_tags( $_POST['surname'] );
    $name = strip_tags( $_POST['name'] );
    $passport = strip_tags( $_POST['passport'] );
    $date = strip_tags( $_POST['date'] );
    //Convert dd.mm.yyyy to yyyy-mm-dd
    $date = date("Y-m-d", strtotime($date) );

    $address = strip_tags( $_POST['address'] );
    $tel = strip_tags( $_POST['tel'] );
    $email = strip_tags( $_POST['email'] );
    $company_id = strip_tags( $_POST['company_id'] );
    $company_title = strip_tags( $_POST['company_title'] );

    // $franchise = strip_tags( $_POST['franchise'] );
    $period = strip_tags( $_POST['period'] );
    $blank_number = strip_tags( $_POST['blank_number'] );
    $date_from = strip_tags( $_POST['date_start'] );
    $date_from = date("Y-m-d", strtotime($date_from) );
    $program_id = strip_tags( $_POST['blank_id'] );
    $program_title = strip_tags( $_POST['blank_title'] );
    $blank_series = strip_tags( $_POST['blank_series'] );

    $rate_id = strip_tags( $_POST['rate_id'] );
    $rate_franchise = strip_tags( $_POST['rate_franchise'] );
    $rate_validity = strip_tags( $_POST['rate_validity'] );
    $rate_insured_sum = strip_tags( $_POST['rate_insured_sum'] );
    $rate_price = strip_tags( $_POST['rate_price'] );
//    $rate_locations = strip_tags( $_POST['rate_locations'] );
    $rate_coefficient = strip_tags( $_POST['rate_coefficient'] );
    $citizenship = strip_tags( $_POST['citizenship'] );


    $rate_price_coefficient = ( ! empty( $_POST['rate_price_coefficient'] ) ) ? $_POST['rate_price_coefficient'] : 1;

    $insurers = $_POST['insurers'];

    $insurer_status = (int) $_POST['insurer_status'];



    $count_days = $period;
//    $date_to = explode("/", $period);
//    $count_days = $date_to[1];
//    $date_to = $date_to[0];

    $summ = $date_from . " + " . ($period -1) . " days";
    $date_to = date( "Y-m-d", strtotime( $summ ) );



    $pdf_url = '';

    //Получаем ID пользователя и проверяем его роль
    $user_id = get_current_user_id();
    // $user_id = 50;
    if( $user_id > 0 ){
        $user_data = get_userdata( 1 );
        $user_role = $user_data->roles[0];
        if( $user_role == 'manager' ){
            $is_manager = 1;
        }
        else{
            $is_manager = 0;
        }
    }
    else{
        $is_manager = 0;
    }

    $status = 0;
    //ВІЗА СТАНДАРТНІ БЛАНКИ
//    if( $program_id == 1 ){

    $user_years = get_full_years( $date );

    if( $user_years < 18 ){
        $result['message'][] = '<span class="message-danger">Страхувальник не може бути молодшим за 18 рокiв.</span>';
    }

    //Проверяем коеффициенты по дате рождения пользователей
    //Если статус застрахованых персон ($insurer_status) равен 0 значит мы не должны учитывать возрастной коефициент страховальника
    if( $insurer_status != 0 ){

        //ТОлько для ПрАТ СК Інтер Експрес
        if( $company_id == 1 )
        {
            // Если добавлены застрахованые особы, то коеффициент страховальника ставим 1 не сависит от его возраста
            // т.к. он страхует не себя а другого человека.
            // Специфика бланка, может быть застрахован только один человек.
            if( count( $insurers ) > 0 )
            {
                $rate_coefficient = 1;
            }
            else{
                $coefficient_data = covidSetCoeficient( $company_id, $user_years, $company_title, $program_title, $program_id );
            }
        }
        else{
            $coefficient_data = covidSetCoeficient( $company_id, $user_years, $company_title, $program_title, $program_id );
        }


        if( ! empty( $coefficient_data['message'] ) ) {
            $result['message'][] = $coefficient_data['message'];
        }

        $rate_coefficient = $coefficient_data['coefficient'];
    }
    else
    {
        $rate_coefficient = 1;
    }



    // Только для ПрАТ СК Інтер Експрес
    //Считаем количество застрахованых персон, если больше 1 то выдаем сообщение об ошибке
    if( $company_id == 1 )
    {
        if( count( $insurers ) > 1 )
        {
            $result['message'][] = '<span class="message-danger">Багато застрахованих осіб. По даній компанії можливо застрахувати лише одну особу на бланк.</span>';
        }

        if( $insurer_status == 1 && count( $insurers ) > 0 )
        {
            $result['message'][] = '<span class="message-danger">Багато застрахованих осіб. По даній компанії можливо застрахувати лише одну особу на бланк.</span>';
        }
    }


    //Вроверяем на пустоту переданые параметры
    if( empty( $surname ) ) $result['message'][] = '<span class="message-danger">Поле "Прiзвище" заповнено не коректно.</span>';
    if( empty( $name ) ) $result['message'][] = '<span class="message-danger">Поле "Iм\'я" заповнено не коректно.</span>';
    if( empty( $passport ) ) $result['message'][] = '<span class="message-danger">Поле "Серiя, номер паспорта" заповнено не коректно.</span>';
    if( empty( $date ) ) $result['message'][] = '<span class="message-danger">Поле "Дата народження" заповнено не корректно.</span>';
    if( empty( $address ) ) $result['message'][] = '<span class="message-danger">Поле "Адреса постійного місця проживання" заповнено не коректно.</span>';
    // if( empty( $tel ) ) $result['message'][] = '<span class="message-danger">Поле "Телефон" заповнено не коректно.</span>';
    // if( empty( $email ) ) $result['message'][] = '<span class="message-danger">Поле "Email" заповнено не коректно.</span>';
    if( empty( $company_id ) ) $result['message'][] = '<span class="message-danger">Відсутня така страхова компанія.</span>';
    if( empty( $company_title ) ) $result['message'][] = '<span class="message-danger">Відсутня назва страхової компанії.</span>';

    // if( empty( $franchise ) ) $result['message'][] = 'Поле "Франшиза" заповнено не коректно.';
    if( empty( $period ) ) $result['message'][] = '<span class="message-danger">Поле "перiод страхування" заповнено не коректно.</span>';

    if( empty( $date_from ) ) $result['message'][] = '<span class="message-danger">Поле "Дата початку дiї договору" заповнено не коректно.</span>';
    if( empty( $program_id ) ) $result['message'][] = '<span class="message-danger">Поле "Оберіть бланк" заповнено не коректно.</span>';
    if( empty( $program_title ) ) $result['message'][] = '<span class="message-danger">Назва програми відсутня.</span>';
    //Тип бланка "Паперовий"



    if( empty( $rate_id ) ) $result['message'][] = '<span class="message-danger">ID тарифа відсутнє.</span>';
    if( empty( $rate_franchise ) ) $result['message'][] = '<span class="message-danger">"Франшиза" не вибрана.</span>';
    if( empty( $rate_validity ) ) $result['message'][] = '<span class="message-danger">"Перiод страхування" не вибраний.</span>';
    if( empty( $rate_insured_sum ) ) $result['message'][] = '<span class="message-danger">Страхова сума відсутня.</span>';
    if( empty( $rate_price ) ) $result['message'][] = '<span class="message-danger">Ціна страхового полюча відсутня.</span>';
    if( empty( $citizenship ) ) $result['message'][] = '<span class="message-danger">Громадянство відсутнє.</span>';
//    if( empty( $rate_locations ) ) $result['message'][] = '<span class="message-danger">Територія дії відсутня.</span>';


    $insurer_count = 0;
    //Проверяем заполнены ли данные в "страховых особах"
    if( ! empty( $insurers ) && count( $insurers ) > 0 ){

        $insurer_count = 1;

        foreach ( $insurers as $insurer ){

            if( empty( $insurer['lastName'] ) ) $result['message'][] = '<span class="message-danger">Не вказано прізвище у застрахованої особи №'. $insurer_count . '.</span>';
            if( empty( $insurer['name'] ) ) $result['message'][] = '<span class="message-danger">Не вказано ім\'я у застрахованої особи №'. $insurer_count . '.</span>';
            if( empty( $insurer['date'] ) ) $result['message'][] = '<span class="message-danger">Не вказана дата народження у застрахованої особи №'. $insurer_count . '.</span>';
            if( empty( $insurer['passport'] ) ) $result['message'][] = '<span class="message-danger">Не вказанні паспортні дані у застрахованої особи №'. $insurer_count . '.</span>';
            if( empty( $insurer['address'] ) ) $result['message'][] = '<span class="message-danger">Не вказано адреса у застрахованої особи №'. $insurer_count . '.</span>';
            if( empty( $insurer['citizenship'] ) ) $result['message'][] = '<span class="message-danger">Не вказано громадянство у застрахованої особи №'. $insurer_count . '.</span>';

            $insurer_date = get_full_years( $insurer['date'] );
            //Проверяем коеффициенты по дате рождения пользователей
            $coefficient_data = covidSetCoeficient( $company_id, $insurer_date, $company_title, $program_title, $program_id );

            if( ! empty( $coefficient_data['message'] ) ) {
                $result['message'][] = $coefficient_data['message'];
            }

            $insurer_count ++;
        }
    }

    $data = array();

    $data['surname'] = $surname;
    $data['name'] = $name;
    $data['passport'] = $passport;
    $data['date'] = $date;
    $data['address'] = $address;
    $data['tel'] = $tel;
    $data['email'] = $email;
    $data['company_id'] = $company_id;
    $data['period'] = $period;
    $data['date_start'] = $date_from;
    $data['program_id'] = $program_id;
    $data['blank_number'] = $blank_number;
    $data['blank_series'] = $blank_series;

    $data['rate_id'] = $rate_id;
    $data['rate_franchise'] = $rate_franchise;
    $data['rate_validity'] = $rate_validity;
    $data['rate_insured_sum'] = $rate_insured_sum;
    $data['rate_price'] = $rate_price;
//    $data['rate_locations'] = $rate_locations;

    $data['user_id'] = $user_id;
    $data['user_role_text'] = $user_data->roles[0];
    $data['user_role'] = $user_role;



    //Проверяем достоверность даных полученых из фронта
    global $wpdb;

    $table_name_rate = $wpdb->get_blog_prefix() . 'covid_rate';

    $authenticity = $wpdb->get_row( "SELECT * FROM ".$table_name_rate." WHERE id = ".$rate_id." ", ARRAY_A );


    if( $authenticity['price'] != $rate_price ){
        $result['message'][] = '<span class="message-danger">Були переданi недостовiрнi данi.</span>';
    }



    //Если ошибок нет, то продолжаем выполнение
    if( empty( $result['message'] ) ){

        // Електронний бланк


            $blank_data = new CovidBlank();

            //для поиска по ТАБЛИЧКИ ЭЛЕКТРОННЫХ
            $blank_number_data = $blank_data->get_e_blank_number_data($company_id);



            //Оформление договора
            //для поиска по ТАБЛИЧКИ ЭЛЕКТРОННЫХ
            if( ! empty( $blank_number_data ) ){

                //для поиска по ТАБЛИЧКИ ЭЛЕКТРОННЫХ
                $new_order_blank_id = (int)$blank_number_data[0]['blank_number'];
                $number_of_blank_series = $blank_number_data[0]['blank_series'];
                $number_of_blank_id = (int)$blank_number_data[0]['number_of_blank_id'];
                $number_blank_comment = $blank_number_data[0]['comments'];

                $unicue_code = random_string();

                $cashback = get_user_meta($user_id, "user_return_percent_covid_company_id_" . $company_id, 1);

                $table_name = $wpdb->get_blog_prefix() . 'covid_orders';

                $table_name_insurance_program = $wpdb->get_blog_prefix() . 'covid_program';

                $program_title_original = $wpdb->get_row("SELECT title FROM " . $table_name_insurance_program . " WHERE id = " . (int)$program_id . " AND status = 1", ARRAY_A);
                $program_title_original = $program_title_original['title'];

                $query = $wpdb->insert($table_name,
                    array(
                        'program_id' => (int)$program_id,
                        'program_title' => $program_title_original,
                        'number_blank_id' => (int)$number_of_blank_id,
                        'number_blank_comment' => $number_blank_comment,
                        'blank_number' => $new_order_blank_id,
                        'blank_series' => $number_of_blank_series,
                        'company_id' => $company_id,
                        'company_title' => $company_title,
                        'rate_id' => $rate_id,
                        'rate_franchise' => $rate_franchise,
                        'rate_validity' => $rate_validity,
                        'rate_insured_sum' => $rate_insured_sum,
                        'rate_price' => $rate_price,
                        'name' => $name,
                        'last_name' => $surname,
                        'passport' => $passport,
                        'citizenship' => $citizenship,
                        'birthday' => $date,
                        'address' => $address,
                        'phone_number' => $tel,
                        'email' => $email,
                        'date_from' => $date_from,
                        'date_to' => $date_to,
                        'count_days' => (int)$count_days,
                        'pdf_url' => $pdf_url,
                        'is_manager' => $is_manager,
                        'user_id' => $user_id,
                        'cashback' => $cashback,
                        'status' => 1,
                        'rate_coefficient' => $rate_coefficient,
                        'rate_price_coefficient' => $rate_price_coefficient,
                        'unicue_code' => $unicue_code,
                        'insurer_status' => $insurer_status),
                    array(
                        '%d',
                        '%s',
                        '%d',
                        '%s',
                        '%d',
                        '%s',
                        '%d',
                        '%s',
                        '%d',
                        '%s',
                        '%s',
                        '%s',
                        '%f',
                        '%s',
                        '%s',
                        '%s',
                        '%s',
                        '%s',
                        '%s',
                        '%s',
                        '%s',
                        '%s',
                        '%s',
                        '%d',
                        '%s',
                        '%d',
                        '%d',
                        '%f',
                        '%d',
                        '%f',
                        '%f',
                        '%s',
                        '%d'
                    ));

                $order_id = $wpdb->insert_id;

                // $result['message'][] = 'Номер бланка совпадает с диапазоном';

                //Если у нас есть Страховальники и был создан договор то можно добавлять новые данные
                if ($query && !empty($insurers)) {

                    $table_name = $wpdb->get_blog_prefix() . 'covid_insurer';

                    foreach ($insurers as $insurer) {

                        $insurer_last_name = $insurer['lastName'];
                        $insurer_name = $insurer['name'];
                        $insurer_date = date("Y-m-d", strtotime($insurer['date']));
                        $insurer_coefficient_date = get_full_years($insurer['date']);
                        $insurer_passport = $insurer['passport'];
                        $insurer_address = $insurer['address'];
                        $insurer_citizenship = $insurer['citizenship'];

                        //                        date("Y-m-d", strtotime($date) );
                        //Проверяем коеффициенты по дате рождения пользователей
                        $coefficient_data = covidSetCoeficient($company_id, $insurer_coefficient_date, $company_title, $program_title, $program_id);

                        $rate_coefficient = $coefficient_data['coefficient'];


                        $insurer_query = $wpdb->insert($table_name, array('order_id' => $order_id, 'last_name' => $insurer_last_name, 'name' => $insurer_name, 'birthday' => $insurer_date, 'passport' => $insurer_passport, 'address' => $insurer_address, 'citizenship' => $insurer_citizenship, 'coefficient' => $rate_coefficient, 'price' => $rate_price),
                            array('%d', '%s', '%s', '%s', '%s', '%s', '%s', '%f', '%f'));


                        if (!$insurer_query) {
                            $result['message'][] = '<span class="message-danger">Не вдалося записати страхувальників в базу данних.</span>';
                        }


                    }

                }


                if ($query) {

                    //для поиска по ТАБЛИЧКИ ЭЛЕКТРОННЫХ
                    $blank_data->change_status_e_blank_number($number_of_blank_id, $new_order_blank_id,1);


                    $result['status'] = true;
                    $result['message'][] = '<span class="message-ok">Вітаємо, поліс успішно оформлений.</span>';

                    $result['last_step_html'] = '<a class="get-new-medical-order" href="/covid2019">Оформити новий поліс</a><a target="_blank" class="download-medical-order" href="/wp-content/plugins/covid/order-print/electronic-form/electronic-form.php?order_id=' . $order_id . '&key=TdHjjZycfXfqRF7Ydao4">Скачати поліс</a>';
                    $result['order_id'] = $wpdb->insert_id;
                } else {
                    $result['status'] = false;
                    $result['message'][] = '<span class="message-danger">Не вдалося записати полiс в базу данних.</span>';
                    $result['order_id'] = false;
                }
            }
            else{
                $result['status'] = false;
                $result['message'][] = 'Не вдалося присвоїти номер електронному договору.';
            }



    }
    else{
        $result['status'] = false;
    }

    echo json_encode( $result );

    wp_die();

}


function covidSetCoeficient( $company_id, $user_years, $company_title, $program_title, $program_id ){

    $rate_coefficient = 1;
    $status = 0;

    //ПрАТ СК Інтер Експрес
    if( $company_id == 1 )
    {
        if ($user_years <= 3) {
            $rate_coefficient = 2;
            $status = 1;
        } else if (4 <= $user_years && $user_years <= 8) {
            $rate_coefficient = 1.5;
            $status = 1;
        } else if (9 <= $user_years && $user_years <= 14) {
            $rate_coefficient = 1.3;
            $status = 1;
        } else if (15 <= $user_years && $user_years <= 21) {
            $rate_coefficient = 1.2;
            $status = 1;
        } else if (22 <= $user_years && $user_years <= 65) {
            $rate_coefficient = 1;
            $status = 1;
        } else if (66 <= $user_years && $user_years <= 75) {
            $rate_coefficient = 2.5;
            $status = 1;
        }

    }
    //СК Український Страховий Стандарт
    else if( $company_id == 2 )
    {
        if( 1 < $user_years ){
            $rate_coefficient = 2.5;
            $status = 1;
        }
        else if( 1 <= $user_years && $user_years <= 17  ){
            $rate_coefficient = 1.5;
            $status = 1;
        }
        else if( 18 <= $user_years && $user_years <= 59  ){
            $rate_coefficient = 1;
            $status = 1;
        }
        else if( 60 <= $user_years && $user_years <= 65  ){
            $rate_coefficient = 2;
            $status = 1;
        }
        else if( 66 <= $user_years && $user_years <= 75  ){
            $rate_coefficient = 3.5;
            $status = 1;
        }

    }
    //СК ЕТАЛОН
    else if( $company_id == 3 )
    {

        if( 1 <= $user_years && $user_years <= 60 ){
            $rate_coefficient = 1;
            $status = 1;
        }
        else if( 61 <= $user_years && $user_years <= 70  ){
            $rate_coefficient = 1.5;
            $status = 1;
        }

    }
    //СК ІНТЕР ПЛЮС
    else if( $company_id == 4 )
    {


    }
    //СК ПРОВІДНА
    else if( $company_id == 5 )
    {

        if( 1 <= $user_years && $user_years <= 60 ){
            $rate_coefficient = 1;
            $status = 1;
        }
        else if( 61 <= $user_years && $user_years <= 70  ){
            $rate_coefficient = 1.8;
            $status = 1;
        }

    }


    if( $status == 0 ){
        $message = '<span class="message-danger">' . $user_years . ' В ' . $company_title .' "' . $program_title .'" по вказанiй вiковiй категорiї договори не приймаються.</span>';
    }

    /*if( $company_id == 1 ){

//        if( 14 <= $user_years && $user_years < 18 ){
        if( $user_years < 18 ){
            $rate_coefficient = 1.2;
            $status = 1;
        }else if( 18 <= $user_years && $user_years < 60  ){
            $rate_coefficient = 1;
            $status = 1;
        }else if( 60 <= $user_years && $user_years <= 65  ){
            $rate_coefficient = 1.5;
            $status = 1;
        }else if( 66 <= $user_years && $user_years <= 70  ){
            $rate_coefficient = 2;
            $status = 1;
        }

        if( $status == 0 ){
            $message = '<span class="message-danger">' . $user_years . ' В ' . $company_title .' "' . $program_title .'" по вказанiй вiковiй категорiї договори не приймаються.</span>';
        }
        //СК ГАРДІАН
    }else if( $company_id == 2 ){

        if( $program_id == 3 ){

            if (1 <= $user_years && $user_years < 17) {
                $rate_coefficient = 1.5;
                $status = 1;
            }else if( 18 <= $user_years && $user_years < 60 ){
                $rate_coefficient = 1;
                $status = 1;
            }
            else if( 60 <= $user_years && $user_years <= 65  ){
                $rate_coefficient = 2;
                $status = 1;
            }
            else if (66 <= $user_years && $user_years < 70) {
                $rate_coefficient = 4;
                $status = 1;
            }
        } else if( $program_id == 1 ){
            if( 18 <= $user_years && $user_years < 60 ){
                $rate_coefficient = 1;
                $status = 1;
            }
            else if( 60 <= $user_years && $user_years <= 65  ){
                $rate_coefficient = 2;
                $status = 1;
            }
            else if (66 <= $user_years && $user_years < 70) {
                $rate_coefficient = 4;
                $status = 1;
            }
        }
        else{
            if( 18 <= $user_years && $user_years < 60 ){
                $rate_coefficient = 1;
                $status = 1;
            }
            else if( 60 <= $user_years && $user_years <= 65  ){
                $rate_coefficient = 2;
                $status = 1;
            }

        }



        if( $status == 0 ){
            $message = '<span class="message-danger">' . $user_years . ' В ' . $company_title .' "' . $program_title .'" по вказанiй вiковiй категорiї договори не приймаються.</span>';
        }

    }*/

    $result = array(
        'message' => $message,
        'coefficient' => $rate_coefficient,
    );

    return $result;

}