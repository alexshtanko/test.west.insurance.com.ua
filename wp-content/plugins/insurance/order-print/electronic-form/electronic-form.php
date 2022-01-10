<?php

require($_SERVER['DOCUMENT_ROOT'].'/wp-load.php');


define('ACCESSCNST', TRUE);

$key = 'kDCRa89dc0e1';

require_once $_SERVER['DOCUMENT_ROOT'].'vendor/autoload.php';

require_once $_SERVER['DOCUMENT_ROOT'].'wp-content/wp-recall/add-on/insurance/class/insurance.php';


//Check key to run the script
if ( $key == $_GET['key'] ) {

    $order_id = $_GET['order_id'];

    $order_data = new Insurance_Class();

    $order = $order_data->get_order( $order_id );

    $programId = $order['program_id'];
    $companyId = $order['company_id'];

    $name = $order['name'];
    $last_name = $order['last_name'];
    $passport = $order['passport'];
    $birthday = date( 'd.m.Y', strtotime( $order['birthday'] ) );
    $address = $order['address'];
    $country = $order['rate_locations'];
    $phone = $order['phone_number'];
    $count_days = $order['count_days'];
    $dateFrom = date( 'd.m.Y', strtotime( $order['date_from'] ) );
    $dateTo = date( 'd.m.Y', strtotime( $order['date_to'] ) );
    $sumInsured = $order['rate_insured_sum'];
    $date = date( 'd.m.Y', strtotime( $order['date_added'] ) );
    $franchise = $order['rate_franchise'];
    $rate_price = $order['rate_price'];
    $rate_insured_sum = $order['rate_insured_sum'];
    $rate_locations = $order['rate_locations'];
    $blank_number = $order['blank_number'];
    $blank_series = $order['blank_series'];



    //Страховальники
    $insurer_status = $order['insurer_status'];
    $insurers = $order_data->get_insurers( $order_id );
    $insurer_peoples_count = 0;


	//$blank_number_print = $blank_series . ' ' . $blank_number;

    //В зависимости от ID Страховой коспании подклчаем разные файлы для вывода электронных бланков
    if( $companyId == 1 )
    {

        //Подключаем СК с ID = 1 - "СК Провiдна"
        require_once '1_providna/providna.php';

    }
    elseif ( $companyId == 2 )
    {
        //GARDIAN
        require_once '2_gardian/gardian.php';
    }
    elseif ( $companyId == 5 )
    {

        //Подключаем СК с ID = 5 - "СК Iнтер плюс"
        require_once '5_inter_plus/inter_plus.php';

    }







}
else{
    echo 'error';
}