<?php

class GardianElectron
{
    const FILE_COOKIES = 'cookies_gardian_electron.txt';
    public $username = "Новосад_ОП";
    public $password = "TMK6xGVuw1";
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

}