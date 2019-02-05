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

use function defined;
use function var_dump;

/**
 * Fired during plugin activation.
 * This class defines all code necessary to run during the plugin's activation.
 * @since      1.0.0
 */
final class PluginActivator
{

    /**
     * @since    1.0.0
     */
    public static function activate()
    {
        global $wp_version;
        if (version_compare($wp_version, '4.7', '<=')) {
            wp_die(__('ACF collector requires at least Wordpress 4.7', PluginI18N::PLUGIN_TEXT_DOMAIN), __('ACF collector activation error', PluginI18N::PLUGIN_TEXT_DOMAIN), array('back_link' => true));
        }

        $ACFVersion = get_option('acf_version');
        if (!class_exists('ACF') || version_compare($ACFVersion, '5.0.0', '<=')) {
            wp_die(__('ACF collector requires Advanced Custom Field 5', PluginI18N::PLUGIN_TEXT_DOMAIN), __('ACF collector activation error', PluginI18N::PLUGIN_TEXT_DOMAIN), array('back_link' => true));
        }
    }

}