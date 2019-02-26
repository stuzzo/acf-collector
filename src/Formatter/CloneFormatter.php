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

/**
 * Class that formats clone field
 *
 * @since      1.0.0
 */
class CloneFormatter extends BaseFormatter
{
    /**
     * CloneFormatter constructor.
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
     * @param bool $isOutputFiltered
     *
     * @return array
     */
    protected function prepareFieldsForOutput($field, $isOutputFiltered)
    {
        if ($isOutputFiltered) {
            $acfHandler = ACFHandler::getInstance();
            $subFieldsDefinitions = !empty($field['sub_fields']) ? $field['sub_fields'] : array();
            $formattedData = [];
            foreach ($subFieldsDefinitions as $subField) {
                $currentSubFieldName = $subField['name'];
                $subField['value'] = !empty($field['value'][$currentSubFieldName]) ? $field['value'][$currentSubFieldName] : array();
                $formattedData += $acfHandler->formatField($subField);
            }
            $returnValue = $formattedData;
        } else {
            $returnValue = $field;
        }

        return array($field['name'] => $returnValue);
    }

}