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

/**
 * Class that formats image field
 *
 * @since      1.0.0
 */
class ImageFormatter extends BaseFormatter
{
    /**
     * ImageFormatter constructor.
     */
    private function __construct()
    {
        $this->defaultOutputFormatterType = self::ARRAY_OUTPUT_FORMATTER_TYPE;
    }

    /**
     * @return \ACFCollector\Formatter\FormatterInterface
     *
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
            if ('array' === $field['return_format']) {
                $returnValue = $field['value']['url'];
            } else {
                $returnValue = $field['value'];
            }
        } else {
            $returnValue = $field;
        }

        return array($field['name'] => $returnValue);
    }

}