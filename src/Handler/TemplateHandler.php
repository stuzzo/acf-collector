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
 * @since  1.0.0
 */
class TemplateHandler
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
     * Register the filters used to add the fields to the current object
     *
     * @since  1.0.0
     */
    public function init()
    {
        $this->loader->addFilter('template_redirect', $this, 'addFieldsToCurrentPost');
        $this->loader->addFilter('template_redirect', $this, 'addFieldsToCurrentTaxonomy');
        $this->loader->addFilter('get_comment', $this, 'addFieldsToCurrentComment');
        $this->loader->addFilter('get_user_custom_fields', $this, 'addFieldsToCurrentUser');
        $this->loader->addFilter('wp_get_nav_menu_object', $this, 'addFieldsToCurrentMenu');
        $this->loader->addFilter('wp_get_nav_menus', $this, 'addFieldsToCurrentMenus', 10, 2);
        $this->loader->addFilter('acf_collector_get_fields', $this, 'getAllFieldsForCurrentPost');
    }

    /**
     * Add the fields to the current object (page or post)
     *
     * @since  1.0.0
     */
    public function addFieldsToCurrentPost()
    {
        if (is_tax() || is_category() || is_tag()) {
            return;
        }

        global $post;
        if (empty($post) || property_exists($post, $this->ACFCollectorFieldName)) {
            return;
        }

        $fields = $this->ACFHandler->getFieldsFormattedFromObjectID($post->ID);
        $post->{$this->ACFCollectorFieldName} = $fields;
    }

    /**
     * Add the fields to the current comment
     *
     * @var \WP_Comment $comment
     * @return \WP_Comment
     * @since  1.0.0
     */
    public function addFieldsToCurrentComment($comment)
    {
        if (property_exists($comment, $this->ACFCollectorFieldName)) {
            return $comment;
        }
        $fields = $this->ACFHandler->getFieldsFormattedFromCommentID($comment->comment_ID);
        $comment->{$this->ACFCollectorFieldName} = $fields;

        return $comment;
    }

    /**
     * Add the fields to the current object (page or post)
     *
     * @since  1.0.0
     */
    public function addFieldsToCurrentTaxonomy()
    {
        /** @var \WP_Term $currentTerm */
        $currentTerm = get_queried_object();
        if (null === $currentTerm || !($currentTerm instanceof \WP_Term) || property_exists($currentTerm, $this->ACFCollectorFieldName)) {
            return;
        }
        $fields = $this->ACFHandler->getFieldsFormattedFromTerm($currentTerm->term_id, $currentTerm->taxonomy);
        $currentTerm->{$this->ACFCollectorFieldName} = $fields;
    }

    /**
     * Add the fields to the current user
     *
     * @param \WP_User $user
     * @return \WP_User
     * @since  1.0.0
     */
    public function addFieldsToCurrentUser(&$user)
    {
        if (null === $user || !($user instanceof \WP_User) || property_exists($user, $this->ACFCollectorFieldName)) {
            return;
        }
        $fields = $this->ACFHandler->getFieldsFormattedFromUserID($user->ID);
        $user->{$this->ACFCollectorFieldName} = $fields;

        return $user;
    }

    /**
     * Add the fields to the current user
     *
     * @param \WP_Term $menu
     * @return \WP_Term
     * @since  1.0.0
     */
    public function addFieldsToCurrentMenu($menu)
    {
        if (null === $menu || !($menu instanceof \WP_Term) || property_exists($menu, $this->ACFCollectorFieldName)) {
            return;
        }

        $fields = $this->ACFHandler->getFieldsFormattedFromTerm($menu->term_id, $menu->taxonomy);
        $menu->{$this->ACFCollectorFieldName} = $fields;

        return $menu;
    }

    /**
     * Add the fields to the current menus
     *
     * @param \array $menus
     * @return \array
     * @since  1.0.0
     */
    public function addFieldsToCurrentMenus($menus, $args)
    {
        foreach ($menus as &$currentMenu) {
            $currentMenu = $this->addFieldsToCurrentMenu($currentMenu);
        }

        return $menus;
    }

    /**
     * Returns an array with the custom fields related to the post
     *
     * @param int $postId
     * @return \array
     * @since  1.0.0
     */
    public function getAllFieldsForCurrentPost($postId)
    {
        return $this->ACFHandler->getFieldsFormattedFromObjectID($postId);
    }

}
