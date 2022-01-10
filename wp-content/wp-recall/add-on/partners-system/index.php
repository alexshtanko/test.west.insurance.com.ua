<?php

include_once 'classes/class-partners-form.php';
include_once 'classes/class-partners.php';
include_once 'promocode.php';
include_once 'functions-ajax.php';

if ( is_admin() )
	include_once 'admin/index.php';

if ( ! is_admin() ):
	add_action( 'rcl_enqueue_scripts', 'rcl_partners_system_scripts', 10 );
endif;
function rcl_partners_system_scripts() {
	rcl_enqueue_style( 'partners-system', rcl_addon_url( 'style.css', __FILE__ ) );
}

add_action( 'plugins_loaded', 'rcl_partners_load_plugin_textdomain', 10 );
function rcl_partners_load_plugin_textdomain() {
	load_textdomain( 'partners-system', rcl_addon_path( __FILE__ ) . '/languages/partners-system-' . get_locale() . '.mo' );
}

add_action( 'init', 'init_globals_ps' );
function init_globals_ps() {
	global $rcl_options, $ps_options;
	$ps_options				 = get_option( 'options-ps' );
	$rcl_options['partners'] = $ps_options;
	if ( ! $ps_options['get_name'] )
		$ps_options['get_name']	 = 'ref';
}

add_action( 'init', 'add_tab_partners_system' );
function add_tab_partners_system() {

	$args = array(
		'id'		 => 'partners',
		'name'		 => __( "You're a partner!", 'partners-system' ),
		'supports'	 => array( 'ajax' ),
		'public'	 => 0,
		'icon'		 => 'fa-share-alt',
		'output'	 => 'menu',
		'content'	 => array(
			array(
				'id'		 => 'your-refers',
				'icon'		 => 'fa-users',
				'name'		 => __( 'Attached referrals', 'partners-system' ),
				'callback'	 => array(
					'name' => 'ps_tab_refers'
				)
			),
			array(
				'id'		 => 'your-incentive',
				'icon'		 => 'fa-usd',
				'name'		 => __( 'Charges', 'partners-system' ),
				'callback'	 => array(
					'name' => 'ps_tab_incentive'
				)
			),
			array(
				'id'		 => 'referall-map',
				'icon'		 => 'fa-usd',
				'name'		 => __( 'Карта рефералів', 'partners-system' ),
				'callback'	 => array(
					'name' => 'get_map_partners'
				)
			)
		)
	);

	rcl_tab( $args );
}

function ps_tab_refers( $master_id ) {
	global $wpdb, $ps_options;

	$content = '';

	if ( ps_get_option( 'link_partner' ) ) {
		$partner_id = ps_get_partner( $master_id );
		if ( $partner_id )
			$content .= '<p>' . __( 'Your upstream partner', 'partners-system' ) . ': <a href="' . get_author_posts_url( $partner_id ) . '">' . get_the_author_meta( 'display_name', $partner_id ) . '</a></p><br>';
	}

	$content .= '<p><b>' . __( 'Your affiliate link', 'partners-system' ) . '</b>: ' . get_ref_url() . '</p>';

	if ( ps_get_option( 'promocode' ) ) {
		$content .= '<p><b>' . __( 'Ваш промокод', 'partners-system' ) . '</b>: ' . ps_get_promocode( $master_id ) . '</p><br>';
	}

	$content .= '<h3>' . __( 'Was referrals', 'partners-system' ) . '</h3>';

	$cnt = $wpdb->get_var( "SELECT COUNT(ID) FROM " . WP_PREFIX . "prt_partners WHERE partner = '$master_id'" );

	if ( ! $cnt ) {
		$content .= '<p>' . __( 'You have not yet registered referrals', 'partners-system' ) . '</p>';
		return $content;
	}

	$ref_navi	 = new Rcl_PageNavi( 'refers', $cnt );
	$limit_us	 = $ref_navi->limit();

	$referals = $wpdb->get_results( "SELECT * FROM " . WP_PREFIX . "prt_partners WHERE partner = '$master_id' ORDER BY ID DESC LIMIT $limit_us" );

	$content .= '<table class="referal-list rcl-form">
        <tr>
            <th scope="col">' . __( 'Your referral', 'partners-system' ) . '</td>
            <th scope="col">' . __( 'Number of referrals', 'partners-system' ) . '</td>
            <th scope="col">' . __( 'URL', 'partners-system' ) . '</td>
            <th scope="col">' . __( 'Date and time', 'partners-system' ) . '</td>
        </tr>';

	foreach ( $referals as $referal ) {
		$cnt_sec_referals = $wpdb->get_var( "SELECT count(ID) FROM " . WP_PREFIX . "prt_partners WHERE partner = '$referal->referal'" );
		$content .= '<tr>'
			. '<td><a href="' . get_author_posts_url( $referal->referal ) . '">' . get_the_author_meta( 'display_name', $referal->referal ) . '</a></td>'
			. '<td>' . $cnt_sec_referals . ' реф.</td>'
			. '<td>' . $referal->url . '</td>'
			. '<td>' . mysql2date( 'j F Y H:i', $referal->timeaction ) . '</td>'
			. '</tr>';
	}

	$content .= '</table>';

	$content .= $ref_navi->pagenavi();

	return $content;
}

function ps_tab_incentive( $master_id ) {
	global $wpdb;

	$stat = '<h3>' . __( 'Statistics of rewards', 'partners-system' ) . '</h3>';

	$cnt_inc = $wpdb->get_var( "SELECT COUNT(ID) FROM " . WP_PREFIX . "prt_incentives WHERE partner = '$master_id' ORDER BY ID DESC" );

	if ( ! $cnt_inc ) {
		$stat .= '<p>' . __( 'You didn`t get rewards for the actions of your referrals', 'partners-system' ) . '</p>';
		return $stat;
	}

	$inc_navi	 = new Rcl_PageNavi( 'incentyives', $cnt_inc, array( 'in_page' => 50 ) );
	$limit_us	 = $inc_navi->limit();

	$incentives = $wpdb->get_results( "SELECT * FROM " . WP_PREFIX . "prt_incentives WHERE partner = '$master_id' ORDER BY ID DESC LIMIT $limit_us" );

	$stat = '<table class="referal-list rcl-form">';

	$stat .= '<tr>'
		. '<th>' . __( 'Referral', 'partners-system' ) . '</th>'
		. '<th>' . __( 'Size promotion', 'partners-system' ) . '</th>'
		. '<th>' . __( 'Date and time', 'partners-system' ) . '</th>'
		. '</tr>';

	foreach ( $incentives as $incentive ) {

		switch ( $incentive->type_inc ) {
			case 1: $end = ' ' . __( 'points', 'partners-system' ) . '';
				break;
			case 4: $end = ' ' . __( 'points', 'partners-system' ) . '';
				break;
			default: $end = ' ' . rcl_get_primary_currency( 1 );
		}

		$stat .= '<tr>'
			. '<td><a href="' . get_author_posts_url( $incentive->referal ) . '">' . get_the_author_meta( 'display_name', $incentive->referal ) . '</a></td>'
			. '<td>' . __( 'Level', 'partners-system' ) . ' ' . $incentive->level . ': ' . $incentive->size_inc . $end;

		if ( in_array( $incentive->action_inc, array( 1, 2 ) ) )
			$stat .= ' (' . __( 'Сумма платежа', 'partners-system' ) . ': ' . $incentive->order_inc . ' ' . rcl_get_primary_currency( 1 ) . ')';

		$stat .= '</td>'
			. '<td>' . $incentive->time_start . '</td>'
			. '</tr>';
	}

	$stat .= '</table>';

	$stat .= $inc_navi->pagenavi();

	return $stat;
}

function get_ref_url( $atts = false ) {
	global $ps_options, $user_ID, $post;

	if ( ! $user_ID )
		return false;

	extract( shortcode_atts( array(
		'type' => 'default'
			), $atts ) );

	if ( $type == 'current' ) {
		$page = get_permalink( $post->ID );
	} else {
		if ( isset( $ps_options['ref_page'] ) && $ps_options['ref_page'] )
			$page	 = get_permalink( $ps_options['ref_page'] );
		else
			$page	 = get_home_url() . '/';
	}

	$data = $user_ID;

	if ( isset( $ps_options['get_data'] ) && $ps_options['get_data'] == 1 )
		$data	 = get_the_author_meta( 'user_login', $user_ID );
	$url	 = rcl_format_url( $page ) . $ps_options['get_name'] . '=' . $data;

	if ( $type == 'tail' )
		$url .= '&tail=' . $post->ID;

	return $url;
}

add_shortcode( 'ref-url', 'get_ref_url' );
function get_statistics_ps() {
	global $user_ID;

	if ( ! $user_ID )
		return false;

	$content = ps_tab_refers( $user_ID );

	$content .= ps_tab_incentive( $user_ID );

	return $content;
}

add_shortcode( 'partner-stats', 'get_statistics_ps' );
function get_map_partners() {
	$map = new Map_Partners();
	return $map->get_map_partners();
}

add_shortcode( 'partner-map', 'get_map_partners' );
//$action: 0 - регистрация, 1 - пополнение ЛС, 2 - оплата заказа
function add_partner_incentive( $referal, $sumorder = 0, $action = 2 ) {
	global $wpdb;
	$prt			 = new Partner_Class();
	$prt->sumorder	 = $sumorder;
	$prt->loop_insentives( $referal, $action );
}

function ps_get_partner( $user_id ) {
	global $wpdb;
	$partner = $wpdb->get_var( "SELECT partner FROM " . WP_PREFIX . "prt_partners WHERE referal='$user_id'" );
	return $partner;
}

function ps_get_referal( $user_id ) {
	global $wpdb;
	$referals = array();
	$referalResult = $wpdb->get_results( "SELECT referal FROM " . WP_PREFIX . "prt_partners WHERE partner='$user_id'" , ARRAY_A);
	if(count($referalResult) > 0){
		foreach($referalResult as $data){
			$referals[] = $data["referal"];
		}
	}
	return $referals;
}

function ps_update_partners( $update, $where ) {
	global $wpdb;

	$result = $wpdb->update( WP_PREFIX . "prt_partners", $update, $where
	);

	return $result;
}

function ps_get_option( $name, $default = false ) {
	global $ps_options;

	if ( ! $ps_options )
		$ps_options = get_option( 'options-ps' );

	if ( isset( $ps_options[$name] ) && $ps_options[$name] != '' )
		return $ps_options[$name];

	return $default;
}

function ps_form( $args ) {
	$Form = new PS_Form( $args );
	return $Form->get_form();
}

add_action( 'delete_user', 'ps_delete_user_data', 20 );
function ps_delete_user_data( $user_id ) {
	global $wpdb;

	$wpdb->query( "DELETE FROM " . WP_PREFIX . "prt_partners WHERE referal = '$user_id' OR partner = '$user_id'" );
}
