jQuery(document).ready(function($) {

	AddCompany();

    UploadImage();

    function UploadImage(){

        $('.js-upload-image').on('click', function(){
            var send_attachment_bkp = wp.media.editor.send.attachment;
            var button = $(this);
            wp.media.editor.send.attachment = function(props, attachment) {
                // $(button).parent().prev().attr('src', attachment.url);
                // $(button).prev().val(attachment.id);
                // $('.js-upload-image-input').attr('data-src', attachment.url);
                $('.js-upload-logo-img-wrapper').html('<img src="'+ attachment.url +'" alt="">');
                $('.js-upload-image-input').val(attachment.id);
                wp.media.editor.send.attachment = send_attachment_bkp;
            }
            wp.media.editor.open(button);
            return false; 
        });
    }

	function AddCompany(){


		$('body').on('click', '#addCompany', function(e){

			e.preventDefault();
			
            companyName = $('#companyName').val();
            companyLogoUrl = $('.js-upload-logo-img-wrapper img').attr('src');
            companyLogoId = $('.js-upload-image-input').val()*1;

            if( ! companyName == '' ){
                
                //Создаем данные для передачи
                var data = {
                    action: 'covidaddcompany',
                    nonce: covidAdminAddCompany.nonce,
                    company_name: companyName,
                    company_logo_url: companyLogoUrl,
                    company_logo_id: companyLogoId,
                };

                // console.log(user_club_title);

                //Отправляем данные
                var jqXHR = $.post( covidAdminAddCompany.ajaxurl, data, function(response) {
                    // console.log(response);
                });

                //Если получили статус 200
                jqXHR.done(function(response){

                    // $('#aBidMessage .acf-input').text(response);

                    data = JSON.parse(response);

                    // console.log('Сообщение: ' + data.message + 'Название компании: ' + data.company_name);

                    //Обнуляем значение инпута
                    $('#companyName').val('');
                    //Выводим сообщщение
                    $('#companyMessage').text(data.message);
                    //Убираем сообщение через 5 сек
                    setTimeout(function(){
                        $('#companyMessage').text('');
                    }, 5000);

                    //Обновить таблицу бланков
                    if( data.status ){
                        LoadCompany();
                    }


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
    
    function LoadCompany(){

        //Создаем данные для передачи
        var data = {
            action: 'covidcompanylist',
            nonce: covidAdminCompanyList.nonce,
        };

        // console.log(user_club_title);

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