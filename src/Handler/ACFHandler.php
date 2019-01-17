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

/**
 * @since      1.0.0
 */
class ACFHandler
{
    const FORMATTERS_CLASS_PREFIX = 'ACF_Formatter_Input_';

    public function getFieldsFormattedFromObjectId($objectId)
    {
        $formattedFields = [];
        $fields = get_field_objects($objectId);
        if (empty($fields)) {
            return $formattedFields;
        }

        return $this->formatFields($fields);
    }

    private function formatFields(array $fields)
    {
        $formattedFields = [];
        foreach ($fields as $field) {
            $formattedFields += $this->formatField($field);
        }

        return $formattedFields;
    }

    private function formatField(array $field)
    {
        try {
            $formattedField = $this->formatFieldByType($field);
        } catch (FieldNotImplementedException $exception) {
            $formattedField[$field['name']] = $exception->getMessage();
        }

        return $formattedField;
    }


    private function formatFieldByType(array $field)
    {
        $formatter_class = sprintf('%s%s', self::FORMATTERS_CLASS_PREFIX, ucfirst($field['type']));
        if (!class_exists($formatter_class)) {
            throw new FieldNotImplementedException($field['type']);
        }


    }

}