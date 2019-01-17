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

use ACFCollector\Main\PluginLoader;

/**
 * The api-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @since      1.0.0
 */
class RestAPIHandler
{

    /**
     * @var PluginLoader
     */
    private $loader;

    public function __construct(PluginLoader $loader)
    {
        $this->loader = $loader;
    }

    /**
     * Register the api methods to modify Rest API responses.
     *
     * @since    1.0.0
     */
    public function init()
    {
        $this->initPageResponse();
        $this->initPostResponse();
    }

    private function initPageResponse()
    {
        $this->loader->addRestField('page', 'acf_formatter_fields', ['get_callback' => [$this, 'get_object_custom_fields']]);
    }

    private function initPostResponse()
    {
        $this->loader->addRestField('post', 'acf_formatter_fields', ['get_callback' => [$this, 'get_object_custom_fields']]);
    }

    public function get_object_custom_fields($object)
    {
        $fieldsHandler = ACF_Formatter_Fields_Handler::getInstance();
        $fields = $fieldsHandler->getFieldsFormattedFromObjectId($object['id']);

        return $fields;
    }

}
