<?php

function user_insurance_visible_status_delete( $user_id )
{

    require_once "class-user-insurance-visible.php";

    $class = new classUserInsuranceVisible();

    $class->remove_user_insurance_visible_status( $user_id );

}