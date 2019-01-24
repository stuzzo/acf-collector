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

use ACFCollector\Formatter\FileFormatter;
use ACFCollector\Tests\ACFCollectorTestCase;
use function file_get_contents;
use function json_decode;
use function sprintf;

class FileFormatterTest extends ACFCollectorTestCase
{
    private function getField(): array
    {
        $jsonFile = sprintf('%s/FileField.json', $this->jsonDir);
        $jsonContent = file_get_contents($jsonFile);

        return json_decode($jsonContent, true);
    }

    public function testReturnValue(): void
    {
        $formatter = FileFormatter::getInstance();
        $field = $this->getField();
        $fieldsFormatted = $formatter->format($field);

        $this->assertIsArray($fieldsFormatted);
        $this->assertArrayHasKey('label', $fieldsFormatted[$field['name']]);
        $this->assertArrayHasKey('value', $fieldsFormatted[$field['name']]);
        $this->assertArrayHasKey('type', $fieldsFormatted[$field['name']]);
        $this->assertArrayHasKey('return_format', $fieldsFormatted[$field['name']]);
    }
}