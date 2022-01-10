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
<?php 

$message = array();
$message['txt_title'] = 'Компанії'; 
$message['txt_all_company'] = 'Всi Компанії';
$message['txt_add_new_company'] = 'Додати нову Компанію';
$message['txt_add_company'] = 'Додати Компанію';

$message['txt_n'] = '№';
$message['txt_id'] = 'ID';
$message['txt_company_title'] = 'Назва Компанії';
$message['txt_control'] = 'Управлiння';

$message['txt_enter_company_title'] = 'Введіть назву компанії';


?>
<!-- This file should primarily consist of HTML with a little bit of PHP. -->

<div class="wrap">
    <div class="row">
        <div class="col-12">
            <h1><?php echo $message['txt_title'];?></h1>

            <hr>
        </div>
    </div>

    <h2><?php echo $message['txt_add_new_company'];?></h2>

    <div class="covid-form-wrapper">
        <form method="POST" name="add_company">
            <div class="upload-logo-img-wrapper js-upload-logo-img-wrapper"></div>
            <button class="upload-btn form-company-logo js-upload-image">Завантажити логотип компанії</button>
            <input type="text" class="js-upload-image-input" hidden>
            <div class="form-group alignleft actions">
                <!-- <label for="companyName"><?php echo $message['txt_company_title'];?></label> -->
                <input class="regular-text" id="companyName" name="company_name" type="text" placeholder="<?php echo $message['txt_enter_company_title'];?>">
            </div>
            <div class="alignleft actions">
                <button class="button button-primary button-large" id="addCompany"><?php echo $message['txt_add_company'];?></button>
            </div>
            <small id="companyMessage" class="form-text text-muted text-success"></small>
        </form>
        
        <div class="clear"></div>
    </div>


    <?php 
        //Вывод всех существующих бланков
    ?>
    <div class="company-list-wrapper">
        
        <div id="covidCompanyList">Завантаження...</div>
    </div><!--blank-list-wrapper end here-->

    <div class="message-area js-message-area"></div>
    
        
</div><!--wrap end here-->


<?php 
//Modal
?>
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


