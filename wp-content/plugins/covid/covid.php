<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              alexshtanko.com.ua
 * @since             1.1.0
 * @package           Covid
 *
 * @wordpress-plugin
 * Plugin Name:       Covid
 * Plugin URI:        alexshtanko.com.ua
 * Description:       Страхование.
 * Version:           1.1.0
 * Author:            Alex Shtanko
 * Author URI:        alexshtanko.com.ua
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       covid
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if (!defined('ABSPATH')) {
    die;
}

// if ( ! defined( 'WPINC' ) ) {
// 	die;
// }

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define('COVID_VERSION', '1.0.1');

define('PLUGIN_URL', plugin_dir_url(__FILE__));

define('UPLOAD_FOLDER_URL', trailingslashit(wp_upload_dir()['basedir']) . 'files/xls');

// require ABSPATH . '/vendor/autoload.php';

// use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
// use PhpOffice\PhpSpreadsheet\IOFactory;


/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-covid-activator.php
 */
function activate_covid()
{
    require_once plugin_dir_path(__FILE__) . 'includes/class-covid-activator.php';
    Covid_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-covid-deactivator.php
 */
function deactivate_covid()
{
    require_once plugin_dir_path(__FILE__) . 'includes/class-covid-deactivator.php';
    Covid_Deactivator::deactivate();
}

register_activation_hook(__FILE__, 'activate_covid');
register_deactivation_hook(__FILE__, 'deactivate_covid');

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path(__FILE__) . 'includes/class-covid.php';


//Программы
require plugin_dir_path(__FILE__) . '/admin/include/class-covid-admin-program.php';

//Нумерация Бланков ОТ и ДО 
require plugin_dir_path(__FILE__) . '/admin/include/class-covid-admin-number-of-blanks.php';

//Компании
require plugin_dir_path(__FILE__) . '/admin/include/class-covid-admin-company.php';

//Тарифы
require plugin_dir_path(__FILE__) . '/admin/include/class-covid-admin-rate.php';

//Заказы
require plugin_dir_path(__FILE__) . '/admin/include/class-covid-admin-orders.php';

//Закрепление нумерации бланков за определенным менеджером
require plugin_dir_path(__FILE__) . '/admin/include/class-covid-admin-blank-to-manager.php';

//Статусы заказов
require plugin_dir_path(__FILE__) . '/admin/include/class-covid-statuses.php';

//Типы бланков
require plugin_dir_path(__FILE__) . '/admin/include/class-covid-admin-blank-type.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_covid()
{

    $plugin = new Covid();

    $plugin->run();

}

run_covid();
