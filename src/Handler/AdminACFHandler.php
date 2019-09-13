<?php

/*
 * This file is part of the ACF Collector plugin.
 *
 * (c) Alfredo Aiello <stuzzo@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ACFCollector\Handler;

use ACFCollector\Main\PluginI18N;
use ACFCollector\Main\PluginLoader;
use function is_admin;
use function var_dump;

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @since  1.0.0
 */
class AdminACFHandler
{
    /**
     * @var \ACFCollector\Main\PluginLoader
     * @since  1.0.0
     */
    private $loader;

    public function __construct(PluginLoader $loader)
    {
        $this->loader = $loader;
    }

    /**
     * Register the filters used to add the fields to the current object
     *
     * @since  1.0.0
     */
    public function init()
    {
        $this->loader->addAction('acf/render_field_settings', $this, 'addSettingForShowingInCollectorField');
        $this->loader->addAction('acf/render_field_settings', $this, 'addSettingForFilterFieldOutput');
    }

    /**
     * Enable the field to be added to the acf collector field
     *
     * @param $field array
     * @since  1.0.0
     */
    public function addSettingForShowingInCollectorField($field)
    {
        acf_render_field_setting(
            $field,
            array(
                'label' => __('Add to ACF collector plugin?', PluginI18N::getPluginTextDomain()),
                'instructions' => '',
                'name' => 'acf_collector_add_field_to_plugin',
                'type' => 'true_false',
                'ui' => 1,
                'default_value' => true
            )
        );
    }

    /**
     * Add flag to filter the output field keys
     *
     * @param $field array
     * @since  1.0.0
     */
    public function addSettingForFilterFieldOutput($field)
    {
        acf_render_field_setting(
            $field,
            array(
                'label' => __('ACF Collector filter Output?', PluginI18N::getPluginTextDomain()),
                'instructions' => '',
                'name' => 'acf_collector_is_output_filtered',
                'type' => 'true_false',
                'ui' => 1,
                'default_value' => false
            )
        );
    }

}