<?php

class classUserCovidVisible
{

    /*
     * Получаем све СТРАХОВЫЕ КОМПАНИИ
     * 1 - Страхование
     * 2 - Covid2019
     * return ARRAY
     */
    public function get_covid_companies( $table = 2 )
    {
        global $wpdb;

        $table_company = '';

        if( $table == 1){
            $table_company = $wpdb->prefix . "insurance_company";
        }
        elseif( $table == 2 ){
            $table_company = $wpdb->prefix . "covid_company";
        }

        $result = [];

        $result = $wpdb->get_results("SELECT * FROM ".$table_company." WHERE status = 1 ;", ARRAY_A);

        return $result;
    }


    /*
     * Отрисовываем СТРАХОВЫЕ КОМПАНИИ
     * return HTML
     */
    public function render_covid_companies( $data, $user_data )
    {
        $result = '';

        $user_id = (int)$user_data->data->ID;

        if( ! empty( $data ) )
        {
            $result .= '<br><h2>Видимiсть страхових компанiй (COVID)</h2>';
            $result .= '<table class="form-table" style="width: 400px;">';
            $result .= '<thead>';
            $result .= '<tr><td>Назва компанiї</td><td>Вiдображати?</td></tr>';
            $result .= '</thead>';
            $result .= '<tbody>';

            foreach( $data as $company )
            {

                $meta = get_user_meta( $user_id, 'user_covid_company_visible_status_' .$company['id'], true );

                if( $meta == 1 )
                {
                    $result .= '<tr data="'.$meta.'"><td><label>'. $company['title'].'</label></td><td><input name="user_covid_company_visible_status_'.$company['id'].'" id="user_covid_company_visible_status_'.$company['id'].'" type="checkbox" checked></td></tr>';
                }
                else
                {
                    $result .= '<tr data="'.$meta.'"><td><label>'. $company['title'].'</label></td><td><input name="user_covid_company_visible_status_'.$company['id'].'" id="user_covid_company_visible_status_'.$company['id'].'" type="checkbox"></td></tr>';
                }

            }

            $result .= '</tbody>';
            $result .= '</table>';
        }

        return $result;
    }

    /*
     * Удаляем произвольные поля видимости пользователем СК
     */
    public function remove_user_covid_visible_status( $user_id )
    {
        global $wpdb;

        $table_company = $wpdb->prefix . "usermeta";

        $result = '';

        if( $user_id )
        {
            $result = $wpdb->delete( $table_company, [ 'user_id' => $user_id ] );
        }

        return $result;
    }

}