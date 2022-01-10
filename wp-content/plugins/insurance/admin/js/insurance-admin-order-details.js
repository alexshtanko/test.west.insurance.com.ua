jQuery(document).ready(function ($) {

    $('body').on('click', '.insurance-modal-wrapper.show', function (e) {
        if (!$(e.target).closest(".insurance-modal-wrapper.show .insurance-modal").length) {
            $('#insuranceModal').removeClass('show');

            $('#insuranceModal .js-insurance-modal-header-title').text('');

            $('#insuranceModal .js-insurance-modal-body').html('');

        }
        e.stopPropagation();
    });


    InsuranceModalClose();

    $('body').on('click', '.js-order-details', function () {

        let orderId = $(this).attr('data-id');

        $.ajax({
            type: "POST",
            method: "POST",
            url: insuranceAdminOrderDetails.ajaxurl,
            data: {
                action: 'insuranceadminorderdetails',
                nonce: insuranceAdminOrderDetails.nonce,
                id: orderId,
            },
            success: function (data) {
                // data = JSON.parse(data);
                $('#insuranceModal').addClass('show');

                $('#insuranceModal .js-insurance-modal-header-title').text('Деталі замовлення');

                $('#insuranceModal .js-insurance-modal-body').html(data);
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
            url: insuranceAdminOrderDetails.ajaxurl,
            data: {
                action: 'insuranceadminorderdetailssave',
                nonce: insuranceAdminOrderDetails.nonce,
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
                    $('#insuranceModal').removeClass('show');

                    $('#insuranceModal .js-insurance-modal-header-title').text('');

                    $('#insuranceModal .js-insurance-modal-body').html('');
                } else {
                    alert(data.message);
                }
            }
        });
        //Показать модальное окно
    });

    $('body').on('click', '.js-insurance-modal-close', function () {

        //Скрыть модальное окно
        $('#insuranceModal').removeClass('show');

        $('#insuranceModal .js-insurance-modal-header-title').text('');

        $('#insuranceModal .js-insurance-modal-body').html('');


    });

    // }

    function InsuranceModalClose() {

        $('body').on('click', '.js-insurance-modal-close', function () {

            //Скрыть модальное окно
            $('#insuranceModal').removeClass('show');

            $('#insuranceModal .js-insurance-modal-header-title').text('');

            $('#insuranceModal .js-insurance-modal-body').html('');


        });
    }

    function HideModal() {

        $('#insuranceModal').removeClass('show');

        $('#insuranceModal .js-insurance-modal-header-title').text('');

        $('#insuranceModal .js-insurance-modal-body').html('');
    }

});