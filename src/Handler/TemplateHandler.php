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
use function get_queried_object;
use function is_category;
use function is_tag;
use function is_tax;

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @since      1.0.0
 */
class TemplateHandler
{
    const ACF_COLLECTOR_FIELD_NAME = 'acf_collector_field';

    /**
     * @var \ACFCollector\Main\PluginLoader
     */
    private $loader;

    /**
     * @var \ACFCollector\Handler\ACFHandler
     */
    private $ACFHandler;

    public function __construct(PluginLoader $loader, ACFHandler $ACFHandler)
    {
        $this->loader = $loader;
        $this->ACFHandler = $ACFHandler;
    }

    /**
     * Register the filters used to add the fields to the current object
     *
     * @since    1.0.0
     */
    public function init()
    {
        $this->loader->addFilter('template_redirect', $this, 'addFieldsToCurrentPost');
        $this->loader->addFilter('template_redirect', $this, 'addFieldsToCurrentTaxonomy');
        $this->loader->addFilter('get_comment', $this, 'addFieldsToCurrentComment');
    }

    /**
     * Add the fields to the current object (page or post)
     *
     * @since    1.0.0
     */
    public function addFieldsToCurrentPost()
    {
        if (is_tax() || is_category() || is_tag()) {
            return;
        }

        global $post;
        if (empty($post)) {
            return;
        }
        $fields = $this->ACFHandler->getFieldsFormattedFromObjectID($post->ID);
        $post->{self::ACF_COLLECTOR_FIELD_NAME} = $fields;
    }

    /**
     * Add the fields to the current comment
     *
     * @var \WP_Comment $comment
     * @since    1.0.0
     *
     * @return \WP_Comment
     */
    public function addFieldsToCurrentComment($comment)
    {
        $fields = $this->ACFHandler->getFieldsFormattedFromCommentID($comment->comment_ID);
        $comment->{self::ACF_COLLECTOR_FIELD_NAME} = $fields;

        return $comment;
    }

    /**
     * Add the fields to the current object (page or post)
     *
     * @since    1.0.0
     */
    public function addFieldsToCurrentTaxonomy()
    {
        /** @var \WP_Term $currentTerm */
        $currentTerm = get_queried_object();
        if (null === $currentTerm || !($currentTerm instanceof \WP_Term)) {
            return;
        }
        $fields = $this->ACFHandler->getFieldsFormattedFromTerm($currentTerm->term_id, $currentTerm->taxonomy);
        $currentTerm->{self::ACF_COLLECTOR_FIELD_NAME} = $fields;
    }

}
