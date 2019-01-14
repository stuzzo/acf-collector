<?php

namespace ACFFormatter\Main;

/**
 * The core plugin class.
 *
 * This class initializes all the plugin functionality
 *
 * @since      1.0.0
 * @package    ACF_Formatter
 * @subpackage ACF_Formatter/includes
 * @author     Alfredo Aiello <stuzzo@gmail.com>
 */
class PluginKernel
{

    /**
     * The loader that's responsible for maintaining and registering all hooks that power
     * the plugin.
     *
     * @since    1.0.0
     * @access   protected
     * @var      ACF_Formatter_Loader $loader Maintains and registers all hooks for the plugin.
     */
    protected $loader;

    /**
     * The unique identifier of this plugin.
     *
     * @since    1.0.0
     * @access   protected
     * @var      string $plugin_name The string used to uniquely identify this plugin.
     */
    protected $plugin_name;

    /**
     * The current version of the plugin.
     *
     * @since    1.0.0
     * @access   protected
     * @var      string $version The current version of the plugin.
     */
    protected $version;

    /**
     * Define the core functionality of the plugin.
     *
     * Set the plugin name and the plugin version that can be used throughout the plugin.
     * Load the dependencies, define the locale, and set the hooks for the admin area and
     * the public-facing side of the site.
     *
     * @since    1.0.0
     */
    public function __construct()
    {
        add_action('plugins_loaded', array($this, 'init'));
    }

    public function init()
    {
        if (defined('PLUGIN_NAME_VERSION')) {
            $this->version = PLUGIN_NAME_VERSION;
        } else {
            $this->version = '1.0.0';
        }
//        $this->plugin_name = 'acf-formatter';
//
//        $this->load_dependencies();
//        $this->set_locale();
//                $this->define_admin_hooks();
////        $this->define_public_hooks();
//        $this->define_api_hooks();
    }

    /**
     * Load the required dependencies for this plugin.
     *
     * Include the following files that make up the plugin:
     *
     * - ACF_Formatter_Loader. Orchestrates the hooks of the plugin.
     * - ACF_Formatter_i18n. Defines internationalization functionality.
     * - ACF_Formatter_Admin. Defines all hooks for the admin area.
     * - ACF_Formatter_Public. Defines all hooks for the public side of the site.
     *
     * Create an instance of the loader which will be used to register the hooks
     * with WordPress.
     *
     * @since    1.0.0
     * @access   private
     */
    private function load_dependencies()
    {

        /**
         * The class responsible for orchestrating the actions and filters of the
         * core plugin.
         */
//        require_once plugin_dir_path(__DIR__) . 'includes/class-acf-formatter-loader.php';

        /**
         * The class responsible for defining internationalization functionality
         * of the plugin.
         */
//        require_once plugin_dir_path(__DIR__) . 'includes/class-acf-formatter-i18n.php';

        /**
         * The class responsible for defining all actions that occur in the admin area.
         */
//        require_once plugin_dir_path(__DIR__) . 'admin/class-acf-formatter-admin.php';

        /**
         * The class responsible for defining all actions that occur in the public-facing
         * side of the site.
         */
//        require_once plugin_dir_path(__DIR__) . 'public/class-acf-formatter-public.php';

//        $folders_to_be_loaded = array('exception', 'handler', 'formatter');
//        foreach ($folders_to_be_loaded as $folder_to_be_loaded) {
//            foreach (glob(plugin_dir_path(__DIR__) . "$folder_to_be_loaded/*.php") as $file) {
//                require_once $file;
//            }
//        }
//
        $this->loader = new ACF_Formatter_Loader();

    }

    /**
     * Define the locale for this plugin for internationalization.
     *
     * Uses the ACF_Formatter_i18n class in order to set the domain and to register the hook
     * with WordPress.
     *
     * @since    1.0.0
     * @access   private
     */
    private function set_locale()
    {
        $plugin_i18n = new ACF_Formatter_i18n();

        $this->loader->add_action('plugins_loaded', $plugin_i18n, 'load_plugin_textdomain');
    }

    /**
     * Register all of the hooks related to the admin area functionality
     * of the plugin.
     *
     * @since    1.0.0
     * @access   private
     */
    private function define_admin_hooks()
    {
        $plugin_admin = new ACF_Formatter_Admin($this->get_plugin_name(), $this->get_version());

        $this->loader->add_action('admin_enqueue_scripts', $plugin_admin, 'enqueue_styles');
        $this->loader->add_action('admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts');
    }

    /**
     * Register all of the hooks related to the public-facing functionality
     * of the plugin.
     *
     * @since    1.0.0
     * @access   private
     */
    private function define_public_hooks()
    {
        $plugin_public = new ACF_Formatter_Public($this->get_plugin_name(), $this->get_version());

        $this->loader->add_action('wp_enqueue_scripts', $plugin_public, 'enqueue_styles');
        $this->loader->add_action('wp_enqueue_scripts', $plugin_public, 'enqueue_scripts');
        $this->loader->add_filter('template_redirect', $plugin_public, 'register_template_hook');
    }

    /**
     * Register all of the hooks related to the rest api functionality
     * of the plugin.
     *
     * @since    1.0.0
     * @access   private
     */
    private function define_api_hooks()
    {
        $plugin_api = new ACF_Formatter_Rest_API_Handler($this->get_plugin_name(), $this->get_version());

        $this->loader->add_filter('rest_api_init', $plugin_api, 'init_api');
    }

    /**
     * Run the loader to execute all of the hooks with WordPress.
     *
     * @since    1.0.0
     */
    public function run()
    {
        $this->loader->run();
    }

    /**
     * The name of the plugin used to uniquely identify it within the context of
     * WordPress and to define internationalization functionality.
     *
     * @since     1.0.0
     * @return    string    The name of the plugin.
     */
    public function get_plugin_name()
    {
        return $this->plugin_name;
    }

    /**
     * The reference to the class that orchestrates the hooks with the plugin.
     *
     * @since     1.0.0
     * @return    ACF_Formatter_Loader    Orchestrates the hooks of the plugin.
     */
    public function get_loader()
    {
        return $this->loader;
    }

    /**
     * Retrieve the version number of the plugin.
     *
     * @since     1.0.0
     * @return    string    The version number of the plugin.
     */
    public function get_version()
    {
        return $this->version;
    }

}
