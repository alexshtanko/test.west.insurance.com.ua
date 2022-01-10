<?php

if( !defined('ACCESSCNSTINSURANCE' ) ) {
    die('Direct access not permitted');
}
else {

//    $order_id = empty( $_GET['order_id'] ) ? $_GET['order_id'] : '';
    $order_id = $_GET['order_id'];
//    echo $order_id;

    $order_data = new Insurance_Class();

    $order = $order_data->get_order( $order_id );

    $rows = '';

//    echo '<pre>';
//    var_dump($order);

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
    $paiment_date = date('d.m.Y', strtotime('-1 day', strtotime($order['date_added'])));
    $franchise = $order['rate_franchise'];
    $rate_price = $order['rate_price'];
    $rate_insured_sum = $order['rate_insured_sum'];
    $rate_locations = $order['rate_locations'];
    $blank_number = $order['blank_number'];
    $blank_series = $order['blank_series'];
    $rate_validity = explode( '/', $order['rate_validity'] );
    $rate_validity = $rate_validity[1];



    $blank_number_print = $blank_series . ' ' . $blank_number;

    //Данные застрахованых персон
    $insure_name = '';
    $insure_last_name = '';
    $insure_last_name = '';
    $insure_passport = '';
    $insure_birthday = '';
    $insure_address = '';


    //Финальная стоимость страховки
    $total_rate_price = 0;

    //Данные которые надо заносить в файл
    $const_insurer_work = 'M1';
    $const_insurer_program = 'S';
    $trip_type = 'Багаторазові/Multi trip';
    $separate = '-';
    $sprecial_conditions = 'Покриваються випадки пов\'язані з "COVID-19" / Covered  "COVID-19"';
    //Количество строчек в бланке под застрахованых персон
    $max_row_count = 6;

    $row_empty = '<tr>
            <td style="border: 1px solid #000;height: 8pt"></td>
            <td style="border: 1px solid #000;height: 8pt"></td>
            <td style="border: 1px solid #000;height: 8pt"></td>
            <td style="border: 1px solid #000;height: 8pt"></td>
            <td style="border: 1px solid #000;height: 8pt"></td>
            <td style="border: 1px solid #000;height: 8pt"></td>
            <td style="border: 1px solid #000;height: 8pt"></td>
            <td style="border: 1px solid #000;height: 8pt"></td>
            <td style="border: 1px solid #000;height: 8pt"></td>
            <td style="border: 1px solid #000;height: 8pt"></td>
            <td style="border: 1px solid #000;height: 8pt"></td>
            <td style="border: 1px solid #000;height: 8pt"></td>
            <td style="border: 1px solid #000;height: 8pt"></td>
            <td style="border: 1px solid #000;height: 8pt"></td>
            <td style="border: 1px solid #000;height: 8pt"></td>
        </tr>';

    //Страховальники
    $insurer_status = $order['insurer_status'];
    $insurers = $order_data->get_insurers( $order_id );

    $insurer_peoples_count = 0;
    $max_peoples_count = 1;




    if( $insurer_status ) {

        $insurer_age_coefficient = $order['rate_coefficient'];
        $insurer_rate_price = $rate_price * $insurer_age_coefficient;
        $insurer_rate_price = round( $insurer_rate_price, 2 );

        if ($order['rate_price_coefficient'] != 1) {
            $insurer_rate_price = $insurer_rate_price * $order['rate_price_coefficient'];
            $insurer_rate_price = round($insurer_rate_price, 2);
        }

        $total_rate_price = $insurer_rate_price;

    }


    if( $insurers ){

        foreach ( $insurers as $insurer ){

            if( $insurer_peoples_count <= $max_peoples_count )
            {
                $insure_name = $insurer['name'];
                $insure_last_name = $insurer['last_name'];
                $insure_passport = $insurer['passport'];
                $insure_birthday = date( 'd.m.Y', strtotime( $insurer['birthday'] ) );
                $insure_address = $insurer['address'];

                //расчет цены в зависимости от возрастного коеффициента
                $insurer_age_coefficient = $insurer['coefficient'];

                $insurer_rate_price = $rate_price * $insurer_age_coefficient;
                $insurer_rate_price = round( $insurer_rate_price, 2 );

                if( $order['rate_price_coefficient'] != 1 ){
                    $insurer_rate_price = $insurer_rate_price * $order['rate_price_coefficient'];
                    $insurer_rate_price = round( $insurer_rate_price, 2 );
                }

                //Суммыруем итоговую цену страхового полиса
                $total_rate_price += $insurer_rate_price;

            }

        }
    }





    /**
     * @description
     * Упрощенный метод формирования PDF из html
     */

// Create an instance of the class:
    $mpdf = new Mpdf\Mpdf([
        'mode' => 'utf-8', // кодировка (по умолчанию UTF-8)
        //'format' => 'A4', // - формат документа
        'format' => [210,297], // - формат документа
        'margin_left' => '7mm',
        'margin_right' => '5mm',
        'margin_top' => '5mm',
        'margin_bottom' => '5mm',
        //'orientation' => 'L' // - альбомная ориентация
    ]);

    $mpdf->simpleTables = true;

//    $mpdf->simpleTables = false;
//    $mpdf->packTableData = true;
//    $mpdf->keep_table_proportions = TRUE;
//    $mpdf->shrink_tables_to_fit=1;
//$mpdf->showImageErrors = true;
//$mpdf->set('SetHeader', 'Попередній перегляд договору');
// Заголовок PDF
//$mpdf->SetTitle( 'mPDF' );
// Автор
    $mpdf->SetAuthor('Kutsenko');
    /**
     * @name HTML
     * @description формируем html код
     */

    $html = file_get_contents(__DIR__ . DIRECTORY_SEPARATOR . "euroins.html");
    $search = ["%ORDERID%",
        "%LASTNAME%",
        "%NAME%",
        "%PASSPORT%",
        "%BIRTHDAY%",
        "%COUNTDAYS%",
        "%ADDRESS%",
        "%RATELOCATIONS%",
        "%RATEVALIDITY%",
        "%TRIPTYPE%",
        "%ROWS%",
        "%SPECIALCONDITIONS%",
        "%DATEFROM%",
        "%DATETO%",
        "%TOTALRATEPRICE%",
        "%DATE%",
        "%PAIMENTDATE%",
        "%FRANCHISE%",
        "%INSURERNAME%",
        "%INSURERLASTNAME%",
        "%INSURERBIRTHDAY%",
        "%INSURERPASSPORT%",
        "%INSURERADDRESS%",
        "%INSURERRATEPRICE%",
    ];


//    $replace = [$order_id,
    $replace = [$blank_number_print,
        $last_name,
        $name,
        $passport,
        $birthday,
        $count_days,
        $address,
        $rate_locations,
        $rate_validity,
        $trip_type,
        $rows,
        $sprecial_conditions,
        $dateFrom,
        $dateTo,
        $total_rate_price,
        $date,
        $paiment_date,
        $franchise,
        $insure_name,
        $insure_last_name,
        $insure_birthday,
        $insure_passport,
        $insure_address,
        $insurer_rate_price,
    ];
    $html = str_replace($search, $replace, $html);

//$mpdf->Image(__DIR__.DIRECTORY_SEPARATOR."pdf_templates".DIRECTORY_SEPARATOR."logonew.png", 0, 0, 133, 39, 'png', 'epolicy.com.ua', false, false);
// устанавливаем номер страницы если нужно
//$mpdf->setFooter( '{PAGENO}' );
// подключаем стили
// подключаем файл стилей
    $stylesheet = file_get_contents(__DIR__ . DIRECTORY_SEPARATOR . "style.css");
    $mpdf->WriteHTML($stylesheet, 1);
// генерируем сам PDF
    $mpdf->WriteHTML($html, 2);
// выводим PDF  в браузер
    $mpdf->Output();
// или сохраняем PDF в файл
//$mpdf->Output('filename.pdf','F');

}