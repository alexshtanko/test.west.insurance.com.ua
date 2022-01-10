<?php

rcl_ajax_action('ps_get_form_new_referal');
function ps_get_form_new_referal(){
    global $user_ID;
    
    $users = get_users(array('fields'=>array('ID','display_name')));
    
    $userIds = array();
    foreach($users as $user){
        $userIds[$user->ID] = $user->display_name;
    }
    
    $result = array(
        'dialog' => array(
            'content' => ps_form(array(
                'fields' => array(
                    array(
                        'slug' => 'partner_id',
                        'type' => 'number',
                        'title' => __('Впишите ID партнера'),
                        'required' => 1,
                        //'values' => $userIds,
                        'notice' => __('Впишите ID пользователя для назначения его в качестве партнера для реферала')
                    ),
                    array(
                        'slug' => 'referal_id',
                        'type' => 'number',
                        'title' => __('Впишите ID реферала'),
                        'required' => 1,
                        //'values' => $userIds,
                        'notice' => __('Впишите ID пользователя для закрепления его в качестве реферала для партнера')
                    )
                ),
                'action' => 'edit-partner',
                'onclick' => 'ps_send_form_data("ps_ajax_add_new_partner",this);return false;',
                'submit' => __('Подтвердить выбор')
            )),
            'title' => __('Создание новой связи Партнер-Реферал'),
            'size' => 'auto',
            'class' => 'ps-dialog'
        )
    );
    
    wp_send_json($result);
    
}

rcl_ajax_action('ps_ajax_add_new_partner');
function ps_ajax_add_new_partner(){
    
    $partner_id = intval($_POST['partner_id']);
    $referal_id = intval($_POST['referal_id']);
    
    if($partner_id == $referal_id){
        wp_send_json(array(
            'error' => __('Партнер и реферал должны отличаться!')
        ));
    }
    
    $partID = ps_get_partner($referal_id);
    
    if($partner_id == $partID){
        wp_send_json(array(
            'error' => __('Реферал уже закреплен за этим партнером!')
        ));
    }
    
    if($partID){
        wp_send_json(array(
            'error' => __('Реферал уже закреплен за другим партнером!')
        ));
    }
    
    global $wpdb;

    $wpdb->insert(
        WP_PREFIX.'prt_partners',
        array(
            'partner' => $partner_id,
            'referal' => $referal_id,
            'url'=> $_SERVER['SERVER_NAME'],
            'timeaction'=> current_time('mysql')
        )
    );
    
    wp_send_json(array(
        'reload' => true,
        'success' => __('Новая связь успешно установлена!')
    ));
  
}

rcl_ajax_action('ps_get_form_edit_partner');
function ps_get_form_edit_partner(){
    global $user_ID;
    
    $data_id = $_POST['data_id'];
    
    $users = get_users(array('fields'=>array('ID','display_name')));
    
    $partners = array();
    foreach($users as $user){
        $partners[$user->ID] = $user->display_name;
    }
    
    $result = array(
        'dialog' => array(
            'content' => ps_form(array(
                'fields' => array(
                    array(
                        'slug' => 'partner_id',
                        'type' => 'number',
                        'title' => __('Впишите ID партнера'),
                        'required' => 1,
                        //'values' => $partners,
                        'notice' => __('Впишите ID пользователя для назначения его в качестве партнера для реферала')
                    ),
                    array(
                        'slug' => 'data_id',
                        'type' => 'hidden',
                        'value' => $data_id
                    )
                ),
                'action' => 'edit-partner',
                'onclick' => 'ps_send_form_data("ps_ajax_edit_partner",this);return false;',
                'submit' => __('Подтвердить выбор')
            )),
            'title' => __('Назначение нового партнера для реферала'),
            'size' => 'auto',
            'class' => 'ps-dialog'
        )
    );
    
    wp_send_json($result);
    
}

rcl_ajax_action('ps_ajax_edit_partner');
function ps_ajax_edit_partner(){
    
    $partner_id = intval($_POST['partner_id']);
    $data_id = intval($_POST['data_id']);
    
    ps_update_partners(array(
        'partner' => $partner_id
    ),array(
        'ID' => $data_id
    ));
    
    wp_send_json(array(
        'reload' => true,
        'success' => __('Партнер был успешно переназначен!')
    ));
  
}

rcl_ajax_action('ps_get_form_edit_referal');
function ps_get_form_edit_referal(){
    global $user_ID;
    
    $data_id = $_POST['data_id'];
    
    $users = get_users(array('fields'=>array('ID','display_name')));
    
    $referals = array();
    foreach($users as $user){
        $referals[$user->ID] = $user->display_name;
    }
    
    $result = array(
        'dialog' => array(
            'content' => ps_form(array(
                'fields' => array(
                    array(
                        'slug' => 'referal_id',
                        'type' => 'number',
                        'title' => __('Впишите ID реферала'),
                        'required' => 1,
                        //'values' => $referals,
                        'notice' => __('Впишите ID пользователя для закрепления его в качестве реферала за партнером')
                    ),
                    array(
                        'slug' => 'data_id',
                        'type' => 'hidden',
                        'value' => $data_id
                    )
                ),
                'action' => 'edit-referal',
                'onclick' => 'ps_send_form_data("ps_ajax_edit_referal",this);return false;',
                'submit' => __('Подтвердить выбор')
            )),
            'title' => __('Переназначение реферала для партнера'),
            'size' => 'auto',
            'class' => 'ps-dialog'
        )
    );
    
    wp_send_json($result);
    
}

rcl_ajax_action('ps_ajax_edit_referal');
function ps_ajax_edit_referal(){

    $referal_id = intval($_POST['referal_id']);
    $data_id = intval($_POST['data_id']);
    
    ps_update_partners(array(
        'referal' => $referal_id
    ),array(
        'ID' => $data_id
    ));
    
    wp_send_json(array(
        'reload' => true,
        'success' => __('Реферал был успешно переназначен!')
    ));
  
}