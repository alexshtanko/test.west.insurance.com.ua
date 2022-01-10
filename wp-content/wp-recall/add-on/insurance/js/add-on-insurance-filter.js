jQuery(document).ready(function($) {

	OrderFilter();

	function OrderFilter(){
        
		$('.js-insurance-order-filter-btn').on('click', function(e){

            e.preventDefault();
            base = $(this);
            user_id = base.parents('.add-on-insurance-filetr-wrapper').find('select').val()*1;

            base.text('Фільтрація');

            // console.log( user_id );
			                
            //Создаем данные для передачи
            var data = {
                action: 'order_filter',
                ajax_nonce : Rcl.nonce, // проверочный ключ безопасности
                user_id: user_id,
            };


            // ajax post запрос
            jQuery.post({
                url: Rcl.ajaxurl, // путь до вордпресс обработчика ajax
                dataType: "json", // тип данных с которыми работаем
                data: data, // массив наших данных (сформировали выше)
                success: function(response){ // при успешном возврате
                    // console.log(response);
                    // console.log('success');

                    $('.js-insurance-order-filter-btn').text('Фільтрувати');

                    //Render orders
                    $('.js-add-on-insurance-rate-list-wrapper').html(response.orders);

                    //Render pagination
                    $('.js-add-on-insurance-pagination').html(response.pagination);
                    
                },
                complete: function(response){ // ajax-запрос завершился
                    // console.log('Conplete');
                    
                },
                error: function(){
                    alert('Сервер зйнятий, спробуйте пізніше.');
                }
            });
            return false;

		})
    }
    
   
});