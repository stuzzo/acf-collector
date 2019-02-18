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
use ACFCollector\Exception\WrongFilteredFieldsException;
use ACFCollector\Factory\FormatterOutputFactory;
use function array_diff;
use function array_values;
use function count;
use function implode;
use function in_array;
use function sprintf;

/**
 * Base class that contains only helper methods for formatters
 *
 * @since      1.0.0
 */
abstract class BaseFormatter implements FormatterInterface
{
    const STRING_OUTPUT_FORMATTER_TYPE = 'String';
    const ARRAY_OUTPUT_FORMATTER_TYPE = 'Array';
    const INTEGER_OUTPUT_FORMATTER_TYPE = 'Integer';

    /**
     * @var string
     * @since 1.0.0
     */
    protected $defaultOutputFormatterType;

    /**
     * @var array
     * @since 1.0.0
     */
    protected $returnKeys;

    /**
     * Keys that are returned for each field type
     *
     * @return array
     * @since 1.0.0
     */
    protected function getBaseReturnFields()
    {
        return [
            'label',
            'name',
            'type',
        ];
    }

    /**
     * Set the keys to return
     *
     * @since 1.0.0
     */
    protected function init()
    {
        $this->returnKeys = array_merge($this->returnKeys, $this->getBaseReturnFields());
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

        if ($isOutputFiltered) {
            try {
                $formattedFields = $this->filterArrayFieldByReturnKeys($field, $this->returnKeys);
            } catch (WrongFilteredFieldsException $exception) {
                $formattedFields['value'] = $exception->getMessage();

                return $this->prepareFieldsForOutput($field, $formattedFields);
            }
        } else {
            $formattedFields = $this->formatArrayKeysByKeys($field);
        }

        $this->setOutputFormatterByField($field);
        try {
            $outputFormatter = FormatterOutputFactory::getFormatterForOutput($this->defaultOutputFormatterType);
            $formattedFields += $outputFormatter->formatReturnValue($field);
        } catch (OutputFormatterNotImplementedException $exception) {
            $formattedFields['value'] = $exception->getMessage();
        }

        return $this->prepareFieldsForOutput($field, $formattedFields);
    }

    /**
     * Filter the result array by keys specified on init method
     *
     * @param $field
     * @param $returnKeys
     *
     * @return array
     */
    protected function filterArrayFieldByReturnKeys($field, $returnKeys)
    {
        $formattedFields = [];
        foreach ($field as $key => $value) {
            if (in_array($key, $returnKeys, true)) {
                $formattedFields[$key] = $value;
            }
        }

        if (count($formattedFields) !== count($returnKeys)) {
            $diff = array_diff(array_values($returnKeys), array_keys($formattedFields));
            $diffMessage = sprintf('The following %s different: %s', count($diff) > 1 ? 'elements are' : 'element is', implode(',', $diff));
            throw new WrongFilteredFieldsException(sprintf('The field %s expects %d to return, %d received. %s', $field['name'], count($returnKeys), count($formattedFields), $diffMessage));
        }

        return $formattedFields;
    }

    /**
     * Filter the result array by keys specified on init method
     *
     * @param $field
     *
     * @return array
     */
    protected function formatArrayKeysByKeys($field)
    {
        $formattedFields = [];
        foreach ($field as $key => $value) {
            $formattedFields[$key] = $value;
        }

        return $formattedFields;
    }

    /**
     * Return an array fieldName => fieldValue
     *
     * @param $field
     * @param $formattedFields
     *
     * @return array
     */
    protected function prepareFieldsForOutput($field, $formattedFields)
    {
        return [$field['name'] => $formattedFields];
    }

    /**
     * Verify if the current field has the return format key and modify the output formatter
     *
     * @param $field
     */
    protected function setOutputFormatterByField($field)
    {
        if ('checkbox' === $field['type']) {
            $this->defaultOutputFormatterType = 'Array';
            return;
        }

        if (!isset($field['return_format'])) {
            return;
        }

        switch ($field['return_format']) {
            case 'array':
                $this->defaultOutputFormatterType = 'Array';
                break;
            case 'id':
                $this->defaultOutputFormatterType = 'Integer';
        }
    }
}
