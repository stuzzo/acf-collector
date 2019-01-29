<?php

/*
 * Alfredo Aiello <stuzzo@gmail.com>
 */

declare(strict_types=1);

namespace ACFCollector\Main;

use function add_action;
use function sprintf;

class PluginOptions
{

    const PREFIX_OPTION_NAME = 'acf_collector';

    /**
     * @since    1.0.0
     */
    public function init()
    {
        add_action('admin_init', [$this, 'setupOptions']);
    }

    public function setupOptions()
    {
//        $this->registerSettings();
        $this->initOptionPage();
    }

    private function registerSettings()
    {
        //        add_option(sprintf('%s_field_name', self::PREFIX_OPTION_NAME), 'acf_collector_field');
        $args = [
            'type' => 'string',
            'sanitize_callback' => 'sanitize_text_field',
            'default' => null,
        ];
        register_setting(sprintf('%s_options_group', self::PREFIX_OPTION_NAME), sprintf('%s_field_name', self::PREFIX_OPTION_NAME), $args);
    }

    private function initOptionPage()
    {
        \add_options_page(__('ACF collector options', 'acf-collector'), __('ACF collector', 'acf-collector'), 'manage_options', 'acfcollector-settings', [$this, 'getSettingPage']);
    }

    public function getSettingPage()
    {
        ?>
        <div class="wrap">
            <h1>Theme Panel</h1>
            <form method="post" action="options.php">
                <?php
                settings_fields('section');
                do_settings_sections('theme-options');
                submit_button();
                ?>
            </form>
        </div>
        <?php
    }
}