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

$current_user = wp_get_current_user();
if( $current_user->ID ) {
	$user          = wp_get_current_user();
	$allowed_roles = array( 'user_manager' );

	if ( array_intersect( $allowed_roles, $user->roles ) ) {
		wp_redirect( " https://" . $_SERVER['HTTP_HOST'] . "/medical-m" );
	}
}

get_header();
the_post();

$sb = Seofy_Theme_Helper::render_sidebars();
$row_class = $sb['row_class'];
$column = $sb['column'];



?>


<div class="wgl-container" data="MEDICAL">

    <div class="row">
        <div class="vc_col-lg-12">
            <div class="medical-form-wrapper">
                <h3>Форма страхування</h3>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="vc_col-lg-12 medical-form" id="medicalForm">


            <form action="#" method="POST">
                <div class="medical-form-wrapper steps">
                    <div class="js-select-insurance-period"></div>
                    <div class="js-select-insurance-age"></div>
                </div><!--medical-form-wrapper end here-->

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