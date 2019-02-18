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

use ACFCollector\Formatter\Output\ObjectFormatter;
use ACFCollector\Tests\ACFCollectorTestCase;

class ObjectFormatterTest extends ACFCollectorTestCase
{
    public function testReturnValue(): void
    {
        $formatter = ObjectFormatter::getInstance();
        $fieldsFormatted = $formatter->formatReturnValue([]);

        $this->assertIsArray($fieldsFormatted);
        $this->assertArrayHasKey('value', $fieldsFormatted);
        $this->assertIsArray($fieldsFormatted['value']);
    }
}