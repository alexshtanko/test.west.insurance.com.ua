<?php
/**
 * The template for manager page
 Template Name: Сторінка менеджера
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Seofy
 * @since 1.0
 * @version 1.0
 */

get_header();
the_post();
global $wpdb;

$sb = Seofy_Theme_Helper::render_sidebars();
$row_class = $sb['row_class'];
$column = $sb['column'];
date_default_timezone_set('Europe/Kiev');

//$dateFrom = date('Y-m-d');
$dateFrom = date('d.m.Y', strtotime('+1 day'));
//$dateTo = date('Y-m-d', strtotime('+1 year -1 day'));
$dateTo = date('d.m.Y', strtotime('+1 year'));


//service_stop
$table_ewa_config = $wpdb->prefix . "ewa_config";
$service_stop = $wpdb->get_results("SELECT value FROM ".$table_ewa_config." WHERE `key` = 'service_stop'");
?>
    <div class="wgl-container">
		<?php
		if(count($service_stop) == 1 && $service_stop[0]->value == 1){
			echo "<div class='steps'><h2>Сервіс тимчасово не працює!</h2></div>";
		}
		else {
			$current_user = wp_get_current_user();
			if ( $current_user->ID ) {
				//$user = new WP_User( $current_user->ID );
				//$user_roles = $user->roles;

				$user = wp_get_current_user();
				$allowed_roles = array( 'user_manager', 'administrator' );

				if ( array_intersect( $allowed_roles, $user->roles ) ) {
					//if ( in_array( 'administrator', $user_roles, true ) OR in_array( 'user_manager', $user_roles, true )) {
					?>
                    <div class="steps">

                        <div class="row">
                            <div class="vc_col-lg-12">
                                <div class="step-1">

                                    <div class="step-one-number" id="setNumber">
                                        <h1>(Менеджер)</h1>
                                        <h2>Розрахувати по номеру авто</h2>
                                        <div class="step-one-number-inner">
                                            <div class="title-silver">Для зареєстрованих в Україні</div>

                                            <input type="text" class="inpt-1 car-number" placeholder="AA1234BP"
                                                   oninput="this.value = this.value.toUpperCase()"/>

                                            <div class="step-1-text">
                                                або розрахувати<br>
                                                <span class="get-calc" id="getCalc">на калькуляторі</span>
                                            </div>

                                            <button class="go-step-2" id="goStepTwo">Розрахувати вартість</button>
                                        </div>

                                    </div>

                                    <div class="step-one-calc" id="setCalc">

                                        <h3>Калькулятор</h3>
                                        <label>Тип транспортного засобу</label>

                                        <div class="dd-list-wrapper">
                                            <input class="dd-hide-filed" type="text" readonly="readonly">
                                            <div class="dd-arrow"></div>
                                            <div class="dd-list-input">Оберіть...</div>
                                            <ul class="dd-list type-of-car">
                                                <li data-type-car="A1">Мотоцикл / моторолер - до 300 см3</li>
                                                <li data-type-car="A2">Мотоцикл / моторолер - більше 300 см3</li>
                                                <li data-type-car="B1">Легковий автомобіль - до 1600 см3</li>
                                                <li data-type-car="B2">Легковий автомобіль - 1601 - 2000 см3</li>
                                                <li data-type-car="B3">Легковий автомобіль - 2001 - 3000</li>
                                                <li data-type-car="B4">Легковий автомобіль - більше 3000 см3</li>
                                                <li data-type-car="B5">Легковий електрокар (окрім гібридних)</li>
                                                <li data-type-car="C1">Грузовий автомобіль - до 2т</li>
                                                <li data-type-car="C2">Грузовий автомобіль - більше 2т</li>
                                                <li data-type-car="D1">Автобус - до 20 чоловік</li>
                                                <li data-type-car="D2">Автобус - більше 20 чоловік</li>
                                                <li data-type-car="E">Прицеп до грузового авто</li>
                                                <li data-type-car="F">Прицеп до легкового авто</li>
                                            </ul>
                                        </div><!--dd-list-wrapper end here-->

                                        <div class="parameter-five">
                                            <label>Категорія контрагента</label>
                                            <div class="dd-list-wrapper">
                                                <input class="dd-hide-filed" type="text" readonly="readonly">
                                                <div class="dd-arrow"></div>
                                                <div class="dd-list-input">Оберіть...</div>
                                                <ul class="dd-list type-of-cat-contagent">
                                                    <li data-type-cat-contragent="NATURAL">Фізична особа</li>
                                                    <li data-type-cat-contragent="LEGAL">Юридичина особа</li>
                                                    <li data-type-cat-contragent="PRIVILEGED">Пільговик</li>
                                                </ul>
                                            </div>
                                        </div>

                                        <div class="parameter-three">
                                            <label>Реєстрація власника авто</label>
                                            <span class="privileges-wrapper">
										<input type="checkbox" id="foreign">
										<label for="foreign">Іноземна</label>
								</span>

                                            <input type="text" class="inpt-2 cities js-cities"
                                                   placeholder="Введіть місто реєстрації власника">

                                            <div class="city-result-list" id="cityResultList"></div>
                                        </div>

                                        <!-- // KUTSENKO -->
                                        <div class="parameter-four">
                                            <label>Тип реєстрації авто</label>
                                            <span class="taxi-wrapper">
                                            <input type="checkbox" id="taxi">
                                            <label for="taxi">Таксі&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
                                    </span>

                                            <div class="dd-list-wrapper">
                                                <input class="dd-hide-filed" type="text" readonly="readonly">
                                                <div class="dd-arrow"></div>
                                                <div class="dd-list-input">Оберіть...</div>
                                                <ul class="dd-list type-of-registration">
                                                    <li data-type-reg="PERMANENT_WITHOUT_OTK">Постійна реєстрація (без
                                                        ОТК)
                                                    </li>
                                                    <li data-type-reg="PERMANENT_WITH_OTK">Постійна реєстрація (з ОТК)
                                                    </li>
                                                    <li data-type-reg="TEMPORARY">Тимчасова реєстрація</li>
                                                    <li data-type-reg="TEMPORARY_ENTRANCE">Тимчасовий в'їзд</li>
                                                </ul>
                                            </div>
                                        </div>

                                        <div class="parameter-seven">
                                            <label>Строк дії</label>
                                            <div class="dd-list-wrapper">
                                                <input class="dd-hide-filed" type="text" readonly="readonly">
                                                <div class="dd-arrow"></div>
                                                <div class="dd-list-input">1 рік</div>
                                                <ul class="dd-list validity">
                                                    <li data-validity="15" data-validity-period="d">15 днів</li>
                                                    <li data-validity="1" data-validity-period="m">1 місяць</li>
                                                    <li data-validity="2" data-validity-period="m">2 місяці</li>
                                                    <li data-validity="3" data-validity-period="m">3 місяці</li>
                                                    <li data-validity="4" data-validity-period="m">4 місяці</li>
                                                    <li data-validity="5" data-validity-period="m">5 місяців</li>
                                                    <li data-validity="6" data-validity-period="m">6 місяців</li>
                                                    <li data-validity="7" data-validity-period="m">7 місяців</li>
                                                    <li data-validity="8" data-validity-period="m">8 місяців</li>
                                                    <li data-validity="9" data-validity-period="m">9 місяців</li>
                                                    <li data-validity="10" data-validity-period="m">10 місяців</li>
                                                    <li data-validity="11" data-validity-period="m">11 місяців</li>
                                                    <li data-validity="1" data-validity-period="y">1 рік</li>
                                                </ul>
                                            </div>
                                        </div>

                                        <div class="parameter-six">
                                            <label>Термін дії полісу</label>
                                            <div class="row">
                                                <div class="vc_col-xs-6">
                                                    <div class="inpt-date-wrapepr inpt-date-from">
                                                        <input class="inpt-2 bg-calendar" id="termStart" type="text"
                                                            placeholder="дд.мм.рррр" autocomplete="off" value="<?php echo $dateFrom; ?>">
                                                    </div>
                                                </div>
                                                <div class="vc_col-xs-6">
                                                    <div class="inpt-date-wrapepr inpt-date-to">
                                                        <input class="inpt-2 bg-calendar" id="termEnd" type="text"
                                                               readonly="readonly" value="<?php echo $dateTo; ?>"
                                                               disabled="disabled">
                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                        <button class="btn-1" id="goStepThreeCalc">Порівняти ціни</button>

                                        <span class="go-back" id="goToNumber">Повернутись назад</span>

                                    </div>
                                </div><!--step-1 end here-->


                                <div class="step-2">
                                    <div class="row">
                                        <div class="vc_col-lg-6">
                                            <div class="step-2-title">Автомобіль</div>
                                            <div class="step-2-text car"></div>
                                        </div>
                                        <div class="vc_col-lg-6">
                                            <div class="step-2-title">Номер авто</div>
                                            <div class="step-2-text car-number"></div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="vc_col-lg-6">
                                            <div class="step-2-title">VIN</div>
                                            <div class="step-2-text vin"></div>
                                        </div>
                                        <div class="vc_col-lg-6">
                                            <div class="step-2-title">Категорія</div>
                                            <div class="step-2-text car-cat"></div>
                                        </div>
                                    </div>

                                    <div class="step-2-inner">

                                        <label>Реєстрація авто</label>
                                        <span class="privileges-wrapper">
										<input type="checkbox" id="foreignCar">
										<label for="foreignCar">Іноземна</label>
								</span>
                                        <input class="inpt-2 js-cities js-get-cities" id="get-cities" type="text"
                                               placeholder="Введіть місто реєстрації">
                                        <div class="city-result-list js-city-result-list"></div>

                                        <div class="dateFrom-dateTo">
                                            <label>Термін дії полісу</label>
                                            <div class="row">
                                                <div class="vc_col-xs-6">
                                                    <div class="inpt-date-wrapepr inpt-date-from">
                                                        <input class="inpt-2 bg-calendar" id="termStartSecond"
                                                               type="text" placeholder="дд.мм.рррр" autocomplete="off"
                                                               value="<?php echo $dateFrom; ?>">
                                                    </div>
                                                </div>
                                                <div class="vc_col-xs-6">
                                                    <div class="inpt-date-wrapepr inpt-date-to">
                                                        <input class="inpt-2 bg-calendar" id="termEndSecond" type="text"
                                                               readonly="readonly" value="<?php echo $dateTo; ?>"
                                                               disabled="disabled">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <button class="btn-2" id="goStepThree">Далі</button>

                                        <span class="go-back" id="goBack">Повернутись назад</span>
                                    </div>
                                </div><!--step-2 end here-->


                                <div class="step-3">
                                    <div class="row step-3-header">
                                        <div class="vc_col-lg-4">
                                            <div class="step-3-title">Категорія</div>
                                            <div class="step-3-text car-cat"></div>
                                        </div>
                                        <div class="vc_col-lg-3">
                                            <div class="step-3-title">Реєстрація</div>
                                            <div class="step-3-text adress"></div>
                                        </div>
                                        <div class="vc_col-lg-1">
                                            <div class="step-3-title">Пільги</div>
                                            <div class="step-3-text contr-agent"></div>
                                        </div>
                                        <div class="vc_col-lg-2">
                                            <div class="step-3-title">Термін дії</div>
                                            <div class="step-3-text termin">12 місяців</div>
                                        </div>
                                        <div class="vc_col-lg-2">
                                            <button class="btn-change" id="goBackFromOsagos">Змінити</button>
                                        </div>
                                    </div>

                                    <div class="row step-3-results-header">
                                        <div class="vc_col-lg-12">
                                            <div class="step-3-matches">Знайдено співпадінь - <span></span></div>
                                        </div>
                                    </div>

                                    <div class="step-3-results-list owl-carousel owl-theme">

                                    </div> <!--step-3-results-list end here-->

                                </div><!--step-3 end here-->

                                <div class="step-4">
                                    <div class="step-4-title">
                                        <h3>Оформлення полісу ОСАГО</h3>
                                    </div>

                                    <form action="/plc/m/pay_m.php" method="post" id="checkoutForm">
                                        <div class="step-4-header">
                                            <div class="row flex-box">
                                                <div class="vc_col-lg-10">
                                                    <div>
                                                        <span class="policy-check-title">Вартість:</span>
                                                        <span class="policy-check-price"></span>
                                                        <span class="policy-check-currency">грн</span>
                                                        <span class="policy-check-type"><span class="electro-policy">Електронний поліс</span></span>
                                                    </div>
                                                    <div class="policy-check-period">
                                                        <span class="policy-check-period-title">Період дії: </span>

                                                        <input type="text" class="inpt-4" id="policyCheckPeriodStart"
                                                               value="<?php echo $dateFrom; ?>" readonly="readonly"> -

                                                        <input type="text" class="inpt-4" id="policyCheckPeriodEnd"
                                                               value="<?php echo $dateTo; ?>" readonly="readonly">
                                                    </div>
                                                </div>
                                                <div class="vc_col-lg-2">
                                                    <button class="btn-change" id="goBackFromRegOsago">Назад</button>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="step-4-body-top">

                                            <div class="row">
                                                <div class="vc_col-lg-12">
                                                    <div class="title-1">
                                                        Введіть e-mail
                                                    </div>
                                                    <input name="email" class="inpt-5" type="email" placeholder="E-mail"
                                                           required>

                                                    <div class="bg-yellow email-send-text">На цей e-mail буде
                                                        відправлено електронний поліс
                                                    </div>
                                                </div>
                                            </div>
                                        </div><!--step-4-body-top end here-->


                                        <div class="step-4-body">
                                            <div class="user-personal-data">

                                                <div class="userData">
                                                    <div class="row user-profile-line flex-box">
                                                        <div class="vc_col-xs-12 vc_col-lg-12">
                                                            <div class="title-1"><i class="fa fa-user-o"
                                                                                    aria-hidden="true"></i> Особисті
                                                                дані
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row user-profile-line-1">
                                                        <div class="vc_col-lg-4">
                                                            <label for="user-surname" class="label-1">Прізвище</label>
                                                            <input name="user-surname" type="text" class="inpt-5"
                                                                   id="user-surname" required>
                                                        </div>
                                                        <div class="vc_col-lg-4">
                                                            <label for="user-name" class="label-1">Ім'я</label>
                                                            <input name="user-name" type="text" class="inpt-5"
                                                                   id="user-name" required>
                                                        </div>
                                                        <div class="vc_col-lg-4">
                                                            <label for="user-second-name"
                                                                   class="label-1">По-батькові</label>
                                                            <input name="user-second-name" type="text" class="inpt-5"
                                                                   id="user-second-name" required>
                                                        </div>
                                                    </div>

                                                    <div class="row user-profile-line-1">
                                                        <div class="vc_col-lg-4 position-relative">
                                                            <label for="user-date" class="label-1">Дата народження</label>
                                                            <input name="user-date" type="text" class="inpt-5 bg-calendar" id="user-date" autocomplete="off" required placeholder="дд.мм.рррр">
                                                        </div>
                                                        <div class="vc_col-lg-4">
                                                            <label for="user-inn" class="label-1">ІНН</label>
                                                            <input name="inn" type="number" class="inpt-5" id="user-inn"
                                                                   minlength="10" maxlength="10" required>
                                                        </div>
                                                        <div class="vc_col-lg-4">
                                                            <label for="user-phone" class="label-1">Мобільний</label>
                                                            <input name="user-phone" type="tel" class="inpt-5"
                                                                   id="user-phone" required>
                                                        </div>
                                                    </div>
                                                </div>


                                                <div class="companyData">

                                                    <div class="row user-profile-line flex-box">
                                                        <div class="vc_col-xs-12 vc_col-lg-12">
                                                            <div class="title-1"><i class="fa fa-user-o"
                                                                                    aria-hidden="true"></i> Дані про
                                                                компанію
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row company-profile-line-1">
                                                        <div class="vc_col-lg-4">
                                                            <label for="company-name" class="label-1">Назва</label>
                                                            <input name="company-name" type="text" class="inpt-5"
                                                                   id="company-name" required>
                                                        </div>

                                                        <div class="vc_col-lg-4">
                                                            <label for="company-inn" class="label-1">ЄДРПОУ</label>
                                                            <input name="company-inn" type="number" class="inpt-5"
                                                                   id="company-inn" minlength="8" maxlength="14"
                                                                   required>
                                                        </div>

                                                        <div class="vc_col-lg-4">
                                                            <label for="user-phone" class="label-1">Мобільний</label>
                                                            <input name="user-phone" type="tel" class="inpt-5"
                                                                   id="user-phone" required>
                                                        </div>
                                                    </div>

                                                </div>

                                            </div><!--user-personal-data end here-->

                                            <div class="user-document user-profile-line">
                                                <div class="row flex-box">
                                                    <div class="vc_col-lg-4">
                                                        <div class="title-1">
                                                            <i class="fa fa-file-text-o" aria-hidden="true"></i>
                                                            Документ <span><br>(паспорт, права чи посвідчення)</span>
                                                        </div>
                                                    </div>
                                                    <div class="vc_col-lg-4 radio-btn-wrapper js-document-wrapper">
                                                        <label>Тип документа</label>
                                                        <div class="dd-list-wrapper">
                                                            <input name="document-type"
                                                                   class="dd-hide-filed selected-document" type="text"
                                                                   readonly="readonly">
                                                            <div class="dd-arrow"></div>
                                                            <div class="dd-list-input dd-list-input-docs">Оберіть...
                                                            </div>
                                                            <ul class="dd-list type-of-documents">
                                                                <li data-type-doc="PASSPORT"
                                                                    data-for-privileged="false">Паспорт
                                                                </li>
                                                                <li data-type-doc="ID_PASSPORT"
                                                                    data-for-privileged="false">ID-паспорт
                                                                </li>
                                                                <li data-type-doc="DRIVING_LICENSE"
                                                                    data-for-privileged="false">Посвідчення водія
                                                                </li>
                                                                <li data-type-doc="FOREIGN_PASSPORT"
                                                                    data-for-privileged="false">Паспорт іноземця
                                                                </li>
                                                                <li data-type-doc="RESIDENCE_PERMIT"
                                                                    data-for-privileged="false">Вид на проживання
                                                                </li>
                                                                <li data-type-doc="PENSION_CERTIFICATE"
                                                                    data-for-privileged="true">Пенсійне посвідчення
                                                                </li>
                                                                <li data-type-doc="DISABILITY_CERTIFICATE"
                                                                    data-for-privileged="true">Посвідчення про
                                                                    інвалідність
                                                                </li>
                                                                <li data-type-doc="VETERAN_CERTIFICATE"
                                                                    data-for-privileged="true">Посвідчення учасника
                                                                    війни
                                                                </li>
                                                                <li data-type-doc="CHERNOBYL_CERTIFICATE"
                                                                    data-for-privileged="true">Чорнобильське посвідчення
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <div class="vc_col-lg-4"></div>
                                                </div>

                                                <div class="row user-profile-line-1">

                                                    <div class="user-document-passport" id="userDocumentPassport">

                                                        <div class="inputsIdPassport">
                                                            <div class="vc_col-lg-2">
                                                                <label>Запис №</label>
                                                                <input name="document-record-number" type="text"
                                                                       class="inpt-5" required>
                                                            </div>

                                                            <div class="vc_col-lg-2">
                                                                <label>Документ №</label>
                                                                <input name="document-number" type="number"
                                                                       class="inpt-5" required>
                                                            </div>

                                                            <div class="vc_col-lg-4">
                                                                <label>Орган, що видав</label>
                                                                <input name="document-issued" type="text" class="inpt-5"
                                                                       required>
                                                            </div>

                                                            <div class="vc_col-lg-2">
                                                                <label>Дата видачі</label>
                                                                <input name="document-data" type="text"
                                                                       class="inpt-5 bg-calendar" id="document-data"
                                                                       autocomplete="off" placeholder="дд.мм.рррр" required>
                                                            </div>

                                                            <div class="vc_col-lg-2">
                                                                <label>Дійсний до</label>
                                                                <input name="document-data-untill" type="text"
                                                                       class="inpt-5 bg-calendar"
                                                                       id="document-data-untill" autocomplete="off" placeholder="дд.мм.рррр"
                                                                       required>
                                                            </div>
                                                        </div>

                                                        <div class="inputsOtherDocument">
                                                            <div class="vc_col-lg-2">
                                                                <label>Серія</label>
                                                                <input name="passport-series" type="text" class="inpt-5"
                                                                       maxlength="3" required>
                                                            </div>

                                                            <div class="vc_col-lg-2">
                                                                <label>Номер</label>
                                                                <input name="passport-number" type="number"
                                                                       class="inpt-5" required>
                                                            </div>

                                                            <div class="vc_col-lg-6">
                                                                <label>Ким виданий</label>
                                                                <input name="passport-issued" type="text" class="inpt-5"
                                                                       required>
                                                            </div>

                                                            <div class="vc_col-lg-2">
                                                                <label>Коли виданий</label>
                                                                <input name="passport-data" type="text"
                                                                       class="inpt-5 bg-calendar" id="passport-data"
                                                                       autocomplete="off" placeholder="дд.мм.рррр" required>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div><!--user-document end here-->

                                            <div class="user-location user-profile-line">
                                                <div class="row">
                                                    <div class="vc_col-lg-12">
                                                        <div class="title-1">
                                                            <i class="fa fa-map-marker" aria-hidden="true"></i> Адреса
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="vc_col-lg-4">
                                                        <label class="label-1">Назва населеного пункту</label>
                                                        <input name="user-adress" type="text" class="inpt-5"
                                                               placeholder="" required>
                                                    </div>
                                                    <div class="vc_col-lg-4">
                                                        <label class="label-1">Назва вулиці</label>
                                                        <input name="user-street" type="text" class="inpt-5"
                                                               placeholder="" required>
                                                    </div>
                                                    <div class="vc_col-lg-2">
                                                        <label class="label-1">№ Будинку</label>
                                                        <input name="user-house" type="text" class="inpt-5" required>
                                                    </div>
                                                    <div class="vc_col-lg-2">
                                                        <label class="label-1">№ Квартири</label>
                                                        <input name="user-flat" type="text" class="inpt-5">
                                                    </div>
                                                </div>
                                            </div><!--user-location end here-->

                                            <div class="user-transport user-profile-line">
                                                <div class="row flex-box">
                                                    <div class="vc_col-sm-12 vc_col-lg-12">
                                                        <div class="title-1">
                                                            <i class="fa fa-car" aria-hidden="true"></i> Транспортний
                                                            засіб
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="vc_col-lg-4">
                                                        <label class="label-1">Держ. номер </label>
                                                        <input name="car-number" type="text" class="inpt-5"
                                                               placeholder=""
                                                               oninput="this.value = this.value.toUpperCase()" required>
                                                    </div>
                                                    <div class="vc_col-lg-4">
                                                        <label class="label-1">Марка </label>
                                                        <input name="car-brand" type="text" class="inpt-5"
                                                               placeholder="" required>
                                                    </div>
                                                    <div class="vc_col-lg-4">
                                                        <label class="label-1">Модель </label>
                                                        <input name="car-model" type="text" class="inpt-5"
                                                               placeholder="" required>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="vc_col-lg-4">
                                                        <label class="label-1">№ шасі </label>
                                                        <input name="car-chassis" type="text" class="inpt-5"
                                                               placeholder=""
                                                               oninput="this.value = this.value.toUpperCase()"
                                                               minlength="5" maxlength="17" required>
                                                    </div>
                                                    <div class="vc_col-lg-4">
                                                        <label class="label-1">Рік випуску </label>
                                                        <input name="car-year" type="number" class="inpt-5"
                                                               placeholder="" maxlength="4" required>
                                                    </div>
                                                    <div class="engineWeight">
                                                        <div class="vc_col-lg-4">
                                                            <label class="label-1">Об'єм двигуна </label>
                                                            <input name="car-engine" type="number" class="inpt-5"
                                                                   placeholder="" minlength="3" maxlength="4" required>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div><!--user-transport end here-->

                                            <!-- HIDDEN INPUTS -->
                                            <input name="car-data" id="car-data" type="hidden" class="inpt-5">

                                            <input name="car-cat" id="car-cat" type="hidden" class="inpt-5">
                                            <input name="car-reg-cat" id="car-reg-cat" type="hidden" class="inpt-5">
                                            <input name="car-foreign" id="car-foreign" type="hidden" class="inpt-5">
                                            <input name="car-contr-agent" id="car-contr-agent" type="hidden"
                                                   class="inpt-5">
                                            <input name="car-adress" id="car-adress" type="hidden" class="inpt-5">
                                            <input name="car-zone" id="car-zone" type="hidden" class="inpt-5">
                                            <input name="car-adress-code" id="car-adress-code" type="hidden"
                                                   class="inpt-5">

                                            <input name="car-taxi" id="car-taxi" type="hidden" class="inpt-5">

                                            <input name="car-selected-osago" id="car-selected-osago" type="hidden"
                                                   class="inpt-5">
                                            <input name="car-selected-franchise" id="car-selected-franchise"
                                                   type="hidden" class="inpt-5">
                                            <input name="car-selected-dcv" id="car-selected-dcv" type="hidden"
                                                   class="inpt-5">
                                            <input name="car-selected-addt-contract" id="car-selected-addt-contract"
                                                   type="hidden" class="inpt-5">

                                            <input name="osago-from" id="osago-from" type="hidden" class="inpt-5">
                                            <input name="osago-to" id="osago-to" type="hidden" class="inpt-5">
                                            <input name="osago-reg-end" id="osago-reg-end" type="hidden" class="inpt-5">
                                            <!-- HIDDEN INPUTS -->

                                        </div><!--step-4-body end here-->

                                        <div class="step-4-footer user-profile-line">
                                            <div class="step-4-footer-top">
                                                <div class="row">
                                                    <div class="vc_col-lg-12">
                                                        <input type="checkbox" id="agree" name="agree"><label
                                                                for="agree">Я приймаю умови <a href="/public-offer/"
                                                                                               target="_blank">договору
                                                                публічної оферти</a>, підтверджую достовірність всіх
                                                            введених даних.</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="step-4-footer-bottom">
                                                <div class="row">
                                                    <div class="vc_col-lg-8">
                                                        <input type="submit" name="submit" class="btn-get-it"
                                                               value="Підтвердити укладення">
                                                    </div>
                                                    <div class="vc_col-lg-4">
                                                        <button type="submit" name="getPdf"id="pdfPreview"><i class="fa fa-file-pdf-o" aria-hidden="true"></i> Попередній перегляд</button>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="step-4-footer-bottom">
                                                <div class="row">
                                                    <div class="vc_col-lg-12">
                                                        <div class="credit-cart">
                                                            <img class="cart-visa"
                                                                 src="<?php echo bloginfo( 'template_url' ); ?>/img/visa.svg"
                                                                 alt="">
                                                            <img src="<?php echo bloginfo( 'template_url' ); ?>/img/master-cart.svg"
                                                                 alt="">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div><!--step-4-footer end here-->

                                        <!-- </div> -->
                                    </form>
                                </div><!--step-4 end here-->

                            </div>
                        </div>

                    </div><!--steps end here-->

				<?php
				$user_id = get_current_user_id(); //Получаем текущий id пользователя
				$balance = rcl_get_user_balance( $user_id );

				?>
                    <script>
                        var userBalance = <?php echo $balance ? $balance : 0; ?>;
                    </script>

					<?php
				}
			} else {
				echo "<div>Доступ до сторінки заборонено!</div>";
			}
		}
		?>

        <div class="row <?php echo apply_filters('seofy_row_class', $row_class); ?>">
            <div id='main-content' class="wgl_col-<?php echo apply_filters('seofy_column_class', $column); ?>">
				<?php
				the_content(esc_html__('Read more!', 'seofy'));
				wp_link_pages(array('before' => '<div class="page-link">' . esc_html__('Pages', 'seofy') . ': ', 'after' => '</div>'));
				if ( comments_open() || get_comments_number() ) :
					comments_template();
				endif; ?>
            </div>
			<?php
			echo (isset($sb['content']) && !empty($sb['content']) ) ? $sb['content'] : '';
			?>
        </div>
    </div>

<?php
if($current_user->ID == 16 OR $current_user->ID == 39){
	?>
    <script>
        //console.log('true-test...');
        jQuery('form#checkoutForm').find("input[type='submit']").prop('disabled',true);
    </script>
	<?php
}

get_footer();

?>