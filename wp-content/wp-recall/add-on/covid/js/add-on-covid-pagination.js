jQuery(document).ready(function($) {

    $('body').on('click', '.js-insurance-order-filter-btn', function(e){
        
        e.preventDefault();
        
        RateList();

        $('.js-add-on-insurance-pagination-inpt').val(1);
        $('.add-on-insurance-pagination-btn-prev').addClass('pagination-btn-disable');
        $('.add-on-insurance-pagination-btn-next').removeClass('pagination-btn-disable');

        return false;
    })

    Paginations();
    function Paginations(){

        //Next Page
        $('#pagination').on('click', '.add-on-covid-pagination-btn-next', function(){
            
            base = $(this);
            currentPage = base.parents('#pagination').find('.js-add-on-covid-pagination-inpt').val()*1;
            pages = base.parents('#pagination').find('.js-paginations-total-pages').attr('data-pages')*1;
            nextPage = currentPage + 1;


            if( nextPage <= pages ){
                // currentPage ++;
                base.parents('#pagination').find('.js-add-on-covid-pagination-inpt').val( nextPage );
                $('.add-on-insurance-pagination-btn-prev').removeClass('paginations-btn-disable');
                $('.pagination-btn-begin').removeClass('paginations-btn-disable');
                RateList( nextPage );
            }
            if( nextPage == pages ){
                base.addClass('pagination-btn-disable');
            }

        });

        //Prev Page
        $('#pagination').on('click', '.add-on-covid-pagination-btn-prev', function(){
            
            base = $(this);
            currentPage = base.parents('#pagination').find('.js-add-on-covid-pagination-inpt').val()*1;
            pages = base.parents('#pagination').find('.js-paginations-total-pages').attr('data-pages')*1;
            prevPage = currentPage - 1;

            if( prevPage >= 1 ){
                currentPage --;
                base.parents('#pagination').find('.js-add-on-covid-pagination-inpt').val( prevPage );
                $('.add-on-insurance-pagination-btn-next').removeClass('paginations-btn-disable');
                $('.paginations-btn-end').removeClass('paginations-btn-disable');
                RateList( prevPage );
            }
            else{
                base.addClass('paginations-btn-disable');
            }


        });



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
            action: 'order_pagination',
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

                // console.log(response);
                // console.log('success');

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

    }
});