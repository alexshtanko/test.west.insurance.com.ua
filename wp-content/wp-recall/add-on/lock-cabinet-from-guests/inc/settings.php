<?php

function lcg_settings($options){
    $opt = new Rcl_Options(__FILE__);
    $options .= $opt->options('Настройки Lock Cabinet From Guests', array(
        $opt->option_block(
            array(
                $opt->label('Как будем ограничивать доступ в кабинет?'),
                $opt->option('select', array(
                    'name' => 'lcg_variant',
                    'default' => 'Кабинет с ограничением',
                    'parent' => true,
                    'options' => array('cab' => 'Пускаем в кабинет с ограничением', 'no_cab' => 'Редирект из кабинета',)
                )),
                $opt->child(                            //подчиненный блок
                        array(
                            'name' => 'lcg_variant',    //атрибут name родителя
                            'value' => 'cab'            //значение опции родителя
                        ),
                        array(                          //далее содержимое скрытого блока
                            $opt->label('<br/>Установите своё сообщение:'),
                            $opt->option('textarea', array(
                                'name' => 'lcg_message',
                            )),
                            $opt->notice('По умолчанию: <strong>Содержимое кабинета доступно авторизованным пользователям</strong><br/><br/>'),
                            $opt->label('Закрыть "Подробную информацию" пользователя?'),
                            $opt->option('select', array(
                                'name' => 'lcg_uinfo',
                                'options' => array(1 => 'Да', 0 => 'Нет')
                            )),
                            $opt->help('Эта опция не позволит неавторизованному пользователю смотреть блок "Подробная информация"'),
                            $opt->label('<br/>Не закрывать эти вкладки:'),
                            $opt->option('textarea', array(
                                'name' => 'lcg_tabs',
                            )),
                            $opt->help('Укажите вкладки, контент которых будет показан в кабинете гостю. <br/><br/>'
                                    . 'Надо указать id вкладки. Он содержится в атрибуте <strong>data-tab="feed_90"</strong><br/>'
                                    . 'feed_90 и будет нужный id.<br/><br/>'
                                    . 'Подробней как получить id вкладки <a target="_blank" href="https://codeseller.ru/products/lock-cabinet-from-guests/">ЗДЕСЬ</a>'),
                            $opt->notice('Через запятую. Например: <strong>groups, publics</strong>'),
                        )
                ),
                $opt->child(    //подчиненный 2 блок
                        array(
                            'name' => 'lcg_variant',
                            'value' => 'no_cab'
                        ),
                        array(
                            $opt->label('<br/>Куда перенаправим пользователя?'),
                            $opt->option('text', array(
                                'name' => 'lcg_redirect',
                            )),
                            $opt->help('Когда незалогиненный пользователь посетит чей-то личный кабинет, сработает редирект и переправит его на нужную нам страницу<br/><br/>'
                                    . 'Например на этой странице мы можем подготовить для него мотивационный материал, где красочно распишем преимущества зарегистрированного пользователя'),
                            $opt->notice('Урл вида: <strong>http://ваш-сайт/целевая-страница/</strong><br/><br/>'
                                    . 'Если пусто - редирект на главную страницу сайта'),
                        )
                ),
            )
        )
    ));
    return $options;
}
add_filter('admin_options_wprecall','lcg_settings');