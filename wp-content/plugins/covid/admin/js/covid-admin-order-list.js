jQuery(document).ready(function ($) {

    $('body').on('click', '#OrderFilterSbmt', function (e) {

        e.preventDefault();

        OrderList();

        $('.js-paginations-inpt').val(1);
        $('.paginations-btn-prev').addClass('paginations-btn-disable');
        $('.paginations-btn-next').removeClass('paginations-btn-disable');

        return false;
    });

    $('body').on('change', '#orderList .order_status', function (e) {

        e.preventDefault();
        let orderId = $(this).attr('data-id');
        let status = $(this).val();

            $.ajax({
                type: "POST",
                method: "POST",
                url: covidAdminOrderList.ajaxurl,
                data: {
                    action: 'covidorderhangestatus',
                    nonce: covidAdminOrderList.nonce,
                    id: orderId,
                    status: status
                },
                success: function (data) {

                }
            });
        return false;
    });


    $('.order_list_page #paginations').on('click', 'button', function (e) {
        e.preventDefault();
        page = $(this).attr('data-page') * 1;
        OrderList(page);
    });

    Paginations();

    function Paginations() {
        //Next Page
        $('.order_list_page #paginations').on('click', '.paginations-btn-next', function () {

            base = $(this);
            currentPage = base.parents('#paginations').find('.js-paginations-inpt').val() * 1;
            pages = base.parents('#paginations').find('.js-paginations-total-pages').attr('data-pages') * 1;
            nextPage = currentPage + 1;
            if (nextPage <= pages) {
                // currentPage ++;
                base.parents('#paginations').find('.js-paginations-inpt').val(nextPage);
                $('.paginations-btn-prev').removeClass('paginations-btn-disable');
                $('.paginations-btn-begin').removeClass('paginations-btn-disable');

                OrderList(nextPage);
            }
            if (nextPage == pages) {
                base.addClass('paginations-btn-disable');
            }
        });
        //Prev Page
        $('.order_list_page #paginations').on('click', '.paginations-btn-prev', function () {

            base = $(this);
            currentPage = base.parents('#paginations').find('.js-paginations-inpt').val() * 1;
            pages = base.parents('#paginations').find('.js-paginations-total-pages').attr('data-pages') * 1;
            prevPage = currentPage - 1;

            if (prevPage >= 1) {
                currentPage--;
                base.parents('#paginations').find('.js-paginations-inpt').val(prevPage);
                $('.paginations-btn-next').removeClass('paginations-btn-disable');
                $('.paginations-btn-end').removeClass('paginations-btn-disable');
                OrderList(prevPage);
            } else {
                base.addClass('paginations-btn-disable');
            }
        });
        //End Page
        $('.order_list_page #paginations').on('click', '.paginations-btn-end', function () {

            base = $(this);
            currentPage = base.parents('#paginations').find('.js-paginations-inpt').val() * 1;
            pages = base.parents('#paginations').find('.js-paginations-total-pages').attr('data-pages') * 1;
            // prevPage = currentPage - 1;
            if (base.hasClass('paginations-btn-disable')) {
            } else {
                if (currentPage != pages) {

                    OrderList(pages);
                    $('.js-paginations-inpt').val(pages);

                    base.addClass('paginations-btn-disable');
                    $('.paginations-btn-next').addClass('paginations-btn-disable');

                    $('.paginations-btn-begin').removeClass('paginations-btn-disable');
                    $('.paginations-btn-prev').removeClass('paginations-btn-disable');
                }
            }
        });

        //Begin Page
        $('.order_list_page #paginations').on('click', '.paginations-btn-begin', function () {
            base = $(this);

            if (base.hasClass('paginations-btn-disable')) {
            } else {
                OrderList(1);
                $('.js-paginations-inpt').val(1);

                base.addClass('paginations-btn-disable');
                $('.paginations-btn-prev').addClass('paginations-btn-disable');
                $('.paginations-btn-end').removeClass('paginations-btn-disable');
                $('.paginations-btn-next').removeClass('paginations-btn-disable');
            }
        });
    }

    function OrderList(page = 1) {

        orderCompanyId = $('#formOrderList #orderCompanyId').val();
        orderProgramId = $('#formOrderList #orderProgramId').val();
        orderFranchise = $('#formOrderList #orderFranchise').val();
        orderBlankSeries = $('#formOrderList #orderBlankSeries').val();
        orderManagerId = $('#formOrderList #orderManagerId').val();
        orderStatus = $('#formOrderList #orderStatus').val();
        orderCount = $('#formOrderList #count').val();
        orderDateFrom = $('#formOrderList #OrderDateFrom').val();
        orderDateTo = $('#formOrderList #OrderDateTo').val();
        covidBlankNumber = $('#formOrderList #covidBlankNumber').val();

        console.log('covidBlankNumber: ' + covidBlankNumber);

        //Создаем данные для передачи
        let data = {
            action: 'covidorderlist',
            nonce: covidAdminOrderList.nonce,
            company_id: orderCompanyId,
            program_id: orderProgramId,
            franchise: orderFranchise,
            blank_series: orderBlankSeries,
            manager_id: orderManagerId,
            status: orderStatus,
            count: orderCount,
            date_from: orderDateFrom,
            date_to: orderDateTo,
            blank_number: covidBlankNumber,
            page: page,
        };

        //Отправляем данные
        var jqXHR = $.post(covidAdminOrderList.ajaxurl, data, function (response) {

        });
        //Если получили статус 200
        jqXHR.done(function (response) {
            data = JSON.parse(response);
            // console.log(data);
            $('#orderList').html(data.orders);
            $('.js-paginations-total-pages').attr('data-pages', data.pages).find('span').text(data.pages);
            $('.js-paginations-total-elements').attr('data-elements', data.orders).find('span').text(data.orders_count);
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
                $('.js-message').html('');
            } else {
                $('.js-message').html('<div class="message-okay">' + data.message + '</div>');
            }
        });
        //Если была ошибка
        jqXHR.fail(function (response) {
            alert('Сервер занят, попробуйте немного позже');
        });
        return false;
    }
});