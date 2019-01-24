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
 * Class that formats number field
 *
 * @since      1.0.0
 */
class NumberFormatter extends BaseFormatter
{
    /**
     * NumberFormatter constructor.
     */
    private function __construct()
    {
        $this->defaultOutputFormatterType = self::INTEGER_OUTPUT_FORMATTER_TYPE;
        $this->returnKeys = array(
            'default_value',
            'min',
            'max',
            'placeholder',
        );
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
            $inst->init();
        }

        return $inst;
    }

}