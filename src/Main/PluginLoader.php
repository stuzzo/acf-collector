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

/**
 * Register all actions and filters for the plugin.
 *
 * Maintain a list of all hooks that are registered throughout
 * the plugin, and register them with the WordPress API. Call the
 * run function to execute the list of actions and filters.
 *
 * @since      1.0.0
 */
class PluginLoader
{

    /**
     * The array of actions registered with WordPress.
     *
     * @since    1.0.0
     * @var      array $actions The actions registered with WordPress to fire when the plugin loads.
     */
    protected $actions;

    /**
     * The array of filters registered with WordPress.
     *
     * @since    1.0.0
     * @var      array $filters The filters registered with WordPress to fire when the plugin loads.
     */
    protected $filters;

    /**
     * The array of rest fields registered with WordPress.
     *
     * @since    1.0.0
     * @var      array $restFields The rest fields registered with WordPress to fire when the plugin loads.
     */
    protected $restFields;

    /**
     * Initialize the collections used to maintain the actions and filters.
     *
     * @since    1.0.0
     */
    public function __construct()
    {
        $this->actions = array();
        $this->filters = array();
        $this->restFields = array();
    }

    /**
     * Add a new action to the collection to be registered with WordPress.
     *
     * @since    1.0.0
     *
     * @param    string $hook          The name of the WordPress action that is being registered.
     * @param    object $component     A reference to the instance of the object on which the action is defined.
     * @param    string $callback      The name of the function definition on the $component.
     * @param    int    $priority      Optional. The priority at which the function should be fired. Default is 10.
     * @param    int    $accepted_args Optional. The number of arguments that should be passed to the $callback. Default is 1.
     */
    public function addAction($hook, $component, $callback, $priority = 10, $accepted_args = 1)
    {
        $this->actions = $this->add($this->actions, $hook, $component, $callback, $priority, $accepted_args);
    }

    /**
     * Add a new filter to the collection to be registered with WordPress.
     *
     * @since    1.0.0
     *
     * @param    string $hook          The name of the WordPress filter that is being registered.
     * @param    object $component     A reference to the instance of the object on which the filter is defined.
     * @param    string $callback      The name of the function definition on the $component.
     * @param    int    $priority      Optional. The priority at which the function should be fired. Default is 10.
     * @param    int    $accepted_args Optional. The number of arguments that should be passed to the $callback. Default is 1
     */
    public function addFilter($hook, $component, $callback, $priority = 10, $accepted_args = 1)
    {
        $this->filters = $this->add($this->filters, $hook, $component, $callback, $priority, $accepted_args);
    }

    /**
     * A utility function that is used to register the actions and hooks into a single
     * collection.
     *
     * @since    1.0.0
     * @access   private
     *
     * @param    array  $hooks         The collection of hooks that is being registered (that is, actions or filters).
     * @param    string $hook          The name of the WordPress filter that is being registered.
     * @param    object $component     A reference to the instance of the object on which the filter is defined.
     * @param    string $callback      The name of the function definition on the $component.
     * @param    int    $priority      The priority at which the function should be fired.
     * @param    int    $accepted_args The number of arguments that should be passed to the $callback.
     *
     * @return   array                                  The collection of actions and filters registered with WordPress.
     */
    private function add($hooks, $hook, $component, $callback, $priority, $accepted_args)
    {
        $hooks[] = array(
            'hook' => $hook,
            'component' => $component,
            'callback' => $callback,
            'priority' => $priority,
            'accepted_args' => $accepted_args,
        );

        return $hooks;
    }

    /**
     * Add a new rest field named as $attribute to the $objectType requests with $args arguments
     *
     * @since    1.0.0
     *
     * @param string $objectType
     * @param string $attribute
     * @param array  $args
     */
    public function addRestField($objectType, $attribute, array $args)
    {
        $this->restFields[] = [
            'objectType' => $objectType,
            'attribute' => $attribute,
            'args' => $args,
        ];
    }

    /**
     * Register the filters and actions with WordPress.
     *
     * @since    1.0.0
     */
    public function run()
    {
        foreach ($this->filters as $hook) {
            \add_filter($hook['hook'], array($hook['component'], $hook['callback']), $hook['priority'], $hook['accepted_args']);
        }

        foreach ($this->actions as $hook) {
            \add_action($hook['hook'], array($hook['component'], $hook['callback']), $hook['priority'], $hook['accepted_args']);
        }

        foreach ($this->restFields as $field) {
            \register_rest_field($field['objectType'], $field['attribute'], $field['args']);
        }
    }

}