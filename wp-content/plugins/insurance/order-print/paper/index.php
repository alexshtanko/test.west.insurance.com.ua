<?php

require($_SERVER['DOCUMENT_ROOT'].'/wp-load.php');

$key = 'WPbm49ebf124';
define('ACCESSCNSTINSURANCE', TRUE);
require_once $_SERVER['DOCUMENT_ROOT'].'vendor/autoload.php';

require_once $_SERVER['DOCUMENT_ROOT'].'wp-content/wp-recall/add-on/insurance/class/insurance.php';


//Check key to run the script
if ( $key == $_GET['key'] ) {


//    $order_id = empty( $_GET['order_id'] ) ? $_GET['order_id'] : '';
    $order_id = $_GET['order_id'];

    if( $order_id ) {

        $order_data = new Insurance_Class();

        $order = $order_data->get_order( $order_id );

        $rows = '';

        $programId = $order['program_id'];
        $companyId = $order['company_id'];

        $name = $order['name'];
        $last_name = $order['last_name'];
        $passport = $order['passport'];
        $birthday = date('d.m.Y', strtotime($order['birthday']));
        $address = $order['address'];
        $country = $order['rate_locations'];
        $phone = $order['phone_number'];
        $count_days = $order['count_days'];
        $dateFrom = date('d.m.Y', strtotime($order['date_from']));
        $dateTo = date('d.m.Y', strtotime($order['date_to']));
        $sumInsured = $order['rate_insured_sum'];
        $date = date('d.m.Y', strtotime($order['date_added']));
        $franchise = $order['rate_franchise'];
        $rate_price = $order['rate_price'];
        $rate_insured_sum = $order['rate_insured_sum'];
        $rate_locations = $order['rate_locations'];
        $blank_number = $order['blank_number'];
        $blank_series = $order['blank_series'];


        if( $companyId == 2 )
        {
            //Подключаем СК с ID = 2 - "СК GARDIAN"
            require_once '2_gardian/gardian.php';
        }
        elseif( $companyId == 4 )
        {
            //Подключаем СК с ID = 4 - "СК ЕСВРОИНС"
            require_once '4_euroins/euroins.php';
        }
        elseif ( $companyId == 6 )
        {
            //Подключаем СК с ID = 6 - "СК EKTA"
            require_once '6_ekta/ekta.php';
        }


    }
}
else{
    echo 'error';
}