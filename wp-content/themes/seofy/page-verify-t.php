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

get_header();
?>
    <div class="wgl-container verify-page">

<?php
if(isset($_GET['unique_code'])) {
    $unique_code = trim($_GET['unique_code']);
	global $wpdb;
	$table_name = $wpdb->prefix . "ewa";

	$orders = $wpdb->get_results( "SELECT * FROM `" . $table_name . "` WHERE `unique-code` = '".$unique_code."'", ARRAY_A );

	if(count($orders) == 1){
	    $order = $orders[0];
//		echo "<pre>";
//		print_r($orders);
//		echo "</pre>";

		if($order["liqpay-status"] == "success" OR $order["liqpay-status"] == "sandbox"){
		    ?>
        <div class="verify-data">
            <div class="row">
                <div class="vc_col-lg-12">
                    <div class="verify-title">Введіть код із SMS повідомлення (ТЕСТ)</div>
                </div>
            </div>

            <div class="row">
                <div class="vc_col-xs-2 vc_col-sm-2 vc_col-md-3 vc_col-lg-4"></div>
                <div class="vc_col-xs-8 vc_col-sm-8 vc_col-md-6  vc_col-lg-4">
                    <div class="verify-wrapper">
                        <form action="#" action="POST" id="verify-sms">

                            <div class="row">
                                <div class="vc_col-xs-12 vc_col-sm-6 vc_col-md-6 vc_col-lg-6">


                                    <input class="inpt-5" type="text" id="verify" name="verify" minlength="6" maxlength="6" required>
                                </div>
                                <div class="vc_col-xs-12 vc_col-sm-6 vc_col-md-6 vc_col-lg-6">
                                    <input class="btn-submit" type="submit" value="Надіслати">
                                </div>
                        </form>
                    </div>
                    <div class="verify-error" style="display: none;">
                        <p>Введено невірний код із смс повідомлення!</p>
                    </div>
                </div>
            </div>
        </div>

            <script>
                jQuery(document).ready(function() {
                    var AjaxUrl = location.protocol + "//" + window.location.hostname + "/plc/c/check_sms-t.php";
                    var uniqueCode = '';
                    var enteredSmsCode = '';
                    var urlParams = new URLSearchParams(window.location.search);

                    if (typeof urlParams.get('unique_code') != 'undefined' && !!urlParams.get('unique_code')) {
                        uniqueCode = urlParams.get('unique_code');
                    }

                    jQuery('form#verify-sms').submit(function(e) {
                        e.preventDefault();
                        //jQuery(this).find("input[type='submit']").prop('disabled',true);

                        enteredSmsCode = jQuery("#verify-sms input[name='verify']").val();

                        jQuery.ajax(AjaxUrl, {
                            type: "POST",
                            data: "checksms=true&smsCode=" + enteredSmsCode +
                                "&uniqueCode=" + uniqueCode,
                            timeout: 91000000,
                            success: function (data, textStatus, jqXHR) {
                                var request = JSON.parse(data);

                                if(request.status == "ok"){
                                    jQuery(".verify-data").html("<div class='row'><div class='vc_col-lg-12'><div class='verify-title'><p>Ваш поліс успішно укладений.</p><p>Через кілька хвилин Ви отримаєте його на електронну пошту.</p><p>Поліс <?php echo $order['contract-id']; ?> для ТЗ <?php echo $order['car-number']; ?> укладено.</p><p>Сторінка для перевірки <a href='http://ep.ewa.ua/<?php echo $order['contract-code']; ?>'>http://ep.ewa.ua/<?php echo $order['contract-code']; ?></a></p><p>Дякуємо що обрали нас сервіс. <a href='https://epolicy.com.ua'>epolicy.com.ua</a></p></div></div></div>");
                                }
                                else {
                                    jQuery(".verify-error").fadeIn(500).delay(3000).fadeOut(500);
                                }
                            },
                            error: function (x, t, m) {
                                alert("Помилка надсилання запиту, спробуйте пізніше.");
                            }
                        });
                    });
                });
            </script>

            <?php
        }
		else {
		    // Проплата не прошла
            ?>
            <div class="row">
                <div class="vc_col-lg-12">
                    <div class="verify-title">Проплата ще не надійшла. Почекайте пару хвилин і оновіть сторінку.</div>
                </div>
            </div>

            <script>
                setTimeout(function() { window.location=window.location;},20000);
            </script>
            <?php
        }
    }
	else {
        // Такой заказ не найден или передан неправильный параметр
        ?>
        <div class="row">
            <div class="vc_col-lg-12">
                <div class="verify-title">Код замовлення не вірний</div>
            </div>
        </div>
        <?php
    }
}
else {
    ?>
	<div class="row">
            <div class="vc_col-lg-12">
                <div class="verify-title">Код замовлення не вірний</div>
            </div>
        </div>
    <?php
}
?>

    </div>

<?php

the_post();

$sb = Seofy_Theme_Helper::render_sidebars();
$row_class = $sb['row_class'];
$column = $sb['column'];
?>
<div class="wgl-container">
    <div class="row <?php echo apply_filters('seofy_row_class', $row_class); ?>">
        <div id='main-content' class="wgl_col-<?php echo apply_filters('seofy_column_class', $column); ?>">
            <?php
            the_content(esc_html__('Read more!', 'seofy'));
            wp_link_pages(array('before' => '<div class="page-link">' . esc_html__('Pages', 'seofy') . ': ', 'after' => '</div>'));
            if ( comments_open() || get_comments_number() ) :
                comments_template();
        endif; ?>
    </div>
    <?php
    echo (isset($sb['content']) && !empty($sb['content']) ) ? $sb['content'] : '';
    ?>           
</div>
</div>
<?php
get_footer(); 

?>