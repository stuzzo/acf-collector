<?php

/*
 * This file is part of the ACF Collector plugin.
 *
 * (c) Alfredo Aiello <stuzzo@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ACFCollector\Handler;

use ACFCollector\Exception\FieldNotImplementedException;
use ACFCollector\Factory\FormatterFactory;

/**
 * @since      1.0.0
 */
final class ACFHandler
{

    /**
     * @since      1.0.0
     */
    private function __construct() {}

    /**
     * @since      1.0.0
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
     * @param int $objectId
     *
     * @return array
     */
    public function getFieldsFormattedFromObjectId($objectId)
    {
        $fields = get_field_objects($objectId);
        if (empty($fields)) {
            return ['No fields found on the provided object'];
        }

        return $this->formatFields($fields);
    }

    private function formatFields($fields)
    {
        $formattedFields = [];
        foreach ($fields as $field) {
            $formattedFields += $this->formatField($field);
        }

        return $formattedFields;
    }

    private function formatField($field)
    {
        if (empty($field['name'])) {
            $formattedField[$field['error']] = 'Found one or more fields without name';
            return $formattedField;
        }

        if (empty($field['type'])) {
            $formattedField[$field['name']] = 'Type not set for this field';
            return $formattedField;
        }

        if (!isset($field['value'])) {
            $formattedField[$field['name']] = 'Value not found';
            return $formattedField;
        }

        try {
            $formattedField = $this->formatFieldByType($field);
        } catch (FieldNotImplementedException $exception) {
            $formattedField[$field['name']] = $exception->getMessage();
        }

        return $formattedField;
    }


    private function formatFieldByType($field)
    {
        /** @var \ACFCollector\Formatter\FormatterInterface $formatter */
        $formatter = FormatterFactory::getFormatter($field['type']);

        return $formatter->formatReturnValue($field);
    }

}