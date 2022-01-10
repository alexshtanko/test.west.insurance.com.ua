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

<?php

$message = array();
$message['txt_title'] = 'Тарифи iмпорт'; 
$message['txt_rate_import'] = 'Iмпортувати тарифи'

?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <h1><?php echo $message['txt_title'];?></h1>

            <hr>
        </div>

        <div class="row">
            <div class="col-12">
            <div class="tablenav top">
                <?php if( ! empty( $blanks ) or ! empty( $companies ) ) :?>
                    
                        
                        
                        
                    <form id="formRateImport" action="<?= admin_url('admin-post.php'); ?>" method="POST" name="add_blank" enctype="multipart/form-data">
                            <input type="hidden" name="action" value="insurance_admin_rate_import" />
                            <?php wp_nonce_field( 'form_rate_file_upload', 'fileup_nonce' ); ?>
                            <input type="hidden" name="redirect" value="/wp-admin/admin.php?page=insurance-rate-import" />
                        <div class="row">
                            <table>
                                <?php if( ! empty( $companies ) ) :?>

                                    <tr>
                                        <td><label for="rateCompany">Оберiть компанію</label></td>
                                        <td>
                                            <select name="rate_company" id="rateCompany">
                                                <option value=""></option>
                                                <?php foreach( $companies as $company ) : ?>
                                                    <option value="<?php echo $company['id'] ?>"><?php echo $company['title']; ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </td>
                                    </tr>
                                
                                <?php else: ?>
                                    Компанії ще не доданi, додайте їх перед тим як iмпортувати даннi.
                                <?php endif; ?>

                                <?php if( ! empty( $blanks ) ) :?>
                                    <tr>
                                        <td><label for="rateBlank">Оберiть програму</label></td>
                                        <td>
                                            <select name="rate_blank" id="rateBlank">
                                                <option value=""></option>
                                                <?php foreach( $blanks as $blank ) : ?>
                                                    <option value="<?php echo $blank['id'] ?>"><?php echo $blank['title']; ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </td>
                                    </tr>
                                <?php else: ?>
                                    Бланки ще не доданi, додайте їх перед тим як iмпортувати даннi.
                                <?php endif; ?>
                                
                                <?php if( !empty( $all_balnk_type ) ) : ?>

                                    <tr>
                                        <td><label for="rateBlank">Оберiть тип бланка</label></td>
                                        <td>

                                        <select name="blank_type" id="blank_type">
                                            <option value=""></option>
                                            <?php foreach ( $all_balnk_type as $blank_type ) : ?>

                                                <option value="<?php echo $blank_type['id'] ?>"><?php echo $blank_type['text']; ?></option>

                                            <?php endforeach; ?>
                                        </select>
                                        </td>
                                    </tr>
                                <?php else : ?>
                                    Типи бланків ще не додані, додайте їх перед тим як iмпортувати даннi.
                                <?php endif; ?>

                                <?php if( ! empty( $blanks ) && ! empty( $companies ) ) :?>
                                    <tr>
                                        <td><label for="rateCompany">Файл для завантаження:</label></td>
                                        <td><input class="regular-text" id="rateImportFile" name="rate_import_file" multiple type="file"></td>
                                    </tr>

                                    <tr>
                                        <td></td>
                                        <td><input type="submit" value="<?php echo $message['txt_rate_import'];?>" class="button button-primary button-large" id="rateImport"></td>
                                    </tr>
                                    
                                        <small id="rateImportMessage" class="form-text text-muted text-success"></small>
                                    
                                <?php endif; ?>
                            </table>
                        </div>
                    </form>
                <?php else: ?>
                    Бланки та Компанії ще не доданi, додайте їх перед тим як iмпортувати даннi.
                <?php endif; ?>
            </div>
            </div>
        </div>
    </div>

</div>