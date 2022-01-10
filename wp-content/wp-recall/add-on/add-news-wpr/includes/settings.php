<?php 
/*********************************************************************/
/**	Name: Add News WP-Recall (Объявление в личном кабинете)			**/
/**	Author Uri: http://wppost.ru/author/ulogin_vkontakte_220251751/	**/
/**	includes/settings.php											**/
/*********************************************************************/

add_filter('admin_options_wprecall','options_add_news_wpr');
function options_add_news_wpr($options){
		
    $opt = new Rcl_Options();
	
    $options .= $opt->options(
        'Add News WP-Recall', array(
		
        $opt->option_block(
            array(
                $opt->title('Основные настройки'),
							
                $opt->label('Показывать объявление'),
                $opt->option('select',array(
                    'name'=>'on_off_addnwpr',
                    'parent'=>true,
                    'options'=>array(
                        'off_addnwpr'=>'Нет',
                        'on_addnwpr'=>'Да',
                        )
                )),
				$opt->notice('Объявление по умолчанию выводится над ЛК пользователя <hr />'),
				
				$opt->child(
					array(
						'name'=>'on_off_addnwpr',
						'value'=>'on_addnwpr'
					),
				
					array(
				
						$opt->label('Заголовок объявления'),
						$opt->option('text',array(
							'name'=>'title_addnwpr')),
				
						$opt->label('Текст объявления'),
						$opt->option('textarea',array(
							'name'=>'text_addnwpr')),

						$opt->notice('</br><hr />'),
						
						$opt->title('Оформление блока объявления'),
						
							$opt->label('Цвет рамки объявления'),
							$opt->option('text',array(
								'name'=>'color_border_addnwpr',
								'default'=>'#DD3333')),
							//$opt->notice('По умолчанию используется красный цвет'),
							
							$opt->label('Ширина рамки объявления в px'),
							$opt->option('text',array(
								'name'=>'border_addnwpr',
								'default'=>'4')),
							$opt->notice('Оставьте поле пустым, если необходимо разместить объявление без рамки'),
							
							$opt->label('Цвет фона объявления'),
							$opt->option('text',array(
								'name'=>'color_backgraund_addnwpr',
								'default'=>'')),
							$opt->notice('По умолчанию не используется заливка фона'),
							
							$opt->label('Цвет заголовка объявления'),
							$opt->option('text',array(
								'name'=>'color_title_addnwpr',
								'default'=>'')),
							$opt->notice('По умолчанию используется цвет вашей темы'),
							
							$opt->label('Цвет текста объявления'),
							$opt->option('text',array(
								'name'=>'color_text_addnwpr',
								'default'=>'')),
							$opt->notice('По умолчанию используется цвет вашей темы'),
							
					)),
				
				$opt->notice('</br><hr /><strong>Доступна расширенная версия "Add News WP-Recall FULL" <a href="https://codeseller.ru/products/add-news-wp-recall-full-razmeshhaem-obyavleniya-ot-administratora-v-kabinetax-polzovatelej-i-ne-tolko/" target="_blank">скачать</a></strong>'),
				
					$opt->notice('вывод объявление в личном кабинете
</br>- вывод объявления с помощью шорткода
</br>- ключение в объявление таймера обратного отсчета
</br>- включение в объявление текста и кнопки призыва к действию
</br>- добавление в объявление кнопки «Закрыть», с применением (cookies)
</br>- расширенные настройки
</br>- срок жизни cookies
</br>- уникальный cookies_key
</br>- настройки стилей (блок объявления, таймер обратного отсчета, призыв к действию)
</br>Новые функции и возможности расширенной весии дополнения по мере его развития будут дополняться!')
            )
        ),

$opt->option_block(
			array(
			
				$opt->title('От автора дополнения'),
				
					$opt->notice('Все замечания и предложения по работе дополнения, пишите в <strong><a href="http://wppost.ru/author/ulogin_vkontakte_220251751/" target="_blank">приватном чате автора</a></strong> дополнения <strong>"Add News WP-Recall"</strong></br></br>'),
						
					$opt->notice('Наш сайт <strong><a href="http://web-blog.su" target="_blank">Web-Blog.su</a></strong>'),
					
					$opt->notice('Наша группа в VK <strong><a href="http://vk.com/web_blog_su" target="_blank">vk.com/web_blog_su</a></strong>'),
					
					// $opt->notice('Мы пишем в своем блоге:<iframe src="http://web-blog.su/lat-art/" width="500" height="105" scrolling="no"></iframe>')
            ))
		)	
   );
     
    return $options;
}