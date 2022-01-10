jQuery(document).ready(function($) {

    $('body').on('click', '#RateFilterSbmt', function(e){
        
        e.preventDefault();
        
        RateList();

        $('.js-paginations-inpt').val(1);
        $('.paginations-btn-prev').addClass('paginations-btn-disable');
        $('.paginations-btn-next').removeClass('paginations-btn-disable');

        return false;
    })

    

    $('.rate_list_page #paginations').on('click', 'button', function(e){

        e.preventDefault();

        page = $(this).attr('data-page')*1;

        RateList(page);
    });

    Paginations();
    function Paginations(){

        //Next Page
        $('.rate_list_page #paginations').on('click', '.paginations-btn-next', function(){
            
            base = $(this);
            currentPage = base.parents('#paginations').find('.js-paginations-inpt').val()*1;
            pages = base.parents('#paginations').find('.js-paginations-total-pages').attr('data-pages')*1;
            nextPage = currentPage + 1;


            if( nextPage <= pages ){
                // currentPage ++;
                base.parents('#paginations').find('.js-paginations-inpt').val( nextPage );
                $('.paginations-btn-prev').removeClass('paginations-btn-disable');
                $('.paginations-btn-begin').removeClass('paginations-btn-disable');
                RateList( nextPage );
            }
            if( nextPage == pages ){
                base.addClass('paginations-btn-disable');
            }

            // console.log('currentPage Next: ' + nextPage);
            // console.log('pages: ' + pages);

        });

        //Prev Page
        $('.rate_list_page #paginations').on('click', '.paginations-btn-prev', function(){
            
            base = $(this);
            currentPage = base.parents('#paginations').find('.js-paginations-inpt').val()*1;
            pages = base.parents('#paginations').find('.js-paginations-total-pages').attr('data-pages')*1;
            prevPage = currentPage - 1;

            if( prevPage >= 1 ){
                currentPage --;
                base.parents('#paginations').find('.js-paginations-inpt').val( prevPage );
                $('.paginations-btn-next').removeClass('paginations-btn-disable');
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
        $('.rate_list_page #paginations').on('click', '.paginations-btn-end', function(){
            
            base = $(this);
            currentPage = base.parents('#paginations').find('.js-paginations-inpt').val()*1;
            pages = base.parents('#paginations').find('.js-paginations-total-pages').attr('data-pages')*1;
            // prevPage = currentPage - 1;

            if( base.hasClass('paginations-btn-disable') ){

            }
            else{
                
                if( currentPage != pages ){

                    RateList( pages );
                    $('.js-paginations-inpt').val( pages );
    
                    base.addClass('paginations-btn-disable');
                    $('.paginations-btn-next').addClass('paginations-btn-disable');
    
                    $('.paginations-btn-begin').removeClass('paginations-btn-disable');
                    $('.paginations-btn-prev').removeClass('paginations-btn-disable');
    
                }
            }
            
            // console.log('pages: ' + pages);

        });

        //Begin Page
        $('.rate_list_page #paginations').on('click', '.paginations-btn-begin', function(){
            
            base = $(this);
            
            if( base.hasClass('paginations-btn-disable') ){

            }
            else{
                RateList( 1 );
                $('.js-paginations-inpt').val( 1 );

                base.addClass('paginations-btn-disable');
                $('.paginations-btn-prev').addClass('paginations-btn-disable');

                $('.paginations-btn-end').removeClass('paginations-btn-disable');
                $('.paginations-btn-next').removeClass('paginations-btn-disable');

                // console.log('pages: ' + pages);
            }

        });

    }
    

	function RateList(page = 1){
        
        rateCompanyTitle = $('#formRateList #rateCompanyTitle').val();
        rateBlankTitle = $('#formRateList #rateBlankTitle').val();
        rateFranchise = $('#formRateList #rateFranchise').val();
        rateValidity = $('#formRateList #rateValidity').val();
        rateSum = $('#formRateList #rateSum').val();
        rateLocation = $('#formRateList #rateLocation').val();
        rateCount = $('#formRateList #count').val();
        // console.log('companyTitle: ' + companyTitle);
        console.log('page: ' + page);

        
        
        //Создаем данные для передачи
        var data = {
            action: 'insuranceratelist',
            nonce: insuranceAdminRateList.nonce,
            company_title: rateCompanyTitle,
            blank_title: rateBlankTitle,
            franchise: rateFranchise,
            validity: rateValidity,
            sum: rateSum,
            location: rateLocation,
            count: rateCount,
            page: page,
        };

        // console.log(user_club_title);

        //Отправляем данные
        var jqXHR = $.post( insuranceAdminRateList.ajaxurl, data, function(response) {
            // console.log(response);
        });

        //Если получили статус 200
        jqXHR.done(function(response){

            // console.log('Сообщение: ' + response );
            data = JSON.parse(response);

            console.log(data.rates);
            // console.log(response);
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
            // $('.js-paginations-inpt').val( 1 );
            // $('.paginations-btn-prev').addClass('paginations-btn-disable');
            // $('.paginations-btn-next').removeClass('paginations-btn-disable');
            

            // $('#paginations').html(data.paginations);
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

			
    }
});