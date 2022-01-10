<?php


require($_SERVER['DOCUMENT_ROOT'].'/wp-load.php');

$key = 'TdHjjZycfXfqRF7Ydao4';

define('ACCESSCNSTCOVID', TRUE);

require_once $_SERVER['DOCUMENT_ROOT'].'vendor/autoload.php';

require_once $_SERVER['DOCUMENT_ROOT'].'wp-content/wp-recall/add-on/covid/class/covid.php';


//Check key to run the script
if ( $key == $_GET['key'] ) {

    $order_id = $_GET['order_id'];

    $order_data = new Covid_Class();

    $order = $order_data->get_covid_order($order_id);

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

    $citizenship = $order['citizenship'];

    $fio = $last_name . ' ' . $name;



    if( $companyId == 1 )
    {
        //Подключаем СК с ID = 1 - "СК ie"
        require_once '1_ie/ie.php';
    }
    elseif ( $companyId == 2 )
    {
        //Подключаем СК с ID = 2 - "СК UCC"
        require_once '2_ucc/ucc.php';
    }
    elseif ( $companyId == 3 )
    {
        //Подключаем СК с ID = 3 - "СК Еталон"
        require_once '3_etalon/etalon.php';
    }
    elseif ( $companyId == 4 )
    {

    }
    elseif ( $companyId == 5 )
    {
        //Подключаем СК с ID = 5 - "СК Провiдна"
        require_once '5_providna/providna.php';
    }
}
else{
    echo 'Error.';
}