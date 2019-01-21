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
use ACFCollector\Handler\RestAPIHandler;
use ACFCollector\Tests\ACFCollectorTestCase;
use function has_action;

class RestAPIHandlerTest extends ACFCollectorTestCase
{
    public function testAddAction(): void
    {
        $pluginLoader = $this->getPluginLoader();
        $restAPIHandler = new RestAPIHandler($pluginLoader, ACFHandler::getInstance());
        $restAPIHandler->init();
        $pluginLoader->run();

        self::assertTrue(has_action('rest_api_init', [$restAPIHandler, 'setupRestFields']));
    }

    public function testGetObjectCustomFields(): void
    {
        $pluginLoader = $this->getPluginLoader();
        $restAPIHandler = new RestAPIHandler($pluginLoader, ACFHandler::getInstance());
        $object['id'] = $this->getRandomInt();
        $fields = $restAPIHandler->getObjectCustomFields($object);

        $this->assertIsArray($fields);
    }

    public function testGetTermCustomFields(): void
    {
        $pluginLoader = $this->getPluginLoader();
        $restAPIHandler = new RestAPIHandler($pluginLoader, ACFHandler::getInstance());
        $object['id'] = $this->getRandomInt();
        $object['taxonomy'] = $this->getRandomString();
        $fields = $restAPIHandler->getTermCustomFields($object);

        $this->assertIsArray($fields);
    }

}