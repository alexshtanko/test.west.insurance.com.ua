jQuery(document).ready(function ($) {
    var seletedCompany = "";

    $("form#formBlankToManager #CompanyId").on('change', function () {
        seletedCompany = $("#CompanyId").val();

        if (!!seletedCompany) {
            $('#blanksSeries option').each(function (index, item) {
                if (!!$(item).val()) {
                    if (seletedCompany == $(item).data("company-id")) {
                        $(item).show()
                    } else {
                        $(item).hide();
                    }
                }
            });

            $("#blanksSeries").prop("disabled", false);
        } else {
            $("#blanksSeries").prop("disabled", true);
        }

    });

    $('form#formBlankToManager').submit(function (e) {
        if (parseInt($("input#blanksNumberStart").val()) > parseInt($("input#blanksNumberEnd").val())) {
            alert("Нумерація бланку ВІД не може бути меншою нумерації бланку ДО.");
            return false;
        }
    });


    /*$('body').on('click', '#get_manager_id', function (e) {
        e.preventDefault();
        let form = $(this).closest('form#manager_search');

        $.ajax({
            type: "POST",
            method: "POST",
            url: insuranceAdminBlankToManager.ajaxurl,
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
    });*/
});