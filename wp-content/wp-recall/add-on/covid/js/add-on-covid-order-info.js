jQuery(document).ready(function($) {

	OrderMoreInfo();

	function OrderMoreInfo(){
        
		$('body').on('click', '.js-get-covid-order-info', function(e){

			e.preventDefault();
			
            base = $(this);
            order_id = base.attr('data-order-id')*1;
                
            //Создаем данные для передачи
            var data = {
                action: 'covid_order_info',
                ajax_nonce : Rcl.nonce, // проверочный ключ безопасности
                order_id: order_id,
                // nonce: addOnInsurance.nonce,
            };


            // ajax post запрос
            jQuery.post({
                url: Rcl.ajaxurl, // путь до вордпресс обработчика ajax
                dataType: "json", // тип данных с которыми работаем
                data: data, // массив наших данных (сформировали выше)
                success: function(response){ // при успешном возврате
                    // console.log(response);
                    console.log('success');
                    $('#my-modal-id div').html(response);
                    $('a.show-modal-data').click();
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

    RemovalRequest();

    function RemovalRequest(){

        $('body').on('click', '.js-covid-removal-request', function(e){

            e.preventDefault();

            base = $(this);

            order_id = base.attr('data-order-id')*1;
            unicue_code = base.attr('data-unicue-code');
            blank_number = base.attr('data-blank-number');
            blank_series = base.attr('data-blank-series');

            console.log('order_id: ' + order_id);

            //Создаем данные для передачи
            var data = {
                action: 'covid_removal_request',
                ajax_nonce : Rcl.nonce, // проверочный ключ безопасности
                order_id: order_id,
                unicue_code: unicue_code,
                blank_number: blank_number,
                blank_series: blank_series,
                // nonce: addOnInsurance.nonce,
            };

            // ajax post запрос
            jQuery.post({
                url: Rcl.ajaxurl, // путь до вордпресс обработчика ajax
                dataType: "json", // тип данных с которыми работаем
                data: data, // массив наших данных (сформировали выше)
                success: function(response){ // при успешном возврате
                    // console.log(response);
                    // console.log('success');
                    $('#my-modal-id div').html(response);
                    $('a.show-modal-data').click();
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

    SendEmail();

    function SendEmail(){

        $('body').on('click', '#covidSendRemovalRequest', function(e){

            e.preventDefault();

            base = $(this);

            order_id = base.attr('data-order-id')*1;
            status = $('#removalRequestStatus').val();
            comment = $('#removalRequestComments').val();
            unicue_code = base.attr('data-unicue-code');
            blank_number = base.attr('data-blank-number');
            blank_series = base.attr('data-blank-series');

            console.log('order_id: ' + order_id + ' status: ' + status + ' comment: ' +comment + " unicue_code: "
                + unicue_code + ' blank_number: ' + blank_number + ' blank_series: ' + blank_series);


            //Создаем данные для передачи
            var data = {
                action: 'covid_send_email',
                ajax_nonce : Rcl.nonce, // проверочный ключ безопасности
                order_id: order_id,
                status: status,
                comment: comment,
                unicue_code: unicue_code,
                blank_number: blank_number,
                blank_series: blank_series,
                // nonce: addOnInsurance.nonce,
            };

            // ajax post запрос
            jQuery.post({
                url: Rcl.ajaxurl, // путь до вордпресс обработчика ajax
                dataType: "json", // тип данных с которыми работаем
                data: data, // массив наших данных (сформировали выше)
                success: function(response){ // при успешном возврате
                    
                    console.log('Send Email');
                    // console.log('order_date_added: ' + data.order_date_added );
                    
                    $('.js-form-message').html('<span style="color: green; width: 100%; text-align: center; display: block">Запит успішно надіслано адміністратору сайта.</span>');
                    $('#removalRequestComments').val('');
                    // $('#my-modal-id div').html(response);
                    // $('a.show-modal-data').click();
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