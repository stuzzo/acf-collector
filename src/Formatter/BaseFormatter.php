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

use ACFCollector\Exception\OutputFormatterNotImplementedException;
use ACFCollector\Factory\FormatterOutputFactory;

/**
 * Base class that contains only helper methods for formatters
 *
 * @since      1.0.0
 */
abstract class BaseFormatter implements FormatterInterface
{
    const STRING_OUTPUT_FORMATTER_TYPE = 'String';
    const ARRAY_OUTPUT_FORMATTER_TYPE = 'Array';
    const OBJECT_OUTPUT_FORMATTER_TYPE = 'Object';
    const INTEGER_OUTPUT_FORMATTER_TYPE = 'Integer';

    /**
     * @var string
     * @since 1.0.0
     */
    protected $defaultOutputFormatterType;

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
        try {
            $outputFormatter = FormatterOutputFactory::getFormatterForOutput($this->defaultOutputFormatterType);
            $field += $outputFormatter->formatReturnValue($field);
        } catch (OutputFormatterNotImplementedException $exception) {
            $field['value'] = $exception->getMessage();
        }

        return $this->prepareFieldsForOutput($field, $isOutputFiltered);
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
            /*
             * In this way I know that every field type set a value,
             * so in next time, I can cast the formatted fields parameter to array
             */
            $returnValue = $field['value'];
        } else {
            $returnValue = $field;
        }


        return [$field['name'] => $returnValue];
    }

    /**
     * Verify if the current field has the return format key and modify the output formatter
     *
     * @param $field
     */
    protected function setOutputFormatterByField($field)
    {
        if (!isset($field['return_format'])) {
            return;
        }

        switch ($field['return_format']) {
            case 'array':
                $this->defaultOutputFormatterType = 'Array';
                break;
            case 'id':
                $this->defaultOutputFormatterType = 'Integer';
                break;
            case 'object':
                $this->defaultOutputFormatterType = 'Object';
        }
    }
}
