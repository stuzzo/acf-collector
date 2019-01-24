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
        $this->returnKeys = array(
            'return_format',
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