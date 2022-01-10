<?php

/*
 * Изменение статуса договора и сохранение в БД нового статуса договора и времени изменения
 *
 */
require($_SERVER['DOCUMENT_ROOT'].'/wp-load.php');

require_once $_SERVER['DOCUMENT_ROOT']."wp-content/themes/seofy/include/class-euroins.php";

//require_once $_SERVER['DOCUMENT_ROOT'].'wp-content/wp-recall/add-on/insurance/class/insurance.php';

$key = 'WPbm49ebf124';

if ( $key == $_GET['key'] ) {

    $current_date = date( 'Y-m-d' );

    $euroins = new Euroins();

    //Получаем все договора текущей даты
    $orders = $euroins->get_orders_data( $current_date, $current_date );

    if( ! empty( $orders ) )
    {
        foreach ( $orders as $order )
        {

            $order_status = $euroins->get_order( $order['order_id'] );

            if( ! empty( $order_status ) )
            {
                // договор ЗАКЛЮЧЕН

                if( $order_status[0]['status'] == 1 )
                {

                    $insuranceApplicationID = $order['insuranceApplicationID'];

                    //Отправляем на подтверждение статуса договора
                    $status = $euroins->confirm( $insuranceApplicationID );

//                    //Если договор подтвержден, меняем статус у нас в БД
                    if( $status == 200 )
                    {

                        $result = $euroins->change_order_status( $order['order_id'], 1 );
                    }

                }
            }

        }
    }

}
else
{
    echo 'Ключ не совпадает!';
}