jQuery(document).ready(function($) {


    $('body').on('click', '#get_manager_id', function (e) {
        e.preventDefault();

        let form = $(this).closest('form#manager_search');

        //Создаем данные для передачи
        var data = {
            action: 'covidadmingetblanktomanager',
            nonce: covidAdminGetBlankToManager.nonce,
            company_id: form.find('[name=company_id]').val(),
            blank_series: form.find('[name=blank_series]').val(),
            blank_number: form.find('[name=blank_number]').val(),
        };


        //Отправляем данные
        var jqXHR = $.post( covidAdminGetBlankToManager.ajaxurl, data, function(response) {
            // console.log(response);
        });

        //Если получили статус 200
        jqXHR.done(function(data){
            data = JSON.parse(data);
            $('.manager_name_span').html(data.message);
        });

        //Если была ошибка
        jqXHR.fail(function(response){

            console.log(response);

            alert('Сервер занят, попробуйте немного позже');

        });

    });


});