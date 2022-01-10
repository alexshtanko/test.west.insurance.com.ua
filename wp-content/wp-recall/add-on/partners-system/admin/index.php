<?php

add_action( 'admin_head', 'ps_admin_scripts' );
function ps_admin_scripts() {
	wp_enqueue_script( 'jquery' );
	wp_enqueue_script( 'ps-scripts', rcl_addon_url( 'admin/assets/scripts.js', __FILE__ ) );
	wp_enqueue_style( 'ps-style', rcl_addon_url( 'admin/assets/style.css', __FILE__ ) );
}

add_action( 'admin_menu', 'add_menu_ps' );
function add_menu_ps() {
	add_menu_page( 'Partners', 'Partners', 'manage_options', 'partners-system', 'options_ps' );
	add_submenu_page( 'partners-system', __( 'Settings', 'partners-system' ), __( 'Settings', 'partners-system' ), 'manage_options', 'partners-system', 'options_ps' );
	add_submenu_page( 'partners-system', __( 'Partners and Referrals', 'partners-system' ), __( 'Partners and Referrals', 'partners-system' ), 'manage_options', 'partners-list', 'admin_partners_list' );
	add_submenu_page( 'partners-system', __( 'Promotion', 'partners-system' ), __( 'Promotion', 'partners-system' ), 'manage_options', 'incentives-list', 'admin_incentives_list' );
}

function options_ps() {
	global $ps_options;
	//$ps_options = $rcl_options['partners'];

	require_once RCL_PATH . 'classes/class-rcl-options.php';
	$opt = new Rcl_Options( __FILE__ );

	$content						 = '<div class="wrap">';
	$content .= reg_form_wpp( 'prtsys' );
	$content .= ' <h2>' . __( 'Settings', 'partners-system' ) . ' Partners System</h2>
                    <div class="wrap">
	<form method="post" action="">
        <input type="hidden" name="update-partners-options" value="1" />
        ' . wp_nonce_field( 'update-options-ps', '_wpnonce', true, false );
	$key							 = rcl_key_addon( pathinfo( __FILE__ ) );
	if ( ! isset( $ps_options['partners_level'] ) )
		$ps_options['partners_level']	 = 2;
	//print_r($ps_options);
	$content .= '
	<div id="options-' . $key . '" class="wrap-recall-options" style="display:block;">
		<div class="option-block">
                    <label>' . __( 'View affiliate links', 'partners-system' ) . '</label>';

	$rp = (isset( $ps_options['ref_page'] )) ? $ps_options['ref_page'] : false;

	$args = array(
		'selected'			 => $rp,
		'name'				 => 'ref_page',
		'show_option_none'	 => __( 'Home page', 'partners-system' ),
		'echo'				 => 0
	);
	$content .= wp_dropdown_pages( $args );

	$gd = (isset( $ps_options['get_data'] )) ? $ps_options['get_data'] : false;

	$content .= '/?<input style="width:50px;" type="text" name="get_name" value="' . $ps_options['get_name'] . '">=
                    <select style="width:110px;" name="get_data">
                    <option value="">partner_ID</option>'
		. '<option value="1" ' . selected( 1, $gd, false ) . '>partner_login</option>
                    </select>
                    <small>' . __( 'The current reference', 'partners-system' ) . ': ' . get_ref_url() . '</small>
                    <label>' . __( 'The appointment of the partner when registering', 'partners-system' ) . '</label>
                    <small>' . __( 'If registration took place without the affiliate link', 'partners-system' ) . '</small>
                    <input type="number" name="default_partner" value="' . (isset( $ps_options['default_partner'] ) ? $ps_options['default_partner'] : '') . '">
                    <input type="hidden" name="default_partner_on" value="0">
                    <input type="checkbox" name="default_partner_on" ' . checked( 1, (isset( $ps_options['default_partner_on'] ) ? $ps_options['default_partner_on'] : false ), false ) . ' value="1"> ' . __( 'Included', 'partners-system' ) . '

                    <small>' . __( 'Specify the ID of the partner to which you will attach a new referral.', 'partners-system' ) . '<br>'
		. __( 'If empty, the partner is randomly assigned.', 'partners-system' ) . '</small>

                    <label>' . __( 'Reassign referrals when a user is deleted', 'partners-system' ) . '</label>
                    <input type="hidden" name="transfer_referals" value="0">
                    <input type="checkbox" name="transfer_referals" ' . checked( 1, (isset( $ps_options['transfer_referals'] ) ? $ps_options['transfer_referals'] : false ), false ) . ' value="1"> ' . __( 'Included', 'partners-system' ) . '<br>
                    <small>' . __( 'If enabled, the referrals of the user to remove attached to the partner whose referral it is', 'partners-system' ) . '</small>

                    <label>' . __( 'The link to the partner profile', 'partners-system' ) . '</label>
                    <input type="hidden" name="link_partner" value="0">
                    <input type="checkbox" name="link_partner" ' . checked( 1, (isset( $ps_options['link_partner'] ) ? $ps_options['link_partner'] : false ), false ) . ' value="1"> ' . __( 'Included', 'partners-system' ) . '<br>
                    <small>' . __( 'If enabled, the referral system also displays link to the profile of the inviting partner', 'partners-system' ) . '</small>

                    <label>' . __( 'Ограничение кол-ва рефералов' ) . '</label>
                    <input type="number" name="refers_amount" value="' . (isset( $ps_options['refers_amount'] ) ? $ps_options['refers_amount'] : false) . '"><br>
                    <small>' . __( 'Опция ограничивает количество прямых рефералов для партнера, если пусто, то без ограничений' ) . '</small>

                    <label>' . __( 'Промокоды' ) . '</label>
                    <input type="checkbox" name="promocode" ' . checked( 1, (isset( $ps_options['promocode'] ) ? $ps_options['promocode'] : false ), false ) . ' value="1"> ' . __( 'Included', 'partners-system' ) . '<br>
                    <small>' . __( 'Включаем выдачу промокодов партнерам и возможность регистрации реферала с указанием промокода пригласившего партнера' ) . '</small>

                    <label>' . __( 'Возврат на баланс от первого заказа' ) . '</label>
                    <input type="number" name="return_amount" value="' . (isset( $ps_options['return_amount'] ) ? $ps_options['return_amount'] : false) . '">%<br>
                    <small>' . __( 'Возвращать на внутренний баланс пользователя указанный процент от первого заказа' ) . '</small>

                    <label>' . __( 'The number of levels affiliate program', 'partners-system' ) . '</label>
                    <select id="levels-select" name="partners_level">';
	for ( $a = 1; $a <= 50; $a ++  ) {
		$content .= '<option value="' . $a . '" ' . selected( $a, (isset( $ps_options['partners_level'] ) ? $ps_options['partners_level'] : false ), false ) . '>' . $a . '</option>';
	}
	$content .= '</select>';
	$content .= '</div>

		<div class="option-block">';
	$content .= "<script>
                    jQuery(document).ready(function(e) {
                        jQuery('body').on('change','#levels-select', function (){
                            var val = jQuery('#levels-select').val();
                            jQuery('.option-block').find('.levels').each(function() {
                                var id_level = parseInt(jQuery(this).attr('id').replace(/\D+/g,''));
                                if(id_level>val){
                                    jQuery(this).hide().children().attr('disabled','disabled');
                                }else{
                                    jQuery(this).show().children().attr('disabled',false);
                                }
                            });
                        });
                    });
                    </script>";

	$stl	 = '';
	$actions = apply_filters( 'rcl_partner_actions', array(
		__( 'Registration', 'partners-system' ),
		__( 'Completion of a personal account', 'partners-system' ),
		__( 'Order payment', 'partners-system' )
	) );
	$types	 = array(
		__( 'No', 'partners-system' ),
		__( 'Points', 'partners-system' ),
		__( 'Payment', 'partners-system' ),
		__( 'Процент (платеж)' ),
		__( 'Процент (баллы)', 'partners-system' )
	);

	$content .= '<label>' . __( 'Promotion referral register', 'partners-system' ) . '</label>'
		. __( 'Type', 'partners-system' ) . ' <select name="reg[type]" style="width:140px;">';

	foreach ( $types as $k => $type ) {
		if ( $k == 3 )
			continue;
		$tp = (isset( $ps_options['reg']['type'] )) ? $ps_options['reg']['type'] : false;
		$content .= '<option value="' . $k . '" ' . selected( $k, $tp, false ) . '>' . $type . '</option>';
	}
	$sz = (isset( $ps_options['reg']['size'] )) ? $ps_options['reg']['size'] : false;
	$content .= '</select>'
		. ' ' . __( 'Size', 'partners-system' ) . ' <input style="width:50px;" type="text" name="reg[size]" value="' . $sz . '">';

	$content .= '<h3 align="center">' . __( 'Promote partner referral for action', 'partners-system' ) . '</h3>';

	for ( $b = 1; $b <= 100; $b ++  ) {
		$content .= '<div class="levels" id="level-' . $b . '" ' . $stl . '>'
			. '<h3 align="center">' . __( 'Level', 'partners-system' ) . ' ' . $b . '</h3>';

		foreach ( $actions as $key => $action ) {
			$sz = (isset( $ps_options['levels'][$b]['size'][$key] )) ? $ps_options['levels'][$b]['size'][$key] : false;
			$content .= '<label>' . $action . '</label>'
				. __( 'Type', 'partners-system' ) . ' <select name="levels[' . $b . '][type][' . $key . ']" style="width:150px;">';

			foreach ( $types as $k => $type ) {
				if ( $key === 0 && ($k == 3 || $k == 4) )
					continue;
				$tp = (isset( $ps_options['levels'][$b]['type'][$key] )) ? $ps_options['levels'][$b]['type'][$key] : false;
				$content .= '<option value="' . $k . '" ' . selected( $k, $tp, false ) . '>' . $type . '</option>';
			}
			$content .= '</select>'
				. ' ' . __( 'Size', 'partners-system' ) . ' <input style="width:50px;" type="text" name="levels[' . $b . '][size][' . $key . ']" value="' . $sz . '">';
		}
		$content .= '</div>';
		if ( $ps_options['partners_level'] == $b )
			$stl = 'style=display:none;"';
	}
	$content .= '
		</div>
	</div>';

	$content .= '<div style="width: 600px;">
	<p><input type="submit" class="button button-primary button-large right" name="options-ps" value="' . __( 'Save the settings', 'partners-system' ) . '" /></p>

        </div>
	</form>
	</div>';
	echo $content;
}

add_action( 'admin_init', 'update_options_ps' );
function update_options_ps() {
	//print_r($_POST);exit;
	if ( isset( $_POST['update-partners-options'] ) ) {

		if ( ! wp_verify_nonce( $_POST['_wpnonce'], 'update-options-ps' ) )
			return false;
		if ( get_option( WP_PREFIX . 'prtsys' ) != WP_HOST )
			return false;
		$lvl = $_POST['partners_level'];
		foreach ( $_POST as $key => $value ) {
			if ( $key == 'options-ps' )
				continue;
			if ( $key == 'levels' ) {
				foreach ( $value as $k => $val ) {
					if ( $k > $lvl )
						continue;
					$options[$key][$k] = $val;
				}
			}else {
				$options[$key] = $value;
			}
		}
		update_option( 'options-ps', $options );
		wp_redirect( admin_url( 'admin.php?page=partners-system' ) );
		exit;
	}
}

function admin_incentives_list() {
	global $wpdb;

	if ( $_POST['action'] == 'trash' ) {
		foreach ( $_POST['delete-incentive'] as $id ) {
			$author_ref = $_POST['partner'][$id];

			$ins_data = array(
				'partner'	 => $author_ref,
				'referal'	 => $_POST['referal'][$id],
				'size'		 => $_POST['size'][$id],
				'type'		 => $_POST['type'][$id]
			);

			$wpdb->query( "DELETE FROM " . WP_PREFIX . "prt_incentives WHERE ID = '$id'" );

			if ( $ins_data['type'] == 1 && function_exists( 'rcl_delete_rating' ) ) {

				$args = array(
					'user_id'		 => $ins_data['referal'],
					'object_id'		 => $id,
					'object_author'	 => $author_ref,
					'rating_value'	 => $ins_data['size'],
					'rating_type'	 => 'partner-system',
					'user_overall'	 => true
				);

				rcl_delete_rating( $args );
			}
			if ( $ins_data['type'] == 2 || $ins_data['type'] == 3 ) {

				$oldusercount	 = rcl_get_user_balance( $author_ref );
				$newusercount	 = $oldusercount - $ins_data['size'];
				rcl_update_user_balance( $newusercount, $author_ref, __( 'Cancellation of reward for referral', 'partners-system' ) );
			}

			do_action( 'rcl_partner_remove_incentives', $ins_data );
		}
	}

	if ( $_GET['paged'] )
		$page	 = $_GET['paged'];
	else
		$page	 = 1;

	$inpage	 = 30;
	$start	 = ($page - 1) * $inpage;
	if ( $_POST['search-user'] ) {
		$user		 = $_POST['search-user'];
		$incentives	 = $wpdb->get_results( "SELECT * FROM " . WP_PREFIX . "prt_incentives WHERE partner = '$user' OR referal = '$user' ORDER BY ID DESC LIMIT $start,$inpage" );
		$count		 = $wpdb->get_var( "SELECT COUNT(ID) FROM " . WP_PREFIX . "prt_incentives WHERE partner = '$user' OR referal = '$user'" );
	} elseif ( $_GET['partner'] ) {
		$get		 = $_GET['partner'];
		$get_data	 = '&partner=' . $get;
		$incentives	 = $wpdb->get_results( "SELECT * FROM " . WP_PREFIX . "prt_incentives WHERE partner = '$get' ORDER BY ID DESC LIMIT $start,$inpage" );
		$count		 = $wpdb->get_var( "SELECT COUNT(ID) FROM " . WP_PREFIX . "prt_incentives WHERE partner = '$get'" );
	} elseif ( $_GET['referal'] ) {
		$get		 = $_GET['referal'];
		$get_data	 = '&referal=' . $get;
		$incentives	 = $wpdb->get_results( "SELECT * FROM " . WP_PREFIX . "prt_incentives WHERE referal = '$get' ORDER BY ID DESC LIMIT $start,$inpage" );
		$count		 = $wpdb->get_var( "SELECT COUNT(ID) FROM " . WP_PREFIX . "prt_incentives WHERE referal = '$get'" );
	} elseif ( $_GET['type'] ) {
		$get		 = $_GET['type'];
		$get_data	 = '&type=' . $get;
		$incentives	 = $wpdb->get_results( "SELECT * FROM " . WP_PREFIX . "prt_incentives WHERE type_inc = '$get' ORDER BY ID DESC LIMIT $start,$inpage" );
		$count		 = $wpdb->get_var( "SELECT COUNT(ID) FROM " . WP_PREFIX . "prt_incentives WHERE type_inc = '$get'" );
	} else {
		$incentives	 = $wpdb->get_results( "SELECT * FROM " . WP_PREFIX . "prt_incentives ORDER BY ID DESC LIMIT $start,$inpage" );
		$count		 = $wpdb->get_var( "SELECT COUNT(ID) FROM " . WP_PREFIX . "prt_incentives" );
	}

	$num_page	 = ceil( $count / $inpage );
	$cnt		 = count( $incentives );

	$table	 = '<div class="wrap"><h2>' . __( 'Track produced rewards partners', 'partners-system' ) . '</h2>
                        <form action="" method="post">
                            <p class="search-box">
                                <label class="screen-reader-text" for="post-search-input">' . __( 'Search', 'partners-system' ) . ':</label>
                                <input type="search" id="post-search-input" name="search-user" value="' . $_POST['search-user'] . '">
                                <input type="submit" name="" id="search-submit" class="button" value="' . __( 'Search user', 'partners-system' ) . '">
                            </p>
                        </form>
			<form action="" method="post">
			<div class="tablenav top">
				<div class="alignleft actions">
				<select name="action">
					<option selected="selected" value="-1">' . __( 'Action', 'partners-system' ) . '</option>
					<option value="trash">' . __( 'Delete', 'partners-system' ) . '</option>
				</select>
				<input id="doaction" class="button action" type="submit" value="' . __( 'Apply', 'partners-system' ) . '" name="">
				</div>
			</div>
			<table class="widefat">
                        <thead>
			<tr>
                            <th class="check-column" scope="row"></th>
                            <th scope="col">№</th>
                            <th scope="col">' . __( 'Partner', 'partners-system' ) . '</th>
                            <th scope="col">' . __( 'Referral', 'partners-system' ) . '</th>
                            <th scope="col">' . __( 'Event:Type promotion', 'partners-system' ) . '</th>
                            <th scope="col">' . __( 'Size promotion', 'partners-system' ) . '</th>
                            <th scope="col">' . __( 'Date and time', 'partners-system' ) . '</th>
                        </tr>
                        </thead>';
	$n		 = 0;

	$actions = apply_filters( 'rcl_partner_actions', array(
		__( 'Registration', 'partners-system' ),
		__( 'Completion of a personal account', 'partners-system' ),
		__( 'Order payment', 'partners-system' )
	) );

	foreach ( $incentives as $incentive ) {

		switch ( $incentive->type_inc ) {
			case 1: $type_inc	 = __( 'Reputation', 'partners-system' );
				break;
			case 2: $type_inc	 = __( 'Lump sum payment', 'partners-system' );
				break;
			case 3: $type_inc	 = __( 'Процент (платеж)', 'partners-system' );
				break;
			case 4: $type_inc	 = __( 'Процент (баллы)', 'partners-system' );
				break;
		}

		switch ( $incentive->type_inc ) {
			case 1: $end = ' ' . __( 'points', 'partners-system' );
				break;
			case 4: $end = ' ' . __( 'points', 'partners-system' );
				break;
			default: $end = ' ' . rcl_get_primary_currency( 1 );
		}

		$action = (isset( $actions[$incentive->action_inc] )) ? $actions[$incentive->action_inc] : __( 'Unknown event', 'partners-system' );

		$table .= '<tr';
		if ( $n % 2 == 0 )
			$table .= ' class="alternate"';
		$table .= '>
		<th class="check-column" scope="row"><input id="delete-incentive-' . $incentive->ID . '" type="checkbox" value="' . $incentive->ID . '" name="delete-incentive[]"></th>
		<td>' . ++ $n . '</td>
		<td><a href="/wp-admin/admin.php?page=incentives-list&partner=' . $incentive->partner . '">' . get_the_author_meta( 'display_name', $incentive->partner ) . '</a></td>
		<td><a href="/wp-admin/admin.php?page=incentives-list&referal=' . $incentive->referal . '">' . get_the_author_meta( 'display_name', $incentive->referal ) . '</a></td>
		<td>' . $action . ': <a href="/wp-admin/admin.php?page=incentives-list&type=' . $incentive->type_inc . '">' . $type_inc . '</a></td>
		<td>' . __( 'Level', 'partners-system' ) . ' ' . $incentive->level . ': ' . $incentive->size_inc . $end;

		if ( in_array( $incentive->action_inc, array( 1, 2 ) ) )
			$table .= ' (' . __( 'Сумма платежа', 'partners-system' ) . ': ' . $incentive->order_inc . ' ' . rcl_get_primary_currency( 1 ) . ')';

		$table .= '</td>'
			. '<td>' . $incentive->time_start . '
		<input type="hidden" name="partner[' . $incentive->ID . ']" value="' . $incentive->partner . '">
		<input type="hidden" name="referal[' . $incentive->ID . ']" value="' . $incentive->referal . '">
		<input type="hidden" name="type[' . $incentive->ID . ']" value="' . $incentive->type_inc . '">
		<input type="hidden" name="size[' . $incentive->ID . ']" value="' . $incentive->size_inc . '">
		</td>
		</tr>';
	}

	$table .= '</table></form>';

	$navi = new Rcl_PageNavi( 'incentives', $count, array( 'key' => 'paged', 'in_page' => $inpage ) );

	$table .= $navi->pagenavi();

	$table .= '</div>';

	echo $table;
}

function admin_partners_list() {
	global $wpdb;

	rcl_dialog_scripts();

	if ( isset( $_POST['delete_referal'] ) ) {
		$del_ref	 = $_POST['referal'];
		$author_ref	 = $_POST['partner'];

		$all_size_inc	 = $wpdb->get_var( "SELECT sum(size_inc) FROM " . WP_PREFIX . "prt_incentives WHERE type_inc = '2' AND referal = '$del_ref' OR type_inc = '3' AND referal = '$del_ref'" );
		$ref_data		 = $wpdb->get_row( "SELECT * FROM " . WP_PREFIX . "prt_incentives WHERE referal = '$del_ref' AND partner = '$author_ref'" );

		if ( $all_size_inc != 0 ) {
			$oldusercount	 = rcl_get_user_balance( $author_ref );
			$newusercount	 = $oldusercount - $all_size_inc;
			rcl_update_user_balance( $newusercount, $author_ref, __( 'Cancellation of reward for referral', 'partners-system' ) );
		}

		if ( $ref_data->type_inc == 1 && function_exists( 'rcl_delete_rating' ) ) {
			//$size_ref = -1*$ref_data->size_inc;
			//update_total_rayt_user_rcl($ref_data->partner,$size_ref);
			$args = array(
				'user_id'		 => $ref_data->referal,
				'object_id'		 => $ref_data->ID,
				'object_author'	 => $ref_data->partner,
				'rating_value'	 => $ref_data->size_inc,
				'rating_type'	 => 'partner-system',
				'user_overall'	 => true
			);

			rcl_delete_rating( $args );
		}

		$wpdb->query( "DELETE FROM " . WP_PREFIX . "prt_partners WHERE referal = '$del_ref'" );
		$wpdb->query( "DELETE FROM " . WP_PREFIX . "prt_incentives WHERE referal = '$del_ref'" );
	}

	if ( isset( $_GET['paged'] ) )
		$page	 = $_GET['paged'];
	else
		$page	 = 1;

	$inpage	 = 30;
	$start	 = ($page - 1) * $inpage;

	if ( isset( $_GET['user-id'] ) ) {
		$user_id	 = $_GET['user-id'];
		$referals	 = $wpdb->get_results( "SELECT * FROM " . WP_PREFIX . "prt_partners WHERE partner = '$user_id' OR referal = '$user_id' ORDER BY ID DESC LIMIT $start,$inpage" );
		$count		 = $wpdb->get_var( "SELECT COUNT(ID) FROM " . WP_PREFIX . "prt_partners WHERE partner = '$user_id' OR referal = '$user_id'" );
	} elseif ( isset( $_GET['partner'] ) ) {
		$get		 = $_GET['partner'];
		$get_data	 = '&partner=' . $get;
		$referals	 = $wpdb->get_results( "SELECT * FROM " . WP_PREFIX . "prt_partners WHERE partner = '$get' ORDER BY ID DESC LIMIT $start,$inpage" );
		$count		 = $wpdb->get_var( "SELECT COUNT(ID) FROM " . WP_PREFIX . "prt_partners WHERE partner = '$get'" );
	} else {
		$referals	 = $wpdb->get_results( "SELECT * FROM " . WP_PREFIX . "prt_partners ORDER BY ID DESC LIMIT $start,$inpage" );
		$count		 = $wpdb->get_var( "SELECT COUNT(ID) FROM " . WP_PREFIX . "prt_partners" );
	}

	$num_page	 = ceil( $count / $inpage );
	$cnt		 = count( $referals );



	$n		 = 0;
	$table	 = '<div class="wrap preloader-box">
        <h2>' . __( 'Statistics activity partners', 'partners-system' ) . '</h2>
            <span class="add-partner">'
		. '<a href="#" class="button-primary" onclick=\'ps_ajax(' . json_encode( array(
			'action' => 'ps_get_form_new_referal',
		) ) . ',this);return false;\'>Добавить новую связь</a>'
		. '</span>
            <form action="" method="get">
                <p class="search-box">
                    <label class="screen-reader-text" for="post-search-input">' . __( 'Search', 'partners-system' ) . ':</label>
                    <input type="search" id="post-search-input" name="user-id" value="' . $_GET['user-id'] . '">
                    <input type="submit" name="" id="search-submit" class="button" value="' . __( 'Search user', 'partners-system' ) . '">
                    <input type="hidden" name="page" value="partners-list">
                </p>
            </form>
            <table class="widefat">
            <thead>
            <tr>
                <th scope="col">№</th>
                <th scope="col">' . __( 'Partner', 'partners-system' ) . '</th>
                <th scope="col">' . __( 'Referral', 'partners-system' ) . '</th>
                <th scope="col">' . __( 'URL', 'partners-system' ) . '</th>
                <th scope="col">' . __( 'Date and time', 'partners-system' ) . '</th>
                <th scope="col"></th>
            </tr>
            </thead>';

	if ( $referals ) {

		foreach ( $referals as $referal ) {
			$table .= '<tr';
			if ( $n % 2 == 0 )
				$table .= ' class="alternate"';
			$table .= '>'
				. '<td>' . ++ $n . '</td>'
				. '<td>'
				. get_the_author_meta( 'display_name', $referal->partner )
				. '<div class="row-actions">'
				. '<span class="all-reffers">'
				. '<a href="' . get_bloginfo( 'wpurl' ) . '/wp-admin/admin.php?page=partners-list&partner=' . $referal->partner . '">Получить всех рефералов</a>'
				. '</span>'
				. ' | '
				. '<span class="edit-partner">'
				. '<a href="#" onclick=\'ps_ajax(' . json_encode( array(
					'action'	 => 'ps_get_form_edit_partner',
					'data_id'	 => $referal->ID
				) ) . ',this);return false;\'>Переназначить партнера</a>'
				. '</span>'
				. '</div>'
				. '</td>'
				. '<td>'
				. '<a href="' . get_author_posts_url( $referal->referal ) . '">' . get_the_author_meta( 'display_name', $referal->referal ) . '</a>'
				. '<div class="row-actions">'
				. '<span class="edit-referal">'
				. '<a href="#" onclick=\'ps_ajax(' . json_encode( array(
					'action'	 => 'ps_get_form_edit_referal',
					'data_id'	 => $referal->ID
				) ) . ',this);return false;\'>Переназначить реферала</a>'
				. '</span>'
				. '</div>'
				. '</td>'
				. '<td>' . $referal->url . '</td>'
				. '<td>' . mysql2date( 'j F Y H:i', $referal->timeaction ) . '</td>'
				. '<td>'
				. '<form action="" method="post">'
				. '<input type="submit" class="button-primary" name="delete_referal" value="' . __( 'Delete', 'partners-system' ) . '">'
				. '<input type="hidden" name="referal" value="' . $referal->referal . '">'
				. '<input type="hidden" name="partner" value="' . $referal->partner . '">'
				. '</form>'
				. '</td>'
				. '</tr>';
		}
	}
	$table .= '</table>';

	$navi = new Rcl_PageNavi( 'partners', $count, array( 'key' => 'paged', 'in_page' => $inpage ) );

	$table .= $navi->pagenavi();

	$table .= '</div>';

	echo $table;
}
