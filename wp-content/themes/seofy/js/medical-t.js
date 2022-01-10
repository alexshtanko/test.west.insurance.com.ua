jQuery(document).ready(function(){

    MedicalClac();

    function MedicalClac(){
        jQuery("input[name='medical-tel']").mask("+38 (099) 999-99-99");

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
                {"insuranceAmount": 30000, "insuranceCurrency": "EUR", "franchiseAmount": 200, "franchiseCurrency": "EUR", "period": "365/365", "minAge": 3, "maxAge": 60, "price": 480},
                {"insuranceAmount": 30000, "insuranceCurrency": "EUR", "franchiseAmount": 200, "franchiseCurrency": "EUR", "period": "365/180", "minAge": 3, "maxAge": 60, "price": 220},
                {"insuranceAmount": 30000, "insuranceCurrency": "EUR", "franchiseAmount": 200, "franchiseCurrency": "EUR", "period": "365/90", "minAge": 3, "maxAge": 60, "price": 140},
                {"insuranceAmount": 30000, "insuranceCurrency": "EUR", "franchiseAmount": 200, "franchiseCurrency": "EUR", "period": "365/30", "minAge": 3, "maxAge": 60, "price": 85},
                {"insuranceAmount": 30000, "insuranceCurrency": "EUR", "franchiseAmount": 200, "franchiseCurrency": "EUR", "period": "180/90", "minAge": 3, "maxAge": 60, "price": 140},
                {"insuranceAmount": 30000, "insuranceCurrency": "EUR", "franchiseAmount": 200, "franchiseCurrency": "EUR", "period": "180/60", "minAge": 3, "maxAge": 60, "price": 110},
                {"insuranceAmount": 30000, "insuranceCurrency": "EUR", "franchiseAmount": 200, "franchiseCurrency": "EUR", "period": "180/30", "minAge": 3, "maxAge": 60, "price": 85},
                {"insuranceAmount": 30000, "insuranceCurrency": "EUR", "franchiseAmount": 200, "franchiseCurrency": "EUR", "period": "60/30", "minAge": 3, "maxAge": 60, "price": 85},
                {"insuranceAmount": 30000, "insuranceCurrency": "EUR", "franchiseAmount": 200, "franchiseCurrency": "EUR", "period": "30/10", "minAge": 3, "maxAge": 60, "price": 70},
                {"insuranceAmount": 30000, "insuranceCurrency": "EUR", "franchiseAmount": 0, "franchiseCurrency": "EUR", "period": "365/365", "minAge": 3, "maxAge": 60, "price": 944},
                {"insuranceAmount": 30000, "insuranceCurrency": "EUR", "franchiseAmount": 0, "franchiseCurrency": "EUR", "period": "365/180", "minAge": 3, "maxAge": 60, "price": 504},
                {"insuranceAmount": 30000, "insuranceCurrency": "EUR", "franchiseAmount": 0, "franchiseCurrency": "EUR", "period": "365/90", "minAge": 3, "maxAge": 60, "price": 368},
                {"insuranceAmount": 30000, "insuranceCurrency": "EUR", "franchiseAmount": 0, "franchiseCurrency": "EUR", "period": "365/30", "minAge": 3, "maxAge": 60, "price": 196},
                {"insuranceAmount": 30000, "insuranceCurrency": "EUR", "franchiseAmount": 0, "franchiseCurrency": "EUR", "period": "180/90", "minAge": 3, "maxAge": 60, "price": 368},
                {"insuranceAmount": 30000, "insuranceCurrency": "EUR", "franchiseAmount": 0, "franchiseCurrency": "EUR", "period": "180/60", "minAge": 3, "maxAge": 60, "price": 316},
                {"insuranceAmount": 30000, "insuranceCurrency": "EUR", "franchiseAmount": 0, "franchiseCurrency": "EUR", "period": "180/30", "minAge": 3, "maxAge": 60, "price": 196},
                {"insuranceAmount": 30000, "insuranceCurrency": "EUR", "franchiseAmount": 0, "franchiseCurrency": "EUR", "period": "60/30", "minAge": 3, "maxAge": 60, "price": 196},
                {"insuranceAmount": 30000, "insuranceCurrency": "EUR", "franchiseAmount": 0, "franchiseCurrency": "EUR", "period": "30/10", "minAge": 3, "maxAge": 60, "price": 124}
            ]
        },
            {
                "id": 6623,
                "name": "Український Страховий Стандарт",
                "contracts" : [
                    {"insuranceAmount": 30000, "insuranceCurrency": "EUR", "franchiseAmount": 100, "franchiseCurrency": "EUR", "period": "365/365", "minAge": 18, "maxAge": 75, "price": 410},
                    {"insuranceAmount": 30000, "insuranceCurrency": "EUR", "franchiseAmount": 100, "franchiseCurrency": "EUR", "period": "365/180", "minAge": 18, "maxAge": 75, "price": 240},
                    {"insuranceAmount": 30000, "insuranceCurrency": "EUR", "franchiseAmount": 100, "franchiseCurrency": "EUR", "period": "365/90", "minAge": 18, "maxAge": 75, "price": 140},
                    {"insuranceAmount": 30000, "insuranceCurrency": "EUR", "franchiseAmount": 100, "franchiseCurrency": "EUR", "period": "365/60", "minAge": 18, "maxAge": 75, "price": 120},
                    {"insuranceAmount": 30000, "insuranceCurrency": "EUR", "franchiseAmount": 100, "franchiseCurrency": "EUR", "period": "365/30", "minAge": 1, "maxAge": 17, "price": 60},
                    {"insuranceAmount": 30000, "insuranceCurrency": "EUR", "franchiseAmount": 100, "franchiseCurrency": "EUR", "period": "365/15", "minAge": 1, "maxAge": 17, "price": 50}
                ],

            },
            {
                "id": 8,
                "name": "ВУСО",
                "contracts" : [
                    {"insuranceAmount": 30000, "insuranceCurrency": "EUR", "franchiseAmount": 100, "franchiseCurrency": "EUR", "period": "365/365", "minAge": 3, "maxAge": 60, "price": 450},
                    {"insuranceAmount": 30000, "insuranceCurrency": "EUR", "franchiseAmount": 100, "franchiseCurrency": "EUR", "period": "365/180", "minAge": 3, "maxAge": 60, "price": 225},
                    {"insuranceAmount": 30000, "insuranceCurrency": "EUR", "franchiseAmount": 100, "franchiseCurrency": "EUR", "period": "365/90", "minAge": 3, "maxAge": 60, "price": 138},
                    {"insuranceAmount": 30000, "insuranceCurrency": "EUR", "franchiseAmount": 100, "franchiseCurrency": "EUR", "period": "365/60", "minAge": 3, "maxAge": 60, "price": 125},
                    {"insuranceAmount": 30000, "insuranceCurrency": "EUR", "franchiseAmount": 0, "franchiseCurrency": "EUR", "period": "365/365", "minAge": 3, "maxAge": 60, "price": 938},
                    {"insuranceAmount": 30000, "insuranceCurrency": "EUR", "franchiseAmount": 0, "franchiseCurrency": "EUR", "period": "365/180", "minAge": 3, "maxAge": 60, "price": 500},
                    {"insuranceAmount": 30000, "insuranceCurrency": "EUR", "franchiseAmount": 0, "franchiseCurrency": "EUR", "period": "365/90", "minAge": 3, "maxAge": 60, "price": 375},
                    {"insuranceAmount": 30000, "insuranceCurrency": "EUR", "franchiseAmount": 0, "franchiseCurrency": "EUR", "period": "365/60", "minAge": 3, "maxAge": 60, "price": 188}
                ],

            },
        ];
        var periods = ["30/10", "60/30", "180/30", "180/60", "180/90", "365/15", "365/15", "365/30", "365/60", "365/90", "365/180", "365/365"];

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
        GetMedicalInsurance();

        ModalClose();


        function SelectInsurancePeriod(){
            renderInsurancePeriod = '<label>Оберiть перiод страхування (днiв)</label>' + ddListStart;

            for (i = 0; i < periods.length; i++){
                renderInsurancePeriod += '<li data-period="' + periods[i] + '">' + periods[i] + '</li>';
            }
            renderInsurancePeriod += ddLIstEnd;

            jQuery('#medicalForm .js-select-insurance-period').html(renderInsurancePeriod);

        }

        function SelectInsuranceAge(){

            jQuery('body').on('click', '.js-select-insurance-period li', function(){
                renderAge = '<label>Скiльки Вам рокiв?</label>' + ddListStart;

                for (i = 1; i < 100; i++){
                    renderAge += '<li data-age="' + i + '">' + i + '</li>';
                }
                renderAge += ddLIstEnd;

                jQuery('#medicalForm .js-select-insurance-age').html(renderAge);
                jQuery('#medicalForm .js-insurance-list').html('');
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
                                    "franchiseAmount" : contract.franchiseAmount,
                                    "franchiseCurrency": contract.franchiseCurrency,
                                    "insuranceAmount" : contract.insuranceAmount,
                                    "insuranceCurrency": contract.insuranceCurrency,
                                    "period": contract.period,
                                    "minAge": contract.minAge,
                                    "maxAge": contract.maxAge,
                                    "price": contract.price
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
                    insuranceListStart = "<div class='InsuranceAmountText'>Страхова сума: 30000 EUR</div>";
                    insuranceListStart += '<div class="step-3-results-list">';
                    insuranceListEnd = '</div>';
                    insuranceListItemStart = '<div class="row step-3-results-item"><div class="vc_col-md-12"><div class="step-3-results-item-top">';
                    insuranceListItemEnd = '</div></div></div>';

                    renderInsuranceList = insuranceListStart;

                    SetInsuranceList.forEach((item, index, array) => {

                        //Render Company List Item START
                        renderInsuranceList += insuranceListItemStart;

                        //Render Company Logo and Company Name
                        renderInsuranceList += '<div class="vc_col-sm-4 vc_col-md-4"><div class="company-logo"><img src="/plc/img/' + item.id + '.png" alt=""></div><div class="company-title">' + item.name + '</div></div>';

                        //Render Insurance Price
                        renderInsuranceList += '<div class="vc_col-sm-4 vc_col-md-4"><div class="step-3-dcv"><div class="step-3-results-item-title">Оберiть франшизу</div>';

                        item.contracts.forEach((contract, indexContr, array) => {
                            dataInsuranceAmount = contract.contracts.insuranceAmount;
                            dataCurrencyInsurance = contract.contracts.insuranceCurrency;
                            dataInsuranceAmountText = '<span class="insuranceAmount">(Страхова сума: '+dataInsuranceAmount+' '+dataCurrencyInsurance +')</span>';

                            if( indexContr == 0 ){
                                CheckedInsurancePrice = contract.contracts.price;
                                CheckedInsuranceAmount = contract.contracts.franchiseAmount;
                                CheckedInsurancecurrency = contract.contracts.franchiseCurrency;

                                renderInsuranceList += '<p><input type="radio" name="'+ item.id +'" id="'+ item.id + "" + indexContr +'" data-insurance-price="'+ contract.contracts.price +'" data-insurance-amount="'+ contract.contracts.insuranceAmount +'" data-franchise-amount="'+ contract.contracts.franchiseAmount +'" checked><label data-insurance-price="'+ contract.contracts.price +'" data-franchise-amount="'+ contract.contracts.franchiseAmount +'" for="' + item.id + "" + indexContr +'">'+ contract.contracts.franchiseAmount +' ' + CheckedInsurancecurrency + ' </label></p>';
                            }
                            else{
                                renderInsuranceList += '<p><input type="radio" name="'+ item.id +'" id="'+ item.id + "" + indexContr +'" data-insurance-price="'+ contract.contracts.price +'" data-insurance-amount="'+ contract.contracts.insuranceAmount +'" data-franchise-amount="'+ contract.contracts.franchiseAmount +'"><label data-insurance-price="'+ contract.contracts.price +'" data-franchise-amount="'+ contract.contracts.franchiseAmount +'" for="' + item.id + "" + indexContr +'">'+ contract.contracts.franchiseAmount +' ' + CheckedInsurancecurrency + ' </label></p>';
                            }
                        });

                        renderInsuranceList += '</div></div>';

                        //Render Insurance Amount
                        //renderInsuranceList += '<div class="vc_col-sm-4 vc_col-md-2"><div class="step-3-price"><div class="step-3-results-item-title">Страхова сума</div><span class="price js-insurance-anount">' + CheckedInsuranceAmount + '</span><span class="currency"> '+ CheckedInsurancecurrency +'</span></div></div>';

                        //Render Insurance Price
                        renderInsuranceList += '<div class="vc_col-sm-4 vc_col-md-2"><div class="step-3-price"><div class="step-3-results-item-title">Цiна</div><span class="price js-insurance-price">'+ CheckedInsurancePrice +'</span><span class="currency"> грн</span></div></div>';

                        //Render Button
                        renderInsuranceList += '<div class="vc_col-md-2"><button data-company-id="'+ item.id +'" data-cmpany-name="'+ item.name +'" data-insurance-currency="'+ CheckedInsurancecurrency +'" data-insurance-period="'+ insurancePeriod +'" data-insurance-price="'+ CheckedInsurancePrice +'" data-franchise-amount="'+ CheckedInsuranceAmount +'" class="btn-get-it js-get-insurance">Придбати</button></div>';

                        //Render Company List Item END
                        renderInsuranceList += insuranceListItemEnd;

                    });

                    renderInsuranceList += insuranceListEnd;

                    //Render InsuranceList
                    jQuery('#medicalForm .js-insurance-list').html(renderInsuranceList);

                }
                else{
                    alert('Нiчого не знайдено!');
                    jQuery('#medicalForm .js-insurance-list').html('');
                }

                //Change Insurance Price
                jQuery('body').on('click', '.js-insurance-list label', function(){
                    console.log("ttt");

                    base = jQuery(this);

                    insurancePrice = base.attr('data-insurance-price');
                    insuranceAmount = base.attr('data-franchise-amount');

                    base.parents('.step-3-results-item').find('.data-franchise-amount').text(insuranceAmount);
                    base.parents('.step-3-results-item').find('.js-insurance-price').text(insurancePrice);

                    base.parents('.step-3-results-item').find('.js-get-insurance').attr('data-franchise-amount', insuranceAmount);
                    base.parents('.step-3-results-item').find('.js-get-insurance').attr('data-insurance-price', insurancePrice);

                });

            });



        } //InsuranceList end

        function GetMedicalInsurance(){
            jQuery('body').on('click', '.js-get-insurance', function(e){

                base = jQuery(this);


                jQuery('#medicalForm input').each(function(){
                    inptValue = jQuery(this).val();

                    if( inptValue == '' ){
                        jQuery(this).addClass('medical-error');
                    }
                    else{
                        jQuery(this).removeClass('medical-error');
                    }
                });

                if(jQuery('#medicalForm input').hasClass('medical-error')){
                    alert('Потрібно заповнити всі поля форми!');
                }
                else{



                    companyId = base.attr('data-company-id');
                    companyFranchise = base.attr('data-franchise-amount');
                    companyPeriod = base.attr('data-insurance-period');
                    // insurancePrice = base.attr('data-insurance-price');

                    jQuery('.js-medical-customer-form').find('input[name=company-id]').val(companyId);
                    jQuery('.js-medical-customer-form').find('input[name=company-franchise]').val(companyFranchise);
                    jQuery('.js-medical-customer-form').find('input[name=company-period]').val(companyPeriod);


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


        jQuery('form.js-medical-customer-form').submit(function(e) {
            e.preventDefault(); // avoid to execute the actual submit of the form.

            jQuery('.js-medical-customer-form input').each(function(){
                inptValue = jQuery(this).val();

                if( inptValue == '' ){
                    jQuery(this).addClass('medical-error');
                }
                else{
                    jQuery(this).removeClass('medical-error');
                }
            });

            if(jQuery('.js-medical-customer-form input').hasClass('medical-error')){
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
                            window.location = '/plc/c/payment_medical-t.php?code=' + request.code;
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