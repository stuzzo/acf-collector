<?php

class ACF_Formatter_Input_Text
{

    public static function getInstance()
    {
        static $inst = null;
        if ($inst === null) {
            $inst = new self();
        }
        return $inst;
    }

    public function format(array $field)
    {
        return $this->outputFormatter->formatReturnValue($field);
    }
}