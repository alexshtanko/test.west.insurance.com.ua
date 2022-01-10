<?php

include_once '../class/insurance.php';

require($_SERVER['DOCUMENT_ROOT'].'/wp-load.php');

require ABSPATH . '/vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$order_id = $_GET['order_id'];

$key = $_GET['key'];

$secure_key = 'WPbm49ebf124';

if ( ! empty( $order_id ) && $key == $secure_key ){

    $insurance = new Insurance_Class();

    $status = $insurance->export_excell( $order_id );

    if( $status ){

        $order = $insurance->get_order( $order_id );
        
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

        $explodeDateFrom = explode(".", $dateFrom);
        $explodeDateTo = explode(".", $dateTo);
        $explodeFranchise = explode(" ", $franchise);
        $explodeSumInsured = explode(" ", $sumInsured);

        $tariff = 1100/($explodeSumInsured[0]*30)*100;

        $reader = IOFactory::createReader("Xlsx");
        $spreadsheet = $reader->load("template_usi.xlsx");
        $sheet       = $spreadsheet->getActiveSheet();
        $sheet->setCellValueByColumnAndRow(6, 3, $firstName.' '.$name);
        $sheet->setCellValueByColumnAndRow(4, 5, $passport);
        $sheet->setCellValueByColumnAndRow(10, 5, $birthday);
        $sheet->setCellValueByColumnAndRow(6, 7, $address);
        $sheet->setCellValueByColumnAndRow(14, 5, $phone);
        $sheet->setCellValueByColumnAndRow(11, 8, $country);
        $sheet->setCellValueByColumnAndRow(16, 4, $countDays);
        $sheet->setCellValueByColumnAndRow(16, 9, $sumInsured);
        $sheet->setCellValueByColumnAndRow(20, 15, $date);
        $sheet->setCellValueByColumnAndRow(19, 11, $tariff);
        $sheet->setCellValueByColumnAndRow(26, 15, $explodeFranchise[0]);
        $sheet->setCellValueByColumnAndRow(27, 15, $explodeFranchise[1]);

        $sheet->setCellValueByColumnAndRow(20, 2, $explodeDateFrom[0]);
        $sheet->setCellValueByColumnAndRow(21, 2, $explodeDateFrom[1]);
        $sheet->setCellValueByColumnAndRow(22, 2, $explodeDateFrom[2]);

        $sheet->setCellValueByColumnAndRow(25, 2, $explodeDateTo[0]);
        $sheet->setCellValueByColumnAndRow(26, 2, $explodeDateTo[1]);
        $sheet->setCellValueByColumnAndRow(27, 2, $explodeDateTo[2]);

        $writer  = new Xlsx( $spreadsheet );
        $xlsName = "report.xlsx";
        header( 'Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' );
        header( 'Content-Disposition: attachment;filename="' . $xlsName . '"' );
        header( 'Cache-Control: max-age=0' );
        $writer->save( 'php://output' );

    }
    else{

    }

}