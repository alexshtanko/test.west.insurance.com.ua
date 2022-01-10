<?php

function user_covid_visible_status_show( $user_data )
{

    require_once "class-user-covid-visible.php";

    $user = new classUserCovidVisible();

    $data = $user->get_covid_companies();

    $companies_html = $user->render_covid_companies( $data, $user_data );

    echo $companies_html;

}