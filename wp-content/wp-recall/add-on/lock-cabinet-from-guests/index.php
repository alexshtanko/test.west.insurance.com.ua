<?php

/*

╔═╗╔╦╗╔═╗╔╦╗
║ ║ ║ ╠╣ ║║║ https://otshelnik-fm.ru
╚═╝ ╩ ╚  ╩ ╩

*/


// подключаем настройки
if( is_admin() && !is_network_admin() ){
    require_once 'inc/settings.php';
}


// закрываем вкладки
function lcg_close_tabs($args){
    if( !rcl_is_office() ) return $args;    //не в кабинете

    if( is_user_logged_in() ) return $args; // авторизован

    if (rcl_get_option('lcg_variant') != 'cab') return $args;       // только когда стоит 'cab'=>'Пускаем в кабинет с ограничением'

    if ($args['id'] == 'chat') return $args;                        // если это Chat - не меняем ничего
    if ($args['id'] == 'fc_float_chat') return $args;               // если это F-Chat - не меняем ничего

    $exclude_tabs = explode(',', rcl_get_option('lcg_tabs') );      // массив исключаемых вкладок
    if ($exclude_tabs){
        foreach ($exclude_tabs as $exclude_tab){
            if ($args['id'] == trim($exclude_tab)) return $args;
        }
    }

    $args['content'] = array_slice($args['content'], 0, 1);         // убираем дочерние вкладки
    $args['content'][0]['callback']['name'] = 'lcg_tab_content';    // контент вкладок подменяем своим

    return $args;
}
add_filter('rcl_pre_output_tab','lcg_close_tabs');


// новая коллбек функция - текст сообщения
function lcg_tab_content(){
    $in_tag = '<span style="background:#fce6db;padding:10px;display:block;text-align:center;">';
    $out = rcl_get_option('lcg_message');
    $out_tag = '</span>';

    $out_filter = apply_filters('ofm_lock_cabinet_after', $out);

    return $in_tag . $out_filter . $out_tag;
}


// удалим блок инфо из авы
function lcg_del_info(){
    if ( !is_user_logged_in() ){
        if (rcl_get_option('lcg_uinfo') != 1) return false;

        remove_filter('rcl_avatar_icons', 'rcl_add_user_info_button', 10);
        add_filter('rcl_avatar_icons', 'lcg_info_button', 10);
    }
}
add_action('init', 'lcg_del_info');


// сообщение в алерте при просмотре подробной инфы
function lcg_info_button($icons){
    $m_sg = rcl_get_option('lcg_message');

    $icons['user-info'] = array(
        'icon' => 'fa-info-circle',
        'atts' => array(
            'title' => __('User info', 'wp-recall'),
            'onclick' => "rcl_notice('$m_sg','error','8000');"
        )
    );

    return $icons;
}


// редирект гостей (неавторизованных) из кабинета на целевую страницу
function lcg_redirect_from_cabinet(){
    if( !rcl_is_office() ) return false; // не в кабинете

    if (rcl_get_option('lcg_variant') != 'no_cab') return false; // не нужен редирект

    if ( !is_user_logged_in() ){
        $lcg_url = ( rcl_get_option( 'lcg_redirect', home_url() ) );

        if (filter_var($lcg_url, FILTER_VALIDATE_URL) === FALSE){
            $lcg_url = home_url();
        }

        wp_redirect($lcg_url);
        exit;
    }
}
add_action('template_redirect', 'lcg_redirect_from_cabinet');
