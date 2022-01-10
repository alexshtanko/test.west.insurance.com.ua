jQuery(document).ready(function($) {

    RemoveNumberOfBlanks();
    
    RemoveBtn();

    function RemoveBtn(){

        $('body').on('click', '.js-remove-btn', function(e){
            
            $(this).parents('.manage-column').find('.delete-agree').addClass('show');
           
        });

        $('body').on('click', '.js-remove-btn-cancel', function(e){
            
            $(this).parents('.manage-column').find('.delete-agree').removeClass('show');
           
        });

    }

	function RemoveNumberOfBlanks(){

		$('body').on('click', '.js-remove-number-of-blanks', function(e){

            e.preventDefault();
            
            base = $(this);
            blank_id = $(this).attr('data-id')*1;
           
            if( blank_id != '' ){
                   
                //Создаем данные для передачи
                var data = {
                    action: 'covidadminremovenumberofblanks',
                    nonce: covidAdminRemoveNumberOfBlanks.nonce,
                    id: blank_id,
                };

                //Отправляем данные
                var jqXHR = $.post( covidAdminRemoveNumberOfBlanks.ajaxurl, data, function(response) {
                    // console.log(response);
                });

                //Если получили статус 200
                jqXHR.done(function(response){

                    data = JSON.parse(response);
                    console.log(data.message);
                    console.log(data.status);
                    console.log(data.blanks);

                    base.parents('.manage-column').find('.delete-agree').removeClass('show');

                    $('.js-message').html('<span class="color-green">' + data.message + '</span>');
                    messageReset();

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
			
		})
    }

    function messageReset( delay = 5000 ){
         //Убираем сообщение через 5 сек
         setTimeout(function(){
            $('.js-message').html('');

        }, delay);
    }

    function LoadCompany(){

        //Создаем данные для передачи
        var data = {
            action: 'covidcompanylist',
            nonce: covidAdminCompanyList.nonce,
        };

        //Отправляем данные
        var jqXHR = $.post( covidAdminCompanyList.ajaxurl, data, function(response) {
            // console.log(response);
        });

        //Если получили статус 200
        jqXHR.done(function(response){

            console.log('Сообщение: ' + response );

            $('#covidCompanyList').html(response);

        });

        //Если была ошибка
        jqXHR.fail(function(response){

            console.log(response);

            alert('Сервер занят, попробуйте немного позже');

        });

    }
});