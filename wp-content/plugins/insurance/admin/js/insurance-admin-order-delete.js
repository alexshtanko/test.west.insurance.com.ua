jQuery(document).ready(function ($) {
    RemoveBtn();

    function RemoveBtn() {

        $('body').on('click', '.js-remove-btn', function (e) {

            $(this).parents('.manage-column').find('.delete-agree').addClass('show');

        });

        $('body').on('click', '.js-remove-btn-cancel', function (e) {

            $(this).parents('.manage-column').find('.delete-agree').removeClass('show');

        });

    }

    orderDelete();

    function orderDelete(id, page = 1) {

        $('body').on('click', '.js-delete-order', function () {

            id = $(this).attr('data-id') * 1;
            page = $('.js-paginations-inpt').val() * 1;

            orderCompanyId = $('#formOrderList #orderCompanyId').val();
            orderProgramId = $('#formOrderList #orderProgramId').val();
            orderFranchise = $('#formOrderList #orderFranchise').val();
            orderBlankSeries = $('#formOrderList #orderBlankSeries').val();
            orderManagerId = $('#formOrderList #orderManagerId').val();
            orderStatus = $('#formOrderList #orderStatus').val();
            orderCount = $('#formOrderList #count').val();
            orderDateFrom = $('#formOrderList #OrderDateFrom').val();
            orderDateTo = $('#formOrderList #OrderDateTo').val();


            //Создаем данные для передачи
            let data = {
                action: 'insuranceorderdelete',
                nonce: insuranceAdminorderDelete.nonce,
                company_id: orderCompanyId,
                program_id: orderProgramId,
                franchise: orderFranchise,
                blank_series: orderBlankSeries,
                manager_id: orderManagerId,
                status: orderStatus,
                count: orderCount,
                date_from: orderDateFrom,
                date_to: orderDateTo,
                page: page,
                id: id,
            };

            // console.log(user_club_title);

            //Отправляем данные
            let jqXHR = $.post(insuranceAdminorderDelete.ajaxurl, data, function (response) {
                // console.log(response);
            });

            //Если получили статус 200
            jqXHR.done(function (response) {

                data = JSON.parse(response);

                // console.log(data);

                $('#orderList').html(data.orders);
                // $('#paginations').html(data.paginations);


                $('.js-paginations-total-pages').attr('data-pages', data.pages).find('span').text(data.pages);


                $('.js-paginations-total-elements').attr('data-elements', data.orders).find('span').text(data.orders_count);
                // console.log('pages: ' + data.pages);
                if (data.pages == 1) {
                    $('.paginations-btn-prev').addClass('paginations-btn-disable');
                    $('.paginations-btn-next').addClass('paginations-btn-disable');
                    $('.paginations-btn-end').addClass('paginations-btn-disable');
                    $('.paginations-btn-begin').addClass('paginations-btn-disable');
                } else {
                    $('.paginations-btn-next').removeClass('paginations-btn-disable');
                    $('.paginations-btn-end').removeClass('paginations-btn-disable');
                }

                if (data.orders) {
                    // $('.js-message').html( '<div class="message-danger">' + data.message + '</div>');
                } else {
                    $('.js-message').html('<div class="message-okay">' + data.message + '</div>');
                }

            });

            //Если была ошибка
            jqXHR.fail(function (response) {

                // console.log(response);

                alert('Сервер занят, попробуйте немного позже');

            });
            return false;
        });

    }
});