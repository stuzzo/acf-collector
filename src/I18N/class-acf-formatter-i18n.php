<?php

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    ACF_Formatter
 * @subpackage ACF_Formatter/includes
 * @author     Alfredo Aiello <stuzzo@gmail.com>
 */
class ACF_Formatter_i18n
{

    /**
     * Load the plugin text domain for translation.
     *
     * @since    1.0.0
     */
    public function load_plugin_textdomain()
    {
        load_plugin_textdomain(
            'acf-formatter',
            false,
            dirname(dirname(plugin_basename(__FILE__))) . '/languages/'
        );
    }

}