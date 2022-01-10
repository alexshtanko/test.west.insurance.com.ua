<?php
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

//    if ( ! array_intersect( $allowed_roles, $user->roles ) ) {
//        wp_redirect( " https://" . $_SERVER['HTTP_HOST'] . "/medical" );
//    }
}
else{
//    wp_redirect( " https://" . $_SERVER['HTTP_HOST'] . "/medical" );
    wp_redirect( " https://" . $_SERVER['HTTP_HOST'] . "/" );
    exit;
}

get_header();
the_post();
global $wpdb;

$sb = Seofy_Theme_Helper::render_sidebars();
$row_class = $sb['row_class'];
$column = $sb['column'];
date_default_timezone_set('Europe/Kiev');

//$dateFrom = date('Y-m-d');
$dateFrom = date('d.m.Y', strtotime('+1 day'));
//$dateTo = date('Y-m-d', strtotime('+1 year -1 day'));
$dateTo = date('d.m.Y', strtotime('+1 year'));


//service_stop
$table_ewa_config = $wpdb->prefix . "ewa_config";
$service_stop = $wpdb->get_results("SELECT value FROM ".$table_ewa_config." WHERE `key` = 'service_stop'");

$blank_type_id = 0;

if( isset( $_GET['blank_type_id'] ) ){
    $blank_type_id = (int) $_GET['blank_type_id'];
}

the_content();
?>


<div class="wgl-container">
    <?php
    if(count($service_stop) == 1 && $service_stop[0]->value == 1){
        echo "<div class='steps'><h2>Сервіс тимчасово не працює!</h2></div>";
    }
    else {
        $current_user = wp_get_current_user();
        if ( $current_user->ID ) {

            $user = wp_get_current_user();
            $allowed_roles = array( 'user_manager', 'administrator' );

            //if ( array_intersect( $allowed_roles, $user->roles ) ) { ?>


                <div class="js-test"></div>

                <div class="row">
                    <div class="vc_col-lg-12">
                        <div class="medical-form-wrapper">
                            <h3>Форма страхування</h3>
                            <div class="insurance-vait js-insurance-vait">Отримання данних вiд сервера, будь ласка зачекайте...</div>
                        </div>

                    </div>
                </div>

                <div class="row">
                    <div class="vc_col-lg-12 medical-form" >

                        <form action="#" method="POST" id="medicalForm">
                            <div class="js-steps-and-list">
                                <div class="medical-form-wrapper steps">
                                    <?php if( $blank_type_id == 0 ) : ?>
                                        <div class="js-select-insurance-blank-type"></div>
                                    <?php endif; ?>
                                    <div class="js-select-insurance-blank"></div>
                                    <div class="js-select-insurance-period"></div>
                                    <!-- <div class="js-select-insurance-age"></div> -->

                                    <div class="message-wrapper js-message"></div>


                                </div><!--medical-form-wrapper end here-->

                                <div class="js-insurance-list step-3"></div>

                            </div>



                                                             <div class="js-insurance-form hidden">
<!--                            <div class="js-insurance-form">-->

                                <div class="insurance-data js-insurance-data">
                                    <div class="row">
                                        <div class="vc_col-lg-10">
                                            <div class="insurance-data-field js-insurance-data-blank-title">Назва програми: <span></span></div>
                                            <div class="insurance-data-field js-insurance-data-validity">Перiод страхування (днiв): <span></span></div>
                                            <div class="insurance-data-field js-insurance-data-company-title">Назва компанії: <span></span></div>
                                            <div class="insurance-data-field js-insurance-data-insured-sum">Страхова сума: <span></span></div>
                                            <div class="insurance-data-field js-insurance-data-franchise">Франшиза: <span></span></div>
                                            <div class="insurance-data-field js-insurance-data-price">Ціна: <span></span> грн</div>
                                            <div class="insurance-data-field js-insurance-data-location">Територія дії: <span></span></div>

                                        </div>
                                        <div class="vc_col-lg-2">
                                            <a href="#" class="insurance-go-prev-step" id="goInsuranceList">Назад</a>
                                        </div>
                                    </div>
                                </div>

                                <div class="row user-profile-line-1">
                                    <div class="vc_col-lg-4">
                                        <div class="inpt-wrapper">
                                            <label for="medical_date_start" class="label-1 label-required">Дата початку дiї договору</label>
                                            <input name="medical_date_start" type="text" class="inpt-5 bg-calendar" id="medical_date_start" autocomplete="off"  placeholder="дд.мм.рррр">
                                        </div>
                                    </div>

                                    <div class="vc_col-lg-4">
                                        <div class="inpt-wrapper">
                                            <label for="medical_last_name" class="label-1 label-required">Прізвище</label>
                                            <input name="medical_last_name" type="text" class="inpt-5" id="medical_last_name" >
                                        </div>
                                    </div>
                                    <div class="vc_col-lg-4">
                                        <div class="inpt-wrapper">
                                            <label for="medical_name" class="label-1 label-required">Ім'я</label>
                                            <input name="medical_name" type="text" class="inpt-5" id="medical_name" >
                                        </div>
                                    </div>
                                </div>

                                <div class="row user-profile-line-1">
                                    <div class="vc_col-lg-2">
                                        <div class="inpt-wrapper">
                                            <label for="medical_date" class="label-1 label-required">Дата народження</label>
                                            <input name="medical_date" type="text" class="inpt-5 bg-calendar" id="medical_date" autocomplete="off"  placeholder="дд.мм.рррр">
                                        </div>
                                    </div>
                                    <div class="vc_col-lg-2">
                                        <div class="inpt-wrapper">
                                            <label for="medical_tel" class="label-1">Телефон</label>
                                            <input name="medical_tel" type="tel" class="inpt-5" id="medical_tel">
                                        </div>
                                    </div>

                                    <div class="vc_col-lg-4">
                                        <div class="inpt-wrapper">
                                            <label for="medical_passport" class="label-1 label-required">Серiя, номер паспорта</label>
                                            <input name="medical_passport" type="text" class="inpt-5" id="medical_passport" >
                                        </div>
                                    </div>

                                    <div class="vc_col-lg-4">
                                        <div class="inpt-wrapper">
                                            <label for="medical_address" class="label-1 label-required">Адреса постійного місця проживання</label>
                                            <input name="medical_address" type="text" class="inpt-5" id="medical_address" >
                                        </div>
                                    </div>

                                </div>

                             <?php if( $blank_type_id == 1 ) : ?>
                                <div class="row user-profile-line-1 js-blank-line">

                                        <div class="vc_col-lg-4 js-box-series">
                                            <div class="inpt-wrapper">
                                                <div class="js-select-insurance-blank-series"></div>
                                            </div>
                                        </div>

                                        <div class="vc_col-lg-4 js-box-blank-number">
                                            <div class="inpt-wrapper">
                                                <label for="medical_blank_number" class="label-1 label-required">Номер бланку</label>
                                                <input name="medical_blank_number" type="number" class="inpt-5" id="medical_blank_number" >

                                            </div>
                                        </div>


                                    <div class="vc_col-lg-4 js-box-email">
                                        <div class="inpt-wrapper">
                                            <label for="medical_email" class="label-1">Email</label>
                                            <input name="medical_email" type="email" class="inpt-5" id="medical_email" autocomplete="off">
                                        </div>
                                    </div>
                                </div>

                                 <div class="row user-profile-line-1 js-coefficient-line">
                                     
                                     <div class="vc_col-lg-4 js-box-coefficient" id="priceCoefficientBox">
                                         <div class="inpt-wrapper">
                                             <label class="label-1">Оберіть коефіцієнт надбавки</label>
                                             <div class="dd-list-wrapper">

                                                 <input type="text" id="priceCoefficient" class="dd-hide-filed" readonly="readonly" value="1" name="medical_price_coefficient">
                                                 <div class="dd-arrow"></div>

                                                 <div class="dd-list-input">1</div>
                                                 <ul class="dd-list">
                                                     <li data-value="1">1</li>
                                                     <li data-value="1.5">1.5</li>
                                                     <li data-value="1.7">1.7</li>
                                                     <li data-value="2">2</li>
                                                     <li data-value="2.5">2.5</li>
                                                 </ul>
                                             </div>
                                         </div>
                                     </div>


                                     <div class="vc_col-lg-4 js-box-add-insurer">
                                         <div class="add-insurer-wrapper">
                                             <label class="label-1">Додати страхувальника до застрахованих осiб</label>
                                             <input type="checkbox" name="add-insurer" id="addInserer" checked><label for="addInserer" title="Якщо страхувальник та застрахована одна i таж особа, нiчого добавляти не потрiбно." ></label>

                                             <button type="button" class="btn-1 btn-add-insurers" id="addInserers" title="Додати ще одного застрахованого.">+</button>
                                         </div>
                                     </div>
                                 </div>

                    <?php elseif( $blank_type_id == 2 ) : ?>

                                 <div class="row user-profile-line-1">

                                     <div class="vc_col-lg-4">
                                         <div class="inpt-wrapper">
                                             <label for="medical_email" class="label-1">Email</label>
                                             <input name="medical_email" type="email" class="inpt-5" id="medical_email" autocomplete="off">
                                         </div>
                                     </div>

                                     <div class="vc_col-lg-4" id="priceCoefficientBox">
                                         <div class="inpt-wrapper">
                                             <label class="label-1">Оберіть коефіцієнт надбавки</label>
                                             <div class="dd-list-wrapper">

                                                 <input type="text" id="priceCoefficient" class="dd-hide-filed" readonly="readonly" value="1" name="medical_price_coefficient">
                                                 <div class="dd-arrow"></div>

                                                 <div class="dd-list-input">1</div>
                                                 <ul class="dd-list">
                                                     <li data-value="1">1</li>
                                                     <li data-value="1.5">1.5</li>
                                                     <li data-value="1.7">1.7</li>
                                                     <li data-value="2">2</li>
                                                     <li data-value="2.5">2.5</li>
                                                 </ul>
                                             </div>
                                         </div>
                                     </div>


                                     <div class="vc_col-lg-4">
                                         <div class="add-insurer-wrapper">
                                             <label class="label-1">Додати страхувальника до застрахованих осiб</label>
                                             <input type="checkbox" name="add-insurer" id="addInserer" checked><label for="addInserer" title="Якщо страхувальник та застрахована одна i таж особа, нiчого добавляти не потрiбно." ></label>

                                             <button type="button" class="btn-1 btn-add-insurers" id="addInserers" title="Додати ще одного застрахованого.">+</button>
                                         </div>
                                     </div>

                                 </div>

                             <?php else : ?>

                                 <div class="row user-profile-line-1 js-blank-line">

                                     <div class="vc_col-lg-4 js-box-series">
                                         <div class="inpt-wrapper">
                                             <div class="js-select-insurance-blank-series"></div>
                                         </div>
                                     </div>

                                     <div class="vc_col-lg-4 js-box-blank-number">
                                         <div class="inpt-wrapper">
                                             <label for="medical_blank_number" class="label-1 label-required">Номер бланку</label>
                                             <input name="medical_blank_number" type="number" class="inpt-5" id="medical_blank_number" >

                                         </div>
                                     </div>


                                     <div class="vc_col-lg-4 js-box-email">
                                         <div class="inpt-wrapper">
                                             <label for="medical_email" class="label-1">Email</label>
                                             <input name="medical_email" type="email" class="inpt-5" id="medical_email" autocomplete="off">
                                         </div>
                                     </div>
                                 </div>

                                 <div class="row user-profile-line-1 js-coefficient-line">

                                     <div class="vc_col-lg-4 js-box-coefficient" id="priceCoefficientBox">
                                         <div class="inpt-wrapper">
                                             <label class="label-1">Оберіть коефіцієнт надбавки</label>
                                             <div class="dd-list-wrapper">

                                                 <input type="text" id="priceCoefficient" class="dd-hide-filed" readonly="readonly" value="1" name="medical_price_coefficient">
                                                 <div class="dd-arrow"></div>

                                                 <div class="dd-list-input">1</div>
                                                 <ul class="dd-list">
                                                     <li data-value="1">1</li>
                                                     <li data-value="1.5">1.5</li>
                                                     <li data-value="1.7">1.7</li>
                                                     <li data-value="2">2</li>
                                                     <li data-value="2.5">2.5</li>
                                                 </ul>
                                             </div>
                                         </div>
                                     </div>


                                     <div class="vc_col-lg-4 js-box-add-insurer">
                                         <div class="add-insurer-wrapper">
                                             <label class="label-1">Додати страхувальника до застрахованих осiб</label>
                                             <input type="checkbox" name="add-insurer" id="addInserer" checked><label for="addInserer" title="Якщо страхувальник та застрахована одна i таж особа, нiчого добавляти не потрiбно." ></label>

                                             <button type="button" class="btn-1 btn-add-insurers" id="addInserers" title="Додати ще одного застрахованого.">+</button>
                                         </div>
                                     </div>
                                 </div>


                             <?php endif; ?>



                                <div class="insurer-wrapper js-insurer-wrapper"></div>

                                <?php /*<div class="insurer-row">
                                    <div class="row">
                                        <div class="vc_col-lg-4">
                                            <label class="label-1" for="insurerLastName">Прiзвище</label>
                                            <input class="inpt-5" type="text" id="insurerLastName">
                                        </div>
                                        <div class="vc_col-lg-4">
                                            <label class="label-1" for="insurerName">Ім'я</label>
                                            <input class="inpt-5" type="text" id="insurerName">
                                        </div>
                                        <div class="vc_col-lg-4">
                                            <div class="inpt-wrapper">
                                                <label class="label-1" for="insurerDate">Дата народження</label>
                                                <input class="inpt-5 bg-calendar add-data-picker" type="text" id="insurerDate" autocomplete="off" required placeholder="дд.мм.рррр">
<!--                                            <input name="medical_date_start" type="text" class="inpt-5 bg-calendar" id="medical_date_start" autocomplete="off" required placeholder="дд.мм.рррр">-->
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="vc_col-lg-5">
                                            <label class="label-1" for="insurerPassport">Серiя, номер паспорта</label>
                                            <input class="inpt-5" type="text" id="insurerPassport">
                                        </div>
                                        <div class="vc_col-lg-5">
                                            <label class="label-1" for="insurerAddress">Адреса постійного місця проживання</label>
                                            <input class="inpt-5" type="text" id="insurerAddress">
                                        </div>
                                        <div class="vc_col-lg-2">
                                            <button class="btn-1 add-insurer-row js-add-insurer-row">+</button>
                                            <button class="btn-1 remove-insurer-row js-remove-insurer-row">-</button>

                                        </div>
                                    </div>
                                </div><!--insurer-wrapper end here--> */ ?>


                                <?php if( $blank_type_id != 0 ) : ?>
                                    <input name="blank_type_id" id="blank_type_id" type="hidden" value="<?php echo $blank_type_id; ?>">
                                <?php endif; ?>
                                <input name="company_id" type="hidden">
                                <input name="company_franchise" type="hidden">
                                <input name="company_period" type="hidden">
                                <input name="company_title" type="hidden">
                                <input name="blank_title" type="hidden">
<!--                                <input name="blank_id" type="hidden">-->

                                <input name="rate_id" type="hidden">
                                <input name="rate_franchise" type="hidden">
                                <input name="rate_validity" type="hidden">
                                <input name="rate_insured_sum" type="hidden">
                                <input name="rate_price" type="hidden">
                                <input name="rate_coefficient" type="hidden">
                                <input name="rate_locations" type="hidden">

                                <div class="step-4-footer">
                                    <div class="medical-btn-wrapper">
                                        <input class="btn-get-it js-btn-get-it" type="submit" value="Оформити полiс">
                                    </div>
                                </div>

                            </div>
                        </form>

                        <div class="insurance-form-message js-insurance-form-message"></div>

                        <div class="insurance-form-last-step js-insurance-form-last-step"></div>

                    </div>
                </div>

            <?php /*}
            else{

                echo 'У вас нема доступу.';

            }*/
        }
        else{
            echo '<h1>Ви не увійшли в систему. Будь-ласка <a href="/">авторизуйтеся</a>.</h1>';
        }
    }
    ?>
</div>

<?php
if($current_user->ID == 16 OR $current_user->ID == 39){
    ?>
    <script>
        jQuery('form#medicalForm').find("input[type='submit']").prop('disabled',true);
    </script>
    <?php
}

get_footer();

?>

<div class="epol-modal-wrapper">
    <div class="epol-modal-wrapper-inner">
        <div class="epol-modal">
            <div class="epol-modal-header">
                <div class="epol-modal-close js-epol-modal-close"></div>
                <h3>Замовити полic</h3>
            </div>
            <div class="epol-modal-body">
                <form class="js-medical-customer-form" action="/plc/c/pay_medical.php" method="POST">
                    <label for="medical-surname">Прiзвище</label>
                    <input name="medical-surname" class="inpt-2" type="text" required>
                    <label for="medical-name">Iм'я</label>
                    <input name="medical-name" class="inpt-2" type="text" required>
                    <!-- <label for="medical-middle-name">По батьковi</label>
                    <input name="medical-middle-name" class="inpt-2" type="text"> -->
                    <label for="medical-passport">Серiя, номер паспорта</label>
                    <input name="medical-passport" class="inpt-2" type="text" required>
                    <label for="medical-date">Дата народження</label>
                    <!--                    <input name="user-date" class="inpt-2 bg-calendar" type="text" readonly="readonly" required>-->
                    <input name="medical-date" class="inpt-2" type="date" required>
                    <label for="medical-address">Адреса постійного місця проживання</label>
                    <input name="medical-address" class="inpt-2" type="text" required>
                    <label for="medical-tel">Телефон</label>
                    <input name="medical-tel" class="inpt-2" type="tel" required>
                    <label for="medical-email">Email</label>
                    <input name="medical-email" class="inpt-2" type="email" required>
                    <input name="blank-number" class="inpt-2" type="number" required>
                    <div class="btn-wrapper">
                        <input id="medicalCustomerBid" class="btn-1" type="submit" value="Замовити">
                    </div>
                    <input name="company-id" type="hidden">
                    <input name="company-franchise" type="hidden">
                    <input name="company-period" type="hidden">
                    <!-- <input name="insurance-price" type="hidden"> -->
                    <div class="js-medical-customer-form-message medical-customer-form-message"></div>

                </form>
            </div>
        </div>
    </div><!--epol-modal-wrapper-inner end here-->
</div><!--epol-modal-wrapper end here-->
    