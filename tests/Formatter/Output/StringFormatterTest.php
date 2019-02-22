<?php

/*
 * This file is part of the ACF Collector plugin.
 *
 * (c) Alfredo Aiello <stuzzo@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace ACFFormatter\Tests\Formatter\Output;

use ACFCollector\Formatter\Output\StringFormatter;
use ACFCollector\Tests\ACFCollectorTestCase;

class StringFormatterTest extends ACFCollectorTestCase
{
    public function testReturnValue(): void
    {
        $formatter = StringFormatter::getInstance();
        $fieldFormattedValue = $formatter->formatReturnValue([]);

        $this->assertIsString($fieldFormattedValue);
    }
}