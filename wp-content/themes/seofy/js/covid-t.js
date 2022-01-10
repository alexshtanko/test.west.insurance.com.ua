jQuery(document).ready(function(){

    CovidClac();

    function CovidClac(){
        jQuery("input[name='covid-tel']").mask("+38 (099) 999-99-99");

        // jQuery.datepicker.regional['ua'] = {
        //     monthNames: ['Січень', 'Лютий', 'Березень', 'Квітень',
        //         'Травень', 'Червень', 'Липень', 'Серпень', 'Вересень',
        //         'Жовтень', 'Листопад', 'Грудень'],
        //     monthNamesShort: ['Сiч.', 'Лют.', 'Бер.', 'Квіт.',
        //         'Трав.', 'Черв.', 'Лип.', 'Серп.', 'Вер.',
        //         'Жовт.', 'Лист.', 'Груд.'],
        //     dayNamesMin: ['Нд','Пн','Вт','Ср','Чт','Пт','Сб'],
        //     firstDay: 1,
        // };
        //
        // jQuery.datepicker.setDefaults(jQuery.datepicker.regional['ua']);
        //
        // jQuery("input[name='user-date']").datepicker(
        //         {
        //             dateFormat: 'yy-mm-dd', maxDate: "0",
        //             changeMonth: true,
        //             changeYear: true
        //             //yearRange: "1920:" + ((new Date().getFullYear()))
        //         }
        //       );

        /*dd list*/

        jQuery(document).on('click', '.dd-list-wrapper .dd-arrow, .dd-list-wrapper .dd-list-input', function(){

            base = jQuery(this);

            if( !base.parents('.dd-list-wrapper').hasClass('dd-list-open') ){
                jQuery('.dd-list-wrapper').find('.dd-list').slideUp(300);
                jQuery('.dd-list-wrapper').removeClass('dd-list-open');

                base.parents('.dd-list-wrapper').toggleClass('dd-list-open');

                base.parents('.dd-list-wrapper').find('.dd-list').slideToggle(300);

            }
            else{
                jQuery('.dd-list-wrapper').find('.dd-list').slideUp(300);
                jQuery('.dd-list-wrapper').removeClass('dd-list-open');
            }

        })

        //Change value dd list
        jQuery(document).on('click', '.dd-list-wrapper .dd-list li', function(){

            base = jQuery(this);

            val = base.text();

            base.parents('.dd-list-wrapper').find('.dd-list-input').text(val);

            base.parents('.dd-list-wrapper').find('.dd-hide-filed').val(val);

            base.parents('.dd-list-wrapper').toggleClass('dd-list-open');
            base.parents('.dd-list-wrapper').find('.dd-list').slideToggle(300);

        });



        var data = [{
            "id" : 177,
            "name" : "Ю.Ес.Ай",
            "contracts" : [
                {"insuranceAmount": 10000, "period": 30, "minAge": 0, "maxAge": 64, "price": 100, "currency": "грн"},
                {"insuranceAmount": 10000, "period": 90, "minAge": 0, "maxAge": 64, "price": 150, "currency": "грн"},
                {"insuranceAmount": 10000, "period": 180, "minAge": 0, "maxAge": 64, "price": 250, "currency": "грн"},
                {"insuranceAmount": 10000, "period": 365, "minAge": 0, "maxAge": 64, "price": 400, "currency": "грн"},
                {"insuranceAmount": 20000, "period": 30, "minAge": 0, "maxAge": 64, "price": 190, "currency": "грн"},
                {"insuranceAmount": 20000, "period": 90, "minAge": 0, "maxAge": 64, "price": 280, "currency": "грн"},
                {"insuranceAmount": 20000, "period": 180, "minAge": 0, "maxAge": 64, "price": 470, "currency": "грн"},
                {"insuranceAmount": 20000, "period": 365, "minAge": 0, "maxAge": 64, "price": 760, "currency": "грн"},
                {"insuranceAmount": 40000, "period": 30, "minAge": 0, "maxAge": 64, "price": 340, "currency": "грн"},
                {"insuranceAmount": 40000, "period": 90, "minAge": 0, "maxAge": 64, "price": 500, "currency": "грн"},
                {"insuranceAmount": 40000, "period": 180, "minAge": 0, "maxAge": 64, "price": 860, "currency": "грн"},
                {"insuranceAmount": 40000, "period": 365, "minAge": 0, "maxAge": 64, "price": 1400, "currency": "грн"},
                {"insuranceAmount": 10000, "period": 30, "minAge": 65, "maxAge": 75, "price": 200, "currency": "грн"},
                {"insuranceAmount": 10000, "period": 90, "minAge": 65, "maxAge": 75, "price": 300, "currency": "грн"},
                {"insuranceAmount": 10000, "period": 180, "minAge": 65, "maxAge": 75, "price": 500, "currency": "грн"},
                {"insuranceAmount": 10000, "period": 365, "minAge": 65, "maxAge": 75, "price": 800, "currency": "грн"},
                {"insuranceAmount": 20000, "period": 30, "minAge": 65, "maxAge": 75, "price": 380, "currency": "грн"},
                {"insuranceAmount": 20000, "period": 90, "minAge": 65, "maxAge": 75, "price": 560, "currency": "грн"},
                {"insuranceAmount": 20000, "period": 180, "minAge": 65, "maxAge": 75, "price": 940, "currency": "грн"},
                {"insuranceAmount": 20000, "period": 365, "minAge": 65, "maxAge": 75, "price": 1520, "currency": "грн"},
                {"insuranceAmount": 40000, "period": 30, "minAge": 65, "maxAge": 75, "price": 680, "currency": "грн"},
                {"insuranceAmount": 40000, "period": 90, "minAge": 65, "maxAge": 75, "price": 1000, "currency": "грн"},
                {"insuranceAmount": 40000, "period": 180, "minAge": 65, "maxAge": 75, "price": 1720, "currency": "грн"},
                {"insuranceAmount": 40000, "period": 365, "minAge": 65, "maxAge": 75, "price": 1520, "currency": "грн"},
            ]
        },
            {
                "id": 6623,
                "name": "Український Страховий Стандарт",
                "contracts" : [
                    {"insuranceAmount": 5000, "period": 30, "minAge": 18, "maxAge": 75, "price": 80, "currency": "EUR"},
                    {"insuranceAmount": 5000, "period": 90, "minAge": 18, "maxAge": 75, "price": 160, "currency": "EUR"},
                    {"insuranceAmount": 5000, "period": 180, "minAge": 18, "maxAge": 75, "price": 240, "currency": "EUR"},
                    {"insuranceAmount": 5000, "period": 365, "minAge": 18, "maxAge": 75, "price": 600, "currency": "EUR"},
                    {"insuranceAmount": 5000, "period": 30, "minAge": 1, "maxAge": 17, "price": 120, "currency": "EUR"},
                    {"insuranceAmount": 5000, "period": 90, "minAge": 1, "maxAge": 17, "price": 240, "currency": "EUR"},
                    {"insuranceAmount": 5000, "period": 180, "minAge": 1, "maxAge": 17, "price": 360, "currency": "EUR"},
                    {"insuranceAmount": 5000, "period": 365, "minAge": 1, "maxAge": 17, "price": 900, "currency": "EUR"},
                    {"insuranceAmount": 5000, "period": 30, "minAge": 60, "maxAge": 65, "price": 160, "currency": "EUR"},
                    {"insuranceAmount": 5000, "period": 90, "minAge": 60, "maxAge": 65, "price": 320, "currency": "EUR"},
                    {"insuranceAmount": 5000, "period": 180, "minAge": 60, "maxAge": 65, "price": 480, "currency": "EUR"},
                    {"insuranceAmount": 5000, "period": 365, "minAge": 60, "maxAge": 65, "price": 1200, "currency": "EUR"},
                    {"insuranceAmount": 5000, "period": 30, "minAge": 66, "maxAge": 75, "price": 200, "currency": "EUR"},
                    {"insuranceAmount": 5000, "period": 90, "minAge": 66, "maxAge": 75, "price": 400, "currency": "EUR"},
                    {"insuranceAmount": 5000, "period": 180, "minAge": 66, "maxAge": 75, "price": 600, "currency": "EUR"},
                    {"insuranceAmount": 5000, "period": 365, "minAge": 66, "maxAge": 75, "price": 800, "currency": "EUR"},
                ],

            },
            {
                "id": 8,
                "name": "ВУСО",
                "contracts" : [
                    {"insuranceAmount": 10000, "period": 90, "minAge": 0, "maxAge": 59, "price": 150, "currency": "грн"},
                    {"insuranceAmount": 10000, "period": 90, "minAge": 60, "maxAge": 69, "price": 300, "currency": "грн"},
                ],

            },
        ];
        var periods = [30, 90, 180, 365];

        var ddListStart =   '<div class="dd-list-wrapper"><input class="dd-hide-filed" type="text" readonly="readonly"><div class="dd-arrow"></div>' +
            '<div class="dd-list-input">Оберіть...</div><ul class="dd-list type-of-car">';
        var ddLIstEnd =     '</ul></div>';

        //Step 0
        SelectInsurancePeriod();
        //Step 1
        SelectInsuranceAge();
        //Step 2
        InsuranceList();
        //Step 3
        GetCovidInsurance();

        ModalClose();


        function SelectInsurancePeriod(){
            renderInsurancePeriod = '<label>Оберiть перiод страхування (днiв)</label>' + ddListStart;

            for (i = 0; i < periods.length; i++){
                renderInsurancePeriod += '<li data-period="' + periods[i] + '">' + periods[i] + '</li>';
            }
            renderInsurancePeriod += ddLIstEnd;

            jQuery('#covidForm .js-select-insurance-period').html(renderInsurancePeriod);

        }

        function SelectInsuranceAge(){

            jQuery('body').on('click', '.js-select-insurance-period li', function(){
                renderAge = '<label>Скiльки Вам рокiв?</label>' + ddListStart;

                for (i = 1; i < 100; i++){
                    renderAge += '<li data-age="' + i + '">' + i + '</li>';
                }
                renderAge += ddLIstEnd;

                jQuery('#covidForm .js-select-insurance-age').html(renderAge);
                jQuery('#covidForm .js-insurance-list').html('');
            });

        }



        function InsuranceList(){

            jQuery('body').on('click', '.js-select-insurance-age li', function(){

                SetInsuranceList = new Array();


                insurancePeriod = jQuery('.js-select-insurance-period input').val();
                insuranceAge = jQuery(this).attr('data-age');
                // insuranceAge = 74;
                // insurancePeriod = 30;
                render = '';

                //Create Insurance List
                data.forEach((item, index, array) => {

                    InsuranceList = new Array();
                    iteration = 0;

                    item.contracts.forEach((contract, indexContr, array) => {


                        if( contract.period == insurancePeriod && contract.minAge <= insuranceAge && contract.maxAge >= insuranceAge ){

                            InsuranceList[iteration] = {
                                "contracts": {
                                    "insuranceAmount" : contract.insuranceAmount,
                                    "period": contract.period,
                                    "minAge": contract.minAge,
                                    "maxAge": contract.maxAge,
                                    "price": contract.price,
                                    "currency": contract.currency,
                                }
                            }

                            iteration ++;
                        }

                        if( InsuranceList.length != 0 ){

                            SetInsuranceList[index] = {
                                "id" : item.id,
                                "name": item.name,
                                "contracts": InsuranceList,
                            }

                        }
                    });
                });

                //Если есть страховки выводим список вариантов
                if( SetInsuranceList.length != 0 ){

                    insuranceListStart = '<div class="step-3-results-list">';
                    insuranceListEnd = '</div>';
                    insuranceListItemStart = '<div class="row step-3-results-item"><div class="vc_col-md-12"><div class="step-3-results-item-top">';
                    insuranceListItemEnd = '</div></div></div>';

                    renderInsuranceList = insuranceListStart;

                    SetInsuranceList.forEach((item, index, array) => {

                        //Render Company List Item START
                        renderInsuranceList += insuranceListItemStart;

                        //Render Company Logo and Compane Name
                        renderInsuranceList += '<div class="vc_col-sm-4 vc_col-md-4"><div class="company-logo"><img src="/plc/img/' + item.id + '.png" alt=""></div><div class="company-title">' + item.name + '</div></div>';

                        //Render Insurance Price
                        renderInsuranceList += '<div class="vc_col-sm-4 vc_col-md-4"><div class="step-3-dcv"><div class="step-3-results-item-title">Оберiть страхову суму</div>';

                        item.contracts.forEach((contract, indexContr, array) => {
                            if( indexContr == 0 ){
                                CheckedInsurancePrice = contract.contracts.price;
                                CheckedInsuranceAmount = contract.contracts.insuranceAmount;
                                CheckedInsurancecurrency = contract.contracts.currency;
                                renderInsuranceList += '<p><input type="radio" name="'+ item.id +'" id="'+ item.id + "" + indexContr +'" data-insurance-price="'+ contract.contracts.price +'" data-insurance-amount="'+ contract.contracts.insuranceAmount +'" checked><label data-insurance-price="'+ contract.contracts.price +'" data-insurance-amount="'+ contract.contracts.insuranceAmount +'" for="' + item.id + "" + indexContr +'">'+ contract.contracts.insuranceAmount +' ' + CheckedInsurancecurrency + ' </label></p>';
                            }
                            else{
                                renderInsuranceList += '<p><input type="radio" name="'+ item.id +'" id="'+ item.id + "" + indexContr +'" data-insurance-price="'+ contract.contracts.price +'" data-insurance-amount="'+ contract.contracts.insuranceAmount +'"><label data-insurance-price="'+ contract.contracts.price +'" data-insurance-amount="'+ contract.contracts.insuranceAmount +'" for="' + item.id + "" + indexContr +'">'+ contract.contracts.insuranceAmount +' ' + CheckedInsurancecurrency + '</label></p>';
                            }
                        });

                        renderInsuranceList += '</div></div>';

                        //Render Insurance Amount
                        //renderInsuranceList += '<div class="vc_col-sm-4 vc_col-md-2"><div class="step-3-price"><div class="step-3-results-item-title">Страхова сума</div><span class="price js-insurance-anount">' + CheckedInsuranceAmount + '</span><span class="currency"> '+ CheckedInsurancecurrency +'</span></div></div>';

                        //Render Insurance Price
                        renderInsuranceList += '<div class="vc_col-sm-4 vc_col-md-2"><div class="step-3-price"><div class="step-3-results-item-title">Цiна</div><span class="price js-insurance-price">'+ CheckedInsurancePrice +'</span><span class="currency"> грн</span></div></div>';

                        //Render Button
                        renderInsuranceList += '<div class="vc_col-md-2"><button data-company-id="'+ item.id +'" data-cmpany-name="'+ item.name +'" data-insurance-currency="'+ CheckedInsurancecurrency +'" data-insurance-period="'+ insurancePeriod +'" data-insurance-price="'+ CheckedInsurancePrice +'" data-insurance-amount="'+ CheckedInsuranceAmount +'" class="btn-get-it js-get-insurance">Придбати</button></div>';

                        //Render Company List Item END
                        renderInsuranceList += insuranceListItemEnd;

                    });

                    renderInsuranceList += insuranceListEnd;

                    //Render InsuranceList
                    jQuery('#covidForm .js-insurance-list').html(renderInsuranceList);

                }
                else{
                    alert('Нiчого не знайдено!');
                    jQuery('#covidForm .js-insurance-list').html('');
                }

                //Change Insurance Price
                jQuery('body').on('click', '.js-insurance-list label', function(){

                    base = jQuery(this);

                    insurancePrice = base.attr('data-insurance-price');
                    insuranceAmount = base.attr('data-insurance-amount');

                    base.parents('.step-3-results-item').find('.js-insurance-anount').text(insuranceAmount);
                    base.parents('.step-3-results-item').find('.js-insurance-price').text(insurancePrice);

                    base.parents('.step-3-results-item').find('.js-get-insurance').attr('data-insurance-amount', insuranceAmount);
                    base.parents('.step-3-results-item').find('.js-get-insurance').attr('data-insurance-price', insurancePrice);

                });



                //Test
                // SetInsuranceList.forEach((item, index, array) => {
                //     console.log(item);
                // });


            });



        } //InsuranceList end

        function GetCovidInsurance(){
            jQuery('body').on('click', '.js-get-insurance', function(e){

                base = jQuery(this);


                jQuery('#covidForm input').each(function(){
                    inptValue = jQuery(this).val();

                    if( inptValue == '' ){
                        jQuery(this).addClass('covid-error');
                    }
                    else{
                        jQuery(this).removeClass('covid-error');
                    }
                });

                if(jQuery('#covidForm input').hasClass('covid-error')){
                    alert('Потрібно заповнити всі поля форми!');
                }
                else{



                    companyId = base.attr('data-company-id');
                    companyAmount = base.attr('data-insurance-amount');
                    companyPeriod = base.attr('data-insurance-period');
                    // insurancePrice = base.attr('data-insurance-price');

                    jQuery('.js-covid-customer-form').find('input[name=company-id]').val(companyId);
                    jQuery('.js-covid-customer-form').find('input[name=company-amount]').val(companyAmount);
                    jQuery('.js-covid-customer-form').find('input[name=company-period]').val(companyPeriod);


                    jQuery('.epol-modal-wrapper').addClass('modal-open');
                    jQuery('body').addClass('modal-open');


                }


                e.preventDefault();
                return false;


            })
        }






        function ModalClose(){
            jQuery('.js-epol-modal-close').on('click', function(){
                jQuery('.epol-modal-wrapper').removeClass('modal-open');
                jQuery('body').removeClass('modal-open');
            });

            jQuery(document).mouseup(function (e){ // событие клика по веб-документу
                var div = jQuery(".epol-modal"); // тут указываем ID элемента
                if (!div.is(e.target) // если клик был не по нашему блоку
                    && div.has(e.target).length === 0) { // и не по его дочерним элементам
                    //div.hide(); // скрываем его
                    jQuery('.epol-modal-wrapper').removeClass('modal-open');
                    jQuery('body').removeClass('modal-open');
                }
            });
        }


        jQuery('form.js-covid-customer-form').submit(function(e) {
            e.preventDefault(); // avoid to execute the actual submit of the form.

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
            else {
                jQuery(this).find("input[type='submit']").prop('disabled', true).val('Завантаження...');

                var form = jQuery(this);
                var url = form.attr('action');

                jQuery.ajax({
                    type: "POST",
                    url: url,
                    data: form.serialize(), // serializes the form's elements.
                    success: function (data) {
                        var request = JSON.parse(data);
                        if (request.status == "OK") {
                            //if(!alert(request.data)){
                            window.location = '/plc/c/payment_covid-t.php?code=' + request.code;
                            //}
                        } else {
                            alert(request.data);
                        }

                        jQuery('form#checkoutForm').find("input[type='submit']").prop('disabled', false).val('Сплатити');
                    }
                });
            }
        });

    }

});