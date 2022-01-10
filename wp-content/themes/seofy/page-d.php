<?php
//require 'include/class-blank.php';


/**
 * The template for manager page
 * Template Name: Medical менеджер
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Seofy
 * @since 1.0
 * @version 1.0
 */




$current_user = wp_get_current_user();
if( $current_user->ID ) {
    $user          = wp_get_current_user();
    $allowed_roles = array( 'user_manager', 'administrator' );

    global $wpdb;


    /*$orders = $wpdb->get_results("
    SELECT DISTINCT o.id, o.user_id FROM plc_insurance_orders o 
    LEFT JOIN plc_insurance_blank_to_manager btm ON btm.manager_id = o.user_id 
    AND o.blank_number BETWEEN btm.number_start AND btm.number_end 
    WHERE o.date_added >= '2021-06-01' AND o.date_added <= '2021-07-01' ORDER BY o.user_id ASC;",
    ARRAY_A);*/

    //$orders = $wpdb->get_results("SELECT o.user_id FROM `plc_insurance_orders` o WHERE o.date_added >= '2021-07-16';", ARRAY_A);
    $u = get_parents_id( 122 );
//    var_dump($u);
    $orders = d_get_order();
//     echo '<pre>';
//     var_dump( $orders );

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
                            <td>Входит в диапазон бланков</td>
                            <td>Данные дампазона</td>
                        </tr>
                    </thead>
                    <tbody>';
    $i = 1;
    foreach ( $orders as $order ){

        $users = get_parents_id( $order['user_id'] );

        //Проверяем вхождения номера бланка в диапазон бланков
        $diapazon_status = 'Не входит или статус 0';
        $diapazon_status_data = check_blank_diapazon( $order['blank_number'], $order['blank_series'], $order['company_id'] );

//        echo '<pre>';
//        var_dump($diapazon_status_data);
//        echo '</pre>';

        if( ! empty( $diapazon_status_data ) )
        {
            $diapazon_status = 'Входит, ID: ';
        }
        else{

            $check_blank_diapazon_status = check_blank_diapazon_status( $order['blank_number'], $order['blank_series'], $order['company_id'] );

            $str = blank_diapazon( $check_blank_diapazon_status );
//            echo '<pre>';
//            var_dump($check_blank_diapazon_status);
//            echo '</pre>';

            $result .= '<tr>
                        <td>'. $i .'</td>
                        <td>'.$order['id'].'</td>
                        <td>'.$order['number_blank_id'].'</td>
                        <td>'.$order['blank_number'].'</td>
                        <td>'.$order['user_id'].'</td>
                        <td>'.$users.'</td>
                        <td>'.$order['date_added'].'</td>
                        <td>'.$diapazon_status.' ' . $diapazon_status_data[0]['id'].'</td>
                        <td>'.$str.'</td>
                    </tr>';


        }



        $i ++;
    }

    $result .= '</tbody></table>';

    echo $result;
}
else{
    echo 'www';
}


function d_get_order( $statrt = 1, $stop = 9999999 ){

    global $wpdb;

    $result = $wpdb->get_results("
                                SELECT o.id, o.number_blank_id, o.blank_number, o.user_id, o.date_added, o.company_id, o.blank_series  
                                FROM `plc_insurance_orders` o 
                                WHERE o.date_added >= '2021-01-01' AND o.date_added <= '2021-02-17';", ARRAY_A);

    return $result;
}


function check_blank_diapazon( $blank_number, $blank_series, $company_id ){

    global $wpdb;

    $table_name_number_of_blank = 'plc_insurance_number_of_blank';

    $result = $wpdb->get_results("
                                SELECT id, comments, status  
                                FROM " . $table_name_number_of_blank . " 
                                WHERE company_id = " . $company_id . " 
                                AND blank_series = '" . $blank_series . "' 
                                AND " . $blank_number . " >= number_start 
                                AND " . $blank_number . " <= number_end
                                AND status = 1", ARRAY_A);

    return $result;
}

function check_blank_diapazon_status( $blank_number, $blank_series, $company_id ){

    global $wpdb;

    $table_name_number_of_blank = 'plc_insurance_number_of_blank';

    $result = $wpdb->get_results("
                                SELECT *  
                                FROM " . $table_name_number_of_blank . " 
                                WHERE company_id = " . $company_id . " 
                                AND blank_series = '" . $blank_series . "' 
                                AND " . $blank_number . " >= number_start 
                                AND " . $blank_number . " <= number_end", ARRAY_A);

    return $result;
}

function blank_diapazon( $blanks ){

    $result = '';
    foreach ( $blanks as $blank )
    {

        $result .=
            'ID: ' . $blank['id'] .
            '&nbsp;&nbsp;&nbsp;&nbsp;'. $blank['number_start'] .
            ' ... ' . $blank['number_end'].
            ' blank_type_id: ' . $blank['blank_type_id'] . ' <b>Status: ' .$blank['status'] . '</b><br>';

    }


    return $result;
}

