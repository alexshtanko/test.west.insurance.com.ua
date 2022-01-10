jQuery(document).ready(function(){
	jQuery(function () {
		jQuery('[data-toggle="tooltip"]').tooltip();
	})

	jQuery('body').tooltip({
		selector: '.noMoney'
	});

	function FormatDate(date)
	{
		var arr = date.split(".");
		date = arr[2] + "-" + arr[1] + "-" + arr[0];
		return date;
	}

	function getPolicy(){

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



		//More

		jQuery('.step-3-results-list .step-3-results-item-more').on('click', function(){

			base = jQuery(this);

			if( !base.parents('.step-3-results-item').hasClass('results-item-open') ){
				jQuery('.step-3-results-item').find('.step-3-results-item-bottom').slideUp(300);
				jQuery('.step-3-results-item').removeClass('results-item-open');

				base.parents('.step-3-results-item').addClass('results-item-open');

				base.parents('.step-3-results-item').find('.step-3-results-item-bottom').slideToggle(300);

			}
			else{
				jQuery('.step-3-results-item').find('.step-3-results-item-bottom').slideUp(300);
				jQuery('.step-3-results-item').removeClass('results-item-open');
			}

		})

		//Manipulate policy items
		function DestroyCarousel(){

			let owl = jQuery('.owl-carousel');

			jQuery('#showList').on('click', function(){
				owl.trigger('destroy.owl.carousel');
				owl.find('.owl-stage-outer').children().unwrap();
				owl.css({'display': 'block'});
				jQuery('#showList').addClass('active');
				jQuery('showTile').removeClass('active');
			})

		}

		function CreateCarousel(){

			let owl = jQuery('.owl-carousel');



			jQuery('#showTile').on('click', function(){

				jQuery('.step-3-results-item').find('.step-3-results-item-bottom').css({'display': 'none'});
				jQuery('.step-3-results-item').removeClass('results-item-open');
				jQuery('#showList').removeClass('active');
				jQuery('showTile').addClass('active');
				owl.owlCarousel({
					loop:false,
					margin:10,
					nav: true,
					dots: false,
					mouseDrag: false,
					navText: ['<i class="fa fa-angle-left" aria-hidden="true"></i>', '<i class="fa fa-angle-right" aria-hidden="true"></i>'],
					responsive:{
						0:{
							items:1
						},
						600:{
							items:2
						},
						1000:{
							items:5
						}
					}
				})
			})

		}

		function ParameterToggleBox(){
			jQuery('#getParameter').on('click', function(){
				jQuery(this).toggleClass('parameter-box-open');
				jQuery(this).parents('.step-4-header').find('.step-4-header-bottom').slideToggle(300);
			})
		}


		function UserList(){
			jQuery('#userCurrentLabel').on('click', function(){

				jQuery('#userLIst').focus();
			})
		}

		function Select(){

			jQuery('.select-wrapper select').on('change', function(){

				let v = jQuery(this).val()*1;

				if( v == 0 ){
					console.log('--select if: ' + v);
					jQuery(this).parents('.select-wrapper').removeClass('.selected');
					jQuery(this).parents('.select-wrapper').find('input:radio').prop('checked', false);
					jQuery(this).parents('.row').find('input.select-radio').prop('checked', true);
				}
				else{
					console.log('--select else: ' + v);
					jQuery(this).parents('.select-wrapper').addClass('.selected');
					jQuery(this).parents('.select-wrapper').find('input:radio').prop('checked', true);
				}
			})

		}


		function GetCalc(){
			jQuery('#getCalc').on('click', function(){
				jQuery('#setNumber').css({'display': 'none'});
				jQuery('#setCalc').css({'display': 'block'});

				carContrAgent = '';
			});

			jQuery('#goToNumber').on('click', function(){
				jQuery('#setNumber').css({'display': 'block'});
				jQuery('#setCalc').css({'display': 'none'});
			});
		}

		GetCalc();

		Select();

		UserList();

		ParameterToggleBox();

		DestroyCarousel();

		CreateCarousel();

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

		// jQuery.datepicker.setDefaults(jQuery.datepicker.regional['ru']);

		/*Изменение даты*/
		ChangeDate();

		function ChangeDate(){

			jQuery('body').on('change', '#termStart', function(){

				changedDateTo = jQuery(this).val();
				changedDateTo = new Date(FormatDate(changedDateTo));
				console.log('changedDateTo:' + changedDateTo);

				if (carRegCat == "PERMANENT_WITHOUT_OTK" || carRegCat == "PERMANENT_WITH_OTK") {
					changedDateTo.setFullYear(changedDateTo.getFullYear() + 1);
					changedDateTo.setDate(changedDateTo.getDate() - 1);
					jQuery("#termEnd").datepicker('setDate', changedDateTo);
				} else {
					if (termValidityPeriod == "d") {
						changedDateTo.setDate(changedDateTo.getDate() + (termValidity - 1));
					}

					if (termValidityPeriod == "m") {
						changedDateTo.setMonth(changedDateTo.getMonth() + termValidity);
						changedDateTo.setDate(changedDateTo.getDate() - 1);
					}

					if (termValidityPeriod == "y") {
						changedDateTo.setFullYear(changedDateTo.getFullYear() + termValidity);
						changedDateTo.setDate(changedDateTo.getDate() - 1);
					}

					jQuery("#termEnd").datepicker('setDate', changedDateTo);
				}
			})

		}

		jQuery('#termStart').datepicker({
			beforeShow: function(input, inst) {
				inst.dpDiv.css({
					// marginTop: -input.offsetHeight + 'px', 
					// marginLeft: input.offsetWidth + 'px'
				});
			},
			showOn: "button",
			buttonImage: "/wp-content/themes/seofy/img/small-calendar.svg",
			buttonImageOnly: true,
			buttonText: "",
			dateFormat: 'dd.mm.yy', minDate: '+1', onSelect: function (dateText) {
				var changedDateTo = new Date(FormatDate(this.value));

				if (carRegCat == "PERMANENT_WITHOUT_OTK" || carRegCat == "PERMANENT_WITH_OTK") {
					changedDateTo.setFullYear(changedDateTo.getFullYear() + 1);
					changedDateTo.setDate(changedDateTo.getDate() - 1);
					jQuery("#termEnd").datepicker('setDate', changedDateTo);
				} else {
					if (termValidityPeriod == "d") {
						changedDateTo.setDate(changedDateTo.getDate() + (termValidity - 1));
					}

					if (termValidityPeriod == "m") {
						changedDateTo.setMonth(changedDateTo.getMonth() + termValidity);
						changedDateTo.setDate(changedDateTo.getDate() - 1);
					}

					if (termValidityPeriod == "y") {
						changedDateTo.setFullYear(changedDateTo.getFullYear() + termValidity);
						changedDateTo.setDate(changedDateTo.getDate() - 1);
					}

					jQuery("#termEnd").datepicker('setDate', changedDateTo);
				}
			}
		});


		jQuery('#termStartSecond').datepicker({ 
			showOn: "button",
			buttonImage: "/wp-content/themes/seofy/img/small-calendar.svg",
			buttonImageOnly: true,
			buttonText: "",
			dateFormat: 'dd.mm.yy', 
			minDate: '+1', 
			onSelect: function(dateText) {
				var changedDateTo = new Date(FormatDate(this.value));
				changedDateTo.setFullYear(changedDateTo.getFullYear() + 1);
				changedDateTo.setDate(changedDateTo.getDate() - 1);
				jQuery("#termEndSecond").datepicker('setDate', changedDateTo);
			} });

		jQuery('#termEnd, #termEndSecond').datepicker({dateFormat: 'dd.mm.yy'});

	}
	getPolicy();


	/////////////////// KUTSENKO
	var AjaxUrl = location.protocol + "//" + window.location.hostname + "/plc/m/index.php";
	var pdfPreviewUrl = "/plc/pdf/osago/";
	var carCat = "";
	var carNumber = "";
	var carVin = "";
	var carModelText = "";
	var carForeign = "";
	var carContrAgent = "";
	var carRegCat = "";
	//var carFranchise = "";
	var taxi = "false";

	var selectedCityId = '';
	var selectedZoneId = '';
	var selectedCityValue = '';

	var carCatText = "";
	var calcAdress = "";

	var carAdress = ""; // доп переменная если автомобиль зарегистрирован за границей
	var carZone = ""; // доп переменная для адреса (зоны)

	var counterOsagos = 0;

	var dateFrom = "";
	var dateTo = "";
	var dateRegEnd = "";

	var noMoney = '<span class="fa-stack noMoney" data-toggle="tooltip" data-placement="top" title="Недостатньо коштів на рахунку"><i class="fa fa-money fa-stack-1x"></i><i class="fa fa-ban fa-stack-2x text-danger"></i></span>';

	var yearNow = new Date().getFullYear();

	// ПЕРВЫЙ ШАГ
	jQuery('#goStepTwo').on('click', function(e) {
		e.preventDefault();
		if(jQuery(".car-number").val().length >= 4){
			var u_carnumber = jQuery(".car-number").val();
			jQuery.ajax(AjaxUrl, {
				type: "POST",
				data: "getcar=true&carnumber=" + u_carnumber,
				timeout: 91000000,
				success: function (data, textStatus, jqXHR) {
					var request = JSON.parse(data);
					if(request.status == "OK"){
						jQuery(".steps .step-4 input[name='car-data']").val(data);

						jQuery(".step-2 .car").html(request.modelText);
						jQuery(".step-2 .car-number").html(request.stateNumber);
						jQuery(".step-2 .vin").html(request.vin);
						jQuery(".step-2 .car-cat").html(request.cat);

						carCatText = request.cat;
						carCat = request.сatCode;

						carNumber = request.stateNumber;
						carVin = request.vin;
						carModelText = request.modelText;

						jQuery(".steps .step-4 input[name='car-brand']").val(request.brand);
						jQuery(".steps .step-4 input[name='car-model']").val(request.modelName);


						jQuery(".steps .step-4 input[name='car-chassis']").val(request.vin);
						jQuery(".steps .step-4 input[name='car-number']").val(request.stateNumber);

						jQuery(".steps .step-4 input[name='car-year']").val(request.year);
						jQuery(".steps .step-4 input[name='car-engine']").val(request.engineVolume);

						jQuery(".steps .step-1").css("display", "none");
						jQuery(".steps .step-2").css("display", "block");

						jQuery('.step-4 .user-document .type-of-documents li').css('display', 'none');
						jQuery('.step-4 .user-document .type-of-documents li[data-for-privileged="false"]').css('display', 'block');
						jQuery('.step-4 .user-document-passport').html('');
						jQuery('.step-4 .dd-list-input-docs').html("");
					}
					else {
						alert("Дані про машину не знайдені");
						jQuery("#getCalc").click();
					}

					//console.log(request);
				},
				error: function (x, t, m) {
					alert("Помилка надсилання запиту, спробуйте пізніше.");
				}
			});
		}
		else {
			alert("Не вірно заповнене поле номера автомобіля");
		}
	});

	jQuery('.step-2 #goBack').on('click', function(e) {
		jQuery(".steps .step-2").css("display", "none");
		jQuery(".steps .step-1").css("display", "block");
	});

	// ВТОРОЙ ШАГ
	jQuery( "#get-cities" ).bind("change paste keyup", function() {
		if(jQuery(this).val() !== selectedCityValue){
			selectedCityId = '';
		}
	});

	jQuery(".cities ").autocomplete({
		source: function( request, response ) {
			jQuery.ajax( {
				url: AjaxUrl,
				type: "POST",
				data: "getcity=true&city=" + request.term,
				dataType: 'json',
				timeout: 91000000,
				success: function( data ) {
					response( data );
				}
			} );
		},
		appendTo: '#cityResultList',
		minLength: 2,
		select: function( event, ui ) {
			selectedCityId = ui.item.id;
			selectedCityValue = ui.item.value;
			selectedZoneId = ui.item.zone;
			jQuery(".steps .step-4 input[name='car-adress']").val(selectedCityValue);
			jQuery(".steps .step-4 input[name='car-zone']").val(selectedZoneId);
		},
	});

	jQuery("#get-cities").autocomplete({
		source: function( request, response ) {
			jQuery.ajax( {
				url: AjaxUrl,
				type: "POST",
				data: "getcity=true&city=" + request.term,
				dataType: 'json',
				timeout: 91000000,
				success: function( data ) {
					response( data );
				}
			} );
		},
		appendTo: '.js-city-result-list',
		minLength: 2,
		select: function( event, ui ) {
			selectedCityId = ui.item.id;
			selectedCityValue = ui.item.value;
			selectedZoneId = ui.item.zone;
			jQuery(".steps .step-4 input[name='car-adress']").val(selectedCityValue);
			jQuery(".steps .step-4 input[name='car-zone']").val(selectedZoneId);
		},
	});

	// ТРЕТИЙ ШАГ
	//////// КАЛЬКУЛЯТОР
	// Введенный адрес
	jQuery( ".step-one-calc .cities" ).bind("change paste keyup", function() {
		calcAdress = jQuery(this).val();
		jQuery(".steps .step-4 input[name='car-adress']").val(calcAdress);
	});

	// Тип транспортного средства
	jQuery('.type-of-car li').on('click', function() {
		carCat = jQuery(this).attr("data-type-car");
		carCatText = jQuery(this).text();
	});


	var inputsUserData = jQuery('.step-4 .user-personal-data .userData').html();
	var inputsCompanyData = jQuery('.step-4 .user-personal-data .companyData').html();
	var inputEngineWeight = jQuery('.step-4 .engineWeight').html();

	jQuery('.step-4 .user-personal-data').html(inputsUserData); // изначально показываем поля обычного пользователя, не компании
	jQuery('#user-date').datepicker({
		beforeShow: function(input, inst) {
			jQuery('#ui-datepicker-div').removeClass(function() {
				return jQuery('input').get(0).id;
			});
			jQuery('#ui-datepicker-div').addClass(this.id);
		},
		maxDate: "-18Y",
		dateFormat: 'dd.mm.yy',
		changeMonth: true,
		changeYear: true,
		yearRange: "1920:" + ((new Date().getFullYear()) - 18),
	});

	var inputsUserDocumentData = jQuery('.step-4 .user-document').html();

	// Тип контрагента
	jQuery('.type-of-cat-contagent li').on('click', function() {
		carContrAgent = jQuery(this).attr("data-type-cat-contragent");

		if(carContrAgent == 'LEGAL'){
			jQuery('.step-4 .user-personal-data').html(inputsCompanyData);
			jQuery('.step-4 .user-document').html('');
		}
		else {
			jQuery('.step-4 .user-personal-data').html(inputsUserData);
			jQuery('.step-4 .user-document').html(inputsUserDocumentData);

			jQuery('#user-date').datepicker({
				beforeShow: function(input, inst) {
					// setTimeout(function () {
					// 	inst.dpDiv.css({
					// 		top: 100,
					// 		left: 200
					// 	});
					// }, 0);
					jQuery('#ui-datepicker-div').removeClass(function() {
						return jQuery('input').get(0).id;
					});
					jQuery('#ui-datepicker-div').addClass(this.id);
				},
				maxDate: "-18Y",
				dateFormat: 'dd.mm.yy',
				changeMonth: true,
				changeYear: true,
				yearRange: "1920:" + ((new Date().getFullYear()) - 18),
			});
		}


		jQuery('.step-4 .user-document .type-of-documents li').css('display', 'none');
		if(carContrAgent == 'PRIVILEGED'){
			jQuery('.step-4 .user-document .type-of-documents li[data-for-privileged="true"]').css('display', 'block');
		}
		else {
			jQuery('.step-4 .user-document .type-of-documents li[data-for-privileged="false"]').css('display', 'block');
		}

		//jQuery("#user-phone").mask("+38 (099) 999-99-99");

		jQuery('.step-4 .user-document-passport').html('');

	});

	// Тип регистрации авто
	jQuery('.type-of-registration li').on('click', function() {
		carRegCat = jQuery(this).attr("data-type-reg");

		jQuery('.step-1 .parameter-six').css('display', 'block');

		//if(carRegCat == "PERMANENT_WITHOUT_OTK" || carRegCat == "PERMANENT_WITH_OTK"){
		if(carRegCat == "PERMANENT_WITHOUT_OTK"){
			jQuery('.step-1 .parameter-seven').css('display', 'none');

			var changedDateTo = new Date(FormatDate(jQuery('#termStart').val()));
			//console.log(changedDateTo);
			changedDateTo.setFullYear(changedDateTo.getFullYear() + 1);
			changedDateTo.setDate(changedDateTo.getDate() - 1);
			jQuery("#termEnd").datepicker('setDate', changedDateTo);
		}
		else {
			changeValidity();
			jQuery('.step-1 .parameter-seven').css('display', 'block');
		}

		if(carRegCat !== "PERMANENT_WITH_OTK" && jQuery('#taxi').is(':checked')){
			jQuery('#taxi').removeAttr("checked");
		}
	});


	//////
	var termValidity = 1;
	var termValidityPeriod = "y";
	jQuery('.validity li').on('click', function() {
		termValidity = parseInt(jQuery(this).attr("data-validity"));
		termValidityPeriod = jQuery(this).attr("data-validity-period");

		changeValidity();
	});


	function changeValidity() {
		var changedDateTo = new Date(FormatDate(jQuery('#termStart').val()));

		if(termValidityPeriod == "d") {
			changedDateTo.setDate(changedDateTo.getDate() + (termValidity - 1));
		}

		if(termValidityPeriod == "m") {
			changedDateTo.setMonth(changedDateTo.getMonth() + termValidity);
			changedDateTo.setDate(changedDateTo.getDate() - 1);
		}

		if(termValidityPeriod == "y") {
			changedDateTo.setFullYear(changedDateTo.getFullYear() + termValidity);
			changedDateTo.setDate(changedDateTo.getDate() - 1);
		}

		jQuery("#termEnd").datepicker('setDate', changedDateTo);
	}




	jQuery('#taxi').change(function() {
		jQuery('.parameter-four .dd-list-input').html("Постійна реєстрація (з ОТК)");
		carRegCat = "PERMANENT_WITH_OTK";

		jQuery('.step-1 .parameter-six').css('display', 'block');
		jQuery('.step-1 .parameter-seven').css('display', 'none');

		// if(jQuery(this).is(':checked')){
		// 	jQuery('.type-of-registration li[data-type-reg="PERMANENT_WITH_OTK"]').click();
		// }
	});

	// Франшиза
	// jQuery('.type-of-franchise li').on('click', function() {
	// 	carFranchise = jQuery(this).attr("data-type-franchise");
	// });

	var simpleFormOrCalc = "";
	var OSAGOS = "";

	var checkSelectDate = false;

	jQuery('#goStepThreeCalc, #goStepThree').on('click', function(e) {
		e.preventDefault();
		simpleFormOrCalc = jQuery(this).attr('id');

		var thisButtonTextDefault = jQuery(this).text();
		//jQuery(this).html('Завантаження...');

		// Если переход через калькулятор
		if(simpleFormOrCalc == "goStepThreeCalc") {
			jQuery(".steps .step-4 input[name='car-brand']").val("");
			jQuery(".steps .step-4 input[name='car-model']").val("");
			jQuery(".steps .step-4 input[name='car-chassis']").val("");
			jQuery(".steps .step-4 input[name='car-number']").val("");

			if (jQuery("#foreign").is(':checked')) {
				carForeign = "true";  // checked
				carAdress = "0";
				carZone = "6";
			} else {
				carForeign = "false";  // unchecked
				carAdress = String(selectedCityId);
				carZone = String(selectedZoneId);
			}
			selectedZoneId = carZone;
			jQuery(".steps .step-4 input[name='car-zone']").val(selectedZoneId);

			if (jQuery("#taxi").is(':checked')) {
				taxi = "true";  // checked
			} else {
				taxi = "false";  // unchecked
			}

			dateFrom = jQuery('#termStart').val();
			dateTo = jQuery('#termEnd').val();
			dateRegEnd = jQuery('#termEnd').val();
		}

		// Если переход через ввод номера авто
		if(simpleFormOrCalc == "goStepThree") {
			carRegCat = "PERMANENT_WITHOUT_OTK";

			if (jQuery("#foreignCar").is(':checked')) {
				carForeign = "true";  // checked
				selectedZoneId = 6;
				jQuery(".steps .step-4 input[name='car-zone']").val(selectedZoneId);
				carAdress = "0";
				carZone = "";
			} else {
				carForeign = "false";  // unchecked
				carAdress = String(selectedCityId);
				carZone = String(selectedZoneId);
			}
			selectedZoneId = carZone;


			//carForeign = "false";
			carContrAgent = "NATURAL";

			// if(selectedCityId !== ''){
			// 	carAdress = String(selectedCityId);
			// }

			dateFrom = jQuery('#termStartSecond').val();
			dateTo = jQuery('#termEndSecond').val();
		}

		//if(carRegCat == "PERMANENT_WITHOUT_OTK" || carRegCat == "PERMANENT_WITH_OTK"){
		if(carRegCat == "PERMANENT_WITHOUT_OTK"){
			if(jQuery('#termStart').val() !== '' && jQuery('#termEnd').val() !== ''){
				checkSelectDate = true;
				dateRegEnd = '';
			}
		}
		else {
			checkSelectDate = true;
			dateTo = dateRegEnd;
		}

		jQuery(".step-3 .termin").html("До " + dateTo);
		jQuery('.step-4 #policyCheckPeriodStart').val( dateFrom );
		jQuery('.step-4 #policyCheckPeriodEnd').val( dateTo );


		jQuery('.step-4 #osago-from').val( dateFrom );
		jQuery('.step-4 #osago-to').val( dateTo );
		jQuery('.step-4 #osago-reg-end').val( dateRegEnd );

		if (carAdress.length > 0 && carCat !== "" && carRegCat !== "" && checkSelectDate && carContrAgent) {
			jQuery(this).html('Завантаження...');

			jQuery(".steps .step-4 input[name='car-cat']").val(carCat);
			jQuery(".steps .step-4 input[name='car-reg-cat']").val(carRegCat);
			jQuery(".steps .step-4 input[name='car-foreign']").val(carForeign);
			jQuery(".steps .step-4 input[name='car-contr-agent']").val(carContrAgent);
			jQuery(".steps .step-4 input[name='car-adress-code']").val(carAdress);
			jQuery(".steps .step-4 input[name='car-taxi']").val(taxi);

			if(carCat == "E" || carCat == "F" || carCat == "B5"){
				jQuery('.step-4 .engineWeight').html("");
			}
			else {
				jQuery('.step-4 .engineWeight').html(inputEngineWeight);
			}

			jQuery.ajax(AjaxUrl, {
				type: "POST",
				data: "osago=true&carCat=" + carCat +
					"&carRegCat=" + carRegCat +
					"&carForeign=" + carForeign +
					"&carContrAgent=" + carContrAgent +
					"&carAdress=" + carAdress +
					"&carZone=" + carZone +
					"&dateFrom=" + dateFrom +
					"&dateTo=" + dateTo +
					"&dateRegEnd=" + dateRegEnd +
					"&taxi=" + taxi,
				timeout: 91000000,
				success: function (data, textStatus, jqXHR) {
					jQuery('#' + simpleFormOrCalc).html(thisButtonTextDefault);

					var request = JSON.parse(data);
					OSAGOS = request;
					if (request.length > 0) {
						jQuery(".step-3-results-list").html("");
						counterOsagos = 0;
						for (var i = 0; i < request.length; i++) {
							if (request[i].id !== null) {
								var selectedPrice;

								var allFranhises = '';
								var allDcvs = '';
								var allPrices = '';
								var allPricesDcv = '';
								var counter = 1;
								var checkedRadio = '';
								var nomoneyDisabled = '';
								var rowOsago = '';
								var firstActiveFranchise = '';
								var addtContractRow = '';
								var allAdditionalContracts = '';
								var hideContractBlock = '';
								var checkedRadioa = '';


								jQuery.each(request[i].franchises, function(key, value) {
									if(counter == 1){
										checkedRadio = "checked";
										selectedPrice = value;
										firstActiveFranchise = key;
									}
									else {
										checkedRadio = '';
									}

									if(userBalance < parseFloat(value) ){
										nomoneyDisabled = "disabled";
									}
									else {
										nomoneyDisabled = "";
									}

									allFranhises += '<p><input type="radio" name="fr' + request[i].code + '" id="fr-' + key + request[i].code + '" data-type-franchise="' + key + '" ' + checkedRadio + ' ' + nomoneyDisabled + '><label for="fr-' + key + request[i].code + '">' + key + ' грн</label>' + (nomoneyDisabled == "disabled" ? noMoney : "") + '</p>\n';
									allPrices += 'data-franchise-' + key + '="' + value + '" ';

									counter++;
								});

								counter = 1;
								jQuery.each(request[i].dcvs, function(key, value) {
									// if(counter == 1){
									// 	checkedRadio = "checked";
									// 	selectedPrice = value;
									// }
									// else {
									// 	checkedRadio = '';
									// }

									if(userBalance < (parseFloat(selectedPrice) + parseFloat(value)) ){
										nomoneyDisabled = "disabled";
									}
									else {
										nomoneyDisabled = "";
									}

									allDcvs += '<p><input type="radio" name="dcv' + request[i].code + '" id="dcv-' + key + request[i].code + '" data-type-dcv="' + key + '" ' + nomoneyDisabled + '><label for="dcv-' + key + request[i].code + '">' + key + ' грн</label>' + (nomoneyDisabled == "disabled" ? noMoney : "") + '</p>\n';
									allPricesDcv += 'data-dcv-' + key + '="' + value + '" ';
									counter++;
								});

								var buttonBuy = "";
								if(request[i].id !== "99999"){
									buttonBuy = '<button data-response-id="' + i + '" data-response-company-id="' + request[i].id + '" data-response-company-code="' + request[i].code + '" class="btn-get-it">Придбати</button>';
								}
								else {
									buttonBuy = '';
								}

								var plusPrice = 0;
								if(firstActiveFranchise != '' && request[i].hasOwnProperty('requiredAddtContract')){
									if(request[i].requiredAddtContract == "true") {
										checkedRadioa = 'disabled="disabled" checked="checked"';
										//checkedRadioa = 'checked="checked"';
										plusPrice = 1;
									}
									else {
										checkedRadioa = '';
									}

									jQuery.each(request[i].AddtContract, function(key, value) {
										if(firstActiveFranchise == key){
											if(userBalance < (parseFloat(selectedPrice) + parseFloat(value)) ){
												hideContractBlock = "style ='display: none;'";
											}
											else {
												hideContractBlock = "style ='display: block;'";
												if(plusPrice == 1)  selectedPrice = parseFloat(selectedPrice) + parseFloat(value);
											}
										}

										allAdditionalContracts += "data-addtContractPrice" + key + "='" + value + "' ";
									});


									addtContractRow = '<span class="addtContract" ' + hideContractBlock + '><input type="checkbox" id="addt' + request[i].companyId + '" ' + checkedRadioa + ' ' + allAdditionalContracts + '><label for="addt' + request[i].companyId + '">Додатковий договір</label></span>';
									//console.log(addtContractRow);
									//console.log(allAdditionalContracts);
								}

								rowOsago += '<div class="row step-3-results-item">\n' +
									'\t\t\t\t\t\t\t\t<div class="vc_col-md-12">\n' +
									'\t\t\t\t\t\t\t\t\t<div class="row step-3-results-item-top">\n' +
									'\t\t\t\t\t\t\t\t\t\t<div class="vc_col-sm-4 vc_col-md-3">\n' +
									'\t\t\t\t\t\t\t\t\t\t\t<div class="company-logo"><img src="' + request[i].image + '" /></div>\n' +
									'\t\t\t\t\t\t\t\t\t\t\t<div class="company-title">' + request[i].namePrint + '</div>\n' +
									'\t\t\t\t\t\t\t\t\t\t</div>\n' +
									'\t\t\t\t\t\t\t\t\t\t<div class="vc_col-sm-4 vc_col-md-2">\n' +
									'\t\t\t\t\t\t\t\t\t\t\t<div class="step-3-franchise">\n' +
									'\t\t\t\t\t\t\t\t\t\t\t\t<div class="step-3-results-item-title">Франшиза</div>\n' + allFranhises +
									'\t\t\t\t\t\t\t\t\t\t\t</div>\n' +
									'\t\t\t\t\t\t\t\t\t\t</div>\n';

								if(allDcvs.length > 0){
									rowOsago += '\t\t\t\t\t\t\t\t\t\t<div class="vc_col-sm-4 vc_col-md-2">\n' +
										'\t\t\t\t\t\t\t\t\t\t\t<div class="step-3-dcv">\n' +
										'\t\t\t\t\t\t\t\t\t\t\t\t<div class="step-3-results-item-title">ДЦВ</div>\n' + allDcvs +
										'\t\t\t\t\t\t\t\t\t\t\t</div>\n' +
										'\t\t\t\t\t\t\t\t\t\t</div>\n';
								}
								else {
									rowOsago += '<div class="vc_col-sm-4 vc_col-md-2"></div>';
								}

								jQuery(".step-3-results-list").append(rowOsago + '<div class="vc_col-sm-4 vc_col-md-3">\n' +
									'\t\t\t\t\t\t\t\t\t\t\t<div class="step-3-price">\n' +
									'\t\t\t\t\t\t\t\t\t\t\t\t<div class="step-3-results-item-title">Ціна</div><span class="price" ' + allPrices + allPricesDcv + '>' + selectedPrice + '</span> <span class="currency">грн</span>' + addtContractRow + '\n' +
									'\t\t\t\t\t\t\t\t\t\t\t</div>\n' +
									'\t\t\t\t\t\t\t\t\t\t</div>\n' +
									'\t\t\t\t\t\t\t\t\t\t<div class="vc_col-md-2">\n' +
									'\t\t\t\t\t\t\t\t\t\t\t' + buttonBuy + '\n' +
									'\t\t\t\t\t\t\t\t\t\t\t<span class="electro-policy">Електронний поліс</span>\n' +
									'\t\t\t\t\t\t\t\t\t\t</div>\n' +
									'\t\t\t\t\t\t\t\t\t</div>\n' +
									'\t\t\t\t\t\t\t\t</div>\n' +
									'\t\t\t\t\t\t</div>');

								counterOsagos = counterOsagos + 1;
							}
						}

						if (counterOsagos > 0) {
							jQuery(".step-3 .step-3-matches span").html(counterOsagos);
							var privileg = "";
							if (carContrAgent == "PRIVILEGED") {
								privileg = "Так";
							} else {
								privileg = "Ні";
							}

							jQuery(".step-3 .car-cat").html(carCatText);

							if(simpleFormOrCalc == "goStepThree") {
								jQuery(".step-3 .adress").html(selectedCityValue);
							}
							else {
								jQuery(".step-3 .adress").html(calcAdress);
							}

							jQuery(".step-3 .contr-agent").html(privileg);


							if(simpleFormOrCalc == "goStepThree") {
								jQuery(".steps .step-2").css("display", "none");
								jQuery(".steps .step-3").css("display", "block");
							}
							else {
								jQuery(".steps .step-1").css("display", "none");
								jQuery(".steps .step-3").css("display", "block");
							}

						} else {
							alert("Відповідних тарифів не знайдено. Спробуйте змінити параметри пошуку.");
						}

					} else {
						alert("Відповідних тарифів не знайдено. Спробуйте ще раз або пізніше.");
					}

					//console.log(request);
				},
				error: function (x, t, m) {
					alert("Помилка надсилання запиту, спробуйте пізніше.");
				}
			});
		} else {
			jQuery('#' + simpleFormOrCalc).html(thisButtonTextDefault);
			alert("Потрібно заповнити всі поля форми!")
		}
	});


	jQuery("#goBackFromOsagos").on('click', function(e) {
		e.preventDefault();
		if(simpleFormOrCalc == "goStepThree") {
			jQuery(".steps .step-3").css("display", "none");
			jQuery(".steps .step-2").css("display", "block");
		}
		else {
			jQuery(".steps .step-3").css("display", "none");
			jQuery(".steps .step-1").css("display", "block");
		}
	});
	// /КАЛЬКУЛЯТОР

	// Выбор ОСАГО
	jQuery(document).on("click", ".step-3 input:radio", function() {
		var tempSelectedFranchise = 0;
		var tempSelectedDcv = 0;
		var tempAddtContract = 0;
		var tempSelectedFranchiseCode = '';

		tempSelectedFranchiseCode = jQuery(this).parents(".step-3-results-item-top").find(".step-3-franchise input[type=radio]:checked").attr("data-type-franchise");
		tempSelectedFranchise = jQuery(this).parents(".step-3-results-item-top").find(".step-3-price span.price").attr("data-franchise-" + tempSelectedFranchiseCode);

		if(jQuery(this).parents(".step-3-results-item-top").find("div").hasClass('step-3-dcv')){
			if(jQuery(this).parents(".step-3-results-item-top").find(".step-3-dcv input:radio").is(":checked")){
				tempSelectedDcv = jQuery(this).parents(".step-3-results-item-top").find(".step-3-dcv input[type=radio]:checked").attr("data-type-dcv");
				tempSelectedDcv = jQuery(this).parents(".step-3-results-item-top").find(".step-3-price span.price").attr("data-dcv-" + tempSelectedDcv);
			}
		}

		if(jQuery(this).parents(".step-3-results-item-top").find("span").hasClass('addtContract')){
			tempAddtContract = jQuery(this).parents(".step-3-results-item-top").find(".addtContract input[type=checkbox]:checked").attr("data-addtcontractprice" + tempSelectedFranchiseCode);

			if(typeof tempAddtContract == "undefined"){
				tempAddtContract = 0;
				jQuery(this).parents(".step-3-results-item-top").find(".addtContract").css("display", "none");
			}
			else {
				jQuery(this).parents(".step-3-results-item-top").find(".addtContract").css("display", "block");
			}

		}

		jQuery(this).parents(".step-3-results-item-top").find(".step-3-price span.price").html(parseFloat(tempSelectedFranchise) + parseFloat(tempSelectedDcv) + parseFloat(tempAddtContract));
	});

	jQuery(document).on("click", ".step-3 .addtContract input:checkbox", function(e) {
		tempSelectedFranchiseCode = jQuery(this).parents(".step-3-results-item-top").find(".step-3-franchise input[type=radio]:checked").attr("data-type-franchise");
		var tempAddtContractPrice = 0;
		tempAddtContractPrice = jQuery(this).attr("data-addtcontractprice" + tempSelectedFranchiseCode);
		var sign = "-";
		if(jQuery(this).is(':checked')){
			console.log("checked");
			sign = "+";
		}
		else {
			console.log("unchecked");
			sign = "-";
		}

		if(typeof tempAddtContractPrice !== "undefined" && tempAddtContractPrice > 0){
			tempPrice = parseFloat(jQuery(this).parents(".step-3-results-item-top").find(".step-3-price span.price").html());
			if(sign == "+"){
				updatedPrice = tempPrice + parseFloat(tempAddtContractPrice);
			}
			else {
				updatedPrice = tempPrice - parseFloat(tempAddtContractPrice);
			}

			jQuery(this).parents(".step-3-results-item-top").find(".step-3-price span.price").html(updatedPrice);
		}
	});

	jQuery("#goBackFromRegOsago").on('click', function(e) {
		e.preventDefault();
		jQuery(".steps .step-4").css("display", "none");
		jQuery(".steps .step-3").css("display", "block");
	});

	var selectedOsago = "";
	var selectedOsagoFranchise = "";
	jQuery(document).on("click", ".step-3 .btn-get-it", function(e) {
		e.preventDefault();
		selectedOsago = jQuery(this).attr('data-response-id');

		//Переключаемся на отправку формы на сайт euroins
		if(jQuery(this).attr('data-response-company-id') == "99999" && jQuery(this).attr('data-response-company-code') == "99999999"){
			jQuery('#checkoutForm').attr('action', '/plc/m/pay_m_euroins.php');
		}
		else {
			jQuery('#checkoutForm').attr('action', '/plc/m/pay_m.php');
		}

		var selectedOsagoRadio = jQuery(this).parents(".step-3-results-item-top").find(".step-3-franchise input[type=radio]:checked");

		var selectedDcvRadio = '';
		if(jQuery(this).parents(".step-3-results-item-top").find("div").hasClass('step-3-dcv')){
			if(jQuery(this).parents(".step-3-results-item-top").find(".step-3-dcv input:radio").is(":checked")){
				selectedDcvRadio = jQuery(this).parents(".step-3-results-item-top").find(".step-3-dcv input[type=radio]:checked");
			}
			// else {
			// 	if(jQuery(selectedOsagoRadio).attr("data-type-franchise") == "0"){
			// 		alert('Для 0 франшизи потрібно обов\'язково обрати ДЦВ!');
			// 		return false;
			// 	}
			// }
		}


		var selectedAddtContractRadio = '';
		if(jQuery(this).parents(".step-3-results-item-top").find("span").hasClass('addtContract')){
			if(jQuery(this).parents(".step-3-results-item-top").find(".addtContract input:checkbox").is(":checked")){
				selectedAddtContractRadio = jQuery(this).parents(".step-3-results-item-top").find(".addtContract input[type=checkbox]:checked");
			}

		}

		// if (jQuery(selectedOsagoRadio).is(':disabled')) {
		// 	alert('У вас недостатньо коштів!');
		// }
		// else {
		//selectedOsagoFranchise = jQuery(this).parents(".step-3-results-item-top").find(".step-3-franchise input[type=radio]:checked").attr("data-type-franchise");
		selectedOsagoFranchise = jQuery(selectedOsagoRadio).attr("data-type-franchise");

		var selectedOsagoDcv;
		if(selectedDcvRadio){
			selectedOsagoDcv = jQuery(selectedDcvRadio).attr("data-type-dcv");
			jQuery(".steps .step-4 input[name='car-selected-dcv']").val(selectedOsagoDcv);
		}
		else {
			selectedOsagoDcv = 0;
			jQuery(".steps .step-4 input[name='car-selected-dcv']").val('');
		}

		jQuery(".steps .step-4 input[name='car-selected-osago']").val(JSON.stringify(OSAGOS[selectedOsago]));
		jQuery(".steps .step-4 input[name='car-selected-franchise']").val(selectedOsagoFranchise);

		//console.log(OSAGOS[selectedOsago]);
		//console.log(selectedOsagoFranchise);

		var addtContractPrice = 0;
		if(selectedAddtContractRadio){
			jQuery(".steps .step-4 input[name='car-selected-addt-contract']").val('true');
			addtContractPrice = OSAGOS[selectedOsago]["AddtContract"][selectedOsagoFranchise];
		}
		else {
			jQuery(".steps .step-4 input[name='car-selected-addt-contract']").val('false');
		}

		var FinalPrice = 0;
		if(selectedOsagoDcv) {
			FinalPrice = OSAGOS[selectedOsago]["dcvs"][selectedOsagoDcv] + OSAGOS[selectedOsago]["franchises"][selectedOsagoFranchise];
		}
		else {
			FinalPrice = OSAGOS[selectedOsago]["franchises"][selectedOsagoFranchise];
		}

		if(typeof addtContractPrice !== "undefined" && addtContractPrice > 0){
			FinalPrice = parseFloat(FinalPrice) + parseFloat(addtContractPrice);
		}
		else {
			jQuery(".steps .step-4 input[name='car-selected-addt-contract']").val('false');
		}

		////////
		// Для ВУСО есть ограничения по 6 зоне по сроку
		//console.log(carForeign);
		//console.log(OSAGOS[selectedOsago]["companyId"]);
		if(carForeign == "true" && OSAGOS[selectedOsago]["companyId"] == 8){

			var daysLag = Math.ceil(Math.abs(new Date(FormatDate(dateTo)).getTime() - new Date(FormatDate(dateFrom)).getTime()) / (1000 * 3600 * 24));
			if(daysLag > 31){
				alert('СК не передбачено укладання договорів для 6 зони більше ніж на 1 місяць!');
				return false;
			}
		}
		///////

		if(userBalance < FinalPrice ){
			alert('У вас недостатньо коштів!');
			return false;
		}

		jQuery(".steps .step-4 .policy-check-price").html(FinalPrice);

		jQuery(".steps .step-3").css("display", "none");
		jQuery("#user-phone").mask("+38 (099) 999-99-99");
		jQuery(".steps .step-4").css("display", "block");

		jQuery("#user-date").mask("99.99.9999", {placeholder: "дд.мм.рррр"});
		//}
	});
	// /Выбор ОСАГО

	// Заполнение пользовательских данных (регистрация ОСАГО)
	var inputsIdPassport = jQuery('.step-4 .user-document-passport .inputsIdPassport').html();
	var inputsOtherDocument = jQuery('.step-4 .user-document-passport .inputsOtherDocument').html();

	jQuery('.step-4 .user-document-passport').html('');


	jQuery(document).on('click', '.type-of-documents li', function() {
		selectDocument(jQuery(this).attr('data-type-doc'));
	});

	jQuery('.step-4 .btn-get-it').on('click', function() {
		jQuery('form#checkoutForm').attr({"action":"/plc/m/pay_m.php", "target":"_self"});
		checkForm();
	});

	//jQuery( ".step-4 input[name='car-number']" ).bind("change paste keyup", function() {
	jQuery( ".step-4 input[name='car-number']" ).on('input', function() {
		if(jQuery(this).val().length >= 6){
			//jQuery(".steps .step-4 input[name='car-brand']").val("").prop("readonly", true);
			//jQuery(".steps .step-4 input[name='car-model']").val("").prop("readonly", true);
			//jQuery(".steps .step-4 input[name='car-chassis']").val("").prop("readonly", true);

			jQuery(this).addClass("ui-autocomplete-loading");

			jQuery.ajax(AjaxUrl, {
				type: "POST",
				data: "getcar=true&carnumber=" + jQuery(this).val(),
				timeout: 91000000,
				success: function (data, textStatus, jqXHR) {
					var request = JSON.parse(data);
					if (request.status == "OK") {
						jQuery(".steps .step-4 input[name='car-data']").val(data);
						jQuery(".steps .step-4 input[name='car-brand']").val(request.brand);
						jQuery(".steps .step-4 input[name='car-model']").val(request.modelName);
						jQuery(".steps .step-4 input[name='car-chassis']").val(request.vin);

						if(request.brand == "") jQuery(".steps .step-4 input[name='car-brand']").val("").prop("readonly", false);
						if(request.modelName == "") jQuery(".steps .step-4 input[name='car-model']").val("").prop("readonly", false);
					}
					else {
						jQuery(".steps .step-4 input[name='car-brand']").val("").prop("readonly", false);
						jQuery(".steps .step-4 input[name='car-model']").val("").prop("readonly", false);
						jQuery(".steps .step-4 input[name='car-chassis']").val("").prop("readonly", false);
					}
					jQuery( ".step-4 input[name='car-number']" ).removeClass("ui-autocomplete-loading");
				}
			});
		}
	});
	// /Заполнение пользовательских данных

	jQuery('[name="car-chassis"]').bind("change keyup input click", function() {
		if (this.value.match(/[^a-zA-Z0-9]/g)) {
			this.value = this.value.replace(/[^a-zA-Z0-9]/g, '');
		}
	});

	jQuery('[name="car-number"]').bind("change keyup input click", function() {
		if (this.value.match(/[^a-zA-Zа-яА-Я0-9]/g)) {
			this.value = this.value.replace(/[^a-zA-Zа-яА-Я0-9]/g, '');
		}
	});

	jQuery('form#checkoutForm').submit(function(e) {
		var form = jQuery(this);
		var url = form.attr('action');

		if(url != pdfPreviewUrl){
			e.preventDefault(); // avoid to execute the actual submit of the form.
			jQuery(this).find("input[type='submit']").prop('disabled',true).val('Завантаження...');

			jQuery.ajax({
				type: "POST",
				url: url,
				data: form.serialize(), // serializes the form's elements.
				success: function (data) {
					var request = JSON.parse(data);
					if (request.status == "OK") {
						if (!alert(request.data)) {
							window.location = '/';
						}
					} else {
						alert(request.data);
					}

					jQuery('form#checkoutForm').find("input[type='submit']").prop('disabled', false).val('Підтвердити укладення');
				}
			});
		}
	});


	jQuery(document).on("click","#pdfPreview", function(){
		jQuery('form#checkoutForm').attr({"action": pdfPreviewUrl, "target":"_blank"});
		checkForm();
	});

	jQuery(document).on("focusout","#company-inn, #user-inn", function(){
		if(jQuery(this).val().length >= 8) {
			getInnData(jQuery(this).val(), carContrAgent);
		}
	});

	function checkForm(){
		if (!jQuery(".step-4 input[name='agree']").is(':checked')) {
			event.preventDefault();
			alert('Для продовження ви повинні прийняти умови договору публічної оферти');
			return false;
		}

		if (jQuery(".step-4 input[name='inn']").val().length != 10) {
			event.preventDefault();
			alert('ІНН має бути 10 символів!');
			return false;
		}

		if (!/\d/.test(jQuery(".step-4 input[name='car-number']").val())) {
			event.preventDefault();
			alert('Державний номер ТЗ містить не корректні символи, або не містить цифр');
			return false;
		}

		if (jQuery(".step-4 input[name='car-chassis']").val().length < 5 || jQuery(".step-4 input[name='car-chassis']").val().length > 17) {
			event.preventDefault();
			alert('Номер кузова повинен бути від 5 до 17 символів і містити тільки латинські букви і принаймні одну арабську цифру');
			return false;
		}

		if(carContrAgent == 'PRIVILEGED') {
			if(carCat !== "E" && carCat !== "F") {
				if (jQuery(".step-4 input[name='car-engine']").val().length > 4 || jQuery(".step-4 input[name='car-engine']").val().length < 3) {
					event.preventDefault();
					alert('Об\'єм двигуна має бути від 3 до 4 символів!');
					return false;
				}
			}
		}

		if(parseInt(jQuery(".step-4 input[name='car-year']").val()) < 1970 || parseInt(jQuery(".step-4 input[name='car-year']").val()) > yearNow){
			event.preventDefault();
			alert('Рік автомобіля має бути не менше 1970 і не більше ' + yearNow + '!');
			return false;
		}

		return true;
	}


	var AjaxUrlInnInfo = location.protocol + "//" + window.location.hostname + "/plc/m/get_inn_info.php";
	function getInnData(inn, carContrAgent) {
		jQuery.ajax(AjaxUrlInnInfo, {
			type: "POST",
			data: "inn=" + inn + "&carContrAgent=" + carContrAgent,
			timeout: 91000000,
			success: function (data, textStatus, jqXHR) {
				var request = JSON.parse(data);
				if (request.status == "OK") {

					var textConfrim = '';
					if(carContrAgent = "LEGAL"){
						textConfrim = 'ЄДРПОУ';
					}
					else {
						textConfrim = 'ІНН';
					}

					var answer = window.confirm("Інформація по введенному " + textConfrim + " знайдена в базі сайту, заповнити поля автоматично?");

					if (answer) {
						var lastDbRecord = request.data;

						if(jQuery(".steps .step-4 input[name='email']").val() == ''){
							jQuery(".steps .step-4 input[name='email']").val(lastDbRecord['email']);
						}

						jQuery(".steps .step-4 input[name='user-phone']").val(lastDbRecord['user-phone']);

						jQuery(".steps .step-4 input[name='user-adress']").val(lastDbRecord['user-adress']);
						jQuery(".steps .step-4 input[name='user-street']").val(lastDbRecord['user-street']);
						jQuery(".steps .step-4 input[name='user-house']").val(lastDbRecord['user-house']);
						jQuery(".steps .step-4 input[name='user-flat']").val(lastDbRecord['user-flat']);

						// jQuery(".steps .step-4 input[name='car-number']").val(lastDbRecord['car-number']);
						// jQuery(".steps .step-4 input[name='car-brand']").val(lastDbRecord['car-brand']);
						// jQuery(".steps .step-4 input[name='car-model']").val(lastDbRecord['car-model']);
						// jQuery(".steps .step-4 input[name='car-chassis']").val(lastDbRecord['car-chassis']);
						// jQuery(".steps .step-4 input[name='car-year']").val(lastDbRecord['car-year']);

						if (typeof lastDbRecord['user-surname'] !== "undefined") {
							selectDocument(lastDbRecord['user-passport']);

							if(jQuery(".steps .step-4 input[name='user-name']").val() == ''){
								jQuery(".steps .step-4 input[name='user-name']").val(lastDbRecord['user-name']);
							}

							if(jQuery(".steps .step-4 input[name='user-surname']").val() == ''){
								jQuery(".steps .step-4 input[name='user-surname']").val(lastDbRecord['user-surname']);
							}


							if(jQuery(".steps .step-4 input[name='user-second-name']").val() == ''){
								jQuery(".steps .step-4 input[name='user-second-name']").val(lastDbRecord['user-second-name']);
							}

							if(jQuery(".steps .step-4 input[name='user-date']").val() == ''){
								jQuery(".steps .step-4 input[name='user-date']").val(lastDbRecord['user-date']);
							}

							// PASSPORT
							jQuery('.dd-list-input-docs').html(jQuery('.type-of-documents li[data-type-doc=' + lastDbRecord["user-passport"] + ']').text());

							if(lastDbRecord['user-passport'] == 'ID_PASSPORT'){
								jQuery(".steps .step-4 input[name='document-record-number']").val(lastDbRecord['document-record-number']);
								jQuery(".steps .step-4 input[name='document-number']").val(lastDbRecord['passport-number']);
								jQuery(".steps .step-4 input[name='document-issued']").val(lastDbRecord['passport-issued']);
								jQuery(".steps .step-4 input[name='document-data']").mask("99.99.9999", {placeholder: "дд.мм.рррр"}).val(lastDbRecord['passport-data']);
								jQuery(".steps .step-4 input[name='document-data-untill']").mask("99.99.9999", {placeholder: "дд.мм.рррр"}).val(lastDbRecord['document-till']);
							}
							else {
								jQuery(".steps .step-4 input[name='passport-series']").val(lastDbRecord['passport-series']);
								jQuery(".steps .step-4 input[name='passport-number']").val(lastDbRecord['passport-number']);
								jQuery(".steps .step-4 input[name='passport-issued']").val(lastDbRecord['passport-issued']);
								jQuery(".steps .step-4 input[name='passport-data']").mask("99.99.9999", {placeholder: "дд.мм.рррр"}).val(lastDbRecord['passport-data']);
							}

						}
						else {

							if(jQuery(".steps .step-4 input[name='company-name']").val() == ''){
								jQuery(".steps .step-4 input[name='company-name']").val(lastDbRecord['company-name']);
							}

						}

					}

				}
			}
		});
	}


	function selectDocument (document_type){
		jQuery('input.selected-document').val(document_type);

		if(document_type == 'ID_PASSPORT'){
			jQuery('.step-4 .user-document-passport').html(inputsIdPassport);
		}
		else {
			jQuery('.step-4 .user-document-passport').html(inputsOtherDocument);
		}

		jQuery('#passport-data, #document-data').mask("99.99.9999", {placeholder: "дд.мм.рррр"}).datepicker({
			beforeShow: function(input, inst) {
				jQuery('#ui-datepicker-div').removeClass(function() {
					return jQuery('input').get(0).id;
				});
				jQuery('#ui-datepicker-div').addClass(this.id);
			},
			showOn: "button",
			buttonImage: "/wp-content/themes/seofy/img/small-calendar.svg",
			buttonImageOnly: true,
			buttonText: "",
			dateFormat: 'dd.mm.yy',
			changeMonth: true,
			changeYear: true,
			yearRange: "1940:" + yearNow,
			maxDate: '-1D',
		});

		if(document_type == 'ID_PASSPORT') {
			jQuery('#document-data-untill').mask("99.99.9999", {placeholder: "дд.мм.рррр"}).datepicker({
				beforeShow: function (input, inst) {
					jQuery('#ui-datepicker-div').removeClass(function () {
						return jQuery('input').get(0).id;
					});
					jQuery('#ui-datepicker-div').addClass(this.id);
				},
				showOn: "button",
				buttonImage: "/wp-content/themes/seofy/img/small-calendar.svg",
				buttonImageOnly: true,
				buttonText: "",
				dateFormat: 'dd.mm.yy',
				changeMonth: true,
				changeYear: true,
				yearRange: yearNow + ":2080",
				minDate: '+1D',
			});
		}
	}

	/////////////////// /KUTSENKO
});

//Hide DD-list
jQuery(document).mouseup(function (e){
	var div = jQuery(".dd-list-wrapper");
	if (!div.is(e.target)
		&& div.has(e.target).length === 0) {
		jQuery('.dd-list-wrapper').find('.dd-list').slideUp(300);
		jQuery('.dd-list-wrapper').removeClass('dd-list-open');
	}
});

function isJson(str) {
	try {
		JSON.parse(str);
	} catch (e) {
		return false;
	}
	return true;
}