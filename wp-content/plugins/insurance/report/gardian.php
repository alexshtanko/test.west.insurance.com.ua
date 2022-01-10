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

	//Віза стандарні бланки
    // program_id = 1
	//$sql = "SELECT name, last_name as firstName, birthday, ((YEAR(CURRENT_DATE) - YEAR(birthday)) - (DATE_FORMAT(CURRENT_DATE, '%m%d') < DATE_FORMAT(birthday, '%m%d'))) AS years, passport, address, blank_series, blank_number, company_title, date_from as dateFrom, date_to as dateTo, count_days as countDays, rate_locations as country, rate_insured_sum as sumInsured, rate_price as insuranceRate, rate_franchise as franchise, rate_coefficient, date_added, number_blank_comment FROM " . $table_name . " WHERE date_added BETWEEN '2021-07-01 00:00:00' AND '2021-07-01 23:59:59' AND status = 1 AND company_id = 2 AND program_id = 1 ORDER BY id DESC;";
	//echo $sql;
	//$data = $wpdb->get_results($sql, ARRAY_A);

	$data = $wpdb->get_results( "SELECT name, last_name as firstName, birthday,
(
(YEAR(CURRENT_DATE) - YEAR(birthday)) -                             /* step 1 */
(DATE_FORMAT(CURRENT_DATE, '%m%d') < DATE_FORMAT(birthday, '%m%d')) /* step 2 */
) AS years, passport, address, blank_series, blank_number, company_title, date_from as dateFrom, date_to as dateTo, count_days as countDays, rate_locations as country, rate_insured_sum as sumInsured, rate_price as insuranceRate, rate_franchise as franchise, rate_coefficient, date_added, number_blank_comment FROM " . $table_name . " WHERE date_added >= (CURRENT_DATE()-1) AND status = 1 AND company_id = 2 AND program_id = 1 ORDER BY id DESC;", ARRAY_A );

	$programOneComments = [];
	$programOneCommentsUnique = [];
	if(count($data) > 0) {
		foreach($data as $rows) {
			$programOneComments[] = $rows['number_blank_comment'];
		}
		$programOneCommentsUnique = array_values(array_unique($programOneComments));
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
        $data = $wpdb->get_results( "SELECT name, last_name as firstName, birthday,
(
(YEAR(CURRENT_DATE) - YEAR(birthday)) -                             /* step 1 */
(DATE_FORMAT(CURRENT_DATE, '%m%d') < DATE_FORMAT(birthday, '%m%d')) /* step 2 */
) AS years, passport, address, blank_series, blank_number, company_title, date_from as dateFrom, date_to as dateTo, count_days as countDays, rate_locations as country, rate_insured_sum as sumInsured, rate_price as insuranceRate, rate_franchise as franchise, rate_coefficient, date_added, number_blank_comment FROM " . $table_name . " WHERE date_added >= (CURRENT_DATE() - 1) AND status = 1 AND company_id = 2 AND program_id = 3 ORDER BY id DESC;", ARRAY_A );

	$programThreeComments = [];
	$programThreeCommentsUnique = [];
	if(count($data) > 0) {
		foreach($data as $rows) {
			$programThreeComments[] = $rows['number_blank_comment'];
		}
		$programThreeCommentsUnique = array_values(array_unique($programThreeComments));
	}

    $excelData_bezviz = [];
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
                $number_blank_comment
            ];
        }
    }

    $orders_count += count( $excelData_bezviz );

    // Віза Чехія
    // program_id = 4
        $data = $wpdb->get_results( "SELECT name, last_name as firstName, birthday,
(
(YEAR(CURRENT_DATE) - YEAR(birthday)) -                             /* step 1 */
(DATE_FORMAT(CURRENT_DATE, '%m%d') < DATE_FORMAT(birthday, '%m%d')) /* step 2 */
) AS years, passport, address, blank_series, blank_number, company_title, date_from as dateFrom, date_to as dateTo, count_days as countDays, rate_locations as country, rate_insured_sum as sumInsured, rate_price as insuranceRate, rate_franchise as franchise, rate_coefficient, date_added, number_blank_comment FROM " . $table_name . " WHERE date_added >= (CURRENT_DATE()-1) AND status = 1 AND company_id = 2 AND program_id = 4 ORDER BY id DESC;", ARRAY_A );

	$programFourComments = [];
	$programFourCommentsUnique = [];
	if(count($data) > 0) {
		foreach($data as $rows) {
			$programFourComments[] = $rows['number_blank_comment'];
		}
		$programFourCommentsUnique = array_values(array_unique($programFourComments));
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
	    if(count($programOneCommentsUnique) > 0) {
	    	$tmp = [];
            foreach($excelData as $orders){
                $f = array_search($orders[count($orders) -1], $programOneCommentsUnique);
			    $tmp[$f][] = $orders;
		    }

		    foreach($tmp as $keyComments=>$valueComments) {
			    $reader      = IOFactory::createReader( "Xlsx" );
			    $spreadsheet = $reader->load( "gardian.xlsx" );
			    $sheet       = $spreadsheet->getActiveSheet();
			    $sheet->fromArray( $valueComments, null, 'A2' );

			    $format  = "xls";
			    $xlsName = "report_viza_st_bl_comment_".$keyComments."." . $format;

			    $file = WP_CONTENT_DIR . '/plugins/insurance/report/send/' . $xlsName;

			    $writer = new Xls( $spreadsheet );
			    $writer->save( $file );

			    $attachments[] = $file;
		    }

		    unset($tmp);
	    }
    }

    //Безвіз
    if( count( $excelData_bezviz ) > 0 ){
	    $tmp = [];
	    foreach($excelData_bezviz as $orders){
		    $f = array_search($orders[count($orders) -1], $programThreeCommentsUnique);
		    $tmp[$f][] = $orders;
	    }

	    foreach($tmp as $keyComments=>$valueComments) {
		    $reader      = IOFactory::createReader( "Xlsx" );
		    $spreadsheet = $reader->load( "gardian_m.xlsx" );
		    $sheet       = $spreadsheet->getActiveSheet();
		    $sheet->fromArray( $valueComments, null, 'A2' );

		    $format  = "xls";
		    $xlsName = "report_bezviz_comment_".$keyComments."." . $format;

		    $file = WP_CONTENT_DIR . '/plugins/insurance/report/send/' . $xlsName;

		    $writer = new Xls( $spreadsheet );
		    $writer->save( $file );

		    $attachments[] = $file;
	    }

	    unset($tmp);
    }

    //Віза Чехія
    if( count( $excelData_czech ) > 0 ){
	    $tmp = [];
	    foreach($excelData_czech as $orders){
		    $f = array_search($orders[count($orders) -1], $programFourCommentsUnique);
		    $tmp[$f][] = $orders;
	    }

	    foreach($tmp as $keyComments=>$valueComments) {
		    $reader      = IOFactory::createReader( "Xlsx" );
		    $spreadsheet = $reader->load( "gardian_czech.xlsx" );
		    $sheet       = $spreadsheet->getActiveSheet();
		    $sheet->fromArray( $valueComments, null, 'A2' );

		    $format  = "xls";
		    $xlsName = "report_viza_czech_comment_".$keyComments."." . $format;

		    $file = WP_CONTENT_DIR . '/plugins/insurance/report/send/' . $xlsName;

		    $writer = new Xls( $spreadsheet );
		    $writer->save( $file );

		    $attachments[] = $file;
	    }

	    unset($tmp);
    }


	if( $orders_count > 0 ){
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
		$status = wp_mail($to, '=?UTF-8?B?'.base64_encode($subject).'?=', $message, $header_ . $headers, $attachments);

		if( $status ){
			$table_name = $wpdb->get_blog_prefix() . 'insurance_cron_reports';

			$script_name = 'Медичне страхування';
			$comment = 'GARDIAN | Сформовано та вiдправлено ' . $orders_count;

			$query = $wpdb->insert( $table_name, array( 'script_name' => $script_name, 'comment' => $comment ),
				array( '%s', '%s' ));
		}
		else {
			echo "Ошибка отправки письма!";
		}

		foreach($attachments as $files){
			unlink($files);
		}

	}
}