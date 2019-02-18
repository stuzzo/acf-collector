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

use function array_merge;
use phpDocumentor\Reflection\Types\Parent_;

/**
 * Class that formats text field
 *
 * @since      1.0.0
 */
class TextFormatter extends BaseFormatter
{
    /**
     * TextareaFormatter constructor.
     *
     * @since 1.0.0
     */
    private function __construct()
    {
        $this->defaultOutputFormatterType = self::STRING_OUTPUT_FORMATTER_TYPE;
        $this->returnKeys = array();
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