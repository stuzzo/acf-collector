<?php

/*
 * This file is part of the ACF Formatter plugin.
 *
 * (c) Alfredo Aiello <stuzzo@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ACFFormatter\Main;

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 */
class PluginI18N
{

    /**
     * Load the plugin text domain for translation.
     *
     * @since    1.0.0
     */
    public function load_plugin_textdomain(): void
    {
        load_plugin_textdomain(
            'acf-formatter',
            false,
            dirname(__DIR__) . '/languages/'
        );
    }

}