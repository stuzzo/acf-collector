<?php

namespace ACFFormatter\Tests\Handler;

use ACFCollector\Handler\ACFHandler;
use ACFCollector\Tests\ACFCollectorTestCase;

class ACFHandlerTest extends ACFCollectorTestCase
{
    public function testIfLoadDomainIsCalled(): void
    {
        $ACFHandler = ACFHandler::getInstance();
        $returnFields = $ACFHandler->getFieldsFormattedFromObjectId(34234324323432);

        $this->assertIsArray($returnFields);

    }

}