<?php

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @since      1.0.0
 * @package    ACF_Formatter
 * @subpackage ACF_Formatter/rest-api
 * @author     Alfredo Aiello <stuzzo@gmail.com>
 */
class ACF_Formatter_Rest_API_Handler
{

    /**
     * The ID of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string $plugin_name The ID of this plugin.
     */
    private $plugin_name;

    /**
     * The version of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string $version The current version of this plugin.
     */
    private $version;

    /**
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     *
     * @param      string $plugin_name The name of the plugin.
     * @param      string $version     The version of this plugin.
     */
    public function __construct($plugin_name, $version)
    {
        $this->plugin_name = $plugin_name;
        $this->version = $version;
    }

    /**
     * Register the api methods to modify Rest API responses.
     *
     * @since    1.0.0
     */
    public function init_api()
    {
        $this->init_page_response();
        $this->init_post_response();
    }

    private function init_page_response()
    {
        register_rest_field('page', 'acf_formatter_fields', array('get_callback' => array($this, 'get_object_custom_fields')));
    }

    private function init_post_response()
    {
        register_rest_field('post', 'acf_formatter_fields', array('get_callback' => array($this, 'get_object_custom_fields')));
    }

    public function get_object_custom_fields($object)
    {
        $fieldsHandler = ACF_Formatter_Fields_Handler::getInstance();
        $fields = $fieldsHandler->getFieldsFormattedFromObjectId($object['id']);

        return $fields;
    }

}
