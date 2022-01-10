<?php

/*
 * Изменение статуса договора и сохранение в БД нового статуса договора и времени изменения
 *
 */
require($_SERVER['DOCUMENT_ROOT'].'/wp-load.php');

require_once $_SERVER['DOCUMENT_ROOT']."wp-content/themes/seofy/include/class-euroins.php";

$key = 'WPbm49ebf124';

if ( $key == $_GET['key'] ) {

    $current_date = date( 'Y-m-d' );

    $euroins = new Euroins();

    //Получаем все договора текущей даты
    $orders = $euroins->get_orders_data( $current_date, $current_date );

    $orders_id = '';

    //Если есть неоформленные договора, то заполняем данные для отправки Email
    if( ! empty( $orders ) )
    {
        $count = count( $orders );

        foreach ( $orders as $order )
        {

            $orders_id .= '<p> ID: ' . $order['order_id'] . '</p>';

        }
    }

    $status = $euroins->send_email( $orders_id, $count );

}
else
{
    echo 'Ключ не совпадает!';
}