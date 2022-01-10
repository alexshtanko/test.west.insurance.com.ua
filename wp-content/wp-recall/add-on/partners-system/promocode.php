<?php

//выводим поле промокода в дефолтных полях
add_filter('rcl_default_profile_fields','ps_add_promocode_field');
function ps_add_promocode_field($fields){

    if(!ps_get_option('promocode')) return $fields;
    
    $fields[] = array(
        'type' => 'text',
        'slug' => 'ps_promocode',
        'title' => __('Укажите промокод')
    );
    
    return $fields;
}

//скрываем некоторые опции поля
add_filter('rcl_custom_field_options','ps_edit_field_options',10,3);
function ps_edit_field_options($options, $field, $type){
    
    if(!ps_get_option('promocode')) return $options;
    
    if($type != 'profile' || !rcl_is_register_open()) return $options;
    
    if($field['slug'] != 'ps_promocode') return $options;
    
    $unset = array(
        'filter',
        'admin',
        'req'
    );
    
    foreach($options as $k => $option){
                
        if(in_array($option['slug'],$unset)){
            unset($options[$k]);
        }

    }
    
    return $options;
    
}

//скрываем значение поля в профиле
add_filter('custom_field_profile','ps_edit_office_profile_fields',10);
function ps_edit_office_profile_fields($field){
    
    if(!ps_get_option('promocode')) return $field;

    if($field['slug'] == 'ps_promocode') return false;

    return $field;
    
}

function ps_get_promocode($user_id){
    require_once 'classes/class-hash.php';
    
    $h36 = new Hash36();
    
    return $h36->encode($user_id);
    
}

function ps_decode_promocode($code){
    require_once 'classes/class-hash.php';
    
    $h36 = new Hash36();
    
    return $h36->decode($code);
}

