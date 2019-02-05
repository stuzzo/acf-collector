<?php

/*
 * This file is part of the ACF Collector plugin.
 *
 * (c) Alfredo Aiello <stuzzo@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ACFCollector\Main;

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
     * @since 1.0.0
     */
    const PLUGIN_TEXT_DOMAIN = 'acf-collector';

    /**
     * Return the plugin text domain
     * @return string
     * @since 1.0.0
     */
    public static function getPluginTextDomain()
    {
        static $inst = null;
        if ($inst === null) {
            $inst = new self();
        }
        return self::PLUGIN_TEXT_DOMAIN;
    }

    /**
     * Load the plugin text domain for translation.
     * @since    1.0.0
     */
    public function loadPluginTextdomain()
    {
        \load_plugin_textdomain(
            self::PLUGIN_TEXT_DOMAIN,
            false,
            dirname(__DIR__) . '/Resources/languages/'
        );
    }

}