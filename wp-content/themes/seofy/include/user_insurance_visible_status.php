<?php

function user_insurance_visible_status_show( $user_data )
{

    require_once "class-user-insurance-visible.php";

    $user = new classUserInsuranceVisible();

    $data = $user->get_insurance_companies();

    $companies_html = $user->render_insurance_companies( $data, $user_data );

    echo $companies_html;

}