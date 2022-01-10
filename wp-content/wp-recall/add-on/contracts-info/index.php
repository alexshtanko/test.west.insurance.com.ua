<?php
add_action('init','add_tab_contracts_info');
function add_tab_contracts_info(){
    
    $tab_data =	array(
        'id'=>'contractsInfo',
        'name'=>'Договори страхування',
        'public'=>0,//делаем вкладку приватной
        'icon'=>'fa-files-o',//указываем иконку
        'output'=>'menu',//указываем область вывода
        'content'=>array(
            array( //массив данных первой дочерней вкладки
                'callback' => array(
                    'name'=>'contracts_info_recall_block',//функция формирующая контент
                )
            )
        )
    );
 
    rcl_tab($tab_data);
 
}
 
function contracts_info_recall_block($user){
	add_thickbox();
	global $user_ID;
	global $wpdb;
	$content = '';
	$table_name = $wpdb->prefix . "ewa";
	$orders = $wpdb->get_results("SELECT * FROM ".$table_name." WHERE `wp-user` = ".$user_ID." and `contract-id` != '' ORDER BY id DESC", ARRAY_A);

	if(count($orders) >= 1) {
		$content .= "<table class='wp-list-table widefat fixed striped posts'>";
		$content .= "<thead>
                <th scope='col' class='manage-column' style='width:35px;'>ID</th>
				<th scope='col' class='manage-column'>Прізвище ім'я</th>
				<th scope='col' class='manage-column'>Телефон</th>
				<th scope='col' class='manage-column' style='width:80px;'>Номер авто</th>
				<th scope='col' class='manage-column' style='width:60px;'>Ціна</th>
				<th scope='col' class='manage-column'>Компанія</th>
				<th scope='col' class='manage-column' style='width:110px;'>Дата запису</th>
				<th scope='col' class='manage-column'>Інформація</th>
			  </thead>";

		$content .= "<tbody id='contractsInfo'>";

		foreach($orders as $order){
			$osagos = json_decode($order['osago-franchises'], true);
			$selectedOsagoPrice = $osagos[$order['osago-selected-franchise']];
			if(!$selectedOsagoPrice){
				$selectedOsagoPrice = $order["osago-franhise".$order['osago-selected-franchise']];
			}

			$dateAdded = strtotime( $order['date-added'] );
			$dateTimeAdded = date( 'd.m.Y', $dateAdded );

			$phone = preg_replace('~[^+0-9]+~','', $order['user-phone']);

			$content .= "<tr>
					<td>".$order['id']."</td>
					<td>".$order['user-surname']." ".$order['user-name']."</td>
					<td><a href='tel:".$phone."'>".$phone."</a></td>
					<td>".$order['car-number']."</td>
					<td>".$selectedOsagoPrice."</td>
					<td>".$order['osago-name']."</td>
					<td>".$dateTimeAdded."</td>
					<td>
						<button type='submit' class='button button-primary button-large more-data' data-order-id='".$order['id']."' data-order-unique-code='".$order['unique-code']."'><i class='fa fa-eye'></i></button>	
					</td>
				  </tr>";

			unset($details, $selectedOsagoPrice, $osagos);
		}
		$content .= "</tbody></table>";


	$content .= "<div id='my-modal-id' style='display:none;'><div></div></div><a name='Данi про користувача' style='display: none;' href='/?TB_inline&width=600&height=550&inlineId=my-modal-id' class='thickbox show-modal-data'>Открыть модальное окно</a>";
	$content .= '</div>';

	$content .= "<script>jQuery(document).ready(function(){
            jQuery('.more-data').on('click', function(e) {
                e.preventDefault();
                var orderId = jQuery(this).attr('data-order-id');
                var orderCode = jQuery(this).attr('data-order-unique-code');

                var AjaxUrlInnInfo = location.protocol + \"//\" + window.location.hostname + \"/plc/order_info.php\";
                jQuery.ajax(AjaxUrlInnInfo, {
                    type: \"POST\",
                    data: \"orderId=\" + orderId + \"&orderCode=\" + orderCode,
                    timeout: 91000000,
                    success: function (data, textStatus, jqXHR) {
                        var request = JSON.parse(data);
                        console.log(request);
                        if(request.status == \"OK\") {
                            //jQuery('#my-modal-id div').html(jQuery(this).parent().find('textarea[name=\'more\']').val());
                            jQuery('#my-modal-id div').html(request.data);
                            jQuery('a.show-modal-data').click();
                        }
                        else {
                            alert(\"Ошибка, данные о записи не найдены!\");
                        }
                    }
                });
            });
        });</script>";

	$content .= "<style>#TB_ajaxContent { padding: 0px!important;} #TB_window { width: 600px!important;} button#TB_closeWindowButton:active, button#TB_closeWindowButton:focus, .tb-close-icon { outline: none!important;}</style>";
    $content .= "<style>#contractsInfo tr td {vertical-align: middle!important;} #contractsInfo tr td button {padding: 0px 5px!important; margin-bottom: 0px;}</style>";

	}
	else {
		$content .= '<p>Ви не заключили жодного контракту</p>';
    }

	return $content;
}
?>