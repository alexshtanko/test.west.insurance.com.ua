jQuery(document).ready(function($) {

    FilterNumberOfBlanks();
    
    FilterReset();

    function FilterReset(){

        $('body').on('click', '#resetNumberOfBlank', function(e){

            e.preventDefault();
            			
            blank_id = 0;

            console.log('blank id: ' + blank_id);

            if( blank_id == 0 ){
                    
                //Создаем данные для передачи
                var data = {
                    action: 'covidadminfilternumberofblanks',
                    nonce: covidAdminFilterNumberOfBlanks.nonce,
                    blank_id: blank_id
                };

                //Отправляем данные
                var jqXHR = $.post( covidAdminFilterNumberOfBlanks.ajaxurl, data, function(response) {

                });

                //Если получили статус 200
                jqXHR.done(function(response){

                    data = JSON.parse(response);

                    $('.js-number-of-blanks-list').html( data.blanks );

                });

                //Если была ошибка
                jqXHR.fail(function(response){

                    console.log(response);

                    alert('Сервер занят, попробуйте немного позже');

                });

                return false;
               
                
            }
            else{
                $('.js-message').html('<span class="color-red">Заповніть усі поля у формі.</span>');
                messageReset(5000);
            }

            return false;

            
        });
    }



	function FilterNumberOfBlanks(){


		$('body').on('click', '#sbmtNumberOfBlank', function(e){

            e.preventDefault();
            			
            blank_id = $('#NumberOfBlank').val()*1;

            console.log('blank id: ' + blank_id);

            if( blank_id != '' ){
                    
                //Создаем данные для передачи
                var data = {
                    action: 'covidadminfilternumberofblanks',
                    nonce: covidAdminFilterNumberOfBlanks.nonce,
                    blank_id: blank_id,
                };

                //Отправляем данные
                var jqXHR = $.post( covidAdminFilterNumberOfBlanks.ajaxurl, data, function(response) {

                });

                //Если получили статус 200
                jqXHR.done(function(response){

                    data = JSON.parse(response);

                    $('.js-number-of-blanks-list').html( data.blanks );

                });

                //Если была ошибка
                jqXHR.fail(function(response){

                    console.log(response);

                    alert('Сервер занят, попробуйте немного позже');

                });

                return false;
               
                
            }
            else{
                messageReset(5000);
            }

            return false;
			
		})
    }

    function messageReset( delay = 5000 ){
         //Убираем сообщение через 5 сек
         setTimeout(function(){
            $('.js-message').html('');

        }, delay);
    }

});