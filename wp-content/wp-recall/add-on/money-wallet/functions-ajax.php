<?php

rcl_ajax_action( 'mw_user_transfer', false );
function mw_user_transfer() {
	global $wpdb, $user_ID;

	$id_user	 = intval( $_POST['user_id'] );
	$add_count	 = round( str_replace( ',', '.', absint( $_POST['transfer_amount'] ) ), 2 );

	if ( ! $add_count || $user_ID == $id_user )
		return false;

	$user = get_user_by( 'id', $id_user );

	if ( ! $user )
		return false;

	$oldusercount	 = rcl_get_user_balance( $user_ID );
	$newusercount	 = $oldusercount - $add_count;
	if ( $newusercount < 0 ) {
		wp_send_json( array( 'error' => __( 'Insufficient funds on personal account!', 'rcl-wallet' ) ) );
	}

	rcl_update_user_balance( $newusercount, $user_ID, __( 'The transfer of funds to the user', 'rcl-wallet' ) . ' ' . get_the_author_meta( 'display_name', $id_user ) );

	$display_name = get_the_author_meta( 'display_name', $user_ID );

	$user_addcount = rcl_get_user_balance( $id_user );

	$new_addcount = $user_addcount + $add_count;
	rcl_update_user_balance( $new_addcount, $id_user, __( 'The funds coming from the user', 'rcl-wallet' ) . ' ' . $display_name );

	$subject	 = __( 'Money transfer', 'rcl-wallet' );
	$email		 = get_the_author_meta( 'user_email', $id_user );
	$textmail	 = '<p>' . sprintf( __( 'Into your personal account with the website "%s" was transferred from another user', 'rcl-wallet' ), get_bloginfo( 'name' ) ) . '!</p>
            <p>' . sprintf( __( 'The user %s has transferred to your personal account %s', 'rcl-wallet' ), '<a href="' . get_author_posts_url( $user_ID ) . '">' . $display_name . '</a>', $add_count . ' ' . rcl_get_primary_currency( 1 ) ) . '</p>';
	rcl_mail( $email, $subject, $textmail );

	$log['count']	 = $newusercount;
	$log['success']	 = __( 'The funds were successfully transferred to the account of that user', 'rcl-wallet' );

	wp_send_json( array(
		'success'	 => __( 'The funds were successfully transferred to the account of that user', 'rcl-wallet' ),
		'count'		 => $newusercount,
		'dialog'	 => array(
			'close' => true
		)
	) );
}

rcl_ajax_action( 'mw_load_user_transfer_form', false );
function mw_load_user_transfer_form() {

	$form = rcl_get_form( array(
		'onclick'	 => 'rcl_send_form_data("mw_user_transfer", this);return false;',
		'submit'	 => __( 'Передать' ),
		'fields'	 => array(
			array(
				'type'			 => 'number',
				'slug'			 => 'transfer_amount',
				'required'		 => 1,
				'value_min'		 => 1,
				'placeholder'	 => 0,
				'title'			 => __( 'Сумма перевода' )
			),
			array(
				'type'	 => 'hidden',
				'slug'	 => 'user_id',
				'value'	 => $_POST['user_id']
			)
		)
		) );

	wp_send_json( array(
		'dialog' => array(
			'title'		 => __( 'Перевод другому пользователю' ),
			'content'	 => $form
		)
	) );
}

rcl_ajax_action( 'mw_new_output_request', false );
function mw_new_output_request() {
	global $wpdb, $user_ID, $rcl_options;


	$count	 = round( str_replace( ',', '.', $_POST['output_size'] ), 2 );
	$type	 = $_POST['pay_system'];
	$wallet	 = $_POST['wallet_system'];

	if ( mw_get_user_request( $user_ID ) ) {
		wp_send_json( array(
			'error' => __( 'Уже есть один действующий запрос на вывод средств!' )
		) );
	};

	$balance = rcl_get_user_balance( $user_ID );

	$newusercount = $balance - $count;

	if ( $newusercount < 0 ) {
		wp_send_json( array(
			'error' => __( 'Insufficient funds on personal account!', 'rcl-wallet' ) )
		);
	}

	$min = rcl_get_option( 'mw_min', 0 );

	if ( $min && $min > $count ) {
		$log['error'] = __( 'Ошибка! Минимальная сумма запроса: ' . $min . ' ' . rcl_get_primary_currency( 1 ), 'wp-recall' );
		wp_send_json( $log );
	}

	rcl_update_user_balance( $newusercount, $user_ID, __( 'Lock means on request', 'rcl-wallet' ) );

	mw_add_request( array(
		'user_rq'	 => $user_ID,
		'count_rq'	 => $count,
		'comment_rq' => $type . ' ' . str_replace( array( ' ', '-' ), '', $wallet ),
	) );

	$perc = rcl_get_option( 'percent_output_request', 0 );

	setcookie( 'rcl_wallet', json_encode( array( 'type' => $type, 'wallet' => $wallet ) ), time() + 31104000, '/' );

	if ( $perc ) {
		$output = $count - round( ($count * $perc / 100 ), 2 );
	} else {
		$output	 = $count;
		$perc	 = 0;
	}

	$subject	 = __( 'Request the withdrawal', 'rcl-wallet' );
	$textmail	 = '
    <h3>' . __( 'Request data', 'rcl-wallet' ) . ':</h3>
    <p>' . __( 'The amount of the request', 'rcl-wallet' ) . ': ' . $count . '</p>
    <p>' . __( 'Account number', 'rcl-wallet' ) . ': ' . $type . ' ' . $wallet . '</p>';
	$admin_email = get_option( 'admin_email' );
	rcl_mail( $admin_email, $subject, $textmail );

	wp_send_json( array(
		'success'	 => __( 'Запрос успешно добавлен' ),
		'reload'	 => true
	) );
}

rcl_ajax_action( 'mw_cancel_request', false );
function mw_cancel_request() {
	global $user_ID;

	$request_id = intval( $_POST['request_id'] );

	$request = mw_get_request( $request_id );

	if ( ! $request || $request->user_rq != $user_ID ) {

		wp_send_json( array(
			'error' => __( 'Не удалось выполнить запрос' )
		) );
	}

	$delete = mw_delete_request( $request_id );

	if ( ! $delete ) {
		wp_send_json( array(
			'error' => __( 'Не удалось выполнить запрос' )
		) );
	}

	$balance		 = rcl_get_user_balance( $user_ID );
	$newusercount	 = $balance + $request->count_rq;

	rcl_update_user_balance( $newusercount, $user_ID, __( 'Refund with lock on request', 'rcl-wallet' ) );

	$subject	 = __( 'The withdrawal request was cancelled', 'rcl-wallet' );
	$textmail	 = '
    <p>' . __( 'Your request for withdrawal has been rejected', 'rcl-wallet' ) . '.</p>
    <h3>' . __( 'Information about the transfer', 'rcl-wallet' ) . ':</h3>
    <p>' . __( 'The amount of the transfer', 'rcl-wallet' ) . ': ' . $request->count_rq . '</p>
    <p>' . __( 'Account number', 'rcl-wallet' ) . ': ' . $request->comment_rq . '</p>'
		. '<p>' . __( 'The blocked funds were returned to your personal account', 'rcl-wallet' ) . '</p>';
	$admin_email = get_the_author_meta( 'user_email', $user_ID );
	rcl_mail( $admin_email, $subject, $textmail );

	wp_send_json( array(
		'success'	 => __( 'Запрос успешно отменен' ),
		'reload'	 => true
	) );
}
