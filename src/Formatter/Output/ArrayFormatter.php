<?php

/*
 * This file is part of the ACF Collector plugin.
 *
 * (c) Alfredo Aiello <stuzzo@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ACFCollector\Formatter\Output;

/**
 * Class ArrayFormatter
 * @package ACFCollector\Formatter\Output
 * @since 1.0.0
 */
class ArrayFormatter implements OutputFormatterInterface
{
    /**
     * ArrayFormatter constructor
     * @since 1.0.0
     */
    private function __construct() {}

    /**
     * @return \ACFCollector\Formatter\Output\OutputFormatterInterface
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
     * @param array $field
     *
     * @return array
     */
    public function formatReturnValue($field)
    {
        if (empty($field['value'])) {
            return array();
        }

        return $field['value'];
    }
}