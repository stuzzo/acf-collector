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

use ACFCollector\Formatter\ButtonGroupFormatter;
use ACFCollector\Tests\ACFCollectorTestCase;
use function file_get_contents;
use function json_decode;
use function sprintf;

class ButtonGroupFormatterTest extends ACFCollectorTestCase
{
    private function getField(): array
    {
        $jsonFile = sprintf('%s/ButtonGroupField.json', $this->jsonDir);
        $jsonContent = file_get_contents($jsonFile);

        return json_decode($jsonContent, true);
    }

    public function testReturnValue(): void
    {
        $formatter = ButtonGroupFormatter::getInstance();
        $field = $this->getField();
        $fieldFormatted = $formatter->format($field, true);

        $this->assertIsArray($fieldFormatted);
        $this->assertNotEmpty($fieldFormatted);
        $buttons = array_values($fieldFormatted);
        $this->assertIsArray($buttons);
    }
}