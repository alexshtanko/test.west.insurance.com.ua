<?php

function user_covid_visible_status_delete( $user_id )
{

    require_once "class-user-covid-visible.php";

    $class = new classUserCovidVisible();

    $class->remove_user_covid_visible_status( $user_id );

}