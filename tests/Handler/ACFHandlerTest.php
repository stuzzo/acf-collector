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

namespace ACFFormatter\Tests\Handler;

use ACFCollector\Handler\ACFHandler;
use ACFCollector\Tests\ACFCollectorTestCase;

class ACFHandlerTest extends ACFCollectorTestCase
{
    public function testIfArrayIsReturnedWithARandomID(): void
    {
        $ACFHandler = ACFHandler::getInstance();
        $returnFields = $ACFHandler->getFieldsFormattedFromObjectID($this->getRandomInt());

        $this->assertIsArray($returnFields);
    }

    public function testIfArrayIsReturnedWithARandomTermIDAndRandomTaxonomy(): void
    {
        $ACFHandler = ACFHandler::getInstance();
        $returnFields = $ACFHandler->getFieldsFormattedFromTerm($this->getRandomInt(), $this->getRandomString());

        $this->assertIsArray($returnFields);
    }

    public function testIfArrayIsReturnedWithARandomCommentID(): void
    {
        $ACFHandler = ACFHandler::getInstance();
        $returnFields = $ACFHandler->getFieldsFormattedFromCommentID($this->getRandomInt());

        $this->assertIsArray($returnFields);
    }

}