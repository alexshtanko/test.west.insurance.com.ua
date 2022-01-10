<?php

require($_SERVER['DOCUMENT_ROOT'].'/wp-load.php');

$key = 'kDCRa89dc0e1';

require_once $_SERVER['DOCUMENT_ROOT'].'vendor/autoload.php';

require_once $_SERVER['DOCUMENT_ROOT'].'wp-content/wp-recall/add-on/insurance/class/insurance.php';


//Check key to run the script
if ( $key == $_GET['key'] ) {


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
    $franchise = $order['rate_franchise'];
    $rate_price = $order['rate_price'];
    $rate_insured_sum = $order['rate_insured_sum'];
    $rate_locations = $order['rate_locations'];
    $blank_number = $order['blank_number'];
    $blank_series = $order['blank_series'];

	$date_year = date( 'y', strtotime( $order['date_added'] ) );
    if(strlen(trim($blank_number)) == 6) $blank_number = "0".$blank_number;
	if(strlen(trim($blank_series)) > 0) $blank_series = $blank_series."/";

    //$blank_number_print = $blank_series . ' ' . $blank_number;
    $blank_number_print = $blank_series.$blank_number."/1054/".$date_year;


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

    if($companyId == 1) {

        if( $insurer_status ){

            $insurer_peoples_count = 1 + count( $insurers );

            $insurer_age_coefficient = $order['rate_coefficient'];
            $insurer_rate_price = $rate_price * $insurer_age_coefficient;
            $insurer_rate_price = round( $insurer_rate_price, 2 );


            //Расчет цены в зависимости от коеффициента наценки менеджера
            //Для компании "Провідна" ID = 1
            //Изначально надо уменьшить стоимость на 20%
            //Потом увеличиваем на выбраный коеффициент

            if( $order['rate_price_coefficient'] != 1 ){
                $insurer_rate_price = $insurer_rate_price / 1.2;
                $insurer_rate_price = $insurer_rate_price * $order['rate_price_coefficient'];
                $insurer_rate_price = round( $insurer_rate_price, 2 );
            }

            $rows .='<tr>
                        <td><p style="font-size: 7px;">' . $last_name . ' ' . $name . '</p></td>
                        <td><p style="font-size: 7px;">' . $passport . '</p></td>
                        <td><p style="font-size: 7px;">' . $birthday . '</p></td>
                        <td><p style="font-size: 7px;">'. $separate .'</p></td>
                        <td style="width=20px"><p style="font-size: 7px;">'. $const_insurer_work . '</p></td>
                        <td style="width=20px"><p style="font-size: 7px;">'. $const_insurer_program .'</p></td>
                        <td><p style="font-size: 7px;">' . $rate_insured_sum . '</p></td>
                        <td><p style="font-size: 7px;">' . $franchise . '</p></td>
                        <td><p style="font-size: 7px;">' . $insurer_rate_price . '</p></td>
                        <td style="width=80px"><p style="font-size: 7px;">'. $separate .'</p></td>
                        <td style="width=80px"><p style="font-size: 7px;">'. $separate .'</p></td>
                        <td style="width=80px"><p style="font-size: 7px;">'. $separate .'</p></td>
                        <td style="width=80px"><p style="font-size: 7px;">'. $separate .'</p></td>
                        <td style="width=80px"><p style="font-size: 7px;">'. $separate .'</p></td>
                        <td style="width=80px"><p style="font-size: 7px;">'. $separate .'</p></td>
                    </tr>';

            $total_rate_price = $insurer_rate_price;

            if( $insurers ){

                foreach ( $insurers as $insurer ){

                    //Записываем дату рождения
                    $insurer_birthday = date( 'd.m.Y', strtotime( $insurer['birthday'] ) );


                    //расчет цены в зависимости от возрастного коеффициента
                    $insurer_age_coefficient = $insurer['coefficient'];

                    $insurer_rate_price = $rate_price * $insurer_age_coefficient;
                    $insurer_rate_price = round( $insurer_rate_price, 2 );



                    //Расчет цены в зависимости от коеффициента наценки менеджера
                    //Для компании "Провідна" ID = 1
                    //Изначально надо уменьшить стоимость на 20%
                    //Потом увеличиваем на выбраный коеффициент

                    if( $order['rate_price_coefficient'] != 1 ){
                        $insurer_rate_price = $insurer_rate_price / 1.2;
                        $insurer_rate_price = $insurer_rate_price * $order['rate_price_coefficient'];
                        $insurer_rate_price = round( $insurer_rate_price, 2 );
                    }

                    //Суммыруем итоговую цену страхового полиса
                    $total_rate_price += $insurer_rate_price;

                    $rows .='<tr>
                        <td><p style="font-size: 7px;">' . $insurer['last_name'] . ' ' . $insurer['name'] . '</p></td>
                        <td><p style="font-size: 7px;">' . $insurer['passport'] . '</p></td>
                        <td><p style="font-size: 7px;">' . date( 'd.m.Y', strtotime( $insurer['birthday'] ) ) . '</p></td>
                        <td><p style="font-size: 7px;">'. $separate .'</p></td>
                        <td style="width=20px"><p style="font-size: 7px;">'. $const_insurer_work . '</p></td>
                        <td style="width=20px"><p style="font-size: 7px;">'. $const_insurer_program .'</p></td>
                        <td><p style="font-size: 7px;">' . $rate_insured_sum . '</p></td>
                        <td><p style="font-size: 7px;">' . $franchise . '</p></td>
                        <td><p style="font-size: 7px;">' . $insurer_rate_price . '</p></td>
                        <td style="width=80px"><p style="font-size: 7px;">'. $separate .'</p></td>
                        <td style="width=80px"><p style="font-size: 7px;">'. $separate .'</p></td>
                        <td style="width=80px"><p style="font-size: 7px;">'. $separate .'</p></td>
                        <td style="width=80px"><p style="font-size: 7px;">'. $separate .'</p></td>
                        <td style="width=80px"><p style="font-size: 7px;">'. $separate .'</p></td>
                        <td style="width=80px"><p style="font-size: 7px;">'. $separate .'</p></td>
                    </tr>';

                }
            }
        }
        else{
            if( $insurers ){


                $insurer_peoples_count = count( $insurers );

                foreach ( $insurers as $insurer ){

                    //Зфписываем фамилиию и имя

                    //Записываем дату рождения
                    $insurer_birthday = date( 'd.m.Y', strtotime( $insurer['birthday'] ) );

                    // "-"



                    //расчет цены в зависимости от возрастного коеффициента
                    $insurer_age_coefficient = $insurer['coefficient'];

                    $insurer_rate_price = $rate_price * $insurer_age_coefficient;
                    $insurer_rate_price = round( $insurer_rate_price, 2 );



                    //Расчет цены в зависимости от коеффициента наценки менеджера
                    //Для компании "Провідна" ID = 1
                    //Изначально надо уменьшить стоимость на 20%
                    //Потом увеличиваем на выбраный коеффициент

                    if( $order['rate_price_coefficient'] != 1 ){
                        $insurer_rate_price = $insurer_rate_price / 1.2;
                        $insurer_rate_price = $insurer_rate_price * $order['rate_price_coefficient'];
                        $insurer_rate_price = round( $insurer_rate_price, 2 );
                    }

                    //Суммыруем итоговую цену страхового полиса
                    $total_rate_price += $insurer_rate_price;

                    $rows .='<tr>
                        <td><p style="font-size: 7px;">' . $insurer['last_name'] . ' ' . $insurer['name'] . '</p></td>
                        <td><p style="font-size: 7px;">' . $insurer['passport'] . '</p></td>
                        <td><p style="font-size: 7px;">' . date( 'd.m.Y', strtotime( $insurer['birthday'] ) ) . '</p></td>
                        <td><p style="font-size: 7px;text-align: center">'. $separate .'</p></td>
                        <td style="width=20px"><p style="font-size: 7px;">'. $const_insurer_work . '</p></td>
                        <td style="width=20px"><p style="font-size: 7px;">'. $const_insurer_program .'</p></td>
                        <td><p style="font-size: 7px;">' . $rate_insured_sum . '</p></td>
                        <td><p style="font-size: 7px;">' . $franchise . '</p></td>
                        <td><p style="font-size: 7px;">' . $insurer_rate_price . '</p></td>
                        <td style="width=80px"><p style="font-size: 7px;text-align: center">'. $separate .'</p></td>
                        <td style="width=80px"><p style="font-size: 7px;text-align: center">'. $separate .'</p></td>
                        <td style="width=80px"><p style="font-size: 7px;text-align: center">'. $separate .'</p></td>
                        <td style="width=80px"><p style="font-size: 7px;text-align: center">'. $separate .'</p></td>
                        <td style="width=80px"><p style="font-size: 7px;text-align: center">'. $separate .'</p></td>
                        <td style="width=80px"><p style="font-size: 7px;text-align: center">'. $separate .'</p></td>
                    </tr>';

                }
            }
        }

    }


    if( $insurer_peoples_count < $max_row_count ){

        for ( $count_rows = $max_row_count - $insurer_peoples_count; $count_rows < $max_row_count; $count_rows++){

            $rows .= $row_empty;

        }
    }



    /**
     * @description
     * Упрощенный метод формирования PDF из html
     */

// Create an instance of the class:
    $mpdf = new Mpdf\Mpdf([
        'mode' => 'utf-8', // кодировка (по умолчанию UTF-8)
        'format' => 'A4', // - формат документа
        'margin_left' => 2,
        'margin_right' => 5,
        'margin_top' => 7,
        'margin_bottom' => 5,
        //'orientation' => 'L' // - альбомная ориентация
    ]);
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

    $html = file_get_contents(__DIR__ . DIRECTORY_SEPARATOR . "electronic.html");
    $search = ["%ORDERID%",
        "%LASTNAME%",
        "%NAME%",
        "%PASSPORT%",
        "%BIRTHDAY%",
        "%COUNTDAYS%",
        "%ADDRESS%",
        "%RATELOCATIONS%",
        "%TRIPTYPE%",
        "%ROWS%",
        "%SPECIALCONDITIONS%",
        "%DATEFROM%",
        "%DATETO%",
        "%TOTALRATEPRICE%",
        "%DATE%",
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
        $trip_type,
        $rows,
        $sprecial_conditions,
        $dateFrom,
        $dateTo,
        $total_rate_price,
        $date
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
else{
    echo 'error';
}