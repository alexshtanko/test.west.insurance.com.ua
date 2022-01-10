<?php

require($_SERVER['DOCUMENT_ROOT'].'/wp-load.php');

$key = 'TdHjjZycfXfqRF7Ydao4';

require_once $_SERVER['DOCUMENT_ROOT'].'vendor/autoload.php';

require_once $_SERVER['DOCUMENT_ROOT'].'wp-content/wp-recall/add-on/covid/class/covid.php';


//Check key to run the script
if ( $key == $_GET['key'] ) {


//    $order_id = empty( $_GET['order_id'] ) ? $_GET['order_id'] : '';
    $order_id = $_GET['order_id'];

    $order_data = new Covid_Class();

    $order = $order_data->get_covid_order( $order_id );

    $rows = '';


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
    $email = $order['email'];
    $citizenship = $order['citizenship'];
    $fio = $last_name . ' ' . $name;
    $rate_validity = $order['rate_validity'];



    $blank_number_print = $blank_series . ' ' . $blank_number;


    //Финальная стоимость страховки
    $total_rate_price = 0;

    $total_rate_price = $rate_price * $order['rate_coefficient'] * $order['rate_price_coefficient'];


    //Количество строчек в бланке под застрахованых персон
    $max_row_count = 1;



    //Insurer data
    $i_fio = '';
    $i_address = '';
    $i_birthday = '';
    $i_passport = '';
    $i_inn = '';
    $i_phone = '';
    $i_email = '';

    //Страховальники
    $insurer_status = $order['insurer_status'];

    if( ! $insurer_status )
    {
        $insurers = $order_data->get_covid_insurers( $order_id );

        if( count( $insurers ) > 0 )
        {
            $i_fio = $insurers[0]['last_name'] . ' ' . $insurers[0]['name'];
            $i_address = $insurers[0]['address'];
            $i_birthday =  date( 'd.m.Y', strtotime( $insurers[0]['birthday'] ) );
            $i_passport = $insurers[0]['passport'];
            $i_inn = '';
            $i_phone = '';
            $i_email = '';
            $total_rate_price = $rate_price * $insurers[0]['coefficient'] * $order['rate_price_coefficient'];
        }
    }
    else{
        $i_fio = $fio;
        $i_address = $address;
        $i_birthday = $birthday;
        $i_passport = $passport;
        $i_inn = '';
        $i_phone = $phone;
        $i_email = $email;
    }


    $insure_tarif = explode( ' ', $rate_insured_sum );
    $insure_tarif = ( $total_rate_price / $insure_tarif[0] ) * 100;


    $insurer_peoples_count = 0;




    /**
     * @description
     * Упрощенный метод формирования PDF из html
     */

// Create an instance of the class:
    $mpdf = new Mpdf\Mpdf([
        'mode' => 'utf-8', // кодировка (по умолчанию UTF-8)
        //'format' => 'A4', // - формат документа
        'format' => [210,297], // - формат документа
        'margin_left' => '13mm',
        'margin_right' => '7mm',
        'margin_top' => '5mm',
        'margin_bottom' => '5mm',
        //'orientation' => 'L' // - альбомная ориентация
    ]);

    $mpdf->simpleTables = true;


    $mpdf->SetAuthor('Shtanko');
    /**
     * @name HTML
     * @description формируем html код
     */


    if( $companyId == 1 )
    {
        $html = file_get_contents(__DIR__ . DIRECTORY_SEPARATOR . "ie/ie.html");
        $stylesheet = file_get_contents(__DIR__ . DIRECTORY_SEPARATOR . "ie/style.css");
    }
    else
    {
        echo 'Не знайдено форми для друку договору';

        wp_die();
    }

    $search = [
        "%DATECREATED%",
        "%BLANKNUMBER%",
        "%FIO%",
        "%ADDRESS%",
        "%BIRTHDAY%",
        "%PASSPORT%",
        "%PHONE%",
        "%EMAIL%",
        "%CITIZENSHIP%",
        "%IFIO%",
        "%IADDRESS%",
        "%IBIRTHDAY%",
        "%IPASSPORT%",
        "%IINN%",
        "%IPHONE%",
        "%IEMAIL%",

        "%RATEVALIDITY%",
        "%FRANCHISE%",
        "%DATEFROM%",
        "%DATETO%",
        "%TOTALRATEPRICE%",
        "%RATEINSUREDSUM%",
        "%INSURETARIF%",
    ];


    $replace = [
        $date,
        $blank_number,
        $fio,
        $address,
        $birthday,
        $passport,
        $phone,
        $email,
        $citizenship,
        $i_fio,
        $i_address,
        $i_birthday,
        $i_passport,
        $i_inn,
        $i_phone,
        $i_email,

        $rate_validity,
        $franchise,
        $dateFrom,
        $dateTo,
        $total_rate_price,
        $rate_insured_sum,
        $insure_tarif,
    ];
    $html = str_replace($search, $replace, $html);


    $mpdf->WriteHTML($stylesheet, 1);
// генерируем сам PDF
    $mpdf->WriteHTML($html, 2);
// выводим PDF  в браузер
    $mpdf->Output();
}
else{
    echo 'error';
}