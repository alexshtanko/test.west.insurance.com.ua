jQuery(document).ready(function(){

    jQuery('#covidCustomerBid').on('click', function(e){

        e.preventDefault();

        jQuery('.js-covid-customer-form input').each(function(){
            inptValue = jQuery(this).val();

            if( inptValue == '' ){
                jQuery(this).addClass('covid-error');
            }
            else{
                jQuery(this).removeClass('covid-error');
            }
        });

        if(jQuery('.js-covid-customer-form input').hasClass('covid-error')){
            alert('Потрібно заповнити всі поля форми!');
        }
        else{
            
        

            var data = {
                action: 'covidbid',
                nonce: covidBid.nonce,
                insuranceCompany: jQuery('.js-get-company input').val(),
                insuranceAmount: jQuery('.js-get-company-amount input').val(),
                insurancePrediod: jQuery('.js-get-company-period input').val(),
                insurancePrice: jQuery('.js-insurance-price').text(),
                customerSurname: jQuery('.js-covid-customer-form input[name="covid-surname"]').val(),
                customerName: jQuery('.js-covid-customer-form input[name="covid-name"]').val(),
                customerDate: jQuery('.js-covid-customer-form input[name="covid-date"]').val(),
                // customerMiddleName: jQuery('.js-covid-customer-form input[name="covid-middle-name"]').val(),
                customerPassport: jQuery('.js-covid-customer-form input[name="covid-passport"]').val(),
                customerAddress: jQuery('.js-covid-customer-form input[name="covid-address"]').val(),
                customerTel: jQuery('.js-covid-customer-form input[name="covid-tel"]').val(),
                customerEmail: jQuery('.js-covid-customer-form input[name="covid-email"]').val(),
            };

            //Отправляем данные
            var jqXHR = jQuery.post( covidBid.ajaxurl, data, function(response) {
                // console.log(response);
            });

            //Если получили статус 200
            jqXHR.success(function(response){

                // console.log('Ok');
                console.log(response);

                jQuery('.js-covid-customer-form-message').text('Запит вiдправлено.');

                //Reset input
                jQuery('.js-covid-customer-form input[name="covid-name"]').val('');
                jQuery('.js-covid-customer-form input[name="covid-surname"]').val('');
                jQuery('.js-covid-customer-form input[name="covid-tel"]').val('');
                jQuery('.js-covid-customer-form input[name="covid-email"]').val('');
                jQuery('.js-covid-customer-form input[name="covid-passport"]').val('');
                jQuery('.js-covid-customer-form input[name="covid-date"]').val('');
                jQuery('.js-covid-customer-form input[name="covid-address"]').val('');
                jQuery('.dd-list-input').text('Оберіть...');
                jQuery('.js-get-company-amount').html('');
                jQuery('.js-get-company-period').html('');
                jQuery('.js-get-insurance-price').html('');

                setTimeout(function(){
                    jQuery('.js-covid-customer-form-message').text('');
                    setTimeout(function(){
                        jQuery('.epol-modal-wrapper').removeClass('modal-open');
                    }, 2000);
                }, 3000);


                // AddingEventToList(response);

                // CloseEventlist();

                //Reset Data
                // eventData.val('');
                // eventData.attr('data-date', '');
                // eventData.attr('data-type', '');

            });

            //Если была ошибка
            jqXHR.fail(function(response){
                console.log('Fail message: ' + response);
                alert('Повторите попытку немного позже.');

            });

        }

            
            return false;

    });
});