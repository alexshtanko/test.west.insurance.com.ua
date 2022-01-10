<?php
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);

require_once $_SERVER['DOCUMENT_ROOT'].'/vendor/autoload.php';

require_once $_SERVER['DOCUMENT_ROOT'].'/wp-content/plugins/insurance/admin/include/class-insurance-admin-help.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Writer\Pdf\Mpdf;
use PhpOffice\PhpSpreadsheet\Style\Border;

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
	echo "Не вірний запит.";
	exit;
}

require_once( $_SERVER['DOCUMENT_ROOT'].'/wp-load.php' );
global $wpdb;
$table_name = $wpdb->prefix . "insurance_orders";
$table_statuses_name = $wpdb->prefix . "insurance_statuses";
$current_user = wp_get_current_user();

$statuses = $wpdb->get_results( "SELECT id, text FROM " . $table_statuses_name . " WHERE status = 1;", ARRAY_A);

$allStatuses = [];
foreach($statuses as $tmp){
	$allStatuses[$tmp["id"]] = $tmp["text"];
}

// МЕНЕДЖЕРЫ
$admin = false;
$manager = false;
if( $current_user->ID ) {
	$user       = new WP_User( $current_user->ID );
	$user_roles = $user->roles;

	if (in_array( 'administrator', $user_roles, true ) ) {
		$admin = true;
	}

	if (in_array( 'user_manager', $user_roles, true ) ) {
		$manager = true;
	}
}
else {
	echo "У даного користувача немає прав.";
	exit;
}

if($admin || $manager) {
	//$format = "pdf";
	$format = "xlsx";

//	$_POST["dateFrom"]  = "2021-01-01"; //"2020-09-03";
//	$_POST["dateTo"]    = "2021-01-30"; //"2020-10-16";
//	$_POST["managerId"] = ""; //"29";
//	$_POST["referals"]  = "1";
//	$_POST["companyId"] = "";//"1"; //"177";
//	$_POST["programId"] = "";

	if($admin) {
		if ( $_POST["managerId"] ) {
			if ( array_key_exists( "referals", $_POST ) ) {
				$managers       = getAllReferals( [ intval( $_POST["managerId"] ) ] );
				$searchManagers = count( $managers ) > 1 ? implode( ", ", $managers ) : $managers[0];
			} else {
				$searchManagers = $_POST["managerId"];
			}
		}
		$managerId = $_POST["managerId"] ? "E.`user_id` in (" . $searchManagers . ")" : "";
	}

	if($manager) {
		if ( array_key_exists( "referals", $_POST ) ) {
			$managers       = getAllReferals( [ intval( $current_user->ID ) ] );
			$searchManagers = count( $managers ) > 1 ? implode( ", ", $managers ) : $managers[0];
		} else {
			$searchManagers = $current_user->ID;
		}

		$managerId = "E.`user_id` in (" . $searchManagers . ")";
	}

	$dateFrom  = isset($_POST["dateFrom"]) && validateDate($_POST["dateFrom"]) ? "E.`date_added` >= '" . $_POST["dateFrom"] . " 00:00:00'" : "";
	$dateTo    = isset($_POST["dateTo"]) && validateDate($_POST["dateTo"]) ? "E.`date_added` <= '" . $_POST["dateTo"] . " 23:59:59'" : "";
	$blank_type_id = $_POST["blank_type_id"];

	$companyId = $_POST["companyId"] ? "E.`company_id` = " . intval($_POST["companyId"]) : "";
	$programId = $_POST["programId"] ? "E.`program_id` = " . intval($_POST["programId"]) : "";
	$arrayValues = [$dateFrom, $dateTo, $managerId, $companyId, $programId];
	$arrayValues = array_diff($arrayValues, array(''));
	$query = implode(" AND ", $arrayValues);
	//Типы бланков 
	// 1 - "Паперовий"
	// 2 - "Електронний"
	if( $blank_type_id == 1 || $blank_type_id == 2 ){
		$query .= ' AND blank_type_id = ' . $blank_type_id;
	}

	$blank_types_data = $wpdb->get_results( "SELECT id, text FROM `plc_insurance_blank_type` WHERE `status` = 1", ARRAY_A);
	

	$data = $wpdb->get_results( "SELECT * FROM " . $table_name . " as E WHERE ".$query." AND `status` IN (SELECT id FROM ".$table_statuses_name." WHERE status = 1 AND managerReport = 1) ORDER BY E.`id` DESC", ARRAY_A );
	$data = array_map('wp_unslash', $data);

	$reader = IOFactory::createReader("Xlsx");
	$spreadsheet = $reader->load("manager.xlsx");
	$sheet       = $spreadsheet->getActiveSheet();

	$excelData = array();
	if ( count( $data ) > 0 ) {
		$i = 1;
		foreach ( $data as $row ) {
			$orderStatus = mb_strtoupper($allStatuses[$row["status"]]);
			if($row['status'] == 1) {
				$blankNumber      = $row['blank_number'];
				$blankSeries      = $row['blank_series'];
				$dateAdded        = date( "d.m.Y", strtotime( $row['date_added'] ) );
				$dateFrom         = date( "d.m.Y", strtotime( $row['date_from'] ) );
				$dateTo           = date( "d.m.Y", strtotime( $row['date_to'] ) );
				$name             = $row['name'];
				$lastName         = $row['last_name'];
				$ratePrice        = (float) $row['rate_price'];
				$rate_coefficient = (float) $row['rate_coefficient'];
				$ratePrice        = $ratePrice * $rate_coefficient;
				$ratePrice        = round( $ratePrice, 2 );
				$order_blank_type_id = (int) $row['blank_type_id'];

				$cashback         = (float) $row['cashback'];
				$summCashback     = $cashback ? round( ( $ratePrice / 100 ) * $cashback, 2 ) : "";
				$user             = get_user_by( 'id', $row['user_id'] ); //$user->data->display_name
				$companyTitle     = $row['company_title'];
				$programTitle     = $row['program_title'];



                /*
                 * Расчет стоимости в зависимости от компании, наценок, количеста застрахованых пользователей
                 *
                 * */
                $order_id = $row['id'];
                $companyId = $row['company_id'];
                $rate_price = $row['rate_price'];

                $insurer_status = $row['insurer_status'];

                $insurance = new Insurance_Class();

                $insurers = $insurance->get_insurers( $order_id );

                $insurer_peoples_count = 0;
                //Финальная стоимость страховки
                $ratePrice = 0;



				$insurer_status = (int)$row['insurer_status'];

				$insurer_price = 0;

				$total_insurer_rate_price = 0;

				$insurer_price_data = new Insurance_Admin_Help();

				if( $insurer_status ){

					$insurer_price = $insurer_price_data->company_price_coeficient( $row['company_id'], $row['rate_price'], $row['rate_coefficient'], $row['rate_price_coefficient'] );
					$total_insurer_rate_price = $insurer_price;

					if( $insurers ) {

						foreach ($insurers as $insurer) {

							//расчет цены в зависимости от возрастного коеффициента
							$insurer_age_coefficient = $insurer['coefficient'];

							$total_insurer_rate_price += $insurer_price_data->company_price_coeficient( $row['company_id'], $row['rate_price'], $insurer_age_coefficient, $row['rate_price_coefficient'] );

						}
					}

				}
				else{

					if( $insurers ) {

						foreach ($insurers as $insurer) {

							//расчет цены в зависимости от возрастного коеффициента
							$insurer_age_coefficient = $insurer['coefficient'];

							$total_insurer_rate_price += $insurer_price_data->company_price_coeficient( $row['company_id'], $row['rate_price'], $insurer_age_coefficient, $row['rate_price_coefficient'] );

						}
					}


				}
				/*Конец расчета по коеффициентам*/

			}
			else {
				$blankNumber      = $row['blank_number'];
				$blankSeries      = $row['blank_series'];
				$dateAdded        = date( "d.m.Y", strtotime( $row['date_added'] ) );
				$dateFrom = $dateTo = $name = $lastName = $ratePrice = $rate_coefficient = $ratePrice = $cashback = $summCashback = "";
				$user             = get_user_by( 'id', $row['user_id'] ); //$user->data->display_name
				$companyTitle     = $row['company_title'];
				$programTitle     = $row['program_title'];
			}

			foreach( $blank_types_data as $blank_type_data ){
				if( $blank_type_data['id'] == $order_blank_type_id ){
					$blank_type_text = $blank_type_data['text'];
				}
			}

			$ratePrice = $total_insurer_rate_price;
			$excelData[] = array($i, $blankSeries.$blankNumber, $dateAdded, $dateFrom, $dateTo, $lastName." ".$name, $ratePrice, $cashback, $summCashback, $user->data->display_name, $companyTitle, $programTitle, $blank_type_text, $orderStatus);
			$i++;
		}
	}

	if(count($excelData) > 0) {
		// EXCEL HEADER
		$printDateFrom = $_POST['dateFrom'] ? "з " . date( "d.m.Y", strtotime( $_POST['dateFrom'] ) ) . " " : "";
		$printDateTo   = $_POST['dateTo'] ? date( "d.m.Y", strtotime( $_POST['dateTo'] ) ) : date( "d.m.Y" );

		$sheet->fromArray( [ "в період " . $printDateFrom . "по " . $printDateTo ], null, 'A3' );
		// /EXCEL HEADER

		$generateRowsStart = 8;
		$sheet->fromArray( $excelData, null, 'A' . $generateRowsStart );

		$styleArray = [
			'borders' => [
				'allBorders' => [
					'borderStyle' => Border::BORDER_THIN,
					'color'       => [ 'rgb' => '333333' ],
				]
			],
			'font'    => [
				'size' => 8,
				'name' => 'Arial'
			]
		];

		$sheet->getStyle( 'A' . $generateRowsStart . ':N' . ( $generateRowsStart + $i - 2 ) )->applyFromArray( $styleArray );

		$sheet->mergeCells( 'B' . ( $generateRowsStart + $i + 2 ) . ':E' . ( $generateRowsStart + $i + 2 ) );
		$sheet->fromArray( [ "Довіритель" ], null, 'B' . ( $generateRowsStart + $i + 2 ) );
		$sheet->getStyle( 'B' . ( $generateRowsStart + $i + 2 ) )->getAlignment()->setHorizontal( 'center' )->setVertical( 'center' );
		$sheet->getStyle( 'B' . ( $generateRowsStart + $i + 2 ) )->getFont()->setBold( true );

		$sheet->mergeCells( 'B' . ( $generateRowsStart + $i + 4 ) . ':E' . ( $generateRowsStart + $i + 4 ) );
		$sheet->fromArray( [ "_____________________(_______________)" ], null, 'B' . ( $generateRowsStart + $i + 4 ) );
		$sheet->getStyle( 'B' . ( $generateRowsStart + $i + 4 ) )->getAlignment()->setHorizontal( 'right' )->setVertical( 'center' );

		$sheet->fromArray( [ "Повірений" ], null, 'F' . ( $generateRowsStart + $i + 2 ) );
		$sheet->getStyle( 'F' . ( $generateRowsStart + $i + 2 ) )->getAlignment()->setHorizontal( 'center' )->setVertical( 'center' );
		$sheet->getStyle( 'F' . ( $generateRowsStart + $i + 2 ) )->getFont()->setBold( true );

		$sheet->fromArray( [ "_____________________(_______________)" ], null, 'F' . ( $generateRowsStart + $i + 4 ) );
		$sheet->getStyle( 'F' . ( $generateRowsStart + $i + 4 ) )->getAlignment()->setHorizontal( 'right' )->setVertical( 'center' );

		$sheet->getStyle( 'A' . ( $generateRowsStart + $i - 1 ) . ":G" . ( $generateRowsStart + $i - 1 ) )->applyFromArray( $styleArray );
		$sheet->getStyle( 'A' . ( $generateRowsStart + $i - 1 ) . ":G" . ( $generateRowsStart + $i - 1 ) )->getFont()->setBold( true );
		$sheet->getStyle( 'A' . ( $generateRowsStart + $i - 1 ) . ":G" . ( $generateRowsStart + $i - 1 ) )->getAlignment()->setHorizontal( 'center' )->setVertical( 'center' );
		$sheet->mergeCells( 'A' . ( $generateRowsStart + $i - 1 ) . ':F' . ( $generateRowsStart + $i - 1 ) );
		$sheet->fromArray( [ "Всього" ], null, 'A' . ( $generateRowsStart + $i - 1 ) );
		$sheet->setCellValue( 'G' . ( $generateRowsStart + $i - 1 ), '=SUM(G' . $generateRowsStart . ':G' . ( $generateRowsStart + $i - 2 ) . ')' );

		$sheet->getStyle( 'I' . ( $generateRowsStart + $i - 1 ) . ":I" . ( $generateRowsStart + $i - 1 ) )->applyFromArray( $styleArray );
		$sheet->getStyle( 'I' . ( $generateRowsStart + $i - 1 ) . ":I" . ( $generateRowsStart + $i - 1 ) )->getFont()->setBold( true );
		$sheet->getStyle( 'I' . ( $generateRowsStart + $i - 1 ) . ":I" . ( $generateRowsStart + $i - 1 ) )->getAlignment()->setHorizontal( 'center' )->setVertical( 'center' );
		$sheet->setCellValue( 'I' . ( $generateRowsStart + $i - 1 ), '=SUM(I' . $generateRowsStart . ':I' . ( $generateRowsStart + $i - 2 ) . ')' );

		if ( $format == "xlsx" ) {
			$writer  = new Xlsx( $spreadsheet );
			$xlsName = "report.xlsx";
			header( 'Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' );
			header( 'Content-Disposition: attachment;filename="' . $xlsName . '"' );
			header( 'Cache-Control: max-age=0' );
			$writer->save( 'php://output' );
		}

		if ( $format == "pdf" ) {
			$writer  = new Mpdf( $spreadsheet );
			$pdfName = "report.pdf";
			header( "Content-type:application/pdf" );
			header( 'Content-Disposition: attachment;filename="' . $pdfName . '"' );
			header( 'Cache-Control: max-age=0' );
			$writer->save( 'php://output' );
		}
	}
	else {
		echo "Договори за вказаними критеріям не знайдено.";
	}
}