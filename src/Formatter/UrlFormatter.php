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
 * Class that formats url field
 *
 * @since      1.0.0
 */
class UrlFormatter extends BaseFormatter
{
    /**
     * TextareaFormatter constructor.
     *
     * @since 1.0.0
     */
    private function __construct()
    {
        $this->defaultOutputFormatterType = self::STRING_OUTPUT_FORMATTER_TYPE;
        $this->returnKeys = array(
            'default_value',
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