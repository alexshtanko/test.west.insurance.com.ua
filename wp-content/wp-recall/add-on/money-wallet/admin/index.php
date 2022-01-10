<?php

require_once 'history-requests.php';
require_once 'history-payments.php';

add_action('admin_menu', 'request_output_wallet_page_rcl',30);
function request_output_wallet_page_rcl(){
    $prim = 'manage-rmag';
    if(!function_exists('rcl_commerce_menu')) $prim = 'manage-wpm-options';
    $hook1 = add_submenu_page( $prim, __('Withdrawal','rcl-wallet'), __('Withdrawal','rcl-wallet'), 'edit_plugins', 'manage-output-wallet', 'rcl_wallet_history_admin_page');
    add_action( "load-$hook1", 'rcl_wallet_history_page_options' );
    $hook2 = add_submenu_page( $prim, __('Flow of funds','rcl-wallet'), __('Flow of funds','rcl-wallet'), 'edit_plugins', 'wallet-history-payments', 'rcl_wallet_payments_admin_page');
    add_action( "load-$hook2", 'rcl_wallet_payments_page_options' );

}

add_filter('balans_column_rcl','add_link_history_money',10,2);
function add_link_history_money($cnt,$user_id){
    $cnt .= '<br><a href="'.admin_url('admin.php?page=wallet-history-payments&action=history&user='.$user_id).'">'.__('History','rcl-wallet').'</a>';
    return $cnt;
}

add_filter('admin_options_wprecall','get_admin_wallet_page_content');
function get_admin_wallet_page_content($content){
    global $rcl_options;

    $opt = new Rcl_Options(__FILE__);

    $content .= $opt->options(
        __('Settings personal account','rcl-wallet'), array(
        $opt->options_box( __('Withdrawal','rcl-wallet'),
            array(
                array(
                    'type' => 'select',
                    'slug' => 'output_wallet_request',
                    'title' => __('Allow withdrawals?','rcl-wallet'),
                    'values' => array(__('Not allowed','rcl-wallet'),__('Allowed','rcl-wallet')),
                    'childrens' => array(
                        1 => array(
                            array(
                                'type' => 'textarea',
                                'slug' => 'pay_system_request',
                                'title' =>__('Payment system which permitted withdrawal','rcl-wallet'),
                                'notice' => __('Specify comma-separated names of payment systems which the user can choose to withdraw funds','rcl-wallet'),
                            ),
                            array(
                                'type' => 'number',
                                'slug' => 'percent_output_request',
                                'title' =>__('The percentage of Commission for withdrawal of funds','rcl-wallet'),
                                'notice' => __('If nothing is specified, the withdrawal Commission is not charged','rcl-wallet'),
                            ),
                            array(
                                'type' => 'number',
                                'slug' => 'mw_min',
                                'title' =>__('Минимальная сумма снятия','rcl-wallet')
                            )
                        )
                    )
                ),
                array(
                    'type' => 'select',
                    'slug' => 'wallet_usercount',
                    'title' => __('Bring personal account in the advanced tab','rcl-wallet'),
                    'values' => array(__('No','rcl-wallet'),__('Yes','rcl-wallet'))
                )
            )
        ),
        $opt->options_box( __('The transfer of funds','rcl-wallet'),
            array(
                array(
                    'type' => 'select',
                    'slug' => 'output_pay_other_user',
                    'title' => __('Transfer of funds between users','rcl-wallet'),
                    'values' => array(__('Not allowed','rcl-wallet'),__('Allowed','rcl-wallet'))
                )
            )
        ))
    );

    return $content;

}

function mw_admin_cancel_request($id_row){

    $request = mw_get_request($id_row);

    if(!$request){
        wp_die(__('Не удалось найти запрос'));
    }

    $delete = mw_delete_request($id_row);

    if(!$delete){
        wp_die(__('Не удалось удалить запрос'));
    }

    $oldusercount = rcl_get_user_balance($request->user_rq);
    $newusercount = $oldusercount + $request->count_rq;

    rcl_update_user_balance($newusercount,$request->user_rq,__('Refund with lock on request','rcl-wallet'));

    $subject = __('The withdrawal request was cancelled','rcl-wallet');
    $textmail = '
    <p>'.__('Your request for withdrawal has been rejected','rcl-wallet').'.</p>
    <h3>'.__('Information about the transfer','rcl-wallet').':</h3>
    <p>'.__('The amount of the transfer','rcl-wallet').': '.$request->count_rq.'</p>
    <p>'.__('Account number','rcl-wallet').': '.$request->comment_rq.'</p>'
    . '<p>'.__('The blocked funds were returned to your personal account','rcl-wallet').'</p>';
    $admin_email = get_the_author_meta('user_email',$request->user_rq);
    rcl_mail($admin_email, $subject, $textmail);

}

function mw_admin_success_request($id_row){
    global $wpdb,$user_ID,$rcl_options;

    $old_req = mw_get_request($id_row);

    if(!$old_req){
        wp_die(__('Не удалось найти запрос'));
    }

    if($rcl_options['percent_output_request'])
        $output = $old_req->count_rq - round(($old_req->count_rq*$rcl_options['percent_output_request']/100),2);
    else
        $output = $old_req->count_rq;

    $wpdb->update( RCL_PREF .'wallet_request',
        array( 'output_rq' => $output,'status_rq' => 2),
        array( 'ID' => $id_row )
    );

    add_wallet_history_row($old_req->count_rq,$old_req->user_rq,__('For a withdrawal to','rcl-wallet').' '.$old_req->comment_rq,1);

    $subject = __('The request for withdrawal is made','rcl-wallet');
    $textmail = '
    <p>'.__('Your request for withdrawal has been approved','rcl-wallet').'.</p>
    <h3>'.__('Information about the transfer','rcl-wallet').':</h3>
    <p>'.__('The amount of the transfer','rcl-wallet').': '.$output.'</p>
    <p>'.__('Account number','rcl-wallet').': '.$old_req->comment_rq.'</p>';
    $admin_email = get_the_author_meta('user_email',$old_req->user_rq);
    rcl_mail($admin_email, $subject, $textmail);

}