<?php

class MW_History extends Rcl_Query{

    function __construct() {

        $table = array(
            'name' => RCL_PREF ."wallet_history",
            'as' => 'wallet_history',
            'cols' => array(
                'ID',
                'user_id',
                'count_pay',
                'user_balance',
                'comment_pay',
                'time_pay',
                'type_pay'
            )
        );

        parent::__construct($table);
    }

}

class MW_Request extends Rcl_Query{

    function __construct() {

        $table = array(
            'name' => RCL_PREF ."wallet_request",
            'as' => 'wallet_request',
            'cols' => array(
                'ID',
                'user_rq',
                'count_rq',
                'output_rq',
                'comment_rq',
                'time_rq',
                'status_rq'
            )
        );

        parent::__construct($table);
    }

}