<?php

/*
 * This file is part of the ACF Collector plugin.
 *
 * (c) Alfredo Aiello <stuzzo@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ACFCollector\Formatter;

use ACFCollector\Handler\ACFHandler;
use function var_dump;

/**
 * Class that formats Google map field
 *
 * @since      1.0.0
 */
class RepeaterFormatter extends BaseFormatter
{
    /**
     * GoogleMapFormatter constructor.
     *
     * @since 1.0.0
     */
    private function __construct()
    {
        $this->defaultOutputFormatterType = self::ARRAY_OUTPUT_FORMATTER_TYPE;
    }

    /**
     * @return \ACFCollector\Formatter\FormatterInterface
     *
     * @since 1.0.0
     */
    public static function getInstance()
    {
        static $inst = null;
        if ($inst === null) {
            $inst = new self();
        }

        return $inst;
    }

    /**
     * Return an array fieldName => fieldValue
     *
     * @param array $field
     * @param bool  $isOutputFiltered
     *
     * @return array
     */
    protected function prepareFieldsForOutput($field, $isOutputFiltered)
    {
        if ($isOutputFiltered) {
            $acfHandler = ACFHandler::getInstance();
            $layoutDefinitions = !empty($field['layouts']) ? $field['layouts'] : [];
            $layoutValues = !empty($field['value']) ? $field['value'] : [];
            $formattedData = [];

            foreach ($layoutValues as $layoutValue) {
                // I get the layout type
                $currentLayoutValue = [];
                $currentLayoutValue['acf_fc_layout'] = $layoutValue['acf_fc_layout'];

                // Loop through the definition to get the structure informations
                foreach ($layoutDefinitions as $layoutDefinition) {

                    // Check if the current the definition is on current layout
                    if ($layoutDefinition['name'] === $currentLayoutValue['acf_fc_layout']) {

                        // Now I have to set the value to definition and call the formatter
                        foreach ($layoutDefinition['sub_fields'] as $fieldDefinition) {
                            $fieldDefinition['value'] = $layoutValue[$fieldDefinition['name']];
                            $currentLayoutValue += $acfHandler->formatField($fieldDefinition);
                        }
                    }
                }

                $formattedData[] = $currentLayoutValue;
            }

            $returnValue = $formattedData;
        } else {
            $returnValue = $field;
        }

        return array($field['name'] => $returnValue);
    }

}