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
use function get_taxonomies;
use function get_term_by;
use function var_dump;

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
    const ACF_COLLECTOR_FIELD_NAME = 'acf_collector_field';

    /**
     * @var \ACFCollector\Main\PluginLoader
     *
     * @since      1.0.0
     */
    private $loader;

    /**
     * @var \ACFCollector\Handler\ACFHandler
     *
     * @since      1.0.0
     */
    private $ACFHandler;

    public function __construct(PluginLoader $loader, ACFHandler $ACFHandler)
    {
        $this->loader = $loader;
        $this->ACFHandler = $ACFHandler;
    }

    /**
     * Register the api methods to modify Rest API responses.
     *
     * @since    1.0.0
     */
    public function init()
    {
        $this->loader->addAction('wp_loaded', $this, 'setupRestFields');
    }


    /**
     * @since      1.0.0
     */
    public function setupRestFields()
    {
        $this->initPageResponse();
        $this->initPostResponse();
        $this->initCustomPostTypes();
        $this->initTaxonomyResponse();
    }

    /**
     * @since      1.0.0
     */
    private function initPageResponse()
    {
        $this->addRestField('page', self::ACF_COLLECTOR_FIELD_NAME, array('get_callback' => array($this, 'getObjectCustomFields')));
    }

    /**
     * @since      1.0.0
     */
    private function initPostResponse()
    {
        $this->addRestField('post', self::ACF_COLLECTOR_FIELD_NAME, array('get_callback' => array($this, 'getObjectCustomFields')));
    }

    /**
     * @since      1.0.0
     */
    private function initCustomPostTypes()
    {
        $args = array(
            'public'   => true,
            '_builtin' => false,
        );
        $output = 'names'; // names or objects, note names is the default
        $operator = 'and'; // 'and' or 'or'
        $post_types = get_post_types($args, $output, $operator);
        foreach ($post_types as $postType) {
            $this->addRestField($postType, self::ACF_COLLECTOR_FIELD_NAME, array('get_callback' => array($this, 'getObjectCustomFields')));
        }
    }

    /**
     * @since      1.0.0
     */
    private function initTaxonomyResponse()
    {
        $taxonomies = get_taxonomies();
        foreach ($taxonomies as $taxonomy) {
            $this->addRestField($taxonomy, self::ACF_COLLECTOR_FIELD_NAME, array('get_callback' => array($this, 'getTermCustomFields')));
        }
    }

    /**
     * @since      1.0.0
     */
    private function addRestField($type, $fieldName, $args)
    {
        \register_rest_field($type, $fieldName, $args);
    }

    /**
     * @param mixed $object Current object requested (Post, Page, etc.)
     *
     * @return array
     */
    public function getObjectCustomFields($object)
    {
        return $this->ACFHandler->getFieldsFormattedFromObjectId($object['id']);
    }

    /**
     * @param array $currentTerm Current term requested
     *
     * @return array
     */
    public function getTermCustomFields($currentTerm)
    {
        return $this->ACFHandler->getFieldsFormattedFromTerm($currentTerm['id'], $currentTerm['taxonomy']);
    }

}