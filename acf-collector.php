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
use ACFCollector\Main\PluginActivator;
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
 * The code that runs during plugin activation and admin init.
 * @since 1.0.0
 */
function activate_acf_formatter()
{
    PluginActivator::activate();
}

register_activation_hook(__FILE__, 'activate_acf_formatter');
add_action('admin_init', 'activate_acf_formatter');

/**
 * The code that runs during plugin deactivation.
 * @since 1.0.0
 */
function deactivate_acf_formatter()
{
    //    PluginDeactivator::deactivate();
}

register_deactivation_hook(__FILE__, 'deactivate_acf_formatter');

if (!function_exists('acf_collector_plugin_action_links')) {
    /**
     * Add action links on plugin page in to Plugin Name block
     *
     * @param $links array() action links
     * @param $file  string  relative path to plugin "acf-collector.php"
     *
     * @return $links array() action links
     */
    function acf_collector_plugin_action_links($links, $file)
    {
        static $this_plugin;
        if (!$this_plugin) {
            $this_plugin = plugin_basename(__FILE__);
        }
        if ($file === $this_plugin) {
            $settings_link = '<a href="options-general.php?page=acf_collector">' . __('Settings', PluginI18N::PLUGIN_TEXT_DOMAIN) . '</a>';
            array_unshift($links, $settings_link);
        }

        return $links;
    }

}
add_filter('plugin_action_links', 'acf_collector_plugin_action_links', 10, 2);

/**
 * Plugin entry point
 * @since 1.0.0
 */
function initPlugin()
{
    $acfCollectorFieldName = get_option('acf_collector_field_name', 'acf_collector_field');
    $pluginI18N = new PluginI18N();
    $pluginLoader = new PluginLoader();
    $restAPIHandler = new RestAPIHandler($pluginLoader, ACFHandler::getInstance(), $acfCollectorFieldName);
    $templateHandler = new TemplateHandler($pluginLoader, ACFHandler::getInstance(), $acfCollectorFieldName);
    $pluginOptions = new PluginOptions();
    new PluginKernel($pluginI18N, $restAPIHandler, $templateHandler, $pluginLoader, $pluginOptions);
}

initPlugin();