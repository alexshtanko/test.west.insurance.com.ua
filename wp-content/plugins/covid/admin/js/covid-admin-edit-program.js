jQuery(document).ready(function($) {

    EditProgram();
    
    CovidModalOpen('Редагувати Бланк');

    CovidModalClose();

    function CovidModalOpen( title ){
        $('body').on('click', '.js-edit-program', function(){

            //Старое название Бланка
            programTitleOld = $(this).attr('data-program-title');

            programId = $(this).attr('data-id');

            programComments = $(this).attr('data-program-comments');

            //Передаем форму
            dataHtml = '<form class="covid-modal-form" action="" method="POST" name="edit_program"><label for="editProgramOldName">Стара назва програми</label><input class="regular-text" id="editProgramOldName" name="edit_program_old_name" type="text" readonly="readonly" value="'+ programTitleOld +'"><label for="editProgramName">Нова назва бланку</label><input class="regular-text" id="editProgramName" name="edit_program_name" type="text" placeholder="Введіть назву програми"><label for="editProgramComments">Введіть коментар до бланка</label><input class="regular-text" id="editProgramComments" name="edit_program_comments" type="text" placeholder="Введіть коментар до програми" value="'+ programComments +'"><button class="button button-primary button-large covid-sbmt" id="editProgram" data-program-id="'+ programId +'"><i class="fa fa-floppy-o"></i> Зберегти</button></form>';

            //Показать модальное окно
            $('#covidModal').addClass('show');

            $('#covidModal .js-covid-modal-header-title').text( title );

            $('#covidModal .js-covid-modal-body').html(dataHtml);


        });

        $('body').on('click', '.js-covid-modal-close', function(){

            //Скрыть модальное окно
            $('#covidModal').removeClass('show');

            $('#covidModal .js-covid-modal-header-title').text('');

            $('#covidModal .js-covid-modal-body').html('');


        });
    }

    function CovidModalClose( ){
        
        $('body').on('click', '.js-covid-modal-close', function(){

            //Скрыть модальное окно
            $('#covidModal').removeClass('show');

            $('#covidModal .js-covid-modal-header-title').text('');

            $('#covidModal .js-covid-modal-body').html('');


        });
    }

	function EditProgram(){
        

		$('body').on('click', '#editProgram',  function(e){

            console.log('Edit program');

			e.preventDefault();
			
            programId = $(this).attr('data-program-id')*1;

            programTitle = $(this).parents('form').find('#editProgramName').val();

            programComments = $(this).parents('form').find('#editProgramComments').val();

            console.log('programTitle:' + programTitle + ' programId: ' + programId);

            // if( programTitle.length > 1 ){
                
                //Создаем данные для передачи
                var data = {
                    action: 'covideditprogram',
                    nonce: covidAdminEditProgram.nonce,
                    id: programId,
                    title: programTitle,
                    comments: programComments,
                };

                //Отправляем данные
                var jqXHR = $.post( covidAdminEditProgram.ajaxurl, data, function(response) {
                    // console.log(response);
                });

                //Если получили статус 200
                jqXHR.done(function(response){

                    data = JSON.parse(response);

                    // console.log('Result: ' + data.message + ' ID: ' + data.id + ' Title: ' + data.program_name);

                    // Обновить таблицу бланков
                    if( data.status ){
                        LoadProgram();
                    }

                    //Скрыть модальное окно
                    $('#covidModal').removeClass('show');

                    $('#covidModal .js-covid-modal-header-title').text('');

                    $('#covidModal .js-covid-modal-body').html('');


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