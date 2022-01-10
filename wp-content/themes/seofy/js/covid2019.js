jQuery(document).ready(function(){

    //Datapicker

    jQuery.datepicker.regional['ua'] = {
        monthNames: ['Січень', 'Лютий', 'Березень', 'Квітень',
            'Травень', 'Червень', 'Липень', 'Серпень', 'Вересень',
            'Жовтень', 'Листопад', 'Грудень'],
        monthNamesShort: ['Сiч.', 'Лют.', 'Бер.', 'Квіт.',
            'Трав.', 'Черв.', 'Лип.', 'Серп.', 'Вер.',
            'Жовт.', 'Лист.', 'Груд.'],
        dayNamesMin: ['Нд','Пн','Вт','Ср','Чт','Пт','Сб'],
        firstDay: 1,
    };

    jQuery.datepicker.setDefaults(jQuery.datepicker.regional['ua']);

    //Datapicker
    jQuery('#medical_date').datepicker({
        beforeShow: function(input, inst) {
            jQuery('#ui-datepicker-div').removeClass(function() {
                return jQuery('input').get(0).id;
            });
            jQuery('#ui-datepicker-div').addClass(this.id);
        },
        showOn: "button",
        buttonImage: "/wp-content/themes/seofy/img/small-calendar.svg",
        buttonImageOnly: true,
        buttonText: "Оберiть дату",
        maxDate: "-1Y",
        dateFormat: 'dd.mm.yy',
        changeMonth: true,
        changeYear: true,
        // yearRange: "1920:" + ((new Date().getFullYear()) - 18),
        yearRange: "1920:" + ((new Date().getFullYear()) - 1),
        // minDate: -18,
        // yearRange: "1920:",
    });

    //Datapicker
    jQuery('#medical_date_start').datepicker({
        beforeShow: function(input, inst) {
            jQuery('#ui-datepicker-div').removeClass(function() {
                return jQuery('input').get(0).id;
            });
            jQuery('#ui-datepicker-div').addClass(this.id);
        },
        showOn: "button",
        buttonImage: "/wp-content/themes/seofy/img/small-calendar.svg",
        buttonImageOnly: true,
        buttonText: "Оберiть дату",
        minDate: 0,
        dateFormat: 'dd.mm.yy',
        changeMonth: true,
        changeYear: true,
    });

    //Datapicker
    /*jQuery('.add-data-picker').datepicker({
        beforeShow: function(input, inst) {
            jQuery('#ui-datepicker-div').removeClass(function() {
                return jQuery('input').get(0).id;
            });
            jQuery('#ui-datepicker-div').addClass(this.id);
        },
        showOn: "button",
        buttonImage: "/wp-content/themes/seofy/img/small-calendar.svg",
        buttonImageOnly: true,
        buttonText: "Оберiть дату",
        maxDate: "-1Y",
        dateFormat: 'dd.mm.yy',
        changeMonth: true,
        changeYear: true,
        // yearRange: "1920:" + ((new Date().getFullYear()) - 18),
        yearRange: "1920:" + ((new Date().getFullYear()) - 1),
        // minDate: -1,
        // yearRange: "1920:",
    });*/

    jQuery("#medical_tel").mask("+38 (099) 999-99-99");
    jQuery("#medical_date").mask("99.99.9999", {placeholder: "дд.мм.рррр"});
    jQuery("#medical_date_start").mask("99.99.9999", {placeholder: "дд.мм.рррр"});
    jQuery(".js-insurer-date").mask("99.99.9999", {placeholder: "дд.мм.рррр"});

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

    // jQuery('body').on('click', '.js-insurance-list label', function(){
    jQuery('body').on('click', '.js-insurance-list label.js-label-insurance-price', function(){

        id = jQuery(this).parents('p').find('input').attr('id');
        ChangePrice(id);
        /*base = jQuery(this);

        insurancePrice = base.attr('data-insurance-price');
        insuranceAmount = base.attr('data-franchise-amount');
        rateLocation = base.attr('data-rate-location');
        rateId = base.attr('for');

        base.parents('.step-3-results-item').find('.data-franchise-amount').text(insuranceAmount);
        base.parents('.step-3-results-item').find('.js-insurance-price').text(insurancePrice);


        base.parents('.step-3-results-item').find('.js-get-insurance').attr('data-franchise-amount', insuranceAmount);
        base.parents('.step-3-results-item').find('.js-get-insurance').attr('data-insurance-price', insurancePrice);

        base.parents('.step-3-results-item').find('.js-get-insurance').attr('data-rate-locations', rateLocation);
        base.parents('.step-3-results-item').find('.js-get-insurance').attr('data-rate-id', rateId);

        base.parents('.step-3-results-item').find('.js-get-insurance').attr('data-rate-price', insurancePrice);
        base.parents('.step-3-results-item').find('.js-get-insurance').attr('data-rate-franchise', insuranceAmount);*/

    });

    //Изменяем цену страховки
    ChangePrice();
    function ChangePrice(id)
    {

        base = id;

        // insurancePrice = base.attr('data-insurance-price');
        // insuranceAmount = base.attr('data-franchise-amount');
        // rateLocation = base.attr('data-rate-location');
        // rateId = base.attr('for');
        insurancePrice = jQuery('#'+base).attr('data-insurance-price');
        insuranceAmount = jQuery('#'+base).attr('data-franchise-amount');
        rateLocation = jQuery('#'+base).attr('data-rate-location');
        // rateId = jQuery('#'+base).attr('for');
        rateId = id;
        insuredSum = jQuery('#'+base).attr('data-insured-sum');

        jQuery('#'+base).parents('.step-3-results-item').find('.data-franchise-amount').text(insuranceAmount);
        jQuery('#'+base).parents('.step-3-results-item').find('.js-insurance-price').text(insurancePrice);


        jQuery('#'+base).parents('.step-3-results-item').find('.js-get-insurance').attr('data-franchise-amount', insuranceAmount);
        jQuery('#'+base).parents('.step-3-results-item').find('.js-get-insurance').attr('data-insurance-price', insurancePrice);

        jQuery('#'+base).parents('.step-3-results-item').find('.js-get-insurance').attr('data-rate-locations', rateLocation);
        jQuery('#'+base).parents('.step-3-results-item').find('.js-get-insurance').attr('data-rate-id', rateId);

        jQuery('#'+base).parents('.step-3-results-item').find('.js-get-insurance').attr('data-rate-price', insurancePrice);
        jQuery('#'+base).parents('.step-3-results-item').find('.js-get-insurance').attr('data-rate-franchise', insuranceAmount);

        jQuery('#'+base).parents('.step-3-results-item').find('.js-get-insurance').attr('data-rate-insured-sum', insuredSum);


    }

    //Change value dd list
    jQuery(document).on('click', '.dd-list-wrapper .dd-list li', function(){

        base = jQuery(this);

        title = base.text();
        val = base.attr('data-value');
        console.log('val: ' + val);

        base.parents('.dd-list-wrapper').find('.dd-list-input').text(title);

        base.parents('.dd-list-wrapper').find('.dd-hide-filed').val(val).change().click();

        base.parents('.dd-list-wrapper').toggleClass('dd-list-open');
        base.parents('.dd-list-wrapper').find('.dd-list').slideToggle(300);

        if( base.hasClass('js-blank') ){
            jQuery('input[name=blank_title]').val(title);
            jQuery('.js-insurance-data-blank-title span').text( title );
        }

    });


    //Начало программы
    Start();

    function Start(){

            MedicalM();

    }

    InsuranceList();

    function MedicalM(){



        SelectBlank();

        jQuery('body').on('click', '.js-select-insurance-blank li', function(){

            blank_id = jQuery(this).attr('data-value');

            jQuery('.js-select-insurance-period').html('');
            jQuery('.js-insurance-list').html('');

            //Получем период страхования
            MedicalMGetData(blank_id);

            jQuery('.js-select-insurance-period').html('Завантаження...');
            MedicalInsuranceBlankSeries(blank_id);

            //Reset form data
            jQuery('.js-insurance-form').slideUp(300);
            jQuery('.js-insurance-form input').not('.js-insurance-form input[type=submit], .js-insurance-form [name=blank_title], #medical_blank_series, #blank_type_id').val('');
            jQuery('.js-insurance-form .dd-list-input').text('Оберіть...');

        });
    }



    function MedicalMGetData(blank_id){

        var data = {
            action: 'covidperiod',
            nonce: medicalM.nonce,
            blank_id: blank_id,
        };

        //Отправляем данные
        var jqXHR = jQuery.post( medicalM.ajaxurl, data, function(response) {
            // console.log(response);

        });

        //Если получили статус 200
        jqXHR.done(function(response){

            data = JSON.parse(response);

            result = MedicalMRender(data.results);

            // jQuery('.js-test').html(result);

            // console.log('message: ' + data.message);

            var ddListStart =   '<div class="dd-list-wrapper"><input class="dd-hide-filed" type="text" readonly="readonly"><div class="dd-arrow"></div>' +
                '<div class="dd-list-input">Оберіть...</div><ul class="dd-list type-of-car">';
            var ddLIstEnd =     '</ul></div>';


            if( data.results != '' ){
                jQuery('.js-message').html('');
                //Step 1
                SelectInsurancePeriod( ddListStart, ddLIstEnd, data.results );
            }
            else{
                jQuery('.js-message').html('<span class="message-danger">Результатів не знайдено. Будь ласка оберiть іншу програму.</span>');
            }


            //Step 1
            // SelectInsuranceAge( ddListStart, ddLIstEnd );

            //Step 2




        });

        //Если была ошибка
        jqXHR.fail(function(response){

            // console.log(response);

            alert('Сервер занят, попробуйте немного позже');

        });

    }

    function MedicalMRender(val){

        all_data = val;

        result = '';

        all_data.forEach(element => {

            result += 'validity: ' + element.validity;

        });

        return result;
    }


    function SelectInsurancePeriod( ddListStart, ddLIstEnd, val ){

        all_data = val;

        renderInsurancePeriod = '<label>Оберiть перiод страхування (днiв)</label>' + ddListStart;

        all_data.forEach(element => {
            renderInsurancePeriod += '<li data-value="' + element.validity + '">' + element.validity + '</li>';
        });
        renderInsurancePeriod += ddLIstEnd;

        jQuery('#medicalForm .js-select-insurance-period').html(renderInsurancePeriod);

    }



    function SelectBlank(){

        blank_type_id = jQuery('#blank_type_id').val();

        var data = {
            action: 'covidgetblanks',
            nonce: medicalM.nonce,
            blank_type_id: blank_type_id,
        };

        //Отправляем данные
        var jqXHR = jQuery.post( medicalM.ajaxurl, data, function(response) {
            // console.log(response);
        });

        //Если получили статус 200
        jqXHR.done(function(response){

            data = JSON.parse(response);

            // console.log(data.message);
            // console.log(data.blanks);

            var ddListStart =   '<div class="dd-list-wrapper"><input class="dd-hide-filed" name="medical_blank_id" id="medical_blank_id" type="text" readonly="readonly"><div class="dd-arrow"></div>' +
                '<div class="dd-list-input">Оберіть...</div><ul class="dd-list type-of-car">';
            var ddLIstEnd =     '</ul></div>';

            RenderBlanks( ddListStart, ddLIstEnd, data.blanks );

            // alert(data.blanks);

        });

        //Если была ошибка
        jqXHR.fail(function(response){

            // console.log(response);

            alert('Сервер занят, попробуйте немного позже');

        });

    }

    function SelectBlankType(){

        var data = {
            action: 'medicalmgetblanktype',
            nonce: medicalM.nonce,
        };

        //Отправляем данные
        var jqXHR = jQuery.post( medicalM.ajaxurl, data, function(response) {
            // console.log(response);
        });

        //Если получили статус 200
        jqXHR.done(function(response){

            data = JSON.parse(response);

            // console.log(data.message);
            // console.log(data.blanks);

            var ddListStart =   '<div class="dd-list-wrapper"><input class="dd-hide-filed" name="blank_type_id" id="blank_type_id" type="text" readonly="readonly"><div class="dd-arrow"></div>' +
                '<div class="dd-list-input">Оберіть...</div><ul class="dd-list type-of-car">';
            var ddLIstEnd =     '</ul></div>';

            RenderBlankType( ddListStart, ddLIstEnd, data.blanks );

        });

        //Если была ошибка
        jqXHR.fail(function(response){

            // console.log(response);

            alert('Сервер занят, попробуйте немного позже');

        });

    }

    function RenderBlanks( ddListStart, ddLIstEnd, data ){

        jQuery('.js-insurance-vait').text('');

        renderBlank = '<label>Оберіть програму</label>' + ddListStart;

        data.forEach(function( element ){
            renderBlank += '<li class="js-blank" data-value="' + element.id + '">' + element.title + '</li>';
        });
        renderBlank += ddLIstEnd;

        jQuery('#medicalForm .js-select-insurance-blank').html(renderBlank);
        jQuery('#medicalForm .js-insurance-list').html('');

    }

    function RenderBlankType( ddListStart, ddLIstEnd, data ){

        jQuery('.js-insurance-vait').text('');

        renderBlank = '<label>Оберіть тип бланку</label>' + ddListStart;

        data.forEach(function( element ){
            renderBlank += '<li class="js-blank" data-value="' + element.id + '">' + element.text + '</li>';
        });
        renderBlank += ddLIstEnd;

        jQuery('#medicalForm .js-select-insurance-blank-type').html(renderBlank);
        jQuery('#medicalForm .js-insurance-list').html('');

    }

    function SelectInsuranceAge( ddListStart, ddLIstEnd ){

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



    function ManagerCoefficient(){

        coefficientPrice = 1;



        coefficient = jQuery('#priceCoefficient').val()*1;
        // coefficient = jQuery('#priceCoefficient').attr('value')*1;
        company_id = jQuery('input[name="company_id"]').val()*1;
        price = jQuery('input[name="rate_price"]').val()*1;

        // console.log('coefficient = ' + coefficient);

        //Для компании "Провідна" ID = 1
        //Изначально надо уменьшить стоимость на 20%
        //Потом увеличиваем на выбраный коеффициент
        /*if( company_id == 1 ){
            if( coefficient != 1 ){
                coefficientPrice = 1 / 1.2;
                coefficientPrice = coefficientPrice * coefficient;

                // console.log('coefficientPrice = ' + coefficientPrice);
            }
            else{
                coefficientPrice = 1;
            }

        }*/

        coefficientPrice = coefficientPrice * coefficient;

        return coefficientPrice;


    }

    function InsuranceList(){

        jQuery('.js-select-insurance-period').on('change', 'input', function(){

            jQuery('.js-insurance-list').html('Завантаження...');
            validity = jQuery(this).val();
            program_id = jQuery('#medical_blank_id').val();
            blank_type_id = jQuery('#blank_type_id').val();

            var data = {
                action: 'getcovidinsurancelist',
                nonce: medicalM.nonce,
                validity: validity,
                program_id: program_id,
                blank_type_id: blank_type_id,

            };

            //Отправляем данные
            var jqXHR = jQuery.post( medicalM.ajaxurl, data, function(response) {
                // console.log(response);

            });

            //Если получили статус 200
            jqXHR.done(function(response){

                data = JSON.parse(response);
                // console.log(data.message);
                // console.log(data.result);
                jQuery('.js-insurance-list').css({'display' : 'block'});
                jQuery('.js-insurance-list').html(data.result);

                jQuery('.js-insurance-form').slideUp();

                //Reset form data
                jQuery('.js-insurance-form input').not('.js-insurance-form input[type=submit], .js-insurance-form [name=blank_title], #medical_blank_series, #blank_type_id').val('');
                jQuery('.js-insurance-form .dd-list-input').text('Оберіть...');

            });

            //Если была ошибка
            jqXHR.fail(function(response){

                console.log(response);

                alert('Сервер занят, попробуйте немного позже');

            });

        });
    }

    function MedicalInsuranceBlankSeries(blank_id, company_id = 1){

        var data = {
            action: 'getinsuranceblankseries',
            nonce: medicalM.nonce,
            blank_id: blank_id,
            company_id: company_id,
        };

        //Отправляем данные
        var jqXHR = jQuery.post( medicalM.ajaxurl, data, function(response) {
            // console.log(response);
        });

        //Если получили статус 200
        jqXHR.done(function(response){

            data = JSON.parse(response);

            blank_series = data.blanks_series;

            if( blank_series.length == 1 ){

                blank_series.forEach(element => {
                    renderInsurancePeriod = '<label for="" class="label-1 label-required">Оберiть серiю бланка</label><input class="inpt-5" name="medical_blank_series" id="medical_blank_series" type="text" readonly="readonly" value="' + element.blank_series + '" required>';

                    jQuery('#medicalForm .js-select-insurance-blank-series').html(renderInsurancePeriod);

                });

            }
            else{

                var ddListStart =   '<div class="dd-list-wrapper"><input class="dd-hide-filed" name="medical_blank_series" id="medical_blank_series" type="text" readonly="readonly"><div class="dd-arrow"></div>' +
                    '<div class="dd-list-input">Оберіть...</div><ul class="dd-list type-of-car">';
                var ddLIstEnd =     '</ul></div>';

                renderInsurancePeriod = '<label class="label-1 label-required">Оберiть серiю бланка</label>' + ddListStart;

                blank_series.forEach(element => {
                    renderInsurancePeriod += '<li data-value="' + element.blank_series + '">' + element.blank_series + '</li>';
                });
                renderInsurancePeriod += ddLIstEnd;

                jQuery('#medicalForm .js-select-insurance-blank-series').html(renderInsurancePeriod);

            }








        });

        //Если была ошибка
        jqXHR.fail(function(response){

            console.log(response);

            alert('Сервер занят, попробуйте немного позже');

        });



    }



    GetMedicalInsurance();

    function GetMedicalInsurance(){
        jQuery('body').on('click', '.js-get-insurance', function(e){

            e.preventDefault();

            base = jQuery(this);

            //Ставим наценку менеджера 1
            jQuery('#priceCoefficient').val(1);

            jQuery('.js-steps-and-list').slideUp(300);

            jQuery('.js-insurance-form').slideDown(300);

            jQuery('html, body').animate({
                scrollTop: jQuery("#medicalForm").offset().top - 200
            }, 1000);

            companyId = base.attr('data-company-id');
            companyFranchise = base.attr('data-franchise-amount');
            companyPeriod = base.attr('data-insurance-period');
            companyTitle = base.attr('data-cmpany-name');
            // insurancePrice = base.attr('data-insurance-price');

            jQuery('#medicalForm').find('input[name=company_id]').val(companyId);
            jQuery('#medicalForm').find('input[name=company_franchise]').val(companyFranchise);
            jQuery('#medicalForm').find('input[name=company_period]').val(companyPeriod);
            jQuery('#medicalForm').find('input[name=company_title]').val(companyTitle);

            //Коеффициент надбавки для компании "Провідна" с ID = 1
            // if( companyId == 1 ){
            //     jQuery('#priceCoefficientBox').css({'display': 'block'});
            // }
            // else{
            //     jQuery('#priceCoefficientBox').css({'display': 'none'});
            // }

            //Rate data

            //Get data
            rate_id = base.attr('data-rate-id');
            rate_franchise = base.attr('data-rate-franchise');
            rate_validity = base.attr('data-rate-validity');
            rate_insured_sum = base.attr('data-rate-insured-sum');
            rate_price = base.attr('data-rate-price');
            rate_locations = base.attr('data-rate-locations');
            program_id = base.attr('data-program-id')*1;
            // medical_blank_id = base.attr('medical_blank_id');

            MedicalInsuranceBlankSeries( program_id, companyId );

            //Set data
            jQuery('#medicalForm').find('input[name=rate_id]').val(rate_id);
            jQuery('#medicalForm').find('input[name=rate_franchise]').val(rate_franchise);
            jQuery('#medicalForm').find('input[name=rate_validity]').val(rate_validity);
            jQuery('#medicalForm').find('input[name=rate_price]').val(rate_price);
            jQuery('#medicalForm').find('input[name=rate_locations]').val(rate_locations);
            jQuery('#medicalForm').find('input[name=rate_insured_sum]').val(rate_insured_sum);

            //Show data for manager
            jQuery('.js-insurance-data-validity span').text( rate_validity );
            jQuery('.js-insurance-data-company-title span').text( companyTitle );
            jQuery('.js-insurance-data-franchise span').text( rate_franchise );
            jQuery('.js-insurance-data-price span').text( rate_price );
            // jQuery('.js-insurance-data-location span').text( rate_locations );

            Сoefficient( rate_price );


            //Если ИД компании равно 3 то снимаем галочку "Додати страхувальника до застрахованих осiб"
            // if( companyId == 3 ){
            //     disableCheckbox();
            // }
            // else{
            //     enableCheckbox();
            // }



            e.preventDefault();
            return false;

        })
    }

    GoBack();

    function GoBack(){

        jQuery('#goInsuranceList').on('click', function(e){

            e.preventDefault();

            // jQuery('.js-steps').slideDown(300);
            jQuery('.js-insurance-form').slideUp(300, function(){
                jQuery('.js-steps-and-list').slideDown(300, function(){
                    jQuery('html, body').animate({
                        scrollTop: jQuery(".js-insurance-list").offset().top -400
                    }, 1000);

                    // jQuery('#priceCoefficientBox').css({'display' : 'none'});
                    jQuery('#priceCoefficient').val(1).parent('.dd-list-wrapper').find('.dd-list-input').text('Оберіть...');



                })
            });

            jQuery('.js-insurance-form-message').html('');
            jQuery('.js-insurer-wrapper').html('');


        });
    }

    ModalClose();

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



    jQuery('body').on('change', 'input[name=medical_date]', function(){

        rate_price = jQuery('input[name=rate_price]').val()*1;

        Сoefficient( rate_price );

    });

    function Сoefficient( price ){

        // base = jQuery('input[name=medical_date]');

        youser_date = jQuery('input[name=medical_date]').val();

        medical_blank_id = jQuery('#medical_blank_id').val()*1;

        coefficient = 1;

        insurer_count = 1;

        priceSumm = 0;

        insurerRowCount = jQuery('.js-insurer-wrapper .insurer-row').size();


        //Проверяем галочку
        if(jQuery('#addInserer').attr("checked") != 'checked') {
            insurerStatus = 0;
        }
        else{
            insurerStatus = 1;
        }

        //Если галочка нажата то просчитываем коеффициент по дате рождения
        if( insurerStatus == 1 ){

            coefficient = CheckUserYears(youser_date);

            newPrice = price*coefficient;
            newPrice = newPrice.toFixed(2);

            priceSumm = newPrice;

            jQuery('.js-btn-get-it').prop("disabled", false).css({'display': 'block'});
            jQuery('.js-insurance-form-message').html('');

        }
        else{
            if( insurerRowCount == 0 ){

                jQuery('.js-btn-get-it').prop("disabled", true).css({'display': 'none'});
                jQuery('.js-insurance-form-message').html('<span style="color: red; font-weight: bold;">Додайте хочаб одну застраховану особу.</span>');

            }
        }

        //Если у нас есть еще пользователи для страхования. Т.е. количество рядов больше 0
        if( insurerRowCount > 0 ){
            i = 1;
            console.log('-----------insurerRowCount > 0 ' + insurerRowCount);

            for( count = 0; count < insurerRowCount;  ) {

                youser_date = jQuery('.insurer-row').eq(count).find('.add-data-picker').val();

                coefficient = CheckUserYears(youser_date);

                newPrice = price*coefficient;
                newPrice = newPrice.toFixed(2);

                priceSumm = (priceSumm * 1) + (newPrice * 1);

                count ++;
            }
        }

        //Итоговая сумма с наценкой менеджера
        managerCoeficient = ManagerCoefficient();
        priceSumm = priceSumm * managerCoeficient;


        console.log('-----------Сoefficient()');
        console.log('-----------managerCoeficient: ' + managerCoeficient);
        console.log('-----------priceSumm: ' + priceSumm );


        //TODO Сoefficient
        jQuery('.js-insurance-data-price span').text( priceSumm );



        jQuery('input[name=rate_coefficient]').val( coefficient );



    }




    //Присваевает страховой коеффициент в зависимости от даты рождения клиента

    function CheckUserYears( youser_date ) {

        coefficient = 1;

        medical_blank_id = jQuery('#medical_blank_id').val() * 1;

        console.log('---------medical_blank_id:' + medical_blank_id);

        //ВІЗА СТАНДАРТНІ БЛАНКИ
        // if( medical_blank_id == 1){

        if (youser_date != '') {

            company_id = jQuery('input[name=company_id]').val() * 1;

            company_title = jQuery('input[name=company_title]').val();


            youser_date = youser_date.split('.');

            youser_date = youser_date[2] + '-' + youser_date[1] + '-' + youser_date[0];


            user_years = age_count(youser_date);

            status = 0;

            //ПрАТ СК Інтер Експрес
            if (company_id == 1) {

                if (user_years <= 3) {
                    coefficient = 2;
                    status = 1;
                } else if (4 <= user_years && user_years <= 8) {
                    coefficient = 1.5;
                    status = 1;
                } else if (9 <= user_years && user_years <= 14) {
                    coefficient = 1.3;
                    status = 1;
                } else if (15 <= user_years && user_years <= 21) {
                    coefficient = 1.2;
                    status = 1;
                } else if (22 <= user_years && user_years <= 65) {
                    coefficient = 1;
                    status = 1;
                } else if (66 <= user_years && user_years <= 75) {
                    coefficient = 2.5;
                    status = 1;
                }

                if (status == 0) {
                    jQuery('.js-btn-get-it').prop("disabled", true).css({'display': 'none'});
                    jQuery('.js-insurance-form-message').html('<span style="color: red; font-weight: bold;">В ' + company_title + ' "Covid-19 Іноземці" по вказанiй вiковiй категорiї договори не приймаються.</span>');
                } else {
                    jQuery('.js-btn-get-it').prop("disabled", false).css({'display': 'block'});
                    jQuery('.js-insurance-form-message').html('');
                }
            //СК Український Страховий Стандарт
            }else if( company_id == 2 ){

                if ( user_years < 1 ) {
                    coefficient = 2.5;
                    status = 1;
                } else if ( 1 <= user_years && user_years <= 17 ) {
                    coefficient = 1.5;
                    status = 1;
                } else if ( 18 <= user_years && user_years <= 59 ) {
                    coefficient = 1;
                    status = 1;
                } else if ( 60 <= user_years && user_years <= 65 ) {
                    coefficient = 2;
                    status = 1;
                } else if ( 66 <= user_years && user_years <= 75 ) {
                    coefficient = 3.5;
                    status = 1;
                }

                if (status == 0) {
                    jQuery('.js-btn-get-it').prop("disabled", true).css({'display': 'none'});
                    jQuery('.js-insurance-form-message').html('<span style="color: red; font-weight: bold;">В ' + company_title + ' "Covid-19 Іноземці" по вказанiй вiковiй категорiї договори не приймаються.</span>');
                } else {
                    jQuery('.js-btn-get-it').prop("disabled", false).css({'display': 'block'});
                    jQuery('.js-insurance-form-message').html('');
                }

            //СК ЕТАЛОН
            }else if( company_id == 3 ){

                if ( 1 <= user_years && user_years <= 60 ) {
                    coefficient = 1;
                    status = 1;
                } else if ( 61 <= user_years && user_years <= 70 ) {
                    coefficient = 1.5;
                    status = 1;
                }

                if (status == 0) {
                    jQuery('.js-btn-get-it').prop("disabled", true).css({'display': 'none'});
                    jQuery('.js-insurance-form-message').html('<span style="color: red; font-weight: bold;">В ' + company_title + ' "Covid-19 Іноземці" по вказанiй вiковiй категорiї договори не приймаються.</span>');
                } else {
                    jQuery('.js-btn-get-it').prop("disabled", false).css({'display': 'block'});
                    jQuery('.js-insurance-form-message').html('');
                }

            }else if(company_id == 4){

            //СК ПРОВІДНА
            }else if( company_id == 5 ){

                if ( 1 <= user_years && user_years <= 60 ) {
                    coefficient = 1;
                    status = 1;
                } else if ( 61 <= user_years && user_years <= 70 ) {
                    coefficient = 1.8;
                    status = 1;
                }

                if (status == 0) {
                    jQuery('.js-btn-get-it').prop("disabled", true).css({'display': 'none'});
                    jQuery('.js-insurance-form-message').html('<span style="color: red; font-weight: bold;">В ' + company_title + ' "Covid-19 Іноземці" по вказанiй вiковiй категорiї договори не приймаються.</span>');
                } else {
                    jQuery('.js-btn-get-it').prop("disabled", false).css({'display': 'block'});
                    jQuery('.js-insurance-form-message').html('');
                }

            }
            // else{
            //     if (status == 0) {
            //         console.log('IF');
            //         jQuery('.js-btn-get-it').prop("disabled", true).css({'display': 'none'});
            //         jQuery('.js-insurance-form-message').html('<span style="color: red; font-weight: bold;">В ' + company_title + ' "По вказанiй вiковiй категорiї договори не приймаються.</span>');
            //     } else {
            //         jQuery('.js-btn-get-it').prop("disabled", false).css({'display': 'block'});
            //         jQuery('.js-insurance-form-message').html('');
            //         console.log('ELSE');
            //     }
            // }



           else {

                jQuery('.js-btn-get-it').prop("disabled", false).css({'display': 'block'});
                jQuery('.js-insurance-form-message').html('');

            }

    }

        return coefficient;


    }


    jQuery( document ).tooltip();


    //Insurer Додати страхувальника до застрахованих осiб

    AddInsurer();

    function AddInsurer(){

        insurerRow = InsurerRow( 1 );

        jQuery('body').on('click', '#addInserers', function(){

            insurerRowCount = jQuery('.js-insurer-wrapper .insurer-row').size();

            if( insurerRowCount < 1 ){



                jQuery('.js-insurer-wrapper').html( insurerRow );

                jQuery('.add-data-picker').attr('id', 'insurerDate1')

                DatapickerInit();

                //TODO Расчет стоимости
                rate_price = jQuery('input[name=rate_price]').val()*1;

                Сoefficient( rate_price );

                insurerRowCount = insurerRowCount + 1;

                jQuery('.js-btn-get-it').prop("disabled", false).css({'display': 'block'});
                jQuery('.js-insurance-form-message').html('');

            }





            // if(jQuery('#addInserer').attr("checked") != 'checked') {
            //     insurerStatus = 0;
            // }
            // else{
            //     insurerStatus = 1;
            // }
            //
            // console.log('---------insurerStatus:' + insurerStatus);
            //
            // if( insurerStatus == 1 ){

            // jQuery('.js-btn-get-it').prop("disabled", false).css({'display': 'block'});
            // jQuery('.js-insurance-form-message').html('');

            // }
            // else{
            //     if( insurerRowCount == 0 ){
            //
            //         jQuery('.js-btn-get-it').prop("disabled", true).css({'display': 'none'});
            //         jQuery('.js-insurance-form-message').html('<span style="color: red; font-weight: bold;">Додайте хочаб одну застраховану особу111111.</span>');
            //
            //     }
            // }



        });

        /*insurerRow = InsurerRow( 1 );
        jQuery('body').on('change', '#addInserer', function(){
            if(jQuery('#addInserer').attr("checked") != 'checked') {
                console.log('NO checked');
                jQuery('.js-insurer-wrapper').html('');
            }
            else{

                jQuery('.js-insurer-wrapper').html( insurerRow );

                jQuery('.add-data-picker').attr('id', 'insurerDate1')

                DatapickerInit();

                console.log('checked');

            }
        });*/

    }

    AddInsuranceRow();

    RemoveInsuranceRow();

    function AddInsuranceRow(){

        jQuery('body').on('click', '.js-add-insurer-row', function(e){

            e.preventDefault();

            console.log('Adding');

            company_id = jQuery('input[name=company_id]').val()*1;

            insurerRowCount = jQuery('.js-insurer-wrapper .insurer-row').size();

            insurerLimit = 3;

            console.log('--ADD insurerRowCount: ' + insurerRowCount);

            id = insurerRowCount + 1;

            insurerRow = InsurerRow( id );

            if( company_id == 1 ){

                if(jQuery('#addInserer').attr("checked") != 'checked') {
                    insurerLimit = 1;
                }
                else{
                    insurerLimit = 0;
                }

            }

            //Providna (Провiдна)
            /*if( company_id == 1 ){

                if(jQuery('#addInserer').attr("checked") != 'checked') {
                    insurerLimit = 3;
                }
                else{
                    insurerLimit = 2;
                }

            }

            //Garfian (Гардиан)
            if( company_id == 2 ){
                if(jQuery('#addInserer').attr("checked") != 'checked') {
                    insurerLimit = 3;
                }
                else{
                    insurerLimit = 2;
                }
            }

            //USI (USI)
            if( company_id == 4 ){
                if(jQuery('#addInserer').attr("checked") != 'checked') {
                    insurerLimit = 3;
                }
                else{
                    insurerLimit = 2;
                }
            }
*/
            id = insurerRowCount + 1;

            insurerRow = InsurerRow( id );

            if( insurerRowCount < insurerLimit ){

                ReinitInsurerRow();



                jQuery('.js-insurer-wrapper .insurer-row:last').after( insurerRow );

                // jQuery('.js-insurer-wrapper .insurer-row:last').find('.add-data-picker').attr('id', id );

                DatapickerInit();

                rate_price = jQuery('input[name=rate_price]').val()*1;

                Сoefficient( rate_price );

                jQuery(".js-insurer-date").mask("99.99.9999", {placeholder: "дд.мм.рррр"});

            }

        });

    }

    function RemoveInsuranceRow(){

        jQuery('body').on('click', '.js-remove-insurer-row', function(e){

            e.preventDefault();

            jQuery(this).parents('.insurer-row').remove();

            insurerRowCount = jQuery('.js-insurer-wrapper .insurer-row').size();

            console.log('--REMOVE insurerRowCount: ' + insurerRowCount);

            // DatapickerInit();

            ReinitInsurerRow();

            rate_price = jQuery('input[name=rate_price]').val()*1;

            Сoefficient( rate_price );


        });

    }

    function InsurerRow( id ){

        // return '<div class="insurer-row"><div class="row"><div class="col-lg-4"><label data-id="insurerLastName" class="label-1" for="insurerLastName">Прiзвище</label><input class="inpt-5" type="text" id="insurerLastName"></div><div class="col-lg-4"><label class="label-1" for="insurerName">Ім\'я</label><input class="inpt-5" type="text" id="insurerName"></div><div class="col-lg-4"><div class="inpt-wrapper"><label class="label-1" for="insurerDate">Дата народження</label><input class="inpt-5 bg-calendar add-data-picker" type="text" id="insurerDate" autocomplete="off" required placeholder="дд.мм.рррр"></div></div></div><div class="row"><div class="col-lg-5"><label class="label-1" for="insurerPassport">Серiя, номер паспорта</label><input class="inpt-5" type="text" id="insurerPassport"></div><div class="col-lg-5"><label class="label-1" for="insurerAddress">Адреса постійного місця проживання</label><input class="inpt-5" type="text" id="insurerAddress"></div><div class="col-lg-2"><button class="btn-1 add-insurer-row js-add-insurer-row">+</button><button class="btn-1 remove-insurer-row js-remove-insurer-row">-</button></div></div></div>';
        return '<div class="insurer-row"><div class="row"><div class="col-lg-4"><div class="inpt-wrapper"><label data-id="insurerLastName" for="insurerLastName'+ id +'" class="label-1">Прiзвище</label><input class="inpt-5 insurer-last-name" id="insurerLastName'+id+'" name="insurerLastName'+id+'" type="text"></div></div><div class="col-lg-4"><div class="inpt-wrapper"><label data-id="insurerName" for="insurerName'+id+'" class="label-1">Ім\'я</label><input class="inpt-5 insurer-name" name="insurerName'+id+'" id="insurerName'+id+'" type="text"></div></div><div class="col-lg-4"><div class="inpt-wrapper"><div class="inpt-wrapper"><label data-id="insurerDate" for="insurerDate'+id+'" class="label-1">Дата народження</label><input class="inpt-5 bg-calendar add-data-picker insurer-date js-insurer-date" data-mask="99.99.9999" name="insurerDate'+id+'" id="insurerDate'+id+'" type="text" autocomplete="off" placeholder="дд.мм.рррр"></div></div></div></div><div class="row"><div class="col-lg-3"><div class="inpt-wrapper"><label data-id="insurercitizenship" for="insurerCitizenship'+id+'" class="label-1">Громадянство</label><input class="inpt-5 insurer-citizenship" id="insurerCitizenship'+id+'" name="insurerCitizenship'+id+'" type="text"></div></div><div class="col-lg-3"><div class="inpt-wrapper"><label data-id="insurerPassport" for="insurerPassport'+id+'" class="label-1">Серiя, номер паспорта</label><input class="inpt-5 insurer-passport" id="insurerPassport'+id+'" name="insurerPassport'+id+'" type="text"></div></div><div class="col-lg-4"><div class="inpt-wrapper"><label data-id="insurerAddress" class="label-1" for="insurerAddress'+id+'">Адреса постійного місця проживання</label><input class="inpt-5 insurer-address" name="insurerAddress'+id+'" id="insurerAddress'+id+'" type="text"></div></div><div class="col-lg-2"><label class="label-1">&nbsp;</label><button class="btn-1 add-insurer-row js-add-insurer-row">+</button><button class="btn-1 remove-insurer-row js-remove-insurer-row">-</button></div></div></div>';
    }


    CheckData();

    //Срабатывает всякий раз как пользователь изменяет дату рождения в "Застрахованих осiб"
    function CheckData() {

        jQuery('body').on('change', '.js-insurer-date', function(){

            rate_price = jQuery('input[name=rate_price]').val()*1;

            Сoefficient( rate_price );

        });
    }

    ChangeInsurerStatus();

    //Срабатывает всякий раз как пользователь изменяет статус "Додати страхувальника до застрахованих осiб"
    //Убарает или ставит "Галочку"
    function ChangeInsurerStatus(){

        jQuery('body').on('change', '#addInserer', function() {

            rate_price = jQuery('input[name=rate_price]').val() * 1;

            Сoefficient(rate_price);

        });

    }

    function DatapickerInit(){

        //Datapicker
        jQuery('.add-data-picker').datepicker({
            beforeShow: function(input, inst) {
                jQuery('#ui-datepicker-div').removeClass(function() {
                    return jQuery('input').get(0).id;
                });
                jQuery('#ui-datepicker-div').addClass(this.id);
            },
            showOn: "button",
            buttonImage: "/wp-content/themes/seofy/img/small-calendar.svg",
            buttonImageOnly: true,
            buttonText: "Оберiть дату",
            maxDate: "-1Y",
            dateFormat: 'dd.mm.yy',
            changeMonth: true,
            changeYear: true,
            yearRange: "1920:" + ((new Date().getFullYear()) - 1),
        });

    }

    function ReinitInsurerRow(){

        count = 0;
        index = 1

        rowCount = jQuery('.insurer-row').length;

        console.log('rowCount___________: ' + rowCount);

        if( rowCount > 0 ){

            for( count = 0; count < rowCount;  ) {

                // jQuery('.insurer-row').each(function(){

                // Row 1 col 1

                insurerLastName = jQuery('.insurer-row').eq(count).find('.row').eq(0).find('.col-lg-4').eq(0).find('.label-1').attr('data-id');
                jQuery('.insurer-row').eq(count).find('.row').eq(0).find('.col-lg-4').eq(0).find('.label-1').attr('for', insurerLastName + index);
                jQuery('.insurer-row').eq(count).find('.row').eq(0).find('.col-lg-4').eq(0).find('.inpt-5').attr('id', insurerLastName + index);
                jQuery('.insurer-row').eq(count).find('.row').eq(0).find('.col-lg-4').eq(0).find('.inpt-5').attr('name', insurerLastName + index);

                // Row 1 col 2

                insurerName = jQuery('.insurer-row').eq(count).find('.row').eq(0).find('.col-lg-4').eq(1).find('.label-1').attr('data-id');
                jQuery('.insurer-row').eq(count).find('.row').eq(0).find('.col-lg-4').eq(1).find('.label-1').attr('for', insurerName + index);
                jQuery('.insurer-row').eq(count).find('.row').eq(0).find('.col-lg-4').eq(1).find('.inpt-5').attr('id', insurerName + index);
                jQuery('.insurer-row').eq(count).find('.row').eq(0).find('.col-lg-4').eq(1).find('.inpt-5').attr('name', insurerName + index);

                // Row 1 col 3
                insurerDate = jQuery('.insurer-row').eq(count).find('.row').eq(0).find('.col-lg-4').eq(2).find('.label-1').attr('data-id');
                jQuery('.insurer-row').eq(count).find('.row').eq(0).find('.col-lg-4').eq(2).find('.label-1').attr('for', insurerDate + index);
                jQuery('.insurer-row').eq(count).find('.row').eq(0).find('.col-lg-4').eq(2).find('.inpt-5').attr('id', insurerDate + index);
                jQuery('.insurer-row').eq(count).find('.row').eq(0).find('.col-lg-4').eq(2).find('.inpt-5').attr('name', insurerDate + index);


                // Row 2 col 1
                insurerPassport = jQuery('.insurer-row').eq(count).find('.row').eq(1).find('.col-lg-5').eq(0).find('.label-1').attr('data-id');
                jQuery('.insurer-row').eq(count).find('.row').eq(1).find('.col-lg-5').eq(0).find('.label-1').attr('for', insurerPassport + index);
                jQuery('.insurer-row').eq(count).find('.row').eq(1).find('.col-lg-5').eq(0).find('.inpt-5').attr('id', insurerPassport + index);
                jQuery('.insurer-row').eq(count).find('.row').eq(1).find('.col-lg-5').eq(0).find('.inpt-5').attr('name', insurerPassport + index);

                console.log('------------insurerPassport: ' + insurerPassport);

                // Row 2 col 2
                insurerAddress = jQuery('.insurer-row').eq(count).find('.row').eq(1).find('.col-lg-5').eq(1).find('.label-1').attr('data-id');
                jQuery('.insurer-row').eq(count).find('.row').eq(1).find('.col-lg-5').eq(1).find('.label-1').attr('for', insurerAddress + index);
                jQuery('.insurer-row').eq(count).find('.row').eq(1).find('.col-lg-5').eq(1).find('.inpt-5').attr('id', insurerAddress + index);
                jQuery('.insurer-row').eq(count).find('.row').eq(1).find('.col-lg-5').eq(1).find('.inpt-5').attr('name', insurerAddress + index);


                count ++;
                index ++;

            }
        }

        // });


    }

    CoefficientPrice();
//TODO Расчет по наценке менеджера
    function CoefficientPrice(){
        jQuery('#priceCoefficientBox').on('change', '#priceCoefficient', function(){

            /*coefficient = jQuery(this).val()*1;
            company_id = jQuery('input[name="company_id"]').val()*1;
            price = jQuery('input[name="rate_price"]').val()*1;

            //Для компании "Провідна" ID = 1
            //Изначально надо уменьшить стоимость на 20%
            //Потом увеличиваем на выбраный коеффициент
            if( company_id == 1 ){
                if( coefficient != 1 ){
                    coefficientPrice = price / 1.2;
                    coefficientPrice = coefficientPrice * coefficient;
                }
                else{
                    coefficientPrice = price;
                }

            }*/

            //coefficientPrice = ManagerCoefficient();

            price = jQuery('input[name="rate_price"]').val()*1;


            Сoefficient( price );

            // jQuery('.js-insurance-data-price').find('span').text( coefficientPrice );
        });
    }


    SetInsurerDateMask();
    function SetInsurerDateMask(){

        jQuery('body').on("focus", ".js-insurer-date", function() {
            jQuery(this).mask("99.99.9999", {placeholder: "дд.мм.рррр"});
            // jQuery(".js-insurer-date").mask("99.99.9999", {placeholder: "дд.мм.рррр"});
        });
    }


    ChangeInsurerSumBox();
    function ChangeInsurerSumBox()
    {
        jQuery('.js-insurance-list').on('click', '.js-change-insurer-sum label', function (){
            base = jQuery(this);

            box_id = base.attr('data-insurer-price-box-id');

            base.parents('.step-3-results-item-top').find('.insurer-price-box').addClass('hide-box');
            base.parents('.step-3-results-item-top').find('.insurer-price-box#'+box_id).removeClass('hide-box');
            base.parents('.step-3-results-item-top').find('.insurer-price-box').find('input').prop("checked", false);
            base.parents('.step-3-results-item-top').find('.insurer-price-box#'+box_id).find('p').eq(0).find('input').prop("checked", true);

            id = base.parents('.step-3-results-item-top').find('.insurer-price-box#'+box_id).find('p').eq(0).find('input').attr('id');

            ChangePrice(id);
        });
    }

    // CheckInsuranceStatus();
    //
    // function CheckInsuranceStatus()
    // {
    //
    //     jQuery('.js-addInserer-label').on('click', function(){
    //
    //         if(jQuery('#addInserer').attr("checked") != 'checked') {
    //             insurer_status = 0;
    //             jQuery('#addInserers').css({'display' : 'none'});
    //             jQuery('.js-insurer-wrapper .insurer-row').remove();
    //         }
    //         else{
    //             insurer_status = 1;
    //             jQuery('#addInserers').css({'display' : 'block'});
    //         }
    //     })
    //
    // }

    function disableCheckbox()
    {
        jQuery('#addInserer').prop('checked', false);
        jQuery('#addInserer').css({'display': 'block'});

    }
    function enableCheckbox()
    {
        jQuery('#addInserer').prop('checked', true);
        jQuery('#addInserer').css({'display': 'block'});

    }

});
