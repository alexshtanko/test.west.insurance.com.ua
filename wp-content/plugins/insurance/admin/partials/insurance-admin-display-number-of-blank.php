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


<div class="wrap">
    <h1><?php echo get_admin_page_title(); ?></h1>
    <?php if ($companies) : ?>
        <?php
        echo '<p><a href="' . admin_url('admin.php?page=insurance-blank-to-manager') . '" class="blank-to-manager">
                <i class="fa fa-user"></i> Закріплення нумерації бланків за менеджером</a></p>';
        ?>

        <h2>Додати нумерацію</h2>
        <form action="" method="POST" id="formNumberOfBlank">
            <div class="number-of-blanks-form-wrapper tablenav top">

                <select name="blank_type_id" id="blankTypeId">
                    <option value="" selected>Тип бланка</option>
                    <?php foreach ($blank_types as $blank_type) : ?>
                        <option value="<?php echo $blank_type['id']; ?>"><?php echo $blank_type['text']; ?></option>
                    <?php endforeach; ?>
                </select>
                <select name="company_id" id="CompanyId" class="select-position">
                    <option value="" selected>Назва компанії</option>
                    <?php foreach ($companies as $company) : ?>
                        <option value="<?php echo $company['id']; ?>"><?php echo $company['title']; ?></option>
                    <?php endforeach; ?>
                </select>

                <input class="inpt-1" type="text" name="form_blanks_series" id="blanksSeries" placeholder="Серія бланка"
                       required>
                <input class="inpt-2" type="number" name="form_blanks_number_start" id="blanksNumberStart"
                       placeholder="Нумерація бланка від" required>
                <input class="inpt-2" type="number" name="form_blanks_number_end" id="blanksNumberEnd"
                       placeholder="Нумерація бланка до" required>
                <input class="inpt-2" type="text" name="form_blanks_comments" id="blanksComments"
                       placeholder="Коментар">


                <input type="submit" id="sbmtAddNumberOfBlanks" value="Зберегти"
                       class="button button-primary button-large">

            </div><!--number-of-blanks-form-wrapper end here-->
        </form>
        <hr/>
        <h2>Пошук по закріпленим бланкам</h2>
        <form action="" method="POST" id="manager_search">
            <div style="display: inline-block; vertical-align:top">
                <label>Назва компанії</label> <br/>
                <select name="company_id">
                    <option value="" selected>Назва компанії</option>
                    <?php if (!empty($companies) && is_array($companies)): ?>
                        <?php foreach ($companies as $company) : ?>
                            <option value="<?php echo $company['id']; ?>"><?php echo $company['title']; ?></option>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </select>
            </div>
            <div style="display: inline-block; vertical-align:top">
                <label>Серія бланка</label> <br/>
                <select name="blank_series" class="inpt-2insuranceadmingetmanagerofblank">
                    <option value="" selected>Серія бланка</option>
                    <?php if (!empty($blank_series) && is_array($blank_series)): ?>
                        <?php foreach ($blank_series as $blank_serie) : ?>
                            <option value="<?php echo $blank_serie["blank_series"]; ?>"><?php echo $blank_serie["blank_series"]; ?></option>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </select>
            </div>
            <div style="display: inline-block; vertical-align:top">
                <label>Номер бланку</label> <br/>
                <input type="text" name="blank_number" class="inpt-2">
            </div>

            <div style="display: inline-block; vertical-align:top">
                <label>&nbsp;</label> <br/>
                <input type="submit" value="Знайти менеджера" class="btn-m-l button button-primary button-large"
                       id="get_manager_id">
            </div>

            <div style="display: inline-block; vertical-align:top">
                <label>&nbsp;</label> <br/>
                <span class="manager_name_span" style="padding: 20px; line-height: 30px;"></span>
            </div>
        </form>
        <hr/>


        <span class="message js-message"></span>

        <?php if ($blank_list) : ?>
            <div class="number-of-blanks-list js-number-of-blanks-list"><?php echo $blank_list; ?></div>
        <?php endif; ?>

    <?php else : ?>
        На даний момент не додано жодної компанії, перейдіть в розділ <a
                href="/wp-admin/admin.php?page=insurance-company">Компанії</a> щоб додати її.
    <?php endif; ?>

</div><!--wrap end here-->

