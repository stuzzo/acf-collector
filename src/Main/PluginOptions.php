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

    /**
     * @since    1.0.0
     */
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
        $optionsGroup = sprintf('%s_options_group', self::PREFIX_OPTION_NAME);
        $optionsSection = sprintf('%s_options_section', self::PREFIX_OPTION_NAME);

        \add_settings_section(
            $optionsSection, //section name for the section to add
            'Advanced Custom Fields Collector Settings', //section title visible on the page
            null, //callback for section description
            $optionsGroup//page to which section will be added.
        );

        \add_settings_field(
            'acf_collector_field_name',//ID for the settings field to add
            'Field name', //settings title visible on the page
            [$this, 'renderTextField'], //callback for displaying the settings field
            $optionsGroup, // settings page to where option is displayed
            $optionsSection,// section id for parent section.
            ['name' => 'acf_collector_field_name', 'description' => 'This will be the key where you will find the custom fields']
        );
        \register_setting($optionsGroup, 'acf_collector_field_name');

        \add_settings_field(
            'acf_collector_is_output_filtered',//ID for the settings field to add
            'Do you want to filter output?', //settings title visible on the page
            [$this, 'renderRadioField'], //callback for displaying the settings field
            $optionsGroup, // settings page to where option is displayed
            $optionsSection,// section id for parent section.
            [
                'name' => 'acf_collector_is_output_filtered',
                'description' => 'Choose if you want to receive all the fields properties or just value, label and name',
                'options' => [['label' => 'Yes', 'value' => 1], ['label' => 'No', 'value' => 0]]
            ]
        );
        \register_setting($optionsGroup, 'acf_collector_is_output_filtered');

    }

    public function renderTextField($args)
    {
        $input = sprintf('<input type="text" name="%s" value="%s">', $args['name'], esc_attr(get_option($args['name'], 'acf_collector_field')));
        $span = sprintf('<br><span class="acf-collector-container_body--span">%s</span>', $args['description']);

        echo $input . $span;
    }

    public function renderRadioField($args)
    {
        $radio = '';
        $currentValue = (int) esc_attr(get_option($args['name'], 0));
        foreach ($args['options'] as $key => $value) {
            $radio .= sprintf('<input class="acf-collector-container_body--input-radio" type="radio" name="%s" value="%s" %s>%s', $args['name'], $value['value'], $currentValue === $value['value'] ? 'checked' : '', $value['label']);
        }
        $span = sprintf('<br><span class="acf-collector-container_body--span">%s</span>', $args['description']);

        echo $radio . $span;
    }

    private function initOptionPage()
    {
        \add_options_page(__('ACF collector options', 'acf-collector'), __('ACF collector', 'acf-collector'), 'manage_options', 'acf_collector', [$this, 'getSettingPage']);
    }

    public function getSettingPage()
    {
        $optionGroup = sprintf('%s_options_group', self::PREFIX_OPTION_NAME);
        $optionGroupFieldName = sprintf('%s_field_name', self::PREFIX_OPTION_NAME);

        include_once dirname(__DIR__) . '/Resources/admin/settings.php';
    }

    private function enqueueStyle()
    {
        \wp_enqueue_style('acf_collector_stylesheet', plugins_url('src/Resources/admin/css/acf_collector.css', dirname(__DIR__)) . '', [], ACF_COLLECTOR_VERSION, 'all');
    }

}