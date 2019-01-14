<?php

class ACF_Formatter_Field_Not_Implemented_Exception extends RuntimeException
{
    public function __construct($fieldType, $code = 0, \Throwable $previous = null)
    {
        $fullMessage = sprintf('Formatter for field type %s non implemented', $fieldType);
        parent::__construct($fullMessage, $code, $previous);
    }
}
