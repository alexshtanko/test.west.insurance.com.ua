<?php

/**
 * Fired during plugin activation
 *
 * @link       alexshtanko.com.ua
 * @since      1.0.0
 *
 * @package    Covid
 * @subpackage Covid/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Covid
 * @subpackage Covid/includes
 * @author     Alex <alexshtanko@gmail.com>
 */
class Covid_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {

		$activator = new Covid_Activator();
		
		$activator->createTableProgram();

		$activator->createTableNumberOfBlank();

		$activator->createTableCompany();

		$activator->createTableRate();

		$activator->createTableOrders();

		$activator->createTableCronReports();

		$activator->createUploadFolder();

		$activator->createBlankToManager();



        $activator->createTableInsurer();

        $activator->createTableBlankType();


        $activator->createTableStatuses();

        /*
         * Запустить єти методы один раз для после реализации нового функционала
         * "Електронные бланки"
         *
         * */

//        $activator->updateTableCovidnceRate();
//        $activator->updateTableCovidOrders();




        //Конец "Электронные бланки"


        /*
         * Запустить эти методы один раз для создания отдельной ТАБЛИЧКИ ЭЛЕКТРОННЫХ номеров бланков
         *
         * */
//для поиска по ТАБЛИЧКИ ЭЛЕКТРОННЫХ
        $activator->create_table_covid_e_blank_number_list();
//        $activator->blnak_number_to_covid_e_blank_number_list();
//        $activator->change_staus_e_blank_number_list();


        //Конец ТАБЛИЧКИ ЭЛЕКТРОННЫХ номеров бланков


		//Update Order Table
		//$orders = $activator->get_orders();

		//$activator->set_unicue_number( $orders );

        //После закачки закоментировать
        //Update Order table
        //Установит всем "страхувальникам" статус = 1
        //$activator->set_insurer_status( $orders );


        //После закачки закоментировать
        //Изменить цену в тех договорах где были установлены наценки от менеджеров
        //$bad_orders = $activator->get_false_price();

        //$activator->set_true_price( $bad_orders );


        /*
         * 28.10.2021
         * Добавление видимости всех СК для всех МЕНЕДЖЕРОВ
         * Включать только ОДИН РАЗ!!!
         */

//        $activator->update_user_covid_visible_companies();

	}

	public function createUploadFolder() {

		$uploads_dir = UPLOAD_FOLDER_URL;
		wp_mkdir_p( $uploads_dir );

		

	}

	public function createTableProgram() {

		global $wpdb;

		$table_name = $wpdb->get_blog_prefix() . 'covid_program';

		$charset_collate = "DEFAULT CHARACTER SET {$wpdb->charset} COLLATE {$wpdb->collate}";

		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		$sql = "CREATE TABLE {$table_name} (
			id int(11) unsigned NOT NULL auto_increment,
			title varchar(255) NOT NULL default '',
			comments varchar(255) NOT NULL default '',
			status int(1) unsigned NOT NULL default '0',
			date_added TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
			PRIMARY KEY  (id)
		) {$charset_collate};";

		// Создать таблицу.
		dbDelta( $sql );

	} 

	public function createTableNumberOfBlank() {

		global $wpdb;

		$table_name = $wpdb->get_blog_prefix() . 'covid_number_of_blank';

		$charset_collate = "DEFAULT CHARACTER SET {$wpdb->charset} COLLATE {$wpdb->collate}";

		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		$sql = "CREATE TABLE {$table_name} (
			id int(11) unsigned NOT NULL auto_increment,
			number_start int(8) unsigned NOT NULL,
			number_end int(8) unsigned NOT NULL,
			company_id int(8) unsigned NOT NULL,
			blank_series varchar(10) NOT NULL default '',
			comments varchar(255) NOT NULL default '',
			blank_type_id int(1) unsigned NOT NULL default '1',
			range_used_status tinyint(1) NOT NULL default 0,
			status int(1) unsigned NOT NULL default '0',
			date_added TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
			PRIMARY KEY  (id)
		) {$charset_collate};";

		// Создать таблицу.
		dbDelta( $sql );

	} 

	public function createTableCompany() {

		global $wpdb;

		$table_name = $wpdb->get_blog_prefix() . 'covid_company';

		$charset_collate = "DEFAULT CHARACTER SET {$wpdb->charset} COLLATE {$wpdb->collate}";

		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		$sql = "CREATE TABLE {$table_name} (
			id int(11) unsigned NOT NULL auto_increment,
			title varchar(255) NOT NULL default '',
			logo_url varchar(255) NOT NULL default '',
			logo_id int(12) NOT NULL,
			status int(1) unsigned NOT NULL default '0',
			date_added TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
			PRIMARY KEY  (id)
		) {$charset_collate};";

		// Создать таблицу.
		dbDelta( $sql );

	} 

	public function createTableRate() {

		global $wpdb;

		$table_name = $wpdb->get_blog_prefix() . 'covid_rate';

		$charset_collate = "DEFAULT CHARACTER SET {$wpdb->charset} COLLATE {$wpdb->collate}";

		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		$sql = "CREATE TABLE {$table_name} (
			id int(11) unsigned NOT NULL auto_increment,
			franchise varchar(12) NOT NULL default '',
			validity varchar(12) NULL default '',
			insured_sum varchar(12) NOT NULL default '',
			price decimal(12,2) unsigned NOT NULL default 0,
			company_id int(8) unsigned NOT NULL,
			program_id int(8) unsigned NOT NULL,
			date_added TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
			PRIMARY KEY  (id)
		) {$charset_collate};";

		// Создать таблицу.
		dbDelta( $sql );

	} 

	public function createTableOrders() {

		global $wpdb;

		$table_name = $wpdb->get_blog_prefix() . 'covid_orders';

		$charset_collate = "DEFAULT CHARACTER SET {$wpdb->charset} COLLATE {$wpdb->collate}";

		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		$sql = "CREATE TABLE {$table_name} (
			`id` int(12) unsigned NOT NULL AUTO_INCREMENT,
			`program_id` int(12) NOT NULL,
			`program_title` varchar(255) NOT NULL,
			`number_blank_id` int(4) NOT NULL,
			`number_blank_comment` varchar(255) NOT NULL default '',
			`blank_number` int(12) NOT NULL,
			`blank_series` varchar(10) NOT NULL,
			`company_id` int(12) NOT NULL,
			`company_title` varchar(255) NOT NULL,
			`rate_id` int(12) NOT NULL,
			`rate_franchise` varchar(12) NOT NULL,
			`rate_validity` varchar(12) NOT NULL,
			`rate_insured_sum` varchar(12) NOT NULL,
			`rate_price` decimal(12,2) NOT NULL,
			`rate_coefficient` decimal(5,2) NOT NULL default 1,
			`rate_price_coefficient` decimal(5,2) NOT NULL default 1,
			`name` varchar(25) NOT NULL default '',
			`last_name` varchar(32) NOT NULL default '',
			`passport` varchar(40) NOT NULL default '',
			`citizenship` varchar(255) NOT NULL default '',
			`birthday` varchar(12) NOT NULL default '',
			`address` varchar(255) NOT NULL default '',
			`phone_number` varchar(30) NOT NULL default '',
			`email` varchar(255) NOT NULL default '',
			`date_from` varchar(12) NOT NULL default '',
			`date_to` varchar(12) NOT NULL default '',
			`count_days` int(4) NOT NULL,
			`pdf_url` varchar(255) NOT NULL default '',
			`status` int(1) unsigned NOT NULL default 0,
			`is_manager` int(1) NOT NULL default 0,
			`user_id` int(12) NOT NULL,
			`cashback` decimal(5,2) NOT NULL,
			`unicue_code` varchar(12) NOT NULL default '',
			`insurer_status` tinyint(1) NOT NULL default 0,
			`date_added` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
			PRIMARY KEY  (id)
		) {$charset_collate};";

		// Создать таблицу.
		dbDelta( $sql );

	} 


	public function createTableCronReports() {

		global $wpdb;

		$table_name = $wpdb->get_blog_prefix() . 'covid_cron_reports';

		$charset_collate = "DEFAULT CHARACTER SET {$wpdb->charset} COLLATE {$wpdb->collate}";

		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		$sql = "CREATE TABLE {$table_name} (
			`id` int(12) unsigned NOT NULL AUTO_INCREMENT,
			`script_name` varchar(255) NOT NULL,
			`comment` varchar(255) NOT NULL,
			`date_added` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
			PRIMARY KEY  (id)
		) {$charset_collate};";

		// Создать таблицу.
		dbDelta( $sql );

	} 

	public function createBlankToManager() {

		global $wpdb;

		$table_name = $wpdb->get_blog_prefix() . 'covid_blank_to_manager';

		$charset_collate = "DEFAULT CHARACTER SET {$wpdb->charset} COLLATE {$wpdb->collate}";

		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		$sql = "CREATE TABLE {$table_name} (
			id int(5) unsigned NOT NULL auto_increment,
			number_of_blank_id INT(5) NOT NULL,
			manager_id INT(5) NOT NULL,
			number_start INT(12) NOT NULL,
			number_end INT(12) NOT NULL,
			comment VARCHAR(255) NOT NULL,
			status int(1) unsigned NOT NULL default '0',
			date_added TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
			PRIMARY KEY  (id)			
		) {$charset_collate};";

		// Создать таблицу.
		dbDelta( $sql );

	} 


	public function createTableInsurer() {

        global $wpdb;

        $table_name = $wpdb->get_blog_prefix() . 'covid_insurer';

        $charset_collate = "DEFAULT CHARACTER SET {$wpdb->charset} COLLATE {$wpdb->collate}";

        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
        $sql = "CREATE TABLE {$table_name} (
			`id` int(5) unsigned NOT NULL auto_increment,
			`order_id` INT(5) NOT NULL,
			`name` varchar(25) NOT NULL default '',
			`last_name` varchar(32) NOT NULL default '',
			`passport` varchar(40) NOT NULL default '',
			`birthday` varchar(12) NOT NULL default '',
			`address` varchar(255) NOT NULL default '',
			`citizenship` varchar(255) NOT NULL default '',
			`coefficient` decimal(5,2) NOT NULL default 1,
			`price` decimal(12,2) NOT NULL,
			`date_added` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
			PRIMARY KEY  (id)			
		) {$charset_collate};";

        // Создать таблицу.
        dbDelta( $sql );

    }

	public function get_orders(){

        global $wpdb;

        $table_name_orders = $wpdb->get_blog_prefix() . 'covid_orders';

        $results = $wpdb->get_results( "SELECT * FROM ". $table_name_orders ." " , ARRAY_A);

        return $results;
    }


	public function set_unicue_number( $orders ){

        global $wpdb;

        $table_name_orders = $wpdb->get_blog_prefix() . 'covid_orders';


	    foreach( $orders as $order ){

            $unicue_code = $this->random_string();

            $results = $wpdb->get_results( "UPDATE " . $table_name_orders . " SET `unicue_code`='" . $unicue_code . "'  WHERE id = " . $order['id'] , ARRAY_A);

        }

    }

    public function random_string(){

        $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $strength = 12;

        $input_length = strlen($permitted_chars);
        $random_string = '';
        for($i = 0; $i < $strength; $i++) {
            $random_character = $permitted_chars[mt_rand(0, $input_length - 1)];
            $random_string .= $random_character;
        }

        return $random_string;

    }

	public function set_insurer_status( $orders ){

        global $wpdb;

        $table_name_orders = $wpdb->get_blog_prefix() . 'covid_orders';


        foreach( $orders as $order ){

            $results = $wpdb->get_results( "UPDATE " . $table_name_orders . " SET `insurer_status`=1 WHERE id = " . $order['id'], ARRAY_A);

        }

    }

    public function get_false_price() {

        global $wpdb;

        $table_name_orders = $wpdb->get_blog_prefix() . 'covid_orders';

        $results = $wpdb->get_results( "SELECT * FROM ". $table_name_orders ." WHERE `rate_price_coefficient` > 1" , ARRAY_A);

        return $results;



    }
    public function set_true_price( $orders ){

        global $wpdb;

        $table_name_orders = $wpdb->get_blog_prefix() . 'covid_orders';

        foreach( $orders as $order ){

            $price = $order['rate_price'] / $order['rate_price_coefficient'];
            $price = $price * 1.2;
            $results = $wpdb->get_results( "UPDATE " . $table_name_orders . " SET `rate_price` = " . $price ." WHERE id = " . $order['id'], ARRAY_A);

        }

    }


    /*
     * Таблица типов бланков
     * */
    public function createTableBlankType(){

        global $wpdb;

        $table_name = $wpdb->get_blog_prefix() . 'covid_blank_type';

        $charset_collate = "DEFAULT CHARACTER SET {$wpdb->charset} COLLATE {$wpdb->collate}";

        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
        $sql = "CREATE TABLE {$table_name} (
			`id` int(2) unsigned NOT NULL auto_increment,
			`text` varchar(255) NOT NULL default '',
			`status` int(1) unsigned NOT NULL default 0,
			`date_added` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
			PRIMARY KEY  (id)			
		) {$charset_collate};";

        // Создать таблицу.
        dbDelta( $sql );

    }

    /*
     * Добавить столбец в табилцу "Тарифы" covid_rate
     * */
    public function updateTableCovidRate(){

        global $wpdb;

        $table_name = $wpdb->get_blog_prefix() . 'covid_rate';

        $wpdb->query( 'ALTER TABLE ' . $table_name . ' ADD `blank_type_id` VARCHAR (2) NOT NULL DEFAULT 1 AFTER `program_id`' );

    }

    /*
     * Добавить столбец в табилцу "Тарифы" covid_orders
     * */
    public function updateTableCovidOrders(){

        global $wpdb;

        $table_name = $wpdb->get_blog_prefix() . 'covid_orders';

        $wpdb->query( 'ALTER TABLE ' . $table_name . ' ADD `blank_type_id` VARCHAR (2) NOT NULL DEFAULT 1 AFTER `cashback`' );

    }




    /*
     * Создание таблички нумерации для ЭЛЕКТРОННЫХ бланков
     *
     * */
    public function create_table_covid_e_blank_number_list()
    {

        global $wpdb;

        $table_name = $wpdb->get_blog_prefix() . 'covid_e_blank_number_list';

        $charset_collate = "DEFAULT CHARACTER SET {$wpdb->charset} COLLATE {$wpdb->collate}";

        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
        $sql = "CREATE TABLE {$table_name} (
			`id` int(10) unsigned NOT NULL auto_increment,
			`blank_number` INT(10) NOT NULL,
			`number_of_blank_id` INT(5) NOT NULL,
			`status` int(1) unsigned NOT NULL default '0',
			`date_change` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
			`date_added` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
			PRIMARY KEY  (id)			
		) {$charset_collate};";

        // Создать таблицу.
        dbDelta( $sql );

    }


    public function createTableStatuses() {

        global $wpdb;

        $table_name = $wpdb->get_blog_prefix() . 'covid_statuses';

        $charset_collate = "DEFAULT CHARACTER SET {$wpdb->charset} COLLATE {$wpdb->collate}";

        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
        $sql = "CREATE TABLE {$table_name} (
			id int(3) unsigned NOT NULL auto_increment,
			text  varchar(100) NOT NULL default '',
			comment varchar(255) NOT NULL default '',
			adminReport tinyint(1) NOT NULL default 1,
			managerReport tinyint(1) NOT NULL default 1,
			freeBlank tinyint(1) NOT NULL default 1,
			status tinyint(1) NOT NULL default 1,
			disabled tinyint(1) NOT NULL default 1,
			date_added TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
			PRIMARY KEY  (id)
		) {$charset_collate};";

        // Создать таблицу.
        dbDelta( $sql );

    }


    /*
     * Заполнени таблички нумерации ЭЛЕКТРОННЫХ бланков в зависимоисти от диапазонов ЭЛЕКТРОННЫХ бланков
     *
     * */
    private function blnak_number_to_covid_e_blank_number_list()
    {

        $e_blank_diapason = $this->get_e_blank_diapason();

        foreach ( $e_blank_diapason as $blank_diapason )
        {
            $i = $blank_diapason['number_start'];
            while( $i <= $blank_diapason['number_end'] )
            {
                $this->set_blnak_number_to_covid_e_blank_number_list($i, $blank_diapason['id']);
                $i++;
            }

        }

    }

    /*
     * Получаем диапазоны нумераций ЭЛЕКТРОННЫХ бланков
     *
     * return ARRAY
     * */
    private function get_e_blank_diapason()
    {

        global $wpdb;

        $table_name_number_of_blank = $wpdb->get_blog_prefix() . 'covid_number_of_blank';

        $results = $wpdb->get_results( "SELECT * FROM ". $table_name_number_of_blank ." WHERE `blank_type_id` = 2 AND status = 1" , ARRAY_A);

        return $results;

    }


    /*
     * Вставляем нумерацию ЭЛЕКТРОННЫХ бланков
     * */
    private function set_blnak_number_to_covid_e_blank_number_list($blank_number, $number_of_blank_id)
    {

        global $wpdb;

        $table_name = $wpdb->get_blog_prefix() . 'covid_e_blank_number_list';
        $wpdb->insert( $table_name, 
		[
			'blank_number' => $blank_number,
			'number_of_blank_id' => $number_of_blank_id
		], 
		[
			'%d', 
			'%d'
		] );

    }


    /*
     * Меняем статус у нумерации ЭЛЕКТРОННЫХ бланков
     *
     * */
    private function change_staus_e_blank_number_list()
    {

        global $wpdb;

        $e_blank_numbers = $this->get_all_e_blank_number();

        $table_name = $wpdb->get_blog_prefix() . 'covid_e_blank_number_list';

        foreach ( $e_blank_numbers as $e_blank_number )
        {

            $res = $this->get_order($e_blank_number['number_of_blank_id'], $e_blank_number['blank_number']);


            if( count( $res ) >= 1 )
            {
                $wpdb->update( $table_name,
                    [ 'status' => 1 ],
                    [ 'blank_number' => $e_blank_number['blank_number'], 'number_of_blank_id' => $e_blank_number['number_of_blank_id'] ],
                    [ '%d' ],
                    [ '%d', '%d' ]
                );
            }
        }
    }


    /*
     * Получаем договора в зависимости от типа бланка
     *
     * return ARRAY
     * */
    private function get_order_by_blank_type($blank_type_id = 1)
    {

        global $wpdb;

        $table_name_orders = $wpdb->get_blog_prefix() . 'covid_orders';

        $results = $wpdb->get_results( "SELECT * FROM ". $table_name_orders ." WHERE `blank_type_id` = ".$blank_type_id." ORDER BY `id` ASC" , ARRAY_A);

        return $results;

    }

    /*
     * Получить все нумерации ЭЛЕКТРОННЫХ бланков с таблички covid_e_blank_number_list
     *
     * return ARRAY
     * */
    private function get_all_e_blank_number()
    {
        global $wpdb;

        $table_name = $wpdb->get_blog_prefix() . 'covid_e_blank_number_list';

        $results = $wpdb->get_results( "SELECT * FROM ". $table_name ." " , ARRAY_A);

        return $results;

    }


    /*
     * Получаем договора по критериям
     *
     * return ARRAY
     *
     * */
    private function get_order($number_blank_id, $blank_number)
    {
        global $wpdb;

        $table_name = $wpdb->get_blog_prefix() . 'covid_orders';

        $results = $wpdb->get_results( "SELECT * FROM ". $table_name ." WHERE `status` = 1 AND `number_blank_id` = ".$number_blank_id." AND `blank_number` = ".$blank_number." " , ARRAY_A);

        return $results;
    }



    /*
     * Получаем всех пользователей по РОЛИ и добавляем статус видимости каждой СК = 1
     */
    public  function update_user_covid_visible_companies( $role = 'user_manager' )
    {
        $arg = [
            'role__in' => [$role],
        ];
        $users = get_users( $arg );

        $companies = $this->get_covid_companies( 2 );

        if( $users )
        {
            foreach ( $users as $user ) {
                if ($companies) {
                    foreach ($companies as $company) {
                        update_user_meta( $user->ID, 'user_covid_company_visible_status_' . $company['id'], 1);
                    }
                }
            }
        }
    }

    /*
     * Получаем све СТРАХОВЫЕ КОМПАНИИ
     * 1 - Страхование
     * 2 - Covid2019
     * return ARRAY
     */
    public function get_covid_companies( $table = 2 )
    {
        global $wpdb;

        $table_company = '';

        if( $table == 1){
            $table_company = $wpdb->prefix . "insurance_company";
        }
        elseif( $table == 2 ){
            $table_company = $wpdb->prefix . "covid_company";
        }

        $result = [];

        $result = $wpdb->get_results("SELECT * FROM ".$table_company." WHERE status = 1 ;", ARRAY_A);

        return $result;
    }

}



