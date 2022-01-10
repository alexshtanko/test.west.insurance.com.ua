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


	DeleteCompany();

	function DeleteCompany(){

		$('#insuranceCompanyList').on('click', '.js-delete-company',  function(e){
            console.log('delete company');
			e.preventDefault();
			
            companyId = $(this).attr('data-id')*1;

            if( ! companyId == '' ){
                
                //Создаем данные для передачи
                var data = {
                    action: 'insurancedeletecompany',
                    nonce: insuranceAdminDeleteCompany.nonce,
                    id: companyId,

                };

                //Отправляем данные
                var jqXHR = $.post( insuranceAdminDeleteCompany.ajaxurl, data, function(response) {
                    // console.log(response);
                });

                //Если получили статус 200
                jqXHR.done(function(response){

                    data = JSON.parse(response);

                    //Обновить таблицу бланков
                    if( data.status ){
                        LoadCompany();

                        $('.js-message-area').text( data.message );
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
    
    function LoadCompany(){

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