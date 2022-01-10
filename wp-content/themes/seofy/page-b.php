<?php

$current_user = wp_get_current_user();
if( $current_user->ID ) {

    $orders = d_get_order();

    /*$txt = "122,100,100,7";

    $user_string_id = get_parents_id( 122 );
    $user_string_id = $user_string_id . '';

    var_dump($user_string_id);

    echo '<br><br><br><br><br><br>';

    $dd = $wpdb->get_results("SELECT id FROM `plc_insurance_blank_to_manager` 
WHERE `manager_id` IN (".$user_string_id.") 
  AND `number_of_blank_id`=73 
  AND 278890 >= `number_start` 
  AND 278890 <= `number_end`;", ARRAY_A);
    if( ! empty( $dd ) ){
        echo 'НЕ пустое';
    }
    var_dump($dd);*/
    $i = 1;
    global $wpdb;
    $table_blank_to_manager = 'plc_insurance_blank_to_manager';



    $user_string_id = '';
    $result = '';
    $result = '<table border>
                    <thead>
                        <tr>
                            <td>#</td>
                            <td>ID договора</td>
                            <td>Номер бланка</td>
                            <td>Номер договора</td>
                            <td>Id менеджера</td>
                            <td>ID менеджеров</td>
                            <td>Время заключения договора</td>
                            <td>Status</td>
                        </tr>
                    </thead>
                    <tbody>';

    foreach ( $orders as $order ){


        $user_string_id = get_parents_id( $order['user_id'] );

        if ($user_string_id == '') {
            $user_string_id = $order['user_id'];
        }


        /*
         * Проверяем принадлежит ли номер договора (заявки) менеджеру или его партнеру (т.е. вышестоящему менеджеру)
         * */
        $has_manager_blank = $wpdb->get_results("SELECT id FROM " . $table_blank_to_manager . " 
        WHERE 
        manager_id IN (" . $user_string_id . ") 
        AND number_of_blank_id=" . $order['number_blank_id'] . " 
        AND " . $order['blank_number'] . " >= number_start 
        AND " . $order['blank_number'] . " <= number_end", ARRAY_A);

/*
        $has_manager_blank = $wpdb->get_results("SELECT id FROM " . $table_blank_to_manager . " 
        WHERE 
        manager_id IN (" . $user_string_id . ") 
        AND number_of_blank_id=" . $order['number_blank_id'] . " 
        AND " . $order['blank_number'] . " >= number_start 
        AND " . $order['blank_number'] . " <= number_end
        AND status = 1",
            ARRAY_A);

*/
/*
        $has_manager_blank = $wpdb->get_results("SELECT id FROM " . $table_blank_to_manager . "
        WHERE
        manager_id IN (" . $user_string_id . ")
        AND number_of_blank_id=" . $order['number_blank_id'] . "
        AND " . $order['blank_number'] . " >= number_start
        AND " . $order['blank_number'] . " <= number_end
        AND status = 0",
            ARRAY_A);
*/
        /*
         * Если договор не принадлежит менеджеру или его партнерам, то выводим его данные
         * */

//        if( $order['user_id'] == 122 ){
            if ( empty( $has_manager_blank ) ) {

                $result .= '<tr>
                        <td>'. $i .'</td>
                        <td>'.$order['id'].'</td>
                        <td>'.$order['number_blank_id'].'</td>
                        <td>'.$order['blank_number'].'</td>
                        <td>'.$order['user_id'].'</td>
                        <td>'.$user_string_id.'</td>
                        <td>'.$order['date_added'].'</td>
                        <td>'.$has_manager_blank['status'].'</td>
                    </tr>';

                $i++;

            }
//        }

    }

    $result .= '</tbody></table>';

    echo $result;

}

function d_get_order( $statrt = 1, $stop = 9999999 ){

    global $wpdb;

    $result = $wpdb->get_results("
                                SELECT o.id, o.number_blank_id, o.blank_number, o.user_id, o.date_added, o.company_id, o.blank_series  
                                FROM `plc_insurance_orders` o 
                                WHERE o.date_added >= '2021-01-01' AND o.blank_type_id = 1;", ARRAY_A);

    return $result;
}