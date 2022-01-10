jQuery(document).ready(function($) {

    $('body').on('click', '.js-insurance-order-filter-btn', function(e){
        
        e.preventDefault();
        
        RateList();

        $('.js-add-on-insurance-pagination-inpt').val(1);
        $('.add-on-insurance-pagination-btn-prev').addClass('pagination-btn-disable');
        $('.add-on-insurance-pagination-btn-next').removeClass('pagination-btn-disable');

        return false;
    })

    

    // $('#pagination').on('click', 'button', function(e){

    //     e.preventDefault();

    //     page = $(this).attr('data-page')*1;

    //     RateList(page);
    // });

    Paginations();
    function Paginations(){

        //Next Page
        $('#pagination').on('click', '.add-on-insurance-pagination-btn-next', function(){
            
            base = $(this);
            currentPage = base.parents('#pagination').find('.js-add-on-insurance-pagination-inpt').val()*1;
            pages = base.parents('#pagination').find('.js-paginations-total-pages').attr('data-pages')*1;
            nextPage = currentPage + 1;


            if( nextPage <= pages ){
                // currentPage ++;
                base.parents('#pagination').find('.js-add-on-insurance-pagination-inpt').val( nextPage );
                $('.add-on-insurance-pagination-btn-prev').removeClass('paginations-btn-disable');
                $('.pagination-btn-begin').removeClass('paginations-btn-disable');
                RateList( nextPage );
            }
            if( nextPage == pages ){
                base.addClass('pagination-btn-disable');
            }

            // console.log('currentPage Next: ' + nextPage);
            // console.log('pages: ' + pages);

        });

        //Prev Page
        $('#pagination').on('click', '.add-on-insurance-pagination-btn-prev', function(){
            
            base = $(this);
            currentPage = base.parents('#pagination').find('.js-add-on-insurance-pagination-inpt').val()*1;
            pages = base.parents('#pagination').find('.js-paginations-total-pages').attr('data-pages')*1;
            prevPage = currentPage - 1;

            if( prevPage >= 1 ){
                currentPage --;
                base.parents('#pagination').find('.js-add-on-insurance-pagination-inpt').val( prevPage );
                $('.add-on-insurance-pagination-btn-next').removeClass('paginations-btn-disable');
                $('.paginations-btn-end').removeClass('paginations-btn-disable');
                RateList( prevPage );
            }
            else{
                base.addClass('paginations-btn-disable');
            }

            // console.log('currentPage Prev: ' + prevPage);
            // console.log('pages: ' + pages);

        });

        //End Page
        /*$('#pagination').on('click', '.paginations-btn-end', function(){
            
            base = $(this);
            currentPage = base.parents('#pagination').find('.js-add-on-insurance-pagination-inpt').val()*1;
            pages = base.parents('#pagination').find('.js-paginations-total-pages').attr('data-pages')*1;
            // prevPage = currentPage - 1;

            if( base.hasClass('paginations-btn-disable') ){

            }
            else{
                
                if( currentPage != pages ){

                    RateList( pages );
                    $('.js-add-on-insurance-pagination-inpt').val( pages );
    
                    base.addClass('paginations-btn-disable');
                    $('.add-on-insurance-pagination-btn-next').addClass('paginations-btn-disable');
    
                    $('.paginations-btn-begin').removeClass('paginations-btn-disable');
                    $('.add-on-insurance-pagination-btn-prev').removeClass('paginations-btn-disable');
    
                }
            }
            
            // console.log('pages: ' + pages);

        });*/

        //Begin Page
        /*$('#pagination').on('click', '.paginations-btn-begin', function(){
            
            base = $(this);
            
            if( base.hasClass('paginations-btn-disable') ){

            }
            else{
                RateList( 1 );
                $('.js-add-on-insurance-pagination-inpt').val( 1 );

                base.addClass('paginations-btn-disable');
                $('.add-on-insurance-pagination-btn-prev').addClass('paginations-btn-disable');

                $('.paginations-btn-end').removeClass('paginations-btn-disable');
                $('.add-on-insurance-pagination-btn-next').removeClass('paginations-btn-disable');

                // console.log('pages: ' + pages);
            }

        });*/

    }
    

	function RateList(page = 1){
        
        // rateCompanyTitle = $('#formRateList #rateCompanyTitle').val();
        // rateBlankTitle = $('#formRateList #rateBlankTitle').val();
        // rateFranchise = $('#formRateList #rateFranchise').val();
        // rateValidity = $('#formRateList #rateValidity').val();
        // rateSum = $('#formRateList #rateSum').val();
        // rateLocation = $('#formRateList #rateLocation').val();
        // rateCount = $('#formRateList #count').val();
        // console.log('companyTitle: ' + companyTitle);
       

        user_id = $('.add-on-insurance-filetr-wrapper').find('select').val()*1;

        console.log('user_id: ' + user_id);

        console.log('page: ' + page);
        
        
        var data = {
            action: 'order_paginatio',
            ajax_nonce : Rcl.nonce, // проверочный ключ безопасности
            page: page,
            user_id: user_id,
        };
        
        // ajax post запрос
        jQuery.post({
            url: Rcl.ajaxurl, // путь до вордпресс обработчика ajax
            dataType: "json", // тип данных с которыми работаем
            data: data, // массив наших данных (сформировали выше)
            success: function(response){ // при успешном возврате
                console.log(response);
                console.log('success');

                $('.js-add-on-insurance-rate-list-wrapper').html( response.orders );
                $('.js-add-on-insurance-pagination').html( response.pagination );

                
                
            },
            complete: function(response){ // ajax-запрос завершился
                console.log('Conplete');
                
            },
            error: function(){
                alert('Сервер зйнятий, спробуйте пізніше.');
            }
        });

        return false;
        /*
        //Если получили статус 200
        jqXHR.done(function(response){

            // console.log('Сообщение: ' + response );
            data = JSON.parse(response);
            // console.log(response);
            $('#rateList').html(data.rates);

            $('.js-paginations-total-pages').attr( 'data-pages', data.pages ).find('span').text( data.pages );


            $('.js-paginations-total-elements').attr( 'data-elements', data.rates ).find('span').text( data.rates_count );
            console.log('pages: ' + data.pages);
            if( data.pages == 1 ){
                $('.add-on-insurance-pagination-btn-prev').addClass('paginations-btn-disable');
                $('.add-on-insurance-pagination-btn-next').addClass('paginations-btn-disable');
                $('.paginations-btn-end').addClass('paginations-btn-disable');
                $('.paginations-btn-begin').addClass('paginations-btn-disable');
            }
            else{
                $('.add-on-insurance-pagination-btn-next').removeClass('paginations-btn-disable');
                $('.paginations-btn-end').removeClass('paginations-btn-disable');
            }
           
            if( data.rates ){
                // $('.js-message').html( '<div class="message-danger">' + data.message + '</div>');
            }
            else{
                $('.js-message').html( '<div class="message-okay">' + data.message + '</div>' );
            }

            console.log('rates_count: '+data.rates_count);


            // $('#insuranceBlankLIst').html(response);

        });

        //Если была ошибка
        jqXHR.fail(function(response){

            console.log(response);

            alert('Сервер занят, попробуйте немного позже');

        });

        return false;

        */

			
    }
});