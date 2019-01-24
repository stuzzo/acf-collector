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

use ACFCollector\Formatter\Output\ArrayFormatter;
use ACFCollector\Tests\ACFCollectorTestCase;

class ArrayFormatterTest extends ACFCollectorTestCase
{
    public function testReturnValue(): void
    {
        $formatter = ArrayFormatter::getInstance();
        $fieldsFormatted = $formatter->formatReturnValue([]);

        $this->assertIsArray($fieldsFormatted);
        $this->assertArrayHasKey('value', $fieldsFormatted);
        $this->assertIsArray($fieldsFormatted['value']);
    }
}