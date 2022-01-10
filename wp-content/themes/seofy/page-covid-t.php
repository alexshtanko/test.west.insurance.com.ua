<?php
/**
 * The template for displaying all pages
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

if(!isset($_GET['access']) || $_GET['access'] !== "Ke4I9)sC" ) wp_redirect( " https://".$_SERVER['HTTP_HOST'] );

get_header();
the_post();

$sb = Seofy_Theme_Helper::render_sidebars();
$row_class = $sb['row_class'];
$column = $sb['column'];
?>


<div class="wgl-container" data="COVID">
    
    <div class="row">
        <div class="vc_col-lg-12">
            <div class="covid-form-wrapper">
                <h3>Форма страхування TEST</h3>
            </div>
        </div>   
    </div>
    <div class="row">
        <div class="vc_col-lg-12 covid-form" id="covidForm">
            
                
                <form action="#" method="POST">
                <div class="covid-form-wrapper steps">
                    <div class="js-select-insurance-period"></div>
                    <div class="js-select-insurance-age"></div>
                </div><!--covid-form-wrapper end here-->

                <div class="js-insurance-list step-3"></div>


                    <!-- <div class="js-get-company"></div>
                    <div class="js-get-company-amount"></div>
                    <div class="js-get-company-period"></div>
                    <div class="js-get-insurance-price"></div> -->
                </form>
                
            

        
        </div>
    </div>
</div>



<?php
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
                <form class="js-covid-customer-form" action="/plc/c/pay_covid-t.php" method="POST">
                    <label for="covid-surname">Прiзвище</label>
                    <input name="covid-surname" class="inpt-2" type="text" required>
                    <label for="covid-name">Iм'я</label>
                    <input name="covid-name" class="inpt-2" type="text" required>
                    <!-- <label for="covid-middle-name">По батьковi</label>
                    <input name="covid-middle-name" class="inpt-2" type="text"> -->
                    <label for="covid-passport">Серiя, номер паспорта</label>
                    <input name="covid-passport" class="inpt-2" type="text" required>
                    <label for="covid-date">Дата народження</label>
<!--                    <input name="user-date" class="inpt-2 bg-calendar" type="text" readonly="readonly" required>-->
                    <input name="covid-date" class="inpt-2" type="date" required>
                    <label for="covid-address">Адреса постійного місця проживання</label>
                    <input name="covid-address" class="inpt-2" type="text" required>
                    <label for="covid-tel">Телефон</label>
                    <input name="covid-tel" class="inpt-2" type="tel" required>
                    <label for="covid-email">Email</label>
                    <input name="covid-email" class="inpt-2" type="email" required>
                    <div class="btn-wrapper">
                    <input id="covidCustomerBid" class="btn-1" type="submit" value="Замовити">
                    </div>
                    <input name="company-id" type="hidden">
                    <input name="company-amount" type="hidden">
                    <input name="company-period" type="hidden">
                    <!-- <input name="insurance-price" type="hidden"> -->
                    <div class="js-covid-customer-form-message covid-customer-form-message"></div>
                    
                </form>
            </div>
        </div>
    </div><!--epol-modal-wrapper-inner end here-->
</div><!--epol-modal-wrapper end here-->