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
 * Class that formats taxonomy field
 *
 * @since      1.0.0
 */
class TaxonomyFormatter extends BaseFormatter
{
    /**
     * TaxonomyFormatter constructor.
     *
     * @since 1.0.0
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
     * Verify if the current field has the return format key and modify the output formatter
     *
     * @param $field
     *
     * @since 1.0.0
     */
    protected function setOutputFormatterByField($field)
    {
        $value = $field['value'];
        if (is_int($value)) {
            $this->defaultOutputFormatterType = self::INTEGER_OUTPUT_FORMATTER_TYPE;
        }
    }
}