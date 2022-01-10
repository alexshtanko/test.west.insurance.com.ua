jQuery(document).ready(function($) {

    RemoveBtn();

    function RemoveBtn(){

        $('body').on('click', '.js-remove-btn', function(e){
            
            $(this).parents('.manage-column').find('.delete-agree').addClass('show');
           
        });

        $('body').on('click', '.js-remove-btn-cancel', function(e){
            
            $(this).parents('.manage-column').find('.delete-agree').removeClass('show');
           
        });

    }

    RateDelete();

	function RateDelete( id, page = 1 ){

        $('body').on('click', '.js-delete-rate', function(){

            id = $(this).attr('data-id')*1;
            page = $('.js-paginations-inpt').val()*1;

            rateCompanyTitle = $('#formRateList #rateCompanyTitle').val();
            rateBlankTitle = $('#formRateList #rateBlankTitle').val();
            rateFranchise = $('#formRateList #rateFranchise').val();
            rateValidity = $('#formRateList #rateValidity').val();
            rateSum = $('#formRateList #rateSum').val();
            rateLocation = $('#formRateList #rateLocation').val();
            rateCount = $('#formRateList #count').val();
            // page = $('.js-active-page button').attr('data-page');
            // console.log('companyTitle: ' + companyTitle);
            console.log('rateLocation: ' + rateLocation);
            console.log('rateCount: ' + rateCount);
            console.log('rateSum: ' + rateSum);
            console.log('rateFranchise: ' + rateFranchise);
            console.log('rateBlankTitle: ' + rateBlankTitle);
            console.log('rateCompanyTitle: ' + rateCompanyTitle);

            
            
            //Создаем данные для передачи
            var data = {
                action: 'covidratedelete',
                nonce: covidAdminRateDelete.nonce,
                company_title: rateCompanyTitle,
                blank_title: rateBlankTitle,
                franchise: rateFranchise,
                validity: rateValidity,
                sum: rateSum,
                location: rateLocation,
                count: rateCount,
                page: page,
                id: id,
            };

            //Отправляем данные
            var jqXHR = $.post( covidAdminRateDelete.ajaxurl, data, function(response) {
                // console.log(response);
            });

            //Если получили статус 200
            jqXHR.done(function(response){

                data = JSON.parse(response);

                console.log(data);

                $('#rateList').html(data.rates);

                $('.js-paginations-total-pages').attr( 'data-pages', data.pages ).find('span').text( data.pages );


                $('.js-paginations-total-elements').attr( 'data-elements', data.rates ).find('span').text( data.rates_count );
                console.log('pages: ' + data.pages);
                if( data.pages == 1 ){
                    $('.paginations-btn-prev').addClass('paginations-btn-disable');
                    $('.paginations-btn-next').addClass('paginations-btn-disable');
                    $('.paginations-btn-end').addClass('paginations-btn-disable');
                    $('.paginations-btn-begin').addClass('paginations-btn-disable');
                }
                else{
                    $('.paginations-btn-next').removeClass('paginations-btn-disable');
                    $('.paginations-btn-end').removeClass('paginations-btn-disable');
                }

                if( data.rates ){

                }
                else{
                    $('.js-message').html( '<div class="message-okay">' + data.message + '</div>' );
                }

            });

            //Если была ошибка
            jqXHR.fail(function(response){

                console.log(response);

                alert('Сервер занят, попробуйте немного позже');

            });

            return false;

        }); 

        }
});