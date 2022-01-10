<?php

if( !defined('ACCESSCNST' ) ) {
    die('Direct access not permitted');
}
else{

    $rows = '';

    // Андрей попросил поменять вывод номера (23.07.2021)
    $date_year = date( 'y', strtotime( $order['date_added'] ) );
    if(strlen(trim($blank_number)) == 6) $blank_number = "0".$blank_number;
    if(strlen(trim($blank_series)) > 0) $blank_series = $blank_series."/";
    $blank_number_print = $blank_series.$blank_number."/1054/".$date_year;
    //////////////////////////////////////////////////////

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

    // Добавляем пустые ряды
    if( $insurer_peoples_count < $max_row_count ){

        for ( $count_rows = $max_row_count - $insurer_peoples_count; $count_rows < $max_row_count; $count_rows++){

            $rows .= $row_empty;

        }
    }


    //Формируем PDF файл

    $mpdf = new Mpdf\Mpdf([
        'mode' => 'utf-8', // кодировка (по умолчанию UTF-8)
        'format' => 'A4', // - формат документа
        'margin_left' => 2,
        'margin_right' => 5,
        'margin_top' => 7,
        'margin_bottom' => 5,
    ]);

    // Автор
    $mpdf->SetAuthor('Shtanko');

    $html = file_get_contents(__DIR__ . "/providna.html");
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

    // подключаем файл стилей
    $stylesheet = file_get_contents(__DIR__  . "/style.css");
    $mpdf->WriteHTML($stylesheet, 1);
    // генерируем сам PDF
    $mpdf->WriteHTML($html, 2);
    // выводим PDF  в браузер
    $mpdf->Output();

}