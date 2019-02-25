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

namespace ACFFormatter\Tests\Formatter;

use ACFCollector\Formatter\RepeaterFormatter;
use ACFCollector\Tests\ACFCollectorTestCase;
use function file_get_contents;
use function json_decode;
use function sprintf;

class RepeaterFormatterTest extends ACFCollectorTestCase
{
    private function getField(): array
    {
        $jsonFile = sprintf('%s/RepeaterField.json', $this->jsonDir);
        $jsonContent = file_get_contents($jsonFile);

        return json_decode($jsonContent, true);
    }

    public function testReturnValue(): void
    {
        $formatter = RepeaterFormatter::getInstance();
        $field = $this->getField();
        $fieldFormatted = $formatter->format($field, true);

        $this->assertIsArray($fieldFormatted);
        $this->assertNotEmpty($fieldFormatted);
        $repeater = array_values($fieldFormatted);
        $this->assertIsArray(reset($repeater));
    }
}