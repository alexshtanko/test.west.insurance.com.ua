<?phpadd_action('plugins_loaded', 'rcl_menu_buttons_languages',10);function rcl_menu_buttons_languages(){    load_textdomain( 'rcl-buttons', rcl_addon_path(__FILE__) . '/languages/rcl-buttons-'. get_locale() . '.mo' );}add_filter('admin_options_wprecall','rcl_menu_buttons_options');function rcl_menu_buttons_options($content){    $opt = new Rcl_Options();    $menus = rmb_get_menu_list();    $content .= $opt->options(        (__('Settings Rcl Buttons','rcl-buttons')),        $opt->options_box( __('Основные настройки'),            array(                array(                    'type' => 'checkbox',                    'slug' => 'rmb_menu',                    'title' => __('Site menu','rcl-buttons'),                    'values' => $menus,                    'notice' => __('Mark the menus in which the plug-in buttons will be displayed','rcl-buttons')                ),                array(                    'type' => 'checkbox',                    'slug' => 'rmb_buttons',                    'title' => __('Show link','rcl-buttons'),                    'values' => array(                        'login'=>(__('Log in','rcl-buttons')),                        'register'=>(__('Registration','rcl-buttons')),                        'account'=>(__('Private office','rcl-buttons')),                        'logout'=>(__('Logout','rcl-buttons'))                    )                )            )        )    );    return $content;}function rmb_get_menu_list(){    $menus = wp_get_nav_menus();    if(!$menus) return false;    foreach($menus as $menu){        $options[$menu->slug] = $menu->name;    }    return $options;}if(!is_admin())    add_filter('wp_get_nav_menu_items','rmb_edit_menu_items',10,3);function rmb_edit_menu_items($items, $menu, $args){    global $user_ID,$rcl_options;    if(!isset($rcl_options['rmb_menu'])||!$rcl_options['rmb_menu']) return $items;    $key = array_search($menu->slug,$rcl_options['rmb_menu']);    if($key===false) return $items;    $buttons = rmb_get_buttons();    if(!$buttons) return $items;    $items = array_merge($items,$buttons);    foreach($items as $k=>$item){        if($item->menu_order) continue;        $items[$k]->menu_order = $k+1;    }    return $items;}if(!is_admin())    add_filter('wp_get_nav_menu_object','rmb_edit_get_menu_object',10,2);function rmb_edit_get_menu_object($menu_obj, $menu){    global $rcl_options;    if(!isset($rcl_options['rmb_menu'])||!$rcl_options['rmb_menu']) return $menu_obj;    $key = array_search($menu_obj->slug,$rcl_options['rmb_menu']);    if($key===false) return $menu_obj;    $menu_obj->count = 5;    return $menu_obj;}//if(!is_admin()) add_filter('wp_nav_menu_objects','rmb_edit_menu_object',10,2);function rmb_edit_menu_object($sorted_menu_items, $args){    global $rcl_options;    $key = array_search($args->menu->slug,$rcl_options['rmb_menu']);    if($key===false) return $sorted_menu_items;    return $sorted_menu_items;}function rmb_get_buttons(){    global $user_ID,$rcl_options;    /*$array = array(        array(            'ID'=>'rcl-user-account',            'object' => 'custom',            'type'=>'custom',            'post_title'=>'Профиль',            'title'=>'Профиль',            'url'=>get_author_posts_url($user_ID),            'post_type' => 'nav_menu_item',            'menu_item_parent'=>0,            'classes'=>array('rcl-user-account')        )    );*/    if(is_customize_preview()) return false;    if(!$rcl_options['rmb_buttons']) return false;    if($user_ID){        if(array_search('account',$rcl_options['rmb_buttons'])!==false){            $array[] = array(                'ID'=>'rcl-user-lk',                'object' => 'custom',                'type'=>'custom',                'post_title'=>__('Private office','rcl-buttons'),                'title'=>'<i class="rcli fa-home"></i> '.__('Private office','rcl-buttons'),                'url'=>get_author_posts_url($user_ID),                'post_type' => 'nav_menu_item',                //'menu_item_parent'=>'rcl-user-account',                'classes'=>array('rcl-user-lk')            );        }        if(array_search('logout',$rcl_options['rmb_buttons'])!==false){            $array[] = array(                'ID'=>'rcl-loginout',                'object' => 'custom',                'type'=>'custom',                'post_title'=>__('Logout','rcl-buttons'),                'title'=>'<i class="rcli fa-external-link fa-external-link-alt"></i> '.__('Logout','rcl-buttons'),                'url'=>wp_logout_url('/'),                'post_type' => 'nav_menu_item',                //'menu_item_parent'=>'rcl-user-account',                //'filter'=>'raw',                'classes'=>array('rcl-loginout')            );        }    }else{        if(array_search('login',$rcl_options['rmb_buttons'])!==false){            $array[] = array(                'ID'=>'rcl-login',                'object' => 'custom',                'type'=>'custom',                'post_title'=>__('Log in','rcl-buttons'),                'title'=>'<i class="rcli fa-sign-in fa-sign-in-alt"></i> '.__('Log in','rcl-buttons'),                'url'=>rmb_get_url_button_loginform('login'),                'post_type' => 'nav_menu_item',                //'menu_item_parent'=>'rcl-user-account',                'classes'=>array(                    'rcl-login'                )            );        }        if(array_search('register',$rcl_options['rmb_buttons'])!==false){            $array[] = array(                'ID'=>'rcl-register',                'object' => 'custom',                'type'=>'custom',                'post_title'=>__('Registration','rcl-buttons'),                'title'=>'<i class="rcli fa-book"></i> '.__('Registration','rcl-buttons'),                'url'=>rmb_get_url_button_loginform('register'),                //'menu_item_parent'=>'rcl-user-account',                'post_type' => 'nav_menu_item',                //'filter'=>'raw',                'classes'=>array(                    'rcl-register'                )            );        }    }    if(!$array) return false;    foreach($array as $button){       $buttons[] = (object)$button;    }    return $buttons;}function rmb_get_url_button_loginform($type){    global $rcl_options;    if($type=='login'){        switch($rcl_options['login_form_recall']){            case 1: return rcl_format_url(get_permalink($rcl_options['page_login_form_recall'])).'action-rcl=login'; break;            case 2: return wp_login_url(get_permalink($rcl_options['page_login_form_recall'])); break;            default: return '#'; break;        }    }    if($type=='register'){       switch($rcl_options['login_form_recall']){            case 1: return rcl_format_url(get_permalink($rcl_options['page_login_form_recall'])).'action-rcl=register'; break;            case 2: return wp_registration_url(); break;            default: return '#'; break;        }    }}