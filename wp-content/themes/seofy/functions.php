<?php

require 'include/class-blank.php';
require 'include/class-covid-blank.php';
//Euroins
require_once 'include/class-euroins.php';

//EKTA
require_once 'include/class_ekta.php';

//GARDIAN
//require_once 'include/class-gardian-paper.php';
//require_once 'include/class-gardian-electron.php';
require_once 'include/class-gardian.php';

/*
    Add stylesheets and scripts file for get-policy page
*/
function epolicy_scripts() {

    if( is_page( array( 2964 ) ) ){

        wp_enqueue_script( 'bitrix', get_template_directory_uri() . '/js/bitrix.js', array('jquery'), '1.2', true );
    }


    //COVID Calc page
    if( is_page( array( 3057 ) ) ){

        wp_enqueue_style( 'get-policy', get_template_directory_uri() . '/css/get-policy.css?v=1.2.0');
        wp_enqueue_script( 'jquery.maskedinput.min', get_template_directory_uri() . '/js/jquery.maskedinput.min.js', array('jquery'), '1.0', true );
        wp_enqueue_script( 'covid', get_template_directory_uri() . '/js/covid.js', array('jquery'), '1.25', true );
        //add_action( 'wp_enqueue_scripts', 'covid_js', 101 );
    }

    //COVID Calc page TEST
    if( is_page( array( 3065 ) ) ){
        wp_enqueue_style( 'ui', get_template_directory_uri() . '/css/ui/jquery-ui.min.css');
        wp_enqueue_style( 'ui-theme', get_template_directory_uri() . '/css/ui/jquery-ui.theme.min.css');
        wp_enqueue_style( 'get-policy', get_template_directory_uri() . '/css/get-policy.css?v=1.2');
        wp_enqueue_style( 'custom', get_template_directory_uri() . '/css/custom.css');

        wp_enqueue_script( 'jquery', get_template_directory_uri() . '/js/jquery.js', array(), '1124', true );
        wp_enqueue_script( 'ui', get_template_directory_uri() . '/js/ui/jquery-ui.min.js', array('jquery'), '1', true );
        wp_enqueue_script( 'date', get_template_directory_uri() . '/js/build/date.js', array('jquery'), '1', true );
        wp_enqueue_script( 'jquery.maskedinput.min', get_template_directory_uri() . '/js/jquery.maskedinput.min.js', array('jquery'), '1.0', true );
        wp_enqueue_script( 'covid', get_template_directory_uri() . '/js/covid-t.js', array('jquery'), '1.11', true );
        wp_enqueue_style( 'get-policy', get_template_directory_uri() . '/css/get-policy.css?v=1.2');
    }

    //MEDICAL Calc page
    if( is_page( array( 3071 ) ) ){
        wp_enqueue_style( 'get-policy', get_template_directory_uri() . '/css/get-policy.css?v=1.2');
        wp_enqueue_script( 'jquery.maskedinput.min', get_template_directory_uri() . '/js/jquery.maskedinput.min.js', array('jquery'), '1.0', true );
        wp_enqueue_script( 'medical', get_template_directory_uri() . '/js/medical.js', array('jquery'), '1.1', true );
    }

    //MEDICAL Calc manager page 
    if( is_page( array( 3086 ) ) ){
        wp_enqueue_style( 'ui', get_template_directory_uri() . '/css/ui/jquery-ui.min.css');
        wp_enqueue_style( 'ui-theme', get_template_directory_uri() . '/css/ui/jquery-ui.theme.min.css');
        wp_enqueue_style( 'get-policy', get_template_directory_uri() . '/css/get-policy.css', '1.0.3');
        wp_enqueue_style( 'get-medical', get_template_directory_uri() . '/css/get-medical.css', array(), '1.0.13.1');
        wp_enqueue_script( 'jquery.maskedinput.min', get_template_directory_uri() . '/js/jquery.maskedinput.min.js', array('jquery'), '1.0', true );
        wp_enqueue_script( 'ui', get_template_directory_uri() . '/js/ui/jquery-ui.min.js', array('jquery'), '1', true );
        wp_enqueue_script( 'date', get_template_directory_uri() . '/js/build/date.js', array('jquery'), '1', true );

        // wp_enqueue_script( 'validatelocalize', get_template_directory_uri() . '/js/validate/localization/messages_uk.min.js', array('jquery', 'medicalmcreateorder' ), '1', true );
        wp_enqueue_script( 'validateadditional', get_template_directory_uri() . '/js/validate/additional-methods.min.js', array('jquery', 'medicalmcreateorder' ), '1', true );
        wp_enqueue_script( 'validate', get_template_directory_uri() . '/js/validate/jquery.validate.min.js', array('jquery', 'validateadditional' ), '1', true );
        // wp_enqueue_script( 'medical-m', get_template_directory_uri() . '/js/medical-m.js', array('jquery'), '1.1', true );
        // function covid_js(){

        wp_enqueue_script( 'medicalm', get_template_directory_uri() . '/js/medical-m.js', array('jquery'), '1.0.2.3' );

        wp_localize_script( 'medicalm', 'medicalM', array(
            'ajaxurl' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce( 'medical-m' ) // Create nonce which we later will use to verify AJAX request
        ));

        wp_enqueue_script( 'medicalmcreateorder', get_template_directory_uri() . '/js/medical-m-create-order.js', array('jquery'), '1.0.161.19' );

        wp_localize_script( 'medicalmcreateorder', 'medicalmCreateOrder', array(
            'ajaxurl' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce( 'medical-m-create-order' ) // Create nonce which we later will use to verify AJAX request
        ));
        // }

    }

    //covid2019 Calc manager page
    if( is_page( array( 3135 ) ) ){
        wp_enqueue_style( 'ui', get_template_directory_uri() . '/css/ui/jquery-ui.min.css');
        wp_enqueue_style( 'ui-theme', get_template_directory_uri() . '/css/ui/jquery-ui.theme.min.css');
        wp_enqueue_style( 'get-policy', get_template_directory_uri() . '/css/get-policy.css', '1.0.3');
        wp_enqueue_style( 'get-medical', get_template_directory_uri() . '/css/get-medical.css', array(), '1.0.14');
        wp_enqueue_script( 'jquery.maskedinput.min', get_template_directory_uri() . '/js/jquery.maskedinput.min.js', array('jquery'), '1.0', true );
        wp_enqueue_script( 'ui', get_template_directory_uri() . '/js/ui/jquery-ui.min.js', array('jquery'), '1', true );
        wp_enqueue_script( 'date', get_template_directory_uri() . '/js/build/date.js', array('jquery'), '1', true );

        // wp_enqueue_script( 'validatelocalize', get_template_directory_uri() . '/js/validate/localization/messages_uk.min.js', array('jquery', 'medicalmcreateorder' ), '1', true );
        wp_enqueue_script( 'validateadditional', get_template_directory_uri() . '/js/validate/additional-methods.min.js', array('jquery', 'medicalmcreateorder' ), '1', true );
        wp_enqueue_script( 'validate', get_template_directory_uri() . '/js/validate/jquery.validate.min.js', array('jquery', 'validateadditional' ), '1', true );
        // wp_enqueue_script( 'medical-m', get_template_directory_uri() . '/js/medical-m.js', array('jquery'), '1.1', true );
        // function covid_js(){

        wp_enqueue_script( 'medicalm', get_template_directory_uri() . '/js/covid2019.js', array('jquery'), '1.0.2' );

        wp_localize_script( 'medicalm', 'medicalM', array(
            'ajaxurl' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce( 'medical-m' ) // Create nonce which we later will use to verify AJAX request
        ));

        wp_enqueue_script( 'medicalmcreateorder', get_template_directory_uri() . '/js/covid2019-create-order.js', array('jquery'), '1.0.2' );

        wp_localize_script( 'medicalmcreateorder', 'medicalmCreateOrder', array(
            'ajaxurl' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce( 'medical-m-create-order' ) // Create nonce which we later will use to verify AJAX request
        ));
        // }

    }

    //MEDICAL Calc page TEST
    if( is_page( array( 3073 ) ) ){
        wp_enqueue_style( 'ui', get_template_directory_uri() . '/css/ui/jquery-ui.min.css');
        wp_enqueue_style( 'ui-theme', get_template_directory_uri() . '/css/ui/jquery-ui.theme.min.css');
        wp_enqueue_style( 'get-policy', get_template_directory_uri() . '/css/get-policy.css?v=1.2');
        wp_enqueue_style( 'custom', get_template_directory_uri() . '/css/custom.css');

        wp_enqueue_script( 'jquery', get_template_directory_uri() . '/js/jquery.js', array(), '1124', true );
        wp_enqueue_script( 'ui', get_template_directory_uri() . '/js/ui/jquery-ui.min.js', array('jquery'), '1', true );
        wp_enqueue_script( 'date', get_template_directory_uri() . '/js/build/date.js', array('jquery'), '1', true );
        wp_enqueue_script( 'jquery.maskedinput.min', get_template_directory_uri() . '/js/jquery.maskedinput.min.js', array('jquery'), '1.0', true );
        wp_enqueue_script( 'medical', get_template_directory_uri() . '/js/medical-t.js', array('jquery'), '1.1', true );
        wp_enqueue_style( 'get-policy', get_template_directory_uri() . '/css/get-policy.css?v=1.2');
    }



    if( is_page( array( 2930, 2937, 2979, 3033, 3046, 3049 ) ) ){

        // wp_enqueue_style( 'get-font', get_template_directory_uri() . '/css/font-awesome.min.css');

        wp_enqueue_style( 'owl-carousel', get_template_directory_uri() . '/css/owl/owl.carousel.min.css');

        wp_enqueue_style( 'owl-theme', get_template_directory_uri() . '/css/owl/owl.theme.default.min.css');

        wp_enqueue_style( 'ui', get_template_directory_uri() . '/css/ui/jquery-ui.min.css');

        wp_enqueue_style( 'ui-theme', get_template_directory_uri() . '/css/ui/jquery-ui.theme.min.css');

        wp_enqueue_style( 'get-policy', get_template_directory_uri() . '/css/get-policy.css', array(), '1.16' );

        wp_enqueue_style( 'custom', get_template_directory_uri() . '/css/custom.css');



        wp_enqueue_script( 'jquery', get_template_directory_uri() . '/js/jquery.js', array(), '1124', true );

        wp_enqueue_script( 'jquery-owl', get_template_directory_uri() . '/js/owl/owl.carousel.min.js', array('jquery'), '1', true );

        wp_enqueue_script( 'ui', get_template_directory_uri() . '/js/ui/jquery-ui.min.js', array('jquery'), '1', true );

        wp_enqueue_script( 'date', get_template_directory_uri() . '/js/build/date.js', array('jquery'), '1', true );

        wp_enqueue_script( 'jquery.maskedinput.min', get_template_directory_uri() . '/js/jquery.maskedinput.min.js', array('jquery', 'date'), '1.0', true );

    }

    if( is_page( array( 2930, 2937 ) ) ){
        $current_user = wp_get_current_user();
        if( $current_user->ID ) {
            //$user = new WP_User( $current_user->ID );
            //$user_roles = $user->roles;

            $user          = wp_get_current_user();
            $allowed_roles = array( 'user_manager' );

            if ( array_intersect( $allowed_roles, $user->roles ) ) {
                wp_redirect( "/get-policy-m" );
                exit;
            }

        }

        wp_enqueue_script( 'get-policy-js', get_template_directory_uri() . '/js/get-policy.js', array('jquery', 'date'), '3.0.7', true );
    }

    if( is_page( array( 3049 ) ) ){
        wp_enqueue_script( 'get-policy-js', get_template_directory_uri() . '/js/get-policy-t.js', array('jquery', 'date'), '2.39', true );
    }

    if( is_page( array( 3046 ) ) ){
        wp_enqueue_script( 'get-policy-js', get_template_directory_uri() . '/js/get-policy-t.js', array('jquery', 'date'), '2.58', true );
    }

    if( is_page( array( 2979 ) ) ){
        wp_enqueue_script( 'get-policy-js', get_template_directory_uri() . '/js/get-policy-m.js', array('jquery', 'date'), '3.7.6', true );
    }

    if( is_page( array( 3033 ) ) ){
        wp_enqueue_script( 'get-policy-js', get_template_directory_uri() . '/js/get-policy-m-t.js', array('jquery', 'date'), '3.28', true );
    }

}

///// Отключаем уведомления о каких-либо обновлениях
//add_filter('pre_site_transient_update_core',create_function('$a', "return null;"));
//wp_clear_scheduled_hook('wp_version_check');
//
//remove_action('load-update-core.php','wp_update_themes');
//add_filter('pre_site_transient_update_themes',create_function('$a', "return null;"));
//wp_clear_scheduled_hook('wp_update_themes');
//
//remove_action( 'load-update-core.php', 'wp_update_plugins' );
//add_filter( 'pre_site_transient_update_plugins', create_function( '$a', "return null;" ) );
//wp_clear_scheduled_hook( 'wp_update_plugins' );
/////

add_action( 'wp_enqueue_scripts', 'epolicy_scripts' );


add_action('user_new_form', 'my_profile_new_fields_add');
//add_action('show_user_profile', 'my_profile_new_fields_add');
add_action('edit_user_profile', 'my_profile_new_fields_add');

//add_action('personal_options_update', 'my_profile_new_fields_update');
add_action('edit_user_profile_update', 'my_profile_new_fields_update');
add_action('user_register', 'my_profile_new_fields_update');


/*
 * Добавляем возможность скрывать или показывать СТРАХОВЫЕ КОМПАНИИ
 * конкретному пользователю на странице редактирования пользователя
 * (МЕДИЧКА)
 */
add_action('user_new_form', 'user_insurance_visible_status_show');
add_action('edit_user_profile', 'user_insurance_visible_status_show');
include_once "include/user_insurance_visible_status.php";

add_action( 'user_register', 'user_insurance_visible_status_update' );
add_action('personal_options_update', 'user_insurance_visible_status_update');
add_action('edit_user_profile_update', 'user_insurance_visible_status_update');
include_once "include/user_insurance_visible_status_update.php";

add_action( 'delete_user', 'user_insurance_visible_status_delete', 10, 10 );
include_once "include/user_insurance_visible_status_delete.php";


/*
 * Добавляем возможность скрывать или показывать СТРАХОВЫЕ КОМПАНИИ
 * конуретному пользователю на странице редактирования пользователя
 * (COVID2019)
 */
add_action('user_new_form', 'user_covid_visible_status_show');
add_action('edit_user_profile', 'user_covid_visible_status_show');
include_once "include/covid2019/user_covid_visible_status_show.php";

add_action( 'user_register', 'user_covid_visible_status_update' );
add_action('personal_options_update', 'user_covid_visible_status_update');
add_action('edit_user_profile_update', 'user_covid_visible_status_update');
include_once "include/covid2019/user_covid_visible_status_update.php";

add_action( 'delete_user', 'user_covid_visible_status_delete', 10, 10 );
include_once "include/covid2019/user_covid_visible_status_delete.php";


function enqueue_my_scripts($hook) {
    if ( 'user-edit.php' == $hook || 'user-new.php' == $hook) {
        //echo "<p style='text-align:center;'>" .$hook. "</p>";
        //echo "<script>jQuery(document).ready(function(){jQuery('#mobile').mask('+38 (099) 999-99-99');});</script>";
        wp_enqueue_script( 'jquery.maskedinput.min', get_template_directory_uri() . '/js/jquery.maskedinput.min.js', array('jquery'), '1.0', true );
        //wp_add_inline_script("my_scripts", "jQuery(document).ready(function(){jQuery('#mobile').mask('+38 (099) 999-99-99');});");
    }


}
add_action('admin_enqueue_scripts', 'enqueue_my_scripts');


//function true_add_contacts( $contactmethods ) {
//	$contactmethods['mobile'] = 'Мобільний номер';
//	return $contactmethods;
//}
//add_filter('user_contactmethods', 'true_add_contacts', 10, 1);

function getPercentFranchises(){
    global $wpdb;
    $table_config = $wpdb->prefix . "ewa_config";
    $percentFranchises = array();

    $percentFranchisesArray = $wpdb->get_results("SELECT value FROM ".$table_config." WHERE `key` = 'percent_franchises'", ARRAY_A);
    if(count($percentFranchisesArray) == 1) {
        $percentFranchises = $percentFranchisesArray[0]["value"];
        $explodeFranchises = explode(";", $percentFranchises);
        unset($percentFranchises);
        if(count($explodeFranchises > 0)){
            foreach($explodeFranchises as $value){
                if(is_numeric($value)){
                    $percentFranchises[] = $value;
                }
            }
        }
    }

    return $percentFranchises;
}

function validateDate($date, $format = 'Y-m-d')
{
    $d = DateTime::createFromFormat($format, $date);
    return $d && $d->format($format) === $date;
}

function getAllReferals($manager){
    $referals = array();
    foreach($manager as $data) {
        $referals[] = $data;
        $level = ps_get_referal( $data );
        if ( count( $level ) > 0 ) {
            $referals = array_merge(getAllReferals($level), $referals);
        }
    }
    return $referals;
}

function my_profile_new_fields_add($user){
    $return_percent = get_user_meta( $user->ID, "user_return_percent", 1 );
    $user_phone = get_user_meta( $user->ID, "user_phone", 1 );
    $user_return_percent_no_zero_franchise_with_dcv_OSAGO = get_user_meta( $user->ID, "user_return_percent_no_zero_franchise_with_dcv_OSAGO", 1 );
    $user_return_percent_no_zero_franchise_with_dcv_DCV = get_user_meta( $user->ID, "user_return_percent_no_zero_franchise_with_dcv_DCV", 1 );
    $user_return_percent_zero_franchise_with_dcv_OSAGO = get_user_meta( $user->ID, "user_return_percent_zero_franchise_with_dcv_OSAGO", 1 );
    $user_return_percent_zero_franchise_with_dcv_DCV = get_user_meta( $user->ID, "user_return_percent_zero_franchise_with_dcv_DCV", 1 );

    global $wpdb;
    $table_name = $wpdb->prefix . "ewa_companies";
    $allCompanies = '';
    $percentFranchises = getPercentFranchises();

    $companies = $wpdb->get_results("SELECT ewa_id, name FROM ".$table_name." WHERE `status` = 1", ARRAY_A);
    if(count($companies) >= 1) {
        foreach ( $companies as $company ) {
            $return_percent_tmp = get_user_meta( $user->ID, "user_return_percent_company_id_".$company['ewa_id'], 1 );
            $return_percent_tmp_dcv = get_user_meta( $user->ID, "user_return_percent_dcv_company_id_".$company['ewa_id'], 1 );
            $return_percent_tmp_additional_percent = get_user_meta( $user->ID, "user_return_percent_additional_enable_company_id_".$company['ewa_id'], 1 );
            $return_percent_tmp_additional_percent ? $company_add_percent_checked = ' checked="checked"' : $company_add_percent_checked = '';

            $allCompanies .= '<tr>
                                <th style="width: 300px; min-width: 300px!important">
                                    <label for="user_return_percent_company_id_'.$company['ewa_id'].'">'.$company['name'].'</label>
                                </th>
                                 <th>
                                    <input type="number" 
                                           id="user_return_percent_company_id_'.$company['ewa_id'].'" 
                                           name="user_return_percent_company_id_'.$company['ewa_id'].'" 
                                           value="'.$return_percent_tmp.'" min="1" max="40"><br>
                                 </th>';

            $allCompanies .= '<th>
                                    <input type="checkbox" 
                                           id="user_return_percent_additional_enable_company_id_'.$company['ewa_id'].'" 
                                           name="user_return_percent_additional_enable_company_id_'.$company['ewa_id'].'" 
                                           value="1" '.$company_add_percent_checked.'><br>
                                </th>';

            $allCompanies .= '<th>
                                    <input type="number" 
                                           id="user_return_percent_dcv_company_id_'.$company['ewa_id'].'" 
                                           name="user_return_percent_dcv_company_id_'.$company['ewa_id'].'" 
                                           value="'.$return_percent_tmp_dcv.'" min="1" max="40"><br>
                                </th>';

            if(count($percentFranchises) > 0){
                foreach($percentFranchises as $value){
                    $return_percent_zero_franchise_tmp = get_user_meta( $user->ID, "user_return_percent_".$value."_franchise_company_id_".$company['ewa_id'], 1 );

                    $franchiseByZone = '<div class="frahnchiseByZone">';
                    for($i = 1; $i <=6; $i++){
                        $return_percent_zero_franchise_with_zone_tmp = get_user_meta( $user->ID, "user_return_percent_".$value."_franchise_".$i."_zone_company_id_".$company['ewa_id'], 1 );
                        $franchiseByZone .= '<div><span><i class="fa fa-map-marker" aria-hidden="true"></i> '.$i.'</span><input type="number" id="user_return_percent_'.$value.'_franchise_'.$i.'_zone_company_id_'.$company['ewa_id'].'" name="user_return_percent_'.$value.'_franchise_'.$i.'_zone_company_id_'.$company['ewa_id'].'" min="1" max="40" value="'.$return_percent_zero_franchise_with_zone_tmp.'"></div>';
                        if($i == 3) $franchiseByZone .= "<br><br>";
                    }
                    $franchiseByZone .= '</div>';
                    unset($i);

                    $allCompanies .= ' <th class="franchise">
                                            <div>Стандартно <input type="number" 
                                                   id="user_return_percent_'.$value.'_franchise_company_id_'.$company['ewa_id'].'" 
                                                   name="user_return_percent_'.$value.'_franchise_company_id_'.$company['ewa_id'].'" 
                                                   value="'.$return_percent_zero_franchise_tmp.'" min="1" max="40"></div><br>'.$franchiseByZone.'
                                        </th>';
                }
            }

            $allCompanies .= "</tr>";
        }
    }


    // Медичне страхуваання
    $table_name_medical_companies = $wpdb->prefix . "insurance_company";
    $medicalCompanies = $wpdb->get_results("SELECT id, title FROM ".$table_name_medical_companies." WHERE `status` = 1", ARRAY_A);
    $allMedicalCompanies = '';
    if(count($medicalCompanies) >= 1) {
        $allMedicalCompanies .= '<table class="form-table"><tbody>';

        foreach ( $medicalCompanies as $medCompany ) {
            $return_percent_medical_company_id_tmp = get_user_meta( $user->ID, "user_return_percent_medical_company_id_".$medCompany['id'], 1 );

            $allMedicalCompanies .= '<tr>
                                        <th><label for="user_return_percent_medical_company_id_'.$medCompany['id'].'">'.$medCompany['title'].'</label></th>
                                        <td>
                                            <input type="number" id="user_return_percent_medical_company_id_'.$medCompany['id'].'" name="user_return_percent_medical_company_id_'.$medCompany['id'].'" value="'.$return_percent_medical_company_id_tmp.'" min="1" max="50"><br>
                                        </td>
                                    </tr>';
        }

        $allMedicalCompanies .= '</tbody></table>';
    }
    else {
        $allMedicalCompanies = "<div>У Вас не додано жодної медичної компанії.</div>";
    }
    // / Медичне страхування


    // COVID 19
	$table_name_covid_companies = $wpdb->prefix . "covid_company";
	$covidCompanies = $wpdb->get_results("SELECT id, title FROM ".$table_name_covid_companies." WHERE `status` = 1", ARRAY_A);
	$allCovidCompanies = '';
	if(count($covidCompanies) >= 1) {
		$allCovidCompanies .= '<table class="form-table"><tbody>';

		foreach ( $covidCompanies as $cvdCompany ) {
			$return_percent_covid_company_id_tmp = get_user_meta( $user->ID, "user_return_percent_covid_company_id_".$cvdCompany['id'], 1 );

			$allCovidCompanies .= '<tr>
                                        <th><label for="user_return_percent_covid_company_id_'.$cvdCompany['id'].'">'.$cvdCompany['title'].'</label></th>
                                        <td>
                                            <input type="number" id="user_return_percent_covid_company_id_'.$cvdCompany['id'].'" name="user_return_percent_covid_company_id_'.$cvdCompany['id'].'" value="'.$return_percent_covid_company_id_tmp.'" min="1" max="50"><br>
                                        </td>
                                    </tr>';
		}

		$allCovidCompanies .= '</tbody></table>';
	}
	else {
		$allCovidCompanies = "<div>У Вас не додано жодної Covid компанії.</div>";
	}
	// / COVID 19

//	$dd = get_user_meta($user->ID);
//	echo "<div class='sss' style='display: none;'>";
//	echo "<pre>";
//	print_r($dd);
//	echo "</pre>";
//	echo "</div>";
    ?>

    <table class="form-table">
        <tr>
            <th><label for="user_phone">Мобільний номер</label></th>
            <td>
                <input type="text" id="user_phone" name="user_phone" class="code" value="<?php echo $user_phone ?>"><br>
            </td>
        </tr>
    </table>
    <hr>
    <h1>EWA</h1>
    <h3>Одержуваний %</h3>
    <table class="form-table">
        <tr>
            <th><label for="user_return_percent">% від укладення контракту (за замовчуванням)</label></th>
            <td>
                <input type="number" id="user_return_percent" name="user_return_percent" value="<?php echo $return_percent ?>" min="1" max="40"><br>
            </td>
        </tr>
    </table>

    <hr>
    <h3>Додатковий % від електронного полісу разом з ДЦВ</h3>
    <table table class="widefat fixed striped posts" cellspacing="0">
        <tr>
            <th><label for="user_return_percent_zero_franchise_with_dcv_OSAGO">% від <strong>0</strong> франшизи (ОСАГО)</label></th>
            <td>
                <input type="number" id="user_return_percent_zero_franchise_with_dcv_OSAGO" name="user_return_percent_zero_franchise_with_dcv_OSAGO" value="<?php echo $user_return_percent_zero_franchise_with_dcv_OSAGO ?>" min="1" max="40"><br>
            </td>
            <th><label for="user_return_percent_zero_franchise_with_dcv_DCV">% від <strong>0</strong> франшизи (ДЦВ)</label></th>
            <td>
                <input type="number" id="user_return_percent_zero_franchise_with_dcv_DCV" name="user_return_percent_zero_franchise_with_dcv_DCV" value="<?php echo $user_return_percent_zero_franchise_with_dcv_DCV ?>" min="1" max="40"><br>
            </td>
        </tr>
        <tr>
            <th><label for="user_return_percent_no_zero_franchise_with_dcv_OSAGO">% від <strong>&ne;0</strong> франшизи (ОСАГО)</label></th>
            <td>
                <input type="number" id="user_return_percent_no_zero_franchise_with_dcv_OSAGO" name="user_return_percent_no_zero_franchise_with_dcv_OSAGO" value="<?php echo $user_return_percent_no_zero_franchise_with_dcv_OSAGO ?>" min="1" max="40"><br>
            </td>
            <th><label for="user_return_percent_no_zero_franchise_with_dcv_DCV">% від <strong>&ne;0</strong> франшизи (ДЦВ)</label></th>
            <td>
                <input type="number" id="user_return_percent_no_zero_franchise_with_dcv_DCV" name="user_return_percent_no_zero_franchise_with_dcv_DCV" value="<?php echo $user_return_percent_no_zero_franchise_with_dcv_DCV ?>" min="1" max="40"><br>
            </td>
        </tr>
    </table>
    <hr><br>
    <div style="min-width: 900px; overflow-x: auto;">
        <table class="widefat striped posts" cellspacing="0" style="width: 100%">
            <!-- <table class="widefat fixed striped posts" cellspacing="0" style="width: 100%"> -->
            <thead>
            <tr>
                <th colspan="2" style="width: 300px">Компанія</th>
                <th style="width: 150px">+% (ОСАГО + ДЦВ)</th>
                <th style="width: 140px">ДЦВ</th>
                <?php
                if(count($percentFranchises) > 0) {
                    foreach ( $percentFranchises as $value ) {
                        echo '<th style="min-width: 230px;">«<strong>'.$value.'</strong>» франшиза</th>';
                    }
                }
                ?>
            </tr>
            </thead>
            <?php echo $allCompanies;  ?>
        </table>
    </div>
    <style>
        .widefat th input {
            margin: 0px;
            padding: 3px 5px;
        }
        .widefat thead {
            background-color: #c3c3c3;
        }
        .widefat thead th {
            font-weight: bold!important;
        }
    </style>
    <br>

    <hr>
    <h3>МЕДИЧНЕ СТРАХУВАННЯ</h3>
    <?php echo $allMedicalCompanies; ?>

    <hr>
    <h3>COVID 19 СТРАХУВАННЯ</h3>
	<?php echo $allCovidCompanies; ?>


    <hr><h3>Авторизація на інші ресурси</h3>
    <h2>USI Travel</h2>
    <table class="form-table">
        <tr>
            <th><label for="other_companies_login_usi_travel">Логін</label></th>
            <td>
                <input type="text" id="other_companies_login_usi_travel" name="other_companies_login_usi_travel" value="<?php echo get_user_meta( $user->ID, "other_companies_login_usi_travel", 1 ) ?>"><br>
            </td>
        </tr>
        <tr>
            <th><label for="other_companies_password_usi_travel">Пароль</label></th>
            <td>
                <input type="text" id="other_companies_password_usi_travel" name="other_companies_password_usi_travel" value="<?php echo get_user_meta( $user->ID, "other_companies_password_usi_travel", 1 ) ?>"><br>
            </td>
        </tr>
    </table>

    <br><h2>USI Policy</h2>
    <table class="form-table">
        <tr>
            <th><label for="other_companies_login_usi_policy">Логін</label></th>
            <td>
                <input type="text" id="other_companies_login_usi_policy" name="other_companies_login_usi_policy" value="<?php echo get_user_meta( $user->ID, "other_companies_login_usi_policy", 1 ) ?>"><br>
            </td>
        </tr>
        <tr>
            <th><label for="other_companies_password_usi_policy">Пароль</label></th>
            <td>
                <input type="text" id="other_companies_password_usi_policy" name="other_companies_password_usi_policy" value="<?php echo get_user_meta( $user->ID, "other_companies_password_usi_policy", 1 ) ?>"><br>
            </td>
        </tr>
    </table>

    <br><h2>UFI Travel</h2>
    <table class="form-table">
        <tr>
            <th><label for="other_companies_login_ufi_travel">Логін</label></th>
            <td>
                <input type="text" id="other_companies_login_ufi_travel" name="other_companies_login_ufi_travel" value="<?php echo get_user_meta( $user->ID, "other_companies_login_ufi_travel", 1 ) ?>"><br>
            </td>
        </tr>
        <tr>
            <th><label for="other_companies_password_ufi_travel">Пароль</label></th>
            <td>
                <input type="text" id="other_companies_password_ufi_travel" name="other_companies_password_ufi_travel" value="<?php echo get_user_meta( $user->ID, "other_companies_password_ufi_travel", 1 ) ?>"><br>
            </td>
        </tr>
    </table>
    <style>
        th.franchise {
            /* min-width: 350px; */
            min-width: 230px;
        }
        .franchise input {
            vertical-align: middle!important;
        }
        .frahnchiseByZone>div {
            margin-right: 3px;
            display: inline-block;
        }

        .frahnchiseByZone span {
            display: inline-block;
            width:21px;
            margin-right: 2px;
        }
    </style>
    <script>jQuery(document).ready(function(){jQuery('#user_phone').mask('+38 (099) 999-99-99');});</script>
    <?php
}

// обновление
function my_profile_new_fields_update($user_id){
    if(isset($_POST) && count($_POST) > 0){
        $get_user_meta = get_user_meta($user_id);
        foreach($get_user_meta as $meta_key => $meta_value){
            if ( substr( $meta_key, 0, 49 ) == 'user_return_percent_additional_enable_company_id_' ) {
                delete_user_meta( $user_id, $meta_key, $meta_value[0] );
            }
        }

        $percentFranchises = getPercentFranchises();

        if (array_key_exists('user_return_percent', $_POST)) {
            update_user_meta( $user_id, "user_return_percent", $_POST['user_return_percent'] );
        }

        if (array_key_exists('user_phone', $_POST)) {
            update_user_meta( $user_id, "user_phone", $_POST['user_phone'] );
        }

        if (array_key_exists('user_return_percent_no_zero_franchise_with_dcv_OSAGO', $_POST)) {
            if((int)$_POST['user_return_percent_no_zero_franchise_with_dcv_OSAGO'] > 0) {
                update_user_meta( $user_id, "user_return_percent_no_zero_franchise_with_dcv_OSAGO", $_POST['user_return_percent_no_zero_franchise_with_dcv_OSAGO'] );
            }
            else {
                delete_user_meta( $user_id, "user_return_percent_no_zero_franchise_with_dcv_OSAGO" );
            }}

        if (array_key_exists('user_return_percent_no_zero_franchise_with_dcv_DCV', $_POST)) {
            if((int)$_POST['user_return_percent_no_zero_franchise_with_dcv_DCV'] > 0) {
                update_user_meta( $user_id, "user_return_percent_no_zero_franchise_with_dcv_DCV", $_POST['user_return_percent_no_zero_franchise_with_dcv_DCV'] );
            }
            else {
                delete_user_meta( $user_id, "user_return_percent_no_zero_franchise_with_dcv_DCV" );
            }
        }

        if (array_key_exists('user_return_percent_zero_franchise_with_dcv_OSAGO', $_POST)) {
            if((int)$_POST['user_return_percent_zero_franchise_with_dcv_OSAGO'] > 0) {
                update_user_meta( $user_id, "user_return_percent_zero_franchise_with_dcv_OSAGO", $_POST['user_return_percent_zero_franchise_with_dcv_OSAGO'] );
            }
            else {
                delete_user_meta( $user_id, "user_return_percent_zero_franchise_with_dcv_OSAGO" );
            }
        }

        if (array_key_exists('user_return_percent_zero_franchise_with_dcv_DCV', $_POST)) {
            if((int)$_POST['user_return_percent_zero_franchise_with_dcv_DCV'] > 0) {
                update_user_meta( $user_id, "user_return_percent_zero_franchise_with_dcv_DCV", $_POST['user_return_percent_zero_franchise_with_dcv_DCV'] );
            }
            else {
                delete_user_meta( $user_id, "user_return_percent_zero_franchise_with_dcv_DCV" );
            }
        }

        foreach($_POST as $key => $value){
            if ( substr( $key, 0, 31 ) == 'user_return_percent_company_id_' ) {
                update_user_meta( $user_id, $key, $value );
            }

            if ( substr( $key, 0, 35 ) == 'user_return_percent_dcv_company_id_' ) {
                $metaKey = get_user_meta( $user_id, $key, 1 );
                if($metaKey){
                    if($value) {
                        update_user_meta( $user_id, $key, $value );
                    }
                    else {
                        delete_user_meta( $user_id, $key, $value );
                    }
                }
                else {
                    if($value) {
                        update_user_meta( $user_id, $key, $value );
                    }
                }
            }

            // Additional percent
            if ( substr( $key, 0, 49 ) == 'user_return_percent_additional_enable_company_id_' ) {
                update_user_meta( $user_id, $key, $value );
            }

            // Other companies access
            if ( substr( $key, 0, 25 ) == 'other_companies_password_' ||  substr( $key, 0, 22 ) == 'other_companies_login_') {
                $metaKey = get_user_meta( $user_id, $key, 1 );
                if($metaKey){
                    if($value) {
                        update_user_meta( $user_id, $key, $value );
                    }
                    else {
                        delete_user_meta( $user_id, $key, $value );
                    }
                }
                else {
                    if($value) {
                        update_user_meta( $user_id, $key, $value );
                    }
                }
            }


            if(count($percentFranchises) > 0) {
                foreach ( $percentFranchises as $percentFranchise ) {
                    if ( substr( $key, 0, (42 + strlen($percentFranchise)) ) == 'user_return_percent_'.$percentFranchise.'_franchise_company_id_' ) {
                        $metaKey = get_user_meta( $user_id, $key, 1 );
                        if($metaKey){
                            if($value > 0) {
                                update_user_meta( $user_id, $key, $value );
                            }
                            else {
                                delete_user_meta( $user_id, $key, $value );
                            }
                        }
                        else {
                            if($value > 0) {
                                update_user_meta( $user_id, $key, $value );
                            }
                        }
                    }

                    for($i = 1; $i <=6; $i++){
                        if ( substr( $key, 0, (49 + strlen($percentFranchise)) ) == 'user_return_percent_'.$percentFranchise.'_franchise_'.$i.'_zone_company_id_' ) {
                            $metaKey = get_user_meta( $user_id, $key, 1 );
                            if($metaKey){
                                if($value > 0) {
                                    update_user_meta( $user_id, $key, $value );
                                }
                                else {
                                    delete_user_meta( $user_id, $key, $value );
                                }
                            }
                            else {
                                if($value > 0) {
                                    update_user_meta( $user_id, $key, $value );
                                }
                            }
                        }
                    }

                }
            }


            // Медичне страхування
            if ( substr( $key, 0, 39 ) == 'user_return_percent_medical_company_id_' ) {
                $metaKey = get_user_meta( $user_id, $key, 1 );
                if($metaKey){
                    if($value) {
                        update_user_meta( $user_id, $key, $value );
                    }
                    else {
                        delete_user_meta( $user_id, $key, $value );
                    }
                }
                else {
                    if($value) {
                        update_user_meta( $user_id, $key, $value );
                    }
                }
            }
            // /Медичне страхування


	        // COVID 19
	        if ( substr( $key, 0, 37 ) == 'user_return_percent_covid_company_id_' ) {
		        $metaKey = get_user_meta( $user_id, $key, 1 );
		        if($metaKey){
			        if($value) {
				        update_user_meta( $user_id, $key, $value );
			        }
			        else {
				        delete_user_meta( $user_id, $key, $value );
			        }
		        }
		        else {
			        if($value) {
				        update_user_meta( $user_id, $key, $value );
			        }
		        }
	        }
	        // /COVID 19

        }
    }
}

//add_filter( 'manage_users_custom_column', 'percent_user_admin_content', 10,  3);
//function percent_user_admin_content( $custom_column, $column_name, $user_id ){
//
//	switch( $column_name ){
//		case 'balance_user_recall':
//			$custom_column = '<input type="text" class="balanceuser-'.$user_id.'" size="4" value="'.rcl_get_user_balance($user_id).'">'
//			                 . '<input type="button" class="recall-button edit_balance" id="user-'.$user_id.'" value="Ok">';
//			break;
//
//	}
//	return $custom_column;
//
//}


//Class Theme Helper
require_once ( get_template_directory() . '/core/class/theme-helper.php' );

//Class Theme Cache
require_once ( get_template_directory() . '/core/class/theme-cache.php' );

//Class Walker comments
require_once ( get_template_directory() . '/core/class/walker-comment.php' );

//Class Walker Mega Menu
require_once ( get_template_directory() . '/core/class/walker-mega-menu.php' );

//Class Theme Likes
require_once ( get_template_directory() . '/core/class/theme-likes.php' );

//Class Theme Cats Meta
require_once ( get_template_directory() . '/core/class/theme-cat-meta.php' );

//Class Single Post
require_once ( get_template_directory() . '/core/class/single-post.php' );

//Class Theme Autoload
require_once ( get_template_directory() . '/core/class/theme-autoload.php' );

//Class Tinymce
require_once(get_template_directory() . "/core/class/tinymce-icon.php");

function seofy_content_width() {
    if ( ! isset( $content_width ) ) {
        $content_width = 940;
    }
}
add_action( 'after_setup_theme', 'seofy_content_width', 0 );

function seofy_theme_slug_setup() {
    add_theme_support('title-tag');
}
add_action('after_setup_theme', 'seofy_theme_slug_setup');

require_once(get_template_directory() . '/wpb/wpb-init.php');


add_action('init', 'seofy_page_init');
if (!function_exists('seofy_page_init')) {
    function seofy_page_init()
    {
        add_post_type_support('page', 'excerpt');
    }
}

if (!function_exists('seofy_main_menu')) {
    function seofy_main_menu ($location = ''){
        wp_nav_menu( array(
            'theme_location'  => 'main_menu',
            'menu'  => $location,
            'container' => '',
            'container_class' => '',
            'after' => '',
            'link_before'     => '<span>',
            'link_after'      => '</span>',
            'walker' => new Seofy_Mega_Menu_Waker()
        ) );
    }
}

// return all sidebars
if (!function_exists('seofy_get_all_sidebar')) {
    function seofy_get_all_sidebar() {
        global $wp_registered_sidebars;
        $out = array();
        if ( empty( $wp_registered_sidebars ) )
            return;
        foreach ( $wp_registered_sidebars as $sidebar_id => $sidebar) :
            $out[$sidebar_id] = $sidebar['name'];
        endforeach;
        return $out;
    }
}

if (!function_exists('seofy_get_custom_preset')) {
    function seofy_get_custom_preset() {
        $custom_preset = get_option('seofy_preset');
        $presets =  seofy_default_preset();

        $out = array();
        $out['default'] = esc_html__( 'Default', 'seofy' );
        $i = 1;
        if(is_array($presets)){
            foreach ($presets as $key => $value) {
                $out[$key] = $key;
                $i++;
            }
        }
        if(is_array($custom_preset)){
            foreach ( $custom_preset as $preset_id => $preset) :
                $out[$preset_id] = $preset_id;
            endforeach;
        }
        return $out;
    }
}

if (!function_exists('seofy_get_custom_menu')) {
    function seofy_get_custom_menu() {
        $taxonomies = array();

        $menus = get_terms('nav_menu');
        foreach ($menus as $key => $value) {
            $taxonomies[$value->name] = $value->name;
        }
        return $taxonomies;
    }
}

function seofy_get_attachment( $attachment_id ) {
    $attachment = get_post( $attachment_id );
    return array(
        'alt' => get_post_meta( $attachment->ID, '_wp_attachment_image_alt', true ),
        'caption' => $attachment->post_excerpt,
        'description' => $attachment->post_content,
        'href' => get_permalink( $attachment->ID ),
        'src' => $attachment->guid,
        'title' => $attachment->post_title
    );
}

if (!function_exists('seofy_reorder_comment_fields')) {
    function seofy_reorder_comment_fields($fields ) {
        $new_fields = array();

        $myorder = array('author', 'email', 'url', 'comment');

        foreach( $myorder as $key ){
            $new_fields[ $key ] = isset($fields[ $key ]) ? $fields[ $key ] : '';
            unset( $fields[ $key ] );
        }

        if( $fields ) {
            foreach( $fields as $key => $val ) {
                $new_fields[ $key ] = $val;
            }
        }

        return $new_fields;
    }
}
add_filter('comment_form_fields', 'seofy_reorder_comment_fields');

function seofy_mce_buttons_2( $buttons ) {
    array_unshift( $buttons, 'styleselect' );
    return $buttons;
}
add_filter( 'mce_buttons_2', 'seofy_mce_buttons_2' );


function seofy_tiny_mce_before_init( $settings ) {

    $settings['theme_advanced_blockformats'] = 'p,h1,h2,h3,h4';
    $style_formats = array(
        array( 'title' => esc_html__( 'Dropcap', 'seofy' ), 'items' => array(
            array( 'title' => esc_html__( 'Theme Color', 'seofy' ), 'inline' => 'span', 'classes' => 'dropcap theme_style', 'styles' => array( 'color' => '#ffffff', 'background-color' => Seofy_Theme_Helper::get_option('theme-custom-color'))),
            array( 'title' => esc_html__( 'Theme Secondary Color', 'seofy' ), 'inline' => 'span', 'classes' => 'dropcap secondary_style', 'styles' => array( 'color' => Seofy_Theme_Helper::get_option('second-custom-color'), 'background-color' => '#ffffff')),
        )),
        array( 'title' => esc_html__( 'Highlighter', 'seofy' ), 'items' => array(
            array( 'title' => esc_html__( 'Theme Color', 'seofy' ), 'inline' => 'span', 'classes' => 'highlighter', 'styles' => array( 'color' => '#ffffff', 'background-color' => Seofy_Theme_Helper::get_option('theme-custom-color'))),
            array( 'title' => esc_html__( 'Theme Secondary Color', 'seofy' ), 'inline' => 'span', 'classes' => 'highlighter_second', 'styles' => array( 'color' => '#ffffff', 'background-color' => Seofy_Theme_Helper::get_option('second-custom-color'))),
        )),
        array( 'title' => esc_html__( 'Font Weight', 'seofy' ), 'items' => array(
            array( 'title' => esc_html__( 'Default', 'seofy' ), 'inline' => 'span', 'classes' => 'custom-weight', 'styles' => array( 'font-weight' => 'inherit' ) ),
            array( 'title' => esc_html__( 'Lightest (100)', 'seofy' ), 'inline' => 'span', 'classes' => 'custom-weight', 'styles' => array( 'font-weight' => '100' ) ),
            array( 'title' => esc_html__( 'Lighter (200)', 'seofy' ), 'inline' => 'span', 'classes' => 'custom-weight', 'styles' => array( 'font-weight' => '200' ) ),
            array( 'title' => esc_html__( 'Light (300)', 'seofy' ), 'inline' => 'span', 'classes' => 'custom-weight', 'styles' => array( 'font-weight' => '300' ) ),
            array( 'title' => esc_html__( 'Normal (400)', 'seofy' ), 'inline' => 'span', 'classes' => 'custom-weight', 'styles' => array( 'font-weight' => '400' ) ),
            array( 'title' => esc_html__( 'Medium (500)', 'seofy' ), 'inline' => 'span', 'classes' => 'custom-weight', 'styles' => array( 'font-weight' => '500' ) ),
            array( 'title' => esc_html__( 'Semi-Bold (600)', 'seofy' ), 'inline' => 'span', 'classes' => 'custom-weight', 'styles' => array( 'font-weight' => '600' ) ),
            array( 'title' => esc_html__( 'Bold (700)', 'seofy' ), 'inline' => 'span', 'classes' => 'custom-weight', 'styles' => array( 'font-weight' => '700' ) ),
            array( 'title' => esc_html__( 'Extra Bold (800)', 'seofy' ), 'inline' => 'span', 'classes' => 'custom-weight', 'styles' => array( 'font-weight' => '800' ) ),
            array( 'title' => esc_html__( 'Black (900)', 'seofy' ), 'inline' => 'span', 'classes' => 'custom-weight', 'styles' => array( 'font-weight' => '900' ) ),
        )
        ),
        array( 'title' => esc_html__( 'List Style', 'seofy' ), 'items' => array(
            array( 'title' => esc_html__( 'Dash', 'seofy' ), 'selector' => 'ul', 'classes' => 'seofy_dash'),
            array( 'title' => esc_html__( 'Check', 'seofy' ), 'selector' => 'ul', 'classes' => 'seofy_check'),
            array( 'title' => esc_html__( 'Check With Gradient', 'seofy' ), 'selector' => 'ul', 'classes' => 'seofy_check_gradient'),
            array( 'title' => esc_html__( 'Plus', 'seofy' ), 'selector' => 'ul', 'classes' => 'seofy_plus'),
            array( 'title' => esc_html__( 'No List Style', 'seofy' ), 'selector' => 'ul', 'classes' => 'no-list-style'),
        )
        ),
    );

    $settings['style_formats'] = str_replace( '"', "'", json_encode( $style_formats ) );
    $settings['extended_valid_elements'] = 'span[*],a[*],i[*]';
    return $settings;
}
add_filter( 'tiny_mce_before_init', 'seofy_tiny_mce_before_init' );

function seofy_theme_add_editor_styles() {
    add_editor_style( 'css/font-awesome.min.css' );
}
add_action( 'current_screen', 'seofy_theme_add_editor_styles' );

function seofy_categories_postcount_filter ($variable) {
    if(strpos($variable,'</a> (')){
        $variable = str_replace('</a> (', '</a> <span class="post_count">', $variable);
        $variable = str_replace('</a>&nbsp;(', '</a>&nbsp;<span class="post_count">', $variable);
        $variable = str_replace(')', '</span>', $variable);
    }
    else{
        $variable = str_replace('</a> <span class="count">(', '</a><span class="post_count">', $variable);
        $variable = str_replace(')', '', $variable);
    }

    $pattern1 = '/cat-item-\d+/';
    preg_match_all( $pattern1, $variable,$matches );
    if(isset($matches[0])){
        foreach ($matches[0] as $key => $value) {
            $int = (int) str_replace('cat-item-','', $value);
            $icon_image_id = get_term_meta ( $int, 'category-icon-image-id', true );
            if(!empty($icon_image_id)){
                $icon_image = wp_get_attachment_image_src ( $icon_image_id, 'full' );
                $icon_image_alt = get_post_meta($icon_image_id, '_wp_attachment_image_alt', true);
                $replacement = '$1<img class="cats_item-image" src="'. esc_url($icon_image[0]) .'" alt="'.(!empty($icon_image_alt) ? esc_attr($icon_image_alt) : '').'"/>';
                $pattern = '/(cat-item-'.$int.'+.*?><a.*?>)/';
                $variable = preg_replace( $pattern, $replacement, $variable );
            }
        }
    }

    return $variable;
}
add_filter('wp_list_categories', 'seofy_categories_postcount_filter');

add_filter( 'get_archives_link', 'seofy_render_archive_widgets', 10, 6 );
function seofy_render_archive_widgets ( $link_html, $url, $text, $format, $before, $after ) {
    $after = str_replace('(', '', $after);
    $after = str_replace(' ', '', $after);
    $after = str_replace('&nbsp;', '', $after);
    $after = str_replace(')', '', $after);

    $after = !empty($after) ? "<span class='post_count'>".esc_html($after)."</span>" : "";

    $link_html = "<li>".esc_html($before)."<a href='".esc_url($url)."'>".esc_html($text)."</a>".$after."</li>";

    return $link_html;

}

// Add image size
if ( function_exists( 'add_image_size' ) ) {
    add_image_size( 'wgl-740-520',  740, 520, true  );
    add_image_size( 'wgl-440-440',  440, 440, true  );
    add_image_size( 'wgl-220-180',  220, 180, true  );
    add_image_size( 'wgl-120-120',  120, 120, true  );
}

// Include Woocommerce init if plugin is active
if ( class_exists( 'WooCommerce' ) ) {
    require_once( get_template_directory() . '/woocommerce/woocommerce-init.php' );
}

/**
 * Enqueue svg to the media.
 * @return void
 */
add_filter('upload_mimes', 'seofy_svg_mime_types');

function seofy_svg_mime_types($mimes) {
    $mimes['svg'] = 'image/svg+xml';
    return $mimes;
}






function is_user_role( $role, $user_id = null ) {
    $user = is_numeric( $user_id ) ? get_userdata( $user_id ) : wp_get_current_user();

    if( ! $user )
        return false;

    return in_array( $role, (array) $user->roles );
}

//Check user ROLE in MANAGER page
function my_page_checker() {
    if( is_page( 2979 ) )
    {
        $user = wp_get_current_user();
        $allowed_roles = array('user_manager', 'administrator');

        if( !array_intersect($allowed_roles, $user->roles ) ) {
            wp_redirect( home_url() );
            exit;
        }
    }
}
add_action( 'wp', 'my_page_checker' );

//Show adminbar for admin ONLY
if ( ! current_user_can( 'manage_options' ) ) {
    show_admin_bar( false );
}


//Administation page for admin ONLY
//function only_admin()
//{
//    if ( ! current_user_can( 'manage_options' ) && '/wp-admin/admin-ajax.php' != $_SERVER['PHP_SELF'] ) {
//        wp_redirect( home_url() );
//    }
//}
//add_action( 'admin_init', 'only_admin', 1 );


add_filter( 'wp_nav_menu_items', 'add_loginout_link', 10, 2 );
function add_loginout_link( $items, $args ) {
    if (is_user_logged_in()) {
        $items .= '<li class="menu-item menu-item-type-custom menu-item-object-custom current-menu-item"><a href="'. wp_logout_url(home_url()) .'"><span>Вихiд</span></a></li>';
    }
    elseif (!is_user_logged_in()) {
        $items .= '<li class="rcl-login menu-item menu-item-type-custom menu-item-object-custom current-menu-item"><a href="'. site_url('#bawloginout#') .'" class="rcl-login"><span>Вхiд</span></a></li>';
    }
    return $items;
}


//Изменить отправителя (wordpress) в письме
add_filter( 'wp_mail_from_name', function($from_name){
    return 'Epolicy';
} );


function covid_js(){

    wp_enqueue_script( 'covidbid', get_template_directory_uri() . '/js/covid-bid.js', array('jquery') );

    wp_localize_script( 'covidbid', 'covidBid', array(
        'ajaxurl' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce( 'covid-bid' ) // Create nonce which we later will use to verify AJAX request
    ));
}


add_action('wp_ajax_covidbid', 'covid_bid');
add_action('wp_ajax_nopriv_covidbid', 'covid_bid');

function covid_bid(){

    if( empty( $_POST['nonce'] ) ){
        wp_die('asd', 'asdasd', 400);
    }

    check_ajax_referer( 'covid-bid', 'nonce', true );

    $insurance_company = $_POST['insuranceCompany'];
    $insurance_Amount = $_POST['insuranceAmount'];
    $insurance_Period = $_POST['insurancePrediod'];
    $insurance_Price = $_POST['insurancePrice'];
    $insurance_customer_name = $_POST['customerName'];
    $insurance_customer_date = $_POST['customerDate'];
    // $insurance_customer_middle_name = $_POST['customerMiddleName'];
    $insurance_customer_surname = $_POST['customerSurname'];
    $insurance_customer_passport = $_POST['customerPassport'];
    $insurance_customer_address = $_POST['customerAddress'];
    $insurance_customer_Tel = $_POST['customerTel'];
    $insurance_customer_Email = $_POST['customerEmail'];

    $site_name =  get_bloginfo();
    $site_email =  get_bloginfo( $show = 'admin_email' );


    $to = 'epolicy@i.ua';
    // $to = 'alexshtanko@gmail.com';

    $subject = 'Epolicy COVID 2019';
    $message = 'Прiзвище: ' . $insurance_customer_surname . '<br> Iм\'я: ' . $insurance_customer_name . '<br> Дата народження: ' . $insurance_customer_date . '<br> Паспорт: ' . $insurance_customer_passport . '<br> Адреса: ' . $insurance_customer_address . '<br> Телефон: ' . $insurance_customer_Tel . '<br> Email: ' . $insurance_customer_Email . '<br> Страхова компанiя: ' . $insurance_company . '<br> Страхова сума: ' . $insurance_Amount . '<br> Страховий перiод: ' . $insurance_Period . '<br> Цiна: ' . $insurance_Price;

    $headers = "From: " . $site_email . "\r\n";
    $headers .= "Reply-To: ". $site_email . "\r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: text/html; charset=UTF-8\r\n";

    $header_ = 'MIME-Version: 1.0' . "\r\n" . 'Content-type: text/html; charset=UTF-8' . "\r\n";
    wp_mail($to, '=?UTF-8?B?'.base64_encode($subject).'?=', $message, $header_ . $headers);


    wp_die();

}
// add_action('init','register_my_tab');
// function register_my_tab(){

//     $tab_data =	array(
//         'id'=>'id-tab',
//         'name'=>'Имя вкладки',
//         'content'=>array(
//             array(
//                 'callback' => array(
//                     'name'=>'my_custom_function'
//                 )
//             )
//         )
//     );

//     rcl_tab($tab_data);
// }

// function my_custom_function(){

// 	echo 'Hello';
// }




/**
 * Mrdical bid (manager page)
 */


add_action('wp_ajax_medicalm', 'medicalm_bid');
add_action('wp_ajax_nopriv_medicalm', 'medicalm_bid');

function medicalm_bid(){

    if( empty( $_POST['nonce'] ) ){
        wp_die('', '', 400);
    }

    check_ajax_referer( 'medical-m', 'nonce', true );

    $program_id = $_POST['blank_id'];


    global $wpdb;

    $table_name_rate = $wpdb->get_blog_prefix() . 'insurance_rate';
    $table_name_blank = $wpdb->get_blog_prefix() . 'insurance_program';
    $table_name_company = $wpdb->get_blog_prefix() . 'insurance_company';

    // $results = $wpdb->get_results( $wpdb->prepare("SELECT DISTINCT ir.id, ir.franchise, ir.validity, ir.insured_sum, ir.price, ir.locations, ic.title as commpany_title, ib.title as blank_title 
    // FROM " . $table_name_rate . " ir 
    // left join " . $table_name_company . " ic on ic.id = ir.company_id 
    // left join " . $table_name_blank . " ib on ib.id = ir.program_id 
    // GROUP BY ir.validity ORDER BY ir.id DESC", '%d', '%d', '%d' ), ARRAY_A );

    $results = $wpdb->get_results( $wpdb->prepare("SELECT DISTINCT ir.validity 
    FROM " . $table_name_rate . " ir 
    WHERE program_id = " . $program_id . "
    GROUP BY ir.validity DESC ORDER BY CONVERT(Substring_Index(ir.validity, '/', -1), SIGNED INTEGER) DESC", '%d' ), ARRAY_A );


    // ORDER BY ir.id DESC", '%d' ), ARRAY_A );
    // return $results;

    $result = array(
        'test' => $_POST['test'],
        'results' => $results,
    );

    echo json_encode($result);

    wp_die();
}


add_action('wp_ajax_getinsurancelist', 'medicalm_insurance_list');
add_action('wp_ajax_nopriv_getinsurancelist', 'medicalm_insurance_list');

function medicalm_insurance_list(){

    if( empty( $_POST['nonce'] ) ){
        wp_die('', '', 400);
    }

    check_ajax_referer( 'medical-m', 'nonce', true );

    $program_id = $_POST['program_id'];

    $blank_type_id = $_POST['blank_type_id'];

    //Надо получить данные страховки

    $validity = $_POST['validity'];

    global $wpdb;

    $table_name_rate = $wpdb->get_blog_prefix() . 'insurance_rate';
    $table_name_program = $wpdb->get_blog_prefix() . 'insurance_program';
    $table_name_company = $wpdb->get_blog_prefix() . 'insurance_company';

//    $result = $wpdb->get_results( $wpdb->prepare( "SELECT ir.id, ir.franchise, ir.validity, ir.insured_sum, ir.price, ir.locations, ir.company_id, ic.title as commpany_title, ic.logo_url as company_logo_url, ir.program_id, ib.title as program_title
//    FROM " . $table_name_rate . " ir
//    left join " . $table_name_company . " ic on ic.id = ir.company_id
//    left join " . $table_name_program . " ib on ib.id = ir.program_id
//    WHERE ir.validity = '" . $validity . "' AND ir.program_id = '" . $program_id . "' AND ir.blank_type_id = '" . $blank_type_id . "' ORDER BY ir.id ASC", '%d', '%d', '%d' ), ARRAY_A );

//02.09.2021
        $result = $wpdb->get_results( $wpdb->prepare( "SELECT 
       ir.id, 
       ir.franchise, 
       ir.validity, 
       ir.insured_sum, 
       ir.price, 
       ir.locations, 
       ir.company_id, 
       ic.title as commpany_title, 
       ic.logo_url as company_logo_url, 
       ir.program_id, 
       ib.title as program_title,
       
       ( SUBSTR(ir.franchise, 1,instr(ir.franchise,' ') - 1) *1) AS franchise_number
    FROM " . $table_name_rate . " ir
    left join " . $table_name_company . " ic on ic.id = ir.company_id
    left join " . $table_name_program . " ib on ib.id = ir.program_id
    WHERE ir.validity = '" . $validity . "' AND ir.program_id = '" . $program_id . "' AND ir.blank_type_id = '" . $blank_type_id . "' ORDER BY franchise_number ASC", '%d', '%d', '%d' ), ARRAY_A );

//    $result = $wpdb->get_results( "SELECT ir.id, ir.franchise, ir.validity, ir.insured_sum, ir.price, ir.locations, ir.company_id, ic.title as commpany_title, ic.logo_url as company_logo_url, ir.program_id, ib.title as program_title
//    FROM " . $table_name_rate . " ir
//    left join " . $table_name_company . " ic on ic.id = ir.company_id
//    left join " . $table_name_program . " ib on ib.id = ir.program_id
//    WHERE ir.validity = '" . $validity . "' AND ir.program_id = '" . $program_id . "' AND ir.blank_type_id = '" . $blank_type_id . "' ORDER BY ir.id ASC;", ARRAY_A );


    // return $results;

    if( ! empty( $result ) ){


        $result = array(
            'message' => 'Знайдено полісів.',
            'result' => medical_list_render( $result, $program_id ),
//             'results' => $result
        );
        // $result = medical_list_render( $result );
    }
    else{
        $result = array(
            'message' => 'В базі данних відсутні поліси за вашими критеріями.',
            'result' => $result,
        );
    }

    echo json_encode($result);
    // echo $result;

    wp_die();
}


function medical_list_render( $insurance_list, $program_id = '' ) {

    /*
     * Получаем список отображаемых компаний
     */
    $cur_user_id = get_current_user_id();


    $result = '';

    // $result .= '<div class="step-3-results-list">';

    $results = array();

    $program_id = $program_id;

    $current_time = date('H:i:s');
    //Создаем массив компаний и сортируем по страховой выплате и компании

    if( current_user_can('create_users') ){


        foreach( $insurance_list as $item )
        {
            //Убираем СК ЕВРОИНС
            if( $item['company_id'] == 4 && $current_time < '23:00:00' )
            {
                $results[$item['insured_sum']][$item['commpany_title']]['logo'] = $item['company_logo_url'];
                $results[$item['insured_sum']][$item['commpany_title']]['validity'] = $item['validity'];
                $results[$item['insured_sum']][$item['commpany_title']]['company_id'] = $item['company_id'];
                $results[$item['insured_sum']][$item['commpany_title']]['franchise'][] = array(
                    'id' => $item['id'],
                    'franchise' =>  $item['franchise'],
                    'price' => $item['price'],
                    'program_id' => $item['program_id'],
                    'program_title' => $item['program_title'],
                    'rate_locations' => $item['locations'],
                    // 'rate_id' => $item['rate_title'],
                );
            }
            else if( $item['company_id'] != 4 )
            {
                $results[$item['insured_sum']][$item['commpany_title']]['logo'] = $item['company_logo_url'];
                $results[$item['insured_sum']][$item['commpany_title']]['validity'] = $item['validity'];
                $results[$item['insured_sum']][$item['commpany_title']]['company_id'] = $item['company_id'];
                $results[$item['insured_sum']][$item['commpany_title']]['franchise'][] = array(
                    'id' => $item['id'],
                    'franchise' =>  $item['franchise'],
                    'price' => $item['price'],
                    'program_id' => $item['program_id'],
                    'program_title' => $item['program_title'],
                    'rate_locations' => $item['locations'],
                    // 'rate_id' => $item['rate_title'],
                );
            }
        }
    }
    else
    {
        foreach( $insurance_list as $item ){

            //Убираем СК ЕВРОИНС
            if( $item['company_id'] == 4 && $current_time < '23:00:00' )
            {
                $user_company_visible_status = get_user_meta($cur_user_id, 'user_insurance_company_visible_status_' . $item['company_id'], true);

                if ($user_company_visible_status == 1) {
                    $results[$item['insured_sum']][$item['commpany_title']]['logo'] = $item['company_logo_url'];
                    $results[$item['insured_sum']][$item['commpany_title']]['validity'] = $item['validity'];
                    $results[$item['insured_sum']][$item['commpany_title']]['company_id'] = $item['company_id'];
                    $results[$item['insured_sum']][$item['commpany_title']]['franchise'][] = array(
                        'id' => $item['id'],
                        'franchise' => $item['franchise'],
                        'price' => $item['price'],
                        'program_id' => $item['program_id'],
                        'program_title' => $item['program_title'],
                        'rate_locations' => $item['locations'],
                        // 'rate_id' => $item['rate_title'],
                    );
                }
            }
            else if( $item['company_id'] != 4 )
            {
                $user_company_visible_status = get_user_meta($cur_user_id, 'user_insurance_company_visible_status_' . $item['company_id'], true);

                if ($user_company_visible_status == 1) {
                    $results[$item['insured_sum']][$item['commpany_title']]['logo'] = $item['company_logo_url'];
                    $results[$item['insured_sum']][$item['commpany_title']]['validity'] = $item['validity'];
                    $results[$item['insured_sum']][$item['commpany_title']]['company_id'] = $item['company_id'];
                    $results[$item['insured_sum']][$item['commpany_title']]['franchise'][] = array(
                        'id' => $item['id'],
                        'franchise' => $item['franchise'],
                        'price' => $item['price'],
                        'program_id' => $item['program_id'],
                        'program_title' => $item['program_title'],
                        'rate_locations' => $item['locations'],
                        // 'rate_id' => $item['rate_title'],
                    );
                }
            }

        }
    }


    //Отрисовываем HTML

    if( ! empty( $results ) ) {
        foreach ($results as $k_insured_sum => $v_insured_sum) {

            $result .= '<div class="InsuranceAmountText">' . $k_insured_sum . '</div>';

            $result .= '<div class="step-3-results-list">';
            $company_logo = '';
            foreach ($v_insured_sum as $k_company => $v_company) {
                if (!empty($v_company['logo'])) {
                    $company_logo = '<img src="' . $v_company['logo'] . '" alt="' . $k_company . '">';
                } else {
                    $company_logo = '';
                }

                $coefficient_message = '';

                if ($v_company['company_id'] == 1 or $v_company['company_id'] == 2) {
                    $coefficient_message = '<span class="coefficient-message js-coefficient-message" data-toggle="tooltip" data-placement="top" title="Цiна може бути змiнена в залежностi вiд дати народження."><i class="fa fa-info-circle" aria-hidden="true"></i></span>';
                }

                $result .= '<div class="row step-3-results-item">';
                $result .= '<div class="vc_col-md-12">';
                $result .= '<div class="step-3-results-item-top">';
                $result .= '<div class="vc_col-sm-4 vc_col-md-4"><div class="company-logo">' . $company_logo . '</div><div class="company-title">' . $k_company . '</div></div>';
                $result .= '<div class="vc_col-sm-4 vc_col-md-4"><div class="step-3-dcv"><div class="step-3-results-item-title">Оберiть франшизу</div>';

                $i = 0;
                $rate_id = '';
                $rate_franchise = '';
                $rate_locations = '';
                foreach ($v_company['franchise'] as $company) {
                    if ($i == 0) {
                        $price = $company['price'];
                        $rate_id = $company['id'];
                        $rate_franchise = $company['franchise'];
                        $rate_locations = $company['rate_locations'];
                        $result .= '<p><input type="radio" name="' . $k_insured_sum . $k_company . '" id="' . $company['id'] . '" data-insurance-price="' . $company['price'] . '" data-insurance-amount="' . $company['franchise'] . '" data-franchise-amount="' . $k_insured_sum . '" checked><label for="' . $company['id'] . '" data-insurance-price="' . $company['price'] . '" data-franchise-amount="' . $company['franchise'] . '" data-rate-location="' . $rate_locations . '">' . $company['franchise'] . '</label></p>';
                    } else {
                        $result .= '<p><input type="radio" name="' . $k_insured_sum . $k_company . '" id="' . $company['id'] . '" data-insurance-price="' . $company['price'] . '" data-insurance-amount="' . $company['franchise'] . '" data-franchise-amount="' . $k_insured_sum . '"><label for="' . $company['id'] . '" data-insurance-price="' . $company['price'] . '" data-franchise-amount="' . $company['franchise'] . '" data-rate-location="' . $company['rate_locations'] . '">' . $company['franchise'] . '</label></p>';
                    }
                    $i++;
                }


                $result .= '</div></div>';
                // $result .= '<div class="vc_col-sm-4 vc_col-md-2"><div class="step-3-price"><div class="step-3-results-item-title">Цiна</div><span class="price js-insurance-price">' . $company['price'] . '</span> <span class="currency">грн.</span></div></div>';
                $result .= '<div class="vc_col-sm-4 vc_col-md-2"><div class="step-3-price"><div class="step-3-results-item-title">Цiна ' . $coefficient_message . '</div><span class="price js-insurance-price">' . $price . '</span> <span class="currency">грн.</span></div></div>';

                // $result .= '<div class="vc_col-md-2"><button data-company-id="' . $v_company['company_id'] . '" data-cmpany-name="' . $k_company . '" data-insurance-currency="" data-insurance-period="'. $v_company['validity'] .'" data-insurance-price="' . $company['price'] . '" data-franchise-amount="' . $rate_franchise . '"  data-rate-id="'. $rate_id .'" data-rate-franchise="' . $rate_franchise . '" data-rate-validity="'. $v_company['validity'] .'" data-rate-insured-sum="'. $k_insured_sum .'" data-rate-price="' . $company['price'] . '" data-rate-locations="'. $rate_locations .'" class="btn-get-it js-get-insurance">Придбати</button></div>';
                $result .= '<div class="vc_col-md-2"><button data-program-id="' . $program_id . '" data-company-id="' . $v_company['company_id'] . '" data-cmpany-name="' . $k_company . '" data-insurance-currency="" data-insurance-period="' . $v_company['validity'] . '" data-insurance-price="' . $price . '" data-franchise-amount="' . $rate_franchise . '"  data-rate-id="' . $rate_id . '" data-rate-franchise="' . $rate_franchise . '" data-rate-validity="' . $v_company['validity'] . '" data-rate-insured-sum="' . $k_insured_sum . '" data-rate-price="' . $price . '" data-rate-locations="' . $rate_locations . '" class="btn-get-it js-get-insurance">Придбати</button></div>';

                $result .= '</div></div></div>';

            }

            $result .= '</div>';

        }
    }
    else
    {
        $result = '<p style="text-align: center">Для Вас не додано жондої компанiї. Звернiться до адмiнicтратора сайту.</p>';
    }

    return $result;

}

add_action('wp_ajax_medicalmcreateorder', 'medicalm_insurance_create_order');
add_action('wp_ajax_nopriv_medicalmcreateorder', 'medicalm_insurance_create_order');

function medicalm_insurance_create_order(){

    if( empty( $_POST['nonce'] ) ){
        wp_die('', '', 400);
    }

    check_ajax_referer( 'medical-m-create-order', 'nonce', true );

    $result = array();

    $surname = strip_tags( $_POST['surname'] );
    $name = strip_tags( $_POST['name'] );
    $passport = strip_tags( $_POST['passport'] );
    $passport_series = preg_replace("/[^A-Za-z]/", '', $passport);
    $passport_number = preg_replace("/[^0-9]/", '', $passport);
    $date = strip_tags( $_POST['date'] );

    $birthday = date("Y-m-d", strtotime($date) );
    $birthday_reverse = date("d-m-Y", strtotime($date) );

    //Convert dd.mm.yyyy to yyyy-mm-dd
    $date = date("Y-m-d", strtotime($date) );
    $date_now = date('Y-m-d');

    $address = strip_tags( $_POST['address'] );
    $tel = strip_tags( $_POST['tel'] );
    $email = strip_tags( $_POST['email'] );
    $company_id = strip_tags( $_POST['company_id'] );
    $company_title = strip_tags( $_POST['company_title'] );

    // $franchise = strip_tags( $_POST['franchise'] );
    $period = strip_tags( $_POST['period'] );
    $blank_number = strip_tags( $_POST['blank_number'] );
    $date_from = strip_tags( $_POST['date_start'] );
    $date_from = date("Y-m-d", strtotime($date_from) );
    $program_id = strip_tags( $_POST['blank_id'] );
    $program_title = strip_tags( $_POST['blank_title'] );
    $blank_series = strip_tags( $_POST['blank_series'] );
    $blank_type_id = strip_tags( $_POST['blank_type_id'] );

    if( isset( $_POST['inn'] ) )
    {
        $inn = strip_tags( $_POST['inn'] );
    }
    else
    {
        $inn = '';
    }

    if( isset( $_POST['sex'] ) )
    {
        $sex = strip_tags( $_POST['sex'] );
    }
    else
    {
        $sex = '';
    }

    if( isset( $_POST['eddr'] ) )
    {
        $eddr = strip_tags( $_POST['eddr'] );
    }
    else
    {
        $eddr = '';
    }



    $rate_id = strip_tags( $_POST['rate_id'] );
    $rate_franchise = strip_tags( $_POST['rate_franchise'] );
    $rate_validity = strip_tags( $_POST['rate_validity'] );
    $rate_insured_sum = strip_tags( $_POST['rate_insured_sum'] );
    $rate_price = strip_tags( $_POST['rate_price'] );
    $rate_locations = strip_tags( $_POST['rate_locations'] );
    $rate_coefficient = strip_tags( $_POST['rate_coefficient'] );

    $rate_price_coefficient = ( ! empty( $_POST['rate_price_coefficient'] ) ) ? $_POST['rate_price_coefficient'] : 1;

//    $test = json_decode( $_POST['test'] );
    $insurers = $_POST['insurers'];

    $insurer_status = (int) $_POST['insurer_status'];

    $current_time = date('H:i:s');


    //Цена с наценкой
    //Для компании "Провідна" ID = 1
    //Изначально надо уменьшить стоимость на 20%
    //Потом увеличиваем на выбраный коеффициент
    /*if( $company_id == 1 ){
        if( $rate_price_coefficient != 1 ){
            $rate_price = $rate_price / 1.2;
            $rate_price = $rate_price * $rate_price_coefficient;
        }
    }*/
//    $rate_price = $rate_price * $rate_price_coefficient;


    $date_to = explode("/", $period);
    $count_days = $date_to[1];
    $destinition_days = $date_to[0];
    $date_to = $date_to[0];



    $summ = $date_from . " + " . ($date_to -1) . " days";
    $date_to = date( "Y-m-d", strtotime( $summ ) );



    $pdf_url = '';

    //Получаем ID пользователя и проверяем его роль
    $user_id = get_current_user_id();
    // $user_id = 50;
    if( $user_id > 0 ){
        $user_data = get_userdata( 1 );
        $user_role = $user_data->roles[0];
        if( $user_role == 'manager' ){
            $is_manager = 1;
        }
        else{
            $is_manager = 0;
        }
    }
    else{
        $is_manager = 0;
    }

    $status = 0;
    //ВІЗА СТАНДАРТНІ БЛАНКИ
//    if( $program_id == 1 ){

    $user_years = get_full_years( $date );

    if( $user_years < 18 ){
        $result['message'][] = '<span class="message-danger">Страхувальник не може бути молодшим за 18 рокiв.</span>';
    }


    //Проверяем коеффициенты по дате рождения пользователей
    //Если статус застрахованых персон ($insurer_status) равен 0 значит мы не должны учитывать возрастной коефициент страховальника
    if( $insurer_status != 0 ){
        $coefficient_data = setCoeficient( $company_id, $user_years, $company_title, $program_title, $program_id );

        if( ! empty( $coefficient_data['message'] ) ) {
            $result['message'][] = $coefficient_data['message'];
        }

        $rate_coefficient = $coefficient_data['coefficient'];
    }
    else{
        $rate_coefficient = 1;
    }



    $error_txt_message = [];
    $error_txt_message['max_person'] = '<span class="message-danger">Багато застрахованих осіб. По даній компанії можливо застрахувати максимум 3 особи на бланк.</span>';
    // СК ПРОВІДНА
    //Считаем количество застрахованых персон, если больше 1 то выдаем сообщение об ошибке
    if( $company_id == 1 )
    {
        if( count( $insurers ) > 3 )
        {
            $result['message'][] = $error_txt_message['max_person'];
        }

        if( $insurer_status == 1 && count( $insurers ) > 2 )
        {
            $result['message'][] = $error_txt_message['max_person'];
        }
    }
    //СК ГАРДІАН
    elseif ( $company_id == 2 )
    {

//        if( empty( $inn ) ) $result['message'][] = '<span class="message-danger">IHH відсутнiй.</span>';
        if( empty( $inn) && empty( $eddr ) ) $result['message'][] = '<span class="message-danger">IHH або ЕДДР відсутнi.</span>';
        if( empty( $sex ) ) $result['message'][] = '<span class="message-danger">Стать не вказана.</span>';

        if( count( $insurers ) > 1 )
        {
            $result['message'][] = '<span class="message-danger">Багато застрахованих осіб. По даній компанії можливо застрахувати максимум 1 особу на бланк.</span>';
        }

        if( $insurer_status == 1 && count( $insurers ) > 1 )
        {
            $result['message'][] = '<span class="message-danger">Багато застрахованих осіб. По даній компанії можливо застрахувати максимум 1 особу на бланк.</span>';
        }
    }
//    elseif ( $company_id == 2 )
//    {
//        if( count( $insurers ) > 3 )
//        {
//            $result['message'][] = $error_txt_message['max_person'];
//        }
//
//        if( $insurer_status == 1 && count( $insurers ) > 2 )
//        {
//            $result['message'][] = $error_txt_message['max_person'];
//        }
//    }
    //СК Ю.ЕС.АЙ
    elseif ( $company_id == 3 )
    {
        if( count( $insurers ) > 3 )
        {
            $result['message'][] = $error_txt_message['max_person'];
        }

        if( $insurer_status == 1 && count( $insurers ) > 2 )
        {
            $result['message'][] = $error_txt_message['max_person'];
        }
    }
    //СК ЄВРОІНС
    elseif ( $company_id == 4 )
    {
        if( count( $insurers ) > 1 )
        {
            $result['message'][] = '<span class="message-danger">Багато застрахованих осіб. По даній компанії можливо застрахувати максимум 1 особу на бланк.</span>';;
        }

        if( $insurer_status == 1 && count( $insurers ) > 1 )
        {
            $result['message'][] = '<span class="message-danger">Багато застрахованих осіб. По даній компанії можливо застрахувати максимум 1 особу на бланк.</span>';;
        }
    }
    //СК ІНТЕР-ПЛЮС
    elseif ( $company_id == 5 )
    {
        if( count( $insurers ) > 3 )
        {
            $result['message'][] = $error_txt_message['max_person'];
        }

        if( $insurer_status == 1 && count( $insurers ) > 2 )
        {
            $result['message'][] = $error_txt_message['max_person'];
        }
    }
    //СК ЕКТА
    elseif ( $company_id == 6 )
    {
        if( count( $insurers ) > 2 )
        {
            $result['message'][] = '<span class="message-danger">Багато застрахованих осіб. По даній компанії можливо застрахувати максимум 2 особи на бланк.</span>';;
        }

        if( $insurer_status == 1 && count( $insurers ) > 1 )
        {
            $result['message'][] = '<span class="message-danger">Багато застрахованих осіб. По даній компанії можливо застрахувати максимум 2 особи на бланк.</span>';;
        }
    }


    //ЕВРОИНС
    if( $company_id == 4 && $current_time > '23:00:00' )
    {
        $result['message'][] = '<span class="message-danger">Для СК Евроiнс оформлення договорiв пiсля 23:00 заборонено.</span>';
    }



    //Вроверяем на пустоту переданые параметры
    if( empty( $surname ) ) $result['message'][] = '<span class="message-danger">Поле "Прiзвище" заповнено не коректно.</span>';
    if( empty( $name ) ) $result['message'][] = '<span class="message-danger">Поле "Iм\'я" заповнено не коректно.</span>';
    if( empty( $passport ) ) $result['message'][] = '<span class="message-danger">Поле "Серiя, номер паспорта" заповнено не коректно.</span>';
    if( empty( $date ) ) $result['message'][] = '<span class="message-danger">Поле "Дата народження" заповнено не корректно.</span>';
    if( empty( $address ) ) $result['message'][] = '<span class="message-danger">Поле "Адреса постійного місця проживання" заповнено не коректно.</span>';
    // if( empty( $tel ) ) $result['message'][] = '<span class="message-danger">Поле "Телефон" заповнено не коректно.</span>'; 
    // if( empty( $email ) ) $result['message'][] = '<span class="message-danger">Поле "Email" заповнено не коректно.</span>'; 
    if( empty( $company_id ) ) $result['message'][] = '<span class="message-danger">Відсутня така страхова компанія.</span>';
    if( empty( $company_title ) ) $result['message'][] = '<span class="message-danger">Відсутня назва страхової компанії.</span>';

    // if( empty( $franchise ) ) $result['message'][] = 'Поле "Франшиза" заповнено не коректно.'; 
    if( empty( $period ) ) $result['message'][] = '<span class="message-danger">Поле "перiод страхування" заповнено не коректно.</span>';

    if( empty( $date_from ) ) $result['message'][] = '<span class="message-danger">Поле "Дата початку дiї договору" заповнено не коректно.</span>';
    if( empty( $program_id ) ) $result['message'][] = '<span class="message-danger">Поле "Оберіть бланк" заповнено не коректно.</span>';
    if( empty( $program_title ) ) $result['message'][] = '<span class="message-danger">Назва програми відсутня.</span>';
    //Тип бланка "Паперовий"
    if( $blank_type_id == 1 ) {
        if (empty($blank_number)) $result['message'][] = '<span class="message-danger">Поле "Номер бланка" заповнено не коректно.</span>';
    }

    //Тип бланка "Паперовий"
    if( $blank_type_id == 1 ){
        if( empty( $blank_series ) ) $result['message'][] = '<span class="message-danger">Відсутня серiя бланка.</span>';
    }


    if( empty( $rate_id ) ) $result['message'][] = '<span class="message-danger">ID тарифа відсутнє.</span>';
    if( empty( $rate_franchise ) ) $result['message'][] = '<span class="message-danger">"Франшиза" не вибрана.</span>';
    if( empty( $rate_validity ) ) $result['message'][] = '<span class="message-danger">"Перiод страхування" не вибраний.</span>';
    if( empty( $rate_insured_sum ) ) $result['message'][] = '<span class="message-danger">Страхова сума відсутня.</span>';
    if( empty( $rate_price ) ) $result['message'][] = '<span class="message-danger">Ціна страхового полюча відсутня.</span>';
    if( empty( $rate_locations ) ) $result['message'][] = '<span class="message-danger">Територія дії відсутня.</span>';


    //Проверяем заполнены ли данные в "страховых особах"
    if( ! empty( $insurers ) ){

        $insurer_count = 1;

        foreach ( $insurers as $insurer ){

            if( empty( $insurer['lastName'] ) ) $result['message'][] = '<span class="message-danger">Не вказано прізвище у застрахованої особи №'. $insurer_count . '.</span>';
            if( empty( $insurer['name'] ) ) $result['message'][] = '<span class="message-danger">Не вказано ім\'я у застрахованої особи №'. $insurer_count . '.</span>';
            if( empty( $insurer['date'] ) ) $result['message'][] = '<span class="message-danger">Не вказана дата народження у застрахованої особи №'. $insurer_count . '.</span>';
            if( empty( $insurer['passport'] ) ) $result['message'][] = '<span class="message-danger">Не вказанні паспортні дані у застрахованої особи №'. $insurer_count . '.</span>';
            if( empty( $insurer['address'] ) ) $result['message'][] = '<span class="message-danger">Не вказано адреса у застрахованої особи №'. $insurer_count . '.</span>';

            $insurer_date = get_full_years( $insurer['date'] );
            //Проверяем коеффициенты по дате рождения пользователей
            $coefficient_data = setCoeficient( $company_id, $insurer_date, $company_title, $program_title, $program_id );

            if( ! empty( $coefficient_data['message'] ) ) {
                $result['message'][] = $coefficient_data['message'];
            }

            $insurer_count ++;
        }
    }

    $data = array();

    $data['surname'] = $surname;
    $data['name'] = $name;
    $data['passport'] = $passport;
    $data['date'] = $date;
    $data['address'] = $address;
    $data['tel'] = $tel;
    $data['email'] = $email;
    $data['company_id'] = $company_id;
    $data['period'] = $period;
    $data['date_start'] = $date_from;
    $data['program_id'] = $program_id;
    $data['blank_number'] = $blank_number;
    $data['blank_series'] = $blank_series;

    $data['rate_id'] = $rate_id;
    $data['rate_franchise'] = $rate_franchise;
    $data['rate_validity'] = $rate_validity;
    $data['rate_insured_sum'] = $rate_insured_sum;
    $data['rate_price'] = $rate_price;
    $data['rate_locations'] = $rate_locations;

    $data['user_id'] = $user_id;
    $data['user_role_text'] = $user_data->roles[0];
    $data['user_role'] = $user_role;
    $data['insurers'] = $insurers;


    // $result['message'][] = 'Поліс успішно оформлено';
    // $result['data'] = $data;


    // $query = $wpdb->insert( $table_name, array( 'program_id' => $program_id, 'program_title' => $program_title, 'blank_number' => $blank_number, 'blank_series' => $blank_series,
    // 'company_id' => $company_id, 'company_title' => $company_title, 'rate_id' => $rate_id, 'rate_franchise' => $rate_franchise, 'rate_validity' => $rate_validity,
    // 'rate_insured_sum' => $rate_insured_sum, 'rate_price' => $rate_price, 'rate_locations' => $rate_locations, 'name' => $name, 'last_name' => $surname,
    // 'passport' => $passport, 'birthday' => $date, 'address' => $address, 'phone_number' => $tel, 'email' => $email, 'pdf_url' => $pdf_url, 'is_manager' => $is_manager, 'user_id' => $user_id, 'status' => 1 ), array( '%d', '%s', '%d', '%s', '%d', '%s', '%d', '%s', '%s', '%s', '%d', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%d', '%d', '%d' ));





    // echo json_encode( $result );

    // wp_die();


    //Проверяем достоверность даных полученых из фронта
    global $wpdb;

    $table_name_rate = $wpdb->get_blog_prefix() . 'insurance_rate';

    $authenticity = $wpdb->get_row( "SELECT * FROM plc_insurance_rate WHERE id = ".$rate_id." ", ARRAY_A );


    if( $authenticity['price'] != $rate_price ){
        $result['message'][] = '<span class="message-danger">Були переданi недостовiрнi данi.</span>';
    }









    //Если ошибок нет, то продолжаем выполнение
    if( empty( $result['message'] ) ){


        /*
         * Оформляем договор
         * $blank_type_id = 1 - "Паперовий бланк"
         * $blank_type_id = 2 - "електронний бланк"
         * */

        if( $blank_type_id == 1 ) {

            $paper = true;

            $table_name = $wpdb->get_blog_prefix() . 'insurance_orders';
            $table_name_number_of_blank = $wpdb->get_blog_prefix() . 'insurance_number_of_blank';
            $insurance_statuses = $wpdb->get_blog_prefix() . 'insurance_statuses';

            //Проверяем оформлена ли уже страховка по такому номеру бланка

            //        $has_blank = $wpdb->get_results( $wpdb->prepare( "SELECT id FROM " . $table_name . " WHERE blank_number = %d AND status = 1", $blank_number ), ARRAY_A );

            $has_blank = $wpdb->get_results($wpdb->prepare("SELECT o.id FROM " . $table_name . " o INNER JOIN " . $insurance_statuses . " s ON s.id = o.status WHERE o.blank_number = %d AND o.company_id = %d AND blank_series = %s AND o.status = 1 AND s.freeBlank != 1", $blank_number, $company_id, $blank_series ), ARRAY_A);

            // 07.12.2021
            // $has_blank = $wpdb->get_results($wpdb->prepare("SELECT o.id FROM " . $table_name . " o INNER JOIN " . $insurance_statuses . " s ON s.id = o.status WHERE o.blank_number = %d AND s.freeBlank != 1", $blank_number), ARRAY_A);

            ////Если такой бланк еще небыл оформлен идем дальше
            if (empty($has_blank)) {
                //Ищем попадает ли указаный номер бланка в диапазон БЛАНКОВ в таблице
                $has_blank = $wpdb->get_results("SELECT id, comments FROM " . $table_name_number_of_blank . " WHERE company_id = " . $company_id . " AND blank_series = '" . $blank_series . "' AND " . $blank_number . " >= number_start AND " . $blank_number . " <= number_end AND status = 1", ARRAY_A);
                // $result['message'][] = 'Такого бланка еще нет. Будем пробовать добавить.';

                //Если бланк входит в диапазон бланков то записываем ОРДЕР в таблицу
                if (!empty($has_blank)) {

                    //Записываем ИД и коментарий бланка
                    $number_blank_id = $has_blank[0]['id'];
                    $number_blank_comment = $has_blank[0]['comments'];

                    $user_string_id = get_parents_id($user_id);

                    if ($user_string_id == '') {
                        $user_string_id = $user_id;
                    }


                    $table_blank_to_manager = $wpdb->get_blog_prefix() . 'insurance_blank_to_manager';
                    ////Проверяем попадает ли указаный номер бланка в диапазон БЛАНКОВ менеджера
                    //$has_manager_blank = $wpdb->get_results( "SELECT id FROM " . $table_blank_to_manager . " WHERE manager_id=" . $user_id . " AND number_of_blank_id=" . $number_blank_id . " AND " . $blank_number . " >= number_start AND " . $blank_number . " <= number_end AND status = 1", ARRAY_A );
                    $has_manager_blank = $wpdb->get_results("SELECT id FROM " . $table_blank_to_manager . " WHERE manager_id IN (" . $user_string_id . ") AND number_of_blank_id=" . $number_blank_id . " AND " . $blank_number . " >= number_start AND " . $blank_number . " <= number_end AND status = 1", ARRAY_A);
                   if( ! empty( $has_manager_blank ) ){
//                     if( 1 ){

                    $unicue_code = random_string();

                    $cashback = get_user_meta($user_id, "user_return_percent_medical_company_id_" . $company_id, 1);

                    $table_name = $wpdb->get_blog_prefix() . 'insurance_orders';
                    $table_name_insurance_program = $wpdb->get_blog_prefix() . 'insurance_program';

                    $program_title_original = $wpdb->get_row("SELECT title FROM " . $table_name_insurance_program . " WHERE id = " . (int)$program_id . " AND status = 1", ARRAY_A);
                    $program_title_original = $program_title_original['title'];

                    $query = $wpdb->insert($table_name, array('program_id' => $program_id, 'program_title' => $program_title_original, 'number_blank_id' => $number_blank_id, 'number_blank_comment' => $number_blank_comment, 'blank_number' => $blank_number,
                        'blank_series' => $blank_series, 'company_id' => $company_id, 'company_title' => $company_title, 'rate_id' => $rate_id, 'rate_franchise' => $rate_franchise,
                        'rate_validity' => $rate_validity, 'rate_insured_sum' => $rate_insured_sum, 'rate_price' => $rate_price, 'rate_locations' => $rate_locations, 'name' => $name,
                        'last_name' => $surname, 'passport' => $passport, 'birthday' => $date, 'address' => $address, 'phone_number' => $tel, 'email' => $email, 'date_from' => $date_from,
                        'date_to' => $date_to, 'count_days' => $count_days, 'pdf_url' => $pdf_url, 'is_manager' => $is_manager, 'user_id' => $user_id, 'cashback' => $cashback, 'status' => 1, 'rate_coefficient' => $rate_coefficient, 'rate_price_coefficient' => $rate_price_coefficient, 'unicue_code' => $unicue_code, 'insurer_status' => $insurer_status, 'blank_type_id' => $blank_type_id, 'sex' =>  $sex, 'inn' => $inn, 'eddr' => $eddr ),
                        array('%d', '%s', '%d', '%s', '%d', '%s', '%d', '%s', '%d', '%s', '%s', '%s', '%f', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%d', '%s', '%d', '%d', '%f', '%d', '%f', '%f', '%s', '%d', '%d', '%s', '%s', '%s' ));

                    $order_id = $wpdb->insert_id;
                    // $query = $wpdb->insert( $table_name, array( 'program_id' => $program_id, 'program_title' => $program_title, 'blank_number' => $blank_number,
                    // 'blank_series' => $blank_series, 'company_id' => $company_id, 'company_title' => $company_title, 'rate_id' => $rate_id, 'rate_franchise' => $rate_franchise,
                    // 'rate_validity' => $rate_validity, 'rate_insured_sum' => $rate_insured_sum, 'rate_price' => $rate_price, 'rate_locations' => $rate_locations, 'name' => $name,
                    // 'last_name' => $surname, 'passport' => $passport, 'birthday' => $date, 'address' => $address, 'phone_number' => $tel, 'email' => $email, 'date_from' => $date_from,
                    // 'date_to' => $date_to, 'count_days' => $count_days, 'pdf_url' => $pdf_url, 'is_manager' => $is_manager, 'user_id' => $user_id, 'cashback' => $cashback,'status' => 1, 'rate_coefficient' => $rate_coefficient ),
                    // array( '%d', '%s', '%d', '%s', '%d', '%s', '%d', '%s', '%s', '%s', '%f', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%d', '%s', '%d', '%d', '%f', '%d', '%f' ));

//                     $result['message'][] = $query;

                    //Если у нас есть Страховальники и был создан договор то можно добавлять новые данные
                    if ($query && !empty($insurers)) {

                        $table_name = $wpdb->get_blog_prefix() . 'insurance_insurer';

                        foreach ($insurers as $insurer) {

                            $insurer_last_name = $insurer['lastName'];
                            $insurer_name = $insurer['name'];
                            $insurer_date = date("Y-m-d", strtotime($insurer['date']));
                            $insurer_coefficient_date = get_full_years($insurer['date']);
                            $insurer_passport = $insurer['passport'];
                            $insurer_address = $insurer['address'];

                            //                        date("Y-m-d", strtotime($date) );
                            //Проверяем коеффициенты по дате рождения пользователей
                            $coefficient_data = setCoeficient($company_id, $insurer_coefficient_date, $company_title, $program_title, $program_id);

                            $rate_coefficient = $coefficient_data['coefficient'];


                            $insurer_query = $wpdb->insert($table_name, array('order_id' => $order_id, 'last_name' => $insurer_last_name, 'name' => $insurer_name, 'birthday' => $insurer_date, 'passport' => $insurer_passport, 'address' => $insurer_address, 'coefficient' => $rate_coefficient, 'price' => $rate_price),
                                array('%d', '%s', '%s', '%s', '%s', '%s', '%f', '%f'));


                            if (!$insurer_query) {
                                $result['message'][] = '<span class="message-danger">Не вдалося записати страхувальників в базу данних.</span>';
                            }


                        }

                    }


                    if ($query) {

                        //CK GARDIAN
                        if ($company_id == 2) {
                           /* $dateNow = date("d.m.Y");

                            if ($dateNow == "11.02.2021") {
                                $wpdb->query("UPDATE `" . $table_name . "` SET `date_added` = DATE_FORMAT(date_added, '%Y-%m-08 %H:%i:%s') WHERE `id` = " . $wpdb->insert_id);
                            }

                            if ($dateNow == "12.02.2021") {
                                $wpdb->query("UPDATE `" . $table_name . "` SET `date_added` = DATE_FORMAT(date_added, '%Y-%m-09 %H:%i:%s') WHERE `id` = " . $wpdb->insert_id);
                            }

                            if ($dateNow == "13.02.2021") {
                                $wpdb->query("UPDATE `" . $table_name . "` SET `date_added` = DATE_FORMAT(date_added, '%Y-%m-10 %H:%i:%s') WHERE `id` = " . $wpdb->insert_id);
                            }
*/


//                            $gardian = new GardianPaper(__DIR__);
                            $gardian = new Gardian(__DIR__);
                            $currencyRate = '30.3376';
                            $gardian_status = 'Draft';
                            $gardian_phone = $gardian->format_phone_number( $tel );
                            $rate_franchise_number = preg_replace("/[^0-9]/", '', $rate_franchise);

                            $gardian_date_to = $date_from . " + 1 year";
                            $gardian_date_to = $gardian_date_to . " - 1 days";
                            $gardian_date_to = date( "Y-m-d", strtotime( $gardian_date_to ) );


                            if( $sex == 'M' )
                            {
                                $sex = 'Male';
                            }
                            elseif ( $sex == 'W' )
                            {
                                $sex = 'Female';
                            }

                            $gardian_rate_insured_sum = preg_replace("/[^0-9]*/",'',$rate_insured_sum);

                            $gardian_product_id = '';
                            // 68947399-4db5-11eb-b19c-00155df66a18 - D (Латвія)
                            // 68947398-4db5-11eb-b19c-00155df66a18 - E (Чехія)
                            // 68947396-4db5-11eb-b19c-00155df66a18 - А (Work)
                            //	6894739a-4db5-11eb-b19c-00155df66a18 - М (Європа)
                            //	aea90dd0-75aa-11eb-b19f-00155df66a18 - М (СНД)
                            if( $program_id == 1 )
                            {
                                $gardian_product_id = '68947396-4db5-11eb-b19c-00155df66a18';
                            }
                            elseif ( $program_id == 3 )
                            {
                                $gardian_product_id = '6894739a-4db5-11eb-b19c-00155df66a18';
                            }
                            elseif ( $program_id == 4 )
                            {
                                $gardian_product_id = '68947398-4db5-11eb-b19c-00155df66a18';
                            }


                            $blankType =  $paper === false ? "true" : "false";

                            $gardian_data = [
                                'agr[GUID]' => '',
                                'agr[Blank][BlankGUID]' => '',
                                'agr[Blank][BlankName]' => '',
                                'agr[Blank][BlankComment]' => '',
                                'agr[Blank][BlankComment2]' => '',
                                'agr[Blank][NumberLength]' => 0,
                                'agr[BlankNumber]' => 0,
                                'agr[Sticker][BlankGUID]' => '37e5ec78_2fe2_11ec_b1b2_00155dae7a01', // Тип номерного бланка GUID (Всегда такое значение)
                                'agr[Sticker][BlankName]' => 'GR', // Тип номерного бланка (Всегда такое значение)
                                'agr[Sticker][BlankComment]' => '',
                                'agr[Sticker][BlankComment2]' => '',
                                'agr[Sticker][NumberLength]' => 0,
                                'agr[StickerNumber]' => $blank_number,
                                'agr[Number]' => '',
                                'agr[Product]' => 'ВЗРКон',
                                'agr[Date]' => $date_now,
                                'agr[BegDate]' => $date_from,
                                'agr[EndDate]' => $gardian_date_to,
                                'agr[Summ]' => $rate_price * $rate_coefficient,
                                'agr[Customer][CustomerName]' => $surname . ' ' . $name,
                                'agr[Customer][CustomerFullName]' => $surname . ' ' . $name,
                                'agr[Customer][CustomerFName]' => '',
                                'agr[Customer][CustomerLName]' => '',
                                'agr[Customer][CustomerSName]' => '',
                                'agr[Customer][CustomerType]' => 'person',
                                'agr[Customer][CustomerCode]' => $inn,
                                'agr[Customer][CustomerBDate]' => $birthday,
                                'agr[Customer][CustomerForeigner]' => 'false',
                                'agr[Customer][CustomerPersonWithoutCode]' => 'false',
                                'agr[Customer][CustomerPhone]' => $gardian_phone,
                                'agr[Customer][CustomerAddress]' => $address,
                                'agr[Customer][CustomerAddressLat]' => $address,
                                'agr[Customer][CustomerPassport][DocType]' => '',
                                'agr[Customer][CustomerPassport][DocSeries]' => '',
                                'agr[Customer][CustomerPassport][DocNumber]' => '',
                                'agr[Customer][CustomerPassport][DocDate]' => '',
                                'agr[Customer][CustomerPassport][DocSourceOrg]' => '',
                                'agr[Customer][CustomerDriversLicense][DocType]' => '',
                                'agr[Customer][CustomerDriversLicense][DocSeries]' => '',
                                'agr[Customer][CustomerDriversLicense][DocNumber]' => '',
                                'agr[Customer][CustomerDriversLicense][DocDate]' => '0001-01-01T00:00:00',
                                'agr[Customer][CustomerDriversLicense][DocSourceOrg]' => '',
                                'agr[Customer][CustomerPreferentialDocument][DocType]' => '',
                                'agr[Customer][CustomerPreferentialDocument][DocSeries]' => '',
                                'agr[Customer][CustomerPreferentialDocument][DocNumber]' => '',
                                'agr[Customer][CustomerPreferentialDocument][DocDate]' => '0001-01-01T00:00:00',
                                'agr[Customer][CustomerPreferentialDocument][DocSourceOrg]' => '',
                                'agr[Customer][CustomerInternationalPassport][DocType]' => 'InternationalPassport',
                                'agr[Customer][CustomerInternationalPassport][DocSeries]' => $passport_series,
                                'agr[Customer][CustomerInternationalPassport][DocNumber]' => $passport_number,
                                'agr[Customer][CustomerInternationalPassport][DocDate]' => '0001-01-01',
                                'agr[Customer][CustomerInternationalPassport][DocSourceOrg]' => '',
                                'agr[Customer][CustomerNameLat]' => $surname . ' ' . $name,
                                'agr[Customer][CustomerIncorrectCode]' => 'false',
                                'agr[Customer][CustomerContactPerson]' => '',
                                'agr[Customer][CustomerBankAccount]' => '',
                                'agr[Customer][CustomerGUID]' => '',
                                'agr[Customer][CustomerCitizenshipCountry][EnumVal]' => '',
                                'agr[Customer][CustomerCitizenshipCountry][EnumName]' => '',
                                'agr[Customer][CustomerCitizenshipCountry][EnumFlag]' => 'false',
                                'agr[Customer][CustomerCitizenshipCountry][EnumRate]' => 0,
                                'agr[Customer][CustomerEmail]' => $email,
                                'agr[Customer][CustomerEDDRCode]' => $eddr,
                                'agr[Customer][CustomerGender]' => $sex,
                                'agr[Beneficiary]' => '',
                                'agr[BeneficiaryIsCustomer]' => 'false',
                                'agr[Srok]' => 0,
                                'agr[BonusMalus]' => 0,
                                'agr[Zone]' => 0,
                                'agr[Objects][0][Mark]' => '',
                                'agr[Objects][0][Model]' => '',
                                'agr[Objects][0][VIN]' => '',
                                'agr[Objects][0][RegNum]' => '',
                                'agr[Objects][0][YearOfCreation]' => 0,
                                'agr[Objects][0][Type]' => '',
                                'agr[Objects][0][ObjectGUID]' => '',
                                'agr[Objects][0][Name]' => $surname . ' ' . $name,
                                'agr[Objects][0][NameLat]' => $surname . ' ' . $name,
                                'agr[Objects][0][Date]' => $birthday,
                                'agr[Objects][0][InternationalPassport][DocType]' => '',
                                'agr[Objects][0][InternationalPassport][DocSeries]' => $passport_series,
                                'agr[Objects][0][InternationalPassport][DocNumber]' => $passport_number,
                                'agr[Objects][0][InternationalPassport][DocDate]' => '0001-01-01T00:00:00',
                                'agr[Objects][0][InternationalPassport][DocSourceOrg]' => '',
                                'agr[Objects][0][Address]' => $address,
                                'agr[Objects][0][Phone]' => $gardian_phone,
                                'agr[Objects][0][DecimalOption1]' => $rate_price * $rate_coefficient,
                                'agr[Objects][0][DecimalOption2]' => 0,
                                'agr[Objects][0][AddressLat]' => $address,
                                'agr[Objects][0][ObjType]' => '',
                                'agr[Objects][0][StringOption1]' => '',
                                'agr[UnusedMonthes][M1]' => 'false',
                                'agr[UnusedMonthes][M2]' => 'false',
                                'agr[UnusedMonthes][M3]' => 'false',
                                'agr[UnusedMonthes][M4]' => 'false',
                                'agr[UnusedMonthes][M5]' => 'false',
                                'agr[UnusedMonthes][M6]' => 'false',
                                'agr[UnusedMonthes][M7]' => 'false',
                                'agr[UnusedMonthes][M8]' => 'false',
                                'agr[UnusedMonthes][M9]' => 'false',
                                'agr[UnusedMonthes][M10]' => 'false',
                                'agr[UnusedMonthes][M11]' => 'false',
                                'agr[UnusedMonthes][M12]' => 'false',
                                'agr[OTKFlag]' => 'false',
                                'agr[OTK6Flag]' => 'false',
                                'agr[OTKDate]' => '0001-01-01T00:00:00',
                                'agr[Preference]' => '',
                                'agr[Franchise]' => $rate_franchise_number,
                                'agr[OSAGOValues][K1]' => 0,
                                'agr[OSAGOValues][K2]' => 0,
                                'agr[OSAGOValues][K3]' => 0,
                                'agr[OSAGOValues][K4]' => 0,
                                'agr[OSAGOValues][K5]' => 0,
                                'agr[OSAGOValues][K6]' => 0,
                                'agr[OSAGOValues][K7]' => 0,
                                'agr[OSAGOValues][K8]' => 0,
                                'agr[OSAGOValues][K9]' => 0,
                                'agr[PayDate]' => '0001-01-01T00:00:00',
                                'agr[PayDoc]' => '',
                                'agr[RegistrationPlace]' => '',
                                'agr[StazhDo3Let]' => 'false',
                                'agr[CommerceUse]' => 'false',
                                'agr[Status]' => $gardian_status,
                                'agr[Deleted]' => 'false',
                                'agr[ParentAgreementGUID]' => '',
                                'agr[ParentAgreementNumber]' => '',
                                'agr[ParentAgreementDate]' => '0001-01-01T00:00:00',
                                'agr[CrossAgreementGUID]' => '',
                                'agr[CrossAgreementNumber]' => '',
                                'agr[CrossAgreementDate]' => '0001-01-01T00:00:00',
                                'agr[BlankStatus]' => '',
                                'agr[SalesChannelGUID]' => 'bd909c32_2b2a_11eb_b19b_00155df66a18', // Канал продажу: Агентський - Агенти-вільний ринок  (Всегда)
                                'agr[SalesChannelParentGUID]' => '',
                                'agr[Partner]' => '',
                                'agr[ParkDiscount]' => 0,
                                'agr[ParkDiscountStr]' => '',
                                'agr[BMR]' => 'false',
                                'agr[ValidationCode]' => '',
                                'agr[Countries]' => '047c8592-4e59-11eb-b19c-00155df66a18', // Територія покриття: Європа / Europe (Всегда)
                                'agr[Country]' => '',
                                'agr[PaymentSchedule][0][PaymentNum]' => 0,
                                'agr[PaymentSchedule][0][PaymentDate]' => '0001-01-01T00:00:00',
                                'agr[PaymentSchedule][0][PaymentSum]' => 0,
                                'agr[SpecialTariff]' => 'false',
                                'agr[MultiUse]' => 'false',
                                'agr[BoolOption1]' => 'false',
                                'agr[BoolOption2]' => 'true',
                                'agr[BoolOption3]' => 'false',
                                'agr[BoolOption4]' => 'false',
                                'agr[BoolOption5]' => 'false',
                                'agr[StringOption1]' => '',
                                'agr[StringOption2]' => '',
                                'agr[Currency]' => 'EUR',
                                'agr[AgreementType]' => '',
                                'agr[DurationType]' => $count_days,
                                'agr[KV]' => 0,
                                'agr[Summ1]' => $gardian_rate_insured_sum,
                                'agr[Summ2]' => 0,
                                'agr[Summ3]' => 0,
                                'agr[Summ4]' => 0,
                                'agr[Summ5]' => 0,
                                'agr[Tariff]' => 0,
                                'agr[Prem1]' => $rate_price * $rate_coefficient,
                                'agr[Prem2]' => 0,
                                'agr[Prem3]' => 0,
                                'agr[Prem4]' => 0,
                                'agr[Prem5]' => 0,
                                'agr[Corr1]' => 0,
                                'agr[Corr2]' => 0,
                                'agr[Corr3]' => 0,
                                'agr[CurrencyRate]' => $currencyRate,
                                'agr[TerritorySPType]' => '',
                                'agr[Sighner][EnumVal]' => '',
                                'agr[Sighner][EnumName]' => '',
                                'agr[Sighner][EnumFlag]' => 'false',
                                'agr[Sighner][EnumRate]' => 0,
                                'agr[ProxyDoc][EnumVal]' => '',
                                'agr[ProxyDoc][EnumName]' => '',
                                'agr[ProxyDoc][EnumFlag]' => 'false',
                                'agr[ProxyDoc][EnumRate]' => 0,
                                'agr[MaxTariff]' => 'false',
                                'agr[IsPaid]' => 'false',
                                'agr[Agent][EnumVal]' => '',
                                'agr[Agent][EnumName]' => '',
                                'agr[Agent][EnumFlag]' => 'false',
                                'agr[Agent][EnumRate]' => 0,
                                'agr[ProductGUID]' => $gardian_product_id,
                                'agr[TariffProp]' => '',
                                'agr[Digital]' => $blankType,
                                'agr[Password]' => '',
                                'agr[UsedBlanks]' => ''
                            ];

                            //Если мы страхуем ДРУГОГО ЧЕЛОВЕКА
                            if( $insurer_status == 0 ) {
                                if (!empty ($insurers)) {
                                    foreach ($insurers as $insurer) {

                                        $insurer_passport_series = preg_replace("/[^A-Za-z]/", '', $insurer['passport']);
                                        $insurer_passport_number = preg_replace("/[^0-9]/", '', $insurer['passport']);

                                        $gardian_data['agr[Objects][0][Name]'] = $insurer['lastName'] . ' ' . $insurer['name'];
                                        $gardian_data['agr[Objects][0][NameLat]'] = $insurer['lastName'] . ' ' . $insurer['name'];
                                        $gardian_data['agr[Objects][0][Date]'] = date("Y-m-d", strtotime($insurer['date']));
                                        $gardian_data['agr[Objects][0][InternationalPassport][DocSeries]'] = $insurer_passport_series;
                                        $gardian_data['agr[Objects][0][InternationalPassport][DocNumber]'] = $insurer_passport_number;
                                        $gardian_data['agr[Objects][0][Address]'] = $insurer['address'];
                                        $gardian_data['agr[Objects][0][AddressLat]'] = $insurer['address'];

                                    }
                                }
                            }


                            $result['message'][] = $gardian_data;

                            // РЕГИСТРАЦИЯ ДОГОВОРА
                            if($gardian->loginPage()){
                                if($gardian->login() == 200){
                                    //Устанавлтваем курс
                                    $gardian->getCurrencyRate();
                                    $gardian_order = $gardian->createOrder($gardian_data);
//                                    $gardian_order = $gardian->createPaperOrder($gardian_data);

//                                    $result['message'][] = $gardian_order;

                                    if( ! $gardian_order['Result'] )
                                    {
                                        $result['status'] = false;
                                        foreach ( $gardian_order['Messages'] as $error_smg )
                                        {
                                            $result['message'][] = '<span class="message-danger">' . $error_smg . '</span>';
                                        }
                                    }

                                    if(is_array($gardian_order)){
                                        if(array_key_exists('Messages', $gardian_order) && count($gardian_order['Messages']) >= 4 && array_key_exists('Result', $gardian_order) && $gardian_order['Result'] == 1){
                                            $gardian_data['agr[GUID]'] = $gardian_order['Messages'][0];
                                            $gardian_data['agr[Customer][CustomerGUID]'] = $gardian_order['Messages'][1];
                                            $gardian_data['agr[Number]'] = $gardian_order['Messages'][2];
                                            $gardian_data['agr[BlankNumber]'] = explode("-", $gardian_order['Messages'][2])[1];
                                            $gardian_data['agr[Objects][0][ObjectGUID]'] = $gardian_order['Messages'][3];

//                                            $result['message'][] = $gardian_data;
                                            $gardian_result = $gardian->changeOrderStatus($gardian_data, "Signed");
//                                            $gardian_result = $gardian->changeStatusPaperOrder($gardian_data, "Signed");


//                                            $result['message'][] = $gardian_result;
//
                                            $gardian_order_data = [
                                                'gardian_GUID' => $gardian_result['Messages'][0],
                                                'gardian_CustomerGUID' => $gardian_result['Messages'][1],
                                                'gardian_Number' => $gardian_result['Messages'][2],
                                                'gardian_ObjectGUID' => $gardian_result['Messages'][3],
                                                'order_id' => $order_id,
                                                'status' => 1,
                                            ];

                                            $st = $gardian->add_order_data( $gardian_order_data );

//                                            $result['message'][] = $st;
                                            $result['status'] = true;
                                            $result['message'][] = '<span class="message-ok">Вітаємо, поліс успішно оформлений.</span>';
                                            $result['last_step_html'] = '<a class="get-new-medical-order" href="/medical-m/">Оформити новий поліс</a><a target="_blank" class="download-medical-order" href="/wp-content/plugins/insurance/order-print/paper/index.php?order_id=' . $order_id . '&key=WPbm49ebf124">Скачати поліс</a>';
                                        }
                                    }
                                    else
                                    {
                                        $result['status'] = false;
                                        $result['message'][] = '<span class="message-danger">Не вдалося додати договip.</span>';
                                        $result['message'][] = $gardian_order;
                                    }
                                }
                                else
                                {
                                    $result['status'] = false;
                                    $result['message'][] = '<span class="message-danger">Не вдалося залогiнитись в СК ГАРДIАН.</span>';
                                }
                            }
                            else
                            {
                                $result['status'] = false;
                                $result['message'][] = '<span class="message-danger">Не вдалося увiйти до СК ГАРДIАН.</span>';
                            }


                            if( $result['status'] == false )
                            {
                                $gardian->remove_order( $order_id );
                            }

                        }
                        //СК ЄВРОІНС
                        /*elseif ( $company_id == 4 )
                        {

                            $euroins = new Euroins();

                            $euroins_result = $euroins->reserve( $data );

                            // Если в ответе от АПИ Евроинса приходит ИД договора значит добавляем данные к нам в БД
                            if( isset( $euroins_result['insuranceApplicationID'] ) )
                            {
                                $euroins_data = [
                                    'order_id' => $order_id,
                                    'insuranceApplicationID' => $euroins_result['insuranceApplicationID'],
                                    'polisNumber' => $euroins_result['polisNumber'],
                                ];


                                //Заносим информацию о договоре в БД
                                $r = $euroins->add_order_data( $euroins_data );

                                $result['status'] = true;
                                $result['message'][] = '<span class="message-ok">Вітаємо, поліс успішно оформлений.</span>';
                                //                    $result['last_step_html'] = '<a class="get-new-medical-order" href="/medical-m/">Оформити новий поліс</a><a target="_blank" class="download-medical-order" href="/wp-content/wp-recall/add-on/insurance/report/download_print.php?order_id=' . $wpdb->insert_id . '&key=WPbm49ebf124">Скачати поліс</a>';
                                $result['last_step_html'] = '<a class="get-new-medical-order" href="/medical-m/">Оформити новий поліс</a><a target="_blank" class="download-medical-order" href="/wp-content/plugins/insurance/order-print/paper/index.php?order_id=' . $order_id . '&key=WPbm49ebf124">Скачати поліс</a>';
                                $result['order_id'] = $wpdb->insert_id;
                            }
                            else
                            {
                                $result['status'] = false;
                                $result['message'][] = '<span class="message-danger">Не вдалося оформити полic.</span>';

                                foreach ( $euroins_result as $euroins_res )
                                {
                                    $result['message'][] = $euroins_res;
                                }

                                //Удаляем договор который сохранили у нас в БД
                                $euroins->remove_order( $order_id );

                                if ( !empty($insurers) )
                                {
//                                    Удаляем застрахованых персон
                                }

                                //EROOR
                            }



                        }*/
                        //CK EKTA
                        elseif ( $company_id == 6 )
                        {
                          $ekta = new Ekta(__DIR__);

                            $ekta_error = [];

                            if( $ekta->login() == 200 ){

                                /* Расчитываем франшизу
                                 * Для этого берем только число из выбраной франшизы
                                 * и проверяем его на подходящее значение
                                 */
                                $rate_franchise_number = preg_replace("/[^0-9]/", '', $rate_franchise);
//                                $rate_franchise_number = '';
                                if( $rate_franchise_number == 0 )
                                {
                                    $rate_franchise_number = 4;
                                }
                                elseif ( $rate_franchise_number == 50 )
                                {
                                    $rate_franchise_number = 1;
                                }
                                elseif ( $rate_franchise_number == 100 )
                                {
                                    $rate_franchise_number = 2;
                                }
                                elseif ( $rate_franchise_number == 150 )
                                {
                                    $rate_franchise_number = 3;
                                }


                                $rate_insured_sum_number = '';
                                if( $rate_insured_sum == 30000 )
                                {
                                    $rate_insured_sum_number = 1;
                                }
                                elseif ( $rate_insured_sum == 50000 )
                                {
                                    $rate_insured_sum_number = 2;
                                }
                                elseif ( $rate_insured_sum == 60000 )
                                {
                                    $rate_insured_sum_number = 3;
                                }




                                if( empty( $rate_franchise_number ) )
                                {
                                    $ekta_error[] = 'Вказана франшиза не пiдходить для вибраної компанії.';
                                }

                                if( empty( $rate_insured_sum_number ) )
                                {
                                    $ekta_error[] = 'Страхова сума не  пiдходить для вибраної компанії.';
                                }


                                //Если нет ошибок заполняем массив данными и отправляем на сервер ЕКТА
                                if( empty( $ekta_error ) )
                                {

                                    $phone = '+' . preg_replace('/\D+/', '', $tel);
//                                    $result['message'][] = $phone;

                                    $ekta_order = [
                                        'territory' => '1',                                   // Территория действия всегда Европа, а это 1
                                        'date_from' => $date_from,                            // Дата начала действия договора '2022-11-25'
                                        'date_to' => $date_to,                                // Дата окончания действия договора '2022-11-25'
                                        'count_active_days' => $count_days,                   // Доступное количество дней за границей
                                        'multivisa' => true,                                  // Мультивиза. Всегда 1
                                        'destinition_days' => $destinition_days,              // Общее количество дней
                                        'police_number' => null,                              // Номер полиса, всегда пусто
                                        'sport' => false,                                     // Страховка для спорта, всегда пусто
                                        'work' => true,                                       // Страховка для работы, всегда 1
                                        'franshise_id' => $rate_franchise_number,             // Франшиза: 0 Euro = 4; 50 Euro = 1; 100 Euro = 2; 150 Euro = 3
                                        'company_id' => 'company1',                           // Страховая компания ЕКТА (всегда такое вот значение)
                                        'coverage_id' => $rate_insured_sum_number,                                 // Покрытие страховки (30 000 EUR = 1; 50 000 EUR = 2; 60 000 EUR = 3)
                                        'insurer' =>                                          // Страховщик
                                            [
                                                'client_build' =>  '   ',                     // Номера дома, не обязательно, можно передавать пустоту
                                                'client_street' => '   ',                     // Улица, не обязательно, передаем пустоту
                                                'client_room' => '   ',                       // Номер квартиры, передаем пустоту
                                                'client_fname' => $name,                      // Имя страхователя
                                                'client_lname' => $surname,                   // Фамилия страхователя
                                                'client_birth' => $birthday_reverse,               // Дата рождения страхователя '14-06-1989'
                                                'client_phone' => $phone,            // Номер телефона страхователя (обязательно)
                                                'client_email' => $email,            // Email обязательно
                                                'client_passport' => $passport,              // Паспорт страхователя (обязательно)
//                                                'client_city' => 'Kiev',                      // Город (обязательно)
                                                'client_city' => ' ',                      // Город (обязательно)
                                                'client_country' => 'Ukraine',                // Всегда Украина
                                                'name_first' => $name,                     // Имя (дублируется)
                                                'name_last' => $surname,                     // Фамилия (дублируется)
                                                'phone' => $phone,                              // Номер телефона (дублируется) '+380934444444'
//                                            'city' => 'Kiev',                             // Город (обязательно
                                                'city' => ' ',                             // Город (обязательно
                                                'country' => 'Ukraine',                       // Всегда Украина
                                                'address' => $address,                           // Адрес (поле не обязательное, но лучше передавать тот адрес, что у нас есть)
                                                'build' => '   ',                             // Номер дома (необязательно)
                                                'email' => $email,                            // Email страхователя
                                                'birthday' => $birthday,                   // Дата рождения страхователя только чуть в другом формате (обрати внимание) '1989-06-14'
                                                'passport' => $passport                      // Загран паспорт
                                            ],
                                        'ns_include' => true                                     // Несчастный случай (всегда 1)
                                    ];


                                    //Если мы страхуем самого себя
                                    if( $insurer_status != 0 )
                                    {
                                        $ekta_order['tourists'][] = array(
                                            'name_first' => $name,             // Имя (обязательно)
                                            'name_last' => $surname,             // Фамилия (обязательно)
                                            'birthday' => $birthday,           // Дата рождения (обязательно) '1989-06-14'
                                            'passport' => $passport,
                                        );

                                        if( ! empty ($insurers) )
                                        {
                                            foreach ($insurers as $insurer)
                                            {

                                                $ekta_order['tourists'][] = array(
                                                    'name_first' => $insurer['name'],             // Имя (обязательно)
                                                    'name_last' => $insurer['lastName'],             // Фамилия (обязательно)
                                                    'birthday' => date("Y-m-d", strtotime($insurer['date'])),           // Дата рождения (обязательно) '1989-06-14'
                                                    'passport' => $insurer['passport'],
                                                );

                                            }
                                        }
                                    }
                                    else
                                    {
                                        if( ! empty ($insurers) )
                                        {
                                            foreach ($insurers as $insurer)
                                            {

                                                $ekta_order['tourists'][] = array(
                                                    'name_first' => $insurer['name'],             // Имя (обязательно)
                                                    'name_last' => $insurer['lastName'],             // Фамилия (обязательно)
                                                    'birthday' => date("Y-m-d", strtotime($insurer['date'])),           // Дата рождения (обязательно) '1989-06-14'
                                                    'passport' => $insurer['passport'],
                                                );

                                            }
                                        }
                                    }

//
                                      $ekta_response = $ekta->createOrder( $ekta_order );
//                                      echo $ekta_response;

//                                    $ekta_response = '{"success":false,"data":{"success":true,"id":1,"order_id":1,"tariff_id":40,"cost":325}}';

                                    $ekta_response = json_decode( $ekta_response, true);

//                                    foreach( $ekta_response as $ekta_resp )
//                                    {
//                                        $result['message'][] = $ekta_resp;
//                                    }

//                                    $result['message'][] = $ekta_order;
//                                    $result['message'][] = $ekta_response;
                                    if( $ekta_response['success'] )
                                    {
                                        $ekta_data = array(
                                            'ekta_id' => $ekta_response['data']['id'],
                                            'ekta_order_id' => $ekta_response['data']['order_id'],
                                            'ekta_cost' => $ekta_response['data']['cost'],
                                            'order_id' => $order_id,
                                            'status' => 1,
                                        );

//                                        $result['message'][] = $ekta_data;
                                        $r = $ekta->add_order_data( $ekta_data );

                                        $result['status'] = true;
                                        $result['message'][] = '<span class="message-ok">Вітаємо, поліс успішно оформлений.</span>';
                                        $result['last_step_html'] = '<a class="get-new-medical-order" href="/medical-m/">Оформити новий поліс</a><a target="_blank" class="download-medical-order" href="/wp-content/plugins/insurance/order-print/paper/index.php?order_id=' . $order_id . '&key=WPbm49ebf124">Скачати поліс</a>';
//                                        $result['message'][] = $r;
                                    }
                                    else{
                                        $ekta->remove_order( $order_id );
                                        $result['status'] = false;
                                        $result['message'][] = '<span class="message-danger">Не вдалось оформити полic.</span>';
                                    }


//                                    $result['message'][] = $ekta_order;
//                                    $result['status'] = true;
//                                    $result['message'][] = '<span class="message-ok">Вітаємо, поліс успішно оформлений.</span>';
//                                    $result['last_step_html'] = '<a class="get-new-medical-order" href="/medical-m/">Оформити новий поліс</a><a target="_blank" class="download-medical-order" href="/wp-content/plugins/insurance/order-print/paper/index.php?order_id=' . $order_id . '&key=WPbm49ebf124">Скачати поліс</a>';
                                    $result['order_id'] = $wpdb->insert_id;
//                                    $result['status'] = true;
//                                    $result['message'][] = '<span class="message-ok">Вітаємо, поліс успішно оформлений.</span>';
//                                    $result['last_step_html'] = '<a class="get-new-medical-order" href="/medical-m/">Оформити новий поліс</a><a target="_blank" class="download-medical-order" href="/wp-content/plugins/insurance/order-print/paper/index.php?order_id=' . $order_id . '&key=WPbm49ebf124">Скачати поліс</a>';
//                                    $result['order_id'] = $wpdb->insert_id;
                                }

                            }
                            else {

                                $ekta->remove_order( $order_id );
                                $result['status'] = false;
                                $result['message'][] = '<span class="message-danger">Не вдалось увійти в систему.</span>';
                            }

                        }
                        else
                        {
                            $result['status'] = true;
                            $result['message'][] = '<span class="message-ok">Вітаємо, поліс успішно оформлений.</span>';
                            //                    $result['last_step_html'] = '<a class="get-new-medical-order" href="/medical-m/">Оформити новий поліс</a><a target="_blank" class="download-medical-order" href="/wp-content/wp-recall/add-on/insurance/report/download_print.php?order_id=' . $wpdb->insert_id . '&key=WPbm49ebf124">Скачати поліс</a>';
                            $result['last_step_html'] = '<a class="get-new-medical-order" href="/medical-m/">Оформити новий поліс</a><a target="_blank" class="download-medical-order" href="/wp-content/wp-recall/add-on/insurance/report/download_print.php?order_id=' . $order_id . '&key=WPbm49ebf124">Скачати поліс</a>';
                            $result['order_id'] = $wpdb->insert_id;
                        }
                        // $result['data'] = $query;
                    } else {
                        $result['status'] = false;
                        $result['message'][] = '<span class="message-danger">Не вдалося записати полiс в базу данних.</span>';
                        $result['order_id'] = false;
                    }
                   }
                   else{
                       $result['status'] = false;
                       $result['message'][] = '<span class="message-danger">Номер бланку по введеним параметрам не входить в дiапазон нумерацiй бланкiв закріплених за менеджером.</span>';
                   }

                } else {
                    $result['status'] = false;
                    $result['message'][] = '<span class="message-danger">Номер бланку по введеним параметрам не входить в дiапазон нумерацiй бланкiв.</span>';
                }
            } else {
                $result['status'] = false;
                $result['message'][] = '<span class="message-danger">Поліс за номером бланка <strong>' . $blank_number . '</strong> вже зареєстрований, будь ласка вкажіть інший номер бланка.</span>';
            }
        }
        // Електронний бланк
        elseif ( $blank_type_id == 2 ){

            $paper = false;

            $blank_data = new Blank();

            //для поиска по ТАБЛИЧКИ ЭЛЕКТРОННЫХ
            $blank_number_data = $blank_data->get_e_blank_number_data($company_id);


/*
            //Получаем последний оформленый договор
        //    $result['message'][] = 'Получаем последний оформленый договор.<br>';
            $last_order_blank_number_data = $blank_data->get_last_order_data( $blank_type_id, $company_id );

            //Если есть последний оформленый договор
            if( ! empty( $last_order_blank_number_data ) ){
            //    $result['message'][] = 'Если есть последний оформленый договор.<br>';

                $last_order_blank_number = (int) $last_order_blank_number_data[0]['blank_number'] ;
//                $result['message'][] = $last_order_blank_number. '<br>';
                // Делаем + 1 для того чтобы узнать для какого диапазона он подходит
//                $new_order_blank_id = $last_order_blank_number + 1;
                $new_order_blank_id = $last_order_blank_number;

                $last_order_blank_series = $last_order_blank_number_data[0]['blank_series'];

                $number_of_blank_data = $blank_data->get_blank_range( $blank_type_id, $company_id, $new_order_blank_id, $last_order_blank_series );

                //Если есть подходящий диапазон
                if( ! empty( $number_of_blank_data ) ){
                //    $result['message'][] = 'Если есть подходящий диапазон.<br>';

                    //Максимум диапазона
                    $blank_range_number_end = (int) $number_of_blank_data[0]['number_end'];
                    $number_blank_comment = $number_of_blank_data[0]['comments'];
                    $number_of_blank_series = $number_of_blank_data[0]['blank_series'];
                    $new_order_blank_id ++;

                    //ID диапазона
                    $number_of_blank_id = (int) $number_of_blank_data[0]['id'];

                    //Если максимум диапазона бланков совпадает с нормером договора то изменяем статус для этого диапазона бланков
                    if( $new_order_blank_id == $blank_range_number_end ){
                        $blank_data->change_range_used_status( $number_of_blank_id );
                    }
                }
                else{
                    //Выбираем новый диапазон
                //    $result['message'][] = 'Выбираем новый диапазон.<br>';
                    $number_of_blank_data = $blank_data->get_new_blank_range( $blank_type_id, $company_id, $new_order_blank_id, $last_order_blank_series );
//                    $result['message'][] = $new_order_blank_id.'<br>';

                    if( ! empty( $number_of_blank_data ) ){

                        //Максимум диапазона
                        $blank_range_number_end = (int) $number_of_blank_data[0]['number_end'];
                        $new_order_blank_id = (int) $number_of_blank_data[0]['number_start'];
                        $number_blank_comment = $number_of_blank_data[0]['comments'];
                        $number_of_blank_series = $number_of_blank_data[0]['blank_series'];

                        //ID диапазона
                        $number_of_blank_id = (int) $number_of_blank_data[0]['id'];

                        //Если максимум диапазона бланков совпадает с нормером договора то изменяем статус для этого диапазона бланков
                        if( $new_order_blank_id == $blank_range_number_end ){
                            $blank_data->change_range_used_status( $number_of_blank_id );
                        }

                    }
                    else{
                        $result['status'] = false;
                        $result['message'][] = 'По даним параметрам вільних бланків не знайдено.<br>';
                    }

                }

            }
            //Иначе это первый договор
            else{
            //    $result['message'][] = 'Иначе это первый договор.<br>';
                $number_of_blank_data = $blank_data->get_first_blank_range( $blank_type_id, $company_id );


                $number_of_blank_id = (int) $number_of_blank_data[0]['id'];
                $new_order_blank_id = (int) $number_of_blank_data[0]['number_start'];
                //Максимум диапазона
                $blank_range_number_end = (int) $number_of_blank_data[0]['number_end'];
                $number_blank_comment = $number_of_blank_data[0]['comments'];
                $number_of_blank_series = $number_of_blank_data[0]['blank_series'];

//                $result['message'][] = $new_order_blank_id;

                //Если максимум диапазона бланков совпадает с нормером договора то изменяем статус для этого диапазона бланков
                if( $new_order_blank_id == $blank_range_number_end ){
                    $blank_data->change_range_used_status( $number_of_blank_id );
                }

            }
*/


            //Оформление договора
//            if( ! empty( $new_order_blank_id ) ){
            //для поиска по ТАБЛИЧКИ ЭЛЕКТРОННЫХ
            if( ! empty( $blank_number_data ) ){

                //для поиска по ТАБЛИЧКИ ЭЛЕКТРОННЫХ
                $new_order_blank_id = (int)$blank_number_data[0]['blank_number'];
                $number_of_blank_series = $blank_number_data[0]['blank_series'];
                $number_of_blank_id = (int)$blank_number_data[0]['number_of_blank_id'];
                $number_blank_comment = $blank_number_data[0]['comments'];

                $unicue_code = random_string();

                $cashback = get_user_meta($user_id, "user_return_percent_medical_company_id_" . $company_id, 1);

                $table_name = $wpdb->get_blog_prefix() . 'insurance_orders';

                $query = $wpdb->insert($table_name, array('program_id' => $program_id, 'program_title' => $program_title, 'number_blank_id' => $number_of_blank_id, 'number_blank_comment' => $number_blank_comment, 'blank_number' => $new_order_blank_id,
                    'blank_series' => $number_of_blank_series, 'company_id' => $company_id, 'company_title' => $company_title, 'rate_id' => $rate_id, 'rate_franchise' => $rate_franchise,
                    'rate_validity' => $rate_validity, 'rate_insured_sum' => $rate_insured_sum, 'rate_price' => $rate_price, 'rate_locations' => $rate_locations, 'name' => $name,
                    'last_name' => $surname, 'passport' => $passport, 'birthday' => $date, 'address' => $address, 'phone_number' => $tel, 'email' => $email, 'date_from' => $date_from,
                    'date_to' => $date_to, 'count_days' => $count_days, 'pdf_url' => $pdf_url, 'is_manager' => $is_manager, 'user_id' => $user_id, 'cashback' => $cashback, 'status' => 1, 'rate_coefficient' => $rate_coefficient, 'rate_price_coefficient' => $rate_price_coefficient, 'unicue_code' => $unicue_code, 'insurer_status' => $insurer_status, 'blank_type_id' => $blank_type_id ),
                    array('%d', '%s', '%d', '%s', '%d', '%s', '%d', '%s', '%d', '%s', '%s', '%s', '%f', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%d', '%s', '%d', '%d', '%f', '%d', '%f', '%f', '%s', '%d', '%d' ));

                $order_id = $wpdb->insert_id;

                // $result['message'][] = 'Номер бланка совпадает с диапазоном';

                //Если у нас есть Страховальники и был создан договор то можно добавлять новые данные
                if ($query && !empty($insurers)) {

                    $table_name = $wpdb->get_blog_prefix() . 'insurance_insurer';

                    foreach ($insurers as $insurer) {

                        $insurer_last_name = $insurer['lastName'];
                        $insurer_name = $insurer['name'];
                        $insurer_date = date("Y-m-d", strtotime($insurer['date']));
                        $insurer_coefficient_date = get_full_years($insurer['date']);
                        $insurer_passport = $insurer['passport'];
                        $insurer_address = $insurer['address'];

                        //                        date("Y-m-d", strtotime($date) );
                        //Проверяем коеффициенты по дате рождения пользователей
                        $coefficient_data = setCoeficient($company_id, $insurer_coefficient_date, $company_title, $program_title, $program_id);

                        $rate_coefficient = $coefficient_data['coefficient'];


                        $insurer_query = $wpdb->insert($table_name, array('order_id' => $order_id, 'last_name' => $insurer_last_name, 'name' => $insurer_name, 'birthday' => $insurer_date, 'passport' => $insurer_passport, 'address' => $insurer_address, 'coefficient' => $rate_coefficient, 'price' => $rate_price),
                            array('%d', '%s', '%s', '%s', '%s', '%s', '%f', '%f'));


                        if (!$insurer_query) {
                            $result['message'][] = '<span class="message-danger">Не вдалося записати страхувальників в базу данних.</span>';
                        }


                    }

                }


                if ($query) {

                    //для поиска по ТАБЛИЧКИ ЭЛЕКТРОННЫХ
                    $blank_data->change_status_e_blank_number($number_of_blank_id, $new_order_blank_id,1);


                    if ($company_id == 2) {

                        $gardian_electron = new Gardian(__DIR__);
                        $currencyRate = '30.3376';
                        $gardian_status = 'Draft';
                        $gardian_phone = $gardian_electron->format_phone_number( $tel );

                        $rate_franchise_number = preg_replace("/[^0-9]/", '', $rate_franchise);

                        $gardian_date_to = $date_from . " + 1 year";
                        $gardian_date_to = $gardian_date_to . " - 1 days";
                        $gardian_date_to = date( "Y-m-d", strtotime( $gardian_date_to ) );


                        if( $sex == 'M' )
                        {
                            $sex = 'Male';
                        }
                        elseif ( $sex == 'W' )
                        {
                            $sex = 'Female';
                        }

                        $gardian_rate_insured_sum = preg_replace("/[^0-9]*/",'',$rate_insured_sum);

                        $gardian_product_id = '';
                        // 68947399-4db5-11eb-b19c-00155df66a18 - D (Латвія)
                        // 68947398-4db5-11eb-b19c-00155df66a18 - E (Чехія)
                        // 68947396-4db5-11eb-b19c-00155df66a18 - А (Work)
                        //	6894739a-4db5-11eb-b19c-00155df66a18 - М (Європа)
                        //	aea90dd0-75aa-11eb-b19f-00155df66a18 - М (СНД)
                        if( $program_id == 1 )
                        {
                            $gardian_product_id = '68947396-4db5-11eb-b19c-00155df66a18';
                        }
                        elseif ( $program_id == 5 )
                        {
                            $gardian_product_id = '6894739a-4db5-11eb-b19c-00155df66a18';
                        }
                        elseif ( $program_id == 4 )
                        {
                            $gardian_product_id = '68947398-4db5-11eb-b19c-00155df66a18';
                        }


                        $gardian_product_id = '68947396-4db5-11eb-b19c-00155df66a18';


                        $blankType =  $paper === false ? "true" : "false";

                        $gardian_data = [
                            'agr[GUID]' => '',
                            'agr[Blank][BlankGUID]' => '',
                            'agr[Blank][BlankName]' => '',
                            'agr[Blank][BlankComment]' => '',
                            'agr[Blank][BlankComment2]' => '',
                            'agr[Blank][NumberLength]' => 0,
                            'agr[BlankNumber]' => 0,
                            'agr[Sticker][BlankGUID]' => '37e5ec78_2fe2_11ec_b1b2_00155dae7a01', // Тип номерного бланка GUID (Всегда такое значение)
                            'agr[Sticker][BlankName]' => 'GR', // Тип номерного бланка (Всегда такое значение)
                            'agr[Sticker][BlankComment]' => '',
                            'agr[Sticker][BlankComment2]' => '',
                            'agr[Sticker][NumberLength]' => 0,
                            'agr[StickerNumber]' => $blank_number,
                            'agr[Number]' => '',
                            'agr[Product]' => 'ВЗРКон',
                            'agr[Date]' => $date_now,
                            'agr[BegDate]' => $date_from,
                            'agr[EndDate]' => $gardian_date_to,
                            'agr[Summ]' => $rate_price * $rate_coefficient,
                            'agr[Customer][CustomerName]' => $surname . ' ' . $name,
                            'agr[Customer][CustomerFullName]' => $surname . ' ' . $name,
                            'agr[Customer][CustomerFName]' => '',
                            'agr[Customer][CustomerLName]' => '',
                            'agr[Customer][CustomerSName]' => '',
                            'agr[Customer][CustomerType]' => 'person',
                            'agr[Customer][CustomerCode]' => $inn,
                            'agr[Customer][CustomerBDate]' => $birthday,
                            'agr[Customer][CustomerForeigner]' => 'false',
                            'agr[Customer][CustomerPersonWithoutCode]' => 'false',
                            'agr[Customer][CustomerPhone]' => $gardian_phone,
                            'agr[Customer][CustomerAddress]' => $address,
                            'agr[Customer][CustomerAddressLat]' => $address,
                            'agr[Customer][CustomerPassport][DocType]' => '',
                            'agr[Customer][CustomerPassport][DocSeries]' => '',
                            'agr[Customer][CustomerPassport][DocNumber]' => '',
                            'agr[Customer][CustomerPassport][DocDate]' => '',
                            'agr[Customer][CustomerPassport][DocSourceOrg]' => '',
                            'agr[Customer][CustomerDriversLicense][DocType]' => '',
                            'agr[Customer][CustomerDriversLicense][DocSeries]' => '',
                            'agr[Customer][CustomerDriversLicense][DocNumber]' => '',
                            'agr[Customer][CustomerDriversLicense][DocDate]' => '0001-01-01T00:00:00',
                            'agr[Customer][CustomerDriversLicense][DocSourceOrg]' => '',
                            'agr[Customer][CustomerPreferentialDocument][DocType]' => '',
                            'agr[Customer][CustomerPreferentialDocument][DocSeries]' => '',
                            'agr[Customer][CustomerPreferentialDocument][DocNumber]' => '',
                            'agr[Customer][CustomerPreferentialDocument][DocDate]' => '0001-01-01T00:00:00',
                            'agr[Customer][CustomerPreferentialDocument][DocSourceOrg]' => '',
                            'agr[Customer][CustomerInternationalPassport][DocType]' => 'InternationalPassport',
                            'agr[Customer][CustomerInternationalPassport][DocSeries]' => $passport_series,
                            'agr[Customer][CustomerInternationalPassport][DocNumber]' => $passport_number,
                            'agr[Customer][CustomerInternationalPassport][DocDate]' => '0001-01-01',
                            'agr[Customer][CustomerInternationalPassport][DocSourceOrg]' => '',
                            'agr[Customer][CustomerNameLat]' => $surname . ' ' . $name,
                            'agr[Customer][CustomerIncorrectCode]' => 'false',
                            'agr[Customer][CustomerContactPerson]' => '',
                            'agr[Customer][CustomerBankAccount]' => '',
                            'agr[Customer][CustomerGUID]' => '',
                            'agr[Customer][CustomerCitizenshipCountry][EnumVal]' => '',
                            'agr[Customer][CustomerCitizenshipCountry][EnumName]' => '',
                            'agr[Customer][CustomerCitizenshipCountry][EnumFlag]' => 'false',
                            'agr[Customer][CustomerCitizenshipCountry][EnumRate]' => 0,
                            'agr[Customer][CustomerEmail]' => $email,
                            'agr[Customer][CustomerEDDRCode]' => $eddr,
                            'agr[Customer][CustomerGender]' => $sex,
                            'agr[Beneficiary]' => '',
                            'agr[BeneficiaryIsCustomer]' => 'false',
                            'agr[Srok]' => 0,
                            'agr[BonusMalus]' => 0,
                            'agr[Zone]' => 0,
                            'agr[Objects][0][Mark]' => '',
                            'agr[Objects][0][Model]' => '',
                            'agr[Objects][0][VIN]' => '',
                            'agr[Objects][0][RegNum]' => '',
                            'agr[Objects][0][YearOfCreation]' => 0,
                            'agr[Objects][0][Type]' => '',
                            'agr[Objects][0][ObjectGUID]' => '',
                            'agr[Objects][0][Name]' => $surname . ' ' . $name,
                            'agr[Objects][0][NameLat]' => $surname . ' ' . $name,
                            'agr[Objects][0][Date]' => $birthday,
                            'agr[Objects][0][InternationalPassport][DocType]' => '',
                            'agr[Objects][0][InternationalPassport][DocSeries]' => $passport_series,
                            'agr[Objects][0][InternationalPassport][DocNumber]' => $passport_number,
                            'agr[Objects][0][InternationalPassport][DocDate]' => '0001-01-01T00:00:00',
                            'agr[Objects][0][InternationalPassport][DocSourceOrg]' => '',
                            'agr[Objects][0][Address]' => $address,
                            'agr[Objects][0][Phone]' => $gardian_phone,
                            'agr[Objects][0][DecimalOption1]' => $rate_price * $rate_coefficient,
                            'agr[Objects][0][DecimalOption2]' => 0,
                            'agr[Objects][0][AddressLat]' => $address,
                            'agr[Objects][0][ObjType]' => '',
                            'agr[Objects][0][StringOption1]' => '',
                            'agr[UnusedMonthes][M1]' => 'false',
                            'agr[UnusedMonthes][M2]' => 'false',
                            'agr[UnusedMonthes][M3]' => 'false',
                            'agr[UnusedMonthes][M4]' => 'false',
                            'agr[UnusedMonthes][M5]' => 'false',
                            'agr[UnusedMonthes][M6]' => 'false',
                            'agr[UnusedMonthes][M7]' => 'false',
                            'agr[UnusedMonthes][M8]' => 'false',
                            'agr[UnusedMonthes][M9]' => 'false',
                            'agr[UnusedMonthes][M10]' => 'false',
                            'agr[UnusedMonthes][M11]' => 'false',
                            'agr[UnusedMonthes][M12]' => 'false',
                            'agr[OTKFlag]' => 'false',
                            'agr[OTK6Flag]' => 'false',
                            'agr[OTKDate]' => '0001-01-01T00:00:00',
                            'agr[Preference]' => '',
                            'agr[Franchise]' => $rate_franchise_number,
                            'agr[OSAGOValues][K1]' => 0,
                            'agr[OSAGOValues][K2]' => 0,
                            'agr[OSAGOValues][K3]' => 0,
                            'agr[OSAGOValues][K4]' => 0,
                            'agr[OSAGOValues][K5]' => 0,
                            'agr[OSAGOValues][K6]' => 0,
                            'agr[OSAGOValues][K7]' => 0,
                            'agr[OSAGOValues][K8]' => 0,
                            'agr[OSAGOValues][K9]' => 0,
                            'agr[PayDate]' => '0001-01-01T00:00:00',
                            'agr[PayDoc]' => '',
                            'agr[RegistrationPlace]' => '',
                            'agr[StazhDo3Let]' => 'false',
                            'agr[CommerceUse]' => 'false',
                            'agr[Status]' => $gardian_status,
                            'agr[Deleted]' => 'false',
                            'agr[ParentAgreementGUID]' => '',
                            'agr[ParentAgreementNumber]' => '',
                            'agr[ParentAgreementDate]' => '0001-01-01T00:00:00',
                            'agr[CrossAgreementGUID]' => '',
                            'agr[CrossAgreementNumber]' => '',
                            'agr[CrossAgreementDate]' => '0001-01-01T00:00:00',
                            'agr[BlankStatus]' => '',
                            'agr[SalesChannelGUID]' => 'bd909c32_2b2a_11eb_b19b_00155df66a18', // Канал продажу: Агентський - Агенти-вільний ринок  (Всегда)
                            'agr[SalesChannelParentGUID]' => '',
                            'agr[Partner]' => '',
                            'agr[ParkDiscount]' => 0,
                            'agr[ParkDiscountStr]' => '',
                            'agr[BMR]' => 'false',
                            'agr[ValidationCode]' => '',
                            'agr[Countries]' => '047c8592-4e59-11eb-b19c-00155df66a18', // Територія покриття: Європа / Europe (Всегда)
                            'agr[Country]' => '',
                            'agr[PaymentSchedule][0][PaymentNum]' => 0,
                            'agr[PaymentSchedule][0][PaymentDate]' => '0001-01-01T00:00:00',
                            'agr[PaymentSchedule][0][PaymentSum]' => 0,
                            'agr[SpecialTariff]' => 'false',
                            'agr[MultiUse]' => 'false',
                            'agr[BoolOption1]' => 'false',
                            'agr[BoolOption2]' => 'true',
                            'agr[BoolOption3]' => 'false',
                            'agr[BoolOption4]' => 'false',
                            'agr[BoolOption5]' => 'false',
                            'agr[StringOption1]' => '',
                            'agr[StringOption2]' => '',
                            'agr[Currency]' => 'EUR',
                            'agr[AgreementType]' => '',
                            'agr[DurationType]' => $count_days,
                            'agr[KV]' => 0,
                            'agr[Summ1]' => $gardian_rate_insured_sum,
                            'agr[Summ2]' => 0,
                            'agr[Summ3]' => 0,
                            'agr[Summ4]' => 0,
                            'agr[Summ5]' => 0,
                            'agr[Tariff]' => 0,
                            'agr[Prem1]' => $rate_price * $rate_coefficient,
                            'agr[Prem2]' => 0,
                            'agr[Prem3]' => 0,
                            'agr[Prem4]' => 0,
                            'agr[Prem5]' => 0,
                            'agr[Corr1]' => 0,
                            'agr[Corr2]' => 0,
                            'agr[Corr3]' => 0,
                            'agr[CurrencyRate]' => $currencyRate,
                            'agr[TerritorySPType]' => '',
                            'agr[Sighner][EnumVal]' => '',
                            'agr[Sighner][EnumName]' => '',
                            'agr[Sighner][EnumFlag]' => 'false',
                            'agr[Sighner][EnumRate]' => 0,
                            'agr[ProxyDoc][EnumVal]' => '',
                            'agr[ProxyDoc][EnumName]' => '',
                            'agr[ProxyDoc][EnumFlag]' => 'false',
                            'agr[ProxyDoc][EnumRate]' => 0,
                            'agr[MaxTariff]' => 'false',
                            'agr[IsPaid]' => 'false',
                            'agr[Agent][EnumVal]' => '',
                            'agr[Agent][EnumName]' => '',
                            'agr[Agent][EnumFlag]' => 'false',
                            'agr[Agent][EnumRate]' => 0,
                            'agr[ProductGUID]' => $gardian_product_id,
                            'agr[TariffProp]' => '',
                            'agr[Digital]' => $blankType,
                            'agr[Password]' => '',
                            'agr[UsedBlanks]' => ''
                        ];


                        //Если мы страхуем ДРУГОГО ЧЕЛОВЕКА
                        if( $insurer_status == 0 ) {
                            if (!empty ($insurers)) {
                                foreach ($insurers as $insurer) {

                                    $insurer_passport_series = preg_replace("/[^A-Za-z]/", '', $insurer['passport']);
                                    $insurer_passport_number = preg_replace("/[^0-9]/", '', $insurer['passport']);

                                    $gardian_data['agr[Objects][0][Name]'] = $insurer['lastName'] . ' ' . $insurer['name'];
                                    $gardian_data['agr[Objects][0][NameLat]'] = $insurer['lastName'] . ' ' . $insurer['name'];
                                    $gardian_data['agr[Objects][0][Date]'] = date("Y-m-d", strtotime($insurer['date']));
                                    $gardian_data['agr[Objects][0][InternationalPassport][DocSeries]'] = $insurer_passport_series;
                                    $gardian_data['agr[Objects][0][InternationalPassport][DocNumber]'] = $insurer_passport_number;
                                    $gardian_data['agr[Objects][0][Address]'] = $insurer['address'];
                                    $gardian_data['agr[Objects][0][AddressLat]'] = $insurer['address'];

                                }
                            }

                        }


                            $result['message'][] = $gardian_data;

                        // РЕГИСТРАЦИЯ ДОГОВОРА
                        if($gardian_electron->loginPage()){

                            if($gardian_electron->login() == 200){
                                //Устанавлтваем курс
                                $gardian_electron->getCurrencyRate();

                                $gardian_order = $gardian_electron->createOrder($gardian_data);

                                //Если ответ с ошибками
                                if( ! $gardian_order['Result'] )
                                {
                                    $result['status'] = false;
                                    foreach ( $gardian_order['Messages'] as $error_smg )
                                    {
                                        $result['message'][] = '<span class="message-danger">' . $error_smg . '</span>';
                                    }
                                }

                                if(is_array($gardian_order)){

                                    if(array_key_exists('Messages', $gardian_order) && count($gardian_order['Messages']) >= 4 && array_key_exists('Result', $gardian_order) && $gardian_order['Result'] == 1) {

                                        $gardian_data['agr[GUID]'] = $gardian_order['Messages'][0];
                                        $gardian_data['agr[Customer][CustomerGUID]'] = $gardian_order['Messages'][1];
                                        $gardian_data['agr[Number]'] = $gardian_order['Messages'][2];
                                        $gardian_data['agr[BlankNumber]'] = explode("-", $gardian_order['Messages'][2])[1];
                                        $gardian_data['agr[Objects][0][ObjectGUID]'] = $gardian_order['Messages'][3];

                                        if ( $paper === false ) {
                                            $smsAnswer = $gardian_electron->sendSms( $gardian_order['Messages'][0] );
                                            if ( is_array( $smsAnswer ) ) {

                                                if ( array_key_exists( 'OTP', $smsAnswer ) && array_key_exists( 'Result', $smsAnswer ) && $smsAnswer['Result'] == 1 ) {
                                                    $gardian_data['agr[Password]'] = $smsAnswer['OTP'];
                                                    $gardian_result = $gardian_electron->changeOrderStatus( $gardian_data, "Signed" );

                                                    $gardian_order_data = [
                                                        'gardian_GUID' => $gardian_result['Messages'][0],
                                                        'gardian_CustomerGUID' => $gardian_result['Messages'][1],
                                                        'gardian_Number' => $gardian_result['Messages'][2],
                                                        'gardian_ObjectGUID' => $gardian_result['Messages'][3],
                                                        'order_id' => $order_id,
                                                        'status' => 1,
                                                    ];

                                                    $gardian_electron->add_order_data( $gardian_order_data );

                                                    $result['status'] = true;
                                                    $result['message'][] = '<span class="message-ok">Вітаємо, поліс успішно оформлений.</span>';
                                                    $result['last_step_html'] = '<a class="get-new-medical-order" href="/medical-m/">Оформити новий поліс</a><a target="_blank" class="download-medical-order" href="/wp-content/plugins/insurance/order-print/paper/index.php?order_id=' . $order_id . '&key=WPbm49ebf124">Скачати поліс</a>';
                                                }

                                            }
                                        }
                                        else {
                                            $result = $gardian_electron->changeOrderStatus( $gardian_data, "Signed" );
                                        }

                                    }
                                    else
                                    {
                                        $result['status'] = false;
                                        $result['message'][] = '<span class="message-danger">Не вдалося додати договip.</span>';
                                    }

                                }
                                else
                                {
                                    $result['status'] = false;
                                    $result['message'][] = '<span class="message-danger">Не вдалося додати договip.</span>';
                                }

                            }

                        }
                        else
                        {
                            $result['status'] = false;
                            $result['message'][] = '<span class="message-danger">Не вдалося увiйти до СК ГАРДIАН.</span>';
                        }


                        if( $result['status'] == false )
                        {
                            $gardian_electron->remove_order( $order_id );
                        }


//                        if($gardian_electron->loginPage()){
//                            if($gardian_electron->login() == 200){
//                                $gardian_order = $gardian_electron->createPaperOrder($gardian_data);
//
////                                    $result['message'][] = $gardian_order;
//
//                                if( ! $gardian_order['Result'] )
//                                {
//                                    $result['status'] = false;
//                                    foreach ( $gardian_order['Messages'] as $error_smg )
//                                    {
//                                        $result['message'][] = '<span class="message-danger">' . $error_smg . '</span>';
//                                    }
//                                }
//
//                                if(is_array($gardian_order)){
//                                    if(array_key_exists('Messages', $gardian_order) && count($gardian_order['Messages']) >= 4 && array_key_exists('Result', $gardian_order) && $gardian_order['Result'] == 1){
//                                        $gardian_data['agr[GUID]'] = $gardian_order['Messages'][0];
//                                        $gardian_data['agr[Customer][CustomerGUID]'] = $gardian_order['Messages'][1];
//                                        $gardian_data['agr[Number]'] = $gardian_order['Messages'][2];
//                                        $gardian_data['agr[BlankNumber]'] = explode("-", $gardian_order['Messages'][2])[1];
//                                        $gardian_data['agr[Objects][0][ObjectGUID]'] = $gardian_order['Messages'][3];
//
//                                        $gardian_result = $gardian_electron->changeStatusPaperOrder($gardian_data, "Signed");
//
//
//                                        $result['message'][] = $gardian_result;
////
//                                        $gardian_order_data = [
//                                            'gardian_GUID' => $gardian_result['Messages'][0],
//                                            'gardian_CustomerGUID' => $gardian_result['Messages'][1],
//                                            'gardian_Number' => $gardian_result['Messages'][2],
//                                            'gardian_ObjectGUID' => $gardian_result['Messages'][3],
//                                            'order_id' => $order_id,
//                                            'status' => 1,
//                                        ];
//
//                                        $st = $gardian_electron->add_order_data( $gardian_order_data );
//
//                                        $result['message'][] = $st;
//                                        $result['status'] = true;
//                                        $result['message'][] = '<span class="message-ok">Вітаємо, поліс успішно оформлений.</span>';
//                                        $result['last_step_html'] = '<a class="get-new-medical-order" href="/medical-m/">Оформити новий поліс</a><a target="_blank" class="download-medical-order" href="/wp-content/plugins/insurance/order-print/paper/index.php?order_id=' . $order_id . '&key=WPbm49ebf124">Скачати поліс</a>';
//                                    }
//                                }
//                                else
//                                {
//                                    $result['status'] = false;
//                                    $result['message'][] = '<span class="message-danger">Не вдалося додати договip.</span>';
//                                    $result['message'][] = $gardian_order;
//                                }
//                            }
//                            else
//                            {
//                                $result['status'] = false;
//                                $result['message'][] = '<span class="message-danger">Не вдалося залогiнитись в СК ГАРДIАН.</span>';
//                            }
//                        }
//                        else
//                        {
//                            $result['status'] = false;
//                            $result['message'][] = '<span class="message-danger">Не вдалося увiйти до СК ГАРДIАН.</span>';
//                        }
//
//
//                        if( $result['status'] == false )
//                        {
//                            $gardian_electron->remove_order( $order_id );
//                        }
                    }
                    else
                    {
                        $result['status'] = true;
                        $result['message'][] = '<span class="message-ok">Вітаємо, поліс успішно оформлений.</span>';
                        $result['last_step_html'] = '<a class="get-new-medical-order" href="/medical-m?blank_type_id='. $blank_type_id .'">Оформити новий поліс</a><a target="_blank" class="download-medical-order" href="/wp-content/plugins/insurance/order-print/electronic-form/electronic-form.php?order_id=' . $order_id . '&key=kDCRa89dc0e1">Скачати поліс</a>';
                        $result['order_id'] = $wpdb->insert_id;
                    }

//                    $result['status'] = true;
//                    $result['message'][] = '<span class="message-ok">Вітаємо, поліс успішно оформлений 2.</span>';
//                    //                    $result['last_step_html'] = '<a class="get-new-medical-order" href="/medical-m/">Оформити новий поліс</a><a target="_blank" class="download-medical-order" href="/wp-content/wp-recall/add-on/insurance/report/download_print.php?order_id=' . $wpdb->insert_id . '&key=WPbm49ebf124">Скачати поліс</a>';
//                    $result['last_step_html'] = '<a class="get-new-medical-order" href="/medical-m?blank_type_id='. $blank_type_id .'">Оформити новий поліс</a><a target="_blank" class="download-medical-order" href="/wp-content/plugins/insurance/order-print/electronic-form/electronic-form.php?order_id=' . $order_id . '&key=kDCRa89dc0e1">Скачати поліс</a>';
//                    $result['order_id'] = $wpdb->insert_id;
                    // $result['data'] = $query;
                } else {
                    $result['status'] = false;
                    $result['message'][] = '<span class="message-danger">Не вдалося записати полiс в базу данних.</span>';
                    $result['order_id'] = false;
                }
            }
            else{
                $result['status'] = false;
                $result['message'][] = 'Не вдалося присвоїти номер електронному договору.';
            }

        }
        else{
            $result['status'] = false;
            $result['message'][] = 'Не вдалося знайти переданий тип бланка. Спробуйте вибрати інший.';
        }

    }
    else{
        $result['status'] = false;
    }

    echo json_encode( $result );

    wp_die();

}



//Получаем диапазон бланков
function get_empty_blnak_number(){

}

function setCoeficient( $company_id, $user_years, $company_title, $program_title, $program_id ){

    $rate_coefficient = 1;

    //СК ПРОВІДНА
    if( $company_id == 1 ){

//        if( 14 <= $user_years && $user_years < 18 ){
        if( $user_years < 18 ){
            $rate_coefficient = 1.2;
            $status = 1;
        }else if( 18 <= $user_years && $user_years < 60  ){
            $rate_coefficient = 1;
            $status = 1;
        }else if( 60 <= $user_years && $user_years <= 65  ){
            $rate_coefficient = 1.5;
            $status = 1;
        }else if( 66 <= $user_years && $user_years <= 70  ){
            $rate_coefficient = 2;
            $status = 1;
        }

        if( $status == 0 ){
            $message = '<span class="message-danger">' . $user_years . ' В ' . $company_title .' "' . $program_title .'" по вказанiй вiковiй категорiї договори не приймаються.</span>';
        }
        //СК ГАРДІАН
    }else if( $company_id == 2 ){

        if( $program_id == 3 ){

            if (1 <= $user_years && $user_years < 17) {
                $rate_coefficient = 1.5;
                $status = 1;
            }else if( 18 <= $user_years && $user_years < 60 ){
                $rate_coefficient = 1;
                $status = 1;
            }
            else if( 60 <= $user_years && $user_years <= 65  ){
                $rate_coefficient = 2;
                $status = 1;
            }
            else if (66 <= $user_years && $user_years < 70) {
                $rate_coefficient = 4;
                $status = 1;
            }
        } else if( $program_id == 1 ){
            if( 18 <= $user_years && $user_years < 60 ){
                $rate_coefficient = 1;
                $status = 1;
            }
            else if( 60 <= $user_years && $user_years <= 65  ){
                $rate_coefficient = 2;
                $status = 1;
            }
            else if (66 <= $user_years && $user_years < 70) {
                $rate_coefficient = 4;
                $status = 1;
            }
        }
        else{
            if( 18 <= $user_years && $user_years < 60 ){
                $rate_coefficient = 1;
                $status = 1;
            }
            else if( 60 <= $user_years && $user_years <= 65  ){
                $rate_coefficient = 2;
                $status = 1;
            }

        }



        if( $status == 0 ){
            $message = '<span class="message-danger">' . $user_years . ' В ' . $company_title .' "' . $program_title .'" по вказанiй вiковiй категорiї договори не приймаються.</span>';
        }

    //СК ЕВРОИНС  EUROINS
    }else if( $company_id == 4 ){
        if ( 16 > $user_years ) {
            $rate_coefficient = 1;
            $status = 0;
        }else if( 60 <= $user_years && $user_years <= 65 ){
            $rate_coefficient = 1.5;
            $status = 1;
        }
        else if( 66 <= $user_years && $user_years <= 70  ){
            $rate_coefficient = 2;
            $status = 1;
        }
        else if( $user_years > 70  ){
            $rate_coefficient = 1;
            $status = 0;
        }

        if( $status == 0 ){
            $message = '<span class="message-danger"> В ' . $company_title .' "' . $program_title .'" по вказанiй вiковiй категорiї (' . $user_years . ' р.) договори не приймаються.</span>';
        }
    //СК ІНТЕР-ПЛЮС
    }else if( $company_id == 5 ){
        if ( 1 <= $user_years && $user_years <= 59 ) {
            $rate_coefficient = 1;
            $status = 1;
        }else if( 60 <= $user_years && $user_years <= 75 ){
            $rate_coefficient = 2;
            $status = 1;
        }
        else if( 76 <= $user_years && $user_years <= 80  ){
            $rate_coefficient = 3;
            $status = 1;
        }
        if( $status == 0 ){
            $message = '<span class="message-danger">' . $user_years . ' В ' . $company_title .' "' . $program_title .'" по вказанiй вiковiй категорiї договори не приймаються.</span>';
        }
        //СК ЕКТА
    }else if( $company_id == 6 ){
        if ( $user_years > 3 && $user_years < 65 ) {
            $rate_coefficient = 1;
            $status = 1;
        }


        if( $status == 0 ){
            $message = '<span class="message-danger"> В ' . $company_title .' "' . $program_title .'" по вказанiй вiковiй категорiї (' . $user_years . ' р.) договори не приймаються.</span>';
        }
    }

    $result = array(
        'message' => $message,
        'coefficient' => $rate_coefficient,
    );

    return $result;

}


function get_full_years( $birthdayDate ) {
    $datetime = new DateTime($birthdayDate);
    $interval = $datetime->diff(new DateTime(date("Y-m-d")));
    return $interval->format("%Y");
}



add_action('wp_ajax_medicalmgetblanks', 'medicalm_insurance_get_blanks');
add_action('wp_ajax_nopriv_medicalmgetblanks', 'medicalm_insurance_get_blanks');

function medicalm_insurance_get_blanks(){

    if( empty( $_POST['nonce'] ) ){
        wp_die('', '', 400);
    }

    check_ajax_referer( 'medical-m', 'nonce', true );

    $blank_type_id = $_POST['blank_type_id'];

    global $wpdb;

    $table_name_rate = $wpdb->get_blog_prefix() . 'insurance_rate';
    $table_name_program = $wpdb->get_blog_prefix() . 'insurance_program';

//    $blanks = $wpdb->get_results( $wpdb->prepare("SELECT id, title FROM " . $table_name . " WHERE status = 1 ORDER BY id DESC;", '%d' ) );

//    $blanks = $wpdb->get_results( $wpdb->prepare('SELECT DISTINCT * FROM ' . $table_name_rate . ' r
//    LEFT JOIN ' . $table_name_program . ' p on p.id = r.blank_type_id AND p.status = 1
//    WHERE r.blank_type_id = 1 GROUP BY r.program_idORDER BY id DESC;', '%d' ) );

    $blanks = $wpdb->get_results('SELECT DISTINCT p.id, p.title FROM ' . $table_name_rate . ' r 
    RIGHT JOIN ' . $table_name_program . ' p on p.id = r.program_id AND p.status = 1 
    WHERE r.blank_type_id = ' . $blank_type_id . ' GROUP BY r.program_id;' );

    if( $blanks ){
        $result = array(
            'message' => 'OK )',
            'blanks' => $blanks
        );
    }
    else{
        $result = array(
            'message' => 'На даний момент не додано жодного бланку',
            'blanks' => ''
        );
    }


    echo json_encode( $result );

    wp_die();
}

add_action('wp_ajax_medicalmgetblanktype', 'medicalm_insurance_get_blank_types');
add_action('wp_ajax_nopriv_medicalmgetblanktype', 'medicalm_insurance_get_blank_types');

function medicalm_insurance_get_blank_types(){

    if( empty( $_POST['nonce'] ) ){
        wp_die('', '', 400);
    }

    check_ajax_referer( 'medical-m', 'nonce', true );

    global $wpdb;

    $table_name = $wpdb->get_blog_prefix() . 'insurance_blank_type';

    $blanks = $wpdb->get_results( $wpdb->prepare("SELECT id, text FROM " . $table_name . " WHERE status = 1;", '%d', '%s' ) );

    if( $blanks ){
        $result = array(
            'message' => 'OK )',
            'blanks' => $blanks
        );
    }
    else{
        $result = array(
            'message' => 'На даний момент не додано жодного типу бланкa',
            'blanks' => ''
        );
    }


    echo json_encode( $result );

    wp_die();
}

add_action('wp_ajax_getinsuranceblankseries', 'medicalm_insurance_blanks_series');
add_action('wp_ajax_nopriv_getinsuranceblankseries', 'medicalm_insurance_blanks_series');

function medicalm_insurance_blanks_series(){

    if( empty( $_POST['nonce'] ) ){
        wp_die('', '', 400);
    }

    check_ajax_referer( 'medical-m', 'nonce', true );

    $company_id = strip_tags( $_POST['company_id'] );
    $blank_type_id = strip_tags( $_POST['blank_type_id'] );

    global $wpdb;

    $table_name = $wpdb->get_blog_prefix() . 'insurance_number_of_blank';

    $blanks_series = $wpdb->get_results( $wpdb->prepare("SELECT blank_series FROM " . $table_name . " WHERE company_id = ". $company_id ." AND blank_type_id = " . $blank_type_id . " AND status = 1 GROUP BY blank_series ORDER BY id DESC;", '%d' ) );

    if( $blanks_series ){
        $result = array(
            'message' => 'OK )',
            'blanks_series' => $blanks_series,
        );
    }
    else{
        $result = array(
            'message' => 'На даний момент не додано жодної компанії',
            'blanks_series' => ''
        );
    }


    echo json_encode( $result );

    wp_die();
}


class getParent {

    function __construct() {

    }

    public $referals_array = array();


    public function get_parent_manager( $user_id ) {
        global $wpdb;
        $partner = $wpdb->get_row( "SELECT partner FROM plc_9115_prt_partners WHERE referal='$user_id'", ARRAY_A );
        return $partner;
    }

    public function get_all_partner_manager( $user_id ) {

        if( ! $user_id )
            return false;

        $partners = array();

        $partners = $this->get_parent_manager( $user_id );

        if( $partners ){

            $this->referals_array[] = $user_id;

            foreach( $partners as $partners_id ){

                $id = (int)$partners_id;

                $this->referals_array[] = $id;

                $this->get_all_partner_manager( $id );

            }
        }
    }

}


function get_parents_id( $user_id ){

    $parent = new getParent();

    $parent->get_all_partner_manager( $user_id );

    $result = $parent->referals_array;

    $result = implode( ",", $result );

    return $result;

}

//Генерация случайной строки
function random_string(){

    $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $strength = 12;

    $input_length = strlen($permitted_chars);
    $random_string = '';
    for($i = 0; $i < $strength; $i++) {
        $random_character = $permitted_chars[mt_rand(0, $input_length - 1)];
        $random_string .= $random_character;
    }

    return $random_string;

}

// $t = get_parents_id(83);

// var_dump($t);

//covid 2019
include_once 'include/covid2019.php';
