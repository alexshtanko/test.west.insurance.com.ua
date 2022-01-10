<?php

function user_insurance_visible_status_update( $user_id )
{

    require_once "class-user-insurance-visible.php";

    $companies = new classUserInsuranceVisible();

    $data = $companies->get_insurance_companies();

    $user_roles = $_POST['role'];

    if( $user_roles == 'user_manager' )
    {
        foreach ( $data as $company )
        {
            update_user_meta( $user_id, 'user_insurance_company_visible_status_' . $company['id'], isset($_POST['user_insurance_company_visible_status_'.$company['id']]));
        }
    }




}