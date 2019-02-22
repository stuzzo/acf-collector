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

use function json_encode;
use stdClass;

/**
 * Class ObjectFormatter
 * @package ACFCollector\Formatter\Output
 * @since 1.0.0
 */
class ObjectFormatter implements OutputFormatterInterface
{
    /**
     * ObjectFormatter constructor
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
     * @return \stdClass()
     */
    public function formatReturnValue($field)
    {
        if (empty($field['value'])) {
            return new \stdClass();
        }

        return $field['value'];
    }
}