<?php

function mw_get_history( $args = array() ) {

	$query = new MW_History();

	return $query->get_results( $args );
}

function mw_count_history( $args = array() ) {

	$query = new MW_History();

	return $query->count( $args );
}

function mw_get_requests( $args = array() ) {

	$query = new MW_Request();

	return $query->get_results( $args );
}

function mw_count_requests( $args = array() ) {

	$query = new MW_Request();

	return $query->count( $args );
}

function mw_get_request( $request_id ) {

	$query = new MW_Request();

	return $query->get_row( array(
			'ID' => $request_id
	) );
}

function mw_get_user_request( $user_id, $status = 1 ) {

	$query = new MW_Request();

	return $query->get_row( array(
			'user_rq'	 => $user_id,
			'status_rq'	 => $status
	) );
}

function mw_add_request( $args ) {
	global $wpdb;

	$args = wp_parse_args( $args, array(
		'output_rq'	 => 0,
		'time_rq'	 => current_time( 'mysql' ),
		'status_rq'	 => 1
	) );



	if ( ! $wpdb->insert( RCL_PREF . 'wallet_request', $args ) )
		return false;

	$request_id = $wpdb->insert_id;

	do_action( 'mw_add_request', $request_id );

	return $request_id;
}

function mw_delete_request( $request_id ) {
	global $wpdb;

	return $wpdb->query( "DELETE FROM " . RCL_PREF . "wallet_request WHERE ID='$request_id'" );
}
