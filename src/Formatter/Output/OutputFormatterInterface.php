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
 * Interface OutputFormatterInterface
 * @package ACFCollector\Formatter
 * @since 1.0.0
 */
interface OutputFormatterInterface
{
    /**
     * @param array $field
     *
     * @return array
     */
    public function formatReturnValue($field);
}
