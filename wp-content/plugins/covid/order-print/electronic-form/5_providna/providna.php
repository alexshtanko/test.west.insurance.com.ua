<?php

use PhpOffice\PhpWord\TemplateProcessor;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\Settings;

if( !defined('ACCESSCNSTCOVID' ) ) {
    die('Direct access not permitted');
}
else {

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

    if (!$insurer_status) {
        $insurers = $order_data->get_covid_insurers($order_id);

        if (count($insurers) > 0) {
            $i_fio = $insurers[0]['last_name'] . ' ' . $insurers[0]['name'];
            $i_address = $insurers[0]['address'];
            $i_birthday = date('d.m.Y', strtotime($insurers[0]['birthday']));
            $i_passport = $insurers[0]['passport'];
            $i_inn = '';
            $i_phone = '';
            $i_email = '';
            $total_rate_price = $rate_price * $insurers[0]['coefficient'] * $order['rate_price_coefficient'];
        }
    } else {
        $i_fio = $fio;
        $i_address = $address;
        $i_birthday = $birthday;
        $i_passport = $passport;
        $i_inn = '';
        $i_phone = $phone;
        $i_email = $email;
    }


    $insure_tarif = explode(' ', $rate_insured_sum);
    $insure_tarif = ($total_rate_price / $insure_tarif[0]) * 100;


    $insurer_peoples_count = 0;


        $templateProcessor = new TemplateProcessor(__DIR__ . "/template.docx");

        $templateProcessor->setValue('orderNumber', "04/".$blank_number_print."/1054/21");
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


        $templateProcessor->setValue('insFio', $i_fio);
        $templateProcessor->setValue('insBirthday', $i_birthday);
        $templateProcessor->setValue('insPassport', $i_passport);
        $templateProcessor->setValue('insAdress', $i_address);
        $templateProcessor->setValue('insPhone', $i_phone);


        header('Content-type:application/msword');
        header('Content-Disposition: attachment; filename="report.docx"');
        header('Cache-Control: max-age=0');
        $templateProcessor->saveAs('php://output');

        exit;

}