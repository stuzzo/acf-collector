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
     * @param array $field
     * @param bool  $isOutputFiltered
     *
     * @return array
     * @since 1.0.0
     */
    public function format($field, $isOutputFiltered)
    {
        $this->setOutputFormatterByField($field);

        $subFieldsDefinitions = isset($field['sub_fields']) ? $field['sub_fields'] : [];
        $subFieldsBlocks = ($field['value'] && $field['value'] !== false) ? $field['value'] : [];
        $formattedData = [];

        foreach ($subFieldsBlocks as $subFieldsBlock) {
            $index = 0;
            $currentFormattedField = [];
            foreach ($subFieldsBlock as $fieldKey => $fieldValue) {
                $currentSubField = $subFieldsDefinitions[$index++];
                $currentSubField['value'] = $fieldValue;
                $currentFormattedField += parent::format($currentSubField, $isOutputFiltered);
            }
            $formattedData[] = $currentFormattedField;
        }
        $field['value'] = $formattedData;

        return $this->prepareFieldsForOutput($field, $isOutputFiltered);
    }
}