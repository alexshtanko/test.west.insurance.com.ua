jQuery(document).ready(function($) {

	BlankLIst();

	function BlankLIst(){
        
        //Создаем данные для передачи
        var data = {
            action: 'insuranceprogramlist',
            nonce: insuranceAdminProgramList.nonce,
        };

        // console.log(user_club_title);

        //Отправляем данные
        var jqXHR = $.post( insuranceAdminProgramList.ajaxurl, data, function(response) {
            // console.log(response);
        });

        //Если получили статус 200
        jqXHR.done(function(response){

            // console.log('Сообщение: ' + response );

            $('#insuranceProgramList').html(response);

        });

        //Если была ошибка
        jqXHR.fail(function(response){

            console.log(response);

            alert('Сервер занят, попробуйте немного позже');

        });

			
    }
});