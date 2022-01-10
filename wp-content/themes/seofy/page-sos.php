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
the_post();

$sb = Seofy_Theme_Helper::render_sidebars();
$row_class = $sb['row_class'];
$column = $sb['column'];
?>


<div class="wgl-container" data="SOS">

    <div class="row">
        <div class="vc_col-lg-12">
            <?php the_content(esc_html__('Read more!', 'seofy')); ?>
        </div>
    </div>
    <div class="row">
        <div class="vc_col-lg-12">
            <div class="sos-table">
                <table>
                    <thead>
                        <tr>
                            <td>№ п.п.</td>
                            <td>Назва СК</td>
                            <td>Цілодобовий контакт-центр</td>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td><a target="_blank" href="https://globalgarant.com.ua/ru/insurances/strahovij-vipadok-osago/">Global Garant</a></td>
                            <td><p><a href="tel:0443577080">(044)3577080</a></p></td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td><a target="_blank" href="https://www.ubi.ua/strahovoj-sluchaj-avtograzhdanka/">UBI-COOP</a></td>
                            <td><p><a href="tel:0995542000">(099)5542000</a></p></td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td><a target="_blank" href="https://usi.net.ua/strakhovyi-vypadok">USI</a></td>
                            <td><p><a href="tel:0800308400">0800308400</a></p></td>
                        </tr>
                        <tr>
                            <td>4</td>
                            <td><a target="_blank" href="https://alfagarant.com/caseosago">Альфа-Гарант</a></td>
                            <td><p><a href="tel:0800501710">0800501710</a></p></td>
                        </tr>
                        <tr>
                            <td>5</td>
                            <td><a target="_blank" href="https://alfaic.ua/straxovoj-sluchaj/kasko/dorozhno-transportnoe-proisshestvie-dtp#">Альфа Страхування</a></td>
                            <td><p><a href="tel:0800309999">0800309999</a></p></td>
                        </tr>
                        <tr>
                            <td>6</td>
                            <td><a target="_blank" href="https://arx.com.ua/strakhoviy-vypadok/avtotsyvilka">АРКС</a></td>
                            <td><p><a href="tel:0800302723">0800302723</a></p></td>
                        </tr>
                        <tr>
                            <td>7</td>
                            <td><a target="_blank" href="https://arsenal-ic.ua/ru/insurance-case#category-transport_tab-1">Арсенал</a></td>
                            <td><p><a href="tel:0800604453">0800604453</a></p></td>
                        </tr>
                        <tr>
                            <td>8</td>
                            <td><a target="_blank" href="https://aska.ua/ru/insurance-accident/avtocivilka">АСКА</a></td>
                            <td><p><a href="tel:0800601701">0800601701</a></p><p><a href="tel:0800503707">0800503707</a></p></td>
                        </tr>
                        <tr>
                            <td>9</td>
                            <td><a target="_blank" href="https://askods.com">АСКО-Донбас Північний</a></td>
                            <td><p><a href="tel:0800501560">0800501560</a></p></td>
                        </tr>
                        <tr>
                            <td>10</td>
                            <td><a target="_blank" href="https://vuso.ua/kontaktyi/straxovoj-sluchaj-kuda-zvonit.html">ВУСО</a></td>
                            <td><p><a href="tel:0800503773">0800503773</a></p></td>
                        </tr>
                        <tr>
                            <td>11</td>
                            <td><a target="_blank" href="https://grdn.com.ua/straxovij-vipadok/">Гардіан</a></td>
                            <td><p><a href="tel:0800503114">0800503114</a></p></td>
                        </tr>
                        <tr>
                            <td>12</td>
                            <td><a target="_blank" href="http://www.etalon.ua/repair_damage/avto/responsibility/responsibility-actions/">Еталон</a></td>
                            <td><p><a href="tel:0800305800">0800305800</a></p></td>
                        </tr>
                        <tr>
                            <td>13</td>
                            <td><a target="_blank" href="https://eia.com.ua/node/176">ЄСА</a></td>
                            <td><p><a href="tel:0800305800">0800305800</a></p></td>
                        </tr>
                        <tr>
                            <td>14</td>
                            <td><a target="_blank" href="https://megagarant.com/straxovoj-sluchaj/">Мега-гарант</a></td>
                            <td><p><a href="tel:0800502071">0800502071</a></p></td>
                        </tr>
                        <tr>
                            <td>15</td>
                            <td><a target="_blank" href="https://motor-garant.com.ua/contact">Мотор-Гарант</a></td>
                            <td><p><a href="tel:0800309709">0800309709</a></p></td>
                        </tr>
                        <tr>
                            <td>16</td>
                            <td><a target="_blank" href="https://www.oberig-sg.com/online">Обериг</a></td>
                            <td><p><a href="tel:0800218201">0800218201</a></p></td>
                        </tr>
                        <tr>
                            <td>17</td>
                            <td><a target="_blank" href="https://omega.ua/ru/ctrahovoj-sluchaj">Омега</a></td>
                            <td><p><a href="tel:0800301010">0800301010</a></p></td>
                        </tr>
                        <tr>
                            <td>18</td>
                            <td><a target="_blank" href="https://oranta.ua/ru/insurance-case/avtotsivilka/">Оранта</a></td>
                            <td><p><a href="tel:0800050505">0800050505</a></p></td>
                        </tr>
                        <tr>
                            <td>19</td>
                            <td><a target="_blank" href="https://universalna.com/strahoviy-vipadok/ocv/">Універсальна</a></td>
                            <td><p><a href="tel:0800500381">0800500381</a></p></td>
                        </tr>
                        <tr>
                            <td>20</td>
                            <td><a target="_blank" href="https://upsk.com.ua/service/actions/diyi_oscpv/">УПСК</a></td>
                            <td><p><a href="tel:0800507050">0800507050</a></p></td>
                        </tr>
                        <tr>
                            <td>21</td>
                            <td><a target="_blank" href="http://www.ukringroup.com.ua/ua/case/osago/actions">УСГ</a></td>
                            <td><p><a href="tel:0800500349">0800500349</a></p></td>
                        </tr>
                    </tbody>
                    
                </table>
            </div><!--sos-table end here-->
        </div>   
    </div>
    
</div>



<?php
get_footer(); 

?>
