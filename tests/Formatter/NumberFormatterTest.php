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

use ACFCollector\Formatter\NumberFormatter;
use ACFCollector\Tests\ACFCollectorTestCase;
use function array_values;
use function file_get_contents;
use function json_decode;
use function reset;
use function sprintf;

class NumberFormatterTest extends ACFCollectorTestCase
{
    private function getField(): array
    {
        $jsonFile = sprintf('%s/NumberField.json', $this->jsonDir);
        $jsonContent = file_get_contents($jsonFile);

        return json_decode($jsonContent, true);
    }

    public function testReturnValue(): void
    {
        $formatter = NumberFormatter::getInstance();
        $field = $this->getField();
        $fieldFormatted = $formatter->format($field, true);

        $this->assertIsArray($fieldFormatted);
        $this->assertNotEmpty($fieldFormatted);
        $number = array_values($fieldFormatted);
        $this->assertIsInt(reset($number));
    }
}