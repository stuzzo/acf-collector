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

use ACFCollector\Handler\RestAPIHandler;
use ACFCollector\Handler\TemplateHandler;

/**
 * The core plugin class.
 *
 * This class initializes all the plugin functionality
 *
 * @since      1.0.0
 */
class PluginKernel
{

    /**
     * The unique identifier of this plugin.
     * @var      string $pluginName The string used to uniquely identify this plugin.
     * @since    1.0.0
     */
    private $pluginName;

    /**
     * The current version of the plugin.
     * @var      string $version The current version of the plugin.
     * @since    1.0.0
     */
    private $version;

    /**
     * The class that contains I18N logic
     * @var \ACFCollector\Main\PluginI18N
     * @since    1.0.0
     */
    private $i18n;

    /**
     * @var \ACFCollector\Handler\RestAPIHandler
     * @since    1.0.0
     */
    private $apiHandler;

    /**
     * @var \ACFCollector\Handler\TemplateHandler
     * @since    1.0.0
     */
    private $templateHandler;

    /**
     * @var \ACFCollector\Main\PluginLoader
     * @since    1.0.0
     */
    private $loader;

    /**
     * @var \ACFCollector\Main\PluginOptions
     * @since    1.0.0
     */
    private $options;

    public function __construct(PluginI18N $i18n, RestAPIHandler $apiHandler, TemplateHandler $templateHandler, PluginLoader $loader, PluginOptions $options)
    {
        add_action('plugins_loaded', [$this, 'init']);
        $this->i18n = $i18n;
        $this->apiHandler = $apiHandler;
        $this->templateHandler = $templateHandler;
        $this->loader = $loader;
        $this->options = $options;
    }

    /**
     * Define the core functionality of the plugin.
     *
     * Set the plugin name and the plugin version that can be used throughout the plugin.
     * Load the dependencies, define the locale, and set the hooks for the admin area and
     * the public-facing side of the site.
     *
     * @since    1.0.0
     */
    public function init()
    {
        if (defined('ACF_COLLECTOR_VERSION')) {
            $this->version = ACF_COLLECTOR_VERSION;
        } else {
            $this->version = '1.0.0';
        }
        $this->pluginName = 'acf-collector';
        $this->loadTextDomain();
        $this->initAPIHandler();
        $this->initTemplateHandler();
        $this->initLoader();
        $this->initOptionPage();
    }

    /**
     * The name of the plugin used to uniquely identify it within the context of
     * WordPress and to define internationalization functionality.
     * @return    string    The name of the plugin.
     * @since     1.0.0
     */
    public function getPluginName()
    {
        return $this->pluginName;
    }

    /**
     * Retrieve the version number of the plugin.
     * @return    string    The version number of the plugin.
     * @since     1.0.0
     */
    public function getVersion()
    {
        return $this->version;
    }

    /**
     * Initialize i18n text domain.
     * @since    1.0.0
     */
    private function loadTextDomain()
    {
        $this->i18n->loadPluginTextdomain();
    }

    /**
     * Initialize rest api handler
     * @since    1.0.0
     */
    private function initAPIHandler()
    {
        $this->apiHandler->init();
    }

    /**
     * Register all of the hooks related to the public-facing functionality
     * of the plugin.
     * @since    1.0.0
     */
    private function initTemplateHandler()
    {
        $this->templateHandler->init();
    }

    /**
     * Run the loader to execute all of the hooks with WordPress.
     * @since    1.0.0
     */
    private function initLoader()
    {
        $this->loader->run();
    }

    /**
     * Run the loader to execute all of the hooks with WordPress.
     * @since    1.0.0
     */
    private function initOptionPage()
    {
        $this->options->init();
    }
}