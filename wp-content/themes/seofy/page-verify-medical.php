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
			$unique_code = trim( $_GET['unique_code'] );
			global $wpdb;
			$table_name = $wpdb->prefix . "medical";

			$orders = $wpdb->get_results( "SELECT * FROM `" . $table_name . "` WHERE `unique-code` = '" . $unique_code . "'", ARRAY_A );

			if ( count( $orders ) == 1 ) {
				$order = $orders[0];
//		echo "<pre>";
//		print_r($orders);
//		echo "</pre>";

				if ( $order["liqpay-status"] == "success" OR $order["liqpay-status"] == "sandbox" ) {
					?>
                    <div class="verify-data">
                        <div class="row">
                            <div class="vc_col-lg-12">
                                <div class="verify-title">Страховий поліс успішно укладено. Протягом декількох годин на Вашу електронну адресу «<strong><a href="mailto:<?php echo $order["email"]; ?>"><?php echo $order["email"]; ?></a></strong>» буде відправлено підтверджуючий документ.</div>
                            </div>
                        </div>
                    </div>
					<?php
				} else {
					?>
                    <div class="row">
                        <div class="vc_col-lg-12">
                            <div class="verify-title">Оплата по даному страховому полісу ще не надійшла. Спробуйте оновити сторінку через пару хвилин.</div>
                        </div>
                    </div>
					<?php
				}
			}
			else {
				?>
                <div class="row">
                    <div class="vc_col-lg-12">
                        <div class="verify-title">Код замовлення не знайдено</div>
                    </div>
                </div>
				<?php
            }
		}
		else {
			?>
            <div class="row">
                <div class="vc_col-lg-12">
                    <div class="verify-title">Код замовлення не передано</div>
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