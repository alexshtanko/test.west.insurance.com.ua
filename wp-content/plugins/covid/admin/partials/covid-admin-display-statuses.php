<div class="wrap">
    <h1><?php echo get_admin_page_title(); ?></h1>
	<?php
	if(array_key_exists("getStatusId", $_GET)) {
		echo '<p><a href="' . admin_url( 'admin.php?page=covid-statuses' ) . '" class="button button-primary button-large">
                                                <i class="fa fa-reply"></i> Повернутися до списку статусів замовлень</a></p>';
	}
	?>


<?php
if(strlen($noticeText) > 0) {
	echo '<div id="message" class="notice ' . $noticeStyle . ' is-dismissible"><p>' . $noticeText . '</p><button type="button" class="notice-dismiss"><span class="screen-reader-text">Закрити це повідомлення.</span></button></div>';
}

$inputStatusText = $statusComment  = '';
$statusAdminReport = $statusManagerReport = $statusFreeBlank = 1;

if(!array_key_exists("getStatusId", $_GET)) {
	echo $statuses;
	echo "<br /><hr>
    <h2>Додати новий статус</h2>";
}
else {
    echo "<h2>Редагувати статус</h2>";
	$editRow = $statusArray[0];
	$statusId = $editRow['id'];
	$statusText = $editRow['text'];
	$statusComment= $editRow['comment'];
	$statusAdminReport = $editRow['adminReport'];
	$statusManagerReport = $editRow['managerReport'];
	$statusFreeBlank = $editRow['freeBlank'];

	$inputStatusText = " value='".$statusText."'";
	$inputStatusComment = " value='".$statusComment."'";
}

?>
    <form action="" method="POST" id="formStatuses">
        <table class='form-table'><tbody>
           <tr>
                <th scope="row"><label for="statusText">Текст статусу</label></th>
                <td>
                    <input class="inpt-2" type="text" name="form_status_text" id="statusText" required="" <?php echo $inputStatusText; ?>>
                </td>
           </tr>
           <tr>
               <th scope="row"><label for="statusComment">Коментар</label></th>
               <td>
                   <input class="inpt-2" type="text" name="form_status_comment" id="statusComment" <?php echo $inputStatusComment; ?>>
               </td>
           </tr>

           <tr>
               <th scope="row"><label for="statusAdminReport">Показувати в звітах для адміна</label></th>
               <td>
                   <select name="form_status_admin_report" id="statusAdminReport" class="select-position" required>
                       <?php if($statusAdminReport == 1) { ?>
                           <option value="1" selected>Так</option>
                           <option value="0">Ні</option>
                       <?php
                            }
                            else {
                                ?>
                                <option value="1">Так</option>
                                <option value="0" selected>Ні</option>
                                <?php
                            }
                       ?>
                   </select>
               </td>
           </tr>
           <tr>
               <th scope="row"><label for="statusManagerReport">Показувати в звітах для менеджера</label></th>
               <td>
                   <select name="form_status_manager_report" id="statusManagerReport" class="select-position" required>
	                   <?php if($statusManagerReport == 1) { ?>
                           <option value="1" selected>Так</option>
                           <option value="0">Ні</option>
		                   <?php
	                   }
	                   else {
		                   ?>
                           <option value="1">Так</option>
                           <option value="0" selected>Ні</option>
		                   <?php
	                   }
	                   ?>
                   </select>
               </td>
           </tr>
           <tr>
               <th scope="row"><label for="statusFreeBlank">Звільняти номер бланку</label></th>
               <td>
                   <select name="form_status_free_blank" id="statusFreeBlank" class="select-position" required>
			           <?php if($statusFreeBlank == 1) { ?>
                           <option value="1" selected>Так</option>
                           <option value="0">Ні</option>
				           <?php
			           }
			           else {
				           ?>
                           <option value="1">Так</option>
                           <option value="0" selected>Ні</option>
				           <?php
			           }
			           ?>
                   </select>
               </td>
           </tr>
        </tbody></table>
        <p>
            <?php if(!array_key_exists("getStatusId", $_GET)) { ?>
            <input class="inpt-2" type="hidden" name="add_status" id="add_status" value="true">
            <?php }
                else {
                    ?>
                    <input class="inpt-2" type="hidden" name="edit_status" id="edit_status" value="true">
                    <input class="inpt-2" type="hidden" name="status_id" id="status_id" value="<?php echo $statusId; ?>">
                    <?php
                }
            ?>
            <input type="submit" id="sbmtAddBlankToManager" value="Зберегти" class="button button-primary button-large">
        </p>
    </form>




<?php
if(count($statusesArray) > 0){
    $statusTextJS = '';
    foreach($statusesArray as $value) {
	    $statusTextJS .= "'".$value['text']."',";
    }
}
?>

<script>
    var statuses = [<?php echo substr($statusTextJS, 0, -1);  ?>];
    <?php if(array_key_exists("getStatusId", $_GET)) { ?>
        var disableCheckName = true;
    <?php }
    else {?>
        var disableCheckName = false;
    <?php } ?>
</script>
</div>
