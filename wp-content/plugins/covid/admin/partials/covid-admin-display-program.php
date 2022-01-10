<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       alexshtanko.com.ua
 * @since      1.0.0
 *
 * @package    Covdi
 * @subpackage Covid/admin/partials
 */
?>
<?php 

$message = array();
$message['txt_title'] = 'Програми'; 
$message['txt_all_program'] = 'Всi програми';
$message['txt_add_new_program'] = 'Додати нову програму';
$message['txt_add_program'] = 'Додати програму';

$message['txt_n'] = '№';
$message['txt_id'] = 'ID';
$message['txt_company_title'] = 'Назва компанії';
$message['txt_control'] = 'Управлiння';

$message['txt_enter_program_title'] = 'Введіть назву програми';
$message['txt_enter_program_comments'] = 'Введіть коментар до програми';


?>
<!-- This file should primarily consist of HTML with a little bit of PHP. -->

<div class="wrap">
    <div class="row">
        <div class="col-12">
            <h1><?php echo $message['txt_title'];?></h1>

            <hr>
        </div>
    </div>

    <h2><?php echo $message['txt_add_new_program'];?></h2>
    <div class="covid-form-wrapper">
        <form action="" method="POST" name="add_program">
            <div class="form-group alignleft actions margin-right-10">
                <!-- <label for="programName"><?php echo $message['txt_company_title'];?></label> -->
                <input class="regular-text" id="programName" name="program_name" type="text" placeholder="<?php echo $message['txt_enter_program_title'];?>">
                <input class="regular-text" id="programComments" name="program_comments" type="text" placeholder="<?php echo $message['txt_enter_program_comments'];?>">
            
            </div>
            <div class="alignleft actions">
                <button class="button button-primary button-large btn-position" id="addProgram"><?php echo $message['txt_add_program'];?></button>
            </div>
            
        </form>

        <div class="clear"></div>
        <small id="programMessage" class="form-text text-muted text-success"></small>
    </div>


    <?php 
        //Вывод всех существующих бланков
    ?>
    <div class="program-list-wrapper">
        <div id="covidProgramList">Завантаження...</div>
    </div><!--program-list-wrapper end here-->
       
    
    
</div><!--wrap end here-->

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


