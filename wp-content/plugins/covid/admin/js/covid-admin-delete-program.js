jQuery(document).ready(function($) {

    RemoveBtn();

    function RemoveBtn(){

        $('body').on('click', '.js-remove-btn', function(e){
            
            $(this).parents('.manage-column').find('.delete-agree').addClass('show');
           
        });

        $('body').on('click', '.js-remove-btn-cancel', function(e){
            
            $(this).parents('.manage-column').find('.delete-agree').removeClass('show');
           
        });

    }


	DeleteProgram();

	function DeleteProgram(){

		$('#covidProgramList').on('click', '.js-delete-program',  function(e){
            // console.log('delete program');
			e.preventDefault();
			
            programId = $(this).attr('data-id')*1;

            if( ! programId == '' ){
                
                //Создаем данные для передачи
                var data = {
                    action: 'coviddeleteprogram',
                    nonce: covidAdminDeleteProgram.nonce,
                    id: programId,

                };

                //Отправляем данные
                var jqXHR = $.post( covidAdminDeleteProgram.ajaxurl, data, function(response) {
                    // console.log(response);
                });

                //Если получили статус 200
                jqXHR.done(function(response){

                    data = JSON.parse(response);

                    //Обновить таблицу бланков
                    if( data.status ){
                        LoadProgram();
                    }


                });

                //Если была ошибка
                jqXHR.fail(function(response){

                    console.log(response);

                    alert('Сервер занят, попробуйте немного позже');

                });

                return false;
                
            }
			
		})
    }
    
    function LoadProgram(){

        //Создаем данные для передачи
        var data = {
            action: 'covidprogramlist',
            nonce: covidAdminProgramList.nonce,
        };

        // console.log(user_club_title);

        //Отправляем данные
        var jqXHR = $.post( covidAdminProgramList.ajaxurl, data, function(response) {
            // console.log(response);
        });

        //Если получили статус 200
        jqXHR.done(function(response){

            // console.log('Сообщение: ' + response );

            $('#covidProgramList').html(response);

        });

        //Если была ошибка
        jqXHR.fail(function(response){

            console.log(response);

            alert('Сервер занят, попробуйте немного позже');

        });

    }
});