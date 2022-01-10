jQuery(document).ready(function ($) {

    $('body').on('click', '.covid-modal-wrapper.show', function (e) {
        if (!$(e.target).closest(".covid-modal-wrapper.show .covid-modal").length) {
            $('#covidModal').removeClass('show');

            $('#covidModal .js-covid-modal-header-title').text('');

            $('#covidModal .js-covid-modal-body').html('');

        }
        e.stopPropagation();
    });


    CovidModalClose();

    $('body').on('click', '.js-order-details', function () {

        let orderId = $(this).attr('data-id');

        $.ajax({
            type: "POST",
            method: "POST",
            url: covidAdminOrderDetails.ajaxurl,
            data: {
                action: 'covidadminorderdetails',
                nonce: covidAdminOrderDetails.nonce,
                id: orderId,
            },
            success: function (data) {
                // data = JSON.parse(data);
                $('#covidModal').addClass('show');

                $('#covidModal .js-covid-modal-header-title').text('Деталі замовлення');

                $('#covidModal .js-covid-modal-body').html(data);
            }
        });
        //Показать модальное окно
    });

    $('body').on('click', '#save_order_details', function (e) {
        e.preventDefault();
        let form = $(this).closest('form');

        $.ajax({
            type: "POST",
            method: "POST",
            url: covidAdminOrderDetails.ajaxurl,
            data: {
                action: 'covidadminorderdetailssave',
                nonce: covidAdminOrderDetails.nonce,
                id: form.find('[name=id]').val(),
                name: form.find('[name=name]').val(),
                last_name: form.find('[name=last_name]').val(),
                passport: form.find('[name=passport]').val(),
                birthday: form.find('[name=birthday]').val(),
                address: form.find('[name=address]').val(),
                phone_number: form.find('[name=phone_number]').val(),
                email: form.find('[name=email]').val(),
                date_from: form.find('[name=date_from]').val(),
                date_to: form.find('[name=date_to]').val(),
                date_added: form.find('[name=date_added]').val(),
            },
            success: function (data) {
                data = JSON.parse(data);
                if (data.status === 'ok') {
                    $('#covidModal').removeClass('show');

                    $('#covidModal .js-covid-modal-header-title').text('');

                    $('#covidModal .js-covid-modal-body').html('');
                } else {
                    alert(data.message);
                }
            }
        });
        //Показать модальное окно
    });

    $('body').on('click', '.js-covid-modal-close', function () {

        //Скрыть модальное окно
        $('#covidModal').removeClass('show');

        $('#covidModal .js-covid-modal-header-title').text('');

        $('#covidModal .js-covid-modal-body').html('');


    });

    // }

    function CovidModalClose() {

        $('body').on('click', '.js-covid-modal-close', function () {

            //Скрыть модальное окно
            $('#covidModal').removeClass('show');

            $('#covidModal .js-covid-modal-header-title').text('');

            $('#covidModal .js-covid-modal-body').html('');


        });
    }

    function HideModal() {

        $('#covidModal').removeClass('show');

        $('#covidModal .js-covid-modal-header-title').text('');

        $('#covidModal .js-covid-modal-body').html('');
    }

});