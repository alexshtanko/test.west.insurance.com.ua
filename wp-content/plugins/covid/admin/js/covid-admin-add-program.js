jQuery(document).ready(function($) {

	AddProgram();

	function AddProgram(){

		$('#addProgram').on('click', function(e){

			e.preventDefault();
			
            programName = $('#programName').val();
            programComments = $('#programComments').val();
            
            if( ! programName == '' ){
                
                //Создаем данные для передачи
                var data = {
                    action: 'covidaddprogram',
                    nonce: covidAdminAddProgram.nonce,
                    program_name: programName,
                    program_comments: programComments,
                };

                // console.log(user_club_title);

                //Отправляем данные
                var jqXHR = $.post( covidAdminAddProgram.ajaxurl, data, function(response) {
                    // console.log(response);
                });

                //Если получили статус 200
                jqXHR.done(function(response){
                    // console.log(response);
                    // $('#aBidMessage .acf-input').text(response);

                    data = JSON.parse(response);

                    // console.log('Сообщение: ' + data.message + 'Название компании: ' + data.program_name);
                    
                    
                    //Выводим сообщщение
                    $('#programMessage').html(data.message);
                    //Убираем сообщение через 5 сек
                    setTimeout(function(){
                        $('#programMessage').text('');
                    }, 5000);

                    //Обновить таблицу бланков
                    if( data.status ){
                        LoadProgram();
                        //Обнуляем значение инпута
                        $('#programName').val('');
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

            // console.log(response);

            alert('Сервер занят, попробуйте немного позже');

        });

    }
});