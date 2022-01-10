jQuery(document).ready(function($) {

	AddNumberOfBlanks();

	function AddNumberOfBlanks(){


		$('body').on('click', '#sbmtAddNumberOfBlanks', function(e){

            e.preventDefault();

            blank_type_id = $('#blankTypeId').val()*1;
            company_id = $('#CompanyId').val()*1;
            blank_series = $('#blanksSeries').val();
            blank_number_start = $('#blanksNumberStart').val()*1;
            blank_number_end = $('#blanksNumberEnd').val()*1;
            blank_comments = $('#blanksComments').val();

            status = 0;

            console.log( 'blank_comments: ' + blank_comments );

            if( blank_type_id == 1 ){

                if( company_id != '' && blank_series != '' && blank_number_start != '' && blank_number_end != '' ){

                    if( blank_number_end > blank_number_start  ){

                        status = 1;


                        //Создаем данные для передачи
                        var data = {
                            action: 'insuranceaddnumberofblanks',
                            nonce: insuranceAdminAddNumberOfBlanks.nonce,
                            blank_type_id: blank_type_id,
                            company_id: company_id,
                            blank_series: blank_series,
                            blank_number_start: blank_number_start,
                            blank_number_end: blank_number_end,
                            blank_comments: blank_comments,
                        };

                    }
                    else{

                        status = 0;

                        $('.js-message').html('<span class="color-red">Поле "Нумерація бланка від" має бути більшим за поле "Нумерація бланка до"</span>');
                        messageReset(6000);

                    }

                }
                else{
                    $('.js-message').html('<span class="color-red">Заповніть усі поля у формі.</span>');
                    messageReset(5000);
                    status = 0;
                }


            }
            else if ( blank_type_id == 2 ){

                if( company_id != '' && blank_number_start != '' && blank_number_end != '' ){

                    if( blank_number_end > blank_number_start  ){

                        status = 1;

                        //Создаем данные для передачи
                        var data = {
                            action: 'insuranceaddnumberofblanks',
                            nonce: insuranceAdminAddNumberOfBlanks.nonce,
                            blank_type_id: blank_type_id,
                            company_id: company_id,
                            blank_series: blank_series,
                            blank_number_start: blank_number_start,
                            blank_number_end: blank_number_end,
                            blank_comments: blank_comments,
                        };


                    }
                    else{

                        status = 0;

                        $('.js-message').html('<span class="color-red">Поле "Нумерація бланка від" має бути більшим за поле "Нумерація бланка до"</span>');
                        messageReset(6000);

                    }

                }
                else{

                    status = 0;

                    $('.js-message').html('<span class="color-red">Заповніть усі поля у формі.</span>');
                    messageReset(5000);
                }

            }
            else{

                status = 0;

                $('.js-message').html('<span class="color-red">Оберіть тип бланка.</span>');
                messageReset(5000);

            }

            if( status == 1 ){

                //Отправляем данные
                var jqXHR = $.post( insuranceAdminAddNumberOfBlanks.ajaxurl, data, function(response) {
                    // console.log(response);
                });

                //Если получили статус 200
                jqXHR.done(function(response){
                    // console.log(response);
                    // $('#aBidMessage .acf-input').text(response);

                    data = JSON.parse(response);
                    console.log(data.message);

                    $('.js-message').html('<span class="color-green">' + data.message + '</span>');
                    messageReset();

                    $('.js-number-of-blanks-list').html( data.blanks );
                    $('#blanksNumberStart').val('');
                    $('#blanksNumberEnd').val('');
                    $('#blanksComments').val('');

                });

                //Если была ошибка
                jqXHR.fail(function(response){

                    console.log(response);

                    alert('Сервер занят, попробуйте немного позже');

                });

                return false;

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

    }



    /*
    * Скрывает или показывает поля в зависимости от типа выбранного бланка
    * Скрываем если тип бланка "Электронный"
    * Показываем если "С бумаги"
    * */

    // ShowHideInput();

    function ShowHideInput(){

        $('#blankTypeId').on('change', function(){
            blank_type_id = $(this).val();

            if( blank_type_id == 1 ){
                $('#CompanyId, #blanksSeries').removeClass('hide');
            }
            else if( blank_type_id == 2 ){
                $('#CompanyId, #blanksSeries').addClass('hide');
            }
        });

    }
});