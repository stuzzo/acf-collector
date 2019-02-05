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

interface FormatterInterface
{
    /**
     * @param array $field
     * @param bool $isOutputFiltered
     *
     * @return array
     */
    public function format($field, $isOutputFiltered);
}
