<?php

require($_SERVER['DOCUMENT_ROOT'].'/wp-load.php');
require_once '../admin/include/class-covid-admin-orders.php';

$key = 'sqrNKT7A$U49A';
require ABSPATH . '/vendor/autoload.php';

//Check key to run the script
if ( $key == $_GET['key'] ){

    $order_id = (int)$_GET['order_id'];
    $status = (int)$_GET['status'];
    $unicue_code = $_GET['unicue_code'];
   /* echo '<pre>';
echo '$order_id';
    var_dump( $order_id );
    echo '$status';
    var_dump( $status );
    echo '$unicue_code';
    var_dump( $unicue_code );*/


    if( !empty ( $order_id ) && $status != '' && ! empty( $unicue_code ) ){

        global $wpdb;

        $table_name_orders = $wpdb->get_blog_prefix() . 'covid_orders';

        $result = $wpdb->update( $table_name_orders, ['status' => $status], ['id' => $order_id, 'unicue_code' => $unicue_code] );

        $class_order = new Covid_Admin_Orders();
        //для поиска по ТАБЛИЧКИ ЭЛЕКТРОННЫХ
        $blank_type_data = $class_order->get_order_blank_type_id($order_id);
        $e_status = $status != 1 ? 0 : 1;


        $class_order->set_status_e_blank($blank_type_data[0]['number_blank_id'], $blank_type_data[0]['blank_number'], $e_status);


        if( $result != false ){

            echo 'Статус був успiшно замiнений';

        }
        else{
            echo 'Не знайдено договору для змiни статусу. ';
        }


    }
    else{
        echo 'Помилка. Не всi данi було передано.';
    }

}
else{
    echo 'Невiрний ключ.';
}

//oBui8BDicURg
//fUoSoaojLN3X