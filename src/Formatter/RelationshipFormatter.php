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
 * Class that formats relationship field
 *
 * @since      1.0.0
 */
class RelationshipFormatter extends BaseFormatter
{
    /**
     * RelationshipFormatter constructor.
     *
     * @since 1.0.0
     */
    private function __construct()
    {
        $this->defaultOutputFormatterType = self::OBJECT_OUTPUT_FORMATTER_TYPE;
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
}