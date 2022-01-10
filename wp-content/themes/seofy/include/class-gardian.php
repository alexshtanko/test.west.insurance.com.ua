<?php

class Gardian
{
    const FILE_COOKIES = 'cookies_gardian.txt';
    public $username = "Подгурець_ВВ";
    public $password = "ogtER45ovO";
    public $siteUrl = "https://polis.grdn.com.ua/";
    public $loginUrl = "https://polis.grdn.com.ua/Home/Login";
    public $ordersTableUrl = "https://polis.grdn.com.ua/Home/TravelConTable";
    public $saveOrderUrl = "https://polis.grdn.com.ua/Home/SaveAgreement";
    public $blankUrl = "https://polis.grdn.com.ua/Home/TravelConDetails";
    public $printBlankUrl = "https://polis.grdn.com.ua/Home/GetPrintForm";
    public $sendSmsUrl = "https://polis.grdn.com.ua/Home/SendAgreementSMS";
    public $path;
    public $currencyRate;
    public $requestVerificationToken = "";

    public function __construct($path) {
        $this->path = $path;
    }

    public function loginPage(){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->loginUrl);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_REFERER, $this->siteUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_SSLVERSION, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch,CURLOPT_COOKIEJAR, $this->path.DIRECTORY_SEPARATOR.self::FILE_COOKIES);
        $response = curl_exec($ch);
        $httpResponseCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        if($httpResponseCode == 200) {
            preg_match( '/name=\"\_\_RequestVerificationToken\"\s+type=\"hidden\"\s+value=\"(.*?)\"/', $response, $matches );
            $this->requestVerificationToken = count( $matches ) == 2 ? $matches[1] : "";
            if($this->requestVerificationToken !== ""){
                return true;
            }
            else {
                return false;
            }
        }
        else {
            return false;
        }
    }

    public function login(){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->loginUrl);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_REFERER, $this->loginUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_SSLVERSION, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch,CURLOPT_COOKIEFILE, $this->path.DIRECTORY_SEPARATOR.self::FILE_COOKIES);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query(["__RequestVerificationToken" => $this->requestVerificationToken,
            "Username" => $this->username,
            "Password" => $this->password,
            "UseStandartForms" => "true"], '', '&'));
        curl_exec($ch);
        $httpResponseCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        return $httpResponseCode;
    }

    public function getCurrencyRate(){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->blankUrl);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_REFERER, $this->siteUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_SSLVERSION, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch,CURLOPT_COOKIEFILE, $this->path.DIRECTORY_SEPARATOR.self::FILE_COOKIES);
        $response = curl_exec($ch);
        $httpResponseCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if($httpResponseCode == 200) {
            preg_match( '/\"CurrencyRate\"\:(.*?),/', $response, $matches );
            $this->currencyRate = count( $matches ) == 2 ? $matches[1] : "";
        }
    }

    public function createOrder($data){
        if($this->currencyRate) $data['agr[CurrencyRate]'] = $this->currencyRate;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->saveOrderUrl);
        curl_setopt($ch, CURLOPT_HEADER, false);
        //curl_setopt($ch, CURLOPT_REFERER, $this->blankUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_SSLVERSION, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch,CURLOPT_COOKIEFILE, $this->path.DIRECTORY_SEPARATOR.self::FILE_COOKIES);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        $response = curl_exec($ch);
        $httpResponseCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if($httpResponseCode == 200){
            return json_decode(json_decode($response, true), true);
        }
        else {
            return false;
        }
    }

    public function changeOrderStatus($data, $status){
        $data['agr[Status]'] = $status;
        return $this->createOrder($data);
    }

    public function sendSms($guid){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->sendSmsUrl);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_REFERER, $this->blankUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_SSLVERSION, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch,CURLOPT_COOKIEFILE, $this->path.DIRECTORY_SEPARATOR.self::FILE_COOKIES);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "GUID=".$guid);
        $response = curl_exec($ch);
        $httpResponseCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if($httpResponseCode == 200){
            return json_decode(json_decode($response, true), true);
        }
        else {
            return false;
        }

    }

    public function printBlank($pdfData){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->printBlankUrl);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_REFERER, $this->ordersTableUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_SSLVERSION, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch,CURLOPT_COOKIEFILE, $this->path.DIRECTORY_SEPARATOR.self::FILE_COOKIES);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($pdfData));
        $response = curl_exec($ch);
        $httpResponseCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if($httpResponseCode == 200){
            ob_clean();
            $pdfName = "report.pdf";
            header( "Content-type:application/pdf" );
            header( 'Content-Disposition: attachment;filename="' . $pdfName . '"' );
            header( 'Cache-Control: max-age=0' );
            echo $response;
            exit;
        }
        else {
            return false;
        }

    }





    //Добавление информации о договоре в БД
    public function add_order_data( $data )
    {
        require($_SERVER['DOCUMENT_ROOT'].'/wp-load.php');

        global $wpdb;

        $table_name = $wpdb->get_blog_prefix() . 'insurance_gardian_orders';
        $date_change = date( 'Y-m-d H:i:s' );
        $query = $wpdb->insert(
            $table_name,
            array(
                'gardian_GUID' => $data['gardian_GUID'],
                'gardian_CustomerGUID' => $data['gardian_CustomerGUID'],
                'gardian_Number' => $data['gardian_Number'],
                'gardian_ObjectGUID' => $data['gardian_ObjectGUID'],
                'order_id' => $data['order_id'],
                'status' => $data['status'],
                'date_added' => $date_change,
                'date_change' => $date_change,
            ),
            array( '%s', '%s', '%s', '%s', '%d', '%d', '%s', '%s' )
        );

        return $query;


    }

    //Удаление договора
    public function remove_order( $order_id )
    {
        require($_SERVER['DOCUMENT_ROOT'].'/wp-load.php');

        global $wpdb;

        $table_name = $wpdb->get_blog_prefix() . 'insurance_orders';

        $wpdb->delete( $table_name, [ 'id'=> $order_id ], [ '%d' ] ); // 1 будет обработано как число (%d).
    }


    public function format_phone_number( $phone ){
        $phone = preg_replace("/[^0-9]*/",'',$phone);

        $area = substr($phone,0,3);;
        $code = substr($phone,3,2);;
        $num1 = substr($phone,5,3);;
        $num2 = substr($phone,8,2);;
        $num3 = substr($phone,10,2);;

        $phone = '+' . $area . '(' .  $code . ')' . '-' . $num1 . '-' . $num2 . '-' . $num3;

        return $phone;

    }

    /*
     * Получаем данные о договоре СК ГАРДИАН
     * RETURN ARRAY
     */
    public function get_gardian_order( $order_id )
    {
        require($_SERVER['DOCUMENT_ROOT'].'/wp-load.php');

        global $wpdb;

        $table_name = $wpdb->get_blog_prefix() . 'insurance_gardian_orders';

        $order_data = $wpdb->get_row($wpdb->prepare("SELECT * FROM " . $table_name . " WHERE order_id = %s AND status = 1 ", $order_id), ARRAY_A);

        return $order_data;
    }


    //Изменяем статус у договора
    public function change_order_status( $order_id, $status = 0 )
    {
        require($_SERVER['DOCUMENT_ROOT'].'/wp-load.php');

        global $wpdb;

        $table_name = $wpdb->get_blog_prefix() . 'insurance_gardian_orders';

        $date_change = date( 'Y-m-d H:i:s' );

        $result = $wpdb->update( $table_name, ['status' => $status, 'date_change' => $date_change], ['order_id' => $order_id], ['%d', '%s'], ['%d'] );

        return $result;
    }

    /*
     * Создание массива данных для отправки на сервис СК ГАРДИАН по изменению статуса
     * RETURN ARRAY
     */
    public function create_array_data( $order_id, $gardian_status )
    {

        $gardian_data = [];

        $order = $this->get_order( $order_id );

        $gardian_order = $this->get_gardian_order( $order_id );

        $paper = true;
        if( $order['blank_type_id'] == 2 ){
            $paper = false;
        }

        $blankType =  $paper === false ? "true" : "false";


        $program_id = $order['program_id'];

        $date_now = date("d.m.Y");

        $passport_series = preg_replace("/[^A-Za-z]/", '', $order['passport']);
        $passport_number = preg_replace("/[^0-9]/", '', $order['passport']);
        $rate_franchise_number = preg_replace("/[^0-9]/", '', $order['rate_franchise']);
        $gardian_rate_insured_sum = preg_replace("/[^0-9]*/",'', $order['rate_insured_sum']);
        $currencyRate = '30.3376';
//        $gardian_status = 'Draft';

        $sex = $order['sex'];
        if( $sex == 'M' )
        {
            $sex = 'Male';
        }
        elseif ( $sex == 'W' )
        {
            $sex = 'Female';
        }

        $gardian_product_id = '';
// 68947399-4db5-11eb-b19c-00155df66a18 - D (Латвія)
// 68947398-4db5-11eb-b19c-00155df66a18 - E (Чехія)
// 68947396-4db5-11eb-b19c-00155df66a18 - А (Work)
//	6894739a-4db5-11eb-b19c-00155df66a18 - М (Європа)
//	aea90dd0-75aa-11eb-b19f-00155df66a18 - М (СНД)
        if( $program_id == 1 )
        {
            $gardian_product_id = '68947396-4db5-11eb-b19c-00155df66a18';
        }
        elseif ( $program_id == 3 )
        {
            $gardian_product_id = '6894739a-4db5-11eb-b19c-00155df66a18';
        }
        elseif ( $program_id == 4 )
        {
            $gardian_product_id = '68947398-4db5-11eb-b19c-00155df66a18';
        }

        $gardian_phone = $this->format_phone_number( $order['phone_number'] );

        $gardian_data = [
            'agr[GUID]' => '',
            'agr[Blank][BlankGUID]' => '',
            'agr[Blank][BlankName]' => '',
            'agr[Blank][BlankComment]' => '',
            'agr[Blank][BlankComment2]' => '',
            'agr[Blank][NumberLength]' => 0,
            'agr[BlankNumber]' => 0,
            'agr[Sticker][BlankGUID]' => '37e5ec78_2fe2_11ec_b1b2_00155dae7a01', // Тип номерного бланка GUID (Всегда такое значение)
            'agr[Sticker][BlankName]' => 'GR', // Тип номерного бланка (Всегда такое значение)
            'agr[Sticker][BlankComment]' => '',
            'agr[Sticker][BlankComment2]' => '',
            'agr[Sticker][NumberLength]' => 0,
            'agr[StickerNumber]' => $order['blank_number'],
            'agr[Number]' => '',
            'agr[Product]' => 'ВЗРКон',
            'agr[Date]' => $date_now,
            'agr[BegDate]' => $order['date_from'],
            'agr[EndDate]' => $order['date_to'],
            'agr[Summ]' => $order['rate_price'] * $order['rate_coefficient'],
            'agr[Customer][CustomerName]' => $order['last_name'] . ' ' . $order['name'],
            'agr[Customer][CustomerFullName]' => $order['last_name'] . ' ' . $order['name'],
            'agr[Customer][CustomerFName]' => '',
            'agr[Customer][CustomerLName]' => '',
            'agr[Customer][CustomerSName]' => '',
            'agr[Customer][CustomerType]' => 'person',
            'agr[Customer][CustomerCode]' => $order['inn'],
            'agr[Customer][CustomerBDate]' => $order['birthday'],
            'agr[Customer][CustomerForeigner]' => 'false',
            'agr[Customer][CustomerPersonWithoutCode]' => 'false',
            'agr[Customer][CustomerPhone]' => $gardian_phone,
            'agr[Customer][CustomerAddress]' => $order['address'],
            'agr[Customer][CustomerAddressLat]' => $order['address'],
            'agr[Customer][CustomerPassport][DocType]' => '',
            'agr[Customer][CustomerPassport][DocSeries]' => '',
            'agr[Customer][CustomerPassport][DocNumber]' => '',
            'agr[Customer][CustomerPassport][DocDate]' => '',
            'agr[Customer][CustomerPassport][DocSourceOrg]' => '',
            'agr[Customer][CustomerDriversLicense][DocType]' => '',
            'agr[Customer][CustomerDriversLicense][DocSeries]' => '',
            'agr[Customer][CustomerDriversLicense][DocNumber]' => '',
            'agr[Customer][CustomerDriversLicense][DocDate]' => '0001-01-01T00:00:00',
            'agr[Customer][CustomerDriversLicense][DocSourceOrg]' => '',
            'agr[Customer][CustomerPreferentialDocument][DocType]' => '',
            'agr[Customer][CustomerPreferentialDocument][DocSeries]' => '',
            'agr[Customer][CustomerPreferentialDocument][DocNumber]' => '',
            'agr[Customer][CustomerPreferentialDocument][DocDate]' => '0001-01-01T00:00:00',
            'agr[Customer][CustomerPreferentialDocument][DocSourceOrg]' => '',
            'agr[Customer][CustomerInternationalPassport][DocType]' => 'InternationalPassport',
            'agr[Customer][CustomerInternationalPassport][DocSeries]' => $passport_series,
            'agr[Customer][CustomerInternationalPassport][DocNumber]' => $passport_number,
            'agr[Customer][CustomerInternationalPassport][DocDate]' => '0001-01-01',
            'agr[Customer][CustomerInternationalPassport][DocSourceOrg]' => '',
            'agr[Customer][CustomerNameLat]' => $order['last_name'] . ' ' . $order['name'],
            'agr[Customer][CustomerIncorrectCode]' => 'false',
            'agr[Customer][CustomerContactPerson]' => '',
            'agr[Customer][CustomerBankAccount]' => '',
            'agr[Customer][CustomerGUID]' => '',
            'agr[Customer][CustomerCitizenshipCountry][EnumVal]' => '',
            'agr[Customer][CustomerCitizenshipCountry][EnumName]' => '',
            'agr[Customer][CustomerCitizenshipCountry][EnumFlag]' => 'false',
            'agr[Customer][CustomerCitizenshipCountry][EnumRate]' => 0,
            'agr[Customer][CustomerEmail]' => $order['email'],
            'agr[Customer][CustomerEDDRCode]' => '',
            'agr[Customer][CustomerGender]' => $sex,
            'agr[Beneficiary]' => '',
            'agr[BeneficiaryIsCustomer]' => 'false',
            'agr[Srok]' => 0,
            'agr[BonusMalus]' => 0,
            'agr[Zone]' => 0,
            'agr[Objects][0][Mark]' => '',
            'agr[Objects][0][Model]' => '',
            'agr[Objects][0][VIN]' => '',
            'agr[Objects][0][RegNum]' => '',
            'agr[Objects][0][YearOfCreation]' => 0,
            'agr[Objects][0][Type]' => '',
            'agr[Objects][0][ObjectGUID]' => '',
            'agr[Objects][0][Name]' => $order['last_name'] . ' ' . $order['name'],
            'agr[Objects][0][NameLat]' => $order['last_name'] . ' ' . $order['name'],
            'agr[Objects][0][Date]' => $order['birthday'],
            'agr[Objects][0][InternationalPassport][DocType]' => '',
            'agr[Objects][0][InternationalPassport][DocSeries]' => $passport_series,
            'agr[Objects][0][InternationalPassport][DocNumber]' => $passport_number,
            'agr[Objects][0][InternationalPassport][DocDate]' => '0001-01-01T00:00:00',
            'agr[Objects][0][InternationalPassport][DocSourceOrg]' => '',
            'agr[Objects][0][Address]' => $order['address'],
            'agr[Objects][0][Phone]' => $gardian_phone,
            'agr[Objects][0][DecimalOption1]' => $order['rate_price'] * $order['rate_coefficient'],
            'agr[Objects][0][DecimalOption2]' => 0,
            'agr[Objects][0][AddressLat]' => $order['address'],
            'agr[Objects][0][ObjType]' => '',
            'agr[Objects][0][StringOption1]' => '',
            'agr[UnusedMonthes][M1]' => 'false',
            'agr[UnusedMonthes][M2]' => 'false',
            'agr[UnusedMonthes][M3]' => 'false',
            'agr[UnusedMonthes][M4]' => 'false',
            'agr[UnusedMonthes][M5]' => 'false',
            'agr[UnusedMonthes][M6]' => 'false',
            'agr[UnusedMonthes][M7]' => 'false',
            'agr[UnusedMonthes][M8]' => 'false',
            'agr[UnusedMonthes][M9]' => 'false',
            'agr[UnusedMonthes][M10]' => 'false',
            'agr[UnusedMonthes][M11]' => 'false',
            'agr[UnusedMonthes][M12]' => 'false',
            'agr[OTKFlag]' => 'false',
            'agr[OTK6Flag]' => 'false',
            'agr[OTKDate]' => '0001-01-01T00:00:00',
            'agr[Preference]' => '',
            'agr[Franchise]' => $rate_franchise_number,
            'agr[OSAGOValues][K1]' => 0,
            'agr[OSAGOValues][K2]' => 0,
            'agr[OSAGOValues][K3]' => 0,
            'agr[OSAGOValues][K4]' => 0,
            'agr[OSAGOValues][K5]' => 0,
            'agr[OSAGOValues][K6]' => 0,
            'agr[OSAGOValues][K7]' => 0,
            'agr[OSAGOValues][K8]' => 0,
            'agr[OSAGOValues][K9]' => 0,
            'agr[PayDate]' => '0001-01-01T00:00:00',
            'agr[PayDoc]' => '',
            'agr[RegistrationPlace]' => '',
            'agr[StazhDo3Let]' => 'false',
            'agr[CommerceUse]' => 'false',
            'agr[Status]' => $gardian_status,
            'agr[Deleted]' => 'false',
            'agr[ParentAgreementGUID]' => '',
            'agr[ParentAgreementNumber]' => '',
            'agr[ParentAgreementDate]' => '0001-01-01T00:00:00',
            'agr[CrossAgreementGUID]' => '',
            'agr[CrossAgreementNumber]' => '',
            'agr[CrossAgreementDate]' => '0001-01-01T00:00:00',
            'agr[BlankStatus]' => '',
            'agr[SalesChannelGUID]' => 'bd909c32_2b2a_11eb_b19b_00155df66a18', // Канал продажу: Агентський - Агенти-вільний ринок  (Всегда)
            'agr[SalesChannelParentGUID]' => '',
            'agr[Partner]' => '',
            'agr[ParkDiscount]' => 0,
            'agr[ParkDiscountStr]' => '',
            'agr[BMR]' => 'false',
            'agr[ValidationCode]' => '',
            'agr[Countries]' => '047c8592-4e59-11eb-b19c-00155df66a18', // Територія покриття: Європа / Europe (Всегда)
            'agr[Country]' => '',
            'agr[PaymentSchedule][0][PaymentNum]' => 0,
            'agr[PaymentSchedule][0][PaymentDate]' => '0001-01-01T00:00:00',
            'agr[PaymentSchedule][0][PaymentSum]' => 0,
            'agr[SpecialTariff]' => 'false',
            'agr[MultiUse]' => 'false',
            'agr[BoolOption1]' => 'false',
            'agr[BoolOption2]' => 'true',
            'agr[BoolOption3]' => 'false',
            'agr[BoolOption4]' => 'false',
            'agr[BoolOption5]' => 'false',
            'agr[StringOption1]' => '',
            'agr[StringOption2]' => '',
            'agr[Currency]' => 'EUR',
            'agr[AgreementType]' => '',
            'agr[DurationType]' => $order['count_days'],
            'agr[KV]' => 0,
            'agr[Summ1]' => $gardian_rate_insured_sum,
            'agr[Summ2]' => 0,
            'agr[Summ3]' => 0,
            'agr[Summ4]' => 0,
            'agr[Summ5]' => 0,
            'agr[Tariff]' => 0,
            'agr[Prem1]' => $order['rate_price'] * $order['rate_coefficient'],
            'agr[Prem2]' => 0,
            'agr[Prem3]' => 0,
            'agr[Prem4]' => 0,
            'agr[Prem5]' => 0,
            'agr[Corr1]' => 0,
            'agr[Corr2]' => 0,
            'agr[Corr3]' => 0,
            'agr[CurrencyRate]' => $currencyRate,
            'agr[TerritorySPType]' => '',
            'agr[Sighner][EnumVal]' => '',
            'agr[Sighner][EnumName]' => '',
            'agr[Sighner][EnumFlag]' => 'false',
            'agr[Sighner][EnumRate]' => 0,
            'agr[ProxyDoc][EnumVal]' => '',
            'agr[ProxyDoc][EnumName]' => '',
            'agr[ProxyDoc][EnumFlag]' => 'false',
            'agr[ProxyDoc][EnumRate]' => 0,
            'agr[MaxTariff]' => 'false',
            'agr[IsPaid]' => 'false',
            'agr[Agent][EnumVal]' => '',
            'agr[Agent][EnumName]' => '',
            'agr[Agent][EnumFlag]' => 'false',
            'agr[Agent][EnumRate]' => 0,
            'agr[ProductGUID]' => $gardian_product_id,
            'agr[TariffProp]' => '',
            'agr[Digital]' => $blankType,
            'agr[Password]' => '',
            'agr[UsedBlanks]' => ''
        ];


        $gardian_data['agr[GUID]'] = $gardian_order['gardian_GUID'];
        $gardian_data['agr[Customer][CustomerGUID]'] = $gardian_order['gardian_CustomerGUID'];
        $gardian_data['agr[Number]'] = $gardian_order['gardian_Number'];
        $gardian_data['agr[BlankNumber]'] = explode("-", $gardian_order['gardian_Number'])[1];
        $gardian_data['agr[Objects][0][ObjectGUID]'] = $gardian_order['gardian_ObjectGUID'];


        return $gardian_data;

    }

    //Получаем данные договора
    public function get_order( $order_id )
    {

        require($_SERVER['DOCUMENT_ROOT'].'/wp-load.php');

        global $wpdb;

        $table_name = $wpdb->get_blog_prefix() . 'insurance_orders';

        $order_data = $wpdb->get_row($wpdb->prepare("SELECT * FROM " . $table_name . " WHERE id = %d ", $order_id), ARRAY_A);

        return $order_data;
    }

}