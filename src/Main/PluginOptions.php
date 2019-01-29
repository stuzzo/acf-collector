<?php

/*
 * Alfredo Aiello <stuzzo@gmail.com>
 */

declare(strict_types=1);

namespace ACFCollector\Main;

use function add_action;
use function dirname;
use function sprintf;

class PluginOptions
{

    const PREFIX_OPTION_NAME = 'acf_collector';

    /**
     * @since    1.0.0
     */
    public function init()
    {
        add_action('admin_menu', [$this, 'setupOptions']);
    }

    public function setupOptions()
    {
        $this->registerSettings();
        $this->initOptionPage();
        $this->enqueueStyle();
    }

    private function registerSettings()
    {
        add_option(sprintf('%s_field_name', self::PREFIX_OPTION_NAME), 'acf_collector_field');
        $args = [
            'type' => 'string',
            'sanitize_callback' => 'sanitize_text_field',
            'default' => null,
        ];
        register_setting(sprintf('%s_options_group', self::PREFIX_OPTION_NAME), sprintf('%s_field_name', self::PREFIX_OPTION_NAME), $args);
    }

    private function initOptionPage()
    {
        \add_options_page(__('ACF collector options', 'acf-collector'), __('ACF collector', 'acf-collector'), 'manage_options', 'acf_collector', [$this, 'getSettingPage']);
    }

    private function enqueueStyle()
    {
        \wp_enqueue_style('acf_collector_stylesheet', plugins_url('src/Resources/admin/css/acf_collector.css', dirname(__DIR__)) . '', [], ACF_COLLECTOR_VERSION, 'all');
    }

    public function getSettingPage()
    {
        $optionGroup = sprintf('%s_options_group', self::PREFIX_OPTION_NAME);
        $optionGroupFieldName = sprintf('%s_field_name', self::PREFIX_OPTION_NAME);

        include_once dirname(__DIR__) . '/Resources/admin/settings.php';

    }
}