<?php

require_once 'class-query-table.php';
require_once 'functions-database.php';
require_once 'functions-ajax.php';

if(is_admin()){
    require_once 'admin/index.php';

}

if (!is_admin()):
    add_action('rcl_enqueue_scripts','rcl_wallet_scripts',10);
endif;

function rcl_wallet_scripts(){
    rcl_enqueue_style('rcl-wallet',rcl_addon_url('style.css', __FILE__));
    rcl_enqueue_script( 'rcl-wallet', rcl_addon_url('js/scripts.js', __FILE__) );
}

add_action('plugins_loaded', 'rcl_wallet_load_plugin_textdomain',10);
function rcl_wallet_load_plugin_textdomain(){
    load_textdomain( 'rcl-wallet', rcl_addon_path(__FILE__) . '/languages/rcl-wallet-'. get_locale() . '.mo' );
}

add_filter('rcl_init_js_variables','rcl_init_js_wallet_variables',10);
function rcl_init_js_wallet_variables($data){
    $data['local']['transfer_funds'] = __('The transfer of funds','rcl-wallet');
    $data['local']['transfer'] = __('Transfer','rcl-wallet');
    $data['local']['enter_transfer_sum'] = __('Enter the transfer amount','rcl-wallet');
    $data['local']['enter_int'] = __('Specify the number of','rcl-wallet');
    $data['local']['are_you_sore'] = __('You seriously?','rcl-wallet');
    $data['local']['insufficient_funds'] = __('Insufficient funds on personal account!','rcl-wallet');
    return $data;
}

add_action('init','rcl_add_block_wallet_button');
function rcl_add_block_wallet_button(){
    rcl_block('actions','add_wallet_count_button_user_lk',array('public'=>-1));
}

function add_wallet_count_button_user_lk($author_lk){
    global $user_ID,$rcl_options;
    if(!isset($rcl_options['output_pay_other_user'])||$rcl_options['output_pay_other_user']!=1)  return false;

    return rcl_get_button(__('Make transfer','rcl-wallet'),'#',array(
        'icon' => 'fa-money',
        'class' => 'view-count-form',
        'attr' => 'onclick="mw_load_user_transfer_form('.$author_lk.');return false;"'
    ));
}

add_action('rcl_add_user_balance','add_wallet_history_row',10,3);
add_action('rcl_pre_update_user_balance','add_wallet_history_row',10,3);
function add_wallet_history_row($money,$user_id,$comment,$type=false){
    global $wpdb;

    $time_action = current_time('mysql');

    if(doing_action('rcl_add_user_balance')){
        $type = 2;
        $newBalance = rcl_get_user_balance($user_id);
        $count = $money;
    }else if(doing_action('rcl_pre_update_user_balance')){
        $oldBalance = rcl_get_user_balance($user_id);
        $type = ($oldBalance>$money)? 1: 2;
        $newBalance = $money;
        if($type==1){
            $count = $oldBalance-$money;
        }else if($type==2){
            $count = $money-$oldBalance;
        }
    }else{
        $newBalance = rcl_get_user_balance($user_id);
        $count = $money;
    }

    $res = $wpdb->insert(
        RCL_PREF.'wallet_history',
        array(
            'user_id' => $user_id,
            'count_pay' => round($count, 2),
            'user_balance' => $newBalance,
            'comment_pay' => $comment,
            'time_pay' => $time_action,
            'type_pay' => $type
        )
    );

    do_action('add_wallet_history_row',$wpdb->insert_id);

    return $res;
}

add_action('init','add_tab_wallet');
function add_tab_wallet(){

    $args = array(
        'id'=>'wallet',
        'name'=>__('Balance','rcl-recall'),
        'supports'=>array('ajax'),
        'public'=>0,
        'icon'=>'fa-money',
        'content'=>array(
            array(
                'id' => 'wallet',
                'name' => __('История'),
                'callback' => array(
                    'name'=>'mw_wallet_history_tab'
                )
            )
        )
    );



    if(rcl_get_option('output_wallet_request')){
        $args['content'][] = array(
            'id' => 'wallet-request',
            'name' => __('Вывод средств'),
            'callback' => array(
                'name'=>'mw_wallet_requests_tab'
            )
        );
    }

    rcl_tab($args);

}

function mw_wallet_history_tab($master_id){

    $content = '';

    if(function_exists('rcl_get_html_usercount') && rcl_get_option('wallet_usercount', 0)){
        $content .= rcl_get_html_usercount();
        $content .= '<hr>';
    }

    $cnt = mw_count_history(array(
        'user_id' => $master_id
    ));

    if(!$cnt){
        return '<p>'.__('You haven`t had the movements of funds on the personal account','rcl-wallet').'</p>';
    }

    $rclnavi = new Rcl_PageNavi('rcl-wallet', $cnt);

    $history = mw_get_history(array(
        'user_id' => $master_id,
        'number' => 30,
        'offset' => $rclnavi->offset
    ));

    $n = $cnt-$rclnavi->offset;

    $balance = rcl_get_user_balance($master_id);

    $currency = rcl_get_primary_currency(1);

    $content .= '<h3>'.__('The history of balance changes','rcl-wallet').'</h3>';

    $content .= $rclnavi->pagenavi();

    $Table = new Rcl_Table(array(
        'cols' => array(
            array(
                'title' => __('№'),
                'width' => 10, 'align' => 'center'
            ),
            array(
                'title' => __('Дата','rcl-wallet'),
                'width' => 30, 'align' => 'center'
            ),
            array(
                'title' => __('Parish','rcl-wallet').'/'.__('Consumption','rcl-wallet'),
                'width' => 20, 'align' => 'center'
            ),
            array(
                'title' => __('The rest','rcl-wallet'),
                'width' => 25, 'align' => 'center'
            ),
            array(
                'title' => __('Comment','rcl-wallet'),
                'width' => 55
            )
        ),
        'zebra' => 1,
        'border' => array('table', 'cols', 'rows')
    ));

    foreach($history as $pay){

        $user_balance = ($pay->user_balance)? $pay->user_balance.' '.$currency: '-';

        $Table->add_row(array(
            $n--,
            mysql2date('Y-m-d H:i',$pay->time_pay),
            ($pay->type_pay==2? '+ '.$pay->count_pay.' '.$currency: '- '.$pay->count_pay.' '.$currency),
            $user_balance,
            $pay->comment_pay
        ));

    }

    $content .= $Table->get_table();

    $content .= $rclnavi->pagenavi();

    return $content;

}

function mw_wallet_requests_tab($master_id){

    $content = '';

    if(!mw_get_user_request($master_id)){
        $content .= mw_get_request_form();
        $content .= '<hr>';
    }

    $content .= mw_requests_history_tab($master_id);

    return $content;

}

function mw_get_request_form(){

    $min = rcl_get_option('mw_min', 0);
    $default = isset($_COOKIE['rcl_wallet'])? json_decode(wp_unslash($_COOKIE['rcl_wallet'])): false;
    $paySystems = array_map('trim',explode(',',rcl_get_option('pay_system_request')));

    $values = array();
    for($a=0; $a < count($paySystems); $a++){
        $values[$paySystems[$a]] = $paySystems[$a];
    }

    $fields = array(
        array(
            'type' => 'select',
            'title' => __('Платежная система'),
            'slug' => 'pay_system',
            'empty-first' => __('Выберите вариант вывода'),
            'default' => $default->type,
            'required' => 1,
            'values' => $values
        ),
        array(
            'type' => 'text',
            'title' => __('Номер кошелька/счета'),
            'slug' => 'wallet_system',
            'default' => $default->wallet,
            'required' => 1,
        ),
        array(
            'type' => 'number',
            'slug' => 'output_size',
            'title' => __('Сумма запроса'),
            'default' => 0,
            'required' => 1,
            'value_min' => $min? $min: 0,
            'notice' => $min? __('Минимальная сумма запроса').': '.$min.' '.rcl_get_primary_currency(1): ''
        )
    );

    $content = '<h3>'.__('Форма запроса на вывод средств').'</h3>';

    $content .= rcl_get_form(array(
        'onclick' => 'rcl_send_form_data("mw_new_output_request", this);return false;',
        'fields' => $fields,
        'submit' => __('Отправить'),
    ));

    if($perc = rcl_get_option('percent_output_request', 0))
        $content .= '<p>'.sprintf(__('Комиссия запроса на вывод: %s','rcl-wallet'), $perc.' %').'</p>';

    return $content;

}

function mw_requests_history_tab($master_id){

    $content = '<h3>'.__('История запросов на вывод средств','rcl-wallet').'</h3>';

    $cnt = mw_count_requests(array(
        'user_rq' => $master_id
    ));

    if(!$cnt){
        return $content . '<p>'.__('Запросов на вывод еще не было','rcl-wallet').'</p>';
    }

    $rclnavi = new Rcl_PageNavi('rcl-wallet', $cnt);

    $history = mw_get_requests(array(
        'user_rq' => $master_id,
        'number' => 30,
        'offset' => $rclnavi->offset
    ));

    $n = $cnt-$rclnavi->offset;

    $percent = rcl_get_option('percent_output_request', 0);

    $content .= $rclnavi->pagenavi();

    $Table = new Rcl_Table(array(
        'cols' => array(
            array(
                'title' => __('Дата','rcl-wallet'),
                'width' => 30, 'align' => 'center'
            ),
            array(
                'title' => __('Cумма запроса','rcl-wallet'),
                'width' => 20, 'align' => 'center'
            ),
            array(
                'title' => __('Сумма вывода','rcl-wallet'),
                'width' => 20, 'align' => 'center'
            ),
            array(
                'title' => __('Комментарий','rcl-wallet'),
                'width' => 30
            ),
            array(
                'title' => __('Статус','rcl-wallet'),
                'width' => 30
            ),
            array(
                'title' => '',
                'width' => 10, 'align' => 'center'
            )
        ),
        'zebra' => 1,
        'border' => array('table', 'cols', 'rows')
    ));

    foreach($history as $request){

        $output = '';

        if($request->status_rq==1){
            if($percent) $output = ($request->count_rq - round(($request->count_rq*$percent/100),2)).' '.rcl_get_primary_currency(1);
            else $output = $request->count_rq.' '.rcl_get_primary_currency(1);
        }else{
            $output = $request->output_rq.' '.rcl_get_primary_currency(1);
        }

        $status = '';

        if($request->status_rq==1){
            $status = '<span style="color:red;">'.__('Consideration','rcl-wallet').'</span>';
        }
        if($request->status_rq==2){
            $status = '<span style="color:green;">'.__('Made','rcl-wallet').'</span>';
        }

        $Table->add_row(array(
            mysql2date('Y-m-d H:i',$request->time_rq),
            $request->count_rq.' '.rcl_get_primary_currency(1),
            $output,
            $request->comment_rq,
            $status,
            ($request->status_rq==1? '<span style="color:red;" onclick="mw_cancel_request('.$request->ID.');return false;"><i class="fa fa-trash" aria-hidden="true"></i></span>': '')
        ));

    }

    $content .= $Table->get_table();

    $content .= $rclnavi->pagenavi();

    return $content;

}

add_filter('count_widget_rcl','get_output_wallet_count_rcl');
function get_output_wallet_count_rcl($content){
    global $user_ID,$rcl_options,$user_LK;
    if($user_LK||$rcl_options['output_wallet_request']!=1) return $content;
    return $content .= '<a href="'.rcl_format_url(get_author_posts_url($user_ID),'wallet').'" class="recall-button" style="float: left;">'.__('Withdrawal','rcl-wallet').'</a>';
}

