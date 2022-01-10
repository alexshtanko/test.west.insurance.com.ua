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

    $status = $insurance->export_excell( $order_id );

	// var_dump($status);

    if( $status ){

        $order = $insurance->get_order( $order_id );
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

		//20.04.2021
        //Страховальники
		$insurer_status = $order['insurer_status'];
		$insurers = $insurance->get_insurers( $order_id );


		
		//price * coefficient
		$rate_coefficient = $order['rate_coefficient'];
		$rate_price = $rate_price * $rate_coefficient;
		$rate_price = round( $rate_price, 2 );

        $explodeDateFrom = explode(".", $dateFrom);
        $explodeDateTo = explode(".", $dateTo);
        $explodeFranchise = explode(" ", $franchise);
        $explodeSumInsured = explode(" ", $sumInsured);


        $tariff = 1100/($explodeSumInsured[0]*30)*100;

        $reader = IOFactory::createReader("Xlsx");

        if($companyId == 2) {
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
	        $sheet->setCellValueByColumnAndRow( 4, 6, $passport );
	        $sheet->setCellValueByColumnAndRow( 10, 6, $birthday );
	        $sheet->setCellValueByColumnAndRow( 6, 8, $address );
	        $sheet->setCellValueByColumnAndRow( 14, 6, $phone );
	        $sheet->setCellValueByColumnAndRow( 11, 9, $country );
	        $sheet->setCellValueByColumnAndRow( 16, 5, $countDays );
	        $sheet->setCellValueByColumnAndRow( 16, 10, $sumInsured );
	        $sheet->setCellValueByColumnAndRow( 20, 16, $date );
	        // $sheet->setCellValueByColumnAndRow(19, 11, $tariff);
	        $sheet->setCellValueByColumnAndRow( 26, 8, $rate_price );
	        $sheet->setCellValueByColumnAndRow( 19, 12, $rate_price );

	        $sheet->setCellValueByColumnAndRow( 26, 16, $explodeFranchise[0] );
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
			        break;
		        case "3":
			        $spreadsheet = $reader->load( "providna_bezviz.xlsx" );
			        break;
		        case "4":
			        $spreadsheet = $reader->load( "providna_chekhiya.xlsx" );
			        break;
		        default:
			        $spreadsheet = false;
	        }

	        if(!$spreadsheet) wp_die( "Файл для формування бланку не знайдено", "Помилка формування бланку" );

	        $sheet       = $spreadsheet->getActiveSheet();
	        $sheet->setCellValueByColumnAndRow(3, 4, $firstName.' '.$name);
	        $sheet->setCellValueByColumnAndRow(3, 5, $passport);
	        $sheet->setCellValueByColumnAndRow(9, 5, $birthday);
	        if(strlen($phone) > 0) {
		        $sheet->setCellValueByColumnAndRow( 3, 6, $address . ", " . $phone );
	        }
	        else {
		        $sheet->setCellValueByColumnAndRow( 3, 6, $address );
	        }
	        $sheet->setCellValueByColumnAndRow(12, 6, $country);
	        $sheet->setCellValueByColumnAndRow(16, 4, $countDays);
	        $sheet->setCellValueByColumnAndRow(10, 9, $rate_price);
	        $sheet->setCellValueByColumnAndRow(15, 16, $rate_price);
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