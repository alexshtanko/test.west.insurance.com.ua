<?php

global $rcl_options;

if(!isset($rcl_options['lcg_variant'])) $rcl_options['lcg_variant'] = 'cab';
if(!isset($rcl_options['lcg_message'])) $rcl_options['lcg_message'] = 'Содержимое кабинета доступно авторизованным пользователям';
if(!isset($rcl_options['lcg_uinfo'])) $rcl_options['lcg_uinfo'] = 1;

update_option('rcl_global_options',$rcl_options);