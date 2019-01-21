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
use function sprintf;

/**
 * @since      1.0.0
 */
final class ACFHandler
{

    /**
     * @since 1.0.0
     */
    private function __construct()
    {
    }

    /**
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
     * @param int $objectId
     *
     * @return array
     *
     * @since 1.0.0
     */
    public function getFieldsFormattedFromObjectId($objectId)
    {
        $fields = get_field_objects($objectId);
        if (empty($fields)) {
            return $this->getArrayResponseWhenNoFieldsFound();
        }

        return $this->formatFields($fields);
    }

    /**
     * @param int $termID
     * @param string $termTaxonomy
     *
     * @return array
     */
    public function getFieldsFormattedFromTerm($termID, $termTaxonomy)
    {
        $meta = get_term_meta($termID);
        if (empty($meta)) {
            return $this->getArrayResponseWhenNoFieldsFound();
        }

        // populate vars
        foreach ($meta as $key => $value) {
            // does a field key exist for this value?
            if (!isset($meta["_{$key}"])) {
                continue;
            }

            // get field
            $field_key = $meta["_{$key}"][0];
            $field = acf_maybe_get_field($field_key);

            // bail early if no field, or if the field's name is different to $k
            // - solves problem where sub fields (and clone fields) are incorrectly allowed
            if (!$field || $field['name'] !== $key) {
                continue;
            }

            $field['value'] = get_field($field['name'], sprintf('%s_%s', $termTaxonomy, $termID));

            // append to $value
            $fields[$field['name']] = $field;
        }

        if (empty($fields)) {
            return $this->getArrayResponseWhenNoFieldsFound();
        }

        return $this->formatFields($fields);
    }

    /**
     * @param $fields
     *
     * @return array
     *
     * @since 1.0.0
     */
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

    private function getArrayResponseWhenNoFieldsFound()
    {
        return array('No fields found on the provided object');
    }
}