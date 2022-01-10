jQuery(document).ready(function($) {

	OrderFilter();

	function OrderFilter(){
        
		$('body').on('click', '.js-get-order-excell', function(e){

            e.preventDefault();
            base = $(this);
            order_id = base.attr('data-order-id')*1;
            

            console.log( order_id );
			                
            //Создаем данные для передачи
            var data = {
                action: 'get_excell_order',
                ajax_nonce : Rcl.nonce, // проверочный ключ безопасности
                order_id: order_id,
            };


            // ajax post запрос
            jQuery.post({
                url: Rcl.ajaxurl, // путь до вордпресс обработчика ajax
                dataType: "json", // тип данных с которыми работаем
                data: data, // массив наших данных (сформировали выше)
                success: function(response){ // при успешном возврате
                    console.log(response);
                    console.log('success');

                    
                    
                },
                complete: function(response){ // ajax-запрос завершился
                    console.log('Conplete');
                    
                },
                error: function(){
                    alert('Сервер зйнятий, спробуйте пізніше.');
                }
            });
            return false;

		})
    }
    
   
});