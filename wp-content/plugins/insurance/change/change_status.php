<?php

require($_SERVER['DOCUMENT_ROOT'].'/wp-load.php');
require_once '../admin/include/class-insuranse-admin-orders.php';
$key = 'sqrNKT7A$U49A';
require ABSPATH . '/vendor/autoload.php';

//Check key to run the script
if ( $key == $_GET['key'] ){

    $order_id = (int)$_GET['order_id'];
    $status = $_GET['status'];
    $unicue_code = $_GET['unicue_code'];

    if( !empty ( $order_id ) && $status != '' && ! empty( $unicue_code ) ){

        global $wpdb;

        $table_name_orders = $wpdb->get_blog_prefix() . 'insurance_orders';

        $result = $wpdb->update( $table_name_orders, ['status' => $status], ['id' => $order_id, 'unicue_code' => $unicue_code] );





        $order_class = new Insurance_Admin_Orders();


        $order_data = $order_class->get_order( $order_id );
        $company_id = $order_data[0]['company_id'];

        //Зменяем статус в СК ЕКТА
        if( $company_id == 6 )
        {
            require_once $_SERVER['DOCUMENT_ROOT'].'wp-content/themes/seofy/include/class_ekta.php';
            $ekta = new Ekta(__DIR__);

            $ekta->change_ekta_status( $order_id, $status );


        }


        //для поиска по ТАБЛИЧКИ ЭЛЕКТРОННЫХ
        $blank_type_data = $order_class->get_order_blank_type_id($order_id);

        $e_status = $status != 1 ? 0 : 1;

        if( $blank_type_data[0]['blank_type_id'] == 2 )
        {
            $order_class->set_status_e_blank($blank_type_data[0]['number_blank_id'], $blank_type_data[0]['blank_number'], $e_status);
        }



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