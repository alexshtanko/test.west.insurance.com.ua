<?php
require($_SERVER['DOCUMENT_ROOT'].'/wp-load.php');

$key = 'TdHjjZycfXfqRF7Ydao4';

require_once $_SERVER['DOCUMENT_ROOT'].'vendor/autoload.php';

require_once $_SERVER['DOCUMENT_ROOT'].'wp-content/wp-recall/add-on/covid/class/covid.php';

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

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
	$insurerText = "";

	if( ! $insurer_status )
	{
		$insurers = $order_data->get_covid_insurers( $order_id );
		$insurerText = "Не є Застрахованою особою / Non insured";

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

		$insurerText = "Є Застрахованою особою / Is insuard";
	}


	$insure_tarif = explode( ' ', $rate_insured_sum );
	$insure_tarif = ( $total_rate_price / $insure_tarif[0] ) * 100;


	$insurer_peoples_count = 0;

	if( $companyId == 1 || $companyId == 2)
	{
		$reader = IOFactory::createReader("Xlsx");
		$spreadsheet = $reader->load( "2_ucc/template.xlsx" );

		if(!$spreadsheet) wp_die( "Файл для формування бланку не знайдено", "Помилка формування бланку" );
		$sheet       = $spreadsheet->getActiveSheet();

		$sheet->setCellValueByColumnAndRow( 4, 2, "№ ".$blank_number_print );
		$sheet->setCellValueByColumnAndRow( 3, 4, $count_days );
		$sheet->setCellValueByColumnAndRow( 7, 4, explode(" ", $franchise)[0] );
		$sheet->setCellValueByColumnAndRow( 8, 4, explode(" ", $franchise)[1] );

		$sheet->setCellValueByColumnAndRow( 4, 6, $dateFrom );
		$sheet->setCellValueByColumnAndRow( 6, 6, $dateTo );

		$sheet->setCellValueByColumnAndRow( 11, 8, explode(" ", $rate_insured_sum)[0] );
		$sheet->setCellValueByColumnAndRow( 13, 8, explode(" ", $rate_insured_sum)[1] );

		$sheet->setCellValueByColumnAndRow( 5, 10, $address );

		$sheet->setCellValueByColumnAndRow( 3, 12, $insurerText );

		$sheet->setCellValueByColumnAndRow( 2, 14, $last_name . ' ' . $name );
		$sheet->setCellValueByColumnAndRow( 5, 14, $passport );
		$sheet->setCellValueByColumnAndRow( 6, 14, $birthday );

		$sheet->setCellValueByColumnAndRow( 11, 14, $total_rate_price );

		if( ! $insurer_status )
		{
			$sheet->setCellValueByColumnAndRow( 11, 14, 0 );

			$sheet->setCellValueByColumnAndRow( 3, 16, $i_fio );
			$sheet->setCellValueByColumnAndRow( 5, 16, $i_passport );
			$sheet->setCellValueByColumnAndRow( 6, 16, $i_birthday );
			$sheet->setCellValueByColumnAndRow( 11, 16, $total_rate_price );
		}

		$sheet->setCellValueByColumnAndRow( 11, 20, $total_rate_price." UAH" );
		$sheet->setCellValueByColumnAndRow( 12, 25, $date );

		// Stamp
		$stamp = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
		$stamp->setName('Stamp');
		$stamp->setDescription('Stamp');
		$stamp->setPath('2_ucc/stamp.png'); // put your path and image here
		$stamp->setWidth(130);
		$stamp->setCoordinates("J23");
		$stamp->setOffsetX(65);
		$stamp->setOffsetY(10);
		$stamp->setWorksheet($spreadsheet->getActiveSheet());
		// / Stamp

		// Sign
		$sign = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
		$sign->setName('Sign');
		$sign->setDescription('Sign');
		$sign->setPath('2_ucc/sign.png'); // put your path and image here
		$sign->setWidth(105);
		$sign->setCoordinates("J24");
		$sign->setOffsetX(60);
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
	else
	{
		echo 'Не знайдено форми для друку договору';

		wp_die();
	}

}
else{
	echo 'error';
}