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
                    action: 'insuranceadminfilternumberofblanks',
                    nonce: insuranceAdminFilterNumberOfBlanks.nonce,
                    blank_id: blank_id
                };

                //Отправляем данные
                var jqXHR = $.post( insuranceAdminFilterNumberOfBlanks.ajaxurl, data, function(response) {
                    // console.log(response);
                });

                //Если получили статус 200
                jqXHR.done(function(response){
                    // console.log(response);
                    // $('#aBidMessage .acf-input').text(response);

                    data = JSON.parse(response);
                    // console.log(data.message);
                    // console.log('id: ' + data.id);
                    // console.log('blanks: ' + data.blanks);


                    // $('.js-message').html('<span class="color-green">' + data.message + '</span>');
                    // messageReset();

                    $('.js-number-of-blanks-list').html( data.blanks );
                    // $('#blanksNumberStart').val('');
                    // $('#blanksNumberEnd').val('');

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
                    action: 'insuranceadminfilternumberofblanks',
                    nonce: insuranceAdminFilterNumberOfBlanks.nonce,
                    blank_id: blank_id,
                    // blank_number_start: blank_number_start,
                    // blank_number_end: blank_number_end,

                };

                // console.log(user_club_title);

                //Отправляем данные
                var jqXHR = $.post( insuranceAdminFilterNumberOfBlanks.ajaxurl, data, function(response) {
                    // console.log(response);
                });

                //Если получили статус 200
                jqXHR.done(function(response){
                    // console.log(response);
                    // $('#aBidMessage .acf-input').text(response);

                    data = JSON.parse(response);
                    // console.log(data.message);
                    // console.log('id: ' + data.id);
                    // console.log('blanks: ' + data.blanks);


                    // $('.js-message').html('<span class="color-green">' + data.message + '</span>');
                    // messageReset();

                    $('.js-number-of-blanks-list').html( data.blanks );
                    // $('#blanksNumberStart').val('');
                    // $('#blanksNumberEnd').val('');

                });

                //Если была ошибка
                jqXHR.fail(function(response){

                    console.log(response);

                    alert('Сервер занят, попробуйте немного позже');

                });

                return false;
               
                
            }
            else{
                // $('.js-message').html('<span class="color-red">Заповніть усі поля у формі.</span>');
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

    /*function LoadCompany(){

        //Создаем данные для передачи
        var data = {
            action: 'insurancecompanylist',
            nonce: insuranceAdminCompanyList.nonce,
        };

        // console.log(user_club_title);

        //Отправляем данные
        var jqXHR = $.post( insuranceAdminCompanyList.ajaxurl, data, function(response) {
            // console.log(response);
        });

        //Если получили статус 200
        jqXHR.done(function(response){

            console.log('Сообщение: ' + response );

            $('#insuranceCompanyList').html(response);

        });

        //Если была ошибка
        jqXHR.fail(function(response){

            console.log(response);

            alert('Сервер занят, попробуйте немного позже');

        });

    }*/
});