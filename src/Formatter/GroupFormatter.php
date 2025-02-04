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
 * Class that formats group field
 *
 * @since      1.0.0
 */
class GroupFormatter extends BaseFormatter
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
            $fieldDefinitions = !empty($field['sub_fields']) ? $field['sub_fields'] : array();
            $fieldValues = !empty($field['value']) ? $field['value'] : array();
            $formattedData = array();
            $acfHandler = ACFHandler::getInstance();

            foreach ($fieldDefinitions as $fieldIndex => $fieldDefinition) {
                $fieldDefinition['value'] = $fieldValues[$fieldDefinition['name']];
                $formattedData += $acfHandler->formatField($fieldDefinition);
            }

            $returnValue = $formattedData;
        } else {
            $returnValue = $field;
        }

        return array($field['name'] => $returnValue);
    }

}