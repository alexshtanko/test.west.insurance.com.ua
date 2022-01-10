<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       alexshtanko.com.ua
 * @since      1.0.0
 *
 * @package    Covid
 * @subpackage Covid/admin/partials
 */

require_once ABSPATH.'/vendor/autoload.php';

require_once ABSPATH . '/wp-content/plugins/covid/admin/include/class-covid-admin-help.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Writer\Pdf\Mpdf;
use PhpOffice\PhpSpreadsheet\Style\Border;
?>

<?php
$error = '';
if($_POST){
	global $wpdb;
	$table_name = $wpdb->prefix . "covid_orders";
	$table_statuses_name = $wpdb->prefix . "covid_statuses";
	$current_user = wp_get_current_user();

	$admin = false;
	if( $current_user->ID ) {
		$user       = new WP_User( $current_user->ID );
		$user_roles = $user->roles;

		if (in_array( 'administrator', $user_roles, true ) ) {
			$admin = true;
		}
	}
	else {
		echo "У даного користувача немає прав.";
		exit;
	}

	if($admin) {
		//$format = "pdf";
		$format = "xlsx";

//		$_POST["dateFrom"]  = "2021-01-01"; //"2020-09-03";
//		$_POST["dateTo"]    = "2021-01-30"; //"2020-10-16";
//		$_POST["managerId"] = ""; //"29";
//		$_POST["referals"]  = "1";
//		$_POST["companyId"] = "";//"1"; //"177";
//		$_POST["programId"] = "1";

        if ( $_POST["managerId"] ) {
            if ( array_key_exists( "referals", $_POST ) ) {
                $managers       = getAllReferals( [ intval( $_POST["managerId"] ) ] );
                $searchManagers = count( $managers ) > 1 ? implode( ", ", $managers ) : $managers[0];
            } else {
                $searchManagers = $_POST["managerId"];
            }
        }
        $managerId = $_POST["managerId"] ? "E.`user_id` in (" . $searchManagers . ")" : "";

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
//        if( $blank_type_id == 1 || $blank_type_id == 2 ){
//            $query .= ' AND blank_type_id = ' . $blank_type_id;
//        }

		$data = $wpdb->get_results( "SELECT * FROM " . $table_name . " as E WHERE ".$query." AND `status` IN (SELECT id FROM ".$table_statuses_name." WHERE status = 1 AND adminReport = 1) ORDER BY E.`id` DESC", ARRAY_A );
		$data = array_map('wp_unslash', $data);

//echo '<pre>';
//var_dump($data);

	$blank_types_data = $wpdb->get_results( "SELECT id, text FROM `plc_covid_blank_type` WHERE `status` = 1", ARRAY_A);

		$reader = IOFactory::createReader("Xlsx");
		$spreadsheet = $reader->load($reportFilePath);
		$sheet       = $spreadsheet->getActiveSheet();

		$excelData = array();
		if ( count( $data ) > 0 ) {
			$i = 1;
			foreach ( $data as $row ) {
				$blankNumber = $row['blank_number'];
				$blankSeries = $row['blank_series'];
				$dateAdded = date("d.m.Y", strtotime($row['date_added']));
				$orderStatus = mb_strtoupper($allStatuses[$row["status"]]);
                $order_blank_type_id = (int) $row['blank_type_id'];



				if($row['status'] == 1){


				    /*
				     * Расчет стоимости в зависимости от компании, наценок, количеста застрахованых пользователей
				     *
				     * */
                    $order_id = $row['id'];
                    $companyId = $row['company_id'];
                    $rate_price = $row['rate_price'];

                    $insurer_status = $row['insurer_status'];

                    $covid = new Covid_Class();

                    $insurers = $covid->get_covid_insurers( $order_id );

                    $insurer_peoples_count = 0;
                    //Финальная стоимость страховки
                    $total_rate_price = 0;


                    $insurer_status = (int)$row['insurer_status'];

                    $insurer_price = 0;

                    $total_insurer_rate_price = 0;

                    $insurer_price_data = new Covid_Admin_Help();

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




					$dateFrom           = date( "d.m.Y", strtotime( $row['date_from'] ) );
					$dateTo             = date( "d.m.Y", strtotime( $row['date_to'] ) );
					$countDays          = $row['count_days'];
					$name               = $row['name'];
					$lastName           = $row['last_name'];
					$passport           = $row['passport'];
					$birthday           = date( "d.m.Y", strtotime( $row['birthday'] ) );
//					$ratePrice          = (float) $row['rate_price'];
					$ratePrice          = (float) $total_rate_price;
					$rate_coefficient   = (float) $row['rate_coefficient'];
//					$ratePrice          = $ratePrice * $rate_coefficient;
//					$ratePrice          = round( $ratePrice, 2 );
					$ratePrice          = $total_insurer_rate_price;
					$cashback           = (float) $row['cashback'];
					$summCashback       = $cashback ? round( ( $ratePrice / 100 ) * $cashback, 2 ) : "";
					$user               = get_user_by( 'id', $row['user_id'] ); //$user->data->display_name
					$companyTitle       = $row['company_title'];
					$programTitle       = $row['program_title'];
					$numberBlankComment = $row['number_blank_comment'];


                }
                else {
	                $dateFrom = $dateTo = $countDays = $name = $lastName = $passport = $birthday = $rate_coefficient = $ratePrice = $cashback = $summCashback  = "";
	                $user               = get_user_by( 'id', $row['user_id'] ); //$user->data->display_name
	                $companyTitle       = $row['company_title'];
	                $programTitle       = $row['program_title'];
	                $numberBlankComment = $row['number_blank_comment'];
                }


                foreach( $blank_types_data as $blank_type_data ){
                    if( $blank_type_data['id'] == $order_blank_type_id ){
                        $blank_type_text = $blank_type_data['text'];
                    }
                }

                $blank_type_text = 'Електронний';

				$excelData[] = array(
				        $i,
                    $blankSeries.$blankNumber,
                    $dateAdded,
                    $dateFrom,
                    $dateTo,
                    $countDays,
                    $lastName." ".$name,
                    $passport,
                    $birthday,
                    $ratePrice,
                    $cashback,
                    $summCashback,
                    $user->data->display_name,
                    $companyTitle,
                    $programTitle,
                    $numberBlankComment,
                    $blank_type_text,
                    $orderStatus
                );
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

			$sheet->getStyle( 'A' . $generateRowsStart . ':R' . ( $generateRowsStart + $i - 2 ) )->applyFromArray( $styleArray );

			$sheet->mergeCells( 'B' . ( $generateRowsStart + $i + 2 ) . ':E' . ( $generateRowsStart + $i + 2 ) );
			$sheet->fromArray( [ "Довіритель" ], null, 'B' . ( $generateRowsStart + $i + 2 ) );
			$sheet->getStyle( 'B' . ( $generateRowsStart + $i + 2 ) )->getAlignment()->setHorizontal( 'center' )->setVertical( 'center' );
			$sheet->getStyle( 'B' . ( $generateRowsStart + $i + 2 ) )->getFont()->setBold( true );

			$sheet->mergeCells( 'B' . ( $generateRowsStart + $i + 4 ) . ':E' . ( $generateRowsStart + $i + 4 ) );
			$sheet->fromArray( [ "_____________________(_______________)" ], null, 'B' . ( $generateRowsStart + $i + 4 ) );
			$sheet->getStyle( 'B' . ( $generateRowsStart + $i + 4 ) )->getAlignment()->setHorizontal( 'right' )->setVertical( 'center' );

			$sheet->fromArray( [ "Повірений" ], null, 'G' . ( $generateRowsStart + $i + 2 ) );
			$sheet->getStyle( 'G' . ( $generateRowsStart + $i + 2 ) )->getAlignment()->setHorizontal( 'center' )->setVertical( 'center' );
			$sheet->getStyle( 'G' . ( $generateRowsStart + $i + 2 ) )->getFont()->setBold( true );

			$sheet->fromArray( [ "_____________________(_______________)" ], null, 'G' . ( $generateRowsStart + $i + 4 ) );
			$sheet->getStyle( 'G' . ( $generateRowsStart + $i + 4 ) )->getAlignment()->setHorizontal( 'right' )->setVertical( 'center' );

			$sheet->getStyle( 'A' . ( $generateRowsStart + $i - 1 ) . ":J" . ( $generateRowsStart + $i - 1 ) )->applyFromArray( $styleArray );
			$sheet->getStyle( 'A' . ( $generateRowsStart + $i - 1 ) . ":J" . ( $generateRowsStart + $i - 1 ) )->getFont()->setBold( true );
			$sheet->getStyle( 'A' . ( $generateRowsStart + $i - 1 ) . ":J" . ( $generateRowsStart + $i - 1 ) )->getAlignment()->setHorizontal( 'center' )->setVertical( 'center' );
			$sheet->mergeCells( 'A' . ( $generateRowsStart + $i - 1 ) . ':I' . ( $generateRowsStart + $i - 1 ) );
			$sheet->fromArray( [ "Всього" ], null, 'A' . ( $generateRowsStart + $i - 1 ) );
			$sheet->setCellValue( 'J' . ( $generateRowsStart + $i - 1 ), '=SUM(J' . $generateRowsStart . ':J' . ( $generateRowsStart + $i - 2 ) . ')' );

			if ( $format == "xlsx" ) {
				$writer  = new Xlsx( $spreadsheet );
				$xlsName = "report.xlsx";

				header( "Pragma: public" );
				header( "Expires: 0" );
				header( "Cache-Control: must-revalidate, post-check=0, pre-check=0" );
				header( "Cache-Control: private", false );
				header( 'Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' );
				header( 'Content-Disposition: attachment;filename="' . $xlsName . '"' );
				header( "Content-Transfer-Encoding: binary" );
				ob_end_clean();
				$writer->save( 'php://output' );
				exit();
			}

			if ( $format == "pdf" ) {
				$writer  = new Mpdf( $spreadsheet );
				$pdfName = "report.pdf";

				header( "Pragma: public" );
				header( "Expires: 0" );
				header( "Cache-Control: must-revalidate, post-check=0, pre-check=0" );
				header( "Cache-Control: private", false );
				header( "Content-type:application/pdf" );
				header( 'Content-Disposition: attachment;filename="' . $pdfName . '"' );
				header( "Content-Transfer-Encoding: binary" );
				ob_end_clean();
				$writer->save( 'php://output' );
				exit();
			}
		}
		else {
		    $error = '<div id="message" class="notice notice-error is-dismissible"><p>Договори за вказаними критеріям не знайдено.</p><button type="button" class="notice-dismiss"><span class="screen-reader-text">Закрити це повідомлення.</span></button></div>';
        }
	}

}
?>

<div class="wrap">
    <h1><?php echo get_admin_page_title(); ?></h1>
    <?php
    if($error) echo $error;

    $managersList = "";
    if(count($managers) > 0){
        foreach($managers as $key=>$value){
	        $managersList .= '<option value="' . $key . '" >' . $value . '</option>';
        }
    }

    $companiesList = "";
    if(count($companies) > 0){
	    foreach($companies as $value){
		    $companiesList .= '<option value="' . $value['id'] . '" >' . $value['title'] . '</option>';
	    }
    }

    $programsList = "";
    if(count($all_programs) > 0){
	    foreach($all_programs as $value){
		    $programsList .= '<option value="' . $value->id . '" >' . $value->title . '</option>';
	    }
    }

    $blank_type_id = '';
    if( count( $all_blank_type_id ) > 0 ){
        foreach( $all_blank_type_id as $value ){
            $blank_type_id .= '<option value="' . $value['id'] . '" >' . $value['text'] . '</option>';
        }
    }

    ?>
    <?php
    echo '<form action="" method="POST" class="get_report">';
    echo "<table class='form-table'><tbody>";
    echo '<tr>
            <th scope="row"><label for="dateFrom">Дата з</label></th>
            <td> 
                <input name="dateFrom" id="dateFrom" type="date" value="'.date("Y-m-d").'" style="width: 200px;">
            </td>
          </tr>
          <tr>
            <th scope="row"><label for="dateTo">Дата по</label></th>
            <td> 
                <input name="dateTo" id="dateTo" type="date" value="'.date("Y-m-d").'" style="width: 200px;">
            </td>
          </tr>
          <tr>
            <th scope="row"><label for="managerId">Менеджер</label></th>
            <td> 
                <select name="managerId" id="managerId" style="width: 200px;">
                 <option value="" selected=""></option>
                 '.$managersList.'
                 </select>
                 <input name="referals" type="checkbox" id="referals" value="1">
                 <label for="referals">+ реферали </label>
            </td>
          </tr>
          <tr>
            <th scope="row"><label for="companyId">Компанія</label></th>
            <td> 
                <select name="companyId" id="companyId" style="width: 200px;">
                <option value="" selected=""></option>
                 '.$companiesList.'
                 </select>
            </td>
          </tr> 
          <tr>
            <th scope="row"><label for="programId">Програма</label></th>
            <td> 
                <select name="programId" id="programId" style="width: 200px;">
                <option value="" selected=""></option>
                 '.$programsList.'
                 </select>
            </td>
          </tr>
          <tr>
            <th scope="row"><label for="blank_type_id">Тип бланка</label></th>
            <td> 
                <select name="blank_type_id" id="blank_type_id" style="width: 200px;">
                <option value="" selected=""></option>
                 '.$blank_type_id.'
                 </select>
            </td>
          </tr>';
    echo "</tbody></table>";
    echo "<p><button type='submit' class='button button-primary button-large'>Сформувати</button></p>";
    echo "</form>";
    ?>
</div>