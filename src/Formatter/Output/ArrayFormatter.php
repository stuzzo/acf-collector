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

class ArrayFormatter implements OutputFormatterInterface
{

    private function __construct() {}

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
            return array('value' => []);
        }

        return array('value' => $field['value']);
    }
}