<?php

class Euroins
{

    private $url = "http://testapi.euroins.com.ua/ChangeContracts4413/reserve";
    public function index()
    {

    }

    //Резервирование договора
    public function reserve( $insurer_data )
    {

        if( ! empty( $insurer_data ) )
        {
            $result = '';
            $url = "http://testapi.euroins.com.ua/ChangeContracts4413/reserve";
            //$url = $this->url;
            $name = $this->transliterateen( $insurer_data['name'] );
            $surname = $this->transliterateen( $insurer_data['surname'] );

            //Преобразовываем номер телефона в нужный формат для отправки
            $tel_data = str_replace( '(', '', $insurer_data['tel'] );
            $tel_data = str_replace( ')', '', $tel_data );
            $tel_data = explode(' ',$tel_data);
            $split = str_split( $tel_data[1] );
            $tel = $tel_data[0] . $split[0] . ' ' . $split[1] . $split[2] . '-' . $tel_data[2];

            //Преобразовываем франшизу
            $franchise = explode( ' ', $insurer_data['rate_franchise'] );
            $franchise = $franchise[0];

            $username = 'TestPartners';
            $password = 'uXT6%rNo';

            $data = [
                "insurer" => [
                    "birthDate"=> $insurer_data['date'],
                    "dCitizenStatusID"=> 1,
                    "dPersonStatusID"=> 1,
                    "identCode"=> "0000000000",
                    "name"=> $name,
                    "surname"=> $surname,
                    "fullNameEnglish"=> $insurer_data['name'] . " " . $insurer_data['surname'],
                    "phoneNumber"=> $tel,
                    "email"=> $insurer_data['email'],
                    "countryID"=> "0f52adf4-f544-42d6-bea6-ad656ab683df",
                    "englishAddress"=> $insurer_data['address'],
                    "dDocumentTypeID"=> 11,
                    "docNumber"=> $insurer_data['passport'], //Номер документу Regex: ^[0-9а-яА-Яa-zA-ZіІїЇэЭєЄёЁ\. +\-',"()\\]*$
//                    "docIssuedDate"=> "2008-05-31T00:00:00" //Дата видачі документу Вказується не для всіх типів документів
                ],
                "skipSms"=> true,
//                "insuranceObjects"=> [
//                    array(
//                        "birthDate"=> "1996-10-27T00:00:00",
//                        "dCitizenStatusID"=> 1,
//                        "dPersonStatusID"=> 1,
//                        "identCode"=> "0000000000",
//                        "name"=> $name,
//                        "surname"=> $surname,
//                        "fullNameEnglish"=> "Dmytro Nadsonov",
//                        "phoneNumber"=> "+380 12-121-21-11",
//                        "email"=> "koval@gmail.com",
//                        "countryID"=> "0f52adf4-f544-42d6-bea6-ad656ab683df",
//                        "englishAddress"=> "Odessa",
//                        "dDocumentTypeID"=> 11,
//                        "docNumber"=> "00013981",
//                        "docIssuedDate"=> "2008-05-31T00:00:00"
//                    )
//                ],
                "franchise"=> $franchise,
                "agentID"=> "TravelInsService",
                "insuranceSum"=> 30000,
                "dTravelType"=> 2,
                "country"=> "f4e130f5-46bc-45c6-8af4-02cfd50166a1",  // - Poland
                "termOfBeingAbroad"=> 15, //Узнать
                "beginingDate"=> $insurer_data['date_start'],
                "birthDate"=> $insurer_data['date'], //Узнать ПОВТОРЯЕТЬСЯ
                "program"=> 2,
                "currency"=> 3,
                "zoneOfAct"=> 1
            ];

            //Есть страховальники
            if( ! empty( $insurer_data['insurers'] ) )
            {

                foreach ( $insurer_data['insurers'] as $insurer )
                {
                    $insurer_last_name = $this->transliterateen( $insurer['lastName'] );
                    $insurer_name = $this->transliterateen( $insurer['name'] );
                    $insurer_birthday = date("Y-m-d", strtotime($insurer['birthday']));
                    $insurer_coefficient_date = get_full_years($insurer['date']);
                    $insurer_passport = $insurer['passport'];
                    $insurer_address = $insurer['address'];
                }


                $data["insuranceObjects"][] = array(
                    "birthDate"=> $insurer_birthday,
                    "dCitizenStatusID"=> 1,
                    "dPersonStatusID"=> 1,
                    "identCode"=> "0000000000",
                    "name"=> $insurer_name,
                    "surname"=> $insurer_last_name,
                    "fullNameEnglish"=> $insurer['name'] . ' ' . $insurer['lastName'],
                    "phoneNumber"=> $tel,
                    "email"=> $insurer_data['email'],
                    "countryID"=> "0f52adf4-f544-42d6-bea6-ad656ab683df",
                    "englishAddress"=> $insurer['address'],
                    "dDocumentTypeID"=> 11,
                    "docNumber"=> $insurer['passport'],
//                    "docIssuedDate"=> "2008-05-31T00:00:00" //Узнать
                );

            }
            else
            {
                $data["insuranceObjects"][] = array(
                    "birthDate"=> $insurer_data['date'],
                    "dCitizenStatusID"=> 1,
                    "dPersonStatusID"=> 1,
                    "identCode"=> "0000000000",
                    "name"=> $name,
                    "surname"=> $surname,
                    "fullNameEnglish"=> $insurer_data['name'] . " " . $insurer_data['surname'],
                    "phoneNumber"=> $tel,
                    "email"=> $insurer_data['email'],
                    "countryID"=> "0f52adf4-f544-42d6-bea6-ad656ab683df",
                    "englishAddress"=> $insurer_data['address'],
                    "dDocumentTypeID"=> 11,
                    "docNumber"=> $insurer_data['passport'], //Узнать
//                    "docIssuedDate"=> "2008-05-31T00:00:00" //Узнать
                );
            }


            $data = json_encode( $data );
            $ch = curl_init( $url );

            /* pass encoded JSON string to the POST fields */
            curl_setopt( $ch, CURLOPT_POSTFIELDS, $data );

            /* set the content type json */
            $headers = [
                'Content-Type:application/json',
                'authid: TestPartners',
                'authkey: uXT6%rNo'
            ];

            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

            /* set return type json */
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            /* execute request */
            $result = curl_exec($ch);

            /* close cURL resource */
            curl_close($ch);

            $result = json_decode($result, true);

            return $result;

        }

    }

    //Добавление информации о договоре в БД
    public function add_order_data( $data )
    {
        require($_SERVER['DOCUMENT_ROOT'].'/wp-load.php');

        global $wpdb;

        $table_name = $wpdb->get_blog_prefix() . 'insurance_euroins_orders';

        $query = $wpdb->insert(
            $table_name,
            array( 'order_id' => $data['order_id'], 'insuranceApplicationID' => $data['insuranceApplicationID'], 'polisNumber' => $data['polisNumber'] ),
            array( '%d', '%s', '%s')
        );

        return $query;


    }


    public function confirm( $insuranceApplicationID )
    {

        $url = "http://testapi.euroins.com.ua/ChangeContracts4413/confirm";

        $data = [
            'insuranceApplicationID' => $insuranceApplicationID,
        ];

        $data = json_encode( $data );
        $ch = curl_init( $url );

        curl_setopt( $ch, CURLOPT_POSTFIELDS, $data );

        $headers = [
            'Content-Type:application/json',
            'authid: TestPartners',
            'authkey: uXT6%rNo'
        ];

        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        curl_exec($ch);

        $result = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        curl_close($ch);

        return $result;
    }

    //Получаем данные договоров ЕВРОИНС в зависимисти от времени
    public function get_orders_data( $date_from, $date_to )
    {
        require($_SERVER['DOCUMENT_ROOT'].'/wp-load.php');

        global $wpdb;

        $date_from = $date_from . " 00:00:00";

        $date_to = $date_to . " 23:59:59";

        $table_name = $wpdb->get_blog_prefix() . 'insurance_euroins_orders';

        $order_data = $wpdb->get_results($wpdb->prepare("SELECT * FROM " . $table_name . " WHERE date_added >= '%s' AND date_added <= '%s' AND status = '%d' ", $date_from, $date_to, 0 ), ARRAY_A);

        return $order_data;

    }

    //Получаем данные договора ЕВРОИНС в зависимисти от времени
    public function get_order_data( $order_id )
    {

        require($_SERVER['DOCUMENT_ROOT'].'/wp-load.php');

        global $wpdb;

        $table_name = $wpdb->get_blog_prefix() . 'insurance_euroins_orders';

        $order_data = $wpdb->get_results($wpdb->prepare("SELECT * FROM " . $table_name . " WHERE order_id = %s ", $order_id), ARRAY_A);

        return $order_data;
    }


    //Получаем данные договора
    public function get_order( $order_id )
    {

        require($_SERVER['DOCUMENT_ROOT'].'/wp-load.php');

        global $wpdb;

        $table_name = $wpdb->get_blog_prefix() . 'insurance_orders';

        $order_data = $wpdb->get_results($wpdb->prepare("SELECT * FROM " . $table_name . " WHERE id = %d ", $order_id), ARRAY_A);

        return $order_data;
    }

    //Изменяем статус у договора
    public function change_order_status( $order_id, $status = 0 )
    {
        require($_SERVER['DOCUMENT_ROOT'].'/wp-load.php');

        global $wpdb;

        $table_name = $wpdb->get_blog_prefix() . 'insurance_euroins_orders';

        $date_change = date( 'Y-m-d H:i:s' );

        $result = $wpdb->update( $table_name, ['status' => $status, 'date_change' => $date_change], ['order_id' => $order_id], ['%d', '%s'], ['%d'] );

        return $result;
    }

    public function send_email( $data = '', $count = 0 )
    {
        //sen email
        $from_email = 'info@epolicy.com.ua';
        $subject = 'Медичне страхування (EUROINS).';
        $message = '<p>Не вдалося змiнити статус для договорiв (EUROINS) - ' . $count . '</p>';
        $message .= $data;

        $to = array(
            //'kutsenko.a.v.1990@gmail.com',
             'alexshtanko@gmail.com',
            get_option('admin_email'),
        );

        $headers = "From: " . $from_email . "\r\n";
        $headers .= "Reply-To: ". $from_email . "\r\n";
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: text/html; charset=UTF-8\r\n";

        $header_ = 'MIME-Version: 1.0' . "\r\n" . 'Content-type: text/html; charset=UTF-8' . "\r\n";
        $status = wp_mail($to, '=?UTF-8?B?'.base64_encode($subject).'?=', $message, $header_ . $headers);

        return $status;
    }


    //Удаление договора
    public function remove_order( $order_id )
    {
        require($_SERVER['DOCUMENT_ROOT'].'/wp-load.php');

        global $wpdb;

        $table_name = $wpdb->get_blog_prefix() . 'insurance_orders';

        $wpdb->delete( $table_name, [ 'id'=> $order_id ], [ '%d' ] ); // 1 будет обработано как число (%d).
    }


    //Удаление EUROINS договора
    public function remove_euroins_order( $order_id )
    {
        require($_SERVER['DOCUMENT_ROOT'].'/wp-load.php');

        global $wpdb;

        $table_name = $wpdb->get_blog_prefix() . 'insurance_euroins_orders';

        $wpdb->delete( $table_name, [ 'id'=> $order_id ], [ '%d' ] ); // 1 будет обработано как число (%d).
    }



    //Перевод с Англ на Кирилицу
    public function transliterateen($input)
    {
        $gost = array(
            "a" => "а", "b" => "б", "v" => "в", "g" => "г", "d" => "д", "e" => "е", "yo" => "ё",
            "j" => "ж", "z" => "з", "i" => "и", "i" => "й", "k" => "к",
            "l" => "л", "m" => "м", "n" => "н", "o" => "о", "p" => "п", "r" => "р", "s" => "с", "t" => "т",
            "y" => "у", "f" => "ф", "h" => "х", "c" => "ц",
            "ch" => "ч", "sh" => "ш", "sh" => "щ", "i" => "ы", "e" => "е", "u" => "у", "ya" => "я", "A" => "А", "B" => "Б",
            "V" => "В", "G" => "Г", "D" => "Д", "E" => "Е", "Yo" => "Ё", "J" => "Ж", "Z" => "З", "I" => "И", "I" => "Й", "K" => "К", "L" => "Л", "M" => "М",
            "N" => "Н", "O" => "О", "P" => "П",
            "R" => "Р", "S" => "С", "T" => "Т", "Y" => "Ю", "F" => "Ф", "H" => "Х", "C" => "Ц", "Ch" => "Ч", "Sh" => "Ш",
            "Sh" => "Щ", "I" => "Ы", "E" => "Е", "U" => "У", "Ya" => "Я", "'" => "ь", "'" => "Ь", "''" => "ъ", "''" => "Ъ", "j" => "ї", "i" => "и", "g" => "ґ",
            "ye" => "є", "J" => "Ї", "I" => "І",
            "G" => "Ґ", "YE" => "Є"
        );
        return strtr($input, $gost);
    }

}