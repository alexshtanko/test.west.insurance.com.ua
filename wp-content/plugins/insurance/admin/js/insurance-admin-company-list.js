jQuery(document).ready(function($) {

	CompanyLIst();

	function CompanyLIst(){
        
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

            // console.log('Сообщение: ' + response );

            $('#insuranceCompanyList').html(response);

        });

        //Если была ошибка
        jqXHR.fail(function(response){

            console.log(response);

            alert('Сервер занят, попробуйте немного позже');

        });

			
    }
});