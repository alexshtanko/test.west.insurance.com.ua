<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       alexshtanko.com.ua
 * @since      1.0.0
 *
 * @package    Insurance
 * @subpackage Insurance/admin/partials
 */
?>



<div class="wrap rate_list_page">
    <h2><?php echo get_admin_page_title(); ?></h2>

    <div class="rate-form-filter wp-core-ui">
        <form name="form_rate_list" id="formRateList" method="POST">
            <select name="rate_company_title" id="rateCompanyTitle">
                <option value="" selected>Назва компанії</option>
                <?php foreach( $companies as $company ) : ?>
                    <option value="<?php echo $company['id']; ?>"><?php echo $company['title']; ?></option>
                <?php endforeach; ?>
            </select>

            <select name="rate_blank_title" id="rateBlankTitle">
                <option value="" selected>Назва програми</option>
                <?php foreach( $programs as $program ) : ?>
                    <option value="<?php echo $program['id']; ?>"><?php echo $program['title']; ?></option>
                <?php endforeach; ?>
            </select>

            <select name="rate_franchise" id="rateFranchise">
                <option value="" selected>Франшиза</option>
                <?php foreach( $franchises as $franchise ) : ?>
                    <option value="<?php echo $franchise['franchise']; ?>"><?php echo $franchise['franchise']; ?></option>
                <?php endforeach; ?>
            </select>

            <select name="rate_validity" id="rateValidity">
                <option value="" selected>Термін дії</option>
                <?php foreach( $validities as $validity ) : ?>
                    <option value="<?php echo $validity['validity']; ?>"><?php echo $validity['validity']; ?></option>
                <?php endforeach; ?>
            </select>

            <select name="rate_sum" id="rateSum">
                <option value="" selected>Страхова сума</option>
                <?php foreach( $insured_sum as $sum ) : ?>
                    <option value="<?php echo $sum['insured_sum']; ?>"><?php echo $sum['insured_sum']; ?></option>
                <?php endforeach; ?>
            </select>

            <select name="rate_location" id="rateLocation">
                <option value="" selected>Територія дії</option>
                <?php foreach( $locations as $location ) : ?>
                    <option value="<?php echo $location['locations']; ?>"><?php echo $location['locations']; ?></option>
                <?php endforeach; ?>
            </select>

            <select name="rate_count" id="count">
                <option value="10" selected>10</option>
                <option value="25">25</option>
                <option value="50">50</option>
                <option value="100">100</option>
            </select>
            <button class="button button-primary button-large" id="RateFilterSbmt">Фiльтрувати</button>
        </form>
    </div>
    <table class="wp-list-table widefat fixed striped posts">
        <thead>
            <tr>
                <th class="table-50">№</th>
                <th class="table-50">Id</th>
                <th>Назва компанії</th>
                <th>Франшиза</th>
                <th>Термін дії</th>
                <th>Страхова сума</th>
                <th>Ціна(грн)</th>
                <th>Територія дії</th>
                <th>Програма</th>
                <th class="table-100 text-center">Управління</th>
            </tr>
        </thead>

        <tbody id="rateList">
            <?php echo $rates; ?>
           
            <?php /*$i = 1; ?>
            <?php foreach( $rates as $rate ) : ?>
                <tr>
                    <td><?php echo $i; ?></td>
                    <td><?php echo $rate['id']; ?></td>
                    <td><?php echo $rate['commpany_title']; ?></td>
                    <td><?php echo $rate['franchise']; ?></td>
                    <td><?php echo $rate['validity']; ?></td>
                    <td><?php echo $rate['insured_sum']; ?></td>
                    <td><?php echo $rate['price']; ?></td>
                    <td><?php echo $rate['locations']; ?></td>
                    <td><?php echo $rate['blank_title']; ?></td>
                    <td><button class="button button-primary button-large deleteRow" data-id="<?php echo $rate['id']; ?>"><i class="fa fa-trash"></i></button></td>
                </tr>
            <?php 
                $i ++; 
                endforeach; */
            ?>
        </tbody>
    </table>
    <div class="message-danger js-message"></div>

    
    <div class="pagination" id="paginations">
            
            <?php //echo $paginations; ?>
            
            <div class="paginations-total-elements js-paginations-total-elements" data-elements="<?php echo $rates_count; ?>">Знайдено тарифів: <span><?php echo $rates_count; ?></span></div>&nbsp;|&nbsp;
            <div class="paginations-total-pages js-paginations-total-pages" data-pages="<?php echo $pages; ?>">Сторінок: <span><?php echo $pages; ?></span></div>
            <div class="paginations-btn paginations-btn-begin paginations-btn-disable">«</div>
            <div class="paginations-btn paginations-btn-disable paginations-btn-prev">‹</div>
            <input class="paginations-inpt js-paginations-inpt" type="text" value="1">
            <div class="paginations-btn paginations-btn-next">›</div>
            <div class="paginations-btn paginations-btn-end">»</div>
        <?php // var_dump($paginations); ?>
    </div>



</div>
