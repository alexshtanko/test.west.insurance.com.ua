jQuery(document).ready(function(){

    ValidateOrderForm();

    function ValidateOrderForm(){

        message_required = 'Обов`язкове для заповнення.';
        message_lettersonly = 'Тiльки англiйськi лiтери.';
        message_letterandspace = 'Тiльки англiйськi лiтери, пробіл та тире.';
        message_lettersandnumbersonly = 'Тiльки англiйськi лiтери та цифри.';
        message_tel = 'Телефон введено не корректно.';
        message_email = 'Невiрно введено Email.';
        message_number = 'Будьласка введiть число.';
        message_address = 'Тiльки "," "." англiйськi лiтери та цифри.';
        message_date = 'Дата початку дiї договору не може бути менша за поточну.';

        company_id = jQuery('input[name="company_id"]').val();

        // message_year_limit = 'Страхувальник не може бути молодшим за 18 рокiв.';



        /*jQuery.validator.addMethod("insurerName", jQuery.validator.methods.required,
            'Обов`язкове для заповнення. 123' );

        jQuery.validator.addClassRules("test1", {
            // required: true,
            minlength: 2,
            insurerName: true,
        });*/

        jQuery('form#medicalForm').on('submit', function(event) {
            jQuery('.insurer-last-name').each(function() {
                jQuery(this).rules("add",
                    {
                        required: true,
                        lettersandspace: true,
                        messages: {
                            required: message_required,
                            lettersandspace: message_lettersandnumbersonly,
                        }
                    });
            });

        });

        jQuery('form#medicalForm').on('submit', function(event) {
            jQuery('.insurer-name').each(function() {
                jQuery(this).rules("add",
                    {
                        required: true,
                        lettersonly: true,
                        messages: {
                            required: message_required,
                            lettersonly: message_lettersonly,
                        }
                    });
            });
        });

        jQuery('form#medicalForm').on('submit', function(event) {
            jQuery('.insurer-date').each(function() {
                jQuery(this).rules("add",
                    {
                        required: true,
                        messages: {
                            required: message_required,
                        }
                    });
            });
        });

        jQuery('form#medicalForm').on('submit', function(event) {
            //Add validation rule for dynamically generated name fields
            jQuery('.insurer-passport').each(function() {
                jQuery(this).rules("add",
                    {
                        required: true,
                        addressonly: true,
                        messages: {
                            required: message_required,
                            addressonly: message_address,
                        }
                    });
            });

        });

        jQuery('form#medicalForm').on('submit', function(event) {
            //Add validation rule for dynamically generated name fields
            jQuery('.insurer-address').each(function() {
                jQuery(this).rules("add",
                    {
                        required: true,
                        addressonly: true,
                        messages: {
                            required: message_required,
                            addressonly: message_address,
                        }
                    });
            });

        });



        
        jQuery('#medicalForm').validate({
            errorClass: "inpt-error",
            rules: {
                medical_last_name: {
                    required: true,
                    // lettersonly: true,
                    lettersandspace: true,
                },
                medical_name: {
                    required: true,
                    lettersonly: true,
                },
                medical_passport: {
                    required: true,
                    addressonly: true,
                },
                medical_date: {
                    required: true,
                    year_limit: true,
                },
                medical_address: {
                    required: true,
                    addressonly: true,
                },
                medical_tel: {
                    // required: true,
                    // matches_telephone: true,
                },
                medical_date_start: {
                    required: true,
                    date: true,
                },
                medical_email: {
                    // required: true,
                    email: true,
                },
                medical_blank_number: {
                    required: true,
                    number: true,
                },
                medical_blank_series: {
                    required: true,
                },
                medical_sex: {
                    required: true,
                },
                medical_inn: {
                    // required: true,
                    // required: {
                    //     depends: function (element) {
                    //         return $("#medical_eddr").val() === '';
                    //     }
                    // },
                    number: true,
                },
                medical_eddr: {
                    // required: true,
                    // required: {
                    //     depends: function (element) {
                    //         return $("#medical_inn").val() === '';
                    //     }
                    // },
                },
            },            
            messages: {
                medical_last_name: {
                    required: message_required,
                    // lettersonly: message_lettersonly,
                    lettersandspace: message_letterandspace,
                },
                medical_name: {
                    required: message_required,
                    lettersonly: message_lettersonly,
                },
                medical_passport: {
                    required: message_required,
                    addressonly: message_address,
                },
                medical_date: {
                    required: message_required,
                    // year_limit: message_year_limit,
                },
                medical_address: {
                    required: message_required,
                    addressonly: message_address,
                },
                medical_tel: {
                    // required: message_required,
                    // matches_telephone: message_tel,
                },
                medical_date_start: {
                    required: message_required,
                    date: message_date,
                },
                medical_email: {
                    email: message_email,
                },
                medical_blank_number: {
                    required: message_required,
                    number: message_number,
                },
                medical_blank_series: {
                    required: message_required,
                },
                medical_sex: {
                    required: message_required,
                },
                medical_inn: {
                    required: message_required,
                    number: message_number,
                },
                medical_eddr: {
                    required: message_required,
                },

            },
            invalidHandler: function() {
                // $(this).find(":input.class-error:first").focus();
                jQuery('.inpt-error').parents('.dd-list-wrapper').find('.dd-list-input').addClass('inpt-error');

            },
            submitHandler: function(form) {

                surname = jQuery('input[name="medical_last_name"]').val();
                user_name = jQuery('input[name="medical_name"]').val();
                passport = jQuery('input[name="medical_passport"]').val();
                date = jQuery('input[name="medical_date"]').val();
                address = jQuery('input[name="medical_address"]').val();
                tel = jQuery('input[name="medical_tel"]').val();
                email = jQuery('input[name="medical_email"]').val();
                franchise = jQuery('input[name="company_franchise"]').val();
                period = jQuery('input[name="company_period"]').val();
                date_start = jQuery('input[name="medical_date_start"]').val();

                sex = '';
                if( jQuery('input[name="medical_sex"]').size() > 0 )
                {
                    sex = jQuery('input[name="medical_sex"]').val();
                }

                inn = '';
                if( jQuery('input[name="medical_inn"]').size() > 0 )
                {
                    inn = jQuery('input[name="medical_inn"]').val();
                }

                eddr = '';
                if( jQuery('input[name="medical_eddr"]').size() > 0 )
                {
                    eddr = jQuery('input[name="medical_eddr"]').val();
                }




                blank_type_id = jQuery('input[name="blank_type_id"]').val();
                blank_id = jQuery('input[name="medical_blank_id"]').val();
                blank_title = jQuery('input[name="blank_title"]').val();
                blank_series = jQuery('input[name="medical_blank_series"]').val();
                blank_number = jQuery('input[name="medical_blank_number"]').val();

                

                company_title = jQuery('input[name="company_title"]').val();
                company_id = jQuery('input[name="company_id"]').val();

                rate_id = jQuery('input[name="rate_id"]').val();
                rate_franchise = jQuery('input[name="rate_franchise"]').val();
                rate_validity = jQuery('input[name="rate_validity"]').val();
                rate_insured_sum = jQuery('input[name="rate_insured_sum"]').val();
                rate_price = jQuery('input[name="rate_price"]').val();
                rate_locations = jQuery('input[name="rate_locations"]').val();
                rate_coefficient = jQuery('input[name="rate_coefficient"]').val();

                rate_price_coefficient = jQuery('#priceCoefficient').val()*1;
                if( rate_price_coefficient == '' ){
                    rate_price_coefficient = 1;
                }
                console.log('rate_price_coefficient: ' + rate_price_coefficient);

                if(jQuery('#addInserer').attr("checked") != 'checked') {

                    insurer_status = 0;
                }
                else{

                    insurer_status = 1;

                }

                count = 1;

                insurers = [];

                rowCount = jQuery('.insurer-row').length;

                console.log('rowCount: ' + rowCount);

                count = 0;
                index = 1

                if( rowCount > 0 ){

                    for( count = 0; count < rowCount;  ) {

                        insurerLastName = jQuery('.insurer-row').eq(count).find('#insurerLastName' + index).val();
                        insurerName = jQuery('.insurer-row').eq(count).find('#insurerName' + index).val();
                        insurerDate = jQuery('.insurer-row').eq(count).find('#insurerDate' + index).val();
                        insurerPassport = jQuery('.insurer-row').eq(count).find('#insurerPassport' + index).val();
                        insurerAddress = jQuery('.insurer-row').eq(count).find('#insurerAddress' + index).val();


                        insurers[count] = {
                            lastName: insurerLastName,
                            name: insurerName,
                            date: insurerDate,
                            passport: insurerPassport,
                            address: insurerAddress,

                        }
                        count = count + 1;
                        index = index + 1;
                    }

                }


                // emp = JSON.stringify(emp);


                // return false;

                jQuery('.js-insurance-form .btn-get-it').val('Оформлення...');

                var data = {
                    action: 'medicalmcreateorder',
                    nonce: medicalmCreateOrder.nonce,
                    surname: surname,
                    name: user_name,
                    passport: passport,
                    date: date,
                    address: address,
                    tel: tel,
                    email: email,
                    franchise: franchise,
                    period: period,
                    date_start: date_start,
                    sex: sex,
                    inn: inn,
                    eddr: eddr,

                    blank_type_id: blank_type_id,
                    blank_id: blank_id,
                    blank_title: blank_title,
                    blank_series: blank_series,
                    blank_number: blank_number,

                    company_id: company_id,
                    company_title: company_title,

                    rate_id: rate_id,
                    rate_franchise: rate_franchise,
                    rate_validity: rate_validity,
                    rate_insured_sum: rate_insured_sum,
                    rate_price: rate_price,
                    rate_locations: rate_locations,
                    rate_coefficient: rate_coefficient,
                    rate_price_coefficient: rate_price_coefficient,

                    insurers: insurers,
                    insurer_status: insurer_status,
                    // test: insurerData,

                };

                console.log(data);
        
                //Отправляем данные
                var jqXHR = jQuery.post( medicalmCreateOrder.ajaxurl, data, function(response) {
                    // console.log(response);
                });
        
                //Если получили статус 200
                jqXHR.done(function(response){
        
                    data = JSON.parse(response);   

                    console.log(data.data);
                    console.log(data.status);
                    console.log(data.message);
                    console.log(data.last_step_html);

                    jQuery('.js-insurance-form .btn-get-it').val('Оформити полiс');
                    jQuery('.js-insurance-form-message').html(data.message);

                    if( data.status ){
                        // resetMessage();
                        jQuery('.js-insurance-form input').not('.js-insurance-form input[type=submit], .js-insurance-form [name=blank_title]').val('');
                        jQuery('.js-insurance-form .dd-list-input').text('Оберіть...');

                        jQuery('.js-insurance-form').slideUp(300);

                        jQuery('.js-insurance-form-last-step').html(data.last_step_html);

                        // window.location.href = "https://epolicy.com.ua/medical-m/";
                    }
                    

                    //Reset form data
                    // jQuery('.js-insurance-form').slideUp(300);
                    


        
                });
        
                //Если была ошибка
                jqXHR.fail(function(response){
        
                    console.log(response);

                    jQuery('.js-insurance-form-message').html(data.message);
                    resetMessage();
        
                    // alert('Сервер занят, попробуйте немного позже');
        
                });

            }

        });


        // jQuery( ".test" ).rules( "add", {
        //     required: true,
        //     minlength: 2,
        //     messages: {
        //         required: "Required input",
        //         minlength: jQuery.validator.format("Please, at least {0} characters are necessary")
        //     }
        // });




        //Возвращает колчество лет
        function age_count(date) {
            // now
            var now = new Date();
            now.setMinutes(now.getMinutes() - now.getTimezoneOffset());
            now = now.toISOString().substr(0, 19).replace('T',' ');
            // calculate
            var age = now.substr(0, 4) - date.substr(0, 4);
            if(now.substr(5) < date.substr(5)) --age;
            // output
            return age;
        }

        //Проверяет на возраст старше 18 лет
        jQuery.validator.addMethod("year_limit", function(value, element, params) {

            youser_date = value.split('.');
            youser_date = youser_date[2] + '-' + youser_date[1] + '-' + youser_date[0];

            youser_date = age_count( youser_date );

            company_id = jQuery('input[name="company_id"]').val();

            if( company_id == 4 ){
                return this.optional(element) || youser_date >= 16;
            }
            else{
                return this.optional(element) || youser_date >= 18;
            }


        // }, message_year_limit );
        }, function(error, element){

            company_id = jQuery('input[name="company_id"]').val();
            console.log('==========company_id===== ' + company_id);

            if( error != 'true' ){
                if( company_id == 4 )
                {
                    return 'Страхувальник не може бути молодшим за 16 рокiв.';
                }
                else
                {
                    return 'Страхувальник не може бути молодшим за 18 рокiв.';
                }
            }

        } );


        //Проверяет на возраст старше 18 лет
        jQuery.validator.addMethod("phone_required", function(value, element, params) {

            company_id = jQuery('input[name="company_id"]').val();

            if( company_id == 2 ){
                return this.optional(element) || youser_date >= 16;
            }
            else{
                return this.optional(element) || youser_date >= 18;
            }


            // }, message_year_limit );
        }, function(error, element){

            company_id = jQuery('input[name="company_id"]').val();
            console.log('==========company_id===== ' + company_id);

            if( error != 'true' ){
                if( company_id == 4 )
                {
                    return 'Страхувальник не може бути молодшим за 16 рокiв.';
                }
                else
                {
                    return 'Страхувальник не може бути молодшим за 18 рокiв.';
                }
            }

        } );


        // "([0-9]{10})|(\([0-9]{3}\)\s+[0-9]{3}\-[0-9]{4})"
        jQuery.validator.addMethod("lettersonly", function(value, element) {
            return this.optional(element) || /^[a-zA-Z]+$/i.test(value);
        }, message_required);
        jQuery.validator.addMethod("lettersandspace", function(value, element) {
            return this.optional(element) || /^[a-zA-Z -]+$/i.test(value);
        }, message_required);
        jQuery.validator.addMethod("lettersandnumbersonly", function(value, element) {
            return this.optional(element) || /^[a-zA-Z0-9]+$/i.test(value);
        }, message_lettersandnumbersonly ); 
        jQuery.validator.addMethod("addressonly", function(value, element) {
            return this.optional(element) || /^[a-zA-Z0-9 \/,.]+$/i.test(value);
        }, message_lettersandnumbersonly ); 
        jQuery.validator.addMethod("matches_telephone", function(value, element) {
            return this.optional(element) || /^(\+?\d+)?\s*(\(\d+\))?[\s-]*([\d-]*)$/i.test(value);
        }, message_tel );
        jQuery.validator.addMethod("date", function(value, element) {
            
            var now = new Date();
            var today = new Date(now.getFullYear(), now.getMonth(), now.getDate());
            today = today.getTime();
            var enter_date = value.split('.');
            enter_date = new Date( enter_date[1] + '.' + enter_date[0] + '.' + enter_date[2] );
            enter_date  = new Date(enter_date.getFullYear(), enter_date.getMonth(), enter_date.getDate());

            enter_date = enter_date.getTime();

            return this.optional(element) || enter_date >= today;

        }, message_date ); 
        
    }


    function resetMessage(){

        setTimeout(function(){
            jQuery('.js-insurance-form-message').html('');
        }, 5000);
    }
    
});