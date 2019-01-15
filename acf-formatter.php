<?php

/*
 * This file is part of the ACF Formatter plugin.
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
 * @package           ACF_Formatter
 *
 * @wordpress-plugin
 * Plugin Name:       Advanced Custom Fields Formatter
 * Plugin URI:        https://www.google.it
 * Description:       It appends automatically to the current request all the custom field used in the current content (e.g. Pages, Posts, etc.)
 * Version:           1.0.0
 * Author:            Alfredo Aiello <stuzzo@gmail.com>
 * Author URI:        https://www.google.it
 * License:           MIT
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       acf-formatter
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
use ACFFormatter\Main\PluginKernel;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\PhpFileLoader;

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
register_activation_hook(__FILE__, 'activate_acf_formatter');

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-acf-formatter-deactivator.php
 */
function deactivate_acf_formatter()
{
    require_once plugin_dir_path(__FILE__) . 'includes/class-acf-formatter-deactivator.php';
    ACF_Formatter_Deactivator::deactivate();
}
register_deactivation_hook(__FILE__, 'deactivate_acf_formatter');

require plugin_dir_path(__FILE__) . '/vendor/autoload.php';

// Initialize service container
$container = new ContainerBuilder();

// Load configuration
$phpLoader = new PhpFileLoader($container, new FileLocator(__DIR__.'/config'));
$phpLoader->load('services.php');

$container->compile();

/** @var PluginKernel $pluginKernel */
$pluginKernel = $container->get(PluginKernel::class);
$pluginKernel->init();