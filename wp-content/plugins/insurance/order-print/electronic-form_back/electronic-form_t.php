<?php

require($_SERVER['DOCUMENT_ROOT'].'/wp-load.php');

$key = 'kDCRa89dc0e1';

require_once $_SERVER['DOCUMENT_ROOT'].'vendor/autoload.php';

require_once $_SERVER['DOCUMENT_ROOT'].'wp-content/wp-recall/add-on/insurance/class/insurance.php';

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$order_id = $_GET['order_id'];
$key = $_GET['key'];
$secure_key = 'WPbm49ebf124';

//Check key to run the script
if ( $key == $_GET['key'] ) {
	$insurance = new Insurance_Class();

	$status = $insurance->export_excell( $order_id );
	$user = wp_get_current_user();

	if( $status || $user->ID == 1 ) {
		$order_id = $_GET['order_id'];

		$order_data = new Insurance_Class();

		$order = $order_data->get_order( $order_id );

		$rows = '';
		$programId = $order['program_id'];
		$companyId = $order['company_id'];

		$name             = $order['name'];
		$last_name        = $order['last_name'];
		$passport         = $order['passport'];
		$birthday         = date( 'd.m.Y', strtotime( $order['birthday'] ) );
		$address          = $order['address'];
		$country          = $order['rate_locations'];
		$phone            = $order['phone_number'];
		$count_days       = $order['count_days'];
		$dateFrom         = date( 'd.m.Y', strtotime( $order['date_from'] ) );
		$dateTo           = date( 'd.m.Y', strtotime( $order['date_to'] ) );
		$sumInsured       = $order['rate_insured_sum'];
		$date             = date( 'd.m.Y', strtotime( $order['date_added'] ) );
		$franchise        = $order['rate_franchise'];
		$rate_price       = $order['rate_price'];
		$rate_insured_sum = $order['rate_insured_sum'];
		$rate_locations   = $order['rate_locations'];
		$blank_number     = $order['blank_number'];
		$blank_series     = $order['blank_series'];

		$blank_number_print = $blank_series . ' ' . $blank_number;


		//Финальная стоимость страховки
		$total_rate_price = 0;

		$insurer_status = $order['insurer_status'];
		$insurers       = $insurance->get_insurers( $order_id );

		$insurer_peoples_count = 0;


		$explodeDateFrom   = explode( ".", $dateFrom );
		$explodeDateTo     = explode( ".", $dateTo );
		$explodeFranchise  = explode( " ", $franchise );
		$explodeSumInsured = explode( " ", $sumInsured );


		$tariff = 1100 / ( $explodeSumInsured[0] * 30 ) * 100;

		$reader = IOFactory::createReader( "Xlsx" );

	    if($companyId == 5 || $companyId == 1) {
			$spreadsheet = $reader->load( "inter_plus/inter_plus.xlsx" );

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

			$sheet->setCellValueByColumnAndRow( 4, 7, $last_name . ' ' . $name );
			$sheet->setCellValueByColumnAndRow( 14, 8, $order['passport'] );
			$sheet->setCellValueByColumnAndRow( 4, 9, $birthday );
			$sheet->setCellValueByColumnAndRow( 4,  10, $order['address'] );
			$sheet->setCellValueByColumnAndRow( 4, 11, $order['phone_number'] );

			$sheet->setCellValueByColumnAndRow( 4, 12, $explodeSumInsured[0]);
			$sheet->setCellValueByColumnAndRow( 5, 12, $explodeSumInsured[1]);

			$sheet->setCellValueByColumnAndRow( 4, 16, $order['rate_locations'] );

			$sheet->setCellValueByColumnAndRow( 4, 21, "франшиза ".$franchise." Cover Covid-19" );

			// Дальше таблица с перечнем людей
			$sheet->setCellValueByColumnAndRow( 4, 29, $last_name . ' ' . $name );
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
				$sheet->setCellValueByColumnAndRow( 4, $peoplesTable, $last_name . ' ' . $name );
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

			// Nova Assistance
			$novaAssistance = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
			$novaAssistance->setName('Nova Assistance');
			$novaAssistance->setDescription('Nova Assistance');
			$novaAssistance->setPath('inter_plus/nova_assistance.png'); // put your path and image here
			$novaAssistance->setWidth(210);
			$novaAssistance->setCoordinates("A3");
			$novaAssistance->setOffsetX(15);
			$novaAssistance->setOffsetY(12);
			$novaAssistance->setWorksheet($spreadsheet->getActiveSheet());
			// / Nova Assistance

			// Inter Plus Logo
		    $interPlusLogo = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
		    $interPlusLogo->setName('Inter Plus');
		    $interPlusLogo->setDescription('Inter Plus');
		    $interPlusLogo->setPath('inter_plus/inter_plus_logo.png'); // put your path and image here
		    $interPlusLogo->setWidth(180);
		    $interPlusLogo->setCoordinates("AV3");
		    $interPlusLogo->setOffsetX(8);
		    $interPlusLogo->setOffsetY(3);
		    $interPlusLogo->setWorksheet($spreadsheet->getActiveSheet());
		    // / Inter Plus Logo

		    // Stamp
		    $stamp = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
		    $stamp->setName('Stamp');
		    $stamp->setDescription('Stamp');
		    $stamp->setPath('inter_plus/stamp.png'); // put your path and image here
		    $stamp->setWidth(170);
		    $stamp->setCoordinates("AC17");
		    $stamp->setOffsetX(52);
		    $stamp->setOffsetY(3);
		    $stamp->setWorksheet($spreadsheet->getActiveSheet());
		    // / Stamp

		    // Sign
		    $sign = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
		    $sign->setName('Sign');
		    $sign->setDescription('Sign');
		    $sign->setPath('inter_plus/sign.png'); // put your path and image here
		    $sign->setWidth(98);
		    $sign->setCoordinates("AB24");
		    $sign->setOffsetX(0);
		    $sign->setOffsetY(0);
		    $sign->setWorksheet($spreadsheet->getActiveSheet());
		    // / Sign


		    $writer  = new Xlsx( $spreadsheet );
		    $xlsName = "report.xlsx";
		    header( 'Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' );
		    header( 'Content-Disposition: attachment;filename="' . $xlsName . '"' );
		    header( 'Cache-Control: max-age=0' );
		    $writer->save( 'php://output' );
		}
	}
}
else{
    echo 'error';
}