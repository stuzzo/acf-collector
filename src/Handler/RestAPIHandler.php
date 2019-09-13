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

/**
 * The api-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @since  1.0.0
 */
class RestAPIHandler
{
    /**
     * @var \ACFCollector\Main\PluginLoader
     * @since  1.0.0
     */
    private $loader;

    /**
     * @var \ACFCollector\Handler\ACFHandler
     * @since  1.0.0
     */
    private $ACFHandler;

    /**
     * @var string
     * @since  1.0.0
     */
    private $ACFCollectorFieldName;

    public function __construct(PluginLoader $loader, ACFHandler $ACFHandler, $ACFCollectorFieldName)
    {
        $this->loader = $loader;
        $this->ACFHandler = $ACFHandler;
        $this->ACFCollectorFieldName = $ACFCollectorFieldName;
    }

    /**
     * Register the api methods to modify Rest API responses.
     *
     * @since  1.0.0
     */
    public function init()
    {
        $this->loader->addAction('rest_api_init', $this, 'setupRestFields');
    }


    /**
     * @since  1.0.0
     */
    public function setupRestFields()
    {
        $this->initCustomPostTypesResponse();
        $this->initTaxonomyResponse();
        $this->initTagResponse();
        $this->initCommentResponse();
        $this->initUserResponse();
    }

    /**
     * Add the field to all the custom post types
     *
     * @since  1.0.0
     */
    private function initCustomPostTypesResponse()
    {
        $post_types = get_post_types(array('public' => true));
        foreach ($post_types as $postType) {
            $this->addRestField($postType, $this->ACFCollectorFieldName, array('get_callback' => array($this, 'getObjectCustomFields')));
        }
    }

    /**
     * Add the field to all the taxonomies types
     *
     * @since  1.0.0
     */
    private function initTaxonomyResponse()
    {
        $taxonomies = get_taxonomies();
        foreach ($taxonomies as $taxonomy) {
            $this->addRestField($taxonomy, $this->ACFCollectorFieldName, array('get_callback' => array($this, 'getTermCustomFields')));
        }
    }

    /**
     * Add the field to tags
     *
     * @since  1.0.0
     */
    private function initTagResponse()
    {
        $this->addRestField('tag', $this->ACFCollectorFieldName, array('get_callback' => array($this, 'getTermCustomFields')));
    }

    /**
     * Add the field to comments
     *
     * @since  1.0.0
     */
    private function initCommentResponse()
    {
        $this->addRestField('comment', $this->ACFCollectorFieldName, array('get_callback' => array($this, 'getCommentCustomFields')));
    }

    /**
     * Add the field to users
     *
     * @since  1.0.0
     */
    private function initUserResponse()
    {
        $this->addRestField('user', $this->ACFCollectorFieldName, array('get_callback' => array($this, 'getUserCustomFields')));
    }

    /**
     * @since  1.0.0
     */
    private function addRestField($type, $fieldName, $args)
    {
        \register_rest_field($type, $fieldName, $args);
    }

    /**
     * @param mixed $object Current object requested (Post, Page, etc.)
     * @return array
     * @since  1.0.0
     */
    public function getObjectCustomFields($object)
    {
        if (!isset($object['id'])) {
            return [];
        }
        return $this->ACFHandler->getFieldsFormattedFromObjectID($object['id']);
    }

    /**
     * @param array $currentTerm Current term requested
     * @return array
     * @since  1.0.0
     */
    public function getTermCustomFields($currentTerm)
    {
        if (!isset($currentTerm['id'])) {
            return [];
        }
        return $this->ACFHandler->getFieldsFormattedFromTerm($currentTerm['id'], $currentTerm['taxonomy']);
    }

    /**
     * @param array $currentComment Current comment requested
     * @return array
     * @since  1.0.0
     */
    public function getCommentCustomFields($currentComment)
    {
        if (!isset($currentComment['id'])) {
            return [];
        }
        return $this->ACFHandler->getFieldsFormattedFromCommentID($currentComment['id']);
    }

    /**
     * @param array $currentUser Current user requested
     * @return array
     * @since  1.0.0
     */
    public function getUserCustomFields($currentUser)
    {
        if (!isset($currentUser['id'])) {
            return [];
        }
        return $this->ACFHandler->getFieldsFormattedFromUserID($currentUser['id']);
    }

}