<div class="wrap">
    <h1><?php echo get_admin_page_title(); if(isset($currentUser)) echo " (".$currentUser->display_name.")"?></h1>
        <?php
            if(array_key_exists("managerid", $_GET)) {
                echo '<p><a href="' . admin_url( 'admin.php?page=covid-blank-to-manager' ) . '" class="button button-primary button-large">
                                                <i class="fa fa-reply"></i> Повернутися до списку менеджерів</a></p>';
            }
        ?>


<?php
if(strlen($noticeText) > 0) {
    echo '<div id="message" class="notice ' . $noticeStyle . ' is-dismissible"><p>' . $noticeText . '</p><button type="button" class="notice-dismiss"><span class="screen-reader-text">Закрити це повідомлення.</span></button></div>';
}

if(array_key_exists("managerid", $_GET)){
	?>
    <h2>Додати нумерацію</h2>
    <form action="" method="POST" id="formBlankToManager">
        <div class="number-of-blanks-form-wrapper tablenav top">
            <select name="company_id" id="CompanyId" class="select-position" required>
                <option value="" selected="" disabled>Назва компанії</option>
	            <?php
	            foreach($companies as $company){
		            echo '<option value="'.$company['id'].'">'.$company['title'].'</option>';
	            }
	            ?>
            </select>

            <select name="form_blanks_series" id="blanksSeries" class="select-position" disabled required>
                <option value="" selected="" disabled>Серія бланка</option>
		        <?php
		        foreach($blank_series as $blank){
			        echo '<option value="'.$blank['blank_series'].'" data-company-id="'.$blank['company_id'].'">'.$blank['blank_series'].'</option>';
		        }
		        ?>
            </select>

            <input class="inpt-2" type="number" name="form_blanks_number_start" id="blanksNumberStart" placeholder="Нумерація бланка від" required="">
            <input class="inpt-2" type="number" name="form_blanks_number_end" id="blanksNumberEnd" placeholder="Нумерація бланка до" required="">
            <input class="inpt-2" type="text" name="form_blanks_comments" id="blanksComments" placeholder="Коментар">
            <input class="inpt-2" type="hidden" name="add_blank_number_to_manager" id="add_blank_number_to_manager" value="true">
            <input type="submit" id="sbmtAddBlankToManager" value="Зберегти" class="button button-primary button-large">
        </div>
    </form>
    <hr>


    <?php

	if(count($managerRows) > 0) {
		echo "<h2>Закріплені нумерації</h2><table>" . $renderTableRows . "</table>";
	}
	else {
	    echo "<h2>Закріплених нумерацій бланків за даним менеджером не знайдено.</h2>";
    }
}
else {

	?>
    <hr/>
    <h4>Звіт по вільним бланкам</h4>
    <form action="" method="POST">
        <div style="display: inline-block; vertical-align:top">
            <label>Дата з</label> <br/>
            <input type="date" name="dateFrom">
        </div>
        <div style="display: inline-block; vertical-align:top">
            <label>Дата до</label> <br/>
            <input type="date" name="dateTo">
        </div>
        <div style="display: inline-block; vertical-align:top">
            <label>Менеджер</label> <br/>
            <select name="managerId" id="orderManagerId">
                <option value="" selected>Менеджер</option>
				<?php foreach ($managers as $id => $manager) : ?>
                    <option value="<?= $id; ?>"><?= $manager; ?></option>
				<?php endforeach; ?>
            </select>
        </div>
        <div style="display: inline-block; vertical-align:top">
            <label>Назва компанії</label> <br/>
            <select name="companyId" id="orderCompanyId">
                <option value="" selected>Назва компанії</option>
				<?php if (!empty($companies) && is_array($companies)): ?>
					<?php foreach ($companies as $company) : ?>
                        <option value="<?php echo $company['id']; ?>"><?php echo $company['title']; ?></option>
					<?php endforeach; ?>
				<?php endif; ?>
            </select>
        </div>
        <div style="display: inline-block; vertical-align:top">
            <label>&nbsp;</label> <br/>
            <input type="hidden" name="filter" value="download_xlsx"/>
            <input type="submit" value="Сформувати звіт" class="btn-m-l button button-primary button-large">
        </div>
    </form>
    <br/>
	<?

	if(isset($managers) && is_array($managers) && count($managers) > 0){
		?>
	<table class="wp-list-table widefat fixed striped posts">
		<thead>
			<tr>
				<th class="manage-column table-50">№</th>
				<th class="manage-column">Менеджер</th>
				<th class="manage-column table-100 text-center">Управлiння</th>
			</tr>
		</thead>
		<tbody>
		<?php
			$counter = 1;
			foreach($managers as $key => $value){
				echo '<tr>
						<td>'.$counter.'</td>
						<td><a href="'.admin_url('admin.php?page=covid-blank-to-manager&managerid='.$key).'">'.$value.'</a></td>
						<td class="text-center manage-column">
						<a href="'.admin_url('admin.php?page=covid-blank-to-manager&managerid='.$key).'" class="button button-primary button-large js-remove-btn"><i class="fa fa-edit"></i></a>
						</td>';
				$counter++;
			}
		?>
		</tbody></table>
		<?php
	}
}
?>
</div>
