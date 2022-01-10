<?php

function user_covid_visible_status_update( $user_id )
{

    require_once "class-user-covid-visible.php";

    $companies = new classUserCovidVisible();

    $data = $companies->get_covid_companies( 2 );

    $user_roles = $_POST['role'];

    if( $user_roles == 'user_manager' )
    {
        foreach ( $data as $company )
        {
            update_user_meta( $user_id, 'user_covid_company_visible_status_' . $company['id'], isset($_POST['user_covid_company_visible_status_'.$company['id']]));
        }
    }




}