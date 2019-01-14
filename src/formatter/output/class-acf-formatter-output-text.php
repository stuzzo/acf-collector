<?php

class Acf_Output_Text
{
    public static function formatReturnValue($field)
    {
        $key = $field['name'];
        if (empty($field) || null === $field['value']) {
            return array($key => '');
        }

        return array($key => (string)$field['value']);
    }
}