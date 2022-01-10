<?php
//ini_set('error_reporting', E_ALL);
require($_SERVER['DOCUMENT_ROOT'].'/wp-load.php');
$key = 'kDCRa89dc8e2';
require ABSPATH . '/vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Writer\Xls;

//Check key to run the script
if ( $key == $_GET['key'] ){

	global $wpdb;
	$table_name = $wpdb->get_blog_prefix() . 'insurance_orders';

	$selectedDate = "";
	$dateNow = date("d.m.Y");
	if($dateNow == "11.02.2021") {
		$selectedDate = "2021-02-08";
	}

	if($dateNow == "12.02.2021") {
		$selectedDate = "2021-02-09";
	}

	if($dateNow == "13.02.2021") {
		$selectedDate = "2021-02-10";
	}

	//Віза стандарні бланки
    // program_id = 1
	if($selectedDate == "") {
		$data = $wpdb->get_results( "SELECT name, last_name as firstName, birthday,
(
(YEAR(CURRENT_DATE) - YEAR(birthday)) -                             /* step 1 */
(DATE_FORMAT(CURRENT_DATE, '%m%d') < DATE_FORMAT(birthday, '%m%d')) /* step 2 */
) AS years, passport, address, blank_series, blank_number, company_title, date_from as dateFrom, date_to as dateTo, count_days as countDays, rate_locations as country, rate_insured_sum as sumInsured, rate_price as insuranceRate, rate_franchise as franchise, rate_coefficient, date_added, number_blank_comment FROM " . $table_name . " WHERE date_added >= CURRENT_DATE() AND status = 1 AND company_id = 2 AND program_id = 1 ORDER BY id DESC;", ARRAY_A );

	}
	else {
		// 547
		$data = $wpdb->get_results( "SELECT name, last_name as firstName, birthday,
(
(YEAR(CURRENT_DATE) - YEAR(birthday)) -                             /* step 1 */
(DATE_FORMAT(CURRENT_DATE, '%m%d') < DATE_FORMAT(birthday, '%m%d')) /* step 2 */
) AS years, passport, address, blank_series, blank_number, company_title, date_from as dateFrom, date_to as dateTo, count_days as countDays, rate_locations as country, rate_insured_sum as sumInsured, rate_price as insuranceRate, rate_franchise as franchise, rate_coefficient, date_added, number_blank_comment FROM " . $table_name . " WHERE date_added >= '".$selectedDate."' AND status = 1 AND company_id = 2 AND program_id = 1 AND id > 547 ORDER BY id DESC;", ARRAY_A );

	}

	$excelData = [];
	foreach($data as $row){
		if(count($row) == 19) {
			extract( $row );

			//Price * coefficient
			$insuranceRate = $insuranceRate * $rate_coefficient;
			$insuranceRate = round( $insuranceRate, 2 );
			$birthday = date( "d.m.Y", strtotime( $birthday ) );
			$dateFrom = date( "d.m.Y", strtotime( $dateFrom ) );
			$dateTo = date( "d.m.Y", strtotime( $dateTo ) );

			preg_match('/^([A-Za-z]+)([0-9]+)/', $passport, $maches);
			if(count($maches) == 4){
				$passport = $maches[1].' '.$maches[2];
			}
			else {
				preg_match('/^\D*(?=\d)/', $passport, $mach);
				$passport = substr($passport, 0, strlen($mach[0]))." ".substr($passport, strlen($mach[0]));
			}
			$passport = trim($passport);

			$date_payment = date( "d.m.Y", strtotime( '-1 day', strtotime($dateFrom )) );
			$dateFrom = date( "d.m.Y", strtotime( $dateFrom ) );

			$date_added = date( "d.m.Y", strtotime( $date_added ) );
			if($date_added == $dateFrom) $date_payment = $dateFrom;

			$excelData[] = [
				$blank_number,
				$blank_series,
				$date_added,
				'',
				$dateFrom,
				$dateTo,
				'',
				'',
				$firstName,
				$name,
				'',
				'',
				'мужской',
				$birthday,
				$firstName." ".$name,
				'Закордонний паспорт',
				$passport,
				'',
				'',
				'067 3788645',
				'', '', '', '', '',
				$address,
				$date_payment, //AA
				$insuranceRate,
				'A (work)',
				$country,
				'',
				$countDays,
				'',
				$franchise,
				'', '', '', '', '', '',
				'Туристична поїздка',
				'Плавание, теннис и т.д.',
				'да',
				$sumInsured,
				'да',
				$firstName,
				$name,
				'', '',
				'мужской',
				$birthday,
				$firstName." ".$name,
				'Закордонний паспорт',
				$passport,
				'', '', '067 3788645',
				'', '', '', '', '', '',
				$number_blank_comment
			];
		}
	}

	$orders_count = count( $excelData );


    // Безвіз
    // program_id = 3
    if($selectedDate == "") {
        $data = $wpdb->get_results( "SELECT name, last_name as firstName, birthday,
(
(YEAR(CURRENT_DATE) - YEAR(birthday)) -                             /* step 1 */
(DATE_FORMAT(CURRENT_DATE, '%m%d') < DATE_FORMAT(birthday, '%m%d')) /* step 2 */
) AS years, passport, address, blank_series, blank_number, company_title, date_from as dateFrom, date_to as dateTo, count_days as countDays, rate_locations as country, rate_insured_sum as sumInsured, rate_price as insuranceRate, rate_franchise as franchise, rate_coefficient, date_added, number_blank_comment FROM " . $table_name . " WHERE date_added >= CURRENT_DATE() AND status = 1 AND company_id = 2 AND program_id = 3 ORDER BY id DESC;", ARRAY_A );

    }
    else {
        // 547
        $data = $wpdb->get_results( "SELECT name, last_name as firstName, birthday,
(
(YEAR(CURRENT_DATE) - YEAR(birthday)) -                             /* step 1 */
(DATE_FORMAT(CURRENT_DATE, '%m%d') < DATE_FORMAT(birthday, '%m%d')) /* step 2 */
) AS years, passport, address, blank_series, blank_number, company_title, date_from as dateFrom, date_to as dateTo, count_days as countDays, rate_locations as country, rate_insured_sum as sumInsured, rate_price as insuranceRate, rate_franchise as franchise, rate_coefficient, date_added, number_blank_comment FROM " . $table_name . " WHERE date_added >= '".$selectedDate."' AND status = 1 AND company_id = 2 AND program_id = 3 AND id > 547 ORDER BY id DESC;", ARRAY_A );

    }

    $excelData_bezviz = [];
    foreach($data as $row){
//        if(count($row) == 19) {
            extract( $row );

            //Price * coefficient
            $insuranceRate = $insuranceRate * $rate_coefficient;
            $insuranceRate = round( $insuranceRate, 2 );
            $birthday = date( "d.m.Y", strtotime( $birthday ) );
            $dateFrom = date( "d.m.Y", strtotime( $dateFrom ) );
            $dateTo = date( "d.m.Y", strtotime( $dateTo ) );

            preg_match('/^([A-Za-z]+)([0-9]+)/', $passport, $maches);
            if(count($maches) == 4){
                $passport = $maches[1].' '.$maches[2];
            }
            else {
                preg_match('/^\D*(?=\d)/', $passport, $mach);
                $passport = substr($passport, 0, strlen($mach[0]))." ".substr($passport, strlen($mach[0]));
            }
            $passport = trim($passport);

            $date_payment = date( "d.m.Y", strtotime( '-1 day', strtotime($dateFrom )) );
            $dateFrom = date( "d.m.Y", strtotime( $dateFrom ) );

            $date_added = date( "d.m.Y", strtotime( $date_added ) );
            if($date_added == $dateFrom) $date_payment = $dateFrom;

            $excelData_bezviz[] = [
                $blank_number,
                $blank_series,
                $date_added,
                '',
                $dateFrom,
                $dateTo,
                '',
                '',
                $firstName,
                $name,
                '',
                '',
                'мужской',
                $birthday,
                $firstName." ".$name,
                'Закордонний паспорт',
                $passport,// q
                '',
                '',
                '067 3788645',
                '', '', '', '', '', '', '',
                $address, // AB
                $date_payment, //AC
                $insuranceRate, //AD
                'M',
                $country, // AF
                '',
                $countDays,
                '',
                $franchise, // AJ
                '', '', '', '', '', '', '',
                'Туристична поїздка',
                'Плавание, теннис и т.д.',
                'да', // AT
                $sumInsured,
                'да',
                $firstName,
                $name,
                '', '',
                'мужской', // BA
                $birthday,
                $firstName." ".$name,
                'Закордонний паспорт',
                $passport,
                '', '', '067 3788645',
                '', '', '', '', '', '', '', '',
//                $number_blank_comment
            ];
//        }
    }

    $orders_count += count( $excelData_bezviz );

    // Віза Чехія
    // program_id = 4
    if($selectedDate == "") {
        $data = $wpdb->get_results( "SELECT name, last_name as firstName, birthday,
(
(YEAR(CURRENT_DATE) - YEAR(birthday)) -                             /* step 1 */
(DATE_FORMAT(CURRENT_DATE, '%m%d') < DATE_FORMAT(birthday, '%m%d')) /* step 2 */
) AS years, passport, address, blank_series, blank_number, company_title, date_from as dateFrom, date_to as dateTo, count_days as countDays, rate_locations as country, rate_insured_sum as sumInsured, rate_price as insuranceRate, rate_franchise as franchise, rate_coefficient, date_added, number_blank_comment FROM " . $table_name . " WHERE date_added >= CURRENT_DATE() AND status = 1 AND company_id = 2 AND program_id = 4 ORDER BY id DESC;", ARRAY_A );

    }
    else {
        // 547
        $data = $wpdb->get_results( "SELECT name, last_name as firstName, birthday,
(
(YEAR(CURRENT_DATE) - YEAR(birthday)) -                             /* step 1 */
(DATE_FORMAT(CURRENT_DATE, '%m%d') < DATE_FORMAT(birthday, '%m%d')) /* step 2 */
) AS years, passport, address, blank_series, blank_number, company_title, date_from as dateFrom, date_to as dateTo, count_days as countDays, rate_locations as country, rate_insured_sum as sumInsured, rate_price as insuranceRate, rate_franchise as franchise, rate_coefficient, date_added, number_blank_comment FROM " . $table_name . " WHERE date_added >= '".$selectedDate."' AND status = 1 AND company_id = 2 AND program_id = 4 AND id > 547 ORDER BY id DESC;", ARRAY_A );

    }

    $excelData_czech = [];
    foreach($data as $row){
        if(count($row) == 19) {
            extract( $row );

            //Price * coefficient
            $insuranceRate = $insuranceRate * $rate_coefficient;
            $insuranceRate = round( $insuranceRate, 2 );
            $birthday = date( "d.m.Y", strtotime( $birthday ) );
            $dateFrom = date( "d.m.Y", strtotime( $dateFrom ) );
            $dateTo = date( "d.m.Y", strtotime( $dateTo ) );

            preg_match('/^([A-Za-z]+)([0-9]+)/', $passport, $maches);
            if(count($maches) == 4){
                $passport = $maches[1].' '.$maches[2];
            }
            else {
                preg_match('/^\D*(?=\d)/', $passport, $mach);
                $passport = substr($passport, 0, strlen($mach[0]))." ".substr($passport, strlen($mach[0]));
            }
            $passport = trim($passport);

            $date_payment = date( "d.m.Y", strtotime( '-1 day', strtotime($dateFrom )) );
            $dateFrom = date( "d.m.Y", strtotime( $dateFrom ) );

            $date_added = date( "d.m.Y", strtotime( $date_added ) );
            if($date_added == $dateFrom) $date_payment = $dateFrom;

            $excelData_czech[] = [
                $blank_number,
                $blank_series,
                $date_added,
                '',
                $dateFrom,
                $dateTo,
                '',
                '',
                $firstName,
                $name,
                '',
                '',
                'мужской',
                $birthday,
                $firstName." ".$name,
                'Закордонний паспорт',
                $passport,
                '',
                '',
                '067 3788645',
                '', '', '', '', '',
                $address,
                $date_payment, //AA
                $insuranceRate,
                'A (work)',
                $country,
                '',
                $countDays,
                '',
                $franchise,
                '', '', '', '', '', '',
                'Туристична поїздка',
                'Плавание, теннис и т.д.',
                'да',
                $sumInsured,
                'да',
                $firstName,
                $name,
                '', '',
                'мужской',
                $birthday,
                $firstName." ".$name,
                'Закордонний паспорт',
                $passport,
                '', '', '067 3788645',
                '', '', '', '', '', '',
                $number_blank_comment
            ];
        }
    }

    $orders_count += count( $excelData_czech );

    $attachments = [];

    //Віза стандартні бланки
    if( $excelData > 0 ){
        $reader = IOFactory::createReader("Xlsx");
        $spreadsheet = $reader->load("gardian.xlsx");
        $sheet       = $spreadsheet->getActiveSheet();
        $sheet->fromArray( $excelData,null,'A2' );

        $format = "xls";
        $xlsName = "report_viza_st_bl.".$format;

        $file = WP_CONTENT_DIR . '/plugins/insurance/report/send/' . $xlsName;

        $writer  = new Xls( $spreadsheet );
        $writer->save($file);

        $attachments[] = $file;
    }

    //Безвіз
    if( count( $excelData_bezviz ) > 0 ){
        $reader = IOFactory::createReader("Xlsx");
        $spreadsheet = $reader->load("gardian_m.xlsx");
        $sheet       = $spreadsheet->getActiveSheet();
        $sheet->fromArray( $excelData_bezviz,null,'A2' );

        $format = "xls";
        $xlsName = "report_bezviz.".$format;

        $file = WP_CONTENT_DIR . '/plugins/insurance/report/send/' . $xlsName;

        $writer  = new Xls( $spreadsheet );
        $writer->save($file);

        $attachments[] = $file;
    }

    //Віза Чехія
//    echo '<br>';
//    var_dump($excelData_czech);
    if( count( $excelData_czech ) > 0 ){
        $reader = IOFactory::createReader("Xlsx");
        $spreadsheet = $reader->load("gardian_czech.xlsx");
        $sheet       = $spreadsheet->getActiveSheet();
        $sheet->fromArray( $excelData_czech,null,'A2' );
//
        $format = "xls";
        $xlsName = "report_viza_czech.".$format;
//
        $file = WP_CONTENT_DIR . '/plugins/insurance/report/send/' . $xlsName;

        $writer  = new Xls( $spreadsheet );
        $writer->save($file);

        $attachments[] = $file;
    }


//echo '$orders_count: ' . $orders_count . '<br>';
//	if(count($excelData) > 0){
	if( $orders_count > 0 ){
		/*$reader = IOFactory::createReader("Xlsx");
		$spreadsheet = $reader->load("gardian.xlsx");
		$sheet       = $spreadsheet->getActiveSheet();
		$sheet->fromArray( $excelData,null,'A2' );

		$format = "xls";
		$xlsName = "report.".$format;

		$file = WP_CONTENT_DIR . '/plugins/insurance/report/send/' . $xlsName;

		$writer  = new Xls( $spreadsheet );
		$writer->save($file);*/

		//sen email
		$subject = 'Медичне страхування (Щоденний звіт по заявкам) | GARDIAN';
		$message = 'GARDIAN. За сьогодні було додано медичних полісів - ' . $orders_count . '. </br>';

		//$site_email = 'kutsenko.a.v.1990@gmail.com';
		$site_email = get_option('admin_email');
		// $to = 'alexshtanko@gmail.com';
		// $to = 'kutsenko.a.v.1990@gmail.com';
		$to = array(
			//'kutsenko.a.v.1990@gmail.com',
			 'alexshtanko@gmail.com',
			get_option('admin_email'),
		);

		$headers = "From: " . $site_email . "\r\n";
		$headers .= "Reply-To: ". $site_email . "\r\n";
		$headers .= "MIME-Version: 1.0\r\n";
		$headers .= "Content-Type: text/html; charset=UTF-8\r\n";

		$header_ = 'MIME-Version: 1.0' . "\r\n" . 'Content-type: text/html; charset=UTF-8' . "\r\n";
//		$status = wp_mail($to, '=?UTF-8?B?'.base64_encode($subject).'?=', $message, $header_ . $headers, $file);
		$status = wp_mail($to, '=?UTF-8?B?'.base64_encode($subject).'?=', $message, $header_ . $headers, $attachments);



		if( $status ){

//            echo 'Письмо отправлено.';

			$table_name = $wpdb->get_blog_prefix() . 'insurance_cron_reports';

			$script_name = 'Медичне страхування';
			$comment = 'GARDIAN | Сформовано та вiдправлено ' . $orders_count;

			$query = $wpdb->insert( $table_name, array( 'script_name' => $script_name, 'comment' => $comment ),
				array( '%s', '%s' ));
		}
		else {
			echo "Ошибка отправки письма!";
		}

//		unlink($file);
//		unlink($attachments);
	}
}