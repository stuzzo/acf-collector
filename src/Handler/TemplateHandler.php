<?php

/*
 * This file is part of the ACF Formatter plugin.
 *
 * (c) Alfredo Aiello <stuzzo@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ACFFormatter\Handler;

use ACFFormatter\Main\PluginLoader;

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
    public function init(): void
    {
        $this->loader->addFilter('template_redirect', $this, 'register_template_hook');
    }

    /**
     * Register the JavaScript for the public-facing side of the site.
     *
     * @since    1.0.0
     */
    public function register_template_hook()
    {
        global $post;
        $fields = get_field_objects($post->ID);
        $post->fields = $fields;
        var_dump($fields);
        die('ciao');

    }

}
