jQuery(document).ready(function($) {

    $('body').on('click', '#get_manager_id', function (e) {
        e.preventDefault();

        let form = $(this).closest('form#manager_search');

        //Создаем данные для передачи
        var data = {
            action: 'insuranceadmingetblanktomanager',
            nonce: insuranceAdminGetBlankToManager.nonce,
            company_id: form.find('[name=company_id]').val(),
            blank_series: form.find('[name=blank_series]').val(),
            blank_number: form.find('[name=blank_number]').val(),
        };


        //Отправляем данные
        var jqXHR = $.post( insuranceAdminGetBlankToManager.ajaxurl, data, function(response) {
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

        /*

        $.ajax({
            type: "POST",
            method: "POST",
            // url: insuranceAdminBlankToManager.ajaxurl,
            url: insuranceAdminGetManagerOfBlank.ajaxurl,
            data: {
                action: 'insuranceadmingetmanagerofblank',
                nonce: insuranceAdminBlankToManager.nonce,
                company_id: form.find('[name=company_id]').val(),
                blank_series: form.find('[name=blank_series]').val(),
                blank_number: form.find('[name=blank_number]').val(),

            },
            success: function (data) {
                data = JSON.parse(data);
                $('.manager_name_span').html(data.message);
            }
        });
        //Показать модальное окно
        */
    });


});