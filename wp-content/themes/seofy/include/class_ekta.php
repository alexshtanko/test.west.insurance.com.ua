<?php

class Ekta {
    const FILE_COOKIES = 'cookies_ekta.txt';
//    public $username = "vpodgurets";
//    public $password = "7051985";
    public $username = "";
    public $password = "";
    public $loginUrl = "https://agent.insurs.online/auth/checking_login";
    public $createOrderUrl = "https://agent.insurs.online/handler/createOrder";
    public $path;

    public function __construct($path) {
        $this->path = $path;
    }

    public function login(){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->loginUrl);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_SSLVERSION, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch,CURLOPT_COOKIEJAR, $this->path.DIRECTORY_SEPARATOR.self::FILE_COOKIES);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query(["user_login" => $this->username, "user_password" => $this->password], '', '&'));
        curl_exec($ch);
        $httpResponseCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        return $httpResponseCode;
    }

    public function createOrder($order){
        $data = is_array($order) ? json_encode($order) : $order;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->createOrderUrl);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_SSLVERSION, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch,CURLOPT_COOKIEFILE, $this->path.DIRECTORY_SEPARATOR.self::FILE_COOKIES);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        $response = curl_exec($ch);
        $httpResponseCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if($httpResponseCode == 200){
            return $response;
        }
        else {
            return json_encode(['success' => false, 'error' => 'Невірна відвовідь сервера. Спробуйте ще раз.']);
        }
    }


    //Добавление информации о договоре в БД
    public function add_order_data( $data )
    {
        require($_SERVER['DOCUMENT_ROOT'].'/wp-load.php');

        global $wpdb;

        $table_name = $wpdb->get_blog_prefix() . 'insurance_ekta_orders';

        $query = $wpdb->insert(
            $table_name,
            array(
                'ekta_id' => $data['ekta_id'],
                'ekta_order_id' => $data['ekta_order_id'],
                'ekta_cost' => $data['ekta_cost'],
                'order_id' => $data['order_id'],
                'status' => $data['status']
            ),
            array( '%d', '%d', '%f', '%d', '%d' )
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

    //Удаление застрахованих персон с договора
    public function remove_insurer_order( $order_id )
    {
        require($_SERVER['DOCUMENT_ROOT'].'/wp-load.php');

        global $wpdb;

        $table_name = $wpdb->get_blog_prefix() . 'insurance_insurer';

        $wpdb->delete( $table_name, [ 'order_id'=> $order_id ], [ '%d' ] ); // 1 будет обработано как число (%d).
    }

    /*Получаем данные договора c CK EKTA
    * RETURN ARRAY
    */
    public function get_ekta_order( $order_id )
    {

        require($_SERVER['DOCUMENT_ROOT'].'/wp-load.php');

        global $wpdb;

        $table_name = $wpdb->get_blog_prefix() . 'insurance_ekta_orders';

        $order_data = $wpdb->get_row($wpdb->prepare("SELECT * FROM " . $table_name . " WHERE order_id = %d ", $order_id), ARRAY_A);

        return $order_data;
    }

    /*Получаем данные договора
    * RETURN ARRAY
    */
    public function get_order( $order_id )
    {

        require($_SERVER['DOCUMENT_ROOT'].'/wp-load.php');

        global $wpdb;

        $table_name = $wpdb->get_blog_prefix() . 'insurance_orders';

        $order_data = $wpdb->get_results($wpdb->prepare("SELECT * FROM " . $table_name . " WHERE id = %d ", $order_id), ARRAY_A);

        return $order_data;
    }

    /* Получить все застрахованых персон с таблички insurance_insurer
     * RETURN ARRAY
     */
    public function get_insurer( $order_id )
    {
        require($_SERVER['DOCUMENT_ROOT'].'/wp-load.php');

        global $wpdb;

        $table_name = $wpdb->get_blog_prefix() . 'insurance_insurer';

        $order_data = $wpdb->get_results($wpdb->prepare("SELECT * FROM " . $table_name . " WHERE order_id = %d ", $order_id), ARRAY_A);

        return $order_data;
    }

    /*
     * Изменит статус в СК ЕКТА
     */
    public function change_ekta_status( $order_id, $status )
    {

        global $wpdb;

        $table_name_orders = $wpdb->get_blog_prefix() . 'insurance_ekta_orders';

        $date_change = date( 'Y-m-d H:i:s' );

        $result = $wpdb->update( $table_name_orders, [ 'status' => $status, 'date_change' => $date_change ], [ 'order_id' => $order_id ] );
    }

}