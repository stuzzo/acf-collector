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
use function get_comment_meta;
use function get_option;
use function get_term_meta;
use function get_user_meta;
use function is;
use function is_admin;
use function remove_filter;
use function sprintf;
use function usort;

/**
 * @since      1.0.0
 */
final class ACFHandler
{
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
     * Return the list of acf associated with the object requested through his ID
     *
     * @param int $objectID
     * @return array
     * @since 1.0.0
     */
    public function getFieldsFormattedFromObjectID($objectID)
    {
        // I don't want to fire any behaviour if I'm in admin
        if (is_admin()) {
            return array();
        }
        add_filter('acf/load_field', array($this, 'verifyIfFieldShouldBeAddedToACFCollectorField'), 10, 1);
        $fields = get_field_objects($objectID);
        remove_filter('acf/load_field', array($this, 'verifyIfFieldShouldBeAddedToACFCollectorField'));

        return $this->checkFieldsBeforeFormat($fields);
    }

    /**
     * Enable the field to be added to the acf collector field
     *
     * @param $field array
     * @since  1.0.0
     * @return array|bool
     */
    public function verifyIfFieldShouldBeAddedToACFCollectorField($field)
    {
        if (is_admin()) {
            return $field;
        }

        if (isset($field['acf_collector_add_field_to_plugin']) && 0 === $field['acf_collector_add_field_to_plugin']) {
            return false;
        }

        return $field;
    }

    /**
     * Return the list of acf associated with the term requested through his ID and his taxonomy
     *
     * @param int $termID
     * @param string $termTaxonomy
     * @return array
     * @since 1.0.0
     */
    public function getFieldsFormattedFromTerm($termID, $termTaxonomy)
    {
        $meta = get_term_meta($termID);
        if (empty($meta)) {
            return $this->getArrayResponseWhenNoFieldsFound();
        }
        $fields = $this->getFieldsFromMetaObject($meta, sprintf('%s_%s', $termTaxonomy, $termID));

        return $this->checkFieldsBeforeFormat($fields);
    }

    /**
     * Return the list of acf associated with the comment requested through his ID
     *
     * @param int $commentID
     * @return array
     * @since 1.0.0
     */
    public function getFieldsFormattedFromCommentID($commentID)
    {
        $meta = get_comment_meta($commentID);
        if (empty($meta)) {
            return $this->getArrayResponseWhenNoFieldsFound();
        }
        $fields = $this->getFieldsFromMetaObject($meta, sprintf('comment_%s', $commentID));

        return $this->checkFieldsBeforeFormat($fields);
    }

    /**
     * Return the list of acf associated with the comment requested through his ID
     *
     * @param int $userID
     * @return array
     * @since 1.0.0
     */
    public function getFieldsFormattedFromUserID($userID)
    {
        $meta = get_user_meta($userID);
        if (empty($meta)) {
            return $this->getArrayResponseWhenNoFieldsFound();
        }
        $fields = $this->getFieldsFromMetaObject($meta, sprintf('user_%s', $userID));

        return $this->checkFieldsBeforeFormat($fields);
    }

    /**
     * Get custom fields from object meta
     *
     * @param $meta
     * @param $object
     * @return array
     * @since 1.0.0
     */
    private function getFieldsFromMetaObject($meta, $object)
    {
        $fields = array();
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

            $field['value'] = get_field($field['name'], $object);

            // append to $value
            $fields[$field['name']] = $field;
        }

        return $fields;
    }

    /**
     * Verify if fields aren't empty and order them
     *
     * @param $fields
     * @return array
     * @since 1.0.0
     */
    private function checkFieldsBeforeFormat($fields)
    {
        if (empty($fields)) {
            return $this->getArrayResponseWhenNoFieldsFound();
        }
        usort($fields, array($this, 'orderCustomFields'));

        return $this->formatFields($fields);
    }

    /**
     * @param array $fields
     * @return array
     * @since 1.0.0
     */
    private function formatFields($fields)
    {
        $formattedFields = array();
        foreach ($fields as $field) {
            $formattedFields += $this->formatField($field);
        }

        return $formattedFields;
    }

    /**
     * @param array $field
     * @return array
     * @since 1.0.0
     */
    public function formatField($field)
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

    /**
     * Return the formatted value based on field type
     *
     * @param array $field
     * @return array
     * @since 1.0.0
     */
    private function formatFieldByType($field)
    {
        /** @var \ACFCollector\Formatter\FormatterInterface $formatter */
        $formatter = FormatterFactory::getFormatter($field['type']);
        $isOutputFiltered = isset($field['acf_collector_is_output_filtered']) && 1 === $field['acf_collector_is_output_filtered'];

        return $formatter->format($field, $isOutputFiltered);
    }

    /**
     * Return the response when no fields are found on the specified object
     *
     * @return array
     * @since 1.0.0
     */
    private function getArrayResponseWhenNoFieldsFound()
    {
        return array('No fields found on the provided object');
    }

    /**
     * Order object elements by field menu_order
     *
     * @param $firstField
     * @param $secondField
     * @return bool
     * @since 1.0.0
     */
    private function orderCustomFields($firstField, $secondField)
    {
        if (!isset($firstField['menu_order'], $secondField['menu_order'])) {
            return false;
        }
        return $firstField['menu_order'] > $secondField['menu_order'];
    }
}