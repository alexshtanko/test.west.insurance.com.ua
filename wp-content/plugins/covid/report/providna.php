<?php
// require '../vendor/autoload.php';

require($_SERVER['DOCUMENT_ROOT'].'/wp-load.php');

$key = 'kDCRa89dc8e2';
require ABSPATH . '/vendor/autoload.php';


use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PHPMailer\PHPMailer\PHPMailer;


//Check key to run the script
if ( $key == $_GET['key'] ){
	global $wpdb;
	$table_name = $wpdb->get_blog_prefix() . 'insurance_orders';
	$onlyProvidna = ' AND company_id = 1 ';
	$onlyComment = " AND number_blank_comment LIKE '%Київ%' ";

	$data = $wpdb->get_results( "SELECT name, last_name as firstName, birthday,
(
(YEAR(CURRENT_DATE) - YEAR(birthday)) -                             /* step 1 */
(DATE_FORMAT(CURRENT_DATE, '%m%d') < DATE_FORMAT(birthday, '%m%d')) /* step 2 */
) AS years, passport, address, CONCAT( `blank_series`, `blank_number` ) as contractNumber, company_title, date_from as dateFrom, date_to as dateTo, count_days as countDays, rate_locations as country, rate_insured_sum as sumInsured, rate_price as insuranceRate, rate_franchise as franchise, rate_coefficient, date_added, program_title FROM " . $table_name . " WHERE date_added >= CURRENT_DATE() AND status = 1 ".$onlyProvidna.$onlyComment." ORDER BY id DESC;", ARRAY_A );

	// $data = [
	// 	["OLENA", "LIUBIMOVA", "24.05.1963", "57", "EP064656", "KIROVOHRADSKA OBL.", "ВЗК810251", "13.12.2020", "25.12.2021", "377", "Poland", "30000 EUR", "600", "50 EUR"],
	// 	["KIRIL", "IVANOV", "24.05.1973", "34", "EP0642434", "KIEVSKA OBL.", "ВЗК810333", "18.11.2020", "17.11.2021", "365", "Europe", "20000 EUR", "750", "100 EUR"],
	// ];
	// $company_title = 'Test title';
	$excelData = [];
	$counter= 1;
	foreach($data as $row){
		if(count($row) == 18) {
			extract( $row );

			//Price * coefficient
			$insuranceRate = $insuranceRate * $rate_coefficient;
			$insuranceRate = round( $insuranceRate, 2 );
			// list( $name, $firstName, $birthday, $years, $passport, $address, $contractNumber, $dateFrom, $dateTo, $countDays, $country, $sumInsured, $insuranceRate, $franchise ) = $row;
			$birthday = date( "d.m.Y", strtotime( $birthday ) );
			$dateFrom = date( "d.m.Y", strtotime( $dateFrom ) );
			$dateTo = date( "d.m.Y", strtotime( $dateTo ) );
			$date_added = date( "d.m.Y", strtotime( $date_added ) );

			$excelData[] = [$counter,
				$company_title,
				$contractNumber,
				$date_added,
				$firstName." ".$name,
				$passport,
				$birthday,
				$address,
				$firstName." ".$name,
				$passport,
				$birthday,
				$years,
				$address,

				$sumInsured,
				$insuranceRate,
				$insuranceRate,
				"","0","0","","0","0",
				$franchise,
				$insuranceRate,
				"",
				$dateFrom,
				$dateTo,
				$countDays,
				$country,
				1,
				"Страховий туристичний Сервіс ПП",
				$program_title
			];
			$counter += 1;
		}
	}

	$orders_count = count( $excelData );

	if(count($excelData) > 0){
		$reader = IOFactory::createReader("Xlsx");
		$spreadsheet = $reader->load("providna.xlsx");
		$sheet       = $spreadsheet->getActiveSheet();
		$sheet->fromArray( $excelData,null,'A3' );

		$format = "xlsx";
		$xlsName = "report.".$format;

		$file = WP_CONTENT_DIR . '/plugins/insurance/report/send/' . $xlsName;

		$writer  = new Xlsx( $spreadsheet );
		$writer->save($file);

		//sen email
		$subject = 'Медичне страхування (Щоденний звіт по заявкам).';
		$message = 'За сьогодні було додано медичних полісів - ' . $orders_count . '. </br>';

		//$site_email = 'kutsenko.a.v.1990@gmail.com';
		$site_email = get_option('admin_email');
		// $to = 'alexshtanko@gmail.com';
		// $to = 'kutsenko.a.v.1990@gmail.com';
		$to = array(
			//'kutsenko.a.v.1990@gmail.com',
			'n.erokhina@providna.com.ua',
			//get_option('admin_email'),
		);

		$headers = "From: " . $site_email . "\r\n";
		$headers .= "Reply-To: ". $site_email . "\r\n";
		$headers .= "MIME-Version: 1.0\r\n";
		$headers .= "Content-Type: text/html; charset=UTF-8\r\n";

		$header_ = 'MIME-Version: 1.0' . "\r\n" . 'Content-type: text/html; charset=UTF-8' . "\r\n";
		$status = wp_mail($to, '=?UTF-8?B?'.base64_encode($subject).'?=', $message, $header_ . $headers, $file);

		if( $status ){

			$table_name = $wpdb->get_blog_prefix() . 'insurance_cron_reports';

			$script_name = 'Медичне страхування';
			$comment = 'Сформовано та вiдправлено ' . $orders_count;

			$query = $wpdb->insert( $table_name, array( 'script_name' => $script_name, 'comment' => $comment ),
				array( '%s', '%s' ));
		}
		else {
			echo "Ошибка отправки письма!";
		}

		unlink($file);
	}
}