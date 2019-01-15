<?php

/**
 * @since      1.0.0
 * @package    ACF_Formatter
 * @subpackage ACF_Formatter/handler
 * @author     Alfredo Aiello <stuzzo@gmail.com>
 */
class ACF_Formatter_Fields_Handler
{
    const FORMATTERS_CLASS_PREFIX = 'ACF_Formatter_Input_';

    private function __construct()
    {
    }

    public static function getInstance()
    {
        static $inst = null;
        if ($inst === null) {
            $inst = new self();
        }
        return $inst;
    }

    public function getFieldsFormattedFromObjectId($objectId)
    {
        $formattedFields = array();
        $fields = get_field_objects($objectId);
        if (empty($fields)) {
            return $formattedFields;
        }

        return $this->formatFields($fields);
    }

    private function formatFields(array $fields)
    {
        $formattedFields = array();
        foreach ($fields as $field) {
            $formattedFields += $this->formatField($field);
        }

        return $formattedFields;
    }

    private function formatField(array $field)
    {
        try {
            $formattedField = $this->formatFieldByType($field);
        } catch (ACF_Formatter_Field_Not_Implemented_Exception $exception) {
            $formattedField[$field['name']] = $exception->getMessage();
        }

        return $formattedField;
    }


    private function formatFieldByType(array $field)
    {
        $formatter_class = sprintf('%s%s', self::FORMATTERS_CLASS_PREFIX, ucfirst($field['type']));
        if (!class_exists($formatter_class)) {
            throw new ACF_Formatter_Field_Not_Implemented_Exception($field['type']);
        }


    }

}