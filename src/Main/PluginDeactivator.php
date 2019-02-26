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
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      1.0.0
 */
final class PluginDeactivator
{

    /**
     * @since    1.0.0
     */
    public static function deactivate()
    {
        \delete_option('acf_collector_field_name');
        \delete_option('acf_collector_is_output_filtered');
    }

}