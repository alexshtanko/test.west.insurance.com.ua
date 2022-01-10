<?php

class Partner_Class {

	public $level;
	public $partner;
	public $action; //0 - регистрация, 1 - пополнение ЛС, 2 - оплата заказа
	public $type;
	public $sumorder = 0;
	public $referal;
	public $size;
	public $ref_url;

	function __construct() {

		init_globals_ps();

		add_action( 'init', array( &$this, 'save_new_ref_link_activate' ) );
		add_action( 'user_register', array( &$this, 'save_new_ref_link' ), 10 );
		add_action( 'rcl_success_pay_system', array( &$this, 'payment_balance' ), 10 );
		add_action( 'rcl_payment_order', array( &$this, 'payment_order' ) );
		add_action( 'woocommerce_order_status_completed', array( &$this, 'wc_payment' ), 10 );
		add_action( 'delete_user', array( &$this, 'transfer_referals' ), 10 );
	}

	function wc_payment( $order_id ) {
		$order = wc_get_order( $order_id );

		$this->sumorder = $order->get_total();

		if ( ps_get_option( 'return_amount' ) ) {

			//если заказ первый, то начисляем на баланс указанный процент
			if ( wc_get_customer_order_count( $order->user_id ) == 1 ) {
				$this->return_amount( $order->user_id, $this->sumorder );
			}
		}

		$this->loop_insentives( ( int ) $order->user_id, 2 );
	}

	function payment_order( $order_id ) {

		$rclOrder = rcl_get_order( $order_id );

		$this->sumorder = $rclOrder->order_price;

		if ( ps_get_option( 'return_amount' ) ) {

			$Rcl_Orders_Query = new Rcl_Orders_Query();

			//если заказ первый, то начисляем на баланс указанный процент
			if ( $Rcl_Orders_Query->count( array( 'user_id' => $rclOrder->user_id ) ) == 1 ) {
				$this->return_amount( $rclOrder->user_id, $this->sumorder );
			}
		}

		$this->loop_insentives( $rclOrder->user_id, 2 );
	}

	function return_amount( $user_id, $orderPrice ) {

		$returnAmount = ps_get_option( 'return_amount' );

		if ( ! $returnAmount || ! $orderPrice )
			return false;

		$amount = round( $orderPrice * $returnAmount / 100, 2 );

		$userBalance = rcl_get_user_balance( $user_id ) + $amount;

		$res = rcl_update_user_balance( $userBalance, $user_id, __( 'Возврат от оплаты первого заказа согласно условий партнерской программы', 'partners-system' ) );
	}

	function payment_balance( $data ) {
		if ( $data->pay_type != 1 )
			return false;
		$this->sumorder = $data->pay_summ;
		$this->loop_insentives( $data->user_id, $data->pay_type );
	}

	function save_data_referal() {
		global $ps_options, $post;
		$data	 = 'id';
		if ( $ps_options['get_data'] == 1 )
			$data	 = 'login';
		$return	 = ($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : $_SERVER['SERVER_NAME'];
		$user	 = get_user_by( $data, $_GET[$ps_options['get_name']] );
		setcookie( 'ref', $user->ID, time() + 3600 * 24 * 30, '/' );
		setcookie( 'return', $return, time() + 3600 * 24 * 30, '/' );

		if ( $_GET['tail'] && $post->ID != $_GET['tail'] ) {
			wp_redirect( get_permalink( $_GET['tail'] ) );
			exit;
		}
	}

	function save_new_ref_link_activate() {
		global $ps_options;
		if ( isset( $_GET[$ps_options['get_name']] ) ) {
			add_action( 'wp', array( &$this, 'save_data_referal' ) );
		}
	}

	function transfer_referals( $user_id ) {
		global $wpdb, $ps_options;

		if ( ! isset( $ps_options['transfer_referals'] ) || ! $ps_options['transfer_referals'] )
			return false;

		$partner_id = $this->get_partner( $user_id );
		if ( $partner_id ) {
			$wpdb->update(
				WP_PREFIX . "prt_partners", array(
				'partner' => $partner_id
				), array(
				'partner' => $user_id
				)
			);
		}
	}

	function update_count_partner( $partner, $size ) {
		global $wpdb;
		$oldcount = rcl_get_user_balance( $partner );

		$newusercount	 = $oldcount + $size;
		$res			 = rcl_update_user_balance( $newusercount, $partner, __( 'Accrual of funds for the affiliate program', 'partners-system' ) );

		return $res;
	}

	function get_partner( $user_id ) {
		global $wpdb;
		$partner = $wpdb->get_var( "SELECT partner FROM " . WP_PREFIX . "prt_partners WHERE referal='$user_id'" );
		return $partner;
	}

	function get_referal( $user_id ) {
		global $wpdb;
		$referal = $wpdb->get_var( "SELECT referal FROM " . WP_PREFIX . "prt_partners WHERE partner='$user_id'" );
		return $referal;
	}

	function count_referals( $partner_id ) {
		global $wpdb;
		return $wpdb->get_var( "SELECT COUNT(referal) FROM " . WP_PREFIX . "prt_partners WHERE partner='$partner_id'" );
	}

	function mail_new_ref( $partner, $referall ) {
		$subject	 = __( 'You have a new referral!', 'partners-system' );
		$email		 = get_the_author_meta( 'user_email', $partner );
		$textmail	 = '
            <p>' . sprintf( __( 'Congratulations! On the website "%s" you have a new referral', 'partners-system' ), get_bloginfo( 'name' ) ) . '</p>
            <h3>' . __( 'Information about referrals', 'partners-system' ) . ':</h3>
            <p><b>' . __( 'Name', 'partners-system' ) . '</b>: <a href="' . get_author_posts_url( $referall ) . '">' . get_the_author_meta( 'display_name', $referall ) . '</a></p>'
			. '<p><b>' . __( 'Email Реферала', 'partners-system' ) . '</b>: ' . get_the_author_meta( 'email', $referall ) . '</p>';
		rcl_mail( $email, $subject, $textmail );
	}

	function add_new_insentive( $user_id = false ) {
		global $wpdb;
		$referal	 = $this->referal;
		$time_action = current_time( 'mysql' );
		if ( ! $user_id )
			$user_id	 = $this->partner;
		else
			$referal	 = 0;

		$this->size = floatval( str_replace( ',', '.', $this->size ) );

		if ( $this->type == 3 || $this->type == 4 ) {
			$size		 = $this->sumorder * $this->size / 100;
			$accuracy	 = $this->type == 3 ? 2 : 0;
			$size		 = round( $size, $accuracy );
		} else {
			$size = $this->size;
		}

		$res = $wpdb->insert(
			WP_PREFIX . 'prt_incentives', array(
			'action_inc' => $this->action,
			'type_inc'	 => $this->type,
			'size_inc'	 => $size,
			'order_inc'	 => $this->sumorder,
			'referal'	 => $referal,
			'level'		 => $this->level,
			'partner'	 => $user_id,
			'time_start' => $time_action
			)
		);

		switch ( $this->type ) {
			case 1:
				if ( function_exists( 'rcl_insert_rating' ) ) {
					$args = array(
						'user_id'		 => $referal,
						'object_id'		 => $wpdb->insert_id,
						'object_author'	 => $user_id,
						'rating_value'	 => $size,
						'rating_type'	 => 'partner-system',
						'user_overall'	 => true
					);
					rcl_insert_rating( $args );
				}
				break;
			case 2:
				$this->update_count_partner( $user_id, $size );
				break;
			case 3: if ( $this->sumorder ) {
					$this->update_count_partner( $user_id, $size );
				}
				break;
			case 4: if ( $this->sumorder ) {
					if ( function_exists( 'rcl_insert_rating' ) ) {
						$args = array(
							'user_id'		 => $referal,
							'object_id'		 => $wpdb->insert_id,
							'object_author'	 => $user_id,
							'rating_value'	 => $size,
							'rating_type'	 => 'partner-system',
							'user_overall'	 => true
						);
						rcl_insert_rating( $args );
					}
				}
				break;
		}

		return $res;
	}

	function insert_new_referall( $partner_id, $user_id, $url ) {
		global $ps_options, $wpdb;

		$defaultPartnerID = 0;

		if ( ps_get_option( 'default_partner_on' ) ) {

			$defaultPartnerID = ps_get_option( 'default_partner', 0 );

			if ( ! $defaultPartnerID )
				$defaultPartnerID = $wpdb->get_var( "SELECT ID FROM $wpdb->users WHERE ID!='$user_id' ORDER BY RAND()" );
		}

		$refersAmount = ps_get_option( 'refers_amount', 0 );

		if ( $refersAmount && $defaultPartnerID != $partner_id ) {

			if ( $this->count_referals( $partner_id ) >= $refersAmount ) {

				if ( $defaultPartnerID && $partner_id != $defaultPartnerID ) {

					$this->insert_new_referall( $defaultPartnerID, $user_id, '' );
				}

				return;
			}
		}

		$time_action = current_time( 'mysql' );

		$data = array(
			'partner'	 => $partner_id,
			'referal'	 => $user_id,
			'url'		 => isset( $url ) ? $url : $_SERVER['SERVER_NAME'],
			'timeaction' => $time_action
		);

		$res = $wpdb->insert(
			WP_PREFIX . 'prt_partners', $data
		);

		do_action( 'insert_new_referall', $data );

		$this->mail_new_ref( $partner_id, $user_id );

		return $res;
	}

	function loop_insentives( $referal, $action = 2 ) {
		global $ps_options;
		$this->action	 = $action;
		$this->referal	 = $referal;
		$this->level	 = 0;

		if ( $action === 0 && $ps_options['reg']['type'] ) {
			$this->type	 = $ps_options['reg']['type'];
			$this->size	 = $ps_options['reg']['size'];
			$this->add_new_insentive( $this->referal );
		}

		for ( $this->level = 1; $this->level <= $ps_options['partners_level']; $this->level ++ ) {

			$this->partner = $this->get_partner( $this->referal );

			if ( ! $this->partner )
				break;

			if ( $ps_options['levels'][$this->level]['type'][$action] == 0 ) {
				$this->referal	 = $this->partner;
				$this->partner	 = false;
				continue;
			}

			$this->type	 = $ps_options['levels'][$this->level]['type'][$action];
			$this->size	 = $ps_options['levels'][$this->level]['size'][$action];

			$this->add_new_insentive();

			$this->referal	 = $this->partner;
			$this->partner	 = false;
		}
	}

	function save_new_ref_link( $user_id ) {
		global $wpdb;

		$partnerID	 = 0;
		$url		 = $_SERVER['SERVER_NAME'];

		if ( ps_get_option( 'promocode' ) && isset( $_POST['ps_promocode'] ) && $_POST['ps_promocode'] ) {

			$promoID = ps_decode_promocode( $_POST['ps_promocode'] );

			if ( get_user_by( 'ID', $promoID ) ) {
				$partnerID	 = $promoID;
				$url		 = 'code: ' . $_POST['ps_promocode'];
			}
		}

		if ( ! $partnerID ) {
			$partnerID	 = isset( $_COOKIE['ref'] ) ? $_COOKIE['ref'] : 0;
			$url		 = isset( $_COOKIE['return'] ) ? $_COOKIE['return'] : '';
		}

		if ( $partnerID ) {

			$this->insert_new_referall( $partnerID, $user_id, $url );
			$this->loop_insentives( $user_id, 0 );
		} else {

			if ( ps_get_option( 'default_partner_on' ) ) {

				$defaultPartnerID = ps_get_option( 'default_partner', 0 );

				if ( ! $defaultPartnerID )
					$defaultPartnerID = $wpdb->get_var( "SELECT ID FROM $wpdb->users WHERE ID!='$user_id' ORDER BY RAND()" );

				if ( $defaultPartnerID ) {
					$this->insert_new_referall( $defaultPartnerID, $user_id, $url );
				}
			}
		}

		setcookie( 'ref', '', time() + 3600 * 24 * 30, '/' );
		setcookie( 'return', '', time() + 3600 * 24 * 30, '/' );
	}

}

$Partner_Class = new Partner_Class();

class Map_Partners {

	public $lvl;

	function __construct() {

	}

	function get_referalls( $users_id ) {
		global $wpdb;
		return $wpdb->get_col( "SELECT referal FROM " . WP_PREFIX . "prt_partners WHERE partner IN (" . implode( ',', $users_id ) . ")" );
	}

	function get_level( $refs ) {

		if ( ! $refs )
			return false;

		$map = '<div class="level">'
			. '<small class="title-lvl">' . __( 'Level', 'partners-system' ) . ' ' . $this->lvl . '</small>';
		foreach ( $refs as $ref ) {
			$map .= $this->get_user_box( $ref );
		}
		$map .= '</div>';
		return $map;
	}

	function get_user_box( $user_id ) {
		return '<div class="partner">'
			. '<a href="' . get_author_posts_url( $user_id ) . '" title="' . get_the_author_meta( 'display_name', $user_id ) . '">'
			. get_avatar( $user_id, 30 )
			. '</a>'
			. '</div>';
	}

	function get_map_partners() {
		global $ps_options, $user_ID;

		if ( ! $user_ID )
			return false;

		$map = '<div id="map-partners">';
		$map .= '<div class="level">'
			. '<div class="partner">'
			. '<a href="' . get_author_posts_url( $user_ID ) . '">'
			. get_avatar( $user_ID, 30 )
			. '</a>'
			. '</div>'
			. '</div>';

		$partners = array( $user_ID );

		for ( $this->lvl = 1; $this->lvl <= $ps_options['partners_level']; $this->lvl ++ ) {
			$refs		 = $this->get_referalls( $partners );
			if ( ! $refs )
				break;
			$map .= $this->get_level( $refs );
			$partners	 = $refs;
		}
		$map .= '</div>';
		return $map;
	}

}
