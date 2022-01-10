<?php
/*
 * Вспомогательный клас в котором собраны часто повтояющиеся операции
 * */
class Insurance_Admin_Help
{

    public function __construct()
    {
    }

    /*
     * Расчитываем наценку в зависимости от СТРАХОВОЙ КОМПАНИИ
     * $company_id - id страховой компании
     * $rate_price - цена договора (без наценок)
     * $insurer_age_coefficient - возрастной коэффициент
     * $rate_price_coefficient - наценка менеджера
     *
     * return float
     * */
    public function company_price_coeficient( $company_id, $rate_price, $insurer_age_coefficient = 1, $rate_price_coefficient = 1 )
    {

        //СК ПРОВІДНА
        if( $company_id == 1 ){


            //Наценка в зависимости от возрастного коэффициента
            $insurer_rate_price = $rate_price * $insurer_age_coefficient;
            $insurer_rate_price = round( $insurer_rate_price, 2 );

            //Расчет цены в зависимости от коэффициента наценки менеджера
            //Для компании "Провідна" ID = 1
            //Изначально надо уменьшить стоимость на 20%
            //Потом увеличиваем на выбраный коэффициент

            if( $company_id == 1 && $rate_price_coefficient != 1 ){
                $insurer_rate_price = $insurer_rate_price / 1.2;
                $insurer_rate_price = $insurer_rate_price * $rate_price_coefficient;
                $insurer_rate_price = round( $insurer_rate_price, 2 );
            }

        }
        //СК ГАРДІАН
        elseif(  $company_id == 2 ){

            $insurer_rate_price = $rate_price * $insurer_age_coefficient;
            $insurer_rate_price = round( $insurer_rate_price, 2 );
            
        }
        // СК ИНТЕРПЛЮС
        elseif( $company_id == 5 )
        {
            $insurer_rate_price = $rate_price * $insurer_age_coefficient;
            $insurer_rate_price = round( $insurer_rate_price, 2 );
        }
        //ІНШІ
        else{

            $insurer_rate_price = $rate_price * $insurer_age_coefficient;
            $insurer_rate_price = round( $insurer_rate_price, 2 );
//            $insurer_rate_price = $rate_price;

        }

        return $insurer_rate_price;

    }



    /*
     * Получаем всех пользователей по РОЛИ и добавляем статус видимости указаной СК = 1
     */
    public  function updateUserInsuranceVisibleCompany( $role = 'user_manager', $company_id = 0 )
    {

        if( $company_id )
        {
            $arg = [
                'role__in' => [$role],
            ];
            $users = get_users( $arg );

            if( $users )
            {
                foreach ( $users as $user ) {

                    $st = update_user_meta( $user->ID, 'user_insurance_company_visible_status_' . $company_id, 1);

                }
            }
        }

    }

}