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
use ACFCollector\Handler\TemplateHandler;
use ACFCollector\Tests\ACFCollectorTestCase;
use function Brain\Monkey\Functions\stubs;
use function has_filter;
use stdClass;

class TemplateHandlerTest extends ACFCollectorTestCase
{
    public function testAddAction(): void
    {
        $pluginLoader = $this->getPluginLoader();
        $templateHandler = new TemplateHandler($pluginLoader, ACFHandler::getInstance());
        $templateHandler->init();
        $pluginLoader->run();

        self::assertTrue(has_filter('template_redirect', [$templateHandler, 'addFieldsToCurrentPost']));
        self::assertTrue(has_filter('template_redirect', [$templateHandler, 'addFieldsToCurrentTaxonomy']));
    }

    public function testAddFieldsToCurrentPost(): void
    {
        $pluginLoader = $this->getPluginLoader();
        $templateHandler = new TemplateHandler($pluginLoader, ACFHandler::getInstance());
        global $post;
        $post = new stdClass();
        $templateHandler->addFieldsToCurrentPost();

        $this->assertObjectHasAttribute(self::ACF_COLLECTOR_FIELD_NAME, $post);
    }

    public function testAddFieldsToCurrentTaxonomy(): void
    {
        $pluginLoader = $this->getPluginLoader();
        $templateHandler = new TemplateHandler($pluginLoader, ACFHandler::getInstance());
        global $wp_query;
        $wp_query = new stdClass();
        $wp_query->queried_object = new stdClass();
        stubs(['get_queried_object'], $wp_query->queried_object);
        $templateHandler->addFieldsToCurrentTaxonomy();

        $this->assertObjectHasAttribute(self::ACF_COLLECTOR_FIELD_NAME, $wp_query->queried_object);
    }

}