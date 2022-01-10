<?php

if( !defined('ACCESSCNSTINSURANCE' ) ) {
    die('Direct access not permitted');
}
else {

    require_once $_SERVER['DOCUMENT_ROOT'].'wp-content/themes/seofy/include/class_ekta.php';



//    $order_id = empty( $_GET['order_id'] ) ? $_GET['order_id'] : '';
    $order_id = $_GET['order_id'];
//    echo $order_id;
    $ekta = new Ekta(__DIR__);

    $ekta_order_data = $ekta->get_ekta_order( $order_id );

    $ekta_order_id = $ekta_order_data['ekta_id'];




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
    $paiment_date = $date;
//    $paiment_date = date('d.m.Y', strtotime('-1 day', strtotime($order['date_from'])));
    $franchise = $order['rate_franchise'];
    $rate_price = $order['rate_price'];
    $rate_insured_sum = $order['rate_insured_sum'];
    $rate_locations = $order['rate_locations'];
    $blank_number = $order['blank_number'];
    $blank_series = $order['blank_series'];
    $rate_validity = explode( '/', $order['rate_validity'] );
    $insurance_validity = $rate_validity[0];
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
    $max_peoples_count = 2;

    $count_person = 0;
    $count_person_tmp = 0;
    $rate_price_tmp = 0;

    $rate_price_total_mb = 0;
    $rate_price_total_hb = 0;

    //Застрахованые особы:
    $tourist = '';

    $coefficient_mb = .6;
    $coefficient_hb = .4;



    $tourist_empty = '<div class="row"><div class="w-100 left"><div class="inner b-t b-l b-r h-18 l-h-16 t-a-c"><b>-----</b></div></div><div class="w-20 left"><div class="inner b-t  h-18 l-h-17 t-a-c"><b>-----</b></div></div><div class="w-19 left"><div class="inner b-t b-l  b-r h-18 l-h-17 t-a-c"><b>-----</b></div></div><div class="w-5 left"><div class="inner b-t  h-18 l-h-17 t-a-c">-----</div></div><div class="w-47 left h-18"><div class="inner b-t b-l  h-16 l-h-5 t-a-c"><div class="w-16 left h-14"><div class="inner h-14 l-h-17 t-a-c"><b>-----</b></div></div><div class="w-15 left h-14"><div class="inner b-l h-14 l-h-17 t-a-c"><b>-----</b></div></div><div class="w-15 left h-14"><div class="inner b-l h-14 l-h-17 t-a-c"><b>-----</b></div></div></div></div><div class="w-8 left h-18"><div class="inner b-t b-l b-r h-16 l-h-17 t-a-c">-----</div></div></div>';

    // В зависимости от количества "туристов" застрахованых людей будут разные коеффициенты МВ и НВ
    if( $insurer_status )
    {
        $count_person_tmp ++;
        $rate_price_tmp += $rate_price;
    }

    if( $insurers )
    {
        foreach ( $insurers as $insurer ){
            $count_person_tmp ++;
            $rate_price_tmp += $rate_price;
        }
    }

    if( $count_person_tmp == 1 )
    {
        $coefficient_mb = .6;
        $coefficient_hb = .4;
    }
    elseif ( $count_person_tmp == 2 )
    {
        $coefficient_mb = .3;
        $coefficient_hb = .2;
    }

    $fs = 'f-7';
    $ifs = 'f-7';
    $lh = 'l-h-16';

    $last_name_name_address = $last_name  . ' ' . $name . '/ ' . $address;
    $last_name_name_address_len = iconv_strlen($last_name_name_address);

    if( $last_name_name_address_len >= 50 && $last_name_name_address_len < 100)
    {
        $fs = ' f-5';
    }
    elseif( $last_name_name_address_len >= 100 )
    {
        $fs = ' f-5';
        $lh = ' l-h-8';
    }
//    elseif( $last_name_name_address_len >= 100 )
//    {
//        $fs = ' f-5';
//    }

//    var_dump($last_name_name_address_len);
//    echo $lh;
//    echo $fs;
//
//    die();


    if( $insurer_status ) {

        $insurer_age_coefficient = $order['rate_coefficient'];
        $insurer_rate_price = $rate_price * $insurer_age_coefficient;
        $insurer_rate_price = round( $insurer_rate_price, 2 );

        if ($order['rate_price_coefficient'] != 1) {
            $insurer_rate_price = $insurer_rate_price * $order['rate_price_coefficient'];
            $insurer_rate_price = round($insurer_rate_price, 2);
        }

        $total_rate_price = $insurer_rate_price;

        $count_person ++;
        $count_person_tmp ++;

//        $tourist[] = [
//            'name' => $name,
//            'last_name' => $last_name,
//            'passport' => $passport,
//        ];

        $rate_price_mb = $rate_price_tmp * $coefficient_mb;
        $rate_price_hb = $rate_price_tmp * $coefficient_hb;

        $rate_price_total_mb += $rate_price_mb;
        $rate_price_total_hb += $rate_price_hb;

        $last_name_name_address = $last_name  . ' ' . $name . '/ ' . $address;
        $last_name_name_address_len = iconv_strlen($last_name_name_address);



        $ilh = ' l-h-17';
        if( $last_name_name_address_len >= 50 && $last_name_name_address_len < 100 )
        {
            $ifs = ' f-5';
        }
        elseif( $last_name_name_address_len >= 100 )
        {
            $ifs = ' f-5';
            $ilh = ' l-h-9';
        }

        $tourist .= '<div class="row"><div class="w-100 left"><div class="inner b-t b-l b-r h-18 '. $ilh .' t-a-c ' . $ifs . '"><b>' . $last_name_name_address . '</b></div></div><div class="w-20 left"><div class="inner b-t h-18 l-h-17 t-a-c"><b>' . $passport . '</b></div></div><div class="w-19 left"><div class="inner b-t b-l b-r h-18 l-h-17 t-a-c"><b>' . $passport . '</b></div></div><div class="w-5 left"><div class="inner b-t h-18 l-h-17 t-a-c">-----</div></div><div class="w-47 left h-18"><div class="inner b-t b-l h-16 l-h-5 t-a-c"><div class="w-16 left h-14"><div class="inner h-14 l-h-17 t-a-c"><b>' . $rate_price_mb . '</b></div></div><div class="w-15 left h-14"><div class="inner b-l h-14 l-h-17 t-a-c"><b>' . $rate_price_hb . '</b></div></div><div class="w-15 left h-14"><div class="inner b-l h-14 l-h-17 t-a-c"><b>' . $rate_price . '</b></div></div></div></div><div class="w-8 left h-18"><div class="inner b-t b-l b-r h-16 l-h-17 t-a-c">-----</div></div></div>';

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

                $count_person++;

                $rate_price_mb = $rate_price_tmp * $coefficient_mb;
                $rate_price_hb = $rate_price_tmp * $coefficient_hb;

                $rate_price_total_mb += $rate_price_mb;
                $rate_price_total_hb += $rate_price_hb;

                $insure_last_name_name_address = $insure_last_name  . ' ' . $insure_name . '/ ' . $insure_address;
                $insure_last_name_name_address_len = iconv_strlen($insure_last_name_name_address);

                $ilh = ' l-h-17';

                if( $last_name_name_address_len >= 50 && $last_name_name_address_len < 100 )
                {
                    $ifs = ' f-5';
                }
                elseif( $last_name_name_address_len >= 100 )
                {
                    $ifs = ' f-5';
                    $ilh = ' l-h-9';
                }
                $tourist .= '<div class="row"><div class="w-100 left"><div class="inner b-t b-l b-r h-18 '. $ilh .' t-a-c ' . $ifs . '"><b>' . $insure_last_name_name_address . '</b></div></div><div class="w-20 left"><div class="inner b-t  h-18 l-h-16 t-a-c"><b>' . $insure_passport . '</b></div></div><div class="w-19 left"><div class="inner b-t b-l  b-r h-18 l-h-16 t-a-c"><b>' . $insure_birthday . '</b></div></div><div class="w-5 left"><div class="inner b-t  h-18 l-h-16 t-a-c">-----</div></div><div class="w-47 left h-18"><div class="inner b-t b-l h-16 l-h-5 t-a-c"><div class="w-16 left h-14"><div class="inner h-14 l-h-17 t-a-c"><b>' . $rate_price_mb . '</b></div></div><div class="w-15 left h-14"><div class="inner b-l h-14 l-h-17 t-a-c"><b>' . $rate_price_hb . '</b></div></div><div class="w-15 left h-14"><div class="inner b-l h-14 l-h-17 t-a-c"><b>' . $rate_price . '</b></div></div></div></div><div class="w-8 left h-18"><div class="inner b-t b-l b-r  h-16 l-h-17 t-a-c">-----</div></div></div>';

            }

        }
    }

    if( $count_person < 2 )
    {
        $tourist .= $tourist_empty;
    }





    /**
     * @description
     * Упрощенный метод формирования PDF из html
     */

// Create an instance of the class:
    $mpdf = new Mpdf\Mpdf([
        'mode' => 'utf-8', // кодировка (по умолчанию UTF-8)
        //'format' => 'A4', // - формат документа
        'format' => [212,297], // - формат документа
        'margin_left' => '7mm',
        'margin_right' => '5mm',
        'margin_top' => '4mm',
        'margin_bottom' => '4mm',
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


    $html = file_get_contents(__DIR__ . DIRECTORY_SEPARATOR . "ekta.html");
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

        "%INSURANCEVALIDITY%",
        "%COUNTPERSON%",
        "%RATEINSUREDSUM%",
        "%EKTAORDERID%",
        "%TOURIST%",
        "%RATEPRICETOTALMB%",
        "%RATEPRICETOTALHB%",
        "%LASTNAMENAMEADDRESS%",
        "%FS%",
        "%IFS%",
        "%LH%",
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

        $insurance_validity,
        $count_person,
        $sumInsured,
        $ekta_order_id,
        $tourist,
        $rate_price_total_mb,
        $rate_price_total_hb,
        $last_name_name_address,
        $fs,
        $ifs,
        $lh,
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