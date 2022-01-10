jQuery(document).ready(function($) {

    UploadCompanyLogo();

    function UploadCompanyLogo(){

        $('body').on('click', '.js-upload-company-logo', function(){
            
            var send_attachment_bkp = wp.media.editor.send.attachment;
            var button = $(this);
            wp.media.editor.send.attachment = function(props, attachment) {
                // $(button).parent().prev().attr('src', attachment.url);
                // $(button).prev().val(attachment.id);
                // $('.js-upload-image-input').attr('data-src', attachment.url);
                $('.js-company-edit-form-logo').find('img').attr('src', attachment.url);
                $('.js-company-edit-form-logo').find('.company-edit-form-company-logo-id').val(attachment.id);
                
                // $('.js-upload-logo-img-wrapper').html('<img src="'+ attachment.url +'" alt="">');
                // $('.js-upload-image-input').val(attachment.id);
                wp.media.editor.send.attachment = send_attachment_bkp;
            }
            wp.media.editor.open(button);
            return false; 
        });
    }

    EditCompany();
    
    InsuranceModalOpen('Редагувати компанiю');

    InsuranceModalClose();

    function InsuranceModalOpen( title ){
        $('body').on('click', '.js-edit-company', function(){

            //Старое название Бланка
            companyTitleOld = $(this).attr('data-company-title');

            companyId = $(this).attr('data-id');
            companyLogoUrl = $(this).attr('data-logo-url');
            companyLogoId = $(this).attr('data-logo-id');

            //Передаем форму
            dataHtml = '<form class="insurance-modal-form" action="" method="POST" name="edit_company"><label for="editcompanyOldName"><div class="company-edit-form-logo js-company-edit-form-logo"><input class="company-edit-form-company-logo-id js-company-edit-form-company-logo-id" type="text" hidden><img src="'+ companyLogoUrl +'" /><div class="clear"></div><button class="upload-btn form-company-logo js-upload-company-logo">Змінити логотип компанії</button></div><div class="clear"></div>Стара назва бланку</label><input class="regular-text" id="editCompanyOldName" name="edit_company_old_name" type="text" readonly="readonly" value="'+ companyTitleOld +'"><label for="editCompanyName">Нова назва бланку</label><input class="regular-text" id="editCompanyName" name="edit_company_name" type="text" placeholder="Введіть назву бланка"><button class="button button-primary button-large insurance-sbmt" id="editCompany" data-company-id="'+ companyId +'"><i class="fa fa-floppy-o"></i> Зберегти</button></form><div class="company-edit-message js-company-edit-message"></div>';

            //Показать модальное окно
            $('#insuranceModal').addClass('show');

            $('#insuranceModal .js-insurance-modal-header-title').text( title );

            $('#insuranceModal .js-insurance-modal-body').html(dataHtml);


        });

        $('body').on('click', '.js-insurance-modal-close', function(){

            //Скрыть модальное окно
            $('#insuranceModal').removeClass('show');

            $('#insuranceModal .js-insurance-modal-header-title').text('');

            $('#insuranceModal .js-insurance-modal-body').html('');


        });
    }

    function InsuranceModalClose( ){
        
        $('body').on('click', '.js-insurance-modal-close', function(){

            //Скрыть модальное окно
            $('#insuranceModal').removeClass('show');

            $('#insuranceModal .js-insurance-modal-header-title').text('');

            $('#insuranceModal .js-insurance-modal-body').html('');


        });
    }

	function EditCompany(){
        

		$('body').on('click', '#editCompany',  function(e){

            console.log('Edit company');

			e.preventDefault();
			
            companyId = $(this).attr('data-company-id')*1;

            companyTitle = $(this).parents('form').find('#editCompanyName').val();
            companyLogoUrl = $('.js-company-edit-form-logo img').attr('src');
            companyLogoId = $('.company-edit-form-company-logo-id').val()*1;

            console.log('companyTitle:' + companyTitle + ' companyId: ' + companyId);

            // if( companyTitle.length > 1 ){
                
                //Создаем данные для передачи
                var data = {
                    action: 'insuranceeditcompany',
                    nonce: insuranceAdminEditCompany.nonce,
                    id: companyId,
                    title: companyTitle,
                    company_logo_url: companyLogoUrl,
                    company_logo_id: companyLogoId,
                };

                //Отправляем данные
                var jqXHR = $.post( insuranceAdminEditCompany.ajaxurl, data, function(response) {
                    // console.log(response);
                });

                //Если получили статус 200
                jqXHR.done(function(response){

                    data = JSON.parse(response);

                    // console.log('Result: ' + data.message + ' ID: ' + data.id + ' Title: ' + data.company_name);

                    // Обновить таблицу бланков
                    if( data.status ){
                        LoadCompany();
                    }

                    //Скрыть модальное окно

                    $('.js-company-edit-message').html( data.message );

                    setTimeout(HideModal, 2500);


                });

                //Если была ошибка
                jqXHR.fail(function(response){

                    // console.log(response);

                    alert('Сервер занят, попробуйте немного позже');

                });

                return false;
                
            // }
			
		})
    }

    function HideModal(){

        $('#insuranceModal').removeClass('show');

        $('#insuranceModal .js-insurance-modal-header-title').text('');

        $('#insuranceModal .js-insurance-modal-body').html('');
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