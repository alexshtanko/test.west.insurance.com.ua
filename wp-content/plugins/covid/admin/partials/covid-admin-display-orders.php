<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       alexshtanko.com.ua
 * @since      1.0.0
 *
 * @package    Covid
 * @subpackage Covid/admin/partials
 */
?>


<div class="wrap order_list_page">
    <h2><?php echo get_admin_page_title(); ?></h2>

    <div class="order-form-filter wp-core-ui">
        <form name="form_order_list" id="formOrderList" method="POST">
            <select name="order_company_title" id="orderCompanyId">
                <option value="" selected>Назва компанії</option>
                <?php foreach ($companies as $company) : ?>
                    <option value="<?php echo $company['id']; ?>"><?php echo $company['title']; ?></option>
                <?php endforeach; ?>
            </select>

            <select name="order_program_id" id="orderProgramId">
                <option value="" selected>Назва програми</option>
                <?php foreach ($programs as $program) : ?>
                    <option value="<?php echo $program['id']; ?>"><?php echo $program['title']; ?></option>
                <?php endforeach; ?>
            </select>

            <select name="order_franchise" id="orderFranchise">
                <option value="" selected>Франшиза</option>
                <?php foreach ($franchises as $franchise) : ?>
                    <option value="<?php echo $franchise['franchise']; ?>"><?php echo $franchise['franchise']; ?></option>
                <?php endforeach; ?>
            </select>

            <select name="order_blank_series" id="orderBlankSeries">
                <option value="" selected>Серія бланка</option>
                <?php foreach ($blank_series as $blank_serie) : ?>
                    <option value="<?php echo $blank_serie['blank_series']; ?>"><?php echo $blank_serie['blank_series']; ?></option>
                <?php endforeach; ?>
            </select>

            <input class="inpt-position w-140" name="order_number" id="covidBlankNumber" type="number" placeholder="Номер бланку">

            <select name="order_manager_id" id="orderManagerId">
                <option value="" selected>Менеджер</option>
                <?php foreach ($managers as $manager) : ?>
                    <option value="<?php echo $manager['id']; ?>"><?php echo $manager['name']; ?></option>
                <?php endforeach; ?>
            </select>

            <select name="order_status" id="orderStatus">
                <option value="" selected>Статус</option>
                <?php foreach ($statuses as $status) : ?>
                    <option value="<?php echo $status['id']; ?>"><?php echo $status['text']; ?></option>
                <?php endforeach; ?>
            </select>

            <select name="order_count" id="count">
                <option value="10" selected>10</option>
                <option value="25">25</option>
                <option value="50">50</option>
                <option value="100">100</option>
            </select>

            <br/>
            <div style="display: inline-block; vertical-align:top">
                <label>Дата з</label> <br/>
                <input type="date" id="OrderDateFrom">
            </div>
            <div style="display: inline-block; vertical-align:top">
                <label>Дата до</label> <br/>
                <input type="date" id="OrderDateTo">
            </div>
            <div style="display: inline-block; vertical-align:top">
                <br/>
                <button class="button button-primary button-large" id="OrderFilterSbmt">Фiльтрувати</button>
            </div>
        </form>
    </div>
    <br/>
    <table class="wp-list-table widefat fixed striped posts">
        <thead>
        <tr>
            <!--                <th class="table-50">№</th>-->
            <th class="table-50">Id</th>
            <th>Назва програми</th>
            <th>Назва компанії</th>
            <th>Серія бланка</th>
            <th>Номер бланку</th>
            <th>Ціна(грн)</th>
            <th>Менеджер</th>
            <th>Дата і час</th>
            <th>Статус</th>
            <th class="table-150 text-center">Управління</th>
        </tr>
        </thead>

        <tbody id="orderList">
        <?php echo $orders; ?>
        </tbody>
    </table>
    <div class="message-danger js-message"></div>


    <div class="pagination" id="paginations">

        <?php //echo $paginations; ?>

        <div class="paginations-total-elements js-paginations-total-elements"
             data-elements="<?php echo $orders_count; ?>">Знайдено замовлень: <span><?php echo $orders_count; ?></span>
        </div>&nbsp;|&nbsp;
        <div class="paginations-total-pages js-paginations-total-pages" data-pages="<?php echo $pages; ?>">Сторінок:
            <span><?php echo $pages; ?></span></div>
        <div class="paginations-btn paginations-btn-begin paginations-btn-disable">«</div>
        <div class="paginations-btn paginations-btn-disable paginations-btn-prev">‹</div>
        <input class="paginations-inpt js-paginations-inpt" type="text" value="1">
        <div class="paginations-btn paginations-btn-next">›</div>
        <div class="paginations-btn paginations-btn-end">»</div>
        <?php // var_dump($paginations); ?>
    </div>


</div>

<div class="covid-modal-wrapper" id="covidModal">
    <div class="covid-modal">
        <div class="covid-modal-header">
            <span class="covid-modal-header-title js-covid-modal-header-title"></span>
            <div class="covid-modal-close js-covid-modal-close"><i class="fa fa-close"></i></div>
        </div>
        <div class="covid-modal-body js-covid-modal-body">

        </div>
    </div>
</div>
<style>
    .covid-modal-wrapper.show .covid-modal {
        max-width: 480px;
        left: 5%;
    }

    .popup_table {
        width: 95%;
        margin: 0 auto;
    }

    .covid-modal-wrapper.show{
        padding: 30px 0;
    }

    .covid-modal-body {
        padding: 15px 0;
        max-height: 420px;
        overflow: auto;
    }

    .covid-modal-header {
        height: 25px;
    }


</style>