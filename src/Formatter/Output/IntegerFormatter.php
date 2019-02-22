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
 * Class IntegerFormatter
 * @package ACFCollector\Formatter\Output
 * @since 1.0.0
 */
class IntegerFormatter implements OutputFormatterInterface
{

    /**
     * IntegerFormatter constructor
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
     * @return int
     */
    public function formatReturnValue($field)
    {
        if (empty($field['value'])) {
            return 0;
        }

        return (int) $field['value'];
    }
}