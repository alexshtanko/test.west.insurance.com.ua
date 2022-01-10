<?php
require($_SERVER['DOCUMENT_ROOT'].'/wp-load.php');

$key = 'TdHjjZycfXfqRF7Ydao4';

require_once $_SERVER['DOCUMENT_ROOT'].'vendor/autoload.php';

require_once $_SERVER['DOCUMENT_ROOT'].'wp-content/wp-recall/add-on/covid/class/covid.php';

use PhpOffice\PhpWord\TemplateProcessor;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\Settings;

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

	if( $companyId == 1 || $companyId == 3)
	{
		$templateProcessor = new TemplateProcessor("3_etalon/template.docx");

		$templateProcessor->setValue('orderNumber', $blank_number_print);
		$templateProcessor->setValue('orderDate', $date);

		$templateProcessor->setValue('fio', $fio);
		$templateProcessor->setValue('inn', "");
		$templateProcessor->setValue('birthday', $birthday);
		$templateProcessor->setValue('phone', $phone);
		$templateProcessor->setValue('email', $email);
		$templateProcessor->setValue('adress', $address);
		$templateProcessor->setValue('passport', $passport);

		$templateProcessor->setValue('dateFrom', $dateFrom);
		$templateProcessor->setValue('dateTo', $dateTo);
		$templateProcessor->setValue('sumInsured', $sumInsured);
		$templateProcessor->setValue('insuranceRate', $insure_tarif);

		$templateProcessor->setValue('insurancePayment', $total_rate_price);
		$templateProcessor->setValue('totalPrice', $total_rate_price);



		$templateProcessor->setValue('insFio_1', $i_fio);
		$templateProcessor->setValue('insB_1', $i_birthday);
		$templateProcessor->setValue('insAdress_1', $i_address.", ".$i_passport);

		for($m = 2; $m <=5; $m++){
			$templateProcessor->setValue('insFio_'.$m, "");
			$templateProcessor->setValue('insB_'.$m, "");
			$templateProcessor->setValue('insAdress_'.$m, "");
		}

		header( 'Content-type:application/msword');
		header('Content-Disposition: attachment; filename="report.docx"');
		header( 'Cache-Control: max-age=0' );
		$templateProcessor->saveAs('php://output');

		exit;
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