<?php

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
 * @package           ACF_Formatter
 *
 * @wordpress-plugin
 * Plugin Name:       Advanced Custom Fields Formatter
 * Plugin URI:        https://www.google.it
 * Description:       It appends to the current requests all the custom fields used.
 * Version:           1.0.0
 * Author:            Alfredo Aiello
 * Author URI:        https://www.google.it
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       acf-formatter
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
use ACFFormatter\Main\PluginKernel;

if (!defined('WPINC')) {
    die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define('PLUGIN_NAME_VERSION', '1.0.0');

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-acf-formatter-activator.php
 */
function activate_acf_formatter()
{
    require_once plugin_dir_path(__FILE__) . 'includes/class-acf-formatter-activator.php';
    ACF_Formatter_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-acf-formatter-deactivator.php
 */
function deactivate_acf_formatter()
{
    require_once plugin_dir_path(__FILE__) . 'includes/class-acf-formatter-deactivator.php';
    ACF_Formatter_Deactivator::deactivate();
}

//register_activation_hook(__FILE__, 'activate_acf_formatter');
//register_deactivation_hook(__FILE__, 'deactivate_acf_formatter');

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
//require plugin_dir_path(__FILE__) . 'includes/class-acf-formatter.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_acf_formatter()
{
    require plugin_dir_path(__FILE__) . '/vendor/autoload.php';

    new PluginKernel();
}
run_acf_formatter();