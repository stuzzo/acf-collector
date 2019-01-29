<?php

/*
 * This file is part of the ACF Collector plugin.
 *
 * (c) Alfredo Aiello <stuzzo@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://www.google.it
 * @since             1.0.0
 *
 * @wordpress-plugin
 * Plugin Name:       Advanced Custom Fields: API and template fields collector
 * Plugin URI:        https://www.google.it
 * Description:       It appends automatically to the current request all the custom fields used in the current content (e.g. Pages, Posts, etc.)
 * Version:           1.0.0
 * Author:            Alfredo Aiello <stuzzo@gmail.com>
 * Author URI:        https://www.google.it
 * License:           GPLv2 or later
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       acf-collector
 * Domain Path:       /Resources/languages
 */

use ACFCollector\Handler\ACFHandler;
use ACFCollector\Handler\RestAPIHandler;
use ACFCollector\Handler\TemplateHandler;
use ACFCollector\Main\PluginI18N;
use ACFCollector\Main\PluginKernel;
use ACFCollector\Main\PluginLoader;
use ACFCollector\Main\PluginOptions;

// If this file is called directly, abort.
if (!defined('WPINC')) {
    die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 */
define('ACF_COLLECTOR_VERSION', '1.0.0');
define('ACF_COLLECTOR_PATH', plugin_dir_path(__FILE__));

require_once 'autoloader.php';

/**
 * The code that runs during plugin activation.
 *
 * @since 1.0.0
 */
function activate_acf_formatter()
{
//    PluginActivator::activate();
}
register_activation_hook(__FILE__, 'activate_acf_formatter');

/**
 * The code that runs during plugin deactivation.
 *
 * @since 1.0.0
 */
function deactivate_acf_formatter()
{
//    PluginDeactivator::deactivate();
}
register_deactivation_hook(__FILE__, 'deactivate_acf_formatter');

/**
 * Plugin entry point
 *
 * @since 1.0.0
 */
function initPlugin()
{
    $pluginI18N = new PluginI18N();
    $pluginLoader = new PluginLoader();
    $restAPIHandler = new RestAPIHandler($pluginLoader, ACFHandler::getInstance());
    $templateHandler = new TemplateHandler($pluginLoader, ACFHandler::getInstance());
    $pluginOptions = new PluginOptions();
    new PluginKernel($pluginI18N,  $restAPIHandler, $templateHandler, $pluginLoader, $pluginOptions);
}
initPlugin();