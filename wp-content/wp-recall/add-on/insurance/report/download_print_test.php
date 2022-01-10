<?php

include_once '../class/insurance.php';

require($_SERVER['DOCUMENT_ROOT'].'/wp-load.php');

require ABSPATH . '/vendor/autoload.php';

// require ABSPATH . '/plc/vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$order_id = $_GET['order_id'];

$key = $_GET['key'];

$secure_key = 'WPbm49ebf124';

if ( ! empty( $order_id ) && $key == $secure_key ){

    $insurance = new Insurance_Class();

    $status = true; //$insurance->export_excell( $order_id );

	// var_dump($status);

    if( $status ){

        $order = $insurance->get_order( $order_id );

	    if($order['status'] != 1) wp_die( "Статус договору повинен бути 'Заключений'", "Помилка формування бланку" );

        $programId = $order['program_id'];
        $companyId = $order['company_id'];

        $name = $order['name'];
        $firstName = $order['last_name'];
        $passport = $order['passport'];
        $birthday = date( 'd.m.Y', strtotime( $order['birthday'] ) );
        $address = $order['address'];
        $country = $order['rate_locations'];
        $phone = $order['phone_number'];
        $countDays = $order['count_days'];
        $dateFrom = date( 'd.m.Y', strtotime( $order['date_from'] ) );
        $dateTo = date( 'd.m.Y', strtotime( $order['date_to'] ) );
        $sumInsured = $order['rate_insured_sum'];
        $date = date( 'd.m.Y', strtotime( $order['date_added'] ) );
        $franchise = $order['rate_franchise'];
		$rate_price = $order['rate_price'];

        //Финальная стоимость страховки
        $total_rate_price = 0;


		//Данные которые надо заносить в фланк
		$const_insurer_separate = '-';
        $const_insurer_work = 'M1';
		$const_insurer_program = 'V';



		//20.04.2021
        //Страховальники
		$insurer_status = $order['insurer_status'];
		$insurers = $insurance->get_insurers( $order_id );

		$insurer_peoples_count = 0;


		//price * coefficient
		//$rate_coefficient = $order['rate_coefficient'];
		//$rate_price = $rate_price * $rate_coefficient;
		//$rate_price = round( $rate_price, 2 );
//echo '<pre>';
//var_dump($insurers);
//wp_die();
        $explodeDateFrom = explode(".", $dateFrom);
        $explodeDateTo = explode(".", $dateTo);
        $explodeFranchise = explode(" ", $franchise);
        $explodeSumInsured = explode(" ", $sumInsured);


        $tariff = 1100/($explodeSumInsured[0]*30)*100;



        $t = ['order' => $order,
	          'programId' => $programId,
	          'companyId' => $companyId,
	          'name' => $name,
	          'firstName' => $firstName,
	          'passport' => $passport,
	          'birthday' => $birthday,
	          'address' => $address,
	          'country' => $country,
	          'phone' => $phone,
	          'countDays' => $countDays,
	          'dateFrom' => $dateFrom,
	          'dateTo' => $dateTo,
	          'sumInsured' => $sumInsured,
	          'date' => $date,
	          'franchise' => $franchise,
	          'rate_price' => $rate_price,
        ];


//	    if( $insurers ) {
//		    //$row_count = 14;
//		    foreach ( $insurers as $insurer ) {
//			    echo "<pre>";
//			    print_r($insurer);
//			    echo "</pre><br/ >";
//		    }
//	    }
//
//	    echo "<pre>";
//	    print_r($order);
//	    echo "</pre>";
//
//	   foreach($t as $key => $value){
//	   	    echo "<p>".$key." => ".$value."</p>";
//	   }
//	   exit;

        $reader = IOFactory::createReader("Xlsx");

	    if($companyId == 1 || $companyId == 2 || $companyId == 3 || $companyId == 4 || $companyId == 5) {
			    $spreadsheet = $reader->load( "inter_plus_paper.xlsx" );

			    if(!$spreadsheet) wp_die( "Файл для формування бланку не знайдено", "Помилка формування бланку" );

			    $sheet = $spreadsheet->getSheetByName('DATA');

			    $sheet->setCellValueByColumnAndRow( 4, 1, $order['blank_series'] . $order['blank_number'] );

			    $datePrint = date( 'd.m.Y Hi', strtotime( $order['date_added'] ) );
			    $datePrint = str_split($datePrint);

			    $rowDatePrint = 4;
			    foreach($datePrint as $value){
				    $sheet->setCellValueByColumnAndRow( $rowDatePrint, 2, strval($value) );
				    $rowDatePrint++;
			    }

			    $rateValidity = explode("/", $order['rate_validity']);
			    $sheet->setCellValueByColumnAndRow( 4, 3, $rateValidity[0] );
			    $sheet->setCellValueByColumnAndRow( 4, 4, $rateValidity[1] );

			    $dateFrom = date( 'd.m.Y', strtotime( $order['date_from'] ) );
			    $dateFrom = str_split($dateFrom);
			    $rowDateFrom = 4;
			    foreach($dateFrom as $value){
				    $sheet->setCellValueByColumnAndRow( $rowDateFrom, 5, strval($value) );
				    $rowDateFrom++;
			    }

			    $dateTo = date( 'd.m.Y', strtotime( $order['date_to'] ) );
			    $dateTo = str_split($dateTo);
			    $rowDateTo = 4;
			    foreach($dateTo as $value){
				    $sheet->setCellValueByColumnAndRow( $rowDateTo, 6, strval($value) );
				    $rowDateTo++;
			    }

			    $sheet->setCellValueByColumnAndRow( 4, 7, $firstName . ' ' . $name );
			    $sheet->setCellValueByColumnAndRow( 14, 8, $order['passport'] );
			    $sheet->setCellValueByColumnAndRow( 4, 9, $birthday );
			    $sheet->setCellValueByColumnAndRow( 4,  10, $order['address'] );
			    $sheet->setCellValueByColumnAndRow( 4, 11, $order['phone_number'] );

			    $sheet->setCellValueByColumnAndRow( 4, 12, $explodeSumInsured[0]);
			    $sheet->setCellValueByColumnAndRow( 5, 12, $explodeSumInsured[1]);

			    $sheet->setCellValueByColumnAndRow( 4, 16, $order['rate_locations'] );

			    $sheet->setCellValueByColumnAndRow( 4, 21, "франшиза ".$franchise." Cover Covid-19" );

			    // Дальше таблица с перечнем людей
			    $sheet->setCellValueByColumnAndRow( 4, 29, $firstName . ' ' . $name );
			    $sheet->setCellValueByColumnAndRow( 5, 29, $birthday );

			    $peoplesTable = 30;

			    if( $insurer_status){
				    $insurer_age_coefficient = $order['rate_coefficient'];
				    $insurer_rate_price = $rate_price * $insurer_age_coefficient;
				    if( $order['rate_price_coefficient'] != 1 ){
					    $insurer_rate_price = $insurer_rate_price * $order['rate_price_coefficient'];
				    }
				    $insurer_rate_price = round( $insurer_rate_price, 2 );
				    $sheet->setCellValueByColumnAndRow( 7, 29, $insurer_rate_price );
				    $total_rate_price = $insurer_rate_price;

				    $sheet->setCellValueByColumnAndRow( 7, $peoplesTable, $insurer_rate_price );
				    // Заполняем таблицу застрахованными
				    $sheet->setCellValueByColumnAndRow( 4, $peoplesTable, $firstName . ' ' . $name );
				    $sheet->setCellValueByColumnAndRow( 5, $peoplesTable, $birthday);
				    $sheet->setCellValueByColumnAndRow( 6, $peoplesTable, $order['passport'] );
				    $sheet->setCellValueByColumnAndRow( 12, $peoplesTable, $sumInsured);
				    $sheet->setCellValueByColumnAndRow( 8, $peoplesTable, "0.00");
				    $sheet->setCellValueByColumnAndRow( 9, $peoplesTable, "0.00");
				    $sheet->setCellValueByColumnAndRow( 10, $peoplesTable, "0.00");
				    $sheet->setCellValueByColumnAndRow( 13, $peoplesTable, "0.00");
				    $sheet->setCellValueByColumnAndRow( 14, $peoplesTable, "0.00 грн.");
				    $sheet->setCellValueByColumnAndRow( 15, $peoplesTable, "0.00");
				    $sheet->setCellValueByColumnAndRow( 16, $peoplesTable, "0.00");
				    $sheet->setCellValueByColumnAndRow( 17, $peoplesTable, "0.00");
				    $sheet->setCellValueByColumnAndRow( 18, $peoplesTable, "0.00");
				    $sheet->setCellValueByColumnAndRow( 19, $peoplesTable, "0.00");
			    }
			    else {
				    $sheet->setCellValueByColumnAndRow( 7, 29, "" );

				    $sheetBlank = $spreadsheet->getSheetByName('Поліс');
				    $sheetBlank->setCellValueByColumnAndRow( 2, 9, "Страхувальник" );
				    $sheetBlank->setCellValueByColumnAndRow( 2, 10, "Policy" );
			    }

			    $sheet->setCellValueByColumnAndRow( 12, 29, $sumInsured );


			    if( $insurers ) {
				    $row_count = $insurer_status ? 31 : $peoplesTable;
				    foreach ( $insurers as $insurer ) {

					    $insurer_age_coefficient = $insurer['coefficient'];
					    $insurer_rate_price = $rate_price * $insurer_age_coefficient;
					    $insurer_rate_price = round( $insurer_rate_price, 2 );

					    if( $order['rate_price_coefficient'] != 1 ){
						    $insurer_rate_price = $insurer_rate_price * $order['rate_price_coefficient'];
						    $insurer_rate_price = round( $insurer_rate_price, 2 );
					    }

					    //Суммыруем итоговую цену страхового полиса
					    $total_rate_price += $insurer_rate_price;

					    // Заполняем таблицу застрахованными
					    $sheet->setCellValueByColumnAndRow( 4, $row_count, $insurer['last_name']." ".$insurer['name'] );
					    $sheet->setCellValueByColumnAndRow( 5, $row_count, date( 'd.m.Y', strtotime( $insurer['birthday'] ) ));

					    $sheet->setCellValueByColumnAndRow( 6, $row_count, $insurer['passport'] );

					    $sheet->setCellValueByColumnAndRow( 7, $row_count, $insurer_rate_price);
					    $sheet->setCellValueByColumnAndRow( 12, $row_count, $sumInsured);

					    $sheet->setCellValueByColumnAndRow( 8, $row_count, "0.00");
					    $sheet->setCellValueByColumnAndRow( 9, $row_count, "0.00");
					    $sheet->setCellValueByColumnAndRow( 10, $row_count, "0.00");
					    $sheet->setCellValueByColumnAndRow( 13, $row_count, "0.00");
					    $sheet->setCellValueByColumnAndRow( 14, $row_count, "0.00 грн.");
					    $sheet->setCellValueByColumnAndRow( 15, $row_count, "0.00");
					    $sheet->setCellValueByColumnAndRow( 16, $row_count, "0.00");
					    $sheet->setCellValueByColumnAndRow( 17, $row_count, "0.00");
					    $sheet->setCellValueByColumnAndRow( 18, $row_count, "0.00");
					    $sheet->setCellValueByColumnAndRow( 19, $row_count, "0.00");

					    $row_count++;
				    }
			    }

			    $sheet->setCellValueByColumnAndRow( 4, 22, $total_rate_price );
			    $sheet->setCellValueByColumnAndRow( 4, 23, $total_rate_price );

			    $imageCells = ["A3", "A36", "A69"];
			    foreach($imageCells as $imageKey => $imageVal){
				    $imageKey = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
				    $imageKey->setName('Inter Plus');
				    $imageKey->setDescription('Inter Plus');
				    $imageKey->setPath('img/inter_plus.png'); // put your path and image here
				    $imageKey->setWidth(230);
				    $imageKey->setCoordinates($imageVal);
				    $imageKey->setOffsetX(15);
				    $imageKey->setOffsetY(12);
				    $imageKey->setWorksheet($spreadsheet->getActiveSheet());
			    }


	    }
        else if($companyId == 2222) {
	        switch ($programId) {
		        case "1":
			        $spreadsheet = $reader->load( "gardian.xlsx" );
			        break;
		        case "3":
			        $spreadsheet = $reader->load( "gardian_bezviz.xlsx" );
			        break;
		        case "4":
			        $spreadsheet = $reader->load( "gardian_chekhiya.xlsx" );
			        break;
		        default:
			        $spreadsheet = false;
	        }

	        if(!$spreadsheet) wp_die( "Файл для формування бланку не знайдено", "Помилка формування бланку" );

	        $sheet       = $spreadsheet->getActiveSheet();
	        $sheet->setCellValueByColumnAndRow( 6, 4, $firstName . ' ' . $name );


            if( $insurer_status ){
                $insurer_age_coefficient = $order['rate_coefficient'];
                $insurer_rate_price = $rate_price * $insurer_age_coefficient;
                $insurer_rate_price = round( $insurer_rate_price, 2 );

                $insurer_peoples_count = 1 + count( $insurers );


                $insurer_status_text = 'Так/Yes';




                //Добавление цены
                $sheet->setCellValueByColumnAndRow( 10, 9, $insurer_rate_price );

                $total_rate_price = $insurer_rate_price;

                if( $insurers ){
                    $row_count = 14;
                    foreach ( $insurers as $insurer ){

                        //Зфписываем фамилиию и имя
                        $sheet->setCellValueByColumnAndRow( 2, $row_count, $insurer['last_name'] . ' ' . $insurer['name'] );
                        //Записываем пасспортные данные
                        $sheet->setCellValueByColumnAndRow( 7, $row_count, $insurer['passport'] );

                        //Аресс
                        $sheet->setCellValueByColumnAndRow( 9, $row_count, $insurer['address'] );
                        //Записываем дату рождения
                        //Записываем дату рождения
                        $insurer_birthday = date( 'd.m.Y', strtotime( $insurer['birthday'] ) );
                        $sheet->setCellValueByColumnAndRow( 14, $row_count, $insurer_birthday );

                        //расчет цены в зависимости от возрастного коеффициента
                        $insurer_age_coefficient = $insurer['coefficient'];

                        $insurer_rate_price = $rate_price * $insurer_age_coefficient;
                        $insurer_rate_price = round( $insurer_rate_price, 2 );




                        //Страховой платеж
                        $sheet->setCellValueByColumnAndRow(10, $row_count, $insurer_rate_price);

                        //Суммыруем итоговую цену страхового полиса
                        $total_rate_price += $insurer_rate_price;


                        $row_count ++;

                    }
                }
            }
            else{
                if( $insurers ){
                    $row_count = 13;

                    $insurer_peoples_count = count( $insurers );

                    $insurer_status_text = 'Ні/No';

                    foreach ( $insurers as $insurer ){

                        //Зфписываем фамилиию и имя
                        $sheet->setCellValueByColumnAndRow( 2, $row_count, $insurer['last_name'] . ' ' . $insurer['name'] );
                        //Записываем пасспортные данные
                        $sheet->setCellValueByColumnAndRow( 7, $row_count, $insurer['passport'] );

                        //Аресс
                        $sheet->setCellValueByColumnAndRow( 9, $row_count, $insurer['address'] );
                        //Записываем дату рождения
                        //Записываем дату рождения
                        $insurer_birthday = date( 'd.m.Y', strtotime( $insurer['birthday'] ) );
                        $sheet->setCellValueByColumnAndRow( 14, $row_count, $insurer_birthday );

                        //расчет цены в зависимости от возрастного коеффициента
                        $insurer_age_coefficient = $insurer['coefficient'];

                        $insurer_rate_price = $rate_price * $insurer_age_coefficient;
                        $insurer_rate_price = round( $insurer_rate_price, 2 );


                        //Страховой платеж
                        $sheet->setCellValueByColumnAndRow(10, $row_count, $insurer_rate_price);

                        //Суммыруем итоговую цену страхового полиса
                        $total_rate_price += $insurer_rate_price;


                        $row_count ++;

                    }
                }
            }


	        $sheet->setCellValueByColumnAndRow( 4, 6, $passport );
	        $sheet->setCellValueByColumnAndRow( 10, 6, $birthday );
	        $sheet->setCellValueByColumnAndRow( 6, 8, $address );
	        $sheet->setCellValueByColumnAndRow( 14, 6, $phone );
	        $sheet->setCellValueByColumnAndRow( 11, 9, $country );
	        $sheet->setCellValueByColumnAndRow( 16, 5, $countDays );
	        $sheet->setCellValueByColumnAndRow( 16, 10, $sumInsured );
	        $sheet->setCellValueByColumnAndRow( 20, 16, $date );

	        //
            $sheet->setCellValueByColumnAndRow( 15, 5, $insurer_status_text );

	        // $sheet->setCellValueByColumnAndRow(19, 11, $tariff);
//	        $sheet->setCellValueByColumnAndRow( 26, 8, $rate_price );
//	        $sheet->setCellValueByColumnAndRow( 19, 12, $rate_price );

            //Цена за одногу страховую особу
            $sheet->setCellValueByColumnAndRow( 26, 8, $rate_price );
//            $sheet->setCellValueByColumnAndRow( 26, 8, $total_rate_price );
//            $sheet->setCellValueByColumnAndRow( 19, 12, $total_rate_price );
            $sheet->setCellValueByColumnAndRow( 19, 12, $rate_price );

            //Количество людей которых страхуем
            $sheet->setCellValueByColumnAndRow( 26, 11, $insurer_peoples_count );

            //Цена за всех
            $sheet->setCellValueByColumnAndRow( 26, 13, $total_rate_price );

	        $sheet->setCellValueByColumnAndRow( 26, 16, $explodeFranchise[0]);
	        //$sheet->setCellValueByColumnAndRow( 26, 16, 0 );
	        //$sheet->fromArray( [0], null, 'Z16', true );
	        $sheet->setCellValueByColumnAndRow( 27, 16, $explodeFranchise[1] );

	        $sheet->setCellValueByColumnAndRow( 20, 3, $explodeDateFrom[0] );
	        $sheet->setCellValueByColumnAndRow( 21, 3, $explodeDateFrom[1] );
	        $sheet->setCellValueByColumnAndRow( 22, 3, $explodeDateFrom[2] );

	        $sheet->setCellValueByColumnAndRow( 25, 3, $explodeDateTo[0] );
	        $sheet->setCellValueByColumnAndRow( 26, 3, $explodeDateTo[1] );
	        $sheet->setCellValueByColumnAndRow( 27, 3, $explodeDateTo[2] );
        }
        else if($companyId == 1) {
	        switch ($programId) {
		        case "1":
			        $spreadsheet = $reader->load("providna.xlsx");
                    //Данные которые надо заносить в фланк
                    $const_insurer_work = 'M1';
                    $const_insurer_program = 'V';
			        break;
		        case "3":
			        $spreadsheet = $reader->load( "providna_bezviz.xlsx" );
                    //Данные которые надо заносить в фланк
                    $const_insurer_work = '-';
                    $const_insurer_program = 'S';
			        break;
		        case "4":
			        $spreadsheet = $reader->load( "providna_chekhiya.xlsx" );
                    //Данные которые надо заносить в фланк
                    $const_insurer_work = 'M1';
                    $const_insurer_program = 'S';
			        break;
		        default:
			        $spreadsheet = false;
	        }

	        if(!$spreadsheet) wp_die( "Файл для формування бланку не знайдено", "Помилка формування бланку" );

	        $sheet       = $spreadsheet->getActiveSheet();
	        $sheet->setCellValueByColumnAndRow(3, 4, $firstName.' '.$name);
	        $sheet->setCellValueByColumnAndRow(3, 5, $passport);
	        $sheet->setCellValueByColumnAndRow(9, 5, $birthday);



            if( $insurer_status ){

                $insurer_peoples_count = 1 + count( $insurers );

                $sheet->setCellValueByColumnAndRow( 1, 9, $firstName . ' ' . $name );

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

                //Добавление цены
                $sheet->setCellValueByColumnAndRow( 10, 9, $insurer_rate_price );

                $total_rate_price = $insurer_rate_price;

                if( $insurers ){
                    $row_count = 10;
                    foreach ( $insurers as $insurer ){

                        //Зфписываем фамилиию и имя
                        $sheet->setCellValueByColumnAndRow( 1, $row_count, $insurer['last_name'] . ' ' . $insurer['name'] );
                        //Записываем пасспортные данные
                        $sheet->setCellValueByColumnAndRow( 3, $row_count, $insurer['passport'] );
                        //Записываем дату рождения
                        $insurer_birthday = date( 'd.m.Y', strtotime( $insurer['birthday'] ) );
                        $sheet->setCellValueByColumnAndRow( 4, $row_count, $insurer_birthday );

                        // "-"
                        $sheet->setCellValueByColumnAndRow( 5, $row_count, $const_insurer_separate );
                        $sheet->setCellValueByColumnAndRow( 11, $row_count, $const_insurer_separate );
                        $sheet->setCellValueByColumnAndRow( 12, $row_count, $const_insurer_separate );
                        $sheet->setCellValueByColumnAndRow( 13, $row_count, $const_insurer_separate );
                        $sheet->setCellValueByColumnAndRow( 14, $row_count, $const_insurer_separate );
                        $sheet->setCellValueByColumnAndRow( 15, $row_count, $const_insurer_separate );
                        $sheet->setCellValueByColumnAndRow( 16, $row_count, $const_insurer_separate );

                        //Название программы "М1"
                        $sheet->setCellValueByColumnAndRow( 6, $row_count, $const_insurer_work );

                        //программа стразования "V"
                        $sheet->setCellValueByColumnAndRow( 7, $row_count, $const_insurer_program );

                        //Страховая сумма
                        $sheet->setCellValueByColumnAndRow(8, $row_count, $explodeSumInsured[0]);
                        //Франшиза
                        $sheet->setCellValueByColumnAndRow(9, $row_count, $franchise);


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

                        //Страховой платеж
                        $sheet->setCellValueByColumnAndRow(10, $row_count, $insurer_rate_price);

                        //Суммыруем итоговую цену страхового полиса
                        $total_rate_price += $insurer_rate_price;


                        $row_count ++;

                    }
                }
            }
            else{
                if( $insurers ){
                    $row_count = 9;

                    $insurer_peoples_count = count( $insurers );

                    foreach ( $insurers as $insurer ){

                        //Зфписываем фамилиию и имя
                        $sheet->setCellValueByColumnAndRow( 1, $row_count, $insurer['last_name'] . ' ' . $insurer['name'] );
                        //Записываем пасспортные данные
                        $sheet->setCellValueByColumnAndRow( 3, $row_count, $insurer['passport'] );
                        //Записываем дату рождения
                        $insurer_birthday = date( 'd.m.Y', strtotime( $insurer['birthday'] ) );
                        $sheet->setCellValueByColumnAndRow( 4, $row_count, $insurer_birthday );

                        // "-"
                        $sheet->setCellValueByColumnAndRow( 5, $row_count, $const_insurer_separate );
                        $sheet->setCellValueByColumnAndRow( 11, $row_count, $const_insurer_separate );
                        $sheet->setCellValueByColumnAndRow( 12, $row_count, $const_insurer_separate );
                        $sheet->setCellValueByColumnAndRow( 13, $row_count, $const_insurer_separate );
                        $sheet->setCellValueByColumnAndRow( 14, $row_count, $const_insurer_separate );
                        $sheet->setCellValueByColumnAndRow( 15, $row_count, $const_insurer_separate );
                        $sheet->setCellValueByColumnAndRow( 16, $row_count, $const_insurer_separate );

                        //Название программы "М1"
                        $sheet->setCellValueByColumnAndRow( 6, $row_count, $const_insurer_work );

                        //программа стразования "V"
                        $sheet->setCellValueByColumnAndRow( 7, $row_count, $const_insurer_program );

                        //Страховая сумма
                        $sheet->setCellValueByColumnAndRow(8, $row_count, $explodeSumInsured[0]);
                        //Франшиза
                        $sheet->setCellValueByColumnAndRow(9, $row_count, $franchise);


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

                        //Страховой платеж
                        $sheet->setCellValueByColumnAndRow(10, $row_count, $insurer_rate_price);

                        //Суммыруем итоговую цену страхового полиса
                        $total_rate_price += $insurer_rate_price;

                        $row_count ++;

                    }
                }
            }

	        if(strlen($phone) > 0) {
		        $sheet->setCellValueByColumnAndRow( 3, 6, $address . ", " . $phone );
	        }
	        else {
		        $sheet->setCellValueByColumnAndRow( 3, 6, $address );
	        }
	        $sheet->setCellValueByColumnAndRow(12, 6, $country);
	        $sheet->setCellValueByColumnAndRow(16, 4, $countDays);

	        //Количество пользователей
	        $sheet->setCellValueByColumnAndRow(9, 6, $insurer_peoples_count);


//	        $sheet->setCellValueByColumnAndRow(10, 9, $rate_price);
//	        $sheet->setCellValueByColumnAndRow(15, 16, $rate_price);
            //Итоговая цена с учетом всех застрахованых особ
	        $sheet->setCellValueByColumnAndRow(15, 16, $total_rate_price);

//                echo '$total_rate_price = ' . $total_rate_price;
	        $sheet->setCellValueByColumnAndRow(15, 21, $date);
	        $sheet->setCellValueByColumnAndRow(13, 4, $dateFrom);
	        $sheet->setCellValueByColumnAndRow(13, 5, $dateTo);
	        $sheet->setCellValueByColumnAndRow(9, 9, $franchise);
	        $sheet->setCellValueByColumnAndRow(8, 9, $explodeSumInsured[0]);
        }
        else if($companyId == 3){
		    $spreadsheet = $reader->load("usi.xlsx");
		    $sheet       = $spreadsheet->getActiveSheet();

		    $sheet->setCellValueByColumnAndRow(1, 13, $firstName.' '.$name);
		    $sheet->setCellValueByColumnAndRow(39, 13, $passport);
		    $sheet->setCellValueByColumnAndRow(50, 13, $birthday);
	        if(strlen($phone) > 0) {
		        $sheet->setCellValueByColumnAndRow( 1, 19, $address . ", " . $phone );
	        }
	        else {
		        $sheet->setCellValueByColumnAndRow( 1, 19, $address );
	        }
		    $sheet->setCellValueByColumnAndRow(79, 11, $country);
		    $sheet->setCellValueByColumnAndRow(79, 19, $countDays);
		    $sheet->setCellValueByColumnAndRow(62, 50, $rate_price);
		    $sheet->setCellValueByColumnAndRow(17, 58, $rate_price." грн");
		    $sheet->setCellValueByColumnAndRow(79, 54, $date);
		    $sheet->setCellValueByColumnAndRow(102, 54, $date);
		    $sheet->setCellValueByColumnAndRow(79, 15, $dateFrom);
		    $sheet->setCellValueByColumnAndRow(93, 15, $dateTo);
		    $sheet->setCellValueByColumnAndRow(54, 50, $franchise);
		    $sheet->setCellValueByColumnAndRow(17, 50, $sumInsured);
	    }
        else {
	        wp_die( "Файл для формування бланку не знайдено", "Помилка формування бланку" );
        }



        $writer  = new Xlsx( $spreadsheet );
        $xlsName = "report.xlsx";
        header( 'Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' );
        header( 'Content-Disposition: attachment;filename="' . $xlsName . '"' );
        header( 'Cache-Control: max-age=0' );
        $writer->save( 'php://output' );

    }
    else{
	    wp_die( "Замовлення не знайдено", "Помилка формування бланку" );
    }


}
else{
	wp_die( "Ключ не знайдено або він не вірний.", "Помилка формування бланку" );
}